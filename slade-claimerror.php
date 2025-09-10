<?php
$print_url="billing_pending_op2.php";

?>
<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>Billing Paylater</title>
   <link rel="stylesheet" href="css/sweetalert-min.css">
  <script src="js/sweetalert.min.js"> </script>
 </head>
 <body>
 <script>
  swal({
  title: "Claim ID : Error",
  text: "Unable to connect slade server. please try again later.",
  type: "success"
  }).then(function() {
    window.location = "<?php echo $print_url;?>";
 });
 </script>
<?php

exit;
?>
 </body>
</html>
