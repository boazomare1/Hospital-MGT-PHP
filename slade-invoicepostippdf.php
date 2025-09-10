<?php

ob_start();

session_start();

ini_set('max_execution_time', 3000);

ini_set('memory_limit','-1');

include ("db/db_connect.php");


$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedate = date('Y-m-d');
$companyanum=1;


$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$updatetime = date('H:i:s');

$updatedate = date('Y-m-d');

$currentdate = date('Y-m-d');

$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$temp = 0;

$balanceamount = "0.00";

$openingbalance = "0.00";

$searchsuppliername = "";

$cbsuppliername = "";

$pharmacy_fxrate=2872.49;

$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1location = $res1["locationname"];
$locationcode = $res1["locationcode"];

function post_invoice($id,$filename1,$file_path1,$name,$authorization,$invoice_url,$visitcode,$billno,$patientcode,$loc)
{
	
	  /*$file_path1='C:\\Users\\user\\Downloads\\medbot-slade\\'.$filename1;*/
	  
	 //$file_path1='\Users\user\Downloads\medbot-slade\IPF-18-24.pdf';

/*if($name=='')
{
	$name='John';
}
if($visitcode=='')
{
	$visitcode='OPV-399-1';
}*/
$filetype='pdf';
$desc="invoice scan for ".$name;
	$data_string='{
		    "invoice": "'.$id.'",
			"attachment":"'.$file_path1.'",
 			"description": "'.$desc.'"
		 }';
		 
		 $post_datas=array(
		 'invoice' => $id,
		 "description" => $desc,
		 "attachment" => new CURLFILE($file_path1)
		 
		 );
	/*print_r($post_datas);
	exit;*/
		
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_SAFE_UPLOAD, false);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: multipart/form-data' , $authorization ));
	curl_setopt($curl, CURLOPT_POSTFIELDS,$post_datas);
	curl_setopt($curl, CURLOPT_URL, $invoice_url.'/v1/invoice_attachments/upload_attachment/?format=json');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	$result = curl_exec($curl);
	
	if (file_exists($file_path1)) 
    {
    if (unlink($file_path1)) 
    {
    } 
    }
	$err = curl_error($curl);
	curl_close($curl);
	if ($err) {
	   $inv_rslt['status'] = 'Faild';
	   $inv_rslt['msg'] = $err_unable_connect;
	}else{
		$obj=json_decode($result,true);
		if(isset($obj['id'])){
			$id1=$obj['id'];
           	$query8 = "update slade_claim set claim_invoice_status='pending',invoice_id='$id',invoice_upload_id='$id1',invoice_upload_payload='".addslashes($result)."',updated='".date('Y-m-d H:i:s')."' where visitcode = '$visitcode' ";
            $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8);
			$inv_rslt['status'] = 'Success';
			//remove file from folder here
			
			header("location:ipbilling.php?billnumber=$billno&savedpatientcode=$patientcode&&savedvisitcode=$visitcode&&loc=$loc");
exit;
		}else{
		 
          $inv_rslt['status'] = 'Faild';
		}
	}
}


if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
if (isset($_REQUEST["claim"])) { $claim = $_REQUEST["claim"]; } else { $claim = ""; }
if (isset($_REQUEST["auth"])) { $auth = $_REQUEST["auth"]; } else { $auth = ""; }
if (isset($_REQUEST["invoice_url"])) { $invoice_url = $_REQUEST["invoice_url"]; } else { $invoice_url = ""; }


if (isset($_REQUEST["billnumber"])) { $billnumbers = $_REQUEST["billnumber"]; } else { $billnumbers = ""; }

if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }

if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }



$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where locationcode='$locationcode' and customercode='$patientcode'");

$execlab=mysqli_fetch_array($Querylab);

$patientage=$execlab['age'];

$patientgender=$execlab['gender'];

$customername = $execlab['customername'];



$patienttype=$execlab['maintype'];

$querytype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where locationcode='$locationcode' and auto_number='$patienttype'");

$exectype=mysqli_fetch_array($querytype);

$patienttype1=$exectype['paymenttype'];

$patientsubtype=$execlab['subtype'];

$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where locationcode='$locationcode' and auto_number='$patientsubtype'");

$execsubtype=mysqli_fetch_array($querysubtype);

$patientsubtype1=$execsubtype['subtype'];



$query32 = "select * from ip_discharge where locationcode='$locationcode' and patientcode='$patientcode' and visitcode='$visitcode'";

$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$num32 = mysqli_num_rows($exec32);

$res32 = mysqli_fetch_array($exec32);

$dischargedby = $res32['username'];



$query33 = "select * from master_employee where locationcode='$locationcode' and username = '$dischargedby'";

$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res33 = mysqli_fetch_array($exec33);

$employeename = $res33['employeename'];



?>



<?php

function roundTo($number, $to){ 

    return round($number/$to, 0)* $to; 

} 



?>



<?php

		$query2 = "select * from master_location where locationcode = '$locationcode'";

		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res2 = mysqli_fetch_array($exec2);

		//$companyname = $res2["companyname"];

		$address1 = $res2["address1"];

		$address2 = $res2["address2"];

//		$area = $res2["area"];

//		$city = $res2["city"];

//		$pincode = $res2["pincode"];

		$emailid1 = $res2["email"];

		$phonenumber1 = $res2["phone"];

		$locationcode = $res2["locationcode"];

//		$phonenumber2 = $res2["phonenumber2"];

//		$tinnumber1 = $res2["tinnumber"];

//		$cstnumber1 = $res2["cstnumber"];

	//	$locationname =  $res2["locationname"];

		$prefix = $res2["prefix"];

		$suffix = $res2["suffix"];

		

?>

<style type="text/css">

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; 

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000; 

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000;  text-decoration:none

}

.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000;  text-decoration:none

}

.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #000000;  text-decoration:none


}

.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000; 

}

.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; 

}

.bodytext33 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;

}

.bodytext34 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;

}

.bodytext35 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;

}

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #FFFFFF;

	font-family:Arial, Helvetica, sans-serif;

}

.underline {text-decoration: underline;}

.page_footer

{

	font-family: Times;

	text-align:center;

	font-weight:bold;

	margin-bottom:25px;

	

}

</style>



