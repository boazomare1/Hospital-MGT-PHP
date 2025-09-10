<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];

$titlestr = 'SALES BILL';

if (isset($_REQUEST["mrnno"])) { $billnum1 = $_REQUEST["mrnno"]; } else { $billnum1 = ""; }

if (isset($_REQUEST["grnno"])) { $billnum2 = $_REQUEST["grnno"]; } else { $billnum2 = ""; }

if (isset($_REQUEST["ADate1"])) { $fromdate = $_REQUEST["ADate1"]; } else { $fromdate = ""; }

if (isset($_REQUEST["ADate2"])) { $todate = $_REQUEST["ADate2"]; } else { $todate = ""; }

if (isset($_REQUEST["supplierbillno"])) { $supplierbillno1 = $_REQUEST["supplierbillno"]; } else { $supplierbillno1 = ""; }


if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];


$billnumber = $_REQUEST['billnum'];
$store = $_REQUEST['store1'];
$billdate = $_REQUEST['billdate'];
$suppliername = $_REQUEST['suppliername'];
$suppliercode = $_REQUEST['suppliercode'];
$ponumber = $_REQUEST['pono'];
$accountssubid = $_REQUEST['accountssubid'];
$supplierbillno = $_REQUEST['supplierbillno1'];
$amount = $_REQUEST['totalpurchaseamount1'];
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


