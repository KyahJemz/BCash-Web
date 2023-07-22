import {    
    getNotificationArray,
    setNotificationArray
} from '../main.js';

import Notification from '../class/class-notification.js';

export function activateNotification () {
    const box = document.getElementById("Notification-Box-Container");
    box.style.display = "flex";
}

export function deactivateNotification () {
    const box = document.getElementById("Notification-Box-Container");
    box.style.display = "none";
}

export function removeNotificationBox(notification,notificationTable){
    notification.removePopupNotificationElement();
    if (notificationTable.childElementCount <= 0){
        deactivateNotification();
    }
}

export function getNotifications(){
    let notificationArray = getNotificationArray();
    return notificationArray;
}

export function refreshNotifications(){

    let rawNotificationArray = [];
    rawNotificationArray.push("1");
    rawNotificationArray.push("1");
    rawNotificationArray.push("1");
    rawNotificationArray.push("1");
    rawNotificationArray.push("1");
    rawNotificationArray.push("1");
    rawNotificationArray.push("1");
    rawNotificationArray.push("1");
    rawNotificationArray.push("1");
    rawNotificationArray.push("1");
    // get notifcation from ajax
    let notificationArray = [];
    //loop

    rawNotificationArray.forEach(item => {
        let notification = new Notification();
        notification.setNotificationBoxInfo("id","title","content","timestamp","type");
        notificationArray.push(notification);
    });
    setNotificationArray(notificationArray);


}
