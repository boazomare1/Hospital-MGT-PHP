<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$financialyear = $_SESSION["financialyear"];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d'); 
$updatetime = date('H:i:s');
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$totalamount = '';
$query31 = "select fromyear,toyear from master_financialyear where status = 'Active' order by auto_number desc";
$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
$res31 = mysqli_fetch_array($exec31);
$finfromyear = $res31['fromyear'];
$fintoyear = $res31['toyear'];
 
$query1111 = "select * from master_employee where username = '$username'";
$exec1111 = mysqli_query($GLOBALS["___mysqli_ston"], $query1111) or die ("Error in Query1111".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1111 = mysqli_fetch_array($exec1111))
{
$locationnumber = $res1111["location"];
$query1112 = "select * from master_location where auto_number = '$locationnumber' and status<>'delete'";
$exec1112 = mysqli_query($GLOBALS["___mysqli_ston"], $query1112) or die ("Error in Query1112".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1112 = mysqli_fetch_array($exec1112))
{
 $locationname = $res1112["locationname"];    
 $locationcode = $res1112["locationcode"];
}
 }
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];
if ($frmflag2 == 'frmflag2')
{
        //get locationcode and locationname for inserting
 $locationcodeget=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';
 $locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
//get ends here
		$paymentmode = $_REQUEST['billtype'];
		$chequenumber = isset($_REQUEST['chequenumber'])?$_REQUEST['chequenumber']:'';
		$billdate = $_REQUEST['ADate1'];
		//$bankname = $_REQUEST['bankname'];
		//$billdate=$_REQUEST['billdate'];
		$remarks = $_REQUEST['remarks'];
		$accountname= $_REQUEST['accname'];
		$visitcode=$_REQUEST["visitcode"];
	$patientcode = $_REQUEST["patientcode"];
		
	//	$paymentamount = $_REQUEST['paymentamount'];
		$cashamount = isset($_REQUEST['cashamount'])?$_REQUEST['cashamount']:'';
		$creditamount = isset($_REQUEST['creditamount'])?$_REQUEST['creditamount']:'';
		$mpesanumber = isset($_REQUEST['mpesanumber'])?$_REQUEST['mpesanumber']:'';
		$chequeamount = isset($_REQUEST['chequeamount'])?$_REQUEST['chequeamount']:'';
		$chequenumber = isset($_REQUEST['chequenumber'])?$_REQUEST['chequenumber']:'';
		$chequedate = isset($_REQUEST['chequedate'])?$_REQUEST['chequedate']:'';
		$chequebank = isset($_REQUEST['chequebank'])?$_REQUEST['chequebank']:'';
		$cardamount = isset($_REQUEST['cardamount'])?$_REQUEST['cardamount']:'';
		$cardnumber = isset($_REQUEST['cardnumber'])?$_REQUEST['cardnumber']:'';
		$card = isset($_REQUEST['cardname'])?$_REQUEST['cardname']:'';
		$bankname1 = isset($_REQUEST['bankname1'])?$_REQUEST['bankname1']:'';
		$onlineamount = isset($_REQUEST['onlineamount'])?$_REQUEST['onlineamount']:'';
		$onlinenumber = isset($_REQUEST['onlinenumber'])?$_REQUEST['onlinenumber']:'';
		$totalamount = isset($_REQUEST['tdShowTotal'])?$_REQUEST['tdShowTotal']:'';
		$cashgivenbycustomer = isset($_REQUEST['cashgivenbycustomer'])?$_REQUEST['cashgivenbycustomer']:'';
		$cashgiventocustomer = isset($_REQUEST['cashgiventocustomer'])?$_REQUEST['cashgiventocustomer']:'';
		$billanum='';
		$query77 = "select * from master_visitentry where visitcode='$visitcode'";
		$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res77 = mysqli_fetch_array($exec77);
		$doctorname  = $res77['consultingdoctor'];
		
		
		$remarks = $_REQUEST['remarks'];
		$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'IPDF-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from master_transactionipdeposit where transactionmodule = 'PAYMENT' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode =$paynowbillprefix.'1'."-".date('y');
		$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;
	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $paynowbillprefix .$maxanum."-".date('y');
	$openingbalance = '0.00';
	//echo $companycode;
}
		$patientname = $_REQUEST['patientname'];
		$patientcode = $_REQUEST['patientcode'];
		$visitcode = $_REQUEST['visitcode'];
		$accname = $_REQUEST['accname'];
		$transactionmodule = 'PAYMENT';
		//$depositype= $_REQUEST['deposittype'];
		$depositype= 'new1';
		$cashcoa = $_REQUEST['cashcoa'];
		$chequecoa = $_REQUEST['chequecoa'];
		$cardcoa = $_REQUEST['cardcoa'];
		$mpesacoa = $_REQUEST['mpesacoa'];
		$onlinecoa = $_REQUEST['onlinecoa'];
		$ipdepositscoa = $_REQUEST['ipdepositscoa'];
		
		$comments = $_REQUEST['comments'];
		if($depositype == 'new1')
		{
			if ($paymentmode == 'CASH')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CASH';
		$particulars = 'BY CASH';	
		
		$query55 = "select * from financialaccount where transactionmode = 'CASH'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res55 = mysqli_fetch_array($exec55);
		 $cashcode = $res55['ledgercode'];
		 
		$query9 = "insert into master_transactionipdeposit (transactiondate, particulars, 
		transactionmode, transactiontype, transactionamount, cashamount,
		ipaddress, updatedate, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,docno,username,transactiontime,coa,locationname,locationcode,comments, cashcode) 
		values ('$updatedatetime', '$particulars', 
		'$transactionmode', '$transactiontype', '$cashamount', '$cashamount', 
		 '$ipaddress', '$updatedatetime', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$patientname','$patientcode','$visitcode','$accname','$billnumbercode','$username',CURTIME(),'$ipdepositscoa','".$locationnameget."','".$locationcodeget."','".$comments."','$cashcode')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodedebit(billnumber,billdate,ipaddress,username,cash,cashcoa,patientname,patientcode,patientvisitcode,accountname,source,locationname,locationcode)values('$billnumbercode','$updatedatetime','$ipaddress','$username','$cashamount','$cashcoa','$patientname','$patientcode','$visitcode','$accname','deposit','".$locationnameget."','".$locationcodeget."')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
			if ($paymentmode == 'ONLINE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'ONLINE';
		$particulars = 'BY ONLINE ';	
		
		$query55 = "select * from financialaccount where transactionmode = 'ONLINE'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res55 = mysqli_fetch_array($exec55);
		 $bankcode = $res55['ledgercode'];
		 
		$query9 = "insert into master_transactionipdeposit (patientname,patientcode,visitcode,transactiondate, particulars, 
		transactionmode, transactiontype,ipaddress, updatedate, companyanum, companyname, remarks, 
		transactionmodule,accountname,docno,transactionamount,onlineamount,chequenumber,bankname,username,transactiontime,coa,locationname,locationcode,comments,bankcode) 
		values ('$patientname','$patientcode','$visitcode','$updatedatetime', '$particulars', 
		'$transactionmode', '$transactiontype','$ipaddress', '$updatedatetime','$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$accname','$billnumbercode','$onlineamount','$onlineamount','$onlinenumber','$bankname','$username','$updatetime','$ipdepositscoa','".$locationnameget."','".$locationcodeget."','".$comments."','$bankcode')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodedebit(billnumber,billdate,ipaddress,username,online,onlinecoa,patientname,patientcode,patientvisitcode,accountname,source,locationname,locationcode)values('$billnumbercode','$updatedatetime','$ipaddress','$username','$onlineamount','$onlinecoa','$patientname','$patientcode','$visitcode','$accname','deposit','".$locationnameget."','".$locationcodeget."')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		if ($paymentmode == 'MPESA')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'MPESA';
		$particulars = 'BY MPESA ';	
		
		$query55 = "select * from financialaccount where transactionmode = 'MPESA'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res55 = mysqli_fetch_array($exec55);
		 $mpesacode = $res55['ledgercode'];
		
		$query9 = "insert into master_transactionipdeposit (patientname,patientcode,visitcode,transactiondate, particulars, 
		transactionmode, transactiontype,ipaddress, updatedate, companyanum, companyname, remarks, 
		transactionmodule,accountname,docno,transactionamount,creditamount,chequenumber,bankname,username,transactiontime,coa,locationname,locationcode,comments,mpesacode) 
		values ('$patientname','$patientcode','$visitcode','$updatedatetime', '$particulars', 
		'$transactionmode', '$transactiontype','$ipaddress', '$updatedatetime','$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$accname','$billnumbercode','$creditamount','$creditamount','$mpesanumber','$bankname','$username','$updatetime','$ipdepositscoa','".$locationnameget."','".$locationcodeget."','".$comments."','$mpesacode')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodedebit(billnumber,billdate,ipaddress,username,mpesa,mpesacoa,patientname,patientcode,patientvisitcode,accountname,source,locationname,locationcode)values('$billnumbercode','$updatedatetime','$ipaddress','$username','$creditamount','$mpesacoa','$patientname','$patientcode','$visitcode','$accname','deposit','".$locationnameget."','".$locationcodeget."')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		if ($paymentmode == 'CHEQUE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CHEQUE';
		$particulars = 'BY CHEQUE ';		
		
		$query55 = "select * from financialaccount where transactionmode = 'CHEQUE'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res55 = mysqli_fetch_array($exec55);
		 $bankcode = $res55['ledgercode'];
		 
	    $query9 = "insert into master_transactionipdeposit (patientname,patientcode,visitcode,transactiondate, particulars, 
		transactionmode, transactiontype,ipaddress, updatedate, companyanum, companyname, remarks, 
		transactionmodule,accountname,docno,transactionamount,chequeamount,chequenumber,chequedate,bankname,username,transactiontime,coa,locationname,locationcode,comments,bankcode) 
		values ('$patientname','$patientcode','$visitcode','$updatedatetime', '$particulars', 
		'$transactionmode', '$transactiontype','$ipaddress', '$updatedatetime','$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$accname','$billnumbercode','$chequeamount','$chequeamount','$chequenumber','$chequedate','$chequebank','$username','$updatetime','$ipdepositscoa','".$locationnameget."','".$locationcodeget."','".$comments."','$bankcode')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodedebit(billnumber,billdate,ipaddress,username,cheque,chequecoa,patientname,patientcode,patientvisitcode,accountname,source,locationname,locationcode)values('$billnumbercode','$updatedatetime','$ipaddress','$username','$chequeamount','$chequecoa','$patientname','$patientcode','$visitcode','$accname','deposit','".$locationnameget."','".$locationcodeget."')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		if ($paymentmode == 'CREDITCARD')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CREDITCARD';
		$particulars = 'BY CREDITCARD ';		
		
		$query55 = "select * from financialaccount where transactionmode = 'CREDITCARD'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res55 = mysqli_fetch_array($exec55);
		 $bankcode = $res55['ledgercode'];
	
	    $query9 = "insert into master_transactionipdeposit (patientname,patientcode,visitcode,transactiondate, particulars, 
		transactionmode, transactiontype,ipaddress, updatedate, companyanum, companyname, remarks, 
		transactionmodule,accountname,docno,transactionamount,cardamount,chequenumber,chequedate,bankname,username,transactiontime,coa,locationname,locationcode,comments,bankcode) 
		values ('$patientname','$patientcode','$visitcode','$updatedatetime', '$particulars', 
		'$transactionmode', '$transactiontype','$ipaddress', '$updatedatetime','$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$accname','$billnumbercode','$cardamount','$cardamount','$cardnumber','$chequedate','$bankname1','$username','$updatetime','$ipdepositscoa','".$locationnameget."','".$locationcodeget."','".$comments."','$bankcode')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodedebit(billnumber,billdate,ipaddress,username,card,cardcoa,patientname,patientcode,patientvisitcode,accountname,source,locationname,locationcode)values('$billnumbercode','$updatedatetime','$ipaddress','$username','$cardamount','$cardcoa','$patientname','$patientcode','$visitcode','$accname','deposit','".$locationnameget."','".$locationcodeget."')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		if ($paymentmode == 'SPLIT')
		{
			$adjustamount = $_REQUEST['adjustamount'];
			if (isset($_REQUEST["net_deposit_amt"])) 
			{ 
				$adv_dep_bal_amt = $_REQUEST["net_deposit_amt"]; 
			} 
			else 
			{ 
				$adv_dep_bal_amt = 0; 
			}
		$transactiontype = 'PAYMENT';
		$transactionmode = 'SPLIT';
		$particulars = 'BY SPLIT '.$billnumbercode.'';
		$bankcode = '';
		$cashcode ='';
		$mpesacode='';
		if($cashamount !='0.00')
		{
		$query55 = "select * from financialaccount where transactionmode = 'CASH'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res55 = mysqli_fetch_array($exec55);
		 $cashcode = $res55['ledgercode'];
		}
		if($creditamount !='0.00')
		{
		$query55 = "select * from financialaccount where transactionmode = 'MPESA'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res55 = mysqli_fetch_array($exec55);
		 $mpesacode = $res55['ledgercode'];
		}
		if($cardamount !='0.00')
		{
		$query55 = "select * from financialaccount where transactionmode = 'CREDITCARD'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res55 = mysqli_fetch_array($exec55);
		 $bankcode = $res55['ledgercode'];
		}	
		if($chequeamount !='0.00')
		{
		$query55 = "select * from financialaccount where transactionmode = 'CHEQUE'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res55 = mysqli_fetch_array($exec55);
		 $bankcode = $res55['ledgercode'];
		}
		if($onlineamount !='0.00')
		{
		$query55 = "select * from financialaccount where transactionmode = 'ONLINE'";
		 $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res55 = mysqli_fetch_array($exec55);
		 $bankcode = $res55['ledgercode'];
		}
		
		$query9 = "insert into master_transactionipdeposit (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount,
		cardamount, billnumber, billanum, 
		chequedate, bankname, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,creditcardname,creditcardnumber,creditcardbankname,paymenttype,subtype,transactiontime,cashamount,onlineamount,chequeamount,chequenumber,creditamount,onlinenumber,mpesanumber,locationname,locationcode,docno,bankcode,mpesacode,cashcode,adjustamount) 
		values ('$billdate', '$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount',
		'$cardamount','$billnumbercode',  '$billanum', 
		'$chequedate', '$chequebank', '$ipaddress', '".date('Y-m-d')."', '$balanceamount', '$companyanum', '$companyname', 
		'$remarks', '$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$card','$cardnumber','$bankname1','CASH','CASH',CURTIME(),'$cashamount','$onlineamount','$chequeamount','$chequenumber','$creditamount','$onlinenumber','$mpesanumber','".$locationnameget."','".$locationcodeget."','$billnumbercode','$bankcode','$mpesacode','$cashcode','$adjustamount')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,card,cardcoa,cash,cashcoa,cheque,chequecoa,online,onlinecoa,adjust,mpesa,mpesacoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$billdate','$ipaddress','$username','$cardamount','$cardcoa','$cashamount','$cashcoa','$chequeamount','$chequecoa','$onlineamount','$onlinecoa','$adjustamount','$creditamount','$mpesacoa','billingpaynow','".$locationnameget."','".$locationcodeget."')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        // Check if the patient has advance deposit amount
		 $query_dep = "select patientname,patientcode,sum(transactionamount) amt from master_transactionadvancedeposit where patientcode='$patientcode' group by patientcode";
		 $exec_dep = mysqli_query($GLOBALS["___mysqli_ston"], $query_dep) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		 $num_dep_rows = mysqli_num_rows($exec_dep);	
		 if($num_dep_rows)
		 {
			if($adjustamount > 0)
			{
				$query_adjust = "INSERT INTO `adjust_advdeposits` (`id`, `locationcode`, `patientcode`, `visitcode`, `billno`, `adjustamount`, `balamt`, `billdate`,`adjusttype`, `username`, `ipaddress`) VALUES (NULL, '$locationcodeget', '$patientcode', '$visitcode', '$billnumbercode', '$adjustamount', '$adv_dep_bal_amt', '$billdate','ipdeposit', '$username', '$ipaddress')";
				$exec_adjust = mysqli_query($GLOBALS["___mysqli_ston"], $query_adjust) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			}
	
	     }
	
		}
		}
		/*else
		{
		 $query9 = "insert into master_transactionipdeposit (patientname,patientcode,visitcode,transactiondate, particulars, 
		ipaddress, updatedate, companyanum, companyname, remarks, 
		transactionmodule,accountname,docno,transactionamount,username,transactiontime,locationname,locationcode,comments) 
		values ('$patientname','$patientcode','$visitcode','$updatedatetime', 'By Advance Adjustment', 
		'$ipaddress', '$updatedatetime','$companyanum', '$companyname', '$remarks', 
		'Adjustment','$accname','$billnumbercode','0.00','$username','$updatetime','".$locationnameget."','".$locationcodeget."','".$comments."')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		foreach($_POST['advancedocno'] as $key => $value)
		{
		$advancedocno=$_POST['advancedocno'][$key];
		if(isset($_POST['ack']))
		{
		$query31 = "update master_transactionadvancedeposit set recordstatus='adjusted', visitcode='$visitcode' where patientcode='$patientcode' and docno='$advancedocno'";
		$exec31 = mysql_query($query31) or die(mysql_error());
		}
		}
	
		}*/
		$query64 = "update master_ipvisitentry set deposit='completed' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec64 = mysqli_query($GLOBALS["___mysqli_ston"], $query64) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		//header("location:patientbillingstatus_bills.php?ippatientcode=$patientcode&&ipbillnumber=$billnumbercode");
		?>
		<script>
        function functoprint() 
	 {
	//alert("hi");
	window.open("print_depositcollection_dmp4inch1.php?patientcode=<?php echo $patientcode;?>&&billnumbercode=<?php echo $billnumbercode;?>&&locationcode=<?php echo $locationcodeget;?>","OriginalWindowA4",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.location.href="patientbillingstatus_bills.php";
	  } 
        </script>
		
		<?php
		
		echo "<script>functoprint();</script>";
		
		exit;
		
}
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Payment Entry Not Completed.";
}
//include ("autocompletebuild_customer1.php");
?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'IPDF-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from master_transactionipdeposit where transactionmodule = 'PAYMENT' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
 $billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode =$paynowbillprefix.'1'."-".date('y');
		$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;
	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $paynowbillprefix .$maxanum."-".date('y');
	$openingbalance = '0.00';
	//echo $companycode;
}
$query764 = "select * from master_financialintegration where field='ipdeposits'";
$exec764 = mysqli_query($GLOBALS["___mysqli_ston"], $query764) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res764 = mysqli_fetch_array($exec764);
$ipdepositscoa = $res764['code'];
$ipdepositscoaname = $res764['coa'];
$ipdepositstype = $res764['type'];
$ipdepositsselect = $res764['selectstatus'];
$query765 = "select * from master_financialintegration where field='cashipdeposits'";
$exec765 = mysqli_query($GLOBALS["___mysqli_ston"], $query765) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res765= mysqli_fetch_array($exec765);
$cashcoa = $res765['code'];
$query766 = "select * from master_financialintegration where field='chequeipdeposits'";
$exec766 = mysqli_query($GLOBALS["___mysqli_ston"], $query766) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res766 = mysqli_fetch_array($exec766);
$chequecoa = $res766['code'];
$query767 = "select * from master_financialintegration where field='mpesaipdeposits'";
$exec767 = mysqli_query($GLOBALS["___mysqli_ston"], $query767) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res767 = mysqli_fetch_array($exec767);
$mpesacoa = $res767['code'];
$query768 = "select * from master_financialintegration where field='cardipdeposits'";
$exec768 = mysqli_query($GLOBALS["___mysqli_ston"], $query768) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res768 = mysqli_fetch_array($exec768);
$cardcoa = $res768['code'];
$query769 = "select * from master_financialintegration where field='onlineipdeposits'";
$exec769 = mysqli_query($GLOBALS["___mysqli_ston"], $query769) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res769 = mysqli_fetch_array($exec769);
$onlinecoa = $res769['code'];
?>
<?php
if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
include ("js/sales1scripting1new_dep.php"); 
$num12=0;
$zero_deposit =true;
$query12 = "select count(visitcode) as numrws from iptest_procedures where visitcode = '$visitcode' and patientcode = '$patientcode' 
			union select count(visitcode) as numrws from ipmedicine_prescription where visitcode = '$visitcode' and patientcode = '$patientcode'";
