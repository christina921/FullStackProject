$(document).ready(() => {
  //schroll

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
  reloadItems();
});

function reloadItems() {
  $("#items").empty();
  let str = "<tr>";
  str += "<th>Name</th>";
  str += "<th>Category</th>";
  str += "<th>Quantity</th>";
  str += "<th>Quantity to get</th>";
  str += "<th></th>";
  str += "</tr>";
  document.getElementById("items").innerHTML = str;

  $.ajax({
    type: "GET",
    url: "./getBaseItemsQuantities.php",
    success: function (response) {
      const itemsTable = document.getElementById("items");

      for (item in response) {
        const tableRow = document.createElement("tr");

        const itemID = item;

        const tdName = document.createElement("td"); //td=table data
        tdName.innerText = response[item].name;
        tableRow.appendChild(tdName);

        const tdCategory = document.createElement("td");
        tdCategory.innerText = response[item].category;
        tableRow.appendChild(tdCategory);

        const tdSaviorQuantity = document.createElement("td");
        tdSaviorQuantity.innerText = response[item].quantity;
        tableRow.appendChild(tdSaviorQuantity);

        const tdQuantityToGet = document.createElement("td");
        const inputQuantity = document.createElement("input");
        inputQuantity.type = "number";
        inputQuantity.min = 0;
        inputQuantity.max = response[item].quantity;
        tdQuantityToGet.appendChild(inputQuantity);
        tableRow.appendChild(tdQuantityToGet);

        const tdButton = document.createElement("td");
        const btn = document.createElement("button");
        btn.innerText = "Get Items";
        btn.setAttribute("item-id", itemID); // Set the ID as attribute on the <button> element
        tdButton.appendChild(btn);
        tableRow.appendChild(tdButton);

        itemsTable.appendChild(tableRow);

        // add button functionality
        btn.addEventListener("click", () => {
          // check if input value is valid
          if (inputQuantity.value === undefined || inputQuantity.value === "" || parseInt(inputQuantity.value) === 0 || parseInt(inputQuantity.value) < 0) {
            return;
          }
          const itemId = btn.getAttribute("item-id");
          const quantityToGet = parseInt(inputQuantity.value);
          $.ajax({
            type: "POST",
            url: "./addItemToSaviorStorage.php",
            data: { itemId: itemId, quantityToGet: quantityToGet },
            success: function (response) {
              console.log(response);
              if (response === "quantity_not_available_error") {
                $.alert({
                  title: "Error",
                  content: "Base does not have the quantity you want!",
                  type: "red",
                  draggable: false,
                });
                return;
              }
              if (response !== "done") {
                $.alert({
                  title: "Error",
                  content: "Something went wrong. Please try again",
                  type: "red",
                  draggable: false,
                });
                return;
              }

              $.alert({
                title: "Success",
                content: `The item with id ${itemId} was successfully added`,
                type: "green",
                draggable: false,
              });
              reloadItems();
            },
          });
        });
      }
    },
  });
}
