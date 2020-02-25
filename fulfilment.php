<?php
error_reporting(0);
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
$input = fopen("log_json.txt", "w") or die("Unable to open file!");
fwrite($input,$json);
fclose($input);
function mint($request)
{
  $servername = "localhost";
  $username = "root";
  $password = "root1234";
  $dbname = "queue";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  $conn->set_charset("utf8");
  $queryText = $request["queryResult"]["queryText"];
  $userId = $request["originalDetectIntentRequest"]["payload"]["data"]["source"]["userId"];
  $date= date('Y-m-d');
  $time = date('H:i:s');
  $Status =  "Waiting" ;

  $opts = ["http"
  =>["header"
  =>"Authorization: Bearer eRJm0hoW+wv7Wb/xP7lDwFZtmsFE0jk69LFxIMEPfhNXn03NC8iY8Jd4FqWYzH16Fcxr/3Qad1c4Dlb0zjORdolspxpcawL1hpjGp9iRdhl7ZB5fb0QR70shjCA868wm0fiynx5trTDBIB0i8eyk/QdB04t89/1O/w1cDnyilFU="
  ,],];
  $context = stream_context_create($opts);
  $profile_json = file_get_contents('https://api.line.me/v2/bot/profile/'.$userId, false, $context);

  $profile_array = json_decode($profile_json, true);
  $pic_ = $profile_array["pictureUrl"];
  //นับคำที่เข้ามาว่าถึงคิวไหนแล้ว
  $select = "SELECT COUNT(*) as no FROM customer_queue WHERE  Date = '$date' and Status_Queue = '$queryText' and Status_TypeQueue != 'complete'  and  Status_TypeQueue != 'cancel'";
  $result = mysqli_query($conn, $select);
  $numRows = mysqli_num_rows($result);
    while($show = mysqli_fetch_array($result)) {
      $substr = (int)$show["no"];
    }
    if ($substr < 0) {
     $substr = 0 ;
    }else {
    $substr = $substr + 1 ;
  }
  $select = "SELECT ID_Customer FROM customer where ID_Customer = '$userId'";
  $result = mysqli_query($conn, $select);
  $numRows = mysqli_num_rows($result);
    while($show = mysqli_fetch_array($result)){
      $user_register = $show["ID_Customer"];
    }
    if ($user_register == null) {
      sendMessage(array(
          "source" => $request["responseId"],
          "fulfillmentText"=>"กรุณาสมัครสมาชิกก่อนทำรายการ",
          "payload" => array(
              "items"=>[
                  array(
                      "simpleResponse"=>
                  array(
                      "textToSpeech"=>"response from host"
                       )
                  )
              ],
              ),

      ));
    } else {
      $sql = "INSERT INTO customer_queue(ID_Customer,Status_Queue,Date,Queue_Time,Status_TypeQueue,pic) select '$userId','$queryText','$date','$time','$Status','$pic_' where not exists (SELECT * from customer_queue where Date = '$date' and Status_TypeQueue != 'complete' and Status_TypeQueue != 'cancel' and ID_customer = '$userId')";
      $dataa ="UPDATE customer SET  image ='$pic_' where ID_Customer = '$userId'";
      $result_statusquery = mysqli_query($conn,$dataa);
      if ($queryText != ""){
        if ($conn->query($sql) === TRUE) {
          $select = "SELECT COUNT(*) as no FROM customer_queue WHERE  Date = '$date' and Status_Queue = '$queryText' and Status_TypeQueue != 'complete' and Status_TypeQueue != 'cancel'";
          $result = mysqli_query($conn, $select);
          $numRows = mysqli_num_rows($result);
            while($show = mysqli_fetch_array($result)){
                  $substr1 = (int)$show["no"];
            }
            if ($substr1 < $substr ) {
              $message="ขออภัย คุณได้ทำการจองคิวไว้ก่อนหน้านี้แล้ว กรุณาตรวจสอบสถานะคิวอีกครั้ง";
            }
            else {
              $message= "จองคิวสำเร็จ";
            }
            sendMessage(array(
                "source" => $request["responseId"],
                "fulfillmentText"=>$message,
                "payload" => array(
                    "items"=>[
                        array(
                            "simpleResponse"=>
                        array(
                            "textToSpeech"=>"response from host"
                             )
                        )
                    ],
                    ),

            ));
      } else {
         echo "Error: " . $sql . "<br>" . $conn->error;
       }
     }
    }
      mysqli_close($conn);
}
  function processMessage($update) {
  $date2 = date("Y-m-d");
  $time = date('H:i:s');
  $queryText2 = $request["queryResult"]["queryText"];
  $userId2 = $update["originalDetectIntentRequest"]["payload"]["data"]["source"]["userId"];
     if ($update["queryResult"]["queryText"] == "คิว") {
        $id =  $update["queryResult"]["parameters"]["number"];
        $conn = mysqli_connect("localhost", "root", "root1234", "queue");
        $sql = "SELECT * FROM customer_queue join customer on customer_queue.ID_customer = customer.ID_Customer" or die("Error:" . mysqli_error());
        $result = mysqli_query($conn, $sql);
        $Q = 1;
        while($row = mysqli_fetch_array($result)) {
          if ($row["date"] = $date2 && $row["Status_TypeQueue"] != 'complete' && $row["Status_TypeQueue"] != 'cancel'  ) {
            if ($row["ID_customer"] == $userId2) {
              $status = $Q;
              $name = $row["name_line"];
              $time2 = $row["Queue_Time"];
            }
            $Q = $Q + 1;
          }
        }
        if ($status == null) {
          $ppp = "ไม่มีรายการ ";
        } else {

          $now_time1=strtotime(date("Y-m-d ".$time));
          $now_time2=strtotime(date("Y-m-d ".$time2));
          $time_diff=abs($now_time2-$now_time1);
          $time_diff_h=floor($time_diff/3600); // จำนวนชั่วโมงที่ต่างกัน
          $time_diff_m=floor(($time_diff%3600)/60); // จำวนวนนาทีที่ต่างกัน
          $time_diff_s=($time_diff%3600)%60; // จำนวนวินาทีที่ต่างกัน
          $ppp = "ขณะนี้คุณ ".$name." อยู่คิวลำดับที่ : " .$status ." คุณอยู่ในคิวมา ".$time_diff_h." ชั่วโมง ".$time_diff_m." นาที";
            $conn->close();
        }
        sendMessage(array(
          "source" => $update["responseId"],
          "fulfillmentText"=>$ppp,
          "payload" => array(
            "items"=>[
              array(
                "simpleResponse"=>
                array(
                  "textToSpeech"=>$ppp
                )
              )
              ],
            ),
          ));
        } else if ($update["queryResult"]["queryText"] == "ยกเลิก") {
           $id =  $update["queryResult"]["parameters"]["number"];
           $conn = mysqli_connect("localhost", "root", "root1234", "queue");
           $sql = "SELECT * FROM customer_queue join customer on customer_queue.ID_customer = customer.ID_Customer" or die("Error:" . mysqli_error());
           $result = mysqli_query($conn, $sql);
           $Q = 1;
           while($row = mysqli_fetch_array($result)) {
             if ($row["date"] = $date2 && $row["Status_TypeQueue"] != 'complete' && $row["Status_TypeQueue"] != 'cancel'  ) {
               if ($row["ID_customer"] == $userId2) {
                 $status = $Q;
                 $name = $row["name_line"];
                 $can =  $row["Start_Time"];

               }
               $Q = $Q + 1;
             }
           }
           if ($can != null ) {
              $ppp = "ยกเลิกคิวไม่ได ท่านกำลังทำรายการ" ;

           }else {
             $sql = "SELECT * FROM customer_queue where ID_customer = '$userId2' and Status_TypeQueue != 'complete' and  Status_TypeQueue != 'cancel'" or die("Error:" . mysqli_error());
             $result = mysqli_query($conn, $sql);
             while($row = mysqli_fetch_array($result)) {
                 $status = $row["ID_customer"];
                 $id = $row["ID_Queue"];
                 $start = $row["Queue_Time"];
             }
             if ($status == null) {
               $ppp = "ไม่มีรายการ ";
             } else {
               $ppp = "ยกเลิกคิวสำเร็จ" ;
               $time = date('H:i:s');

               $dataa2 ="UPDATE customer_queue SET Status_TypeQueue ='cancel',End_Time  = '$time' where ID_Queue = '$id'"; //Status_Queue='cancel',
               $result_statusquery = mysqli_query($conn,$dataa2);

             }
           }
           sendMessage(array(
             "source" => $update["responseId"],
             "fulfillmentText"=>$ppp,
             "payload" => array(
               "items"=>[
                 array(
                   "simpleResponse"=>
                   array(
                     "textToSpeech"=>$ppp
                   )
                 )
                 ],
               ),
             ));
        } else {
          sendMessage(array(
            "source" => $update["responseId"],
            "fulfillmentText"=>"ไม่ได้อยู่ใน intent ใดใด",
            "payload" => array(
              "items"=>[
                array(
                  "simpleResponse"=>
                  array(
                    "textToSpeech"=>"Bad request"
                  )
                )
                ],
              ),
            ));
          }
        }


        function sendMessage($parameters) {
          echo json_encode($parameters);
        }

        function replyMsg($arrayHeader,$arrayPostData){

            $strUrl = "https://api.line.me/v2/bot/message/reply";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$strUrl);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);
            curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arrayPostData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
            curl_close ($ch);
        }