<page pagegroup="new" backtop="12mm" backbottom="20mm" backleft="2mm" backright="3mm">

 <?php  include('print_header_pdf3.php'); ?>

    

 <page_footer>

  <div class="page_footer" style="width: 100%; text-align: center">

                     Page [[page_cu]] of [[page_nb]]

                </div>

    </page_footer>



	

	<table width="100%" align="center" border="0" cellspacing="4" cellpadding="0">

 

           <?php

 		 $query1 = "select * from master_ipvisitentry where locationcode='$locationcode' and patientcode='$patientcode' and visitcode='$visitcode'";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num1=mysqli_num_rows($exec1);

		

		while($res1 = mysqli_fetch_array($exec1))

		{

		$patientname=$res1['patientfullname'];

		$patientcode=$res1['patientcode'];

		$accountname = $res1['accountname'];

		$billtype = $res1['billtype'];

		$gender = $res1['gender'];

		$age = $res1['age'];

		$consultingdoctor = $res1['consultingdoctor'];

		$nhifid = $res1['nhifid'];

		$subtypeanum = $res1['subtype'];

		$type = $res1['type'];

        $memberno=$res1['memberno'];
		
		$res2visitcode = $res1['visitcode'];
		

		$query13 = "select * from master_subtype where  auto_number = '$subtypeanum'";

		$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res13 = mysqli_fetch_array($exec13);

		$subtype = $res13['subtype'];

		$fxrate=$res13['fxrate'];

		$currency=$res13['currency'];

		$bedtemplate=$res13['bedtemplate'];

		$labtemplate=$res13['labtemplate'];

		$radtemplate=$res13['radtemplate'];

		$sertemplate=$res13['sertemplate'];

		$querytt32 = "select * from master_testtemplate where templatename='$bedtemplate'";

		$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$numtt32 = mysqli_num_rows($exectt32);

		$exectt=mysqli_fetch_array($exectt32);

		$bedtable=$exectt['referencetable'];

		if($bedtable=='')

		{

			$bedtable='master_bed';

		}

		$bedchargetable=$exectt['templatename'];

		if($bedchargetable=='')

		{

			$bedchargetable='master_bedcharge';

		}

		$querytl32 = "select * from master_testtemplate where templatename='$labtemplate'";

		$exectl32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytl32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$numtl32 = mysqli_num_rows($exectl32);

		$exectl=mysqli_fetch_array($exectl32);		

		$labtable=$exectl['templatename'];

		if($labtable=='')

		{

			$labtable='master_lab';

		}

		

		$querytt32 = "select * from master_testtemplate where templatename='$radtemplate'";

		$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$numtt32 = mysqli_num_rows($exectt32);

		$exectt=mysqli_fetch_array($exectt32);		

		$radtable=$exectt['templatename'];

		if($radtable=='')

		{

			$radtable='master_radiology';

		}

		

		$querytt32 = "select * from master_testtemplate where templatename='$sertemplate'";

		$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$numtt32 = mysqli_num_rows($exectt32);

		$exectt=mysqli_fetch_array($exectt32);

		$sertable=$exectt['templatename'];

		if($sertable=='')

		{

			$sertable='master_services';

		}

		$query813 = "select * from ip_discharge where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";

		$exec813 = mysqli_query($GLOBALS["___mysqli_ston"], $query813) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$res813 = mysqli_fetch_array($exec813);

		$num813 = mysqli_num_rows($exec813);

		if($num813 > 0)

		{

		$updatedate=$res813['recorddate'];

		$updatedatetime=$res813['recordtime'];

		

		}

		
$scheme_id = $res1["scheme_id"];
	$query_sc = "select scheme_name from master_planname where scheme_id = '$scheme_id'";

	$exec_sc = mysqli_query($GLOBALS["___mysqli_ston"], $query_sc) or die ("Error in query_sc".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res_sc = mysqli_fetch_array($exec_sc);

	$accname = $res_sc['scheme_name'];

	     }

		 

		$query2 = "select * from ip_bedallocation where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";

		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$res2 = mysqli_fetch_array($exec2);

		$admissiondate = $res2['recorddate'];

		$wardanum = $res2['ward'];

		$bed = $res2['bed'];
        $alloc_docno = $res2['docno'];
		$admissiontime = $res2['recordtime'];

		

		

		$query12 = "select * from master_ward where locationcode='$locationcode' and auto_number = '$wardanum'";

		$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res12 = mysqli_fetch_array($exec12);

		$wardname = $res12['ward'];

		//No. of days calculation

		$startdate = strtotime($admissiondate);

		$enddate = strtotime($updatedate);

		$nbOfDays = $enddate - $startdate;

		$nbOfDays = ceil($nbOfDays/60/60/24);

		//billno

		$querybill = "select billno, billdate,preauthcode from billing_ip where locationcode='$locationcode' and patientcode = '$patientcode' and visitcode = '$visitcode' and billno = '$billnumbers'";

		$execbill = mysqli_query($GLOBALS["___mysqli_ston"], $querybill) or die ("Error in querybill".mysqli_error($GLOBALS["___mysqli_ston"]));

		$resbill = mysqli_fetch_array($execbill);

		$billno = $resbill['billno'];

		$billdate1 = $resbill['billdate'];

		$preauthcode = $resbill['preauthcode'];



		$from_limit_date=$admissiondate;

		$to_limit_date =date('Y-m-d');

		$querybill = "select billdate from billing_ip where patientcode = '$patientcode' and visitcode = '$visitcode'";

		$execbill = mysqli_query($GLOBALS["___mysqli_ston"], $querybill) or die ("Error in querybill".mysqli_error($GLOBALS["___mysqli_ston"]));

		if($resbill = mysqli_fetch_array($execbill)){

			$to_limit_date = $resbill['billdate'];		

		}



		$query813 = "select recorddate from ip_discharge where visitcode='$visitcode' and patientcode='$patientcode'";

		$exec813 = mysqli_query($GLOBALS["___mysqli_ston"], $query813) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$res813 = mysqli_fetch_array($exec813);

		$num813 = mysqli_num_rows($exec813);

		if($num813 > 0)

		{

		//$to_limit_date=$res813['recorddate'];

		}

		

		$queryicd = "select * from discharge_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number DESC";

$execicd = mysqli_query($GLOBALS["___mysqli_ston"], $queryicd) or die ("Error in queryicd".mysqli_error($GLOBALS["___mysqli_ston"]));

$resicd = mysqli_fetch_array($execicd);

$primary = $resicd['primarydiag'];

		

		?>

		    <tr>

  <td colspan="10">&nbsp;</td></tr>

		   <tr>

             <td width="110" align="left" valign="center" class="bodytext31"><strong>Name:</strong></td> 

		     <td width="250" align="left" valign="center" class="bodytext31"><?php echo $patientname; ?></td>

		     <td width="110" align="left" valign="center" class="bodytext31"><strong>Invoice No:</strong></td> 

		     <td width="160" align="left" valign="center" class="bodytext31"><?php echo $billno; ?></td>

          </tr>

		  

	       <tr>

             <td width="110" align="left" valign="center" class="bodytext31"><strong>Reg. No.:</strong></td>

	         <td width="250" align="left" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>

	         <td width="110" align="left" valign="center" class="bodytext31"><strong>Bill Date:</strong></td> 

		     <td width="160" align="left" valign="center" class="bodytext31"><?php echo date("d/m/Y", strtotime($billdate1)); ?></td>

         </tr>

          <tr>

             <td width="110" align="left" valign="center" class="bodytext31"><strong>Bill Type:</strong></td>

	         <td width="250" align="left" valign="center" class="bodytext31"><?php echo $billtype; ?></td>

	         <td width="110" align="left" valign="center" class="bodytext31"><strong>IP Visit No.:</strong></td>

			 <td width="160" align="left" valign="left" class="bodytext31"><?php echo $visitcode; ?></td>

         </tr>

        <tr>

			<td width="110" align="left" valign="center" class="bodytext31"><strong>Account:</strong></td>

			<td width="250" align="left" valign="center" class="bodytext31"><?php echo $accname; ?></td>

			<td width="110" align="left" valign="center" class="bodytext31"><strong>Admission Date:</strong></td> 

	        <td width="160" align="left" valign="center" class="bodytext31"><?php echo  date("d/m/Y", strtotime($admissiondate))." ".$admissiontime; ?></td>

</tr>		<tr>

            <td width="110" align="left" valign="center" class="bodytext31"><strong>Covered By: </strong></td>

            <td width="250" align="left" valign="center" class="bodytext31"><?php echo $subtype; ?></td>

            <td width="110" align="left" valign="center" class="bodytext31"><strong>Discharge Date:</strong></td>

			<td width="160" align="left" valign="center" class="bodytext31"><?php echo date("d/m/Y", strtotime($updatedate))." ".$updatedatetime; ?></td>

		</tr>

		 <tr>

         

			<td width="110" align="left" valign="center" class="bodytext31"><strong>Member No:</strong></td>

             <td width="250" align="left" valign="center" class="bodytext31"><?php echo $memberno; ?></td>

            <td width="110" align="left" valign="center" class="bodytext31"><strong>No of Days:</strong></td>

			<td width="160" align="left" valign="left" class="bodytext31"><?php echo $nbOfDays; ?></td>

        </tr>

         <tr>

			<td width="110" align="left" valign="center" class="bodytext31"><strong>Pre Auth Code:</strong></td>

			<td width="250" align="left" valign="center" class="bodytext31"><?php echo $preauthcode; ?></td>

			<td width="110" align="left" valign="center" class="bodytext31"><strong>Type:</strong></td>

			<td width="160" align="left" valign="left" class="bodytext31"><?php echo $type; ?></td>

          </tr>

          <tr>

            <td width="110" align="left" valign="center" class="bodytext31">&nbsp;</td>

            <td width="250" align="left" valign="center" class="bodytext31">&nbsp;</td>

			<td width="110" align="left" valign="center" class="bodytext31"><strong>Bed No:</strong></td>

			<td width="160" align="left" valign="center" class="bodytext31"><?php echo $bed;?></td>

		</tr>

		

       

        <tr>

  <td colspan="10">&nbsp;</td></tr> 





              <?php

			$colorloopcount = '';

			$sno = '';

			$totalamount=0;

			$totalquantity = 0;

			$totalop =0;

			$query17 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";

			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res17 = mysqli_fetch_array($exec17);

			$consultationfee=$res17['admissionfees'];

			$packageanum1 = $res17['package'];

			$consultationfee = number_format($consultationfee,2,'.','');

			$viscode=$res17['visitcode'];

			$consultationdate=$res17['consultationdate'];

			$packchargeapply = $res17['packchargeapply'];

			

			

			$query53 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";

			$exec53 = mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res53 = mysqli_fetch_array($exec53);

			$refno = $res53['docno'];

			

			

			$totalop=$consultationfee;

			

			?>

       

			  <tr>

<td width="169" align="left"  valign="center" class="bodytext31">&nbsp;</td>

			 <td class="bodytext31"  valign="center"  align="left"><strong>Admission Fees:</strong></td>

			   

                <td class="bodytext31" valign="center"  align="right"><?php echo number_format($consultationfee,2,'.',','); ?></td>

				 

           	</tr>	

              

			<?php

			$colorloopcount = '';

			$sno = '';

			$totalamount=0;

			$totalquantity = 0;



					  $packageamount = 0;

			 $query731 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'"; 

			$exec731 = mysqli_query($GLOBALS["___mysqli_ston"], $query731) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res731 = mysqli_fetch_array($exec731);

			$packageanum1 = $res731['package'];

			$packagedate1 = $res731['consultationdate'];

			$packageamount = $res731['packagecharge'];

			

			$query741 = "select * from master_ippackage where auto_number='$packageanum1'";

			$exec741 = mysqli_query($GLOBALS["___mysqli_ston"], $query741) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res741 = mysqli_fetch_array($exec741);

			$packdays1 = $res741['days'];

			$packagename = $res741['packagename'];

			

			

			if($packageanum1 != 0)

	{

	

	 $reqquantity = $packdays1;

	 

	 $reqdate = date('Y-m-d',strtotime($packagedate1) + (24*3600*$reqquantity));

	 

			  $colorloopcount = $colorloopcount + 1;

			$showcolor = ($colorloopcount & 1); 

		

			  ?>

          <tr>

          			<td width="169" align="left"  valign="center" class="bodytext31">&nbsp;</td>

                        <td class="bodytext31"  valign="center"  align="left"><strong><?php echo "Package Charge";?></strong></td>

                        <td class="bodytext31" valign="center"  align="right"><?php  echo number_format($packageamount,2,'.',',');  ?></td>                   

                    </tr>

			  <?php

			  }

			  



$totalbedallocationamount=0;

$totalbedtransferamount=0;		





			$querya01 = "select *,sum(amount) as amount from billing_ipbedcharges where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode' and docno='$billno' and bed <> '0' group by description";

			$execa01 = mysqli_query($GLOBALS["___mysqli_ston"], $querya01) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$numa01 = mysqli_num_rows($execa01);

			while($resca01=mysqli_fetch_array($execa01)){



				$date=$resca01['recorddate'];

				$refno =$visitcode;

				$charge=$resca01['description'];

				$bed=$resca01['bed'];

				$ward=$resca01['ward'];

				$quantity=$resca01['quantity'];

				$rate=$resca01['rate'];

				$amount=$resca01['amount'];

				

				$querybed = mysqli_query($GLOBALS["___mysqli_ston"], "select bed from master_bed where auto_number='$bed'");

				$resbed = mysqli_fetch_array($querybed);

				$bedname = $resbed['bed'];

				

				$queryward = mysqli_query($GLOBALS["___mysqli_ston"], "select description from master_ward where auto_number='$ward'");

				$resward = mysqli_fetch_array($queryward);

				$wardname = $resward['description'];

				

				if($quantity==0){

					$quantity=1;

				}

			

				$totalbedallocationamount=$totalbedallocationamount+$amount;

			if($charge=="RMO Charges"){

					continue;

				}

								

					  ?>

					<tr>

<td width="169" align="left"  valign="center" class="bodytext31">&nbsp;</td>

                        <td class="bodytext31"  valign="center"  align="left"><strong><?php echo $charge;?></strong></td>

                        <td class="bodytext31" valign="center"  align="right"><?php  echo number_format($amount,2,'.',',');  ?></td>                   

                    </tr>              

		<?php	

			}

		

		

		/*	$totalbedallocationamount = 0;

			

			 $requireddate = '';

			 $quantity = '';

			 $allocatenewquantity = '';

			$query18 = "select ward,bed,docno,recorddate,leavingdate,recordstatus from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";

				$exec18 = mysql_query($query18) or die ("Error in Query1".mysql_error());

				while($res18 = mysql_fetch_array($exec18))

				{

					$ward = $res18['ward'];

					$allocateward = $res18['ward'];			

					$bed = $res18['bed'];

					$refno = $res18['docno'];

					$date = $res18['recorddate'];

					$bedallocateddate = $res18['recorddate'];

					$packagedate = $res18['recorddate'];

					$leavingdate = $res18['leavingdate'];

					$recordstatus = $res18['recordstatus'];

					if($leavingdate=='0000-00-00')

					{

						$leavingdate=$updatedate;

					}

					$query51 = "select bed,threshold from `$bedtable` where auto_number='$bed'";

					$exec51 = mysql_query($query51) or die(mysql_error());

					$res51 = mysql_fetch_array($exec51);

					$bedname = $res51['bed'];

					$threshold = $res51['threshold'];

					$thresholdvalue = $threshold/100;

					$time1 = new DateTime($bedallocateddate);

					$time2 = new DateTime($leavingdate);

					$interval = $time1->diff($time2);			  

					$quantity1 = $interval->format("%a");

					if($packdays1>$quantity1)

					{

						$quantity1=$quantity1-$packdays1; 

						$packdays1=$packdays1-$quantity1;

					}

					else

					{

						$quantity1=$quantity1-$packdays1;

						$packdays1=0;

					}

					$quantity='0';

					$diff = abs(strtotime($leavingdate) - strtotime($bedallocateddate));

					$query91 = "select charge,rate from `$bedchargetable` where bedanum='$bed' and recordstatus ='' and charge not in ('Accommodation Charges','Cafetaria Charges')";

					$exec91 = mysql_query($query91) or die(mysql_error());

					$num91 = mysql_num_rows($exec91);

					while($res91 = mysql_fetch_array($exec91))

					{

						$charge = $res91['charge'];

						$rate = $res91['rate'];	

						

						if($charge!='Bed Charges')

						{

							//$quantity=$quantity1+1;

							if($recordstatus=='discharged')

							{

								if($bedallocateddate==$leavingdate)

								{

									$quantity=$quantity1+1;

								}

								else

								{

									$quantity=$quantity1;

								}

							}

							else

							{

								$quantity=$quantity1;

							}

						}

						else

						{

							if($recordstatus=='discharged')

							{

								if($bedallocateddate==$leavingdate)

								{

									$quantity=$quantity1+1;

								}

								else

								{

									$quantity=$quantity1;

								}

							}

							else

							{

								$quantity=$quantity1;

							}

						}

						$amount = $quantity * $rate;						

						$allocatequantiy = $quantity;

						$allocatenewquantity = $quantity;

						if($quantity>0)

						{

							if($type=='hospital'||$charge!='Resident Doctor Charges')

							{

								$colorloopcount = $sno + 1;

								$showcolor = ($colorloopcount & 1); 

								if ($showcolor == 0)

								{

									//echo "if";

									$colorcode = 'bgcolor="#FFFFFF"';

								}

								else

								{

									//echo "else";

									$colorcode = 'bgcolor="#FFFFFF"';

								}

								$totalbedallocationamount=$totalbedallocationamount+($quantity*($rate));



				if($charge=="RMO Charges"){

					continue;

				}

								

					  ?>

					<tr>

<td width="169" align="left"  valign="center" class="bodytext31">&nbsp;</td>

                        <td class="bodytext31"  valign="center"  align="left"><strong><?php echo $charge;?></strong></td>

                        <td class="bodytext31" valign="center"  align="right"><?php  echo number_format($amount,2,'.',',');  ?></td>                   

                    </tr>              

					 

					   <?php 

							}

						}

					}

				}

				$totalbedtransferamount=0;

				$query18 = "select ward,bed,docno,recorddate,leavingdate,recordstatus from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode'";

				$exec18 = mysql_query($query18) or die ("Error in Query1".mysql_error());

				while($res18 = mysql_fetch_array($exec18))

				{

					$quantity1=0;

					$ward = $res18['ward'];

					$allocateward = $res18['ward'];			

					$bed = $res18['bed'];

					$refno = $res18['docno'];

					$date = $res18['recorddate'];

					//$bedallocateddate = $res18['recorddate'];

					$packagedate = $res18['recorddate'];

					$leavingdate = $res18['leavingdate'];

					$recordstatus = $res18['recordstatus'];

					if($leavingdate=='0000-00-00')

					{

						$leavingdate=$updatedate;

					}

					$query51 = "select bed,threshold from `$bedtable` where auto_number='$bed'";

					$exec51 = mysql_query($query51) or die(mysql_error());

					$res51 = mysql_fetch_array($exec51);

					$bedname = $res51['bed'];

					$threshold = $res51['threshold'];

					$thresholdvalue = $threshold/100;

					$time1 = new DateTime($date);

					$time2 = new DateTime($leavingdate);

					$interval = $time1->diff($time2);			  

					$quantity1 = $interval->format("%a");

					if($packdays1>$quantity1)

					{

						$quantity1=$quantity1-$packdays1; 

						$packdays1=$packdays1-$quantity1;

					}

					else

					{

						$quantity1=$quantity1-$packdays1;

						$packdays1=0;

					}

					$bedcharge='0';

					$quantity='0';



					$diff = abs(strtotime($leavingdate) - strtotime($bedallocateddate));

					$query91 = "select charge,rate from `$bedchargetable` where bedanum='$bed' and recordstatus ='' and charge not in ('Accommodation Charges','Cafetaria Charges')";

					$exec91 = mysql_query($query91) or die(mysql_error());

					$num91 = mysql_num_rows($exec91);

					while($res91 = mysql_fetch_array($exec91))

					{

						$charge = $res91['charge'];

						$rate = $res91['rate'];	

						

						if($charge!='Bed Charges')

						{

							//$quantity=$quantity1+1;

							if($recordstatus=='discharged')

							{

								if($bedallocateddate==$leavingdate)

								{

									$quantity=$quantity1+1;

								}

								else

								{

									$quantity=$quantity1;

								}

							}

							else

							{

								$quantity=$quantity1;

							}

						}

						else

						{

							if($recordstatus=='discharged')

							{

								if($bedallocateddate==$leavingdate)

								{

									$quantity=$quantity1+1;

								}

								else

								{

									$quantity=$quantity1;

								}

							}

							else

							{

								$quantity=$quantity1;

							}

						}

						$amount = $quantity * $rate;						

						$allocatequantiy = $quantity;

						$allocatenewquantity = $quantity;

						if($bedcharge=='0')

						{

							if($quantity>0)

							{

								if($type=='hospital'||$charge!='Resident Doctor Charges')

								{

									$colorloopcount = $sno + 1;

									$showcolor = ($colorloopcount & 1); 

									if ($showcolor == 0)

									{

										//echo "if";

										$colorcode = 'bgcolor="#FFFFFF"';

									}

									else

									{

										//echo "else";

										$colorcode = 'bgcolor="#FFFFFF"';

									}

									$totalbedtransferamount=$totalbedtransferamount+($quantity*($rate));

				if($charge=="RMO Charges"){

					continue;

				}



						  ?>

						<tr>

<td width="169" align="left"  valign="center" class="bodytext31">&nbsp;</td>

							<td class="bodytext31"  valign="center"  align="left"><strong><?php echo $charge;?></strong></td>

							<td class="bodytext31" valign="center"  align="right"><?php  echo number_format($amount,2,'.',',');  ?></td>                   

						</tr>							

						 

						   <?php 

								}

							}

							else

							{

								if($charge=='Bed Charges')

								{

									//$bedcharge='1';

								}

							}

						}

					}

				}

			

			*/

			  ?>

			 

			   <?php 

			   



			$original_fxrate= $fxrate;

			if(strtoupper($currency)=="USD"){

				$fxrate = $pharmacy_fxrate;

			}

						   



			$totalpharm=0;

			$phaamount31=0;

			$phaamount3=0;





			

			$query23 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and freestatus = 'No' GROUP BY ipdocno,itemcode order by entrydate";

			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_pharmacy = mysqli_num_rows($exec23);

			while($res23 = mysqli_fetch_array($exec23))

			{

			$phaquantity=0;

			$quantity1=0;

			$phaamount=0;

			$phaquantity1=0;

			$totalrefquantity=0;

			$phaamount1=0;

			$phadate=$res23['entrydate'];

			$phaname=$res23['itemname'];

			$phaitemcode=$res23['itemcode'];

			$pharate=$res23['rate'];

			$refno = $res23['ipdocno'];

			$quantity=$res23['quantity'];

			$pharmfree = $res23['freestatus'];

			$amount=$pharate*$quantity;

			$query33 = "select quantity,totalamount from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode' and ipdocno = '$refno'";

			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res33 = mysqli_fetch_array($exec33))

			{

			$quantity=$res33['quantity'];

			$phaquantity=$phaquantity+$quantity;

			$amount=$res33['totalamount'];

			$phaamount=$phaamount+$amount;

			}

   			$quantity=$phaquantity;

			$amount=$pharate*$quantity;

			$query331 = "select sum(quantity) as quantity, sum(totalamount) as totalamount from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and docnumber='$refno' and itemcode='$phaitemcode'";

			$exec331 = mysqli_query($GLOBALS["___mysqli_ston"], $query331) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		    $res331 = mysqli_fetch_array($exec331);

			

			$quantity1=$res331['quantity'];

			//$phaquantity1=$phaquantity1+$quantity1;

			$amount1=$res331['totalamount'];

			//$phaamount1=$phaamount1+$amount1;

			

			$resquantity = $quantity - $quantity1;

			$resamount = $amount - $amount1;

						

			$resamount=($resamount/$fxrate);

			//if($resquantity != 0)

			{



			if(strtoupper($pharmfree) =='NO')

			{



			$phaamount3=$phaamount3+$phaamount;

			$phaamount31=$phaamount31+$amount1; 



				$colorloopcount = $colorloopcount + 1;

			$showcolor = ($colorloopcount & 1); 

		

			$totalpharm=$totalpharm+$resamount;

			?>		

			  

			  <?php }

			  }

			  }

			  ?>



		<tr>

