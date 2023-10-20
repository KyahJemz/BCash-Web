<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BCash - Administrator</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="<?php echo base_url('./public/css/styles.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('./public/css/dialog-box.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('./public/css/menu.css'); ?>">

    <link rel="stylesheet" href="<?php echo base_url('./public/css/administrator/transactions.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('./public/css/administrator/accounts.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('./public/css/administrator/cards.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('./public/css/administrator/configurations.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('./public/css/administrator/notifications.css'); ?>">
</head>

<body>


    <div class="design-background"></div>
    
<!--
    SIDEBAR
-->  
    <div class="sidebar-container">
        <div class="top-panel">
            <div class="image">
                <img src="../public/images/bcash-logo.png" alt="BCash Logo">
            </div>
            <div class="details">
                <div class="category">BCash: Administrator</div>
                <div id="WebAccountFullName" class="fullname">Loading...</div>
            </div>
            <div class="button-container">
                <button id="menu-notification-button" type="button" class="curson-pointer" title="Notifications"><img src="../public/images/icons/notification-yellow.png" alt="notification-icon"></button>
                <button id="menu-settings-button" type="button" class="curson-pointer" title="Settings"><img src="../public/images/icons/settings-yellow.png" alt="settings-icon"></button>
            </div>
        </div>
        <div class="bottom-panel">
            <div class="pattern"></div>
            <nav class="menu">
                <ul>
                    <li data-menu="Home" class="curson-pointer menu-selected menuSelectionButton">
                        <div class="selected"></div>
                        <img src="../public/images/icons/home.png" alt="Home Icon">
                        <p>Home</p>
                    </li>
                    <li data-menu="Transactions Management" class="curson-pointer menuSelectionButton menuSelectionDropdownButton">
                        <img src="../public/images/icons/longreceipt.png" alt="Transactions Icon">
                        <p>Transactions</p>
                        <img id="sidebar-bottom-menu-myorders-more" class="more" src="../public/images/icons/more.png" alt="More Icon">
                    </li>
                        <li class="menuSelectionDropdownItems">
                            <ul>
                                <li data-menu="All Transactions" class="curson-pointer menuSelectionButton">
                                    <div class="selected"></div>
                                    <p>All Transactions</p>
                                </li>
                            </ul>
                        </li>
                    <li data-menu="Accounts Management" class="curson-pointer menuSelectionButton menuSelectionDropdownButton">
                        <img src="../public/images/icons/accounts.png" alt="Transactions Icon">
                        <p>Accounts</p>
                        <img id="sidebar-bottom-menu-myorders-more" class="more" src="../public/images/icons/more.png" alt="More Icon">
                    </li>
                        <li class="menuSelectionDropdownItems">
                            <ul>
                                <li data-menu="User Accounts" class="curson-pointer menuSelectionButton">
                                    <div class="selected"></div>
                                    <p>User Accounts</p>
                                </li>
                                <!-- <li data-menu="Guest Accounts" class="curson-pointer menuSelectionButton">
                                    <div class="selected"></div>
                                    <p>Guest Accounts</p>
                                </li> -->
                                <li data-menu="Merchant Accounts" class="curson-pointer menuSelectionButton">
                                    <div class="selected"></div>
                                    <p>Merchant Accounts</p>
                                </li>
                                <li data-menu="Merchant Staffs Accounts" class="curson-pointer menuSelectionButton">
                                    <div class="selected"></div>
                                    <p>Merchant Staffs Accounts</p>
                                </li>
                                <li data-menu="Guardian Accounts" class="curson-pointer menuSelectionButton">
                                    <div class="selected"></div>
                                    <p>Guardian Accounts</p>
                                </li>
                                <li data-menu="Accounting Accounts" class="curson-pointer menuSelectionButton">
                                    <div class="selected"></div>
                                    <p>Accounting Accounts</p>
                                </li>
                                <li data-menu="Administrator Accounts" class="curson-pointer menuSelectionButton">
                                    <div class="selected"></div>
                                    <p>Administrator Accounts</p>
                                </li>
                                <li data-menu="Add Account" class="curson-pointer menuSelectionButton">
                                    <div class="selected"></div>
                                    <p>Add Account</p>
                                </li>
                            </ul>
                        </li>
                    <li data-menu="Cards Management" class="curson-pointer menuSelectionButton">
                        <div class="selected"></div>
                        <img src="../public/images/icons/card.png" alt="Add Card Icon">
                        <p>Cards Management</p>
                    </li>
                    <li data-menu="Notifications Control Management" class="curson-pointer menuSelectionButton">
                        <div class="selected"></div>
                        <img src="../public/images/icons/addnitification.png" alt="Add Notification Icon">
                        <p>Notification</p>
                    </li>
                    <li data-menu="Application Control Management" class="curson-pointer menuSelectionButton">
                        <div class="selected"></div>
                        <img src="../public/images/icons/control.png" alt="Control Icon">
                        <p>Application</p>
                    </li>
                </ul>



            </nav>
        </div>
    </div>
