<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$suppliername = "";
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$res2suppliername = '';
$suppliercode = '';
$cbsuppliername = "";
$billnumberprefix = '';
$billanum='';
$username_auto_number="";
$billautonumber='';
$transactionmodule1='';
$currency='KSH';
$fxrate='1';
$locationname='';

$queryuser="select employeename,auto_number from master_employee where username='$username'";
$execuser = mysqli_query($GLOBALS["___mysqli_ston"], $queryuser) or die ("Error in queryuser".mysqli_error($GLOBALS["___mysqli_ston"]));
if($resuser = mysqli_fetch_array($execuser)){
 $username_auto_number=$resuser['auto_number'];
}
 
$location="select locationcode from login_locationdetails where username='$username' and docno='$docno'";
$exeloc=mysqli_query($GLOBALS["___mysqli_ston"], $location);
$resloc=mysqli_fetch_array($exeloc);
$locationcode=$resloc['locationcode'];

$query66 = "select * from master_location where locationcode = '$locationcode'";
$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
$res66 = mysqli_fetch_array($exec66);
$locationprefix = $res66['prefix'];

$query31 = "select fromyear,toyear from master_financialyear where status = 'Active' order by auto_number desc";
$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
$res31 = mysqli_fetch_array($exec31);
$finfromyear = $res31['fromyear']; 
$fintoyear = $res31['toyear'];

$paymentvoucherno = '';
$mode = '';
$bankcode='';
$bankname='';
$suppliername = '';

$approved_amount = 0;
$appvdcheque = '';
$appvdchequedt = '';
$appvdpaymentmode = '';
$remarks = '';
$appvdtaxamount = '0';

//This include updatation takes too long to load for hunge items database.
include ("autocompletebuild_supplier1.php");

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}


