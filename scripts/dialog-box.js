function openDialogBox(type){
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

function closeDialogBox() {
    const box = document.getElementById("Dialog-Box-Container");
    box.style.display = "none";
}

document.addEventListener('click', function(event) {
    const dialogContainer = document.getElementById('Dialog-Box-Container');
    const dialogContent = document.querySelector('.dialog-content');
    
    if (event.target === dialogContainer && !dialogContent.contains(event.target)) {
        closeDialogBox();
    }
});