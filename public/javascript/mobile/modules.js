import Layouts from "./layouts.js";
import { ChangeLayout } from "./layoutManager.js";
import Defaults from "./defaults.js";
import Helper from "./helper.js";
import AjaxRequest from "./ajax.js";

export default class Modules {

    static SplashScreen () {
        setTimeout(() => {
            ChangeLayout(Layouts.Login(), Modules.LoginModule, null);
        }, Defaults.SplashScreenTime);
    }

    static LoginModule() {
        document.getElementById("Login-SignIn").addEventListener('click', ()=>{
            console.log("123");
        });
    }

    static OTPValidationModule() {
        const OTPBox = [
            document.querySelector(".OTPValidation1"),
            document.querySelector(".OTPValidation2"),
            document.querySelector(".OTPValidation3"),
            document.querySelector(".OTPValidation4"),
            document.querySelector(".OTPValidation5"),
            document.querySelector(".OTPValidation6")
        ];

        const OTP = [];

        document.querySelector(".keypad-1").addEventListener('click', ()=>{
            OTP.push("1");
            Modules.RefreshNumBox(OTPBox, OTP, 6, "text", "OTP");
        });
        document.querySelector(".keypad-2").addEventListener('click', ()=>{
            OTP.push("2");
            Modules.RefreshNumBox(OTPBox, OTP, 6, "text", "OTP");
        });
        document.querySelector(".keypad-3").addEventListener('click', ()=>{
            OTP.push("3");
            Modules.RefreshNumBox(OTPBox, OTP, 6, "text", "OTP");
        });
        document.querySelector(".keypad-4").addEventListener('click', ()=>{
            OTP.push("4");
            Modules.RefreshNumBox(OTPBox, OTP, 6, "text", "OTP");
        });
        document.querySelector(".keypad-5").addEventListener('click', ()=>{
            OTP.push("5");
            Modules.RefreshNumBox(OTPBox, OTP, 6, "text", "OTP");
        });
        document.querySelector(".keypad-6").addEventListener('click', ()=>{
            OTP.push("6");
            Modules.RefreshNumBox(OTPBox, OTP, 6, "text", "OTP");
        });
        document.querySelector(".keypad-7").addEventListener('click', ()=>{
            OTP.push("7");
            Modules.RefreshNumBox(OTPBox, OTP, 6, "text", "OTP");
        });
        document.querySelector(".keypad-8").addEventListener('click', ()=>{
            OTP.push("8");
            Modules.RefreshNumBox(OTPBox, OTP, 6, "text", "OTP");
        });
        document.querySelector(".keypad-9").addEventListener('click', ()=>{
            OTP.push("9");
            Modules.RefreshNumBox(OTPBox, OTP, 6, "text", "OTP");
        });
        document.querySelector(".keypad-0").addEventListener('click', ()=>{
            OTP.push("0");
            Modules.RefreshNumBox(OTPBox, OTP, 6, "text", "OTP");
        });
        document.querySelector(".keypad-11").addEventListener('click', ()=>{
            OTP.length = 0;
            Modules.RefreshNumBox(OTPBox, OTP, 6, "text", "OTP");
        });
        document.querySelector(".keypad-12").addEventListener('click', ()=>{
            OTP.pop();
            Modules.RefreshNumBox(OTPBox, OTP, 6, "text", "OTP");
        });
    }

    static PinValidationModule() {
        const PINBox = [
            document.querySelector(".PinValidation1"),
            document.querySelector(".PinValidation2"),
            document.querySelector(".PinValidation3"),
            document.querySelector(".PinValidation4"),
            document.querySelector(".PinValidation5"),
            document.querySelector(".PinValidation6")
        ];

        const PIN = [];

        document.querySelector(".keypad-1").addEventListener('click', ()=>{
            PIN.push("1");
            Modules.RefreshNumBox(PINBox, PIN, 6, "password", "PIN");
        });
        document.querySelector(".keypad-2").addEventListener('click', ()=>{
            PIN.push("2");
            Modules.RefreshNumBox(PINBox, PIN, 6, "password", "PIN");
        });
        document.querySelector(".keypad-3").addEventListener('click', ()=>{
            PIN.push("3");
            Modules.RefreshNumBox(PINBox, PIN, 6, "password", "PIN");
        });
        document.querySelector(".keypad-4").addEventListener('click', ()=>{
            PIN.push("4");
            Modules.RefreshNumBox(PINBox, PIN, 6, "password", "PIN");
        });
        document.querySelector(".keypad-5").addEventListener('click', ()=>{
            PIN.push("5");
            Modules.RefreshNumBox(PINBox, PIN, 6, "password", "PIN");
        });
        document.querySelector(".keypad-6").addEventListener('click', ()=>{
            PIN.push("6");
            Modules.RefreshNumBox(PINBox, PIN, 6, "password", "PIN");
        });
        document.querySelector(".keypad-7").addEventListener('click', ()=>{
            PIN.push("7");
            Modules.RefreshNumBox(PINBox, PIN, 6, "password", "PIN");
        });
        document.querySelector(".keypad-8").addEventListener('click', ()=>{
            PIN.push("8");
            Modules.RefreshNumBox(PINBox, PIN, 6, "password", "PIN");
        });
        document.querySelector(".keypad-9").addEventListener('click', ()=>{
            PIN.push("9");
            Modules.RefreshNumBox(PINBox, PIN, 6, "password", "PIN");
        });
        document.querySelector(".keypad-0").addEventListener('click', ()=>{
            PIN.push("0");
            Modules.RefreshNumBox(PINBox, PIN, 6, "password", "PIN");
        });
        document.querySelector(".keypad-11").addEventListener('click', ()=>{
            PIN.length = 0;
            Modules.RefreshNumBox(PINBox, PIN, 6, "password", "PIN");
        });
        document.querySelector(".keypad-12").addEventListener('click', ()=>{
            PIN.pop();
            Modules.RefreshNumBox(PINBox, PIN, 6, "password", "PIN");
        });
    }

