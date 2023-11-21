import Layouts from "./layouts.js";
import { ChangeLayout } from "./layoutManager.js";
import Defaults from "./defaults.js";
import Helper from "./helper.js";

export default class Modules {

    static SplashScreen () {
        setTimeout(() => {
            ChangeLayout(Layouts.Login(), Modules.LoginModule, null);
        }, Defaults.SplashScreenTime);
    }

    static LoginModule() {
        document.getElementById("Login-SignIn").addEventListener('click', ()=>{
            console.log("123");
        });



    }
}
