<?php
  session_start();

if (isset($_POST['confirm-ct'])) {
  require 'dbh.inc.php';

  $uid = $_SESSION['userId'];
  $teamtag = $_POST['teamtag-uid'];
  $teamname = $_POST['teamname-uid'];
  $nationID = $_POST['nation'];

  strtoupper($teamtag);

  if (empty($teamtag) || empty($teamname)) {
    header("Location: ../teams.php?e=emptyfields");
    exit();
  }else if (!preg_match("/^[a-zA-Z0-9_ -]*$/", $teamtag) || !preg_match("/^[a-zA-Z0-9_ -]*$/", $teamname)) {
    header("Location: ../teams.php?e=invalidchar");
    exit();
  }else {

    $invCode = uniqid(16);

    $sql = "INSERT INTO teams (idUsers, TeamTag, TeamName, SearchPlayers, TeamLogo, inviteCode, nation) VALUES ('$uid', UPPER('$teamtag'), '$teamname', '0', 'default-team.png', '$invCode', '$nationID')";

    if ($conn->query($sql) === TRUE) {

      $teamid = mysqli_insert_id($conn);

      $sql1 = "INSERT INTO tsocial (idTeam) VALUES ('$teamid')";

      if ($conn->query($sql1) === TRUE) {
        header("Location: ../teams.php?i=success");
      } else {
        echo "Error: " . $sql1 . "<br>" . $conn->error;
      }

    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }


  }


$conn->close();
}
 ?>
