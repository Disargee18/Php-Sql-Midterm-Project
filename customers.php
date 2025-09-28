<?php 
    require_once 'includes/dbc.inc.php';

    if(isset($_GET['action'])&&$_GET['action']=='search'){
        $search = $_GET['search'];
        $stmt = $pdo->prepare("SELECT * FROM customers WHERE customer_name LIKE :search OR customer_email LIKE :search OR customer_phone LIKE :search;");
        $stmt->execute([':search' => "%$search%"]);
        $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } else  {
    $stmt = $pdo->query("SELECT * FROM customers;");
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <h1>Customer List</h1>
        <form action="" method="get">
            <input type="hidden" name="action" value="search">
            <input type="text" placeholder="Search Customer" name="search"><button type="submit">Submit</button>
        </form>
        <br><br>
        <a href="add-customer.php">Add Customer</a>
        <br><br>
        <form action="" method="get">
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
                <?php foreach($customers as $customer) : ?>
                    <tr>
                        <td><?=$customer['customer_id']?></td>
                        <td><?=$customer['customer_name']?></td>
                        <td><?=$customer['customer_email']?></td>
                        <td><?=$customer['customer_phone']?></td>
                        <td><a href="edit-customer.php?action=edit&id=<?=$customer['customer_id']?>">Edit</a> | <a href="includes/customer-crud.php?action=delete&id=<?=$customer['customer_id']?>">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </form>
    </center>
</body>
</html>