if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if (isset($_REQUEST["paymentdocno"])) { $paymentdocno = $_REQUEST["paymentdocno"]; } else { $paymentdocno = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
	$query281 = "select *, sum(approved_amount) as approved_amount from master_transactionpharmacy where paymentvoucherno = '$paymentdocno' and transactiontype = 'PURCHASE' and transactionmode <> 'CREDIT' group by paymentvoucherno order by auto_number desc";
			  $exec281 = mysqli_query($GLOBALS["___mysqli_ston"], $query281) or die ("Error in Query281".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $num281 = mysqli_num_rows($exec281);
			  $res281 = mysqli_fetch_array($exec281);
			  $totalamount=0;
			  $transactiondate = $res281['transactiondate'];
			  $date = explode(" ",$transactiondate);
			  $paymentvoucherno = $res281['paymentvoucherno'];
			  $mode = 'CHEQUE';
			  $bankcode=$res281['bankcode'];
			  $bankname=$res281['appvdbank'];
			  $suppliername = $res281['suppliername'];
			  
			$approved_amount = $res281['approved_amount'];
			$appvdcheque = $res281['appvdcheque'];
			$appvdchequedt = $res281['appvdchequedt'];
			$remarks = $res281['remarks'];
			$appvdpaymentmode = $res281['paymentmode'];
			//$appvdtaxamount = $res281['appvdfxamount'];
			
	$searchsuppliername = $suppliername;
	
		$arraysuppliername = $res281['suppliername'];
		$arraysuppliername = trim($arraysuppliername);
		$arraysuppliercode = $res281['suppliercode'];
		//	$arraysuppliername = $_POST['searchsuppliername'];
		//$arraysuppliercode = $_POST['searchsuppliercode'];
		
		$query1 = "select * from master_supplier where suppliercode = '$arraysuppliercode'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1 = mysqli_fetch_array($exec1);
		$supplieranum = $res1['auto_number'];
		$openingbalance = $res1['openingbalance'];

		$cbsuppliername = $arraysuppliername;
		$suppliername = $arraysuppliername;
		$suppliercode = $arraysuppliercode;
		
}

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag2 == 'frmflag2')
{
	if (isset($_SESSION["paymententrysession"])) { $paymententrysession = $_SESSION["paymententrysession"]; } else { $paymententrysession = "pending"; }
	if(true)
	{
		$_SESSION['paymententrysession']='completed';
	 	 $locationcode1=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:''; 	 
		//For generating first code
		include ("transactioncodegenerate1pharmacy.php");

		$query2 = "select * from settings_approval where modulename = 'collection' and status <> 'deleted'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$approvalrequired = $res2['approvalrequired'];
		if ($approvalrequired == 'YES')	{
			$approvalstatus = 'PENDING';
		}
		else {
			$approvalstatus = 'APPROVED';
		}
	
	
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'SPE-';
$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select * from master_transactionpharmacy where transactiontype='PAYMENT' and transactionmodule ='PAYMENT' and docno LIKE '%SPE%' order by auto_number desc limit 0, 1";
//echo $query2.'<br>';
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='SPE-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
    //echo $billnumbercode.'<br>';
	$billnumbercode = intval($billnumbercode);
	//echo $billnumbercode.'<br>';
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	$billnumbercode = 'SPE-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
    
    //echo $billnumbercode;
	//exit;
}

if($username_auto_number!=""){
 $billnumbercode.="-".$username_auto_number;
}
		//echo "inside if";
		$suppliercode = $_REQUEST['suppliercode'];
		
		$query11 = "select * from master_accountname where id = '$suppliercode'";
		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res11 = mysqli_fetch_array($exec11);
		$suppliername = $res11['accountname'];
		$accountssubanum = $res11['accountssub'];
		
		$query111 = "select * from master_accountssub where auto_number='$accountssubanum'";
		$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res111= mysqli_fetch_array($exec111);
		$accountssubid = $res111['id'];
		
		$paymententrydate = $_REQUEST['paymententrydate'];
		$paymentmode = $_REQUEST['paymentmode'];
		$chequenumber = $_REQUEST['chequenumber'];
		$chequedate = $_REQUEST['ADate1'];
		$bankname1 = $_REQUEST['bankname'];
		$whtcondition = $_REQUEST['whton'];
		$pretaxamount = $_REQUEST['pretax'];
		$tax16amount = $_REQUEST['tax16'];
		$whtapplicablecode = $_REQUEST['taxanum'];
		if($bankname1 != '')
		{
		$banknamesplit = explode('||',$bankname1);
		$bankcode = $banknamesplit[0];
		$bankname = $banknamesplit[1];
		}
		else
		{
		$bankcode = '04-5405';
		$bankname = '';
		}
		$bankbranch = isset($_REQUEST['bankbranch'])?$_REQUEST['bankbranch']:'';
		$remarks = $_REQUEST['remarks'];
		$paymentvoucherno = $_REQUEST['paymentvoucherno'];
		$paymentamount = $_REQUEST['paymentamount'];
		$netpayable = $_REQUEST['netpayable'];
		$taxamount = $_REQUEST['taxamount'];
		$pendingamount = $_REQUEST['pendingamount'];
		$remarks = $_REQUEST['remarks'];
		$cashcoa = $_REQUEST['cashcoa'];
		$chequecoa = $_REQUEST['chequecoa'];
		$cardcoa = $_REQUEST['cardcoa'];
		$mpesacoa = $_REQUEST['mpesacoa'];
		$onlinecoa = $_REQUEST['onlinecoa'];
		$onaccount =isset($_REQUEST['onaccount'])?$_REQUEST['onaccount']:'';
		$pendingamount=str_replace(',', '', $pendingamount);
		$netpayable=str_replace(',', '', $netpayable);
		$paymentamount=str_replace(',', '', $paymentamount);	
		$balanceamount = $pendingamount - $netpayable;
		$transactiondate = $paymententrydate;
		$balanceamount=str_replace(',', '', $balanceamount);
		$transactionmode = $paymentmode;
		if ($transactionmode == 'TDS')
		{
			$transactiontype = 'TDS';
		}
		else
		{
			$transactiontype = 'PAYMENT';
		}
		
		$ipaddress = $ipaddress;
		$updatedate = $updatedatetime;

		$string = explode("||", $bankname1);
		$bankcode = $string[0];
		$bankname = $string[1];

		$query30 = "select tax_percent from master_withholding_tax where auto_number = '$whtapplicablecode'";
		$exec30 = mysqli_query($GLOBALS["___mysqli_ston"], $query30) or die("Error in Query30".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res30 = mysqli_fetch_array($exec30);
		$taxpercentage = $res30['tax_percent'];

		if($whtcondition == 1){
			$whtconditionname = "ON ORIGINAL";
		} else if($whtcondition == 2) {
			$whtconditionname = "ON TOTAL";
		}else
			$whtconditionname = "";

		$transactionmodule = 'PAYMENT';

		$query40 = "INSERT INTO paymententry_details(docno, entrydate, paymentmode, accountnameid, accountname, pendingamount, supplieramount, wht_condition, wht_condition_name, pretaxamount, vat16amount, applicable_wht_code, taxpercentage, taxamount, netpayable, cheque_number, cheque_date, onaccount, bankname, bankcode, username) VALUES ('$billnumbercode', '$transactiondate', '$paymentmode', '$suppliercode', '$suppliername', '$pendingamount', '$paymentamount', '$whtcondition', '$whtconditionname', '$pretaxamount', '$tax16amount', '$whtapplicablecode', '$taxpercentage', '$taxamount', '$netpayable', '$chequenumber', '$chequedate', '$onaccount', '$bankname', '$bankcode', '$username')";
		$exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));

		if(isset($_POST['onaccount']))
		{
		
		if ($paymentmode == 'CASH')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CASH';
		//$cashamount = $paymentamount;
		//include ("transactioninsert1.php");
			
		$query9 = "insert into master_transactionpharmacy (transactioncode, transactiondate, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount, cashamount,taxamount,
		 ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule, approvalstatus,docno,suppliercode,recordstatus,transactionstatus,bankcode) 
		values ('$transactioncode', '$transactiondate', '$accountssubid', '$suppliername', 
		'$transactionmode', '$transactiontype', '$netpayable', '$netpayable', '$taxamount',
		'$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule', '$approvalstatus','$billnumbercode','$suppliercode','','onaccount','$bankcode')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$queryon = "insert into master_transactionaponaccount (`transactiondate`, `docno`, `particulars`, `suppliercode`, `suppliername`, `transactionmode`, `transactiontype`, 		        `transactionmodule`, `transactionamount`, 
		`adjamount`, `balanceamount`,`ipaddress`, `updatedate`, `recordstatus`, `companyanum`, `companyname`,`cashamount`,`bankcode`,locationcode)
		values('$transactiondate','$billnumbercode','onaccount','$suppliercode','$suppliername','$transactionmode','$transactiontype','$transactionmodule','$paymentamount',
		'$paymentamount','0.00','$ipaddress','$transactiondate','','$companyanum', '$companyname','$paymentamount','$bankcode','$locationcode1')"; 
		$execon = mysqli_query($GLOBALS["___mysqli_ston"], $queryon) or die ("Error in Queryon".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodecredit(billnumber,billdate,ipaddress,username,cash,cashcoa,source,transactionamount)values('$billnumbercode','$transactiondate','$ipaddress','$username','$netpayable','$cashcoa','supplierpaymententry','$netpayable')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	}
	if ($paymentmode == 'ONLINE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'ONLINE';
		//include ("transactioninsert1.php");
		$query9 = "insert into master_transactionpharmacy (transactioncode, transactiondate, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount, onlineamount,taxamount,
		ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule, approvalstatus,docno,suppliercode,recordstatus,transactionstatus,bankcode) 
		values ('$transactioncode', '$transactiondate', '$accountssubid', '$suppliername', 
		'$transactionmode', '$transactiontype', '$netpayable', '$netpayable', '$taxamount',
		'$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule', '$approvalstatus','$billnumbercode','$suppliercode','','onaccount','$bankcode')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$queryon = "insert into master_transactionaponaccount (`transactiondate`, `docno`, `particulars`, `suppliercode`, `suppliername`, `transactionmode`, `transactiontype`, 		        `transactionmodule`, `transactionamount`, 
		`adjamount`, `balanceamount`,`ipaddress`, `updatedate`, `recordstatus`, `companyanum`, `companyname`,`onlineamount`,`bankcode`,locationcode)
		values('$transactiondate','$billnumbercode','onaccount','$suppliercode','$suppliername','$transactionmode','$transactiontype','$transactionmodule','$paymentamount',
		'$paymentamount','0.00','$ipaddress','$transactiondate','','$companyanum', '$companyname','$paymentamount','$bankcode','$locationcode1')";
		$execon = mysqli_query($GLOBALS["___mysqli_ston"], $queryon) or die ("Error in Queryon".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodecredit(billnumber,billdate,ipaddress,username,online,onlinecoa,source,transactionamount)values('$billnumbercode','$transactiondate','$ipaddress','$username','$netpayable','$onlinecoa','supplierpaymententry','$netpayable')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	}
	
	if ($paymentmode == 'MPESA')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'MPESA';
		//include ("transactioninsert1.php");
		$query9 = "insert into master_transactionpharmacy (transactioncode, transactiondate, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount, mpesaamount,taxamount,
		ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule, approvalstatus,docno,suppliercode,recordstatus,transactionstatus,bankcode) 
		values ('$transactioncode', '$transactiondate', '$accountssubid', '$suppliername', 
		'$transactionmode', '$transactiontype', '$netpayable', '$netpayable', '$taxamount',
		'$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule', '$approvalstatus','$billnumbercode','$suppliercode','','onaccount','$bankcode')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$queryon = "insert into master_transactionaponaccount (`transactiondate`, `docno`, `particulars`, `suppliercode`, `suppliername`, `transactionmode`, `transactiontype`, 		        `transactionmodule`, `transactionamount`, 
		`adjamount`, `balanceamount`,`ipaddress`, `updatedate`, `recordstatus`, `companyanum`, `companyname`,`mpesaamount`,`bankcode`,locationcode)
		values('$transactiondate','$billnumbercode','onaccount','$suppliercode','$suppliername','$transactionmode','$transactiontype','$transactionmodule','$paymentamount',
		'$paymentamount','0.00','$ipaddress','$transactiondate','','$companyanum', '$companyname','$paymentamount','$bankcode','$locationcode1')";
		$execon = mysqli_query($GLOBALS["___mysqli_ston"], $queryon) or die ("Error in Queryon".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodecredit(billnumber,billdate,ipaddress,username,online,onlinecoa,source,transactionamount)values('$billnumbercode','$transactiondate','$ipaddress','$username','$netpayable','$onlinecoa','supplierpaymententry','$netpayable')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	}
	
		if ($paymentmode == 'CHEQUE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CHEQUE';
		$apndbankname=$_POST['apndbankname'];
		if($balanceamount >0){
		$app=0;
		 $query1 = "UPDATE `master_purchase` SET `approved_payment` = '0', `paymentvoucherno` = '$paymentvoucherno' WHERE `master_purchase`.`billnumber`  = '".$billnum."' and `master_purchase`.`suppliercode`  = '".$suppliercode."'";
		//$exec3 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		}
		else { $app=1;
		}
	
		//include ("transactioninsert1.php");
		$query9 = "insert into master_transactionpharmacy (transactioncode, transactiondate, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount,
		chequeamount,taxamount,chequenumber,
		chequedate, bankname, bankbranch, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule, approvalstatus,docno,suppliercode,recordstatus,transactionstatus,bankcode,approved_payment,appvdbank,appvdcheque,appvdchequedt) 
		values ('$transactioncode', '$transactiondate','$accountssubid', '$suppliername', 
		'$transactionmode', '$transactiontype', '$netpayable',
		'$netpayable', '$taxamount','$chequenumber',  
		'$chequedate', '$bankname', '$bankbranch','$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', 
		'$remarks', '$transactionmodule', '$approvalstatus','$billnumbercode','$suppliercode','','onaccount','$bankcode','$app','$apndbankname','$chequenumber','$chequedate')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$queryon = "insert into master_transactionaponaccount (`transactiondate`, `docno`, `particulars`, `suppliercode`, `suppliername`, `transactionmode`, `transactiontype`, 		        `transactionmodule`, `transactionamount`, 
		`adjamount`, `balanceamount`,`ipaddress`, `updatedate`, `recordstatus`, `companyanum`, `companyname`,`chequeamount`,`bankcode`,locationcode)
		values('$transactiondate','$billnumbercode','onaccount','$suppliercode','$suppliername','$transactionmode','$transactiontype','$transactionmodule','$paymentamount',
		'$paymentamount','0.00','$ipaddress','$transactiondate','','$companyanum', '$companyname','$paymentamount','$bankcode','$locationcode1')";
		$execon = mysqli_query($GLOBALS["___mysqli_ston"], $queryon) or die ("Error in Queryon".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodecredit(billnumber,billdate,ipaddress,username,cheque,chequecoa,source,transactionamount)values('$billnumbercode','$transactiondate','$ipaddress','$username','$netpayable','$chequecoa','supplierpaymententry','$netpayable')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		}
		
		}
		else
		{
		if ($paymentmode == 'CASH')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CASH';
		//$cashamount = $paymentamount;
		//include ("transactioninsert1.php");
		foreach($_POST['billnum'] as $key => $value)
		{

		$billnums=explode("@",$_POST['billnum'][$key]);
		$billnum=$billnums[0];
		
		$adjamount=$_POST['adjamount'][$key];
		$balamount=$_POST['balamount'][$key];
		$adjamount=str_replace(',', '', $adjamount);
		$balamount=str_replace(',', '', $balamount);
		$supplierbillnumber=$_POST['supplierbillnumber'][$key];
		$mrnno=$_POST['mrnno'][$key];
		$particulars = 'BY CASH (Inv NO:'.$billnumberprefix.$supplierbillnumber.')';	
		foreach($_POST['ack'] as $check)
		{
		$acknow=$check;
		if($acknow==$_POST['billnum'][$key])
		{
		if($balamount >0){
		$app=0;
		 $query1 = "UPDATE `master_purchase` SET `approved_payment` = '0', `paymentvoucherno` = '$paymentvoucherno' WHERE `master_purchase`.`billnumber`  = '".$billnum."' and `master_purchase`.`suppliercode`  = '".$suppliercode."'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		else {  $query1 = "UPDATE `master_purchase` SET `approved_payment` = '2', `paymentvoucherno` = '$paymentvoucherno' WHERE `master_purchase`.`billnumber`  = '".$billnum."' and `master_purchase`.`suppliercode`  = '".$suppliercode."'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		
		$query9 = "insert into master_transactionpharmacy (transactioncode, transactiondate, particulars, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount, cashamount,taxamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule, approvalstatus,docno,suppliercode,recordstatus,bankcode,paymentvoucherno,mrnno) 
		values ('$transactioncode', '$transactiondate', '$particulars', '$accountssubid', '$suppliername', 
		'$transactionmode', '$transactiontype', '$adjamount', '$adjamount', '$taxamount',
		'$billnum',  '$billanum', '$ipaddress', '$updatedate', '$balamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule', '$approvalstatus','$billnumbercode','$suppliercode','allocated','$bankcode','$paymentvoucherno','$mrnno')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$queryon = "insert into master_transactionaponaccount (`transactiondate`, `docno`, `particulars`, `suppliercode`, `suppliername`, `transactionmode`, `transactiontype`, 		        `transactionmodule`, `transactionamount`, 
		`adjamount`, `balanceamount`,`ipaddress`, `updatedate`, `recordstatus`, `companyanum`, `companyname`,`cashamount`,`bankcode`,locationcode)
		values('$transactiondate','$billnumbercode','onaccount','$suppliercode','$suppliername','$transactionmode','$transactiontype','$transactionmodule','$paymentamount',
		'$paymentamount','0.00','$ipaddress','$transactiondate','','$companyanum', '$companyname','$paymentamount','$bankcode','$locationcode1')";
		$execon = mysqli_query($GLOBALS["___mysqli_ston"], $queryon) or die ("Error in Queryon".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodecredit(billnumber,billdate,ipaddress,username,cash,cashcoa,source,transactionamount)values('$billnumbercode','$transactiondate','$ipaddress','$username','$adjamount','$cashcoa','supplierpaymententry','$adjamount')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	}
	}
	}
		}
		if ($paymentmode == 'ONLINE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'ONLINE';
				foreach($_POST['billnum'] as $key => $value)
		{
		
		$billnums3=explode("@",$_POST['billnum'][$key]);
		$billnum3=$billnums3[0];

		$adjamount=$_POST['adjamount'][$key];
		$balamount=$_POST['balamount'][$key];
		$adjamount=str_replace(',', '', $adjamount);
		$balamount=str_replace(',', '', $balamount);
		$supplierbillnumber=$_POST['supplierbillnumber'][$key];
		$mrnno=$_POST['mrnno'][$key];
		$particulars = 'BY ONLINE (Inv NO:'.$billnumberprefix.$supplierbillnumber.')';	
		foreach($_POST['ack'] as $check)
		{
		$acknow=$check;
		if($acknow==$_POST['billnum'][$key])
		{
		if($balamount >0){
		$app=0;
		 $query1 = "UPDATE `master_purchase` SET `approved_payment` = '0', `paymentvoucherno` = '$paymentvoucherno' WHERE `master_purchase`.`billnumber`  = '".$billnum3."' and `master_purchase`.`suppliercode`  = '".$suppliercode."'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		else {  $query1 = "UPDATE `master_purchase` SET `approved_payment` = '2', `paymentvoucherno` = '$paymentvoucherno' WHERE `master_purchase`.`billnumber`  = '".$billnum3."' and `master_purchase`.`suppliercode`  = '".$suppliercode."'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		
	//include ("transactioninsert1.php");
		$query9 = "insert into master_transactionpharmacy (transactioncode, transactiondate, particulars, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount, onlineamount,taxamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule, approvalstatus,docno,suppliercode,recordstatus,bankcode,paymentvoucherno,mrnno) 
		values ('$transactioncode', '$transactiondate', '$particulars', '$accountssubid', '$suppliername', 
		'$transactionmode', '$transactiontype', '$adjamount', '$adjamount', '$taxamount',
		'$billnum3',  '$billanum', '$ipaddress', '$updatedate', '$balamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule', '$approvalstatus','$billnumbercode','$suppliercode','allocated','$bankcode','$paymentvoucherno','$mrnno')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$queryon = "insert into master_transactionaponaccount (`transactiondate`, `docno`, `particulars`, `suppliercode`, `suppliername`, `transactionmode`, `transactiontype`, 		        `transactionmodule`, `transactionamount`, 
		`adjamount`, `balanceamount`,`ipaddress`, `updatedate`, `recordstatus`, `companyanum`, `companyname`,`onlineamount`,`bankcode`,locationcode)
		values('$transactiondate','$billnumbercode','onaccount','$suppliercode','$suppliername','$transactionmode','$transactiontype','$transactionmodule','$paymentamount',
		'$paymentamount','0.00','$ipaddress','$transactiondate','','$companyanum', '$companyname','$paymentamount','$bankcode','$locationcode1')";
		$execon = mysqli_query($GLOBALS["___mysqli_ston"], $queryon) or die ("Error in Queryon".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodecredit(billnumber,billdate,ipaddress,username,online,onlinecoa,source,transactionamount)values('$billnumbercode','$transactiondate','$ipaddress','$username','$adjamount','$onlinecoa','supplierpaymententry','$adjamount')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	}
	}
	}
		}
		
		if ($paymentmode == 'MPESA')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'MPESA';
				foreach($_POST['billnum'] as $key => $value)
		{
		//$billnum3=$_POST['billnum'][$key];

		$billnums3=explode("@",$_POST['billnum'][$key]);
		$billnum3=$billnums3[0];

		$adjamount=$_POST['adjamount'][$key];
		$balamount=$_POST['balamount'][$key];
		$adjamount=str_replace(',', '', $adjamount);
		$balamount=str_replace(',', '', $balamount);
		$supplierbillnumber=$_POST['supplierbillnumber'][$key];
		$mrnno=$_POST['mrnno'][$key];
		$particulars = 'BY MPESA (Inv NO:'.$billnumberprefix.$supplierbillnumber.')';	
		foreach($_POST['ack'] as $check)
		{
		$acknow=$check;
		if($acknow==$_POST['billnum'][$key])
		{
		if($balamount >0){
		$app=0;
		 $query1 = "UPDATE `master_purchase` SET `approved_payment` = '0', `paymentvoucherno` = '$paymentvoucherno' WHERE `master_purchase`.`billnumber`  = '".$billnum3."' and `master_purchase`.`suppliercode`  = '".$suppliercode."'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		else {  $query1 = "UPDATE `master_purchase` SET `approved_payment` = '2', `paymentvoucherno` = '$paymentvoucherno' WHERE `master_purchase`.`billnumber`  = '".$billnum3."' and `master_purchase`.`suppliercode`  = '".$suppliercode."'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
			
		//include ("transactioninsert1.php");
		$query9 = "insert into master_transactionpharmacy (transactioncode, transactiondate, particulars, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount, mpesaamount,taxamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule, approvalstatus,docno,suppliercode,recordstatus,bankcode,paymentvoucherno,mrnno) 
		values ('$transactioncode', '$transactiondate', '$particulars', '$accountssubid', '$suppliername', 
		'$transactionmode', '$transactiontype', '$adjamount', '$adjamount', '$taxamount',
		'$billnum3',  '$billanum', '$ipaddress', '$updatedate', '$balamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule', '$approvalstatus','$billnumbercode','$suppliercode','allocated','$bankcode','$paymentvoucherno','$mrnno')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$queryon = "insert into master_transactionaponaccount (`transactiondate`, `docno`, `particulars`, `suppliercode`, `suppliername`, `transactionmode`, `transactiontype`, 		        `transactionmodule`, `transactionamount`, 
		`adjamount`, `balanceamount`,`ipaddress`, `updatedate`, `recordstatus`, `companyanum`, `companyname`,`mpesaamount`,`bankcode`,locationcode)
		values('$transactiondate','$billnumbercode','onaccount','$suppliercode','$suppliername','$transactionmode','$transactiontype','$transactionmodule','$paymentamount',
		'$paymentamount','0.00','$ipaddress','$transactiondate','','$companyanum', '$companyname','$paymentamount','$bankcode','$locationcode1')";
		$execon = mysqli_query($GLOBALS["___mysqli_ston"], $queryon) or die ("Error in Queryon".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodecredit(billnumber,billdate,ipaddress,username,online,onlinecoa,source,transactionamount)values('$billnumbercode','$transactiondate','$ipaddress','$username','$adjamount','$onlinecoa','supplierpaymententry','$adjamount')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	}
	}
	}
		}
		
		if ($paymentmode == 'CHEQUE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CHEQUE';
		foreach($_POST['billnum'] as $key => $value)
		{
		$apndbankname=$_POST['apndbankname'];
		//$billnum1=$_POST['billnum'][$key];

		$billnums1=explode("@",$_POST['billnum'][$key]);
		$billnum1=$billnums1[0];

		$adjamount=$_POST['adjamount'][$key];
		$balamount=$_POST['balamount'][$key];
		$adjamount=str_replace(',', '', $adjamount);
		$balamount=str_replace(',', '', $balamount);
		$supplierbillnumber=$_POST['supplierbillnumber'][$key];
		$mrnno=$_POST['mrnno'][$key];
		$particulars = 'BY CHEQUE (Inv NO:'.$billnumberprefix.$supplierbillnumber.')';		
		foreach($_POST['ack'] as $check)
		{
		$acknow=$check;
		if($acknow==$_POST['billnum'][$key])
		{
		//include ("transactioninsert1.php");
		if($balamount >0){
		$app=0;
		 $query1 = "UPDATE `master_purchase` SET `approved_payment` = '0', `paymentvoucherno` = '$paymentvoucherno' WHERE `master_purchase`.`billnumber`  = '".$billnum1."' and `master_purchase`.`suppliercode`  = '".$suppliercode."'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		else {  $query1 = "UPDATE `master_purchase` SET `approved_payment` = '2', `paymentvoucherno` = '$paymentvoucherno' WHERE `master_purchase`.`billnumber`  = '".$billnum1."' and `master_purchase`.`suppliercode`  = '".$suppliercode."'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	
		$query9 = "insert into master_transactionpharmacy (transactioncode, transactiondate, particulars, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount,
		chequeamount,taxamount,chequenumber, billnumber, billanum, 
		chequedate, bankname, bankbranch, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule, approvalstatus,docno,suppliercode,recordstatus,bankcode,appvdbank,appvdcheque,appvdchequedt,paymentvoucherno,mrnno) 
		values ('$transactioncode', '$transactiondate', '$particulars', '$accountssubid', '$suppliername', 
		'$transactionmode', '$transactiontype', '$adjamount',
		'$adjamount', '$taxamount','$chequenumber',  '$billnum1',  '$billanum', 
		'$chequedate', '$bankname', '$bankbranch','$ipaddress', '$updatedate', '$balamount', '$companyanum', '$companyname', 
		'$remarks', '$transactionmodule', '$approvalstatus','$billnumbercode','$suppliercode','allocated','$bankcode','$apndbankname','$chequenumber','$chequedate','$paymentvoucherno','$mrnno')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$queryon = "insert into master_transactionaponaccount (`transactiondate`, `docno`, `particulars`, `suppliercode`, `suppliername`, `transactionmode`, `transactiontype`, 		        `transactionmodule`, `transactionamount`, 
		`adjamount`, `balanceamount`,`ipaddress`, `updatedate`, `recordstatus`, `companyanum`, `companyname`,`chequeamount`,`bankcode`,locationcode)
		values('$transactiondate','$billnumbercode','onaccount','$suppliercode','$suppliername','$transactionmode','$transactiontype','$transactionmodule','$paymentamount',
		'$paymentamount','0.00','$ipaddress','$transactiondate','','$companyanum', '$companyname','$paymentamount','$bankcode','$locationcode1')";
		$execon = mysqli_query($GLOBALS["___mysqli_ston"], $queryon) or die ("Error in Queryon".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "insert into paymentmodecredit(billnumber,billdate,ipaddress,username,cheque,chequecoa,source,transactionamount)values('$billnumbercode','$transactiondate','$ipaddress','$username','$adjamount','$chequecoa','supplierpaymententry','$adjamount')";
        $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		}
		}
		}
		}
		
		if ($paymentmode == 'WRITEOFF')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'WRITEOFF';
			foreach($_POST['billnum'] as $key => $value)
		{
		$billnums2=explode("@",$_POST['billnum'][$key]);
		$billnum2=$billnums2[0];

		//$billnum2=$_POST['billnum'][$key];
		$adjamount=$_POST['adjamount'][$key];
		$balamount=$_POST['balamount'][$key];
		$adjamount=str_replace(',', '', $adjamount);
		$balamount=str_replace(',', '', $balamount);
			$supplierbillnumber=$_POST['supplierbillnumber'][$key];
			$mrnno=$_POST['mrnno'][$key];
		$particulars = 'BY WRITEOFF (Inv NO:'.$billnumberprefix.$supplierbillnumber.')';		
	
		foreach($_POST['ack'] as $check)
		{
		$acknow=$check;
		if($acknow==$_POST['billnum'][$key])
		{
		
		if($balamount >0){
		$app=0;
		 $query1 = "UPDATE `master_purchase` SET `approved_payment` = '0', `paymentvoucherno` = '$paymentvoucherno' WHERE `master_purchase`.`billnumber`  = '".$billnum2."' and `master_purchase`.`suppliercode`  = '".$suppliercode."'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		else {  $query1 = "UPDATE `master_purchase` SET `approved_payment` = '2', `paymentvoucherno` = '$paymentvoucherno' WHERE `master_purchase`.`billnumber`  = '".$billnum2."' and `master_purchase`.`suppliercode`  = '".$suppliercode."'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		//include ("transactioninsert1.php");
		$query9 = "insert into master_transactionpharmacy (transactioncode, transactiondate, particulars, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount, writeoffamount,taxamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule, approvalstatus,suppliercode,recordstatus,docno,paymentvoucherno,mrnno) 
		values ('$transactioncode', '$transactiondate', '$particulars', '$accountssubid', '$suppliername', 
		'$transactionmode', '$transactiontype', '$adjamount', '$adjamount', '$taxamount',
		'$billnum2',  '$billanum', '$ipaddress', '$updatedate', '$balamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule', '$approvalstatus','$suppliercode','allocated','$billnumbercode','$paymentvoucherno','$mrnno')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		}
		}
		}
		}
	
	/*if($taxamount > 0)
	{
		$supplierbillno = $billnumbercode;
		$paynowbillprefix = 'WHT-';
		$paynowbillprefix1=strlen($paynowbillprefix);
		$query231 = "select * from master_purchase where typeofpurchase='WHT' order by auto_number desc limit 0, 1";
		$exec231 = mysql_query($query231) or die ("Error in Query231".mysql_error());
		$res231 = mysql_fetch_array($exec231);
		$billnumber = $res231["billnumber"];
		$billdigit=strlen($billnumber);
		if ($billnumber == '')
		{
			$billnumbercode1 ='WHT-'.'1'.'-'.$locationprefix;
			$openingbalance = '0.00';
		}
		else
		{
			$billnumber = $res231["billnumber"];
			$billnumbercode1 = substr($billnumber,$paynowbillprefix1, $billdigit);
			//echo $billnumbercode1;
			$billnumbercode1 = intval($billnumbercode1);
			$billnumbercode1 = $billnumbercode1 + 1;
		
			$maxanum = $billnumbercode1;
			
			
			$billnumbercode1 = 'WHT-' .$maxanum.'-'.$locationprefix;
			$openingbalance = '0.00';
			//echo $companycode;
		}

		$transactiontype = 'PURCHASE';
		$transactionmode = 'BILL';
		$particulars = 'BY PURCHASE (Inv NO:'.$billnumbercode1.$supplierbillnumber.')';	
		//include ("transactioninsert1.php");
		$query9 = "insert into master_transactionpharmacy (transactiondate, particulars, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount,
		billnumber, billanum, ipaddress, updatedate,  companyanum, companyname, transactionmodule,suppliercode, wht_ledgercode, wht_ledger,paymentvoucherno,chequenumber) 
		values ('$transactiondate', '$particulars', '$accountssubid', 'W/tax Payable', 
		'$transactionmode', '$transactiontype', '$taxamount', 
		'$billnumbercode1',  '$billautonumber', '$ipaddress', '$updatedate', '$companyanum', '$companyname', '$transactionmodule1','07-4001','03-1015-AE','SUPPLIER WITHHOLDING','$paymentvoucherno','$chequenumber')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		$query334 = "insert into master_purchase (companyanum, billnumber, billdate, suppliercode, suppliername,totalamount,totalquantity,ipaddress,supplierbillnumber,typeofpurchase,currency,fxrate,totalfxamount,locationcode,locationname,purchaseamount)values('$companyanum','$billnumbercode1','$transactiondate','07-4001', 'W/tax Payable','$taxamount','1','$ipaddress','$supplierbillno','WHT','$currency','$fxrate','$taxamount','$locationcode','$locationname','$taxamount')";
		$exec334 = mysql_query($query334) or die(mysql_error());
	} */
    }
    ?>
	<script>
		window.open("print_paymententry.php?billnumber=<?php echo $billnumbercode; ?>", "OriginalWindow", 'width=522,height=650,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
		window.open("paymententry1.php?st=success","_self")
	</script>

	<?php
	    exit;
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }


if ($st == 'success')
{
	$errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Payment Entry Not Completed.";
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
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

function cbsuppliername1()
{
	document.cbform1.submit();
}
function amountcheck()
{
}
</script>
<script type="text/javascript" src="js/autocomplete_supplier12.js"></script>
<script type="text/javascript" src="js/autosuggest2supplier1.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
}


function disableEnterKey(varPassed)
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}

	if(key == 13) // if enter key press
	{
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}
}


