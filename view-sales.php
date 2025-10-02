<?php
require_once 'includes/dbc.inc.php';

if (isset($_GET['action']) && $_GET['action'] == 'view' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT total_amount, sale_date, customer_name, product_name, sale_item_id, quantity_sold, price_at_sale 
                                FROM sales_items INNER JOIN products ON sales_items.product_id = products.product_id
                                INNER JOIN sales ON sales_items.sale_id = sales.sale_id
                                INNER JOIN customers ON sales.customer_id = customers.customer_id
                                WHERE sales.sale_id = :id;");
    $stmt->execute([':id' => $id]);
    $view = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
$grandtotal=0;
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
        <?php if(!empty($view)):?>
            <h1><?= "Sales #" . $id ?></h1>

            <h2><?= "Customer: " . $view[0]['customer_name'] ?></h2>
            <h4>Sale Date: <?= $view[0]['sale_date'] ?></h4>
            <h4>Total Amount: <?= $view[0]['total_amount'] ?></h4>

            <table border="1" cellpadding="8">
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price at Sale</th>
                    <th>Subtotal</th>
                </tr>
                <?php foreach ($view as $item): ?>
                    <tr>
                        <td><?= $item['product_name'] ?></td>
                        <td><?= $item['quantity_sold'] ?></td>
                        <td><?= $item['price_at_sale'] ?></td>
                        <td><?= number_format($item['quantity_sold'] * $item['price_at_sale'], 2) ?></td>
                        <?php number_format($grandtotal += $item['quantity_sold'] * $item['price_at_sale'],2);?>

                    </tr>
                <?php endforeach ?>
                <tr>
                    <th colspan="3">Grand Total:</th>
                    <th><?=number_format($grandtotal,2)?></th>
                </tr>
            </table>
        <?php else: ?>
            <p>No sale found for this ID.</p>
        <?php endif; ?>
    </center>
</body>

</html>