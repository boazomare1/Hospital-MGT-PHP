<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$docno1 = $_SESSION['docno'];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$recorddate = date('Y-m-d');
$recordtime = date('H:i:s');

$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

$uniquecode = array();
$duplicated = array();
$uniquecode12 = array();
$main_array = array();
$sub_array = array();

//error_reporting(E_ALL);

//To populate the autocompetelist_services1.js

$transactiondatefrom = date('Y-m-d');

$transactiondateto = date('Y-m-d');

if(isset($_POST['ADate1'])){$fromdate = $_POST['ADate1'];}else{$fromdate=$transactiondatefrom;}

if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate=$transactiondateto;}

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

//$frmflag1 = $_REQUEST['frmflag1'];
if (isset($_REQUEST["lpodate"])) { $lpodate = $_REQUEST["lpodate"]; } else { $lpodate = ""; }


$query = "select * from login_locationdetails where username='$username' and docno='$docno1' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
$locationname  = $res["locationname"];
$locationcode = $res["locationcode"];

$query018="select auto_number from master_location where locationcode='$locationcode'";
$exc018=mysqli_query($GLOBALS["___mysqli_ston"], $query018);
$res018=mysqli_fetch_array($exc018);
$location_auto = $res018['auto_number'];

$query77 = "select job_title from master_employee where username = '$username'";
$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
$res77 = mysqli_fetch_array($exec77);
$job_title = $res77['job_title'];



if ($frmflag1 == 'frmflag1')

{

//$medicinecode = $_REQUEST['medicinecode'];
if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

}

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }

if (isset($_REQUEST["lpodate"])) { $lpodate = $_REQUEST["lpodate"]; } else { $lpodate = ""; }

if ($frm1submit1 == 'frm1submit1')

