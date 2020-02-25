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
<title>dashboard</title>
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
<body class="w3-sand" >

<!-- Top container -->
<div class="w3-bar w3-top w3-orange w3-large" style="z-index:4">
  <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
  <form action="check_logout.php" method="post">
    <button name ="logOut" type="submit" class=" w3-button  w3-hover-none w3-hover-text-light-grey w3-right"><i class="fa fa-sign-out"></i>  log out</button>
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
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Dashboard</h5>
  </div>
  <div class="w3-bar-block">
    <a href="adminpage.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-home fa-fw"></i> Home</a>
    <a href="admin_dashboard.php" class="w3-bar-item w3-button w3-pink"><i class="fa fa-history fa-fw"></i> Dashboard</a>
    <a href="admin.php" class="w3-bar-item w3-button w3-padding  w3-padding"><i class="fa fa-book fa-fw"></i> History</a>
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
    <h5><b><i class="fa fa-history"></i> Dashboard</b></h5>
  </header>
  <?php
  $date= date('Y-m-d');
  $result=mysqli_query($conn,"SELECT * from customer_queue");
  $D = [];
  while($row = mysqli_fetch_array($result)) {
    if ($row["Status_TypeQueue"] == 'cancel' || $row["Status_TypeQueue"] == 'complete' || $row["Status_TypeQueue"] == '"Waiting"') {
        $all = $all + 1;
    }
    if ($row["Status_TypeQueue"] == 'cancel') {
      $cancel = $cancel + 1;
    } else if ($row["Status_TypeQueue"] == 'complete' ) {
      $complete = $complete + 1;
    } else if ($row["Status_TypeQueue"] == 'Waiting') {
      $incomplete = $incomplete + 1;
    }
  }
  $result=mysqli_query($conn,"SELECT DISTINCT Date from customer_queue");
  while($row = mysqli_fetch_array($result)) {
    array_push($D,$row["Date"]);
  }
$arrlength = count($D);
$dataPoints = [];
  for ($i=0; $i < $arrlength; $i++) {
    $result1 = mysqli_query($conn,"SELECT count(*) count from customer_queue where Date = '$D[$i]'");
    while($row = mysqli_fetch_array($result1)) {
      $count = $row[count];
    }
    $TT = array("y" => $count, "label" => $D[$i]);
    array_push($dataPoints,$TT);
  }
  ?>
  <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
      <div class="w3-container w3-red w3-padding-16">
        <div class="w3-left"><i class="fa fa-close w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $cancel;?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>cancel</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-blue w3-padding-16">
        <div class="w3-left"><i class="fa fa-check w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $complete;?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Complete</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-teal w3-padding-16">
        <div class="w3-left"><i class="fa fa-minus w3-xxxlarge"></i></div>
        <div class="w3-right">

          <h3><?php echo $incomplete;?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Waiting</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-orange w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-newspaper-o  w3-xxxlarge"></i></div>
        <div class="w3-right">

          <h3><?php echo $all;?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>All History</h4>
      </div>
      <br/>
      <br/>
    </div>
  </div>
  <br>
<?php
if (isset($_POST['delete'])) {
  $id = $_POST['delete'];
  $dataa2 ="DELETE FROM customer_queue WHERE  ID_Queue = '$id'";
  $result_statusquery = mysqli_query($conn,$dataa2);
    echo "<META HTTP-EQUIV='Refresh' CONTENT = '1;URL=#.php'>" ;
    $conn->close();
  }
mysqli_close($conn);

?>
<div id="chartContainer" style="height: 250px; width: 50%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	title: {
		text: "Time Queue"
	},
	axisY: {
		title: "จำนวนคนที่จองคิว"
	},
	data: [{
		type: "line",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();

}
</script>
</body>
</html>
