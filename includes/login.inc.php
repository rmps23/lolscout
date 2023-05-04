<?php
if (isset($_POST['login-submit'])){

  require 'dbh.inc.php';

  $email = $_POST['email-uid'];
  $password = $_POST['password-uid'];

  if (empty($email) || empty($password)) {
    header("Location: ../login.php?e=emptyfields");
    exit();
  }
  else {
    $sql = "SELECT * FROM users WHERE email=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../login.php?e=sqlerror");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt, "s", $email);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($row = mysqli_fetch_assoc($result)) {
        $pwdCheck = password_verify($password, $row['pwd']);
        if ($pwdCheck == false) {
          header("Location: ../login.php?e=wrongpwd");
          exit();
        }
        else if ($pwdCheck == true) {
          session_start();
          $idU = $row['idUsers'];
          $_SESSION['userId'] = $row['idUsers'];
          $_SESSION['userUsn'] = $row['username'];

          header("Location: ../profile.php?login=success&id=$idU");
          exit();
        }
        else {
          header("Location: ../login.php?e=wrongpwd");
          exit();
        }
      }
      else {
        header("Location: ../login.php?e=noemail");
        exit();
      }
    }
  }

}
else {
  header("Location: ../index.php");
  exit();
}
