<?php
include '../includes/header.inc.php';
include '../includes/dbh.inc.php';

$email = $_SESSION['email'];
$pw = $_SESSION['pw'];

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

            <a href="signup-s1.php"><button class="ls-back">◄ Back</button></a>
            <br>

            <form action="includes/signup-s2.inc.php" method="post">
    
                <p class="ls-text">Nation</p>
                <select class="ls-textbox" name="nation">

                    <?php

                        $sql = "SELECT * FROM nation;";
                        $result = mysqli_query($conn, $sql);
                        
                        while($row = mysqli_fetch_array($result)):;
                    ?>
                        <img src="country-images/" alt="">
                        <option value="<?php echo $row['idNation'];?>"><?php echo $row['name'];?></option>

                    <?php 
                    
                        endwhile;
                        
                    ?>

                </select>
                <br>
                
                <p class="ls-text">Role</p>
                <select class="ls-textbox" name="role">

                    <?php

                        $sql = "SELECT * FROM roles WHERE idRole > 0;";
                        $result = mysqli_query($conn, $sql);
                        
                        while($row = mysqli_fetch_array($result)):;
                    ?>
                        <img src="country-images/" alt="">
                        <option value="<?php echo $row['idRole'];?>"><?php echo $row['rolename'];?></option>

                    <?php 
                    
                        endwhile;
                        
                    ?>

                </select>
                <br>

                <button type="submit" class="ls-button" name="submit-s2">Next</button>

            </form>

        </div>

    </div>

</div>

</body>

