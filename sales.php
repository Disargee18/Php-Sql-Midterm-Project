<?php
require_once 'includes/dbc.inc.php';



if (isset($_GET['action']) && $_GET['action'] == 'search') {
    $search = $_GET['search'];
    $stmt = $pdo->prepare("SELECT sale_id, sale_date, total_amount, customer_name FROM sales 
                        INNER JOIN customers ON sales.customer_id = customers.customer_id WHERE customer_name LIKE :search");
    $stmt->execute([':search' => "%$search%"]);
    $sales = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $stmt = $pdo->query("SELECT sale_id, sale_date, total_amount, customer_name
                        FROM sales
                        INNER JOIN customers ON sales.customer_id = customers.customer_id;");
    $sales = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <h1>Sales List</h1>
        <form action="" method="get">
            <input type="hidden" name="action" value="search">
            <input type="text" placeholder="Search Sales" name="search"><button type="submit">Submit</button>
        </form>
        <br><br>
        <a href="add-sales.php">Add Sales</a>
        <br><br>
        <form action="" method="get">
            <table border="1" cellpadding="8">
                <tr>
                    <th>Sale ID</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($sales as $sale) : ?>
                    <tr>
                        <td><?= $sale['sale_id'] ?></td>
                        <td><?= $sale['customer_name'] ?></td>
                        <td><?= $sale['sale_date'] ?></td>
                        <td><?= "₱".$sale['total_amount'] ?></td>
                        <td><a href="view-sales.php?action=view&id=<?= $sale['sale_id'] ?>">View</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </form>
    </center>
</body>

</html>