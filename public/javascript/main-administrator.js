import Transactions from './modules/transactions.js';
import Alerts from './modules/alerts.js';
import Modals from './modules/modals.js';
import Menu from './modules/menu.js';
import Dropdown from './modules/dropdown.js';
import Accounts from './modules/accounts.js';
import AjaxRequest from './ajax.js';
// import { SetAccountingChart } from './chart.js';

import Helper from './helper.js';

////////////////////////////
// VARIABLES
////////////////////////////

const helper = new Helper();
const Ajax = new AjaxRequest(BaseURL);
const modals = new Modals();
const menu = new Menu();
const dropdown = new Dropdown();

const allTransactions = new Transactions(
  document.getElementById("All-Transactions-Table"),
  document.getElementById("All-Transactions-Query"),
  document.getElementById("All-Transactions-Footer-Query"),
  Ajax,
  helper,
  modals
  );

const guestAccounts = new Accounts(
  "guest-adm",
  document.getElementById("Guest-Accounts-Table-Body"),
  document.getElementById("Guest-Accounts-Query"),
  Ajax,
  helper,
  modals
  );

const userAccounts = new Accounts(
  "user-adm",
  document.getElementById("User-Accounts-Table-Body"),
  document.getElementById("User-Accounts-Query"),
  Ajax,
  helper,
  modals
  );

const merchantAccounts = new Accounts(
  "merchant-adm",
  document.getElementById("Merchant-Accounts-Table-Body"),
  document.getElementById("Merchant-Accounts-Query"),
  Ajax,
  helper,
  modals
  );

const merchantStaffsAccounts = new Accounts(
  "merchantStaff-adm",
  document.getElementById("MerchantStaff-Accounts-Table-Body"),
  document.getElementById("MerchantStaff-Accounts-Query"),
  Ajax,
  helper,
  modals
);

const guardianAccounts = new Accounts(
  "guardian-adm",
  document.getElementById("Guardian-Accounts-Table-Body"),
  document.getElementById("Guardian-Accounts-Query"),
  Ajax,
  helper,
  modals
  );

const accountingAccounts = new Accounts(
  "accounting-adm",
  document.getElementById("Accounting-Accounts-Table-Body"),
  document.getElementById("Accounting-Accounts-Query"),
  Ajax,
  helper,
  modals
  );

const administratorAccounts = new Accounts(
  "administrator-adm",
  document.getElementById("Administrator-Accounts-Table-Body"),
  document.getElementById("Administrator-Accounts-Query"),
  Ajax,
  helper,
  modals
  );

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
  alerts.createAlert(type,text);
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
    // Ajax.sendRequest([], "get chart data")
    // .then(responseData => {
    //   SetAccountingChart(responseData.Parameters);
    // })
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

function onTransactionsSearchClick(event) {
  const transactionPanel = event.currentTarget.parentNode.parentNode.dataset.transactiontype;
  if (transactionPanel === "AllTransactions") {
    allTransactions.applyTransactionsQueries(event, 'get all transactions');
  }
}

