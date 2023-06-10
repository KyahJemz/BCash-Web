
let menuMyOrderActivated = false;

function menuSelection(selected) {
    const value = selected.querySelector('p').innerText;
    console.log(value); 

    if (value === "My Orders") {
        const menuMore = document.getElementById("sidebar-bottom-menu-myorders-more");
        const menuSubitems = document.getElementById("sidebar-bottom-menu-myorders-subitems");

        if (menuMyOrderActivated) {
            menuMyOrderActivated = false;
            menuMore.style.transform = "rotate(0deg)";
            menuSubitems.style.height = "0px";
        } else {
            menuMyOrderActivated = true;
            menuMore.style.transform = "rotate(180deg)";
            menuSubitems.style.height = "90px";
        }
    } else {

        ChangeTitle(value);

        ChangeMenuSelected(value.replace(new RegExp(" ", 'g'), ''));

        HideAllPanels(value.replace(new RegExp(" ", 'g'), ''));

       ChangePanel(value.replace(new RegExp(" ", 'g'), ''))

       // loadPanelContent('general-panel', '../webpages/panels/transaction-logs.html');
    }
}

function ChangeMenuSelected(value){
    const x = document.getElementById(value);
    console.log(value);

    let elements = document.getElementsByClassName("menu-selected");
    for (var i = 0; i < elements.length; i++) {
        elements[i].classList.remove("menu-selected");
    }
    x.classList.add("menu-selected")
    console.log(value);
}

function ChangePanel(value){
    let x = "panel-"+value.toLowerCase();
    let element = document.getElementById(x);
    if (element.classList.contains("hidden")) {
        element.classList.remove("hidden");
    }
    element.classList.add("visible");
    if (!(element.classList.contains("visible"))) {
        element.classList.add("visible");
    }console.log(value+123);
}

function HideAllPanels() {
    let panels = document.getElementsByClassName("body-content-panel");
    for (var i = 0; i < panels.length; i++) {
        if (panels[i].classList.contains("visible")) {
            panels[i].classList.remove("visible");
        }
        if (!(panels[i].classList.contains("hidden"))) {
            panels[i].classList.add("hidden");
        }
    }
}

function ChangeTitle(value) {
    document.getElementById("Panel-Title").innerHTML = value;
}




function loadPanelContent(panelId, panelFile) {

    const panelElement = document.getElementById(panelId);

    panelElement.innerHTML = "<div id='panel-transactions' class='body-content-panel hidden'> <div class='panel-transactions-query panel'> <div class='titlebar'><p>Query Conditions</p></div> <div class='panel-transactions-query-forms'> <div> <label for='StartDate'>Start Date</label> <input id='StartDate' class='textbox' type='date' name='StartDate'> </div> <div> <label for='EndDate'>End Date</label> <input id='EndDate' class='textbox' type='date' name='EndDate'> </div> <div> <label for='TransactionNumber'>Transaction Number</label> <input id='TransactionNumber' class='textbox' type='text' name='TransactionNumber'> </div> <div></div>";

        console.log(panelId);

}