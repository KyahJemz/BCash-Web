
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
}