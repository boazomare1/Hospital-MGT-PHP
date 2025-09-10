<?php

include("db/db_connect.php");



$fileData1 = '';



date_default_timezone_set('Africa/Nairobi'); 
if(isset($_REQUEST['authorization_id'])) { $authorization_id = $_REQUEST['authorization_id']; } else { $authorization_id = ''; }
if(isset($_REQUEST['amount'])) { $amount = $_REQUEST['amount']; } else { $amount = ''; }

if(isset($_REQUEST['type'])) { $type = $_REQUEST['type']; } else { $type = ''; }

if(isset($_REQUEST['claim'])) { $claim = $_REQUEST['claim']; } else { $claim = ''; }


if(isset($_REQUEST['billautonumber'])) { $billautonumber = $_REQUEST['billautonumber']; } else { $billautonumber = ''; }

if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST['visitcode']; } else { $visitcode = ''; }

if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST['patientcode']; } else { $patientcode = ''; }

if(isset($_REQUEST['printbill'])) { $printbill = $_REQUEST['printbill']; } else { $printbill = ''; }

if(isset($_REQUEST['loc'])) { $loc = $_REQUEST['loc']; } else { $loc = ''; }

if(isset($_REQUEST['frmflag1'])) { $frmflag1 = $_REQUEST['frmflag1']; } else { $frmflag1 = ''; }

if(isset($_REQUEST['slade'])) { $slade = $_REQUEST['slade']; } else { $slade = ''; }

if(isset($_REQUEST['offpatient'])) { $offpatient = $_REQUEST['offpatient']; } else { $offpatient = ''; }

if(isset($_REQUEST['split_status'])) { $split_status = $_REQUEST['split_status']; } else { $split_status = ''; }


if($frmflag1 == 'frmflag1')

{

$sno = 0;

$claimdate = date('Y-m-d');

$claimtime = date('H:i:s');



$query7 = "select * from master_ipvisitentry where visitcode = '$visitcode'";

$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));

$res7 = mysqli_fetch_array($exec7);

$smartbenefitno = $res7['smartbenefitno'];

$patientfirstname = $res7['patientfirstname'];

$patientmiddlename = $res7['patientmiddlename'];

$patientlastname = $res7['patientlastname'];

$consultationanum = $res7['consultationtype'];

$department = $res7['department'];

$consultationfees = $res7['admissionfees'];



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



$query8 = "select sum(totalamount+discount+((-1)*deposit)+((-1)*nhif)) as tot from billing_ip where visitcode = '$visitcode'";

$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));

$res8 = mysqli_fetch_array($exec8);

$paylateramount = $res8['tot'];



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

				<Group_Practice_Number>SKSP_2209</Group_Practice_Number>

				<Group_Practice_Name>RUAI FAMILY HOSPITAL</Group_Practice_Name>

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

				

/*$query11 = "select * from billing_paylaterconsultation where billno = '$billautonumber'";	

$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());

$res11 = mysql_fetch_array($exec11);

$consultationamount = $res11['totalamount'];		

*/

			

$query17 = "select admissionfees from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";

$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res17 = mysqli_fetch_array($exec17);

$consultationamount=$res17['admissionfees'];

	

$copayconsult = ($consultationamount/100)*$res17planpercentage;



$sno = $sno + 1;

$query2 = "select * from ip_bedallocation where  visitcode='$visitcode' and patientcode='$patientcode'";

		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$res2 = mysqli_fetch_array($exec2);

	
        $alloc_docno = $res2['docno'];				

