<?php
session_start();
require 'dbh.inc.php';

if (isset($_SESSION['userId'])) {

  $uID = $_SESSION['userId'];
  $sql = "SELECT * FROM users WHERE idUsers = $uID;";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);

  $profileimg = $row['profileImg'];
  $accConfirm = $row['accConfirm'];

  $sql = "SELECT * FROM apply WHERE idTeamUser = $uID;";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $rowcount = mysqli_num_rows($result);

?>

<div class="navbar">
  <span class="navbar-button-sidemenu" onclick="openNav()" id="burger">&#9776;</span>&nbsp;&nbsp;
  <a href="index.php" class="navbar-logo">LOLSCOUT</a>
  <a class="navbar-link" href="includes/logout.inc.php">Logout</a>
</div>

<div id="mySidenav" class="sidenav">
  <ul>
    <li>
    <a href="profile.php?id=<?php echo $uID; ?>">Profile</a>
    <br>
    <a href="search-team.php">Search Teams</a>
    <a href="notification.php">Notifications&nbsp;&nbsp;<span class="badge" style="color: #6BD0FF;"><?php echo $rowcount; ?></span></a>
    <br>
    <a href="applies.php">My Applies</a>
    <a href="teams.php">My Teams</a>
    <br>
    <a href="favorites.php">Favorites</a>
    <br>
    <a href="settings.php">Settings</a>
    </li>
  </ul>
</div>

<script>
  function openNav() {
    var menu = document.getElementById("mySidenav").style.width;

    if (menu == "250px") {
      document.getElementById("mySidenav").style.width = "0";
      document.getElementById("burger").style.color = "#eee";
    }else {
      document.getElementById("mySidenav").style.width = "250px";
      document.getElementById("burger").style.color = "#1F2123";
    }

  }
</script>

<?php

  if ($accConfirm == "0") {
    include 'includes/riotaccount.php';
  }

}else {
?>

<div class="navbar">
  <a href="index.php" class="navbar-logo">LOLSCOUT <span style="font-size:12px; color:red;">beta</span></a>
  <a class="navbar-link" href="signup.php">Signup</a>
  <a class="navbar-link" href="login.php">Login</a>
  <div class="dropdown">
    <a class="dropbtn">&#9776;</a>
      <div class="dropdown-content">
        <a href="login.php">Login</a>
        <a href="signup.php">Signup</a>
      </div>
  </div>
</div>

<?php
}
?>

<br>
