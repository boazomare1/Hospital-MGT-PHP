<?php

error_reporting(0);
session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");


$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$location =isset( $_REQUEST['location'])?$_REQUEST['location']:'';



$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$searchsuppliername = "";

$cbsuppliername = "";



//This include updatation takes too long to load for hunge items database.





if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

//$getcanum = $_GET['canum'];

if ($getcanum != '')

{

	$query4 = "select * from master_supplier where auto_number = '$getcanum'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res4 = mysqli_fetch_array($exec4);

	$cbsuppliername = $res4['suppliername'];

	$suppliername = $res4['suppliername'];

}



if(isset($_REQUEST['searchitem'])) { $searchitem = $_REQUEST['searchitem']; } else { $searchitem = ""; }



if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

//$frmflag2 = $_POST['frmflag2'];

if (isset($_REQUEST["assignmonth"])) { $assignmonth = $_REQUEST["assignmonth"]; } else { $assignmonth = date('M-Y'); }



if (isset($_REQUEST["frmflag56"])) { $frmflag56 = $_REQUEST["frmflag56"]; } else { $frmflag56 = ""; }



if ($frmflag56 == 'frmflag56')

{

	$depreciation_prefix = "DEP-";

	$query2 = "select * from assets_depreciation order by auto_number desc limit 0, 1";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_fetch_array($exec2);
	$billnumber_new = $res2["doc_number"];
	if ($billnumber_new == '')
	{
	$billnumbercode =$depreciation_prefix.'1';
	
	}
	else
	{
	$billnumber_new = $res2["doc_number"];
	$billnumbercode = substr($billnumber_new, 4, 8);
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;
	$maxanum = $billnumbercode;


	$billnumbercode = $depreciation_prefix.$maxanum;
	
	}

	$assignmonth = $_REQUEST["assignmonth"];

	$totalcount = $_REQUEST['totalcount'];



		$depriciation_startyear = explode('-', $assignmonth);

		$start_month = strtoupper($depriciation_startyear[0]);

		switch ($start_month) {
			case 'JAN':
				$month = 1;
				break;
			case 'FEB':
			$month = 2;
				break;
				case 'MAR':
			$month = 3;
				break;
				case 'APR':
			$month = 4;
				break;
				case 'MAY':
			$month = 5;
				break;
				case 'JUN':
			$month = 6;
				break;
				case 'JUL':
			$month = 7;
				break;
				case 'AUG':
			$month = 8;
				break;
				case 'SEP':
			$month = 9;
				break;
				case 'OCT':
			$month = 10;
				break;
				case 'NOV':
			$month = 11;
				break;
				case 'DEC':
			$month = 12;
				break;
			default:
				# code...
				break;
		}
		if($month <10)
		{
			$month = "0".$month;
		}
		$start_day = '01';

		$start_year = $depriciation_startyear[1];

		$depreciation_done_date = $start_year.'-'.$month.'-'.$start_day;

		$depreciation_done_date = date("Y-m-t", strtotime($depreciation_done_date));

	for($i=1;$i<=$totalcount;$i++)

	{

		if(isset($_REQUEST['checkanum'.$i]))

		{

			$checkanum = $_REQUEST['checkanum'.$i];

			if($checkanum != '')

			{

				$assetanum = $_REQUEST['assetanum'.$i];

				$depreciation = $_REQUEST['depreciation'.$i];

				$depreciation = str_replace(',','',$depreciation);

				$assetid = $_REQUEST['assetid'.$i];

				//echo $assetanum.'->'.$depreciation;

				

				$query66 = "SELECT * FROM assets_depreciation WHERE asset_id = '$assetid' AND processmonth = '$assignmonth'";

				$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));

				$row66 = mysqli_num_rows($exec66);

				if($row66 == 0)

				{

					

					 $query34 = "select * from assets_register where auto_number = '$assetanum'";

					
					   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

					   $asset_num = mysqli_num_rows($exec34);

					  
					   $res34 = mysqli_fetch_array($exec34);

					   $itemname = $res34['itemname'];

					   $itemcode = $res34['itemcode'];

					   $totalamount = $res34['totalamount'];

					   $entrydate = $res34['entrydate'];

					   $suppliercode = $res34['suppliercode'];

					   $suppliername = $res34['suppliername'];

					   $anum = $res34['auto_number'];

					   $asset_id = $res34['asset_id'];

						$asset_category = $res34['asset_category'];

						$asset_class = $res34['asset_class'];

						$asset_department = $res34['asset_department'];

						$asset_unit = $res34['asset_unit'];

						$asset_period = $res34['asset_period'];

						$startyear = $res34['startyear'];

						$billnumber = $res34['billnumber'];

						$companyanum =  $res34['companyanum'];

						$bill_autonumber = $res34['bill_autonumber'];

						$itemanum = $res34['itemanum'];

						$itemdescription = $res34['itemdescription'];

						$unit_abbreviation = $res34['unit_abbreviation'];

						$rate = $res34['rate'];

						$quantity = $res34['quantity'];

						$subtotal = $res34['subtotal'];

						$free = $res34['free'];

						$itemtaxpercentage = $res34['itemtaxpercentage'];

						$itemtaxamount = $res34['itemtaxamount'];

						$closingstock = $res34['closingstock'];

						$coa = $res34['coa'];

						$coa = $res34['coa'];
						$discountamount = $res34['discountamount'];
						$recordstatus = $res34['recordstatus'];
						//$username = $res34['username'];
						$ipaddress = $res34['ipaddress'];
						$entrydate = $res34['entrydate'];
						$batchnumber = $res34['batchnumber'];
						$costprice = $res34['costprice'];
						$salesprice = $res34['salesprice'];
						$expirydate = $res34['expirydate'];
						$itemfreequantity = $res34['itemfreequantity'];
						$itemtotalquantity = $res34['itemtotalquantity'];
						$packageanum = $res34['packageanum'];
						$packagename = $res34['packagename'];
						$quantityperpackage = $res34['quantityperpackage'];
						$allpackagetotalquantity = $res34['allpackagetotalquantity'];
						$manufactureranum = $res34['manufactureranum'];
						$manufacturername = $res34['manufacturername'];
						$suppliername = $res34['suppliername'];
						$suppliercode = $res34['suppliercode'];
						$supplieranum = $res34['supplieranum'];
						$supplierbillnumber = $res34['supplierbillnumber'];

						$typeofpurchase = $res34['typeofpurchase'];
						$ponumber = $res34['ponumber'];
						$itemstatus = $res34['itemstatus'];
						$locationcode = $res34['locationcode'];
						$store = $res34['store'];
						$location = $res34['location'];
						$fifo_code = $res34['fifo_code'];
						$currency = $res34['currency'];
						$fxrate = $res34['fxrate'];
						$totalfxamount = $res34['totalfxamount'];
						$deliverybillno = $res34['deliverybillno'];
						$mrnno = $res34['mrnno'];
						$fxpkrate = $res34['fxpkrate'];
						$fxtotamount = $res34['fxtotamount'];
						$assetledger = $res34['assetledger'];
						$assetledgercode = $res34['assetledgercode'];
						$assetledgeranum = $res34['assetledgeranum'];
						$priceperpk = $res34['priceperpk'];
						$fxamount = $res34['fxamount'];
						
						$dep_percent = $res34['dep_percent'];
						$asset_department = $res34['asset_department'];
						$depreciationledger = $res34['depreciationledger'];
						$depreciationledgercode = $res34['depreciationledgercode'];

						$accdepreciationledger = $res34['accdepreciationledger'];
						$accdepreciationledgercode = $res34['accdepreciationledgercode'];
						$accdepreciation = $res34['accdepreciation'];

						$openingstock = $res34['openingstock'];
						$closingstock = $res34['closingstock'];
					

					$query78 = "INSERT INTO `assets_depreciation`(`bill_autonumber`,`doc_number`, `companyanum`, `billnumber`, `categoryname`, `itemanum`, `itemcode`, `itemname`, `itemdescription`,

					`unit_abbreviation`, `rate`, `quantity`, `subtotal`, `free`, `itemtaxpercentage`, `itemtaxamount`, `discountpercentage`, `discountrupees`, `openingstock`, 

					`closingstock`, `totalamount`, `coa`, `discountamount`, `recordstatus`, `username`, `ipaddress`, `entrydate`, `batchnumber`, `costprice`, `salesprice`, 

					`expirydate`, `itemfreequantity`, `itemtotalquantity`, `packageanum`, `packagename`, `quantityperpackage`, `allpackagetotalquantity`, `manufactureranum`, 

					`manufacturername`, `suppliername`, `suppliercode`, `supplieranum`, `supplierbillnumber`, `typeofpurchase`, `ponumber`, `itemstatus`, `locationcode`, `store`, 

					`location`, `fifo_code`, `currency`, `fxrate`, `totalfxamount`, `deliverybillno`, `mrnno`, `fxpkrate`, `fxtotamount`, `assetledger`, `assetledgercode`, 

					`assetledgeranum`, `priceperpk`, `fxamount`, `asset_id`, `asset_class`, `asset_category`, `dep_percent`, `asset_department`, `asset_unit`, `asset_period`, 

					`startyear`, `depreciationledger`, `depreciationledgercode`, `accdepreciationledger`, `accdepreciationledgercode`, `accdepreciation`,`depreciation`,`processmonth`,`depreciation_date`) 

					VALUES ('$bill_autonumber', '$billnumbercode', '$companyanum', '$billnumber','$asset_category','$itemanum','$itemcode','$itemname','$itemdescription','$unit_abbreviation','$rate','$quantity','$subtotal','$free','$itemtaxpercentage','$itemtaxamount','$discountpercentage','$discountrupees','$openingstock','$closingstock','$totalamount','$coa','$discountamount','$recordstatus','$username','$ipaddress','$updatedatetime','$batchnumber','$costprice','$salesprice','$expirydate','$itemfreequantity','$itemtotalquantity','$packageanum','$packagename','$quantityperpackage','$allpackagetotalquantity','$manufactureranum','$manufacturername','$suppliername','$suppliercode','$supplieranum','$supplierbillnumber','$typeofpurchase','$ponumber','$itemstatus','$locationcode','$store','$location','$fifo_code','$currency','$fxrate','$totalfxamount','$deliverybillno','$mrnno','$fxpkrate','$fxtotamount','$assetledger','$assetledgercode','$assetledgeranum','$priceperpk','$fxamount','$asset_id','$asset_class','$asset_category','$dep_percent','$asset_department','$asset_unit','$asset_period','$startyear','$depreciationledger','$depreciationledgercode','$accdepreciationledger','$accdepreciationledgercode','$accdepreciation','$depreciation','$assignmonth','$depreciation_done_date')";


					

					$exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die ("Error in Query78".mysqli_error($GLOBALS["___mysqli_ston"]));

					//$insertid = mysql_insert_id();

			

					/*$query79 = "UPDATE assets_depreciation SET depreciation = '$depreciation', processmonth = '$assignmonth', entrydate = '$updatedatetime', username = '$username', ipaddress = '$ipaddress' WHERE auto_number = '$insertid'";

					$exec79 = mysql_query($query79) or die ("Error in Query79".mysql_error());*/

					

				}	

			}

		}

	}

	

	header("location:assetdepreciationall.php?st=success");

}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

