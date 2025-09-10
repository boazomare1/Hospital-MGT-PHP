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
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$docno1 = $_SESSION['docno'];
$titlestr = 'SALES BILL';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
$docno = $_REQUEST['docno'];
$priority = $_REQUEST['priority'];
$original_priority = $_REQUEST['priority_old'];
$docno = $_REQUEST['docno'];
$remarks = addslashes($_REQUEST['remarks']);
$famailfrom = $_REQUEST['famailfrom'];
$famailcc = $_REQUEST['famailcc'];
$baemailcc = $_REQUEST['baemailcc'];
$baemailfrom = $_REQUEST['baemailfrom'];
$bamailfrom = $_REQUEST['bamailfrom'];
$source = $_REQUEST['source'];
$suppliernamearr = $_POST['suppliername'];
$supplierautonum_arr = $_POST['supplierautonum'];
$checked_discounts = $_POST['chkdiscount'];
$editor1 = $_POST['editor1'];
/*
foreach ($_POST['chkdiscount'] as $key => $value) {
	# code...
	echo $value.'<br>';
}*/
$lpodate = $_POST['lpodate'];
//$lpodate= date('Y-m-d',strtotime($dateonly));
if($_POST['discard'] != $docno)
{
	
  foreach($_POST['medicinename'] as $key => $value)
		{
		$medicinename=$_POST['medicinename'][$key]; 
	    $itemcode=$_POST['itemcode'][$key];
	//echo "<br>".$itemcode;
		$reqqty=str_replace(',','',$_POST['reqqty'][$key]);
		
		
		$pkgqty=$_POST['pkgqty'][$key];
		$amount=str_replace(',','',$_POST['amount'][$key]);
		$rate=str_replace(',','',$_POST['rate'][$key]);
		$purchasetype=strtolower($_POST['purchasetype'][$key]);
		$baserate = $_POST['baserate'][$key];
		$discount = $_POST['discount'][$key];
		$freeqty  = $_POST['freeqty'][$key];
		$originalamt = str_replace(',','',$_POST['orgamount'][$key]);
		$tax_per = $_POST['taxper'][$key];
		$tax_amt = str_replace(',','',$_POST['taxamt'][$key]);
		if($checked_discounts[$itemcode])
		{
			$discount_by_percent = 1;
		}
	    else
	    {
	    	 $discount_by_percent = 0; // by default	
	    }
	   
		$suppliercode =  $_POST['supplieritem'][$key];
		
		$suppliername =  $suppliernamearr[$suppliercode];
		$supplier_auto_number = $supplierautonum_arr[$suppliercode];
		$medanum=trim($_POST['medanum'][$key]);
		
		//echo $suppliername.'--'.$suppliercode.'-'.$supplier_auto_number;
		foreach($_POST['app'] as $check)
		{
			$acknow = $check; 
			//echo "<br>".$acknow;
			if($itemcode == $acknow)
			{
				$status = '1';
				//$query45="update purchase_indent set approvalstatus='$status',quantity='$reqqty',packagequantity='$pkgqty',amount='$amount' where docno='$docno' and medicinecode='$itemcode'";
				if(strtolower(trim($purchasetype))!=strtolower('Expenses') && strtolower(trim($purchasetype))!=strtolower('Others') && strtoupper(trim($purchasetype))!='ASSETS')
				{
					
$query45="UPDATE purchase_indent set approvalstatus='$status',quantity='$reqqty',packagequantity='$pkgqty',rate='$rate',amount='$amount', remarks='$remarks',baremarks='$remarks',famailfrom='$famailfrom',famailcc='$famailcc',bausername='$username',priority='$priority',original_priority='$original_priority',suppliername='$suppliername',suppliercode='$suppliercode',supplieranum='$supplier_auto_number',originalamt='$originalamt',baserate='$baserate',discount='$discount',freeqty='$freeqty',discount_by_percent='$discount_by_percent',povalidity='$lpodate',s_terms='$editor1',tax_percentage='$tax_per',tax_amount='$tax_amt' where docno='$docno' and medicinecode='$itemcode' and auto_number='$medanum'";
$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
										 
if($source=='departmentapproval')
{				
$query46="UPDATE purchase_indent set approvalstatus='$status',initial_approval='$status' where docno='$docno' and auto_number='$medanum'"; 
$exec46 = mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	
}
}
else
{
$query45="UPDATE purchase_indent set approvalstatus='$status',quantity='$reqqty',packagequantity='$pkgqty',rate='$rate',amount='$amount', remarks='$remarks',baremarks='$remarks',famailfrom='$famailfrom',famailcc='$famailcc',bausername='$username',priority='$priority',original_priority='$original_priority',suppliername='$suppliername',suppliercode='$suppliercode',supplieranum='$supplier_auto_number',originalamt='$originalamt',baserate='$baserate',discount='$discount',freeqty='$freeqty',discount_by_percent='$discount_by_percent',povalidity='$lpodate',s_terms='$editor1',tax_percentage='$tax_per',tax_amount='$tax_amt' where docno='$docno' and auto_number='$itemcode'"; 
$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
if($source=='departmentapproval')
{				
$query46="UPDATE purchase_indent set approvalstatus='',initial_approval='$status' where docno='$docno' and auto_number='$itemcode'"; 	
$exec46 = mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
}
				}
				//echo "<br>".$query45;
				//echo $purchasetype;
			
				$actionstatus='approve'; 
				
			}
		
		}
		
		
		
		}
		
		}
		else
		{
			
			$suppliernamearr = $_POST['suppliername'];
			$supplierautonum_arr = $_POST['supplierautonum'];
  foreach($_POST['medicinename'] as $key => $value)
		{
		$medicinename=$_POST['medicinename'][$key]; 
	    $itemcode=$_POST['itemcode'][$key];
	//echo "<br>".$itemcode;
		$reqqty=str_replace(',','',$_POST['reqqty'][$key]);
		$pkgqty=$_POST['pkgqty'][$key];
		$amount=str_replace(',','',$_POST['amount'][$key]);
		$rate=str_replace(',','',$_POST['rate'][$key]);
		$purchasetype=strtolower($_POST['purchasetype'][$key]);
		$baserate = $_POST['baserate'][$key];
		$discount = $_POST['discount'][$key];
		$freeqty  = $_POST['freeqty'][$key];
		$originalamt = $_POST['orgamount'][$key];
		$tax_per = $_POST['taxper'][$key];
		$tax_amt = strtolower($_POST['taxamt'][$key]);
		if($checked_discounts[$itemcode])
		{
			$discount_by_percent = 1;
		}
	    else
	    {
	    	 $discount_by_percent = 0; // by default	
	    }
		$suppliercode =  $_POST['supplieritem'][$key];
		$suppliername =  $suppliernamearr[$suppliercode];
		$supplier_auto_number = $supplierautonum_arr[$suppliercode];
		$medanum=trim($_POST['medanum'][$key]);
		if(strtolower(trim($purchasetype))!=strtolower('Expenses') && strtolower(trim($purchasetype))!=strtolower('Others') &&strtoupper(trim($purchasetype))!='ASSETS')
		{
		
$query45="UPDATE purchase_indent set approvalstatus='reject',quantity='$reqqty',packagequantity='$pkgqty',rate='$rate',amount='$amount', remarks='$remarks',famailfrom='$famailfrom',famailcc='$famailcc',bausername='$username',priority='$priority',original_priority='$original_priority',suppliername='$suppliername',suppliercode='$suppliercode',supplieranum='$supplier_auto_number',originalamt='$originalamt',baserate='$baserate',discount='$discount',freeqty='$freeqty',discount_by_percent='$discount_by_percent',povalidity='$lpodate',s_terms='$editor1',tax_percentage='$tax_per',tax_amount='$tax_amt' where docno='$docno' and medicinecode='$itemcode' and auto_number='$medanum'";
$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
 if($source=='departmentapproval')
{				
$query46="UPDATE purchase_indent set approvalstatus='',initial_approval='reject' where docno='$docno' and auto_number='$medanum'"; 
$exec46 = mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	
}
		}
		else
		{
			
$query45="UPDATE purchase_indent set approvalstatus='reject',quantity='$reqqty',packagequantity='$pkgqty',rate='$rate',amount='$amount', remarks='$remarks',famailfrom='$famailfrom',famailcc='$famailcc',bausername='$username',priority='$priority',original_priority='$original_priority',suppliername='$suppliername',suppliercode='$suppliercode',supplieranum='$supplier_auto_number',originalamt='$originalamt',baserate='$baserate',discount='$discount',freeqty='$freeqty',discount_by_percent='$discount_by_percent',povalidity='$lpodate',s_terms='$editor1',tax_percentage='$tax_per',tax_amount='$tax_amt' where docno='$docno' and auto_number='$itemcode'"; 
$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
if($source=='departmentapproval')
{				
$query46="UPDATE purchase_indent set approvalstatus='',initial_approval='reject' where docno='$docno' and auto_number='$itemcode'"; 
$exec46 = mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	
}
		}
		//echo "<br>".$query45;
			
	
		
		
		$actionstatus='reject'; 
		}
		
		}
		//exit;
		$action='budgetapproval';
		include('indentmail.php');
