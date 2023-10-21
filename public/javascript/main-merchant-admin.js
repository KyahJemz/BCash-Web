import Transactions from './modules/transactions.js';
import Accounts from './modules/accounts.js';
import Orders from './modules/order.js';
import Items from './modules/items.js';
import Alerts from './modules/alerts.js';
import Modals from './modules/modals.js';
import Menu from './modules/menu.js';
import Dropdown from './modules/dropdown.js';
import AjaxRequest from './ajax.js';

import Helper from './helper.js';

////////////////////////////
// VARIABLES
////////////////////////////

const myOrders = new Orders();
const myItems = new Items();
const modals = new Modals();
const menu = new Menu();
const dropdown = new Dropdown();
const helper = new Helper();
const Ajax = new AjaxRequest(BaseURL);

const myTransactions = new Transactions(
  document.getElementById("My-Transactions-Table"),
  document.getElementById("My-Transactions-Query"),
  document.getElementById("My-Transactions-Footer-Query"),
  Ajax,
  helper,
  modals
);

const accounts = new Accounts(
  "merchantStaffs", 
  document.getElementById("staffmanagement-table-header"),
  document.getElementById("staffmanagement-table-body"),
  document.getElementById("staffmanagement-table-query")
  );

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
    onModalCloseButtonClick()
  }
});

////////////////////////////
// INITIALIZATIONS
////////////////////////////

export function makeAlert(type,text){
  const alerts = new Alerts();
  alerts.createAlert(type,text);
}

export function makeNotification(id,title,content){
 // const notification = new Notification();
 // notification.setPopupNotificationInfo(id,title,content);
}

export function makeModal(type, title, content){
  modals.activateModal(type, title, content);
}

function refreshItems(){
  myItems.registerItem()
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
    makeAlert("Invalid Order", "No items selectd to place an order. Please select and try again...");
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

function onTransactionsSearchClick(event) {
  myTransactions.applyTransactionsQueries(event, 'get my transactions');
}

function onTransactionsClearClick(event) {
  myTransactions.clearTransactionsQueries(event);
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
  document.getElementById("Modal-Container").style.display = "none";
}

helper.addElementClickListenerById('Modal-Close-Button', onModalCloseButtonClick);




////////////////////////////
// MENU PRIMARY BUTTONS
////////////////////////////

function onMenuNotificationButtonClick() {
  Ajax.sendRequest([], 'get my notifications')
    .then(responseData => {
      if (responseData.Success) {
        makeModal("Modal", "Notifications", modals.getModalView("Notification Panel",responseData.Parameters));
      }
  })
}

function onMenuSettingsButtonClick() {
  Ajax.sendRequest([], 'get my account')
    .then(responseData => {
      if (responseData.Success) {
        makeModal("Modal", "Personal Settings", modals.getModalView("Settings Panel",responseData.Parameters));
        helper.addElementClickListenerById('btn-submit-account-changes', updateAccount);
      }
  })
  makeModal("Modal", "Personal Settings", modals.getModalView("Settings Panel"));
}

async function updateAccount (event) {
  const parent = event.currentTarget.parentNode.parentNode;

  const Firstname = parent.querySelector('#AccountSettings-Firstname').value;
  const Lastname = parent.querySelector('#AccountSettings-Lastname').value;
  const Email = parent.querySelector('#AccountSettings-Email').value;

  const CurrentPassword = parent.querySelector('#AccountSettings-OldPassword');
  const CurrentPIN = parent.querySelector('#AccountSettings-OldPINCode');

  const data = {
    Firstname : Firstname,
    Lastname : Lastname,
    Email : Email,
    CurrentPassword : CurrentPassword.value,
    CurrentPIN : CurrentPIN.value,
  }

  await Ajax.sendRequest(data, 'update my account')
    .then(responseData => {
      if (responseData.Success) {
      }
  });

  if (parent.querySelector('#AccountSettings-ChangePassword').checked) {
    const NewPassword1 = parent.querySelector('#AccountSettings-NewPassword1').value;
    const NewPassword2 = parent.querySelector('#AccountSettings-NewPassword2').value;

    const data = {
      NewPassword1 : NewPassword1,
      NewPassword2 : NewPassword2,
      CurrentPassword : CurrentPassword.value,
    }
  
    await Ajax.sendRequest(data, 'update my password')
      .then(responseData => {
    });
  }

  if (parent.querySelector('#AccountSettings-ChangePINCode').checked) {
    const NewPINCode1 = parent.querySelector('#AccountSettings-NewPINCode1').value;
    const NewPINCode2 = parent.querySelector('#AccountSettings-NewPINCode2').value;

    const data = {
      NewPINCode1 : NewPINCode1,
      NewPINCode2 : NewPINCode2,
      CurrentPIN : CurrentPIN.value,
    }
  
    await Ajax.sendRequest(data, 'update my pin')
      .then(responseData => {
    });
  }

  CurrentPassword.value = '';
  CurrentPIN.value = '';

  parent.querySelector('#AccountSettings-NewPassword1').value = '';
  parent.querySelector('#AccountSettings-NewPassword2').value = '';
  parent.querySelector('#AccountSettings-NewPINCode1').value = '';
  parent.querySelector('#AccountSettings-NewPINCode2').value = '';
}

helper.addElementClickListenerById('menu-notification-button', onMenuNotificationButtonClick);
helper.addElementClickListenerById('menu-settings-button', onMenuSettingsButtonClick);




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




////////////////////////////
// ACCOUNTS
////////////////////////////

function onMerchantStaffAccountsSearchClick(event) {
  accounts.applyAccountsQuery(event);
}

function onMerchantStaffAccountsClearClick(event) {
  accounts.clearAccountsQuery(event);
}

helper.addElementClickListener('.accounts-search-button', onMerchantStaffAccountsSearchClick);
helper.addElementClickListener('.accounts-clear-button', onMerchantStaffAccountsClearClick);





////////////////////////////
// API
////////////////////////////

helper.addElementClickListenerById('Logout-Button', Logout); 
async function Logout (){
  await Ajax.sendRequest([], "Logout")
    .then(responseData => {
    });
}

GetMyData();
async function GetMyData () {
  await Ajax.sendRequest([], "get my account")
    .then(responseData => {
      if (responseData.Success) {
        const name = (responseData['Parameters']['Account']['Firstname'] + " " + responseData['Parameters']['Account']['Lastname']);
        document.getElementById('WebAccountFullName').innerHTML = name;
      } else {
        setTimeout(() => {
          GetMyData ();
        }, 2000);
      }
  })
    .catch(error => {
      console.error('Request Error:', error);
      setTimeout(() => {
        GetMyData ();
      }, 2000);
  });
}








