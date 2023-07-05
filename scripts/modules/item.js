/* 
#########################################
BCASH WEB - ITEMS MODULE
Event Handler for Items
#########################################
*/

import {
    bindItemsEventButtons,
    bindDropdownSubItemEventButtons
} from '../main.js';

// USED FOR FILTERS
function getFilteredItems (temp,items,filter,search) {
    if(filter == "All"){
        items.forEach(item => {
            if(item.name.toUpperCase().includes(search)) {
                temp.push(item);
            }
        })
    } else { 
        items.forEach(item => {
            if(item.category == filter && item.name.toUpperCase().includes(search)) {
                temp.push(item);
            }
        })
    }
    return temp;
}

// USED FOR SORTING
function getSortedItems (temp,sort) {
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
function getLayoutTag (layout, container) {
    if(layout == "Card") {
        if (container.querySelector(".list-layout")) {
            container.querySelector(".list-layout").classList.add("card-layout");
            container.querySelector(".list-layout").classList.remove("list-layout");
        }
        return ".card-layout";
    } else if (layout == "List") {
        if (container.querySelector(".card-layout")) {
            container.querySelector(".card-layout").classList.add("list-layout");
            container.querySelector(".card-layout").classList.remove("card-layout");
        }
        return ".list-layout";
    }
}

// USED FOR UPDATING FILTER DROPDOWN SUBITEMS
function updateFilterCategoryDropdown(dropdown,items, elemetId){
    dropdown.innerHTML = 
    `<a class="dropdownButtonSubItem dropdown-selected" href="javascript:void(0)">All</a>`;

    const uniqueCategories = new Set();
    items.forEach(item => uniqueCategories.add(item.category));
    Array.from(uniqueCategories).forEach(item => { 
        dropdown.innerHTML = dropdown.innerHTML + 
        `<a class="dropdownButtonSubItem" href="javascript:void(0)">`+ item +`</a>`;
    });

    bindDropdownSubItemEventButtons(elemetId);
}

// USED FOR DISPLAYING ITEMS
export function displayItems(items, order, type) {
    let temp = [];

    if (type == "CreateOrder") {
        console.log("REFRESHING cREATE ORDER ITEMS");
        const filter = document.getElementById('createorder-filter-dropdown').innerHTML;
        const sort = document.getElementById('createorder-sort-dropdown').innerHTML;
        const layout =document.getElementById('createorder-layout-dropdown').innerHTML;
        const search = document.getElementById("createorder-search").value.toUpperCase();
        const container = document.querySelector(".order-items-container");
        let layoutTag ="";
        let button = ``;

        temp = getFilteredItems(temp,items,filter,search); // FILTER ITEMS FISRT

        temp = getSortedItems(temp,sort); // SORT ITEMS SECOND

        layoutTag = getLayoutTag(layout,container); // GET LAYOUT

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
        updateFilterCategoryDropdown(document.getElementById("createorder-category-choices"),items,"createorder-category-choices");

        // USED TO DIPLAY SEARCH RESULT OF EMPTY
        if (temp.length === 0) {
            if (items.length > 0) {
                container.querySelector(layoutTag).innerHTML = `<div class="emptyBlock">No Results`;
            } else {
                container.querySelector(layoutTag).innerHTML = `<div class="emptyBlock">There are currently no items registered`;
            }
        }
        
    } else if (type == "ItemManagement"){
        console.log("REFRESHING ITEMMANAGEMETN ITEMS");
        const filter = document.getElementById('itemmanagement-filter-dropdown').innerHTML;
        const sort = document.getElementById('itemmanagement-sort-dropdown').innerHTML;
        const layout =document.getElementById('itemmanagement-layout-dropdown').innerHTML;
        const search = document.getElementById("itemmanagement-search").value.toUpperCase();
        const container = document.querySelector(".panel-itemmanagement-content");
        let layoutTag ="";

        temp = getFilteredItems(temp,items,filter,search);

        temp = getSortedItems(temp,sort);

        layoutTag = getLayoutTag(layout,container);

        container.querySelector(layoutTag).innerHTML = '';
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
                        <button title="Edit" class="curson-pointer"><img src="../images/icons/edit-yellow.png" alt=""></button>
                        <button title="Delete" class="curson-pointer"><img src="../images/icons/delete-red.png" alt=""></button>
                    </div>
                </div>
            `;
        });

        // UPDATETING FILTER DROPDON SUBITEMS
        updateFilterCategoryDropdown(document.getElementById("itemmanagement-category-choices"),items,"itemmanagement-category-choices");

        // USED TO DIPLAY SEARCH RESULT OF EMPTY
        if (temp.length === 0) {
            if (items.length > 0) {
                container.querySelector(layoutTag).innerHTML = `<div class="emptyBlock">No Results`;
            } else {
                container.querySelector(layoutTag).innerHTML = `<div class="emptyBlock">There are currently no items registered`;
            }
        }
    }
 
  bindItemsEventButtons();
}