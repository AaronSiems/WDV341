<?php

//1
function americaDate($date) {
    return "Date = " . date('m/d/Y', strtotime($date));
}
//2
function internationalDate($date) {
    return "Date = " . date('d/m/Y', strtotime($date));
}
//3
function stringStuff($string){
    //a
    $stringLength = strlen($string);
    //b
    $string = ltrim($string); 
    $string = rtrim($string);
    //c
    $stringLower = strtolower($string);
    //d
    if(stripos($string, 'DMACC') !== false) {
        $containDMACC = "true";
    } else {
        $containDMACC = "false";
    }
    
    return "String length: " . $stringLength . "</br> Cut White Space String: " . $string . "</br> Lowercase: " . $stringLower . "</br> Contains DMACC?: " . $containDMACC;
    
}
//4
function formatNumber($num) {
    $decimal = null;
    $formatedNum = "";
    $i = 0;
    
    //cut the decimal out for use later if exists.
    if(strpos($num, ".") != null){ 
        $decimal = substr($num, strpos($num, "."), strlen($num));
        $num = substr($num, 0, strpos($num, "."));
    }
    //first comma
    $firstComma = strlen($num) % 3;
    if ($firstComma > 0) {
        $formatedNum = substr($num, 0, $firstComma) . ",";
        $i = $i + $firstComma;
    }
    //loop commas
    while($i < strlen($num)){
        if ($i+3 < strlen($num)) {
            $formatedNum = $formatedNum . substr($num, $i, 3) . ",";
        } else {
            $formatedNum = $formatedNum . substr($num, $i, 3);
        }
        $i = $i+3;
    }
    
    //re-add decimal if needed
    if($decimal != null){
        $formatedNum = $formatedNum . $decimal;
    }
    return $formatedNum;
}

//5
function formatCurrency($num){
    $formatedNum = formatNumber($num); //call previous func
    //if decimal was given, use it, otherwise add our own
    if(strpos($formatedNum, ".") == null){
        return "$" . $formatedNum . ".00";
    } else {
        return "$" . $formatedNum;
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
    <h1>Problem 1</h1>
    <?php echo "<h3>" . americaDate("22-06-2011") . "</h3>" ?>
    
    <h1>Problem 2</h1>
    <?php echo "<h3>" . internationalDate("12/06/1996") . "</h3>" ?>
    
    <h1>Problem 3 - String manipulation ( This contains DmACc )</h1>
    <?php echo "<h3>" . stringStuff(" This contains DmACc ") . "</h3>" ?>
    
    <h1>Problem 4 - Format number (1234567890)</h1>
    <?php echo "<h3>" . formatNumber(1234567890) . "</h3>" ?>
    
    <h1>Problem 5 - Format a number into USD (123456)</h1>
    <?php echo "<h3>" . formatCurrency(123456) . "</h3>" ?>
</body>
</html>
