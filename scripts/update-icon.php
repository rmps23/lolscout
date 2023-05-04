<?php

require '../includes/dbh.inc.php';
session_start();

$idp = $_GET['idp'];
$icd = $_GET['icd'];
$sn = $_GET['sn'];


?>
<span id="sumn" style="visibility:hidden;"><?php echo $sn; ?></span>

<?php

$lastUP = (strtotime("now"));


$icon = $icd;

$sql2 = "UPDATE riot SET profileImg = '$icon' WHERE idUser='$idp';";
$result2 = $conn->query($sql2);


if (mysqli_query($conn, $sql2)) {

  $sql = "UPDATE riot SET lastupdate = '$lastUP' WHERE idUser='$idp';";
  $result = $conn->query($sql);

  if (mysqli_query($conn, $sql)) {

    header("Location: ../profile.php?id=$idp&success");
    exit();
    } else {
      echo "Error updating record: " . mysqli_error($conn);
    }

    header("Location: ../profile.php?id=$idp&success");
    exit();

  } else {
    echo "Error updating record: " . mysqli_error($conn);
  }


?>
