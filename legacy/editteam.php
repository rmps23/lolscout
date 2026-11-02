<?php
include 'includes/header.inc.php';
include 'includes/menuham.php';

?>

<div class="et-main-top">
  <table class="et-main-top-in">
    <tr>
      <td class="et-main-top-td">
        <p>Edit Team</p>
      </td>
      <td class="et-main-top-td">
      <a onclick="document.getElementById('modal-team-create').style.display='block'"><button class="et-main-top-button">Invite Link</button></a>
      </td>
    </tr>
  </table>
</div>

<div class="teams-main">
  <?php
  $idTeam = $_GET['id'];

  $sql = "SELECT * FROM teams WHERE idTeam = $idTeam;";
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
  $teamNation = $row['nation'];

  ?>
  
  <table class="et-main-table">
    <tr>
      <td>
        <div class="et-table-menu">
          <span>Tag:<?php echo $teamTag; ?></span>
        </div>
        <div class="et-table-menu">
          <span>Name:<?php echo $teamName; ?></span>
        </div>
        <div class="et-table-menu">
          <?php
          $sql2 = "SELECT * FROM  WHERE idTeam = $idTeam;";
          $result2 = mysqli_query($conn, $sql2);
          $row2 = mysqli_fetch_assoc($result2);


          ?>
          <span>Nation:<?php echo $teamNation; ?></span>
        </div>
        <div class="et-table-menu">
          <span>Rank:<?php echo $searchRank; ?></span>
        </div>
      </td>
      <td class="et-table-player-div">
        <div class="et-table-menu">
          <p>teste</p>
        </div>
      </td>
    </tr>
  </table>

</div>


















