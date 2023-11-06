<?php
//    var_dump($_SESSION["LOGGED_IN_USER"]);
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

        <!-- include the login form -->
        <?php include_once "view/user/user_dashboard.php" ?>

        <!-- include the footer section -->
        <?php include_once("view/footer.php") ?>

        <?php include_once "view/jscript.php" ?>
    </body>
</html>