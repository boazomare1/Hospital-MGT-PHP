<?php
include ("db/db_connect.php");
$results = array();

$err_unable_connect="Unable to connect slade server or Invalid url access.";
$err_faild_repost='Unable to post bill against the claim, please repost the bill later.';
$err_post_success='Successfully posted invoice against the claim.';

 $query1 = "select * from master_slade where  id='1'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);

$api_url=$res1['api_url'];
$balance_reservations_id=$res1['balance_reservations_id'];
$claim_url=$res1['claim_url'];
$invoice_url=$res1['invoice_url'];
$invoice_attach_url=$res1['invoice_attach_url'];
$client_id=$res1['client_id'];
$client_secret=$res1['client_secret'];
$username=$res1['username'];
$password=$res1['password'];
 $refresh_token=$res1['refresh_token'];
$access_token=$res1['access_token'];
$created_at_token=$res1['creadte_at'];
$valid_up_to=strtotime("$created_at_token +1 hours");
$current_time=time();

/*echo date('Y-m-d H:i:s',$valid_up_to).'-'.date('Y-m-d H:i:s',$current_time);
echo 'ref-->'. $refresh_token.'access-->'.$access_token.'created'.$created_at_token;*/
if(($refresh_token=='' || $access_token=='') || $created_at_token==''){

	$url = $api_url.'/oauth2/token/';
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	$curl_post_data = array(
			 'client_id' => $client_id,
			 'client_secret' => $client_secret,
			 'grant_type' => 'password',
			 'username' => $username,
			 'password' => $password, 
		);

	$data_string='';
	foreach($curl_post_data as $key=>$value) { $data_string .= $key.'='.$value.'&'; }
	rtrim($data_string, '&');

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	$curl_response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	if ($err) {
       $results['error'] = $err_unable_connect;
	   echo json_encode($results);
	   exit;
	}else{
		$obj=json_decode($curl_response);
		if(isset($obj->error)){
           $results['error'] = $obj->error_description;
	       echo json_encode($results);
	       exit;
		}else{
			$slade_token= $obj->access_token;
			$refresh_token= $obj->refresh_token;
			if(isset($slade_token) && $slade_token!=''){
				$sql1="update master_slade set access_token='$slade_token',refresh_token='$refresh_token',creadte_at='".date('Y-m-d H:i:s')."' where id=1";
				mysqli_query($GLOBALS["___mysqli_ston"], $sql1);
			}
		}
	}
}
else if($current_time>$valid_up_to)
{

	
	//$slade_token= $access_token;
	//$refresh_token= $refresh_token;
	

      $url = $api_url.'/oauth2/token/';
	
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	$curl_post_data = array(
			'client_id' => $client_id,
			 'client_secret' => $client_secret,
			 'grant_type' => 'password',
			 'username' => $username,
			 'password' => $password, 
		);

	$data_string='';
	foreach($curl_post_data as $key=>$value) { $data_string .= $key.'='.$value.'&'; }
	rtrim($data_string, '&');

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
	
	$curl_response = curl_exec($curl);
	
	$err = curl_error($curl);
	curl_close($curl);
	if ($err) {
       $results['error'] = $err_unable_connect;
	}else{
		$obj=json_decode($curl_response);
		if(isset($obj->error)){
		 if($obj->error=='invalid_grant'){
            $url = $api_url.'/oauth2/token/';
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			$curl_post_data = array(
					 'client_id' => $client_id,
					 'client_secret' => $client_secret,
					 'grant_type' => 'password',
					 'username' => $username,
					 'password' => $password, 
				);

			$data_string='';
			foreach($curl_post_data as $key=>$value) { $data_string .= $key.'='.$value.'&'; }
			rtrim($data_string, '&');

			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
			$curl_response = curl_exec($curl);
			
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
			   $results['error'] = $err_unable_connect;
			   echo json_encode($results);
			   exit;
			}else{
				$obj=json_decode($curl_response);
				if(isset($obj->error)){
				   $results['error'] = $obj->error_description;
				   echo json_encode($results);
				   exit;
				}else{
					$slade_token= $obj->access_token;
					$refresh_token= $obj->refresh_token;
					if(isset($slade_token) && $slade_token!=''){
						$sql="update master_slade set access_token='$slade_token',refresh_token='$refresh_token',creadte_at='".date('Y-m-d H:i:s')."' where id='1'";
						mysqli_query($GLOBALS["___mysqli_ston"], $sql);
					}
				}
			}
		 }else{
			 $results['error'] = $obj->error;
			 echo json_encode($results);
			 exit;
		 }
		}else{
			$slade_token= $obj->access_token;
			$refresh_token= $obj->refresh_token;
			if(isset($slade_token) && $slade_token!=''){
				$sql="update master_slade set access_token='$slade_token',refresh_token='$refresh_token',creadte_at='".date('Y-m-d H:i:s')."' where id='1'";
				mysqli_query($GLOBALS["___mysqli_ston"], $sql);
			}
		}
	}


}
else if($current_time<=$valid_up_to)
{

$slade_token= $access_token;
$refresh_token= $refresh_token;

   /*  $url = $api_url.'/oauth2/token/';
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	$curl_post_data = array(
			
			          'client_id' => $client_id,
					 'client_secret' => $client_secret,
					 'grant_type' => 'password',
					 'username' => $username,
					 'password' => $password, 
		);
	$data_string='';
	
	foreach($curl_post_data as $key=>$value) { $data_string .= $key.'='.$value.'&'; }
	rtrim($data_string, '&');

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
	$curl_response = curl_exec($curl);
	
	$err = curl_error($curl);
	curl_close($curl);
	if ($err) {
       $results['error'] = $err_unable_connect;
	}else{
		$obj=json_decode($curl_response);
		if(isset($obj->error)){
		 if($obj->error=='invalid_grant'){
            $url = $api_url.'/oauth2/token/';
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			$curl_post_data = array(
					 'client_id' => $client_id,
					 'client_secret' => $client_secret,
					 'grant_type' => 'password',
					 'username' => $username,
			         'password' => $password, 
				
				);
             
			$data_string='';
			foreach($curl_post_data as $key=>$value) { $data_string .= $key.'='.$value.'&'; }
			rtrim($data_string, '&');

			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
			$curl_response = curl_exec($curl);
			
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
			   $results['error'] = $err_unable_connect;
			   echo json_encode($results);
			   exit;
			}else{
				$obj=json_decode($curl_response);
				if(isset($obj->error)){
				   $results['error'] = $obj->error_description;
				   echo json_encode($results);
				   exit;
				}else{
					$slade_token= $obj->access_token;
					$refresh_token= $obj->refresh_token;
					if(isset($slade_token) && $slade_token!=''){
						$sql="update master_slade set access_token='$slade_token',refresh_token='$refresh_token',creadte_at='".date('Y-m-d H:i:s')."' where id='1'";
						mysqli_query($GLOBALS["___mysqli_ston"], $sql);
					}
				}
			}
		 }else{
			 $results['error'] = $obj->error;
			 echo json_encode($results);
			 exit;
		 }
		}else{
			$slade_token= $obj->access_token;
			$refresh_token= $obj->refresh_token;
			if(isset($slade_token) && $slade_token!=''){
				$sql="update master_slade set access_token='$slade_token',refresh_token='$refresh_token',creadte_at='".date('Y-m-d H:i:s')."' where id='1'";
				mysqli_query($GLOBALS["___mysqli_ston"], $sql);
			}
		}
	}*/
}
/*else{
  $slade_token= $access_token;
}*/
?>
