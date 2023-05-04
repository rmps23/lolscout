<?php
if (isset($_POST['submit-s2'])) {

    require '../../includes/dbh.inc.php';

    $email = $_SESSION['email'];
    $pw = $_SESSION['pw'];

    $nation = $_POST['nation'];
    $role = $_POST['role'];

    $_SESSION['nation'] = $nation;
    $_SESSION['role'] = $role;

    ?>

    <form action="../signup-s3.php" id="s2" method="post">
        <input type="hidden" name="email" value="<?php echo $email; ?>">
        <input type="hidden" name="pw" value="<?php echo $pw; ?>">
        <input type="hidden" name="nation" value="<?php echo $nation; ?>">
        <input type="hidden" name="role" value="<?php echo $role; ?>">
    </form>

    <?php
    
    header("Location: ../signup-s3.php");
    exit();


}else {

    header("Location: ../../index.php");
    exit();

}