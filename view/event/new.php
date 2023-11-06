<?php
include_once "helper/Helper.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once "view/head.php" ?>
    <title>New Event</title>
</head>
<body>
<!-- include the header section -->
<?php include_once "view/topbar.php" ?>

<!-- form start -->
<h3 id="form-title">Create an event</h3>
<div id="form-container" >
    <!-- feedback container-->
    <?php
    if (!empty($_SESSION['EDIT_EVENT_FAILED_MSG'])){
        Helper::showErrorMessage($_SESSION['EDIT_EVENT_FAILED_MSG']);
    };
    unset($_SESSION['EDIT_EVENT_FAILED_MSG']);
    ?>

    <form action="<?php echo Route::getCreateEventPath() ?>" method="post" id="event-form">

        <label class="form-label" for="event_name">Event name</label>
        <input class="form-text-input" type="text" name="event_name" id="event_name" placeholder="Visit to Kintampo Falls">

        <label class="form-label" for="event_date">Event date</label>
        <input class="form-text-input" type="date" name="event_date" id="event_date">

        <label class="form-label" for="event_attendees">Attendees</label>&nbsp;<small style="color: crimson;">(Hold down Ctrl + click to select multiple)</small>
        <select name="event_attendees[]" id="event_attendees" class="form-text-input" multiple title="Hold down Ctl + click to select many" size="2">
            <?php
                $user = new UsersController();
                $user_records = $user->readRecord();

                foreach ($user_records as $record) {
                    echo "<option value='".$record['email']."'>".$record['email']."</option>";
                }
            ?>
        </select>

        <label class="form-label" for="event_description">Description</label>
        <textarea id="event_description" name="event_description" rows="2" class="form-text-input" >A trip to Kintampo falls and Fiema monkey sanctuary
        </textarea>

        <button type="button" class="register-button general-button" onclick="validateCreateEvent('this')" id="btn_create_event" name="btn_create_event">Add Event</button>

    </form>
    <div style="text-align: center; padding-top: 10px;">
        <a href="<?php echo(Route::getEventsPath()) ?>">Cancel</a>
    </div>
</div>
<!-- form end -->

<!-- include the footer section -->
<?php include_once("view/footer.php") ?>

<?php include_once("view/jscript.php") ?>

</body>
</html>