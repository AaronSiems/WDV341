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
                $stmt = $conn->prepare("UPDATE wdv341_events 
            SET event_name='$name', 
            event_description='$description', 
            event_presenter='$presenter', 
            event_date='$date', 
            event_time='$time'
            WHERE event_id='" . $_GET['id'] . "';");

                $stmt->execute();

                echo("<h1>The event was sucessfully edited.</h1>");
            } catch (PDOException $ex) {
                $errorMessage = $ex->getMessage();
            } 
        }
    } else { //Submit was not clicked
        if(isset($_GET['id'])) {
            try {
                $id = $_GET['id'];

                $sql = "
                SELECT event_id, event_name, event_description, event_presenter, DATE_FORMAT(event_date, '%Y-%c-%e') AS date, event_time
                FROM wdv341_events
                WHERE event_id = $id";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $name = $row['event_name'];
                $description = $row['event_description'];
                $presenter = $row['event_presenter'];
                $date = $row['date'];
                $time = $row['event_time'];
            } catch (PDOException $ex) {
                $errorMessage = $ex->getMessage();
                header( "refresh:5;url=selectEvents.php" );
                echo"An error occured, please try again later. You will be redirected back to selectEvents in 5 seconds. <a href='selectEvents.php'>Click here if you are not redirected.</a>";
            }
        } else {
            header( "refresh:5;url=selectEvents.php" );
            echo"An error occured, the record to edit was not found. You will be redirected back to selectEvents in 5 seconds. <a href='selectEvents.php'>Click here if you are not redirected.</a>";
        }
    }

    if(isset($_POST["reset"])) {
        if(isset($_GET['id'])) {
            try {
                $id = $_GET['id'];

                $sql = "
                SELECT event_id, event_name, event_description, event_presenter, DATE_FORMAT(event_date, '%Y-%c-%e') AS date, event_time
                FROM wdv341_events
                WHERE event_id = $id";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $name = $row['event_name'];
                $description = $row['event_description'];
                $presenter = $row['event_presenter'];
                $date = $row['date'];
                $time = $row['event_time'];
            } catch (PDOException $ex) {
                $errorMessage = $ex->getMessage();
                header( "refresh:5;url=selectEvents.php" );
                echo"An error occured, please try again later. You will be redirected back to selectEvents in 5 seconds. <a href='selectEvents.php'>Click here if you are not redirected.</a>";
            }
        } else {
            header( "refresh:5;url=selectEvents.php" );
            echo"An error occured, the record to edit was not found. You will be redirected back to selectEvents in 5 seconds. <a href='selectEvents.php'>Click here if you are not redirected.</a>";
        }
    }
} else {
    header("Location: login.php");
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
        <h2>SQL Edit event in wdv341_events table</h2>
        <form name="eventsForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?id=" . $_GET['id'] ?>">

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
                <input type="submit" name="submit" id="submit" value="Update">
                <input type="submit" name="reset" id="reset" value="Reset">
            </p>
        </form>

    </body>
</html>
