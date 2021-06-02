<?php
include 'includes/menuham.php';
 ?>

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


     <div id="main">

        <br><br><br>
         <div class="login-main">
           <a class="login-title">Login</a>
           <br><br><br><br>
           <p>_________________________________________________________________________</p>
           <br><br><br><br>
           <?php
             if (isset($_GET['error'])) {
               if ($_GET['error'] == "emptyfields") {
                 echo '<div class="error-box"> You need to fill all the data. </div>';
               }
               else if ($_GET['error'] == "wrongpwd") {
                 echo '<div class="error-box"> Invalid email or password. </div>';
               }
               else if ($_GET['error'] == "noemail") {
                 echo '<div class="error-box"> Invalid email. </div>';
               }
             }
            ?>
           <form class="" action="includes/login.inc.php" method="post">
             <p class="login-text">Email</p>
             <input type="text" class="login-textbox" name="email-uid">
             <br><br><br>
             <p class="login-text">Password</p>
             <input type="password" class="login-textbox" name="password-uid">
             <br><br><br><br><br>
             <button type="submit" class="login-button" name="login-submit">Login</button>
           </form>

           <form class="" action="includes/login.inc.php" method="post">
             <input type="hidden" class="login-textbox" name="email-uid" value="piss23@gmail.com">
             <input type="hidden" class="login-textbox" name="password-uid" value="test">
             <br><br>
             <button type="submit" class="login-button" name="login-submit">Admin</button>
           </form>
           <br><br><br><br>
           <p>_________________________________________________________________________</p>
           <br><br><br><br>
           <p class="login-text">If you don't have an account,&nbsp;<a href="signup.php">Register</a></p>
         </div>
     </div>

  </body>
</html>
