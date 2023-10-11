import Alerts from './modules/alerts.js';

export default class AjaxRequest {

    constructor(baseURL){
        this.baseURL = baseURL
    }

    makeAlert(type,text){
        if (text!=''){
            const alerts = new Alerts();
            alerts.createAlert(type,text);
        }
    }

    sendRequest(url, data, intent) {
        return new Promise((resolve, reject) => {
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': AuthToken,
                    'AccountAddress': AccountAddress,
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
            .catch(error => reject(error));
        });
    }
}


// ##########
// ORDERS API
// ##########


// ##########
// ITEMS API
// ##########

    

    

// ##########
// ITEMS API
// ##########

