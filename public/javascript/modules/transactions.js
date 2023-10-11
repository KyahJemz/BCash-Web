
// MODULE
// TRANSACTIONS

export default class Transactions {

  constructor(tableContainer,queryContainer) {
    this.totalOrders = 0;
    this.totalSales = 0;
    this.totalRecords = 0;
    this.data = [];
    this.tableContainer = tableContainer;
    this.queryContainer = queryContainer;
  }

  refreshSummay (){
    this.totalOrders = 0;
    this.totalSales = 0;
    this.totalRecords = 0;

    this.data.forEach(element => {
      this.totalRecords++;
      this.totalOrders++;
      this.totalSales = Number(this.totalSales) + Number(element.Amount);
    });
    console.log(this.totalOrders,this.totalSales,this.totalRecords);
  }

  getTotalRecords (){
    this.refreshSummay ();
    return this.totalRecords;
  }

  getTotalOrders (){
    this.refreshSummay ();
    return this.totalOrders;
  }

  getTotalSales (){
    this.refreshSummay ();
    return this.totalSales;
  }

  getData (){
    return this.data;
  }

  getTransactionsData(){
    this.data = [
        {
          "Transaction ID": "246810",
          "Status": "Completed",
          "In Charge": "Robert Johnson",
          "Name": "Sophia Miller",
          "Category": "Home Decor",
          "Department": "Operations",
          "Course": "N/A",
          "Amount": "150.50",
          "Items": "Table Lamp, Cushions",
          "Timestamp": "2023-07-15 12:20:00",
          "Payment Method": "Debit Card",
          "Notes": "Delivery address updated"
        },

    ];
    // fire ajax request

    return this.data;
  }

  getTransactionDetails(){

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

  applyTransactionsQueries(event){
    
    this.getTransactionsData();
    this.getTotalSales ();
    this.displayTransactionsToTable();
  }

  displayTransactionsToTable(){
    let template = ``;
    let count = 0;
    console.log(this.data);
    if (this.data) {
        this.data.forEach((record) => {  
            count++;
            template = template + `
            <tr>
                <td><div class="col1 cell" title="checkbox"><input class="transactionCheckbox" type="checkbox" name="`+record["Transaction ID"]+`" id=""></div></td>
                <td><div class="col2 cell" title="`+count+`"><center>`+count+`</center></div></td>
                <td><div class="col3 cell" title="`+record["Transaction ID"]+`"><a class="transaction-viewdata-button view-more" href="">`+record["Transaction ID"]+`</a></div></td>
                <td><div class="col4 cell" title="`+record["Status"]+`">`+record["Status"]+`</div></td>
                <td><div class="col5 cell" title="`+record["In Charge"]+`">`+record["In Charge"]+`</div></td>
                <td><div class="col6 cell" title="`+record["Name"]+`">`+record["Name"]+`</div></td>
                <td><div class="col7 cell" title="`+record["Category"]+`">`+record["Category"]+`</div></td>
                <td><div class="col8 cell" title="`+record["Department"]+`">`+record["Department"]+`</div></td>
                <td><div class="col9 cell" title="`+record["Course"]+`">`+record["Course"]+`</div></td>
                <td><div class="col10 cell" title="`+record["Amount"]+`">`+record["Amount"]+`</div></td>
                <td><div class="col11 cell" title="`+record["Items"]+`">`+record["Items"]+`</div></td>
                <td><div class="col12 cell" title="`+record["Timestamp"]+`">`+record["Timestamp"]+`</div></td>
                <td><div class="col13 cell" title=`+record["Payment Method"]+`">`+record["Payment Method"]+`</div></td>
                <td><div class="col14 cell" title="`+record["Notes"]+`">`+record["Notes"]+`</div></td>
            </tr>       
        `
        });
    }
    
    this.tableContainer.innerHTML = template;

  }

}