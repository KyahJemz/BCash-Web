import Order from './class/class-order.js';
import { 
    windowOnclickEvents,
    addToCart, 
    quantity,
    placeOrder, 
    menuSelectionEvents, 
    dropdownEvents, 
    changeSelectionEvents,
    refreshReceipt
} from './eventHandlers.js';

var doc = document;

//#####//
// ORDER MODULE
//#####//



  window.onclick = windowOnclickEvents;

const order = new Order();

document.querySelectorAll('.addToCartButton').forEach(button => {
  button.addEventListener('click', () => {
      const itemId = button.parentNode.parentNode.dataset.itemId;
      const name = button.parentNode.parentNode.dataset.name;
      const cost = button.parentNode.parentNode.dataset.cost;
      const image = button.parentNode.parentNode.dataset.image;
      addToCart(button, order, itemId, name, cost, image, "1");
  });
});

export function bindQuantityEventButtons() {
  document.querySelectorAll('.quantityButton').forEach(button => {
    button.addEventListener('click', () => {
      const type = button.dataset.type;
      const itemId = button.parentNode.parentNode.dataset.itemId;
      quantity(button, order, itemId, type);
    });
  });
}

document.getElementById('txt-order-Discount').addEventListener('input', () => {
  refreshReceipt(order)
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

