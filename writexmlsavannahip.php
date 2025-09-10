<?php
include("db/db_connect.php");

$fileData1 = '';

date_default_timezone_set('Africa/Nairobi'); 

if(isset($_REQUEST['billautonumber'])) { $billautonumber = $_REQUEST['billautonumber']; } else { $billautonumber = ''; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST['visitcode']; } else { $visitcode = ''; }
if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST['patientcode']; } else { $patientcode = ''; }
if(isset($_REQUEST['printbill'])) { $printbill = $_REQUEST['printbill']; } else { $printbill = ''; }
if(isset($_REQUEST['loc'])) { $loc = $_REQUEST['loc']; } else { $loc = ''; }
if(isset($_REQUEST['frmflag1'])) { $frmflag1 = $_REQUEST['frmflag1']; } else { $frmflag1 = ''; }
if($frmflag1 == 'frmflag1')
{
$sno = 0;
$claimdate = date('Y-m-d');
$claimtime = date('H:i:s.u');
$consultingdoctorcode ='';
$consultingdoctor ='';
$query7 = "select * from master_ipvisitentry where visitcode = '$visitcode'";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
$res7 = mysqli_fetch_array($exec7);
$smartbenefitno = '';
$patientfirstname = $res7['patientfirstname'];
$patientmiddlename = $res7['patientmiddlename'];
$patientlastname = $res7['patientlastname'];
$patientfullname = $res7['patientfullname'];
$consultationanum = $res7['consultationtype'];
$department = $res7['department'];
$consultationfees = $res7['admissionfees'];
$locationcodeget = $res7['locationcode'];
 $res17planpercentage=$res7['planpercentage'];
$savannah_authid = $res7['savannah_authid'];
$savannah_authiflag = $res7['savannah_authflag'];
  $plannumber = $res7['planname'];
$memberno = $res7['memberno'];	
$payer_code = $res7['payer_code'];	
$nhifid = $res7['nhifid'];	
$slade_authentication_token = $res7['slade_authentication_token'];		
			$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resplanname = mysqli_fetch_array($execplanname);
		 	$planforall = $resplanname['forall'];


$query4 = "select * from master_consultationtype where auto_number = '$consultationanum'";
$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
$res4 = mysqli_fetch_array($exec4);
$consultationtype = $res4['consultationtype'];

$query6 = "select * from master_customer where customercode = '$patientcode'";
$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
$res6 = mysqli_fetch_array($exec6);
$mrdno = $res6['mrdno'];
$dateofbirth = $res6['dateofbirth'];
$gender = $res6['gender'];
if($gender == 'Male') { $gender = 'M'; }
else { $gender = 'F'; }

$query8 = "select * from master_transactionip where visitcode = '$visitcode' and patientcode='$patientcode'";
$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
$res8 = mysqli_fetch_array($exec8);
$paylateramount = $res8['transactionamount'];
$billdate = $res8['transactiondate'];
$billtime = $res8['transactiondate'];
$subtype = $res8['subtype'];
$accountname = $res8['accountname'];
$accountnameid = $res8['accountnameid'];
$locationcode = $res8['locationcode'];
$locationname = $res8['locationname'];
$billtime = date('H:i:s.u',strtotime($billtime));

$query2 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$admissiondate = $res2['recorddate'];
$admissiontime = $res2['recordtime'];
$admissiontime = date('H:i:s.u',strtotime($admissiontime));

$query32 = "select * from ip_discharge where patientcode='$patientcode' and visitcode='$visitcode'";
$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$num32 = mysqli_num_rows($exec32);
$res32 = mysqli_fetch_array($exec32);
$dischargedby = $res32['username'];
$dischargedate = $res32['recorddate'];
$dischargetime = $res32['recordtime'];
$dischargetime = date('H:i:s.u',strtotime($dischargetime));

/*$query321 = "select primaryname from dischargesummary where patientcode='$patientcode' and patientvisitcode='$visitcode' order by auto_number DESC";
$exec321 = mysql_query($query321) or die(mysql_error());
$res321 = mysql_fetch_array($exec321);*/
$query321 = "select primarydiag,primaryicdcode from consultation_icd where patientcode='$patientcode' and patientvisitcode='$visitcode' order by auto_number DESC";
$exec321 = mysqli_query($GLOBALS["___mysqli_ston"], $query321) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res321 = mysqli_fetch_array($exec321);
$primaryname = $res321['primarydiag'];
$primarycode = $res321['primaryicdcode'];
//$consultingdoctor = $res321['doctorname'];
//$consultingdoctorcode = $res321['doctorcode'];

/*$query3211 = "select icdcode from master_icd where description like '".$primaryname."'";
$exec3211 = mysql_query($query3211) or die(mysql_error());
$res3211 = mysql_fetch_array($exec3211);
$primarycode = $res321['icdcode'];*/
 $fileData1 = $fileData1.addslashes("
		<?xml version='1.0' encoding='UTF-8'?>
		<Claim>
		<patient_name>".$patientfullname."</patient_name>
		<patient_number>".$patientcode."</patient_number>
		<nhif_number>".$nhifid."</nhif_number>
		<member_number>".$memberno."</member_number>
		<payer_code>".$payer_code."</payer_code>
		<payer_name>".$subtype."</payer_name>
		<scheme_code>".$accountnameid."</scheme_code>
		<scheme_name>".$accountname."</scheme_name>
		<visit_number>".$visitcode."</visit_number>
		<visit_end>".$dischargedate."T".$dischargetime."</visit_end>
		<visit_start>".$admissiondate."T".$admissiontime."</visit_start>
		<visit_type>INPATIENT</visit_type>
		<branch_code>".$locationcode."</branch_code>
			<branch_name>".$locationname."</branch_name>
		<slade_authentication_token>".$slade_authentication_token."</slade_authentication_token>
		<diagnoses>
			<diagnosis>
			<code>".$primarycode."</code>
			<name>".$primaryname."</name>
			</diagnosis>
		</diagnoses>");
		
		$fileData1 = $fileData1.addslashes("<doctors>
		<doctor>
		<code>".$consultingdoctorcode."</code>
		<name>".$consultingdoctor."</name>
		</doctor>
		</doctors>
		<invoices>
			<invoice>
			<provider_claim_no>".$billautonumber."</provider_claim_no>
			<workflow_state>FINAL</workflow_state>
			<bill_from>".$admissiondate."T".$admissiontime."</bill_from>
			<bill_to>".$dischargedate."T".$dischargetime."</bill_to>");

$icd_name = '';
$icd_code = '';			
$query17 = "select admissionfees from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res17 = mysqli_fetch_array($exec17);
$consultationamount=$res17['admissionfees'];
	
$copayconsult = ($consultationamount/100)*$res17planpercentage;

$sno = $sno + 1;

if($planforall=='yes'){ 

$sno = $sno + 1;
$consultationtype="ADMISSION COPAY";

$fileData1 = $fileData1.addslashes("
		<copays>
		<copay>
		<charge>".$copayconsult."</charge>
		<charge_date>".$billdate."T".$billtime."</charge_date>
		<copay_type>SELF_PAY</copay_type>
		<provider_copay_number>".$billautonumber."</provider_copay_number>
		</copay>
		</copays>");	
}
$fileData1 = $fileData1.addslashes("
			<invoice_lines>");
$fileData1 = $fileData1.addslashes("
				<invoice_line>
				<billing_code>ADM</billing_code>
				<charge_date>".$billdate."T".$billtime."</charge_date>
				<name>Admission</name>
				<provider_claimline_no>".$billautonumber."</provider_claimline_no>
				<quantity>1</quantity>
				<unit_price>".$consultationamount."</unit_price>
				</invoice_line>");

$query91 = "select description,rate, quantity, recorddate, bed from billing_ipbedcharges where ward <> '0' and bed <> '0' and docno = '$billautonumber' and visitcode = '$visitcode'";
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
	
	$amount = $quantity * $rate;						
	$allocatequantiy = $quantity;
	$allocatenewquantity = $quantity;
	if($quantity>0)
	{
		$sno = $sno + 1;
		$consultationtype="BED CHARGES";
		
		$fileData1 = $fileData1.addslashes("
				<invoice_line>
				<billing_code>BED</billing_code>
				<charge_date>".$billdate."T".$billtime."</charge_date>
				<name>".$charge."</name>
				<provider_claimline_no>".$billautonumber."</provider_claimline_no>
				<quantity>".$quantity."</quantity>
				<unit_price>".$rate."</unit_price>
				</invoice_line>");
	}
}
}

$querya12 = "select * from billing_ippharmacy where patientvisitcode = '$visitcode' and medicinename <> 'DISPENSING'";	
$execa12 = mysqli_query($GLOBALS["___mysqli_ston"], $querya12) or die ("Error in Querya12".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($execa12)>0)
{
	
$query12 = "select * from billing_ippharmacy where patientvisitcode = '$visitcode'";	
$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res12 = mysqli_fetch_array($exec12))
{
$medicinecode = $res12['medicinecode'];	
$medicinecode_full = $res12['medicinecode'];	
$medicinecode = substr($medicinecode,0,9);
$medicinename = $res12['medicinename'];
$medquantity = $res12['quantity'];	
$medrate = $res12['rate'];	
$medamount = $res12['amount'];	

$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
				<invoice_line>
				<billing_code>".$medicinecode."</billing_code>
				<charge_date>".$billdate."T".$billtime."</charge_date>
				<name>".$medicinename."</name>
				<provider_claimline_no>".$billautonumber."</provider_claimline_no>
				<quantity>".$medquantity."</quantity>
				<unit_price>".$medrate."</unit_price>
				</invoice_line>");
}

}

$query13 = "select * from billing_iplab where patientvisitcode = '$visitcode'";	
$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res13 = mysqli_fetch_array($exec13))
{
$labcode = $res13['labitemcode'];
$labcode_full = $res13['labitemcode'];
$labcode = substr($labcode,0,9);	
$labname = $res13['labitemname'];
$labquantity = '1';	
$labrate = $res13['labitemrate'];	

$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
				<invoice_line>
				<billing_code>".$labcode."</billing_code>
				<charge_date>".$billdate."T".$billtime."</charge_date>
				<name>".$labname."</name>
				<provider_claimline_no>".$billautonumber."</provider_claimline_no>
				<quantity>".$labquantity."</quantity>
				<unit_price>".$labrate."</unit_price>
				</invoice_line>");
}	

$query14 = "select * from billing_ipradiology where patientvisitcode = '$visitcode'";	
$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res14 = mysqli_fetch_array($exec14))
{
$radiologycode = $res14['radiologyitemcode'];	
$radiologycode_full = $res14['radiologyitemcode'];	
$radiologycode = substr($radiologycode,0,9);
$radiologyname = $res14['radiologyitemname'];
$radiologyquantity = '1';	
$radiologyrate = $res14['radiologyitemrate'];	
		
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
				<invoice_line>
				<billing_code>".$radiologycode."</billing_code>
				<charge_date>".$billdate."T".$billtime."</charge_date>
				<name>".$radiologyname."</name>
				<provider_claimline_no>".$billautonumber."</provider_claimline_no>
				<quantity>".$radiologyquantity."</quantity>
				<unit_price>".$radiologyrate."</unit_price>
				</invoice_line>");
}	

$query15 = "select * from billing_ipservices where patientvisitcode = '$visitcode'";	
$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res15 = mysqli_fetch_array($exec15))
{
$servicescode = $res15['servicesitemcode'];	
$servicescode_full = $res15['servicesitemcode'];	
$servicescode = substr($servicescode,0,9);
$servicesname = $res15['servicesitemname'];
$servicesquantity = '1';
$servicesquantity = number_format($servicesquantity,0,'.','');	
$servicesamount = $res15['servicesitemrate'];	
			
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
				<invoice_line>
				<billing_code>".$servicescode."</billing_code>
				<charge_date>".$billdate."T".$billtime."</charge_date>
				<name>".$servicesname."</name>
				<provider_claimline_no>".$billautonumber."</provider_claimline_no>
				<quantity>".$servicesquantity."</quantity>
				<unit_price>".$servicesamount."</unit_price>
				</invoice_line>");
}	

$query16 = "select * from ip_otbilling where patientvisitcode = '$visitcode'";	
$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res16 = mysqli_fetch_array($exec16))
{
$referalcode = $res16['docno'];	
$referalcode = substr($referalcode,0,9);
$referalname = $res16['surgeryname'];
$referalquantity = '1';	
$referalamount = $res16['rate'];	
			
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
				<invoice_line>
				<billing_code>".$referalcode."</billing_code>
				<charge_date>".$billdate."T".$billtime."</charge_date>
				<name>".$referalname."</name>
				<provider_claimline_no>".$billautonumber."</provider_claimline_no>
				<quantity>".$referalquantity."</quantity>
				<unit_price>".$referalamount."</unit_price>
				</invoice_line>");
}	

