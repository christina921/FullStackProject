<?php 
  session_start();    //ολο το αρχειο αυτο για καταστροφη του session
  session_unset();
  session_destroy();
?>