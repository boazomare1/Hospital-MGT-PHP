<?php
include_once("db/db_connect.php");
include_once('slade.php');
$authorization="Authorization: Bearer $slade_token";
$billno ="";
$visitcode ="";
$claim ="";
$invoice_arry=array();
if(isset($_REQUEST['billno'])) { $billno = $_REQUEST['billno']; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST['visitcode']; }
if(isset($_REQUEST['claim'])) { $claim = $_REQUEST['claim']; }
$inv_rslt=array();
$inv_line=array();
echo $query7 = "select * from billing_ip where visitcode = '$visitcode' and billno='$billno' and slade_status!='completed' and slade_claim_id='$claim'";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
$num232 = mysqli_num_rows($exec7);
$sno=1;
$j=0;
if($num232>0){

	$res7 = mysqli_fetch_array($exec7);
	$claim_payload=$res7['smartxml'];
	 
	$inv_send=stripslashes($claim_payload);;
	

	//$query8 = "update billing_paylater set smartxml='".addslashes($inv_send)."' where visitcode = '$visitcode' ";
    //$exec8 = mysql_query($query8);

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json' , $authorization ));
	curl_setopt($curl, CURLOPT_POSTFIELDS,$inv_send);
	curl_setopt($curl, CURLOPT_URL, $claim_url.'/v1/invoices/?format=json');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	$result = curl_exec($curl);	
	$err = curl_error($curl);

	curl_close($curl);
	print_r($err);
	if ($err) {
	   $inv_rslt['status'] = 'Faild';
	   $inv_rslt['msg'] = $err_unable_connect;
	}else{
		$obj=json_decode($result,true);
		if(isset($obj['id'])){
            $query8 = "update billing_ip set slade_status='completed' where visitcode = '$visitcode' ";
            $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8);
			$query8 = "update slade_claim set invoice_payload='".addslashes($result)."',updated='".date('Y-m-d H:i:s')."' where visitcode = '$visitcode' and claim_id='".$res7['slade_claim_id']."'";
            $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8);
			$inv_rslt['status'] = 'Success';
            $inv_rslt['msg'] = $err_post_success;
		}else{
		  $query8 = "update slade_claim set invoice_payload='".addslashes($result)."',updated='".date('Y-m-d H:i:s')."' where visitcode = '$visitcode' and claim_id='".$res7['slade_claim_id']."'";
            $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8);
          $inv_rslt['status'] = 'Faild';
	      $inv_rslt['msg'] = $err_faild_repost;
		}
	}

	

}else{
  $inv_rslt['status']='Faild';
  $inv_rslt['msg']='Invalid/Already completed.';
}

echo json_encode($inv_rslt);
?>