$fileData1 = $fileData1.addslashes("

	<Service>

	<Number>".$sno."</Number>

	<Invoice_Number>".$billautonumber."</Invoice_Number>

	<Global_Invoice_Nr>0</Global_Invoice_Nr>

	<Start_Date>".$claimdate."</Start_Date>

	<Start_Time>".$claimtime."</Start_Time>

	<Provider>

		<Role>SP</Role>

		<Practice_Number>SKSP_2209</Practice_Number>

	</Provider>");

	$query115 = "select primarydiag, primaryicdcode from discharge_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode'";	

	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));

	$num23 = mysqli_num_rows($exec115);
    if($num23>0){
	$icd_code1=''; 
		   $icd_name1='';
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		if($icd_code1=='')
		{
		 $icd_code1= $icd_code; 
		 $icd_name1=$icd_name;
		}else
		{
		 $icd_code1= $icd_code1.','.$icd_code; 
		 $icd_name1=$icd_name1.','.$icd_name;
		}
	
		}
			$fileData1 = $fileData1.addslashes("
		<Diagnosis>
		<Stage>P</Stage>
			<Code_Type>ICD10</Code_Type>
			<Code>".$icd_code1."</Code>
			<Description>".$icd_name1."</Description>
		</Diagnosis>");

	}else{

        $fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}

	$fileData1 = $fileData1.addslashes("

	<Encounter_Type>ADMISSION</Encounter_Type>

	<Code_Type>".$alloc_docno."</Code_Type>

	<Code>ADMISSION</Code>

	<Code_Description>Admission Charge </Code_Description>

	<Quantity>1</Quantity>

	<Total_Amount>".$consultationamount."</Total_Amount>

	<Reason></Reason>

	</Service>");


/*
if($planforall=='yes'){ 



$sno = $sno + 1;

$consultationtype="ADMISSION COPAY";



$fileData1 = $fileData1.addslashes("

	<Service>

	<Number>".$sno."</Number>

	<Invoice_Number>".$billautonumber."</Invoice_Number>

	<Global_Invoice_Nr>0</Global_Invoice_Nr>

	<Start_Date>".$claimdate."</Start_Date>

	<Start_Time>".$claimtime."</Start_Time>

	<Provider>

		<Role>SP</Role>

		<Practice_Number>SKSP_2209</Practice_Number>

	</Provider>");

	$query115 = "select primarydiag, primaryicdcode from discharge_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode'";	

	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));

	
	$num23 = mysqli_num_rows($exec115);
	if($num23>0){
	$icd_code1=''; 
		   $icd_name1='';
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		if($icd_code1=='')
		{
		 $icd_code1= $icd_code; 
		 $icd_name1=$icd_name;
		}else
		{
		 $icd_code1= $icd_code1.','.$icd_code; 
		 $icd_name1=$icd_name1.','.$icd_name;
		}
	
		}
			$fileData1 = $fileData1.addslashes("
		<Diagnosis>
		<Stage>P</Stage>
			<Code_Type>ICD10</Code_Type>
			<Code>".$icd_code1."</Code>
			<Description>".$icd_name1."</Description>
		</Diagnosis>");
	}else{

	$fileData1 = $fileData1.addslashes("
	<Diagnosis>
		<Stage>P</Stage>
		<Code_Type>Examination and observation for other reasons</Code_Type>
		<Code>Z04</Code>
	</Diagnosis>");

	}

	$fileData1 = $fileData1.addslashes("

	<Encounter_Type>ADMISSION</Encounter_Type>

	<Code_Type>".$department."</Code_Type>

	<Code>COPAY</Code>

	<Code_Description>Admission Charge COPAY</Code_Description>

	<Quantity>1</Quantity>

	<Total_Amount>".-$copayconsult."</Total_Amount>

	<Reason></Reason>

	</Service>");

	

} */



$query17p = "select package, packagecharge from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";

$exec17p = mysqli_query($GLOBALS["___mysqli_ston"], $query17p) or die ("Error in Query17p".mysqli_error($GLOBALS["___mysqli_ston"]));

$res17p = mysqli_fetch_array($exec17p);

$packageanum1 = $res17p['package'];

$packageamount = $res17p['packagecharge'];

if($packageanum1 != 0)

{	

	$query741 = "select * from master_ippackage where auto_number='$packageanum1'";

	$exec741 = mysqli_query($GLOBALS["___mysqli_ston"], $query741) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

	$res741 = mysqli_fetch_array($exec741);

	$packdays1 = $res741['days'];

	$packagename = $res741['packagename'];

	$packagecode = $res741['servicescode'];

	$packagecode = substr($packagecode,0,9);

	

	$sno = $sno + 1;

	$consultationtype=$packagename;

	

	$fileData1 = $fileData1.addslashes("

		<Service>

		<Number>".$sno."</Number>

		<Invoice_Number>".$billautonumber."</Invoice_Number>

		<Global_Invoice_Nr>0</Global_Invoice_Nr>

		<Start_Date>".$claimdate."</Start_Date>

		<Start_Time>".$claimtime."</Start_Time>

		<Provider>

			<Role>SP</Role>

			<Practice_Number>SKSP_2209</Practice_Number>

		</Provider>");

		$query115 = "select primarydiag, primaryicdcode from discharge_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode'";	

		$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		$icd_code1=''; 
		   $icd_name1='';
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		if($icd_code1=='')
		{
		 $icd_code1= $icd_code; 
		 $icd_name1=$icd_name;
		}else
		{
		 $icd_code1= $icd_code1.','.$icd_code; 
		 $icd_name1=$icd_name1.','.$icd_name;
		}
	
		}
			$fileData1 = $fileData1.addslashes("
		<Diagnosis>
		<Stage>P</Stage>
			<Code_Type>ICD10</Code_Type>
			<Code>".$icd_code1."</Code>
			<Description>".$icd_name1."</Description>
		</Diagnosis>");
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
		$fileData1 = $fileData1.addslashes("

		<Encounter_Type>Package</Encounter_Type>

		<Code_Type>Mcode</Code_Type>

		<Code>".$packagecode."</Code>

		<Code_Description>".$packagename."</Code_Description>

		<Quantity>1</Quantity>

		<Total_Amount>".$packageamount."</Total_Amount>

		<Reason></Reason>

		</Service>");

	

}



$query91 = "select auto_number,description,rate, quantity, recorddate, bed from billing_ipbedcharges where ward <> '0' and bed <> '0' and docno = '$billautonumber' and visitcode = '$visitcode'";

$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$num91 = mysqli_num_rows($exec91);

if($num91>0){

while($res91 = mysqli_fetch_array($exec91))

{
    $auto_number = $res91['auto_number'];
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

			<Service>

			<Number>".$sno."</Number>

			<Invoice_Number>".$billautonumber."</Invoice_Number>

			<Global_Invoice_Nr>0</Global_Invoice_Nr>

			<Start_Date>".$claimdate."</Start_Date>

			<Start_Time>".$claimtime."</Start_Time>

			<Provider>

				<Role>SP</Role>

				<Practice_Number>SKSP_2209</Practice_Number>

			</Provider>");

			$query115 = "select primarydiag, primaryicdcode from discharge_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode'";	

			$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));

			$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		$icd_code1=''; 
		   $icd_name1='';
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		if($icd_code1=='')
		{
		 $icd_code1= $icd_code; 
		 $icd_name1=$icd_name;
		}else
		{
		 $icd_code1= $icd_code1.','.$icd_code; 
		 $icd_name1=$icd_name1.','.$icd_name;
		}
	
		}
			$fileData1 = $fileData1.addslashes("
		<Diagnosis>
		<Stage>P</Stage>
			<Code_Type>ICD10</Code_Type>
			<Code>".$icd_code1."</Code>
			<Description>".$icd_name1."</Description>
		</Diagnosis>");
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
		if($charge!='Bed Charges')
		{
		  $bed=$bed.'/'.$auto_number;
		}
			$fileData1 = $fileData1.addslashes("

			<Encounter_Type>Bedcharges</Encounter_Type>

			<Code_Type>Mcode</Code_Type>

			<Code>BED-".$bed."</Code>

			<Code_Description>".$charge."</Code_Description>

			<Quantity>".$quantity."</Quantity>

			<Total_Amount>".$amount."</Total_Amount>

			<Reason></Reason>

			</Service>");

	}

}

}



$querya12 = "select * from billing_ippharmacy where patientvisitcode = '$visitcode' and pkg_status='NO' and medicinename <> 'DISPENSING'";	

$execa12 = mysqli_query($GLOBALS["___mysqli_ston"], $querya12) or die ("Error in Querya12".mysqli_error($GLOBALS["___mysqli_ston"]));

if(mysqli_num_rows($execa12)>0)

{

	

$query12 = "select * from billing_ippharmacy where patientvisitcode = '$visitcode' and pkg_status='NO' ";	

$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

while($res12 = mysqli_fetch_array($exec12))

{

$medicinecode = $res12['medicinecode'];	

$medicinecode_full = $res12['medicinecode'];	

//$medicinecode = substr($medicinecode,0,9);

$medicinename = $res12['medicinename'];

$medquantity = $res12['quantity'];	

$medrate = $res12['rate'];	

$medamount = $res12['amount'];	

if($medicinename == 'DISPENSING'){
$medicinecode = "DISP01";	
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

		<Practice_Number>SKSP_2209</Practice_Number>

	</Provider>");

	$query115 = "select primarydiag, primaryicdcode from discharge_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode'";	

	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));

	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		$icd_code1=''; 
		   $icd_name1='';
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		if($icd_code1=='')
		{
		 $icd_code1= $icd_code; 
		 $icd_name1=$icd_name;
		}else
		{
		 $icd_code1= $icd_code1.','.$icd_code; 
		 $icd_name1=$icd_name1.','.$icd_name;
		}
	
		}
			$fileData1 = $fileData1.addslashes("
		<Diagnosis>
		<Stage>P</Stage>
			<Code_Type>ICD10</Code_Type>
			<Code>".$icd_code1."</Code>
			<Description>".$icd_name1."</Description>
		</Diagnosis>");
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

	

}



}



