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
?>

<html>

<head>
<title>Home</title>
    <script src="lib/js/jquery-2.2.0.js"></script>
    <script src="lib/js/angular.js"></script>
    <script src="lib/js/bootstrap.js"></script>
    <link rel="stylesheet" href="lib/css/bootstrap.css"/>
    <link rel="stylesheet" href="lib/css/bootstrap-theme.css"/>
</head>
</html>