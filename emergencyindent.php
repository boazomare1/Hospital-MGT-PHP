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
$locationname=isset($_REQUEST['locationname'])?$_REQUEST['locationname']:'';
$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
$storecode=isset($_REQUEST['storecode'])?$_REQUEST['storecode']:'';
$store=isset($_REQUEST['store'])?$_REQUEST['store']:'';
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
	$lpotype    = $_REQUEST['lpotype'];
	$currency = explode(',',$_REQUEST['currency']);
	$currency = $currency[1];
	$fxamount = $_REQUEST['fxamount'];
	$piemailfrom = $_REQUEST['piemailfrom'];
	$bamailfrom = $_REQUEST['bamailfrom'];
	$bamailcc = $_REQUEST['bamailcc'];
	$jobdescription = $_REQUEST['jobdescription'];
	
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
		//$billnumbercode ='PI-'.'1';
		
		$billnumbercode =$paynowbillprefix."-".'1'."-".date('y')."-".$location_auto;
		$openingbalance = '0.00';
	}
	else
	{
		$billnumber = $res2["docno"];
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
		//$billnumbercode = 'PI-' .$maxanum;
		$openingbalance = '0.00';
		//echo $companycode;
		
	
	}
	/* if($purchasetype!='non-medical' && $purchasetype!='ASSETS')
	{
		$searchsuppliername = '';
		$searchsuppliercode = '';
		$searchsupplieranum = '';
	}
	else
	{ */
		$searchsuppliername = trim($_REQUEST['searchsuppliername']);
		$searchsuppliercode = trim($_REQUEST['searchsuppliercode']);
		$searchsupplieranum = trim($_REQUEST['searchsupplieranum']);
		/*$searchsuppliername = '';
		$searchsuppliercode = '';
		$searchsupplieranum = '';*/
		//}
	//$searchsuppliername = $_REQUEST['searchsuppliername'];
	//$searchsuppliername = $_REQUEST['searchsuppliername'];
		for ($p=1;$p<=2000;$p++)
		{	
		    //echo '<br>'.$i;
			//echo '<br>'.
			//$autonumber = $_REQUEST['autonumber'.$p];	
			//echo '<br>'.
		    $medicinename = $_REQUEST['medicinename'.$p];
		    
			if($purchasetype!='non-medical' && $purchasetype!='ASSETS')
			{
				
				$medicinecode = $_REQUEST['medicinecode'.$p];
				$pkgqty = $_REQUEST['pkgqty'.$p];
				
			}
			else
			{
				$medicinecode='';
				$pkgqty = '1';
			}
			$reqqty = str_replace(',','',$_REQUEST['reqqty'.$p]);
			$rate =str_replace(',','',$_REQUEST['rate'.$p]) ;
			$amount =str_replace(',','',$_REQUEST['amount'.$p]);
			
			
			if ($medicinename != "")
			{
				$query43="insert into purchase_indent(date,docno,medicinename,medicinecode,quantity,packagequantity,rate,amount,username,status,remarks,faremarks,companyanum,location,locationname,locationcode,storecode,storename,purchasetype,currency,fxamount,originalqty,originalamt,originalrate,suppliername,suppliercode,supplieranum,pimailfrom,bamailfrom,bamailcc,indent_memo,priority,job_title,lpo_type,indent_approval,approvalstatus,initial_approval)values('$dateonly','$billnumbercode','$medicinename','$medicinecode','$reqqty','$pkgqty','$rate','$amount','$username','$status','$remarks','$remarks','$companyanum','$location','".$locationname."','".$locationcode."','".$storecode."','".$store."','$purchasetype','$currency','$fxamount','$reqqty','$amount','$rate','$searchsuppliername','$searchsuppliercode','$searchsupplieranum','$piemailfrom','$bamailfrom','$bamailcc','$remarks','$priority','$job_title','$lpotype','approved','approved','1')";
						 
               // $query4885="update purchase_indent set indent_approval='approved' where docno='$docno' and medicinecode='$medicinecode' and docno='$billnumbercode'";
		        
				$exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		 
			
			}
				}
				$action='purchaseindent';
				//include('indentmail.php');
				header("location:emergencyindent.php?success=success");
				exit;
	}
	else
	{
	header("location:emergencyindent.php?success=Failed");
	exit;
	}
}
//to redirect if there is no entry in masters category or item or customer or settings
//To get default tax from autoitemsearch1.php and autoitemsearch2.php - for CST tax override.
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
	//$billnumbercode ='PI-'.'1';
	$openingbalance = '0.00';
}
else
{
	/*$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
    $billnumbercode=abs($billnumbercode);
	$billnumbercode = $billnumbercode + 1;
	$maxanum = $billnumbercode;*/
	
	    $billnumber = $res2["docno"];
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
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
<link rel="stylesheet" type="text/css" href="css/autocomplete.css" />  
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
	
	//alert(rateref);
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
function funcOnLoadBodyFunctionCall()
{
	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	//funcCustomerDropDownSearch7(); //To handle ajax dropdown list.
	
	//funcPopupPrintFunctionCall();
	
}
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
	//funcCustomerDropDownSearch4();
	//funcPopupPrintFunctionCall();
	
}
</script>
<script>
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
	if(purchasetype!='non-medical' && purchasetype!='ASSETS')
	{
		document.getElementById("pkgqty").value=Math.round(pkgqty);
	}
	else
	{
	document.getElementById("pkgqty").value=Math.round(1);
	}
	if(document.getElementById('total').value=='')
	{
	var totalamount='0';
	}
	else
	{
	var totalamount=document.getElementById('total').value;
	}
	
	
	totalamount=parseFloat(totalamount.replace(/[^0-9\.]+/g,"")) + parseFloat(amount.replace(/[^0-9\.]+/g,""));
	//alert(totalamount);
	document.getElementById("total").value=formatMoney(totalamount.toFixed(2));
	
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
<script type="text/javascript" src="js/insertnewitem32.js?v=3.1"></script>
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
input[name="priority"] {
  -webkit-appearance: checkbox; /* Chrome, Safari, Opera */
  -moz-appearance: checkbox;    /* Firefox */
  -ms-appearance: checkbox;     /* not currently supported */
}
.savebutton{
 	font-size: 15px;
 	width: 100px;
    height: 35px;
    margin-top:75px;
}
</style>
<script src="js/datetimepicker_css.js"></script>
<?php //include("autocompletebuild_medicine1.php"); ?>
<?php //include("js/dropdownlist1scriptingmedicine1.php"); ?>
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/autocomplete_medicine1.js"></script>
<script type="text/javascript" src="js/automedicinecodesearch5kiambu1_emerindent.js"></script>
<script type="text/javascript" src="js/jquery.min-autocomplete.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript">
$(function() {
$('#searchsuppliername').autocomplete({
	source:'ajaxsuppliernewserach.php', 
	select: function(event,ui){
			var code = ui.item.id;
			var anum = ui.item.anum;
			$('#searchsuppliercode').val(code);
			$('#searchsupplieranum').val(anum);
			},
	  open: function( event, ui ) {
			$("#searchsuppliercode").val('');
	   },
	html: true
    });
	$('#rate').focusin(function() {
  $('#rate' ).val($('#rate' ).val().replace(/[^0-9\.]+/g,""));
});
$('#rate').focusout(function() {
  $('#rate' ).val(formatMoney($('#rate' ).val().replace(/[^0-9\.]+/g,"")));
});
	$('#reqqty').focusin(function() {
  $('#reqqty' ).val($('#reqqty' ).val().replace(/[^0-9\.]+/g,""));
});
$('#reqqty').focusout(function() {
  $('#reqqty' ).val($('#reqqty' ).val().replace(/[^0-9\.]+/g,"").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
});
});
</script>
<script>
function currencyfix()
{
var trl=$('#insertrow tr').length;
if(trl!=0)
{
$('#currency').prop('disabled',true);
}
else
{
$('#currency').prop('disabled',false);
}
}
function functioncurrencyfx(val)
{	
	var myarr = val.split(",");
	var currate=myarr[0];
	var currency=myarr[1];
	//alert(currate);
	//alert(currency);
	document.getElementById("fxamount").value=  currate;
	//document.getElementById("amounttot").value='';
	//document.getElementById("currencyamt").value='';
	
}
function functiontransactionfx()
{	
	var purchasetype=document.getElementById("purchasetype").value;
	//alert(purchasetype);
	if(purchasetype!='Expenses' && purchasetype!='Others' && purchasetype!='non-medical' && purchasetype!='ASSETS' && purchasetype!='DRUGS' && purchasetype!='NON DRUGS')
	{
		$( "#medicinename" ).autocomplete( "option", "disabled", false );
		document.getElementById("packsize").value='';
		document.getElementById("pkgqty").value='';
		document.getElementById("rate").value='';
		document.getElementById("searchsuppliername").value='';
		document.getElementById("searchsuppliercode").value='';
		document.getElementById("searchsuppliername").disabled=true;
		document.getElementById("searchsuppliercode").disabled=true;
		
		//document.getElementById("rate").readOnly=false;
		document.getElementById("packsize").disabled=false;
		document.getElementById("pkgqty").disabled=false;
		document.getElementById("avlqty").disabled=false;
		
		var divsToHide = document.getElementsByClassName("supblc"); //divsToHide is an array
    for(var i = 0; i < divsToHide.length; i++){
        //divsToHide[i].style.visibility = "hidden"; // or
        divsToHide[i].style.display = "none"; // depending on what you're doing
    }
	}
	else
	{
		if(purchasetype=='non-medical' || purchasetype=='ASSETS' || purchasetype=='DRUGS' || purchasetype=='NON DRUGS' )
		{
		$( "#medicinename" ).autocomplete( "option", "disabled",true);
		}
		document.getElementById("packsize").value='1';
		document.getElementById("pkgqty").value='1';
		document.getElementById("rate").value='0';
		document.getElementById("rate").readOnly=false;
		document.getElementById("searchsuppliername").value='';
		document.getElementById("searchsuppliercode").value='';
		document.getElementById("searchsuppliername").disabled=false;
		document.getElementById("searchsuppliercode").disabled=false;
		document.getElementById("packsize").disabled=true;
		document.getElementById("pkgqty").disabled=true;
		document.getElementById("avlqty").disabled=true;
			var divsToHide = document.getElementsByClassName("supblc"); //divsToHide is an array
    for(var i = 0; i < divsToHide.length; i++){
        //divsToHide[i].style.visibility = "hidden"; // or
        divsToHide[i].style.display = ""; // depending on what you're doing
    }
	}
	$("#medicinename").autocomplete({
	source: "ajax/ajaxmedicine.php?purchasetype="+$("#purchasetype").val(),
	minLength: 2,
        select: function(event, ui) {
		    $("#medicinecode").val(ui.item.itemcode) ;
			$("#medicinenamel").val(ui.item.value);
			funcmedicinesearch4()
        },
 		//funcmedicinesearch4()
        html: true
	 
	});
	$("#medicinename").keyup(function()
	{
	//alert();
	if($("#medicinename").val().trim()!=$("#medicinenamel").val().trim())
	{
	//alert();
	$("#medicinecode").val('');
	$("#rate").val('');
	$("#fxrate").val('');
	$("#amount").val('');
	}
	});
}
function process()
{
	var purchasetype=document.getElementById("purchasetype").value;
	
	if(purchasetype=='')
	{
		alert('Please Select Purchase Type');
		document.getElementById("purchasetype").focus();
		return false;
	}
	if(document.getElementById("total").value=='0.00' || document.getElementById("total").value=='')
	{
	alert('Please Enter atleast one item ');
		document.getElementById("medicinename").focus();
		return false;
	}
	var remarks=document.getElementById("remarks").value;
	if(remarks=='')
	{
		alert('Please Enter MEMO ');
		document.getElementById("remarks").focus();
		return false;
	}
	
	var currency=document.getElementById("currency").value;
	if(currency=='')
	{
		alert('Please Select currency');
		document.getElementById("currency").focus();
		return false;
	}
	/*var searchsuppliername=document.getElementById("searchsuppliername").value;
	if(searchsuppliername=='')
	{
		alert('Please Enter Supplier Name');
		document.getElementById("searchsuppliername").focus();
		return false;
	}
	var searchsupplieranum=document.getElementById("searchsupplieranum").value;
	if(searchsupplieranum=='')
	{
		alert('Please Select Supplier From the List');
		document.getElementById("searchsuppliername").focus();
		return false;
	}*/
	if(document.querySelectorAll('input[name=priority]:checked').length == 0)
	{
		alert('Please Select Priority');
		document.getElementById("priority1").focus();
		return false;
	}
	//document.getElementById("saveindent").disabled=true;
	$('#currency').prop('disabled',false);
	//alert(document.getElementById("currency").value);
	var varUserChoice; 
	varUserChoice = confirm('Are you sure of saving the data?'); 
	//alert(fRet); 
	if (varUserChoice == false)
	{
		//alert ("Entry Not Saved.");
		return false;
	}
	else
	{
		//alert ("Entry Saved.");
		document.frmsales.submit();
		//return true;
	}
}
function clickmedicine()
{
	var medicinename=document.getElementById("purchasetype").value;
	var medicinenametype = medicinename;
	if(medicinename=='')
	{
		alert('Please Select Purchase Type');
		document.getElementById("purchasetype").focus();
		return false;
	}
	var medicinename=document.getElementById("currency").value;
	if(medicinename=='')
	{
		alert('Please Select currency');
		document.getElementById("currency").focus();
		return false;
	}
	//if(medicinenametype=='ASSETS'){
           if(document.getElementById("searchsuppliercode").value==''){
               alert('Please Select supplier');
				document.getElementById("searchsuppliername").focus();
				return false;
		   }
	//}
	var medicinename=document.getElementById("lpotype").value;
	if(medicinename=='')
	{
		alert('Please Select LPO type');
		document.getElementById("lpotype").focus();
		return false;
	}
}
</script>
</head>
      
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="form1" id="frmsales" method="post" action="emergencyindent.php" onKeyDown="return disableEnterKey(event)" onSubmit="return process()">
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
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="980" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <?php if($success=='success'){?>
			  <tr>
			    <td colspan="8" align="left" valign="middle"  bgcolor="#FF9933" class="bodytext3"><strong>Transaction SucessFully Saved</strong></td>
                
			    </tr>
			<?php }?>
			  <tr>
			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>DOC No</strong></td>
                <td width="12%" align="left" valign="top" >
				<input name="docno" id="docno" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A;" size="10" autocomplete="off" readonly/>                  </td>
                 <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Date</strong></td>
                <td width="12%" align="left" valign="top" >
				<input name="date" id="date" value="<?php echo $dateonly; ?>" style="border: 1px solid #001E6A" size="10" rsize="20" readonly/>				</td>
                <td width="9%" align="left" valign="middle" class="bodytext3" ><strong>Store</strong></td>
                <td width="18%" align="left" valign="top" ><input type="text" name="store" id="store" value="<?php echo $store; ?>" size="18" rsize="20" style="border: 1px solid #001E6A">
                <input type="hidden" name="storecode" id="storecode" value="<?php echo $storecode; ?>" size="18" rsize="20" style="border: 1px solid #001E6A">
                </td>
                <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Location</strong></td>
                <td width="20%" colspan="3" align="left" valign="top" >
				<input name="location" id="location" value="<?php echo $locationname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
                <input type="hidden" name="locationcode" value="<?php echo $locationcode?>">			</td>
			    </tr>
                
                <tr>
			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Purchase Type</strong></td>
                <td width="12%" align="left" valign="top" >
				<select id="purchasetype" name="purchasetype" onChange="functiontransactionfx()" style="border:#F00 1px solid">
                <option value=''>Select</option>
                <?php
                $query16 = "select name from master_purchase_type where status <> 'deleted' and name<>'ASSETS' order by id";
				$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res16 = mysqli_fetch_array($exec16))
				{
				$purchasetype = $res16["name"];
				?>
                <option value="<?= $purchasetype; ?>"><?= $purchasetype; ?></option>
				<?php
				}
				?>
			
                </select>
                </td>
                 <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Currency</strong></td>
                <td width="12%" align="left" valign="top" >
				<select  name="currency" id="currency" onChange="return functioncurrencyfx(this.value)" >
                 <!--  <option value="">Select Currency</option> -->
                                    
                    <?php
					$query1currency = "select currency,rate from master_currency where recordstatus = '' ";
					$exec1currency = mysqli_query($GLOBALS["___mysqli_ston"], $query1currency) or die ("Error in Query1currency".mysqli_error($GLOBALS["___mysqli_ston"]));
					while ($res1currency = mysqli_fetch_array($exec1currency))
					{
					$currency = $res1currency["currency"];
					$rate = $res1currency["rate"];
					?>
                  <option value="<?php echo $rate.','.$currency; ?>"><?php echo $currency; ?></option>
                  <?php
					}
					?>
                    
                  
                   </select>				</td>
                <td width="9%" align="left" valign="middle" class="bodytext3" ><strong>FX Rate</strong></td>
                <td width="18%" align="left" valign="top" ><input name="fxamount" type="text" id="fxamount" size="8" value="1" readonly>
               
                </td>
