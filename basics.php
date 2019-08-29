<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>

<body>
    <?php $yourName = "Aaron Siems"; ?>
    <h1> PHP Basics</h1>
    <h2> <?php echo"$yourName"; ?></h2>
    <?php 
        //Numbers
        $number1 = 12;
        $number2 = 24;
        $total = $number1 + $number2;
        echo "<p>Number 1: $number1
            </br>Number 2: $number2
            </br>Total: $total</p>";
    
        //Array
        $array = ["PHP", "HTML", "Javascript"];
        $js_array = json_encode($array);
        echo "<script>
                var JsArray = $js_array;
                for(var i = 0; i < JsArray.length; i++){
                    if(i < JsArray.length - 1){
                        document.write(JsArray[i] + ', ');
                    } else {
                        document.write(JsArray[i] + '.');
                    }
                }
            </script>";
    ?>
    
</body>
</html>
