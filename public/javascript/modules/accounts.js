import { makeModal } from './modals.js';

export default class Accounts {
  constructor(type, tableHeader, tableBody, queryContainer) {
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

  teststaffmerchant(){
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

  testusers(){
    const list = [
        {
            "Account ID": "ACC12345",
            "Status": "Active",
            "Category": "General",
            "Username": "user123",
            "Firstname": "John",
            "Lastname": "Doe",
            "Email": "john.doe@example.com",
            "Campus": "Main Campus",
            "Group": "Group A",
            "Department": "Computer Science",
            "Course": "Introduction to Programming",
            "Last Seen": "2023-08-16 10:30 AM"
        },
        {
            "Account ID": "ACC67890",
            "Status": "Inactive",
            "Category": "Library",
            "Username": "jane_smith",
            "Firstname": "Jane",
            "Lastname": "Smith",
            "Email": "jane.smith@example.com",
            "Campus": "North Campus",
            "Group": "Group B",
            "Department": "English Literature",
            "Course": "Shakespearean Studies",
            "Last Seen": "2023-08-15 3:45 PM"
        },
        {
            "Account ID": "ACC24680",
            "Status": "Active",
            "Category": "Canteen",
            "Username": "foodie123",
            "Firstname": "Alex",
            "Lastname": "Johnson",
            "Email": "alex.johnson@example.com",
            "Campus": "South Campus",
            "Group": "Group C",
            "Department": "Culinary Arts",
            "Course": "Gourmet Cuisine",
            "Last Seen": "2023-08-14 11:15 AM"
        },
        {
            "Account ID": "ACC13579",
            "Status": "Active",
            "Category": "Sports",
            "Username": "sporty88",
            "Firstname": "Michael",
            "Lastname": "Williams",
            "Email": "michael.williams@example.com",
            "Campus": "West Campus",
            "Group": "Group D",
            "Department": "Physical Education",
            "Course": "Advanced Yoga",
            "Last Seen": "2023-08-14 4:30 PM"
        },
        {
            "Account ID": "ACC98765",
            "Status": "Inactive",
            "Category": "Arts",
            "Username": "artlover",
            "Firstname": "Emily",
            "Lastname": "Taylor",
            "Email": "emily.taylor@example.com",
            "Campus": "East Campus",
            "Group": "Group E",
            "Department": "Fine Arts",
            "Course": "Oil Painting Techniques",
            "Last Seen": "2023-08-15 1:20 PM"
        },
        {
            "Account ID": "ACC55555",
            "Status": "Active",
            "Category": "Music",
            "Username": "musicmaniac",
            "Firstname": "David",
            "Lastname": "Robinson",
            "Email": "david.robinson@example.com",
            "Campus": "Main Campus",
            "Group": "Group A",
            "Department": "Music Composition",
            "Course": "Jazz Improvisation",
            "Last Seen": "2023-08-16 9:00 AM"
        },
        {
            "Account ID": "ACC88888",
            "Status": "Active",
            "Category": "Science",
            "Username": "sciencewhiz",
            "Firstname": "Sarah",
            "Lastname": "Garcia",
            "Email": "sarah.garcia@example.com",
            "Campus": "North Campus",
            "Group": "Group B",
            "Department": "Physics",
            "Course": "Quantum Mechanics",
            "Last Seen": "2023-08-15 2:10 PM"
        },
        {
            "Account ID": "ACC77777",
            "Status": "Inactive",
            "Category": "Technology",
            "Username": "techgeek",
            "Firstname": "Daniel",
            "Lastname": "Lee",
            "Email": "daniel.lee@example.com",
            "Campus": "South Campus",
            "Group": "Group C",
            "Department": "Computer Engineering",
            "Course": "Advanced AI",
            "Last Seen": "2023-08-14 5:40 PM"
        }
    ];

    return list;
  }

  refreshTable(button){
    switch (this.type) {
      case "all": 
        //this.getAllAccounts(button);
        break;
      case "users": 
        this.users = this.testusers();
        //this.getUsers(button);
        break;
      case "merchants":
        this.merchants = this.testusers();
       // this.getMerchants(button);
        break;
      case "merchantStaffs":
        this.merchantStaffs = this.teststaffmerchant();
        //this.getMerchantStaffs(button);
        break;
      case "merchantStaffsView2":
        this.merchantStaffs = this.teststaffmerchant();
        //this.getMerchantStaffs(button);
        break;
      case "accounting":
        this.accounting = this.testusers();
       // this.getAccounting(button);
        break;
      case "administrators":
        this.administrators = this.testusers();
       // this.getAdministrators(button);
        break;
      case "parentalAccounts":
        this.parentalAccounts = this.testusers();
      //  this.getParentalAccounts(button);
        break;
      default:
        createAlert("danger","Invalid account type parameter");
        break;
    }
    console.log("132");
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
        this.type === "merchantStaffsView2" ||
        this.type === "accounting" ||
        this.type === "administrators" ||
        this.type === "parentalAccounts"
      ) {
        list.forEach(record => {
          num++,
          view = view + `
            <tr>
              <td><div class="col1 cell" title="`+num+`"><center>`+num+`</center></div></td>
              <td><div class="col2 cell" title="`+record["Account ID"]+`"><a class="account-viewdata-button view-more" href="">`+record["Account ID"]+`</a></div></td>
              <td><div class="col3 cell `+ record["Status"].replace(new RegExp(" ", 'g'), '').toLowerCase() +`" title="`+record["Status"]+`">`+record["Status"]+`</div></td>
              <td><div class="col4 cell" title="`+record["Category"]+`">`+record["Category"]+`</div></td>
              <td><div class="col5 cell" title="`+record["Username"]+`">`+record["Username"]+`</div></td>
              <td><div class="col6 cell" title="`+record["Firstname"]+`">`+record["Firstname"]+`</div></td>
              <td><div class="col7 cell" title="`+record["Lastname"]+`">`+record["Lastname"]+`</div></td>
              <td><div class="col8 cell" title="`+record["Email"]+`">`+record["Email"]+`</div></td>
              <td><div class="col9 cell" title="`+record["Campus"]+`">`+record["Campus"]+`</div></td>
              <td><div class="col10 cell" title="`+record["Group"]+`">`+record["Group"]+`</div></td>
              <td><div class="col11 cell" title="`+record["Department"]+`">`+record["Department"]+`</div></td>
              <td><div class="col12 cell" title=`+record["Course"]+`">`+record["Course"]+`</div></td>
              <td><div class="col13 cell" title="`+record["Last Seen"]+`">`+record["Last Seen"]+`</div></td>
            </tr>  
          `;
        });
    } else if (
      this.type === "all"
    ) {
      list.forEach(record => {
        num++,
        view = view + `
          <tr>
            <td><div class="col1 cell" title="`+num+`"><center>`+num+`</center></div></td>
            <td><div class="col2 cell" title="`+record["Account ID"]+`"><a class="account-viewdata-button view-more" href="">`+record["Account ID"]+`</a></div></td>
            <td><div class="col3 cell `+ record["Status"].replace(new RegExp(" ", 'g'), '').toLowerCase() +`" title="`+record["Status"]+`">`+record["Status"]+`</div></td>
            <td><div class="col4 cell" title="`+record["Category"]+`">`+record["Category"]+`</div></td>
            <td><div class="col5 cell" title="`+record["Username"]+`">`+record["Username"]+`</div></td>
            <td><div class="col6 cell" title="`+record["Firstname"]+`">`+record["Firstname"]+`</div></td>
            <td><div class="col7 cell" title="`+record["Lastname"]+`">`+record["Lastname"]+`</div></td>
            <td><div class="col8 cell" title="`+record["Email"]+`">`+record["Email"]+`</div></td>
            <td><div class="col9 cell" title="`+record["Campus"]+`">`+record["Campus"]+`</div></td>
            <td><div class="col10 cell" title="`+record["Group"]+`">`+record["Group"]+`</div></td>
            <td><div class="col11 cell" title="`+record["Department"]+`">`+record["Department"]+`</div></td>
            <td><div class="col12 cell" title=`+record["Course"]+`">`+record["Course"]+`</div></td>
            <td><div class="col13 cell" title="`+record["Last Seen"]+`">`+record["Last Seen"]+`</div></td>
          </tr>    
        `;
      });
    }
    return view;
  }

  getTableHeaderView() {
    let view = ``;
    if (
      this.type === "merchantStaffs"
      ) {
        view = view + `
          <tr>
            <th>
              <div class="col1 cell">
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
        this.type === "merchantStaffsView2" ||
        this.type === "accounting" ||
        this.type === "administrators" ||
        this.type === "parentalAccounts"
      ) {
        view = view + `
          <tr>
            <th><div class="col1">#</div></th>
            <th><div class="col2">Account ID</div></th>
            <th><div class="col3">Status</div></th>
            <th><div class="col4">Category</div></th>
            <th><div class="col5">Username</div></th>
            <th><div class="col6">Firstname</div></th>
            <th><div class="col7">Lastname</div></th>
            <th><div class="col8">Email</div></th>
            <th><div class="col9">Campus</div></th>
            <th><div class="col10">Group</div></th>
            <th><div class="col11">Department</div></th>
            <th><div class="col12">Course</div></th>
            <th><div class="col13">Last Seen</div></th>
          </tr>
        `;
    } 
    console.log(this.tableHeader);
    return view;
  }

  displayTableView(){
    switch (this.type) {
      case "all": 

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

      case "merchantStaffsView2":
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




  applyAccountsQuery(event){
    const value = event.currentTarget;
    this.refreshTable(value);
    this.displayTableView();
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