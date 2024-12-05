<?php
    use PET\settings\styles;
    require_once("init.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PET - Login</title>
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
                    <label for="password">Password</label>
                    <input type="password" class="transparent_input" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn-submit" onclick="checkLogin();">Login</button>
                <span id="form_functions">
                    <a href="register.php" class="f_function">New user? Register now!</a> | 
                    <a href="fmp2.php" class="f_function">Forgot my password</a>
                </span>
            </form>
        </main>
    </div>
</body>
</html>
