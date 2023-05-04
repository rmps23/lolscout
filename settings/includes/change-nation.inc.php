<?php
session_start();

if (isset($_POST['confirm-nation'])) {
  require '../../includes/dbh.inc.php';

  $nationID = $_POST['nation'];
  $uid = $_SESSION['userId'];



        $sql = "UPDATE users SET idNation='$nationID' WHERE idUsers='$uid';";
        $result = $conn->query($sql);

          if (mysqli_query($conn, $sql)) {
            header("Location: ../lolset.php?i=success");
            exit();
          } else {
            echo "Error updating record: " . mysqli_error($conn);
          }

}

$conn->close();

 ?>
