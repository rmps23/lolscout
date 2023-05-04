<?php
session_start();

if (isset($_POST['confirm-role'])) {
  require '../../includes/dbh.inc.php';

  $role = $_POST['roles'];
  $uid = $_SESSION['userId'];

    $sql = "UPDATE users SET idRole='$role' WHERE idUsers='$uid';";
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
