<?php
session_start();
require_once 'includes/dbc.inc.php';

$stmt = $pdo->query("SELECT * FROM customers;");
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt2 = $pdo->query("SELECT * FROM products;");
$products = $stmt2->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['cancel'])) {
    unset($_SESSION['cart']);
    unset($_SESSION['locked']);
    session_destroy();
    header("Location: add-sales.php");
    exit;
}


if (isset($_POST['checkout'])) {
    $stmt4 = $pdo->prepare("SELECT customer_id FROM customers WHERE customer_name = :customer_name");
    $stmt4->execute(['customer_name' => $_SESSION['locked']]);
    $customer = $stmt4->fetch(PDO::FETCH_ASSOC);

    $_SESSION['customer_id'] = $customer['customer_id'];
    $customer_id = $customer['customer_id'];
    $date_time = date('Y-m-d H:i:s');
    $total_amount = $_SESSION['grandtotal'];

    $stmt5 = $pdo->prepare("INSERT INTO sales (customer_id, sale_date, total_amount) VALUES (:customer_id, :sale_date, :total_amount)");
    $stmt5->execute([
        ':customer_id' => $customer_id,
        ':sale_date' => $date_time,
        ':total_amount' => $total_amount
    ]);

    $sale_id = $pdo->lastInsertId();

    foreach ($_SESSION['cart'] as $item) {
        $stmt6 = $pdo->prepare("INSERT INTO sales_items (sale_id, product_id, quantity_sold, price_at_sale) VALUES (:sale_id, :product_id, :quantity_sold, :price_at_sale)");
        $stmt6->execute([
            ':sale_id' => $sale_id,
            ':product_id' => $item['product_id'],
            ':quantity_sold' => $item['quantity'],
            ':price_at_sale' => $item['price_at_sale'],
        ]);

        $stmt7 = $pdo->prepare("UPDATE products SET product_quantity = product_quantity - :quantity_sold WHERE product_id = :product_id");
        $stmt7->execute([
            ':quantity_sold' => $item['quantity'],
            ':product_id' => $item['product_id']
        ]);
    }


    $_SESSION = [];
    session_destroy();
    header("Location: sales.php");
    exit;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_name'])) {
    $customer_name = $_POST['customer_name'];
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $date_time = $_POST['date_time'];
    $grandtotal = 0;


    if (!isset($_SESSION['locked'])) {
        $_SESSION['locked'] = $customer_name;
    }

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $stmt3 = $pdo->prepare("SELECT product_price, product_quantity, product_id FROM products WHERE product_name = :product_name");
    $stmt3->execute(['product_name' => $product_name]);
    $product = $stmt3->fetch(PDO::FETCH_ASSOC);

    $_SESSION['product_price'] = $product['product_price'];
    $total = $product['product_price'] * $quantity;

    $quantitystock = 0;
    foreach ($_SESSION['cart'] as $item) {
        if ($item['product_id'] == $product['product_id']) {
            $quantitystock += $item['quantity'];
        }
    }

    $quantitystock+=$quantity;



    if ($quantitystock > $product['product_quantity']) {
        echo "<script>alert('No enough stock available.');</script>";
    } else {

        $_SESSION['cart'][] = [
            'customer_name' => $_SESSION['locked'],
            'product_name' => $product_name,
            'product_id' => $product['product_id'],
            'quantity' => $quantity,
            'total' => $total,
            'date_time' => $date_time,
            'price_at_sale' => $product['product_price'],

        ];
    }
    foreach ($_SESSION['cart'] as $index => $item) {
        $grandtotal += $item['total'];
        $_SESSION['grandtotal'] = $grandtotal;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay'])) {
    if (isset($_POST['payment'])) {
        $payment = $_POST['payment'];
    } else {
        $payment = 0;
    }


    if ($payment < $_SESSION['grandtotal']) {
        echo "<script>alert('Not enough payment. Please enter an amount equal to or greater than the total.');</script>";
    } else {
        $_SESSION['payment'] = $payment;
        $_SESSION['change'] = $payment - $_SESSION['grandtotal'];
        $_SESSION['payment_valid'] = true;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $delete_index = $_POST['delete'];

    if (isset($_SESSION['cart'][$delete_index])) {
        unset($_SESSION['cart'][$delete_index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }

    $grandtotal = 0;
    foreach ($_SESSION['cart'] as $item) {
        $grandtotal += $item['total'];
    }
    $_SESSION['grandtotal'] = $grandtotal;

    header("Location: add-sales.php");
    exit;
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <center>
        <a href="customers.php">Customer's Page</a> |
        <a href="products.php">Product's Page</a> |
        <a href="sales.php">Sale's Page</a>
        <br><br>
        <h1>Add Sales</h1>
        <form action="" method="post">
            <label for="customer_name">Customer:</label>
            <select name="customer_name" id="customer_name"
                <?= isset($_SESSION['locked']) ? 'disabled' : '' ?>>
                <?php foreach ($customers as $customer): ?>
                    <option value="<?= $customer['customer_name'] ?>"
                        <?= (isset($_SESSION['locked']) && $_SESSION['locked'] === $customer['customer_name']) ? 'selected' : '' ?>>
                        <?= $customer['customer_name'] ?>
                    </option>
                <?php endforeach; ?>
                <?php if (isset($_SESSION['locked'])): ?>
                    <input type="hidden" name="customer_name" value="<?= $_SESSION['locked'] ?>">
                <?php endif; ?>
            </select><br><br>
            <label for="product_name">Product</label>
            <select name="product_name" id="product_name">
                <?php foreach ($products as $product) : ?>
                    <option value="<?= $product['product_name'] ?>"><?= $product['product_name'] ?></option>
                <?php endforeach ?>
            </select><br><br>
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" min="1" required><br><br>
            <input type="hidden" name="date_time" value="<?= date('Y-m-d H:i:s') ?>">
            <button type="submit">Add To Cart</button><br><br>




            <h2>Cart</h2>
        </form>
        <form action="" method="post">
            <table border="1" cellpadding="8">
                <tr>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>

                <?php if (!empty($_SESSION['cart'])): ?>
                    <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                        <tr>
                            <td><?= $item['customer_name'] ?></td>
                            <td><?= $item['product_name'] ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= $item['total'] ?></td>
                            <td><button type="submit" name="delete" value="<?= $index ?>" onclick="return confirm('Are you sure you want to remove <?= $item['product_name'] ?> from the cart?');">Delete</button></td>

                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                <tr>
                    <th colspan="4">Grand Total:</th>
                    <td><?= isset($_SESSION['grandtotal']) ? $_SESSION['grandtotal'] : '0' ?></td>
                </tr>
            </table>
            <br>
            <input type="hidden" name="accept_payment">
            <label for="payment">Payment: </label>
            <input type="number" inputmode="numeric" name="payment">
            <button type="submit" name="pay" <?= empty($_SESSION['cart']) ? 'disabled' : '' ?>>Submit</button>
            <?php if (isset($_SESSION['change'])): ?>
                <h3><b>Change: </b><b><?= $_SESSION['change'] ?></b></h3>
            <?php endif; ?>

            <br><br>
            <button type="submit" name="cancel">Cancel Checkout</button>
            <button type="submit" name="checkout"
                <?= (empty($_SESSION['cart']) || empty($_SESSION['payment_valid'])) ? 'disabled' : '' ?>>
                Checkout
            </button>



        </form>


    </center>
</body>

</html>