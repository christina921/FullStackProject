var mapLayers = []; // gia na ginetai h allagh topothesias toy savior kai na ginetai refresh olwn twn marker
var map = null;
var saviorLocation = [];
let allMarkersLayer = null;

function cancelOffer(offerId) {
  console.log(`Handling offer with ID: ${offerId}`); //the '$' is Template literals στην js για να το παρω κατευθειαν
  // Add your logic to handle the offer here

  $.ajax({
    type: "POST",
    url: "./cancelOffer.php",
    data: { offerId: offerId },
    success: function (response) {
      if (response !== "done") {
        $.alert({
          title: "Error",
          content: "Could not Cancel this request. Please try again",
          type: "red",
          draggable: false,
        });
        return;
      }

      $.alert({
        title: "Success",
        content: "Offer was successfully canceled",
        type: "green",
        draggable: false,
      });
      reloadMap();
      reloadTasks();
    },
  });
}

function cancelRequest(requestId) {
  console.log(`Handling request with ID: ${requestId}`);
  // Add your logic to handle the request here

  $.ajax({
    type: "POST",
    url: "./cancelRequest.php",
    data: { requestId: requestId },
    success: function (response) {
      if (response !== "done") {
        $.alert({
          title: "Error",
          content: "Could not Cancel this request. Please try again",
          type: "red",
          draggable: false,
        });
        return;
      }

      $.alert({
        title: "Success",
        content: "Request was successfully canceled",
        type: "green",
        draggable: false,
      });
      reloadMap();
      reloadTasks();
    },
  });
}

function requestDone(requestId) {
  console.log(`Handling request with ID: ${requestId}`); //the '$' is Template literals στην js για να το παρω κατευθειαν
  // Add your logic to handle the offer here
  $.ajax({
    type: "POST",
    url: "./requestDone.php",
    data: { requestId: requestId },
    success: function (response) {
      console.log(response);
      if (response == "not_enough_quantity_error") {
        $.alert({
          title: "Error",
          content: "You don't have the requested items in your inventory",
          type: "red",
          draggable: false,
        });
        return;
      }
      if (response != "done") {
        $.alert({
          title: "Error",
          content: "Something went wrong. Please try again later",
          type: "red",
          draggable: false,
        });
        return;
      }

      $.alert({
        title: "Success",
        content: "Request ended.",
        type: "green",
        draggable: false,
      });
      reloadMap();
      reloadTasks();
    },
  });
}

function offerDONE(offerId) {
  console.log(`Handling offer with ID: ${offerId}`);
  // Add your logic to handle the request here

  $.ajax({
    type: "POST",
    url: "./offerDone.php",
    data: { offerId: offerId },
    success: function (response) {
      console.log(response);
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
        content: "Offer ended. Please return all items to base",
        type: "green",
        draggable: false,
      });
      reloadMap();
      reloadTasks();
    },
  });
}

function takeOverOffer(offerId) {
  $.ajax({
    type: "POST",
    url: "./takeOverOffer.php",
    data: { offerId: offerId },
    success: function (response) {
      console.log(response);
      if (response == "ERROR") {
        $.alert({
          title: "Error",
          content: "There was an error. Please try again later",
          type: "red",
          draggable: false,
        });
        return;
      }
      if (response == "4_task_limit_reached") {
        $.alert({
          title: "Error",
          content: "You can only have a maximum number of 4 tasks",
          type: "red",
          draggable: false,
        });
        return;
      }
      if (response != "done") {
        $.alert({
          title: "Error",
          content: "There was an error. Please try again later",
          type: "red",
          draggable: false,
        });
        return;
      }

      $.alert({
        title: "Success",
        content: "Request take over successfully made",
        type: "green",
        draggable: false,
      });
      reloadMap();
      reloadTasks();
    },
  });
}

