<?php
include 'includes/menuham.php';
include 'includes/header.inc.php';
?>


<?php
  $uID = $_SESSION['userId'];

  $getID = $_GET['id'];

  $sql = "SELECT * FROM teams WHERE idTeam = $getID";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);

  $teamTag = $row['TeamTag'];
  $teamName = $row['TeamName'];
  $searchRank = $row['SearchRank'];
  $searchPlayers = $row['SearchPlayers'];
  $teamLogo = $row['TeamLogo'];
  $teamInfo = $row['TeamInfo'];
  $teamNation = $row['nation'];



  $sql3 = "SELECT * FROM nation WHERE idNation = '$teamNation';";
  $result3 = mysqli_query($conn, $sql3);
  $row3 = mysqli_fetch_assoc($result3);

  $nationName = $row3['name'];
  $nationIMG = $row3['image'];
?>

<div class="pro-t-main-top">
  <table class="pro-t-main-top-in">
    <tr>
      <td class="pro-t-main-top-td">
        <p><?php echo $teamTag." - ".$teamName; ?></p>
      </td>
    </tr>
  </table>
</div>

<div class="pro-t-main">
  <table class="pro-t-table">
    <tr>
      <td>
        <div class="pro-t-in-logo">
          <img class="pro-t-logo" src="teams-images/<?php echo $teamLogo; ?>">
        </div>
      </td>
      <td rowspan="3" style="width: 70%; 	vertical-align: top;">
        <?php
          $sql = "SELECT * FROM userteam WHERE idTeam = $getID";
          $result = mysqli_query($conn, $sql);
          $row = mysqli_fetch_assoc($result);

          if($result = mysqli_query($conn, $sql)){
            if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
            
            $idUser = $row['idUser'];

            $sql2 = "SELECT * FROM users WHERE idUsers = $idUser";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);

            $idRole = $row2['idRole'];
            $idNation = $row2['idNation'];

            $sql3 = "SELECT * FROM nation WHERE idNation = $idNation";
            $result3 = mysqli_query($conn, $sql3);
            $row3 = mysqli_fetch_assoc($result3);

            $playerNation = $row3['image'];

            $sql4 = "SELECT * FROM riot WHERE idUser = $idUser";
            $result4 = mysqli_query($conn, $sql4);
            $row4 = mysqli_fetch_assoc($result4);

            $opgg = $row4['opgg'];

            $sql5 = "SELECT * FROM rankuser WHERE idUser = $idUser";
            $result5 = mysqli_query($conn, $sql5);
            $row5 = mysqli_fetch_assoc($result5);

            $idRank = $row5['idRank'];

            $sql6 = "SELECT * FROM ranks WHERE idRank = $idRank";
            $result6 = mysqli_query($conn, $sql6);
            $row6 = mysqli_fetch_assoc($result6);

            $rankIMG = $row6['image'];

            $sql7 = "SELECT * FROM roles WHERE idRole = $idRole";
            $result7 = mysqli_query($conn, $sql7);
            $row7 = mysqli_fetch_assoc($result7);

            $roleIMG = $row7['image'];

        ?>
        <div class="pro-t-in-player">
          <img class="pro-t-player-nation" src="country-images/<?php echo $playerNation; ?>">
          <img class="pro-t-player-nation" src="role-images/<?php echo $roleIMG; ?>">
          <span><?php echo $opgg; ?></span>
          <a href="profile.php?id=<?php echo $idUser; ?>"><button class="pro-t-player-button">Profile</button></a>
          <?php
          if($idRank == "0"){
          ?>
            <img class="pro-t-player-rank" src="rank-images/DEFAULT.png">
          <?php
          }else{
          ?>
            <img class="pro-t-player-rank" src="rank-images/<?php echo $rankIMG; ?>">
          <?php
          }
          ?>
        </div>

        <?php
            }
          }
        }
        ?>

      </td>
    </tr>
    <tr>
      <td>
        <div class="pro-t-in-nation">
          <img class="pro-t-nation" src="country-images/<?php echo $nationIMG; ?>">
          <span><?php echo $nationName; ?></span>
        </div>
      </td>
    </tr>
    <tr>
      <td>
        <div class="pro-t-in-info">
          <p>
            <?php
              if($teamInfo == "0"){
                echo "N/A";
              }else {
                echo $teamInfo;
              }
            ?>
          </p>
        </div>
      </td>
    </tr>
  </table>
</div>










