    static PinCreationModule() {
        const NewPINBox = [
            document.querySelector(".PinCreation1"),
            document.querySelector(".PinCreation2"),
            document.querySelector(".PinCreation3"),
            document.querySelector(".PinCreation4"),
            document.querySelector(".PinCreation5"),
            document.querySelector(".PinCreation6"),
            document.querySelector(".PinCreation7"),
            document.querySelector(".PinCreation8"),
            document.querySelector(".PinCreation9"),
            document.querySelector(".PinCreation10"),
            document.querySelector(".PinCreation11"),
            document.querySelector(".PinCreation12")
        ];

        const NewPIN = [];

        document.querySelector(".keypad-1").addEventListener('click', ()=>{
            NewPIN.push("1");
            Modules.RefreshNumBox(NewPINBox, NewPIN, 12, "password", "PIN");
        });
        document.querySelector(".keypad-2").addEventListener('click', ()=>{
            NewPIN.push("2");
            Modules.RefreshNumBox(NewPINBox, NewPIN, 12, "password", "PIN");
        });
        document.querySelector(".keypad-3").addEventListener('click', ()=>{
            NewPIN.push("3");
            Modules.RefreshNumBox(NewPINBox, NewPIN, 12, "password", "PIN");
        });
        document.querySelector(".keypad-4").addEventListener('click', ()=>{
            NewPIN.push("4");
            Modules.RefreshNumBox(NewPINBox, NewPIN, 12, "password", "PIN");
        });
        document.querySelector(".keypad-5").addEventListener('click', ()=>{
            NewPIN.push("5");
            Modules.RefreshNumBox(NewPINBox, NewPIN, 12, "password", "PIN");
        });
        document.querySelector(".keypad-6").addEventListener('click', ()=>{
            NewPIN.push("6");
            Modules.RefreshNumBox(NewPINBox, NewPIN, 12, "password", "PIN");
        });
        document.querySelector(".keypad-7").addEventListener('click', ()=>{
            NewPIN.push("7");
            Modules.RefreshNumBox(NewPINBox, NewPIN, 12, "password", "PIN");
        });
        document.querySelector(".keypad-8").addEventListener('click', ()=>{
            NewPIN.push("8");
            Modules.RefreshNumBox(NewPINBox, NewPIN, 12, "password", "PIN");
        });
        document.querySelector(".keypad-9").addEventListener('click', ()=>{
            NewPIN.push("9");
            Modules.RefreshNumBox(NewPINBox, NewPIN, 12, "password", "PIN");
        });
        document.querySelector(".keypad-0").addEventListener('click', ()=>{
            NewPIN.push("0");
            Modules.RefreshNumBox(NewPINBox, NewPIN, 12, "password", "PIN");
        });
        document.querySelector(".keypad-11").addEventListener('click', ()=>{
            NewPIN.length = 0;
            Modules.RefreshNumBox(NewPINBox, NewPIN, 12, "password", "PIN");
        });
        document.querySelector(".keypad-12").addEventListener('click', ()=>{
            NewPIN.pop();
            Modules.RefreshNumBox(NewPINBox, NewPIN, 12, "password", "PIN");
        });
    }

    static RefreshNumBox(elements, code, length, type, validationType) {
        for (let index = 0; index < length; index++) {
            if (code[index] !== undefined){
                if (type === "text") {
                    elements[index].innerHTML = code[index];
                } else {
                    elements[index].innerHTML = "*";
                }
            } else {
                elements[index].innerHTML = "";
            };
        }
        if (code.length === length){
            switch (validationType) {
                case "OTP":
                    const OTPdata = {
                        OTP: code.join(''),
                        IpAddress: IpAddress,
                        Device: Device,
                        Location: Location,
                    };
                    AjaxRequest.sendRequest(OTPdata,"OTPValidation",BaseURL+"Api/Auth/Process")
                        .then(responseData => {
                    });
                break;

                case "PIN":
                    const PINdata = {
                        PIN: code.join(''),
                        IpAddress: IpAddress,
                        Device: Device,
                        Location: Location,
                    };
                    AjaxRequest.sendRequest(PINdata,"PINValidation",BaseURL+"Api/Auth/Process")
                        .then(responseData => {
                    });
                break;

                case "NEWPIN":
                    if (code.slice(0, 6).join('') === code.slice(6, 12).join('')){
                        const NewPINdata = {
                            PIN1: code.slice(0, 6).join(''), 
                            IpAddress: IpAddress,
                            Device: Device,
                            Location: Location,
                        };
                        AjaxRequest.sendRequest(NewPINdata,"PINCreation",BaseURL+"Api/Auth/Process")
                            .then(responseData => {
                        });
                    } else {
                        alert("PIN code does not match!");
                        ChangeLayout(Layouts.PinCreation(), Modules.PinCreationModule, null);
                    }
                break;

                default:
                    break;
            }
        }
    };

