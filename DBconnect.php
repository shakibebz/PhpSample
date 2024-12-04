<?php
$DATABASE_SERVER_IP = "localhost";
$DATABASE_USER_NAME = "root";
$DATABASE_USER_PASSWORD="";
$DATABASE_NAME="test";
try {
    $con = new PDO(
        "mysql:host=$DATABASE_SERVER_IP;
         dbname=$DATABASE_NAME",
        $DATABASE_USER_NAME,
        $DATABASE_USER_PASSWORD
    );
    // set the PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>