<?php
include_once('slade.php');
$results = array();
$authorization="Authorization: Bearer $slade_token";
$authorization_id="";
$amount="";
$invoice_number="";
$billno="";
$type="";
if(isset($_REQUEST['split_status'])) { $split_status = $_REQUEST['split_status']; }
if(isset($_REQUEST['billautonumber'])) { $billno = $_REQUEST['billautonumber']; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST['visitcode']; }
if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST['patientcode']; }
if(isset($_REQUEST['authorization_id']) && $_REQUEST['authorization_id']!='')
  $authorization_id=$_REQUEST['authorization_id'];
if(isset($_REQUEST['amount']) && $_REQUEST['amount']!='')
  $amount=$_REQUEST['amount'];
if(isset($_REQUEST['invoice_number']) && $_REQUEST['invoice_number']!='')
  $invoice_number=$_REQUEST['invoice_number'];
  if(isset($_REQUEST['source']) && $_REQUEST['source']!='') $type=$_REQUEST['source'];
  if($type=='')
  {
  if(isset($_REQUEST['type']) && $_REQUEST['type']!='') $type=$_REQUEST['type'];
  }

if($type!='ip')
{
   $query12 = "select * from billing_paylater where  billno='$billno'";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num12=mysqli_num_rows($exec12);
	$res12 = mysqli_fetch_array($exec12);
	$patientname=$res12['patientname'];
	$patientcode=$res12['patientcode'];
	$visitcode=$res12['visitcode'];
}
$data_string='{
        "authorization": "'.$authorization_id.'",
        "amount": "'.$amount.'",
        "invoice_number": "'.$billno.'"
     }';

$curl = curl_init();
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json' , $authorization ));
curl_setopt($curl, CURLOPT_POSTFIELDS,$data_string);
curl_setopt($curl, CURLOPT_URL, $balance_reservations_id.'/v1/balances/reservations/reserve_from_authorization/?format=json');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
$result = curl_exec($curl);
/*print_r($result);
exit;*/
$err = curl_error($curl);
curl_close($curl);
if ($err) {
   $results['error'] = $err_unable_connect;
  $print_url="slade_reposting.php";  
?>
  <!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus�">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>Balance Reservations</title>
   <link rel="stylesheet" href="css/sweetalert-min.css">
  <script src="js/sweetalert.min.js"> </script>
 </head>
 <body>
 <script>
  swal({
  title: "Slade Error : <?php echo $results['error'];?>",
  type: "success"
  }).then(function() {
    window.location = "<?php echo $print_url;?>";
 });
 </script>
<?php
}else{

	$obj=json_decode($result,true);
   
	if(isset($obj['id']) && $obj['id']!=''){
	
     if($type=='ip'){
	
		if(isset($obj['benefit']) && ($obj['benefit']=='INPATIENT' || $obj['benefit']=='MATERNITY' || $obj['benefit']=='DENTAL')){
			$id=$obj['id'];
		$guid=$obj['guid'];
				$results['id'] =$obj['id'];
				$results['guid'] =$obj['guid'];
			header("location:slade-claim.php?id=$id&&patientcode=$patientcode&&visitcode=$visitcode&&guid=$guid&&billno=$billno&&frmtype=$type&&split_status=$split_status");
				//$results['visit_limit'] =80000;


		}else{
		   $results['error'] = 'INPATIENT ONLY';
		}
	 }else{
		

       if(isset($obj['benefit']) && ($obj['benefit']=='OUTPATIENT' || $obj['benefit']=='DENTAL' || $obj['benefit']=='OPTICAL')){
		$id=$obj['id'];
		$guid=$obj['guid'];
		$source='op';
					/*code added by murali*/
				$results['id'] =$obj['id'];
				$results['guid'] =$obj['guid'];
				
//$sql="insert into slade_claim(patientcode,visitcode,claim_id,created,service_type,balance_reservations) values('$patientcode','$visitcode','".$obj['id']."','".date('Y-m-d H:i:s')."','".$obj['benefit']."','".addslashes($result)."')";
//mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die ("Error in sql".mysqli_error($GLOBALS["___mysqli_ston"]));

			header("location:slade-claim.php?id=$id&&patientcode=$patientcode&&visitcode=$visitcode&&guid=$guid&&billno=$billno&&frmtype=$source");				
				//$results['visit_limit'] =80000;

		}else{
		   $results['error'] = 'OUTPATIENT ONLY';
		}

	 }


	}
	elseif(isset($obj['status']) && $obj['status']=='Failure'){
	  $results['error'] = $obj['message'];
	  $print_url="slade_reposting.php";  
	?>
	<!doctype html>
	<html lang="en">
	<head>
	<meta charset="UTF-8">
	<meta name="Generator" content="EditPlus�">
	<meta name="Author" content="">
	<meta name="Keywords" content="">
	<meta name="Description" content="">
	<title>Balance Reservations</title>
	<link rel="stylesheet" href="css/sweetalert-min.css">
	<script src="js/sweetalert.min.js"> </script>
	</head>
	<body>
	<script>
	swal({
	title: "Slade Error : <?php echo $results['error'];?>",
	type: "success"
	}).then(function() {
	window.location = "<?php echo $print_url;?>";
	});
	</script>
	<?php
	}
	elseif(isset($obj['first_name'])){
	  $results['error'] = "First Name may not be blank";
	  $print_url="slade_reposting.php";  
	?>
	<!doctype html>
	<html lang="en">
	<head>
	<meta charset="UTF-8">
	<meta name="Generator" content="EditPlus�">
	<meta name="Author" content="">
	<meta name="Keywords" content="">
	<meta name="Description" content="">
	<title>Balance Reservations</title>
	<link rel="stylesheet" href="css/sweetalert-min.css">
	<script src="js/sweetalert.min.js"> </script>
	</head>
	<body>
	<script>
	swal({
	title: "Slade Error : <?php echo $results['error'];?>",
	type: "success"
	}).then(function() {
	window.location = "<?php echo $print_url;?>";
	});
	</script>
	<?php
	}
    elseif(isset($obj['last_name'])){
	  $results['error'] = "Last Name may not be blank";
	  $print_url="slade_reposting.php";  
	?>
	<!doctype html>
	<html lang="en">
	<head>
	<meta charset="UTF-8">
	<meta name="Generator" content="EditPlus�">
	<meta name="Author" content="">
	<meta name="Keywords" content="">
	<meta name="Description" content="">
	<title>Balance Reservations</title>
	<link rel="stylesheet" href="css/sweetalert-min.css">
	<script src="js/sweetalert.min.js"> </script>
	</head>
	<body>
	<script>
	swal({
	title: "Slade Error : <?php echo $results['error'];?>",
	type: "success"
	}).then(function() {
	window.location = "<?php echo $print_url;?>";
	});
	</script>
	<?php
	}
	else{
	  $results['error'] = 'Invalid Information';
	  $print_url="slade_reposting.php";  
	?>
	<!doctype html>
	<html lang="en">
	<head>
	<meta charset="UTF-8">
	<meta name="Generator" content="EditPlus�">
	<meta name="Author" content="">
	<meta name="Keywords" content="">
	<meta name="Description" content="">
	<title>Balance Reservations</title>
	<link rel="stylesheet" href="css/sweetalert-min.css">
	<script src="js/sweetalert.min.js"> </script>
	</head>
	<body>
	<script>
	swal({
	title: "Slade Error : <?php echo $results['error'];?>",
	type: "success"
	}).then(function() {
	window.location = "<?php echo $print_url;?>";
	});
	</script>
	<?php
	}
}
echo json_encode($results);
exit;

?>