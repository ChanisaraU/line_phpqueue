<?php
date_default_timezone_set('Asia/Bangkok');
$servername = "localhost";
$username = "root";
$password = "4sCNfcnjP9dwcfwM";
$dbname = "queue";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8");
?>