<br><br><br><br><br><br><br>



      <main class="profile-t-main">
        <br><br><br>
        <script type="text/javascript">

          function closeAlert(){
            var element = document.getElementById("alerta");
            element.parentNode.removeChild(element);
          }

        </script>
        <?php
        if(isset($_GET['i'])) {
          ?>
          <div id="alerta" class="alert2">
            <span class="alert-text">Success!</span>
            <span class="closebtn" onclick="closeAlert()">&#10005;</span>
          </div>
          <?php
        }
        ?>

        <?php
        if (isset($_GET['e'])) {
          $error = $_GET['e'];
          if ($error == "roletaken") {
            ?>
            <div id="alerta" class="alert">
              <span class="alert-text">Role is already taken!</span>
              <span class="closebtn" onclick="closeAlert()">&#10005;</span>
            </div>
            <?php
          }
        }
        ?>
        <br>
        <table class="profile-t-table">
          <tr>
            <td class="profile-t-table-td" style="vertical-align: middle;">
              <span><?php echo $teamName; ?></span>
              <br>
              <img src="teams-images/<?php echo $teamLogo; ?>" class="profile-t-table-img">
              <div class="profile-t-table-td-div" style="text-align: left;">
                <img height="30" width="40" src="country-images/<?php echo $nationIMG; ?>">
                <span><?php echo $nationName; ?></span>
              </div>
            </td>
            <td style="width: 70%" class="profile-t-table-td">
              <div class="profile-t-table-mem1">
                <span>Members</span>
              </div>
                <?php
                $sql1 = "SELECT * FROM users WHERE idTeam = $getID;";
                $result1 = mysqli_query($conn, $sql1);
                $row1 = mysqli_fetch_assoc($result1);

                if($result1 = mysqli_query($conn, $sql1)){
                  if(mysqli_num_rows($result1) > 0){
                  while($row1 = mysqli_fetch_array($result1)){

                    $opggU = $row1['opgg'];
                    $roleU = $row1['role'];
                    $idUser = $row1['idUsers'];
                    $nation = $row1['nation'];
                    $username = $row1['username'];

                    $sql4 = "SELECT * FROM nation WHERE idNation = $nation;";
                    $result4 = mysqli_query($conn, $sql4);
                    $row4 = mysqli_fetch_assoc($result4);


                    $sql2 = "SELECT * FROM roles WHERE idRole = $roleU;";
                    $result2 = mysqli_query($conn, $sql2);
                    $row2 = mysqli_fetch_assoc($result2);

                    $rolename = $row2['rolename'];
                    $roleimg = $row2['image'];

                    ?>
                    <div class="profile-t-table-bar">

                    <img height="20" width="20" src="role-images/<?php echo $roleimg; ?>" alt="">
                    <?php
                    if ($nation == "0") {
                      ?>
                      <img class="profile-t-table-flag" height="20" width="30" src="country-images/default.png" alt="">
                      <?php
                    }else {
                      $nationIMG = $row4['image'];
                      ?>
                      <img class="profile-t-table-flag" height="20" width="30" src="country-images/<?php echo $nationIMG; ?>">
                      <?php
                    }
                     ?>
                    <span><?php echo $rolename; ?> :</span>
                    <span><?php echo $username; ?></span>
                    <a href="profile.php?id=<?php echo $idUser; ?>"><button>Profile</button></a>
                    </div>
                    <?php
                  }
                }else {
                  ?>
                  <div class="profile-t-table-bar">
                    <span style="line-height: 35px; font-size: 16px;">This team has no members yet!</span>
                  </div>
                  <?php
                }
              }
                ?>
              </div>

            </td>
          </tr>
          <tr>
            <td class="profile-t-table-td" style="vertical-align: left;">
              <div class="profile-t-table-mem1">
                <span>Socials</span>
              </div>
              <?php
              $sql1 = "SELECT * FROM tsocial WHERE idTeam = $getID;";
              $result1 = mysqli_query($conn, $sql1);
              $row1 = mysqli_fetch_assoc($result1);

              $facebook = $row1['facebook'];
              $twitter = $row1['twitter'];
              $instagram = $row1['instagram'];
              $twitch = $row1['twitch'];
              $youtube = $row1['youtube'];

              if ($facebook != "0") {
                echo "<div class='profile-social-bar'>
                      <img style='margin-left:8px' height='25' width='25' src='social-images/facebook.png'>
                      <a href='$facebook' target='_blank'>
                      <span>Facebook</span>
                      </a>
                      </div>";
              }
              if ($twitter != "0") {
                echo "<div class='profile-social-bar'>
                      <a href='$twitter' target='_blank'>
                      <img style='margin-left:8px' height='25' width='25' src='social-images/twitter.png'>
                      <span>Twitter</span>
                      </a>
                      </div>";
              }
              if ($instagram != "0") {
                echo "<div class='profile-social-bar'>
                      <a href='$instagram' target='_blank'>
                      <img style='margin-left:8px' height='25' width='25' src='social-images/instagram.png'>
                      <span>Instagram</span>
                      </a>
                      </div>";
              }
              if ($twitch != "0") {
                echo "<div class='profile-social-bar'>
                      <a href='$twitch' target='_blank'>
                      <img style='margin-left:8px' height='25' width='25' src='social-images/twitch.png'>
                      <span>Twitch</span>
                      </a>
                      </div>";
              }
              if ($youtube != "0") {
                echo "<div class='profile-social-bar'>
                      <a href='$youtube' target='_blank'>
                      <img style='margin-left:8px' height='25' width='25' src='social-images/youtube.png'>
                      <span>Youtube</span>
                      </a>
                      </div>";
              }

              if ($facebook == "0" && $twitter == "0" && $instagram == "0" && $twitch == "0" && $youtube == "0") {
                echo "<div class='profile-social-bar' style='text-align: center;'>
                      <span class='profile-undefined'>•• N/A ••</span>
                      </div>";
              }
              ?>
                </div>
            </td>
            <td class="profile-t-table-td" style="vertical-align: top;">
              <div class="profile-t-table-mem1">
                <span>Description</span>
              </div>
              <div class='profile-social-bar2'>
                <?php
                if ($teamInfo == "0") {
                  echo "Your team has no description.";
                }else {
                  echo $teamInfo;
                }
                 ?>
              </div>
            </td>
          </tr>
        </table>

      </main>

      <?php
      include 'footer.php';
       ?>
