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

if (isset($_SESSION["goodsreceivednotesession"])) { $goodsreceivednotesession = $_SESSION["goodsreceivednotesession"]; } else { $goodsreceivednotesession = ""; }

//$frmflag2 = $_POST['frmflag2'];



if ($frmflag2 == 'frmflag2')

{

//$billnumber = $_REQUEST['billnum'];

if($goodsreceivednotesession=='pending')

{

$_SESSION['goodsreceivednotesession']='completed';

$store = $_REQUEST['store1'];



$job_title = $_REQUEST['jobtitle'];



//$billdate = $_REQUEST['billdate'];

$billdate = $_POST['grndate1'];

$suppliername = $_REQUEST['suppliername'];

$suppliercode = $_REQUEST['suppliercode'];

$supplieranum = $_REQUEST['supplieranum'];

$ponumber = $_REQUEST['pono'];

$accountssubid = $_REQUEST['accountssubid'];

$supplierbillno = $_REQUEST['supplierbillno1'];

$amount = $_REQUEST['totalpurchaseamount'];

$deliverybillno = $_REQUEST['deliverybillno1'];

$currency = $_REQUEST['currency'];

$fxrate = $_REQUEST['fxrate'];

$mrnno = $_REQUEST['mrnno'];

$totalfxamount = $_REQUEST['totalfxamount'];

if (isset($_REQUEST["expense"])) { $expense = $_REQUEST["expense"]; } else { $expense = ""; }

if (isset($_REQUEST["expenseno"])) { $expensecode = $_REQUEST["expenseno"]; } else { $expensecode = ""; }

if (isset($_REQUEST["expenseanum"])) { $expenseanum = $_REQUEST["expenseanum"]; } else { $expenseanum = ""; }





$amount = 0;

$totalfxamount = 0;



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

if($supplierbillno=='')

{

$query5 = "select * from materialreceiptnote_details where billnumber = '$mrnno' order by billnumber";

$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res5 = mysqli_fetch_array($exec5);

$supplierbillno =$res5['supplierbillnumber']; 

$deliverybillno =$res5['deliverybillno'];				



}



$query3 = "select * from master_company where companystatus = 'Active'";

$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

$res3 = mysqli_fetch_array($exec3);

$paynowbillprefix = 'GRN-';

$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select * from purchase_details where typeofpurchase='Process' order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["billnumber"];

$billdigit=strlen($billnumber);

if ($billnumber == '')

{

	$billnumbercode ='GRN-'.'1'.'-'.$locationprefix;

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

	

	

	$billnumbercode = 'GRN-' .$maxanum.'-'.$locationprefix;

	$openingbalance = '0.00';

	//echo $companycode;

}



$purchasetype = $_REQUEST['purchasetype'];



$mrnwise_amount = 0;

$mrnwise_totalfxamount = 0;

$mrn_arr = array();

foreach($_POST['itemname'] as $key=>$value)

{

$itemname = $_POST['itemname'][$key];

$itemcode = $_POST['itemcode'][$key];

$selitemcode = $_POST['selitemcode'][$key];

$autoid     = $_POST['autoid'][$key];

foreach($_POST['selectitem'] as $check=>$value1)

{

$selectitem = $_POST['selectitem'][$check];



if($selitemcode == $selectitem)

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

$salesprice = $_POST['saleprice'][$key];

$costprice = $_POST['costprice'][$key];

$expirydate = $_POST['expirydate'][$key];

$fxamount1 = $_POST['fxamount'][$key];

$totalfxpuramount = $_POST['totalfxamount1'][$key];

$vattype=$_POST['vattype'][$key];
$whv=$_POST['whv'][$key];
$wht=$_POST['wht'][$key];

$whv_explode = explode('|', $whv);
$whv_id=$whv_explode[0];
$whv_value=$whv_explode[1];

 $wh_fetch_per_total=$rate*$quantity;

//  $query_whv_fetch = "SELECT * from master_withholding_tax where tax_id = '$whv'";
// $exec_whv_fetch = mysql_query($query_whv_fetch) or die ("Error in Query_whv_fetch".mysql_error());
// $res_whv_fetch = mysql_fetch_array($exec_whv_fetch);
// $whv_percentage = $res_whv_fetch['tax_percentage'];

// $whv_per=($whv_percentage/100);
 $whv_amount=($wh_fetch_per_total/100)*$whv_value;

// $query_wht_fetch = "SELECT * from master_withholding_tax where tax_id = '$wht'";
// $exec_wht_fetch = mysql_query($query_wht_fetch) or die ("Error in Query_wht_fetch".mysql_error());
// $res_wht_fetch = mysql_fetch_array($exec_wht_fetch);
//  $wht_percentage = $res_wht_fetch['tax_percentage'];

// $wht_per=($wht_percentage/100);
 $wht_explode = explode('|', $wht);
$wht_id=$wht_explode[0];
$wht_value=$wht_explode[1];
$wht_amount=($wh_fetch_per_total/100)*$wht_value;

$fifocode = $_POST['fifocode'][$key];

			$expirymonth = substr($expirydate, 0, 2);

			$expiryyear = substr($expirydate, 3, 2);

			$expiryday = '01';

			$expirydate = $expiryyear.'-'.$expirymonth.'-'.$expiryday;

$ponumber = $_POST['ponumber'][$key];

$mrnno = $_POST['mrnnumber'][$key];


$expense = $_POST['expense'][$key];
$expensecode = $_POST['expenseno'][$key];
$expenseanum = $_POST['expenseanum'][$key];




$purchasetypee = $_POST['purchasetype'][$key];

if(!in_array($mrnno, $mrn_arr))

$mrn_arr[] = $mrnno;



// calculate mrnwise total

//if(!in_array($mrnno, $mrn_arr))

//{

	$mrnamt[$mrnno][]   = $mrnwise_amount + $totalamount;

	$mrnfxamt[$mrnno][] = $mrnwise_totalfxamount + $totalfxpuramount;

//}



$amount = $amount + $totalamount;// calculate grand total

$totalfxamount = $totalfxamount + $totalfxpuramount; // calculate grand fxtotal





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

/*$asset = $_POST['asset'];
echo '<pre>';print_r($asset);
*/
$ledgeranum = $_POST['ledgeranum'][$key];

$ledgercode = $_POST['ledgercode'][$key];

$ledgername = $_POST['ledgername'][$key];



			$query31 = "select * from master_itempharmacy where itemcode = '$itemcode'"; 

			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res31 = mysqli_fetch_array($exec31);

			$itemunitabb = $res31['unitname_abbreviation'];

			$res31packageanum = $res31['packageanum'];

			$categoryname = $res31['categoryname'];



			//$packagename = addslashes($packagename);

			$query32 = "select * from master_packagepharmacy where auto_number = '$res31packageanum'";//packagename = '$packagename'";

			$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query32".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res32 = mysqli_fetch_array($exec32);

			$packageanum = $res32['auto_number'];

			$quantityperpackage = $res32['quantityperpackage'];



		

			$querystock2 = "select fifo_code from transaction_stock where docstatus='New Batch' order by auto_number desc limit 0, 1";

			$execstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querystock2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			$resstock2 = mysqli_fetch_array($execstock2);

			//$fifo_code = $resstock2["fifo_code"];

			if ($fifo_code == '')

			{		

				$fifo_code = '1';

				$queryupdatecumstock2 = "update transaction_stock set cum_stockstatus='0' where itemcode='$itemcode' and locationcode='$locationcode'";

				//$execupdatecumstock2 = mysql_query($queryupdatecumstock2) or die ("Error in updateCumQuery2".mysql_error());

				

				$stockquery2="INSERT into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,

				batchnumber, batch_quantity, 

				transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,rate,totalprice)

				values ('$fifo_code','purchase_details','$itemcode', '$itemname', '$updatedate','1', 'Purchase', 

				'$batchnumber', '$allpackagetotalquantity', '$allpackagetotalquantity', 

				'$allpackagetotalquantity', '$billnumbercode', 'New Batch','1','1', '$locationcode','','$store1', '', '$username', '$ipaddress','$updatedate','$updatetime','$updatedatetime','$salesprice','$totalamount')";

				

				//$stockexecquery2=mysql_query($stockquery2) or die(mysql_error());

				}

				else

				{

				$querycumstock2 = "select sum(batch_quantity) as cum_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$locationcode'";

				$execcumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querycumstock2) or die ("Error in CumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

				$rescumstock2 = mysqli_fetch_array($execcumstock2);

				$cum_quantity = $rescumstock2["cum_quantity"];

				$cum_quantity = $allpackagetotalquantity+$cum_quantity;

				$fifo_code = $fifo_code + 1;

				

				$queryupdatecumstock2 = "update transaction_stock set cum_stockstatus='0' where itemcode='$itemcode' and locationcode='$locationcode'";

				//$execupdatecumstock2 = mysql_query($queryupdatecumstock2) or die ("Error in updateCumQuery2".mysql_error());

				

				$stockquery2="INSERT into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,

				batchnumber, batch_quantity, 

				transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,rate,totalprice)

				values ('$fifo_code','purchase_details','$itemcode', '$itemname', '$updatedate','1', 'Purchase', 

				'$batchnumber', '$allpackagetotalquantity', '$allpackagetotalquantity', 

				'$cum_quantity', '$billnumbercode', 'New Batch','1','1', '$locationcode','','$store1', '', '$username', '$ipaddress','$updatedate','$updatetime','$updatedatetime','$salesprice','$totalamount')";

				

				//$stockexecquery2=mysql_query($stockquery2) or die(mysql_error());

				

				

			}

			

			$query4 = "INSERT into purchase_details (bill_autonumber, companyanum, 

			billnumber, itemanum, itemcode, itemname, itemdescription, rate, quantity, 

			subtotal, free, discountpercentage, discountrupees, openingstock, closingstock, totalamount, 

			discountamount, username, ipaddress, entrydate, itemtaxpercentage, itemtaxamount, unit_abbreviation, 

			batchnumber, salesprice, expirydate, vat_type_id, wh_vat_id, wh_vat_value, wh_tax_id, wh_tax_value  , itemfreequantity, itemtotalquantity, 

			packageanum, packagename, quantityperpackage, allpackagetotalquantity, 

			manufactureranum, manufacturername,typeofpurchase,suppliername,suppliercode,supplieranum ,ponumber,supplierbillnumber,costprice,locationcode,store,coa,categoryname,fifo_code,totalfxamount,deliverybillno,mrnno,ledgeranum,ledgercode,ledgername,expense,expensecode,expenseanum,job_title) 

			values ('$billautonumber', '$companyanum', '$billnumbercode', '$itemanum', '$itemcode', '$itemname', '$itemdescription', '$rate', '$quantity', 

			'$totalamount', '$free', '$itemdiscountpercent', '$itemdiscountrupees', '$opening

			stock', '$closingstock', 

			'$totalamount', '$discountamount', '$username', '$ipaddress', '$billdate', 

			'$itemtaxpercent', '$itemtaxamount', '$itemunitabb', 

			'$batchnumber', '$salesprice', '$expirydate',

			'$vattype', '$whv_id', '$whv_amount', '$wht_id', '$wht_amount',

			 '$free', '$quantity', 

			'$packageanum', '$packagename', '$quantityperpackage', '$allpackagetotalquantity', 

			'$manufactureranum', '$manufacturername','Process','$suppliername','$suppliercode','$supplieranum','$ponumber','$supplierbillno','$costprice','$locationcode','$store1','$coa','$categoryname','$fifo_code','$totalfxpuramount','$deliverybillno','$mrnno','$ledgeranum','$ledgercode','$ledgername','$expense','$expensecode','$expenseanum','$job_title')";

			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

			

			$query56 = "update purchaseorder_details set grnstatus='$itemstatus' where billnumber='$ponumber' and itemcode='$itemcode'";

		

			

			$query56 = "update materialreceiptnote_details set grnstatus='completed' where auto_number=$autoid";

			$exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			

			$query561 = "update master_itempharmacy set rateperunit='$salesprice',purchaseprice='$costprice' where itemcode='$itemcode'";

			$exec561 = mysqli_query($GLOBALS["___mysqli_ston"], $query561) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			

			$locationrate = $locationcode.'_rateperunit';

			$query562 = "update master_medicine set rateperunit='$salesprice',`$locationrate`='$salesprice',purchaseprice='$costprice' where itemcode='$itemcode'";

			


			
			if(strtoupper($purchasetypee) == 'ASSETS')

			{

				$asset = $_POST['asset'][$key];
				$assetcode = $_POST['assetno'][$key];
				$assetanum = $_POST['assetanum'][$key];

				/*echo strtoupper($purchasetypee).'<br>';
				echo 'asset'.$asset.'<br>';
				echo 'assetcode'.$assetcode.'<br>';
				echo 'assetanum'.$assetanum.'<br>';*/
				$query4asset = "insert into assets_register (bill_autonumber, companyanum, 

				billnumber, itemanum, itemcode, itemname, itemdescription, rate, quantity, 

				subtotal, free, discountpercentage, discountrupees, openingstock, closingstock, totalamount, 

				discountamount, username, ipaddress, entrydate, itemtaxpercentage, itemtaxamount, unit_abbreviation, 

				batchnumber, salesprice, expirydate, itemfreequantity, itemtotalquantity, 

				packageanum, packagename, quantityperpackage, allpackagetotalquantity, 

				manufactureranum, manufacturername,typeofpurchase,suppliername,suppliercode,supplieranum ,ponumber,supplierbillnumber,costprice,locationcode,store,coa,categoryname,fifo_code,totalfxamount,deliverybillno,mrnno,assetledger,assetledgercode,assetledgeranum) 

				values ('$billautonumber', '$companyanum', '$billnumbercode', '$itemanum', '$itemcode', '$itemname', '$itemdescription', '$rate', '$quantity', 

				'$totalamount', '$free', '$itemdiscountpercent', '$itemdiscountrupees', '$opening

				stock', '$closingstock', 

				'$totalamount', '$discountamount', '$username', '$ipaddress', '$billdate', 

				'$itemtaxpercent', '$itemtaxamount', '$itemunitabb', 

				'$batchnumber', '$salesprice', '$expirydate', '$free', '$quantity', 

				'$packageanum', '$packagename', '$quantityperpackage', '$allpackagetotalquantity', 

				'$manufactureranum', '$manufacturername','Process','$suppliername','$suppliercode','$supplieranum','$ponumber','$supplierbillno','$costprice','$locationcode','$store1','$coa','$categoryname','$fifo_code','$totalfxpuramount','$deliverybillno','$mrnno','$asset','$assetcode','$assetanum')";
				//echo $query4asset.'<br>';

				$exec4asset = mysqli_query($GLOBALS["___mysqli_ston"], $query4asset) or die ("Error in Query4asset".mysqli_error($GLOBALS["___mysqli_ston"]));

			}

			

}



}



}



		foreach ($mrnamt as $mrnnumber => $mrn) {

			$tot = 0;

			foreach ($mrn as $k => $val) {

				$tot = $tot + $val;

			}

			$subtot_mrnamt[$mrnnumber] = $tot;

		}



		foreach ($mrnfxamt as $mrnnumber1 => $mrn1) {

			$tot = 0;

			foreach ($mrn1 as $k1 => $val1) {

				$tot = $tot + $val1;

			}

			$subtot_mrnfxamt[$mrnnumber1] = $tot;

		}

		foreach ($mrn_arr as $key => $mrnno) {

			



		$amount        =  $subtot_mrnamt[$mrnno];

		$totalfxamount =  $subtot_mrnfxamt[$mrnno];



		$transactiontype = 'PAYMENT';

		$transactionmode = 'CREDIT';

		$particulars = 'BY CREDIT (Inv NO:'.$billnumbercode.$supplierbillnumber.')';	

		//include ("transactioninsert1.php");

		$query9 = "INSERT into master_transactionpharmacy (transactiondate, particulars, supplieranum, suppliername, 

		transactionmode, transactiontype, transactionamount, creditamount,balanceamount,

		billnumber, billanum, ipaddress, updatedate,  companyanum, companyname, transactionmodule,suppliercode,currency,fxrate,totalfxamount,mrnno) 

		values ('$updatedatetime', '$particulars', '$accountssubid', '$suppliername', 

		'$transactionmode', '$transactiontype', '$amount', '$amount', '$amount',

		'$billnumbercode',  '$billautonumber', '$ipaddress', '$updatedate', '$companyanum', '$companyname', '$transactionmodule1','$suppliercode','$currency','$fxrate','$totalfxamount','$mrnno')";

		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

		

		$transactiontype = 'PURCHASE';

		$transactionmode = 'BILL';

		$particulars = 'BY PURCHASE (Inv NO:'.$billnumbercode.$supplierbillnumber.')';	

		//include ("transactioninsert1.php");

		$query9 = "insert into master_transactionpharmacy (transactiondate, particulars, supplieranum, suppliername, 

		transactionmode, transactiontype, transactionamount,

		billnumber, billanum, ipaddress, updatedate,  companyanum, companyname, transactionmodule,suppliercode,currency,fxrate,totalfxamount,mrnno) 

		values ('$updatedatetime', '$particulars', '$accountssubid', '$suppliername', 

		'$transactionmode', '$transactiontype', '$amount', 

		'$billnumbercode',  '$billautonumber', '$ipaddress', '$updatedate', '$companyanum', '$companyname', '$transactionmodule1','$suppliercode','$currency','$fxrate','$totalfxamount','$mrnno')";

		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

		

		$query3 = "insert into master_purchase (companyanum, billnumber, billdate, suppliercode, suppliername,totalamount,totalquantity,ipaddress,supplierbillnumber,typeofpurchase,currency,fxrate,totalfxamount,locationcode,locationname,purchaseamount,expense,expensecode,expenseanum,mrnno)values('$companyanum','$billnumbercode','$updatedatetime','$suppliercode', '$suppliername','$amount','$quantity','$ipaddress','$supplierbillno','Process','$currency','$fxrate','$totalfxamount','$locationcode','$locationname','$amount','$expense','$expensecode','$expenseanum','$mrnno')";

		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));



		}







		

}



