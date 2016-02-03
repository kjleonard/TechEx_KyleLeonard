<?php
$loggedIn = isset($_COOKIE['userID']);
include "db.inc.php";

$userID = $_COOKIE['userID'];
$newEmail = $_POST['email'];
$old = $_POST['oldPass'];
$pass1 = $_POST['newPass'];
$pass2 = $_POST['newPass2'];

if ($loggedIn) {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    $demo_user = 91033504;

    //Welcome the user

    $req = "SELECT * FROM `Users` WHERE `ID` = $userID";
    $result = $conn->query($req);
    $conn->close();

    if ($result->num_rows > 0) {
	// output data of each row
	$row = $result->fetch_assoc();
	echo "<div class=\"alert alert-info\" role=\"alert\"><span>" . "<div align=\"left\">Welcome " . $row['firstName'] . " " . $row['lastName'] . '</div><div align="right" <a href="./logout.php"</a> <a href="./"> Home </a> | <a href="./logout.php">Log Out</a></div></span></div>';
    	$email = $row['email'];
    	$currentPass = $row['password'];
    }
} else {
    echo '<meta http-equiv="refresh" content="0;URL=\'login.php\'" />';
}

if (($newEmail != $email && $newEmail != '') || $pass1 != '') {
    //UPDATE `Users` SET `email`=[value-4],`password`=[value-5] WHERE `ID`=
    if ($pass1 == '') {
     	//Just update the email
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $req = "UPDATE `Users` SET `email`='$newEmail' WHERE `ID`=$userID";
        
	if ($demo_user == $userID) {} else {
            $result = $conn->query($req);
	}
        $conn->close();

        $email = $newEmail;
        echo "<div class=\"alert alert-success\" role=\"alert\">Profile has been updated.</div>";
    } else {
    //The email and/or password needs to be updated
        if ($pass1 != $pass2 && $old == '') {
            echo "<div class=\"alert alert-danger\" role=\"alert\">The old password is required when changing passwords</div>";
        } else if ($pass1 != $pass2) {
            echo "<div class=\"alert alert-danger\" role=\"alert\">Password was not changed, the new passwords do not match.</div>";
        } else if ($old == '') {
            echo "<div class=\"alert alert-danger\" role=\"alert\">You need to enter your current password into the old password section to change it.</div>";
        } else {
         //Data is there lets make it happen   
            $old = md5($old);
            $pass1 = md5($pass1);
            if ($currentPass == $old) {
             //Sweet update the pass and email
                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                } 

                $req = "UPDATE `Users` SET `email`='$newEmail', `password` = '$pass1' WHERE `ID`=$userID";
		
		if ($demo_user == $userID) {} else {
        	    $result = $conn->query($req);
		}

                $conn->close();

                $email = $newEmail;
                echo "<div class=\"alert alert-success\" role=\"alert\">Profile has been updated.</div>";
            } else {
                echo "<div class=\"alert alert-danger\" role=\"alert\">Password was not changed, the current password is incorrect.</div>";
            }
        }
    //Lets check that both passwords are the same and that the new password is correct
    }
}
?>
<html>
<head>
<title>Profile</title>
    <script src="lib/js/jquery-2.2.0.js"></script>
    <script src="lib/js/angular.js"></script>
    <script src="lib/js/bootstrap.js"></script>
    <link rel="stylesheet" href="lib/css/bootstrap.css"/>
    <link rel="stylesheet" href="lib/css/bootstrap-theme.css"/>
</head>
<body>
<form class="form-horizontal" method="POST" action="profile.php">
<fieldset>

<!-- Form Name -->
<legend>My Account</legend>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="userID">User ID</label>  
  <div class="col-md-4">
    <input id="userID" name="userID" readonly type="text" placeholder="<?php echo $userID ?>" class="form-control input-md">
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="email">Email</label>  
  <div class="col-md-4">
    <input id="email" name="email" type="text" value="<?php echo $email ?>" class="form-control input-md">
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="oldPass">Old Password</label>  
  <div class="col-md-4">
    <input id="oldPass" name="oldPass" type="password" placeholder="Password" class="form-control input-md">
    <span class="help-block">Only Enter IF Changing the Password</span>  
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="newPass">New Password</label>  
  <div class="col-md-4">
    <input id="newPass" name="newPass" type="password" placeholder="Password" class="form-control input-md">
    <span class="help-block">Only Enter IF Changing the Password</span>  
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="newPass2">New Password - Again</label>  
  <div class="col-md-4">
    <input id="newPass2" name="newPass2" type="password" placeholder="Password" class="form-control input-md">
    <span class="help-block">Only Enter IF Changing the Password</span>  
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit"></label>
  <div class="col-md-4">
    <button id="submit" name="submit" class="btn btn-primary">Update Profile</button>
  </div>
</div>

</fieldset>
</form>

</body>

</html>