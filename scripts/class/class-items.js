import { uploadOrderData } from '../ajaxUtils.js';

class Item {
  constructor(id, name, cost, dateModified, dateCreated, image) {
    this.id = id;
    this.image = image;
    this.name = name;
    this.cost = cost;
    this.dateModified = dateModified;
    this.dateCreated = dateCreated;
  }

  updateItem(name, cost, image) {
    this.name = name;
    this.cost = cost;
    if (image !== null) {
      uploadImage(this.id, image);
    }
    uploadData(this);
  }

  deleteItem() {
    // send a delete request with this.id to delete the item
  }
}

function uploadImage(itemId, image) {
  // send an AJAX request to upload the image for the specified itemId
}

function uploadData(item) {
  const url = 'your-api-endpoint'; // Replace with your actual API endpoint
  const cardNumber = '1234567890'; // Example card number, replace with actual card number or retrieve it from user input
  const items = [item]; // Convert the item to an array or modify the uploadOrderData function to accept a single item

  uploadOrderData(url, cardNumber, items)
    .then(response => {
      // Handle successful response
    })
    .catch(error => {
      // Handle error
    });
}

export default Item;