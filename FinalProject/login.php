<?php
session_start();
$msg = "";
$username = "";
$password = "";
$msg = "";

if(isset($_SESSION['admin']) && $_SESSION['admin'] == true) { //Valid user
    $msg = "Welcome back " . $_SESSION['user'];
} else { //invalid user
    if(isset($_POST['submit'])) { //user is trying to sign in
        $username = $_POST['inName']; //self-posting username
        $password = $_POST['inPassword']; //do not return password but will be used for logic

        try {

            require_once("connectPDO.php");
            $sql = "
                SELECT users_username, users_password
                FROM final_users
                WHERE users_username='$username'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if($username == $row['users_username'] && $password == $row['users_password']){
                //valid
                $_SESSION['admin'] = true;
                $_SESSION['user'] = $username;
                $msg .= "Welcome back $username";
            } else {
                $_SESSION['admin'] = false;
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
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <link href = "styles.css"
              rel = "stylesheet"
              type = "text/css" />

        <meta name="author" content="Aaron Siems">
        <meta name="description" content="WDV341 final project">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
    </head>

    <body>
        <section id="main" class="bg">
            <div class="container">
                <h1>Generic Library Admin Login</h1>
                <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="collapsibleNavbar">
                        <ul class="navbar-nav">
                            <li><a class="nav-link" href="index.php">Home</a></li>
                            <li><a class="nav-link" href="books.php">Books</a></li>
                            <li><a class="nav-link" href="contact.php">Contact</a></li>
                        </ul>
                        <ul class="navbar-nav ml-auto">
                            <?php
                            if(isset($_SESSION['admin']) && $_SESSION['admin'] == true) { ?>
                            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                            <?php } else { ?>
                            <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </nav>

                </br>
            <?php
            if(isset($_SESSION['admin']) && $_SESSION['admin'] == true) { //Valid user?>
            <p>Welcome back <?php echo $_SESSION['user'];?> </br>
            What would you like to do today?</p>
            </br>
                <a href="books.php">Edit or delete books from the list</a> </br>
                <a href="addBook.php">Add a book</a> </br>
                <a href="logout.php">Logout</a>

            <?php } else { //not a valid user do stuff below?>
            <form method="post" name="loginForm" action="login.php">
                <p>Username: <input name="inName" type="text" value="<?php echo $username?>"/></p>
                <p>Password: <input name="inPassword" type="password"/></p>
                <p><input type="submit" value="Login" name="submit"></p>
            </form>

            <?php echo "<p class='error'>$msg</p>";}//close ?>
            </div>
        </section>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
