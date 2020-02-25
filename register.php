<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Form Register</title>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>
<body bgcolor="#E6E6FA" >
<div class="container">
	<div class="row">
		<div class="col-md-7 col-xs-12">

    <form  name="register" action="save_register.php" method="POST" id="register" class="form-horizontal">
       <div class="form-group">
       <div class="col-sm-2">  </div>
       <div class="col-sm-5" align="left">
       <br>
			<!-- <p>context.userId</p> <p id="useridfield"></p> -->
			<input type="hidden" name="id" id="input" value="">
			<input type="hidden" name="image" id="useridprofilefield" value="">
			<input type="hidden" name="name" id="displaynamefield" value="">
			<input type="hidden" name="status" id="statusmessagefield" value="">
      <center> <h4 ><font color="#88BBAA"> QueueConnect </font></h4></center>
       </div>
       <input name="Admin_level" type="hidden" id="Admin_level" value="2" />
       </div>
        <!-- <div class="form-group">
          <div class="col-sm-5" align="left">
        <font color="#88DDBB">  Username : </font> <input  name="Admin_username" type="text" required class="form-control" id="Admin_username" placeholder="username" pattern="^[a-zA-Z0-9]+$" title="ภาษาอังกฤษหรือตัวเลขเท่านั้น" minlength="2"  />
          </div>
      </div> -->
         <div class="form-group">
          <div class="col-sm-5" align="left">
        <font color="#88DDBB">  ID card number : </font><input  name="Admin_password" type="password" required class="form-control" id="Admin_password" placeholder="ID card number" pattern="^[a-zA-Z0-9]+$" minlength="2" />
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-7" align="left">
        <font color="#88DDBB">  Name-Lastname : </font> <input  name="Admin_name" type="text" required class="form-control" id="Admin_name" placeholder="ชื่อ-สกุล" />
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-6" align="left">
          <font color="#88DDBB">  Email : </font><input  name="Admin_email" type="email" class="form-control" id="Admin_email"   placeholder="อีเมล์"/>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-6" align="left">
        <font color="#88DDBB">  Telephone: </font><input  name="Admin_phone" type="text" class="form-control" id="Admin_phone"  placeholder="เบอร์โทร" />
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-6" align="left">
          <font color="#88DDBB">address : </font> <textarea name="address" class="form-control" id="address"  placeholder="ที่อยู่"></textarea>
          </div>
        </div>
      <div class="form-group">
      <div class="col-sm-2"> </div>
          <div class="col-sm-6">
          <center><button type="submit" id="getprofilebutton" class="btn btn-primary" id="btn"> สมัครสมาชิก </center></button>
          </div>

      </div>
      </form>

			 <!-- <h2>Profile</h2> -->
			 <!-- <div id="profilepicturediv"> -->
			 </div>
	 </div>
</div>
</div>
</div>
<script src="https://d.line-scdn.net/liff/1.0/sdk.js"></script>
<script type="text/javascript">
window.onload = function (e) {
	liff.init(function (data) {
			initializeApp(data);

	});
};
function initializeApp(data) {
	document.getElementById("input").value = data.context.userId;
	// get profile call
			 liff.getProfile().then(function (profile) {
					 document.getElementById('displaynamefield').value = profile.displayName;
					 document.getElementById('useridprofilefield').value = profile.pictureUrl;
					 document.getElementById('statusmessagefield').value = profile.statusMessage;
			 })
	}
</script>
</body>
</html>
