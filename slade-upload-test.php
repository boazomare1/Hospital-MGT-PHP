<?php
include_once("db/db_connect.php");
include_once('slade.php');
$authorization="Authorization: Bearer $slade_token";

$path_info=__DIR__;
$path_info=str_replace("\\",'/',$path_info);
$slade_rslt=array();

if(!isset($upload_type)) 
  $upload_type=='claim';

if(!isset($bill_type))
  $bill_type='billing_paylater';

if(isset($upload_type) && ($upload_type=='invoice' || $upload_type=='claim')) { 

	$query7 = "select upload_claim,upload_invoice,slade_claim_id from $bill_type where billno = '$billno' and slade_claim_id='$claim_id'";
	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rows77 = mysqli_num_rows($exec7);
	if($rows77 > 0)
	{
      $res7 = mysqli_fetch_array($exec7);

	 if($upload_type=='invoice'){

		 $attache_filename=$res7['upload_invoice'];
		 $claim_id=$res7['slade_claim_id'];

		 $sql ="SELECT invoice_payload FROM `slade_claim` where claim_id='$claim_id'";
		 $exec72 = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die ("Error in sql".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res72 = mysqli_fetch_array($exec72);

		 $get_invoice_id=stripslashes($res72['invoice_payload']);
		 $get_invoice_id=json_decode($get_invoice_id);
		 
		 $invoice_id=$get_invoice_id->id;
		 
		 $upload_url=$claim_url.'/v1/invoice_attachments/upload_attachment/?format=json';
		 $post_datas=array(
				 'invoice' => $invoice_id,
				 'description' => "Invoice scan",
				 'attachment' => new CURLFILE($path_info.'/slade_uploads/'.$attache_filename)
				);

     }
	 else{
		 $attache_filename=$res7['upload_claim'];
		 $upload_url=$claim_url.'/v1/claim_attachments/upload_attachment/?format=json';
	     $post_datas=array(
				 'claim' => $claim_id,
				 'description' => "Claim form",
				 'attachment_type' => 'CLAIM_FORM',
				 'attachment' => new CURLFILE($path_info.'/slade_uploads/'.$attache_filename)
				);
	 }

	 if($attache_filename!='' && file_exists(dirname(__FILE__).'/slade_uploads/'.$attache_filename)){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SAFE_UPLOAD, false);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_URL, $upload_url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type:  multipart/form-data' , $authorization ));
		curl_setopt($curl, CURLOPT_POST, 1);                                         
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_datas); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		$result = curl_exec($curl);	
		$err = curl_error($curl);
        print_r($err);
		curl_close($curl);
		if ($err) {
		   $slade_rslt['status'] = 'Faild';
		   $slade_rslt['msg'] = $err_unable_connect;
		}else{
			$obj=json_decode($result,true);
            print_r($obj);
			if(isset($obj['id'])){
				$slade_rslt['status'] = 'Success';
				$slade_rslt['response'] = trim($result);
				$slade_rslt['msg']='Successfully uploaded.';
				@unlink($path_info.'/slade_uploads/'.$attache_filename);
			}
			elseif(isset($obj['attachment_type'][0]) && $obj['attachment_type'][0]=='You can only have one attachment of type CLAIM_FORM'){
				$slade_rslt['status'] = 'Success';
				$slade_rslt['response'] = trim($result);
				$slade_rslt['msg']='Successfully uploaded.';
				@unlink($path_info.'/slade_uploads/'.$attache_filename);
			}
			else{
				$slade_rslt['status'] = 'Faild';
				$slade_rslt['response'] = trim($result);
				$slade_rslt['msg']=$obj['attachment_type'];
			}
		}
	}
	else{
				$slade_rslt['status'] = 'Faild';
				$slade_rslt['msg']='Upload file not found.';
	 }
  }
  else{
	 $slade_rslt['status']='Faild';
	 $slade_rslt['msg']='Invalid bill/claim details.';
  }

}
else{
  $slade_rslt['status']='Faild';
  $slade_rslt['msg']='Invalid upload type.';
}

//echo json_encode($slade_rslt);

?>