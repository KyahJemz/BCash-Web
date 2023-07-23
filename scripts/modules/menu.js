export function toggleSubMenuDropdown(value) {
  const menuMoreIcon = value.querySelector(".more");
  const menuSubitems = value.nextElementSibling;

  if (menuSubitems.style.height === "fit-content") {
    menuMoreIcon.style.transform = "rotate(0deg)";
    menuSubitems.style.height = "0px";
    menuSubitems.style.display = "none"
  } else {
    menuMoreIcon.style.transform = "rotate(180deg)";
    menuSubitems.style.height = "fit-content";
    menuSubitems.style.display = "list-item"
  }
}

export function ChangeMenuSelected(value) {
  const elements = document.querySelectorAll(".menuSelectionButton");
  for (var i = 0; i < elements.length; i++) {
    if (elements[i].classList.contains("menu-selected")) {
      elements[i].classList.remove("menu-selected");
    }
  }

  elements.forEach(element => {
    if (element.dataset.menu === value) {
      if (!(element.classList.contains("menu-selected"))) {
        element.classList.add("menu-selected");
    }
    }
  });

}
  
export function ChangePanel(value) {
  let x = value;
  let element = document.getElementById(x);
  if (element) {
    element.classList.toggle("hidden", false);
    element.classList.toggle("visible", true);
  }
}
  
export function HideAllPanels() {
  let panels = document.getElementsByClassName("body-content-panel");
  if (panels.length > 0) {
    for (var i = 0; i < panels.length; i++) {
      if (panels[i].classList.contains("visible")) {
        panels[i].classList.remove("visible");
      }
      if (!(panels[i].classList.contains("hidden"))) {
        panels[i].classList.add("hidden");
      }
    }
  }
}

export function ChangeTitle(value) {
  const titleElement = document.getElementById("Panel-Title");
  if (titleElement) {
    titleElement.textContent = value;
  }
}
