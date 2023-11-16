
export default class Modals {

    constructor() {
        this.box = null;
        this.header = null;
        this.body = null;
        this.type = '';
        this.title = '';
        this.content = '';
    }

    openModal() {
        if (this.box && this.header && this.body) {
            this.box.style.display = "flex";
            this.header.innerHTML = this.title;
            this.body.innerHTML = this.content;
        }
    }

    openAlertModal(){
        if (this.box && this.header && this.body) {
            this.box.style.display = "flex";
            this.header.innerHTML = this.title;
            this.body.innerHTML = `
                <div class="message-container">
                    <div class="message">${this.message}</div>
                    <div class="button"><button id="modal-btn-ok">OK</button></div>
                </div>
            `;

            document.getElementById("modal-box-btn-ok").addEventListener('click', () => {
                this.closeModal();
            });
        }
    }
    
    closeModal() {
        if (this.box) {
            this.box.style.display = "none";
        }
    }

    activateModal(type, title, content, targetFunction) {
        this.box = document.getElementById("Modal-Container");
        this.header = document.getElementById("Modal-Header");
        this.body = document.getElementById("Modal-Body");

        if (!this.box || !this.header || !this.body) {
            throw new Error("Modal DOM elements not found.");
        }

        this.type = type;
        this.title = title;
        this.content = content;

        if (this.type === "AlertModal") {
            this.openAlertModal();
        } else if (this.type === "Modal") {
            this.openModal();
        } else if (this.type === "ConfirmModal") {
            this.openConfirmationBox(targetFunction);
        } else {
            throw new Error("Invalid modal type.");
        }
    }

    openConfirmationBox(targetFunction) {
        if (this.box && this.header && this.body) {
            this.box.style.display = "flex";
            this.header.innerHTML = this.title;
            this.body.innerHTML = `
                <div class="message-container">
                    <div class="message">${this.content}</div>
                    <div class="alert-button">
                        <button id="modal-btn-no">No</button>
                        <button id="modal-btn-yes">Yes</button>
                     </div>
                </div>
            `;

            document.getElementById("modal-btn-yes").addEventListener('click', ()=>{
                targetFunction();
                document.getElementById("Modal-Container").style.display = "none";
            });
            document.getElementById("modal-btn-no").addEventListener('click', ()=>{
                document.getElementById("Modal-Container").style.display = "none";
            });
        }
    }

