<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BCash - Accounting</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="<?php echo base_url('./public/css/styles.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('./public/css/dialog-box.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('./public/css/menu.css'); ?>">
    
    <link rel="stylesheet" href="<?php echo base_url('./public/css/accounting/home.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('./public/css/accounting/transactions.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('./public/css/accounting/accounts.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('./public/css/accounting/cashinform.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('./public/css/accounting/fundremittance.css'); ?>">
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
                <div class="category">BCash: Accounting</div>
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
                    <li data-menu="Cash In Form" class="curson-pointer menuSelectionButton">
                        <div class="selected"></div>
                        <img src="../public/images/icons/cashin.png" alt="Cash In Icon">
                        <p>Cash-In Form</p>
                    </li>
                    <li data-menu="Transactions Management" class="curson-pointer menuSelectionButton menuSelectionDropdownButton">
                        <img src="../public/images/icons/longreceipt.png" alt="Transactions Icon">
                        <p>Transactions</p>
                        <img id="sidebar-bottom-menu-myorders-more" class="more" src="../public/images/icons/more.png" alt="More Icon">
                    </li>
                    <li class="menuSelectionDropdownItems">
                        <ul>
                            <li data-menu="My Transactions" class="curson-pointer menuSelectionButton">
                                <div class="selected"></div>
                                <p>My Transactions</p>
                            </li>
                            <li data-menu="All Transactions" class="curson-pointer menuSelectionButton">
                                <div class="selected"></div>
                                <p>All Transactions</p>
                            </li>
                        </ul>
                    </li>
                    <li data-menu="Accounts" class="curson-pointer menuSelectionButton">
                        <div class="selected"></div>
                        <img src="../public/images/icons/accounts.png" alt="Accounts Icon">
                        <p>Accounts</p>
                    </li>
                    <li data-menu="Fund Remittance" class="curson-pointer menuSelectionButton">
                        <div class="selected"></div>
                        <img src="../public/images/icons/remittance.png" alt="Fund Remittance Icon">
                        <p>Fund Remittance</p>
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
                        <div class="header">
                            <p>Welcome to Dashboard</p>
                        </div>
                        <div class="charts-container-row1">
                            <div class="chart-item">
                                <!-- Total Cash In Today / Total Amount -->
                                <div class="chart-header">
                                    <p class="chart-title">Total cash-in today</p>
                                    <div class="chart-value">
                                        <p class="chart-number">P100.00</p>
                                        <div class="chart-status">
                                            <p class="chart-status-number">150%</p>
                                            <img class="chart-status-image" src="" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div id="chart-total-cash-in" class="chart-mini">
                                    <canvas></canvas>
                                </div>
                            </div>
                            <div class="chart-item">
                                <!-- Total Orders In Merchants  -->
                                <div class="chart-header">
                                    <p class="chart-title">Total orders in merchants</p>
                                    <div class="chart-value">
                                        <p class="chart-number">P100.00</p>
                                        <div class="chart-status">
                                            <p class="chart-status-number">150%</p>
                                            <img class="chart-status-image" src="" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div id="chart-total-orders-merchants" class="chart-mini">
                                    <canvas></canvas>
                                </div>
                            </div>
                            <div class="chart-item">
                                <!-- Total Total Sales In Merchants -->
                                <div class="chart-header">
                                    <p class="chart-title">Total Sales in merchants</p>
                                    <div class="chart-value">
                                        <p class="chart-number">P100.00</p>
                                        <div class="chart-status">
                                            <p class="chart-status-number">150%</p>
                                            <img class="chart-status-image" src="" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div id="chart-total-sales-merchants" class="chart-mini">
                                    <canvas></canvas>
                                </div>
                            </div>
                            <div class="chart-item">
                                <!-- Total Transactions Today -->
                                <div class="chart-header">
                                    <p class="chart-title">Total transactions today</p>
                                    <div class="chart-value">
                                        <p class="chart-number">P100.00</p>
                                        <div class="chart-status">
                                            <p class="chart-status-number">150%</p>
                                            <img class="chart-status-image" src="" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div id="chart-total-transactions-today" class="chart-mini">
                                    <canvas></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="charts-container-row2">
                            <div class="chart-5 chart-item">
                                <!-- Total Transactions Today -->
                                <div class="chart-header">
                                    <p class="chart-title">Daily Transactions Line Graph</p>
                                    <p class="chart-description">fhjuhfu sfjha hafewf a dfwef awfwa agn agag ag nag  </p>
                                    <div class="chart-value">
                                        <div class="chart-value-1">
                                            <p class="chart-value-1-number"></p>
                                            <p class="chart-value-1-title"></p>
                                        </div>
                                        <div class="chart-value-2">
                                            <p class="chart-value-2-number"></p>
                                            <p class="chart-value-2-title"></p>
                                        </div>
                                    </div>
                                </div>
                                <div id="chart-cashin-total-history" class="">
                                    <canvas></canvas>
                                </div>
                            </div>

                            <div class="chart-6 chart-item">
                                <!-- Total Transactions Today -->
                                <div class="chart-header">
                                    <p class="chart-title">Circulating Money</p>
                                    <p class="chart-description">eithed dfmk sdfe sfesf </p>
                                </div>
                                <div id="chart-money-in-circulation" class="">
                                    <canvas></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="charts-container-row3">
                            <div class="chart-7 chart-item">
                                <!-- Recent Transactions -->
                                <div class="header">
                                    <p class="title">Recent Transactions</p>
                                    <p class="date">Last Update: 12:98AM</p>
                                </div>
                                <ul>
                                    <li>
                                        <img src="" alt="" >
                                        <div>
                                            <p class="name">name</p>
                                            <p class="date">date</p>
                                        </div>
                                        <div>
                                            <p class="amount">amount</p>
                                            <p class="type">type</p>
                                        </div>
                                    </li>
                                    <li>
                                        <img src="" alt="" >
                                        <div>
                                            <p class="name">name</p>
                                            <p class="date">date</p>
                                        </div>
                                        <div>
                                            <p class="amount">amount</p>
                                            <p class="type">type</p>
                                        </div>
                                    </li>
                                    <li>
                                        <img src="" alt="" >
                                        <div>
                                            <p class="name">name</p>
                                            <p class="date">date</p>
                                        </div>
                                        <div>
                                            <p class="amount">amount</p>
                                            <p class="type">type</p>
                                        </div>
                                    </li>
                                    <li>
                                        <img src="" alt="" >
                                        <div>
                                            <p class="name">name</p>
                                            <p class="date">date</p>
                                        </div>
                                        <div>
                                            <p class="amount">amount</p>
                                            <p class="type">type</p>
                                        </div>
                                    </li>
                                    <li>
                                        <img src="" alt="" >
                                        <div>
                                            <p class="name">name</p>
                                            <p class="date">date</p>
                                        </div>
                                        <div>
                                            <p class="amount">amount</p>
                                            <p class="type">type</p>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                            <div class="chart-8 chart-item">
                                <div class="header">
                                    <p class="title">Recent Cash-In</p>
                                    <p class="date">Last Update: 12:98AM</p>
                                </div>
                                <!-- Recent Cash In -->
                                <ul>
                                    <li>
                                        <img src="" alt="" >
                                        <div>
                                            <p class="name">name</p>
                                            <p class="date">date</p>
                                        </div>
                                        <div>
                                            <p class="amount">amount</p>
                                            <p class="type">type</p>
                                        </div>
                                    </li>
                                    <li>
                                        <img src="" alt="" >
                                        <div>
                                            <p class="name">name</p>
                                            <p class="date">date</p>
                                        </div>
                                        <div>
                                            <p class="amount">amount</p>
                                            <p class="type">type</p>
                                        </div>
                                    </li>
                                    <li>
                                        <img src="" alt="" >
                                        <div>
                                            <p class="name">name</p>
                                            <p class="date">date</p>
                                        </div>
                                        <div>
                                            <p class="amount">amount</p>
                                            <p class="type">type</p>
                                        </div>
                                    </li>
                                    <li>
                                        <img src="" alt="" >
                                        <div>
                                            <p class="name">name</p>
                                            <p class="date">date</p>
                                        </div>
                                        <div>
                                            <p class="amount">amount</p>
                                            <p class="type">type</p>
                                        </div>
                                    </li>
                                    <li>
                                        <img src="" alt="" >
                                        <div>
                                            <p class="name">name</p>
                                            <p class="date">date</p>
                                        </div>
                                        <div>
                                            <p class="amount">amount</p>
                                            <p class="type">type</p>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                            <div class="chart-9 chart-item">
                                <div class="header">
                                    <p class="title">Recent Activities</p>
                                    <p class="date">Last Update: 12:98AM</p>
                                </div>
                                <!-- Recent Activities -->
                                <ul>
                                    
                                    <li>
                                        <img src="" alt="" >
                                        <div>
                                            <p class="name">name</p>
                                            <p class="date">date</p>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        </div>

                       <!--
                    


                        Total Cash In Today / Total Amount
                        Total Orders In Merchants
                        Total Total Sales In Merhcants
                        Total Transactions Today

                        Mpney in Circulation
                            Hold By Users
                            Hold By Merchants   

                        graph of sales every day Cash ins               
                       -->
                    </div>
                </div>

    <!--
        CASH IN FORM 
    -->
                <div id="panel-cashinform" class="body-content-panel hidden">
                    <div class="panel-cashinform-content">
                        <div class="left-container">
                            <div class="header">
                                <p class="title">Cash-In Form</p>
                                <p class="help">?</p>
                            </div>
                            <div class="content-container">

                                <div class="input-container">
                                    <label for="">Id:</label>
                                    <input id="CashIn-Id" type="text" name="">
                                </div>

                                <div class="input-container">
                                    <label for="amount">Amount: </label>
                                    <input id="CashIn-Amount" type="text" name="amount">
                                </div>
    
                                
    
                                <button id="CashIn-Btn-SearchUser" class="search">Search User</button>
    
                                <fieldset class="details-container">
                                    <legend>User Details</legend>
                                    <div class="item">
                                        <p>Name: </p>
                                        <p id="CashIn-UserName"></p>
                                    </div>
    
                                    <div class="item">
                                        <p>Curent Balance: </p>
                                        <p id="CashIn-UserBalance"></p>
                                    </div>
                                </fieldset>
    
                                <button id="CashIn-Btn-Transfer" class="transfer">Confirm Transfer</button>
                            </div>
                        </div>
                        <div class="right-container">
                            <div class="header">
                                <p class="title">Recent Cash-In</p>
                            </div>
                            <!-- Recent Cash In -->
                            <ul id="CashIn-Content">
                            <!-- 
                                <li>
                                    <img src="" alt="" >
                                    <div>
                                        <p class="name">name</p>
                                        <p class="date">date</p>
                                    </div>
                                    <div>
                                        <p class="amount">amount</p>
                                        <p class="type">type</p>
                                    </div>
                                </li> 
                            -->
                                

                            </ul>
                        </div>                        

                        
                    </div>
                </div>

    <!--
        My TRANSACTIONS 
    -->
                <div id="panel-mytransactions" class="body-content-panel hidden">
                    <div id="My-Transactions-Query" class="panel-transactions-query panel">
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
                    <div class="panel-transactions-buttons" data-transactiontype="MyTransactions">
                        <div>
                            <button id="mytransaction-search-button" class="btn-default curson-pointer transaction-search-button" type="submit" value="Search" name="MyTransactionsSubmit">
                                <img src="../public/images/icons/search-yellow.png" alt="search">
                                <span>Search</span>
                            </button>
                            <button id="mytransaction-clear-button" class="btn-default curson-pointer transaction-clear-button" type="reset" value="Clear">
                                <img src="../public/images/icons/clear-yellow.png" alt="search">
                                <span>Clear</span>
                            </button>
                            <button id="mytransaction-export-button" class="btn-default curson-pointer transaction-export-button" type="button" value="Export">
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
                            <tbody id="My-Transactions-Table" class="transactions-table">
                               
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
                    <div class="panel-transactions-buttons" data-transactiontype="AllTransactions">
                        <div>
                            <button id="mytransaction-search-button" class="btn-default curson-pointer transaction-search-button" type="submit" value="Search" name="MyTransactionsSubmit">
                                <img src="../public/images/icons/search-yellow.png" alt="search">
                                <span>Search</span>
                            </button>
                            <button id="mytransaction-clear-button" class="btn-default curson-pointer transaction-clear-button" type="reset" value="Clear">
                                <img src="../public/images/icons/clear-yellow.png" alt="search">
                                <span>Clear</span>
                            </button>
                            <button id="mytransaction-export-button" class="btn-default curson-pointer transaction-export-button" type="button" value="Export">
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
                                    <th class="col3"><div>Transaction Address</div></th> 
                                    <th class="col4"><div>Transaction ID</div></th> 
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
        ACCOUNTS 
    -->
                <div id="panel-accounts" class="body-content-panel hidden">
                    <div id="accounts-query" class="panel-accounts-query panel">
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
                    <div class="panel-accounts-buttons" data-transactiontype="mytransactions">
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
                                <thead id="accounts-table-header">
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
                                </thead>
                            </table>
                        </div>
                        <div>
                            <table>
                                <tbody id="accounts-table-body" class="accounts-table">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

    <!--
        FUND REMITTANCE 
    -->
                <div id="panel-fundremittance" class="body-content-panel hidden">
                    <div class="panel-fundremittance-content">
                        <div class="left-panel">
                            <div class="top-panel">
                                <div class="row">
                                    <div class="flex"> 
                                        <p>Date: </p>
                                        <input type="date" name="" id="date-picker" value="">
                                        <input type="text" name="" id="date-text" value="" disabled>
                                    </div>
                                    <div>
                                        <button>Export as File</button>
                                        <button>Submit to Accounting</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div>Total Orders: 250</div>
                                    <div>Total Sales: 250</div>
                                </div>
                            </div>
                            <div class="bottom-panel">
                                <div class="table-container">
                                    <div class="table-header">
                                        <div class="table-row">
                                            <div>#</div>
                                            <div>Transaction#</div>
                                            <div>Status</div>
                                            <div>Amount</div>
                                        </div>
                                    </div>
                                    <div class="table-content">
                                        <div class="table-row">
                                            <div>1</div>
                                            <div>14235235252erwr3</div>
                                            <div>Completed</div>
                                            <div>123,556</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="right-panel">
                            <div class="header">Recent Remitances</div>
                            <div class="table-container">
                                <div class="table-header">
                                    <div class="table-row">
                                        <div>#</div>
                                        <div>Date</div>
                                        <div>Status</div>
                                        <div>Amount</div>
                                    </div>
                                </div>
                                <div class="table-content">
                                    <div class="table-row">
                                        <div class="num">12</div>
                                        <div>September 16, 2023</div>
                                        <div>Completed</div>
                                        <div>123,556</div>
                                    </div>
                                   
                                </div>
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
    <script src="../public/javascript/main-accounting.js" type="module"></script>
    <script src="../public/javascript/chart.js" type="module"></script>
</body>
</html>

