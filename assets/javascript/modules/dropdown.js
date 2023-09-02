
import Helper from '../helper.js';

export default class Dropdown {

  dropdown(event, value, position) {
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
  
changeSelection(element) {
  console.log(element.parentNode.parentNode);
  console.log(element.innerHTML);
    let grandparent = element.parentNode.parentNode;
    let btnText = grandparent.querySelector(".dropdown-text");
    btnText.innerHTML = element.innerHTML;

    let dropdownSelected = element.parentNode.querySelector('.dropdown-selected');
    dropdownSelected.classList.remove('dropdown-selected');
    element.classList.add('dropdown-selected');
/*
    if (element.innerHTML === "Card") {
        document.getElementById("icon-layout-1").src="../../images/icons/grid-yellow.png";
    } else if (element.innerHTML === "List"){
        document.getElementById("icon-layout-1").src="../../images/icons/list-yellow.png";
    }
*/
}

windowClickClearDropdown(event) {
    if (!event.target.matches('.dropdownbtn')) {
      const dropdowns = document.getElementsByClassName('dropdown-content');
      for (let i = 0; i < dropdowns.length; i++) {
        const openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('dropdownshow')) {
          openDropdown.classList.remove('dropdownshow');
          openDropdown.classList.remove('dropdown-content-top');
          openDropdown.classList.remove('dropdown-content-bottom');
        }
      }
  
      const dropdownarrow = document.getElementsByClassName('dropdown-arrow');
      for (let i = 0; i < dropdownarrow.length; i++) {
        const openDropdownArrow = dropdownarrow[i];
        if (openDropdownArrow.classList.contains('rotate')) {
          openDropdownArrow.classList.remove('rotate');
        }
      }
    }
  }
  
dropdownEvents(event) {
  const value = event.currentTarget;
  const position = value.dataset.layout;
  this.dropdown(event, value, position);
}

changeSelectionEvents(event,items,order) {
    const value = event.currentTarget;
    this.changeSelection(value);

    const panel = value.parentNode.parentNode.dataset.panel;
    console.log(panel);
    if (panel != undefined){
        items.displayItems(items, order, panel);

       // const helper = new Helper();
        //helper.addElementClickListener(".dropdownButtonSubItem", (event) => this.changeSelectionEvents(event,items,order));
    }
  }

  customChangeSelectionEvents(target,items,order) {
    this.changeSelection(target);

    const panel = value.parentNode.parentNode.dataset.panel;
    console.log(panel);
    if (panel != undefined){
        items.displayItems(items, order, panel);

       // const helper = new Helper();
        //helper.addElementClickListener(".dropdownButtonSubItem", (event) => this.changeSelectionEvents(event,items,order));
    }
  }


  






}


