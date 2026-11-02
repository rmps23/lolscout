<?php
if (isset($_POST['submit-s3'])) {

require '../../includes/dbh.inc.php';

$email = $_SESSION['email'];
$pw = $_SESSION['pw'];
$nation = $_SESSION['nation'];
$role = $_SESSION['role'];
$code = $_POST['code'];
$sumname = $_POST['sumname'];
$_SESSION['sumname'] = $sumname;


?>

<input type="hidden" id="code" value="<?php echo $code; ?>">
<input type="hidden" id="sumname" value="<?php echo $sumname; ?>">

<script type="text/javascript">

    getID();

    $(function() {
        $('#sumname').on('keypress', function(e) {
            if (e.which == 32){
                console.log('Space Detected');
                return false;
            }
        });
    });

    async function getID(){
        const Sname = document.getElementById("sumname").value;
        const code = document.getElementById("code").value;

        const url = "../../scripts/confirm-summoner.php?id=" + Sname;
        const response = await fetch(url);

        const data = await response.json();
        
        const riotID = data['id'];
        const icon = data['profileIconId'];

        const url2 = "../../scripts/confirm-riotacc.php?id=" + riotID + "&sn=" + Sname + "&code=" + code;
        const response2 = await fetch(url2);

        if (response2.status == 200){

            const data2 = await response2.json();

            if(data2['status'] == 0){

                window.location.replace("../signup-s3.php?error=nocode");

            }else if (data2['status'] == 1) {

                window.location.replace("../signup-s3.php?error=codematch");

            }else if (data2['status'] == 2) {

                window.location.replace("signup-comp.inc.php?idr=" + riotID + "&ic=" + icon);

            }

        }else{

            console.log("Something went wrong!")
            return;
        
        }

    }
</script>

<?php

}else {

    header("Location: ../../index.php");
    exit();

}