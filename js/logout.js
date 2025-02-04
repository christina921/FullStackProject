function logout() {
  $.ajax({
    type: "POST",
    url: "../../logout.php",
    success: function (response) {
      window.location = "../../index.php";
    },
  });
}
