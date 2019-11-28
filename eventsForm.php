<?php
session_start();
if(isset($_SESSION['validUser']) && $_SESSION['validUser'] == true) {

    require_once("connectPDO.php");
    require_once("FormValidator.php");

    $v = new FormValidator();
    $name = "";
    $description = "";
    $presenter = "";
    date_default_timezone_set('America/Chicago');
    $date = date('Y-m-d', time());
    $time = date('G:i', time());

    $errorMessage = "";


    //refill form
    if(isset($_POST["submit"])) {
        $name = $_POST["nameText"];
        $description = $_POST["descText"];
        $presenter = $_POST["presenterText"];
        $date = $_POST["date"];
        $time = $_POST["time"];

        if (empty($name)) {
            $errorMessage .= "Invalid Name <br>";
        } else if (!($v::validateTextArea($description, 150))) {
            $errorMessage .= "Invalid Name <br>";
        }
        if (empty($description)) {
            $errorMessage .= "Invalid Description <br>";
        } else if (!($v::validateTextArea($description, 150))) {
            $errorMessage .= "Invalid Description <br>";
        }
        if (!($v::validateName($presenter))) {
            $errorMessage .= "Invalid Presenter <br>";
        }

        if(empty($errorMessage)) {
            //do stuff with data

            echo($name . "  " . $description . "  " . $presenter . "  " . $date . "  " . $time . "  " . $errorMessage);
            try {
                $stmt = $conn->prepare("INSERT INTO wdv341_events (event_name, event_description, event_presenter, event_date, event_time) VALUES (:name, :desc, :presenter, :date, :time);");

                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':desc', $description);
                $stmt->bindParam(':presenter', $presenter);
                $stmt->bindParam(':date', $date);
                $stmt->bindParam(':time', $time);

                $stmt->execute();

                echo("<h1>Your data was succesfully added to the table.</h1>");
            } catch (PDOException $ex) {
                $errorMessage = $ex->getMessage();
            } 
        }
    }
} else {
    header("Location: login.php");
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
    </head>

    <body>
        <h1>WDV341</h1>
        <h2>SQL Insert to wdv341_events table</h2>
        <a href="login.php">Return to login page</a>
        <form name="eventsForm" method="post" action="eventsForm.php">

            <p>
                <label for="nameText">Event Name:</label>
                <input type="text" name="nameText" id="nameText" value="<?php echo "$name" ?>">
            </p>
            <p>
                <label for="descText">Event Description:</label>
                <input type="text" name="descText" id="descText" value="<?php echo "$description" ?>">
            </p>
            <p>
                <label for="presenterText">Event Presenter:</label>
                <input type="text" name="presenterText" id="presenterText" value="<?php echo "$presenter" ?>">
            </p>

            <p>
                <label for="date">Event date:</label>
                <input type="date" name="date" id="date" value="<?php echo "$date" ?>">
            </p>

            <p>
                <label for="time">Event time (CNT):</label>
                <input type="time" name="time" id="time" value="<?php echo "$time" ?>">
            </p>

            <?php echo "<p class='error'> $errorMessage </p>"?>
            <p>
                <input type="submit" name="submit" id="submit" value="Submit">
                <input type="submit" name="reset" id="reset" value="Reset">
            </p>
        </form>

    </body>
</html>