<span id="supblc" style="display:none">
               <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3 supblc" style="display:none"><strong>Supplier Name</strong></td>
                <td width="20%" colspan="3" align="left" valign="top" class="supblc" style="display:none" >
                <input name="searchsuppliername" type="text" id="searchsuppliername" value="" size="30" autocomplete="off">
                <input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" />
				 <input type="hidden" name="searchsupplieranum" id="searchsupplieranum" style="text-transform:uppercase" value="<?php echo $searchsupplieranum; ?>" size="20" />
					</td> 
					</span>
					    <td width="15%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" style="display:none"><strong>LPO Type</strong></td>
			<td width="12%" align="left" valign="top" style="display:none">
				<select  name="lpotype" id="lpotype" >
                   <option value="">Select </option>
                   <option value="CASH">CASH </option>
                   <option selected value="CREDIT">CREDIT </option>
               </select>
				</td>
				
			    </tr>
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
                <!--<tr>
			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>From</strong></td>
                <td colspan="2" align="left" valign="top" ><?php echo $useremail;?></td>
                 <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>To</strong></td>
                <td colspan="2" align="left" valign="top" ><?php echo $emailto;?></td>
                <td width="9%" align="left" valign="middle" class="bodytext3" ><strong>CC</strong></td>
                <td colspan="2" align="left" valign="top" ><?php echo $emailcc;?></td>
			    </tr>
