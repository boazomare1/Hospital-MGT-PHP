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
$claimdate = date('Y-m-d');
$claimtime = date('H:i:s');

$query7 = "select * from master_visitentry where visitcode = '$visitcode'";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
$res7 = mysqli_fetch_array($exec7);
$smartbenefitno = $res7['smartbenefitno'];
$patientfirstname = $res7['patientfirstname'];
$patientmiddlename = $res7['patientmiddlename'];
$patientlastname = $res7['patientlastname'];
$consultationanum = $res7['consultationtype'];
$department = $res7['departmentname'];
$consultationfees = $res7['consultationfees'];
$subtype = $res7['subtype'];
//$querysub = "select is_savannah from master_subtype where auto_number = '$subtype'";
//$execsub = mysql_query($querysub) or die ("Error in querysub".mysql_error());
//$ressub = mysql_fetch_array($execsub);
$is_savannah = '';
 $res17planpercentage=$res7['planpercentage'];
  $plannumber = $res7['planname'];
			
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

$query8 = "select * from billing_paylater where visitcode = '$visitcode'";
$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
$res8 = mysqli_fetch_array($exec8);
$paylateramount = $res8['totalamount'];

 $fileData1 = $fileData1.addslashes("
			<Claim>
			<Claim_Header>
				<Invoice_Number>".$billautonumber."</Invoice_Number>
				<Claim_Date>".$claimdate."</Claim_Date>
				<Claim_Time>".$claimtime."</Claim_Time>
				<Pool_Number>".$smartbenefitno."</Pool_Number>
				<Total_Services>".$sno."</Total_Services>
				<Gross_Amount>".$paylateramount."</Gross_Amount>
				<Provider>
				<Role>SP</Role>
				<Country_Code>KEN</Country_Code>
				<Group_Practice_Number>SKSP_3540</Group_Practice_Number>
				<Group_Practice_Name>Premier Hospital</Group_Practice_Name>
				</Provider>
				<Authorization>
				<Pre_Authorization_Number>0</Pre_Authorization_Number>
				<Pre_Authorization_Amount>0</Pre_Authorization_Amount>
				</Authorization>
				<Payment_Modifiers>
					<Payment_Modifier>
						<Type>1</Type>
						<Amount>0</Amount>
						<Receipt>0</Receipt>
					</Payment_Modifier>
					<PaymentModifier>
						<Type>5</Type>
						<NHIF_Member_Nr>0</NHIF_Member_Nr>
						<NHIF_Contributor_Nr>0</NHIF_Contributor_Nr>
						<NHIF_Employer_Code>0</NHIF_Employer_Code>
						<NHIF_Site_Nr>0</NHIF_Site_Nr>
						<NHIF_Patient_Relation>0</NHIF_Patient_Relation>
						<Diagnosis_Code>0</Diagnosis_Code>
						<Admit_Date>".$claimdate."</Admit_Date>
						<Discharge_Date>".$claimdate."</Discharge_Date>
						<Days_Used>0</Days_Used>
						<Amount>0</Amount>
					</PaymentModifier>
				</Payment_Modifiers>
			</Claim_Header>
			<Member>
				<Membership_Number>".$mrdno."</Membership_Number>
				<card_serialnumber>00000010000JB529</card_serialnumber>
				<Scheme_Code>unknown</Scheme_Code>
				<Scheme_Plan>unknown</Scheme_Plan>
			</Member>
			<Patient>
				<Dependant>Y</Dependant>
				<First_Name>".$patientfirstname."</First_Name>
				<Middle_Name>".$patientmiddlename."</Middle_Name>
				<Surname>".$patientlastname."</Surname>
				<Date_Of_Birth>".$dateofbirth."</Date_Of_Birth>
				<Gender>".$gender."</Gender>
				<patient_hospitalnumber>".$patientcode."</patient_hospitalnumber>
			</Patient>
			<Claim_Data>
				<Discharge_Notes>Diagn</Discharge_Notes>");
				
$icd_name = '';
$icd_code = '';
$icd_code = substr($icd_code,0,6);	
				
/*$query11 = "select * from billing_paylaterconsultation where billno = '$billautonumber'";	
$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
$res11 = mysql_fetch_array($exec11);
$consultationamount = $res11['totalamount'];		
*/
			
$query17 = "select consultationfees from master_visitentry where visitcode='$visitcode' and patientcode='$patientcode'";
$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res17 = mysqli_fetch_array($exec17);
$consultationamount=$res17['consultationfees'];
	
$copayconsult = ($consultationamount/100)*$res17planpercentage;

$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
	<Service>
	<Number>".$sno."</Number>
	<Invoice_Number>".$billautonumber."</Invoice_Number>
	<Global_Invoice_Nr>0</Global_Invoice_Nr>
	<Start_Date>".$claimdate."</Start_Date>
	<Start_Time>".$claimtime."</Start_Time>
	<Provider>
		<Role>SP</Role>
		<Practice_Number>SKSP_3540</Practice_Number>
	</Provider>");
	
	$query115 = "select primarydiag, primaryicdcode from consultation_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number";	
	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>".$icd_name."</Code_Type>
			<Code>".$icd_code."</Code>
		</Diagnosis>");
		}
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	
	$fileData1 = $fileData1.addslashes("
	<Encounter_Type>CONSULTATION</Encounter_Type>
	<Code_Type>".$department."</Code_Type>
	<Code>".$visitcode."</Code>
	<Code_Description>".$consultationtype."</Code_Description>
	<Quantity>1</Quantity>
	<Total_Amount>".$consultationamount."</Total_Amount>
	<Reason></Reason>
	</Service>");

if($planforall=='yes'){ 

$sno = $sno + 1;
$consultationtype="CONSULTATION COPAY";

$fileData1 = $fileData1.addslashes("
	<Service>
	<Number>".$sno."</Number>
	<Invoice_Number>".$billautonumber."</Invoice_Number>
	<Global_Invoice_Nr>0</Global_Invoice_Nr>
	<Start_Date>".$claimdate."</Start_Date>
	<Start_Time>".$claimtime."</Start_Time>
	<Provider>
		<Role>SP</Role>
		<Practice_Number>SKSP_3540</Practice_Number>
	</Provider>");
	
	$query115 = "select primarydiag, primaryicdcode from consultation_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number";	
	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>".$icd_name."</Code_Type>
			<Code>".$icd_code."</Code>
		</Diagnosis>");
		}
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	
	$fileData1 = $fileData1.addslashes("
	<Encounter_Type>CONSULTATION</Encounter_Type>
	<Code_Type>".$department."</Code_Type>
	<Code>".$visitcode."</Code>
	<Code_Description>".$consultationtype."</Code_Description>
	<Quantity>1</Quantity>
	<Total_Amount>".-$copayconsult."</Total_Amount>
	<Reason></Reason>
	</Service>");
	
}

$query18 = "select copayfixedamount from master_billing where visitcode='$visitcode' and patientcode='$patientcode'";
$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res18 = mysqli_fetch_array($exec18))
{
$copayfixedamount = $res18['copayfixedamount'];
$res18total = $copayfixedamount/1;

if($copayfixedamount!=0.00){

$sno = $sno + 1;
$consultationtype="CONSULTATION COPAY FIXED";

$fileData1 = $fileData1.addslashes("
	<Service>
	<Number>".$sno."</Number>
	<Invoice_Number>".$billautonumber."</Invoice_Number>
	<Global_Invoice_Nr>0</Global_Invoice_Nr>
	<Start_Date>".$claimdate."</Start_Date>
	<Start_Time>".$claimtime."</Start_Time>
	<Provider>
		<Role>SP</Role>
		<Practice_Number>SKSP_3540</Practice_Number>
	</Provider>");
	$query115 = "select primarydiag, primaryicdcode from consultation_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number";	
	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>".$icd_name."</Code_Type>
			<Code>".$icd_code."</Code>
		</Diagnosis>");
		}
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	$fileData1 = $fileData1.addslashes("
	<Encounter_Type>CONSULTATION</Encounter_Type>
	<Code_Type>".$department."</Code_Type>
	<Code>".$visitcode."</Code>
	<Code_Description>".$consultationtype."</Code_Description>
	<Quantity>1</Quantity>
	<Total_Amount>".-$copayfixedamount."</Total_Amount>
	<Reason></Reason>
	</Service>");

}


}

$query18 = "select consultationfxamount from billing_patientweivers where visitcode='$visitcode' and patientcode='$patientcode'";
$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res18 = mysqli_fetch_array($exec18))
{
$copayfixedamount = $res18['consultationfxamount'];
$res18total = $copayfixedamount/1;

if($copayfixedamount>0){

$sno = $sno + 1;
$consultationtype="CONSULTATION DISCOUNT";

$fileData1 = $fileData1.addslashes("
	<Service>
	<Number>".$sno."</Number>
	<Invoice_Number>".$billautonumber."</Invoice_Number>
	<Global_Invoice_Nr>0</Global_Invoice_Nr>
	<Start_Date>".$claimdate."</Start_Date>
	<Start_Time>".$claimtime."</Start_Time>
	<Provider>
		<Role>SP</Role>
		<Practice_Number>SKSP_3540</Practice_Number>
	</Provider>");
	$query115 = "select primarydiag, primaryicdcode from consultation_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number";	
	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>".$icd_name."</Code_Type>
			<Code>".$icd_code."</Code>
		</Diagnosis>");
		}
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	$fileData1 = $fileData1.addslashes("
	<Encounter_Type>CONSULTATION</Encounter_Type>
	<Code_Type>".$department."</Code_Type>
	<Code>".$visitcode."</Code>
	<Code_Description>".$consultationtype."</Code_Description>
	<Quantity>1</Quantity>
	<Total_Amount>".-$copayfixedamount."</Total_Amount>
	<Reason></Reason>
	</Service>");

}


}

$querya12 = "select * from billing_paylaterpharmacy where patientvisitcode = '$visitcode' and medicinename <> 'DISPENSING'";	
$execa12 = mysqli_query($GLOBALS["___mysqli_ston"], $querya12) or die ("Error in Querya12".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($execa12)>0)
{
	
$query12 = "select * from billing_paylaterpharmacy where patientvisitcode = '$visitcode'";	
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
$medamount = 0;	
$copaypharm = (0/100)*$res17planpercentage;
}

$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
	<Service>
	<Number>".$sno."</Number>
	<Invoice_Number>".$billautonumber."</Invoice_Number>
	<Global_Invoice_Nr>0</Global_Invoice_Nr>
	<Start_Date>".$claimdate."</Start_Date>
	<Start_Time>".$claimtime."</Start_Time>
	<Provider>
		<Role>SP</Role>
		<Practice_Number>SKSP_3540</Practice_Number>
	</Provider>");
	$query115 = "select primarydiag, primaryicdcode from consultation_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number";	
	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>".$icd_name."</Code_Type>
			<Code>".$icd_code."</Code>
		</Diagnosis>");
		}
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	$fileData1 = $fileData1.addslashes("
	<Encounter_Type>Pharmacy</Encounter_Type>
	<Code_Type>Mcode</Code_Type>
	<Code>".$medicinecode."</Code>
	<Code_Description>".$medicinename."</Code_Description>
	<Quantity>".$medquantity."</Quantity>
	<Total_Amount>".$medamount."</Total_Amount>
	<Reason></Reason>
	</Service>");
	

if($planforall=='yes'){ 
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
	<Service>
	<Number>".$sno."</Number>
	<Invoice_Number>".$billautonumber."</Invoice_Number>
	<Global_Invoice_Nr>0</Global_Invoice_Nr>
	<Start_Date>".$claimdate."</Start_Date>
	<Start_Time>".$claimtime."</Start_Time>
	<Provider>
		<Role>SP</Role>
		<Practice_Number>SKSP_3540</Practice_Number>
	</Provider>");
	$query115 = "select primarydiag, primaryicdcode from consultation_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number";	
	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>".$icd_name."</Code_Type>
			<Code>".$icd_code."</Code>
		</Diagnosis>");
		}
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	$fileData1 = $fileData1.addslashes("
	<Encounter_Type>Pharmacy</Encounter_Type>
	<Code_Type>Mcode</Code_Type>
	<Code>".$medicinecode."</Code>
	<Code_Description>".$medicinename." - COPAY</Code_Description>
	<Quantity>".$medquantity."</Quantity>
	<Total_Amount>".-$copaypharm."</Total_Amount>
	<Reason></Reason>
	</Service>");

}
}

}

