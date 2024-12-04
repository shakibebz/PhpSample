<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
function authenticate() {
    $headers = getallheaders();
    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        die(json_encode(['message' => 'Authorization header missing.']));
    }

    $authHeader = $headers['Authorization'];
    $token = str_replace('Bearer ', '', $authHeader);

    try {
        $decoded = JWT::decode($token, new Key(JWT_SECRET, 'HS256'));

        // Optional: Add user info to global or session for further use
        return $decoded->sub; // Return user ID from the token payload
    } catch (Exception $e) {
        http_response_code(401);
        die(json_encode(['message' => 'Invalid token.']));
    }
}
