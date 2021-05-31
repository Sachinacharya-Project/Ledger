<?php
    session_start();
    if(isset($_SESSION['username'])){
        header("location: /models/dashboard.php");
    }
    $output = '';
    if(isset($_SESSION['error'])){
        $message = $_SESSION['error'];
        if($message == null){
            $output = '';
        }else{
            $output = "
            <div class='messages error'>
                $message
            </div>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://kit.fontawesome.com/612f542d54.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Allan&family=Anton&family=Bebas+Neue&family=Courgette&family=Imbue&family=Kaushan+Script&family=Lobster&family=Nova+Square&family=Oswald:wght@300;400&family=PT+Sans+Narrow&family=Pathway+Gothic+One&family=Poppins&family=Potta+One&family=Righteous&family=Roboto:wght@300;400&family=Squada+One&family=Teko:wght@300;400&family=Trade+Winds&family=Yanone+Kaffeesatz:wght@400;500&family=Yellowtail&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/account.css">
    <title>Account | Login</title>
</head>
<body>
    <button value="" class="nullvalue"></button>
    <div class="account login">
        <h1>Login</h1>
        <?php
            echo $output;
        ?>
        <div class="separator"></div>
        <div class="cred div-username">
            <input type="text" name="username" id="username" class="username" placeholder="Username" autocomplete="off">
        </div>
        <div class="cred div-password">
            <input type="password" name="password" placeholder="Password" id="lpassword" class="password" autocomplete="off">
            <label for="password">
                <i class="fas fa-eye" onclick="togglePassword('lpassword', this)"></i>
            </label>
        </div>
        <div class="extraSection">
            <a href="/?forgot">Forgot Password?</a>
            <a href="/?signup">Don't Have account?</a>
        </div>
        <div class="send-btn">
            <input type="submit" value="Login" class="send" id="send" onclick="accountHandle('login')">
        </div>
    </div>
    <div class="account signup firststep">
        <h1>Signup</h1>
        <p>First Step: Basic Details</p>
        <?php
            echo $output;
        ?>
        <div class="separator"></div>
        <div class="cred div-email">
            <input type="email" name="email" class="email" placeholder="Email Address" autocomplete="off">
        </div>
        <div class="cred div-name">
            <input type="text" name="name" class="name" placeholder="Fullname" autocomplete="off">
        </div>
        <div class="cred div-username">
            <input type="text" name="username" class="username" placeholder="Username" autocomplete="off">
        </div>
        <div class="cred div-password">
            <input type="password" name="password" id='spassword' placeholder="Password" class="password" autocomplete="off">
            <label for="password">
                <i class="fas fa-eye" onclick="togglePassword('spassword', this)"></i>
            </label>
        </div>
        <div class="extraSection">
            <a href="/?forgot">Forgot password?</a>
            <a href="/?login">Already have account?</a>
        </div>
        <div class="send-btn">
            <button onclick="nextStep()">Next</button>
        </div>
    </div>
    <div class="account secondstep">
        <h1>Signup</h1>
        <p>Last Step: Extra Information</p>
        <div class="cred div-shop">
            <input type="text" name="shopname" class="shopname" placeholder="Shopname" autocomplete="off">
        </div>
        <div class="cred div-regd">
            <input type="text" name="regd" class="regd" placeholder="Registration Number" autocomplete="off">
        </div>
        <div class="cred div-address">
            <input type="text" name="address" class="address" placeholder="Address" autocomplete="off">
        </div>
        <div class="cred div-phonr">
            <input type="text" name="phone" class="phone" placeholder="Phone Number" autocomplete="off">
        </div>
        <div class="send-btn">
            <button onclick="accountHandle('signup')">SignUp</button>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="./js/account.js"></script>
</body>
</html>