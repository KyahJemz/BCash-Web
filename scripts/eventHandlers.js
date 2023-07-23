import { 
    toggleSubMenuDropdown, 
    ChangeTitle, 
    ChangeMenuSelected, 
    HideAllPanels, 
    ChangePanel 
} from './modules/menu.js';

import { 
    getTransactionHistory, 
    displayToTable, 
} from './modules/transactions.js';

import {
    displayItems
} from './modules/item.js';

import {
    openDialogBox,
    openAlertDialogBox,
    closeDialogBox
} from './modules/dialog-box.js';

import {
    activateNotification,
    deactivateNotification,
    removeNotificationBox
} from './modules/notification-box.js';

import { 
    displayOrders,
    toggleItemButton,
    toggleQuantityButton,
    refreshReceiptValues
} from './modules/order.js';

import { 
    dropdown, 
    changeSelection, 
    windowClickClearDropdown, 
} from './modules/dropdown.js';

import { 
    uploadOrderData 
} from './ajaxUtils.js';





export function windowOnclickEvents(event){
    windowClickClearDropdown(event)

    const dialogContainer = document.getElementById('Dialog-Box-Container');
    const dialogContent = document.querySelector('.dialog-content');
    
    if (event.target === dialogContainer && !dialogContent.contains(event.target)) {
        closeDialogBox();
    }
}

export function closeDialogBoxEvents(){
    closeDialogBox();
}




//#####//
// ORDER EVENTS
//#####//

export function addToCart(button, order, itemId, name, cost, image, quantity) {
    if (button.dataset.type == "AddToCart") {
        order.addItem(itemId, name, cost, image, quantity);
    } 
    if (button.dataset.type == "RemoveToCart") {
        order.removeItem(itemId);
    }
    toggleItemButton(button);
    displayOrders(order);
    refreshReceiptValues(order);
}

export function quantity(order, itemId, type) {
    console.log("Quantity Fired")
    order.updateQuantity(itemId, type)
    displayOrders(order);
    toggleQuantityButton(order,itemId)
    refreshReceiptValues(order);
}

export function refreshReceipt(order){
    refreshReceiptValues(order);
}

export function clearOrder(order) {
    document.querySelectorAll(".addToCartButton").forEach(button => {
        if(button.dataset.type === "RemoveToCart") {
            console.log(button.parentNode.parentNode.dataset.itemId);
            order.removeItem(button.parentNode.parentNode.dataset.itemId);
            toggleItemButton(button);
            displayOrders(order);
            refreshReceiptValues(order);
        }
    })
}

export function placeOrderEvents(order) {
    if (order.items.length > 0) {
        uploadOrderData();
    } else {
        openAlertDialogBoxEvents("Invalid Request","Try adding some improvemnts");
    }
}


//#####//
// ITEM EVENTS
//#####//

export function displayItemsEvents(items, order, type){
    displayItems(items,order, type);
    displayOrders(order);
}


//#####//
// MENU EVENTS
//#####//

export function menuSelectionEvents(value, items, order) {
    // Used ".replace(new RegExp(" ", 'g'), '')" to remove spaces
    const panelName = value.dataset.menu;
    const panelId = "panel-"+panelName.replace(new RegExp(" ", 'g'), '').toLowerCase();

    console.log(panelName);
    if (value.classList.contains("menuSelectionDropdownButton")) {
        toggleSubMenuDropdown(value); 
    } else {
        if(document.getElementById(panelId)){
            ChangeTitle(panelName);
            ChangeMenuSelected(panelName);
            HideAllPanels(panelId);
            ChangePanel(panelId);
            console.log(panelId);
        } else {
            console.log("Panel Does Not Exist");
        }
    }

    // Check and Refresh Items Depending On Panel Clicked
    if (panelName === "Item Management"){
        displayItems(items,order, panelName.replace(new RegExp(" ", 'g'), ''));
    } else if (panelName === "Create Order") {
        displayItems(items,order, panelName.replace(new RegExp(" ", 'g'), ''));
    }
}