    static HomeModule() {

        let CardIdVisible = true;
        let CardBalanceVisible = true;

        document.getElementById("Home-Card-Balance-Toggle").addEventListener('click', () => {
            if (CardBalanceVisible) {
                CardBalanceVisible = false;
                document.getElementById("Home-Card-Balance").innerHTML = Helper.getHiddenBalance(userBalance ?? "0.00");
                document.getElementById("Home-Card-Balance-Toggle").setAttribute("src", BaseURL + "../public/images/mobile/icon_visibility_off.png");
            } else {
                CardBalanceVisible = true;
                document.getElementById("Home-Card-Balance").innerHTML = Helper.getBalance(userBalance ?? "0.00");
                document.getElementById("Home-Card-Balance-Toggle").setAttribute("src", BaseURL + "../public/images/mobile/icon_visibility.png");
            }
        });
        
        document.getElementById("Home-Card-SID-Toggle").addEventListener('click', () => {
            if (CardIdVisible) {
                CardIdVisible = false;
                document.getElementById("Home-Card-SID").innerHTML = Helper.getHiddenPersonalId(userPersonalId ?? "");
                document.getElementById("Home-Card-SID-Toggle").setAttribute("src", BaseURL + "../public/images/mobile/icon_visibility_off.png");
            } else {
                CardIdVisible = true;
                document.getElementById("Home-Card-SID").innerHTML = userPersonalId ?? "";
                document.getElementById("Home-Card-SID-Toggle").setAttribute("src", BaseURL + "../public/images/mobile/icon_visibility.png");
            }
        });

        
        document.querySelector(".Home-RecentTransactions .more").addEventListener('click', ()=> {
            ChangeLayout(Layouts.Transactions(), Modules.TransactionsModule, null);
        });
            
        document.getElementById('Home-NavBar-1').addEventListener('click', () => {
            ChangeLayout(Layouts.Home(), Modules.HomeModule, null);
        });
        document.getElementById('Home-NavBar-2').addEventListener('click', () => {
            ChangeLayout(Layouts.Transfer(), Modules.TransferModule, null);
        });
        document.getElementById('Home-NavBar-3').addEventListener('click', () => {
            ChangeLayout(Layouts.ScanQR(), Modules.ScanQRModule, null);
        });
        document.getElementById('Home-NavBar-4').addEventListener('click', () => {
            ChangeLayout(Layouts.Whitelist(), Modules.WhitelistModule, null);
        });
        document.getElementById('Home-NavBar-5').addEventListener('click', () => {
            ChangeLayout(Layouts.SecuritySettings(), Modules.SecuritySettingsModule, null);
        });
        
        document.querySelector(".Nav1").addEventListener('click', () => {
            ChangeLayout(Layouts.Home(), Modules.HomeModule, null);
        });
        document.querySelector(".Nav2").addEventListener('click', () => {
            ChangeLayout(Layouts.Transactions(), Modules.TransactionsModule, null);
        });
        document.querySelector(".Nav3").addEventListener('click', () => {
            ChangeLayout(Layouts.Announcements(), Modules.AnnouncementsModule, null);
        });
        document.querySelector(".Nav4").addEventListener('click', () => {
            ChangeLayout(Layouts.Profile(), Modules.ProfileModule, null);
        });

        AjaxRequest.sendRequest([],"get my account",BaseURL+"Api/Request/Process")
        .then(responseData => {
            if (responseData.Success === true){
                if (responseData.Parameters?.Guardian) {
                    userActorCategory = responseData.Parameters.Guardian.ActorCategory_Id;
                    userBalance = responseData.Parameters.Details.Balance;
                    userPersonalId = responseData.Parameters.Details.SchoolPersonalId;
                    userEmail = responseData.Parameters.Guardian.Email;
                    userLastname = responseData.Parameters.Guardian.Lastname;
                    userFirstname = responseData.Parameters.Guardian.Firstname;
                } else {
                    userActorCategory = responseData.Parameters.Account.ActorCategory_Id;
                    userBalance = responseData.Parameters.Details.Balance;
                    userPersonalId = responseData.Parameters.Details.SchoolPersonalId;
                    userEmail = responseData.Parameters.Account.Email;
                    userLastname = responseData.Parameters.Account.Lastname;
                    userFirstname = responseData.Parameters.Account.Firstname;
                }
                

                if (CardIdVisible) {
                    CardIdVisible = false;
                    document.getElementById("Home-Card-SID").innerHTML = Helper.getHiddenPersonalId(userPersonalId ?? "");
                    document.getElementById("Home-Card-SID-Toggle").setAttribute("src", BaseURL + "../public/images/mobile/icon_visibility_off.png");
                } else {
                    CardIdVisible = true;
                    document.getElementById("Home-Card-SID").innerHTML = userPersonalId ?? "";
                    document.getElementById("Home-Card-SID-Toggle").setAttribute("src", BaseURL + "../public/images/mobile/icon_visibility.png");
                }

                if (CardBalanceVisible) {
                    CardBalanceVisible = false;
                    document.getElementById("Home-Card-Balance").innerHTML = Helper.getHiddenBalance(userBalance ?? "0.00");
                    document.getElementById("Home-Card-Balance-Toggle").setAttribute("src", BaseURL + "../public/images/mobile/icon_visibility_off.png");
                } else {
                    CardBalanceVisible = true;
                    document.getElementById("Home-Card-Balance").innerHTML = Helper.getBalance(userBalance ?? "0.00");
                    document.getElementById("Home-Card-Balance-Toggle").setAttribute("src", BaseURL + "../public/images/mobile/icon_visibility.png");
                }

                if (userActorCategory === "5" || userActorCategory === "6") {
                    document.getElementById("Home-NavBar-2").style.display = "flex";
                    document.getElementById("Home-NavBar-3").style.display = "flex";
                    document.getElementById("Home-NavBar-4").style.display = "flex";
                } else if (userActorCategory === "7") {
                    document.getElementById("Home-NavBar-2").style.display = "none";
                    document.getElementById("Home-NavBar-3").style.display = "none";
                    document.getElementById("Home-NavBar-4").style.display = "none";
                } 

                document.getElementById("Home-Fullname").innerHTML = Helper.toTitleCase(userFirstname + " " + userLastname);

                document.getElementById("Home-Card-Name").innerHTML = userFirstname + " " + userLastname;

            } else {
                Modules.HomeModule();
                alert("Error Loading Page");
            }
        });

        AjaxRequest.sendRequest([],"get recent transactions", BaseURL+"Api/Request/Process")
        .then(responseData => {
            if (responseData.Success === true){

                document.getElementById("Home-RecentTransactions").innerHTML = "";

                responseData.Parameters.forEach(element => {
                    let TransactionAddress = element.Transaction_Address;
                    let TransactionAmount = AccountAddress === element.Sender_Address ? "- " + element.TotalAmount : "+ " + element.TotalAmount;
                    let TransactionDate = element.Timestamp;
                    let TransactionType = element.TransactionType;

                    document.getElementById("Home-RecentTransactions").innerHTML = document.getElementById("Home-RecentTransactions").innerHTML + 
                    `
                        <div class="transaction-row Home-Recent-Transaction-Row pointer" data-transactionaddress="${TransactionAddress}">
                            <div class="transaction-info">
                                <div class="transaction-details">
                                    <span class="transaction-type">${TransactionType}</span>
                                    <span class="transaction-date">${Helper.convertTimestamp(TransactionDate)}</span>
                                </div>
                                <div class="transaction-amount">
                                    <span class="transaction-amount-text">${TransactionAmount}</span>
                                </div>
                            </div>
                            <div class="transaction-divider"></div>
                        </div>
                    `;
                });

                const elements = document.querySelectorAll(".Home-Recent-Transaction-Row");
                elements.forEach(element => {
                    element.addEventListener('click', (e) => {
                        const TransactionAddress = e.currentTarget.dataset.transactionaddress;
                        ChangeLayout(Layouts.Receipt(), Modules.ReceiptModule, TransactionAddress);
                    });
                });
                
            } else {
                Modules.HomeModule();
                alert("Error Loading Page");
            }
        });

    }

