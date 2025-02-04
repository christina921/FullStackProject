var locationMarker = null;

$(document).ready(() => {
  const signupBtn = document.getElementById("signup-btn");

  signupBtn.addEventListener("click", () => {
    const usernameElement = document.getElementById("username");
    const passwordElement = document.getElementById("password");
    const phoneElement = document.getElementById("phone");
    const password2Element = document.getElementById("password2");
    const fullName = document.getElementById("fullName");

    if (usernameElement.value == "" || passwordElement.value == "" || phoneElement.value == "" || fullName.value == "") {
      const alertTextElement = document.getElementById("alert-text");
      alertTextElement.innerText = "Username, Password, Full name and phone number are required";
      return;
    } else if (!phoneElement.value.startsWith("69") || phoneElement.value.length !== 10) {
      const alertTextElement = document.getElementById("alert-text");
      alertTextElement.innerText = "Phone number must start with '69' and be 10 digits long";
      return;
    } else if (passwordElement.value !== password2Element.value) {
      const alertTextElement = document.getElementById("alert-text");
      alertTextElement.innerText = "Passwords do not match";
      return;
    } else if (locationMarker == null) {
      const alertTextElement = document.getElementById("alert-text");
      alertTextElement.innerText = "Please tap on map to show where the savior is located";
      return;
    }

    $.ajax({
      type: "POST",
      url: "./signupSaviorDataBase.php",
      data: {
        username: usernameElement.value,
        password: passwordElement.value,
        fullName: fullName.value,
        phone: phoneElement.value,
        latitude: locationMarker.getLatLng().lat,
        longitude: locationMarker.getLatLng().lng,
      },
      success: function (response) {
        const alertTextElement = document.getElementById("alert-text");
        if (response == "already user") {
          alertTextElement.innerText = "There is already a savior with that username.";
          return;
        }
        if (response != "registered") {
          alertTextElement.innerText = "There was an error registering. Please try again later.";
          return;
        }

        alertTextElement.innerText = "Signup was successful. ";
      },
    });
  });

  var map = L.map("map").setView([38.18449777869458, 21.748924248386178], 13);
  L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
  }).addTo(map);

  map.on("click", (e) => {
    if (locationMarker != null) {
      // an o xrhsths pataei 2h fora ston xarth
      map.removeLayer(locationMarker);
      locationMarker = null;
    }

    marker = L.marker(e.latlng);
    marker.addTo(map);

    locationMarker = marker;
  });
});
