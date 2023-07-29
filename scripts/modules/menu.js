export function toggleSubMenuDropdown(value) {
  const menuMoreIcon = value.querySelector(".more");
  const menuSubitems = value.nextElementSibling;

  if (menuSubitems.style.height === "fit-content") {
    menuMoreIcon.style.transform = "rotate(0deg)";
    menuSubitems.style.height = "0px";
    menuSubitems.style.display = "none";
  } else {
    menuMoreIcon.style.transform = "rotate(180deg)";
    menuSubitems.style.height = "fit-content";
    menuSubitems.style.display = "list-item";
  }
}

export function ChangeMenuSelected(value) {
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
  
export function ChangePanel(panelId) {
  const element = document.getElementById(panelId);
  if (element) {
    element.classList.toggle("hidden", false);
    element.classList.toggle("visible", true);
  }
}
  
export function HideAllPanels() {
  const panels = document.querySelectorAll(".body-content-panel");
  panels.forEach((panel) => {
    panel.classList.remove("visible");
    panel.classList.add("hidden");
  });
}

export function ChangeTitle(value) {
  const titleElement = document.getElementById("Panel-Title");
  if (titleElement) {
    titleElement.textContent = value;
  }
}
