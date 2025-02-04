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
  <link rel="stylesheet" href="../../css/adminIndex.css" />

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>

  <script src="../../js/logout.js"></script>
  <script src="../../js/savior/baseStorage.js"></script>
</head>

<body>


  <img src="../../images/13.jpg" alt="Logo">

  <div class="login-container">
    <button id="logoutBtn">Logout</button>
  </div>

  <div class="toMap-container">
    <button id="mapBtn">Go Back</button>
  </div>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('mapBtn').addEventListener('click', function() {
      window.location.href = './saviorHomepage.php'; // './' refers to the current directory
    });
  });
  </script>

  <div class="horizontal">
    <div class="table-container">
      <h1>Items</h1>

      <table id="items" class="my-table">
        <tr>
          <th>Name</th>
          <th>Category</th>
          <th>Quantity</th>
          <th>Quantity to get</th>
          <th></th>
        </tr>
      </table>
    </div>

    <button id="scrollTopBtn" title="Go to top">Top</button>

</body>

</html>