<td width="169" align="left"  valign="center" class="bodytext31">&nbsp;</td>

			<td class="bodytext31"  valign="center"  align="left"><strong>Pharmacy:</strong></td>

			 			

			 <td class="bodytext31" valign="center"  align="right"><?php  echo number_format(($phaamount3/$fxrate),2,'.',',');  ?></td>

		     

		</tr>

        <tr>

<td width="169" align="left"  valign="center" class="bodytext31">&nbsp;</td>

			<td class="bodytext31"  valign="center"  align="left"><strong>Pharmacy Returns:</strong></td>

			 

			 	

			 <td class="bodytext31" valign="center"  align="right">-<?php  echo number_format(($phaamount31/$fxrate),2,'.',',');  ?></td>

		     

		</tr>	

			

			  

			  <?php

			 //  }

//			  }

			 // }

			  ?>

			  <?php 

			 

			 

			$fxrate = $original_fxrate;



			  $totallab=0;

			  $query19 = "select * from ipconsultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> ''  and freestatus='No' order by consultationdate";

			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_lab = mysqli_num_rows($exec19);

				

			while($res19 = mysqli_fetch_array($exec19))

			{

			$labdate=$res19['consultationdate'];

			$labname=$res19['labitemname'];

			$labcode=$res19['labitemcode'];

			$labrate=$res19['labitemrate'];

			$labrefno=$res19['iptestdocno'];

			$labfree = $res19['freestatus'];

			

			if(strtoupper($labfree) == 'NO')

			{

			$queryl51 = "select labitemrate as rateperunit from `billing_iplab` where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemcode='$labcode'";

			$execl51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryl51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$resl51 = mysqli_fetch_array($execl51);

			$labrate = $resl51['rateperunit'];

			/*

			$queryl51 = "select rateperunit from `$labtable` where itemcode='$labcode'";

			$execl51 = mysql_query($queryl51) or die(mysql_error());

			$resl51 = mysql_fetch_array($execl51);

			$labrate = $resl51['rateperunit'];*/

			

			

			$totallab=$totallab+$labrate;

			 }

			  }

			?>

        

		<tr>

<td width="169" align="left"  valign="center" class="bodytext31">&nbsp;</td>

			<td class="bodytext31"  valign="center"  align="left"><strong>Laboratory:</strong></td>

			

				

			<td class="bodytext31" valign="center"  align="right"><?php echo number_format($totallab,2,'.',','); ?></td>

		</tr>	

			  

			  <?php 

			 

			  ?>

			  

			    <?php 

				$totalrad=0;

			  $query20 = "select * from ipconsultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund' and freestatus= 'No' order by consultationdate";

			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_radio = mysqli_num_rows($exec20);

						

			/*if($num_radio>0){

			echo "<tr><td colspan='7'><strong>RADIOLOGY</strong></td></tr>";   

			}*/

			

			while($res20 = mysqli_fetch_array($exec20))

			{

			$raddate=$res20['consultationdate'];

			$radname=$res20['radiologyitemname'];

			$radrate=$res20['radiologyitemrate'];

			$radref=$res20['iptestdocno'];

			$radiologyfree = $res20['freestatus'];

			$radiologyitemcode = $res20['radiologyitemcode'];

			if(strtoupper($radiologyfree) == 'NO')

			{

			$queryr51 = "select radiologyitemrate rateperunit from `billing_ipradiology` where  patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemcode='$radiologyitemcode'";

			$execr51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$resr51 = mysqli_fetch_array($execr51);

			$radrate = $resr51['rateperunit'];

			/*

			$queryr51 = "select rateperunit from `$radtable` where itemcode='$radiologyitemcode'";

			$execr51 = mysql_query($queryr51) or die(mysql_error());

			$resr51 = mysql_fetch_array($execr51);

			$radrate = $resr51['rateperunit']; */

			

			

			$totalrad=$totalrad+$radrate;

			}

			}

			?>

       

		<tr>

<td width="169" align="left"  valign="center" class="bodytext31">&nbsp;</td>

        

			<td class="bodytext31"  valign="center"  align="left"><strong>Radiology:</strong></td>

			

			<td class="bodytext31" valign="center"  align="right"><?php echo number_format($totalrad,2,'.',','); ?></td>

		</tr>	

			  

			  <?php 

			  $theatreamt=0;

			

		   $query199 = "select * from ipconsultation_services where servicesitemname like '%THEATRE%' AND patientvisitcode='$visitcode' and patientcode='$patientcode' and wellnessitem <> '1' ";

			$exec199 = mysqli_query($GLOBALS["___mysqli_ston"], $query199) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			

				

			while($res199 = mysqli_fetch_array($exec199))

			{

			

			$theatrerate=$res199['amount'];

			$theatrefreestatus=$res199['freestatus'];

			

			

			if(strtoupper($theatrefreestatus) == 'NO')

			{

			

			



			//$theatreamt=$theatreamt+$theatrerate;

			  }

              }

			?>

        

		<?php /*?><tr>

<td width="169" align="left"  valign="center" class="bodytext31">&nbsp;</td>

			<td class="bodytext31"  valign="center"  align="left"><strong>Theatre:</strong></td>

			

				

			<td class="bodytext31" valign="center"  align="right"><?php echo number_format($theatreamt,2,'.',','); ?></td>

		</tr><?php */?>

        <?php	

            		

			  ?>

			  	    <?php 

					

			

					$totalser=0;

		    $query21 = "select consultationdate,servicesitemname,servicesitemrate,iptestdocno,freestatus,servicesitemcode,serviceqty from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> '' and servicerefund <> 'refund' and wellnessitem <> '1' group by servicesitemcode, iptestdocno order by consultationdate";

			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res21 = mysqli_fetch_array($exec21))

			{

			$totserrate = 0;

			$serdate=$res21['consultationdate'];

			$sername=$res21['servicesitemname'];

			$serrate=$res21['servicesitemrate'];

			$serref=$res21['iptestdocno'];

			$servicesfree = $res21['freestatus'];

			$sercode=$res21['servicesitemcode'];

			$serqty=$res21['serviceqty'];

			/*

			$querys51 = "select rateperunit from `$sertable` where itemcode='$sercode'";

			$execs51 = mysql_query($querys51) or die(mysql_error());

			$ress51 = mysql_fetch_array($execs51);

			$serrate = $ress51['rateperunit'];*/



			$query2111 = "select serviceqty, amount from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and servicerefund <> 'refund' and iptestdocno = '$serref'";

			$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]));

			$numrow2111 = mysqli_num_rows($exec2111);

			$resqty = mysqli_fetch_array($exec2111);

			 $serqty=$resqty['serviceqty'];

			if($serqty==0){$serqty=$numrow2111;}

			

			

 			$querys51 = "select sum(servicesitemrate) as rateperunit from `billing_ipservices` where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode='$sercode' and wellnessitem <> '1'";

			$execs51 = mysqli_query($GLOBALS["___mysqli_ston"], $querys51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$ress51 = mysqli_fetch_array($execs51);

			$serrate = $ress51['rateperunit'];

           /*

			$query2111 = "select sum(serviceqty) as serviceqty from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and servicerefund <> 'refund' and wellnessitem <> '1'";

			$exec2111 = mysql_query($query2111) or die ("Error in Query2111".mysql_error());

			$numrow2111 = mysql_num_rows($exec2111);

			$resqty = mysql_fetch_array($exec2111);

			 $serqty1=$resqty['serviceqty'];

			if($serqty==0){$serqty=$numrow2111;}

			$serrate = $serrate/$serqty1; */

			if(strtoupper($servicesfree) == 'NO')

			{

			 $totserrate=$resqty['amount'];

			/*   if($totserrate==0){

			$totserrate=$serrate*$numrow2111;

			  }

			$totserrate=$serrate*$serqty; */

			  $totalser=$totalser+$totserrate;

			}

			}

			?>

            

			<tr>

<td width="169" align="left"  valign="center" class="bodytext31">&nbsp;</td>

				<td class="bodytext31"  valign="center"  align="left"><strong>Services and Procedures:</strong></td>

								

				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($totalser,2,'.',','); ?></td>

			</tr>	

			  

			 

			<?php

			$totalotbillingamount = 0;

			$query61 = "select * from ip_otbilling where patientcode='$patientcode' and patientvisitcode='$visitcode' order by consultationdate";

			$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_ot = mysqli_num_rows($exec61);

			/*if($num_ot>0 ){

				echo "<tr><td colspan='7'><strong>OT SURGERY</strong></td></tr>";

			}*/

			while($res61 = mysqli_fetch_array($exec61))

		   {

			$otbillingdate = $res61['consultationdate'];

			$otbillingrefno = $res61['docno'];

			$otbillingname = $res61['surgeryname'];

			$otbillingrate = $res61['rate'];

			$otbillingrate = 1*($otbillingrate/$fxrate);

			$totalotbillingamount = $totalotbillingamount + $otbillingrate;

		   }

		   if($totalotbillingamount!=0){

			?>

		<tr>

<td width="169" align="left"  valign="center" class="bodytext31">&nbsp;</td>

			<td class="bodytext31"  valign="center"  align="left"><strong>OT Surgery:</strong></td>

			

			

			<td class="bodytext31" valign="center"  align="right"><?php echo number_format($totalotbillingamount,2,'.',','); ?></td>

		</tr>

				

				<?php

		   }

			$totalprivatedoctoramount = 0;

			$query62 = "select * from ipprivate_doctor where patientcode='$patientcode' and patientvisitcode='$visitcode' and pvt_flg = '1' order by consultationdate";

			$exec62 = mysqli_query($GLOBALS["___mysqli_ston"], $query62) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_pvt = mysqli_num_rows($exec62);

			

			while($res62 = mysqli_fetch_array($exec62))

		   {

			$privatedoctordate = $res62['consultationdate'];

			$privatedoctorrefno = $res62['docno'];

			$privatedoctor = $res62['doctorname'];

			$privatedoctorrate = $res62['rate'];

			$privatedoctoramount = $res62['amount'];

			$privatedoctorunit = $res62['units'];

			$description = $res62['remarks'];

			if($description != '')

			{

			$description = '-'.$description;

			}

			$privatedoctoramount = $privatedoctorunit*($privatedoctorrate/$fxrate);

			$totalprivatedoctoramount = $totalprivatedoctoramount + $privatedoctoramount;

		   }

			?>

            

			<tr>

<td width="169" align="left"  valign="center" class="bodytext31">&nbsp;</td>

				<td class="bodytext31"  valign="center"  align="left"><strong>PVT Doctor Charges</strong></td>

				

				

			

				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($totalprivatedoctoramount,2,'.',','); ?></td>

			</tr>

				

				<?php

				

				

			$totalambulanceamount = 0;

			$query63 = "select * from ip_ambulance where patientcode='$patientcode' and patientvisitcode='$visitcode' order by consultationdate";

			$exec63 = mysqli_query($GLOBALS["___mysqli_ston"], $query63) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_rescue = mysqli_num_rows($exec63);

			

			while($res63 = mysqli_fetch_array($exec63))

		   {

			$ambulancedate = $res63['consultationdate'];

			$ambulancerefno = $res63['docno'];

			$ambulance = $res63['description'];

			$ambulancerate = $res63['rate'];

			$ambulanceamount = $res63['amount'];

			$ambulanceunit = $res63['units'];

			$ambulanceamount = $ambulanceunit*($ambulancerate/$fxrate);			

			$totalambulanceamount = $totalambulanceamount + $ambulanceamount;

		   }

			?>

            

			<tr>

