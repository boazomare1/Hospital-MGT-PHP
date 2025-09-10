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
$datetimeonly = date("Y-m-d H:i:s");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];

$docno = $_SESSION['docno'];


$titlestr = 'SALES BILL';

$getdocnumber=isset($_REQUEST['docnumber'])?$_REQUEST['docnumber']:'';
$getsalseautonumber=isset($_REQUEST['salseautonumber'])?$_REQUEST['salseautonumber']:'';

$query231 = "select * from master_employee where username='$username'";
$exec231 = mysqli_query($GLOBALS["___mysqli_ston"], $query231) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res231 = mysqli_fetch_array($exec231);
$res7locationanum1 = $res231['location'];

$query551 = "select * from master_location where auto_number='$res7locationanum1'";
$exec551 = mysqli_query($GLOBALS["___mysqli_ston"], $query551) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res551 = mysqli_fetch_array($exec551);
$location1 = $res551['locationname'];

$res7storeanum1 = $res231['store'];

$query751 = "select * from master_store where auto_number='$res7storeanum1'";
$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res751 = mysqli_fetch_array($exec751);
$store1 = $res751['store'];

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{   

//get locationcode and storecode
$getlocationcode=isset($_REQUEST['getlocationcode'])?$_REQUEST['getlocationcode']:'';
$getlocationname=isset($_REQUEST['getlocationname'])?$_REQUEST['getlocationname']:'';
$getstorecode=isset($_REQUEST['getstorecode'])?$_REQUEST['getstorecode']:'';
//end here

$patientcode=$_REQUEST['patientcode'];
$visitcode=$_REQUEST['visitcode'];
$pharmacycoa = $_REQUEST['pharmacycoa'];
$patientname=$_REQUEST['customername'];
$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab=mysqli_fetch_array($Querylab);
$patienttype=$execlab['maintype'];
$querytype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where auto_number='$patienttype'");
$exectype=mysqli_fetch_array($querytype);
$patienttype1=$exectype['paymenttype'];
$patientsubtype=$execlab['subtype'];
$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$patientsubtype'");
$execsubtype=mysqli_fetch_array($querysubtype);
$patientsubtype1=$execsubtype['subtype'];

$query77 = "select * from master_ipvisitentry where visitcode='$visitcode'";
		$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res77 = mysqli_fetch_array($exec77);
		$doctor = $res77['consultingdoctor'];
		
		$query78 = "select * from master_doctor where auto_number='$doctor'";
		$exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res78 = mysqli_fetch_array($exec78);
		$doctorname = $res78['doctorname'];
	
$billnumber=$_REQUEST['billnumber'];
$dateonly = date("Y-m-d");
 $accountname = $_REQUEST['account'];
$totalrefundamount = $_REQUEST['totalamt'];
$accountnameano=$_REQUEST['accountnameano'];
$accountnameid=$_REQUEST['accountnameid'];

foreach($_POST['med'] as $key => $value)
{
$medicinename=$_POST['med'][$key]; 
$itemcode=$_POST['code'][$key];
$rate=$_POST['rate'][$key];
		$quantity=$_POST['quantity'][$key];
		$returnquantity=$_POST['returnquantity'][$key];
		$batchnumber=$_POST['batch'][$key];
		$amount=$_POST['amount'][$key];
		$fifo_code=$_POST['fifo_code'][$key];
		//get docno hrere
$docnumber=$_REQUEST['docnumber'][$key];
//ends here
//get docno hrere
$salseautonumber=$_REQUEST['salseautonumber'][$key];
//ends here
		
			$query31 = "select categoryname from master_itempharmacy where itemcode = '$itemcode'"; 
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res31 = mysqli_fetch_array($exec31);
			 $categoryname = $res31['categoryname'];
			 
			 $query6 = "select ledgername, ledgercode, ledgerautonumber,incomeledger,incomeledgercode, purchaseprice from master_medicine where itemcode = '$itemcode'"; 
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6 = mysqli_fetch_array($exec6);
			$ledgername = $res6['ledgername'];
			$ledgercode = $res6['ledgercode'];
			$ledgeranum = $res6['ledgerautonumber'];
			$incomeledger =$res6['incomeledger'];
			$incomeledgercode = $res6['incomeledgercode'];
			$costprice = $res6['purchaseprice'];
			$totalcp = $costprice * $returnquantity;
		
			foreach($_POST['ref'] as $check1)
			{
			 $refund=$check1;
		
	if($refund == $itemcode)
	{
	if($returnquantity !='')
	{
	if($visitcode!='walkinvis')
	{// echo 'in';
		$query76 = "select * from master_ipvisitentry where billtype='PAY LATER' and visitcode='$visitcode'";
		$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num76 = mysqli_num_rows($exec76);
		if($num76 == 0)
		{ //echo 'll';
		
		$querycumstock2 = "select sum(batch_quantity) as cum_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$getlocationcode'";
		$execcumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querycumstock2) or die ("Error in CumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rescumstock2 = mysqli_fetch_array($execcumstock2);
		$cum_quantity = $rescumstock2["cum_quantity"];
		$cum_quantity = $cum_quantity+$returnquantity;
		
		$querybatstock2 = "select batch_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$getlocationcode' and fifo_code='$fifo_code' and storecode ='$getstorecode'";
		$execbatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querybatstock2) or die ("Error in batQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$resbatstock2 = mysqli_fetch_array($execbatstock2);
		$bat_quantity = $resbatstock2["batch_quantity"];
		$bat_quantity = $bat_quantity+$returnquantity;
		
		$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' ,batch_stockstatus='0' where itemcode='$itemcode' and locationcode='$getlocationcode' and storecode='$getstorecode' and fifo_code='$fifo_code'";
		$execupdatebatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatebatstock2) or die ("Error in updatebatQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' where itemcode='$itemcode' and locationcode='$getlocationcode'";
		$execupdatebatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatebatstock2) or die ("Error in updatebatQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$stockquery2="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,
			batchnumber, batch_quantity, 
			transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,patientcode,patientvisitcode,patientname,rate,totalprice,ledgeranum,ledgercode,ledgername,incomeledger,incomeledgercode)
			values ('$fifo_code','pharmacysalesreturn_details','$itemcode', '$medicinename', '$dateonly','1', 'Sales Return', 
			'$batchnumber', '$bat_quantity', '$returnquantity', 
			'$cum_quantity', '$billnumber', '','1','1', '$getlocationcode','','$getstorecode', '', '$username', '$ipaddress','$dateonly','$timeonly','$datetimeonly','$patientcode','$visitcode','$patientname','$rate','$amount','$ledgeranum','$ledgercode','$ledgername','$incomeledger','$incomeledgercode')";
			
		$stockexecquery2=mysqli_query($GLOBALS["___mysqli_ston"], $stockquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query43="insert into pharmacysalesreturn_details(fifo_code,patientcode,visitcode,companyanum,billnumber,itemcode,itemname,rate,quantity,totalamount,username,ipaddress,entrydate,batchnumber,billstatus,location,pharmacycoa,categoryname,locationname,locationcode,store,docnumber,salseautonumber,ledgeranum,ledgercode,ledgername,incomeledger,incomeledgercode, costprice, totalcp)values('$fifo_code','$patientcode','$visitcode','$companyanum','$billnumber','$itemcode','$medicinename','$rate','$returnquantity','$amount','$username','$ipaddress','$dateonly','$batchnumber','pending','$location1','$pharmacycoa','$categoryname','".$getlocationname."','".$getlocationcode."','".$getstorecode."','".$docnumber."','".$salseautonumber."','$ledgeranum','$ledgercode','$ledgername','$incomeledger','$incomeledgercode','$costprice','$totalcp')"; 
		$exec43=mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		}
		else
		{//echo 'jj';
		
		$querycumstock2 = "select cum_quantity from transaction_stock where cum_stockstatus='1' and itemcode='$itemcode' and locationcode='$getlocationcode'";
		$execcumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querycumstock2) or die ("Error in CumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rescumstock2 = mysqli_fetch_array($execcumstock2);
		$cum_quantity = $rescumstock2["cum_quantity"];
		$cum_quantity = $cum_quantity+$returnquantity;
		
		$querybatstock2 = "select batch_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$getlocationcode' and fifo_code='$fifo_code' and storecode ='$getstorecode'";
		$execbatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querybatstock2) or die ("Error in batQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$resbatstock2 = mysqli_fetch_array($execbatstock2);
		$bat_quantity = $resbatstock2["batch_quantity"];
		$bat_quantity = $bat_quantity+$returnquantity;
		
		$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' ,batch_stockstatus='0' where itemcode='$itemcode' and locationcode='$getlocationcode' and storecode='$getstorecode' and fifo_code='$fifo_code'";
		$execupdatebatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatebatstock2) or die ("Error in updatebatQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' where itemcode='$itemcode' and locationcode='$getlocationcode'";
		$execupdatebatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatebatstock2) or die ("Error in updatebatQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$stockquery2="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,
			batchnumber, batch_quantity, 
			transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,patientcode,patientvisitcode,patientname,ledgeranum,ledgercode,ledgername,incomeledger,incomeledgercode)
			values ('$fifo_code','pharmacysalesreturn_details','$itemcode', '$medicinename', '$dateonly','1', 'Sales Return', 
			'$batchnumber', '$bat_quantity', '$returnquantity', 
			'$cum_quantity', '$billnumber', '','1','1', '$getlocationcode','','$getstorecode', '', '$username', '$ipaddress','$dateonly','$timeonly','$datetimeonly','$patientcode','$visitcode','$patientname','$ledgeranum','$ledgercode','$ledgername','$incomeledger','$incomeledgercode')";
			
		$stockexecquery2=mysqli_query($GLOBALS["___mysqli_ston"], $stockquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query43="insert into pharmacysalesreturn_details(patientcode,visitcode,companyanum,billnumber,itemcode,itemname,rate,quantity,totalamount,username,ipaddress,entrydate,batchnumber,billstatus,pharmacycoa,location,categoryname,locationname,locationcode,store,docnumber,salseautonumber,ledgeranum,ledgercode,ledgername,incomeledger,incomeledgercode,costprice,totalcp)values('$patientcode','$visitcode','$companyanum','$billnumber','$itemcode','$medicinename','$rate','$returnquantity','$amount','$username','$ipaddress','$dateonly','$batchnumber','completed','$pharmacycoa','$location1','$categoryname','".$getlocationname."','".$getlocationcode."','".$getstorecode."','".$docnumber."','".$salseautonumber."','$ledgeranum','$ledgercode','$ledgername','$incomeledger','$incomeledgercode','$costprice','$totalcp')";
		$exec43=mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query55 = "insert into paylaterpharmareturns(patientcode,patientvisitcode,patientname,medicinecode,medicinename,rate,quantity,amount,pharmacycoa,username,ipaddress,billdate,accountname,billnumber,locationname,locationcode,ledgercode,ledgername,incomeledger,incomeledgercode)values('$patientcode','$visitcode','$patientname','$itemcode','$medicinename','$rate','$returnquantity','$amount','$pharmacycoa','$username','$ipaddress','$dateonly','$accountname','$billnumber','".$getlocationname."','".$getlocationcode."','$ledgercode','$ledgername','$incomeledger','$incomeledgercode')";
		$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
			
		
	
		}//echo "oo";
	}//echo "oo";
	/*else
	{ echo 'ii';
		$query43="insert into pharmacysalesreturn_details(patientcode,visitcode,companyanum,billnumber,itemcode,itemname,rate,quantity,totalamount,username,ipaddress,entrydate,batchnumber,billstatus,pharmacycoa,location,categoryname,locationname,locationcode,store,docnumber,salseautonumber)values('$patientcode','$visitcode','$companyanum','$billnumber','$itemcode','$medicinename','$rate','$returnquantity','$amount','$username','$ipaddress','$dateonly','$batchnumber','pending','$pharmacycoa','$location1','$categoryname','".$getlocationname."','".$getlocationcode."','".$getstorecode."','".$docnumber."','".$salseautonumber."')";
		$exec43=mysql_query($query43) or die(mysql_error());
		
		$query55 = "insert into paylaterpharmareturns(patientcode,patientvisitcode,patientname,medicinecode,medicinename,rate,quantity,amount,pharmacycoa,username,ipaddress,billdate,accountname,billnumber,locationname,locationcode)values('$patientcode','$visitcode','$patientname','$itemcode','$medicinename','$rate','$returnquantity','$amount','$pharmacycoa','$username','$ipaddress','$dateonly','$accountname','$billnumber','".$getlocationname."','".$getlocationcode."')";
		$exec55 = mysql_query($query55) or die(mysql_error());
	}*/
	}//echo "oo";
	}//echo "oo";
			}//echo "ij";
	}//echo "ok";
 	
		$query76 = "select * from master_ipvisitentry where billtype='PAY LATER' and visitcode='$visitcode'";
		$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num76 = mysqli_num_rows($exec76);
		if($num76 > 0)
		{ 
			$query83="insert into master_transactionpaylater(patientname,patientcode,visitcode,transactiondate,accountname,docno,ipaddress,companyanum,companyname,financialyear,transactiontype,paymenttype,subtype,transactionamount,receivableamount,doctorname,locationname,locationcode,accountnameid,accountnameano,fxamount,accountcode)values('$patientname',
					  '$patientcode','$visitcode','$dateonly','$accountname','$billnumber','$ipaddress','$companyanum','$companyname','$financialyear','pharmacycredit','$patienttype1','$patientsubtype1','$totalrefundamount','$totalrefundamount','$doctorname','".$getlocationname."','".$getlocationcode."','$accountnameid','$accountnameano','$totalrefundamount','$accountnameid')";
			$exec83=mysqli_query($GLOBALS["___mysqli_ston"], $query83) or die("error in query83".mysqli_error($GLOBALS["___mysqli_ston"]));		  
		}
	
  header("location:medicineissuelist.php");
  exit;
}

