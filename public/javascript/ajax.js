export default class AjaxRequest {

    constructor(baseURL){
        this.baseURL = baseURL
    }

    sendRequest(url, method, data) {
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




    
}


// ##########
// ORDERS API
// ##########

    export function uploadOrderData(walletAddress, items) {
        const url = "";
        const data = {
            walletAddress,
            items,
        };
        return sendAjaxRequest(url, 'POST', data);
    }

// ##########
// ITEMS API
// ##########

    export function deleteItemData(itemId) {
        const url = "";
        const data = {
            itemId
        };
        return sendAjaxRequest(url, 'POST', data);
    }

    export function updateItemImage(itemId,image) {
        const url = "";
        const data = {
            itemId,
            itemImage
        };
        return sendAjaxRequest(url, 'POST', data);
    }

    export function UpdateItemData(item) {
        const url = "";
        const data = {
        itemId: item.id,
        itemName: item.name,
        itemCost: item.cost
        };
        return sendAjaxRequest(url, 'POST', data);
    }

    export function addItemData(name, cost, image) {
        const url = "";
        const data = {
        itemName: name,
        itemCost: cost,
        itemImage: image
        };
        return sendAjaxRequest(url, 'POST', data);
    }
    
    export function searchItemData(query) {
        const url = "";
        const data = {
            query
        };
        return sendAjaxRequest(url, 'GET', data);
    }

    export function filterItemData(query) {
        const url = "";
        const data = {
            query
        };
        return sendAjaxRequest(url, 'GET', data);
    }

    export function layoutItem(query) {
        const url = "";
        const data = {
            query
        };
        return sendAjaxRequest(url, 'GET', data);
    }





    

// ##########
// ITEMS API
// ##########

