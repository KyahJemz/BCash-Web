class Order {
    constructor() {
      this.items = [];
      this.cardNumber = '';
    }
  
    addItem(itemId, quantity) {
      this.items.push({itemId, quantity});
    }
  
    removeItem(itemId) {
      const index = this.items.findIndex(item => item.itemId === itemId);
      if (index !== -1) {
        this.items.splice(index, 1);
      }
    }
  
    updateQuantity(itemId, quantity) {
      const item = this.items.find(item => item.itemId === itemId);
      if (item) {
        item.quantity = quantity;
        if (item.quantity <= 0) {
          this.removeItem(itemId);
        }
      }
    }
  
    updateItemId(itemId, newItemId) {
      const item = this.items.find(item => item.itemId === itemId);
      if (item) {
        item.itemId = newItemId;
      }
    }
  
    setCardNumber(cardNumber) {
      this.cardNumber = cardNumber;
    }

    uploadOrder(){
        // send an ajax request to server upload thath card id and items. and wait for its responce if completed or not
    }
  }
  
  export default Order;