<?php

	setCookie('userID', 123, time() - 86400, '/');
    	echo '<meta http-equiv="refresh" content="0;URL=\'login.php\'" />';

?>

<html>
<head>
<title>Logout</title>
</head>
<body>

<h2>You have successfully logged out. Redirecting to homepage...</h2>

</body>

</html>