<?php 
    require_once 'includes/dbc.inc.php';

    if(isset($_GET['action'])&& $_GET['action']=='search')
    {
        $search = $_GET['search'];
        $stmt = $pdo->prepare("SELECT * FROM products WHERE product_name LIKE :search OR product_price LIKE :search OR product_quantity LIKE :search;");
        $stmt->execute([':search' => "%$search%"]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }else{
        $stmt = $pdo->query("SELECT * FROM products;");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <h1>Products List</h1>
        <form action="" method="get">
            <input type="hidden" name="action" value="search">
            <input type="text" placeholder="Search Product" name="search"><button type="submit">Submit</button>
        </form>
        <br><br>
        <a href="add-product.php">Add Product</a>
        <br><br>
        <form action="" method="get">
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
                <?php foreach($products as $product) : ?>
                    <tr>
                        <td><?=$product['product_id']?></td>
                        <td><?=$product['product_name']?></td>
                        <td><?= "₱".$product['product_price']?></td>
                        <td><?=$product['product_quantity']?></td>
                        <td><a href="edit-product.php?action=edit&id=<?=$product['product_id']?>">Edit</a> | <a href="includes/product-crud.php?action=delete&id=<?=$product['product_id']?>">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </form>
    </center>
</body>
</html>