<?php

session_start();
require_once('DBconnect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_REQUEST['email'];
    $password = $_REQUEST['pass'];
    $roleName = $_REQUEST['role'];

    try {
        createUser($email, $password, $roleName);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

function createUser($email, $password, $roleName) {

    // Check if the role exists
    require ('DBconnect.php');
    $query="SELECT Id FROM roles WHERE role_name = '$roleName'";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $role = $stmt->fetch();
    $role_id= $role['Id'];


    if (!$role) {
        throw new Exception("Role not found.");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $insert="INSERT INTO users (email, pass, role_id) VALUES ('$email', '$hashedPassword', '$role_id')";
    $stmt = $con->prepare($insert);
    $stmt->execute();

    echo "User created successfully.";
}