<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css">
    <script src="scripts/menu.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@600&display=swap" rel="stylesheet">
    <title>Project A</title>
  </head>
  <body>
    <?php
    include 'includes/menuham.php';
     ?>

    <div id="main">

        <br>
        <div class="signup-main">
          <br>
          <a class="login-title">Signup</a>
          <br><br><br>
          <p>_________________________________________________________________________</p>
          <br><br><br>
          <?php


            if (isset($_GET['error'])) {
              if ($_GET['error'] == "emptyfields") {
                echo '<div class="error-box"> You need to fill all the data. </div>';
              }
              else if ($_GET['error'] == "invalidemailusn") {
                echo '<div class="error-box"> Invalid username and email. </div>';
              }
              else if ($_GET['error'] == "invalidemail") {
                echo '<div class="error-box"> Invalid email. </div>';
              }
              else if ($_GET['error'] == "invalidusn") {
                echo '<div class="error-box"> Invalid username. </div>';
              }
              else if ($_GET['error'] == "passowordcheck") {
                echo '<div class="error-box"> Invalid password check. </div>';
              }
              else if ($_GET['error'] == "usertaken") {
                echo '<div class="error-box"> Username is already taken. </div>';
              }
              else if ($_GET['error'] == "emailtaken") {
                echo '<div class="error-box"> Email is already taken. </div>';
              }
            }

           ?>
          <form class="" action="includes/signup.inc.php" method="post">
            <p class="signup-text">Username</p>
            <input type="text" class="signup-textbox" name="username-uid">
            <br><br>
            <p class="signup-text">Email</p>
            <input type="text" class="signup-textbox" name="email-uid">
            <br><br>
            <p class="signup-text">Password</p>
            <input type="password" class="signup-textbox" name="password-uid">
            <br><br>
            <p class="signup-text">Repeat Password</p>
            <input type="password" class="signup-textbox" name="rpassword-uid">
            <br><br><br><br>
            <button type="submit" class="signup-button" name="signup-submit">Signup</button>
          </form>
          <br><br><br>
          <p>_________________________________________________________________________</p>
          <br><br><br>
          <p class="login-text">If you already have an account,&nbsp;<a href="login.php">Login</a></p>
        </div>
    </div>




  </body>
</html>
