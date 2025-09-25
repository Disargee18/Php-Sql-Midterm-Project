<?php 
    $host = 'localhost';
    $name = 'pos';
    $user = 'root';
    $pass = '';

    try{
        $pdo = new PDO("mysql:host=$host;dbname=$name",$user,$pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        die("Connection Failed: ">$e->getMessage());
    }
?>  