    static TransactionsModule() {

        document.querySelector(".Nav1").addEventListener('click', () => {
            ChangeLayout(Layouts.Home(), Modules.HomeModule, null);
        });
        document.querySelector(".Nav2").addEventListener('click', () => {
            ChangeLayout(Layouts.Transactions(), Modules.TransactionsModule, null);
        });
        document.querySelector(".Nav3").addEventListener('click', () => {
            ChangeLayout(Layouts.Announcements(), Modules.AnnouncementsModule, null);
        });
        document.querySelector(".Nav4").addEventListener('click', () => {
            ChangeLayout(Layouts.Profile(), Modules.ProfileModule, null);
        });

        AjaxRequest.sendRequest([],"get all transactions", BaseURL+"Api/Request/Process")
            .then(responseData => {
                if (responseData.Success === true){

                    document.getElementById("Transactions-Container").innerHTML = "";

                    responseData.Parameters.forEach(element => {
                        let TransactionAddress = element.Transaction_Address;
                        let TransactionAmount = AccountAddress === element.Sender_Address ? "- " + element.TotalAmount : "+ " + element.TotalAmount;
                        let TransactionDate = element.Timestamp;
                        let TransactionType = element.TransactionType;

                        document.getElementById("Transactions-Container").innerHTML = document.getElementById("Transactions-Container").innerHTML + 
                        `
                            <div class="transaction-row pointer" data-transactionaddress="${TransactionAddress}">
                                <div class="transaction-info">
                                    <div class="transaction-details">
                                        <span class="transaction-type">${TransactionType}</span>
                                        <span class="transaction-date">${Helper.convertTimestamp(TransactionDate)}</span>
                                    </div>
                                    <div class="transaction-amount">
                                        <span class="transaction-amount-text">${TransactionAmount}</span>
                                    </div>
                                </div>
                                <div class="transaction-divider"></div>
                            </div>
                        `;
                    });

                    const elements = document.querySelectorAll(".transaction-row");
                    elements.forEach(element => {
                        element.addEventListener('click', (e) => {
                            const TransactionAddress = e.currentTarget.dataset.transactionaddress;
                            ChangeLayout(Layouts.Receipt(), Modules.ReceiptModule, TransactionAddress);
                        });
                    });
                    
                } else {
                    Modules.TransactionsModule();
                    alert("Error Loading Page");
                }
            });
    }

