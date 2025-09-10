<?php
include_once("db/db_connect.php");
$results_error =array();

if(isset($_REQUEST['docno'])){
	$print_no= $_REQUEST['docno'];
	$chk_slade="select billno,slade_upload_claim_status,slade_upload_inv_status from completed_billingpaylater where isSlade=1 and printno='".$print_no."' and ( slade_upload_claim_status!='completed' or slade_upload_inv_status!='completed')";
	$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $chk_slade) or die ("Error in chk_slade".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rows277 = mysqli_num_rows($exec27);
	if($rows277 > 0)
	{
        while($res24 = mysqli_fetch_array($exec27)) {

            echo '<br>bill-'.$billno = $res24["billno"];

			if( strpos( $billno, 'IPF' ) !== false)
				$bill_type="billing_ip";
			else
			   $bill_type="billing_paylater";

		    $chk_claimid="select slade_claim_id from $bill_type where billno = '$billno' and slade_claim_id!=''";
			$exec276 = mysqli_query($GLOBALS["___mysqli_ston"], $chk_claimid) or die ("Error in chk_claimid".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res246 = mysqli_fetch_array($exec276);
			echo 'claim-'.$claim_id = $res246["slade_claim_id"];
            
			if($res24["slade_upload_claim_status"]!='completed'){
			  echo $upload_type="claim";
			  include('slade-upload-test.php');
			  $status_claim=$slade_rslt['status'];
			  if($status_claim=='Success'){
				 mysqli_query($GLOBALS["___mysqli_ston"], "update completed_billingpaylater set slade_upload_claim_status='completed',slade_uploadclaim_payload='".$slade_rslt['response']."' where billno = '$billno' and printno='$print_no'");
			  }else{
				if(isset($slade_rslt['response'])){
                    mysqli_query($GLOBALS["___mysqli_ston"], "update completed_billingpaylater set slade_uploadclaim_payload='".$slade_rslt['response']."' where billno = '$billno' and printno='$print_no'");
				}              
			  }
			}

			if($res24["slade_upload_inv_status"]!='completed'){
			 echo  $upload_type="invoice";
			  include('slade-upload-test.php');
			  $status_claim=$slade_rslt['status'];
			  
			  if($status_claim=='Success'){
				 mysqli_query($GLOBALS["___mysqli_ston"], "update completed_billingpaylater set slade_upload_inv_status='completed',slade_uploadinv_payload='".$slade_rslt['response']."' where billno = '$billno' and printno='$print_no'");
			  }else{
				if(isset($slade_rslt['response'])){
                    mysqli_query($GLOBALS["___mysqli_ston"], "update completed_billingpaylater set slade_uploadinv_payload='".$slade_rslt['response']."' where billno = '$billno' and printno='$print_no'");
				}               
			  } 
			}
		}
	}

	 $chk_slade="select printno from completed_billingpaylater where isSlade=1 and printno='".$print_no."' and ( slade_upload_claim_status!='completed' or slade_upload_inv_status!='completed')";
	$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $chk_slade) or die ("Error in chk_slade".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rows277 = mysqli_num_rows($exec27);
	if($rows277 > 0)
	{
		$results_error['status'] ='faild';
        $results_error['msg'] ='There is a Problem Uploading Some claim/invoice to Slade, please try again later.';
	}
	else{
		$results_error['status'] ='success';
        $results_error['msg'] ='Invoice/Claim Successfully Uploaded.';
	}
}
else{
  $results_error['status'] ='faild';
   $results_error['msg'] ='Invaild Doc No.';
}

echo json_encode($results_error);
exit;

?>