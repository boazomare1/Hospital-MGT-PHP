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

$ipaddress = $_SERVER["REMOTE_ADDR"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];

$financialyear = $_SESSION["financialyear"];

$balanceamount = 0;

$cashamount21 = '';

$cardamount21 = '';

$onlineamount21 = '';

$chequeamount21 = '';

$tdsamount21 = '';

$writeoffamount21 = '';

$taxamount21 = '';

$titlestr = 'SALES BILL';



$docno=$_SESSION["docno"];

$query01="select locationcode from login_locationdetails where docno ='$docno' and username='$username' order by auto_number desc";
$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
$res01=mysqli_fetch_array($exc01);
$main_locationcode = $res01['locationcode'];

$query018="select auto_number from master_location where locationcode='$main_locationcode'";
$exc018=mysqli_query($GLOBALS["___mysqli_ston"], $query018);
$res018=mysqli_fetch_array($exc018);
$location_auto = $res018['auto_number'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

//$frmflag2 = $_POST['frmflag2'];



if ($frmflag2 == 'frmflag2')

{ 

$billnumber = $_REQUEST['billnum'];

$billdate = $_REQUEST['billdate'];

$suppliername = $_REQUEST['suppliername'];

$query101 = "select * from master_accountname where accountname = '$suppliername'";

	$exec101 = mysqli_query($GLOBALS["___mysqli_ston"], $query101) or die ("Error in Query101".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res101 = mysqli_fetch_array($exec101);

	$suppliercode = $res101['id'];

	

	

	$query1 = "select * from master_accountname where id='$suppliercode'";

	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_num_rows());

	$res1 = mysqli_fetch_array($exec1);

	$accountssubanum = $res1['accountssub'];

	

	$query11 = "select * from master_accountssub where auto_number='$accountssubanum'";

	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	$res11 = mysqli_fetch_array($exec11);

	$accountssubid = $res11['id'];

	

	

$grnnumber = $_REQUEST['grnno'];

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



$locationcode = $_REQUEST['locationcode'];

$locationname = $_REQUEST['locationname'];

$storeanum = $_REQUEST['store'];



$query751 = "select * from master_financialintegration where field='grt'";

$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res751 = mysqli_fetch_array($exec751);

$coa = $res751['code'];



foreach($_POST['itemname'] as $key=>$value)

{

$itemname = $_POST['itemname'][$key];

$itemcode = $_POST['itemcode'][$key];

 $query5 = "select * from master_itempharmacy where itemcode = '$itemcode'"; 

			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res5 = mysqli_fetch_array($exec5);

			$itemanum = $res5['auto_number'];

			foreach($_POST['returncheckbox'] as $check)

			{

			$acknow = $check;

			if($acknow == $itemcode)

			{

$rate = $_POST['costprice'][$key];

$quantity = $_POST['returnqty'][$key];



$amount = $_POST['totalamount'][$key];



$itemdiscountpercent = $_POST['discount'][$key];

$balqty = $_POST['balqty'][$key];

$fifo_code = $_POST['fifo_code'][$key];

if($balqty == $quantity)

{

$itemstatus = 'received';

}

else

{

$itemstatus = '';

}



$batchnumber = $_POST['batch'][$key];

$salesprice = $_POST['saleprice'][$key];

$expirydate = $_POST['expirydate'][$key];

$packagename = $_POST['packsize'][$key];



$ledgeranum = $_POST['ledgeranum'][$key];

$ledgercode = $_POST['ledgercode'][$key];

$ledgername = $_POST['ledgername'][$key];

$incomeledger =$_POST['incomeledger'][$key];

$incomeledgercode = $_POST['incomeledgercode'][$key];



 			$query31 = "select * from master_itempharmacy where itemcode = '$itemcode'"; 

			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res31 = mysqli_fetch_array($exec31);

			$itemunitabb = $res31['unitname_abbreviation'];

		    $res31packageanum = $res31['auto_number'];

			$categoryname = $res31['categoryname'];



			//$packagename = addslashes($packagename);

			$query32 = "select * from master_packagepharmacy where auto_number = '$res31packageanum' "; //packagename = '$packagename'";

			$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query32".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res32 = mysqli_fetch_array($exec32);

			$packageanum = $res32['auto_number'];

			$quantityperpackage = $res32['quantityperpackage'];

			$returnqty = $quantity; 

            $itemsubtotal = $quantity * $rate;

if(($returnqty != '')&&($returnqty != 0))

{

			

			$querycumstock2 = "select sum(batch_quantity) as cum_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$locationcode'";

			$execcumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querycumstock2) or die ("Error in CumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

			$rescumstock2 = mysqli_fetch_array($execcumstock2);

			$cum_quantity = $rescumstock2["cum_quantity"];

			$cum_quantity = $cum_quantity-$returnqty;

			if($cum_quantity=='0'){ $cum_stockstatus='0'; }else{$cum_stockstatus='1';}

			if($cum_quantity>='0')

			{

			$querybatstock2 = "select batch_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$locationcode' and fifo_code='$fifo_code' and storecode='$storeanum'";

			$execbatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querybatstock2) or die ("Error in batQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

			$resbatstock2 = mysqli_fetch_array($execbatstock2);

			$bat_quantity = $resbatstock2["batch_quantity"];

			$bat_quantity = $bat_quantity-$returnqty;

			

			if($bat_quantity=='0'){ $batch_stockstatus='0'; }else{$batch_stockstatus='1';}

			if($bat_quantity>='0')

			{

			$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' ,batch_stockstatus='0' where itemcode='$itemcode' and locationcode='$locationcode' and fifo_code='$fifo_code' and storecode='$storeanum'";

			$execupdatebatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatebatstock2) or die ("Error in updatebatQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

			

			$queryupdatecumstock2 = "update transaction_stock set cum_stockstatus='0' where itemcode='$itemcode' and locationcode='$locationcode'";

			$execupdatecumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatecumstock2) or die ("Error in updateCumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

			

			$stockquery2="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,

			batchnumber, batch_quantity, 

			transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,rate,totalprice,ledgeranum,ledgercode,ledgername,incomeledger,incomeledgercode)

			values ('$fifo_code','purchasereturn_details','$itemcode', '$itemname', '$dateonly','0', 'Purchase Return', 

			'$batchnumber', '$bat_quantity', '$returnqty', 

			'$cum_quantity', '$billnumber', '','$cum_stockstatus','$batch_stockstatus', '$locationcode','','$storeanum', '', '$username', '$ipaddress','$dateonly','$timeonly','$updatedatetime','$rate','$itemsubtotal','$ledgeranum','$ledgercode','$ledgername','$incomeledger','$incomeledgercode')";

			

			$stockexecquery2=mysqli_query($GLOBALS["___mysqli_ston"], $stockquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				

         	$query4 = "insert into purchasereturn_details (bill_autonumber, companyanum, 

			billnumber, itemanum, itemcode, itemname, itemdescription, rate, quantity, 

			subtotal, free, discountpercentage, discountrupees, openingstock, closingstock, totalamount, 

			discountamount, username, ipaddress, entrydate, itemtaxpercentage, itemtaxamount, unit_abbreviation, 

			batchnumber, expirydate,typeofreturn,suppliername,suppliercode,packagequantity,location,store,grnbillnumber,accountssubcode,grtcoa,categoryname,locationcode,locationname,fifo_code,ledgeranum,ledgercode,ledgername,incomeledger,incomeledgercode) 

			values ('$billautonumber', '$companyanum', '$billnumber', '$itemanum', '$itemcode', '$itemname', '$itemdescription', '$rate', '$quantity', 

			'$itemsubtotal', '$free', '$itemdiscountpercent', '$itemdiscountrupees', '$openingstock', '$closingstock', 

			'$itemsubtotal', '$discountamount', '$username', '$ipaddress', '$billdate', 

			'$itemtaxpercent', '$itemtaxamount', '$itemunitabb',

			'$batchnumber',  '$expirydate','Process','$suppliername','$suppliercode','$returnqty','$locationname','$storeanum','$grnnumber','$accountssubid','$coa','$categoryname','$locationcode','$locationname','$fifo_code','$ledgeranum','$ledgercode','$ledgername','$incomeledger','$incomeledgercode')";  

			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

			$test = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);

		    $query56 = "update purchase_details set itemstatus='$itemstatus' where billnumber='$grnnumber' and itemcode='$itemcode'";

			$exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				

			header("location:mainmenu1.php");

			}

			}

			

			}

	

}

}

}



			?>

       

        

        <?php

		if($test != ''){

		echo 	'<script type="text/javascript">funcPrintReceipt1();window.location = "mainmenu1.php";</script>';

		exit;



		}

