    <div class="design-background"></div>

    <div class="content-container">
        <div class="header-box">
            <div class="left-header">
                <div class="sscr-image">
                    <img src="<?php echo base_url('assets/images/sscr-logo.png'); ?>"  alt="sscr-logo">
                </div>
                <div class="sscr-text">
                    <div class="text1">San Sebastian College - Recoletos</div>
                    <div class="line"></div>
                    <div class="text2">Caritas et Scientia</div>
                </div>
            </div>a
            <div class="right-header">
                v1.2.3
            </div>
            
        </div>
        <div class="left-box">
            <p class="welcome">WELCOME TO</p>
            <img class="logo" src="<?php echo base_url('assets/images/bcash-logo.png'); ?>" alt="">
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
            <div>
                
                <div class="form-title">
                   <p>Login Form</p> 
                </div>
                

                <?php echo validation_errors(); ?>
                <?php echo form_open('validateLogin'); ?>

                <div class="input-container">
                    <input type="text" name="bcash-username" value="<?php echo set_value('bcash-username'); ?>" required>
                    <label>Username</label>
                    <?php echo form_error('bcash-username'); ?>
                </div>
                <div class="input-container">
                    <input type="password" name="bcash-password" required>
                    <label>Password</label>
                    <?php echo form_error('bcash-password'); ?>
                </div>
                <div class="button-container">
                    <button class="btn-default curson-pointer" type="submit" name="bcash-login">Sign-In</button>
                </div>
                <?php echo form_close(); ?>


                <div class="note">
                    <a href=""><u>Forgot Password?</u></a>
                </div>
            </div>
        </div>
    </div>

    <div id="Alert-Box-Container" class="Alert-container">
        <table class="Alert-Box-Table">
        
        </table>
    </div>