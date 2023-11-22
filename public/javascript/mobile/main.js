import Layouts from "./layouts.js";
import Modules from "./modules.js";
import { ChangeLayout } from "./layoutManager.js";
import Defaults from "./defaults.js";
import AjaxRequest from "./ajax.js";

//ChangeLayout(Layouts.SplashScreen(), Modules.SplashScreen, null);

ChangeLayout(Layouts.Login(), Modules.LoginModule, null);

window.handleCredentialResponse = (response) => {
    console.log(response.credential);
    const data = {
        GoogleToken: response.credential,
        IpAddress: IpAddress,
        Device: Device,
        Location: Location,
    };
    AjaxRequest.sendRequest(data,"MobileLogin",BaseURL+"Api/Auth/Process")
        .then(responseData => {

    });
}




export function ScanForPurchases() {
    if (AccountAddress === "" || AuthToken === "") {
        return false;
    }
    AjaxRequest.sendRequest([],"scan for purchases",BaseURL+"Api/Auth/Process")
        .then(responseData => {
            if (responseData.Success === true) {
                ChangeLayout(Layouts.PurchaseConfirmation(), Modules.PurchaseConfirmationModule, responseData.Parameters);
            } else {
                ScanForPurchases();
            }
        });
}








