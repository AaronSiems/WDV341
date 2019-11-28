<?php
session_start();
if(isset($_SESSION['validUser']) && $_SESSION['validUser'] == true) {
    require_once("connectPDO.php");

    $errorMessage = "";


    if(isset($_POST["submit"])) {
        if(empty($errorMessage)) {
            try {
                $sql = "
                SELECT event_id, event_name, event_description, event_presenter, DATE_FORMAT(event_date, '%c/%e/%Y') AS event_date, event_time
                FROM wdv341_events";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
            } catch (PDOException $ex) {
                $errorMessage = $ex->getMessage();
            } 
        }
    }

    if(isset($_POST["reset"])) {
        //runs top of page to set values to default
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
        <title>Events Select</title>
        <style>
            .error	{
                color:red;
                font-style:italic;	
            }
            th {
                text-decoration: underline;
            }
        </style>

    </head>

    <body>
        <h1>WDV341</h1>
        <h2>SQL Select from wdv341_events table</h2>
        <a href="login.php">Return to login page</a>
        <form name="selectEventsForm" method="post" action="selectEvents.php">
            <?php echo "<p class='error'> $errorMessage </p>"?>
            <p>
                <input type="submit" name="submit" id="submit" value="Get all rows in table">
                <input type="submit" name="reset" id="reset" value="Reset">
            </p>
        </form>

        <table>
            <tr>
                <th>Event Name</th>
                <th>Event Description</th>
                <th>Event Presenter</th>
                <th>Event Date</th>
                <th>Event Time</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>

            <?php 
    if(isset($sql)) { //prepared statement was run
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "
                        <tr>
                            <td>" . $row['event_name'] . "</td>
                            <td>" . $row['event_description'] . "</td>
                            <td>" . $row['event_presenter'] . "</td>
                            <td>" . $row['event_date'] . "</td>
                            <td>" . $row['event_time'] . "</td>
                            <td>
                            <form name='editForm' method='get' action='updateEventsForm.php'>
                            <button type='submit' name='id' value='".$row['event_id'] ."'>Update</button></form></td>
                            <td>
                            <form name='deleteForm' method='get' action='deleteEvent.php'>
                            <button type='submit' name='id' value='".$row['event_id'] ."'>Delete</button></form></td>
                        </tr>
                        ";
        }
    }
            ?>
        </table>
    </body>
</html>
