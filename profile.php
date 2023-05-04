<?php
include 'includes/menuham.php';
include 'includes/header.inc.php';

$uID = $_SESSION['userId'];

$getID = $_GET['id'];

$sql = "SELECT * FROM users WHERE idUsers = $getID;";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$idRole = $row['idRole'];
$idNation = $row['idNation'];
?>

<div class="pro-main-top">
  <table class="pro-main-top-in">
    <tr>
      <td class="pro-main-top-td" style="width: 10%;">
        <?php
          $sql = "SELECT * FROM riot WHERE idUser = $getID;";
          $result = mysqli_query($conn, $sql);
          $row = mysqli_fetch_assoc($result);
        
          $opgg = $row['opgg'];
          $icon = $row['profileImg'];
          $lastUP = $row['lastupdate'];
          $idRiot = $row['idAcc'];
        ?>

        <img class="pro-main-top-img" src="http://ddragon.leagueoflegends.com/cdn/12.3.1/img/profileicon/<?php echo $icon; ?>.png">
      </td>
      <td class="pro-main-top-td" style="width: 50%;">
        <span class="pro-main-top-sumname"><?php echo $opgg; ?></span>
      </td>
      <td class="pro-main-top-td" style="text-align: right;">
        <?php 
        $time = date("d/m/Y - H:i:s",$lastUP)." (UTC+1)";
        $nowtime = strtotime("+6 hours");
        ?>
        <button class="pro-main-top-button" onclick="updateRank()">Update</button>
        <p class="pro-main-top-lastup"><?php echo "Last Update: ".$time; ?></p>
      </td>
    </tr>
  </table>
</div>

