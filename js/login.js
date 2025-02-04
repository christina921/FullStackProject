$(document).ready(() => {
  const submitBtn = document.getElementById("submit-btn");

  submitBtn.addEventListener("click", () => {
    const usernameElement = document.getElementById("username");
    const passwordElement = document.getElementById("password");

    if (usernameElement.value == "" || passwordElement.value == "") {
      const alertTextElement = document.getElementById("alert-text");
      alertTextElement.innerText = "Username and Password are required";
      return;
    }

    $.ajax({
      type: "GET",
      url: "./php/login.php?username=" + usernameElement.value + "&password=" + passwordElement.value,
      success: function (response) {
        if (response == "user not found") {
          const alertTextElement = document.getElementById("alert-text");
          alertTextElement.innerText = "Username Or Password Are Incorrect";
          return;
        }

        if (response == "admin") {
          window.location.href = "php/admin/adminHomepage.php";
        } else if (response == "savior") {
          window.location.href = "php/savior/saviorHomepage.php";
        } else if (response == "citizen") {
          window.location.href = "php/citizen/citizenHomepage.php";
        }
      },
    });
  });
});
