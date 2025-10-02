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
        <h1>Add Product</h1>
        <br>
        <form action="includes/product-crud.php" method="post">
            <input type="hidden" name="action" value="create">
            <label for="product_name"><b>Name:</b></label>
            <input type="text" name="product_name" id="product_name" required><br><br>
            <label for="product_price"><b>Price:</b></label>
            <input type="price" name="product_price" id="product_price" required><br><br>
            <label for="product_price"><b>Quantity:</b></label>
            <input type="number " name="product_quantity" id="product_quantity" required><br><br>
            <button type="submit">Add Product</button>
        </form>
    </center>
</body>
</html>