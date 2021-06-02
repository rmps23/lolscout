<?php

include 'includes/menuham.php';
include 'includes/header.inc.php';


 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

  <body>

        <?php
          if (isset($_SESSION['userId'])) {

            $uID = $_SESSION['userId'];

            $sql = "SELECT * FROM apply WHERE idTeamUser = $uID;";
            $result2 = mysqli_query($conn, $sql);
            $num_rows = mysqli_num_rows($result2);



            ?>
            <div class="teams-main">
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
                <div class="teams-box">
                  <span class="not-tittle">Notifications</span>
            <?php
            if ($num_rows > 0) {
              while($row = mysqli_fetch_array($result2)) {

                $idApply = $row['idApply'];
                $idUser = $row['idApply'];
                $idURole = $row['idUserRole'];
                $idUApplier = $row['idUser'];

                $idTeam = $row['idTeam'];

                $sql = "SELECT * FROM teams WHERE idTeam = $idTeam;";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);

                $teamTag = $row['TeamTag'];
                $teamName = $row['TeamName'];
                $teamLogo = $row['TeamLogo'];

                $sql = "SELECT * FROM users WHERE idUsers = $idUApplier;";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);

                $username = $row['username'];
                $opgg = $row['opgg'];

                $sql = "SELECT * FROM rankuser WHERE idUser = $idUApplier;";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);

                $tier = $row['tier'];
                $div = $row['ranks'];
                $lp = $row['LP'];
                $idRank = $row['idRank'];

                $sql = "SELECT * FROM ranks WHERE idRank = $idRank;";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);

                $rankIMG = $row['image'];


                ?>
                <br>

                  <div class="not-box">
                        <table width="100%">
                          <tr>
                            <td width="25%" class="not-topic">PROFILE / OPGG</td>
                            <td width="25%" class="not-topic">PLAYER RANK</td>
                            <td width="25%" class="not-topic">TEAM</td>
                            <td width="25%" class="not-topic">OPTIONS</td>
                          </tr>
                        </table>
                        <table width="100%">
                          <tr>
                            <td width="25%">
                              <div class="not-box-bar">
                                <br>
                                <a href="profile.php?id=<?php echo $idUApplier; ?>" class="not-button">Profile - <?php echo $username; ?></a>
                                <br>
                                <br>
                                <a href="https://euw.op.gg/summoner/userName=<?php echo $opgg; ?>" class="not-button">OPGG - <?php echo $opgg; ?></a>
                                <br>
                                <br>
                              </div>
                            </td>
                            <td width="25%">
                              <div class="not-box-bar">
                                <br>
                                <img height="50" width="50" src="rank-images/<?php echo $rankIMG; ?>" alt="">
                                <br>
                                <span style="color: #eee;"><?php echo $tier." ".$div." - ".$lp." LP" ?></span>
                                <br>
                              </div>
                            </td>
                            <td width="25%">
                              <div class="not-box-bar">
                                <br>
                                <img height="50" width="50" src="teams-images/<?php echo $teamLogo; ?>" alt="">
                                <br>
                                <span style="color: #eee;"><?php echo $teamTag." | ".$teamName; ?></span>
                                <br>
                                <br>
                              </div>
                            </td>
                            <td width="25%">
                              <div class="not-box-bar">
                                <br>
                                <form action="includes/apply-team.inc.php?idr=<?php echo $idURole; ?>&idt=<?php echo $idTeam; ?>&ida=<?php echo $idApply; ?>" method="post">
                                  <button type="submit" class="not-buttonv2" name="apply-player">Accept</button>
                                  <button type="submit" class="not-buttonv2" name="apply-cancel2">Decline</button>
                                </form>
                                <br>
                                <br>
                              </div>
                            </td>
                          </tr>
                        </table>
                        </div>
                <?php
              }
            }else {
              echo "No notifications!";
            }
            ?>

          </div>
          </div>

          <?php
          }else {
            header("Location: index.php");
          }
          ?>

  </body>
</html>