function process1backkeypress1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}

function disableEnterKey()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}
	
	if(key == 13) // if enter key press
	{
		return false;
	}
	else
	{
		return true;
	}

}

function paymententry1process2()
{
	if (document.getElementById("cbfrmflag1").value == "")
	{
		alert ("Search Bill Number Cannot Be Empty.");
		document.getElementById("cbfrmflag1").focus();
		document.getElementById("cbfrmflag1").value = "<?php echo $cbfrmflag1; ?>";
		return false;
	}
}

function paymententry1process1()
{
	//alert ("inside if");
	document.getElementById("formsubmit01").disabled=true;
	if (document.getElementById("paymentamount").value == "")
	{
		alert ("Payment Amount Cannot Be Empty.");
		document.getElementById("paymentamount").focus();
		document.getElementById("paymentamount").value = "0.00"
		document.getElementById("formsubmit01").disabled=false;
		return false;
	}
	if (document.getElementById("paymentamount").value == "0.00")
	{
		alert ("Payment Amount Cannot Be Empty.");
		document.getElementById("paymentamount").focus();
		document.getElementById("paymentamount").value = "0.00"
		document.getElementById("formsubmit01").disabled=false;
		return false;
	}
	var numbers =/^[a-zA-Z]+$/;
	if ((document.getElementById("paymentamount").value.match(numbers)))
	{
		alert ("Payment Amount Can Only Be Numbers.");
		document.getElementById("paymentamount").focus();
		document.getElementById("formsubmit01").disabled=false;
		return false;
	}
	if (document.getElementById("paymentmode").value == "")
	{
		alert ("Please Select Payment Mode.");
		document.getElementById("paymentmode").focus();
		document.getElementById("formsubmit01").disabled=false;
		return false;
	}
	if (document.getElementById("paymentmode").value == "CHEQUE")
	{
		if(document.getElementById("chequenumber").value == "")
		{
			alert ("If Payment By Cheque, Then Payment Number Cannot Be Empty.");
			document.getElementById("chequenumber").focus();
			document.getElementById("formsubmit01").disabled=false;
			return false;
		} 
	}
	

	
	if(document.getElementById("paymentmode").value == "CHEMPESAQUE"){
	if(document.getElementById("chequenumber").value == "")
		{
		alert ("If Payment By Mpesa, Then Payment Number Cannot Be Empty.");
		document.getElementById("chequenumber").focus();
		document.getElementById("formsubmit01").disabled=false;
	    return false;
		}
	}
		
	if (document.getElementById("bankname").value == "")
	{
		alert ("Account Name Cannot Be Empty.");
		document.getElementById("bankname").focus();
		document.getElementById("formsubmit01").disabled=false;
		return false;
	}
	
	
	
	
	
	
	var fRet; 
	fRet = confirm('Are you sure want to save this payment entry?'); 
	//return false;
	//alert(fRet); 
	//alert(document.getElementById("paymentamount").value); 
	//alert(document.getElementById("pendingamounthidden").value); 
	if (fRet == true)
	{
		var varPaymentAmount = document.getElementById("paymentamount").value; 
		var varPaymentAmount = varPaymentAmount * 1;
		var varPendingAmount = document.getElementById("pendingamounthidden").value; 
		var varPendingAmount = parseInt(varPendingAmount);
		var varPendingAmount = varPendingAmount * 1;
		//alert (varPendingAmount);
		/*
		if (varPaymentAmount > varPendingAmount)
		{
			alert('Payment Amount Is Greater Than Pending Amount. Entry Cannot Be Saved.'); 
			alert ("Payment Entry Not Completed.");
			return false;
		}
		*/
	}
	if (fRet == false)
	{
		alert ("Payment Entry Not Completed.");
		document.getElementById("formsubmit01").disabled=false;
		return false;
	}
		
	// window.scrollTo(0,0);
	// document.getElementById("formloader").style.display = "";
	// document.body.style.overflow='auto';
	//return false;
	
}

