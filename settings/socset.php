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
    <p>Social Settings</p>

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
        $sql = "SELECT * FROM socials WHERE idUsers = $uID;";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        $facebook = $row['facebook'];
        $twitter = $row['twitter'];
        $instagram = $row['instagram'];
        $twitch = $row['twitch'];
        $youtube = $row['youtube'];

        if ($facebook == "0" || $twitter == "0" || $instagram == "0" || $twitch == "0" || $youtube == "0") {
        ?>
        <div class="set-inc-title">
        <a onclick="document.getElementById('modal-change-social').style.display='block'" ><button>+ Add Social</button></a>
        </div>
        <?php
        }
    ?>
    


 
  <?php
    if ($facebook !== "0") {
        echo "<div class='set-inc-title'>
        <img src='../social-images/facebook.png' class='settings-social-img'>
        <a href='$facebook' target='_blank'>Facebook</a>";
        ?>
        <a onclick="document.getElementById('modal-remove-facebook').style.display='block'" class='settings-x-button'>&times;</a>
        <?php
        echo "</div>";
    }
    ?>

<?php
    if ($twitter !== "0") {
        echo "<div class='set-inc-title'>
        <img src='../social-images/twitter.png' class='settings-social-img'>
        <a href='$twitter' target='_blank'>Twitter</a>";
        ?>
        <a onclick="document.getElementById('modal-remove-twitter').style.display='block'" class='settings-x-button'>&times;</a>
        <?php
        echo "</div>";
    }
    ?>

<?php
    if ($instagram !== "0") {
        echo "<div class='set-inc-title'>
        <img src='../social-images/instagram.png' class='settings-social-img'>
        <a href='$instagram' target='_blank'>Instagram</a>";
        ?>
        <a onclick="document.getElementById('modal-remove-instagram').style.display='block'" class='settings-x-button'>&times;</a>
        <?php
        echo "</div>";
    }
    ?>

<?php
    if ($twitch !== "0") {
        echo "<div class='set-inc-title'>
        <img src='../social-images/twitch.png' class='settings-social-img'>
        <a href='$twitch' target='_blank'>Twitch</a>";
        ?>
        <a onclick="document.getElementById('modal-remove-twitch').style.display='block'" class='settings-x-button'>&times;</a>
        <?php
        echo "</div>";
    }
    ?>

<?php
    if ($youtube !== "0") {
        echo "<div class='set-inc-title'>
        <img src='../social-images/youtube.png' class='settings-social-img'>
        <a href='$youtube' target='_blank'>Youtube</a>";
        ?>
        <a onclick="document.getElementById('modal-remove-youtube').style.display='block'" class='settings-x-button'>&times;</a>
        <?php
        echo "</div>";
    }
    ?>
  </div>

  
</div>


</div>
<!-- MODAL CONTENTS -->


<div id="modal-change-social" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-padding-32">
      <span onclick="document.getElementById('modal-change-social').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#3FA0EF;">&times;</span>

          <br>
          <p class="modal-title">Edit Social Media</p>
          <br>
          <?php
          if ($facebook == "0") {
            ?>
            <div class="modal-social-midbar">
              <form class="" action="includes/change-social.inc.php" method="post">
                  <img style="margin-left: 20px; margin-bottom:2px;" height="20" width="20" src="../social-images/facebook.png" alt="">
                  <span style="color: #eee; line-height: 55px; margin-left:10px;">Facebook</span>
                <button class="modal-add-social" type="submit" name="confirm-facebook">Add</button>
                <input class="modal-social-textbox" type="text" name="facebook-id" placeholder="Insert facebook link here...">
              </form>
            </div>
            <?php
          }

          if ($twitter == "0") {
            ?>
            <div class="modal-social-midbar">
              <form class="" action="includes/change-social.inc.php" method="post">
                <img style="margin-left: 20px; margin-bottom:2px;" height="20" width="20" src="../social-images/twitter.png" alt="">
                <span style="color: #eee; line-height: 55px; margin-left:10px;">Twitter</span>
                <button class="modal-add-social" type="submit" name="confirm-twitter">Add</button>
                <input class="modal-social-textbox" type="text" name="twitter-id" placeholder="Insert twitter link here...">
              </form>
            </div>
            <?php
          }

          if ($instagram == "0") {
            ?>
            <div class="modal-social-midbar">
              <form class="" action="includes/change-social.inc.php" method="post">
                <img style="margin-left: 20px; margin-bottom:2px;" height="20" width="20" src="../social-images/instagram.png" alt="">
                <span style="color: #eee; line-height: 55px; margin-left:10px;">Instagram</span>
                <button class="modal-add-social" type="submit" name="confirm-instagram">Add</button>
                <input class="modal-social-textbox" type="text" name="instagram-id" placeholder="Insert instagram link here...">
              </form>
            </div>
            <?php
          }

          if ($twitch == "0") {
            ?>
            <div class="modal-social-midbar">
              <form class="" action="includes/change-social.inc.php" method="post">
                <img style="margin-left: 20px; margin-bottom:2px;" height="20" width="20" src="../social-images/twitch.png" alt="">
                <span style="color: #eee; line-height: 55px; margin-left:10px;">Twitch</span>
                <button class="modal-add-social" type="submit" name="confirm-twitch">Add</button>
                <input class="modal-social-textbox" type="text" name="twitch-id" placeholder="Insert twitch link here...">
              </form>
            </div>
            <?php
          }

          if ($youtube == "0") {
            ?>
            <div class="modal-social-midbar">
              <form class="" action="includes/change-social.inc.php" method="post">
                <img style="margin-left: 20px; margin-bottom:2px;" height="20" width="20" src="../social-images/youtube.png" alt="">
                <span style="color: #eee; line-height: 55px; margin-left:10px;">Youtube</span>
                <button class="modal-add-social" type="submit" name="confirm-youtube">Add</button>
                <input class="modal-social-textbox" type="text" name="youtube-id" placeholder="Insert youtube link here...">
              </form>
            </div>
            <?php
          }
          ?>

          <div id="remove-facebook-modal" class="modal">
            <form class="" action="includes/change-social.inc.php" method="post">
              <br>
              <p class="profile-modal-label">Confirm removal of facebook from your socials ?</p>
              <br>
              <button class="profile-modal-confirm" type="submit" name="confirm-remove-facebook">Confirm</button>
              <button class="profile-modal-confirm" type="submit" name="cancel-remove-social">Cancel</button>
              <br><br>
            </form>
          </div>

    </div>
  </div>
