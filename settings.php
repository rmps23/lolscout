<?php
include 'includes/menuham.php';
include 'includes/header.inc.php';
require 'includes/dbh.inc.php';
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <body>
    <?php
      if (isset($_SESSION['userId'])) {

        $uID = $_SESSION['userId'];
        $sql = "SELECT * FROM users WHERE idUsers = $uID;";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        $idUCode = $row['idUCode'];
        $username = $row['username'];
        $email = $row['email'];
        $profileimg = $row['profileImg'];
        $role = $row['role'];
        $opgg = $row['opgg'];
        $accConfirm = $row['accConfirm'];
        $nation = $row['nation'];
        $Udesc = $row['info'];
        $uIdTeam = $row['idTeam'];

      ?>
      <br>
      <div class="settings-main">
        <?php
          if (isset($_GET['error'])) {
            if ($_GET['error'] == "filebig") {
            ?>
              <div class="alert">
                <span class="alert-text">Warning! File size is too big.</span>
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
              </div>
            <?php
          }else if ($_GET['error'] == "invfile") {
          ?>
            <div class="alert">
              <span class="alert-text">Warning! Invalid file type.</span>
              <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            </div>
          <?php
          }else if ($_GET['error'] == "emptyfield") {
          ?>
            <div class="alert">
              <span class="alert-text">Warning! Empty fields.</span>
              <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            </div>
          <?php
          }else if ($_GET['error'] == "invalidusn") {
          ?>
            <div class="alert">
              <span class="alert-text">Warning! Invalid username.</span>
              <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            </div>
          <?php
          }else if ($_GET['error'] == "emptyemail") {
          ?>
            <div class="alert">
              <span class="alert-text">Warning! Empty fields.</span>
              <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            </div>
          <?php
          }else if ($_GET['error'] == "invalidemail") {
          ?>
            <div class="alert">
              <span class="alert-text">Warning! Invalid email.</span>
              <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            </div>
          <?php
          }else if ($_GET['error'] == "emailtaken") {
          ?>
            <div class="alert">
              <span class="alert-text">Warning! Email already taken.</span>
              <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            </div>
          <?php
        }else if ($_GET['error'] == "pwcheck") {
          ?>
            <div class="alert">
              <span class="alert-text">Warning! Passwords doesn't match.</span>
              <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            </div>
          <?php
          }else if ($_GET['error'] == "invalidlink") {
            ?>
              <div class="alert">
                <span class="alert-text">Warning! Invalid link.</span>
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
              </div>
            <?php
            }
        }else if (isset($_GET['i'])){
          if ($_GET['i'] == "success") {
          ?>
            <div class="alert2">
              <span class="alert-text">Data edited with success. ✔</span>
              <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            </div>
          <?php
          }
        }
        ?>

        <table style="width:100%;">
          <tr>
            <td>
              <div class="settings-box">
                <div class="settings-main-text">
                  <p class="settings-title">Profile Image</p>
                  <br>
                  <img class="settings-img" src="profile-images/<?php echo $profileimg; ?>" alt="">
                  <div class="settings-side-img">
                    <p class="settings-text-desc">Image in JPEG, JPG or PNG format</p>
                    <a onclick="document.getElementById('modal-profile-img').style.display='block'" class="settins-change-img">Upload Image</a>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        </table>

        <table style="width:100%;">
          <tr>
            <td>
              <div class="settings-box">
                <div class="settings-main-text">
                  <p class="settings-title">Account Settings</p>
                  <br>
                  <div class="settings-info-midbox">
                    <span class="settings-info-text" style="margin-left:20px;">User ID: <span class='settings-info-text-c'><?php echo $uID; ?></span></span>
                  </div>
                  <div class="settings-info-midbox">
                    <span class="settings-info-text" style="margin-left:20px;">Username: <span class='settings-info-text-c'><?php echo $username; ?></span></span>
                    <a onclick="document.getElementById('modal-change-username').style.display='block'" class="settings-edit-button">Edit</a>
                  </div>
                  <div class="settings-info-midbox">
                    <span class="settings-info-text" style="margin-left:20px;">Email: <span class='settings-info-text-c'><?php echo $email; ?></span></span>
                    <a onclick="document.getElementById('modal-change-email').style.display='block'" class="settings-edit-button">Edit</a>
                  </div>
                  <div class="editteam-info-midbox-desc">
                    <span class="editteam-info-text" style="margin-left:20px;">Description:</span>
                    <a onclick="document.getElementById('modal-user-desc').style.display='block'" class="settings-edit-button">Edit</a>
                    <br>
                    <div style="margin:20px; text-align: justify;">
                      <span class='editteam-info-text-c' ><?php echo $Udesc; ?></span>
                    </div>
                  </div>
                  <div class="settings-info-midbox">
                    <?php
                    $sql4 = "SELECT * FROM nation WHERE idNation = $nation;";
                    $result4 = mysqli_query($conn, $sql4);
                    $row4 = mysqli_fetch_assoc($result4);

                    $nationName = $row4['name'];
                    $nationIMG = $row4['image'];

                    ?>
                    <img class="settings-flag" height="20" width="30" src="country-images/<?php echo $nationIMG; ?>" alt="">
                    <span class="settings-info-text" style="margin-left:5px;"><span class='settings-info-text-c'><?php echo $nationName; ?></span></span>
                    <a onclick="document.getElementById('modal-change-nation').style.display='block'" class="settings-edit-button">Edit</a>
                  </div>
                  <div class="settings-info-midbox">
                    <a onclick="document.getElementById('modal-change-password').style.display='block'" class="settings-social-button" style="margin-left:20px;">Change Password</a>
                  </div>
              </div>
            </td>
          </tr>
        </table>

        <table style="width:100%; scroll-behavior: smooth; overflow-y: scroll;" id="riotconfirm">
          <tr>
            <td>
              <div class="settings-box">
                <div class="settings-main-text">
                  <p class="settings-title">League of Legends Settings</p>
                  <br>
                  <div class="settings-info-midbox">
                    <span class="settings-info-text" style="margin-left:20px;">League of Legends Account:
                      <?php
                      if ($accConfirm == "1") {
                        echo "<span class='settings-info-text-c' style='color: #07c900;'>Confirmed! ✔</span>";
                      }else {
                        echo "<span class='settings-info-text-c'style='color: #e60202;'>Undefined ✘</span></span>";
                        ?>
                        <a onclick="document.getElementById('modal-confirm-acc').style.display='block'" class='settings-edit-button'>Confirm Account</a>
                        <?php
                      }
                      ?>
                  </div>
                  <?php
                  if ($accConfirm == "0") {
                    echo "<div class='settings-info-midbox'>
                            <span class='settings-info-text' style='margin-left:20px;'>Confirm Code: <span id='display' class='settings-info-text-c'>$idUCode</span></span>
                            <a id='sim' onClick='copyText(display)' class='settings-edit-button'>Copy Code</a>

                          </div>";
                  }
                   ?>
                   <div class="settings-info-midbox">
                     <?php
                       if ($opgg == "0") {
                         ?>
                         <span class="settings-info-text" style="margin-left:20px;">OPGG: Undefined</span>
                         <?php
                       }else {
                         ?>
                         <span class="settings-info-text" style="margin-left:20px;">OPGG:
                           <a href="https://euw.op.gg/summoner/userName=<?php echo $opgg; ?>" target="_blank" class='settings-info-text-c'><span id="opgg"><?php echo $opgg; ?></span></a>
                         </span>
                         <?php
                       }
                      ?>
                   </div>
                   <script>
                   function copyText(element) {
                     var range, selection, worked;

                     if (document.body.createTextRange) {
                       range = document.body.createTextRange();
                       range.moveToElementText(element);
                       range.select();
                     } else if (window.getSelection) {
                       selection = window.getSelection();
                       range = document.createRange();
                       range.selectNodeContents(element);
                       selection.removeAllRanges();
                       selection.addRange(range);
                     }

                     try {
                       document.execCommand('copy');
                       alert("Code copied with success!");
                     }
                     catch (err) {
                       alert('Unable to copy text');
                     }
                   }

                   </script>

                  <div class="settings-info-midbox">
                    <span class="settings-info-text" style="margin-left:20px;">Role:
                      <span class='settings-info-text-c'>
                        <?php
                        $sql2 = "SELECT * FROM roles WHERE idRole = $role;";
                        $result2 = mysqli_query($conn, $sql2);
                        $row2 = mysqli_fetch_assoc($result2);

                        $rolename = $row2['rolename'];
                        $roleimg = $row2['image'];

                        ?>
                        <img class='settings-role-img' src='role-images/<?php echo $roleimg; ?>'>
                        <span><?php echo $rolename; ?></span></span></span>
                        <a onclick="document.getElementById('modal-change-role').style.display='block'" class='settings-edit-button'>Change Role</a>
                  </div>
                  <div class="settings-info-midbox">
                    <?php
                      $sql = "SELECT * FROM teams WHERE idTeam = $uIdTeam;";
                      $result = mysqli_query($conn, $sql);
                      $row = mysqli_fetch_assoc($result);

                      $teamname = $row['TeamName'];
                      $teamLogo = $row['TeamLogo'];
                     ?>
                    <span class="settings-info-text" style="margin-left:20px;">Team:
                    <img class='settings-role-img' src='teams-images/<?php echo $teamLogo; ?>'>
                    <span class='settings-info-text-c'><?php echo $teamname; ?></span></span>
                    <?php
                    if ($uIdTeam !== "0") {
                      ?>
                      <a onclick="document.getElementById('modal-leave-team').style.display='block'" class="settings-edit-button">Leave Team</a>
                      <?php
                    }
                     ?>
                  </div>
                  <div class="settings-info-midbox">
                    <?php

                      $sql = "SELECT * FROM rankuser WHERE idUser = $uID";
                      $result = mysqli_query($conn, $sql);
                      $row = mysqli_fetch_assoc($result);

                      $idRank = $row['idRank'];

                      $sql2 = "SELECT * FROM ranks WHERE idRank = $idRank";
                      $result2 = mysqli_query($conn, $sql2);
                      $row2 = mysqli_fetch_assoc($result2);

                      $rankName = $row2['rankname'];
                      $rankimage = $row2['image'];


                    ?>
                    <span class="editteam-info-text" style="margin-left:20px;">Rank: <span class='editteam-info-text-c' style="margin-left:5px;">

                      <img height="30" width="30" src="rank-images/<?php echo $rankimage; ?>" alt="">
                      <span><?php echo $rankName; ?></span>
                    </span></span>
                    <a onclick="updateRank()" class="editteam-edit-button">Update Rank</a>
                  </div>
              </div>
            </td>
          </tr>
        </table>

        <table style="width:100%;">
          <tr>
            <td>
              <div class="settings-box">
                <div class="settings-main-text">
                  <p class="settings-title">Social Settings</p>
                  <br>
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
                  <div class="settings-info-midbox">
                    <a onclick="document.getElementById('modal-change-social').style.display='block'" class="settings-social-button">+ Add Social</a>
                  </div>
                  <?php
                    }
                  ?>
                  <?php
                    if ($facebook !== "0") {
                      echo "<div class='settings-info-midbox'>
                              <img style='margin-left: 20px; margin-bottom:1px;' src='social-images/facebook.png' height='25' width='25'>
                              <a href='$facebook' class='settings-social-button' target='_blank'>Facebook</a>";
                            ?>
                            <a onclick="document.getElementById('modal-remove-facebook').style.display='block'" class='settings-x-button'>&times;</a>
                            <?php
                            echo "</div>";
                    }
                    if ($twitter !== "0") {
                      echo "<div class='settings-info-midbox'>
                              <img style='margin-left: 20px; margin-bottom:1px;' src='social-images/twitter.png' height='25' width='25'>
                              <a href='$twitter' class='settings-social-button' target='_blank'>Twitter</a>";
                            ?>
                            <a onclick="document.getElementById('modal-remove-twitter').style.display='block'" class='settings-x-button'>&times;</a>
                            <?php
                            echo "</div>";
                    }
                    if ($instagram !== "0") {
                      echo "<div class='settings-info-midbox'>
                              <img style='margin-left: 20px; margin-bottom:1px;' src='social-images/instagram.png' height='25' width='25'>
                              <a href='$instagram' class='settings-social-button' target='_blank'>Instagram</a>";
                            ?>
                            <a onclick="document.getElementById('modal-remove-instagram').style.display='block'" class='settings-x-button'>&times;</a>
                            <?php
                            echo "</div>";
                    }
                    if ($twitch !== "0") {
                      echo "<div class='settings-info-midbox'>
                              <img style='margin-left: 20px; margin-bottom:1px;' src='social-images/twitch.png' height='25' width='25'>
                              <a href='$twitch' class='settings-social-button' target='_blank'>Twitch</a>";
                            ?>
                            <a onclick="document.getElementById('modal-remove-twitch').style.display='block'" class='settings-x-button'>&times;</a>
                            <?php
                            echo "</div>";
                    }
                    if ($youtube !== "0") {
                      echo "<div class='settings-info-midbox'>
                              <img style='margin-left: 20px; margin-bottom:1px;' src='social-images/youtube.png' height='25' width='25'>
                              <a href='$youtube' class='settings-social-button' target='_blank'>Youtube</a>";
                            ?>
                            <a onclick="document.getElementById('modal-remove-youtube').style.display='block'" class='settings-x-button'>&times;</a>
                            <?php
                            echo "</div>";
                    }
                  ?>

              </div>
            </td>
          </tr>
        </table>

        <table style="width:100%;">
          <tr>
            <td>
              <div class="settings-box">
                <div class="settings-main-text">
                  <p class="settings-title">Delete Account</p>
                  <br>
                  <div class="settings-info-midbox">
                      <a onclick="document.getElementById('modal-remove-account').style.display='block'" class="settings-social-button">Delete Account</a>
                    </form>
                  </div>
              </div>
            </td>
          </tr>
        </table>

      </div>