    static AnnouncementsModule() {

        document.querySelector(".Nav1").addEventListener('click', () => {
            ChangeLayout(Layouts.Home(), Modules.HomeModule, null);
        });
        document.querySelector(".Nav2").addEventListener('click', () => {
            ChangeLayout(Layouts.Transactions(), Modules.TransactionsModule, null);
        });
        document.querySelector(".Nav3").addEventListener('click', () => {
            ChangeLayout(Layouts.Announcements(), Modules.AnnouncementsModule, null);
        });
        document.querySelector(".Nav4").addEventListener('click', () => {
            ChangeLayout(Layouts.Profile(), Modules.ProfileModule, null);
        });

        document.querySelector(".Announcements-Content").innerHTML = "";

        AjaxRequest.sendRequest([],"get my notifications", BaseURL+"Api/Request/Process")
        .then(responseData => {
            if (responseData.Success === true){
                responseData.Parameters.forEach(element => {
                    document.querySelector(".Announcements-Content").innerHTML = document.querySelector(".Announcements-Content").innerHTML + `
                        <div class="Announcements-container">
                            <div class="Announcements-title">${element.Title}</div>
                            <div class="Announcements-date">${Helper.convertTimestamp(element.Timestamp)}</div>
                            <div class="Announcements-content-text">${element.Content}</div>
                        </div>
                    `;
                });
            } 
        });
    }

    static ProfileModule() {

        document.querySelector(".Profile-Name").innerHTML = userFirstname + " " + userLastname;
        document.querySelector(".Profile-Email").innerHTML = userEmail;

        document.querySelector(".Profile-Nav-1").addEventListener('click', () => {
            ChangeLayout(Layouts.SecuritySettings(), Modules.SecuritySettingsModule, null);
        });
        document.querySelector(".Profile-Nav-2").addEventListener('click', () => {
            ChangeLayout(Layouts.Whitelist(), Modules.WhitelistModule, null);
        });
        document.querySelector(".Profile-Nav-3").addEventListener('click', () => {
            ChangeLayout(Layouts.ActivityLogs(), Modules.ActivityLogsModule, null);
        });
        document.querySelector(".Profile-Nav-4").addEventListener('click', () => {
            ChangeLayout(Layouts.LoginHistory(), Modules.LoginHistoryModule, null);
        });
        document.querySelector(".Profile-Nav-5").addEventListener('click', () => {
            alert("Signing out");
            AjaxRequest.sendRequest([],"Logout",BaseURL+"Api/Auth/Process")
                .then(responseData => {});
            window.location.href = 'http://localhost/index.php/mobile/index';
        });

        document.querySelector(".Nav1").addEventListener('click', () => {
            ChangeLayout(Layouts.Home(), Modules.HomeModule, null);
        });
        document.querySelector(".Nav2").addEventListener('click', () => {
            ChangeLayout(Layouts.Transactions(), Modules.TransactionsModule, null);
        });
        document.querySelector(".Nav3").addEventListener('click', () => {
            ChangeLayout(Layouts.Announcements(), Modules.AnnouncementsModule, null);
        });
        document.querySelector(".Nav4").addEventListener('click', () => {
            ChangeLayout(Layouts.Profile(), Modules.ProfileModule, null);
        });

        document.querySelector(".pin-confirmation-container").style.display = 'none';

        AjaxRequest.sendRequest([],"get my account", BaseURL+"Api/Request/Process")
            .then(responseData => {
                if (responseData.Success === true){
                    document.getElementById('Config-AllowTransfer').checked = responseData.Parameters.Details.CanDoTransfers === '1';
                    document.getElementById('Config-AllowTransactions').checked = responseData.Parameters.Details.CanDoTransactions === '1';
                    document.getElementById('Config-AllowCard').checked = responseData.Parameters.Details.CanUseCard === '1';
                    document.getElementById('Config-AutoConfirm').checked = responseData.Parameters.Details.IsTransactionAutoConfirm === '1';
                    document.getElementById('Config-ManageSettings').checked = responseData.Parameters.Details.CanModifySettings === '1';

                    document.querySelectorAll('.Config').forEach(element => {
                        element.addEventListener('change', (e)=>{
                            document.querySelector(".pin-confirmation-container").style.display = 'flex';
                        });
                    });
                } 
            });

        document.getElementById('btnCancel').addEventListener('click', () => {
            ChangeLayout(Layouts.Profile(), Modules.ProfileModule, null);
        });

        document.getElementById('btnConfirm').addEventListener('click', () => {
            const settingsData = {
                PinCode: document.getElementById('Config-pinCode').value,
                CanDoTransfers: document.getElementById('Config-AllowTransfer').checked === true ? "1" : "0",
                CanDoTransactions: document.getElementById('Config-AllowTransactions').checked === true ? "1" : "0",
                CanUseCard: document.getElementById('Config-AllowCard').checked === true ? "1" : "0",
                IsTransactionAutoConfirm: document.getElementById('Config-AutoConfirm').checked === true ? "1" : "0",
                CanModifySettings: document.getElementById('Config-ManageSettings').checked === true ? "1" : "0",
            };
            AjaxRequest.sendRequest(settingsData,"update my settings", BaseURL+"Api/Request/Process")
                .then(responseData => {
                    document.getElementById('Config-pinCode').value = "";
                    ChangeLayout(Layouts.Profile(), Modules.ProfileModule, null);
                });
        });

        if (userActorCategory === "7") {
            document.querySelector(".Guardian-Row").style.display = "flex";
            document.querySelector(".Profile-Nav-2").style.display = "none";
        } else {
            document.querySelector(".Guardian-Row").style.display = "none";
            document.querySelector(".Profile-Nav-2").style.display = "flex";
        }


    }

