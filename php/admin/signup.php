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
  <title>Web Project 2024</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">


 
  <link rel="stylesheet" href="../../css/adminIndex.css" />
  
  <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <link rel="stylesheet" href="../../css/index.css" />

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <script src="../../js/admin/signupSavior.js"></script>
  <script src="../../js/logout.js"></script>
  
</head>

<body>


<div class="login-container">
    <button id="logoutBtn">Logout</button>
  </div>


  <div class="toMap-container">
    <button id="mapBtn2">Go To Operations Management</button>
  </div>
  <div class="buttonn">
    <button id="mapBtn">View Map</button>
  </div>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('mapBtn').addEventListener('click', function() {
      window.location.href = './adminHomepage.php'; // './' refers to the current directory
    });
  });
  </script>

  

 


<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('mapBtn2').addEventListener('click', function() {
      window.location.href = './storage.php'; // './' refers to the current directory
    });
  });
  </script>
  



<script>
document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('logoutBtn').addEventListener('click', function() {
    $.ajax({
      type: "POST",
      url: "../../logout.php",
      success: function (response) {
        window.location = "../../index.php";
      },
      
    });
  });
});
</script>




  <form class="login-form" onsubmit="event.preventDefault();">
    <h2 class="form-item form-title">Sign Up Savior</h2>

    <input id="username" class="form-item" type="text" placeholder="* Username">
    <input id="fullName" class="form-item" type="text" placeholder="* Full Name">
    <input id="phone" class="form-item" type="text" name="phone" placeholder="* Phone">
    <div class="form-pair">
      <input id="password" class="form-item" type="password" name="password" placeholder="* Password">
      <input id="password2" class="form-item" type="password" name="confirm-password" placeholder="* Confirm Password">
    </div>
    <button id="signup-btn" class="form-item general-button">Submit</button>
    
    <div id="alert-text" class="form-item form-alert"></div>
  </form>

  <div id="map"></div>

  

</body>

</html>