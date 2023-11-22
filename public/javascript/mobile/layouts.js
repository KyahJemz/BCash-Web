export default class Layouts {

    static SplashScreen(){
        return `
        <div class="SplashScreen">
            <div class="SplashScreen-logo">
                <img src="${BaseURL}../public/images/mobile/bcash_logo_white.png" alt="" srcset="">
            </div>
            <p class="SplashScreen-title">Baste E-wallet</p>
            <p class="SplashScreen-subtitle">San Sebastian College - Recoletos</p>
        </div>
        `;
    }

    static Login(){
        return `
        <div class="Login">
            <div class="Login-Background"></div>
            <div class="Top">
                <p class="Login-head1">Welcome To</p>
                <p class="Login-head2">Baste E-Wallet</p>
                <p class="Login-head3">Hassle-free transactions made possible</p>
            </div>
            <div class="Bottom">
                <p>Sign in with your SSCR email</p>
                <div id="Login-SignIn" class="Login-button g_id_signin" data-type="standard">
                   
                </div>
            </div>
        </div>
        `;
    }

    static PinValidation(){
        return `
        <div class="PinValidation">
            <div class="Top">
                <p class="PinValidation-title">Enter PIN code</p>
                <div class="CodeBoxContainer">
                    <div class="CodeBox PinValidation1"></div>
                    <div class="CodeBox PinValidation2"></div>
                    <div class="CodeBox PinValidation3"></div>
                    <div class="CodeBox PinValidation4"></div>
                    <div class="CodeBox PinValidation5"></div>
                    <div class="CodeBox PinValidation6"></div>
                </div>
                <p class="PinValidation-subtitle">PIN code adds extra layer of security</p>
                <p class="PinValidation-subtitle">when using the app</p>
            </div>
            <div class="Bottom">
                <div class="keypad">
                    <table>
                        <tr><td class="keypad-1">1</td><td class="keypad-2">2</td><td class="keypad-3">3</td></tr>
                        <tr><td class="keypad-4">4</td><td class="keypad-5">5</td><td class="keypad-6">6</td></tr>
                        <tr><td class="keypad-7">7</td><td class="keypad-8">8</td><td class="keypad-9">9</td></tr>
                        <tr><td class="keypad-11">X</td><td class="keypad-0">0</td><td class="keypad-12">&lt;</td></tr>
                    </table>
                </div>
            </div>
        </div>
        `;
    }

    static PinCreation(){
        return `
        <div class="PinCreation">
            <div class="Top">
                <p class="PinCreation-title">Enter your desired PIN Code</p>
                <div class="CodeBoxContainer">
                    <div class="CodeBox PinCreation1"></div>
                    <div class="CodeBox PinCreation2"></div>
                    <div class="CodeBox PinCreation3"></div>
                    <div class="CodeBox PinCreation4"></div>
                    <div class="CodeBox PinCreation5"></div>
                    <div class="CodeBox PinCreation6"></div>
                </div>
                <br>
                <p class="PinCreation-title">Re-enter your PIN Code</p>
                <div class="CodeBoxContainer">
                    <div class="CodeBox PinCreation7"></div>
                    <div class="CodeBox PinCreation8"></div>
                    <div class="CodeBox PinCreation9"></div>
                    <div class="CodeBox PinCreation10"></div>
                    <div class="CodeBox PinCreation11"></div>
                    <div class="CodeBox PinCreation12"></div>
                </div>
            </div>
            <div class="Bottom">
                <div class="keypad">
                    <table>
                        <tr><td class="keypad-1">1</td><td class="keypad-2">2</td><td class="keypad-3">3</td></tr>
                        <tr><td class="keypad-4">4</td><td class="keypad-5">5</td><td class="keypad-6">6</td></tr>
                        <tr><td class="keypad-7">7</td><td class="keypad-8">8</td><td class="keypad-9">9</td></tr>
                        <tr><td class="keypad-11">X</td><td class="keypad-0">0</td><td class="keypad-12">&lt;</td></tr>
                    </table>
                </div>
            </div>
        </div>
        `;
    }

    static OTPValidation(){
        return `
        <div class="OTPValidation">
            <div class="Top">
                <p class="OTPValidation-title">Enter OTP code</p>
                <div class="CodeBoxContainer">
                    <div class="CodeBox OTPValidation1"></div>
                    <div class="CodeBox OTPValidation2"></div>
                    <div class="CodeBox OTPValidation3"></div>
                    <div class="CodeBox OTPValidation4"></div>
                    <div class="CodeBox OTPValidation5"></div>
                    <div class="CodeBox OTPValidation6"></div>
                </div>
                <p class="OTPValidation-subtitle">A OTP code has been sent to your email.</p>
                <p class="OTPValidation-subtitle">OTP is valid for 5 minutes.</p>
            </div>
            <div class="Bottom">
                <div class="keypad">
                    <table>
                        <tr><td class="keypad-1">1</td><td class="keypad-2">2</td><td class="keypad-3">3</td></tr>
                        <tr><td class="keypad-4">4</td><td class="keypad-5">5</td><td class="keypad-6">6</td></tr>
                        <tr><td class="keypad-7">7</td><td class="keypad-8">8</td><td class="keypad-9">9</td></tr>
                        <tr><td class="keypad-11">X</td><td class="keypad-0">0</td><td class="keypad-12">&lt;</td></tr>
                    </table>
                </div>
            </div>
        </div>
        `;
    }

    static Home(){
        return `
        <div class="Home">
            <div class="Home-Background"></div>
            <div class="Home-Content">
                <div class="Home-Header">
                    <div class="Left">
                        <p class="Home-Greetings">Good day,</p>
                        <p id="Home-Fullname" class="Home-FullName">Stephen Layson</p>
                    </div>
                    <div class="Right">
                        <img src="${BaseURL}.${BaseURL}../public/images/mobile/icon_nav2.png" alt="pp">
                    </div>
                </div>
                <div class="Home-Card">
                    <p class="Home-Card-P1">Main Card</p>
                    <p class="Home-Card-P2">Balance</p>
                    <div class="Home-Card-Row"><p id="Home-Card-Balance">Loading...</p><img id="Home-Card-Balance-Toggle" src="${BaseURL}../public/images/mobile/icon_visibility_off.png" alt=""></div>
                    <div class="Home-Card-Row"><p id="Home-Card-SID">Loading...</p><img id="Home-Card-SID-Toggle" src="${BaseURL}../public/images/mobile/icon_visibility_off.png" alt=""></div>
                    <p id="Home-Card-Name" class="Home-Card-P2">Stephen Layson</p>
                    <img class="Home-Card-Logo" src="${BaseURL}../public/images/mobile/logo_sscr.png" alt="">
                </div>
                <div class="Home-NavBar">
                    <div id="Home-NavBar-1" class="Home-Nav">
                        <div class="Home-Nav-Icon"><img src="${BaseURL}../public/images/mobile/icon_home_card_nav_1.png" alt=""></div>
                        <p>Cash In</p>
                    </div>
                    <div id="Home-NavBar-2" class="Home-Nav">
                        <div class="Home-Nav-Icon"><img src="${BaseURL}../public/images/mobile/icon_home_card_nav_2.png" alt=""></div>
                        <p>Transfer</p>
                    </div>
                    <div id="Home-NavBar-3" class="Home-Nav">
                        <div class="Home-Nav-Icon"><img src="${BaseURL}../public/images/mobile/icon_home_card_nav_3.png" alt=""></div>
                        <p>QR Code</p>
                    </div>
                    <div id="Home-NavBar-4" class="Home-Nav">
                        <div class="Home-Nav-Icon"><img src="${BaseURL}../public/images/mobile/icon_home_card_nav_4.png" alt=""></div>
                        <p>Whitelist</p>
                    </div>
                    <div id="Home-NavBar-5" class="Home-Nav">
                        <div class="Home-Nav-Icon"><img src="${BaseURL}../public/images/mobile/icon_home_card_nav_5.png" alt=""></div>
                        <p>Settings</p>
                    </div>
                </div>
                <div class="Home-RecentTransactions">
                    <div class="Home-RecentTransactions-Header">
                        <p class="title">Recent Transactions</p>
                        <p id="Home-RecentTransactions-More" class="more pointer">View More</p>
                    </div>
                    <hr/>
                    <div class="Home-RecentTransactions-Content">
                        <div id="Home-RecentTransactions" class="scroll">
                           
                        </div>
                    </div>
                </div>
            </div>
            <div class="NavBar">
                <div class="Nav Nav1">
                    <img class="Active" src="${BaseURL}../public/images/mobile/icon_nav1.png" alt="1">
                    <p class="Active">Home</p>
                </div>
                <div class="Nav Nav2">
                    <img src="${BaseURL}../public/images/mobile/icon_nav2.png" alt="2">
                    <p>Transactions</p>
                </div>
                <div class="Nav Nav3">
                    <img src="${BaseURL}../public/images/mobile/icon_nav3.png" alt="3">
                    <p>Announcements</p>
                </div>
                <div class="Nav Nav4">
                    <img src="${BaseURL}../public/images/mobile/icon_nav4.png" alt="4">
                    <p>Profile</p>
                </div>
            </div>
        </div>
        `;
    }

    static Transactions(){
        return `
        <div class="Transactions">
            <div class="Transactions-Background"></div>
            <div class="Header">
                <p>Transaction History</p>
            </div>

            <div id="Transactions-Container" class="Transactions-Content">
                
            </div>

            <div class="NavBar">
                <div class="Nav Nav1">
                    <img src="${BaseURL}../public/images/mobile/icon_nav1.png" alt="1">
                    <p>Home</p>
                </div>
                <div class="Nav Nav2">
                    <img class="Active" src="${BaseURL}../public/images/mobile/icon_nav2.png" alt="2">
                    <p class="Active">Transactions</p>
                </div>
                <div class="Nav Nav3">
                    <img src="${BaseURL}../public/images/mobile/icon_nav3.png" alt="3">
                    <p>Announcements</p>
                </div>
                <div class="Nav Nav4">
                    <img src="${BaseURL}../public/images/mobile/icon_nav4.png" alt="4">
                    <p>Profile</p>
                </div>
            </div>
        </div>
        `;
    }

    static Announcements(){
        return `
        <div class="Announcements">
            <div class="Announcements-Background"></div>

            <div class="Header">
                <p>Announcements</p>
            </div>

            <div class="Announcements-Content">
               
            </div>

            <div class="NavBar">
                <div class="Nav Nav1">
                    <img src="${BaseURL}../public/images/mobile/icon_nav1.png" alt="1">
                    <p>Home</p>
                </div>
                <div class="Nav Nav2">
                    <img src="${BaseURL}../public/images/mobile/icon_nav2.png" alt="2">
                    <p>Transactions</p>
                </div>
                <div class="Nav Nav3">
                    <img class="Active" src="${BaseURL}../public/images/mobile/icon_nav3.png" alt="3">
                    <p class="Active">Announcements</p>
                </div>
                <div class="Nav Nav4">
                    <img src="${BaseURL}../public/images/mobile/icon_nav4.png" alt="4">
                    <p>Profile</p>
                </div>
            </div>
        </div>
        `;
    }

    static Profile(){
        return `
        <div class="Profile">
            <div class="Profile-Background"></div>
            <div class="Profile-Content">

                <img class="Profile-Image" src="${BaseURL}../public/images/mobile/icon_profile_security_settings.png" alt="">
                <p class="Profile-Name">Stephen Layson</p>
                <p class="Profile-Email">s.stephen.layson@sscr.edu</p>

                <div class="Profile-Row Pointer Profile-Nav-1">
                    <div class="left"><img src="${BaseURL}../public/images/mobile/icon_profile_security_settings.png" alt=""></div>
                    <p>Security Settings</p>
                    <img class="right" src="${BaseURL}../public/images/mobile/icon_next.png" alt="">
                </div>

                <div class="Profile-Row">
                    <p class="title">General Settings</p>
                </div>

                <div class="Profile-Row">
                    <div class="left"><img src="${BaseURL}../public/images/mobile/icon_profile_transfer.png" alt=""></div>
                    <p>Allow Transfers</p>
                    <label class="switch right">
                        <input class="Config" id="Config-AllowTransfer" type="checkbox">
                        <span class="slider round"></span>
                    </label>
                </div>

                <div class="Profile-Row">
                    <div class="left"><img src="${BaseURL}../public/images/mobile/icon_profile_transactions.png" alt=""></div>
                    <p>Allow Transactions</p>
                    <label class="switch right">
                        <input class="Config" id="Config-AllowTransactions" type="checkbox">
                        <span class="slider round"></span>
                    </label>
                </div>

                <div class="Profile-Row">
                    <div class="left"><img src="${BaseURL}../public/images/mobile/icon_profile_card.png" alt=""></div>
                    <p>Allow Use of Card</p>
                    <label class="switch right">
                        <input class="Config" id="Config-AllowCard" type="checkbox">
                        <span class="slider round"></span>
                    </label>
                </div>

                <div class="Profile-Row">
                    <div class="left"><img src="${BaseURL}../public/images/mobile/icon_profile_confirm.png" alt=""></div>
                    <p>Transaction Auto Confirm</p>
                    <label class="switch right">
                        <input class="Config" id="Config-AutoConfirm" type="checkbox">
                        <span class="slider round"></span>
                    </label>
                </div>

                <div class="Profile-Row Guardian-Row">
                    <div class="left"><img src="${BaseURL}../public/images/mobile/icon_profile_confirm_manage_settings.png" alt=""></div>
                    <p>Allow Modify Settings</p>
                    <label class="switch right">
                        <input class="Config" id="Config-ManageSettings" type="checkbox">
                        <span class="slider round"></span>
                    </label>
                </div>

                <div class="Profile-Row">
                    <p class="title">More</p>
                </div>

                <div class="Profile-Row Pointer Profile-Nav-2">
                    <div class="left"><img src="${BaseURL}../public/images/mobile/icon_profile_whitelist.png" alt=""></div>
                    <p>Whitelist</p>
                    <img class="right" src="${BaseURL}../public/images/mobile/icon_next.png" alt="">
                </div>

                <div class="Profile-Row Pointer Profile-Nav-3">
                    <div class="left"><img src="${BaseURL}../public/images/mobile/icon_profile_activity_logs.png" alt=""></div>
                    <p>Activity Logs</p>
                    <img class="right" src="${BaseURL}../public/images/mobile/icon_next.png" alt="">
                </div>

                <div class="Profile-Row Pointer Profile-Nav-4">
                    <div class="left"><img src="${BaseURL}../public/images/mobile/icon_profile_login_history.png" alt=""></div>
                    <p>Login History</p>
                    <img class="right" src="${BaseURL}../public/images/mobile/icon_next.png" alt="">
                </div>

                <div class="Profile-Row Pointer Profile-Nav-5">
                    <div class="left"><img src="${BaseURL}../public/images/mobile/icon_profile_logout.png" alt=""></div>
                    <p>Logout</p>
                    <img class="right" src="${BaseURL}../public/images/mobile/icon_next.png" alt="">
                </div>

                <div class="pin-confirmation-container" id="pinConfirmation">
                    <div class="pin-confirmation-content">
                        <div class="pin-confirmation-title">Enter Pin Code</div>
                        <input type="password" class="pin-confirmation-input" id="Config-pinCode" maxlength="6" placeholder="6 digit PIN code">
                        <div class="pin-confirmation-buttons">
                            <div class="pin-confirmation-button" id="btnCancel">Cancel</div>
                            <div class="pin-confirmation-button" id="btnConfirm">Confirm</div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="NavBar">
                <div class="Nav Nav1">
                    <img src="${BaseURL}../public/images/mobile/icon_nav1.png" alt="1">
                    <p>Home</p>
                </div>
                <div class="Nav Nav2">
                    <img src="${BaseURL}../public/images/mobile/icon_nav2.png" alt="2">
                    <p>Transactions</p>
                </div>
                <div class="Nav Nav3">
                    <img src="${BaseURL}../public/images/mobile/icon_nav3.png" alt="3">
                    <p>Announcements</p>
                </div>
                <div class="Nav Nav4">
                    <img class="Active" src="${BaseURL}../public/images/mobile/icon_nav4.png" alt="4">
                    <p class="Active">Profile</p>
                </div>
            </div>
        </div>
        `;
    }

    static SecuritySettings(){
        return `
        <div class="SecuritySettings">
            <div class="SecuritySettings-Background"></div>
            <div class="Mini-Header">
                <img class="Back" src="${BaseURL}../public/images/mobile/icon_back.png" alt="">
            </div>

            <div class="SecuritySettings-Content">
                <p class="Activity-Title">Security Settings</p>
                <p class="Activity-Notes">For your safety and protection, please input your unique PIN code in the field below. This PIN code ensures that only you can access your account.</p>
                <p class="Activity-Notes">Please refrain from sharing this PIN code with anyone to maintain the confidentiality and security of your account.
                <p class="Activity-Notes bold center">Thank you for keeping your account secure!</p>
                <div class="Form-Box">
                    <p class="Form-Label">Old PIN code</p>
                    <input id="SecuritySettings-OldPin" class="Form-Pin" type="password" maxlength="6" placeholder="Old PIN code">
                </div>
                <div class="Form-Box">
                    <p class="Form-Label">New PIN code</p>
                    <input id="SecuritySettings-NewPin" class="Form-Pin" type="password" maxlength="6" placeholder="New PIN code">
                </div>
                <div class="Form-Box">
                    <p class="Form-Label">Re-type new PIN code</p>
                    <input id="SecuritySettings-ReNewPin" class="Form-Pin" type="password" maxlength="6"  placeholder="Re-type new PIN code">
                </div>
                <div class="Form-Box">
                    <button id="SecuritySettings-Btn" class="Form-Button">Change PIN code</button>
                </div>
            </div>
        </div>
        `;
    }

    static Whitelist(){
        return `
        <div class="Whitelist">
            <div class="Whitelist-Background"></div>
            <div class="Mini-Header">
                <img class="Back" src="${BaseURL}../public/images/mobile/icon_back.png" alt="">
            </div>

            <div class="Whitelist-Header">
                <p class="Activity-Title">Whitelist</p>
                <p class="Activity-Notes">Only trusted and whitelisted accounts are authorized for fund transfers within the application.</p>
            </div>

            <div class="Whitelist-Content">
              

                
            </div>

            <div class="Whitelist-Footer">
                <div class="Form-Box">
                    <button id="Whitelist-Add" class="Form-Button">Add Account</button>
                </div>
            </div>
        </div>
        `;
    }

    static WhitelistAdd(){
        return `
        <div class="WhitelistAdd">
            <div class="WhitelistAdd-Background"></div>
            <div class="Mini-Header">
                <img class="Back" src="${BaseURL}../public/images/mobile/icon_back.png" alt="">
            </div>

            <div class="WhitelistAdd-Header">
                <p class="Activity-Title">Whitelist Add Account</p>
                <p class="Activity-Notes">Only trusted and whitelisted accounts are authorized for fund transfers within the application.</p>
            </div>

            <div class="WhitelistAdd-Content">

                <div class="Form-Box">
                    <p class="Form-Label">Whitelisting School ID Number:</p>
                    <input id="WhitelistAdd-Id" class="Form-Text" type="text"  placeholder="Id Number">
                </div>

                <div class="Form-Box WhitelistAdd-closed">
                    <p class="Form-Label">Whitelisting Name:</p>
                    <input id="WhitelistAdd-Name" class="Form-Text" type="text" disabled>
                </div>

                <p class="Activity-Notes WhitelistAdd-TopNotes">By adding an account to your whitelist, you confirm that the provided information is accurate and has been validated to the best of your knowledge. Proceeding with this action will authorize the added account for privileged access and transactions based on your permissions.</p>
                <p class="Activity-Notes">Please ensure that the account details and permissions are verified before adding them to your whitelist.</p>
                <p class="Activity-Notes WhitelistAdd-BottomNotes WhitelistAdd-closed">Would you like to continue and add this account to your whitelist?</p>
              
                <div class="Form-Box WhitelistAdd-Footer WhitelistAdd-closed" >
                    <p class="Form-Label">Your PIN Code</p>
                    <input id="WhitelistAdd-PIN" class="Form-Text" type="password" maxlength="6" placeholder="6 digit PIN code">
                </div>

                <div class="Form-Box WhitelistAdd-closed">
                    <button id="WhitelistAdd-Add" class="Form-Button">Add Account</button>
                </div>

            </div>

        </div>
        `;
    }

    static ActivityLogs(){
        return `
        <div class="ActivityLogs">
            <div class="ActivityLogs-Background"></div>
            <div class="Mini-Header">
                <img class="Back" src="${BaseURL}../public/images/mobile/icon_back.png" alt="">
            </div>

            <div class="ActivityLogs-Header">
                <p class="Activity-Title">Activity Logs</p>
                <p class="Activity-Notes">You can monitor your recent activities and interactions within the app. If you notice any suspicious or potentially harmful changes, please notify the system administrators immediately.</p>
            </div>

            <div class="ActivityLogs-Content">

            </div>

        </div>
        `;
    }

    static LoginHistory(){
        return `
        <div class="LoginHistory">
            <div class="LoginHistory-Background"></div>
            <div class="Mini-Header">
                <img class="Back" src="${BaseURL}../public/images/mobile/icon_back.png" alt="">
            </div>

            <div class="LoginHistory-Header">
                <p class="Activity-Title">Login History</p>
                <p class="Activity-Notes">Monitor your login history closely and be vigilant for any unauthorized access. Should such incidents reoccur, change your PIN immediately and seek guidance from system administrators.</p>
            </div>

            <div id="LoginHistory-Content" class="LoginHistory-Content">

            </div>

            <div class="LoginHistory-Footer">
                <div class="Form-Box">
                    <button id="LoginHistory-Btn" class="Form-Button">Remove all saved logins</button>
                </div>
            </div>

        </div>
        `;
    }

    static Transfer(){
        return `
        <div class="Transfer">
            <div class="Transfer-Background"></div>
            <div class="Mini-Header">
                <img class="Back" src="${BaseURL}../public/images/mobile/icon_back.png" alt="">
            </div>

            <div class="Transfer-Header">
                <p class="Activity-Title">Transfer Form</p>
                <p class="Activity-Notes">Please double-check the entered amount and recipient before confirming the transfer.</p>
            </div>

            <div class="Transfer-Content">

                <div class="Form-Box" >
                    <p class="Form-Label">Receiver School Id Number:</p>
                    <input id="Transfer-SchooId" class="Form-Text" type="text" placeholder="Id number">
                </div>

                <div class="Form-Box" >
                    <p class="Form-Label">Amount:</p>
                    <input id="Transfer-Amount" class="Form-Text" type="number" placeholder="1.00 - 1,000.00">
                </div>

                <div class="Form-Box" >
                    <p class="Form-Label">Message:</p>
                    <input id="Transfer-Message" class="Form-Text" type="text" placeholder="optional">
                </div>

                <div class="Form-Box">
                    <button id="Transfer-Btn" class="Form-Button">Transfer</button>
                </div>
            </div>

        </div>
        `;
    }

    static TransferConfirmation(){
        return `
        <div class="TransferConfirmation">
            <div class="TransferConfirmation-Background"></div>
            <div class="Mini-Header">
                <img class="Back" src="${BaseURL}../public/images/mobile/icon_back.png" alt="">
            </div>

            <div class="TransferConfirmation-Header">
                <p class="Activity-Title">Transfer Confirmation</p>
                <p class="Activity-Notes">Validate all information and confirm it to be correct</p>
            </div>

            <div class="TransferConfirmation-Content">

                <Table>
                    <tr>
                        <td>Source</td>
                        <td><div class="TransferConfirmation-2Row">
                            <p id="TransferConfirmation-SourceName">-</p>
                            <p id="TransferConfirmation-SourceId">-</p>
                        </div></td>
                    </tr>
                    <tr>
                        <td>Destination</td>
                        <td><div class="TransferConfirmation-2Row">
                            <p id="TransferConfirmation-DestinationName">-</p>
                            <p id="TransferConfirmation-DestinationId">-</p>
                        </div></td>
                    </tr>
                    <tr>
                        <td>Amount</td>
                        <td id="TransferConfirmation-Amount">-</td>
                    </tr>
                    <tr>
                        <td>Purpose</td>
                        <td>Fund Transfer</td>
                    </tr>
                    <tr>
                        <td>Message</td>
                        <td id="TransferConfirmation-Message">-</td>
                    </tr>
                </Table>

                <p class="Activity-Notes center TransferConfirmation-LastNote">Please ensure all information is corrrect. By clicking \'Transfer\' button means that you have validated all information and confirming it to be correct.</p>

                <div class="Form-Box">
                    <button id="TransferConfirmation-Transfer" class="Form-Button">Confirm Transfer</button>
                </div>
            </div>

        </div>
        `;
    }


    static PurchaseConfirmation(){
        return `
        <div class="PurchaseConfirmation">
            <div class="PurchaseConfirmation-Background"></div>
            <div class="Mini-Header">
                <img class="Back" src="${BaseURL}../public/images/mobile/icon_back.png" alt="">
            </div>

            <div class="PurchaseConfirmation-Header">
                <p class="Activity-Title">Purchase Confirmation</p>
                <p class="Activity-Notes">Validate all information and confirm it to be correct</p>
            </div>

            <div class="PurchaseConfirmation-Content">

                <Table>
                    <tr>
                        <td>Merchant</td>
                        <td id="PurchaseConfirmation-Merchant">-</td>
                    </tr>
                    <tr>
                        <td>Amount</td>
                        <td id="PurchaseConfirmation-Amount">-</td>
                    </tr>
                    <tr>
                        <td>Discount</td>
                        <td id="PurchaseConfirmation-Discount">-</td>
                    </tr>
                    <tr>
                        <td>Total Amount</td>
                        <td id="PurchaseConfirmation-TotalAmount">-</td>
                    </tr>
                </Table>

                <Table>
                    <tr>
                        <td>Items</td>
                    </tr>
                    <tr>
                        <td>
                            <div id="PurchaseConfirmation-Items"></div>
                        </td>
                    </tr>
                </Table>

                <p class="Activity-Notes center PurchaseConfirmation-LastNote">Please ensure all information is corrrect. By clicking \'Transfer\' button means that you have validated all information and confirming it to be correct.</p>

                <div class="Form-Dual-Button-Box">
                    <button class="Form-Dual-Button">Reject</button>
                    <button class="Form-Dual-Button">Confirm</button>
                </div>
            </div>

        </div>
        `;
    }


    static ScanQR(){
        return `
        <div class="ScanQR">
            <div class="ScanQR-Background"></div>
            <div class="Mini-Header">
                <img class="Back" src="${BaseURL}../public/images/mobile/icon_back.png" alt="">
            </div>

            <div class="ScanQR-Header">
                <p class="Activity-Title">Scan QR</p>
                <p class="Activity-Notes">Exercise caution when scanning QR codes. Be mindful of potential security risks associated with unfamiliar or untrusted sources. Avoid scanning codes from unknown or suspicious origins to safeguard your device and personal data.</p>
                <div class="Form-Box">
                    <button class="Form-Button">Start Scanning</button>
                </div>
            </div>

        </div>
        `;
    }


    static Receipt(){
        return `
        <div class="Receipt">
            <div class="Mini-Header">
                <img class="Back" src="${BaseURL}../public/images/mobile/icon_back.png" alt="">
            </div>

            <div class="Receipt-Content">
                <div class="Top">
                    <div class="header">
                        <img src="${BaseURL}../public/images/mobile/bcash_logo_white.png" alt="">
                        <p id="Receipt-Timestamp">October 1, 2023</p>
                    </div>
                    <p class="title">Transaction Receipt</p>
                    <p id="Receipt-Type" class="subtitle">Transaction Receipt</p>
                    <Table>
                        <tr>
                            <td>Source</td>
                            <td><div class="Receipt-2Row">
                                <p id="Receipt-SourceName">-</p>
                                <p id="Receipt-SourceId">-</p>
                            </div></td>
                        </tr>
                        <tr>
                            <td>Destination</td>
                            <td><div class="Receipt-2Row">
                                <p id="Receipt-DestinationName">-</p>
                                <p id="Receipt-DestinationId">-</p>
                            </div></td>
                        </tr>
                        <tr id="Receipt-Amount-Container">
                            <td>Amount</td>
                            <td id="Receipt-Amount">-</td>
                        </tr>
                        <tr id="Receipt-Discount-Container">
                            <td>Discount</td>
                            <td id="Receipt-Discount">-</td>
                        </tr>
                        <tr>
                            <td>Total Amount</td>
                            <td id="Receipt-TotalAmount">-</td>
                        </tr>
                        <tr>
                            <td>Message</td>
                            <td id="Receipt-Message">-</td>
                        </tr>
                    </Table>
                </div>
                <div class="Mid">
                    <p id="Receipt-Reference">Ref. No.</p>
                </div>
                <div class="Bot" id="Receipt-Items-Container">
                    <table id="Receipt-Items">
                    </table>
                </div>
            </div>

        </div>
        `;
    }
}