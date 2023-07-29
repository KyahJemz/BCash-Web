
export default class Notification {

    maxNotificationTimeout = 3000;
    maxNotificationCount = 5;

// NOTIFICATION BOX
    setNotificationBoxInfo(id,title,content,timestamp,type) {
        this.id = id;
        this.title = title;
        this.content = content;
        this.timestamp = timestamp;
        this.type = type;
    }

    getNotificationBoxView(){
        return `
            <div class="notification-item" data-type="`+ this.type +`" data-id="`+ this.id +`">
                <div class="title-container">
                    <p class="title">`+ this.title +`</p>
                    <p class="date">`+ this.timestamp +`</p>
                </div>
                <div class="content-container">
                    <p class="content">`+ this.content +`</p>
                </div>
            </div>
            `;
    }

// NOTIFICATION POPUP
    setPopupNotificationInfo(id,title,content,timeout) {
        this.id = id;
        this.title = title;
        this.content = content;
        if (timeout > 0){
            this.maxNotificationTimeout = number;
        }
    }

    setPopupNotificationElement(element){
        this.element = element;
    }

    removePopupNotificationElement(){
        const notificationTable = document.querySelector(".Notification-Box-Table");
        notificationTable.removeChild(this.element);
    }

    getPopupNotificationView(){
        return  `<div class="header">
                    <div class="title">
                        <p class="text">`+ this.title +`</p>
                    </div>
                    <div class="close">
                        <p class="close-btn cursor-pointer">X</p>
                    </div>
                </div>
                <div class="notification-content">
                    <p>`+ this.content +`</p>
                </div>
            `;
        
    }

    getPopupNotificationMaxNotificationTimeout(){
        return this.maxNotificationTimeout;
    }

    getPopupNotificationMaxNotificationCount(){
        return this.maxNotificationCount;
    }

    getPopupNotificationId(){
        return this.id;
    }
}