<!-- MODAL CONTENTS -->
<div id="modal-profile-img" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-padding-32">
      <span onclick="document.getElementById('modal-profile-img').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
      <p class="modal-title">Change Profile Image</p>
      <br>
      <div>
        <img class="modal-img-pre" width="50" height="50" src="profile-images/<?php echo $profileimg; ?>" alt="">
        <br>
        <div class="upload-box">
          <form action="includes/uploadimg.inc.php" method="post" enctype="multipart/form-data">
          <label for="file-upload" class="custom-file-upload">
          <i class="fa fa-cloud-upload"></i> Upload Image
          </label>
          <input id="file-upload" name='file' type="file" style="display:none;">
          <script type="text/javascript">
            $('#file-upload').change(function() {
            var i = $(this).prev('label').clone();
            var file = $('#file-upload')[0].files[0].name;
            $(this).prev('label').text(file);
            });
          </script>
          <br>
          <button class="custom-file-button" type="submit" name="submit-img">Confirm</button>
        </form>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="modal-change-username" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-padding-32">
      <span onclick="document.getElementById('modal-change-username').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
      <form class="" action="includes/change-usn.inc.php" method="post">
        <br>
        <p class="modal-title">Change Username</p>
        <br>
        <input class="modal-textbox" type="text" name="username-uid" placeholder="Insert new username">
        <br><br>
        <button class="modal-confirm-button" type="submit" name="confirm-username">Confirm</button>
        <br><br>
      </form>
    </div>
  </div>
