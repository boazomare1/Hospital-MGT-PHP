<?php
include_once("slade-invoiceip_split.php");
$cbfrmflag1='cbfrmflag1';
$print_url="ipbilling.php?billnumber=$billno&savedpatientcode=$patientcode&&savedvisitcode=$visitcode&&cbfrmflag1=$cbfrmflag1";
if($inv_rslt['status']=='Success'){
	
	/*echo 'billno-->'.$billno;
	echo 'visit_number-->'.$visit_number;
	echo 'visitcode-->'.$visitcode;
	echo 'id-->'.$id;
	echo 'authorization-->'.$authorization;
	echo 'invoice_attach_url-->'.$invoice_attach_url;
	exit; */
header("location:slade-invoicepostippdf_split.php?billautonumber=$billno&&visitcode=$visitcode&claim=$id&auth=$authorization&invoice_url=$invoice_attach_url&patientcode=$patientcode");
exit;
//header("location:ipbilling.php?billnumber=$billno&savedpatientcode=$patientcode&&savedvisitcode=$visitcode");
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
  <title>IP Final Invoice</title>
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
