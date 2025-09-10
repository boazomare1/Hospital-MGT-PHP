<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$currentdate = date("Y-m-d");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];  
$financialyear = $_SESSION["financialyear"];
$docno1 = $_SESSION['docno'];
$locationname=isset($_REQUEST['locationname'])?$_REQUEST['locationname']:'';
$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
$storecode=isset($_REQUEST['storecode'])?$_REQUEST['storecode']:'';
$store=isset($_REQUEST['store'])?$_REQUEST['store']:'';
$templateid=isset($_REQUEST['templateid'])?$_REQUEST['templateid']:'';
//$template_id=isset($_REQUEST['map_template_code'])?$_REQUEST['map_template_code']:'';
$query = "select * from login_locationdetails where username='$username' and docno='$docno1' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
$locationname  = $res["locationname"];
$locationcode = $res["locationcode"];
 
$query018="select auto_number from master_location where locationcode='$locationcode'";
$exc018=mysqli_query($GLOBALS["___mysqli_ston"], $query018);
$res018=mysqli_fetch_array($exc018);
$location_auto = $res018['auto_number'];
$titlestr = 'SALES BILL';
$query77 = "select job_title from master_employee where username = '$username'";
$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
$res77 = mysqli_fetch_array($exec77);
$job_title = $res77['job_title'];
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
  if($username!='')
  {
		$docno = $_REQUEST['docno'];
		$location = $_REQUEST['location'];
		$status = $_REQUEST['status'];
		$remarks = $_REQUEST['remarks'];
		$priority = $_REQUEST['priority'];
		$purchasetype = $_REQUEST['purchasetype'];
		$currency = explode(',',$_REQUEST['currency']);
		$currency = $currency[1];
		$fxamount = $_REQUEST['fxamount'];
		$piemailfrom = $_REQUEST['piemailfrom'];
		$bamailfrom = $_REQUEST['bamailfrom'];
		$bamailcc = $_REQUEST['bamailcc'];
		$jobdescription = $_REQUEST['jobdescription'];
		$editor1 = $_POST['editor1'];

		$query3 = "select * from bill_formats where description = 'purchase_indent'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res3 = mysqli_fetch_array($exec3);
		$paynowbillprefix = $res3['prefix'];
		$paynowbillprefix1=strlen($paynowbillprefix);
		$query2 = "select * from purchase_indent order by auto_number desc limit 0, 1";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$billnumber = $res2["docno"];
		$billdigit=strlen($billnumber);
		$lpodate = $_POST['lpodate'];
		$is_blanket = $_REQUEST['blanket'];
		if ($billnumber == '')
		{
			$billnumbercode =$paynowbillprefix."-".'1'."-".date('y')."-".$location_auto;
			//$billnumbercode ='PI-'.'1';
			$openingbalance = '0.00';
		}
		else
		{
			$billnumber = $res2["docno"];
			$maxcount=split("-",$billnumber);
			$maxcount1=$maxcount[1];
			$maxanum = $maxcount1+1;
			$billnumbercode = $paynowbillprefix ."-".$maxanum."-".date('y')."-".$location_auto;
			//$billnumbercode = 'PI-' .$maxanum;
			$openingbalance = '0.00';
			//echo $companycode;
		}

		$searchsuppliername = $_REQUEST['supplier'];
		$searchsuppliercode = $_REQUEST['srchsuppliercode'];
		$searchsupplieranum = $_REQUEST['searchsupplieranum'];

		///////////////// GRN NUMBER /////////

		/* $query312 = "select * from bill_formats where description = 'external_mrn'";
		$exec312 = mysqli_query($GLOBALS["___mysqli_ston"], $query312) or die ("Error in Query312".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res312 = mysqli_fetch_array($exec312);
		$paynowbillprefix = $res312['prefix'];
		//$paynowbillprefix = 'MGR-';
		$paynowbillprefix13=strlen($paynowbillprefix);
		$query2233 = "select * from materialreceiptnote_details where billnumber like '%$paynowbillprefix-%' order by auto_number desc limit 0, 1";
		$exec2233 = mysqli_query($GLOBALS["___mysqli_ston"], $query2233) or die ("Error in Query2233".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2233 = mysqli_fetch_array($exec2233);
		$billnumber3 = $res2233["billnumber"];
		$billdigit3=strlen($billnumber3);
		if ($billnumber3 == '')
		{
			//$billnumbercode3 ='MGR-'.'1';
			$billnumbercode3 =$paynowbillprefix."-".'1'."-".date('y')."-".$location_auto;
			// $openingbalance = '0.00';
		}
		else
		{
			$billnumber3 = $res2233["billnumber"];
			$maxcount3=split("-",$billnumber3);
			$maxcount_3=$maxcount3[1];
			$maxanum = $maxcount_3+1;
			$billnumbercode3 = $paynowbillprefix ."-".$maxanum."-".date('y')."-".$location_auto;
			//$billnumbercode3 = 'MGR-' .$maxanum;
			// $openingbalance = '0.00';
		}
		///////////////// GRN NUMBER /////////
		///////////////// MLPO NUMBER GENERATE /////////

		$query31 = "select * from bill_formats where description = 'direct_purchase'";
		$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res31 = mysqli_fetch_array($exec31);
		$paynowbillprefix = $res31['prefix'];
		//$paynowbillprefix = 'MLPO-';
        $paynowbillprefix1=strlen($paynowbillprefix);
        $query3 = "select * from manual_lpo order by auto_number desc limit 0, 1";
        $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        $num3 = mysqli_num_rows($exec3);
        $res3 = mysqli_fetch_array($exec3);
        $billnumber1 = $res3['billnumber'];
        $billdigit=strlen($billnumber1);
        if($num3 >0)
        {
				$query22 = "select * from manual_lpo order by auto_number desc limit 0, 1";
				$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num22 = mysqli_num_rows($exec22);
				$res22 = mysqli_fetch_array($exec22);
				$billnumber1 = $res222["billnumber"];        
				$billdigit=strlen($billnumber1);
				if($billnumber1 != '')
				{
				$billnumbercode1 = $billnumber1;
				$docstatus = '';          
				}
				else
				{
				$query224 = "select * from manual_lpo order by auto_number desc limit 0, 1";
				$exec224 = mysqli_query($GLOBALS["___mysqli_ston"], $query224) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res224 = mysqli_fetch_array($exec224);
				$billnumber1 = $res224['billnumber'];
				$maxcount_1=split("-",$billnumber1);
				$maxcount_2=$maxcount_1[1];
				$maxanum = $maxcount_2+1;
				$billnumbercode1 = $paynowbillprefix ."-".$maxanum."-".date('y')."-".$location_auto;
				$openingbalance = '0.00';           
				$docstatus = 'new';
				}
        }
        else
        {
          $query22 = "select * from manual_lpo order by auto_number desc limit 0, 1";
          $exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
          $res22 = mysqli_fetch_array($exec22);
          $billnumber1 = $res22["billnumber"];
          $billdigit=strlen($billnumber1);
          if ($billnumber1 == '')
          {
            //$billnumbercode1 =$paynowbillprefix.'1';
			$billnumbercode1 =$paynowbillprefix."-".'1'."-".date('y')."-".$location_auto;
            $openingbalance = '0.00';
            $docstatus = 'new';
          }
        } */
  
	///////////////// MLPO NUMBER GENERATE /////////
	// $fxamount;fxpkrate fxtotamount
	//$searchsuppliername = $_REQUEST['searchsuppliername'];
    for ($u=1;$u<=2000;$u++)
    { 
		$medicinename = $_REQUEST['template_item'.$u];
		$medicinecode='';
		$pkgqty = 0;
		$reqqty = $_REQUEST['template_item_size'.$u];
		$rate =str_replace(',','',$_REQUEST['template_rate'.$u]) ;
		$tax_percent =str_replace(',','',$_REQUEST['template_tax'.$u]) ;
		$amount =str_replace(',','',$_REQUEST['template_amount'.$u]);
		$checked_temp =$_REQUEST['check_template'.$u];
		$tax_amount = 0;
		if($tax_percent > 0)
		{
		$tax_amount = $amount - ( $rate *  $reqqty);
		}
     
			if($checked_temp)
			{
			if ($medicinename != "" && $amount>0)
			{
				$query43="insert into purchase_indent(date,docno,medicinename,medicinecode,quantity,packagequantity,rate,amount,username,status,remarks,faremarks,companyanum,location,locationname,locationcode,storecode,storename,purchasetype,currency,fxamount,originalqty,originalamt,originalrate,suppliername,suppliercode,supplieranum,pimailfrom,bamailfrom,bamailcc,indent_memo,priority,job_title,approvalstatus,bausername,fausername,ceousername,pogeneration,s_terms,tax_percentage,tax_amount,povalidity,is_blanket,purchaserequest_from)values
				('$dateonly','$billnumbercode','$medicinename','$medicinecode','$reqqty','$pkgqty','$rate','$amount','$username','$status','$remarks','$remarks','$companyanum','$location','".$locationname."','".$locationcode."','".$storecode."','".$store."','$purchasetype','$currency','$fxamount','$reqqty','$amount','$rate','$searchsuppliername','$searchsuppliercode','$searchsupplieranum','$piemailfrom','$bamailfrom','$bamailcc','$remarks','$priority','$job_title','pending','$username','$username','$username', 'pending','$editor1','$tax_percent','$tax_amount','$lpodate','$is_blanket','direct_purchase')";
				$exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));     

				/*if($is_blanket=='yes')
				$received_status = '';
				else
				$received_status = 'received';
				$query56="INSERT into manual_lpo(companyanum,billnumber,itemcode,itemname,rate,quantity,totalamount,username, ipaddress, entrydate,purchaseindentdocno,purchasetype,suppliername,suppliercode,supplieranum,recordstatus,docstatus,locationname,locationcode,storename,storecode,currency,fxamount,fxpkrate,fxtotamount,remarks,job_title,goodsstatus,itemtaxpercentage,itemtaxamount,is_blanket) values('$companyanum','$billnumbercode1','$itemcode','$medicinename','$rate','$reqqty','$amount','$username','$ipaddress','$currentdate','$docno','$purchasetype','$searchsuppliername','$searchsuppliercode','$searchsupplieranum','generated','$docstatus','$locationname','$locationcode','$storename','$storecode','$currency','$fxamount','$rate','$amount','$baremarks','$job_title','','$tax_percent','$tax_amount','$is_blanket')";
				// fxpkrate fxtotamount 
				$exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));    
				
				/////////////////// MLPO ///////////// goods RECIVED NOTES //////////////

				if($is_blanket=='no'){
				$query4 = "insert into materialreceiptnote_details (bill_autonumber, companyanum, billnumber, itemanum, itemcode, itemname, itemdescription, rate, quantity, 
				subtotal, free, discountpercentage, discountrupees, openingstock, closingstock, totalamount, discountamount, username, ipaddress, entrydate, itemtaxpercentage, itemtaxamount, unit_abbreviation, batchnumber, salesprice, expirydate, itemfreequantity, itemtotalquantity, packageanum, packagename, quantityperpackage, allpackagetotalquantity,manufactureranum,manufacturername,typeofpurchase,suppliername,suppliercode,supplieranum,ponumber,supplierbillnumber,costprice,locationcode,store,coa,categoryname,fifo_code,totalfxamount,fxpkrate,priceperpk,deliverybillno,currency,fxamount,ledgeranum,ledgercode,ledgername ,incomeledger,incomeledgercode,purchasetype) 
				values ('$billautonumber', '$companyanum', '$billnumbercode3', '$itemanum', '$itemcode', '$medicinename', '$itemdescription', '$rate', '$reqqty', '$amount', '$free', '$itemdiscountpercent', '$itemdiscountrupees', '$openingstock', '$closingstock', '$amount', '$discountamount', '$username', '$ipaddress', '$currentdate', '$tax_percent', '$tax_amount', '$itemunitabb', '$batchnumber', '$salesprice', '$currentdate', '$free', '$reqqty', '$packageanum', '$packagename', '$quantityperpackage', '$reqqty', '$manufactureranum', '$manufacturername', 'Process', '$searchsuppliername', '$searchsuppliercode', '$searchsupplieranum', '$billnumbercode1', '$supplierbillno', '$rate', '$locationcode', '$store', '$coa', '$categoryname', '', '$amount', '$rate', '$rate', '$deliverybillno', '$currency', '$fxamount', '$ledgeranum', '$ledgercode', '$ledgername', '$incomeledger', '$incomeledgercode','$purchasetype')";
				$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				}*/
			}
		}
     }
		
		for ($p=1;$p<=2000;$p++)
		{ 
		$medicinename = $_REQUEST['medicinename'.$p];
		$medicinecode='';
		$pkgqty = str_replace(',','',$_REQUEST['req_qty'.$p]);
		$reqqty = $_REQUEST['reqqty'.$p];
		$rate =str_replace(',','',$_REQUEST['rate'.$p]) ;
		$tax_percent =str_replace(',','',$_REQUEST['tax_percent'.$p]) ;
		$amount =str_replace(',','',$_REQUEST['amount'.$p]);
		$tax_amount = 0;
		if($tax_percent > 0)
		{
		$tax_amount = $amount - ( $rate *  $reqqty);
		}

		if ($medicinename != "")
		{
				$query43="insert into purchase_indent(date,docno,medicinename,medicinecode,quantity,packagequantity,rate,amount,username,status,remarks,faremarks,companyanum,location,locationname,locationcode,storecode,storename,purchasetype,currency,fxamount,originalqty,originalamt,originalrate,suppliername,suppliercode,supplieranum,pimailfrom,bamailfrom,bamailcc,indent_memo,priority,job_title,approvalstatus,bausername,fausername,ceousername,pogeneration,s_terms,tax_percentage,tax_amount,povalidity,is_blanket,purchaserequest_from)values
				('$dateonly','$billnumbercode','$medicinename','$medicinecode','$reqqty','$pkgqty','$rate','$amount','$username','$status','$remarks','$remarks','$companyanum','$location','".$locationname."','".$locationcode."','".$storecode."','".$store."','$purchasetype','$currency','$fxamount','$reqqty','$amount','$rate','$searchsuppliername','$searchsuppliercode','$searchsupplieranum','$piemailfrom','$bamailfrom','$bamailcc','$remarks','$priority','$job_title','pending','$username','$username','$username', 'pending','$editor1','$tax_percent','$tax_amount','$lpodate','$is_blanket','direct_purchase')";
				$exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));     

			/*if($is_blanket=='yes')
				$received_status = '';
			else
				$received_status = 'received';
				$query56="INSERT into manual_lpo(companyanum,billnumber,itemcode,itemname,rate,quantity,totalamount,username, ipaddress, entrydate,purchaseindentdocno,purchasetype,suppliername,suppliercode,supplieranum,recordstatus,docstatus,locationname,locationcode,storename,storecode,currency,fxamount,fxpkrate,fxtotamount,remarks,job_title,goodsstatus,itemtaxpercentage,itemtaxamount,is_blanket) values('$companyanum','$billnumbercode1','$itemcode','$medicinename','$rate','$reqqty','$amount','$username','$ipaddress','$currentdate','$docno','$purchasetype','$searchsuppliername','$searchsuppliercode','$searchsupplieranum','generated','$docstatus','$locationname','$locationcode','$storename','$storecode','$currency','$fxamount','$rate','$amount','$baremarks','$job_title','','$tax_percent','$tax_amount','$is_blanket')";
				$exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				
				// $query55="update purchase_indent set pogeneration='completed' where docno='$docno' and auto_number='$auto_number'";
				// $exec55=mysql_query($query55) or die(mysql_error());
				/////////////////// MLPO ///////////// goods RECIVED NOTES //////////////

			if($is_blanket=='no'){
				
				$query4 = "insert into materialreceiptnote_details (bill_autonumber, companyanum, billnumber, itemanum, itemcode, itemname, itemdescription, rate, quantity, subtotal, free, discountpercentage, discountrupees, openingstock, closingstock, totalamount, discountamount, username, ipaddress, entrydate, itemtaxpercentage, itemtaxamount, unit_abbreviation, batchnumber, salesprice, expirydate, itemfreequantity, itemtotalquantity, packageanum, packagename, quantityperpackage, allpackagetotalquantity,manufactureranum,manufacturername,typeofpurchase,suppliername,suppliercode,supplieranum,ponumber,supplierbillnumber,costprice,locationcode,store,coa,categoryname,fifo_code,totalfxamount,fxpkrate,priceperpk,deliverybillno,currency,fxamount,ledgeranum,ledgercode,ledgername ,incomeledger,incomeledgercode,purchasetype) 
				values ('$billautonumber', '$companyanum', '$billnumbercode3', '$itemanum', '$itemcode', '$medicinename', '$itemdescription', '$rate', '$reqqty', '$amount', '$free', '$itemdiscountpercent', '$itemdiscountrupees', '$openingstock', '$closingstock', '$amount', '$discountamount', '$username', '$ipaddress', '$currentdate', '$tax_percent', '$tax_amount', '$itemunitabb', '$batchnumber', '$salesprice', '$currentdate', '$free', '$reqqty', '$packageanum', '$packagename', '$quantityperpackage', '$reqqty', '$manufactureranum', '$manufacturername', 'Process', '$searchsuppliername', '$searchsuppliercode', '$searchsupplieranum', '$billnumbercode1', '$supplierbillno', '$rate', '$locationcode', '$store', '$coa', '$categoryname', '', '$amount', '$rate', '$rate', '$deliverybillno', '$currency', '$fxamount', '$ledgeranum', '$ledgercode', '$ledgername', '$incomeledger', '$incomeledgercode','$purchasetype')";
				$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				}*/
		}
		}
        $action='purchaseindent';
        header("location:direct_purchase.php?success=success");
        exit;
  }
  else
  {
  header("location:direct_purchase.php?success=Failed");
  exit;
  }
}
//to redirect if there is no entry in masters category or item or customer or settings
//To get default tax from autoitemsearch1.php and autoitemsearch22.php - for CST tax override.
if (isset($_REQUEST["defaulttax"])) { $defaulttax = $_REQUEST["defaulttax"]; } else { $defaulttax = ""; }
if (isset($_REQUEST["success"])) { $success = $_REQUEST["success"]; } else { $success = ""; }
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
if(isset($_REQUEST["patientcode"]))
{
$patientcode=$_REQUEST["patientcode"];
$visitcode=$_REQUEST["visitcode"];
}
//This include updatation takes too long to load for hunge items database.
//To populate the autocompetelist_services1.js
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
if ($delbillst == "" && $delbillnumber == "")
{
  $res41customername = "";
  $res41customercode = "";
  $res41tinnumber = "";
  $res41cstnumber = "";
  $res41address1 = "";
  $res41deliveryaddress = "";
  $res41area = "";
  $res41city = "";
  $res41pincode = "";
  $res41billdate = "";
  $billnumberprefix = "";
  $billnumberpostfix = "";
}
?>
<?php
$query3 = "select * from bill_formats where description = 'purchase_indent'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = $res3['prefix'];
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from purchase_indent order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
  
  $billnumbercode =$paynowbillprefix."-".'1'."-".date('y')."-".$location_auto;
  $openingbalance = '0.00';
}
else
{
  $billnumber = $res2["docno"];
/*
  $billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
  //echo $billnumbercode;
  $billnumbercode = intval($billnumbercode);
  $billnumbercode = $billnumbercode + 1;
  $maxanum = $billnumbercode;*/
  
        $maxcount=split("-",$billnumber);
		$maxcount1=$maxcount[1];
		$maxanum = $maxcount1+1;
  
  $billnumbercode = $paynowbillprefix ."-".$maxanum."-".date('y')."-".$location_auto;
  //$billnumbercode = 'PI-' .$maxanum;
  $openingbalance = '0.00';
  //echo $companycode;
}
$query = "select * from login_locationdetails where username='$username' and docno='$docno1' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
  
   $locationname  = $res["locationname"];
   $locationcode = $res["locationcode"];
