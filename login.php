<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Login Now</title>
</head>
<body>
    <div class="form">
        <div class="title">Login Now</div>
        <div id="msg"></div>
        <form id="loginForm" method="post">
            <div class="input-container">
                <input id="email" name="email" class="input" type="email" placeholder=" " required/>
                <div class="cut cut-short"></div>
                <label for="email" class="placeholder">Email</label>
            </div>
            <div class="input-container">
                <input id="password" name="password" class="input" type="password" placeholder=" " required/>
                <div class="cut"></div>
                <label for="password" class="placeholder">Password</label>
                
            </div>
            <p class="account-switch"><a href="passReset.php">Forgot your password ?</a></p>
            <button type="submit" name="submit" class="submit">Login</button>
        </form>
        <p class="account-switch">Don't have an account? <a href="register.php">Sign up</a></p>
    </div>
    <script src="assets/js/login.js"></script>
    <script>
         $(document).ready(function() {
     $('[title="Hosted on free web hosting 000webhost.com. Host your own website for FREE."]').hide();
 });
    </script>
</body>
</html>
