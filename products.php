<?php 
    require_once 'includes/dbc.inc.php';

    $stmt = $pdo->query("SELECT * FROM products;");
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
        <h1>Products List</h1>
        <input type="text" placeholder="Search Product"><button>Submit</button>
        <br><br>
        <a href="add-product.php">Add Product</a>
        <br><br>
        <form action="" method="get">
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Product Quantity</th>
                    <th>Action</th>
                </tr>
                <?php foreach($products as $product) : ?>
                    <tr>
                        <td><?=$product['product_id']?></td>
                        <td><?=$product['product_name']?></td>
                        <td><?=$product['product_price']?></td>
                        <td><?=$product['product_quantity']?></td>
                        <td><a href="edit-product.php?action=edit&id=<?=$product['product_id']?>">Edit</a> | <a href="includes/product-crud.php?action=delete&id=<?=$product['product_id']?>">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </form>
    </center>
</body>
</html>