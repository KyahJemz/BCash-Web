
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
                                        <img src="../images/sample-qr.jpg" alt="">
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
                    layout = layout + element.getNotificationBoxView();;
                });
        
                view = view + `<div id="notification-list" class="notification-list">` + layout + `</div>`;
            }

            return view;
    
        } else if (type=="Settings Panel"){
            return ``;
    
            //  bindDialogBoxCloseButton();
        }
    }
}