$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die("Error in query12 ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res12 = mysqli_fetch_array($exec12)){
$num12 += $res12['numrws'];
}
if($num12 > 0)
{
	$zero_deposit = false;
}
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<script>
  
    function funcSaveBill1()
{
var varUserChoice; 
	varUserChoice = confirm('Are You Sure Want To Save This Entry?'); 
	//alert(fRet); 
	if (varUserChoice == false)
	{
		alert ("Entry Not Saved.");
		return false;
	}
	else
	{
		//alert ("Entry Saved.");
		
		functoprint();
		//return true;
	}
	
	}
function FunctionCall()
{
	funcBodyOnLoad();
	funcPopupPrintFunctionCall();
funcCustomerDropDownSearch1();
}
function funcdepositchange()
{
if(document.getElementById("deposittype").value == 'adjust')
{
if(document.getElementsByName("ack[]").length != 0)
{
document.getElementById("paymentamount").value = '0.00';
document.getElementById("billtype").disabled = true;
document.getElementById("paymentamount").readOnly = true;
}
else
{
alert("No Deposites on Patient to Adjust");
document.getElementById("deposittype").selectedIndex  = 1;
}
}
if(document.getElementById("deposittype").value == 'new1')
{
document.getElementById("paymentamount").value = '0.00';
document.getElementById("billtype").disabled = false;
document.getElementById("paymentamount").readOnly = false;
}
}
function funpaymentamount(serialnumber,amount)
{
var serialnumber = serialnumber;
var amount = amount;
if(document.getElementById("deposittype").value == '')
{
alert("Please Select Deposit Type");
document.getElementById("deposittype").focus();
return false;
}
if(document.getElementById("deposittype").value == 'new1')
{
alert("Please Change Deposit Type");
document.getElementById("deposittype").focus();
return false;
}
if(document.getElementById("ack"+serialnumber+"").checked == true)
{
document.getElementById("paymentamount").value = amount;
document.getElementById("paymentamount").readOnly = true;
}
if(document.getElementById("ack"+serialnumber+"").checked == false)
{
document.getElementById("paymentamount").value = '0.00';
document.getElementById("paymentamount").readOnly = false;
}
}
function checkvalid()
{
if(document.getElementById("deposittype").value == '')
{
alert("Please Select Deposit Type");
document.getElementById("deposittype").focus();
return false;
}
if(document.getElementById("deposittype").value == 'adjust')
{
if(document.querySelectorAll('input[name="ack[]"]:checked').length == 0)
{
alert("Please Select Deposit from Advance Deposits to adjust");
return false;
}
}
//alert(document.getElementById("tdShowTotal").value);
	
	if(document.getElementById("tdShowTotal").value==0 && document.getElementById("deposittype").value == 'new1')
	{
		<?php if(!$zero_deposit){
			?>
		
			alert("Patient has OP Bill Applied. None zero deposite only.");
			return false;
		<?php } else{
			?>
		if(document.getElementById("comments").value=='')
		{
			alert("Please enter the Reason for 0.00 Deposite!");
			document.getElementById("comments").focus();
			return false;
			}
		<?php }?>
		
		}
		
if((document.getElementById("cashamount").value != '')&&(document.getElementById("cashamount").value != '0.00')&&(document.getElementById("cashamount").value !=0))
{
	if((document.getElementById("cashgivenbycustomer").value=='')||(document.getElementById("cashgivenbycustomer").value==0))
	{
	alert("Please Enter Cash Given by Customer!");
	document.getElementById("cashgivenbycustomer").focus();
	return false;
	}
}
if((document.getElementById("chequeamount").value != '')&&(document.getElementById("chequeamount").value != '0.00')&&(document.getElementById("chequeamount").value !=0))
{
	if((document.getElementById("chequenumber").value==''))
	{
	alert("Please Enter Cheque Number!");
	document.getElementById("chequenumber").focus();
	return false;
	}
	if((document.getElementById("chequedate").value==''))
	{
	alert("Please Enter Cheque Date!");
	document.getElementById("chequedate").focus();
	return false;
	}
	if((document.getElementById("chequebank").value==''))
	{
	alert("Please Enter Cheque Bank!");
	document.getElementById("chequebank").focus();
	return false;
	}
}
if((document.getElementById("creditamount").value != '')&&(document.getElementById("creditamount").value != '0.00')&&(document.getElementById("creditamount").value !=0))
{
	// Kenique 02/08/2018
	if((document.getElementById("mpesanumber").value==''))
	{
	alert("Please Enter MPESA Number!");
	document.getElementById("mpesanumber").focus();
	return false;
	}
}
if((document.getElementById("cardamount").value != '')&&(document.getElementById("cardamount").value != '0.00')&&(document.getElementById("cardamount").value !=0))
{
	if((document.getElementById("cardnumber").value==''))
	{
	alert("Please Enter Card Number!");
	document.getElementById("cardnumber").focus();
	return false;
	}
	if((document.getElementById("cardname").value==''))
	{
	alert("Please Enter Card Name!");
	document.getElementById("cardname").focus();
	return false;
	}
	if((document.getElementById("bankname").value==''))
	{
	alert("Please Enter Card Bank!");
	document.getElementById("bankname").focus();
	return false;
	}
}
if((document.getElementById("onlineamount").value != '')&&(document.getElementById("onlineamount").value != '0.00')&&(document.getElementById("onlineamount").value !=0))
{
	if((document.getElementById("onlinenumber").value==''))
	{
	alert("Please Enter Online Number!");
	document.getElementById("onlinenumber").focus();
	return false;
	}
}
/*if(document.getElementById("paymentamount").value == '0.00')
{
alert("Please Enter Deposit Amount");
document.getElementById("paymentamount").focus();
return false;
}*/
if(document.getElementById("deposittype").value == 'new1')
{
if(document.getElementById("paymentmode").value == '')
{
alert("Please Select Payment Mode");
document.getElementById("paymentmode").focus();
return false;
}
}
var varUserChoice; 
	varUserChoice = confirm('Are You Sure Want To Save This Entry?'); 
	//alert(fRet); 
	if (varUserChoice == false)
	{
		alert ("Entry Not Saved.");
		return false;
	}
	document.getElementByID('savebutton').disabled=true;
	
}
function balancecalc(mode)
{
var mode = mode;
var cashamount = document.getElementById("cashamount").value;
//alert(cashamount);
if(cashamount == '')
{
cashamount = 0;
}
var chequeamount = document.getElementById("chequeamount").value;
if(chequeamount == '')
{
chequeamount = 0;
}
var cardamount = document.getElementById("cardamount").value;
if(cardamount == '')
{
cardamount = 0;
}
var onlineamount = document.getElementById("onlineamount").value;
if(onlineamount == '')
{
onlineamount = 0;
}
var adjustamount = document.getElementById("adjustamount").value;
if(adjustamount == '')
{
	adjustamount = 0;
}
var mpesaamount = document.getElementById("creditamount").value;
if(mpesaamount == '')
{
mpesaamount = 0;
}
var balance_amt = parseFloat($('#hid_bal_amt').val());
if(parseFloat(adjustamount) >parseFloat( balance_amt) )
{
	alert('Adjust amount exceeds Available Amount');
	$('#adjustamount').val('0.00');
	$('#adjustamount').keyup();
	return false;
}
else
{
	
	var adv_dep_bal_amt = parseFloat(balance_amt) - parseFloat(adjustamount);
	adv_dep_bal_amt = adv_dep_bal_amt.toFixed(2);
	//var format_bal = adv_dep_bal_amt.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	$('#adv_dep_bal_amt').text(adv_dep_bal_amt.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
	$('#net_deposit_amt').val(adv_dep_bal_amt);
}
//var balance =  document.getElementById("totalamount").value;
var totalamount = parseFloat(cashamount)+parseFloat(chequeamount)+parseFloat(cardamount)+parseFloat(onlineamount)+parseFloat(adjustamount)+parseFloat(mpesaamount);
var newbalance= parseFloat(totalamount);
newbalance = newbalance.toFixed(2);
if(newbalance < 0)
{
alert("Entered Amount is greater than Bill Amount");
if(mode == '1')
{
document.getElementById("cashamount").value = '0.00';
}    
if(mode == '2')
{
document.getElementById("creditamount").value = '0.00';
}  
if(mode == '3')
{
document.getElementById("chequeamount").value = '0.00';
}  
if(mode == '4')
{
document.getElementById("cardamount").value = '0.00';
}  
if(mode == '5')
{
document.getElementById("onlineamount").value = '0.00';
document.getElementById("adjustamount").value = '0.00';
}            
          
return false;
}
if(newbalance == -0.00)
{
newbalance = 0;
newbalance = newbalance.toFixed(2);
}
	
	
document.getElementById("tdShowTotal").value = newbalance;
}
function cashentryonfocus1()
{
	if (document.getElementById("cashgivenbycustomer").value == "0.00")
	{
		document.getElementById("cashgivenbycustomer").value = "";
		document.getElementById("cashgivenbycustomer").focus();cashgiventocustomer
	}
	if (document.getElementById("cashgivenbycustomer").value != "")
	{
	document.getElementById("cashgiventocustomer").value=parseFloat(document.getElementById("cashgivenbycustomer").value)-parseFloat(document.getElementById("cashamount").value);
	}
}
function funcOnLoadBodyFunctionCall()
{
	funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	funcPopupPrintFunctionCall();
	//alert ("Auto Print Function Runs Here.");	
}
function funcPopupPrintFunctionCall()
{
	///*
	//alert ("Auto Print Function Runs Here.");
	<?php
	if (isset($_REQUEST["src"])) { $src = $_REQUEST["src"]; } else { $src = ""; }
	//$src = $_REQUEST["src"];
	if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
	//$st = $_REQUEST["st"];
	if (isset($_REQUEST["billnumber"])) { $previousbillnumber = $_REQUEST["billnumber"]; } else { $previousbillnumber = ""; }
	//$previousbillnumber = $_REQUEST["billnumber"];
	if (isset($_REQUEST["billautonumber"])) { $previousbillautonumber = $_REQUEST["billautonumber"]; } else { $previousbillautonumber = ""; }
	//$previousbillautonumber = $_REQUEST["billautonumber"];
	if (isset($_REQUEST["companyanum"])) { $previouscompanyanum = $_REQUEST["companyanum"]; } else { $previouscompanyanum = ""; }
	//$previouscompanyanum = $_REQUEST["companyanum"];
	if ($src == 'frm1submit1' && $st == 'success')
	{
	$query1print = "select * from master_printer where defaultstatus = 'default' and status <> 'deleted'";
	$exec1print = mysqli_query($GLOBALS["___mysqli_ston"], $query1print) or die ("Error in Query1print.".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1print = mysqli_fetch_array($exec1print);
	$papersize = $res1print["papersize"];
	$paperanum = $res1print["auto_number"];
	$printdefaultstatus = $res1print["defaultstatus"];
	
	if ($paperanum == '1') //For 40 Column paper
	{
	?>
		//quickprintbill1();
		quickprintbill1sales();
	//alert ("Auto Print Function Runs Here.");
	<?php
	}
	else if ($paperanum == '2') //For A4 Size paper
	{
	?>
		loadprintpage1('A4');
	<?php
	}
	else if ($paperanum == '3') //For A4 Size paper
	{
	?>
		loadprintpage1('A5');
	<?php
	}
	}
	?>
	//*/
}
</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.bali
{
text-align:right;
}
</style>
</head>
<script src="js/datetimepicker_css_fin.js"></script>
<script src="js/jquery-1.11.1.min.js"></script>
<?php 
include ("js/dropdownlist1advancedeposit.php"); ?>
<script type="text/javascript" src="js/autosuggestadvancedeposit.js"></script> 
<script type="text/javascript" src="js/autocomplete_customer1.js"></script>
<body onLoad="return FunctionCall();" >
<form name="form1" id="form1" method="post" action="depositform.php" onSubmit="return checkvalid();">	
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
   
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      
	 
	
		<tr>
		<td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
           <?php
		  
		  $locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
		   $query1 = "select locationcode from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		while($res1 = mysqli_fetch_array($exec1))
		{
		
		
		$locationcodeget = $res1['locationcode'];
		$query551 = "select * from master_location where locationcode='".$locationcodeget."'";
		$exec551 = mysqli_query($GLOBALS["___mysqli_ston"], $query551) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res551 = mysqli_fetch_array($exec551);
		$locationnameget = $res551['locationname'];
		}?>
             <tr>
			  <td align="center" valign="center" class="bodytext31"><strong>Doc No</strong></td>
			   <td  colspan="3"  align="left" valign="center" class="bodytext31"><input type="text" name="docno" id="docno" value="<?php echo $billnumbercode; ?>" size="10"></td>
               <td colspan="2" class="bodytext31" ><strong>Location &nbsp;</strong><?php echo $locationnameget;?></td>
                  <input type="hidden" name="locationcodeget" value="<?php echo $locationcodeget?>">
				<input type="hidden" name="locationnameget" value="<?php echo $locationnameget?>">
			 </tr>
            <tr>
              
				 <td width="22%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient Name</strong></div></td>
           
				 <td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>
				 <td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP Visit  </strong></div></td>
				 <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
				 <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Gender  </strong></div></td>
				 <td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Age  </strong></div></td>
		
              </tr>
           <?php
            $colorloopcount ='';
		
		$query1 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		while($res1 = mysqli_fetch_array($exec1))
		{
		$patientname=$res1['patientfullname'];
		$patientcode=$res1['patientcode'];
		$accountname = $res1['accountname'];
		$patientlocationcode=$res1['locationcode'];
		$patientlocationname=$res1['locationname'];
		$gender = $res1['gender'];
		$age = $res1['age'];
		
		
		$query67 = "select * from master_accountname where auto_number='$accountname'";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 
		$res67 = mysqli_fetch_array($exec67);
		$accname = $res67['accountname'];
		
		
		
	
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
             
			  <td  align="left" valign="center" class="bodytext31">
			    <div align="center"><?php echo $patientname; ?></div></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $visitcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $accname; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $gender; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $age; ?></td>
				<input type="hidden" name="patientname" id="patientname" value="<?php echo $patientname; ?>">
				 
				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>">
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>">
			
				<input type="hidden" name="accname" id="accname" value="<?php echo $accname; ?>">
			   </tr>
		   <?php 
		   } 
		  
		   ?>
           
            <tr>
             	<td colspan="4" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td><td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            
             	<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            
             	</tr>
			<tr>
        <td colspan="6">&nbsp;</td>
      </tr>
			<tr>
			<td colspan="6">
			 <table width="919" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                <tbody>
				
                  <tr bgcolor="#011E6A">
                    <td colspan="8" bgcolor="#ecf0f5" class="bodytext3"><strong>Payment  Entry - Details </strong></td>
					<td width="109" align="left" valign="middle" bgcolor="#ecf0f5"  class="bodytext31"> <strong>Deposit Type</strong></td>
                    <td width="109" align="left" valign="middle" bgcolor="#ecf0f5"  class="bodytext31"><!-- <select name="deposittype" id="deposittype" onChange="return funcdepositchange();"> -->
                    	<select name="deposittype" id="deposittype">
					<option value="">Select Type</option>
					<option value="new1" selected="selected">New</option>
					<!-- <option value="adjust">Adjust</option> -->
					</select></td>
                  </tr>
                  <tr>
                    <td colspan="8" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#FFFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td width="115" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">  Amount</td>
                    <td width="219" align="left" valign="top"  bgcolor="#FFFFFF">
					<input type="hidden" name="paymentamount" id="paymentamount" style="border: 1px solid #001E6A; text-align:right" value="0.00"  size="20" />
                    <input type="text" id="tdShowTotal" name="tdShowTotal" readonly  size="20" value="0.00" style="border:none;background:none;color:#000;font:bold 15px/20px Arial, Helvetica, sans-serif">
							<input type="hidden" name="cashcoa" value="<?php echo $cashcoa; ?>">
							<input type="hidden" name="ipdepositscoa" value="<?php echo $ipdepositscoa; ?>">
				<input type="hidden" name="chequecoa" value="<?php echo $chequecoa; ?>">
				<input type="hidden" name="mpesacoa" value="<?php echo $mpesacoa; ?>">
				<input type="hidden" name="cardcoa" value="<?php echo $cardcoa; ?>">
				<input type="hidden" name="onlinecoa" value="<?php echo $onlinecoa; ?>"></td>
	</td>
                    <td width="113" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Payment Mode </td>
                    <td width="214" align="left" valign="top"  bgcolor="#FFFFFF">
					<select name="billtype" id="billtype" style="width: 130px;" onChange="getEncAmount(); return paymentinfo()">
                        <option value="" selected="selected">SELECT</option>
                        <option value="CHEQUE">CHEQUE</option>
                        <option value="CASH">CASH</option>
						<option value="CREDITCARD">CREDIT CARD</option>
      					<option value="ONLINE">ONLINE</option>
						<option value="MPESA">MPESA</option>
                        <option value="SPLIT">SPLIT</option>
                    </select></td>
                     <td align="left" valign="center"  
                 class="bodytext31" colspan="1" bgcolor="#FFF">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31" colspan="1" bgcolor="#FFF">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31" colspan="1" bgcolor="#FFF">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31" colspan="1" bgcolor="#FFF">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
                  </tr>
                 <!-- <tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> Number </td>-->
                    <!--<td align="left" valign="top"  bgcolor="#FFFFFF">
					<input name="chequenumber" id="chequenumber" style="border: 1px solid #001E6A" value=""  size="20" /></td>-->
                   <!-- <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Bank Name </td>-->
                    <!--<td align="left" valign="top"  bgcolor="#FFFFFF"><input name="bankname" id="bankname" style="border: 1px solid #001E6A" value=""  size="20" /></td>-->
                 <!-- </tr>-->
                  <tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">  Date </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo date('Y-m-d'); ?>"  size="20"  readonly="readonly" onKeyDown="return disableEnterKey()"/>
					<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1','','','','','','past','<?= $finfromyear; ?>','<?= $fintoyear; ?>')" style="cursor:pointer"/>				    </td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Remarks</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="remarks" id="remarks" style="border: 1px solid #001E6A" value=""  size="20" />
					 <input type="hidden" name="docno" value="<?php echo $billnumbercode; ?>"></td>
                     
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Comments</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input type="textarea" name="comments" id="comments" style="border: 1px solid #001E6A" value=""  size="20" />
					 </td>
                      <td align="left" valign="center"  
                 class="bodytext31" colspan="1" bgcolor="#FFF">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31"  width="219" bgcolor="#FFF"><input type="text" style="width:150px;border:1px #FFFFFF" readonly></td>
                <!--<td align="left" valign="center"  
                 class="bodytext31" colspan="1" bgcolor="#FFF">&nbsp;</td>-->
               <!-- <td align="left" valign="center"  
                 class="bodytext31" colspan="1" bgcolor="#FFF">&nbsp;</td>-->
                <td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
                  </tr>
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  <tr id="cashamounttr">
			 
              
                <td  align="right" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF"><div align="right"><strong>Cash </strong></div></td>
                                <td  align="left" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF"><input name="cashamount" id="cashamount" onBlur="return funcbillamountcalc1()" tabindex="1" value="0.00" style="text-align:right" size="8"  readonly="readonly" onKeyUp="return balancecalc('1')"/></td>
                <td  align="left" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF"><div align="right"><strong>Cash Recd </strong></div></td>
                <td  align="left" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF"><input name="cashgivenbycustomer" id="cashgivenbycustomer" onKeyUp="return funcbillamountcalc1()" onFocus="return cashentryonfocus1()"  tabindex="2" style="text-align:right" size="8" autocomplete="off"  /></td>
                <td align="left" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF"><div align="right"><strong>Change   </strong></div></td>
                <td align="left" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF"><input name="cashgiventocustomer" id="cashgiventocustomer" onBlur="return funcbillamountcalc1()" value="0.00" style="text-align:right" size="8" readonly  /></td>
               
               
                <td align="left" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF">&nbsp;</td>
                <td align="left" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF">&nbsp;</td>
              </tr>
			
              <tr id="creditamounttr">
               
                <td colspan="1" align="left" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF"><div align="right"><strong> MPESA </strong></div></td>
                <td align="left" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF"><input name="creditamount" id="creditamount" onBlur="return funcbillamountcalc1()" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="8"  readonly="readonly" onKeyUp="getEncAmount(); return balancecalc('2')"/></td>
                <td align="left" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF"><div align="right"><strong> MPESA No. </strong></div></td>
                <td align="left" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF"><input name="mpesanumber" id="mpesanumber" value="" style="border: 1px solid #001E6A; text-align:left; text-transform:uppercase" size="8"  readonly/>
			<?php 
				$query = "select mobilenumber from master_customer where customercode = '$patientcode'";
				$execquery = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
				$resquery = mysqli_fetch_array($execquery);
				$mobilenumber = $resquery['mobilenumber'];
			?>
            <!-- iPayments HTML/PHP Code Start -->
            <?php
            	$mpesa_amount = $totalamount;
                $mpesa_secret_key = $mpesa_secret;
                $mpesa_result_field = "mpesanumber";
                $mpesa_amount_field = "creditamount";
                $mpesa_number = iPayment_mobileTrim($mobilenumber);
                $mpesa_user_id = $username; // Max 10 Char
            ?>    
            <input type="hidden" name="mpesa_url" id="mpesa_url" value="<?= $mpesa_url ?>" placeholder="Mpesa Amount Field">
            <input type="hidden" name="mpesa_amount_field" id="mpesa_amount_field" value="<?= $mpesa_amount_field ?>" placeholder="Mpesa Amount Field">
            <input type="hidden" name="mpesa_result_field" id="mpesa_result_field" value="<?= $mpesa_result_field ?>" placeholder="Mpesa Result Field">
            <input type="hidden" name="mpesa_amount" id="mpesa_amount" value="<?= iPayment_encrypt("$mpesa_amount","$mpesa_secret_key") ?>" placeholder="Amount">
            <input type="hidden" name="mpesa_secret_key" id="mpesa_secret_key" value="<?= $mpesa_secret_key ?>" placeholder="Secret Key">
            <input type="hidden" name="mpesa_number" id="mpesa_number" value="<?= iPayment_encrypt("$mpesa_number","$mpesa_secret_key") ?>" placeholder="Number">
            <input type="hidden" name="mpesa_user_id" id="mpesa_user_id" value="<?= $mpesa_user_id ?>" placeholder="User">
            <?php if($mpesa_integration == 1){ ?><span id="iPaymentsIcon" onclick="OpenMpesa()" style="padding: 3px;background-color: #fff;border-radius: 20px;border: 1px solid;cursor: pointer;" title="Lipa na MPESA - iPayments">⚡</span> <?php } ?>
            <!-- iPayments HTML/PHP Code End -->
			</td>
                <td align="left" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF">&nbsp;</td>
                <td align="left" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF">&nbsp;</td>
                <td align="left" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF">&nbsp;</td>
 
                <td align="left" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF">&nbsp;</td>
               
              </tr>
              <tr id="chequeamounttr">
               
                <td colspan="1" align="left" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF"><div align="right"><strong>Cheque  </strong></div></td>
                <td align="left" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF"><input name="chequeamount" id="chequeamount" onBlur="return funcbillamountcalc1()" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="8"  readonly="readonly" onKeyUp="return balancecalc('3')"/></td>
                <td align="left" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF"><div align="right"><strong> Chq No. </strong></div></td>
                <td align="left" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF"><input name="chequenumber" id="chequenumber" value="" style="border: 1px solid #001E6A; text-align:left; text-transform:uppercase" size="8"  /></td>
                <td align="left" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF"><div align="right"><strong> Date </strong></div></td>
                <td  colspan="1" align="left" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF">  <input name="chequedate" id="chequedate" value="" style="border: 1px solid #001E6A;float:left; text-align:left; text-transform:uppercase" size="8"  /><img src="images2/cal.gif" onClick="javascript:NewCssCal('chequedate')" style="cursor:pointer;float:left"/></td>
                <td align="left" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF"><div align="right"><strong> Bank  </strong></div></td>
                <td  align="left" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF"> <input name="chequebank" id="chequebank" value="" style="border: 1px solid #001E6A; text-align:left; text-transform:uppercase" size="8"  /></td>
                
                   </tr>
			  
              <tr id="cardamounttr">
               
                <td colspan="1" align="left" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF"><div align="right"><strong>Card  </strong></div></td>
                <td align="left" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF"><input name="cardamount" id="cardamount" onBlur="return funcbillamountcalc1()" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="8"  readonly="readonly" onKeyUp="getBarclayAmount(); return balancecalc('4')"/></td>
                <td align="left" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF"><div align="right"><strong> Transaction No </strong></div></td>
                <td align="left" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF"><input name="cardnumber" id="cardnumber" value="" style="border: 1px solid #001E6A; text-align:left; text-transform:uppercase" size="8"  /><!-- iPayments HTML/PHP Code Start -->
	            <?php
	                $barclays_amount = $totalamount;
	                $barclays_secret_key = $barclays_secret;
	                $barclays_result_field = "cardnumber";
	                $barclays_amount_field = "cardamount";
	                $barclays_user_id = "1"; // Must be an interger value
	            ?>
	            <input type="hidden" name="barclayscard_url" id="barclayscard_url" value="<?= $barclayscard_url ?>" placeholder="Barclays Card Url">
	            <input type="hidden" name="barclays_result_field" id="barclays_result_field" value="<?= $barclays_result_field ?>" placeholder="Mpesa Result">
	            <input type="hidden" name="barclays_amount" id="barclays_amount" value="<?= iPayment_encrypt('$barclays_amount','$barclays_secret_key') ?>" placeholder="Amount">
	            <input type="hidden" name="barclays_amount_field" id="barclays_amount_field" value="<?= $barclays_amount_field ?>">
	            <input type="hidden" name="barclays_secret_key" id="barclays_secret_key" value="<?= $barclays_secret_key ?>" placeholder="Secret Key">
	            <input type="hidden" name="barclays_user_id" id="barclays_user_id" value="<?= $barclays_user_id ?>" placeholder="User">
	            <?php if($barclayscard_integration == 1){ ?><span onclick="OpenBarclays()" style="padding: 3px;background-color: #fff;border-radius: 20px;border: 1px solid;cursor: pointer;" id="iPaymentsIconBarclays" title="Card Payments - iPayments">⚡</span><?php } ?>
	            <!-- iPayments HTML/PHP Code End -->
	        	</td>
	        	<td colspan="4" bgcolor="#fff"></td>
                <!-- <td colspan="1" align="left" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF"><div align="right"><strong>Name  </strong></div></td>
                <td align="left" valign="center"  
 class="bodytext31" colspan="1" bgcolor="#FFF"><input type="text" name="cardname" id="cardname" size="8" style="border: 1px solid #001E6A; text-align:left;"> -->
                <!--<select name="cardname" id="cardname">
                  <option value="">SELECT CARD</option>
                  <?php
				$querycom="select * from master_creditcard where status <> 'deleted'";
				$execcom=mysqli_query($GLOBALS["___mysqli_ston"], $querycom) or die("Error in querycom".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($rescom=mysqli_fetch_array($execcom))
				{
				$creditcardname=$rescom["creditcardname"];
				?>
                  <option value="<?php echo $creditcardname;?>"><?php echo $creditcardname;?></option>
                  <?php
				}
				?>
                </select>--><!-- </td>
                <td align="left" valign="center" class="bodytext31" colspan="1" bgcolor="#FFF"><div align="right"><strong> Bank  </strong></div></td>
                <td align="left" valign="center" class="bodytext31" colspan="1" bgcolor="#FFF"><input name="bankname1" id="bankname" value="" style="border: 1px solid #001E6A; text-align:left; text-transform:uppercase"  size="8"  /></td> -->
              </tr>
              <tr id="onlineamounttr">
			 
			    <td colspan="1" align="left" valign="center" 
                 class="bodytext31" colspan="1" bgcolor="#FFF">
                 <div align="right"><strong>Online  </strong></div>                  </td>
                <td align="left" valign="center"  
                 class="bodytext31" colspan="1" bgcolor="#FFF"><input name="onlineamount" id="onlineamount" onBlur="return funcbillamountcalc1()" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="8" readonly onKeyUp="return balancecalc('5')"/></td>
                 <td align="left" valign="center"  
                 class="bodytext31" colspan="1" bgcolor="#FFF"><div align="right"><strong> Online No </strong></div></td>
                <td align="left" valign="center"  
                 class="bodytext31" colspan="1" bgcolor="#FFF"><input name="onlinenumber" id="onlinenumber" value="" style="border: 1px solid #001E6A; text-align:left; text-transform:uppercase" size="8"  /></td>
                <td align="left" valign="center"  
                 class="bodytext31" colspan="1" bgcolor="#FFF">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31" colspan="1" bgcolor="#FFF">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31" colspan="1" bgcolor="#FFF">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31" colspan="1" bgcolor="#FFF">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
              </tr>
                 
              <tr id="adjustamounttr">
			 
			    <td colspan="1" align="left" valign="center" 
                 class="bodytext31" colspan="1" bgcolor="#FFF">
                 <div align="right"><strong>Adjust  </strong></div>                  </td>
                <td align="left" valign="center"  
                 class="bodytext31" colspan="1" bgcolor="#FFF"><input name="adjustamount" id="adjustamount" onBlur="return funcbillamountcalc1()"  style="border: 1px solid #001E6A; text-align:right" size="8" readonly onKeyUp="return balancecalc('5')"/></td>
                 <td align="left" valign="center"  
                 class="bodytext31" colspan="1" bgcolor="#FFF">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31" colspan="1" bgcolor="#FFF">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31" colspan="1" bgcolor="#FFF">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31" colspan="1" bgcolor="#FFF">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31" colspan="1" bgcolor="#FFF">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31" colspan="1" bgcolor="#FFF">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
              </tr>
                  <tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                    <td align="left" valign="top"  colspan="5" bgcolor="#FFFFFF"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                      <input type="hidden" name="cbfrmflag2" value="<?php echo $supplieranum; ?>">
                      <input type="hidden" name="frmflag2" value="frmflag2">
                      <input name="Submit" type="submit"  value="Save Payment" id="savebutton" class="button" style="border: 1px solid #001E6A"/>
                    </font></td>
                    
                  </tr>
                </tbody>
              </table>			  </td>
			 </tr>
          </tbody>
        </table>
		</td>
		</tr>
		
		</table>
		
		</td>
		</tr>
	
      
      <tr>
	    <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
            <tr>
			<td colspan="3" bgcolor="#ecf0f5" class="bodytext311"><strong>Advance Deposits</strong></td>
			<td colspan="2" bgcolor="#ecf0f5" class="bodytext311"><strong>Location:&nbsp;&nbsp;<?php echo $patientlocationname ?></strong></td>
				</tr>
			 <tr>
               <td width="5%"align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> No </strong></div></td>
		
				 <td width="22%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient Name</strong></div></td>
           
				 <td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>
				 <!-- <td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date of Collection  </strong></div></td>
				 <td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Doc No</strong></div></td> -->
				 <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount  </strong></div></td>
                 <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bal. Amt  </strong></div></td>
				 <!-- <td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Select </strong></div></td> -->
		
              </tr>
			  <?php
			   $colorloopcount ='';
			   $sno = '';
			   
			  //$query43 = "select * from master_transactionadvancedeposit where patientcode='$patientcode' and recordstatus='' group by docno";
			  $query43 = "select patientname,patientcode,sum(transactionamount) amt from master_transactionadvancedeposit  where patientcode='$patientcode' group by patientcode order by auto_number desc";
			  $exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  $num43 = mysqli_num_rows($exec43);
			  while($res43 = mysqli_fetch_array($exec43))
			  {
			  
			  $patientname1 = $res43['patientname']; 
			  $patientcode1 = $res43['patientcode'];
			 // $dateofcollection = $res43['transactiondate'];
			  //$docnum = $res43['docno'];
			  //$transactionamount = $res43['transactionamount'];
				$deposit_totalamt=$res43['amt'];
				$deposit_bal_amt = $deposit_totalamt;
				$all_adjust_amt = 0;
				$all_refund_amt = 0;
				$deposit_amt_bal_query = "SELECT sum(adjustamount) usedamt FROM `adjust_advdeposits` WHERE `patientcode` = '$patientcode'";
				$bal_exec = mysqli_query($GLOBALS["___mysqli_ston"], $deposit_amt_bal_query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($bal_exec) > 0)
				{
					$bal_res = mysqli_fetch_array($bal_exec);
					$all_adjust_amt = $bal_res['usedamt']; 
					//$deposit_bal_amt = $deposit_totalamt - $all_adjust_amt;
				}
			  echo $refund_amt_bal_query = "SELECT sum(amount) as refundamt from deposit_refund where patientcode = '$patientcode' and visitcode='$visitcode'";
			    $refund_bal_exec = mysqli_query($GLOBALS["___mysqli_ston"], $refund_amt_bal_query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			   if(mysqli_num_rows($refund_bal_exec) > 0)
			   {
			   	   $refund_bal_res = mysqli_fetch_array($refund_bal_exec);
			   	   $all_refund_amt = $refund_bal_res['refundamt'];
			   }
			   $deposit_bal_amt = ($deposit_totalamt - ($all_adjust_amt + $all_refund_amt) );
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
				 <td  align="center" valign="center" class="bodytext31"><?php echo $sno = $sno +1; ?></td>
				 <td  align="left" valign="center" class="bodytext31">
			    <div align="center"><?php echo $patientname1; ?></div></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $patientcode1; ?></td>
				
				<!--<td  align="center" valign="center" class="bodytext31"><?php echo $dateofcollection; ?></td> 
				<td  align="center" valign="center" class="bodytext31"><?php echo $docnum; ?></td> 
				<input type="hidden" name="advancedocno[]" id="advancedocno" value="<?php echo $docnum; ?>"> -->
				<td  align="center" valign="center" class="bodytext31" id="adv_dep_total_amt"><?php echo number_format($deposit_totalamt,'2','.',',');?></td>
				<td  align="center" valign="center" class="bodytext31 tdstrong" id="adv_dep_bal_amt"><strong><?php echo number_format($deposit_bal_amt,'2','.',','); ?></strong></td>
				<input type="hidden" name="net_deposit_amt" id="net_deposit_amt" value="<?php echo $deposit_bal_amt; ?>" />
				<input type="hidden" name="hid_bal_amt" id="hid_bal_amt" value="<?php echo $deposit_bal_amt; ?>" />
			<!-- <td  align="center" valign="center" class="bodytext31"><input type="checkbox" name="ack[]" id="ack<?php echo $sno; ?>" onClick="return funpaymentamount('<?php echo $sno; ?>','<?php echo $transactionamount; ?>')"></td> -->
				</tr>
				<?php 
				}
				if($num43 == 0)
				{ ?>
					<tr><td class="bodytext31" colspan="6" align="center">There are No Advance Deposits Found</td>
						<input type="hidden" name="has_adv_deposit_amt" id="has_adv_deposit_amt" value="0" >
						<input type="hidden" name="adv_dep_total_amt" id="adv_dep_total_amt" value="0" />
			  		<input type="hidden" name="net_deposit_amt" id="net_deposit_amt" value="0" />
					<input type="hidden" name="hid_bal_amt" id="hid_bal_amt" value="0" />
					</tr>
				<?php }
				else
				{ ?>
					<input type="hidden" name="has_adv_deposit_amt" id="has_adv_deposit_amt" value="1" >
				<?php }
				?>
			</tbody>
			</table>
		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  
	 
    </table>
  </table>
   </form>
<script type="text/javascript">
function getEncAmount(){
	var amount = document.getElementById('creditamount').value;
	$.ajax({
        type: "POST",
        url: 'mpesacalc.php',
        data : {mpesaamt: amount},
        success: function(data)
        {	
        	document.getElementById("mpesa_amount").value = data;
        }
    });
}
function OpenMpesa(){
  var mpesa_url = window.document.getElementById("mpesa_url").value;
  var mpesa_amount = window.document.getElementById("mpesa_amount").value;
  var mpesa_amount_field = window.document.getElementById("mpesa_amount_field").value;
  var mpesa_result_field = window.document.getElementById("mpesa_result_field").value;
  var mpesa_secret_key = window.document.getElementById("mpesa_secret_key").value;
  var mpesa_number = window.document.getElementById("mpesa_number").value;
  var mpesa_user_id = window.document.getElementById("mpesa_user_id").value;
  var url = mpesa_url+"?mpesa_amount="+mpesa_amount+"&mpesa_number="+mpesa_number+"&mpesa_result_field="+mpesa_result_field+"&mpesa_secret_key="+mpesa_secret_key+"&mpesa_user_id="+mpesa_user_id+"&mpesa_amount_field="+mpesa_amount_field;
   var strWindowFeatures = "directories=no,titlebar=no,toolbar=no,location=no,copyhistory=no,status=no,menubar=no,scrollbars=no,resizable=no,height=520,width=450,top=20,left=450";
   window.open(url,"LIPA NA MPESA",strWindowFeatures);
}
</script>
<!-- iPayments Javascript Code End -->
<!-- iPayments Encryption Start -->
<?php function iPayment_encrypt($data, $key) {
    //$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $secret_iv = 'ivkey';
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    $encrypted =openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);return base64_encode($encrypted . '::' . $iv);} ?>
<!-- iPayments Encryption End -->
<!-- iPayments Javascript Code Start -->
<script type="text/javascript">
//***being called in sales1scripting_new.js***
function getBarclayAmount(){
var amount = document.getElementById('cardamount').value;
$.ajax({
    type: "POST",
    url: 'barclayscalc.php',
    data : {barclaysamt: amount},
    success: function(data)
    {	
    	document.getElementById("barclays_amount").value = data;
    }
});
}
function OpenBarclays(){
  var barclays_url = window.document.getElementById("barclayscard_url").value;
  var barclays_amount = window.document.getElementById("barclays_amount").value;
  var barclays_result_field = window.document.getElementById("barclays_result_field").value;
  var barclays_amount_field = window.document.getElementById("barclays_amount_field").value;
  var barclays_secret_key = window.document.getElementById("barclays_secret_key").value;
  var barclays_user_id = window.document.getElementById("barclays_user_id").value;

  var url = barclays_url+"?barclays_amount="+barclays_amount+"&barclays_result_field="+barclays_result_field+"&barclays_amount_field="+barclays_amount_field+"&barclays_secret_key="+barclays_secret_key+"&barclays_user_id="+barclays_user_id;
   var strWindowFeatures = "directories=no,titlebar=no,toolbar=no,location=no,copyhistory=no,status=no,menubar=no,scrollbars=no,resizable=no,height=520,width=450,top=20,left=450";
   window.open(url,"Barclays Card Payments",strWindowFeatures);
 }
</script>
<!-- iPayments Javascript Code End -->
<!-- iPayments Mobile Start -->
<?php
    function iPayment_mobileTrim($data){
        return ($data!="")?"254".substr($data, -9):"";
    }
?>
<!-- iPayments Mobile End -->
<?php include ("includes/footer1.php"); ?>
<script type="text/javascript">
	document.getElementById("deposittype").disabled = true;
	document.getElementById("paymentamount").value = '0.00';
	document.getElementById("paymentamount").readOnly = false;
</script>
</body>
</html>
