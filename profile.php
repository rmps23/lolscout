<?php
include 'includes/menuham.php';
include 'includes/header.inc.php';
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

  <body>
    <?php
        $uID = $_SESSION['userId'];

        $getID = $_GET['id'];

        $sql = "SELECT * FROM users WHERE idUsers = $getID;";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        $idUCode = $row['idUCode'];
        $username = $row['username'];
        $email = $row['email'];
        $profileimg = $row['profileImg'];
        $opgg = $row['opgg'];
        $role = $row['role'];
        $accConfirm = $row['accConfirm'];
        $nation = $row['nation'];
        $Udesc = $row['info'];
        $uIdTeam = $row['idTeam'];

      ?>
      <br><br>
      <div class="profile-main">
        <table style="width:100%;">
          <tr>

            <td style="width: 30%;">
              <div class="profile-card">
                <span class="profile-card-tittle"><?php echo $username; ?></span>
                <br>
                <img class="profile-card-img" src="profile-images/<?php echo $profileimg; ?>">
                <br>
                <div class="profile-card-bar">
                  <?php
                  $sql1 = "SELECT * FROM socials WHERE idUsers = $getID;";
                  $result1 = mysqli_query($conn, $sql1);
                  $row1 = mysqli_fetch_assoc($result1);

                  $facebook = $row1['facebook'];
                  $twitter = $row1['twitter'];
                  $instagram = $row1['instagram'];
                  $twitch = $row1['twitch'];
                  $youtube = $row1['youtube'];

                  if ($facebook != "0") {
                    echo "<a href='$facebook' class='profile-tooltip' target='_blank'>
                          <img class='profile-card-bar-icon' src='social-images/facebook.png'>
                          <span class='profile-tooltiptext'>Facebook</span>
                          </a>";
                  }
                  if ($twitter != "0") {
                    echo "<a href='$twitter' class='profile-tooltip' target='_blank'>
                          <img class='profile-card-bar-icon' src='social-images/twitter.png'>
                          <span class='profile-tooltiptext'>Twitter</span>
                          </a>";
                  }
                  if ($instagram != "0") {
                    echo "<a href='$instagram' class='profile-tooltip' target='_blank'>
                          <img class='profile-card-bar-icon' src='social-images/instagram.png'>
                          <span class='profile-tooltiptext'>Instagram</span>
                          </a>";
                  }
                  if ($twitch != "0") {
                    echo "<a href='$twitch' class='profile-tooltip' target='_blank'>
                          <img class='profile-card-bar-icon' src='social-images/twitch.png'>
                          <span class='profile-tooltiptext'>Twitch</span>
                          </a>";
                  }
                  if ($youtube != "0") {
                    echo "<a href='$youtube' class='profile-tooltip' target='_blank'>
                          <img class='profile-card-bar-icon' src='social-images/youtube.png'>
                          <span class='profile-tooltiptext'>Youtube</span>
                          </a>";
                  }

                  if ($facebook == "0" && $twitter == "0" && $instagram == "0" && $twitch == "0" && $youtube == "0") {
                    echo "<span class='profile-undefined'>•• N/A ••</span>";
                  }
                  ?>

                </div>
                <div class="profile-card-bar">
                  <?php
                  $sql2 = "SELECT * FROM roles WHERE idRole = $role;";
                  $result2 = mysqli_query($conn, $sql2);
                  $row2 = mysqli_fetch_assoc($result2);

                  $rolename = $row2['rolename'];
                  $roleimg = $row2['image'];
                  ?>
                    <img class='profile-role-img' style="margin-bottom:5px;" src='role-images/<?php echo $roleimg; ?>'>
                    <span style="color: #eee; line-height: 43px; margin-left:5px;"><?php echo $rolename; ?></span></span></span>
                </div>
              </div>
              <table width="100%">
                <tr>
                  <td>
                    <div class="profile-card-tc">
                      <span class="profile-card-tittle">Description</span>
                      <br>

                      <div class="profile-card-desc">
                        <span class="profile-desc-text"><?php echo $Udesc; ?></span>
                      </div>
                    </div>
                  </td>
                </tr>
              </table>
            </td>

            <td style="width: 70%;">
              <div class="profile-card-info">
                <span class="profile-card-tittle">User Information</span>
                <br>
                <div class="profile-card-info-bar">
                  <span class="profile-card-subtitle">Username: <span style="color:#999;"><?php echo $username; ?></span></span>
                </div>
                <?php
                if ($accConfirm == "1") {
                 ?>
                <div class="profile-card-info-bar">
                  <span class="profile-card-subtitle">Verified:</span>
                  <span style="margin-left: 6px; color: #07c900;">✔</span>
                </div>
                <div class="profile-card-info-bar">
                  <span class="profile-card-subtitle">OPGG:</span>
                  <a href="https://euw.op.gg/summoner/userName=<?php echo $opgg; ?>" target="_blank" class="profile-opgg-button"><?php echo $opgg; ?></a>
                </div>
                <?php
              }else{
                ?>
                <div class="profile-card-info-bar">
                  <span class="profile-card-subtitle">Verified:</span>
                  <span style="margin-left: 6px; color: #e60202;">✘</span>
                </div>
                <div class="profile-card-info-bar">
                  <span class="profile-card-subtitle">OPGG: <span style="color:#999;">Undefined</span></span>
                </div>
                <?php
                }
                 ?>
                 <div class="profile-card-info-bar">
                   <?php
                   $sql4 = "SELECT * FROM nation WHERE idNation = $nation;";
                   $result4 = mysqli_query($conn, $sql4);
                   $row4 = mysqli_fetch_assoc($result4);

                   if ($nation == "0") {
                     ?>
                     <span class="profile-card-subtitle" style="line-height:42px; margin-left:15px;">Nation: <span style="color:#999;">Undefined</span></span>
                     <?php
                   }else {
                     $nationName = $row4['name'];
                     $nationIMG = $row4['image'];
                     ?>
                     <img class="settings-flag" style="margin-left:15px; margin-bottom:4px;" height="20" width="30" src="country-images/<?php echo $nationIMG; ?>" alt="">
                     <span class="profile-card-subtitle" style="line-height:42px; margin-left:5px;"><span style="color:#999;"><?php echo $nationName; ?></span></span>
                     <?php
                   }
                    ?>

                 </div>
              </div>
              <table width="100%">
                <tr>
                  <td style="width: 50%;">
                    <div class="profile-card-tc" style="text-align:center;">
                      <span class="profile-card-tittle">Team</span>
                      <br>
                      <?php
                      $sql4 = "SELECT * FROM teams WHERE idTeam = $uIdTeam;";
                      $result4 = mysqli_query($conn, $sql4);
                      $row4 = mysqli_fetch_assoc($result4);

                      $teamtag = $row4['TeamTag'];
                      $teamname = $row4['TeamName'];
                      $teamLogo = $row4['TeamLogo'];
                       ?>
                      <div class="profile-card-team-bar">
                        <img src="teams-images/<?php echo $teamLogo; ?>" class="profile-team-icon">
                        <br>
                        <p class="profile-team-name"><?php echo $teamtag; ?></p>
                        <p class="profile-team-name"><?php echo $teamname; ?></p>
                      </div>
                    </div>
                  </td>

                      <?php
                      $sql6 = "SELECT * FROM users WHERE idUsers = $getID;";
                      $result6 = mysqli_query($conn, $sql6);
                      $row6 = mysqli_fetch_assoc($result6);

                      $accConfirm = $row6['accConfirm'];

                      if ($accConfirm == "1") {
                        $sql5 = "SELECT * FROM rankuser WHERE idUser = $getID;";
                        $result5 = mysqli_query($conn, $sql5);
                        $row5 = mysqli_fetch_assoc($result5);

                        $tier = $row5['tier'];
                        $rank = $row5['ranks'];
                        $lp = $row5['LP'];
                        $sumname = $row5['sumname'];
                      ?>
                      <td style="width: 50%;">
                        <div class="profile-card-tc" style="text-align:center;">
                          <span class="profile-card-tittle"><?php echo $sumname; ?></span>
                          <br>

                       <div class="profile-card-team-bar">
                         <img src="rank-images/<?php echo $tier.".png"; ?>" class="profile-rank-icon">
                         <br>
                         <p class="profile-team-name"><?php echo $tier . " " . $rank; ?></p>
                         <p class="profile-team-name"><?php echo $lp . " LP"; ?></p>
                       </div>
                     </div>
                   </td>
                       <?php
                     }else {
                       ?>
                       <td style="width: 50%;">
                       </td>
                       <?php
                     }
                      ?>

                </tr>
              </table>
            </td>

          </tr>
        </table>
      </div>

  </body>
</html>
