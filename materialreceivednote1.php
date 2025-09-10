<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$updatetime = date('H:i:s');
$updatedate = date('Y-m-d');
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$locationprefix = '';

$titlestr = 'SALES BILL';
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
if(isset($_REQUEST['locationcode'])) { $locationcode = $_REQUEST['locationcode']; } else { $locationcode = ''; }
if (isset($_SESSION["materialreceivednotesession"])) { $materialreceivednotesession = $_SESSION["materialreceivednotesession"]; } else { $materialreceivednotesession = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag2 == 'frmflag2')
{
//$billnumber = $_REQUEST['billnum'];
if($materialreceivednotesession=='pending')
{
$_SESSION['materialreceivednotesession']='completed';
$store = $_REQUEST['store1'];

$billdate = $_REQUEST['billdate'];
$suppliername = $_REQUEST['suppliername'];
$suppliercode = $_REQUEST['suppliercode'];
$ponumber = $_REQUEST['pono'];
$accountssubid = $_REQUEST['accountssubid'];
$supplierbillno = $_REQUEST['supplierbillno1'];
$amount = $_REQUEST['totalpurchaseamount'];
$currency = $_REQUEST['currency'];
$fxrate = $_REQUEST['fxrate'];
$deliverybillno = $_REQUEST['deliverybillno1'];
$totalfxamount = $_REQUEST['totalfxamount'];
$purchasetype = $_REQUEST['purchasetype'];

$query23 = "select * from master_employee where username='$username'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23); 
$res7locationanum = $res23['location'];

$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res55 = mysqli_fetch_array($exec55);
$location = $res55['locationname'];


$query751 = "select * from master_financialintegration where field='grn'";
$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res751 = mysqli_fetch_array($exec751);
$coa = $res751['code'];

$locationcode = $_REQUEST['location'];
$locationname = $_REQUEST['locationname'];
$store1 = $_REQUEST['store1'];

$query66 = "select * from master_location where locationcode = '$locationcode'";
$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
$res66 = mysqli_fetch_array($exec66);
$locationprefix = $res66['prefix'];

$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'MRN-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from materialreceiptnote_details where typeofpurchase='Process' and billnumber like 'MRN-%' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='MRN-'.'1'.'-'.$locationprefix;
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
	
	
	$billnumbercode = 'MRN-' .$maxanum.'-'.$locationprefix;
	$openingbalance = '0.00';
	//echo $companycode;
}

foreach($_POST['itemname'] as $key=>$value)
{
$itemname = $_POST['itemname'][$key];
$itemcode = $_POST['itemcode'][$key];
$selectitemcode = $_POST['selectitemcode'][$key];

foreach($_POST['selectitem'] as $check=>$value1)
{
$selectitem = $_POST['selectitem'][$check];

if($selectitemcode == $selectitem)
{

$query5 = "select * from master_itempharmacy where itemcode = '$itemcode'";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res5 = mysqli_fetch_array($exec5);
			$itemanum = $res5['auto_number'];
$rate = $_POST['rate'][$key];
$quantity = $_POST['receivedquantity'][$key];
$allpackagetotalquantity = $_POST['totalquantity'][$key];

$free = $_POST['free'][$key];
$itemdiscountpercent = $_POST['discount'][$key];
$totalamount = $_POST['totalamount1'][$key];
$itemtaxpercent = $_POST['tax'][$key];
$batchnumber = $_POST['batch'][$key];
$batchnumber = str_replace(" ","",$batchnumber);
$batchnumber = trim($batchnumber);
$salesprice = $_POST['saleprice'][$key];
$costprice = $_POST['costprice'][$key];
$maxcostprice = $_POST['maxcostprice'][$key];
$expirydate = $_POST['expirydate'][$key];
$fxamount1 = $_POST['fxamount'][$key];
$totalfxpuramount = $_POST['totalfxamount1'][$key];
$expirymonth = substr($expirydate, 0, 2);
$expiryyear = substr($expirydate, 3, 2);
$expiryday = '01';
$expirydate = $expiryyear.'-'.$expirymonth.'-'.$expiryday;
$priceperpack = $_POST['priceperpack'][$key];
$packagename = $_POST['packsize'][$key];
 $balqty = $_POST['balqty'][$key];
if($balqty == $quantity)
{
$itemstatus = 'received';
}
else
{
$itemstatus = '';
}

			$query31 = "select unitname_abbreviation, packageanum, categoryname from master_itempharmacy where itemcode = '$itemcode'"; 
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res31 = mysqli_fetch_array($exec31);
			$itemunitabb = $res31['unitname_abbreviation'];
			$res31packageanum = $res31['packageanum'];
			$categoryname = $res31['categoryname'];

			//$packagename = addslashes($packagename);
			$query32 = "select auto_number, quantityperpackage from master_packagepharmacy where auto_number = '$res31packageanum'";//packagename = '$packagename'";
			$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query32".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res32 = mysqli_fetch_array($exec32);
			$packageanum = $res32['auto_number'];
			$quantityperpackage = $res32['quantityperpackage'];

			$query6 = "select ledgername, ledgercode, ledgerautonumber,incomeledger,incomeledgercode from master_medicine where itemcode = '$itemcode'"; 
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6 = mysqli_fetch_array($exec6);
			$ledgername = $res6['ledgername'];
			$ledgercode = $res6['ledgercode'];
			$ledgeranum = $res6['ledgerautonumber'];
			$incomeledger =$res6['incomeledger'];
			$incomeledgercode = $res6['incomeledgercode'];

			
			$querystock2 = "select fifo_code from transaction_stock where docstatus='New Batch' order by auto_number desc limit 0, 1";
			$execstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querystock2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resstock2 = mysqli_fetch_array($execstock2);
			$fifo_code = $resstock2["fifo_code"];
			if ($fifo_code == '')
			{       
				$fifo_code = '1';
				$queryupdatecumstock2 = "update transaction_stock set cum_stockstatus='0' where itemcode='$itemcode' and locationcode='$locationcode'";
				$execupdatecumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatecumstock2) or die ("Error in updateCumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$stockquery2="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,
				batchnumber, batch_quantity, 
				transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,rate,totalprice,ledgeranum,ledgercode,ledgername,incomeledger,incomeledgercode
)
				values ('$fifo_code','purchase_details','$itemcode', '$itemname', '$updatedate','1', 'Purchase', 
				'$batchnumber', '$allpackagetotalquantity', '$allpackagetotalquantity', 
				'$allpackagetotalquantity', '$billnumbercode', 'New Batch','1','1', '$locationcode','','$store1', '', '$username', '$ipaddress','$updatedate','$updatetime','$updatedatetime','$salesprice','$totalamount','$ledgeranum','$ledgercode','$ledgername','$incomeledger','$incomeledgercode')";
				
				$stockexecquery2=mysqli_query($GLOBALS["___mysqli_ston"], $stockquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				else
				{
				$querycumstock2 = "select cum_quantity from transaction_stock where cum_stockstatus='1' and itemcode='$itemcode' and locationcode='$locationcode'";
				$execcumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querycumstock2) or die ("Error in CumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$rescumstock2 = mysqli_fetch_array($execcumstock2);
				$cum_quantity = $rescumstock2["cum_quantity"];
				$cum_quantity = $allpackagetotalquantity+$cum_quantity;
				$fifo_code = $fifo_code + 1;
				
				$queryupdatecumstock2 = "update transaction_stock set cum_stockstatus='0' where itemcode='$itemcode' and locationcode='$locationcode'";
				$execupdatecumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatecumstock2) or die ("Error in updateCumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$stockquery2="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,
				batchnumber, batch_quantity, 
				transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,rate,totalprice,ledgeranum,ledgercode,ledgername,incomeledger,incomeledgercode
)
				values ('$fifo_code','purchase_details','$itemcode', '$itemname', '$updatedate','1', 'Purchase', 
				'$batchnumber', '$allpackagetotalquantity', '$allpackagetotalquantity', 
				'$cum_quantity', '$billnumbercode', 'New Batch','1','1', '$locationcode','','$store1', '', '$username', '$ipaddress','$updatedate','$updatetime','$updatedatetime','$salesprice','$totalamount','$ledgeranum','$ledgercode','$ledgername','$incomeledger','$incomeledgercode')";
				
				$stockexecquery2=mysqli_query($GLOBALS["___mysqli_ston"], $stockquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				
				
			}
			
			$query4 = "insert into materialreceiptnote_details (bill_autonumber, companyanum, 
			billnumber, itemanum, itemcode, itemname, itemdescription, rate, quantity, 
			subtotal, free, discountpercentage, discountrupees, openingstock, closingstock, totalamount, 
			discountamount, username, ipaddress, entrydate, itemtaxpercentage, itemtaxamount, unit_abbreviation, 
			batchnumber, salesprice, expirydate, itemfreequantity, itemtotalquantity, 
			packageanum, packagename, quantityperpackage, allpackagetotalquantity, 
			manufactureranum, manufacturername,typeofpurchase,suppliername,suppliercode,ponumber,supplierbillnumber,costprice,locationcode,store,coa,categoryname,fifo_code,totalfxamount,fxpkrate,priceperpk,deliverybillno,currency,fxamount,ledgeranum,ledgercode,ledgername ,incomeledger,incomeledgercode,purchasetype
) 
			values ('$billautonumber', '$companyanum', '$billnumbercode', '$itemanum', '$itemcode', '$itemname', '$itemdescription', '$rate', '$quantity', 
			'$totalamount', '$free', '$itemdiscountpercent', '$itemdiscountrupees', '$opening
			stock', '$closingstock', 
			'$totalamount', '$discountamount', '$username', '$ipaddress', '$billdate', 
			'$itemtaxpercent', '$itemtaxamount', '$itemunitabb', 
			'$batchnumber', '$salesprice', '$expirydate', '$free', '$quantity', 
			'$packageanum', '$packagename', '$quantityperpackage', '$allpackagetotalquantity', 
			'$manufactureranum', '$manufacturername','Process','$suppliername','$suppliercode','$ponumber','$supplierbillno','$costprice','$locationcode','$store1','$coa','$categoryname','$fifo_code','$totalfxpuramount','$fxamount1','$priceperpack','$deliverybillno','$currency','$fxrate','$ledgeranum','$ledgercode','$ledgername','$incomeledger','$incomeledgercode','$purchasetype')";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$query56 = "update purchaseorder_details set goodsstatus='$itemstatus' where billnumber='$ponumber' and itemcode='$itemcode'";
			$exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
			$query561 = "update master_itempharmacy set purchaseprice='$costprice' where itemcode='$itemcode'";
			$exec561 = mysqli_query($GLOBALS["___mysqli_ston"], $query561) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$locationrate = $locationcode.'_rateperunit';
			$query562 = "update master_medicine set purchaseprice='$costprice' where itemcode='$itemcode'";
			$exec562 = mysqli_query($GLOBALS["___mysqli_ston"], $query562) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
			
}

}

}

		$transactiontype = 'PAYMENT';
		$transactionmode = 'CREDIT';
		$particulars = 'BY CREDIT (Inv NO:'.$billnumbercode.$supplierbillnumber.')';    
		//include ("transactioninsert1.php");
		$query9 = "insert into master_transactionpharmacy (transactiondate, particulars, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount, creditamount,balanceamount,
		billnumber, billanum, ipaddress, updatedate,  companyanum, companyname, transactionmodule,suppliercode,currency,fxrate,totalfxamount) 
		values ('$updatedatetime', '$particulars', '$accountssubid', '$suppliername', 
		'$transactionmode', '$transactiontype', '$amount', '$amount', '$amount',
		'$billnumbercode',  '$billautonumber', '$ipaddress', '$updatedate', '$companyanum', '$companyname', '$transactionmodule1','$suppliercode','$currency','$fxrate','$totalfxamount')";
		//$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		$transactiontype = 'PURCHASE';
		$transactionmode = 'BILL';
		$particulars = 'BY PURCHASE (Inv NO:'.$billnumbercode.$supplierbillnumber.')';  
		//include ("transactioninsert1.php");
		$query9 = "insert into master_transactionpharmacy (transactiondate, particulars, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount,
		billnumber, billanum, ipaddress, updatedate,  companyanum, companyname, transactionmodule,suppliercode,currency,fxrate,totalfxamount) 
		values ('$updatedatetime', '$particulars', '$accountssubid', '$suppliername', 
		'$transactionmode', '$transactiontype', '$amount', 
		'$billnumbercode',  '$billautonumber', '$ipaddress', '$updatedate', '$companyanum', '$companyname', '$transactionmodule1','$suppliercode','$currency','$fxrate','$totalfxamount')";
		//$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		$query3 = "insert into master_purchase (companyanum, billnumber, billdate, suppliercode, suppliername,totalamount,totalquantity,ipaddress,supplierbillnumber,typeofpurchase,currency,fxrate,totalfxamount)values('$companyanum','$billnumbercode','$updatedatetime','$suppliercode', '$suppliername','$amount','$quantity','$ipaddress','$supplierbillno','Process','$currency','$fxrate','$totalfxamount')";
		//$exec3 = mysql_query($query3) or die(mysql_error());

}
header("location:materialreceivednote.php?mrn=$billnumbercode&&locationcode=$locationcode");
}


