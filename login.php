<?php
$loggedIn = isset($_COOKIE['userID']);
include 'db.inc.php';
/*
if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}
*/
$email = $_REQUEST['email'];
$subPass = $_REQUEST['pass'];
$subPass = md5($subPass);

//If the user is already logged in just redirect them to the home page
if ($loggedIn) {
    echo '<meta http-equiv="refresh" content="2;URL=\'index.php\'" />';
}

//Alright they may have entered a username and password
if ($email != '' && subPass != '') {
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $req = "SELECT * FROM `Users` WHERE `email` = '$email'";
    $result = $conn->query($req);

    if ($result->num_rows > 0) {
        // output data of each row
	$row = $result->fetch_assoc();
	if ($row['password'] == $subPass) {
	    setCookie('userID', $row['ID'], time() + 86400, '/');
	    echo '<meta http-equiv="refresh" content="0;URL=\'index.php\'" />';
	} else {
	    echo "Username/Password is incorrect.";
	}
    } else {
        echo "<div class=\"alert alert-danger\" role=\"alert\">Username/Password is incorrect.</div>";
    }
    $conn->close();
}
?>

<html>
<head>
<title>Login</title>
    <script src="lib/js/jquery-2.2.0.js"></script>
    <script src="lib/js/angular.js"></script>
    <script src="lib/js/bootstrap.js"></script>
    <link rel="stylesheet" href="lib/css/bootstrap.css"/>
    <link rel="stylesheet" href="lib/css/bootstrap-theme.css"/>
</head>

<body>
<form class="form-horizontal" action="/login.php" method="post">
<fieldset>

<legend>Login</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="email">E-mail Address</label>  
  <div class="col-md-5">
  <input id="email" name="email" type="text" placeholder="john@doe.com" value="<?php echo $email?>" class="form-control input-md" required="">
  </div>
</div>

<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="pass">Password</label>
  <div class="col-md-5">
    <input id="pass" name="pass" type="password" placeholder="password" class="form-control input-md glyphicon glyphicon-lock" required="">
    
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for=""></label>
  <div class="col-md-4">
    <button id="" name="" class="btn btn-primary">Login</button><br />
    <a href="./register.php">Register</a> | <a href="./lostpassword.php">Forgot Password</a>
  </div>
</div>

</fieldset>
</form>

</body>
</html>