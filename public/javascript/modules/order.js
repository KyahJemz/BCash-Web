/* 
#########################################
BCASH WEB - ORDER MODULE
#########################################
*/
import Helper from '../helper.js';

export default class Orders {
  constructor() {
    this.items = [];
    this.walletAddress = '';
  }

  getOrdersArray(){
    return this.items;
  }

  addItem(itemId, name, cost, image, quantity) {
    this.items.push({itemId, name, cost, image, quantity});
    console.log("success", `${itemId} Added`);
  }

  removeItem(itemId) {
    const index = this.items.findIndex(item => item.itemId === itemId);
    if (index !== -1) {
      this.items.splice(index, 1);
    }
    console.log("success", `${itemId} Removed`);
  }

  updateQuantity(itemId, order, type) {
    const item = order.items.find(item => item.itemId === itemId);
    if (item) {
      if (type === "add") {
        item.cost = Number(item.cost)/Number(item.quantity)
        item.quantity = Number(item.quantity) + 1;
        item.cost = Number(item.cost)*Number(item.quantity)
      } else if (type === "less") {
        item.cost = Number(item.cost)/Number(item.quantity)
        item.quantity = Number(item.quantity) - 1;
        item.cost = Number(item.cost)*Number(item.quantity)
        if (item.quantity < 1) {
          this.removeItem(itemId);
        }
      }
    }
  }

  updateItemId(itemId, newItemId) {
    const item = this.items.find(item => item.itemId === itemId);
    if (item) {
      item.itemId = newItemId;
    }
  }

  setCardNumber(walletAddress) {
    this.walletAddress = walletAddress;
  }

  uploadOrder(){
    uploadOrderData(this.walletAddress, this.items);
  }

  toggleItemButton(button) {
    if (button.dataset.type == "AddToCart") { // CHANGE TO ADD TO CART BUTTON
      button.innerHTML = '<p>Remove</p>';
      button.dataset.type = 'RemoveToCart';
    } else if (button.dataset.type == "RemoveToCart"){ // CHANGE TO REMOVE TO CART BUTTON
      button.innerHTML = '<p>Add</p>';
      button.dataset.type = 'AddToCart';
    }
  }

  toggleQuantityButton(itemId, order) {
    const item = order.items.find(item => item.itemId === itemId); // CHECKING IF EXISITNG
    if (!item) {
      let itemContainer = document.querySelectorAll('.item-container');
      itemContainer.forEach(item => {
        let itemIdx = item.dataset.itemId;
        if (itemIdx === itemId) { 
          let addToCartButtons = item.querySelectorAll('.item-button .addToCartButton');
          addToCartButtons.forEach(button => {
            this.toggleItemButton(button);
          });
        }
      });
    }
  }

  refreshReceiptValues(order) {
    let quantiy = 0;
    let subtotal = 0;
    let discount = document.getElementById("txt-order-Discount").value;

    order.items.forEach(item => {
      quantiy = Number(quantiy) + Number(item.quantity);
      subtotal = Number(subtotal) + Number(item.cost);
    })

    document.getElementById("order-quantity").innerHTML = "Quantity: "+quantiy;
    document.getElementById("order-subtotal").innerHTML = "Subtotal: ₱"+Number(subtotal).toFixed(2);
    document.getElementById("order-total").innerHTML = "Total: ₱"+(Number(subtotal).toFixed(2)-Number(discount).toFixed(2));
  }

  displayOrders(order) {
    document.getElementById("order-list").innerHTML = '';
  
    if (order.items.length === 0) { // IF ORDERS ITEMS ARE EMPTY
      document.getElementById("order-list").innerHTML = `<div class="emptyBlock">No items selected</div>`;
    } else  {
      order.items.forEach(item => {  // IF ORDERS ITEMS HAVE VALUES 
        document.getElementById("order-list").innerHTML = document.getElementById("order-list").innerHTML + `
          <div class="item" data-item-id="`+ item.itemId +`" data-cost="`+ item.cost +`"  data-name=`+ item.name +` data-image="`+ item.image +`">
            <div class="image">
              <img src="../public/images/items/`+ item.image +`" alt="">
            </div>
            <div class="details">
              <p class="name-text">`+ item.name +`</p>
              <p class="cost-text">₱`+ Number(item.cost).toFixed(2) +`</p>
            </div>
            <div class="quantity">
              <button data-type="less" class="quantityButton">-</button>
              <p class="quantity-text">`+ item.quantity +`</p>
              <button data-type="add" class="quantityButton">+</button>
            </div>
        </div>
      `});
    }

   const helper = new Helper();
   helper.addElementClickListener('.quantityButton',(event) => this.changeQuantity(event, order));
  }

  // EVENT LISTENER

  addToCart(event, order) {
    const button = event.currentTarget;
    const itemId = button.parentNode.parentNode.dataset.itemId;
    const name = button.parentNode.parentNode.dataset.name;
    const cost = button.parentNode.parentNode.dataset.cost;
    const image = button.parentNode.parentNode.dataset.image;
    const quantity = "1";

    if (button.dataset.type == "AddToCart") {
      this.addItem(itemId, name, cost, image, quantity);
    } 
    if (button.dataset.type == "RemoveToCart") {
      this.removeItem(itemId);
    }
    this.toggleItemButton(button);
    this.displayOrders(order);
    this.refreshReceiptValues(order);
  }

  changeQuantity(event, order) {
    const button = event.currentTarget;
    const itemId = button.parentNode.parentNode.dataset.itemId;
    const type = button.dataset.type;

    this.updateQuantity(itemId, order, type)
    this.displayOrders(order);
    this.toggleQuantityButton(itemId, order)
    this.refreshReceiptValues(order);
  }

  clearOrder(order) {
    document.querySelectorAll(".addToCartButton").forEach(button => {
      if(button.dataset.type === "RemoveToCart") {
        this.removeItem(button.parentNode.parentNode.dataset.itemId);
        this.toggleItemButton(button);
        this.displayOrders(order);
        this.refreshReceiptValues(order);
      }
    })
  }

  placeOrderEvents(order) {
    if (order.items.length > 0) {
        this.uploadOrderData();
    } else {
        openAlertDialogBoxEvents("Invalid Request","Try adding some improvemnts");
    }
  }

}



