//#####//
// DROPDOWN EVENTS
//#####//
  
export function dropdownEvents(event, value, position) {
    dropdown(event, value, position);
}

export function changeSelectionEvents(element) {
    changeSelection(element);
}

export function windowClickClearDropdownEvents(event) {
    windowClickClearDropdown(event);
}
  

//#####//
// DIALOG BOX EVENTS
//#####//

export function openDialogBoxEvents(type) {
    openDialogBox(type)
}

export function openAlertDialogBoxEvents(title,message){
    openAlertDialogBox(title,message);
}

  
//#####//
// TRANSACTIONS EVENTS
//#####//

export function applyTransactionsQueries(){
    const transactionsTable = document.getElementById("transactions-table");
    let transactionStartDate = document.getElementById("transactions-startdate").value;
    let transactionEndDate = document.getElementById("transactions-enddate").value;
    let transactionNumber = document.getElementById("transactions-transactionnumber").value;
    let transactionName = document.getElementById("transaction-transactionname").value;
    let transactionStatus = document.getElementById("transaction-status-dropdown").innerHTML;
    let transactionsRecordPerPage = document.getElementById("transaction-recordscount-dropwond").innerHTML

    if (transactionStartDate==="" || transactionEndDate==="") {
        const currentDate = new Date();
        const year = currentDate.getFullYear();
        const month = String(currentDate.getMonth() + 1).padStart(2, '0');
        const day = String(currentDate.getDate()).padStart(2, '0');
        const formattedDate = `${year}-${month}-${day}`;

        if (transactionStartDate==="") {
            transactionStartDate = `${formattedDate} ${"00:00:00"}`;
        } else {
            transactionStartDate = `${transactionStartDate} ${"00:00:00"}`;
        }
        if (transactionEndDate==="") {
            transactionEndDate  = `${formattedDate} ${"23:59:59"}`;
        } else {
            transactionEndDate  = `${transactionEndDate} ${"23:59:59"}`;
        }
    }

    if (transactionsRecordPerPage === "25/Page" || transactionsRecordPerPage === "50/Page" || transactionsRecordPerPage === "100/Page" || transactionsRecordPerPage === "500/Page") {
        if (transactionsRecordPerPage === "25/Page") {
            transactionsRecordPerPage = "25";
        } else if (transactionsRecordPerPage === "50/Page"){
            transactionsRecordPerPage = "50";
        } else if (transactionsRecordPerPage === "100/Page"){
            transactionsRecordPerPage = "100";
        } else if (transactionsRecordPerPage === "500/Page"){
            transactionsRecordPerPage = "500";
        } else {
            transactionsRecordPerPage = "25";
        }
    } else {
        transactionsRecordPerPage = "25";
    }

    const data = getTransactionHistory(transactionStartDate,transactionEndDate,transactionNumber,transactionName,transactionStatus,transactionsRecordPerPage);
    console.log(data);

    displayToTable(transactionsTable,data);
}

export function clearTransactionsQueries(){

}



export function createNotification(notificationArray,notification){
    const notificationTable = document.querySelector(".Notification-Box-Table");

    if (notificationTable.querySelectorAll(".notification-box").length === 0) {
        activateNotification();
    }

    if (notificationTable.querySelectorAll(".notification-box").length > notification.getPopupNotificationMaxNotificationCount()) {
        notificationTable.removeChild(notificationTable.querySelector("tr"));
    }

    const newRow = document.createElement('tr');
    newRow.className = "notification-box";
    newRow.dataset.type = notification.getPopupNotificationId();
    
    const newCell = document.createElement('td');
    newCell.innerHTML = notification.getPopupNotificationView();

    notification.setPopupNotificationElement(newRow);
    
    newRow.appendChild(newCell);
    notificationTable.appendChild(newRow);

    setTimeout(function() {
        removeNotificationBox(notification,notificationTable);
    }, notification.getPopupNotificationMaxNotificationTimeout());
}










  
   