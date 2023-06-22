function openDialogBox(type){
    if (type=="Add-Item"){
        const box = document.getElementById("Dialog-Box-Container");
        const header = document.getElementById("Dialog-Box-header");
        const body = document.getElementById("Dialog-Box-Body");

        box.style.display = "flex";
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