$query17 = "select * from ipprivate_doctor where patientvisitcode = '$visitcode'";	
$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query17".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res17 = mysqli_fetch_array($exec17))
{
$drdocno = $res17['docno'];
$drdocno = substr($drdocno,0,9);	
$drname = $res17['doctorname'];
$drquantity = $res17['units'];	
$dramount = $res17['amount'];	
$drreferalrate = $res17['rate'];

$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
				<invoice_line>
				<billing_code>".$drdocno."</billing_code>
				<charge_date>".$billdate."T".$billtime."</charge_date>
				<name>".$drname."</name>
				<provider_claimline_no>".$billautonumber."</provider_claimline_no>
				<quantity>".$drquantity."</quantity>
				<unit_price>".$drreferalrate."</unit_price>
				</invoice_line>");
}	

$query18 = "select * from ip_ambulance where patientvisitcode = '$visitcode'";	
$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res18 = mysqli_fetch_array($exec18))
{
$ambdocno = $res18['docno'];
$ambdocno = substr($ambdocno,0,9);	
$ambname = $res18['description'];
$ambquantity = $res18['units'];	
$ambamount = $res18['amount'];	
$ambreferalrate = $res18['rate'];
			
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
				<invoice_line>
				<billing_code>".$ambdocno."</billing_code>
				<charge_date>".$billdate."T".$billtime."</charge_date>
				<name>".$ambname."</name>
				<provider_claimline_no>".$billautonumber."</provider_claimline_no>
				<quantity>".$ambquantity."</quantity>
				<unit_price>".$ambreferalrate."</unit_price>
				</invoice_line>");
}

