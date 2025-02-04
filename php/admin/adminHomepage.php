<!DOCTYPE html>
<html lang="en">

<head>
  <?php 
    session_start();
    if( !isset( $_SESSION["username"] ) && !isset( $_SESSION["type"] )) {
      header("Location:../../index.php");
    } 
    else if ( $_SESSION["type"] == "savior" ) {
      header("Location:../savior/saviorHomepage.php");
    } 
    else if ( $_SESSION["type"] == "citizen" ) {
      header("Location:../citizen/citizenHomepage.php");
    }
  ?>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../../css/adminIndex.css" />

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <link rel="stylesheet" href="css/index.css" />

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>

  <script src="../../js/logout.js"></script>
  <script src="../../js/admin/homepage.js"></script>
</head>

<body>
  <img src="../../images/13.jpg" alt="Logo">

  <div class="login-container">
    <button id="logoutBtn">Logout</button>
  </div>


  <div class="toMap-container">
    <button id="mapBtn">Go To Operations Management</button>
  </div>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('mapBtn').addEventListener('click', function() {
      window.location.href = './storage.php'; // './' refers to the current directory
    });
  });
  </script>

  <div class="toggle-group">
  
    <div class="toggle"  >
    
      <label for="savior">Active Savior With Offers Or Requests</label>
      <input id="savior" type="checkbox" checked>
      
    </div>
    <div class="toggle">
      <label for="savior-free">Saviors Without Active Requests Or Offers</label>
      <input id="savior-free" type="checkbox" checked>
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