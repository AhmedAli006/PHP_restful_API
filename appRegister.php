<?php
// include_once "connection.php";

// if($_SERVER['REQUEST_METHOD']==='POST'){
//   $data = json_decode(file_get_contents("php://input"),true);

//   // Remove the reference to itself from the data object.
// //   $data = json_decode(json_encode($data), true);

//   $name = $data["name"];
//   $email = $data["email"];
//   $password = $data["password"];

//   $sql = "insert into `users` (`name`, `email`,`password`) values ('$name','$email','$password')";

//   if(mysqli_query($conn,$sql)){
//     $message = "OK";
//     echo json_encode(array("message"=>$message));
//   }else{
//     $message = "error";
//     echo json_encode(array("message"=>$message));
//   }
// }


include_once "connection.php";
include_once "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    // Initialize an empty array to store validation errors
    $errors = [];

    // Validate the data
    if (empty($data['name'])) {
        $errors['name'] = 'Please enter your name';
    }

    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address';
    }

    if (strlen($data['password']) < 8) {
        $errors['password'] = 'Your password must be at least 8 characters long';
    }

    if (count($errors) > 0) {
        echo json_encode(['errors' => $errors]);
        exit;
    }

    // Sanitize and escape the data
    $name = mysqli_real_escape_string($conn, $data['name']);
    $email = mysqli_real_escape_string($conn, $data['email']);
    $password = mysqli_real_escape_string($conn, $data['password']);

    // Check if the email already exists

    
$sql = "SELECT * FROM `users` WHERE `email` = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo json_encode(['message' => 'Email already exists']);
        exit;
    }

    // Hash the password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the user into the database
    $sql = "INSERT INTO `users` (`name`, `email`, `password`) VALUES ('$name', '$email', '$password')";

    if (mysqli_query($conn, $sql)) {
        $message = "User registered successfully";
        echo json_encode(['message' => $message]);
    } else {
        $message = "An error occurred while registering the user";
        echo json_encode(['message' => $message]);
    }
}


?>
