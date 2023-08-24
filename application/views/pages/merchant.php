<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BCash</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="../styles/dialog-box.css">

    <link rel="stylesheet" href="../styles/merchant/home.css">
    <link rel="stylesheet" href="../styles/merchant/menu.css">
    <link rel="stylesheet" href="../styles/merchant/createorder.css">
    <link rel="stylesheet" href="../styles/merchant/transactions.css">
    <link rel="stylesheet" href="../styles/merchant/itemmanagement.css">
</head>

<body>


    <div class="design-background"></div>
    
<!--
    SIDEBAR
-->  
    <div class="sidebar-container">
        <div class="top-panel">
            <div class="image">
                <img src="../images/bcash-logo.png" alt="BCash Logo">
            </div>
            <div class="details">
                <div class="category">BCash: Merchant</div>
                <div class="fullname">Juan Dela Cruz</div>
            </div>
            <div class="button-container">
                <button type="button" class="curson-pointer" title="Notifications"><img src="../images/icons/add-yellow.png" alt="notification-icon"></button>
                <button type="button" class="curson-pointer" title="Settings"><img src="../images/icons/add-yellow.png" alt="settings-icon"></button>
            </div>
        </div>
        <div class="bottom-panel">
            <div class="pattern"></div>
            <nav class="menu">
                <ul>
                    <li id="Home" class="curson-pointer menu-tab menu-selected menuSelectionButton">
                        <div class="selctd"></div>
                        <img src="../images/icons/home.png" alt="Home Icon">
                        <p>Home</p>
                    </li>
                    <li id="MyOrders" class="curson-pointer menu-tab menuSelectionButton">
                        <img src="../images/icons/order.png" alt="My Orders Icon">
                        <p>My Orders</p>
                        <img id="sidebar-bottom-menu-myorders-more" class="more" src="../images/icons/more.png" alt="More Icon">
                    </li>
                    <li id="sidebar-bottom-menu-myorders-subitems">
                        <ul>
                            <li id="CreateOrder" class="curson-pointer menu-tab menuSelectionButton">
                                <div class="selctd"></div>
                                <p>Create Order</p>
                            </li>
                            <li id="Transactions" class="curson-pointer menu-tab menuSelectionButton">
                                <div class="selctd"></div>
                                <p>Transactions</p>
                            </li>
                        </ul>
                    </li>
                    <li id="ItemManagement" class="curson-pointer menu-tab menuSelectionButton">
                        <div class="selctd"></div>
                        <img src="../images/icons/item.png" alt="Item Management Icon">
                        <p>Item Management</p>
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
                    <img src="../images/icons/view-more-white.png" alt="view more">
                </div>
                <div class="image">
                    <img src="../images/sscr-logo.png" alt="SSCR Logo">
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
                    <img src="../images/icons/logout.png" alt="Logout Icon">
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
                <div id="panel-home" class="body-content-panel hidden">
                    <div class="panel-home-welcome">
                        <h3>Welcome Back!</h3>
                        <p>All systems are operating flawlessly, ensuring a smooth and seamless experience as usual.</p>
                    </div>
                    <div class="panel-home-graphs-container">
                        <div class="panel-home-container1">
                            <div class="panel-home-container1-col1">
                                <div class="panel-home-card1">
                                    <h1>123,230.00</h1>
                                    <h4>Sales</h4>
                                </div>
                                <div class="panel-home-card2">
                                    <h1>53</h1>
                                    <h4>Orders</h4>
                                </div>
                            </div>
                            <div class="panel-home-container1-col2">
                                <div class="panel-home-card3">
                                    <h4>Sales Graph</h4>
                                    <canvas id="graph-daily"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="panel-home-container2">
                            <div class="panel-home-card4">
                                <h4>Orders by Items</h4>
                                <canvas id="graph-order-by-items"></canvas>
                            </div>
                            <div class="panel-home-card5">
                                <h4>Sales by Category</h4>
                                <canvas id="graph-sales-by-category"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
    <!--
        TRANSACTIONS 
    -->
                <div id="panel-transactions" class="body-content-panel visible">
                    <div class="panel-transactions-query panel">
                        <div class="form-container">
                            <div>
                                <label for="StartDate">Start Date</label>
                                <input id="transactions-startdate" class="textbox" type="date" name="StartDate">
                            </div>
                            <div>
                                <label for="EndDate">End Date</label>
                                <input id="transactions-enddate" class="textbox" type="date" name="EndDate">
                            </div>
                            <div>
                                <label for="TransactionNumber">Transaction Number</label>
                                <input id="transactions-transactionnumber" class="textbox" type="text" name="TransactionNumber">
                            </div>
                            <div>
                                <label for="TransactionName">Search Name</label>
                                <input id="transaction-transactionname" class="textbox" type="text" name="TransactionName">
                            </div>
                            <div>
                                <label>Status Filter</label>
                                <div class="dropdown">
                                    <button class="dropdownButton dropdownbtn curson-pointer" data-layout="bottom">
                                        <span id="transaction-status-dropdown" class=" dropdown-text">All</span>
                                        <img class="dropdown-arrow" src="../images/icons/more.png" alt="more">
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
                    <div class="panel-transactions-buttons">
                        <div>
                            <button id="transaction-search-button" class="btn-default curson-pointer" type="submit" value="Search" name="TransactionsSubmit">
                                <img src="../images/icons/search-yellow.png" alt="search">
                                <span>Search</span>
                            </button>
                            <button id="transaction-clear-button" class="btn-default curson-pointer" type="reset" value="Clear">
                                <img src="../images/icons/clear-yellow.png" alt="search">
                                <span>Clear</span>
                            </button>
                            <button id="transaction-export-button" class="btn-default curson-pointer" type="button" value="Export">
                                <img src="../images/icons/download-yellow.png" alt="search">
                                <span>Export</span>
                            </button>
                        </div>
                        <div>
                            <div>
                                <div>Total Orders: </div>
                                <div id="transaction-totalorders-text" class="text">???</div>
                            </div>
                            <div>
                                <div >Total Sales: </div>
                                <div id="transaction-totalsales-text" class="text">???</div>
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
                                </tr>Transaction ID, Status, In Charge, Name, Category, Department, Course, Amount, Items, Timestamp, Payment Method, Notes
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
                            <tbody id="transactions-table">
                                <tr>
                                    <td><div class="col1 cell" title="checkbox"><input type="checkbox" name="" id=""></div></td>
                                    <td><div class="col2 cell" title="Completed"><center>2</center></div></td>
                                    <td><div class="col3 cell" title="123456789"><a class="transaction-viewdata-button view-more" href="">123456789</a></div></td>
                                    <td><div class="col4 cell" title="Completed">Completed</div></td>
                                    <td><div class="col5 cell" title="John Doe">John Doe</div></td>
                                    <td><div class="col6 cell" title="Student">Student</div></td>
                                    <td><div class="col7 cell" title="IT Department">IT Department</div></td>
                                    <td><div class="col8 cell" title="BSIT 3">BSIT 3</div></td>
                                    <td><div class="col9 cell" title="150">150</div></td>
                                    <td><div class="col10 cell" title="Good Shit">Good Shit</div></td>
                                    <td><div class="col11 cell" title="2023-05-27 10:30 AM">2023-05-27 10:30 AM</div></td>
                                    <td><div class="col12 cell" title="ABC Store">ABC Store</div></td>
                                    <td><div class="col13 cell" title="ABC Store">ABC Store</div></td>
                                    <td><div class="col14 cell" title="ABC Store">ABC Store</div></td>
                                </tr>                        
                            </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-transactions-footer">
                        <div class="page-numbers-container">
                            <ul id="transaction-pagenumbers" class="page-numbers">
                                <button id="transaction-leftpage-button">&lt;</button>
                                <li><a class="transaction-pagenumber-button curson-pointer selected" onclick="">1</a></li>
                                <li><a class="transaction-pagenumber-button curson-pointer" onclick="">2</a></li>
                                <li><a class="transaction-pagenumber-button curson-pointer" onclick="">3</a></li>
                                <li><a class="transaction-pagenumber-button curson-pointer" onclick="">4</a></li>
                                <li><a class="transaction-pagenumber-button curson-pointer" onclick="">5</a></li>
                                <button id="transaction-rightpage-button">&gt;</button>
                            </ul>
                        </div>
                        <div>
                            <div>Total: </div>
                            <div id="transaction-totalsales-text" class="text">???</div>
                        </div>
                        <div class="dropdown">
                            <div class="dropdown-content">
                                <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)" >25/Page</a>
                                <a class="dropdownButtonSubItem" href="javascript:void(0)">50/Page</a>
                                <a class="dropdownButtonSubItem" href="javascript:void(0)">100/Page</a>
                                <a class="dropdownButtonSubItem" href="javascript:void(0)">500/Page</a>
                            </div>
                            <button class="dropdownButton dropdownbtn curson-pointer" data-layout="top">
                                <span id="transaction-recordscount-dropwond" class="dropdown-text">25/Page</span>
                                <img class="dropdown-arrow" src="../images/icons/more.png" alt="more">
                            </button>
                        </div>
                    </div>
                </div>
    <!--
        ITEM MANAGEMENT 
    -->
                <div id="panel-itemmanagement" class="body-content-panel hidden"> 
                    <div class="panel-itemmanagement-query panel">
                        <div class="forms">
                            <div class="left-panel">
                                <div>
                                    <img class="input-icon icon" src="../images/icons/search-yellow.png" alt="search">
                                    <input placeholder="Search..." id="itemmanagement-search" class="textbox" type="search" name="itemmanagement-search">
                                </div>
                                <div>
                                    <div class="dropdown" data-panel="ItemManagement">
                                        <button title="Category Filter" data-layout="bottom" class="dropdownButton dropdownbtn curson-pointer">
                                            <img class="icon" src="../images/icons/category-yellow.png" alt="category">
                                            <span id="itemmanagement-filter-dropdown" class="dropdown-text">All</span>
                                            <img class="dropdown-arrow" src="../images/icons/more.png" alt="more">
                                        </button>
                                        <div id="itemmanagement-category-choices" class="dropdown-content">
                                            <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="dropdown" data-panel="ItemManagement">
                                        <button title="Sort" data-layout="bottom" class="dropdownButton dropdownbtn curson-pointer">
                                            <img class="icon" src="../images/icons/sort-yellow.png" alt="sort">
                                            <span id="itemmanagement-sort-dropdown" class="dropdown-text">Ascending</span>
                                            <img class="dropdown-arrow" src="../images/icons/more.png" alt="more">
                                        </button>
                                        <div class="dropdown-content">
                                            <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">Ascending</a>
                                            <a class="dropdownButtonSubItem" href="javascript:void(0)">Descending</a>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="dropdown" data-panel="ItemManagement">
                                        <button title="Layout View" data-layout="bottom" class="dropdownButton dropdownbtn curson-pointer">
                                            <img id="icon-layout-1" class="icon" src="../images/icons/list-yellow.png" alt="layout">
                                            <span id="itemmanagement-layout-dropdown" class="dropdown-text">List</span>
                                            <img class="dropdown-arrow" src="../images/icons/more.png" alt="more">
                                        </button>
                                        <div class="dropdown-content">
                                            <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">List</a>
                                            <a class="dropdownButtonSubItem" href="javascript:void(0)">Card</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="right-panel">
                                <div>
                                    <button class="curson-pointer addItemButton" type="button">
                                        <img class="icon" src="../images/icons/add-yellow.png" alt="layout">
                                        <span>Add Item</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-itemmanagement-content">
                        <div class="list-layout"></div>
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
                                    <img class="input-icon icon" src="../images/icons/search-yellow.png" alt="search">
                                    <input placeholder="Search..." id="createorder-search" class="textbox" type="search" name="createorder-search">
                                </div>
                                <div>
                                    <div class="dropdown" data-panel="CreateOrder">
                                        <button title="Category Filter" data-layout="bottom" class="dropdownButton dropdownbtn curson-pointer">
                                            <img class="icon" src="../images/icons/category-yellow.png" alt="category">
                                            <span id="createorder-filter-dropdown" class="dropdown-text">All</span>
                                            <img class="dropdown-arrow" src="../images/icons/more.png" alt="more">
                                        </button>
                                        <div id="createorder-category-choices" class="dropdown-content">
                                            <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="dropdown" data-panel="CreateOrder">
                                        <button title="Sort" data-layout="bottom" class="dropdownButton dropdownbtn curson-pointer">
                                            <img class="icon" src="../images/icons/sort-yellow.png" alt="sort">
                                            <span id="createorder-sort-dropdown" class="dropdown-text">Ascending</span>
                                            <img class="dropdown-arrow" src="../images/icons/more.png" alt="more">
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
                                            <img id="icon-layout-1" class="icon" src="../images/icons/list-yellow.png" alt="layout">
                                            <span id="createorder-layout-dropdown" class="dropdown-text">List</span>
                                            <img class="dropdown-arrow" src="../images/icons/more.png" alt="more">
                                        </button>
                                        <div class="dropdown-content">
                                            <a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">List</a>
                                            <a class="dropdownButtonSubItem" href="javascript:void(0)">Card</a>
                                        </div>
                                    </div>
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
                                            <img src="../images/icons/delete-red.png" alt="">
                                        </button>
                                        <button id="createorder-placeorder" type="button" class="placeOrderButton curson-pointer">
                                            <img src="../images/icons/order-receipt.png" alt="">
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
    NOTIFICATION ###
-->
    <div id="Notification-Box-Container" class="notification-container">
        <div id="Notification-Box-Id" class="notification-box">
            <div class="header">
                <div class="title">
                    <p class="text">New Notification 1</p>
                </div>
                <div class="close">
                    <p class="close-btn curson-pointer" onclick="removeNotificationBox(this)">X</p>
                </div>
            </div>
            <div class="notification-content">
                <p>123</p>
            </div>
        </div>
    </div>
<!--
    DIALOG BOX ###
-->
    <div id="Dialog-Box-Container" class="dialog-container">
        <div class="dialog-content">
            <div class="header">
                <div class="title">
                    <p id="Dialog-Box-header" class="text">N/A</p>
                </div>
                <div class="close" >
                    <p id="Dialog-Box-Close-Button" class="close-btn curson-pointer">X</p>
                </div>
            </div>
            <div id="Dialog-Box-Body" class="body">
            </div>
        </div>
    </div>
<!--
    JAVASCRIPTS  ###
-->

