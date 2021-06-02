<?php

include 'includes/menuham.php';
include 'includes/header.inc.php';
require 'includes/dbh.inc.php';

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

  <body>

        <?php
          if (isset($_SESSION['userId'])) {

            $uID = $_SESSION['userId'];

          ?>

          <br>
          <div class="st-main">
            <table style="width: 100%;">
              <tr>
                <td style="width: 30%">
                  <div class="st-box">
                    <span class="st-title">Filter by Name</span>
                    <form action="includes/searchteam.inc.php" method="post" target="lista">
                    <div class="st-box-bar">
                      <input class="st-textbox" type="text" name="word-s" placeholder="Insert Team Name" maxlength="50">
                      <br>
                      <button class="st-button" type="submit" name="word-search">Search</button>
                    </div>
                    <br>
                    <span class="st-title">Filter by Role/Rank</span>
                    <div class="st-box-bar">
                      <br>
                      <span>Role</span>
                      <br>
                      <select class="modal-change-role" name="role">
                        <?php
                        $sql4 = "SELECT * FROM roles WHERE idRole > 0;";
                        $result4 = mysqli_query($conn, $sql4);
                        ?>
                        <?php while($row4 = mysqli_fetch_array($result4)):;?>
                         <option value="<?php echo $row4['idRole'];?>"><?php echo $row4['rolename'];?></option>
                        <?php endwhile;?>
                      </select>
                      <br>
                      <br>
                      <p>Minimum Rank Required</p>
                      <select class="modal-change-role" name="rank">
                        <?php
                        $sql5 = "SELECT * FROM ranks;";
                        $result5 = mysqli_query($conn, $sql5);
                        ?>
                       <?php while($row5 = mysqli_fetch_array($result5)):;?>
                         <option selected value="<?php echo $row5['idRank'];?>"><?php echo $row5['rankname'];?></option>
                        <?php endwhile;?>

                      </select>
                      <br><br>
                      <button class="st-button" type="submit" name="rR">Search</button>
                      <br>
                    </div>
                    <br>
                    <span class="st-title">Filter by Only Available/Role</span>
                    <div class="st-box-bar">
                      <br>
                      <span>Role</span>
                      <br>
                      <select class="modal-change-role" name="role2">
                        <?php
                        $sql4 = "SELECT * FROM roles WHERE idRole > 0;";
                        $result4 = mysqli_query($conn, $sql4);
                        ?>
                        <?php while($row4 = mysqli_fetch_array($result4)):;?>
                         <option value="<?php echo $row4['idRole'];?>"><?php echo $row4['rolename'];?></option>
                        <?php endwhile;?>
                      </select>
                      <br><br>
                      <button class="st-button" type="submit" name="onlyA">Search</button>
                      <br>
                    </div>

                    </form>
                  </div>
                </td>
                <td style="width: 70%;">
                  <div class="st-box">
                    <span class="st-title" >Search</span>
                    <?php
                    $sql3 = "SELECT * FROM apply WHERE idUser = $uID;";
                    $result3 = mysqli_query($conn, $sql3);
                    $numrow = mysqli_num_rows($result3);

                     ?>
                    <span class="st-title" style="float: right;">Applied: <?php echo $numrow; ?>/3</span>
                    <br>
                    <p style="color: #eee; vertical-align: middle; margin-bottom:10px;"><img width="16" height="16" src="images/infoimg.png" alt=""> &nbsp;NOTE: You can only apply for a team if your rank is the minimum required choosen from the team.</p>
                        <?php
                        $sql2 = "SELECT * FROM users WHERE idUsers = $uID;";
                        $result2 = mysqli_query($conn, $sql2);
                        $row2 = mysqli_fetch_assoc($result2);

                        $aC = $row2['accConfirm'];

                        if ($aC == 0) {
                          ?>
                          <div class="st-acc-box">
                            <span style="color: #eee;">
                          <?php
                          echo "You have to confirm your League of Legends account to be able to aply for teams!";
                          ?>
                        </span>
                      </div>
                          <?php
                        }
                         ?>


                    <iframe name="lista" width="100%" height="700px" src="includes/searchteam.inc.php">
                  </div>
                </td>
              </tr>
            </table>
          </div>


          <?php
          }else {
            header("Location: index.php");
          }
          ?>

  </body>
</html>
