
<?php

require 'dbh.inc.php';
include 'header.inc.php';
session_start();

$uID = $_SESSION['userId'];

$sql1 = "SELECT * FROM rankuser WHERE idUser = $uID;";
$result1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_assoc($result1);

$rank = $row1['idRank'];



if (isset($_POST['word-search'])) {


  $word = $_POST['word-s'];

  if (empty($word)) {
    ?>
    <table style="width: 100%;">
      <tr>
        <td>
          <div class="st-bar" style="text-align:center; line-height:100px;">
            <?php echo "Search field is empty, try to write something before pressing search!"; ?>
          </div>
        </td>
      </tr>
    </table>
    <?php
  }else{

    $sql = "SELECT * FROM teams WHERE SearchPlayers = '1' AND idUsers != '$uID' AND TeamName LIKE '%$word%' ORDER BY SearchRank;";
    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);

    if ($num_rows > 0) {
      while($row = mysqli_fetch_array($result)) {
        $idT = $row['idTeam'];
        $tag = $row['TeamTag'];
        $teamname = $row['TeamName'];
        $teamlogo = $row['TeamLogo'];
        $sR = $row['SearchRank'];

        $top = $row['idTop'];
        $jungler = $row['idJungler'];
        $mid = $row['idMid'];
        $bot = $row['idBot'];
        $support = $row['idSupport'];
        $coach = $row['idCoach'];
        $analyst = $row['idAnalyst'];
        $manager = $row['idManager'];
        ?>

        <div class="st-bar">
          <?php
            $sql1 = "SELECT * FROM ranks WHERE idRank = $sR;";
            $result1 = mysqli_query($conn, $sql1);
            $row1 = mysqli_fetch_assoc($result1);

            echo "<a href='../team-profile.php?id=$idT' target='_parent'><img class='st-bar-img' src='../teams-images/$teamlogo'></a>";

            if ($sR != "30") {
              $rankname = $row1['rankname'];
              $rankIMG = $row1['image'];
              echo "<img class='st-bar-img-rank' src='../rank-images/$rankIMG'>";
            }else {
              echo "<img class='st-bar-img-rank' src='../rank-images/default.png'>";
            }

            echo "<a href='../team-profile.php?id=$idT' target='_parent' class='st-teamnametag'>$tag&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;$teamname</a>";

            ?>
            <div class="st-tooltip">
              <span class="st-roles">ROLES MISSING</span>
              <span class="st-tooltiptext">
              <?php
              if ($top == "0") {
                echo "<img class='st-bar-img-role' src='../role-images/top.png'>TOP ";
              }
              if($jungler == "0"){
                echo "<img class='st-bar-img-role' src='../role-images/jungler.png'>JUNGLER ";
              }
              if($mid == "0"){
                echo "<img class='st-bar-img-role' src='../role-images/mid.png'>MID ";
              }
              if($bot == "0"){
                echo "<img class='st-bar-img-role' src='../role-images/bot.png'>BOT ";
              }
              if($support == "0"){
                echo "<img class='st-bar-img-role' src='../role-images/support.png'>SUPPORT ";
              }
              if($coach == "0"){
                echo "<img class='st-bar-img-role' src='../role-images/coach.png'>COACH ";
              }
              if($analyst == "0"){
                echo "<img class='st-bar-img-role' src='../role-images/analyst.png'>ANALYST ";
              }
              if($manager == "0"){
                echo "<img class='st-bar-img-role' src='../role-images/manager.png'>MANAGER";
              }
              ?>
              </span>
            </div>

            <?php

            if ($rank <= $sR) {
              $sql1 = "SELECT * FROM apply WHERE idUser = $uID";
              $result1 = mysqli_query($conn, $sql1);
              $numrow2 = mysqli_num_rows($result1);

              if ($numrow2 != 3) {

              $sql1 = "SELECT * FROM apply WHERE idUser = $uID AND idTeam = $idT;";
              $result1 = mysqli_query($conn, $sql1);
              $numrow = mysqli_num_rows($result1);

              if ($numrow > 0 ) {
                echo "<span style='float:right; line-height:100px; margin-right:20px; color:green;'>Already Applied</span>";
              }else {
                ?>
                <a onclick="document.getElementById('modal-apply-<?php echo $idT; ?>').style.display='block'" class='st-apply'>APPLY</a>

                <div id="modal-apply-<?php echo $idT; ?>" class="w3-modal">
                  <div class="w3-modal-content w3-animate-top">
                    <div class="w3-container w3-padding-32">
                      <span onclick="document.getElementById('modal-apply-<?php echo $idT; ?>').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
                      <form class="" action="apply-team.inc.php?idt=<?php echo $idT; ?>" method="post">
                        <br>
                        <p class="modal-title">Do you want to apply for a spot in <?php echo $teamname; ?>?</p>
                        <br>
                        <img class='st-bar-img' src='../teams-images/<?php echo $teamlogo; ?>'>
                        <br><br>
                        <br>
                        <button class="st-conf-apply" type="submit" name="confirm-apply-team">Confirm</button>&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="cursor:pointer;" onclick="document.getElementById('modal-apply-<?php echo $idT; ?>').style.display='none'">Cancel</span>
                        <br><br>
                       </form>
                    </div>
                  </div>
                </div>
                <?php
              }


          }else {
              echo "<span style='float:right; line-height:100px; margin-right:20px; color:#cc0000;'>Can't Apply</span>";
          }
        }
          ?>
          </div>


      <?php
      }
      }else {
      ?>
      <table style="width: 100%;">
        <tr>
          <td>
            <div class="st-bar" style="text-align:center;">
              <?php echo "<span style='line-height: 100px;'>No results!</span>"; ?>
            </div>
          </td>
        </tr>
      </table>
      <?php
      }
    }
}else if (isset($_POST['rR'])) {

  $role = $_POST['role'];
  $minRank = $_POST['rank'];

  if ($role == "1") {
    $role = "idTop";
  }else if ($role == "2") {
    $role = "idJungler";
  }else if ($role == "3") {
    $role = "idMid";
  }else if ($role == "4") {
    $role = "idBot";
  }else if ($role == "5") {
    $role = "idSupport";
  }else if ($role == "6") {
    $role = "idCoach";
  }else if ($role == "7") {
    $role = "idAnalyst";
  }else if ($role == "8") {
    $role = "idManager";
  }


  $sql = "SELECT * FROM teams WHERE SearchPlayers = '1' AND idUsers != '$uID' AND SearchRank <= $minRank AND $role = 0 ORDER BY SearchRank;";
  $result = mysqli_query($conn, $sql);
  $num_rows = mysqli_num_rows($result);

  if ($num_rows > 0) {
    while($row = mysqli_fetch_array($result)) {
      $idT = $row['idTeam'];
      $tag = $row['TeamTag'];
      $teamname = $row['TeamName'];
      $teamlogo = $row['TeamLogo'];
      $sR = $row['SearchRank'];

      $top = $row['idTop'];
      $jungler = $row['idJungler'];
      $mid = $row['idMid'];
      $bot = $row['idBot'];
      $support = $row['idSupport'];
      $coach = $row['idCoach'];
      $analyst = $row['idAnalyst'];
      $manager = $row['idManager'];
      ?>

      <div class="st-bar">
        <?php
          $sql1 = "SELECT * FROM ranks WHERE idRank = $sR;";
          $result1 = mysqli_query($conn, $sql1);
          $row1 = mysqli_fetch_assoc($result1);

          echo "<a href='../team-profile.php?id=$idT' target='_parent'><img class='st-bar-img' src='../teams-images/$teamlogo'></a>";

          if ($sR != "30") {
            $rankname = $row1['rankname'];
            $rankIMG = $row1['image'];
            echo "<img class='st-bar-img-rank' src='../rank-images/$rankIMG'>";
          }else {
            echo "<img class='st-bar-img-rank' src='../rank-images/default.png'>";
          }

          echo "<a href='../team-profile.php?id=$idT' target='_parent' class='st-teamnametag'>$tag&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;$teamname</a>";

          ?>

          <div class="st-tooltip">
            <span class="st-roles">ROLES MISSING</span>
            <span class="st-tooltiptext">
            <?php
            if ($top == "0") {
              echo "<img class='st-bar-img-role' src='../role-images/top.png'>TOP ";
            }
            if($jungler == "0"){
              echo "<img class='st-bar-img-role' src='../role-images/jungler.png'>JUNGLER ";
            }
            if($mid == "0"){
              echo "<img class='st-bar-img-role' src='../role-images/mid.png'>MID ";
            }
            if($bot == "0"){
              echo "<img class='st-bar-img-role' src='../role-images/bot.png'>BOT ";
            }
            if($support == "0"){
              echo "<img class='st-bar-img-role' src='../role-images/support.png'>SUPPORT ";
            }
            if($coach == "0"){
              echo "<img class='st-bar-img-role' src='../role-images/coach.png'>COACH ";
            }
            if($analyst == "0"){
              echo "<img class='st-bar-img-role' src='../role-images/analyst.png'>ANALYST ";
            }
            if($manager == "0"){
              echo "<img class='st-bar-img-role' src='../role-images/manager.png'>MANAGER";
            }
            ?>
            </span>
          </div>

          <?php

          if ($rank <= $sR) {
            $sql1 = "SELECT * FROM apply WHERE idUser = $uID";
            $result1 = mysqli_query($conn, $sql1);
            $numrow2 = mysqli_num_rows($result1);

            if ($numrow2 != 3) {

            $sql1 = "SELECT * FROM apply WHERE idUser = $uID AND idTeam = $idT;";
            $result1 = mysqli_query($conn, $sql1);
            $numrow = mysqli_num_rows($result1);

            if ($numrow > 0 ) {
              echo "<span style='float:right; line-height:100px; margin-right:20px; color:green;'>Already Applied</span>";
            }else {
              ?>
              <a onclick="document.getElementById('modal-apply-<?php echo $idT; ?>').style.display='block'" class='st-apply'>APPLY</a>

              <div id="modal-apply-<?php echo $idT; ?>" class="w3-modal">
                <div class="w3-modal-content w3-animate-top">
                  <div class="w3-container w3-padding-32">
                    <span onclick="document.getElementById('modal-apply-<?php echo $idT; ?>').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
                    <form class="" action="apply-team.inc.php?idt=<?php echo $idT; ?>" method="post">
                      <br>
                      <p class="modal-title">Do you want to apply for a spot in <?php echo $teamname; ?>?</p>
                      <br>
                      <img class='st-bar-img' src='../teams-images/<?php echo $teamlogo; ?>'>
                      <br><br>
                      <br>
                      <button class="st-conf-apply" type="submit" name="confirm-apply-team">Confirm</button>&nbsp;&nbsp;&nbsp;&nbsp;
                      <span style="cursor:pointer;" onclick="document.getElementById('modal-apply-<?php echo $idT; ?>').style.display='none'">Cancel</span>
                      <br><br>
                     </form>
                  </div>
                </div>
              </div>
              <?php
            }


        }else {
            echo "<span style='float:right; line-height:100px; margin-right:20px; color:#cc0000;'>Can't Apply</span>";
        }
      }
        ?>
        </div>


    <?php
    }
  }
}else if (isset($_POST['onlyA'])) {

  $role = $_POST['role2'];



  if ($role == "1") {
    $role = "idTop";
  }else if ($role == "2") {
    $role = "idJungler";
  }else if ($role == "3") {
    $role = "idMid";
  }else if ($role == "4") {
    $role = "idBot";
  }else if ($role == "5") {
    $role = "idSupport";
  }else if ($role == "6") {
    $role = "idCoach";
  }else if ($role == "7") {
    $role = "idAnalyst";
  }else if ($role == "8") {
    $role = "idManager";
  }




  $sql = "SELECT * FROM teams WHERE SearchPlayers = '1' AND idUsers != '$uID' AND SearchRank >= $rank AND $role = 0 ORDER BY SearchRank;";
  $result = mysqli_query($conn, $sql);
  $num_rows = mysqli_num_rows($result);

  if ($num_rows > 0) {
    while($row = mysqli_fetch_array($result)) {
      $idT = $row['idTeam'];
      $tag = $row['TeamTag'];
      $teamname = $row['TeamName'];
      $teamlogo = $row['TeamLogo'];
      $sR = $row['SearchRank'];

      $top = $row['idTop'];
      $jungler = $row['idJungler'];
      $mid = $row['idMid'];
      $bot = $row['idBot'];
      $support = $row['idSupport'];
      $coach = $row['idCoach'];
      $analyst = $row['idAnalyst'];
      $manager = $row['idManager'];
      ?>

      <div class="st-bar">
        <?php
          $sql1 = "SELECT * FROM ranks WHERE idRank = $sR;";
          $result1 = mysqli_query($conn, $sql1);
          $row1 = mysqli_fetch_assoc($result1);

          echo "<a href='../team-profile.php?id=$idT' target='_parent'><img class='st-bar-img' src='../teams-images/$teamlogo'></a>";

          if ($sR != "30") {
            $rankname = $row1['rankname'];
            $rankIMG = $row1['image'];
            echo "<img class='st-bar-img-rank' src='../rank-images/$rankIMG'>";
          }else {
            echo "<img class='st-bar-img-rank' src='../rank-images/default.png'>";
          }

          echo "<a href='../team-profile.php?id=$idT' target='_parent' class='st-teamnametag'>$tag&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;$teamname</a>";
          ?>
          <div class="st-tooltip">
            <span class="st-roles">ROLES MISSING</span>
            <span class="st-tooltiptext">
            <?php
            if ($top == "0") {
              echo "<img class='st-bar-img-role' src='../role-images/top.png'>TOP ";
            }
            if($jungler == "0"){
              echo "<img class='st-bar-img-role' src='../role-images/jungler.png'>JUNGLER ";
            }
            if($mid == "0"){
              echo "<img class='st-bar-img-role' src='../role-images/mid.png'>MID ";
            }
            if($bot == "0"){
              echo "<img class='st-bar-img-role' src='../role-images/bot.png'>BOT ";
            }
            if($support == "0"){
              echo "<img class='st-bar-img-role' src='../role-images/support.png'>SUPPORT ";
            }
            if($coach == "0"){
              echo "<img class='st-bar-img-role' src='../role-images/coach.png'>COACH ";
            }
            if($analyst == "0"){
              echo "<img class='st-bar-img-role' src='../role-images/analyst.png'>ANALYST ";
            }
            if($manager == "0"){
              echo "<img class='st-bar-img-role' src='../role-images/manager.png'>MANAGER";
            }
            ?>
            </span>
          </div>
          <?php

          if ($rank <= $sR) {
            $sql1 = "SELECT * FROM apply WHERE idUser = $uID";
            $result1 = mysqli_query($conn, $sql1);
            $numrow2 = mysqli_num_rows($result1);

            if ($numrow2 != 3) {

            $sql1 = "SELECT * FROM apply WHERE idUser = $uID AND idTeam = $idT;";
            $result1 = mysqli_query($conn, $sql1);
            $numrow = mysqli_num_rows($result1);

            if ($numrow > 0 ) {
              echo "<span style='float:right; line-height:100px; margin-right:20px; color:green;'>Already Applied</span>";
            }else {
              ?>
              <a onclick="document.getElementById('modal-apply-<?php echo $idT; ?>').style.display='block'" class='st-apply'>APPLY</a>

              <div id="modal-apply-<?php echo $idT; ?>" class="w3-modal">
                <div class="w3-modal-content w3-animate-top">
                  <div class="w3-container w3-padding-32">
                    <span onclick="document.getElementById('modal-apply-<?php echo $idT; ?>').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
                    <form class="" action="apply-team.inc.php?idt=<?php echo $idT; ?>" method="post">
                      <br>
                      <p class="modal-title">Do you want to apply for a spot in <?php echo $teamname; ?>?</p>
                      <br>
                      <img class='st-bar-img' src='../teams-images/<?php echo $teamlogo; ?>'>
                      <br><br>
                      <br>
                      <button class="st-conf-apply" type="submit" name="confirm-apply-team">Confirm</button>&nbsp;&nbsp;&nbsp;&nbsp;
                      <span style="cursor:pointer;" onclick="document.getElementById('modal-apply-<?php echo $idT; ?>').style.display='none'">Cancel</span>
                      <br><br>
                     </form>
                  </div>
                </div>
              </div>
              <?php
            }


        }else {
            echo "<span style='float:right; line-height:100px; margin-right:20px; color:#cc0000;'>Can't Apply</span>";
        }
      }
        ?>
        </div>


    <?php
    }
  }
}else {

  $sql = "SELECT * FROM teams WHERE SearchPlayers = '1' AND idUsers != '$uID' ORDER BY SearchRank;";
  $result = mysqli_query($conn, $sql);
  $num_rows = mysqli_num_rows($result);

  if ($num_rows > 0) {
    while($row = mysqli_fetch_array($result)) {
      $idT = $row['idTeam'];
      $tag = $row['TeamTag'];
      $teamname = $row['TeamName'];
      $teamlogo = $row['TeamLogo'];
      $sR = $row['SearchRank'];

      $top = $row['idTop'];
      $jungler = $row['idJungler'];
      $mid = $row['idMid'];
      $bot = $row['idBot'];
      $support = $row['idSupport'];
      $coach = $row['idCoach'];
      $analyst = $row['idAnalyst'];
      $manager = $row['idManager'];
      ?>


            <div class="st-bar">
              <?php
                $sql1 = "SELECT * FROM ranks WHERE idRank = $sR;";
                $result1 = mysqli_query($conn, $sql1);
                $row1 = mysqli_fetch_assoc($result1);

                echo "<a href='../team-profile.php?id=$idT' target='_parent'><img class='st-bar-img' src='../teams-images/$teamlogo'></a>";

                if ($sR != "30") {
                  $rankname = $row1['rankname'];
                  $rankIMG = $row1['image'];
                  echo "<img class='st-bar-img-rank' src='../rank-images/$rankIMG'>";
                }else {
                  echo "<img class='st-bar-img-rank' src='../rank-images/default.png'>";
                }

                echo "<a href='../team-profile.php?id=$idT' target='_parent' class='st-teamnametag'>$tag&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;$teamname</a>";

                ?>
                <div class="st-tooltip">
                  <span class="st-roles">ROLES MISSING</span>
                  <span class="st-tooltiptext">
                  <?php
                  if ($top == "0") {
                    echo "<img class='st-bar-img-role' src='../role-images/top.png'>TOP ";
                  }
                  if($jungler == "0"){
                    echo "<img class='st-bar-img-role' src='../role-images/jungler.png'>JUNGLER ";
                  }
                  if($mid == "0"){
                    echo "<img class='st-bar-img-role' src='../role-images/mid.png'>MID ";
                  }
                  if($bot == "0"){
                    echo "<img class='st-bar-img-role' src='../role-images/bot.png'>BOT ";
                  }
                  if($support == "0"){
                    echo "<img class='st-bar-img-role' src='../role-images/support.png'>SUPPORT ";
                  }
                  if($coach == "0"){
                    echo "<img class='st-bar-img-role' src='../role-images/coach.png'>COACH ";
                  }
                  if($analyst == "0"){
                    echo "<img class='st-bar-img-role' src='../role-images/analyst.png'>ANALYST ";
                  }
                  if($manager == "0"){
                    echo "<img class='st-bar-img-role' src='../role-images/manager.png'>MANAGER";
                  }
                  ?>
                  </span>
                </div>
                <?php



                if ($rank <= $sR) {
                  $sql1 = "SELECT * FROM apply WHERE idUser = $uID";
                  $result1 = mysqli_query($conn, $sql1);
                  $numrow2 = mysqli_num_rows($result1);

                  if ($numrow2 != 3) {

                  $sql1 = "SELECT * FROM apply WHERE idUser = $uID AND idTeam = $idT;";
                  $result1 = mysqli_query($conn, $sql1);
                  $numrow = mysqli_num_rows($result1);

                  if ($numrow > 0 ) {
                    echo "<span style='float:right; line-height:100px; margin-right:20px; color:green;'>Already Applied</span>";
                  }else {
                    ?>
                    <a onclick="document.getElementById('modal-apply-<?php echo $idT; ?>').style.display='block'" class='st-apply'>APPLY</a>

                    <div id="modal-apply-<?php echo $idT; ?>" class="w3-modal">
                      <div class="w3-modal-content w3-animate-top">
                        <div class="w3-container w3-padding-32">
                          <span onclick="document.getElementById('modal-apply-<?php echo $idT; ?>').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
                          <form class="" action="apply-team.inc.php?idt=<?php echo $idT; ?>" method="post">
                            <br>
                            <p class="modal-title">Do you want to apply for a spot in <?php echo $teamname; ?>?</p>
                            <br>
                            <img class='st-bar-img' src='../teams-images/<?php echo $teamlogo; ?>'>
                            <br><br>
                            <br>
                            <button class="st-conf-apply" type="submit" name="confirm-apply-team">Confirm</button>&nbsp;&nbsp;&nbsp;&nbsp;
                            <span style="cursor:pointer;" onclick="document.getElementById('modal-apply-<?php echo $idT; ?>').style.display='none'">Cancel</span>
                            <br><br>
                           </form>
                        </div>
                      </div>
                    </div>
                    <?php
                  }


              }else {
                  echo "<span style='float:right; line-height:100px; margin-right:20px; color:#cc0000;'>Can't Apply</span>";
              }
            }
              ?>
              </div>

    <?php
    }
  }
}