header("location:mainmenu1.php");

}



?>

 <script>

		function funcPrintReceipt1()

{

 window.open("print_goodsreturns.php?grt=<?php echo $billnumber;?>","OriginalWindow<?php echo $billnumber; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

 

}

		</script>

<?php

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



	$searchgrn = $_POST['grn'];

	$searchgrn = trim($searchgrn);

$query5 = "select * from materialreceiptnote_details where billnumber = '$searchgrn' order by billnumber";

$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res5 = mysqli_fetch_array($exec5))

{

	$billnum = $res5["billnumber"];

	$suppliername = $res5['suppliername'];

	$suppliercode = $res5['suppliercode'];

    $suppliername = strtoupper($suppliername);

    $billdate = $res5['entrydate'];

	$locationcode = $res5['locationcode'];

	$storecode1 = $res5['store']; 

	

	$query6 = "select * from master_location where locationcode = '$locationcode'";

	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res6 = mysqli_fetch_array($exec6);

	$locationname = $res6['locationname'];

	

	$query61 = "select * from master_store where storecode = '$storecode1'";

	$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query61".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res61 = mysqli_fetch_array($exec61);

	$store = $res61['store'];

	$storecode = $res61['storecode'];

	

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



$query2b = "select * from master_purchase where mrnno = '$searchgrn'";

$exec2b = mysqli_query($GLOBALS["___mysqli_ston"], $query2b) or die ("Error in Query2b".mysqli_error($GLOBALS["___mysqli_ston"]));

$rowcount2b = mysqli_num_rows($exec2b);

$number=mysqli_num_rows($exec2b);

$res2b = mysqli_fetch_array($exec2b);

$suppliername = $res2b['suppliername'];

$suppliercode = $res2b['suppliercode'];

$anum=$res2b['auto_number'];

$billnumber1 = $res2b['billnumber'];

$supplierbillnumber=$res2b['supplierbillnumber'];

$billnumberprefix = $res2b['billnumberprefix'];

$billnumberpostfix = $res2b['billnumberpostfix'];

$billdate = $res2b['billdate'];

$billtotalamount = $res2b['totalamount'];

$billtotalfxamount = $res2b['totalfxamount'];

$mrnno = $res2b['mrnno'];

$approved_amount = 0;



$query3 = "select sum(approved_amount) as approved_amount from master_transactionpharmacy where transactiontype = 'PURCHASE' and transactionmode <> 'CREDIT' and billnumber = '$billnumber1' and companyanum='$companyanum' and  approved_payment = '1'";

$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

$num=mysqli_num_rows($exec3);

while ($res3 = mysqli_fetch_array($exec3))

{

	//$approved_amount = $res3['approved_amount'];

}



$query3 = "select * from master_transactionpharmacy where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and billnumber = '$billnumber1' and companyanum='$companyanum' and recordstatus = 'allocated'";

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

}

			

