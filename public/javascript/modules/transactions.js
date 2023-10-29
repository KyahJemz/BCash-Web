
// MODULE
// TRANSACTIONS

import { makeModal } from './modals.js';
import AjaxRequest from '../ajax.js';
import Helper from '../helper.js';

export default class Transactions {

  constructor(tableContainer,queryContainer,footerQueryContainer, Ajax, Helper, Modals) {
    this.Ajax = Ajax;
    this.Helper = Helper;
    this.tableContainer = tableContainer;
    this.queryContainer = queryContainer;
    this.footerQueryContainer = footerQueryContainer;
    this.Modals = Modals;
  }
  
  clearTransactionsQueries(){
    this.tableContainer ? this.tableContainer.innerHTML = "" : '';
    if (AccountAddress.substring(0, 3) === 'ACT'){
      document.getElementById('mytransaction-records-cashin').innerHTML = `
        Records : <a class="display-record">0</a>
      `;
      document.getElementById('mytransaction-total-cashin').innerHTML = `
        Amount Total : <a class="display-record">₱ 0.00</a>
      `;
    }

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

  exportTransactions(){

  }

  async fetchData(intent){
		const data = {
      StartDate: (this.StartDate) ? this.StartDate : null,
      EndDate: (this.EndDate) ? this.EndDate : null,
      TransactionAddress: (this.TransactionAddress) ? this.TransactionAddress : null,
      SearchName: (this.SearchName) ? this.SearchName : null,
      StatusFilter: (this.StatusFilter) ? this.StatusFilter : null,
			ResultsPerPage: (this.ResultsPerPage)
        ? (
          (this.ResultsPerPage === '50/Page') ? '50' :
          (this.ResultsPerPage === '100/Page') ? '100' :
          (this.ResultsPerPage === '200/Page') ? '200' :
          (this.ResultsPerPage === 'All/Page') ? 'All' :
          '50'
        )
        : '50'
		}; 
		await this.Ajax.sendRequest(data, intent)
			.then(responseData => {
				if (responseData.Success) {
          this.data = responseData.Parameters;
          this.displayTransactionsToTable();
				}
			})
  }

  applyTransactionsQueries(event, intent){
    this.intent = intent;
    this.StartDate = this.queryContainer.querySelector(".transactions-startdate").value;
    this.EndDate = this.queryContainer.querySelector(".transactions-enddate").value;
    this.TransactionAddress = this.queryContainer.querySelector(".transactions-transactionnumber").value;
    this.SearchName = this.queryContainer.querySelector(".transactions-transactionname").value;
    this.StatusFilter = this.queryContainer.querySelector(".transactions-status-dropdown").textContent;
    this.ResultsPerPage = this.footerQueryContainer.querySelector(".transactions-recordscount-dropdown").textContent;
  
    this.fetchData(this.intent);
  }

  displayTransactionsToTable(){
    let totalAmount = 0;
    let totalRecords = 0;
    let template = ``;
    let count = 0;
    if (this.data) {
        this.data.forEach((record) => {  
            Object.keys(record).forEach(key => {
              if (record[key] === null || record[key] === "") {
                  record[key] = "?";
              }
            });
          count++;
          totalRecords++;
          totalAmount = totalAmount + Number(record["TotalAmount"]);
          template = template + `
            <tr class="transactions-row">
                <td><div class="col1 cell" title="checkbox"><input class="transactionCheckbox" type="checkbox" name="`+record["Transaction ID"]+`" id=""></div></td>
                <td><div class="col2 cell" title="`+count+`"><center>`+count+`</center></div></td>
                <td><div class="col3 cell TransactionAddress" title="`+record["Transaction_Address"]+`"><a class="transaction-viewdata-button view-more">`+record["Transaction_Address"]+`</a></div></td>
                <td><div class="col4 cell" title="`+record["TransactionType"]+`">`+record["TransactionType"]+`</div></td>
                <td><div class="col5 cell" title="`+record["Status"]+`">`+record["Status"]+`</div></td>
                <td><div class="col6 cell" title="`+record["Sender_Address"]+`">`+record["Sender_Address"]+`</div></td>
                <td><div class="col7 cell" title="`+record["Sender_Firstname"]+` `+record["Sender_Lastname"]+`">`+record["Sender_Firstname"]+` `+record["Sender_Lastname"]+`</div></td>
                <td><div class="col8 cell" title="`+record["Receiver_Address"]+`">`+record["Receiver_Address"]+`</div></td>
                <td><div class="col9 cell" title="`+record["Receiver_Firstname"]+` `+record["Receiver_Lastname"]+`">`+record["Receiver_Firstname"]+` `+record["Receiver_Lastname"]+`</div></td>
                <td><div class="col10 cell" title="₱ `+this.Helper.formatNumber(record["TotalAmount"])+`">₱ `+this.Helper.formatNumber(record["TotalAmount"])+`</div></td>
                <td><div class="col11 cell" title="`+record["Timestamp"]+`">`+record["Timestamp"]+`</div></td>
                <td><div class="col12 cell" title="`+record["Posted By"]+`">`+record["PostedBy"]+`</div></td>
                <td><div class="col13 cell" title="`+record["PaymentMethod"]+`">`+record["PaymentMethod"]+`</div></td>
                <td><div class="col14 cell" title="`+record["Notes"]+`">`+record["Notes"]+`</div></td>
            </tr>       
          `
        });
    }
    if (AccountAddress.substring(0, 3) === 'ACT'){
      document.getElementById('mytransaction-records-cashin').innerHTML = `
        Records : <a class="display-record">${totalRecords}</a>
      `;
      document.getElementById('mytransaction-total-cashin').innerHTML = `
        Amount Total : <a class="display-record">₱ ${this.Helper.formatNumber(totalAmount)}</a>
      `;
    }
    this.tableContainer.innerHTML = template;
    const TransactionAddress = this.tableContainer.querySelectorAll(".TransactionAddress");
    this.Helper.addElementClickListenerByElement(TransactionAddress,this.openDialogBox);
  }

  async openDialogBox(event) {
    const TransactionAddress = event.currentTarget.querySelector('.transaction-viewdata-button').textContent

    const data = {
      TransactionAddress: TransactionAddress,
		}; 

    const helper = new Helper();
    const Ajax = new AjaxRequest(BaseURL);
		await Ajax.sendRequest(data, 'get transactions details')
			.then(responseData => {
				if (responseData.Success) {
          let Items = '';
          responseData.Parameters['Items'].forEach(element => {
            Items = Items + `
            <div class="item">
              <p class="name">${element.ItemName}</p>
              <p class="quantity">x${element.ItemQuantity}</p>
              <p class="price">₱ ${helper.formatNumber(element.ItemAmount * element.ItemQuantity)}</p>
            </div>
          `; }); 

          const layout = `
            <div class="Transaction-Details">
              <div class="details-header">
                <p class="title">Transaction Detailed Summary</p>
                <p class="TransactionType">${responseData.Parameters['Info']['TransactionType']}</p>
                <p class="Status">${responseData.Parameters['Info']['Status']}</p>
                <p class="Timestamp">${responseData.Parameters['Info']['Timestamp']}</p>
              </div>
              <hr>
              <div class="body-sender">
                <p class="Sender_Address"><a class="label">Sender Address: </a> ${responseData.Parameters['Info']['Sender_Address']}</p>
                <p class="SenderName"><a class="label">Sender Name: </a> ${responseData.Parameters['Info']['Sender_Firstname']} ${responseData.Parameters['Info']['Sender_Lastname']}</p>
              </div>
              <p>------- To ------</p>
              <div class="body-receiver">
                <p class="Receiver_Address"><a class="label">Receiver Address: </a> ${responseData.Parameters['Info']['Receiver_Address']}</p>
                <p class="ReceiverName"><a class="label">Receiver Name: </a> ${responseData.Parameters['Info']['Receiver_Firstname']} ${responseData.Parameters['Info']['Receiver_Lastname']}</p>
              </div>
              <hr>
              <div class="details-footer">
                <p class="PostedBy"><a class="label">Posted By: </a>${responseData.Parameters['Info']['PostedBy']}</p>
                ${responseData.Parameters['Info']['Amount'] !== responseData.Parameters['Info']['TotalAmount'] ? `<p class="Amount"><a class="label">Amount: ₱ </a>${helper.formatNumber(responseData.Parameters['Info']['Amount'])}</p>` : ''}
                ${responseData.Parameters['Info']['Amount'] !== responseData.Parameters['Info']['TotalAmount'] ? `<p class="Discount"><a class="label">Discount: ₱ </a>${helper.formatNumber(responseData.Parameters['Info']['Discount'])}</p>` : ''}
                <p class="TotalAmount"><a class="label">Total Amount: </a>₱  ${helper.formatNumber(responseData.Parameters['Info']['TotalAmount'])}</p>
                ${responseData.Parameters['Info']['PaymentMethod'] !== null && responseData.Parameters['Info']['PaymentMethod'] !== undefined ? `<p class="PaymentMethod"><a class="label">Payment Method: </a>${responseData.Parameters['Info']['PaymentMethod']}</p>` : ''}
              </div>
              <hr>
              <div class="details-message">
                <p class="Message"><a class="label">Note: </a> ${responseData.Parameters['Info']['Notes'] ?? ""}</p>
              </div>
              <hr>
              <div class="details-items">
                ${Items}
              </div>
            </div>
          `;
          makeModal('Modal', 'Transaction Details', layout);
				}
			})
  }

}