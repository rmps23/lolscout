<?php
  require '../../includes/dbh.inc.php';

  $email = $_SESSION['email'];
  $pw = $_SESSION['pw'];
  $nation = $_SESSION['nation'];
  $role = $_SESSION['role'];
  $sumname = $_SESSION['sumname'];
  $lastUP = (strtotime("now"));

  $icon = $_GET['ic'];
  $idRiot = $_GET['idr'];

  $hashedPwd = password_hash($pw, PASSWORD_DEFAULT);

  $sql = "INSERT INTO users (email, pwd, idRole, idNation) VALUES (?, ?, ?, ?)";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {

    header("Location: ../index.php?e=sqlerror");
    exit();

  }else {

    mysqli_stmt_bind_param($stmt, "ssss", $email, $hashedPwd, $role, $nation);
    mysqli_stmt_execute($stmt);

    $uid = mysqli_insert_id($conn);

    $sql = "INSERT INTO socials (idUsers) VALUES ('$uid')";

    if ($conn->query($sql) === TRUE) {

      $sql2 = "INSERT INTO riot (idUser, idAcc, opgg, profileImg, lastupdate) VALUES ('$uid', '$idRiot', '$sumname', '$icon', '$lastUP')";

      if ($conn->query($sql2) === TRUE) {

        $sql3 = "INSERT INTO userteam (idUser) VALUES ('$uid')";

        if ($conn->query($sql3) === TRUE) {
        
          $sql4 = "INSERT INTO rankuser (idUser) VALUES ('$uid')";

          if ($conn->query($sql4) === TRUE) {
        
            header("Location: ../../settings.php?signup3=success");

          } else {

          echo "Error: " . $sql . "<br>" . $conn->error;
        
          }

        } else {

        echo "Error: " . $sql . "<br>" . $conn->error;
        
        }

        header("Location: ../../settings.php?signup2=success");

      } else {

      echo "Error: " . $sql . "<br>" . $conn->error;
      
      }

      header("Location: ../../settings.php?signup1=success");
      
    } else {

      echo "Error: " . $sql . "<br>" . $conn->error;
      
    }

    session_start();
    $_SESSION['userId'] = $uid;

    header("Location: ../../settings.php?signup=success");
    exit();
  }
         

  mysqli_stmt_close($stmt);
  mysqli_close($conn);

// }else {
//   header("Location: ../../index.php");
//   exit();
// }
