import AjaxRequest from '../ajax.js';
import { makeModal } from './modals.js';
import Helper from '../helper.js';

export default class Accounts {
  constructor(type, tableBody, queryContainer, Ajax, Helper, Modals) {
    this.Ajax = Ajax;
    this.Helper = Helper;
    this.Modals = Modals;
    this.type = type;
    this.tableBody = tableBody;
    this.queryContainer = queryContainer;
  }

  getTableBodyView(){
    let view = '';
    let num = 0;

    if (this.type === "merchantStaff") {
      const NameUsernameEmail = this.queryContainer.querySelector(".NameUsernameEmail").value;
      const Status = this.queryContainer.querySelector(".accounts-status-dropdown").textContent;

      const data = {
        NameUsernameEmail : NameUsernameEmail,
        Status : Status,
      }
      this.Ajax.sendRequest(data, this.intent)
        .then(responseData => {
          responseData.Parameters.forEach(element => {
            const status = (element['IsAccountActive'] === '1') ? 'Active' : 'Inactive' ;
            num++,
            view = view + `
              <tr data-type="MTS-MTA" class="table-row StaffAccounts curson-pointer" data-userid="`+ element['WebAccounts_Address'] +`">
                <td class="col1">
                  <div class="cell">
                    <div><p>`+ num +`</p></div>
                    <div><p class="`+ status.replace(new RegExp(" ", 'g'), '').toLowerCase() +`">`+status +`</p></div>
                    <div><p class='account-viewdata-button'>`+ element['WebAccounts_Address'] +`</p></div>
                    <div><p>`+ element['Username'] +`</p> </div>
                    <div><p>`+ element['Firstname'] +`</p></div>
                    <div><p>`+ element['Lastname'] +`</p></div>
                  </div>
                </td>
              </tr>
            `;
          });
          this.tableBody.innerHTML = view;
          const StaffAccounts = this.tableBody.querySelectorAll(".StaffAccounts");
          this.Helper.addElementClickListenerByElement(StaffAccounts,this.openDialogBox);
        })
    }
    
    if (this.type === "administrator-adm") {
      const AccountAddress = this.queryContainer.querySelector(".accounts-address").value;
      const Name = this.queryContainer.querySelector(".accounts-name").value;
      const Email = this.queryContainer.querySelector(".accounts-email").value;
      const Status = this.queryContainer.querySelector(".accounts-status-dropdown").textContent;

      const data = {
        AccountAddress : AccountAddress,
        Name : Name,
        Email : Email,
        Status : Status
      }
      this.Ajax.sendRequest(data, this.intent)
        .then(responseData => {
          if (responseData.Success) {
            this.data = responseData.Parameters;
            this.data.forEach(record => {
              Object.keys(record).forEach(key => {
                if (record[key] === null || record[key] === "") {
                    record[key] = "?";
                }
              });
              const status = (record['IsAccountActive'] === '1') ? 'Active' : 'Inactive' ;
              num++,
              view = view + `
                <tr>
                  <td><div class="col1 cell" title="`+num+`"><center>`+num+`</center></div></td>
                  <td><div class="col2 cell ADM_AccountAddress" data-type="ADM-ADM" title="`+record["WebAccounts_Address"]+`"><a class="account-viewdata-button view-more">`+record["WebAccounts_Address"]+`</a></div></td>
                  <td><div class="col3 cell `+ status.replace(new RegExp(" ", 'g'), '').toLowerCase() +`" title="`+status+`">`+status+`</div></td>
                  <td><div class="col4 cell" title="`+(record["ActorCategory"])+`">`+(record["ActorCategory"])+`</div></td>
                  <td><div class="col5 cell" title="`+(record["Firstname"])+`">`+(record["Firstname"])+`</div></td>
                  <td><div class="col6 cell" title="`+(record["Lastname"])+`">`+(record["Lastname"])+`</div></td>
                  <td><div class="col7 cell" title="`+(record["Email"])+`">`+(record["Email"])+`</div></td>
                  <td><div class="col8 cell" title="`+(record["Campus"])+`">`+(record["Campus"])+`</div></td>
                  <td><div class="col9 cell" title="`+(record["DateRegistered"])+`">`+(record["DateRegistered"])+`</div></td>
                </tr>
              `;
            }); 
            this.tableBody.innerHTML = view;
            const AccountAddress = this.tableBody.querySelectorAll(".ADM_AccountAddress");
            this.Helper.addElementClickListenerByElement(AccountAddress,this.openDialogBox);
          }
      })
      .catch(error => {
        this.tableBody.innerHTML =  view;
      });


    } 

    if ( this.type === "accounting-adm") {
      const AccountAddress = this.queryContainer.querySelector(".accounts-address").value;
      const Name = this.queryContainer.querySelector(".accounts-name").value;
      const Email = this.queryContainer.querySelector(".accounts-email").value;
      const Status = this.queryContainer.querySelector(".accounts-status-dropdown").textContent;

      const data = {
        AccountAddress : AccountAddress,
        Name : Name,
        Email : Email,
        Status : Status
      }
      this.Ajax.sendRequest(data, this.intent)
        .then(responseData => {
          if (responseData.Success) {
            this.data = responseData.Parameters;
            this.data.forEach(record => {
              Object.keys(record).forEach(key => {
                if (record[key] === null || record[key] === "") {
                    record[key] = "?";
                }
              });
              const status = (record['IsAccountActive'] === '1') ? 'Active' : 'Inactive' ;
              num++,
              view = view + `
                <tr>
                  <td><div class="col1 cell" title="`+num+`"><center>`+num+`</center></div></td>
                  <td><div class="col2 cell ACT_AccountAddress" data-type="ACT-ADM" title="`+record["WebAccounts_Address"]+`"><a class="account-viewdata-button view-more">`+record["WebAccounts_Address"]+`</a></div></td>
                  <td><div class="col3 cell `+ status.replace(new RegExp(" ", 'g'), '').toLowerCase() +`" title="`+status+`">`+status+`</div></td>
                  <td><div class="col4 cell" title="`+(record["ActorCategory"])+`">`+(record["ActorCategory"])+`</div></td>
                  <td><div class="col5 cell" title="`+(record["Firstname"])+`">`+(record["Firstname"])+`</div></td>
                  <td><div class="col6 cell" title="`+(record["Lastname"])+`">`+(record["Lastname"])+`</div></td>
                  <td><div class="col7 cell" title="`+(record["Email"])+`">`+(record["Email"])+`</div></td>
                  <td><div class="col8 cell" title="`+(record["Campus"])+`">`+(record["Campus"])+`</div></td>
                  <td><div class="col9 cell" title="`+(record["DateRegistered"])+`">`+(record["DateRegistered"])+`</div></td>
                </tr>
              `;
            }); 
            this.tableBody.innerHTML = view;
            const AccountAddress = this.tableBody.querySelectorAll(".ACT_AccountAddress");
            this.Helper.addElementClickListenerByElement(AccountAddress,this.openDialogBox);
          }
      })
      .catch(error => {
        this.tableBody.innerHTML =  view;
      });


    } 

    if (this.type === 'merchant-adm') {
      const AccountAddress = this.queryContainer.querySelector(".accounts-address").value;
      const Name = this.queryContainer.querySelector(".accounts-name").value;
      const Email = this.queryContainer.querySelector(".accounts-email").value;
      const MerchantCategory = this.queryContainer.querySelector(".accounts-merchantcategory").value;
      const Status = this.queryContainer.querySelector(".accounts-status-dropdown").textContent;

      const data = {
        AccountAddress : AccountAddress,
        MerchantCategory : MerchantCategory,
        Name : Name,
        Email : Email,
        Status : Status
      }
      this.Ajax.sendRequest(data, this.intent)
        .then(responseData => {
          if (responseData.Success) {
            this.data = responseData.Parameters;
            this.data.forEach(record => {
              Object.keys(record).forEach(key => {
                if (record[key] === null || record[key] === "") {
                    record[key] = "?";
                }
              });
              const status = (record['IsAccountActive'] === '1') ? 'Active' : 'Inactive' ;
              num++,
              view = view + `
                <tr>
                  <td><div class="col1 cell" title="`+num+`"><center>`+num+`</center></div></td>
                  <td><div class="col2 cell MTA_AccountAddress" data-type="MTA-ADM" title="`+record["WebAccounts_Address"]+`"><a class="account-viewdata-button view-more">`+record["WebAccounts_Address"]+`</a></div></td>
                  <td><div class="col3 cell `+ status.replace(new RegExp(" ", 'g'), '').toLowerCase() +`" title="`+status+`">`+status+`</div></td>
                  <td><div class="col4 cell" title="`+(record["ActorCategory"])+`">`+(record["ActorCategory"])+`</div></td>
                  <td><div class="col5 cell" title="`+(record["Firstname"])+`">`+(record["Firstname"])+`</div></td>
                  <td><div class="col6 cell" title="`+(record["Lastname"])+`">`+(record["Lastname"])+`</div></td>
                  <td><div class="col7 cell" title="`+(record["Email"])+`">`+(record["Email"])+`</div></td>
                  <td><div class="col8 cell" title="`+(record["ShopName"])+`">`+(record["ShopName"])+`</div></td>
                  <td><div class="col9 cell" title="`+(record["Campus"])+`">`+(record["Campus"])+`</div></td>
                  <td><div class="col10 cell" title="`+(record["DateRegistered"])+`">`+(record["DateRegistered"])+`</div></td>
                </tr>
              `;
            }); 
            this.tableBody.innerHTML = view;
            const AccountAddress = this.tableBody.querySelectorAll(".MTA_AccountAddress");
            this.Helper.addElementClickListenerByElement(AccountAddress,this.openDialogBox);
          }
      })
      .catch(error => {
        this.tableBody.innerHTML = view;
      });
    }

    if (this.type === 'merchantStaff-adm') {
      const AccountAddress = this.queryContainer.querySelector(".accounts-address").value;
      const Name = this.queryContainer.querySelector(".accounts-name").value;
      const Email = this.queryContainer.querySelector(".accounts-email").value;
      const MerchantCategory = this.queryContainer.querySelector(".accounts-merchantcategory").value;
      const Status = this.queryContainer.querySelector(".accounts-status-dropdown").textContent;

      const data = {
        AccountAddress : AccountAddress,
        MerchantCategory : MerchantCategory,
        Name : Name,
        Email : Email,
        Status : Status
      }
      this.Ajax.sendRequest(data, this.intent)
        .then(responseData => {
          if (responseData.Success) {
            this.data = responseData.Parameters;
            this.data.forEach(record => {
              Object.keys(record).forEach(key => {
                if (record[key] === null || record[key] === "") {
                    record[key] = "?";
                }
              });
              const status = (record['IsAccountActive'] === '1') ? 'Active' : 'Inactive' ;
              num++,
              view = view + `
                <tr>
                  <td><div class="col1 cell" title="`+num+`"><center>`+num+`</center></div></td>
                  <td><div class="col2 cell MTS_AccountAddress" data-type="MTS-ADM" title="`+record["WebAccounts_Address"]+`"><a class="account-viewdata-button view-more">`+record["WebAccounts_Address"]+`</a></div></td>
                  <td><div class="col3 cell `+ status.replace(new RegExp(" ", 'g'), '').toLowerCase() +`" title="`+status+`">`+status+`</div></td>
                  <td><div class="col4 cell" title="`+(record["ActorCategory"])+`">`+(record["ActorCategory"])+`</div></td>
                  <td><div class="col5 cell" title="`+(record["Firstname"])+`">`+(record["Firstname"])+`</div></td>
                  <td><div class="col6 cell" title="`+(record["Lastname"])+`">`+(record["Lastname"])+`</div></td>
                  <td><div class="col7 cell" title="`+(record["Email"])+`">`+(record["Email"])+`</div></td>
                  <td><div class="col8 cell" title="`+(record["ShopName"])+`">`+(record["ShopName"])+`</div></td>
                  <td><div class="col9 cell" title="`+(record["Campus"])+`">`+(record["Campus"])+`</div></td>
                  <td><div class="col10 cell" title="`+(record["DateRegistered"])+`">`+(record["DateRegistered"])+`</div></td>
                </tr>
              `;
            }); 
            this.tableBody.innerHTML = view;
            const AccountAddress = this.tableBody.querySelectorAll(".MTS_AccountAddress");
            this.Helper.addElementClickListenerByElement(AccountAddress,this.openDialogBox);
          }
      })
      .catch(error => {
        this.tableBody.innerHTML = view;
      });
    }

    if (this.type === 'guardian-adm') {
      const AccountAddress = this.queryContainer.querySelector(".accounts-address").value;
      const Name = this.queryContainer.querySelector(".accounts-name").value;
      const Email = this.queryContainer.querySelector(".accounts-email").value;
      const Status = this.queryContainer.querySelector(".accounts-status-dropdown").textContent;

      const data = {
        AccountAddress : AccountAddress,
        Name : Name,
        Email : Email,
        Status : Status
      }
      this.Ajax.sendRequest(data, this.intent)
        .then(responseData => {
          if (responseData.Success) {
            this.data = responseData.Parameters;
            this.data.forEach(record => {
              Object.keys(record).forEach(key => {
                if (record[key] === null || record[key] === "") {
                    record[key] = "?";
                }
              });
              const status = (record['IsAccountActive'] === '1') ? 'Active' : 'Inactive' ;
              num++,
              view = view + `
                <tr>
                  <td><div class="col1 cell" title="`+num+`"><center>`+num+`</center></div></td>
                  <td><div class="col2 cell GDN_AccountAddress" data-type="GDN-ADM" title="`+record["GuardianAccount_Address"]+`"><a class="account-viewdata-button view-more">`+record["GuardianAccount_Address"]+`</a></div></td>
                  <td><div class="col3 cell `+ status.replace(new RegExp(" ", 'g'), '').toLowerCase() +`" title="`+status+`">`+status+`</div></td>
                  <td><div class="col4 cell" title="`+(record["ActorCategory"])+`">`+(record["ActorCategory"])+`</div></td>
                  <td><div class="col5 cell" title="`+(record["Firstname"])+`">`+(record["Firstname"])+`</div></td>
                  <td><div class="col6 cell" title="`+(record["Lastname"])+`">`+(record["Lastname"])+`</div></td>
                  <td><div class="col7 cell" title="`+(record["Email"])+`">`+(record["Email"])+`</div></td>
                  <td><div class="col8 cell" title="`+(record["Campus"])+`">`+(record["Campus"])+`</div></td>
                  <td><div class="col9 cell" title="`+(record["DateRegistered"])+`">`+(record["DateRegistered"])+`</div></td>
                </tr>
              `;
            }); 
            this.tableBody.innerHTML = view;
            const AccountAddress = this.tableBody.querySelectorAll(".GDN_AccountAddress");
            this.Helper.addElementClickListenerByElement(AccountAddress,this.openDialogBox);
          }
      })
      .catch(error => {
        this.tableBody.innerHTML =  view;
      });
    }

    if (this.type === "user-adm") {
      const AccountAddress = this.queryContainer.querySelector(".accounts-address").value;
      const SchoolPersonalId = this.queryContainer.querySelector(".accounts-schoolpersonalid").value;
      const Name = this.queryContainer.querySelector(".accounts-name").value;
      const Email = this.queryContainer.querySelector(".accounts-email").value;
      const Status = this.queryContainer.querySelector(".accounts-status-dropdown").textContent;

      const data = {
        AccountAddress : AccountAddress,
        SchoolPersonalId : SchoolPersonalId,
        Name : Name,
        Email : Email,
        Status : Status
      }
      this.Ajax.sendRequest(data, this.intent)
        .then(responseData => {
          if (responseData.Success) {
            this.data = responseData.Parameters;
            this.data.forEach(record => {
              Object.keys(record).forEach(key => {
                if (record[key] === null || record[key] === "") {
                    record[key] = "?";
                }
              });
              const status = (record['IsAccountActive'] === '1') ? 'Active' : 'Inactive' ;
              num++,
              view = view + `
                <tr>
                  <td><div class="col1 cell" title="`+num+`"><center>`+num+`</center></div></td>
                  <td><div class="col2 cell USR_AccountAddress" data-type="USR-ADM" title="`+record["UsersAccount_Address"]+`"><a class="account-viewdata-button view-more">`+record["UsersAccount_Address"]+`</a></div></td>
                  <td><div class="col3 cell `+ status.replace(new RegExp(" ", 'g'), '').toLowerCase() +`" title="`+status+`">`+status+`</div></td>
                  <td><div class="col4 cell" title="`+(record["ActorCategory"])+`">`+(record["ActorCategory"])+`</div></td>
                  <td><div class="col5 cell" title="`+(record["Firstname"])+`">`+(record["Firstname"])+`</div></td>
                  <td><div class="col6 cell" title="`+(record["Lastname"])+`">`+(record["Lastname"])+`</div></td>
                  <td><div class="col7 cell" title="`+(record["Email"])+`">`+(record["Email"])+`</div></td>
                  <td><div class="col8 cell" title="`+(record["SchoolPersonalId"])+`">`+(record["SchoolPersonalId"])+`</div></td>
                  <td><div class="col9 cell" title="`+(record["Campus"])+`">`+(record["Campus"])+`</div></td>
                  <td><div class="col10 cell" title="`+(record["DateRegistered"])+`">`+(record["DateRegistered"])+`</div></td>
                </tr>
              `;
            }); 
            this.tableBody.innerHTML = view;
            const AccountAddress = this.tableBody.querySelectorAll(".USR_AccountAddress");
            this.Helper.addElementClickListenerByElement(AccountAddress,this.openDialogBox);
          }
        })
    }


    if (this.type === "user") {
      const AccountAddress = this.queryContainer.querySelector(".accounts-address").value;
      const SchoolPersonalId = this.queryContainer.querySelector(".accounts-schoolpersonalid").value;
      const Name = this.queryContainer.querySelector(".accounts-name").value;
      const Email = this.queryContainer.querySelector(".accounts-email").value;
      const Status = this.queryContainer.querySelector(".accounts-status-dropdown").textContent;

      const data = {
        AccountAddress : AccountAddress,
        SchoolPersonalId : SchoolPersonalId,
        Name : Name,
        Email : Email,
        Status : Status
      }
      this.Ajax.sendRequest(data, this.intent)
        .then(responseData => {
          if (responseData.Success) {
            this.data = responseData.Parameters;
            this.data.forEach(record => {
              Object.keys(record).forEach(key => {
                if (record[key] === null || record[key] === "") {
                    record[key] = "?";
                }
              });
              const status = (record['IsAccountActive'] === '1') ? 'Active' : 'Inactive' ;
              num++,
              view = view + `
                <tr>
                  <td><div class="col1 cell" title="`+num+`"><center>`+num+`</center></div></td>
                  <td><div class="col2 cell USR_AccountAddress" data-type="USR-ACT" title="`+record["UsersAccount_Address"]+`"><a class="account-viewdata-button view-more">`+record["UsersAccount_Address"]+`</a></div></td>
                  <td><div class="col3 cell `+ status.replace(new RegExp(" ", 'g'), '').toLowerCase() +`" title="`+status+`">`+status+`</div></td>
                  <td><div class="col4 cell" title="`+(record["ActorCategory"])+`">`+(record["ActorCategory"])+`</div></td>
                  <td><div class="col5 cell" title="`+(record["Firstname"])+`">`+(record["Firstname"])+`</div></td>
                  <td><div class="col6 cell" title="`+(record["Lastname"])+`">`+(record["Lastname"])+`</div></td>
                  <td><div class="col7 cell" title="`+(record["Email"])+`">`+(record["Email"])+`</div></td>
                  <td><div class="col8 cell" title="`+(record["SchoolPersonalId"])+`">`+(record["SchoolPersonalId"])+`</div></td>
                  <td><div class="col9 cell" title="`+(record["Campus"])+`">`+(record["Campus"])+`</div></td>
                  <td><div class="col10 cell" title="`+(record["DateRegistered"])+`">`+(record["DateRegistered"])+`</div></td>
                </tr>
              `;
            }); 
            this.tableBody.innerHTML = view;
            const AccountAddress = this.tableBody.querySelectorAll(".USR_AccountAddress");
            this.Helper.addElementClickListenerByElement(AccountAddress,this.openDialogBox);
          }
      })
    }
  }

