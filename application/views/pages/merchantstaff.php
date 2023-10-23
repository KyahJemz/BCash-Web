<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BCash - Merchant</title>
    <link rel="stylesheet" href="<?php echo base_url('./public/css/styles.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('./public/css/dialog-box.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('./public/css/menu.css'); ?>">

    <link rel="stylesheet" href="<?php echo base_url('./public/css/merchant/home.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('./public/css/merchant/itemmanagement.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('./public/css/merchant/createorder.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('./public/css/merchant/transactions.css'); ?>">
</head>


<body>


    <div class="design-background"></div>
    
<!--
    SIDEBAR
-->  
    <div class="sidebar-container">
        <div class="top-panel">
            <div class="image">
                <img src="<?php echo base_url('./public/images/bcash-logo.png'); ?>" alt="BCash Logo">
            </div>
            <div class="details">
                <div class="category">BCash: Merchant</div>
                <div class="fullname" id="WebAccountFullName">Loading...</div>
            </div>
            <div class="button-container">
                <button id="menu-notification-button" type="button" class="curson-pointer" title="Notifications"><img src="<?php echo base_url('./public/images/icons/notification-yellow.png'); ?>" alt="notification-icon"></button>
                <button id="menu-settings-button" type="button" class="curson-pointer" title="Settings"><img src="<?php echo base_url('./public/images/icons/settings-yellow.png'); ?>" alt="settings-icon"></button>
            </div>
        </div>
        <div class="bottom-panel">
            <div class="pattern"></div>
            <nav class="menu">
                <ul>
                    <li data-menu="Home" class="curson-pointer menu-selected menuSelectionButton">
                        <div class="selected"></div>
                        <img src="<?php echo base_url('./public/images/icons/home.png'); ?>" alt="Home Icon">
                        <p>Home</p>
                    </li>
                    <li data-menu="My Orders" class="curson-pointer menuSelectionButton menuSelectionDropdownButton">
                        <img src="<?php echo base_url('./public/images/icons/order.png'); ?>" alt="My Orders Icon">
                        <p>My Orders</p>
                        <img id="sidebar-bottom-menu-myorders-more" class="more" src="<?php echo base_url('./public/images/icons/more.png'); ?>" alt="More Icon">
                    </li>
                    <li class="menuSelectionDropdownItems">
                        <ul>
                            <li data-menu="Create Order" class="curson-pointer menuSelectionButton">
                                <div class="selected"></div>
                                <p>Create Order</p>
                            </li>
                            <li data-menu="Transactions" class="curson-pointer menuSelectionButton">
                                <div class="selected"></div>
                                <p>Transactions</p>
                            </li>
                        </ul>
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
                    <img src="<?php echo base_url('./public/images/icons/view-more-white.png'); ?>" alt="view more">
                </div>
                <div class="image">
                    <img src="<?php echo base_url('./public/images/sscr-logo.png'); ?>" alt="SSCR Logo">
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
                    <img src="<?php echo base_url('./public/images/icons/logout.png'); ?>" alt="Logout Icon">
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
                   
                </div>

    <!--
        TRANSACTIONS 
    -->
                <div id="panel-transactions" class="body-content-panel hidden">
                    <div id="My-Tansactions-Query" class="panel-transactions-query panel">
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
                    <div class="panel-transactions-buttons">
                        <div>
                            <button class="btn-default curson-pointer transaction-search-button" type="submit" value="Search" name="TransactionsSubmit">
                                <img src="<?php echo base_url('./public/images/icons/search-yellow.png'); ?>" alt="search">
                                <span>Search</span>
                            </button>
                            <button class="btn-default curson-pointer transaction-clear-button" type="reset" value="Clear">
                                <img src="<?php echo base_url('./public/images/icons/clear-yellow.png'); ?>" alt="search">
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
                            <tbody id="My-Tansactions-Table" class="transactions-table">
                                      
                            </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-transactions-footer" id="My-Transactions-Footer-Query">
                        <div class="dropdown">
                            <div class="dropdown-content">
                                <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)" >50/Page</a>
                                <a class="dropdownButtonSubItem" href="javascript:void(0)">100/Page</a>
                                <a class="dropdownButtonSubItem" href="javascript:void(0)">200/Page</a>
                                <a class="dropdownButtonSubItem" href="javascript:void(0)">All/Page</a>
                            </div>
                            <button class="dropdownButton dropdownbtn curson-pointer" data-layout="top">
                                <span class="transactions-recordscount-dropwond" class="dropdown-text">50/Page</span>
                                <img class="dropdown-arrow" src="<?php echo base_url('./public/images/icons/more.png'); ?>" alt="more">
                            </button>
                        </div>
                    </div>
                </div>
    <!--
        CREATE ORDER 
    -->
                <div id="panel-createorder" class="body-content-panel hidden">
                    <div class="panel-createorder-content">
                        <div class="left-panel">
                            <div class="query-container panel"> 
                                <div>
                                    <img class="input-icon icon" src="<?php echo base_url('./public/images/icons/search-yellow.png'); ?>" alt="search">
                                    <input placeholder="Search..." id="createorder-search" class="textbox" type="search" name="createorder-search">
                                </div>
                                <div>
                                    <div class="dropdown" data-panel="CreateOrder">
                                        <button title="Sort" data-layout="bottom" class="dropdownButton dropdownbtn curson-pointer">
                                            <img class="icon" src="<?php echo base_url('./public/images/icons/sort-yellow.png'); ?>" alt="sort">
                                            <span id="createorder-sort-dropdown" class="dropdown-text">Ascending</span>
                                            <img class="dropdown-arrow" src="<?php echo base_url('./public/images/icons/more.png'); ?>" alt="more">
                                        </button>
                                        <div class="dropdown-content">
                                            <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">Ascending</a>
                                            <a class="dropdownButtonSubItem" href="javascript:void(0)">Descending</a>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="dropdown" data-panel="CreateOrder">
                                        <button title="Layout View" data-layout="bottom" class="dropdownButton dropdownbtn curson-pointer">
                                            <img id="icon-layout-1" class="icon" src="<?php echo base_url('./public/images/icons/list-yellow.png'); ?>" alt="layout">
                                            <span id="createorder-layout-dropdown" class="dropdown-text">List</span>
                                            <img class="dropdown-arrow" src="<?php echo base_url('./public/images/icons/more.png'); ?>" alt="more">
                                        </button>
                                        <div class="dropdown-content">
                                            <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">List</a>
                                            <a class="dropdownButtonSubItem" href="javascript:void(0)">Details</a>
                                            <a class="dropdownButtonSubItem" href="javascript:void(0)">Tiles</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="category-container">
                                <p>Category:</p>
                                <div class="category-list" id="createorder-category" data-type="CreateOrder">
                                </div>
                            </div>
                            <div class="order-items-container"> 
                                <div class="card-layout"></div>
                            </div>
                        </div>

                        <div class="right-panel">
                            <div class="receipt-container panel"> 
                                <div class="title">
                                    <p >Order:</p>
                                </div>
                                <div id="order-list" class="orders"></div>
                                <div class="summary">
                                    <hr>
                                    <div class="details">
                                        <p id="order-quantity">Quantity: 0</p>
                                        <p id="order-subtotal">Subtotal: ₱0</p>
                                    </div>
                                    <div class="discount">
                                        <p>Discount: ₱</p>
                                        <input id="txt-order-Discount" type="number" name="" id="" value="0.00">
                                    </div>
                                    <div class="total">
                                        <p id="order-total">Total: ₱0</p>
                                    </div>
                                    <hr>
                                    <div class="button-container">
                                        <button id="createorder-clear" type="button" class="curson-pointer">
                                            <img src="<?php echo base_url('./public/images/icons/delete-red.png'); ?>" alt="">
                                        </button>
                                        <button id="createorder-placeorder" type="button" class="placeOrderButton curson-pointer">
                                            <img src="<?php echo base_url('./public/images/icons/order-receipt.png'); ?>" alt="">
                                            <p>Place Order</p>
                                        </button>
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
    <script src="../public/javascript/chart.js"></script>
    <script src="../public/javascript/main-merchant.js" type="module"></script>
</body>
</html>