foreach($_POST['itemname'] as $key=>$value)
{
$itemname = $_POST['itemname'][$key];
$itemcode = $_POST['itemcode'][$key];
$query5 = "select * from master_itempharmacy where itemcode = '$itemcode'";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res5 = mysqli_fetch_array($exec5);
			$itemanum = $res5['auto_number'];
$rate = $_POST['rate'][$key];
$quantity = $_POST['receivedquantity'][$key];
$allpackagetotalquantity = $_POST['totalquantity'][$key];
$orderedquantity = $_POST['orderedquantity'][$key];
$free = $_POST['free'][$key];
$itemdiscountpercent = $_POST['discount'][$key];
$totalamount = $_POST['totalamount1'][$key];
$itemtaxpercent = $_POST['tax'][$key];
$batchnumber = $_POST['batch'][$key];
$salesprice = $_POST['saleprice1'][$key];
$costprice = $_POST['costprice'][$key];
$expirydate = $_POST['expirydate'][$key];
			$expirymonth = substr($expirydate, 0, 2);
			$expiryyear = substr($expirydate, 3, 2);
			$expiryday = '01';
			$expirydate = $expiryyear.'-'.$expirymonth.'-'.$expiryday;
		
$packagename = $_POST['packsize'][$key];
 $balqty = $_POST['balqty'][$key];
if(intval($orderedquantity) == intval($quantity))
{
$itemstatus = 'received';
}
else
{
$itemstatus = '';
}

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
			
			$query33 = "select * from materialreceiptnote_details where billnumber='$ponumber' and itemcode='$itemcode'";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res33 = mysqli_fetch_array($exec33);
			$purchaseordernumber = $res33['ponumber'];
			
			



			$query4 = "insert into purchase_details (bill_autonumber, companyanum, 
			billnumber, itemanum, itemcode, itemname, itemdescription, rate, quantity, 
			subtotal, free, discountpercentage, discountrupees, openingstock, closingstock, totalamount, 
			discountamount, username, ipaddress, entrydate, itemtaxpercentage, itemtaxamount, unit_abbreviation, 
			batchnumber, salesprice, expirydate, itemfreequantity, itemtotalquantity, 
			packageanum, packagename, quantityperpackage, allpackagetotalquantity, 
			manufactureranum, manufacturername,typeofpurchase,suppliername,suppliercode,ponumber,supplierbillnumber,costprice,location,store,coa,categoryname) 
			values ('$billautonumber', '$companyanum', '$billnumber', '$itemanum', '$itemcode', '$itemname', '$itemdescription', '$rate', '$quantity', 
			'$totalamount', '$free', '$itemdiscountpercent', '$itemdiscountrupees', '$opening
			stock', '$closingstock', 
			'$totalamount', '$discountamount', '$username', '$ipaddress', '$billdate', 
			'$itemtaxpercent', '$itemtaxamount', '$itemunitabb', 
			'$batchnumber', '$salesprice', '$expirydate', '$free', '$quantity', 
			'$packageanum', '$packagename', '$quantityperpackage', '$allpackagetotalquantity', 
			'$manufactureranum', '$manufacturername','Process','$suppliername','$suppliercode','$ponumber','$supplierbillno','$costprice','$location','$store','$coa','$categoryname')";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$query56 = "update materialreceiptnote_details set itemstatus='$itemstatus' where billnumber='$ponumber' and itemcode='$itemcode'";
			$exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
			$query561 = "update master_itempharmacy set rateperunit='$salesprice',purchaseprice='$costprice' where itemcode='$itemcode'";
			$exec561 = mysqli_query($GLOBALS["___mysqli_ston"], $query561) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$query562 = "update master_medicine set rateperunit='$salesprice',purchaseprice='$costprice' where itemcode='$itemcode'";
			$exec562 = mysqli_query($GLOBALS["___mysqli_ston"], $query562) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$query56 = "update master_rfqpurchaseorder set goodsstatus='$itemstatus' where billnumber='$purchaseordernumber' and itemcode='$itemcode'";
			$exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			
}
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CREDIT';
		$particulars = 'BY CREDIT (Inv NO:'.$billnumber.$supplierbillnumber.')';	
		//include ("transactioninsert1.php");
		$query9 = "insert into master_transactionpharmacy (transactiondate, particulars, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount, creditamount,balanceamount,
		billnumber, billanum, ipaddress, updatedate,  companyanum, companyname, transactionmodule,suppliercode) 
		values ('$updatedatetime', '$particulars', '$accountssubid', '$suppliername', 
		'$transactionmode', '$transactiontype', '$amount', '$amount', '$amount',
		'$billnumber',  '$billautonumber', '$ipaddress', '$updatedate', '$companyanum', '$companyname', '$transactionmodule1','$suppliercode')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$transactiontype = 'PURCHASE';
		$transactionmode = 'BILL';
		$particulars = 'BY PURCHASE (Inv NO:'.$billnumber.$supplierbillnumber.')';	
		//include ("transactioninsert1.php");
		$query9 = "insert into master_transactionpharmacy (transactiondate, particulars, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount,
		billnumber, billanum, ipaddress, updatedate,  companyanum, companyname, transactionmodule,suppliercode) 
		values ('$updatedatetime', '$particulars', '$accountssubid', '$suppliername', 
		'$transactionmode', '$transactiontype', '$amount', 
		'$billnumber',  '$billautonumber', '$ipaddress', '$updatedate', '$companyanum', '$companyname', '$transactionmodule1','$suppliercode')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query3 = "insert into master_purchase (companyanum, billnumber, billdate, suppliercode, suppliername,totalamount,totalquantity,ipaddress,supplierbillnumber)values('$companyanum','$billnumber','$updatedatetime','$suppliercode', '$suppliername','$amount','$quantity','$ipaddress','$supplierbillno')";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));





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

	/*$searchpo = $_POST['po'];
	$searchpo = trim($searchpo);
	$len1 = strlen($searchpo);
					$str1 = preg_replace('/[^\\/\-a-z\s]/i', '', $searchpo);
					
					$searchpo = $mrnno;
					
					if($str1 == 'MRN-')
					{
$query5 = "select * from materialreceiptnote_details where billnumber = '$searchpo' and itemstatus='' order by billnumber";
}
else
{*/ $searchpo = $billnum1;
$query5 = "select * from materialreceiptnote_details where billnumber = '$searchpo' and itemstatus='' order by billnumber";
//}
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res5 = mysqli_fetch_array($exec5))
{
	$billnum = $res5["billnumber"];
	$suppliername = $res5['suppliername'];
	$suppliercode = $res5['suppliercode'];
    $suppliername = strtoupper($suppliername);
    $billdate = $res5['entrydate'];
	$supplierbillnumber = $res5['supplierbillnumber'];

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

$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res55 = mysqli_fetch_array($exec55);
$location = $res55['locationname'];

$res7storeanum = $res23['store'];

$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res75 = mysqli_fetch_array($exec75);
$store = $res75['store'];

$query78 = "select * from purchase_details where billnumber='$billnum2' and ponumber='$billnum1' ";
$exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res78 = mysqli_fetch_array($exec78);
 mysqli_num_rows($exec78); 
$res78store = $res78['store'];
$res78entrydate = $res78['entrydate'];
?>

<style>
#table {
    margin: 0;
    padding: 0; 
	style="position: absolute; left: 50; top:789;"
}
</style>

		<table width="810" border="0" align="left" cellpadding="0" cellspacing="0">
			  <tr>
			    <td width="58" align="left" valign="middle"   class="bodytext3"><strong>DOC No</strong></td>
                <td colspan="5" align="left" valign="middle" class="bodytext3"><?php echo $billnum2; ?>
				<input name="docno" id="docno" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A;" size="10" autocomplete="off" readonly="readonly" type="hidden"/></td>
                 <td width="70"  align="left" valign="middle"   class="bodytext3"><strong>MRN</strong></td>
                <td colspan="6"  align="left" valign="middle" class="bodytext3"><?php echo $billnum1; ?>
                  <input type="hidden" name="po2" id="po2" value="<?php echo $billnum; ?>" style="border: 1px solid #001E6A" size="10" rsize="20" autocomplete="off"/></td>
		        <td colspan="4" ><strong>MRN Date </strong><span class="bodytext3"><?php echo $billdate; ?>
                    <input name="lpodate22" id="lpodate22" value="<?php echo $billdate; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly="readonly" type="hidden"/>
				</span></td>
			  </tr>
				<tr>
			    <td  align="left" valign="middle"   class="bodytext3"><strong>Supplier</strong></td>
                <td colspan="5"  align="left" valign="middle" class="bodytext3"><?php echo $suppliername; ?> <!--& <?php echo $suppliercode; ?>-->
				<input name="supplier" id="supplier" value="<?php echo $suppliername; ?>" style="border: 1px solid #001E6A;" size="25" autocomplete="off" readonly="readonly" type="hidden"/>    
				<input type="hidden" name="suppliercode" id="suppliercode" value="<?php echo $suppliercode; ?>">           </td>
                 <td><strong>Invoice</strong></td>
				 <td colspan="6"><span class="bodytext3"><?php echo $supplierbillnumber; ?>
                     <input type="hidden" name="supplierbillno2" id="supplierbillno2" value="<?php echo $supplierbillnumber; ?>" style="border: 1px solid #001E6A" size="10" rsize="20" autocomplete="off" onkeyup="return billnotransfer()"/>
				 </span></td>
				 <td colspan="4"><strong>GRN Date </strong><span class="bodytext3"><?php echo $res78entrydate; ?>
                    <input name="grndate22" id="grndate22" value="<?php echo $dateonly; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly="readonly" type="hidden"/>
				 </span></td>
				</tr>
				<tr>
			    <td  align="left" valign="middle"   class="bodytext3"><strong>Address</strong></td>
                <td colspan="5"  align="left" valign="middle" class="bodytext3"><?php echo $address; ?>
				<input name="address" id="address" value="<?php echo $address; ?>" style="border: 1px solid #001E6A;" size="30" autocomplete="off" readonly="readonly" type="hidden"/>                  </td>
                 <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
				<td><strong>Telephone</strong></td>
				<td colspan="8"><span class="bodytext3"><?php echo $tele; ?>
                    <input name="telephone2" id="telephone2" value="<?php echo $tele; ?>" style="border: 1px solid #001E6A" size="25" rsize="20" readonly="readonly" type="hidden"/>
				</span></td>
			    </tr>
				<tr>
			    <td  align="left" valign="middle"   class="bodytext3"><strong>Location</strong></td>
                <td width="31"  align="left" valign="middle" class="bodytext3"><?php echo $location; ?></td>
			      <td width="55"  align="left" valign="middle"   class="bodytext3">&nbsp;</td>
				<td width="64" >&nbsp;</td>
				<td width="52" >&nbsp;</td>
				<td width="39" >&nbsp;</td>
				<td  align="left" valign="middle"   class="bodytext3"><strong>Store</strong></td>
				<td colspan="6" ><span class="bodytext3"><?php echo $res78store; ?></span></td>
		  </tr>
        
		  <tbody id="foo">
		 <input type="hidden" name="billnum" value="<?php echo $billnumbercode; ?>">
		 <input type="hidden" name="billdate" value="<?php echo $dateonly; ?>">
		 <input type="hidden" name="suppliername" value="<?php echo $suppliername; ?>">
		 <input type="hidden" name="pono" value="<?php echo $billnum; ?>">
		 <input type="hidden" name="location" value="<?php echo $location; ?>">
		 <input type="hidden" name="store1" id="store1">
		 <input type="hidden" name="suppliercode" id="suppliercode" value="<?php echo $suppliercode; ?>"> 
		 <input type="hidden" name="accountssubid" value="<?php echo $accountssubid; ?>">
		 <input type="hidden" name="supplierbillno1" id="supplierbillno1" value="<?php echo $supplierbillnumber; ?>">
		 
		 
             <tr>
               <td  align="left" valign="center" bgcolor="#ffffff" class="bodytext3">&nbsp;</td>
               <td bgcolor="#ffffff" class="bodytext3" valign="center"  align="left">&nbsp;</td>
               <td align="center" valign="center" bgcolor="#ffffff" class="bodytext3">&nbsp;</td>
               <td align="center" valign="center" bgcolor="#ffffff" class="bodytext3">&nbsp;</td>
               <td align="center" valign="center" bgcolor="#ffffff" class="bodytext3">&nbsp;</td>
               <td align="center" valign="center" bgcolor="#ffffff" class="bodytext3">&nbsp;</td>
               <td  align="center" valign="center" bgcolor="#ffffff" class="bodytext3">&nbsp;</td>
               <td width="57"  align="center" valign="center" bgcolor="#ffffff" class="bodytext3">&nbsp;</td>
               <td width="31"  align="center" valign="center" bgcolor="#ffffff" class="bodytext3">&nbsp;</td>
               <td width="52"  align="center" valign="center" bgcolor="#ffffff" class="bodytext3">&nbsp;</td>
               <td width="46"  align="center" valign="center" bgcolor="#ffffff" class="bodytext3">&nbsp;</td>
               <td width="56"  align="center" valign="center" bgcolor="#ffffff" class="bodytext3">&nbsp;</td>
               <td width="34"  align="center" valign="center" bgcolor="#ffffff" class="bodytext3">&nbsp;</td>
               <td width="44"  align="center" valign="center" bgcolor="#ffffff" class="bodytext3">&nbsp;</td>
               <td width="39"  align="right" valign="center" bgcolor="#ffffff" class="bodytext3">&nbsp;</td>
               <td width="35"  align="right" valign="center" bgcolor="#ffffff" class="bodytext3">&nbsp;</td>
               <td width="47"  align="right" valign="center" bgcolor="#ffffff" class="bodytext3">&nbsp;</td>
             </tr>
             <tr>
		               <td align="center" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>S.No</strong></td>
                       <td bgcolor="#ffffff" class="bodytext3" valign="center"  align="left" ><strong>Item</strong></td>
                       <td   align="center" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Ord.Qty</strong></td>
                       <td   align="center" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Recd.Qty</strong></td>
					   <td   align="center" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Bal.Qty</strong></td>
                       <td   align="center" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Batch</strong></td>
                       <td   align="center" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Exp.Dt</strong></td>
                      <td   align="center" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Pkg.Size</strong></td>
                       <td   align="center" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Free</strong></td>
                       <td   align="center" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Tot.Qty</strong></td>
					    <td   align="right" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>QP/PK</strong></td>
					   <td   align="right" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Price/Pk</strong></td>
					   <td   align="center" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Disc %</strong></td>
					   <td   align="center" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Tax</strong></td>
					  <td   align="right" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Total </strong></td>
						<td align="right" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Cost Price</strong></td>
						<td   align="right" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Sale Price</strong></td>
		  </tr>
				  		<?php
			$colorloopcount = '';
			$sno = 0;
			$totalamount=0;	
			$grandtotalamount = 0;
			$len = strlen($billnum);
					$str = preg_replace('/[^\\/\-a-z\s]/i', '', $billnum);
					if($str == 'MRN-')
					{
			$query76 = "select * from materialreceiptnote_details where billnumber='$billnum1' and itemstatus=''";
			}
			else
			{
			$query76 = "select * from materialreceiptnote_details where billnumber='$billnum1' and itemstatus=''";
			}
			$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$number = mysqli_num_rows($exec76);
			while($res76 = mysqli_fetch_array($exec76))
			{
			$totalreceivedqty = 0;
			$itemname = $res76['itemname'];
			$itemcode = $res76['itemcode'];
			$rate = $res76['priceperpack'];
			$quantity = $res76['quantity'];
			$amount = $res76['totalamount'];
			$suppliercode = $res76['suppliercode'];
			$batchnumber = $res76['batchnumber'];
			$expirydate = $res76['expirydate'];
			$free = $res76['itemfreequantity'];
			$priceperpack = $res76['priceperpack'];
			$totalqty = $res76['allpackagetotalquantity'];
			$discountpercent = $res76['discountpercentage'];
			$itemtaxpercentage = $res76['itemtaxpercentage'];
			$itemtotalamount = $rate * $quantity;
			
			$grandtotalamount = $grandtotalamount + $itemtotalamount;
			
			$packsize = $res76['unit_abbreviation'];
			$packsizelen = strlen($packsize);
			
			$unitquantity = substr($packsize,0,$packsizelen-1);
			$costprice = $itemtotalamount/($unitquantity * $quantity);
			
			$query761 = "select * from master_rfq where suppliercode='$suppliercode' and medicinecode='$itemcode' and status = 'generated' order by auto_number desc";
			$exec761 = mysqli_query($GLOBALS["___mysqli_ston"], $query761) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res761 = mysqli_fetch_array($exec761);
			$orderedquantity = $res761['packagequantity'];
			$amount3 = $res761['amount'];
			$quotedprice = $res761['rate'];
			
			if($rate > $quotedprice)
			{
			$error_css='background-color:red';
			}
			else if($rate < $quotedprice)
			{
			$error_css = 'background-color:yellow';
			}
			else
			{
			$error_css = '';
			}
	
				$balanceqty = $orderedquantity - $quantity;
				
				$expirydate = explode("-",$expirydate);
			$year =  $expirydate[0];
			$year = substr($year,2,4);
			$month = $expirydate[1];
			$newexpirydate = $expirydate[1].'/'.$year;
			

			$query77 = "select * from master_medicine where itemcode='$itemcode'";
			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res77 = mysqli_fetch_array($exec77);
			$packagesize = $res77['packagename'];
			$spmarkup = $res77['spmarkup'];
			$saleprice = $spmarkup * $costprice;
			
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
		 	<tr>
		<td class="bodytext3" valign="center"  align="center"><?php echo $sno = $sno + 1; ?></td>
		<td class="bodytext3" valign="center"  align="left"><?php echo $itemname; ?></td>
		<input type="hidden" name="itemname[]" value="<?php echo $itemname; ?>">
		<input type="hidden" name="itemcode[]" value="<?php echo $itemcode; ?>">
		<input type="hidden" name="rate[]" value="<?php echo $rate; ?>">
		<input type="hidden" name="quantity[]" value="<?php echo $quantity; ?>">
		<input type="hidden" name="totalamount[]" value="<?php echo $amount; ?>">
		<td class="bodytext3" valign="center"  align="center"><?php echo intval($orderedquantity); ?></td><input type="hidden" name="orderedquantity[]" id="orderedquantity<?php echo $sno; ?>" value="<?php echo intval($orderedquantity); ?>">
		<td class="bodytext3" valign="center"  align="center"><input type="hidden" name="receivedquantity[]" id="receivedquantity<?php echo $sno; ?>" size="6" onKeyUp="return totalcalc('<?php echo $sno; ?>');" class="bodytext21" autocomplete="off" value="<?php echo intval($quantity); ?>" readonly="readonly"><?php echo intval($quantity); ?></td>
		<td class="bodytext3" valign="center"  align="center"><?php echo $balanceqty; ?><input type="hidden" name="balqty[]" id="balqty<?php echo $sno; ?>" value="<?php echo $balanceqty; ?>"></td>
		<td class="bodytext3" valign="center"  align="center"><input type="hidden" name="batch[]" id="batch<?php echo $sno; ?>" size="6" class="bodytext21" autocomplete="off" value="<?php echo $batchnumber; ?>" readonly="readonly"><?php echo $batchnumber; ?></td>
		<td class="bodytext3" valign="center"  align="center"><input type="hidden" name="expirydate[]" id="expirydate<?php echo $sno; ?>" size="6" autocomplete="off" value="<?php echo $newexpirydate; ?>" readonly="readonly"><?php echo $newexpirydate; ?></td>
		<td class="bodytext3" valign="center"  align="center"><?php echo $packagesize; ?><input type="hidden" name="packsize[]" id="packsize<?php echo $sno; ?>" value="<?php echo $packagesize; ?>"></td>
		<td class="bodytext3" valign="center"  align="center"><input type="hidden" name="free[]" id="free<?php echo $sno; ?>" size="6" onKeyUp="return totalcalc1('<?php echo $sno; ?>');" class="bodytext21" autocomplete="off" value="<?php echo intval($free); ?>" readonly="readonly"><?php echo intval($free); ?></td>
		<td class="bodytext3" valign="center"  align="center"><input type="hidden" name="totalquantity[]" id="totalquantity<?php echo $sno; ?>" size="6" class="bodytext21" value="<?php echo intval($totalqty); ?>" readonly="readonly"><?php echo intval($totalqty); ?></td>
		<td class="bodytext3" valign="center"  align="right"><?php echo number_format($quotedprice,2,'.',','); ?></td>
		<td class="bodytext3" valign="center"  align="right"><input type="hidden" name="priceperpack[]" id="priceperpack<?php echo $sno; ?>" size="6" onKeyUp="return totalamount('<?php echo $sno; ?>','<?php echo $number; ?>');" class="bodytext21" autocomplete="off" value="<?php echo $rate; ?>" readonly="readonly" align="right" style="<?php echo $error_css; ?>"><?php echo number_format($rate,2,'.',','); ?></td>
		<td class="bodytext3" valign="center"  align="right"><input type="hidden" name="discount[]" id="discount<?php echo $sno; ?>" size="6" onKeyUp="return totalamount5('<?php echo $sno; ?>','<?php echo $number; ?>');" class="bodytext21" autocomplete="off" value="<?php echo $discountpercent; ?>" readonly="readonly"><?php echo number_format($discountpercent,2,'.',','); ?></td>
		<td class="bodytext3" valign="center"  align="center"><input type="hidden" name="tax[]" id="tax<?php echo $sno; ?>" size="6" onKeyUp="return totalamount20('<?php echo $sno; ?>','<?php echo $number; ?>');" class="bodytext21" autocomplete="off" value="<?php echo $itemtaxpercentage; ?>" readonly="readonly"><?php echo $itemtaxpercentage; ?></td>
		<td class="bodytext3" valign="center"  align="right"><input type="hidden" name="totalamount[]" id="totalamount<?php echo $sno; ?>" size="6" class="bodytext21" readonly="readonly" value="<?php echo number_format($itemtotalamount,2,'.',','); ?>"><?php echo number_format($itemtotalamount,2,'.',','); ?></td>
		<input type="hidden" name="totalamount1[]" id="totalamount<?php echo $sno; ?>" size="6" class="bodytext21" readonly="readonly" value="<?php echo $itemtotalamount; ?>">
		<td class="bodytext3" valign="center"  align="right"><input type="hidden" name="costprice[]" id="costprice<?php echo $sno; ?>" size="6" class="bodytext21" readonly="readonly" value="<?php echo number_format($costprice,2,'.',','); ?>"><?php echo number_format($costprice,2,'.',','); ?></td>
		<td  align="right" valign="center" class="bodytext3">
		  <input  type="hidden" name="saleprice1[]" id="saleprice1<?php echo $sno; ?>" size="6" class="bodytext21" readonly="readonly" value="<?php echo $saleprice; ?>">
            <input type="hidden" name="spmarkup" id="spmarkup<?php echo $sno; ?>" value="<?php echo $spmarkup; ?>">
		  <input type="hidden" name="saleprice[]" id="saleprice<?php echo $sno; ?>" size="6" class="bodytext21" readonly="readonly" value="<?php echo number_format($saleprice,2,'.',','); ?>">
		  <?php echo number_format($spmarkup,2,'.',','); ?></td>
		</tr>
			<?php 
		
			}
		?>
			  <tr>
              <td class="bodytext3" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext3" valign="center"  align="left" 
                >&nbsp;</td>
				<td class="bodytext3" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext3" valign="center"  align="left" 
                >&nbsp;</td>
				 <td class="bodytext3" valign="center"  align="left" 
                >&nbsp;</td>
				 <td class="bodytext3" valign="center"  align="left" 
                >&nbsp;</td>
				 <td class="bodytext3" valign="center"  align="left" 
                >&nbsp;</td>
				 <td class="bodytext3" valign="center"  align="center" 
                ></td>
				 <td class="bodytext3" valign="center"  align="left" 
                >&nbsp;</td>
				<td class="bodytext3" valign="center"  align="left" 
                >&nbsp;</td>
				<td class="bodytext3" valign="center"  align="left" 
                >&nbsp;</td>
				<td class="bodytext3" valign="center"  align="left" 
                >&nbsp;</td>
				<td class="bodytext3" valign="center"  align="left" 
                >&nbsp;</td>
				<td  align="right" valign="center" 
                 class="bodytext3"><strong>Total:</strong></td>
				<td class="bodytext3" valign="center"  align="right" 
                ><strong><?php echo number_format($grandtotalamount,2,'.',','); ?></strong></td>
				<td class="bodytext3" valign="center"  align="left" 
                >&nbsp;</td>
				<td  align="left" valign="center" 
                 class="bodytext3">&nbsp;</td>
			  </tr>
           
          </tbody>
        </table>	
				

<?php	
$content = ob_get_clean();

// convert in PDF

try
{
$html2pdf = new HTML2PDF('L', 'A4', 'en');
//      $html2pdf->setModeDebug();
//$html2pdf->setDefaultFont('Arial');
$html2pdf->writeHTML($content, isset($_GET['vuehtml']));

$html2pdf->Output('rfqgrnview.pdf');
}
catch(HTML2PDF_exception $e) {
echo $e;
exit;
}
?>

