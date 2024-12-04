<?php
session_start();

require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

//CONSTANTS that we need for jwt verificaton
$secret = bin2hex(random_bytes(32));
define('JWT_SECRET', $secret);
const JWT_ISSUER = '127.0.0.1:81';
const JWT_EXPIRATION = 3600;

//verification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = ($_REQUEST['email']);
    $password = $_REQUEST['pass'];

    require 'DBconnect.php';

    // Fetch user by email
    $stmt = "SELECT * FROM users WHERE email = '$email'";
    $state= $con->prepare($stmt);
    $state->execute();
    $flag= $state->rowCount();

    if ($flag > 0) {
        $user = $state->fetch();

        //check if user is Admin
        if ($user['role_id'] === 1) {

            //check password
            if ($user && password_verify($password, $user['pass'])) {

                // Password is correct
                $issuedAt = time();
                $expirationTime = $issuedAt + JWT_EXPIRATION; // Token valid for 1 hour
                $payload = [
                    'iss' => JWT_ISSUER,
                    'iat' => $issuedAt,
                    'exp' => $expirationTime,
                    'sub' => $user['Id'] // User ID
                ];

                $jwt = JWT::encode($payload, JWT_SECRET, 'HS256');

                echo json_encode([
                    'message' => 'Welcome, Admin! You can manage users.',
                    'token' => $jwt
                ]);
            } else {
                http_response_code(401);
                echo json_encode(['message' => 'Invalid email or password.']);
            }
        }
        else
        {
            echo json_encode(['message' => 'You have not permission to run this action. Call the system manager.']);
        }
    }
    else
    {
        echo json_encode(['message' => 'User not found']);
    }
}
