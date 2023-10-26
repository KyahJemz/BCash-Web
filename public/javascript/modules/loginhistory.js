import AjaxRequest from '../ajax.js';
import { makeModal } from './modals.js';
import Helper from '../helper.js';

export default class LoginHistory {
  constructor() {
    this.records = [];
  }

  getView(){
    let view = ``;
    var layout = ``;

    if (this.records.length > 0) {
      this.records.forEach(element => {
        layout = layout + `
          <div class="login-history-item">
            <p class="LastOnline">Last Online:`+ element['LastOnline'] +`</p>
            <p class="Device">Device : `+ element['Device'] +`</p>
            <p class="IpAddress">IP Address : `+ element['IpAddress'] +`</p>
            <p class="Location">Location : `+ element['Location'] +`</p>
            <button class="remove-btn cursor-pointer" data-device="${element['Device']}" data-location="${element['Location']}" data-ipaddress="${element['IpAddress']}">Remove</button>
          </div>
        `;
      });

      view = view + `
        <div id="login-history-item-list" class="login-history-item-list">
          <p>These are your last registered sign-in.</p>
          ` + layout + `
          <button id="LoginHistory-SubmitBtn" class="remove-all cursor-pointer">Remove All</button>
        </div>`;
    } else {
      view = view + `
        <div id="login-history-item-list" class="login-history-item-list">
          <p>No results, No history.</p>
        </div>`;
    }
    return view;
  }

  open(){
    const Ajax = new AjaxRequest(BaseURL);
    const helper = new Helper();

    Ajax.sendRequest([], "get login history")
    .then(responseData => {
      this.records = responseData.Parameters;
      makeModal('Modal', 'Login History', this.getView());

      helper.addElementClickListenerById("LoginHistory-SubmitBtn",()=>{
        Ajax.sendRequest([], "delete all login history")
        .then(responseData => {
          this.open();
        });
      });

      helper.addElementClickListener("#login-history-item-list .remove-btn",(event)=>{
        const data = {
          Device : event.currentTarget.dataset.device,
          IpAddress : event.currentTarget.dataset.ipaddress,
          Location : event.currentTarget.dataset.location,
        };
        Ajax.sendRequest(data, "delete one login history")
          .then(responseData => {
            this.open();
        });
      });

    });
  }
}