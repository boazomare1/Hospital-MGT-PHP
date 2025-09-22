<?php
session_start();
error_reporting(0);
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";

// Initialize variables
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$docno1 = $_SESSION['docno'];
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$billnumberprefix = "";
$username_auto_number = "";

// Get user details
$queryuser = "select employeename,auto_number from master_employee where username='$username'";
$execuser = mysqli_query($GLOBALS["___mysqli_ston"], $queryuser) or die ("Error in queryuser".mysqli_error($GLOBALS["___mysqli_ston"]));
if($resuser = mysqli_fetch_array($execuser)){
    $username_auto_number = $resuser['auto_number'];
}

// Include autocomplete for doctor search
include ("autocompletebuild_doctor.php");
// Handle form parameters
$getcanum = isset($_REQUEST["canum"]) ? $_REQUEST["canum"] : "";
$cbsuppliername = isset($_REQUEST["cbsuppliername"]) ? $_REQUEST["cbsuppliername"] : "";
$billnumbercode = isset($_REQUEST["billnumbercode"]) ? $_REQUEST["billnumbercode"] : "";

// Get location details
$locationdetails = "select locationcode from login_locationdetails where username='$username' and docno='$docno1'";
$exeloc = mysqli_query($GLOBALS["___mysqli_ston"], $locationdetails);
$resloc = mysqli_fetch_array($exeloc);
$locationcode = $resloc['locationcode'];

// Handle supplier selection
if ($getcanum != '') {
    $query4 = "select * from master_supplier where auto_number = '$getcanum'";
    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res4 = mysqli_fetch_array($exec4);
    $cbsuppliername = $res4['suppliername'];
    $suppliername = $res4['suppliername'];
}
// Handle form flags and parameters
$cbfrmflag1 = isset($_REQUEST["cbfrmflag1"]) ? $_REQUEST["cbfrmflag1"] : "";
$searchsuppliercode = isset($_REQUEST["searchsuppliercode"]) ? $_REQUEST["searchsuppliercode"] : "";

// Handle doctor search form submission
if ($cbfrmflag1 == 'cbfrmflag1') {
    $searchsuppliername = $_POST['searchsuppliername'];
    if ($searchsuppliername != '') {
        $arraysupplier = explode("#", $searchsuppliername);
        $arraysuppliername = $arraysupplier[0];
        $arraysuppliername = trim($arraysuppliername);
        $arraysuppliercode = $arraysupplier[1];
        
        $query1 = "select * from master_supplier where suppliercode = '$arraysuppliercode'";
        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res1 = mysqli_fetch_array($exec1);
        $supplieranum = $res1['auto_number'];
        $openingbalance = $res1['openingbalance'];
        $cbsuppliername = $arraysuppliername;
        $suppliername = $arraysuppliername;
        $doctorcode = $arraysuppliercode;
    } else {
        $cbsuppliername = $_REQUEST['cbsuppliername'];
        $cbsuppliername = strtoupper($cbsuppliername);
        $suppliername = $_REQUEST['cbsuppliername'];
        $suppliername = strtoupper($suppliername);
    }
}
// Handle payment form submission
$cbfrmflag2 = isset($_REQUEST["cbfrmflag2"]) ? $_REQUEST["cbfrmflag2"] : "";
$frmflag2 = isset($_REQUEST["frmflag2"]) ? $_REQUEST["frmflag2"] : "";

