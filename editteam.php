<?php
include 'includes/header.inc.php';
include 'includes/menuham.php';

 ?>


<html lang="en" dir="ltr">
  <body>
    <?php
      if (isset($_SESSION['userId'])) {

        if (isset($_GET['id'])) {
          $idTeam = $_GET['id'];
        }



        $uID = $_SESSION['userId'];

        $sql = "SELECT * FROM teams WHERE idTeam = $idTeam AND idUsers = $uID;";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $numrow = mysqli_num_rows ($result);

        $teamTag = $row['TeamTag'];
        $teamName = $row['TeamName'];
        $searchRank = $row['SearchRank'];
        $searchPlayers = $row['SearchPlayers'];
        $teamLogo = $row['TeamLogo'];
        $teamInfo = $row['TeamInfo'];
        $invCode = $row['inviteCode'];


      ?>
      <br>
      <div class="editteam-main">
        <a href="teams.php" class="editteam-back">◄ Back</a>
        <br>
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
        <br>
        <table style="width:100%;">
          <tr>
            <td>
              <div class="editteam-box">
                <div class="editteam-main-text">
                  <p class="editteam-title">Team Logo</p>
                  <br>
                  <img class="editteam-img" src="teams-images/<?php echo $teamLogo; ?>" alt="">
                  <div class="editteam-side-img">
                    <p class="editteam-text-desc">Image in JPEG, JPG or PNG format</p>
                    <a onclick="document.getElementById('modal-team-img').style.display='block'" class="editteam-change-img">Upload Image</a>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        </table>


        <table style="width:100%;">
          <tr>
            <td>
              <div class="editteam-box">
                <div class="editteam-main-text">
                  <p class="editteam-title">Team Invite Link</p>
                  <br>
                    <div class="editteam-info-midbox">
                      <a class="editteam-info-text" style="margin-left:20px; text-decoration:none;" href="team-invite.php?idC=<?php echo $invCode; ?>" id="display">Click here to go to invite link.</a>
                    </div>
                </div>
              </div>
            </td>
          </tr>
        </table>
        <table style="width:100%;">
          <tr>
            <td>
              <div class="editteam-box">
                <div class="editteam-main-text">
                  <p class="editteam-title">Team Settings</p>
                  <br>
                  <div class="editteam-info-midbox">
                    <span class="editteam-info-text" style="margin-left:20px;">TAG: <span class='editteam-info-text-c'><?php echo $teamTag; ?></span></span>
                    <a onclick="document.getElementById('modal-team-tag').style.display='block'" class="editteam-edit-button">Edit</a>
                  </div>
                  <div class="editteam-info-midbox">
                    <span class="editteam-info-text" style="margin-left:20px;">Name: <span class='editteam-info-text-c'><?php echo $teamName; ?></span></span>
                    <a onclick="document.getElementById('modal-team-name').style.display='block'" class="editteam-edit-button">Edit</a>
                  </div>
                  <div class="editteam-info-midbox">
                    <span class="editteam-info-text" style="margin-left:20px;">LFP: <span class='editteam-info-text-c'>
                      <?php
                      if ($searchPlayers == "1") {
                        echo "<span class='editteam-info-text-c' style='color: #07c900; margin-left:5px;'>✔</span>";
                      }else {
                        echo "<span class='editteam-info-text-c'style='color: #e60202; margin-left:5px;'>✘</span></span>";
                      }
                       ?>

                    </span></span>
                    <a onclick="document.getElementById('modal-team-lfp').style.display='block'" class="editteam-edit-button">Edit</a>
                  </div>
                  <div class="editteam-info-midbox">
                    <span class="editteam-info-text" style="margin-left:20px;">Rank: <span class='editteam-info-text-c' style="margin-left:5px;">
                      <?php
                      if ($searchRank == 30) {
                        echo "Undefined";
                        ?>
                        <img height="30" width="30" src="rank-images/default.png" alt="">
                        <?php
                      }else {
                        $sql = "SELECT * FROM ranks WHERE idRank = $searchRank";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);

                        $rankname = $row['rankname'];
                        $rankIMG = $row['image'];

                        echo $rankname;
                      ?>
                      <img height="30" width="30" src="rank-images/<?php echo $rankIMG; ?>" alt="">
                      <?php
                        }
                       ?>
                    </span></span>
                    <div class="tooltip">
                      <img src="images/infoimg.png" style="cursor:pointer; margin-left:10px;" width="20" height="20">
                      <span class="tooltiptext">This is the minimum rank of the player to be able to apply for the team</span>
                    </div>
                    <a onclick="document.getElementById('modal-change-ranksearch').style.display='block'" class="editteam-edit-button">Edit</a>

                    <div id="modal-change-ranksearch" class="w3-modal">
                      <div class="w3-modal-content w3-animate-top">
                        <div class="w3-container w3-padding-32">
                          <span onclick="document.getElementById('modal-change-ranksearch').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
                          <br>
                          <p class="modal-title">Choose minimum rank required for the applies.</p>
                          <br>
                          <form class="" action="includes/change-ranksearch.inc.php?id=<?php echo $idTeam; ?>" method="post">
                            <select class="modal-change-role" name="rank">
                              <?php
                              $sql5 = "SELECT * FROM ranks;";
                              $result5 = mysqli_query($conn, $sql5);
                              ?>
                             <?php while($row5 = mysqli_fetch_array($result5)):;?>
                               <option value="<?php echo $row5['idRank'];?>"><?php echo $row5['rankname'];?></option>
                              <?php endwhile;?>
                              </select>
                          <br><br>
                          <button class="modal-confirm-button" type="submit" name="confirm-rank">Confirm</button>
                          <br><br>
                          </form>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="settings-info-midbox-desc">
                    <span class="settings-info-text" style="margin-left:20px;">Description:</span>
                    <a onclick="document.getElementById('modal-team-desc').style.display='block'" class="settings-edit-button">Edit</a>
                    <br>
                    <div style="margin:20px; text-align: justify;">
                      <?php
                      if ($teamInfo == "0") {
                        echo "<span class='settings-info-text-c' >No description.</span>";
                      }else {
                        echo "<span class='settings-info-text-c' >$teamInfo</span>";
                      }
                       ?>

                    </div>
                  </div>
                  <div class="editteam-info-midbox-desc">
                    <span class="editteam-info-text" style="margin-left:20px;">Players:</span>
                    <br>
                    <?php

                    $sql1 = "SELECT * FROM users WHERE idTeam = $idTeam;";
                    $result1 = mysqli_query($conn, $sql1);
                    $row1 = mysqli_fetch_assoc($result1);




                    if($result1 = mysqli_query($conn, $sql1)){
                      if(mysqli_num_rows($result1) > 0){
                      while($row1 = mysqli_fetch_array($result1)){

                        $opggU = $row1['opgg'];
                        $roleU = $row1['role'];
                        $idUserT = $row1['idUsers'];
                        $idUs = $row1['idUsers'];

                        $sql2 = "SELECT * FROM roles WHERE idRole = $roleU;";
                        $result2 = mysqli_query($conn, $sql2);
                        $row2 = mysqli_fetch_assoc($result2);

                        $rolename = $row2['rolename'];
                        $roleimg = $row2['image'];


                    ?>
                    <div class="editteam-info-midbox-player">
                      <img class="editteam-role-img" style="margin-bottom:2px;" src="role-images/<?php echo $roleimg; ?>" alt="">
                      <span class='editteam-info-text-c' style="line-height:50px;"><?php echo $rolename; ?> :</span>
                      <a href="https://euw.op.gg/summoner/userName=<?php echo $opggU; ?>" target="_blank" class="editteam-opgg-button"><?php echo $opggU; ?></a>
                      <a onclick="document.getElementById('modal-team-player<?php echo $idUserT; ?>').style.display='block'" class="editteam-kick-button" style="float:right;">Kick Player</a>
                    </div>

                    <div id="modal-team-player<?php echo $idUserT; ?>" class="w3-modal">
                      <div class="w3-modal-content w3-animate-top">
                        <div class="w3-container w3-padding-32">
                          <span onclick="document.getElementById('modal-team-player<?php echo $idUserT; ?>').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
                          <div>
                            <div class="upload-box">
                              <form class="" action="includes/change-teaminfo.inc.php?id=<?php echo $idUs; ?>&idt=<?php echo $idTeam; ?>" method="post">
                                <br>
                                <p class="modal-title">Confirm to kick <?php echo $opggU; ?> from the team?</p>
                                <br>
                                <button class="modal-confirm-button" type="submit" name="confirm-kickp">Confirm</button>
                                <br><br>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php
                        }
                      }else {
                        ?>
                        <div class="editteam-info-midbox-player">
                          <span class='editteam-info-text-c' style="line-height:45px;">No players.</span>
                        </div>
                        <?php
                      }
                    }
                    ?>
                  </div>
                  <div class="editteam-info-midbox">
                    <a onclick="document.getElementById('modal-team-delete').style.display='block'" class="editteam-delete-button">Delete Team</a>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        </table>




