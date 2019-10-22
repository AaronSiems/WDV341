<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>
    </head>

    <body>

        <?php
        require('FormValidator.php');
        $v = new FormValidator();

        function pass($b) {
            if ($b == false) {
                return "False";
            } else if ($b == true) {
                return "True";
            }
        }
        //bad html
        echo "<h1> Name Validation Checks </h1>"; //T F F F T
        echo "<h3> Aaron: " . pass($v::validateName("Aaron"));
        echo "<h3> 2: " . pass($v::validateName("2"));
        echo "<h3> {Blank Space}: " . pass($v::validateName(""));
        echo "<h3> @aron: " . pass($v::validateName("@aron"));
        echo "<h3> Aaron Siems: " . pass($v::validateName("Aaron Siems"));

        echo "<h1> Email Validation Checks </h1>"; //F T F F T F
        echo "<h3> a: " . pass($v::validateEmail("a"));
        echo "<h3> aaron@gmail.com: " . pass($v::validateEmail("aaron@gmail.com"));
        echo "<h3> aaron@gmail: " . pass($v::validateEmail("aaron@gmail"));
        echo "<h3> aaron at gmail.com: " . pass($v::validateEmail("aaron at gmail.com"));
        echo "<h3> arron2@gmail.com: " . pass($v::validateEmail("aaron2@gmail.com"));
        echo "<h3> aaron@gm@il.com: " . pass($v::validateEmail("aaron@gm@il.com"));

        echo "<h1> Phone Validation Checks </h1>"; //T F F F
        echo "<h3> 1234567890: " . pass($v::validatePhone("1234567890"));
        echo "<h3> abcdefghij: " . pass($v::validatePhone("abcdefghij"));
        echo "<h3> {Blank Space}: " . pass($v::validatePhone(""));
        echo "<h3> (123)4567890: " . pass($v::validatePhone("(123)4567890"));

        echo "<h1> Text Area Validation Checks </h1>"; //T F T
        echo "<h3> 1234567890 max size 20: " . pass($v::validateTextArea("1234567890", 20));
        echo "<h3> 1234567890 max size 9: " . pass($v::validateTextArea("1234567890", 9));
        echo "<h3> Hello Mr. Duck32 max size 20: " . pass($v::validateTextArea("Hello Mr. Duck32", 20));
        ?>

    </body>
</html>
