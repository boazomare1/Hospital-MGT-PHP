<?php

function is_connected() {
  $connected = @fsockopen("www.google.com", 80);
  if ($connected) {
    fclose($connected);
    return true;
  } else {
    return false;
  }
}

if (is_connected()) {
  //echo "You are connected to the internet.";
} else {
  echo "You seem to be offline. Please check your internet connection.";
}

?>
