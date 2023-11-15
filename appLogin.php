<?php
include_once "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    // Sanitize and escape the data
    $email = mysqli_real_escape_string($conn, $data['email']);
    $password = mysqli_real_escape_string($conn, $data['password']);

    // Check if the user exists
    $sql = "SELECT * FROM `users` WHERE `email` = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // User exists, so check the password
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            // Password is correct, so log the user in
            $token = bin2hex(openssl_random_pseudo_bytes(16));

            $sql = "UPDATE `users` SET `token` = '$token' WHERE `email` = '$email'";
            mysqli_query($conn, $sql);

            echo json_encode(['message' => 'Login successful', 'token' => $token]);
        } else {
            echo json_encode(['message' => 'Incorrect password']);
        }
    } else {
        echo json_encode(['message' => 'User does not exist']);
    }
}
