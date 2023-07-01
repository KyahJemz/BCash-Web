import {
  deleteItemData, 
  updateItemImage, 
  UpdateItemData, 
  addItemData, 
  searchItemData, 
  filterItemData
} from '../ajaxUtils.js';

export default class Item {
  constructor(itemId, name, cost, category, dateModified, dateCreated, image) {
    this.itemId = itemId;
    this.image = image;
    this.name = name;
    this.cost = cost;
    this.category = category;
    this.dateModified = dateModified;
    this.dateCreated = dateCreated;
  }

  deleteItem() {
    deleteItemData(this.id)
  }

  updateItem(name, cost, image) {
    this.name = name;
    this.cost = cost;
    if (image !== null) {
      updateItemImage(this.id, image);
    }
    UpdateItemData(this);
  }

  static addItem(name, cost, image) {
    addItemData(name, cost, image);
  }

  static searchItem(query) {
    searchItemData(query);
  }

  static filterItem(query) {
    filterItemData(query);
  }

  static layoutItem(query) {
    layoutItemData(query);
  }
}