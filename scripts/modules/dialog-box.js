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

