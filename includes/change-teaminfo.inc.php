<?php
  session_start();

/*---------------CONFIRM TEAM SOCIAL-----------------*/

if (isset($_POST['confirm-teamname'])) {
  require 'dbh.inc.php';

  $teamname = $_POST['t-teamname'];
  $uid = $_SESSION['userId'];

  if (isset($_GET['id'])) {
    $idTeam = $_GET['id'];
  }


  if (empty($teamname)) {
    header("Location: ../editteam.php?id=$idTeam&e=emptyfield");
    exit();
  }else if (!preg_match("/^[a-zA-Z0-9_ -]*$/", $teamname)) {
      header("Location: ../editteam.php?id=$idTeam&e=invalidteamname");
      exit();

    }else {
          $sql = "UPDATE teams SET TeamName='$teamname' WHERE idTeam='$idTeam';";
          $result = $conn->query($sql);

          if (mysqli_query($conn, $sql)) {
            header("Location: ../editteam.php?id=$idTeam&i=success");
            exit();
          } else {
            echo "Error updating record: " . mysqli_error($conn);
          }

        }
}

if (isset($_POST['confirm-tag'])) {
  require 'dbh.inc.php';

  $tag = $_POST['t-tag'];
  $uid = $_SESSION['userId'];

  if (isset($_GET['id'])) {
    $idTeam = $_GET['id'];
  }


  if (empty($tag)) {
    header("Location: ../profile.php?id=$idTeam&e=emptyfield");
    exit();
  }else if (!preg_match("/^[a-zA-Z0-9_ -]*$/", $tag)) {
      header("Location: ../profile.php?id=$idTeam&e=invalidtag");
      exit();

    }else {
          $sql = "UPDATE teams SET TeamTag='$tag' WHERE idTeam='$idTeam';";
          $result = $conn->query($sql);

          if (mysqli_query($conn, $sql)) {
            header("Location: ../editteam.php?id=$idTeam&i=success");
            exit();
          } else {
            echo "Error updating record: " . mysqli_error($conn);
          }

        }
}

if (isset($_POST['confirm-t-info'])) {
  require 'dbh.inc.php';

  $tinfo = $_POST['t-info'];
  $uid = $_SESSION['userId'];

  if (isset($_GET['id'])) {
    $idTeam = $_GET['id'];
  }


  if (empty($tinfo)) {
    header("Location: ../editteam.php?id=$idTeam&e=emptyfield");
    exit();
  }else if (!preg_match("/^[a-zA-Z0-9_ -]*$/", $tag)) {
      header("Location: ../editteam.php?id=$idTeam&e=invalidtinfo");
      exit();

    }else {
          $sql = "UPDATE teams SET TeamInfo='$tinfo' WHERE idTeam='$idTeam';";
          $result = $conn->query($sql);

          if (mysqli_query($conn, $sql)) {
            header("Location: ../editteam.php?id=$idTeam&i=success");
            exit();
          } else {
            echo "Error updating record: " . mysqli_error($conn);
          }

        }
}

if (isset($_POST['confirm-delete-team'])) {
  require 'dbh.inc.php';

  $teamname = $_POST['teamname'];
  $uid = $_SESSION['userId'];

  if (isset($_GET['id'])) {
    $idTeam = $_GET['id'];
  }

  $sql = "SELECT * FROM teams WHERE idTeam = $idTeam;";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);

  $tnDB = $row['TeamName'];

  if (empty($teamname)) {
    header("Location: ../editteam.php?id=$idTeam&e=emptyfield");
    exit();
  }else if ($teamname != $tnDB){
      header("Location: ../editteam.php?id=$idTeam&e=invalidconfirm");
      exit();

  }else {
          $sql = "DELETE FROM teams WHERE idTeam='$idTeam';";
          $result = $conn->query($sql);

          if (mysqli_query($conn, $sql)) {
            header("Location: ../teams.php");
            exit();
          } else {
            echo "Error updating record: " . mysqli_error($conn);
          }

    }
}

/*---------------CONFIRM TEAM SOCIAL-----------------*/

