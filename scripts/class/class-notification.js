
export default class Notification {

    maxNotificationTimeout = 2000;
    maxNotificationCount = 5;

    setInfo(id,title,content) {
        this.id = id;
        this.title = title;
        this.content = content;
    }

    setElement(element){
        this.element = element;
    }

    removeElement(){
        const notificationTable = document.querySelector(".Notification-Box-Table");
        notificationTable.removeChild(this.element);
    }

    getView(){
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

    getMaxNotificationTimeout(){
        return this.maxNotificationTimeout;
    }

    getMaxNotificationCount(){
        return this.maxNotificationCount;
    }

    getId(){
        return this.id;
    }
}