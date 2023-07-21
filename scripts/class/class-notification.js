
export default class Notification {

    maxNotificationTimeout = 500;
    maxNotificationCount = 5;

    createInfo(id,title,content) {
        this.id = id;
        this.title = title;
        this.content = content;
    }

    getContent(){
        return this.content;
    }

    getId(){
        return this.id;
    }

    getTitle(){
        return this.title;
    }

    getMaxNotificationTimeout(){
        return this.maxNotificationTimeout;
    }
}