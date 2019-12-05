<?php 
require_once("Emailer.php");

$Sender = "aaronjsiems@gmail.com";
$SendTo = "admin@aaronsiems.com";
$Subj = "Test";
$Mess = "This is a test message.";

$email = new Emailer($Sender, $SendTo, $Subj, $Mess);
?>

<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>
    </head>

    <body>
        <?php $out = $email->sendEmail(); echo"$out";?>
    </body>
</html>
