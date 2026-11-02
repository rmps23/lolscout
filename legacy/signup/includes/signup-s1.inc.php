<?php
if (isset($_POST['submit-s1'])) {
    require '../../includes/dbh.inc.php';

    $email = $_POST['email-uid'];
    $pw = $_POST['password-uid'];
    $rpw = $_POST['rpassword-uid'];

    $_SESSION['email'] = $email;
    $_SESSION['pw'] = $pw;

    $sql = "SELECT * FROM users WHERE email = '$email';";
    $result = mysqli_query($conn, $sql);
    $rownum = mysqli_num_rows($result);

    if (empty($email) || empty($pw) || empty($rpw)) {

        header("Location: ../signup-s1.php?e=emptyfields");
        exit();

    }else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        header("Location: ../signup-s1.php?e=invalidemail");
        exit();

    }else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {

        header("Location: ../signup-s1.php?e=invalidusn");
        exit();

    }else if ($pw !== $rpw) {

        header("Location: ../signup-s1.php?e=passowordcheck");
        exit();
    
    }else if ($rownum > 0) {

        header("Location: ../signup-s1.php?e=emailtaken");
        exit();
    
    }else{
        
        header("Location: ../signup-s2.php");
        exit();

    }

}else {

    header("Location: ../../index.php");
    exit();

}