    static SecuritySettingsModule() {
        document.querySelector(".Back").addEventListener('click', () => {
            ChangeLayout(Layouts.Home(), Modules.HomeModule, null);
        });

        document.getElementById('SecuritySettings-OldPin')
        document.getElementById('SecuritySettings-NewPin')
        document.getElementById('SecuritySettings-ReNewPin')

        document.getElementById('SecuritySettings-Btn').addEventListener('click', ()=> {
            if (document.getElementById('SecuritySettings-NewPin').value === document.getElementById('SecuritySettings-OldPin').value) {
                alert("Create a new PIN code");
                return
            }
            if (document.getElementById('SecuritySettings-NewPin').value !== document.getElementById('SecuritySettings-ReNewPin').value) {
                alert("New PIN code does not match");
                return
            }
            AjaxRequest.sendRequest({CurrentPIN: document.getElementById('SecuritySettings-OldPin').value, NewPINCode1: document.getElementById('SecuritySettings-NewPin').value, NewPINCode2: document.getElementById('SecuritySettings-ReNewPin').value},"update my pin",BaseURL+"Api/Request/Process")
                .then(responseData => {
                    if (responseData.Success === true){
                        ChangeLayout(Layouts.Profile(), Modules.ProfileModule, null);
                    } 
                });
        });
    }

    static WhitelistModule() {
        document.querySelector(".Back").addEventListener('click', () => {
            ChangeLayout(Layouts.Home(), Modules.HomeModule, null);
        });

        document.querySelector(".Whitelist-Content").innerHTML = "";

        AjaxRequest.sendRequest([],"get my whitelist",BaseURL+"Api/Request/Process")
            .then(responseData => {
                if (responseData.Success === true){

                    responseData.Parameters.forEach(element => {
                        document.querySelector(".Whitelist-Content").innerHTML = document.querySelector(".Whitelist-Content").innerHTML + `
                            <div class="Whitelist-container">
                                <div class="Whitelist-info-row">
                                    <div class="Whitelist-label">Name :</div>
                                    <div class="Whitelist-value">${Helper.toTitleCase(element.Firstname + " " + element.Lastname)}</div>
                                </div>
                        
                                <div class="Whitelist-info-row">
                                    <div class="Whitelist-label">Date :</div>
                                    <div class="Whitelist-value Whitelist-italic">${Helper.convertTimestamp(element.Timestamp)}</div>
                                </div>
                        
                                <button class="Whitelist-remove-button" data-account="${element.Whitelisted_Address}">Remove</button>
                            </div>
                        `;
                    });

                    const elements = document.querySelectorAll(".Whitelist-Content .Whitelist-remove-button");
                    elements.forEach(element => {
                        element.addEventListener('click', (e)=>{
                            AjaxRequest.sendRequest({Id: e.currentTarget.dataset.account},"remove one from whitelist",BaseURL+"Api/Request/Process")
                            .then(responseData => {
                                Modules.WhitelistModule();
                            });
                        });
                    });
                    
                } 
            });
        
        document.getElementById("Whitelist-Add").addEventListener('click', ()=>{
            ChangeLayout(Layouts.WhitelistAdd(), Modules.WhitelistAddModule, null);
        });
    }

    static WhitelistAddModule() {
        document.querySelector(".Back").addEventListener('click', () => {
            ChangeLayout(Layouts.Whitelist(), Modules.WhitelistModule, null);
        });

        document.querySelectorAll(".WhitelistAdd-closed").forEach(element => {
            element.style.display = "none";
          });

        document.getElementById("WhitelistAdd-Id").addEventListener('change', (e)=>{
            document.getElementById('WhitelistAdd-PIN').value = "";
            document.querySelectorAll(".WhitelistAdd-closed").forEach(element => {
                element.style.display = "none";
              });
            AjaxRequest.sendRequest({Id: document.getElementById('WhitelistAdd-Id').value},"get other account",BaseURL+"Api/Request/Process")
                .then(responseData => {
                    if (responseData.Success === true){
                        document.getElementById('WhitelistAdd-Name').value = Helper.toTitleCase(responseData.Parameters.Account.Firstname + " " +responseData.Parameters.Account.Lastname);
                        document.querySelectorAll(".WhitelistAdd-closed").forEach(element => {
                            element.style.display = "block";
                          });
                    } 
                });
        });



        document.getElementById("WhitelistAdd-Add").addEventListener('click', ()=> {
            AjaxRequest.sendRequest({Id: document.getElementById('WhitelistAdd-Id').value, PinCode: document.getElementById('WhitelistAdd-PIN').value},"add one to whitelist",BaseURL+"Api/Request/Process")
                .then(responseData => {
                    if (responseData.Success === true){
                        ChangeLayout(Layouts.Whitelist(), Modules.WhitelistModule, null);
                    } 
                });
        });
    }

