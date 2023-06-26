let menuMyOrderActivated = false;

export function toggleMyOrdersMenu() {
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
  }

export function ChangeMenuSelected(value) {
    const x = document.getElementById(value);
    console.log(value);
  
    let elements = document.getElementsByClassName("menu-selected");
    for (var i = 0; i < elements.length; i++) {
      elements[i].classList.remove("menu-selected");
    }
    x.classList.add("menu-selected")
    console.log(value);
  }
  
export function ChangePanel(value) {
    let x = "panel-" + value.toLowerCase();
    let element = document.getElementById(x);
    if (element.classList.contains("hidden")) {
      element.classList.remove("hidden");
    }
    element.classList.add("visible");
    if (!(element.classList.contains("visible"))) {
      element.classList.add("visible");
    }
    console.log(value + 123);
  }
  
  export function HideAllPanels() {
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

  export function ChangeTitle(value) {
    document.getElementById("Panel-Title").innerHTML = value;
  }
