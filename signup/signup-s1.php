<?php
include '../includes/header.inc.php';
include '../includes/dbh.inc.php';
?>

<body>

<script type="text/javascript">

    function closeAlert(){
        var element = document.getElementById("alerta");
        element.parentNode.removeChild(element);
    }

</script>

<div class="ls-content">

    <div class="ls-banner">
        <span>LOLSCOUT</span>
    </div>

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
            
            <form action="includes/signup-s1.inc.php" method="post">

                <p class="ls-text">Email</p>
                <input type="text" class="ls-textbox" name="email-uid">
                <br>
                
                <p class="ls-text">Password</p>
                <input type="password" class="ls-textbox" name="password-uid">
                <br>

                <p class="ls-text">Repeat Password</p>
                <input type="password" class="ls-textbox" name="rpassword-uid">
                <br>

                <p class="ls-text">If you already have an account, go to <a href="../login.php">Login</a></p>

                <button type="submit" class="ls-button" name="submit-s1">Next</button>

            </form>

        </div>

    </div>

</div>

</body>