    modalViews = []
    getModalView(type,value){
        if (type=="Add-Item"){
            return `
                <div class="Add-Item">
                    <div class="image">
                        <img src="${MainURL}public/images/items/default.png" alt="">
                    </div>
                    <form action="" onsubmit="return false;" class="form" id="AddItem-Form" enctype="multipart/form-data">
                        <div>
                            <p>Item Image</p>
                            <input id="AddItem-Image" type="file" name="Image" accept="image/*">
                        </div>
                        <div>
                            <p>Item Name</p>
                            <input id="AddItem-Name" type="text" title="25 Character Limit"  name="ItemName" maxlength="25" required>
                        </div>
                        <div>
                            <p>Item Cost</p>
                            <input id="AddItem-Cost" type="number" title="Number Only" name="ItemCost" required>
                        </div>
                        <div>
                            <p>Item Category</p>
                            <input id="AddItem-Category" type="text" title="Can be Existing Category or new Category" name="ItemCategory" required>
                        </div>
                        <div class="button-container">
                            <button id="AddItem-CancelBtn" class="dialog-box-close-button" type="button">Cancel</button>
                            <button id="AddItem-SubmitBtn" type="submit" name="form" value="Add-Item">Save Changes</button>
                        </div>
                    </form>
                </div>
            `;
    
           // bindDialogBoxCloseButton();
    
        } else if (type=="Edit-Item"){
            return `
                <div class="Edit-Item">
                    <div class="image">
                        <img src="${MainURL}public/images/items/${value['ItemImage']}" alt="">
                    </div>
                    <div class="form">
                        <div>
                            <p>Item Image</p>
                            <input id="EditItem-Image" type="file" value="${value['ItemImage']}" name="item-image" accept="image/*">
                        </div>
                        <div>
                            <p>Item Name</p>
                            <input id="EditItem-Name" type="text" value="${value['ItemName']}" title="25 Character Limit"  name="item-name" maxlength="25" required>
                        </div>
                        <div>
                            <p>Item Cost</p>
                            <input id="EditItem-Cost" type="number" value="${value['ItemCost']}" title="Number Only" name="item-cost" required>
                        </div>
                        <div>
                            <p>Item Category</p>
                            <input id="EditItem-Category" type="text" value="${value['ItemCategory']}" title="Can be Existing Category or new Category" name="item-category" required>
                        </div>
                        <div class="button-container" data-itemid="${value['ItemId']}">
                            <button id="EditItem-CancelBtn" class="dialog-box-close-button" type="button">Cancel</button>
                            <button id="EditItem-SubmitBtn" type="submit" name="form" value="Add-Item">Save Changes</button>
                        </div>
                    </div>
                </div>
            `;

            // bindDialogBoxCloseButton();
        
        } else if (type=="Delete-Item"){
            return `
                <div class="Delete-Item">
                    <div class="form">
                        <div>
                            <p><strong>Are you sure you want to delete this item?</strong></p>
                            <p><em>Item Name: ${value['ItemName']}</em></p>
                            <p><em>Item Cost: ${value['ItemCost']}</em></p>
                            <p><em>Item Category: ${value['ItemCategory']}</em></p>
                            <br>
                            <p>Please confirm the deletion by entering your PIN CODE below:</p>
                            <input id="DeleteItem-PINCode" type="password">
                            <input id="DeleteItem-ItemId" value="${value['ItemId']}" hidden type="text">
                        </div>
                        <div class="button-container">
                            <button id="DeleteItem-CancelBtn" class="dialog-box-close-button" type="button">Cancel</button>
                            <button id="DeleteItem-SubmitBtn" type="submit">Delete</button>
                        </div>
                    </div>
                </div>
            `;
    
            // bindDialogBoxCloseButton();
        
        } else if (type=="Place-Order"){

            var view = ``;
    
            const orders = value.items;
            if (orders !== "") {
                if (orders.length !== 0) {
                    var quantiy = 0;
                    var subtotal = 0;
                    var discount = document.getElementById("txt-order-Discount").value;
                    var data = ``;
            
                    orders.forEach(item => {
                    quantiy = Number(quantiy) + Number(item.quantity);
                    subtotal = Number(subtotal) + Number(item.cost);
                    data = data + `
                        <div class="item">
                            <div class="name">`+item.name+`</div>
                            <div class="cost">
                                <p>x`+item.quantity+`</p>
                                <p>₱ `+Number(item.cost).toFixed(2)+`</p>
                            </div>
                        </div>
                    `;
                    });
        
                    view = ``;
        
                    view = `
                        <div class="order-confirmation">
                            <div id="order-status" class="status"><p class="warning">Status: Preparing<p></div>
                            <div id="order-content" class="content">
                                <div class="left-panel">
                                    <div class="list">
                                        <div class="list-header">
                                            <p><strong>Order Summary</strong></p>
                                        </div>
                                        `+data+`
                                    </div>
                                    <div class="summary">
                                        <p class="quantity"><strong>Items: </strong>`+quantiy+`</p>
                                        <p class="subtotal"><strong>Subtotal: </strong>₱ `+Number(subtotal).toFixed(2)+`</p>
                                        <p id="order-discount" data-value="`+(discount)+`" class="discount"><strong>Discount: </strong>₱ `+Number(discount).toFixed(2)+`</p>
                                        <p class="total"><strong>Total: </strong>₱ <a id="order-total">`+(Number(subtotal)-Number(discount)).toFixed(2)+`</a></p>
                                    </div>
                                </div>
                                <div class="right-panel">
                                    <div id="order-qrcode" class="qr-code">
                                        <p><strong>QR-Code:</strong></p>
                                        <button id="order-qrScan">Use QR</button>
                                    </div>
                                    <div class="id-card">
                                        <p><strong>Id Card or Manual Input: </strong></p>
                                        <input id="order-userid" type="search">
                                    </div>
                                    <div class="details">
                                        <fieldset>
                                            <legend>Details:</legend>
                                            <p class="Name"><strong>Name: </strong><input readonly type="text" id="order-name"></p>
                                            <p class="Balance"><strong>Balance: </strong><input readonly type="text" id="order-balance"></p>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div id="order-buttons" class="buttons">
                                <button class="btn-back dialog-box-close-button">Cancel</button>
                                <button id="order-submit" class="btn-submit">Submit</button>
                            </div>
                        </div>
                    `;
    
                    // bindDialogBoxCloseButton();
                }

                return view;
            }
        } else if (type=="Notification Panel"){
            const notificationArray = value;
    
            let view = ``;
            var layout = ``;
    
            if (notificationArray.length > 0) {
                notificationArray.forEach(element => {
                    layout = layout + `
                        <div class="notification-item" data-isnew="`+ element['IsNew'] +`" data-id="`+ element['Notification_ID '] +`">
                            <div class="title-container">
                                <p class="title">`+ element['Title'] +`</p>
                                <p class="date">`+ element['Timestamp'] +`</p>
                            </div>
                            <div class="content-container">
                                <p class="content">`+ element['Content'] +`</p>
                            </div>
                        </div>
                    `;
                });
        
                view = view + `<div id="notification-list" class="notification-list">` + layout + `</div>`;
            }

            return view;
    
        } else if (type=="Settings Panel"){
            const Information = value;
            return `
                <div class="personal-information-container">
                    <fieldset class="personalInformationSettings">
                        <table>
                            <tr>
                                <td>
                                    <img src="${MainURL}public/images/profiles/default.png" alt="profile">
                                </td>
                                <td>
                                    <p>Account Address:</p>
                                    <input id="AccountSettings-AccountAddress" style="background-color: rgb(220, 220, 220);" type="text" readonly name="UserId" value="${Information.Account['WebAccounts_Address']}">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Firstname:</p>
                                    <input id="AccountSettings-Firstname" type="text" name="Firstname" value="${Information.Account['Firstname']}">
                                </td>
                                <td>
                                    <p>Lastname:</p>
                                    <input id="AccountSettings-Lastname" type="text" name="Lastname" value="${Information.Account['Lastname']}">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Category:</p>
                                    <input type="text" style="background-color: rgb(220, 220, 220);" readonly name="ActorCategory" value="${Information.Details['ActorCategory']}">
                                </td>
                                ${Information.Details['MerchantCategory'] ? `<td>
                                    <p>Merchant Category:</p>
                                    <input type="text" style="background-color: rgb(220, 220, 220);" readonly name="MerchantCategory" value="${Information.Details['MerchantCategory']}">
                                </td>` : ``}
                            </tr>
                            <tr>
                                ${Information.Details['ActorCategory'] === 'Merchant Staff' ? `
                                <td>
                                    <p>E-Mail:</p>
                                    <input style="background-color: rgb(220, 220, 220);" id="AccountSettings-Email" readonly type="text" name="Email" value="${Information.Account['Email']}">
                                </td>
                                ` : `
                                <td>
                                    <p>E-Mail:</p>
                                    <input id="AccountSettings-Email" type="text" name="Email" value="${Information.Account['Email']}">
                                </td>
                                `}
                            </tr>
                        </table>
                    </fieldset>
                    <fieldset class="passwordSettings">
                        <legend><p>Password Settings</p></legend>
                        <table>
                            <tr>
                                <td><label for="changePassword"><p>Change Password?</p></label></td>
                                <td><input type="checkbox" name="changePassword" id="AccountSettings-ChangePassword"></td>
                            </tr>
                            <tr>
                                <td><p>New Password:</p></td>
                                <td><input id="AccountSettings-NewPassword1" type="password" name="NewPassword" placeholder="*****************"></td>
                            </tr>
                            <tr>
                                <td><p>Re-type New Password:</p></td>
                                <td><input id="AccountSettings-NewPassword2" type="password" name="ConfirmNewPassword" placeholder="*****************"></td>
                            </tr>
                        </table>
                    </fieldset>
                    <fieldset class="pinCodeSettings">
                        <legend><p>Pin Code Settings</p></legend>
                        <table>
                            <tr>
                                <td><label for="changePinCode"><p>Change PIN code?</p></label></td>
                                <td><input type="checkbox" name="changePinCode" id="AccountSettings-ChangePINCode"></td>
                            </tr>
                            <tr>
                                <td><p>New PIN Code:</p></td>
                                <td><input id="AccountSettings-NewPINCode1" type="password" name="NewPinCode" placeholder="******"></td>
                            </tr>
                            <tr>
                                <td><p>Re-type New PIN Code:</p></td>
                                <td><input id="AccountSettings-NewPINCode2" type="password" name="ConfirmNewPinCode" placeholder="******"></td>
                            </tr>
                        </table>
                    </fieldset>
                    <fieldset class="ConfirmChanges">
                        <legend><p>Confirmation</p></legend>
                        <table>
                            <tr>
                                <td colspan="2">
                                    <p class="center-text">Required to apply changes.</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Current Password:</p>
                                    <input id="AccountSettings-OldPassword" type="password" name="OldPassword" placeholder="">
                                </td>
                                <td>
                                    <p>Current PIN Code:</p>
                                    <input id="AccountSettings-OldPINCode" type="password" name="OldPINCode" placeholder="">
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                    <div class="buttons-container">
                        ${Information.Account['WebAccounts_Address'].substring(0, 3) === 'ADM' ? `<button id="btn-all-activity-history" class="btn-submit">All Activity Logs</button>` : ''}
                        ${Information.Account['WebAccounts_Address'].substring(0, 3) === 'ADM' ? `<button id="btn-administrators-activity-history" class="btn-submit">Administrators Activity Logs</button>` : ''}
                        ${Information.Account['WebAccounts_Address'].substring(0, 3) === 'ACT' ? `<button id="btn-all-accountings-activity-history" class="btn-submit">All Accountings Activity Logs</button>` : ''}
                        ${Information.Account['WebAccounts_Address'].substring(0, 3) === 'MTA' ? `<button id="btn-merchant-activity-history" class="btn-submit">Merchant Activity Logs</button>` : ''}
                        <button id="btn-activity-history" class="btn-submit ">Activity Logs</button>
                        <button id="btn-login-history" class="btn-submit ">Login History</button>
                        <button id="btn-submit-account-changes" class="btn-submit ">Update Changes</button>
                    </div>
                </div>
            `;
    
            //  bindDialogBoxCloseButton();
        }
    }
}


export function makeModal(type, title, content){
    const modal = new Modals();
    modal.activateModal(type, title, content);
}