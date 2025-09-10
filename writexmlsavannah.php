<?php
include("db/db_connect.php");

$fileData1 = '';

date_default_timezone_set('Africa/Nairobi'); 

if(isset($_REQUEST['billautonumber'])) { $billautonumber = $_REQUEST['billautonumber']; } else { $billautonumber = ''; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST['visitcode']; } else { $visitcode = ''; }
if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST['patientcode']; } else { $patientcode = ''; }
if(isset($_REQUEST['printbill'])) { $printbill = $_REQUEST['printbill']; } else { $printbill = ''; }
if(isset($_REQUEST['frmflag1'])) { $frmflag1 = $_REQUEST['frmflag1']; } else { $frmflag1 = ''; }
if($frmflag1 == 'frmflag1')
{
$sno = 0;

$claimdate = date("Y-m-d");
$claimtime = date('H:i:s.u');

$query7 = "select * from master_visitentry where visitcode = '$visitcode'";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
$res7 = mysqli_fetch_array($exec7);
$memberno = $res7['memberno'];
$patientfullname = $res7['patientfullname'];
$consultationanum = $res7['consultationtype'];
$department = $res7['departmentname'];
$consultationfees = $res7['consultationfees'];
$payer_code = $res7['payer_code'];
$res17planpercentage=$res7['planpercentage'];
$plannumber = $res7['planname'];
$slade_authentication_token = $res7['slade_authentication_token'];
//$consultingdoctor = $res7['consultingdoctor'];
//$consultingdoctorcode = $res7['consultingdoctorcode'];
$consultationdate = $res7['consultationdate'];
$consultationtime = $res7['consultationtime'];
$savannah_authid = $res7['savannah_authid'];
$savannah_authflag = $res7['savannah_authflag'];
$consultationdate = date("Y-m-d",strtotime($consultationdate));
$consultationtime = date('H:i:s.u',strtotime($consultationtime));

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
if($memberno == '')
{
$memberno = $mrdno;
}
$dateofbirth = $res6['dateofbirth'];
$gender = $res6['gender'];
if($gender == 'Male') { $gender = 'M'; }
else { $gender = 'F'; }

$query8 = "select * from billing_paylater where visitcode = '$visitcode'";
$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
$res8 = mysqli_fetch_array($exec8);
$paylateramount = $res8['totalamount'];
$locationcode = $res8['locationcode'];
$locationname = $res8['locationname'];
$subtype = $res8['subtype'];
$accountname = $res8['accountname'];
$accountnameid = $res8['accountnameid'];

$query82 = "select a.username,b.employeename as username,b.employeecode as doctorcode,b.docusername from master_consultationlist a JOIN doctor_mapping b ON (a.username=b.docusername) where a.visitcode = '$visitcode' order by a.auto_number desc";
$exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die ("Error in Query82".mysqli_error($GLOBALS["___mysqli_ston"]));
$res82 = mysqli_fetch_array($exec82);
$consultingdoctor = $res82['username'];
$consultingdoctorcode = $res82['doctorcode'];

$query81 = "select * from master_transactionpaylater where billnumber = '$billautonumber' and transactiontype like 'finalize'";
$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
$res81 = mysqli_fetch_array($exec81);
 $transactiondate = $res81['transactiondate'];
$transactiontime = $res81['transactiontime'];
$transactiondate = date("Y-m-d",strtotime($transactiondate));
$transactiontime = date('H:i:s.u',strtotime($transactiontime));

$query115 = "select primarydiag, primaryicdcode from consultation_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number DESC";	
$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
$res115 = mysqli_fetch_array($exec115);		
$icd_name = $res115['primarydiag'];
$icd_code = $res115['primaryicdcode'];
$icd_code = substr($icd_code,0,6);	

 $fileData1 = $fileData1.addslashes("
			<Claim>
			<patient_name>".$patientfullname."</patient_name>
			<patient_number>".$patientcode."</patient_number>
			<nhif_number></nhif_number>
			<member_number>".$memberno."</member_number>
			<payer_code>".$payer_code."</payer_code>
			<payer_name>".$subtype."</payer_name>
			<scheme_code>".$accountnameid."</scheme_code>
			<scheme_name>".$accountname."</scheme_name>
			<visit_number>".$visitcode."</visit_number>
			<visit_end>".$transactiondate."T".$transactiontime."</visit_end>
			<visit_start>".$consultationdate."T".$consultationtime."</visit_start>
			<visit_type>OUTPATIENT</visit_type>
			<branch_code>".$locationcode."</branch_code>
			<branch_name>".$locationname."</branch_name>
			<slade_authentication_token>".$slade_authentication_token."</slade_authentication_token>
			<diagnoses>
			<diagnosis>
			</diagnosis>
			</diagnoses>
			<doctors>
			<doctor>
			<code>".$consultingdoctorcode."</code>
			<name>".$consultingdoctor."</name>
			</doctor>
			</doctors>
			<invoices>
			<invoice>
			<provider_claim_no>".$billautonumber."</provider_claim_no>
			<workflow_state>FINAL</workflow_state>
			<bill_from>".$consultationdate."T".$consultationtime."</bill_from>
			<bill_to>".$transactiondate."T".$transactiontime."</bill_to>
			<copays>");
				

				
/*$query11 = "select * from billing_paylaterconsultation where billno = '$billautonumber'";	
$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
$res11 = mysql_fetch_array($exec11);
$consultationamount = $res11['totalamount'];		
*/
$query13 = "select primarydiag,primaryicdcode,patientvisitcode,consultationtime,consultationdate from consultation_icd where patientvisitcode = '$visitcode' ";	
$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res13 = mysqli_fetch_array($exec13))
{
$icdcode = $res13['primaryicdcode'];
$icdcode = substr($icdcode,0,9);	
$icdname = $res13['primarydiag'];
$consultationdate = $res13['consultationdate'];
$consultationtime = $res13['consultationtime'];
$patientvisitcode = $res13['patientvisitcode'];
			
$sno = $sno + 1;
$fileData1 = $fileData1.addslashes("
			<diagnoses>
			<code>".$icdcode."</code>
			<charge_date>".$consultationdate."T".$consultationtime."</charge_date>
			<name>".$icdname."</name>
			<provider_copay_number>".$patientvisitcode."</provider_copay_number>
			</diagnoses>");
 }

		
$query17 = "select consultationfees from master_visitentry where visitcode='$visitcode' and patientcode='$patientcode'";
$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res17 = mysqli_fetch_array($exec17);
$consultationamount=$res17['consultationfees'];
	
$copayconsult = ($consultationamount/100)*$res17planpercentage;

$sno = $sno + 1;

if($planforall=='yes'){ 

$sno = $sno + 1;
$consultationtype="CONSULTATION COPAY";

$fileData1 = $fileData1.addslashes("
			<copay>
			<charge>".$copayconsult."</charge>
			<charge_date>".$transactiondate."T".$transactiontime."</charge_date>
			<copay_type>".$consultationtype."</copay_type>
			<provider_copay_number>".$billautonumber."</provider_copay_number>
			</copay>");
	
}

$query18 = "select copayfixedamount,billnumber from master_billing where visitcode='$visitcode' and patientcode='$patientcode'";
$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res18 = mysqli_fetch_array($exec18))
{
$copayfixedamount = $res18['copayfixedamount'];
$billnumbercon = $res18['billnumber'];
$res18total = $copayfixedamount/1;

if($copayfixedamount!=0.00){

$sno = $sno + 1;
$consultationtype="CONSULTATION COPAY FIXED";

$fileData1 = $fileData1.addslashes("
			<copay>
			<charge>".$copayfixedamount."</charge>
			<charge_date>".$transactiondate."T".$transactiontime."</charge_date>
			<copay_type>".$consultationtype."</copay_type>
			<provider_copay_number>".$billnumbercon."</provider_copay_number>
			</copay>");

}


}

$querya12 = "select * from billing_paylaterpharmacy where patientvisitcode = '$visitcode' and medicinename <> 'DISPENSING'";	
$execa12 = mysqli_query($GLOBALS["___mysqli_ston"], $querya12) or die ("Error in Querya12".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($execa12)>0)
{
	
$query12 = "select * from billing_paylaterpharmacy where patientvisitcode = '$visitcode' and billnumber = '$billautonumber'";	
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
$copaypharm = (($res199rate*$medquantity)/100)*$res17planpercentage;
}			
if($medicinename == 'DISPENSING'){
$medamount = 40;
$res199rate = 40;	
$copaypharm = (40/100)*$res17planpercentage;
}

$sno = $sno + 1;

	

if($planforall=='yes'){ 
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
			<copay>
			<charge>".$copaypharm."</charge>
			<charge_date>".$transactiondate."T".$transactiontime."</charge_date>
			<copay_type>".$medicinename."</copay_type>
			<provider_copay_number>".$billautonumber."</provider_copay_number>
			</copay>");

}
}

}

$query13 = "select * from billing_paylaterlab where patientvisitcode = '$visitcode' and billnumber = '$billautonumber'";	
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
$labrate = $labrate/$labquantity;
$copaylab = ($labrate/100)*$res17planpercentage;
				
$sno = $sno + 1;


 if($planforall=='yes'){
	$sno = $sno + 1;
	$fileData1 = $fileData1.addslashes("
			<copay>
			<charge>".$copaylab."</charge>
			<charge_date>".$transactiondate."T".$transactiontime."</charge_date>
			<copay_type>".$labname."</copay_type>
			<provider_copay_number>".$billautonumber."</provider_copay_number>
			</copay>");
 }

}	

$query14 = "select * from billing_paylaterradiology where patientvisitcode = '$visitcode' and billnumber = '$billautonumber'";	
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
$radiologyrate = $radiologyrate/$radiologyquantity;
$copayrad = ($radiologyrate/100)*$res17planpercentage;
			
$sno = $sno + 1;

 if($planforall=='yes'){
	$sno = $sno + 1;
				
	$fileData1 = $fileData1.addslashes("
			<copay>
			<charge>".$copayrad."</charge>
			<charge_date>".$transactiondate."T".$transactiontime."</charge_date>
			<copay_type>".$radiologyname."</copay_type>
			<provider_copay_number>".$billautonumber."</provider_copay_number>
			</copay>");
	 }
}	

$query15 = "select * from billing_paylaterservices where patientvisitcode = '$visitcode' and billnumber = '$billautonumber'";	
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

$query233 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$servicescode_full'";
$exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
$res233 = mysqli_fetch_array($exec233);
$numrow233 = mysqli_num_rows($exec233);
$serviceitemrate = $res233['servicesitemrate'];
$servicesamount=$serviceitemrate*$servicesquantity;
$copayser = ($serviceitemrate*$servicesquantity/100)*$res17planpercentage;
			
$sno = $sno + 1;


if($planforall=='yes'){
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
			<copay>
			<charge>".$copayser."</charge>
			<charge_date>".$transactiondate."T".$transactiontime."</charge_date>
			<copay_type>".$servicesname."</copay_type>
			<provider_copay_number>".$billautonumber."</provider_copay_number>
			</copay>");

}

}	

