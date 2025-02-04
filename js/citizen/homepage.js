var itemNames = [];

$(document).ready(() => {
  const logoutBtnElement = document.getElementById("logoutBtn");
  logoutBtnElement.addEventListener("click", logout);

  // setup autocomplete
  $.ajax({
    type: "GET",
    url: "./getItemNames.php",
    success: function (response) {
      for (id in response) {
        itemNames.push(response[id]);
      }

      $("#item-choice").autocomplete({
        source: itemNames,
      });
    },
  });

  // setup requests and offers history
  resetRequestsHistory();
  resetOffersHistory();

  // setup announcements Information
  $.ajax({
    type: "GET",
    url: "./getAnnouncementsInfo.php",
    success: function (response) {
      const announcementsDivElement = document.getElementById("announcements");

      for (data in response) {
        const announcementDiv = document.createElement("div"); // <div></div>
        announcementDiv.classList.add("announcement"); // <div class="announcement"></div>

        const titleH2 = document.createElement("h2");
        titleH2.innerText = "Announcement " + data;
        announcementDiv.appendChild(titleH2);

        const dateP = document.createElement("p");
        dateP.innerText = "Created Date: " + response[data]["created_date"];
        announcementDiv.appendChild(dateP);

        const itemsP = document.createElement("p");
        itemsP.innerText = "Items:";
        announcementDiv.appendChild(itemsP);

        for (item in response[data]["items"]) {
          const itemOuterDiv = document.createElement("div"); // <div></div>

          const itemNameP = document.createElement("p"); // <p></p>
          itemNameP.innerText = response[data]["items"][item]["item_name"]; // <p>ITEM NAME</p>
          itemOuterDiv.appendChild(itemNameP); // <div> <p>ITEM NAME</p> </div>
          
          const horizontalDiv = createAnnouncementButton(item);
          itemOuterDiv.appendChild(horizontalDiv);

          announcementDiv.appendChild(itemOuterDiv);
        }

        announcementsDivElement.appendChild(announcementDiv);
      }
    },
  });

  // functionality of submitting a request
  const submitRequestButton = document.getElementById("submit-request");
  submitRequestButton.addEventListener("click", () => {
    const itemChoiceElement = document.getElementById("item-choice");
    const quantityElement = document.getElementById("quantity");
    if (itemChoiceElement.value == "") return;

    if (quantityElement.value == "") return;

    $.ajax({
      type: "POST",
      url: "./createRequest.php",
      data: { item_name: itemChoiceElement.value, people_num: quantityElement.value },
      success: function (response) {
        const errorRequestElement = document.getElementById("error-request");
        if (response != "done") {
          errorRequestElement.style.color = "red";
          errorRequestElement.innerText = "There was an error. Please try again later!";
          console.log(response);
          return;
        }
        errorRequestElement.style.color = "green";
        errorRequestElement.innerText = "Your request was successful";
        resetRequestsHistory();
      },
    });
  });
});

// generating a div with class = horizontal for Announcements
function createAnnouncementButton(id) {
  const outerDiv = document.createElement("div");
  outerDiv.classList.add("horizontal");

  // Create input field
  const inputElement = document.createElement("input");
  inputElement.type = "number";
  inputElement.placeholder = "Choose Quantity";
  outerDiv.appendChild(inputElement);

  // Create button
  const buttonElement = document.createElement("button");
  buttonElement.innerText = "Create Offer";
  buttonElement.setAttribute("data-id", id);
  outerDiv.appendChild(buttonElement);

  

  // Add event listener for the button to trigger AJAX POST
  $(buttonElement).click(function() {
    // Get the data-id attribute and the input field's value
    const itemId = buttonElement.getAttribute("data-id");
    const quantity = inputElement.value; // Get user input
    console.log("Retrieved itemId:", itemId);
    console.log("itemId:", itemId, "quantity:", quantity);
    $.ajax({
      type:"POST",
      url: "./postOffer.php", // Your endpoint
      data: { 
        itemId: itemId, 
        quantity: quantity  // Send input data
      },
      success: function(response) {
        generalMessageElement = document.getElementById("general-message");
        if(response != "done") {
          generalMessageElement.style.color = 'red';
          generalMessageElement.innerText = "There was a problem with your offer. Please try again later";
          return;
        }

        generalMessageElement.style.color = 'green';
        generalMessageElement.innerText = "Your offer was successfully created";
        resetOffersHistory();
      },
      
    });
  });

  return outerDiv;
}