?>

<?php
if (isset($_REQUEST["errcode"])) { $errcode = $_REQUEST["errcode"]; } else { $errcode = ""; }
if($errcode == 'failed')
{
	$errmsg="No Stock";
}
?>
<script>
function validcheck()
{
document.getElementById("savebutton").value == true;
if(confirm("Are You Want To Save The Record?")==false){document.getElementById("savebutton").value == false;return false;}	
}
function acknowledgevalid(varSerialNumber2)
{
var varSerialNumber2=varSerialNumber2;

var hasChecked = false;
if (document.getElementById("ref"+varSerialNumber2+"").checked)
{
hasChecked = true;
}

if (hasChecked == false)
{
alert("Please either refund a drug  or click back button on the browser to exit sample collection");
document.getElementById("returnquantity"+varSerialNumber2+"").value = 0;
return false;
}
return true;

}
function balancecalc(varSerialNumber1,qnty1,totalcount)
{
var varSerialNumber1 = varSerialNumber1;
var qnty1 = qnty1;
var totalcount=totalcount;
//alert(totalcount);
var grandtotal=0;

var abc=acknowledgevalid(varSerialNumber1);
if(abc == true)
{

var returnquantity=document.getElementById("returnquantity"+varSerialNumber1+"").value;
returnquantity = parseInt(returnquantity);
qnty1 = parseInt(qnty1);
if(returnquantity>qnty1)
{
alert("Please Enter a Lesser Quantity");
document.getElementById("balamount"+varSerialNumber1+"").value=0.00;
document.getElementById("totalamt").value=0.00;
document.getElementById("amount"+varSerialNumber1+"").value=0.00;
document.getElementById("returnquantity"+varSerialNumber1+"").value = 0;
document.getElementById("returnquantity"+varSerialNumber1+"").focus();
return false;
}
if(returnquantity <= qnty1)
{
var balancequantity=parseFloat(qnty1)-parseFloat(returnquantity);

document.getElementById("balamount"+varSerialNumber1+"").value=balancequantity;

var rate=document.getElementById("rate"+varSerialNumber1+"").value;

var newamount=rate * returnquantity;
document.getElementById("amount"+varSerialNumber1+"").value=newamount.toFixed(2);
for(i=1;i<=totalcount;i++)
{
var totalamount=document.getElementById("amount"+i+"").value;

if(totalamount == "")
{
totalamount=0;
}
//alert(totalamount);
grandtotal=parseFloat(grandtotal)+parseFloat(totalamount);

}
//alert(grandtotal);
document.getElementById("totalamt").value=grandtotal.toFixed(2);
}
return true;
}

}