function takeOverRequest(reqId) {
  $.ajax({
    type: "POST",
    url: "./takeOverRequest.php",
    data: { requestId: reqId },
    success: function (response) {
      console.log(response);
      if (response == "ERROR") {
        $.alert({
          title: "Error",
          content: "There was an error. Please try again later",
          type: "red",
          draggable: false,
        });
        return;
      }
      if (response == "4_task_limit_reached") {
        $.alert({
          title: "Error",
          content: "You can only have a maximum number of 4 tasks",
          type: "red",
          draggable: false,
        });
        return;
      }
      if (response != "done") {
        $.alert({
          title: "Error",
          content: "There was an error. Please try again later",
          type: "red",
          draggable: false,
        });
        return;
      }

      $.alert({
        title: "Success",
        content: "Request take over successfully made",
        type: "green",
        draggable: false,
      });
      reloadMap();
      reloadTasks();
    },
  });
}

$(document).ready(() => {
  var viewInvetory = document.getElementById("view-car-items-btn");
  viewInvetory.onclick = function () {
    window.location.href = "https://localhost/web_project_2024/php/savior/getInvetory.php";
  };

  const logoutBtnElement = document.getElementById("logoutBtn");
  logoutBtnElement.addEventListener("click", logout);
  //from here the panel for tasks

  reloadTasks();

  //from here is the map functionallity
  map = L.map("map").setView([38.18449777869458, 21.748924248386178], 13);
  L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
  }).addTo(map);

  $.ajax({
    type: "GET",
    url: "./getMapInfo.php",

    success: function (response) {
      onMapInfoSuccess(response);
    },
  });
});

