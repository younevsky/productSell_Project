<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Reset Your Password</title>
</head>
<body>
    <div class="form">
        <div class="title">Forgot Password</div>
        <div class="subtitle">Enter your E-mail address</div>
        <div id="msg"></div>
        <form id="resetForm" method="post">
            <div class="input-container ">
                <input id="email" name="email" class="input" type="email" placeholder=" " required/>
                <div class="cut cut-short"></div>
                <label for="email" class="placeholder">Email</label>
            </div>
            <div class="input-container " id="otpContainer" style="display: none;">
                <input id="otp" name="otp" class="input" type="number" placeholder=" " />
                <div class="cut cut-short"></div>
                <label for="otp" class="placeholder">OTP</label>
            </div>
            <div class="input-container" id="passwordContainer" style="display: none;">
                <input id="newPassword" name="newPassword" class="input" type="password" placeholder=" " />
                <div class="cut cut-short"></div>
                <label for="newPassword" class="placeholder">New Password</label>
            </div>

            <button type="submit" name="submit" class="submit" id="submit">Reset</button>
            <p class="account-switch">Don't have an account? <a href="register.php">Sign up</a></p>
            
            <p class="account-switch">Already have an account? <a href="login.php">Log in</a></p>
        </form>
    </div>
    <script src="assets/js/reset.js"></script>
    <script>
         $(document).ready(function() {
     $('[title="Hosted on free web hosting 000webhost.com. Host your own website for FREE."]').hide();
 });
    </script>
</body>
</html>
