<?php
include_once("db/db_connect.php");
include_once('slade.php');
$results = array();
$authorization="Authorization: Bearer $slade_token";

if(isset($_REQUEST['frmtype']) && $_REQUEST['frmtype']=='ip'){
   $frmtable='master_ipvisitentry';
   $service_type='INPATIENT';
}
else{
   $frmtable='master_visitentry';
   $service_type='OUTPATIENT';
}

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
	$visit_number=$exc_rslt['visitcode'];
	$patientsubtype=$exc_rslt['subtype'];

	$scheme_code=$exc_rslt['accountname'];

	$queryplan=mysqli_query($GLOBALS["___mysqli_ston"], "select accountname from master_accountname where auto_number='$scheme_code'");
	$execplan=mysqli_fetch_array($queryplan);
	$scheme_name=$execplan['accountname'];

	$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select subtype,slade_payer_code from master_subtype where auto_number='$patientsubtype'");
	$execsubtype=mysqli_fetch_array($querysubtype);
	$payer_name=$execsubtype['subtype'];
	$payer_code=$execsubtype['slade_payer_code'];

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
		$query115 = "select primarydiag, primaryicdcode from discharge_icd where patientcode = '$patient_number' and patientvisitcode = '$visitcode' and primaryicdcode!='' and primaryicdcode!='undefined' order by auto_number desc limit 0,1";	}
	else{
	    $query115 = "select primarydiag, primaryicdcode from consultation_icd where patientvisitcode = '$visitcode' and primaryicdcode!='' and primaryicdcode!='undefined' order by auto_number desc limit 0,1";	
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
			  $icdarray['code'] ='Z04';
	          $icdarray['name'] ='Examination and observation for other reasons';
		  }

		}
	}else{
	   $icdarray['code'] ='Z04';
	   $icdarray['name'] ='Examination and observation for other reasons';
	}

	$icd10_codes="[".json_encode($icdarray,true)."]";

	echo $data_string='{
			"patient_name": "'.$patientname.'",
			"patient_number": "'.$patient_number.'",
			"member_number": "'.$member_number.'",
			"visit_number": "'.$visit_number.'",
			"scheme_code": "'.$scheme_code.'",
			"scheme_name": "'.$scheme_name.'",
			"payer_name": "'.$payer_name.'",
			"payer_code": "'.$payer_code.'",
			"visit_start": "'.$visit_start.'",
			"visit_end": "'.$visit_end.'",
			"service_type": "'.$service_type.'",
			"icd10_codes": '.$icd10_codes.'
		 }';

	
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json' , $authorization ));
	curl_setopt($curl, CURLOPT_POSTFIELDS,$data_string);
	curl_setopt($curl, CURLOPT_URL, $claim_url.'/v1/claims/?format=json');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	$result = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);    

	if ($err) {
	   $results['error'] = $err_unable_connect;
	}else{

		$obj=json_decode($result,true);
		print_r($obj);
       
		if(isset($obj['id']) ){
            $results['claim_id'] = $obj['id'];
		  		
			 $sql="insert into slade_claim(patientcode,visitcode,claim_id,created,service_type,claim_payload) values('".$obj['patient_number']."','".$obj['visit_number']."','".$obj['id']."','".date('Y-m-d H:i:s')."','".$obj['service_type']."','".addslashes($result)."')";
			 mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die ("Error in sql".mysqli_error($GLOBALS["___mysqli_ston"]));
			          
		}
		elseif(isset($obj['status']) && $obj['status']=='Failure'){
		  $results['error'] = $obj['message'];
		}
		else{
		  $results['error'] = 'Invalid Information';
		}
	}

	
	}else{
	  $results['error'] = 'Must have visit code';
	}
/*}
else{
  $execchk_rslt=mysql_fetch_array($execchk);
  $results['claim_id'] = $execchk_rslt['claim_id'];
}*/
}else{
  $results['error'] = 'Invalid visit code';
}

echo json_encode($results);
exit;
?>