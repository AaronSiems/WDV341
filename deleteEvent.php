<?php
session_start();
if(isset($_SESSION['validUser']) && $_SESSION['validUser'] == true) {
    if(isset($_GET['id'])) {
        try {
            require_once("connectPDO.php");
            $id = $_GET['id'];

            $sql = "
                DELETE
                FROM wdv341_events
                WHERE event_id = $id";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            header( "refresh:5;url=selectEvents.php" );
            echo"Your request was processed and you will be redirected in 5 seconds. <a href='selectEvents.php'>Click here if you are not redirected.</a>";
        } catch (PDOException $ex) {
            $errorMessage = $ex->getMessage();
            header( "refresh:5;url=selectEvents.php" );
            echo"An error occured and the row was NOT deleted. You will be redirected in 5 seconds. <a href='selectEvents.php'>Click here if you are not redirected.</a>";
        }
    } else {
        header( "refresh:5;url=selectEvents.php" );
        echo"An error occured and the row was NOT deleted. You will be redirected in 5 seconds. <a href='selectEvents.php'>Click here if you are not redirected.</a>";
    }
} else {
    header("Location: login.php");
}
?>