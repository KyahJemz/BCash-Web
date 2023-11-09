import AjaxRequest from '../ajax.js';
import { makeModal } from './modals.js';
import Helper from '../helper.js';

export default class Cards {
  constructor(tableBody, queryContainer, Ajax, Helper, Modals) {
    this.Ajax = Ajax;
    this.Helper = Helper;
    this.Modals = Modals;
    this.tableBody = tableBody;
    this.queryContainer = queryContainer;
  }

  getTableBodyView(){
    let view = '';
    let num = 0;

    const CardsAddress = this.queryContainer.querySelector(".cards-address").value;
    const UserAddress = this.queryContainer.querySelector(".cards-useraaddress").value;
    const Status = this.queryContainer.querySelector(".cards-status-dropdown").textContent;

    const data = {
      Card_Address : CardsAddress,
      Account_Address : UserAddress,
      Status : Status,
    }
    this.Ajax.sendRequest(data, this.intent)
      .then(responseData => {
        if (responseData.Success) {
          this.data = responseData.Parameters;
          view = view + `
            <tr>
              <td colspan="7"><div class="free"><input class="AddCardAddressForm" type="text"><Button class="AddCardAddressButton">Upload Card</Button></td>
            </tr>
          `;

          this.data.forEach(record => {
            Object.keys(record).forEach(key => {
              if (record[key] === null || record[key] === "") {
                  record[key] = "?";
              }
            });
            const status = (record['IsActive'] === '1') ? 'Active' : 'Inactive' ;
            num++,
            view = view + `
              <tr>
                <td><div class="col1 cell" title="`+num+`"><center>`+num+`</center></div></td>
                <td><div class="col2 cell CardAddress" title="`+record["Card_Address"]+`"><a class="cards-viewdata-button view-more">`+record["Card_Address"]+`</a></div></td>
                <td><div class="col3 cell `+ status.replace(new RegExp(" ", 'g'), '').toLowerCase() +`" title="`+status+`">`+status+`</div></td>
                <td><div class="col4 cell" title="`+(record["UsersAccount_Address"])+`">`+(record["UsersAccount_Address"])+`</div></td>
                <td><div class="col5 cell" title="`+(record["Firstname"])+`">`+(record["Firstname"])+`</div></td>
                <td><div class="col6 cell" title="`+(record["Lastname"])+`">`+(record["Lastname"])+`</div></td>
                <td><div class="col7 cell" title="`+(record["Notes"])+`">`+(record["Notes"])+`</div></td>
              </tr>
            `;
          }); 
          this.tableBody.innerHTML = view;
          const AccountAddress = this.tableBody.querySelectorAll(".CardAddress");
          this.Helper.addElementClickListenerByElement(AccountAddress,this.openDialogBox);
          this.Helper.addElementClickListenerByElement(this.tableBody.querySelectorAll(".AddCardAddressButton"),this.addCardAddress);
        }
      })
      .catch(error => {
        this.tableBody.innerHTML = `
            <tr>
              <td colspan="7"><div class="free"><input class="AddCardAddressForm" type="text"><Button class="AddCardAddressButton">Upload Card</Button></td>
            </tr>
        `;
        this.Helper.addElementClickListenerByElement(this.tableBody.querySelectorAll(".AddCardAddressButton"),this.addCardAddress);
      });
  }

  openDialogBox(event) {
    const CardAddress = event.currentTarget.querySelector('.cards-viewdata-button').textContent;

      const data = {
        Card_Address : CardAddress,
        Account_Address : null,
        Status : 'All',
      }
      const Ajax = new AjaxRequest(BaseURL);
      Ajax.sendRequest(data, 'get cards')
        .then(responseData => {
          if (responseData.Success) {
            const data = responseData.Parameters[0];
            const layout = `
              <div class="personal-information-container">
  
                  <br>
                  <p class="title center-text">Card Details</p>
                  <p id="CardDetails-CardAddress" class="subtitle">${(data['Card_Address'])}</p>
                  <br>
  
                  <fieldset class="PersonalDetailsSettings">

                    <legend><p>Card Details</p></legend>
                    <table>
                      <tr>
                        <td colspan="2">
                          <p>User Account Address :</p>
                          <input id="CardDetails-UsersAccountAddress" type="text" value="${(data['UsersAccount_Address']) ? data['UsersAccount_Address'] : ''}">
                        </td>
                      </tr>

                      <tr>
                        <td colspan="2">
                          <p>Notes :</p>
                          <textarea id="CardDetails-Notes" rows="4" cols="50" type="text">${(data['Notes']) ? data['Notes'] : ''}</textarea>
                        </td>
                      </tr>

                      <tr>
                        <td>
                          <p>Is Active:</p>
                        </td>
                        <td>
                          <label class="switch">
                            <input id="CardDetails-IsActive" type="checkbox" ${(data['IsActive'] === '1') ? 'checked' : ''}>
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
                            <input id="CardDetails-PINCode" type="password"  placeholder="******">
                          </td>
                        </tr>
                      </table>
                  </fieldset>

                  <div class="buttons-container">
                      <button id="btn-submit-card-details-changes" class="btn-submit ">Upload Changes</button>
                  </div>
              </div>
            `;
            makeModal('Modal', 'Card Details Settings', layout);
  
            const element = document.getElementById("btn-submit-card-details-changes");
            
            element.addEventListener('click', (event) => {
              const parent = event.currentTarget.parentNode.parentNode;
            
              const Card_Address = parent.querySelector('#CardDetails-CardAddress').textContent;
              const UsersAccount_Address = parent.querySelector('#CardDetails-UsersAccountAddress').value;
              const Notes = parent.querySelector('#CardDetails-Notes').value; 
              const IsActive = parent.querySelector('#CardDetails-IsActive').checked; 
              const PinCode = parent.querySelector('#CardDetails-PINCode');  
            
              const data = {
                Card_Address : Card_Address,
                UsersAccount_Address : UsersAccount_Address,
                Notes : (Notes),
                IsActive : (IsActive === true) ? '1' : '0',
                PinCode : PinCode.value,
              }
            
              const Ajax = new AjaxRequest(BaseURL);
              Ajax.sendRequest(data, 'update card')
                .then(responseData => {
                  if (responseData.Success) {
                    
                  }
              });
              PinCode.value = '';
            });
          }
        })

  }

  applyCardsQuery(event,intent,addCardAddress){
    this.addCardAddress = addCardAddress
    this.intent = intent;
    this.getTableBodyView();
  }

  clearCardsQuery(event,addCardAddress){
    this.addCardAddress = addCardAddress
    this.tableBody ? this.tableBody.innerHTML = `
      <tr>
        <td colspan="7"><div class="free"><input class="AddCardAddressForm" type="text"><Button class="AddCardAddressButton">Upload Card</Button></td>
      </tr>
    ` : '';

    this.Helper.addElementClickListenerByElement(this.tableBody.querySelectorAll(".AddCardAddressButton"),this.addCardAddress);

    if (this.queryContainer) {
      const queryList = this.queryContainer.querySelectorAll(".query");

      queryList.forEach(element => {
        element.classList.contains("inputdate") ? element.value = "" : '';
        element.classList.contains("inputtext") ? element.value = "" : '';
        element.classList.contains("inputdropdown") ? element.textContent = "All" : '';
      });
    }
  }
}