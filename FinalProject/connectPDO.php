<?php
$serverName = "localhost";
$databaseUsername = "root";
$databasePassword = "";
$database = "wdv341";

try {
    $conn = new PDO("mysql:host=$serverName;dbname=$database", $databaseUsername, $databasePassword);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully"; 
}
catch(Exception $e)
{
    //Send an error to my email
    require_once("Emailer.php");
    $Sender = "aaronjsiems@gmail.com";
    $SendTo = "admin@aaronsiems.com";
    $Subj = "Error";
    $Mess = "An error occured in the final connectPDO file. \n"  + $e->getMessage();
    $email = new Emailer($Sender, $SendTo, $Subj, $Mess); 
    die();
}
?>

