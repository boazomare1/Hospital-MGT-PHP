<?php
session_start();
//echo session_id();
include ("db/db_connect.php");
include ("includes/loginverify.php");
error_reporting(0);
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$registrationdate = date('Y-m-d');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$docno = $_SESSION['docno'];
if (isset($_REQUEST["id"])) { $id = $_REQUEST["id"]; } else { $id = ""; }
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }

$query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1location = $res1["locationname"]; 
$res1locationcode = $res1["locationcode"];
$searchlocation = $res1["locationcode"];

$query231 = "select * from master_employeelocation where username='$username' and locationcode='".$searchlocation."' and defaultstore = 'default' order by locationname";
$exec231 = mysqli_query($GLOBALS["___mysqli_ston"], $query231) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res231 = mysqli_fetch_array($exec231);
$res7locationanum1 = $res231['locationcode'];
$location3 = $res231['locationname'];
$storeanum = $res231['storecode'];

$query751 = "select * from master_store where auto_number='$storeanum'";
$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res751 = mysqli_fetch_array($exec751);
$store3 = $res751['store'];
$storecode = $res751['storecode'];


if($frm1submit1=='frm1submit1'){
	
$theater_surg=$_REQUEST['theater_surg'];
$theater_anesth=$_REQUEST['theater_anesth'];
$theater_otcons=$_REQUEST['theater_otcons'];
$theater_otother=$_REQUEST['theater_otother'];
$theater_otservice=$_REQUEST['theater_otservice'];


$patientfullname = $_REQUEST['patientfullname'];
$patientcode = $_REQUEST['patientcode'];
$visitcode = $_REQUEST['visitcode'];
$billtype = $_REQUEST['billtypes'];
$age=$_REQUEST['age'];
$gender=$_REQUEST['gender'];
$account = $_REQUEST['accountnamename'];
$subtypeano = $_REQUEST['subtypeano'];

$query2 = "select sum(rows) as rows from (SELECT  count(auto_number) AS rows FROM billing_ipcreditapproved WHERE visitcode = '$visitcode'
UNION ALL 
SELECT  count(auto_number) AS rows FROM billing_ip WHERE visitcode = '$visitcode') as a";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$rows = $res2['rows'];
if($rows> 0 ){
echo "<script>alert('Bill Already Finalized');history.back();</script>";
exit;
}

if($theater_surg=='theater_surg'){
	
$paynowbillprefix = 'IPD-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ipprivate_doctor order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
$billnumbercode ='IPD-'.'1';
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
$billnumbercode = 'IPD-' .$maxanum;
$openingbalance = '0.00';
//echo $companycode;
}	

foreach($_POST['referal'] as $key=>$value){	
//echo '<br>'.
$pairs= $_POST['referal'][$key];
$pairvar= $pairs;
$pairs1= $_POST['rate4'][$key];
$pairvar1= $pairs1;
$units = 1;
$amount = $_POST['rate4'][$key];
$pairvar1 = $amount;
$description = $_POST['description'][$key];
//$servicecode = $_POST['descriptioncode'][$key];
$servicecode ='';
$doccoa= $_POST['referalcode'][$key];

if($pairvar!="")
{
$referalquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into ipprivate_doctor(docno,units,amount,patientcode,patientname,patientvisitcode,doctorname,rate,billtype,accountname,consultationdate,paymentstatus,consultationtime,username,ipaddress,remarks, servicecode, locationcode,doccoa,pvt_flg,from_module)
values('$billnumbercode','$units','$amount','$patientcode','$patientfullname','$visitcode','$pairvar','$pairvar1','$billtype','$account','$dateonly','pending','$timeonly','$username','$ipaddress','$description','$servicecode', '$res1locationcode','$doccoa','1','fromtheaterbilling')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
}
}
	
} 

if($theater_anesth=='theater_anesth'){

$paynowbillprefix = 'IPD-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ipprivate_doctor order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
$billnumbercode ='IPD-'.'1';
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
$billnumbercode = 'IPD-' .$maxanum;
$openingbalance = '0.00';
//echo $companycode;
}

foreach($_POST['referal_anesthetic'] as $key=>$value){	
//echo '<br>'.
$pairs= $_POST['referal_anesthetic'][$key];
$pairvar= $pairs;
$pairs1= $_POST['rate4_anesthetic'][$key];
$pairvar1= $pairs1;
$units = 1;
$amount = $_POST['rate4_anesthetic'][$key];
$pairvar1 = $amount;
$description = $_POST['description_anesthetic'][$key];
//$servicecode = $_POST['descriptioncode_anesthetic'][$key];
$servicecode = '';
$doccoa= $_POST['referalcode_anesthetic'][$key];

if($pairvar!="")
{
$referalquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into ipprivate_doctor(docno,units,amount,patientcode,patientname,patientvisitcode,doctorname,rate,billtype,accountname,consultationdate,paymentstatus,consultationtime,username,ipaddress,remarks, servicecode, locationcode,doccoa,pvt_flg,from_module)
values('$billnumbercode','$units','$amount','$patientcode','$patientfullname','$visitcode','$pairvar','$pairvar1','$billtype','$account','$dateonly','pending','$timeonly','$username','$ipaddress','$description','$servicecode', '$res1locationcode','$doccoa','1','fromtheaterbilling')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
}
}

	
}

