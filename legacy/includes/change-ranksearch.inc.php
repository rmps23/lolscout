<?php
  session_start();

if (isset($_POST['confirm-rank'])) {
  require 'dbh.inc.php';


  $rank = $_POST['rank'];


  if (isset($_GET['id'])) {
    $idTeam = $_GET['id'];
  }


        $sql = "UPDATE teams SET SearchRank=$rank WHERE idTeam=$idTeam;";
        $result = $conn->query($sql);

          if (mysqli_query($conn, $sql)) {
            header("Location: ../editteam.php?id=$idTeam&i=success");
            exit();
          } else {
            echo "Error updating record: " . mysqli_error($conn);
          }


}
$conn->close();

 ?>
