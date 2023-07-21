

export function activateNotification () {
    const box = document.getElementById("Notification-Box-Container");
    box.style.display = "flex";
}

export function deactivateNotification () {
    const box = document.getElementById("Notification-Box-Container");
    box.style.display = "none";
}

export function removeNotificationBox(value,notificationTable){
    const notificationBoxes = document.querySelectorAll(".notification-box");
    notificationBoxes.forEach(element => {
        if (element.dataset.type === value.getId()){
            notificationTable.removeChild(element);
        }
    });
    if (value)
}

export function addNotificationBox(content) {
    let box = document.getElementById("Notification-Box-Container");


    box.innerHTML += `<div id="Notification-Box-Id" class="notification-box" data-type="123">
            <div class="header">
                <div class="title">
                    <p class="text">New Notification 1</p>
                </div>
                <div class="close">
                    <p class="close-btn curson-pointer">X</p>
                </div>
            </div>
            <div class="notification-content">
                <p>123</p>
            </div>
        </div>`;


    let lastChildDiv = box.lastElementChild;
    setTimeout(function() {
        lastChildDiv.classList.add('add-notification');
    }, 50);
    
  }