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
    <link rel="stylesheet" href="<?php echo base_url('./public/css/accounting/loginhistory.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('./public/css/accounting/loginhistory.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('./public/css/accounting/activityhistory.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('./public/css/accounting/cards.css'); ?>">
</head>

<body>


    <div class="design-background"></div>
    
<!--
    SIDEBAR
-->  
    <div class="sidebar-container">
        <div class="top-panel">
            <div class="image">
                <img src="<?php echo base_url('./public/images/bcash-logo'); ?>" alt="BCash Logo">
            </div>
            <div class="details">
                <div class="category">BCash: Accounting</div>
                <div id="WebAccountFullName" class="fullname">Loading...</div>
            </div>
            <div class="button-container">
                <button id="menu-notification-button" type="button" class="curson-pointer" title="Notifications"><img src="<?php echo base_url('./public/images/icons/notification-yellow'); ?>" alt="notification-icon"></button>
                <button id="menu-settings-button" type="button" class="curson-pointer" title="Settings"><img src="<?php echo base_url('./public/images/icons/settings-yellow'); ?>" alt="settings-icon"></button>
            </div>
        </div>
        <div class="bottom-panel">
            <div class="pattern"></div>
            <nav class="menu">
                <ul>
                    <li data-menu="Home" class="curson-pointer menu-selected menuSelectionButton">
                        <div class="selected"></div>
                        <img src="<?php echo base_url('./public/images/icons/home'); ?>" alt="Home Icon">
                        <p>Home</p>
                    </li>
                    <li data-menu="Cash In Form" class="curson-pointer menuSelectionButton">
                        <div class="selected"></div>
                        <img src="<?php echo base_url('./public/images/icons/cashin'); ?>" alt="Cash In Icon">
                        <p>Cash-In Form</p>
                    </li>
                    <li data-menu="Transactions Management" class="curson-pointer menuSelectionButton menuSelectionDropdownButton">
                        <img src="<?php echo base_url('./public/images/icons/longreceipt'); ?>" alt="Transactions Icon">
                        <p>Transactions</p>
                        <img id="sidebar-bottom-menu-myorders-more" class="more" src="<?php echo base_url('./public/images/icons/more'); ?>" alt="More Icon">
                    </li>
                    <li class="menuSelectionDropdownItems">
                        <ul>
                            <li data-menu="Accounting Transactions" class="curson-pointer menuSelectionButton">
                                <div class="selected"></div>
                                <p>Accounting Transactions</p>
                            </li>
                            <li data-menu="All Transactions" class="curson-pointer menuSelectionButton">
                                <div class="selected"></div>
                                <p>All Transactions</p>
                            </li>
                        </ul>
                    </li>
                    <li data-menu="Accounts" class="curson-pointer menuSelectionButton">
                        <div class="selected"></div>
                        <img src="<?php echo base_url('./public/images/icons/accounts'); ?>" alt="Accounts Icon">
                        <p>Accounts</p>
                    </li>
                    <li data-menu="Add Guest Account" class="curson-pointer menuSelectionButton">
                        <div class="selected"></div>
                        <img src="<?php echo base_url('./public/images/icons/group'); ?>" alt="Card Icon">
                        <p>Add Guest Account</p>
                    </li>
                    <li data-menu="Fund Remittance" class="curson-pointer menuSelectionButton">
                        <div class="selected"></div>
                        <img src="<?php echo base_url('./public/images/icons/remittance'); ?>" alt="Fund Remittance Icon">
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
                    <img src="<?php echo base_url('./public/images/icons/view-more-white'); ?>" alt="view more">
                </div>
                <div class="image">
                    <img src="<?php echo base_url('./public/images/sscr-logo'); ?>" alt="SSCR Logo">
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
                    <img src="<?php echo base_url('./public/images/icons/logout'); ?>" alt="Logout Icon">
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
                                <div class="chart-header">
                                    <p class="chart-title">Total cash-in today</p>
                                    <div class="chart-value">
                                        <p class="chart-number">???</p>
                                    </div>
                                </div>
                                <div id="chart-total-cash-in" class="chart-mini">
                                    <canvas></canvas>
                                </div>
                            </div>

                            <div class="chart-item">
                                <div class="chart-header">
                                    <p class="chart-title">Total orders in merchants</p>
                                    <div class="chart-value">
                                        <p class="chart-number">???</p>
                                    </div>
                                </div>
                                <div id="chart-total-orders-merchants" class="chart-mini">
                                    <canvas></canvas>
                                </div>
                            </div>

                            <div class="chart-item">
                                <div class="chart-header">
                                    <p class="chart-title">Total Sales in merchants</p>
                                    <div class="chart-value">
                                        <p class="chart-number">???</p>
                                    </div>
                                </div>
                                <div id="chart-total-sales-merchants" class="chart-mini">
                                    <canvas></canvas>
                                </div>
                            </div>

                            <div class="chart-item">
                                <div class="chart-header">
                                    <p class="chart-title">Total transactions today</p>
                                    <div class="chart-value">
                                        <p class="chart-number">???</p>
                                    </div>
                                </div>
                                <div id="chart-total-transactions-today" class="chart-mini">
                                    <canvas></canvas>
                                </div>
                            </div>

                        </div>

                        <div class="charts-container-row2">

                            <div class="chart-5 chart-item">
                                <div class="chart-header">
                                    <p class="chart-title">Daily Transactions Line Graph</p>
                                    <p class="chart-description">This graph depicts the circulation of BCash within the accounting department for the past 7 days.</p>
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
                                <div class="chart-header">
                                    <p class="chart-title">Circulating Money</p>
                                    <p class="chart-description">This chart illustrates the distribution of cash in circulation.</p>
                                </div>
                                <div id="chart-money-in-circulation" class="">
                                    <canvas></canvas>
                                </div>
                            </div>

                        </div>

                        <div class="charts-container-row3">

                            <div class="chart-7 chart-item">
                                <div class="header">
                                    <p class="title">Recent Transactions</p>
                                </div>
                                <ul id="chart-recent-transactions">
                                    <!-- Data -->
                                </ul>
                            </div>

                            <div class="chart-8 chart-item">
                                <div class="header">
                                    <p class="title">Recent Cash-In</p>
                                </div>
                                <ul id="chart-recent-cashin">
                                    <!-- Data -->
                                </ul>
                            </div>

                            <div class="chart-9 chart-item">
                                <div class="header">
                                    <p class="title">Recent Activities</p>
                                </div>
                                <ul id="chart-recent-activities">
                                   <!-- Data -->
                                </ul>
                            </div>

                        </div>

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
                                    <input id="CashIn-Id" type="search" name="" autocomplete="off">
                                </div>

                                <div class="input-container">
                                    <label for="amount">Amount: </label>
                                    <input id="CashIn-Amount" type="text" name="amount" autocomplete="off">
                                </div>

                                <fieldset class="details-container">
                                    <legend>Details</legend>
                                    <div class="item">
                                        <p>Name : </p>
                                        <p id="CashIn-UserName"></p>
                                    </div>
    
                                    <div class="item">
                                        <p>Curent Balance : </p>
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
                            
                            <ul id="CashIn-Content">
                                <!-- Data -->
                            </ul>
                        </div>                        

                        
                    </div>
                </div>

    <!--  
        ACCOUNTING TRANSACTIONS 
    -->
                <div id="panel-accountingtransactions" class="body-content-panel hidden">
                    <div id="My-Transactions-Query" class="panel-transactions-query panel">
                        <div class="form-container">
                            <div>
                                <label for="StartDate">Start Date</label>
                                <input class="transactions-startdate query inputdate" class="textbox" type="date" name="MyTransactionStartDate" autocomplete="off">
                            </div>
                            <div>
                                <label for="EndDate">End Date</label>
                                <input class="transactions-enddate query inputdate" class="textbox" type="date" name="MyTransactionEndDate" autocomplete="off">
                            </div>
                            <div>
                                <label for="TransactionNumber">Transaction Number</label>
                                <input class="transactions-transactionnumber query inputtext" class="textbox" type="text" name="MyTransactionNumber" autocomplete="off">
                            </div>
                            <div>
                                <label for="TransactionName">Search Name</label>
                                <input class="transactions-transactionname query inputtext" class="textbox" type="text" name="MyTransactionName" autocomplete="off">
                            </div>
                            <div>
                                <label>Status Filter</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="transactions-status-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="<?php echo base_url('./public/images/icons/more'); ?>" alt="more">
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
                    <div class="panel-transactions-buttons" data-transactiontype="MyTransactions">
                        <div>
                            <button id="mytransaction-search-button" class="btn-default curson-pointer transaction-search-button" type="submit" value="Search" name="MyTransactionsSubmit">
                                <img src="<?php echo base_url('./public/images/icons/search-yellow'); ?>" alt="search">
                                <span>Search</span>
                            </button>
                            <button id="mytransaction-clear-button" class="btn-default curson-pointer transaction-clear-button" type="reset" value="Clear">
                                <img src="<?php echo base_url('./public/images/icons/clear-yellow'); ?>" alt="search">
                                <span>Clear</span>
                            </button>
                        </div>
                        <div>
                            <p id='mytransaction-records-cashin'>Records : <a class="display-record">0</a></p>
                            <p id='mytransaction-total-cashin'>Amount Total : <a class="display-record">₱ 0.00</a></p>
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
                            <tbody id="My-Transactions-Table" class="transactions-table">
                               
                            </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="My-Transactions-Footer-Query" class="panel-transactions-footer">
                        <div class="dropdown">
                            <div class="dropdown-content">
                                <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)" >50/Page</a>
                                <a class="dropdownButtonSubItem" href="javascript:void(0)">100/Page</a>
                                <a class="dropdownButtonSubItem" href="javascript:void(0)">200/Page</a>
                                <a class="dropdownButtonSubItem" href="javascript:void(0)">All/Page</a>
                            </div>
                            <button class="dropdownButton dropdownbtn curson-pointer" data-layout="top">
                                <span class="transactions-recordscount-dropdown dropdown-text">50/Page</span>
                                <img class="dropdown-arrow" src="<?php echo base_url('./public/images/icons/more.png'); ?>" alt="more">
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
                                <input class="transactions-startdate query inputdate" class="textbox" type="date" name="MyTransactionStartDate" autocomplete="off">
                            </div>
                            <div>
                                <label for="EndDate">End Date</label>
                                <input class="transactions-enddate query inputdate" class="textbox" type="date" name="MyTransactionEndDate" autocomplete="off">
                            </div>
                            <div>
                                <label for="TransactionNumber">Transaction Address</label>
                                <input class="transactions-transactionnumber query inputtext" class="textbox" type="text" name="MyTransactionNumber" autocomplete="off">
                            </div>
                            <div>
                                <label for="TransactionName">Search Name</label>
                                <input class="transactions-transactionname query inputtext" class="textbox" type="text" name="MyTransactionName" autocomplete="off">
                            </div>
                            <div>
                                <label>Status Filter</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span class="transactions-status-dropdown dropdown-text query inputdropdown">All</span>
                                        <img class="dropdown-arrow" src="<?php echo base_url('./public/images/icons/more'); ?>" alt="more">
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
                            <button id="mytransaction-search-button" class="btn-default curson-pointer transaction-search-button" type="submit" value="Search" name="MyTransactionsSubmit">
                                <img src="<?php echo base_url('./public/images/icons/search-yellow'); ?>" alt="search">
                                <span>Search</span>
                            </button>
                            <button id="mytransaction-clear-button" class="btn-default curson-pointer transaction-clear-button" type="reset" value="Clear">
                                <img src="<?php echo base_url('./public/images/icons/clear-yellow'); ?>" alt="search">
                                <span>Clear</span>
                            </button>
                            <button id="mytransaction-export-button" class="btn-default curson-pointer transaction-export-button" type="button" value="Export">
                                <img src="<?php echo base_url('./public/images/icons/download-yellow'); ?>" alt="search">
                                <span>Export</span>
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
                                <img class="dropdown-arrow" src="<?php echo base_url('./public/images/icons/more'); ?>" alt="more">
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
                                        <img class="dropdown-arrow" src="<?php echo base_url('./public/images/icons/more'); ?>" alt="more">
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
                    <div class="panel-accounts-buttons" data-transactiontype="mytransactions">
                        <div>
                            <button class="btn-default curson-pointer accounts-search-button" type="submit" value="Search" name="MyTransactionsSubmit">
                                <img src="<?php echo base_url('./public/images/icons/search-yellow'); ?>" alt="search">
                                <span>Search</span>
                            </button>
                            <button class="btn-default curson-pointer accounts-clear-button" type="reset" value="Clear">
                                <img src="<?php echo base_url('./public/images/icons/clear-yellow'); ?>" alt="search">
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
                                <tbody id="accounts-table-body" class="accounts-table">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

    <!-- 
        ADD GUEST ACCOUNT 
    -->
                <div id="panel-addguestaccount" class="body-content-panel hidden">
                    <div class="panel-add-account">
                        <div>
                            <p class="AddAccount-title">Add Guest Account Form</p>
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
                                    <span class="addaccount-accountcategory-dropdown dropdown-text query inputdropdown">Guest</span>
                                    <img class="dropdown-arrow" src="<?php echo base_url('./public/images/icons/more'); ?>" alt="more">
                                </button>
                                <div class="dropdown-content" id="ActorCategory_Dropdown">
                                    <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">Guest</a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div id="AddAccount-CardAddressContainer" style="display: block;">
                            <p>Card Address : </p>
                            <input id="AddAccount-CardAddress" type="text">
                        </div>
                        <div id="AddAccount-SchoolPersonalIdContainer" style="display: block;">
                            <p>School Personal Id : </p>
                            <input id="AddAccount-SchoolPersonalId" type="text">
                        </div>
                        <hr>
                        <div class="btn-container">
                            <button id="AddAccount-SubmitBtn" class="Btn">Add Account</button>
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
                                </div>
                                <div class="row" id="FundRemittance-Buttons">
                                    
                                </div>
                            </div>
                            <div class="bottom-panel">
                                <div class="table-container">
                                    <div class="table-header">
                                        <p class="details-title">Details</p>
                                    </div>
                                    <div class="row">
                                        <div id="FundRemittance-TotalOrders">Total Orders: 0</div>
                                        <div id="FundRemittance-TotalSales">Total Sales: ₱ 0.00</div>
                                    </div>
                                    <div class="table-content" id="FundRemittance-DetailsContainer">
                                        <!-- TABLE -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="right-panel">
                            <div class="header">Recent Remitances</div>
                            <div class="table-container">
                                <div class="table-header">
                                    <div class="table-row">
                                        <div class="c1">#</div>
                                        <div class="c2">Date</div>
                                        <div class="c3">Status</div>
                                        <div class="c4">Merchant</div>
                                    </div>
                                </div>
                                <div class="table-content" id="FundRemittance-RecentContainer">
                                    <!-- TABLE -->
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
    <script src="<?php echo base_url('./public/javascript/main-accounting.js'); ?>" type="module"></script>
</body>
</html>




