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
  
  <link rel="stylesheet" href="../../css/adminIndex.css" />

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>

  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  
  <script src="../../js/logout.js"></script>
   <!--<script src="../../js/admin/homepage.js"></script>    <!--TODO  πεταει error αλλα χωρις αυτο δεν δουλευει το logout -->




 

</head>

<body>
  <img src="../../images/13.jpg" alt="Logo">

  <div class="login-container">
    <button id="logoutBtn">Logout</button>
  </div>

  <div class="toMap-container">
    <button id="operations">Go To Operations Management</button>
    <button id="a">View Map</button>
  </div>

  <div id="messageContainer"></div>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('operations').addEventListener('click', function() {
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

<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('a').addEventListener('click', function() {
      window.location.href = './adminHomepage.php'; // './' refers to the current directory
    });
  });
  </script>




<h1 class ="chris"> Upload Your Announcement.</h1>

<form id="itemForm">
    <div class="form-group1" id="itemInputContainer">
        <!-- Initial item input field -->
        
        <div class="item-input">
            <label for="itemName0">Item Name : </label>
            <input type="text" id="itemName0" name="itemName[]" required>
            <button type="button" onclick="removeInput(this)">Remove</button>
        </div>
    </div>

    <button type="button" onclick="addItem()">Add More Items</button>
    <button type="submit">Submit Items</button>
</form>
<script>
itemNames = [];
$.ajax({
  type: "GET",
  url: "./getItemNames.php",
  success: function (response) {
    for (id in response) {
      itemNames.push(response[id]);
    }

    $("#itemName0").autocomplete({
      source: itemNames,
    });
  },
});




// Track the number of item fields currently present
let itemCount = 1;

// Function to add a new item input field to the form
function addItem() {
    // Get the container that holds all item inputs
    const container = document.getElementById('itemInputContainer');

    // Create a new div element to hold the new input field and button
    const newInput = document.createElement('div');
    newInput.classList.add('item-input'); // Add the class for styling and identification

    // Set the HTML inside the div to include an input and a remove button
    // Each input gets a unique ID and name using the itemCount
    newInput.innerHTML = `
        <label for="itemName${itemCount}">Item Name:</label>
        <input type="text" id="itemName${itemCount}" name="itemName[]" required>
        <button type="button" onclick="removeInput(this)">Remove</button>
    `;

    // Append the new div to the container
    container.appendChild(newInput);

    // create dropdown functionality
    $(`#itemName${itemCount}`).autocomplete({
      source: itemNames,
    });
    // Increment the item count to ensure future labels and inputs have unique identifiers
    itemCount++;
}

// Function to remove an item input field
function removeInput(button) {
    // Remove the parent div of the button that was clicked
    // This button is within the div we want to remove
    button.parentNode.remove();
}




document.getElementById('itemForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting and reloading the page

    // Clear any previous messages
    document.getElementById('messageContainer').textContent = '';

    // Extract data using FormData
    const formData = new FormData(this);

    console.log("Form Data Values Submitted:");
    for (let [key, value] of formData.entries()) {
        console.log(value); // Log only the value of each form input
    }

   console.log(formData);
    


   $.ajax({
  type: "POST",
  url: "./postannouncements.php",
  data: formData,
  processData: false,
  contentType: false,
  dataType: 'json', // Ensure this is set
  success: function(response) {
     console.log('Success:', response);
     if (response != "done") {
       $("#messageContainer").text("You must provide an item that is already in the database, announcement could not be completed.");
     } else {
       $("#messageContainer").text("Announcement completed successfully.");
     }
  },
  error: function(jqXHR, textStatus, errorThrown) {
      console.log("Error:", textStatus, errorThrown);
  }
});




});


</script>


</body>

</html>