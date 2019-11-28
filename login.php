<?php
session_start();
$msg = "";
$username = "";
$password = "";

if(isset($_SESSION['validUser']) && $_SESSION['validUser'] == true) { //Valid user
    $msg = "Welcome back " . $_SESSION['user'];
} else { //invalid user
    if(isset($_POST['submit'])) { //user is trying to sign in
        $username = $_POST['inName']; //self-posting username
        $password = $_POST['inPassword']; //do not return password but will be used for logic

        try {

            require_once("connectPDO.php");
            $sql = "
                SELECT event_user_name, event_user_password
                FROM event_user
                WHERE event_user_name='$username'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if($username == $row['event_user_name'] && $password == $row['event_user_password']){
                //valid
                $_SESSION['validUser'] = true;
                $_SESSION['user'] = $username;
                $msg .= "Welcome back $username";
            } else {
                $_SESSION['validUser'] = false;
                $msg .= "Invalid username or password";
            }
        } catch (PDOException $ex) {
            $errorMessage = $ex->getMessage();
        }
    } else { //user is seeing page for first time
    }
}

?>

<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>
    </head>

    <body>
        <h1>Login page for WDV341 event pages</h1>
        <h2><?php echo $msg;?></h2>
        <?php
        if(isset($_SESSION['validUser']) && $_SESSION['validUser'] == true) { //Valid user?>
        <a href="selectEvents.php">See All Events (edit/delete)</a> </br>
        <a href="eventsForm.php">Add event</a> </br>
        <a href="logout.php">Logout</a>

        <?php } else { //not a valid user do stuff below?>
        <form method="post" name="loginForm" action="login.php">
            <p>Username: <input name="inName" type="text" value="<?php echo $username?>"/></p>
            <p>Password: <input name="inPassword" type="password"/></p>
            <p><input type="submit" value="Login" name="submit"></p>
        </form>

        <?php }//close ?>
    </body>
</html>
