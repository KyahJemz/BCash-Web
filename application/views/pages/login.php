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
            <br>
            <p class="title">BCash</p>
            <br>
            <p class="quote">An E-wallet application for SSC-RdC</p>
            <br>
            <p class="intro">BCash is an e-wallet app for SSC-RdC. It enables you to pay for school needs and monitor your finances with ease. BCash is your smart and convenient payment portal.</p>
            <br>
            <div class="button-contianer">
                <button class="curson-pointer signin-btn">Sign-In</button>
            </div>
        </div>
        <div class="right-box">
            <img src="<?php echo base_url('./public/images/bcash-logo-bw.gif'); ?>" alt="">
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