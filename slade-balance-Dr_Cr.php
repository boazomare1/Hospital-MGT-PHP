<?php
include_once('slade.php');
$results = array();
$authorization="Authorization: Bearer $slade_token";
$authorization_id="";
$amount="";
$invoice_number="";
$billno="";
$type="";
if(isset($_REQUEST['billno'])) { $billno = $_REQUEST['billno']; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST['visitcode']; }
if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST['patientcode']; }
if(isset($_REQUEST['authorization_id']) && $_REQUEST['authorization_id']!='')
  $authorization_id=$_REQUEST['authorization_id'];
 if(isset($_REQUEST['source'])) { $source = $_REQUEST['source']; }

if(isset($_REQUEST['locationcode']) && $_REQUEST['locationcode']!='')
  $locationcode=$_REQUEST['locationcode'];
if(isset($_REQUEST['billno'])) { $billno = $_REQUEST['billno']; }
if(isset($_REQUEST['mainsource'])) { $mainsource = $_REQUEST['mainsource']; } 
if(isset($_REQUEST['docno'])) { $docno = $_REQUEST['docno']; } 
if($source=='credit')
{
header("location:print_adhoc_creditnote_slade_linewise.php?billautonumber=$billno&&visitcode=$visitcode&claim=$id&auth=$authorization_id&locationcode=$locationcode&patientcode=$patientcode&billno=$docno");
exit;	
}
else if($source=='debit')
{

header("location:print_adhoc_debitnote_slade_linewise.php?billautonumber=$billno&&visitcode=$visitcode&claim=$id&auth=$authorization_id&locationcode=$locationcode&patientcode=$patientcode&billno=$docno");
exit;	
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

$err = curl_error($curl);
curl_close($curl);
if ($err) {
   $results['error'] = $err_unable_connect;
  
}else{

	$obj=json_decode($result,true);
   
	if(isset($obj['id']) && $obj['id']!=''){
	
     if($type=='ip'){
	
		if(isset($obj['benefit']) && ($obj['benefit']=='INPATIENT' || $obj['benefit']=='MATERNITY')){
			$id=$obj['id'];
		$guid=$obj['guid'];
				$results['id'] =$obj['id'];
				$results['guid'] =$obj['guid'];
			header("location:slade-claim.php?id=$id&&patientcode=$patientcode&&visitcode=$visitcode&&guid=$guid&&billno=$billno&&frmtype=$type");
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
			header("location:slade-claim.php?id=$id&&patientcode=$patientcode&&visitcode=$visitcode&&guid=$guid&&billno=$billno&&frmtype=$source");				
				//$results['visit_limit'] =80000;

		}else{
		   $results['error'] = 'OUTPATIENT ONLY';
		}

	 }


	}
	elseif(isset($obj['status']) && $obj['status']=='Failure'){
	  $results['error'] = $obj['message'];
	}
	elseif(isset($obj['first_name'])){
	  $results['error'] = "First Name may not be blank";
	}
    elseif(isset($obj['last_name'])){
	  $results['error'] = "Last Name may not be blank";
	}
	else{
	  $results['error'] = 'Invalid Information';
	}
}
echo json_encode($results);
exit;

?>