function funcPrintReceipt1()
{
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

</script>
<script>
function updatebox1(varSerialNumber,billamt,totalcount1, chequeno, bankname, remarks, pvno, taxamt)
{
	document.getElementById("acknow"+varSerialNumber+"").checked = true;
}
function updatebox(varSerialNumber,billamt,totalcount1, chequeno, bankname, remarks, pvno, taxamt)
{
	document.getElementById("acknow"+varSerialNumber+"").checked = true;
if(document.getElementById("onaccount").checked == true)
{
alert("Dont Select Invoice");
document.getElementById("acknow"+varSerialNumber+"").checked = false;
return false;
}
var adjamount1;
var grandtotaladjamt2=0;
var varSerialNumber = varSerialNumber;
var totalcount1=document.getElementById("totcount").value;
document.getElementById("chequenumber").value = chequeno;

document.getElementById("apndbankname").options.length=null; 
var combo = document.getElementById('apndbankname'); 
combo.options[<?php echo '0';?>] = new Option (bankname, bankname); 
//document.getElementById("apndbankname").value = bankname;

document.getElementById("remarks").value = remarks;
document.getElementById("paymentvoucherno").value = pvno;
document.getElementById("taxamount").value = taxamt;
var billamt = billamt;
  var textbox = document.getElementById("adjamount"+varSerialNumber+"");
    textbox.value = "";
if(document.getElementById("acknow"+varSerialNumber+"").checked == true)
{
    if(document.getElementById("acknow"+varSerialNumber+"").checked) {
        textbox.value = billamt;
    }
	var balanceamt=billamt-billamt;
	document.getElementById("balamount"+varSerialNumber+"").value=balanceamt.toFixed(2);
	var totalbillamt=document.getElementById("paymentamount").value;
	var totalbillamt=document.getElementById("paymentamount").value;
	totalbillamt=totalbillamt.replace(/,/g,'');
	if(totalbillamt == 0.00)
{
totalbillamt=0;
}
				totalbillamt=parseFloat(totalbillamt)+parseFloat(billamt);
			
totalbillamt = totalbillamt.toFixed(2);
totalbillamt = totalbillamt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
document.getElementById("paymentamount").value = totalbillamt;
document.getElementById("netpayable").value = totalbillamt;
document.getElementById("totaladjamt").value=totalbillamt;
}
else
{
//alert(totalcount1);
for(j=1;j<=totalcount1;j++)
{
var totaladjamount2=document.getElementById("adjamount"+j+"").value;

if(totaladjamount2 == "")
{
totaladjamount2=0;
}
grandtotaladjamt2=grandtotaladjamt2+parseFloat(totaladjamount2);
}
//alert(grandtotaladjamt);
document.getElementById("paymentamount").value = grandtotaladjamt2.toFixed(2);
document.getElementById("netpayable").value = grandtotaladjamt2.toFixed(2);
document.getElementById("totaladjamt").value=grandtotaladjamt2.toFixed(2);

 }  
}
function checkboxcheck(varSerialNumber5)
{

if(document.getElementById("acknow"+varSerialNumber5+"").checked == false)
{
alert("Please click on the Select check box");
return false;
}
return true;
}
function balancecalc(varSerialNumber1,billamt1,totalcount)
{
var varSerialNumber1 = varSerialNumber1;

var billamt1 = billamt1;
var totalcount=document.getElementById("totcount").value;
//alert(totalcount);
var grandtotaladjamt=0;
var adjamount=document.getElementById("adjamount"+varSerialNumber1+"").value;
var adjamount3=parseFloat(adjamount);
if(adjamount3 > billamt1)
{
alert("Please enter correct amount");
document.getElementById("paymentamount").value = '0.00';
document.getElementById("totaladjamt").value = '0.00';
document.getElementById("adjamount"+varSerialNumber1+"").value = '0.00';
document.getElementById("balamount"+varSerialNumber1+"").value = billamt1;
document.getElementById("adjamount"+varSerialNumber1+"").focus();
return false;
}
var balanceamount=parseFloat(billamt1)-parseFloat(adjamount);
balanceamount = balanceamount.toFixed(2);
balanceamount = balanceamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
document.getElementById("balamount"+varSerialNumber1+"").value=balanceamount;

for(i=1;i<=totalcount;i++)
{
var totaladjamount=document.getElementById("adjamount"+i+"").value;
if(totaladjamount == "")
{
totaladjamount=0;
}
grandtotaladjamt=grandtotaladjamt+parseFloat(totaladjamount);
}
//alert(grandtotaladjamt);
grandtotaladjamt = grandtotaladjamt.toFixed(2);
grandtotaladjamt = grandtotaladjamt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
document.getElementById("paymentamount").value = grandtotaladjamt;
document.getElementById("netpayable").value = grandtotaladjamt;
document.getElementById("totaladjamt").value=grandtotaladjamt;
var tax = document.getElementById("taxanum").value;
if(tax != '')
{
var paymentamount = document.getElementById("paymentamount").value;
<?php
$query1 = "select * from master_withholding_tax where record_status = '1' order by auto_number";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1taxname = $res1["name"];
						$res1taxpercent = $res1["tax_percent"];
						$res1anum = $res1["auto_number"];
						?>
						if(tax == "<?php echo $res1anum; ?>")
						{
						taxpercent = "<?php echo $res1taxpercent; ?>";
						}
						<?php
	}
	
	?>
	
	taxamount = (paymentamount * taxpercent)/100;
	var netpayable = paymentamount - taxamount;
	document.getElementById("taxamount").value = taxamount.toFixed(2);
	document.getElementById("netpayable").value = netpayable.toFixed(2);
}
}

