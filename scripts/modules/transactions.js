
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
        {
          "Transaction ID": "135791",
          "Status": "Pending",
          "In Charge": "Jennifer Brown",
          "Name": "Daniel Anderson",
          "Category": "Sports",
          "Department": "Sales",
          "Course": "N/A",
          "Amount": "85.00",
          "Items": "Football, Water Bottle",
          "Timestamp": "2023-07-15 11:10:00",
          "Payment Method": "Cash",
          "Notes": "None"
        },
        {
          "Transaction ID": "102938",
          "Status": "Completed",
          "In Charge": "Michael Wilson",
          "Name": "Olivia Johnson",
          "Category": "Beauty",
          "Department": "Marketing",
          "Course": "N/A",
          "Amount": "65.25",
          "Items": "Makeup Kit, Face Cream",
          "Timestamp": "2023-07-15 15:55:00",
          "Payment Method": "Credit Card",
          "Notes": "Gift wrapping requested"
        },
        {
          "Transaction ID": "753159",
          "Status": "Pending",
          "In Charge": "Emily Davis",
          "Name": "James Smith",
          "Category": "Clothing",
          "Department": "Operations",
          "Course": "N/A",
          "Amount": "120.00",
          "Items": "T-Shirt, Jeans",
          "Timestamp": "2023-07-15 16:30:00",
          "Payment Method": "PayPal",
          "Notes": "None"
        },
        {
          "Transaction ID": "864209",
          "Status": "Completed",
          "In Charge": "David Wilson",
          "Name": "Emma Anderson",
          "Category": "Electronics",
          "Department": "Sales",
          "Course": "N/A",
          "Amount": "450.00",
          "Items": "Smartwatch, Earphones",
          "Timestamp": "2023-07-15 13:05:00",
          "Payment Method": "Debit Card",
          "Notes": "None"
        },
        {
          "Transaction ID": "314159",
          "Status": "Pending",
          "In Charge": "Sophia Miller",
          "Name": "Alexander Brown",
          "Category": "Books",
          "Department": "Marketing",
          "Course": "N/A",
          "Amount": "28.75",
          "Items": "Thriller Novel, Bookmark",
          "Timestamp": "2023-07-15 10:40:00",
          "Payment Method": "Credit Card",
          "Notes": "None"
        },
        {
          "Transaction ID": "567890",
          "Status": "Completed",
          "In Charge": "Daniel Anderson",
          "Name": "Ava Johnson",
          "Category": "Home Appliances",
          "Department": "Operations",
          "Course": "N/A",
          "Amount": "280.50",
          "Items": "Refrigerator, Microwave",
          "Timestamp": "2023-07-15 14:00:00",
          "Payment Method": "Cash",
          "Notes": "Installation required"
        },
        {
          "Transaction ID": "975310",
          "Status": "Pending",
          "In Charge": "Olivia Johnson",
          "Name": "William Davis",
          "Category": "Toys",
          "Department": "Sales",
          "Course": "N/A",
          "Amount": "60.25",
          "Items": "Action Figures, Puzzle",
          "Timestamp": "2023-07-15 11:30:00",
          "Payment Method": "PayPal",
          "Notes": "None"
        },
        {
          "Transaction ID": "456789",
          "Status": "Completed",
          "In Charge": "James Smith",
          "Name": "Ella Brown",
          "Category": "Beauty",
          "Department": "Marketing",
          "Course": "N/A",
          "Amount": "95.00",
          "Items": "Perfume, Lipstick",
          "Timestamp": "2023-07-15 15:15:00",
          "Payment Method": "Credit Card",
          "Notes": "None"
        },
        {
          "Transaction ID": "789012",
          "Status": "Pending",
          "In Charge": "Emma Anderson",
          "Name": "Noah Wilson",
          "Category": "Clothing",
          "Department": "Operations",
          "Course": "N/A",
          "Amount": "150.00",
          "Items": "Dress, Shoes",
          "Timestamp": "2023-07-15 16:00:00",
          "Payment Method": "Debit Card",
          "Notes": "None"
        },
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
          {
            "Transaction ID": "135791",
            "Status": "Pending",
            "In Charge": "Jennifer Brown",
            "Name": "Daniel Anderson",
            "Category": "Sports",
            "Department": "Sales",
            "Course": "N/A",
            "Amount": "85.00",
            "Items": "Football, Water Bottle",
            "Timestamp": "2023-07-15 11:10:00",
            "Payment Method": "Cash",
            "Notes": "None"
          },
          {
            "Transaction ID": "102938",
            "Status": "Completed",
            "In Charge": "Michael Wilson",
            "Name": "Olivia Johnson",
            "Category": "Beauty",
            "Department": "Marketing",
            "Course": "N/A",
            "Amount": "65.25",
            "Items": "Makeup Kit, Face Cream",
            "Timestamp": "2023-07-15 15:55:00",
            "Payment Method": "Credit Card",
            "Notes": "Gift wrapping requested"
          },
          {
            "Transaction ID": "753159",
            "Status": "Pending",
            "In Charge": "Emily Davis",
            "Name": "James Smith",
            "Category": "Clothing",
            "Department": "Operations",
            "Course": "N/A",
            "Amount": "120.00",
            "Items": "T-Shirt, Jeans",
            "Timestamp": "2023-07-15 16:30:00",
            "Payment Method": "PayPal",
            "Notes": "None"
          },
          {
            "Transaction ID": "864209",
            "Status": "Completed",
            "In Charge": "David Wilson",
            "Name": "Emma Anderson",
            "Category": "Electronics",
            "Department": "Sales",
            "Course": "N/A",
            "Amount": "450.00",
            "Items": "Smartwatch, Earphones",
            "Timestamp": "2023-07-15 13:05:00",
            "Payment Method": "Debit Card",
            "Notes": "None"
          },
          {
            "Transaction ID": "314159",
            "Status": "Pending",
            "In Charge": "Sophia Miller",
            "Name": "Alexander Brown",
            "Category": "Books",
            "Department": "Marketing",
            "Course": "N/A",
            "Amount": "28.75",
            "Items": "Thriller Novel, Bookmark",
            "Timestamp": "2023-07-15 10:40:00",
            "Payment Method": "Credit Card",
            "Notes": "None"
          },
          {
            "Transaction ID": "567890",
            "Status": "Completed",
            "In Charge": "Daniel Anderson",
            "Name": "Ava Johnson",
            "Category": "Home Appliances",
            "Department": "Operations",
            "Course": "N/A",
            "Amount": "280.50",
            "Items": "Refrigerator, Microwave",
            "Timestamp": "2023-07-15 14:00:00",
            "Payment Method": "Cash",
            "Notes": "Installation required"
          },
          {
            "Transaction ID": "975310",
            "Status": "Pending",
            "In Charge": "Olivia Johnson",
            "Name": "William Davis",
            "Category": "Toys",
            "Department": "Sales",
            "Course": "N/A",
            "Amount": "60.25",
            "Items": "Action Figures, Puzzle",
            "Timestamp": "2023-07-15 11:30:00",
            "Payment Method": "PayPal",
            "Notes": "None"
          },
          {
            "Transaction ID": "456789",
            "Status": "Completed",
            "In Charge": "James Smith",
            "Name": "Ella Brown",
            "Category": "Beauty",
            "Department": "Marketing",
            "Course": "N/A",
            "Amount": "95.00",
            "Items": "Perfume, Lipstick",
            "Timestamp": "2023-07-15 15:15:00",
            "Payment Method": "Credit Card",
            "Notes": "None"
          },
          {
            "Transaction ID": "789012",
            "Status": "Pending",
            "In Charge": "Emma Anderson",
            "Name": "Noah Wilson",
            "Category": "Clothing",
            "Department": "Operations",
            "Course": "N/A",
            "Amount": "150.00",
            "Items": "Dress, Shoes",
            "Timestamp": "2023-07-15 16:00:00",
            "Payment Method": "Debit Card",
            "Notes": "None"
          },
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
          {
            "Transaction ID": "135791",
            "Status": "Pending",
            "In Charge": "Jennifer Brown",
            "Name": "Daniel Anderson",
            "Category": "Sports",
            "Department": "Sales",
            "Course": "N/A",
            "Amount": "85.00",
            "Items": "Football, Water Bottle",
            "Timestamp": "2023-07-15 11:10:00",
            "Payment Method": "Cash",
            "Notes": "None"
          },
          {
            "Transaction ID": "102938",
            "Status": "Completed",
            "In Charge": "Michael Wilson",
            "Name": "Olivia Johnson",
            "Category": "Beauty",
            "Department": "Marketing",
            "Course": "N/A",
            "Amount": "65.25",
            "Items": "Makeup Kit, Face Cream",
            "Timestamp": "2023-07-15 15:55:00",
            "Payment Method": "Credit Card",
            "Notes": "Gift wrapping requested"
          },
          {
            "Transaction ID": "753159",
            "Status": "Pending",
            "In Charge": "Emily Davis",
            "Name": "James Smith",
            "Category": "Clothing",
            "Department": "Operations",
            "Course": "N/A",
            "Amount": "120.00",
            "Items": "T-Shirt, Jeans",
            "Timestamp": "2023-07-15 16:30:00",
            "Payment Method": "PayPal",
            "Notes": "None"
          },
          {
            "Transaction ID": "864209",
            "Status": "Completed",
            "In Charge": "David Wilson",
            "Name": "Emma Anderson",
            "Category": "Electronics",
            "Department": "Sales",
            "Course": "N/A",
            "Amount": "450.00",
            "Items": "Smartwatch, Earphones",
            "Timestamp": "2023-07-15 13:05:00",
            "Payment Method": "Debit Card",
            "Notes": "None"
          },
          {
            "Transaction ID": "314159",
            "Status": "Pending",
            "In Charge": "Sophia Miller",
            "Name": "Alexander Brown",
            "Category": "Books",
            "Department": "Marketing",
            "Course": "N/A",
            "Amount": "28.75",
            "Items": "Thriller Novel, Bookmark",
            "Timestamp": "2023-07-15 10:40:00",
            "Payment Method": "Credit Card",
            "Notes": "None"
          },
          {
            "Transaction ID": "567890",
            "Status": "Completed",
            "In Charge": "Daniel Anderson",
            "Name": "Ava Johnson",
            "Category": "Home Appliances",
            "Department": "Operations",
            "Course": "N/A",
            "Amount": "280.50",
            "Items": "Refrigerator, Microwave",
            "Timestamp": "2023-07-15 14:00:00",
            "Payment Method": "Cash",
            "Notes": "Installation required"
          },
          {
            "Transaction ID": "975310",
            "Status": "Pending",
            "In Charge": "Olivia Johnson",
            "Name": "William Davis",
            "Category": "Toys",
            "Department": "Sales",
            "Course": "N/A",
            "Amount": "60.25",
            "Items": "Action Figures, Puzzle",
            "Timestamp": "2023-07-15 11:30:00",
            "Payment Method": "PayPal",
            "Notes": "None"
          },
          {
            "Transaction ID": "456789",
            "Status": "Completed",
            "In Charge": "James Smith",
            "Name": "Ella Brown",
            "Category": "Beauty",
            "Department": "Marketing",
            "Course": "N/A",
            "Amount": "95.00",
            "Items": "Perfume, Lipstick",
            "Timestamp": "2023-07-15 15:15:00",
            "Payment Method": "Credit Card",
            "Notes": "None"
          },
          {
            "Transaction ID": "789012",
            "Status": "Pending",
            "In Charge": "Emma Anderson",
            "Name": "Noah Wilson",
            "Category": "Clothing",
            "Department": "Operations",
            "Course": "N/A",
            "Amount": "150.00",
            "Items": "Dress, Shoes",
            "Timestamp": "2023-07-15 16:00:00",
            "Payment Method": "Debit Card",
            "Notes": "None"
          },
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
          {
            "Transaction ID": "135791",
            "Status": "Pending",
            "In Charge": "Jennifer Brown",
            "Name": "Daniel Anderson",
            "Category": "Sports",
            "Department": "Sales",
            "Course": "N/A",
            "Amount": "85.00",
            "Items": "Football, Water Bottle",
            "Timestamp": "2023-07-15 11:10:00",
            "Payment Method": "Cash",
            "Notes": "None"
          },
          {
            "Transaction ID": "102938",
            "Status": "Completed",
            "In Charge": "Michael Wilson",
            "Name": "Olivia Johnson",
            "Category": "Beauty",
            "Department": "Marketing",
            "Course": "N/A",
            "Amount": "65.25",
            "Items": "Makeup Kit, Face Cream",
            "Timestamp": "2023-07-15 15:55:00",
            "Payment Method": "Credit Card",
            "Notes": "Gift wrapping requested"
          },
          {
            "Transaction ID": "753159",
            "Status": "Pending",
            "In Charge": "Emily Davis",
            "Name": "James Smith",
            "Category": "Clothing",
            "Department": "Operations",
            "Course": "N/A",
            "Amount": "120.00",
            "Items": "T-Shirt, Jeans",
            "Timestamp": "2023-07-15 16:30:00",
            "Payment Method": "PayPal",
            "Notes": "None"
          },
          {
            "Transaction ID": "864209",
            "Status": "Completed",
            "In Charge": "David Wilson",
            "Name": "Emma Anderson",
            "Category": "Electronics",
            "Department": "Sales",
            "Course": "N/A",
            "Amount": "450.00",
            "Items": "Smartwatch, Earphones",
            "Timestamp": "2023-07-15 13:05:00",
            "Payment Method": "Debit Card",
            "Notes": "None"
          },
          {
            "Transaction ID": "314159",
            "Status": "Pending",
            "In Charge": "Sophia Miller",
            "Name": "Alexander Brown",
            "Category": "Books",
            "Department": "Marketing",
            "Course": "N/A",
            "Amount": "28.75",
            "Items": "Thriller Novel, Bookmark",
            "Timestamp": "2023-07-15 10:40:00",
            "Payment Method": "Credit Card",
            "Notes": "None"
          },
          {
            "Transaction ID": "567890",
            "Status": "Completed",
            "In Charge": "Daniel Anderson",
            "Name": "Ava Johnson",
            "Category": "Home Appliances",
            "Department": "Operations",
            "Course": "N/A",
            "Amount": "280.50",
            "Items": "Refrigerator, Microwave",
            "Timestamp": "2023-07-15 14:00:00",
            "Payment Method": "Cash",
            "Notes": "Installation required"
          },
          {
            "Transaction ID": "975310",
            "Status": "Pending",
            "In Charge": "Olivia Johnson",
            "Name": "William Davis",
            "Category": "Toys",
            "Department": "Sales",
            "Course": "N/A",
            "Amount": "60.25",
            "Items": "Action Figures, Puzzle",
            "Timestamp": "2023-07-15 11:30:00",
            "Payment Method": "PayPal",
            "Notes": "None"
          },
          {
            "Transaction ID": "456789",
            "Status": "Completed",
            "In Charge": "James Smith",
            "Name": "Ella Brown",
            "Category": "Beauty",
            "Department": "Marketing",
            "Course": "N/A",
            "Amount": "95.00",
            "Items": "Perfume, Lipstick",
            "Timestamp": "2023-07-15 15:15:00",
            "Payment Method": "Credit Card",
            "Notes": "None"
          },
          {
            "Transaction ID": "789012",
            "Status": "Pending",
            "In Charge": "Emma Anderson",
            "Name": "Noah Wilson",
            "Category": "Clothing",
            "Department": "Operations",
            "Course": "N/A",
            "Amount": "150.00",
            "Items": "Dress, Shoes",
            "Timestamp": "2023-07-15 16:00:00",
            "Payment Method": "Debit Card",
            "Notes": "None"
          },
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
          {
            "Transaction ID": "135791",
            "Status": "Pending",
            "In Charge": "Jennifer Brown",
            "Name": "Daniel Anderson",
            "Category": "Sports",
            "Department": "Sales",
            "Course": "N/A",
            "Amount": "85.00",
            "Items": "Football, Water Bottle",
            "Timestamp": "2023-07-15 11:10:00",
            "Payment Method": "Cash",
            "Notes": "None"
          },
          {
            "Transaction ID": "102938",
            "Status": "Completed",
            "In Charge": "Michael Wilson",
            "Name": "Olivia Johnson",
            "Category": "Beauty",
            "Department": "Marketing",
            "Course": "N/A",
            "Amount": "65.25",
            "Items": "Makeup Kit, Face Cream",
            "Timestamp": "2023-07-15 15:55:00",
            "Payment Method": "Credit Card",
            "Notes": "Gift wrapping requested"
          },
          {
            "Transaction ID": "753159",
            "Status": "Pending",
            "In Charge": "Emily Davis",
            "Name": "James Smith",
            "Category": "Clothing",
            "Department": "Operations",
            "Course": "N/A",
            "Amount": "120.00",
            "Items": "T-Shirt, Jeans",
            "Timestamp": "2023-07-15 16:30:00",
            "Payment Method": "PayPal",
            "Notes": "None"
          },
          {
            "Transaction ID": "864209",
            "Status": "Completed",
            "In Charge": "David Wilson",
            "Name": "Emma Anderson",
            "Category": "Electronics",
            "Department": "Sales",
            "Course": "N/A",
            "Amount": "450.00",
            "Items": "Smartwatch, Earphones",
            "Timestamp": "2023-07-15 13:05:00",
            "Payment Method": "Debit Card",
            "Notes": "None"
          },
          {
            "Transaction ID": "314159",
            "Status": "Pending",
            "In Charge": "Sophia Miller",
            "Name": "Alexander Brown",
            "Category": "Books",
            "Department": "Marketing",
            "Course": "N/A",
            "Amount": "28.75",
            "Items": "Thriller Novel, Bookmark",
            "Timestamp": "2023-07-15 10:40:00",
            "Payment Method": "Credit Card",
            "Notes": "None"
          },
          {
            "Transaction ID": "567890",
            "Status": "Completed",
            "In Charge": "Daniel Anderson",
            "Name": "Ava Johnson",
            "Category": "Home Appliances",
            "Department": "Operations",
            "Course": "N/A",
            "Amount": "280.50",
            "Items": "Refrigerator, Microwave",
            "Timestamp": "2023-07-15 14:00:00",
            "Payment Method": "Cash",
            "Notes": "Installation required"
          },
          {
            "Transaction ID": "975310",
            "Status": "Pending",
            "In Charge": "Olivia Johnson",
            "Name": "William Davis",
            "Category": "Toys",
            "Department": "Sales",
            "Course": "N/A",
            "Amount": "60.25",
            "Items": "Action Figures, Puzzle",
            "Timestamp": "2023-07-15 11:30:00",
            "Payment Method": "PayPal",
            "Notes": "None"
          },
          {
            "Transaction ID": "456789",
            "Status": "Completed",
            "In Charge": "James Smith",
            "Name": "Ella Brown",
            "Category": "Beauty",
            "Department": "Marketing",
            "Course": "N/A",
            "Amount": "95.00",
            "Items": "Perfume, Lipstick",
            "Timestamp": "2023-07-15 15:15:00",
            "Payment Method": "Credit Card",
            "Notes": "None"
          },
          {
            "Transaction ID": "789012",
            "Status": "Pending",
            "In Charge": "Emma Anderson",
            "Name": "Noah Wilson",
            "Category": "Clothing",
            "Department": "Operations",
            "Course": "N/A",
            "Amount": "150.00",
            "Items": "Dress, Shoes",
            "Timestamp": "2023-07-15 16:00:00",
            "Payment Method": "Debit Card",
            "Notes": "None"
          },
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
          {
            "Transaction ID": "135791",
            "Status": "Pending",
            "In Charge": "Jennifer Brown",
            "Name": "Daniel Anderson",
            "Category": "Sports",
            "Department": "Sales",
            "Course": "N/A",
            "Amount": "85.00",
            "Items": "Football, Water Bottle",
            "Timestamp": "2023-07-15 11:10:00",
            "Payment Method": "Cash",
            "Notes": "None"
          },
          {
            "Transaction ID": "102938",
            "Status": "Completed",
            "In Charge": "Michael Wilson",
            "Name": "Olivia Johnson",
            "Category": "Beauty",
            "Department": "Marketing",
            "Course": "N/A",
            "Amount": "65.25",
            "Items": "Makeup Kit, Face Cream",
            "Timestamp": "2023-07-15 15:55:00",
            "Payment Method": "Credit Card",
            "Notes": "Gift wrapping requested"
          },
          {
            "Transaction ID": "753159",
            "Status": "Pending",
            "In Charge": "Emily Davis",
            "Name": "James Smith",
            "Category": "Clothing",
            "Department": "Operations",
            "Course": "N/A",
            "Amount": "120.00",
            "Items": "T-Shirt, Jeans",
            "Timestamp": "2023-07-15 16:30:00",
            "Payment Method": "PayPal",
            "Notes": "None"
          },
          {
            "Transaction ID": "864209",
            "Status": "Completed",
            "In Charge": "David Wilson",
            "Name": "Emma Anderson",
            "Category": "Electronics",
            "Department": "Sales",
            "Course": "N/A",
            "Amount": "450.00",
            "Items": "Smartwatch, Earphones",
            "Timestamp": "2023-07-15 13:05:00",
            "Payment Method": "Debit Card",
            "Notes": "None"
          },
          {
            "Transaction ID": "314159",
            "Status": "Pending",
            "In Charge": "Sophia Miller",
            "Name": "Alexander Brown",
            "Category": "Books",
            "Department": "Marketing",
            "Course": "N/A",
            "Amount": "28.75",
            "Items": "Thriller Novel, Bookmark",
            "Timestamp": "2023-07-15 10:40:00",
            "Payment Method": "Credit Card",
            "Notes": "None"
          }
        // Additional entries...
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