-->
				<input type="hidden" name="piemailfrom" id="piemailfrom" value="<?php echo $useremail;?>"><input type="hidden" name="jobdescription" id="jobdescription" value="<?php echo $jobdescription;?>">
				<input type="hidden" name="bamailfrom" id="bamailfrom" value="<?php echo $emailto;?>">
				<input type="hidden" name="bamailcc" id="bamailcc" value="<?php echo $emailcc;?>">
                
            </tbody>
        </table></td>
      </tr>
      <tr>
	  <td>&nbsp;
	  </td>
	  </tr>
      <tr id="pressid">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				   <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="150" class="bodytext3">Item Description</td>
                       <td width="48" class="bodytext3">Avl Qty</td>
                       <td width="41" class="bodytext3">Req Qty</td>
                       <td width="48" class="bodytext3">Pack Size</td>
                       <td width="48" class="bodytext3">Pkg Qty</td>                      
                       <td class="bodytext3">Rate</td>
                       <td width="48" class="bodytext3">Amount</td>
                     </tr>
					 <tr>
					 <div id="insertrow">					 </div></tr>
                     <tr>
					  <input type="hidden" name="serialnumber" id="serialnumber" value="1">
					  <input type="hidden" name="medicinecode" id="medicinecode" value="">
                       <td><input name="medicinename" type="text" id="medicinename" size="45" autocomplete="off"  onClick="clickmedicine();">
					   <input type="hidden" name="medicinenamel" id="medicinenamel" value="">
					   </td>
                       <td><input name="avlqty" type="text" id="avlqty" size="8" readonly></td>
                        <td><input name="reqqty" type="text" id="reqqty" size="8" onKeyUp="return calc();" autocomplete="off"></td>
                       <td><input name="packsize" type="text" id="packsize" size="8" readonly></td>
                       <td><input name="pkgqty" type="text" id="pkgqty" size="8" readonly></td>
                       <td width="48"><input name="rate" type="text" id="rate"  size="8" onKeyUp="return calc();" autocomplete="off" readonly>
					   <input name="fxrate" type="hidden" id="fxrate" readonly size="8"></td>
                       <td>
                         <input name="amount" type="text" id="amount" readonly size="8"></td>
                       <td><label>
                       <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem10()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
                     
					 <input type="hidden" name="h" id="h" value="0">
                   </table>				  </td>
			       </tr>
			       <tr><td>&nbsp;</td></tr>
				    <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total</span><input type="text" id="total" readonly size="7"></td>
			      </tr>
				  <tr>
	  <td>&nbsp;
	  </td>
	  </tr>
      <tr>
	  <td>
	  <table width="816">
     <tr>
	 <td width="66" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">User Name</td>
	   <td width="111" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> <input type="text" name="username" value="<?php echo $username; ?>" size="10" readonly></td>
	    <td width="47" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Status</td>
	   <td width="120" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> <input type="text" name="status" value="RFA" size="10"></td>
	    <td width="84" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Memo</td>
	    <td width="260" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" calign="left"><textarea name="remarks" id="remarks"></textarea></td>
	 </tr>
	 <tr>
	 <td width="47" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Priority</strong></td>
	 <td colspan="4" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
	 <input type="radio" name="priority" id="priority1" value="Critical" checked><label for="priority1">Critical</label>&nbsp;&nbsp;
	 <input type="radio" name="priority" id="priority2" value="High"><label for="priority2">High</label>&nbsp;&nbsp;
	 <input type="radio" name="priority" id="priority3" value="Medium"><label for="priority3">Medium</label>&nbsp;&nbsp;
	 <input type="radio" name="priority" id="priority4" value="Low"><label for="priority4">Low</label>&nbsp;&nbsp;
	 </td>
	 </tr>
		</table>
		</td>
		</tr>				
		        
      <tr>
        
		 <td colspan="2" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
		  <input type="hidden" name="frm1submit1" value="frm1submit1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
               <input name="Submit222" type="submit"  value="Save" class="button savebutton" id="saveindent" style="border: 1px solid #001E6A"/>		 </td>
      </tr>
	  </table>
      </td>
      </tr>
    
  </table>
</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>