<?php
include('connect.php');
header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename= "queue_myexcel.xls"');
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".filesize("myexcel.xls"));

@readfile($filename);


?>

<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<table>

  <html xmlns:o="urn:schemas-microsoft-com:office:office"
  xmlns:x="urn:schemas-microsoft-com:office:excel"
  xmlns="http://www.w3.org/TR/REC-html40">

  <html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  </head>
  <body>
  <table>
     <tr>
      <td>No.</td>
      <td>Display Name</td>
      <td>Status Queue</td>
      <td>Status TypeQueue</td>
      <td>Time</td>
      <td>Start Time</td>
      <td>End Time</td>
      <td>Day</td>
    </tr>
    <?php
    $date= date('Y-m-d');
    $query = "SELECT * FROM customer_queue join customer on customer_queue.ID_customer = customer.ID_Customer" or die("Error:" . mysqli_error());
    $result = mysqli_query($conn, $query);
      while($row = mysqli_fetch_array($result)) {
        if ($row["date"] != $date) {
          if ($row["Status_TypeQueue"] == 'cancel' ||$row["Status_TypeQueue"] == 'complete' ) {
    ?>

    <tr>
      <!-- <td class="w3-center"><?php echo $num;?></td> -->
      <td ><?php echo $row["ID_Queue"]?></td>
      <td ><?php echo $row["name_line"]?></td>
      <td ><?php echo $row["Status_Queue"]?></td>
      <td ><?php echo $row["Status_TypeQueue"]?></td>
      <td ><?php echo $row["Queue_Time"]?></td>
      <td ><?php echo $row["Start_Time"]?></td>
      <td ><?php echo $row["End_Time"]?></td>
      <td ><?php echo $row["Date"]?></td>
    </tr>
  <?php }}}?>
</table>
</body>
</html>
