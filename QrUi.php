<?php
include_once "connection.php";

//  $dt  =  $_GET['id'];
// if (isset($_GET['id'])) {
//     $dt = $_GET['id'];
//     echo $dt;
// }

if(isset($_GET['qr'])){
// $dt = mysql_real_escape_string( $_GET['id']);
// //   $data = json_decode(file_get_contents("php://input"),true);

// //   Remove the reference to itself from the data object.
// //   $data = json_decode(json_encode($data), true);

$dt = $_GET['qr'];

//   $sql = "insert into `qrcode` (`qrData`) values ('$dt')";
  $sql = "insert into `qrcode` (`qrData`) values ('$dt')";


  if(mysqli_query($conn,$sql)){
    $message = "OK";
    echo json_encode(array("message"=>$message));
  }else{
    $message = "error";
    echo json_encode(array("message"=>$message));
  }
}
?>