$query23 = "select * from master_employeelocation where username='$username' and defaultstore='default' and locationcode='".$locationcode."'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$res7storeanum = $res23['storecode'];
$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res75 = mysqli_fetch_array($exec75);
$store = $res75['store'];
$storecode = $res75['storecode'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direct Purchase - MedStar Hospital Management</title>
    <link rel="stylesheet" type="text/css" href="css/vat-modern.css" />
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    <link rel="stylesheet" type="text/css" href="css/autocomplete.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script language="javascript">
function deletevalid()
{
var del;
del=confirm("Do You want to delete this referal ?");
if(del == false)
{
return false;
}
}
function btnDeleteClick10(delID4,vrate4)
{
  //alert ("Inside btnDeleteClick.");
  var newtotal;
  //alert(delID4);
  var varDeleteID4= delID4;
  //alert(vrate4);
  //alert (varDeleteID3);
  var fRet7; 
  fRet7 = confirm('Are You Sure Want To Delete This Entry?'); 
  //alert(fRet); 
  if (fRet7 == false)
  {
    //alert ("Item Entry Not Deleted.");
    return false;
  }
  var child4 = document.getElementById('idTR'+varDeleteID4);  
  //alert (child3);//tr name
    var parent4 = document.getElementById('insertrow'); // tbody name.
  document.getElementById ('insertrow').removeChild(child4);
  var child4= document.getElementById('idTRaddtxt'+varDeleteID4);  //tr name
    var parent4 = document.getElementById('insertrow'); // tbody name.
  
  if (child4 != null) 
  {
    //alert ("Row Exsits.");
    document.getElementById ('insertrow').removeChild(child4);
  }
  var currenttotal=document.getElementById('total').value.replace(/[^0-9\.]+/g,"");
  //alert(currenttotal);
  newtotal= currenttotal-vrate4;
//alert(newtotal);
document.getElementById('total').value=formatMoney(newtotal.toFixed(2));
 currencyfix();  
}
</script>
<?php //include ("js/sales1scripting1.php"); ?>
<script>
  function is_int(){ 
    // var decimal=  /^[-+]?[0-9]+\.[0-9]+$/; 
    // var decimal= /^[-+][0-9]+\.[0-9]+[eE][-+]?[0-9]+$/;  
// if(as.match(decimal)) {
  var v=document.getElementById("req_qty").value;
  if((parseFloat(v) == parseInt(v)) && !isNaN(v)){
      return true;
  } else { 
  alert("Quantity should be integer");
  $('#req_qty').val('0.00');
 // if (isNaN(amount)) a = 0;
      return false;
  } 
}
  function is_int_r(value){ 
  if((parseFloat(value) == parseFloat(value)) && !isNaN(value)){
      return true;
  } else { 
  // alert("Rate should be In numbers");
  document.getElementById("rate_fx").value='0';
  
      return false;
  } 
}
 
  function CalculateAmount(){
// /^\d*$/.req_qty(value);
// /^\d*$/.rate_fx(value);
 var medicinename = $('#medicinename').val();
var item_code = '';
 if(medicinename == '')
 {
   alert('Please Enter Item Description');
   $('#req_qty').val('');
   $('#medicinename').focus();
 }
/////////////////////// new
var new_rate=$('#rate_fx').val();
new_rate=new_rate.replace(/,/g,''); 
// new_rate = parseFloat(new_rate).toFixed(2);
          new_rate = new_rate.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
		  //alert(new_rate); 
$('#rate_fx').val(new_rate);
/////////////////////// new
  var req_qty=($.trim($('#req_qty').val())!='')?$.trim($('#req_qty').val()):'0';
  // var req_qty=($.trim($('#req_qty').val())!='')?$.trim($('#req_qty').val()):'0';
  // is_int_q(req_qty);
  // var rate=($.trim($('#rate_fx').val())!='');
      var  rate=$("#rate_fx").val(); // 123,33.00
          rate=rate.replace(/,/g,''); 
  var rate=($.trim($('#rate_fx').val())!='')?$.trim(rate):'0.00';
  // $('#rate_fx').val(rate);
  is_int_r(rate);
  
  var tax=$('#tax_percent').val();
  // var percent=tax_data.split('|');
  // var tax=percent[1];
  // var exclude_goods=percent[0];
  // if(exclude_goods==1)
  // {
  //   tax=0;
  // }
  //var tax=$.trim($('#tax_template_value').val());
  var fxrate=($.trim($('#fxrate').val())!='')?$.trim($('#fxrate').val()):'1.00';
  //var fxrate=
    var package_qnty = $('#package_qty').val();
 
 var main_rate = $('#rate').val();
  main_rate=main_rate.replace(/,/g,''); 
 if(req_qty!='0' && item_code == '' && medicinename!='' && tax!='')
 {
   $('#rate_fx').prop('readonly',false);
   $('#rate').val(rate);
   $('#pack_size').val('1S');
    var req_pkg_qnty = parseFloat(req_qty)/1;
   $('#pkg_qty').val(req_pkg_qnty);
 }
 else 
 {
   var req_pkg_qnty = parseFloat(req_qty)/parseFloat(package_qnty);
  
  $('#pkg_qty').val(req_pkg_qnty);
 }
 // if(req_qty=='0' || req_qty=="")
 // {
 //   $('#amount').val('0.00');
 // }else{
 
 var total_main_amount = parseFloat(req_qty*main_rate);
  $('#main_amount').val(total_main_amount);
  
  // rate=(rate/fxrate);
  var total1=parseFloat(req_qty*rate);
 
  var total2=parseFloat(total1*tax) / 100;
  $('#tax_amount').val(total2);
   var total3=parseFloat(total2+total1);
    // var total_amount=parseFloat(req_qty*rate).toFixed(2); 
     var total_amount1=parseFloat(total3).toFixed(2); 
      total_amount1 = total_amount1.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"); 
     $('#amount').val(total_amount1);
     console.log(~~NaN);
   // }
  
}
function calc()
{
  var reqqty=document.getElementById("reqqty").value;
  var packsize=document.getElementById("packsize").value;
  var purchasetype=document.getElementById("purchasetype").value;
  var fxamount=document.getElementById("fxamount").value;
  var packvalue=packsize.substring(0,packsize.length - 1);
  
  var rt = document.getElementById("rate").value.replace(/[^0-9\.]+/g,"");
  document.getElementById("fxrate").value=parseFloat(fxamount*rt);
  var rate=document.getElementById("fxrate").value.replace(/[^0-9\.]+/g,"");
  
    rate = parseFloat(rate)/parseFloat(fxamount);
  //}
  if(reqqty!='')
      reqqty = reqqty.replace(/[^0-9\.]+/g,"");
  var amount=parseFloat(reqqty) * parseFloat(rate);
  document.getElementById("amount").value=formatMoney(amount.toFixed(2));
  var pkgqty=reqqty/packvalue;
  packvalue=parseInt(packvalue);
  if(reqqty < packvalue)
  {
    pkgqty=1;
  } 
  if(purchasetype!='non-medical')
  {
    document.getElementById("pkgqty").value=Math.round(pkgqty);
  }
  else
  {
  document.getElementById("pkgqty").value=Math.round(1);
  }
  
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
</script>
<script type="text/javascript" src="js/directpurchase_insert.js"></script>
<script src="js/datetimepicker_css.js"></script>
<?php include ("js/dropdownlist1scriptingpurchaseorder.php"); ?>
<script type="text/javascript" src="js/autocomplete_purchaseorder.js"></script>
<script type="text/javascript" src="js/autosuggestpurchaseorder.js"></script>
<script type="text/javascript" src="js/povalidity.js"></script>
<style type="text/css">
.bodytext3 {  FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
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
.bodytext33 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
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
input[name="priority"] {
  -webkit-appearance: checkbox; /* Chrome, Safari, Opera */
  -moz-appearance: checkbox;    /* Firefox */
  -ms-appearance: checkbox;     /* not currently supported */
}
.savebutton{
  font-size: 15px;
  width: 100px;
    height: 35px;
}
.bal
{
border-style:none;
background:none;
text-align:right;
FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma;
}
</style>
<script type="text/javascript" src="ckeditor1/ckeditor.js"></script>
<script src="js/datetimepicker_css.js"></script>
<?php //include("autocompletebuild_medicine1.php"); ?>
<?php //include("js/dropdownlist1scriptingmedicine1.php"); ?>
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/autocomplete_medicine1.js"></script>
<script type="text/javascript" src="js/automedicinecodesearch5kiambu1.js"></script>
<script type="text/javascript" src="js/jquery.min-autocomplete.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript">
  $(function() {
$('#supplier').autocomplete({
  source:'ajaxsuppliernewserach.php', 
  select: function(event,ui){
      var code = ui.item.id;
      var anum = ui.item.anum;
      $('#srchsuppliercode').val(code);
      $('#searchsupplieranum').val(anum);
      // this.form.submit();
      },
  html: true
    });
	
	$('#map_template').autocomplete({
  source:'ajaxpurchase_templatesearch.php', 
  select: function(event,ui){
      var code = ui.item.id;
      var anum = ui.item.anum;
      $('#map_template_code').val(code);
      $('#map_template_auto').val(anum);
	  if(code!='')
	  {
		$.ajax({
		type: "get",
		url: "ajaxpurchase_templatesearch.php?templateid="+code+'&source='+"getid",
		success: function(html){
		$("#display_items").empty();
		$('#display_items').append(html);
		}
		});
	  }
	//window.open("direct_purchase.php?templateid="+code);
   // window.opener.location.reload();
      },
  html: true
    });
  /*$('#supplier').change(function() {
        if($('#srchsuppliercode').val() !="")
        this.form.submit();
    });*/
   getValidityDays();
});
function cal_amt(val,id)
{
	
var supplier=document.getElementById("supplier").value;
if(supplier=='')
{
alert('Please Select Supplier');
document.getElementById("supplier").focus();
return false;
}
	/*if(document.getElementById("check_template"+id).checked == true)
	{*/
var new_rate = val.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
$("#template_rate"+id).val(new_rate);
var val=val.replace(/,/g,''); 
var amt='0.00';
var get_qty='0.00';
var get_qty=$("#template_item_size"+id).val();
var amt = parseFloat(get_qty) * parseFloat(val);
var amt = amt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
if(amt!='NaN')
{
$("#template_amount"+id).val(amt);
}
	//}
	
	
	
}
function cal_amt_second(val,id)
{
$('#check_template'+id).prop('checked', false); // Unchecks it	
//get_item(id);
var supplier=document.getElementById("supplier").value;
if(supplier=='')
{
alert('Please Select Supplier');
document.getElementById("supplier").focus();
return false;
}
var val=val.replace(/,/g,''); 
var amt='0.00';
var get_qty='0.00';
var get_qty=$("#template_item_size"+id).val();
var val = document.getElementById('template_rate'+id).value.replace(/[^0-9\.]+/g,"");
var amt = parseFloat(get_qty) * parseFloat(val);
var amt = amt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
if(amt!='NaN')
{
$("#template_amount"+id).val(amt);
}
	//}
	
	
	
}
function get_item(id)
{
var amt='0';	
	if(document.getElementById("check_template"+id).checked == false)
	{
	
		
		
var currenttotal=document.getElementById('total').value.replace(/[^0-9\.]+/g,"");
var vrate4=document.getElementById('template_amount'+id).value.replace(/[^0-9\.]+/g,"");
if(vrate4>0)
{
newtotal= currenttotal-vrate4;
//alert(newtotal);
document.getElementById('total').value=formatMoney(newtotal.toFixed(2));
$("#template_rate"+id).val('');
$("#template_amount"+id).val('');
}
 
	}
	else
	{
	if(document.getElementById('total').value=='')
	{
	var totalamount='0';
	}
	else
	{
	var totalamount=document.getElementById('total').value;
	}
	var amt=document.getElementById('template_amount'+id).value.replace(/[^0-9\.]+/g,"");
	if(amt>0)
	{
	totalamount=parseFloat(totalamount.replace(/[^0-9\.]+/g,"")) + parseFloat(amt.replace(/[^0-9\.]+/g,""));
	//alert(totalamount+"second");
	document.getElementById("total").value=formatMoney(totalamount.toFixed(2));
	}
	
	}
	 
	/*if($('#frmsales').find('input[type=checkbox]:checked').length >1)
    {
		alert('Please Check One Checkbox');
	}
	if(document.getElementById("check_template"+id).checked == true)
	{
	var itemname=$("#template_item"+id).val();
	var itemnqty=$("#template_item_size"+id).val();
	$("#medicinename").val(itemname);
	$("#req_qty").val(itemnqty);
	}
	else
	{
		$("#medicinename").val('');
		$("#req_qty").val('');
	}*/
	
}
function clickmedicine()
{
  var blanket=document.getElementById("blanket").value;
  if(blanket=='')
  {
    alert('Please Select blanket');
    document.getElementById("blanket").focus();
    return false;
  }
  var currency=document.getElementById("currency").value;
  if(currency=='')
  {
    alert('Please Select currency');
    document.getElementById("currency").focus();
    return false;
  }
  var supplier=document.getElementById("supplier").value;
  if(supplier=='')
  {
    alert('Please Select Supplier');
    document.getElementById("supplier").focus();
    return false;
  }
}
function getValidityDays() {
    var d1 = parseDate($('#todaydate').val());
    var d2 = parseDate($('#lpodate').val());
    console.log(d1)
    console.log('d2'+d2)
    var oneDay = 24*60*60*1000;
    var diff = 0;
    if (d1 && d2) {
  
      diff = Math.round(Math.abs((d2.getTime() - d1.getTime())/(oneDay)));
      console.log('diff'+diff);
    }
    $('#validityperiod').val(diff);
}
function parseDate(input) {
  var parts = input.match(/(\d+)/g);
  // new Date(year, month [, date [, hours[, minutes[, seconds[, ms]]]]])
  return new Date(parts[0], parts[1]-1, parts[2]); // months are 0-based
}
function savechk(){
var del;
del=confirm("Do You want to save?");
if(del == false)
{
return false;
}
else
	return true;
}
function spl() {
	    var key = event.keyCode || event.charCode;
   if(key=='222')
   {
	   //alert('yes');
	   return false;
   }
		/*var data = document.form1.itemname.value;
		//alert(data);
		// var iChars = "!%^&*()+=[];,.{}|\:<>?~"; //All special characters.
		var iChars = "!^+=[];,{}|\<>?~";
		for (var i = 0; i < data.length; i++) {
			if (iChars.indexOf(data.charAt(i)) != -1) {
				alert("Your pharmacy Item Name Has Special Characters. Like ! ^ + = [ ] ; , { } | \ < > ? ~ These are not allowed.");
				return false;
			}
		}*/
	}
</script>
</head>
      
<body>
    <!-- Modern Header -->
    <header class="modern-header">
        <div class="header-content">
            <div class="hospital-logo">
                <div class="hospital-icon">
                    <i class="fas fa-hospital"></i>
                </div>
                <div class="hospital-info">
                    <h1>MedStar Hospital Management</h1>
                    <p>Direct Purchase Order System</p>
                </div>
            </div>
            <div class="user-info">
                <div class="user-avatar">
                    <?php echo strtoupper(substr($username, 0, 2)); ?>
                </div>
                <div class="user-details">
                    <h3><?php echo $username; ?></h3>
                    <p><?php echo $companyname; ?></p>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <div class="breadcrumb-content">
            <div class="breadcrumb">
                <a href="dashboard.php">Dashboard</a>
                <span class="breadcrumb-separator">›</span>
                <a href="purchase_management.php">Purchase Management</a>
                <span class="breadcrumb-separator">›</span>
                <span>Direct Purchase</span>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Success Message -->
        <?php if($success=='success'){ ?>
        <div class="success-message">
            <div class="success-icon">
                <i class="fas fa-check"></i>
            </div>
            <div>
                <strong>Transaction Successfully Saved</strong>
                <p>Your purchase order has been created successfully.</p>
            </div>
        </div>
        <?php } ?>

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-title">
                <div class="page-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div>
                    <h1>Direct Purchase Order</h1>
                    <p class="page-subtitle">Create and manage direct purchase orders for medical supplies and equipment</p>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="quick-actions">
                <a href="purchase_order_list.php" class="action-btn">
                    <i class="fas fa-list"></i>
                    View Orders
                </a>
                <a href="supplier_management.php" class="action-btn">
                    <i class="fas fa-users"></i>
                    Manage Suppliers
                </a>
                <a href="template_management.php" class="action-btn">
                    <i class="fas fa-file-alt"></i>
                    Templates
                </a>
            </div>
        </div>

        <form name="form1" id="frmsales" method="post" action="direct_purchase.php">
            <!-- Purchase Order Details -->
            <div class="form-container">
                <div class="form-header">
                    <div class="form-header-icon">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <h2>Purchase Order Details</h2>
                </div>
                <div class="form-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="docno">Document Number</label>
                            <input type="text" name="docno" id="docno" class="form-control" value="<?php echo $billnumbercode; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="text" name="date" id="date" class="form-control" value="<?php echo $dateonly; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="location">Location</label>
                            <input type="text" name="location" id="location" class="form-control" value="<?php echo $locationname; ?>" readonly>
                            <input type="hidden" name="locationcode" value="<?php echo $locationcode?>">
                        </div>
                        <div class="form-group">
                            <label for="map_template">Template</label>
                            <input type="text" name="map_template" id="map_template" class="form-control" value="<?php echo $map_template; ?>" autocomplete="off" placeholder="Search for template...">
                            <input type="hidden" name="map_template_code" id="map_template_code" value="<?php echo $map_template_code; ?>">
                            <input type="hidden" name="map_template_autono" id="map_template_autono" value="<?php echo $map_template_autono ?>">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Purchase Configuration -->
            <div class="form-container">
                <div class="form-header">
                    <div class="form-header-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h2>Purchase Configuration</h2>
                </div>
                <div class="form-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="blanket">Blanket Order</label>
                            <select name="blanket" id="blanket" class="form-control form-select">
                                <option value="no">No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="currency">Currency</label>
                            <select name="currency" id="currency" class="form-control form-select">
                                <?php
                                $query1currency = "select currency,rate from master_currency where recordstatus = '' ";
                                $exec1currency = mysqli_query($GLOBALS["___mysqli_ston"], $query1currency) or die ("Error in Query1currency".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1currency = mysqli_fetch_array($exec1currency))
                                {
                                    $currency = $res1currency["currency"];
                                    $rate = $res1currency["rate"];
                                ?>
                                <option value="<?php echo $rate.','.$currency; ?>"><?php echo $currency; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fxamount">FX Rate</label>
                            <input name="fxamount" type="text" id="fxamount" class="form-control" value="1" readonly>
                        </div>
                        <div class="form-group">
                            <label for="supplier">Supplier</label>
                            <input type="text" name="supplier" id="supplier" class="form-control" value="<?php echo $suppliername; ?>" autocomplete="off" placeholder="Search for supplier...">
                            <input type="hidden" name="srchsuppliercode" id="srchsuppliercode" value="<?php echo $suppliercode; ?>">
                            <input type="hidden" name="searchsupplieranum" id="searchsupplieranum" value="<?php echo $srchsupplieranum ?>">
                        </div>
                    </div>
                </div>
            </div>
            <?php 
            $query1mail = "select emailto,emailcc from master_email where recordstatus <> 'deleted' and module='Purchase Indent' order by auto_number desc";
            $exec1mail = mysqli_query($GLOBALS["___mysqli_ston"], $query1mail) or die ("Error in Query1mail".mysqli_error($GLOBALS["___mysqli_ston"]));
            while ($res1mail = mysqli_fetch_array($exec1mail))
            {
              $emailto = $res1mail["emailto"];
              $emailcc = $res1mail["emailcc"];
            }
            $query1mail = "select mei.email,me.jobdescription from master_employee me,master_employeeinfo mei where me.username='$username' and me.employeecode=mei.employeecode";
            $exec1mail = mysqli_query($GLOBALS["___mysqli_ston"], $query1mail) or die ("Error in Query1mail".mysqli_error($GLOBALS["___mysqli_ston"]));
            while ($res1mail = mysqli_fetch_array($exec1mail))
            {
              $useremail = $res1mail["email"];
              $jobdescription = $res1mail["jobdescription"];
            }
            ?>
            <input type="hidden" name="piemailfrom" id="piemailfrom" value="<?php echo $useremail;?>">
            <input type="hidden" name="jobdescription" id="jobdescription" value="<?php echo $jobdescription;?>">
            <input type="hidden" name="bamailfrom" id="bamailfrom" value="<?php echo $emailto;?>">
            <input type="hidden" name="bamailcc" id="bamailcc" value="<?php echo $emailcc;?>">

            <!-- Template Items Section -->
            <?php if($templateid!=''){ ?>
            <div class="template-section">
                <div class="template-header">
                    <div class="template-icon">
                        <i class="fas fa-list"></i>
                    </div>
                    <h3>Template Items</h3>
                </div>
                <div class="template-items">
                    <?php 
                    $query_wht1 = "SELECT itemname,quantity from purchase_templatelinking where template_id='$templateid'";
                    $exec_wht1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_wht1) or die ("Error in query_wht1".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while ($res_wht1 = mysqli_fetch_array($exec_wht1))
                    { 
                        $itemname = $res_wht1['itemname'];
                        $quantity = $res_wht1['quantity'];
                        $crm=$crm+1;  
                    ?>
                    <div class="template-item">
                        <input name="check_template<?php echo $crm;?>" type="checkbox" class="template-checkbox" id="check_template<?php echo $crm;?>" onClick="get_item('<?php echo $crm;?>');">
                        <div class="template-item-name"><?php echo $itemname; ?></div>
                        <div class="template-item-qty"><?php echo $quantity; ?></div>
                        <input type="hidden" name="template_item<?php echo $crm;?>" id="template_item<?php echo $crm;?>" value="<?php echo $itemname;?>">
                        <input type="hidden" name="template_item_size<?php echo $crm;?>" id="template_item_size<?php echo $crm;?>" value="<?php echo $quantity;?>">
                    </div>
                    <?php } ?>
                </div>
                <input type="hidden" id="template_item_count" value="<?php echo $crm;?>"/>
            </div>
            <?php } ?>

            <!-- Items Section -->
            <div class="items-section">
                <div class="items-header">
                    <div class="items-header-icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <h3>Purchase Items</h3>
                </div>
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Item Description</th>
                            <th>Quantity</th>
                            <th>Rate</th>
                            <th>Tax %</th>
                            <th>Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="insertrow">
                        <!-- Items will be added here dynamically -->
                    </tbody>
                </table>
                <!-- Add Item Form -->
                <div class="add-item-form">
                    <div class="add-item-grid">
                        <div class="form-group">
                            <label for="medicinename">Item Description</label>
                            <input name="medicinename" type="text" id="medicinename" class="form-control" autocomplete="off" onClick="clickmedicine();" onkeydown="return spl()" placeholder="Enter item description...">
                            <input type="hidden" name="medicinenamel" id="medicinenamel" value="">
                        </div>
                        <div class="form-group">
                            <label for="req_qty">Quantity</label>
                            <input name="req_qty" type="number" id="req_qty" class="form-control" onKeyUp="CalculateAmount()" onChange="CalculateAmount()" placeholder="Qty">
                        </div>
                        <div class="form-group">
                            <label for="rate_fx">Rate</label>
                            <input id="rate_fx" name="rate_fx" type="text" class="form-control" onKeyUp="CalculateAmount()" placeholder="Rate">
                            <input id="rate" name="rate" type="hidden" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tax_percent">Tax %</label>
                            <select name="tax_percent" id="tax_percent" class="form-control form-select" onchange="CalculateAmount()">
                                <?php 
                                $query_wht = "SELECT * from master_tax";
                                $exec_wht = mysqli_query($GLOBALS["___mysqli_ston"], $query_wht) or die ("Error in query_wht".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res_wht = mysqli_fetch_array($exec_wht))
                                { ?>
                                <option value="<?=$res_wht['taxpercent'];?>"><?=ucwords($res_wht['taxname']) ;?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input name="amount" type="text" id="amount" class="form-control" readonly placeholder="Amount">
                        </div>
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="button" name="Add" id="Add" onClick="return insertitem10()" class="add-item-btn">
                                <i class="fas fa-plus"></i>
                                Add Item
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="serialnumber" id="serialnumber" value="1">
                    <input type="hidden" name="h" id="h" value="0">
                </div>
            </div>
            <!-- Total Section -->
            <div class="total-section">
                <div class="total-display">
                    <div class="total-label">Total Amount</div>
                    <div class="total-amount" id="total-display">$0.00</div>
                </div>
                <input type="text" id="total" readonly style="display: none;">
            </div>

            <!-- Validity Section -->
            <div class="validity-section">
                <div class="validity-grid">
                    <div class="validity-label">Valid Till:</div>
                    <div class="validity-input">
                        <?php 
                        $default_lpo_date = date('Y-m-d', strtotime("+30 days"));
                        ?>
                        <input name="lpodate" id="lpodate" class="form-control" value="<?php echo $default_lpo_date; ?>" readonly onChange="return getValidityDays();"/>
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('lpodate','yyyyMMdd','','','','','future')" style="cursor:pointer"/>
                    </div>
                    <div class="validity-days">
                        <input type="text" name="validityperiod" id="validityperiod" value="" readonly>
                        <span>Days</span>
                    </div>
                </div>
                <input type="hidden" name="todaydate" id="todaydate" value="<?php echo date('Y-m-d'); ?>">
            </div>
            <!-- Terms Section -->
            <div class="terms-section">
                <div class="terms-header">
                    <div class="terms-icon">
                        <i class="fas fa-file-contract"></i>
                    </div>
                    <h3>Supplier Terms and Conditions</h3>
                </div>
                <?php
                $query7 = "select * from master_po_terms";
                $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res7 = mysqli_fetch_array($exec7);
                $terms = $res7['terms'];
                ?>
                <textarea id="consultation" class="terms-editor ckeditor" name="editor1"><?php echo $terms;?></textarea>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <input type="hidden" name="frm1submit1" value="frm1submit1" />
                <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                
                <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                    <i class="fas fa-arrow-left"></i>
                    Cancel
                </button>
                
                <button type="button" class="btn btn-secondary" onclick="clearForm()">
                    <i class="fas fa-undo"></i>
                    Clear Form
                </button>
                
                <button type="submit" class="btn btn-success" id="saveindent" onclick='return savechk()'>
                    <i class="fas fa-save"></i>
                    Save Purchase Order
                </button>
            </div>
        </form>
    </div>

    <!-- Include Modern JavaScript -->
    <script type="text/javascript" src="js/direct_purchase-modern.js"></script>
    <script type="text/javascript" src="js/directpurchase_insert.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    <script type="text/javascript" src="js/autocomplete_purchaseorder.js"></script>
    <script type="text/javascript" src="js/autosuggestpurchaseorder.js"></script>
    <script type="text/javascript" src="js/povalidity.js"></script>
    <script type="text/javascript" src="ckeditor1/ckeditor.js"></script>
    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="js/autocomplete_medicine1.js"></script>
    <script type="text/javascript" src="js/automedicinecodesearch5kiambu1.js"></script>
    <script type="text/javascript" src="js/jquery.min-autocomplete.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>

    <script>
        // Clear form function
        function clearForm() {
            if (confirm('Are you sure you want to clear the form? All entered data will be lost.')) {
                document.getElementById('frmsales').reset();
                document.getElementById('insertrow').innerHTML = '';
                document.getElementById('total').value = '';
                document.getElementById('total-display').textContent = '$0.00';
            }
        }
    </script>
</body>
</html>