//$st = $_REQUEST['st'];

if ($st == '1')

{

	$errmsg = "Success. Payment Entry Update Completed.";

}

if ($st == '2')

{

	$errmsg = "Failed. Payment Entry Not Completed.";

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Depreciation All - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/vat-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker CSS -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- Date Picker Scripts -->
    <script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<?php include ("js/dropdownlistipbilling.php"); ?>

<script type="text/javascript" src="js/autosuggestipbilling.js"></script> <!-- For searching customer -->

<script type="text/javascript" src="js/autocomplete_customeripbilling.js"></script>

<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>

<script type="text/javascript" src="js/jquery.min-autocomplete.js"></script>

<script type="text/javascript" src="js/jquery-ui.min.js"></script>


<script>	

<?php 

if (isset($_REQUEST["ipbillnumber"])) { $ipbillnumbers = $_REQUEST["ipbillnumber"]; } else { $ipbillnumbers = ""; }

if (isset($_REQUEST["ippatientcode"])) { $ippatientcodes = $_REQUEST["ippatientcode"]; } else { $ipbillnumbers = ""; }

?>

	var ipbillnumberr;

	var ipbillnumberr = "<?php echo $ipbillnumbers; ?>";

	var ippatientcoder;

	var ippatientcoder = "<?php echo $ippatientcodes; ?>";

	//alert(refundbillnumber);

	if(ipbillnumberr != "") 

	{

		window.open("print_depositcollection_dmp4inch1.php?billnumbercode="+ipbillnumberr+"&&patientcode="+ippatientcoder+"","OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 

	}				

</script>

<script language="javascript">



function ajaxlocationfunction(val)

{ 

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

						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;

						}

					  }

					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);

					xmlhttp.send();

}

					

