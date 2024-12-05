<?php

    namespace PET;

    class ErrorHandler
    {
        public static $error_template = "<html>
        <head>
            <link rel='stylesheet' href='resources/css/error.css'>
        </head>
        <body>
            <header>
                [title]
            </header>
            <div id='errorContainer'>
                <div id='errorBorder'></div>
                <div id='errorMessage'>
                    [message]
                </div>
            </div>
        </body>
        </html>";

        public static function displayErrorMessage($error_string, $error_title='Error!'):void
        {
            ob_start();
            global $error_template;
            $tmp = self::$error_template;
            $tmp = str_replace("[message]", $error_string, $tmp);
            $tmp = str_replace("[title]", $error_title, $tmp);
            print($tmp);
            ob_flush();
        }
    }