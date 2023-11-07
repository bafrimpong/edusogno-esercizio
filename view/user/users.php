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
<h3 id="form-title">List of Users</h3>
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
            <th style='width: 20%'>First Name</th>
            <th style='width: 20%'>Last Name</th>
            <th style='width: 30%'>E-mail</th>
            <th style="width: 18%">Action</th>
        </tr>
        <?php
        $user_controller = new UsersController();
        $all_users = $user_controller->readRecord();

        $row_num = 0;
        foreach ($all_users as $user) {

            echo("<tr>
                        <td>".($row_num += 1).".</td>
                        <td>". $user['first_name'] ."</td>
                        <td>". $user['last_name'] ."</td>
                        <td>". $user['email'] ."</td>
                        <td>
                            <a href='".Route::getProfilePath()."?key=".$user['id']."' class='edit-record'>View Profile</a> |
                            <a href='".Route::getDeleteUserPath()."?key=".$user['id']."' class='delete-record'>Delete</a>
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