$query19 = "select * from iphomecare where patientvisitcode = '$visitcode'";	
$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query19".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res19 = mysqli_fetch_array($exec19))
{
$homedocno = $res19['docno'];
$homedocno = substr($homedocno,0,9);	
$homename = $res19['description'];
$homequantity = $res19['units'];	
$homeamount = $res19['amount'];	
$homereferalrate = $res19['rate'];
			
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
				<invoice_line>
				<billing_code>".$homedocno."</billing_code>
				<charge_date>".$billdate."T".$billtime."</charge_date>
				<name>".$homename."</name>
				<provider_claimline_no>".$billautonumber."</provider_claimline_no>
				<quantity>".$homequantity."</quantity>
				<unit_price>".$homereferalrate."</unit_price>
				</invoice_line>");
}	

$query20 = "select * from ipmisc_billing where patientvisitcode = '$visitcode'";	
$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res20 = mysqli_fetch_array($exec20))
{
$miscdocno = $res20['docno'];
$miscdocno = substr($miscdocno,0,9);	
$miscname = $res20['description'];
$miscquantity = $res20['units'];	
$miscamount = $res20['amount'];	
$miscreferalrate = $res20['rate'];
			
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
				<invoice_line>
				<billing_code>".$miscdocno."</billing_code>
				<charge_date>".$billdate."T".$billtime."</charge_date>
				<name>".$miscname."</name>
				<provider_claimline_no>".$billautonumber."</provider_claimline_no>
				<quantity>".$miscquantity."</quantity>
				<unit_price>".$miscreferalrate."</unit_price>
				</invoice_line>");
}