$query13 = "select * from billing_iplab where patientvisitcode = '$visitcode' and pkg_status='NO' ";	

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

	<Service>

	<Number>".$sno."</Number>

	<Invoice_Number>".$billautonumber."</Invoice_Number>

	<Global_Invoice_Nr>0</Global_Invoice_Nr>

	<Start_Date>".$claimdate."</Start_Date>

	<Start_Time>".$claimtime."</Start_Time>

	<Provider>

		<Role>SP</Role>

		<Practice_Number>SKSP_2209</Practice_Number>

	</Provider>");

	$query115 = "select primarydiag, primaryicdcode from discharge_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode'";	

	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));

	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		$icd_code1=''; 
		   $icd_name1='';
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		if($icd_code1=='')
		{
		 $icd_code1= $icd_code; 
		 $icd_name1=$icd_name;
		}else
		{
		 $icd_code1= $icd_code1.','.$icd_code; 
		 $icd_name1=$icd_name1.','.$icd_name;
		}
	
		}
			$fileData1 = $fileData1.addslashes("
		<Diagnosis>
		<Stage>P</Stage>
			<Code_Type>ICD10</Code_Type>
			<Code>".$icd_code1."</Code>
			<Description>".$icd_name1."</Description>
		</Diagnosis>");
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

}	