<!--MODALS------------------------------------------------------------------>

<div id="modal-team-img" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-padding-32">
      <span onclick="document.getElementById('modal-team-img').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
      <p class="modal-title">Change Team Logo</p>
      <br>
      <div>
        <img class="modal-img-pre" width="50" height="50" src="teams-images/<?php echo $teamLogo; ?>" alt="">
        <div class="upload-box">
        <form action="includes/uploadimg.inc.php" method="post" enctype="multipart/form-data">
          <?php echo "<input type='hidden' type='idTeam' name='idTeam' value=$idTeam>"; ?>
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
          <button class="custom-file-button" type="submit" name="submit-team-img">Upload</button>

        </form>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="modal-team-tag" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-padding-32">
      <span onclick="document.getElementById('modal-team-tag').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
      <div>
        <div class="upload-box">
          <form class="" action="includes/change-teaminfo.inc.php?id=<?php echo $idTeam; ?>" method="post">
            <br>
            <p class="modal-title">Change Team TAG</p>
            <br>
            <input class="modal-textbox" style="text-transform: uppercase; text-align:center;" maxlength="4" type="text" name="t-tag" placeholder="Insert new team tag">
            <br><br>
            <button class="modal-confirm-button" type="submit" name="confirm-tag">Confirm</button>
            <br><br>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="modal-team-name" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-padding-32">
      <span onclick="document.getElementById('modal-team-name').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
      <div>
        <div class="upload-box">
          <form class="" action="includes/change-teaminfo.inc.php?id=<?php echo $idTeam; ?>" method="post">
            <br>
            <p class="modal-title">Change Team Name</p>
            <br>
            <input class="modal-textbox" style="text-align:center;" type="text" name="t-teamname" placeholder="Insert new team name">
            <br><br>
            <button class="modal-confirm-button" type="submit" name="confirm-teamname">Confirm</button>
            <br><br>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="modal-team-desc" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-padding-32">
      <span onclick="document.getElementById('modal-team-desc').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
      <div>
        <div class="upload-box">
          <form class="" action="includes/change-teaminfo.inc.php?<?php echo "id=$idTeam"; ?>" method="post">
            <br>
            <p class="modal-title">Change Team Info</p>
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
            <textarea id="field" onkeypress="countChar(this)" maxlength="250" class="modal-textbox-desc" type="text" name="t-info" placeholder="Insert new team name"><?php echo $teamInfo; ?></textarea>
            <br>
            <br>
            <span style="color: #eee;">Characters remaining: <span id="charNum">250</span></span>
            <br>
            <br>
            <button class="modal-confirm-button" type="submit" name="confirm-t-info">Confirm</button>
            <br><br>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="modal-team-lfp" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-padding-32">
      <span onclick="document.getElementById('modal-team-lfp').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
      <div>
        <div class="upload-box">
          <form class="" action="includes/change-teaminfo.inc.php?id=<?php echo $idTeam; ?>" method="post">
            <br>
            <p class="modal-title">Change Looking For Team</p>
            <br>
            <?php
            $sql3 = "SELECT * FROM teams WHERE idTeam = $idTeam;";
            $result3 = mysqli_query($conn, $sql3);
            $row3 = mysqli_fetch_assoc($result3);

            $searchplayer = $row3['SearchPlayers'];

            if ($searchplayer == "1") {
              echo "<button class='modal-confirm-button' type='submit' name='confirm-lfp2'>No, Thanks!</button>";
            }else {
              echo "<button class='modal-confirm-button' type='submit' name='confirm-lfp'>Looking for Player</button>";
            }
             ?>
            <br><br>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


<div id="modal-team-delete" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-padding-32">
      <span onclick="document.getElementById('modal-team-delete').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
      <div>
        <div class="upload-box">
          <form class="" action="includes/change-teaminfo.inc.php?id=<?php echo $idTeam; ?>" method="post">
            <br>
            <p class="modal-title">Are you sure to delete this team ?</p>
            <br>
            <button class="modal-confirm-button" type="submit" name="confirm-delete">Confirm</button>
            <br><br>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


<!--END MODALS------------------------------------------------------------------>





      <br>





  </body>
</html>

<?php
}
 ?>
