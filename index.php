<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Web Project 2024</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
  <link rel="stylesheet" href="css/index.css" />

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="js/login.js"></script>
  
  <?php session_start(); ?>  <!-- Starts a PHP session to enable the use of session variables,session started,cause i use them later in the linked js or php -->

</head>

<body>
  <form class="login-form" onsubmit="event.preventDefault();">
    <h2 class="form-item form-title">Login</h2>

    <input id="username" type="text" placeholder="* Username" class="form-item">
    <input id="password" type="password" placeholder="* Password" class="form-item">

    <button id="submit-btn" class="form-item general-button">Submit</button>
    <p class="form-item form-message">Want to join out community? <a href="signup.php">Create an account</a></p>
    <div id="alert-text" class="form-item form-alert"></div>
  </form>
</body>

</html>