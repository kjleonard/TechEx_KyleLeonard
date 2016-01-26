<html>
<head>
<script src="lib/js/angular.js"></script>
<script src="lib/js/jquery-1.12.0.js"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <title>Hello World</title>
</head>

<body ng-app=>
     TEST 1: <p>Hello World - HTML</p>
    <div ng-init="$scope.disp = true">
        TEST 2: {{$scope.disp}} - > True will display if Angular is working
    </div>
    TEST 3: <div class="alert alert-success" role="alert">Bootstrap is working if I am green!</div>
    
    TEST 4: <?php echo "Hello World - PHP is working"; ?>
    
    <br />
    <p> There should be 4 tests working... if there are not four outputs above something is not configured correctly... </p>
</body>

</html>