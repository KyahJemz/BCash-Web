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
  "merchantStaff", 
  document.getElementById("staffmanagement-table-body"),
  document.getElementById("staffmanagement-table-query"),
  Ajax,
  helper,
  modals
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
  const alerts = new Alerts(document.querySelector(".Alert-Box-Table", ));
  alerts.createAlertElement(type,text);
}

export function makeModal(type, title, content){
  modals.activateModal(type, title, content);
}

function refreshItems(){
  myItems.clearItems();
  Ajax.sendRequest([], "get items")
    .then(responseData => {
      responseData.Parameters.forEach(row => {
        //myItems.registerItem("1","Spicy Chicken Sandwich","120","Food","2023-06-29","2023-06-29", "../public/images/items/1.png");
        myItems.registerItem(row['MerchantItems_Id'],row['Name'],row['Price'],row['ItemCategory'],row['ModifiedTimestamp'],row['CreatedTimestamp'], row['Image']);
      });
    });
}




////////////////////////////
// ORDER
////////////////////////////

function onTxtOrderDiscountInput(){
  myOrders.refreshReceiptValues(myOrders);
}

function onCreateOrderClearClick(){
  myOrders.clearOrder(myOrders)
}

let intervalId;
function startInterval() {
  intervalId = setInterval(() => {
    Ajax.sendRequest([], 'listen order event')
      .then(responseData => {
        if (responseData.Parameters.UsersAccount_Address !== null) {
          document.getElementById('order-userid').value = responseData.Parameters.UsersAccount_Address;
          clearInterval(intervalId);
        }
      });
  }, 1000);
}