$query14 = "select * from billing_ipradiology where patientvisitcode = '$visitcode' and pkg_status='NO' ";	

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

	<Service>

	<Number>".$sno."</Number>

	<Invoice_Number>".$billautonumber."</Invoice_Number>

	<Global_Invoice_Nr>0</Global_Invoice_Nr>

	<Start_Date>".$claimdate."</Start_Date>

	<Start_Time>".$claimtime."</Start_Time>

	<Provider>

		<Role>SP</Role>

		<Practice_Number>SKSP_2209</Practice_Number>

	</Provider>");

	$query115 = "select primarydiag, primaryicdcode from discharge_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode'";	

	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));

	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		$icd_code1=''; 
		   $icd_name1='';
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		if($icd_code1=='')
		{
		 $icd_code1= $icd_code; 
		 $icd_name1=$icd_name;
		}else
		{
		 $icd_code1= $icd_code1.','.$icd_code; 
		 $icd_name1=$icd_name1.','.$icd_name;
		}
	
		}
			$fileData1 = $fileData1.addslashes("
		<Diagnosis>
		<Stage>P</Stage>
			<Code_Type>ICD10</Code_Type>
			<Code>".$icd_code1."</Code>
			<Description>".$icd_name1."</Description>
		</Diagnosis>");
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

}	



$query15 = "select * from billing_ipservices where patientvisitcode = '$visitcode' and wellnessitem <> '1' and pkg_status='NO' ";	

$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));

while($res15 = mysqli_fetch_array($exec15))

