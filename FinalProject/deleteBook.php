<?php
session_start();
if(isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
    if(isset($_GET['id'])) {
        try {
            require_once("connectPDO.php");
            $id = $_GET['id'];

            $sql = "
                DELETE
                FROM final_books
                WHERE books_id = $id";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            header( "refresh:5;url=books.php" );
            echo"Your request was processed and you will be redirected in 5 seconds. <a href='books.php'>Click here if you are not redirected.</a>";
        } catch (PDOException $ex) {
            $errorMessage = $ex->getMessage();
            header( "refresh:5;url=books.php" );
            echo"An error occured and the book was NOT deleted. You will be redirected in 5 seconds. <a href='books.php'>Click here if you are not redirected.</a>";
        }
    } else {
        header( "refresh:5;url=books.php" );
        echo"An error occured and the book was NOT deleted. You will be redirected in 5 seconds. <a href='books.php'>Click here if you are not redirected.</a>";
    }
} else {
    header("Location: login.php");
}
?>