// Process payment entry
if ($frmflag2 == 'frmflag2')
{
			$query3 = "select * from master_company where companystatus = 'Active'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$paynowbillprefix = 'DP-';
			$paynowbillprefix1=strlen($paynowbillprefix);
			
			$query2 = "select * from master_transactiondoctor where transactiontype='PAYMENT' and docno like 'DP-%' order by auto_number desc limit 0, 1";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2 = mysqli_fetch_array($exec2);
			$billnumber = $res2["docno"];
			$billdigit=strlen($billnumber);
			if ($billnumber == '')
			{
				$billnumbercode ='DP-'.'1';
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
				
				
				$billnumbercode = 'DP-' .$maxanum;
				$openingbalance = '0.00';
				//echo $companycode;
			}
if($username_auto_number!=""){
	$billnumbercode.="-".$username_auto_number;
}
			$paymententrydate = $_REQUEST['paymententrydate'];
			$paymentmode = $_REQUEST['paymentmode'];
			$chequenumber = $_REQUEST['chequenumber'];
			$chequedate = $_REQUEST['ADate1'];
			$bankname1 = $_REQUEST['bankname'];
			$banknamesp = explode('||', $bankname1);
			$bankcode = isset($banknamesp[0]) ? $banknamesp[0] : '';
			$bankname = isset($banknamesp[1]) ? $banknamesp[1] : '';
			$bankbranch = $_REQUEST['bankbranch'];
			$remarks = $_REQUEST['remarks'];
			$paymentamount = $_REQUEST['paymentamount'];
			$netpayable = $_REQUEST['netpayable'];
			$cashcoa = $_REQUEST['cashcoa'];
			$chequecoa = $_REQUEST['chequecoa'];
			$cardcoa = $_REQUEST['cardcoa'];
			$mpesacoa = $_REQUEST['mpesacoa'];
			$onlinecoa = $_REQUEST['onlinecoa'];
			$doctorcode = $_REQUEST['doctorcode'];
			$bankcharges = $_REQUEST['bankcharges'];


			$taxanum = $_REQUEST['taxanum'];
			$querytax = "select tax_percent from master_withholding_tax where auto_number = '$taxanum'";
			$exectax = mysqli_query($GLOBALS["___mysqli_ston"], $querytax) or die ('Error in QueryTax'.mysqli_error($GLOBALS["___mysqli_ston"]));
			$restax = mysqli_fetch_array($exectax);
			$taxpercent = $restax['tax_percent'];
			$wht_id = $restax['tax_id'];
			$wht_anum = $restax['auto_number'];
			$taxamount = ($paymentamount*$taxpercent)/100;
			$netpayable = $paymentamount - $taxamount;
			
			$searchsuppliercode1 = $_REQUEST["searchsuppliercode1"];
			$searchsuppliername1 = $_REQUEST['searchsuppliername1'];
			$searchsuppliername1 = strtoupper($searchsuppliername1);
		
			$pendingamount = $_REQUEST['pendingamount'];
			$remarks = $_REQUEST['remarks'];
				
			$balanceamount = $pendingamount - $paymentamount;
			$transactiondate = $paymententrydate;
			
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
			
			
			
			
			$query1 = "select * from master_withholding_tax where record_status = '1' and auto_number='$taxanum' order by auto_number";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			
			$res1taxname = $res1["name"];
			$res1taxpercent = $res1["tax_percent"];
			$res1anum = $res1["auto_number"];
			$wht_id = $res1['tax_id'];
			$wht_anum = $res1['auto_number'];
			
			$transactionmodule = 'PAYMENT';
			if ($paymentmode == 'CASH')
			{
				$transactiontype = 'PAYMENT';
				$transactionmode = 'CASH';
				$particulars = 'BY CASH '.$billnumberprefix.$billnumber.'';	
				//$cashamount = $paymentamount;
				//include ("transactioninsert1.php");
				
				if(!isset($_POST['serialno']))
				{	$querychk1 = "select visitcode from master_transactiondoctor where visitcode = '$visitcode' and transactionamount = '$adjamount' and billnumber = '$billnum' and billautonumber = '$billautonumber' and transactiondate = '$transactiondate' ";
							$execchk1 = mysqli_query($GLOBALS["___mysqli_ston"], $querychk1) or die ("Error in querychk1".mysqli_error($GLOBALS["___mysqli_ston"]));
							$numchk = mysqli_num_rows($execchk1);
							if($numchk == 0)
							{
								
					$query9 = "insert into master_transactiondoctor (transactiondate, particulars, 
					transactionmode, transactiontype, transactionamount, cashamount,taxamount,
					billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
					transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,doctorcode,username,locationcode,bankname, bankcode,wht_perc,wht_anum,wht_id,netpayable,bankcharges) 
					values ('$transactiondate', 'BY CASH', 
					'$transactionmode', '$transactiontype', '$paymentamount', '$paymentamount', '$taxamount', 
					'',  '', '$ipaddress', '$updatedate', '0.00', '$companyanum', '$companyname', '$remarks', 
					'$transactionmodule','','','','','$searchsuppliername1','','$billnumbercode','$searchsuppliercode1','$username','$locationcode','$bankname','$bankcode','$res1taxpercent','$wht_anum','$wht_id','$netpayable','$bankcharges')";
					$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query91".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					$query37 = "insert into paymentmodecredit(billnumber,billdate,ipaddress,username,cash,cashcoa,source,transactionamount)values('$billnumbercode','$transactiondate','$ipaddress','$username','$netpayable','$cashcoa','doctorpaymententry','$netpayable')";
					$exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
							}
				}
				else
				{
					
					foreach($_POST['serialno'] as $key => $value)
					{
						//echo count($_POST['billnum']);
						$billnum=$_POST['billnum'][$key];
						$name=$_POST['name'][$key];
						$accountname=$_POST['accountname'][$key];
						$patientcode=$_POST['patientcode'][$key];
						$visitcode=$_POST['visitcode'][$key];
						$doctorname=$_POST['doctorname'][$key];
						$serialno=$_POST['serialno'][$key];
						//echo $doctorname;
						$balamount=$_POST['balamount'][$key];
						$billautonumber=$_POST['billautonumber'][$key];
						//echo $balamount;
						if($balamount == 0.00)
						{
							$billstatus='paid';
						}
						else
						{
							$billstatus='unpaid';
						}
						//echo $billstatus;
						$adjamount=$_POST['adjamount'][$key];
						
						
						
						$taxamount=$adjamount * $res1taxpercent/100;
						$netpayable=$adjamount-$taxamount;
						foreach($_POST['ack'] as $check)
						{
						$acknow=$check;
						if($acknow==$serialno)
						{
							$querychk1 = "select visitcode from master_transactiondoctor where visitcode = '$visitcode' and transactionamount = '$adjamount' and billnumber = '$billnum' and billautonumber = '$billautonumber' and transactiondate = '$transactiondate' and doctorcode='$doctorcode'";
							$execchk1 = mysqli_query($GLOBALS["___mysqli_ston"], $querychk1) or die ("Error in querychk1".mysqli_error($GLOBALS["___mysqli_ston"]));
							$numchk = mysqli_num_rows($execchk1);
							if($numchk == 0)
							{
								$query87="update billing_paylater set doctorstatus='$billstatus' where billno='$billnum'";
								$exec87=mysqli_query($GLOBALS["___mysqli_ston"], $query87);
								$query88="update billing_paynow set doctorstatus='$billstatus' where billno='$billnum'";
								$exec88=mysqli_query($GLOBALS["___mysqli_ston"], $query88);
								$query90="update billing_ipprivatedoctor set doctorstatus='$billstatus' where docno='$billnum' and description='$doctorname' and auto_number = '$billautonumber'";
								$exec90=mysqli_query($GLOBALS["___mysqli_ston"], $query90);
								
								
								$query9 = "insert into master_transactiondoctor (transactiondate, particulars, 
								transactionmode, transactiontype, transactionamount, cashamount,taxamount,
								billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
								transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,doctorcode,billautonumber,username,bankcode,bankname,wht_perc,wht_anum,wht_id,netpayable,bankcharges) 
								values ('$transactiondate', '$particulars', 
								'$transactionmode', '$transactiontype', '$adjamount', '$adjamount', '$taxamount', 
								'$billnum',  '$billanum', '$ipaddress', '$updatedate', '$balamount', '$companyanum', '$companyname', '$remarks', 
								'$transactionmodule','$name','$patientcode','$visitcode','$accountname','$doctorname','$billstatus','$billnumbercode','$doctorcode','$billautonumber','$username','$bankcode','$bankname','$res1taxpercent','$wht_anum','$wht_id','$netpayable','$bankcharges')";
								$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query92".mysqli_error($GLOBALS["___mysqli_ston"]));
								
								$query37 = "insert into paymentmodecredit(billnumber,billdate,ipaddress,username,cash,cashcoa,source,transactionamount)values('$billnumbercode','$transactiondate','$ipaddress','$username','$adjamount','$cashcoa','doctorpaymententry','$adjamount')";
								$exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
							}
						
						}	
					}
				}
			}
			}
			
			if ($paymentmode == 'ONLINE')
			{
				$transactiontype = 'PAYMENT';
				$transactionmode = 'ONLINE';
				$particulars = 'BY ONLINE '.$billnumberprefix.$billnumber.'';	
				
				if(!isset($_POST['billnum']))
				{
					$query9 = "insert into master_transactiondoctor (transactiondate, particulars, 
					transactionmode, transactiontype, transactionamount, onlineamount,taxamount,
					billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
					transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,doctorcode,username,bankcode,bankname,wht_perc,wht_anum,wht_id,netpayable, chequenumber, chequedate,bankcharges) 
					values ('$transactiondate', 'BY ONLINE', 
					'$transactionmode', '$transactiontype', '$paymentamount', '$paymentamount', '$taxamount', 
					'',  '', '$ipaddress', '$updatedate', '0.00', '$companyanum', '$companyname', '$remarks', 
					'$transactionmodule','','','','','$searchsuppliername1','','$billnumbercode','$searchsuppliercode1','$username','$bankcode','$bankname','$res1taxpercent','$wht_anum','$wht_id','$netpayable', '$chequenumber','$chequedate','$bankcharges')";
					$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query93".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					$query37 = "insert into paymentmodecredit(billnumber,billdate,ipaddress,username,cash,cashcoa,source,transactionamount)values('$billnumbercode','$transactiondate','$ipaddress','$username','$netpayable','$cashcoa','doctorpaymententry','$netpayable')";
					$exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				
				}
				else
				{
					foreach($_POST['serialno'] as $key => $value)
					{
						$billnum3=$_POST['billnum'][$key];
						$name1=$_POST['name'][$key];
						$accountname=$_POST['accountname'][$key];
						$patientcode=$_POST['patientcode'][$key];
						$visitcode=$_POST['visitcode'][$key];
						$doctorname=$_POST['doctorname'][$key];
						$balamount=$_POST['balamount'][$key];
						$serialno=$_POST['serialno'][$key];
						$billautonumber=$_POST['billautonumber'][$key];
						if($balamount == 0.00)
						{
							$billstatus='paid';
						}
						else
						{
							$billstatus='unpaid';
						}
					
						$adjamount=$_POST['adjamount'][$key];
						$taxamount=$adjamount * $res1taxpercent/100;
						$netpayable=$adjamount-$taxamount;
						foreach($_POST['ack'] as $check)
						{
							$acknow=$check;
							if($acknow==$serialno)
							{
							$querychk1 = "select visitcode from master_transactiondoctor where visitcode = '$visitcode' and transactionamount = '$adjamount' and billnumber = '$billnum3' and billautonumber = '$billautonumber' and transactiondate = '$transactiondate' and doctorcode='$doctorcode'";
							$execchk1 = mysqli_query($GLOBALS["___mysqli_ston"], $querychk1) or die ("Error in querychk1".mysqli_error($GLOBALS["___mysqli_ston"]));
							$numchk = mysqli_num_rows($execchk1);
							if($numchk == 0)
							{
								//include ("transactioninsert1.php");
								$query87="update billing_paylater set doctorstatus='$billstatus' where billno='$billnum3'";
								$exec87=mysqli_query($GLOBALS["___mysqli_ston"], $query87);
								$query88="update billing_paynow set doctorstatus='$billstatus' where billno='$billnum3'";
								$exec88=mysqli_query($GLOBALS["___mysqli_ston"], $query88);
								$query90="update billing_ipprivatedoctor set doctorstatus='$billstatus' where docno='$billnum3' and description='$doctorname' and auto_number = '$billautonumber'";
								$exec90=mysqli_query($GLOBALS["___mysqli_ston"], $query90);
						
						
								
								$query9 = "insert into master_transactiondoctor (transactiondate, particulars,
								transactionmode, transactiontype, transactionamount, onlineamount,taxamount,
								billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
								transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,doctorcode,billautonumber,username,bankcode,bankname,wht_perc,wht_anum,wht_id,netpayable, chequenumber, chequedate,bankcharges) 
								values ('$transactiondate','$particulars', 
								'$transactionmode', '$transactiontype', '$adjamount', '$adjamount', '$taxamount', 
								'$billnum3',  '$billanum', '$ipaddress', '$updatedate', '$balamount', '$companyanum', '$companyname', '$remarks', 
								'$transactionmodule','$name1','$patientcode','$visitcode','$accountname','$doctorname','$billstatus','$billnumbercode','$doctorcode','$billautonumber','$username','$bankcode','$bankname','$res1taxpercent','$wht_anum','$wht_id','$netpayable', '$chequenumber','$chequedate','$bankcharges')";
								$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query94".mysqli_error($GLOBALS["___mysqli_ston"]));
						
								$query37 = "insert into paymentmodecredit(billnumber,billdate,ipaddress,username,online,onlinecoa,source,transactionamount)values('$billnumbercode','$transactiondate','$ipaddress','$username','$adjamount','$onlinecoa','doctorpaymententry','$adjamount')";
								$exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						
							}
							}
						}
					}
				}				
			}
			if ($paymentmode == 'MPESA')
			{
				$transactiontype = 'PAYMENT';
				$transactionmode = 'MPESA';
				$particulars = 'BY MPESA '.$billnumberprefix.$billnumber;	
				
				if(!isset($_POST['billnum']))
				{
					$query9 = "insert into master_transactiondoctor (transactiondate, particulars, 
					transactionmode, transactiontype, transactionamount, mpesaamount,taxamount,
					billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
					transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,doctorcode,
					bankname, mpesanumber, chequedate,username,bankcode,wht_perc,wht_anum,wht_id,netpayable,bankcharges) 
					values ('$transactiondate', 'BY MPESA', 
					'$transactionmode', '$transactiontype', '$paymentamount', '$paymentamount', '$taxamount', 
					'',  '', '$ipaddress', '$updatedate', '0.00', '$companyanum', '$companyname', '$remarks', 
					'$transactionmodule','','','','','$searchsuppliername1','','$billnumbercode','$searchsuppliercode1',
					'$bankname', '$chequenumber','$chequedate','$username','$bankcode','$res1taxpercent','$wht_anum','$wht_id','$netpayable','$bankcharges')";
					$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query95".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					$query37 = "insert into paymentmodecredit(billnumber,billdate,ipaddress,username,mpesa,mpesacoa,source,transactionamount)values('$billnumbercode','$transactiondate','$ipaddress','$username','$netpayable','$mpesacoa','doctorpaymententry','$netpayable')";
					$exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				
				}
				else
				{	
					foreach($_POST['serialno'] as $key => $value)
					{
						$billnum1=$_POST['billnum'][$key];
						$name2=$_POST['name'][$key];
						$accountname=$_POST['accountname'][$key];
						$patientcode=$_POST['patientcode'][$key];
						$visitcode=$_POST['visitcode'][$key];
						$doctorname=$_POST['doctorname'][$key];
						$balamount=$_POST['balamount'][$key];
						$serialno=$_POST['serialno'][$key];
						$billautonumber=$_POST['billautonumber'][$key];
						if($balamount == 0.00)
						{
							$billstatus='paid';
						}
						else
						{
							$billstatus='unpaid';
						}
					
						$adjamount=$_POST['adjamount'][$key];
						$taxamount=$adjamount * $res1taxpercent/100;
						$netpayable=$adjamount-$taxamount;
						foreach($_POST['ack'] as $check)
						{
							$acknow=$check;
							if($acknow==$serialno)
							{
							$querychk1 = "select visitcode from master_transactiondoctor where visitcode = '$visitcode' and transactionamount = '$adjamount' and billnumber = '$billnum1' and billautonumber = '$billautonumber' and transactiondate = '$transactiondate' and doctorcode='$doctorcode'";
							$execchk1 = mysqli_query($GLOBALS["___mysqli_ston"], $querychk1) or die ("Error in querychk1".mysqli_error($GLOBALS["___mysqli_ston"]));
							$numchk = mysqli_num_rows($execchk1);
							if($numchk == 0)
							{
							//include ("transactioninsert1.php");
							$query87="update billing_paylater set doctorstatus='$billstatus' where billno='$billnum1'";
							$exec87=mysqli_query($GLOBALS["___mysqli_ston"], $query87);
							$query88="update billing_paynow set doctorstatus='$billstatus' where billno='$billnum1'";
							$exec88=mysqli_query($GLOBALS["___mysqli_ston"], $query88);
							$query90="update billing_ipprivatedoctor set doctorstatus='$billstatus' where docno='$billnum1' and description='$doctorname' and auto_number = '$billautonumber'";
							$exec90=mysqli_query($GLOBALS["___mysqli_ston"], $query90);
							
							
							
							$query9 = "insert into master_transactiondoctor (transactiondate, particulars,
							transactionmode, transactiontype, transactionamount,
							mpesaamount,taxamount,mpesanumber, billnumber, billanum, 
							chequedate, bankname, bankbranch, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
							transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,doctorcode,billautonumber,username,bankcode,wht_perc,wht_anum,wht_id,netpayable,bankcharges) 
							values ('$transactiondate', '$particulars', 
							'$transactionmode', '$transactiontype', '$adjamount',
							'$adjamount','$taxamount','$chequenumber',  '$billnum1',  '$billanum', 
							'$chequedate', '$bankname', '$bankbranch','$ipaddress', '$updatedate', '$balamount', '$companyanum', '$companyname', 
							'$remarks', '$transactionmodule','$name2','$patientcode','$visitcode','$accountname','$doctorname','$billstatus','$billnumbercode','$doctorcode','$billautonumber','$username','$bankcode','$res1taxpercent','$wht_anum','$wht_id','$netpayable','$bankcharges')";
							$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query96".mysqli_error($GLOBALS["___mysqli_ston"]));
							
							$query37 = "insert into paymentmodecredit(billnumber,billdate,ipaddress,username,mpesa,mpesacoa,source,transactionamount)values('$billnumbercode','$transactiondate','$ipaddress','$username','$adjamount','$mpesacoa','doctorpaymententry','$adjamount')";
							$exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					
							}
							}
						}
					}
				}
			}
			if ($paymentmode == 'CHEQUE')
			{
				$transactiontype = 'PAYMENT';
				$transactionmode = 'CHEQUE';
				$particulars = 'BY CHEQUE '.$billnumberprefix.$billnumber;	
				
				if(!isset($_POST['billnum']))
				{
					$query9 = "insert into master_transactiondoctor (transactiondate, particulars, 
					transactionmode, transactiontype, transactionamount, chequeamount,taxamount,
					billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
					transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,doctorcode,
					bankname, chequenumber, chequedate,username,bankcode,wht_perc,wht_anum,wht_id,netpayable,bankcharges) 
					values ('$transactiondate', 'BY CHEQUE', 
					'$transactionmode', '$transactiontype', '$paymentamount', '$paymentamount', '$taxamount', 
					'',  '', '$ipaddress', '$updatedate', '0.00', '$companyanum', '$companyname', '$remarks', 
					'$transactionmodule','','','','','$searchsuppliername1','','$billnumbercode','$searchsuppliercode1',
					'$bankname', '$chequenumber','$chequedate','$username','$bankcode','$res1taxpercent','$wht_anum','$wht_id','$netpayable','$bankcharges')";
					$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query95".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					$query37 = "insert into paymentmodecredit(billnumber,billdate,ipaddress,username,cash,cashcoa,source,transactionamount)values('$billnumbercode','$transactiondate','$ipaddress','$username','$netpayable','$cashcoa','doctorpaymententry','$netpayable')";
					$exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				
				}
				else
				{	
					foreach($_POST['serialno'] as $key => $value)
					{
						$billnum1=$_POST['billnum'][$key];
						$name2=$_POST['name'][$key];
						$accountname=$_POST['accountname'][$key];
						$patientcode=$_POST['patientcode'][$key];
						$visitcode=$_POST['visitcode'][$key];
						$doctorname=$_POST['doctorname'][$key];
						$balamount=$_POST['balamount'][$key];
						$serialno=$_POST['serialno'][$key];
						$billautonumber=$_POST['billautonumber'][$key];
						if($balamount == 0.00)
						{
							$billstatus='paid';
						}
						else
						{
							$billstatus='unpaid';
						}
					
						$adjamount=$_POST['adjamount'][$key];
						$taxamount=$adjamount * $res1taxpercent/100;
						$netpayable=$adjamount-$taxamount;
						foreach($_POST['ack'] as $check)
						{
							$acknow=$check;
							if($acknow==$serialno)
							{
							$querychk1 = "select visitcode from master_transactiondoctor where visitcode = '$visitcode' and transactionamount = '$adjamount' and billnumber = '$billnum1' and billautonumber = '$billautonumber' and transactiondate = '$transactiondate' and doctorcode='$doctorcode'";
							$execchk1 = mysqli_query($GLOBALS["___mysqli_ston"], $querychk1) or die ("Error in querychk1".mysqli_error($GLOBALS["___mysqli_ston"]));
							$numchk = mysqli_num_rows($execchk1);
							if($numchk == 0)
							{
							//include ("transactioninsert1.php");
							$query87="update billing_paylater set doctorstatus='$billstatus' where billno='$billnum1'";
							$exec87=mysqli_query($GLOBALS["___mysqli_ston"], $query87);
							$query88="update billing_paynow set doctorstatus='$billstatus' where billno='$billnum1'";
							$exec88=mysqli_query($GLOBALS["___mysqli_ston"], $query88);
							$query90="update billing_ipprivatedoctor set doctorstatus='$billstatus' where docno='$billnum1' and description='$doctorname' and auto_number = '$billautonumber'";
							$exec90=mysqli_query($GLOBALS["___mysqli_ston"], $query90);
							
							
							
							$query9 = "insert into master_transactiondoctor (transactiondate, particulars,
							transactionmode, transactiontype, transactionamount,
							chequeamount,taxamount,chequenumber, billnumber, billanum, 
							chequedate, bankname, bankbranch, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
							transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,doctorcode,billautonumber,username,bankcode,wht_perc,wht_anum,wht_id,netpayable,bankcharges) 
							values ('$transactiondate', '$particulars', 
							'$transactionmode', '$transactiontype', '$adjamount',
							'$adjamount','$taxamount','$chequenumber',  '$billnum1',  '$billanum', 
							'$chequedate', '$bankname', '$bankbranch','$ipaddress', '$updatedate', '$balamount', '$companyanum', '$companyname', 
							'$remarks', '$transactionmodule','$name2','$patientcode','$visitcode','$accountname','$doctorname','$billstatus','$billnumbercode','$doctorcode','$billautonumber','$username','$bankcode','$res1taxpercent','$wht_anum','$wht_id','$netpayable','$bankcharges')";
							$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query96".mysqli_error($GLOBALS["___mysqli_ston"]));
							
							$query37 = "insert into paymentmodecredit(billnumber,billdate,ipaddress,username,cheque,chequecoa,source,transactionamount)values('$billnumbercode','$transactiondate','$ipaddress','$username','$adjamount','$chequecoa','doctorpaymententry','$adjamount')";
							$exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					
							}
							}
						}
					}
				}
			}
			
			if ($paymentmode == 'WRITEOFF')
			{
				$transactiontype = 'PAYMENT';
				$transactionmode = 'WRITEOFF';
				$particulars = 'BY WRITEOFF '.$billnumberprefix.$billnumber;	
				if(!isset($_POST['billnum']))
				{
					$query9 = "insert into master_transactiondoctor (transactiondate, particulars, 
					transactionmode, transactiontype, transactionamount, writeoffamount,taxamount,
					billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
					transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,doctorcode,billautonumber,username,wht_perc,wht_anum,wht_id,netpayable,bankcharges) 
					values ('$transactiondate', 'BY WRITEOFF', 
					'$transactionmode', '$transactiontype', '$paymentamount', '$paymentamount', '$taxamount', 
					'',  '', '$ipaddress', '$updatedate', '0.00', '$companyanum', '$companyname', '$remarks', 
					'$transactionmodule','','','','','$searchsuppliername1','','$billnumbercode','$searchsuppliercode1','$billautonumber','$username','$res1taxpercent','$wht_anum','$wht_id','$netpayable','$bankcharges')";
					$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query97".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					$query37 = "insert into paymentmodecredit(billnumber,billdate,ipaddress,username,cash,cashcoa,source,transactionamount)values('$billnumbercode','$transactiondate','$ipaddress','$username','$netpayable','$cashcoa','doctorpaymententry','$netpayable')";
					$exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				
				}
				else
				{	
					foreach($_POST['serialno'] as $key => $value)
					{
						$billnum2=$_POST['billnum'][$key];
						$name3=$_POST['name'][$key];
						$accountname=$_POST['accountname'][$key];
						$patientcode=$_POST['patientcode'][$key];
						$visitcode=$_POST['visitcode'][$key];
						$doctorname=$_POST['doctorname'][$key];
						$balamount=$_POST['balamount'][$key];
						$serialno=$_POST['serialno'][$key];
						$billautonumber=$_POST['billautonumber'][$key];
						if($balamount == 0.00)
						{
							$billstatus='paid';
						}
						else
						{
							$billstatus='unpaid';
						}
				
						$adjamount=$_POST['adjamount'][$key];
						$taxamount=$adjamount * $res1taxpercent/100;
						$netpayable=$adjamount-$taxamount;
						foreach($_POST['ack'] as $check)
						{
							$acknow=$check;
							if($acknow==$serialno)
							{
							$querychk1 = "select visitcode from master_transactiondoctor where visitcode = '$visitcode' and billnumber = '$billnum2' and billautonumber = '$billautonumber' and transactionamount = '$adjamount' and transactiondate = '$transactiondate' and doctorcode='$doctorcode'";
							$execchk1 = mysqli_query($GLOBALS["___mysqli_ston"], $querychk1) or die ("Error in querychk1".mysqli_error($GLOBALS["___mysqli_ston"]));
							$numchk = mysqli_num_rows($execchk1);
							if($numchk == 0)
							{
								//include ("transactioninsert1.php");
								$query87="update billing_paylater set doctorstatus='$billstatus' where billno='$billnum'";
								$exec87=mysqli_query($GLOBALS["___mysqli_ston"], $query87);
								$query88="update billing_paynow set doctorstatus='$billstatus' where billno='$billnum'";
								$exec88=mysqli_query($GLOBALS["___mysqli_ston"], $query88);
								$query90="update billing_ipprivatedoctor set doctorstatus='$billstatus' where docno='$billnum' and description='$doctorname' and auto_number = '$billautonumber'";
								$exec90=mysqli_query($GLOBALS["___mysqli_ston"], $query90);
						
							
								$query9 = "insert into master_transactiondoctor (transactiondate, particulars,  
								transactionmode, transactiontype, transactionamount, writeoffamount,taxamount,
								billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
								transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,doctorcode,billautonumber,username,locationcode,wht_perc,wht_anum,wht_id,netpayable,bankcharges) 
								values ('$transactiondate', '$particulars',
								'$transactionmode', '$transactiontype', '$adjamount', '$adjamount', '$taxamount',
								'$billnum2',  '$billanum', '$ipaddress', '$updatedate', '$balamount', '$companyanum', '$companyname', '$remarks', 
								'$transactionmodule','$name3','$patientcode','$visitcode','$accountname','$doctorname','$billstatus','$doctorcode','$billautonumber','$username','$locationcode','$res1taxpercent','$wht_anum','$wht_id','$netpayable','$bankcharges')";
								$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query98".mysqli_error($GLOBALS["___mysqli_ston"]));
							}
							}
						}
					}
				}
			}
		
		header("location:doctorpaymententry.php?docno=$billnumbercode");
		exit;
		
}
// Handle success/error messages
$st = isset($_REQUEST["st"]) ? $_REQUEST["st"] : "";
if ($st == '1') {
    $errmsg = "Success. Payment Entry Update Completed.";
    $bgcolorcode = 'success';
}
if ($st == '2') {
    $errmsg = "Failed. Payment Entry Not Completed.";
    $bgcolorcode = 'failed';
}
if(isset($_REQUEST['docno'])) { $docno = $_REQUEST['docno']; } else { $docno = ''; }
if($docno != "") { ?>
<script>
window.open("print_doctorremittances.php?docno=<?php echo $docno; ?>","OriginalWindow<?php echo '1'; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
</script>
<?php
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Payment Entry - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/doctor-payment-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker CSS -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- jQuery UI for autocomplete -->
    <link href="js/jquery-ui.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- Scripts -->
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script type="text/javascript" src="js/autocomplete_doctor.js"></script>
    <script type="text/javascript" src="js/autosuggestdoctor.js"></script>
    <script type="text/javascript">
    window.onload = function () {
        var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
    }
    function disableEnterKey(varPassed) {
        if (event.keyCode==8) {
            event.keyCode=0; 
            return event.keyCode 
            return false;
        }
        
        var key;
        if(window.event) {
            key = window.event.keyCode;     //IE
        } else {
            key = e.which;     //firefox
        }
        if(key == 13) { // if enter key press
            return false;
        } else {
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
	
	if (document.getElementById("cbsuppliername").value == "")
	{
		alert ("Enter Doctor Name");
		document.getElementById("cbsuppliername").focus();
		return false;
	}
	if (document.getElementById("paymentamount").value == "")
	{
		alert ("Payment Amount Cannot Be Empty.");
		document.getElementById("paymentamount").focus();
		document.getElementById("paymentamount").value = "0.00"
		return false;
	}
	if (document.getElementById("paymentamount").value == "0.00")
	{
		alert ("Payment Amount Cannot Be Empty.");
		document.getElementById("paymentamount").focus();
		document.getElementById("paymentamount").value = "0.00"
		return false;
	}
	if (isNaN(document.getElementById("paymentamount").value))
	{
		alert ("Payment Amount Can Only Be Numbers.");
		document.getElementById("paymentamount").focus();
		return false;
	}
	if (document.getElementById("paymentmode").value == "")
	{
		alert ("Please Select Payment Mode.");
		document.getElementById("paymentmode").focus();
		return false;
	}

	if(document.getElementById("bankname").value == "")
	{
		alert ("Please select Bank.");
		document.getElementById("bankname").focus();
		return false;
	} 


	if(document.getElementById("ADate1").value == "")
	{
		alert ("Please select paymentdate.");
		return false;
	} 


	if (document.getElementById("paymentmode").value == "CHEQUE")
	{
		if(document.getElementById("chequenumber").value == "")
		{
			alert ("If Payment By Cheque, Then Cheque Number Cannot Be Empty.");
			document.getElementById("chequenumber").focus();
			return false;
		} 
		else if (document.getElementById("bankname").value == "")
		{
			alert ("If Payment By Cheque, Then Bank Name Cannot Be Empty.");
			document.getElementById("bankname").focus();
			return false;
		}
	}
	else if (document.getElementById("paymentmode").value == "MPESA")
	{
		if(document.getElementById("chequenumber").value == "")
		{
			alert ("If Payment By Mpesa, Then Mpesa Number Cannot Be Empty.");
			document.getElementById("chequenumber").focus();
			return false;
		}
		else if (document.getElementById("bankname").value == "")
		{
			alert ("If Payment By Mpesa, Then Mpesa Bank Name Cannot Be Empty.");
			document.getElementById("bankname").focus();
			return false;
		}
		
	}

	if (document.getElementById("bankcharges").value == "" || document.getElementById("bankcharges").value == "0.00")
	{
	var fRet1; 
	fRet1 = confirm('Do you like to enter Bank Charges? '); 
		if (fRet1 == true)
		{
			document.getElementById("bankcharges").focus();
			return false;
		}
	}
	
	 document.getElementById("form1button").disabled=true;
	
	var fRet; 
	fRet = confirm('Are you sure want to save this payment entry?'); 
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
	
		FuncPopup();
		document.form1.submit();
		
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
		 document.getElementById("form1button").disabled=false;
		alert ("Payment Entry Not Completed.");
		return false;
	}
		
	//return false;
	
}
function funcPrintReceipt1()
{
	var docno = "<?php echo $docno;?>";
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_doctorremittances.php?docno="+docno,"OriginalWindow<?php echo '1'; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}
function FillNetpay()
{
	var Payment = document.getElementById("paymentamount").value;
	if(isNaN(Payment))
	{
		alert("Enter Numbers");
		document.getElementById("paymentamount").value = "";
		document.getElementById("netpayable").value = "";
		document.getElementById("paymentamount").focus();
	}
	else
	{
		if(Payment != "")
		{	
			var Payment = parseFloat(Payment);
			document.getElementById("netpayable").value = Payment.toFixed(2);
		}
	}
}
function FillDoctor()
{
	var Doctor = document.getElementById("cbsuppliername").value;
	document.getElementById("searchsuppliername1").value = Doctor;
}
</script>
<script>
	function bankCharges()
{
	paymentamount = document.getElementById("paymentamount").value;
	if(paymentamount=='0.00'){
			alert('Check the bill!');
			document.getElementById("bankcharges").value='0.00';
			return false;
	}

	taxamount = document.getElementById("taxamount").value;
	bank_charges = document.getElementById("bankcharges").value;
	 // var adj=paymentamount-bank_charges;
	 if(taxamount==''){
	 		taxamount=0;
	 }
	 if(bank_charges==''){
	 		bank_charges=0;
	 }
	 var adj1=parseFloat(paymentamount)-parseFloat(taxamount);
	 var adj=parseFloat(adj1)-parseFloat(bank_charges);
	 if(adj<0){
	 	document.getElementById("netpayable").value=adj1.toFixed(2);
	 	alert('Amount Entered is Higher Than the Net Payable.');
	 	document.getElementById("bankcharges").value='0.00';
	 	return false;
	 }

	 document.getElementById("netpayable").value=adj.toFixed(2);
}


function updatebox(varSerialNumber,billamt,totalcount1)
{
	document.getElementById("bankcharges").value='0.00';
var adjamount1;
var grandtotaladjamt2=0;
var varSerialNumber = varSerialNumber;
var totalcount1=document.getElementById("totcount").value;
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
	if(totalbillamt == 0.00)
{
totalbillamt=0;
}
				totalbillamt=parseFloat(totalbillamt)+parseFloat(billamt);
			
		totalbillamt1=totalbillamt.toFixed(2);
		totalbillamt1 = totalbillamt1.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
			//alert(totalbillamt);
document.getElementById("paymentamount").value = totalbillamt.toFixed(2);
document.getElementById("netpayable").value = totalbillamt.toFixed(2);
document.getElementById("totaladjamt").value=totalbillamt1;
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
function balancecalc(varSerialNumber1,billamt1,totalcount)
{
	document.getElementById("bankcharges").value='0.00';
var varSerialNumber1 = varSerialNumber1;
var billamt1 = billamt1;
var totalcount=document.getElementById("totcount").value;
var grandtotaladjamt=0;
var adjamount=document.getElementById("adjamount"+varSerialNumber1+"").value;
var adjamount3=parseFloat(adjamount);
if(adjamount3 > billamt1)
{
alert("Please enter correct amount");
document.getElementById("adjamount"+varSerialNumber1+"").focus();
return false;
}
var balanceamount=parseFloat(billamt1)-parseFloat(adjamount);
	balanceamount=balanceamount.toFixed(2);
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

	grandtotaladjamt1=grandtotaladjamt.toFixed(2);
	grandtotaladjamt1 = grandtotaladjamt1.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

document.getElementById("paymentamount").value = grandtotaladjamt.toFixed(2);
document.getElementById("netpayable").value = grandtotaladjamt.toFixed(2);
document.getElementById("totaladjamt").value=grandtotaladjamt1;
var tax = document.getElementById("taxanum").value;
if(tax != '')
{
var paymentamount = document.getElementById("paymentamount").value;
<?php
$query1 = "select * from master_tax where status <> 'deleted' order by taxname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1taxname = $res1["taxname"];
						$res1taxpercent = $res1["taxpercent"];
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
function netpayablecalc()
{
var taxamount;
var taxpercent;
var paymentamount = document.getElementById("paymentamount").value;
var tax = document.getElementById("taxanum").value;
//alert(tax);
if(tax != '')
{
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
	// document.getElementById("netpayable").value = netpayable.toFixed(2);

	bank_charges = document.getElementById("bankcharges").value;
	var adj1=parseFloat(netpayable)-parseFloat(bank_charges);
	document.getElementById("netpayable").value = adj1.toFixed(2);
}
else
{
	document.getElementById("taxamount").value = 0.00;
	// document.getElementById("netpayable").value = paymentamount;
	bank_charges = document.getElementById("bankcharges").value;
	var adj1=parseFloat(paymentamount)-parseFloat(bank_charges);
	document.getElementById("netpayable").value = adj1;
}	
	
}
function FuncPopup()
{
	window.scrollTo(0,0);
	document.getElementById("imgloader").style.display = "";
	document.body.style.overflow='auto';
	//return false;
}
</script>
<?php
$query765 = "select * from master_financialintegration where field='cashdoctorpaymententry'";
$exec765 = mysqli_query($GLOBALS["___mysqli_ston"], $query765) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res765= mysqli_fetch_array($exec765);
$cashcoa = $res765['code'];
$query766 = "select * from master_financialintegration where field='chequedoctorpaymententry'";
$exec766 = mysqli_query($GLOBALS["___mysqli_ston"], $query766) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res766 = mysqli_fetch_array($exec766);
$chequecoa = $res766['code'];
$query767 = "select * from master_financialintegration where field='mpesadoctorpaymententry'";
$exec767 = mysqli_query($GLOBALS["___mysqli_ston"], $query767) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res767 = mysqli_fetch_array($exec767);
$mpesacoa = $res767['code'];
$query768 = "select * from master_financialintegration where field='carddoctorpaymententry'";
$exec768 = mysqli_query($GLOBALS["___mysqli_ston"], $query768) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res768 = mysqli_fetch_array($exec768);
$cardcoa = $res768['code'];
$query769 = "select * from master_financialintegration where field='onlinedoctorpaymententry'";
$exec769 = mysqli_query($GLOBALS["___mysqli_ston"], $query769) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res769 = mysqli_fetch_array($exec769);
$onlinecoa = $res769['code'];
?>
    <script src="js/datepicker_doctor.js"></script>
</head>

<body>
    <!-- Loading Overlay -->
    <div id="imgloader" class="loading-overlay" style="display:none;">
        <div class="loading-content">
            <div class="loading-spinner">
                <i class="fas fa-spinner fa-spin"></i>
            </div>
            <p><strong>Saving Payment Entry</strong></p>
            <p>Please Wait...</p>
        </div>
    </div>

    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
    </header>

    <!-- User Information Bar -->
    <div class="user-info-bar">
        <div class="user-welcome">
            <span class="welcome-text">Welcome, <strong><?php echo htmlspecialchars($username); ?></strong></span>
            <span class="location-info">📍 Company: <?php echo htmlspecialchars($companyname); ?></span>
        </div>
        <div class="user-actions">
            <a href="mainmenu1.php" class="btn btn-outline">🏠 Main Menu</a>
            <a href="logout.php" class="btn btn-outline">🚪 Logout</a>
        </div>
    </div>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Home</a>
        <span>→</span>
        <span>Doctor Payment Entry</span>
    </nav>

    <!-- Floating Menu Toggle -->
    <div id="menuToggle" class="floating-menu-toggle">
        <i class="fas fa-bars"></i>
    </div>

    <!-- Main Container with Sidebar -->
    <div class="main-container-with-sidebar">
        <!-- Left Sidebar -->
        <aside id="leftSidebar" class="left-sidebar">
            <div class="sidebar-header">
                <h3>Quick Navigation</h3>
                <button id="sidebarToggle" class="sidebar-toggle">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            
            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="mainmenu1.php" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="doctorpaymententry.php" class="nav-link active">
                            <i class="fas fa-credit-card"></i>
                            <span>Doctor Payment Entry</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="doctorsactivityreport.php" class="nav-link">
                            <i class="fas fa-user-md"></i>
                            <span>Doctor Activity Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeusersreport.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Active Users Report</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php if (!empty($errmsg)): ?>
                    <div class="alert alert-<?php echo $bgcolorcode === 'success' ? 'success' : ($bgcolorcode === 'failed' ? 'error' : 'info'); ?>">
                        <i class="fas fa-<?php echo $bgcolorcode === 'success' ? 'check-circle' : ($bgcolorcode === 'failed' ? 'exclamation-triangle' : 'info-circle'); ?> alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Doctor Payment Entry</h2>
                    <p>Process and record doctor payments with comprehensive tracking and validation.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="printReceipt()">
                        <i class="fas fa-print"></i> Print Receipt
                    </button>
                </div>
            </div>
            <!-- Doctor Search Form Section -->
            <div class="search-form-section">
                <div class="search-form-header">
                    <i class="fas fa-user-md search-form-icon"></i>
                    <h3 class="search-form-title">Select Doctor</h3>
                </div>
                
                <form name="cbform1" method="post" action="doctorpaymententry.php" class="search-form">
                    <div class="form-group">
                        <label for="searchsuppliername" class="form-label">Search Doctor</label>
                        <input name="searchsuppliername" type="text" id="searchsuppliername" 
                               value="<?php echo htmlspecialchars($searchsuppliername); ?>" 
                               class="form-input" placeholder="Type doctor name to search..." autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="cbsuppliername" class="form-label">Doctor Name</label>
                        <input value="<?php echo htmlspecialchars($cbsuppliername); ?>" 
                               name="cbsuppliername" type="text" id="cbsuppliername" 
                               onKeyDown="return disableEnterKey()" onKeyUp="return FillDoctor()" 
                               class="form-input" placeholder="Doctor name will appear here..." 
                               <?php if($searchsuppliername != "") { ?> readonly <?php } ?>>
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" 
                               onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" 
                               value="<?php if($searchsuppliercode != '') { echo $searchsuppliercode; } else { echo '04-4602'; } ?>" />
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-search"></i>
                            Search Doctor
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>
            <?php
            // Handle doctor selection and advance payment check
            if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
            if ($cbfrmflag1 == 'cbfrmflag1') {
                $searchsuppliername = $_POST['searchsuppliername'];
                
                if ($searchsuppliername != '') {
                    $arraysupplier = explode("#", $searchsuppliername);
                    $arraysuppliername = $arraysupplier[0];
                    $arraysuppliername = trim($arraysuppliername);
                    $arraysuppliercode = $arraysupplier[1];
                    
                    $query1 = "select * from master_doctor where doctorcode = '$arraysuppliercode'";
                    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res1 = mysqli_fetch_array($exec1);
                    $supplieranum = $res1['auto_number'];
                    $openingbalance = $res1['openingbalance'];
                    $cbsuppliername = $arraysuppliername;
                    $suppliername = $arraysuppliername;
                } else {
                    $cbsuppliername = $_REQUEST['cbsuppliername'];
                    $suppliername = $_REQUEST['cbsuppliername']; 
                }
            }

            // Check for advance payments
            $total_pendingamount = 0;
            if (isset($arraysuppliercode)) {
                $query2 = "select * from advance_payment_entry where ledger_code='$arraysuppliercode' and transactionmodule = 'PAYMENT' and recordstatus<>'deleted' group by docno order by auto_number desc";
                $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                $num2 = mysqli_num_rows($exec2);
                while ($res2 = mysqli_fetch_array($exec2)) {
                    $totalamount = $res2['transactionamount'];
                    $transactiondate = $res2['transactiondate'];
                    $docno = $res2['docno'];
                    $transactionmode = $res2['transactionmode'];
                    $bankcode = $res2['bankcode'];
                    $bankname = $res2['bankname'];
                    $docname = $res2['ledger_name'];
                    
                    $query_adp = "SELECT sum(transactionamount) as transactionamount FROM `advance_payment_allocation` WHERE docno='$docno' and recordstatus='allocated'";
                    $exec_adp = mysqli_query($GLOBALS["___mysqli_ston"], $query_adp) or die ("Error in Query_adp".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $num_adp = mysqli_num_rows($exec_adp);
                    $res_adp = mysqli_fetch_array($exec_adp);
                    $total_adp_transactioamount = $res_adp['transactionamount'];
                    $pending_amount_doc = $totalamount - $total_adp_transactioamount;
                    $total_pendingamount += $pending_amount_doc;
                }
                
                if($total_pendingamount > 0) { ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle alert-icon"></i>
                        <span><strong>Doctor has Advance Payments!</strong> Please allocate the same against invoices to process the payment.</span>
                    </div>
                <?php }
            }
            ?>

            <!-- Payment Entry Form Section -->
            <?php if ($cbfrmflag1 == 'cbfrmflag1'): ?>
            <div class="payment-form-section">
                <div class="payment-form-header">
                    <i class="fas fa-credit-card payment-form-icon"></i>
                    <h3 class="payment-form-title">Payment Entry Details</h3>
                    <div class="opening-balance">
                        <span class="balance-label">Opening Balance:</span>
                        <span class="balance-value"><?php echo number_format($openingbalance, 2); ?></span>
                    </div>
                </div>
                
                <form name="form1" id="form1" method="post" action="doctorpaymententry.php?cbfrmflag1=<?php echo $cbfrmflag1; ?>" onSubmit="return paymententry1process1()" class="payment-form">
                    <input type="hidden" name="searchsuppliercode1" id="searchsuppliercode1" value="<?php if($searchsuppliercode != '') { echo $searchsuppliercode; } else { echo '04-4602'; } ?>" />
                    <input type="hidden" name="searchsuppliername1" id="searchsuppliername1" value="" />
                    <input type="hidden" name="cashcoa" value="<?php echo $cashcoa; ?>">
                    <input type="hidden" name="chequecoa" value="<?php echo $chequecoa; ?>">
                    <input type="hidden" name="mpesacoa" value="<?php echo $mpesacoa; ?>">
                    <input type="hidden" name="cardcoa" value="<?php echo $cardcoa; ?>">
                    <input type="hidden" name="onlinecoa" value="<?php echo $onlinecoa; ?>">
                    <input type="hidden" name="doctorcode" value="<?php echo $doctorcode; ?>">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="pendingamount" class="form-label">Total Pending Amount</label>
                            <input name="pendingamount" id="pendingamount" class="form-input amount-input" 
                                   value="<?php echo $openingbalance; ?>" readonly onKeyDown="return disableEnterKey()" />
                            <input name="pendingamounthidden" id="pendingamounthidden" type="hidden" 
                                   value="<?php echo $openingbalance; ?>" />
                        </div>
                        
                        <div class="form-group">
                            <label for="paymententrydate" class="form-label">Entry Date</label>
                            <div class="date-input-group">
                                <input name="paymententrydate" id="paymententrydate" 
                                       value="<?php echo date('Y-m-d'); ?>" class="form-input date-input" 
                                       readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('paymententrydate','','','','','','past','','<?=$updatedatetime;?>')" 
                                     class="date-picker-icon" style="cursor:pointer"/>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="paymentamount" class="form-label">Payment Amount</label>
                            <input name="paymentamount" id="paymentamount" class="form-input amount-input" 
                                   value="0.00" <?php if($searchsuppliername != "") { ?> readonly <?php } ?> 
                                   onKeyUp="return FillNetpay()" />
                        </div>
                        
                        <div class="form-group">
                            <label for="paymentmode" class="form-label">Payment Mode</label>
                            <select name="paymentmode" id="paymentmode" class="form-input">
                                <option value="" selected="selected">Select Payment Mode</option>
                                <option value="CHEQUE">CHEQUE</option>
                                <option value="CASH">CASH</option>
                                <option value="MPESA">MPESA</option>
                                <option value="ONLINE">ONLINE</option>
                                <option value="WRITEOFF">ADJUSTMENT</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="taxanum" class="form-label">Select Applicable WHT</label>
                            <select id="taxanum" name="taxanum" onChange="return netpayablecalc()" class="form-input">
                                <option value="">Select Tax</option>
                                <?php
                                $query1 = "select * from master_withholding_tax where record_status = '1' order by auto_number";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $res1taxname = $res1["name"];
                                    $res1taxpercent = $res1["tax_percent"];
                                    $res1anum = $res1["auto_number"];
                                    ?>
                                    <option value="<?php echo $res1anum; ?>"><?php echo $res1taxname.' ( '.$res1taxpercent.'% ) '; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="taxamount" class="form-label">Tax Amount</label>
                            <input name="taxamount" id="taxamount" class="form-input amount-input" readonly/>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="netpayable" class="form-label">Net Payable</label>
                            <input name="netpayable" id="netpayable" class="form-input amount-input" value="0.00" readonly/>
                        </div>
                        
                        <div class="form-group">
                            <!-- Empty space for layout balance -->
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="chequenumber" class="form-label">Cheque/Mpesa Number</label>
                            <input name="chequenumber" id="chequenumber" class="form-input" 
                                   value="" autocomplete="off" placeholder="Enter cheque or mpesa number" />
                        </div>
                        
                        <div class="form-group">
                            <label for="bankname" class="form-label">Bank Name</label>
                            <select name="bankname" id="bankname" class="form-input">
                                <option value="">Select Bank</option>
                                <?php 
                                $querybankname = "select * from master_bank where bankstatus <> 'deleted'";
                                $execbankname = mysqli_query($GLOBALS["___mysqli_ston"], $querybankname) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($resbankname = mysqli_fetch_array($execbankname)) { ?>
                                    <option value="<?php echo $resbankname['bankcode'].'||'.$resbankname['bankname']; ?>">
                                        <?php echo $resbankname['bankname']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <input type="hidden" name="bankbranch" id="bankbranch">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Payment Date</label>
                            <div class="date-input-group">
                                <input name="ADate1" id="ADate1" class="form-input date-input" 
                                       value="" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1','','','','','','past','','<?=$updatedatetime;?>')" 
                                     class="date-picker-icon" style="cursor:pointer"/>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="remarks" class="form-label">Remarks</label>
                            <input name="remarks" id="remarks" class="form-input" 
                                   value="" autocomplete="off" placeholder="Enter payment remarks" />
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="bankcharges" class="form-label">Bank Charges</label>
                            <input name="bankcharges" id="bankcharges" class="form-input amount-input" 
                                   value="0.00" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" 
                                   onKeyUp="bankCharges()" autocomplete="off" />
                        </div>
                        
                        <div class="form-group">
                            <!-- Empty space for layout balance -->
                        </div>
                    </div>

                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag2" value="<?php echo $supplieranum; ?>">
                        <input type="hidden" name="frmflag2" value="frmflag2">
                        
                        <button type="submit" id="form1button" class="submit-btn" onClick="return amountcheck()">
                            <i class="fas fa-save"></i>
                            Save Payment
                        </button>
                        
                        <button type="button" class="btn btn-secondary" onclick="resetPaymentForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>
            <?php endif; ?>
				
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
	$searchsuppliername = $_POST['searchsuppliername'];
	if ($searchsuppliername != '')
	{
		$arraysupplier = explode("#", $searchsuppliername);
		$arraysuppliername = $arraysupplier[0];
		$arraysuppliername = trim($arraysuppliername);
		$arraysuppliercode = $arraysupplier[1];
		
		$query1 = "select * from master_supplier where suppliercode = '$arraysuppliercode'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1 = mysqli_fetch_array($exec1);
		$supplieranum = $res1['auto_number'];
		$openingbalance = $res1['openingbalance'];
		$cbsuppliername = $arraysuppliername;
		$suppliername = $arraysuppliername;
		$suppliercode = $arraysuppliercode;
	}
	else
	{
		$cbsuppliername = $_REQUEST['cbsuppliername'];
		$suppliername = $_REQUEST['cbsuppliername'];
		$suppliercode = $_REQUEST['cbsuppliercode'];
	}

	if($total_pendingamount>0){ 
		exit();
					}
	/////////////////// fro checking the docotor is there any advance payment entry with pending!=0

	
/* 		  	$query21 = "select * from master_doctor where doctorname like '%$suppliername%' and status <>'DELETED' group by doctorname order by doctorname desc ";
			$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
			$res21 = mysql_fetch_array($exec21);
			$res21accountname = $res21['doctorname'];
			$supplieranum = $res21['auto_number'];
			$suppliercode = $res21['doctorcode']; */
	
	
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
            <tr>
              <td colspan="3" bgcolor="#ecf0f5" class="bodytext311"><strong><?php echo $suppliername; ?></strong></td>
              <td width="6%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="7%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
			  <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
         <td width="7%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
          <td width="7%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
            </tr>
            <tr>
              <td width="5%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><strong>No.</strong></td>
				  <td width="6%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><strong>Select</strong></td>
              <td width="15%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><strong>Patient</strong></td>
              <td width="5%" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Bill No </strong></div></td>
              <td width="5%" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Bill Date </strong></div></td>
              <td width="5%" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Bill Amt </strong></div></td>
              <td width="5%" class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong> After Bill </strong></div></td>
              <td width="5%" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Paid</strong></div></td>
              <td width="5%" class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Last Pmt </strong></div></td>
              <td width="5%"class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong> After Pmt </strong></div></td>
              <td width="5%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><div align="right"><strong>Pending</strong></div></td>
				  <td width="5%" class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong> Adj Amt</strong></div></td>
              <td width="5%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong> Bal Amt</strong></div></td>
            </tr>
            <?php
			
			$totalbalance = '';
			$sno = 0;
			$cashamount21 = '';
			$cardamount21 = '';
			$onlineamount21 = '';
			$chequeamount21 = '';
			$tdsamount21 = '';
			$taxamount21 = '';
			$writeoffamount21 = '';
			$mpesaamount21='';
			$totalnumbr='';
			$totalnumb=0;
			//$cashamount21 = '0.00';
				$cashamount21 = 0;
				//$cardamount21 = '0.00';
				$cardamount21 = 0;
				//$onlineamount21 = '0.00';
				$onlineamount21 = 0;
				//$chequeamount21 = '0.00';
				$chequeamount21 = 0;
				//$tdsamount21 = '0.00';
				$tdsamount21 = 0;
				//$writeoffamount21 = '0.00';
				$writeoffamount21 = 0;
				//$taxamount21 = '0.00';
				$taxamount21 = 0;
				//$totalpayment = '0.00';
				$totalpayment = 0;
				//$netpayment = '0.00';
				$netpayment = 0;
				//$balanceamount = '0.00';
				$balanceamount = 0;
				
				//$billtotalamount = '0.00';
				$billtotalamount = 0;
				//$netpayment = '0.00';
				$netpayment = 0;
				//$balanceamount = '0.00';
				$balanceamount = 0;
				
				//$billstatus = '0.00';
				$billstatus = 0;
			//include("doctorcount.php");
			$number = 0;
			$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$totalpurchase1=0;
			$colorloopcount=0;
			if (isset($_REQUEST["showbilltype"])) { $showbilltype = $_REQUEST["showbilltype"]; } else { $showbilltype = ""; }
			if ($showbilltype == 'All Bills')
			{
				$showbilltype = '';
			}
			
			?>
				
				<!-- Billing Start -->
			<?php
			//$query2 = "select patientname,patientcode,visitcode,accountname,billanum,billnumber,transactiondate from doctorsharing where doctorcode = '$suppliercode' ";
			//$query2 = "select description as doctorname,patientname,patientcode,visitcode,accountname,docno as billnumber,recorddate as transactiondate,original_amt,amount,sum(transactionamount) as transactionamount,sum(sharingamount) as transactionamount1,doccoa,visittype from billing_ipprivatedoctor where doccoa = '$suppliercode' group by billnumber,doccoa order by recorddate";
			
		/*	union
				(SELECT billingaccountname as doctorname,patientname,patientcode,patientvisitcode as  visitcode,accountname,docno as billnumber,consultationdate as transactiondate, amount as original_amt,amount,sum(amount) as transactionamount,sum(amount) as transactionamount1,billingaccountcode as doccoa,billtype as visittype,ref_no as docno_c  from adhoc_creditnote where billingaccountcode = '$suppliercode' group by billnumber,doccoa order by transactiondate )*/ 
			
			$query2 = "
			(select description as doctorname,patientname,patientcode,visitcode as visitcode,accountname,docno as billnumber,recorddate as transactiondate,original_amt as original_amt,amount,sum(transactionamount) as transactionamount,sum(sharingamount) as transactionamount1,doccoa as doccoa,billtype as visittype,docno as docno_c from billing_ipprivatedoctor where doccoa = '$suppliercode' group by billnumber,doccoa order by transactiondate)
			
				
				
			union
				(SELECT billingaccountname as doctorname,patientname,patientcode,patientvisitcode as  visitcode,accountname,docno as billnumber,consultationdate as transactiondate, amount as original_amt,amount,sum(amount) as transactionamount,sum(amount) as transactionamount1,billingaccountcode as doccoa,billtype as visittype,ref_no as docno_c  from adhoc_debitnote where billingaccountcode = '$suppliercode' group by billnumber,doccoa order by transactiondate ) 
			";
			
			//echo $query2;
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowcount2 = mysqli_num_rows($exec2);
			while ($res2 = mysqli_fetch_array($exec2))
			{
				$suppliername1 = $res2['patientname'];
				$patientcode = $res2['patientcode'];
				$visitcode = $res2['visitcode'];
				//$billautonumber=$res2['billanum'];
				 $billnumber = $res2['billnumber'];
				
				$billdate = $res2['transactiondate'];
				$suppliername = $res2['accountname'];
				$doctorname=$res2['doctorname'];
				$doccode=$res2['doccoa'];
				$visittype=$res2['visittype'];
				$docno_c=$res2['docno_c'];
			$visittype='';	
		$typebill='';
		$query21="select * from master_visitentry where visitcode='$visitcode'";
		$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$row21 = mysqli_num_rows($exec21);
			$res21 = mysqli_fetch_array($exec21);
			$typebill = 'OP';
			$visittype=$res21['billtype'];
				if($row21==0){
					$query21="select * from master_ipvisitentry where visitcode='$visitcode'";
		$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$row21 = mysqli_num_rows($exec21);
			$res21 = mysqli_fetch_array($exec21);
			$typebill = 'IP';
			$visittype=$res21['billtype'];
					
				}
				
				if($typebill=='OP') {
				  $amount_topay_doc = $res2['transactionamount'];
				}	else {
				  $amount_topay_doc = $res2['transactionamount1'];
				}
				$name = $res2['patientname'];
				$billtotalamount = $amount_topay_doc;
				
				$totalpayment =0;
				$netpayment =0;
				$cashamount21 = 0;
				$cardamount21 = 0;
				$mpesaamount21 = 0;
				$onlineamount21 = 0;
				$chequeamount21 = 0;
				$tdsamount21 = 0;
				$writeoffamount21 = 0;
				$taxamount21 = 0;
				
				$query3 = "select * from master_transactiondoctor where billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''  and acc_status <> 'deallocated' and doctorcode='$doccode'";
				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
				$numb=mysqli_num_rows($exec3);
				if($numb>0){
				while ($res3 = mysqli_fetch_array($exec3))
				{
					//echo $res3['auto_number'];
					$cashamount1 = $res3['cashamount'];
					$onlineamount1 = $res3['onlineamount'];
					$chequeamount1 = $res3['chequeamount'];
					$cardamount1 = $res3['cardamount'];
					$tdsamount1 = $res3['tdsamount'];
					$mpesaamount1 = $res3['mpesaamount'];
					$writeoffamount1 = $res3['writeoffamount'];
					
					
					$cashamount21 = $cashamount21 + $cashamount1;
					$mpesaamount21 = $mpesaamount21 + $mpesaamount1;
					$cardamount21 = $cardamount21 + $cardamount1;
					$onlineamount21 = $onlineamount21 + $onlineamount1;
					$chequeamount21 = $chequeamount21 + $chequeamount1;
					$tdsamount21 = $tdsamount21 + $tdsamount1;
					$writeoffamount21 = $writeoffamount21 + $writeoffamount1;
					
				}
				}else
				{
					$cashamount21 = 0;
					$mpesaamount21 = 0;
					$cardamount21 = 0;
					$onlineamount21 = 0;
					$chequeamount21 = 0;
					$tdsamount21 = 0;
					$writeoffamount21 = 0;
				}
			
				$totalpayment = $cashamount21 + $chequeamount21 + $onlineamount21 + $cardamount21+$mpesaamount21;
				$netpayment1 = $totalpayment + $tdsamount21 + $writeoffamount21;

				 ///////////// CASH REFUNDS/////////////
	 	  $query234 = "SELECT sum(sharingamount) as sharingamount, sum(transactionamount) as transactionamount, docno, percentage, pvtdr_percentage, visittype FROM `billing_ipprivatedoctor_refund` WHERE doccoa='$searchsuppliercode'  AND `visitcode` =  '$visitcode' and against_refbill='$billnumber' group by docno, visitcode ";
		  $exec234 = mysqli_query($GLOBALS["___mysqli_ston"], $query234) or die ("Error in Query234".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num234=mysqli_num_rows($exec234);
			// while($res234 = mysql_fetch_array($exec234)){
		  $res234 = mysqli_fetch_array($exec234);
		  $ref_doc = $res234['docno'];
		  $res45vistype = $res234['visittype'];
		  $res45transactionamount = $res234['sharingamount'];
		  if($res45vistype == "OP")
		  {
			$res45doctorperecentage = $res234['percentage'];
			 $res45transactionamount = $res234['transactionamount'];
		  }
		  else
		  {
			$res45doctorperecentage = $res234['pvtdr_percentage'];
		  }
		 // }
         ///////////// CASH REFUNDS/////////////
		 ///credit_note 
		$credit_amount=0;
		$query23 = "SELECT sum(amount) as amount FROM `adhoc_creditnote` WHERE ref_no='$billnumber'  AND `patientvisitcode` =  '$visitcode' and  billingaccountcode = '$doccode' ";
		$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num23=mysqli_num_rows($exec23);
		$res23= mysqli_fetch_array($exec23);
	    $credit_amount = $res23['amount'];

	    ////////////////// from allocation of ADJUST PAYMENT ENTRIES//
								$query_adp = "SELECT sum(transactionamount) as transactionamount FROM `advance_payment_allocation` WHERE doctorcode='$suppliercode'  AND `visitcode` =  '$visitcode' and billnumber='$billnumber' and recordstatus='allocated' group by billnumber, visitcode order by auto_number desc";
								$exec_adp = mysqli_query($GLOBALS["___mysqli_ston"], $query_adp) or die ("Error in Query_adp".mysqli_error($GLOBALS["___mysqli_ston"]));
								$num_adp=mysqli_num_rows($exec_adp);
								// while($res_adp = mysql_fetch_array($exec_adp)){
								$res_adp = mysqli_fetch_array($exec_adp);
								$res_adp_transactioamount = $res_adp['transactionamount'];

								$query_adp2 = "SELECT transactionamount, transactiondate,updatedate FROM `advance_payment_allocation` WHERE doctorcode='$suppliercode'  AND `visitcode` =  '$visitcode' and billnumber='$billnumber' and recordstatus='allocated' group by billnumber, visitcode order by auto_number desc limit 1";
								$exec_adp2 = mysqli_query($GLOBALS["___mysqli_ston"], $query_adp2) or die ("Error in Query_adp2".mysqli_error($GLOBALS["___mysqli_ston"]));
								$num_adp2=mysqli_num_rows($exec_adp2);
								// while($res_adp2 = mysql_fetch_array($exec_adp2)){
								$res_adp2 = mysqli_fetch_array($exec_adp2);
								 $res_adp2_transactioamount = $res_adp2['transactionamount'];
								 $res_adp2_transactiondate = $res_adp2['updatedate'];
				              ////////////////// from allocation of ADJUST PAYMENT ENTRIES//

				$balanceamount = $amount_topay_doc - $netpayment1 - $res45transactionamount -$credit_amount - $res_adp_transactioamount;

				$netpayment=$netpayment1+$res_adp_transactioamount;
		 
		// $balanceamount = $amount_topay_doc - $netpayment1 - $res45transactionamount-$credit_amount;
			
			$billtotalamount = number_format($billtotalamount, 2, '.', '');
			$netpayment = number_format($netpayment, 2, '.', '');
			$balanceamount = number_format($balanceamount, 2, '.', '');
			$billstatus = $billtotalamount.'||'.$netpayment.'||'.$balanceamount;
				
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
			
			
			if ($balanceamount != '0.00')
			{
			////fro paylater allocation checking
			
		$query00 = "SELECT * FROM `master_doctor` WHERE doctorcode='$doccode'   ";
		$exec00 = mysqli_query($GLOBALS["___mysqli_ston"], $query00) or die ("Error in Query00".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num00=mysqli_num_rows($exec00);
		$res00= mysqli_fetch_array($exec00);
		$excludeallocation = $res00['excludeallocation'];
			
		   $alloted_status='';
		   
		   if($visittype == 'PAY LATER'  && $excludeallocation=='0' )
		   {
				
			$query27 = "select billbalanceamount from master_transactionpaylater where billnumber='$billnumber' and (recordstatus='allocated') and transactionstatus <> 'onaccount' and acc_flag = '0'  and transactiontype='PAYMENT' order by auto_number desc limit 0,1";
			$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num2 = mysqli_num_rows($exec27);
					if($num2==0)
					{
						$alloted_status = "No";
					}
					else
					{
						$res27 = mysqli_fetch_array($exec27);
						$transc_amt_bal = $res27['billbalanceamount'];
							if($transc_amt_bal>0 )
							{
								$alloted_status = "Partly";
							}
							else
							{
							$alloted_status = "Fully";
							}
					 }	
						
			}
			if($visittype == 'PAY NOW' || strpos( $billnumber, "CF-" ) !== false)
			{
			   $alloted_status = "Fully";
			}
				
			if($alloted_status=='Fully' || $alloted_status==''){
			
			$date1 = $date1;
			$date2 = date("Y-m-d");  
			$diff = abs(strtotime($date2) - strtotime($date1));  
			$days = floor($diff / (60*60*24));  
			$daysafterbilldate = $days;
			
			//$query3 = "select * from master_transactiondoctor where billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = '' and billautonumber='$billautonumber' and acc_status <> 'deallocated' order by auto_number desc";
			$query3 = "select * from master_transactiondoctor where billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''  and acc_status <> 'deallocated' and doctorcode='$doccode' order by auto_number desc";
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res31 = mysqli_fetch_array($exec31);
			$numb1=mysqli_num_rows($exec31);
			$totalnumb=$totalnumb+$numb1;
			 
			$lastpaymentdate = $res31['transactiondate'];


				 $date1 =  strtotime($lastpaymentdate);
				$date2 =  strtotime($res_adp2_transactiondate); // Can use date/string just like strtotime.
				// echo $diff=var_dump($date1 > $date2);
				 if($date1 < $date2){
				 	 $lastpaymentdate=$res_adp2_transactiondate;
				 }

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
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">
			  <input type="checkbox" name="ack[]" id="acknow<?php echo $sno; ?>" value="<?php echo $sno; ?>" onClick="updatebox('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div class="bodytext311"><?php echo $name; ?>(<?php echo $visitcode; ?>)</div></td>
			  <input type="hidden" name="patientcode[]" id="patientcode" value="<?php echo $patientcode; ?>">
			  <input type="hidden" name="visitcode[]" id="visitcode" value="<?php echo $visitcode; ?>">
			  <input type="hidden" name="accountname[]" id="accountname" value="<?php echo $suppliername; ?>">
			  <input type="hidden" name="doctorname[]" value="<?php echo $doctorname; ?>">
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billnumber; ?></div></td>
              <input type="hidden" name="billnum[]" value="<?php echo $billnumber; ?>">
			  <input type="hidden" name="name[]" value="<?php echo $name; ?>">
              <input type="hidden" name="serialno[]" value="<?php echo $sno; ?>">
              <input type="hidden" name="billautonumber[]" value="<?php echo $billautonumber; ?>">
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billdate; ?></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
                <?php if ($billtotalamount != '0.00') echo number_format($billtotalamount,2,'.',','); ?>
              </div></td><input type="hidden" name="billamount" id="bill" value="<?php if ($billtotalamount != '0.00') echo $billtotalamount; ?>">
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left"><div align="right"><?php echo $daysafterbilldate.' Days'; ?></div>
                  <div align="right"></div>
                <div align="right"></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
                <?php if ($netpayment != '0.00') echo number_format($netpayment,2,'.',','); ?>
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
                <?php if ($balanceamount != '0.00') echo  number_format($balanceamount,2,'.',','); ?>
              </div></td>
			      <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">
					<input class="bali" type="text" name="adjamount[]" id="adjamount<?php echo $sno; ?>" size="7" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')" autocomplete="off">
					</td>
            <td class="bodytext311" valign="center" bordercolor="#f3f3f3"><input type="text" class="bal" name="balamount[]" id="balamount<?php echo $sno; ?>" size="7" readonly></td>
            </tr>
            <?php
				$totalbalance = $totalbalance + $balanceamount;
				}
			}else{
                  $totalpayment =0;
				$netpayment =0;
				}
				 $credit_amount=0;
				//$cashamount21 = '0.00';
				$cashamount21 = 0;
				//$cardamount21 = '0.00';
				$cardamount21 = 0;
				//$onlineamount21 = '0.00';
				$onlineamount21 = 0;
				//$chequeamount21 = '0.00';
				$chequeamount21 = 0;
				//$tdsamount21 = '0.00';
				$tdsamount21 = 0;
				//$writeoffamount21 = '0.00';
				$writeoffamount21 = 0;
				//$taxamount21 = '0.00';
				$taxamount21 = 0;
				//$totalpayment = '0.00';
				$totalpayment = 0;
				//$netpayment = '0.00';
				$netpayment = 0;
				//$balanceamount = '0.00';
				$balanceamount = 0;
				
				//$billtotalamount = '0.00';
				$billtotalamount = 0;
				//$netpayment = '0.00';
				$netpayment = 0;
				//$balanceamount = '0.00';
				$balanceamount = 0;
				
				//$billstatus = '0.00';
				$billstatus = 0;
			}
			?>
				<!-- Billing End -->
			
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
                bgcolor="#ecf0f5"><div align="right"><strong>
                <?php //echo number_format($totalpurchaseamount, 2); ?>
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
                bgcolor="#ecf0f5"><div align="right"><strong><?php if ($totalbalance != '') echo number_format($totalbalance,2,'.',','); ?></strong></div></td>
             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">
				<input type="hidden" name="totcount" id="totcount" value="<?php echo $sno; ?>">
				<input type="text" name="totaladjamt" id="totaladjamt" readonly size="7" class="bal"></td>
             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
			</tr>
          </tbody>
        </table>
            <?php
            }
            ?>

        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/doctor-payment-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
