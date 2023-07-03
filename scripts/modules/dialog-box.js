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
    }
}

export function openAlertDialogBox(title,message){
    const box = document.getElementById("Dialog-Box-Container");
    const header = document.getElementById("Dialog-Box-header");
    const body = document.getElementById("Dialog-Box-Body");

    box.style.display = "flex";
    header.innerHTML = title;
    body.innerHTML = `
    <div class="message">`+ message +`</div>
    `;
}

export function closeDialogBox() {
    const box = document.getElementById("Dialog-Box-Container");
    box.style.display = "none";
}