$json = file_get_contents("php://input");
/*Decode Json From LINE Data Body*/
$request4 = json_decode($json, true);
if (isset($request4["events"][0]) && $request4["events"][0]["message"]["type"] == "location") {
  $accessToken = "eRJm0hoW+wv7Wb/xP7lDwFZtmsFE0jk69LFxIMEPfhNXn03NC8iY8Jd4FqWYzH16Fcxr/3Qad1c4Dlb0zjORdolspxpcawL1hpjGp9iRdhl7ZB5fb0QR70shjCA868wm0fiynx5trTDBIB0i8eyk/QdB04t89/1O/w1cDnyilFU=";
  $raw_message = $request4["events"][0]["message"];
  $arrayHeader = array();
      $arrayHeader[] = "Content-Type: application/json";
      $arrayHeader[] = "Authorization: Bearer {$accessToken}";

      //รับข้อความจากผู้ใช้
      $message = $request4['events'][0]['message']['text'];
  #ตัวอย่าง Message Type "Text"
    $address_text =  $request4["events"][0]["message"]["address"];

    $arrayPostData['replyToken'] = $request4['events'][0]['replyToken'];
    $arrayPostData['messages'][0]['type'] = "text";
    $arrayPostData['messages'][0]['text'] = "ใช่ที่ " .   $address_text . " หรือไม่ ?";
    replyMsg($arrayHeader,$arrayPostData);
  // save_to_database() << do
  // send_line("ต้องการที่นี่ไหม") << do
  // echo "xxx";

}else if (isset($request4["queryResult"]["queryText"])) {
  if ($request4["queryResult"]["queryText"]=='คิว' || $request4["queryResult"]["queryText"]=='ยกเลิก') {
    processMessage($request4);
    echo $request4["queryResult"] ;
  } else if (strtolower($request4["queryResult"]["queryText"])== 'fund' || strtolower($request4["queryResult"]["queryText"]) == 'account'|| strtolower($request4["queryResult"]["queryText"]) == 'credit' || strtolower($request4["queryResult"]["queryText"]) == 'other') {
      mint($request4);
  }
}
?>