function onMapInfoSuccess(info) {
  mapLayers = [];
  if (allMarkersLayer != null) {
    map.removeLayer(allMarkersLayer);
  }
  // Initialize the request markers layer
  allMarkersLayer = new L.layerGroup();
  map.addLayer(allMarkersLayer);
  const requestMarkersLayer = new L.layerGroup();
  //TODO: Remove all mapLayers pushes from the whole file
  mapLayers.push({ requests_layer: requestMarkersLayer });

  // Icon for request markers
  const requestIcon = L.icon({
    iconUrl: "../../images/requests_marker.png",
    iconSize: [48, 48],
    iconAnchor: [24, 47],
    popupAnchor: [1, -47],
  });

  // Add markers to the request layer
  for (const request in info["requests"]) {
    const tempLatLng = [info["requests"][request].citizen_lat, info["requests"][request].citizen_lng];
    const tempRequestMarker = L.marker(tempLatLng, { icon: requestIcon }); //dhmiourgeia marker

    let string = "<h4>Open Requests</h4>" + "Citizen Name: " + info["requests"][request].citizen_name;
    string += "<br> Created Date: " + info["requests"][request].created_date;
    string += "<br> Citizen Phone: " + info["requests"][request].citizen_phone;
    string += "<br> Item Name: " + info["requests"][request].item_name;
    string += "<br> For: " + info["requests"][request].num_of_people + " People ";
    string += `<br><button onclick="takeOverRequest(${request})">Take over</button>`;

    tempRequestMarker.bindPopup(string);
    requestMarkersLayer.addLayer(tempRequestMarker);
  }
  allMarkersLayer.addLayer(requestMarkersLayer); // Ensure the layer is added to the map

  // Initialize took over request markers layer
  const took_over_requestMarkersLayer = new L.layerGroup();
  const lines_Layer = new L.layerGroup();
  mapLayers.push({ took_over_requests_layer: took_over_requestMarkersLayer });
  mapLayers.push({ lines_Layer: lines_Layer });

  // Icon for took over request markers
  const took_over_requestIcon = L.icon({
    iconUrl: "../../images/took_over_requests.png",
    iconSize: [48, 48],
    iconAnchor: [24, 47],
    popupAnchor: [1, -47],
  });

  // Add markers to the took over request layer
  for (const took_over_request in info["took_over_requests"]) {
    const tempLatLng = [info["took_over_requests"][took_over_request].citizen_lat, info["took_over_requests"][took_over_request].citizen_lng];
    const temptook_over_requestMarker = L.marker(tempLatLng, { icon: took_over_requestIcon });
    took_over_requestMarkersLayer.addLayer(temptook_over_requestMarker);

    let popupString = "<h4>Active Requests</h4>" + "Created Date: " + info["took_over_requests"][took_over_request].created_date;
    popupString += "<br> Took Over Date: " + info["took_over_requests"][took_over_request].took_over_date;
    popupString += "<br> Item Name: " + info["took_over_requests"][took_over_request].item_name;
    popupString += "<br> For: " + info["took_over_requests"][took_over_request].num_of_people + " People ";
    popupString += "<br> Citizen Name: " + info["took_over_requests"][took_over_request].citizen_name;
    popupString += "<br> Citizen Phone: " + info["took_over_requests"][took_over_request].citizen_phone;
    popupString += "<br> Item Name: " + info["took_over_requests"][took_over_request].item_name;

    temptook_over_requestMarker.bindPopup(popupString);
    took_over_requestMarkersLayer.addLayer(temptook_over_requestMarker);

    // create line from citizen to savior
    const lineLatLng = [
      [info["took_over_requests"][took_over_request].citizen_lat, info["took_over_requests"][took_over_request].citizen_lng],
      [info["took_over_requests"][took_over_request].savior_lat, info["took_over_requests"][took_over_request].savior_lng],
    ];
    L.polyline(lineLatLng, { color: "red" }).addTo(lines_Layer);
  }
  allMarkersLayer.addLayer(lines_Layer); // Ensure the layer is added to the map
  allMarkersLayer.addLayer(took_over_requestMarkersLayer); // Ensure the layer is added to the map

  // offers,, Initialize offer markers layer
  const offerMarkersLayer = new L.layerGroup();
  mapLayers.push({ offers_layer: offerMarkersLayer });

  // Icon for offers
  const offerIcon = L.icon({
    iconUrl: "../../images/offers_marker.png",
    iconSize: [48, 48],
    iconAnchor: [24, 47],
    popupAnchor: [1, -47],
  });

  // Add markers to the offer layer
  for (const offer in info["offers"]) {
    const tempLatLng = [info["offers"][offer].citizen_lat, info["offers"][offer].citizen_lng];
    const tempOfferMarker = L.marker(tempLatLng, { icon: offerIcon });
    offerMarkersLayer.addLayer(tempOfferMarker);

    let string2 = "<h4>Available Offer</h4>" + "Created Date: " + info["offers"][offer].created_date;
    string2 += "<br> Citizen Name: " + info["offers"][offer].citizen_name;
    string2 += "<br> Citizen Phone: " + info["offers"][offer].citizen_phone;
    string2 += "<br> Item Name: " + info["offers"][offer].item_name;
    string2 += "<br> Quantity: " + info["offers"][offer].quantity;
    string2 += `<br><button onclick="takeOverOffer(${offer})">Take over</button>`;

    tempOfferMarker.bindPopup(string2);
    offerMarkersLayer.addLayer(tempOfferMarker);
  }

  allMarkersLayer.addLayer(offerMarkersLayer);

  //took_over_offers
  const took_over_offerMarkersLayer = new L.layerGroup();
  mapLayers.push({ took_over_offers_layer: took_over_offerMarkersLayer });

  // Icon for offers
  const took_over_offerIcon = L.icon({
    iconUrl: "../../images/took_over_offers_marker.png",
    iconSize: [48, 48],
    iconAnchor: [24, 47],
    popupAnchor: [1, -47],
  });

  // Add markers to the offer layer
  for (const took_over_offer in info["took_over_offers"]) {
    const tempLatLng = [info["took_over_offers"][took_over_offer].citizen_lat, info["took_over_offers"][took_over_offer].citizen_lng];
    const temptook_over_offerMarker = L.marker(tempLatLng, { icon: took_over_offerIcon });
    took_over_offerMarkersLayer.addLayer(temptook_over_offerMarker);

    let string99 = "<h4>Active Offers</h4>" + "Created Date: " + info["took_over_offers"][took_over_offer].created_date;
    string99 += "<br> Item Name: " + info["took_over_offers"][took_over_offer].item_name;
    string99 += "<br> Offer Quantity: " + info["took_over_offers"][took_over_offer].quantity;
    string99 += "<br> Citizen Name: " + info["took_over_offers"][took_over_offer].citizen_name;
    string99 += "<br> Citizen Phone: " + info["took_over_offers"][took_over_offer].citizen_phone;

    temptook_over_offerMarker.bindPopup(string99);
    took_over_offerMarkersLayer.addLayer(temptook_over_offerMarker);

    // create line from citizen to savior
    const lineLatLng = [
      [info["took_over_offers"][took_over_offer].citizen_lat, info["took_over_offers"][took_over_offer].citizen_lng],
      [info["took_over_offers"][took_over_offer].savior_lat, info["took_over_offers"][took_over_offer].savior_lng],
    ];
    L.polyline(lineLatLng, { color: "green" }).addTo(lines_Layer);
  }

  allMarkersLayer.addLayer(took_over_offerMarkersLayer);

  //building location

  const buildinglocationMarkersLayer = new L.layerGroup();
  mapLayers.push({ building_location_layer: buildinglocationMarkersLayer });

  // Icon for offers
  const buildinglocationIcon = L.icon({
    iconUrl: "../../images/buildinglocationmarker.png",
    iconSize: [48, 48],
    iconAnchor: [24, 47],
    popupAnchor: [1, -47],
  });

  // Create building location Marker
  const tempLatLng = [info["buildinglocation"].latitude, info["buildinglocation"].longitude];
  buildingLocation = tempLatLng;
  const tempbuildinglocatioMarker = L.marker(tempLatLng, { icon: buildinglocationIcon });
  buildinglocationMarkersLayer.addLayer(tempbuildinglocatioMarker);

  allMarkersLayer.addLayer(buildinglocationMarkersLayer);

  //savior
  const saviorMarkerLayer = new L.layerGroup();
  mapLayers.push({ savior_layer: saviorMarkerLayer });

  // Icon for saviors free
  const saviorsfreeIcon = L.icon({
    iconUrl: "../../images/saviorsfreemarker.png",
    iconSize: [48, 48],
    iconAnchor: [24, 47],
    popupAnchor: [1, -47],
  });

  // Savior Marker

  const saviorLatLng = [info["savior"].latitude, info["savior"].longitude];
  saviorLocation = saviorLatLng;
  const tempSaviorMarker = L.marker(saviorLatLng, { icon: saviorsfreeIcon, draggable: true });
  saviorMarkerLayer.addLayer(tempSaviorMarker);

  allMarkersLayer.addLayer(saviorMarkerLayer);

  // create building marker functionallity
  tempSaviorMarker.on("moveend", (event) => {
    $.ajax({
      type: "POST",
      url: "./changeSaviorLocation.php",
      data: { new_lat: event.target._latlng.lat, new_lng: event.target._latlng.lng },
      success: function (response) {
        if (response != "done") {
          // there was a problem updating building location
          tempSaviorMarker.setLatLng(saviorLocation);
          return;
        }

        $.ajax({
          type: "GET",
          url: "./getMapInfo.php",
          success: function (response) {
            onMapInfoSuccess(response);
          },
        });
      },
    });
  });

  // Toggle Markers functionality
  const requestsCheckBox = document.getElementById("request");
  requestsCheckBox.addEventListener("click", function (event) {
    if (requestsCheckBox.checked) {
      allMarkersLayer.addLayer(requestMarkersLayer);
      return;
    }

    allMarkersLayer.removeLayer(requestMarkersLayer);
  });

  const requestsTookOverCheckBox = document.getElementById("request-took-over");
  requestsTookOverCheckBox.addEventListener("click", function (event) {
    if (requestsTookOverCheckBox.checked) {
      allMarkersLayer.addLayer(took_over_requestMarkersLayer);
      return;
    }

    allMarkersLayer.removeLayer(took_over_requestMarkersLayer);
  });

  const offersCheckBox = document.getElementById("offer");
  offersCheckBox.addEventListener("click", function (event) {
    if (offersCheckBox.checked) {
      allMarkersLayer.addLayer(offerMarkersLayer);
      return;
    }

    map.removeLayer(offerMarkersLayer);
  });

  const offersTookOverCheckBox = document.getElementById("offer-took-over");
  offersTookOverCheckBox.addEventListener("click", function (event) {
    if (offersTookOverCheckBox.checked) {
      allMarkersLayer.addLayer(took_over_offerMarkersLayer);
      return;
    }

    allMarkersLayer.removeLayer(took_over_offerMarkersLayer);
  });

  const baseCheckBox = document.getElementById("base");
  baseCheckBox.addEventListener("click", function (event) {
    if (baseCheckBox.checked) {
      allMarkersLayer.addLayer(buildinglocationMarkersLayer);
      return;
    }

    allMarkersLayer.removeLayer(buildinglocationMarkersLayer);
  });

  const linesCheckBox = document.getElementById("lines");
  linesCheckBox.addEventListener("click", function (event) {
    if (linesCheckBox.checked) {
      allMarkersLayer.addLayer(lines_Layer);
      return;
    }

    allMarkersLayer.removeLayer(lines_Layer);
  });

  const saviorCheckBox = document.getElementById("savior-toggle");
  saviorCheckBox.addEventListener("click", function (event) {
    if (saviorCheckBox.checked) {
      allMarkersLayer.addLayer(saviorMarkerLayer);
      return;
    }

    allMarkersLayer.removeLayer(saviorMarkerLayer);
  });
}

