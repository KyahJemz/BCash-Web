export function activateNotification () {
    const box = document.getElementById("Notification-Box-Container");
    box.style.display = "flex";
}

export function deactivateNotification () {
    const box = document.getElementById("Notification-Box-Container");
    box.style.display = "none";
}

export function removeNotificationBox(notification,notificationTable){
    notification.removeElement();
   
    if (notificationTable.childElementCount <= 0){
        deactivateNotification();
    }
    console.log("Removed");
}