$query16 = "select * from billing_paylaterreferal where patientvisitcode = '$visitcode' and billnumber = '$billautonumber'";	
$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res16 = mysqli_fetch_array($exec16))
{
$referalcode = $res16['referalcode'];	
$referalcode = substr($referalcode,0,9);
$referalname = $res16['referalname'];
$referalquantity = '1';	
$referalamount = $res16['referalrate'];	

$copayref = ($referalamount/100)*$res17planpercentage;
			
$sno = $sno + 1;

if($planforall=='yes'){
$sno = $sno + 1;

$fileData1 = $fileData1.addslashes("
			<copay>
			<charge>".$copayref."</charge>
			<charge_date>".$transactiondate."T".$transactiontime."</charge_date>
			<copay_type>".$referalname."</copay_type>
			<provider_copay_number>".$billautonumber."</provider_copay_number>
			</copay>");

}

}	

$query17 = "select * from billing_homecarepaylater where visitcode = '$visitcode' and billnumber = '$billautonumber'";	
$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query17".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res17 = mysqli_fetch_array($exec17))
{
$homedocno = $res17['docno'];
$homedocno = substr($homedocno,0,9);	
$homename = $res17['description'];
$homequantity = $res17['quantity'];	
$homeamount = $res17['amount'];	
$homereferalrate = $res17['rate'];
$copayhom = (($homereferalrate*$homequantity)/100)*$res17planpercentage;
			
$sno = $sno + 1;

if($planforall=='yes'){
$sno = $sno + 1;

$fileData1 = $fileData1.addslashes("
			<copay>
			<charge>".$copayhom."</charge>
			<charge_date>".$transactiondate."T".$transactiontime."</charge_date>
			<copay_type>".$homename."</copay_type>
			<provider_copay_number>".$billautonumber."</provider_copay_number>
			</copay>");

}
}	

$query18 = "select * from billing_opambulancepaylater where visitcode = '$visitcode' and billnumber = '$billautonumber'";	
$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res18 = mysqli_fetch_array($exec18))
{
$ambdocno = $res18['docno'];
$ambdocno = substr($ambdocno,0,9);	
$ambname = $res18['description'];
$ambquantity = $res18['quantity'];	
$ambamount = $res18['amount'];	
$ambreferalrate = $res18['rate'];
$copayopamb = (($ambreferalrate*$ambquantity)/100)*$res17planpercentage;
			
$sno = $sno + 1;
				


if($planforall=='yes'){
$sno = $sno + 1;
$fileData1 = $fileData1.addslashes("
			<copay>
			<charge>".$copayopamb."</charge>
			<charge_date>".$transactiondate."T".$transactiontime."</charge_date>
			<copay_type>".$ambname."</copay_type>
			<provider_copay_number>".$billautonumber."</provider_copay_number>
			</copay>
			");
}
}	
$fileData1 = $fileData1.addslashes("
			</copays>
			<invoice_lines>");
			
$query17 = "select consultationfees from master_visitentry where visitcode='$visitcode' and patientcode='$patientcode'";
$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res17 = mysqli_fetch_array($exec17);
$consultationamount=$res17['consultationfees'];
	
$copayconsult = ($consultationamount/100)*$res17planpercentage;

$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
	<invoice_line>
	<billing_code>CON-MAIN</billing_code>
	<charge_date>".$transactiondate."T".$transactiontime."</charge_date>
	<name>Consultation</name>
	<provider_claimline_no>".$billautonumber."</provider_claimline_no>
	<quantity>1</quantity>
	<unit_price>".$consultationamount."</unit_price>
	</invoice_line>");




$querya12 = "select * from billing_paylaterpharmacy where patientvisitcode = '$visitcode' and medicinename <> 'DISPENSING'";	
$execa12 = mysqli_query($GLOBALS["___mysqli_ston"], $querya12) or die ("Error in Querya12".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($execa12)>0)
{
	
$query12 = "select * from billing_paylaterpharmacy where patientvisitcode = '$visitcode'  and billnumber = '$billautonumber'";	
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
$copaypharm = (($res199rate*$medquantity)/100)*$res17planpercentage;
}			
if($medicinename == 'DISPENSING'){
$medicinecode = 'DISP';
$medamount = 40;
$res199rate = 40;	
$copaypharm = (40/100)*$res17planpercentage;
}

$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
	<invoice_line>
	<billing_code>".$medicinecode."</billing_code>
	<charge_date>".$transactiondate."T".$transactiontime."</charge_date>
	<name>".$medicinename."</name>
	<provider_claimline_no>".$billautonumber."</provider_claimline_no>
	<quantity>".$medquantity."</quantity>
	<unit_price>".$res199rate."</unit_price>
	</invoice_line>");
}

}

$query13 = "select * from billing_paylaterlab where patientvisitcode = '$visitcode' and billnumber = '$billautonumber'";	
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
$labrate = $labrate/$labquantity;
$copaylab = ($labrate/100)*$res17planpercentage;
				
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
	<invoice_line>
	<billing_code>".$labcode."</billing_code>
	<charge_date>".$transactiondate."T".$transactiontime."</charge_date>
	<name>".$labname."</name>
	<provider_claimline_no>".$billautonumber."</provider_claimline_no>
	<quantity>1</quantity>
	<unit_price>".$labrate."</unit_price>
	</invoice_line>");



}	

