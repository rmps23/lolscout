<?php
include 'includes/menuham.php';
include 'includes/header.inc.php';
?>

<?php
  if (isset($_SESSION['userId'])) {

    $uID = $_SESSION['userId'];

    $sql = "SELECT * FROM apply WHERE idUser = $uID;";
    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);

    ?>

    <main>

      <div class="apply-main">
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

        <br>
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
        $teamNation = $row1['nation'];


        $sql2 = "SELECT * FROM ranks WHERE idRank = $sR;";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);

        $rankIMG = $row2['image'];
        $rankname = $row2['rankname'];

        ?>
        
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

        <table class="apply-bar">
          <tr>
            <td class="apply-top-box"><?php echo $teamname; ?></td>
            <td class="apply-top-box"><?php echo $rankname; ?></td>
            <td class="apply-top-box">Nation</td>
            <td class="apply-top-box">Options</td>
          </tr>
          <tr>
            <td class="apply-box"><img height="80" width="80" src="teams-images/<?php echo $teamLogo; ?>" alt=""></td>
            <td class="apply-box"><img height="80" width="80" src="rank-images/<?php echo $rankIMG; ?>"></td>
            <td class="apply-box">
              <?php
              $sql2 = "SELECT * FROM nation WHERE idNation = $teamNation;";
              $result2 = mysqli_query($conn, $sql2);
              $row2 = mysqli_fetch_assoc($result2);

              $nationName = $row2['name'];
              $nationIMG = $row2['image'];
              ?>
              <img class="not-nation" src="country-images/<?php echo $nationIMG; ?>" alt="">
              <br>
              <span style="font-size: 14px; color: #ccc;"><?php echo $nationName; ?></span>
            </td>

            <td class="apply-box">

              <a href="team-profile.php?id=<?php echo $idTeam; ?>"><button class="apply-table-minibut" style="margin-bottom: 10px;">View Team</button></a>
              <a onclick="document.getElementById('modal-apply-<?php echo $idTeam; ?>').style.display='block'"><button class="apply-table-minibut">Cancel</button></a>

                <div id="modal-apply-<?php echo $idTeam; ?>" class="w3-modal">
                  <div class="w3-modal-content w3-animate-top">
                    <div class="w3-container w3-padding-32">
                      <span onclick="document.getElementById('modal-apply-<?php echo $idTeam; ?>').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
                      <form class="" action="includes/apply-team.inc.php?ida=<?php echo $idApply; ?>" method="post">
                        <br>
                        <p class="modal-title">Do you want to cancel the application for <?php echo $teamname; ?>?</p>
                        <br>
                        <img width="150" height="150" src='teams-images/<?php echo $teamLogo; ?>'>
                        <br><br>
                        <br>
                        <button style="width:100px;" type="submit" name="apply-cancel">Confirm</button>&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="cursor:pointer; color:#eee;" onclick="document.getElementById('modal-apply-<?php echo $idTeam; ?>').style.display='none'">Cancel</span>
                        <br><br>
                      </form>
                    </td>
                  </div>
                </div>
              </div>

            </td>
          </tr>
        </table>


  <?php
    }
  }else {
  ?>
  <div class="apply-table-no-applies">
    <span>You didn't apply for any team yet.</span>
  </div>
  <?php
  }
  ?>
  </div>

</main>

<?php
}else {
  header("Location: index.php");
}
?>

<?php
include 'footer.php';

 ?>
