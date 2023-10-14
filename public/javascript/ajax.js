import Alerts from './modules/alerts.js';

export default class AjaxRequest {

    constructor(baseURL){
        this.baseURL = baseURL
    }

    sendRequest(data, intent) {
        const alerts = new Alerts(document.querySelector(".Alert-Box-Table"));
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
            .then(data => {
                if (data.Success === false) {
                    alerts.createAlertElement('danger', data.Response)
                } else {
                    console.log(data);
                    if (data.Response !== '' && data.Response !== null){
                        alerts.createAlertElement('success', data.Response)
                    }
                }
                resolve(data);
            })
            .catch(error => {
                alerts.createAlertElement('danger', error);
                reject(error);
            });
        });
    }
}
