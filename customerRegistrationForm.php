<?php
require('FormValidator.php');
$v = new FormValidator();
$inName = "";
$inPhone = "";
$inEmail = "";
$inRegistration = "";
$inBadge = "";
$inFridayMeal = false;
$inSatMeal = false;
$inSunMeal = false;
$inRequest = "";
$robotValidation = false;

$robotError = "";
$errorMessage = "";

//if captcha solved robotValidation=true
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

//refill form
if(isset($_POST["submit"])) {
    $inName = $_POST["nameText"];
    $inPhone = $_POST["phoneText"];
    $inEmail = $_POST["emailText"];
    $inRegistration = $_POST["registration"];
    if (isset($_POST["badgeRadio"])) {
        $inBadge = $_POST["badgeRadio"];
    }
    if (isset($_POST["fridayCheck"])) {
        $inFridayMeal = true;
    }
    if (isset($_POST["saturdayCheck"])) {
        $inSatMeal = true;
    }
    if (isset($_POST["sundayCheck"])) {
        $inSunMeal = true;
    }
    $inRequest = $_POST["specialRequest"];

    if (!($v::validateName($inName))) {
        $errorMessage .= "Invalid Name <br>";
    }
    if (!($v::validatePhone($inPhone))) {
        $errorMessage .= "Invalid Phone <br>";
    }
    if (!($v::validateEmail($inEmail))) {
        $errorMessage .= "Invalid Email <br>";
    }
    if (empty($inRegistration)) {
        $errorMessage .= "Must select registration type <br>";
    }
    if (empty($inBadge)) {
        $errorMessage .= "Must select a badge holder <br>";
    }
    if (!($v::validateTextArea($inRequest, 200))) {
        $errorMessage .= "Your request is too long or contains an invalid character <br>";
    }
    if ($robotValidation) { 
        if(empty($errorMessage)) {
            //do stuff with data
            //echo "<p> $inName, $inPhone, $inEmail, $inRegistration, $inBadge, $inFridayMeal, $inSatMeal, $inSunMeal, $inRequest </p>";
        }
    } else {
        $robotError = "Captcha failed";
    }


}

if(isset($_POST["reset"])) {
    //runs top of page to set values to default
}


?>
<!DOCTYPE html>
<html >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>WDV341 Intro PHP - Self Posting Form</title>
        <style>

            #orderArea	{
                width:600px;
                border:thin solid black;
                margin: auto auto;
                padding-left: 20px;
            }

            #orderArea h3	{
                text-align:center;	
            }
            .error	{
                color:red;
                font-style:italic;	
            }

        </style>

        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>

    <body>
        <h1>WDV341 Intro PHP</h1>
        <h2>Unit-5 and Unit-6 Self Posting - Form Validation Assignment


        </h2>
        <p>&nbsp;</p>


        <div id="orderArea">
            <form name="form3" method="post" action="customerRegistrationForm.php">
                <h3>Customer Registration Form</h3>

                <p>
                    <label for="nameText">Name:</label>
                    <input type="text" name="nameText" id="nameText" value="<?php echo "$inName" ?>">
                </p>
                <p>
                    <label for="phoneText">Phone Number:</label>
                    <input type="text" name="phoneText" id="phoneText" value="<?php echo "$inPhone" ?>">
                </p>
                <p>
                    <label for="emailText">Email Address: </label>
                    <input type="text" name="emailText" id="emailText" value="<?php echo "$inEmail" ?>">
                </p>
                <p>
                    <label for="registration">Registration: </label>
                    <select name="registration" id="registration">
                        <option value="" <?php if(isset($inRegistration) && $inRegistration=="") {echo "selected";} ?> >Choose Type</option>
                        <option value="Attendee" <?php if(isset($inRegistration) && $inRegistration=="Attendee") {echo "selected";} ?>>Attendee</option>
                        <option value="Presenter" <?php if(isset($inRegistration) && $inRegistration=="Presenter") {echo "selected";} ?>>Presenter</option>
                        <option value="Volunteer" <?php if(isset($inRegistration) && $inRegistration=="Volunteer") {echo "selected";} ?>>Volunteer</option>
                        <option value="Guest" <?php if(isset($inRegistration) && $inRegistration=="Guest") {echo "selected";} ?>>Guest</option>
                    </select>
                </p>
                <p>Badge Holder:</p>
                <p>
                    <input type="radio" name="badgeRadio" id="clip" <?php if (isset($inBadge) && $inBadge=="clip") echo "checked";?> value="clip">
                    <label for="clip">Clip</label> <br>
                    <input type="radio" name="badgeRadio" id="lanyard" <?php if (isset($inBadge) && $inBadge=="lanyard") echo "checked";?> value="lanyard">
                    <label for="lanyard">Lanyard</label> <br>
                    <input type="radio" name="badgeRadio" id="magnet" <?php if (isset($inBadge) && $inBadge=="magnet") echo "checked";?> value="magnet">
                    <label for="magnet">Magnet</label>
                </p>
                <p>Provided Meals (Select all that apply):</p>
                <p>
                    <input type="checkbox" name="fridayCheck" id="fridayCheck" <?php if ($inFridayMeal) echo "checked";?>>
                    <label for="fridayCheck">Friday Dinner</label><br>
                    <input type="checkbox" name="saturdayCheck" id="saturdayCheck" <?php if ($inSatMeal) echo "checked";?>>
                    <label for="saturdayCheck">Saturday Lunch</label><br>
                    <input type="checkbox" name="sundayCheck" id="sundayCheck" <?php if ($inSunMeal) echo "checked";?>>
                    <label for="sundayCheck">Sunday Award Brunch</label>
                </p>
                <p>
                    <label for="textarea">Special Requests/Requirements: (Limit 200 characters)<br>
                    </label>
                    <textarea name="specialRequest" cols="40" rows="5" id="specialRequest"><?php echo $inRequest;?></textarea>
                </p>

                <div class="g-recaptcha" data-sitekey="6Ldwj7wUAAAAABFpKd-j8I0GWxb3zPCzX-yCZDx1"></div>
                <?php echo "<p> $robotError </p>"?>
                <?php echo "<p> $errorMessage </p>"?>
                <p>
                    <input type="submit" name="submit" id="submit" value="Submit">
                    <input type="submit" name="reset" id="reset" value="Reset">
                </p>
            </form>
        </div>

    </body>
</html>