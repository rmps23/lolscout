<?php
include 'includes/header.inc.php';
require 'includes/dbh.inc.php';


$email = $_GET['e'];
?>


<body>

<div class="login-main">
<br>

<div class="login-box">
  <form class="" action="includes/confirm-code.inc.php" method="post">
    <p class="login-text">Insert verification code.</p>
    <br>
    <input type="text" class="login-textbox" name="code" maxlength="8">
    <input type="hidden" name="email" value="<?php echo $email; ?>">
    <br><br>
    <button type="submit" id="search" class="login-button" name="confirm-code">Confirm</button>
    <br>
  </form>
</div>

</div>

</body>
