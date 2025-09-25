<?php 
    require_once 'includes/dbc.inc.php';

    $stmt = $pdo->query("SELECT * FROM customers;");
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <h1>Customer List</h1>
        <input type="text" placeholder="Search Customer"><button>Submit</button>
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