if($source=='departmentapproval')
{
	header("location:menupage1.php?mainmenuid=MM009");
}
else
{
		header("location:viewpurchaseindent.php");
}
		
}
//to redirect if there is no entry in masters category or item or customer or settings
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
if (isset($_REQUEST["source"])) { $source = $_REQUEST["source"]; } else { $source = ""; }
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
$paynowbillprefix = 'PI-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from purchase_indent order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='PI-'.'1';
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
	
	
	$billnumbercode = 'PI-' .$maxanum;
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
<?php 
if(isset($_REQUEST['docno']))
{
$docno = $_REQUEST['docno'];
}
?>
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
<?php
if ($delbillst != 'billedit') // Not in edit mode or other mode.
{
?>
	//Function call from billnumber onBlur and Save button click.
	function billvalidation()
	{
		billnovalidation1();
	}
<?php
}
?>
function funcPopupPrintFunctionCall()
{
	///*
	//alert ("Auto Print Function Runs Here.");
	<?php
	if (isset($_REQUEST["src"])) { $src = $_REQUEST["src"]; } else { $src = ""; }
	//$src = $_REQUEST["src"];
	if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
	//$st = $_REQUEST["st"];
	if (isset($_REQUEST["billnumber"])) { $previousbillnumber = $_REQUEST["billnumber"]; } else { $previousbillnumber = ""; }
	//$previousbillnumber = $_REQUEST["billnumber"];
	if (isset($_REQUEST["billautonumber"])) { $previousbillautonumber = $_REQUEST["billautonumber"]; } else { $previousbillautonumber = ""; }
	//$previousbillautonumber = $_REQUEST["billautonumber"];
	if (isset($_REQUEST["companyanum"])) { $previouscompanyanum = $_REQUEST["companyanum"]; } else { $previouscompanyanum = ""; }
	//$previouscompanyanum = $_REQUEST["companyanum"];
	if ($src == 'frm1submit1' && $st == 'success')
	{
	$query1print = "select * from master_printer where defaultstatus = 'default' and status <> 'deleted'";
	$exec1print = mysqli_query($GLOBALS["___mysqli_ston"], $query1print) or die ("Error in Query1print.".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1print = mysqli_fetch_array($exec1print);
	$papersize = $res1print["papersize"];
	$paperanum = $res1print["auto_number"];
	$printdefaultstatus = $res1print["defaultstatus"];
	if ($paperanum == '1') //For 40 Column paper
	{
	?>
		//quickprintbill1();
		quickprintbill1sales();
	<?php
	}
	else if ($paperanum == '2') //For A4 Size paper
	{
	?>
		loadprintpage1('A4');
	<?php
	}
	else if ($paperanum == '3') //For A4 Size paper
	{
	?>
		loadprintpage1('A5');
	<?php
	}
	}
	?>
	//*/
}
//Print() is at bottom of this page.
</script>
<?php include ("js/sales1scripting1.php"); ?>
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
function cashentryonfocus1()
{
	if (document.getElementById("cashgivenbycustomer").value == "0.00")
	{
		document.getElementById("cashgivenbycustomer").value = "";
		document.getElementById("cashgivenbycustomer").focus();
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
	funcCustomerDropDownSearch4();
	funcPopupPrintFunctionCall();
	
}
</script>
<script>
function funqty(id)
{
//alert(id);
if(document.getElementById(id) == document.activeElement)
{
document.getElementById(id).value=document.getElementById(id).value.replace(/[^0-9\.]+/g,"");
}
else
{
document.getElementById(id).value=document.getElementById(id).value.replace(/[^0-9\.]+/g,"").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
}
}
function rate_update(sno)
{
	var get_rate=document.getElementById("rate"+sno).value;
	var supplier_get=document.getElementById("supplieritem"+sno).value;
	var medicine_code=document.getElementById("medicine_code"+sno).value;
	var dataString = 'get_rate='+get_rate+'&&supplier_get='+supplier_get+'&&medicine_code='+medicine_code;
	$.ajax({
	type: "get",
	url: "update_rate_supplier.php",
	data: dataString,
	success: function(html){
	$('#rateupdate'+sno).css('background-color','#00FF00');
	}
	});	
}
function calc(serialnumber,totalcount)
{
var grandtotalamount = 0;
var serialnumber = serialnumber;
var totalcount = totalcount;
var reqqty=document.getElementById("reqqty"+serialnumber+"").value;
var packsize=document.getElementById("packsize"+serialnumber+"").value;
var purchasetype=document.getElementById("purchasetype").value;
var fxamount=document.getElementById("fxamount").value;
var packvalue=packsize.substring(0,packsize.length - 1);
if(purchasetype!='non-medical')
{
	rate = parseFloat(rate)/parseFloat(fxamount);
}
var rate=document.getElementById("rate"+serialnumber+"").value.replace(/[^0-9\.]+/g,"");
var amount=parseFloat(reqqty) * parseFloat(rate);
document.getElementById("orgamount"+serialnumber+"").value=formatMoney(amount.toFixed(2));
var taxamount = 0;
var taxper = document.getElementById("taxper"+serialnumber+"").value.replace(/[^0-9\.]+/g,"");
if(taxper > 0)
{
	var taxamount = parseFloat(amount) * (parseFloat(taxper) / 100);
	document.getElementById("taxamt"+serialnumber+"").value= taxamount.toFixed(2);
}
else
{
	if(taxper == 0)
	document.getElementById("taxamt"+serialnumber+"").value= taxamount.toFixed(2);	
}
amount = parseFloat(amount) + parseFloat(taxamount);
//alert(amount);
document.getElementById("amount"+serialnumber+"").value=formatMoney(amount.toFixed(2));
var pkgqty=reqqty/packvalue;
packvalue=parseInt(packvalue);
if(reqqty < packvalue)
{
pkgqty=1;
}
if(purchasetype!='non-medical')
{
	document.getElementById("pkgqty"+serialnumber+"").value=Math.round(pkgqty);
}
for(i=1;i<=totalcount;i++)
{
var totalamount=document.getElementById("amount"+i+"").value.replace(/[^0-9\.]+/g,"");
if(totalamount == "")
{
totalamount=0;
}
grandtotalamount=grandtotalamount+parseFloat(totalamount);
}
document.getElementById("totalamount").value=formatMoney(grandtotalamount.toFixed(2));
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
<script language="JavaScript">
	function discardchk() {
		if(document.getElementById("discard").checked == true)
		{
			document.getElementById("selectall").checked = false;
		}
	}
	function selectAll(source) {
		
		if(document.getElementById("selectall").checked == true)
		{
			document.getElementById("discard").checked = false;
		}
		
		checkboxes = document.getElementsByName('app[]');
		for(var i in checkboxes)
			checkboxes[i].checked = source.checked;
	}
	function process()
	{
		
			if(document.getElementById("remarks").value=='')
			{
				alert('Enter Remarks');
				document.getElementById("remarks").focus();
				return false;
			}
		
		if(document.getElementById("discard").checked==false && document.getElementById("selectall").checked==false)
		{
			alert('Select Approve or Reject Checkbox');
			return false;
		}
		if(document.getElementById("discard").checked==true && document.getElementById("selectall").checked==true)
		{
			alert('Select Any One Approve or Reject Checkbox');
			return false;
		}
		if(document.querySelectorAll('input[name=priority]:checked').length == 0)
	{
		alert('Please Select Priority');
		document.getElementById("priority1").focus();
		return false;
	}
	var count = 0;
	var selectclass = 'supplier_item_map';
	$('select.' + selectclass).each( function() {
         var val = $(this).val();
         //console.log('valuue'+val)
         if(!val)
         	count = 1;
    });
    if(count)
	{
		alert('Please map supplier with item and try again');
		return false;
	}
	var items_rowscount = $('#total_line_items').val();
	if(items_rowscount == 0){
		alert('No items found to save');
		return false;
	}
	
	 document.getElementById("saveindent").disabled=true;
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
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
.bal
{
border-style:none;
background:none;
text-align:right;
FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma;
}
#remarks{
	border-color:red;
	}
input[name="priority"] {
  -webkit-appearance: checkbox; /* Chrome, Safari, Opera */
  -moz-appearance: checkbox;    /* Firefox */
  -ms-appearance: checkbox;     /* not currently supported */
}
/* .ui-widget-header,.ui-state-default, ui-button{  
            background:#b9cd6d;  
            border: 1px solid #b9cd6d;  
            color: #FFFFFF;  
            font-weight: bold;  
         }  */
 .savebutton{
 	font-size: 15px;
 	width: 100px;
    height: 35px;
    margin-top:75px;
}
.bld{
	font-weight: bold;
}
</style>
<script type="text/javascript" src="ckeditor1/ckeditor.js"></script>
<script src="js/datetimepicker_css.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<link href="js/jquery-ui.css" rel="stylesheet">
<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript" src="js/jquery-1.11.1.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css">
 <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
 <link href="js/jquery-ui.css" rel="stylesheet">
 <!--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
 <script src="jquery/jquery-ui.js"></script>
 <script src="js/purchase_history.js"></script>
 <link rel="stylesheet" type="text/css" href="css/custom.css" />
 <script type="text/javascript" src="js/povalidity.js"></script>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
              
<body onLoad="return funcOnLoadBodyFunctionCall();">
	<script>
var del_snos = [];
	$(document).ready(function(){
		/* $( "#items_dialog" ).dialog({  
                autoOpen: false, 
                maxWidth:600,
		        maxHeight: 500,
		        width: 600,
		        height: 300,
		        modal: true   
         });*/
	$( ".deleteitem" ).click(function(event) {
	  if (confirm('Are you sure you want to delete this?')) {
		var sno = $(this).attr('sno');
		var id = $(this).attr('id');
		$.ajax({
		  url: 'ajax/ajaxpurchaseindent.php',
		  type: 'POST',
		  //async: false,
		  dataType: 'json',
		  //processData: false,    
		  data: { 
		      auto_number: id
		  },
		  success: function (data) { 
		  	//alert(data)
		  	
		  	var msg = data.msg;
		  	if(data.status == 1)
		  	{
		  		alert(msg);
		  		//$('#tr_'+id).hide();
		  		$('#tr_'+id).remove();
		  		
		  		del_snos.push(sno);
		  		var items_rowscount = $('#total_line_items').val();
		  		var new_rowscount = parseInt(items_rowscount) - 1;
		  		$('#total_line_items').val(new_rowscount);
		  		var items_rowscount = $('#total_line_items').val();
		  		if(items_rowscount == 0)
		  			$('#totalamount').val('0.00');
		  	}
		  	else
		  	{
		  		alert(msg);
		  	}
		  	
		  }
		});
	  }
		return false;
	})	
	/*$( ".viewhistory" ).click(function() {
		var itemcode = $(this).attr('id');
		//alert(id)
		$.ajax({
		  url: 'ajax/getitempurchasehistory.php',
		  type: 'POST',
		  //async: false,
		  dataType: 'json',
		  //processData: false,    
		  data: { 
		      itemcode: itemcode
		  },
		  success: function (data) { 
		  
		  	var itemname = "";
		  		for (var i = 0; i < data.length; i++) {
		  		itemname = data[i]['itemname'];
		  		
		  	}
		  	var html ="";
		  	html += '<div class="bodytext31 itemtitle"><b>'+itemname+'</b></div>';
		  	html += '<table width="100%" border="1" cellspacing="0.5" cellpadding="2">';
		  	html += '<tbody ><tr><td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Purchase Date</strong></td><td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Cost Price </strong></td><td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Quantity<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Supplier</strong></td></tr>';
		  	for (var i = 0; i < data.length; i++) {
		  		console.log(data[i]['suppliername']);
		  		var entrydate = data[i]['entrydate'];
		  		var rate = data[i]['rate'];
		  		var quantity = data[i]['quantity'];
		  		var suppliername = data[i]['suppliername'];
		  		
		  		html += '<tr><td class="bodytext31" align="center">'+entrydate+'</td><td align="right" class="bodytext31">'+rate+'</td><td align="right" class="bodytext31">'+quantity+'</td><td align="center" class="bodytext31">'+suppliername+'</td></tr>';
		  	}
		  	html += '</tbody></table>';
		  	
		  	$('#items_dialog').html(html);
		  	$( "#items_dialog" ).dialog( "open" );
		  	
		  }
		});
	});*/
	$( ".discount" ).keyup(function() {
		var id = $(this).attr('id');
		var sno = $(this).attr('sno');
		var baserate = parseFloat($('#baserate'+sno).val());
		// if checkbox is checked cal as percentage else by value
		 if($('#chkdiscount'+sno).is(":checked")) {
           
            // Discount Checkbox Checked
            var discount_per = $.trim($(this).val());
			if(discount_per !="" && discount_per !==undefined)
			{
				if(parseFloat(discount_per) > 100)
				{
					alert('Discount cannot exceed 100 %');
					$(this).val('');
					whenDiscountEmpty(sno);
					return false;
				}
				var discount = ((parseFloat(baserate)/100) * parseFloat(discount_per));
				
				discount = discount.toFixed(2);
				var rate = parseFloat(baserate) - parseFloat(discount);
				var reqqty = $.trim($('#reqqty'+sno).val());
				
				$('#rate'+sno).val(rate.toFixed(2));
				$('#rate'+sno).keyup();
				
			}
			else
			{
				if(discount_per =="")
				{
					whenDiscountEmpty(sno);
				}
			}
        }
        else
        {
        	// Discount Checkbox Unchecked
        	var discount = $.trim($(this).val());
			if(discount !="" && discount !==undefined)
			{
				if(parseFloat(discount) > parseFloat(baserate))
				{
					alert('Discount Amount cannot exceed Base Rate Amount');
					$(this).val('');
					whenDiscountEmpty(sno);
					return false;
				}
				
				var rate = parseFloat(baserate) - parseFloat(discount);
				var reqqty = $.trim($('#reqqty'+sno).val());
				
				$('#rate'+sno).val(rate.toFixed(2));
				$('#rate'+sno).keyup();
				
			}
			else
			{
				if(discount =="")
				{
					whenDiscountEmpty(sno);
				}
			}
        }
	});
	$( ".baserate" ).keyup(function() {
		var id = $(this).attr('id');
		var sno = $(this).attr('sno');
		var baserate = parseFloat($('#baserate'+sno).val());
		$('#rate'+sno).keyup();
		$('#discount'+sno).keyup()
	});
	$('.discount').keypress(function (event) {
           return isNumber(event, this)
    });
    $('.freeqty').keypress(function (event) {
           return isOnlyNumber(event, this)
    });
    
    $('.baserate').keypress(function (event) {
           return isNumber(event, this)
    });
    $( ".supplier_item_map" ).change(function() {
  		
  		var supplier_code = $(this).val();
  		var sno = $(this).attr('serno');
  		
  		var baserate = $('#baserate_'+sno+'_'+supplier_code).val();
  		
  		$('#discount'+sno).val('');
  		$('#baserate'+sno).val(baserate);
  		$('#rate'+sno).val(baserate);
  		$('#orgamount'+sno).val(baserate);
  		
  		$('#rate'+sno).keyup();
	});
	$('.chkboxdiscount').change(function() {
		var id = $(this).attr('id');
		var sno = $(this).attr('sno');
		$('#discount'+sno).keyup();
    });
	
/*var future = new Date();
var povalidityts = future.setDate(future.getDate() + 30);
var newdate = new Date(povalidityts);
console.log('newdt'+newdate)
var povalidity_date = getDateFormat(newdate)
//console.log(povalidity_date)
$('#lpodate').val(povalidity_date);*/
getValidityDays();
});
	function isNumber(evt, element) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (
            //(charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57))
            return false;
        return true;
    } 
    function isOnlyNumber(evt, element) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if ((charCode < 48 || charCode > 57))
            return false;
        return true;
    } 
    function whenDiscountEmpty(sno)
    {
    	var baserate = parseFloat($('#baserate'+sno).val());
    	$('#rate'+sno).val(baserate.toFixed(2));
		$('#rate'+sno).keyup();
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
function Map_supplier(id)
{
	varCallFrom='7';
window.open("popup_itemmapmultiple.php?callfrom="+varCallFrom+'&item='+id,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');	
}
/*function getDateFormat(date) {
var d = new Date(date),
month = '' + (d.getMonth() + 1),
day = '' + d.getDate(),
year = d.getFullYear();
if (month.length < 2)
    month = '0' + month;
if (day.length < 2)
    day = '0' + day;
var date = new Date();
date.toLocaleDateString();
return [year, month, day].join('-');
}*/
   
</script>
<form name="form1" id="frmsales" method="post" action="purchaseindentapproval.php" onKeyDown="return disableEnterKey(event)" onSubmit="return process()">
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
              
			 <?php 
			if(isset($_REQUEST['docno']))
			{
				$docno = $_REQUEST['docno'];
				$query12 = "select suppliername,purchasetype,currency,fxamount,pimailfrom,bamailfrom,bamailcc,locationcode,storecode,priority,locationname from purchase_indent where docno='$docno' and (approvalstatus='' or approvalstatus='rejected1')";
				$exec12= mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$numb=mysqli_num_rows($exec12);				
				while($res12 = mysqli_fetch_array($exec12))
				{
					$suppliername = $res12['suppliername'];
					$purchasetype = $res12['purchasetype'];				
					$currency = $res12['currency'];
					$fxamount = $res12['fxamount'];
					$pimailfrom = $res12['pimailfrom'];
					$bamailfrom = $res12['bamailfrom'];
					$bamailcc = $res12['bamailcc'];
					$locationcode = $res12['locationcode'];
					$storecode = $res12['storecode'];
					$priority = $res12['priority'];
					$location_name = $res12['locationname'];
				}
			}
$query121 = "select storename from purchase_indent where docno='$docno' and (approvalstatus='' or approvalstatus='rejected1')";
$exec121= mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die ("Error in Query121".mysqli_error($GLOBALS["___mysqli_ston"]));
$res121 = mysqli_fetch_array($exec121);
$store = $res121['storename'];
			?>
		
			  <tr>
			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Doc No</strong></td>
                <td width="27%" align="left" valign="top" >
				<input name="docno" id="docno" value="<?php echo $docno; ?>"  size="10" autocomplete="off" readonly/>                  </td>
                 <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Date</strong></td>
                <td  align="left" valign="top" >
				<input type="hidden" id="date" value="<?php echo $dateonly; ?>"  size="10" rsize="20" readonly/>		
                <input name="date" id="date_disp" value="<?php echo date('d/m/Y',strtotime($dateonly)); ?>"  size="10" rsize="20" readonly/>				</td>
                
             <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Store</strong></td>
                <td width="17%" align="left" valign="top" >
				<input name="store" id="store" value="<?php echo $store;?>" size="18" rsize="20" readonly/>				</td>
                
                 <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Location</strong></td>
                <td width="17%" align="left" valign="top" >
				<input name="location" id="location" value="<?php echo $locationname;?>" size="18" rsize="20" readonly/>				</td>
			    </tr>
                <tr>
			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Purchase Type</strong></td>
                <td width="27%" align="left" valign="middle" >
				<input name="purchasetype" id="purchasetype" value="<?php echo $purchasetype; ?>" size="10" autocomplete="off" readonly/>                  </td>
                 <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Currency</strong></td>
                <td align="left" valign="middle" >
				<input name="currency" id="currency" value="<?php echo $currency; ?>" size="10" rsize="20" readonly/>				</td>
                
             <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Exchange Rate</strong></td>
                <td width="17%" align="left" valign="middle" >
				<input name="fxamount" id="fxamount" value="<?php echo $fxamount;?>"size="18" rsize="20" readonly/>				</td>
                
                <!--  <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Supplier</strong></td>
                <td width="17%" align="left" valign="middle"  class="bodytext3"><?php echo $suppliername;?>
				</td> -->
			    </tr>
                <?php 
				$query1mail = "select emailto,emailcc from master_email where recordstatus <> 'deleted' and module='Budget Approval' order by auto_number desc";
				$exec1mail = mysqli_query($GLOBALS["___mysqli_ston"], $query1mail) or die ("Error in Query1mail".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res1mail = mysqli_fetch_array($exec1mail))
				{
					$emailto = $res1mail["emailto"];
					$emailcc = $res1mail["emailcc"];
				}
				?>
                <tr>
			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>From</strong></td>
                <td colspan="7" align="left" valign="top" ><?php echo $pimailfrom;?>
                <input type="hidden" name="baemailfrom" id="baemailfrom" value="<?php echo $bamailfrom;?>">
                <input type="hidden" name="bamailfrom" id="bamailfrom" value="<?php echo $pimailfrom;?>">
                <input type="hidden" name="baemailcc" id="baemailcc" value="<?php echo $bamailcc;?>">
            	</td>
				</tr>
				<tr>
                 <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>To</strong></td>
                <td colspan="7" align="left" valign="top" ><?php echo $emailto;?><input type="hidden" name="famailfrom" id="famailfrom" value="<?php echo $emailto;?>"></td>
				</tr>
				<tr>
                <td width="9%" align="left" valign="middle" class="bodytext3" ><strong>CC</strong></td>
                <td colspan="7" align="left" valign="top" ><?php echo $emailcc;?><input type="hidden" name="famailcc" id="famailcc" value="<?php echo $emailcc;?>"></td>
			    </tr>
            </tbody>
        </table></td>
      </tr>
      <tr>
	  <td>&nbsp;
	  </td>
	  </tr>
      <h2>Please Map  All the Suppliers and Reload the Page</h2>
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="2" width="1450" 
            align="left" border="0">
			<tbody id="foo">
			<tr>
				<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Medicine Code</strong></td>
				<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Medicine Name</strong></td>
				<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Supplier Code</strong></td>
				<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Supplier Mapped </strong></td>
				
				<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Original Qty</strong></td>
				<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Req Qty</strong></td>
				<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Free Qty</strong></td>
				<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Pack Size</strong></td>
				<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Pkg Qty</strong></td>
				<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Base Rate</strong></td>
				<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>&nbsp;</strong></td>
				<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Discount</strong></td>
				<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Rate</strong></td>
                <?php if($purchasetype != "ASSETS")
               { ?>
                <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Act</strong></td>
                <?php } ?>
				<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Tax%</strong></td>
				<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Tax.Amt</strong></td>
				<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Goods Amt</strong></td>
				<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Total Amt</strong></td>
                <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Prev Purchase Price</strong></td>
				
			</tr>
				  		<?php
			$colorloopcount = '';
			$sno = 0;
			$totalamount=0;	
			$taxamount = 0;		
			$query12 = "select * from purchase_indent where docno='$docno' and (approvalstatus='' or approvalstatus='rejected1') and is_deleted=0";
			$exec12= mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numb=mysqli_num_rows($exec12);
			
			while($res12 = mysqli_fetch_array($exec12))
         {
		$medanum = $res12['auto_number'];
		$medicinename = $res12['medicinename'];
		$itemcode = $res12['medicinecode'];
		$purchasetype = $res12['purchasetype'];
		$reqqty = $res12['quantity'];
		$originalqty= $res12['originalqty'];
		$originalamt=$res12['originalamt'];
		$row_id = $res12['auto_number'];
		$actual_rate = $res12['baserate'];
		$suppliername = $res12['suppliername'];
		$suppliercode = $res12['suppliercode'];
		$supplieranum = $res12['supplieranum'];
		if(strtolower(trim($purchasetype))==strtolower('Expenses') || strtolower(trim($purchasetype))==strtolower('Others') || trim($purchasetype) == 'ASSETS')
		{
			$itemcode = $res12['auto_number'];
		}
		$query231 = "select * from master_employeelocation where username='$username' and defaultstore='default'";
		$exec231 = mysqli_query($GLOBALS["___mysqli_ston"], $query231) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res231 = mysqli_fetch_array($exec231);
		 $res7locationanum1 = $res231['locationcode'];
		
		/*$query551 = "select * from master_location where auto_number='$res7locationanum1'";
		$exec551 = mysql_query($query551) or die(mysql_error());
		$res551 = mysql_fetch_array($exec551);
		$location = $res231['locationname'];*/
		
		 $res7storeanum1 = $res231['storecode'];
		
		$query751 = "select * from master_store where auto_number='$res7storeanum1'";
		$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res751 = mysqli_fetch_array($exec751);
		$store = $res751['store'];
		$storecode = $res751['storecode'];
		
	
		
			$query2 = "select * from master_medicine where itemcode = '$itemcode'";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2 = mysqli_fetch_array($exec2);
			$package = $res2['packagename'];
			$meds_code = $res2['meds_code'];
			$taxpercent = 0;
			$taxamount = 0;	
			$taxid = $res2['taxanum'];
			// Get tax percentage
			$query11 = "select taxpercent from master_tax where auto_number='$taxid'";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11 = mysqli_fetch_array($exec11);
			$taxpercent = $res11["taxpercent"];
			$packagequantity = $res12['packagequantity'];
			$rate = $res12['rate'];
			//$amount = $res12['amount']; 
			$itemcode = $itemcode;
		//include ('autocompletestockcount1include1.php');
		//$querystock1 = "select sum(batch_quantity) as currentstock from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$locationcode' and storecode ='$storecode'";
//		$execstock1 = mysql_query($querystock1) or die ("Error in Querystock1".mysql_error());
//		$resstock1 = mysql_fetch_array($execstock1);
//		$currentstock = $resstock1['currentstock'];
//		$currentstock = $currentstock;
		
		//$totalamount= $totalamount + $amount;
		$sno = $sno + 1;
		$query7512 = "select * from master_itemtosupplier where itemcode='$itemcode' and storecode='$storecode'";
		//echo $query7512;
		$exec7512 = mysqli_query($GLOBALS["___mysqli_ston"], $query7512) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res7512 = mysqli_fetch_array($exec7512);
		$mappedsuppliername = $res7512['suppliername'];
		 $item_suppliers_qry = "SELECT `master_accountname`.`auto_number`,`suppliercode`,`master_accountname`.`accountname`,`master_itemmapsupplier`.`fav_supplier`,`master_itemmapsupplier`.`rate` FROM `master_accountname` inner join master_itemmapsupplier on `master_itemmapsupplier`.`suppliercode` = `master_accountname`.`id` WHERE `master_itemmapsupplier`.`itemcode`='$itemcode' group by `master_itemmapsupplier`.`suppliercode` ";
		$item_supp_res = mysqli_query($GLOBALS["___mysqli_ston"], $item_suppliers_qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		//$supp_res_1 = mysql_fetch_array($item_supp_res);
        $cost_price='';
		
         $query75128 = "select costprice from purchase_details where itemcode='$itemcode' order by auto_number desc";
		$exec75128 = mysqli_query($GLOBALS["___mysqli_ston"], $query75128) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res75128 = mysqli_fetch_array($exec75128);
		$cost_price1 = $res75128['costprice'];
		if($cost_price1<=0)
		{
		$query751281 = "select costprice from materialreceiptnote_details where itemcode='$itemcode' order by auto_number desc";
		$exec751281 = mysqli_query($GLOBALS["___mysqli_ston"], $query751281) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res751281 = mysqli_fetch_array($exec751281);
		$cost_price = $res751281['costprice'];
		}
		else
		{
			$cost_price=$cost_price1;
		}
		if($cost_price<=0)
		{
			$cost_price='No Prev Purchase';
		}
 $query70 = "select auto_number from master_itemmapsupplier where itemcode='$itemcode' order by auto_number desc";
$exec70 = mysqli_query($GLOBALS["___mysqli_ston"], $query70) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$num70=mysqli_num_rows($exec70);
?>
  <tr id="tr_<?php echo $row_id; ?>">
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $itemcode;?></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $medicinename;?></div>
		   <input type="hidden" name="medanum[]" value="<?php echo $medanum;?>">
			<input type="hidden" name="medicinename[]" value="<?php echo $medicinename;?>">
			<input type="hidden" name="itemcode[]" value="<?php echo $itemcode; ?>">
			<input type="hidden" name="purchasetype[]" value="<?php echo $purchasetype; ?>">
            <input type="hidden" name="medicine_code[]" id="medicine_code<?php echo $sno ; ?>" value="<?php echo $itemcode; ?>">
		</td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $meds_code;?></div></td>
		<!-- <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $mappedsuppliername;?></div></td>-->
		<td class="bodytext31" valign="center"  align="left">
<?php
if($num70<=0 && $purchasetype != "ASSETS")
{ ?>
<input class="bodytext31"  type="button" name="map_sup" id="map_sup<?php echo $row_id; ?>" onClick="Map_supplier('<?php echo $itemcode;?>')" value="Map Supplier"/>
<?php
}
else
{?>
<div align="center">
<select class="bodytext31 supplier_item_map" name="supplieritem[]" id="supplieritem<?php echo $sno ; ?>" serno="<?php echo $sno; ?>">
<?php 
$hidden_html = "";
$baserate = 0;
$incr = 0;
$amount = 0;
$originalamt = 0;
if($purchasetype == "ASSETS")
{ 
	$tax_class ="";
	$tax_editable = "";
	$baserate = $res12['rate'];
	$amount = $baserate * $reqqty;
		$originalamt = $baserate * $originalqty;
	?>
	<option value="<?php echo $suppliercode; ?>"><?php echo $suppliername; ?></option>
	<input type="hidden" name="suppliername[<?php echo $suppliercode?>]"  value="<?php echo $suppliername ?>" >
	<input type="hidden" name="supplierautonum[<?php echo $suppliercode?>]"  value="<?php echo $supplieranum ?>" >
<?php }
else
{
	$tax_class ="bal";
	$tax_editable = "readonly";
	while($supp_res = mysqli_fetch_array($item_supp_res))
	{
		//$supp_res1 = $supp_res;
		$incr = $incr + 1;
		if($incr == 1)
		{
			$baserate = $supp_res['rate'];
		}
		if($source=='departmentapproval'){
		if($supp_res['fav_supplier'])
		{
			$baserate = $supp_res['rate'];
			
			
		}
		}
		else
		{
		$baserate = $actual_rate;
		}
		$amount = $baserate * $reqqty;
		$originalamt = $baserate * $originalqty;
		if($taxpercent > 0)
		{
		$taxamount = $amount * ($taxpercent / 100);
		}
	
		$amount = $amount + $taxamount;
		
if($source=='departmentapproval'){
?><option value="<?php echo $supp_res['suppliercode']; ?>" <?php if($supp_res['fav_supplier']) echo 'selected'; ?>><?php echo $supp_res['accountname']; ?></option>
<?php 
$supp_code = $supp_res["suppliercode"];
		$supp_rate = $supp_res["rate"];
}
else
{
	?><option value="<?php echo $supp_res['suppliercode']; ?>" <?php if($suppliercode==$supp_res['suppliercode']) echo 'selected'; ?>><?php echo $supp_res['accountname']; ?></option>
<?php
$supp_code = $suppliercode;
		$supp_rate = $supp_res["rate"];
}
		
		 
	}
}
$totalamount= $totalamount + $amount;
?>
</select>
</div>
<?php } ?>  
		</td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $originalqty;?></div></td>
		<td class="bodytext31" valign="right"  align="right"><div align="right"><input type="text" name="reqqty[]" id="reqqty<?php echo $sno ; ?>" value="<?php echo $reqqty;?>" size="6" onKeyUp="return calc('<?php echo $sno; ?>','<?php echo $numb; ?>');" onFocus="funqty(this.id)" onBlur="funqty(this.id)" style="text-align:right"></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" class="freeqty" name="freeqty[]" id="freeqty<?php echo $sno ; ?>" value="" size="6" style="text-align:right"></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="packsize[]" id="packsize<?php echo $sno ; ?>" value="<?php echo $package;?>" size="6" class="bal" readonly></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="pkgqty[]" id="pkgqty<?php echo $sno ; ?>" size="6" value="<?php echo $packagequantity;?>" class="bal" readonly></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="baserate[]" id="baserate<?php echo $sno ; ?>" size="6" class="baserate" value="<?php echo $baserate; ?>" sno="<?php echo $sno; ?>" style="text-align:right"></div></td>
        
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" class="chkboxdiscount" name="chkdiscount[<?php echo $itemcode; ?>]" id="chkdiscount<?php echo $sno ; ?>" size="6" value="1" sno="<?php echo $sno ; ?>"></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" class="discount" name="discount[]" id="discount<?php echo $sno ; ?>" size="6" value="" sno="<?php echo $sno ; ?>"></div></td>
		<td class="bodytext31" valign="right"  align="right"><div align="right"><input type="text" name="rate[]" id="rate<?php echo $sno ; ?>" value="<?php echo number_format($baserate,'2','.',',');?>" onKeyUp="return calc('<?php echo $sno; ?>','<?php echo $numb; ?>');" size="6" align="right" readonly style="text-align:right"></div></td>
        <?php if($purchasetype != "ASSETS")
        { ?>
        <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="button" name="rateupdate[]" id="rateupdate<?php echo $sno ; ?>" size="6" class="baserate" value="Update" sno="<?php echo $sno; ?>" onClick="rate_update('<?php echo $sno; ?>')"></div></td>
        <?php } ?>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="taxper[]" id="taxper<?php echo $sno ; ?>" value="<?php echo number_format($taxpercent,'2','.',',');?>" onKeyUp="return calc('<?php echo $sno; ?>','<?php echo $numb; ?>');" size="6" class="<?= $tax_class; ?>" <?= $tax_editable;?>></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="taxamt[]" id="taxamt<?php echo $sno ; ?>" value="<?php echo number_format($taxamount,'2','.',',');?>" onKeyUp="return calc('<?php echo $sno; ?>','<?php echo $numb; ?>');" size="6" class="<?= $tax_class; ?>" readonly></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="orgamount[]" id="orgamount<?php echo $sno ; ?>" value="<?php echo number_format($originalamt,'2','.',',');?>" size="10" class="bal" readonly></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="amount[]" id="amount<?php echo $sno ; ?>" value="<?php echo number_format($amount,'2','.',',');?>" size="10" class="bal" readonly>
        <input type="checkbox" name="app[]" value="<?php echo $itemcode; ?>" style="display:none"/>
        </div></td>
        
        <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $cost_price;?></div></td>
        
        
        <td width="4%" align="left" valign="center"  class="bodytext3"><div align="center">
						<a href="#" class="deleteitem" id="<?php echo $row_id; ?>" sno="<?php echo $sno;?>">
						<img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
		<td width="4%" align="left" valign="center"  class="bodytext3"><div align="center">
						<a href="#" class="viewhistory" itemname="<?php echo $medicinename;?>" id="<?php echo $itemcode; ?>">View</a></div></td>
		
				</tr>
			<?php 
				
			$qry = "SELECT `master_accountname`.`auto_number`,`suppliercode`,`master_accountname`.`accountname`,`master_itemmapsupplier`.`fav_supplier`,`master_itemmapsupplier`.`rate` FROM `master_accountname` inner join master_itemmapsupplier on `master_itemmapsupplier`.`suppliercode` = `master_accountname`.`id` WHERE `master_itemmapsupplier`.`itemcode`='$itemcode' group by `master_itemmapsupplier`.`suppliercode` ";
		$res = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sup = mysqli_fetch_array($res))
					{?>
						<input type="hidden" name="sup_base_rate" id="baserate_<?php echo $sno?>_<?php echo $sup['suppliercode'] ?>" value="<?php echo $sup['rate'];?>" >
						<input type="hidden" name="suppliername[<?php echo $sup['suppliercode']?>]"  value="<?php echo $sup['accountname'] ?>" >
						<input type="hidden" name="supplierautonum[<?php echo $sup['suppliercode']?>]"  value="<?php echo $sup['auto_number'] ?>" >
					<?php }
					$total_line_items = $sno;
			}
		?>
		<input type="hidden" id="total_line_items" value="<?php echo $total_line_items; ?>">
		<tr>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="center" bgcolor="#ecf0f5"><input type="text" name="totalamount" id="totalamount" value="<?php echo number_format($totalamount,'2','.',','); ?>" size="10" class="bal bld" readonly></td>
				 
               </tr>
              <!--  <tr><td><?php echo $hidden_html; ?></td></tr> -->
               
          </tbody>
        </table>		</td>
      </tr>
			<?php 
			//$default_lpo_date = date('Y-m-d', strtotime('+1 month'));
			$default_lpo_date = date('Y-m-d', strtotime("+30 days"));
			?>	    
				  <tr>
	  <td>&nbsp;
	  </td>
	  </tr>
      <tr>
	  <td>
	  <table width="100%">
     <tr>
	 <td width="66" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">User Name</td>
	   <td width="111" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> <input type="text" name="username" value="<?php echo $username; ?>" size="10"></td>
	    <td width="47" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Discard</td>
	   <td width="60" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> <input type="checkbox" id="discard" name="discard"   onClick="discardchk()" value="<?php echo $docno; ?>"> </td>
	   
       <td width="84" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Remarks</td>
	    <td width="260" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" calign="left"><textarea name="remarks" id="remarks"></textarea></td>
	    <td width="47" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Approve All</td>
	   <td width="120" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> <input type="checkbox" id="selectall" onClick="selectAll(this)"></td>
	 
     </tr>
     
	 <tr>
	  <td width="47" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Priority</strong></td>
		<td colspan ='3' valign="middle"  bgcolor="#ecf0f5" class="bodytext3" calign="left">
		<input type="radio" <?php if($priority == 'Critical'){echo "checked";}?> name="priority" id="priority1" value="Critical"><label for="priority1">Critical</label>&nbsp;&nbsp;
		<input type="radio" <?php if($priority == 'High'){echo "checked";}?> name="priority" id="priority2" value="High"><label for="priority2">High</label>&nbsp;&nbsp;
		<input type="radio" <?php if($priority == 'Medium'){echo "checked";}?> name="priority" id="priority3" value="Medium"><label for="priority3">Medium</label>&nbsp;&nbsp;
		<input type="radio" <?php if($priority == 'Low'){echo "checked";}?> name="priority" id="priority4" value="Low"><label for="priority4">Low</label>&nbsp;&nbsp;
		<input type="hidden" name="priority_old" value="<?= $priority;?>">
		</td>
		<td width="47" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Valid Till</td>
	   <td width="60" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> 
    <input name="lpodate" id="lpodate" size="10"   value="<?php echo $default_lpo_date; ?>" readonly onChange="return getValidityDays();"/>
            <img src="images2/cal.gif" onClick="javascript:NewCssCal('lpodate','yyyyMMdd','','','','','future')" style="cursor:pointer"/> <input type="text" name="validityperiod" id="validityperiod" class="bal" value="" style="width:40px;"><span id="validstr">Days</span><input type="hidden" name="todaydate" id="todaydate" value="<?php echo date('Y-m-d'); ?>"> </td>
	 </tr>
	 <tr>
     	 <!-- <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Supplier Terms and conditions</strong>
     	 </td> -->
     	 <!-- <td colspan="2"></td> -->
		<?php
		$query7 = "select * from master_po_terms";
        $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res7 = mysqli_fetch_array($exec7);
		$terms = $res7['terms'];
		?>
     	<td colspan="5">
     		<label>Supplier Terms and conditions: </label>
				<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
				            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
				            494="left" border="0">
				          <tbody id="foo">
				         
						<tr></tr>
				                 <tr>
				                    <textarea id="consultation" cols='50' rows='15' class="ckeditor" name="editor1"><?php echo $terms;?></textarea>
								</tr>
							<?php 
						?>
				        </tbody>
				</table>		
     	</td>
     	<td colspan="1" align="right" valign="top"  bgcolor="#ecf0f5" class="bodytext3">
		  <input type="hidden" name="frm1submit1" value="frm1submit1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                   <input type="hidden" name="source" id="source" value="<?php echo $source; ?>" />
               <input name="Submit222" type="submit"  value="Save" class="button savebutton" id="saveindent">		 </td>
     </tr>
		</table>
		</td>
		</tr>				
		        
      <tr>
        <td align="left">
               <a href="print_generaterpia.php?docnumber=<?php echo $docno; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a>
               <a href="print_generaterpiapdf.php?docnumber=<?php echo $docno; ?>"><img src="images/pdfdownload.jpg" width="30" height="30"></a>
               </td>
		<!--  <td colspan="1" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
		  <input type="hidden" name="frm1submit1" value="frm1submit1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
               <input name="Submit222" type="submit"  value="Save" class="button" id="saveindent">		 </td> -->
              
      </tr>
	  </table>
      </td>
      </tr>
    
  </table>
</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
 <div id="items_dialog" title="Purchase History" width="500px" height="300px"> </div>
</body>
</html>