<?php
include '../includes/header.inc.php';
include '../includes/dbh.inc.php';

$email = $_SESSION['email'];
$pw = $_SESSION['pw'];
$nation = $_SESSION['nation'];
$role = $_SESSION['role'];
?>

<body>

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
    <p class="alert-text"><?php echo "Error: ".$msg; ?></p>

    <?php
    }elseif (isset($_GET['i'])) {
    ?>

    <p class="alert-text-success">Success!</p>

    <?php
    }
?>

<div class="ls-content">

    <div class="ls-banner">
        <span>LOLSCOUT</span>
    </div>
    
    <div class="ls-main">

        <div class="ls-form">

            <a href="signup-s2.php"><button class="ls-back">◄ Back</button></a>
            <br>

            <form action="includes/signup-s3.inc.php" method="post">
                
                <p class="ls-text">Confirm League of Legends Account</p>
                <input type="text" class="ls-textbox" name="sumname">
                <br>

                <button type="submit" class="ls-button" name="submit-s3">Complete</button>
                <br>

                <?php

                    $uniqueID = uniqid("lolscout");

                ?>

                <br>    
                <p class="ls-text">Code: <span style="color: #ab0000;"><?php echo $uniqueID; ?></span></p>
                <input type="hidden" name="code" value="<?php echo $uniqueID; ?>">
                <br>

                <p class="ls-text">Insert the code above in your client and save: Settings > About > Verification.</p>
                <br>
                <p class="ls-text">Insert your summoner name above and click on confirm button.</p>
                <br>
                <img class="ls-tpimg" src="../../images/thirdparty.png">

            </form>

        </div>

    </div>

</div>

</body>

