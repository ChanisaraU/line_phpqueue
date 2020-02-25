<?php
include('connect.php');
$date= date('Y-m-d');
$query = "SELECT * FROM customer_queue join customer on customer_queue.ID_customer = customer.ID_Customer" or die("Error:" . mysqli_error());
$result = mysqli_query($conn, $query);
$intNumField = mysqli_num_fields($result);
$resultArray = array();
	while($row = $result->fetch_assoc()) {
		if ($row["date"] = $date) {
			if ($row["Status_TypeQueue"] != 'complete') {
				if ($row["Status_TypeQueue"] != 'cancel') {
					$time = date('H:i:s');
					$time2 = $row["Queue_Time"];
					$now_time1=strtotime(date("Y-m-d ".$time));
					$now_time2=strtotime(date("Y-m-d ".$time2));
					$time_diff=abs($now_time2-$now_time1);
					$time_diff_h=floor($time_diff/3600); // จำนวนชั่วโมงที่ต่างกัน
					$time_diff_m=floor(($time_diff%3600)/60); // จำวนวนนาทีที่ต่างกัน
					$time_diff_s=($time_diff%3600)%60; // จำนวนวินาทีที่ต่างกัน
					$W_Q = $time_diff_h .":".$time_diff_m.":".$time_diff_s;

					if ($row['Start_Time'] == null) { // ยังไม่กดเรัยก
						$W_Q = $time_diff_h .":".$time_diff_m.":".$time_diff_s;
					} else {
						$timez = date('H:i:s');
						$time2z = $row["Start_Time"];
						$now_time1z=strtotime(date("Y-m-d ".$timez));
						$now_time2z=strtotime(date("Y-m-d ".$time2z));
						$time_diffz=abs($now_time2z-$now_time1z);
						$time_diff_hz=floor($time_diffz/3600); // จำนวนชั่วโมงที่ต่างกัน
						$time_diff_mz=floor(($time_diffz%3600)/60); // จำวนวนนาทีที่ต่างกัน
						$time_diff_sz=($time_diffz%3600)%60; // จำนวนวินาทีที่ต่างกัน
						$W_Q = $time_diff_hz .":".$time_diff_mz.":".$time_diff_sz;
					}
					$resultArray[] =
					    array(
								"ID_Queue" => $row['ID_Queue'],
								"ID_customer" => $row['ID_customer'],
								"End_Time" => $row['End_Time'],
								"Status_Queue" => $row['Status_Queue'],
								"Status_TypeQueue" => $row['Status_TypeQueue'],
								"Date" => $row['Date'],
								"Queue_Time" => $row['Queue_Time'],
								"Start_Time" => $row['Start_Time'],
								"ID_Customer" => $row['ID_Customer'],
						    "Username" => $row['Username'],
						    "Password" => $row['Password'],
						    "Name" => $row['Name'],
						    "Email" => $row['Email'],
						    "Telephone" => $row['Telephone'],
						    "Address" => $row['Address'],
						    "name_line" => $row['name_line'],
						    "image" => $row['image'],
						    "status" => $row['status'],
						    "date" => $row['date'],
								"W_Q" => $W_Q
					    );
				}
			}
		}
}
mysqli_close($objConnect);
echo json_encode($resultArray);
?>
<?php


// echo json_encode($arr);
?>
