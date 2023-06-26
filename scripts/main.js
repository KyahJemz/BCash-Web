import Order from './class/class-order.js';
import { addToCart, placeOrder, menuSelection } from './eventHandlers.js';

//#####//
// ORDER MODULE
//#####//

const order = new Order();

document.querySelectorAll('.addToCartButton').forEach(button => {
  button.addEventListener('click', () => {
    const itemId = button.dataset.itemId;
    const quantity = button.dataset.quantity;
    addToCart(order, itemId, quantity);
  });
});

document.querySelectorAll('.placeOrderButton').forEach(button => {
  button.addEventListener('click', () => {
    placeOrder(order);
  });
});

//#####//
// DROPDOWN MODULE
//#####//
document.querySelectorAll('.menuSelectionButton').forEach(menuItem => {
    menuItem.addEventListener('click', () => {
      menuSelection(menuItem);
    });
  });


