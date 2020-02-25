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
<title>admin</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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
      <span>Welcome, <strong> <?php echo $_SESSION['user_name'];?></strong></span><br>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-envelope"></i></a>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-user"></i></a>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-cog"></i></a>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Dashboard</h5>
  </div>
  <div class="w3-bar-block">
    <a href="adminpage.php" class="w3-bar-item w3-button w3-padding "><i class="fa fa-home fa-fw"></i>  Home</a>
    <a href="admin.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-book"></i> History</a>
      <hr>
    <a href="setting_admin.php" class="w3-bar-item w3-button w3-padding w3-pink"><i class="fa fa-cogs"></i> setting admin</a>


  </div>
</nav>
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-users"></i>Add admin</b></h5>
  </header>

      <div class="w3-row w3-container">
        <div class="w3-col s11  w3-center">
        </div>
        <div class="w3-col s1 w3-right">
          <a href="setting_admin.php"class="w3-btn w3-indigo" style="width: 100%;" ><i class="fa fa-reply-all"></i></a>
        </div>
      </div>
  <form method="post" class="w3-container w3-card-4 w3-light-grey w3-margin">
  <div class="w3-row w3-section">
    <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user"></i></div>
      <div class="w3-rest">
        <input class="w3-input w3-border" name="username" type="text" required placeholder="Username">
      </div>
  </div>

  <div class="w3-row w3-section">
    <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-key"></i></div>
      <div class="w3-rest">
        <input class="w3-input w3-border" name="password" type="text" required placeholder="Pasword">
      </div>
  </div>

  <div class="w3-row w3-section">
    <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-envelope-o"></i></div>
      <div class="w3-rest">
        <input class="w3-input w3-border" name="email" type="text" required placeholder="Email">
      </div>
  </div>

  <div class="w3-row w3-section">
    <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-phone"></i></div>
      <div class="w3-rest">
        <input class="w3-input w3-border" name="phone" type="text" required placeholder="Phone">
      </div>
  </div>
  <div class="w3-row w3-section">
    <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-cog"></i></div>
      <div class="w3-rest">
        <select class="w3-select" required name="rules">
        <option value="" disabled selected>Choose your rules</option>
        <option value="admin">Admin</option>
        <option value="write">Write</option>
        <option value="read">Read </option>
        </select>
      </div>
  </div>
  <button name ="add" type="submit" class="w3-button w3-block w3-section w3-pink w3-ripple w3-padding">Add</button>

  </form>
  <?php
  if (isset($_POST['add'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $rules = $_POST['rules'];
    $password = md5("$password");
    $dataa1 = "SELECT * FROM admin where username = '$username' or email = '$email'" or die("Error:" . mysqli_error());
    $result = mysqli_query($conn, $dataa1);
      $check = "F";
    while($row = mysqli_fetch_array($result)) {
      $check = "T";
    }
    if ($check == "T") {
      echo "มีขอมูลแล้ว";
    } else {
      $dataa2 ="INSERT INTO admin(username,password,email,telephone,rules) VALUES ('$username', '$password', '$email','$phone','$rules');";
      $result_statusquery = mysqli_query($conn,$dataa2);
    }
  }
  ?>
<script>
var mySidebar = document.getElementById("mySidebar");
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
