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
                <div class="fullname">Juan Dela Cruz</div>
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
                                <li data-menu="User Transactions" class="curson-pointer menuSelectionButton">
                                    <div class="selected"></div>
                                    <p>User Transactions</p>
                                </li>
                                <li data-menu="Merchant Transactions" class="curson-pointer menuSelectionButton">
                                    <div class="selected"></div>
                                    <p>Merchant Transactions</p>
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
                                <li data-menu="Merchant Accounts" class="curson-pointer menuSelectionButton">
                                    <div class="selected"></div>
                                    <p>Merchant Accounts</p>
                                </li>
                                <li data-menu="Merchant Staffs Accounts" class="curson-pointer menuSelectionButton">
                                    <div class="selected"></div>
                                    <p>Merchant Staffs Accounts</p>
                                </li>
                                <li data-menu="Parental Accounts" class="curson-pointer menuSelectionButton">
                                    <div class="selected"></div>
                                    <p>Parental Accounts</p>
                                </li>
                                <li data-menu="Accounting Accounts" class="curson-pointer menuSelectionButton">
                                    <div class="selected"></div>
                                    <p>Accounting Accounts</p>
                                </li>
                                <li data-menu="Administrator Accounts" class="curson-pointer menuSelectionButton">
                                    <div class="selected"></div>
                                    <p>Administrator Accounts</p>
                                </li>
                            </ul>
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
            <div class="right-side curson-pointer" onclick="">
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
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Success</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Failed</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Waiting</a>
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
                            <button id="alltransactions-export-button" class="btn-default curson-pointer transaction-export-button" type="button" value="Export">
                                <img src="../public/images/icons/download-yellow.png" alt="search">
                                <span>Export</span>
                            </button>
                        </div>
                        <div>
                            <div>
                                <div>Total Orders: </div>
                                <div class="transaction-totalorders-text text">???</div>
                            </div>
                            <div>
                                <div >Total Sales: </div>
                                <div class="transaction-totalsales-text text">???</div>
                            </div>
                        </div>
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
                                    <th class="col3"><div>Transaction ID</div></th>
                                    <th class="col4"><div>Status</div></th>
                                    <th class="col5"><div>In Charge</div></th>
                                    <th class="col6"><div>Name</div></th>
                                    <th class="col7"><div>Category</div></th>
                                    <th class="col8"><div>Department</div></th>
                                    <th class="col9"><div>Course</div></th>
                                    <th class="col10"><div>Amount</div></th>
                                    <th class="col11"><div>Items</div></th>
                                    <th class="col12"><div>Timestamp</div></th>
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
                    <div class="panel-transactions-footer">
                        <div class="page-numbers-container">
                            <ul id="mytransaction-pagenumbers" class="page-numbers">
                                <button id="transaction-leftpage-button">&lt;</button>
                                <li><a class="mytransaction-pagenumber-button curson-pointer selected" onclick="">1</a></li>
                                <li><a class="mytransaction-pagenumber-button curson-pointer" onclick="">2</a></li>
                                <li><a class="mytransaction-pagenumber-button curson-pointer" onclick="">3</a></li>
                                <li><a class="mytransaction-pagenumber-button curson-pointer" onclick="">4</a></li>
                                <li><a class="mytransaction-pagenumber-button curson-pointer" onclick="">5</a></li>
                                <button id="mytransaction-rightpage-button">&gt;</button>
                            </ul>
                        </div>
                        <div>
                            <div>Total: </div>
                            <div class="transaction-totalsales-text text">???</div>
                        </div>
                        <div class="dropdown">
                            <div class="dropdown-content">
                                <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)" >25/Page</a>
                                <a class="dropdownButtonSubItem" href="javascript:void(0)">50/Page</a>
                                <a class="dropdownButtonSubItem" href="javascript:void(0)">100/Page</a>
                                <a class="dropdownButtonSubItem" href="javascript:void(0)">500/Page</a>
                            </div>
                            <button class="dropdownButton dropdownbtn curson-pointer" data-layout="top">
                                <span class="transactions-recordscount-dropwond dropdown-text">25/Page</span>
                                <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                            </button>
                        </div>
                    </div>
                </div>

    <!--
        USER TRANSACTIONS 
    -->
                <div id="panel-usertransactions" class="body-content-panel hidden">
                    <div id="User-Transactions-Query" class="panel-transactions-query panel">
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
                                        <span class="transactions-status-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Success</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Failed</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Waiting</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-transactions-buttons" data-transactiontype="UserTransactions">
                        <div>
                            <button id="usertransaction-search-button" class="btn-default curson-pointer transaction-search-button" type="submit" value="Search" name="MyTransactionsSubmit">
                                <img src="../public/images/icons/search-yellow.png" alt="search">
                                <span>Search</span>
                            </button>
                            <button id="usertransaction-clear-button" class="btn-default curson-pointer transaction-clear-button" type="reset" value="Clear">
                                <img src="../public/images/icons/clear-yellow.png" alt="search">
                                <span>Clear</span>
                            </button>
                            <button id="usertransaction-export-button" class="btn-default curson-pointer transaction-export-button" type="button" value="Export">
                                <img src="../public/images/icons/download-yellow.png" alt="search">
                                <span>Export</span>
                            </button>
                        </div>
                        <div>
                            <div>
                                <div>Total Orders: </div>
                                <div class="transaction-totalorders-text text">???</div>
                            </div>
                            <div>
                                <div >Total Sales: </div>
                                <div class="transaction-totalsales-text text">???</div>
                            </div>
                        </div>
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
                                    <th class="col3"><div>Transaction ID</div></th>
                                    <th class="col4"><div>Status</div></th>
                                    <th class="col5"><div>In Charge</div></th>
                                    <th class="col6"><div>Name</div></th>
                                    <th class="col7"><div>Category</div></th>
                                    <th class="col8"><div>Department</div></th>
                                    <th class="col9"><div>Course</div></th>
                                    <th class="col10"><div>Amount</div></th>
                                    <th class="col11"><div>Items</div></th>
                                    <th class="col12"><div>Timestamp</div></th>
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
                            <tbody id="User-Transactions-Table" class="transactions-table">
                               
                            </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-transactions-footer">
                        <div class="page-numbers-container">
                            <ul id="mytransaction-pagenumbers" class="page-numbers">
                                <button id="transaction-leftpage-button">&lt;</button>
                                <li><a class="mytransaction-pagenumber-button curson-pointer selected" onclick="">1</a></li>
                                <li><a class="mytransaction-pagenumber-button curson-pointer" onclick="">2</a></li>
                                <li><a class="mytransaction-pagenumber-button curson-pointer" onclick="">3</a></li>
                                <li><a class="mytransaction-pagenumber-button curson-pointer" onclick="">4</a></li>
                                <li><a class="mytransaction-pagenumber-button curson-pointer" onclick="">5</a></li>
                                <button id="mytransaction-rightpage-button">&gt;</button>
                            </ul>
                        </div>
                        <div>
                            <div>Total: </div>
                            <div class="transaction-totalsales-text text">???</div>
                        </div>
                        <div class="dropdown">
                            <div class="dropdown-content">
                                <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)" >25/Page</a>
                                <a class="dropdownButtonSubItem" href="javascript:void(0)">50/Page</a>
                                <a class="dropdownButtonSubItem" href="javascript:void(0)">100/Page</a>
                                <a class="dropdownButtonSubItem" href="javascript:void(0)">500/Page</a>
                            </div>
                            <button class="dropdownButton dropdownbtn curson-pointer" data-layout="top">
                                <span class="transactions-recordscount-dropwond dropdown-text">25/Page</span>
                                <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                            </button>
                        </div>
                    </div>
                </div>

    <!--
        MERCHANT TRANSACTIONS 
    -->
                <div id="panel-merchanttransactions" class="body-content-panel hidden">
                    <div id="Merchant-Transactions-Query" class="panel-transactions-query panel">
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
                                        <span class="transactions-status-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Success</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Failed</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Waiting</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-transactions-buttons" data-transactiontype="MerchantTransactions">
                        <div>
                            <button id="merchanttransaction-search-button" class="btn-default curson-pointer transaction-search-button" type="submit" value="Search" name="MyTransactionsSubmit">
                                <img src="../public/images/icons/search-yellow.png" alt="search">
                                <span>Search</span>
                            </button>
                            <button id="merchanttransaction-clear-button" class="btn-default curson-pointer transaction-clear-button" type="reset" value="Clear">
                                <img src="../public/images/icons/clear-yellow.png" alt="search">
                                <span>Clear</span>
                            </button>
                            <button id="merchanttransaction-export-button" class="btn-default curson-pointer transaction-export-button" type="button" value="Export">
                                <img src="../public/images/icons/download-yellow.png" alt="search">
                                <span>Export</span>
                            </button>
                        </div>
                        <div>
                            <div>
                                <div>Total Orders: </div>
                                <div class="transaction-totalorders-text text">???</div>
                            </div>
                            <div>
                                <div >Total Sales: </div>
                                <div class="transaction-totalsales-text text">???</div>
                            </div>
                        </div>
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
                                    <th class="col3"><div>Transaction ID</div></th>
                                    <th class="col4"><div>Status</div></th>
                                    <th class="col5"><div>In Charge</div></th>
                                    <th class="col6"><div>Name</div></th>
                                    <th class="col7"><div>Category</div></th>
                                    <th class="col8"><div>Department</div></th>
                                    <th class="col9"><div>Course</div></th>
                                    <th class="col10"><div>Amount</div></th>
                                    <th class="col11"><div>Items</div></th>
                                    <th class="col12"><div>Timestamp</div></th>
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
                            <tbody id="Merchant-Transactions-Table" class="transactions-table">
                            
                            </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-transactions-footer">
                        <div class="page-numbers-container">
                            <ul id="merchanttransaction-pagenumbers" class="page-numbers">
                                <button id="transaction-leftpage-button">&lt;</button>
                                <li><a class="mytransaction-pagenumber-button curson-pointer selected" onclick="">1</a></li>
                                <li><a class="mytransaction-pagenumber-button curson-pointer" onclick="">2</a></li>
                                <li><a class="mytransaction-pagenumber-button curson-pointer" onclick="">3</a></li>
                                <li><a class="mytransaction-pagenumber-button curson-pointer" onclick="">4</a></li>
                                <li><a class="mytransaction-pagenumber-button curson-pointer" onclick="">5</a></li>
                                <button id="mytransaction-rightpage-button">&gt;</button>
                            </ul>
                        </div>
                        <div>
                            <div>Total: </div>
                            <div class="transaction-totalsales-text text">???</div>
                        </div>
                        <div class="dropdown">
                            <div class="dropdown-content">
                                <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)" >25/Page</a>
                                <a class="dropdownButtonSubItem" href="javascript:void(0)">50/Page</a>
                                <a class="dropdownButtonSubItem" href="javascript:void(0)">100/Page</a>
                                <a class="dropdownButtonSubItem" href="javascript:void(0)">500/Page</a>
                            </div>
                            <button class="dropdownButton dropdownbtn curson-pointer" data-layout="top">
                                <span class="transactions-recordscount-dropwond dropdown-text">25/Page</span>
                                <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                            </button>
                        </div>
                    </div>
                </div>

    <!--
        USER ACCOUNTS 
    -->
                <div id="panel-useraccounts" class="body-content-panel hidden">
                    <div id="User-Accounts-Query" class="panel-accounts-query panel">
                        <div class="form-container">
                            <div>
                                <label for="accountschoolid">Id Number</label>
                                <input class="accounts-accountschoolid query textbox inputtext" type="text" name="accountschoolid">
                            </div>
                            <div>
                                <label for="accountfirstname">First name</label>
                                <input class="accounts-accountfirstname query textbox inputtext" type="text" name="accountfirstname">
                            </div>
                            <div>
                                <label for="accountlastname">Last name</label>
                                <input class="accounts-accountlastname query textbox inputtext" type="text" name="accountlastname">
                            </div>
                            <div>
                                <label>Group Filter</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-group-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Teacher</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Student</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Highschool</a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label>Department Filter</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-department-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">WAWA</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">WA</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">SDS</a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label>Course Filter</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-course-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSIT</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSN</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSCS</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSEE</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSA</a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label>Group Filter</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-group-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Teacher</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Student</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Highschool</a>
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
                                <label for="accountschoolid">Id Number</label>
                                <input class="accounts-accountschoolid query textbox inputtext" type="text" name="accountschoolid">
                            </div>
                            <div>
                                <label for="accountfirstname">First name</label>
                                <input class="accounts-accountfirstname query textbox inputtext" type="text" name="accountfirstname">
                            </div>
                            <div>
                                <label for="accountlastname">Last name</label>
                                <input class="accounts-accountlastname query textbox inputtext" type="text" name="accountlastname">
                            </div>
                            <div>
                                <label>Group Filter</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-group-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Teacher</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Student</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Highschool</a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label>Department Filter</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-department-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">WAWA</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">WA</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">SDS</a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label>Course Filter</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-course-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSIT</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSN</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSCS</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSEE</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSA</a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label>Group Filter</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-group-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Teacher</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Student</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Highschool</a>
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
                                <thead id="Merchant-Accounts-Table-Header">
                                   
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
                    <div id="MercahntStaffs-Accounts-Query" class="panel-accounts-query panel">
                        <div class="form-container">
                            <div>
                                <label for="accountschoolid">Id Number</label>
                                <input class="accounts-accountschoolid query textbox inputtext" type="text" name="accountschoolid">
                            </div>
                            <div>
                                <label for="accountfirstname">First name</label>
                                <input class="accounts-accountfirstname query textbox inputtext" type="text" name="accountfirstname">
                            </div>
                            <div>
                                <label for="accountlastname">Last name</label>
                                <input class="accounts-accountlastname query textbox inputtext" type="text" name="accountlastname">
                            </div>
                            <div>
                                <label>Group Filter</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-group-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Teacher</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Student</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Highschool</a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label>Department Filter</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-department-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">WAWA</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">WA</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">SDS</a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label>Course Filter</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-course-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSIT</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSN</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSCS</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSEE</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSA</a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label>Group Filter</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-group-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Teacher</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Student</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Highschool</a>
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
                                <thead id="MerchantStaffs-Accounts-Table-Header">
                                
                                </thead>
                            </table>
                        </div>
                        <div>
                            <table>
                                <tbody id="MerchantStaffs-Accounts-Table-Body" class="accounts-table">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

    <!--
        PARENTAL ACCOUNTS 
    -->
                <div id="panel-parentalaccounts" class="body-content-panel hidden">
                    <div id="Parental-Accounts-Query" class="panel-accounts-query panel">
                        <div class="form-container">
                            <div>
                                <label for="accountschoolid">Id Number</label>
                                <input class="accounts-accountschoolid query textbox inputtext" type="text" name="accountschoolid">
                            </div>
                            <div>
                                <label for="accountfirstname">First name</label>
                                <input class="accounts-accountfirstname query textbox inputtext" type="text" name="accountfirstname">
                            </div>
                            <div>
                                <label for="accountlastname">Last name</label>
                                <input class="accounts-accountlastname query textbox inputtext" type="text" name="accountlastname">
                            </div>
                            <div>
                                <label>Group Filter</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-group-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Teacher</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Student</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Highschool</a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label>Department Filter</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-department-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">WAWA</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">WA</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">SDS</a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label>Course Filter</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-course-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSIT</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSN</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSCS</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSEE</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSA</a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label>Group Filter</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-group-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Teacher</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Student</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Highschool</a>
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
                                <thead id="Parental-Accounts-Table-Header">
                                   
                                </thead>
                            </table>
                        </div>
                        <div>
                            <table>
                                <tbody id="Parental-Accounts-Table-Body" class="accounts-table">
                                    
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
                                <label for="accountschoolid">Id Number</label>
                                <input class="accounts-accountschoolid query textbox inputtext" type="text" name="accountschoolid">
                            </div>
                            <div>
                                <label for="accountfirstname">First name</label>
                                <input class="accounts-accountfirstname query textbox inputtext" type="text" name="accountfirstname">
                            </div>
                            <div>
                                <label for="accountlastname">Last name</label>
                                <input class="accounts-accountlastname query textbox inputtext" type="text" name="accountlastname">
                            </div>
                            <div>
                                <label>Group Filter</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-group-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Teacher</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Student</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Highschool</a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label>Department Filter</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-department-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">WAWA</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">WA</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">SDS</a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label>Course Filter</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-course-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSIT</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSN</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSCS</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSEE</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSA</a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label>Group Filter</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-group-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Teacher</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Student</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Highschool</a>
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
                                <thead id="Accounting-Accounts-Table-Header">
                                   
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
                                <label for="accountschoolid">Id Number</label>
                                <input class="accounts-accountschoolid query textbox inputtext" type="text" name="accountschoolid">
                            </div>
                            <div>
                                <label for="accountfirstname">First name</label>
                                <input class="accounts-accountfirstname query textbox inputtext" type="text" name="accountfirstname">
                            </div>
                            <div>
                                <label for="accountlastname">Last name</label>
                                <input class="accounts-accountlastname query textbox inputtext" type="text" name="accountlastname">
                            </div>
                            <div>
                                <label>Group Filter</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-group-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Teacher</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Student</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Highschool</a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label>Department Filter</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-department-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">WAWA</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">WA</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">SDS</a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label>Course Filter</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-course-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSIT</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSN</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSCS</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSEE</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">BSA</a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label>Group Filter</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="accounts-group-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="../public/images/icons/more.png" alt="more">
                                    </button>
                                    <div class="dropdown-content">
                                        <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Teacher</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Student</a>
                                        <a class="dropdownButtonSubItem" href="javascript:void(0)">Highschool</a>
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
                                <thead id="Administrator-Accounts-Table-Header">
                                   
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
        NOTIFICATIONS CONTROL MANAGEMENT 
    -->
                <div id="panel-notificationscontrolmanagement" class="body-content-panel hidden">
                    <div class="panel-notificationscontrolmanagement-content">
                    
                    </div>
                </div>

    <!--
        APPLICATION CONTROL MANAGEMENT 
    -->
                <div id="panel-applicationcontrolmanagement" class="body-content-panel hidden">
                    <div class="panel-applicationcontrolmanagement-content">
                    
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

