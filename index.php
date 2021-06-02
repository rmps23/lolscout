<?php

include 'includes/menuham.php';
include 'includes/header.inc.php';
require 'includes/dbh.inc.php';
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

  <body>


    <div id="main">
        <div class="index-main">

          <?php

            if (isset($_SESSION['userId'])) {

              $uID = $_SESSION['userId'];
              ?>

              <div class="index-bg-img">
                <br><br><br>
                <span style="color:#eee; font-size:35px;">LOLSCOUT - Search the perfect team for you!</span>
                <br><br><br>

                <div style="text-align:center;">
                  <div class="index-icon">
                    <img src="images/desc1.png" alt="">
                    <br>
                    <br>
                    <span style="color:#eee; font-size:22px;">Find a Team.</span>
                  </div>
                  <div class="index-icon">
                    <img src="images/desc2.png" alt="">
                    <br>
                    <br>
                    <span style="color:#eee; font-size:22px;">Team Management</span>
                  </div>
                  <div class="index-icon">
                    <img src="images/desc3.png" alt="">
                    <br>
                    <br>
                    <span style="color:#eee; font-size:22px;">Verified Accounts</span>
                  </div>
                  <br><br>
                </div>

                <div class="index-getstartbar">
                  <br><br>
                  <?php
                  $sql = "SELECT * FROM users WHERE idUsers = $uID;";
                  $result = mysqli_query($conn, $sql);
                  $row = mysqli_fetch_assoc($result);

                  $accConfirm = $row['accConfirm'];
                   ?>

                  <?php
                  if ($accConfirm == "0") {
                    ?>
                    <span style="font-size:30px;">Start Configuring Account!</span>
                    <br><br><br>
                    <a href="settings.php" class="index-button">Account Settings</a><a href="search-team.php" class="index-button">Search Teams</a>
                    <?php
                  }else {
                    ?>
                    <span style="font-size:30px;">Start Now!</span>
                    <br><br><br>
                    <a href="applies.php" class="index-button">Applies</a><a href="search-team.php" class="index-button">Search Teams</a>
                    <?php
                  }
                   ?>

                </div>





              </div>
            </div>
        </div>
              <?php



            }else {
              ?>
              <div class="index-bg-img">
                <br><br><br>
                <span style="color:#eee; font-size:35px;">LOLSCOUT - Search the perfect team for you!</span>
                <br><br><br>

                <div style="text-align:center;">
                  <div class="index-icon">
                    <img src="images/desc1.png" alt="">
                    <br>
                    <br>
                    <span style="color:#eee; font-size:22px;">Find a Team.</span>
                  </div>
                  <div class="index-icon">
                    <img src="images/desc2.png" alt="">
                    <br>
                    <br>
                    <span style="color:#eee; font-size:22px;">Team Management</span>
                  </div>
                  <div class="index-icon">
                    <img src="images/desc3.png" alt="">
                    <br>
                    <br>
                    <span style="color:#eee; font-size:22px;">Verified Accounts</span>
                  </div>
                  <br><br>
                </div>

                <div class="index-getstartbar">
                  <br><br>
                  <span style="font-size:30px;">Start Now!</span>
                  <br><br><br>
                  <a href="signup.php" class="index-button">SIGNUP</a><a href="login.php" class="index-button">LOGIN</a>
                </div>
              </div>
            </div>
        </div>
              <?php
            }

           ?>


  </body>
</html>
