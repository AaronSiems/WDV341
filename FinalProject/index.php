<?php
session_start();
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
        <title>Library</title>
    </head>

    <body>
        <section id="main" class="bg">
            <div class="container">
                <h1>Generic Library</h1>
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
                            <li class="nav-item"><a class="nav-link" href="login.php">Admin Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                            <?php } else { ?>
                            <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </nav>
                
                </br>
                <div class="row">
                    <div class="col-md">
                        <h3>Welcome to generic library's website.</h3>
                    </div>
                </div>
                </br>
                <div class="row">
                    <div class="col-md">
                        <img src="images/library.jpg" alt="interier of a library"><p class="img-footer">Photo by j zamora on Unsplash</p>
                    </div>
                    <div class="col-md">
                        <h4>
                            <a href="books.php" style="color: aqua;">Browse our selection of books here.</a>
                            </br>
                            </br>
                            <p>Our library offers many wonderful books and services such as public internet and computers, </p>
                        </h4>
                    </div>
                </div>
            </div>
        </section>
        
        
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
