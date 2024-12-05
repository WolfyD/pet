<?php
    use PET\settings\styles;
    require_once("init.php");
    require_once("resources/settings/styles.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PET - Create user</title>
    <link rel="stylesheet" href="resources/css/main.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <script src="js/main.js"></script>
    <style>
        :root{
            --paw-print-color: rgba(107, 142, 173, 0.1); /* Very light steel blue */
            <?php print(styles::getTheme($theme)) ?>
        }
    </style>
</head>
<body>
    <div class="login-container">
        <header class="login-header">
            <h1>Welcome to PET</h1>
            <p style="line-height: 10px; margin: 5px 0 0 0;" class="tagline">Create new user</p>
        </header>
        <main class="login-main">
            <div class="message-container" id="registration_message" style="display: none;">
                <p id="reg_message_text" class="message-text">[Message will appear here]</p>
            </div>
            <form class="login-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="password1">Password</label>
                    <input type="password" id="password1" name="password1" placeholder="Enter your password" required>
                </div>
                <div class="form-group">
                    <label for="password2">Repeat Password</label>
                    <input type="password" class="transparent_input" id="password2" name="password2" placeholder="Repeat your password" required>
                </div>
                <button type="submit" class="btn-submit" onclick="checkRegister()">Register</button>
                <span id="form_functions">
                    <a href="login.php" class="f_function">Already have a user? Log in!</a> | 
                    <a href="fmp.php" class="f_function">Forgot my password</a>
                </span>
            </form>
        </main>
    </div>
</body>
</html>
