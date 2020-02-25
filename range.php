<!DOCTYPE html>
<html>
<title>admin</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<?php
// Range.php
if(isset($_POST["From"], $_POST["to"]))
{
	$conn = mysqli_connect("localhost", "root", "root1234", "queue");
	$result = '';
	$query = "SELECT * FROM customer_queue join customer on customer_queue.ID_customer = customer.ID_Customer WHERE Date BETWEEN '".$_POST["From"]."' AND '".$_POST["to"]."'";
	$sql = mysqli_query($conn, $query);
	$result .='
	<table id="myTable" class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
	<tr>
	<td class="w3-center">No.</td>
  <td class="w3-center">Display Proflie</td>
  <td class="w3-center">Name</td>
	<td class="w3-center">Status message</td>
	<td class="w3-center">Status queue</td>
  <td class="w3-center">Date</td>
  <td class="w3-center">Time</td>
  <td class="w3-center">Action</td>
	</tr>';
	if(mysqli_num_rows($sql) > 0)
	{
		 $num = 0;
		while($row = mysqli_fetch_array($sql))
		{
			$num =$num+1 ;
			$result .='
			<tr>
				<td class="w3-center">'.$num.'</td>
			<td class="w3-center"><img src="'.$row["image"].'" alt="Smiley face" height="42" width="42"></td>
			<td class="w3-center">'.$row["name_line"].'</td>
			<td class="w3-center">'.$row["status"].'</td>
			<td class="w3-center">'.$row["Status_Queue"].'</td>
			<td class="w3-center">'.$row["Date"].'</td>
			<td class="w3-center">'.$row["Queue_Time"].'</td>
			<td class="w3-center">
			<form method="post">
			<button type="submit" name="delete" class="w3-btn  w3-red" value ="'. $row["ID_Queue"].'">
			delete
			</button>
			</form>
			</td>
			</tr>';
		}
	}
	else
	{
		$result .='
		<tr>
		<td colspan="5">No Purchased Item Found</td>
		</tr>';
	}
	$result .='</table>';
	echo $result;
}
?>
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
</html>