if($theater_otcons=='theater_otcons'){
$paynowbillprefix = 'IPMP-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ipmedicine_prescription where recordstatus = '' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='IPMP-'.'1';
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
	$billnumbercode = 'IPMP-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}	
$dischargemedicine = isset($_REQUEST["dischargemedicine"])? 'Yes' : 'No';
	for ($p=1;$p<=100;$p++)
	{	
		    $medicinename = $_REQUEST['medicinename'.$p];
			$medicinename = addslashes($medicinename);
			$medicinecode = trim($_REQUEST['medicinecode'.$p]);
			
			$query77="select * from master_medicine where itemcode='$medicinecode' and status =''";
			$exec77=mysqli_query($GLOBALS["___mysqli_ston"], $query77);
			$res77=mysqli_fetch_array($exec77);
			$medicinecode=$res77['itemcode'];
			//$rate=$res77[$locationcodeget.'rateperunit'];
			$categoryname = $res77['categoryname'];
			if($medicinecode==""){
				continue;
			}

			$quantity = $_REQUEST['quantity'.$p];
			$frequency = $_REQUEST['frequency'.$p];
			$days = $_REQUEST['days'.$p];
			$dose = $_REQUEST['dose'.$p];
			$dosemeasure = $_REQUEST['dosemeasure'.$p];
			$pharmfree = $_REQUEST['pharmfree'.$p];
			$instructions = $_REQUEST['instructions'.$p];
			$route = $_REQUEST['route'.$p];
			$hour = $_REQUEST['hour'.$p];
			$minute = $_REQUEST['minute'.$p];
			$sec = '00';
			$expirymonth = substr($expirydate, 0, 2);
			$expiryyear = substr($expirydate, 3, 2);
			$expiryday = '01';
			$expirydate = $expiryyear.'-'.$expirymonth.'-'.$expiryday;
			$starttime = $hour.':'.$minute.':'.$sec;
			$sess = $_REQUEST['sess'.$p];
			$rates= $_REQUEST['rates'.$p];
			$amounts= $_REQUEST['amounts'.$p];
			$fifo_code = $_REQUEST['fifo_code'.$p];
			$medicinebatch = $_REQUEST['medicinebatch'.$p];
			$medicinebatch = str_replace(" ","",$medicinebatch);
			$medicinebatch = trim($medicinebatch);
			$uniquebatch = $_REQUEST['uniquebatch'.$p];
		
			$query40 = "select rate from transaction_stock where batch_stockstatus='1' and itemcode='$medicinecode' and locationcode='$res1locationcode' and batchnumber ='$medicinebatch' and fifo_code='$fifo_code' and storecode ='$storecode' limit 0,1";	
			$exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die ("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res40 = mysqli_fetch_array($exec40);
			$rate = $res40['rate'];

			$amount = $quantity * $rate;

			$query6 = "select ledgername, ledgercode, ledgerautonumber,incomeledger,incomeledgercode from master_medicine where itemcode = '$medicinecode'"; 
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6 = mysqli_fetch_array($exec6);
			$ledgername = $res6['ledgername'];
			$ledgercode = $res6['ledgercode'];
			$ledgeranum = $res6['ledgerautonumber'];
			$incomeledger =$res6['incomeledger'];
			$incomeledgercode = $res6['incomeledgercode'];

			if ($medicinename != "")// && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
			{
				$querycumstock2 = "select cum_quantity from transaction_stock where cum_stockstatus='1' and itemcode='$medicinecode' and locationcode='$res1locationcode'";
				$execcumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querycumstock2) or die ("Error in CumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$rescumstock2 = mysqli_fetch_array($execcumstock2);
				$cum_quantity = $rescumstock2["cum_quantity"];
				$cum_quantity = $cum_quantity-$quantity;
				if($cum_quantity=='0'){ $cum_stockstatus='0'; }else{$cum_stockstatus='1';}
				//echo $cum_quantity.','.$itemcode.'<br>';
				if(true)
				{
				$querybatstock2 = "select batch_quantity, auto_number from transaction_stock where batch_stockstatus='1' and itemcode='$medicinecode' and locationcode='$res1locationcode' and fifo_code='$fifo_code' and storecode ='$storecode'";
				$execbatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querybatstock2) or die ("Error in batQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$resbatstock2 = mysqli_fetch_array($execbatstock2);
					$bat_quantity = $resbatstock2["batch_quantity"];
					$auto_num1 = $resbatstock2["auto_number"];
					$quantity = intval($quantity);
					$bat_quantity = $bat_quantity-$quantity;
					$bat_quantity = intval($bat_quantity);
					//echo $bat_quantity.','.$itemcode.'<br>';
					if($bat_quantity=='0'){ $batch_stockstatus='0'; }else{$batch_stockstatus='1';}
					if($bat_quantity>='0')
					{
						$querycheckbat = "select auto_number from transaction_stock where itemcode='$medicinecode' and locationcode='$res1locationcode' and fifo_code='$fifo_code' and storecode ='$storecode' and auto_number > '$auto_num1'";
						$execcheckbat= mysqli_query($GLOBALS["___mysqli_ston"], $querycheckbat) or die ("Error in checkbat".mysqli_error($GLOBALS["___mysqli_ston"]));
						$num252 = mysqli_num_rows($exec251);
						if($num252 == 0){
						$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' ,batch_stockstatus='0' where itemcode='$medicinecode' and locationcode='$res1locationcode' and storecode='$storecode' and fifo_code='$fifo_code'";
						$execupdatebatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatebatstock2) or die ("Error in updatebatQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

						$stockquery2="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,
						batchnumber, batch_quantity,transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,patientcode,patientvisitcode,patientname,rate,totalprice,ledgeranum,ledgercode,ledgername,incomeledger,incomeledgercode)
						values ('$fifo_code','pharmacysales_details','$medicinecode', '$medicinename', '$dateonly','0', 'IP Direct Sales', '$medicinebatch', '$bat_quantity', '$quantity','$cum_quantity', '$billnumbercode', '','$cum_stockstatus','$batch_stockstatus', '$res1locationcode','','$storecode', '', '$username', '$ipaddress','$dateonly','$timeonly','$updatedatetime','$patientcode','$visitcode','$patientfullname','$rate','$amount','$ledgeranum','$ledgercode','$ledgername','$incomeledger','$incomeledgercode')";
						$stockexecquery2=mysqli_query($GLOBALS["___mysqli_ston"], $stockquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

						$query86 ="insert into ipmedicine_prescription(itemname,itemcode,quantity,prescribed_quantity,rateperunit,totalrate,batchnumber,companyanum,patientcode,visitcode,patientname,username,ipaddress,date,account,docno,billtype,expirydate,starttime,session,frequency,dose,days,freestatus,route,dischargemedicine,medicineissue,instructions,locationcode,locationname,dosemeasure)values('$medicinename','$medicinecode','$quantity','$quantity','$rates','$amounts','$medicinebatch','$companyanum','$patientcode','$visitcode','$patientfullname','$username','$ipaddress','$dateonly','$account','$billnumbercode','$billtype','$expirydate','$starttime','$sess','$frequency','$dose','$days','$pharmfree','$route','$dischargemedicine','completed','$instructions','".$res1locationcode."','".$res1location."','$dosemeasure')"; 
						$exec86 = mysqli_query($GLOBALS["___mysqli_ston"], $query86) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

						$query66 ="insert into pharmacysales_details(fifo_code,itemname,itemcode,quantity,rate,totalamount,batchnumber,companyanum,patientcode,visitcode,patientname,financialyear,username,ipaddress,entrydate,accountname,ipdocno,entrytime,location,store,issuedfrom,freestatus,categoryname,route,locationcode,locationname,ledgeranum,ledgercode,ledgername,incomeledger,incomeledgercode,costprice,totalcp,from_module)values('$fifo_code','$medicinename','$medicinecode','$quantity','$rates','$amounts','$medicinebatch','$companyanum','$patientcode','$visitcode','$patientfullname','$financialyear','$username','$ipaddress','$dateonly','$account','$billnumbercode','$timeonly','$searchlocation','$storecode','ip','$pharmfree','$categoryname','$route','".$res1locationcode."','".$res1location."','$ledgeranum','$ledgercode','$ledgername','$incomeledger','$incomeledgercode','$rate','$amount','fromtheaterbilling')";
						$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

						$query86 ="insert into ipmedicine_issue(itemname,itemcode,quantity,rateperunit,totalrate,batchnumber,companyanum,patientcode,visitcode,patientname,username,ipaddress,date,account,docno,billtype,expirydate,starttime,session,frequency,dose,days,freestatus,route,dischargemedicine,instructions,locationcode,locationname,dosemeasure,from_module)values('$medicinename','$medicinecode','$quantity','$rates','$amounts', '$medicinebatch','$companyanum','$patientcode','$visitcode','$patientfullname','$username','$ipaddress','$dateonly','$account','$billnumbercode','$billtype','$expirydate','$starttime','$sess','$frequency','$dose','$days','$pharmfree','$route','$dischargemedicine','$instructions','".$res1locationcode."','".$res1location."','$dosemeasure','fromtheaterbilling')";
						$exec86 = mysqli_query($GLOBALS["___mysqli_ston"], $query86) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

						}

					}

				}

		    }

		}	
}

if($theater_otother=='theater_otother'){

$paynowbillprefix = 'MSC-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ipmisc_billing order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='MSC-'.'1';
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
	$billnumbercode = 'MSC-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

		foreach($_POST['referal_otother'] as $key=>$value){	
		//echo '<br>'.
		$pairs= $_POST['referal_otother'][$key];
		$pairvar= $pairs;
		$pairs1= $_POST['rate4_otother'][$key];
		$pairvar1= $pairs1;
		$units = $_POST['units'][$key];
		$amount = $_POST['amount_otother'][$key];
		$accountname=$_POST['accountname_otother'][$key];
		$accountcode=$_POST['accountcode_otother'][$key];

		if($pairvar!="")
		{
		$referalquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into ipmisc_billing(docno,units,amount,patientcode,patientname,patientvisitcode,description,rate,billtype,billingaccountcode,billingaccountname,accountname,consultationdate,paymentstatus,consultationtime,remarks,username,ipaddress,locationname,locationcode,from_module)values('$billnumbercode','$units','$amount','$patientcode','$patientfullname','$visitcode','$pairvar','$pairvar1','$billtype','$accountcode','$accountname','$account','$dateonly','pending','$timeonly','','$username','$ipaddress','".$searchlocation."','".$res1locationcode."','fromtheaterbilling')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		}
		}
}

if($theater_otservice=='theater_otservice'){
	
$paynowbillprefix = 'TP-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from iptest_procedures order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
$billnumbercode ='TP-'.'1';
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
$billnumbercode = 'TP-' .$maxanum;
$openingbalance = '0.00';
//echo $companycode;
}

		foreach($_POST['services'] as $key => $value)
		{
				    //echo '<br>'.$k;
		//$ledgercode=$_POST["ledgercode"][$key];
 		//$ledgername=$_POST["ledgername"][$key];
		$servicesname=addslashes($_POST["services"][$key]);

		$query13s = "select sertemplate from master_subtype where auto_number = '$subtypeano' order by subtype";
		$exec13s = mysqli_query($GLOBALS["___mysqli_ston"], $query13s) or die ("Error in Query13s".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res13s = mysqli_fetch_array($exec13s);
		$tablenames = $res13s['sertemplate'];
		if($tablenames == '')
		{
		  $tablenames = 'master_services';
		}
		
		$stringbuild1 = "";
		
		$servicescode=$_POST["servicescode"][$key];
		$serdoct=$_POST["serdoct"][$key];
		$serdoctcode=$_POST["serdoctcode"][$key];
		$servicesrate=$_POST["rate3"][$key];
		$servicesfree = $_POST["servicesfree"][$key];
		$quantityser=$_POST['quantityser3'][$key];
		$seramount=$_POST['totalservice3'][$key];
		
		if(($servicesname!="")&&($servicesrate!=''))
		{
		$servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], "INSERT into ipconsultation_services(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,consultationdate,paymentstatus,process,iptestdocno,accountname,billtype,consultationtime,freestatus,locationcode,serviceqty,amount,incomeledgercode,incomeledgername,username,doctorcode,doctorname,from_module)values('$patientcode','$patientfullname','$visitcode','$servicescode','$servicesname','$servicesrate','$dateonly','paid','pending','$billnumbercode','$account','$billtype','$timeonly','$servicesfree','$res1locationcode','".$quantityser."','".$seramount."','$ledgercode','$ledgername','$username','$serdoctcode','$serdoct','fromtheaterbilling')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		mysqli_query($GLOBALS["___mysqli_ston"], "insert into iptest_procedures(docno,patientname,patientcode,visitcode,account,recorddate,ipaddress,recordtime,username,billtype,locationcode,doctorcode,doctorname)values('$billnumbercode','$patientfullname','$patientcode','$visitcode','$account','$dateonly','$ipaddress','$timeonly','$username','$billtype','$res1locationcode','$serdoctcode','$serdoct')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		}			
}

//exit;
header("location:theatrelistreport.php");
	
}




