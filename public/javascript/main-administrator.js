import Transactions from './modules/transactions.js';
import Cards from './modules/cards.js';
import Alerts from './modules/alerts.js';
import Modals from './modules/modals.js';
import Menu from './modules/menu.js';
import Dropdown from './modules/dropdown.js';
import Accounts from './modules/accounts.js';
import AjaxRequest from './ajax.js';
import LoginHistory from './modules/loginhistory.js'
import { SetAdministratorChart } from './chart.js';
import ActivityHistory from './modules/activityhistory.js';

import Helper from './helper.js';

////////////////////////////
// VARIABLES
////////////////////////////

const helper = new Helper();
const Ajax = new AjaxRequest(BaseURL);
const modals = new Modals();
const menu = new Menu();
const dropdown = new Dropdown();
const loginHistory = new LoginHistory();
const MyActivityHistory = new ActivityHistory('get my activity logs');
const AdministratorsActivityHistory = new ActivityHistory('get all administrartor activity logs');
const AllActivityHistory = new ActivityHistory('get all activity logs');

const cards = new Cards(
  document.getElementById("Cards-Table-Body"),
  document.getElementById("Cards-Query"),
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
    Ajax.sendRequest([], "get chart data")
    .then(responseData => {
      SetAdministratorChart(responseData.Parameters);
    })
  }
  if (event.currentTarget.dataset.menu === "Application Control Management") {
    SetConfiguration();
  }
  if (event.currentTarget.dataset.menu === "Notifications Control Management") {
    SetNotifications();
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
        helper.addElementClickListenerById('btn-login-history',()=>{loginHistory.open()});

        helper.addElementClickListenerById('btn-activity-history',()=>{MyActivityHistory.open()});
        helper.addElementClickListenerById('btn-administrators-activity-history',()=>{AdministratorsActivityHistory.open()});
        helper.addElementClickListenerById('btn-all-activity-history',()=>{AllActivityHistory.open()});
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

const dateInputs = document.querySelectorAll('.inputdate');
const today = new Date().toISOString().slice(0, 10);
dateInputs.forEach(input => {
    input.value = today;
    input.addEventListener('change', (event) => {
        if (!input.value) {
            input.value = today;
        }
    });
});


////////////////////////////
// CARDS
////////////////////////////
function onCardsSearchClick(event) {
  cards.applyCardsQuery(event, 'get cards',addCardAddress);
}

function onCardsClearClick(event) {
  cards.clearCardsQuery(event, addCardAddress);
}

export function addCardAddress(event){
  const CardsAddress = event.currentTarget.parentNode.querySelector('.AddCardAddressForm').value;
  const data = {
    Card_Address : CardsAddress,
  }
  Ajax.sendRequest(data, 'add card')
    .then(responseData => {
      if (responseData.Success) {
        cards.applyCardsQuery(null, 'get cards',addCardAddress);    
        event.currentTarget.parentNode.querySelector('.AddCardAddressForm').value = "";
      }
    })
}

helper.addElementClickListener('.cards-search-button', onCardsSearchClick);
helper.addElementClickListener('.cards-clear-button', onCardsClearClick);

helper.addElementClickListenerByElement(document.querySelectorAll("#Cards-Table-Body .AddCardAddressButton"),addCardAddress);

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
          `<a class="dropdownButtonSubItem" href="javascript:void(0)">${element['ShopName']}</a>`
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
          `<a class="dropdownButtonSubItem" href="javascript:void(0)">${element['Name']}</a>`
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
    document.getElementById('AddAccount-CardAddressContainer').style.display = 'block';
    document.getElementById('AddAccount-SchoolPersonalIdContainer').style.display = 'block';
   
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
        document.getElementById('AddAccount-Firstname').value = "";
        document.getElementById('AddAccount-Lastname').value = "";
        document.getElementById('AddAccount-Email').value = "";
        document.querySelector('#panel-addaccount .addaccount-accountcategory-dropdown').textContent = "";

        document.querySelector('#panel-addaccount .addaccount-merchantcategory-dropdown').textContent = "";
        document.getElementById('AddAccount-Username').value = "";
        document.getElementById('AddAccount-Password').value = "";
        document.getElementById('AddAccount-CardAddress').value = "";
        document.getElementById('AddAccount-SchoolPersonalId').value = "";
        document.getElementById('AddAccount-MerchantCategoryAdd').value = "";
      }
  })
})

export function SetConfiguration() {
  Ajax.sendRequest([], "get configuration")
  .then(responseData => {
    document.getElementById('Config-PinCode').value = "";
    if (responseData.Success) {
      responseData.Parameters.forEach(row => {
        if (row['Title'] === 'AndroidAppVersion' || row['Title'] === 'WebAppVersion') {
          document.getElementById('Config-'+row['Title']).value = (row['Value']) ? row['Value'] : '';
        } else {
          document.getElementById('Config-'+row['Title']).checked = (row['Value'] === '1') ? true : false;
        }
        document.getElementById('Config-'+row['Title']+'Description').value = (row['Description: ']) ? row['Description: '] : '';
      });
    }
  })
}

