<?php 
    require_once 'includes/dbc.inc.php';

    $stmt = $pdo->query("SELECT * FROM sales;");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <h1>Sales List</h1>
        <form action="" method="get">
            <input type="hidden" name="action" value="search">
            <input type="text" placeholder="Search Sales" name="search"><button type="submit">Submit</button>
        </form>
        <br><br>
        <a href="add-sales.php">Add Sales</a>
        <br><br>
        <form action="" method="get">
            <table border="1">
                <tr>
                    <th>Sale ID</th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                <?php foreach($products as $product) : ?>
                    <tr>
                        <td><?=$sale['sales_id']?></td>
                        <td><?=$customer['customer_name']?></td>
                        <td><?=$product['product_name']?></td>
                        <td><?=$sales_items['quantity_sold']?></td>
                        <td><?=$sale['sale_date']?></td>
                        <td><a href="edit-sales.php?action=edit&id=<?=$product['product_id']?>">Edit</a> | <a href="includes/sales-crud.php?action=delete&id=<?=$product['product_id']?>">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </form>
    </center>
</body>
</html>