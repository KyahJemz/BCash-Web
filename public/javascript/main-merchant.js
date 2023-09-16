import Transactions from './modules/transactions.js';
import Orders from './modules/order.js';
import Items from './modules/items.js';
import Notifications from './modules/notifications.js';
import { createAlert } from './modules/alerts.js';
import Modals from './modules/modals.js';
import Menu from './modules/menu.js';
import Dropdown from './modules/dropdown.js';

import Helper from './helper.js';

////////////////////////////
// VARIABLES
////////////////////////////

const notifications = new Notifications();
const myTransactions = new Transactions(document.getElementById("My-Tansactions-Table"),document.getElementById("My-Tansactions-Query"));
const myOrders = new Orders();
const myItems = new Items();
const modals = new Modals();
const menu = new Menu();
const dropdown = new Dropdown();
const helper = new Helper();

var notificationArray = [];

export function getItemsArray(){
  return myItems.getItemsArray();
}

export function getOrdersArray(){
  return myOrders.getOrdersArray();
}

////////////////////////////
// EVENT LISTENERS
////////////////////////////

window.addEventListener('click', (event) => {
  dropdown.windowClickClearDropdown(event);

  const dialogContainer = document.getElementById('Modal-Container');
  const dialogContent = document.querySelector('.modal-content');
    
  if (event.target === dialogContainer && !dialogContent.contains(event.target)) {
      modals.closeModal();
  }
});

////////////////////////////
// INITIALIZATIONS
////////////////////////////





export function makeNotification(id,title,content){
 // const notification = new Notification();
 // notification.setPopupNotificationInfo(id,title,content);
}

export function makeModal(type, title, content){
  modals.activateModal(type, title, content);
}

myItems.registerItem("1","Spicy Chicken Sandwich","120","Food","2023-06-29","2023-06-29", "../public/images/items/1.png")
myItems.registerItem("2","Beef Stir-fry with Rice","150","Food","2023-06-29","2023-06-29", "../public/images/items/2.png");
myItems.registerItem("3","Margherita Pizza","180","Pizza","2023-06-29","2023-06-29", "../public/images/items/3.png");
myItems.registerItem("4","Vegetable Curry with Naan Bread","130","Food","2023-06-29","2023-06-29", "../public/images/items/4.png");
myItems.registerItem("5","BBQ Pulled Pork Burger","140","Food","2023-06-29","2023-06-29", "../public/images/items/5.png");
myItems.registerItem("6","Fish Tacos with Salsa","160","Food","2023-06-29","2023-06-29", "../public/images/items/6.png");
myItems.registerItem("7","Iced Caramel Macchiato","110","Drink","2023-06-29","2023-06-29", "../public/images/items/7.png");
myItems.registerItem("8","Strawberry Banana Smoothie","90","Drink","2023-06-29","2023-06-29", "../public/images/items/8.png");
myItems.registerItem("9","Chocolate Chip Ice Cream","70","Disert","2023-06-29","2023-06-29", "../public/images/items/9.png");
myItems.registerItem("10","Fresh Fruit Salad","100","Disert","2023-06-29","2023-06-29", "../public/images/items/10.png");

//console.log(myItems.getItemsArray());

//displayItemsEvents(items, "CreateOrder");




////////////////////////////
// ORDER
////////////////////////////

function onTxtOrderDiscountInput(){
  myOrders.refreshReceiptValues(myOrders);
}

function onCreateOrderClearClick(){
  myOrders.clearOrder(myOrders)
}

function onCreateOrderPlaceOrderClick(){
  if (myOrders.items.length > 0) {
    makeModal("Modal", "Order Confirmation", modals.getModalView("Place-Order",myOrders));
   // openDialogBoxEvents("Place-Order");
  } else {
    createAlert("warning", "No items selectd to place an order. Please select and try again...");
  //  openAlertDialogBoxEvents("Invalid Order", "No items selectd to place an order. Please select and try again...")
  }
}

helper.addElementInputListenerById('txt-order-Discount',onTxtOrderDiscountInput);
helper.addElementClickListenerById('createorder-clear',onCreateOrderClearClick);
helper.addElementClickListenerById('createorder-placeorder',onCreateOrderPlaceOrderClick);




//#####//
// ITEMS MODULE
//#####//

function onCreateOrderSearchInput(){
  myItems.displayItems(myItems, myOrders, "CreateOrder");
}

function onItemManagementSearchInput(){
  myItems.displayItems(myItems, myOrders, "ItemManagement");
}

helper.addElementInputListenerById('createorder-search', onCreateOrderSearchInput);
helper.addElementInputListenerById('itemmanagement-search', onItemManagementSearchInput)


////////////////////////////
// MENU
////////////////////////////

function onMenuSelectionButton(event) {
  menu.menuSelectionEvents(event, myItems, myOrders);
}

helper.addElementClickListener('.menuSelectionButton', onMenuSelectionButton);



////////////////////////////
// DROPDOWN
////////////////////////////

function onDropdownButtonClick(event) {
  dropdown.dropdownEvents(event);
}

function onDropdownButtonSubItemClick(event) {
  dropdown.changeSelectionEvents(event, myItems, myOrders);
}

export function bindDropdownSubItemEventButtons() {
  helper.addElementClickListener(".dropdownButtonSubItem", onDropdownButtonSubItemClick);
}

helper.addElementClickListener('.dropdownButton', onDropdownButtonClick);
helper.addElementClickListener('.dropdownButtonSubItem', onDropdownButtonSubItemClick);



////////////////////////////
// TRANSACTIONS
////////////////////////////

function onTransactionsSearchClick() {
  myTransactions.applyTransactionsQueries(this);
}

function onTransactionsClearClick() {
  myTransactions.clearTransactionsQueries(this);
}

function onTransactionsExportClick() {
  //exprtTransactionsQueries(this);
}

helper.addElementClickListener('.transaction-search-button', onTransactionsSearchClick);
helper.addElementClickListener('.transaction-clear-button', onTransactionsClearClick);
helper.addElementClickListener('.transaction-export-button', onTransactionsExportClick);


////////////////////////////
// DIALOG BOX
////////////////////////////

function onModalCloseButtonClick() {
  modals.closeModal();
}

helper.addElementClickListenerById('Modal-Close-Button', onModalCloseButtonClick);




////////////////////////////
// MENU PRIMARY BUTTONS
////////////////////////////

function onMenuNotificationButtonClick() {
  makeModal("Modal", "Notifications", modals.getModalView("Notification Panel"));
}

function onMenuSettingsButtonClick() {
  makeModal("Modal", "Personal Settings", modals.getModalView("Settings Panel"));
}

helper.addElementClickListenerById('menu-notification-button', onMenuNotificationButtonClick);
helper.addElementClickListenerById('menu-settings-button', onMenuSettingsButtonClick);

//makeModal("Modal", "Personal Settings Panel", modals.getModalView("Settings Panel"));



////////////////////////////
// OTHERS
////////////////////////////



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
      sidebar.style.minWidth = "0px";f
      document.getElementById("menu-visibility-button").style.transform = "rotate(0deg)";
    }
});

export function setNotificationArray(data){
  notificationArray = data;
}