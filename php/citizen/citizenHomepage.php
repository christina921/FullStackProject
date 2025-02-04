<!DOCTYPE html>
<html lang="en">

<head>
  <?php 
    session_start();
    if( !isset( $_SESSION["username"] ) && !isset( $_SESSION["type"] )) {
      header("Location:../../index.php");
    } else if ( $_SESSION["type"] == "admin" ) {
      header("Location:../admin/adminHomepage.php");
    } else if ( $_SESSION["type"] == "savior" ) {
      header("Location:../savior/saviorHomepage.php");
    }
  ?>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../../css/citizenIndex.css" />

  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

  <script src="../../js/logout.js"></script>
  <script src="../../js/citizen/homepage.js"></script>
</head>

<body>
  <img src="../../images/13.jpg" alt="Logo">

  <div class="login-container">
    <button id="logoutBtn">Logout</button>
  </div>

  <div class="request-container">
    <h2>Make a New Request</h2>
    <form onsubmit="event.preventDefault();">
      <label for="item-choice">Choose an item:</label>
      <input list="items" id="item-choice" name="item-choice">

      <label for="quantity">Quantity of people:</label>
      <input type="number" id="quantity" name="quantity" min="1">

      <button type="submit" id="submit-request">Submit Request</button>
      <p style="color:red" id="error-request"></p>
    </form>

    <p style="color:red" id="general-message"></p>
    <div class="container">

      <div id="announcements" class="board">
        <h1>Announcements</h1>
      </div>



      <div id="offers" class="offers">
        <h1>Offers</h1>
        <div class="horizontal">
        </div>
      </div>

      <div id="requests" class="requests">
        <h1>Requests History</h1>
      </div>

    </div>
</body>

</html>