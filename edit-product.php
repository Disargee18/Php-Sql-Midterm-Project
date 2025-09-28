<?php
    require_once 'includes/dbc.inc.php';

    if(isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])){
        $id = $_GET['id'];
        $stmt = $pdo->prepare("SELECT * FROM products WHERE product_id = :id;");
        $stmt->execute([':id' => $id]);
        $products = $stmt->fetch(PDO::FETCH_ASSOC);
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
        <h1>Edit Product</h1>
        <br>
        <form action="includes/product-crud.php" method="post">
            <input type="hidden" name="action" value="edit">
            <label for="product_name"><b>Name:</b></label>
            <input type="text" name="product_name" id="product_name" required value="<?=$products['product_name']?>"><br><br>
            <label for="product_price"><b>Price:</b></label>
            <input type="price" name="product_price" id="product_price" required value="<?=$products['product_price']?>"><br><br>
            <label for="product_quantity"><b>Quantity:</b></label>
            <input type="number" name="product_quantity" id="product_quantity" required value="<?=$products['product_quantity']?>"><br><br>   
            <input type="hidden" name="id" value="<?=$products['product_id']?>">
            <button type="submit">Edit product</button>
        </form>
    </center>
</body>
</html>