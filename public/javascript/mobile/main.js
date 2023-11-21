import Layouts from "./layouts.js";
import Modules from "./modules.js";
import { ChangeLayout } from "./layoutManager.js";
import Defaults from "./defaults.js";

ChangeLayout(Layouts.SplashScreen(), Modules.SplashScreen, null);

ChangeLayout(Layouts.Login(), Modules.LoginModule, null);

export function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();
    console.log('ID: ' + profile.getId());
    console.log('Name: ' + profile.getName());
    console.log('Image URL: ' + profile.getImageUrl());
    console.log('Email: ' + profile.getEmail());
}

export function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
        console.log('User signed out.');
    });
}