<!--
    CONTENT TOP BAR
-->   
    <div class="content-container">
        <div class="top-panel">
            <div class="left-side">
                <div id="menu-visibility-button" class="curson-pointer">
                    <img src="../public/images/icons/view-more-white.png" alt="view more">
                </div>
                <div class="image">
                    <img src="../public/images/sscr-logo.png" alt="SSCR Logo">
                </div>
                <div class="text">
                    San Sebastian College - Recoletos
                </div>
            </div>
            <div class="right-side curson-pointer" id="Logout-Button">
                <div class="text">
                    Log out
                </div>
                <div class="image">
                    <img src="../public/images/icons/logout.png" alt="Logout Icon">
                </div>
            </div>
        </div>
<!--
    CONTENT HEADER 
-->
        <div class="bottom-panel">
            <div class="content">
                <div class="titlebar"><p id="Panel-Title">Home</p></div>
<!--
    CONTENT BODY
-->
    <!--
        HOME 
    -->
                <div id="panel-home" class="body-content-panel visible">
                    <div class="panel-home-content">
                       
                    </div>
                </div>

    <!--
        ALL TRANSACTIONS 
    -->
                <div id="panel-alltransactions" class="body-content-panel hidden">

                    <div id="All-Transactions-Query" class="panel-transactions-query panel">
                        <div class="form-container">
                            <div>
                                <label for="StartDate">Start Date</label>
                                <input class="transactions-startdate query inputdate" class="textbox" type="date" name="MyTransactionStartDate">
                            </div>
                            <div>
                                <label for="EndDate">End Date</label>
                                <input class="transactions-enddate query inputdate" class="textbox" type="date" name="MyTransactionEndDate">
                            </div>
                            <div>
                                <label for="TransactionNumber">Transaction Number</label>
                                <input class="transactions-transactionnumber query inputtext" class="textbox" type="text" name="MyTransactionNumber">
                            </div>
                            <div>
                                <label for="TransactionName">Search Name</label>
                                <input class="transactions-transactionname query inputtext" class="textbox" type="text" name="MyTransactionName">
                            </div>
                            <div>
                                <label>Status Filter</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="transactions-status-dropdown dropdown-text query">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Completed</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Payment Pending</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Waiting</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Canceled</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-transactions-buttons" data-transactiontype="AllTransactions">
                        <div>
                            <button id="alltransactions-search-button" class="btn-default curson-pointer transaction-search-button" type="submit" value="Search" name="MyTransactionsSubmit">
                                <img src="../public/images/icons/search-yellow.png" alt="search">
                                <span>Search</span>
                            </button>
                            <button id="alltransactions-clear-button" class="btn-default curson-pointer transaction-clear-button" type="reset" value="Clear">
                                <img src="../public/images/icons/clear-yellow.png" alt="search">
                                <span>Clear</span>
                            </button>
                        </div>
                        <div></div>
                    </div>
                    <div class="panel-transactions-table">
                        <div class="table-header">
                            <table>
                                <colgroup>
                                    <col class="col1">
                                    <col class="col2">
                                    <col class="col3">
                                    <col class="col4">
                                    <col class="col5">
                                    <col class="col6">
                                    <col class="col7">
                                    <col class="col8">
                                    <col class="col9">
                                    <col class="col10">
                                    <col class="col11">
                                    <col class="col12">
                                    <col class="col13">
                                    <col class="col14">
                                </colgroup>
                                <thead>
                                <tr>
                                    <th class="col1"><div><input type="checkbox" name="" id=""></div></th>
                                    <th class="col2"><div>#</div></th>
                                    <th class="col3"><div>Transaction Address</div></th> 
                                    <th class="col4"><div>Transaction Type</div></th> 
                                    <th class="col5"><div>Status</div></th>
                                    <th class="col6"><div>Sender Address</div></th>
                                    <th class="col7"><div>Sender Name</div></th>
                                    <th class="col8"><div>Receiver Address</div></th>
                                    <th class="col9"><div>Receiver Name</div></th>
                                    <th class="col10"><div>Total Amount</div></th>
                                    <th class="col11"><div>Timestamp</div></th>
                                    <th class="col12"><div>PostedBy</div></th>
                                    <th class="col13"><div>Payment Method</div></th>
                                    <th class="col14"><div>Notes</div></th>
                                </tr>
                                </thead>
                            </table>
                            </div>
                            <div>
                            <table>
                                <colgroup>
                                    <col class="col1">
                                    <col class="col2">
                                    <col class="col3">
                                    <col class="col4">
                                    <col class="col5">
                                    <col class="col6">
                                    <col class="col7">
                                    <col class="col8">
                                    <col class="col9">
                                    <col class="col10">
                                    <col class="col11">
                                    <col class="col12">
                                    <col class="col13">
                                    <col class="col14">
                                </colgroup>
                            <tbody id="All-Transactions-Table" class="transactions-table">
                               
                            </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="All-Transactions-Footer-Query" class="panel-transactions-footer">
                        <div class="dropdown">
                            <div class="dropdown-content">
                                <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)" >50/Page</a>
                                <a class="dropdownButtonSubItem" href="javascript:void(0)">100/Page</a>
                                <a class="dropdownButtonSubItem" href="javascript:void(0)">200/Page</a>
                                <a class="dropdownButtonSubItem" href="javascript:void(0)">All/Page</a>
                            </div>
                            <button class="dropdownButton dropdownbtn curson-pointer" data-layout="top">
                                <span class="transactions-recordscount-dropdown dropdown-text">50/Page</span>
                                <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                            </button>
                        </div>
                    </div>
                </div>

    <!--
        GUEST ACCOUNTS 
  
                <div id="panel-guestaccounts" class="body-content-panel hidden">
                    <div id="Guest-Accounts-Query" class="panel-accounts-query panel">
                        <div class="form-container">
                            <div>
                                <label for="accounts-address">Account Address</label>
                                <input class="accounts-address query textbox inputtext" type="text" name="accounts-address" autocomplete="off">
                            </div>
                            <div>
                                <label for="accounts-schoolpersonalid">School Personal Id</label>
                                <input class="accounts-schoolpersonalid query textbox inputtext" type="text" name="accounts-schoolpersonalid" autocomplete="off">
                            </div>
                            <div>
                                <label for="accounts-name">Name</label>
                                <input class="accounts-name query textbox inputtext" type="text" name="accounts-name" autocomplete="off">
                            </div>
                            <div>
                                <label for="accounts-email">Email</label>
                                <input class="accounts-email query textbox inputtext" type="text" name="accounts-email" autocomplete="off">
                            </div>
                            <div>
                                <label>Status</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-status-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Active</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Inactive</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-accounts-buttons" data-transactiontype="GuestAccounts">
                        <div>
                            <button class="btn-default curson-pointer accounts-search-button" type="submit" value="Search" name="MyTransactionsSubmit">
                                <img src="../public/images/icons/search-yellow.png" alt="search">
                                <span>Search</span>
                            </button>
                            <button class="btn-default curson-pointer accounts-clear-button" type="reset" value="Clear">
                                <img src="../public/images/icons/clear-yellow.png" alt="search">
                                <span>Clear</span>
                            </button>
                        </div>
                    </div>
                    <div class="panel-accounts-table">
                        <div class="table-header">
                            <table>
                                <thead id="Guest-Accounts-Table-Header">
                                    <tr>
                                        <th><div class="col1">#</div></th>
                                        <th><div class="col2">Account Address</div></th>
                                        <th><div class="col3">Status</div></th>
                                        <th><div class="col4">Category</div></th>
                                        <th><div class="col5">Firstname</div></th>
                                        <th><div class="col6">Lastname</div></th>
                                        <th><div class="col7">Email</div></th>
                                        <th><div class="col8">School Personal Id</div></th>
                                        <th><div class="col9">Campus</div></th>
                                        <th><div class="col10">Guardian Address</div></th>
                                        <th><div class="col11">Guardian Email</div></th>
                                        <th><div class="col12">Guardian Name</div></th>
                                        <th><div class="col13">Date Registered</div></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div>
                            <table>
                                <tbody id="Guest-Accounts-Table-Body" class="accounts-table">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> 
            -->

   
    <!--
        USER ACCOUNTS 
    -->
                <div id="panel-useraccounts" class="body-content-panel hidden">
                    <div id="User-Accounts-Query" class="panel-accounts-query panel">
                        <div class="form-container">
                            <div>
                                <label for="accounts-address">Account Address</label>
                                <input class="accounts-address query textbox inputtext" type="text" name="accounts-address" autocomplete="off">
                            </div>
                            <div>
                                <label for="accounts-schoolpersonalid">School Personal Id</label>
                                <input class="accounts-schoolpersonalid query textbox inputtext" type="text" name="accounts-schoolpersonalid" autocomplete="off">
                            </div>
                            <div>
                                <label for="accounts-name">Name</label>
                                <input class="accounts-name query textbox inputtext" type="text" name="accounts-name" autocomplete="off">
                            </div>
                            <div>
                                <label for="accounts-email">Email</label>
                                <input class="accounts-email query textbox inputtext" type="text" name="accounts-email" autocomplete="off">
                            </div>
                            <div>
                                <label>Status</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-status-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Active</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Inactive</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-accounts-buttons" data-transactiontype="UserAccounts">
                        <div>
                            <button class="btn-default curson-pointer accounts-search-button" type="submit" value="Search" name="MyTransactionsSubmit">
                                <img src="../public/images/icons/search-yellow.png" alt="search">
                                <span>Search</span>
                            </button>
                            <button class="btn-default curson-pointer accounts-clear-button" type="reset" value="Clear">
                                <img src="../public/images/icons/clear-yellow.png" alt="search">
                                <span>Clear</span>
                            </button>
                        </div>
                    </div>
                    <div class="panel-accounts-table">
                        <div class="table-header">
                            <table>
                                <thead id="User-Accounts-Table-Header">
                                    <tr>
                                        <th><div class="col1">#</div></th>
                                        <th><div class="col2">Account Address</div></th>
                                        <th><div class="col3">Status</div></th>
                                        <th><div class="col4">Category</div></th>
                                        <th><div class="col5">Firstname</div></th>
                                        <th><div class="col6">Lastname</div></th>
                                        <th><div class="col7">Email</div></th>
                                        <th><div class="col8">School Personal Id</div></th>
                                        <th><div class="col9">Campus</div></th>
                                        <th><div class="col10">Date Registered</div></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div>
                            <table>
                                <tbody id="User-Accounts-Table-Body" class="accounts-table">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

    <!--
        MERCHANT ACCOUNTS 
    -->
                <div id="panel-merchantaccounts" class="body-content-panel hidden">
                    <div id="Merchant-Accounts-Query" class="panel-accounts-query panel">
                    <div class="form-container">
                            <div>
                                <label for="accounts-address">Account Address</label>
                                <input class="accounts-address query textbox inputtext" type="text" name="accounts-address" autocomplete="off">
                            </div>
                            <div>
                                <label for="accounts-merchantcategory">Merchant Category</label>
                                <input class="accounts-merchantcategory query textbox inputtext" type="text" name="accounts-merchantcategory" autocomplete="off">
                            </div>
                            <div>
                                <label for="accounts-name">Name</label>
                                <input class="accounts-name query textbox inputtext" type="text" name="accounts-name" autocomplete="off">
                            </div>
                            <div>
                                <label for="accounts-email">Email</label>
                                <input class="accounts-email query textbox inputtext" type="text" name="accounts-email" autocomplete="off">
                            </div>
                            <div>
                                <label>Status</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-status-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Active</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Inactive</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-accounts-buttons" data-transactiontype="MerchantAccounts">
                        <div>
                            <button class="btn-default curson-pointer accounts-search-button" type="submit" value="Search" name="MyTransactionsSubmit">
                                <img src="../public/images/icons/search-yellow.png" alt="search">
                                <span>Search</span>
                            </button>
                            <button class="btn-default curson-pointer accounts-clear-button" type="reset" value="Clear">
                                <img src="../public/images/icons/clear-yellow.png" alt="search">
                                <span>Clear</span>
                            </button>
                        </div>
                    </div>
                    <div class="panel-accounts-table">
                        <div class="table-header">
                            <table>
                                <thead id="Merchant-Accounts-Table-Header">
                                    <tr>
                                        <th><div class="col1">#</div></th>
                                        <th><div class="col2">Account Address</div></th>
                                        <th><div class="col3">Status</div></th>
                                        <th><div class="col4">Category</div></th>
                                        <th><div class="col5">Firstname</div></th>
                                        <th><div class="col6">Lastname</div></th>
                                        <th><div class="col7">Email</div></th>
                                        <th><div class="col8">Merchant Category</div></th>
                                        <th><div class="col9">Campus</div></th>
                                        <th><div class="col10">Date Registered</div></th>
                                    </tr>   
                                </thead>
                            </table>
                        </div>
                        <div>
                            <table>
                                <tbody id="Merchant-Accounts-Table-Body" class="accounts-table">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


    <!--
        MERCHANT STAFFS ACCOUNTS 
    -->
                <div id="panel-merchantstaffsaccounts" class="body-content-panel hidden">
                    <div id="MerchantStaff-Accounts-Query" class="panel-accounts-query panel">
                    <div class="form-container">
                            <div>
                                <label for="accounts-address">Account Address</label>
                                <input class="accounts-address query textbox inputtext" type="text" name="accounts-address" autocomplete="off">
                            </div>
                            <div>
                                <label for="accounts-merchantcategory">Merchant Category</label>
                                <input class="accounts-merchantcategory query textbox inputtext" type="text" name="accounts-merchantcategory" autocomplete="off">
                            </div>
                            <div>
                                <label for="accounts-name">Name</label>
                                <input class="accounts-name query textbox inputtext" type="text" name="accounts-name" autocomplete="off">
                            </div>
                            <div>
                                <label for="accounts-email">Email</label>
                                <input class="accounts-email query textbox inputtext" type="text" name="accounts-email" autocomplete="off">
                            </div>
                            <div>
                                <label>Status</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-status-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Active</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Inactive</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-accounts-buttons" data-transactiontype="MerchantStaffAccounts">
                        <div>
                            <button class="btn-default curson-pointer accounts-search-button" type="submit" value="Search" name="MyTransactionsSubmit">
                                <img src="../public/images/icons/search-yellow.png" alt="search">
                                <span>Search</span>
                            </button>
                            <button class="btn-default curson-pointer accounts-clear-button" type="reset" value="Clear">
                                <img src="../public/images/icons/clear-yellow.png" alt="search">
                                <span>Clear</span>
                            </button>
                        </div>
                    </div>
                    <div class="panel-accounts-table">
                        <div class="table-header">
                            <table>
                                <thead id="MerchantStaff-Accounts-Table-Header">
                                    <tr>
                                        <th><div class="col1">#</div></th>
                                        <th><div class="col2">Account Address</div></th>
                                        <th><div class="col3">Status</div></th>
                                        <th><div class="col4">Category</div></th>
                                        <th><div class="col5">Firstname</div></th>
                                        <th><div class="col6">Lastname</div></th>
                                        <th><div class="col7">Email</div></th>
                                        <th><div class="col8">Merchant Category</div></th>
                                        <th><div class="col9">Campus</div></th>
                                        <th><div class="col10">Date Registered</div></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div>
                            <table>
                                <tbody id="MerchantStaff-Accounts-Table-Body" class="accounts-table">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

    <!--
        GUARDIAN ACCOUNTS 
    -->
                <div id="panel-guardianaccounts" class="body-content-panel hidden">
                    <div id="Guardian-Accounts-Query" class="panel-accounts-query panel">
                    <div class="form-container">
                            <div>
                                <label for="accounts-address">Account Address</label>
                                <input class="accounts-address query textbox inputtext" type="text" name="accounts-address" autocomplete="off">
                            </div>
                            <div>
                                <label for="accounts-name">Name</label>
                                <input class="accounts-name query textbox inputtext" type="text" name="accounts-name" autocomplete="off">
                            </div>
                            <div>
                                <label for="accounts-email">Email</label>
                                <input class="accounts-email query textbox inputtext" type="text" name="accounts-email" autocomplete="off">
                            </div>
                            <div>
                                <label>Status</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-status-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Active</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Inactive</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-accounts-buttons" data-transactiontype="GuardianAccounts">
                        <div>
                            <button class="btn-default curson-pointer accounts-search-button" type="submit" value="Search" name="MyTransactionsSubmit">
                                <img src="../public/images/icons/search-yellow.png" alt="search">
                                <span>Search</span>
                            </button>
                            <button class="btn-default curson-pointer accounts-clear-button" type="reset" value="Clear">
                                <img src="../public/images/icons/clear-yellow.png" alt="search">
                                <span>Clear</span>
                            </button>
                        </div>
                    </div>
                    <div class="panel-accounts-table">
                        <div class="table-header">
                            <table>
                                <thead id="Guardian-Accounts-Table-Header">
                                    <tr>
                                        <th><div class="col1">#</div></th>
                                        <th><div class="col2">Account Address</div></th>
                                        <th><div class="col3">Status</div></th>
                                        <th><div class="col4">Category</div></th>
                                        <th><div class="col5">Firstname</div></th>
                                        <th><div class="col6">Lastname</div></th>
                                        <th><div class="col7">Email</div></th>
                                        <th><div class="col8">Campus</div></th>
                                        <th><div class="col9">Date Registered</div></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div>
                            <table>
                                <tbody id="Guardian-Accounts-Table-Body" class="accounts-table">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

    <!--
        ACCOUNTING ACCOUNTS 
    -->
                <div id="panel-accountingaccounts" class="body-content-panel hidden">
                    <div id="Accounting-Accounts-Query" class="panel-accounts-query panel">
                    <div class="form-container">
                            <div>
                                <label for="accounts-address">Account Address</label>
                                <input class="accounts-address query textbox inputtext" type="text" name="accounts-address" autocomplete="off">
                            </div>
                            <div>
                                <label for="accounts-name">Name</label>
                                <input class="accounts-name query textbox inputtext" type="text" name="accounts-name" autocomplete="off">
                            </div>
                            <div>
                                <label for="accounts-email">Email</label>
                                <input class="accounts-email query textbox inputtext" type="text" name="accounts-email" autocomplete="off">
                            </div>
                            <div>
                                <label>Status</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-status-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Active</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Inactive</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-accounts-buttons" data-transactiontype="AccountingAccounts">
                        <div>
                            <button class="btn-default curson-pointer accounts-search-button" type="submit" value="Search" name="MyTransactionsSubmit">
                                <img src="../public/images/icons/search-yellow.png" alt="search">
                                <span>Search</span>
                            </button>
                            <button class="btn-default curson-pointer accounts-clear-button" type="reset" value="Clear">
                                <img src="../public/images/icons/clear-yellow.png" alt="search">
                                <span>Clear</span>
                            </button>
                        </div>
                    </div>
                    <div class="panel-accounts-table">
                        <div class="table-header">
                            <table>
                                <thead id="Accounting-Accounts-Table-Header">
                                    <tr>
                                        <th><div class="col1">#</div></th>
                                        <th><div class="col2">Account Address</div></th>
                                        <th><div class="col3">Status</div></th>
                                        <th><div class="col4">Category</div></th>
                                        <th><div class="col5">Firstname</div></th>
                                        <th><div class="col6">Lastname</div></th>
                                        <th><div class="col7">Email</div></th>
                                        <th><div class="col8">Campus</div></th>
                                        <th><div class="col9">Date Registered</div></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div>
                            <table>
                                <tbody id="Accounting-Accounts-Table-Body" class="accounts-table">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

    <!--
        ADMINISTRATOR ACCOUNTS 
    -->
                <div id="panel-administratoraccounts" class="body-content-panel hidden">
                    <div id="Administrator-Accounts-Query" class="panel-accounts-query panel">
                        <div class="form-container">
                            <div>
                                <label for="accounts-address">Account Address</label>
                                <input class="accounts-address query textbox inputtext" type="text" name="accounts-address" autocomplete="off">
                            </div>
                            <div>
                                <label for="accounts-name">Name</label>
                                <input class="accounts-name query textbox inputtext" type="text" name="accounts-name" autocomplete="off">
                            </div>
                            <div>
                                <label for="accounts-email">Email</label>
                                <input class="accounts-email query textbox inputtext" type="text" name="accounts-email" autocomplete="off">
                            </div>
                            <div>
                                <label>Status</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-status-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Active</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Inactive</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-accounts-buttons" data-transactiontype="AdministratorAccounts">
                        <div>
                            <button class="btn-default curson-pointer accounts-search-button" type="submit" value="Search" name="MyTransactionsSubmit">
                                <img src="../public/images/icons/search-yellow.png" alt="search">
                                <span>Search</span>
                            </button>
                            <button class="btn-default curson-pointer accounts-clear-button" type="reset" value="Clear">
                                <img src="../public/images/icons/clear-yellow.png" alt="search">
                                <span>Clear</span>
                            </button>
                        </div>
                    </div>
                    <div class="panel-accounts-table">
                        <div class="table-header">
                            <table>
                                <thead id="Administrator-Accounts-Table-Header">
                                    <tr>
                                        <th><div class="col1">#</div></th>
                                        <th><div class="col2">Account Address</div></th>
                                        <th><div class="col3">Status</div></th>
                                        <th><div class="col4">Category</div></th>
                                        <th><div class="col5">Firstname</div></th>
                                        <th><div class="col6">Lastname</div></th>
                                        <th><div class="col7">Email</div></th>
                                        <th><div class="col8">Campus</div></th>
                                        <th><div class="col9">Date Registered</div></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div>
                            <table>
                                <tbody id="Administrator-Accounts-Table-Body" class="accounts-table">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

    <!--
        ADD ACCOUNT
    -->
                <div id="panel-addaccount" class="body-content-panel hidden">
                    <div class="panel-add-account">
                        <div>
                            <p class="AddAccount-title">Add an Account Form</p>
                        </div>
                        <div>
                            <p>Firstname : </p>
                            <input id="AddAccount-Firstname" type="text">
                        </div>
                        <div>
                            <p>Lastname : </p>
                            <input id="AddAccount-Lastname" type="text">
                        </div>
                        <div>
                            <p>Email : </p>
                            <input id="AddAccount-Email" type="text">
                        </div>
                        <div>
                            <label>Actor Category :</label>
                            <div class="dropdown">
                                <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                    <span class="addaccount-accountcategory-dropdown dropdown-text query inputdropdown"></span>
                                    <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                </button>
                                <div class="dropdown-content" id="ActorCategory_Dropdown">
                                    <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)"></a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div id="AddAccount-UsernameContainer" style="display: none;">
                            <p>Username : </p>
                            <input id="AddAccount-Username" type="text">
                        </div>
                        <div id="AddAccount-PasswordContainer" style="display: none;">
                            <p>Password : </p>
                            <input id="AddAccount-Password" type="password">
                        </div>
                        <div id="AddAccount-CardAddressContainer" style="display: none;">
                            <p>Card Address : </p>
                            <input id="AddAccount-CardAddress" type="text">
                        </div>
                        <div id="AddAccount-SchoolPersonalIdContainer" style="display: none;">
                            <p>School Personal Id : </p>
                            <input id="AddAccount-SchoolPersonalId" type="text">
                        </div>
                        <div id="AddAccount-MerchantCategoryAddContainer" style="display: none;">
                            <p>New Merchant Category : </p>
                            <input id="AddAccount-MerchantCategoryAdd" type="text">
                        </div>
                        <div id="AddAccount-MerchantCategoryContainer" style="display: none;">
                            <label>Merchant Category:</label>
                            <div class="dropdown">
                                <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                    <span class="addaccount-merchantcategory-dropdown dropdown-text query inputdropdown"></span>
                                    <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                </button>
                                <div class="dropdown-content" id="MerchantCategory_Dropdown">
                                    <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)"></a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="btn-container">
                            <button id="AddAccount-SubmitBtn" class="Btn">Add Account</button>
                        </div>

                    </div>
                </div>

    <!--
        CARDS MANAGEMENT 
    -->
                <div id="panel-cardsmanagement" class="body-content-panel hidden">
                        <div id="Cards-Query" class="panel-cards-query panel">
                            <div class="form-container">
                                <div>
                                    <label for="cards-address">Card Address</label>
                                    <input class="cards-address query textbox inputtext" type="text" name="cards-address" autocomplete="off">
                                </div>
                                <div>
                                    <label for="cards-useraaddress">Card User Address</label>
                                    <input class="cards-useraaddress query textbox inputtext" type="text" name="cards-useraaddress" autocomplete="off">
                                </div>
                                <div>
                                    <label>Status</label>
                                    <div class="dropdown">
                                        <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                            <span class="cards-status-dropdown dropdown-text query inputdropdown">All</span>
                                            <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                        </button>
                                        <div class="dropdown-content">
                                            <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                            <a class="dropdownButtonSubItem" href="javascript:void(0)">Active Cards</a>
                                            <a class="dropdownButtonSubItem" href="javascript:void(0)">Inactive Cards</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-cards-buttons" data-transactiontype="Cards">
                            <div>
                                <button class="btn-default curson-pointer cards-search-button" type="submit" value="Search">
                                    <img src="../public/images/icons/search-yellow.png" alt="search">
                                    <span>Search</span>
                                </button>
                                <button class="btn-default curson-pointer cards-clear-button" type="reset" value="Clear">
                                    <img src="../public/images/icons/clear-yellow.png" alt="search">
                                    <span>Clear</span>
                                </button>
                            </div>
                        </div>
                        <div class="panel-cards-table">
                            <div class="table-header">
                                <table>
                                    <thead id="Cards-Table-Header">
                                        <tr>
                                            <th><div class="col1">#</div></th>
                                            <th><div class="col2">Card Address</div></th>
                                            <th><div class="col3">Status</div></th>
                                            <th><div class="col4">User Address</div></th>

                                            <th><div class="col5">User Firstname</div></th>
                                            <th><div class="col6">User Lastname</div></th>
 
                                            <th><div class="col7">Notes</div></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div>
                                <table>
                                    <tbody id="Cards-Table-Body" class="cards-table">
                                        <tr>
                                            <td colspan="7"><div class="free"><input class="AddCardAddressForm" type="text"><Button class="AddCardAddressButton">Upload Card</Button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                </div>




    <!--
        NOTIFICATIONS CONTROL MANAGEMENT 
    -->
                <div id="panel-notificationscontrolmanagement" class="body-content-panel hidden">
                    <div class="panel-notificationscontrolmanagement-content">

                        <div class="notification-add-form">
                            <div class="notification-input">
                                <p class="notification-form-title">Add Notification Form</p>
                            </div>

                            <div class="notification-input">
                                <p>Subject :</p>
                                <input id="Notifications-Subject" type="text">
                            </div>
                            <div class="notification-input">
                                <p>Content :</p>
                                <textarea id="Notifications-Content" cols="30" rows="10"></textarea>
                            </div>
                            <div class="notification-input">
                                <button id="Notifications-SubmitBtn">Set Notification</button>
                            </div>
                        </div>

                        <div id="Notifications-Container" class="notification-list">
                            <div class="notification-text">Notifications</div>
                            <div class="notification-item">
                                <div class="left-content">
                                    <p class="notification-subject">subject</p>
                                    <p class="notification-date">date</p>
                                    <p class="notification-content">content</p>
                                </div>
                                <div class="right-content">
                                    <button class="delete"><img src="../public/images/icons/delete-red.png" alt="" srcset=""></button>
                                </div>
                            </div>
                            <div class="notification-item">
                                <div class="left-content">
                                    <p class="notification-subject">subject</p>
                                    <p class="notification-date">date</p>
                                    <p class="notification-content">content</p>
                                </div>
                                <div class="right-content">
                                    <button class="delete"><img src="../public/images/icons/delete-red.png" alt="" srcset=""></button>
                                </div>
                            </div>
                            <div class="notification-item">
                                <div class="left-content">
                                    <p class="notification-subject">subject</p>
                                    <p class="notification-date">date</p>
                                    <p class="notification-content">content</p>
                                </div>
                                <div class="right-content">
                                    <button class="delete"><img class="icon" src="../public/images/icons/delete-red.png" alt="" srcset=""></button>
                                </div>
                            </div>
                            <div class="notification-item">
                                <div class="left-content">
                                    <p class="notification-subject">subject</p>
                                    <p class="notification-date">date</p>
                                    <p class="notification-content">content</p>
                                </div>
                                <div class="right-content">
                                    <button class="delete"><img class="icon" src="../public/images/icons/delete-red.png" alt="" srcset=""></button>
                                </div>
                            </div>
                            <div class="notification-item">
                                <div class="left-content">
                                    <p class="notification-subject">subject</p>
                                    <p class="notification-date">date</p>
                                    <p class="notification-content">content</p>
                                </div>
                                <div class="right-content">
                                    <button class="delete"><img class="icon" src="../public/images/icons/delete-red.png" alt="" srcset=""></button>
                                </div>
                            </div>
                        </div>

                    
                    </div>
                </div>

    <!--
        APPLICATION CONTROL MANAGEMENT 
    -->
                <div id="panel-applicationcontrolmanagement" class="body-content-panel hidden">
                    <div class="panel-applicationcontrolmanagement-content">

                        <div class="config-group-container">
                            <div class="config-title">System Main Settings</div>

                            <div class="config">
                                <p>Maintenance :</p>
                                <div class="settings">
                                    <label class="switch">
                                        <input id="Config-IsMaintenance" type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                    <input id="Config-IsMaintenanceDescription" type="text" placeholder="Message...">
                                </div>
                            </div>

                            <div class="config">
                                <p>Android App Version :</p>
                                <div class="settings">
                                    <input id="Config-AndroidAppVersion" type="text">
                                    <input id="Config-AndroidAppVersionDescription" type="text" placeholder="Message...">
                                </div>
                            </div>

                            <div class="config">
                                <p>Web App Version :</p>
                                <div class="settings">
                                    <input id="Config-WebAppVersion" type="text">
                                    <input id="Config-WebAppVersionDescription" type="text" placeholder="Message...">
                                </div>
                            </div>
                        </div>

                        <div class="config-group-container">
                            <div class="config-title">System Transactions Settings</div>

                            <div class="config">
                                <p>Can use Transactions :</p>
                                <div class="settings">
                                    <label class="switch">
                                        <input id="Config-Transactions" type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                    <input id="Config-TransactionsDescription" type="text" placeholder="Message...">
                                </div>
                            </div>

                            <div class="config">
                                <p>Can use Transfers :</p>
                                <div class="settings">
                                    <label class="switch">
                                        <input id="Config-Transfers" type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                    <input id="Config-TransfersDescription" type="text" placeholder="Message...">
                                </div>
                            </div>

                            <div class="config">
                                <p>Can use CashIn :</p>
                                <div class="settings">
                                    <label class="switch">
                                        <input id="Config-CashIn" type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                    <input id="Config-CashInDescription" type="text" placeholder="Message...">
                                </div>
                            </div>

                        </div>
                        <div class="config-group-container">
                            <div class="config-title">System Accounts Settings</div>

                            <div class="config">
                                <p>Accounting Accounts :</p>
                                <div class="settings">
                                    <label class="switch">
                                        <input id="Config-Accounting" type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                    <input id="Config-AccountingDescription" type="text" placeholder="Message...">
                                </div>
                            </div>

                            <div class="config">
                                <p>Merchant Admin Accounts :</p>
                                <div class="settings">
                                    <label class="switch">
                                        <input id="Config-MerchantAdmin" type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                    <input id="Config-MerchantAdminDescription" type="text" placeholder="Message...">
                                </div>
                            </div>

                            <div class="config">
                                <p>Merchant Staff Accounts :</p>
                                <div class="settings">
                                    <label class="switch">
                                        <input id="Config-MerchantStaff" type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                    <input id="Config-MerchantStaffDescription" type="text" placeholder="Message...">
                                </div>
                            </div>

                            <div class="config">
                                <p>User Accounts :</p>
                                <div class="settings">
                                    <label class="switch">
                                        <input id="Config-User" type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                    <input id="Config-UserDescription" type="text" placeholder="Message...">
                                </div>
                            </div>

                            <div class="config">
                                <p>Guest Accounts :</p>
                                <div class="settings">
                                    <label class="switch">
                                        <input id="Config-Guest" type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                    <input id="Config-GuestDescription" type="text" placeholder="Message...">
                                </div>
                            </div>

                            <div class="config">
                                <p>Guardian Accounts :</p>
                                <div class="settings">
                                    <label class="switch">
                                        <input id="Config-Guardian" type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                    <input id="Config-GuardianDescription" type="text" placeholder="Message...">
                                </div>
                            </div>
                        </div>

                        <div class="config-pin-container">
                            <div class="settings">
                                <p>Your PIN Code:</p>
                                <input id="Config-PinCode" type="password" placeholder=" * * * * * * ">
                                <button id="Config-Submit">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
    <!--
        END 
    -->
            </div>
        </div>
    </div>
<!--
    ALERTS ###
-->
<div id="Alert-Box-Container" class="Alert-container">
    <table class="Alert-Box-Table">
        
    </table>
</div>
<!--
MODALS ###
-->
<div id="Modal-Container" class="modal-container">
    <div class="modal-content">
        <div class="header">
            <div class="title">
                <p id="Modal-Header" class="text">N/A</p>
            </div>
            <div class="close" >
                <p id="Modal-Close-Button" class="close-btn curson-pointer">X</p>
            </div>
        </div>
        <div id="Modal-Body" class="body">
            
        </div>
    </div>
</div>
<!--
    JAVASCRIPTS  ###
-->
    <script src="../public/javascript/main-administrator.js" type="module"></script>
</body>
</html>

