import { makeModal } from './modals.js';

export default class Accounts {
  constructor(type, tableHeader, tableBody, queryContainer) {
    this.allAccounts = [];
    this.users = [];
    this.merchants = [];
    this.merchantStaffs = [];
    this.accounting = [];
    this.administrators = [];
    this.parentalAccounts = [];
    this.type = type;
    this.tableHeader = tableHeader;
    this.tableBody = tableBody;
    this.queryContainer = queryContainer;
  }

  getType(button){
    if (button.parentNode.parentNode.dataset.type === undefined) {
      return "none";
    }
    return button.parentNode.parentNode.dataset.type;
  }

  fetchAccount(type,filter){

  }

  getAccountData(type, id){

  }

  getAllAccounts(button){
    const filter = getType(button);
    this.fetchAccount("all",filter);
    return this.allAccounts;
  }

  getUsers(button) {
    const filter = getType(button);
    this.fetchAccount("users",filter);
    return this.users;
  }

  getMerchants(button) {
    const filter = getType(button);
    this.fetchAccount("merchants",filter);
    return this.merchants;
  }

  getMerchantStaffs(button) {
    const filter = getType(button);
    this.fetchAccount("merchantStaffs",filter);
    return this.merchantStaffs;
  }

  getAccounting(button) {
    const filter = getType(button);
    this.fetchAccount("accounting",filter);
    return this.accounting;
  }

  getAdministrators(button) {
    const filter = getType(button);
    this.fetchAccount("administrators",filter);
    return this.administrators;
  }

  getParentalAccounts(button) {
    const filter = getType(button);
    this.fetchAccount("parentalAccounts",filter);
    return this.parentalAccounts;
  }

  test(){
    const list = [
      {
        "Status": "Active",
        "User Id": "mrstf-2314124",
        "Username": "SophiaMiller.132",
        "Firstname": "Sophia",
        "Lastname": "Miller",
        "category": "Canteen",
      },
      {
        "Status": "Not Active",
        "User Id": "mrstf-2314124",
        "Username": "SophiaMiller.132",
        "Firstname": "Sophia",
        "Lastname": "Miller",
        "category": "Canteen",
      },
      {
        "Status": "Not Active",
        "User Id": "mrstf-2314124",
        "Username": "SophiaMiller.132",
        "Firstname": "Sophia",
        "Lastname": "Miller",
        "category": "Canteen",
      },
      {
        "Status": "Active",
        "User Id": "mrstf-2314124",
        "Username": "SophiaMiller.132",
        "Firstname": "Sophia",
        "Lastname": "Miller",
        "category": "Canteen",
      },
      {
        "Status": "Active",
        "User Id": "mrstf-2314124",
        "Username": "SophiaMiller.132",
        "Firstname": "Sophia",
        "Lastname": "Miller",
        "category": "Canteen",
      }];

    return list;
  }


  refreshTable(button){
    switch (this.type) {
      case "all": 
        //this.getAllAccounts(button);
        break;
      case "users": 
        //this.getUsers(button);
        break;
      case "merchants":
       // this.getMerchants(button);
        break;
      case "merchantStaffs":
        this.merchantStaffs = this.test();
        //this.getMerchantStaffs(button);
        break;
      case "accounting":
       // this.getAccounting(button);
        break;
      case "administrators":
       // this.getAdministrators(button);
        break;
      case "parentalAccounts":
      //  this.getParentalAccounts(button);
        break;
      default:
        break;
    }
    this.displayTableView();
  }