if($cbfrmflag1=='cbfrmflag1'){
	
$paynowbillprefix = 'IPMP-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ipmedicine_prescription where recordstatus = '' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='IPMP-'.'1';
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
	$billnumbercode = 'IPMP-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}	
		
$query3_01 = "select * from master_theatre_booking where auto_number = '$id'";
$exec3_01 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_01) or die ("Error in Query3_0".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3_01 = mysqli_fetch_array($exec3_01);
$patientcode = $res3_01['patientcode'];
$procedure_type =$res3_01['proceduretype'];
$theatre_code =$res3_01['theatrecode'];
$category =$res3_01['category'];
$speaciality =$res3_01['speaciality'];
$surgerydatetime =$res3_01['surgerydatetime'];
$estimatedtime =$res3_01['estimatedtime'];
$surgeon =$res3_01['surgeon'];
$anesthesia =$res3_01['anesthesia'];
$anesthesiatype =$res3_01['anesthesiatype'];
$ward = $res3_01['ward'];
$assistant_surgeon = $res3_01['assistant_surgeon'];
$anaesthetisit_note = $res3_01['anaesthetisit_note'];
$doctor_note = $res3_01['doctor_note'];
$patient_type = $res3_01['patient_type'];
$visitcode = $res3_01['patientvisitcode'];
$s_side = $res3_01['side'];
$timestamp=$res3_01['date'];
$splitTimeStamp = explode(" ",$timestamp);
$date_register = $splitTimeStamp[0];
$time_register = $splitTimeStamp[1];

		$Queryloc=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_ipvisitentry where visitcode='$visitcode'");
		$execloc=mysqli_fetch_array($Queryloc);
		 $locationcode=$execloc['locationcode'];
		 $locationname=$execloc['locationname'];
		 $packcharge = $execloc['packchargeapply'];
		 $billtype = $execloc['billtype'];

		$query3 = "select * from master_customer where customercode = '$patientcode'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res3 = mysqli_fetch_array($exec3);
		$patientfirstname = $res3['customername'];
		$patientfirstname = strtoupper($patientfirstname);
		$patientmiddlename = $res3['customermiddlename'];
		$patientmiddlename = strtoupper($patientmiddlename);
		$patientlastname = $res3['customerlastname'];
		$patientlastname = strtoupper($patientlastname);
		$patientfullname = $res3['customerfullname'];
		$patientfullname = strtoupper($patientfullname);
		$paymenttype1 = $res3['paymenttype'];
		$paymenttype = $res3['paymenttype'];
		$mrdno = $res3['mrdno'];
		$memberno = $res3['memberno'];
		$photoavailable = $res3['photoavailable'];
		$res11locationcode=$res3['locationcode'];
		$patientspent=$res3['opdue'];
		//$billtype = $res3['billtype'];
		$age = $res3['age'];
		$dateofbirth = $res3["dateofbirth"];
		$subtype = $res3['subtype'];
		$gender = $res3['gender'];
		$accountname = $res3['accountname'];
	
		$query4 = "select * from master_accountname where auto_number = '$accountname'";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res4 = mysqli_fetch_array($exec4);
		$accountnameanum = $res4['auto_number'];
		$accountname = $res4['accountname'];
		
	
		$query4 = "select * from master_paymenttype where auto_number = '$paymenttype'";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res4 = mysqli_fetch_array($exec4);
		$paymenttypeanum = $res4['auto_number'];
		$paymenttype = $res4['paymenttype'];
		
		$query51 = "select * from master_visitentry where patientcode = '$patientcode' and recordstatus = '' order by auto_number desc limit 0,1";
		$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res51 = mysqli_fetch_array($exec51);
		$lastvisitdate = $res51['consultationdate'];
		
		$query24 = "select subtype,auto_number from master_subtype where auto_number = '$subtype'";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res4 = mysqli_fetch_array($exec4);
		$subtype = $res4['subtype'];
		$subtypeanum = $res4['auto_number'];
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
#position
{
position: absolute;
    left: 830px;
    top: 420;
}
-->
</style>

<style>
.hideClass
{display:none;}
</style>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
#position
{
position: absolute;
    left: 830px;
    top: 420;
}

.custom-header{
	background-color: #c3eeb7;
	color:#000;
	text-transform: bold;
	text-align: center;
}
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/datetimepicker_css.js"></script>  
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link href="css/autocomplete.css" rel="stylesheet"> 
<link rel="stylesheet" type="text/css" href="css/multi-select.css">
<script src="js/jquery.multi-select.js" type="text/javascript"></script> 
<script type="text/javascript" src="js/insertnewsurgeondetails.js"></script>
<script type="text/javascript" src="js/insertnewsurgeondetails_anesthetic.js"></script>
<?php include ("js/dropdownlist1newscriptingmedicine1.php"); ?>
<script type="text/javascript" src="js/autosuggestipmedicineissue1new.js"></script> 
<script type="text/javascript" src="js/autocomplete_ipmedicineissue.js"></script>
<script type="text/javascript" src="js/automedicinecodesearchipmedicineissue1.js"></script>
<script type="text/javascript" src="js/autocomplete_batchnumberippharmacyissue.js"></script>
<script type="text/javascript" src="js/insertnewitemipmedicineissue1new1.js?v=2"></script>
<script type="text/javascript" src="js/autocomplete_expirydate1ipmedicineissue.js"></script>
<script type="text/javascript" src="js/autocomplete_stockipmedicineissue.js"></script>
<script type="text/javascript" src="js/autosuggestservices1.js"></script>
<script type="text/javascript" src="js/autoservicescodesearch2.js"></script>
<script type="text/javascript" src="js/insertnewitem44ipser_new_theater.js"></script>
<?php include ("js/sales1scripting1.php"); ?>
<script type="text/javascript" src="js/insertnewitemipmiscbilling_otother.js"></script>
<script type="text/javascript" src="js/autosuggesaccountsearch1.js"></script>
<script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>
</head>
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
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
</style>
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
$(document).ready(function(e) {
$(function() {
$('.show_chkbox_status').hide();	
	
$('#referal').autocomplete({	
	source:'ajaxsurgeonsearch_theater.php',
	minLength:3,
	delay: 0,
	html: true, 
		select: function(event,ui){
			  var referal = ui.item.itemname;	
			  var referalcode=ui.item.itemcode;
			  var rate4=ui.item.res1doctorfees;
			  var description=ui.item.department;
			 //alert(decriptioncode);
			  document.getElementById('referal').value=referal;
			  document.getElementById('referalcode').value=referalcode;
			  document.getElementById('rate4').value=rate4;
			  //document.getElementById('description').value=description;
			},
    });
	
	$('#referal_anesthetic').autocomplete({	
	source:'ajaxsurgeonsearch_theater.php',
	minLength:3,
	delay: 0,
	html: true, 
		select: function(event,ui){
			  var referal = ui.item.itemname;	
			  var referalcode=ui.item.itemcode;
			  var rate4=ui.item.res1doctorfees;
			  var description=ui.item.department;
			 //alert(decriptioncode);
			  document.getElementById('referal_anesthetic').value=referal;
			  document.getElementById('referalcode_anesthetic').value=referalcode;
			  document.getElementById('rate4_anesthetic').value=rate4;
			 // document.getElementById('description_anesthetic').value=description;
			},
    });

 $('#service_chkbox').change(function() {
        if(this.checked) {
			var servicesname = "Use of Implants";
			var servicescode = "SER083";
			// checkbox is checked
			$('#servicescode').val(servicescode);   
			$('#services').val(servicesname);
			$('#hiddenservices').val(servicesname);
			$('#services').prop('readonly', true);
			$('.show_chkbox_status').show();

			//funcservicessearch7(); //autocustomercodesearch2.js
			
			var baseunit = $('#baseunit').val();
			
		  	if(baseunit == 0)
		  	{
		  		$('#baseunit').val(1);
		  	}

        }
        else
        {
        	//checkbox is un checked
        	$('.show_chkbox_status').hide();
        	$('#services').prop('readonly', false);
        	var datas = 'serv';
        	cleardatas(datas);
        	$('#services').val('');
        	$('#hiddenservices').val('');
        }         
    });

$('#serdoct').autocomplete({
source:"ajaxdoc.php",
select:function(event,ui){
$('#serdoct').val(ui.item.value);
$('#serdoctcode').val(ui.item.id);
}
});

$("#costprice").keyup(function(){
		var percentval = $('#percentage').val();
		var costprice  = $( this ).val();
		var newprice = (costprice/100)*percentval;
		var finalprice = (parseFloat(costprice) + parseFloat(newprice)).toFixed(2);
		$('#rate3').val(finalprice);
		$('#quantityser3').keyup();
    });
	
	
$('#description').autocomplete({
source:'descriptionsearch.php?subtype="+subtype+"',
minLength:3,
delay: 0,
html: true, 
select: function(event,ui){
var description = ui.item.itemname;	
var decriptioncode=ui.item.itemcode;
//alert(decriptioncode);
document.getElementById('descriptioncode').value=decriptioncode;
},
});

$('#description_anesthetic').autocomplete({
source:'descriptionsearch.php?subtype="+subtype+"',
minLength:3,
delay: 0,
html: true, 
select: function(event,ui){
var description = ui.item.itemname;	
var decriptioncode=ui.item.itemcode;
//alert(decriptioncode);
document.getElementById('descriptioncode_anesthetic').value=decriptioncode;
},
});
	
	
	
	});
});

$(function() {
$('#services').autocomplete({
source:"ajaxautocomplete_services.php?subtype=<?php echo $subtype;?>&&loc=<?php echo $res1locationcode; ?>",
select:function(event,ui){
$('#services').val(ui.item.value);
customernamelostfocus2();
}
});	
});

function validcheck()
{
if (confirm("Do You Want To Save The Record?")==false){return false;
document.getElementById("Submit").disabled = false;	}

//document.getElementById("Submit").disabled = true;	

}

function clearcode(id)
{
document.getElementById(id).value='';
}
function clearcode_anesthetic(id)
{
document.getElementById(id).value='';
}

function cleardatas(datas)
{
	if(datas=='serv')
{
//document.getElementById("serialnumber3").value='';
document.getElementById("servicescode").value='';
document.getElementById("rate3").value='';
document.getElementById("ledgercode").value='';
document.getElementById("ledgername").value='';
document.getElementById("baseunit").value='';
document.getElementById("incrqty").value='';
document.getElementById("incrrate").value='';
document.getElementById("slab").value='';
document.getElementById("quantityser3").value='';
document.getElementById("totalservice3").value='';
document.getElementById("servicesfree").value='';
document.getElementById("pkg2").value='';


}
}

function btnDeleteClick6(delID4)
{
	//alert ("Inside btnDeleteClick.");
	var newtotal;
	//alert(delID4);
	var varDeleteID4= delID4;
	//alert(varDeleteID4);
	//alert(rateref);
	var fRet7; 
	fRet7 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet7 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}
	
	var amountid='amount_otother'+varDeleteID4+'';
	//alert(amountid);
	var varamount12= parseFloat(document.getElementById(amountid).value);
	//alert(varamount12);
	var vartotal12= parseFloat(document.getElementById('total_otother').value);
	//alert(vartotal12);
	vartotal12=vartotal12-varamount12;
	document.getElementById('total_otother').value=vartotal12.toFixed(2);
	
	var child4 = document.getElementById('idTR_otother'+varDeleteID4);  
	//alert (child3);//tr name
    var parent4 = document.getElementById('insertrow_otother'); // tbody name.
	document.getElementById ('insertrow_otother').removeChild(child4);
	var child4= document.getElementById('idTRaddtxt'+varDeleteID4);  //tr name
    var parent4 = document.getElementById('insertrow_otother'); // tbody name.

	if (child4 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow_otother').removeChild(child4);
	}
var scode=document.getElementById('scode').value;
scode=parseInt(scode)-1;
document.getElementById('scode').value=scode;	
}

