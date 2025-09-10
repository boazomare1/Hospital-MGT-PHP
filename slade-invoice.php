<?php
include_once("db/db_connect.php");
include_once('slade.php');
$authorization="Authorization: Bearer $slade_token";

$billno ="";
$visitcode ="";
$disc_consultationfxamount1='0.00';
$pharm_disc='0.00';
$lab_disc='0.00';
$rad_disc ='0.00';
$serv_desc ='0.00';
$invoice_arry=array();
if(isset($_REQUEST['billno'])) { $billno = $_REQUEST['billno']; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST['visitcode']; }
$inv_rslt=array();
$inv_line=array();
  //$query7 = "select * from billing_paylater where visitcode = '$visitcode' and billno='$billno' and slade_status!='completed'";
   $query7 = "select * from billing_paylater where visitcode = '$visitcode' ";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
$num232 = mysqli_num_rows($exec7);
$sno=1;
$j=0;
if($num232>0){

	$res7 = mysqli_fetch_array($exec7);

	 $query17 = "select * from master_visitentry where visitcode='$visitcode'";
	$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res17 = mysqli_fetch_array($exec17);
	$consultationamount=$res17['consultationfees'];
	$plannumber = $res17['planname'];
	$res17planpercentage=$res17['planpercentage'];
	$patientcode=$res17['patientcode'];

    $copayconsult ='';
	$copayconsult_per ='';

	$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";
	$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]));
	$resplanname = mysqli_fetch_array($execplanname);
	$planforall = $resplanname['forall'];


    if($planforall=='yes'){
$querybill = "select totalamount from billing_paynow where visitcode='$visitcode'";
$execbill = mysqli_query($GLOBALS["___mysqli_ston"], $querybill) or die ("Error in Querybill".mysqli_error($GLOBALS["___mysqli_ston"]));
$resbill = mysqli_fetch_array($execbill);
$bill_amount = $resbill['totalamount'];

		$copayconsult_per = ($consultationamount/100)*$res17planpercentage;
		$copayconsult_per=$copayconsult_per+$bill_amount;
	}else{
    
	    $query18 = "select copayfixedamount from master_billing where visitcode='$visitcode' and  copayfixedamount>0";
		$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		if($res18 = mysqli_fetch_array($exec18))
		{
			$copayconsult = number_format($res18['copayfixedamount'],2,'.','');

		}
	}
	if($copayconsult_per>0)
	{
		$copayconsult=$copayconsult_per;
	}
	$invoice_arry["claim"]=$res7['slade_claim_id'];
	$invoice_arry["invoice_number"]=$billno;
	$invoice_arry["invoice_date"]=date("c",strtotime($res7['billdate']));
	
	
	/*$query18 = "select consultationfxamount from billing_patientweivers where visitcode='$visitcode' and patientcode='$patientcode' and consultationfxamount>0";
		$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res18 = mysqli_fetch_array($exec18))
		{
		 $disc_consultationfxamount = $res18['consultationfxamount'];
		 $disc_consultationfxamount1=$disc_consultationfxamount1+$disc_consultationfxamount;
		}*/
		
		$query18 = "select sum(consult_discamount) as consult_discamount,sum(pharmacy_discamount) as pharmacy_discamount, sum(lab_discamount) as lab_discamount,sum(radiology_discamount) as radiology_discamount,sum(services_discamount) as services_discamount from patientweivers where visitcode='$visitcode' and patientcode='$patientcode' ";
		$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res18 = mysqli_fetch_array($exec18);
		
		 $disc_consultationfxamount = $res18['consult_discamount'];
		 $pharm_disc = $res18['pharmacy_discamount'];
		 $lab_disc = $res18['lab_discamount'];
		 $rad_disc = $res18['radiology_discamount'];
		 $serv_desc = $res18['services_discamount'];
		 $disc_consultationfxamount1=$disc_consultationfxamount1+$disc_consultationfxamount+$pharm_disc+$lab_disc+$rad_disc+$serv_desc;
	
     $invoice_arry["discount_amount"]=number_format($disc_consultationfxamount1,2,'.','');
    if($copayconsult>0){
      $copay_arr[0]["copay_type"]="SELF_PAY";
	  $copay_arr[0]["copay_amount"]=$copayconsult;
	  $invoice_arry["copays"]=$copay_arr;
	}

	/////////////////////// start consutation  /////////////////////////////////////

	if($consultationamount >0 ){
	   $inv_line[$j]["item_code"]=$visitcode;
	   $inv_line[$j]["item_name"]='CONSULTATION FEE';
	   $inv_line[$j]["charge_date"]=date("c",strtotime($res7['billdate']));
	   $inv_line[$j]["unit_price"]=$consultationamount;
	   $inv_line[$j]["quantity"]=1;

		/*$query18 = "select consultationfxamount from billing_patientweivers where visitcode='$visitcode' and patientcode='$patientcode' and consultationfxamount>0";
		$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res18 = mysqli_fetch_array($exec18))
		{
		  $inv_line[$j]["discount"] = number_format($res18['consultationfxamount'],2,'.','');
		 
		}*/
		 $inv_line[$j]["discount"] = '';
		if($planforall=='yes'){
              //$inv_line[$j]["line_copay"]=number_format($copayconsult_per,2,'.','');
			  $inv_line[$j]["line_copay"]='';
		   }
	    $inv_line[$j]["line_number"]=$sno;	
		$sno++;
		$j++;
	}

    /////////////////////// end consultation  /////////////////////////////////////
    /////////////////////// start pharma  /////////////////////////////////////
	 $querya12 = "select * from billing_paylaterpharmacy where patientvisitcode = '$visitcode' and medicinename <> 'DISPENSING'";	
	$execa12 = mysqli_query($GLOBALS["___mysqli_ston"], $querya12) or die ("Error in Querya12".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($execa12)>0)
	{
		
		 $query12 = "select * from billing_paylaterpharmacy where patientvisitcode = '$visitcode' and medicinename <> 'DISPENSING'";	
		$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res12 = mysqli_fetch_array($exec12))
		{
			$medicinecode = $res12['medicinecode'];	
			$medicinecode_full = $res12['medicinecode'];	
			$medicinecode = substr($medicinecode,0,9);
			$medicinename = $res12['medicinename'];
			$medquantity = $res12['quantity'];	
			$res199rate = $medrate = $res12['rate'];	
			$medamount = $res12['amount'];	

			$copaypharm =0;
			$query199 = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode' and medicinecode = '$medicinecode_full' order by auto_number desc";
			$exec199 = mysqli_query($GLOBALS["___mysqli_ston"], $query199) or die ("Error in Query199".mysqli_error($GLOBALS["___mysqli_ston"]));
			$pharmnumber=mysqli_num_rows($exec199);
			if($pharmnumber >0)
			{
				$res199 = mysqli_fetch_array($exec199);
				$res199rate = $res199['rate'];
				$res199referalno=$res199['refno'];
				$res199amount = $res199['amount'];
				$medamount = ($res199rate*$medquantity);	
				$copaypharm = (($res199rate)/100)*$res17planpercentage;
				$copaypharm='';
			}
			
		   $inv_line[$j]["item_code"]=$medicinecode;
		   $inv_line[$j]["item_name"]=$medicinename;
		   $inv_line[$j]["charge_date"]=date("c",strtotime($res7['billdate']));
		   $inv_line[$j]["unit_price"]=$res199rate;
		   $inv_line[$j]["quantity"]=$medquantity;

		   if($planforall=='yes'){
              $inv_line[$j]["line_copay"]=number_format($copaypharm,2,'.','');
		   }
		    
			$inv_line[$j]["line_number"]=$sno;	
			$sno++;
			$j++;
		}
	}

	$query18 = "select pharmacyfxamount from billing_patientweivers where visitcode='$visitcode' and patientcode='$patientcode' and pharmacyfxamount>0";
	$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res18 = mysqli_fetch_array($exec18))
	{
	   $inv_line[$j]["item_code"]='Discount'.$sno;
	   $inv_line[$j]["item_name"]="Paharmacy Discount";
	   $inv_line[$j]["charge_date"]=date("c",strtotime($res7['billdate']));
	   $inv_line[$j]["unit_price"]=0-number_format($res18['pharmacyfxamount'],2,'.','');
	   $inv_line[$j]["quantity"]=1;
	   $inv_line[$j]["line_number"]=$sno;
	   $sno++;
	   $j++;
	}

	/////////////////////// end pharma /////////////////////////////////////
	/////////////////////// start lab  /////////////////////////////////////

	$query13 = "select * from billing_paylaterlab where patientvisitcode = '$visitcode'";	
	$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res13 = mysqli_fetch_array($exec13))
	{
		$labcode = $res13['labitemcode'];
		$labcode_full = $res13['labitemcode'];
		$labcode = substr($labcode,0,9);	
		$labname = $res13['labitemname'];
		$labquantity = '1';	
		$labrate = $res13['labitemrate'];	

		 $query200 = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemcode = '$labcode_full'";
		$exec200 = mysqli_query($GLOBALS["___mysqli_ston"], $query200) or die ("Error in Query200".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res200 = mysqli_fetch_array($exec200);
		$res200referalno=$res200['refno'];
		$labrate = $res200['labitemrate'];
		$cashcopay = $res200['cash_copay'];

		$labrate = $labrate/$labquantity;
		$copaylab = ($labrate/100)*$res17planpercentage;
 
	   $inv_line[$j]["item_code"]=$labcode;
	   $inv_line[$j]["item_name"]=$labname;
	   $inv_line[$j]["charge_date"]=date("c",strtotime($res7['billdate']));
	   $inv_line[$j]["unit_price"]=$labrate;
	   $inv_line[$j]["quantity"]=$labquantity;
	   if($cashcopay>0 || $planforall=='yes'){
         //$inv_line[$j]["line_copay"]=$cashcopay+number_format($copaylab,2,'.','');
		 $inv_line[$j]["line_copay"]='';
	   }
	  
	   $inv_line[$j]["line_number"]=$sno;	
	   $sno++;
	   $j++;


	}

	$query18 = "select labfxamount from billing_patientweivers where visitcode='$visitcode' and patientcode='$patientcode' and labfxamount>0";
	$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res18 = mysqli_fetch_array($exec18))
	{
	   $inv_line[$j]["item_code"]='Discount'.$sno;
	   $inv_line[$j]["item_name"]="Lab Discount";
	   $inv_line[$j]["charge_date"]=date("c",strtotime($res7['billdate']));
	   $inv_line[$j]["unit_price"]=0-number_format($res18['labfxamount'],2,'.','');
	   $inv_line[$j]["quantity"]=1;
	   $inv_line[$j]["line_number"]=$sno;
	   $sno++;
	   $j++;
	}

	/////////////////////// end lab  /////////////////////////////////////
	/////////////////////// start radiology  /////////////////////////////////////
	$query14 = "select * from billing_paylaterradiology where patientvisitcode = '$visitcode'";	
	$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res14 = mysqli_fetch_array($exec14))
	{
		$radiologycode = $res14['radiologyitemcode'];	
		$radiologycode_full = $res14['radiologyitemcode'];	
		$radiologycode = substr($radiologycode,0,9);
		$radiologyname = $res14['radiologyitemname'];
		$radiologyquantity = '1';	
		$radiologyrate = $res14['radiologyitemrate'];	


		$query211 = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode'  and radiologyitemcode = '$radiologycode_full'";
		$exec211 = mysqli_query($GLOBALS["___mysqli_ston"], $query211) or die ("Error in Query211".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res211 = mysqli_fetch_array($exec211);
		$res211referal=$res211['refno'];
		$radiologyrate = $res211['radiologyitemrate'];
		$cashcopay = $res211['cash_copay'];
		$radiologyrate = $radiologyrate/$radiologyquantity;
		$copayrad = ($radiologyrate/100)*$res17planpercentage;

	   $inv_line[$j]["item_code"]=$radiologycode;
	   $inv_line[$j]["item_name"]=$radiologyname;
	   $inv_line[$j]["charge_date"]=date("c",strtotime($res7['billdate']));
	   $inv_line[$j]["unit_price"]=$radiologyrate;
	   $inv_line[$j]["quantity"]=$radiologyquantity;
	   if($cashcopay>0 || $planforall=='yes'){
		 //$inv_line[$j]["line_copay"]=$cashcopay+number_format($copayrad,2,'.','');
		 $inv_line[$j]["line_copay"]='';
	   }
	   
	   $inv_line[$j]["line_number"]=$sno;	
	   $sno++;
	   $j++;
	}

	$query18 = "select radiologyfxamount from billing_patientweivers where visitcode='$visitcode' and patientcode='$patientcode' and radiologyfxamount>0";
	$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res18 = mysqli_fetch_array($exec18))
	{
	   $inv_line[$j]["item_code"]='Discount'.$sno;
	   $inv_line[$j]["item_name"]="Radiology Discount";
	   $inv_line[$j]["charge_date"]=date("c",strtotime($res7['billdate']));
	   $inv_line[$j]["unit_price"]=0-number_format($res18['radiologyfxamount'],2,'.','');
	   $inv_line[$j]["quantity"]=1;
	   $inv_line[$j]["line_number"]=$sno;
	   $sno++;
	   $j++;
	}

   /////////////////////// end radiology  /////////////////////////////////////
   /////////////////////// start services  /////////////////////////////////////

    $query15 = "select * from billing_paylaterservices where patientvisitcode = '$visitcode'";	
	$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res15 = mysqli_fetch_array($exec15))
	{
		$servicescode = $res15['servicesitemcode'];	
		$servicescode_full = $res15['servicesitemcode'];	
		$servicescode = substr($servicescode,0,9);
		$servicesname = $res15['servicesitemname'];
		$servicesquantity = $res15['serviceqty'];
		$servicesquantity = number_format($servicesquantity,0,'.','');	
		$servicesamount = $res15['amount'];	
		$serviceitemrate = $res15['servicesitemrate'];
		$cashcopay =0;

		 $query233 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$servicescode_full'";
		$exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res233 = mysqli_fetch_array($exec233);
		$numrow233 = mysqli_num_rows($exec233);
		if($numrow233>0){
		$serviceitemrate = $res233['servicesitemrate'];
		$servicesamount=$serviceitemrate*$servicesquantity;
		$cashcopay =$res233['cash_copay'];
		}
		$copayser = ($serviceitemrate/100)*$res17planpercentage;

	   $inv_line[$j]["item_code"]=$servicescode;
	   $inv_line[$j]["item_name"]=$servicesname;
	   $inv_line[$j]["charge_date"]=date("c",strtotime($res7['billdate']));
	   $inv_line[$j]["unit_price"]=$serviceitemrate;
	   $inv_line[$j]["quantity"]=$servicesquantity;
	   if($cashcopay>0 || $planforall=='yes'){
		 //$inv_line[$j]["line_copay"]=$cashcopay+number_format($copayser,2,'.','');
		 $inv_line[$j]["line_copay"]='';
	   }
	   
	   $inv_line[$j]["line_number"]=$sno;	
	   $sno++;
	   $j++;

	}

	$query18 = "select servicesfxamount from billing_patientweivers where visitcode='$visitcode' and patientcode='$patientcode' and servicesfxamount>0";
	$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res18 = mysqli_fetch_array($exec18))
	{
	   $inv_line[$j]["item_code"]='Discount'.$sno;
	   $inv_line[$j]["item_name"]="Service Discount";
	   $inv_line[$j]["charge_date"]=date("c",strtotime($res7['billdate']));
	   $inv_line[$j]["unit_price"]=0-number_format($res18['servicesfxamount'],2,'.','');
	   $inv_line[$j]["quantity"]=1;
	   $inv_line[$j]["line_number"]=$sno;
	   $sno++;
	   $j++;
	}
 
   /////////////////////// end services  /////////////////////////////////////
   /////////////////////// start referal  /////////////////////////////////////
    $query16 = "select * from billing_paylaterreferal where patientvisitcode = '$visitcode'";	
	$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res16 = mysqli_fetch_array($exec16))
	{
		$referalcode = $res16['referalcode'];	
		$referalcode = substr($referalcode,0,9);
		$referalname = $res16['referalname'];
		$referalquantity = '1';	
		$referalamount = $res16['referalrate'];	

		$copayref = ($referalamount/100)*$res17planpercentage;
		$copayref='';
		$inv_line[$j]["item_code"]=$referalcode;
	   $inv_line[$j]["item_name"]=$referalname;
	   $inv_line[$j]["charge_date"]=date("c",strtotime($res7['billdate']));
	   $inv_line[$j]["unit_price"]=$referalamount;
	   $inv_line[$j]["quantity"]=$referalquantity;
	   if($planforall=='yes'){
		 $inv_line[$j]["line_copay"]=$copayref;
	   }
	   $inv_line[$j]["line_number"]=$sno;	
	   $sno++;
	}

   /////////////////////// end referal  /////////////////////////////////////
   /////////////////////// start homecare  /////////////////////////////////////
   $query17 = "select * from billing_homecarepaylater where visitcode = '$visitcode'";	
	$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query17".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res17 = mysqli_fetch_array($exec17))
	{
		$homedocno = $res17['docno'];
		$homedocno = substr($homedocno,0,9);	
		$homename = $res17['description'];
		$homequantity = $res17['quantity'];	
		$homeamount = $res17['amount'];	
		$homereferalrate = $res17['rate'];
		$copayhom = (($homereferalrate)/100)*$res17planpercentage;
		$copayhom='';
		$inv_line[$j]["item_code"]=$homedocno;
	   $inv_line[$j]["item_name"]=$homename;
	   $inv_line[$j]["charge_date"]=date("c",strtotime($res7['billdate']));
	   $inv_line[$j]["unit_price"]=$homereferalrate;
	   $inv_line[$j]["quantity"]=$homequantity;
	   if($planforall=='yes'){
		 $inv_line[$j]["line_copay"]=$copayhom;
	   }
	   $inv_line[$j]["line_number"]=$sno;	
	   $sno++;
	   $j++;
	}

   /////////////////////// end homecare  /////////////////////////////////////

   /////////////////////// start ambulance  /////////////////////////////////////
   $query18 = "select * from billing_opambulancepaylater where visitcode = '$visitcode'";	
	$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res18 = mysqli_fetch_array($exec18))
	{
		$ambdocno = $res18['docno'];
		$ambdocno = substr($ambdocno,0,9);	
		$ambname = $res18['description'];
		$ambquantity = $res18['quantity'];	
		$ambamount = $res18['amount'];	
		$ambreferalrate = $res18['rate'];
		$copayopamb = (($ambreferalrate)/100)*$res17planpercentage;
		$copayopamb='';
		$inv_line[$j]["item_code"]=$ambdocno;
	   $inv_line[$j]["item_name"]=$ambname;
	   $inv_line[$j]["charge_date"]=date("c",strtotime($res7['billdate']));
	   $inv_line[$j]["unit_price"]=$ambreferalrate;
	   $inv_line[$j]["quantity"]=$ambquantity;
	   if($planforall=='yes'){
		 $inv_line[$j]["line_copay"]=$copayopamb;
	   }
	   $inv_line[$j]["line_number"]=$sno;	
	   $sno++;
	   $j++;
	}

   /////////////////////// end ambulance  /////////////////////////////////////

   json_encode($inv_line);
	$invoice_arry["lines"]=$inv_line;
	$inv_send=json_encode($invoice_arry);
	
/*	print_r($inv_send);
	exit;*/
		
	$query8 = "update billing_paylater set smartxml='".addslashes($inv_send)."' where visitcode = '$visitcode' ";
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
            $query8 = "update billing_paylater set slade_status='completed' where visitcode = '$visitcode' ";
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

//echo json_encode($inv_rslt);
?>