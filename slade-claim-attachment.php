<?php
include_once("db/db_connect.php");
include_once('slade.php');
$results = array();
$authorization="Authorization: Bearer $slade_token";

if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_REQUEST["source"])) { $source = $_REQUEST["source"]; } else { $source = ""; }
if (isset($_REQUEST["get_file"])) { $get_file = $_REQUEST["get_file"]; } else { $get_file = ""; }
if (isset($_REQUEST["get_dis_summ"])) { $get_dis_summ = $_REQUEST["get_dis_summ"]; } else { $get_dis_summ = ""; }
if (isset($_REQUEST["source"])) { $source = $_REQUEST["source"]; } else { $source = ""; }
if (isset($_REQUEST["billno"])) { $billno = $_REQUEST["billno"]; } else { $billno = ""; }
if (isset($_REQUEST["mainsource"])) { $mainsource = $_REQUEST["mainsource"]; } else { $mainsource = ""; }
if($mainsource=='claimform')
{
$fileName = $_FILES['file']['name'];
$tmpName  = $_FILES['file']['tmp_name'];
$fileSize = $_FILES['file']['size'];
$fileType = $_FILES['file']['type'];

if(!empty($fileName) && ($fileSize>0)){ 

$file_path = '\Users\user\Downloads\medbot-slade'; 
if (!file_exists($file_path)) { 
    mkdir($file_path, 0777, true); 
} 

$info = pathinfo($_FILES['file']['name']);
$ext = $info['extension']; // get the extension of the file
$newname = $billno."_claim"; 
//echo 'target-->'.$target = '\Users\user\Downloads\/'.$newname;
$target = '\Users\user\Downloads\medbot-slade\\'.$newname.'.pdf';
move_uploaded_file( $_FILES['file']['tmp_name'], $target);
$content=$newname;
$get_file=$target;
}



$query018="select claim_id,patientcode from slade_claim where visitcode='$visitcode' order by id desc";
$exc018=mysqli_query($GLOBALS["___mysqli_ston"], $query018);
$res018=mysqli_fetch_array($exc018);
$invoice_upload_id = $res018['claim_id'];
$patient_number=$res018['patientcode'];

$query0181="select customerfullname from master_customer where customercode='$patient_number'";
$exc0181=mysqli_query($GLOBALS["___mysqli_ston"], $query0181);
$res0181=mysqli_fetch_array($exc0181);
$customerfullname = $res0181['customerfullname'];
$desc="invoice scan for ".$customerfullname;
$attachment_type='CLAIM_FORM';
//echo $get_file=$get_file;
//echo 'manual-->'.$get_file='\Users\user\Downloads\get_file.pdf';
/*$attachment_type='PRESCRIPTION';

	$get_file='\Users\user\Downloads\get_file.pdf';*/	
	//$attachment_type='LAB_ORDER'; 

		  $post_datas=array(
		 'claim' => $invoice_upload_id,
		 "description" => $desc,
		 "attachment_type" => $attachment_type,
		 "attachment" => new CURLFILE($get_file)
		 
		 );
/*	print_r($post_datas);
	echo $authorization;
	echo $claim_url;
	exit;*/
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_SAFE_UPLOAD, false);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: multipart/form-data' , $authorization ));
	curl_setopt($curl, CURLOPT_POSTFIELDS,$post_datas);
	curl_setopt($curl, CURLOPT_URL, $claim_url.'/v1/claim_attachments/upload_attachment/?format=json');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	$result = curl_exec($curl);
	/*print_r($curl);
	exit;*/
	$err = curl_error($curl);
	curl_close($curl);    
	if ($err) {
	   $results['error'] = $err_unable_connect;
	}else{
		$obj=json_decode($result,true);	
     
		if(isset($obj['id']) ){
  	
			 if($source=='ip')
			{
			 $query8 = "update slade_claim set claim_upload_payload='".addslashes($result)."',updated='".date('Y-m-d H:i:s')."' where visitcode = '$visitcode' ";
            $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8);
			echo "success";
			}
			
			else  if($source=='op')
			{
			 $query8 = "update slade_claim set claim_invoice_status='success',claim_upload_payload='".addslashes($result)."',updated='".date('Y-m-d H:i:s')."' where visitcode = '$visitcode' ";
            $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8);
			echo "success";	
			}
			          
		}
		else
		{
		  echo "fail";
		}
	 
	}
}

if($mainsource=='discharge')
{
	
$fileName = $_FILES['file']['name'];
$tmpName  = $_FILES['file']['tmp_name'];
$fileSize = $_FILES['file']['size'];
$fileType = $_FILES['file']['type'];

if(!empty($fileName) && ($fileSize>0)){ 

$file_path = '\Users\user\Downloads\medbot-slade'; 
if (!file_exists($file_path)) { 
    mkdir($file_path, 0777, true); 
} 

$info = pathinfo($_FILES['file']['name']);
$ext = $info['extension']; // get the extension of the file
$newname = $billno."_discharge"; 
//echo 'target-->'.$target = '\Users\user\Downloads\/'.$newname;
$target = '\Users\user\Downloads\medbot-slade\\'.$newname.'.pdf';
move_uploaded_file( $_FILES['file']['tmp_name'], $target);
$content=$newname;
$get_file=$target;
}
	

	
$query018="select claim_id,patientcode from slade_claim where visitcode='$visitcode' order by id desc";
$exc018=mysqli_query($GLOBALS["___mysqli_ston"], $query018);
$res018=mysqli_fetch_array($exc018);
$invoice_upload_id = $res018['claim_id'];
$patient_number=$res018['patientcode'];

$query0181="select customerfullname from master_customer where customercode='$patient_number'";
$exc0181=mysqli_query($GLOBALS["___mysqli_ston"], $query0181);
$res0181=mysqli_fetch_array($exc0181);
$customerfullname = $res0181['customerfullname'];
$desc="invoice scan for ".$customerfullname;
$attachment_type='OTHER';
$get_file=$get_file;

/*$attachment_type='PRESCRIPTION';

	$get_file='\Users\user\Downloads\get_file.pdf';*/	
	//$attachment_type='LAB_ORDER'; 

		  $post_datas=array(
		 'claim' => $invoice_upload_id,
		 "description" => $desc,
		 "attachment_type" => $attachment_type,
		 "attachment" => new CURLFILE($get_file)
		 
		 );
/*	print_r($post_datas);
	echo $authorization;
	echo $claim_url;
	exit;*/
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_SAFE_UPLOAD, false);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: multipart/form-data' , $authorization ));
	curl_setopt($curl, CURLOPT_POSTFIELDS,$post_datas);
	curl_setopt($curl, CURLOPT_URL, $claim_url.'/v1/claim_attachments/upload_attachment/?format=json');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	$result = curl_exec($curl);
	print_r($result);
	$err = curl_error($curl);
	curl_close($curl);    
	if ($err) {
	   $results['error'] = $err_unable_connect;
	}else{
		$obj=json_decode($result,true);	
     
		if(isset($obj['id']) ){
  	
			 $query8 = "update slade_claim set claim_invoice_status='success',	claim_ds_upload='".addslashes($result)."',updated='".date('Y-m-d H:i:s')."' where visitcode = '$visitcode' ";
            $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8);
			echo "success";
			          
		}
		else
		{
		  echo "fail";
		}
	 
	}
}

echo json_encode($results);
exit;
?>