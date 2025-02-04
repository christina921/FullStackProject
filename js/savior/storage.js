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

  document.getElementById("transfer-all-items-to-base-btn").addEventListener("click", () => {
    $.ajax({
      type: "POST",
      url: "./addAllItemsToBase.php",
      success: function (response) {
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
          content: "All items were successfully transferred to base",
          type: "green",
          draggable: false,
        });
        reloadItems();
      },
    });
  });
});

function reloadItems() {
  $("#items").empty();
  let str = "<tr>";
  str += "<th>Name</th>";
  str += "<th>Category</th>";
  str += "<th>Savior Storage</th>";
  str += "</tr>";
  document.getElementById("items").innerHTML = str;

  $.ajax({
    type: "GET",
    url: "./getItemsQuantities.php",
    success: function (response) {
      const itemsTable = document.getElementById("items");

      for (item in response) {
        if (response[item].savior_quantity == 0) continue;

        const tableRow = document.createElement("tr");

        const itemID = response[item].id; // { 16: {name: "a name", ..., id: "16"}, 17: {name: "a name 2", ..., id: "17" }
        // Set the ID attribute for the <tr> element

        const tdName = document.createElement("td"); //td=table data
        tdName.innerText = response[item].name;
        tableRow.appendChild(tdName);

        const tdCategory = document.createElement("td");
        tdCategory.innerText = response[item].category;
        tableRow.appendChild(tdCategory);

        const tdSaviorQuantity = document.createElement("td");
        tdSaviorQuantity.innerText = response[item].savior_quantity;
        tableRow.appendChild(tdSaviorQuantity);

        itemsTable.appendChild(tableRow);
      }
    },
  });
}
