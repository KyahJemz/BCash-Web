import { 
  uploadOrderData 
} from '../ajaxUtils.js';

export default class Order {
  constructor() {
    this.items = [];
    this.walletAddress = '';
  }

  addItem(itemId, name, cost, image, quantity) {
    this.items.push({itemId, name, cost, image, quantity});
    console.log(itemId+" Added");
  }

  removeItem(itemId) {
    const index = this.items.findIndex(item => item.itemId === itemId);
    if (index !== -1) {
      this.items.splice(index, 1);
    }
    console.log(itemId+" Removed");
  }

  updateQuantity(itemId, type) {
    const item = this.items.find(item => item.itemId === itemId);
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
    console.log("Uploading");
  }
}