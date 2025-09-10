<?php
session_start();
session_destroy();
session_start();
//header ("location:access.php");
?>
<script>
if (true) 
{
  //document.write("JavaScript is turned on!");
  window.location = "access.php";
}
</script>
<noscript>
JavaScript is turned off in your web browser. Turn it on to take full advantage of this site, then refresh the page.
</noscript>