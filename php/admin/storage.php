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

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>

  <script src="../../js/logout.js"></script>
  <script src="../../js/admin/storage.js"></script>
</head>

<body>


  <img src="../../images/13.jpg" alt="Logo">

  <div class="login-container">
    <button id="logoutBtn">Logout</button>
  </div>

  <div class="toMap-container">
    <button id="mapBtn">View Map</button>
  </div>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('mapBtn').addEventListener('click', function() {
      window.location.href = './adminHomepage.php'; // './' refers to the current directory
    });
  });
  </script>






  <div class="button-container">
    <button id="insert-items-btn">Insert Items in the Base</button>
    <input type="file" id="items-file-input" class="file-input">
    <div class="vertical-line"></div>
    <button id="signup-btn">Sign Up Saviors</button>
    <div class="vertical-line"></div>
     <button id="announcements">Post Announcement</button>
    
  </div>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('signup-btn').addEventListener('click', function() {
      window.location.href = './signup.php';
    });
  });
  </script>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('announcements').addEventListener('click', function() {
      window.location.href = './announcements.php';
    });
  });
  </script>



  <p id="instruction">Click On An Item To See Its Details.</p>
  <div class="horizontal">
    <div class="table-container">
      <h1>Items</h1>

      <table id="items" class="my-table">
        <tr>
          <th>Name</th>  <!-- th: table header | tr : table row  |td : table data -->

          <th>Category</th>
          <th>Storage Quantity</th>
          <th>Savior Storage</th>
        </tr>
      </table>
    </div>

    <div class="table-container sticky-container">
      <h1>Details</h1>
      <table id="details" class="my-table">
        <tr>
          <th>Name</th>
          <th>Value</th>
        </tr>
        <tr>

        </tr>
      </table>

    </div>
  </div>


  <button id="scrollTopBtn" title="Go to top">Top</button>

</body>

</html>