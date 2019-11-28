<?php
session_start();

$_SESSION['validUser'] = false;
session_unset();	//remove all session variables related to current session
session_destroy();

header( "refresh:5;url=login.php" );
echo"Succesfully logged out. You will be redirected back to login page in 5 seconds. <a href='login.php'>Click here if you are not redirected.</a>";
?>