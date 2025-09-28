<?php
    require_once 'includes/dbc.inc.php';

    if(isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])){
        $id = $_GET['id'];
        $stmt = $pdo->prepare("SELECT * FROM customers WHERE customer_id = :id;");
        $stmt->execute([':id' => $id]);
        $customers = $stmt->fetch(PDO::FETCH_ASSOC);
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
        <h1>Edit Customer</h1>
        <br>
        <form action="includes/customer-crud.php" method="post">
            <input type="hidden" name="action" value="edit">
            <label for="customer_name"><b>Name:</b></label>
            <input type="text" name="customer_name" id="customer_name" required value="<?=$customers['customer_name']?>"><br><br>
            <label for="customer_email"><b>Email:</b></label>
            <input type="email" name="customer_email" id="customer_email" required value="<?=$customers['customer_email']?>"><br><br>
            <label for="customer_phone"><b>Phone:</b></label>
            <input type="number " name="customer_phone" id="customer_phone" required value="<?=$customers['customer_phone']?>"><br><br> 
            <input type="hidden" name="id" value="<?=$customers['customer_id']?>">  
            <button type="submit">Edit Customer</button>
        </form>
    </center>
</body>
</html>