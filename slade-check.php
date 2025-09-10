<?php
include_once('slade.php');
$results = array();
$authorization="Authorization: Bearer $slade_token";

$first_name="";
$last_name="";
$auth_token="";
$member_number="";
$type="op";

if(isset($_REQUEST['first_name']) && $_REQUEST['first_name']!='')
  $first_name=$_REQUEST['first_name'];
if(isset($_REQUEST['last_name']) && $_REQUEST['last_name']!='')
  $last_name=$_REQUEST['last_name'];
if(isset($_REQUEST['auth_token']) && $_REQUEST['auth_token']!='')
  $auth_token=$_REQUEST['auth_token'];
if(isset($_REQUEST['type']) && $_REQUEST['type']!='')
  $type=$_REQUEST['type'];
if(isset($_REQUEST['member_number']) && $_REQUEST['member_number']!='')
  $member_number=$_REQUEST['member_number'];
$data_string='{
        "first_name": "'.$first_name.'",
        "last_name": "'.$last_name.'",
        "auth_token": "'.$auth_token.'",
		"member_number": "'.$member_number.'"
     }';

//$claim_url='https://is-api.multitenant.slade360.co.ke';
/*echo $claim_url;
print_r($data_string);
echo $authorization;
exit;*/
$curl = curl_init();
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json' , $authorization ));
curl_setopt($curl, CURLOPT_POSTFIELDS,$data_string);
curl_setopt($curl, CURLOPT_URL, $claim_url.'/v1/authorizations/validate_authorization_token/?format=json');
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
  
}else{

	$obj=json_decode($result,true);

	if(isset($obj['status']) && $obj['status']=='Success'){
     if($type=='ip'){
		if(isset($obj['service_type']) && ($obj['service_type']=='INPATIENT' || $obj['service_type']=='MATERNITY' || $obj['service_type']=='DENTAL' )){
			if(isset($obj['benefit_balance']) && $obj['benefit_balance']>0){
				$results['status'] = $obj['status'];
				$results['has_op'] = 'Y';			
				$results['valid_from'] = date('Y-m-d H:i:s',strtotime($obj['authorization_date']));
				$results['valid_to'] = date('Y-m-d H:i:s',strtotime($obj['auth_expiry']));
				$results['slade_authentication_token'] = trim($result);
				$results['member_number'] =trim($obj['member_number']);
				$results['visit_limit'] =trim($obj['benefit_balance']);
				//$results['visit_limit'] =80000;

			}
			else{
		      $results['error'] = 'Insufficient benefit balance';
			}

		}else{
		   $results['error'] = 'INPATIENT ONLY';
		}
	 }else{
       if(isset($obj['service_type']) && ($obj['service_type']=='OUTPATIENT' || $obj['service_type']=='DENTAL' || $obj['service_type']=='OPTICAL')){
			if(isset($obj['benefit_balance']) && $obj['benefit_balance']>0){
				$results['status'] = $obj['status'];
				/*code added by murali*/
				$results['planfixedamount'] =$obj['copay_value'];
				$results['view_reserved_amount'] =$obj['reserved_amount'];
				$results['authorization_guid'] =$obj['authorization_guid'];
				/*code added by murali ends here*/
				$results['has_op'] = 'Y';			
				$results['valid_from'] = date('Y-m-d H:i:s',strtotime($obj['authorization_date']));
				$results['valid_to'] = date('Y-m-d H:i:s',strtotime($obj['auth_expiry']));
				$results['slade_authentication_token'] = trim($result);
				$results['member_number'] =trim($obj['member_number']);
				$results['visit_limit'] =trim($obj['benefit_balance']);
				
				//$results['visit_limit'] =80000;

			}
			else{
		      $results['error'] = 'Insufficient benefit balance';
			}

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