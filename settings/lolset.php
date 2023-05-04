<?php
include '../includes/header.inc.php';
require '../includes/dbh.inc.php';

$uID = $_SESSION['userId'];
$sql = "SELECT * FROM users WHERE idUsers = $uID;";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$email = $row['email'];
$idNation = $row['idNation'];
$idRole = $row['idRole'];

?>

<style>
    body{
        background-color: #eee;
    }
</style>

<div class="set-inc-main">



  <div class="set-inc-title">
    <p>League of Legends Settings</p>

  <?php
  if (isset($_GET['e'])) {

  $error = $_GET['e'];

  $sql = "SELECT * FROM errors WHERE error = '$error';";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);

  $msg = $row['message'];

  ?>
  <p class="alert-text"><?php echo "Error: ".$msg; ?></p>

  <?php
  }elseif (isset($_GET['i'])) {
  ?>

  <p class="alert-text-success">Success!</p>
  
  <?php
  }
  ?>
        
  </div>
    

  <div class="set-inc-text">


  <?php
  $sql = "SELECT * FROM nation WHERE idNation = $idNation;";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);

  $nationName = $row['name'];
  $nationIMG = $row['image'];

  If($nation == "0"){
  ?>  

  <div class="set-inc-title">
  <p>
  Nation: <span>Undefined</span>
  <img class="settings-flag" height="20" width="30" src="../country-images/default.png" alt="">
  </p>

  <?php
  }else{
  ?>

  <div class="set-inc-title">
  <p>
  Nation: <span><?php echo $nationName; ?></span>
  <img class="settings-flag" height="20" width="30" src="../country-images/<?php echo $nationIMG; ?>" alt="">
  </p>
  <?php
  }
  ?>
  <a onclick="document.getElementById('modal-change-nation').style.display='block'"><button>Edit</button></a>
  <br>
  </div>



  <?php
  $sql = "SELECT * FROM roles WHERE idRole = $idRole;";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);

  $rolename = $row['rolename'];
  $roleimg = $row['image'];

  ?>

  <div class="set-inc-title">
      <p>
      Role: <span><?php echo $rolename; ?></span>
      <img class='settings-role-img' src='../role-images/<?php echo $roleimg; ?>'>
      </p>
      <a onclick="document.getElementById('modal-change-role').style.display='block'"><button>Edit</button></a>
  </div>


  <?php
  $sql = "SELECT * FROM userteam WHERE idUser = $uID;";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);

  $idTeam = $row['idTeam'];

  if($idTeam == "0"){
  ?>

  <div class="set-inc-title">
      <p>
      Team: <span>Unknown</span>
      <img height="30" width="30" class='settings-team' src='../teams-images/default-team.png'>
      </p>
      <a href="../search-team.php" target="_parent"><button>Search Team</button></a>
  </div>

  <?php  

  }else{
  
  $sql = "SELECT * FROM teams WHERE idTeam = $idTeam;";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);

  $teamTAG = $row['TeamTag'];
  $teamname = $row['TeamName'];
  $teamLogo = $row['TeamLogo'];
  ?>

  <div class="set-inc-title">
      <p>
      Team: <span><?php echo $teamTAG." - ".$teamname; ?></span>
      <img height="30" width="30" class='settings-team' src='../teams-images/<?php echo $teamLogo; ?>'>
      </p>
      <a onclick="document.getElementById('modal-leave-team').style.display='block'"><button>Leave Team</button></a>
  </div>

  <?php
  }
  ?>
  
</div>

</div>



<!-- MODAL CONTENTS -->

<div id="modal-change-role" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-padding-32">
      <span onclick="document.getElementById('modal-change-role').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#3FA0EF;">&times;</span>
      <br>
      <p class="modal-title">Change Role</p>
      <br>
      <form class="" action="includes/change-role.inc.php" method="post">
        <select class="modal-change-role" name="roles">
          <?php
          $sql5 = "SELECT * FROM roles WHERE idRole > 0;";
          $result5 = mysqli_query($conn, $sql5);
          ?>
         <?php while($row5 = mysqli_fetch_array($result5)):;?>
           <option value="<?php echo $row5['idRole'];?>"><?php echo $row5['rolename'];?></option>
          <?php endwhile;?>
          </select>
      <br><br>
      <button class="modal-confirm-button" type="submit" name="confirm-role">Confirm</button>
      <br><br>
      </form>
    </div>
  </div>
</div>


<div id="modal-change-nation" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-padding-32">
      <span onclick="document.getElementById('modal-change-nation').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#3FA0EF;">&times;</span>
      <br>
      <p class="modal-title">Change Nationality</p>
      <br>
      <form class="" action="includes/change-nation.inc.php" method="post">
        <select class="modal-change-role" name="nation">
          <?php
          $sql5 = "SELECT * FROM nation;";
          $result5 = mysqli_query($conn, $sql5);
          ?>
         <?php while($row5 = mysqli_fetch_array($result5)):;?>
           <option value="<?php echo $row5['idNation'];?>"><?php echo $row5['name'];?></option>
          <?php endwhile;?>
          </select>
      <br><br>
      <button class="modal-confirm-button" type="submit" name="confirm-nation">Confirm</button>
      <br><br>
      </form>
    </div>
  </div>
</div>

<div id="modal-leave-team" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-padding-32">
      <span onclick="document.getElementById('modal-leave-team').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#3FA0EF;">&times;</span>
      <form class="" action="includes/leave-team.inc.php" method="post">
        <br>
        <div style="width: 70%; margin: auto;">
          <p class="modal-title">Are you sure you want to leave the team?</p>
        </div>
        <br>
        <button class="modal-confirm-button" type="submit" name="confirm-leave-team">Confirm</button>
        <br><br>
      </form>
    </div>
  </div>
</div>



<!-- END MODAL CONTENTS -->



<?php

?>