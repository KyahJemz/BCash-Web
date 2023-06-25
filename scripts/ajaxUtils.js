function sendAjaxRequest(url, method, data) {
    return new Promise((resolve, reject) => {
        fetch(url, {
            method,
            headers: {
                'Content-Type': 'application/json',
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
  
export function uploadOrderData(url, cardNumber, items) {
const data = {
    cardNumber,
    items,
};

return sendAjaxRequest(url, 'POST', data);
}
  
  // Add more AJAX utility functions as needed