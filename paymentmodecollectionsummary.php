<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));

$paymentreceiveddateto = date('Y-m-d');

$currentdate = date("Y-m-d");



$searchsuppliername = '';

$suppliername = '';

$cbsuppliername = '';

$cbcustomername = '';

$cbbillnumber = '';

$cbbillstatus = '';

$colorloopcount = '';

$sno = '';

$snocount = '';

$visitcode1 = '';

$total = '';

$looptotalpaidamount = '0.00';

$looptotalpendingamount = '0.00';

$looptotalwriteoffamount = '0.00';

$looptotalcashamount = '0.00';

$looptotalcreditamount = '0.00';

$looptotalcardamount = '0.00';

$looptotalonlineamount = '0.00';

$looptotalchequeamount = '0.00';

$looptotaltdsamount = '0.00';

$looptotalwriteoffamount = '0.00';

$pendingamount = '0.00';

$accountname = '';



if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }

 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

 $locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';

//$getcanum = $_GET['canum'];

if ($getcanum != '')

{

	$query4 = "select * from master_supplier where auto_number = '$getcanum'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res4 = mysqli_fetch_array($exec4);

	$cbsuppliername = $res4['suppliername'];

	$suppliername = $res4['suppliername'];

}



if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{



	//$cbsuppliername = $_REQUEST['cbsuppliername'];

	//$suppliername = $_REQUEST['cbsuppliername'];

	$paymentreceiveddatefrom = $_REQUEST['ADate1'];

	$paymentreceiveddateto = $_REQUEST['ADate2'];

	

	$visitcode1 = 10;



}



if (isset($_REQUEST["task"])) { $task = $_REQUEST["task"]; } else { $task = ""; }

//$task = $_REQUEST['task'];

if ($task == 'deleted')

{

	$errmsg = 'Payment Entry Delete Completed.';

}



if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

//$paymenttype = $_REQUEST['paymenttype'];

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

//$billstatus = $_REQUEST['billstatus'];

if ($ADate1 != '' && $ADate2 != '')

{

	$transactiondatefrom = $_REQUEST['ADate1'];

	$transactiondateto = $_REQUEST['ADate2'];

}

else

