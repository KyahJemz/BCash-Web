import Order from './class/class-order.js';
import Item from './class/class-items.js';

import { 
    windowOnclickEvents,
    addToCart, 
    quantity,
    placeOrderEvents, 
    menuSelectionEvents, 
    dropdownEvents, 
    changeSelectionEvents,
    refreshReceipt,
    displayItemsEvents,
    clearOrder,
    openDialogBoxEvents,
    openAlertDialogBoxEvents,
    closeDialogBoxEvents
} from './eventHandlers.js';

var doc = document;

//#####//
// INITIALZASIO MODULE
//#####//

window.onclick = windowOnclickEvents;

const items = [];
items.push(new Item("1","Spicy Chicken Sandwich","120","Food","2023-06-29","2023-06-29", "../images/items/1.png"));
items.push(new Item("2","Beef Stir-fry with Rice","150","Food","2023-06-29","2023-06-29", "../images/items/2.png"));
items.push(new Item("3","Margherita Pizza","180","Pizza","2023-06-29","2023-06-29", "../images/items/3.png"));
items.push(new Item("4","Vegetable Curry with Naan Bread","130","Food","2023-06-29","2023-06-29", "../images/items/4.png"));
items.push(new Item("5","BBQ Pulled Pork Burger","140","Food","2023-06-29","2023-06-29", "../images/items/5.png"));
items.push(new Item("6","Fish Tacos with Salsa","160","Food","2023-06-29","2023-06-29", "../images/items/6.png"));
items.push(new Item("7","Iced Caramel Macchiato","110","Drink","2023-06-29","2023-06-29", "../images/items/7.png"));
items.push(new Item("8","Strawberry Banana Smoothie","90","Drink","2023-06-29","2023-06-29", "../images/items/8.png"));
items.push(new Item("9","Chocolate Chip Ice Cream","70","Disert","2023-06-29","2023-06-29", "../images/items/9.png"));
items.push(new Item("10","Fresh Fruit Salad","100","Disert","2023-06-29","2023-06-29", "../images/items/10.png"));

console.log(items);

//displayItemsEvents(items, "CreateOrder");





document.getElementById("Dialog-Box-Close-Button").addEventListener('click', () => {
  closeDialogBoxEvents();
});

document.getElementById("Dialog-Box-Close-Button").addEventListener('click', () => {
  closeDialogBoxEvents();
});
//#####//
// ORDER MODULE
//#####//


const order = new Order();

openDialogBoxEvents("test");

export function getOrder(){
  if (order.items.length <= 0) {
    return "";
  } else {
    return order;
  }
}

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
      quantity(order, itemId, type);
    });
  });
}

document.getElementById('txt-order-Discount').addEventListener('input', () => {
  refreshReceipt(order)
});

document.getElementById('createorder-clear').addEventListener('click', () => {
  clearOrder(order);
});


document.getElementById('createorder-placeorder').addEventListener('click', () => {
  if (order.items.length > 0) {
    openDialogBoxEvents("Place-Order");
  } else {
    openAlertDialogBoxEvents("Invalid Order", "No items selectd to place an order. Please select and try again...")
  }
});


//#####//
// ITEMS MODULE
//#####//

document.getElementById('createorder-search').addEventListener('input', () => {
  displayItemsEvents(items, order, "CreateOrder");
});

document.getElementById('itemmanagement-search').addEventListener('input', () => {
  displayItemsEvents(items, order, "ItemManagement");
});

export function bindItemsEventButtons() {
  document.querySelectorAll('.addToCartButton').forEach(button => {
    button.addEventListener('click', () => {
        const itemId = button.parentNode.parentNode.dataset.itemId;
        const name = button.parentNode.parentNode.dataset.name;
        const cost = button.parentNode.parentNode.dataset.cost;
        const image = button.parentNode.parentNode.dataset.image;
        addToCart(button, order, itemId, name, cost, image, "1");
    });
  });
}







//#####//
// MENU
//#####//
document.querySelectorAll('.menuSelectionButton').forEach(menuItem => {
    menuItem.addEventListener('click', () => {
      const value = menuItem.querySelector('p').innerText;
      menuSelectionEvents(value, items, order);
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

    const panel = element.parentNode.parentNode.dataset.panel;
    displayItemsEvents(items, order, panel);
  });
});

export function bindDropdownSubItemEventButtons(query) {
  let x = document.getElementById(query).querySelectorAll(".dropdownButtonSubItem").forEach(item => {
    item.addEventListener('click', event => {
      const element = event.currentTarget; 
      changeSelectionEvents(element); 
      
      const panel = element.parentNode.parentNode.dataset.panel;
    displayItemsEvents(items, order, panel);
    });
  });
}












document.getElementById("menu-visibility-button").addEventListener('click', () => {
  console.log("ACTIVATED222 !");
  const sidebar = document.querySelector(".sidebar-container");
  const screenWidth = window.innerWidth;

    if (sidebar.style.minWidth === "0px") {
      sidebar.style.width = "225px";
      sidebar.style.minWidth = "225px";
      document.getElementById("menu-visibility-button").style.transform = "rotate(180deg)";
    } else {
      sidebar.style.width = "0px";
      sidebar.style.minWidth = "0px";
      document.getElementById("menu-visibility-button").style.transform = "rotate(0deg)";
    }
});

