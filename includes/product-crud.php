<?php 
    require_once 'dbc.inc.php';

    $action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];

    if($action == 'create'){

        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];  
        $product_quantity = $_POST['product_quantity'];

        $stmt = $pdo->prepare("INSERT INTO products (product_name, product_price, product_quantity) VALUES (:product_name, :product_price, :product_quantity);");
        $stmt->execute([
            ':product_name' => $product_name,
            ':product_price' => $product_price,
            ':product_quantity' => $product_quantity
        ]);
        header("Location: ../products.php");
        exit; 
    }

    if($action == 'edit')
    {
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_quantity = $_POST['product_quantity'];
        $id = $_POST['id'];

        $stmt = $pdo->prepare("UPDATE products SET product_name = :product_name, product_price = :product_price, product_quantity = :product_quantity WHERE product_id = :id;");
        $stmt->execute([
            ':product_name' => $product_name,
            ':product_price' => $product_price,
            ':product_quantity' => $product_quantity,
            ':id' => $id
        ]);
        header("Location: ../products.php");
        exit;
    }



    if($action == 'delete')
    {
        $id = $_GET['id'];

        $stmt = $pdo->prepare("DELETE FROM products WHERE product_id = :id;");
        $stmt->execute([
            ':id'=>$id
        ]);
        header("Location: ../products.php");
        exit;
    }
?>