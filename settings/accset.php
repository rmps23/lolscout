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
        background-image: none;
    }
</style>

<div class="set-inc-main">

    <div class="set-inc-title">
        <p>Account Settings</p>

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
        <div class="set-inc-title">
            <p>Email: <span><?php echo $email; ?></span></p>
            <a onclick="document.getElementById('modal-change-email').style.display='block'"><button>Edit</button></a>
            <br>
        </div>

        <div class="set-inc-title">
            <p>Password</p>
            <p><a onclick="document.getElementById('modal-change-password').style.display='block'"><button>Change Password</button></a></p>
        </div>
    </div>
</div>


<!-- MODAL CONTENTS -->

<div id="modal-change-email" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-padding-32">
      <span onclick="document.getElementById('modal-change-email').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#3FA0EF;">&times;</span>
        <form action="includes/change-email.inc.php" method="post">
          <br>
          <p class="modal-title">Change Email</p>
          <br>
          <input class="modal-textbox" type="text" name="email-uid" placeholder="Insert new email">
          <br><br>
          <button class="modal-confirm-button" type="submit" name="confirm-email">Confirm</button>
          <br><br>
        </form>
    </div>
  </div>
</div>

<div id="modal-change-password" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-padding-32">
      <span onclick="document.getElementById('modal-change-password').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#3FA0EF;">&times;</span>
        <form class="" action="includes/change-pw.inc.php" method="post">
          <br>
          <p class="modal-title">Change Password</p>
          <br>
          <input class="modal-textbox" type="password" name="password" placeholder="Insert new password">
          <br><br>
          <input class="modal-textbox" type="password" name="password-cf" placeholder="Confirm new password">
          <br><br>
          <button class="modal-confirm-button" type="submit" name="confirm-change-pw">Confirm</button>
          <br><br>
        </form>
    </div>
  </div>
</div>


























<div id="modal-change-role" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-padding-32">
      <span onclick="document.getElementById('modal-change-role').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
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
      <span onclick="document.getElementById('modal-change-nation').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
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
           <img src="country-images/" alt="">
           <option  style="background-image:url(<?php echo $nationP; ?>);" value="<?php echo $row5['idNation'];?>"><?php echo $row5['name'];?></option>
          <?php endwhile;?>
          </select>
      <br><br>
      <button class="modal-confirm-button" type="submit" name="confirm-nation">Confirm</button>
      <br><br>
      </form>
    </div>
  </div>
</div>





<!-- END MODAL CONTENTS -->



<?php

?>