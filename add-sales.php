<?php
session_start();
require_once 'includes/dbc.inc.php';

$stmt = $pdo->query("SELECT * FROM customers;");
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt2 = $pdo->query("SELECT * FROM products;");
$products = $stmt2->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['checkout'])) {
    $_SESSION = [];
    session_destroy();
    header("Location: sales.php");
    exit;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_name'])) {
    $customer_name = $_POST['customer_name'];
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $date_time = $_POST['date_time'];


    if (!isset($_SESSION['locked'])) {
        $_SESSION['locked'] = $customer_name;
    }

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $stmt3 = $pdo->prepare("SELECT product_price FROM products WHERE product_name = :product_name");
    $stmt3->execute(['product_name' => $product_name]);
    $product = $stmt3->fetch(PDO::FETCH_ASSOC);

    $total = $product['product_price'] * $quantity;

    $_SESSION['cart'][] = [
        'customer_name' => $_SESSION['locked'],
        'product_name' => $product_name,
        'quantity' => $quantity,
        'total' => $total,
        'date_time' => $date_time
    ];
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
            <table border="1">
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
                            <td><?= (new DateTime($item['date_time']))->format('Y-m-d H:i:s') ?>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>
            <button type="submit" name="checkout">Checkout</button>

            <!-- <?php
                    // echo '<pre>';
                    // print_r($_SESSION);
                    // echo '</pre>';
                    ?> -->
        </form>


    </center>
</body>

</html>