function onCreateOrderPlaceOrderClick(){
  if (myOrders.items.length > 0) {
    Ajax.sendRequest([], 'set order event')
    .then(responseData => {
      if (responseData.Success) {
        makeModal("Modal", "Order Confirmation", modals.getModalView("Place-Order",myOrders));
        const qrcode = new QRCode("order-qrcode", {
          text: responseData.Parameters,
          width: 128,
          height: 128
        });
        startInterval();
      }
  })


   
    
    

  } else {
    makeAlert("danger", "No items selectd to place an order. Please select and try again...");
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
  if (event.currentTarget.dataset.menu === "Item Management") {
    refreshItems();
  }
  if (event.currentTarget.dataset.menu === "Create Order") {
    refreshItems();
  }
  if (event.currentTarget.dataset.menu === "Fund Remittance") {
    document.getElementById('FundRemittance-DetailsContainer').innerHTML = "";
    document.getElementById('FundRemittance-Buttons').innerHTML = "";
    document.getElementById('FundRemittance-RecentContainer').innerHTML = "";
    document.getElementById('FundRemittance-TotalOrders').innerHTML = `Total Orders : 0`;
    document.getElementById('FundRemittance-TotalSales').innerHTML = `Total Sales : ₱ 0.00`;
    Ajax.sendRequest([], "get my remittance")
      .then(responseData => {
        fundRemittance(responseData.Parameters);
      })
    

      
  }


  
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
  accounts.applyAccountsQuery(event, 'get staff accounts');
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

helper.addElementClickListenerById('ItemManagement-AddItems', ()=>{
  makeModal("Modal", "Add Item Form", modals.getModalView("Add-Item",AddItem));
  helper.addElementClickListenerById('AddItem-SubmitBtn',AddItem);
  helper.addElementClickListenerById('AddItem-CancelBtn',onModalCloseButtonClick);
})

export function AddItem(){
  const formData = new FormData(document.getElementById('AddItem-Form'));

  const imageInput = document.getElementById('AddItem-Image');
  if (imageInput.files.length > 0) {
    formData.set('file', imageInput.files[0]);
  }

  const data = {
    ItemName : document.getElementById('AddItem-Name').value,
    ItemCost : document.getElementById('AddItem-Cost').value,
    ItemCategory : document.getElementById('AddItem-Category').value,
  }


  Ajax.sendRequest(data, "add item")
    .then(responseData => {
      refreshItems();
  })
}




export function fundRemittance (parameters){
  document.getElementById('FundRemittance-DetailsContainer').innerHTML = "";
  document.getElementById('FundRemittance-Buttons').innerHTML = "";
  document.getElementById('FundRemittance-RecentContainer').innerHTML = "";
  document.getElementById('FundRemittance-TotalOrders').innerHTML = `Total Orders : 0`;
  document.getElementById('FundRemittance-TotalSales').innerHTML = `Total Sales : ₱ 0.00`;
  const FundRemittance = document.getElementById('FundRemittance-RecentContainer');
  FundRemittance.innerHTML = '';
  parameters.forEach(element => {
    FundRemittance.innerHTML = FundRemittance.innerHTML + `
      <div class="table-row RecentRemittanceBtn" data-remittance="${element.Remittance_Id}">
        <div class="c1">${element.Remittance_Id}</div>
        <div class="c2">${helper.getDate(element.DateResponse)}</div>
        <div class="c3 ${element.Status}">${element.Status}</div>
        <div class="c4">${element.Submitted_By}</div>
      </div>
    `;
  });
  
  helper.addElementClickListenerByElement(FundRemittance.querySelectorAll('.RecentRemittanceBtn'),(event)=>{
    const data = {
      Remittance_Id : event.currentTarget.dataset.remittance,
    };
    Ajax.sendRequest(data, "get remittance details")
      .then(responseData => {
        let TotalAmount = 0;
        let TotalOrders = 0;
        const FundRemittanceDetails = document.getElementById('FundRemittance-DetailsContainer');
        FundRemittanceDetails.innerHTML = '';
        responseData.Parameters.RemittanceList.forEach(element => {
          let bottomLayout = '';
          element.Items.forEach(element => {
            bottomLayout = bottomLayout + `
              <div class="bottom">
                <p class="name">${element.ItemName}</p>
                <p class="quantity">x${element.ItemQuantity}</p>
                <p class="price">₱ ${helper.formatNumber(element.ItemAmount * element.ItemQuantity)}</p>
              </div>
            `;
          });
          FundRemittanceDetails.innerHTML = FundRemittanceDetails.innerHTML + `
            <div class="table-row-details">
                <div class="top">
                  <p>Id: ${element.Transaction_Address}</p>
                  <p>Total: ₱ ${helper.formatNumber(element.Credit)}</p>
                </div>
                ${bottomLayout}
            </div>
          `;
          TotalAmount = TotalAmount + Number(element.Credit); // floating number
          TotalOrders = TotalOrders + 1;
        });
        document.getElementById('FundRemittance-TotalOrders').innerHTML = `Total Orders : ${TotalOrders}`;
        document.getElementById('FundRemittance-TotalSales').innerHTML = `Total Sales : ₱ ${helper.formatNumber(TotalAmount)}`;
      });

  })

  Ajax.sendRequest([], "get remaining remittance")
    .then(responseData => {
      let TotalAmount = 0;
        let TotalOrders = 0;
        const FundRemittanceDetails = document.getElementById('FundRemittance-DetailsContainer');
        FundRemittanceDetails.innerHTML = '';
        responseData.Parameters.forEach(element => {
          let bottomLayout = '';
          element.Items.forEach(element => {
            bottomLayout = bottomLayout + `
              <div class="bottom">
                <p class="name">${element.ItemName}</p>
                <p class="quantity">x${element.ItemQuantity}</p>
                <p class="price">₱ ${helper.formatNumber(element.ItemAmount * element.ItemQuantity)}</p>
              </div>
            `;
          });
          FundRemittanceDetails.innerHTML = FundRemittanceDetails.innerHTML + `
            <div class="table-row-details">
                <div class="top">
                  <p>Id: ${element.Transaction_Address}</p>
                  <p>Total: ₱ ${helper.formatNumber(element.Credit)}</p>
                </div>
                ${bottomLayout}
            </div>
          `;
          TotalAmount = TotalAmount + Number(element.Credit); // floating number
          TotalOrders = TotalOrders + 1;
        });
        document.getElementById('FundRemittance-TotalOrders').innerHTML = `Today Orders : ${TotalOrders}`;
        document.getElementById('FundRemittance-TotalSales').innerHTML = `Today Sales : ₱ ${helper.formatNumber(TotalAmount)}`;

        if (FundRemittanceDetails.innerHTML !== '') {
          document.getElementById('FundRemittance-Buttons').innerHTML = `
            <button id="FundRemittance-SubmitBtn">Remit</button>
          `;
          helper.addElementClickListenerById('FundRemittance-SubmitBtn',(event)=>{
            console.log(event.currentTarget);
            Ajax.sendRequest([], "Upload remittance").then(responseData => fundRemittance(responseData.Parameters));
          });
        }
        

       

      })
}