<td width="169" align="left"  valign="center" class="bodytext31">&nbsp;</td>

				<td class="bodytext31"  valign="center"  align="left"><strong>Rescue Charges:</strong></td>

				

							

				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($totalambulanceamount,2,'.',','); ?></td>

			</tr>

				

				<?php

			$totalmiscbillingamount = 0;

			$query69 = "select * from ipmisc_billing where patientcode='$patientcode' and patientvisitcode='$visitcode' order by consultationdate";

			$exec69 = mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_misc = mysqli_num_rows($exec69);

			/*if($num_misc>0){

			echo "<tr><td colspan='7'><strong>MISC CHARGES</strong></td></tr>";

			}*/

			while($res69 = mysqli_fetch_array($exec69))

		   {

			$miscbillingdate = $res69['consultationdate'];

			$miscbillingrefno = $res69['docno'];

			$miscbilling = $res69['description'];

			$miscbillingrate = $res69['rate'];

			$miscbillingamount = $res69['amount'];

			$miscbillingunit = $res69['units'];

			$miscbillingamount = $miscbillingunit*($miscbillingrate/$fxrate);

			$totalmiscbillingamount = $totalmiscbillingamount + $miscbillingamount;

		   }

			?>

			<tr>

<td width="169" align="left"  valign="center" class="bodytext31">&nbsp;</td>

				<td class="bodytext31"  valign="center"  align="left"><strong>MISC Charges: </strong></td>

				

								

				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($totalmiscbillingamount,2,'.',','); ?></td>

			</tr>

				

				<?php

				 $payoveralltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totalmiscbillingamount+$theatreamt); 

				?>			

			

            

            

			<tr>

<td width="169" align="left"  valign="center" class="bodytext31">&nbsp;</td>

			<td align="left" class="bodytext31" valign="center"><strong>Total Bill Amount:</strong></td>

			<td align="right" class="bodytext31" valign="middle" style=""><?php echo number_format($payoveralltotal,2,'.',','); ?></td>

			</tr>

			

            

            <?php 

				

			$totalcreditamt = 0;

		  	$totaldiscountamount = 0;

			$query64 = "select * from ip_discount where patientcode='$patientcode' and patientvisitcode='$visitcode'";

			$exec64 = mysqli_query($GLOBALS["___mysqli_ston"], $query64) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res64 = mysqli_fetch_array($exec64))

		   {

			 $discountrate = $res64['rate']/$fxrate;

			 $discountrate = -$discountrate;

			// $discountrate = 1*($discountrate/$fxrate);

			 $totaldiscountamount = $totaldiscountamount + $discountrate;  

			   

		   }


		   $query641 = "select * from ip_nhifprocessing where locationcode='$locationcode' and patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec641 = mysqli_query($GLOBALS["___mysqli_ston"], $query641) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res641= mysqli_fetch_array($exec641))
		   {
			   $nhifqty = $res641['totaldays'];
			$nhifrate = $res641['nhifrebate'];
			$nhifclaim = $res641['nhifclaim'];
			//$nhifclaim = -$nhifclaim;
			$nhifclaim = $nhifqty*($nhifrate/$fxrate);
			$totaldiscountamount = $totaldiscountamount - $nhifclaim; 
		   }
		   $totalcreditamt = $totalcreditamt + $totaldiscountamount; 

			?>

			<tr>