function btnDeleteClick4(delID4)
{
	var newtotal;
	//alert(delID4);
	var varDeleteID4= delID4;
	//alert(varDeleteID4);
	var fRet7; 
	fRet7 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet7 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}
	
	var amountid='rate4'+varDeleteID4+'';
	//alert(amountid);
	var varamount12= parseFloat(document.getElementById(amountid).value);
	//alert(varamount12);
	var vartotal12= parseFloat(document.getElementById('total_surg').value);
	//alert(vartotal12);
	vartotal12=vartotal12-varamount12;
	document.getElementById('total_surg').value=vartotal12.toFixed(2);
	
	var child4 = document.getElementById('idTR_surgeon'+varDeleteID4);  
	//alert (child3);//tr name
    var parent4 = document.getElementById('insertrow4'); // tbody name.
	document.getElementById ('insertrow4').removeChild(child4);
	var child4= document.getElementById('idTRaddtxt'+varDeleteID4);  //tr name
    var parent4 = document.getElementById('insertrow4'); // tbody name.
	if (child4 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow4').removeChild(child4);
	}
    document.getElementById("Add4").disabled = false;
}

function btnDeleteClick_anesthetic(delID4)
{
	var newtotal;
	//alert(delID4);
	var varDeleteID4= delID4;
	//alert(varDeleteID4);
	var fRet7; 
	fRet7 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet7 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}
	
	var amountid='rate4_anesthetic'+varDeleteID4+'';
	//alert(amountid);
	var varamount12= parseFloat(document.getElementById(amountid).value);
	//alert(varamount12);
	var vartotal12= parseFloat(document.getElementById('total_anthe').value);
	//alert(vartotal12);
	vartotal12=vartotal12-varamount12;
	document.getElementById('total_anthe').value=vartotal12.toFixed(2);
	
	var child4 = document.getElementById('idTR_anesthetic'+varDeleteID4);  
	//alert (child3);//tr name
    var parent4 = document.getElementById('insertrow_anesthetic'); // tbody name.
	document.getElementById ('insertrow_anesthetic').removeChild(child4);
	var child4= document.getElementById('idTRaddtxt'+varDeleteID4);  //tr name
    var parent4 = document.getElementById('insertrow_anesthetic'); // tbody name.
	if (child4 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow_anesthetic').removeChild(child4);
	}
    document.getElementById("Add4").disabled = false;
}

function btnDeleteClick3(delID3,vrate3)
{
	// pop_delete_labcode();
	var vrate3=vrate3;
	//alert ("Inside btnDeleteClick.");
	var newtotal1;
	var varDeleteID3= delID3;
	//alert (varDeleteID3);
	//alert(vrate3);
	var fRet6; 
	fRet6 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet6 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child3 = document.getElementById('idTR_service'+varDeleteID3);  
	//alert (child3);//tr name
    var parent3 = document.getElementById('insertrow3'); // tbody name.
	document.getElementById ('insertrow3').removeChild(child3);
	var child3= document.getElementById('idTRaddtxt'+varDeleteID3);  //tr name
    var parent3 = document.getElementById('insertrow3'); // tbody name.
	if (child3 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow3').removeChild(child3);
	}
	var currenttotal1=document.getElementById('total3').value;
	//alert(currenttotal);
	newtotal1= currenttotal1-vrate3;	
	//alert(newtotal);	
	document.getElementById('total3').value=newtotal1;	
	if(document.getElementById('total1').value=='')
	{
	totalamount21=0;
	}
	else
	{
	totalamount21=document.getElementById('total1').value;
	}
	if(document.getElementById('total2').value=='')
	{
	totalamount31=0;
	}
	else
	{
	totalamount31=document.getElementById('total2').value;
	}
	
	var newgrandtotal1=parseInt(totalamount21)+parseInt(totalamount31)+parseInt(newtotal1);	
	//alert(newgrandtotal4);	
	document.getElementById('total4').value=newgrandtotal1.toFixed(2);	
	document.getElementById("totalamount").value=newgrandtotal1.toFixed(2);
	document.getElementById("subtotal").value=newgrandtotal1.toFixed(2);
	document.getElementById("subtotal1").value=newgrandtotal1.toFixed(2);
	// pop_delete_labcode();
}

function isNumberKey(evt, element) {
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57) && !(charCode == 46 || charCode == 8))
    return false;
  else {
    var len = $(element).val().length;
    var index = $(element).val().indexOf('.');
    if (index > 0 && charCode == 46) {
      return false;
    }
    if (index > 0) {
      var charAfterdot = (len + 1) - index;
      if (charAfterdot > 3) {
        return false;
      }
    }

  }
  return true;
}

function funcamountcalc()
{
if(document.getElementById("units").value != '')
{
var units = document.getElementById("units").value;
var rate = document.getElementById("rate4_otother").value;
var amount = units * rate;
document.getElementById("amount_otother").value = amount.toFixed(2);
}
}

function funcOnLoadBodyFunctionCall()
{
	funcCustomerDropDownSearch4(); 
	var oTextbox = new AutoSuggestControl(document.getElementById("searchaccountname"), new StateSuggestions());
}

function Functionfrequency()
{
var formula = document.getElementById("formula").value;
formula = formula.replace(/\s/g, '');
//alert(formula);
if(formula == 'INCREMENT')
{
var ResultFrequency;
var frequencyanum = document.getElementById("frequency").value;
var medicinedose=document.getElementById("dose").value;
var VarDays = document.getElementById("days").value; 
if((frequencyanum != '') && (VarDays != ''))
{
ResultFrequency = medicinedose*frequencyanum * VarDays;
//alert(ResultFrequency);
}
else
{
ResultFrequency =0;
}
var currentstock = document.getElementById("currentstock").value;
if(parseInt(ResultFrequency) > parseInt(currentstock))
{
alert("Please Enter Lesser Quantity");
document.getElementById("days").value = 0; 
return false;
}
document.getElementById("quantity").value = ResultFrequency;
<!--checking avl qty-->
var avlqty= document.getElementById("availableqty").value;
//alert(avlqty);
if(parseFloat(ResultFrequency) > parseFloat(avlqty))
{
// alert('ok');
document.getElementById("days").value=''; 
document.getElementById("quantity").value='';
} 
var VarRate = document.getElementById("rate").value;
var ResultAmount = parseFloat(VarRate * ResultFrequency);
document.getElementById("amount").value = ResultAmount.toFixed(2);
}
else if(formula == 'CONSTANT')
{
var ResultFrequency;
var strength = document.getElementById("strength").value;
var frequencyanum = document.getElementById("frequency").value;
var medicinedose=document.getElementById("dose").value;
var VarDays = document.getElementById("days").value; 
if((frequencyanum != '') && (VarDays != ''))
{
ResultFrequency = medicinedose*frequencyanum*VarDays/strength;
}
else
{
ResultFrequency =0;
}
//ResultFrequency = parseInt(ResultFrequency);
ResultFrequency = Math.ceil(ResultFrequency);
//alert(ResultFrequency);
var currentstock = document.getElementById("currentstock").value;
if(parseInt(ResultFrequency) > parseInt(currentstock))
{
alert("Please Enter Lesser Quantity");
document.getElementById("days").value = 0; 
return false;
}
document.getElementById("quantity").value = ResultFrequency;

var VarRate = document.getElementById("rate").value;
var ResultAmount = parseFloat(VarRate * ResultFrequency);
document.getElementById("amount").value = ResultAmount.toFixed(2);
}
}

function frequencyitem()
{
if(document.form1.frequency.value=="select")
{
alert("please select a frequency");
document.form1.frequency.focus();
return false;
}
return true;
}

function btnDeleteClick(delID)
{
	//alert ("Inside btnDeleteClick.");
	var newtotal4;
	//alert(pharmamount);
	var varDeleteID = delID;
	//alert (varDeleteID);
	var fRet3; 
	fRet3 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet3 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}
	var amountid='amounts'+delID+'';
	var varamount12= parseFloat(document.getElementById(amountid).value);
	alert(varamount12)
	var vartotal12= parseFloat(document.getElementById('total').value);
	vartotal12=vartotal12-varamount12;
	document.getElementById('total').value=vartotal12.toFixed(2);
	var unikey = document.getElementById("uniqueautonum"+varDeleteID).value;
						//alert(unikey);
						if (window.XMLHttpRequest)
						  {// code for IE7+, Firefox, Chrome, Opera, Safari
						  xmlhttp=new XMLHttpRequest();
						  }
						else
						  {// code for IE6, IE5
						  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
						  }
						xmlhttp.onreadystatechange=function()
						  {
						  if (xmlhttp.readyState==4 && xmlhttp.status==200)
							{
						//	document.getElementById("medicinename").innerHTML=xmlhttp.responseText;
							}
						  }
						xmlhttp.open("GET","ajaxbatchdelete.php?autkey="+unikey+"&&actkey="+0,true);
						xmlhttp.send();	
	var child = document.getElementById('idTR'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	document.getElementById ('insertrow').removeChild(child);
	var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	//alert (child);
	if (child != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow').removeChild(child);
	}
}