{

$servicescode = $res15['servicesitemcode'];	

$servicescode_full = $res15['servicesitemcode'];	

$servicescode = substr($servicescode,0,9);

$servicesname = $res15['servicesitemname'];

$servicesquantity = 1;

$servicesquantity = number_format($servicesquantity,0,'.','');	

$servicesamount = $res15['servicesitemrate'];	

			

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

		<Practice_Number>SKSP_2209</Practice_Number>

	</Provider>");

	$query115 = "select primarydiag, primaryicdcode from discharge_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode'";	

	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));

	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		$icd_code1=''; 
		   $icd_name1='';
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		if($icd_code1=='')
		{
		 $icd_code1= $icd_code; 
		 $icd_name1=$icd_name;
		}else
		{
		 $icd_code1= $icd_code1.','.$icd_code; 
		 $icd_name1=$icd_name1.','.$icd_name;
		}
	
		}
			$fileData1 = $fileData1.addslashes("
		<Diagnosis>
		<Stage>P</Stage>
			<Code_Type>ICD10</Code_Type>
			<Code>".$icd_code1."</Code>
			<Description>".$icd_name1."</Description>
		</Diagnosis>");
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

	<Service>

	<Number>".$sno."</Number>

	<Invoice_Number>".$billautonumber."</Invoice_Number>

	<Global_Invoice_Nr>0</Global_Invoice_Nr>

	<Start_Date>".$claimdate."</Start_Date>

	<Start_Time>".$claimtime."</Start_Time>

	<Provider>

		<Role>SP</Role>

		<Practice_Number>SKSP_2209</Practice_Number>

	</Provider>");

	$query115 = "select primarydiag, primaryicdcode from discharge_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode'";	

	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));

	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		$icd_code1=''; 
		   $icd_name1='';
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		if($icd_code1=='')
		{
		 $icd_code1= $icd_code; 
		 $icd_name1=$icd_name;
		}else
		{
		 $icd_code1= $icd_code1.','.$icd_code; 
		 $icd_name1=$icd_name1.','.$icd_name;
		}
	
		}
			$fileData1 = $fileData1.addslashes("
		<Diagnosis>
		<Stage>P</Stage>
			<Code_Type>ICD10</Code_Type>
			<Code>".$icd_code1."</Code>
			<Description>".$icd_name1."</Description>
		</Diagnosis>");
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	$fileData1 = $fileData1.addslashes("

	<Encounter_Type>OT</Encounter_Type>

	<Code_Type>Mcode</Code_Type>

	<Code>".$referalcode."</Code>

	<Code_Description>".$referalname."</Code_Description>

	<Quantity>".$referalquantity."</Quantity>

	<Total_Amount>".$referalamount."</Total_Amount>

	<Reason></Reason>

	</Service>");



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

	<Service>

	<Number>".$sno."</Number>

	<Invoice_Number>".$billautonumber."</Invoice_Number>

	<Global_Invoice_Nr>0</Global_Invoice_Nr>

	<Start_Date>".$claimdate."</Start_Date>

	<Start_Time>".$claimtime."</Start_Time>

	<Provider>

		<Role>SP</Role>

		<Practice_Number>SKSP_2209</Practice_Number>

	</Provider>");

	$query115 = "select primarydiag, primaryicdcode from discharge_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode'";	

	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));

	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		$icd_code1=''; 
		   $icd_name1='';
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		if($icd_code1=='')
		{
		 $icd_code1= $icd_code; 
		 $icd_name1=$icd_name;
		}else
		{
		 $icd_code1= $icd_code1.','.$icd_code; 
		 $icd_name1=$icd_name1.','.$icd_name;
		}
	
		}
			$fileData1 = $fileData1.addslashes("
		<Diagnosis>
		<Stage>P</Stage>
			<Code_Type>ICD10</Code_Type>
			<Code>".$icd_code1."</Code>
			<Description>".$icd_name1."</Description>
		</Diagnosis>");
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	$fileData1 = $fileData1.addslashes("

	<Encounter_Type>Doctor</Encounter_Type>

	<Code_Type>Mcode</Code_Type>

	<Code>".$drdocno."</Code>

	<Code_Description>".$drname."</Code_Description>

	<Quantity>".$drquantity."</Quantity>

	<Total_Amount>".$dramount."</Total_Amount>

	<Reason></Reason>

	</Service>");

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

	<Service>

	<Number>".$sno."</Number>

	<Invoice_Number>".$billautonumber."</Invoice_Number>

	<Global_Invoice_Nr>0</Global_Invoice_Nr>

	<Start_Date>".$claimdate."</Start_Date>

	<Start_Time>".$claimtime."</Start_Time>

	<Provider>

		<Role>SP</Role>

		<Practice_Number>SKSP_2209</Practice_Number>

	</Provider>");

	$query115 = "select primarydiag, primaryicdcode from discharge_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode'";	

	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));

	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		$icd_code1=''; 
		   $icd_name1='';
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		if($icd_code1=='')
		{
		 $icd_code1= $icd_code; 
		 $icd_name1=$icd_name;
		}else
		{
		 $icd_code1= $icd_code1.','.$icd_code; 
		 $icd_name1=$icd_name1.','.$icd_name;
		}
	
		}
			$fileData1 = $fileData1.addslashes("
		<Diagnosis>
		<Stage>P</Stage>
			<Code_Type>ICD10</Code_Type>
			<Code>".$icd_code1."</Code>
			<Description>".$icd_name1."</Description>
		</Diagnosis>");
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

	<Service>

	<Number>".$sno."</Number>

	<Invoice_Number>".$billautonumber."</Invoice_Number>

	<Global_Invoice_Nr>0</Global_Invoice_Nr>

	<Start_Date>".$claimdate."</Start_Date>

	<Start_Time>".$claimtime."</Start_Time>

	<Provider>

		<Role>SP</Role>

		<Practice_Number>SKSP_2209</Practice_Number>

	</Provider>");

	$query115 = "select primarydiag, primaryicdcode from discharge_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode'";	

	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));

	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		$icd_code1=''; 
		   $icd_name1='';
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		if($icd_code1=='')
		{
		 $icd_code1= $icd_code; 
		 $icd_name1=$icd_name;
		}else
		{
		 $icd_code1= $icd_code1.','.$icd_code; 
		 $icd_name1=$icd_name1.','.$icd_name;
		}
	
		}
			$fileData1 = $fileData1.addslashes("
		<Diagnosis>
		<Stage>P</Stage>
			<Code_Type>ICD10</Code_Type>
			<Code>".$icd_code1."</Code>
			<Description>".$icd_name1."</Description>
		</Diagnosis>");
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

	<Service>

	<Number>".$sno."</Number>

	<Invoice_Number>".$billautonumber."</Invoice_Number>

	<Global_Invoice_Nr>0</Global_Invoice_Nr>

	<Start_Date>".$claimdate."</Start_Date>

	<Start_Time>".$claimtime."</Start_Time>

	<Provider>

		<Role>SP</Role>

		<Practice_Number>SKSP_2209</Practice_Number>

	</Provider>");

	$query115 = "select primarydiag, primaryicdcode from discharge_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode'";	

	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));

	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		$icd_code1=''; 
		   $icd_name1='';
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		if($icd_code1=='')
		{
		 $icd_code1= $icd_code; 
		 $icd_name1=$icd_name;
		}else
		{
		 $icd_code1= $icd_code1.','.$icd_code; 
		 $icd_name1=$icd_name1.','.$icd_name;
		}
	
		}
			$fileData1 = $fileData1.addslashes("
		<Diagnosis>
		<Stage>P</Stage>
			<Code_Type>ICD10</Code_Type>
			<Code>".$icd_code1."</Code>
			<Description>".$icd_name1."</Description>
		</Diagnosis>");
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	$fileData1 = $fileData1.addslashes("

	<Encounter_Type>Miscellaneous</Encounter_Type>

	<Code_Type>Mcode</Code_Type>

	<Code>".$miscdocno."</Code>

	<Code_Description>".$miscname."</Code_Description>

	<Quantity>".$miscquantity."</Quantity>

	<Total_Amount>".$miscamount."</Total_Amount>

	<Reason></Reason>

	</Service>");

}



$query21 = "select * from master_transactionipdeposit where visitcode = '$visitcode'";	

$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));