$query14 = "select * from billing_paylaterradiology where patientvisitcode = '$visitcode' and billnumber = '$billautonumber'";	
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
$radiologyrate = $radiologyrate/$radiologyquantity;
$copayrad = ($radiologyrate/100)*$res17planpercentage;
			
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
	<invoice_line>
	<billing_code>".$radiologycode."</billing_code>
	<charge_date>".$transactiondate."T".$transactiontime."</charge_date>
	<name>".$radiologyname."</name>
	<provider_claimline_no>".$billautonumber."</provider_claimline_no>
	<quantity>1</quantity>
	<unit_price>".$radiologyrate."</unit_price>
	</invoice_line>
	");


}	

$query15 = "select * from billing_paylaterservices where patientvisitcode = '$visitcode' and billnumber = '$billautonumber'";	
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

$query233 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$servicescode_full'";
$exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
$res233 = mysqli_fetch_array($exec233);
$numrow233 = mysqli_num_rows($exec233);
$serviceitemrate = $res233['servicesitemrate'];
$servicesamount=$serviceitemrate*$servicesquantity;
$copayser = ($serviceitemrate*$servicesquantity/100)*$res17planpercentage;
			
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
	<invoice_line>
	<billing_code>".$servicescode."</billing_code>
	<charge_date>".$transactiondate."T".$transactiontime."</charge_date>
	<name>".$servicesname."</name>
	<provider_claimline_no>".$billautonumber."</provider_claimline_no>
	<quantity>".$servicesquantity."</quantity>
	<unit_price>".$serviceitemrate."</unit_price>
	</invoice_line>
	");



}	

