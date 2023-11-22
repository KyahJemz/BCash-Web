import Layouts from "./layouts.js";
import Modules from "./modules.js";
import { ChangeLayout } from "./layoutManager.js";

export default class AjaxRequest {

    static sendRequest(data, intent, url) {
        //const alerts = new Alerts(document.querySelector(".Alert-Box-Table"));
        return new Promise((resolve, reject) => {
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': AuthToken,
                    'AccountAddress': AccountAddress,
                    'ClientVersion': ClientVersion,
                    'IpAddress': IpAddress,
                    'Device': Device,
                    'Location': Location,
                    'Intent': intent, 
                },
                body: JSON.stringify(data),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText);
                }
                return response.json();
            })
            .then(data => {
                console.log('--Server Response--',data); // For Logs
                if (data.Success === false) {
                    //alerts.createAlertElement('danger', data.Response);
                    if (data.Target === 'Login') {
                        window.location.href = 'http://localhost/index.php/mobile/index';
                        alert("Sign in required, Authentication failed or session expired.");
                    }
                } else if (data.Success === true){
                    if (data.Response !== '' && data.Response !== null){
                        //alerts.createAlertElement('success', data.Response)
                    }
                    if (data.Target === 'Login') {
                        window.location.href = 'http://localhost/index.php/mobile/index';
                        alert("Signing out");
                    }
                }
                if (data?.Parameters?.AccountAddress) {
                    AccountAddress = data.Parameters.AccountAddress;
                }
                if (data?.Parameters?.AuthorizationToken) {
                    AuthToken = data.Parameters.AuthorizationToken;
                }
                switch (data.Target) {
                    case "OTPValidation":
                        ChangeLayout(Layouts.OTPValidation(), Modules.OTPValidationModule, null);
                        break;

                    case "PINValidation":
                        ChangeLayout(Layouts.PinValidation(), Modules.PinValidationModule, null);
                        break;

                    case "PINCreation":
                        ChangeLayout(Layouts.PinCreation(), Modules.PinCreationModule, null);
                        break;

                    case "5":
                        ChangeLayout(Layouts.Home(), Modules.HomeModule, null);
                        break;

                    case "6":
                        ChangeLayout(Layouts.Home(), Modules.HomeModule, null);
                        break;

                    case "7":
                        ChangeLayout(Layouts.Home(), Modules.HomeModule, null);
                        break;

                    case null:
                        break;
                
                    default:
                        ChangeLayout(Layouts.Login(), Modules.LoginModule, null);
                        break;
                }
                resolve(data);
            })
            .catch(error => {
                //alerts.createAlertElement('danger', error);
                reject(error);
            });
        });
    }
}
