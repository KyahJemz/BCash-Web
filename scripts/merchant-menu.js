
let menuMyOrderActivated = false;

function menuSelection(selected) {
    
    if (selected === "myorders") {
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
        let x = document.getElementById(selected);
        let elements = document.getElementsByClassName("menu-selected");
        for (var i = 0; i < elements.length; i++) {
            elements[i].classList.remove("menu-selected");
        }
        x.classList.remove("menu-selected")
        x.classList.add("menu-selected")
    }
    console.log(selected);

    HideAllPanels();

    if (selected === "transactions") {
        const panel = document.getElementById("panel-transactions");
        panel.classList.remove("hidden");
        ChangeTitle("Transactions");
    } else {
        ChangeTitle(" ")
        HideAllPanels()
    }
}

function HideAllPanels() {
    let panels = document.getElementsByClassName("body-content-panel");
    for (var i = 0; i < panels.length; i++) {
        panels[i].classList.remove("visible");
        if (!(panels[i].classList.contains("hidden"))) {
            panels[i].classList.add("hidden");
        }
    }
}


function ChangeTitle(value) {
    document.getElementById("body-content-titlebar").innerHTML = value;
}