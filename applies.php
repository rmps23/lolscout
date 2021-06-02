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

            $sql = "SELECT * FROM apply WHERE idUser = $uID;";
            $result = mysqli_query($conn, $sql);
            $num_rows = mysqli_num_rows($result);

            ?>
            <div class="teams-main">
              <br>
                <div class="teams-box">

            <?php
            if ($num_rows > 0) {
              while($row = mysqli_fetch_array($result)) {


                $idApply = $row['idApply'];
                $idTeam = $row['idTeam'];

                $sql1 = "SELECT * FROM teams WHERE idTeam = $idTeam;";
                $result1 = mysqli_query($conn, $sql1);
                $row1 = mysqli_fetch_assoc($result1);

                $teamLogo = $row1['TeamLogo'];
                $teamname = $row1['TeamName'];
                $sR = $row1['SearchRank'];

                $sql2 = "SELECT * FROM ranks WHERE idRank = $sR;";
                $result2 = mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_assoc($result2);

                $rankIMG = $row2['image'];
                $rankname = $row2['rankname'];



                ?>
                  <div class="team-box-info">
                        <table width="100%">
                          <tr height="70">
                            <td width="33%"><span class="apply-text"><?php echo $teamname; ?></span></td>
                            <td width="33%"><span class="apply-text"><?php echo $rankname; ?></span></td>
                            <td width="33%"><span class="apply-text">Options</span></td>
                          </tr>
                          <tr>
                            <td width="33%"><img height="80" width="80" src="teams-images/<?php echo $teamLogo; ?>" alt=""></td>
                            <td width="33%"><img height="80" width="80" src="rank-images/<?php echo $rankIMG; ?>"</td>
                            <td>
                              <form action="includes/apply-team.inc.php?ida=<?php echo $idApply; ?>" method="post">
                                <a onclick="document.getElementById('modal-apply-<?php echo $idTeam; ?>').style.display='block'" class='apply-cancel'>Cancel</a>

                                <div id="modal-apply-<?php echo $idTeam; ?>" class="w3-modal">
                                  <div class="w3-modal-content w3-animate-top">
                                    <div class="w3-container w3-padding-32">
                                      <span onclick="document.getElementById('modal-apply-<?php echo $idTeam; ?>').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
                                      <form class="" action="apply-team.inc.php?ida=<?php echo $idApply; ?>" method="post">
                                        <br>
                                        <p class="modal-title">Do you want to cancel the application for <?php echo $teamname; ?>?</p>
                                        <br>
                                        <img class='st-bar-img' src='teams-images/<?php echo $teamLogo; ?>'>
                                        <br><br>
                                        <br>
                                        <button class="st-conf-apply" type="submit" name="apply-cancel">Confirm</button>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span style="cursor:pointer; color:#eee;" onclick="document.getElementById('modal-apply-<?php echo $idTeam; ?>').style.display='none'">Cancel</span>
                                        <br><br>
                                       </form>
                                     </td>
                                  </div>
                                </div>
                              </div>
                            </form>
                          </tr>
                        </table>
                        </div>
                        <br><br>
                <?php


              }
            }else {
              echo "You didn't apply for any team yet.";
            }
            ?>

          </div>
          </div>
            <?php

          ?>




          <div id="modal-team-create" class="w3-modal">
            <div class="w3-modal-content w3-animate-top">
              <div class="w3-container w3-padding-32">
                <span onclick="document.getElementById('modal-team-create').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
                <div>
                  <div class="upload-box">
                    <form class="" action="includes/create-team.inc.php" method="post">
                      <br>
                      <span class="team-create-t">TAG</span>
                      <br>
                      <input style="text-align: center;  text-transform: uppercase;" class="modal-textbox" type="text" name="teamtag-uid" maxlength="4" placeholder="Insert Team TAG">
                      <br><br>
                      <span class="team-create-t">Team Name</span>
                      <br>
                      <input style="text-align: center;" class="modal-textbox" type="text" name="teamname-uid" maxlength="25" placeholder="Insert Team Name">
                      <br><br>
                      <button class="modal-confirm-button" type="submit" name="confirm-ct">Confirm</button>
                      <br><br>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>

<br><br>

          <?php
          }else {
            header("Location: index.php");
          }
          ?>

  </body>
</html>
