<?php
include 'includes/header.inc.php';
require 'includes/dbh.inc.php';
?>

<body>

<div class="ls-content">

  <div class="ls-banner">
    <span>LOLSCOUT</span>
  </div>
  <script type="text/javascript">

function closeAlert(){
  var element = document.getElementById("alerta");
  element.parentNode.removeChild(element);
}

</script>

  <div class="ls-main">

        <div class="ls-form">

            <?php
                if (isset($_GET['e'])) {

                $error = $_GET['e'];

                $sql = "SELECT * FROM errors WHERE error = '$error';";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);

                $msg = $row['message'];

                ?>
                <p class="alert-text"><?php echo "Error: ".$msg; ?></p>

                <?php
                }elseif (isset($_GET['i'])) {
                ?>

                <p class="alert-text-success">Success!</p>
                
                <?php
                }
            ?>

            <form action="includes/login.inc.php" method="post">
              <p class="ls-text">Email</p>
              <input type="text" class="ls-textbox" name="email-uid">
              <br><br>
              <p class="ls-text">Password</p>
              <input type="password" class="ls-textbox" name="password-uid">
              <br><br>
              <span class="ls-text">
                If you don't have an account <a href="signup/signup-s1.php">Signup</a>
              </span>
              <br><br>
                <a onclick="document.getElementById('modal-forgot-pw').style.display='block'" class="ls-forgotpw">Forgot password?</a>
              <?php
                if (isset($_GET["reset"])) {
                  if ($_GET["reset"] == "success") {
                    echo '<p>Email sent! You can now check your email inbox.';

                  }
                }
                if (isset($_GET['newpwd'])) {
                  if ($_GET["newpwd" == "passwordupdated"]) {
                    echo '<p>Your password has been reset!</p>';
                  }
                }
              ?>
              <br><br>
              <button type="submit" class="ls-button" name="login-submit">Login</button>
            </form>
        </div>

  </div>

  <div id="modal-forgot-pw" class="w3-modal">
      <div class="w3-modal-content w3-animate-top">
          <div class="w3-container w3-padding-32">
          <span onclick="document.getElementById('modal-forgot-pw').style.display='none'" class="w3-button w3-display-topright" style="font-size:30px; color:#e60202;">&times;</span>
              <p class="sent-notification" ></p>
              <form action="request-pw.php" method="post">
              <br>
              <p class="modal-title">Insert your email</p>
              <br>
              <input class="modal-textbox" type="text" name="email" placeholder="Insert email..." value="">
              <br><br>
              <button class="modal-confirm-button" name="request-email" type="submit" value="Send an Email">Request Password Reset</button>
              <br>
              </form>
          </div>
      </div>
    </div>

</div>

</body>
