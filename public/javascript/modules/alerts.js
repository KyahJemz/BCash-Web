
export default class Alerts {

    constructor(table){
        this.AlertTimeout = 3000;
        this.AlertCount = 5;
        this.alertTable = table;
        this.alertType = '';
        this.alertText = '';
    }

    // Alert type : danger warning success

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
            <div class="Alert-content `+ this.alertType +`">
                <p>`+ this.alertText +`</p>
            </div>
        `;
    }

    createAlertElement(type, text){
        if (!type || !text) {
            throw new Error("Invalid type or text for creating an alert.");
        }

        this.alertType = type;
        this.alertText = text;

        this.addAlertElement();
        
        setTimeout(() => {
            this.removeAlertElement();
        }, this.AlertTimeout);
    }
}