<?php

ob_start();
session_start(); 

error_reporting(0);

//date_default_timezone_set('Asia/Calcutta');

include ("db/db_connect.php");

include_once('slade.php');
$authorization="Authorization: Bearer $slade_token";
$debit='credit';
$billno ="";
$visitcode ="";
$disc_consultationfxamount1='0.00';
$pharm_disc='0.00';
$lab_disc='0.00';
$rad_disc ='0.00';
$serv_desc ='0.00';
$invoice_arry=array();
$inv_rslt=array();
$inv_line=array();
$j=0;

//include ("includes/loginverify.php");

$updatedatetime = date("Y-m-d H:i:s");

$indiandatetime = date ("d-m-Y H:i:s");

$dateonly = date("Y-m-d");

$timeonly = date("H:i:s");

$username = $_SESSION["username"];

$ipaddress = $_SERVER["REMOTE_ADDR"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];

$financialyear = $_SESSION["financialyear"];

$currentdate = date("Y-m-d");

$updatedate=date("Y-m-d");

$titlestr = 'SALES BILL';


$defaulttax = '';
$docno = $_SESSION['docno'];



$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';



if($locationcode!='')

{

	$locationcode=$_REQUEST['locationcode'];

}

else

{

//header location

	$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname ";

	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res1 = mysqli_fetch_array($exec1);

	

 	$locationname = $res1["locationname"];

	$locationcode = $res1["locationcode"];

}

	$query3 = "select * from master_location where locationcode = '$locationcode'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res3 = mysqli_fetch_array($exec3);

	//$companyname = $res2["companyname"];

	$address1 = $res3["address1"];

	$address2 = $res3["address2"];

	//$area = $res2["area"];

	//$city = $res2["city"];

	//$pincode = $res2["pincode"];

	$emailid1 = $res3["email"];

	$phonenumber1 = $res3["phone"];

	$locationcode = $res3["locationcode"];

	//$phonenumber2 = $res2["phonenumber2"];

	//$tinnumber1 = $res2["tinnumber"];

	//$cstnumber1 = $res2["cstnumber"];

	$locationname =  $res3["locationname"];

	$prefix = $res3["prefix"];

	$suffix = $res3["suffix"];

	


// include("print_header.php");
//include("print_header_pdf3.php");

 //get location for sort by location purpose

  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

	if($location!='')

	{

		  $locationcode=$location;

		}

		//location get end here

if ($defaulttax == '')

{

	$_SESSION["defaulttax"] = '';

}

else

{

	$_SESSION["defaulttax"] = $defaulttax;

}

if(isset($_REQUEST["patientcode"]))

{

$patientcode=$_REQUEST["patientcode"];

$visitcode=$_REQUEST["visitcode"];

$billnumber = $_REQUEST["billno"];

$invoice_number=$billnumber;
$Invoice_type='CREDIT_NOTE';
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }

}
 // `consultationdate`, `consultationtime`, `patientcode`, `patientname`, `patientvisitcode`, `description`, `rate`, `amount`, `units`, `docno`, `ref_no`, `billtype`, `accountname`, `locationname`, `locationcode`, `paymentstatus`, `remarks`, `referalrefund`, `username`, `ipaddress`, `billingaccountname`, `billingaccountcode` FROM `adhoc_creditnote`


	 $query4 = "SELECT * FROM adhoc_creditnote WHERE patientcode = '$patientcode' AND patientvisitcode = '$visitcode' AND docno = '$billnumber'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res4 = mysqli_fetch_array($exec4);

	 $patientname = $res4['patientname']; 

	$billnumbercode = $res4['docno']; 

	$patientcode = $res4['patientcode'];

	$dateonly = $res4['consultationdate']; 

	$visitcode = $res4['patientvisitcode'];

	$patientaccount1 = $res4['accountname'];

	$totalamount = $res4['amount'];
	$rate = $res4['rate'];
	$units = $res4['units'];
    $ref_no = $res4['ref_no'];
	$locationcode= $res4['locationcode'];

	$remarks = $res4['remarks'];
	
	$query18 = "select claim_id from slade_claim where visitcode='$visitcode' and claim_id!='' order by id desc ";
$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));
$res18 = mysqli_fetch_array($exec18);
$claim_id = $res18["claim_id"];


	
	
	$invoice_arry["claim"]=$claim_id;
	$invoice_arry["invoice_date"]=date("c",strtotime($res4['consultationdate']));
	$invoice_arry["invoice_number"]=$invoice_number;
	$invoice_arry["Invoice_type"]=$Invoice_type;
    $invoice_arry["linked_invoice"]=$billautonumber;



?>


<?php

	$sno=1;

	$totalamount = 0;

	 $query5 = "SELECT * FROM adhoc_creditnote WHERE patientcode = '$patientcode' AND patientvisitcode = '$visitcode' AND docno = '$billnumber'";

	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));

	$row5 = mysqli_num_rows($exec5);

	if($row5 > 0)

	{

	while($res5 = mysqli_fetch_array($exec5)){

	$item = $res5['billingaccountname'];
    $description = $res5['description'];

	$amount = $res5['amount'];
	$rate = $res5['rate'];
	$units = $res5['units'];

	$totalamount = $totalamount + $amount;
	
	$inv_line[$j]["item_code"]=$billnumber;
	$inv_line[$j]["item_name"]=$item;
	$inv_line[$j]["charge_date"]=date("c",strtotime($res5['consultationdate']));
	$inv_line[$j]["unit_price"]=$rate;
	$inv_line[$j]["quantity"]=$units;
	$inv_line[$j]["line_number"]=$sno;
	$sno++;
	$j++;


	}

	}

json_encode($inv_line);
	$invoice_arry["lines"]=$inv_line;
	$inv_send=json_encode($invoice_arry);

/*print_r($inv_send);
exit;*/


	$curl = curl_init();
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json' , $authorization ));
	curl_setopt($curl, CURLOPT_POSTFIELDS,$inv_send);
	curl_setopt($curl, CURLOPT_URL, $invoice_attach_url.'/v1/invoices/?format=json');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	$result = curl_exec($curl);

	$err = curl_error($curl);
	curl_close($curl);
	if ($err) {
	   $inv_rslt['status'] = 'Faild';
	   $inv_rslt['msg'] = $err_unable_connect;
	}else{
		$obj=json_decode($result,true);
		if(isset($obj['id'])){
			$id=$obj['id'];
          
			$query8 = "update slade_claim set credit_payload='".addslashes($result)."',updated='".date('Y-m-d H:i:s')."' where visitcode = '$visitcode'";
            $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8);
		 $query81 = "update adhoc_debitnote set posting_status='completed' where patientvisitcode = '$visitcode' and docno='$billnumber' ";
		$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81);
			$inv_rslt['status'] = 'Success';
            $inv_rslt['msg'] = $err_post_success;
			/*header("location:print_adhoc_creditnote_slade.php?billno=$billnumber&&visitcode=$visitcode&patientcode=$patientcode&locationcode=$locationcode");
				exit;*/
				header("location:slade_dr_cr_notes.php?billno=$billnumber&&visitcode=$visitcode&&patientcode=$patientcode&&locationcode=$locationcode&&source=$debit");
exit;
		}else{
		  //$query8 = "update slade_claim set invoice_payload='".addslashes($result)."',updated='".date('Y-m-d H:i:s')."' where visitcode = '$visitcode' and claim_id='".$res7['slade_claim_id']."'";
            //$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8);
          $inv_rslt['status'] = 'Faild';
	      $inv_rslt['msg'] = $err_faild_repost;
		}
	}
?>



