<?php
if(isset($_REQUEST['printno'])){
	$printno=$_REQUEST['printno'];
	$url="deliveryreportsubtypeprint.php?st=printsuccess&&printno=".$printno;
?>
<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>Dispatch Invoice</title>
   <link rel="stylesheet" href="css/sweetalert-min.css">
  <script src="js/sweetalert.min.js"> </script>
 </head>
 <body>
 <script>
  swal({
  text: "There is a Problem Uploading Some claim/invoice to Slade, please re-upload again under 'Reprint Dispatch Report' Module",
  type: "success"
  }).then(function() {
    window.location = "<?php echo $url;?>";
 });
 </script>
<?php
}
else
header("location:deliveryreportsubtypeprint.php");

exit;
?>
 </body>
</html>