function checkvalid(totcount)
{
var totcount=totcount;

for(j=1;j<=totcount;j++)
{
if(document.getElementById("acknow"+j+"").checked == true)
{
alert("Please deselect invoice");

return false;
}
}
return true;


}

function netpayablecalc()
{
var taxamount;
var taxpercent;
if(document.getElementById("whton").value == "")
{
	alert("Select WHT Condition");
	document.getElementById("taxanum").value = "";
	document.getElementById("whton").focus();
	return false;
}
var paymentamount = document.getElementById("pretax").value;
paymentamount=paymentamount.replace(/,/g,'');
var tax = document.getElementById("taxanum").value;
<?php
$query1 = "select * from master_withholding_tax where record_status = '1' order by auto_number";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1taxname = $res1["name"];
						$res1taxpercent = $res1["tax_percent"];
						$res1anum = $res1["auto_number"];
						?>
						if(tax == "<?php echo $res1anum; ?>")
						{
						taxpercent = "<?php echo $res1taxpercent; ?>";
						}
						<?php
	}
	
	?>
	
	taxamount = (paymentamount * taxpercent)/100;
	var tax16 = document.getElementById("tax16").value;
	tax16=tax16.replace(/,/g,'');
	var netpayable = parseFloat(paymentamount) - parseFloat(taxamount) + parseFloat(tax16);
	document.getElementById("taxamount").value = taxamount.toFixed(2);
	document.getElementById("netpayable").value = netpayable.toFixed(2);
	
}
function balances()
{
	/*var balance = 0;
	var mode = document.getElementById("paymentmode").value;
	if(mode == 'CASH'){
		<?php
		    
			/*$querydcash = "SELECT SUM(cash) AS totalcash FROM paymentmodedebit";
			$execdcash = mysql_query($querydcash) or die(mysql_error());
			$resdcash= mysql_fetch_array($execdcash);
			$debitcash =  $resdcash['totalcash'];
			$queryccash = "SELECT SUM(cash) AS totalccash FROM paymentmodecredit";
			$execccash = mysql_query($queryccash) or die(mysql_error());
			$resccash= mysql_fetch_array($execccash);
			$creditcash =  $resccash['totalccash'];
			$balance=$debitcash-$creditcash*/
		?>
			
			var balance = '<?php echo number_format($balance,2,'.',','); ?>';
			document.getElementById("balamount").style.display='block';
			document.getElementById("balanc").style.display='block';
			document.getElementById("balanc").value = balance;
//			alert(balance);	
			if((document.getElementById("paymentamount").value) >= balance){ alert("The expense amount should be less than of balance amount"); }	
	}
	else{document.getElementById("balanc").value = balance;document.getElementById("balamount").style.display='none';document.getElementById("balanc").style.display='none';}*/
}

function whtcalc()
{
 var whton = document.getElementById("whton").value;
 if(whton == 1)
 {
	 var paymentamount = document.getElementById("paymentamount").value;
	 paymentamount=paymentamount.replace(/,/g,'');
	 var pretax = parseFloat(paymentamount) / parseFloat(1.16);
	 var tax16 = parseFloat(pretax) * parseFloat(0.16);
	 tax16 = tax16.toFixed(2);
	 var tot1 = parseFloat(paymentamount) - parseFloat(tax16);
	 tot1 = tot1.toFixed(2);
	 document.getElementById("tax16").value = tax16;
	 document.getElementById("pretax").value = tot1;
	 document.getElementById("netpayable").value = tot1;
 }
 else if(whton == 2)
 {
	 var paymentamount = document.getElementById("paymentamount").value;
	 paymentamount=paymentamount.replace(/,/g,'');
	 paymentamount=parseFloat(paymentamount);
	 paymentamount=paymentamount.toFixed(2);
	 var pretax = parseFloat(paymentamount) / parseFloat(1.16);
	 var tax16 = parseFloat(pretax) * parseFloat(0.16);
	 tax16 = tax16.toFixed(2);
	 var tot1 = parseFloat(paymentamount) - parseFloat(tax16);
	 tot1 = tot1.toFixed(2);
	 document.getElementById("tax16").value = '0.00';
	 document.getElementById("pretax").value = paymentamount;
	 document.getElementById("netpayable").value = paymentamount;
 }
 //alert(tax16);
}

function validchk(){

var fRet; 
	fRet = confirm('Are you sure want to save this payment entry?'); 
	
	if (fRet == false)
	{
		return false;
	}


}
</script>
<?php

$query765 = "select * from master_financialintegration where field='cashsupplierpaymententry'";
$exec765 = mysqli_query($GLOBALS["___mysqli_ston"], $query765) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res765= mysqli_fetch_array($exec765);

$cashcoa = $res765['code'];


$query766 = "select * from master_financialintegration where field='chequesupplierpaymententry'";
$exec766 = mysqli_query($GLOBALS["___mysqli_ston"], $query766) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res766 = mysqli_fetch_array($exec766);

$chequecoa = $res766['code'];


