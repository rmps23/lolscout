<?php
  session_start();

if (isset($_POST['confirm-email'])) {
  require '../../includes/dbh.inc.php';


  $email = $_POST['email-uid'];
  $uid = $_SESSION['userId'];

  if (empty($email)){
    header("Location: ../accset.php?e=emptyfields");
    exit();
  }else {

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      header("Location: ../accset.php?e=invalidemail");
      exit();

    }else {
      $sql = "SELECT * FROM users WHERE email='$email';";

      if($result = mysqli_query($conn, $sql)){
        if(mysqli_num_rows($result) > 0){
          header("Location: ../accset.php?e=emailtaken");
          exit();
        }else {
            $sql = "UPDATE users SET email='$email' WHERE idUsers='$uid';";
            $result = $conn->query($sql);

            if (mysqli_query($conn, $sql)) {
              header("Location: ../accset.php?i=success");
              exit();
            } else {
              echo "Error updating record: " . mysqli_error($conn);
            }
          }
        }
    }
  }





$conn->close();
}
 ?>
