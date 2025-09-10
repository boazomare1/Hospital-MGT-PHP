<?php

error_reporting(0);
session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



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

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

//$frmflag2 = $_POST['frmflag2'];

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-2 year'));

$paymentreceiveddateto = date('Y-m-d');

if ($frmflag2 == 'frmflag2')

{



}
if ($cbfrmflag1 == 'cbfrmflag1')

{

$paymentreceiveddatefrom = $_REQUEST['ADate1'];

	$paymentreceiveddateto = $_REQUEST['ADate2'];

	
	if (isset($_REQUEST["categoryid"])) { $categoryid_selected = $_REQUEST["categoryid"]; } else { $categoryid_selected = ""; }
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
    <title>Fixed Asset Depreciation Detailed Report - MedStar</title>
    
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
    
    <!-- Autocomplete Scripts -->
    <?php include ("js/dropdownlistipbilling.php"); ?>

<script type="text/javascript" src="js/autosuggestipbilling.js"></script> <!-- For searching customer -->

<script type="text/javascript" src="js/autocomplete_customeripbilling.js"></script>

<script type="text/javascript" src="jquery/jquery-1.11.3.min.js"></script>

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

	$(document).ready(function() {

		$('.executelink').click(function(){
	    	return confirm("Are you sure you want to Assetize?");
		})
	});


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



<script src="js/datetimepicker_css.js"></script>



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
        <span>Fixed Asset Depreciation Detailed Report</span>
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
                <h2>Fixed Asset Depreciation Detailed Report</h2>
                <p>Comprehensive analysis of fixed asset depreciation with detailed breakdown by category and asset.</p>
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
            
            <form name="cbform1" method="post" action="fixedasset_depreciation_detailed_report.php">
                <div class="form-row">
                    <div class="form-group">
                        <label for="location">Location</label>
                        <select name="location" id="location" onChange="ajaxlocationfunction(this.value);">

                  <?php

						

						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res1 = mysqli_fetch_array($exec1))

						{

						$locationname = $res1["locationname"];

						$locationcode = $res1["locationcode"];

						?>

						<option value="<?php echo $locationcode; ?>" <?php if($location!=''){if($location == $locationcode){echo "selected";}}?>><?php echo $locationname; ?></option>

						<?php

						}

						?>

                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="categoryid">Category</label>
                        <select name="categoryid" id="categoryid">
                            <option value="">Select Category</option>
                  <?php

						

						$query1 = "select * from master_assetcategory where recordstatus='' order by category";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res1 = mysqli_fetch_array($exec1))

						{

						$categoryid = $res1["auto_number"];

						$categoryname = $res1["category"];

						?>

						<option value="<?php echo $categoryid; ?>" <?php if($categoryid_selected!=''){if($categoryid_selected == $categoryid){echo "selected";}}?>><?php echo $categoryname; ?></option>

						<?php

						}

						?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="search_month">As on Month</label>
                        <select name="search_month">
                            <option <?php if($searchmonth == '01') { ?> selected = 'selected' <?php } ?> value="01">January</option>
                            <option <?php if($searchmonth == '02') { ?> selected = 'selected' <?php } ?> value="02">February</option>
                            <option <?php if($searchmonth == '03') { ?> selected = 'selected' <?php } ?> value="03">March</option>
                            <option <?php if($searchmonth == '04') { ?> selected = 'selected' <?php } ?> value="04">April</option>
                            <option <?php if($searchmonth == '05') { ?> selected = 'selected' <?php } ?> value="05">May</option>
                            <option <?php if($searchmonth == '06') { ?> selected = 'selected' <?php } ?> value="06">June</option>
                            <option <?php if($searchmonth == '07') { ?> selected = 'selected' <?php } ?> value="07">July</option>
                            <option <?php if($searchmonth == '08') { ?> selected = 'selected' <?php } ?> value="08">August</option>
                            <option <?php if($searchmonth == '09') { ?> selected = 'selected' <?php } ?> value="09">September</option>
                            <option <?php if($searchmonth == '10'){ ?> selected = 'selected' <?php } ?> value="10">October</option>
                            <option <?php if($searchmonth == '11'){ ?> selected = 'selected' <?php } ?> value="11">November</option>
                            <option <?php if($searchmonth == '12'){ ?> selected = 'selected' <?php } ?> value="12">December</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="search_year">Year</label>
                        <select name="search_year">
                            <option value="">Select Year</option>
                            <?php 
                            if (isset($_REQUEST["search_month"])) { $searchmonth = $_REQUEST["search_month"]; } else { $searchmonth = ""; }
                            if (isset($_REQUEST["search_year"])) { $year_p = $_REQUEST["search_year"]; } else { $year_p = ""; }

                            if($searchmonth==''){
                                $year_p=date('Y');
                                $month_p=date('m');
                                $searchmonth=$month_p;
                            }

                            $year_present=date('Y');
                            $year_past=$year_p-5;
                            $year_fut=$year_present+5;
                            $years = range($year_past, strftime($year_fut, time())); 
                            
                            foreach($years as $year1) : ?>
                                <option <?php if($year_p == $year1){ ?> selected = 'selected' <?php } ?> value="<?php echo $year1; ?>"><?php echo $year1; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary" onClick="return funcvalidcheck();">
                            <i class="fas fa-search"></i> Generate Report
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Results Section -->
        <div class="data-table-section">
            <div class="table-header">
                <h3><i class="fas fa-chart-line"></i> Fixed Asset Depreciation Report</h3>
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

