<?php
header("Content-Type:application/json");

$hostname = '127.0.0.1';
$hostlogin = 'root';
$hostpassword = '@spyc3@1ct@2019';
$databasename = 'premier';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  $data = json_decode(file_get_contents("php://input"));

  $key ="3C3uaCdBHaYpLalLLiSadUOah8DvhwI/qTCbq0Ra11s=";

  if(isset($data->userId) && isset($data->userPassword) && isset($data->apiKey) && isset($data->ipAddress) && $data->apiKey==$key ){

	$userId= addslashes($data->userId);
	$userPassword= base64_encode(addslashes($data->userPassword));
	$apiKey = $data->apiKey;
	$ipAddress = $data->ipAddress;
	$created_at = date('Y-m-d H:i:s');
	$updated_at = date('Y-m-d H:i:s');

	$link = ($GLOBALS["___mysqli_ston"] = mysqli_connect($hostname, $hostlogin, $hostpassword)) or die('Could not connect Table : ' . mysqli_error($GLOBALS["___mysqli_ston"]));
	mysqli_select_db($GLOBALS["___mysqli_ston"], $databasename) or die('Could not select database'. mysqli_error($GLOBALS["___mysqli_ston"]));

	$query = "INSERT INTO `fingerprint_login_details`(`user_name`, `password`, `api_key`, `ipaddress`,`created_at`, `updated_at`)
	values('$userId', '$userPassword', '$apiKey', '$ipAddress', '$created_at', '$updated_at')";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));

	$query_check = "select auto_number,biometric from `master_employee` where username = '$userId' and password = '$userPassword' and status = 'ACTIVE'";
	$exec_check = mysqli_query($GLOBALS["___mysqli_ston"], $query_check) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rowcount_check = mysqli_num_rows($exec_check);
	$fetch_rows = mysqli_fetch_array($exec_check);

		if($rowcount_check>0){

                      if($fetch_rows['biometric']=="0"){
 			 response(400,"You don’t have access to use this application, please contact administrator.");
                        }else{
		 	 response(200,"Success");		
                        }
		}else{
			response(400,"Invalid username or password.");
		}
	
	}else{

		response(400,"Invalid Request");
	}

}else{
		response(400,"Invalid Request");
}

function response($status,$status_message)
{
        header("HTTP/1.1 ".$status.' '.$status_message);
	
	$response['status']=$status;
	$response['status_message']=$status_message;
	
	$json_response = json_encode($response);
	echo $json_response;
}

?>