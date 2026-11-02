<?php
session_start();
require '../includes/dbh.inc.php';

$icd = $_GET['icd'];
$idp = $_GET['idp'];

$rank = $_GET['r'];
$tier = $_GET['t'];
$lp = $_GET['lp'];
$sn = $_GET['sn'];

echo $rank;
echo $tier;
echo $lp;


if ($rank !== "") {

  if ($tier == "MASTER" || $tier == "GRANDMASTER" || $tier == "CHALLENGER") {
    $rank = "";
  }

  $text = $tier . " " . $rank;


  $sql = "SELECT * FROM ranks WHERE rankname = '$text';";
  $result = $conn->query($sql);

  if (mysqli_query($conn, $sql)) {

    $row = mysqli_fetch_assoc($result);
    $idRank = $row['idRank'];

    $sql2 = "UPDATE rankuser SET idRank = '$idRank', tier = '$tier', ranks = '$rank' , LP = '$lp' WHERE idUser = '$idp';";
    $result2 = $conn->query($sql2);

    if (mysqli_query($conn, $sql2)) {
      header("Location: ../scripts/update-icon.php?sn=$sn&icd=$icd&idp=$idp");
      exit();
    } else {
      echo "Error updating record: " . mysqli_error($conn);
    }


  } else {
    echo "Error updating record: " . mysqli_error($conn);
  }




}





?>
