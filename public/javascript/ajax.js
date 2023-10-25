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
                console.log('--Server Response--',data); // For Logs
                if (data.Success === false) {
                    alerts.createAlertElement('danger', data.Response);
                    if (data.Target === 'Login') {
                        alert("Sign in required, Authentication failed or session expired.");
                        window.location.href = 'http://localhost/';
                    }
                } else if (data.Success === true){

                    if (data.Response !== '' && data.Response !== null){
                        alerts.createAlertElement('success', data.Response)
                    }
                    if (data.Target === 'Login') {
                        alert("Signing out");
                        window.location.href = 'http://localhost/';
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

    sendFormDateRequest(FormData, intent) {
        const alerts = new Alerts(document.querySelector(".Alert-Box-Table"));
        return new Promise((resolve, reject) => {
            fetch(this.baseURL, {
                method: 'POST',
                headers: {
                    'Content-Type': false,
                    'Authorization': AuthToken,
                    'AccountAddress': AccountAddress,
                    'ClientVersion': ClientVersion,
                    'IpAddress': IpAddress,
                    'Device': Device,
                    'Location': Location,
                    'Intent': intent, 
                },
                body: FormData,
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText);
                }
                return response.json();
            })
            .then(data => {
                console.log('--Server Response--',data); // For Logs
                if (data.Success === false) {
                    alerts.createAlertElement('danger', data.Response);
                    if (data.Target === 'Login') {
                        alert("Sign in required, Authentication failed or session expired.");
                        window.location.href = 'http://localhost/';
                    }
                } else if (data.Success === true){

                    if (data.Response !== '' && data.Response !== null){
                        alerts.createAlertElement('success', data.Response)
                    }
                    if (data.Target === 'Login') {
                        alert("Signing out");
                        window.location.href = 'http://localhost/';
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
