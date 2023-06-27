import Order from './class/class-order.js';
import { 
    windowOnclickEvents,
    addToCart, 
    placeOrder, 
    menuSelectionEvents, 
    dropdownEvents, 
    changeSelectionEvents
} from './eventHandlers.js';

window.onclick = windowOnclickEvents;

//#####//
// ORDER MODULE
//#####//

const order = new Order();

document.querySelectorAll('.addToCartButton').forEach(button => {
  button.addEventListener('click', () => {
    const itemId = button.parentNode.parentNode.dataset.itemId;
    const quantity = button.dataset.quantity;
    addToCart(order, itemId, quantity);
  });
});

document.querySelectorAll('.addQuantityButton').forEach(button => {
  button.addEventListener('click', () => {
    const itemId = button.parentNode.parentNode.dataset.itemId;
    xxx(order, itemId);
  });
});

document.querySelectorAll('.lessQuantityButton').forEach(button => {
  button.addEventListener('click', () => {
    const itemId = button.parentNode.parentNode.dataset.itemId;
    xxx(order, itemId);
  });
});












document.querySelectorAll('.placeOrderButton').forEach(button => {
  button.addEventListener('click', () => {
    placeOrder(order);
  });
});

//#####//
// MENU
//#####//
document.querySelectorAll('.menuSelectionButton').forEach(menuItem => {
    menuItem.addEventListener('click', () => {
        menuSelectionEvents(menuItem);
    });
});

//#####//
// DROPDOWN
//#####//

document.querySelectorAll('.dropdownButton').forEach(dropdownBtn => {
    dropdownBtn.addEventListener('click', event => {
      const value = event.currentTarget;
      const position = value.dataset.layout;
      dropdownEvents(event, value, position);
    });
  });
  
  document.querySelectorAll('.dropdownButtonSubItem').forEach(item => {
    item.addEventListener('click', event => {
      const element = event.currentTarget;
      changeSelectionEvents(element);
    });
  });

 