<div class="pro-main-mid">

  <table class="pro-main-table">
    <tr>

      <td class="pro-rank">
        <div class="pro-rank-in">
          <?php
            $sql = "SELECT * FROM rankuser WHERE idUser = $getID;";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
          
            $idRank = $row['idRank'];
            $tier = $row['tier'];
            $ranks = $row['ranks'];
            $lp = $row['LP'];

            $sql = "SELECT * FROM ranks WHERE idRank = $idRank;";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);

            $rankimg = $row['image'];

            if($idRank == "0"){
            ?>
            
            <div>
              <img class="pro-mid-rank-img" src="rank-images/DEFAULT.png">
              <br>
              <p>
                UNRANKED
              </p>
            </div>

            <?php
            }else{
            ?>
            <div>
              <img class="pro-mid-rank-img" src="rank-images/<?php echo $rankimg; ?>">
              <br>
              <p>
                <?php echo $tier." ".$ranks." - ".$lp." LP"; ?>
              </p>
            </div>
            <?php
            }
            ?>

          

        </div>
      </td>

      <td class="pro-info">
        <a href="https://euw.op.gg/summoners/euw/<?php echo $opgg; ?>" target="_blank"><div class="pro-info-bar-opgg"><img src="images/opgg.png" height="10"></div></a>
        <?php
        $sql = "SELECT * FROM nation WHERE idNation = $idNation;";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
      
        $nationName = $row['name'];
        $nationIMG = $row['image'];

        $sql = "SELECT * FROM roles WHERE idRole = $idRole;";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        $roleName = $row['rolename'];
        $roleIMG = $row['image'];
        ?>
        <div class="pro-info-bar">
          <img class="pro-info-nation" src="country-images/<?php echo $nationIMG; ?>">
          <span><?php echo $nationName; ?></span>
        </div>
        <div class="pro-info-bar">
          <img class="pro-info-nation" src="role-images/<?php echo $roleIMG; ?>">
          <span><?php echo $roleName; ?></span>
        </div>
      </td>

    </tr>
  </table>

  <table class="pro-main-table">
    <tr>
      <td class="pro-social">
        <div class="pro-social-in">
          <div>
          <?php
          $sql = "SELECT * FROM socials WHERE idUsers = $getID;";
          $result = mysqli_query($conn, $sql);
          $row = mysqli_fetch_assoc($result);

          $facebook = $row['facebook'];
          $twitter = $row['twitter'];
          $instagram = $row['instagram'];
          $twitch = $row['twitch'];
          $youtube = $row['youtube'];

          if ($facebook != "0") {
            echo "<a href='$facebook' target='_blank'>
                  <img class='pro-social-img' src='social-images/facebook.png'>
                  </a>";
          }
          if ($twitter != "0") {
            echo "<a href='$twitter' class='' target='_blank'>
                  <img class='pro-social-img' src='social-images/twitter.png'>
                  </a>";
          }
          if ($instagram != "0") {
            echo "<a href='$instagram' class='' target='_blank'>
                  <img class='pro-social-img' src='social-images/instagram.png'>
                  </a>";
          }
          if ($twitch != "0") {
            echo "<a href='$twitch' class='' target='_blank'>
                  <img class='pro-social-img' src='social-images/twitch.png'>
                  </a>";
          }
          if ($youtube != "0") {
            echo "<a href='$youtube' class='' target='_blank'>
                  <img class='pro-social-img' src='social-images/youtube.png'>
                  </a>";
          }

          if ($facebook == "0" && $twitter == "0" && $instagram == "0" && $twitch == "0" && $youtube == "0") {
            echo "<p>N/A</p>";
          }

          ?>
          </div>
        </div>
      </td>
      <td class="pro-champ">
          <input type="hidden" id="sumID" value="<?php echo $idRiot ?>">
          <script>
            window.onload = champion();

            async function champion(){
            
            const sumID = document.getElementById('sumID').value;

            const url2 = "scripts/champion-mastery.php?id=" + sumID;
            const response2 = await fetch(url2);
            const data2 = await response2.json();

            const url = "scripts/champion-info.php";
            const response = await fetch(url);
            const data = await response.json();


            for (let i = 0; i < 3; i++) {

              const sim = data['data'];

              const numChamp = data2[i]['championId'];
              const lvlChamp = data2[i]['championLevel'];
              const champmastery = data2[i]['championPoints'];

              function championIdtoName( championID, championDb){
                for (var championName in championDb){
                  if ( championDb[championName]['key'] == championID ){
                  return championName;
                  }
                }
              }

              var champName = championIdtoName(numChamp, sim);
              
              document.getElementById('champName' + i).innerHTML = champName;
              document.getElementById('champexp' + i).innerHTML = champmastery + " - Points";
              document.getElementById('champIMG' + i).src = "http://ddragon.leagueoflegends.com/cdn/12.4.1/img/champion/" + champName + ".png";
            }
          }

          </script>

            <div class="pro-champ-in">
              <img id="champIMG0" class="pro-champ-img">
              <span id="champName0"></span>
              <span id="champexp0" class="pro-champ-points"></span>
            </div>

            <div class="pro-champ-in">
              <img id="champIMG1" class="pro-champ-img">
              <span id="champName1"></span>
              <span id="champexp1" class="pro-champ-points"></span>
            </div>

            <div class="pro-champ-in">
              <img id="champIMG2" class="pro-champ-img">
              <span id="champName2"></span>
              <span id="champexp2" class="pro-champ-points"></span>
            </div>

          </div>
      </td>
      <td class="pro-team">
          <div class="pro-team-in">

            <?php
            $sql = "SELECT * FROM userteam WHERE idUser = $getID;";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            
            $idTeam = $row['idTeam'];

            $sql = "SELECT * FROM teams WHERE idTeam = $idTeam;";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $rowcount = mysqli_num_rows($result);
          
            if($rowcount > 0){

              $teamTAG = $row['TeamTag'];
              $teamName = $row['TeamName'];
              $teamLogo = $row['TeamLogo'];

              ?>
              
              <img class="pro-team-img" src="teams-images/<?php echo $teamLogo; ?>">
              <div>
                <p><?php echo $teamTAG." - ".$teamName; ?></p>
              </div>
            
              <a href="team-profile.php?id=<?php echo $idTeam; ?>"><button class="pro-team-button">View Team</button> </a>
            <?php
            }else {
            ?>

            <img class="pro-team-img" src="teams-images/default-team.png">
            
            <div>
              <p>N/A</p>
            </div>

            <?php
            }
            ?>

          </div>
      </td>
    </tr>
  </table>  
