import Transactions from './modules/transactions.js';
import Orders from './modules/order.js';
import Items from './modules/items.js';
import Notifications from './modules/notifications.js';
import Alerts from './modules/alerts.js';
import Modals from './modules/modals.js';
import Menu from './modules/menu.js';
import Dropdown from './modules/dropdown.js';
import Accounts from './modules/accounts.js';
import AjaxRequest from './ajax.js';

import Helper from './helper.js';


////////////////////////////
// VARIABLES
////////////////////////////
const helper = new Helper();
const Ajax = new AjaxRequest(BaseURL);
const modals = new Modals();

const notifications = new Notifications();
const myTransactions = new Transactions(
  document.getElementById("My-Transactions-Table"),
  document.getElementById("My-Transactions-Query"),
  document.getElementById("My-Transactions-Footer-Query"),
  Ajax,
  helper,
  modals
);
const allTransactions = new Transactions(
  document.getElementById("All-Transactions-Table"),
  document.getElementById("All-Transactions-Query"),
  document.getElementById("All-Transactions-Footer-Query"),
  Ajax,
  helper,
  modals
  );
const userAccounts = new Accounts(
  "users",
  document.getElementById("accounts-table-header"),
  document.getElementById("accounts-table-body"),
  document.getElementById("accounts-query")
  );
const myOrders = new Orders();
const myItems = new Items();

const menu = new Menu();
const dropdown = new Dropdown();

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


export function makeAlert(type,text){
  const alerts = new Alerts(document.querySelector(".Alert-Box-Table"));
  alerts.createAlertElement(type,text);
}

export function makeNotification(id,title,content){
 // const notification = new Notification();
 // notification.setPopupNotificationInfo(id,title,content);
}

export function makeModal(type, title, content){
  modals.activateModal(type, title, content);
}



////////////////////////////
// MENU
////////////////////////////

function onMenuSelectionButton(event) {
  menu.menuSelectionEvents(event, null, null);
}

helper.addElementClickListener('.menuSelectionButton', onMenuSelectionButton);



////////////////////////////
// DROPDOWN
////////////////////////////

function onDropdownButtonClick(event) {
  dropdown.dropdownEvents(event);
}

function onDropdownButtonSubItemClick(event) {
  dropdown.changeSelectionEvents(event, null, null);
}

export function bindDropdownSubItemEventButtons() {
  helper.addElementClickListener(".dropdownButtonSubItem", onDropdownButtonSubItemClick);
}

helper.addElementClickListener('.dropdownButton', onDropdownButtonClick);
helper.addElementClickListener('.dropdownButtonSubItem', onDropdownButtonSubItemClick);



////////////////////////////
// TRANSACTIONS
////////////////////////////

async function onTransactionsSearchClick(event) {
	const transactionPanel = event.currentTarget.parentNode.parentNode.dataset.transactiontype;
	if (transactionPanel === "MyTransactions") {
		myTransactions.applyTransactionsQueries(event, "get my transactions");
	} else if (transactionPanel === "AllTransactions") {
		allTransactions.applyTransactionsQueries(event, "get all transactions");
	}
}

