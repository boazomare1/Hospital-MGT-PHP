<?php
session_start();
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
	$financialyear= "";
$updatedatetime = date('Y-m-d H:i:s');
$updatedate  = date('Y-m-d');
$updatetime = date('H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$docno = $_SESSION['docno'];
$reverse_ledger_id = "03-4500-2";

$query = "select * from master_location where  status <> 'deleted' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
$locationname  = $res["locationname"];
$locationcode = $res["locationcode"];
$res12locationanum = $res["auto_number"];
//get location for sort by location purpose
$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if($location!='')
{
$locationcode=$location;
}
	$currency= 'KSH';
	$fxrate= '1';


$query1 = "select * from op_ar_ap_july_2019 where account_type in ('AR') and status='' order by auto_number ASC";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{

	$ano= $res1["auto_number"];
	$patientname= $res1["description"];
	$patientcode= $res1["transaction_number"];
	$visitcode= $res1["transaction_number"];
	$billdate= $res1["transaction_date"];
	$accountcode= $res1["ledger_code"];
	$accountname= $res1["coa"];
	$billno= $res1["transaction_number"];
	$paymenttype= $res1["payment_type"];
	$subtype= $res1["sub_type_name"];
	$totalamount= $res1["amount"];
	$doctorname = "";
	$username = "admin";
	$totalamount= $res1["amount"];
	$totalfxamount= $res1["amount"];
	$accountnameano= $res1["ledger_id"];
	$accountcode= $res1["ledger_code"];
	$subtypeano= $res1["sub_type"];

	$query_insert ="insert into master_transactionpaylater(patientname,patientcode,visitcode,transactiondate,accountcode,accountname,billnumber,ipaddress,companyanum,companyname,financialyear,transactiontype,paymenttype,subtype,transactionamount,doctorname,username,transactiontime,locationname,locationcode,billamount,currency,exchrate,fxamount,accountnameano,accountnameid,subtypeano,billbalanceamount)values('$patientname','$patientcode','$visitcode','$billdate','$accountcode','$accountname','$billno','$ipaddress','$companyanum','$companyname','$financialyear','finalize','$paymenttype','$subtype','$totalamount','$doctorname','$username','$updatedatetime','".$locationname."','".$locationcode."','$totalamount','$currency','$fxrate','$totalfxamount','$accountnameano','$accountcode','$subtypeano','$totalfxamount')";

	echo $query_insert."<br>";
	$exec_insert = mysqli_query($GLOBALS["___mysqli_ston"], $query_insert) or die ("Error in query_insert".mysqli_error($GLOBALS["___mysqli_ston"]));

$doc_number = $res1["transaction_number"];
$from_table = 'master_transactionpaylater';
$remarks = 'Opening AR July-2019';
$ledger_id = $res1["ledger_code"];
$transaction_date = $res1["transaction_date"];
$transaction_amount = $res1["amount"];
$transaction_type = 'D';
$reverse_transaction_type = 'C';

if($transaction_amount<0){
	$transaction_type = 'C';
	$reverse_transaction_type = 'D';
	$transaction_amount = abs($transaction_amount);
}

$parent_type = 'A';
$currency_code = 'CUR-1';
$exchange_rate = 1;
$cost_center_code = '';
$narration = '';
$record_status = '1';
$user_name = 'admin';

	$query_insert_tb ="insert into tb(doc_number,from_table,remarks,ledger_id,transaction_date,transaction_amount,transaction_type,parent_type,currency_code,exchange_rate,cost_center_code,narration,record_status,user_name,locationcode)values('$doc_number','$from_table','$remarks','$ledger_id','$transaction_date','$transaction_amount','$transaction_type','$parent_type','$currency_code','$exchange_rate','$cost_center_code','$narration','$record_status','$user_name','$locationcode')";

	echo $query_insert_tb."<br><br>";
	$exec_insert_tb = mysqli_query($GLOBALS["___mysqli_ston"], $query_insert_tb) or die ("Error in query_insert_tb".mysqli_error($GLOBALS["___mysqli_ston"]));


	$query_insert_tb ="insert into tb(doc_number,from_table,remarks,ledger_id,transaction_date,transaction_amount,transaction_type,parent_type,currency_code,exchange_rate,cost_center_code,narration,record_status,user_name,locationcode)values('$doc_number','$from_table','$remarks','$reverse_ledger_id','$transaction_date','$transaction_amount','$reverse_transaction_type','$parent_type','$currency_code','$exchange_rate','$cost_center_code','$narration','$record_status','$user_name','$locationcode')";

	echo $query_insert_tb."<br><br>";
	$exec_insert_tb = mysqli_query($GLOBALS["___mysqli_ston"], $query_insert_tb) or die ("Error in query_insert_tb".mysqli_error($GLOBALS["___mysqli_ston"]));


	$query_update = "update op_ar_ap_july_2019 set status = 'done' where auto_number = '$ano'";
	$exec_update = mysqli_query($GLOBALS["___mysqli_ston"], $query_update) or die ("Error in Query_update".mysqli_error($GLOBALS["___mysqli_ston"]));


}

$query1 = "select * from op_ar_ap_july_2019 where account_type in ('AP') and status='' order by auto_number ASC";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{

	$ano= $res1["auto_number"];
	$billdate= $res1["transaction_date"];

	$billnumbercode= $res1["transaction_number"];
	$supplierbillnumber= $res1["transaction_number"];
	$mrnno = $res1["transaction_number"];
	$transactiontype = 'PAYMENT';
	$transactionmode = 'CREDIT';
	$particulars = 'BY CREDIT (Inv NO:'.$supplierbillnumber.')';	
	$accountssubid = $suppliercode = $res1["ledger_code"];
	$suppliername= $res1["coa"];
	$amount= -1*$res1["amount"];
	$totalfxamount = $amount;
	$transactionmodule = "";
	$billautonumber = "";
	$quantity = 1;
	$quantity = 1;
	$supplierbillno = $supplierbillnumber;
	$expense ="";
	$expensecode  ="";
	$expenseanum  ="";
	$cost_center ="";

	//include ("transactioninsert1.php");
	$query_ap_insert = "INSERT into master_transactionpharmacy (transactiondate, particulars, supplieranum, suppliername, transactionmode, transactiontype, transactionamount, creditamount,balanceamount,billnumber, billanum, ipaddress, updatedate,  companyanum, companyname, transactionmodule,suppliercode,currency,fxrate,totalfxamount,mrnno) values ('$billdate', '$particulars', '$accountssubid', '$suppliername','$transactionmode', '$transactiontype', '$amount', '$amount', '$amount','$billnumbercode',  '$billautonumber', '$ipaddress', '$updatedate', '$companyanum', '$companyname', '$transactionmodule','$suppliercode','$currency','$fxrate','$totalfxamount','$mrnno')";
	echo $query_ap_insert."<br><br>";
	$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query_ap_insert) or die ("Error in query_ap_insert".mysqli_error($GLOBALS["___mysqli_ston"]));

$transactiontype = 'PURCHASE';
$transactionmode = 'BILL';
$particulars = 'BY PURCHASE (Inv NO:'.$billnumbercode.$supplierbillnumber.')';	

	$query_ap_insert = "INSERT into master_transactionpharmacy (transactiondate, particulars, supplieranum, suppliername, transactionmode, transactiontype, transactionamount, creditamount,balanceamount,billnumber, billanum, ipaddress, updatedate,  companyanum, companyname, transactionmodule,suppliercode,currency,fxrate,totalfxamount,mrnno) values ('$billdate', '$particulars', '$accountssubid', '$suppliername','$transactionmode', '$transactiontype', '$amount', '$amount', '$amount','$billnumbercode',  '$billautonumber', '$ipaddress', '$updatedate', '$companyanum', '$companyname', '$transactionmodule','$suppliercode','$currency','$fxrate','$totalfxamount','$mrnno')";
	echo $query_ap_insert."<br><br>";
	$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query_ap_insert) or die ("Error in query_ap_insert".mysqli_error($GLOBALS["___mysqli_ston"]));



		$query_ap_insert_2 = "insert into master_purchase (companyanum, billnumber, billdate, suppliercode, suppliername,totalamount,totalquantity,ipaddress,supplierbillnumber,typeofpurchase,currency,fxrate,totalfxamount,locationcode,locationname,purchaseamount,expense,expensecode,expenseanum,mrnno)values('$companyanum','$billnumbercode','$billdate','$suppliercode', '$suppliername','$amount','$quantity','$ipaddress','$supplierbillno','Process','$currency','$fxrate','$totalfxamount','$locationcode','$locationname','$amount','$expense','$expensecode','$expenseanum','$mrnno')";
	  echo $query_ap_insert_2."<br><br>";
	  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query_ap_insert_2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));


	$doc_number = $res1["transaction_number"];
	$from_table = 'master_transactionpharmacy';
	$remarks = 'Opening AP July-2019';
	$ledger_id = $res1["ledger_code"];
	$transaction_date = $res1["transaction_date"];
	$transaction_amount = $res1["amount"];
	$transaction_type = 'D';
	$reverse_transaction_type = 'C';
	if($transaction_amount<0){
		$transaction_type = 'C';
		$reverse_transaction_type = 'D';
		$transaction_amount = abs($transaction_amount);
	}

	$parent_type = 'L';
	$currency_code = 'CUR-1';
	$exchange_rate = 1;
	$cost_center_code = '';
	$narration = '';
	$record_status = '1';
	$user_name = 'admin';

	$query_insert_tb ="insert into tb(doc_number,from_table,remarks,ledger_id,transaction_date,transaction_amount,transaction_type,parent_type,currency_code,exchange_rate,cost_center_code,narration,record_status,user_name,locationcode)values('$doc_number','$from_table','$remarks','$ledger_id','$transaction_date','$transaction_amount','$transaction_type','$parent_type','$currency_code','$exchange_rate','$cost_center_code','$narration','$record_status','$user_name','$locationcode')";

	echo $query_insert_tb."<br><br>";
	$exec_insert_tb = mysqli_query($GLOBALS["___mysqli_ston"], $query_insert_tb) or die ("Error in query_insert_tb".mysqli_error($GLOBALS["___mysqli_ston"]));


	$query_insert_tb ="insert into tb(doc_number,from_table,remarks,ledger_id,transaction_date,transaction_amount,transaction_type,parent_type,currency_code,exchange_rate,cost_center_code,narration,record_status,user_name,locationcode)values('$doc_number','$from_table','$remarks','$reverse_ledger_id','$transaction_date','$transaction_amount','$reverse_transaction_type','$parent_type','$currency_code','$exchange_rate','$cost_center_code','$narration','$record_status','$user_name','$locationcode')";

	echo $query_insert_tb."<br><br>";
	$exec_insert_tb = mysqli_query($GLOBALS["___mysqli_ston"], $query_insert_tb) or die ("Error in query_insert_tb".mysqli_error($GLOBALS["___mysqli_ston"]));


	$query_update = "update op_ar_ap_july_2019 set status = 'done' where auto_number = '$ano'";
	$exec_update = mysqli_query($GLOBALS["___mysqli_ston"], $query_update) or die ("Error in Query_update".mysqli_error($GLOBALS["___mysqli_ston"]));

}

