<?php
  session_start();

if (isset($_POST['confirm-username'])) {
  require 'dbh.inc.php';


  $username = $_POST['username-uid'];
  $uid = $_SESSION['userId'];

  $usernameUP = strtoupper($username);

  if (empty($username)) {
    header("Location: ../settings.php?e=emptyfield");
    exit();
  }else if (!preg_match("/^[a-zA-Z0-9_ -]*$/", $username)) {
      header("Location: ../settings.php?e=invalidusn");
      exit();

    }else if ($usernameUP == "ADMIN") {
      header("Location: ../settings.php?e=invalidusn");
      exit();
    }else {
          $sql = "UPDATE users SET username='$username' WHERE idUsers='$uid';";
          $result = $conn->query($sql);

          if (mysqli_query($conn, $sql)) {
            header("Location: ../settings.php?i=success");
            exit();
          } else {
            echo "Error updating record: " . mysqli_error($conn);
          }
    }
}


$conn->close();

 ?>
