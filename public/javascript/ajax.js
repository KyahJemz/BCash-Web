export default class AjaxRequest {

    constructor(baseURL){
        this.baseURL = baseURL
    }

    sendRequest(url, method, data, AccountAddress, token) {
        return new Promise((resolve, reject) => {
            fetch(url, {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': token,
                    'AccountAddress': AccountAddress,
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