<?php
session_start();

if (isset($_POST['confirm-delete-account'])) {

    require '../../includes/dbh.inc.php';
  
    $uid = $_SESSION['userId'];
  
    $password = $_POST['passsword'];
  
    $sql = "SELECT * FROM users WHERE idUsers = $uid;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
  
    $pwdCheck = password_verify($password, $row['pwd']);
  
    if ($pwdCheck == false) {
      header("Location: ../delacc.php?e=pwr");
      exit();
    }else {
  
      $sql = "DELETE FROM users WHERE idUsers=$uid;";
      $result = $conn->query($sql);
      mysqli_query($conn, $sql);
  
  
      $sql2 = "DELETE FROM socials WHERE idUsers=$uid;";
      $result2 = $conn->query($sql2);
      mysqli_query($conn, $sql2);
  
  
      $sql3 = "DELETE FROM rankuser WHERE idUser=$uid;";
      $result3 = $conn->query($sql3);
      mysqli_query($conn, $sql3);

      $sql4 = "DELETE FROM userteam WHERE idUser=$uid;";
      $result4 = $conn->query($sql4);
      mysqli_query($conn, $sql4);

      $sql5 = "DELETE FROM riot WHERE idUser=$uid;";
      $result5 = $conn->query($sql5);
      mysqli_query($conn, $sql5);
  

      echo "<script>window.parent.location.href= '../../index.php'</script>";

      session_unset();
      session_destroy();
      exit();
    }
  
  }
  
  if (isset($_POST['cancel-delete-account'])) {
    header("Location: ../delacc.php");
    exit();
  }