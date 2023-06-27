import { 
    toggleMyOrdersMenu, 
    ChangeTitle, 
    ChangeMenuSelected, 
    HideAllPanels, 
    ChangePanel 
} from './modules/menu.js';

import { 
    displayOrders
} from './modules/dropdown.js';

import { 
    dropdown, 
    changeSelection, 
    windowClickClearDropdown, 
} from './modules/order.js';

import { 
    uploadOrderData 
} from './ajaxUtils.js';



export function windowOnclickEvents(event){
    windowClickClearDropdown(event)
}



//#####//
// ORDER EVENTS
//#####//

export function addToCart(order, itemId, quantity) {
  order.addItem(itemId, quantity);
  displayOrders(order);
}

export function placeOrder(order) {
    uploadOrderData();
}




//#####//
// DROPDOWN EVENTS
//#####//

export function menuSelectionEvents(selected) {
    const value = selected.querySelector('p').innerText;
    console.log(value);
  
    if (value === "My Orders") {
        toggleMyOrdersMenu();
    } else {
        ChangeTitle(value);
        ChangeMenuSelected(value.replace(new RegExp(" ", 'g'), ''));
        HideAllPanels(value.replace(new RegExp(" ", 'g'), ''));
        ChangePanel(value.replace(new RegExp(" ", 'g'), ''));
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
  
  
   