while($res21 = mysqli_fetch_array($exec21))

{

$depodocno = $res21['docno'];

//$depodocno = substr($depodocno,0,9);	

$deponame = 'IP Deposit';

$depoquantity = 1;	

$depoamount = $res21['transactionamount'];	

$deporeferalrate = $res21['transactionamount'];

			

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

		<Practice_Number>SKSP_2209</Practice_Number>

	</Provider>");

	$query115 = "select primarydiag, primaryicdcode from discharge_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode'";	

	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));

	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		$icd_code1=''; 
		   $icd_name1='';
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		if($icd_code1=='')
		{
		 $icd_code1= $icd_code; 
		 $icd_name1=$icd_name;
		}else
		{
		 $icd_code1= $icd_code1.','.$icd_code; 
		 $icd_name1=$icd_name1.','.$icd_name;
		}
	
		}
			$fileData1 = $fileData1.addslashes("
		<Diagnosis>
		<Stage>P</Stage>
			<Code_Type>ICD10</Code_Type>
			<Code>".$icd_code1."</Code>
			<Description>".$icd_name1."</Description>
		</Diagnosis>");
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	$fileData1 = $fileData1.addslashes("

	<Encounter_Type>Deposit</Encounter_Type>

	<Code_Type>Mcode</Code_Type>

	<Code>".$depodocno."</Code>

	<Code_Description>IP Deposit</Code_Description>

	<Quantity>1</Quantity>

	<Total_Amount>".-($depoamount)."</Total_Amount>

	<Reason></Reason>

	</Service>");

}



$query22 = "select * from master_transactionadvancedeposit where visitcode = '$visitcode' and recordstatus='adjusted'";

$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));

