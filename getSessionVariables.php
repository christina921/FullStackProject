<?php 
  session_start();
// αυτο ειναι για να ελενχω τι εχει αποθηκευτει στο session
  echo $_SESSION["username"]."  ".$_SESSION["name"]."  ".$_SESSION["phone"]."   ".$_SESSION["type"]

?>