//ajax to get location which is selected ends here









function cbsuppliername1()

{

	document.cbform1.submit();

}



function funcOnLoadBodyFunctionCall()

{ 

	//alert ("Inside Body On Load Fucntion.");

	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php

	

	funcCustomerDropDownSearch1(); //To handle ajax dropdown list.

	funcPopupOnLoad1();

}







</script>

<script type="text/javascript">
$(document).ready(function(){

	$("#checkall").change(function() {
    if(this.checked) {
        //Do stuff
         $('input:checkbox:not(:disabled)').attr('checked','checked');

         var totalcount = $('#totalcount').val();
         console.log('#'+totalcount+'#')
         totalamount(0,totalcount);
    }
    else
    {
    	$('input:checkbox:not(:disabled)').removeAttr('checked');
    	var totalcount = $('#totalcount').val();
    	console.log('#'+totalcount+'#')
         totalamount(0,totalcount);
    }
});


	$('#submitbtn').click(function(){
		var total = $('.depreciate_checkbox:checked').length;
		if(total == 0)
		{
			alert('Please select atleast one asset to depreciate');
			return false;
		}
    return confirm("Are you sure you want to Depreciate?");
})
   
});

function totalamount(varserialnumber2,totalcount)

{

var grandtotaldepamt = 0;



var totalcount = totalcount;

for(i=1;i<=totalcount;i++)

{

	if(document.getElementById("checkanum"+i+"").checked==true)

	{

		var totaldepcreationamt =document.getElementById("depreciation"+i+"").value.replace(/[^0-9\.]+/g,"");

		


		grandtotaldepamt=grandtotaldepamt+parseFloat(totaldepcreationamt);

		

	}

}

document.getElementById("totaldepcreationamt").value = formatMoney(grandtotaldepamt);



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

function disableEnterKey(varPassed)

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

		return false;

	}

	else

	{

		return true;

	}



}