//To get default tax from autoitemsearch1.php and autoitemsearch2.php - for CST tax override.
if (isset($_REQUEST["defaulttax"])) { $defaulttax = $_REQUEST["defaulttax"]; } else { $defaulttax = ""; }
if(isset($_REQUEST['delete']))
{
$referalname=$_REQUEST['delete'];
mysqli_query($GLOBALS["___mysqli_ston"], "delete from consultation_referal where referalname='$referalname'");
}
//$defaulttax = $_REQUEST["defaulttax"];
if ($defaulttax == '')
{
	$_SESSION["defaulttax"] = '';
}
else
{
	$_SESSION["defaulttax"] = $defaulttax;
}

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
$storecodeget='';
	$searchpo = $_POST['po'];
	$searchpo = trim($searchpo);
	$len1 = strlen($searchpo);
					$str1 = preg_replace('/[^\\/\-a-z\s]/i', '', $searchpo);
					
					if($str1 == 'MLPO-')
					{
//$query5 = "select * from purchaseorder_details where billnumber = '$searchpo' and recordstatus='generated' order by billnumber";
$query5 = "select * from manual_lpo where billnumber = '$searchpo' and recordstatus='' order by billnumber";
}
else
{
 $query5 = "select * from purchaseorder_details where billnumber = '$searchpo' and (recordstatus='autogenerated' || recordstatus='generated') order by billnumber";
}
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res5 = mysqli_fetch_array($exec5))
{
	//echo "yes";
	$billnum = $res5["billnumber"];
	$suppliername = $res5['suppliername'];
	$suppliercode = $res5['suppliercode'];
	$suppliername = strtoupper($suppliername);
	$billdate = $res5['billdate'];
	$res5locationcode = $res5['locationcode'];
	$res5locationname = $res5['locationname'];
	$currency = $res5['currency'];
	$fxamount = $res5['fxamount'];  
	if($currency=='')
	{
		$currency='UGX';
		$fxamount='1';
	}
	if($str1 != 'MLPO-')
	{
	$storename = $res5['storename'];    
	$storecodeget = $res5['storecode'];
	}
	
	$purchaseindentdocno = $res5['purchaseindentdocno'];
			
	$query99 = "select purchasetype from purchase_indent where docno = '$purchaseindentdocno'";
	$exec99 = mysqli_query($GLOBALS["___mysqli_ston"], $query99) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$number7 = mysqli_num_rows($exec99);
	$res99 = mysqli_fetch_array($exec99);
	$purchasetype = $res99['purchasetype'];
	
	$query66 = "select * from master_location where locationcode = '$res5locationcode'";
	$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res66 = mysqli_fetch_array($exec66);
	$locationprefix = $res66['prefix'];
		
	$query1 = "select * from master_accountname where id='$suppliercode'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_num_rows());
	$res1 = mysqli_fetch_array($exec1);
	$accountssubanum = $res1['accountssub'];
	
	$query11 = "select * from master_accountssub where auto_number='$accountssubanum'";
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res11 = mysqli_fetch_array($exec11);
	$accountssubid = $res11['id'];
	$query66 = "select * from master_supplier where suppliercode='$suppliercode'";
$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res66 = mysqli_fetch_array($exec66);
$addressname = $res66['address1'];
$address = $addressname;
$addressname1 = $res66['address2'];
if($addressname1 != '')
{
$address = $address.','.$addressname1;
}
$area = $res66['area'];
if($area != '')
{
$address = $address.','.$area;
}
$city = $res66['city'];
if($city !='')
{
$address = $address.','.$city;
}
$state = $res66['state'];
if($state !='')
{
$address = $address.','.$state;
}
$country = $res66['country'];
if($country !='')
{
$address = $address.','.$country;
}
$telephone2 = $res66['mobilenumber'];
$tele=$telephone2;
$telephone = $res66['phonenumber1'];
if($telephone != '')
{
$tele=$tele.','.$telephone;
}
$telephone1 = $res66['phonenumber2'];
if($telephone1 != '')
{
$tele=$tele.','.$telephone1;
}
}

	//$transactiondatefrom = $_REQUEST['ADate1'];
	//$transactiondateto = $_REQUEST['ADate2'];

}


