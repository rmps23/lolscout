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

            $getCode = $_GET['idC'];


            $sql1 = "SELECT * FROM teams WHERE inviteCode = '$getCode';";
            $result1 = mysqli_query($conn, $sql1);
            $row1 = mysqli_fetch_assoc($result1);

            $idTeam = $row1['idTeam'];
            $teamname = $row1['TeamName'];
            $teamTag = $row1['TeamTag'];
            $teamLogo = $row1['TeamLogo'];

            ?>
            <div class="teams-main">
              <br>
                <div class="teams-box">
                  <div class="team-box-info">
                        <table width="100%">
                          <tr height="70">
                            <td width="33%">
                            <span class="apply-text">Do you want to accept the invitation to join this team ?</span><br><br>
                            <span class="apply-text"><?php echo $teamTag." | ".$teamname; ?></span><br>
                            <img src="teams-images/<?php echo $teamLogo; ?>" class="tp-team-img"><br><br>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <form action="includes/apply-team.inc.php?id=<?php echo $idTeam; ?>" method="post">
                                <button type="submit" name="enter-team" class="ti-button">Confirm</button>
                              </form>
                            </td>
                          </tr>
                        </table>
                        </div>
                        <br><br>
          </div>
          </div>

          <?php
          }else {
            header("Location: index.php");
          }
          ?>

  </body>
</html>
