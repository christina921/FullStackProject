<?php 
session_start();
if (!isset($_SESSION["username"]) || !isset($_SESSION["type"])) {
  header("Location: ../../index.php");
  exit; // Ensure the script stops after sending header
} 
else if ($_SESSION["type"] == "admin") {
  header("Location: ../admin/adminHomepage.php");
  exit;
} 
else if ($_SESSION["type"] == "citizen") {
  header("Location: ../citizen/citizenHomepage.php");
  exit;
}
include_once("../../connect_to_db.php");

$offerId = $_POST["offerId"];

// find savior id using prepared statement
$stmt = $db_link->prepare("SELECT id FROM savior WHERE username = ?");
$stmt->bind_param("s", $_SESSION["username"]);
$stmt->execute();
$result = $stmt->get_result(); //παρε το αποτελεσμα απο το query απο τον server kai apothikeyse to sto 
// $result
$savior_id = null;
if ($row = $result->fetch_assoc()) {
  // Create an array with 'item_id' and 'quantity' from the fetched data
  $savior_id = (int)$row["id"];
}
if (is_null($savior_id)) {
  echo "savior_id is null";
  exit;
}

// find the items that is listed in offer using prepared statement
$stmt = $db_link->prepare("SELECT item_id, quantity FROM offer WHERE id = ?");
$stmt->bind_param("i", $offerId);
$stmt->execute();
$result = $stmt->get_result();
$offer_item = null;
if ($row = $result->fetch_assoc()) {
  $offer_item = [
    "id" => $row["item_id"],
    "quantity" => $row["quantity"]
  ];
}
if (is_null($offer_item)) {
  echo "offer_item is null";
  exit;
}

// insert items into saviorItems table using prepared statement
$stmt = $db_link->prepare("INSERT INTO savioritems (`savior_id`, `item_id`, `quantity`) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)");
$stmt->bind_param("iii", $savior_id, $offer_item["id"], $offer_item["quantity"]);
$stmt->execute();

// set finished date on offer table using prepared statement
$stmt = $db_link->prepare("UPDATE offer SET finished_date = CURRENT_TIMESTAMP WHERE id = ?");
$stmt->bind_param("i", $offerId);
$stmt->execute();

echo "done";
?>
