import {
  deleteItemData, 
  updateItemImage, 
  UpdateItemData, 
  addItemData, 
  searchItemData, 
  filterItemData, 
  layoutItemData 
} from '../ajaxUtils.js';

export default class Item {
  constructor(id, name, cost, dateModified, dateCreated, image) {
    this.id = id;
    this.image = image;
    this.name = name;
    this.cost = cost;
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