<?php
//Get the Event data from the server.
include_once("../connectPDO.php");

$sql = "
                SELECT event_name, event_description, event_presenter, DATE_FORMAT(event_date, '%c/%e/%Y') AS date, event_time
                FROM wdv341_event
                ORDER BY event_date DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();


?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>WDV341 Intro PHP  - Display Events Example</title>
        <style>
            .eventBlock{
                width:500px;
                margin-left:auto;
                margin-right:auto;
                background-color:#CCC;	
            }

            .displayEvent{
                text_align:left;
                font-size:18px;	
            }

            .displayDescription {
                margin-left:100px;
            }
            
            .displayMonthEvent{
                text_align:left;
                font-size:18px;	
                color: red;
            }
        </style>
    </head>

    <body>
        <h1>WDV341 Intro PHP</h1>
        <h2>Example Code - Display Events as formatted output blocks</h2>   
        <h3>??? Events are available today.</h3>

        <?php //Display each row as formatted output in the div below
        //This first block is for determining the name formating
        $currentMonth = false;
        $inTheFuture = false;
        $today = date('Y-m-d');
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $eventDate = date('Y-m-d', strtotime($row["date"]));
            if ($today < $eventDate) {
                $inTheFuture = true;
                if (date('Y-m', strtotime($row["date"])) === date('Y-m')) {
                    $currentMonth = true;
                } else {
                    $currentMonth = false;
                }
            } else {
                $inTheFuture = false;
                $currentMonth = false;
            }
            
            $eventFormat = '<span class="displayEvent"> Event: ' . $row["event_name"]; //default format
            if ($currentMonth) {
                $eventFormat = '<span class="displayMonthEvent"><i><b>Event: ' . $row["event_name"] . '</b></i>';
            } else if ($inTheFuture) {
                $eventFormat = '<span class="displayEvent"><i>Event: ' . $row["event_name"] . '</i>';
            }
            
            //Event format has been selected, now to output each block
            
            echo '
            <p>
                <div class="eventBlock">	
                    <div>
                        ' . $eventFormat . '</span>
                        <span>Presenter: ' . $row["event_presenter"]  . '</span>
                    </div>
                    <div>
                        <span class="displayDescription">Description: ' . $row["event_description"] . '</span>
                    </div>
                    <div>
                        <span class="displayTime">Time: ' . $row["event_time"] . '</span>
                    </div>
                    <div>
                        <span class="displayDate">Date: ' . $row["date"] . '</span>
                    </div>
                </div>
            </p> ';
        }
        ?>
        </div>	
    </body>
</html>