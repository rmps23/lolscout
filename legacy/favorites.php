<?php
include 'includes/menuham.php';
include 'includes/header.inc.php';
?>

<div class="not-main">

<br><br><br>
<script type="text/javascript">

  function closeAlert(){
    var element = document.getElementById("alerta");
    element.parentNode.removeChild(element);
  }

</script>

<?php
  if (isset($_GET['e'])) {

    $error = $_GET['e'];
    
    $sql = "SELECT * FROM errors WHERE error = '$error';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    $msg = $row['message'];

    ?>
    <div id="alerta" class="alert">
      <span class="alert-text"><?php echo $msg; ?></span>
      <span class="closebtn" onclick="closeAlert()">&#10005;</span>
    </div>

    <?php
    }elseif (isset($_GET['i'])) {
    ?>
      <div id="alerta" class="alert2">
        <span class="alert-text">Success!</span>
        <span class="closebtn" onclick="closeAlert()">&#10005;</span>
      </div>
    <?php
    }
?>


<?php
  if (isset($_SESSION['userId'])) {

    $uID = $_SESSION['userId'];

    $sql = "SELECT * FROM favs WHERE idUser = $uID;";
    $result2 = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result2);


if ($num_rows > 0) {
  while($row = mysqli_fetch_array($result2)) {

    $idFavUser = $row['idFavUser'];

    $sql = "SELECT * FROM users WHERE idUsers = $idFavUser;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    $username = $row['username'];
    $opgg = $row['opgg'];
    $idTeam = $row['idTeam'];
    $nation = $row['nation'];

    $sql = "SELECT * FROM teams WHERE idTeam = $idTeam;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    $teamTAG = $row['TeamTag'];
    $teamName = $row['TeamName'];
    $teamLogo = $row['TeamLogo'];



    ?>
<table class="fav-table">
  <tr>
    <td class="fav-table-topbar"><?php echo $username; ?></td>
    <td class="fav-table-topbar">Team</td>
    <td class="fav-table-topbar">Nation</td>
    <td class="fav-table-topbar">Options</td>
  </tr>
  <tr>
    <td class="fav-table-botbar">

      <a href="profile.php?id=<?php echo $idFavUser; ?>">
      <div class="fav-table-minibar">
        <span style="	color: #111;">Profile</span>
      </div>
      </a>

    </td>

    <td class="fav-table-botbar">
      <img style="margin-bottom:15px;" height="50" width="50" src="teams-images/<?php echo $teamLogo; ?>" alt="">
      <br>
      <span style="font-size: 14px;"><?php echo $teamTAG." | ".$teamName; ?></span>
    </td>

    <?php
    if ($nation == 0) {
      ?>
      <td class="fav-table-botbar">
        <img class="fav-nation" src="country-images/default.png ?>" alt="">
        <br>
        <span style="font-size: 14px;">Unknown</span>
      </td>
      <?php
    }else {
      $sql = "SELECT * FROM nation WHERE idNation = $nation;";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_assoc($result);

      $nationName = $row['name'];
      $nationIMG = $row['image'];
      ?>
      <td class="fav-table-botbar">
        <img class="fav-nation" src="country-images/<?php echo $nationIMG; ?>" alt="">
        <br>
        <span style="font-size: 14px;"><?php echo $nationName; ?></span>
      </td>
      <?php
    }

     ?>

    <td class="fav-table-botbar">

      <a onclick="document.getElementById('modal-remove-fav').style.display='block'">
        <div class="fav-table-minibar">
          <span>Remove</span>
        </div>
      </a>

      <div id="modal-remove-fav" class="w3-modal">
        <div class="w3-modal-content w3-animate-top">
          <div class="w3-container w3-padding-32">
            <span onclick="document.getElementById('modal-remove-fav').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
            <form class="" action="includes/add-fav.inc.php?id=<?php echo $idFavUser; ?>" method="post">
              <br>
              <p class="modal-title">Do you want to remove <?php echo $username; ?> from your favorites?</p>
              <br>
              <button class="modal-confirm-button" type="submit" name="confirm-delete-fav">Confirm</button>
              &nbsp;&nbsp;&nbsp;
              <button class="modal-confirm-button" type="submit" name="cancel-delete-fav">Cancel</button>
              <br><br>
            </form>
          </div>
        </div>
      </div>

    </td>
  </tr>
</table>

 
<?php

}
}else {
?>
  <div class="fav-noresult">
    <span>Nothing on your favorite list!</span>
  </div>
<?php
}

?>
</div>
<?php

}else {
  header("Location: index.php");
}

include 'footer.php';
