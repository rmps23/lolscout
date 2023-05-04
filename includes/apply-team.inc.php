<?php
  session_start();

if (isset($_POST['confirm-apply-team'])) {

require 'dbh.inc.php';

$uid = $_SESSION['userId'];
$idTeam = $_GET['idt'];

$sql2 = "SELECT * FROM users WHERE idUsers = $uid;";
$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_assoc($result2);

$idRole = $row2['role'];


$sql1 = "SELECT * FROM teams WHERE idTeam = $idTeam;";
$result1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_assoc($result1);

$idTeamOwner = $row1['idUsers'];

$sql3 = "SELECT * FROM apply WHERE idUser = $uid;";
$result3 = mysqli_query($conn, $sql3);
$numrow = mysqli_num_rows($result3);

if ($numrow >= 3) {
  echo "You can't apply for more than 3 teams.";
}else {

  $sql = "INSERT INTO apply (idTeam, idTeamUser, idUser, idUserRole) VALUES ($idTeam, $idTeamOwner, $uid, $idRole)";

  if ($conn->query($sql) === TRUE) {
    header("Location: searchteam.inc.php");
    exit();
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

}
$conn->close();
}



if (isset($_POST['apply-cancel'])) {

require 'dbh.inc.php';

$idApply = $_GET['ida'];

$sql1 = "DELETE FROM apply WHERE idApply = $idApply;";
$result1 = mysqli_query($conn, $sql1);


header("Location: ../applies.php?i=success");
exit();


}



if (isset($_POST['enter-team'])) {

require 'dbh.inc.php';

$uid = $_SESSION['userId'];
$idTeam = $_GET['id'];

$sql2 = "SELECT * FROM users WHERE idUsers = $uid;";
$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_assoc($result2);

$idRole = $row2['role'];

if ($idRole == 1) {
  $idRole = "idTop";
}else if ($idRole == 2) {
  $idRole = "idJungler";
}else if ($idRole == 3) {
  $idRole = "idMid";
}else if ($idRole == 4) {
  $idRole = "idBot";
}else if ($idRole == 5) {
  $idRole = "idSupport";
}else if ($idRole == 6) {
  $idRole = "idCoach";
}else if ($idRole == 7) {
  $idRole = "idAnalyst";
}else if ($idRole == 8) {
  $idRole = "idManager";
}

$sql2 = "SELECT * FROM teams WHERE idTeam = $idTeam AND $idRole = 0;";
$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_assoc($result2);
$numrow = mysqli_num_rows($result2);

if ($numrow > 0) {
  $sql = "UPDATE teams SET $idRole = $uid WHERE idTeam =$idTeam;";
  $result = $conn->query($sql);

  $sql = "UPDATE users SET idTeam = $idTeam WHERE idUsers = $uid;";
  $result = $conn->query($sql);

  header("Location: ../team-profile.php?id=$idTeam");
  exit();

}else {
  header("Location: ../team-profile.php?e=roletaken");
  exit();
}


}




if (isset($_POST['apply-cancel2'])) {

require 'dbh.inc.php';

$idApply = $_GET['ida'];

$sql1 = "DELETE FROM apply WHERE idApply = $idApply;";
$result1 = mysqli_query($conn, $sql1);


header("Location: ../notification.php?i=success");
exit();


}


if (isset($_POST['apply-player'])) {

require 'dbh.inc.php';

$uid = $_SESSION['userId'];
$idApply = $_GET['ida'];
$idTeam = $_GET['idt'];
$idRole = $_GET['idr'];

if ($idRole == 1) {
  $idRole = "idTop";
}else if ($idRole == 2) {
  $idRole = "idJungler";
}else if ($idRole == 3) {
  $idRole = "idMid";
}else if ($idRole == 4) {
  $idRole = "idBot";
}else if ($idRole == 5) {
  $idRole = "idSupport";
}else if ($idRole == 6) {
  $idRole = "idCoach";
}else if ($idRole == 7) {
  $idRole = "idAnalyst";
}else if ($idRole == 8) {
  $idRole = "idManager";
}

$sql = "UPDATE users SET idTeam = $idTeam WHERE idUsers = $uid;";
$result = $conn->query($sql);

$sql = "UPDATE teams SET $idRole = $uid WHERE idTeam = $idTeam;";
$result = $conn->query($sql);

$sql1 = "DELETE FROM apply WHERE idApply = $idApply;";
$result1 = mysqli_query($conn, $sql1);



header("Location: ../notification.php?i=success");
exit();


}


 ?>