header("location:goodsreceivednote.php");

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



$supplier_code = $_POST['suppliercode'];



	/*$searchpo = $_POST['po'];

	$searchpo = trim($searchpo);

	$len1 = strlen($searchpo);

					$str1 = preg_replace('/[^\\/\-a-z\s]/i', '', $searchpo);*/

					

					/*if($str1 == 'MLPO-')

					{

//$query5 = "select * from purchaseorder_details where billnumber = '$searchpo' and recordstatus='generated' order by billnumber";

$query5 = "select * from manual_lpo where billnumber = '$searchpo' and recordstatus='' order by billnumber";

}

else

{

$query5 = "select * from materialreceiptnote_details where billnumber = '$searchpo' order by billnumber";

}*/

$query5 = "select * from materialreceiptnote_details where suppliercode='$supplier_code' order by billnumber";

$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res5 = mysqli_fetch_array($exec5))

{

	//echo "yes";

	$billnum = $res5["billnumber"];

	$suppliername = $res5['suppliername'];

	$suppliercode = $res5['suppliercode'];

	$supplieranum = $res5['supplieranum'];

    $suppliername = strtoupper($suppliername);

    $billdate = $res5['entrydate'];

	$res5locationcode = $res5['locationcode'];

	$res5locationname = $res5['location'];

	$currency = $res5['currency'];

	$fxamount = $res5['fxamount'];	

	$deliverybillno = $res5['deliverybillno'];	

	$purchasetype=$res5['purchasetype'];

	$ponumber = $res5['ponumber'];

	$supplierbillnumber = $res5['supplierbillnumber'];

	if($currency=='')

	{

		$currency='UGX';

		$fxamount='1';

	}

	if($str1 != 'MLPO-')

	{

		$storename = $res5['store'];	

		$storecodeget = $res5['store'];

	}

	

	$query66 = "select * from master_location where locationcode = '$res5locationcode'";

	$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res66 = mysqli_fetch_array($exec66);

	$locationprefix = $res66['prefix'];

	$res5locationname = $res66['locationname'];

	

	$query66 = "select * from master_store where storecode = '$storecodeget'";

	$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res66 = mysqli_fetch_array($exec66);

	$storename = $res66['store'];

		

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

$paynowbillprefix = 'GRN-';

$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select * from purchase_details where typeofpurchase='Process' order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["billnumber"];

$billdigit=strlen($billnumber);

if ($billnumber == '')

{

	$billnumbercode ='GRN-'.'1';

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

	

	

	$billnumbercode = 'GRN-' .$maxanum;

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

include("autocompletebuild_mrn.php");



?>



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

	//funcPopupPrintFunctionCall();

	

}





</script>

<script>

/*function totalcalc(varserialnumber)

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

*/



function totalamount(varserialnumber2,totalcount)

{



var grandtotaladjamt = 0;

var grandtotalfxadjamt = 0;

var varserialnumber2 = varserialnumber2;

var totalcount = totalcount;

for(i=1;i<=totalcount;i++)

{

	if(document.getElementById("selectitem"+i+"").checked==true)

	{

		var totaladjamount=document.getElementById("totalamount"+i+"").value;

		var totaladjfxamount=document.getElementById("totalfxamount"+i+"").value;

		if(totaladjamount == "")

		{

			totaladjamount=0;

		}

		grandtotaladjamt=grandtotaladjamt+parseFloat(totaladjamount);

		grandtotalfxadjamt = parseFloat(grandtotalfxadjamt)+parseFloat(totaladjfxamount);

	}

}

document.getElementById("totalpurchaseamount").value = grandtotaladjamt.toFixed(2);

document.getElementById("totalfxamount").value = grandtotalfxadjamt.toFixed(2);



// format prices

document.getElementById("totalpurchaseamountnew").value = formatMoney(grandtotaladjamt.toFixed(2));

document.getElementById("totalfxamountnew").value = formatMoney(grandtotalfxadjamt.toFixed(2));

}



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



/*function totalamountdisc(varserialnumber3,totalcount1)

{



var totalcount1 = totalcount1;

var grandtotaladjamt1 = 0;

var varserialnumber3 = varserialnumber3;

var grandtotalfxadjamt = 0;

var receivedqty3 = document.getElementById("receivedquantity"+varserialnumber3+"").value;

var priceperpack3 = document.getElementById("priceperpack"+varserialnumber3+"").value;

var fxrate = document.getElementById("fxrate").value;

var fxamount = document.getElementById("fxamount"+varserialnumber3+"").value;

var totalamount3 = parseFloat(receivedqty3) * parseFloat(fxamount);



var packsize3=document.getElementById("packsize"+varserialnumber3+"").value;

var packvalue3=packsize3.substring(0,packsize3.length - 1);

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

grandtotaladjamt1=grandtotaladjamt1+parseFloat(totaladjamount);

grandtotalfxadjamt = parseFloat(grandtotalfxadjamt)+parseFloat(totaladjfxamount);



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

var totalamount4 = parseFloat(receivedqty4) * parseFloat(fxamount);

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

grandtotaladjamt2=grandtotaladjamt2+parseFloat(totaladjamount);

grandtotalfxadjamt = parseFloat(grandtotalfxadjamt)+parseFloat(totaladjfxamount);

}

document.getElementById("totalpurchaseamount").value = grandtotaladjamt2.toFixed(2);

document.getElementById("totalfxamount").value = grandtotalfxadjamt.toFixed(2);

}

*/



function funcsave(totalcount5)

{

var totalcount5 =totalcount5;

/*if(document.getElementById("po").value =='')

{

alert("Please Select Purchase Order");

document.getElementById("po").focus();

document.getElementById("savebutton").disabled=false;

return false;

}*/

if(document.getElementById("supplierbillno").value =='')

{

alert("Please Enter Supplier Invoice Number");

document.getElementById("supplierbillno").focus();

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

if(document.getElementById("expenseno") !=null && (document.getElementById("purchasetype").value=='Expenses' || document.getElementById("purchasetype").value=='Others'))

{

if(document.getElementById("expenseno").value =='' || document.getElementById("expenseno").value =='0')

{

alert("Please Select Expense Name");

document.getElementById("expense").focus();

return false;

}

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

if(!(document.getElementById("purchasetype").value=='Expenses' || document.getElementById("purchasetype").value=='Others'))

{

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

document.getElementById("savebutton").disabled=true;



var totalitemscnt = $('#totalitems').val();

var chkflag = "false";

for(i=1;i<=totalitemscnt;i++)

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



if(document.getElementById("supplierbillno").value =='')

{

alert("Please Enter Supplier Invoice Number");

document.getElementById("supplierbillno").focus();

document.getElementById("savebutton").disabled=false;

return false;

}



if(document.getElementById("grndate").value =='')

{

alert("Please Choose Invoice Date");

document.getElementById("grndate").focus();

document.getElementById("savebutton").disabled=false;

return false;

}

else

{

	var grndate = document.getElementById("grndate").value;

	document.getElementById("grndate1").value = grndate;

}

if(document.getElementById("deliverybillno").value =='')

{

alert("Please Enter Delivery Number");

document.getElementById("deliverybillno").focus();

document.getElementById("savebutton").disabled=false;

return false;

}

var varUserChoice; 

	varUserChoice = confirm('Are you sure of saving the entry? Pl note that once saved, Financial Data will be updated.'); 

	//alert(fRet); 

	if (varUserChoice == false)

	{

		alert ("Entry Not Saved.");

		document.getElementById("savebutton").disabled=false;

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

<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>

<script src="js/datetimepicker_css_fin.js"></script>

<?php include ("js/dropdownlist1scriptingpurchaseorder.php"); ?>

<script type="text/javascript" src="js/autocomplete_mrn.js"></script>

<script type="text/javascript" src="js/autosuggestpurchaseorder.js"></script>



<script type="text/javascript" src="js/jquery.min-autocomplete.js"></script>

<script type="text/javascript" src="js/jquery-ui.min.js"></script>

<script type="text/javascript">


function exp(id){
	var id= id;
$('#expense'+id).autocomplete({

	source:'autoexpensesearch.php', 

	select: function(event,ui){

			var code = ui.item.id;

			var anum = ui.item.anum;

			$('#expenseno'+id).val(code);

			$('#expenseanum'+id).val(anum);

			},

	html: true

    });
};

function asset(id){
	var id= id;
$('#asset'+id).autocomplete({

	source:'autoassetsearch.php', 

	select: function(event,ui){

			var code = ui.item.id;

			var anum = ui.item.anum;

			$('#assetno'+id).val(code);

			$('#assetanum'+id).val(anum);

			},

	html: true

    });
};
$(function() {

billnotransfer();


$('#supplier').autocomplete({

	source:'ajaxsuppliernewserach.php', 

	select: function(event,ui){

			var code = ui.item.id;

			var anum = ui.item.anum;

			$('#suppliercode').val(code);

			$('#supplieranum').val(anum);

			this.form.submit();

			},

	html: true

});





});

</script>
<script src="js/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script language="javascript">

$(function() {

    $('#vattype').autocomplete({
		
	source:'ajax_vattype.php', 
	
	minLength:2,
	delay: 0,
	html: true, 
		select: function(event,ui){
				var vatauto=ui.item.vatauto;
				var vatid=ui.item.vatid;
				$('#vattypeautoid').val(vatauto);	
				$('#vatid').val(vatid);	
			}
    });
});
</script>
</head>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />

<link rel="stylesheet" type="text/css" href="css/autocomplete.css" />        

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

		 <form name="cbform1" method="post" action="goodsreceivednote.php"> 

		<table width="1000" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3">

            <tbody>

              

	 

		

			  <tr>

			 

			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Doc No</strong></td>

                <td width="27%" align="left" valign="middle" class="bodytext3"><?php echo $billnumbercode.'-'.$locationprefix; ?>

				<input name="docno" id="docno" value="<?php echo $billnumbercode; ?>" size="10" autocomplete="off" readonly type="hidden"/>                  </td>

                <!--  <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Select MRN</strong></td>

                <td colspan="3" align="left" valign="top" >

				<input name="po" id="po" value="<?php echo $billnum; ?>" size="10" rsize="20" autocomplete="off"/>				</td> -->

				 <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Supplier</strong></td>

                <td width="27%" align="left" valign="middle" class="bodytext3">

                	<input  type="text" name="supplier" id="supplier" value="<?php echo $suppliername; ?>" size="25" autocomplete="off" style="text-transform:uppercase;width:300px" /> 

			  

				<input type="hidden" name="suppliercode" id="suppliercode" value="<?php echo $suppliercode; ?>">  

				<input type="hidden" name="supplieranum" id="supplieranum" value="<?php echo $supplieranum; ?>">         </td>

				 <td >&nbsp;</td>

				<td >&nbsp;</td>

             <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>MRN Date </strong></td>

                <td width="17%" colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $billdate; ?>

				<input name="lpodate" id="lpodate" value="<?php echo $billdate; ?>" size="18" rsize="20" readonly type="hidden"/>				</td>

			    </tr>

				<tr>

			   <td >&nbsp;</td>

				<td >&nbsp;</td>

                 <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Invoice No</strong></td>

                <td colspan="3" align="left" valign="middle" >

				<!-- <input name="supplierbillno" id="supplierbillno" value="<?php echo $supplierbillnumber; ?>" size="10" rsize="20" autocomplete="off" onKeyUp="return billnotransfer()"/> -->	

				<input name="supplierbillno" id="supplierbillno" value="" size="10" rsize="20" autocomplete="off" onKeyUp="return billnotransfer()"/>			</td>

             <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Invoice Date </strong></td>

                <td width="17%" colspan="3" align="left" valign="middle" class="bodytext3">

                <input name="grndate" id="grndate" size="10"  readonly/>

           <img src="images2/cal.gif" onClick="javascript:NewCssCal('grndate','yyyyMMdd','','','','','past','07-01-2019','<?php echo date('m-d-Y');?>')" style="cursor:pointer"/>



				<!-- <input name="grndate" id="grndate" value="<?php echo $dateonly; ?>" size="18" rsize="20" readonly type="hidden"/> -->				</td>

			    </tr>

				<tr>

			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Address</strong></td>

                <td width="27%" align="left" valign="middle" class="bodytext3"><?php echo $address; ?>

				<input name="address" id="address" value="<?php echo $address; ?>" size="30" autocomplete="off" readonly type="hidden"/>                  </td>

                 <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>DC No</strong></td>

                <td colspan="3" align="left" valign="middle" class="bodytext3"><!-- <input name="deliverybillno" id="deliverybillno" value="<?php echo $deliverybillno; ?>" size="10" rsize="20" autocomplete="off" onKeyUp="return billnotransfer()"/> -->

                	<input name="deliverybillno" id="deliverybillno" value="" size="10" rsize="20" autocomplete="off" onKeyUp="return billnotransfer()"/>

				<input name="telephone" id="telephone" value="<?php echo $tele; ?>" size="25" rsize="20" readonly type="hidden"/>				</td>

             <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Time </strong></td>

                <td width="17%" colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $timeonly; ?>

				<input name="time" id="time" value="<?php echo $timeonly; ?>" size="18" rsize="20" readonly type="hidden"/>				</td>

				<input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                </tr>

				<tr>

			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Location</strong></td>

                <td width="27%" align="left" valign="middle" class="bodytext3"><?php echo $res5locationname; ?></td>

				   <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Store</strong></td>

                <td colspan="3" width="27%" align="left" valign="middle" class="bodytext3">

				 <select name="store" id="store" onChange="return storeassign()" <?php if(trim($purchasetype)!='Expenses' && trim($purchasetype)!='Others'){echo 'disabled';}?>>

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

		<form action="goodsreceivednote.php" method="post" name="form" onSubmit="return validationcheck()">

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="2" width="1200" 

            align="left" border="0">

          <tbody id="foo">

		 <input type="hidden" name="billnum" value="<?php echo $billnumbercode; ?>">

		 <input type="hidden" name="billdate" value="<?php echo $dateonly; ?>">

		 <input type="hidden" name="grndate1" id="grndate1" value="<?php echo $dateonly; ?>">

		 

		 <input type="hidden" name="suppliername" value="<?php echo $suppliername; ?>">

		<!--  <input type="hidden" name="pono" value="<?php echo $ponumber; ?>"> -->

         <!-- <input type="hidden" name="mrnno" value="<?php echo $billnum; ?>"> -->

		 <input type="hidden" name="location" value="<?php echo $res5locationcode; ?>">

		 <input type="hidden" name="locationname" value="<?php echo $res5locationname; ?>">

		 <input type="hidden" name="store1" id="store1" value="<?php echo $storecodeget; ?>">

		 <input type="hidden" name="suppliercode" id="suppliercode" value="<?php echo $suppliercode; ?>"> 

		 <input type="hidden" name="accountssubid" value="<?php echo $accountssubid; ?>">

		 <input type="hidden" name="supplierbillno1" id="supplierbillno1">

         <input name="deliverybillno1" id="deliverybillno1" value="<?php echo $deliverybillno; ?>" size="10" type="hidden" rsize="20" autocomplete="off">

         <input name="fxrate" id="fxrate" value="<?php echo $fxamount; ?>" size="18" rsize="20" readonly type="hidden"/>

         <input name="currency" id="currency" value="<?php echo $currency; ?>" size="18" rsize="20" readonly type="hidden"/>

		 <input type="hidden" name="purchasetype" id="purchasetype" value="<?php echo $purchasetype; ?>">

		 <tr>

			    <td colspan="3" width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Purchase type</strong></td>

                <td colspan="3" width="27%" align="left" valign="middle" class="bodytext3"><?php echo strtoupper(trim($purchasetype));?> </td>

				<?php if(trim($purchasetype) == 'Expenses' || trim($purchasetype)=='Others')

				{

				?>

				   <!-- <td colspan="2" align="left" width="14%"   valign="middle" colspan=""  bgcolor="#ecf0f5" class="bodytext3"><strong>Select Expense</strong></td>

                    <td colspan="3" align="left" width="22%"  valign="middle" colspan="" class="bodytext3">

                    <input name="expense" id="expense" value="" size="30" rsize="40" autocomplete="off"/>

                    <input name="expenseno" id="expenseno" value="" type="hidden" />

					<input name="expenseanum" id="expenseanum" value="" type="hidden" />

                     </td> -->

					 <?php

					 }

					 else

					 {

					 ?>

					 <td colspan="2" width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong></strong></td>

                <td width="27%" align="left" valign="middle" class="bodytext3"></td>

					 <?php

					 }

					 ?>

                <td colspan="2" width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong> </strong></td>

                <td width="17%" colspan="3" align="left" valign="middle" class="bodytext3" style="font-size:14px;"><strong></strong>

						</td>

		</tr>	
		<?php  $mgr_find1 = preg_replace('/[^\\/\-a-z\s]/i', '', $billnum);
					if($mgr_find1 == 'MGR-'){
		 ?>

             <tr>

		              <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>&nbsp;</strong></td>

					   <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>S.No</strong></td>

                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center" width="20%"><strong>Item</strong></td>

                       

                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Recd.Qty</strong></td>

					   

                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Expense Ledger</strong></td>

                       <!-- <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Exp.Dt</strong></td>

                      <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Pkg.Size</strong></td>

                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Free</strong></td> -->

                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Tot.Qty</strong></td>

					   

                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>FX (Units)</strong></td>

					   <!-- <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Disc %</strong></td> -->

					   <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Tax</strong></td>

					    <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>VAT Type</strong></td>
					     <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>WH VAT</strong></td>
					      <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>WH TAX</strong></td>

                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Total FX</strong></td>

                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Price (Units)</strong></td>

                       

					  <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Total Value</strong></td>

						<!-- <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Cost Price</strong></td>

						<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Sale Price</strong></td> -->

				</tr>
			<?php }else{  ?>
				<tr>

		              <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>&nbsp;</strong></td>

					   <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>S.No</strong></td>

                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center" width="20%"><strong>Item</strong></td>

                       

                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Recd.Qty</strong></td>

					   

					   <?php //if(strtoupper($purchasetype) == 'ASSETS') { ?>

					   	 <td id="assetledgertd" bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Asset Ledger</strong></td>
					  <?php // } ?>

					    

                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Batch</strong></td>

                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Exp.Dt</strong></td>

                      <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Pkg.Size</strong></td>

                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Free</strong></td>

                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Tot.Qty</strong></td>

					   

                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>FX (Units)</strong></td>

					   <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Disc %</strong></td>

					   <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Tax</strong></td>

					    <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>VAT Type</strong></td>
					     <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>WH VAT</strong></td>
					      <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>WH TAX</strong></td>

                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Total FX</strong></td>

                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Price (Units)</strong></td>

                       

					  <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Total Value</strong></td>

						<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Cost Price</strong></td>

						<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Sale Price</strong></td>

				</tr>
			<?php } ?>

				  		<?php

			$colorloopcount = '';

			$sno = 0;

			$totalamount=0;	

			 $grandtotal=0;

			 $grandtotalfx=0;

			$len = strlen($billnum);

					$str = preg_replace('/[^\\/\-a-z\s]/i', '', $billnum);

			$items_cnt = 0;

			$assets_cntr = 0;

			if ($cbfrmflag1 == 'cbfrmflag1'){

				$suppliercode = $_POST['suppliercode'];

				



				if(trim($suppliercode) !="" )

				{

					if($str == 'MLPO-')

					{

					//$query76 = "select * from purchaseorder_details where billnumber='$billnum' and recordstatus='generated' and goodsstatus='' and itemstatus <> 'deleted'";

					$query76 = "select * from manual_lpo where billnumber='$billnum' and recordstatus='' and recordstatus <> 'deleted'";

					}

					else

					{

					//$query76 = "select * from materialreceiptnote_details where billnumber='$billnum' and itemstatus <> 'deleted'";

					$query76 = "select billnumber from materialreceiptnote_details where suppliercode='$suppliercode' and itemstatus <> 'deleted' group by billnumber order by auto_number DESC";

					}

					$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));



					// to find the total number of items

					$totitems_qry = "select auto_number from materialreceiptnote_details where suppliercode='$suppliercode' and grnstatus='' and itemstatus <> 'deleted'";

					$exec_itemscnt = mysqli_query($GLOBALS["___mysqli_ston"], $totitems_qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

					$number = mysqli_num_rows($exec_itemscnt);

					while($respo = mysqli_fetch_array($exec76))

					{

					$mrn_number = $respo['billnumber'];

					$mgr_find = preg_replace('/[^\\/\-a-z\s]/i', '', $mrn_number);
					if($mgr_find == 'MGR-'){

						$qry_pos = "select * from materialreceiptnote_details where billnumber='$mrn_number' and grnstatus='' and itemstatus <> 'deleted'";

											$exec_po = mysqli_query($GLOBALS["___mysqli_ston"], $qry_pos) or die(mysqli_error($GLOBALS["___mysqli_ston"]));



											$numrows = mysqli_num_rows($exec_po);

											if($numrows)

											{ ?>



											 <tr>

									              <td colspan="3" class="bodytext31" valign="center"  align="left" 

									                bgcolor="#ecf0f5"><?php  echo $mrn_number;?></td>

									              <td colspan="11" class="bodytext31" valign="center"  align="left" 

									                bgcolor="#ecf0f5">&nbsp;</td>

							                 </tr>

											<?php 

											}

											while($res76 = mysqli_fetch_array($exec_po))

											{

											$totalreceivedqty = 0;

											$_SESSION['goodsreceivednotesession']='pending';

											$itemname = $res76['itemname'];

											$itemcode = $res76['itemcode'];

											$rate = $res76['rate'];

											$quantity = $res76['quantity'];

											$packagesize = '';

											$amount = $res76['totalamount'];

											$packagequantity = $res76['quantity'];

											$ponumber = $res76['ponumber'];

											$allpackagetotalquantity = $res76['allpackagetotalquantity'];

											$fxpkrate = $res76['fxpkrate'];

											$priceperpk = $res76['priceperpk'];

											$free = $res76['free'];

											$batchnumber = $res76['batchnumber'];

											$expirydate = $res76['expirydate'];

											$totalfxamount = $res76['totalfxamount'];

											$salesprice = $res76['salesprice'];

											$costprice = $res76['costprice'];

											$itemtaxpercentage = $res76['itemtaxpercentage'];

											$discountpercentage = $res76['discountpercentage'];

											$itemtotalquantity = $res76['itemtotalquantity'];

											$fifocode = $res76['fifocode'];

											$job_title = $res76['job_title'];

											$grandtotalfx = $grandtotalfx + $totalfxamount;

											$grandtotal = $grandtotal + $amount;

											$year = date('y', strtotime($expirydate));

											$month = date('m', strtotime($expirydate));

											$expirydate=$month.'/'.$year;

											//$packagequantity = $quantity / $packagequantity12;

											//$packagequantity = round($packagequantity);

											$ledgeranum = '';

											$ledgercode = $res76['incomeledgercode'];

											$ledgername = $res76['incomeledger'];

											$purchasetype = $res76['purchasetype'];

											$anum = $res76['auto_number'];

											

											$mrn_no = $res76['billnumber'];

											$query444 = "select * from purchase_details where itemcode='$itemcode' and ponumber='$ponumber'";

											$exec444 = mysqli_query($GLOBALS["___mysqli_ston"], $query444) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

											$num444 = mysqli_num_rows($exec444);

											while($res444 = mysqli_fetch_array($exec444))

											{

											$receivedqty = $res444['quantity'];

											$totalreceivedqty = $totalreceivedqty+$receivedqty;

											}

											

											$balanceqty = $packagequantity - $totalreceivedqty;

											



											$query77 = "select * from master_medicine where itemcode='$itemcode'";

											$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

											$res77 = mysqli_fetch_array($exec77);

											if($packagesize == '')

											{

											$packagesize = $res77['packagename'];

											}

											$spmarkup = $res77['spmarkup'];

										

									

							?>

							<?php $sno = $sno + 1; ?>

							  <tr>

							  		

							  		<td><input type="checkbox" class="selectitem" name="selectitem[]" id="selectitem<?php echo $sno ; ?>" value="<?php echo $itemcode.$anum; ?>" onClick="totalamount('<?php echo $sno; ?>','<?php echo $number; ?>')"></td>

									<td class="bodytext31" valign="center"  align="right"> <div align="center"><?php echo $sno ; ?>

							       

							        </div></td>

									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $itemname; ?></div></td>

									<input type="hidden" name="itemname[]" value="<?php echo $itemname; ?>">

									<input type="hidden" name="itemcode[]" value="<?php echo $itemcode; ?>">

									<input type="hidden" name="selitemcode[]" value="<?php echo $itemcode.$anum; ?>">

									<input type="hidden" name="autoid[]" value="<?php echo $anum; ?>">

									<input type="hidden" name="mrnnumber[]" value="<?php echo $mrn_no; ?>">

									<input type="hidden" name="ponumber[]" value="<?php echo $ponumber; ?>">

									<input type="hidden" name="rate[]" value="<?php echo $rate; ?>">

									<input type="hidden" name="quantity[]" value="<?php echo $quantity; ?>">

									<input type="hidden" name="totalamount[]" value="<?php echo $amount; ?>">

							        <input type="hidden" name="fifocode[]" value="<?php echo $fifocode; ?>">

							        <input type="hidden" name="ledgeranum[]" value="<?php echo $ledgeranum; ?>">

									<input type="hidden" name="ledgercode[]" value="<?php echo $ledgercode; ?>">

									<input type="hidden" name="ledgername[]" value="<?php echo $ledgername; ?>">

									<input type="hidden" name="jobtitle" value="<?php echo $job_title; ?>">



									

									<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="receivedquantity[]" id="receivedquantity<?php echo $sno; ?>" size="6"  class="bodytext21" autocomplete="off" readonly value="<?php echo $itemtotalquantity; ?>"></div></td>

									<!--onKeyUp="return totalcalc('<?php echo $sno; ?>');"-->

							        

									<input type="hidden" name="balqty[]" id="balqty<?php echo $sno; ?>" value="<?php echo $balanceqty; ?>">

							        

									<input type="hidden" name="batch[]" id="batch<?php echo $sno; ?>" size="6" class="bodytext21" autocomplete="off" readonly  value="<?php echo $batchnumber; ?>">



                    <td class="bodytext31" valign="center"  align="left">

                    <input name="expense[]" id="expense<?=$sno;?>" onClick="exp(<?=$sno;?>)" value="" size="30" rsize="40" autocomplete="off"/>

                    <input name="expenseno[]" id="expenseno<?=$sno;?>" value="" type="hidden" />

					<input name="expenseanum[]" id="expenseanum<?=$sno;?>" value="" type="hidden" />

                     </td>

							        

									<input type="hidden" name="expirydate[]" id="expirydate<?php echo $sno; ?>" size="6" autocomplete="off" readonly  value="<?php echo $expirydate; ?>">

							        

									<input type="hidden" name="packsize[]" id="packsize<?php echo $sno; ?>" value="<?php echo $packagesize; ?>" readonly>

							        

									<input type="hidden" name="free[]" id="free<?php echo $sno; ?>" size="6"  class="bodytext21" autocomplete="off" readonly value="<?php echo $free; ?>"> 

									<!--onKeyUp="return totalcalc1('<?php echo $sno; ?>');"-->

							        

									<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="totalquantity[]" id="totalquantity<?php echo $sno; ?>" size="6" class="bodytext21" readonly  value="<?php echo $allpackagetotalquantity; ?>"></div></td>

									

							        <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="fxamount[]" id="fxamount<?php echo $sno; ?>" size="6"  class="bodytext21" autocomplete="off" readonly value="<?php echo $fxpkrate; ?>"></div></td>

									<!--onKeyUp="return totalamount('<?php echo $sno; ?>','<?php echo $number; ?>');"-->

							        

									<input type="hidden" name="discount[]" id="discount<?php echo $sno; ?>" size="6"  class="bodytext21" autocomplete="off" readonly value="<?php echo $discountpercentage; ?>">

							        <!--onKeyUp="return totalamountdisc('<?php echo $sno; ?>','<?php echo $number; ?>');"-->

									<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="tax[]" id="tax<?php echo $sno; ?>" size="6"  class="bodytext21" autocomplete="off" readonly value="<?php echo $itemtaxpercentage; ?>"></div></td>

							 <!--onKeyUp="return totalamount20('<?php echo $sno; ?>','<?php echo $number; ?>');"-->   

							 		<td class="bodytext31" valign="center"  align="left"><div align="center">
							 			<!-- <input type="text" name="vattype[]" id="vattype" size="6"  class="bodytext21" > -->
							 			<!-- <input type="text" name="saccountname" id="accountname" size="30"  /> -->
							                        <!-- <input type="hidden" name="vattypeautoid" id="vattypeautoid" /> -->
							                        <select name="vattype[]" id="vattype<?php echo $sno; ?>"  style="width: 80px;">
							                        	<option value="">--Select--</option>
							                        	<?php 
							                        	$query_vat_pur = "SELECT * from master_vat where flag='purchase' order by vat";
																$exec_vat_pur = mysqli_query($GLOBALS["___mysqli_ston"], $query_vat_pur) or die ("Error in query_vat_pur".mysqli_error($GLOBALS["___mysqli_ston"]));
																while ($res_vat_pur = mysqli_fetch_array($exec_vat_pur))
																{ ?>
															<option value="<?=$res_vat_pur['vat_id'];?>"><?=$res_vat_pur['vat'];?></option>
																<?php }
																	?>
							                        </select>

							 		</div></td>
							 		<td class="bodytext31" valign="center"  align="left"><div align="center">
							                        <select name="whv[]" id="whv<?php echo $sno; ?>" style="width: 80px;">
							                        	<option value="">--Select--</option>
							                        	<?php 
							                        	$query_whv = "SELECT * from master_withholding_tax where type='1' order by name";
																$exec_whv = mysqli_query($GLOBALS["___mysqli_ston"], $query_whv) or die ("Error in query_whv".mysqli_error($GLOBALS["___mysqli_ston"]));
																while ($res_whv = mysqli_fetch_array($exec_whv))
																{ ?>
															<option value="<?=$res_whv['tax_id']."|".$res_whv['tax_percent'] ;?>"><?=$res_whv['name']." -- ".$res_whv['tax_percent'] ;?>%</option>
																<?php }
																	?>
							                        </select>

							 		</div></td>

							 		<td class="bodytext31" valign="center"  align="left"><div align="center">
							                        <select name="wht[]" id="wht<?php echo $sno; ?>" style="width: 80px;">
							                        	<option value="">--Select--</option>
							                        	<?php 
							                        	$query_wht = "SELECT * from master_withholding_tax where type='0' order by name";
																$exec_wht = mysqli_query($GLOBALS["___mysqli_ston"], $query_wht) or die ("Error in query_wht".mysqli_error($GLOBALS["___mysqli_ston"]));
																while ($res_wht = mysqli_fetch_array($exec_wht))
																{ ?>
															<option value="<?=$res_wht['tax_id']."|".$res_wht['tax_percent'] ;?>"><?=$res_wht['name']." -- ".$res_wht['tax_percent'] ;?>%</option>
																<?php }
																	?>
							                        </select>

							 		</div></td>
							 	 

							        <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="totalfxamount1[]" id="totalfxamount<?php echo $sno; ?>" size="6" class="bodytext21" readonly  value="<?php echo $totalfxamount; ?>"></div></td>

							        

							        <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="priceperpack[]" id="priceperpack<?php echo $sno; ?>" size="6"  class="bodytext21" autocomplete="off" readonly value="<?php echo $fxpkrate; ?>"></div></td>

							        

									<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="totalamount1[]" id="totalamount<?php echo $sno; ?>" size="6" class="bodytext21" readonly value="<?php echo $amount; ?>"></div></td>

							        

										

									<!-- <td class="bodytext31" valign="center"  align="left"><div align="center"> -->
										<input type="hidden" name="costprice[]" id="costprice<?php echo $sno; ?>" size="6" class="bodytext21" readonly value="<?php echo $costprice; ?>">
									<!-- </div></td> -->

							        

									<!-- <td class="bodytext31" valign="center"  align="left"><div align="center"> -->

									<input type="hidden" name="spmarkup" id="spmarkup<?php echo $sno; ?>" value="<?php echo $spmarkup; ?>">
									<input type="hidden" name="saleprice[]" id="saleprice<?php echo $sno; ?>" size="6" class="bodytext21" readonly value="<?php echo $salesprice; ?>">
								<!-- </div></td> -->

												</tr>

										<?php 

									$items_cnt = $items_cnt + 1;

										}

									

									?>


				<?php	}else{



					?>



               <?php 

               

               $qry_pos = "select * from materialreceiptnote_details where billnumber='$mrn_number' and grnstatus='' and itemstatus <> 'deleted'";

				$exec_po = mysqli_query($GLOBALS["___mysqli_ston"], $qry_pos) or die(mysqli_error($GLOBALS["___mysqli_ston"]));



				$numrows = mysqli_num_rows($exec_po);

				if($numrows)

				{ ?>



				 <tr>

		              <td colspan="3" class="bodytext31" valign="center"  align="left" 

		                bgcolor="#ecf0f5"><?php  echo $mrn_number;?></td>

		              <td colspan="18" class="bodytext31" valign="center"  align="left" 

		                bgcolor="#ecf0f5">&nbsp;</td>

                 </tr>

				<?php 

				}

				while($res76 = mysqli_fetch_array($exec_po))

				{

				$totalreceivedqty = 0;

				$_SESSION['goodsreceivednotesession']='pending';

				$itemname = $res76['itemname'];

				$itemcode = $res76['itemcode'];

				$rate = $res76['rate'];

				$quantity = $res76['quantity'];

				$packagesize = '';

				$amount = $res76['totalamount'];

				$packagequantity = $res76['quantity'];

				$ponumber = $res76['ponumber'];

				$allpackagetotalquantity = $res76['allpackagetotalquantity'];

				$fxpkrate = $res76['fxpkrate'];

				$priceperpk = $res76['priceperpk'];

				$free = $res76['free'];

				$batchnumber = $res76['batchnumber'];

				$expirydate = $res76['expirydate'];

				$totalfxamount = $res76['totalfxamount'];

				$salesprice = $res76['salesprice'];

				$costprice = $res76['costprice'];

				$itemtaxpercentage = $res76['itemtaxpercentage'];

				$discountpercentage = $res76['discountpercentage'];

				$itemtotalquantity = $res76['itemtotalquantity'];

				$fifocode = $res76['fifocode'];

				$job_title = $res76['job_title'];

				$grandtotalfx = $grandtotalfx + $totalfxamount;

				$grandtotal = $grandtotal + $amount;

				$year = date('y', strtotime($expirydate));

				$month = date('m', strtotime($expirydate));

				$expirydate=$month.'/'.$year;

				//$packagequantity = $quantity / $packagequantity12;

				//$packagequantity = round($packagequantity);

				$ledgeranum = '';

				$ledgercode = $res76['incomeledgercode'];

				$ledgername = $res76['incomeledger'];

				$purchasetype = $res76['purchasetype'];

				$anum = $res76['auto_number'];

				

				$mrn_no = $res76['billnumber'];

				$query444 = "select * from purchase_details where itemcode='$itemcode' and ponumber='$ponumber'";

				$exec444 = mysqli_query($GLOBALS["___mysqli_ston"], $query444) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				$num444 = mysqli_num_rows($exec444);

				while($res444 = mysqli_fetch_array($exec444))

				{

				$receivedqty = $res444['quantity'];

				$totalreceivedqty = $totalreceivedqty+$receivedqty;

				}

				

				$balanceqty = $packagequantity - $totalreceivedqty;

				



				$query77 = "select * from master_medicine where itemcode='$itemcode'";

				$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				$res77 = mysqli_fetch_array($exec77);

				if($packagesize == '')

				{

				$packagesize = $res77['packagename'];

				}

				$spmarkup = $res77['spmarkup'];

			

		

?>

<?php $sno = $sno + 1; ?>

  <tr>

  		

  		<td><input type="checkbox" class="selectitem" name="selectitem[]" id="selectitem<?php echo $sno ; ?>" value="<?php echo $itemcode.$anum; ?>" onClick="totalamount('<?php echo $sno; ?>','<?php echo $number; ?>')"></td>

		<td class="bodytext31" valign="center"  align="right"> <div align="center"><?php echo $sno ; ?>

       

        </div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $itemname; ?></div></td>

		<input type="hidden" name="itemname[]" value="<?php echo $itemname; ?>">

		<input type="hidden" name="itemcode[]" value="<?php echo $itemcode; ?>">

		<input type="hidden" name="selitemcode[]" value="<?php echo $itemcode.$anum; ?>">

		<input type="hidden" name="autoid[]" value="<?php echo $anum; ?>">

		<input type="hidden" name="mrnnumber[]" value="<?php echo $mrn_no; ?>">

		<input type="hidden" name="ponumber[]" value="<?php echo $ponumber; ?>">

		<input type="hidden" name="rate[]" value="<?php echo $rate; ?>">

		<input type="hidden" name="quantity[]" value="<?php echo $quantity; ?>">

		<input type="hidden" name="totalamount[]" value="<?php echo $amount; ?>">

        <input type="hidden" name="fifocode[]" value="<?php echo $fifocode; ?>">

        <input type="hidden" name="ledgeranum[]" value="<?php echo $ledgeranum; ?>">

		<input type="hidden" name="ledgercode[]" value="<?php echo $ledgercode; ?>">

		<input type="hidden" name="ledgername[]" value="<?php echo $ledgername; ?>">

		<input type="hidden" name="jobtitle" value="<?php echo $job_title; ?>">

		 <input type="hidden" name="purchasetype[]" id="purchasetype<?php echo $sno; ?>" value="<?php echo $purchasetype; ?>">

		

		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="receivedquantity[]" id="receivedquantity<?php echo $sno; ?>" size="6"  class="bodytext21" autocomplete="off" readonly value="<?php echo $itemtotalquantity; ?>"></div></td>

		<!--onKeyUp="return totalcalc('<?php echo $sno; ?>');"-->
		 <?php 


		 if(strtoupper($purchasetype) == 'ASSETS') { 
		 	$assets_cntr = $assets_cntr + 1;
		 	?>
		 	
			<td class="bodytext31" valign="center"  align="left">

                    <input name="asset[]" id="asset<?=$sno;?>" onClick="asset(<?=$sno;?>)" value="" size="30" rsize="40" autocomplete="off"/>

                    <input name="assetno[]" id="assetno<?=$sno;?>" value="" type="hidden" />

					<input name="assetanum[]" id="assetanum<?=$sno;?>" value="" type="hidden" />

            </td>
	    <?php  }

	    else{ ?>
	    	
	    		 <input name="asset[]" id="asset<?=$sno;?>" value="" type="hidden" />
	    		<input name="assetno[]" id="assetno<?=$sno;?>" value="" type="hidden" />

					<input name="assetanum[]" id="assetanum<?=$sno;?>" value="" type="hidden" />
	    	
	   <?php  } ?>
          


		<input type="hidden" name="balqty[]" id="balqty<?php echo $sno; ?>" value="<?php echo $balanceqty; ?>">

        

		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="batch[]" id="batch<?php echo $sno; ?>" size="6" class="bodytext21" autocomplete="off" readonly  value="<?php echo $batchnumber; ?>"></div></td>

        

		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="expirydate[]" id="expirydate<?php echo $sno; ?>" size="6" autocomplete="off" readonly  value="<?php echo $expirydate; ?>"></div></td>

        

		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $packagesize; ?><input type="hidden" name="packsize[]" id="packsize<?php echo $sno; ?>" value="<?php echo $packagesize; ?>" readonly></div></td>

        

		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="free[]" id="free<?php echo $sno; ?>" size="6"  class="bodytext21" autocomplete="off" readonly value="<?php echo $free; ?>"></div></td>

		<!--onKeyUp="return totalcalc1('<?php echo $sno; ?>');"-->

        

		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="totalquantity[]" id="totalquantity<?php echo $sno; ?>" size="6" class="bodytext21" readonly  value="<?php echo $allpackagetotalquantity; ?>"></div></td>

		

        <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="fxamount[]" id="fxamount<?php echo $sno; ?>" size="6"  class="bodytext21" autocomplete="off" readonly value="<?php echo $fxpkrate; ?>"></div></td>

		<!--onKeyUp="return totalamount('<?php echo $sno; ?>','<?php echo $number; ?>');"-->

        

		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="discount[]" id="discount<?php echo $sno; ?>" size="6"  class="bodytext21" autocomplete="off" readonly value="<?php echo $discountpercentage; ?>"></div></td>

        <!--onKeyUp="return totalamountdisc('<?php echo $sno; ?>','<?php echo $number; ?>');"-->

		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="tax[]" id="tax<?php echo $sno; ?>" size="6"  class="bodytext21" autocomplete="off" readonly value="<?php echo $itemtaxpercentage; ?>"></div></td>

 <!--onKeyUp="return totalamount20('<?php echo $sno; ?>','<?php echo $number; ?>');"-->   

 		<td class="bodytext31" valign="center"  align="left"><div align="center">
 			<!-- <input type="text" name="vattype[]" id="vattype" size="6"  class="bodytext21" > -->
 			<!-- <input type="text" name="saccountname" id="accountname" size="30"  /> -->
                        <!-- <input type="hidden" name="vattypeautoid" id="vattypeautoid" /> -->
                        <select name="vattype[]" id="vattype<?php echo $sno; ?>"  style="width: 80px;">
                        	<option value="">--Select--</option>
                        	<?php 
                        	$query_vat_pur = "SELECT * from master_vat where flag='purchase' order by vat";
									$exec_vat_pur = mysqli_query($GLOBALS["___mysqli_ston"], $query_vat_pur) or die ("Error in query_vat_pur".mysqli_error($GLOBALS["___mysqli_ston"]));
									while ($res_vat_pur = mysqli_fetch_array($exec_vat_pur))
									{ ?>
								<option value="<?=$res_vat_pur['vat_id'];?>"><?=$res_vat_pur['vat'];?></option>
									<?php }
										?>
                        </select>

 		</div></td>
 		<td class="bodytext31" valign="center"  align="left"><div align="center">
                        <select name="whv[]" id="whv<?php echo $sno; ?>" style="width: 80px;">
                        	<option value="">--Select--</option>
                        	<?php 
                        	$query_whv = "SELECT * from master_withholding_tax where type='1' order by name";
									$exec_whv = mysqli_query($GLOBALS["___mysqli_ston"], $query_whv) or die ("Error in query_whv".mysqli_error($GLOBALS["___mysqli_ston"]));
									while ($res_whv = mysqli_fetch_array($exec_whv))
									{ ?>
								<option value="<?=$res_whv['tax_id']."|".$res_whv['tax_percent'] ;?>"><?=$res_whv['name']." -- ".$res_whv['tax_percent'] ;?>%</option>
									<?php }
										?>
                        </select>

 		</div></td>

 		<td class="bodytext31" valign="center"  align="left"><div align="center">
                        <select name="wht[]" id="wht<?php echo $sno; ?>" style="width: 80px;">
                        	<option value="">--Select--</option>
                        	<?php 
                        	$query_wht = "SELECT * from master_withholding_tax where type='0' order by name";
									$exec_wht = mysqli_query($GLOBALS["___mysqli_ston"], $query_wht) or die ("Error in query_wht".mysqli_error($GLOBALS["___mysqli_ston"]));
									while ($res_wht = mysqli_fetch_array($exec_wht))
									{ ?>
								<option value="<?=$res_wht['tax_id']."|".$res_wht['tax_percent'] ;?>"><?=$res_wht['name']." -- ".$res_wht['tax_percent'] ;?>%</option>
									<?php }
										?>
                        </select>

 		</div></td>
 	 

        <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="totalfxamount1[]" id="totalfxamount<?php echo $sno; ?>" size="6" class="bodytext21" readonly  value="<?php echo $totalfxamount; ?>"></div></td>

        

        <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="priceperpack[]" id="priceperpack<?php echo $sno; ?>" size="6"  class="bodytext21" autocomplete="off" readonly value="<?php echo $fxpkrate; ?>"></div></td>

        

		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="totalamount1[]" id="totalamount<?php echo $sno; ?>" size="6" class="bodytext21" readonly value="<?php echo $amount; ?>"></div></td>

        

			

		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="costprice[]" id="costprice<?php echo $sno; ?>" size="6" class="bodytext21" readonly value="<?php echo $costprice; ?>"></div></td>

        

		<td class="bodytext31" valign="center"  align="left"><div align="center">

		<input type="hidden" name="spmarkup" id="spmarkup<?php echo $sno; ?>" value="<?php echo $spmarkup; ?>"><input type="text" name="saleprice[]" id="saleprice<?php echo $sno; ?>" size="6" class="bodytext21" readonly value="<?php echo $salesprice; ?>"></div></td>

					</tr>

			<?php 

		$items_cnt = $items_cnt + 1;

			}
			} // else condition of the mgr numbers

		} // while


		?>

		<input type="hidden" name="totalitems" id="totalitems" value="<?php echo $items_cnt; ?>">
		<input type="hidden" id="assets_cnt" value="<?php echo $assets_cntr; ?>">
<?php 
		
		} // for supplier if condition ends  

	} // for submit ends

		?>
		<?php  $mgr_find1 = preg_replace('/[^\\/\-a-z\s]/i', '', $billnum);
					if($mgr_find1 == 'MGR-'){
		 ?><tr>

              <td colspan="14" class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
          </tr>
          <?php }else{ ?>
 
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

               </tr>
           <?php } ?>

           

          </tbody>

        </table>	</td>

      </tr>

				    

				  <tr>

	  <td>&nbsp;

	  </td>

	  </tr>

      <tr>

	  <td>

	  <table width="716">

     <tr>

	 <td width="20" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Total Purchase Cost</td>

	   <td width="111" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="hidden" name="totalpurchaseamount" id="totalpurchaseamount" size="10" value="" readonly align="right">

	   <input type="text" name="totalpurchaseamountnew" id="totalpurchaseamountnew" size="10" value="" readonly align="right"></td>

	     

	 </tr>

     <td width="20" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Total FX Purchase Cost</td>

	   <td width="111" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="hidden" name="totalfxamount" id="totalfxamount" size="10" value="" readonly>

	   	<input type="text" name="totalfxamountnew" id="totalfxamountnew" size="10" value="" readonly>

	   </td>

	     

	 </tr>

		</table>

		</td>

		</tr>				

		        

      <tr>

        

		 <td colspan="2" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

		  <input type="hidden" name="frmflag2" value="frmflag2">

             <!--   <input name="Submit222" type="submit"  value="Save" id="savebutton" class="button" onClick="return funcsave('<?php echo $items_cnt; ?>')"/>	 -->

                <input name="Submit222" type="submit"  value="Save" id="savebutton" class="button"/>	 </td>

      </tr>

	  </table>

      </td>

      </tr>

    </form>

  </table>

<script type="text/javascript">
	
	$(function() {

		var assets_cnt = $('#assets_cnt').val();

		if(parseInt(assets_cnt) > 0)
		{
			$('#assetledgertd').show();

		}
		else
		{
			$('#assetledgertd').hide();
		}
	});
</script>

<?php include ("includes/footer1.php"); ?>

<?php //include ("print_bill_dmp4inch1.php"); ?>

</body>

</html>

