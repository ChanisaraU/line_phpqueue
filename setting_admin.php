<?php
include('connect.php');
session_start();
ob_start();
if($_SESSION['user_name'] == null) {
header ("location:index.php");
}
?>
<!DOCTYPE html>
<html>
<title>setting</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
.button {width: 50%;
      }
</style>
<body class="w3-light-grey">

<!-- Top container -->
<div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
  <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
  <form action="check_logout.php" method="post">
  <button name ="logOut" type="submit"class=" w3-button  w3-hover-none w3-hover-text-light-grey w3-right"><i class="fa fa-sign-out"></i>  log out</button>
</form>
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-pale-red w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
        <img src="images/now.png" class=" w3-margin-right" style="width:90px">
    </div>
    <div class="w3-col s8 w3-bar">
      <span> Welcome, <strong> <?php echo $_SESSION['user_name'];?></strong></span><br>
      <!-- <a href="#" class="w3-bar-item w3-button"><i class="fa fa-envelope"></i></a>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-user"></i></a>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-cog"></i></a> -->
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Dashboard</h5>
  </div>
  <div class="w3-bar-block">
    <a href="adminpage.php" class="w3-bar-item w3-button w3-padding "><i class="fa fa-home fa-fw"></i> Home</a>
    <a href="admin_dashboard.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-history fa-fw"></i> Dashboard</a>
    <a href="admin.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-book fa-fw"></i> History</a>
    <a href="admin_skn.php" class="w3-bar-item w3-button w3-padding  w3-padding"><i class="fa fa-puzzle-piece fa-fw"></i> Service</a>
      <hr>
    <a href="setting_admin.php" class="w3-bar-item w3-button w3-padding w3-pink"><i class="fa fa-cogs fa-fw"></i> setting admin</a>


  </div>
</nav>


<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-cogs"></i> Setting</b></h5>
  </header>
  <?php
    if ($_SESSION["rules"] == "admin") {
      $b_add = "";
      $b_edit = "";
      $b_delete = "";
    } else if ($_SESSION["rules"] == "read") {
      $b_add = "disabled";
      $b_edit = "disabled";
      $b_delete = "disabled";
    } else if ($_SESSION["rules"] == "write") {
      $b_add = "disabled";
      $b_edit = "";
      $b_delete = "disabled";
    }

  ?>
  <div class="w3-row w3-container">
    <div class="w3-col s11  w3-center">
    </div>
    <div class="w3-col s1 w3-right">
      <a href="add_admin.php"  style="width: 100%;" >
        <button type="submit" <?php echo $b_add;?> class="w3-btn w3-teal ">Add</button>
       </a>

    </div>
  </div>
  <br>
  <div class="w3-cowidth: 100%;ntainer">
    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
      <tr>
        <td class="w3-center">No.</td>
        <td class="w3-center">username</td>
        <td class="w3-center">e-mail</td>
        <td class="w3-center">telephone</td>
        <td class="w3-center">rules</td>
        <td class="w3-center">Modify</td>
      </tr>
      <?php
      $query = "SELECT * FROM admin" or die("Error:" . mysqli_error());
      $result = mysqli_query($conn, $query);
      $num = 0;
        while($row = mysqli_fetch_array($result)) {
            $num = $num + 1 ;
      ?>
      <tr>
        <td class="w3-center"><?php echo $num;?></td>
        <td class="w3-center"><?php echo $row["username"]?></td>
        <td class="w3-center"><?php echo $row["email"]?></td>
        <td class="w3-center"><?php echo $row["telephone"]?></td>
        <td class="w3-center"><?php echo $row["rules"]?></td>
        <td class="w3-center">
<div class="w3-cell-row">
  <div class="w3-col s6">
    <button onclick="document.getElementById('<?php echo $row["id_admin"]?>').style.display='block'" <?php echo $b_edit;?> class="w3-btn w3-teal  ">Edit</button>
     <div id="<?php echo $row["id_admin"]?>" class="w3-modal">
       <div class="w3-modal-content w3-animate-opacity w3-card-4">
         <header >
           <span onclick="document.getElementById('<?php echo $row["id_admin"]?>').style.display='none'"
           class="w3-button <?php echo $b_edit;?>w3-display-topright">&times;</span>
           <h2>Edit admin</h2>
         </header>
        <div class="w3-container">
          <form method="post" class="w3-container w3-card-4 w3-light-grey w3-margin">
          <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user"></i></div>
              <div class="w3-rest">
                <input class="w3-input w3-border" value="<?php echo $row["username"];?>" name="username" type="text" required placeholder="Username">
              </div>
          </div>
          <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-envelope-o"></i></div>
              <div class="w3-rest">
                <input class="w3-input w3-border" value="<?php echo $row["email"];?>"name="email" type="text" required placeholder="Email">
              </div>
          </div>

          <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-phone"></i></div>
              <div class="w3-rest">
                <input class="w3-input w3-border" value="<?php echo $row["telephone"];?>"name="phone" type="text" required placeholder="Phone">
              </div>
          </div>

          <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-cog"></i></div>
              <div class="w3-rest">
                <?php
                  if ($row["rules"] == "admin") {
                    $admin = "selected";
                    $write = "";
                    $read = "";
                  } elseif ($row["rules"] == "write") {
                    $admin = "";
                    $write = "selected";
                    $read = "";
                  } else {
                    $admin = "";
                    $write = "";
                    $read = "selected";
                  }
                ?>
                <select class="w3-select" required name="rules">
                <option <?php echo $admin; ?> value="admin">$admin</option>
                <option <?php echo $write; ?> value="write">Write</option>
                <option <?php echo $read; ?> value="read">Read </option>
                </select>
              </div>
          </div>

          <button name ="edit" type="submit" value="<?php echo $row["id_admin"]?>" class="w3-button w3-block w3-section w3-green w3-ripple w3-padding">Edit</button>

          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="w3-col s6">
    <?php  if ($row["username"] != $_SESSION['user_name']) {   ?>
      <form method="post">
        <button type="submit" name="Delete" value="<?php echo $row["id_admin"]?>"<?php echo $b_delete;?> class="w3-btn w3-red ">Delete</button>
      </form>
    <?php  }?>

  </div>
</div>


      </td>
      </tr>
    <?php }?>
    </table><br>

<?php
if (isset($_POST['Delete'])) {
   $Delete = $_POST['Delete'];
  $dataa2 ="DELETE FROM admin where id_admin = '$Delete'";
  $result_statusquery = mysqli_query($conn,$dataa2);
    echo "<META HTTP-EQUIV='Refresh' CONTENT = '1;URL=#.php'>" ;
    $conn->close();
  } else if (isset($_POST['edit'])) {
    $id = $_POST['edit'];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $tell = $_POST["phone"];
    $rules = $_POST["rules"];
    $password = md5("$password");
    $dataa2 ="UPDATE admin SET username ='$username',password='$password',email='$email', telephone='$tell' ,rules = '$rules' where id_admin = '$id'";
    $result_statusquery = mysqli_query($conn,$dataa2);
      echo "<META HTTP-EQUIV='Refresh' CONTENT = '1;URL=#.php'>" ;
      $conn->close();
    }
  mysqli_close($conn);
?>

<script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");
// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
    overlayBg.style.display = "none";
  } else {
    mySidebar.style.display = 'block';
    overlayBg.style.display = "block";
  }
}

// Close the sidebar with the close button
function w3_close() {
  mySidebar.style.display = "none";
  overlayBg.style.display = "none";
}
</script>

</body>
</html>
