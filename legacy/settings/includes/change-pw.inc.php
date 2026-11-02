<?php
session_start();

if (isset($_POST['confirm-change-pw'])) {

  require '../../includes/dbh.inc.php';

  $pw = $_POST['password'];
  $pw2 = $_POST['password-cf'];
  $uid = $_SESSION['userId'];

  if (empty($pw) || empty($pw2)) {

    header("Location: ../accset.php?e=emptyfield");
    exit();

  }else if ($pw !== $pw2) {

      header("Location: ../accset.php?e=passwordcheck");
      exit();

    }else {

      $hashedPwd = password_hash($pw, PASSWORD_DEFAULT);

      $sql = "UPDATE users SET pwd='$hashedPwd' WHERE idUsers='$uid';";
      $result = $conn->query($sql);
      if (mysqli_query($conn, $sql)) {

        header("Location: ../accset.php?i=success");
        exit();

      } else {

        echo "Error updating record: " . mysqli_error($conn);

      }
  }

  $conn->close();

}

?>