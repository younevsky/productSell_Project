<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Sign UP Now</title>
</head>
<body>
    <form class="form" id="registerForm" method="post">
    <div class="title">SIGN UP</div>
    <div id="msg"></div>

    <div class="select-container">
        <div class="input-container ic2">
            <select id="country" name="country" class="input" required>
                <option value="" selected disabled hidden>Choose country</option>
                <option value="Morocco">Morocco</option>
                <option value="USA">USA</option>
                <option value="Canada">Canada</option>
                <option value="France">France</option>
                <option value="Germany">Germany</option>
                <option value="Italy">Italy</option>
                <option value="Japan">Japan</option>
                <option value="Australia">Australia</option>
                <option value="Brazil">Brazil</option>
                <option value="China">China</option>
            </select>
            <div class="cut cut-short"></div>
            <label for="country" class="placeholder">Country</label>
        </div>
        <div class="input-container ic2">
            <select id="city" name="city" class="input" required>
                <option value="" selected disabled hidden>Choose city</option>
            </select>
            <div class="cut cut-short"></div>
            <label for="city" class="placeholder">City</label>
        </div>
    </div>
        <div class="input-container">
            <input id="name" name="name" class="input" type="text" placeholder=" " required/>
            <div class="cut cut-short"></div>
            <label for="name" class="placeholder">Name</label>
        </div>
        <div class="input-container">
            <input id="address" name="address" class="input" type="text" placeholder=" " required/>
            <div class="cut"></div>
            <label for="address" class="placeholder">Address</label>
        </div>
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
        <button type="submit" name="submit" class="submit">Sign up</button>
        <p class="account-switch">Already have an account? <a href="login.php">Log in</a></p>
    </form>
    <script src="assets/js/register.js"></script>
    <script>
         $(document).ready(function() {
     $('[title="Hosted on free web hosting 000webhost.com. Host your own website for FREE."]').hide();
 });
    </script>
</body>
</html>
