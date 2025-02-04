$(document).ready(() => {
  //scroll

  // Get the button
  var scrollTopButton = document.getElementById("scrollTopBtn");

  // When the user scrolls down 10px from the top of the document, show the button
  window.onscroll = function () {
    if (document.body.scrollTop > 10 || document.documentElement.scrollTop > 10) {
      scrollTopButton.style.display = "block";
    } else {
      scrollTopButton.style.display = "none";
    }
  };

  // When the user clicks on the button, scroll to the top of the document
  scrollTopButton.onclick = function () {
    document.documentElement.scrollTop = 0;
  };

  ///

  const logoutBtnElement = document.getElementById("logoutBtn");
  logoutBtnElement.addEventListener("click", logout);
  //items page
  $.ajax({
    type: "GET",
    url: "./getItemsQuantities.php",
    success: function (response) {
      const itemsTable = document.getElementById("items");

      for (item in response) {
        const tableRow = document.createElement("tr");

        const itemID = response[item].id;
        
         // { 16: {name: "a name", ..., id: "16"}, 17: {name: "a name 2", ..., id: "17" }
        // Set the ID attribute for the <tr> element
        tableRow.setAttribute("data-id", itemID);

        tableRow.addEventListener("click", () => {
          console.log("Row clicked:", itemID);
          $.ajax({
            type: "GET",
            url: "./getDetailsOfItems.php",
            data: { id: itemID }, //στειλε αυτο στην php 
            success: function (response) {
              // Clear existing rows from the detailsTable
              const detailsTable = document.getElementById("details");
              while (detailsTable.children.length > 1) {
                //only 1 child remains ,because it is length so 1 2 3 etc ,dld to th menei mono 
                //se kathe click katharizei olo to td kai tr
                detailsTable.removeChild(detailsTable.lastChild);
              }
              if (response != 0) {
                // The item has details
                for (let detItem in response) {
               
                  const tableRow2 = document.createElement("tr"); //tr = table row

                  const tdName2 = document.createElement("td"); //td= table data=κελί πίνακα
                  tdName2.innerText = response[detItem].name;
                  tableRow2.appendChild(tdName2); //προσθεσε το κελι στην γραμμη του πινακα

                  const tdValue = document.createElement("td");
                  tdValue.innerText = response[detItem].value;
                  tableRow2.appendChild(tdValue);

                  // Append the row to the table
                  detailsTable.appendChild(tableRow2); //προσθεσε την ολοκληρωμενη γραμμη στον πίνακα
                }
              }
            },
          });
        });

        const tdName = document.createElement("td"); //td=table data = κελί πίνακα
        tdName.innerText = response[item].name;
        tableRow.appendChild(tdName);

        const tdCategory = document.createElement("td");
        tdCategory.innerText = response[item].category;
        tableRow.appendChild(tdCategory);

        const tdBaseQuantity = document.createElement("td");
        tdBaseQuantity.innerText = response[item].base_quantity;
        tableRow.appendChild(tdBaseQuantity);

        const tdSaviorQuantity = document.createElement("td");
        tdSaviorQuantity.innerText = response[item].savior_quantity;
        tableRow.appendChild(tdSaviorQuantity);

        itemsTable.appendChild(tableRow);
      }
    },
  });

  const itemsBtn = document.getElementById("insert-items-btn");

  itemsBtn.addEventListener("click", () => {
    //json insert
    let items = [];
    // τελικο array οταν τελειωσει η επεξεργασια:
    //[
    //    { "item_id": 16, "item_name": "Water", "item_category": "Beverages", "item_quantity": 30 }
    //    { "item_id": 17, "item_name": "Orange juice", "item_category": "Beverages" }
    // ]

    const file = document.getElementById("items-file-input").files[0]; //accessing [0] fetches the first file in this list. necesecery
    if (!file) return; //cause that 's how file property works
   // PROSOXH mesa apo to json insert den allazoyn details 
    var reader = new FileReader();
    reader.readAsText(file, "UTF-8");
    reader.onload = (event) => {
      //when reader finishes
      // check if the file is in JSON format
      try {
        data = JSON.parse(event.target.result); //koita an exei json morfh
      } catch (jsonException) {  //an den exei to pianei to edw
        $.alert({
          title: "Error",
          content: "This file is not in JSON format",
          type: "red",
          draggable: false,
        });
        return;
      }

      let categories = data["categories"]; //initialize array

      for (itemIndex in data["items"]) { //gia kathe antikeimeno sto items 
        // find the category of the item
        itemCategory = null;
        for (cat in categories) {
          if (categories[cat].id == data["items"][itemIndex].category) {
            itemCategory = categories[cat]; 
            //τιθεται ολο το ,πχ { "id": "6", "category_name": "Beverages" },
          }
        }

        // επιστρέφει πχ itemCategory: Object { id: "6", category_name: "Beverages" }  dld einai object h apanthsh
        // console.log("itemCategory:", itemCategory);
        if ("quantity" in data["items"][itemIndex]) {
          //for item objects(itemIndex) ,itemIndex is the key to accesing =0,1...,quantity is the key
          items.push({ //bale ena antikeimeno kathw exei {}
            //create a new object
            item_id: data["items"][itemIndex].id, //data["items"] refers to array of objects,each obj one item
            item_name: data["items"][itemIndex].name,
            item_category: itemCategory.category_name, //The item_category is set using the name of the category found earlier,
            item_quantity: data["items"][itemIndex].quantity,
            // τωρα το 1ο αντικειμενο θα εμφανιζεται ετσι:
            // { "item_id": 16, "item_name": "Water", "item_category": "Beverages", "item_quantity": 
            // 30 }
          });
        } else {
          items.push({ //bale ena antikeimeno kathw exei {}
            item_id: data["items"][itemIndex].id,
            item_name: data["items"][itemIndex].name,
            item_category: itemCategory.category_name,
          });
        }
      }
      console.log(items); // items right now is an array with objects : array(3)[{...},{...},{...}]
      $.ajax({
        //για json insert του admin
        type: "POST",
        url: "./updateInsertItems.php",
        data: { items: items },
        success: function (response) {
          if (response != "DONE") {
            $.alert({
              title: "Alert",
              content: "Files could not be inserted/updated. Please try again later",
              type: "red",
              draggable: false,
            });
            return;
          }

          $.alert({
            title: "Success",
            content: "Files inserted/updated successfully",
            type: "green",
            draggable: false,
          });
        },
      });
    };
  });
});