function reloadTasks() {
  const container = $("#info-container");

  container.empty();

  $.ajax({
    type: "GET",
    url: "./getTaskHistory.php",
    dataType: "json",
    success: function (data) {
      // Process took over offers
      if (data.took_over_offers) {
        /* καλεσε την cancellOffer με το id ως ορισμα (onclick)βαλε το id ως attribute*/
        for (const offerId in data.took_over_offers) {
          const offer = data.took_over_offers[offerId];
          const task = `
                  <div class="task">
                    <h2>Offer </h2>
                    <p>Created Date: ${offer.created_date}</p>
                    <p>Took Over Date: ${offer.took_over_date}</p>
                    <p>Item Name: ${offer.item_name}</p>
                    <p>Category: ${offer.item_category}</p>
                    <p>Quantity: ${offer.quantity}</p>
                    <p>Citizen Name: ${offer.citizen_name}</p>
                    <p>Citizen Phone: ${offer.citizen_phone}</p>
                    <button onclick="cancelOffer(${offerId})">CANCELL OFFER</button>    
                    <button onclick="offerDONE(${offerId})">DONE</button>     
                  </div>`;
          container.append(task);
        }
      }

      // Process took over requests
      if (data.took_over_requests) {
        /* καλεσε την cancellRequest με το 
             με το id ως ορισμα  */
        for (const requestId in data.took_over_requests) {
          const request = data.took_over_requests[requestId];
          const task = `
                  <div class="task">
                    <h2>Request </h2>
                    <p>Created Date: ${request.created_date}</p>
                    <p>Took Over Date: ${request.took_over_date}</p>
                    <p>Item Name: ${request.item_name}</p>
                    <p>Category: ${request.item_category}</p>
                    <p>For: ${request.num_of_people} People</p>
                    <p>Citizen Name: ${request.citizen_name}</p>
                    <p>Citizen Phone: ${request.citizen_phone}</p>
                    <button onclick="cancelRequest(${requestId})">CANCELL REQUEST</button> 
                    <button onclick="requestDone(${requestId})">DONE</button>              
                  </div>`;
          container.append(task);
        }
      }
    },
  });
}

function reloadMap() {
  $.ajax({
    type: "GET",
    url: "./getMapInfo.php",
    success: function (response) {
      onMapInfoSuccess(response);
    },
  });
}