</div>
























  <main class="profile-main">
    <br><br><br>

    <script type="text/javascript">

      function closeAlert(){
        var element = document.getElementById("alerta");
        element.parentNode.removeChild(element);
      }

    </script>

    <?php
    if(isset($_GET['i'])) {
      ?>
      <div id="alerta" class="alert2">
        <span class="alert-text">Success!</span>
        <span class="closebtn" onclick="closeAlert()">&#10005;</span>
      </div>
      <?php
    }
    ?>


    <?php
    if (isset($_GET['e'])) {
      $error = $_GET['e'];
      if ($error == "") {
        ?>
        <div id="alerta" class="alert">
          <span class="alert-text">Something went wrong!</span>
          <span class="closebtn" onclick="closeAlert()">&#10005;</span>
        </div>
        <?php
      }
    }
    ?>
    <br><br><br><br><br><br><br>
    <table class="profile-table">
      <tr>
        <td class="profile-col1">
          <?php
            if ($profileimg == "default.png") {
            ?>
            <img class="profile-col1-icon" src="images/no-icon.png" alt="">
            <?php
          }else {
            ?>
            <img class="profile-col1-icon" src="<?php echo $profileimg; ?>" alt="">
            <?php
            }
           ?>
          <br>
          <span style="color: #eee; font-size:24px;"><?php echo $username; ?></span>
          <br>

          <div>
            <?php
            if ($nation == 0) {
              ?>
              <img class="profile-col1-nation" src="country-images/default.png">
              <span>Undefined</span>
              <?php
            }else {
              $sql4 = "SELECT * FROM nation WHERE idNation = $nation;";
              $result4 = mysqli_query($conn, $sql4);
              $row4 = mysqli_fetch_assoc($result4);

              $nationName = $row4['name'];
              $nationIMG = $row4['image'];
              ?>
              <img class="profile-col1-nation" src="country-images/<?php echo $nationIMG; ?>">
              <span><?php echo $nationName; ?></span>
              <?php
            }
             ?>

          </div>

          <div style="line-height: 30px;">
            <?php
            $sql2 = "SELECT * FROM roles WHERE idRole = $role;";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);

            $rolename = $row2['rolename'];
            $roleimg = $row2['image'];

            ?>
            <img class="profile-col1-role" src='role-images/<?php echo $roleimg; ?>'>
            <span><?php echo $rolename; ?></span>
          </div>
        </td>
        <td class="profile-col2">
          <div>
            <span>Account Verified:
              <?php

              if ($accConfirm == 1) {
                echo "<span style='color: #00a303;'>&nbsp;✔</span>";
              }else {
                echo "<span style='color: #e60202;'>&nbsp;✘</span>";
              }
              ?>
            </span>
          </div>
          <?php
          if ($uID <> $getID) {
            ?>
            <div>
              <?php
                $sql2 = "SELECT * FROM favs WHERE idUser = $uID AND idFavUser = $getID;";
                $result2 = mysqli_query($conn, $sql2);
                $rowcount = mysqli_num_rows($result2);

                if ($rowcount > 0) {
                  ?>
                  <form action="includes/add-fav.inc.php?id=<?php echo $getID; ?>" method="post">
                    <a><button class="profile-col2-fav" type="submit" name="remfav">Remove ★</button></a>
                  </form>
                  <?php
                }else {
                  ?>
                  <form action="includes/add-fav.inc.php?id=<?php echo $getID; ?>" method="post">
                    <a><button class="profile-col2-fav" type="submit" name="addfav">Favorites ★</button></a>
                  </form>
                  <?php
                }
               ?>

            </div>
            <?php
          }
           ?>

          <div>
            <?php
              if ($opgg == "0") {
                ?>
                <span>OPGG: Undefined</span>
                <?php
              }else {
                ?>
                  <a class="profile-opgg" href="https://euw.op.gg/summoner/userName=<?php echo $opgg; ?>" target="_blank">OP.GG</a>
                  <span id="opgg" style="visibility: hidden;"><?php echo $opgg; ?></span>
                <?php
              }
             ?>
          </div>
          <div>
            <button class="profile-col2-button" onclick="updateRank()">Update</button>
            <span>Last Update:
              <?php
              if ($lastUP <> "0") {
                echo $time = date("d/m/Y H:i:s",$lastUP)." (UTC+1)";
                $nowtime = strtotime("+6 hours");
              }else {
                echo "Not Updated.";
              }
               ?>
            </span>

            <span id="uID"><?php echo $getID; ?></span>
            <span id="idRiot"><?php echo $idRiot; ?></span>
            <span id="lastUP"><?php echo $lastUP; ?></span>


            <script>
              const IDP = document.getElementById("uID").innerHTML;
              const date = new Date();
              const timenow = Math.floor(date.getTime()/1000);

              const oldtime = document.getElementById("lastUP").innerHTML;

              const timer = timenow - oldtime;


              async function updateRank(){

                const IDP = document.getElementById("uID").innerHTML;
                const date = new Date();
                const timenow = Math.floor(date.getTime()/1000);

                const oldtime = document.getElementById("lastUP").innerHTML;

                const timer = timenow - oldtime;

                if (timer > 300) {

                const riotID = document.getElementById("idRiot").innerHTML;

                const url2 = "scripts/getdata-rank.php?id=" + riotID;
                const response2 = await fetch(url2);
                const data2 = await response2.json();

                const len = data2['length'];

                console.log(data2);
                console.log(len);


                for (let i = 0; i < len; i++) {

                    const Qtype = data2[i]['queueType'];

                    if (Qtype == "RANKED_SOLO_5x5"){
                        const rank = data2[i]['rank'];
                        const tier = data2[i]['tier'];
                        const lp = data2[i]['leaguePoints'];
                        const Sname3 = data2[i]['summonerName'];

                        console.log(Qtype);
                        console.log(rank);
                        console.log(tier);
                        console.log(lp);
                        console.log(Sname3);

                        const url = "scripts/confirm-summoner.php?id=" + Sname3;
                        const response = await fetch(url);
                        const data = await response.json();
                        const iconID = data['profileIconId'];
                        const idP = document.getElementById("uID").innerHTML;

                        console.log(iconID);

                        window.location.href = "scripts/update-rank.php?r=" + rank + "&t=" + tier + "&lp=" + lp + "&sn=" + Sname3 + "&icd=" + iconID + "&idp=" + idP;
                    }
                }


                  }else {
                    const timerV2 = 300 - timer;
                    window.alert("(◕_◕) This profile is already updated, try again later in " + timerV2 + " seconds!");
                  }


                }

                if (timer > 300) {
                  window.onload = updateRank();
                }

            </script>


          </div>
        </td>
        <?php


          $sql5 = "SELECT * FROM rankuser WHERE idUser = $getID;";
          $result5 = mysqli_query($conn, $sql5);
          $row5 = mysqli_fetch_assoc($result5);

          $tier = $row5['tier'];
          $rank = $row5['ranks'];
          $lp = $row5['LP'];
          $sumname = $row5['sumname'];
          $idRank = $row5['idRank'];

          if ($accConfirm === "1" && $idRank <> "0") {
            ?>
            <td class="profile-col3">
                <span class="profile-card-tittle"><?php echo $sumname; ?></span>
                <br>
                <img class="profile-col3-rank" src="rank-images/<?php echo $tier.".png"; ?>">
                <p class="profile-team-name"><?php echo $tier . " " . $rank; ?></p>
                <p class="profile-team-name"><?php echo $lp . " LP"; ?></p>
         <?php
       }else {
         ?>
         <td class="profile-col3">
           <span class="profile-card-tittle">Undefined</span>
           <br>
           <img class="profile-col3-rank" src="rank-images/DEFAULT.png">
         </td>
         <?php
       }
       ?>

        </td>
      </tr>
      <tr>
        <td class="profile-col4">
            <?php
            $sql1 = "SELECT * FROM socials WHERE idUsers = $getID;";
            $result1 = mysqli_query($conn, $sql1);
            $row1 = mysqli_fetch_assoc($result1);

            $facebook = $row1['facebook'];
            $twitter = $row1['twitter'];
            $instagram = $row1['instagram'];
            $twitch = $row1['twitch'];
            $youtube = $row1['youtube'];

            if ($facebook != "0") {
              echo "<div>
                    <a href='$facebook' target='_blank'>
                    <img class='' src='social-images/facebook.png'>
                    <span>Facebook</span>
                    </a>
                    </div>";
            }
            if ($twitter != "0") {
              echo "<div>
                    <a href='$twitter' class='' target='_blank'>
                    <img class='' src='social-images/twitter.png'>
                    <span class=''>Twitter</span>
                    </a>
                    </div>";
            }
            if ($instagram != "0") {
              echo "<div>
                    <a href='$instagram' class='' target='_blank'>
                    <img class='' src='social-images/instagram.png'>
                    <span class=''>Instagram</span>
                    </a>
                    </div>";
            }
            if ($twitch != "0") {
              echo "<div>
                    <a href='$twitch' class='' target='_blank'>
                    <img class='' src='social-images/twitch.png'>
                    <span class=''>Twitch</span>
                    </a>
                    </div>";
            }
            if ($youtube != "0") {
              echo "<div>
                    <a href='$youtube' class='' target='_blank'>
                    <img class='' src='social-images/youtube.png'>
                    <span class=''>Youtube</span>
                    </a>
                    </div>";
            }

            if ($facebook == "0" && $twitter == "0" && $instagram == "0" && $twitch == "0" && $youtube == "0") {
              echo "<span style='color: #ccc;'>•• N/A ••</span>";
            }
            ?>
          </div>
        </td>
        <td class="profile-col5">
          <span>Description</span>

          <div>
            <span><?php echo $Udesc; ?></span>
          </div>
        </td>
        <td class="profile-col6">

          <span>Team</span>
          <br>
          

        </td>
      </tr>
      <tr>
        <td colspan="3">
          <?php
            if($uID == $getID){
              echo "<span style='color: #eee'>*To change your profile information, you have to do it in settings page.</span>";
            }
          ?>
        </td>
      </tr>
    </table>


</main>