$query767 = "select * from master_financialintegration where field='mpesasupplierpaymententry'";
$exec767 = mysqli_query($GLOBALS["___mysqli_ston"], $query767) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res767 = mysqli_fetch_array($exec767);

$mpesacoa = $res767['code'];

$query768 = "select * from master_financialintegration where field='cardsupplierpaymententry'";
$exec768 = mysqli_query($GLOBALS["___mysqli_ston"], $query768) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res768 = mysqli_fetch_array($exec768);

$cardcoa = $res768['code'];

$query769 = "select * from master_financialintegration where field='onlinesupplierpaymententry'";
$exec769 = mysqli_query($GLOBALS["___mysqli_ston"], $query769) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res769 = mysqli_fetch_array($exec769);

$onlinecoa = $res769['code'];

$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'SPE-';
$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select * from master_transactionpharmacy where transactiontype='PAYMENT' and transactionmodule ='PAYMENT' and docno LIKE '%SPE%' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='SPE-'.'1';
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
	
	
	$billnumbercode = 'SPE-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

if($username_auto_number!=""){
 $billnumbercode.="-".$username_auto_number;
}

?>
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
.formloader { background-color:#FFFFFF; }
#formloader { background-color:#000; }
#formloader1 {
    position: absolute;
    top: 158px;
    left: 487px;
    width: 28%;
    height: 24%;
}
</style>
</head>

<script src="js/datetimepicker_css_fin.js"></script>

<body>
<div align="center" class="formloader" id="formloader" style="display:none;">
<div align="center" class="formloader" id="formloader1" style="display:;">
<p style="text-align:center;"><strong>Saving <br><br> Please Wait...</strong></p>
<img src="images/ajaxloader.gif">
</div>
</div>
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
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="paymententry1.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Payment Entry     - Select Supplier </strong></td>
              </tr>
            <tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
              </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Supplier </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" readonly size="50" autocomplete="off">
              </span></td>
              </tr>
            <tr>
              <td width="18%"  align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> Supplier </td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input value="<?php echo $cbsuppliername; ?>" name="cbsuppliername" type="text" id="cbsuppliername" readonly onKeyDown="return disableEnterKey()" size="50" ></td>
              </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" value="<?php echo $suppliercode; ?>" style="border: 1px solid #001E6A; text-transform:uppercase" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
             
                  <!--<input  type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" />-->
                  </td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
          <tbody>
           <!-- <tr>
              <td width="4%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="30%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="14%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="14%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="13%" bgcolor="#ecf0f5" class="bodytext31"><strong>Opening Balance </strong></td>
              <td width="12%" bgcolor="#ecf0f5" class="bodytext31"><div align="right">
                <?php 
			  echo number_format($openingbalance, 2); 
			  ?>
              </div></td>
            </tr>-->
            <!--<tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong> Supplier </strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>By Purchase </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>By Payments </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>By Adjustment </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>By Balance </strong></div></td>
            </tr>-->
			<?php

			if($res2suppliername == '')
			{
			$purchasebalance = 0.00;
			}
			
			?>
          </tbody>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="4%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="30%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="14%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="14%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="13%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="12%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong> Supplier </strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>By Purchase Return </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>By Payments </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>By Adjustment </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>By Balance </strong></div></td>
            </tr>
            <?php
			
/*			$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
*/
			$transactionamount = "0.00";
			$totalpurchase = "0.00";
			$cashamount1 = "0.00";
			$onlineamount1 = "0.00";
			$chequeamount1 = "0.00";
			$cardamount1 = "0.00";
			$tdsamount1 = "0.00";
			$writeoffamount1 = "0.00";
			$taxamount1 = "0.00";
			$cashamount2 = "0.00";
			$cardamount2 = "0.00";
			$onlineamount2 = "0.00";
			$chequeamount2 = "0.00";
			$tdsamount2 = "0.00";
			$writeoffamount2 = "0.00";
			$taxamount2 = "0.00";
			$totalpayments = "0.00";
			$netpayments = "0.00";
			$balanceamount = "0.00";
			
			
			$query2 = "select * from master_transactionpharmacy where suppliercode = '$suppliercode' and recordstatus = ''  group by suppliercode";// and cstid='$custid' and cstname='$custname'";//  order by transactiondate desc";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res2 = mysqli_fetch_array($exec2))
			{
			$res2anum = $res2['supplieranum'];
			$res2suppliername = $res2['suppliername'];
			if ($supplieranum != 0)
			{
			$query3 = "select * from master_transactionpharmacy where transactiontype = 'PURCHASE RETURN' and transactionmodule = 'PURCHASE RETURN' and suppliercode = '$suppliercode' and recordstatus = ''";// and cstid='$custid' and cstname='$custname'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res3 = mysqli_fetch_array($exec3))
			{
				$transactionamount = $res3['transactionamount'];
				$totalpurchase = $totalpurchase + $transactionamount;
			}
		
			$query3 = "select * from master_transactionpharmacy where transactiontype = 'COLLECTION' and transactionmodule = 'PURCHASE RETURN' and suppliercode = '$suppliercode' and recordstatus = ''";// and cstid='$custid' and cstname='$custname'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res3 = mysqli_fetch_array($exec3))
			{
				$cashamount1 = $res3['cashamount'];
				$onlineamount1 = $res3['onlineamount'];
				$chequeamount1 = $res3['chequeamount'];
				$cardamount1 = $res3['cardamount'];
				$tdsamount1 = $res3['tdsamount'];
				$writeoffamount1 = $res3['writeoffamount'];
				$taxamount1 = $res3['taxamount'];
				
				$cashamount2 = $cashamount2 + $cashamount1;
				$cardamount2 = $cardamount2 + $cardamount1;
				$onlineamount2 = $onlineamount2 + $onlineamount1;
				$chequeamount2 = $chequeamount2 + $chequeamount1;
				$tdsamount2 = $tdsamount2 + $tdsamount1;
				$writeoffamount2 = $writeoffamount2 + $writeoffamount1;
				$taxamount2 = $taxamount2 + $taxamount1;
			}
			
			$totalpayments = $cashamount2 + $chequeamount2 + $onlineamount2 + $cardamount2 + $taxamount2;
			$netpayments = $totalpayments + $tdsamount2 + $writeoffamount2;
			$balanceamount = $totalpurchase - $netpayments;
			
			//netpayments
			if ($res2suppliername != '')
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

			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2suppliername; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalpurchase, 2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalpayments, 2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($writeoffamount2, 2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($balanceamount, 2,'.',','); ?></div></td>
            </tr>
            <?php
			}
			}
			}
			$purchasereturnbalance = $balanceamount;
			//$purchasebalance;
			$actualbalance = $purchasebalance - $purchasereturnbalance;
			
			?>
          </tbody>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
		
		
		
				<form name="form1" id="form1" method="post" action="paymententry1.php" onSubmit="return paymententry1process1()">
			  <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                 <tbody>
				
				<?php
				if($suppliername != '') {
				//include("rowcount.php");
				}
				?>
                  <tr bgcolor="#011E6A">
                    <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Payment  Entry - Details </strong></td>
                    <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                    <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">
					<strong> <?php //echo number_format($openingbalance, 2).' + '.number_format($purchasebalance, 2).' - '.number_format($purchasereturnbalance, 2).' = '.number_format($actualbalance + $openingbalance, 2); ?></strong></td>
                  </tr>
                  <tr>
                    <td colspan="8" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#FFFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
                  </tr>
				  <tr>
				  <td align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
				  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><b id="balamount" style="display:none">Balance Amount:</b></td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input type="text" id="balanc" readonly value="" style="border:none;display:none;"></td>
				  </tr>
				  <tr>
                    <td width="17%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Doc No </td>
                    <td width="29%" align="left" valign="top"  bgcolor="#FFFFFF"><strong><?php echo $billnumbercode; ?></strong></td>
					<td align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
					</tr>
                  <tr>
                    <td width="17%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Total Pending Amount </td>
                    <td width="29%" align="left" valign="top"  bgcolor="#FFFFFF">
					<input name="pendingamount" id="pendingamount" style="border: 1px solid #001E6A; text-align:right" value="<?php //echo number_format($actualbalance + $openingbalance, 2, '.', ','); ?>"  size="20" readonly onKeyDown="return disableEnterKey()" />
				<input type="hidden" name="cashcoa" value="<?php echo $cashcoa; ?>">
				<input type="hidden" name="chequecoa" value="<?php echo $chequecoa; ?>">
				<input type="hidden" name="mpesacoa" value="<?php echo $mpesacoa; ?>">
				<input type="hidden" name="cardcoa" value="<?php echo $cardcoa; ?>">
				<input type="hidden" name="onlinecoa" value="<?php echo $onlinecoa; ?>">
				<input type="hidden" name="suppliercode" value="<?php echo $suppliercode; ?>">
	
					<input name="pendingamounthidden" id="pendingamounthidden" type="hidden" value="<?php echo $balanceamount; ?>"  size="20" readonly onKeyDown="return disableEnterKey()" />					</td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Entry Date (YYYY-MM-DD) </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<input name="paymententrydate" id="paymententrydate" style="border: 1px solid #001E6A" value="<?php echo $updatedatetime; ?>"  readonly="readonly" onKeyDown="return disableEnterKey()" size="20" />
					<img src="images2/cal.gif" onClick="javascript:NewCssCal('paymententrydate','','','','','','past','<?= $finfromyear; ?>','<?= $fintoyear; ?>')" style="cursor:pointer"/></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Supplier Amount </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<input name="paymentamount" id="paymentamount" style="border: 1px solid #001E6A; text-align:right" value="<?php echo $approved_amount; ?>" readonly size="20" onKeyUp="return netpaycalc();" onChange="balances();"/></td>
                     <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><!--WHT Condition--> </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<!--<select name="whton" id="whton" style="width: 130px;" onChange="return whtcalc()">
                        <option value="" selected="selected">SELECT</option>
                        <option value="1">ON ORIGINAL</option>
                        <option value="2">ON TOTAL</option>
                    </select>--></td>
                  </tr>
				 <!-- <tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Pre Tax Amount </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<input name="pretax" id="pretax" style="border: 1px solid #001E6A; text-align:right" value="0.00"  size="20" readonly/></td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">VAT @ 16%</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<input name="tax16" id="tax16" style="border: 1px solid #001E6A; text-align:right" value="0.00"  size="20" readonly/></td>
                  </tr>-->
				  <input type='hidden' name="whton" id="whton" style="border: 1px solid #001E6A; text-align:right" value=""  size="20" readonly/>
				  <input type='hidden' name="pretax" id="pretax" style="border: 1px solid #001E6A; text-align:right" value="0"  size="20" readonly/>
				  <input type='hidden' name="tax16" id="tax16" style="border: 1px solid #001E6A; text-align:right" value="0"  size="20" readonly/>
				  
				  <!-- <tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Select Applicable WHT </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<select id="taxanum" name="taxanum" onChange="return netpayablecalc()">
                          <option value="">Select Tax</option>
                          <?php
						$query1 = "select * from master_withholding_tax where record_status = '1' order by auto_number";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1taxname = $res1["name"];
						$res1taxpercent = $res1["tax_percent"];
						$res1anum = $res1["auto_number"];
						?>
                          <option value="<?php echo $res1anum; ?>"><?php echo $res1taxname.' ( '.$res1taxpercent.'% ) '; ?></option>
                          <?php
						}
						?>
                        </select></td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Tax Amount </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="taxamount" id="taxamount" style="border: 1px solid #001E6A; text-align:right" value="<?php echo $appvdtaxamount; ?>"  size="20" readonly/></td>
                  </tr>-->
				  <input type='hidden' name="taxamount" id="taxamount" style="border: 1px solid #001E6A; text-align:right" value=""  size="20" readonly/>
				  <input type='hidden' name="taxanum" id="taxanum" style="border: 1px solid #001E6A; text-align:right" value=""  size="20" readonly/>
				  <tr>
				  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Net Payable </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="netpayable" id="netpayable" style="border: 1px solid #001E6A; text-align:right" value="<?php echo number_format($approved_amount-$appvdtaxamount,2,'.',''); ?>"  size="20" readonly/></td>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Payment Mode </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<select name="paymentmode" id="paymentmode" style="width: 130px;" onChange="balances();">
					
                        <option value="" selected="selected">SELECT</option>
                        <option value="CHEQUE"<?php if($appvdpaymentmode=='CHEQUE') echo ' selected'; ?>>CHEQUE</option>
                        <option value="CASH"<?php if($appvdpaymentmode=='CASH') echo ' selected'; ?>>CASH</option>
						<option value="MPESA"<?php if($appvdpaymentmode=='MPESA') echo ' selected'; ?>>MPESA</option>
                        <!--<option value="TDS">TDS</option>-->
                        <option value="ONLINE"<?php if($appvdpaymentmode=='ONLINE') echo ' selected'; ?>>ONLINE</option>
                        <option value="WRITEOFF"<?php if($appvdpaymentmode=='WRITEOFF') echo ' selected'; ?>>ADJUSTMENT</option>
                    </select></td>  
				  </tr>
				  
                  <tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Payment Number </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<input name="chequenumber" id="chequenumber" style="border: 1px solid #001E6A" value="<?php echo $appvdcheque; ?>"  size="20" /></td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Account Name </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><!--<input name="bankname" id="bankname" style="border: 1px solid #001E6A" value=""  size="20" />-->
					<select name="bankname" id="bankname">
					<option value="">Select Account</option>
					<?php 
					$querybankname = "select accountname, id from master_accountname where accountsmain = '2' and accountssub IN ('7','8','9') and recordstatus <> 'deleted'";
					$execbankname = mysqli_query($GLOBALS["___mysqli_ston"], $querybankname) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($resbankname = mysqli_fetch_array($execbankname))
					{?>
						<option value="<?php echo $resbankname['id'].'||'.$resbankname['accountname']; ?>"><?php echo $resbankname['accountname']; ?></option>
					<?php
					}
					?>
					</select></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Cheque  Date </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $appvdchequedt; ?>"  size="20"  readonly="readonly" onKeyDown="return disableEnterKey()"/>
					<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1','','','','','','past','<?= $finfromyear; ?>','<?= $fintoyear; ?>')" style="cursor:pointer"/>
				    </td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Remarks</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="remarks" id="remarks" style="border: 1px solid #001E6A" value="<?php echo $remarks; ?>" readonly size="20" />
					<input type="hidden" name="paymentvoucherno" id="paymentvoucherno" value="<?php echo $paymentvoucherno; ?>"></td>
                  </tr>
                  <tr>
				   					
					
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">ON Account</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input type="checkbox" name="onaccount" id="onaccount" onClick="return checkvalid('<?php echo $number; ?>');" disabled></td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
					<td align="left" valign="middle" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
					</tr><tr>
					
					
					<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Bank Name </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><!--<input name="bankname" id="bankname" style="border: 1px solid #001E6A" value=""  size="20" />-->
					<select name="apndbankname" id="apndbankname">
				
					<?php 
					$querybankname = "select * from master_bank where bankstatus!='Deleted'";
					$execbankname = mysqli_query($GLOBALS["___mysqli_ston"], $querybankname) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($resbankname = mysqli_fetch_array($execbankname))
					{
				 if($bankname == $resbankname['bankname']) { 
					?>
						<option value="<?php echo $resbankname['bankname']; ?>" <?php if($bankname == $resbankname['bankname']) { echo "selected"; } ?>><?php echo $resbankname['bankname']; ?></option>
					<?php
					}
					}
					
					?>
					</select></td>
