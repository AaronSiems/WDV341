<?php
session_start();
if(isset($_SESSION['admin']) && $_SESSION['admin'] == true) {

    require_once("connectPDO.php");
    require_once("validator.php");
    
    $v = new Validator();
    $name = "";
    $author = "";
    $isbn = "";

    $errorMessage = "";
    $msg = "";


    //refill form
    if(isset($_POST["submit"])) {
        $name = $_POST["bookNameText"];
        $author = $_POST["authorText"];
        $isbn = $_POST["isbnText"];

        if (empty($name) || strlen($name) > 50) {
            $errorMessage .= "Invalid Name <br>";
        }
        if (empty($author || strlen($author) > 25)) {
            $errorMessage .= "Invalid Author <br>";
        }
        if (empty($isbn)) {
            $errorMessage .= "Invalid ISBN <br>";
        } else if (!$v::validateISBN($isbn)) {
            $errorMessage .= "Your ISBN has an error <br>";
        }
       

        if(empty($errorMessage)) {
            //do stuff with data

            try {
                $stmt = $conn->prepare("INSERT INTO final_books (books_name, books_author, books_isbn) VALUES (:name, :author, :isbn);");
                
                $formatISBN = substr($isbn, 0, 3) . "-" . substr($isbn, 3, 1) . "-" . substr($isbn, 4, 2) . "-" . substr($isbn, 6, 6) . "-" .substr($isbn, 12, 1);
                
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':author', $author);
                $stmt->bindParam(':isbn', $formatISBN);

                $stmt->execute();

                $msg = "<h1>The book '$name' was succesfully added to the table.</h1>";
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
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        
        <link href = "styles.css"
              rel = "stylesheet"
              type = "text/css" />
        
        <meta name="author" content="Aaron Siems">
        <meta name="description" content="WDV341 final project">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Book List</title>
    </head>

    <body>
        <script src=validate.js></script>
        <a href="login.php">Return to login page</a>
        <form name="eventsForm" method="post" action="addBook.php">

            <p>
                <label for="bookNameText">Book Name:</label>
                <input type="text" name="bookNameText" id="bookNameText" oninput="checkName()" value="<?php echo "$name" ?>"> <span class="error" id="nameError"></span>
            </p>
            <p>
                <label for="authorText">Book Author:</label>
                <input type="text" name="authorText" id="authorText" oninput="checkAuthor()" value="<?php echo "$author" ?>"> <span class="error" id="authorError"></span>
            </p>
            <p>
                <label for="isbnText">Book ISBN (no dashes[-], 13 numbers, 
                </br> <a href="https://en.wikipedia.org/wiki/International_Standard_Book_Number#ISBN-13_check_digit_calculation" class="infoLink">and follow proper check digit convention</a>): 
                </br> Exmaple: 1234567890128</label>
                <input type="text" name="isbnText" id="isbnText" oninput="checkISBN()" value="<?php echo "$isbn" ?>"><span class="error" id="isbnError"></span>
                
            </p>

            
            <p class="error"><?php echo $errorMessage;?> </p>
            
            <p>
                <input type="submit" name="submit" id="submit" value="Submit">
                <input type="submit" name="reset" id="reset" value="Reset">
            </p>
            
            <?php echo "<h1>$msg</h1>"; ?>
        </form>

        
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
