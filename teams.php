<?php
include 'includes/menuham.php';
include 'includes/header.inc.php';


if (isset($_SESSION['userId'])) {

$uID = $_SESSION['userId'];

?>

<div class="teams-main-top">
  <table class="teams-main-top-in">
    <tr>
      <td class="teams-main-top-td">
        <p>Teams</p>
      </td>
      <td class="teams-main-top-td">
      <a onclick="document.getElementById('modal-team-create').style.display='block'"><button class="teams-main-top-button">+ Create Team</button></a>
      </td>
    </tr>
  </table>
</div>

<script type="text/javascript">

  function closeAlert(){
    var element = document.getElementById("alerta");
    element.parentNode.removeChild(element);
  }

</script>

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

<div class="teams-main">

  <table class="teams-main-table">
    <?php
    $uID = $_SESSION['userId'];
    $sql = "SELECT * FROM teams WHERE idUsers = $uID;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result); 

    if($result = mysqli_query($conn, $sql)){
      if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_array($result)){
      
      $idTeam = $row['idTeam'];
      $teamTag = $row['TeamTag'];
      $teamName = $row['TeamName'];
      $teamLogo = $row['TeamLogo'];
      $teamNation = $row['nation'];

      $sql2 = "SELECT * FROM nation WHERE idNation = $teamNation;";
      $result2 = mysqli_query($conn, $sql2);
      $row2 = mysqli_fetch_assoc($result2);

      $nationIMG = $row2['image'];        
      ?>
      <tr>
        <td>

      <div class="teams-main-bar">
        <img class="teams-nation" src="country-images/<?php echo $nationIMG; ?>">
        <img src="teams-images/<?php echo $teamLogo; ?>" height="40">
        <span><?php echo $teamTag." - "; ?></span>
        <span><?php echo $teamName; ?></span>
        <a href="editteam.php?id=<?php echo $idTeam; ?>"><button class="teams-button">EDIT TEAM</button></a>
        <a href="team-profile.php?id=<?php echo $idTeam; ?>"><button class="teams-button">PROFILE</button></a>        
      </div>

      </td>
    </tr>
    <?php
        }
      }
    }
    ?>
  </table>

</div>



<div id="modal-team-create" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-padding-32">
      <span onclick="document.getElementById('modal-team-create').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#3FA0EF;">&times;</span>
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
            <span class="team-create-t">Change Nationality</p>
              <select class="modal-change-role" name="nation">
                <?php
                $sql5 = "SELECT * FROM nation;";
                $result5 = mysqli_query($conn, $sql5);
                ?>
                <?php while($row5 = mysqli_fetch_array($result5)):;?>
                  <option  value="<?php echo $row5['idNation'];?>"><?php echo $row5['name'];?></option>
                <?php endwhile;?>
                </select>

            <br><br>
            <button class="modal-confirm-button" type="submit" name="confirm-ct">Confirm</button>
            <br><br>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
}else {
header("Location: index.php");
}
?>