<?php
include 'includes/menuham.php';
include 'includes/header.inc.php';
?>

<script type="text/javascript">
  function closeAlert(){
    var element = document.getElementById("alerta");
    element.parentNode.removeChild(element);
  }
</script>

<div class="not-main">

<?php

if (isset($_SESSION['userId'])) {

  $uID = $_SESSION['userId'];

  $sql = "SELECT * FROM apply WHERE idTeamUser = $uID;";
  $result2 = mysqli_query($conn, $sql);
  $num_rows = mysqli_num_rows($result2);


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
    $teamNation = $row['nation'];

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

    $sql = "SELECT * FROM nation WHERE idNation = $teamNation;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    $nationName = $row['name'];
    $nationIMG = $row['image'];


    ?>

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

<table class="not-table">
  <tr>
    <td class="not-table-topbar"><?php echo $username; ?></td>
    <td class="not-table-topbar">Team</td>
    <td class="not-table-topbar">Nation</td>
    <td class="not-table-topbar">Options</td>
  </tr>
  <tr>
    <td class="not-table-botbar">

      <a href="profile.php?id=<?php echo $idUApplier; ?>">
      <div class="not-table-minibar">
        <span style=" color: #111;">Profile</span>
      </div>
      </a>

      <a href="https://euw.op.gg/summoner/userName=<?php echo $opgg; ?>">
      <div class="not-table-minibar" style="background-color:#007de3; margin-top: 12px;">
        <span>OPGG</span>
      </div>
      </a>
    </td>

    <td class="not-table-botbar">
      <img style="margin-bottom:15px;" height="50" width="50" src="teams-images/<?php echo $teamLogo; ?>" alt="">
      <br>
      <span style="font-size: 14px;"><?php echo $teamTag." | ".$teamName; ?></span>
    </td>

    <td class="not-table-botbar">
      <img class="not-nation" src="country-images/<?php echo $nationIMG; ?>" alt="">
      <br>
      <span style="font-size: 14px;"><?php echo $nationName; ?></span>
    </td>

    <td class="not-table-botbar">

      <form action="includes/apply-team.inc.php?idr=<?php echo $idURole; ?>&idt=<?php echo $idTeam; ?>&ida=<?php echo $idApply; ?>" method="post">
        <button type="submit" class="not-table-minibut" name="apply-player" style="margin-bottom: 10px;">Accept</button>
        <button type="submit" class="not-table-minibut" name="apply-cancel2">Decline</button>
      </form>

    </td>
  </tr>
</table>

<?php

}
}else {
?>
<br><br><br>
  <div class="not-no-notification">
    <span>No notifications!</span>
  </div>
<?php
}

?>
</div>
<?php

}else {
  header("Location: index.php");
}

include 'footer.php';

