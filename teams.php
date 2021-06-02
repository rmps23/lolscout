<?php

include 'includes/menuham.php';
include 'includes/header.inc.php';


 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

  <body>

        <?php
          if (isset($_SESSION['userId'])) {


          ?>

          <div class="teams-main">
            <br>
            <?php
              if (isset($_GET['error'])) {
                if ($_GET['error'] == "emptyfields") {
                ?>
                  <div class="alert">
                    <span class="alert-text">Warning! Empty fields.</span>
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                  </div>
                <?php
              }else if ($_GET['error'] == "invalidchar") {
              ?>
                <div class="alert">
                  <span class="alert-text">Warning! Invalid characters.</span>
                  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                </div>
            <?php
              }
            }
            if (isset($_GET['i'])) {
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
            <table style="width: 100%;">
              <tr>
                <td>
                  <div class="teams-box">
                    <a onclick="document.getElementById('modal-team-create').style.display='block'" class="teams-ct-button">+ Create Team</a>

                    <table style="width:100%;">
                      <tr>
                        <?php

                        $uID = $_SESSION['userId'];
                        $sql = "SELECT * FROM teams WHERE idUsers = $uID;";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);

                        $i = 0;

                        if($result = mysqli_query($conn, $sql)){
                          if(mysqli_num_rows($result) > 0){
                          while($row = mysqli_fetch_array($result)){

                            $i++;

                            $idTeam = $row['idTeam'];
                            $teamTag = $row['TeamTag'];
                            $teamName = $row['TeamName'];
                            $searchRank = $row['SearchRank'];
                            $teamLogo = $row['TeamLogo'];
                         ?>
                        <td>
                          <div class="team-box-info">
                            <span class="team-box-tag"><?php echo $teamTag; ?></span>
                            <br>
                            <span class="team-box-name"><?php echo $teamName; ?></span>
                            <br>
                            <img src="teams-images/<?php echo $teamLogo; ?>" class="team-box-img">
                            <br>
                            <a href="team-profile.php?id=<?php echo $idTeam; ?>" class="team-box-bar">PROFILE</a>
                            <br>
                            <br>
                            <a href="editteam.php?id=<?php echo $idTeam; ?>" class="team-box-bar">EDIT TEAM</a>
                          </div>
                          <?php
                          if ($i == 3) {
                            echo "<tr>";
                            $i = 0;
                          }
                           ?>
                        </td>

                      <?php
                          }
                        }
                      }
                       ?>
                       </tr>
                    </table>
                  </div>
                </td>
              </tr>
            </table>
          </div>


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
