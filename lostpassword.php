<?php
$loggedIn = isset($_COOKIE['userID']);
include 'db.inc.php';

$email = $_REQUEST['email'];
$key = $_REQUEST['key'];

//Generate a new random password
function randomPassword($len) {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    
    for ($i = 0; $i < $len; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

//If the user is already logged in just redirect them to the home page
if ($loggedIn) {
    echo '<meta http-equiv="refresh" content="2;URL=\'index.php\'" />';
}

//Alright they may have entered a username and password
if ($key != '') {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    $req = "SELECT * FROM `LostPassword` WHERE `Code` = '$key'";
    $result = $conn->query($req);
    
    if ($result->num_rows > 0) {
    	$row = $result->fetch_assoc();
    	if ($row['Expiry'] > time()) {
      	    $password = randomPassword(8);
      	    $to      = $row['Email'];
            $subject = 'New Password';
            $message = 'Your new password is: ' . $password . ' You may chage it in the profile page';
            $headers = 'From: lostpassword@mmsquiz.com' . "\r\n" .
            'Reply-To: support@mmsquiz.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

      	    mail($to, $subject, $message, $headers);
      	    // "encrpytion"
            $password = md5($password);
            $email2 = $row['Email'];

            //Set the user's new password
            $req = "UPDATE `Users` SET  `password` = '$password' WHERE `email` = '$email2'";
            $result = $conn->query($req);

            //Set the key to expired
            $req = "UPDATE `LostPassword` SET `Expiry`=0 WHERE `Code` = '$key'";
            $result = $conn->query($req);
            
            echo "<div class=\"alert alert-success\" role=\"alert\">Your new password has been sent to your email, you may now login using it.</div>";
        } else {
            echo "<div class=\"alert alert-danger\" role=\"alert\">The key you have does not exist or is expired, if you think this is an error please email support@mmsquiz.com.</div>"; 
        }
        $conn->close();
    }
}

//Entered email for password recovery

if ($email != '') {
    $key = randomPassword(32);
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $req = "SELECT * FROM `Users` WHERE `email` = '$email'";
    $result = $conn->query($req);

    if ($result->num_rows > 0) {
        //INSERT KEY
        $expire = time() + 3600;
        $req = "INSERT INTO `LostPassword`(`Email`, `Code`, `Expiry`) VALUES ('$email','$key', $expire)";
        $result = $conn->query($req);
        //SEND Them KEY to unlock
        $to      = $email;
        $subject = 'Reset Password';
        $message = 'There has been a request to reset your password, if you made this request please click the link below, if not please ignore this email. http://contact.sitetobe.com/lostpassword.php?key=' . $key;
        $headers = 'From: lostpassword@mmsquiz.com' . "\r\n" .
        'Reply-To: support@mmsquiz.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
        
        mail($to, $subject, $message, $headers);
        
        echo "<div class=\"alert alert-success\" role=\"alert\">Please check your email for a link to change your password.</div>";
    } else {
        echo "<div class=\"alert alert-danger\" role=\"alert\">User does not exist, if you think this is an error please email support@mmsquiz.com.</div>";   
    }
    $conn->close();
}
?>

<html>
<head>
<title>Reset Lost Password</title>
    <script src="lib/js/jquery-2.2.0.js"></script>
    <script src="lib/js/angular.js"></script>
    <script src="lib/js/bootstrap.js"></script>
    <link rel="stylesheet" href="lib/css/bootstrap.css"/>
    <link rel="stylesheet" href="lib/css/bootstrap-theme.css"/>
</head>

<body>
<form class="form-horizontal" action="/lostpassword.php" method="post">
<fieldset>

<legend>Reset Password</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="email">E-mail Address</label>  
  <div class="col-md-5">
    <input id="email" name="email" type="text" placeholder="john@doe.com" value="<?php echo $email?>" class="form-control input-md" required="">
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for=""></label>
  <div class="col-md-4">
    <button id="" name="" class="btn btn-primary">Reset Password</button><br />
    <a href="/register.php">Register</a> | <a href="/login.php">Login</a>
  </div>
</div>

</fieldset>
</form>

</body>

</html>