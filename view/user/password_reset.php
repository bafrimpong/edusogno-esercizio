<?php
    include_once("helper/Helper.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once "view/head.php" ?>
        <title>New Event</title>
    </head>
    <body>
        <!-- include the header section -->
        <?php
            require_once("view/topbar.php");
        ?>

        <!-- form start -->
        <h3 id="form-title" class="login-form-title">Resetta la password</h3>
        <div id="form-container" style="height: auto">

            <!-- error message container-->
            <?php
                if (!empty($_SESSION['FAILED_PASSWORD_MSG'])) {
                    Helper::showErrorMessage($_SESSION["FAILED_PASSWORD_MSG"]);
                };
                unset($_SESSION['FAILED_PASSWORD_MSG']);
            ?>

            <form action="<?php echo Route::getSendPasswordResetInstructionsPath() ?>" method="post" id="password-reset-form">

                <label class="form-label" for="email">Inserisci l’e-mail</label>
                <input class="form-text-input" type="email" name="email" id="email" placeholder="name@example.com" required>

                <button type="submit" class="register-button general-button" id="btn_login">Resetta la password</button>

                <section id="have-account">
                    <label>Hai già un account?</label>
                    <?php
                        echo('&nbsp;<a href="'.Route::getLoginPath().'" id="login-link">Accedi</a>');
                    ?>
                </section>

            </form>
        </div>
        <!-- form end -->

        <?php require_once("view/footer.php") ?>

        <?php require_once("view/jscript.php"); ?>
    </body>
</html>