</div>

<div id="modal-change-email" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-padding-32">
      <span onclick="document.getElementById('modal-change-email').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
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
      <span onclick="document.getElementById('modal-change-password').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
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

<div id="modal-confirm-acc" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-padding-32">
      <span onclick="document.getElementById('modal-confirm-acc').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
      <br>
      <p class="modal-title">Confirm League of Legends Account</p>
      <br>
      <div style="width: 80%; margin: auto;">
        <span style="color: #eee; font-size: 16px;">• First of all you need to copy the code from your settings page, like in the example below.</span>
      </div>
      <br>
      <img class="modal-code-img" src="images/code-img.png" alt="">
      <br><br>
      <div style="width: 80%; margin: auto;">
        <span style="color: #eee; font-size: 16px;">• After you need to insert the code that you copied into the League of Legends client third party verification and save it.</span>
      </div>
      <br>
      <img class="modal-thirdparty-img" src="images/thirdparty.png" alt="">
      <br><br>
      <div style="width: 80%; margin: auto;">
        <span style="color: #eee; font-size: 16px;">• Now you need to insert your Summoner Name in the text box below and press "Confirm"</span>
      </div>
      <br>
      <input class="modal-textbox-sumname" type="text" id="sumname" value="" placeholder="Insert your Summoner Name...">
      <br><br>
      <button class="modal-confirm-button" onclick="getID()">Confirm</button>

      <script type="text/javascript">
        async function getID(){
            const Sname = document.getElementById("sumname").value;
            const Sname2 = Sname;
            const url = "scripts/confirm-summoner.php?id=" + Sname;
            const response = await fetch(url);
            const data = await response.json();
            const riotID = data['id'];
            const url2 = "scripts/confirm-riotacc.php?id=" + riotID + "&sn=" + Sname2;
            const response2 = await fetch(url2);
            if (response2.status == 200)
            {
                const data2 = await response2.json();
                if(data2['status'] == 0){
                  alert("You need to insert your key in the League of Legends client first!")
                  location.reload();
                }else if (data2['status'] == 1) {
                  alert("Your client key doesnt match with your LOLScout key!")
                  location.reload();
                }else if (data2['status'] == 2) {
                  alert("You confirmed your account with success!")
                  location.reload();
                }
            }
            else
            {
              console.log("Something went wrong!")
              return;
            }

        }
      </script>
    </div>
  </div>