//$cbfrmflag1 = $_POST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{

$paymentreceiveddatefrom = $_REQUEST['ADate1'];

	$paymentreceiveddateto = $_REQUEST['ADate2'];
$searchpatient = '';		


$search_month = $_REQUEST['search_month'];
$search_year = $_REQUEST['search_year'];

$date_range_first=$search_year.'-'.$search_month.'-01';

$d = new DateTime($date_range_first); 
$date_range=$d->format( 'Y-m-t' );

?>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>FA Posting Date</th>
                            <th>FA Posting Category</th>
                            <th>FA Posting Type</th>
                            <th>Document Type</th>
                            <th>Document No.</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Depreciation Days</th>
                            <th>User ID</th>
                            <th>Posting Date</th>
                            <th>G/L Entry No.</th>
                            <th>Entry No.</th>
                        </tr>
                    </thead>
                    <tbody>

           <?php
           $grand_netbookvalue = 0;
           $grand_purchasecost = 0;
           $grand_accdepreciation = 0;

           $grandtotal_accdepr = 0;

           $grandtotal_purchasecost = 0;

           $dep_till_date = date("Y-m-d");
		 	$categoryid_cond = "";

		 	if($categoryid_selected!="")
		 	{
		 		$categoryid_cond = " and auto_number='$categoryid_selected' ";
		 	}

           $categoryqry = "select auto_number,category from master_assetcategory where recordstatus= '' $categoryid_cond  order by auto_number ";
		   $categoryexec = mysqli_query($GLOBALS["___mysqli_ston"], $categoryqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($rescategory = mysqli_fetch_array($categoryexec))
		   {
		   	$asset_category_id = $rescategory['auto_number'];		
		   	$category_name = $rescategory['category'];
		   	// get total cost for category

		   	$query66 = "select sum(rate) as totalpurchasecost from assets_register where asset_category_id = $asset_category_id and entrydate<='$date_range'";

			$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res66 = mysqli_fetch_array($exec66);
			$totalpurchasecost =  $res66['totalpurchasecost'];
		   
			 $incr = 1;
			 $total_category_purchasecost = 0;
			 $total_category_accdepr = 0;
			 $total_category_netbookvalue = 0;

			 $assetqry = "select auto_number,asset_id,itemname,totalamount,entrydate,username,salvage,asset_period,depreciation_start_date from assets_register where asset_category_id = $asset_category_id and entrydate<='$date_range'  order by auto_number ";

		   $assetexec = mysqli_query($GLOBALS["___mysqli_ston"], $assetqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		   while($resasset = mysqli_fetch_array($assetexec))
		   {
		   	
		   	$asset_id = $resasset['asset_id'];

		   	$totalamount = $resasset['totalamount'];
		   	$total_category_purchasecost = $total_category_purchasecost + $totalamount;

		   	$asset_name = $resasset['itemname'];

		   	$acquired_date = $resasset['entrydate'];

		   	$acquired_date_new = strtotime($acquired_date);

		   	 $acquired_date_new = date("d/m/Y", $acquired_date_new);

		   	$username = $resasset['username'];

		   	$salvage = $resasset['salvage'];

		   	$asset_period = $resasset['asset_period'];

		   	$depriciation_start_date = $resasset['depreciation_start_date'];

		   	//$depriciation_start_date = strtotime($depriciation_start_date);

		   	 $query77 = "select sum(depreciation) totdepamt from assets_depreciation where asset_id = '$asset_id'  and  depreciation_date<='$date_range'";

			 
			 
			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res77 = mysqli_fetch_array($exec77);

			$accdepreciation =  $res77['totdepamt'];

			$total_category_accdepr = $total_category_accdepr + $accdepreciation;
						
			$netbookvalue = $totalamount - $accdepreciation;

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

			 

          <tr <?php echo $colorcode; ?>>

          	<!--  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td> --> 
               <td colspan="2" class="bodytext31" valign="center"  align="left"><div align="left"><strong><?php echo $category_name.' - '; ?></strong></div></td> 

             <td colspan="5" class="bodytext31" valign="center"  align="left"><div align="left"><strong><?php echo $asset_name; ?></strong></div></td> 
              <td colspan="5" class="bodytext31" valign="center"  align="left"><div align="left"><strong></strong></div></td>
		   </tr>

				<?php 

				$dep_incr = 1;
				// get depreciation start date and end date

				$query88 = "SELECT max(`depreciation_date`) latest_depreciation_date FROM `assets_depreciation` where asset_id = '$asset_id'  and  depreciation_date<='$date_range'";
			 
				$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));

				$res88 = mysqli_fetch_array($exec88);

				$latest_depreciation_date =  $res88['latest_depreciation_date'];

				//$start = $month = strtotime('2018-11-01');
				//$start = $month = strtotime($acquired_date);

				$start = $month = strtotime($depriciation_start_date);

				//$end = strtotime('2019-11-30');
				$end = strtotime($latest_depreciation_date);

				while($month < $end)
				{
				     //echo date('F Y', $month), PHP_EOL;
				   

					  if($dep_incr == 1)
					  {
					  	 

					  	$posting_type = "Acquisition Cost";
					  	?>

					  	 <tr>

            	<td width="3%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><?php echo $acquired_date_new; ?></div></td>
           	  <td width="3%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"></div></td>

			
                 <td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><?php echo $posting_type; ?></div></td>
                 <td width="7%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center">Invoice</div></td>

              <td width="6%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"></div></td>

				    <td width="8%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"></div></td>

                  <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><?php echo number_format($totalamount,2); ?></div></td>

                  <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center">30</div></td>

                  <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><?php echo $username ?></div></td>
                  <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><?php echo $acquired_date_new; ?></div></td>

                	 <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"></div></td>
                 <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"></div></td>                

              </tr>


					<?php   }

				      $monthnamefull = date('F', $month);

				    
				      $month_abr = strtoupper(substr($monthnamefull, 0, 3));

				      $year = date('Y', $month);

				      $depreciation_date = date("t/m/Y",$month);
				      $posting_date = $depreciation_date;
				     
				     $month = strtotime("+1 month", $month);

				   
				    	

				    	$posting_type = "Depreciation";
				    	$document_no = "DEP ".$month_abr.' '.$year;

				    	$depreciationyearly = (($totalamount - $salvage)/ $asset_period);

						$depreciationmonth = ($depreciationyearly / 12);

				     ?>

				  <tr>
				    <td><?php echo $posting_date; ?></td>
           	  <td></td>
                 <td><?php echo $posting_type; ?></td>
                 <td></td>
              <td><?php echo $document_no; ?></td>

				    <td><?php echo $document_no; ?></td>
                  <td class="number-cell currency"><?php echo number_format($depreciationmonth,2); ?></td>
                  <td>30</td>
                  <td><?php echo $username ?></td>
                  <td><?php echo $posting_date; ?></td>
                	 <td></td>
                 <td></td>                

              </tr>
          <?php 
				    $dep_incr = $dep_incr + 1; 

				}
				
				?>

			
		  <?php
		  $incr = $incr + 1;
		}
		$total_category_netbookvalue = $total_category_purchasecost - $total_category_accdepr;

		$grandtotal_purchasecost = $grandtotal_purchasecost + $total_category_purchasecost;

		$grandtotal_accdepr =  $grandtotal_accdepr + $total_category_accdepr;
		if($total_category_netbookvalue > 0){
		?>

	

		<?php 

		   }
		  }

		  $grandtotal_netbookvalue = $grandtotal_purchasecost - $grandtotal_accdepr;
		  
           ?>
            
          


        
			<tr>

            <td colspan="4" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><a href="fixedasset_depreciation_detailed_report_xl.php?categoryid=<?php echo $categoryid_selected ?>&&date_range=<?=$date_range;?>"><img  width="40" height="40" src="images/excel-xls-icon.png" style="cursor:pointer;"></a></td>

			</tr>			

                    </tbody>
                </table>
            </form>
        </div>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/fixedasset_depreciation_detailed_report-modern.js?v=<?php echo time(); ?>"></script>

</body>

</html>

<?php 


function getCategoryAssetIds($asset_category_id)
{
	
	$assetids_arr = array();
	$qry = " select asset_id from assets_register where asset_category_id='$asset_category_id' ";
	
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

	while ($res5 = mysqli_fetch_array($exec5))

				{
					$assetids_arr[] = $res5['asset_id'];
					//echo $res5['asset_id'].'<br>';
				}
	return $assetids_arr;
}
?>

