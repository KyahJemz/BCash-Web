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

    applyAccountsQueries,
    clearAccountsQueries,

    createNotification
    
} from './eventHandlers.js';


////////////////////////////
// VARIABLES
////////////////////////////

window.onclick = windowOnclickEvents;

var items = [];
var notificationArray = [];
const order = new Order();

var doc = document;

export function getOrder(){
  return order;
}

export function getItems(){
  return items;
}

export function getNotificationArray(){
  return notificationArray;
}



////////////////////////////
// EVENT LISTENERS
////////////////////////////

function addElementClickListener(element, callback) {
  const elements = document.querySelectorAll(element);
  if (elements.length > 0) {
    elements.forEach((element) => {
      element.addEventListener('click', callback);
    });
  }
}

function addElementInputistener(element, callback) {
  const elements = document.querySelectorAll(element);
  if (elements.length > 0) {
    elements.forEach((element) => {
      element.addEventListener('intput', callback);
    });
  }
}

function addElementClickListenerById(element, callback) {
  const elements = document.getElementById(element);
  if (elements) {
    elements.addEventListener('click', callback);
  }
}

function addElementInputListenerById(element, callback) {
  const elements = document.getElementById(element);
  if (elements) {
    elements.addEventListener('input', callback);
  }
}



////////////////////////////
// INITIALIZATIONS
////////////////////////////

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




////////////////////////////
// ORDER
////////////////////////////

function onTxtOrderDiscountInput(){
  refreshReceipt(order);
}

function onCreateOrderClearClick(){
  clearOrder(order);
}

function onCreateOrderPlaceOrderClick(){
  if (order.items.length > 0) {
    openDialogBoxEvents("Place-Order");
  } else {
    openAlertDialogBoxEvents("Invalid Order", "No items selectd to place an order. Please select and try again...")
  }
}

function onBindQuantityEventButtonsEvent(event){
  quantity(event, order);
}

export function bindQuantityEventButtons() {
  addElementClickListener('.quantityButton',onBindQuantityEventButtonsEvent);
}

addElementInputListenerById('txt-order-Discount',onTxtOrderDiscountInput);
addElementClickListenerById('createorder-clear',onCreateOrderClearClick);
addElementClickListenerById('createorder-placeorder',onCreateOrderPlaceOrderClick);




//#####//
// ITEMS MODULE
//#####//

function onCreateOrderSearchInput(){
  displayItemsEvents(items, order, "CreateOrder");
}

function onItemManagementSearchInput(){
  displayItemsEvents(items, order, "ItemManagement");
}

function onAddToCartButtonsClick(event){
  addToCart(event, order);
}

function onEditItemButtonClick(event){
  openDialogBoxEvents("Edit-Item",event.currentTarget.parentNode.parentNode.dataset.itemId);
}

function onDeleteItemButtonClick(event){
  openDialogBoxEvents("Delete-Item",event.currentTarget.parentNode.parentNode.dataset.itemId);
}

function onAddItemButtonClick(){
  openDialogBoxEvents("Add-Item");
}

export function bindItemsEventButtons() {
  addElementClickListener('.addToCartButton',onAddToCartButtonsClick);
  addElementClickListener('.editItemButton',onEditItemButtonClick);
  addElementClickListener('.deleteItemButton',onDeleteItemButtonClick);
  addElementClickListener('.addItemButton',onAddItemButtonClick);
}

addElementInputListenerById('createorder-search', onCreateOrderSearchInput);
addElementInputListenerById('itemmanagement-search', onItemManagementSearchInput)



////////////////////////////
// MENU
////////////////////////////

function onMenuSelectionButton(event) {
  menuSelectionEvents(event);
}

addElementClickListener('.menuSelectionButton', onMenuSelectionButton);



////////////////////////////
// DROPDOWN
////////////////////////////

function onDropdownButtonClick(event) {
  dropdownEvents(event);
}

function onDropdownButtonSubItemClick(event) {
  changeSelectionEvents(event);
}

export function bindDropdownSubItemEventButtons() {
  addElementClickListener(".dropdownButtonSubItem", onDropdownButtonSubItemClick);
}

addElementClickListener('.dropdownButton', onDropdownButtonClick);
addElementClickListener('.dropdownButtonSubItem', onDropdownButtonSubItemClick);



////////////////////////////
// TRANSACTIONS
////////////////////////////

function onTransactionsSearchClick() {
  applyTransactionsQueries(this);
}

function onTransactionsClearClick() {
  clearTransactionsQueries(this);
}

function onTransactionsExportClick() {
  //exprtTransactionsQueries(this);
}

addElementClickListener('.transaction-search-button', onTransactionsSearchClick);
addElementClickListener('.transaction-clear-button', onTransactionsClearClick);
addElementClickListener('.transaction-export-button', onTransactionsExportClick);



////////////////////////////
// ACCOUNTS
////////////////////////////

function onAccountsSearchClick() {
  applyAccountsQueries(this);
}

function onAccountsClearClick() {
  clearAccountsQueries(this);
}

function onAccountsExportClick() {
  //exprtAccountsQueries(this);
}

addElementClickListener('.accounts-search-button', onAccountsSearchClick);
addElementClickListener('.accounts-clear-button', onAccountsClearClick);
addElementClickListener('.accounts-export-button', onAccountsExportClick);



////////////////////////////
// DIALOG BOX
////////////////////////////

function onDialogBoxCloseButtonClick() {
  closeDialogBoxEvents();
}

export function bindDialogBoxCloseButton(){
  addElementClickListener('.dialog-box-close-button', onDialogBoxCloseButtonClick);
}

addElementClickListenerById('Dialog-Box-Close-Button', onDialogBoxCloseButtonClick);




////////////////////////////
// MENU PRIMARY BUTTONS
////////////////////////////

function onMenuNotificationButtonClick() {
  openDialogBoxEvents("Notification Panel");
}

function onMenuSettingsButtonClick() {
  openDialogBoxEvents("Settings Panel");
}

addElementClickListenerById('menu-notification-button', onMenuNotificationButtonClick);
addElementClickListenerById('menu-settings-button', onMenuSettingsButtonClick);

openDialogBoxEvents("Settings Panel");



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
      sidebar.style.minWidth = "0px";
      document.getElementById("menu-visibility-button").style.transform = "rotate(0deg)";
    }
});



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

