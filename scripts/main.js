import Order from './class/class-order.js';
import Item from './class/class-items.js';
import Notification from './class/class-notification.js';

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
    closeDialogBoxEvents,
    applyTransactionsQueries,
    clearTransactionsQueries,
    createNotification
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

var notificationArray = [];

export function getNotificationArray(){
  return notificationArray;
}

export function setNotificationArray(data){
  notificationArray = data;
}

export function makePopupNotification(id,title,content){
  const notification = new Notification();
  notification.setPopupNotificationInfo(id,title,content);
  
  createNotification(notificationArray,notification);
}

makePopupNotification("23","title daw to","it is a content daw");
makePopupNotification("12322245","title daw to","it is a content daw");

setTimeout(function() {
  makePopupNotification("3333","title daw to","it is a content daw");
}, 1000);


//


//#####//
// ORDER MODULE
//#####//


const order = new Order();

export function getOrder(){
  if (order.items.length <= 0) {
    return "";
  } else {
    return order;
  }
}

export function bindQuantityEventButtons() {
  document.querySelectorAll('.quantityButton').forEach(button => {
    button.addEventListener('click', () => {
      const type = button.dataset.type;
      const itemId = button.parentNode.parentNode.dataset.itemId;
      quantity(order, itemId, type);
    });
  });
}

if (document.getElementById('txt-order-Discount')){
  document.getElementById('txt-order-Discount').addEventListener('input', () => {
    refreshReceipt(order)
  });
}

if(document.getElementById('createorder-clear')) {
  document.getElementById('createorder-clear').addEventListener('click', () => {
    clearOrder(order);
  });
}

if(document.getElementById('createorder-placeorder')){
  document.getElementById('createorder-placeorder').addEventListener('click', () => {
    if (order.items.length > 0) {
      openDialogBoxEvents("Place-Order");
    } else {
      openAlertDialogBoxEvents("Invalid Order", "No items selectd to place an order. Please select and try again...")
    }
  });
}



//#####//
// ITEMS MODULE
//#####//

if (document.getElementById('createorder-search')){
  document.getElementById('createorder-search').addEventListener('input', () => {
    displayItemsEvents(items, order, "CreateOrder");
  });
  
}

if (document.getElementById('itemmanagement-search')){
  document.getElementById('itemmanagement-search').addEventListener('input', () => {
    displayItemsEvents(items, order, "ItemManagement");
  });
}


export function bindItemsEventButtons() {
  const addToCartButtons = document.querySelectorAll('.addToCartButton');
  if (addToCartButtons.length > 0) {
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

  const editItemButtons = document.querySelectorAll('.editItemButton');
  if (editItemButtons.length > 0){
    document.querySelectorAll('.editItemButton').forEach(button => {
      button.addEventListener('click', () => {
        const itemId = button.parentNode.parentNode.dataset.itemId; 
        openDialogBoxEvents("Edit-Item",itemId);
      });
    });
  }

  const deleteItemButtons = document.querySelectorAll('.deleteItemButton');
  if (deleteItemButtons.length > 0){
    document.querySelectorAll('.deleteItemButton').forEach(button => {
      button.addEventListener('click', () => {
        const itemId = button.parentNode.parentNode.dataset.itemId; 
        openDialogBoxEvents("Delete-Item",itemId);
      });
    });
  }

  const addItemButtons = document.querySelectorAll('.addItemButton');
  if (addItemButtons.length > 0){
    document.querySelectorAll('.addItemButton').forEach(button => {
      button.addEventListener('click', () => {
        openDialogBoxEvents("Add-Item");
      });
    });
  }
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





// TRANSACTIONS

document.getElementById("transaction-search-button").addEventListener('click', () => {
  applyTransactionsQueries();
});


document.getElementById("transaction-clear-button").addEventListener('click', () => {
  clearTransactionsQueries();
});


document.getElementById("transaction-export-button").addEventListener('click', () => {
  exportTransactions();
});




document.getElementById("Dialog-Box-Close-Button").addEventListener('click', () => {
  closeDialogBoxEvents();
});

export function bindDialogBoxCloseButton(){
  document.querySelector(".dialog-box-close-button").addEventListener('click', () => {
    closeDialogBoxEvents();
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

openDialogBoxEvents("Settings Panel");

document.getElementById("menu-notification-button").addEventListener('click', () => {
  openDialogBoxEvents("Notification Panel");
});

document.getElementById("menu-settings-button").addEventListener('click', () => {
  openDialogBoxEvents("Settings Panel");
});