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
<title>history</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
.button {width: 50%;
      }
a {
   text-decoration: none;
   no-underline ;
  }

</style>

<body class="w3-light-grey">

<!-- Top container -->
<div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
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
    <a href="adminpage.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-home fa-fw"></i> Home</a>
    <a href="admin_dashboard.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-history fa-fw"></i> Dashboard</a>
    <a href="admin.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-book fa-fw"></i> History</a>
    <a href="admin_skn.php" class="w3-bar-item w3-button w3-padding   w3-pink w3-padding"><i class="fa fa-puzzle-piece fa-fw"></i> Service</a>
      <hr>
    <a href="setting_admin.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-cogs fa-fw"></i> setting admin</a>
  </div>
</nav>


<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-book"></i> Service</b></h5>
  </header>
    <div class="container">
    <br/>
    <br/>
    <form  method="post">
    <div class="col-md-2">
      <?php $date= date('Y-m-d');?>
    <input type="text" name="From" value="<?php echo $date;?>" id="From" class="form-control" placeholder="From Date"/>
    </div>
    <div class="col-md-2">
    <input type="text" name="to" id="to"  value="<?php echo $date;?>" class="form-control" placeholder="To Date"/>
    </div>
    <div class="col-md-2">
      <select name="SELECT1"class="form-control" id='SELECT1'>
       <option selected value='all'>all</option>
       <option value='other'>other</option>
       <option value='fund'>fund</option>
       <option value='account'>account</option>
       <option value='credit'>credit</option>
    </select>
    </div>
    <div class="col-md-2">
    <input type="submit" name="range" id="range" class="btn btn-success"/>

    </div>
    <div class="col-md-3" align="left">
        <input name="txtKeyword" type="text" id="myInput" onkeyup="myFunction()" align="left"class="form-control" placeholder="Search">
      </div>
      </form>
    </div>


  <br/>
  <br/>
  <?php
  // echo "strssssssssssssssssssing";
  if (isset($_POST['range'])) {
    echo $_POST['From'];
    echo $_POST['SELECT1'];
    $ch = $_POST['SELECT1'];
  }
  ?>

  <div id="date">
  <table  id="myTable" class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
    <tr>
      <td class="w3-center" onclick="sortTable(0)">No.</td>
      <td class="w3-center" onclick="sortTable(1)">Display profile</td>
      <td class="w3-center" onclick="sortTable(2)">Display name</td>
      <td class="w3-center" onclick="sortTable(3)">All</td>
      <td class="w3-center" onclick="sortTable(3)">Description</td>
    </tr>
    <?php
    $date= date('Y-m-d');
    $query1 = "SELECT * FROM skn join customer where skn.name = customer.Name" or die("Error:" . mysqli_error());
    $result1 = mysqli_query($conn, $query1);
      while($row1= mysqli_fetch_array($result1)) {
        $num = $num + 1 ;
        $n = $row1['name'];
        $c = 0;
          $query = "SELECT * FROM customer_queue join customer on customer_queue.ID_customer = customer.ID_Customer where Name = '$n' and Date BETWEEN '".$_POST["From"]."' AND '".$_POST["to"]."' " or die("Error:" . mysqli_error());
          $result = mysqli_query($conn, $query);

            while($row = mysqli_fetch_array($result)) {
              if ($row["date"] != $date) {
                if ($row["Status_TypeQueue"] == 'complete') {
                  if ($_POST['SELECT1'] == 'all' ) {
                    $c = $c + 1;
                  }
                  else if ($n == $row["Name"] and  $row["Status_Queue"] ==  $ch) {
                    $c = $c + 1;
                    // $img =  $row["image"];
                  }
                  echo $n ;
          } }}


    ?>
    <tr>
      <td class="w3-center"><?php echo $num;?></td>
      <td class="w3-center"><img src="<?php echo  $row1["image"]?>" alt="Smiley face" height="42" width="42"></td>
      <td class="w3-center"><?php echo $n?></td>
      <td class="w3-center"><?php echo $c ?></td>
      <form action="Description.php" method="post"><td class="w3-center"><button type="submit" name="Description" value ="<?php echo $n ;?>" class="w3-btn  w3-pink">Description</button>

      </td></form>


      </form>
    </tr>
  <?php
  }?>
  </table>

  </div>
  <br>
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

function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTable");
  switching = true;
  //Set the sorting direction to ascending:
  dir = "asc";
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount ++;
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}
</script>
<script>

$(document).ready(function(){
$.datepicker.setDefaults({
dateFormat: 'yy-mm-dd'
});
$(function(){
$("#From").datepicker();
$("#to").datepicker();
});
$('#range').click(function(){
var From = $('#From').val();
var to = $('#to').val();
if(From != '' && to != '')
{
// $.ajax({
// url:"test.php",
// method:"POST",
// data:{From:From, to:to},
// success:function(data)
// {
// $('#date').html(data);
// }
// });
}
else
{
alert("Please Select the Date");
}
});
});
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>
</body>
</html>
