import { 
    makePopupNotification,
    getNotificationArray, 
    getItems, 
    getOrder,
    bindDropdownSubItemEventButtons
} from './---main.js';

import { 
    toggleSubMenuDropdown, 
    ChangeTitle, 
    ChangeMenuSelected, 
    HideAllPanels, 
    ChangePanel 
} from './modules/menu.js';

import { 
    getTransactionsData, 
    clearTransactioQueries,
    displayTransactionsToTable, 
} from './modules/transactions.js';

import { 
    getAccountsData, 
    displayAccountsToTable, 
} from './modules/accounts.js';

import {
    displayItems
} from './modules/items.js/index.js';

import {
    openDialogBox,
    openAlertDialogBox,
    closeDialogBox
} from './modules/dialog-box.js';

import {
    activateNotification,
    deactivateNotification,
    removeNotificationBox
} from './modules/notifications.js';

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

export function addToCart(event, order) {
    const value = event.currentTarget;
    const itemId = value.parentNode.parentNode.dataset.itemId;
    const name = value.parentNode.parentNode.dataset.name;
    const cost = value.parentNode.parentNode.dataset.cost;
    const image = value.parentNode.parentNode.dataset.image;
    const quantity = "1";

    if (value.dataset.type == "AddToCart") {
        order.addItem(itemId, name, cost, image, quantity);
    } 
    if (value.dataset.type == "RemoveToCart") {
        order.removeItem(itemId);
    }
    toggleItemButton(value);
    displayOrders(order);
    refreshReceiptValues(order);
}

export function quantity(event, order) {
    const value = event.currentTarget;
    const itemId = value.parentNode.parentNode.dataset.itemId;
    const type = value.dataset.type;

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

export function categorySelected(event, items, order) {
    const value = event.currentTarget;
    value.classList.toggle("category-item-selected");
    displayItems(items,order, value.parentNode.dataset.type);
}


//#####//
// MENU EVENTS
//#####//

export function menuSelectionEvents(event) {
    // Used ".replace(new RegExp(" ", 'g'), '')" to remove spaces
    const value = event.currentTarget;
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
        } else {
            console.log("Panel Does Not Exist");
            makePopupNotification("","Panel Does Not Exist","Panel Does Not Exist");
        }
    }

    // Check and Refresh Items Depending On Panel Clicked

    if (panelName === "Item Management"){
        try {
            displayItems(getItems(),getOrder(), panelName.replace(new RegExp(" ", 'g'), ''));
        } catch (error) {
            makePopupNotification("","Display Error",error);
            console.error("Error getting items or order:", error);
        }
    } 
    if (panelName === "Create Order") {
        try {
            displayItems(getItems(),getOrder(), panelName.replace(new RegExp(" ", 'g'), ''));
        } catch (error) {
            makePopupNotification("","Display Error",error);
            console.error("Error getting items or order:", error);
        }
    }
}

//#####//
// DROPDOWN EVENTS
//#####//
  
export function dropdownEvents(event) {
    const value = event.currentTarget;
    const position = value.dataset.layout;
    dropdown(event, value, position);
}