$query18 = "select pharmacyfxamount from billing_patientweivers where visitcode='$visitcode' and patientcode='$patientcode'";
$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res18 = mysqli_fetch_array($exec18))
{
$copayfixedamount = $res18['pharmacyfxamount'];
$res18total = $copayfixedamount/1;

if($copayfixedamount>0){

$sno = $sno + 1;
$consultationtype="PHARMACY DISCOUNT";

$fileData1 = $fileData1.addslashes("
	<Service>
	<Number>".$sno."</Number>
	<Invoice_Number>".$billautonumber."</Invoice_Number>
	<Global_Invoice_Nr>0</Global_Invoice_Nr>
	<Start_Date>".$claimdate."</Start_Date>
	<Start_Time>".$claimtime."</Start_Time>
	<Provider>
		<Role>SP</Role>
		<Practice_Number>SKSP_3540</Practice_Number>
	</Provider>");
	$query115 = "select primarydiag, primaryicdcode from consultation_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number";	
	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>".$icd_name."</Code_Type>
			<Code>".$icd_code."</Code>
		</Diagnosis>");
		}
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	$fileData1 = $fileData1.addslashes("
	<Encounter_Type>Pharmacy</Encounter_Type>
	<Code_Type>Mcode</Code_Type>
	<Code>".$visitcode."</Code>
	<Code_Description>".$consultationtype."</Code_Description>
	<Quantity>1</Quantity>
	<Total_Amount>".-$copayfixedamount."</Total_Amount>
	<Reason></Reason>
	</Service>");

}


}

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
//$labrate = $res200['labitemrate'];
$cashcopay = $res200['cash_copay'];

$labrate = $labrate/$labquantity;
$copaylab = ($labrate/100)*$res17planpercentage;
				
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
	<Service>
	<Number>".$sno."</Number>
	<Invoice_Number>".$billautonumber."</Invoice_Number>
	<Global_Invoice_Nr>0</Global_Invoice_Nr>
	<Start_Date>".$claimdate."</Start_Date>
	<Start_Time>".$claimtime."</Start_Time>
	<Provider>
		<Role>SP</Role>
		<Practice_Number>SKSP_3540</Practice_Number>
	</Provider>");
	$query115 = "select primarydiag, primaryicdcode from consultation_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number";	
	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>".$icd_name."</Code_Type>
			<Code>".$icd_code."</Code>
		</Diagnosis>");
		}
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	$fileData1 = $fileData1.addslashes("
	<Encounter_Type>Laboratory</Encounter_Type>
	<Code_Type>Mcode</Code_Type>
	<Code>".$labcode."</Code>
	<Code_Description>".$labname."</Code_Description>
	<Quantity>".$labquantity."</Quantity>
	<Total_Amount>".$labrate."</Total_Amount>
	<Reason></Reason>
	</Service>");

 if($cashcopay>0){
	$sno = $sno + 1;
	$fileData1 = $fileData1.addslashes("
		<Service>
		<Number>".$sno."</Number>
		<Invoice_Number>".$billautonumber."</Invoice_Number>
		<Global_Invoice_Nr>0</Global_Invoice_Nr>
		<Start_Date>".$claimdate."</Start_Date>
		<Start_Time>".$claimtime."</Start_Time>
		<Provider>
			<Role>SP</Role>
			<Practice_Number>SKSP_3540</Practice_Number>
		</Provider>");
	$query115 = "select primarydiag, primaryicdcode from consultation_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number";	
	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>".$icd_name."</Code_Type>
			<Code>".$icd_code."</Code>
		</Diagnosis>");
		}
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	$fileData1 = $fileData1.addslashes("
		<Encounter_Type>Laboratory</Encounter_Type>
		<Code_Type>Mcode</Code_Type>
		<Code>".$labcode."</Code>
		<Code_Description>".$labname." - CASH COPAY</Code_Description>
		<Quantity>".$labquantity."</Quantity>
		<Total_Amount>".-$cashcopay."</Total_Amount>
		<Reason></Reason>
		</Service>");
 }

  if($planforall=='yes'){
	$sno = $sno + 1;
	$fileData1 = $fileData1.addslashes("
		<Service>
		<Number>".$sno."</Number>
		<Invoice_Number>".$billautonumber."</Invoice_Number>
		<Global_Invoice_Nr>0</Global_Invoice_Nr>
		<Start_Date>".$claimdate."</Start_Date>
		<Start_Time>".$claimtime."</Start_Time>
		<Provider>
			<Role>SP</Role>
			<Practice_Number>SKSP_3540</Practice_Number>
		</Provider>");
	$query115 = "select primarydiag, primaryicdcode from consultation_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number";	
	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>".$icd_name."</Code_Type>
			<Code>".$icd_code."</Code>
		</Diagnosis>");
		}
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	$fileData1 = $fileData1.addslashes("
		<Encounter_Type>Laboratory</Encounter_Type>
		<Code_Type>Mcode</Code_Type>
		<Code>".$labcode."</Code>
		<Code_Description>".$labname." - COPAY</Code_Description>
		<Quantity>".$labquantity."</Quantity>
		<Total_Amount>".-$copaylab."</Total_Amount>
		<Reason></Reason>
		</Service>");
 }

}	

$query18 = "select labfxamount from billing_patientweivers where visitcode='$visitcode' and patientcode='$patientcode'";
$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res18 = mysqli_fetch_array($exec18))
{
$copayfixedamount = $res18['labfxamount'];
$res18total = $copayfixedamount/1;

if($copayfixedamount>0){

$sno = $sno + 1;
$consultationtype="LABORATORY DISCOUNT";

$fileData1 = $fileData1.addslashes("
	<Service>
	<Number>".$sno."</Number>
	<Invoice_Number>".$billautonumber."</Invoice_Number>
	<Global_Invoice_Nr>0</Global_Invoice_Nr>
	<Start_Date>".$claimdate."</Start_Date>
	<Start_Time>".$claimtime."</Start_Time>
	<Provider>
		<Role>SP</Role>
		<Practice_Number>SKSP_3540</Practice_Number>
	</Provider>");
	$query115 = "select primarydiag, primaryicdcode from consultation_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number";	
	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>".$icd_name."</Code_Type>
			<Code>".$icd_code."</Code>
		</Diagnosis>");
		}
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	$fileData1 = $fileData1.addslashes("
	<Encounter_Type>Laboratory</Encounter_Type>
	<Code_Type>Mcode</Code_Type>
	<Code>".$visitcode."</Code>
	<Code_Description>".$consultationtype."</Code_Description>
	<Quantity>1</Quantity>
	<Total_Amount>".-$copayfixedamount."</Total_Amount>
	<Reason></Reason>
	</Service>");

}


}

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
			
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
	<Service>
	<Number>".$sno."</Number>
	<Invoice_Number>".$billautonumber."</Invoice_Number>
	<Global_Invoice_Nr>0</Global_Invoice_Nr>
	<Start_Date>".$claimdate."</Start_Date>
	<Start_Time>".$claimtime."</Start_Time>
	<Provider>
		<Role>SP</Role>
		<Practice_Number>SKSP_3540</Practice_Number>
	</Provider>");
	$query115 = "select primarydiag, primaryicdcode from consultation_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number";	
	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>".$icd_name."</Code_Type>
			<Code>".$icd_code."</Code>
		</Diagnosis>");
		}
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	$fileData1 = $fileData1.addslashes("
	<Encounter_Type>Radiology</Encounter_Type>
	<Code_Type>Mcode</Code_Type>
	<Code>".$radiologycode."</Code>
	<Code_Description>".$radiologyname."</Code_Description>
	<Quantity>".$radiologyquantity."</Quantity>
	<Total_Amount>".$radiologyrate."</Total_Amount>
	<Reason></Reason>
	</Service>");

if($cashcopay>0){
	$sno = $sno + 1;
				
	$fileData1 = $fileData1.addslashes("
		<Service>
		<Number>".$sno."</Number>
		<Invoice_Number>".$billautonumber."</Invoice_Number>
		<Global_Invoice_Nr>0</Global_Invoice_Nr>
		<Start_Date>".$claimdate."</Start_Date>
		<Start_Time>".$claimtime."</Start_Time>
		<Provider>
			<Role>SP</Role>
			<Practice_Number>SKSP_3540</Practice_Number>
		</Provider>");
		$query115 = "select primarydiag, primaryicdcode from consultation_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number";	
		$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>".$icd_name."</Code_Type>
			<Code>".$icd_code."</Code>
		</Diagnosis>");
		}
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
		$fileData1 = $fileData1.addslashes("
		<Encounter_Type>Radiology</Encounter_Type>
		<Code_Type>Mcode</Code_Type>
		<Code>".$radiologycode."</Code>
		<Code_Description>".$radiologyname." - CASH COPAY</Code_Description>
		<Quantity>".$radiologyquantity."</Quantity>
		<Total_Amount>".$cashcopay."</Total_Amount>
		<Reason></Reason>
		</Service>");
	 }


 if($planforall=='yes'){
	$sno = $sno + 1;
				
	$fileData1 = $fileData1.addslashes("
		<Service>
		<Number>".$sno."</Number>
		<Invoice_Number>".$billautonumber."</Invoice_Number>
		<Global_Invoice_Nr>0</Global_Invoice_Nr>
		<Start_Date>".$claimdate."</Start_Date>
		<Start_Time>".$claimtime."</Start_Time>
		<Provider>
			<Role>SP</Role>
			<Practice_Number>SKSP_3540</Practice_Number>
		</Provider>");
		$query115 = "select primarydiag, primaryicdcode from consultation_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number";	
		$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>".$icd_name."</Code_Type>
			<Code>".$icd_code."</Code>
		</Diagnosis>");
		}
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
		$fileData1 = $fileData1.addslashes("
		<Encounter_Type>Radiology</Encounter_Type>
		<Code_Type>Mcode</Code_Type>
		<Code>".$radiologycode."</Code>
		<Code_Description>".$radiologyname." - COPAY</Code_Description>
		<Quantity>".$radiologyquantity."</Quantity>
		<Total_Amount>".$copayrad."</Total_Amount>
		<Reason></Reason>
		</Service>");
	 }
}	

$query18 = "select radiologyfxamount from billing_patientweivers where visitcode='$visitcode' and patientcode='$patientcode'";
$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res18 = mysqli_fetch_array($exec18))
{
$copayfixedamount = $res18['radiologyfxamount'];
$res18total = $copayfixedamount/1;

if($copayfixedamount>0){

$sno = $sno + 1;
$consultationtype="RADIOLOGY DISCOUNT";

$fileData1 = $fileData1.addslashes("
	<Service>
	<Number>".$sno."</Number>
	<Invoice_Number>".$billautonumber."</Invoice_Number>
	<Global_Invoice_Nr>0</Global_Invoice_Nr>
	<Start_Date>".$claimdate."</Start_Date>
	<Start_Time>".$claimtime."</Start_Time>
	<Provider>
		<Role>SP</Role>
		<Practice_Number>SKSP_3540</Practice_Number>
	</Provider>");
	$query115 = "select primarydiag, primaryicdcode from consultation_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number";	
	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>".$icd_name."</Code_Type>
			<Code>".$icd_code."</Code>
		</Diagnosis>");
		}
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	$fileData1 = $fileData1.addslashes("
	<Encounter_Type>Radiology</Encounter_Type>
	<Code_Type>Mcode</Code_Type>
	<Code>".$visitcode."</Code>
	<Code_Description>".$consultationtype."</Code_Description>
	<Quantity>1</Quantity>
	<Total_Amount>".-$copayfixedamount."</Total_Amount>
	<Reason></Reason>
	</Service>");

}


}


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
$copayser = ($serviceitemrate*$servicesquantity/100)*$res17planpercentage;
			
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
	<Service>
	<Number>".$sno."</Number>
	<Invoice_Number>".$billautonumber."</Invoice_Number>
	<Global_Invoice_Nr>0</Global_Invoice_Nr>
	<Start_Date>".$claimdate."</Start_Date>
	<Start_Time>".$claimtime."</Start_Time>
	<Provider>
		<Role>SP</Role>
		<Practice_Number>SKSP_3540</Practice_Number>
	</Provider>");
	$query115 = "select primarydiag, primaryicdcode from consultation_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number";	
	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>".$icd_name."</Code_Type>
			<Code>".$icd_code."</Code>
		</Diagnosis>");
		}
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	$fileData1 = $fileData1.addslashes("
	<Encounter_Type>Services</Encounter_Type>
	<Code_Type>Mcode</Code_Type>
	<Code>".$servicescode."</Code>
	<Code_Description>".$servicesname."</Code_Description>
	<Quantity>".$servicesquantity."</Quantity>
	<Total_Amount>".$servicesamount."</Total_Amount>
	<Reason></Reason>
	</Service>");

if($cashcopay>0){
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
	<Service>
	<Number>".$sno."</Number>
	<Invoice_Number>".$billautonumber."</Invoice_Number>
	<Global_Invoice_Nr>0</Global_Invoice_Nr>
	<Start_Date>".$claimdate."</Start_Date>
	<Start_Time>".$claimtime."</Start_Time>
	<Provider>
		<Role>SP</Role>
		<Practice_Number>SKSP_3540</Practice_Number>
	</Provider>");
	$query115 = "select primarydiag, primaryicdcode from consultation_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number";	
	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>".$icd_name."</Code_Type>
			<Code>".$icd_code."</Code>
		</Diagnosis>");
		}
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	$fileData1 = $fileData1.addslashes("
	<Encounter_Type>Services</Encounter_Type>
	<Code_Type>Mcode</Code_Type>
	<Code>".$servicescode."</Code>
	<Code_Description>".$servicesname." - CASH COPAY</Code_Description>
	<Quantity>".$servicesquantity."</Quantity>
	<Total_Amount>".-$cashcopay."</Total_Amount>
	<Reason></Reason>
	</Service>");

}

if($planforall=='yes'){
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
	<Service>
	<Number>".$sno."</Number>
	<Invoice_Number>".$billautonumber."</Invoice_Number>
	<Global_Invoice_Nr>0</Global_Invoice_Nr>
	<Start_Date>".$claimdate."</Start_Date>
	<Start_Time>".$claimtime."</Start_Time>
	<Provider>
		<Role>SP</Role>
		<Practice_Number>SKSP_3540</Practice_Number>
	</Provider>");
	$query115 = "select primarydiag, primaryicdcode from consultation_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number";	
	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>".$icd_name."</Code_Type>
			<Code>".$icd_code."</Code>
		</Diagnosis>");
		}
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	$fileData1 = $fileData1.addslashes("
	<Encounter_Type>Services</Encounter_Type>
	<Code_Type>Mcode</Code_Type>
	<Code>".$servicescode."</Code>
	<Code_Description>".$servicesname." - COPAY</Code_Description>
	<Quantity>".$servicesquantity."</Quantity>
	<Total_Amount>".-$copayser."</Total_Amount>
	<Reason></Reason>
	</Service>");

}


}	

$query18 = "select servicesfxamount from billing_patientweivers where visitcode='$visitcode' and patientcode='$patientcode'";
$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res18 = mysqli_fetch_array($exec18))
{
$copayfixedamount = $res18['servicesfxamount'];
$res18total = $copayfixedamount/1;

if($copayfixedamount>0){

$sno = $sno + 1;
$consultationtype="SERVICES DISCOUNT";

$fileData1 = $fileData1.addslashes("
	<Service>
	<Number>".$sno."</Number>
	<Invoice_Number>".$billautonumber."</Invoice_Number>
	<Global_Invoice_Nr>0</Global_Invoice_Nr>
	<Start_Date>".$claimdate."</Start_Date>
	<Start_Time>".$claimtime."</Start_Time>
	<Provider>
		<Role>SP</Role>
		<Practice_Number>SKSP_3540</Practice_Number>
	</Provider>");
	$query115 = "select primarydiag, primaryicdcode from consultation_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number";	
	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>".$icd_name."</Code_Type>
			<Code>".$icd_code."</Code>
		</Diagnosis>");
		}
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	$fileData1 = $fileData1.addslashes("
	<Encounter_Type>Services</Encounter_Type>
	<Code_Type>Mcode</Code_Type>
	<Code>".$visitcode."</Code>
	<Code_Description>".$consultationtype."</Code_Description>
	<Quantity>1</Quantity>
	<Total_Amount>".-$copayfixedamount."</Total_Amount>
	<Reason></Reason>
	</Service>");

}


}

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
			
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
	<Service>
	<Number>".$sno."</Number>
	<Invoice_Number>".$billautonumber."</Invoice_Number>
	<Global_Invoice_Nr>0</Global_Invoice_Nr>
	<Start_Date>".$claimdate."</Start_Date>
	<Start_Time>".$claimtime."</Start_Time>
	<Provider>
		<Role>SP</Role>
		<Practice_Number>SKSP_3540</Practice_Number>
	</Provider>");
	$query115 = "select primarydiag, primaryicdcode from consultation_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number";	
	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>".$icd_name."</Code_Type>
			<Code>".$icd_code."</Code>
		</Diagnosis>");
		}
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	$fileData1 = $fileData1.addslashes("
	<Encounter_Type>Referal</Encounter_Type>
	<Code_Type>Mcode</Code_Type>
	<Code>".$referalcode."</Code>
	<Code_Description>".$referalname."</Code_Description>
	<Quantity>".$referalquantity."</Quantity>
	<Total_Amount>".$referalamount."</Total_Amount>
	<Reason></Reason>
	</Service>");


if($planforall=='yes'){
$sno = $sno + 1;

$fileData1 = $fileData1.addslashes("
	<Service>
	<Number>".$sno."</Number>
	<Invoice_Number>".$billautonumber."</Invoice_Number>
	<Global_Invoice_Nr>0</Global_Invoice_Nr>
	<Start_Date>".$claimdate."</Start_Date>
	<Start_Time>".$claimtime."</Start_Time>
	<Provider>
		<Role>SP</Role>
		<Practice_Number>SKSP_3540</Practice_Number>
	</Provider>");
	$query115 = "select primarydiag, primaryicdcode from consultation_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number";	
	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>".$icd_name."</Code_Type>
			<Code>".$icd_code."</Code>
		</Diagnosis>");
		}
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	$fileData1 = $fileData1.addslashes("
	<Encounter_Type>Referal</Encounter_Type>
	<Code_Type>Mcode</Code_Type>
	<Code>".$referalcode."</Code>
	<Code_Description>".$referalname." - COPAY</Code_Description>
	<Quantity>".$referalquantity."</Quantity>
	<Total_Amount>".$copayref."</Total_Amount>
	<Reason></Reason>
	</Service>");

}

}	

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
$copayhom = (($homereferalrate*$homequantity)/100)*$res17planpercentage;
			
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
	<Service>
	<Number>".$sno."</Number>
	<Invoice_Number>".$billautonumber."</Invoice_Number>
	<Global_Invoice_Nr>0</Global_Invoice_Nr>
	<Start_Date>".$claimdate."</Start_Date>
	<Start_Time>".$claimtime."</Start_Time>
	<Provider>
		<Role>SP</Role>
		<Practice_Number>SKSP_3540</Practice_Number>
	</Provider>");
	$query115 = "select primarydiag, primaryicdcode from consultation_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number";	
	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>".$icd_name."</Code_Type>
			<Code>".$icd_code."</Code>
		</Diagnosis>");
		}
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	$fileData1 = $fileData1.addslashes("
	<Encounter_Type>Homecare</Encounter_Type>
	<Code_Type>Mcode</Code_Type>
	<Code>".$homedocno."</Code>
	<Code_Description>".$homename."</Code_Description>
	<Quantity>".$homequantity."</Quantity>
	<Total_Amount>".$homeamount."</Total_Amount>
	<Reason></Reason>
	</Service>");

if($planforall=='yes'){
$sno = $sno + 1;

$fileData1 = $fileData1.addslashes("
	<Service>
	<Number>".$sno."</Number>
	<Invoice_Number>".$billautonumber."</Invoice_Number>
	<Global_Invoice_Nr>0</Global_Invoice_Nr>
	<Start_Date>".$claimdate."</Start_Date>
	<Start_Time>".$claimtime."</Start_Time>
	<Provider>
		<Role>SP</Role>
		<Practice_Number>SKSP_3540</Practice_Number>
	</Provider>");
	$query115 = "select primarydiag, primaryicdcode from consultation_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number";	
	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>".$icd_name."</Code_Type>
			<Code>".$icd_code."</Code>
		</Diagnosis>");
		}
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	$fileData1 = $fileData1.addslashes("
	<Encounter_Type>Homecare</Encounter_Type>
	<Code_Type>Mcode</Code_Type>
	<Code>".$homedocno."</Code>
	<Code_Description>".$homename." - COPAY</Code_Description>
	<Quantity>".$homequantity."</Quantity>
	<Total_Amount>".-$copayhom."</Total_Amount>
	<Reason></Reason>
	</Service>");

}
}	

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
$copayopamb = (($ambreferalrate*$ambquantity)/100)*$res17planpercentage;
			
$sno = $sno + 1;
				
$fileData1 = $fileData1.addslashes("
	<Service>
	<Number>".$sno."</Number>
	<Invoice_Number>".$billautonumber."</Invoice_Number>
	<Global_Invoice_Nr>0</Global_Invoice_Nr>
	<Start_Date>".$claimdate."</Start_Date>
	<Start_Time>".$claimtime."</Start_Time>
	<Provider>
		<Role>SP</Role>
		<Practice_Number>SKSP_3540</Practice_Number>
	</Provider>");
	$query115 = "select primarydiag, primaryicdcode from consultation_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number";	
	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>".$icd_name."</Code_Type>
			<Code>".$icd_code."</Code>
		</Diagnosis>");
		}
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	$fileData1 = $fileData1.addslashes("
	<Encounter_Type>Ambulance</Encounter_Type>
	<Code_Type>Mcode</Code_Type>
	<Code>".$ambdocno."</Code>
	<Code_Description>".$ambname."</Code_Description>
	<Quantity>".$ambquantity."</Quantity>
	<Total_Amount>".$ambamount."</Total_Amount>
	<Reason></Reason>
	</Service>");

if($planforall=='yes'){
$sno = $sno + 1;
$fileData1 = $fileData1.addslashes("
	<Service>
	<Number>".$sno."</Number>
	<Invoice_Number>".$billautonumber."</Invoice_Number>
	<Global_Invoice_Nr>0</Global_Invoice_Nr>
	<Start_Date>".$claimdate."</Start_Date>
	<Start_Time>".$claimtime."</Start_Time>
	<Provider>
		<Role>SP</Role>
		<Practice_Number>SKSP_3540</Practice_Number>
	</Provider>");
	$query115 = "select primarydiag, primaryicdcode from consultation_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number";	
	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>".$icd_name."</Code_Type>
			<Code>".$icd_code."</Code>
		</Diagnosis>");
		}
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	$fileData1 = $fileData1.addslashes("
	<Encounter_Type>Ambulance</Encounter_Type>
	<Code_Type>Mcode</Code_Type>
	<Code>".$ambdocno."</Code>
	<Code_Description>".$ambname." - COPAY</Code_Description>
	<Quantity>".$ambquantity."</Quantity>
	<Total_Amount>".-$copayopamb."</Total_Amount>
	<Reason></Reason>
	</Service>");
}
}	

$fileData1 = $fileData1.addslashes("
</Claim_Data>
</Claim>");

echo $importData = $fileData1;

$updatedate = date('Y-m-d H:i:s');
$InOut_Type = '1';

//include("writexmlsmart.php");

//header("location:billing_pending_op2.php?billautonumber=$billautonumber&&st=success&&printbill=$printbill");
exit;

}
?>
