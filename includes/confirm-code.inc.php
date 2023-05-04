<?php
if (isset($_POST['confirm-code'])) {

require 'dbh.inc.php';

$code = $_POST['code'];
$email = $_POST['email'];

$sql = "SELECT * FROM pwdreset WHERE email = '$email';";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$rowcount = mysqli_num_rows($result);

$codedb = $row['code'];

if ($code == $codedb) {
  header("Location: changepwr.inc.php?email=$email");
  exit();
}else {
  header("Location: ../confirm-code.php?e=$email&error=invalidcode");
  exit();
}

$conn->close();
}


?>