$query38 = "select totalamount from purchasereturn_details where grnbillnumber = '$mrnno'";

$exec38 = mysqli_query($GLOBALS["___mysqli_ston"], $query38) or die ("Error in Query38".mysqli_error($GLOBALS["___mysqli_ston"]));

$num=mysqli_num_rows($exec38);

while ($res38 = mysqli_fetch_array($exec38))

{

	$return = $res38['totalamount'];

	$totalreturn = $totalreturn + $return;

}



$totalpayment = $cashamount21 + $chequeamount21 + $onlineamount21 + $cardamount21 + $taxamount21;

$netpayment = $totalpayment + $tdsamount21 + $writeoffamount21;

				

$balanceamount = $billtotalamount - $netpayment - $approved_amount - $totalreturn;

$balanceamount = number_format($balanceamount, 2, '.', '');	



}





//To verify the edition and manage the count of bills.

$thismonth = date('Y-m-');

$query77 = "select * from master_edition where status = 'ACTIVE'";

$exec77 =  mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));

$res77 = mysqli_fetch_array($exec77);

$res77allowed = $res77["allowed"];





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

$query3 = "select * from bill_formats where description = 'goods_returns'";

$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

$res3 = mysqli_fetch_array($exec3);

$paynowbillprefix = $res3['prefix'];

