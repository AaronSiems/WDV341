<?php
session_start();
require_once("Emailer.php");

$emailOut = "admin@aaronsiems.com";
$email = "";
$subject = "";
$message = "";

$robotValidation = false;
$robotError = "";
$errorMessage = "";
$Success_Message = "";

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
    //Grab variables for self-post
    $email = $_POST["email"];
    $message = $_POST["msg"];
    $subject = $_POST["subject"];



    if ($robotValidation) { //Check captcha then errors
        $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

        if(!preg_match($email_exp,$email)) {
            $errorMessage .= 'The Email Address you entered does not appear to be valid.<br />';
        }


        if(strlen($message) < 2) {
            $errorMessage .= 'The Comments you entered do not appear to be valid.<br />';
        }

        if(strlen($errorMessage) > 0) {
            //Do nothing, error message will appear when page loads
        } else { //No errors - send mail

            function clean_string($string) {
                $bad = array("content-type","bcc:","to:","cc:","href");
                return str_replace($bad,"",$string);
            }
            $email_message = "Message: ".clean_string($message)."\n";
            $subject = clean_string($subject);
            
            $emailSend = new Emailer($email, $emailOut, $subject, $email_message);
            $out = $emailSend->sendEmail();
            
            $confirmSubj = "Confirmation Email";
            $confirmMsg = "Your message to generic library was sent. Email info: " . $out;
            $confirmEmail = new Emailer($emailOut, $email, $confirmSubj, $confirmMsg);
            $uselessVar = $confirmEmail->sendEmail();
            
            $Success_Message = "Your email was sent </br><a href='index.php'>Return to homepage?</a>";
        }
    } else {
        $robotError = "Captcha failed";
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
        <title>Library Contact</title>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>

    <body>
        <section id="main" class="bg">
            <div class="container">
                <h1>Generic Library Contact Page</h1>
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
                
                <div class="row">
                    <div class="col">
                    <form id="contact" action="contact.php" method="post">

                        <div id="formitem">
                            <label for="email"> Email: </label>
                            <input type="email" name="email" value="<?php echo"$email"?>"><br />
                        </div>

                        <div id="formitem">
                            <label for="subject">Subject: </label>
                            <input type="text" name="subject" value="<?php echo"$subject"?>">
                                
                            </select><br />
                        </div>

                        <div id="formitem">
                            <textarea name="msg" form="contact" placeholder="Enter your message here"><?php echo"$message"?></textarea><br />
                        </div>
                        <div class="g-recaptcha" data-sitekey="6Ldwj7wUAAAAABFpKd-j8I0GWxb3zPCzX-yCZDx1"></div>
                        <?php echo "<p class='captchaError'> $robotError </p>"?>
                        <?php echo "<p class='generalError'> $errorMessage </p>"?>
                        <?php echo "<p class='success'> $Success_Message </p>"?>
                        <p>
                            <input type="submit" name="submit" id="submit" value="Submit">
                            <input type="submit" name="reset" id="reset" value="Clear fields"/>
                    </form>
                    </div>
                </div>
            </div>
        </section>
        
        
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
