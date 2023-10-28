export default class Menu {

  toggleSubMenuDropdown(value) {
    const menuMoreIcon = value.querySelector(".more");
    const menuSubitems = value.nextElementSibling;
  
    if (menuSubitems.style.height === "fit-content") {
      menuMoreIcon.style.transform = "rotate(0deg)";
      menuSubitems.style.height = "0px";
      menuSubitems.style.display = "none";
    } else {
      menuMoreIcon.style.transform = "rotate(180deg)";
      menuSubitems.style.height = "fit-content";
      menuSubitems.style.display = "flex";
    }
  }
  
  ChangeMenuSelected(value) {
    const elements = document.querySelectorAll(".menuSelectionButton");
    if (elements) {
      elements.forEach((element) => {
        if (element.classList.contains("menu-selected")) {
          element.classList.remove("menu-selected");
        }
        if (element.dataset.menu === value) {
          element.classList.add("menu-selected");
        }
      });
    }
  }
    
  ChangePanel(panelId) {
    const element = document.getElementById(panelId);
    if (element) {
      element.classList.toggle("hidden", false);
      element.classList.toggle("visible", true);
    }
  }
    
  HideAllPanels() {
    const panels = document.querySelectorAll(".body-content-panel");
    panels.forEach((panel) => {
      panel.classList.remove("visible");
      panel.classList.add("hidden");
    });
  }
  
  ChangeTitle(value) {
    const titleElement = document.getElementById("Panel-Title");
    if (titleElement) {
      titleElement.textContent = value;
    }
  }  

  //EVENTS
menuSelectionEvents(event, items, order) {
  // Used ".replace(new RegExp(" ", 'g'), '')" to remove spaces
  const value = event.currentTarget;
  const panelName = value.dataset.menu;
  const panelId = "panel-"+panelName.replace(new RegExp(" ", 'g'), '').toLowerCase();

  
  if (value.classList.contains("menuSelectionDropdownButton")) {
    this.toggleSubMenuDropdown(value); 
  } else {
    if(document.getElementById(panelId)){
      this.ChangeTitle(panelName);
      this.ChangeMenuSelected(panelName);
      this.HideAllPanels(panelId);
      this.ChangePanel(panelId);
    } else {
      console.log("Panel Does Not Exist");
    }
  }

  // Check and Refresh Items Depending On Panel Clicked

  if (panelName === "Item Management"){
    try {
      items.displayItems(items, order, panelName.replace(new RegExp(" ", 'g'), ''));
    } catch (error) {
      console.error("Error getting items or order:", error);
    }
  } 

  if (panelName === "Create Order") {
    try {
      items.displayItems(items, order, panelName.replace(new RegExp(" ", 'g'), ''));
    } catch (error) {
      console.error("Error getting items or order:", error);
    }
  }

}











}
