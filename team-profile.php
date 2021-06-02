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

        $sql = "SELECT * FROM teams WHERE idTeam = $getID";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        $teamTag = $row['TeamTag'];
        $teamName = $row['TeamName'];
        $searchRank = $row['SearchRank'];
        $searchPlayers = $row['SearchPlayers'];
        $teamLogo = $row['TeamLogo'];
        $teamInfo = $row['TeamInfo'];


        $sql1 = "SELECT * FROM ranks WHERE idRank = $searchRank";
        $result1 = mysqli_query($conn, $sql1);
        $row1 = mysqli_fetch_assoc($result1);




      ?>
      <br><br>
      <div class="profile-main">
        <table style="width:100%;">
          <tr>
            <td>
              <div class="tp-main">
                <table width="100%">
                  <tr>
                    <td width="48%">
                      <div class="tp-card">
                        <span class="tp-title"><?php echo $teamTag." | ".$teamName; ?></span>
                        <br>
                        <img src="teams-images/<?php echo $teamLogo; ?>" class="tp-team-img">
                      </div>
                    </td>
                    <td width="48%">
                      <div class="tp-card">
                        <?php
                          if ($searchRank == 30) {
                            ?>
                            <span class="tp-title">Undefined</span>
                            <br>
                            <img src="rank-images/default.png" class="tp-rank-img">
                            <?php
                          }else {
                            $rankname = $row1['rankname'];
                            $rankIMG = $row1['image'];
                            ?>
                            <span class="tp-title"><?php echo $rankname; ?></span>
                            <br>
                            <img src="rank-images/<?php echo $rankIMG; ?>" class="tp-rank-img">
                            <?php
                          }
                         ?>

                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td width="100%" colspan="2">
                      <div class="tp-card-info"><br>
                        <span class="tp-title" style="margin-left:20px;">Description</span>
                        <br>
                        <div style="margin:20px; text-decoration:justify;">
                          <span class="tp-desc-text">
                            <?php
                            if ($teamInfo == "0") {
                              echo "N/D";
                            }else {
                              echo $teamInfo;
                            }
                             ?>
                          </span>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td width="100%" colspan="2">
                      <div class="tp-card-info"><br>
                        <span class="tp-title" style="margin-left:20px;">Team Members</span>
                        <br>
                        <div style="text-decoration:justify;">
                          <?php
                          $sql1 = "SELECT * FROM users WHERE idTeam = $getID;";
                          $result1 = mysqli_query($conn, $sql1);
                          $row1 = mysqli_fetch_assoc($result1);

                          if($result1 = mysqli_query($conn, $sql1)){
                            if(mysqli_num_rows($result1) > 0){
                            while($row1 = mysqli_fetch_array($result1)){

                              $opggU = $row1['opgg'];
                              $roleU = $row1['role'];
                              $idUserT = $row1['idUsers'];
                              $idUs = $row1['idUsers'];
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
                              <div class="tp-info-midbox-player">

                                <img class="editteam-role-img" style="margin-bottom:2px;" src="role-images/<?php echo $roleimg; ?>" alt="">
                                <span class='editteam-info-text-c' style="line-height:50px;  margin-left:10px;"><?php echo $rolename; ?> :</span>
                                <span class='editteam-info-text-c'><?php echo $username; ?></span>
                                <?php
                                  if ($opggU != "0") {
                                    ?>
                                    <a href="https://euw.op.gg/summoner/userName=<?php echo $opggU; ?>" target="_blank" style="margin-left:10px;" class="editteam-opgg-button"><?php echo $opggU; ?></a>
                                    <?php
                                  }
                                 ?>
                                 <?php
                                 if ($nation == "0") {
                                   ?>
                                   <img class="tp-flag" height="20" width="30" src="country-images/default.png" alt="">
                                   <?php
                                 }else {
                                   $nationIMG = $row4['image'];
                                   ?>
                                   <img class="tp-flag" height="20" width="30" src="country-images/<?php echo $nationIMG; ?>" alt="">
                                   <?php
                                 }
                                  ?>

                                <br>
                              </div>
                              <?php
                            }
                          }else {
                            ?>
                            <div class="tp-info-midbox-player">
                              <span class='editteam-info-text-c' style="line-height:50px;">This team has no members yet!</span>
                            </div>
                            <?php
                          }
                        }
                          ?>

                        </div>
                      </div>
                    </td>
                  </tr>
                </table>
              </div>
            </td>
          </tr>
        </table>
      </div>

  </body>
</html>
