<?php
include 'header.inc.php';
require 'dbh.inc.php';


$email = $_GET['email'];
?>


<body>
<div class="login-main">
<br>

<div class="login-box" style="text-align: center;">
  <form class="" action="change-pw.inc.php" method="post">
    <br>
    <p class="modal-title">Change Password</p>
    <br>
    <input class="modal-textbox" type="password" name="password" placeholder="Insert new password">
    <br><br>
    <input class="modal-textbox" type="password" name="password-cf" placeholder="Confirm new password">
    <br><br>
    <input class="modal-textbox" type="hidden" name="email" value="<?php echo $email; ?>">
    <button class="modal-confirm-button" type="submit" name="change-pw-req">Confirm</button>
    <br><br>
  </form>
</div>

</div>
</body>