helper.addElementClickListenerById('Config-Submit',UpdateConfigurations);
export function UpdateConfigurations() {
  const data = {
    PinCode : document.getElementById('Config-PinCode').value,
    IsMaintenance : (document.getElementById('Config-IsMaintenance').checked) ? '1' : '0',
    IsMaintenanceDescription : (document.getElementById('Config-IsMaintenanceDescription').value) ?? '',
    Transactions : (document.getElementById('Config-Transactions').checked) ? '1' : '0',
    TransactionsDescription : (document.getElementById('Config-TransactionsDescription').value) ?? '',
    Transfers : (document.getElementById('Config-Transfers').checked) ? '1' : '0',
    TransfersDescription : (document.getElementById('Config-TransfersDescription').value) ?? '',
    CashIn : (document.getElementById('Config-CashIn').checked) ? '1' : '0',
    CashInDescription : (document.getElementById('Config-CashInDescription').value) ?? '',
    AndroidAppVersion : (document.getElementById('Config-AndroidAppVersion').value) ?? '',
    AndroidAppVersionDescription : (document.getElementById('Config-AndroidAppVersionDescription').value) ?? '',
    WebAppVersion : (document.getElementById('Config-WebAppVersion').value) ?? '',
    WebAppVersionDescription : (document.getElementById('Config-WebAppVersionDescription').value) ?? '',
    Accounting : (document.getElementById('Config-Accounting').checked) ? '1' : '0',
    AccountingDescription : (document.getElementById('Config-AccountingDescription').value) ?? '',
    MerchantAdmin : (document.getElementById('Config-MerchantAdmin').checked) ? '1' : '0',
    MerchantAdminDescription : (document.getElementById('Config-MerchantAdminDescription').value) ?? '',
    MerchantStaff : (document.getElementById('Config-MerchantStaff').checked) ? '1' : '0',
    MerchantStaffDescription : (document.getElementById('Config-MerchantStaffDescription').value) ?? '',
    User : (document.getElementById('Config-User').checked) ? '1' : '0',
    UserDescription : (document.getElementById('Config-UserDescription').value) ?? '',
    Guest : (document.getElementById('Config-Guest').checked) ? '1' : '0',
    GuestDescription : (document.getElementById('Config-GuestDescription').value) ?? '',
    Guardian : (document.getElementById('Config-Guardian').checked) ? '1' : '0',
    GuardianDescription : (document.getElementById('Config-GuardianDescription').value) ?? '',
  };

  Ajax.sendRequest(data, "update configurations")
  .then(responseData => {
    if (responseData.Success) {
      document.getElementById('Config-PinCode').value = "";
    }
    document.getElementById('Config-PinCode').value = "";
    SetConfiguration();
})
}


export function SetNotifications() {
  Ajax.sendRequest([], "get my notifications")
  .then(responseData => {
    if (responseData.Success) {
      const container = document.getElementById('Notifications-Container');
      container.innerHTML = `<div class="notification-text">Notifications</div>`;
      responseData.Parameters.forEach(row => {
        container.innerHTML = container.innerHTML + `
          <div class="notification-item">
            <div class="left-content">
              <p class="notification-subject">${row['Title']}</p>
              <p class="notification-date">${helper.getDate(row['Timestamp'])}</p>
              <p class="notification-content">${row['Content']}</p>
            </div>
            <div class="right-content">
              <button class="notification-delete" data-notification="${row['Notification_ID']}"><img src="${MainURL}public/images/icons/delete-red.png" alt="" srcset=""></button>
            </div>
          </div>
        `;
      });
      helper.addElementClickListener('.notification-item .notification-delete',(event)=>{
          const title = event.currentTarget.parentNode.parentNode.querySelector('.notification-subject').textContent;
          const Notification_ID = event.currentTarget.dataset.notification;
          modals.activateModal('ConfirmModal', 'Delete Confirmation', `Do you want to remove this notification?<br><br>Title : ${title}`, ()=>{DeleteNotification(Notification_ID)});
        }
      );
    }
  })
}

export function DeleteNotification (Notification_ID){
  const data = {
    Notification_ID : Notification_ID,
  };
  Ajax.sendRequest(data, "delete notification")
  .then(responseData => {
    if (responseData.Success) {
      SetNotifications();
    }
  })
}


helper.addElementClickListenerById('Notifications-SubmitBtn',AddNotifications);
export function AddNotifications() {
  const data = {
    Title : document.getElementById('Notifications-Subject').value,
    Content : document.getElementById('Notifications-Content').value
  };
  Ajax.sendRequest(data, "add notification")
  .then(responseData => {
    if (responseData.Success) {
      document.getElementById('Notifications-Subject').value = "";
      document.getElementById('Notifications-Content').value = "";
      SetNotifications();
    }
  })
}





Ajax.sendRequest([], "get chart data")
    .then(responseData => {
      SetAdministratorChart(responseData.Parameters);
    })


    
    