while($res22 = mysqli_fetch_array($exec22))

{

$depodocno = $res22['docno'];

//$depodocno = substr($depodocno,0,9);	

$deponame = 'Advance Deposit';

$depoquantity = 1;	

$depoamount = $res22['transactionamount'];	

$deporeferalrate = $res22['transactionamount'];

			

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

		<Practice_Number>SKSP_2209</Practice_Number>

	</Provider>");

	$query115 = "select primarydiag, primaryicdcode from discharge_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode'";	

	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));

	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		$icd_code1=''; 
		   $icd_name1='';
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		if($icd_code1=='')
		{
		 $icd_code1= $icd_code; 
		 $icd_name1=$icd_name;
		}else
		{
		 $icd_code1= $icd_code1.','.$icd_code; 
		 $icd_name1=$icd_name1.','.$icd_name;
		}
	
		}
			$fileData1 = $fileData1.addslashes("
		<Diagnosis>
		<Stage>P</Stage>
			<Code_Type>ICD10</Code_Type>
			<Code>".$icd_code1."</Code>
			<Description>".$icd_name1."</Description>
		</Diagnosis>");
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	$fileData1 = $fileData1.addslashes("

	<Encounter_Type>Advance Deposit</Encounter_Type>

	<Code_Type>Mcode</Code_Type>

	<Code>".$depodocno."</Code>

	<Code_Description>Advance Deposit</Code_Description>

	<Quantity>1</Quantity>

	<Total_Amount>".-($depoamount)."</Total_Amount>

	<Reason></Reason>

	</Service>");

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

	<Service>

	<Number>".$sno."</Number>

	<Invoice_Number>".$billautonumber."</Invoice_Number>

	<Global_Invoice_Nr>0</Global_Invoice_Nr>

	<Start_Date>".$claimdate."</Start_Date>

	<Start_Time>".$claimtime."</Start_Time>

	<Provider>

		<Role>SP</Role>

		<Practice_Number>SKSP_2209</Practice_Number>

	</Provider>");

	$query115 = "select primarydiag, primaryicdcode from discharge_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode'";	

	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));

	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		$icd_code1=''; 
		   $icd_name1='';
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		if($icd_code1=='')
		{
		 $icd_code1= $icd_code; 
		 $icd_name1=$icd_name;
		}else
		{
		 $icd_code1= $icd_code1.','.$icd_code; 
		 $icd_name1=$icd_name1.','.$icd_name;
		}
	
		}
			$fileData1 = $fileData1.addslashes("
		<Diagnosis>
		<Stage>P</Stage>
			<Code_Type>ICD10</Code_Type>
			<Code>".$icd_code1."</Code>
			<Description>".$icd_name1."</Description>
		</Diagnosis>");
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	$fileData1 = $fileData1.addslashes("

	<Encounter_Type>Deposit Refund</Encounter_Type>

	<Code_Type>Mcode</Code_Type>

	<Code>REFUND</Code>

	<Code_Description>Deposit Refund</Code_Description>

	<Quantity>1</Quantity>

	<Total_Amount>".$depoamount."</Total_Amount>

	<Reason></Reason>

	</Service>");

}	



$query24 = "select * from ip_nhifprocessing where patientvisitcode = '$visitcode'";

$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));

while($res24 = mysqli_fetch_array($exec24))

