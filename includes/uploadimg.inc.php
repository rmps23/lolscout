<?php

session_start();


if (isset($_POST['submit-team-img'])) {

  require 'dbh.inc.php';

  $uid = $_SESSION['userId'];
  $file = $_FILES['file'];

  $fileName = $_FILES['file']['name'];
  $fileTmpName = $_FILES['file']['tmp_name'];
  $fileSize = $_FILES['file']['size'];
  $fileError = $_FILES['file']['error'];
  $fileType = $_FILES['file']['type'];
  $idTeam = $_POST['idTeam'];

  $fileExt = explode('.', $fileName);
  $fileActualExt = strtolower(end($fileExt));

  $allowed = array('jpg', 'jpeg', 'png', 'pdf');

  if (in_array($fileActualExt, $allowed)) {
    if ($fileError === 0) {
      if ($fileSize < 1000000) {

        $sql = "SELECT * FROM teams WHERE idUsers = $uid AND idTeam = $idTeam;";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $teamimg = $row['TeamLogo'];

        if ($teamimg !== "default-team.png") {
          $filedel="../teams-images/".$teamimg;
          unlink($filedel);

          $fileNameNew = uniqid('', true).".".$fileActualExt;
          $fileDestination = '../teams-images/'.$fileNameNew;
          move_uploaded_file($fileTmpName, $fileDestination);

          $sql = "UPDATE teams SET TeamLogo='$fileNameNew' WHERE idUsers='$uid' AND idTeam = $idTeam;";
          $result = $conn->query($sql);

          if (mysqli_query($conn, $sql)) {
            header("Location: ../editteam.php?id=$idTeam&i=success");
            exit();

          } else {
            echo "Error updating record: " . mysqli_error($conn);
          }

        }else {
          $fileNameNew = uniqid('', true).".".$fileActualExt;
          $fileDestination = '../teams-images/'.$fileNameNew;
          move_uploaded_file($fileTmpName, $fileDestination);

          $sql = "UPDATE teams SET TeamLogo='$fileNameNew' WHERE idUsers='$uid' AND idTeam = $idTeam;";
          $result = $conn->query($sql);

          if (mysqli_query($conn, $sql)) {
            header("Location: ../editteam.php?id=$idTeam&i=success");
            exit();

          } else {
            echo "Error updating record: " . mysqli_error($conn);
          }
        }

      }else {
        echo "Your file is too big!";
        header("Location: ../editteam.php?id=$idTeam&e=filebig");
        exit();
      }
    }else {
      header("Location: ../editteam.php?id=$idTeam&e=invfile");
      exit();
    }
  }else {
    header("Location: ../editteam.php?id=$idTeam&e=invfile");
    exit();
  }
}
