<?php
require_once("connectPDO.php");


$robotValidation = false;
$table = "
<tr> 
    <th>Event Name</th>
    <th>Event Description</th>
    <th>Event Presenter</th>
    <th>Event Date</th>
    <th>Event Time</th>
</tr>";


$robotError = "";
$errorMessage = "";



//if captcha solved robotValidation=true
if(isset($_POST["g-recaptcha-response"]) && !empty($_POST["g-recaptcha-response"])) {
    $secret = "6Ldwj7wUAAAAAKBlnPpB5cX-E72twjQc4SfpOK8y";
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
    $responseData = json_decode($verifyResponse);
    if($responseData->success)
    {
        $robotValidation = true;
    }
    else
    {
        $robotValidation = false;
    }
}


if(isset($_POST["submit"])) {
    if ($robotValidation) { 
        if(empty($errorMessage)) {
            try {
                $sql = "
                SELECT event_name, event_description, event_presenter, DATE_FORMAT(event_date, '%c/%e/%Y'), event_time
                FROM wdv341_events
                WHERE event_id = :id";
                $out = "";
                $rows = true;
                $first = true;
                $currentID = 1;



                if($stmt = $conn->prepare($sql)) {
                    $event_id = $currentID;
                    $stmt->bindParam(":id", $event_id);
                }
                $stmt->execute();
                $out = $stmt->fetch();
                if ($out[0] == null) {
                    //if first time through
                    //$first will remain true
                } else {

                    $table .= "
                    <tr>
                        <td>$out[0]</td>
                        <td>$out[1]</td>
                        <td>$out[2]</td>
                        <td>$out[3]</td>
                        <td>$out[4]</td>
                    </tr>";
                    
                    $first = false;
                }
                


                if($first){
                    $table = "Table is empty"; //Catch empty table
                }
            } catch (PDOException $ex) {
                $errorMessage = $ex->getMessage();
            } 
        }
    } else {
        $robotError = "Captcha failed";
    }
}

if(isset($_POST["reset"])) {
    //runs top of page to set values to default
}
?>

<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Events insert</title>
        <style>
            .error	{
                color:red;
                font-style:italic;	
            }
        </style>

        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>

    <body>
        <h1>WDV341</h1>
        <h2>SQL Select one row from wdv341_events table</h2>

        <form name="selectEventsForm" method="post" action="selectOneEvent.php">
            <div class="g-recaptcha" data-sitekey="6Ldwj7wUAAAAABFpKd-j8I0GWxb3zPCzX-yCZDx1"></div>
            <?php echo "<p class='error'> $robotError </p>"?>
            <?php echo "<p class='error'> $errorMessage </p>"?>
            <p>
                <input type="submit" name="submit" id="submit" value="Get 1st row in table">
                <input type="submit" name="reset" id="reset" value="Reset">
            </p>
        </form>

        <table>
            <?php echo "$table"?>
        </table>
    </body>
</html>
