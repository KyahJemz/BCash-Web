import { 
    toggleMyOrdersMenu, 
    ChangeTitle, 
    ChangeMenuSelected, 
    HideAllPanels, 
    ChangePanel 
} from './modules/menu.js';

import {
    displayItems
} from './modules/item.js';

import {
    openDialogBox,
    openAlertDialogBox,
    closeDialogBox
} from './modules/dialog-box.js';

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

export function quantity(button, order, itemId, type) {
    console.log("Quantity Fired")
    order.updateQuantity(itemId, type)
    displayOrders(order);
    toggleQuantityButton(button, order,itemId)
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

export function refreshItems(items, order, type){
    displayItems(items,order, type);
    displayOrders(order);
}


//#####//
// MENU EVENTS
//#####//

export function menuSelectionEvents(value, items, order) {
    // Used ".replace(new RegExp(" ", 'g'), '')" to remove spaces

    if (value === "My Orders") {
        toggleMyOrdersMenu(); // 
    } else {
        ChangeTitle(value);
        ChangeMenuSelected(value.replace(new RegExp(" ", 'g'), ''));
        HideAllPanels(value.replace(new RegExp(" ", 'g'), ''));
        ChangePanel(value.replace(new RegExp(" ", 'g'), ''));
    }

    // Check and Refresh Items Depending On Panel Clicked
    if (value.replace(new RegExp(" ", 'g'), '').toUpperCase() === "ITEMMANAGEMENT"){
        refreshItems(items,order, value.replace(new RegExp(" ", 'g'), ''))
    } else if (value.replace(new RegExp(" ", 'g'), '').toUpperCase() === "CREATEORDER") {3
        refreshItems(items,order, value.replace(new RegExp(" ", 'g'), ''))
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

  
  
   