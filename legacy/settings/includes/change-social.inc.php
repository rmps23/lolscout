<?php
  session_start();

/*---------------CONFIRM PROFILE SOCIAL-----------------*/

if (isset($_POST['confirm-facebook'])) {
  require '../../includes/dbh.inc.php';

  $facebook = $_POST['facebook-id'];
  $uid = $_SESSION['userId'];

  if (empty($facebook)) {
    header("Location: ../socset.php?e=emptyfields");
    exit();
  }else if (strpos($facebook, "facebook.com/") === false) {
    header("Location: ../socset.php?e=invalidlink");
    exit();
  }else {
    $sql = "UPDATE socials SET facebook='$facebook' WHERE idUsers='$uid';";
    $result = $conn->query($sql);

  if (mysqli_query($conn, $sql)) {
    header("Location: ../socset.php?i=success");
    exit();
  } else {
    echo "Error updating record: " . mysqli_error($conn);
  }
  }
}

if (isset($_POST['confirm-instagram'])) {
  require '../../includes/dbh.inc.php';

  $instagram = $_POST['instagram-id'];
  $uid = $_SESSION['userId'];

  if (empty($instagram)) {
    header("Location: ../socset.php?e=emptyfield");
    exit();
  }else if (strpos($instagram, "instagram.com/") === false) {
    header("Location: ../socset.php?e=invalidlink");
    exit();
  }else {
    $sql = "UPDATE socials SET instagram='$instagram' WHERE idUsers='$uid';";
    $result = $conn->query($sql);

  if (mysqli_query($conn, $sql)) {
    header("Location: ../socset.php?i=success");
    exit();
  } else {
    echo "Error updating record: " . mysqli_error($conn);
  }
  }
}

if (isset($_POST['confirm-twitter'])) {
  require '../../includes/dbh.inc.php';

  $twitter = $_POST['twitter-id'];
  $uid = $_SESSION['userId'];

  if (empty($twitter)) {
    header("Location: ../socset.php?e=emptyfield");
    exit();
  }else if (strpos($twitter, "twitter.com/") === false) {
    header("Location: ../socset.php?e=invalidlink");
    exit();
  }else {
    $sql = "UPDATE socials SET twitter='$twitter' WHERE idUsers='$uid';";
    $result = $conn->query($sql);

  if (mysqli_query($conn, $sql)) {
    header("Location: ../socset.php?i=success");
    exit();
  } else {
    echo "Error updating record: " . mysqli_error($conn);
  }
  }
}

if (isset($_POST['confirm-twitch'])) {
  require '../../includes/dbh.inc.php';

  $twitch = $_POST['twitch-id'];
  $uid = $_SESSION['userId'];

  if (empty($twitch)) {
    header("Location: ../socset.php?e=emptyfield");
    exit();
  }else if (strpos($twitch, "twitch.tv/") === false) {
    header("Location: ../socset.php?e=invalidlink");
    exit();
  }else {
    $sql = "UPDATE socials SET twitch='$twitch' WHERE idUsers='$uid';";
    $result = $conn->query($sql);

  if (mysqli_query($conn, $sql)) {
    header("Location: ../socset.php?i=success");
    exit();
  } else {
    echo "Error updating record: " . mysqli_error($conn);
  }
  }
}

if (isset($_POST['confirm-youtube'])) {
  require '../../includes/dbh.inc.php';

  $youtube = $_POST['youtube-id'];
  $uid = $_SESSION['userId'];

  if (empty($youtube)) {
    header("Location: ../socset.php?e=emptyfield");
    exit();
  }else if (strpos($youtube, "youtube.com/channel/") === false) {
    header("Location: ../socset.php?e=invalidlink");
    exit();
  }else {
    $sql = "UPDATE socials SET youtube='$youtube' WHERE idUsers='$uid';";
    $result = $conn->query($sql);

  if (mysqli_query($conn, $sql)) {
    header("Location: ../socset.php?i=success");
    exit();
  } else {
    echo "Error updating record: " . mysqli_error($conn);
  }
  }
}


/*---------------CONFIRM REMOVE PROFILE SOCIAL-----------------*/

if (isset($_POST['confirm-remove-facebook'])) {

  require '../../includes/dbh.inc.php';

        $uid = $_SESSION['userId'];

        $sql = "UPDATE socials SET facebook='0' WHERE idUsers='$uid';";
        $result = $conn->query($sql);

          if (mysqli_query($conn, $sql)) {
            header("Location: ../socset.php?i=success");
            exit();
          } else {
            echo "Error updating record: " . mysqli_error($conn);
          }
}

if (isset($_POST['confirm-remove-instagram'])) {

  require '../../includes/dbh.inc.php';

        $uid = $_SESSION['userId'];

        $sql = "UPDATE socials SET instagram='0' WHERE idUsers='$uid';";
        $result = $conn->query($sql);

        if (mysqli_query($conn, $sql)) {
          header("Location: ../socset.php?i=success");
          exit();
        } else {
          echo "Error updating record: " . mysqli_error($conn);
        }
}

if (isset($_POST['confirm-remove-twitter'])) {

  require '../../includes/dbh.inc.php';

        $uid = $_SESSION['userId'];

        $sql = "UPDATE socials SET twitter='0' WHERE idUsers='$uid';";
        $result = $conn->query($sql);

        if (mysqli_query($conn, $sql)) {
          header("Location: ../socset.php?i=success");
          exit();
        } else {
          echo "Error updating record: " . mysqli_error($conn);
        }
}

if (isset($_POST['confirm-remove-twitch'])) {

  require '../../includes/dbh.inc.php';

        $uid = $_SESSION['userId'];

        $sql = "UPDATE socials SET twitch='0' WHERE idUsers='$uid';";
        $result = $conn->query($sql);

        if (mysqli_query($conn, $sql)) {
          header("Location: ../socset.php?i=success");
          exit();
        } else {
          echo "Error updating record: " . mysqli_error($conn);
        }
}

if (isset($_POST['confirm-remove-youtube'])) {

  require '../../includes/dbh.inc.php';

        $uid = $_SESSION['userId'];

        $sql = "UPDATE socials SET youtube='0' WHERE idUsers='$uid';";
        $result = $conn->query($sql);

        if (mysqli_query($conn, $sql)) {
          header("Location: ../socset.php?i=success");
          exit();
        } else {
          echo "Error updating record: " . mysqli_error($conn);
        }
}



/*-------------CANCEL REMOVE SOCIAL-----------------*/

if (isset($_POST['cancel-remove-social'])) {
  header("Location: ../socset.php");
  exit();
}

if (isset($_POST['cancel-remove-t-social'])) {
  if (isset($_GET['id'])) {
    $idTeam = $_GET['id'];
  }
  header("Location: ../socset.php?id=$idTeam&i=success");
  exit();
}


/*-----------------------END-----------------------*/


$conn->close();

 ?>
