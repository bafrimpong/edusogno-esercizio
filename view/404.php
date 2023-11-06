<?php
include_once("helper/Helper.php");
?>
<!DOCTYPE html>
<html lang="en">
    <?php require_once("view/head.php"); ?>
    <body>
        <!-- include the header section -->
        <?php
            require_once("view/topbar.php");
        ?>

        <h1 id="form-title" class="login-form-title" style="color: crimson;">404</h1>
        <div id="form-container" style="height: auto">
            <p style="font-size: 25px; text-align: center; color: crimson">
                Requested page or resource not found
            </p>
            <section id="have-account" >
                <?php
                    echo('&nbsp;<a href="'.Route::getLoginPath().'" id="login-link" style="font-size: 22px; text-decoration: none">Go Back</a>');
                ?>
            </section>
        </div>
    <?php require_once("view/footer.php") ?>

    <?php require_once("view/jscript.php"); ?>
</body>
</html>
