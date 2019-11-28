
<?php
$serverName = "localhost";
$databaseUsername = "root";
$databasePassword = "";
$database = "wdv341";

$ConnectionError = "";

try {
    $conn = new PDO("mysql:host=$serverName;dbname=$database", $databaseUsername, $databasePassword);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully"; 
}
catch(PDOException $e)
{
    $ConnectionError = $e;
}
?>