<td width="169" align="left"  valign="center" class="bodytext31">&nbsp;</td>

				<td class="bodytext31"  valign="center"  align="left"><strong>Total Credits</strong></td>

				

				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($totalcreditamt,2,'.',','); ?></td>

			</tr>

			

            

			<?php

			

			$totaldepositfinal=0;

			$totaldepositamount=0;

			$totaldepositrefundamount = 0;	

			$depositrefundamount=0;

			$totaldeposit=0;

			$tot=0;

			$query112 = "select *,sum(transactionamount) as transactionamount from master_transactionipdeposit where patientcode='$patientcode' and visitcode='$visitcode'";

			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_receipt = mysqli_num_rows($exec112);

			

			while($res112 = mysqli_fetch_array($exec112))

			{

			$depositamount = $res112['transactionamount'];

			//$depositamount = 1*($depositamount/$fxrate);

			$depositamount1 = $depositamount;

			$docno = $res112['docno'];

			$transactionmode = $res112['transactionmode'];

			$transactiondate = $res112['transactiondate'];

			$chequenumber = $res112['chequenumber'];

			

			$query731 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";

			$exec731 = mysqli_query($GLOBALS["___mysqli_ston"], $query731) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res731 = mysqli_fetch_array($exec731);

			$depositbilltype = $res731['billtype'];

			

			$totaldiscountamount = 0;

			

			 

			$query1122 = "select *,sum(amount) as amount from deposit_refund where patientcode='$patientcode' and visitcode='$visitcode'";

			$exec1122 = mysqli_query($GLOBALS["___mysqli_ston"], $query1122) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_receipt1 = mysqli_num_rows($exec1122);

			 while($res1122 = mysqli_fetch_array($exec1122))

			{

			$depositrefundamount = $res1122['amount'];

			

			$totaldepositrefundamount = $totaldepositrefundamount + $depositrefundamount;

			 

			}

			

			$totaldepositamount = $totaldepositamount + $depositamount1;

			$tot=$tot+$depositamount1; 

			$totaldeposit=$tot-$totaldepositrefundamount-$totaldiscountamount; 

			$totaldeposit=-$totaldeposit; 

			} 

			//*****************advance deposit*******************

			$totaladvancedepositamount = 0;

			$queryadv = "select *,sum(transactionamount) as transactionamount from master_transactionadvancedeposit where patientcode='$patientcode' and visitcode='$visitcode'";

			$execadv = mysqli_query($GLOBALS["___mysqli_ston"], $queryadv) or die("Error in Queryadv".mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_advdep = mysqli_num_rows($execadv);

			 while($resadv = mysqli_fetch_array($execadv))

			{

			$advancedepositamount = $resadv['transactionamount'];

			

			$totaladvancedepositamount += $advancedepositamount;			 

			}

			//*****************advance deposit ends*******************

			$totaldeposit += $totaladvancedepositamount;

			$totaldepositfinal=-$totaldeposit/$fxrate;

			

			?>

			<tr>

<td width="169" align="left"  valign="center" class="bodytext31">&nbsp;</td>

				<td class="bodytext31" colspan="1" valign="center"  align="left"><strong>Less Deposit and Deposit Refunds:</strong></td>

				<td class="bodytext31" colspan="1" valign="center"  align="right"><?php echo number_format($totaldeposit/$fxrate,2,'.',','); ?></td>

			</tr>

			   

               <?php

			

				$net_amount_summary=$payoveralltotal+$totalcreditamt+($totaldeposit/$fxrate)

			?>

			  



			<tr>

<td width="169" align="left"  valign="center" class="bodytext31">&nbsp;</td>

				<td class="bodytext31" colspan="1" valign="center"  align="left"><strong>Net Total:</strong></td>

				<td class="bodytext31" colspan="1" valign="center"  align="right"><?php echo number_format($net_amount_summary,2,'.',','); ?></td>

			</tr>



	</table>

	  <table width="100%" border="0"  cellpadding="0" cellspacing="0" align="center">

 

  <tr>

    <td colspan="2" align="center"><strong><?php echo 'Diagnosis'; ?></strong></td>

  </tr>

   <tr>

   <td colspan="2" align="left">&nbsp;</td>

   </tr>

 <tr>

   <th width='125' align="left">ICD Code</th>

   <th width='600' align="left">ICD Name</th>

   </tr>

<tr>

    <td colspan="2" align="left"><strong><?php echo 'Impression'; ?></strong></td>

  </tr>

 <?php $queryicd = "select * from discharge_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number DESC";

$execicd = mysqli_query($GLOBALS["___mysqli_ston"], $queryicd) or die ("Error in queryicd".mysqli_error($GLOBALS["___mysqli_ston"]));

while($resicd = mysqli_fetch_array($execicd)){

$primarycode = $resicd['primaryicdcode'];

$primary = $resicd['primarydiag'];

?>

 <tr>

   <td align="left"><?= $primarycode; ?></td>

   <td  align="left"><?= $primary; ?></td>

   </tr>

<?php

}

?>

<tr>

    <td colspan="2" align="left"><strong><?php echo 'Final Diagnosis'; ?></strong></td>

  </tr>

 <?php $queryicd = "select * from discharge_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number DESC";

$execicd = mysqli_query($GLOBALS["___mysqli_ston"], $queryicd) or die ("Error in queryicd".mysqli_error($GLOBALS["___mysqli_ston"]));

while($resicd = mysqli_fetch_array($execicd)){

$primarycode = $resicd['secicdcode'];

$primary = $resicd['secondarydiag'];

?>

 <tr>

   <td align="left"><?= $primarycode; ?></td>

   <td  align="left"><?= $primary; ?></td>

   </tr>

<?php

}

?>

<tr>

   <td colspan="2" align="left">&nbsp;</td>

   </tr>

</table>

<br />

		<table width="" border=""  align="center" cellpadding="0" cellspacing="2">

        

			<tr>

			 	<td colspan="7"  align="center"><span class="underline">FINAL INVOICE</span></td>

			</tr>

             

		<thead>

			<tr>

				<td width="20" align="left" valign="center" 

				bgcolor="#ffffff" class="bodytext31"><strong></strong></td>

				<td  align="left" valign="center" width="85"

				bgcolor="#ffffff" class="bodytext31"><strong>BILL DATE</strong></td>

				<td  align="left" valign="center" width="85"

				bgcolor="#ffffff" class="bodytext31"><strong>Ref.No</strong></td>

				<td  align="left" valign="center" style="white-space:normal" width="225"

				bgcolor="#ffffff" class="bodytext31"><strong>Description</strong></td>

				<td  align="right" valign="center" width="45"

				bgcolor="#ffffff" class="bodytext31"><strong>Qty</strong></td>

				<td  align="right" valign="center" width="75"

				bgcolor="#ffffff" class="bodytext31"><strong>Rate</strong></td>

				<td  align="right" valign="center" width="75"

				bgcolor="#ffffff" class="bodytext31"><strong>Amount</strong></td>

			</tr>

          </thead>

            <tbody>

            <?php

			$colorloopcount = '';

			$sno = '';

			$totalamount=0;

			$totalquantity = 0;

			$totalop =0;

			$query17 = "select * from master_ipvisitentry where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";

			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res17 = mysqli_fetch_array($exec17);

			$consultationfee=$res17['admissionfees'];

			$packageanum1 = $res17['package'];

			$consultationfee = number_format($consultationfee,2,'.','');

			$viscode=$res17['visitcode'];

			$consultationdate=$res17['consultationdate'];

			$packchargeapply = $res17['packchargeapply'];

			

			

			$query53 = "select * from ip_bedallocation where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";

			$exec53 = mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res53 = mysqli_fetch_array($exec53);

			$refno = 'ADMCHRG';

			

			if($packageanum1 != 0)

			{

			if($packchargeapply == 1)

		{

			$colorloopcount = $colorloopcount + 1;

			$showcolor = ($colorloopcount & 1); 

			if ($showcolor == 0)

			{

				//echo "if";

				$colorcode = 'bgcolor="#CBDBFA"';

			}

			else

			{

				//echo "else";

				$colorcode = 'bgcolor="#ecf0f5"';

			}

			//$totalop=$consultationfee/$fxrate;

                       $totalop=$consultationfee;

					

	?>

            <tr>

            <td colspan="6"><strong>ADMISSION FEE</strong></td></tr>

			  <tr>

			 <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td> 

			    <td class="bodytext31" valign="center"  align="left" width="85"><?php echo date('d-m-Y',strtotime($consultationdate)); ?></td>

				<td class="bodytext31" valign="center"  align="left" width="85"><?php echo $alloc_docno; ?></td>

			 <td class="bodytext31" valign="center"  align="left" width="225"><?php echo 'Admission Charge'; ?></td>

			     <td class="bodytext31" valign="center"  align="right" width="45"><?php echo '1'; ?></td>

                <td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($consultationfee,2,'.',','); ?></td>

				 <td class="bodytext31" valign="center"  align="right" width="75	"><?php echo $consultationfee; ?></td>

				

           	</tr>

			<?php

			}

			}

			else

			{

			$colorloopcount = $colorloopcount + 1;

			$showcolor = ($colorloopcount & 1); 

			if ($showcolor == 0)

			{

				//echo "if";

				$colorcode = 'bgcolor="#CBDBFA"';

			}

			else

			{

				//echo "else";

				$colorcode = 'bgcolor="#ecf0f5"';

			}

			//$totalop=$consultationfee/$fxrate;

			$totalop=$consultationfee;

			?>

            <tr><td colspan="6"><strong>ADMISSION FEE</strong></td></tr>

			  <tr>

			 <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td> 

			    <td class="bodytext31" valign="center"  align="left" width="85"><?php echo date('d-m-Y', strtotime($consultationdate)); ?></td>

				<td class="bodytext31" valign="center"  align="left" width="85"><?php echo $alloc_docno; ?></td>

			 <td class="bodytext31" valign="center"  align="left" width="225"><?php echo 'Admission Charge'; ?></td>

			     <td class="bodytext31" valign="center"  align="right" width="45"><?php echo '1'; ?></td>

                <td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($consultationfee,2,'.',','); ?></td>

				 <td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($consultationfee,2,'.',','); ?></td>

				

           	</tr>

			<?php

			}

			?>

			<?php



					  $packageamount = 0;

			 $query731 = "select * from master_ipvisitentry where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";

			$exec731 = mysqli_query($GLOBALS["___mysqli_ston"], $query731) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res731 = mysqli_fetch_array($exec731);

			$packageanum1 = $res731['package'];

			$packagedate1 = $res731['consultationdate'];

			$packageamount = $res731['packagecharge'];

			

			$query741 = "select * from master_ippackage where  auto_number='$packageanum1'";

			$exec741 = mysqli_query($GLOBALS["___mysqli_ston"], $query741) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res741 = mysqli_fetch_array($exec741);

			$packdays1 = $res741['days'];

			$description = $res741['servicescode'];

			$packagename = $res741['packagename'];

			

			

			if($packageanum1 != 0)

	{

	

	 $reqquantity = $packdays1;

	 

	 $reqdate = date('Y-m-d',strtotime($packagedate1) + (24*3600*$reqquantity));

	 

			  $colorloopcount = $colorloopcount + 1;

			$showcolor = ($colorloopcount & 1); 

		

			  ?>
              <tr><td colspan="6">&nbsp;</td></tr>
              <tr><td colspan="6"><strong>PACKAGE CHARGE</strong></td></tr>

		<tr>

			<td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td> 

			<td class="bodytext31" valign="center"  align="left" width="85"><?php echo  date('d-m-Y', strtotime($packagedate1)); ?></td>

			<td class="bodytext31" valign="center"  align="left" width="85"><?php echo $description; ?></td>

			<td class="bodytext31" valign="center"  align="left" width="225"><?php echo $packagename; ?></td>

			<td class="bodytext31" valign="center"  align="right" width="45"><?php echo '1'; ?></td>

			<td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($packageamount,2,'.',','); ?></td>

			<td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($packageamount,2,'.',','); ?></td>

		</tr>

			  <?php

			  }

			  ?>

						<?php 

			$totalbedallocationamount = 0;

			

			 $requireddate = '';

			 $quantity = '';

			 $allocatenewquantity = '';

$totalbedtransferamount=0;



			$ki=1;

			/*$querya01 = "select * from billing_ipbedcharges where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode' and docno='$billno' and bed <> '0' order by recorddate";*/
			
			$querya01 = "select * from billing_ipbedcharges where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'  and bed <> '0' order by recorddate";

			$execa01 = mysqli_query($GLOBALS["___mysqli_ston"], $querya01) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$numa01 = mysqli_num_rows($execa01);

			if($numa01>0){

				echo "<tr><td colspan='6'>&nbsp;</td></tr><tr><td colspan='7'><strong>BED CHARGES</strong></td></tr>";	

			}

			while($resca01=mysqli_fetch_array($execa01)){


				$ref=$resca01['auto_number'];

				$date=$resca01['recorddate'];

				$refno =$visitcode;

				$charge=$resca01['description'];

				$bed=$resca01['bed'];

				$ward=$resca01['ward'];

				$quantity=$resca01['quantity'];

				$rate=$resca01['rate'];

				$amount=$resca01['amount'];

				

				$querybed = mysqli_query($GLOBALS["___mysqli_ston"], "select bed from master_bed where auto_number='$bed'");

				$resbed = mysqli_fetch_array($querybed);

				$bedname = $resbed['bed'];

				

				$queryward = mysqli_query($GLOBALS["___mysqli_ston"], "select description from master_ward where auto_number='$ward'");

				$resward = mysqli_fetch_array($queryward);

				$wardname = $resward['description'];

				

				if($quantity==0){

					$quantity=1;

				}

				if($charge == 'Cafetaria Charges')

									{

										$charge1 = 'Meals';

									}

									elseif($charge == 'Nursing Charges')

									{

										$charge1 = 'Nursing Care';

									}

									elseif($charge == 'RMO Charges')

									{

										$charge1 = 'Doctors Review';

									}

									elseif($charge == 'Accommodation Charges')

									{

										$charge1 = 'Non Pharms';

									}

									else{

										$charge1 = $charge;
									
									}
										if($charge=='Bed Charges'){
                                        $wardname=$bedname;
										}else
										{
										  $wardname=$bedname.'/'.$ref;  
										}
									if($quantity!=0){

				$totalbedallocationamount=$totalbedallocationamount+$amount;



				?>	

                <tr>

                    <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno+1; ?></td> 

                    <td class="bodytext31" valign="center"  align="left" width="85"><?php echo date("d-m-Y", strtotime($date)); ?></td>

                    <td class="bodytext31" valign="center"  align="left" width="85"><?php echo trim($wardname); ?></td>

                    <td class="bodytext31" valign="center"  align="left" width="225"><?php echo trim($charge1).' ('.$bedname.')'; ?></td>

                    <td class="bodytext31" valign="center"  align="right" width="45"><?php echo $quantity; ?></td>

                    <td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($rate,2,'.',','); ?></td>

                    <td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($amount,2,'.',','); ?></td>

                </tr>              

			

			<?php		 } // if qty !=0 ends		

			}

			?> 

			   <?php 

			

			$totalpharm=0;

		  $totallab=0;

				$totalrad=0;

					$totalser=0;

			$numrecords = 0;

			



//while (strtotime($from_limit_date) <= strtotime($to_limit_date)) {

               // echo "$from_limit_date\n";



			$queryn23 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and freestatus = 'No' GROUP BY ipdocno,itemcode";

			$execn23 = mysqli_query($GLOBALS["___mysqli_ston"], $queryn23) or die ("Error in queryn23".mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_pharmacyn = mysqli_num_rows($execn23);

			   

			$queryn19 = "select * from ipconsultation_lab where locationcode='$locationcode' and patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> ''  and freestatus='No' ";

			$execn19 = mysqli_query($GLOBALS["___mysqli_ston"], $queryn19) or die ("Error in queryn19".mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_labn = mysqli_num_rows($execn19);

			   

			$queryn20 = "select * from ipconsultation_radiology where locationcode='$locationcode' and patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund' and freestatus= 'No' ";

			$execn20 = mysqli_query($GLOBALS["___mysqli_ston"], $queryn20) or die ("Error in queryn20".mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_radion = mysqli_num_rows($execn20);

			   

			$queryn21 = "select * from ipconsultation_services where locationcode='$locationcode' and patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> '' and servicerefund <> 'refund' and wellnessitem <> '1' and freestatus = 'No'  group by servicesitemname,iptestdocno";

			$execn21 = mysqli_query($GLOBALS["___mysqli_ston"], $queryn21) or die ("Error in queryn21".mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_servicen = mysqli_num_rows($execn21);

			

			

			$numrecords = $num_pharmacyn + $num_labn + $num_radion + $num_servicen;

			

			if($numrecords > 0){

				

				//echo "<tr><td colspan='7' style='background-color:#ccc'><strong>".date('d M Y',strtotime($from_limit_date))."</strong></td></tr>";

				$data_count=0;

		

		

			$original_fxrate= $fxrate;

			if(strtoupper($currency)=="USD"){

				$fxrate = $pharmacy_fxrate;

			}

			 $titleName ='';
			$storequery ="select p.store as storecode,s.storelable as storelable from pharmacysales_details as p left join master_store as s on p.store=s.storecode where  p.visitcode='$visitcode' and p.patientcode='$patientcode' and p.freestatus = 'No' GROUP BY p.store order by s.storelable";

			$execStore = mysqli_query($GLOBALS["___mysqli_ston"], $storequery) or die ("Error in storequery".mysqli_error($GLOBALS["___mysqli_ston"]));
			$cateTotal = 0 ;
			$storetotal = 0 ;
            while($resStore = mysqli_fetch_array($execStore))
			{
			
			$query23 = "select * from pharmacysales_details where  visitcode='$visitcode' and patientcode='$patientcode' and freestatus = 'No' and store='".$resStore['storecode']."'  and from_module<>'fromtheaterbilling' GROUP BY ipdocno,itemcode order by entrydate";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_pharmacy = mysqli_num_rows($exec23);
			if($num_pharmacy>0){
				if($titleName!=$resStore['storelable']) {
				$titleName = $resStore['storelable'];
				if($resStore['storelable']=='ward')
					$catestoreName ='Ward Items';
				else
                   $catestoreName = ucfirst($resStore['storelable']);

				if($cateTotal>0){
				 echo "<tr><td colspan='5'>Total</td><td align='right'><strong>".number_format($cateTotal,2,'.',',')."</strong></td></tr>";
				 $cateTotal = 0 ;
				 }

				echo "<tr><td colspan='6'>&nbsp;</td></tr><tr><td colspan='7'><strong>".$catestoreName."</strong></td></tr>";
				
				}
			}

			//$query23 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and freestatus = 'No'  GROUP BY ipdocno,itemcode order by entrydate";

			//$exec23 = mysql_query($query23) or die ("Error in Query1".mysql_error());

			//$num_pharmacy = mysql_num_rows($exec23);

			//if($num_pharmacy>0){

			//	echo "<tr><td colspan='6'>&nbsp;</td></tr><tr><td colspan='7'><strong>PHARMACY</strong></td></tr>";

			//}

			while($res23 = mysqli_fetch_array($exec23))

			{

			$phaquantity=0;

			$quantity1=0;

			$phaamount=0;

			$phaquantity1=0;

			$totalrefquantity=0;

			$phaamount1=0;

			$phadate=$res23['entrydate'];

			$phaname=$res23['itemname'];

			$phaitemcode=$res23['itemcode'];

			$pharate=$res23['rate'];

			$refno = $res23['ipdocno'];

			$quantity=$res23['quantity'];

			$pharmfree = $res23['freestatus'];

			$amount=$pharate*$quantity;

			$query33 = "select quantity,totalamount from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode' and ipdocno = '$refno'";

			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res33 = mysqli_fetch_array($exec33))

			{

			$quantity=$res33['quantity'];

			$phaquantity=$phaquantity+$quantity;

			$amount=$res33['totalamount'];

			$phaamount=$phaamount+$amount;

			}

   			$quantity=$phaquantity;

			$amount=$pharate*$quantity;

			$query331 = "select sum(quantity) as quantity, sum(totalamount) as totalamount from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and docnumber='$refno' and itemcode='$phaitemcode'";

			$exec331 = mysqli_query($GLOBALS["___mysqli_ston"], $query331) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		    $res331 = mysqli_fetch_array($exec331);

			

			$quantity1=$res331['quantity'];

			//$phaquantity1=$phaquantity1+$quantity1;

			$amount1=$res331['totalamount'];

			//$phaamount1=$phaamount1+$amount1;

			

			$resquantity = $quantity - $quantity1;

			$resamount = $amount - $amount1;

						

			$resamount=($resamount/$fxrate);

			//if($resquantity != 0)

			{

			if(strtoupper($pharmfree) =='NO')

			{

				$colorloopcount = $colorloopcount + 1;

			$showcolor = ($colorloopcount & 1); 

			if($resquantity!=0){

			$totalpharm=$totalpharm+$resamount;

			$data_count++;
            //$cateTotal = $cateTotal +$resamount;
			?>

		<tr>

			<td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td> 

			  <td class="bodytext31" valign="center"  align="left" width="85"><?php echo  date('d-m-Y', strtotime($phadate)); ?></td>

			 <td class="bodytext31" valign="center"  align="left" width="85"><?php echo $phaitemcode; ?></td>

			 <td class="bodytext31" valign="center"  align="left"  width="225"nowrap="nowrap"><?php echo $phaname; ?></td>

			<!-- <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo $phaname; ?>">

			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo $resquantity; ?>">

			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php echo $pharate; ?>">

			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php echo $resamount; ?>"> -->

			 <td class="bodytext31" valign="center"  align="right" width="45"><?php echo $resquantity; ?></td>

             <td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format(($pharate/$fxrate),2,'.',','); ?></td>

			 <td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($resamount,2,'.',',');; ?></td>

		     

		</tr>	

			

			  

			  <?php } } // if qty !=0 ends		

			  }

			  }
			}

			  ?>

			  <?php 



				  $fxrate = $original_fxrate;

				  

				  $query19 = "select * from ipconsultation_lab where locationcode='$locationcode' and patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> ''  and freestatus='No' order by consultationdate";

			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_lab = mysqli_num_rows($exec19);

			if($num_lab>0){

			echo "<tr><td colspan='6'>&nbsp;</td></tr><tr><td colspan='7'><strong>LAB</strong></td></tr>";

			}

			while($res19 = mysqli_fetch_array($exec19))

			{

			$labdate=$res19['consultationdate'];

			$labname=$res19['labitemname'];

			$labcode=$res19['labitemcode'];

			$labrate=$res19['labitemrate'];

			$labrefno=$res19['iptestdocno'];

			$labfree = $res19['freestatus'];

			

			if(strtoupper($labfree) == 'NO')

			{

			

			$queryl51 = "select  labitemrate as rateperunit from `billing_iplab` where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemcode='$labcode'";

			$execl51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryl51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$resl51 = mysqli_fetch_array($execl51);

			$labrate = $resl51['rateperunit'];

			/*

			$queryl51 = "select rateperunit from `$labtable` where itemcode='$labcode'";

			$execl51 = mysql_query($queryl51) or die(mysql_error());

			$resl51 = mysql_fetch_array($execl51);

			$labrate = $resl51['rateperunit'];*/

			

			$totallab=$totallab+$labrate;

			$data_count++;

			?>

		<tr>

			<td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>

			<td class="bodytext31" valign="center"  align="left" width="85"><?php echo  date('d-m-Y', strtotime($labdate)); ?></td>

			<td class="bodytext31" valign="center"  align="left" width="85"><?php echo $labcode; ?></td>

		<!--	<input name="lab[]" id="lab" size="69" type="hidden" value="<?php echo $labname; ?>">

			<input name="rate5[]" id="rate5" readonly size="8" type="hidden" value="<?php echo $labrate; ?>">

			<input name="labcode[]" id="labcode" readonly size="8" type="hidden" value="<?php echo $labcode; ?>"> -->

			<td class="bodytext31" valign="center"  align="left" width="225"><?php echo $labname; ?></td>

			<td class="bodytext31" valign="center"  align="right" width="45"><?php echo '1'; ?></td>

			<td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($labrate,2,'.',','); ?></td>

			<td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($labrate,2,'.',','); ?></td>

		</tr>	

			  

			  <?php 

			  }

			  }

			  ?>

			  

			    <?php 

			 $query20 = "select * from ipconsultation_radiology where locationcode='$locationcode' and patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund' and freestatus= 'No' order by consultationdate";

			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_radio = mysqli_num_rows($exec20);						

			if($num_radio>0){

			echo "<tr><td colspan='6'>&nbsp;</td></tr><tr><td colspan='7'><strong>RADIOLOGY</strong></td></tr>";   

			}

			while($res20 = mysqli_fetch_array($exec20))

			{

			$raddate=$res20['consultationdate'];

			$radname=$res20['radiologyitemname'];

			$radrate=$res20['radiologyitemrate'];

			$radref=$res20['iptestdocno'];

			$radiologyfree = $res20['freestatus'];

			$radiologyitemcode = $res20['radiologyitemcode'];

			if(strtoupper($radiologyfree) == 'NO')

			{

			$queryr51 = "select radiologyitemrate rateperunit from `billing_ipradiology` where  patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemcode='$radiologyitemcode'";

			$execr51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$resr51 = mysqli_fetch_array($execr51);

			$radrate = $resr51['rateperunit'];

			/*

			$queryr51 = "select rateperunit from `$radtable` where itemcode='$radiologyitemcode'";

			$execr51 = mysql_query($queryr51) or die(mysql_error());

			$resr51 = mysql_fetch_array($execr51);

			$radrate = $resr51['rateperunit'];*/

			

			$totalrad=$totalrad+$radrate;

			$data_count++;

			?>

		<tr>

			<td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>

			<td class="bodytext31" valign="center"  align="left" width="85"><?php echo  date('d-m-Y', strtotime($raddate)); ?></td>

			<td class="bodytext31" valign="center"  align="left" width="85"><?php echo $radiologyitemcode; ?></td>

			<td class="bodytext31" valign="center"  align="left" width="225"><?php echo $radname; ?></td>

			

		<!--	<input name="radiology[]" id="radiology" type="hidden" size="69" autocomplete="off" value="<?php echo $radname; ?>">

			<input name="rate8[]" type="hidden" id="rate8" readonly size="8" value="<?php echo $radrate; ?>"> -->

			<td class="bodytext31" valign="center"  align="right" width="45"><?php echo '1'; ?></td>

			<td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($radrate,2,'.',','); ?></td>

			<td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($radrate,2,'.',','); ?></td>

		</tr>	

			  

			  <?php 

			  }

			  }

			  ?>

			  	    <?php 

					

		    $query21 = "select * from ipconsultation_services where locationcode='$locationcode' and patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> '' and servicerefund <> 'refund' and wellnessitem <> '1' and freestatus = 'No' and from_module<>'fromtheaterbilling' group by servicesitemname,iptestdocno order by consultationdate";

			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_service = mysqli_num_rows($exec21);

			if($num_service>0){

			echo "<tr><td colspan='6'>&nbsp;</td></tr><tr><td colspan='7'><strong>SERVICE</strong></td></tr>";

			}

			while($res21 = mysqli_fetch_array($exec21))

			{

			$totserrate =0 ;

			$serdate=$res21['consultationdate'];

			$sername=$res21['servicesitemname'];

			$serrate=$res21['servicesitemrate'];

			$serref=$res21['iptestdocno'];

			$servicesfree = $res21['freestatus'];

			$servicesdoctorname = $res21['doctorname'];

			$sercode=$res21['servicesitemcode'];

			$serqty = $res21['serviceqty'];

			

			$querys51 = "select rateperunit from `$sertable` where itemcode='$sercode'";

			$execs51 = mysqli_query($GLOBALS["___mysqli_ston"], $querys51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$ress51 = mysqli_fetch_array($execs51);

			$serrate = $ress51['rateperunit'];

			$query2111 = "select serviceqty, amount from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and servicerefund <> 'refund' and iptestdocno = '$serref'";

			$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]));

			$numrow2111 = mysqli_num_rows($exec2111);

			$resqty = mysqli_fetch_array($exec2111);

			 $serqty=$resqty['serviceqty'];

			if($serqty==0){$serqty=$numrow2111;}

			

			

/*			$querys51 = "select sum(servicesitemrate) as rateperunit from `billing_ipservices` where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode='$sercode' and wellnessitem <> '1'";

			$execs51 = mysql_query($querys51) or die(mysql_error());

			$ress51 = mysql_fetch_array($execs51);

			$serrate = $ress51['rateperunit'];

			$query2111 = "select sum(serviceqty) as serviceqty from ipconsultation_services where locationcode='$locationcode' and patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and servicerefund <> 'refund' and wellnessitem <> '1'"; 

			

			$query2111 = "select * from ipconsultation_services where locationcode='$locationcode' and patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and servicerefund <> 'refund' and wellnessitem <> '1' and consultationdate='$from_limit_date'  ";

			$exec2111 = mysql_query($query2111) or die ("Error in Query2111".mysql_error());

			$numrow2111 = mysql_num_rows($exec2111);

			

			$resqty = mysql_fetch_array($exec2111);

			// $serqty1=$resqty['serviceqty'];

			 if($serqty==0){$serqty=$numrow2111;}

			//$serrate = $serrate/$serqty1;*/

			

			if(strtoupper($servicesfree) == 'NO')

			{

				$totserrate=$resqty['amount'];

			/* 	 if($totserrate==0){

			$totserrate=$serrate*$numrow2111;

			  }

			$totserrate=($serqty*$serrate); */

	
			if($serqty!=0){ 
			$totalser=$totalser+$totserrate;

			$data_count++;

			?>

			<tr>

				 <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>

				<td class="bodytext31" valign="center"  align="left" width="85"><?php echo  date('d-m-Y', strtotime($serdate)); ?></td>

				<td class="bodytext31" valign="center"  align="left" width="85"><?php echo $sercode; ?></td>

				<td class="bodytext31" valign="center"  align="left"width="225"><?php echo $sername." - ".$servicesdoctorname; ?></td>

			<!--	<input name="services[]" type="hidden" id="services" size="69" value="<?php echo $sername; ?>">

				<input name="rate3[]" type="hidden" id="rate3" readonly size="8" value="<?php echo $serrate; ?>"> -->

				<td class="bodytext31" valign="center"  align="right" width="45"><?php echo (int)$serqty; ?></td>

				<td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($serrate,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($totserrate,2,'.',','); ?></td>

			</tr>	

			  

			  <?php 	} // if qty !=0 ends		
				} 

			  }



			if($data_count==0){

				echo "<tr ><td colspan='7'>No data found on this day.</td></tr>";				

			}



			}

			                  $from_limit_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_limit_date)));



			//}

			  ?>

			<?php

			$totalotbillingamount = 0;

			$query61 = "select * from ip_otbilling where locationcode='$locationcode' and patientcode='$patientcode' and patientvisitcode='$visitcode' order by consultationdate";

			$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_ot = mysqli_num_rows($exec61);

			if($num_ot>0 ){

				echo "<tr><td colspan='6'>&nbsp;</td></tr><tr><td colspan='7'><strong>OT SURGERY</strong></td></tr>";

			}

			while($res61 = mysqli_fetch_array($exec61))

		   {

			$otbillingdate = $res61['consultationdate'];

			$otbillingrefno = $res61['docno'];

			$otbillingname = $res61['surgeryname'];

			$otbillingrate = $res61['rate'];

			$otbillingrate = 1*($otbillingrate/$fxrate);

			$totalotbillingamount = $totalotbillingamount + $otbillingrate;

			?>

		<tr>

			<td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td> 

			<td class="bodytext31" valign="center"  align="left" width="85"><?php echo  date('d-m-Y', strtotime($otbillingdate)); ?></td>

			<td class="bodytext31" valign="center"  align="left" width="85"><?php echo $otbillingrefno; ?></td>

			<td class="bodytext31" valign="center"  align="left"width="225"><?php echo $otbillingname; ?></td>

		<!--	<input name="surgeryname[]" type="hidden" id="surgeryname" size="69" value="<?php echo $otbillingname; ?>">

			<input name="surgeryrate[]" type="hidden" id="surgeryrate" readonly size="8" value="<?php echo $otbillingrate; ?>"> -->

			<td class="bodytext31" valign="center"  align="right" width="45"><?php echo '1'; ?></td>

			<td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($otbillingrate,2,'.',','); ?></td>

			<td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($otbillingrate,2,'.',','); ?></td>

		</tr>

				<?php

				}

				?>

				<?php

			$totalprivatedoctoramount = 0;

			$query62 = "select * from ipprivate_doctor where  patientcode='$patientcode' and patientvisitcode='$visitcode' and pvt_flg = '1' and from_module<>'fromtheaterbilling' order by consultationdate";

			$exec62 = mysqli_query($GLOBALS["___mysqli_ston"], $query62) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_pvt = mysqli_num_rows($exec62);

			if($num_pvt>0 ){

				echo "<tr><td colspan='6'>&nbsp;</td></tr><tr><td colspan='7'><strong>PVT DOCTOR CHARGES</strong></td></tr>";

			}

			while($res62 = mysqli_fetch_array($exec62))

		   {

			$privatedoctordate = $res62['consultationdate'];

			$privatedoctorrefno = $res62['docno'];

			$privatedoctor = $res62['doctorname'];

			$privatedoctorrate = $res62['rate'];

			$privatedoctoramount = $res62['amount'];

			$privatedoctorunit = $res62['units'];

			$description = $res62['remarks'];

			if($description != '')

			{

			$description = '-'.$description;

			}

			$privatedoctoramount = $privatedoctorunit*($privatedoctorrate/$fxrate);

			$totalprivatedoctoramount = $totalprivatedoctoramount + $privatedoctoramount;

			?>

			<tr>

			    <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td> 

				<td class="bodytext31" valign="center"  align="left" width="85"><?php echo  date('d-m-Y', strtotime($privatedoctordate)); ?></td>

				<td class="bodytext31" valign="center"  align="left" width="85"><?php echo $privatedoctorrefno; ?></td>

				<td class="bodytext31" valign="center"  align="left"width="225"><?php echo $privatedoctor.' '.$description; ?></td>

			<!--	<input name="doctorname[]" type="hidden" id="doctorname" size="69" value="<?php echo $privatedoctor; ?>">

				<input name="doctorrate[]" type="hidden" id="doctorrate" readonly size="8" value="<?php echo $privatedoctorrate/$fxrate; ?>"> -->

				<td class="bodytext31" valign="center"  align="right" width="45"><?php echo $privatedoctorunit; ?></td>

				<td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($privatedoctorrate/$fxrate,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($privatedoctoramount,2,'.',','); ?></td>

			</tr>

				<?php

				}

				?>

				<?php

			$totalambulanceamount = 0;

			$query63 = "select * from ip_ambulance where locationcode='$locationcode' and patientcode='$patientcode' and patientvisitcode='$visitcode' order by consultationdate";

			$exec63 = mysqli_query($GLOBALS["___mysqli_ston"], $query63) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_rescue = mysqli_num_rows($exec63);

			if($num_rescue>0){

			echo "<tr><td colspan='6'>&nbsp;</td></tr><tr><td colspan='7'><strong>RESCUE CHARGES</strong></td></tr>";

			}

			while($res63 = mysqli_fetch_array($exec63))

		   {

			$ambulancedate = $res63['consultationdate'];

			$ambulancerefno = $res63['docno'];

			$ambulance = $res63['description'];

			$ambulancerate = $res63['rate'];

			$ambulanceamount = $res63['amount'];

			$ambulanceunit = $res63['units'];

			$ambulanceamount = $ambulanceunit*($ambulancerate/$fxrate);

			$totalambulanceamount = $totalambulanceamount + $ambulanceamount;

			?>

			<tr>

			    <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td> 

				<td class="bodytext31" valign="center"  align="left" width="85"><?php echo  date('d-m-Y', strtotime($ambulancedate)); ?></td>

				<td class="bodytext31" valign="center"  align="left" width="85"><?php echo $ambulancerefno; ?></td>

				<td class="bodytext31" valign="center"  align="left"width="225"><?php echo $ambulance; ?></td>

			<!--	<input name="doctorname[]" type="hidden" id="doctorname" size="69" value="<?php echo $ambulance; ?>">

				<input name="doctorrate[]" type="hidden" id="doctorrate" readonly size="8" value="<?php echo $ambulancerate; ?>"> -->

				<td class="bodytext31" valign="center"  align="right" width="45"><?php echo $ambulanceunit; ?></td>

				<td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($ambulancerate/$fxrate,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($ambulanceamount,2,'.',','); ?></td>

			</tr>

				<?php

				}

				?>

				<?php

			$totalmiscbillingamount = 0;

			$query69 = "select * from ipmisc_billing where locationcode='$locationcode' and patientcode='$patientcode' and patientvisitcode='$visitcode' and from_module<>'fromtheaterbilling' order by consultationdate";

			$exec69 = mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_misc = mysqli_num_rows($exec69);

			if($num_misc>0){

			echo "<tr><td colspan='6'>&nbsp;</td></tr><tr><td colspan='7'><strong>MISC CHARGES</strong></td></tr>";

			}

			while($res69 = mysqli_fetch_array($exec69))

		   {

			$miscbillingdate = $res69['consultationdate'];

			$miscbillingrefno = $res69['docno'];

			$miscbilling = $res69['description'];

			$miscbillingrate = $res69['rate'];

			$miscbillingamount = $res69['amount'];

			$miscbillingunit = $res69['units'];

			$miscbillingamount = $miscbillingunit*($miscbillingrate/$fxrate);

			$totalmiscbillingamount = $totalmiscbillingamount + $miscbillingamount;

			?>

			<tr>

				<td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td> 

				<td class="bodytext31" valign="center"  align="left" width="85"><?php echo  date('d-m-Y', strtotime($miscbillingdate)); ?></td>

				<td class="bodytext31" valign="center"  align="left" width="85"><?php echo $miscbillingrefno; ?></td>

				<td class="bodytext31" valign="center"  align="left"width="225"><?php echo $miscbilling; ?></td>

			<!--	<input name="doctorname[]" type="hidden" id="doctorname" size="69" value="<?php echo $miscbilling; ?>">

				<input name="doctorrate[]" type="hidden" id="doctorrate" readonly size="8" value="<?php echo $miscbillingrate; ?>"> -->

				<td class="bodytext31" valign="center"  align="right" width="45"><?php echo $miscbillingunit; ?></td>

				<td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($miscbillingrate/$fxrate,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($miscbillingamount,2,'.',','); ?></td>



			</tr>

				<?php

				}

				?>
				
				
				 <tr><td colspan='6'>&nbsp;</td></tr><tr><td colspan='7'><strong>THEATER ITEMS</strong></td></tr>
			<?php
			$querymis = "select * from ipmisc_billing where locationcode='$locationcode' and patientcode='$patientcode' and patientvisitcode='$visitcode'  and from_module='fromtheaterbilling' order by consultationdate";
			$execmis = mysqli_query($GLOBALS["___mysqli_ston"], $querymis) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($resmis = mysqli_fetch_array($execmis))
		   {
			$resmiscbillingdate = $resmis['consultationdate'];
			$resmiscbillingrefno = $resmis['docno'];
			$resmiscbilling = $resmis['description'];
			$resmiscbillingrate = $resmis['rate'];
			$resmiscbillingamount = $resmis['amount'];
			$resmiscbillingunit = $resmis['units'];
			$resmiscbillingamount = $resmiscbillingunit*($resmiscbillingrate/$fxrate);
			$totalmiscbillingamount = $totalmiscbillingamount + $resmiscbillingamount;
			?>	
			<tr>
				<td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td> 
				<td class="bodytext31" valign="center"  align="left" width="85"><?php echo  date('d-m-Y', strtotime($resmiscbillingdate)); ?></td>
				<td class="bodytext31" valign="center"  align="left" width="85"><?php echo $resmiscbillingrefno; ?></td>
				<td class="bodytext31" valign="center"  align="left"width="225"><?php echo $resmiscbilling; ?></td>
				<td class="bodytext31" valign="center"  align="right" width="45"><?php echo $resmiscbillingunit; ?></td>
				<td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($resmiscbillingrate/$fxrate,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($resmiscbillingamount,2,'.',','); ?></td>
			</tr>
		   <?php } ?>
		   <?php 
			$queryipp = "select * from ipprivate_doctor where  patientcode='$patientcode' and patientvisitcode='$visitcode' and pvt_flg = '1' and from_module='fromtheaterbilling' order by consultationdate";
			$execipp = mysqli_query($GLOBALS["___mysqli_ston"], $queryipp) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($resipp = mysqli_fetch_array($execipp))
		   {
			$ippprivatedoctordate = $resipp['consultationdate'];
			$ippprivatedoctorrefno = $resipp['docno'];
			$ippprivatedoctor = $resipp['doctorname'];
			$ippprivatedoctorrate = $resipp['rate'];
			$ippprivatedoctoramount = $resipp['amount'];
			$ippprivatedoctorunit = $resipp['units'];
			$ippdescription = $resipp['remarks'];
			if($ippdescription != '')
			{
			$ippdescription = '-'.$ippdescription;
			}
			$ippprivatedoctoramount = $ippprivatedoctorunit*($ippprivatedoctorrate/$fxrate);
			$totalprivatedoctoramount = $totalprivatedoctoramount + $ippprivatedoctoramount;
			?>
			<tr>
			    <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td> 
				<td class="bodytext31" valign="center"  align="left" width="85"><?php echo  date('d-m-Y', strtotime($ippprivatedoctordate)); ?></td>
				<td class="bodytext31" valign="center"  align="left" width="85"><?php echo $ippprivatedoctorrefno; ?></td>
				<td class="bodytext31" valign="center"  align="left"width="225"><?php echo $ippprivatedoctor.' '.$ippdescription; ?></td>
				<td class="bodytext31" valign="center"  align="right" width="45"><?php echo $ippprivatedoctorunit; ?></td>
				<td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($ippprivatedoctorrate/$fxrate,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($ippprivatedoctoramount,2,'.',','); ?></td>
			</tr>
		   <?php }?>
		   
		   
		    <?php 
		    $queryser = "select * from ipconsultation_services where locationcode='$locationcode' and patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> '' and servicerefund <> 'refund' and wellnessitem <> '1' and freestatus = 'No'  and from_module='fromtheaterbilling' group by servicesitemname,iptestdocno order by consultationdate";
			$execser = mysqli_query($GLOBALS["___mysqli_ston"], $queryser) or die ("Error in Queryser".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($resser = mysqli_fetch_array($execser))
			{
			$totserrate =0 ;
			$resserdate=$resser['consultationdate'];
			$ressername=$resser['servicesitemname'];
			$resserrate=$resser['servicesitemrate'];
			$resserref=$resser['iptestdocno'];
			$resservicesfree = $resser['freestatus'];
			$resservicesdoctorname = $resser['doctorname'];
			$ressercode=$resser['servicesitemcode'];
			$resserqty = $resser['serviceqty'];

			
			$querys51 = "select rateperunit from `$sertable` where itemcode='$ressercode'";
			$execs51 = mysqli_query($GLOBALS["___mysqli_ston"], $querys51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$ress51 = mysqli_fetch_array($execs51);
			$serrate = $ress51['rateperunit'];

			$query2111 = "select serviceqty, amount from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$ressercode' and servicerefund <> 'refund' and iptestdocno = '$resserref'";
			$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numrow2111 = mysqli_num_rows($exec2111);
			$resqty = mysqli_fetch_array($exec2111);
			 $serqty=$resqty['serviceqty'];
			if($serqty==0){$serqty=$numrow2111;}

			if(strtoupper($servicesfree) == 'NO')
			{
				$totserrate=$resqty['amount'];
	
			if($serqty!=0){ 
			$totalser=$totalser+$totserrate;
			$data_count++;
			?>
			<tr>
				 <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
				<td class="bodytext31" valign="center"  align="left" width="85"><?php echo  date('d-m-Y', strtotime($resserdate)); ?></td>
				<td class="bodytext31" valign="center"  align="left" width="85"><?php echo $ressercode; ?></td>
				<td class="bodytext31" valign="center"  align="left"width="225"><?php echo $ressername." - ".$resservicesdoctorname; ?></td>
				<td class="bodytext31" valign="center"  align="right" width="45"><?php echo (int)$serqty; ?></td>
				<td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($serrate,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($totserrate,2,'.',','); ?></td>
			</tr>	
			  <?php 	} // if qty !=0 ends		
				} 
			  } ?>
			  
			<?php  
			if(strtoupper($currency)=="USD"){
				$fxrate = $pharmacy_fxrate;
			}
			$titleName ='';
			$storequerypharma ="select p.store as storecode,s.storelable as storelable from pharmacysales_details as p left join master_store as s on p.store=s.storecode where  p.visitcode='$visitcode' and p.patientcode='$patientcode' and p.freestatus = 'No' GROUP BY p.store order by s.storelable";
			$execStorepharma = mysqli_query($GLOBALS["___mysqli_ston"], $storequerypharma) or die ("Error in storequerypharma".mysqli_error($GLOBALS["___mysqli_ston"]));
			$cateTotal = 0 ;
			$storetotal = 0 ;
            while($resStorepharma = mysqli_fetch_array($execStorepharma))
			{
			$querypharma = "select * from pharmacysales_details where  visitcode='$visitcode' and patientcode='$patientcode' and freestatus = 'No' and from_module='fromtheaterbilling' and store='".$resStorepharma['storecode']."'  GROUP BY ipdocno,itemcode order by entrydate";
			$execpharma = mysqli_query($GLOBALS["___mysqli_ston"], $querypharma) or die ("Error in Querypharma".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_pharmacy = mysqli_num_rows($execpharma);
			while($respharma = mysqli_fetch_array($execpharma))
			{
			$phaquantity=0;
			$quantity1=0;
			$phaamount=0;
			$phaquantity1=0;
			$totalrefquantity=0;
			$phaamount1=0;
			$phadate=$respharma['entrydate'];
			$phaname=$respharma['itemname'];
			$phaitemcode=$respharma['itemcode'];
			$pharate=$respharma['rate'];
			$refno = $respharma['ipdocno'];
			$quantity=$respharma['quantity'];
			$pharmfree = $respharma['freestatus'];
			$amount=$pharate*$quantity;

			$query33phar = "select quantity,totalamount from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode' and ipdocno = '$refno'";
			$exec33phar = mysqli_query($GLOBALS["___mysqli_ston"], $query33phar) or die ("Error in Query33phar".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res33phar = mysqli_fetch_array($exec33phar))
			{
			$quantity=$res33phar['quantity'];
			$phaquantity=$phaquantity+$quantity;
			$amount=$res33phar['totalamount'];
			$phaamount=$phaamount+$amount;
			}
   			$quantity=$phaquantity;
			$amount=$pharate*$quantity;
			$query331phar = "select sum(quantity) as quantity, sum(totalamount) as totalamount from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and docnumber='$refno' and itemcode='$phaitemcode'";
			$exec331phar = mysqli_query($GLOBALS["___mysqli_ston"], $query331phar) or die ("Error in Query331phar".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $res331phar = mysqli_fetch_array($exec331phar);
			$quantity1=$res331phar['quantity'];
			//$phaquantity1=$phaquantity1+$quantity1;
			$amount1=$res331phar['totalamount'];
			//$phaamount1=$phaamount1+$amount1;
			$resquantity = $quantity - $quantity1;
			$resamount = $amount - $amount1;						
			$resamount=($resamount/$fxrate);
			//if($resquantity != 0)
			{
			if(strtoupper($pharmfree) =='NO')
			{
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if($resquantity!=0){
			$totalpharm=$totalpharm+$resamount;
			$data_count++;
            //$cateTotal = $cateTotal +$resamount;
			?>
		<tr>
			<td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td> 
			  <td class="bodytext31" valign="center"  align="left" width="85"><?php echo  date('d-m-Y', strtotime($phadate)); ?></td>
			 <td class="bodytext31" valign="center"  align="left" width="85"><?php echo $phaitemcode; ?></td>
			 <td class="bodytext31" valign="center"  align="left"  width="225"nowrap="nowrap"><?php echo $phaname; ?></td>
			 <td class="bodytext31" valign="center"  align="right" width="45"><?php echo $resquantity; ?></td>
             <td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format(($pharate/$fxrate),2,'.',','); ?></td>
			 <td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($resamount,2,'.',',');; ?></td>
		</tr>	
			  <?php 
			  } 
			  } // if qty !=0 ends		
			  }
			  }
			  }
			  ?> 
				
				
				
				
				
				
				
				

				<?php

				 $payoveralltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totalmiscbillingamount);

				?>			

			<tr>

			<td colspan="7" align="left" class="bodytext31" valign="middle" style="border-top:solid 1px #000000;"></td>

			</tr>

			<tr>

			<td align="right" class="bodytext31" colspan="6" valign="middle"><strong>INVOICE TOTAL AMOUNT :</strong></td>

			<td align="right" class="bodytext31" valign="middle" style=""><strong><?php echo number_format(round($payoveralltotal),2,'.',','); ?></strong></td>

			</tr>

			<tr>

			<td colspan="6" align="left" class="bodytext31" valign="middle" style="">&nbsp;</td>

			</tr>

			<?php

			$totaldepositamount = 0;

			$query112 = "select * from master_transactionipdeposit where locationcode='$locationcode' and patientcode='$patientcode' and visitcode='$visitcode' and transactionamount>0 order by transactiondate";

			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_receipt = mysqli_num_rows($exec112);

			if($num_receipt>0){

				$temp = 1;

				echo '<tr><td align="center" class="underline" colspan="6" valign="middle">RECEIPTS</td></tr>';	

			}

			while($res112 = mysqli_fetch_array($exec112))

			{

			$depositamount = $res112['transactionamount'];

			$depositamount = 1*($depositamount/$fxrate);

			$depositamount1 = -$depositamount;

			$docno = $res112['docno'];

			$transactionmode = $res112['transactionmode'];

			$transactiondate = $res112['transactiondate'];

			$chequenumber = $res112['chequenumber'];

			

			

			$query731 = "select * from master_ipvisitentry where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";

			$exec731 = mysqli_query($GLOBALS["___mysqli_ston"], $query731) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res731 = mysqli_fetch_array($exec731);

			$depositbilltype = $res731['billtype'];

		

		

			$totaldepositamount = $totaldepositamount + $depositamount1;

			?>

			<tr>

				<td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td> 

				<td class="bodytext31" valign="center"  align="left" width="85"><?php echo  date('d-m-Y', strtotime($transactiondate)); ?></td>

				<td class="bodytext31" valign="center"  align="left" width="85"><?php echo $docno; ?></td>

				<td class="bodytext31" valign="center"  align="left" width="225"><?php echo 'Deposit'; ?>&nbsp;&nbsp;<?php echo $transactionmode; ?>

				<?php

				if($transactionmode == 'CHEQUE')

				{

				echo $chequenumber;

				}

				?></td>

				<td class="bodytext31" valign="center"  align="right" width="45"><?php echo '1'; ?></td>

				<td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($depositamount,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right" width="75">-<?php echo number_format($depositamount,2,'.',','); ?></td>

			</tr>

			    

			  

			  <?php }

			  

			  $query112 = "select * from master_transactionadvancedeposit where locationcode='$locationcode' and patientcode='$patientcode' and visitcode='$visitcode' order by transactiondate";

			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			

			while($res112 = mysqli_fetch_array($exec112))

			{

			$depositamount = $res112['transactionamount'];

			$depositamount = 1*($depositamount/$fxrate);

			$depositamount1 = -$depositamount;

			$docno = $res112['docno'];

			$transactionmode = $res112['transactionmode'];

			$transactiondate = $res112['transactiondate'];

			$chequenumber = $res112['chequenumber'];

			

			

			$query731 = "select * from master_ipvisitentry where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";

			$exec731 = mysqli_query($GLOBALS["___mysqli_ston"], $query731) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res731 = mysqli_fetch_array($exec731);

			$depositbilltype = $res731['billtype'];

		

		

			$totaldepositamount = $totaldepositamount + $depositamount1;

			?>

			<tr>

				<td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td> 

				<td class="bodytext31" valign="center"  align="left" width="85"><?php echo  date('d-m-Y', strtotime($transactiondate)); ?></td>

				<td class="bodytext31" valign="center"  align="left" width="85"><?php echo $docno; ?></td>

				<td class="bodytext31" valign="center"  align="left" width="225"><?php echo 'Deposit'; ?>&nbsp;&nbsp;<?php echo $transactionmode; ?>

				<?php

				if($transactionmode == 'CHEQUE')

				{

				echo $chequenumber;

				}

				?></td>

				<td class="bodytext31" valign="center"  align="right" width="45"><?php echo '1'; ?></td>

				<td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($depositamount,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right" width="75">-<?php echo number_format($depositamount,2,'.',','); ?></td>

			</tr>

			    

			  

			  <?php }

				  

			  ?>

			  <?php

			$totaldepositrefundamount = 0;

			$query112 = "select * from deposit_refund where locationcode='$locationcode' and patientcode='$patientcode' and visitcode='$visitcode' order by recorddate";

			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_receipt1 = mysqli_num_rows($exec112);

			if($num_receipt1>0 && $temp !=1){

				$temp = 1;

				echo '<tr><td align="center" class="underline" colspan="6" valign="middle">RECEIPTS</td></tr>';	

			}

			while($res112 = mysqli_fetch_array($exec112))

			{

			$depositrefundamount = $res112['amount'];

			$depositrefundamount = 1*($depositrefundamount/$fxrate);

			$docno = $res112['docno'];

			$transactiondate = $res112['recorddate'];

			

			$colorloopcount = $colorloopcount + 1;

			$showcolor = ($colorloopcount & 1); 

			if ($showcolor == 0)

			{

				//echo "if";

				$colorcode = 'bgcolor="#CBDBFA"';

			}

			else

			{

				//echo "else";

				$colorcode = 'bgcolor="#ecf0f5"';

			}

			$totaldepositrefundamount = $totaldepositrefundamount + $depositrefundamount;

			?>

			  <tr>

				<td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td> 

				 <td class="bodytext31" valign="center"  align="left" width="85"><?php echo date('d-m-Y', strtotime($transactiondate)); ?></td>

				 <td class="bodytext31" valign="center"  align="left" width="85"><?php echo $docno; ?></td>

				 <td class="bodytext31" valign="center"  align="left"width="225"><?php echo 'Deposit Refund'; ?></td>

				 <td class="bodytext31" valign="center"  align="right" width="45"><?php echo '1'; ?></td>

				 <td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($depositrefundamount,2,'.',','); ?></td>

				 <td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($depositrefundamount,2,'.',','); ?></td>

			  </tr>

			  <?php 

			  }

			  ?>

			  

						<?php

			$totalnhifamount = 0;

			$query641 = "select * from ip_nhifprocessing where locationcode='$locationcode' and patientcode='$patientcode' and patientvisitcode='$visitcode' order by consultationdate";

			$exec641 = mysqli_query($GLOBALS["___mysqli_ston"], $query641) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_receipt2 = mysqli_num_rows($exec641);

			if($num_receipt2>0 && $temp !=1){

				$temp = 1;

				echo '<tr><td align="center" class="underline" colspan="6" valign="middle">RECEIPTS</td></tr>';	

			}

			while($res641= mysqli_fetch_array($exec641))

		   {

			$nhifdate = $res641['consultationdate'];

			$nhifrefno = $res641['docno'];

			$nhifqty = $res641['totaldays'];

			$nhifrate = $res641['nhifrebate'];

			$nhifclaim = $res641['nhifclaim'];

			$nhifclaim = -$nhifclaim;

			$nhifclaim = $nhifqty*($nhifrate/$fxrate);

			$totalnhifamount = $totalnhifamount + $nhifclaim;

			?>

			<tr>

				 <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td> 

				<td class="bodytext31" valign="center"  align="left" width="85"><?php echo  date('d-m-Y', strtotime($nhifdate)); ?></td>

				<td class="bodytext31" valign="center"  align="left" width="85"><?php echo $nhifrefno; ?></td>

				<td class="bodytext31" valign="center"  align="left"width="225"> <?php echo 'NHIF'; ?></td>

				<td class="bodytext31" valign="center"  align="right" width="45"><?php echo $nhifqty; ?></td>

				<td class="bodytext31" valign="center"  align="right" width="75">-<?php echo number_format($nhifrate,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right" width="75">-<?php echo number_format($nhifclaim,2,'.',','); ?></td>

			</tr>

				<?php

				}

				?>

			  <tr>

			<td colspan="6" align="left" class="bodytext31" valign="middle" style="">&nbsp;</td>

			</tr>

				<?php

			$totaldiscountamount = 0;

			$query64 = "select * from ip_discount where locationcode='$locationcode' and patientcode='$patientcode' and patientvisitcode='$visitcode' order by consultationdate";

			$exec64 = mysqli_query($GLOBALS["___mysqli_ston"], $query64) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_ipdiscount = mysqli_num_rows($exec64);

			if($num_ipdiscount>0){

				echo '<tr><td align="center" colspan="6" class="underline" valign="middle">CREDITS</td></tr>';

			}

			while($res64 = mysqli_fetch_array($exec64))

		   {

			$discountdate = $res64['consultationdate'];

			$discountrefno = $res64['docno'];

			$discount= $res64['description'];

			$discountrate = $res64['rate'];

			$discountrate = 1*($discountrate/$fxrate);

			$discountrate1 = $discountrate;

			$discountrate = -$discountrate;

			$authorizedby = $res64['authorizedby'];

			//$discountrate = 1*($discountrate/$fxrate);

			$totaldiscountamount = $totaldiscountamount + $discountrate;

			?>

			<tr>

				<td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td> 

				<td class="bodytext31" valign="center"  align="left" width="85"><?php echo  date('d-m-Y', strtotime($discountdate)); ?></td>

				<td class="bodytext31" valign="center"  align="left" width="75"><?php echo $discountrefno; ?></td>

				<td class="bodytext31" valign="center"  align="left"width="225">Discount On <?php echo $discount; ?> by <?php echo $authorizedby; ?></td>

			<!--	<input name="doctorname[]" type="hidden" id="doctorname" size="69" value="<?php echo $discount; ?>">

				<input name="doctorrate[]" type="hidden" id="doctorrate" readonly size="8" value="<?php echo $discountrate; ?>"> -->

				<td class="bodytext31" valign="center"  align="right" width="45"><?php echo '1'; ?></td>

				<td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($discountrate,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($discountrate,2,'.',','); ?></td>

			</tr>

				<?php

				}

				?>



				<?php

			$paid_amount = 0;

			$query64 = "select * from master_transactionip where locationcode='$locationcode' and patientcode='$patientcode' and visitcode='$visitcode' order by transactiondate";

			$exec64 = mysqli_query($GLOBALS["___mysqli_ston"], $query64) or die(mysqli_error($GLOBALS["___mysqli_ston"]));



			while($res64 = mysqli_fetch_array($exec64))

		   {

			$billdate = $res64['transactiondate'];

			$billnumber = $res64['billnumber'];

            $kj=0;



			if(($res64['cashamount']+$res64['onlineamount']+$res64['creditamount']+$res64['chequeamount']+$res64['cardamount']+$res64['mpesaamount'])>0){

				echo '<tr><td align="center" colspan="7" class="underline" valign="middle">PAYMENTS</td></tr>';

			}



			while($kj<=5){

				

 			if($kj==0){

				$mode="CASH";

				$amount = $res64['cashamount'];

			}else if($kj==1){

				$mode="ONLINE";

				$amount = $res64['onlineamount'];			

			}else if($kj==2){

				$mode="CREDIT";

				$amount = $res64['creditamount'];			

			}else if($kj==3){

				$mode="CHEQUE";

				$amount = $res64['chequeamount'];			

			}else if($kj==4){

				$mode="CARD";

				$amount = $res64['cardamount'];			

			}else if($kj==5){

				$mode="MPESA";

				$amount = $res64['mpesaamount'];			

			}

			if($amount>0){

				

			$authorizedby = $res64['username'];

			

			

			$paid_amount = $paid_amount + $amount;

			?>

			<tr>
                <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td> 
				<td class="bodytext31" valign="center"  align="left"><?php echo  date('d-m-Y', strtotime($billdate)); ?></td>

				<td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>

				<td class="bodytext31" valign="center"  align="left"> Payment By <?php echo $mode; ?> </td>

				<td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>

				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($amount,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right">-<?php echo number_format($amount,2,'.',','); ?></td>

			</tr>

				<?php

						}

										$kj++;



					}

				

				}

				?>



					

						

			  <?php 

			  include('convert_currency_to_words.php');

			  $depositamount = 0;

			  $overalltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totaldiscountamount+$totalmiscbillingamount+$totaldepositamount-$totalnhifamount+$totaldepositrefundamount)-$paid_amount;



			 if(number_format($overalltotal,2,'.','')=="-0"){ $overalltotal=0; } else{ $overalltotal=$overalltotal; }

			 if(number_format($overalltotal,2,'.','')==""){ $overalltotal=0; } else{ $overalltotal=$overalltotal; }



			  $convertedwords = @covert_currency_to_words(number_format($overalltotal,2,'.',''));

			  $overalltotal=number_format($overalltotal,2,'.','');

			  $consultationtotal=$totalop;

			   $consultationtotal=number_format($consultationtotal,2,'.','');

			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser;

			   $netpay=number_format($netpay,2,'.','');

			  ?>

            

          </tbody>

          </table>

          

          <table align="center" cellpadding="0" cellspacing="2" width="" border="">

			<tr>

			<td width="" class="bodytext31" align="right">&nbsp;</td>

            <td width="" class="bodytext31" align="right">&nbsp;</td>

            <td width="" class="bodytext31" align="right">&nbsp;</td>

		  </tr>

		<tr> 

            <td  width="550" class="bodytext31" align="left"><strong><?php echo $currency; ?></strong>

			<?php echo str_replace('Kenya Shillings','',$convertedwords); ?></td> 

			<td  width="75" class="bodytext31" align="right"><strong>Balance :</strong></td>

			<td  width="90" align="right" class="bodytext31"><strong><?php echo number_format($overalltotal,2,'.',','); ?></strong></td>

		</tr>

		

         <tr>

			<td width="" class="bodytext31" align="right">&nbsp;</td>

            <td width="" class="bodytext31" align="right">&nbsp;</td>

            <td width="" class="bodytext31" align="right">&nbsp;</td>

		  </tr>

         <tr>

			<td width="350" class="bodytext31" align="left">I Understand that my Liability to this bill is not waived.</td>

		 </tr>

		 <tr>

			<td width="" class="bodytext31" align="right">&nbsp;</td>

            <td width="" class="bodytext31" align="right">&nbsp;</td>

            <td width="" class="bodytext31" align="right">&nbsp;</td>

		  </tr>

		  <tr>

			<td width="" class="bodytext31" align="right">&nbsp;</td>

            <td width="" class="bodytext31" align="right">&nbsp;</td>

            <td width="" class="bodytext31" align="right">&nbsp;</td>

		  </tr>

       
<table width="" border=""  align="center" cellpadding="0" cellspacing="2">
<?php
 $res11billingdatetime=$billdate1;
$res11visitcode=$visitcode;
$res11locationcode=$locationcode;
$res11subtotalamount=$net_amount_summary;
$billautonumber =$billnumber;
$res11subtotalamount = str_replace(',', '', $res11subtotalamount);
  $source_from='ipfinal';
  include ("eTimsapi.php");
  ?>
</table>
		 

</table>

<table width="530" align="center" border="0" cellspacing="0" cellpadding="2">

<tbody>

<tr>

			<td class="bodytext31" align="left">Parent / Guardian Sign ---------------------------------------</td>

			<td class="bodytext31" align="right">Discharged By : <?php echo $employeename; ?></td>

  </tr>

  </tbody>

</table>

</page>


<?php

//$file_path = '\Users\user\Downloads\medbot-slade'; 
  // Checking whether file exists or not 
//if (!file_exists($file_path)) { 
      // Create a new file or direcotry 
  //  mkdir($file_path, 0777, true); 
//} 
//echo $file_path1 = '\Users\user\Downloads\medbot-slade\.'.$billautonumber.'; 
//$file_path1 = '\Users\user\Downloads\medbot-slade\\'.$billautonumber.'.pdf'; 
//$filename1=$billautonumber.'.pdf';

//$desktopPath = getenv("USERPROFILE") . "\\Desktop";
$folderName = "medbot_slade";
//$file_path = $desktopPath . "\\" . $folderName;
$file_path2 = $folderName.'/'.$billautonumber.'.pdf'; 
$filename1=$billautonumber.'.pdf';

if (!file_exists($file_path)) { 
      // Create a new file or direcotry 
    mkdir($file_path, 0777, true); 
} 
//$file_path1 = $file_path.'\\'.$billautonumber.'.pdf'; 
// $filename1=$billautonumber.'.pdf';
 ?> 

<?php

$content = ob_get_clean();
require_once('html2pdf/html2pdf.class.php');

try

{

	$html2pdf = new HTML2PDF('P','A4','fr');

	$html2pdf->WriteHTML($content);
	$pdfdoc = $html2pdf->Output('', 'S');
	file_put_contents($file_path2, $pdfdoc);
	post_invoice($claim,$filename1,$file_path2,$customername,$auth,$invoice_url,$res2visitcode,$billautonumber,$patientcode,$locationcode);
}

catch(HTML2PDF_exception $e) {

	echo $e;

	exit;

}



?>