$query21 = "select * from master_transactionipdeposit where visitcode = '$visitcode'";	
$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res21 = mysqli_fetch_array($exec21))
{
$depodocno = $res21['docno'];
$depodocno = substr($depodocno,0,9);	
$deponame = 'IP Deposit';
$depoquantity = 1;	
$depoamount = $res21['transactionamount'];	
$deporeferalrate = $res21['transactionamount'];
			
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
				<invoice_line>
				<billing_code>".$depodocno."</billing_code>
				<charge_date>".$billdate."T".$billtime."</charge_date>
				<name>".$deponame."</name>
				<provider_claimline_no>".$billautonumber."</provider_claimline_no>
				<quantity>".$depoquantity."</quantity>
				<unit_price>-".$deporeferalrate."</unit_price>
				</invoice_line>");
}

$query22 = "select * from master_transactionadvancedeposit where visitcode = '$visitcode' and recordstatus='adjusted'";
$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res22 = mysqli_fetch_array($exec22))
{
$depodocno = $res22['docno'];
$depodocno = substr($depodocno,0,9);	
$deponame = 'Advance Deposit';
$depoquantity = 1;	
$depoamount = $res22['transactionamount'];	
$deporeferalrate = $res22['transactionamount'];
			
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
				<invoice_line>
				<billing_code>".$depodocno."</billing_code>
				<charge_date>".$billdate."T".$billtime."</charge_date>
				<name>".$deponame."</name>
				<provider_claimline_no>".$billautonumber."</provider_claimline_no>
				<quantity>".$depoquantity."</quantity>
				<unit_price>-".$deporeferalrate."</unit_price>
				</invoice_line>");
}	