    static ActivityLogsModule() {
        document.querySelector(".Back").addEventListener('click', () => {
            ChangeLayout(Layouts.Profile(), Modules.ProfileModule, null);
        });

        AjaxRequest.sendRequest([],"get my activity logs",BaseURL+"Api/Request/Process")
            .then(responseData => {
                if (responseData.Success === true){

                    responseData.Parameters.forEach(element => {

                        let accountAddress = element.Account_Address === AccountAddress
                            ? "You"
                            : element.Account_Address.substring(0, 3) === "ADM"
                                ? "Administrator"
                                : element.Account_Address.substring(0, 3) === "ACT"
                                    ? "Accounting"
                                    : element.Account_Address.substring(0, 3) === "GDN"
                                        ? "Your Guardian"
                                        : "Unknown";

                        let targetAccountAddress = element.Target_Account_Address;
                        let action = element.Action;
                        let task = element.Task;
                        let timestamp = Helper.convertTimestamp(element.Timestamp);


                        document.querySelector('.ActivityLogs-Content').innerHTML = document.querySelector('.ActivityLogs-Content').innerHTML + `
                            <div class="ActivityLogs-container">
                                <div class="ActivityLogs-date">${timestamp}</div>
                                <div class="ActivityLogs-name">${accountAddress}</div>
                                <div class="ActivityLogs-task">${task}</div>
                                <hr class="ActivityLogs-divider">
                            </div>
                        `;

                    });

                } else {
                    alert('Failed getting data. Retrying...');
                    Modules.ActivityLogsModule();
                }
            });
    }

    static LoginHistoryModule() {
        document.querySelector(".Back").addEventListener('click', () => {
            ChangeLayout(Layouts.Profile(), Modules.ProfileModule, null);
        });

        document.getElementById("LoginHistory-Btn").addEventListener('click', () => {
            AjaxRequest.sendRequest([],"delete all login history",BaseURL+"Api/Request/Process")
            .then(responseData => {
                if (responseData.Success === true){
                    Modules.LoginHistoryModule();
                }
            });
        });

        document.getElementById('LoginHistory-Content').innerHTML = "";

        AjaxRequest.sendRequest([],"get my login history",BaseURL+"Api/Request/Process")
            .then(responseData => {
                if (responseData.Success === true){

                    responseData.Parameters.forEach(element => {
                        document.getElementById('LoginHistory-Content').innerHTML = document.getElementById('LoginHistory-Content').innerHTML + `
                            <div class="LoginHistory-container">
                                <div class="LoginHistory-login-from bold">
                                    <span>Login From: </span>
                                    <span class="info">${element.IpAddress}</span>
                                </div>

                                <div class="LoginHistory-location">
                                    <span>Location: </span>
                                    <span class="info">${element.Location}</span>
                                </div>

                                <hr class="LoginHistory-divider">

                                <div class="LoginHistory-device">
                                    <span>${element.Device}</span>
                                </div>

                                <hr class="LoginHistory-divider">

                                <div class="LoginHistory-last-active">
                                    <span>Last Active: </span>
                                    <span class="info">${Helper.convertTimestamp(element.LastOnline)}</span>
                                </div>

                                <button class="LoginHistory-Remove-Item" data-location="${element.Location}" data-device="${element.Device}" data-ipaddress="${element.IpAddress}">Remove</button>
                            </div>
                        `;

                    });
                   
                    const elements = document.querySelectorAll(".LoginHistory-Remove-Item");
                    elements.forEach(element => {
                        element.addEventListener('click', (e)=>{
                            AjaxRequest.sendRequest({IpAddress:e.currentTarget.dataset.ipaddress ,Device: e.currentTarget.dataset.device ,Location: e.currentTarget.dataset.location},"delete one login history",BaseURL+"Api/Request/Process")
                                .then(responseData => {
                                    if (responseData.Success === true){
                                        Modules.LoginHistoryModule();
                                    }
                                });
                        });
                    });

                } else {
                    alert('Failed getting data. Retrying...');
                    Modules.WhitelistModule();
                }
            });
    }

    static TransferModule(params) {
        document.querySelector(".Back").addEventListener('click', () => {
            ChangeLayout(Layouts.Home(), Modules.HomeModule, null);
        });

        if (params !== null) {
            document.getElementById("Transfer-SchooId").value = params.Id;
            document.getElementById("Transfer-Amount").value = params.Amount;
            document.getElementById("Transfer-Message").value = params.Message;
        }

        document.getElementById("Transfer-Btn").addEventListener('click', () => {
            const params = {
                Id: document.getElementById("Transfer-SchooId").value,
                Amount: document.getElementById("Transfer-Amount").value,
                Message: document.getElementById("Transfer-Message").value
            };
            ChangeLayout(Layouts.TransferConfirmation(), Modules.TransferConfirmationModule, params);
        });
    }