  openDialogBox(event) {
    const AccountAddress = event.currentTarget.querySelector('.account-viewdata-button').textContent;
    const Type = event.currentTarget.dataset.type;

    if (Type === 'USR-ACT') {
      const data = {
        AccountAddress : AccountAddress,
        SchoolPersonalId : null,
        Name : null,
        Email : null,
        Status : 'All'
      }
      const Ajax = new AjaxRequest(BaseURL);
      Ajax.sendRequest(data, 'get user accounts')
        .then(responseData => {
          if (responseData.Success) {
            const data = responseData.Parameters[0];
            const layout = `
              <div class="personal-information-container">
  
                  <br>
                  <p class="title center-text">Account Details</p>
                  <p id="AccountDetails-AccountAddress" class="subtitle">${(data['UsersAccount_Address'])}</p>
                  <br>
  
                  <fieldset class="PersonalDetailsSettings">
                    <legend><p>Account Details</p></legend>
                    <table>
                      <tr>
                        <td>
                          <p>Firstname:</p>
                          <input id="AccountDetails-Firstname" type="text" value="${(data['Firstname']) ? data['Firstname'] : ''}">
                        </td>
                        <td>
                          <p>Lastname:</p>
                          <input id="AccountDetails-Lastname" type="text" value="${(data['Lastname']) ? data['Lastname'] : ''}">
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <p>Email:</p>
                          <input id="AccountDetails-Email" type="text" value="${(data['Email']) ? data['Email'] : ''}">
                        </td>
                        <td>
                          <p>School Personal Id</p>
                          <input id="AccountDetails-SchoolPersonalId" type="text" value="${(data['SchoolPersonalId']) ? data['SchoolPersonalId'] : ''}">
                        </td>
                      </tr>
                    </table>
                    
                  </fieldset>
  
                  <fieldset class="AccountDetailsSettings">
                      <legend><p>Account Settings</p></legend>
                      <table>
                        <tr>
                          <td colspan="2">
                              <p class="warning center-text">Warning, High level user settings.</p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Is Account Active:</p>
                          </td>
                          <td>
                            <label class="switch">
                              <input id="AccountDetails-IsAccountActive" type="checkbox" ${(data['IsAccountActive'] === '1') ? 'checked' : ''}>
                              <span class="slider round"></span>
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Can Do Transactions:</p>
                          </td>
                          <td>
                            <label class="switch">
                              <input id="AccountDetails-CanDoTransactions" type="checkbox" ${(data['CanDoTransactions'] === '1') ? 'checked' : ''}>
                              <span class="slider round"></span>
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Can Do Transfers:</p>
                          </td>
                          <td>
                            <label class="switch">
                              <input id="AccountDetails-CanDoTransfers" type="checkbox" ${(data['CanDoTransfers'] === '1') ? 'checked' : ''}>
                              <span class="slider round"></span>
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Can Modify Settings:</p>
                          </td>
                          <td>
                            <label class="switch">
                              <input id="AccountDetails-CanModifySettings" type="checkbox" ${(data['CanModifySettings'] === '1') ? 'checked' : ''}>
                              <span class="slider round"></span>
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Can Use ID Card:</p>
                          </td>
                          <td>
                            <label class="switch">
                              <input id="AccountDetails-CanUseCard" type="checkbox" ${(data['CanUseCard'] === '1') ? 'checked' : ''}>
                              <span class="slider round"></span>
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Is Transaction Auto Confirm:</p>
                          </td>
                          <td>
                            <label class="switch">
                              <input id="AccountDetails-IsTransactionAutoConfirm" type="checkbox" ${(data['IsTransactionAutoConfirm'] === '1') ? 'checked' : ''}>
                              <span class="slider round"></span>
                            </label>
                          </td>
                        </tr>
                      </table>
                  </fieldset>
                  <fieldset class="ConfirmChanges">
                      <legend><p>Confirmation</p></legend>
                      <table>
                        <tr>
                          <td colspan="2">
                            <p class="center-text warning">Required to apply changes.</p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Your PIN Code:</p>
                          </td>
                          <td>
                            <input id="AccountDetails-PINCode" type="password" name="AccountDetails-PINCode" placeholder="******">
                          </td>
                        </tr>
                      </table>
                  </fieldset>
                  <div class="buttons-container">
                      <button id="btn-submit-account-details-changes" class="btn-submit ">Upload Changes</button>
                  </div>
              </div>
            `;
            makeModal('Modal', 'Account Details Settings', layout);
  
            const element = document.getElementById("btn-submit-account-details-changes");
            
            element.addEventListener('click', (event) => {
              const parent = event.currentTarget.parentNode.parentNode;
            
              const AccountAddress = parent.querySelector('#AccountDetails-AccountAddress').textContent;
              const Firstname = parent.querySelector('#AccountDetails-Firstname').value;
              const Lastname = parent.querySelector('#AccountDetails-Lastname').value;
              const Email = parent.querySelector('#AccountDetails-Email').value;
              const SchoolPersonalId = parent.querySelector('#AccountDetails-SchoolPersonalId').value; 
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
                SchoolPersonalId : SchoolPersonalId,
                PINCode : PINCode.value,
                IsAccountActive : (IsAccountActive === true) ? 1 : 0,
                CanDoTransactions : (CanDoTransactions === true) ? 1 : 0,
                CanDoTransfers : (CanDoTransfers === true) ? 1 : 0,
                CanModifySettings : (CanModifySettings === true) ? 1 : 0,
                CanUseCard : (CanUseCard === true) ? 1 : 0,
                IsTransactionAutoConfirm : (IsTransactionAutoConfirm === true) ? 1 : 0,
              }
            
              const Ajax = new AjaxRequest(BaseURL);
              Ajax.sendRequest(data, 'update user details')
                .then(responseData => {
                  if (responseData.Success) {
                  }
              });
            });
          }
        })
    }

