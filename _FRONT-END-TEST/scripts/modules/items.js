/* 
#########################################
BCASH WEB - ITEMS MODULE
Event Handler for Items
#########################################
*/

import Helper from '../helper.js';

export default class Item {
    constructor() {
        this.items = [];
    }

    registerItem(itemId, name, cost, category, dateModified, dateCreated, image) {
        const newItem = {
            itemId,
            name,
            cost,
            category,
            dateModified,
            dateCreated,
            image
        };
        this.items.push(newItem);
    }
  /*
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
  
    addItem(name, cost, image) {
      addItemData(name, cost, image);
    }
*/
    getItemsArray(){
        return this.items;
    }

    //sdsad
    getFilteredItems (temp,items,filter,search) {
        if(filter.length <= 0){
            items.items.forEach(item => {
                if(item.name.toUpperCase().includes(search)) {
                    temp.push(item);
                }
            })
        } else { 
            filter.forEach(element => {
                items.items.forEach(item => {
                    if(item.category == element.dataset.category && item.name.toUpperCase().includes(search)) {
                        temp.push(item);
                    }
                })
            });
        }
        return temp;
    }
    
    // USED FOR SORTING
    getSortedItems (temp,sort) {
        if (sort == "Ascending") {
            temp.sort((a, b) => {
                const nameA = a.name.toUpperCase();
                const nameB = b.name.toUpperCase();
              
                if (nameA < nameB) {
                  return -1;
                } else if (nameA > nameB) {
                  return 1;
                } else {
                  return 0;
                }
              });
        } else if (sort == "Descending") {
            temp.sort((a, b) => {
                if (a.name < b.name) {
                  return 1;
                } else if (a.name > b.name) {
                  return -1;
                } else {
                  return 0;
                }
              });
        }
        return temp;
    }
    
    // USED FOR LAYOUT
    getLayoutTag (layout, container) {
        const className = container.firstElementChild.className;
    
        if(layout == "List") {
            container.firstElementChild.classList.remove(className);
            container.firstElementChild.classList.add("list-layout");
            return ".list-layout";
        } else if (layout == "Details") {
            container.firstElementChild.classList.remove(className);
            container.firstElementChild.classList.add("detail-layout");
            return ".detail-layout";
        } else if (layout == "Tiles") {
            container.firstElementChild.classList.remove(className);
            container.firstElementChild.classList.add("tile-layout");
            return ".tile-layout";
        }
    }
    
    // USED FOR UPDATING FILTER DROPDOWN SUBITEM
    updateCategoryItems(categoryContainer,items, order, filter){
        let categoryActiveItems = [];
        if(filter.length > 0){
            filter.forEach(element => {
                categoryActiveItems.push(element.dataset.category);
            });
        }
    
        categoryContainer.innerHTML = ``;
    
        const uniqueCategories = new Set();
        items.items.forEach(item => uniqueCategories.add(item.category));
        Array.from(uniqueCategories).forEach(item => { 
            if (categoryActiveItems.includes(item)) {
                categoryContainer.innerHTML = categoryContainer.innerHTML + 
                `<button class="category-item curson-pointer category-item-selected" data-category="`+ item +`"><p>`+ item +`</p></button>`;
            } else {
                categoryContainer.innerHTML = categoryContainer.innerHTML + 
                `<button class="category-item curson-pointer" data-category="`+ item +`"><p>`+ item +`</p></button>`;
            }
        });
    
       // bindCategoryItems();

        const helper = new Helper();
        helper.addElementClickListener('.category-item',(event) => this.categorySelected(event, items, order));
    }
    