{

$nhifdocno = $res24['docno'];

//$nhifdocno = substr($nhifdocno,0,9);	

$nhifname = 'NHIF';

$nhifquantity = $res24['totaldays'];

$nhifamount = -1*$res24['nhifclaim'];	

$nhifreferalrate = $res24['nhifrebate'];

			

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

		<Practice_Number>SKSP_2209</Practice_Number>

	</Provider>");

	$query115 = "select primarydiag, primaryicdcode from discharge_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode'";	

	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));

	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		$icd_code1=''; 
		   $icd_name1='';
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		if($icd_code1=='')
		{
		 $icd_code1= $icd_code; 
		 $icd_name1=$icd_name;
		}else
		{
		 $icd_code1= $icd_code1.','.$icd_code; 
		 $icd_name1=$icd_name1.','.$icd_name;
		}
	
		}
			$fileData1 = $fileData1.addslashes("
		<Diagnosis>
		<Stage>P</Stage>
			<Code_Type>ICD10</Code_Type>
			<Code>".$icd_code1."</Code>
			<Description>".$icd_name1."</Description>
		</Diagnosis>");
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	$fileData1 = $fileData1.addslashes("

	<Encounter_Type>NHIF</Encounter_Type>

	<Code_Type>Mcode</Code_Type>

	<Code>".$nhifdocno."</Code>

	<Code_Description>NHIF</Code_Description>

	<Quantity>".$nhifquantity."</Quantity>

	<Total_Amount>".$nhifamount."</Total_Amount>

	<Reason></Reason>

	</Service>");

}	



$query25 = "select * from ip_discount where patientvisitcode = '$visitcode'";

$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));

while($res25 = mysqli_fetch_array($exec25))

{

$discdocno = $res25['docno'];

//$discdocno = substr($discdocno,0,9);	

$discname = $res25['description'];

$discquantity = '1';

$discrate = $res25['rate'];

$discamount = -1*($discrate * $discquantity);	

			

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

		<Practice_Number>SKSP_2209</Practice_Number>

	</Provider>");

	$query115 = "select primarydiag, primaryicdcode from discharge_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode'";	

	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));

	$num23 = mysqli_num_rows($exec115);
		if($num23>0){
		$icd_code1=''; 
		   $icd_name1='';
		while($res115 = mysqli_fetch_array($exec115))
		{
		$icd_name = $res115['primarydiag'];
		$icd_code = $res115['primaryicdcode'];
		$icd_code = substr($icd_code,0,6);	
		if($icd_code1=='')
		{
		 $icd_code1= $icd_code; 
		 $icd_name1=$icd_name;
		}else
		{
		 $icd_code1= $icd_code1.','.$icd_code; 
		 $icd_name1=$icd_name1.','.$icd_name;
		}
	
		}
			$fileData1 = $fileData1.addslashes("
		<Diagnosis>
		<Stage>P</Stage>
			<Code_Type>ICD10</Code_Type>
			<Code>".$icd_code1."</Code>
			<Description>".$icd_name1."</Description>
		</Diagnosis>");
		}else{

		$fileData1 = $fileData1.addslashes("
		<Diagnosis>
			<Stage>P</Stage>
			<Code_Type>Examination and observation for other reasons</Code_Type>
			<Code>Z04</Code>
		</Diagnosis>");

		}
	$fileData1 = $fileData1.addslashes("

	<Encounter_Type>Discount</Encounter_Type>

	<Code_Type>Mcode</Code_Type>

	<Code>".$discdocno."</Code>

	<Code_Description>".$discname."</Code_Description>

	<Quantity>".$discquantity."</Quantity>

	<Total_Amount>".$discamount."</Total_Amount>

	<Reason></Reason>

	</Service>");

}



$fileData1 = $fileData1.addslashes("

</Claim_Data>

</Claim>");



$importData = $fileData1;



$updatedate = date('Y-m-d H:i:s');

$InOut_Type = '2';


$query8 = "update billing_ip set orginalsmartxml='".addslashes($importData)."' where visitcode = '$visitcode' and billno='$billautonumber'";
$exec8 = @mysqli_query($GLOBALS["___mysqli_ston"], $query8);

include("writexmlsmart.php");


if(isset($_REQUEST['slade']) && isset($_REQUEST['claim']) && $_REQUEST['slade']=='yes'){
   $slade_claim_id=$_REQUEST['claim'];
   header("location:slade-balance.php?billautonumber=$billno&&st=success&&printbill=$printbill&&frmflag1=frmflag1&&patientcode=$patientcode&&visitcode=$visitcode&slade=yes&claim=$claim&authorization_id=$authorization_id&amount=$amount&type=ip");
   exit;
}else{
header("location:print_ipfinalinvoice1.php?patientcode=$patientcode&&visitcode=$visitcode&&billnumber=$billautonumber&&loc=$loc&&locationcode=$loc");

exit;

}


}

?>

