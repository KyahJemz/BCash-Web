export function displayOrders(query) {

    document.getElementById("order-list").innerHTML = query;
    document.getElementById("order-list").innerHTML = `
      <div class="item" data-item-id="12">
        <div class="image">
          <img src="../images/school.jpg" alt="">
        </div>
        <div class="details">
          <p class="name-text">Tinapay</p>
          <p class="cost-text">P230</p>
        </div>
        <div class="quantity">
          <button class="addQuantityButton">+</button>
          <p class="quantity-text">1</p>
          <button class="lessQuantityButton">-</button>
        </div>
      </div>
    `;
  }