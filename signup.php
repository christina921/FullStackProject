<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Web Project 2024</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <link rel="stylesheet" href="css/index.css" />

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <script src="js/signup.js"></script>

  <?php session_start(); ?>
</head>

<body>
  <form class="login-form" onsubmit="event.preventDefault();">
    <h2 class="form-item form-title">Sign Up</h2>

    <input id="username" class="form-item" type="text" placeholder="* Username">
    <input id="fullName" class="form-item" type="text" placeholder="* Full Name">
    <input id="phone" class="form-item" type="text" name="phone" placeholder="* Phone">
    <div class="form-pair">
      <input id="password" class="form-item" type="password" name="password" placeholder="* Password">
      <input id="password2" class="form-item" type="password" name="confirm-password" placeholder="* Confirm Password">
    </div>
    <button id="signup-btn" class="form-item general-button">Submit</button>
    <p class="form-item form-message">Are you registered? <a href="index.php">Login</a></p>
    <div id="alert-text" class="form-item form-alert"></div>
  </form>

  <div id="map"></div>

</body>

</html>