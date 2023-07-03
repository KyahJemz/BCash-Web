import {getOrder} from '../main.js';

export function openDialogBox(type){
    const box = document.getElementById("Dialog-Box-Container");
    const header = document.getElementById("Dialog-Box-header");
    const body = document.getElementById("Dialog-Box-Body");
    if (type=="Add-Item"){
        box.style.display = "flex";
        header.innerHTML = "Add Item Form"
    } else if (type=="Edit-Item"){
        box.style.display = "flex";
        header.innerHTML = "Edit Item Form"
    } else if (type=="Delete-Item"){
        box.style.display = "flex";
        header.innerHTML = "Delete Item Confirmation"
    } else if (type=="test"){
        box.style.display = "flex";
        header.innerHTML = "test"

        const order = getOrder();

        if (order !== "") {
            let quantiy = 0;
            let subtotal = 0;
            let discount = document.getElementById("txt-order-Discount").value;
            let data = ``;
    
            order.items.forEach(item => {
            quantiy = Number(quantiy) + Number(item.quantity);
            subtotal = Number(subtotal) + Number(item.cost);
            data = data + `
                <div class="item">
                    <div class="name">`+item.name+`</div>
                    <div class="cost">`+item.cost+`</div>
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
                                    <div class="name"><strong>Name</strong></div>
                                    <div class="cost"><strong>Cost</strong></div>
                                </div>
                                `+data+`
                            </div>
                            <div class="summary">
                                <p class="quantity"><strong>Items: </strong>`+quantiy+`</p>
                                <p class="subtotal"><strong>Subtotal: </strong>₱ `+subtotal+`</p>
                                <p class="discount"><strong>Discount: </strong>₱ `+discount+`</p>
                                <p class="total"><strong>Total: </strong>₱ `+Number(subtotal)-Number(discount)+`</p>
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
                                    <p class="Name"><strong>Name: </strong>stephen regan james layson</p>
                                    <p class="Category"><strong>Categoty: </strong>Student</p>
                                    <p class="waletId"><strong>Wallet Id: </strong> 235dfg463f34646r3</p>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="buttons">
                        <button class="btn-back">Cancel</button>
                        <button class="btn-submit">Submit</button>
                    </div>
                </div>
                `;
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

