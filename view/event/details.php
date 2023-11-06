<?php
    include_once "helper/Helper.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once "view/head.php" ?>
    <title>Event Details</title>
</head>
<body>
<!-- include the header section -->
<?php include_once "view/topbar.php" ?>

<!-- form start -->
<h3 id="form-title">Event Details</h3>
<div id="form-container">
    <?php

        $event_controller = new EventsController();
        $event = [];

        if (isset($_REQUEST['key'])){
            $event = $event_controller->readRecordById($_REQUEST["key"]);
        }

        if (!empty($event)){
            $attendees = explode(",", $event[0]["attendees"]);

            echo("
                <span class='event-details'>Name</span><h2>".$event[0]['event_name']."</h2><br>
                <span class='event-details'>Date</span><div style='padding-left: 25px'><p>".Helper::formatDate('Y-m-d',$event[0]['event_date'])."</p></div><br>
                <span class='event-details'>Attendees</span><div style='padding-left: 30px'><ol>");

                foreach ($attendees as $attendee) {
                    echo ("<li>".$attendee."</li>");
                }
            echo(" 
                </ol></div><br>
                <span class='event-details'>Description</span><br><div style='padding-left: 25px'><p>".$event[0]['event_description']."</p></div>
            ");
        }
    ?>

    <div style="text-align: right;">
        <a class="back-home" href="<?php echo Route::getEventsPath() ?>">&leftarrow; Back</a>
    </div>
</div>
<!-- form end -->

<!-- include the footer section -->
<?php include_once("view/footer.php") ?>

<?php include_once("view/jscript.php") ?>

</body>
</html>