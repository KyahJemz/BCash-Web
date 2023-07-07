import {
    getOrder,
    bindDialogBoxCloseButton
} from '../main.js';

export function openDialogBox(type,data){
    const box = document.getElementById("Dialog-Box-Container");
    const header = document.getElementById("Dialog-Box-header");
    const body = document.getElementById("Dialog-Box-Body");
    if (type=="Add-Item"){
        box.style.display = "flex";
        header.innerHTML = "Add Item Form"
    } else if (type=="Edit-Item"){
        box.style.display = "flex";
        header.innerHTML = "Edit Item Form";

        body.innerHTML = ``;
        body.innerHTML = `
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

                bindDialogBoxCloseButton();

    } else if (type=="Delete-Item"){
        box.style.display = "flex";
        header.innerHTML = "Delete Item Confirmation"

        body.innerHTML = ``;
        body.innerHTML = `
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

            bindDialogBoxCloseButton();

    } else if (type=="Place-Order"){
        box.style.display = "flex";
        header.innerHTML = "Order Confirmation"

        console.log(getOrder());
        const order = getOrder();
        if (order !== "") {
            if (order.items.length !== 0) {
                var quantiy = 0;
                var subtotal = 0;
                var discount = document.getElementById("txt-order-Discount").value;
                var data = ``;
        
                order.items.forEach(item => {
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
                `
                });
    
                body.innerHTML = ``;
    
                body.innerHTML = `
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

                    bindDialogBoxCloseButton();
            }
    
        }
        
        
    }

    
}

export function openAlertDialogBox(title,message){
    const box = document.getElementById("Dialog-Box-Container");
    const header = document.getElementById("Dialog-Box-header");
    const body = document.getElementById("Dialog-Box-Body");

    box.style.display = "flex";
    header.innerHTML = title;
    body.innerHTML = `
    <div class="message-container">
        <div class="message">`+ message +`</div>
        <div class="button"><button id="dialog-box-btn-ok">OK</button></div>
    </div>
    `;

    document.getElementById("dialog-box-btn-ok").addEventListener('click', () => {
        closeDialogBox();
    });
}

export function closeDialogBox() {
    const box = document.getElementById("Dialog-Box-Container");
    box.style.display = "none";
}

