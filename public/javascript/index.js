function bindEventListeners() {
  const signinButton = document.querySelector(".signin-btn");
  const formBackground = document.querySelector(".form-background");
  const formContainer = document.querySelector(".form-container");

  signinButton.addEventListener("click", function () {
      if (formBackground.style.display === "none" || formBackground.style.display === "") {
          formBackground.style.display = "flex";
      } else {
          formBackground.style.display = "none";
      }
  });

  formContainer.addEventListener("click", function (event) {
      event.stopPropagation(); 
  });

  document.addEventListener("click", function (event) {
      if (event.target !== formContainer && event.target !== signinButton) {
          formBackground.style.display = "none";
      }
  });
}

function reBindEventListeners() {
    const signinButton = document.querySelector(".signin-btn");
    const formBackground = document.querySelector(".form-background");
    const formContainer = document.querySelector(".form-container");
    
    formContainer.addEventListener("click", function (event) {
        event.stopPropagation(); 
    });
  
    document.addEventListener("click", function (event) {
        if (event.target !== formContainer && event.target !== signinButton) {
            formBackground.style.display = "none";
        }
    });
}




function changeForm(value) {
    const form_background = document.querySelector('.form-background');
    const formContainer = document.querySelector(".form-container");

    switch (value) {
        case "user-verification":
            form_background.innerHTML = `
                <div class="login-container form-container">
                    <div class="form-title">
                        <p class="title">User Verification</p> 
                        <hr>
                        <p class="subtitle">Enter your username & Password</p>
                        <p class="note"></p>
                    </div>
                    
                    <div class="input-container">
                        <input type="text" name="bcash-username"  required>
                        <label>Username</label>
                    </div>
                    <div class="input-container">
                        <input type="password" name="bcash-password" required>
                        <label>Password</label>
                    </div>

                    <button class="btn-default curson-pointer" type="submit" name="bcash-pin-verify">Verify</button>
                    <hr>
                    <div class="note">
                        <p></p> 
                        <a href=""><u>Forgot Password?</u></a>
                    </div>
                </div>
            `;
            break;

        case "pin-verification":
            form_background.innerHTML = `
                <div class="pin-container form-container">
                    <div class="form-title">
                        <p class="title">PIN Verification</p> 
                        <hr>
                        <p class="subtitle">Enter your 6 digit PIN code.</p>
                    </div>
                    <input type="password" name="pin" minlength="6" pattern="[0-9]{6}" maxlength="6">
                    <button class="btn-default curson-pointer" type="submit" name="bcash-pin-verify">Verify</button>
                    <hr>
                    <div class="note">
                        <p></p> 
                    </div>
                </div>
            `;
            break;

        case "pin-creation":
            form_background.innerHTML = `
                <div class="create-pin-container form-container">
                    <div class="form-title">
                        <p class="title">PIN Creation</p> 
                        <hr>
                        <p class="subtitle">Create your 6 digit PIN code.</p>
                    </div>
                    <input type="password" name="pin1" minlength="6" pattern="[0-9]{6}" maxlength="6">
                    <label for="">Re-type PIN:</label>
                    <input type="password" name="pin2" minlength="6" pattern="[0-9]{6}" maxlength="6">
                    <button class="btn-default curson-pointer" type="submit" name="bcash-pin-create">Create</button>
                    <hr>
                    <div class="note">
                        <p></p> 
                    </div>
                </div>
            `;
            break;

        case "otp-verification":
            form_background.innerHTML = `
                <div class="otp-container form-container">
                    <div class="form-title">
                        <p class="title">One-Time-Password Verification</p> 
                        <hr>
                        <p class="subtitle">Enter 6 digit OTP sent to your email below:</p>
                        <p class="note">jameslayso@fasasd.com</p>
                    </div>
                    <input type="text" name="otp" minlength="6" pattern="[0-9]{6}" maxlength="6">
                    <button class="btn-default curson-pointer" type="submit" name="bcash-otp">Verify</button>
                    <hr>
                    <div class="note">
                        <p></p> 
                    </div>
                </div>
            `;
            break;

        default:
            form_background.innerHTML = `
                <div class="login-container form-container">
                    <div class="form-title">
                        <p class="title">User Verification</p> 
                        <hr>
                        <p class="subtitle">Enter your username & Password</p>
                        <p class="note"></p>
                    </div>
                    
                    <div class="input-container">
                        <input type="text" name="bcash-username"  required>
                        <label>Username</label>
                    </div>
                    <div class="input-container">
                        <input type="password" name="bcash-password" required>
                        <label>Password</label>
                    </div>

                    <button class="btn-default curson-pointer" type="submit" name="bcash-pin-verify">Verify</button>
                    <hr>
                    <div class="note">
                        <p></p> 
                        <a href=""><u>Forgot Password?</u></a>
                    </div>
                </div>
            `;
            break;
            
    }
   // bindEventListeners();
   reBindEventListeners();
}



document.addEventListener("DOMContentLoaded", function () {
    bindEventListeners();
    changeForm("user-verification");
  });