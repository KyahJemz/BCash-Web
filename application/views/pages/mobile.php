<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-signin-client_id" content="953479842774-oou2sv3r8ku0ug4kes6u9mfundf9ok84.apps.googleusercontent.com">

    <title>BCash Mobile</title>
    
    <link rel="stylesheet" href="<?php echo base_url('./public/css/mobile/styles.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('./public/css/mobile/mobile.css'); ?>">
</head>
<body>

    <div id="app"></div>
    
    <div id="g_id_onload"
        data-client_id="953479842774-oou2sv3r8ku0ug4kes6u9mfundf9ok84.apps.googleusercontent.com"
        data-context="signin"
        data-ux_mode="popup"
        data-callback="handleCredentialResponse"
        data-nonce=""
        data-auto_prompt="false">
    </div>

    <div class="g_id_signin"
        data-type="standard"
        data-shape="rectangular"
        data-theme="outline"
        data-text="signin_with"
        data-size="large"
        data-logo_alignment="center"
        data-width="400">
    </div>

    <script src="https://accounts.google.com/gsi/client" async defer></script>

    <script src="<?php echo base_url('./public/javascript/mobile/main.js'); ?>" type="module"></script>
    
</body>
</html>