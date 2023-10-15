import Transactions from './modules/transactions.js';
import Notifications from './modules/notifications.js';
import Alerts from './modules/alerts.js';
import Modals from './modules/modals.js';
import Menu from './modules/menu.js';
import Dropdown from './modules/dropdown.js';
import Accounts from './modules/accounts.js';
import AjaxRequest from './ajax.js';
import { SetAccountingChart } from './chart.js';

import Helper from './helper.js';


////////////////////////////
// VARIABLES
////////////////////////////

const helper = new Helper();
const Ajax = new AjaxRequest(BaseURL);
const modals = new Modals();

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
  document.getElementById("accounts-table-body"),
  document.getElementById("accounts-query"),
  Ajax,
  helper,
  modals
);

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
    onModalCloseButtonClick();
  }
});

////////////////////////////
// INITIALIZATIONS
////////////////////////////

export function makeAlert(type,text){
  const alerts = new Alerts(document.querySelector(".Alert-Box-Table", ));
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
  if (event.currentTarget.dataset.menu === "Home") {
    Ajax.sendRequest([], "get chart data")
    .then(responseData => {
      SetAccountingChart(responseData.Parameters);
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
  document.getElementById("Modal-Container").style.display = "none";
}

helper.addElementClickListenerById('Modal-Close-Button', onModalCloseButtonClick);


////////////////////////////
// MENU PRIMARY BUTTONS
////////////////////////////

async function onMenuNotificationButtonClick() {
  await Ajax.sendRequest([], 'get my notifications')
    .then(responseData => {
      if (responseData.Success) {
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
        makeModal("Modal", "Personal Settings", modals.getModalView("Settings Panel",responseData.Parameters));
        helper.addElementClickListenerById('btn-submit-account-changes', updateAccount);
      }
  })
    .catch(error => {
      console.error('Request Error:', error);
  });
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

function onUsersAccountsSearchClick(event) {
  userAccounts.applyAccountsQuery(event, 'get user accounts', uploadUserChanges);
}

function onUserAccountsClearClick(event) {
  userAccounts.clearAccountsQuery(event);
}

async function uploadUserChanges(event) {
  console.log('trigger');
  const parent = event.currentTarget.parentNode.parentNode;

  const AccountAddress = parent.querySelector('#AccountDetails-AccountAddress').textContent;
  const Firstname = parent.querySelector('#AccountDetails-Firstname').value;
  const Lastname = parent.querySelector('#AccountDetails-Lastname').value;
  const Email = parent.querySelector('#AccountDetails-Email').value;
  const ShoolPersonalId = parent.querySelector('#AccountDetails-ShoolPersonalId').value; 
  const PINCode = parent.querySelector('#AccountDetails-PINCode'); 

  const IsAccountActive = parent.querySelector('#AccountDetails-IsAccountActive').checked; 
  const CanDoTransactions = parent.querySelector('#AccountDetails-CanDoTransactions').checked; 
  const CanDoTransfers = parent.querySelector('#AccountDetails-CanDoTransfers').checked; 
  const CanModifySettings = parent.querySelector('#AccountDetails-CanModifySettings').checked; 
  const CanUseCard = parent.querySelector('#AccountDetails-CanUseCard').checked; 
  const IsTransactionAutoConfirm = parent.querySelector('#AccountDetails-IsTransactionAutoConfirm').checked; 

  const data = {
    AccountAddress : AccountAddress,
    Firstname : Firstname,
    Lastname : Lastname,
    Email : Email,
    ShoolPersonalId : ShoolPersonalId,
    PINCode : PINCode.value,
    IsAccountActive : (IsAccountActive === true) ? '1' : '0',
    CanDoTransactions : (CanDoTransactions === true) ? '1' : '0',
    CanDoTransfers : (CanDoTransfers === true) ? '1' : '0',
    CanModifySettings : (CanModifySettings === true) ? '1' : '0',
    CanUseCard : (CanUseCard === true) ? '1' : '0',
    IsTransactionAutoConfirm : (IsTransactionAutoConfirm === true) ? '1' : '0'
  }

  await Ajax.sendRequest(data, 'update user details')
    .then(responseData => {
      if (responseData.Success) {
      }
  });
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

Ajax.sendRequest([], "get chart data")
    .then(responseData => {
      SetAccountingChart(responseData.Parameters);
    });


// test();
// async function test () {
//   await Ajax.sendRequest([], "get chart data")
//     .then(responseData => {})
// }





















