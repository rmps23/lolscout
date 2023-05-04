<?php
require 'includes/dbh.inc.php';

$email = $_POST['email'];

$code = rand(10000000, 99999999);


$sql = "SELECT * FROM users WHERE email = '$email';";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$rowcount = mysqli_num_rows($result);


if ($rowcount > 0) {

  $sql = "SELECT * FROM pwdreset WHERE email = '$email';";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $rowcount2 = mysqli_num_rows($result);

  if ($rowcount2 > 0) {

    $sql = "UPDATE pwdreset SET code='$code' WHERE email='$email';";

    if ($conn->query($sql) === TRUE) {
      header("Location: send-email.php?c=$code&e=$email");
      exit();
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

  }else {

    $sql = "INSERT INTO pwdreset (email, code) VALUES ('$email', '$code')";

    if ($conn->query($sql) === TRUE) {
      header("Location: send-email.php?c=$code&e=$email");
      exit();
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

  }

}else {
  header("Location: login.php?e=noemail");
  exit();
}
