<?php
include_once("db/db_connect.php");
include_once('slade.php');
$results = array();
$authorization="Authorization: Bearer $slade_token";
$split_status='';

if(isset($_REQUEST['frmtype']) && $_REQUEST['frmtype']=='ip'){
   $frmtable='master_ipvisitentry';
   $service_type='INPATIENT';
}
else{
   $frmtable='master_visitentry';
   $service_type='OUTPATIENT';
}


$main_array=array();
if (isset($_REQUEST["split_status"])) { $split_status = $_REQUEST["split_status"]; } else { $split_status = ""; }
if (isset($_REQUEST["source_from"])) { $source_from = $_REQUEST["source_from"]; } else { $source_from = ""; }
if(isset($_REQUEST['id'])) { $id = $_REQUEST['id']; }
if(isset($_REQUEST['guid'])) { $guid = $_REQUEST['guid']; }
if(isset($_REQUEST['billno'])) { $billno = $_REQUEST['billno']; }
if(isset($_REQUEST['visitcode'])){
$visitcode=$_REQUEST['visitcode'];



/*
$querychk = "select claim_id from slade_claim where visitcode = '$visitcode' ";	
$execchk = mysql_query($querychk) or die ("Error in querychk".mysql_error());
$num232 = mysql_num_rows($execchk);
if($num232==0){*/

$query=mysqli_query($GLOBALS["___mysqli_ston"], "select * from $frmtable where visitcode='$visitcode'");
$rows77 = mysqli_num_rows($query);
if($rows77 > 0)
{
	$exc_rslt=mysqli_fetch_array($query);
	$patientname=$exc_rslt['patientfullname'];
	$patient_number=$exc_rslt['patientcode'];
	$member_number=$exc_rslt['savannah_authid']; 
	$memberno=$exc_rslt['memberno'];
	$visit_number=$exc_rslt['visitcode'];
	$patientsubtype=$exc_rslt['subtype'];

	$scheme_code=$exc_rslt['scheme_id'];
	$locationcode=$exc_rslt['locationcode'];
	
/*	if($source_from=='offslade')
	{
		$member_number=$memberno;
	}*/
	
	if($member_number=='')
	{
		$member_number=$memberno;
	}
	
	$queryplan1=mysqli_query($GLOBALS["___mysqli_ston"], "select locationname,address1 from master_location where locationcode='$locationcode'");
	$execplan1=mysqli_fetch_array($queryplan1);
	$location_name=$execplan1['locationname'];
	$location_code=$execplan1['address1'];

	$queryplan=mysqli_query($GLOBALS["___mysqli_ston"], "select scheme_name from master_planname where scheme_id='$scheme_code'");
	$execplan=mysqli_fetch_array($queryplan);
	$scheme_name=$execplan['scheme_name'];
	


$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select subtype,slade_payer_code from master_subtype where auto_number='$patientsubtype'");
	$execsubtype=mysqli_fetch_array($querysubtype);
	$payer_name=$execsubtype['subtype'];
	$payer_code=$execsubtype['slade_payer_code'];
	
	if($frmtable=='master_ipvisitentry')
	{
	$query28=mysqli_query($GLOBALS["___mysqli_ston"], "select finalbillno from master_ipvisitentry where visitcode='$visitcode'");
	$exc_rslt28=mysqli_fetch_array($query28);
	$billno1=$exc_rslt28['finalbillno'];
	if($billno=='')
	{
	 $billno=$billno1;	
	}
		
		
	 $query7412 = "select payer_code from billing_ipcreditapprovedtransaction where visitcode='$visitcode' and keyprovider='yes'";
	$exec7412 = mysqli_query($GLOBALS["___mysqli_ston"], $query7412) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	$num74120 = mysqli_num_rows($exec7412);
	$res7412 = mysqli_fetch_array($exec7412);
	if($num74120>0)
	{
	$split_status='yes';
	$payer_code = $res7412['payer_code'];
	
	 $querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select subtype,slade_payer_code from master_subtype where slade_payer_code='$payer_code'");
	$execsubtype=mysqli_fetch_array($querysubtype);
	$payer_name=$execsubtype['subtype'];
	}
	
	}
	else
	{
	$query28=mysqli_query($GLOBALS["___mysqli_ston"], "select billno from billing_paylater where visitcode='$visitcode'");
	$exc_rslt28=mysqli_fetch_array($query28);
	$billno=$exc_rslt28['billno'];
		
	}



    if($exc_rslt['savannahvalid_from']!='')
	  $visit_start=date("c",strtotime($exc_rslt['savannahvalid_from']));
	else
	  $visit_start=date("c",strtotime($exc_rslt['consultationdate']));

    if($exc_rslt['savannahvalid_to']!='')
	   $visit_end=date("c",strtotime($exc_rslt['savannahvalid_to']));
	else
		$visit_end=date("c",strtotime(date('Y-m-d')));
	
	$icdarray=array();

	if($service_type=='INPATIENT'){
		$query115 = "select primarydiag, primaryicdcode from discharge_icd where patientcode = '$patient_number' and patientvisitcode = '$visitcode' and primaryicdcode!='' and primaryicdcode!='undefined' ";	}
	else{
	   $query115 = "select primarydiag, primaryicdcode from consultation_icd where patientvisitcode = '$visitcode' and primaryicdcode!='' and primaryicdcode!='undefined'
		UNION ALL
		select disease as primarydiag, icdcode as primaryicdcode from consultation_icd1 where patientvisitcode = '$visitcode' and icdcode!='' and icdcode!='undefined' ";	
	}

	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num23 = mysqli_num_rows($exec115);
	if($num23>0){
		while($res115 = mysqli_fetch_array($exec115))
		{
		  $icd_code = $res115['primaryicdcode'];
		  $icdarray['code'] = substr($icd_code,0,6);	
		  $icdarray['name'] = $res115['primarydiag'];
		  if($icd_code=='' || $icd_code=='undefined'){
			  $icdarray['code'] ='R51';
	          $icdarray['name'] ='Serious Headache';
		  }
          array_push($main_array,$icdarray);
		}
	}else{
	   $icdarray['code'] ='Z04';
	   $icdarray['name'] ='Examination and observation for other reasons';
	   array_push($main_array,$icdarray);
	}

	$icd10_codes=json_encode($main_array,true);

	$data_string='{
		    "payer_code": "'.$payer_code.'",
			"payer_name": "'.$payer_name.'",
			"patient_name": "'.$patientname.'",
			"patient_number": "'.$patient_number.'",
			"member_number": "'.$member_number.'",
			"service_type": "'.$service_type.'",
			"location_code": "'.$location_code.'",
			"location_name": "'.$location_name.'",
			"scheme_code": "'.$scheme_code.'",
			"scheme_name": "'.$scheme_name.'",
			"visit_number": "'.$visit_number.'",
			"visit_start": "'.$visit_start.'",
			"visit_end": "'.$visit_end.'",
		    "icd10_codes": '.$icd10_codes.'
		 }';
	//print_r($data_string);
	//exit;
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json' , $authorization ));
	curl_setopt($curl, CURLOPT_POSTFIELDS,$data_string);
	curl_setopt($curl, CURLOPT_URL, $claim_url.'/v1/claims/?format=json');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	$result = curl_exec($curl);
	//print_r($result);
	//exit;
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
		  <title>Slade Claim</title>
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
if(isset($obj['service_type']) && ($obj['service_type']=='OUTPATIENT' || $obj['service_type']=='DENTAL' || $obj['service_type']=='OPTICAL')){
  
       
		if(isset($obj['id']) ){
            $results['id'] = $obj['id'];
			$id=$obj['id'];
		  		
			 $sql="insert into slade_claim(patientcode,visitcode,claim_id,created,service_type,claim_payload) values('".$obj['patient_number']."','".$obj['visit_number']."','".$obj['id']."','".date('Y-m-d H:i:s')."','".$obj['service_type']."','".addslashes($result)."')";
			 mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die ("Error in sql".mysqli_error($GLOBALS["___mysqli_ston"]));
			 
			  $sql1="update billing_paylater set slade_claim_id='$id' where visitcode='$visit_number' and patientcode='$patient_number'";
			 mysqli_query($GLOBALS["___mysqli_ston"], $sql1) or die ("Error in sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
			 
			 header("location:slade-invoicepost.php?billno=$billno&&visitcode=$visit_number&claim=$id");
				exit;
			          
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
		  <title>Slade Claim</title>
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
		  <title>Slade Claim</title>
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
	   else if(isset($obj['service_type']) && ($obj['service_type']=='INPATIENT')){
       
		if(isset($obj['id']) ){
            $results['id'] = $obj['id'];
			$id=$obj['id'];
		  		
			 $sql="insert into slade_claim(patientcode,visitcode,claim_id,created,service_type,claim_payload) values('".$obj['patient_number']."','".$obj['visit_number']."','".$obj['id']."','".date('Y-m-d H:i:s')."','".$obj['service_type']."','".addslashes($result)."')";
			 mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die ("Error in sql".mysqli_error($GLOBALS["___mysqli_ston"]));
			 
			 
			 if($split_status=='yes')
			 {
				 $sql1="update billing_ipcreditapproved set slade_claim_id='$id' where visitcode='$visit_number' and patientcode='$patient_number'";
			 mysqli_query($GLOBALS["___mysqli_ston"], $sql1) or die ("Error in sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
			  header("location:slade-invoiceippost_split.php?billno=$billno&&visitcode=$visit_number&claim=$id&split_status=$split_status");
				exit;
			 }
			 else
			 {
				 $sql1="update billing_ip set slade_claim_id='$id' where visitcode='$visit_number' and patientcode='$patient_number'";
			 mysqli_query($GLOBALS["___mysqli_ston"], $sql1) or die ("Error in sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
			  header("location:slade-invoiceippost.php?billno=$billno&&visitcode=$visit_number&claim=$id&split_status=$split_status");
				exit;
			 }
			
			 
			  /*$sql1="update billing_ip set slade_claim_id='$id' where visitcode='$visit_number' and patientcode='$patient_number'";
			 mysqli_query($GLOBALS["___mysqli_ston"], $sql1) or die ("Error in sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
			 
			 header("location:slade-invoiceippost.php?billno=$billno&&visitcode=$visit_number&claim=$id");
				exit;*/
			          
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
		  <title>Slade Claim</title>
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
		  <title>Slade Claim</title>
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
		  <title>Slade Claim</title>
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

	
	}else{
	  $results['error'] = 'Must have visit code';
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
		  <title>Slade Claim</title>
		   <link rel="stylesheet" href="css/sweetalert-min.css">
		  <script src="js/sweetalert.min.js"> </script>
		 </head>
		 <body>
		 <script>
		  swal({
		  title: "Medbot Error : <?php echo $results['error'];?>",
		  type: "success"
		  }).then(function() {
			window.location = "<?php echo $print_url;?>";
		 });
		 </script>
		<?php
	}
/*}
else{
  $execchk_rslt=mysql_fetch_array($execchk);
  $results['claim_id'] = $execchk_rslt['claim_id'];
}*/
}else{
  $results['error'] = 'Invalid visit code';
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
		  <title>Slade Claim</title>
		   <link rel="stylesheet" href="css/sweetalert-min.css">
		  <script src="js/sweetalert.min.js"> </script>
		 </head>
		 <body>
		 <script>
		  swal({
		  title: "Medbot Error : <?php echo $results['error'];?>",
		  type: "success"
		  }).then(function() {
			window.location = "<?php echo $print_url;?>";
		 });
		 </script>
		<?php
}

echo json_encode($results);
exit;
?>