//To verify the edition and manage the count of bills.
$thismonth = date('Y-m-');
$query77 = "select * from master_edition where status = 'ACTIVE'";
$exec77 =  mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
$res77 = mysqli_fetch_array($exec77);
$res77allowed = $res77["allowed"];


/*
$query99 = "select count(auto_number) as cntanum from master_quotation where quotationdate like '$thismonth%'";
$exec99 = mysql_query($query99) or die ("Error in Query99".mysql_error());
$res99 = mysql_fetch_array($exec99);
$res99cntanum = $res99["cntanum"];
$totalbillandquote = $res88cntanum + $res99cntanum; //total of bill and quote in current month.
if ($totalbillandquote > $res77allowed)
{
	//header ("location:usagelimit1.php"); // redirecting.
	//exit;
}
*/

//To Edit Bill
if (isset($_REQUEST["delbillst"])) { $delbillst = $_REQUEST["delbillst"]; } else { $delbillst = ""; }
//$delbillst = $_REQUEST["delbillst"];
if (isset($_REQUEST["delbillautonumber"])) { $delbillautonumber = $_REQUEST["delbillautonumber"]; } else { $delbillautonumber = ""; }
//$delbillautonumber = $_REQUEST["delbillautonumber"];
if (isset($_REQUEST["delbillnumber"])) { $delbillnumber = $_REQUEST["delbillnumber"]; } else { $delbillnumber = ""; }
//$delbillnumber = $_REQUEST["delbillnumber"];

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
//$frm1submit1 = $_REQUEST["frm1submit1"];




if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST["st"];
if (isset($_REQUEST["banum"])) { $banum = $_REQUEST["banum"]; } else { $banum = ""; }
//$banum = $_REQUEST["banum"];
if ($st == '1')
{
	$errmsg = "Success. New Bill Updated. You May Continue To Add Another Bill.";
	$bgcolorcode = 'success';
}
if ($st == '2')
{
	$errmsg = "Failed. New Bill Cannot Be Completed.";
	$bgcolorcode = 'failed';
}
if ($st == '1' && $banum != '')
{
	$loadprintpage = 'onLoad="javascript:loadprintpage1()"';
}

?>


<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'MRN-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from materialreceiptnote_details where typeofpurchase='Process' and billnumber like 'MRN-%'  order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='MRN-'.'1';
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
	
	
	$billnumbercode = 'MRN-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

$query23 = "select * from master_employee where username='$username'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$res7locationanum = $res23['location'];

$query55 = "select * from master_location where locationcode='$res5locationcode'";
$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res55 = mysqli_fetch_array($exec55);
$locationname = $res55['locationname'];
$locationanum = $res55['auto_number'];

$res7storeanum = $res23['store'];

$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res75 = mysqli_fetch_array($exec75);
$store = $res75['store'];


?>

<?php
include("autocompletebuild_purchaseorder.php");

?>

