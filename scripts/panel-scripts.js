

function dropdown(event, value, position) {
    event.stopPropagation();    
    if (position === "top") {
        var dropdownContent = value.previousElementSibling;
        dropdownContent.classList.toggle("dropdown-content-top");
    } else {
        var dropdownContent = value.nextElementSibling;
        dropdownContent.classList.toggle("dropdown-content-bottom");
    }
    dropdownContent.classList.toggle("dropdownshow");
    let image = value.querySelector(".dropdown-arrow");
    image.classList.toggle("rotate")
}
  
function changeSelection(element) {
    let grandparent = element.parentNode.parentNode;
    let btnText = grandparent.querySelector(".dropdown-text");
    btnText.textContent = element.textContent;

    let dropdownSelected = element.parentNode.querySelector('.dropdown-selected');
    dropdownSelected.classList.remove('dropdown-selected');
    element.classList.add('dropdown-selected');

    if (element.textContent === "Card") {
        document.getElementById("icon-layout-1").src="../images/icons/grid-yellow.png";
    } else if (element.textContent === "List"){
        document.getElementById("icon-layout-1").src="../images/icons/list-yellow.png";
    }
}
  
window.onclick = function(event) {
    if (!event.target.matches('.dropdownbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('dropdownshow')) {
                openDropdown.classList.remove('dropdownshow');
                openDropdown.classList.remove('dropdown-content-top');
                openDropdown.classList.remove('dropdown-content-bottom');
            }
        }

        var dropdownarrow = document.getElementsByClassName("dropdown-arrow");
        var i;
        for (i = 0; i < dropdownarrow.length; i++) {
            var openDropdownArrow = dropdownarrow[i];
            if (openDropdownArrow.classList.contains('rotate')) {
                openDropdownArrow.classList.remove('rotate');
            }
        }
    }
}


