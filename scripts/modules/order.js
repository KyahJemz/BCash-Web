import {bindQuantityEventButtons} from '../main.js';

export function displayOrders(order) {
  document.getElementById("order-list").innerHTML = '';

  order.items.forEach(item => {
    document.getElementById("order-list").innerHTML = document.getElementById("order-list").innerHTML + `
      <div class="item" data-item-id="`+ item.itemId +`" data-cost="`+ item.cost +`"  data-name=`+ item.name +` data-image="`+ item.image +`">
        <div class="image">
          <img src="`+ item.image +`" alt="">
        </div>
        <div class="details">
          <p class="name-text">`+ item.name +`</p>
          <p class="cost-text">P`+ item.cost +`</p>
        </div>
        <div class="quantity">
          <button data-type="less" class="quantityButton">-</button>
          <p class="quantity-text">`+ item.quantity +`</p>
          <button data-type="add" class="quantityButton">+</button>
        </div>
    </div>
  `});

  if (order.items.length === 0) {
    document.getElementById("order-list").innerHTML = `<div class="emptyBlock">No items selected</div>`;
  }

  bindQuantityEventButtons();
}

  export function toggleItemButton(button) {
    if (button.dataset.type == "AddToCart") {
      button.innerHTML = '<p>Remove</p>';
      button.dataset.type = 'RemoveToCart';
      console.log("RemoveToCart");
    } else if (button.dataset.type == "RemoveToCart"){
      console.log("AddToCart");
      button.innerHTML = '<p>Add</p>';
      button.dataset.type = 'AddToCart';
    }
    console.log("Fired");
  }

  export function toggleQuantityButton(button, order, itemId) {
    order.items.forEach(item => {
      if (item.itemId === itemId) {
        button.parentNode.querySelector('.quantity-text').innerHTML = item.quantity;
        button.parentNode.parentNode.querySelector('.cost-text').innerHTML = "p"+item.cost;
      }
    });

    const item = order.items.find(item => item.itemId === itemId);
    if (!item) {
      let itemContainer = document.querySelectorAll('.item-container');
      itemContainer.forEach(item => {
        let itemIdx = item.dataset.itemId;
        if (itemIdx === itemId) {
          let addToCartButtons = item.querySelectorAll('.item-button .addToCartButton');
          addToCartButtons.forEach(button => {
            toggleItemButton(button);
          });
        }
      });
    }

    
  }

  export function refreshReceiptValues(order) {
    let quantiy = 0;
    let subtotal = 0;
    let discount = document.getElementById("txt-order-Discount").value;

    order.items.forEach(item => {
      quantiy = Number(quantiy) + Number(item.quantity);
      subtotal = Number(subtotal) + Number(item.cost);
    })

    document.getElementById("order-quantity").innerHTML = "Quantity: "+quantiy;
    document.getElementById("order-subtotal").innerHTML = "Subtotal: ₱"+subtotal;
    document.getElementById("order-total").innerHTML = "Total: ₱"+(Number(subtotal)-Number(discount));

  }
