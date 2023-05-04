<?php
include '../includes/header.inc.php';
require '../includes/dbh.inc.php';

$uID = $_SESSION['userId'];
$sql = "SELECT * FROM users WHERE idUsers = $uID;";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

?>

<style>
    body{
        background-color: #eee;
    }
</style>

<div class="set-inc-main">

    <div class="set-inc-title">
        <p>Delete Account</p>

        <?php
          if (isset($_GET['e'])) {

          $error = $_GET['e'];

          if ($error == "pwr"){
            ?>
            <p class="alert-text"><?php echo "Error: Incorrect password!"; ?></p>
            <?php
          }
        }
          ?>

    </div>
    
    <div class="set-inc-text">
        <div class="set-inc-title">
          <a onclick="document.getElementById('modal-remove-account').style.display='block'"><button>Delete Account</button></a>
        </div>

    </div>
</div>


<!-- MODAL CONTENTS -->

<div id="modal-remove-account" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-padding-32">
      <span onclick="document.getElementById('modal-remove-account').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#3FA0EF;">&times;</span>
      <form class="" action="includes/delete-account.inc.php" method="post">
        <br>
        <div style="width: 70%; margin: auto;">
          <p class="modal-title">Do you want to remove your LOLScout account?</p>
          <p class="modal-title"> If you confirm, you can't get your account back.</p>
          <br>
          <p class="modal-title">(._. )</p>
        </div>
        <br>
        <input class="modal-textbox" type="password" name="passsword" placeholder="Insert your password">
        <br><br>
        <button class="modal-confirm-button" type="submit" name="confirm-delete-account">Confirm</button>
        &nbsp;&nbsp;&nbsp;
        <button class="modal-confirm-button" type="submit" name="cancel-delete-account">Cancel</button>
        <br><br>
      </form>
    </div>
  </div>
</div>

<!-- END MODAL CONTENTS -->



<?php

?>