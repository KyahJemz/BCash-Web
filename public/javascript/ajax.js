import Alerts from './modules/alerts.js';

export default class AjaxRequest {

    constructor(baseURL){
        this.baseURL = baseURL
    }

    makeAlert(type,text){
        const alerts = new Alerts(document.querySelector(".Alert-Box-Table"));
        alerts.createAlertElement(type,text);
    }

    sendRequest(data, intent) {
        return new Promise((resolve, reject) => {
            fetch(this.baseURL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': AuthToken,
                    'AccountAddress': AccountAddress,
                    'ClientVersion': ClientVersion,
                    'IpAddress': IpAddress,
                    'Device': Device,
                    'Location': Location,
                    'Intent': intent, 
                },
                body: JSON.stringify(data),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText);
                }
                return response.json();
            })
            .then(data => resolve(data))
            .catch(error => {
                this.makeAlert('danger', error);
                reject(error);
            });
        });
    }
}
