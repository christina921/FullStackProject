var mapLayers = [];
var map = null;
var buildingLocation = [];

$(document).ready(() => {
  const logoutBtnElement = document.getElementById("logoutBtn");
  logoutBtnElement.addEventListener("click", logout);

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

function onMapInfoSuccess(info) {     //info= response
  // Initialize the request markers layer
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

    tempRequestMarker.bindPopup(string);
    requestMarkersLayer.addLayer(tempRequestMarker);
  }
  map.addLayer(requestMarkersLayer); // Ensure the layer is added to the map 

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
    L.polyline(lineLatLng, { color: "#FF007F" }).addTo(lines_Layer);
  }

  map.addLayer(took_over_requestMarkersLayer);
  map.addLayer(lines_Layer);

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

    tempOfferMarker.bindPopup(string2);
    offerMarkersLayer.addLayer(tempOfferMarker);
  }

  map.addLayer(offerMarkersLayer);

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
    L.polyline(lineLatLng, { color: "#7B68EE" }).addTo(lines_Layer);
  }

  map.addLayer(took_over_offerMarkersLayer);

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
  const tempbuildinglocatioMarker = L.marker(tempLatLng, { icon: buildinglocationIcon, draggable: true });
  buildinglocationMarkersLayer.addLayer(tempbuildinglocatioMarker);

  map.addLayer(buildinglocationMarkersLayer);

  // create building marker functionallity
  tempbuildinglocatioMarker.on("moveend", (event) => {  //event: ειναι τα στοιχεια που μου δινει το moveend απο την leeflet
    $.confirm({  //jquery confirm : για το dialog οταν ρωταω διαχειριστη αν θελει να αλλαξει την βαση 
      title: "Confirm!",
      content: "Confirm base location change!",
      buttons: {
        confirm: function () {
          $.ajax({
            type: "POST",
            url: "./changeBaseLocation.php",
            data: { new_lat: event.target._latlng.lat, new_lng: event.target._latlng.lng },
            success: function (response) {
              console.log(response);
              if (response != "done") {
                // there was a problem updating building location
                tempbuildinglocatioMarker.setLatLng(buildingLocation);
                return;
              }

              buildingLocation = [event.target._latlng.lat, event.target._latlng.lng];
            },
          });
        },
        cancel: function () {
          tempbuildinglocatioMarker.setLatLng(buildingLocation);
        },
      },
    });

    console.log(event.target._latlng);
  });

  //saviors_free
  const saviorsfreeMarkersLayer = new L.layerGroup();
  mapLayers.push({ saviors_free_Layer: saviorsfreeMarkersLayer });

  // Icon for saviors free
  const saviorsfreeIcon = L.icon({
    iconUrl: "../../images/saviorsfreemarker.png",
    iconSize: [48, 48],
    iconAnchor: [24, 47],
    popupAnchor: [1, -47],
  });

  // Add markers to the savior free layer
  for (saviorfree in info["saviors_free"]) {
    const tempLatLng = [info["saviors_free"][saviorfree].latitude, info["saviors_free"][saviorfree].longitude];
    const tempsaviorfreeMarker = L.marker(tempLatLng, { icon: saviorsfreeIcon });
    saviorsfreeMarkersLayer.addLayer(tempsaviorfreeMarker);

    let string3 = "<h4>Saviors Without Active Requests or Offers</h4>" + "Savior Name: " + info["saviors_free"][saviorfree].username;
    string3 += "<br> Phone: " + info["saviors_free"][saviorfree].phone;

    if (info["saviors_free"][saviorfree].saviorItems ) {
      string3 += "<br><br><strong>Savior Items:</strong>";
      for (const itemKey in info["saviors_free"][saviorfree].saviorItems) {
          const currentItem = info["saviors_free"][saviorfree].saviorItems[itemKey];
          // Check if item_name is not null and item_quantity is not zero
          if (!currentItem.name || currentItem.quantity === "0") continue;
  
          string3 += `<br> Item Name: ${currentItem.name}`;
          string3 += `<br> Item Quantity: ${currentItem.quantity}`;
      }
  }
  
    tempsaviorfreeMarker.bindPopup(string3);
    saviorsfreeMarkersLayer.addLayer(tempsaviorfreeMarker);
  }

  map.addLayer(saviorsfreeMarkersLayer);

  //saviors with at least one offer at this time

  const saviorsOMarkersLayer = new L.layerGroup();
  mapLayers.push({ saviors_O_Layer: saviorsOMarkersLayer });

  // Icon for saviors free
  const saviorsOIcon = L.icon({
    iconUrl: "../../images/saviorsmarker.png",
    iconSize: [48, 48],
    iconAnchor: [24, 47],
    popupAnchor: [1, -47],
  });

  // Add markers to the savior with offers
  for (const saviorO in info["saviorsO"]) {
    const tempLatLng = [info["saviorsO"][saviorO].latitude, info["saviorsO"][saviorO].longitude];
    const tempsaviorsOIcon = L.marker(tempLatLng, { icon: saviorsOIcon });
    saviorsOMarkersLayer.addLayer(tempsaviorsOIcon);

    let string4 = "<h4>Active Savior With Offers Or Requests</h4>" + "Savior Name: " + info["saviorsO"][saviorO].name;
    string4 += "<br> Phone: " + info["saviorsO"][saviorO].phone;

    // Retrieve the savior items
    if (info["saviorsO"][saviorO].savior_items) {
      string4 += "<br><br><strong>Savior Items:</strong>";
      for (item in info["saviorsO"][saviorO].savior_items) {
        //foreach =για καθε γραμμη που γυρναει η php
        const currentItem = info["saviorsO"][saviorO].savior_items[item];
        if (currentItem.item_name === null) continue;
        if (currentItem.item_quantity == 0) continue;

        string4 += `<br> Item Name: ${currentItem.item_name}`;
        string4 += `<br> Item Quantity: ${currentItem.item_quantity}`;
        string4 += `<br> Item ID: ${currentItem.item_id}`;
      }
    }

    tempsaviorsOIcon.bindPopup(string4);
    saviorsOMarkersLayer.addLayer(tempsaviorsOIcon);
  }

  map.addLayer(saviorsOMarkersLayer);

  //saviors with at least one request at this time

  // Initialize the layer group for saviorsR
  const saviorsRMarkersLayer = new L.layerGroup();
  mapLayers.push({ saviors_R_Layer: saviorsRMarkersLayer });

  const saviorsRIcon = L.icon({
    iconUrl: "../../images/saviorsmarker.png",
    iconSize: [48, 48],
    iconAnchor: [24, 47],
    popupAnchor: [1, -47],
  });

  // Add markers to the saviors with requests
  for (const saviorR in info["saviorsR"]) {
    const tempLatLng = [info["saviorsR"][saviorR].latitude, info["saviorsR"][saviorR].longitude];
    const tempsaviorsRIcon = L.marker(tempLatLng, { icon: saviorsRIcon });
    saviorsRMarkersLayer.addLayer(tempsaviorsRIcon);

    let string5 = "<h4>Active Savior With Requests Or Offers</h4>" + "Savior Name: " + info["saviorsR"][saviorR].name;
    string5 += "<br> Phone: " + info["saviorsR"][saviorR].phone;

    // Retrieve the requests
    if (info["saviorsR"][saviorR].requests && info["saviorsR"][saviorR].requests.length > 0) {
      string5 += "<br><br><strong>Requests:</strong>";
      info["saviorsR"][saviorR].requests.forEach((request) => {
        //foreach =για καθε γραμμη που γυρναει η php
        string5 += `<br> Number of People: ${request.num_of_people}`;
        string5 += `<br> Created Day: ${request.request_created_day}`;
        string5 += `<br> Took Over Date: ${request.request_took_over_date}`;
      });
    }

    // Retrieve the savior items
    if (info["saviorsR"][saviorR].savior_items) {
      string5 += "<br><br><strong>Savior Items:</strong>";
      for (item in info["saviorsR"][saviorR].savior_items) {
        //foreach =για καθε γραμμη που γυρναει η php
        const currentItem = info["saviorsR"][saviorR].savior_items[item];
        if (currentItem.item_name === null) continue;
        if (currentItem.item_quantity == 0) continue;

        string5 += `<br> Item Name: ${currentItem.item_name}`;
        string5 += `<br> Item Quantity: ${currentItem.item_quantity}`;
        string5 += `<br> Item ID: ${currentItem.item_id}`;
      }
    }

    // if (info["saviorsR"][saviorR].savior_items) {
    //   string5 += "<br><br><strong>Savior Items:</strong>";
    //   info["saviorsR"][saviorR].savior_items.forEach((item) => {
    //     foreach =για καθε γραμμη που γυρναει η php
    //     string5 += `<br> Item Name: ${item.item_name}`;
    //     string5 += `<br> Item Quantity: ${item.item_quantity}`;
    //     string5 += `<br> Item ID: ${item.item_id}`;
    //   });
    // }

    tempsaviorsRIcon.bindPopup(string5);
    saviorsRMarkersLayer.addLayer(tempsaviorsRIcon);
  }

  // Add the layer to the map
  map.addLayer(saviorsRMarkersLayer);

  
  // Toggle Markers functionality
  const saviorCheckBox = document.getElementById("savior");
  saviorCheckBox.addEventListener("click", function (event) {
    if (saviorCheckBox.checked) {      //Active Savior With Offers Or Requests
      map.addLayer(saviorsRMarkersLayer);
      map.addLayer(saviorsOMarkersLayer);
      return;
    }

    map.removeLayer(saviorsRMarkersLayer);
    map.removeLayer(saviorsOMarkersLayer);
  });

  const saviorFreeCheckBox = document.getElementById("savior-free");
  saviorFreeCheckBox.addEventListener("click", function (event) {
    if (saviorFreeCheckBox.checked) {   //Saviors Without Active Requests Or Offers
      map.addLayer(saviorsfreeMarkersLayer);
      return;
    }

    map.removeLayer(saviorsfreeMarkersLayer);
  });

  const requestsCheckBox = document.getElementById("request");
  requestsCheckBox.addEventListener("click", function (event) {  //Open Requests
    if (requestsCheckBox.checked) {
      map.addLayer(requestMarkersLayer);
      return;
    }

    map.removeLayer(requestMarkersLayer);
  });

  const requestsTookOverCheckBox = document.getElementById("request-took-over");
  requestsTookOverCheckBox.addEventListener("click", function (event) { //Active Requests
    if (requestsTookOverCheckBox.checked) {
      map.addLayer(took_over_requestMarkersLayer);
      return;
    }

    map.removeLayer(took_over_requestMarkersLayer);
  });

  const offersCheckBox = document.getElementById("offer");
  offersCheckBox.addEventListener("click", function (event) {  //Available Offers 
    if (offersCheckBox.checked) {
      map.addLayer(offerMarkersLayer);
      return;
    }

    map.removeLayer(offerMarkersLayer);
  });

  const offersTookOverCheckBox = document.getElementById("offer-took-over");
  offersTookOverCheckBox.addEventListener("click", function (event) { //Active Offers
    if (offersTookOverCheckBox.checked) {
      map.addLayer(took_over_offerMarkersLayer);
      return;
    }

    map.removeLayer(took_over_offerMarkersLayer);
  });

  const baseCheckBox = document.getElementById("base");
  baseCheckBox.addEventListener("click", function (event) {
    if (baseCheckBox.checked) {
      map.addLayer(buildinglocationMarkersLayer);
      return;
    }

    map.removeLayer(buildinglocationMarkersLayer);
  });

  const linesCheckBox = document.getElementById("lines");
  linesCheckBox.addEventListener("click", function (event) {
    if (linesCheckBox.checked) {
      map.addLayer(lines_Layer);
      return;
    }

    map.removeLayer(lines_Layer);
  });
}