function number(event)
{
	var charcode=(event.which)?event.which:event.keycode
	if(charcode>31 && (charcode<47 || charcode >57))
	{
		return false;
	}
		return true;
}

function updatebox(varSerialNumber3,qnty1,totalcount1)
{
var varSerialNumber3 = varSerialNumber3;
var qnty1 = qnty1;
var totalcount1=totalcount1;
var grandtotal=0;
if(document.getElementById("ref"+varSerialNumber3+"").checked == true)
{
var returnquantity=document.getElementById("returnquantity"+varSerialNumber3+"").value;

if(returnquantity !='')
{
returnquantity = parseInt(returnquantity);
qnty1 = parseInt(qnty1);
if(returnquantity>qnty1)
{
alert("Please Enter a Lesser Quantity");
document.getElementById("balamount"+varSerialNumber3+"").value=0.00;
document.getElementById("totalamt").value=0.00;
document.getElementById("amount"+varSerialNumber3+"").value=0.00;
document.getElementById("returnquantity"+varSerialNumber3+"").value = 0;
document.getElementById("returnquantity"+varSerialNumber3+"").focus();
return false;
}
if(returnquantity <= qnty1)
{
var balancequantity=parseFloat(qnty1)-parseFloat(returnquantity);

document.getElementById("balamount"+varSerialNumber3+"").value=balancequantity;

var rate=document.getElementById("rate"+varSerialNumber3+"").value;

var newamount=rate * returnquantity;
document.getElementById("amount"+varSerialNumber3+"").value=newamount.toFixed(2);
for(i=1;i<=totalcount1;i++)
{
var totalamount=document.getElementById("amount"+i+"").value;

if(totalamount == "")
{
totalamount=0;
}
//alert(totalamount);
grandtotal=parseFloat(grandtotal)+parseFloat(totalamount);

}
//alert(grandtotal);
document.getElementById("totalamt").value=grandtotal.toFixed(2);
return true;
}
}
}
else
{
var dum=0;
document.getElementById("balamount"+varSerialNumber3+"").value=0;
document.getElementById("amount"+varSerialNumber3+"").value=dum.toFixed(2);
for(i=1;i<=totalcount1;i++)
{
var totalamount=document.getElementById("amount"+i+"").value;

if(totalamount == "")
{
totalamount=0;
}
grandtotal=parseFloat(grandtotal)+parseFloat(totalamount);
}
document.getElementById("totalamt").value=grandtotal.toFixed(2);
}
}