<br><br><br><br><br><br><br><br><br><br><br><br>
<main class="editteam-main">

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
        $teamNation = $row['nation'];


      ?>

  <br>
  <script type="text/javascript">

    function closeAlert(){
      var element = document.getElementById("alerta");
      element.parentNode.removeChild(element);
    }

  </script>
  <br>

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
<br>

  <div style="width:80%; margin:auto;">
    <a href="teams.php" class="editteam-back">◄ Back</a>
  </div>
  <br>
  <table>
    <tr>
      <td class="editteam-main-td" style="text-align: center;">
        <span>Team Logo</span>
        <br>
        <img class="editteam-main-img" src="teams-images/<?php echo $teamLogo; ?>" alt="">
        <br>
        <span> Image in JPEG, JPG or PNG format</span>
        <br>
        <a onclick="document.getElementById('modal-team-img').style.display='block'"><button class="editteam-main-imgbut">Upload Image</button></a>
      </td>
    </tr>
  </table>

  <table>
    <tr>
      <td class="editteam-title-bar">
        <span class="settings-title">Account Settings</span>
      </td>
    </tr>

    <tr>
      <td class="editteam-main-td">
        <div class="editteam-main-div">
        <a style="color: #ccc; font-size:18px; text-decoration:none;" href="team-invite.php?idC=<?php echo $invCode; ?>">Click here to go to invite link.</a>
        </div>
      </td>
    </tr>
  </table>

  <table>
    <tr>
      <td class="editteam-title-bar">
        <span class="settings-title">Team Settings</span>
      </td>
    </tr>
    <tr>
      <td class="editteam-main-td">
        <div class="editteam-main-div">
          <span>TAG: <span><?php echo $teamTag; ?></span></span>
          <a onclick="document.getElementById('modal-team-tag').style.display='block'"><button class="editteam-edit-button">Edit</button></a>
        </div>
        <div class="editteam-main-div">
          <span>Name: <span><?php echo $teamName; ?></span></span>
          <a onclick="document.getElementById('modal-team-name').style.display='block'"><button class="editteam-edit-button">Edit</button></a>
        </div>

        <div class="editteam-main-div">
        <?php
          $sql4 = "SELECT * FROM nation WHERE idNation = $teamNation;";
          $result4 = mysqli_query($conn, $sql4);
          $row4 = mysqli_fetch_assoc($result4);

          $nationName = $row4['name'];
          $nationIMG = $row4['image'];
          ?>
          <img class="settings-flag" height="20" width="30" src="country-images/<?php echo $nationIMG; ?>" alt="">
          <span><span><?php echo $nationName; ?></span></span>
          <a onclick="document.getElementById('modal-change-nation').style.display='block'" class="editteam-edit-button">Edit</a>
        </div>

        <div id="modal-change-nation" class="w3-modal">
          <div class="w3-modal-content w3-animate-top">
            <div class="w3-container w3-padding-32">
              <span onclick="document.getElementById('modal-change-nation').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
              <br>
              <p class="modal-title">Change Nationality</p>
              <br>
              <form class="" action="includes/change-nation.inc.php?idt=<?php echo $idTeam; ?>" method="post">
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
              <button class="modal-confirm-button" type="submit" name="confirm-team-nation">Confirm</button>
              <br><br>
              </form>
            </div>
          </div>
        </div>


        <div class="editteam-main-div">
          <span>Looking for Players:
            <?php
            if ($searchPlayers == "1") {
              echo "<span style='color: #07c900; margin-left:5px;'>✔</span>";
            }else {
              echo "<span style='color: #e60202; margin-left:5px;'>✘</span>";
            }
              ?>
            </span>
              <a onclick="document.getElementById('modal-team-lfp').style.display='block'"><button class="editteam-edit-button">Edit</button></a>
        </div>
        <div class="editteam-main-div">
        <span>Rank:
          <?php
          if ($searchRank == 30) {
            echo "Undefined";
            ?>
            <img class="editteam-div-img" src="rank-images/default.png" alt="">
            <?php
          }else {
            $sql = "SELECT * FROM ranks WHERE idRank = $searchRank";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);

            $rankname = $row['rankname'];
            $rankIMG = $row['image'];

            echo $rankname;
          ?>
          <img class="editteam-div-img" src="rank-images/<?php echo $rankIMG; ?>" alt="">
          <?php
            }
            ?>
          </span>
            <a onclick="document.getElementById('modal-change-ranksearch').style.display='block'"><button class="editteam-edit-button">Edit</button></a>
          </div>
      </td>
    </tr>
  </table>


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

    <table>
      <tr>
        <td class="editteam-title-bar">
          <span class="settings-title">Description</span>
        </td>
      </tr>
      <tr>
        <td class="editteam-main-td">
            <div class="editteam-main-div">
              <?php
              if ($teamInfo == "0") {
                echo "<span class='settings-info-text-c' >No description.</span>";
              }else {
                echo "<span class='settings-info-text-c' >$teamInfo</span>";
              }
              ?>
              <a onclick="document.getElementById('modal-team-desc').style.display='block'"><button class="editteam-edit-button">Edit</button></a>
            </div>
      </td>
    </tr>
  </table>



  <table>
    <tr>
      <td class="editteam-title-bar">
        <span class="settings-title">Players</span>
      </td>
    </tr>
    <tr>
      <td class="editteam-main-td">
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
              <div class="editteam-main-div">
                <img class="editteam-role-img" src="role-images/<?php echo $roleimg; ?>" alt="">
                <span class='editteam-info-text-c'><?php echo $rolename; ?> :</span>
                <a href="https://euw.op.gg/summoner/userName=<?php echo $opggU; ?>" target="_blank" class="settings-opgg"><?php echo $opggU; ?></a>
                <a onclick="document.getElementById('modal-team-player<?php echo $idUserT; ?>').style.display='block'" class="editteam-delete-button" style="float:right;">Kick Player</a>
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
                  <div class="editteam-main-div">
                    <span>No players.</span>
                  </div>
                  <?php
                }
              }
              ?>
      </td>
    </tr>
  </table>

  <table>
    <tr>
      <td class="editteam-title-bar">
        <span class="settings-title">Social Settings</span>
      </td>
    </tr>
    <tr>
      <td class="editteam-main-td">
          <?php
          $sql = "SELECT * FROM tsocial WHERE idTeam = $idTeam;";
          $result = mysqli_query($conn, $sql);
          $row = mysqli_fetch_assoc($result);

          $facebook = $row['facebook'];
          $twitter = $row['twitter'];
          $instagram = $row['instagram'];
          $twitch = $row['twitch'];
          $youtube = $row['youtube'];

          if ($facebook == "0" || $twitter == "0" || $instagram == "0" || $twitch == "0" || $youtube == "0") {
            ?>
          <div class="editteam-main-div">
            <a onclick="document.getElementById('modal-change-social').style.display='block'"><button class="editteam-delete-button">+ Add Social</button></a>
          </div>
          <?php
            }
          ?>
          <?php
            if ($facebook !== "0") {
              echo "<div class='editteam-main-div'>
                    <img src='social-images/facebook.png' height='25' width='25'>
                    <a href='$facebook' class='editteam-social-button' target='_blank'>Facebook</a>";
                    ?>
                    <a onclick="document.getElementById('modal-remove-facebook').style.display='block'" class='editteam-x-button'>&times;</a>
                    <?php
                    echo "</div>";

            }
            if ($twitter !== "0") {
              echo "<div class='editteam-main-div'>
                      <img src='social-images/twitter.png' height='25' width='25'>
                      <a href='$twitter' class='editteam-social-button' target='_blank'>Twitter</a>";
                    ?>
                    <a onclick="document.getElementById('modal-remove-twitter').style.display='block'" class='editteam-x-button'>&times;</a>
                    <?php
                    echo "</div>";

            }
            if ($instagram !== "0") {
              echo "<div class='editteam-main-div'>
                      <img src='social-images/instagram.png' height='25' width='25'>
                      <a href='$instagram' class='editteam-social-button' target='_blank'>Instagram</a>";
                    ?>
                    <a onclick="document.getElementById('modal-remove-instagram').style.display='block'" class='editteam-x-button'>&times;</a>
                    <?php
                    echo "</div>";
            }
            if ($twitch !== "0") {
              echo "<div class='editteam-main-div'>
                      <img src='social-images/twitch.png' height='25' width='25'>
                      <a href='$twitch' class='editteam-social-button' target='_blank'>Twitch</a>";
                    ?>
                    <a onclick="document.getElementById('modal-remove-twitch').style.display='block'" class='editteam-x-button'>&times;</a>
                    <?php
                    echo "</div>";
            }
            if ($youtube !== "0") {
              echo "<div class='editteam-main-div'>
                      <img src='social-images/youtube.png' height='25' width='25'>
                      <a href='$youtube' class='editteam-social-button' target='_blank'>Youtube</a>";
                    ?>
                    <a onclick="document.getElementById('modal-remove-youtube').style.display='block'" class='editteam-x-button'>&times;</a>
                    <?php
                    echo "</div>";
            }
          ?>

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
                      <form class="" action="includes/change-social.inc.php?id=<?php echo $idTeam; ?>" method="post">
                          <img style="margin-left: 20px; margin-bottom:2px;" height="20" width="20" src="social-images/facebook.png" alt="">
                          <span style="color: #eee; line-height: 55px; margin-left:10px;">Facebook</span>
                        <button class="modal-add-social" type="submit" name="confirm-t-facebook">Add</button>
                        <input class="modal-social-textbox" type="text" name="t-facebook-id" placeholder="Insert facebook link here...">
                      </form>
                    </div>
                    <?php
                  }

                  if ($twitter == "0") {
                    ?>
                    <div class="modal-social-midbar">
                      <form class="" action="includes/change-social.inc.php?id=<?php echo $idTeam; ?>" method="post">
                        <img style="margin-left: 20px; margin-bottom:2px;" height="20" width="20" src="social-images/twitter.png" alt="">
                        <span style="color: #eee; line-height: 55px; margin-left:10px;">Twitter</span>
                        <button class="modal-add-social" type="submit" name="confirm-t-twitter">Add</button>
                        <input class="modal-social-textbox" type="text" name="t-twitter-id" placeholder="Insert twitter link here...">
                      </form>
                    </div>
                    <?php
                  }

                  if ($instagram == "0") {
                    ?>
                    <div class="modal-social-midbar">
                      <form class="" action="includes/change-social.inc.php?id=<?php echo $idTeam; ?>" method="post">
                        <img style="margin-left: 20px; margin-bottom:2px;" height="20" width="20" src="social-images/instagram.png" alt="">
                        <span style="color: #eee; line-height: 55px; margin-left:10px;">Instagram</span>
                        <button class="modal-add-social" type="submit" name="confirm-t-instagram">Add</button>
                        <input class="modal-social-textbox" type="text" name="t-instagram-id" placeholder="Insert instagram link here...">
                      </form>
                    </div>
                    <?php
                  }

                  if ($twitch == "0") {
                    ?>
                    <div class="modal-social-midbar">
                      <form class="" action="includes/change-social.inc.php?id=<?php echo $idTeam; ?>" method="post">
                        <img style="margin-left: 20px; margin-bottom:2px;" height="20" width="20" src="social-images/twitch.png" alt="">
                        <span style="color: #eee; line-height: 55px; margin-left:10px;">Twitch</span>
                        <button class="modal-add-social" type="submit" name="confirm-t-twitch">Add</button>
                        <input class="modal-social-textbox" type="text" name="t-twitch-id" placeholder="Insert twitch link here...">
                      </form>
                    </div>
                    <?php
                  }

                  if ($youtube == "0") {
                    ?>
                    <div class="modal-social-midbar">
                      <form class="" action="includes/change-social.inc.php?id=<?php echo $idTeam; ?>" method="post">
                        <img style="margin-left: 20px; margin-bottom:2px;" height="20" width="20" src="social-images/youtube.png" alt="">
                        <span style="color: #eee; line-height: 55px; margin-left:10px;">Youtube</span>
                        <button class="modal-add-social" type="submit" name="confirm-t-youtube">Add</button>
                        <input class="modal-social-textbox" type="text" name="t-youtube-id" placeholder="Insert youtube link here...">
                      </form>
                    </div>
                    <?php
                  }
                  ?>
            </div>
          </div>
        </div>

        <div id="modal-remove-facebook" class="w3-modal">
          <div class="w3-modal-content w3-animate-top">
            <div class="w3-container w3-padding-32">
              <span onclick="document.getElementById('modal-remove-facebook').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
              <form class="" action="includes/change-social.inc.php?id=<?php echo $idTeam; ?>" method="post">
                <br>
                <p class="modal-title">Do you want to remove facebook from your socials?</p>
                <br>
                <button class="modal-confirm-button" type="submit" name="confirm-remove-tfacebook">Confirm</button>
                <button class="modal-confirm-button" type="submit" name="cancel-remove-t-social">Cancel</button>
                <br><br>
              </form>
            </div>
          </div>
        </div>

        <div id="modal-remove-twitter" class="w3-modal">
          <div class="w3-modal-content w3-animate-top">
            <div class="w3-container w3-padding-32">
              <span onclick="document.getElementById('modal-remove-twitter').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
              <form class="" action="includes/change-social.inc.php?id=<?php echo $idTeam; ?>" method="post">
                <br>
                <p class="modal-title">Do you want to remove twitter from your socials?</p>
                <br>
                <button class="modal-confirm-button" type="submit" name="confirm-remove-ttwitter">Confirm</button>
                <button class="modal-confirm-button" type="submit" name="cancel-remove-t-social">Cancel</button>
                <br><br>
              </form>
            </div>
          </div>
        </div>

        <div id="modal-remove-instagram" class="w3-modal">
          <div class="w3-modal-content w3-animate-top">
            <div class="w3-container w3-padding-32">
              <span onclick="document.getElementById('modal-remove-instagram').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
              <form class="" action="includes/change-social.inc.php?id=<?php echo $idTeam; ?>" method="post">
                <br>
                <p class="modal-title">Do you want to remove instagram from your socials?</p>
                <br>
                <button class="modal-confirm-button" type="submit" name="confirm-remove-tinstagram">Confirm</button>
                <button class="modal-confirm-button" type="submit" name="cancel-remove-t-social">Cancel</button>
                <br><br>
              </form>
            </div>
          </div>
        </div>

        <div id="modal-remove-twitch" class="w3-modal">
          <div class="w3-modal-content w3-animate-top">
            <div class="w3-container w3-padding-32">
              <span onclick="document.getElementById('modal-remove-twitch').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
              <form class="" action="includes/change-social.inc.php?id=<?php echo $idTeam; ?>" method="post">
                <br>
                <p class="modal-title">Do you want to remove twitch from your socials?</p>
                <br>
                <button class="modal-confirm-button" type="submit" name="confirm-remove-ttwitch">Confirm</button>
                <button class="modal-confirm-button" type="submit" name="cancel-remove-t-social">Cancel</button>
                <br><br>
              </form>
            </div>
          </div>
        </div>

        <div id="modal-remove-youtube" class="w3-modal">
          <div class="w3-modal-content w3-animate-top">
            <div class="w3-container w3-padding-32">
              <span onclick="document.getElementById('modal-remove-youtube').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
              <form class="" action="includes/change-social.inc.php?id=<?php echo $idTeam; ?>" method="post">
                <br>
                <p class="modal-title">Do you want to remove youtube from your socials?</p>
                <br>
                <button class="modal-confirm-button" type="submit" name="confirm-remove-tyoutube">Confirm</button>
                <button class="modal-confirm-button" type="submit" name="cancel-remove-t-social">Cancel</button>
                <br><br>
              </form>
            </div>
          </div>
        </div>

      </td>
    </tr>
  </table>

  <table>
    <tr>
      <td class="editteam-title-bar">
        <span class="settings-title">Delete Team</span>
      </td>
    </tr>
    <tr>
      <td class="editteam-main-td">
          <div class="editteam-main-div">
          <a onclick="document.getElementById('modal-team-delete').style.display='block'"><button class="editteam-delete-button">Delete Team</button></a>
          </div>
    </td>
  </tr>
</table>

<br><br>




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
          <br><br>
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

<br><br>



</main>

<?php
}else {
  header("Location: index.php");
}
?>

<?php
include 'footer.php';

 ?>