<script>
<?php 
if (isset($_REQUEST["mrn"])) { $mrn = $_REQUEST["mrn"]; } else { $mrn = ""; }
?>
	var mrn;
	var mrn = "<?php echo $mrn; ?>";
	//alert(refundbillnumber);
	if(mrn != "") 
	{
		window.open("print_mrnview.php?billnumber="+mrn+"&&locationcode=<?= $locationcode; ?>","OriginalWindowA25",'width=700,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}   
</script>
<script type="text/javascript">

function loadprintpage1(varPaperSizeCatch)
{
	//var varBillNumber = document.getElementById("billnumber").value;
	var varPaperSize = varPaperSizeCatch;
	//alert (varPaperSize);
	//return false;
	<?php
	//To previous js error if empty. 
	if ($previousbillnumber == '') 
	{ 
		$previousbillnumber = 1; 
		$previousbillautonumber = 1; 
		$previouscompanyanum = 1; 
	} 
	?>
	var varBillNumber = document.getElementById("quickprintbill").value;
	var varBillAutoNumber = "<?php //echo $previousbillautonumber; ?>";
	var varBillCompanyAnum = "<?php echo $_SESSION["companyanum"]; ?>";
	if (varBillNumber == "")
	{
		alert ("Bill Number Cannot Be Empty.");//quickprintbill
		document.getElementById("quickprintbill").focus();
		return false;
	}
	
	var varPrintHeader = "INVOICE";
	var varTitleHeader = "ORIGINAL";
	if (varTitleHeader == "")
	{
		alert ("Please Select Print Title.");
		document.getElementById("titleheader").focus();
		return false;
	}
	
	//alert (varBillNumber);
	//alert (varPrintHeader);
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');

	if (varPaperSize == "A4")
	{
		window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&billnumber="+varBillNumber+"","OriginalWindowA4<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
	if (varPaperSize == "A5")
	{
		window.open("print_bill1_a5.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&billnumber="+varBillNumber+"","OriginalWindowA5<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
}


function funcDefaultTax1() //Function to CST Taxes if required.
{
	//alert ("Default Tax");
	<?php
	//delbillst=billedit&&delbillautonumber=13&&delbillnumber=1
	//To avoid change of bill number on edit option after selecting default tax.
	if (isset($_REQUEST["delbillst"])) { $delBillSt = $_REQUEST["delbillst"]; } else { $delBillSt = ""; }
	//$delBillSt = $_REQUEST["delbillst"];
	if (isset($_REQUEST["delbillautonumber"])) { $delBillAutonumber = $_REQUEST["delbillautonumber"]; } else { $delBillAutonumber = ""; }
	//$delBillAutonumber = $_REQUEST["delbillautonumber"];
	if (isset($_REQUEST["delbillnumber"])) { $delBillNumber = $_REQUEST["delbillnumber"]; } else { $delBillNumber = ""; }
	//$delBillNumber = $_REQUEST["delbillnumber"];
	
	?>
	var varDefaultTax = document.getElementById("defaulttax").value;
	if (varDefaultTax != "")
	{
		<?php
		if ($delBillSt == 'billedit')
		{
		?>
		window.location="sales1.php?defaulttax="+varDefaultTax+"&&delbillst=<?php echo $delBillSt; ?>&&delbillautonumber="+<?php echo $delBillAutonumber; ?>+"&&delbillnumber="+<?php echo $delBillNumber; ?>+"";
		<?php
		}
		else
		{
		?>
		window.location="sales1.php?defaulttax="+varDefaultTax+"";
		<?php
		}
		?>
	}
	else
	{
		window.location="sales1.php";
	}
	//return false;
}
function funcOnLoadBodyFunctionCall()
{


	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	 //To handle ajax dropdown list.
	funcCustomerDropDownSearch3();
	funcPopupPrintFunctionCall();
	
}


</script>
<script>
function enabletext(varserialnumber,number)
{
	//alert(varserialnumber);
	if(document.getElementById("selectitem"+varserialnumber+"").checked==true)
	{
		var balnc = document.getElementById("balqty"+varserialnumber+"").value;
		document.getElementById("receivedquantity"+varserialnumber+"").readOnly=false;
		document.getElementById("expirydate"+varserialnumber+"").readOnly=false;
		document.getElementById("free"+varserialnumber+"").readOnly=false;
		document.getElementById("batch"+varserialnumber+"").readOnly=false;
		document.getElementById("discount"+varserialnumber+"").readOnly=false;
		//document.getElementById("tax"+varserialnumber+"").readOnly=false;
		document.getElementById("fxamount"+varserialnumber+"").readOnly=false;
		
		
	}
	else
	{
		document.getElementById("receivedquantity"+varserialnumber+"").readOnly=true;
		document.getElementById("expirydate"+varserialnumber+"").readOnly=true;
		document.getElementById("free"+varserialnumber+"").readOnly=true;
		document.getElementById("batch"+varserialnumber+"").readOnly=true;
		document.getElementById("discount"+varserialnumber+"").readOnly=true;
		//document.getElementById("tax"+varserialnumber+"").readOnly=true;
		document.getElementById("fxamount"+varserialnumber+"").readOnly=true;
		
		document.getElementById("receivedquantity"+varserialnumber+"").value='0';
		document.getElementById("expirydate"+varserialnumber+"").value='';
		document.getElementById("free"+varserialnumber+"").value='0';
		document.getElementById("batch"+varserialnumber+"").value='';
		document.getElementById("discount"+varserialnumber+"").value='0';
		//document.getElementById("tax"+varserialnumber+"").value='0';
		
	}
	totalamount(varserialnumber,number);
}
function totalcalc(varserialnumber)
{
	
	var varserialnumber = varserialnumber;
	var receivedqty = document.getElementById("receivedquantity"+varserialnumber+"").value;
	if(receivedqty != '')
	{
	is_int(receivedqty,varserialnumber);
	}
	var balqty = document.getElementById("balqty"+varserialnumber+"").value;
	if(parseFloat(receivedqty) > parseFloat(balqty))
	{
	alert("Received quantity is greater than Balancequantity.Please Enter Lesser quantity");
	document.getElementById("receivedquantity"+varserialnumber+"").value=0;
	document.getElementById("totalquantity"+varserialnumber+"").value='0';
	return false;
	}
	if(receivedqty != '')
	{
	var packsize=document.getElementById("packsize"+varserialnumber+"").value;
	var packvalue=packsize.substring(0,packsize.length - 1);
	var totalqty=parseInt(receivedqty) * parseInt(packvalue);
	document.getElementById("totalquantity"+varserialnumber+"").value=totalqty;
	}
	return true;
	
}
 function is_int(value,varserialnumber8){ 
  if((parseFloat(value) == parseInt(value)) && !isNaN(value)){
	  return true;
  } else { 
  alert("Quantity should be integer");
  document.getElementById("receivedquantity"+varserialnumber8+"").value=0;
	  return false;
  } 
}
function totalcalc1(varserialnumber1)
{
var varserialnumber1 = varserialnumber1;
var receivedqty1 = document.getElementById("receivedquantity"+varserialnumber1+"").value;
var packsize1=document.getElementById("packsize"+varserialnumber1+"").value;
var free1=document.getElementById("free"+varserialnumber1+"").value;
if(free1 != '')
{
var packvalue1=packsize1.substring(0,packsize1.length - 1);
var totalqty1=parseInt(receivedqty1) * parseInt(packvalue1) + parseInt(free1);
document.getElementById("totalquantity"+varserialnumber1+"").value=totalqty1;
}
}

function checkqty(sno, totnum)
{
	var fxamount = document.getElementById("fxamount"+sno+"").value;
	if(fxamount=='')
	{
		fxamount=0;
	}   
	var receivedqty2 = document.getElementById("receivedquantity"+sno+"").value;
	if(receivedqty2=='')
	{
		receivedqty2=0;
	}
	if(parseFloat(receivedqty2)==0)
	{
		alert("Enter received quantity");
		document.getElementById("receivedquantity"+sno+"").focus();
		return false;   
	}
	var origfxamount = document.getElementById("origfxamount"+sno+"").value;
	var maxcostprice1 = document.getElementById("maxcostprice"+sno+"").value;
	var origmaxcostprice = document.getElementById("origmaxcostprice"+sno+"").value;
	if(parseFloat(fxamount) > parseFloat(maxcostprice1))
	{	
		document.getElementById("maxcostprice"+sno+"").value = parseFloat(fxamount);

		// alert("Price cannot be greaterthan actual price."); 
		// document.getElementById("fxamount"+sno+"").value = origfxamount;
		// totalamount(sno,totnum);
		return false;
	} else {
		document.getElementById("maxcostprice"+sno+"").value = parseFloat(origmaxcostprice);
	}
}

function totalamount(varserialnumber2,totalcount)
{
var grandtotaladjamt = 0;
var grandtotalfxadjamt = 0;
var varserialnumber2 = varserialnumber2;
var totalcount = totalcount;
var fxamount = document.getElementById("fxamount"+varserialnumber2+"").value;
var fxrate = document.getElementById("fxrate").value;
if(fxamount=='')
{
	fxamount=0;
}
var receivedqty2 = document.getElementById("receivedquantity"+varserialnumber2+"").value;
var priceperpack2 = parseFloat(fxamount)*parseFloat(fxrate);
priceperpack2 = priceperpack2.toFixed(2);
if(priceperpack2 != '' && receivedqty2 != '')
{
	
var packsize1=document.getElementById("packsize"+varserialnumber2+"").value;
var packvalue1=packsize1.substring(0,packsize1.length - 1);
var spmarkup = document.getElementById("spmarkup"+varserialnumber2+"").value;
var totalamount = parseFloat(receivedqty2) * parseFloat(priceperpack2) * parseFloat(packvalue1);
var totalfxamount=parseFloat(receivedqty2) * parseFloat(fxamount) * parseFloat(packvalue1);

document.getElementById("totalamount"+varserialnumber2+"").value = totalamount.toFixed(2);
document.getElementById("totalfxamount"+varserialnumber2+"").value = totalfxamount.toFixed(2);
var tot=parseFloat(receivedqty2) * parseFloat(packvalue1);


if(parseFloat(tot)>'0')
{
	var costprice1 = parseFloat(totalamount)/parseFloat(tot);
}
else
{
 	var costprice1=0;
}

document.getElementById("costprice"+varserialnumber2+"").value = costprice1.toFixed(2);

var salepricemarkup = (parseFloat(costprice1) * parseFloat(spmarkup))/100;

var saleprice = parseFloat(costprice1) + parseFloat(salepricemarkup);

document.getElementById("saleprice"+varserialnumber2+"").value = saleprice.toFixed(2);

for(i=1;i<=totalcount;i++)
{
var totaladjamount=document.getElementById("totalamount"+i+"").value;
var totaladjfxamount=document.getElementById("totalfxamount"+i+"").value;
if(totaladjamount == "")
{
totaladjamount=0;
}
if(totaladjfxamount == "")
{
totaladjfxamount=0;
}

if(document.getElementById("selectitem"+i+"").checked==true)
	{
		
grandtotaladjamt=grandtotaladjamt+parseFloat(totaladjamount);
grandtotalfxadjamt = parseFloat(grandtotalfxadjamt)+parseFloat(totaladjfxamount);
	}
	
}
document.getElementById("totalpurchaseamount").value = grandtotaladjamt.toFixed(2);
document.getElementById("totalfxamount").value = grandtotalfxadjamt.toFixed(2);
document.getElementById("priceperpack"+varserialnumber2+"").value=priceperpack2;
}
}

function totalamountdisc(varserialnumber3,totalcount1)
{

var totalcount1 = totalcount1;
var grandtotaladjamt1 = 0;
var varserialnumber3 = varserialnumber3;
var grandtotalfxadjamt = 0;
var receivedqty3 = document.getElementById("receivedquantity"+varserialnumber3+"").value;
var priceperpack3 = document.getElementById("priceperpack"+varserialnumber3+"").value;
var fxrate = document.getElementById("fxrate").value;
var fxamount = document.getElementById("fxamount"+varserialnumber3+"").value;
var packsize3=document.getElementById("packsize"+varserialnumber3+"").value;
var packvalue3=packsize3.substring(0,packsize3.length - 1);
var totalamount3 = parseFloat(receivedqty3) * parseFloat(fxamount) * parseFloat(packvalue3);

var discountpercent3 = document.getElementById("discount"+varserialnumber3+"").value;
if(discountpercent3 !='')
{
var tax = document.getElementById("tax"+varserialnumber3+"").value;
var spmarkup1 = document.getElementById("spmarkup"+varserialnumber3+"").value;
if(tax == '')
{
var totalamount31 = parseFloat(totalamount3) * parseFloat(discountpercent3);
var totalamount32 = parseFloat(totalamount31) / 100;

var finalamount3 = parseFloat(totalamount3) - parseFloat(totalamount32);

var tot1=parseFloat(receivedqty3) * parseFloat(packvalue3);

var costprice1 = parseFloat(priceperpack3);

document.getElementById("costprice"+varserialnumber3+"").value = costprice1;

var salepricemarkup = (parseFloat(costprice1) * parseFloat(spmarkup1))/100;

var saleprice = parseFloat(costprice1) + parseFloat(salepricemarkup);
document.getElementById("saleprice"+varserialnumber3+"").value = saleprice.toFixed(2);
}
else
{
var totalamount31 = parseFloat(totalamount3) * parseFloat(discountpercent3);
var totalamount32 = parseFloat(totalamount31) / 100;

var finalamount3 = parseFloat(totalamount3) - parseFloat(totalamount32);
var finaltaxamount = parseFloat(finalamount3) * parseFloat(tax);
var finaltaxamount1 = parseFloat(finaltaxamount)/100;

var finaltaxamount3 = parseFloat(finalamount3) + parseFloat(finaltaxamount1);

var tot1=parseFloat(receivedqty3) * parseFloat(packvalue3);
var costprice1 = priceperpack3;
document.getElementById("costprice"+varserialnumber3+"").value = costprice1;
var salepricemarkup = (parseFloat(costprice1) * parseFloat(spmarkup1))/100;

var saleprice = parseFloat(costprice1) + parseFloat(salepricemarkup);
document.getElementById("saleprice"+varserialnumber3+"").value = saleprice.toFixed(2);
}

document.getElementById("totalfxamount"+varserialnumber3+"").value = finalamount3.toFixed(2);
document.getElementById("totalamount"+varserialnumber3+"").value = (parseFloat(finalamount3)*parseFloat(fxrate)).toFixed(2);
for(i=1;i<=totalcount1;i++)
{
var totaladjamount=document.getElementById("totalamount"+i+"").value;
var totaladjfxamount=document.getElementById("totalfxamount"+i+"").value;
if(totaladjamount == "")
{
totaladjamount=0;
}
if(totaladjfxamount == "")
{
totaladjfxamount=0;
}
if(document.getElementById("selectitem"+i+"").checked==true)
	{
grandtotaladjamt1=grandtotaladjamt1+parseFloat(totaladjamount);
grandtotalfxadjamt = parseFloat(grandtotalfxadjamt)+parseFloat(totaladjfxamount);
	}
}
document.getElementById("totalpurchaseamount").value = grandtotaladjamt1.toFixed(2);
document.getElementById("totalfxamount").value = grandtotalfxadjamt.toFixed(2);
}

}

function totalamount20(varserialnumber4,totalcount2)
{
var totalcount2 = totalcount2;
var grandtotaladjamt2 = 0;
var grandtotalfxadjamt=0;
var varserialnumber4 = varserialnumber4;
var receivedqty4 = document.getElementById("receivedquantity"+varserialnumber4+"").value;
var priceperpack4 = document.getElementById("priceperpack"+varserialnumber4+"").value;
var packsize4=document.getElementById("packsize"+varserialnumber4+"").value;
var fxrate = document.getElementById("fxrate").value;
var fxamount = document.getElementById("fxamount"+varserialnumber4+"").value;
var packvalue4=packsize4.substring(0,packsize4.length - 1);
var totalamount4 = parseFloat(receivedqty4) * parseFloat(fxamount) * parseFloat(packvalue4);
var discountpercent4 = document.getElementById("discount"+varserialnumber4+"").value;
var spmarkup2 = document.getElementById("spmarkup"+varserialnumber4+"").value;
if(discountpercent4 != '')
{
var totalamount41 = parseFloat(totalamount4) * parseFloat(discountpercent4);
var totalamount42 = parseFloat(totalamount41) / 100;

var finalamount4 = parseFloat(totalamount4) - parseFloat(totalamount42);
var tax = document.getElementById("tax"+varserialnumber4+"").value;
if(tax != '')
{
var finaltaxamount = parseFloat(finalamount4) * parseFloat(tax);
var finaltaxamount1 = parseFloat(finaltaxamount)/100;

var finaltaxamount2 = parseFloat(finalamount4) + parseFloat(finaltaxamount1);
var tot2=parseFloat(receivedqty4) * parseFloat(packvalue4);
var costprice = priceperpack4;
document.getElementById("costprice"+varserialnumber4+"").value = costprice;
var salepricemarkup = (parseFloat(costprice) * parseFloat(spmarkup2))/100;

var saleprice = parseFloat(costprice) + parseFloat(salepricemarkup);
document.getElementById("saleprice"+varserialnumber4+"").value = saleprice.toFixed(2);
}
}
else
{
var tax = document.getElementById("tax"+varserialnumber4+"").value;
if(tax != '')
{
var finaltaxamount = parseFloat(totalamount4) * parseFloat(tax);
var finaltaxamount1 = parseFloat(finaltaxamount)/100;

var finaltaxamount2 = parseFloat(totalamount4) + parseFloat(finaltaxamount1);
var tot2=parseFloat(receivedqty4) * parseFloat(packvalue4);

var costprice = priceperpack4;
document.getElementById("costprice"+varserialnumber4+"").value = costprice;
var salepricemarkup = (parseFloat(costprice) * parseFloat(spmarkup2))/100;

var saleprice = parseFloat(costprice) + parseFloat(salepricemarkup);
document.getElementById("saleprice"+varserialnumber4+"").value = saleprice.toFixed(2);
}
}

document.getElementById("totalfxamount"+varserialnumber4+"").value = finaltaxamount2.toFixed(2);
document.getElementById("totalamount"+varserialnumber4+"").value = (parseFloat(finaltaxamount2)*parseFloat(fxrate)).toFixed(2);
for(i=1;i<=totalcount2;i++)
{
var totaladjamount=document.getElementById("totalamount"+i+"").value;
var totaladjfxamount=document.getElementById("totalfxamount"+i+"").value;
if(totaladjamount == "")
{
totaladjamount=0;
}
if(totaladjfxamount == "")
{
totaladjfxamount=0;
}
if(document.getElementById("selectitem"+i+"").checked==true)
	{
grandtotaladjamt2=grandtotaladjamt2+parseFloat(totaladjamount);
grandtotalfxadjamt = parseFloat(grandtotalfxadjamt)+parseFloat(totaladjfxamount);
	}
}
document.getElementById("totalpurchaseamount").value = grandtotaladjamt2.toFixed(2);
document.getElementById("totalfxamount").value = grandtotalfxadjamt.toFixed(2);
}


function funcsave(totalcount5)
{
document.getElementById("savebutton").disabled=true;
var totalcount5 =totalcount5;

if(document.getElementById("po").value =='')
{
alert("Please Select Purchase Order");
document.getElementById("po").focus();
document.getElementById("savebutton").disabled=false;
return false;
}
if(document.getElementById("supplierbillno").value =='')
{
alert("Please Enter Supplier Invoice Number");
document.getElementById("supplierbillno").focus();
document.getElementById("savebutton").disabled=false;
return false;
}
if(document.getElementById("deliverybillno").value =='')
{
alert("Please Enter Delivery Number");
document.getElementById("deliverybillno").focus();
document.getElementById("savebutton").disabled=false;
return false;
}
if(document.getElementById("store").value =='')
{
alert("Please Select Store");
document.getElementById("store").focus();
document.getElementById("savebutton").disabled=false;
return false;
}
var chkflag = "false";
for(i=1;i<=totalcount5;i++)
{
if(document.getElementById("selectitem"+i+"").checked == true)
{
var chkflag = "true";
}
}

if(chkflag == "false"){
alert('Please Select Item');
document.getElementById("savebutton").disabled=false;
return false;
}
for(i=1;i<=totalcount5;i++)
{
if(document.getElementById("selectitem"+i+"").checked == true)
{
var receivedquantity=document.getElementById("receivedquantity"+i+"").value;
if(receivedquantity == "")
{
alert("Please Enter Received Quantity");
document.getElementById("receivedquantity"+i+"").focus();
document.getElementById("savebutton").disabled=false;
return false; 
}
}
}

for(i=1;i<=totalcount5;i++)
{
	if(document.getElementById("selectitem"+i+"").checked == true)
	{
		var receivedquantity1=document.getElementById("receivedquantity"+i+"").value;
		var balqty1 = document.getElementById("balqty"+i+"").value;

		/*if(parseFloat(receivedquantity1) < parseFloat(balqty1))
		{
			alert("Received quantity is less than Balancequantity.Please Enter equal quantity");
			document.getElementById("receivedquantity"+i+"").value=0;
			document.getElementById("totalquantity"+i+"").value='0';
			return false;
		}*/

/*      if(receivedquantity == "")
		{
			alert("Please Enter Received Quantity");
			document.getElementById("receivedquantity"+i+"").focus();
			document.getElementById("savebutton").disabled=false;
			return false; 
		} */
	}
	
} //Kenique 


for(i=1;i<=totalcount5;i++)
{
if(document.getElementById("selectitem"+i+"").checked == true)
{
var batch=document.getElementById("batch"+i+"").value;
if(batch == "")
{
alert("Please Enter batch Number");
document.getElementById("batch"+i+"").focus();
document.getElementById("savebutton").disabled=false;
return false; 
}
}
}
for(i=1;i<=totalcount5;i++)
{
if(document.getElementById("selectitem"+i+"").checked == true)
{
var varItemExpiryDate=document.getElementById("expirydate"+i+"").value;
if(varItemExpiryDate == "")
{
alert("Please Enter Expiry Date");
document.getElementById("expirydate"+i+"").focus();
document.getElementById("savebutton").disabled=false;
return false; 
}

var varItemExpiryDateLength = varItemExpiryDate.length;
	var varItemExpiryDateLength = parseInt(varItemExpiryDateLength);
	if (varItemExpiryDateLength != 5)
	{
		alert ("Expiry Date Not In Format. Please Enter MM/YY Format. Length Should Be Five Characters.");
		document.getElementById("expirydate"+i+"").focus();
		document.getElementById("savebutton").disabled=false;
		return false;
	}
	var varItemExpiryDateArray = varItemExpiryDate.split("/");
	//alert(varItemExpiryDateArray);
	var varItemExpiryDateArrayLength = varItemExpiryDateArray.length;
	//alert(varItemExpiryDateArrayLength);
	if (varItemExpiryDateArrayLength != 2)
	{
		alert ("Expiry Date Not In Format. Please Enter MM/YY Format. Forward Slash Is Missing.");
		document.getElementById("expirydate"+i+"").focus();
		document.getElementById("savebutton").disabled=false;
		return false;
	}
	
	var varItemExpiryDateMonthLength = varItemExpiryDateArray[0];
	//alert(varItemExpiryDateMonthLength);
	var varItemExpiryDateMonthLength = varItemExpiryDateMonthLength.length;
	//alert(varItemExpiryDateMonthLength);
	var varItemExpiryDateMonthLength = parseInt(varItemExpiryDateMonthLength);
	if (varItemExpiryDateMonthLength != 2)
	{
		alert ("Expiry Date Not In Format. Please Enter MM/YY Format. Preceding Zero Is Required Except November & December.");
		document.getElementById("expirydate"+i+"").focus();
		document.getElementById("savebutton").disabled=false;
		return false;
	}
	
	var varItemExpiryDateYearLength = varItemExpiryDateArray[0];
	//alert(varItemExpiryDateYearLength);
	var varItemExpiryDateYearLength = varItemExpiryDateYearLength.length;
	//alert(varItemExpiryDateYearLength);
	var varItemExpiryDateYearLength = parseInt(varItemExpiryDateYearLength);
	if (varItemExpiryDateYearLength != 2)
	{
		alert ("Expiry Date Not In Format. Please Enter MM/YY Format. Simply Give Current Year In Two Digits.");
		document.getElementById("expirydate"+i+"").focus();
		document.getElementById("savebutton").disabled=false;
		return false;
	}
	
	var varItemExpiryDateMonth = varItemExpiryDateArray[0];
	//alert(varItemExpiryDateMonthLength);
	if (isNaN(varItemExpiryDateMonth))
	{
		alert ("Expiry Date Not In Format. Please Enter MM/YY Format. Month Should Be Number.");
		document.getElementById("expirydate"+i+"").focus();
		document.getElementById("savebutton").disabled=false;
		return false;
	}

	var varItemExpiryDateYear = varItemExpiryDateArray[1];
	//alert(varItemExpiryDateYear);
	if (isNaN(varItemExpiryDateYear))
	{
		alert ("Expiry Date Not In Format. Please Enter MM/YY Format. Year Should Be Number.");
		document.getElementById("expirydate"+i+"").focus();
		document.getElementById("savebutton").disabled=false;
		return false;
	}

	
	var varItemExpiryDateMonth = varItemExpiryDateArray[0];
	//alert(varItemExpiryDateMonthLength);
	if (varItemExpiryDateMonth > 12 || varItemExpiryDateMonth == 0)
	{
		alert ("Expiry Month Should Be Between 1 And 12.");
		document.getElementById("expirydate"+i+"").focus();
		document.getElementById("savebutton").disabled=false;
		return false;
	}

	var varItemExpiryDateYear = varItemExpiryDateArray[1];
	//alert(varItemExpiryDateYear);
	if (varItemExpiryDateYear < 13 || varItemExpiryDateYear > 23)
	{
		alert ("Expiry Year Should Be Between 2013 And 2023.");
		document.getElementById("expirydate"+i+"").focus();
		document.getElementById("savebutton").disabled=false;
		return false;
	}
	}
	}
for(i=1;i<=totalcount5;i++)
{
if(document.getElementById("selectitem"+i+"").checked == true)
{
var priceperpack=document.getElementById("priceperpack"+i+"").value;
if(priceperpack == "")
{
alert("Please Enter Price Per Pack");
document.getElementById("priceperpack"+i+"").focus();
document.getElementById("savebutton").disabled=false;
return false; 
}
}
}
document.form.submit();
}

function billnotransfer()
{
var billno = document.getElementById("supplierbillno").value;
document.getElementById("supplierbillno1").value = billno;
var deliverybillno = document.getElementById("deliverybillno").value;
document.getElementById("deliverybillno1").value = deliverybillno;
}

function validationcheck()
{

var varUserChoice; 
	varUserChoice = confirm('Are you sure of saving the entry? Pl note that once saved, Inventory Data will be updated.'); 
	//alert(fRet); 
	if (varUserChoice == false)
	{
		alert ("Entry Not Saved.");
		return false;
	}
	else
	{
		//alert ("Entry Saved.");
		document.cbform1.submit();
		//return true;
	}

}

function storeassign()
{

var store = document.getElementById("store").value;
document.getElementById("store1").value = store;
}
</script>

<style type="text/css">
.bodytext3 {    FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
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
.bodytext21 {
FONT-WEIGHT: normal;FONT-FAMILY: Tahoma;COLOR: #3b3b3c;
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
.bal
{
border-style:none;
background:none;
text-align:right;
FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma;
}
</style>

<script src="js/datetimepicker_css.js"></script>
<?php include ("js/dropdownlist1scriptingpurchaseorder.php"); ?>
<script type="text/javascript" src="js/autocomplete_purchaseorder.js"></script>
<script type="text/javascript" src="js/autosuggestpurchaseorder.js"></script>

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">

		
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
		<td>
		 <form name="cbform1" method="post" action="materialreceivednote.php"> 
		<table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3">
			<tbody>
			  
	 
		
			  <tr>
			 
				<td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Doc No</strong></td>
				<td width="27%" align="left" valign="middle" class="bodytext3"><?php echo $billnumbercode.'-'.$locationprefix; ?>
				<input name="docno" id="docno" value="<?php echo $billnumbercode; ?>" size="10" autocomplete="off" readonly type="hidden"/>                  </td>
				 <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Select PO</strong></td>
				<td colspan="3" align="left" valign="top" >
				<input name="po" id="po" value="<?php echo $billnum; ?>" size="10" rsize="20" autocomplete="off"/>              </td>
			 <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>LPO Date </strong></td>
				<td width="17%" colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $billdate; ?>
				<input name="lpodate" id="lpodate" value="<?php echo $billdate; ?>" size="18" rsize="20" readonly type="hidden"/>               </td>
				</tr>
				<tr>
				<td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Supplier</strong></td>
				<td width="27%" align="left" valign="middle" class="bodytext3"><?php echo $suppliername; ?> & <?php echo $suppliercode; ?>
				<input name="supplier" id="supplier" value="<?php echo $suppliername; ?>" size="25" autocomplete="off" readonly type="hidden"/>    
				<input type="hidden" name="suppliercode" id="suppliercode" value="<?php echo $suppliercode; ?>">           </td>
				 <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Invoice No</strong></td>
				<td colspan="3" align="left" valign="middle" >
				<input name="supplierbillno" id="supplierbillno" value="" size="10" rsize="20" autocomplete="off" onKeyUp="return billnotransfer()"/>               </td>
			 <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>MRN Date </strong></td>
				<td width="17%" colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $dateonly; ?>
				<input name="grndate" id="grndate" value="<?php echo $dateonly; ?>" size="18" rsize="20" readonly type="hidden"/>               </td>
				</tr>
				<tr>
				<td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Address</strong></td>
				<td width="27%" align="left" valign="middle" class="bodytext3"><?php echo $address; ?>
				<input name="address" id="address" value="<?php echo $address; ?>" size="30" autocomplete="off" readonly type="hidden"/>                  </td>
				 <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>DC No</strong></td>
				<td colspan="3" align="left" valign="middle" class="bodytext3"><input name="deliverybillno" id="deliverybillno" value="" size="10" rsize="20" autocomplete="off" onKeyUp="return billnotransfer()"/>
				<input name="telephone" id="telephone" value="<?php echo $tele; ?>" size="25" rsize="20" readonly type="hidden"/>               </td>
			 <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Time </strong></td>
				<td width="17%" colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $timeonly; ?>
				<input name="time" id="time" value="<?php echo $timeonly; ?>" size="18" rsize="20" readonly type="hidden"/>             </td>
				<input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
				</tr>
				<tr>
				<td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Location</strong></td>
				<td width="27%" align="left" valign="middle" class="bodytext3"><?php echo $res5locationname; ?></td>
				   <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Store</strong></td>
				<td colspan="3" width="27%" align="left" valign="middle" class="bodytext3">
				 <select name="store" id="store" onChange="return storeassign()">
			   <option value=""> Select Store</option>
				 <?php
				$query5 = "select * from master_store where location = '$locationanum' and recordstatus = ''";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$storeanum = $res5['auto_number'];
				$store = $res5["store"];
				$storecode = $res5['storecode'];
				?>
				  <option value="<?php echo $storecode; ?>" <?php if($storecodeget==$storecode){echo "selected";}?>><?php echo $store; ?></option>
				  <?php
				}
				?>
				</select></td>
				<td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Currency </strong></td>
				<td width="17%" colspan="3" align="left" valign="middle" class="bodytext3" style="font-size:14px;"><strong><?php echo $currency.' , '.$fxamount; ?></strong>
						</td>
		</tr>
		<tr>
				<td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong></strong></td>
				<td width="27%" align="left" valign="middle" class="bodytext3"></td>
				   <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong></strong></td>
				<td colspan="3" width="27%" align="left" valign="middle" class="bodytext3">
				 </td>
				<td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong> </strong></td>
				<td width="17%" colspan="3" align="left" valign="middle" class="bodytext3" style="font-size:14px;"><strong></strong>
						</td>
		</tr>
		
			</tbody>
		</table>
		</form></td>
	  </tr>
	  <tr>
	  <td>&nbsp;
	  </td>
	  </tr>
	  <tr>
		<td>
		
		<form action="materialreceivednote.php" method="post" name="form" onSubmit="return validationcheck()">
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
			bordercolor="#666666" cellspacing="0" cellpadding="2" width="1200" 
			align="left" border="0">
		  <tbody id="foo">
		 <input type="hidden" name="billnum" value="<?php echo $billnumbercode; ?>">
		 <input type="hidden" name="billdate" value="<?php echo $dateonly; ?>">
		 <input type="hidden" name="suppliername" value="<?php echo $suppliername; ?>">
		 <input type="hidden" name="pono" value="<?php echo $billnum; ?>">
		 <input type="hidden" name="location" value="<?php echo $res5locationcode; ?>">
		 <input type="hidden" name="locationname" value="<?php echo $res5locationname; ?>">
		 <input type="hidden" name="store1" id="store1" value="<?php echo $storecodeget; ?>">
		 <input type="hidden" name="suppliercode" id="suppliercode" value="<?php echo $suppliercode; ?>"> 
		 <input type="hidden" name="accountssubid" value="<?php echo $accountssubid; ?>">
		 <input type="hidden" name="supplierbillno1" id="supplierbillno1">
		 <input name="deliverybillno1" id="deliverybillno1" value="" size="10" type="hidden" rsize="20" autocomplete="off">
		 <input name="fxrate" id="fxrate" value="<?php echo $fxamount; ?>" size="18" rsize="20" readonly type="hidden"/>
		 <input name="currency" id="currency" value="<?php echo $currency; ?>" size="18" rsize="20" readonly type="hidden"/>
		 <input type="hidden" name="purchasetype" id="purchasetype" value="<?php echo $purchasetype; ?>">   
			 <tr>
					   <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Check</strong></td>
					   <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>S.No</strong></td>
					   <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center" width="20%"><strong>Item</strong></td>
					   <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Ord.Qty</strong></td>
					   <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Recd.Qty</strong></td>
					   <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Bal.Qty</strong></td>
					   <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Batch</strong></td>
					   <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Exp.Dt</strong></td>
					  <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Pkg.Size</strong></td>
					   <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Free</strong></td>
					   <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Tot.Qty</strong></td>
					   
					   <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>FX/Pk</strong></td>
					   <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Disc %</strong></td>
					   <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Tax</strong></td>
					   <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Total FX</strong></td>
					   <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Price/Pk</strong></td>
					   
					  <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Total Value</strong></td>
					  <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>High. Cost Price</strong></td>
						<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Cost Price</strong></td>
						<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Sale Price</strong></td>
				</tr>
						<?php
			$colorloopcount = '';
			$sno = 0;
			$totalamount=0; 
			 
			$len = strlen($billnum);
					$str = preg_replace('/[^\\/\-a-z\s]/i', '', $billnum);
					if($str == 'MLPO-')
					{
			//$query76 = "select * from purchaseorder_details where billnumber='$billnum' and recordstatus='generated' and goodsstatus='' and itemstatus <> 'deleted'";
			$query76 = "select * from manual_lpo where billnumber='$billnum' and recordstatus='' and recordstatus <> 'deleted' group by itemcode";
			}
			else
			{
			$query76 = "select * from purchaseorder_details where billnumber='$billnum' and  (recordstatus='autogenerated' || recordstatus='generated') and goodsstatus='' and itemstatus <> 'deleted' group by itemcode";
			}
			$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$number = mysqli_num_rows($exec76);
			while($res76 = mysqli_fetch_array($exec76))
			{
			$_SESSION['materialreceivednotesession']='pending';
			$totalreceivedqty = 0;
			$itemname = $res76['itemname'];
			$itemcode = $res76['itemcode'];
			$rate = $res76['rate'];
			$fxpkrate = $res76['fxpkrate'];
			$packagesize = $res76['packsize'];
			$quantity = 0;
			$amount = 0;
			$packagequantity = 0;
			$fxtotamount = 0; 
			//$packagequantity = $quantity / $packagequantity12;
			//$packagequantity = round($packagequantity);
			$itemanum = $res76['auto_number']; 
			
			if($str == 'MLPO-')
			{
			$query767 = "select * from manual_lpo where billnumber='$billnum' and itemcode = '$itemcode' and recordstatus='' and recordstatus <> 'deleted'";
			}
			else
			{
			$query767 = "select * from purchaseorder_details where billnumber='$billnum' and itemcode = '$itemcode' and (recordstatus='autogenerated' || recordstatus='generated') and goodsstatus='' and itemstatus <> 'deleted'";
			}
			$exec767 = mysqli_query($GLOBALS["___mysqli_ston"], $query767) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$number7 = mysqli_num_rows($exec767);
			while($res767 = mysqli_fetch_array($exec767))
			{
			$quantity = $quantity + $res767['quantity'];
			$amount = $amount + $res767['totalamount'];
			$packagequantity = $packagequantity + $res767['packagequantity'];
			$fxtotamount = $fxtotamount + $res767['fxtotamount']; 
			}
			
			$purchaseindentdocno = $res767['purchaseindentdocno'];
			
			$query99 = "select purchasetype from purchase_indent where docno = '$purchaseindentdocno'";
			$exec99 = mysqli_query($GLOBALS["___mysqli_ston"], $query99) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$number7 = mysqli_num_rows($exec99);
			$res99 = mysqli_fetch_array($exec99);
			$purchasetype = $res99['purchasetype'];
			
			$query444 = "select * from materialreceiptnote_details where itemcode='$itemcode' and ponumber='$billnum'";
			$exec444 = mysqli_query($GLOBALS["___mysqli_ston"], $query444) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num444 = mysqli_num_rows($exec444);
			while($res444 = mysqli_fetch_array($exec444))
			{
			$receivedqty = $res444['quantity'];
			$totalreceivedqty = $totalreceivedqty+$receivedqty;
			}
			
			$balanceqty = $packagequantity - $totalreceivedqty;
			

			//$query77 = "select * from master_medicine where itemcode='$itemcode'";

			echo $query77 = "select a.rateperunit,a.packagename,a.spmarkup,b.taxname,b.taxpercent from master_medicine as a left join master_tax as b on a.taxanum =b.auto_number where itemcode='$itemcode'";

			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res77 = mysqli_fetch_array($exec77);
			if($packagesize == '')
			{
			$packagesize = $res77['packagename'];
			}
			$spmarkup = $res77['spmarkup'];
			
			if($res77['taxpercent']>0)
				$taxpercent=number_format($res77['taxpercent'],2,'.',''); 
			else
				$taxpercent='';
            
			if($taxpercent > 0) {
			  $fxtotamount =$fxtotamount+ ($fxtotamount*($taxpercent/100));
			  $amount =$amount+ ($amount*($taxpercent/100));
			  $fxtotamount = number_format($fxtotamount,2,'.','');
			  $amount = number_format($amount ,2,'.','');
			}else{

			$fxtotamount = number_format($fxtotamount,2,'.','');
			$amount = number_format($amount,2,'.','');
			}

			$query33 = "select max(costprice) as maxcostprice from materialreceiptnote_details where itemcode = '$itemcode'";
			$exec33 =  mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res33 = mysqli_fetch_array($exec33);
			$maxcostprice = number_format($res33['maxcostprice'], 2,'.',''); 
		
?>
<?php $sno = $sno + 1; ?>
  <tr>
		<td class="bodytext31" valign="center"  align="left"><input type="checkbox" class="selectitem" name="selectitem[]" id="selectitem<?php echo $sno ; ?>" value="<?php echo $itemanum.'|'.$itemcode; ?>" onClick="enabletext('<?php echo $sno; ?>','<?php echo $number; ?>')"></td>
		<td class="bodytext31" valign="center"  align="right"><div align="center"><?php echo $sno ; ?></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $itemname; ?></div></td>
		<input type="hidden" name="itemname[]" value="<?php echo $itemname; ?>">
		<input type="hidden" name="itemcode[]" value="<?php echo $itemcode; ?>">
		<input type="hidden" name="selectitemcode[]" value="<?php echo $itemanum.'|'.$itemcode; ?>">
		<input type="hidden" name="rate[]" value="<?php echo $rate; ?>">
		<input type="hidden" name="quantity[]" value="<?php echo $quantity; ?>">
		<input type="hidden" name="totalamount[]" value="<?php echo $amount; ?>">
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $packagequantity; ?></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="receivedquantity[]" id="receivedquantity<?php echo $sno; ?>" size="6" onKeyUp="return totalcalc('<?php echo $sno; ?>');" class="bodytext21" autocomplete="off" onBlur="return totalamount('<?php echo $sno; ?>','<?php echo $number; ?>');" readonly></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $balanceqty; ?><input type="hidden" name="balqty[]" id="balqty<?php echo $sno; ?>" value="<?php echo $balanceqty; ?>"></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="batch[]" id="batch<?php echo $sno; ?>" size="6" class="bodytext21" autocomplete="off" readonly></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="expirydate[]" id="expirydate<?php echo $sno; ?>" size="6" autocomplete="off" readonly></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $packagesize; ?><input type="hidden" name="packsize[]" id="packsize<?php echo $sno; ?>" value="<?php echo $packagesize; ?>"></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="free[]" id="free<?php echo $sno; ?>" size="6" onKeyUp="return totalcalc1('<?php echo $sno; ?>');" class="bodytext21" autocomplete="off" readonly></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="totalquantity[]" id="totalquantity<?php echo $sno; ?>" size="6" class="bodytext21" readonly></div></td>
		
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="fxamount[]" id="fxamount<?php echo $sno; ?>" size="6" onKeyUp="return totalamount('<?php echo $sno; ?>','<?php echo $number; ?>'), checkqty('<?php echo $sno; ?>','<?php echo $number; ?>')" class="bodytext21" autocomplete="off" readonly value="<?php echo number_format($fxpkrate,2,'.',''); ?>"></div>
		<input type="hidden" name="" id="origfxamount<?php echo $sno; ?>" size="6" class="bodytext21" autocomplete="off" readonly value="<?php echo number_format($fxpkrate,2,'.',''); ?>">
		</td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="discount[]" id="discount<?php echo $sno; ?>" size="6" onKeyUp="return totalamountdisc('<?php echo $sno; ?>','<?php echo $number; ?>');" class="bodytext21" autocomplete="off" readonly></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center">
		<?php echo $taxpercent;?>
		<input type="hidden" name="tax[]" id="tax<?php echo $sno; ?>" size="6" onKeyUp="return totalamount20('<?php echo $sno; ?>','<?php echo $number; ?>');" class="bodytext21" autocomplete="off" value='<?php echo $taxpercent;?>' ></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="totalfxamount1[]" id="totalfxamount<?php echo $sno; ?>" size="6" class="bodytext21" readonly value="<?php echo $fxtotamount; ?>"></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="priceperpack[]" id="priceperpack<?php echo $sno; ?>" size="6"  class="bodytext21" autocomplete="off" readonly value="<?php echo $rate; ?>"></div></td>
<!--        onKeyUp="return totalamount('<?php echo $sno; ?>','<?php echo $number; ?>');"  -->
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="totalamount1[]" id="totalamount<?php echo $sno; ?>" size="6" class="bodytext21" readonly value="<?php echo $amount; ?>"></div></td>
		
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="maxcostprice[]" id="maxcostprice<?php echo $sno; ?>" size="6" class="bodytext21" readonly value="<?php echo $maxcostprice; ?>"></div>
		<input type="hidden" name="" id="origmaxcostprice<?php echo $sno; ?>" size="6" class="bodytext21" autocomplete="off" readonly value="<?php echo number_format($maxcostprice,2,'.',''); ?>"></td>
			
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="costprice[]" id="costprice<?php echo $sno; ?>" size="6" class="bodytext21" readonly></div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="center">
		<input type="hidden" name="spmarkup" id="spmarkup<?php echo $sno; ?>" value="<?php echo $spmarkup; ?>"><input type="text" name="saleprice[]" id="saleprice<?php echo $sno; ?>" size="6" class="bodytext21" readonly></div></td>
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
				 <td class="bodytext31" valign="center"  align="center" 
				bgcolor="#ecf0f5"></td>
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
				bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
				bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
				bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
				bgcolor="#ecf0f5">&nbsp;</td>
			   </tr>
		   
		  </tbody>
	   </table> 
					
				  <tr>
	  <td>&nbsp;
	  </td>
	  </tr>
	  <tr>
	  <td>
	  <table width="716">
	 <tr>
	 <td width="20" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Total Purchase Cost</td>
	   <td width="111" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="text" name="totalpurchaseamount" id="totalpurchaseamount" size="10" readonly></td>
		 
	 </tr>
	 <td width="20" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Total FX Purchase Cost</td>
	   <td width="111" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="text" name="totalfxamount" id="totalfxamount" size="10" readonly></td>
		 
	 </tr>
		</table>
		</td>
		</tr>               
				
	  <tr>
		
		 <td colspan="2" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
		  <input type="hidden" name="frmflag2" value="frmflag2">
			   <input name="Submit222" type="submit"  value="Save" class="button" id="savebutton" onClick="return funcsave('<?php echo $number; ?>')"/>      </td>
	  </tr>
	  </table>
		</form>
		 </td>
	  </tr>
	  </td>
	  </tr>
  
  </table>

<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>