</div>

<div id="modal-remove-facebook" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-padding-32">
      <span onclick="document.getElementById('modal-remove-facebook').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#3FA0EF;">&times;</span>
      <form class="" action="includes/change-social.inc.php" method="post">
        <br>
        <p class="modal-title">Do you want to remove facebook from your socials?</p>
        <br>
        <button class="modal-confirm-button" type="submit" name="confirm-remove-facebook">Confirm</button>
        <button class="modal-confirm-button" type="submit" name="cancel-remove-social">Cancel</button>
        <br><br>
      </form>
    </div>
  </div>
</div>

<div id="modal-remove-twitter" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-padding-32">
      <span onclick="document.getElementById('modal-remove-twitter').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#3FA0EF;">&times;</span>
      <form class="" action="includes/change-social.inc.php" method="post">
        <br>
        <p class="modal-title">Do you want to remove twitter from your socials?</p>
        <br>
        <button class="modal-confirm-button" type="submit" name="confirm-remove-twitter">Confirm</button>
        <button class="modal-confirm-button" type="submit" name="cancel-remove-social">Cancel</button>
        <br><br>
      </form>
    </div>
  </div>
</div>

<div id="modal-remove-instagram" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-padding-32">
      <span onclick="document.getElementById('modal-remove-instagram').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#3FA0EF;">&times;</span>
      <form class="" action="includes/change-social.inc.php" method="post">
        <br>
        <p class="modal-title">Do you want to remove instagram from your socials?</p>
        <br>
        <button class="modal-confirm-button" type="submit" name="confirm-remove-instagram">Confirm</button>
        <button class="modal-confirm-button" type="submit" name="cancel-remove-social">Cancel</button>
        <br><br>
      </form>
    </div>
  </div>
</div>

<div id="modal-remove-twitch" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-padding-32">
      <span onclick="document.getElementById('modal-remove-twitch').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#3FA0EF;">&times;</span>
      <form class="" action="includes/change-social.inc.php" method="post">
        <br>
        <p class="modal-title">Do you want to remove twitch from your socials?</p>
        <br>
        <button class="modal-confirm-button" type="submit" name="confirm-remove-twitch">Confirm</button>
        <button class="modal-confirm-button" type="submit" name="cancel-remove-social">Cancel</button>
        <br><br>
      </form>
    </div>
  </div>
</div>

<div id="modal-remove-youtube" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-padding-32">
      <span onclick="document.getElementById('modal-remove-youtube').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#3FA0EF;">&times;</span>
      <form class="" action="includes/change-social.inc.php" method="post">
        <br>
        <p class="modal-title">Do you want to remove youtube from your socials?</p>
        <br>
        <button class="modal-confirm-button" type="submit" name="confirm-remove-youtube">Confirm</button>
        <button class="modal-confirm-button" type="submit" name="cancel-remove-social">Cancel</button>
        <br><br>
      </form>
    </div>
  </div>
</div>

<!-- END MODAL CONTENTS -->
