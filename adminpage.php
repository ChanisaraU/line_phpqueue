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
<title>home</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="http://code.jquery.com/jquery-latest.js"></script>
<link rel="stylesheet" href="css.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
<body class="w3-Prink-2">

<!-- Top container -->
<div class="w3-bar w3-top w3-Prink-4 w3-large" style="z-index:4">
   <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
  <form action="check_logout.php" method="post">
  <button name ="logOut" type="submit"class=" w3-button  w3-hover-none w3-hover-text-light-grey w3-right"><i class="fa fa-sign-out"></i>  log out</button>
</form>
</div>
<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-Prink-4 w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
        <img src="images/now.png" class=" w3-margin-right" style="width:90px">
    </div>
    <div class="w3-col s8 w3-bar">
      <span> Welcome, <strong> <?php echo $_SESSION['user_name'];?></strong></span><br>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Dashboard</h5>
  </div>
  <div class="w3-bar-block">
    <a href="adminpage.php" class="w3-bar-item w3-button w3-padding w3-Prink-3"><i class="fa fa-home fa-fw"></i> Home</a>
    <a href="admin_dashboard.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-history fa-fw"></i> Dashboard</a>
    <a href="admin.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-book fa-fw"></i>  History</a>
    <a href="admin_skn.php" class="w3-bar-item w3-button w3-padding  w3-padding"><i class="fa fa-puzzle-piece fa-fw"></i> Service</a>
      <hr>
    <a href="setting_admin.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-fw fa-cogs"></i> setting admin</a>
  </div>
</nav>
<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-home"></i> My Home</b></h5>
  </header>
  <div class="w3-cowidth: 100%;ntainer">
    <hr>

    <script>
      getDataFromDb();
      function getDataFromDb()
      {
      $.ajax({
          url: "getData.php" ,
          type: "POST",
          data: ''
        })
        .success(function(result) {
          var obj = jQuery.parseJSON(result);
          var i = 1;
            // if(obj != '')
            // {
                $("#myBody").empty();
                $.each(obj, function(key, val) {
                  // console.log("success");
                  var button_action = "";

                  if (i == 1 ) {
                    button_action = "";


                  } else {button_action = "disabled";}
                  if (val["Start_Time"] == null) {
                    var next = "<button type='submit' name='next'"+button_action+" value='nextqueue'class='w3-btn w3-pink'>Next Queue </button>";
                  } else {
                    var next = "<button type='submit' name='queue'"+button_action+" value='nextqueue'class='w3-btn w3-purple'>Success </button> " +
                       "<button type='submit' name='cancel'"+button_action+" value='Cencel' class='w3-btn w3-red'>Cencel</button> ";;
                  }
                    var tr = "<tr>";
                    tr = tr + "<td class='w3-center'>" + i++ + "</td>";
                    tr = tr + "<td class='w3-center'><img src='"+ val["image"] +"' alt='Smiley face' height='42' width='42'></td>";
                    tr = tr + "<td class='w3-center'>" + val["name_line"] + "</td>";
                    tr = tr + "<td class='w3-center'>" + val["W_Q"] + "</td>";
                    tr = tr + " <td class='w3-center'> " +
                     "<div class='w3-cell-row'> <div class='w3-col s10'> <form method='post'>"+
                      "<input type='hidden' name='id'  value='" + val["ID_Queue"]+ "'>" + next  +"</form> </div>" +
                     " </div>" +
                    " </td>";
                    tr = tr + "</tr>";
                    $('#myTable > tbody:last').append(tr);
                });
            // }
        });
          // console.log("หห");
      }
      setInterval(getDataFromDb, 1000);   // 1000 = 1 second
      </script>


    <div class="w3-container">
      <div class="w3-card-4" style="width:100%;">
        <div class="w3-container"></br>
          <table  id="myTable" class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
            <thead>
            <tr>
              <td class="w3-center">No.</td>
              <td class="w3-center">Display profile</td>
              <td class="w3-center">Display name</td>
              <td class="w3-center">Time</td>
              <td class="w3-center">Action</td>
            </tr>
            </thead>
            <tbody id="myBody"></tbody>
          </table><br>
        </div>
      </div>
    </div>
<?php
if (isset($_POST['queue'])) {
      $date= date('Y-m-d');
      $time = date('H:i:s');
      $option = $_POST['queue'];
      $id = $_POST['id'];
      $dataa ="UPDATE customer_queue SET  Status_TypeQueue ='complete',End_Time = '$time' where ID_Queue = '$id'";  //Status_Queue='$option',
      $result_statusquery = mysqli_query($conn,$dataa);
      $id = $id + 1;
      $dataa2 ="UPDATE customer_queue SET  Status_TypeQueue ='Pending' where ID_Queue = '$id'";
      $result_statusquery = mysqli_query($conn,$dataa2);

      // echo "<META HTTP-EQUIV='Refresh' CONTENT = '1;URL=adminpage.php.php'>" ;
      $conn->close();
}else if (isset($_POST['cancel'])) {
    $id = $_POST['id'];
      $time = date('H:i:s');
    $dataa2 ="UPDATE customer_queue SET Status_TypeQueue ='cancel',End_Time  = '$time' where ID_Queue = '$id'"; // Status_Queue='cancel',
    $result_statusquery = mysqli_query($conn,$dataa2);

      // echo "<META HTTP-EQUIV='Refresh' CONTENT = '1;URL=#.php'>" ;
      $conn->close();
    }else if (isset($_POST['next'])) {
        $id = $_POST['id'];
        $time = date('H:i:s');
        $dataa2 ="UPDATE customer_queue SET Start_Time  = '$time' where ID_Queue = '$id'"; // Status_Queue='cancel',
        $result_statusquery = mysqli_query($conn,$dataa2);

          // echo "<META HTTP-EQUIV='Refresh' CONTENT = '1;URL=#.php'>" ;
          $conn->close();
        }
    else if (isset($_POST['logOut'])) {
      session_start();
      session_destroy();
      echo ("<script>location.href='index.php'</script>");
    }
  mysqli_close($conn);
?>

<script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");


// // Toggle between showing and hiding the sidebar, and add overlay effect
// function w3_open() {
//   if (mySidebar.style.display === 'block') {
//     mySidebar.style.display = 'none';
//     overlayBg.style.display = "none";
//   } else {
//     mySidebar.style.display = 'block';
//     overlayBg.style.display = "block";
//   }
// }
//
// // Close the sidebar with the close button
// function w3_close() {
//   mySidebar.style.display = "none";
//   overlayBg.style.display = "none";
// }
</script>

</body>
</html>
