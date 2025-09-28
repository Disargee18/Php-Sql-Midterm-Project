<?php 
    require_once 'dbc.inc.php';

    $action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];

    if($action == 'create')
    {

        $customer_name = $_POST['customer_name'];
        $customer_email = $_POST['customer_email'];  
        $customer_phone = $_POST['customer_phone'];

        $stmt = $pdo->prepare("INSERT INTO customers (customer_name, customer_email, customer_phone) VALUES (:customer_name, :customer_email, :customer_phone);");
        $stmt->execute([
            ':customer_name' => $customer_name,
            ':customer_email' => $customer_email,
            ':customer_phone' => $customer_phone
        ]);
        header("Location: ../customers.php");
        exit; 
    }


    if($action == 'edit')
    {
        $customer_name = $_POST['customer_name'];
        $customer_email = $_POST['customer_email'];
        $customer_phone = $_POST['customer_phone'];
        $id = $_POST['id'];

        $stmt = $pdo->prepare("UPDATE customers SET customer_name = :customer_name, customer_email = :customer_email, customer_phone = :customer_phone WHERE customer_id = :id;");
        $stmt->execute([
            ':customer_name' => $customer_name,
            ':customer_email' => $customer_email,
            ':customer_phone' => $customer_phone,
            ':id' => $id
        ]);
        header("Location: ../customers.php");
        exit;
    }



    if($action == 'delete')
    {
        $id = $_GET['id'];

        $stmt = $pdo->prepare("DELETE FROM customers WHERE customer_id = :id;");
        $stmt->execute([
            ':id'=>$id
        ]);
        header("Location: ../customers.php");
        exit;
    }
?>