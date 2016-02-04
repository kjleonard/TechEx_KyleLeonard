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
        echo "<div class=\"alert alert-info\" role=\"alert\"><span>" . "<div align=\"left\">Welcome " . $row['firstName'] . " " . $row['lastName'] . '</div><div align="right"><a href="./profile.php">Profile</a> | <a href="./logout.php">Log Out</a></div></span></div>';
    }
} else {
    echo '<meta http-equiv="refresh" content="0;URL=\'login.php\'" />';
}
?>

<html ng-app>

<head>
<title>Home</title>
    <script src="lib/js/jquery-2.2.0.js"></script>
    <script src="lib/js/angular.js"></script>
    <script src="lib/js/bootstrap.js"></script>
    <link rel="stylesheet" href="lib/css/bootstrap.css"/>
    <link rel="stylesheet" href="lib/css/bootstrap-theme.css"/>
    
    <script type="text/javascript">
function formSubmit(setID)
{
  document.forms[0].contactID.value = setID;
  document.forms[0].submit();
}
</script>
    
    
    
    
    <div class="panel-group" style="padding=2%;">
    <div class="panel panel-default" style="width: 20%; float: left;">
    <div class="panel-heading">
    <h3 class="panel-title">Contacts</h3>
    </div>
  <div class="panel-body">
      <a href="newContact.php"><button class="btn btn-success">New Contact</button></a>
      <?php
            $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 

            $req = "SELECT * FROM `Contacts` WHERE `OwnerID` = '$userID'";
            $result = $conn->query($req);

            if ($result->num_rows > 0) {
                // output data of each row
                    echo "<div class=\"row\">";
                    while($row = $result->fetch_assoc()) {
	                   echo '<br /><br /><a href="javascript:formSubmit(' . $row['ID'] . ');"> <input type="submit" class="btn btn-primary" value="'.$row['LastName']. ', ' . $row['FirstName'] .'"></a>'; 	
                    }
                    echo '</div>';
}	

$conn -> close();
?>
      <form action="index.php" method="POST">
          <input type="hidden" name="contactID" value="-1">
      </form>
  </div>
</div>
        
        
        <div class="panel panel-default" style="width: 79%; float: right;">
    <div class="panel-heading">
    <h3 class="panel-title">Contact Details</h3>
    </div>
  <div class="panel-body">
      <?php
        if($_POST['contactID'] == null)
        {
            echo "Select a contact, the details will display here!";
        }else{
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 
            $contactID = $_POST['contactID'];
            $req = "SELECT * FROM `Contacts` WHERE `OwnerID` = '$userID' AND `ID` = '$contactID'";
            $result = $conn->query($req);
            $row = $result ->fetch_assoc();
            $conn -> close();
            
            echo $row['FirstName'] . " " . $row['LastName'] . "<br />";
                if($row['Gender'] == 'm')
                    echo "Male <br />";
                elseif($row['Gender'] == 'f')
                    echo "Female <br />";
                else
                    echo "Gender: Other/Not Listed <br />";
            echo "Birthday: " . $row['Birthday'] . "<br /><br />";
            echo "Cell: " . $row['CellPhone'] . "<br /> Home: " . $row['HomePhone'] . "<br />" . "Work: ". $row['BusinessPhone'] . "<br />Fax: " . $row['Fax'];
            echo "<br /><br /> E-mail: " . $row['Email'];
            
            echo "<br /> <br /> Address <br />";
            echo $row['Street'] . "<br />" . $row['City'] . ", " . $row['State'] . " " . $row['Zip'] . "<br />" . $row['Country'];
            echo "<br /> <br />";
            echo "<a href=\"./updateContact.php?contactID=" . $row['ID'] . "\"><button class=\"btn btn-primary\">Update Contact</button></a>";
            
        }
      1
      ?>
  </div>
</div>
</head>
</html>