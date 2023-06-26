import { 
    toggleMyOrdersMenu, 
    ChangeTitle, 
    ChangeMenuSelected, 
    HideAllPanels, 
    ChangePanel 
} from './utils/menuUtils';

import { 
    uploadOrderData 
} from './ajaxUtils.js';



export function addToCart(order, itemId, quantity) {
  order.addItem(itemId, quantity);
}

export function placeOrder(order) {
    uploadOrderData();
}




//#####//
// DROPDOWN EVENTS
//#####//

export function menuSelection(selected) {
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
  
  
  
  
  