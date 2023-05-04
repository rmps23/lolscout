<?php
  session_start();

  if (isset($_POST['addfav'])) {
    require 'dbh.inc.php';


   $idP = $_GET['id'];
   $uid = $_SESSION['userId'];

   $sql = "INSERT INTO favs (idUser, idFavUser) VALUES ('$uid', '$idP')";

   if (mysqli_query($conn, $sql)) {
      header("Location: ../profile.php?id=$idP&i=success");
      exit();
      } else {
      echo "Error updating record: " . mysqli_error($conn);
      }
  }

  if (isset($_POST['remfav'])) {
    require 'dbh.inc.php';


   $idP = $_GET['id'];
   $uid = $_SESSION['userId'];

   $sql = "DELETE FROM favs WHERE idUser = $uid AND idFavUser = $idP";


   if (mysqli_query($conn, $sql)) {
      header("Location: ../profile.php?id=$idP&i=success");
      exit();
      } else {
      echo "Error updating record: " . mysqli_error($conn);
      }
  }




  if (isset($_POST['confirm-delete-fav'])) {

    require 'dbh.inc.php';

    $uid = $_SESSION['userId'];

    $idFavUser = $_GET['id'];

    $sql = "DELETE FROM favs WHERE idUser = $uid AND idFavUser = $idFavUser;";
    $result = mysqli_query($conn, $sql);

    header("Location: ../favorites.php?i=success");
    exit();
}


if (isset($_POST['cancel-delete-fav'])) {
  header("Location: ../favorites.php");
  exit();
}



$conn->close();

 ?>