export function changeSelectionEvents(event) {
    const value = event.currentTarget;
    changeSelection(value);

    const panel = value.parentNode.parentNode.dataset.panel;
    console.log(panel);
    if (panel != undefined){
        displayItemsEvents(getItems(), getOrder(), panel);
        bindDropdownSubItemEventButtons();
    }
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

export function applyTransactionsQueries(button){
    const transactionsTable = button.parentNode.parentNode.parentNode.querySelector(".transactions-table");
    const transactionStartDateElement = button.parentNode?.parentNode?.parentNode.querySelector(".transactions-startdate");
    const transactionEndDateElement = button.parentNode?.parentNode?.parentNode.querySelector(".transactions-enddate");
    const transactionNumberElement = button.parentNode?.parentNode?.parentNode.querySelector(".transactions-transactionnumber");
    const transactionNameElement = button.parentNode?.parentNode?.parentNode.querySelector(".transactions-transactionname");
    const transactionStatusDropdown = button.parentNode?.parentNode?.parentNode.querySelector(".transactions-status-dropdown");

    const transactionsRecordPerPageDropdown = button.parentNode?.parentNode?.parentNode.querySelector(".transactions-recordscount-dropdown");
    
    let transactionStartDate = transactionStartDateElement ? transactionStartDateElement.value : '';
    let transactionEndDate = transactionEndDateElement ? transactionEndDateElement.value : '';
    const transactionNumber = transactionNumberElement ? transactionNumberElement.value : '';
    const transactionName = transactionNameElement ? transactionNameElement.value : '';
    const transactionStatus = transactionStatusDropdown ? transactionStatusDropdown.textContent.trim() : '';
    const transactionsRecordPerPage = transactionsRecordPerPageDropdown ? transactionsRecordPerPageDropdown.textContent.trim() : '';

    if (transactionStartDate==="" || transactionEndDate==="") {
        const currentDate = new Date();
        const year = currentDate.getFullYear();
        const month = String(currentDate.getMonth() + 1).padStart(2, '0');
        const day = String(currentDate.getDate()).padStart(2, '0');
        const formattedDate = `${year}-${month}-${day}`;

        if (transactionStartDate==="") { // Check if empty, add default value
            transactionStartDate = `${formattedDate} ${"00:00:00"}`;
        } else { // If has value, add morning time
            transactionStartDate = `${transactionStartDate} ${"00:00:00"}`;
        }

        if (transactionEndDate==="") { // Check if empty, add default value
            transactionEndDate  = `${formattedDate} ${"23:59:59"}`;
        } else { // If has value, add evening time
            transactionEndDate  = `${transactionEndDate} ${"23:59:59"}`;
        }
    }



    const data = getTransactionsData(transactionStartDate,transactionEndDate,transactionNumber,transactionName,transactionStatus,transactionsRecordPerPage);

    displayTransactionsToTable(transactionsTable,data);
}

export function clearTransactionsQueries(button){
    const transactionsTable = button.parentNode.parentNode.parentNode.querySelector(".transactions-table");
    const transactionStartDateElement = button.parentNode?.parentNode?.parentNode.querySelector(".transactions-startdate");
    const transactionEndDateElement = button.parentNode?.parentNode?.parentNode.querySelector(".transactions-enddate");
    const transactionNumberElement = button.parentNode?.parentNode?.parentNode.querySelector(".transactions-transactionnumber");
    const transactionNameElement = button.parentNode?.parentNode?.parentNode.querySelector(".transactions-transactionname");
    const transactionStatusDropdown = button.parentNode?.parentNode?.parentNode.querySelector(".transactions-status-dropdown");

    clearTransactioQueries(transactionsTable,transactionStartDateElement,transactionEndDateElement,transactionNumberElement,transactionNameElement,transactionStatusDropdown);


    
    
}

//#####//
// ACCOUNTS EVENTS
//#####//

export function applyAccountsQueries(button){
    const accountsTable = button.parentNode?.parentNode?.parentNode.querySelector(".accounts-table");
    const accountIdElement = button.parentNode?.parentNode?.parentNode.querySelector(".accounts-accountschoolid");
    const accountFirstNameElement = button.parentNode?.parentNode?.parentNode.querySelector(".accounts-accountfirstname");
    const accountLastNameElement = button.parentNode?.parentNode?.parentNode.querySelector(".accounts-accountlastname");
    const groupDropdown = button.parentNode?.parentNode?.parentNode.querySelector(".accounts-group-dropdown");
    const departmentDropdown = button.parentNode?.parentNode?.parentNode.querySelector(".accounts-department-dropdown");
    const courseDropdown = button.parentNode?.parentNode?.parentNode.querySelector(".accounts-course-dropdown");
    const recordsCountDropdown = button.parentNode?.parentNode?.parentNode.querySelector(".accounts-recordscount-dropdown");
    const categoryDropdown = button.parentNode?.parentNode?.parentNode.querySelector(".accounts-category-dropdown");

    const accountId = accountIdElement ? accountIdElement.value : '';
    const accountFirstName = accountFirstNameElement ? accountFirstNameElement.value : '';
    const accountLastName = accountLastNameElement ? accountLastNameElement.value : '';
    const accountGroupFilter = groupDropdown ? groupDropdown.textContent.trim() : '';
    const accountDepartmentFilter = departmentDropdown ? departmentDropdown.textContent.trim() : '';
    const accountCourseFilter = courseDropdown ? courseDropdown.textContent.trim() : '';
    const accountsRecordPerPage = recordsCountDropdown ? recordsCountDropdown.textContent.trim() : '';
    const accountCategoryFilter = categoryDropdown ? categoryDropdown.textContent.trim() : '';
        
    /*
    if (accountsRecordPerPage === "25/Page" || accountsRecordPerPage === "50/Page" || accountsRecordPerPage === "100/Page" || accountsRecordPerPage === "500/Page") {
        if (accountsRecordPerPage === "25/Page") {
            accountsRecordPerPage = "25";
        } else if (accountsRecordPerPage === "50/Page"){
            accountsRecordPerPage = "50";
        } else if (accountsRecordPerPage === "100/Page"){
            accountsRecordPerPage = "100";
        } else if (accountsRecordPerPage === "500/Page"){
            accountsRecordPerPage = "500";
        } else {
            accountsRecordPerPage = "25";
        }
    } else {
        accountsRecordPerPage = "25";
    }
    */

    const data = getAccountsData();
    console.log(data);

   displayAccountsToTable(accountsTable,data);
}

export function clearAccountsQueries(button){

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










  
   