  getTableBodyView(list){
    let view = ``;
    let num = 0;

    if (
      this.type === "merchantStaffs"
      ) {
        list.forEach(element => {
        num++,
        view = view + `
          <tr class="table-row curson-pointer" data-userid="`+ element['User Id'] +`">
            <td class="col1">
              <div class="cell">
                <div><p>`+ num +`</p></div>
                <div><p class="`+ element['Status'].replace(new RegExp(" ", 'g'), '').toLowerCase() +`">`+ element['Status'] +`</p></div>
                <div><p>`+ element['User Id'] +`</p></div>
                <div><p>`+ element['Username'] +`</p> </div>
                <div><p>`+ element['Firstname'] +`</p></div>
                <div><p>`+ element['Lastname'] +`</p></div>
              </div>
            </td>
          </tr>
        `;
      });

    } else if (
        this.type === "users" || 
        this.type === "merchants" ||
        this.type === "accounting" ||
        this.type === "administrators" ||
        this.type === "parentalAccounts"
      ) {
        list.forEach(element => {
          num++,
          view = view + `
            
          `;
        });
    } else if (
      this.type === "all"
    ) {
      list.forEach(element => {
        num++,
        view = view + `
          
        `;
      });
    }
    return view;
  }

  getTableHeaderView(){
    let view = ``;
    if (
      this.type === "merchantStaffs"
      ) {
        view = view + `
          <tr>
            <th class="col1">
              <div class="cell">
                <div><p>#</p></div>
                <div><p>Status</p></div>
                <div><p>UserId</p></div>
                <div><p>Username</p> </div>
                <div><p>Firstname</p></div>
                <div><p>Lastname</p></div>
              </div>
            </th>
          </tr>
        `;
    } else if (
        this.type === "all" || 
        this.type === "users" || 
        this.type === "merchants" ||
        this.type === "accounting" ||
        this.type === "administrators" ||
        this.type === "parentalAccounts"
      ) {
        view = view + `
          <tr>
            <th class="col1">
              <div class="cell">
                <div><p>#</p></div>
                <div><p>Account ID</p></div>
                <div><p>Status</p></div>
                <div><p>Category</p> </div>
                <div><p>Username</p></div>
                <div><p>Firstname</p></div>
                <div><p>Lastname</p></div>
                <div><p>Email</p></div>
                <div><p>Campus</p></div>
                <div><p>Group</p></div>
                <div><p>Department</p></div>
                <div><p>Course</p></div>
                <div><p>Last Seen</p></div>
              </div>
            </th>
          </tr>
        `;
    } 
     
    return view;
  }


  displayTableView(){
    switch (this.type) {
      case "all": 
        this.tableHeader.innerHTML = this.getTableHeaderView();
        this.tableBody.innerHTML = this.getTableBodyView(this.allAccounts);
        break;

      case "users": 
        this.tableHeader.innerHTML = this.getTableHeaderView();
        this.tableBody.innerHTML = this.getTableBodyView(this.users);
        break;

      case "merchants":
        this.tableHeader.innerHTML = this.getTableHeaderView();
        this.tableBody.innerHTML = this.getTableBodyView(this.merchants);
        break;

      case "merchantStaffs":
        this.tableHeader.innerHTML = this.getTableHeaderView();
        this.tableBody.innerHTML = this.getTableBodyView(this.merchantStaffs);
        break;

      case "accounting":
        this.tableHeader.innerHTML = this.getTableHeaderView();
        this.tableBody.innerHTML = this.getTableBodyView(this.accounting);
        break;

      case "administrators":
        this.tableHeader.innerHTML = this.getTableHeaderView();
        this.tableBody.innerHTML = this.getTableBodyView(this.administrators);
        break;

      case "parentalAccounts":
        this.tableHeader.innerHTML = this.getTableHeaderView();
        this.tableBody.innerHTML = this.getTableBodyView(this.parentalAccounts);
        break;

      default:
        break;
    }

    this.bindRowEventListener();
  }

  displayAccountDetails(accountId){
    makeModal("Modal", "ferreter", "dasdsadasa");
  }


  bindRowEventListener(){
    const rows = this.tableBody.querySelectorAll(".table-row");
    if (rows.length > 0) {
      rows.forEach((element) => {
      //  const accountId = element.dataset.userid
        element.addEventListener('click', () => this.displayAccountDetails("accountId"));
      });
    }
  }


  // Other methods for adding, editing, deleting accounts, etc.


  applyAccountsQuery(event){
    const value = event.currentTarget;
    this.refreshTable(value);
  }

  clearAccountsQuery(event){
    this.tableBody ? this.tableBody.innerHTML = "" : '';

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