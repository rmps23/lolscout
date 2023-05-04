<?php
session_start();

if (isset($_POST['confirm-leave-team'])) {
    require '../../includes/dbh.inc.php';
  
    $uid = $_SESSION['userId'];
  
  
    $sql = "UPDATE userteam SET idTeam = '0' WHERE idUser = $uid;";
    $result = $conn->query($sql);
  
    if (mysqli_query($conn, $sql)) {
      header("Location: ../lolset.php?i=success");
      exit();
    } else {
      echo "Error updating record: " . mysqli_error($conn);
    }
  
}