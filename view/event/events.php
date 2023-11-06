<?php
    include_once "helper/Helper.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once "view/head.php" ?>
    <title>Events</title>
</head>
<body>
<!-- include the header section -->
<?php include_once "view/topbar.php" ?>

<!-- form start -->
<h3 id="form-title">List of Events</h3>
<div id="new-event-link">
    <a href="<?php echo(Route::getNewEventPath()) ?>">Create New</a>
</div>
<div id="form-container" style="width: 70% !important;">
    <?php
        if (isset($_SESSION["ACTION_SUCCESS"])){
            Helper::showSuccessMessage($_SESSION["ACTION_SUCCESS"]);
            unset($_SESSION["ACTION_SUCCESS"]);
        } elseif (isset($_SESSION["ACTION_FAILED"])) {
            Helper::showErrorMessage($_SESSION["ACTION_FAILED"]);
            unset($_SESSION["ACTION_FAILED"]);
        }
    ?>
    <table>
        <tr>
            <th style='width: 5%'>#</th>
            <th style='width: 32%'>Event Name</th>
            <th style='width: 13%'>Date</th>
            <th style="width: 32%">Attendees</th>
            <th style="width: 18%">Action</th>
        </tr>
        <?php
            $event = new EventsController();
            $events = $event->readRecord();

            $row_num = 0;
            foreach ($events as $_event) {
                $_attendees = explode(",", $_event["attendees"]);

                echo("<tr>
                        <td>".($row_num += 1).".</td>
                        <td>".$_event['event_name']."</td>
                        <td>".Helper::formatDate('Y-m-d', $_event['event_date'])."</td>
                        <td width='300px'><ul type='none'>");
                        $new_attendees = explode(',', $_event['attendees']);

                        foreach ($new_attendees as $_attendee) {
                            echo("
                                  <li>".$_attendee."</li>
                            ");
                        }
                echo("</ul></td>
                        <td>
                            <a href='".Route::getEventDetailsPath()."?key=".$_event['id']."' class='view-record'>View</a> &nbsp;|
                            <a href='".Route::getEditEventPath()."?key=".$_event['id']."' class='edit-record'>Edit</a> &nbsp;|
                            <a href='".Route::getDeleteEventPath()."?key=".$_event['id']."' class='delete-record'>Delete</a>
                        </td>
                      </tr>"
                );
            }
        ?>
    </table>
</div>
<!-- form end -->

<!-- include the footer section -->
<?php include_once("view/footer.php") ?>

<?php include_once("view/jscript.php") ?>

</body>
</html>