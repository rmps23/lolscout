<?php
include 'includes/menuham.php';
include 'includes/header.inc.php';
?>


<div class="st-main-top">
  <table class="st-main-top-in">
    <tr>
      <td class="st-main-top-td">
        <p>Search Team</p>
      </td>
    </tr>
  </table>
</div>

<div class="st-main">

<table class="st-table">
  <tr>
    <td>
      <div class="st-search-bar">
        <input class="st-textbox" type="text" placeholder="Insert team name here...">
        <label>
          <input class="st-radio" type="radio" name="test" value="small" checked>
          <img src="https://via.placeholder.com/40x60/0bf/fff&text=A">
        </label>
        <label>
          <input class="st-radio" type="radio" name="" value="">
          <img src="https://via.placeholder.com/40x60/b0f/fff&text=B">
        </label>
      </div>
    </td>
  </tr>
</table>

</div>














































<br><br><br><br><br><br><br><br><br><br>
<main class="st-main">
  <br><br><br>

<?php
  if (isset($_SESSION['userId'])) {
    $uID = $_SESSION['userId'];
?>
  <div class="st-div-L">
    <table class="st-table-L">
      <tr>
        <td class="st-topbar">
          <span class="settings-title">Filter by Name</span>
        </td>
      </tr>
      <tr>
        <td class="st-box-bar">
          <form action="includes/searchteam.inc.php" method="post" target="lista">
          <input class="st-textbox" type="text" name="word-s" placeholder="Insert Team Name" maxlength="50">
          <br>
          <button class="st-button" type="submit" name="word-search">Search</button>
        </td>
      </tr>
    </table>
    <br>
    <table class="st-table-L">

        <tr>
          <td class="st-topbar">
            <span class="settings-title">Filter by Role/Rank</span>
          </td>
        </tr>

        <tr>
          <td class="st-box-bar">
            <span>Role</span>
            <br>
            <select class="modal-change-role" name="role">
              <?php
              $sql4 = "SELECT * FROM roles WHERE idRole > 0;";
              $result4 = mysqli_query($conn, $sql4);
              ?>
              <?php while($row4 = mysqli_fetch_array($result4)):;?>
               <option value="<?php echo $row4['idRole'];?>"><?php echo $row4['rolename'];?></option>
              <?php endwhile;?>
            </select>
            <br><br>
            <span>Minimum Rank Required</span>
            <br>
            <select class="modal-change-role" name="rank">
              <?php
              $sql5 = "SELECT * FROM ranks;";
              $result5 = mysqli_query($conn, $sql5);
              ?>
             <?php while($row5 = mysqli_fetch_array($result5)):;?>
               <option selected value="<?php echo $row5['idRank'];?>"><?php echo $row5['rankname'];?></option>
              <?php endwhile;?>
            </select>
            <br><br>
            <button class="st-button" type="submit" name="rR">Search</button>
          </td>
        </tr>

      </table>
      <br>
      <table class="st-table-L">

        <tr>
          <td class="st-topbar">
            <span class="settings-title">Filter by Only Available/Role</span>
          </td>
        </tr>

        <tr>
          <td class="st-box-bar">
            <span>Role</span>
            <br>
            <select class="modal-change-role" name="role2">
              <?php
              $sql4 = "SELECT * FROM roles WHERE idRole > 0;";
              $result4 = mysqli_query($conn, $sql4);
              ?>
              <?php while($row4 = mysqli_fetch_array($result4)):;?>
               <option value="<?php echo $row4['idRole'];?>"><?php echo $row4['rolename'];?></option>
              <?php endwhile;?>
            </select>
            <br><br>
            <button class="st-button" type="submit" name="onlyA">Search</button>
            </form>
          </td>
        </tr>
      </table>

  </div>

  <div class="st-div-R">
    <table class="st-table-R">
      <tr>
        <td class="st-topbar">
          <span class="settings-title">Search</span>
          <br>
          <span style="color: #ccc;"><img width="16" height="16" src="images/infoimg.png" alt=""> &nbsp;NOTE: You can only apply for a team if your rank is the minimum required choosen from the team.</span>
        </td>
      </tr>
      <tr>
        <td class="st-box-bar">
          <?php
          $sql3 = "SELECT * FROM apply WHERE idUser = $uID;";
          $result3 = mysqli_query($conn, $sql3);
          $numrow = mysqli_num_rows($result3);
          ?>
          <span class="st-title" style="float: right;">Applied: <?php echo $numrow; ?>/3</span>
          <br><br>
          <?php
          $sql2 = "SELECT * FROM users WHERE idUsers = $uID;";
          $result2 = mysqli_query($conn, $sql2);
          $row2 = mysqli_fetch_assoc($result2);

          $aC = $row2['accConfirm'];

          if ($aC == 0) {
          ?>
          <div class="st-acc-box">
          <span style="color: #eee;">
            <?php
            echo "You have to confirm your League of Legends account to be able to aply for teams!";
            ?>
          </span>
          </div>
           <?php
             }
           ?>
           <iframe name="lista" width="100%" height="700" src="includes/searchteam.inc.php">
         </td>
       </tr>
    </table>
  </div>
<?php
}else {
  header("Location: index.php");
}
?>
</main>
<?php
include 'footer.php';

 ?>
