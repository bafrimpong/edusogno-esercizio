<?php
include_once "helper/Helper.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once "view/head.php" ?>
    <title>Edit Event</title>
</head>
<body>
<!-- include the header section -->
<?php include_once "view/topbar.php" ?>

<!-- form start -->
<h3 id="form-title">Edit an event</h3>
<div id="form-container" >
    <!-- feedback container-->
    <?php
        if (!empty($_SESSION['CREATE_EVENT_FAILED_MSG'])){
            Helper::showErrorMessage($_SESSION['CREATE_EVENT_FAILED_MSG']);
        };
        unset($_SESSION['CREATE_EVENT_FAILED_MSG']);

        $event_controller = new EventsController();
        $event = [];

        if (isset($_REQUEST['key'])){
            $event = $event_controller->readRecordById($_REQUEST["key"]);

            unset($_REQUEST['key']);
        }
    ?>

    <form action="<?php echo Route::getUpdateEventPath() ?>" method="post" id="event-form">

        <input type="hidden" name="event_id" id="event_id" value="<?php echo($event[0]['id']) ?>">

        <label class="form-label" for="event_name">Enter event name</label>
        <input class="form-text-input" type="text" name="event_name" id="event_name" value="<?php echo($event[0]['event_name']) ?>" placeholder="Visit to Kintampo Falls">

        <label class="form-label" for="event_date">Enter event date</label>
        <input class="form-text-input" type="date" name="event_date" id="event_date" value="<?php echo(Helper::formatDate('Y-m-d', $event[0]['event_date'])) ?>">

        <label class="form-label" for="event_attendees">Select attendees</label>&nbsp;<small style="color: crimson;">(Hold down Ctrl + click to select multiple)</small>
        <select name="event_attendees[]" id="event_attendees" class="form-text-input" multiple title="Hold down Ctl + click to select many" size="2">
            <?php
                $user = new UsersController();
                $user_records = $user->readRecord();
                $attendees = explode(",", $event[0]["attendees"]);

                foreach ($user_records as $record) {
                    if(in_array($record['email'], $attendees)){
                        echo "<option value='".$record['email']."' selected>".$record['email']."</option>";
                    } else {
                        echo "<option value='".$record['email']."'>".$record['email']."</option>";
                    }
                }
            ?>
        </select>

        <label class="form-label" for="event_description">Enter description</label>
        <textarea id="event_description" name="event_description" rows="2" class="form-text-input" ><?php echo($event[0]['event_description']) ?>
        </textarea>

        <div>
            <button type="button" class="register-button general-button" onclick="validateCreateEvent('this')" style="width: 60%; display: inline-block" id="btn_update_event" name="btn_update_event">Add Event</button>
            <a type="button" href="<?php echo(Route::getEventsPath()) ?>" style="width: 35%; display: inline-block" class="register-button general-button" id="back-home" name="back-home">&leftarrow; Back</a>
        </div>


    </form>
</div>
<!-- form end -->

<!-- include the footer section -->
<?php include_once("view/footer.php") ?>

<?php include_once("view/jscript.php") ?>

</body>
</html>