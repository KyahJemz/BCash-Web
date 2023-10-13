
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
                this.closeDialogBox();
            });
        }
    }
    
    closeModal() {
        if (this.box) {
            this.box.style.display = "none";
        }
    }

    activateModal(type, title, content) {
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
        } else {
            throw new Error("Invalid modal type.");
        }
    }

    modalViews = []
    getModalView(type,value){
        if (type=="Add-Item"){
            return `
                <div class="Add-Item">
                    <div class="image">
                        <img src="../images/school.jpg" alt="">
                    </div>
                    <div class="form">
                        <div>
                            <p>Item Image</p>
                            <input type="file" name="item-image" accept="image/*">
                        </div>
                        <div>
                            <p>Item Name</p>
                            <input type="text" title="25 Character Limit"  name="item-name" maxlength="25" required>
                        </div>
                        <div>
                            <p>Item Cost</p>
                            <input type="number" title="Number Only" name="item-cost" required>
                        </div>
                        <div>
                            <p>Item Category</p>
                            <input type="text" title="Can be Existing Category or new Category" name="item-category" required>
                        </div>
                        <div class="button-container">
                            <button class="dialog-box-close-button" type="button">Cancel</button>
                            <button type="submit" name="form" value="Add-Item">Save Changes</button>
                        </div>
                    </div>
                </div>
            `;
    
            // bindDialogBoxCloseButton();
    
        } else if (type=="Edit-Item"){
            return `
                <div class="Edit-Item">
                    <div class="image">
                        <img src="../images/school.jpg" alt="">
                    </div>
                    <div class="form">
                        <div>
                            <p>Item Image</p>
                            <input type="file" name="item-image" accept="image/*">
                        </div>
                        <div>
                            <p>Item Name</p>
                            <input type="text" title="25 Character Limit"  name="item-name" maxlength="25" required>
                        </div>
                        <div>
                            <p>Item Cost</p>
                            <input type="number" title="Number Only" name="item-cost" required>
                        </div>
                        <div>
                            <p>Item Category</p>
                            <input type="text" title="Can be Existing Category or new Category" name="item-category" required>
                        </div>
                        <div class="button-container">
                            <button class="dialog-box-close-button" type="button">Cancel</button>
                            <button type="submit" name="form" value="Add-Item">Save Changes</button>
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
                            <p><em>Item Name: Tinapaty</em></p>
                            <p><em>Item Cost: $132</em></p>
                            <p><em>Item Category: Food</em></p>
                            <br>
                            <p>Please confirm the deletion by entering your PIN CODE below:</p>
                            <input type="text" name="item-delete-Pin-Code">
                        </div>
                        <div class="button-container">
                            <button class="dialog-box-close-button" type="button">Cancel</button>
                            <button type="submit" name="form" value="Add-Item">Delete</button>
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
                            <div class="status">Status: PREPARING</div>
                            <div class="content">
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
                                        <p class="discount"><strong>Discount: </strong>₱ `+Number(discount).toFixed(2)+`</p>
                                        <p class="total"><strong>Total: </strong>₱ `+(Number(subtotal)-Number(discount)).toFixed(2)+`</p>
                                    </div>
                                </div>
                                <div class="right-panel">
                                    <div class="qr-code">
                                        <p><strong>QR-Code:</strong></p>
                                        <img src="../public/images/sample-qr.jpg" alt="">
                                        <button>Generate</button>
                                    </div>
                                    <div class="id-card">
                                        <p><strong>Id Card or Manual Input: </strong></p>
                                        <input type="search">
                                    </div>
                                    <div class="details">
                                        <fieldset>
                                            <legend>Details:</legend>
                                            <p class="Name"><strong>Name: </strong></p>
                                            <p class="Category"><strong>Categoty: </strong></p>
                                            <p class="waletId"><strong>Wallet Id: </strong></p>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div class="buttons">
                                <button class="btn-back dialog-box-close-button">Cancel</button>
                                <button class="btn-submit">Submit</button>
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
            console.log(Information);
            return `
                <div class="personal-information-container">
                    <fieldset class="personalInformationSettings">
                        <table>
                            <tr>
                                <td>
                                    <img src="" alt="">
                                </td>
                                <td>
                                    <p>User Id:</p>
                                    <input id="AccountSettings-AccountAddress" type="text" readonly name="UserId" value="${Information.Account['WebAccounts_Address']}">
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
                                    <p>User Category:</p>
                                    <input type="text" readonly name="ActorCategory" value="${Information.Account['ActorCategory']}">
                                </td>
                                ${Information.Account['MerchantCategory'] ? `<td>
                                    <p>Merhant Category:</p>
                                    <input type="text" readonly name="MerchantCategory" value="${Information.Account['MerchantCategory']}">
                                </td>` : ``}
                            </tr>
                            <tr>
                                <td>
                                    <p>E-Mail:</p>
                                    <input id="AccountSettings-Email" type="text" name="Email" value="${Information.Account['Email']}">
                                </td>
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
                                <td><p>Old Password:</p></td>
                                <td><input id="AccountSettings-OldPassword" type="password" name="OldPassword" placeholder="*****************"></td>
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
                                <td><p>Old PIN Code:</p></td>
                                <td><input id="AccountSettings-OldPINCode" type="password" name="OldPinCode" placeholder="******"></td>
                            </tr>
                            <tr>
                                <td><p>New PIN Code:</p></td>
                                <td><input id="AccountSettings-NewPINCode1 type="password" name="NewPinCode" placeholder="******"></td>
                            </tr>
                            <tr>
                                <td><p>Re-type New PIN Code:</p></td>
                                <td><input id="AccountSettings-NewPINCode2 type="password" name="ConfirmNewPinCode" placeholder="******"></td>
                            </tr>
                        </table>
                    </fieldset>
                    <div class="buttons-container">
                        <button class="btn-back dialog-box-close-button">Close</button>
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