$query16 = "select * from billing_paylaterreferal where patientvisitcode = '$visitcode' and billnumber = '$billautonumber'";	
$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res16 = mysqli_fetch_array($exec16))
{
$referalcode = $res16['referalcode'];	
$referalcode = substr($referalcode,0,9);
$referalname = $res16['referalname'];
$referalquantity = '1';	
$referalamount = $res16['referalrate'];	

$copayref = ($referalamount/100)*$res17planpercentage;
			
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
	<invoice_line>
	<billing_code>".$referalcode."</billing_code>
	<charge_date>".$transactiondate."T".$transactiontime."</charge_date>
	<name>".$referalname."</name>
	<provider_claimline_no>".$billautonumber."</provider_claimline_no>
	<quantity>".$referalquantity."</quantity>
	<unit_price>".$referalamount."</unit_price>
	</invoice_line>
	");



}	

$query17 = "select * from billing_homecarepaylater where visitcode = '$visitcode' and billnumber = '$billautonumber'";	
$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query17".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res17 = mysqli_fetch_array($exec17))
{
$homedocno = $res17['docno'];
$homedocno = substr($homedocno,0,9);	
$homename = $res17['description'];
$homequantity = $res17['quantity'];	
$homeamount = $res17['amount'];	
$homereferalrate = $res17['rate'];
$copayhom = (($homereferalrate*$homequantity)/100)*$res17planpercentage;
			
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
	<invoice_line>
	<billing_code>".$homedocno."</billing_code>
	<charge_date>".$transactiondate."T".$transactiontime."</charge_date>
	<name>".$homename."</name>
	<provider_claimline_no>".$billautonumber."</provider_claimline_no>
	<quantity>".$homequantity."</quantity>
	<unit_price>".$homereferalrate."</unit_price>
	</invoice_line>
	");


}	

