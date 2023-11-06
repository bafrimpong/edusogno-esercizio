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

        <h1 id="form-title" class="login-form-title" style="color: green; ">
            <?php
               echo isset($_SESSION["ACTION_SUCCESS"]) ? "Action Success" : "Action Failed";
            ?>
        </h1>
        <div id="form-container" style="height: auto">
            <?php
                if (isset($_SESSION["ACTION_SUCCESS"])){
                    echo('<p style="font-size: 20px; text-align: center; color: green">'.
                        $_SESSION["ACTION_SUCCESS"].'<br><br>
                    </p>');
                    unset($_SESSION["ACTION_SUCCESS"]);
                } else {
                    echo('<p style="font-size: 20px; text-align: center; color: crimson">'.
                        $_SESSION["ACTION_FAILED"].'<br><br>
                    </p>');
                    unset($_SESSION["ACTION_FAILED"]);
                }
            ?>
            <section id="have-account">
                <?php
                    echo('&nbsp;<a href="'.Route::getLoginPath().'" id="login-link" style="font-size: 20px !important; text-decoration: none !important;">Login Now</a>');
                ?>
            </section>
        </div>
    <?php require_once("view/footer.php") ?>

    <?php require_once("view/jscript.php"); ?>
</body>
</html>
