<?php
include 'includes/header.inc.php';
require 'includes/dbh.inc.php';
?>

<body>
<div class="login-main">

<br>
<span class="login-title">LOGIN</span>
<br>
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


    <br>
    <div class="login-box">
    <span class="login-logo">LOLSCOUT</span><span style="font-size:12px; color:red;">beta</span>
    <br><br>
    <form class="" action="includes/login.inc.php" method="post">
      <?php
        $selector = $_GET["selector"];
        $validator = $_GET["validator"];

        if (empty($selector) || empty($validator)) {
          echo "Could not validate your request!";
        }else {
          if (ctype_xdigits($selector) !== false && ctype_xdigits($validator) !== false) {
            ?>
            <form action="includes/reset-password.inc.php" method="post">
              <input type="hidden" name="selector" value="<?php echo $selector ?>">
              <input type="hidden" name="validator" value="<?php echo $validator ?>">
              <input type="password" name="pwd" value="Enter a new password...">
              <input type="password" name="pwd-repeat" value="Repeat a new password...">
              <button type="submit" name="reset-password-submit">Reset Password</button>
            </form>


            <?php
          }
        }
      ?>

      <br>
      <p class="login-text">Change Password</p>
      <br>
      <input class="login-textbox" type="password" name="password" placeholder="Insert new password">
      <br><br>
      <input class="login-textbox" type="password" name="password-cf" placeholder="Confirm new password">
      <br><br>
      <button class="login-button" type="submit" name="confirm-change-pw">Confirm</button>
      <br><br>
    </form>


    <a href="index.php" class="login-back">◄ Back</a>
  </div>
</div>
</body>
