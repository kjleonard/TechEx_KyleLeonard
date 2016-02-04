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
        echo "<div class=\"alert alert-info\" role=\"alert\"><span>" . "<div align=\"left\">Welcome " . $row['firstName'] . " " . $row['lastName'] . '</div><div align="right"><a href="./index.php">Home</a> | <a href="./profile.php">Profile</a> | <a href="./logout.php">Log Out</a></div></span></div>';
    }
} else {
    echo '<meta http-equiv="refresh" content="0;URL=\'login.php\'" />';
}
if($_POST['fName'])
{
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

    
    $SQL_STR = "UPDATE `Contacts` SET `FirstName`=\"$fName\",`LastName`=\"$lName\",`Email`=\"$email\",`Street`=\"$street\",`City`=\"$city\",`State`=\"$state\",`Zip`=\"$zip\",`Country`=\"$country\",`HomePhone`=\"$phone\",`CellPhone`=\"$cell\",`BusinessPhone`=\"$work\",`Fax`=\"$fax\",`Gender`=\"$gender\",`Birthday`=\"$bday\" WHERE `ID` =" . $_REQUEST['contactID'];
    
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    //Update
    $req = $SQL_STR;
    $result = $conn->query($req);
    $conn -> close();

    
}else if($_REQUEST['contactID'] != null){
    $contactID = $_REQUEST['contactID'];
    $req = "SELECT * FROM `Contacts` WHERE `ID` = '$contactID'";
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    $result = $conn->query($req);
    $conn -> close();
    $row = $result->fetch_assoc();
    //First/Last Name
    $fName = $row['FirstName'];
    $lName = $row['LastName'];

    //Email
    $email = $row['Email'];
    
    //Address, City, State, Zip, Country
    $street =  $row['Street'];
    $city =  $row['City'];
    $state =   $row['State'];
    $zip =  $row['Zip'];
    $country =  $row['Country'];
    
    //Phones Cell, Fax, Business
    $cell = $row['CellPhone'];
    $phone = $row['HomePhone'];
    $fax = $row['Fax'];
    $work = $row['BusinessPhone'];
    
    //Gender Birthday
    $gender = $row['Gender'];
    $bday = $row['Birthday'];
    
    //Owner ID
    $ownerID = $_COOKIE['userID'];
    
 

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
        <form class="form-horizontal" method="post" action="./updateContact.php">
        <fieldset>

        <!-- Form Name -->
        <legend>Update Contact</legend>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="fName">First Name</label>  
          <div class="col-md-4">
          <input id="fName" name="fName" value="<?php echo $fName;?>" type="text" placeholder="John" class="form-control input-md" required="">

          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="lName">Last Name</label>  
          <div class="col-md-4">
          <input id="lName" name="lName" value="<?php echo $lName;?>" type="text" placeholder="Doe" class="form-control input-md">

          </div>
        </div>
            <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="bday">Birthday</label>  
          <div class="col-md-4">
          <input id="bday" name="bday" value="<?php echo $bday;?>" type="text" placeholder="02/28/2015" class="form-control input-md">

          </div>
        </div>

        <!-- Select Basic -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="gender">Gender</label>
          <div class="col-md-2">
            <select id="gender" name="gender" value="<?php echo $gender;?>"class="form-control">
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
          <input id="email" name="email" value="<?php echo $email;?>" type="text" placeholder="john.doe@gmail.com" class="form-control input-md">

          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="street">Street Address</label>  
          <div class="col-md-4">
          <input id="street" name="street" type="text" value="<?php echo $street;?>" placeholder="1234 main rd" class="form-control input-md">

          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="city">City</label>  
          <div class="col-md-4">
          <input id="city" name="city" type="text" value="<?php echo $city;?>" placeholder="Omaha" class="form-control input-md">

          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="state">State</label>  
          <div class="col-md-2">
          <input id="state" name="state" type="text" value="<?php echo $state;?>" placeholder="NE" class="form-control input-md">

          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="Zip">Zip</label>  
          <div class="col-md-2">
          <input id="Zip" name="Zip" type="text" value="<?php echo $zip;?>" placeholder="68145" class="form-control input-md">

          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="country">Country</label>  
          <div class="col-md-4">
          <input id="country" name="country" type="text" value="<?php echo $country;?>" placeholder="USA" class="form-control input-md">

          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="cPhone">Cell Phone</label>  
          <div class="col-md-4">
          <input id="cPhone" name="cPhone" type="text" value="<?php echo $cell;?>" placeholder="402-888-8999" class="form-control input-md">

          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="hPhone">Home Phone</label>  
          <div class="col-md-4">
          <input id="hPhone" name="hPhone" type="text" value="<?php echo $phone;?>" placeholder="402-888-9888" class="form-control input-md">

          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="fax">Fax</label>  
          <div class="col-md-4">
          <input id="fax" name="fax" type="text" placeholder="402-999-8999" value="<?php echo $fax;?>" class="form-control input-md">

          </div>
        </div>
            
         <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="wPhone">Work Phone</label>  
          <div class="col-md-4">
          <input id="wPhone" name="wPhone" type="text" value="<?php echo $work;?>" placeholder="402-999-8999" class="form-control input-md">

          </div>
        </div>
        
        <!-- Text input-->
        <div class="form-group"> 
          <div class="col-md-4">
          <input id="contactID" name="contactID" type="hidden" value="<?php echo $_REQUEST['contactID'];?>" class="form-control input-md">
          </div>
        </div>

        <!-- Button -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="add"></label>
          <div class="col-md-4">
            <button id="add" name="add" class="btn btn-success">Update Contact</button>
          </div>
        </div>

        </fieldset>
        </form>
    </body>
</html>