if (isset($_POST['switchLFT'])) {
  require 'dbh.inc.php';

  $uid = $_SESSION['userId'];

  if (isset($_GET['id'])) {
    $idTeam = $_GET['id'];
  }

  $sql = "SELECT * FROM teams WHERE idTeam = $idTeam;";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);

  $searchPlayers = $row['SearchPlayers'];

  if ($searchPlayers == "0") {
    $searchPlayers = "1";
  }else {
    $searchPlayers = "0";
  }

  $sql = "UPDATE teams SET SearchPlayers='$searchPlayers' WHERE idTeam='$idTeam';";
  $result = $conn->query($sql);

  if (mysqli_query($conn, $sql)) {
    header("Location: ../editteam.php?id=$idTeam&i=success");
    exit();
  } else {
    echo "Error updating record: " . mysqli_error($conn);
  }


}




if (isset($_POST['confirm-lfp'])) {
  require 'dbh.inc.php';

  if (isset($_GET['id'])) {
    $idTeam = $_GET['id'];
  }

  $sql = "UPDATE teams SET SearchPlayers= '1' WHERE idTeam='$idTeam';";
  $result = $conn->query($sql);

  if (mysqli_query($conn, $sql)) {
    header("Location: ../editteam.php?id=$idTeam&i=success");
    exit();
  } else {
    echo "Error updating record: " . mysqli_error($conn);
  }

}


if (isset($_POST['confirm-lfp2'])) {
  require 'dbh.inc.php';

  if (isset($_GET['id'])) {
    $idTeam = $_GET['id'];
  }

  $sql = "UPDATE teams SET SearchPlayers= '0' WHERE idTeam='$idTeam';";
  $result = $conn->query($sql);

  if (mysqli_query($conn, $sql)) {
    header("Location: ../editteam.php?id=$idTeam&i=success");
    exit();
  } else {
    echo "Error updating record: " . mysqli_error($conn);
  }

}



if (isset($_POST['confirm-kickp'])) {
  require 'dbh.inc.php';

  if (isset($_GET['id'])) {
    $idPlayer = $_GET['id'];
  }

  if (isset($_GET['idt'])) {
    $idTeam = $_GET['idt'];
  }

  $sql = "UPDATE users SET idTeam = '0' WHERE idUsers='$idPlayer';";
  $result = $conn->query($sql);

  if (mysqli_query($conn, $sql)) {
    header("Location: ../editteam.php?id=$idTeam&i=success");
    exit();
  } else {
    echo "Error updating record: " . mysqli_error($conn);
  }

}


if (isset($_POST['confirm-delete'])) {
  require 'dbh.inc.php';

  if (isset($_GET['id'])) {
    $idTeam = $_GET['id'];
  }

  $sql1 = "SELECT * FROM users WHERE idTeam = $idTeam;";
  $result1 = mysqli_query($conn, $sql1);
  $row1 = mysqli_fetch_assoc($result1);



  if($result1 = mysqli_query($conn, $sql1)){
    if(mysqli_num_rows($result1) > 0){
    while($row1 = mysqli_fetch_array($result1)){

      $idU = $row1['idUsers'];

      $sql2 = "UPDATE users SET idTeam = '0' WHERE idUsers=$idU;";
      $result2 = $conn->query($sql2);



      if (mysqli_query($conn, $sql2)) {
        header("Location: ../teams.php");
        exit();
      } else {
        echo "Error updating record: " . mysqli_error($conn);
      }

    }
    $sql3 = "DELETE FROM teams WHERE idTeam = $idTeam;";
    $result3 = $conn->query($sql3);

    if (mysqli_query($conn, $sql3)) {
      header("Location: ../teams.php?i=success");
      exit();
    } else {
      echo "Error updating record: " . mysqli_error($conn);
    }
  }else {
    $sql3 = "DELETE FROM teams WHERE idTeam = $idTeam;";
    $result3 = $conn->query($sql3);

    if (mysqli_query($conn, $sql3)) {
      header("Location: ../teams.php");
      exit();
    } else {
      echo "Error updating record: " . mysqli_error($conn);
    }
  }
  }


}



$conn->close();

 ?>
