
class notification {
    constructor(title,content) {
        this.title = title;
        this.content = content
    }


}



function activateNotification () {
    const box = document.getElementById("Notification-Box-Container");
    box.style.display = "flex";
}


function deactivateNotification () {
    const box = document.getElementById("Notification-Box-Container");
    box.style.display = "none";
}

function removeNotificationBox(value){
    let notificationBox = value.parentNode.parentNode.parentNode;
    notificationBox.classList.add('remove-notification');
    setTimeout(function() {
        notificationBox.remove();
    }, 100);
}

function addNotificationBox(content) {
    let box = document.getElementById("Notification-Box-Container");
    
    box.innerHTML += content;
    
    let lastChildDiv = box.lastElementChild;
    setTimeout(function() {
        lastChildDiv.classList.add('add-notification');
    }, 50);
    
  }