    // USED FOR DISPLAYING ITEMS
    displayItems(items, order, type) {
        let temp = [];
    
        if (type == "CreateOrder") {
            const filter = document.getElementById('createorder-category').querySelectorAll('.category-item-selected');
            const sort = document.getElementById('createorder-sort-dropdown').innerHTML;
            const layout =document.getElementById('createorder-layout-dropdown').innerHTML;
            const search = document.getElementById("createorder-search").value.toUpperCase();
            const container = document.querySelector(".order-items-container");
            let layoutTag ="";
            let button = ``;
    
            temp = this.getFilteredItems(temp,items,filter,search); // FILTER ITEMS FISRT
    
            temp = this.getSortedItems(temp,sort); // SORT ITEMS SECOND
    
            layoutTag = this.getLayoutTag(layout,container); // GET LAYOUT
    
            container.querySelector(layoutTag).innerHTML = ''; // CLEAR DISPLAY
    
            temp.forEach(item => {
                const existing = order.items.find(itemx => itemx.itemId === item.itemId); // USED TO CHANGE BUTTONS FOR ALL ADDED TO CART ITEMS
                if (existing) {
                    button = `
                    <div class="item-button">
                        <button data-type="RemoveToCart" title="Remove To Cart" class="addToCartButton curson-pointer"><p>Remove</p></button>
                    </div>
                `;
                } else {
                    button = `
                    <div class="item-button">
                        <button data-type="AddToCart" title="Add To Cart" class="addToCartButton curson-pointer"><p>Add</p></button>
                    </div>
                `;
                }
    
                // USED TO DISPLAY ITEMS IN LAYOUT SELECTED
                container.querySelector(layoutTag).innerHTML = container.querySelector(layoutTag).innerHTML + `
                <div class="item-container" data-item-id="`+ item.itemId +`" data-name="`+ item.name +`" data-cost="`+ item.cost +`"  data-image="`+ item.image +`">
                    <div class="item-image">
                        <img src="`+ item.image +`">
                    </div>
                    <div class="item-details-container">
                        <div class="info-container">
                            <div class="info">
                                <p class="title"><b>`+ item.name +`</b></p>
                            </div>
                            <div class="info">
                                <p class="cost">Cost : ₱<b>`+ Number(item.cost).toFixed(2) +`</b></p>
                            </div>
                        </div>
                    </div>
                    `+ button +`
                </div>
              `;
            });
    
            // UPDATETING FILTER DROPDON SUBITEMS
            this.updateCategoryItems(document.getElementById("createorder-category"),items, order, filter);
    
            // USED TO DIPLAY SEARCH RESULT OF EMPTY
            if (temp.length === 0) {
                if (items.length > 0) {
                    container.querySelector(layoutTag).innerHTML = `<div class="emptyBlock">No Results`;
                } else {
                    container.querySelector(layoutTag).innerHTML = `<div class="emptyBlock">There are currently no items registered`;
                }
            }
            
        } else if (type == "ItemManagement"){
            const filter = document.getElementById('itemmanagement-category').querySelectorAll('.category-item-selected');
            const sort = document.getElementById('itemmanagement-sort-dropdown').innerHTML;
            const layout =document.getElementById('itemmanagement-layout-dropdown').innerHTML;
            const search = document.getElementById("itemmanagement-search").value.toUpperCase();
            const container = document.querySelector(".panel-itemmanagement-content");
            let layoutTag ="";
    
            temp = this.getFilteredItems(temp,items,filter,search); // FILTER ITEMS FISRT
    
            temp = this.getSortedItems(temp,sort); // SORT ITEMS SECOND
    
            layoutTag = this.getLayoutTag(layout,container); // GET LAYOUT
    
            container.querySelector(layoutTag).innerHTML = ''; // CLEAR DISPLAY

            temp.forEach(item => {
    
                container.querySelector(layoutTag).innerHTML = container.querySelector(layoutTag).innerHTML + `
                    <div class="item-container" data-item-id="`+ item.itemId +`" data-name="`+ item.name +`" data-cost="`+ item.cost +`"  data-image="`+ item.image +`">
                        <div class="item-image">
                            <img src="`+ item.image +`" alt="item-image">
                        </div>
                        <div class="item-details-container">
                            <div class="info-container">
                                <div class="info info-title">
                                    <p class="title"><b>`+ item.name +`</b></p>
                                </div>
                                <div class="info info-cost">
                                    <p class="cost">Cost: ₱ <b>`+ item.cost +`</b></p>
                                </div>
                                <div class="info info-created">
                                    <p class="created">Date Created: <b>`+ item.dateCreated +`</b></p>
                                </div>
                                <div class="info info-modified">
                                    <p class="modified">Date Modified: <b>`+ item.dateModified +`</b></p>
                                </div>
                            </div>
                        </div>
                        <div class="item-options">
                            <button title="Edit" class="editItemButton curson-pointer"><img src="../images/icons/edit-yellow.png" alt=""></button>
                            <button title="Delete" class="deleteItemButton curson-pointer"><img src="../images/icons/delete-red.png" alt=""></button>
                        </div>
                    </div>
                `;
            });
    
            // UPDATETING FILTER DROPDON SUBITEMS
            this.updateCategoryItems(document.getElementById("itemmanagement-category"),items, order, filter);
    
            // USED TO DIPLAY SEARCH RESULT OF EMPTY
            if (temp.length === 0) {
                if (items.length > 0) {
                    container.querySelector(layoutTag).innerHTML = `<div class="emptyBlock">No Results`;
                } else {
                    container.querySelector(layoutTag).innerHTML = `<div class="emptyBlock">There are currently no items registered`;
                }
            }
        }

        const helper = new Helper();
        helper.addElementClickListener('.addToCartButton',(event) => order.addToCart(event, order));
       // helper.addElementClickListener('.editItemButton',(event) => categorySelected(event));
       // helper.addElementClickListener('.deleteItemButton',(event) => categorySelected(event));
       // helper.addElementClickListener('.addItemButton',(event) => categorySelected(event));
    }

    categorySelected(event, items, order) {
        const value = event.currentTarget;
        value.classList.toggle("category-item-selected");
        this.displayItems(items, order, value.parentNode.dataset.type);
    }

  }