function funcPrintReceipt1()

{

	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

}



</script>



<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<style type="text/css">

<!--

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

-->

.bal

{

border-style:none;

background:none;

text-align:right;

}

.bali

{

text-align:right;

}

</style>

</head>



<script>

function funcPopupOnLoad1()

{

<?php  

if (isset($_REQUEST["savedpatientcode"])) { $savedpatientcode = $_REQUEST["savedpatientcode"]; } else { $savedpatientcode = ""; }

if (isset($_REQUEST["savedvisitcode"])) { $savedvisitcode = $_REQUEST["savedvisitcode"]; } else { $savedvisitcode = ""; }

if (isset($_REQUEST["billnumber"])) { $billnumbers = $_REQUEST["billnumber"]; } else { $billnumbera = ""; }

?>

var patientcodes = "<?php echo $_REQUEST['savedpatientcode']; ?>";

var visitcodes = "<?php echo $_REQUEST['savedvisitcode']; ?>";

var billnumbers = "<?php echo $_REQUEST['billnumber']; ?>";

//alert(billnumbers);

	if(patientcodes != "") 

	{

		window.open("print_ipfinalinvoice1.php?patientcode="+patientcodes+"&&visitcode="+visitcodes+"&&billnumber="+billnumbers,"OriginalWindowA4",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 

	}

}



</script>



<script src="js/datetimepicker1_css.js"></script>



<body onLoad="return funcOnLoadBodyFunctionCall()">
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
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
        <span>Asset Depreciation All</span>
    </nav>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Alert Container -->
        <div id="alertContainer">
            <?php include ("includes/alertmessages1.php"); ?>
        </div>

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <h2>Asset Depreciation All</h2>
                <p>Comprehensive view of all asset depreciation with detailed breakdown by category, department, and asset type.</p>
            </div>
            <div class="page-header-actions">
                <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
                <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                    <i class="fas fa-download"></i> Export
                </button>
                <button type="button" class="btn btn-outline" onclick="printReport()">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>
        </div>

        <!-- Search Form Section -->
        <div class="form-section">
            <h3><i class="fas fa-search"></i> Report Filters</h3>
            
            <form name="cbform1" method="post" action="assetdepreciationall.php">
                <div class="form-row">
                    <div class="form-group">
                        <label for="location">Location</label>
                        <select name="location" id="location" onChange="ajaxlocationfunction(this.value);">

             

            

                  <?php

						

						if ($location!='')

						{

						$query12 = "select locationname from master_location where locationcode='$location' order by locationname";

						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res12 = mysqli_fetch_array($exec12);

						

						echo $res1location = $res12["locationname"];

						//echo $location;

						}

						else

						{

						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res1 = mysqli_fetch_array($exec1);

						

						echo $res1location = $res1["locationname"];

						//$res1locationanum = $res1["locationcode"];

						}

						?>                  </td>



                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="assignmonth">Process Month</label>
                        <div class="date-input-group">
                            <input type="text" name="assignmonth" id="assignmonth" readonly="readonly" value="<?php echo $assignmonth; ?>" class="date-picker">
                            <i class="fas fa-calendar-alt date-icon" onClick="javascript:NewCssCal('assignmonth','MMMYYYY')" style="cursor:pointer"></i>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary" onClick="return funcvalidcheck();">
                            <i class="fas fa-search"></i> Generate Report
                        </button>
                    </div>
                </div>
            </form>
            
            <!-- Current Location Display -->
            <div class="current-location">
                <strong>Current Location: </strong>
                <span id="ajaxlocation">
                    <?php
                    if ($location!='')
                    {
                        $query12 = "select locationname from master_location where locationcode='$location' order by locationname";
                        $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $res12 = mysqli_fetch_array($exec12);
                        echo $res1location = $res12["locationname"];
                    }
                    else
                    {
                        $query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $res1 = mysqli_fetch_array($exec1);
                        echo $res1location = $res1["locationname"];
                    }
                    ?>
                </span>
            </div>
        </div>

        <!-- Results Section -->
        <div class="data-table-section">
            <div class="table-header">
                <h3><i class="fas fa-list"></i> Asset Depreciation Report</h3>
                <div class="search-bar">
                    <input type="text" placeholder="Search assets..." id="assetSearch">
                    <i class="fas fa-search"></i>
                </div>
            </div>

            <form name="form11" id="form11" method="post" action="">
            
            <?php
            $colorloopcount=0;
            $sno=0;
            
            if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
            
            if ($cbfrmflag1 == 'cbfrmflag1')
            {
                $searchpatient = '';		
            ?>
            
            <div class="export-section">
                <a href="assetdepreciationall_xl.php?assignmonth=<?php echo $assignmonth ?>" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Export to Excel
                </a>
            </div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th><input type="checkbox" name="checkall" id="checkall" value="1"> Select</th>
                        <th>Category</th>
                        <th>Department</th>
                        <th>Asset ID</th>
                        <th>Asset Name</th>
                        <th>Acquisition Date</th>
                        <th>Life</th>
                        <th>Yearly Dep. %</th>
                        <th>Dep. Start</th>

                        <th>Purchase Cost</th>
                        <th>Salvage</th>
                        <th>Acc. Depreciation</th>
                        <th>Net Book Value</th>
                        <th>Depreciation</th>
                    </tr>
                </thead>
                <tbody>

			  

           <?php

$startyear = strtoupper($assignmonth);
	$depriciation_startyear = explode('-', $startyear);

		$start_month = $depriciation_startyear[0];

		switch ($start_month) {
			case 'JAN':
				$month = 1;
				break;
			case 'FEB':
			$month = 2;
				break;
				case 'MAR':
			$month = 3;
				break;
				case 'APR':
			$month = 4;
				break;
				case 'MAY':
			$month = 5;
				break;
				case 'JUN':
			$month = 6;
				break;
				case 'JUL':
			$month = 7;
				break;
				case 'AUG':
			$month = 8;
				break;
				case 'SEP':
			$month = 9;
				break;
				case 'OCT':
			$month = 10;
				break;
				case 'NOV':
			$month = 11;
				break;
				case 'DEC':
			$month = 12;
				break;
			default:
				$month = 1;
				break;
		}

		$start_year = $depriciation_startyear[1];

		if($month <10)
		{
			$month = "0".$month;
		}
		$start_day = '01';


		$depreciation_start_date = $start_year.'-'.$month.'-'.$start_day;

		$end_day = '31';
		$depration_done_date = $start_year.'-'.$month.'-'.$end_day;

		 	$sno = 0;

        
           $query34 = "select * from assets_register where depreciation_start_date <='$depreciation_start_date' order by depreciation_start_date asc";

           //echo $query34;

		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $number = mysqli_num_rows($exec34);
		   while($res34 = mysqli_fetch_array($exec34))

		   {

		   //$sno = $sno + 1;

		   $itemname = $res34['itemname'];

		   $itemcode = $res34['itemcode'];

		   $totalamount = $res34['totalamount'];

		   $entrydate = $res34['entrydate'];

		   $suppliercode = $res34['suppliercode'];

		   $suppliername = $res34['suppliername'];

		   $anum = $res34['auto_number'];

		   $asset_id = $res34['asset_id'];

			$asset_category = $res34['asset_category'];

			$asset_class = $res34['asset_class'];

			$asset_department = $res34['asset_department'];

			$asset_unit = $res34['asset_unit'];

			$asset_period = $res34['asset_period'];

			$startyear = $res34['startyear'];

			$accdepreciationvalue = $res34['accdepreciation'];

			$dep_percent = $res34['dep_percent'];

			$depreciationledgercode = $res34['depreciationledgercode'];

			$salvage = $res34['salvage'];

			$depreciationyearly = (($totalamount - $salvage)/ $asset_period);

			$depvalue=$depreciationmonth = ($depreciationyearly / 12);

			//$depreciation = $totalamount * ($dep_percent / 100);

			//$accdepreciation = $depreciation * $asset_period;

			//$depreciationmonth = $depreciation / 12;

			$depreciationmonth = number_format($depreciationmonth,2);

			 $query77 = "select sum(depreciation) totdepamt from assets_depreciation where asset_id = '$asset_id' and depreciation_date<='$depration_done_date'";

			 //echo 
			 
			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res77 = mysqli_fetch_array($exec77);

			$accdepreciation =  $res77['totdepamt'];
						
			$netbookvalue = $totalamount - $accdepreciation;

			if($depvalue>$netbookvalue){
                $depreciationmonth = number_format($netbookvalue,2);
			}

			if($netbookvalue>0){

			$dep_yearly_per = (1/$asset_period) * 100;

			$disabled = 0;
			$query78 = "select auto_number from assets_depreciation where asset_id = '$asset_id' AND processmonth = '$assignmonth'";

			$exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die ("Error in Query78".mysqli_error($GLOBALS["___mysqli_ston"]));
			$number78 = mysqli_num_rows($exec78);

			if($number78 > 0)
			{
				$disabled = 1;
			}

			
			
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
			// Check if the asset is disposed
			$qry_disposed = "select auto_number from assets_disposal where asset_id ='$asset_id'";
			$execdisp = mysqli_query($GLOBALS["___mysqli_ston"], $qry_disposed) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		    $disposed_num = mysqli_num_rows($execdisp);
		   if($disposed_num == 0){

		   	 $sno = $sno + 1;
			?>

			

                    <tr class="table-row <?php echo ($showcolor == 0) ? 'table-row-even' : 'table-row-odd'; ?>">
                        <td><?php echo $sno; ?></td>
                        <td class="text-center">
                            <input type="checkbox" name="checkanum<?php echo $sno; ?>" id="checkanum<?php echo $sno; ?>" value="<?php echo $anum; ?>" <?php if($depreciationledgercode == '') { echo "readonly"; } ?> <?php if($disabled){echo "disabled";} ?> onClick="totalamount('<?php echo $sno; ?>','<?php echo $number; ?>')" class="depreciate_checkbox">
                        </td>
                        <td><?php echo htmlspecialchars($asset_class); ?></td>
                        <td><?php echo htmlspecialchars($asset_department); ?></td>

                        <td>
                            <input type="hidden" name="assetanum<?php echo $sno; ?>" id="assetanum<?php echo $sno; ?>" value="<?php echo $anum; ?>">
                            <input type="hidden" name="assetid<?php echo $sno; ?>" id="assetid<?php echo $sno; ?>" value="<?php echo $asset_id; ?>">
                            <strong><?php echo htmlspecialchars($asset_id); ?></strong>
                        </td>
                        <td><?php echo htmlspecialchars($itemname); ?></td>
                        <td><?php echo htmlspecialchars($entrydate); ?></td>
                        <td><?php echo htmlspecialchars($asset_period); ?></td>
                        <td><?php echo number_format($dep_yearly_per,2); ?>%</td>
                        <td><?php echo htmlspecialchars($startyear); ?></td>

                        <td class="text-right"><?php echo number_format($totalamount,2); ?></td>
                        <td class="text-right"><?php echo number_format($salvage,2); ?></td>

                        <td class="text-right"><?php echo number_format($accdepreciation,2); ?></td>
                        <td class="text-right"><?php echo number_format($netbookvalue,2); ?></td>
                        <td class="text-right">
                            <?php $style = "style='text-align:right;'"; if($disabled){$style = "style='text-align:right;background-color:lightgrey;'";} ?> 
                            <input type="text" name="depreciation<?php echo $sno; ?>" id="depreciation<?php echo $sno; ?>" value="<?php echo $depreciationmonth; ?>" readonly <?php echo $style; ?> class="depreciation-input">
                            <input type="hidden" name="accdepreciationvalue<?php echo $sno; ?>" id="accdepreciationvalue<?php echo $sno; ?>" value="<?php echo $accdepreciation; ?>">
                        </td>
                    </tr>

		  <?php
		   }
		  	}
		  }

           ?>
                </tbody>
                <tfoot>
                    <tr class="table-total">
                        <td colspan="13">&nbsp;</td>
                        <td><strong>Total:</strong></td>
                        <td class="text-right">
                            <input type="text" class="bal form-control" name="totaldepcreationamt" id="totaldepcreationamt" value="0.00" readonly>
                        </td>
                    </tr>
                </tfoot>
            </table>
            
            <input type="hidden" name="totalcount" id="totalcount" value="<?php echo $sno; ?>">
            
            <div class="form-actions">&nbsp;

                <input type="hidden" name="assignmonth" id="assignmonth" value="<?php echo $assignmonth; ?>">
                <input type="hidden" name="frmflag56" value="frmflag56">
                <button type="submit" name="submit56" id="submitbtn" class="btn btn-primary">
                    <i class="fas fa-save"></i> Submit Depreciation
                </button>
            </div>
            
            <?php
            }
            ?>
            
            </form>
        </div>
    </div>

    
    <!-- Modern JavaScript -->
    <script src="js/assetdepreciationall-modern.js?v=<?php echo time(); ?>"></script>
</body>

</html>



