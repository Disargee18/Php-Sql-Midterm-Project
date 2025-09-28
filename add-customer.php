<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <center>
        <h1>Add Customer</h1>
        <br>
        <form action="includes/customer-crud.php" method="post">
            <input type="hidden" name="action" value="create">
            <label for="customer_name"><b>Name:</b></label>
            <input type="text" name="customer_name" id="customer_name" required><br><br>
            <label for="customer_email"><b>Email:</b></label>
            <input type="email" name="customer_email" id="customer_email" required><br><br>
            <label for="customer_phone"><b>Phone:</b></label>
            <input type="number" inputmode="numeric" name="customer_phone" id="customer_phone" required><br><br>
            <button type="submit">Add Customer</button>
        </form>
    </center>
</body>
</html>