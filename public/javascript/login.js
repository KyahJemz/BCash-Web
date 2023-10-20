const baseUrl = 'http://localhost/index.php';
var Intent = "";
var ResponseMessage = "";

//    '/Api/Login/AuthenticateLogin'

// AJAX
function sendRequest(data,url) {
    console.log('Request Data:', data);
    return new Promise((resolve, reject) => {
        fetch(baseUrl+url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': AuthToken,
                'AccountAddress': AccountAddress,
                'Intent': Intent
            },
            body: JSON.stringify(data),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText);
            }
            return response.json();
        })
        .then(data => resolve(data))
        .catch(error => reject(error));
    });
}



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
            if (AuthToken === "" || AccountAddress === "") {
                console.log("CLEAR");
            } else {
                console.log("LOGOUT");
                logout();
                Intent = "Login";
                changeForm(Intent);
                AccountAddress = "";
                AuthToken = "";
            }
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
            Intent = "Login";
            changeForm(Intent);
        }
    });

    document.querySelector('.validate').addEventListener("click", function () {
        validate ();
    });
}




function changeForm(value) {
    const form_background = document.querySelector('.form-background');
    const formContainer = document.querySelector(".form-container");

    switch (value) {
        case "Login":
            form_background.innerHTML = `
                <div class="login-container form-container">
                    <div class="form-title">
                        <p class="title">User Verification</p> 
                        <hr>
                        <p class="subtitle">Enter your username & Password</p>
                        <p class="note"></p>
                    </div>
                    
                    <div class="input-container">
                        <input class="bcash-username" type="text" name="bcash-username"  required>
                        <label>Username</label>
                    </div>
                    <div class="input-container">
                        <input class="bcash-password" type="password" name="bcash-password" required>
                        <label>Password</label>
                    </div>

                    <button class="validate btn-default cursor-pointer" type="submit" name="bcash-pin-verify">Verify</button>
                    <hr>
                    <div class="note">
                        <p class="ResponseMessage"></p> 
                        <a href=""><u>Forgot Password?</u></a>
                    </div>
                </div>
            `;
            break;

        case "PINValidation":
            form_background.innerHTML = `
                <div class="pin-container form-container">
                    <div class="form-title">
                        <p class="title">PIN Verification</p> 
                        <hr>
                        <p class="subtitle">Enter your 6 digit PIN code.</p>
                    </div>
                    <input class="bcash-pin" type="password" name="pin" minlength="6" pattern="[0-9]{6}" maxlength="6">
                    <button class="validate btn-default cursor-pointer" type="submit" name="bcash-pin-verify">Verify</button>
                    <hr>
                    <div class="note">
                        <p class="ResponseMessage"></p> 
                    </div>
                </div>
            `;
            break;

        case "PINCreation":
            form_background.innerHTML = `
                <div class="create-pin-container form-container">
                    <div class="form-title">
                        <p class="title">PIN Creation</p> 
                        <hr>
                        <p class="subtitle">Create your 6 digit PIN code.</p>
                    </div>
                    <input class="bcash-pin1" type="password" name="pin1" minlength="6" pattern="[0-9]{6}" maxlength="6">
                    <label for="">Re-type PIN:</label>
                    <input class="bcash-pin2" type="password" name="pin2" minlength="6" pattern="[0-9]{6}" maxlength="6">
                    <button class="validate btn-default cursor-pointer" type="submit" name="bcash-pin-create">Create</button>
                    <hr>
                    <div class="note">
                        <p class="ResponseMessage"></p>   
                    </div>
                </div>
            `;
            break;

        case "OTPValidation":
            form_background.innerHTML = `
                <div class="otp-container form-container">
                    <div class="form-title">
                        <p class="title">One-Time-Password Verification</p> 
                        <hr>
                        <p class="subtitle">Enter 6 digit OTP sent to your email below:</p>
                        <p class="note">jameslayso@fasasd.com</p>
                    </div>
                    <input class="bcash-otp" type="text" name="otp" minlength="6" pattern="[0-9]{6}" maxlength="6">
                    <button class="validate btn-default cursor-pointer" type="submit" name="bcash-otp">Verify</button>
                    <hr>
                    <div class="note">
                        <p class="ResponseMessage"></p> 
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
                        <input class="bcash-username" type="text" name="bcash-username"  required>
                        <label>Username</label>
                    </div>
                    <div class="input-container">
                        <input class="bcash-password" type="password" name="bcash-password" required>
                        <label>Password</label>
                    </div>

                    <button class="validate btn-default cursor-pointer" type="submit" name="bcash-pin-verify">Verify</button>
                    <hr>
                    <div class="note">
                        <p class="ResponseMessage"></p> 
                        <a href=""><u>Forgot Password?</u></a>
                    </div>
                </div>
            `;
            break;

    }
    reBindEventListeners();
}

    
function validate (){
    var data = {};
    let url = "/Api/Auth/Process";
    if (Intent === "Login" || Intent === "" || Intent === null || Intent === "WebLogin") {
        data = { 
            Username: document.querySelector('.bcash-username').value,
            Password: document.querySelector('.bcash-password').value,
            IpAddress: IpAddress,
            Device: Device,
            Location: Location
        }; 
        Intent = "WebLogin";
    } else if (Intent === "OTPValidation") {
        data = { 
            OTP: document.querySelector('.bcash-otp').value,
            IpAddress: IpAddress,
            Device: Device,
            Location: Location
        }; 
    } else if (Intent === "PINValidation") {
        data = { 
            PIN: document.querySelector('.bcash-pin').value,
            IpAddress: IpAddress,
            Device: Device,
            Location: Location
        }; 
    }else if (Intent === "PINCreation") {
        data = { 
            NewPIN:document.querySelector('.bcash-pin2').value,
            IpAddress: IpAddress,
            Device: Device,
            Location: Location
        }; 
    } 

    sendRequest(data,url)
    .then(responseData => {
        console.log('Response Data:', responseData);
        console.log(responseData.Traget);
        Intent = responseData.Target;

        if (responseData.Parameters) {
            if (responseData.Parameters.AccountAddress) {
                AccountAddress = responseData.Parameters.AccountAddress;
            }
            if (responseData.Parameters.AuthorizationToken) {
                AuthToken = responseData.Parameters.AuthorizationToken;
            }
        }

        if (responseData.Response){
            ResponseMessage = responseData.Response;
        }

        console.log(ResponseMessage);
        console.log(Intent);
        changeForm(Intent);
        if (Intent === null) {
            Intent = "Login";
        }
        document.querySelector('.ResponseMessage').innerHTML = ResponseMessage;

        if (Intent === "1" ||Intent === "2"||Intent === "3"||Intent === "4"){
            let target = null;
            switch (Intent) {
                case '1':
                    console.log('Welcome Administrator');
                    target = 'Administrator';
                    break;
                case '2':
                    console.log('Welcome Accounting');
                    target = 'Accounting';
                    break;
                case '3':
                    console.log('Welcome Merchant Admin');
                    target = 'MerchantAdmin';
                    break;
                case '4':
                    console.log('Welcome Merchant Staff');
                    target = 'MerchantStaff';
                    break;
                default:
                    console.log('Invalid');
                    window.location.reload();
                    break;
            }
            document.getElementById('redirect').innerHTML = `
                <form id="redirectForm" action="`+baseUrl+`/`+target+`" method="post">
                    <input type="hidden" name="AuthToken" value="`+AuthToken+`">
                    <input type="hidden" name="AccountAddress" value="`+AccountAddress+`">
                    <input type="hidden" name="IpAddress" value="`+IpAddress+`">
                    <input type="hidden" name="Device" value="`+Device+`">
                    <input type="hidden" name="Location" value="`+Location+`">
                </form>
            `;
            var form = document.getElementById("redirectForm");
            form.submit();
        }

    })
    .catch(error => {
        console.error('Request Error:', error);
    });
}


function logout(){
    var data = {};
    let url = "/Api/Auth/Process";
    Intent = "Logout";

    sendRequest(data,url)
        .then(responseData => {
            console.log('Response Data:', responseData);
    })
        .catch(error => {
            console.error('Request Error:', error);
    });
}

// ONLOAD
document.addEventListener("DOMContentLoaded", function () {
    bindEventListeners();
    changeForm("Login");
    validate ();
});