    if (Type === 'USR-ADM') {
      const data = {
        AccountAddress : AccountAddress,
        SchoolPersonalId : '',
        Name : '',
        Email : '',
        Status : 'All'
      }
      const Ajax = new AjaxRequest(BaseURL);
      Ajax.sendRequest(data, 'get user accounts')
        .then(responseData => {
          if (responseData.Success) {
            const data = responseData.Parameters[0];
            const layout = `
              <div class="personal-information-container">
  
                  <br>
                  <p class="title center-text">Account Details</p>
                  <p id="AccountDetails-AccountAddress" class="subtitle">${(data['UsersAccount_Address'])}</p>
                  <br>
  
                  <fieldset class="PersonalDetailsSettings">
                    <legend><p>Account Details</p></legend>
                    <table>
                      <tr>
                        <td>
                          <p>Firstname:</p>
                          <input id="AccountDetails-Firstname" type="text" value="${(data['Firstname']) ? data['Firstname'] : ''}">
                        </td>
                        <td>
                          <p>Lastname:</p>
                          <input id="AccountDetails-Lastname" type="text" value="${(data['Lastname']) ? data['Lastname'] : ''}">
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <p>Email:</p>
                          <input id="AccountDetails-Email" type="text" value="${(data['Email']) ? data['Email'] : ''}">
                        </td>
                        <td>
                          <p>School Personal Id</p>
                          <input id="AccountDetails-SchoolPersonalId" type="text" value="${(data['SchoolPersonalId']) ? data['SchoolPersonalId'] : ''}">
                        </td>
                        <tr>
                        <td>
                          <p>Guardian Address:</p>
                          <input id="AccountDetails-GuardianAccountAddress" type="text" value="${(data['GuardianAccount_Address']) ? data['GuardianAccount_Address'] : ''}">
                        </td>
                      </tr>
                    </table>
                    
                  </fieldset>
  
                  <fieldset class="AccountDetailsSettings">
                      <legend><p>Account Settings</p></legend>
                      <table>
                        <tr>
                          <td colspan="2">
                              <p class="warning center-text">Warning, High level user settings.</p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Is Account Active:</p>
                          </td>
                          <td>
                            <label class="switch">
                              <input id="AccountDetails-IsAccountActive" type="checkbox" ${(data['IsAccountActive'] === '1') ? 'checked' : ''}>
                              <span class="slider round"></span>
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Can Do Transactions:</p>
                          </td>
                          <td>
                            <label class="switch">
                              <input id="AccountDetails-CanDoTransactions" type="checkbox" ${(data['CanDoTransactions'] === '1') ? 'checked' : ''}>
                              <span class="slider round"></span>
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Can Do Transfers:</p>
                          </td>
                          <td>
                            <label class="switch">
                              <input id="AccountDetails-CanDoTransfers" type="checkbox" ${(data['CanDoTransfers'] === '1') ? 'checked' : ''}>
                              <span class="slider round"></span>
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Can Modify Settings:</p>
                          </td>
                          <td>
                            <label class="switch">
                              <input id="AccountDetails-CanModifySettings" type="checkbox" ${(data['CanModifySettings'] === '1') ? 'checked' : ''}>
                              <span class="slider round"></span>
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Can Use ID Card:</p>
                          </td>
                          <td>
                            <label class="switch">
                              <input id="AccountDetails-CanUseCard" type="checkbox" ${(data['CanUseCard'] === '1') ? 'checked' : ''}>
                              <span class="slider round"></span>
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Is Transaction Auto Confirm:</p>
                          </td>
                          <td>
                            <label class="switch">
                              <input id="AccountDetails-IsTransactionAutoConfirm" type="checkbox" ${(data['IsTransactionAutoConfirm'] === '1') ? 'checked' : ''}>
                              <span class="slider round"></span>
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2">
                              <p class="warning center-text">Leave this part blank, if no PIN and Password changes.</p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>New PIN Code:</p>
                          </td>
                          <td>
                            <input id="AccountDetails-AccountPINCode" type="password" value="">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>New Password:</p>
                          </td>
                          <td>
                            <input id="AccountDetails-AccountPassword" type="password" value="">
                          </td>
                        </tr>
                      </table>
                  </fieldset>
                  <fieldset class="ConfirmChanges">
                      <legend><p>Confirmation</p></legend>
                      <table>
                        <tr>
                          <td colspan="2">
                            <p class="center-text warning">Required to apply changes.</p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Your PIN Code:</p>
                          </td>
                          <td>
                            <input id="AccountDetails-PINCode" type="password" name="AccountDetails-PINCode" placeholder="******">
                          </td>
                        </tr>
                      </table>
                  </fieldset>
                  <div class="buttons-container">
                      <button id="btn-submit-account-details-changes" class="btn-submit ">Upload Changes</button>
                  </div>
              </div>
            `;
            makeModal('Modal', 'Account Details Settings', layout);
  
            const element = document.getElementById("btn-submit-account-details-changes");
            
            element.addEventListener('click', (event) => {
              const parent = event.currentTarget.parentNode.parentNode;
            
              const AccountAddress = parent.querySelector('#AccountDetails-AccountAddress').textContent;
              const Firstname = parent.querySelector('#AccountDetails-Firstname').value;
              const Lastname = parent.querySelector('#AccountDetails-Lastname').value;
              const Email = parent.querySelector('#AccountDetails-Email').value;
              const SchoolPersonalId = parent.querySelector('#AccountDetails-SchoolPersonalId').value; 
              const GuardianAccountAddress = parent.querySelector('#AccountDetails-GuardianAccountAddress').value;
              const AccountPINCode = parent.querySelector('#AccountDetails-AccountPINCode').value;  
              const AccountPassword = parent.querySelector('#AccountDetails-AccountPassword').value;   
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
                SchoolPersonalId : SchoolPersonalId,
                AccountPINCode : AccountPINCode,
                AccountPassword : AccountPassword,
                PINCode : PINCode.value,
                GuardianAccountAddress : GuardianAccountAddress,
                IsAccountActive : (IsAccountActive === true) ? 1 : 0,
                CanDoTransactions : (CanDoTransactions === true) ? 1 : 0,
                CanDoTransfers : (CanDoTransfers === true) ? 1 : 0,
                CanModifySettings : (CanModifySettings === true) ? 1 : 0,
                CanUseCard : (CanUseCard === true) ? 1 : 0,
                IsTransactionAutoConfirm : (IsTransactionAutoConfirm === true) ? 1 : 0,
              }
            
              const Ajax = new AjaxRequest(BaseURL);
              Ajax.sendRequest(data, 'update account')
                .then(responseData => {
                  if (responseData.Success) {
                  }
              });
            });
          }
        })
    }

    if (Type === 'ACT-ADM') {
      const data = {
        AccountAddress : AccountAddress,
        Name : '',
        Email : '',
        Status : 'All'
      }
      const Ajax = new AjaxRequest(BaseURL);
      Ajax.sendRequest(data, 'get accounting accounts')
        .then(responseData => {
          if (responseData.Success) {
            const data = responseData.Parameters[0];
            const layout = `
              <div class="personal-information-container">
  
                  <br>
                  <p class="title center-text">Account Details</p>
                  <p id="AccountDetails-AccountAddress" class="subtitle">${(data['WebAccounts_Address'])}</p>
                  <br>
  
                  <fieldset class="PersonalDetailsSettings">
                    <legend><p>Account Details</p></legend>
                    <table>
                      <tr>
                        <td>
                          <p>Firstname:</p>
                          <input id="AccountDetails-Firstname" type="text" value="${(data['Firstname']) ? data['Firstname'] : ''}">
                        </td>
                        <td>
                          <p>Lastname:</p>
                          <input id="AccountDetails-Lastname" type="text" value="${(data['Lastname']) ? data['Lastname'] : ''}">
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <p>Email:</p>
                          <input id="AccountDetails-Email" type="text" value="${(data['Email']) ? data['Email'] : ''}">
                        </td>
                      </tr>
                    </table>
                    
                  </fieldset>
  
                  <fieldset class="AccountDetailsSettings">
                      <legend><p>Account Settings</p></legend>
                      <table>
                        <tr>
                          <td colspan="2">
                              <p class="warning center-text">Warning, High level user settings.</p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Is Account Active:</p>
                          </td>
                          <td>
                            <label class="switch">
                              <input id="AccountDetails-IsAccountActive" type="checkbox" ${(data['IsAccountActive'] === '1') ? 'checked' : ''}>
                              <span class="slider round"></span>
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2">
                              <p class="warning center-text">Leave this part blank, if no PIN and Password changes.</p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>New PIN Code:</p>
                          </td>
                          <td>
                            <input id="AccountDetails-AccountPINCode" type="password" value="">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>New Password:</p>
                          </td>
                          <td>
                            <input id="AccountDetails-AccountPassword" type="password" value="">
                          </td>
                        </tr>
                      </table>
                  </fieldset>
                  <fieldset class="ConfirmChanges">
                      <legend><p>Confirmation</p></legend>
                      <table>
                        <tr>
                          <td colspan="2">
                            <p class="center-text warning">Required to apply changes.</p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Your PIN Code:</p>
                          </td>
                          <td>
                            <input id="AccountDetails-PINCode" type="password" name="AccountDetails-PINCode" placeholder="******">
                          </td>
                        </tr>
                      </table>
                  </fieldset>
                  <div class="buttons-container">
                      <button id="btn-submit-account-details-changes" class="btn-submit ">Upload Changes</button>
                  </div>
              </div>
            `;
            makeModal('Modal', 'Account Details Settings', layout);
  
            const element = document.getElementById("btn-submit-account-details-changes");
            
            element.addEventListener('click', (event) => {
              const parent = event.currentTarget.parentNode.parentNode;
            
              const AccountAddress = parent.querySelector('#AccountDetails-AccountAddress').textContent;
              const Firstname = parent.querySelector('#AccountDetails-Firstname').value;
              const Lastname = parent.querySelector('#AccountDetails-Lastname').value;
              const Email = parent.querySelector('#AccountDetails-Email').value;
              const PINCode = parent.querySelector('#AccountDetails-PINCode'); 
              const AccountPINCode = parent.querySelector('#AccountDetails-AccountPINCode').value;  
              const AccountPassword = parent.querySelector('#AccountDetails-AccountPassword').value; 
            
              const IsAccountActive = parent.querySelector('#AccountDetails-IsAccountActive').checked; 
            
              const data = {
                AccountAddress : AccountAddress,
                Firstname : Firstname,
                Lastname : Lastname,
                Email : Email,
                AccountPINCode : AccountPINCode,
                AccountPassword : AccountPassword,
                PINCode : PINCode.value,
                IsAccountActive : (IsAccountActive === true) ? 1 : 0,
                ccountPINCode : AccountPINCode,
                AccountPassword : AccountPassword,
              }
            
              const Ajax = new AjaxRequest(BaseURL);
              Ajax.sendRequest(data, 'update account')
                .then(responseData => {
                  if (responseData.Success) {
                  }
              });
            });
          }
        })
    }

    if (Type === 'ADM-ADM') {
      const data = {
        AccountAddress : AccountAddress,
        Name : '',
        Email : '',
        Status : 'All'
      }
      const Ajax = new AjaxRequest(BaseURL);
      Ajax.sendRequest(data, 'get administrator accounts')
        .then(responseData => {
          if (responseData.Success) {
            const data = responseData.Parameters[0];
            const layout = `
              <div class="personal-information-container">
  
                  <br>
                  <p class="title center-text">Account Details</p>
                  <p id="AccountDetails-AccountAddress" class="subtitle">${(data['WebAccounts_Address'])}</p>
                  <br>
  
                  <fieldset class="PersonalDetailsSettings">
                    <legend><p>Account Details</p></legend>
                    <table>
                      <tr>
                        <td>
                          <p>Firstname:</p>
                          <input id="AccountDetails-Firstname" type="text" value="${(data['Firstname']) ? data['Firstname'] : ''}">
                        </td>
                        <td>
                          <p>Lastname:</p>
                          <input id="AccountDetails-Lastname" type="text" value="${(data['Lastname']) ? data['Lastname'] : ''}">
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <p>Email:</p>
                          <input id="AccountDetails-Email" type="text" value="${(data['Email']) ? data['Email'] : ''}">
                        </td>
                      </tr>
                    </table>
                    
                  </fieldset>
  
                  <fieldset class="AccountDetailsSettings">
                      <legend><p>Account Settings</p></legend>
                      <table>
                        <tr>
                          <td colspan="2">
                              <p class="warning center-text">Warning, High level user settings.</p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Is Account Active:</p>
                          </td>
                          <td>
                            <label class="switch">
                              <input id="AccountDetails-IsAccountActive" type="checkbox" ${(data['IsAccountActive'] === '1') ? 'checked' : ''}>
                              <span class="slider round"></span>
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2">
                              <p class="warning center-text">Leave this part blank, if no PIN and Password changes.</p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>New PIN Code:</p>
                          </td>
                          <td>
                            <input id="AccountDetails-AccountPINCode" type="password" value="">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>New Password:</p>
                          </td>
                          <td>
                            <input id="AccountDetails-AccountPassword" type="password" value="">
                          </td>
                        </tr>
                      </table>
                  </fieldset>
                  <fieldset class="ConfirmChanges">
                      <legend><p>Confirmation</p></legend>
                      <table>
                        <tr>
                          <td colspan="2">
                            <p class="center-text warning">Required to apply changes.</p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Your PIN Code:</p>
                          </td>
                          <td>
                            <input id="AccountDetails-PINCode" type="password" name="AccountDetails-PINCode" placeholder="******">
                          </td>
                        </tr>
                      </table>
                  </fieldset>
                  <div class="buttons-container">
                      <button id="btn-submit-account-details-changes" class="btn-submit ">Upload Changes</button>
                  </div>
              </div>
            `;
            makeModal('Modal', 'Account Details Settings', layout);
  
            const element = document.getElementById("btn-submit-account-details-changes");
            
            element.addEventListener('click', (event) => {
              const parent = event.currentTarget.parentNode.parentNode;
            
              const AccountAddress = parent.querySelector('#AccountDetails-AccountAddress').textContent;
              const Firstname = parent.querySelector('#AccountDetails-Firstname').value;
              const Lastname = parent.querySelector('#AccountDetails-Lastname').value;
              const Email = parent.querySelector('#AccountDetails-Email').value; 
              const PINCode = parent.querySelector('#AccountDetails-PINCode'); 
              const AccountPINCode = parent.querySelector('#AccountDetails-AccountPINCode').value;  
              const AccountPassword = parent.querySelector('#AccountDetails-AccountPassword').value;   
            
              const IsAccountActive = parent.querySelector('#AccountDetails-IsAccountActive').checked; 
            
              const data = {
                AccountAddress : AccountAddress,
                Firstname : Firstname,
                Lastname : Lastname,
                AccountPINCode : AccountPINCode,
                AccountPassword : AccountPassword,
                Email : Email,
                PINCode : PINCode.value,
                IsAccountActive : (IsAccountActive === true) ? 1 : 0,
              }
            
              const Ajax = new AjaxRequest(BaseURL);
              Ajax.sendRequest(data, 'update account')
                .then(responseData => {
                  if (responseData.Success) {
                  }
              });
            });
          }
        })
    }

    if (Type === 'MTS-ADM') {
      const data = {
        AccountAddress : AccountAddress,
        MerchantCategory : '',
        Name : '',
        Email : '',
        Status : 'All'
      }
      const Ajax = new AjaxRequest(BaseURL);
      Ajax.sendRequest(data, 'get merchantstaff accounts')
        .then(responseData => {
          if (responseData.Success) {
            const data = responseData.Parameters[0];
            const layout = `
              <div class="personal-information-container">
  
                  <br>
                  <p class="title center-text">Account Details</p>
                  <p id="AccountDetails-AccountAddress" class="subtitle">${(data['WebAccounts_Address'])}</p>
                  <br>
  
                  <fieldset class="PersonalDetailsSettings">
                    <legend><p>Account Details</p></legend>
                    <table>
                      <tr>
                        <td>
                          <p>Firstname:</p>
                          <input id="AccountDetails-Firstname" type="text" value="${(data['Firstname']) ? data['Firstname'] : ''}">
                        </td>
                        <td>
                          <p>Lastname:</p>
                          <input id="AccountDetails-Lastname" type="text" value="${(data['Lastname']) ? data['Lastname'] : ''}">
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <p>Email:</p>
                          <input id="AccountDetails-Email" type="text" value="${(data['Email']) ? data['Email'] : ''}">
                        </td>
                      </tr>
                    </table>
                  </fieldset>
  
                  <fieldset class="AccountDetailsSettings">
                      <legend><p>Account Settings</p></legend>
                      <table>
                        <tr>
                          <td colspan="2">
                              <p class="warning center-text">Warning, High level user settings.</p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Is Account Active:</p>
                          </td>
                          <td>
                            <label class="switch">
                              <input id="AccountDetails-IsAccountActive" type="checkbox" ${(data['IsAccountActive'] === '1') ? 'checked' : ''}>
                              <span class="slider round"></span>
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2">
                              <p class="warning center-text">Leave this part blank, if no PIN and Password changes.</p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>New PIN Code:</p>
                          </td>
                          <td>
                            <input id="AccountDetails-AccountPINCode" type="password" value="">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>New Password:</p>
                          </td>
                          <td>
                            <input id="AccountDetails-AccountPassword" type="password" value="">
                          </td>
                        </tr>

                      </table>
                  </fieldset>
                  <fieldset class="ConfirmChanges">
                      <legend><p>Confirmation</p></legend>
                      <table>
                        <tr>
                          <td colspan="2">
                            <p class="center-text warning">Required to apply changes.</p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Your PIN Code:</p>
                          </td>
                          <td>
                            <input id="AccountDetails-PINCode" type="password" name="AccountDetails-PINCode" placeholder="******">
                          </td>
                        </tr>
                      </table>
                  </fieldset>
                  <div class="buttons-container">
                      <button id="btn-submit-account-details-changes" class="btn-submit ">Upload Changes</button>
                  </div>
              </div>
            `;
            makeModal('Modal', 'Account Details Settings', layout);
  
            const element = document.getElementById("btn-submit-account-details-changes");
            
            element.addEventListener('click', (event) => {
              const parent = event.currentTarget.parentNode.parentNode;
            
              const AccountAddress = parent.querySelector('#AccountDetails-AccountAddress').textContent;
              const Firstname = parent.querySelector('#AccountDetails-Firstname').value;
              const Lastname = parent.querySelector('#AccountDetails-Lastname').value;
              const Email = parent.querySelector('#AccountDetails-Email').value;
              const AccountPINCode = parent.querySelector('#AccountDetails-AccountPINCode').value;  
              const AccountPassword = parent.querySelector('#AccountDetails-AccountPassword').value;   
              const PINCode = parent.querySelector('#AccountDetails-PINCode'); 
            
              const IsAccountActive = parent.querySelector('#AccountDetails-IsAccountActive').checked; 
            
              const data = {
                AccountAddress : AccountAddress,
                Firstname : Firstname,
                Lastname : Lastname,
                Email : Email,
                PINCode : PINCode.value,
                AccountPINCode : AccountPINCode,
                AccountPassword : AccountPassword,
                IsAccountActive : (IsAccountActive === true) ? 1 : 0,
              }
            
              const Ajax = new AjaxRequest(BaseURL);
              Ajax.sendRequest(data, 'update account')
                .then(responseData => {
                  if (responseData.Success) {
                  }
              });
            });
          }
        })
    }

    if (Type === 'MTA-ADM') {
      const data = {
        AccountAddress : AccountAddress,
        MerchantCategory : '',
        Name : '',
        Email : '',
        Status : 'All'
      }
      const Ajax = new AjaxRequest(BaseURL);
      Ajax.sendRequest(data, 'get merchant accounts')
        .then(responseData => {
          if (responseData.Success) {
            const data = responseData.Parameters[0];
            const layout = `
              <div class="personal-information-container">
  
                  <br>
                  <p class="title center-text">Account Details</p>
                  <p id="AccountDetails-AccountAddress" class="subtitle">${(data['WebAccounts_Address'])}</p>
                  <br>
  
                  <fieldset class="PersonalDetailsSettings">
                    <legend><p>Account Details</p></legend>
                    <table>
                      <tr>
                        <td>
                          <p>Firstname:</p>
                          <input id="AccountDetails-Firstname" type="text" value="${(data['Firstname']) ? data['Firstname'] : ''}">
                        </td>
                        <td>
                          <p>Lastname:</p>
                          <input id="AccountDetails-Lastname" type="text" value="${(data['Lastname']) ? data['Lastname'] : ''}">
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <p>Email:</p>
                          <input id="AccountDetails-Email" type="text" value="${(data['Email']) ? data['Email'] : ''}">
                        </td>
                      </tr>
                    </table>
                    
                  </fieldset>
  
                  <fieldset class="AccountDetailsSettings">
                      <legend><p>Account Settings</p></legend>
                      <table>
                        <tr>
                          <td colspan="2">
                              <p class="warning center-text">Warning, High level user settings.</p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Is Account Active:</p>
                          </td>
                          <td>
                            <label class="switch">
                              <input id="AccountDetails-IsAccountActive" type="checkbox" ${(data['IsAccountActive'] === '1') ? 'checked' : ''}>
                              <span class="slider round"></span>
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2">
                              <p class="warning center-text">Leave this part blank, if no PIN and Password changes.</p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>New PIN Code:</p>
                          </td>
                          <td>
                            <input id="AccountDetails-AccountPINCode" type="password" value="">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>New Password:</p>
                          </td>
                          <td>
                            <input id="AccountDetails-AccountPassword" type="password" value="">
                          </td>
                        </tr>

                      </table>
                  </fieldset>
                  <fieldset class="ConfirmChanges">
                      <legend><p>Confirmation</p></legend>
                      <table>
                        <tr>
                          <td colspan="2">
                            <p class="center-text warning">Required to apply changes.</p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Your PIN Code:</p>
                          </td>
                          <td>
                            <input id="AccountDetails-PINCode" type="password" name="AccountDetails-PINCode" placeholder="******">
                          </td>
                        </tr>
                      </table>
                  </fieldset>
                  <div class="buttons-container">
                      <button id="btn-submit-account-details-changes" class="btn-submit ">Upload Changes</button>
                  </div>
              </div>
            `;
            makeModal('Modal', 'Account Details Settings', layout);
  
            const element = document.getElementById("btn-submit-account-details-changes");
            
            element.addEventListener('click', (event) => {
              const parent = event.currentTarget.parentNode.parentNode;
            
              const AccountAddress = parent.querySelector('#AccountDetails-AccountAddress').textContent;
              const Firstname = parent.querySelector('#AccountDetails-Firstname').value;
              const Lastname = parent.querySelector('#AccountDetails-Lastname').value;
              const Email = parent.querySelector('#AccountDetails-Email').value;
              const AccountPINCode = parent.querySelector('#AccountDetails-AccountPINCode').value;  
              const AccountPassword = parent.querySelector('#AccountDetails-AccountPassword').value;   
              const PINCode = parent.querySelector('#AccountDetails-PINCode'); 
              const IsAccountActive = parent.querySelector('#AccountDetails-IsAccountActive').checked; 
     
              const data = {
                AccountAddress : AccountAddress,
                Firstname : Firstname,
                Lastname : Lastname,
                Email : Email,
                PINCode : PINCode.value,
                IsAccountActive : (IsAccountActive === true) ? 1 : 0,
                AccountPINCode : AccountPINCode,
                AccountPassword : AccountPassword,
              }
            
              const Ajax = new AjaxRequest(BaseURL);
              Ajax.sendRequest(data, 'update account')
                .then(responseData => {
                  if (responseData.Success) {
                  }
              });
            });
          }
        })
    }

    if (Type === 'GDN-ADM') {
      const data = {
        AccountAddress : AccountAddress,
        Name : '',
        Email : '',
        Status : 'All'
      }
      const Ajax = new AjaxRequest(BaseURL);
      Ajax.sendRequest(data, 'get guardian accounts')
        .then(responseData => {
          if (responseData.Success) {
            const data = responseData.Parameters[0];
            const layout = `
              <div class="personal-information-container">
  
                  <br>
                  <p class="title center-text">Account Details</p>
                  <p id="AccountDetails-AccountAddress" class="subtitle">${(data['GuardianAccount_Address'])}</p>
                  <br>
  
                  <fieldset class="PersonalDetailsSettings">
                    <legend><p>Account Details</p></legend>
                    <table>
                      <tr>
                        <td>
                          <p>Firstname:</p>
                          <input id="AccountDetails-Firstname" type="text" value="${(data['Firstname']) ? data['Firstname'] : ''}">
                        </td>
                        <td>
                          <p>Lastname:</p>
                          <input id="AccountDetails-Lastname" type="text" value="${(data['Lastname']) ? data['Lastname'] : ''}">
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <p>Email:</p>
                          <input id="AccountDetails-Email" type="text" value="${(data['Email']) ? data['Email'] : ''}">
                        </td>
                        <td>
                          <p>User Account Address:</p>
                          <input id="AccountDetails-UserAccountAddress" type="text" value="${(data['UsersAccount_Address']) ? data['UserAccount_Address'] : ''}">
                        </td>
                    </table>
                    
                  </fieldset>
  
                  <fieldset class="AccountDetailsSettings">
                      <legend><p>Account Settings</p></legend>
                      <table>
                        <tr>
                          <td colspan="2">
                              <p class="warning center-text">Warning, High level user settings.</p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Is Account Active:</p>
                          </td>
                          <td>
                            <label class="switch">
                              <input id="AccountDetails-IsAccountActive" type="checkbox" ${(data['IsAccountActive'] === '1') ? 'checked' : ''}>
                              <span class="slider round"></span>
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2">
                              <p class="warning center-text">Leave this part blank, if no PIN and Password changes.</p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>New PIN Code:</p>
                          </td>
                          <td>
                            <input id="AccountDetails-AccountPINCode" type="password" value="">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>New Password:</p>
                          </td>
                          <td>
                            <input id="AccountDetails-AccountPassword" type="password" value="">
                          </td>
                        </tr>

                      </table>
                  </fieldset>
                  <fieldset class="ConfirmChanges">
                      <legend><p>Confirmation</p></legend>
                      <table>
                        <tr>
                          <td colspan="2">
                            <p class="center-text warning">Required to apply changes.</p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Your PIN Code:</p>
                          </td>
                          <td>
                            <input id="AccountDetails-PINCode" type="password" name="AccountDetails-PINCode" placeholder="******">
                          </td>
                        </tr>
                      </table>
                  </fieldset>
                  <div class="buttons-container">
                      <button id="btn-submit-account-details-changes" class="btn-submit ">Upload Changes</button>
                  </div>
              </div>
            `;
            makeModal('Modal', 'Account Details Settings', layout);
  
            const element = document.getElementById("btn-submit-account-details-changes");
            
            element.addEventListener('click', (event) => {
              const parent = event.currentTarget.parentNode.parentNode;
            
              const AccountAddress = parent.querySelector('#AccountDetails-AccountAddress').textContent;
              const Firstname = parent.querySelector('#AccountDetails-Firstname').value;
              const Lastname = parent.querySelector('#AccountDetails-Lastname').value;
              const Email = parent.querySelector('#AccountDetails-Email').value;
              const PINCode = parent.querySelector('#AccountDetails-PINCode');
              const AccountPINCode = parent.querySelector('#AccountDetails-AccountPINCode').value;  
              const AccountPassword = parent.querySelector('#AccountDetails-AccountPassword').value;
              const UserAccountAddress = parent.querySelector('#AccountDetails-UserAccountAddress').value;
              const IsAccountActive = parent.querySelector('#AccountDetails-IsAccountActive').checked; 
            
              const data = {
                AccountAddress : AccountAddress,
                Firstname : Firstname,
                Lastname : Lastname,
                Email : Email,
                UserAccountAddress : UserAccountAddress,
                PINCode : PINCode.value,
                AccountPINCode : AccountPINCode,
                AccountPassword : AccountPassword,
                IsAccountActive : (IsAccountActive === true) ? 1 : 0,
              }
            
              const Ajax = new AjaxRequest(BaseURL);
              Ajax.sendRequest(data, 'update account')
                .then(responseData => {
                  if (responseData.Success) {
                    document.getElementById("Modal-Container").style.display = "none";
                  }
              });
            });
          }
        })
    }

    if (Type === 'MTS-MTA') {
      const data = {
        AccountAddress : AccountAddress,
        MerchantCategory : '',
        Name : '',
        Email : '',
        Status : 'All'
      }
      const Ajax = new AjaxRequest(BaseURL);
      Ajax.sendRequest(data, 'get merchantstaff accounts')
        .then(responseData => {
          if (responseData.Success) {
            const data = responseData.Parameters[0];
            const layout = `
              <div class="personal-information-container">
  
                  <br>
                  <p class="title center-text">Account Details</p>
                  <p id="AccountDetails-AccountAddress" class="subtitle">${(data['WebAccounts_Address'])}</p>
                  <br>
  
                  <fieldset class="PersonalDetailsSettings">
                    <legend><p>Account Details</p></legend>
                    <table>
                      <tr>
                        <td>
                          <p>Firstname:</p>
                          <input id="AccountDetails-Firstname" type="text" value="${(data['Firstname']) ? data['Firstname'] : ''}">
                        </td>
                        <td>
                          <p>Lastname:</p>
                          <input id="AccountDetails-Lastname" type="text" value="${(data['Lastname']) ? data['Lastname'] : ''}">
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <p>Email:</p>
                          <input id="AccountDetails-Email" type="text" value="${(data['Email']) ? data['Email'] : ''}">
                        </td>
                      </tr>
                    </table>
                  </fieldset>
  
                  <fieldset class="AccountDetailsSettings">
                      <legend><p>Account Settings</p></legend>
                      <table>
                        <tr>
                          <td colspan="2">
                              <p class="warning center-text">Warning, High level user settings.</p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Is Account Active:</p>
                          </td>
                          <td>
                            <label class="switch">
                              <input id="AccountDetails-IsAccountActive" type="checkbox" ${(data['IsAccountActive'] === '1') ? 'checked' : ''}>
                              <span class="slider round"></span>
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2">
                              <p class="warning center-text">Leave this part blank, if no PIN and Password changes.</p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>New PIN Code:</p>
                          </td>
                          <td>
                            <input id="AccountDetails-AccountPINCode" type="password" value="">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>New Password:</p>
                          </td>
                          <td>
                            <input id="AccountDetails-AccountPassword" type="password" value="">
                          </td>
                        </tr>

                      </table>
                  </fieldset>
                  <fieldset class="ConfirmChanges">
                      <legend><p>Confirmation</p></legend>
                      <table>
                        <tr>
                          <td colspan="2">
                            <p class="center-text warning">Required to apply changes.</p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p>Your PIN Code:</p>
                          </td>
                          <td>
                            <input id="AccountDetails-PINCode" type="password" name="AccountDetails-PINCode" placeholder="******">
                          </td>
                        </tr>
                      </table>
                  </fieldset>
                  <div class="buttons-container">
                      <button id="btn-submit-account-details-changes" class="btn-submit ">Upload Changes</button>
                  </div>
              </div>
            `;
            makeModal('Modal', 'Account Details Settings', layout);
  
            const element = document.getElementById("btn-submit-account-details-changes");
            
            element.addEventListener('click', (event) => {
              const parent = event.currentTarget.parentNode.parentNode;
            
              const AccountAddress = parent.querySelector('#AccountDetails-AccountAddress').textContent;
              const Firstname = parent.querySelector('#AccountDetails-Firstname').value;
              const Lastname = parent.querySelector('#AccountDetails-Lastname').value;
              const Email = parent.querySelector('#AccountDetails-Email').value;
              const AccountPINCode = parent.querySelector('#AccountDetails-AccountPINCode').value;  
              const AccountPassword = parent.querySelector('#AccountDetails-AccountPassword').value;   
              const PINCode = parent.querySelector('#AccountDetails-PINCode'); 
            
              const IsAccountActive = parent.querySelector('#AccountDetails-IsAccountActive').checked; 
            
              const data = {
                AccountAddress : AccountAddress,
                Firstname : Firstname,
                Lastname : Lastname,
                Email : Email,
                PINCode : PINCode.value,
                AccountPINCode : AccountPINCode,
                AccountPassword : AccountPassword,
                IsAccountActive : (IsAccountActive === true) ? 1 : 0,
              }
            
              parent.querySelector('#AccountDetails-PINCode').value = '';

              const Ajax = new AjaxRequest(BaseURL);
              Ajax.sendRequest(data, 'update staff account')
                .then(responseData => {
                  if (responseData.Success) {
                    document.getElementById("Modal-Container").style.display = "none";
                  }
              });
            });
          }
        })
    }

    // if (Type === 'GST-ADM') {

    // }
  }

  applyAccountsQuery(event,intent, uploadUserChanges){
    this.intent = intent;
    this.uploadUserChanges = uploadUserChanges;
    this.getTableBodyView();
  }

  clearAccountsQuery(event){
    this.tableBody ? this.tableBody.innerHTML = "" : '';

    if (this.queryContainer) {
      const queryList = this.queryContainer.querySelectorAll(".query");
      const today = new Date().toISOString().slice(0, 10);
      queryList.forEach(element => {
        element.classList.contains("inputdate") ? element.value = today : '';
        element.classList.contains("inputtext") ? element.value = "" : '';
        element.classList.contains("inputdropdown") ? element.textContent = "All" : '';
      });
    }
  }
}