</script>

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
.bal
{
border-style:none;
background:none;
text-align:right;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

</style>
<?php
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
$docnumber=$_REQUEST['docnumber'];
?>
<script src="js/datetimepicker_css.js"></script>
<?php
if($visitcode!='walkinvis')
{
$query65= "select * from master_ipvisitentry where patientcode='$patientcode'";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die("error in query65".mysqli_error($GLOBALS["___mysqli_ston"]));
$res65=mysqli_fetch_array($exec65);
$Patientname=$res65['patientfullname'];

$query69="select * from master_customer where customercode='$patientcode'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
$patientage=$res69['age'];
$patientgender=$res69['gender'];
$patientaccount=$res69['accountname'];

$query70="select * from master_accountname where auto_number='$patientaccount'";
$exec70=mysqli_query($GLOBALS["___mysqli_ston"], $query70);
$res70=mysqli_fetch_array($exec70);
$accountname=$res70['accountname'];
$accountnameano=$res70['auto_number'];
$accountnameid=$res70['id'];
}
else
{
$query65= "select * from master_consultationpharmissue where docnumber='$docnumber'";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die("error in query65".mysqli_error($GLOBALS["___mysqli_ston"]));
$res65=mysqli_fetch_array($exec65);
$billno=$res65['billnumber'];
$query69="select * from prescription_externalpharmacy where billnumber='$billno'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
$Patientname=$res69['patientname'];
$patientage=$res69['age'];
$patientgender=$res69['gender'];
$patientaccount=$res69['accountname'];
}
$query764 = "select * from master_financialintegration where field='pharmacypaylaterrefund'";
$exec764 = mysqli_query($GLOBALS["___mysqli_ston"], $query764) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res764 = mysqli_fetch_array($exec764);

$pharmacycoa = $res764['code'];


$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'PRF-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from pharmacysalesreturn_details where ipdocno = '' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='PRF-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billnumber"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'PRF-'.$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

/*echo $queryget = "select pd.locationname,pd.locationcode,ms.storecode FROM pharmacysales_details as pd LEFT JOIN master_store as ms ON pd.store = ms.store WHERE pd.patientcode = '".$patientcode."' AND pd.visitcode = '".$visitcode."'";*/
 $queryget = "select locationname,locationcode,store FROM pharmacysales_details WHERE patientcode = '".$patientcode."' AND visitcode = '".$visitcode."' and ipdocno = '".$getdocnumber."'";

$execget = mysqli_query($GLOBALS["___mysqli_ston"], $queryget) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$resget = mysqli_fetch_array($execget);

 $getlocationname = $resget['locationname'];
 $getlocationcode = $resget['locationcode'];
//echo $getstorename = $resget['store'];
  $getstorecode = $resget['store'];
 $queryget1 = "select store FROM master_store  WHERE storecode='".$getstorecode."'";

$execget1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryget1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$resget1 = mysqli_fetch_array($execget1);

  $getstorename = $resget1['store'];
?>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="frmsales" id="frmsales" method="post" action="pharmacyrefund.php" onKeyDown="return disableEnterKey(event)" onSubmit="return validcheck()">
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
    <td colspan="4" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo 'red'; } ?>" class="bodytext3"><strong><?php echo $errmsg;?>&nbsp;</strong></td></tr>
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
              
                    <input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" /> 
                    <input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
               <td bgcolor="#ecf0f5" class="bodytext3"><strong>Patient  * </strong></td>
	  <td width="25%" align="left" valign="top" bgcolor="#ecf0f5">
				<input name="customername" id="customer" value="<?php echo $Patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/>
                  </td>
                          <td bgcolor="#ecf0f5" class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Date </strong></td>
				
                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
                
                <td  colspan="5" bgcolor="#ecf0f5" class="bodytext3">
               
                  <input name="ADate" id="ADate" style="border: 1px solid #001E6A" value="<?php echo $dateonly; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                  <img src="images2/cal.gif" style="cursor:pointer"/>
				</td>
               
               
              </tr>
			 
		
			  <tr>

			    <td width="5%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code</strong></td>
                <td width="25%" align="left" valign="top" >
			<input name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
                  </td>
                 <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient code </strong></td>
                <td colspan="3" align="left" valign="top" >
				<input name="customercode" id="customercode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
                 <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Location </strong></td>
                <td width="12%" colspan="3" align="left" valign="top" >
				<input name="customercode" id="customercode" value="<?php echo $getlocationname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>		<input type="hidden" name="getlocationcode" value="<?php echo $getlocationcode; ?>">
                <input type="hidden" name="getlocationname" value="<?php echo $getlocationname; ?>">
				
				</td>
             
			    </tr>
				  <tr>

			  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
			    <td align="left" valign="middle" >
				<input type="text" name="patientage" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly>
				&
				<input type="text" name="patientgender" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly>
				     </td>
                <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>
                <td colspan="3" align="left" valign="top" >
				<input name="account" id="account" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input name="accountnameid" id="accountnameid" value="<?php echo $accountnameid; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input name="accountnameano" id="accountnameano" value="<?php echo $accountnameano; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="pharmacycoa" value="<?php echo $pharmacycoa; ?>"></td>
                 <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Store</strong></td>
                <td colspan="3" align="left" valign="top" >
				<input  value="<?php echo $getstorename; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="getstorecode" value="<?php echo $getstorecode; ?>"></td>
				
				  </tr>
				  <tr>
				      <td width="5%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Return No </strong></td>
                <td colspan="3" align="left" valign="top" >
				<input name="billnumber" id="billnumber" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
			</td>
				  </tr>
				  
			   
			   
				  <tr>
				  <td width="5%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
              
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
					<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Refund</strong></div></td>
              <td width="18%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Medicine</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Batch No</strong></div></td>
                <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Avl. Qty</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Iss. Qty</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ret. Qty</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ref. Qty</strong></div></td>
			<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bal. Qty</strong></div></td>
			<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate</strong></div></td>
			<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount</strong></div></td>
			
			      </tr>
                  <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$locationname = $res1["locationname"];
						$locationcode1 = $res1["locationcode"];
						?>
						
						<?php
						}
						
						$query65= "select * from master_employeelocation where username='$username' and defaultstore='default'";
						$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die("error in query65".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res65=mysqli_fetch_array($exec65);
						$storecode=$res65['storecode'];
						$querye65= "select * from master_store where auto_number='$storecode'";
						$exece65=mysqli_query($GLOBALS["___mysqli_ston"], $querye65) or die("error in query65".mysqli_error($GLOBALS["___mysqli_ston"]));
						$rese65=mysqli_fetch_array($exece65);
						$storecodeget=$rese65['storecode'];
						
						?>
						<?php
						$ippharmauotnum=$_REQUEST['ippharmauotnum'];
						$salseautonumber=$_REQUEST['salseautonumber'];
						$locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';
						if($locationcode==''){ $locationcode=$locationcode1;}
						$colorloopcount = '';
						$sno = '';
						$ssno=0;
						$nno=0;
						$totalamount=0;		
						$totalavaquantity=0;
						$totalavaquantity1=0;
			$query71 = "select * from pharmacysales_details where locationcode='".$locationcode."' and patientcode = '$patientcode' and visitcode = '$visitcode' and ipdocno='$docnumber' ";
$exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$numb=mysqli_num_rows($exec71);
//echo $numb;
while($res71 = mysqli_fetch_array($exec71))
	{
	$totalavaquantity1=0;
	$itemcode=$res71["itemcode"];
$batchnumber=$res71["batchnumber"];
$quantity=$res71["quantity"];
$patientnames=$res71["patientname"];
$fifo_code=$res71["fifo_code"];
$query721 = "select * from paylaterpharmareturns where patientname='$patientnames' and patientvisitcode = '$visitcode' and medicinecode='$itemcode'";
$exec721 = mysqli_query($GLOBALS["___mysqli_ston"], $query721) or die ("Error in Query721".mysqli_error($GLOBALS["___mysqli_ston"]));
$numbr1=mysqli_num_rows($exec721);
$res721 = mysqli_fetch_array($exec721);
$billnumber=$res721['billnumber'];
$query72 = "select * from pharmacysalesreturn_details where locationcode='".$locationcode."' and  patientcode = '$patientcode' and visitcode = '$visitcode' and itemcode='$itemcode' and batchnumber='$batchnumber' and docnumber='".$docnumber."' and salseautonumber='".$salseautonumber."'";
$exec72 = mysqli_query($GLOBALS["___mysqli_ston"], $query72) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$numbr=mysqli_num_rows($exec72);
//echo $numbr;
while($res72 = mysqli_fetch_array($exec72))
{
$avaquantity1=$res72['quantity'];
$totalavaquantity1=$totalavaquantity1+$avaquantity1;
}
$resquantity=$quantity - $totalavaquantity1;
//echo $resquantity;


$nno=$nno+1;
	
	}	
	//echo $nno;
			$query61 = "select * from pharmacysales_details where locationcode='".$locationcode."' and patientcode = '$patientcode' and visitcode = '$visitcode' and ipdocno='$docnumber'";
$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
 $num=mysqli_num_rows($exec61);
//echo $num;
while($res61 = mysqli_fetch_array($exec61))
{
$totalavaquantity=0;
$itemname =$res61["itemname"];
$itemcode=$res61["itemcode"];
$batchnumber=$res61["batchnumber"];
$quantity=$res61["quantity"];
$rate=$res61["rate"];
$patientnames=$res61["patientname"];
$fifo_code=$res61["fifo_code"];
$query621 = "select * from paylaterpharmareturns where patientname='$patientnames' and patientvisitcode = '$visitcode' and medicinecode='$itemcode'";
$exec621 = mysqli_query($GLOBALS["___mysqli_ston"], $query621) or die ("Error in Query621".mysqli_error($GLOBALS["___mysqli_ston"]));
$numbr621=mysqli_num_rows($exec621);
$res621 = mysqli_fetch_array($exec621);
$billnumber=$res621['billnumber'];
$query62 = "select * from pharmacysalesreturn_details where locationcode='".$locationcode."' and  patientcode = '$patientcode' and visitcode = '$visitcode' and itemcode='$itemcode' and batchnumber='$batchnumber' and docnumber='".$docnumber."' and salseautonumber='".$salseautonumber."'";
$exec62 = mysqli_query($GLOBALS["___mysqli_ston"], $query62) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$numbr=mysqli_num_rows($exec62);
//echo $numbr;
while($res62 = mysqli_fetch_array($exec62))
{
$avaquantity=$res62['quantity'];
 $totalavaquantity=$totalavaquantity+$avaquantity;
}
$resquantity=$quantity - $totalavaquantity;
$refundedquantity=$totalavaquantity;
$balanceqty=$quantity-$refundedquantity;
$sno=$sno+1;
$quantity=intval($quantity);


//batch qty
 $querybatstock2 = "select batch_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$locationcode' and fifo_code='$fifo_code' and storecode ='$storecodeget'";
$execst62 = mysqli_query($GLOBALS["___mysqli_ston"], $querybatstock2) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
 $batchqty=mysqli_num_rows($execst62);
//echo $numbr;
while($resst62 = mysqli_fetch_array($execst62))
{
$batchqty=$resst62['batch_quantity'];
 $totalabatchqty=$totalabatchqty+$batchqty;
}
?>
  <tr>
  <td class="bodytext31" valign="center"  align="left"><div align="center">
        <input type="checkbox" name="ref[]" id="ref<?php echo $sno; ?>" value="<?php echo $itemcode; ?>" onClick="updatebox('<?php echo $sno; ?>','<?php echo $resquantity;?>','<?php echo $nno; ?>')"/></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $itemname;?></div></td>
		<input type="hidden" name="med[]" value="<?php echo $itemname;?>">
		<input type="hidden" name="code[]" value="<?php echo $itemcode; ?>">
        <input type="hidden" name="fifo_code[]" value="<?php echo $fifo_code; ?>">
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $batchnumber;?></div></td>
            <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $totalabatchqty;?></div></td>
			<input type="hidden" name="batch[]" value="<?php echo $batchnumber;?>">
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity;?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="returnquantity[]" id="returnquantity<?php echo $sno; ?>" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $resquantity;?>','<?php echo $nno; ?>')" onKeyPress="return number(event)"  size="7"></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refundedquantity;?></div></td>
			<input type="hidden" name="quantity[]" value="<?php echo $resquantity;?>">
		   <td class="bodytext31" valign="center" bordercolor="#f3f3f3"><input type="text" class="bal" name="balamount[]" id="balamount<?php echo $sno; ?>" size="7" readonly value="<?php echo $balanceqty; ?>"></td>
         <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $rate;?><input type="hidden" name="rate[]" id="rate<?php echo $sno; ?>" value="<?php echo $rate;?>"></div></td>
		 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" class="bal" name="amount[]" id="amount<?php echo $sno; ?>" size="7" readonly></div></td>
		 <input type="hidden" name="docnumber[]" value="<?php echo $docnumber;?>">
           <input type="hidden" name="salseautonumber[]" value="<?php echo $salseautonumber;?>">
						</tr>
			<?php 
		}
		
			
		?>
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
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong>Total Refund</strong></td>
              <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#ecf0f5"><input type="text" name="totalamt" id="totalamt" size="7" class="bal"></td>
         
             </tr>
           
          </tbody>
        </table>		</td>
      </tr>
       
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr>
              <td width="54%" align="right" valign="top" >
                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
             	  <input name="Submit2223" type="submit" id="savebutton" value="Save" onClick="return check();" accesskey="b" class="button" style="border: 1px solid #001E6A"/>
               </td>
              
            </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
  </table>

</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>