<td align="left" valign="middle" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>


                    <td align="left" valign="top"  bgcolor="#FFFFFF"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                      <input type="hidden" name="cbfrmflag2" value="<?php echo $supplieranum; ?>">
                       <input type="hidden" name="locationcode" id="locationcode" value="<?= $locationcode?>">
                      <input type="hidden" name="frmflag2" value="frmflag2">
                      <input name="Submit" type="submit" id="formsubmit01"  value="Save Payment" class="button" style="border: 1px solid #001E6A" />
                    </font></td>
                  </tr>
                </tbody>
              </table>
			 	</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  <tr>
        <td>
		
		
		
		
		
		
<?php
	
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
		$cbsuppliername = $arraysuppliername;
		$suppliername = $arraysuppliername;
		$suppliercode = $arraysuppliercode;
	
	
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
            <tr>
              <td colspan="3" bgcolor="#ecf0f5" class="bodytext311"><strong><?php echo $suppliername; ?></strong></td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
			  <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
         <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
          <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
		  <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
          <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
           <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            </tr>
            <tr>
              <td width="5%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><strong>No.</strong></td>
				  <td width="6%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><strong>Select</strong></td>
              <td width="9%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><strong> Supplier Inv No</strong></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Doc No </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" width="8%" 
                bgcolor="#ffffff"><div align="left"><strong>Bill Date </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Bill Amt </strong></div></td>
                 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong>WHT VAT</strong></div></td>

				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong>WHT TAX</strong></div></td>

				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Net.Amt</strong></div></td>

              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong> After Bill </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Paid</strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Last Pmt </strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong> After Pmt </strong></div></td>
              <td width="8%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><div align="right"><strong>Pending</strong></div></td>
				  <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong> Adj Amt</strong></div></td>
              <td width="8%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong> Bal Amt</strong></div></td>
            </tr>
            <?php
			$colorloopcount='';
			$totalbalance = '';
			$sno = 0;
			$cashamount21 = '';
			$cardamount21 = '';
			$onlineamount21 = '';
			$chequeamount21 = '';
			$tdsamount21 = '';
			$writeoffamount21 = '';
			$taxamount21 = '';
			$totalnumbr='';
			$totalnumb=0;
			$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$totalpurchase1=0;
			$ss=0;
			if (isset($_REQUEST["showbilltype"])) { $showbilltype = $_REQUEST["showbilltype"]; } else { $showbilltype = ""; }
			if ($showbilltype == 'All Bills')
			{
				$showbilltype = '';
			}			
	
			$query282 = "select * from master_transactionpharmacy where paymentvoucherno = '$paymentdocno' and transactiontype = 'PURCHASE' and transactionmode <> 'CREDIT' order by auto_number";
			  $exec282 = mysqli_query($GLOBALS["___mysqli_ston"], $query282) or die ("Error in Query282".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res282 = mysqli_fetch_array($exec282))
			  {
				  $billnumber2 = $res282['billnumber'];
				  $mrnno = $res282['mrnno'];
				  $suppliercode2 = $res282['suppliercode'];
			  
			 $query2 = "select * from master_purchase where suppliercode = '$suppliercode2' and billnumber = '$billnumber2' and mrnno='$mrnno' and recordstatus <> 'deleted' and companyanum = '$companyanum'  and approved_payment IN ('1','2') group by billnumber";
			//$query2 = "select * from master_transaction where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and transactionmodule = 'SALES' and billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowcount2 = mysqli_num_rows($exec2);
			$number=mysqli_num_rows($exec2);
			while ($res2 = mysqli_fetch_array($exec2))
			{
				$suppliername = $res2['suppliername'];
				$billnumber = $res2['billnumber'];
				$supplierbillnumber=$res2['supplierbillnumber'];
				$billnumberprefix = $res2['billnumberprefix'];
				$billnumberpostfix = $res2['billnumberpostfix'];
				$billdate = $res2['billdate'];
				$billtotalamount = $res2['totalamount'];
				$billtotalfxamount = $res2['totalfxamount'];
				$mrnno = $res2['mrnno'];
				
				$query44 = "select sum(wh_tax_value) as wh_tax_value,sum(wh_vat_value) as wh_vat_value,ponumber from purchase_details where billnumber='$billnumber' and mrnno='$mrnno'";
				$exec44 = mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res44 = mysqli_fetch_array($exec44);
				$wh_tax_value =$res44['wh_tax_value'];
			    $wh_vat_value =$res44['wh_vat_value'];
				$ponumber = $res44['ponumber'];
				$subponumber = substr($ponumber,0,1);
				if($subponumber == 'M')
				{
				$query45 = "select * from materialreceiptnote_details where billnumber='$ponumber'";
				$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res45 = mysqli_fetch_array($exec45);
				$ponumber = $res45['ponumber'];
				}
				$totaladjust=0;
				$query3 = "select * from master_transactionpharmacy where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and billnumber = '$billnumber' and mrnno='$mrnno'  and recordstatus = 'allocated'";
				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num=mysqli_num_rows($exec3);
				while ($res3 = mysqli_fetch_array($exec3))
				{
					//echo $res3['auto_number'];
				    $cashamount1 = $res3['cashamount'];
					$onlineamount1 = $res3['onlineamount'];
					$chequeamount1 = $res3['chequeamount'];
					$cardamount1 = $res3['cardamount'];
					$tdsamount1 = $res3['tdsamount'];
					$writeoffamount1 = $res3['writeoffamount'];
					$taxamount1 = $res3['taxamount'];
					
					$cashamount21 = $cashamount21 + $cashamount1;
					$cardamount21 = $cardamount21 + $cardamount1;
					$onlineamount21 = $onlineamount21 + $onlineamount1;
					$chequeamount21 = $chequeamount21 + $chequeamount1;
					$tdsamount21 = $tdsamount21 + $tdsamount1;
					$writeoffamount21 = $writeoffamount21 + $writeoffamount1;
					$taxamount21 = $taxamount21 + $taxamount1;

					if(strpos($res3['docno'], 'SDBT-') !== false)
						$totaladjust = $totaladjust + $res3['transactionamount'];
				}

				$billtotalfxamount = $billtotalfxamount-$totaladjust;

				$billtotalamount = $billtotalamount-$totaladjust;
			
			    $totalpayment = $cashamount21 + $chequeamount21 + $onlineamount21 + $cardamount21 + $taxamount21;
				$netpayment = $totalpayment + $tdsamount21 + $writeoffamount21;
				
				$totalreturn = 0;
				$query38 = "select totalamount from purchasereturn_details where grnbillnumber = '$mrnno'";
				$exec38 = mysqli_query($GLOBALS["___mysqli_ston"], $query38) or die ("Error in Query38".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num=mysqli_num_rows($exec38);
				while ($res38 = mysqli_fetch_array($exec38))
				{
					$return = $res38['totalamount'];
					$totalreturn = $totalreturn + $return;
				}
				
				$balanceamount = $billtotalamount - $netpayment - $totalreturn;
				
				$billtotalamount = number_format($billtotalamount, 2, '.', '');
				$netpayment = number_format($netpayment, 2, '.', '');
				$balanceamount = number_format($balanceamount, 2, '.', '');
				
				$billstatus = $billtotalamount.'||'.$netpayment.'||'.$balanceamount;

			//echo $balanceamount;
			$billdate = substr($billdate, 0, 10);
			$date1 = $billdate;

			$dotarray = explode("-", $billdate);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$billdate = strtoupper(date("d-M-Y", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear)));

			$billtotalamount = number_format($billtotalamount, 2, '.', '');
			$netpayment = number_format($netpayment, 2, '.', '');
			$balanceamount = number_format($balanceamount, 2, '.', '');
			
			$date1 = $date1;
			$date2 = date("Y-m-d");  
			$diff = abs(strtotime($date2) - strtotime($date1));  
			$days = floor($diff / (60*60*24));  
			$daysafterbilldate = $days;
			
			$query3 = "select * from master_transactionpharmacy where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = 'allocated'  and mrnno='$mrnno' order by auto_number desc";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			 $numb=mysqli_num_rows($exec3);
			 $totalnumb=$totalnumb+$numb;
			 
			$lastpaymentdate = $res3['transactiondate'];
			$lastpaymentdate = substr($lastpaymentdate, 0, 10);
			
			if ($lastpaymentdate != '')
			{
				$date1 = $lastpaymentdate;
				$date2 = date("Y-m-d");  
				$diff = abs(strtotime($date2) - strtotime($date1));  
				$days = floor($diff / (60*60*24));  
				$daysafterpaymentdate = $days;
				
				$dotarray = explode("-", $lastpaymentdate);
				$dotyear = $dotarray[0];
				$dotmonth = $dotarray[1];
				$dotday = $dotarray[2];
				$lastpaymentdate = strtoupper(date("d-M-Y", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear)));
				
			}
			else
			{
				$daysafterpaymentdate = '';
				$lastpaymentdate = '';
			}			

			//echo $balanceamount;
			if ($balanceamount != '0.00')
			{
			
			$query34 = "select * from master_transactionpharmacy where transactiontype = 'PURCHASE' and transactionmode <> 'CREDIT' and billnumber = '$billnumber' and companyanum='$companyanum' and approved_payment = '1' and mrnno='$mrnno'";
			$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die ("Error in Query34".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num4=mysqli_num_rows($exec34);
			$res34 = mysqli_fetch_array($exec34);
			$approved_amount = $res34['approved_amount'];
			$appvdbank = $res34['appvdbank'];
			$appvdcheque = $res34['appvdcheque'];
			$appvdchequedt = $res34['appvdchequedt'];
			$remarks = $res34['remarks'];
			$paymentvoucherno = $res34['paymentvoucherno'];
			$appvdtaxamount = $res34['appvdfxamount'];
			$appvdpaymentmode = $res34['paymentmode'];
			
			$query28 = "select paymentvoucherno from master_purchase where suppliercode = '$suppliercode' and recordstatus <> 'deleted' and paymentvoucherno = '$paymentvoucherno' and billnumber = '$billnumber' and companyanum = '$companyanum'  and approved_payment = '2' group by billnumber";
			$exec28 = mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query28".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowcount28 = mysqli_num_rows($exec28);
			if($rowcount28 == 0)
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

			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $sno = $sno + 1; ?><?php $ss = $ss + 1; ?></td>
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">
			  <input type="checkbox" name="ack[]" id="acknow<?php echo $sno; ?>" value="<?php echo $billnumber; ?>@<?php echo $sno; ?>" onClick="return updatebox1('<?php echo $sno; ?>','<?php echo $approved_amount; ?>','<?php echo $number; ?>','<?php echo $appvdcheque; ?>','<?php echo $appvdbank; ?>','<?php echo $remarks; ?>','<?php echo $paymentvoucherno; ?>','<?php echo $appvdtaxamount; ?>')" checked ></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div class="bodytext311"><?php echo $supplierbillnumber; ?> , <?php echo $ponumber; ?> , <?php echo $mrnno; ?></div></td>
			  <input type="hidden" name="mrnno[]" value="<?php echo $mrnno; ?>">
			  <input type="hidden" name="supplierbillnumber[]" value="<?php echo $supplierbillnumber; ?>">
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billnumberprefix.$billnumber.$billnumberpostfix; ?></div></td>
              <input type="hidden" name="billnum[]" value="<?php echo $billnumber; ?>@<?php echo $sno; ?>">
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billdate; ?></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
                <?php if ($billtotalamount != '0.00') echo number_format($billtotalamount, 2,'.',','); //echo number_format($billtotalamount, 2); ?>
              </div></td><input type="hidden" name="billamount" id="bill" value="<?php if ($billtotalamount != '0.00') echo $billtotalamount; ?>">


              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
               <?php echo number_format($wh_vat_value, 2,'.',','); ?>
              </div></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
               <?php echo number_format($wh_tax_value, 2,'.',','); ?>
              </div></td>

			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
               <?php echo number_format($billtotalamount -($wh_vat_value+$wh_tax_value), 2,'.',','); 
			   $balanceamount =$balanceamount-($wh_vat_value+$wh_tax_value);
			   ?>
              </div></td>
			  
			  
			  <input type="hidden" name="billfxamount" id="billfx" value="<?php if ($billtotalfxamount != '0.00') echo $billtotalfxamount; ?>">
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left"><div align="right"><?php echo $daysafterbilldate.' Days'; ?></div>
                  <div align="right"></div>
                <div align="right"></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
                <?php if ($netpayment != '0.00') echo number_format($netpayment, 2,'.',','); //echo number_format($netpayment, 2); ?> 
              </div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left"><div align="right"> <?php echo $lastpaymentdate; ?> </div>
                  <div align="right"></div>
                <div align="right"></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
                  <?php if ($daysafterpaymentdate != '') echo $daysafterpaymentdate.' Days'; ?>
                </div>
                  <div align="right"></div>
                <div align="right"></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
                <?php if ($balanceamount != '0.00') echo number_format($balanceamount,2,'.',','); //echo number_format($balanceamount, 2); ?>
              </div></td>
			      <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input class="bali" type="text" name="adjamount[]" id="adjamount<?php echo $sno; ?>" value="<?php echo $approved_amount; ?>" size="7" readonly></td>
            <td class="bodytext311" valign="center" bordercolor="#f3f3f3"><input type="text" class="bal" name="balamount[]" id="balamount<?php echo $sno; ?>" value="<?php echo $balanceamount-$approved_amount;?>" size="7" readonly></td>
            </tr>
            <?php
				$totalbalance = $totalbalance + $balanceamount;

				}
				}
				
				$cashamount21 = '0.00';
				$cardamount21 = '0.00';
				$onlineamount21 = '0.00';
				$chequeamount21 = '0.00';
				$tdsamount21 = '0.00';
				$writeoffamount21 = '0.00';
				$taxamount21 = '0.00';

				$totalpayment = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billtotalamount = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billstatus = '0.00';
			  }
			  }
		
			?>
            <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
             
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>
                <?php //echo number_format($totalpurchaseamount, 2); ?>
              </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>
                <?php //echo number_format($netpaymentamount, 2); ?>
              </strong></div></td>
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>
                <?php //echo number_format($netpaymentamount, 2); ?>
              </strong></div></td>
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>
                <?php //echo number_format($netpaymentamount, 2); ?>
              </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>
                <?php //echo number_format($netpaymentamount, 2); ?>
              </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php if ($totalbalance != '') echo number_format($totalbalance, 2, '.', ','); ?></strong></div></td>
             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">
				<input type="hidden" name="totcount" id="totcount" value="<?php echo $sno; ?>">
				<input type="text" name="totaladjamt" id="totaladjamt" size="7" class="bal"></td>
             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
			</tr>
          </tbody>
        </table>
<?php
}
?>	
		
		
		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  
	  </form>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

