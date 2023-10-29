import AjaxRequest from '../ajax.js';
import { makeModal } from './modals.js';
import Helper from '../helper.js';

export default class ActivityHistory {
  constructor(intent) {
    this.records = [];
    this.intent = intent;
  }

  getView(){
    let view = ``;
    var layout = ``;
    const helper = new Helper();
    if (this.records.length > 0) {
      this.records.forEach(element => {
        layout = layout + `
          <div class='activity-logs-row'>
            ${element.Action === 'Add' ? `<div style="background-image: url('../public/images/icons/bolt.png');" class="mark"></div>` 
            : element.Action === 'Edit' ? `<div style="background-image: url('../public/images/icons/edit.png');" class="mark"></div>` 
            : element.Action === 'Delete' ? `<div style="background-image: url('../public/images/icons/delete.png');" class="mark"></div>` 
            : 'ss'
            }
            <div class="details">
              <p class="name">
                ${
                  AccountAddress === element.Account_Address ? 'You':
                  element.Account_Address.substring(0, 3) === 'ADM' ? 'Administrator' :
                  element.Account_Address.substring(0, 3) === 'ACT' ? 'Accounting' :
                  element.Account_Address.substring(0, 3) === 'MTS' ? element.Account_Address :
                  element.Account_Address
                }
              </p>
              <p class="date">${element.Timestamp}</p>
              <p class="task">${element.Task}</p>
            </div>
          </div>`;
      });

      view = view + `
        <div id="activity-logs-list" class="activity-logs-list">
          <p>These are your accounts recorded activity logs.</p>
          ` + layout + `
        </div>`;
    } else {
      view = view + `
        <div id="activity-logs-list" class="activity-logs-list">
          <p>No recorded logs.</p>
        </div>`;
    }
    return view;
  }

  open(){
    const Ajax = new AjaxRequest(BaseURL);
    const helper = new Helper();
//get my activity logs
    Ajax.sendRequest([], this.intent)
    .then(responseData => {
      this.records = responseData.Parameters;
      makeModal('Modal', 'Activity Logs', this.getView());

    });
  }
}