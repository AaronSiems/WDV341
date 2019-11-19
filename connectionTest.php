<?php 
require_once('connectPDO.php');
?>

<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>

<body>
    <?php if(isset($conn)) { echo "Connection succesful";} else { echo $ConnectionError;} ?>
</body>
</html>
