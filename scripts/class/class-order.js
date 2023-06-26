import { 
  uploadOrderData 
} from '../ajaxUtils.js';

export default class Order {
  constructor() {
    this.items = [];
    this.walletAddress = '';
  }

  addItem(itemId, quantity) {
    this.items.push({itemId, quantity});
    console.log(itemId);
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

  setCardNumber(walletAddress) {
    this.walletAddress = walletAddress;
  }

  uploadOrder(){
    uploadOrderData(this.walletAddress, this.items);
    console.log("Uploading");
  }
}