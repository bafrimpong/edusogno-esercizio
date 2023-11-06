<?php

class Helper
{
    public static string $EMAIL_TYPE_RESET_PASSWORD = 'reset password';
    public static string $EMAIL_TYPE_CHANGE_PASSWORD = 'change password';
    public static string $EMAIL_TYPE_REGISTER = 'register';
    public static string $EMAIL_TYPE_CREATE_EVENT = 'create event';
    public static string $EMAIL_TYPE_UPDATE_EVENT = 'update event';

    /**
     * Formats a date object in the form of yyyy-m-d
     * @param string $date_format the format or style in a string
     * @param $date_value
     * @return string
     */
    public static function formatDate(string $date_format, $date_value) : string {
        return date($date_format, strtotime(str_replace('-', '/', $date_value)));
    }

    /**
     * Checks for the type of e-mail to be sent and echo or print the desired message content
     * @param $_email_type `the type of message to be sent`
     * @param $params
     * @return string
     */
    private static function checkEmailTypeAndSetMessage($_email_type, $params): string
    {
        switch ($_email_type) {
            case self::$EMAIL_TYPE_REGISTER:
                return "
                    <p>
                        We have sent you this email to let you know that you have successfully created an account on edusogno
                    </p>
                    <p>
                        You can login to your account by follow the link below:
                    </p>
        
                    <div id='link-container'><a href='http://localhost". Route::getLoginPath() ."'>Login Now</a></div>
                ";
                break;
            case self::$EMAIL_TYPE_CREATE_EVENT:
                return "
                    <p>
                        We have sent you this email you have been added or joined an event on the edusogno platform
                    </p>
                    <p>
                        You may login to your account to manage or view your events by following the link below:
                    </p>
        
                    <div id='link-container'><a href='http://localhost". Route::getLoginPath() ."'>Login Now</a></div>
                ";
                break;
            case self::$EMAIL_TYPE_UPDATE_EVENT:
                return "
                    <p>
                        We have sent you this email to notify you about the modification made to the event you were added earlier on the edusogno platform.
                    </p>
                    <p>
                        You may login to your account to manage or view your events by following the link below:
                    </p>
        
                    <div id='link-container'><a href='http://localhost". Route::getLoginPath() ."'>Login Now</a></div>
                ";
                break;
            case self::$EMAIL_TYPE_CHANGE_PASSWORD:
                return "
                    <p>
                        We have sent you this email to inform you that you have successfully changed your password on edusogno
                    </p>
                    <p>
                        If you do not have an idea about this password change, please contact support as soon as possible
                    </p>";
                break;
            default:
                return "
                    <p>
                        We have sent you this email in response to your request to reset your password on edusogno
                    </p>
                    <p>
                        To reset your password, please follow the link below:
                    </p>
        
                    <div id='link-container'><a href='http://localhost". Route::getPasswordEditPath() ."?".$params."'>Reset Password</a></div>
        
                    <p>
                        <small>Please ignore this email if you did not request a password change</small>
                    </p>
                ";
                break;
        }
    }

    /**
     * @param $first_name
     * @param $email_type
     * @param $message_title
     * @param $params
     * @return string
     */
    public static function getEmailTemplateWithMessage($first_name, $email_type, $message_title, $params): string
    {
        return "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Edusogno</title>
            <link rel='preconnect' href='https://fonts.googleapis.com'>
            <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
            <link href='https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,600;9..40,700&display=swap' rel='stylesheet'>
            <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css' integrity='sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==' crossorigin='anonymous' referrerpolicy='no-referrer' />
        
            <style>
                .email-container {
                    font-family: 'DM Sans', sans-serif;
                    width: 60%;
                    background-color: #D9E5F3;
                    margin: auto;
                }
        
                #logo {
                    padding: 40px;
                    height: 20px;
                    text-align: center;
                    background-color: white;
                    padding-bottom: 50px;
                }
        
                .email-title {
                    background-color: #D9E5F3;
                    text-align: center;
                    padding-top: 20px;
                    color: #134077;
                }
        
                .email-body {
                    background-color: #FFFFFF;
                    padding: 40px;
                }
        
                #link-container > a {
                    text-decoration: none;
                    padding: 10px 20px;
                    text-align: center;
                    border-radius: 20px;
                    display: inline-block;
                    background-color: #0057FF;
                    color: #FFFFFF !important;
                    font-weight: 700;
                }
        
                #link-container > a:hover {
                    background-color: #134077;
                }
        
                p > small {
                    font-style: italic;
                }
        
                .email-footer {
                    max-height: 100px;
                    padding: 20px 40px;
                }
            </style>
        </head>
        <body>
            <div class='email-container'>
                <div id='logo'>
                    <img src='https://drive.google.com/uc?export=view&id=1C7aLkOQvi4uqcnEmwMpo3LwP26P3Y5PM' alt='logo'>
                </div>
                <div class='email-title'>
                    <span><i class='fas fa-lock-open fa-3x'></i></span>
                    <h2>".$message_title."</h2>
                </div>
                <div class='email-body'>
                    <p>Hello&nbsp;".$first_name.",</p>".
                    print_r(self::checkEmailTypeAndSetMessage($email_type,$params), true)
                ."</div>
                <div class='email-footer'>
                    <span style='color: #134077; font-weight: bold;'>Contact Support</span>
                    <p>
                        Edusogno, address line here<br>
                        +233244692697 / +233503691330<br>
                        info@edusogno.com
                    </p>
                </div>
            </div>
        </body>
        </html>";
    }

    /**
     * Sends an email to a designated user in the app
     * @param string $_email_to `recipient email address`
     * @param string $_subject  `email subject`
     * @param string $_message  `the message body of the email`
     * @return bool
     */
    public static function sendEmail(string $_email_to, string $_subject, string $_message): bool
    {
        $headers =  "From: Edu Sogno<devops@cyberwiseinternational.org>\r\n";
        $headers .= "Reply-To: devops@cyberwiseinternational.org\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        try {
            return mail($_email_to, $_subject, $_message, $headers);
        } catch (Exception $exception) {
            return false;
        }
    }

    public static function showErrorMessage($_error_msg) {
        echo("<section class='feedback feedback-error'>
                <span id='btn-close-feedback' onclick='toggleErrorView()'><img class='feedback-close' src='../assets/images/close-button.png' alt='close button'></span>" .
            $_error_msg . "</section>"
        );
    }

    public static function showSuccessMessage($_error_msg) {
        echo("<section class='feedback feedback-success'>
                <span id='btn-close-feedback' onclick='toggleErrorView()'><img class='feedback-close' src='../assets/images/close-button.png' alt='close button'></span>" .
            $_error_msg . "</section>"
        );
    }

    public static function redirectToSuccessFailurePath(){
        header("Location: ".Route::getActionSuccessPath());

        exit();
    }
}