</div>

<div id="modal-user-desc" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-padding-32">
      <span onclick="document.getElementById('modal-user-desc').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
      <div>
        <div class="upload-box">
          <form action="includes/change-info.inc.php" method="post">
            <br>
            <p class="modal-title">Change User Description.</p>
            <br>
            <script src="http://code.jquery.com/jquery-1.5.js"></script>
            <script>
            function countChar(val) {
              var len = val.value.length;
              if (len >= 250) {
                val.value = val.value.substring(0, 250);
              } else {
                $('#charNum').text(250 - len);
              }
            };
            </script>
            <span style="color: #eee;">Use &lt;br&gt; to break lines.</span>
            <br>
            <br>
            <textarea id="field" onkeypress="countChar(this)" maxlength="250" class="modal-textbox-desc" type="text" name="userinfo" placeholder="Insert your description.."><?php echo $Udesc; ?></textarea>
            <br>
            <br>
            <span style="color: #eee;">Characters remaining: <span id="charNum">250</span></span>
            <br>
            <br>
            <button class="modal-confirm-button" type="submit" name="confirm-info">Confirm</button>
            <br><br>
          </form>
        </div>
      </div>
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

<div id="modal-change-social" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-padding-32">
      <span onclick="document.getElementById('modal-change-social').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>

          <br>
          <p class="modal-title">Edit Social Media</p>
          <br>
          <?php
          if ($facebook == "0") {
            ?>
            <div class="modal-social-midbar">
              <form class="" action="includes/change-social.inc.php" method="post">
                  <img style="margin-left: 20px; margin-bottom:2px;" height="20" width="20" src="social-images/facebook.png" alt="">
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
                <img style="margin-left: 20px; margin-bottom:2px;" height="20" width="20" src="social-images/twitter.png" alt="">
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
                <img style="margin-left: 20px; margin-bottom:2px;" height="20" width="20" src="social-images/instagram.png" alt="">
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
                <img style="margin-left: 20px; margin-bottom:2px;" height="20" width="20" src="social-images/twitch.png" alt="">
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
                <img style="margin-left: 20px; margin-bottom:2px;" height="20" width="20" src="social-images/youtube.png" alt="">
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
      <span onclick="document.getElementById('modal-remove-facebook').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
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
      <span onclick="document.getElementById('modal-remove-twitter').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
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
      <span onclick="document.getElementById('modal-remove-instagram').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
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
      <span onclick="document.getElementById('modal-remove-twitch').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
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
      <span onclick="document.getElementById('modal-remove-youtube').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
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

<div id="modal-remove-account" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-padding-32">
      <span onclick="document.getElementById('modal-remove-account').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
      <form class="" action="includes/change-social.inc.php" method="post">
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


<div id="modal-change-nation" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-padding-32">
      <span onclick="document.getElementById('modal-change-role').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
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



<div id="modal-leave-team" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-padding-32">
      <span onclick="document.getElementById('modal-leave-team').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
      <form class="" action="includes/change-teaminfo.inc.php" method="post">
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

<script type="text/javascript">
  async function updateRank(){

      const Sname3 = document.getElementById("opgg").innerHTML

      const url = "scripts/confirm-summoner.php?id=" + Sname3;
      const response = await fetch(url);
      const data = await response.json();

      const riotID = data['id'];
      console.log(riotID)


      const url2 = "scripts/getdata-rank.php?id=" + riotID;
      const response2 = await fetch(url2);
      const data2 = await response2.json();

      const rank = data2['0']['rank'];
      const tier = data2['0']['tier'];
      const lp = data2['0']['leaguePoints'];
      const Qtype = data2['0']['queueType'];

      if (Qtype == "RANKED_FLEX_SR") {

        const url3 = "scripts/getdata-rank.php?id=" + riotID;
        const response3 = await fetch(url3);
        const data3 = await response3.json();

        const rank2 = data3['1']['rank'];
        const tier2 = data3['1']['tier'];
        const lp2 = data3['1']['leaguePoints'];

        window.location.href = "scripts/update-rank.php?r=" + rank2 + "&t=" + tier2 + "&lp=" + lp2 + "&sn=" + Sname3;

      }else {
        window.location.href = "scripts/update-rank.php?r=" + rank + "&t=" + tier + "&lp=" + lp + "&sn=" + Sname3;
      }







  }
</script>

        <br><br><br>
  </body>
</html>

<?php
}
 ?>
