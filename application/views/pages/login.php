<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BCash - Login</title>
    <link rel="stylesheet" href="<?php echo base_url('./public/css/login.css'); ?>">
</head>
<body> 
    <div class="design-background"></div>

    <div class="content-container">
        <div class="header-box">
            <div class="left-header">
                <div class="sscr-image">
                    <img src="<?php echo base_url('./public/images/sscr-logo.png'); ?>"  alt="sscr-logo">
                </div>
                <div class="sscr-text">
                    <div class="text1">San Sebastian College - Recoletos</div>
                    <div class="line"></div>
                    <div class="text2">Caritas et Scientia</div>
                </div>
            </div>
            <div class="right-header">
                v1.2.3
            </div>
            
        </div>
        <div class="left-box">
            <p class="welcome">WELCOME TO</p>
            <img class="logo" src="<?php echo base_url('./public/images/bcash-logo.png'); ?>" alt="">
            <p class="title">BCASH</p>
            <p class="quote">An E-wallet application for SSC-RdC</p>
            <br>
            <p class="intro">BCASH is a payment portal designed to offer food and supplies to all students in the school.</p>
            <br>
            <div class="button-contianer">
                <button class="curson-pointer moreinfo-btn">More Info</button>
                <button class="curson-pointer signin-btn">Sign-In</button>
            </div>
        </div>
        <div class="right-box">
            <img src="" alt="">
        </div>
    </div>

    <div class="form-background" style="display: none;">
        <div class="form-container">
           
        </div>
    </div>

    <div id="redirect" style="display: none;">

    </div>

    <div id="Alert-Box-Container" class="Alert-container">
        <table class="Alert-Box-Table">
        
        </table>
    </div>
    <script src="<?php echo base_url('./public/javascript/login.js'); ?>"></script>
</body>
</html>