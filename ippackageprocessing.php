<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php"); 
include ("includes/loginverify.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$username = $_SESSION["username"];
$docno = $_SESSION['docno'];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$currentdate = date("Y-m-d");
$updatedate=date("Y-m-d");
$titlestr = 'SALES BILL';

if (isset($_REQUEST["packageid"])) { $packageid = $_REQUEST["packageid"]; } else { $packageid = ""; }
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_REQUEST["patientlocation"])) {  $searchlocation = $_REQUEST["patientlocation"]; } else { $searchlocation = ""; }

if($packageid !='' && $patientcode !='' && $visitcode !='')
{
//code for if package change
$delq=mysqli_query($GLOBALS["___mysqli_ston"], "delete from package_processing where package_id != '$packageid' and  visitcode='$visitcode' and recordstatus='' ");
//end here	

// insert all the package items along with the patient info into package_processing table 
$insqry=mysqli_query($GLOBALS["___mysqli_ston"], "select id from package_processing where package_id = '$packageid' and  patientcode='$patientcode' and visitcode='$visitcode' and recordstatus='' ");
$num_rows=mysqli_num_rows($insqry);
$ress=mysqli_fetch_array($insqry);

if($num_rows == 0)
{

$patientname = $execqry['customerfullname'];

$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select customerfullname from master_customer where customercode='$patientcode'");
$execlab=mysqli_fetch_array($Querylab);
$patientname = $execlab['customerfullname'];

$qrypackageitems = "select * from package_items where package_id = '$packageid' and recordstatus != 'deleted'";

$execpackageitems = mysqli_query($GLOBALS["___mysqli_ston"], $qrypackageitems) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($respackageitems = mysqli_fetch_array($execpackageitems))
{

$package_item_type = $respackageitems['package_type'];
$itemcode = $respackageitems['itemcode'];
$itemname = $respackageitems['itemname'];
$quantity = $respackageitems['quantity'];
$itemrate = $respackageitems['rate'];
$dose = $respackageitems['dose'];
$dosemeasure = $respackageitems['dosemeasure'];
$frequency =   $respackageitems['frequency'];
$days = $respackageitems['days'];
$amount = $respackageitems['amount'];
$locationname = $respackageitems['locationname'];
$locationcode = $respackageitems['locationcode'];


$serquery2="insert into package_processing(package_id,package_item_type,patientcode,patientname,visitcode,itemcode,itemname,quantity,rate,dose,dosemeasure,frequency,days,amount,locationname,locationcode,username, ipaddress)  values ('$packageid','$package_item_type', '$patientcode','$patientname','$visitcode','$itemcode','$itemname', '$quantity','$itemrate','$dose','$dosemeasure','$frequency','$days','$amount','$locationname','$locationcode','$username', '$ipaddress')";
$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $serquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

}

} else{

$qrypackageitems = "select rate from package_items where package_id = '$packageid' and recordstatus != 'deleted' and package_type='CT'";		 
$execpackageitems = mysqli_query($GLOBALS["___mysqli_ston"], $qrypackageitems) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$respackageitems = mysqli_fetch_array($execpackageitems);
$rate = $respackageitems['rate'];

$query26="update package_processing set rate='$rate' where  visitcode='$visitcode' and package_item_type='CT' ";
$exec26=mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

}
}


if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{

//if (isset($_REQUEST["packageid"])) { $packageid = $_REQUEST["packageid"]; } else { $packageid = ""; }

$packageid = $_REQUEST["packageid"];
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

$billnumbercode = intval($billnumbercode);
$billnumbercode = $billnumbercode + 1;

$maxanum = $billnumbercode;


$billnumbercode = 'TP-' .$maxanum;
$openingbalance = '0.00';

}

$billdate=$_REQUEST['billdate'];

$paymentmode = $_REQUEST['billtype'];
$patientfullname = $_REQUEST['customername'];
$patientcode = $_REQUEST['patientcode'];
$visitcode = $_REQUEST['visitcode'];
$billtype = $_REQUEST['billtypes'];
$age=$_REQUEST['age'];
$gender=$_REQUEST['gender'];
$account = $_REQUEST['account'];
$locationcode=$_REQUEST['location'];
$rad= $_POST['radiology'];
$rat=$_POST['rate8'];
$items = array_combine($rad,$rat);
$pairs = array();

$subtypeano=$_REQUEST['subtypeano'];


foreach($_POST['labcode'] as $key=>$value)
{
$itemname = $_POST['labname'][$key];
$itemcode = $_POST['labcode'][$key];
$rowid    = $_POST['labrowid'][$key];
$selectitemcode = $_POST['selectlabcode'][$key];
$itemrate = $_POST['labrate'][$key];

foreach($_POST['selectlab'] as $check=>$value1)
{
$selectitem = $_POST['selectlab'][$check];
/*echo '#'.$selectitem.'<br>';
echo '##'.$selectitemcode.'<br>';*/
if($selectitemcode == $selectitem)
{
//echo $itemname.'-'.$itemcode.'-'.$rowid.'<br>';



$insqry = "insert into package_execution(processing_id,username,ipaddress) values ($rowid,'$username','$ipaddress') ";

mysqli_query($GLOBALS["___mysqli_ston"], $insqry) or die ("Error in Insert Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

$updqry = "update package_processing set recordstatus='completed',rate='$itemrate',amount='$itemrate' where id=$rowid";
mysqli_query($GLOBALS["___mysqli_ston"], $updqry) or die ("Error in Update Query1".mysqli_error($GLOBALS["___mysqli_ston"]));


$labname=$itemname;

$query13l = "select labtemplate from master_subtype where auto_number = '$subtypeano' and recordstatus<>'deleted' order by subtype";
$exec13l = mysqli_query($GLOBALS["___mysqli_ston"], $query13l) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res13l = mysqli_fetch_array($exec13l);
$tablenamel = $res13l['labtemplate'];
if($tablenamel == '')
{
$tablenamel = 'master_lab';
}

$stringbuild1 = "";
$labcode=$itemcode;
$labrate=$itemrate;
$labfree='Yes';
$labquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into ipconsultation_lab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,consultationdate,paymentstatus,labsamplecoll,resultentry,labrefund,iptestdocno,accountname,billtype,consultationtime,freestatus,locationcode,username,package_process_id)values('$patientcode','$patientfullname','$visitcode','$labcode','$labname','$labrate','$currentdate','paid','pending','pending','norefund','$billnumbercode','$account','$billtype','$timeonly','$labfree','$locationcode','$username','$rowid')") or die(mysqli_error($link));

}
}
}

foreach($_POST['radcode'] as $key=>$value)
{
$itemname = $_POST['radname'][$key];
$itemcode = $_POST['radcode'][$key];
$rowid    = $_POST['radrowid'][$key];
$itemrate = $_POST['radrate'][$key];
$selectitemcode = $_POST['selectradcode'][$key];

foreach($_POST['selectrad'] as $check=>$value1)
{
$selectitem = $_POST['selectrad'][$check];
/*echo '#'.$selectitem.'<br>';
echo '##'.$selectitemcode.'<br>';*/
if($selectitemcode == $selectitem)
{
//echo $itemname.'-'.$itemcode.'-'.$rowid.'<br>';


$insqry = "insert into package_execution(processing_id,username,ipaddress) values ($rowid,'$username','$ipaddress') ";

mysqli_query($GLOBALS["___mysqli_ston"], $insqry) or die ("Error in Insert Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

$updqry = "update package_processing set recordstatus='completed',rate='$itemrate',amount='$itemrate' where id=$rowid";
mysqli_query($GLOBALS["___mysqli_ston"], $updqry) or die ("Error in Update Query3".mysqli_error($GLOBALS["___mysqli_ston"]));


$pairs= $itemname;
$pairvar= $pairs;
$pairs1= $itemrate;
$pairvar1= $pairs1;
$radiologyfree = 'Yes';


$query13r = "select radtemplate from master_subtype where auto_number = '$subtypeano' order by subtype";
$exec13r = mysqli_query($GLOBALS["___mysqli_ston"], $query13r) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
$res13r = mysqli_fetch_array($exec13r);
$tablenamer = $res13r['radtemplate'];
if($tablenamer == '')
{
$tablenamer = 'master_radiology';
}

$stringbuild1 = "";
$radiologycode=$itemcode;
if(($pairvar!="")&&($pairvar1!=""))
{

$radiologyquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into ipconsultation_radiology(patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,consultationdate,resultentry,iptestdocno,accountname,billtype,consultationtime,freestatus,locationcode,username,package_process_id)values('$patientcode','$patientfullname','$visitcode','$radiologycode','$pairvar','$pairvar1','$currentdate','pending','$billnumbercode','$account','$billtype','$timeonly','$radiologyfree','$locationcode','$username','$rowid')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));


}
}
}
}

foreach($_POST['servicecode'] as $key=>$value)
{
$itemname = $_POST['servicename'][$key];
$itemcode = $_POST['servicecode'][$key];
$itemrate = $_POST['servicerate'][$key];
$rowid    = $_POST['servicerowid'][$key];
$selectitemcode = $_POST['selectservicecode'][$key];
$serviceissqty = $_POST['serqty'][$key];
$servicepckqty = $_POST['serqtypk'][$key];
$servicepckbalqty = $_POST['serqtypkbal'][$key];
$seramt = $_POST['seramt'][$key];


foreach($_POST['selectservice'] as $check=>$value1)
{
$selectitem = $_POST['selectservice'][$check];
/*echo '#'.$selectitem.'<br>';
echo '##'.$selectitemcode.'<br>';*/
if($selectitemcode == $selectitem)
{
//echo $itemname.'-'.$itemcode.'-'.$rowid.'-'.$serviceissqty.'<br>';



$insqry = "insert into package_execution(processing_id,qty,username,ipaddress) values ($rowid,'$serviceissqty','$username','$ipaddress') ";

mysqli_query($GLOBALS["___mysqli_ston"], $insqry) or die ("Error in Insert Query7".mysqli_error($GLOBALS["___mysqli_ston"]));

$recordstatus = 'partial';
if($serviceissqty == $servicepckbalqty )
$recordstatus = 'completed';
$totalsiamt= $servicepckqty*$itemrate;
$updqry = "update package_processing set recordstatus='".$recordstatus."',rate='$itemrate',amount='$totalsiamt' where id=$rowid";
mysqli_query($GLOBALS["___mysqli_ston"], $updqry) or die ("Error in Update Query6".mysqli_error($GLOBALS["___mysqli_ston"]));


$ledgercode=$_POST["ledgercode"][$key];
$ledgername=$_POST["ledgername"][$key];
$servicesname=addslashes($itemname);


$query13s = "select sertemplate from master_subtype where auto_number = '$subtypeano' order by subtype";
$exec13s = mysqli_query($GLOBALS["___mysqli_ston"], $query13s) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
$res13s = mysqli_fetch_array($exec13s);
$tablenames = $res13s['sertemplate'];
if($tablenames == '')
{
$tablenames = 'master_services';
}

$stringbuild1 = "";
$servicescode=$itemcode;
//$serdoct=$_POST["serdoct"][$key];
$serdoct="";
$serdoctcode="";
$servicesrate=$itemrate;
$servicesfree = 'Yes';
$quantityser=$serviceissqty;
$seramount=$seramt;
if(($servicesname!="")&&($servicesrate!=''))
{
$servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into ipconsultation_services(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,consultationdate,paymentstatus,process,iptestdocno,accountname,billtype,consultationtime,freestatus,locationcode,serviceqty,amount,incomeledgercode,incomeledgername,username,doctorcode,doctorname,package_process_id)values('$patientcode','$patientfullname','$visitcode','$servicescode','$servicesname','$servicesrate','$currentdate','paid','pending','$billnumbercode','$account','$billtype','$timeonly','$servicesfree','$locationcode','".$quantityser."','".$seramount."','$ledgercode','$ledgername','$username','$serdoctcode','$serdoct','$rowid')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));

mysqli_query($GLOBALS["___mysqli_ston"], "insert into iptest_procedures(docno,patientname,patientcode,visitcode,account,recorddate,ipaddress,recordtime,username,billtype,locationcode,doctorcode,doctorname,package_process_id)values('$billnumbercode','$patientfullname','$patientcode','$visitcode','$account','$currentdate','$ipaddress','$timeonly','$username','$billtype','$locationcode','$serdoctcode','$serdoct','$rowid')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
}
}
}
}


/*	foreach($_POST['doctorcode'] as $key=>$value)
{
$itemname = $_POST['doctorname'][$key];
$itemcode = $_POST['doctorcode'][$key];
$rowid    = $_POST['doctorrowid'][$key];
$selectitemcode = $_POST['selectdoctorcode'][$key];
$itemrate = $_POST['doctorrate'][$key];

foreach($_POST['selectdoctor'] as $check=>$value1)
{
$selectitem = $_POST['selectdoctor'][$check];

if($selectitemcode == $selectitem)
{

$insqry = "insert into package_execution(processing_id,username,ipaddress) values ($rowid,'$username','$ipaddress') ";

mysql_query($insqry) or die ("Error in Insert Query4".mysql_error());

$updqry = "update package_processing set recordstatus='completed' where id=$rowid";
mysql_query($updqry) or die ("Error in Update Query1".mysql_error());

}
}
}*/
/*
foreach($_POST['pharmacode'] as $key=>$value)
{
$itemname = $_POST['pharmaname'][$key];
$itemcode = $_POST['pharmacode'][$key];
$rowid    = $_POST['pharmarowid'][$key];
$selectitemcode = $_POST['selectpharmacode'][$key];
$serviceissqty = $_POST['pharmaqty'][$key];
$servicepckqty = $_POST['pharmaqtypk'][$key];
$servicepckbalqty = $_POST['pharmaqtypkbal'][$key];

foreach($_POST['selectpharma'] as $check=>$value1)
{

$selectitem = $_POST['selectpharma'][$check];

if($selectitemcode == $selectitem)
{


$recordstatus = 'partial';
if($serviceissqty == $servicepckbalqty )
$recordstatus = 'completed';

$updqry = "update package_processing set recordstatus='".$recordstatus."' where id=$rowid";
mysql_query($updqry) or die ("Error in Update Query9".mysql_error());

$insqry = "insert into package_execution(processing_id,qty,username,ipaddress) values ($rowid,'$serviceissqty','$username','$ipaddress') ";

mysql_query($insqry) or die ("Error in Insert Query10".mysql_error());



}
}
}*/
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