$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select * from purchasereturn_details where typeofreturn='Process' order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["billnumber"];

$billdigit=strlen($billnumber);

if ($billnumber == '')

{

    $billnumbercode =$paynowbillprefix."-".'1'."-".date('y')."-".$location_auto;
	//$billnumbercode ='GRT-'.'1';

	$openingbalance = '0.00';

}

else

{

	$billnumber = $res2["billnumber"];

	/*$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);

	//echo $billnumbercode;

	$billnumbercode = intval($billnumbercode);
    $billnumbercode=abs($billnumbercode);
	$billnumbercode = $billnumbercode + 1;



	$maxanum = $billnumbercode;*/
	
		$maxcount=split("-",$billnumber);
		$maxcount1=$maxcount[1];
		$maxanum = $maxcount1+1;

	

	$billnumbercode = $paynowbillprefix ."-".$maxanum."-".date('y')."-".$location_auto;

	//$billnumbercode = 'GRT-' .$maxanum;

	$openingbalance = '0.00';

	//echo $companycode;

}

?>



<?php

include("autocompletebuild_grn.php");



?>



<script type="text/javascript">



window.onload = function()

{

	//To handle ajax dropdown list.

	funcCustomerDropDownSearch3();

	//funcPopupPrintFunctionCall();

}





</script>



<script>





function checkBox(cno)

{	var checkno=cno;

	

    if(document.getElementById("returncheckbox"+checkno+"").checked)

	{

	

        document.getElementById("returnqty"+checkno+"").readOnly  = false;

		

	}

    else

	{

        document.getElementById("returnqty"+checkno+"").readOnly  = true;

		

		var totamt=document.getElementById("totalamount"+checkno+"").value;

		var totamt2=document.getElementById("value").value;

		var finalamt=totamt2-totamt;

		document.getElementById("value").value=finalamt;

		document.getElementById("returnqty"+checkno+"").value='';

		document.getElementById("totalamount"+checkno+"").value='';

		

	}

}





function amt(varserialnumber3,totalcount1)

{



	var totalcount1 = totalcount1;

	

	var grandtotaladjamt1 = 0;

	var varserialnumber3 = varserialnumber3;

	//alert(varserialnumber3);

	var returnqty = document.getElementById("returnqty"+varserialnumber3+"").value;

	

	if(true)

	{

		var balqty = document.getElementById("balqty"+varserialnumber3+"").value;

		

		if(parseInt(returnqty) > parseInt(balqty))

		{

			alert("Return quantity is greater than Balance quantity. Please Enter lesser Quantity");

			document.getElementById("returnqty"+varserialnumber3+"").value =0;

			document.getElementById("value").value =0;

			document.getElementById("returnqty"+varserialnumber3+"").focus();

			return false;

		}

		document.getElementById("returncheckbox"+varserialnumber3+"").checked = true;

		var costprice = document.getElementById("costprice"+varserialnumber3+"").value;

		var discount = document.getElementById("discount"+varserialnumber3+"").value;

		

		if(discount != 0.00)

		{

			var totalamount = parseFloat(returnqty) * parseFloat(costprice);

			var totalamount1 = (parseFloat(totalamount) * parseFloat(discount))/100;

			var totalamount2 = parseFloat(totalamount) - parseFloat(totalamount1); 

		}

		else

		{

			if(returnqty == "") { returnqty = 0; }

			var totalamount2 = parseFloat(returnqty) * parseFloat(costprice);

		}

		document.getElementById("totalamount"+varserialnumber3+"").value = totalamount2.toFixed(2);

		for(i=1;i<=totalcount1;i++)

		{

			var totaladjamount=document.getElementById("totalamount"+i+"").value;

			if(totaladjamount == "")

			{

				totaladjamount=0;

			}

			grandtotaladjamt1=grandtotaladjamt1+parseFloat(totaladjamount);

		}

		var BalanceAmt = document.getElementById("balanceamt").value;

		if(parseFloat(grandtotaladjamt1) > parseFloat(BalanceAmt))

		{

			alert("Total Amount is Greater than Balance Amount");

			document.getElementById("returnqty"+varserialnumber3+"").value =0;

			document.getElementById("value").value =0;

			document.getElementById("totalamount"+varserialnumber3+"").value=0;

			document.getElementById("returnqty"+varserialnumber3+"").focus();

			return false;

		}

		document.getElementById("value").value = grandtotaladjamt1.toFixed(2);

	}

}



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

		

}