    static TransferConfirmationModule(params) {
        document.querySelector(".Back").addEventListener('click', () => {
            ChangeLayout(Layouts.Transfer(), Modules.TransferModule, params);
        });

        if (params !== null) {
            if(params.Id === null || params.Id === "" || params.Amount === null || params.Amount === ""){
                alert("Please fill Id number and Amount");
                ChangeLayout(Layouts.Transfer(), Modules.TransferModule, params);
            } else if (userPersonalId === params.Id) {
                alert("You cant send to your own account.");
                ChangeLayout(Layouts.Transfer(), Modules.TransferModule, params);
            } else {
                AjaxRequest.sendRequest({Id: params.Id},"get other account", BaseURL+"Api/Request/Process")
                    .then(responseData => {
                        console.log(responseData);
                        if (responseData.Success === true){
                            document.getElementById("TransferConfirmation-SourceName").innerHTML = Helper.toTitleCase(userFirstname + " " + userLastname);
                            document.getElementById("TransferConfirmation-SourceId").innerHTML = userPersonalId;

                            document.getElementById("TransferConfirmation-DestinationName").innerHTML = Helper.toTitleCase(responseData.Parameters.Account.Firstname    + " " + responseData.Parameters.Account.Lastname);
                            document.getElementById("TransferConfirmation-DestinationId").innerHTML = params.Id

                            document.getElementById("TransferConfirmation-Amount").innerHTML = Helper.getBalance(params.Amount);
                            document.getElementById("TransferConfirmation-Message").innerHTML = params.Message;

                        } else {
                            alert(responseData.Response);
                            ChangeLayout(Layouts.Transfer(), Modules.TransferModule, params);
                            return false;
                        }
                    });
                document.getElementById("TransferConfirmation-Transfer").addEventListener('click' , ()=> {
                    AjaxRequest.sendRequest({SchoolPersonalId: params.Id, Amount: params.Amount, Message: params.Message},"initiate transfer", BaseURL+"Api/Request/Process")
                        .then(responseData => {
                            console.log(responseData);
                            if (responseData.Success === true){
                                alert(responseData.Response);
                                ChangeLayout(Layouts.Home(), Modules.HomeModule, null);
                            } else {
                                alert(responseData.Response);
                                ChangeLayout(Layouts.Transfer(), Modules.TransferModule, params);
                                return false;
                            }
                        });
                });
            }
        } else {
            alert("No information received");
            ChangeLayout(Layouts.Transfer(), Modules.TransferModule, null);
        }
    }

    static PurchaseConfirmationModule() {
        AjaxRequest.sendRequest({TransactionAddress: params},"get receipt",BaseURL+"Api/Request/Process")
            .then(responseData => {
                if (responseData.Success === true){
                    
                } else {

                }
            });
    }

    static ScanQRModule() {
        document.querySelector(".Back").addEventListener('click', () => {
            ChangeLayout(Layouts.Home(), Modules.HomeModule, null);
        })
    }

    static ReceiptModule(params) {
        document.querySelector(".Back").addEventListener('click', () => {
            ChangeLayout(Layouts.Transactions(), Modules.TransactionsModule, null);
        });

        AjaxRequest.sendRequest({TransactionAddress: params},"get receipt", BaseURL+"Api/Request/Process")
            .then(responseData => {
                console.log(responseData);
                if (responseData.Success === true){
                    const Info = responseData.Parameters.Info;
                    const Items = responseData.Parameters.Items;

                    document.getElementById('Receipt-Timestamp').innerHTML = Helper.convertTimestamp(Info.Timestamp);
                    document.getElementById('Receipt-Type').innerHTML = Info.TransactionType;

                    document.getElementById('Receipt-SourceName').innerHTML = Info.Sender_Firstname + " " + Info.Sender_Lastname;
                    document.getElementById('Receipt-SourceId').innerHTML = Info.sender_SchoolPersonalId??"";

                    document.getElementById('Receipt-DestinationName').innerHTML = Helper.toTitleCase(Info.Receiver_Firstname + " " + Info.Receiver_Lastname);
                    document.getElementById('Receipt-DestinationId').innerHTML = Info.Receiver_SchoolPersonalId??"";

                    document.getElementById('Receipt-Amount').innerHTML = Helper.getBalance(Info.Amount);
                    document.getElementById('Receipt-Discount').innerHTML = Helper.getBalance(Info.Discount);
                    document.getElementById('Receipt-TotalAmount').innerHTML = Helper.getBalance(Info.TotalAmount);
                    document.getElementById('Receipt-Message').innerHTML = Info.Notes;
                    document.getElementById('Receipt-Reference').innerHTML = "Ref No. "+Info.Transaction_Address;

                    if (Info.TransactionType === "Purchase") {
                        let table = document.getElementById("Receipt-Items");

                        Items.forEach(Item => {
                            let newRow = table.insertRow();

                            let cell1 = newRow.insertCell(0);
                            let cell2 = newRow.insertCell(1);
                            let cell3 = newRow.insertCell(2);

                            cell1.innerHTML = Item.ItemName;
                            cell2.innerHTML = "x"+Item.ItemQuantity;
                            cell3.innerHTML = Helper.getBalance(Number(Item.ItemQuantity) * Number(Item.ItemAmount));
                        });
                    } else {
                        document.getElementById('Receipt-Amount-Container').remove();
                        document.getElementById('Receipt-Items-Container').remove();
                        document.getElementById('Receipt-Discount-Container').remove();
                    }

                    
                } else {
                    Modules.ReceiptModule(params);
                    alert("Error Loading Page");
                }
            });
    }
}