$patientname = $_REQUEST['customername'];
$locationcode = $_REQUEST['location'];
$patientcode = $_REQUEST['patientcode'];
$visitcode = $_REQUEST['visitcode'];
$billtype = $_REQUEST['billtypes'];

$accountname = $_REQUEST['account'];
$dischargemedicine = isset($_REQUEST["dischargemedicine"])? 'Yes' : 'No';

$locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';

$locationcodeget=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
$storecodeget=isset($_REQUEST['storecode'])?$_REQUEST['storecode']:'';

$itemscount = $_REQUEST['serialnumber'];	

$qty_arr = array();
for ($p=1;$p<=$itemscount;$p++)
{	
if(isset($_REQUEST['medicinecodee'.$p]))
{


$medicinename = $_REQUEST['medicinename'.$p];
$medicinename = addslashes($medicinename);
$medicinecode = trim($_REQUEST['medicinecodee'.$p]);
$rowid = $_REQUEST['medprocessrowid'.$p];



$query77="select categoryname from master_medicine where itemcode='$medicinecode' and status =''";
$exec77=mysqli_query($GLOBALS["___mysqli_ston"], $query77);
$res77=mysqli_fetch_array($exec77);

$categoryname = $res77['categoryname'];


if($medicinecode==""){
continue;
}

$quantity = $_REQUEST['quantity'.$p];

$pharmfree = 'Yes';

$sec = '00';
$expirymonth = substr($expirydate, 0, 2);
$expiryyear = substr($expirydate, 3, 2);
$expiryday = '01';
$expirydate = $expiryyear.'-'.$expirymonth.'-'.$expiryday;


$rates= $_REQUEST['rates'.$p];//sales
$amounts= $_REQUEST['amounts'.$p];

$fifo_code = $_REQUEST['fifo_code'.$p];

$medicinebatch = $_REQUEST['medicinebatch'.$p];
$medicinebatch = str_replace(" ","",$medicinebatch);
$medicinebatch = trim($medicinebatch);
$uniquebatch = $_REQUEST['uniquebatch'.$p];



$query6 = "select ledgername, ledgercode, ledgerautonumber,incomeledger,incomeledgercode from master_medicine where itemcode = '$medicinecode'"; 
$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
$res6 = mysqli_fetch_array($exec6);
$ledgername = $res6['ledgername'];
$ledgercode = $res6['ledgercode'];
$ledgeranum = $res6['ledgerautonumber'];
$incomeledger =$res6['incomeledger'];
$incomeledgercode = $res6['incomeledgercode'];


$query40 = "select rate from transaction_stock where batch_stockstatus='1' and itemcode='$medicinecode' and locationcode='$locationcodeget' and batchnumber ='$medicinebatch' and fifo_code='$fifo_code' and storecode ='$storecodeget' limit 0,1";

$exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die ("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));
$res40 = mysqli_fetch_array($exec40);
$rate = $res40['rate'];

$amount = $quantity * $rate;

if ($medicinename != "")
{


$querycumstock2 = "select cum_quantity from transaction_stock where cum_stockstatus='1' and itemcode='$medicinecode' and locationcode='$locationcodeget'";
$execcumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querycumstock2) or die ("Error in CumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
$rescumstock2 = mysqli_fetch_array($execcumstock2);
$cum_quantity = $rescumstock2["cum_quantity"];
$cum_quantity = $cum_quantity-$quantity;
if($cum_quantity=='0'){ $cum_stockstatus='0'; }else{$cum_stockstatus='1';}

$querybatstock2 = "select batch_quantity, auto_number from transaction_stock where batch_stockstatus='1' and itemcode='$medicinecode' and locationcode='$locationcodeget' and fifo_code='$fifo_code' and storecode ='$storecodeget'";
$execbatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querybatstock2) or die ("Error in batQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
$resbatstock2 = mysqli_fetch_array($execbatstock2);
$bat_quantity = $resbatstock2["batch_quantity"];
$auto_num1 = $resbatstock2["auto_number"];
$quantity = intval($quantity);
$bat_quantity = $bat_quantity-$quantity;
$bat_quantity = intval($bat_quantity);

if($bat_quantity=='0'){ $batch_stockstatus='0'; }else{$batch_stockstatus='1';}
if($bat_quantity>='0')
{
$querycheckbat = "select auto_number from transaction_stock where itemcode='$medicinecode' and locationcode='$locationcodeget' and fifo_code='$fifo_code' and storecode ='$storecodeget' and auto_number > '$auto_num1'";
$execcheckbat= mysqli_query($GLOBALS["___mysqli_ston"], $querycheckbat) or die ("Error in checkbat".mysqli_error($GLOBALS["___mysqli_ston"]));
$num252 = mysqli_num_rows($exec251);
if($num252 == 0){

$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' ,batch_stockstatus='0' where itemcode='$medicinecode' and locationcode='$locationcodeget' and storecode='$storecodeget' and fifo_code='$fifo_code'";
$execupdatebatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatebatstock2) or die ("Error in updatebatQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));



$stockquery2="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,
batchnumber, batch_quantity, 
transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,patientcode,patientvisitcode,patientname,rate,totalprice,ledgeranum,ledgercode,ledgername,incomeledger,incomeledgercode)
values ('$fifo_code','pharmacysales_details','$medicinecode', '$medicinename', '$dateonly','0', 'IP Direct Sales', 
'$medicinebatch', '$bat_quantity', '$quantity', 
'$cum_quantity', '$billnumbercode', '','$cum_stockstatus','$batch_stockstatus', '$locationcodeget','','$storecodeget', '', '$username', '$ipaddress','$dateonly','$timeonly','$datetimeonly','$patientcode','$visitcode','$patientname','$rate','$amount','$ledgeranum','$ledgercode','$ledgername','$incomeledger','$incomeledgercode')";

$stockexecquery2=mysqli_query($GLOBALS["___mysqli_ston"], $stockquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$query86 ="insert into ipmedicine_prescription(itemname,itemcode,quantity,prescribed_quantity,rateperunit,totalrate,batchnumber,companyanum,patientcode,visitcode,patientname,username,ipaddress,date,account,docno,billtype,expirydate,freestatus,dischargemedicine,medicineissue,locationcode,locationname,package_process_id)values('$medicinename','$medicinecode','$quantity','$quantity','$rates','$amounts','$medicinebatch','$companyanum','$patientcode','$visitcode','$patientname','$username','$ipaddress','$dateonly','$accountname','$billnumbercode','$billtype','$expirydate','$pharmfree','$dischargemedicine','completed','".$locationcodeget."','".$locationnameget."','$rowid')"; 

$exec86 = mysqli_query($GLOBALS["___mysqli_ston"], $query86) or die(mysqli_error($GLOBALS["___mysqli_ston"]));


$query66 ="insert into pharmacysales_details(fifo_code,itemname,itemcode,quantity,rate,totalamount,batchnumber,companyanum,patientcode,visitcode,patientname,financialyear,username,ipaddress,entrydate,accountname,ipdocno,entrytime,location,store,issuedfrom,freestatus,categoryname,locationcode,locationname,ledgeranum,ledgercode,ledgername,incomeledger,incomeledgercode,package_process_id,costprice,totalcp)values('$fifo_code','$medicinename','$medicinecode','$quantity','$rates','$amounts','$medicinebatch','$companyanum','$patientcode','$visitcode','$patientname','$financialyear','$username','$ipaddress','$dateonly','$accountname','$billnumbercode','$timeonly','$location1','$storecodeget','ip','$pharmfree','$categoryname','".$locationcodeget."','".$locationnameget."','$ledgeranum','$ledgercode','$ledgername','$incomeledger','$incomeledgercode','$rowid','$rate','$amount')";

$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$query86 ="insert into ipmedicine_issue(itemname,itemcode,quantity,rateperunit,totalrate,batchnumber,companyanum,patientcode,visitcode,patientname,username,ipaddress,date,account,docno,billtype,expirydate,freestatus,dischargemedicine,locationcode,locationname,package_process_id)values('$medicinename','$medicinecode','$quantity','$rates','$amounts', '$medicinebatch','$companyanum','$patientcode','$visitcode','$patientname','$username','$ipaddress','$dateonly','$accountname','$billnumbercode','$billtype','$expirydate','$pharmfree','$dischargemedicine','".$locationcodeget."','".$locationnameget."','$rowid')";

$exec86 = mysqli_query($GLOBALS["___mysqli_ston"], $query86) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
}
}


/*$package_type = 'MI';

$qrypackage1 = "select id from package_processing  where package_id=$packageid and package_item_type='$package_type' and patientcode='$patientcode' and visitcode='$visitcode' and itemcode='$medicinecode' ";
$execpackage1 = mysql_query($qrypackage1);
$respackage1 = mysql_fetch_array($execpackage1);
$processing_rowid = $respackage1['id'];*/

$insqry = "insert into package_execution(processing_id,qty,username,ipaddress) values ('$rowid','$quantity','$username','$ipaddress') ";

mysqli_query($GLOBALS["___mysqli_ston"], $insqry) or die ("Error in Insert Query11".mysqli_error($GLOBALS["___mysqli_ston"]));


// Status Update 
$package_type = 'MI';
$qryqty = "select quantity from package_processing where id = '$rowid'";
$execqry = mysqli_query($GLOBALS["___mysqli_ston"], $qryqty) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$resqty = mysqli_fetch_array($execqry);
$package_item_qty = $resqty['quantity'];
$totalpharmaamt=$package_item_qty*$rates;

$issqry1 = "select sum(qty) issuedqty from package_execution where processing_id='$rowid'";
$execiss1 = mysqli_query($GLOBALS["___mysqli_ston"], $issqry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$resiss1 = mysqli_fetch_array($execiss1);
$issuedqty = $resiss1['issuedqty'];

$recordstatus = 'partial';
if($issuedqty == $package_item_qty )
$recordstatus = 'completed';

$updqry = "update package_processing set recordstatus='".$recordstatus."',rate='$rates',amount='$totalpharmaamt' where id=$rowid";
mysqli_query($GLOBALS["___mysqli_ston"], $updqry) or die ("Error in Update Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

// ----


/*if(!in_array($medicinecode,$medicinecode_arr))
{
$medicinecode_arr[] = $medicinecode;
//$rowid_arr[$medicinecode] = $processing_rowid;
$rowid_arr[$medicinecode] = $rowid;
//$qty_arr[$medicinecode] = $quantity;
}
$qty_arr[$medicinecode][] = $quantity;*/

}
}
}

/*foreach ($qty_arr as $key => $medarr) {
# code...
$qtytot = 0;

foreach ($medarr as $k => $qty) {
# code...
$qtytot = $qtytot + $qty;

}
$qtytot_arr[$key] = $qtytot;
}*/

/*$package_type = 'MI';
foreach ($qtytot_arr as $itemcode => $balqty) {
# code...

$qrylab = "select id,itemcode,itemname,rate,amount,quantity from package_processing where package_id = '$packageid' and package_item_type ='$package_type' and patientcode='$patientcode' and visitcode='$visitcode' and recordstatus <> 'completed' and itemcode='$itemcode' ";
$pharmacy_used_amt = 0;
$execlab = mysql_query($qrylab) or die(mysql_error());

while($reslab = mysql_fetch_array($execlab))
{
$package_item_qty = $reslab['quantity'];
$rowid     = $reslab['id'];
$issqry = "select id from package_execution where processing_id='$rowid'";
$execiss = mysql_query($issqry) or die(mysql_error());
$iss_num_rows = mysql_num_rows($execiss);
if($iss_num_rows)
{

$execiss1 = mysql_query($issqry) or die(mysql_error());
$issqry1 = "select sum(qty) issuedqty from package_execution where processing_id='$rowid'";
$execiss1 = mysql_query($issqry1) or die(mysql_error());
$resiss1 = mysql_fetch_array($execiss1);
$issuedqty = $resiss1['issuedqty'];

$recordstatus = 'partial';
if($issuedqty == $package_item_qty )
$recordstatus = 'completed';
$rowid = 	$rowid_arr[$itemcode];
$updqry = "update package_processing set recordstatus='".$recordstatus."' where id=$rowid";
mysql_query($updqry) or die ("Error in Update Query9".mysql_error());


}

}

}*/
/*echo '<pre>';print_r($qtytot_arr);
echo '<pre>';print_r($rowid_arr);


exit;*/

//$package_type = 'CT';


//$rowid = $_REQUEST['selectconrowid'];
//$upd_qry = "update package_items set itemcode= '$serdoctcode',itemname='$serdoct' where package_id=$packageid and package_type='$package_type'";


if(isset($_POST['selectconsult']))
{

$rowid = $_REQUEST['selectconrowid'];

if($rowid)
{

$insqry = "insert into package_execution(processing_id,username,ipaddress) values ($rowid,'$username','$ipaddress') ";
mysqli_query($GLOBALS["___mysqli_ston"], $insqry) or die ("Error in Insert Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
$recordstatus = 'completed';
$updqry = "update package_processing set recordstatus='".$recordstatus."' where id=$rowid";
mysqli_query($GLOBALS["___mysqli_ston"], $updqry) or die ("Error in Update Consulatation Query".mysqli_error($GLOBALS["___mysqli_ston"]));

}

}



foreach($_POST['referal'] as $key=>$value){	




$package_item_type = 'DC';
$itemcode = $_POST['referalcode'][$key];
$itemname = $_POST['referal'][$key];

$itemrate =  $_POST['rate4'][$key];


$amount =$_POST['amount4'][$key];

$description = $_POST['description'][$key];

if($_POST['referalcode'][$key] !="")
{
$serquery2="insert into package_processing (package_id,package_item_type,patientcode,patientname,visitcode,itemcode, itemname,quantity,rate,dose,dosemeasure,frequency,days,amount,description,locationname,locationcode,username, ipaddress) 
values ('$packageid','$package_item_type', '$patientcode','$patientname','$visitcode','$itemcode','$itemname', '$quantity','$itemrate','$dose','$dosemeasure','$frequency','$days','$amount','$description','$locationnameget','$locationcodeget','$username', '$ipaddress')";

$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $serquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$rowid = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);

$insqry = "insert into package_execution(processing_id,username,ipaddress) values ($rowid,'$username','$ipaddress') ";

mysqli_query($GLOBALS["___mysqli_ston"], $insqry) or die ("Error in Insert Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

$updqry = "update package_processing set recordstatus='completed' where id=$rowid";
mysqli_query($GLOBALS["___mysqli_ston"], $updqry) or die ("Error in Update Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

}


}

if(isset($_POST['selectconrowid']) && $_POST['selectconrowid'] !='')
{
$rowid = $_REQUEST['selectconrowid'];
$serdoctcode = $_REQUEST['serdoctcode'];
$serdoct = $_REQUEST['serdoct'];
$upd_qry = "update package_processing set itemcode= '$serdoctcode',itemname='$serdoct' where id=$rowid";
mysqli_query($GLOBALS["___mysqli_ston"], $upd_qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
}

if(isset($_POST['finishprocess']))
{


$upd_qry = "update master_ipvisitentry set package_process= 'completed' where patientcode='$patientcode' and visitcode='$visitcode' and package='$packageid'";
mysqli_query($GLOBALS["___mysqli_ston"], $upd_qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

}
header("location:ippackageprocesslist.php");
exit;

}

?>

<?php
$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab=mysqli_fetch_array($Querylab);
$patientage=$execlab['age'];
$patientgender=$execlab['gender'];
$patientname = $execlab['customerfullname'];
$billtype = $execlab['billtype'];

$Queryloc=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'");
$execloc=mysqli_fetch_array($Queryloc);
$locationcode=$execloc['locationcode'];
$locationname=$execloc['locationname'];
$packcharge = $execloc['packchargeapply'];

$patienttype=$execlab['maintype'];
$querytype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where auto_number='$patienttype'");
$exectype=mysqli_fetch_array($querytype);
$patienttype1=$exectype['paymenttype'];
$patientsubtype=trim($execloc['subtype']);


$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$patientsubtype'");
$execsubtype=mysqli_fetch_array($querysubtype);
$patientsubtype1=$execsubtype['subtype'];
$res131subtype=$execsubtype['subtype'];
$labtemplate=$execsubtype['labtemplate'];
$radtemplate=$execsubtype['radtemplate'];
$sertemplate=$execsubtype['sertemplate'];
$ippactemplate=$execsubtype['ippactemplate'];

$querytt32 = "select * from master_testtemplate where templatename='$ippactemplate'";
$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$numtt32 = mysqli_num_rows($exectt32);
$exectt=mysqli_fetch_array($exectt32);
$ippactemplate=$exectt['templatename'];
if($ippactemplate=='')
{
$ippactemplate='master_ippackage';
}

$patientplan=$execlab['planname'];
$queryplan=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_planname where auto_number='$patientplan'");
$execplan=mysqli_fetch_array($queryplan);
$patientplan1=$execplan['planname'];
$res111subtype=$patientsubtype;
?>
<?php
$querylab1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab1=mysqli_fetch_array($querylab1);
$patientname=$execlab1['customerfullname'];
$patientaccount=$execlab1['accountname'];

$querylab2=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number='$patientaccount'");
$execlab2=mysqli_fetch_array($querylab2);
$patientaccount1=$execlab2['accountname'];


$querytl32 = "select * from master_testtemplate where templatename='$labtemplate'";
$exectl32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytl32) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$numtl32 = mysqli_num_rows($exectl32);
$exectl=mysqli_fetch_array($exectl32);		
$labtable=$exectl['templatename'];
if($labtable=='')
{
$labtable='master_lab';
}

$querytt32 = "select * from master_testtemplate where templatename='$radtemplate'";
$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$numtt32 = mysqli_num_rows($exectt32);
$exectt=mysqli_fetch_array($exectt32);		
$radtable=$exectt['templatename'];
if($radtable=='')
{
$radtable='master_radiology';
}

$querytt32 = "select * from master_testtemplate where templatename='$sertemplate'";
$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$numtt32 = mysqli_num_rows($exectt32);
$exectt=mysqli_fetch_array($exectt32);
$sertable=$exectt['templatename'];
if($sertable=='')
{
$sertable='master_services';
}

?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
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
?>
<?php 
$locationcode=$execloc['locationcode'];


?>

<script type="text/javascript">

function formatMoney(number, places, thousand, decimal) {
number = number || 0;
places = !isNaN(places = Math.abs(places)) ? places : 2;

thousand = thousand || ",";
decimal = decimal || ".";
var negative = number < 0 ? "-" : "",
i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
j = (j = i.length) > 3 ? j % 3 : 0;
return  negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");

}





</script>


<script language="javascript">
var totalamount=0;
var totalamount1=0;
var totalamount2=0;
var totalamount3=0;
var totalamount4=0;
var totalamount11;
var totalamount21;
var totalamount31;
var totalamount41;
var grandtotal=0;
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

function Functionfrequency()
{
var ResultFrequency;
var frequencyanum = document.getElementById("frequency").value;
var medicinedose=document.getElementById("dose").value;
var VarDays = document.getElementById("days").value; 
if((frequencyanum != '') && (VarDays != ''))
{
ResultFrequency = medicinedose*frequencyanum * VarDays;
}
else
{
ResultFrequency =0;
}
document.getElementById("quantity").value = ResultFrequency;
var VarRate = document.getElementById("rate").value;
var ResultAmount = parseFloat(VarRate * ResultFrequency);
document.getElementById("amount").value = ResultAmount.toFixed(2);
}
function processflowitem(varstate)
{
//alert ("Hello World.");
var varProcessID = varstate;
//alert (varProcessID);
var varItemNameSelected = document.getElementById("state").value;
//alert (varItemNameSelected);
ajaxprocess5(varProcessID);
//totalcalculation();
}

function processflowitem1()
{
}
function btnDeleteClick_pharma(delID,pharmamount)
{
var pharmamount=pharmamount;
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
var currenttotal4=document.getElementById('total').value;
//alert(currenttotal);
newtotal4= currenttotal4-pharmamount;

//alert(newtotal);

document.getElementById('total').value=newtotal4;

var currentgrandtotal4=document.getElementById('total4').value;
if(currentgrandtotal4 == '')
{
currentgrandtotal4=0;
}

if(document.getElementById('total1').value=='')
{
totalamount11=0;
}
else
{
totalamount11=document.getElementById('total1').value;
}
if(document.getElementById('total2').value=='')
{
totalamount21=0;
}
else
{
totalamount21=document.getElementById('total2').value;
}
if(document.getElementById('total3').value=='')
{
totalamount31=0;
}
else
{
totalamount31=document.getElementById('total3').value;
}


var newgrandtotal4=parseInt(newtotal4)+parseInt(totalamount11)+parseInt(totalamount21)+parseInt(totalamount31);

//alert(newgrandtotal4);

document.getElementById('total4').value=newgrandtotal4.toFixed(2);


document.getElementById("totalamount").value=newgrandtotal4.toFixed(2);
document.getElementById("subtotal").value=newgrandtotal4.toFixed(2);
document.getElementById("subtotal1").value=newgrandtotal4.toFixed(2);
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
var vartotal12= parseFloat(document.getElementById('mi_items_subtotal_val').value);

vartotal12=vartotal12-varamount12;
document.getElementById('mi_items_subtotal').value=vartotal12.toFixed(2);
document.getElementById('mi_items_subtotal_val').value=vartotal12;

calculate_items_grand_total();
calculate_package_variance();


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

var child = document.getElementById('idTRPH'+varDeleteID);  //tr name
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
var itemscount = $('#itemscount').val();
var items_incr = parseInt(itemscount) - 1;
$('#itemscount').val(items_incr);

}



function sertotal()
{
var varquantityser = document.getElementById("serqty").value;
var varserRate = document.getElementById("serrate").value;
if(varquantityser!='' && varserRate!='') {
var totalservi = parseFloat(varquantityser) * parseFloat(varserRate);
document.getElementById("seramt").value=totalservi.toFixed(2);}
}
function labFunction() {
var subtype = document.getElementById("subtypeano").value;
var packcharge = document.getElementById("packcharge").value;

var myWindow = window.open("addlabtest1.php?subtype="+subtype+"&&pkg="+packcharge, "MsgWindow" ,'width='+screen.availWidth+',height='+screen.availHeight+',toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=1,resizable=1,left=0,top=0','fullscreen');
//myWindow.document.write("<p>This is 'MsgWindow'. I am 200px wide and 100px tall!</p>");
if (myWindow) {
myWindow.onclose = function () { alert("close window"); }
}
}

</script>
<script>
function validcheck()
{
/*document.getElementById("Submit2223").disabled=true;
var finaltotal=document.getElementById("total3").value;
var finaltotal1=document.getElementById("total2").value;
var finaltotal12=document.getElementById("total1").value;
var fintot=finaltotal+finaltotal1+finaltotal12;

if(fintot=="" || fintot=="0.00" || fintot=="0")
{
alert("Please select any test");
document.getElementById("Submit2223").disabled=false;
return false;
}*/

var finalize=confirm("Are you want to Save Records");
if(finalize!=true)
{
document.getElementById("Submit2223").disabled=false;
return false;
}

}
function cleardatas(datas)
{
if(datas=='lab')
{
document.getElementById("serialnumber17").value='';
document.getElementById("labcode").value='';
document.getElementById("rate5").value='';
document.getElementById("pkg").value='';
document.getElementById("labfree").value='';
}
if(datas=='rad')
{
document.getElementById("serialnumber27").value='';
document.getElementById("radiologycode").value='';
document.getElementById("rate8").value='';
document.getElementById("pkg1").value='';
document.getElementById("radiologyfree").value='';

}
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
</script>



<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
body {
margin-left: 0px;
margin-top: 0px;
background-color: #ecf0f5;
}
.style1 {
font-size: 30px;
font-weight: bold;
}
.style2 {
font-size: 18px;
font-weight: bold;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
.bal
{
border-style:none;
background:none;
text-align:right;
font-size: 30px;
font-weight: bold;
FONT-FAMILY: Tahoma
}
.subtotals{font-weight: bold;padding-left:4px;margin-left: 4px;}
#mi_items_subtotal_table,#insertrow2,#insertrow3,#insertrow4{font-size: 14px;}
#mi_items_subtotal_table{padding-left: 25px;}
</style>

<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<link href="js/jquery-ui.css" rel="stylesheet">
<script src="js/datetimepicker_css.js"></script>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<?php include ("js/dropdownlistippackageprocessing.php"); ?>
<script type="text/javascript" src="js/autosuggestippackageprocessing.js?v=3"></script> 
<script type="text/javascript" src="js/autocomplete_ippackageprocessing.js"></script>
<script type="text/javascript" src="js/automedicinecodesearchippackageprocessing.js"></script>
<script type="text/javascript" src="js/autocomplete_batchnumberippackageprocessing.js"></script>
<script type="text/javascript" src="js/insertnewitemippackageprocessing.js"></script>
<script type="text/javascript" src="js/autocomplete_expirydateippackageprocessing.js"></script>
<script type="text/javascript" src="js/autocomplete_stockippackageprocessing.js"></script>
<script type="text/javascript" src="js/insertnewitemipdoctorpkg.js"></script>
<script type="text/javascript">


function funcOnLoadBodyFunctionCall()
{


//To reset any previous values in text boxes. source .js - sales1scripting1.php

//To handle ajax dropdown list.


funcCustomerDropDownSearch4(); 

//funcCustomerDropDownSearch7();		
}
</script>
<body onLoad="return funcOnLoadBodyFunctionCall();">
<script type="text/javascript">
function subtotal_add_lab(sno)
{

var labrate = $('#labrate'+sno).val();
console.log('lbarate'+labrate)
var subtotal = $('#li_items_subtotal_val').val();
console.log(subtotal)

var new_subtotal = parseFloat(subtotal) +  parseFloat(labrate);
$('#li_items_subtotal').val(formatMoney(new_subtotal.toFixed(2)));
$('#li_items_subtotal_val').val(new_subtotal)
}

function subtotal_minus_lab(sno)
{

var labrate = $('#labrate'+sno).val();
console.log('lbarate'+labrate)
var subtotal = $('#li_items_subtotal_val').val();
console.log(subtotal)

var new_subtotal = parseFloat(subtotal) -  parseFloat(labrate);
$('#li_items_subtotal').val(formatMoney(new_subtotal.toFixed(2)));
$('#li_items_subtotal_val').val(new_subtotal)
}

function subtotal_add_rad(sno)
{

var radrate = $('#radrate'+sno).val();

var subtotal = $('#ri_items_subtotal_val').val();
console.log(subtotal)

var new_subtotal = parseFloat(subtotal) +  parseFloat(radrate);
$('#ri_items_subtotal').val(formatMoney(new_subtotal.toFixed(2)));
$('#ri_items_subtotal_val').val(new_subtotal)
}

function subtotal_minus_rad(sno)
{

var radrate = $('#radrate'+sno).val();

var subtotal = $('#ri_items_subtotal_val').val();
console.log(subtotal)

var new_subtotal = parseFloat(subtotal) -  parseFloat(radrate);
$('#ri_items_subtotal').val(formatMoney(new_subtotal.toFixed(2)));
$('#ri_items_subtotal_val').val(new_subtotal)
}

function subtotal_add_service(sno)
{

var servicerate = $('#serrate'+sno).val();
var qty =  $('#serqty'+sno).val();
var amount = parseFloat(servicerate) * parseFloat(qty);
var subtotal = $('#si_items_subtotal_val').val();
console.log(subtotal)

var new_subtotal = parseFloat(subtotal) +  parseFloat(amount);
$('#si_items_subtotal').val(formatMoney(new_subtotal.toFixed(2)));
$('#si_items_subtotal_val').val(new_subtotal)
}
function subtotal_minus_service(sno)
{

var servicerate = $('#serrate'+sno).val();
var qty =  $('#serqty'+sno).val();
var amount = parseFloat(servicerate) * parseFloat(qty);
var subtotal = $('#si_items_subtotal_val').val();
console.log(subtotal)

var new_subtotal = parseFloat(subtotal) - parseFloat(amount);
$('#si_items_subtotal').val(formatMoney(new_subtotal.toFixed(2)));
$('#si_items_subtotal_val').val(new_subtotal)
}
$(document).ready(function(){

$('#serdoct').autocomplete({
source:"ajaxdoc.php",
select:function(event,ui){
$('#serdoct').val(ui.item.value);
$('#serdoctcode').val(ui.item.id);
}
});

$('#referal').autocomplete({
source:"ajaxdocip.php",
select:function(event,ui){
$('#rate4').val(ui.item.fees);
$('#amount4').val(ui.item.fees);
$('#referalcode').val(ui.item.id);

}
});
$('.onlynumber').keypress(function (event) {
return isOnlyNumber(event, this)
});
$('.selectconsult').change(function() {


if($(this).is(":checked")) {
// consultation checked

var consultation_amt = $('#consultation_amt').val();

$('#ct_items_subtotal').val(formatMoney(consultation_amt));
$('#ct_items_subtotal_val').val(consultation_amt);

calculate_items_grand_total();
calculate_package_variance();

}
else
{
// consultation un checked
var consultation_amt = 0;

$('#ct_items_subtotal').val(formatMoney(consultation_amt));
$('#ct_items_subtotal_val').val(consultation_amt);

calculate_items_grand_total();
calculate_package_variance();
}
});
$('#finishprocess').change(function() {

if($(this).is(":checked")) {
// Finish Process checkbox checked
var txt;
var r = confirm("Are you sure all the package is processed? If Yes Pl Click OK else Cancel");
if (r == true) {
txt = "You pressed OK!";
} else {
txt = "You pressed Cancel!";
$(this). prop("checked", false);
}

}

});
//selectlab
$('.selectlab').change(function() {
var sno = $(this).attr('sno');

if($('#selectlab'+sno).is(":checked")) {
// lab checked
subtotal_add_lab(sno);
calculate_items_grand_total();
calculate_package_variance();
}
else
{
// lab un checked
subtotal_minus_lab(sno);
calculate_items_grand_total();
calculate_package_variance();
}
});

$('.selectrad').change(function() {
var sno = $(this).attr('sno');

if($('#selectrad'+sno).is(":checked")) {
// rad checked
subtotal_add_rad(sno);
calculate_items_grand_total();
calculate_package_variance();
}
else
{
// rad un checked
subtotal_minus_rad(sno);
calculate_items_grand_total();
calculate_package_variance();
}
});


$('.selectservice').change(function() {
var sno = $(this).attr('sno');

if($('#selectservice'+sno).is(":checked")) {
// service checked
subtotal_add_service(sno);
$('#serqty'+sno).prop("readonly",false);

calculate_items_grand_total();
calculate_package_variance();
}
else
{
// service un checked
subtotal_minus_service(sno);
$('#serqty'+sno).prop("readonly",true);
calculate_items_grand_total();
calculate_package_variance();
}
});

$( ".serviceqty" ).keyup(function() {
//var id = $(this).attr('id');
var sno = $(this).attr('sno');

var varquantityser = document.getElementById("serqty"+sno).value;
var varserRate = document.getElementById("serrate"+sno).value;



//if(varquantityser!='' && varserRate!='') {
if(varquantityser!='' && varserRate!='') {

var package_qty = $('#serqtypk'+sno).val();
var bal_qty_avai = $("#serqtypkbal"+sno).val();
/*if(parseInt(varquantityser) > parseInt(package_qty ))
{
alert('Quantity cannot be more than Package quantity');
$("#serqty"+sno).val('');
$("#serqty"+sno).focus();
return false;
}*/

if(parseInt(varquantityser) > parseInt(bal_qty_avai ))
{
alert('Entered Quantity cannot be more than Balance Quantity, Please enter lesser quantity');
$("#serqty"+sno).val(0);
$("#serqty"+sno).focus();
$(this).keyup();
return false;
}
var totalservi = parseFloat(varquantityser) * parseFloat(varserRate);
document.getElementById("seramt"+sno).value=totalservi.toFixed(2);
//$('#selectservice'+sno).change();

var classname = 'sercalamt';
var id = 'si_items_subtotal';
calculate_items_total1(classname,id,sno);
//calculate_items_total(classname,id);
/*var issuedqty = $('#serqtyiss'+sno).val();
var bal_qty =  ( parseInt(package_qty) -  ( parseInt(issuedqty)  + parseInt(varquantityser) ) );*/
/*var bal_qty = parseInt(package_qty) - parseInt(varquantityser);
$("#serqtypkbal"+sno).val(bal_qty);*/


}

});

$( "#quantity" ).keyup(function() {


var varquantitypharma = document.getElementById("quantity").value;
var varpharmaRate = document.getElementById("rate").value;
if(varquantitypharma!='' && varpharmaRate!='') {

var medicinecode = $.trim($('#medicinecode').val());
//var package_qty = $('#pharmaqtypk'+sno).val();

//var bal_qty_avai = $("#pharmaqtypkbal"+sno).val();
/*if(parseInt(varquantitypharma) > parseInt(package_qty ))
{
alert('Issue quantity cannot be more than Package quantity');
$("#pharmaqty"+sno).val('');
$("#pharmaqty"+sno).focus();
return false;
}*/
if(medicinecode !='')
{
var bal_qty_avai = $('#pharmaqtypkbal'+medicinecode).val();

if(bal_qty_avai==undefined){
alert('Entered Quantity cannot be more than Balance Quantity');
$(this).val('');
//$("#pharmaqty"+sno).focus();
document.getElementById("amount").value=0;
return false;
}

if(parseInt(varquantitypharma) > parseInt(bal_qty_avai ))
{
alert('Entered Quantity cannot be more than Balance Quantity, Please enter lesser quantity');
$(this).val(0)
//$("#pharmaqty"+sno).focus();
$(this).keyup();
return false;
}

var availableqty = $('#availableqty').val();
if(parseInt(varquantitypharma) > parseInt(availableqty ))
{
alert('Entered Quantity cannot be more than Available Quantity, Please enter lesser quantity');
$(this).val(0)
//$("#pharmaqty"+sno).focus();
$(this).keyup();
return false;
}
var classname = 'tdcaldynqty';

var tot_added_qty = calculate_added_items_qty(classname,medicinecode);
//console.log('added qty'+tot_added_qty);
var current_adding_qty = parseInt(tot_added_qty) + parseInt(varquantitypharma);
if(parseInt(current_adding_qty) > parseInt(bal_qty_avai ))
{
alert('Added Items Quantity is more than Balance Quantity');
$(this).val(0)

$(this).keyup();
return false;
}

}

var totalservi = parseFloat(varquantitypharma) * parseFloat(varpharmaRate);
document.getElementById("amount").value=totalservi.toFixed(2);

/*var classname = 'pharmacalamt';
var id = 'mi_items_subtotal';
calculate_items_total(classname,id);*/

/*var bal_qty = parseInt(package_qty) -  parseInt(varquantitypharma);
$("#pharmaqtypkbal"+sno).val(bal_qty);*/
}

});

$( ".pharmaqty" ).keyup(function() {
//var id = $(this).attr('id');
var sno = $(this).attr('sno');

var varquantitypharma = document.getElementById("pharmaqty"+sno).value;
var varpharmaRate = document.getElementById("pharmarate"+sno).value;
if(varquantitypharma!='' && varpharmaRate!='') {

var package_qty = $('#pharmaqtypk'+sno).val();
console.log(package_qty);
console.log(varquantitypharma);
var bal_qty_avai = $("#pharmaqtypkbal"+sno).val();
/*if(parseInt(varquantitypharma) > parseInt(package_qty ))
{
alert('Issue quantity cannot be more than Package quantity');
$("#pharmaqty"+sno).val('');
$("#pharmaqty"+sno).focus();
return false;
}*/

if(parseInt(varquantitypharma) > parseInt(bal_qty_avai ))
{
alert('Entered Quantity cannot be more than Balance Quantity, Please enter lesser quantity');
$("#pharmaqty"+sno).val(0);
$("#pharmaqty"+sno).focus();
$(this).keyup();
return false;
}
var totalservi = parseFloat(varquantitypharma) * parseFloat(varpharmaRate);
document.getElementById("pharmaamt"+sno).value=totalservi.toFixed(2);

var classname = 'pharmacalamt';
var id = 'mi_items_subtotal';
calculate_items_total(classname,id);

/*var bal_qty = parseInt(package_qty) -  parseInt(varquantitypharma);
$("#pharmaqtypkbal"+sno).val(bal_qty);*/
}

});

if ($('#si_items_subtotal_table > tbody > tr').length == 0){
//$('#si_items_subtotal_table > thead').css('display','none');
$('#si_items_subtotal_table > thead').hide();
$('#si_hide_sub_total').hide();
//$('#si_items_subtotal_table').html('<tr><td align="center">No items found for processing</td></tr>')
}

if ($('#mi_items_subtotal_table > tbody > tr').length == 0){
//$('#mi_items_subtotal_table > thead').css('display','none');
$('#mi_items_subtotal_table > thead').hide();
$('#mi_hide_sub_total').hide();
//$('#mi_items_subtotal_table').html('<tr><td align="center">No items found</td></tr>')
}

if ($('#li_items_subtotal_table > tbody > tr').length == 0){
//$('#li_items_subtotal_table > thead').css('display','none');
$('#li_items_subtotal_table > thead').hide();
$('#li_hide_sub_total').hide();
//$('#li_items_subtotal_table').html('<tr><td align="center">No items found</td></tr>')
}

if ($('#ri_items_subtotal_table > tbody > tr').length == 0){
//$('#ri_items_subtotal_table > thead').css('display','none');
$('#ri_items_subtotal_table > thead').hide();
$('#ri_hide_sub_total').hide();
//$('#ri_items_subtotal_table').html('<tr><td align="center">No items found</td></tr>')

}

});
function isOnlyNumber(evt, element) {

var charCode = (evt.which) ? evt.which : event.keyCode

if ((charCode < 48 || charCode > 57))
return false;

return true;
} 
function calculate_items_total(classname,id){

// Calculate Sub Total for all items
var sum = 0;
$("."+classname).each(function()
{
sum += parseFloat($(this).find("input").val());
});

$('#'+id).val(formatMoney(sum.toFixed(2)));
$('#'+id+'_val').val(sum);
calculate_items_grand_total();
calculate_package_variance();
}

function calculate_items_total1(classname,id,sno){

// Calculate Sub Total for all items
var sum = 0;
// first deduct and the add to subtotal
$('#insertrow4 tr').filter(':has(:checkbox:checked)').find('.serviceamt').each(function() {
// this = td element
console.log($(this).val())
sum += parseFloat($(this).val())
//console.log($(this))
});

/*var sum = 0;
$("."+classname).each(function()
{
sum += parseFloat($(this).find("input.serviceamt").val());
});*/

$('#'+id).val(formatMoney(sum.toFixed(2)));
$('#'+id+'_val').val(sum);
calculate_items_grand_total();
calculate_package_variance();
}
function calculate_items_total_doctor(){
// Calculate Sub Total for all doctor added items
var sum = 0;
$('#insertrow44 tr').find('.adddoctoramt').each(function() {
// this = td element
console.log($(this).val())
sum += parseFloat($(this).val())
//console.log($(this))
});
//console.log(sum)
return sum;
/* $('#'+id).html('');
$('#'+id).html(formatMoney(sum.toFixed(2)));
$('#'+id+'_val').val(sum);*/

}
function calculate_added_items_qty(classname,medicinecode){

// Calculate Total Quantity for dynamically added items for specific Item
console.log('infn'+medicinecode)
console.log('infn'+classname)
var qty = 0;

$("."+medicinecode+classname).each(function()
//$(".PHAR000900tdcaldynqty").each(function()
{	
console.log(' in loop')
console.log($(this).find("input."+medicinecode+"caldynqty").val())
qty += parseInt($(this).find("input."+medicinecode+"caldynqty").val());
});

return qty;
}
function totamt(){

var quantity = $('#quantity').val();
var rate = $('#rate').val();

// get package used amount already
$('#amount').val(quantity*rate);

}
function calculate_items_grand_total(){

// $('#'+id).html(formatMoney(sum.toFixed(2)));
var ct_items_subtotal_val = $('#ct_items_subtotal_val').val();
var si_items_subtotal_val = $('#si_items_subtotal_val').val();
var mi_items_subtotal_val = $('#mi_items_subtotal_val').val();
var li_items_subtotal_val = $('#li_items_subtotal_val').val();
var ri_items_subtotal_val = $('#ri_items_subtotal_val').val();

// get package used amount already
var package_used_amount = $('#package_used_amount_val').val();


var package_grand_total = parseFloat(ct_items_subtotal_val) + parseFloat(si_items_subtotal_val) + parseFloat(mi_items_subtotal_val) + parseFloat(li_items_subtotal_val) + parseFloat(ri_items_subtotal_val) + parseFloat(package_used_amount);

//var package_grand_total = parseFloat(si_items_subtotal_val) + parseFloat(mi_items_subtotal_val) + parseFloat(li_items_subtotal_val) + parseFloat(ri_items_subtotal_val) + parseFloat(package_used_amount);
$('#package_grand_total').val(formatMoney(package_grand_total.toFixed(2)));// Grand total for all items category
$('#package_grand_total_val').val(package_grand_total);

}

function calculate_package_variance()
{
var package_amt            =  $('#packageamtval').val();
var package_grandtotal_amt =  $('#package_grand_total_val').val();
var package_variance_amt   =  parseFloat(package_amt) - parseFloat(package_grandtotal_amt);
$('#package_variance_amt').val(formatMoney(package_variance_amt.toFixed(2)));
$('#package_variance_amt_val').val(formatMoney(package_variance_amt.toFixed(2)));
}
function clearcode(id)
{
document.getElementById(id).value='';
}



function funcamountcalc()

{


console.log('hi')
var units = 1;

var rate = document.getElementById("rate4").value;

docfee = 0;



var amount = units * rate;



var totalamount = parseFloat(docfee) + parseFloat(amount);



document.getElementById("amount4").value = totalamount.toFixed(2);





}
function btnDeleteClick4(delID4)

{

//alert ("Inside btnDeleteClick.");

var newtotal;



var varDeleteID4= delID4;



var fRet7; 

fRet7 = confirm('Are You Sure Want To Delete This Entry?'); 



if (fRet7 == false)

{

//alert ("Item Entry Not Deleted.");

return false;

}



var child4 = document.getElementById('idTR'+varDeleteID4);  

//alert (child3);//tr name

var parent4 = document.getElementById('insertrow44'); // tbody name.

document.getElementById ('insertrow44').removeChild(child4);



//var child4= document.getElementById('idTRaddtxt'+varDeleteID4);  //tr name

var parent4 = document.getElementById('insertrow44'); // tbody name.


var total_added_amt = calculate_items_total_doctor();


$('#ct_items_subtotal').val(formatMoney(total_added_amt));
$('#ct_items_subtotal_val').val(total_added_amt);

calculate_items_grand_total();
calculate_package_variance();




}

</script>


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
//document.getElementById("rate").value=varNewLineValue[1];

}


}
}
xmlhttp.open("GET","ajaxstock1.php?q="+str+"&&loc="+loc+"&&sto="+stor+"&&strm="+strm+"&&fifo_code="+val+"&&subtypeano="+subtypeano,true);
xmlhttp.send();
}




function funcDeleteVoucher(sno,id)
{
var sno = sno;
var id = id;
if(confirm("Are you sure to delete this Entry ?")){	
	
	var action="deleteippackcondoct";	
	var dataString = 'id='+id+'&&action='+action;
	if(sno!=''){		
		$.ajax({
		
			type:"get",
			url:"ippackage_consultationdoctordelete.php",
			data:dataString,
			cache: true,
			success: function(html){	
			$('#idTR'+sno).hide();				
			}			
			});		
		}
	}
	else 
	return false;
}
</script>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
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
?>
<?php
//aaa
if(isset($_REQUEST['storecode'])){ $defaultstore = $_REQUEST['storecode']; } else { $defaultstore = ''; }
if($defaultstore == '')
{
$query231 = "select * from master_employeelocation where username='$username' and locationcode='".$searchlocation."' and defaultstore = 'default' order by locationname";
}
else
{
$query231 = "select * from master_employeelocation where username='$username' and locationcode='".$searchlocation."' and storecode = '$defaultstore' order by locationname";
}
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

?>
<form name="form1" id="frmsales" method="post" action="ippackageprocessing.php" onSubmit="return validcheck()" >
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
<tr bgcolor="#011E6A">
<td colspan="7" bgcolor="#ecf0f5" class="bodytext32"><strong>Patient Details</strong></td>
</tr>
<tr>
<td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
</tr>
<?php $packageid = $_REQUEST['packageid'];
$qrypackage = "select packagename,rate,days,consultation_amt from $ippactemplate where auto_number = '$packageid'";
$execpackage = mysqli_query($GLOBALS["___mysqli_ston"], $qrypackage);
$respackage = mysqli_fetch_array($execpackage);
$packagename = $respackage['packagename'];
$package_amt = $respackage['rate'];
$package_days = $respackage['days'];

$package_type = 'CT';
//$qrypackage1 = "select itemcode,itemname,rate from package_items  where package_id=$packageid and package_type='$package_type'";
$qrypackage1 = "select id,itemcode,itemname,rate from package_processing  where package_id=$packageid and package_item_type='$package_type' and patientcode='$patientcode' and visitcode='$visitcode'";
$execpackage1 = mysqli_query($GLOBALS["___mysqli_ston"], $qrypackage1);
$respackage1 = mysqli_fetch_array($execpackage1);
$package_consulation_amt = $respackage1['rate'];
$doctor_code =  $respackage1['itemcode'];
$doctor_name = $respackage1['itemname'];
$consul_rowid = $respackage1['id'];

$ct_items_subtotal = $package_consulation_amt;
?>
<tr>
<td width="17%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> <strong>Patient Name</strong>  </span></td>
<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
<input name="customername" id="customername" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="18" type="hidden"><?php echo $patientname; ?>
<input type="hidden" name="nameofrelative" id="nameofrelative" value="<?php echo $nameofrelative; ?>" style="border: 1px solid #001E6A;" size="45">
<input type="hidden" name="locationcode" id="locationcode" value="<?php echo $locationcode; ?>">
<input type="hidden" name="locationnameget" id="locationnameget" value="<?php echo $location3;?>">

</td>
<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
<strong>Patientcode</strong></td>
<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
<input name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="18" type="hidden"><?php echo $patientcode; ?></td>
</tr>       

<tr>
<td width="17%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visitcode</strong></td>
<td align="left" valign="middle" class="bodytext3">
<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" />	<?php echo $visitcode; ?></td>			
<td width="17%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>
<td align="left" valign="top" class="bodytext3">
<input type="hidden" name="account" id="account" value="<?php echo $patientaccount1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" />		
<input type="hidden" name="billtypes" id="billtypes" value="<?php echo $billtype; ?>" />
<input type="hidden" name="payment" id="payment" value="<?php echo $patienttype1; ?>">
<input type="hidden" name="subtype" id="subtype"  value="<?php echo $res131subtype; ?>" >                  
<input type="hidden" name="subtypeano" id="subtypeano"  value="<?php echo $patientsubtype; ?>" >                  
<?php echo $patientaccount1; ?>	</td>	
</tr>
<tr>
<td align="left" valign="middle" class="bodytext3"><strong> Date</strong></td>
<td class="bodytext3"><input type="hidden" name="billdate" id="billdate" value="<?php echo $dateonly; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
<?php echo $dateonly; ?>				</td>	
<td align="left" valign="middle" class="bodytext3"><strong>Doc No</strong></td>
<td class="bodytext3"><input type="hidden" name="billno" id="billno" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
<?php echo $billnumbercode; ?></td>
</tr>
<tr>
<td align="left" valign="middle" class="bodytext3"><strong>Location</strong></td>
<td class="bodytext3"><input type="hidden" name="location" id="location" value="<?php echo $locationcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
<?php echo $locationname; ?></td>
<td align="left" valign="middle" class="bodytext3"><strong>Package</strong></td>
<td class="bodytext3"><input type="hidden" name="packcharge" id="packcharge" value="<?php echo $packcharge; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
<?php if($packcharge == 1) { echo 'Yes'; } else { echo 'No'; } ?></td>
</tr>

<tr>
<td align="left" valign="middle" class="bodytext3"><strong>Package Name</strong></td>
<td class="bodytext3">	
<?php echo $packagename; ?></td>
<td align="left" valign="middle" class="bodytext3"><strong>Package Amount</strong></td>
<td class="bodytext3"><strong>
<?php echo  number_format($package_amt,'2','.',','); ?></strong><input type="hidden" name="packageamtval" id="packageamtval" value="<?php echo $package_amt; ?>"></td>
</tr>	
<tr>
<td align="left" valign="middle" class="bodytext3"><strong>Validity Days</strong></td>
<td class="bodytext3">	
<?php echo $package_days; ?></td>

</tr>			


<tr>
<td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
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
<tr>
<td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><strong>Consultation  </strong></span></td>
</tr>
<?php 
$consultation_used_amt = 0;
$show_cons_chkbox = 1;
$package_type = 'CT';

$issqry1 = "select pp.amount from package_processing pp inner join package_execution pe on pp.id=pe.processing_id where pp.package_id = '$packageid' and pp.patientcode ='$patientcode' and pp.visitcode='$visitcode' and package_item_type ='$package_type'";


$execiss1 = mysqli_query($GLOBALS["___mysqli_ston"], $issqry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$con_num_rows = mysqli_num_rows($execiss1);
if($con_num_rows)
{
$resiss1 = mysqli_fetch_array($execiss1);

$used_amount =  $resiss1['amount'];
$consultation_used_amt = $used_amount;
$show_cons_chkbox = 0;
}
?>

<tr><td></td></tr>
<tr>

<td align="left" valign="middle" class="bodytext3">Amount</td>
<td class="bodytext3">	
<?php echo number_format($package_consulation_amt,'2','.',','); ?></td>
<input type="hidden" name="pkg_tot_cons_amt" id="pkg_tot_cons_amt" value="<?=$package_consulation_amt?>">

</tr>
<tr><td>&nbsp;</td></tr>	
<tr>
<?php if($show_cons_chkbox) { ?>
<!-- <td><input type="checkbox"  class="selectconsult" name="selectconsult[]" id="selectconsult" value="">


</td> -->
<?php } ?>
<input name="selectconrowid" type="hidden" id="selectconrowid" size="30" value="<?=$consul_rowid?>">
<!-- <td align="left" valign="middle"  class="bodytext3" bgcolor="#ecf0f5">Doctor</td>
<td align="left" valign="middle"  bgcolor="#ecf0f5">
<input name="serdoct" type="text" id="serdoct" size="30" value="<?=$doctor_name?>">



</td> -->
<input name="serdoctcode" type="hidden" id="serdoctcode" size="30" value="<?=$doctor_code?>">
</tr>		



<tr id="reffid">

<td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

<table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">

<tr>

<td width="30" class="bodytext3"><strong>Doctor</strong></td>

<!--<td class="bodytext3">Visit  Fee</td>-->

<td class="bodytext3"><strong>Fee</strong></td>

<td class="bodytext3"><strong>Description</strong></td>

<td class="bodytext3"><strong>Amount</strong></td>

</tr>



<tr>

<div id="insertrow44"></div></tr>

<tr>

<input type="hidden" name="serialnumberdoc" id="serialnumberdoc" value="1">

<input type="hidden" name="referalcode[]" id="referalcode" value="">

<td width="30"><input name="referal[]" type="text" id="referal" size="40"></td>



<input name="units[]" type="hidden" id="units" size="8" value="1">

<td width="30"><input name="rate4[]" type="text" id="rate4" size="8" onKeyUp="return funcamountcalc()" ></td>

<td width="30"><input name="description[]" type="text" id="description" size="30" onKeyUp="clearcode('descriptioncode')">

<input type="hidden" name="subtypenum" id="subtypenum" value="<?php echo $subtype;?>">

<input type="hidden" name="descriptioncode[]" id="descriptioncode" value=""></td>

<td width="30"><input name="amount4[]" type="text" id="amount4" readonly size="8"></td>

<td><label>

<input type="button" name="Add4" id="Add4" value="Add" onClick="return insertitem5()" class="button" style="border: 1px solid #001E6A">

</label></td>

</tr>

</table></td>

</tr>


<!-- Multi Doctor Code start -->


<tr><td class="bodytext3"><strong>Processed List</strong></td></tr>
<tr>

<td>
<table class="bodytext3" width="400px" style="margin-left: 38px;">
<?php $package_type = 'DC';
$qrylab = "select id,itemcode,itemname,rate,amount from package_processing where package_id = '$packageid' and package_item_type ='$package_type' and patientcode='$patientcode' and visitcode='$visitcode' and recordstatus = 'completed' ";
$doctor_used_amt = 0;
$execlab = mysqli_query($GLOBALS["___mysqli_ston"], $qrylab) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($reslab = mysqli_fetch_array($execlab))
{
$itemcode = $reslab['itemcode'];
$itemname = $reslab['itemname'];
$itemrate = $reslab['rate'];
$rowid     = $reslab['id'];

$sno = $sno + 1;

$issqry = "select id from package_execution where processing_id='$rowid'";
$execiss = mysqli_query($GLOBALS["___mysqli_ston"], $issqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$iss_num_rows = mysqli_num_rows($execiss);
if($iss_num_rows)
{

$execiss1 = mysqli_query($GLOBALS["___mysqli_ston"], $issqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$issqry1 = "select pp.amount from package_execution pe inner join package_processing pp on pe.processing_id = pp.id where pe.processing_id='$rowid'";

$execiss1 = mysqli_query($GLOBALS["___mysqli_ston"], $issqry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$resiss1 = mysqli_fetch_array($execiss1);

$used_amount =  $resiss1['amount'];
$doctor_used_amt = $doctor_used_amt + $used_amount;
}
else
{
$issuedqty = 0;

}

?>
<tr id="idTR<?php echo $sno; ?>">
<td class="bodytext3"><?=$itemname?></td>
<td  class="bodytext3" align="right" ><?=number_format($itemrate,'2','.',',');?></td>
<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"> <a href="#"  onClick="return funcDeleteVoucher('<?php echo $sno; ?>','<?php echo $rowid; ?>')"><img src="images/b_drop.png" width="16" height="16" border="0" /></a>
</tr>
<?php

}

?>

</table>
<input type="hidden" id="doctor_used_amt" value="<?=$doctor_used_amt; ?>">
</td>
</tr>

<!-- Multi Doctor Code end -->

<tr>
<?php if($show_cons_chkbox) { ?>
<td id="ct_hide_sub_total" colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Subtotal</strong><input type="text" id="ct_items_subtotal" readonly class="subtotals" value="<?=number_format($consultation_used_amt,'2','.',',');?>" size="10">
</td>
<?php } ?>
<input type="hidden" name="ct_items_subtotal_val" id="ct_items_subtotal_val" value="0">
<input type="hidden" name="consultation_amt" id="consultation_amt" value="<?=$ct_items_subtotal?>">
</tr> 	 
<tr><td></td></tr>







<tr>
<td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><strong>Lab  </strong></span></td>
</tr>

<!--Lab-->
<tr><td></td></tr>
<tr>
<td colspan="8" id="labArea" >
<table width="700" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber4" style="border-collapse: collapse">
<tr id="pressid3">
<td colspan="15" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
<table id="presid3" width="650" border="0" cellspacing="1" cellpadding="1">
<tr>
<td colspan="3" >
<table class="bodytext3" id="li_items_subtotal_table" width="83%"> 
<thead>
<tr>
<td align="right" ><strong></strong></td>
<td align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<strong>Laboratory Item</strong>
</td><td align="right" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<strong>Rate</strong>
</td>
</tr>
</thead>
<tbody id="insertrow2">
<?php
$sno = 0;
$li_items_subtotal = 0;
$j=1;
$package_type = 'LI';
$qrylab = "select id,itemcode,itemname,rate,amount from package_processing where package_id = '$packageid' and package_item_type ='$package_type' and patientcode='$patientcode' and visitcode='$visitcode' and recordstatus <> 'completed' ";

$execlab = mysqli_query($GLOBALS["___mysqli_ston"], $qrylab) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($reslab = mysqli_fetch_array($execlab))
{
$itemcode = $reslab['itemcode'];
$itemname = $reslab['itemname'];
// $itemrate = $reslab['rate'];
$queryl51 = "select rateperunit from `$labtable` where itemcode='$itemcode'";
$execl51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryl51) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$resl51 = mysqli_fetch_array($execl51);
$itemrate = $resl51['rateperunit'];

$rowid     = $reslab['id'];
$li_items_subtotal =  $li_items_subtotal + $itemrate;
$sno = $sno + 1;
?>
<tr id="idlabTR<?=$j?>">
<td><input type="checkbox" sno="<?=$j?>" class="selectlab" name="selectlab[]" id="selectlab<?=$j?>" value="<?php echo $itemcode.$rowid; ?>"></td>
<input type="hidden" name="selectlabcode[]" value="<?php echo $itemcode.$rowid; ?>">
<input type="hidden" name="labname[]" value="<?php echo $itemname; ?>">
<input type="hidden" name="labcode[]" value="<?php echo $itemcode; ?>">
<input type="hidden" name="labrate[]" value="<?php echo $itemrate; ?>">
<input type="hidden" name="labrowid[]" value="<?php echo $rowid; ?>">
<td id="serialnumberl<?=$j?>" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<input id="serialnumberl<?=$j?>" name="serialnumberl<?=$j?>" type="hidden" size="25" value="<?=$j?>" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;">
<input id="labcode<?=$j?>" name="labcode<?=$j?>" type="hidden" align="left" size="25" value="<?=$itemcode?>" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;">
<!-- </td>
<td style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">-->
<input id="labname<?=$j?>" name="labname<?=$j?>" type="text" align="left" value="<?=$itemname?>" size="25" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;"></td>
<td id="tdlabrate<?=$j?>" class="labcalrate" align="right" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<input id="labrate<?=$j?>"  name="labrate<?=$j?>" type="text" size="16" readonly="" value="<?=$itemrate?>" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: right;"></td>
</tr>
<?php
$j++;
}
?>
</tbody>
</table>
</td>
</tr>
<input type="hidden" name="serialnumberl" id="serialnumberl" value="<?=$j?>">
</table>				  
</td>
</tr> 

<!-- lab additon items -->
<tr><td class="bodytext3"><strong>Additon Package Lab</strong></td></tr>
<tr>
<td>
<table class="bodytext3" width="640px" style="margin-left: 38px;">
<?php 
$package_type = 'LI';
$qrylab1 = "select id,itemcode,itemname,rate,amount,quantity,recordstatus from addpkgitems where  package_item_type ='$package_type' and patientcode='$patientcode' and visitcode='$visitcode'  ";
$execlab1 = mysqli_query($GLOBALS["___mysqli_ston"], $qrylab1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($reslab1 = mysqli_fetch_array($execlab1))
{
$itemcode = $reslab1['itemcode'];
$itemname = $reslab1['itemname'];
$quantity = $reslab1['quantity'];
$rate = $reslab1['rate'];
$amount = $reslab1['amount'];
$recordstatus = $reslab1['recordstatus'];
if($recordstatus==''){ $recordstatus='APPROVAL PENDING';  }
if($recordstatus=='completed'){ $recordstatus='APPROVED';  }

?>
<tr bgcolor="#7CCFDF">
<td width="290px" class="bodytext3"><?=$itemname?></td>
<td  width="200px"class="bodytext3" align="right" ><?=number_format($rate,'2','.',',');?></td>
<!--<td  class="bodytext3" align="right" ><?//=number_format($quantity,'2','.',',');?></td>
<td  class="bodytext3" align="right" ><?//=number_format($rate,'2','.',',');?></td>
<td  class="bodytext3" align="right" ><?//=number_format($amount,'2','.',',');?></td>-->
<td  class="bodytext3" align="center" ><?php  echo $recordstatus; ?></td>
</tr>
<?php
}
?>
</table>
</td>
</tr>	

<!-- END lab additon items -->


<tr><td class="bodytext3"><strong>Processed List</strong></td></tr>
<tr>
<td>
<table class="bodytext3" width="400px" style="margin-left: 38px;">
<?php 
$package_type = 'LI';
$qrylab = "select id,itemcode,itemname,rate,amount from package_processing where package_id = '$packageid' and package_item_type ='$package_type' and patientcode='$patientcode' and visitcode='$visitcode' and recordstatus = 'completed' and add_pkg_trackid='0' ";
$lab_used_amt = 0;
$execlab = mysqli_query($GLOBALS["___mysqli_ston"], $qrylab) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($reslab = mysqli_fetch_array($execlab))
{
$itemcode = $reslab['itemcode'];
$itemname = $reslab['itemname'];
//$itemrate = $reslab['rate'];
$queryl51 = "select rateperunit from `$labtable` where itemcode='$itemcode'";
$execl51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryl51) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$resl51 = mysqli_fetch_array($execl51);
$itemrate = $resl51['rateperunit'];

$rowid     = $reslab['id'];
$li_items_subtotal =  $li_items_subtotal + $itemrate;
$sno = $sno + 1;

$issqry = "select id from package_execution where processing_id='$rowid'";
$execiss = mysqli_query($GLOBALS["___mysqli_ston"], $issqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$iss_num_rows = mysqli_num_rows($execiss);
if($iss_num_rows)
{

$execiss1 = mysqli_query($GLOBALS["___mysqli_ston"], $issqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$issqry1 = "select pp.amount from package_execution pe inner join package_processing pp on pe.processing_id = pp.id where pe.processing_id='$rowid'";

$execiss1 = mysqli_query($GLOBALS["___mysqli_ston"], $issqry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$resiss1 = mysqli_fetch_array($execiss1);
/*$issuedqty = $resiss1['issuedqty'];
$used_amount = $issuedqty * $itemrate;*/
$used_amount =  $itemrate;
$lab_used_amt = $lab_used_amt + $used_amount;
}
else
{
$issuedqty = 0;
}
?>
<tr>
<td class="bodytext3"><?=$itemname?></td>
<td  class="bodytext3" align="right" ><?=number_format($itemrate,'2','.',',');?></td>
</tr>
<?php
}
?>
</table>
</td>
</tr>							   
</table>
</td>
</tr>
<tr>
<td id="li_hide_sub_total" colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Subtotal</strong><input type="text" id="li_items_subtotal" readonly class="subtotals" value="0.00" size="10"><input type="hidden" id="li_items_subtotal_val" value="0"></td>
</tr> 

<tr>
<td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><strong>Radiology  </strong></span></td>
</tr>
<tr><td></td></tr>
<tr><td colspan="3" >

<table class="bodytext3" id="ri_items_subtotal_table" width="66%"> 
<thead>
<td align="right" ><strong></strong></td>
<td align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<strong>Radiology Item</strong>
</th><td align="right" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<strong>Rate</strong>
</td>

</thead>

<tbody id="insertrow3">
<?php
$ri_items_subtotal = 0;
$k=1;
$package_type = 'RI';
$qrylab = "select id,itemcode,itemname,rate,amount from package_processing where package_id = '$packageid' and package_item_type ='$package_type' and patientcode='$patientcode' and visitcode='$visitcode' and recordstatus <> 'completed' ";

$execlab = mysqli_query($GLOBALS["___mysqli_ston"], $qrylab) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($reslab = mysqli_fetch_array($execlab))
{
$itemcode = $reslab['itemcode'];
$itemname = $reslab['itemname'];
//$itemins = $reslab['instructions'];
//$itemrate = $reslab['rate'];
$queryr51 = "select rateperunit from `$radtable` where itemcode='$itemcode'";
$execr51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr51) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$resr51 = mysqli_fetch_array($execr51);
$itemrate = $resr51['rateperunit'];

$rowid = $reslab['id'];
$ri_items_subtotal =  $ri_items_subtotal + $itemrate;
?>
<tr id="idradTR<?=$k?>">
<td><input type="checkbox" sno="<?=$k?>" class="selectrad" name="selectrad[]" id="selectrad<?=$k?>" value="<?php echo $itemcode.$rowid; ?>"></td>

<input type="hidden" name="selectradcode[]" value="<?php echo $itemcode.$rowid; ?>">
<input type="hidden" name="radname[]" value="<?php echo $itemname; ?>">
<input type="hidden" name="radcode[]" value="<?php echo $itemcode; ?>">
<input type="hidden" name="radrate[]" value="<?php echo $itemrate; ?>">
<input type="hidden" name="radrowid[]" value="<?php echo $rowid; ?>">
<td id="tdserialnumberr<?=$k?>" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<input id="serialnumberr<?=$k?>" name="serialnumberr<?=$k?>" type="hidden" size="25" value="<?=$k?>" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;">
<input id="radcode<?=$k?>" name="radcode<?=$k?>" type="hidden" align="left" size="25" value="<?=$itemcode?>" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;">
<!-- </td>
<td style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">-->
<input id="radname<?=$k?>" name="radname<?=$k?>" type="text" align="left" value="<?=$itemname?>" size="35" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;">
</td>


<td id="tdradrate<?=$k?>" class="radcalrate" align="right" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<input id="radrate<?=$k?>"  name="radrate<?=$k?>" type="text" size="16" readonly="" value="<?=$itemrate?>" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: right;">
</td>
</tr>
<?php
$k++;
}
?>
</tbody>
</table></td></tr>
<input type="hidden" name="serialnumberr" id="serialnumberr" value="<?=$k?>">
</table>				  
</td>
</tr> 

<!-- Rad additon items -->
<tr><td class="bodytext3"><strong>Additon Package Radiology</strong></td></tr>
<tr>
<td>
<table class="bodytext3" width="755px" style="margin-left: 38px;">
<?php 
$package_type = 'RI';
$qryrad1 = "select id,itemcode,itemname,rate,amount,quantity,recordstatus from addpkgitems where  package_item_type ='$package_type' and patientcode='$patientcode' and visitcode='$visitcode'  ";
$execrad1 = mysqli_query($GLOBALS["___mysqli_ston"], $qryrad1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($resrad1 = mysqli_fetch_array($execrad1))
{
$itemcode = $resrad1['itemcode'];
$itemname = $resrad1['itemname'];
$quantity = $resrad1['quantity'];
$rate = $resrad1['rate'];
$amount = $resrad1['amount'];
$recordstatus = $resrad1['recordstatus'];
if($recordstatus==''){ $recordstatus='APPROVAL PENDING';  }
if($recordstatus=='completed'){ $recordstatus='APPROVED';  }

?>
<tr bgcolor="#7CCFDF">
<td width="392px" class="bodytext3"><?=$itemname?></td>
<td width="204px" class="bodytext3" align="right" ><?=number_format($rate,'2','.',',');?></td>
<!--<td  class="bodytext3" align="right" ><?//=number_format($quantity,'2','.',',');?></td>
<td  class="bodytext3" align="right" ><?//=number_format($rate,'2','.',',');?></td>
<td  class="bodytext3" align="right" ><?//=number_format($amount,'2','.',',');?></td>-->
<td  class="bodytext3" align="center" ><?php  echo $recordstatus; ?></td>
</tr>
<?php
}
?>
</table>
</td>
</tr>	

<!-- END rad additon items -->




<tr><td class="bodytext3"><strong>Processed List</strong></td></tr>
<tr>

<td>
<table class="bodytext3" width="400px" style="margin-left: 38px;">
<?php $package_type = 'RI';
$qrylab = "select id,itemcode,itemname,rate,amount from package_processing where package_id = '$packageid' and package_item_type ='$package_type' and patientcode='$patientcode' and visitcode='$visitcode' and recordstatus = 'completed' and add_pkg_trackid='0' ";
$rad_used_amt = 0;
$execlab = mysqli_query($GLOBALS["___mysqli_ston"], $qrylab) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($reslab = mysqli_fetch_array($execlab))
{
$itemcode = $reslab['itemcode'];
$itemname = $reslab['itemname'];
// $itemrate = $reslab['rate'];
$queryr51 = "select rateperunit from `$radtable` where itemcode='$itemcode'";
$execr51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr51) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$resr51 = mysqli_fetch_array($execr51);
$itemrate = $resr51['rateperunit'];

$rowid     = $reslab['id'];
$li_items_subtotal =  $li_items_subtotal + $itemrate;
$sno = $sno + 1;

$issqry = "select id from package_execution where processing_id='$rowid'";
$execiss = mysqli_query($GLOBALS["___mysqli_ston"], $issqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$iss_num_rows = mysqli_num_rows($execiss);
if($iss_num_rows)
{

$execiss1 = mysqli_query($GLOBALS["___mysqli_ston"], $issqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$issqry1 = "select pp.amount from package_execution pe inner join package_processing pp on pe.processing_id = pp.id where pe.processing_id='$rowid'";

$execiss1 = mysqli_query($GLOBALS["___mysqli_ston"], $issqry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$resiss1 = mysqli_fetch_array($execiss1);
/*$issuedqty = $resiss1['issuedqty'];
$used_amount = $issuedqty * $itemrate;*/
$used_amount =  $itemrate;


$rad_used_amt = $rad_used_amt + $used_amount;
}
else
{
$issuedqty = 0;

}
?>
<tr>


<td class="bodytext3">
<?=$itemname?>


<!-- </td>
<td style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">-->

</td>
<td  class="bodytext3" align="right" >

<?=number_format($itemrate,'2','.',',');?>

</td>
</tr>
<?php

}
?>

</table>

</td>
</tr>
<tr>
<td id="ri_hide_sub_total" colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Subtotal</strong><input type="text" id="ri_items_subtotal" readonly class="subtotals" value="0.00" size="10"><input type="hidden" id="ri_items_subtotal_val" value="0"></td>
</tr>
<tr>
<td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><strong>Services  </strong></span></td>
</tr>

<tr><td>&nbsp;</td></tr>
<tr><td colspan="5">

<table class="bodytext3" id="si_items_subtotal_table">
<thead><tr>
<td align="right" ><strong></strong></td>
<td align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<strong>Service Item</strong>
</td>
<td align="middle" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<strong>Package.Qty</strong>
</td>
<!--  <td align="middle" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<strong>Issued.Qty</strong>
</td> -->
<td align="middle" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<strong>Bal.Qty</strong>
</td>
<td align="middle" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<strong>Issue.Qty</strong>
</td>
<td align="right" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<strong>Rate</strong>
</td>
<td align="right" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<strong>Amount</strong>
</td>
</tr>
</thead>
<tbody id="insertrow4">

<?php
$si_items_subtotal = 0;
$i=1;
$package_type = 'SI';
$qrylab = "select id,itemcode,itemname,quantity,rate,amount from package_processing where package_id = '$packageid' and package_item_type ='$package_type' and patientcode='$patientcode' and visitcode='$visitcode' and recordstatus <> 'completed' ";

$execlab = mysqli_query($GLOBALS["___mysqli_ston"], $qrylab) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($reslab = mysqli_fetch_array($execlab))
{
$itemcode = $reslab['itemcode'];
$itemname = $reslab['itemname'];
//$itemrate = $reslab['rate'];
$querys51 = "select rateperunit from `$sertable` where itemcode='$itemcode'";
$execs51 = mysqli_query($GLOBALS["___mysqli_ston"], $querys51) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$ress51 = mysqli_fetch_array($execs51);
$itemrate = $ress51['rateperunit'];

$rowid = $reslab['id'];
$pack_qty = $reslab['quantity'];
// Get issued qty

$issqry = "select id from package_execution where processing_id='$rowid'";
$execiss = mysqli_query($GLOBALS["___mysqli_ston"], $issqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$iss_num_rows = mysqli_num_rows($execiss);
if($iss_num_rows)
{

$execiss1 = mysqli_query($GLOBALS["___mysqli_ston"], $issqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$issqry1 = "select sum(qty) issuedqty from package_execution where processing_id='$rowid'";
$execiss1 = mysqli_query($GLOBALS["___mysqli_ston"], $issqry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$resiss1 = mysqli_fetch_array($execiss1);
$issuedqty = $resiss1['issuedqty'];
}
else
{
$issuedqty = 0;
}


$balqty = $pack_qty  - $issuedqty;
$totamount = $balqty * $itemrate;
//$totamount = number_format($totamount,2);
$totamount = number_format($totamount,'2','.','');
$si_items_subtotal =  $si_items_subtotal + ($pack_qty*$itemrate);
?>
<tr id="idserTR<?=$i?>">
<td class="serchk"><input type="checkbox" sno="<?=$i?>" class="selectservice" name="selectservice[]" id="selectservice<?=$i?>" value="<?php echo $itemcode.$rowid; ?>"></td>
<input type="hidden" name="selectservicecode[]" value="<?php echo $itemcode.$rowid; ?>">
<input type="hidden" name="servicename[]" value="<?php echo $itemname; ?>">
<input type="hidden" name="servicecode[]" value="<?php echo $itemcode; ?>">
<input type="hidden" name="servicerate[]" value="<?php echo $itemrate; ?>">


<input type="hidden" name="servicerowid[]" value="<?php echo $rowid; ?>">


<td id="tdserialnumber<?=$i?>" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<!--  <input id="serialnumber<?=$i?>" name="serialnumber<?=$i?>" type="hidden" size="25" value="<?=$i?>" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;"> -->
<input id="sercode<?=$i?>" name="sercode<?=$i?>" type="hidden" align="left" size="25" value="<?=$itemcode?>" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;">
<!-- </td>
<td style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">-->
<input id="sername<?=$i?>" name="sername<?=$i?>" type="text" align="left" value="<?=$itemname?>" size="45" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;font-size:15px;">
</td>

<td id="tdserqtypk<?=$i?>" align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<input id="serqtypk<?=$i?>" sno="<?=$i?>" name="serqtypk[]" type="text" size="5" value="<?=$reslab['quantity']?>"  style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: center;" class="onlynumber" readonly>
</td>
<!--   <td id="tdserqtyiss<?=$i?>" align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<input id="serqtyiss<?=$i?>" sno="<?=$i?>" name="serqtyiss[]" type="text" size="16" value="<?=$issuedqty?>"  style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: center;" class="onlynumber serviceqty" readonly>
</td> -->
<td id="tdserqtypkbal<?=$i?>" align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<input id="serqtypkbal<?=$i?>" sno="<?=$i?>" name="serqtypkbal[]" type="text" size="5" value="<?=$balqty?>"  readonly style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: center;" class="onlynumber">
</td>
<td id="tdserqty<?=$i?>" align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<input id="serqty<?=$i?>" sno="<?=$i?>" name="serqty[]" type="text" size="5"  style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: center;" class="onlynumber serviceqty" value="<?=$balqty?>" readonly>
</td>

<td id="tdserrate<?=$i?>" align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<input id="serrate<?=$i?>" name="serrate<?=$i?>" type="text" size="8" readonly="" value="<?=$itemrate?>" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: right;">
</td>
<td id="tdseramt<?=$i?>" class="sercalamt" align="right" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<input id="seramt<?=$i?>"  class="serviceamt" name="seramt[]" type="text" size="8" readonly="" value="<?=$totamount?>" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: right;">
</td>

</tr>
<?php
$i++;
}
?>
</tbody>
</table></td></tr>
<input type="hidden" name="serialnumbers" id="serialnumbers" value="<?=$i?>">
<input type="hidden" name="h" id="h" value="0">
<input type="hidden" name="ledgercode[]" id="ledgercode" value="">
<input type="hidden" name="ledgername[]" id="ledgername" value="">

<!-- Ser additon items -->
<tr><td class="bodytext3"><strong>Additon Package Service</strong></td></tr>
<tr>
<td>
<table class="bodytext3" width="950px" style="margin-left: 38px;">
<?php 
$package_type = 'SI';
$qryser1 = "select id,itemcode,itemname,rate,amount,quantity,recordstatus from addpkgitems where  package_item_type ='$package_type' and patientcode='$patientcode' and visitcode='$visitcode'  ";
$execser1 = mysqli_query($GLOBALS["___mysqli_ston"], $qryser1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($resser1 = mysqli_fetch_array($execser1))
{
$itemcode = $resser1['itemcode'];
$itemname = $resser1['itemname'];
$quantity = $resser1['quantity'];
$rate = $resser1['rate'];
$amount = $resser1['amount'];
$recordstatus = $resser1['recordstatus'];
if($recordstatus==''){ $recordstatus='APPROVAL PENDING'; $issuedqty=0; }
if($recordstatus=='completed'){ $recordstatus='APPROVED'; $issuedqty=1; }

?>
<tr bgcolor="#7CCFDF">
<td width="340px" class="bodytext3"><?=$itemname?></td>								
<td width="85px" class="bodytext3" align="center" ><?=$quantity;?></td>
<td width="65px" class="bodytext3" align="center" ><?=$quantity;?></td>
<td width="65px" class="bodytext3" align="center" ><?=$issuedqty;?></td>
<td width="82px class="bodytext3" align="right" ><?=number_format($rate,'2','.',',');?></td>
<td width="84px" class="bodytext3" align="center" ><?=number_format($amount,'2','.',',');?></td>
<td  width="145px" class="bodytext3" align="center" ><?php  echo $recordstatus; ?></td>
</tr>
<?php
}
?>
</table>
</td>
</tr>	

<!-- END Ser additon items -->	



<tr><td class="bodytext3"><strong>Processed List</strong></td></tr>
<tr>

<td>
<table class="bodytext3" width="400px" style="margin-left: 38px;">
<?php $package_type = 'SI';
$qrylab = "select id,itemcode,itemname,rate,amount from package_processing where package_id = '$packageid' and package_item_type ='$package_type' and patientcode='$patientcode' and visitcode='$visitcode' and add_pkg_trackid='0' and recordstatus <> '' ";
$services_used_amt = 0;
$execlab = mysqli_query($GLOBALS["___mysqli_ston"], $qrylab) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($reslab = mysqli_fetch_array($execlab))
{
$itemcode = $reslab['itemcode'];
$itemname = $reslab['itemname'];
//$itemrate = $reslab['rate'];

$querys51 = "select rateperunit from `$sertable` where itemcode='$itemcode'";
$execs51 = mysqli_query($GLOBALS["___mysqli_ston"], $querys51) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$ress51 = mysqli_fetch_array($execs51);
$itemrate = $ress51['rateperunit'];

$rowid     = $reslab['id'];
$li_items_subtotal =  $li_items_subtotal + $itemrate;
$sno = $sno + 1;

$issqry = "select id from package_execution where processing_id='$rowid'";
$execiss = mysqli_query($GLOBALS["___mysqli_ston"], $issqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$iss_num_rows = mysqli_num_rows($execiss);
if($iss_num_rows)
{

$execiss1 = mysqli_query($GLOBALS["___mysqli_ston"], $issqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$issqry1 = "select sum(qty) issuedqty from package_execution where processing_id='$rowid'";
$execiss1 = mysqli_query($GLOBALS["___mysqli_ston"], $issqry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$resiss1 = mysqli_fetch_array($execiss1);
$issuedqty = $resiss1['issuedqty'];
$used_amount = $issuedqty * $itemrate;
$services_used_amt = $services_used_amt + $used_amount;
}
else
{
$issuedqty = 0;
$used_amount = $itemrate;

}


?>
<tr>


<td class="bodytext3">
<?=$itemname?>


<!-- </td>
<td style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">-->

</td>
<td  class="bodytext3" align="right" >
<?=number_format($used_amount,'2','.',',');?>

</td>
</tr>
<?php

}
?>

</table>

</td>
</tr>
<tr>
<td id="si_hide_sub_total" colspan="6" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Subtotal</strong><input type="text" id="si_items_subtotal" readonly class="subtotals" value="0.00" size="10"><input type="hidden" id="si_items_subtotal_val" value="0">

</td>
<input type="hidden" id="total4" readonly size="7">
</tr>
<!-- Pharmacy start -->
<tr>
<td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><strong>Pharmacy  </strong></span></td>
</tr>
<tr>
<td colspan="4"></td>
<td align="left" valign="middle" class="bodytext3"><strong>Store</strong></td>
<td class="bodytext3"><input type="hidden" name="store" id="store" value="<?php echo $store3; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				
<input type="hidden" name="request" id="request" value="">

<select name="storecode" id="storecode" >
<?php if($storecode != '') { ?>
<option value="<?php echo $storecode; ?>"><?php echo $store3; ?></option>
<?php } ?>


</select>	</td>
<td colspan="8"></td>

</tr>
<tr><td colspan="3" >

<table class="bodytext3" id="mi_items_subtotal_table"> 

<thead><td align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<strong>Medicine Item</strong>
</td><!-- <td align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<strong>Dose</strong>
</td>
<td align="middle" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<strong>Dose.Measure</strong>
</td>
<td align="middle" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<strong>Freq</strong>
</td>
<td align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<strong>Days</strong>
</td> -->
<td align="middle" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<strong>Package.Qty</strong>
</td>
<td align="middle" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<strong>Issued.Qty</strong>
</td>
<!--  <td align="middle" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<strong>Qty</strong>
</td> -->
<td align="middle" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<strong>Bal.Qty</strong>
</td>
<td align="middle" style="background-color: orange; border: 0px solid rgb(0, 30, 106);">
<strong>Avl Qty</strong>
<td align="right" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<strong>Rate</strong>
</td>
<td align="right" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<strong>Amount</strong>
</td>
</thead>

<tbody id="insertrow1">
<?php
$mi_items_subtotal = 0;
$p=1;
$package_type = 'MI';
$qrylab = "select id,itemcode,itemname,quantity,rate,amount from package_processing where package_id = '$packageid' and package_item_type ='$package_type' and patientcode='$patientcode' and visitcode='$visitcode' and recordstatus <> 'completed' and add_pkg_trackid='0'";
$execlab = mysqli_query($GLOBALS["___mysqli_ston"], $qrylab) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($reslab = mysqli_fetch_array($execlab))
{
$itemcode = $reslab['itemcode'];
$itemname = $reslab['itemname'];
//$itemins = $reslab['instructions'];
if($patientsubtype!='' && $patientsubtype>0)
$subanum = $patientsubtype;
else
$subanum = 1;
$itemratename = "subtype_".$subanum;

$querym2 = "select purchaseprice as rate from master_medicine where itemcode = '$itemcode'";
$execm2 = mysqli_query($GLOBALS["___mysqli_ston"], $querym2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$resm2 = mysqli_fetch_array($execm2);	                 
$itemrate = $resm2['rate'];									 
$pack_qty = $reslab['quantity'];
$medamount=$pack_qty*$itemrate;
$rowid = $reslab['id'];
// Get issued qty

$issqry = "select id from package_execution where processing_id='$rowid'";
$execiss = mysqli_query($GLOBALS["___mysqli_ston"], $issqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$iss_num_rows = mysqli_num_rows($execiss);
if($iss_num_rows)
{

$execiss1 = mysqli_query($GLOBALS["___mysqli_ston"], $issqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$issqry1 = "select sum(qty) as issuedqty from package_execution where processing_id='$rowid' ";
$execiss1 = mysqli_query($GLOBALS["___mysqli_ston"], $issqry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$resiss1 = mysqli_fetch_array($execiss1);
$issuedqty = $resiss1['issuedqty'];
}
else
{
$issuedqty = 0;
}


$query57 = "select sum(batch_quantity) as currentstock,itemcode from transaction_stock where storecode='".$storecode."' AND locationcode='".$locationcode."' AND itemcode = '$itemcode' and batch_stockstatus='1' and TRIM(batchnumber in(select TRIM(batchnumber) from materialreceiptnote_details where expirydate>now() and itemcode ='$itemcode') or TRIM(batchnumber in(select TRIM(batchnumber) from purchase_details where expirydate>now() and itemcode ='$itemcode')))";
$res57=mysqli_query($GLOBALS["___mysqli_ston"], $query57);
$exec57 = mysqli_fetch_array($res57);
$currentstock = intval($exec57['currentstock']);

$balqty = $pack_qty  - $issuedqty;
//$mi_items_subtotal =  $mi_items_subtotal +  $reslab['amount'];
?>
<tr id="idTR<?=$p?>">									 	
<input type="hidden" name="selectpharmacode[]" value="<?php echo $itemcode.$rowid; ?>">
<input type="hidden" name="pharmaname[]" value="<?php echo $itemname; ?>">
<input type="hidden" name="pharmacode[]" value="<?php echo $itemcode; ?>">
<input type="hidden" name="pharmarowid[]" value="<?php echo $rowid; ?>">
<input type="hidden" id="medprocessrowid<?=$itemcode?>" value="<?php echo $rowid; ?>">
<td id="serialnumberp<?=$p?>" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<input id="medicinecode<?=$p?>" name="medicinecode<?=$p?>" type="hidden" align="left" size="25" value="<?=$itemcode?>" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;">
<input id="serialnumberp<?=$p?>" name="serialnumberp<?=$p?>" type="hidden" size="25" value="<?=$p?>" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;">
<input id="medicinename<?=$p?>" name="medicinenamee<?=$p?>" type="text" align="left" size="45" readonly="" value="<?=$itemname?>" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left; font-size:15px;">
</td>
<!-- <td id="dose<?=$p?>" align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<input id="dose<?=$p?>" name="dose<?=$p?>" type="text" size="4" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;" value="<?=$reslab['dose']?>">
</td>
<td id="dosemeasure<?=$p?>" align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<input id="dosemeasure<?=$p?>" name="dosemeasure<?=$p?>" type="text" size="8" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;" value="<?=$reslab['dosemeasure']?>">
</td>
<td id="frequency<?=$p?>" align="middle" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<input id="frequency<?=$p?>" name="frequency<?=$p?>" type="text" size="10" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;" value="<?=$reslab['frequency']?>">
</td>
<td id="days<?=$p?>" align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<input id="days<?=$p?>" name="days<?=$p?>" type="text" size="3" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;" value="<?=$reslab['days']?>">
</td> -->
<td id="tdpharmaqtypk<?=$p?>" align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<input id="pharmaqtypk<?=$p?>" name="pharmaqtypk[]" sno="<?=$p?>" type="text" size="3" class="onlynumber" readonly style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: center;" value="<?=$reslab['quantity']?>">
</td>
<td id="tdpharmaqtyiss<?=$p?>" align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<input id="pharmaqtyiss<?=$p?>" name="pharmaqtyiss<?=$p?>" sno="<?=$p?>" type="text" size="3" class="onlynumber" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: center;" value="<?=$issuedqty?>" readonly>
</td>
<!--   <td id="tdpharmaqty<?=$p?>" align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<input id="pharmaqty<?=$p?>" name="pharmaqty[]" sno="<?=$p?>" type="text" size="3" class="onlynumber pharmaqty" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: left;" value="">
</td> -->
<td id="tdpharmaqtypkbal<?=$itemcode?>" align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<input id="pharmaqtypkbal<?=$itemcode?>" name="pharmaqtypkbal[]" sno="<?=$p?>" type="text" size="3" class="onlynumber" readonly style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: center;" value="<?=$balqty?>">
</td>
<td  align="right" style="background-color: orange; border: 0px solid rgb(0, 30, 106);"><?php echo $currentstock; ?></td>

<td id="tdpharmarate<?=$p?>" align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<input id="pharmarate<?=$itemcode?>" name="pharmarate<?=$p?>" type="text" size="8" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: right;" value="<?=$itemrate?>">
</td>
<td id="tdpharmaamt<?=$p?>" class="pharmacalamt" align="right" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);">
<input id="pharmaamt<?=$itemcode?>"  name="pharmaamt<?=$p?>" type="text" size="9" readonly="" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106); text-align: right;" value="<?=number_format($medamount,2,'.',',')?>">
</td>
</tr>
<?php
$p++;
}
?>
</tbody>
</table></td></tr>
<input type="hidden" name="serialnumberp" id="serialnumberp" value="<?=$p?>">
<tr><td>&nbsp;</td></tr>

<!-- pharma additon items -->
<tr><td class="bodytext3"><strong>Additon Package Medicine</strong></td></tr>
<tr>
<td>
<table class="bodytext3" width="940px" border="0" style="margin-left: 38px;">

<thead>
<td align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);"><strong>Medicine Item</strong></td>
<td align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);"><strong>Qty</strong></td>
<td align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);"><strong>Issued.Qty</strong></td>
<td align="center" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);"><strong>Rate</strong></td>
<td align="center" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);"><strong>Amount</strong></td>
<td align="center" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);"><strong>Status</strong></td>
</thead>	
<?php 
$package_type = 'MI';
$qrypharma1 = "select id,itemcode,itemname,rate,amount,quantity,recordstatus from addpkgitems where  package_item_type ='$package_type' and patientcode='$patientcode' and visitcode='$visitcode'  ";
$execpharma1 = mysqli_query($GLOBALS["___mysqli_ston"], $qrypharma1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($respharma1 = mysqli_fetch_array($execpharma1))
{
$id = $respharma1['id'];
$itemcode = $respharma1['itemcode'];
$itemname = $respharma1['itemname'];
$quantity = $respharma1['quantity'];
$rate = $respharma1['rate'];
$amount = $respharma1['amount'];
$recordstatus = $respharma1['recordstatus'];
if($recordstatus==''){ $recordstatus='APPROVAL PENDING';  }
if($recordstatus=='completed'){ $recordstatus='ISSUE PENDING';  }

$qrypharmaissue = "select sum(c.quantity) as quantity from package_processing as a join addpkgitems as b on a.add_pkg_trackid=b.id join pharmacysales_details as c on c.package_process_id=a.id where   a.patientcode='$patientcode' and a.visitcode='$visitcode' and b.id='$id' ";
$execpharmaissue = mysqli_query($GLOBALS["___mysqli_ston"], $qrypharmaissue) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$respharmaissue = mysqli_fetch_array($execpharmaissue);
$issuedqty = $respharmaissue['quantity'];
if($quantity<=$issuedqty){ $recordstatus='ISSUED';  }	
?>
<tr bgcolor="#7CCFDF">
<td width="300px" class="bodytext3"><?=$itemname?></td>								
<td width="85px" class="bodytext3" align="center" ><?=$quantity;?></td>
<td width="71px" class="bodytext3" align="center" ><?=number_format($issuedqty,'0','','');?></td>
<!--<td width="57px" class="bodytext3" align="center" ><?=$quantity?></td>-->
<td width="83px" class="bodytext3" align="right" ><?=number_format($rate,'2','.',',');?></td>
<td width="91px" class="bodytext3" align="right" ><?=number_format($amount,'2','.',',');?></td>
<td  width="121px" class="bodytext3" align="center" ><?php  echo $recordstatus; ?></td>
</tr>
<?php
}
?>
</table>
</td>
</tr>	

<!-- END pharma additon items -->	


<tr><td>&nbsp;</td></tr>

<tr><td class="bodytext3"><strong>Processed List</strong></td></tr>
<tr>

<td>
<table class="bodytext3" width="550px" style="margin-left: 38px;">
<tr>
<td align="left" class="bodytext3" style="background-color: rgb(255, 255, 255);"><strong>Medicine Item</strong></td>
<td align="left" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);"><strong>Issued.Qty</strong></td>
<td align="center" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);"><strong>Rate</strong></td>
<td align="center" style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);"><strong>Amount</strong></td>
</tr>	
<?php $package_type = 'MI';
$qrylab = "select id,itemcode,itemname,rate,amount,quantity from package_processing where package_id = '$packageid' and package_item_type ='$package_type' and patientcode='$patientcode' and visitcode='$visitcode' and recordstatus <> '' and add_pkg_trackid='0' ";
$pharmacy_used_amt = 0;
$execlab = mysqli_query($GLOBALS["___mysqli_ston"], $qrylab) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($reslab = mysqli_fetch_array($execlab))
{
$itemcode = $reslab['itemcode'];
$itemname = $reslab['itemname'];
$quantity = $reslab['quantity'];
//$itemrate = $reslab['rate'];

if($patientsubtype!='' && $patientsubtype>0)
$subanum = $patientsubtype;
else
$subanum = 1;

$itemratename = "subtype_".$subanum;

$querym2 = "select `$itemratename` as rate from master_medicine where itemcode = '$itemcode'";
$execm2 = mysqli_query($GLOBALS["___mysqli_ston"], $querym2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$resm2 = mysqli_fetch_array($execm2);

$itemrate = $resm2['rate'];

$rowid     = $reslab['id'];

$sno = $sno + 1;

$issqry = "select id from package_execution where processing_id='$rowid'";
$execiss = mysqli_query($GLOBALS["___mysqli_ston"], $issqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$iss_num_rows = mysqli_num_rows($execiss);
if($iss_num_rows)
{
$querym21 = "select quantity,rate from pharmacysales_details where visitcode='$visitcode' and itemcode = '$itemcode'";
$execm21 = mysqli_query($GLOBALS["___mysqli_ston"], $querym21) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$resm21 = mysqli_fetch_array($execm21);

$itemrate = $resm21['rate'];
$quantity = $resm21['quantity'];


$execiss1 = mysqli_query($GLOBALS["___mysqli_ston"], $issqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$issqry1 = "select sum(qty) issuedqty from package_execution where processing_id='$rowid'";
$execiss1 = mysqli_query($GLOBALS["___mysqli_ston"], $issqry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$resiss1 = mysqli_fetch_array($execiss1);
$issuedqty = $resiss1['issuedqty'];
$used_amount = $issuedqty * $itemrate;
$pharmacy_used_amt = $pharmacy_used_amt + $used_amount;
}
else
{
$issuedqty = 0;
$used_amount = $itemrate;

}


?>
<tr>
<td class="bodytext3"><?=$itemname?></td>
<td align="center" class="bodytext3"><?=number_format($quantity,'2')?></td>
<td  class="bodytext3" align="right" ><?=number_format($itemrate,'2','.',',');?></td>
<td  class="bodytext3" align="right" ><?=number_format($used_amount,'2','.',',');?></td>
</tr>
<?php

}
?>

</table>

</td>
</tr>
<?php
include_once("store_stocktaking_chk1.php");
if($num_stocktaking > 0) {
?>
<tr><td colspan="7" class="bodytext3"><font color='red' size='6px'><strong><?php echo $stocktake_err;?></strong></font></td></tr>
<?php
}else{
?>
<tr id="pressid">
<td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
<table id="presid" width="792" border="0" cellspacing="1" cellpadding="1">
<tr>
<td width="200" class="bodytext3">Medicine Name</td>
<td width="40" class="bodytext3">Batch</td>
<td width="40" class="bodytext3">Avl.Qty</td>
<!-- <td width="40" class="bodytext3">Dose</td>
<td width="40" class="bodytext3">Dose Measure</td>
<td width="40" class="bodytext3">Freq</td>
<td width="40" class="bodytext3">Days</td> -->
<td width="40" class="bodytext3">Quantity</td>
<!-- <td width="43" class="bodytext3">Route</td>
<td width="43" class="bodytext3">Instructions</td>
<td width="35" class="bodytext3">Start </td>
<td width="35" class="bodytext3">Time </td>
<td width="35" class="bodytext3">Free </td> -->


<td width="35" class="bodytext3">Rate</td>
<td width="35" class="bodytext3">Amount</td>
</tr>


<tr>
<div id="insertrow">					 </div></tr>
<tr>
<input type="hidden" name="subtypeno" id="subtypeno" value="<?php echo $subanum;?>">
<input type="hidden" name="serialnumber" id="serialnumber" value="1">
<input type="hidden" name="medicinecode" id="medicinecode" value="">
<input name="searchmedicinename1hiddentextbox" id="searchmedicinename1hiddentextbox" type="hidden" value="">
<input name="searchmedicineanum1" id="searchmedicineanum1" value="" type="hidden">
<input name="uniqueautonum" id="uniqueautonum" value="" type="hidden">
<input name="medicinekey" id="medicinekey" value="<?php echo $visitcode,$billnumbercode?>" type="hidden">

<td><input name="medicinename" type="text" id="medicinename" size="40" autocomplete="off">	

</td>


<input type="hidden" name="currentstock" id="currentstock">
<input type="hidden" name="uniquebatch" id="uniquebatch">


<td><select id="medicinebatch" name="medicinebatch" onChange="getavailableqty(this.value)"><option>-Select-</option></select></td>
<td><input type="text" readonly size="5" id="availableqty" name="availableqty"></td>
<!-- <td><input name="dose" type="text" id="dose" size="4" onKeyUp="return Functionfrequency()"></td>
<td><select name="dosemeasure" id="dosemeasure">
<option value="">Select Measure</option>
<option value="suppositories">suppositories</option>
<option value="tabs">tabs</option>
<option value="caps">caps</option>
<option value="ml">ml</option>
<option value="vial">vial</option>
<option value="inj">inj</option>
<option value="amp">amp</option>
<option value="gel">Gel</option>
<option value="tube">tube</option>
</select></td> -->
<!--     <td>
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
</select>				</td>	 -->
<!--   <td><input name="days" type="text" id="days" size="4" onKeyUp="return Functionfrequency()" onFocus="return frequencyitem()"></td> -->
<td><input name="quantity" type="text" id="quantity" class="onlynumber" size="4" onKeyUp="return totamt()"></td>
<!--<td>
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

</select></td>
<td> <select name="sess" id="sess" width="10">
<option value="am">AM</option>
<option value="pm">PM</option>
</select></td> -->

<td>
<input type="text" name="rate" id="rate" value="" size="4" readonly/>
</td> 
<td>   <input type="text" name="amount" id="amount" size="7" readonly> </td>
<input name="formula" type="hidden" id="formula" readonly size="8">

<input name="strength" type="hidden" id="strength" readonly size="8">
<td width="49"><label>
<input type="button" name="Add" id="Add" value="Add" onClick="return insertitem()" class="button" style="border: 1px solid #001E6A">
</label></td>
</tr>
<!--  <tr>
<td colspan="13"></td>
<td class="bodytext3"> Total </td>
<td> <input type="text" name="total" id="total" size="4" value="0" readonly>  </td>
</tr> -->
<input type="hidden" name="h" id="h" value="0">
<input type="hidden" name="itemscount" id="itemscount" value="0">
</table>				  </td>
</tr>
<?php } ?>

<tr>
<td id="mi_hide_sub_total" colspan="6" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Subtotal</strong><input type="text" id="mi_items_subtotal" readonly class="subtotals" value="0.00" size="10"><input type="hidden" id="mi_items_subtotal_val" value="0">

</td>

</tr>
<!-- Pharmacy end -->
<?php 
$package_used_total   =  $services_used_amt + $lab_used_amt + $rad_used_amt + $consultation_used_amt + $pharmacy_used_amt + $doctor_used_amt;
//echo $package_used_total;
//$package_grand_total  =  $si_items_subtotal + $mi_items_subtotal + $li_items_subtotal+$ri_items_subtotal; 
//$package_variance_amt =  $package_amt - $package_grand_total;

$package_variance_amt =  $package_amt - $package_used_total;

?>
<tr><td>&nbsp;</td></tr>
<tr>
<td colspan="6" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Used Amount</strong><input type="text" id="package_grand_total" readonly class="subtotals" value="<?php  echo number_format($package_used_total,'2','.',',');?>" size="10">
<input type="hidden" name="package_grand_total_val" id="package_grand_total_val" value="<?php echo $package_used_total; ?>">
<input type="hidden" name="package_used_amount_val" id="package_used_amount_val" value="<?php echo $package_used_total; ?>">

</td>

</tr>
<tr><td>&nbsp;</td></tr>
<tr>
<td colspan="6" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Variance</strong><input type="text" id="package_variance_amt" readonly class="subtotals" value="<?php  echo number_format($package_variance_amt,'2','.',',');?>" size="10"><input type="hidden" name="package_variance_amt_val" id="package_variance_amt_val" value="<?php echo $package_variance_amt; ?>">

</td>

</tr>   
<input type="hidden" name="packageid" id="packageid" value="<?php echo $packageid; ?>">
<tr><td>&nbsp;</td></tr>
<tr>

<td  ><input type="checkbox"  class="" name="finishprocess" id="finishprocess" value="">
<span class="bodytext3">Finish Process</span>

</td>


<!-- <td   class="bodytext3" bgcolor="#ecf0f5">Finish Process</td> -->

</tr>		
<tr>
<td colspan="5" align="left" valign="left"  bgcolor="#ecf0f5" class="bodytext3">
<input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
<input name="Submit2223" type="submit" id="Submit2223" value="Save" accesskey="b" class="button" style="border: 1px solid #001E6A;margin-left:500px;font-weight: bold;width: 100px;height: 27px;font-size: 17px;"/>
</td>
</tr>
</table>	 </td>

</tr>  <!--end of Service-->



</tbody>
</table>		</td></tr>

<tr>
<td>&nbsp;
</td>
</tr>



</tbody>
</table>
</td>
</tr>

</table>

</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>