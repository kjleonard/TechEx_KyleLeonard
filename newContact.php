<?php
/*
if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}
*/
$loggedIn = isset($_COOKIE['userID']);
include "db.inc.php";

$userID = $_COOKIE['userID'];
if ($loggedIn) {
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    //Welcome the user
    $req = "SELECT * FROM `Users` WHERE `ID` = $userID";
    $result = $conn->query($req);
    $conn -> close();

    if ($result->num_rows > 0) {
        // output data of each row
        $row = $result->fetch_assoc();
        echo "<div class=\"alert alert-info\" role=\"alert\"><span>" . "<div align=\"left\">Welcome " . $row['firstName'] . " " . $row['lastName'] . '</div><div align="right"><a href="./logout.php">Log Out</a></div></span></div>';
    }
} else {
    echo '<meta http-equiv="refresh" content="0;URL=\'login.php\'" />';
}

if($_POST['fName'] != null){    
    //First/Last Name
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    
    //Email
    $email = $_POST['email'];
    
    //Address, City, State, Zip, Country
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['Zip'];
    $country = $_POST['country'];
    
    //Phones Cell, Fax, Business
    $cell = $_POST['cPhone'];
    $phone = $_POST['hPhone'];
    $fax = $_POST['fax'];
    $work = $_POST['wPhone'];
    
    //Gender Birthday
    $gender = $_POST['gender'];
    $bday = $_POST['bday'];
    
    //Owner ID
    $ownerID = $_COOKIE['userID'];
    
    $SQL_STR = "INSERT INTO `Contacts`(`OwnerID`, `FirstName`, `LastName`, `Email`, ";
    $SQL_STR = $SQL_STR . "`Street`, `City`, `State`, `Zip`, `Country`, `HomePhone`, `CellPhone`, `BusinessPhone`, ";
    $SQL_STR = $SQL_STR . "`Fax`, `Gender`, `Birthday`) VALUES ";
    $SQL_STR = $SQL_STR . "($ownerID, \"$fName\",\"$lName\",\"$email\",\"$street\",\"$city\",";
    $SQL_STR = $SQL_STR . "\"$state\",\"$zip\",\"$country\",\"$phone\",\"$cell\",\"$work\"";
    $SQL_STR = $SQL_STR . ",\"$fax\",\"$gender\",\"$bday\")";
    
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    //Add the quiz
    $req = $SQL_STR;
    $result = $conn->query($req);
    $conn -> close();

}


?>


<html>
    <head>
    <script src="lib/js/jquery-2.2.0.js"></script>
    <script src="lib/js/angular.js"></script>
    <script src="lib/js/bootstrap.js"></script>
    <link rel="stylesheet" href="lib/css/bootstrap.css"/>
    <link rel="stylesheet" href="lib/css/bootstrap-theme.css"/>
    <title>New Contact</title>
    </head>
    
    <body>
        <form class="form-horizontal" method="post" action="./newContact.php">
        <fieldset>

        <!-- Form Name -->
        <legend>New Contact</legend>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="fName">First Name</label>  
          <div class="col-md-4">
          <input id="fName" name="fName" type="text" placeholder="John" class="form-control input-md" required="">

          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="lName">Last Name</label>  
          <div class="col-md-4">
          <input id="lName" name="lName" type="text" placeholder="Doe" class="form-control input-md">

          </div>
        </div>
            <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="bday">Birthday</label>  
          <div class="col-md-4">
          <input id="bday" name="bday" type="text" placeholder="02/28/2015" class="form-control input-md">

          </div>
        </div>

        <!-- Select Basic -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="gender">Gender</label>
          <div class="col-md-2">
            <select id="gender" name="gender" class="form-control">
              <option value="m">Male</option>
              <option value="f">Female</option>
              <option value="o">Other</option>
            </select>
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="email">Email</label>  
          <div class="col-md-4">
          <input id="email" name="email" type="text" placeholder="john.doe@gmail.com" class="form-control input-md">

          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="street">Street Address</label>  
          <div class="col-md-4">
          <input id="street" name="street" type="text" placeholder="1234 main rd" class="form-control input-md">

          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="city">City</label>  
          <div class="col-md-4">
          <input id="city" name="city" type="text" placeholder="Omaha" class="form-control input-md">

          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="state">State</label>  
          <div class="col-md-2">
          <input id="state" name="state" type="text" placeholder="NE" class="form-control input-md">

          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="Zip">Zip</label>  
          <div class="col-md-2">
          <input id="Zip" name="Zip" type="text" placeholder="68145" class="form-control input-md">

          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="country">Country</label>  
          <div class="col-md-4">
          <input id="country" name="country" type="text" placeholder="USA" class="form-control input-md">

          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="cPhone">Cell Phone</label>  
          <div class="col-md-4">
          <input id="cPhone" name="cPhone" type="text" placeholder="402-888-8999" class="form-control input-md">

          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="hPhone">Home Phone</label>  
          <div class="col-md-4">
          <input id="hPhone" name="hPhone" type="text" placeholder="402-888-9888" class="form-control input-md">

          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="fax">Fax</label>  
          <div class="col-md-4">
          <input id="fax" name="fax" type="text" placeholder="402-999-8999" class="form-control input-md">

          </div>
        </div>
            
                    <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="wPhone">Work Phone</label>  
          <div class="col-md-4">
          <input id="wPhone" name="wPhone" type="text" placeholder="402-999-8999" class="form-control input-md">

          </div>
        </div>

        <!-- Button -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="add"></label>
          <div class="col-md-4">
            <button id="add" name="add" class="btn btn-success">Add Contact</button>
          </div>
        </div>

        </fieldset>
        </form>
    </body>
</html>