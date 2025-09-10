<?php
include_once("db/db_connect.php");
include_once('slade.php');
$authorization="Authorization: Bearer $slade_token";
$billno ="";
$visitcode ="";
$invoice_arry=array();
if(isset($_REQUEST['billno'])) { $billno = $_REQUEST['billno']; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST['visitcode']; }
if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST['patientcode']; }
if(isset($_REQUEST['split_status'])) { $split_status = $_REQUEST['split_status']; }
$inv_rslt=array();
$inv_line=array();
$main_array=array();
if($split_status=='yes')
{
 $query7 = "select * from billing_ipcreditapproved where visitcode = '$visitcode' and billno='$billno'";
}
else
{
 $query7 = "select * from billing_ip where visitcode = '$visitcode' and billno='$billno' and slade_status!='completed'";	
}
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
$num232 = mysqli_num_rows($exec7);
$sno=1;
$j=0;

if($num232>0){

	$res7 = mysqli_fetch_array($exec7);

	 $query17 = "select * from master_ipvisitentry where visitcode='$visitcode'";
	$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res17 = mysqli_fetch_array($exec17);

	$consultationamount=$res17['admissionfees'];
	$plannumber = $res17['planname'];
	$res17planpercentage=$res17['planpercentage'];
	$patientcode=$res17['patientcode'];
	$subtype=$res17['subtype'];
	
	
	/*echo  $query7412 = "select id from master_accountname where subtype='$subtype'";
	$exec7412 = mysqli_query($GLOBALS["___mysqli_ston"], $query7412) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	$res7412 = mysqli_fetch_array($exec7412);
	$main_ledger = $res7412['id'];
	
	exit;*/

    $copayconsult ='';
	$copayconsult_per ='';

	$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";
	$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]));
	$resplanname = mysqli_fetch_array($execplanname);
	$planforall = $resplanname['forall'];

    if($planforall=='yes'){
		$copayconsult_per = ($consultationamount/100)*$res17planpercentage;
	}
	
	$invoice_arry["claim"]=$res7['slade_claim_id'];
	$invoice_arry["invoice_number"]=$billno;
	$invoice_arry["invoice_date"]=date("c",strtotime($res7['billdate']));
	$ambreferalrate='0.00';
	$query18 = "select sum(rate) as rate from ip_discount where patientvisitcode = '$visitcode'";	
	$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res18 = mysqli_fetch_array($exec18);
	$ambreferalrate = 1*$res18['rate'];
	$invoice_arry["discount_amount"]=$ambreferalrate;

	$nhifclaim=0;
	$query24 = "select sum(nhifclaim) as nhifclaim from ip_nhifprocessing where patientvisitcode = '$visitcode'";
	$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res24 = mysqli_fetch_array($exec24))
	{
      $nhifclaim=$res24["nhifclaim"];
	}


    if($nhifclaim>0)
	{
      $copay_arr["copay_type"]="NHIF";
	  $copay_arr["copay_amount"]=$nhifclaim;
	  $invoice_arry["copays"]=$copay_arr;
	}

	/////////////////////// start ADMISSION  /////////////////////////////////////
   
	if($consultationamount >0 ){
	   $inv_line["item_code"]=$visitcode;
	   $inv_line["item_name"]='ADMISSION FEE';
	   $inv_line["charge_date"]=date("c",strtotime($res7['billdate']));
	   $inv_line["unit_price"]=$consultationamount;
	   $inv_line["quantity"]=1;
    array_push($main_array,$inv_line);
		if($planforall=='yes'){
              //$inv_line[$j]["line_copay"]=number_format($copayconsult_per,2,'.','');
			  $inv_line[$j]["line_copay"]='';
		   }
	    $inv_line[$j]["line_number"]=$sno;	
		$sno++;
		$j++;
	}
    /////////////////////// end ADMISSION  /////////////////////////////////////

	////////////////////// start package  /////////////////////////////////////
	$packageanum1 = $res17['package'];
    $packageamount = $res17['packagecharge'];
   
	if($packageanum1 > 0)
    {
		    $query741 = "select * from master_ippackage where auto_number='$packageanum1'";
			$exec741 = mysqli_query($GLOBALS["___mysqli_ston"], $query741) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res741 = mysqli_fetch_array($exec741);
			$packdays1 = $res741['days'];
			$packagename = $res741['packagename'];
			$packagecode = $res741['servicescode'];
			$packagecode = substr($packagecode,0,9);

		   $inv_line["item_code"]=$packagecode;
		   $inv_line["item_name"]=$packagename;
		   $inv_line["charge_date"]=date("c",strtotime($res7['billdate']));
		   $inv_line["unit_price"]=$packageamount;
		   $inv_line["quantity"]=1;
		   $inv_line["line_number"]=$sno;	
		   array_push($main_array,$inv_line);
		   $sno++;
		   $j++;
	}

    /////////////////////// end package  /////////////////////////////////////
	
	
	 /////////////////////// start split  /////////////////////////////////////
	$nhif_array=array('411','412','413','414','415','416','417','418','419');
	$copay_type='OTHER';
	$total_copay=0;
	 $query919 = "select accountnameid,accountnameano,fxamount from billing_ipcreditapprovedtransaction where  visitcode = '$visitcode' and patientcode='$patientcode' and keyprovider!='yes'";
	$exec919 = mysqli_query($GLOBALS["___mysqli_ston"], $query919) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$num919 = mysqli_num_rows($exec919);
	if($num919>0){
		while($res919 = mysqli_fetch_array($exec919))
		{
            $accountnameid = $res919['accountnameid'];
			$accountnameano = $res919['accountnameano'];
			$fxamount = $res919['fxamount'];
					
			if (in_array($accountnameano, $nhif_array)) 
			{
			$copay_type='NHIF';
			$total_copay=$total_copay+$fxamount;
			}
			
			if($total_copay<=0)
			{
			$total_copay=$total_copay+$fxamount;
			}
			
			if($fxamount>0)
			{
			$copay_arr[0]["copay_type"]=$copay_type;
			$copay_arr[0]["copay_amount"]=$total_copay;
			$invoice_arry["copays"]=$copay_arr;
			}	
			
		   $sno++;
		   $j++;
		}
	}

	/////////////////////// end split /////////////////////////////////////
	
	
	

    /////////////////////// start bed  /////////////////////////////////////
	
	$query91 = "select description,rate, quantity, recorddate, bed from billing_ipbedcharges where ward <> '0' and bed <> '0' and docno = '$billno' and visitcode = '$visitcode'";
	$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$num91 = mysqli_num_rows($exec91);
		
	if($num91>0){
	
		while($res91 = mysqli_fetch_array($exec91))
		{
            $charge = $res91['description'];
			$rate = $res91['rate'];	
			$quantity = $res91['quantity'];
			$date = $res91['recorddate'];
			$bed = $res91['bed'];
			$query = mysqli_query($GLOBALS["___mysqli_ston"], "select bed from master_bed where auto_number = '$bed'") or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
	        $res = mysqli_fetch_array($query);
	        $bedname = $res['bed'];

		   $inv_line["item_code"]='BED-'.$bed;
		   $inv_line["item_name"]=$charge."(".$bedname.")";
		   $inv_line["charge_date"]=date("c",strtotime($date));
		   $inv_line["unit_price"]=number_format($rate,2,'.','');
		   $inv_line["quantity"]=$quantity;
		   $inv_line["line_number"]=$sno;
		   array_push($main_array,$inv_line);
		   $sno++;
		   $j++;
		}
	}

	/////////////////////// end bed /////////////////////////////////////

	/////////////////////// start pharma  /////////////////////////////////////

	$querya12 = "select * from billing_ippharmacy where patientvisitcode = '$visitcode' and medicinename <> 'DISPENSING' and pkg_status!='YES'";	
	$execa12 = mysqli_query($GLOBALS["___mysqli_ston"], $querya12) or die ("Error in Querya12".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($execa12)>0)
	{
		
		$query12 = "select * from billing_ippharmacy where patientvisitcode = '$visitcode' and pkg_status!='YES'";	
		$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res12 = mysqli_fetch_array($exec12))
		{

			$medicinecode = $res12['medicinecode'];	
			$medicinecode_full = $res12['medicinecode'];	
			$medicinecode = substr($medicinecode,0,9);
			$medicinename = $res12['medicinename'];
			$medquantity = $res12['quantity'];	
			$medrate = $res12['rate'];	

		    $inv_line["item_code"]=$medicinecode;
		    $inv_line["item_name"]=$medicinename;
		    $inv_line["charge_date"]=date("c",strtotime($res7['billdate']));
		    $inv_line["unit_price"]=$medrate;
		    $inv_line["quantity"]=$medquantity;
		   
		    $inv_line["line_number"]=$sno;
		    array_push($main_array,$inv_line);	
		   $sno++;
		   $j++;
		}


	}

	/////////////////////// end pharma  /////////////////////////////////////

	/////////////////////// start lab  /////////////////////////////////////

	$query13 = "select * from billing_iplab where patientvisitcode = '$visitcode' and pkg_status!='YES'";	
	$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res13 = mysqli_fetch_array($exec13))
	{
		$labcode = $res13['labitemcode'];
		$labcode_full = $res13['labitemcode'];
		$labcode = substr($labcode,0,9);	
		$labname = $res13['labitemname'];
		$labquantity = '1';	
		$labrate = $res13['labitemrate'];	

	   $inv_line["item_code"]=$labcode;
	   $inv_line["item_name"]=$labname;
	   $inv_line["charge_date"]=date("c",strtotime($res7['billdate']));
	   $inv_line["unit_price"]=$labrate;
	   $inv_line["quantity"]=$labquantity;
	   
	   $inv_line["line_number"]=$sno;	
	   array_push($main_array,$inv_line);
	   $sno++;
	   $j++;


	}

	/////////////////////// end lab  /////////////////////////////////////

	/////////////////////// start radiology  /////////////////////////////////////
	
	$query14 = "select * from billing_ipradiology where patientvisitcode = '$visitcode' and pkg_status!='YES'";	
	$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res14 = mysqli_fetch_array($exec14))
	{
		$radiologycode = $res14['radiologyitemcode'];	
		$radiologycode_full = $res14['radiologyitemcode'];	
		$radiologycode = substr($radiologycode,0,9);
		$radiologyname = $res14['radiologyitemname'];
		$radiologyquantity = '1';	
		$radiologyrate = $res14['radiologyitemrate'];	

	   $inv_line["item_code"]=$radiologycode;
	   $inv_line["item_name"]=$radiologyname;
	   $inv_line["charge_date"]=date("c",strtotime($res7['billdate']));
	   $inv_line["unit_price"]=$radiologyrate;
	   $inv_line["quantity"]=$radiologyquantity;
	   
	   $inv_line["line_number"]=$sno;	
	   array_push($main_array,$inv_line);
	   $sno++;
	   $j++;
	}

	
   /////////////////////// end radiology  /////////////////////////////////////
   /////////////////////// start services  /////////////////////////////////////
	
    $query15 = "select * from billing_ipservices where patientvisitcode = '$visitcode' and wellnessitem <> '1' and pkg_status!='YES'";	
	$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res15 = mysqli_fetch_array($exec15))
	{
		$servicescode = $res15['servicesitemcode'];	
		$servicescode_full = $res15['servicesitemcode'];	
		$servicescode = substr($servicescode,0,9);
		$servicesname = $res15['servicesitemname'];
		$servicesquantity = 1;
		$servicesquantity = number_format($servicesquantity,0,'.','');	
		$serviceitemrate = $res15['servicesitemrate'];
		

	   $inv_line["item_code"]=$servicescode;
	   $inv_line["item_name"]=$servicesname;
	   $inv_line["charge_date"]=date("c",strtotime($res7['billdate']));
	   $inv_line["unit_price"]=$serviceitemrate;
	   $inv_line["quantity"]=$servicesquantity;
	  	   
	   $inv_line["line_number"]=$sno;	
	    array_push($main_array,$inv_line);
	   $sno++;
	   $j++;

	}

   /////////////////////// end services  /////////////////////////////////////

   /////////////////////// start ot  /////////////////////////////////////
  
    $query16 = "select * from ip_otbilling where patientvisitcode = '$visitcode'";	
	$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res16 = mysqli_fetch_array($exec16))
	{
		$referalcode = $res16['docno'];	
		$referalcode = substr($referalcode,0,9);
		$referalname = $res16['surgeryname'];
		$referalquantity = '1';	
		$referalamount = $res16['rate'];

		$inv_line["item_code"]=$referalcode;
	   $inv_line["item_name"]=$referalname;
	   $inv_line["charge_date"]=date("c",strtotime($res7['billdate']));
	   $inv_line["unit_price"]=$referalamount;
	   $inv_line["quantity"]=$referalquantity;
	  
	   $inv_line["line_number"]=$sno;	
	    array_push($main_array,$inv_line);
	   $sno++;
	}

   /////////////////////// end ot  /////////////////////////////////////
   /////////////////////// start private Doctor  /////////////////////////////////////
    
   $query17 = "select * from ipprivate_doctor where patientvisitcode = '$visitcode'";	
	$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query17".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res17 = mysqli_fetch_array($exec17))
	{
		$homedocno = $res17['docno'];
		$homedocno = substr($homedocno,0,9);	
		$homename = $res17['doctorname'];
		$homequantity = $res17['units'];	
		$homereferalrate = $res17['rate'];	
		
		$inv_line["item_code"]=$homedocno;
	   $inv_line["item_name"]=$homename;
	   $inv_line["charge_date"]=date("c",strtotime($res7['billdate']));
	   $inv_line["unit_price"]=$homereferalrate;
	   $inv_line["quantity"]=$homequantity;
	   
	   $inv_line["line_number"]=$sno;
	    array_push($main_array,$inv_line);	
	   $sno++;
	   $j++;
	}

   /////////////////////// end private Doctor  /////////////////////////////////////

   /////////////////////// start ambulance  /////////////////////////////////////
   
   $query18 = "select * from ip_ambulance where patientvisitcode = '$visitcode'";	
	$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res18 = mysqli_fetch_array($exec18))
	{
		$ambdocno = $res18['docno'];
		$ambdocno = substr($ambdocno,0,9);	
		$ambname = $res18['description'];
		$ambquantity = $res18['quantity'];	
		$ambamount = $res18['amount'];	
		$ambreferalrate = $res18['rate'];

		$inv_line["item_code"]=$ambdocno;
	   $inv_line["item_name"]=$ambname;
	   $inv_line["charge_date"]=date("c",strtotime($res7['billdate']));
	   $inv_line["unit_price"]=$ambreferalrate;
	   $inv_line["quantity"]=$ambquantity;
	   
	   $inv_line["line_number"]=$sno;	
	   array_push($main_array,$inv_line);
	   $sno++;
	   $j++;
	}

   /////////////////////// end ambulance  /////////////////////////////////////

    /////////////////////// start homecare  /////////////////////////////////////
	
   $query18 = "select * from iphomecare where patientvisitcode = '$visitcode'";	
	$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res18 = mysqli_fetch_array($exec18))
	{
		$ambdocno = $res18['docno'];
		$ambdocno = substr($ambdocno,0,9);	
		$ambname = $res18['description'];
		$ambquantity = $res18['units'];	
		$ambamount = $res18['amount'];	
		$ambreferalrate = $res18['rate'];

		$inv_line["item_code"]=$ambdocno;
	   $inv_line["item_name"]=$ambname;
	   $inv_line["charge_date"]=date("c",strtotime($res7['billdate']));
	   $inv_line["unit_price"]=$ambreferalrate;
	   $inv_line["quantity"]=$ambquantity;
	   
	   $inv_line["line_number"]=$sno;	
	    array_push($main_array,$inv_line);
	   $sno++;
	   $j++;
	}

   /////////////////////// end homecare  /////////////////////////////////////

    /////////////////////// start misc  /////////////////////////////////////
	
   $query18 = "select * from ipmisc_billing where patientvisitcode = '$visitcode'";	
	$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res18 = mysqli_fetch_array($exec18))
	{
		$ambdocno = $res18['docno'];
		$ambdocno = substr($ambdocno,0,9);	
		$ambname = $res18['description'];
		$ambquantity = $res18['units'];	
		$ambamount = $res18['amount'];	
		$ambreferalrate = $res18['rate'];

		$inv_line["item_code"]=$ambdocno;
	   $inv_line["item_name"]=$ambname;
	   $inv_line["charge_date"]=date("c",strtotime($res7['billdate']));
	   $inv_line["unit_price"]=$ambreferalrate;
	   $inv_line["quantity"]=$ambquantity;
	   
	   $inv_line["line_number"]=$sno;	
	   array_push($main_array,$inv_line);
	   $sno++;
	   $j++;
	}

   /////////////////////// end misc  /////////////////////////////////////

   /////////////////////// start deposit  /////////////////////////////////////
  
   $deposits=0;
   $query18 = "select * from master_transactionipdeposit where visitcode = '$visitcode'";	
	$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res18 = mysqli_fetch_array($exec18))
	{
		$ambdocno = $res18['docno'];
		$ambdocno = substr($ambdocno,0,9);	
		$ambname = 'IP Deposit';
		$ambquantity = 1;	
		$ambreferalrate = $res18['transactionamount'];
		$deposits=$deposits+$ambreferalrate;

	/*	$inv_line[$j]["item_code"]=$ambdocno;
	   $inv_line[$j]["item_name"]=$ambname;
	   $inv_line[$j]["charge_date"]=date("c",strtotime($res7['billdate']));
	   $inv_line[$j]["unit_price"]=-1*$ambreferalrate;
	   $inv_line[$j]["quantity"]=$ambquantity;
	   
	   $inv_line[$j]["line_number"]=$sno;	
	   $sno++;
	   $j++;*/
	}

	 

   /////////////////////// end deposit  /////////////////////////////////////

   /////////////////////// start adv deposit  /////////////////////////////////////
    $query18 = "select * from master_transactionadvancedeposit where visitcode = '$visitcode' and recordstatus='adjusted'";	
	$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res18 = mysqli_fetch_array($exec18))
	{
		$ambdocno = $res18['docno'];
		$ambdocno = substr($ambdocno,0,9);	
		$ambname = 'Advance Deposit';
		$ambquantity = 1;	
		$ambreferalrate = $res18['transactionamount'];
		$deposits=$deposits+$ambreferalrate;
        /*
		$inv_line[$j]["item_code"]=$ambdocno;
	   $inv_line[$j]["item_name"]=$ambname;
	   $inv_line[$j]["charge_date"]=date("c",strtotime($res7['billdate']));
	   $inv_line[$j]["unit_price"]=-1*$ambreferalrate;
	   $inv_line[$j]["quantity"]=$ambquantity;
	   
	   $inv_line[$j]["line_number"]=$sno;	
	   $sno++;
	   $j++;
	   */
	}

    if($deposits>0){
	  $copay_arr[1]["copay_type"]="SELF_PAY";
	  $copay_arr[1]["copay_amount"]=$deposits;
	  $invoice_arry["copays"]=$copay_arr;
	}

   /////////////////////// end adv deposit  /////////////////////////////////////

   /////////////////////// start deposit refund /////////////////////////////////////
  
   $query18 = "select * from deposit_refund where visitcode = '$visitcode'";	
	$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res18 = mysqli_fetch_array($exec18))
	{
		$ambdocno = $res18['docno'];
		$ambdocno = substr($ambdocno,0,9);	
		$ambname = 'Deposit Refund';
		$ambquantity = 1;	
		$ambreferalrate = $res18['amount'];

		$inv_line["item_code"]=$ambdocno;
	   $inv_line["item_name"]=$ambname;
	   $inv_line["charge_date"]=date("c",strtotime($res7['billdate']));
	   $inv_line["unit_price"]=$ambreferalrate;
	   $inv_line["quantity"]=$ambquantity;
	   
	   $inv_line["line_number"]=$sno;	
	     array_push($main_array,$inv_line);
	   $sno++;
	   $j++;
	}

   /////////////////////// end deposit refund /////////////////////////////////////

   /////////////////////// start discount /////////////////////////////////////
 /* 
   $query18 = "select * from ip_discount where patientvisitcode = '$visitcode'";	
	$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res18 = mysqli_fetch_array($exec18))
	{
		$ambdocno = $res18['docno'];
		$ambdocno = substr($ambdocno,0,9);	
		$ambname = $res18['description']." Discount";
		$ambquantity = 1;	
		$ambreferalrate = 1*$res18['rate'];

		$inv_line["item_code"]=$ambdocno;
	   $inv_line["item_name"]=$ambname;
	   $inv_line["charge_date"]=date("c",strtotime($res7['billdate']));
	   $inv_line["unit_price"]=$ambreferalrate;
	   $inv_line["quantity"]=$ambquantity;
	   
	   $inv_line["line_number"]=$sno;	
	   array_push($main_array,$inv_line);
	   $sno++;
	   $j++;
	}
*/

   /////////////////////// end deposit refund /////////////////////////////////////
   
 //  $json_data = json_encode($main_array, JSON_PRETTY_PRINT);

// Output the JSON data
/*echo $json_data;
exit;*/
   // json_encode($main_array);
	$invoice_arry["lines"]=$main_array;
	$inv_send=json_encode($invoice_arry);
		//echo $authorization;
		//echo $claim_url;
	//print_r($inv_send);
	//exit;
	
	$query8 = "update billing_ip set smartxml='".addslashes($inv_send)."' where visitcode = '$visitcode' ";
    $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8);

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json' , $authorization ));
	curl_setopt($curl, CURLOPT_POSTFIELDS,$inv_send);
	curl_setopt($curl, CURLOPT_URL, $claim_url.'/v1/invoices/?format=json');
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
	   $inv_rslt['status'] = 'Faild';
	   $inv_rslt['msg'] = $err_unable_connect;
	}else{
		$obj=json_decode($result,true);
		if(isset($obj['id'])){
			$id=$obj['id'];
            //$query8 = "update billing_ip set slade_status='completed' where visitcode = '$visitcode' ";
            //$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8);
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

//echo json_encode($inv_rslt);
?>