// requests history functionality
function resetRequestsHistory() {
  const requestsElement = document.getElementById("requests");

  while (requestsElement.lastChild) {
    requestsElement.removeChild(requestsElement.lastChild);
  }

  const requestsTitle = document.createElement("h1");
  requestsTitle.innerText = "Requests History";
  requestsElement.appendChild(requestsTitle);

  $.ajax({
    type: "GET",
    url: "./getRequestInfo.php",
    success: function (response) {
      for (data in response) {
        const requestDiv = document.createElement("div"); // <div></div>
        requestDiv.classList.add("request"); // <div class="request"></div>

        const titleH2 = document.createElement("p"); // <h2></h2>
        titleH2.innerText = response[data].item_name; // <h2> response[data].item_name </h2>

        const dateP = document.createElement("p"); // <p></p>
        dateP.innerText = "Created Date: " + response[data].created_date; // <p> response[data].created_date </p>

        const nuOfPeople = document.createElement("p");
        nuOfPeople.innerText = "For " + response[data].num_of_people + " people";

        const saviorName = document.createElement("p");
        if (response[data].savior_name != null) {
          saviorName.innerText = "Rescuer: " + response[data].savior_name;
        }

        const sphone = document.createElement("p");
        if (response[data].phone != null) {
          sphone.innerText = "Telephone: " + response[data].phone;
        }

        const tookOver = document.createElement("p");
        if (response[data].took_over_date != null) {
          tookOver.innerText = "Took over: " + response[data].took_over_date;
        }

        const finish = document.createElement("p");
        if (response[data].finished_date != null) {
          finish.innerText = "Finish: " + response[data].finished_date;
        }

        requestDiv.appendChild(titleH2); // <div class="request"> <h2> response[data].item_name </h2> </div>
        requestDiv.appendChild(dateP); /*
          <div class="request"> 
            <h2> response[data].item_name </h2> 
            <p> response[data].created_date </p>
          </div>
        */
        requestDiv.appendChild(nuOfPeople);
        requestDiv.appendChild(saviorName);
        requestDiv.appendChild(sphone);
        requestDiv.appendChild(tookOver);
        requestDiv.appendChild(finish);

        requestsElement.appendChild(requestDiv);
      }
    },
  });
}

// offers history functionality
function resetOffersHistory() {
  console.log("Resetting offers history...");
  const offersElement = document.getElementById("offers");
  if (!offersElement) {
    console.error("Offers element not found!");
    return;
  }

  while (offersElement.lastChild) {
    offersElement.removeChild(offersElement.lastChild);
  }

  const offersTitle = document.createElement("h1");
  offersTitle.innerText = "Offers";
  offersElement.appendChild(offersTitle);
  $.ajax({  
    type: "GET",
    url: "./getOffersInfo.php",
    success: function (response) {
      const offersElement = document.getElementById("offers");
      for (data in response) {
        const requestDiv2 = document.createElement("div"); // <div></div>
        requestDiv2.classList.add("offer"); // <div class="request"></div>

        const titleH2 = document.createElement("p"); // <h2></h2>
        titleH2.innerText = response[data].item_name; // <h2> response[data].item_name </h2>

        const dateP = document.createElement("p"); // <p></p>
        dateP.innerText = "Created Date: " + response[data].created_date; // <p> response[data].created_date </p>

        const saviorName = document.createElement("p");
        if (response[data].savior_name != null) {
          saviorName.innerText = "Rescuer: " + response[data].savior_name;
        }

        const sphone = document.createElement("p");
        if (response[data].savior_phone != null) {
          sphone.innerText = "Telephone: " + response[data].savior_phone;
        }

        const tookOver = document.createElement("p");
        if (response[data].took_over_date != null) {
          tookOver.innerText = "Took over: " + response[data].took_over_date;
        }

        const finish = document.createElement("p");
        if (response[data].finished_date != null) {
          finish.innerText = "Finish: " + response[data].finished_date;
        }

        const canc = document.createElement("p");
        if (response[data].canceled == 1) {
          canc.innerText = "You have cancelled the offer";
        } else if (response[data].canceled != 1 && response[data].savior_name == null) {
          canc.innerText = "the offer is processing ,if you would like to cancel press the button ";
        }

        const quan = document.createElement("p");
        quan.innerText = "quantity: " + response[data].quantity;

        requestDiv2.appendChild(titleH2); // <div class="request"> <h2> response[data].item_name </h2> </div>
        requestDiv2.appendChild(dateP);
        /*
      <div class="request"> 
        <h2> response[data].item_name </h2> 
        <p> response[data].created_date </p>
      </div>
    */ requestDiv2.appendChild(quan);

        requestDiv2.appendChild(saviorName);
        requestDiv2.appendChild(sphone);
        requestDiv2.appendChild(tookOver);
        requestDiv2.appendChild(finish);
        requestDiv2.appendChild(canc);

        if (response[data].canceled != 1 && response[data].savior_name == null) {
          const cancelButton = document.createElement("button");
          cancelButton.innerText = "Cancel";
          cancelButton.setAttribute("offer-id", data);

          cancelButton.addEventListener("click", () => {
            var offerId = cancelButton.getAttribute("offer-id");
            $.ajax({
              type: "POST",
              url: "./cancelOffer.php",
              data: { offerId: offerId },
              success: function (response) {
                const messageElement = document.getElementById("general-message");
                if (response != "done") {
                  messageElement.style.color = "red";
                  messageElement.innerText = "There was an error. Please try again later.";
                  return;
                }
                
                messageElement.style.color = "green";
                messageElement.innerText = "Offer was successfully canceled";
                resetOffersHistory();
              },
            
            });
          
          });

          // Append the cancel button last, so it shows at the bottom
          requestDiv2.appendChild(cancelButton);
        }

        offersElement.appendChild(requestDiv2);
      }
    },
  });
}