<?php
session_start();

//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$updatedatetime1 = date('Y-m-d');
$cashamount=0;
$pharma_amount_final=0;
$pharma_check_final=0;
$lab_amount_final=0;
$rad_amount_final=0;
$ref_amount_final=0;
$serv_amount_final=0;
$cons_fee_final=0;
$i=0;
$docno=$_SESSION["docno"];

$query01="select locationcode,locationname from login_locationdetails where docno ='$docno' and username='$username' order by auto_number desc";
$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
$res01=mysqli_fetch_array($exc01);
$main_locationcode = $res01['locationcode'];
$locationcodeget = $res01['locationcode'];
$locationnameget  = $res01['locationname'];

$query018="select auto_number from master_location where locationcode='$main_locationcode'";
$exc018=mysqli_query($GLOBALS["___mysqli_ston"], $query018);
$res018=mysqli_fetch_array($exc018);
$location_auto = $res018['auto_number'];


$titlestr = 'SALES BILL';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
	  $visitcode=$_REQUEST["visitcode"];
	$patientcode = $_REQUEST["customercode"];
	$patientname = $_REQUEST["customername"];
	$consultationdate = date("Y-m-d");
	$accountname = $_REQUEST["account"];
  if(isset($_POST["Submit222"]) && $_POST["Submit222"]=='Approve'){
	  


	  
	  
	//get locationcode and locationname for inserting
//$locationcodeget=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';
//$locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
//get ends here

if (isset($_POST['adv_dep'])) 
{
//echo "checked!";
		for($i=0;$i<50;$i++)
		{
		if(isset($_POST['pharmacycheck'][$i]))
		{
			
		$pharmacyanum = $_POST['pharmacyanum'][$i];
		$pharmacyitemcode= $_POST['pharmacyitemcode'][$i];
		$pharma_amount= $_POST['pharma_amount'][$i];
		$pharmacyanumcheck = $pharmacyanum;
		
		if($pharmacyanum == $pharmacyanumcheck)
		{	
		
		if(($pharmacyanum!="")&&($pharmacyitemcode!=""))
		{
		
		$pharma_amount_final=$pharma_amount_final+$pharma_amount;
		$pharmacyquery1="update pharmacysalesreturn_details set adv_refundapprove='approved' where auto_number='$pharmacyanum' and visitcode='$visitcode'";
		$pharmacyquery2=mysqli_query($GLOBALS["___mysqli_ston"], $pharmacyquery1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		}
		}
		}
		
		for($i=0;$i<50;$i++)
	    {
		if(isset($_POST['_pharmacycheck'][$i]))
		{
		$pharmacyanum = $_POST['_pharmacyanum'][$i];
		$pharmacyitemcode= $_POST['_pharmacyitemcode'][$i];
		$pharmacy_check= $_POST['pharmacy_check'][$i];
		$pharmacyanumcheck = $pharmacyanum;
		
		if($pharmacyanum == $pharmacyanumcheck)
	    {	
			
		if(($pharmacyanum!="")&&($pharmacyitemcode!=""))
		{
			$pharma_check_final=$pharma_check_final+$pharmacy_check;
			
			$sqlchk="select request_id from master_item_refund where auto_number='$pharmacyanum' and visitcode='$visitcode'";
		   $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $sqlchk) or die ("Error in sqlchk".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
				$id=$res1["request_id"];
				if($id!=''){
				   $pharmacyquery1="update master_item_refund set adv_refundapprove='approved',approved_user='$username',approved_ip='$ipaddress',approved_date='$updatedatetime' where auto_number='$pharmacyanum' and visitcode='$visitcode'";
				   $pharmacyquery2=mysqli_query($GLOBALS["___mysqli_ston"], $pharmacyquery1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				}
			}
		}
		}
		}
		}
		
		for($i=0;$i<50;$i++)
		{
		if(isset($_POST['labcheck'][$i]))
		{
		$labanum = $_POST['labanum'][$i];
		$labitemcode= $_POST['labitemcode'][$i];
		$lab_amount= $_POST['lab_amount'][$i];
		$labanumcheck = $labanum;
		
		if($labanum == $labanumcheck)
	    {	
			
		if(($labanum!="")&&($labitemcode!=""))
		{
			$lab_amount_final=$lab_amount_final+$lab_amount;
$labquery1="update consultation_lab set adv_refundapprove='approved' where auto_number='$labanum' and patientvisitcode='$visitcode'";
$labquery1=mysqli_query($GLOBALS["___mysqli_ston"], $labquery1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		}
		}
		}
		}
		
		for($i=0;$i<50;$i++)
		{			
		if(isset($_POST['radcheck'][$i]))
		{ 
		$radanum = $_POST['radanum'][$i];
		$raditemcode= $_POST['raditemcode'][$i];
		$raditemrate= $_POST['raditemrate'][$i];
		$radanumcheck = $radanum;
		if($radanum == $radanumcheck)
	    {	
		
		if(($radanum!="")&&($raditemcode!=""))
		{
			$rad_amount_final=$rad_amount_final+$raditemrate;
			$radiologyquery1="update consultation_radiology set adv_refundapprove='approved',radiologyitemrate='$raditemrate' where auto_number='$radanum' and patientvisitcode='$visitcode'";
		$radiologyexecquery1=mysqli_query($GLOBALS["___mysqli_ston"], $radiologyquery1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		}
		}
		}
		}
		
		for($i=0;$i<50;$i++)
		{			
		if(isset($_POST['referalcheck'][$i]))
		{ 
		$radanum = $_POST['refanum'][$i];
		$raditemcode= $_POST['refitemcode'][$i];
		$ref_amount= $_POST['consref_amount'][$i];
		$radanumcheck = $radanum;
		if($radanum == $radanumcheck)
	    {	
		
		if(($radanum!="")&&($raditemcode!=""))
		{
			$ref_amount_final=$ref_amount_final+$ref_amount;
			
$radiologyquery1="update consultation_referal set adv_refundapprove='approved' where auto_number='$radanum' and patientvisitcode='$visitcode'";
$radiologyexecquery1=mysqli_query($GLOBALS["___mysqli_ston"], $radiologyquery1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		}
		}
		}
		}
		
		for($i=0;$i<50;$i++)
		{
		if(isset($_POST['servicescheck'][$i]))
		{ 
		$servicesanum = $_POST['servicesanum'][$i];
		$servicesitemcode= $_POST['servicesitemcode'][$i];
		$service_amount= $_POST['service_amount'][$i];
		$servicesanumcheck = $servicesanum;
		if($servicesanum == $servicesanumcheck)
	    {	
			
		if(($servicesanum!="")&&($servicesitemcode!=""))
		{
			$serv_amount_final=$serv_amount_final+$service_amount;
$servicesquery1="update consultation_services set adv_refundapprove='approved' where auto_number='$servicesanum' and patientvisitcode='$visitcode'";
$servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], $servicesquery1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		}
		}
		}
		}
		
		for($i=0;$i<50;$i++)
		{
			if(isset($_POST['masvis'][$i]))
			{ 
				if($_POST['masvis'][$i] == '1'){
				$p_code=$_REQUEST['masvispatientcode'.$i];
				$v_code=$_REQUEST['masvisvisitcode'.$i];
				$billnumber=$_REQUEST['masvisbill'.$i];
				$cons_fee=$_REQUEST['cons_fee'][$i];
				$cons_fee_final=$cons_fee_final+$cons_fee;
					$query76 = "select auto_number from master_billing where refund_status='requested' and  billnumber = '$billnumber' and visitcode = '$v_code' limit 0,1";
					$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res76 = mysqli_fetch_array($exec76))
					{
				
							$query81 = "update master_billing set adv_refundapprove='approved',refundapprovedby='$username',updatetime=updatetime  where billnumber = '$billnumber' and visitcode = '$v_code'";	
							$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
				
					}
				}
			}
		}
$cashamount=$pharma_amount_final+$pharma_check_final+$lab_amount_final+$rad_amount_final+$ref_amount_final+$serv_amount_final+$cons_fee_final;
	
$query3 = "select * from bill_formats where description = 'Advance Deposit'";

$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

$res3 = mysqli_fetch_array($exec3);

$paynowbillprefix = $res3['prefix'];

$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select * from master_transactionadvancedeposit order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["docno"];

$billdigit=strlen($billnumber);
if ($billnumber == '')
{

	$billnumbercode =$paynowbillprefix."-".'1'."-".date('y')."-".$location_auto;
    $openingbalance = '0.00';
}
else
{
$billnumber = $res2["docno"];
$maxcount=split("-",$billnumber);
$maxcount1=$maxcount[1];
$maxanum = $maxcount1+1;
$billnumbercode = $paynowbillprefix ."-".$maxanum."-".date('y')."-".$location_auto;	
}

		$transactiontype = 'PAYMENT';

		$transactionmode = 'CASH';

		$particulars = 'BY CASH';	

		$transactionmodule='PAYMENT';
		
		$accname=$accountname;
		
		$query55 = "select * from financialaccount where transactionmode = 'CASH'";

		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));

		 $res55 = mysqli_fetch_array($exec55);

		 $cashcode = $res55['ledgercode'];

		 

 $query9 = "insert into master_transactionadvancedeposit (transactiondate, particulars, transactionmode, transactiontype, transactionamount, cashamount,ipaddress, updatedate, companyanum, companyname, remarks, transactionmodule,patientname,patientcode,accountname,docno,username,coa,transactiontime,locationname,locationcode,cashcode) 
values ('$updatedatetime1', '$particulars', '$transactionmode', '$transactiontype', '$cashamount', '$cashamount', '$ipaddress', '$updatedatetime1', '$companyanum', '$companyname', 'From Cash Refund Approval', '$transactionmodule','$patientname','$patientcode','$accname','$billnumbercode','$username','',CURTIME(),'".$locationnameget."','".$locationcodeget."','$cashcode')";
$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
	

  $query37 = "insert into paymentmodedebit(billnumber,billdate,ipaddress,username,cash,cashcoa,patientname,patientcode,accountname,source,locationname,locationcode)values('$billnumbercode','$updatedatetime','$ipaddress','$username','$cashamount','','$patientname','$patientcode','$accname','advancedeposit','".$locationnameget."','".$locationcodeget."')";
$exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

header("location:cashrefundapprovallist.php");
exit;
		
}
  else
  {
	
	for($i=0;$i<50;$i++)
	 {
		if(isset($_POST['pharmacycheck'][$i]))
		{
		$pharmacyanum = $_POST['pharmacyanum'][$i];
		$pharmacyitemcode= $_POST['pharmacyitemcode'][$i];
		$pharmacyanumcheck = $pharmacyanum;
		
		if($pharmacyanum == $pharmacyanumcheck)
	    {	
			
		if(($pharmacyanum!="")&&($pharmacyitemcode!=""))
		{
		
		$pharmacyquery1="update pharmacysalesreturn_details set refundapprove='approved' where auto_number='$pharmacyanum' and visitcode='$visitcode'";
		$pharmacyquery2=mysqli_query($GLOBALS["___mysqli_ston"], $pharmacyquery1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		if (strpos($visitcode, 'IPV') !== false) {
		    // str exists
		    $query39=mysqli_query($GLOBALS["___mysqli_ston"], "update master_ipvisitentry set itemrefund='refund' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		else
		{
			
			$query39=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set itemrefund='refund' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		

		}
		}
		}
		}


		for($i=0;$i<50;$i++)
	    {
		if(isset($_POST['_pharmacycheck'][$i]))
		{
		$pharmacyanum = $_POST['_pharmacyanum'][$i];
		$pharmacyitemcode= $_POST['_pharmacyitemcode'][$i];
		$pharmacyanumcheck = $pharmacyanum;
		
		if($pharmacyanum == $pharmacyanumcheck)
	    {	
			
		if(($pharmacyanum!="")&&($pharmacyitemcode!=""))
		{
		   $sqlchk="select request_id from master_item_refund where auto_number='$pharmacyanum' and visitcode='$visitcode'";
		   $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $sqlchk) or die ("Error in sqlchk".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
				$id=$res1["request_id"];
				if($id!=''){
				   $pharmacyquery1="update master_item_refund set billstatus='approved',approved_user='$username',approved_ip='$ipaddress',approved_date='$updatedatetime' where auto_number='$pharmacyanum' and visitcode='$visitcode'";
				   $pharmacyquery2=mysqli_query($GLOBALS["___mysqli_ston"], $pharmacyquery1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				    $pharmacyquery1="update master_consultationpharm set refund='approved' where auto_number='$id' and patientvisitcode='$visitcode'";
				   $pharmacyquery2=mysqli_query($GLOBALS["___mysqli_ston"], $pharmacyquery1);

				   $pharmacyquery1="update master_consultationpharmissue set refund='approved' where auto_number='$id' and patientvisitcode='$visitcode'";
				   $pharmacyquery2=mysqli_query($GLOBALS["___mysqli_ston"], $pharmacyquery1);

				}
			}
		
		}
		}
		}
		}
       
	
		for($i=0;$i<50;$i++)
					{
		if(isset($_POST['labcheck'][$i]))
		{
		$labanum = $_POST['labanum'][$i];
		$labitemcode= $_POST['labitemcode'][$i];
		$labanumcheck = $labanum;
		
		if($labanum == $labanumcheck)
	    {	
			
		if(($labanum!="")&&($labitemcode!=""))
		{
		
		$labquery1="update consultation_lab set refundapproval='approved' where auto_number='$labanum' and patientvisitcode='$visitcode'";
		$labquery1=mysqli_query($GLOBALS["___mysqli_ston"], $labquery1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query39=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set itemrefund='refund' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		}
		}
		}
		}
		for($i=0;$i<50;$i++)
		{			
		if(isset($_POST['radcheck'][$i]))
		{ 
		$radanum = $_POST['radanum'][$i];
		$raditemcode= $_POST['raditemcode'][$i];
		$raditemrate= $_POST['raditemrate'][$i];
		$radanumcheck = $radanum;
		if($radanum == $radanumcheck)
	    {	
		
		if(($radanum!="")&&($raditemcode!=""))
		{
		$radiologyquery1="update consultation_radiology set refundapprove='approved',radiologyitemrate='$raditemrate' where auto_number='$radanum' and patientvisitcode='$visitcode'";
		$radiologyexecquery1=mysqli_query($GLOBALS["___mysqli_ston"], $radiologyquery1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query39=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set itemrefund='refund' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		}
		}
		}
		}
		for($i=0;$i<50;$i++)
		{			
		if(isset($_POST['referalcheck'][$i]))
		{ 
		$radanum = $_POST['refanum'][$i];
		$raditemcode= $_POST['refitemcode'][$i];
		$radanumcheck = $radanum;
		if($radanum == $radanumcheck)
	    {	
		
		if(($radanum!="")&&($raditemcode!=""))
		{
		$radiologyquery1="update consultation_referal set refundapprove='approved' where auto_number='$radanum' and patientvisitcode='$visitcode'";
		$radiologyexecquery1=mysqli_query($GLOBALS["___mysqli_ston"], $radiologyquery1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query39=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set itemrefund='refund' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		}
		}
		}
		}
		for($i=0;$i<50;$i++)
		{
		if(isset($_POST['servicescheck'][$i]))
		{ 
		$servicesanum = $_POST['servicesanum'][$i];
		$servicesitemcode= $_POST['servicesitemcode'][$i];
		
		$servicesanumcheck = $servicesanum;
		if($servicesanum == $servicesanumcheck)
	    {	
			
		if(($servicesanum!="")&&($servicesitemcode!=""))
		{
		
		$servicesquery1="update consultation_services set refundapprove='approved' where auto_number='$servicesanum' and patientvisitcode='$visitcode'";
		$servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], $servicesquery1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query39=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set itemrefund='refund' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		
		}
		}
		}
		}
		for($i=0;$i<50;$i++)
		{
			if(isset($_POST['masvis'][$i]))
			{ 
				if($_POST['masvis'][$i] == '1'){
					$p_code=$_REQUEST['masvispatientcode'.$i];
					$v_code=$_REQUEST['masvisvisitcode'.$i];
					$billnumber=$_REQUEST['masvisbill'.$i];
					

					$query76 = "select auto_number from master_billing where refund_status='requested' and  billnumber = '$billnumber' and visitcode = '$v_code' limit 0,1";
					$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res76 = mysqli_fetch_array($exec76))
					{
					//$query8 = "select auto_number from billing_paylater where patientcode = '$p_code' and visitcode = '$v_code'";	
					//$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
					//$rows8 = mysql_num_rows($exec8);
					//	if($rows8 == 0)
					//	{
							$query81 = "update master_billing set refund_status='approved',refundapprovedby='$username',updatetime=updatetime  where billnumber = '$billnumber' and visitcode = '$v_code'";	
							$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
							
					//	}
					}
					
				}
			}
		}

		header("location:cashrefundapprovallist.php");
		exit;
    }
  }
  else if(isset($_POST["submit"]) && $_POST["submit"]=='Discard'){

        for($i=0;$i<50;$i++)
	    {
		if(isset($_POST['_pharmacycheck'][$i]))
		{
		$pharmacyanum = $_POST['_pharmacyanum'][$i];
		$pharmacyitemcode= $_POST['_pharmacyitemcode'][$i];
		$pharmacyanumcheck = $pharmacyanum;
		
		if($pharmacyanum == $pharmacyanumcheck)
	    {	
			
		if(($pharmacyanum!="")&&($pharmacyitemcode!=""))
		{
		   $sqlchk="select request_id from master_item_refund where auto_number='$pharmacyanum' and visitcode='$visitcode'";
		   $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $sqlchk) or die ("Error in sqlchk".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
				$id=$res1["request_id"];
				if($id!=''){
				   $pharmacyquery1="update master_item_refund set billstatus='canceled',approved_user='$username',approved_ip='$ipaddress',approved_date='$updatedatetime' where auto_number='$pharmacyanum' and visitcode='$visitcode'";
				   $pharmacyquery2=mysqli_query($GLOBALS["___mysqli_ston"], $pharmacyquery1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				    $pharmacyquery1="update master_consultationpharm set refund='' where auto_number='$id' and patientvisitcode='$visitcode'";
				   $pharmacyquery2=mysqli_query($GLOBALS["___mysqli_ston"], $pharmacyquery1);

				   $pharmacyquery1="update master_consultationpharmissue set refund='' where auto_number='$id' and patientvisitcode='$visitcode'";
				   $pharmacyquery2=mysqli_query($GLOBALS["___mysqli_ston"], $pharmacyquery1);

				}
			}
		
		}
		}
		}
		}

		for($i=0;$i<50;$i++)
					{
		if(isset($_POST['labcheck'][$i]))
		{
		$labanum = $_POST['labanum'][$i];
		$labitemcode= $_POST['labitemcode'][$i];
		$labanumcheck = $labanum;
		
		if($labanum == $labanumcheck)
	    {	
			
		if(($labanum!="")&&($labitemcode!=""))
		{
		
		$chksql="select sampleid,labitemcode,docnumber from consultation_lab where auto_number='$labanum' and sampleid!=''";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $chksql) or die ("Error in chksql".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rows8 = mysqli_num_rows($exec1);
		if($rows8>0){
			while ($res1 = mysqli_fetch_array($exec1))
			{
			    $sampleid=$res1['sampleid'];
				$itemcode=$res1['labitemcode'];
				$docnumber=$res1['docnumber'];

				$labquery1="update consultation_lab set labrefund='norefund' where auto_number='$labanum' and patientvisitcode='$visitcode'";
				$labquery1=mysqli_query($GLOBALS["___mysqli_ston"], $labquery1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				$query29=mysqli_query($GLOBALS["___mysqli_ston"], "update samplecollection_lab set refund='norefund' where itemcode='$itemcode' and patientvisitcode='$visitcode' and sampleid='$sampleid' and docnumber='$docnumber'") or die("error in query".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}else{
			$labquery1="update consultation_lab set labsamplecoll='pending',labrefund='norefund' where auto_number='$labanum' and patientvisitcode='$visitcode'";
			$labquery1=mysqli_query($GLOBALS["___mysqli_ston"], $labquery1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		}
		
		
		}
		}
		}
		}

		for($i=0;$i<50;$i++)
		{			
			if(isset($_POST['radcheck'][$i]))
			{ 
			$radanum = $_POST['radanum'][$i];
			$raditemcode= $_POST['raditemcode'][$i];
			$raditemrate= $_POST['raditemrate'][$i];
			$radanumcheck = $radanum;
			if($radanum == $radanumcheck)
			{	
			
			if(($radanum!="")&&($raditemcode!=""))
			{
				$rsltstatus='pending';
                $prestatus='pending';
				$chksql="select aquisition_datetime,reporting_datetime from consultation_radiology where auto_number='$radanum'";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $chksql) or die ("Error in chksql".mysqli_error($GLOBALS["___mysqli_ston"]));
				$rows8 = mysqli_num_rows($exec1);
				if($rows8>0){
					while ($res1 = mysqli_fetch_array($exec1))
					{
                      $aquisition_datetime=$res1['aquisition_datetime'];
					  $reporting_datetime=$res1['reporting_datetime'];

					  if($aquisition_datetime=='0000-00-00 00:00:00')
						  $prestatus='pending';
					  else
						  $prestatus='completed';

					  if($reporting_datetime=='0000-00-00 00:00:00')
						  $rsltstatus='pending';
					  else
						  $rsltstatus='completed';

					}
				}
			

			$radiologyquery1="update consultation_radiology set resultentry='$rsltstatus',prepstatus='$prestatus',radiologyrefund='' where auto_number='$radanum' and patientvisitcode='$visitcode'";
			$radiologyexecquery1=mysqli_query($GLOBALS["___mysqli_ston"], $radiologyquery1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			}
			}
			}
		}

		for($i=0;$i<50;$i++)
		{
			if(isset($_POST['servicescheck'][$i]))
			{ 
			$servicesanum = $_POST['servicesanum'][$i];
			$servicesitemcode= $_POST['servicesitemcode'][$i];
			
			$servicesanumcheck = $servicesanum;
			if($servicesanum == $servicesanumcheck)
			{	
				
			if(($servicesanum!="")&&($servicesitemcode!=""))
			{
				$processstatus="pending";
			    /*$chksql="select processedby from consultation_services where auto_number='$servicesanum'";
				$exec1 = mysql_query($chksql) or die ("Error in chksql".mysql_error());
				$rows8 = mysql_num_rows($exec1);
				if($rows8>0){
					while ($res1 = mysql_fetch_array($exec1))
					{
                      $processedby=$res1['processedby'];
					  if($processedby!='')
						  $processstatus="completed";
					}
				}*/
             
				
			$servicesquery1="update consultation_services set process='$processstatus',servicerefund='',refundquantity='0' where auto_number='$servicesanum' and patientvisitcode='$visitcode'";
			$servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], $servicesquery1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			
		
			}
			}
			}
		}
  }

  header("location:cashrefundapprovallist.php");
  exit;

}

if(isset($_REQUEST["patientcode"]))
{
$patientcode=$_REQUEST["patientcode"];
$visitcode=$_REQUEST["visitcode"];
}
if(isset($_REQUEST["billno"]))
 $billno=$_REQUEST["billno"];
else
  $billno='';

$billnumber='';
if(isset($_REQUEST["billnumber"]))
{
$billnumber=$_REQUEST["billnumber"];
}
  
?>

<?php
$query78="select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec78=mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res78=mysqli_fetch_array($exec78);
$patientage=$res78['age'];
$patientgender=$res78['gender'];

$res111paymenttype = $res78['paymenttype'];
 $locationcodeget=$res78['locationcode'];
$query33 = "select locationname from master_location where locationcode='".$locationcodeget."'";
$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res33 = mysqli_fetch_array($exec33);
 $locationnameget = $res33['locationname'];


$query121 = "select * from master_paymenttype where auto_number = '$res111paymenttype'";
$exec121 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die (mysqli_error($GLOBALS["___mysqli_ston"]));
$res121 = mysqli_fetch_array($exec121);
$res121paymenttype = $res121['paymenttype'];
?>
<?php
$querylab1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab1=mysqli_fetch_array($querylab1);
$patientname=$execlab1['customerfullname'];
$patientaccount=$execlab1['accountname'];
$billtype=$execlab1['billtype'];
$mobilenumber=$execlab1['mobilenumber'];
$kinname=$execlab1['kinname'];
$kincontactnumber=$execlab1['kincontactnumber'];

$querylab2=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number='$patientaccount'");
$execlab2=mysqli_fetch_array($querylab2);
$patientaccount1=$execlab2['accountname'];

?>
<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.style1 {
	font-size: 36px;
	font-weight: bold;
}
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
input.largerCheckbox { 
            width: 20px; 
            height: 20px; 
        } 
</style>
<script src="jquery/jquery-1.11.3.min.js"></script>
<script type="text/javascript">
function checkAlert(){
	if($('#frmsales').find('input[type=checkbox]:checked').length ==0)
    {
		 alert('Please select atleast an item');
		return false;
	}
	if($('#frmsales').find('input[type=checkbox]:checked').length ==1 && document.getElementById("adv_dep").checked == true)
    {
        alert('Please select atleast an item');
		return false;
    }
	var retVal = confirm("Are you sure you want to save this entry?");
	if( retVal == true ) {
      return true;
	} else {
	  return false;
	}
  
}
function checkdiscardAlert(){
	if($('#frmsales').find('input[type=checkbox]:checked').length == 0)
    {
        alert('Please select atleast an item');
		return false;
    }
	if(document.getElementById("adv_dep").checked == true)
	{
	}
	var retVal = confirm("Are you sure you want to discard this entry?");
	if( retVal == true ) {
      return true;
	} else {
	  return false;
	}
}


function validatenumerics(key) {
   var keycode = (key.which) ? key.which : key.keyCode;
   if (keycode > 31 && (keycode < 48 || keycode > 57)) {
	   return false;
   }
   else return true;
}

function funcamountcalc(sno)
{

	if(document.getElementById("raditemorgrate"+sno).value != '')
	{
		var orgrate = document.getElementById("raditemorgrate"+sno).value;
		var rate = document.getElementById("raditemrate"+sno).value;
		if(parseFloat(rate) > parseFloat(orgrate)) {
		  alert ("Refund should be less than  rate.");
		  document.getElementById("raditemrate"+sno).value ='';
		  document.getElementById("rate"+sno).innerHTML=orgrate;
		  return false;
		}else{
			document.getElementById("rate"+sno).innerHTML=document.getElementById("raditemrate"+sno).value;
		}
		
	}
}
function checkvalid(sno){
	
	//var check = $(this).prop("checked");
	var check = document.getElementById("masvis"+sno).checked
	
	if(check == true){
		//$('#masvis'+sno).val(1);
		document.getElementById('masvis'+sno).value = '1';
	}
	else{
		document.getElementById('masvis'+sno).value = '0';
	}
	
}

</script>


</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body>
<form name="form1" id="frmsales" method="post" action="cashrefundapproval.php" onKeyDown="return disableEnterKey(event)">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
<!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="980" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr>
				  <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Cash Refund Approval</strong></td>
				  </tr>	
				  <tr>
				  <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  </tr>			
			  <tr>
			    <td width="15%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient </strong></td>
                <td width="36%" align="left" valign="middle" class="bodytext3">
				<input name="customername" id="customer" type="hidden" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/><?php echo $patientname; ?>
                  </td>
                 <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient code </strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3">
				<input name="customercode" id="customercode" type="hidden" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientcode; ?>
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
             
			    </tr>
			   <tr>
			    <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
			    <td align="left" valign="middle" class="bodytext3">
				<input type="hidden" name="patientage" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientage; ?>
				&
				<input type="hidden" name="patientgender" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientgender; ?>
				<input type="hidden" name="address1" id="address1" value="<?php echo $res41address1; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;" size="30" />
			      <span class="style4"><!--Area--> </span>
			      <input type="hidden" name="area" id="area" value="<?php echo $res41area; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="10" />
				  </td>
				    <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3">
				<input name="account" id="account" type="hidden" value="<?php echo $patientaccount1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientaccount1; ?>
				
				  </tr>
				  <tr>
				  <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code</strong></td>
                <td colspan="1" align="left" valign="middle" class="bodytext3">
				<input name="visitcode" id="visitcode" type="hidden" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $visitcode; ?>
				<input type="hidden" name="billtype" id="billtypes" value="<?php echo $billtype; ?>">
			 <input type="hidden" name="paymenttype" id="payment" value="<?php echo $res121paymenttype; ?>" readonly   size="20" />		
				   <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Location</strong></td>
                <td colspan="1" align="left" valign="middle" class="bodytext3" ><?php echo $locationnameget?></td>
                <input type="hidden" name="locationcodeget" value="<?php echo $locationcodeget?>">
				<input type="hidden" name="locationnameget" value="<?php echo $locationnameget?>">
                  </tr>
                  
                   <tr>
			    <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Mobile</strong></td>
			    <td align="left" valign="middle" class="bodytext3"><?php echo $mobilenumber?></td>
				    <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Next of Kin</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $kinname?></td>
				
				
				  </tr>
                  
<tr>
<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Next of Kin Mobile</strong></td>
<td align="left" valign="middle" class="bodytext3"><?php echo $kincontactnumber?></td></td>
<td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"></td>
<td colspan="3" align="left" valign="middle" class="bodytext3"></td>


</tr>
				  <tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  </tr>
            </tbody>
        </table></td>
      </tr>
      
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
		  <?php 
		  $sno = '';
			//$query76 = "select * from master_visitentry where paymentstatus='completed' and consultationrefund='torefundrequest' and doctorfeesstatus = '' and visitcode='$visitcode' and patientcode='$patientcode' ";

			$query76 = "select * from master_billing where  visitcode='$visitcode' and patientcode='$patientcode' and billnumber='$billnumber' and refund_status='requested'";

			$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num76 = mysqli_num_rows($exec76);
		  if($num76 > 0)
		  {			
	  ?>
            <tr>
              <td class="bodytext31" valign="center"  align="left"  bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				 <td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>OP Date </strong></div></td>
				<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>
				<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Visit Code  </strong></div></td>
              <td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient </strong></div></td>
                <td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Account</strong></div></td>      
				<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Department</strong></div></td>
				<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Fee</strong></div></td>
                <td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Remarks</strong></div></td>
                <td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Action</strong></div></td>
              </tr>			
			<?php 
			}
			while($res76 = mysqli_fetch_array($exec76))
			{		  
				$patientcode = $res76['patientcode'];
				$patientvisitcode=$res76['visitcode'];
				$consultationdate=$res76['consultationdate'];
				$patientname=$res76['patientfullname'];
				$accountname=$res76['accountname'];
				//$billtype = $res76['billtype'];
				$departmentname = $res76['department'];
				$consultationfees = $res76['patientbillamount'];
				$billnumber = $res76['billnumber'];
				$masvisnum = $res76['auto_number'];
				$remarks = $res76['refundremarks'];
		
?>
				<tr bgcolor="#CBDBFA" >
					<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
					<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo date('d/m/Y',strtotime($consultationdate)); ?></div></td>
					<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $patientcode; ?></div></td>
					<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $patientvisitcode; ?></div></td>
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>
					<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $accountname; ?></div></td>		  
					<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $departmentname; ?></div></td>
					<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo number_format($consultationfees,2); ?></div></td>
					<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $remarks; ?></div></td>
					<td class="bodytext31" valign="center"  align="left"><div align="center">
					<input type = "hidden" name="masvispatientcode<?php echo $sno; ?>" id = "masvispatientcode<?php echo $sno; ?>" value="<?php echo $patientcode; ?>" >
					<input type = "hidden" name="masvisbill<?php echo $sno; ?>" id = "masvisbill<?php echo $sno; ?>" value="<?php echo $billnumber; ?>" >
					<input type = "hidden" name="masvisvisitcode<?php echo $sno; ?>" id = "masvisvisitcode<?php echo $sno; ?>" value="<?php echo $patientvisitcode; ?>" >
                    <input type = "hidden" name="cons_fee[<?php echo $sno; ?>]" id = "cons_fee<?php echo $sno; ?>" value="<?php echo $consultationfees; ?>" >
					<input type="checkbox" name="masvis[<?php echo $sno; ?>]" id= "masvis<?php echo $sno?>"  onclick = "checkvalid('<?php echo $sno; ?>')"value="0">
					</div></td>
				</tr>
	<?php
			}
			
		  ?>
		    <?php
		  $query20num = "select * from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and billstatus='pending' and refundapprove='' and adv_refundapprove=''";
		  $exec20num = mysqli_query($GLOBALS["___mysqli_ston"], $query20num) or die ("Error in query19num".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num20num = mysqli_num_rows($exec20num);
		  if($num20num > 0)
		  {
		  ?>
		   <tr>
				  <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  </tr>	
		  <tr>
				  <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Pharmacy</strong></td>
				  </tr>	
            <tr>
              <td width="16%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Code </strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Pharmacy</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate  </strong></div></td>
					<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>
					<td width="1%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Remarks </strong></td>
				<td width="28%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Select </strong></div></td>
              
                  </tr>
				  		<?php
						}
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;
		
			$query20 = "select * from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and billstatus='pending' and refundapprove='' and adv_refundapprove=''";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res20 = mysqli_fetch_array($exec20))
			{
			
			$pharmacyitemname=$res20['itemname'];
			$pharmacyitemcode=$res20['itemcode'];
			$pharmacyitemrate=$res20['rate'];
			$pharmacyitemqty=$res20['quantity'];
			$remarks=$res20['remarks'];

			$pharmacyitemamount=$pharmacyitemrate*$pharmacyitemqty;
			$pharmacyanum=$res20['auto_number'];

			$querya1 = "select fxamount from billing_paynowpharmacy where patientvisitcode='$visitcode' and patientcode='$patientcode' and medicinecode='$pharmacyitemcode'";
			$execa1 = mysqli_query($GLOBALS["___mysqli_ston"], $querya1) or die ("Error in querya1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($resa1 = mysqli_fetch_array($execa1))
			{
			//$pharmacyitemamount=$resa1['fxamount'];
			}
			
		
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
			
			?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			 <input type="hidden" name="pharmacyanum[<?php echo $sno; ?>]" value="<?php echo $pharmacyanum; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmacyitemcode; ?></div></td>
			 <input type="hidden" name="pharmacyitemcode[<?php echo $sno; ?>]" value="<?php echo $pharmacyitemcode; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmacyitemname; ?></div></td>
			 <input type="hidden" name="pharmacyitemname[<?php echo $sno; ?>]" value="<?php echo $pharmacyitemname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmacyitemrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmacyitemamount; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $remarks; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center">
              <input type="hidden" name="pharma_amount[<?php echo $sno; ?>]" id="pharma_amount<?php echo $sno; ?>" value="<?php echo $pharmacyitemamount;?>"/>
             <input type="checkbox" name="pharmacycheck[<?php echo $sno; ?>]" value="<?php echo $pharmacyanum; ?>"></div></td>
				
				</tr>
			<?php } ?>
			</table>

          
			


            <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
		    <?php
		  $query19num = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='completed' and (freestatus='' or freestatus='NO') and refundapproval='' and labrefund='refund' and adv_refundapprove=''";
		  $exec19num = mysqli_query($GLOBALS["___mysqli_ston"], $query19num) or die ("Error in query19num".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num19num = mysqli_num_rows($exec19num);
		  if($num19num > 0)
		  {
			  
		  ?>
		   <tr>
				  <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  </tr>	
		  <tr>
				  <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Lab</strong></td>
				  </tr>	
            <tr>
              <td width="16%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Code </strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Lab</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate  </strong></div></td>
					<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>
					<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Remarks </strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Select </strong></div></td>
              
                  </tr>
				  		<?php
						}
			$colorloopcount = '';
			
			$totalamount=0;
		
			$query19 = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='completed' and (freestatus='' or freestatus='NO') and refundapproval='' and labrefund='refund' and adv_refundapprove=''";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res19 = mysqli_fetch_array($exec19))
			{
			
			$labitemname=$res19['labitemname'];
			$labitemcode=$res19['labitemcode'];
			$labitemrate=$res19['labitemrate'];
			$labanum=$res19['auto_number'];
			$labremarks=$res19['remarks'];
			
			$querya1 = "select fxamount from billing_paynowlab where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemcode='$labitemcode'";
			$execa1 = mysqli_query($GLOBALS["___mysqli_ston"], $querya1) or die ("Error in querya1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($resa1 = mysqli_fetch_array($execa1))
			{
			
			$labitemrate=$resa1['fxamount'];
			}
		
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
			
			?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			 <input type="hidden" name="labanum[<?php echo $sno; ?>]" value="<?php echo $labanum; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labitemcode; ?></div></td>
			 <input type="hidden" name="labitemcode[<?php echo $sno; ?>]" value="<?php echo $labitemcode; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labitemname; ?></div></td>
			 <input type="hidden" name="labitemname[<?php echo $sno; ?>]" value="<?php echo $labitemname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labitemrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labitemrate; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labremarks; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center">
            <input type="hidden" name="lab_amount[<?php echo $sno; ?>]" id="lab_amount<?php echo $sno; ?>" value="<?php echo $labitemrate; ?>">
           
             <input type="checkbox" name="labcheck[<?php echo $sno; ?>]" value="<?php echo $labanum; ?>"></div></td>
				
				</tr>
			<?php } ?>

		  <?php
		  $query17num = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='completed' and radiologyrefund='refund' and refundapprove='' and adv_refundapprove=''";
		  $exec17num = mysqli_query($GLOBALS["___mysqli_ston"], $query17num) or die ("Error in query17num".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num17numrad = mysqli_num_rows($exec17num);
		  if($num17numrad > 0)
		  {
		  ?>
		   <tr>
				  <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  </tr>	
		  <tr>
				  <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Radiology</strong></td>
				  </tr>	
            <tr>
              <td width="16%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Code </strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Radiology</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate  </strong></div></td>
					<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>
					<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Remarks</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Select </strong></div></td>
              
                  </tr>
				  		<?php
						}
			$colorloopcount = '';
			
			$totalamount=0;
		
			$query17 = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='completed' and radiologyrefund='refund' and refundapprove='' and adv_refundapprove=''";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num18rad = mysqli_num_rows($exec17);
			while ($res17 = mysqli_fetch_array($exec17))
			{
			
			$paharmitemname=$res17['radiologyitemname'];
			$pharmitemcode=$res17['radiologyitemcode'];
			$pharmitemrate=$res17['radiologyitemrate'];
			$radanum=$res17['auto_number'];
			$radremarks=$res17['comments'];
			
			$querya1 = "select fxamount from billing_paynowradiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemcode='$pharmitemcode'";
			$execa1 = mysqli_query($GLOBALS["___mysqli_ston"], $querya1) or die ("Error in querya1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($resa1 = mysqli_fetch_array($execa1))
			{
			
			$pharmitemrate=$resa1['fxamount'];
			}
		
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
				$bg="#CBDBFA";
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ecf0f5"';
				$bg="#ecf0f5";
			}
			$totalamount=$totalamount+$pharmitemrate;
			$totalamount=number_format($totalamount,2);
			?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			 <input type="hidden" name="radanum[<?php echo $sno; ?>]" value="<?php echo $radanum; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemcode; ?></div></td>
			 <input type="hidden" name="raditemcode[<?php echo $sno; ?>]" value="<?php echo $pharmitemcode; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>
			 <input type="hidden" name="raditemname[<?php echo $sno; ?>]" value="<?php echo $paharmitemname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="hidden" name="raditemorgrate[<?php echo $sno; ?>]" id="raditemorgrate<?php echo $sno; ?>" value="<?php echo $pharmitemrate; ?>" size='10'><input type="text" name="raditemrate[<?php echo $sno; ?>]" id="raditemrate<?php echo $sno; ?>" value="<?php echo $pharmitemrate; ?>" size='10' onKeyPress="return validatenumerics(event);" onKeyUp="return funcamountcalc('<?php echo $sno; ?>')" style="background-color:<?php echo $bg; ?>;"></div></td>
	<td class="bodytext31" valign="center"  align="left"><div align="center" id='rate<?php echo $sno; ?>'><?php echo $pharmitemrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $radremarks; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center">
      
             <input type="checkbox" name="radcheck[<?php echo $sno; ?>]" value="<?php echo $radanum; ?>"></div></td>
				
				</tr>
			<?php } ?>

			<?php
		  $query17num = "select * from consultation_referal where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='completed' and referalrefund='refund' and refundapprove='' and adv_refundapprove=''";
		  $exec17num = mysqli_query($GLOBALS["___mysqli_ston"], $query17num) or die ("Error in query17num".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num17num = mysqli_num_rows($exec17num);
		  if($num17num > 0)
		  {
		  ?>
		   <tr>
				  <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  </tr>	
		  <tr>
				  <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Referal</strong></td>
				  </tr>	
            <tr>
              <td width="16%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Code </strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Referal</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate</strong></div></td>
					<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>
					<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Remarks</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Select</strong></div></td>
              
                  </tr>
				  		<?php
						}
			$colorloopcount = '';
			
			$totalamount=0;
		
			$query17 = "select * from consultation_referal where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='completed' and referalrefund='refund' and refundapprove='' and adv_refundapprove=''";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res17 = mysqli_fetch_array($exec17))
			{
			
			$paharmitemname=$res17['referalname'];
			$pharmitemcode=$res17['referalcode'];
			$pharmitemrate=$res17['referalrate'];
			$radanum=$res17['auto_number'];
			$radremarks=$res17['remarks'];
		
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
			$totalamount=$totalamount+$pharmitemrate;
			$totalamount=number_format($totalamount,2);
			?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			 <input type="hidden" name="refanum[<?php echo $sno; ?>]" value="<?php echo $radanum; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemcode; ?></div></td>
			 <input type="hidden" name="refitemcode[<?php echo $sno; ?>]" value="<?php echo $pharmitemcode; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>
			 <input type="hidden" name="refitemname[<?php echo $sno; ?>]" value="<?php echo $paharmitemname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $radremarks; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center">
              <input type="hidden" name="consref_amount[<?php echo $sno; ?>]" id="consref_amount<?php echo $sno; ?>" value="<?php echo $pharmitemrate; ?>">
             <input type="checkbox" name="referalcheck[<?php echo $sno; ?>]" value="<?php echo $radanum; ?>"></div></td>
				
				</tr>
			<?php } ?>


			  <?php
		  $query18num = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='completed' and servicerefund='refund' and refundapprove='' and adv_refundapprove=''";
		  $exec18num = mysqli_query($GLOBALS["___mysqli_ston"], $query18num) or die ("Error in query17num".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num18num = mysqli_num_rows($exec18num);
		  if($num18num > 0)
		  {
		  ?>
		   <tr>
				  <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  </tr>	
		  <tr>
				  <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Service</strong></td>
				  </tr>	
            <tr>
              <td width="16%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Code </strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Service</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate  </strong></div></td>
					<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>
					<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Remarks</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Select </strong></div></td>
              
                  </tr>
				  		<?php
						}
			$colorloopcount = '';
			
			$totalamount=0;
		
			$query18 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='completed' and servicerefund='refund' and refundapprove='' and adv_refundapprove=''";
			$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res18 = mysqli_fetch_array($exec18))
			{
			
			$servicesitemname=$res18['servicesitemname'];
			$servicesitemcode=$res18['servicesitemcode'];
			$servicesitemrate=$res18['servicesitemrate'];
			$servicesanum=$res18['auto_number'];
			$refundqty=$res18['refundquantity'];
			$serviceremarks=$res18['remarks'];

			$querya1 = "select fxamount,serviceqty from billing_paynowservices where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode='$servicesitemcode'";
			$execa1 = mysqli_query($GLOBALS["___mysqli_ston"], $querya1) or die ("Error in querya1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($resa1 = mysqli_fetch_array($execa1))
			{
				if($resa1['serviceqty']>0){
					$servicesitemrate=$resa1['fxamount']/$resa1['serviceqty'];
				}
			}
			
		$serviceamount=$refundqty*$servicesitemrate;

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
			
			?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			 <input type="hidden" name="servicesanum[<?php echo $sno; ?>]" value="<?php echo $servicesanum; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $servicesitemcode; ?></div></td>
			 <input type="hidden" name="servicesitemcode[<?php echo $sno; ?>]" value="<?php echo $servicesitemcode; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $servicesitemname; ?></div></td>
			 <input type="hidden" name="servicesitemname[<?php echo $sno; ?>]" value="<?php echo $servicesitemname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $servicesitemrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo number_format($serviceamount,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serviceremarks; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center">
              <input type="hidden" name="service_amount[<?php echo $sno; ?>]" id="service_amount<?php echo $sno; ?>" value="<?php echo $serviceamount; ?>">
             <input type="checkbox" name="servicescheck[<?php echo $sno; ?>]" value="<?php echo $servicesanum; ?>"></div></td>
				
				</tr>
			<?php } ?>

			<?php
			/// refund before issue the medicine

		  $query20num = "select * from master_item_refund where visitcode='$visitcode' and patientcode='$patientcode' and billstatus='requested' and approved_user='' and billnumber='$billno' and adv_refundapprove=''";
		  $exec20num = mysqli_query($GLOBALS["___mysqli_ston"], $query20num) or die ("Error in query19num".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num20num2 = mysqli_num_rows($exec20num);
		  if($num20num2 > 0)
		  {
		  ?>
		   <tr>
				  <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  </tr>	
		  <tr>
				  <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Pharmacy</strong></td>
				  </tr>	
            <tr>
              <td width="16%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Code </strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Pharmacy</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate  </strong></div></td>
					<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>
					<td width="1%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Remarks </strong></td>
				<td width="28%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Select </strong></div></td>
              
                  </tr>
				  		<?php
						}
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;
		
			
			
			while ($res20 = mysqli_fetch_array($exec20num))
			{
			
			$pharmacyitemname=$res20['itemname'];
			$pharmacyitemcode=$res20['itemcode'];
			$pharmacyitemrate=$res20['rate'];
			$pharmacyitemqty=$res20['quantity'];
			$remarks=$res20['remarks'];

			$pharmacyitemamount=$pharmacyitemrate*$pharmacyitemqty;
			$pharmacyanum=$res20['auto_number'];
			
		
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
			
			?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			 <input type="hidden" name="_pharmacyanum[<?php echo $sno; ?>]" value="<?php echo $pharmacyanum; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmacyitemcode; ?></div></td>
			 <input type="hidden" name="_pharmacyitemcode[<?php echo $sno; ?>]" value="<?php echo $pharmacyitemcode; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmacyitemname; ?></div></td>
			 <input type="hidden" name="_pharmacyitemname[<?php echo $sno; ?>]" value="<?php echo $pharmacyitemname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmacyitemrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmacyitemamount; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $remarks; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center">
              <input type="hidden" name="pharmacy_check[<?php echo $sno; ?>]" id="pharmacy_check<?php echo $sno; ?>" value="<?php echo $pharmacyitemamount; ?>">
             <input type="checkbox" name="_pharmacycheck[<?php echo $sno; ?>]" value="<?php echo $pharmacyanum; ?>"></div></td>
				
				</tr>
			<?php } ?>
			

			  <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
             </tr>
          
          </tbody>
        </table>		</td>
      </tr>
          
      <tr>
         
		 <td  align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
		  <input type="hidden" name="frm1submit1" value="frm1submit1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
		 <table width='100%' >
		   <tr>
         
		 <td  align="left" width="75%">
		  <?php if($num20num2 > 0 || $num19num>0 || $num17numrad>0 || $num18num>0)
		  { ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		   <input name="submit" type="submit" onClick="return checkdiscardAlert()"  value="Discard" class="button"/>
		   <?php } ?>
		 </td>
        
          <td  align="left"  width="75%"><label>Re-Use</label><input type="checkbox" class="largerCheckbox" name="adv_dep" id="adv_dep" value="" disabled /></td>
		 <td  align="right" >
		   <input name="Submit222" type="submit" onClick="return checkAlert()"  value="Approve" class="button"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		 </td>
		 </tr>
		         
                
				

		  </table>
		 </td>
      </tr>
	  </table>
      </td>
      </tr>
    
  </table>
</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>