function sertotal()
{
	var varquantityser = document.getElementById("quantityser3").value;
	var varserRates = document.getElementById("rate3").value;
	var varserBaseunit = document.getElementById("baseunit").value;
	if(varserBaseunit==""){varserBaseunit=0;}
	var varserIncrqty = document.getElementById("incrqty").value;
	if(varserIncrqty==""){varserIncrqty=0;}
	var varserIncrrate = document.getElementById("incrrate").value;
	if(varserIncrrate==""){varserIncrrate=0;}
	var varserSlab = document.getElementById("slab").value;
	//alert(varquantityser+varserBaseunit);
	//alert(document.getElementById("slab").value);
	if(varserSlab=='')
	{
		if(parseInt(varquantityser)==0)
		{document.getElementById("totalservice3").value=0}
		if(parseInt(varquantityser)>0)
		{
		document.getElementById("totalservice3").value=(parseInt(varserRates)*parseInt(varquantityser)).toFixed(2);
		}
	}
		
	if(parseInt(varserSlab)==1)
	{
		if(parseInt(varquantityser)==0)
		{document.getElementById("totalservice3").value=0}
		if(parseInt(varquantityser)>0)
		{
		if(parseInt(varquantityser) <= parseInt(varserBaseunit))
		{ 
		document.getElementById("totalservice3").value=varserRates;			
		}
		//parseInt(varquantityser)+parseInt(varserIncrqty);
		if (parseInt(varquantityser) > parseInt(varserBaseunit))
		{
			var result11 = parseInt(varquantityser) - parseInt(varserBaseunit);
			//alert(result11);
			var rem = parseInt(result11)/parseInt(varserIncrqty);
			var rem= Math.ceil(rem);
			//alert(rem);
			var resultfinal =parseInt(rem)*parseInt(varserIncrrate);//alert(resultfinal);
			document.getElementById("totalservice3").value=(parseInt(varserRates)+parseInt(resultfinal)).toFixed(2);
		}
	}
	}
}
</script>