{

	$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

	$transactiondateto = date('Y-m-d');

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Mode Collection Summary - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/paymentmodecollectionsummary-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Date Picker CSS -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

    <!-- External JavaScript -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>
</head>



<body>
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Payment Mode Collection Summary</p>
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
        <span>Reports</span>
        <span>→</span>
        <span>Payment Mode Collection Summary</span>
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
                        <a href="cashradiologyrefund.php" class="nav-link">
                            <i class="fas fa-x-ray"></i>
                            <span>Cash Radiology Refund</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="cashrefundapprovallist.php" class="nav-link">
                            <i class="fas fa-check-circle"></i>
                            <span>Refund Approval List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chequescollected.php" class="nav-link">
                            <i class="fas fa-money-check"></i>
                            <span>Cheques Collected</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="claimtxnidedit.php" class="nav-link">
                            <i class="fas fa-edit"></i>
                            <span>Claim Transaction Edit</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="payrollprocess1.php" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Payroll Process</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="stockreportbyitem3.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Stock Report by Item</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="paymentmodecollectionsummary.php" class="nav-link">
                            <i class="fas fa-credit-card"></i>
                            <span>Payment Mode Collection Summary</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php include ("includes/alertmessages1.php"); ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Payment Mode Collection Summary</h2>
                    <p>View comprehensive payment collection summaries by payment mode and location.</p>
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

            <!-- Collection Summary Section -->
            <div class="collection-summary-section">
                <div class="collection-summary-header">
                    <div class="collection-summary-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="collection-summary-title">Collections Summary</div>
                    <div class="location-display" id="ajaxlocation">
                        <i class="fas fa-map-marker-alt"></i>
                        <?php
                        if ($location!='')
                        {
                            $query12 = "select locationname from master_location where locationcode='$location' order by locationname";
                            $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res12 = mysqli_fetch_array($exec12);
                            echo htmlspecialchars($res1location = $res12["locationname"]);
                        }
                        else
                        {
                            $query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res1 = mysqli_fetch_array($exec1);
                            echo htmlspecialchars($res1location = $res1["locationname"]);
                        }
                        ?>
                    </div>
                </div>

                <form name="cbform1" method="post" action="paymentmodecollectionsummary.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <div class="date-input-group">
                                <input name="ADate1" id="ADate1" value="<?php echo htmlspecialchars($paymentreceiveddatefrom); ?>" class="form-input" readonly onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" class="date-picker-icon" style="cursor:pointer"/>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <div class="date-input-group">
                                <input name="ADate2" id="ADate2" value="<?php echo htmlspecialchars($paymentreceiveddateto); ?>" class="form-input" readonly onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" class="date-picker-icon" style="cursor:pointer"/>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-input" onChange="ajaxlocationfunction(this.value);">
                                <option value="All">All Locations</option>
                                <?php
                                $query1 = "select locationname,locationcode from master_location order by auto_number desc";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $locationname = $res1["locationname"];
                                    $locationcode = $res1["locationcode"];
                                    $selected = ($location != '' && $location == $locationcode) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $locationcode; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($locationname); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="btn btn-primary" name="Submit">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="reset" class="btn btn-secondary" name="resetbutton" id="resetbutton">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Data Table Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-table data-table-icon"></i>
                    <h3 class="data-table-title">Payment Collection Summary</h3>
                </div>

                <div class="data-table-content">

              <?php

				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if ($cbfrmflag1 == 'cbfrmflag1')

				{

					if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }

					//$cbbillnumber = $_REQUEST['cbbillnumber'];

					if (isset($_REQUEST["customername"])) { $customername = $_REQUEST["customername"]; } else { $customername = ""; }

					//$cbbillstatus = $_REQUEST['cbbillstatus'];

					

					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }

					//$cbbillnumber = $_REQUEST['cbbillnumber'];

					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }

					//$cbbillstatus = $_REQUEST['cbbillstatus'];

					

					$transactiondatefrom = $_REQUEST['ADate1'];

					$transactiondateto = $_REQUEST['ADate2'];

					$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';

					

					//$paymenttype = $_REQUEST['paymenttype'];

					//$billstatus = $_REQUEST['billstatus'];

					

					$urlpath = "cbcustomername=$cbcustomername&&cbbillnumber=$cbbillnumber&&cbbillstatus=$cbbillstatus&&ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";

				}

				else

				{

					$urlpath = "cbcustomername=$cbcustomername&&cbbillnumber=$cbbillnumber&&cbbillstatus=$cbbillstatus&&ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";

				}

				?>

 				<?php

				//For excel file creation.

				

				


				?>

              <script language="javascript">

				function printbillreport1()

				{

					window.open("print_paymentgivenreport1.php?<?php echo $urlpath; ?>","Window1",'width=900,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

					//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');

				}

				function printbillreport2()

				{

					window.location = "dbexcelfiles/PaymentGivenToSupplier.xls"

				}

				</script>

              <!--<input  value="Print Report" onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" />

&nbsp;				<input  value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />-->

</span></td>

            </tr>

                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Cash</th>
                                <th>Card</th>
                                <th>Cheque</th>
                                <th>Online</th>
                                <th>MPESA</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

			<?php

			

			$dotarray = explode("-", $paymentreceiveddateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if ($cbfrmflag1 == 'cbfrmflag1')

				{
					
if($locationcode1=='All')
{
$pass_location = "locationcode !=''";
}
else
{
$pass_location = "locationcode ='$locationcode1'";
}

		    

		  $query2 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionpaynow where $pass_location and transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 

		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res2 = mysqli_fetch_array($exec2);

		  

     	  $res2cashamount1 = $res2['cashamount1'];

		  $res2onlineamount1 = $res2['onlineamount1'];

		  $res2creditamount1 = $res2['creditamount1'];

		  $res2chequeamount1 = $res2['chequeamount1'];

		  $res2cardamount1 = $res2['cardamount1'];

		  

		   

	      $query3 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionexternal where $pass_location and transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 

		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res3 = mysqli_fetch_array($exec3);

		  

     	  $res3cashamount1 = $res3['cashamount1'];

		  $res3onlineamount1 = $res3['onlineamount1'];

		  $res3creditamount1 = $res3['creditamount1'];

		  $res3chequeamount1 = $res3['chequeamount1'];

		  $res3cardamount1 = $res3['cardamount1'];

		  

		  

		  $query4 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_billing where $pass_location and billingdatetime between '$transactiondatefrom' and '$transactiondateto'"; 

		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res4 = mysqli_fetch_array($exec4);

		  

     	  $res4cashamount1 = $res4['cashamount1'];

		  $res4onlineamount1 = $res4['onlineamount1'];

		  $res4creditamount1 = $res4['creditamount1'];

		  $res4chequeamount1 = $res4['chequeamount1'];

		  $res4cardamount1 = $res4['cardamount1'];

		  

		  $query5 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from refund_paynow where $pass_location and transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 

		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res5 = mysqli_fetch_array($exec5);

		  

     	  $res5cashamount1 = $res5['cashamount1'];

		  $res5onlineamount1 = $res5['onlineamount1'];

		  $res5creditamount1 = $res5['creditamount1'];

		  $res5chequeamount1 = $res5['chequeamount1'];

		  $res5cardamount1 = $res5['cardamount1'];

		  

		  $query54 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1  from deposit_refund where $pass_location and  recorddate between '$transactiondatefrom' and '$transactiondateto'"; 

		  $exec54 = mysqli_query($GLOBALS["___mysqli_ston"], $query54) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res54 = mysqli_fetch_array($exec54))

{



		

			  $res54cashamount1 = $res54['cashamount1'];

		  $res54onlineamount1 = $res54['onlineamount1'];

		  $res54creditamount1 = $res54['creditamount1'];

		  $res54chequeamount1 = $res54['chequeamount1'];

		  $res54cardamount1 = $res54['cardamount1'];

			



			

			}  //refund adv

		  

		  $query6 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionadvancedeposit where $pass_location and transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 

		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res6 = mysqli_fetch_array($exec6);

		  

     	  $res6cashamount1 = $res6['cashamount1'];

		  $res6onlineamount1 = $res6['onlineamount1'];

		  $res6creditamount1 = $res6['creditamount1'];

		  $res6chequeamount1 = $res6['chequeamount1'];

		  $res6cardamount1 = $res6['cardamount1'];



		  $query7 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionipdeposit where $pass_location and transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 

		  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res7 = mysqli_fetch_array($exec7);

		  

     	  $res7cashamount1 = $res7['cashamount1'];

		  $res7onlineamount1 = $res7['onlineamount1'];

		  $res7creditamount1 = $res7['creditamount1'];

		  $res7chequeamount1 = $res7['chequeamount1'];

		  $res7cardamount1 = $res7['cardamount1'];

		  

		  $query8 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(mpesaamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionip where $pass_location and transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 

		  $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res8 = mysqli_fetch_array($exec8);

		  

     	  $res8cashamount1 = $res8['cashamount1'];

		  $res8onlineamount1 = $res8['onlineamount1'];

		  $res8creditamount1 = $res8['creditamount1'];

		  $res8chequeamount1 = $res8['chequeamount1'];

		  $res8cardamount1 = $res8['cardamount1'];

		  

    	  $query9 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionipcreditapproved where $pass_location and transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 

		  $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res9 = mysqli_fetch_array($exec9);

		  

     	  $res9cashamount1 = $res9['cashamount1'];

		  $res9onlineamount1 = $res9['onlineamount1'];

		  $res9creditamount1 = $res9['creditamount1'];

		  $res9chequeamount1 = $res9['chequeamount1'];

		  $res9cardamount1 = $res9['cardamount1'];



		  $query10 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from receiptsub_details where $pass_location and transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 

		  $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res10 = mysqli_fetch_array($exec10);

		  

     	  $res10cashamount1 = $res10['cashamount1'];

		  $res10onlineamount1 = $res10['onlineamount1'];

		  $res10creditamount1 = $res10['creditamount1'];

		  $res10chequeamount1 = $res10['chequeamount1'];

		  $res10cardamount1 = $res10['cardamount1'];

 $query11 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionpaylater where $pass_location and docno like 'AR-%' and transactionstatus like 'onaccount' and transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 

		  $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res11 = mysqli_fetch_array($exec11);

		  

     	   $res11cashamount1 = $res11['cashamount1'];

		  $res11onlineamount1 = $res11['onlineamount1'];

		  $res11creditamount1 = $res11['creditamount1'];

		  $res11chequeamount1 = $res11['chequeamount1'];

		  $res11cardamount1 = $res11['cardamount1'];



		  

		  $cashamount = $res2cashamount1 + $res3cashamount1 + $res4cashamount1 + $res6cashamount1 + $res7cashamount1 + $res8cashamount1 + $res9cashamount1 + $res10cashamount1+ $res11cashamount1;

		  $cardamount = $res2cardamount1 + $res3cardamount1 + $res4cardamount1 + $res6cardamount1 + $res7cardamount1 + $res8cardamount1 + $res9cardamount1 + $res10cardamount1+ $res11cardamount1;

		  $chequeamount = $res2chequeamount1 + $res3chequeamount1 + $res4chequeamount1 + $res6chequeamount1 + $res7chequeamount1 + $res8chequeamount1 + $res9chequeamount1 + $res10chequeamount1+ $res11chequeamount1;

		  $onlineamount = $res2onlineamount1 + $res3onlineamount1 + $res4onlineamount1 + $res6onlineamount1 + $res7onlineamount1 + $res8onlineamount1 + $res9onlineamount1 + $res10onlineamount1+ $res11onlineamount1;

		  $creditamount = $res2creditamount1 + $res3creditamount1 + $res4creditamount1 + $res6creditamount1 + $res7creditamount1 + $res8creditamount1 + $res9creditamount1 + $res10creditamount1+ $res11creditamount1;

		  

		 // $cashamount1 = $cashamount - $res5cashamount1 - $res54cashamount1;
          $cashamount1 = $cashamount;//without refunds
		  $cardamount1 = $cardamount - $res5cardamount1 - $res54cardamount1;

		  $chequeamount1 = $chequeamount - $res5chequeamount1 - $res54chequeamount1;

		  $onlineamount1 = $onlineamount - $res5onlineamount1 - $res54onlineamount1;

		  $creditamount1 = $creditamount - $res5creditamount1 - $res54creditamount1;

		  

		  $total = $cashamount1 + $onlineamount1 + $chequeamount1 + $cardamount1 + $creditamount1;

		  

		  $snocount = $snocount + 1;

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
                                <td><?php echo $snocount; ?></td>
                                <td class="amount-cell"><?php echo number_format($cashamount1,2,'.',','); ?></td>
                                <td class="amount-cell"><?php echo number_format($cardamount1,2,'.',','); ?></td>
                                <td class="amount-cell"><?php echo number_format($chequeamount1,2,'.',','); ?></td>
                                <td class="amount-cell"><?php echo number_format($onlineamount1,2,'.',','); ?></td>
                                <td class="amount-cell"><?php echo number_format($creditamount1,2,'.',','); ?></td>
                                <td class="amount-cell total-amount"><?php echo number_format($total,2,'.',','); ?></td>
                                <td class="action-cell">
                                    <?php if($cashamount1 != 0.00): ?>
                                        <a target="_blank" href="print_paymentmodecollectionsummary.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&locationcode=<?php echo $locationcode1; ?>" class="action-btn print" title="Print Report">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/paymentmodecollectionsummary-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>