function funcsave(totalcount5)

{

	var totalcount5 =totalcount5;

	

	

	if(document.getElementById("grn").value =='')

	{

		alert("Please Select GRN Number");

		document.getElementById("grn").focus();

		return false;

	}

	

	

	for(i=1;i<=totalcount5;i++)

	{

		var returnqty=document.getElementById("returnqty"+i+"").value;

		if(document.getElementById("returnqty"+i+"").readOnly ==false  )

		{

			if(returnqty == "")

			{

			alert("Please Enter Return Quantity");

			document.getElementById("returnqty"+i+"").focus();

			return false; 

			}

		}

		/*if(document.getElementById("totalamount"+i+"").value ==''  )

		{

			if(returnqty == "")

			{

			alert("Please Enter Return Quantity");

			document.getElementById("returnqty"+i+"").focus();

			return false; 

			}

		}*/

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

<?php //include ("js/dropdownlist1scriptinggrn.php"); ?>

<!--<script type="text/javascript" src="js/autocomplete_grn.js"></script>

<script type="text/javascript" src="js/autosuggestgrn.js"></script>-->

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />

<link rel="stylesheet" type="text/css" href="css/autocomplete.css" />  



<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>

<script type="text/javascript" src="js/jquery.min-autocomplete.js"></script>

<script type="text/javascript" src="js/jquery-ui.min.js"></script>

<script type="text/javascript">

$(function() {

$('#grn').autocomplete({

	source:'ajaxgrnbuild.php', 

	select: function(event,ui){

			var entrydocno = ui.item.entrydocno;

			$('#grn').val(entrydocno);

			document.cbform1.submit();

			},

	html: true

    });

})

</script>

</head>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<body>



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

		 <form name="cbform1" method="post" action="goodsreturns.php"> 

		<table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" collapse>

            <tbody>		

			  <tr>

			 

			    <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Doc No</strong></td>

                <td width="18%" align="left" valign="middle" class="bodytext3"><?php echo $billnumbercode; ?>

				<input name="docno" id="docno" value="<?php echo $billnumbercode; ?>" size="10" autocomplete="off" readonly type="hidden"/>                  </td>

                 <td width="18%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Select GRN</strong></td>

                <td colspan="3" align="left" valign="top" >

				<input name="grn" id="grn" value="<?php echo $billnum; ?>" size="10" rsize="20" autocomplete="off"/>				</td>

             <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>GRN Date </strong></td>

                <td width="18%" colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $billdate; ?>

				<input name="lpodate" id="lpodate" value="<?php echo $billdate; ?>" size="18" rsize="20" readonly type="hidden"/>				</td>

			    </tr>

				<tr>

			    <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Supplier</strong></td>

                <td width="18%" align="left" valign="middle" class="bodytext3"><?php echo $suppliername; ?>

				<input name="supplier" id="supplier" value="<?php echo $suppliername; ?>" size="25" autocomplete="off" readonly type="hidden"/>                  </td>

                 <td width="18%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>GRN Date</strong></td>

               <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $dateonly; ?>

				<input name="grndate" id="grndate" value="<?php echo $dateonly; ?> size="18" rsize="20" readonly type="hidden"/>				</td>

			     

				  <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Time </strong></td>

                <td width="18%" colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $timeonly; ?>

				<input name="time" id="time" value="<?php echo $timeonly; ?>" size="18" rsize="20" readonly type="hidden"/>				</td>

		

                  </tr>

				<tr>

			    <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Address</strong></td>

                <td width="18%" align="left" valign="middle" class="bodytext3"><?php echo $address; ?>

				<input name="address" id="address" value="<?php echo $address; ?>" size="30" autocomplete="off" readonly type="hidden"/>                  </td>

                 <td width="18%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Telephone</strong></td>

                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $tele; ?>

				<input name="telephone" id="telephone" value="<?php echo $tele; ?>"  size="25" rsize="20" readonly type="hidden"/>				

             	<input type="hidden" name="cbfrmflag1" value="cbfrmflag1"></td>

				<td width="18%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Balance Amt</strong></td>

				<td align="left" valign="middle" class="bodytext3"><input type="text" readonly size="12" name="balanceamt" id="balanceamt" value="<?php echo $balanceamount; ?>"></td>	

			    </tr>

				 <tr>

			    <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Location</strong></td>

                <td width="18%" align="left" valign="middle" class="bodytext3"><?php echo $locationname; ?>

				</td>

                 <td width="18%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Store</strong></td>

                <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $store; ?>

				</td>

             <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Location Code </strong></td>

                <td width="18%" colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $locationcode; ?>

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

	   <?php
	 include_once("store_stocktaking_chk1.php");
	 if($num_stocktaking > 0) {
	  ?>
	  <tr><td colspan="7" class="bodytext3"><font color='red' size='6px'><strong><?php echo $stocktake_err;?></strong></font></td></tr>
	  <?php
	 }else{
	 ?>
      <tr>

        <td>

		<form action="goodsreturns.php" method="post" name="form" onSubmit="return funcSaveBill1()">

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="2" width="1200" 

            align="left" border="0">

          <tbody id="foo">

		 <input type="hidden" name="billnum" value="<?php echo $billnumbercode; ?>">

		 <input type="hidden" name="billdate" value="<?php echo $dateonly; ?>">

		 <input type="hidden" name="suppliername" value="<?php echo $suppliername; ?>">

		 <input type="hidden" name="grnno" value="<?php echo $billnum; ?>">

		<input type="hidden" name="locationcode" value="<?php echo $locationcode; ?>">

		<input type="hidden" name="locationname" value="<?php echo $locationname; ?>">

		<input type="hidden" name="store" value="<?php echo $storecode; ?>">

             <tr>

            <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Return</strong></td>

			<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>S.No</strong></td>

			<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center" width="20%"><strong>Item</strong></td>

			<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Recd.Qty</strong></td>

			<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Ret.Qty</strong></td>

			<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Free</strong></td>

            <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Bal.Qty</strong></td>

			<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Batch</strong></td>

			<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Exp.Dt</strong></td>

			<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Cost Price</strong></td>

			<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Disc %</strong></td>

			<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Total Value</strong></td>

			

			</tr>

				  		<?php

			$colorloopcount = '';

			$sno = 0;

			$totalamount=0;			

			$query76 = "select * from materialreceiptnote_details where billnumber='$billnum' and billnumber<>'' and itemstatus=''";

			$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$number = mysqli_num_rows($exec76);

			while($res76 = mysqli_fetch_array($exec76))

			{

			$totalreceivedqty = 0;

			$itemname = $res76['itemname'];

			$itemcode = $res76['itemcode'];

			$rate = $res76['rate'];

			$quantity = $res76['quantity'];

			$amount = $res76['totalamount'];

			$packagequantity = $res76['packagequantity'];

			$batch = $res76['batchnumber'];

			$expirydate = $res76['expirydate'];

			$costprice = $res76['costprice'];

			$discountpercentage = $res76['discountpercentage'];

			$totalamount = $res76['totalamount'];

			$allpackagetotalquantity = $res76['allpackagetotalquantity'];

			$itemfreeqty=$res76['itemfreequantity'];

			$fifo_code=$res76['fifo_code'];

			$ledgeranum = $res76['ledgeranum'];

			$ledgercode = $res76['ledgercode'];

			$ledgername = $res76['ledgername'];

			$incomeledger =$res76['incomeledger'];

			$incomeledgercode = $res76['incomeledgercode'];

			

			$query444 = "select * from purchasereturn_details where itemcode='$itemcode' and grnbillnumber='$billnum' limit 0,10";

			$exec444 = mysqli_query($GLOBALS["___mysqli_ston"], $query444) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$num444 = mysqli_num_rows($exec444);

			while($res444 = mysqli_fetch_array($exec444))

			{

			$receivedqty = $res444['packagequantity'];

			$totalreceivedqty = $totalreceivedqty+$receivedqty;

			}

			$balanceqty = $allpackagetotalquantity - $totalreceivedqty;

			$query77 = "select * from master_medicine where itemcode='$itemcode' limit 0,10";

			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res77 = mysqli_fetch_array($exec77);

			$packagesize = $res77['packagename'];

			$spmarkup = $res77['spmarkup'];

			

		

?>

  <tr>

 		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" id="returncheckbox<?php echo $sno+1; ?>" name="returncheckbox[]"  

        value="<?php echo $itemcode; ?>" onChange="checkBox('<?php echo $sno+1; ?>')"></div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $itemname; ?></div></td>

		<input type="hidden" name="itemname[]" value="<?php echo $itemname; ?>">

		<input type="hidden" name="itemcode[]" value="<?php echo $itemcode; ?>">

		<input type="hidden" name="rate[]" value="<?php echo $rate; ?>">

		<input type="hidden" name="quantity[]" value="<?php echo $quantity; ?>">

		<input type="hidden" name="fifo_code[]" value="<?php echo $fifo_code; ?>">

		<input type="hidden" name="ledgeranum[]" value="<?php echo $ledgeranum; ?>">

		<input type="hidden" name="ledgercode[]" value="<?php echo $ledgercode; ?>">

		<input type="hidden" name="ledgername[]" value="<?php echo $ledgername; ?>">

        <input type="hidden" name="incomeledger[]" value="<?php echo $incomeledger; ?>">

		<input type="hidden" name="incomeledgercode[]" value="<?php echo $incomeledgercode; ?>">

		        

		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo intval($allpackagetotalquantity); ?><input type="hidden" name="receivedquantity[]" id="receivedquantity<?php echo $sno; ?>" size="6" class="bodytext21" autocomplete="off"></div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text"   readonly name="returnqty[]"  id="returnqty<?php echo $sno; ?>" size="6" onKeyUp="amt('<?php echo $sno; ?>','<?php echo $number; ?>');" autocomplete="off"></div></td>

        <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $itemfreeqty; ?></div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $balanceqty; ?><input type="hidden" name="balqty[]" id="balqty<?php echo $sno; ?>" value="<?php echo $balanceqty; ?>"></div></td>

        

		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $batch; ?><input type="hidden" name="batch[]" id="batch<?php echo $sno; ?>" size="6" class="bodytext21" autocomplete="off" value="<?php echo $batch; ?>"></div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $expirydate; ?><input type="hidden" name="expirydate[]" id="expirydate<?php echo $sno; ?>" size="6" autocomplete="off" value="<?php echo $expirydate; ?>"></div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $costprice; ?><input type="hidden" name="costprice[]" id="costprice<?php echo $sno; ?>" size="6" class="bodytext21" readonly value="<?php echo $costprice; ?>"></div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $discountpercentage; ?><input type="hidden" name="discount[]" id="discount<?php echo $sno; ?>" size="6" class="bodytext21" value="<?php echo $discountpercentage; ?>"></div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="totalamount[]" id="totalamount<?php echo $sno; ?>" size="6" class="bal" readonly></div></td>

		<input type="hidden" name="priceperpack[]" id="priceperpack<?php echo $sno; ?>" size="6" class="bodytext21">

		<!--<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" id="return<?php echo $sno; ?>" name="return[]" 

        value="<?php echo $itemcode; ?>"></div></td>-->

		

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

                

                

				      </tr>

           

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

	 <td width="20" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Total Return Value</td>

	   <td width="111" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="text" name="value" id="value" size="10" readonly></td>

	     

	 </tr>

		</table>

		</td>

		</tr>				

		        

      <tr>

        

		 <td colspan="2" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

		  <input type="hidden" name="frmflag2" value="frmflag2">

               <input name="Submit222" type="submit"  value="Save" class="button" onClick="return funcsave('<?php echo $number; ?>')"/>		 </td>

      </tr>

	  </table>

      </td>

      </tr>

	  <?php } ?>
    </form>

  </table>



<?php include ("includes/footer1.php"); ?>

<?php //include ("print_bill_dmp4inch1.php"); ?>

</body>

</html>