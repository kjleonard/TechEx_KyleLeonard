<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.2/angular.min.js"></script>
<?php
include 'db.inc.php';
 
$email = $_REQUEST['email'];
$pass = $_REQUEST['pass'];
$firstName = $_REQUEST['fName'];
$lastName = $_REQUEST['lName'];
$pass = md5($pass);
 
if ($email != '' && $pass != '' && $firstName != '' && $lastName != '') {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    $req = "SELECT * FROM `Users` WHERE `email` = '$email'";
    $result = $conn->query($req);

    if ($result->num_rows > 0) {
        echo "<div class=\"alert alert-danger\" role=\"alert\">We only allow one account per user.  If you forgot your password please request a new one be sent to your email.</div>";
    } else {
   	$req = "INSERT INTO `Users`(`firstName`, `lastName`, `email`, `password`) VALUES ('$firstName','$lastName','$email','$pass')";
	$result = $conn->query($req);

	if($result == 1) { 
	    echo "<div class=\"alert alert-success\" role=\"alert\">Profile has been created!  <br /> You will now be redirected to the login page in 10 seconds.  If you are not automatically redirected please click <a href=\"login.php\">here</a></div>";
	    echo '<meta http-equiv="refresh" content="10;URL=\'login.php\'" />';
        } else {
    	    echo "<div class=\"alert alert-danger\" role=\"alert\">Error account was NOT created.</div>"; 
        }
    }

    $conn->close();
} else {

}
?>

<html>
<head>
<title>Register</title>
    <script src="lib/js/jquery-2.2.0.js"></script>
    <script src="lib/js/angular.js"></script>
    <script src="lib/js/bootstrap.js"></script>
    <link rel="stylesheet" href="lib/css/bootstrap.css"/>
    <link rel="stylesheet" href="lib/css/bootstrap-theme.css"/>
</head>

<body ng-app>   
<form class="form-horizontal" action="/register.php" method="post">
<fieldset>

<!-- Form Name -->
<legend>Register</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="fName">First Name</label>  
  <div class="col-md-4">
  <input id="fName" name="fName" placeholder="John" class="form-control input-md" required="" type="text">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="lName">Last Name</label>  
  <div class="col-md-4">
  <input id="lName" name="lName" placeholder="Doe" class="form-control input-md" required="" type="text">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="email">Email Address</label>  
  <div class="col-md-4">
  <input id="email" name="email" placeholder="john@doe.com" class="form-control input-md" required="" type="text">
  <span class="help-block">This will only be used as a username and a way to reset your password.  We will not send you spam!</span>  
  </div>
</div>

<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="pass">Password</label>
  <div class="col-md-4">
    <input id="pass" name="pass" placeholder="*********" class="form-control input-md" ng-model="password" required="" type="password">
    
  </div>
</div>

<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="pass2">Password (again)</label>
  <div class="col-md-4">
    <input id="pass2" name="pass2" placeholder="*********" class="form-control input-md" ng-model="password2" required="" type="password">
    <label ng-if="password != password2"> Passwords do not match!</label>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit"></label>
  <div class="col-md-4">
    <button id="submit" ng-disabled="password != password2" name="submit" class="btn btn-primary">Submit Registration</button>
      <br><a href="/login.php">Login</a> | <a href="/lostpassword.php">Forgot Password</a>
  </div>
</div>

</fieldset>
</form>

</body>


</html>