$query23 = "select * from deposit_refund where visitcode = '$visitcode'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res23 = mysqli_fetch_array($exec23))
{
$depodocno = $res23['docno'];
$depodocno = substr($depodocno,0,9);	
$deponame = 'Deposit Refund';
$depoquantity = 1;	
$depoamount = $res23['amount'];	
$deporeferalrate = $res23['amount'];
			
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
				<invoice_line>
				<billing_code>".$depodocno."</billing_code>
				<charge_date>".$billdate."T".$billtime."</charge_date>
				<name>".$deponame."</name>
				<provider_claimline_no>".$billautonumber."</provider_claimline_no>
				<quantity>".$depoquantity."</quantity>
				<unit_price>".$deporeferalrate."</unit_price>
				</invoice_line>");
}	

$query24 = "select * from ip_nhifprocessing where patientvisitcode = '$visitcode'";
$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res24 = mysqli_fetch_array($exec24))
{
$nhifdocno = $res24['docno'];
$nhifdocno = substr($nhifdocno,0,9);	
$nhifname = 'NHIF';
$nhifquantity = $res24['totaldays'];
$nhifamount = $res24['nhifclaim'];	
$nhifreferalrate = $res24['nhifrebate'];
			
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
				<invoice_line>
				<billing_code>".$nhifdocno."</billing_code>
				<charge_date>".$billdate."T".$billtime."</charge_date>
				<name>".$nhifname."</name>
				<provider_claimline_no>".$billautonumber."</provider_claimline_no>
				<quantity>".$nhifquantity."</quantity>
				<unit_price>-".$nhifreferalrate."</unit_price>
				</invoice_line>");
}	

$query25 = "select * from ip_discount where patientvisitcode = '$visitcode'";
$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res25 = mysqli_fetch_array($exec25))
{
$discdocno = $res25['docno'];
$discdocno = substr($discdocno,0,9);	
$discname = $res25['description'];
$discquantity = $res25['unit'];
$discrate = $res25['rate'];
$discamount = $discrate * $discquantity;	
			
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
				<invoice_line>
				<billing_code>".$discdocno."</billing_code>
				<charge_date>".$billdate."T".$billtime."</charge_date>
				<name>".$discname."</name>
				<provider_claimline_no>".$billautonumber."</provider_claimline_no>
				<quantity>".$discquantity."</quantity>
				<unit_price>-".$discrate."</unit_price>
				</invoice_line>");
}

$fileData1 = $fileData1.addslashes("
			    </invoice_lines>
			</invoice>
			</invoices>
			</Claim>");

 $importData = $fileData1;

$updatedate = date('Y-m-d H:i:s');

include("writexmlsavannah_in.php");

header("location:print_ipfinalinvoice1.php?patientcode=$patientcode&&visitcode=$visitcode&&billnumber=$billautonumber&&loc=$locationcodeget");
exit;
}
?>