async function onTransactionsClearClick(event) {
  const transactionPanel = event.currentTarget.parentNode.parentNode.dataset.transactiontype;
  if (transactionPanel === "MyTransactions") {
    myTransactions.clearTransactionsQueries(event);
  } else if (transactionPanel === "AllTransactions") {
    allTransactions.clearTransactionsQueries(event);
  }
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

async function onMenuNotificationButtonClick() {
  await Ajax.sendRequest([], 'get my notifications')
    .then(responseData => {
      if (responseData.Success) {
        console.log(responseData);
        makeModal("Modal", "Notifications", modals.getModalView("Notification Panel",responseData.Parameters));
      }
  })
    .catch(error => {
      console.error('Request Error:', error);
  });
}

async function onMenuSettingsButtonClick() {
  await Ajax.sendRequest([], 'get my account')
    .then(responseData => {
      if (responseData.Success) {
        console.log(responseData);
        makeModal("Modal", "Personal Settings", modals.getModalView("Settings Panel",responseData.Parameters));
        helper.addElementClickListenerById('btn-submit-account-changes', updateAccount);
      }
  })
    .catch(error => {
      console.error('Request Error:', error);
  });
}

async function updateAccount () {
  
  
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

function onUsersAccountsSearchClick(event) {
  userAccounts.applyAccountsQuery(event);
  console.log("eee");
}

function onUserAccountsClearClick(event) {
  console.log("eee");
  userAccounts.clearAccountsQuery(event);
  
}

helper.addElementClickListener('.accounts-search-button', onUsersAccountsSearchClick);
helper.addElementClickListener('.accounts-clear-button', onUserAccountsClearClick);


////////////////////////////
// API
////////////////////////////
function displayparameters(){
  console.log('------------------------------------------');
  console.log('--AccountAddress--', AccountAddress);
  console.log('--AuthToken--', AuthToken);
  console.log('--ClientVersion--', ClientVersion);
  console.log('--IpAddress--', IpAddress);
  console.log('--Device--', Device);
  console.log('--Location--', Location);
  console.log('--BaseURL--', BaseURL);
  console.log('------------------------------------------');
}


helper.addElementClickListenerById('CashIn-Btn-SearchUser', CashIn_SearchUser);
async function CashIn_SearchUser () {
  const intent = "get user details";
  const data = { 
    AccountAddress : document.getElementById('CashIn-Id').value,
    Amount : document.getElementById('CashIn-Amount').value,
  }; 

  await Ajax.sendRequest(data, intent)
    .then(responseData => {
      if (responseData.Success) {
        document.getElementById('CashIn-UserName').innerHTML = responseData.Parameters.Account.Firstname + ' ' + responseData.Parameters.Account.Lastname;
        document.getElementById('CashIn-UserBalance').innerHTML = responseData.Parameters.Details.Balance;
      } else {
        document.getElementById('CashIn-UserName').innerHTML = '';
        document.getElementById('CashIn-UserBalance').innerHTML = '';
        makeAlert('danger',responseData.Response);
      }
      CashIn_RecentCashIn ();
  })
    .catch(error => {
      console.error('Request Error:', error);
  });
}

helper.addElementClickListenerById('CashIn-Btn-Transfer', CashIn_Transfer);
async function CashIn_Transfer () {
  const intent = "initiate cash in";
  const data = { 
    AccountAddress : document.getElementById('CashIn-Id').value,
    Amount : document.getElementById('CashIn-Amount').value,
  }; 
  
  await Ajax.sendRequest(data, intent)
    .then(responseData => {
      if (responseData.Success) {
        document.getElementById('CashIn-Id').value = '';
        document.getElementById('CashIn-Amount').value = '';
        document.getElementById('CashIn-UserName').innerHTML = '';
        document.getElementById('CashIn-UserBalance').innerHTML = '';
        makeAlert('success',responseData.Response);
      } else {
        document.getElementById('CashIn-UserName').innerHTML = '';
        document.getElementById('CashIn-UserBalance').innerHTML = '';
        makeAlert('danger',responseData.Response);
      }
      CashIn_RecentCashIn ();
  })
    .catch(error => {
      console.error('Request Error:', error);
  });
}

CashIn_RecentCashIn ();
async function CashIn_RecentCashIn () {
  const intent = "get top recent cash in";
  const data = {}; 

  await Ajax.sendRequest(data, intent)
    .then(responseData => {
      if (responseData.Success) {
        let layout = ``;
        responseData.Parameters.forEach(row => {
          layout = layout + `
            <li>
              <img src="" alt="" >
              <div>
                <p class="name">${row['Firstname']} ${row['Lastname']}</p>
                <p class="date">${row['Timestamp']}</p>
              </div>
              <div>
                <p class="amount">₱ ${helper.formatNumber(row['TotalAmount'])}</p>
                <p class="type">Cash-In</p>
              </div>
            </li>
          `;
        });
        document.getElementById('CashIn-Content').innerHTML = layout;
      } else {

      }
  })
    .catch(error => {
      console.error('Request Error:', error);
  });
}





















