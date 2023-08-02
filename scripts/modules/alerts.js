
export default class Alerts {

    constructor(){
        this.AlertTimeout = 3000;
        this.AlertCount = 5;
        this.alertTable = document.querySelector(".Alert-Box-Table");
        this.alertType = '';
        this.alertText = '';
    }

    addAlertElement(){
        if (!this.alertTable) {
            throw new Error("Alert table element not found in the DOM.");
        }

        const newRow = document.createElement('tr');
        newRow.className = "Alert-box";  
        
        const newCell = document.createElement('td');
        newCell.innerHTML = this.getAlertView();
        
        newRow.appendChild(newCell);
        this.element = newRow;
        this.alertTable.appendChild(newRow);
    }

    removeAlertElement() {
        if (this.element && this.alertTable.contains(this.element)) {
          this.alertTable.removeChild(this.element);
        }
      }

    getAlertView(){
        return `
            <div class="header">
                <div class="title">
                    <p class="text">`+ this.alertType +`</p>
                </div>
                <div class="close">
                    <p class="close-btn cursor-pointer">X</p>
                </div>
            </div>
            <div class="Alert-content">
                <p>`+ this.text +`</p>
            </div>
        `;
    }

    activateAlertContainer() {
        const box = document.getElementById("Alert-Box-Container");
        if (box) {
          box.style.display = "flex";
        }
      }
    
    deactivateAlertContainer() {
        const box = document.getElementById("Alert-Box-Container");
        if (box) {
          box.style.display = "none";
        }
      }

    createAlert(type, text){
        if (!type || !text) {
            throw new Error("Invalid type or text for creating an alert.");
        }

        this.alertType = type;
        this.alertText = text;

        if (this.alertType === "warning") {

        } else if (this.alertType === "danger") {

        } else if (this.alertType === "success") {
            
        } 

        this.addAlertElement();
        
        setTimeout(() => {
            this.removeAlertElement();
        }, this.AlertTimeout);
    }
}