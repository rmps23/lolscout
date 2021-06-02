<?php

include 'includes/menuham.php';


 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css">
    <script src="scripts/menu.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@600&display=swap" rel="stylesheet">
    <title>Project A</title>
  </head>
  <body>


    <div id="main">
        <div class="index-main">
          <a href="index.html" class="title-test">PROJECT A</a>
          <br>
          <?php

            if (isset($_SESSION['userId'])) {






            }else {
              echo "<p>you are logged out</p>";
            }

           ?>



        </div>
    </div>




  </body>
</html>
