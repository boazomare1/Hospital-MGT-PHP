<?php
include_once("slade-invoice.php");
$print_url="billing_pending_op2.php?billautonumber=$billno&&st=success&&printbill=$billno";
if($inv_rslt['status']=='Success'){
header("location:slade-invoicepostpdf.php?billautonumber=$billno&&visitcode=$visit_number&claim=$id&auth=$authorization&invoice_url=$invoice_attach_url");
exit;
/*header("location:billing_pending_op2.php?billautonumber=$billno&&st=success&&printbill=$billno");
exit;*/
}else{
?>
<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus�">
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
  title: "Claim ID : <?php echo $_REQUEST['claim'];?>",
  text: "<?php echo $inv_rslt['msg'];?>",
  type: "success"
  }).then(function() {
    window.location = "<?php echo $print_url;?>";
 });
 </script>
<?php
}
//header("location:billing_pending_op2.php?billautonumber=$billno&&st=success&&printbill=$billno");
exit;
?>
 </body>
</html>