function onTransactionsClearClick(event) {
  const transactionPanel = event.currentTarget.parentNode.parentNode.dataset.transactiontype;
  if (transactionPanel === "AllTransactions") {
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

export function setNotificationArray(data){
  notificationArray = data;
}



////////////////////////////
// ACCOUNTS
////////////////////////////

function onUsersAccountsSearchClick(event) {
  const panel = event.currentTarget.parentNode.parentNode.dataset.transactiontype;
  if (panel === 'UserAccounts') {
    userAccounts.applyAccountsQuery(event, 'get user accounts', updateActorAccount);

  } else if (panel === 'GuestAccounts') { 
    guestAccounts.applyAccountsQuery(event, 'get guest accounts', updateActorAccount);

  } else if (panel === 'MerchantAccounts') {
    merchantAccounts.applyAccountsQuery(event, 'get merchant accounts', updateActorAccount);

  } else if (panel === 'MerchantStaffAccounts') {
    merchantStaffsAccounts.applyAccountsQuery(event, 'get merchantstaff accounts', updateActorAccount);

  } else if (panel === 'GuardianAccounts') {
    guardianAccounts.applyAccountsQuery(event, 'get guardian accounts', updateActorAccount);

  } else if (panel === 'AccountingAccounts') {
    accountingAccounts.applyAccountsQuery(event, 'get accounting accounts', updateActorAccount);

  } else if (panel === 'AdministratorAccounts') {
    administratorAccounts.applyAccountsQuery(event, 'get administrator accounts', updateActorAccount);

  } else {
    console.log(panel);
  }
}

export function updateActorAccount() {

}

function onUserAccountsClearClick(event) {
  const panel = event.currentTarget.parentNode.parentNode.dataset.transactiontype;
  if (panel === 'UserAccounts') {
    userAccounts.clearAccountsQuery(event);

  } else if (panel === 'GuestAccounts') { 
    guestAccounts.clearAccountsQuery(event);

  } else if (panel === 'MerchantAccounts') {
    merchantAccounts.clearAccountsQuery(event);

  } else if (panel === 'MerchantStaffAccounts') {
    merchantStaffsAccounts.clearAccountsQuery(event);

  } else if (panel === 'GuardianAccounts') {
    merchantStaffsAccounts.clearAccountsQuery(event);

  } else if (panel === 'AccountingAccounts') {
    accountingAccounts.clearAccountsQuery(event);

  } else if (panel === 'AdministratorAccounts') {
    administratorAccounts.clearAccountsQuery(event);

  } else {
    console.log(panel);
  }
  
  
  
  
  x
  
  
  
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



/// ADD ACCOUNT

// panel-addaccount
GetAccountCategoryList();
GetMerchantCategoryList();

async function GetMerchantCategoryList () {
  await Ajax.sendRequest([], "get merchant category list")
    .then(responseData => {
      if (responseData.Success) {
        responseData.Parameters.forEach(element => {
          document.getElementById('MerchantCategory_Dropdown').innerHTML = document.getElementById('MerchantCategory_Dropdown').innerHTML + 
          `<a class="dropdownButtonSubItem" href="javascript:void(0)">${element['ShopName']}</a`
        });
        helper.addElementClickListener("#MerchantCategory_Dropdown .dropdownButtonSubItem", onDropdownButtonSubItemClick);
        helper.addElementClickListener("#MerchantCategory_Dropdown .dropdownButtonSubItem", addAccountContainerUpdate);

      }
  })
}

async function GetAccountCategoryList () {
  await Ajax.sendRequest([], "get account category list")
    .then(responseData => {
      if (responseData.Success) {
        responseData.Parameters.forEach(element => {
          document.getElementById('ActorCategory_Dropdown').innerHTML = document.getElementById('ActorCategory_Dropdown').innerHTML + 
          `<a class="dropdownButtonSubItem" href="javascript:void(0)">${element['Name']}</a`
        });
        helper.addElementClickListener("#ActorCategory_Dropdown .dropdownButtonSubItem", onDropdownButtonSubItemClick);
        helper.addElementClickListener("#ActorCategory_Dropdown .dropdownButtonSubItem", addAccountContainerUpdate);
    }
  })
}

function addAccountContainerUpdate(){

  const AccountCategory = document.querySelector('#panel-addaccount .addaccount-accountcategory-dropdown').innerHTML;

  document.getElementById('AddAccount-MerchantCategoryAddContainer').style.display = 'none';
  document.getElementById('AddAccount-MerchantCategoryContainer').style.display = 'none';
  document.getElementById('AddAccount-PasswordContainer').style.display = 'none';
  document.getElementById('AddAccount-CardAddressContainer').style.display = 'none';
  document.getElementById('AddAccount-SchoolPersonalIdContainer').style.display = 'none';
  document.getElementById('AddAccount-UsernameContainer').style.display = 'none';

  if (AccountCategory === 'Merchant Admin') {
    document.getElementById('AddAccount-PasswordContainer').style.display = 'block';
    document.getElementById('AddAccount-MerchantCategoryAddContainer').style.display = 'block';
    document.getElementById('AddAccount-UsernameContainer').style.display = 'block';


  } else if (AccountCategory === 'Merchant Staff') {
    document.getElementById('AddAccount-PasswordContainer').style.display = 'block';
    document.getElementById('AddAccount-MerchantCategoryContainer').style.display = 'block';
    document.getElementById('AddAccount-UsernameContainer').style.display = 'block';


  } else if (AccountCategory === 'Accounting' || AccountCategory === 'Administrator') {
    document.getElementById('AddAccount-PasswordContainer').style.display = 'block';
    document.getElementById('AddAccount-UsernameContainer').style.display = 'block';

  } else if (AccountCategory === 'User') {
    document.getElementById('AddAccount-CardAddressContainer').style.display = 'block';
    document.getElementById('AddAccount-SchoolPersonalIdContainer').style.display = 'block';


  } else if (AccountCategory === 'Guest'){
    document.getElementById('AddAccount-PasswordContainer').style.display = 'block';
    document.getElementById('AddAccount-CardAddressContainer').style.display = 'block';

   
  } else if (AccountCategory === 'Guardian') {


  }
}

document.getElementById('AddAccount-SubmitBtn').addEventListener('click', () => {
  const data = {
    Firstname : document.getElementById('AddAccount-Firstname').value,
    Lastname : document.getElementById('AddAccount-Lastname').value,
    Email : document.getElementById('AddAccount-Email').value,
    AccountCategory : document.querySelector('#panel-addaccount .addaccount-accountcategory-dropdown').textContent,

    MerchantCategory :document.querySelector('#panel-addaccount .addaccount-merchantcategory-dropdown').textContent,
    Username : document.getElementById('AddAccount-Username').value,
    Password : document.getElementById('AddAccount-Password').value,
    CardAddress : document.getElementById('AddAccount-CardAddress').value,
    SchoolPersonalId : document.getElementById('AddAccount-SchoolPersonalId').value,
    MerchantCategoryAdd : document.getElementById('AddAccount-MerchantCategoryAdd').value,

  };

  Ajax.sendRequest(data, "add account")
    .then(responseData => {
      if (responseData.Success) {
        
      }
  })
})





 