<body onLoad="return funcOnLoadBodyFunctionCall();">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
	<tr>
	<td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
	</tr>
	<tr>
	<td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
	</tr>
	<tr>
	<td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
	</tr>
	<tr>
	<td colspan="14">&nbsp;</td>
	</tr>
	
		<tr>
		<td width="2%">&nbsp;</td>
		<td colspan="5" valign="top">
		<form name="form1" id="form1" method="post">
		<table width="95%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
			<tr>
       		<td width="860">
       			<table width="100%" height="auto" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
       				<tbody>
					<tr bgcolor="#011E6A">
					<td bgcolor="#ecf0f5" class="bodytext3" colspan="2"><strong>Theatre Billing</strong></td>
					<td colspan="5" bgcolor="#ecf0f5" align="right" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
					<input type="hidden" name="locationcode" id="locationcode" value="<?php echo $res1locationcode;?>">
					<?php
					$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
					$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1000".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res1 = mysqli_fetch_array($exec1);									
					echo $res1location = $res1["locationname"];
					?>
					</td>
					</tr>
					<tr>
					<td>&nbsp;</td>
					</tr>
					<!--patientdetails-->
					<tr>
					<td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong><label>Patient Details</label></strong>
					</td>
					</tr>
							<tr>
							<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Patient</td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5" colspan="2">
							<input name="patientfirstname" id="patientfirstname" value="<?php echo $patientfirstname; ?>" readonly  size="30" />
							&nbsp;
							&nbsp;
							<input name="patientmiddlename" id="patientmiddlename" value="<?php echo $patientmiddlename; ?>" readonly size="22" />
							</td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
							<input name="patientlastname" id="patientlastname" value="<?php echo $patientlastname; ?>" readonly size="30" />
							<input name="patientfullname" id="patientfullname" value="<?php echo $patientfullname; ?>" readonly size="30" />
							</td>
							<td align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Age</td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
							<input type="text" name="age" id="age" value="<?php echo $age; ?>" readonly>
							</td>
							</tr>
							<tr>
							<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Patient Reg ID </td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
							<input name="patientcode" id="patientcode" size="30" value="<?php echo $patientcode; ?>" readonly/>&nbsp;&nbsp;&nbsp;&nbsp;
							<input name="visitcode" id="visitcode" size="22" value="<?php echo $visitcode; ?>" readonly/>
							<input name="patientcode_old" id="patientcode_old" type="hidden" size="30" value="<?php echo $patientcode; ?>" readonly/></td>
							<td align="right" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">Registration Date </span></td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
							<input type="text" name="registrationdate" id="registrationdate" size="30" value="<?php echo $date_register; ?>" >
							<input type="hidden" name="billtypes" id="billtypes" value="<?php echo $billtype; ?>" />
							<input type="hidden" name="payment" id="payment" value="<?php echo $paymenttype; ?>">
							</td>
							<td align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Gender</td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
							<input type="text" name="gender" value="<?php echo $gender; ?>" id="gender" readonly></td>
							</tr>
							<tr>
							<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Sub Type </td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
							<label>
							<input type="text" name="subtypename" id="subtypename"  value="<?php echo $subtype;?>"  size="30" readonly="readonly"  >
							<input type="hidden" name="subtype" id="subtype"  value="<?php echo $subtypeanum;?>"  readonly="readonly"  style="border: 1px solid #001E6A;">
							<input type="hidden" name="subtypeano" id="subtypeano"  value="<?php echo $subtypeanum;?>"  readonly="readonly"  style="border: 1px solid #001E6A;">
							</label>
							</td>
							<td align="right" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">Account</span></td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
							<input type="text" name="accountnamename" id="accountnamename"  size="30" value="<?php echo $accountname;?>"  readonly="readonly" style="">
							<input type="hidden" name="accountname" id="accountname"  value="<?php echo $accountnameanum;?>"  readonly="readonly"  style="border: 1px solid #001E6A;"></td>
							<td align="right" valign="middle"  bgcolor="#ecf0f5"><!--<span class="bodytext3">Ward</span>--></td>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
							<!--<select name="ward" id="ward" style="border: 1px solid #001E6A;">
							<option value="">Select Ward</option>-->
							<?php
							$auto_number='';
							$query_th_1 = "SELECT * FROM master_ward ORDER BY auto_number ASC";
							$exec_th_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_th_1) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
							while ($res_th_1 = mysqli_fetch_array($exec_th_1))
							{
							$auto_number = $res_th_1['auto_number'];
							$ward_name = $res_th_1['ward'];

							?>
							<!--<option value="<?php echo $auto_number;?>" <?php if($ward == $auto_number){ echo "selected"; }?> ><?php echo $ward_name;?></option>-->
							<?php } ?>
							<!--</select>-->
							<input type='hidden' name="ward" id="ward" value='<?php echo $auto_number;?>'>
							</td>
							</tr>
					<!-- patient details end-->
					
					<tr>
					<td>&nbsp;</td>
					</tr>
					<!-- booking details--->
						<tr>
						<td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><label><strong>Booking Details</strong></label></td>
						</tr>
						<tr>
						<td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Procedure Type</span></td>
						<td align="left" valign="middle"  bgcolor="#ecf0f5">
						<select name="proceduretype" id="proceduretype" style="border: 1px solid #001E6A;">
						<option value="">Select Procedure</option>
						<option value="emergency" <?php if($procedure_type == 'emergency'){ echo "selected";}?> >Emergency</option>
						<option value="elective" <?php if($procedure_type == 'elective'){ echo "selected";}?> >Elective</option>
						</select>
						</td>
						<td align="right" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">Category</span></td>
						<td align="left" valign="middle"  bgcolor="#ecf0f5">
						<select name="category" id="category" style="border: 1px solid #001E6A;">
						<option value="">Select Category</option>
						<option value="major" <?php if($category == 'major'){ echo "selected";}?>>Major</option>
						<option value="minor" <?php if($category == 'minor'){ echo "selected";}?> >Minor</option>
						</select>
						</td>
						<td align="right"  valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3"><!--Patient Type--></span></td>
						<td align="left" valign="middle"  bgcolor="#ecf0f5">
						<!--<select name="patient_type" id="patient_type" style="border: 1px solid #001E6A;">
						<option value="">Select Type</option>
						<option value="New" <?php if($patient_type == 'New'){ echo "selected";}?>>New</option>
						<option value="Active IP" <?php if($patient_type == 'Active IP'){ echo "selected";}?>>Active IP</option>
						</select>-->
						<input type='hidden' name="patient_type" id="patient_type" value=''>
						</td>
						</tr>
						<tr>
						<td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">Surgeon</span></td>
						<td width="0%">
						<table>
                        <?php 
						$query_surg_doc = "select * from theatre_booking_surgeons WHERE booking_id  = '$id'";
						$exec_surg_doc = mysqli_query($GLOBALS["___mysqli_ston"], $query_surg_doc) or die ("Error in query_surg_doc".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($res_surg_doc = mysqli_fetch_array($exec_surg_doc)){
						$surg_id = $res_surg_doc['surgeon_id'];
                        $idtodel= $res_surg_doc['auto_number'];
						$query_t = "SELECT * FROM master_doctor WHERE doctorcode= '$surg_id'";
				        $exec_t = mysqli_query($GLOBALS["___mysqli_ston"], $query_t) or die ("Error in Query_s".mysqli_error($GLOBALS["___mysqli_ston"]));
				        while ($res_t = mysqli_fetch_assoc($exec_t))
				        {  
					    $newdoctorname=$res_t['doctorname'];
				        } 				
						?>
						<tr>
						<td width="300" style="border: 0px solid #001E6A; background-color: #FFFFFF; text-align: left;"> <div ><?php echo  $newdoctorname;?> </td>
						</tr>
						<?php } ?>
						</table>
						</td>
						<td align="right" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">Anaesthetist</span></td>
						<td align="left" valign="middle"  bgcolor="#ecf0f5">
						<?php
						$docname1 = '';
						$doccode1='';
						$query_sg_1 = "
						SELECT doctorcode, doctorname FROM master_doctor WHERE doctorcode = '$anesthesia' AND status <> 'deleted' AND doctorname <> '' ";
						$exec_sg_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_sg_1) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
						while ($res_sg_1 = mysqli_fetch_array($exec_sg_1))
						{
						$doccode1 = $res_sg_1["doctorcode"]; 
						$docname1 = $res_sg_1["doctorname"];
						//$doctitle = $res_sg_1["doctorname"]; 
						}
						?>
						<input type="text" name="anaesthesia_name" size="35" id="anaesthesia_name" autocomplete="off" value="<?php echo $docname1; ?>">
						</td>
						<td align="right" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">Anaesthesia Type</span></td>
						<td align="left" valign="middle"  bgcolor="#ecf0f5">
						<select name="anesthesiatype" id="anesthesiatype" width="100" style="border: 1px solid #001E6A;">
						<option value="">Anaesthesia Type</option>
						<option value="General Anesthesia" <?php if($anesthesiatype == 'General Anesthesia'){ echo "selected"; } ?> >General Anaesthesist</option>
						<option value="Spinal Anesthesia" <?php if($anesthesiatype == 'Spinal Anesthesia'){ echo "selected"; } ?> >Spinal Anesthesia </option>
						<option value="Sedation Anesthesia" <?php if($anesthesiatype == 'Sedation Anesthesia'){ echo "selected"; } ?> >Sedation Anesthesia</option>
						<option value="Regional Block Anesthesia" <?php if($anesthesiatype == 'Regional Block Anesthesia'){ echo "selected"; } ?> >Regional Block Anesthesia</option>
						<option value="Local Anesthesia" <?php if($anesthesiatype == 'Local Anesthesia'){ echo "selected"; } ?> >Local Anesthesia</option>
						</select>
						</td>
						</tr>
						
						<tr>
						<td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">Theatre</span></td>
						<td align="left" valign="middle"  bgcolor="#ecf0f5">
						<select name="theatre" id="theatre" style="border: 1px solid #001E6A;">
						<option value="">Select Theatre</option>
						<?php
						$query_th_1 = "SELECT * FROM master_theatre ORDER BY auto_number ASC";
						$exec_th_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_th_1) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
						while ($res_th_1 = mysqli_fetch_array($exec_th_1))
						{
						$auto_number = $res_th_1['auto_number'];
						$theatre_name = $res_th_1['theatrename'];
						?>
						<option value="<?php echo $auto_number;?>" <?php if($theatre_code == $auto_number){ echo "selected";}?> ><?php echo $theatre_name;?></option>
						<?php } ?>
						</select>
						</td>					
						<td align="right" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">Surgery Date</span></td>
						<td align="left" valign="middle"  bgcolor="#ecf0f5">
						<?php
						//$now = date('yyyy-mm-dd H:i:s');
						$now = date('Y-m-d');
						$b_str = strtotime($surgerydatetime);
						$b_date = date('Y-m-d', $b_str);
						//echo $b_date;exit;
						?>
						<input id="surgerydate" name="surgerydate" size="35" autocomplete="off" readonly type="text" value="<?php echo $surgerydatetime; ?>" ></td>
						<td align="right" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">Estimated Time</span></td>
						<td align="left" valign="middle"  bgcolor="#ecf0f5">
						<input type="number" name="estimatedtime" id="estimatedtime"  placeholder="Minutes" value="<?php echo $estimatedtime; ?>" style=""  >
						</td>
						</tr>
						<tr>
						<td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">Procedure</span></td>
						<td  align="left" valign="middle">	
						<table>
						<?php 
						//echo $speacialityname; 
						$query3_012 = "select * from theatre_booking_proceduretypes where booking_id = '$id'";
						$exec3_012 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_012) or die ("Error in Query3_012".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($res3_012 = mysqli_fetch_array($exec3_012)){
						$proceduretypename = $res3_012['proceduretype_id'];
						$idtodelp=$res3_012['auto_number'];
						?>
						<tr>
						<td width="300" style="border: 0px solid #001E6A; background-color: #FFFFFF; text-align: left;">
						<?php echo  $proceduretypename;?></td>
						</tr>
						<?php } ?>
						</table>
						</td>
						<td align="right" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">Assistant surgeon</span></td>
						<td align="left" valign="middle"  bgcolor="#ecf0f5">
						<input type="text" name="assistant_surgeon" size="35" id="assistant_surgeon" autocomplete="off" value="<?php echo $assistant_surgeon; ?>">
						</td>
						<td align="right" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">Side</span></td>
						<td align="left" valign="middle"  bgcolor="#ecf0f5">
						<select id="side" name="side" style="border: 1px solid #001E6A;width:150px;">
						<option value="N/A" <?php if($s_side == 'N/A'){ echo "selected"; } ?> >N/A</option>
						<option value="Left" <?php if($s_side == 'Left'){ echo "selected"; } ?>>LEFT</option>
						<option value="Right" <?php if($s_side == 'Right'){ echo "selected"; } ?>>RIGHT</option>
						</select>
						</td>
						</tr>
						<tr>
	                    <td>&nbsp;</td>
	                    </tr>
						<tr>
						<td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Equipments</span></td>
						<td align="left" valign="middle"  bgcolor="#ecf0f5">
						<select name="equipments[]" id='pre-selected-options' multiple='multiple'>
						<?php 
						// get equipments from masters
						$query_equip= "SELECT * FROM master_equipments WHERE record_status <> 'deleted'";
						$exec_equip= mysqli_query($GLOBALS["___mysqli_ston"], $query_equip) or die ("Error in Query_speac".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($res_equip = mysqli_fetch_array($exec_equip)){
						//
						$equip_id = $res_equip['auto_number'];
						$equip_name = $res_equip['equipment_name'];
						$query2_ = "select * from master_theatre_equipments where theatrebookingcode='$id' and patientcode='$patientcode' and itemcode = '$equip_id' order by auto_number desc";
						$exec2_ = mysqli_query($GLOBALS["___mysqli_ston"], $query2_) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($res2_ = mysqli_fetch_array($exec2_))
						{
						$equipment_id1= $res2_['itemcode'];
						}
						if ($equipment_id1 != '' ){$e_id = $equipment_id1;}else{$e_id = '';}
						?>
						<option value='<?php echo $equip_id;?>' <?php if($e_id == $equip_id){echo "selected"; } ?> ><?php echo $equip_name;?></option>
						<?php }?>
						</select>
						</td>
						<td align="left" width="" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3"><!--Anaesthetist Notes--></span></td>
						<td><!--<textarea rows="4" cols="40" name="anaesthetisit_note" id="anaesthetisit_note" ><?php echo $anaesthetisit_note; ?></textarea>--></td>
						<td align="right"  valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3"><!--Doctor Notes--></span></td>
						<td><!--<textarea rows="4" cols="35" name="doctor_note" id="doctor_note" ><?php echo $doctor_note; ?></textarea>--></td>
						<input type='hidden'  name="anaesthetisit_note" id="anaesthetisit_note" value=''>
						<input type='hidden'  name="doctor_note" id="doctor_note" value=''>
						</tr>
					<!-- end booking details--->					
					<tr>
					<td>&nbsp;</td>
					</tr>
					<!-- Surgeon  details--->
						<tr>
						<td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><label><strong>Surgeon Details</strong></label>
						<input type="hidden" id="theater_surg" name="theater_surg" value="theater_surg" readonly size="7">
						</td>
						</tr>
						<tr>
						<td>&nbsp;</td>
						</tr>
						<tr id="reffid">
						<td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
						<table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
						<tr>
							<td width="30" class="bodytext3">Surgeon Name</td>
							<td class="bodytext3">Surgeon Fee</td>
							<td class="bodytext3">Surgeon Specialty</td>
						</tr>
						<tr>
						<div id="insertrow4"></div>
						</tr>
						<tr>
						<input type="hidden" name="serialnumber4" id="serialnumber4" value="1">
						<td width="30"><input name="referal[]" type="text" id="referal" size="30">
						<input type="hidden" name="referalcode[]" id="referalcode" value=""></td>
						<td width="30"><input name="rate4[]" type="text" id="rate4" size="8" ></td>
						<td width="30">
						<input name="description[]" type="text" id="description" size="30" onKeyUp="clearcode('descriptioncode')">
						<input type="hidden" name="descriptioncode[]" id="descriptioncode" value="">
						</td>
					    <td><label> <input type="button" name="Add4" id="Add4" value="Add" onClick="return insertitem5()" class="button" style="border: 1px solid #001E6A"> </label></td>
					    </tr>
						<tr>
						<td colspan="4" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Total</strong><input type="text" id="total_surg" name="total_surg" value="0" readonly size="7"></td>
						</tr>
					    </table>
						</td>
						</tr>
					<!--- end Surgeon details-->

					
					<tr>
					<td>&nbsp;</td>
					</tr>
					
					
					<!-- Anaesthetic   details--->
						<tr>
						<td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><label><strong>Anaesthetic Details</strong></label>
						<input type="hidden" id="theater_anesth" name="theater_anesth" value="theater_anesth" readonly size="7"></td>
						</tr>
						<tr>
						<td>&nbsp;</td>
						</tr>
						<tr id="reffid_anesthetic">
						<td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
						<table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
						<tr>
							<td width="30" class="bodytext3">Anaesthetic Name</td>
							<td class="bodytext3">Anaesthetic Fee</td>
							<td class="bodytext3">Anaesthetic Specialty</td>
						</tr>
						<tr>
						<div id="insertrow_anesthetic"></div>
						</tr>
						<tr>
						<input type="hidden" name="serialnumber_anesthetic" id="serialnumber_anesthetic" value="1">
						<td width="30"><input name="referal_anesthetic[]" type="text" id="referal_anesthetic" size="30">
						<input type="hidden" name="referalcode_anesthetic[]" id="referalcode_anesthetic" value=""></td>
						<td width="30"><input name="rate4_anesthetic[]" type="text" id="rate4_anesthetic" size="8" ></td>
						<td width="30">
						<input name="description_anesthetic[]" type="text" id="description_anesthetic" size="30" onKeyUp="clearcode_anesthetic('descriptioncode_anesthetic')">
						<input type="hidden" name="descriptioncode_anesthetic[]" id="descriptioncode_anesthetic" value="">
						</td>
					    <td><label> <input type="button" name="Add4" id="Add4" value="Add" onClick="return insertitem_anesthetic()" class="button" style="border: 1px solid #001E6A"> </label></td>
					    </tr>
						<tr>
						<td colspan="4" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Total</strong><input type="text" id="total_anthe" name="total_anthe" value="0" readonly size="7"></td>
						</tr>
					    </table>
						</td>
						</tr>
						
						<!-- END Anesthetic   details--->
						<tr>
						<td>&nbsp;</td>
						</tr>
						
						<!-- OT drugs/Consumables   details--->
						<tr>
						<td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><label><strong>OT drugs/Consumables Details</strong></label>
						<input type="hidden" name="dischargemedicine" id="dischargemedicine" value="">
						<input type="hidden" id="theater_otcons" name="theater_otcons" value="theater_otcons" readonly size="7"></td>
						</tr>
						<tr>
						<td>&nbsp;</td>
						</tr>
						
						<tr id="pressid">
						<td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
						<table id="presid" width="100%" border="0" cellspacing="1" cellpadding="1">
						<tr>
						<td align="left" valign="middle" class="bodytext3"><strong>Store</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="hidden" name="store" id="store" value="<?php echo $store3; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				
						<input type="hidden" name="request" id="request" value="">
						<select name="storecode" id="storecode" onChange="return Redirect('<?php echo $patientcode; ?>','<?php echo $visitcode; ?>','<?php echo $res1locationcode; ?>')">
						<?php if($storecode != '') { ?>
						<option value="<?php echo $storecode; ?>"><?php echo $store3; ?></option>
						<?php } ?>
						<?php 
						$query9 = "select * from master_employeelocation where username = '$username' and locationcode = '$locationcode'";
						$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($res9 = mysqli_fetch_array($exec9))
						{
						$res9anum = $res9['storecode'];
						$res9default = $res9['defaultstore'];

						$query10 = "select * from master_store where auto_number = '$res9anum'";
						$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res10 = mysqli_fetch_array($exec10);
						$res10storecode = $res10['storecode'];
						$res10store = $res10['store'];
						$res10anum = $res10['auto_number'];
						?>
						<!--<option value="<?php echo $res10storecode; ?>"><?php echo $res10store; ?></option>-->
						<?php } ?>
						</select>	
						</td>
						</tr>
						<tr>
						<td width="" class="bodytext3">Medicine Name</td>
						<td width="" class="bodytext3">Batch</td>
						<td width="" class="bodytext3">Avl.Qty</td>
						<td width="" class="bodytext3">Dose</td>
						<td width="" class="bodytext3">Dose Measure</td>
						<td width="" class="bodytext3">Freq</td>
						<td width="" class="bodytext3">Days</td>
						<td width="" class="bodytext3">Quantity</td>
						<td width="" class="bodytext3">Route</td>
						<td width="" class="bodytext3">Instructions</td>
						<td width="" class="bodytext3">Start </td>
						<td width="" class="bodytext3">Time </td>
						<td width="" class="bodytext3">Free </td>
						<td></td>
						<td width="" class="bodytext3">Rate</td>
						<td width="" class="bodytext3">Amount</td>
						</tr>
						
						 <script>
					function funcmedicinebatch()
					{
					//	alert('in');
						var xmlhttp;
						var str = document.getElementById("medicinecode").value;
						var strm = document.getElementById("medicinename").value;
						var loc = document.getElementById("locationcode").value;
					 	var stor = document.getElementById("storecode").value;
					 	var subtypeano = document.getElementById("subtypeano").value;
						//alert(loc);
						if (str=="")
						  {
						  document.getElementById("medicinebatch").innerHTML="";
						  return;
						  }
						if (window.XMLHttpRequest)
						  {// code for IE7+, Firefox, Chrome, Opera, Safari
						  xmlhttp=new XMLHttpRequest();
						  }
						else
						  {// code for IE6, IE5
						  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
						  }
						xmlhttp.onreadystatechange=function()
						  {
						  if (xmlhttp.readyState==4 && xmlhttp.status==200)
							{
							document.getElementById("medicinebatch").innerHTML=xmlhttp.responseText;
							document.getElementById("medicinebatch").onchange();
							}
						  }
						xmlhttp.open("GET","ajaxbatch.php?q="+str+"&&loc="+loc+"&&sto="+stor+"&&strm="+strm+"&&subtypeano="+subtypeano,true);
						xmlhttp.send();
						//var batch;          
					}

					function getavailableqty(val)
					{
						var aval = val.split('((');
						var val = aval[1];
						//document.getElementById("availableqty").value=val;
						var xmlhttp;
						var str = document.getElementById("medicinecode").value;
						var strm = document.getElementById("medicinename").value;
						var loc = document.getElementById("locationcode").value;
					 	var stor = document.getElementById("storecode").value;
					 	var subtypeano = document.getElementById("subtypeano").value;
						if (window.XMLHttpRequest)
						{// code for IE7+, Firefox, Chrome, Opera, Safari
						  xmlhttp=new XMLHttpRequest();
						}
						else
						{// code for IE6, IE5
						  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
						}
						xmlhttp.onreadystatechange=function()
						  {
						  if (xmlhttp.readyState==4 && xmlhttp.status==200)
							{
								//alert(xmlhttp.responseText);
								var t = "";
								 t=xmlhttp.responseText;
									var varCompleteStringReturned=t;
									var varNewLineValue=varCompleteStringReturned.split("||");
									var varNewLineLength = varNewLineValue.length;
									if(parseFloat(varNewLineValue[1]) == '0')
									{
										alert('Drug Not applicable for the Insurance! Kindly contact Finance.');
										document.getElementById("medicinecode").value = '';
										document.getElementById("medicinename").value = '';
										document.getElementById("formula").value = '';
										document.getElementById("availableqty").value = '';
										document.getElementById("rate").value = '0.00';
										var newOption = document.createElement('option');
										newOption.text = "Select";
										newOption.value = "";
										newOption.selected = "selected";
										document.getElementById("medicinebatch").options.add(newOption, null);
										//return false;
									}else{
										document.getElementById("availableqty").value=varNewLineValue[0];
										document.getElementById("rate").value=varNewLineValue[1];
									}
							}
						  }
						xmlhttp.open("GET","ajaxstock1.php?q="+str+"&&loc="+loc+"&&sto="+stor+"&&strm="+strm+"&&fifo_code="+val+"&&subtypeano="+subtypeano,true);
						xmlhttp.send();
					}
 </script>
						<tr>
							<div id="insertrow"></div>
						</tr>
						<tr>
						<input type="hidden" name="billno" id="billno" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
						<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" />
						<input type="hidden" name="packcharge" id="packcharge" value="<?php echo $packcharge; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
						<input type="hidden" name="serialnumber" id="serialnumber" value="1">
						<input type="hidden" name="medicinecode" id="medicinecode" value="">
						<input name="searchmedicinename1hiddentextbox" id="searchmedicinename1hiddentextbox" type="hidden" value="">
						<input name="searchmedicineanum1" id="searchmedicineanum1" value="" type="hidden">
						<input name="uniqueautonum" id="uniqueautonum" value="" type="hidden">
						<input name="medicinekey" id="medicinekey" value="<?php echo $visitcode,$billnumbercode?>" type="hidden">
						<td><input name="medicinename" type="text" id="medicinename" size="40" autocomplete="off">	</td>
						<input type="hidden" name="currentstock" id="currentstock">
						<input type="hidden" name="uniquebatch" id="uniquebatch">
						<td><select id="medicinebatch" name="medicinebatch" onChange="getavailableqty(this.value)"><option>-Select-</option></select></td>
						<td><input type="text" readonly size="5" id="availableqty" name="availableqty"></td>
						<td><input name="dose" type="text" id="dose" size="4" onKeyUp="return Functionfrequency()"></td>
						<td><select  class="dose_measure" name="dosemeasure" id="dosemeasure">
						<option value="">Select Measure</option>
						<?php
						// $dose_measure='3';
						$query_prod_type = "select * from dose_measure where status = '1' ";
						$exec_prod_type = mysqli_query($GLOBALS["___mysqli_ston"], $query_prod_type) or die ("Error in query_prod_type".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res_prod_type = mysqli_fetch_array($exec_prod_type))
						{
						$res_prod_id3 = $res_prod_type['id'];
						$res_prod_name3 = $res_prod_type['name'];
						?>
						<option value="<?php echo $res_prod_name3; ?>"  ><?php echo $res_prod_name3; ?></option>
						<?php
						}
						?>
						</select></td>
						<td>
						<select name="frequency" id="frequency" onChange="return Functionfrequency()">
						<?php
						if ($frequncy == '')
						{
						echo '<option value="select" selected="selected">Select frequency</option>';
						}
						else
						{
						$query51 = "select * from master_frequency where recordstatus = ''";
						$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res51 = mysqli_fetch_array($exec51);
						$res51code = $res51["frequencycode"];
						$res51num = $res51['frequencynumber'];
						echo '<option value="'.$res51num.'" selected="selected">'.$res51code.'</option>';
						}
						$query5 = "select * from master_frequency where recordstatus = '' order by auto_number";
						$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res5 = mysqli_fetch_array($exec5))
						{
						$res5num = $res5["frequencynumber"];
						$res5code = $res5["frequencycode"];
						?>
						<option value="<?php echo $res5num; ?>"><?php echo $res5code; ?></option>
						<?php
						}
						?>
						</select>				</td>	
						<td><input name="days" type="text" id="days" size="4" onKeyUp="return Functionfrequency()" onFocus="return frequencyitem()"></td>
						<td><input name="quantity" type="text" id="quantity" size="4" readonly></td>
						<td>
						<select name="route" id="route">
						<option value="" selected="selected">Select Route</option>
						<option value="Oral">Oral</option>
						<option value="Sublingual">Sublingual</option>
						<option value="Rectal">Rectal</option>
						<option value="Vaginal">Vaginal</option>
						<option value="Topical">Topical</option>
						<option value="Intravenous">Intravenous</option>
						<option value="Intramuscular">Intramuscular</option>
						<option value="Subcutaneous">Subcutaneous</option>
						<option value="Not Applicable">Not Applicable</option>
						<option value="Intranasal">Intranasal </option>
						<option value="Eye">Eye</option>
						</select>					   </td>
						<td>
						<input type="text" name="instructions" id="instructions"> 
						</td>
						<td>
						<input type="text" name="hour" id="hour" size="4" placeholder="HH"></td>
						<td>  <input type="text" name="minute" id="minute" size="4" placeholder="MM"></td>
						<input type="hidden" name="pkg" id="pkg">
						<td> <select name="pharmfree" id="pharmfree" width="10">
						<option value="">Select</option>
						<!--<option value="0">No</option>
						<option value="1">Yes</option>-->
						</select></td>
						<td> <select name="sess" id="sess" width="10">
						<option value="am">AM</option>
						<option value="pm">PM</option>
						</select></td>
						<td>
						<input type="text" name="rate" id="rate" value="" size="4" readonly/>
						</td> 
						<td>   <input type="text" name="amount" id="amount" size="4" readonly> </td>
						<input name="formula" type="hidden" id="formula" readonly size="8">
						<input name="strength" type="hidden" id="strength" readonly size="8">
						<td width="49"><label>
						<input type="button" name="Add" id="Add" value="Add" onClick="return insertitem()" class="button" style="border: 1px solid #001E6A">
						</label></td>
						</tr>
						<tr>
						<td colspan="13"></td>
						<td class="bodytext3"> Total </td>
						<td> <input type="text" name="total" id="total" size="4" value="0" readonly>  </td>
						</tr>
						<input type="hidden" name="h" id="h" value="0">
					
						</table>
						</td>
						</tr>
						<!--END  OT drugs/Consumables   details--->
						<tr>
						<td>&nbsp;</td>
						</tr>
					<!-- OT Services  details--->
						<tr>
						<td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><label><strong>OT Services  Details</strong></label>
						<input type="hidden" id="theater_otservice" name="theater_otservice" value="theater_otservice" readonly size="7"></td>
						</tr>
						<tr>
						<td>&nbsp;</td>
						</tr>
						<tr id="serid">
						<td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
						<table id="presid" width="60%" border="0" cellspacing="1" cellpadding="1">
						<tr>
						<td class="bodytext3"></td>
						<td width="" class="bodytext3">Services</td>
						<td width="" class="bodytext3 show_chkbox_status">Cost Price</td>
						<td width="" class="bodytext3 show_chkbox_status">%</td>
						<td class="bodytext3">Doctor Name</td>
						<td class="bodytext3">Base Rate</td>
						<td class="bodytext3">Base Unit</td>
						<td class="bodytext3">Incr Qty</td>
						<td class="bodytext3">Incr Rate</td>
						<td width="" class="bodytext3">Qty</td>
						<td width="" class="bodytext3">Amount</td>
						</tr>
						<tr>
						<div id="insertrow3"></div>
						</tr>
						<tr>
						<input type="hidden" name="serialnumber3" id="serialnumber3" value="1">
						<input type="hidden" name="servicescode[]" id="servicescode" >
						<input type="hidden" name="hiddenservices" id="hiddenservices" value="">
						<td width="30"><input type="checkbox" name="service_chk" id="service_chkbox"></td>
						<td width="30"><input name="services[]" type="text" id="services" onChange="return cleardatas('serv')" size="40"></td>
						<td width="30" class="show_chkbox_status"><input name="costprice" type="text" id="costprice" ></td>
						<td class="show_chkbox_status"><select name="percentage" id="percentage">
						<option value="">Select</option>
						<option value="5">5</option>
						<option value="10">10</option>
						<option value="20">20</option>
						</select>
						</td>
						<td width="30"><input name="serdoct[]" type="text" id="serdoct" size="30">
						<input name="serdoctcode[]" type="hidden" id="serdoctcode" size="30">
						</td>
						<td width="30"><input name="rate3[]" type="text" id="rate3" readonly size="8"></td>
						<input type="hidden" name="ledgercode[]" id="ledgercode" value="">
						<input type="hidden" name="ledgername[]" id="ledgername" value="">
						<td width="30"><input name="baseunit[]" type="text" id="baseunit" readonly size="8"></td>
						<td width="30"><input name="incrqty[]" type="text" id="incrqty" readonly size="8"></td>
						<td width="30"><input name="incrrate[]" type="text" id="incrrate" readonly size="8">
						<input name="slab[]" type="hidden" id="slab" readonly size="8">
						</td>
						<td width="30"><input name="quantityser3[]" type="text" id="quantityser3" onKeyUp="return sertotal()" size="8"></td>
						<td width="30"><input name="totalservice3[]" type="text" id="totalservice3" readonly size="8"></td>
						<input type="hidden" name="pkg2" id="pkg2">
						<td><select name="servicesfree[]" id="servicesfree">
						<option value="">Select</option>
						<option value="0">No</option>
						<option value="1">Yes</option>
						</select>
						</td>
						<td><label>
						<input type="button" name="Add3" id="Add3" value="Add" onClick="return insertitem4()" class="button" style="border: 1px solid #001E6A">
						</label></td>
						</tr>
						</table>
						</td>
						</tr>
						<tr>
						<td colspan="5" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Total</strong><input type="text" id="total3" readonly size="7"><input type="hidden" id="total1" readonly size="7"><input type="hidden" id="total2" readonly size="7"></td>
						<input type="hidden" id="total4" readonly size="7">
						</tr>
						<tr>
						<td>&nbsp;</td>
						</tr>
					<!-- END OT Services  details--->
						<!--<tr>
						<td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><label><strong>OT Other Billing</strong></label>
						<input type="hidden" id="theater_otother" name="theater_otother" value="theater_otother" readonly size="7"></td>
						</tr>
						<tr>
						<td>&nbsp;</td>
						</tr>
						<tr id="reffid">
						<td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
						<table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
						<tr>
						<td width="30" class="bodytext3">Account</td>
						<td width="30" class="bodytext3">Description</td>
						<td class="bodytext3">Unit</td>
						<td class="bodytext3">Rate</td>
						<td class="bodytext3">Amount</td>
						</tr>
						<tr>
						<div id="insertrow_otother">					 </div></tr>
						<tr>
						<input type="hidden" name="scode" id="scode" value="0">
						<input type="hidden" name="serialnumber6" id="serialnumber6" value="1">
						<input type="hidden" name="referalcode_otother" id="referalcode_otother" value="">
						<td width="30">
						<input name="autobuildaccount" type="hidden" id="autobuildaccount" size="30">
						<input name="searchaccountcode" type="hidden" id="searchaccountcode" size="30">
						<input name="searchaccountname" type="text" id="searchaccountname" size="30"></td>
						<td width="30"><input name="referal_otother[]" type="text" id="referal_otother" size="30"></td>
						<td width="30"><input name="units[]" type="text" id="units" size="8" onkeypress="return isNumberKey(event,this)" onKeyUp="return funcamountcalc()"></td>
						<td width="30"><input name="rate4_otother[]" type="text" id="rate4_otother" size="8" onKeyUp="return funcamountcalc()" onkeypress="return isNumberKey(event,this)"></td>
						<td width="30"><input name="amount_otother[]" type="text" id="amount_otother" readonly size="8"></td>
						<td><label>
						<input type="button" name="Add4" id="Add4" value="Add" onClick="return insertitem6()" class="button">
						</label></td>
						</tr>
						<tr>
						<td colspan="6" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Total</strong><input type="text" id="total_otother" name="total_otother" value="0" readonly size="7"></td>
						</tr>
						</table>
						</td>
						</tr>-->
						</tbody>
						
						<tr>
						<td colspan="5" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
						<input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
						<input name="Submit2223" id="Submit" onClick="return validcheck()" type="submit" value="Save" accesskey="b" class="button"/>		</td>
						<td colspan="2"></td>
						</tr>
						
						
					    </table>
						<tr>
						<td>&nbsp;</td>
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
						<tr>
						<td>&nbsp;</td>
						</tr>
						<tr>
						<td>&nbsp;</td>
						</tr>
						
				</td>
				</tr>
		</table>
		</form>
		</td>
		</tr>
	
<script type="text/javascript">
$('#pre-selected-options').multiSelect({
selectableHeader: "<div class='custom-header'>Equipments</div>",
selectionHeader: "<div class='custom-header'>Selected Equipments</div>",
});
</script>
</table>
</body>	