$query18 = "select * from billing_opambulancepaylater where visitcode = '$visitcode' and billnumber = '$billautonumber'";	
$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res18 = mysqli_fetch_array($exec18))
{
$ambdocno = $res18['docno'];
$ambdocno = substr($ambdocno,0,9);	
$ambname = $res18['description'];
$ambquantity = $res18['quantity'];	
$ambamount = $res18['amount'];	
$ambreferalrate = $res18['rate'];
$copayopamb = (($ambreferalrate*$ambquantity)/100)*$res17planpercentage;
			
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
	
	<invoice_line>
	<billing_code>".$ambdocno."</billing_code>
	<charge_date>".$transactiondate."T".$transactiontime."</charge_date>
	<name>".$ambname."</name>
	<provider_claimline_no>".$billautonumber."</provider_claimline_no>
	<quantity>".$ambquantity."</quantity>
	<unit_price>".$ambreferalrate."</unit_price>
	</invoice_line>
	");

}	

$fileData1 = $fileData1.addslashes("</invoice_lines>
</invoice>
</invoices>
</Claim>");

$importData = $fileData1;

$updatedate = date('Y-m-d H:i:s');

include("writexmlsavannah_in.php");

header("location:billing_pending_op2.php?billautonumber=$billautonumber&&st=success&&printbill=$printbill");
exit;
}
?>
