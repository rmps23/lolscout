<?php
  session_start();

if (isset($_POST['confirm-info'])) {

  require 'dbh.inc.php';

  $info = $_POST['userinfo'];
  $uid = $_SESSION['userId'];


  if (empty($info)) {
    header("Location: ../settings.php?e=emptyfield");
    exit();
  }else if (!preg_match("/^[a-zA-Z0-9_ -]*$/", $tag)) {
      header("Location: ../settings.php?e=invalidtag");
      exit();

    }else {
          $sql = "UPDATE users SET info='$info' WHERE idUsers='$uid';";
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
