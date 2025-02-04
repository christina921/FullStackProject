<!DOCTYPE html>
<html lang="en">

<head>
  <?php 
    session_start();
    if( !isset( $_SESSION["username"] ) && !isset( $_SESSION["type"] )) {
      header("Location:../../index.php");
    } 
    else if ( $_SESSION["type"] == "admin" ) {
      header("Location:../admin/adminHomepage.php");
    } 
    else if ( $_SESSION["type"] == "citizen" ) {
      header("Location:../citizen/citizenHomepage.php");
    }
  ?>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../../css/saviorIndex.css" />

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>

  <script src="../../js/logout.js"></script>
  <script src="../../js/savior/homepage.js"></script>
</head>

<body>
  <img src="../../images/13.jpg" alt="Logo">

  <div class="login-container">
    <button id="logoutBtn">Logout</button>
  </div>
  <button id="view-car-items-btn" class="general-button">See The Items in Your Car</button>
  <script>
  var viewInventory = document.getElementById("view-car-items-btn");
  viewInventory.onclick = function() {
    window.location.href = "https://localhost/web_project_2024/php/savior/getInvetory.php";
  };
  </script>

  <button id="view-base-items-btn" class="general-button">Get Items from Base</button>
  <script>
  var viewBase = document.getElementById("view-base-items-btn");
  viewBase.onclick = function() {
    window.location.href = "./getBaseInventory.php";
  };
  </script>

  <div class="info-container" id="info-container">
    <!-- Dynamic content for tasks on homepage.js-->
  </div>


  <div class="toggle-group">
    <div class="toggle">
      <label for="savior-toggle">Savior</label>
      <input id="savior-toggle" type="checkbox" checked>
    </div>
    <div class="toggle">
      <label for="request">Open Requests</label>
      <input id="request" type="checkbox" checked>
    </div>
    <div class="toggle">
      <label for="request-took-over">Active Requests</label>
      <input id="request-took-over" type="checkbox" checked>
    </div>
    <div class="toggle">
      <label for="offer">Available Offers</label>
      <input id="offer" type="checkbox" checked>
    </div>
    <div class="toggle">
      <label for="offer-took-over">Active Offers</label>
      <input id="offer-took-over" type="checkbox" checked>
    </div>
    <div class="toggle">
      <label for="base">Base Station</label>
      <input id="base" type="checkbox" checked>
    </div>
    <div class="toggle">
      <label for="lines">Connection Lines</label>
      <input id="lines" type="checkbox" checked>
    </div>

  </div>

  <div id="map"></div>

</body>

</html>