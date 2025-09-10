<?php
include ("db/db_connect.php");
$results = array();
$slade_token='OTIxN2Y5YWJhNWRkOWZlNUlELTZjZTA5NWZlNWQwOTQ2YTJhODczMDc5Y2Q2MGRlMDcy';
$invoice_arry=array();
$inv_rslt=array();
$inv_line=array();
$messages=array();
$invoice_url='https://bulkdev.swifttdial.com:2778/api/outbox/create';
$j=1;
$query4 = "select profile_code from master_company where profile_code!=''";
$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
$res4 = mysqli_fetch_array($exec4);
$profile_code = $res4['profile_code'];
if($profile_code=='')
{
$profile_code="2201194";
}

$desc1="Thank you for visiting RFH Healthcare.We value you feedback and would love to hear from you on the link below. https://qsysfeedbacksystemv2.qsys-ea.com/feedback-branches/6423fd17a0202.
Our helpline is always open to you 0111033800 #RFHHEALTHCARE #CHANGINGMEDICINE-TOUCHINGLIVES";

if($recipient!='')
{
if(strlen($desc1) > 185){

    $desc = str_split($desc1 , 185); 
    $how_many = count($desc);
    foreach($desc as $index => $desc){

$authorization="Authorization: Bearer $slade_token";


$call_back='https://posthere.io/';

    $invoice_arry["profile_code"]=$profile_code;
			
	$inv_line =  array(
		
	["recipient" => $recipient,
	"message" => $desc,
	"message_type"=>1,
	"req_type" => 1,
	"external_id"=>001]
	);
	$invoice_arry["messages"]=$inv_line;
	$invoice_arry["dlr_callback_url"]=$call_back;
$post_datas=json_encode($invoice_arry);

$headers = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $slade_token,
    'X-API-Key: ' . $slade_token
];

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_SAFE_UPLOAD, false);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_HTTPHEADER,$headers);
	
	curl_setopt($curl, CURLOPT_POSTFIELDS,$post_datas);
	curl_setopt($curl, CURLOPT_URL, $invoice_url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	$result = curl_exec($curl);
    print_r($result);
    }
}
else{

   $authorization="Authorization: Bearer $slade_token";
//$profile_code="2201194";
//$recipient='254789999990';
$call_back='https://posthere.io/';

    $invoice_arry["profile_code"]=$profile_code;
			
	$inv_line =  array(
		
	["recipient" => $recipient,
	"message" => $desc,
	"message_type"=>1,
	"req_type" => 1,
	"external_id"=>001]
	);
	$invoice_arry["messages"]=$inv_line;
	$invoice_arry["dlr_callback_url"]=$call_back;
$post_datas=json_encode($invoice_arry);

$headers = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $slade_token,
    'X-API-Key: ' . $slade_token
];

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_SAFE_UPLOAD, false);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_HTTPHEADER,$headers);
	
	curl_setopt($curl, CURLOPT_POSTFIELDS,$post_datas);
	curl_setopt($curl, CURLOPT_URL, $invoice_url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	$result = curl_exec($curl);
	
}
}