$query1 = "select * from op_ar_ap_july_2019 where account_type in ('APD') and status='' order by auto_number ASC";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$ano= $res1["auto_number"];
	$billdate= $res1["transaction_date"];
	$billno= $res1["transaction_number"];
	$privatedoctor = $res1["coa"];
	$patientname = $res1["description"];
	$privatedoctorrate = abs($res1["amount"]);
	$privatedoctoramount = $privatedoctorrateuhx = $privatedoctoramountuhx = $pvtdrsharingamount = abs($res1["amount"]);
	$privatedoctorquantity= "1";
	$patientcode = $res1["transaction_number"];
	$visitcode = $res1["transaction_number"];
	$accountname = $res1["coa"];
	$stat = 'unpaid';
	$patientbilltype = "PAY LATER";
	$referalcode = $debitcoa = "";
	$doccoa = $res1["ledger_code"];
	$pvtdrperc = "100";


		$query52 = "insert into billing_ipprivatedoctor(description,rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,billstatus,doctorstatus,billtype,creditcoa,debitcoa,locationname,locationcode,doccoa,rateuhx,amountuhx,curtype,fxrate,pvtdr_percentage,sharingamount,transactionamount,original_amt,visittype)values('$privatedoctor','$privatedoctorrate','$privatedoctorquantity','$privatedoctoramount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$billdate','$ipaddress','$username','','$stat','unpaid','$patientbilltype','$referalcode','$debitcoa','".$locationname."','".$locationcode."','$doccoa','".$privatedoctorrateuhx."','".$privatedoctoramountuhx."','".$currency."','".$fxrate."','$pvtdrperc', '$pvtdrsharingamount','$privatedoctoramount','$privatedoctoramount','IP')";
		echo $query52."<br><br>";
		$exec52=mysqli_query($GLOBALS["___mysqli_ston"], $query52) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);


	$doc_number = $res1["transaction_number"];
	$from_table = 'billing_ipprivatedoctor';
	$remarks = 'Opening APD July-2019';
	$ledger_id = $res1["ledger_code"];
	$transaction_date = $res1["transaction_date"];
	$transaction_amount = $res1["amount"];
	$transaction_type = 'D';
	$reverse_transaction_type = 'C';
	if($transaction_amount<0){
		$transaction_type = 'C';
		$reverse_transaction_type = 'D';
		$transaction_amount = abs($transaction_amount);
	}

	$parent_type = 'L';
	$currency_code = 'CUR-1';
	$exchange_rate = 1;
	$cost_center_code = '';
	$narration = '';
	$record_status = '1';
	$user_name = 'admin';

	$query_insert_tb ="insert into tb(doc_number,from_table,remarks,ledger_id,transaction_date,transaction_amount,transaction_type,parent_type,currency_code,exchange_rate,cost_center_code,narration,record_status,user_name,locationcode)values('$doc_number','$from_table','$remarks','$reverse_ledger_id','$transaction_date','$transaction_amount','$reverse_transaction_type','$parent_type','$currency_code','$exchange_rate','$cost_center_code','$narration','$record_status','$user_name','$locationcode')";

	echo $query_insert_tb."<br><br>";
	$exec_insert_tb = mysqli_query($GLOBALS["___mysqli_ston"], $query_insert_tb) or die ("Error in query_insert_tb".mysqli_error($GLOBALS["___mysqli_ston"]));

	$query_update = "update op_ar_ap_july_2019 set status = 'done' where auto_number = '$ano'";
	$exec_update = mysqli_query($GLOBALS["___mysqli_ston"], $query_update) or die ("Error in Query_update".mysqli_error($GLOBALS["___mysqli_ston"]));


}

?>