{
//MLPO
		$query31 = "select * from bill_formats where description = 'direct_purchase'";
		$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res31 = mysqli_fetch_array($exec31);
		$paynowbillprefix1 = $res31['prefix'];
		//$paynowbillprefix1="MLPO-";
		$number1='';
		//$paynowbillprefix1=strlen($paynowbillprefix1);
		$query2 = "select * from manual_lpo order by auto_number desc limit 0, 1";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$num2 = mysqli_num_rows($exec2);
		 $billnumber = $res2["billnumber"];
		$billdigit=strlen($billnumber);
		if ($billnumber == '')
		{
		//$billnumbercode ='MLPO-'.'1';
		$billnumbercode =$paynowbillprefix1."-".'1'."-".date('y')."-".$location_auto;
		$number1 = '1';
		}
		else
		{
		$billnumber = $res2["billnumber"];
	/*	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
		$billnumbercode = intval($billnumbercode);
		$billnumbercode = $billnumbercode + 1;
		$number1 = $billnumbercode;
		$maxanum = $billnumbercode;		
		$billnumbercode = 'MLPO-'.$maxanum;	*/	
		$maxcount_1=split("-",$billnumber);
		$maxcount_2=$maxcount_1[1];
		$maxanum = $maxcount_2+1;
		$billnumbercode = $paynowbillprefix1 ."-".$maxanum."-".date('y')."-".$location_auto;	
		//echo $companycode;
		}
	//MGR	
	$query313 = "select * from bill_formats where description = 'external_mrn'";
	$exec313 = mysqli_query($GLOBALS["___mysqli_ston"], $query313) or die ("Error in Query313".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res313 = mysqli_fetch_array($exec313);
	$paynowbillprefix4 = $res313['prefix'];		
  //$paynowbillprefix = 'MGR-';
  $paynowbillprefix13=strlen($paynowbillprefix);
 $query2233 = "select * from materialreceiptnote_details where billnumber like '%$paynowbillprefix4-%' order by auto_number desc limit 0, 1";
  $exec2233 = mysqli_query($GLOBALS["___mysqli_ston"], $query2233) or die ("Error in Query2233".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res2233 = mysqli_fetch_array($exec2233);
  $billnumber3 = $res2233["billnumber"];
  $billdigit3=strlen($billnumber3);
  if ($billnumber3 == '')
  {
    //$billnumbercode3 ='MGR-'.'1';
	$billnumbercode3 =$paynowbillprefix4."-".'1'."-".date('y')."-".$location_auto;
    // $openingbalance = '0.00';
  }
  else
  {
    $billnumber3 = $res2233["billnumber"];
	$maxcount_1=split("-",$billnumber3);
	$maxcount_2=$maxcount_1[1];
	$maxanum = $maxcount_2+1;
	$billnumbercode3 = $paynowbillprefix4 ."-".$maxanum."-".date('y')."-".$location_auto;	
 /*   $billnumbercode3 = substr($billnumber3,$paynowbillprefix13, $billdigit3);
    $billnumbercode3 = intval($billnumbercode3);
    $billnumbercode3 = $billnumbercode3 + 1;
    $maxanum = $billnumbercode3;
    $billnumbercode3 = 'MGR-' .$maxanum;*/
    // $openingbalance = '0.00';
  }
  
//$paynowbillprefix140 = 'PI-';
$query314 = "select * from bill_formats where description = 'purchase_indent'";
$exec314 = mysqli_query($GLOBALS["___mysqli_ston"], $query314) or die ("Error in Query314".mysqli_error($GLOBALS["___mysqli_ston"]));
$res314 = mysqli_fetch_array($exec314);
$paynowbillprefix140 = $res314['prefix'];
$paynowbillprefix14=strlen($paynowbillprefix140);
$query21 = "select * from purchase_indent order by auto_number desc limit 0, 1";
$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
$res21 = mysqli_fetch_array($exec21);
$billnumber4 = $res21["docno"];
$billdigit4=strlen($billnumber4);
if ($billnumber4 == '')
{
  //$billnumbercode4 ='PI-'.'1';
   $billnumbercode4 =$paynowbillprefix140."-".'1'."-".date('y')."-".$location_auto;
  //$openingbalance = '0.00';
}
else
{
  $billnumber4 = $res21["docno"];
  /*$billnumbercode4 = substr($billnumber4,$paynowbillprefix14, $billdigit4);
  $billnumbercode4 = intval($billnumbercode4);
  $billnumbercode4 = $billnumbercode4 + 1;
  $maxanum = $billnumbercode4;
  $billnumbercode4 = 'PI-' .$maxanum;*/
  //$openingbalance = '0.00';
  //echo $companycode;
	$maxcount_1=split("-",$billnumber4);
	$maxcount_2=$maxcount_1[1];
	$maxanum = $maxcount_2+1;
	$billnumbercode4 = $paynowbillprefix140 ."-".$maxanum."-".date('y')."-".$location_auto;
}
  
$sno_new = $_REQUEST['sno_new'];
$lpodate_1 = $_REQUEST['lpodate_1'];

for($i=1;$i<=$sno_new;$i++)
{
$selectbox = $_REQUEST['selectbox'.$i];
if($selectbox=='1'){
			
			$sub_array['patientname']= $_REQUEST['billpatietname'.$i];
			$sub_array['regnumber'] = $_REQUEST['regnumber'.$i];
			$sub_array['visitnumber'] = $_REQUEST['visitnumber'.$i];
			$sub_array['ageno'] = $_REQUEST['ageno'.$i];			
			$sub_array['gender'] = $_REQUEST['gender'.$i];
			$sub_array['test'] = $_REQUEST['test'.$i];
			$sub_array['suppliername'] = $_REQUEST['suppliername'.$i];
			$sub_array['baserate'] = $_REQUEST['baserate'.$i];
			$sub_array['tax_percent'] = $_REQUEST['tax_percent'.$i];
			$sub_array['amount'] = $_REQUEST['amount'.$i];
			$sub_array['suppliercode'] = $_REQUEST['suppliercode'.$i];
			$sub_array['testcode'] = $_REQUEST['testcode'.$i];	
			$sub_array['suppliername_mlpo'] = $_REQUEST['suppliername_mlpo'.$i];
			$sub_array['supplier_autono'] = $_REQUEST['supplier_autono'.$i];				
			$sub_array['auto_no'] = $_REQUEST['auto_no'.$i];
			$sub_array['table_name'] = $_REQUEST['table_name'.$i];								
			$sub_array['suppliercode_test'] = str_replace('-','',$_REQUEST['suppliercode'.$i]);		
			array_push($main_array, $sub_array);
}
}

usort($main_array, function(array  $a,array  $b) {
    return $a['suppliercode_test'] - $b['suppliercode_test'];
});

$main_array=array_reverse($main_array);
//print_r($main_array);
//$pmlo_count=count($main_array);
$old_sup_code='';
foreach($main_array as $mplo_items) {

$patientname=$mplo_items['patientname'];
$regnumber=$mplo_items['regnumber'];
$visitno=$mplo_items['visitnumber'];
$age=$mplo_items['ageno'];
$test=$mplo_items['test'];
$suppliername=$mplo_items['suppliername'];
$baserate=$mplo_items['baserate'];
$tax_percent=$mplo_items['tax_percent'];
$amount=$mplo_items['amount'];
$suppliercode=$mplo_items['suppliercode'];
$testcode=$mplo_items['testcode'];
$suppliername_mlpo=$mplo_items['suppliername_mlpo'];
$supplier_autono=$mplo_items['supplier_autono'];
$taxamount=$amount-$baserate;
$auto_no=$mplo_items['auto_no'];
$table_name=$mplo_items['table_name'];

if($old_sup_code!=''){
	if($old_sup_code==$mplo_items['suppliercode']){
		//insert
		$query35 = "insert into manual_lpo(entrydate,billnumber,suppliername,username,ipaddress,suppliercode,itemname,itemcode,rate,itemtaxpercentage,itemtaxamount,totalamount,quantity,is_blanket,recordstatus,locationname,locationcode,supplieranum,currency,docstatus,fxamount,fxpkrate,fxtotamount,companyanum,job_title,expirydate,purchaseindentdocno,sample_table,sample_autono )values('$recorddate','$billnumbercode','$suppliername_mlpo','$username','$ipaddress','$suppliercode','$test','$testcode','$baserate','$tax_percent','$taxamount','$amount','1','no','generated','$locationname','$locationcode','$supplier_autono','Kshs','new','1','$baserate','$amount','$companyanum','$job_title','$lpodate_1','$billnumbercode4','$table_name','$auto_no')";
		$exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	
		
	 	$query351 = "insert into materialreceiptnote_details(entrydate,billnumber,suppliername,username,ipaddress,suppliercode,itemname,itemcode,rate,itemtaxpercentage,itemtaxamount,totalamount,is_blanket,job_title,companyanum,fxpkrate,priceperpk,quantity,subtotal,costprice,itemtotalquantity,allpackagetotalquantity,supplieranum,typeofpurchase,ponumber,locationcode,totalfxamount,currency,fxamount,expirydate )values('$recorddate','$billnumbercode3','$suppliername_mlpo','$username','$ipaddress','$suppliercode','$test','$testcode','$baserate','$tax_percent','$taxamount','$amount','no','$job_title','$companyanum','$baserate','$baserate','1','$amount','$amount','1','1','$supplier_autono','Process','$billnumbercode','$locationcode','$amount','Kshs','1','$lpodate_1')";
		$exec351 = mysqli_query($GLOBALS["___mysqli_ston"], $query351) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	
		
	
		$query355 = "insert into purchase_indent(date,docno,medicinename,medicinecode,quantity,rate,amount,username,companyanum,location,approvalstatus,pogeneration,locationname,locationcode,suppliername,suppliercode,supplieranum,currency,fxamount,originalqty,originalamt,originalrate,povalidity,job_title,tax_percentage,tax_amount )	values('$recorddate','$billnumbercode4','$test','$testcode','1','$baserate','$amount','$username','$companyanum','$locationname','approved','completed','$locationname','$locationcode','$suppliername_mlpo','$suppliercode','$supplier_autono','Kshs','1','1','$amount','$baserate','$lpodate_1','$job_title','$tax_percent','$taxamount')";
		$exec355 = mysqli_query($GLOBALS["___mysqli_ston"], $query355) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	
		
	 $query1223="update $table_name set externalack='1'  where auto_number='$auto_no'  ";
	 $exec1223 = mysqli_query($GLOBALS["___mysqli_ston"], $query1223) or die ("Error in Query1223".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		
	 
	}else{
		//incr and insert
		$billnumbercode++;
		$billnumbercode3++;
		$billnumbercode4++;	
		$query35 = "insert into manual_lpo(entrydate,billnumber,suppliername,username,ipaddress,suppliercode,itemname,itemcode,rate,itemtaxpercentage,itemtaxamount,totalamount,quantity,is_blanket,recordstatus,locationname,locationcode,supplieranum,currency,docstatus,fxamount,fxpkrate,fxtotamount,companyanum,job_title,expirydate,purchaseindentdocno,sample_table,sample_autono )values('$recorddate','$billnumbercode','$suppliername_mlpo','$username','$ipaddress','$suppliercode','$test','$testcode','$baserate','$tax_percent','$taxamount','$amount','1','no','generated','$locationname','$locationcode','$supplier_autono','Kshs','new','1','$baserate','$amount','$companyanum','$job_title','$lpodate_1','$billnumbercode4','$table_name','$auto_no')";
		$exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	
		
		$query351 = "insert into materialreceiptnote_details(entrydate,billnumber,suppliername,username,ipaddress,suppliercode,itemname,itemcode,rate,itemtaxpercentage,itemtaxamount,totalamount,is_blanket,job_title,companyanum,fxpkrate,priceperpk,quantity,subtotal,costprice,itemtotalquantity,allpackagetotalquantity,supplieranum,typeofpurchase,ponumber,locationcode,totalfxamount,currency,fxamount,expirydate )values('$recorddate','$billnumbercode3','$suppliername_mlpo','$username','$ipaddress','$suppliercode','$test','$testcode','$baserate','$tax_percent','$taxamount','$amount','no','$job_title','$companyanum','$baserate','$baserate','1','$amount','$amount','1','1','$supplier_autono','Process','$billnumbercode','$locationcode','$amount','Kshs','1','$lpodate_1')";
	$exec351 = mysqli_query($GLOBALS["___mysqli_ston"], $query351) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query355 = "insert into purchase_indent(date,docno,medicinename,medicinecode,quantity,rate,amount,username,companyanum,location,approvalstatus,pogeneration,locationname,locationcode,suppliername,suppliercode,supplieranum,currency,fxamount,originalqty,originalamt,originalrate,povalidity,job_title,tax_percentage,tax_amount )		values('$recorddate','$billnumbercode4','$test','$testcode','1','$baserate','$amount','$username','$companyanum','$locationname','approved','completed','$locationname','$locationcode','$suppliername_mlpo','$suppliercode','$supplier_autono','Kshs','1','1','$amount','$baserate','$lpodate_1','$job_title','$tax_percent','$taxamount')";
		$exec355 = mysqli_query($GLOBALS["___mysqli_ston"], $query355) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query1223="update $table_name set externalack='1'  where auto_number='$auto_no'  ";
	$exec1223 = mysqli_query($GLOBALS["___mysqli_ston"], $query1223) or die ("Error in Query1223".mysqli_error($GLOBALS["___mysqli_ston"]));
			
	}
}else{
 $query35 = "insert into manual_lpo(entrydate,billnumber,suppliername,username,ipaddress,suppliercode,itemname,itemcode,rate,itemtaxpercentage,itemtaxamount,totalamount,quantity,is_blanket,recordstatus,locationname,locationcode,supplieranum,currency,docstatus,fxamount,fxpkrate,fxtotamount,companyanum,job_title,expirydate,purchaseindentdocno,sample_table,sample_autono )values('$recorddate','$billnumbercode','$suppliername_mlpo','$username','$ipaddress','$suppliercode','$test','$testcode','$baserate','$tax_percent','$taxamount','$amount','1','no','generated','$locationname','$locationcode','$supplier_autono','Kshs','new','1','$baserate','$amount','$companyanum','$job_title','$lpodate_1','$billnumbercode4','$table_name','$auto_no')";
		$exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
	 $query351 = "insert into materialreceiptnote_details(entrydate,billnumber,suppliername,username,ipaddress,suppliercode,itemname,itemcode,rate,itemtaxpercentage,itemtaxamount,totalamount,is_blanket,job_title,companyanum,fxpkrate,priceperpk,quantity,subtotal,costprice,itemtotalquantity,allpackagetotalquantity,supplieranum,typeofpurchase,ponumber,locationcode,totalfxamount,currency,fxamount,expirydate )values('$recorddate','$billnumbercode3','$suppliername_mlpo','$username','$ipaddress','$suppliercode','$test','$testcode','$baserate','$tax_percent','$taxamount','$amount','no','$job_title','$companyanum','$baserate','$baserate','1','$amount','$amount','1','1','$supplier_autono','Process','$billnumbercode','$locationcode','$amount','Kshs','1','$lpodate_1')";
	$exec351 = mysqli_query($GLOBALS["___mysqli_ston"], $query351) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query355 = "insert into purchase_indent(date,docno,medicinename,medicinecode,quantity,rate,amount,username,companyanum,location,approvalstatus,pogeneration,locationname,locationcode,suppliername,suppliercode,supplieranum,currency,fxamount,originalqty,originalamt,originalrate,povalidity,job_title,tax_percentage,tax_amount )	values('$recorddate','$billnumbercode4','$test','$testcode','1','$baserate','$amount','$username','$companyanum','$locationname','approved','completed','$locationname','$locationcode','$suppliername_mlpo','$suppliercode','$supplier_autono','Kshs','1','1','$amount','$baserate','$lpodate_1','$job_title','$tax_percent','$taxamount')";
		$exec355 = mysqli_query($GLOBALS["___mysqli_ston"], $query355) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	 $query1223="update $table_name set externalack='1'  where auto_number='$auto_no'  ";
	 $exec1223 = mysqli_query($GLOBALS["___mysqli_ston"], $query1223) or die ("Error in Query1223".mysqli_error($GLOBALS["___mysqli_ston"]));

}

$old_sup_code=$mplo_items['suppliercode'];

}





//$newvalue=array_unique($uniquecode);
//print_r($newvalue);

//header("location:externallabpo.php");
//exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>External Radiology PO - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/externalradpo-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<?php include ("autocompletebuild_supplier1.php"); ?>

<?php

function calculate_age($birthday)
{

    $today = new DateTime();

    $diff = $today->diff(new DateTime($birthday));



    if ($diff->y)

    {

        return $diff->y . ' Years';

    }

    elseif ($diff->m)

    {

        return $diff->m . ' Months';

    }

    else

    {

        return $diff->d . ' Days';

    }

}

?>
<script src="js/jquery-1.11.1.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/autocomplete.css">

<link rel="stylesheet" type="text/css" href="css/style.css">

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; }

-->

</style>

</head>

<!--<script type="text/javascript" src="js/autocomplete_supplier12.js"></script>

<script type="text/javascript" src="js/autosuggest2supplier1.js"></script>-->

<script type="text/javascript">

 $(function() {

  getValidityDays();
});
function calEqAmt(id)
{
var idno = id.match(/\d+/);
var opt = $("#suppliername"+idno).val();
var optsplit = opt.split('||');
var opt1 = optsplit[0];
var opt2 = optsplit[1];
var opt3 = optsplit[2];
var opt4 = optsplit[3];
$('#suppliername_mlpo'+idno).val(opt1);
$('#baserate'+idno).val(opt3);
$('#suppliercode'+idno).val(opt2);
$('#supplier_autono'+idno).val(opt4);
CalculateAmount('#baserate'+idno);
}

function validcheckbox(id)
{
//alert(id);
if(document.getElementById("selectbox"+id).checked == true)
{
$("#selectbox"+id).val(1);
}
else
{
$("#selectbox"+id).val(0);	
}
}






function CalculateAmount(id)
{

// /^\d*$/.req_qty(value);
// /^\d*$/.rate_fx(value);
var idno = id.match(/\d+/);
var suppliername = $('#suppliername'+idno).val();
var item_code = '';
 /*if(suppliername == '')
 {
   alert('Please Select Suppliername ');
   $('#tax_percent'+idno).val('');
   $('#suppliername'+idno).focus();
 }*/  
  var rate=($.trim($('#baserate'+idno).val())!='')?$.trim($('#baserate'+idno).val()):'0.00';
  // $('#rate_fx').val(rate);
//alert(rate); 
  var tax=$('#tax_percent'+idno).val(); 
  // rate=(rate/fxrate);
  var total1=parseFloat(rate);
  var total2=parseFloat(total1*tax) / 100;
  $('#tax_amount').val(total2);
   var total3=parseFloat(total2+total1);
    // var total_amount=parseFloat(req_qty*rate).toFixed(2); 
     var total_amount1=parseFloat(total3).toFixed(2); 
     $('#amount'+idno).val(total_amount1);
     console.log(~~NaN);
   // }
}


function externallabvalue()
{
var checkcount_c=0;
var sno_new = $('#sno_new').val();
	for(var i=1;i<=sno_new;i++)
	{
		//k=sno-1;
		
		if(document.getElementById("selectbox"+i).checked == true)
		{
		
		if($("#suppliername"+i).val() == "")
		{	
        alert("Please select suppliername");
    	$('#suppliername'+i).focus();
	    return false;	
    	}
		
		if($("#baserate"+i).val() == "")
		{	
        alert("Please Enter Rate");
    	$('#baserate'+i).focus();
	    return false;	
    	}
		}
		
		
		
		var checkcount=document.getElementById("selectbox"+i).value;
		
		var checkcount_c=checkcount_c+checkcount;
		
		
	}
	
	    if(checkcount_c<1)
		{			
        alert("Please select atleast one Patient");    	
	    return false;	
    	}
	
var del;

del=confirm("Do You want to save?");

if(del == false)

{

return false;

}
else
{
	return true;

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
function validcheck()

{

/*externallabvalue();	

if(document.getElementById("searchsuppliername").value == '')

{

alert("Please Select External Lab");

document.getElementById("searchsuppliername").focus();

return false;

}*/

}

</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        



<script type="text/javascript" src="js/disablebackenterkey.js"></script>



<script src="js/datetimepicker_css.js"></script>



<body>
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">External Radiology Purchase Order System</p>
    </header>

    <!-- User Information Bar -->
    <div class="user-info-bar">
        <div class="user-welcome">
            <span class="welcome-text">Welcome, <strong><?php echo htmlspecialchars($username); ?></strong></span>
            <span class="location-info">📍 Company: <?php echo htmlspecialchars($companyname); ?></span>
        </div>
        <div class="user-actions">
            <a href="mainmenu1.php" class="btn btn-outline">🏠 Main Menu</a>
            <a href="logout.php" class="btn btn-outline">🚪 Logout</a>
        </div>
    </div>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Home</a>
        <span>→</span>
        <span>External Radiology PO</span>
    </nav>

    <!-- Floating Menu Toggle -->
    <div id="menuToggle" class="floating-menu-toggle">
        <i class="fas fa-bars"></i>
    </div>

    <!-- Main Container with Sidebar -->
    <div class="main-container-with-sidebar">
        <!-- Left Sidebar -->
        <aside id="leftSidebar" class="left-sidebar">
            <div class="sidebar-header">
                <h3>Quick Navigation</h3>
                <button id="sidebarToggle" class="sidebar-toggle">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            
            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="mainmenu1.php" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="labitem1master.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Items</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="openingstockentry_master.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Opening Stock</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addward.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Wards</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountreceivableentrylist.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>Account Receivable</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="corporateoutstanding.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Corporate Outstanding</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountstatement.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Account Statement</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountsmain.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Accounts Main</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountssub.php" class="nav-link">
                            <i class="fas fa-chart-pie"></i>
                            <span>Accounts Sub Type</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="fixedasset_acquisition_report.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Fixed Asset Acquisition</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeinpatientlist.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Active Inpatient List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeusersreport.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Active Users Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartofaccounts_upload.php" class="nav-link">
                            <i class="fas fa-upload"></i>
                            <span>Chart of Accounts Upload</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartaccountsmaindataimport.php" class="nav-link">
                            <i class="fas fa-database"></i>
                            <span>Chart of Accounts Main Import</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartaccountssubdataimport.php" class="nav-link">
                            <i class="fas fa-database"></i>
                            <span>Chart of Accounts Sub Import</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addbloodgroup.php" class="nav-link">
                            <i class="fas fa-tint"></i>
                            <span>Blood Group Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addfoodallergy1.php" class="nav-link">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Food Allergy Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addgenericname.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Generic Name Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addpromotion.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>Promotion Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addsalutation1.php" class="nav-link">
                            <i class="fas fa-user-tie"></i>
                            <span>Salutation Master</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="externalradpo.php" class="nav-link">
                            <i class="fas fa-x-ray"></i>
                            <span>External Radiology PO</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php if (!empty($errmsg)): ?>
                    <div class="alert alert-<?php echo $bgcolorcode === 'success' ? 'success' : ($bgcolorcode === 'failed' ? 'error' : 'info'); ?>">
                        <i class="fas fa-<?php echo $bgcolorcode === 'success' ? 'check-circle' : ($bgcolorcode === 'failed' ? 'exclamation-triangle' : 'info-circle'); ?> alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>External Radiology Purchase Order</h2>
                    <p>Generate purchase orders for external radiology services.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            </div>

            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="search-form-header">
                    <i class="fas fa-search search-form-icon"></i>
                    <h3 class="search-form-title">Search Radiology Orders</h3>
                </div>

		

                <form name="drugs" action="externalradpo.php" method="post" onKeyDown="return disableEnterKey()" onSubmit="" class="search-form">
                    <div class="form-content">

        

        <script language="javascript">



function disableEnterKey()

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

	

	var key;

	if(window.event)

	{

		key = window.event.keyCode;     //IE

	}

	else

	{

		key = e.which;     //firefox

	}

	

	if(key == 13) // if enter key press

	{

		//alert ("Enter Key Press2");

		return false;

	}

	else

	{

		return true;

	}

	



}





</script>

        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="ADate1" class="form-label">
                                    <i class="fas fa-calendar-alt"></i> Date From
                                </label>
                                <div class="input-group">
                                    <input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>" 
                                           size="10" readonly="readonly" onKeyDown="return disableEnterKey()" 
                                           class="form-input date-input" />
                                    <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" 
                                         style="cursor:pointer" class="date-picker-icon"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ADate2" class="form-label">
                                    <i class="fas fa-calendar-alt"></i> Date To
                                </label>
                                <div class="input-group">
                                    <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>" 
                                           size="10" readonly="readonly" onKeyDown="return disableEnterKey()" 
                                           class="form-input date-input" />
                                    <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" 
                                         style="cursor:pointer" class="date-picker-icon"/>
                                </div>
                            </div>
                        </div>

					

        <tr>

          <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><input type="hidden" name="medicinecode" id="medicinecode" style="border: 1px solid #001E6A; text-align:left" onKeyDown="return disableEnterKey()" value="<?php echo $medicinecode; ?>" size="10" readonly /></td>

          <td colspan="3" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">

		  <strong><!--Item Code :--> <?php //echo $medicinecode; ?>

		  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

		  <button type="submit" class="btn btn-primary">
		      <i class="fas fa-search"></i> Search
		  </button>

		  <button name="resetbutton" type="reset" id="resetbutton" class="btn btn-secondary">
		      <i class="fas fa-undo"></i> Reset
		  </button>

		  <input type="hidden" name="frmflag1" value="frmflag1" id="frmflag1">

		  </strong></td>
		  
		  
		  <?php 

      //$default_lpo_date = date('Y-m-d', strtotime('+1 month'));
      $default_lpo_date = date('Y-m-d', strtotime("+60 days"));

      ?>    
      <td colspan="1" align="right" valign="top"   bgcolor="#ffffff" class="bodytext3">Valid Till</td>
     <td colspan="1" align="left" valign="top"   bgcolor="#ffffff"class="bodytext3"> <input name="lpodate" id="lpodate" size="10"   value="<?php echo $default_lpo_date; ?>" readonly onChange="return getValidityDays();"/>
           <img src="images2/cal.gif" onClick="javascript:NewCssCal('lpodate','yyyyMMdd','','','','','future')" style="cursor:pointer"/> <input type="text" name="validityperiod" id="validityperiod" class="bal" value="" style="width:40px;" readonly><span id="validstr">Days</span><input type="hidden" name="todaydate" id="todaydate" value="<?php echo date('Y-m-d'); ?>"> </td>
           
</tr>

        </tr>

      </tbody>

    </table>

                    </div>
                </form>
            </div>

            <!-- Results Section -->
            <div class="results-section">
                <div class="results-header">
                    <i class="fas fa-list results-icon"></i>
                    <h3 class="results-title">Search Results</h3>
                </div>

		<form name="form1" id="form1" method="post" action="externalradpo.php" onSubmit="return validcheck()">	

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="90%"

            align="left" border="0">

          <tbody>

		  <?php

		  if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

//$frmflag1 = $_REQUEST['frmflag1'];

if ($frmflag1 == 'frmflag1')

{



$externallabsupplier = $_REQUEST['searchsuppliername'];

		  ?>

		 

		  <tr>

		      <td width="56" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Select</strong></div></td>

		      <td width="23" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sno</strong></div></td>

				<td width="74" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>

              <td width="177" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Patient Name</strong></td>

              <td width="75" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Reg No</strong></td>

              <td width="77" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit No</strong></div></td>

              <td width="58" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Age</strong></div></td>

				 <td width="74" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Gender</strong></div></td>

				 <td width="74" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sample Id</strong></div></td>

				 <td width="229" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Test Name</strong></div></td>
				
				<td width="140" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Supplier Mapped</strong></div></td>

				 <td width="90" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate</strong></div></td>
				
				<td width="90" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Tax%</strong></div></td>
				
				<td width="90" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount</strong></div></td>





             </tr>

				<?php

				

$sno=0;

$sno1=0;

   $query7 = "(select auto_number as auto_number,docnumber as docnumber,patientname as patientname,patientcode as patientcode,patientvisitcode as patientvisitcode,consultationdate as recorddate,radiologyitemname as itemname,radiologyitemcode as itemcode,'' as sampleid,'' as billnumber,'consultation_radiology' as tablename from consultation_radiology where exclude = 'yes'  and externalack='0'  and  consultationdate between '$fromdate' and '$todate' and locationcode='$locationcode') 
 union all
( select auto_number as auto_number,docnumber as docnumber,patientname as patientname,patientcode as patientcode,patientvisitcode as patientvisitcode,consultationdate as recorddate,radiologyitemname as itemname,radiologyitemcode as itemcode,'' as sampleid,'' as billnumber,'ipconsultation_radiology' as tablename from ipconsultation_radiology where exclude = 'yes'  and externalack='0' and  consultationdate between '$fromdate' and '$todate' and locationcode='$locationcode') order by recorddate desc";

$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$num7 = mysqli_num_rows($exec7);

							

while($res7 = mysqli_fetch_array($exec7))

{

$res7auto_number= $res7['auto_number'];

$res7docnumber = $res7['docnumber'];

$patientname6 = $res7['patientname'];

$regno = $res7['patientcode'];

$visitno = $res7['patientvisitcode'];

$billdate6 = $res7['recorddate'];

$test = $res7['itemname'];

$itemcode = $res7['itemcode'];

$sampleid = $res7['sampleid'];

$billnumber2 = $res7['billnumber'];

$res7tablename = $res7['tablename'];

/*if($regno=='walkin')

{*/

/*$query70 = "select * from billing_external where patientcode = '$regno' and billno ='$billnumber2' ";

$exec70 = mysql_query($query70) or die(mysql_error());

$res70 = mysql_fetch_array($exec70);

$age = $res70['age'];

$gender = $res70['gender'];*/

//}

/*else

{*/

$query751 = "select * from master_customer where customercode = '$regno' ";

$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res751 = mysqli_fetch_array($exec751);

$dob = $res751['dateofbirth'];

$age = calculate_age($dob);

$gender = $res751['gender'];

//}





$query68="select * from master_lab where itemcode='$itemcode' and status <> 'deleted'";

$exec68=mysqli_query($GLOBALS["___mysqli_ston"], $query68);

$res68=mysqli_fetch_array($exec68);

$externallab = $res68['exclude'];

$rate = $res68['externalrate'];



//if($externallab == '1')
//{
$sno=$sno+1;
$sno1=$sno1+1;

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

					$colorcode = 'bgcolor="#CBDBFA"';

				}

				?>

				 <tr <?php echo $colorcode; ?>>

              <td align="left" valign="center" class="bodytext31"><input type="checkbox" name="selectbox<?=$sno;?>" id="selectbox<?php echo $sno; ?>" onClick="validcheckbox(<?php echo $sno; ?>)" value="0"></td>

              <td align="left" valign="center"  class="bodytext31"><?php echo $sno; ?></td>

				 <td align="left" valign="center"    class="bodytext31"><div align="left"><?php echo $billdate6; ?></div>
				 
				<input name="billdate<?=$sno;?>" type="hidden" id="billdate<?=$sno;?>"  value="<?php echo $billdate6; ?>"  size="8"> 
				
				<input name="auto_no<?=$sno;?>" type="hidden" id="auto_no<?=$sno;?>"  value="<?php echo $res7auto_number; ?>"  size="8">
				
				<input name="table_name<?=$sno;?>" type="hidden" id="table_name<?=$sno;?>"  value="<?php echo $res7tablename; ?>"  size="8"> 
				 
				 </td>

              <td align="left" valign="center"    class="bodytext31"><div align="left"><?php echo $patientname6; ?></div>
			  <input name="billpatietname<?=$sno;?>" type="hidden" id="billpatietname<?=$sno;?>"  value="<?php echo $patientname6; ?>"  size="8">
			  </td>

				<td align="left" valign="center"   class="bodytext31"><div align="left"><?php echo $regno; ?></div>
				 <input name="regnumber<?=$sno;?>" type="hidden" id="regnumber<?=$sno;?>"  value="<?php echo $regno; ?>"  size="8">
				</td>

              <td align="left" valign="center"   class="bodytext31"><div align="left"><?php echo $visitno; ?></div>
			   <input name="visitnumber<?=$sno;?>" type="hidden" id="visitnumber<?=$sno;?>"  value="<?php echo $visitno; ?>"  size="8">
			  </td>

             	 <td align="left" valign="center"  class="bodytext31"><div align="left"><?php echo $age; ?></div>
				 <input name="ageno<?=$sno;?>" type="hidden" id="ageno<?=$sno;?>"  value="<?php echo $age; ?>"  size="8">
				 </td>

				 <td align="left" valign="center"   class="bodytext31"><div align="left"><?php echo $gender; ?></div>
				  <input name="gender<?=$sno;?>" type="hidden" id="gender<?=$sno;?>"  value="<?php echo $gender; ?>"  size="8">
				 </td>
				 
				 <td align="left" valign="center"   class="bodytext31"><div align="left"><?php echo $res7docnumber; ?></div>
				  <input name="samplecollid<?=$sno;?>" type="hidden" id="samplecollid<?=$sno;?>"  value="<?php echo $res7docnumber; ?>"  size="8">
				 </td>

				 <td align="left" valign="center"   class="bodytext31"><div align="left"><?php echo $test; ?>
				   <input name="test<?=$sno;?>" type="hidden" id="test<?=$sno;?>"  value="<?php echo $test; ?>"  size="8">
				    <input name="testcode<?=$sno;?>" type="hidden" id="testcode<?=$sno;?>"  value="<?php echo $itemcode; ?>"  size="8">
				 </div></td>

				 <td align="left" valign="center"  class="bodytext31" size="20">
				
			 <select name="suppliername<?=$sno;?>" id="suppliername<?php echo $sno ; ?>"   style="width: 120px" onChange="return calEqAmt(this.id)">
            <option value="">Select</option>
              <?php				
              $sql= "select * from rad_supplierlink where itemcode='$itemcode' ";
			  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die ("Error in sql".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($resfetchvalue = mysqli_fetch_array($exec1))
			  {
			   $suppliercode=$resfetchvalue["suppliercode"]; 
			   $resfetchvaluerate=$resfetchvalue["rate"]; 
			   $resfetchvaluetat=$resfetchvalue["tat"]; 
			   $resfetchvaluesupplier_autoid=$resfetchvalue["supplier_autoid"]; 
			   
			  $query20 = "select accountname from master_accountname where id = '$suppliercode' ";
			  $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die('Error in Query20'.mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res20 = mysqli_fetch_array($exec20);
		      $suppliername = $res20['accountname'];
			  
			              
			  ?>
              <option value="<?php echo $suppliername; ?>||<?php echo $suppliercode; ?>||<?php echo $resfetchvaluerate; ?>||<?php echo $resfetchvaluesupplier_autoid; ?>"><?php echo $suppliername; ?>||Rate:<?php echo $resfetchvaluerate; ?>||TAT:<?php echo $resfetchvaluetat; ?></option>
              <?php } ?>
              </select>
			  </td>
				
			<td align="left" valign="center"   class="bodytext31"><div align="right"><input type="text" name="baserate<?=$sno;?>" id="baserate<?php echo $sno ; ?>" size="6" class="baserate" value="" onKeyUp="CalculateAmount(this.id)"></div></td>
				
			 <td class="bodytext31" valign="center"  align="left" ><div align="center">
                     <select name="tax_percent<?=$sno;?>" id="tax_percent<?php echo $sno ; ?>" style="width: 150px;"  onchange="CalculateAmount(this.id)">>
                          <option value="">--Select--</option>
                              <?php 
                                $query_wht = "SELECT * from master_tax";
                                $exec_wht = mysqli_query($GLOBALS["___mysqli_ston"], $query_wht) or die ("Error in query_wht".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res_wht = mysqli_fetch_array($exec_wht))
                                { ?>
                                <option value="<?=$res_wht['taxpercent'];?>"><?=ucwords($res_wht['taxname']) ;?></option>
                                <?php }?>
                      </select> </div></td>
				 <td>  <input name="amount<?=$sno;?>" type="text" id="amount<?php echo $sno ; ?>"    size="8">
				 
				  <input name="suppliercode<?=$sno;?>" type="hidden" id="suppliercode<?php echo $sno ; ?>"  value=""  size="8">
				  
				  
				  <input name="suppliername_mlpo<?=$sno;?>" type="hidden" id="suppliername_mlpo<?php echo $sno ; ?>"  value=""  size="8">
				  
				  <input name="supplier_autono<?=$sno;?>" type="hidden" id="supplier_autono<?php echo $sno ; ?>"  value=""  size="8"> 
				  
				  
				  
				  </td>

				</tr>

				<?php

				}

				?>

                

				<tr>

        <td colspan="13" align="right">

		<input type="hidden" name="frm1submit1" value="frm1submit1" />

		<input type="hidden" name = "sno_new" id="sno_new" value="<?php echo $sno1; ?>">
		
		<input name="lpodate_1" id="lpodate_1" size="10"   value="<?php echo $default_lpo_date; ?>" readonly type="hidden" >

		<input type="submit" name="submit" value="Generate PO" onClick="return externallabvalue()" ></td>

      </tr>

	  <?php

	  }

	  ?>

		  </tbody>

		  </table>

                </form>
            </div>
        </main>
    </div>


    <!-- Modern JavaScript -->
    <script src="js/externalradpo-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Additional JavaScript for existing functionality -->
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    <script type="text/javascript" src="js/disablebackenterkey.js"></script>

    <script>
        // Initialize page on load
        $(document).ready(function() {
            getValidityDays();
        });
    </script>

</body>
</html>