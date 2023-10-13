
// MODULE
// TRANSACTIONS

import { makeModal } from './modals.js';
import AjaxRequest from '../ajax.js';

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

    if (this.queryContainer) {
      const queryList = this.queryContainer.querySelectorAll(".query");

      queryList.forEach(element => {
        element.classList.contains("inputdate") ? element.value = "" : '';
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
				console.log('Response ssss:', responseData);
				if (responseData.Success) {
          this.data = responseData.Parameters;
          this.displayTransactionsToTable();
				}
			})
			.catch(error => {
				console.error('Request Error:', error);
			});
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
    let template = ``;
    let count = 0;
    if (this.data) {
        this.data.forEach((record) => {  
            count++;
            template = template + `
            <tr>
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
                <td><div class="col14 cell" title="`+record["Message"]+`">`+record["Message"]+`</div></td>
            </tr>       
        `
        });
    }
    this.tableContainer.innerHTML = template;
    const TransactionAddress = this.tableContainer.querySelectorAll(".TransactionAddress");
    this.Helper.addElementClickListenerByElement(TransactionAddress,this.openDialogBox);
  }

  async openDialogBox(event) {
    const TransactionAddress = event.currentTarget.querySelector('.transaction-viewdata-button').textContent
    console.log(TransactionAddress);

// Amount
// Discount
// DiscountReason
// PostedBy
// Receiver_Address
// Receiver_Campus_Id
// Receiver_Email
// Receiver_Firstname
// Receiver_Lastname
// Receiver_SchoolPersonalId
// Sender_Address
// Sender_Email
// Sender_Firstname
// Sender_Lastname
// Status
// Timestamp
// TotalAmount
// TransactionType
// TransactionType_Id
// Transaction_Address
// sender_Campus_Id
// sender_SchoolPersonalId

    const data = {
      TransactionAddress: TransactionAddress,
		}; 

    const Ajax = new AjaxRequest(BaseURL);
		await Ajax.sendRequest(data, 'get transactions details')
			.then(responseData => {
				console.log('Response Details:', responseData);
				if (responseData.Success) {
          const layout = `
            <div class="Transaction-Details">
              <div class="details-header">
                <p class="title">Transaction Detailed Summary</p>
                <p class="TransactionType">${responseData.Parameters['TransactionType']}</p>
                <p class="Status">${responseData.Parameters['Status']}</p>
                <p class="Timestamp">${responseData.Parameters['Timestamp']}</p>
              </div>
              <hr>
              <div class="body-sender">
                <p class="Sender_Address"><a class="label">Sender Address: </a> ${responseData.Parameters['Sender_Address']}</p>
                <p class="SenderName"><a class="label">Sender Name: </a> ${responseData.Parameters['Sender_Firstname']} ${responseData.Parameters['Sender_Lastname']}</p>
              </div>
              <p>------- To ------</p>
              <div class="body-receiver">
                <p class="Receiver_Address"><a class="label">Receiver Address: </a> ${responseData.Parameters['Receiver_Address']}</p>
                <p class="ReceiverName"><a class="label">Receiver Name: </a> ${responseData.Parameters['Receiver_Firstname']} ${responseData.Parameters['Receiver_Lastname']}</p>
              </div>
              <hr>
              <div class="details-footer">
                <p class="PostedBy"><a class="label">Posted By: </a>${responseData.Parameters['PostedBy']}</p>
                ${responseData.Parameters['Amount'] !== responseData.Parameters['TotalAmount'] ? `<p class="Amount"><a class="label">Amount: </a>${responseData.Parameters['Amount']}</p>` : ''}
                ${responseData.Parameters['Amount'] !== responseData.Parameters['TotalAmount'] ? `<p class="Discount"><a class="label">Discount: </a>${responseData.Parameters['Discount']}</p>` : ''}
                ${responseData.Parameters['Amount'] !== responseData.Parameters['TotalAmount'] ? `<p class="DiscountReason"><a class="label">Discount Reason: </a>${responseData.Parameters['DiscountReason']}</p>` : ''}
                ${responseData.Parameters['PaymentMethod'] !== null && responseData.Parameters['PaymentMethod'] !== undefined ? `<p class="PaymentMethod"><a class="label">Payment Method: </a>${responseData.Parameters['PaymentMethod']}</p>` : ''}
                <p class="TotalAmount"><a class="label">Total Amount: </a> ${responseData.Parameters['TotalAmount']}</p>
              </div>
              <hr>
              <div class="details-message">
                <p class="Message"><a class="label">Note: </a> ${responseData.Parameters['Message']}</p>
              </div>
              <hr>
              <div class="details-items">

              </div>
            </div>
          `;
          makeModal('Modal', 'Transaction Details', layout);
				}
			})
			.catch(error => {
				console.error('Request Error:', error);
			});
  }

}