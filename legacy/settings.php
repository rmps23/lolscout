<?php
include 'includes/menuham.php';
include 'includes/header.inc.php';
require 'includes/dbh.inc.php';

if (isset($_SESSION['userId'])) {
?>

<!DOCTYPE html>

<div class="set-main-top">
  <table class="set-main-top-in">
    <tr>
      <td class="set-main-top-td">
        <p>Settings</p>
      </td>
      <td class="set-main-top-td">
        <a href="settings/delacc.php" target="settiframe"><button class="set-main-top-button">Delete Account</button></a>
        <a href="settings/socset.php" target="settiframe"><button class="set-main-top-button">Social Settings</button>
        <a href="settings/lolset.php" target="settiframe"><button class="set-main-top-button">League of Legends Settings</button>
        <a href="settings/accset.php" target="settiframe"><button class="set-main-top-button">Account Settings</button>
      </td>
    </tr>
  </table>
</div>

<div class="set-main">
  <iframe class="set-iframe" name="settiframe" src="settings/accset.php" frameborder="0"></iframe>
</div>

<?php
}else {
  header("Location: index.php");
}
?>