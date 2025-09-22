<?php 
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";

// Initialize variables
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$docno = $_SESSION['docno']; 
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount = "";
$range = "";
$arraysuppliername = '';
$arraysuppliercode = '';	
$totalatret = 0.00;
$totalamountgreater = 0;

// Initialize arrays
$billnumbers = array();
$billnumbers1 = array();
$billnumbers11 = array();
$billnumbers2 = array();
$billnumbers3 = array();
$billnumbers4 = array();
$billnumbers5 = array();
$totalvisitcodes = '';
$totalbillnumbers = '';
		  
// Get location details
$query01 = "select locationcode from login_locationdetails where username='$username' and docno='$docno'";
$exe01 = mysqli_query($GLOBALS["___mysqli_ston"], $query01);
$res01 = mysqli_fetch_array($exe01);
$locationcode = $res01['locationcode'];

// Include autocomplete for doctor search
include ("autocompletebuild_doctor1.php");

// Handle form parameters
$searchsuppliername = isset($_REQUEST["searchsuppliername"]) ? $_REQUEST["searchsuppliername"] : "";
$searchsuppliercode = isset($_REQUEST["searchsuppliercode"]) ? $_REQUEST["searchsuppliercode"] : "";
$location = isset($_REQUEST["location"]) ? $_REQUEST["location"] : '';
$cbfrmflag2 = isset($_REQUEST["cbfrmflag2"]) ? $_REQUEST["cbfrmflag2"] : "";
$frmflag2 = isset($_REQUEST["frmflag2"]) ? $_REQUEST["frmflag2"] : "";

// Process supplier name
if ($searchsuppliername) {
    $searchsuppliername1 = explode('#', $searchsuppliername);
    $searchsuppliername = trim($searchsuppliername1[0]);
}

// Handle date parameters
$ADate1 = isset($_REQUEST["ADate1"]) ? $_REQUEST["ADate1"] : date('Y-m-d');
$ADate2 = isset($_REQUEST["ADate2"]) ? $_REQUEST["ADate2"] : date('Y-m-d');
$paymentreceiveddatefrom = $ADate1;
$paymentreceiveddateto = $ADate2;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Statement Detail Summary - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/doctor-statement-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker CSS -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- jQuery UI for autocomplete -->
    <link href="js/jquery-ui.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- Scripts -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script type="text/javascript" src="js/autocomplete_doctor.js"></script>
    <script type="text/javascript" src="js/autosuggestdoctor_stmt.js"></script>
    <script type="text/javascript">
    window.onload = function () {
        var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
    }
    function coasearch(varCallFrom) {
        var varCallFrom = varCallFrom;
        window.open("showinvoice.php?callfrom="+varCallFrom,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
    }
    
    function coasearch1(varCallFrom1) {
        var varCallFrom1 = varCallFrom1;
        window.open("showwthinvoice.php?callfrom1="+varCallFrom1,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
    }
    
    function showsub(subtypeano) {
        if(document.getElementById('hide'+subtypeano) != null) {
            if(document.getElementById('hide'+subtypeano).style.display == 'none') {
                document.getElementById('hide'+subtypeano).style.display = '';
            } else {
                document.getElementById('hide'+subtypeano).style.display = 'none';
            }
        }
    }
    </script>
    <script src="js/datetimepicker_css.js"></script>
    
    <!-- Modern JavaScript -->
    <script src="js/doctor-statement-modern.js?v=<?php echo time(); ?>"></script>
</head>

<body>
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
        <span>Doctor Statement Detail Summary</span>
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
                        <a href="fulldrstatementdetail_summary.php" class="nav-link active">
                            <i class="fas fa-file-invoice"></i>
                            <span>Doctor Statement Summary</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="doctorsactivityreport.php" class="nav-link">
                            <i class="fas fa-user-md"></i>
                            <span>Doctor Activity Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="doctorpaymententry.php" class="nav-link">
                            <i class="fas fa-credit-card"></i>
                            <span>Doctor Payment Entry</span>
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
                    <h2>Doctor Statement Detail Summary</h2>
                    <p>Comprehensive doctor-wise detailed summary statement with aging analysis and payment tracking.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                </div>
            </div>
            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="search-form-header">
                    <i class="fas fa-user-md search-form-icon"></i>
                    <h3 class="search-form-title">Doctor Statement Search</h3>
                </div>
                
                <form name="cbform1" method="post" action="" class="search-form">
                    <div class="form-group">
                        <label for="searchsuppliername" class="form-label">Search Doctor</label>
                        <input name="searchsuppliername" type="text" id="searchsuppliername" 
                               value="<?php echo htmlspecialchars($searchsuppliername); ?>" 
                               class="form-input" placeholder="Type doctor name to search..." autocomplete="off">
                    </div>
<?php
           	if(isset($_REQUEST['ADate1'])){
           			$paymentreceiveddatefrom=$_REQUEST['ADate1'];
           			$paymentreceiveddateto=$_REQUEST['ADate2'];
           	}
           ?>
		   
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <div class="date-input-group">
                                <input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>" 
                                       class="form-input date-input" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" 
                                     class="date-picker-icon" style="cursor:pointer"/>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <div class="date-input-group">
                                <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>" 
                                       class="form-input date-input" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" 
                                     class="date-picker-icon" style="cursor:pointer"/>
                            </div>
                        </div>
                    </div>	
					
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" onChange="ajaxlocationfunction(this.value);" class="form-input">
                                <option value="All">All</option>
                                <?php
                                $query1 = "select locationname,locationcode from master_location  order by auto_number desc";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $loccode=array();
                                while ($res1 = mysqli_fetch_array($exec1))
                                {
                                $locationname = $res1["locationname"];
                                $locationcode = $res1["locationcode"];
                                
                                ?>
                                 <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>
                                <?php
                                } 
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <!-- Empty space for layout balance -->
                        </div>
                    </div>
                    <div class="form-actions">
                        <input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" />
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-search"></i>
                            Search Statement
                        </button>
                        
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>
            <!-- Results Section -->
            <?php
            if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
            ?>
            
            <?php if ($cbfrmflag1 == 'cbfrmflag1'): ?>
            <div class="results-section">
                <div class="results-header">
                    <h3>Doctor Statement Results</h3>
                    <div class="results-actions">
                        <a target="_blank" href="print_doctorstatement.php?code=<?php echo $searchsuppliercode;?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&suppliername=<?php  echo $searchsuppliername;?>&&locationcode1=<?=$locationcode?>" class="btn btn-outline">
                            <i class="fas fa-file-pdf"></i> Print PDF
                        </a>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Doctor</th>
                                <th>Patient</th>
                                <th>Bill No.</th>
                                <th>Account</th>
                                <th>Bill Date</th>
                                <th>Bill Type</th>
                                <th>Alloted</th>
                                <th>Org. Bill</th>
                                <th>Percentage</th>
                                <th>Doc. Share</th>
                                <th>Bal. Amt</th>
                                <th>30 days</th>
                                <th>60 days</th>
                                <th>90 days</th>
                                <th>120 days</th>
                                <th>180 days</th>
                                <th>180+ days</th>
                            </tr>
                        </thead>
                        <tbody>
            <?php 
            if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
				$colorcode = "";
				$openingcreditamount = 0;
				$openingdebittamount = 0;
				$openingbalance=0;
				$fulltotal = 0;
				$fulltotalamount30 = 0;
				$fulltotalamount60 =0;
				$fulltotalamount90 = 0;
				$fulltotalamount120 = 0;
				$fulltotalamount180 = 0;
				$fulltotalamountgreater = 0;
				$snocount_main = 0;
				$snocount_invoice = 0;
				$total_debitamt = 0;
				$totalatorginal = 0;
				$fulltotalatorginal = 0;
				$doct_wise_amt = 0;
				$doct_wise_orgamt = 0;
				if (isset($_REQUEST["searchsuppliername"])) { $suppliername = $_REQUEST["searchsuppliername"]; } else { $suppliername = ""; }
				if (isset($_REQUEST["searchsuppliercode"])) {  $suppliercode = $_REQUEST["searchsuppliercode"]; } else { $suppliercode = ""; }
					$arraysupplier = explode("#", $suppliername);
					$suppliername = $arraysupplier[0];
					$suppliername = trim($suppliername);
					$res21accountname = $suppliername ;
					$snocount = 0;
					
					if($location=='All')
					{
					$pass_location = "and locationcode !=''";
					}
					else
					{
					$pass_location = "and locationcode ='$location'";
					}
					
					
					if($suppliername !="")
					{
					$query233 = "select auto_number, doccoa,description as doctorname from billing_ipprivatedoctor where doccoa='$suppliercode'  and amount <> '0.00' and amount > 0 and recorddate between '$ADate1' and '$ADate2'  and docno <> ''  $pass_location  group by doccoa order by recorddate,docno ";
					}
					else
					{
					$query233 = "select auto_number, doccoa,description as doctorname from billing_ipprivatedoctor where amount <> '0.00' and amount > 0 and recorddate between '$ADate1' and '$ADate2'  and docno <> '' $pass_location group by doccoa order by recorddate,docno ";
				    }
					
					$exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
			//$num233=mysql_num_rows($exec233);
			
			while($res233 = mysqli_fetch_array($exec233))	
			{
			$suppliercode = $res233['doccoa'];
			$doc_anum = $res233['auto_number'];
			$doctorname = $res233['doctorname'];
			$snocount_main = $snocount_main + 1;
			//////////// OPENING BALANCE //////////////////
			$openingbalance=0;
$orginalamount_total=0;
$totalamount30=0;
$total60=0;
$total90=0;
$total120=0;
$total180=0;
$total210=0;
$doctorperecentage=0;
$docperfinal=0;
$count_for_doc=0;
$totalamount30=0;
					$totalamount60=0;
					$totalamount90=0;
					$totalamount120=0;
					$totalamount180=0;
					$totalamountgreater=0;
$totalamount30_new=0;
$totalamount60_new=0;
$totalamount90_new=0;
$totalamount120_new=0;
$totalamount180_new=0;
$totalamountgreater_new=0;
			 $openingbalance =0;
         $totalat =0;
        
          $query234 = "SELECT mainset.* from (
		  (select recorddate as transdate,docno as documentno,billtype,visitcode,patientname,patientcode,accountname,visittype,sum(sharingamount) as sharingamount,percentage,sum(transactionamount) as transactionamount,pvtdr_percentage,sum(original_amt) as original_amt,locationcode,'' as taxamount,'' as particulars,'' as refno,'billing_ipprivatedoctor' as transtable  from billing_ipprivatedoctor where   doccoa='$suppliercode' $pass_location  and amount <> '0.00' and amount > 0 and recorddate < '$ADate1'  and docno <> '' group by docno,doccoa order by recorddate,docno) 
		  union (select transactiondate as transdate,billnumber as documentno,'' as billtype,visitcode,patientname,patientcode,accountname,'' as visittype, 0 as sharingamount,'' as percentage, transactionamount,'' as pvtdr_percentage,0 as original_amt,'' as locationcode, taxamount,particulars,'' as refno,'master_transactiondoctor' as transtable  from master_transactiondoctor where  debit_reference_no IS NULL and doctorcode='$suppliercode' and transactiondate < '$ADate1' $pass_location order by transactiondate,auto_number)
		  union (SELECT consultationdate as transdate,docno as documentno,billtype,patientvisitcode visitcode,patientname,patientcode,accountname,'' as visittype,0 as sharingamount,'' as percentage,amount as transactionamount,'' as pvtdr_percentage, 0 as original_amt,locationcode,'' as taxamount,'' as particulars,ref_no as refno,'adhoc_creditnote' as transtable from adhoc_creditnote where billingaccountcode = '$suppliercode' and consultationdate < '$ADate1' $pass_location order by consultationdate)
		  union (SELECT consultationdate as transdate,docno as documentno,billtype,patientvisitcode visitcode,patientname,patientcode,accountname,'' as visittype,0 as sharingamount,'' as percentage,amount as transactionamount,'' as pvtdr_percentage, 0 as original_amt,locationcode,'' as taxamount,'' as particulars,ref_no as refno,'adhoc_debitnote' as transtable from adhoc_debitnote where billingaccountcode = '$suppliercode' and consultationdate <'$ADate1' $pass_location order by consultationdate) 
           -- for ADP bills
           union (select transactiondate as transdate,docno as documentno,'' as billtype,'' as visitcode,'' as patientname,'' as patientcode, '' as accountname,'' as visittype, 0 as sharingamount,'' as percentage, transactionamount,'' as pvtdr_percentage,0 as original_amt,'' as locationcode, '0' as taxamount,particulars,'' as refno,'master_transactiondoctor' as transtable  from advance_payment_entry where  ledger_code='$suppliercode' and recordstatus<>'deleted' and transactiondate < '$ADate1' $pass_location order by transactiondate,auto_number)
          union (SELECT recorddate as transdate,docno as documentno,billtype, visitcode visitcode,patientname,patientcode,accountname,'visittype' as visittype,sum(sharingamount) as sharingamount,percentage as percentage,sum(transactionamount) as transactionamount,pvtdr_percentage as pvtdr_percentage, sum(original_amt) as original_amt,locationcode,'' as taxamount,'' as particulars,'' as refno,'billing_ipprivatedoctor_refund' as transtable from billing_ipprivatedoctor_refund where doccoa = '$suppliercode' and recorddate < '$ADate1'  $pass_location group by docno,doccoa order by recorddate,docno)
        ) mainset order by transdate";
      $exec234 = mysqli_query($GLOBALS["___mysqli_ston"], $query234) or die ("Error in Query234".mysqli_error($GLOBALS["___mysqli_ston"]));
      $num234=mysqli_num_rows($exec234);
      while($res234 = mysqli_fetch_array($exec234))
      {
        $res45doctorperecentage = "";
        $res45transactiondate = $res234['transdate'];
        //$n_billdate = $res234
        $billnumber = $res234['documentno'];
        $billtype = $res234['billtype'];
        $res45visitcode = $res234['visitcode'];
        $query124 = "select * from master_visitentry where visitcode = '$res45visitcode'";
        $exec124 = mysqli_query($GLOBALS["___mysqli_ston"], $query124) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
        if(mysqli_num_rows($exec124) == 0)
        {
        $query124 = "select * from master_ipvisitentry where visitcode = '$res45visitcode'";
        $exec124 = mysqli_query($GLOBALS["___mysqli_ston"], $query124) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
        }
        $res124 = mysqli_fetch_array($exec124);
        $billtype = $res124['billtype'];
        $res45patientname = $res234['patientname'];
        $res45patientcode = $res234['patientcode'];
        
        $res45accountname = $res234['accountname'];
        $res45vistype = $res234['visittype'];
        $transtable = $res234['transtable'];
        $description = "";
        $res45billamount = $res234['original_amt'];
        $orginalamount_total+=$res45billamount;
        $refno = $res234['refno'];
        $res45transactionamount = $res234['transactionamount'];
        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'billing_ipprivatedoctor_refund')
        {
              $res45transactionamount = $res234['sharingamount'];
              if($res45vistype == "OP")
              {
              $res45doctorperecentage = $res234['percentage'];
              $res45transactionamount = $res234['transactionamount'];
              }
              else
              {
              $res45doctorperecentage = $res234['pvtdr_percentage'];
              }
              
              $description = "Towards Bill ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res45accountname." )";
             
      
         }
        
         if($transtable == 'master_transactiondoctor')
        {
           $res45transactionamount = $res234['transactionamount'];
          $taxamount = $res234['taxamount'];
          $amtwithouttax = $res45transactionamount - $taxamount;
          $description =  "Payment ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res234['particulars']." )";
            $query124 = "select sum(original_amt) as original_amt,visittype,percentage,pvtdr_percentage from billing_ipprivatedoctor where doccoa='$suppliercode' and docno='$billnumber' and transactionamount >0";
            $exec124 = mysqli_query($GLOBALS["___mysqli_ston"], $query124) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res124 = mysqli_fetch_array($exec124);
            $res45billamount = $res124['original_amt'];
             $orginalamount_total+=$res45billamount;
            $res45vistype = $res124['visittype'];
             if($res45vistype == "OP")
              {
              $res45doctorperecentage = $res234['percentage'];
              $res45transactionamount = $res234['transactionamount'];
              }
              else
              {
              $res45doctorperecentage = $res234['pvtdr_percentage'];
              }
              
            
        }
         if($transtable == 'adhoc_creditnote')
        {
         $description =  "Credit Note ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res45accountname."," .$refno." )";
        
       }
        if($transtable == 'adhoc_debitnote')
        {
         $description =  "Debit Note ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res45accountname."," .$refno." )";
        
       }
        $res45locationcode = $res234['locationcode'];
        $colorloopcount = $colorloopcount + 1;
      $showcolor = ($colorloopcount & 1); 
      if ($showcolor == 0)
      {
        $colorcode = 'bgcolor="#CBDBFA"';
      }
      else
      {
      
        $colorcode = 'bgcolor="#ecf0f5"';
      }
      
       $t1 = strtotime($ADate2);
       $t2 = strtotime($res45transactiondate);
       $days_between = ceil(abs($t1 - $t2) / 86400);
       $snocount = $snocount + 1;
       $res2transactionamount =  $res45transactionamount;
        $debit_total = 0;
        if($days_between <= 30)
      {
      if($snocount == 1)
      {
        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
      $totalamount30 = $openingbalance + $res2transactionamount;
     
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount30 = $openingbalance - $res2transactionamount;
           
        }
      //$totalamount30 = $openingbalance + $res2transactionamount;
     
      }
      else
      {
        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
      $totalamount30 = $totalamount30 + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount30 = $totalamount30 - $res2transactionamount;
        }
     //$totalamount30 = $totalamount30 + $res2transactionamount;
     
      }
      }
      else if(($days_between >30) && ($days_between <=60))
      {
      if($snocount == 1)
      {
        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount60 = $openingbalance + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount60 = $openingbalance - $res2transactionamount;
        }
      //$totalamount60 = $openingbalance + $res2transactionamount;
      }
      else
      {
        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount60 = $totalamount60 + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount60 = $totalamount60 - $res2transactionamount;
        }
     // $totalamount60 = $totalamount60 + $res2transactionamount;
      }
      }
      else if(($days_between >60) && ($days_between <=90))
      {
      if($snocount == 1)
      {
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount90 = $openingbalance + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount90 = $openingbalance - $res2transactionamount;
        }
      //$totalamount90 = $openingbalance + $res2transactionamount;
      }
      else
      {
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount90 = $totalamount90 + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount90 = $totalamount90 - $res2transactionamount;
        }
     // $totalamount90 = $totalamount90 + $res2transactionamount;
      }
      }
      else if(($days_between >90) && ($days_between <=120))
      {
      if($snocount == 1)
      {
        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount120 = $openingbalance + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount120 = $openingbalance - $res2transactionamount;
        }
      //$totalamount120 = $openingbalance + $res2transactionamount;
      }
      else
      {
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount120 = $totalamount120 + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount120 = $totalamount120 - $res2transactionamount;
        }
     // $totalamount120 = $totalamount120 + $res2transactionamount;
      }
      }
      else if(($days_between >120) && ($days_between <=180))
      {
        if($snocount == 1)
      {
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount180 = $openingbalance + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount180 = $openingbalance - $res2transactionamount;
        }
      //$totalamount180 = $openingbalance + $res2transactionamount;
      }
      else
      {
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount180 = $totalamount180 + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount180 = $totalamount180 - $res2transactionamount;
        }
      //$totalamount180 = $totalamount180 + $res2transactionamount;
      }
      }
      else
      {
          if($snocount == 1)
      {
        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamountgreater = $openingbalance + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamountgreater = $openingbalance - $res2transactionamount;
        }
      //$totalamountgreater = $openingbalance + $res2transactionamount;
      }
      else
      {
      
       if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamountgreater = $totalamountgreater + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamountgreater = $totalamountgreater - $res2transactionamount;
        }
        //$totalamountgreater = $totalamountgreater + $res2transactionamount;
      }
      }
      
           if($snocount == 1)
      {
     // $totalat = $openingbalance + $res45amount;
      
      if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
      $totalat = $openingbalance + $res45transactionamount ;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
          $totalat = $openingbalance - $res45transactionamount;
        }
      
      
      }
      else
      {
     // $totalat = $totalat + $res45amount;
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
      $totalat = $totalat + $res45transactionamount ;
        }
        if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
        $totalat = $totalat - $res45transactionamount;
       }
        
      }
        
      }
        $grandtotal = $totalamount30 + $totalamount60 + $totalamount90 + $totalamount120 + $totalamount180 + $totalamountgreater ;
						$fulltotalatorginal = $fulltotalatorginal + $grandtotal;		 
						$fulltotal = $fulltotal + $grandtotal;
						$fulltotalamount30 = $fulltotalamount30 + $totalamount30;
						$fulltotalamount60 = $fulltotalamount60 + $totalamount60;
						$fulltotalamount90 = $fulltotalamount90 + $totalamount90;
						$fulltotalamount120 = $fulltotalamount120 + $totalamount120;
						$fulltotalamount180 = $fulltotalamount180 + $totalamount180;
						$fulltotalamountgreater = $fulltotalamountgreater + $totalamountgreater;
						$doct_wise_amt+=$grandtotal;
						$doct_wise_orgamt+=$grandtotal;
						$totalamount30_new+=$totalamount30;
					$totalamount60_new+=$totalamount60;
					$totalamount90_new+=$totalamount90;
					$totalamount120_new+=$totalamount120;
					$totalamount180_new+=$totalamount180;
					$totalamountgreater_new+=$totalamountgreater;
			?>
			<tr  bgcolor="#ff944d" onClick="showsub(<?=$doc_anum?>)">
            		<td colspan="5" class="bodytext31" valign="center"  align="left"><strong><?php echo strtoupper($doctorname);?></strong></td>
            		 <td colspan="3" class="bodytext31" valign="center"  align="left"><div class="bodytext31">Opening Balance : </div></td>
            		 <!-- <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
            		 <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
            		 <td class="bodytext31" valign="center"  align="left">&nbsp;</td> -->
            		 <td class="bodytext31" valign="center"  align="right"> <div align="right"><?php //echo number_format($orginalamount_total,2,'.',','); ?></div></td>
            		 <td class="bodytext31" valign="center"  align="right"> <div align="right"><?php // echo $docperfinal; ?></div></td>
            		 <td class="bodytext31" valign="center"  align="right"> <div align="right"><?php echo number_format($grandtotal,2,'.',','); ?></div></td>
            		 <td class="bodytext31" valign="center"  align="right"> <div align="right"><?php echo number_format($grandtotal,2,'.',','); ?></div></td>
            		 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalamount30,2,'.',','); ?></div></td>
            		 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalamount60,2,'.',','); ?></div></td>
            		 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalamount90,2,'.',','); ?></div></td>
            		 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalamount120,2,'.',','); ?></div></td>
            		 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalamount180,2,'.',','); ?></div></td>
            		 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalamountgreater,2,'.',','); ?></div></td>
           </tr>
           <!-- /////////////////////////////////OPENING BALANCE //////////////////////////////// -->
		<!-- <tr bgcolor="#ffffff">
            <td colspan="18"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  onClick="showsub(<?=$doc_anum?>)"><strong><?php //echo strtoupper($doctorname);?> (Date From: <?php // echo $ADate1; ?> Date To: <?php // echo $ADate2;?>)</strong></td>
            </tr> -->
             <tbody id="hide<?=$doc_anum?>" style="display:none">
           
			<?php
			// Get all invoices for the doctor
			
			// $doctor_invoice_qry = "select docno,billtype,patientname,visitcode,visittype from billing_ipprivatedoctor where doccoa='$suppliercode'  and amount <> '0.00' and amount > 0 and recorddate between '$ADate1' and '$ADate2'  and docno <> '' group by docno order by recorddate,docno";
			// $exec_invoice = mysql_query($doctor_invoice_qry) or die ("Error in Doctor Invoices Query".mysql_error());
			// while($resinvoice = mysql_fetch_array($exec_invoice))	
			if(1){
			// {
				
			// 	$snocount = 0;	
			// 	$invoiceno = $resinvoice['docno'];
			// 	$billtype = $resinvoice['billtype'];
			// 	$patientname = $resinvoice['patientname'];
			// 	$res45visitcode = $resinvoice['visitcode'];
			// 	$query11 = "SELECT billtype from master_visitentry where visitcode = '$res45visitcode'  ";
			// 	$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
			// 	$res11 = mysql_fetch_array($exec11);
			// 	$num11 =mysql_num_rows($exec11);
			// 	if($num11 ==0)
			// 	{
			// 	$query11 = "SELECT billtype from master_ipvisitentry where  visitcode = '$res45visitcode' ";
			// 	$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
			// 	$res11 = mysql_fetch_array($exec11);
			// 	$num11 =mysql_num_rows($exec11);
			// 	if($num11 ==1)
			// 	    { $billtype = $res11['billtype']; }
			// 	}else{
			// 	$billtype = $res11['billtype'];}
			// 	 // get visit type
			// 	  $visittype = $resinvoice['visittype'];
			// 	// get sub type
			// 	  $subtypename = getsubtype($res45visitcode,$visittype);
			// 		$colorloopcount = $colorloopcount + 1;
			// $showcolor = ($colorloopcount & 1); 
			// if ($showcolor == 0)
			// {
			// 	$colorcode = 'bgcolor="#CBDBFA"';
			// }
			// else
			// {
			
			// 	$colorcode = 'bgcolor="#ecf0f5"';
			// }
				// OB
					
					// $querycr1op = "SELECT SUM(`transactionamount`) as openingbalance  FROM `billing_ipprivatedoctor` WHERE doccoa='$invoiceno'  AND `recorddate` <  '$ADate1' and visittype='OP' and amount <> '0.00' and amount > 0  and docno <> ''";
					// 	$execcr1 = mysql_query($querycr1op) or die ("Error in querycr1op".mysql_error());
					// 	$rescr1 = mysql_fetch_array($execcr1);
					// 	$openingbalance = $rescr1['openingbalance']; 
					// $querycr1ip = "SELECT SUM(`sharingamount`) as openingbalance1  FROM `billing_ipprivatedoctor` WHERE doccoa='$invoiceno'  AND `recorddate` <  '$ADate1' and visittype='IP' and amount <> '0.00' and amount > 0  and docno <> ''";
					// 	$execcr12 = mysql_query($querycr1ip) or die ("Error in querycr1ip".mysql_error());
					// 	$rescr12 = mysql_fetch_array($execcr12);
					// 	$openingbalance1 = $rescr12['openingbalance1']; 
					// 	 $openingbalance =$openingbalance +$openingbalance1;
				   // $openingbalance=$openingbalance;
				  // OB
					//$query234 = "select * from billing_ipprivatedoctor where doccoa='$suppliercode' and docno ='$invoiceno' and amount <> '0.00' and amount > 0 and recorddate between '$ADate1' and '$ADate2' and docno <> '' order by recorddate,docno ";
$snocount_invoice=0;
$openingbalance=0;
			$query234 = "SELECT mainset.* from (
			(select recorddate as transdate,docno as documentno,billtype,visitcode,patientname,patientcode,accountname,visittype,sum(sharingamount) as sharingamount,percentage,sum(transactionamount) as transactionamount,pvtdr_percentage,sum(original_amt) as original_amt,locationcode,'' as taxamount,'' as particulars,'' as refno,'billing_ipprivatedoctor' as transtable  from billing_ipprivatedoctor where doccoa='$suppliercode'  and amount <> '0.00' and amount > 0 and recorddate between '$ADate1' and '$ADate2'  and docno <> '' $pass_location group by docno,doccoa order by recorddate,docno)
           union (select transactiondate as transdate,billnumber as documentno,'' as billtype,visitcode,patientname,patientcode,accountname,'' as visittype, 0 as sharingamount,'' as percentage, transactionamount,'' as pvtdr_percentage,0 as original_amt,'' as locationcode, taxamount,particulars,'' as refno,'master_transactiondoctor' as transtable  from master_transactiondoctor where  debit_reference_no IS NULL and doctorcode='$suppliercode' and transactiondate between '$ADate1' and '$ADate2' $pass_location order by transactiondate,auto_number)
		   union (SELECT consultationdate as transdate,docno as documentno,billtype,patientvisitcode visitcode,patientname,patientcode,accountname,'' as visittype,0 as sharingamount,'' as percentage,amount as transactionamount,'' as pvtdr_percentage, 0 as original_amt,locationcode,'' as taxamount,'' as particulars,ref_no as refno,'adhoc_creditnote' as transtable from adhoc_creditnote where billingaccountcode = '$suppliercode' and consultationdate between '$ADate1' and '$ADate2' $pass_location order by consultationdate) 
		   union (SELECT consultationdate as transdate,docno as documentno,billtype,patientvisitcode visitcode,patientname,patientcode,accountname,'' as visittype,0 as sharingamount,'' as percentage,amount as transactionamount,'' as pvtdr_percentage, 0 as original_amt,locationcode,'' as taxamount,'' as particulars,ref_no as refno,'adhoc_debitnote' as transtable from adhoc_debitnote where billingaccountcode = '$suppliercode' and consultationdate between '$ADate1' and '$ADate2' $pass_location  order by consultationdate) 
           -- for ADP bills
           union (select transactiondate as transdate,docno as documentno,'' as billtype,'' as visitcode,'' as patientname,'' as patientcode, '' as accountname,'' as visittype, 0 as sharingamount,'' as percentage, transactionamount,'' as pvtdr_percentage,0 as original_amt,'' as locationcode, '0' as taxamount,particulars,'' as refno,'master_transactiondoctor' as transtable  from advance_payment_entry where  ledger_code='$suppliercode' and recordstatus<>'deleted' and transactiondate between '$ADate1' and '$ADate2' $pass_location order by transactiondate,auto_number)
          union (SELECT recorddate as transdate,docno as documentno,billtype, visitcode visitcode,patientname,patientcode,accountname,visittype as visittype,sum(sharingamount) as sharingamount,percentage as percentage,sum(transactionamount) as transactionamount,pvtdr_percentage as pvtdr_percentage, sum(original_amt) as original_amt,locationcode,'' as taxamount,'' as particulars,'' as refno,'billing_ipprivatedoctor_refund' as transtable from billing_ipprivatedoctor_refund where doccoa = '$suppliercode' and recorddate between '$ADate1' and '$ADate2' $pass_location group by docno,doccoa order by recorddate,docno)
        ) mainset order by transdate";
			$exec234 = mysqli_query($GLOBALS["___mysqli_ston"], $query234) or die ("Error in Query234".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num234=mysqli_num_rows($exec234);
			
$res45billamount=0;	
			while($res234 = mysqli_fetch_array($exec234))
			{
         $res45patientname = $res234['patientname'];
        $res45patientcode = $res234['patientcode'];
        
        $res45accountname = $res234['accountname'];
        $res45vistype = $res234['visittype'];
        $transtable = $res234['transtable'];
				$invoiceno = $res234['documentno'];
				// $doccoa = $res234['doccoa'];
				$billtype = $res234['billtype'];
				$patientname = $res234['patientname'];
				$res45visitcode = $res234['visitcode'];
				////////////
					$query11 = "SELECT billtype from master_visitentry where visitcode = '$res45visitcode'  ";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
				$num11 =mysqli_num_rows($exec11);
				if($num11 ==0)
				{
				$query11 = "SELECT billtype from master_ipvisitentry where  visitcode = '$res45visitcode' ";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
				$num11 =mysqli_num_rows($exec11);
				if($num11 ==1)
				    { $billtype = $res11['billtype']; }
				}else{
				$billtype = $res11['billtype'];}
				 // get visit type
				  $visittype = $res234['visittype'];
				// get sub type
				  $subtypename = getsubtype($res45visitcode,$visittype);
				////////////
                
				$total = '0.00';
				$totalat = '0.00';
				$totalat1 = '0.00';
				$totalamount30 = 0;
			$totalamount60 = 0;
			$totalamount90 = 0;
			$totalamount120 = 0;
			$totalamount180 = 0;
      $totalamountgreater = 0;
				
				$res45transactiondate = $res234['transdate'];
				$billnumber = $res234['documentno'];
				$transtable = $res234['transtable'];
				$res45billamount = $res234['original_amt'];
				$res45vistype = $res234['visittype'];
				$res45vistype = $res234['visittype'];
				$res45transactionamount = $res234['transactionamount'];
        if($transtable == 'billing_ipprivatedoctor')
        {
              $res45transactionamount = $res234['sharingamount'];
              if($res45vistype == "OP")
              {
              $res45doctorperecentage = $res234['percentage'];
              $res45transactionamount = $res234['transactionamount'];
              }
              else
              {
              $res45doctorperecentage = $res234['pvtdr_percentage'];
              }
              
              $description = "Towards Bill ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res45accountname." )";
             
      
         }
         ///////////// CASH REFUNDS/////////////
         if($transtable == 'billing_ipprivatedoctor_refund')
        {
              $res45transactionamount = $res234['sharingamount'];
              if($res45vistype == "OP")
              {
              $res45doctorperecentage = $res234['percentage'];
              $res45transactionamount = $res234['transactionamount'];
              }
              else
              {
              $res45doctorperecentage = $res234['pvtdr_percentage'];
              }
              $description = "Towards Bill ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res45accountname." )";
         }
         ///////////// CASH REFUNDS/////////////
        
         if($transtable == 'master_transactiondoctor')
        {
           $res45transactionamount = $res234['transactionamount'];
          $taxamount = $res234['taxamount'];
          $amtwithouttax = $res45transactionamount - $taxamount;
          $description =  "Payment ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res234['particulars']." )";
            $query124 = "select sum(original_amt) as original_amt,visittype,percentage,pvtdr_percentage from billing_ipprivatedoctor where doccoa='$suppliercode' and docno='$billnumber' and transactionamount >0";
            $exec124 = mysqli_query($GLOBALS["___mysqli_ston"], $query124) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res124 = mysqli_fetch_array($exec124);
            $res45billamount = $res124['original_amt'];
            $res45vistype = $res124['visittype'];
             if($res45vistype == "OP")
              {
              $res45doctorperecentage = $res234['percentage'];
              $res45transactionamount = $res234['transactionamount'];
              }
              else
              {
              $res45doctorperecentage = $res234['pvtdr_percentage'];
              }
              
            
        }
         if($transtable == 'adhoc_creditnote')
        {
         $description =  "Credit Note ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res45accountname."," .$refno." )";
        
       }
        if($transtable == 'adhoc_debitnote')
        {
         $description =  "Debit Note ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res45accountname."," .$refno." )";
        
       }
        $res45locationcode = $res234['locationcode'];
        /////////////////
			 $t1 = strtotime($ADate2);
		  $t2 = strtotime($res45transactiondate);
		  $days_between = ceil(abs($t1 - $t2) / 86400);
	
		    $t1 = strtotime($ADate2);
       $t2 = strtotime($res45transactiondate);
       $days_between = ceil(abs($t1 - $t2) / 86400);
       $snocount = $snocount + 1;
       $res2transactionamount =  $res45transactionamount;
        $debit_total = 0;
        if($days_between <= 30)
      {
      if($snocount == 1)
      {
        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
      $totalamount30 = $openingbalance + $res2transactionamount;
     
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount30 = $openingbalance - $res2transactionamount;
           
        }
      //$totalamount30 = $openingbalance + $res2transactionamount;
     
      }
      else
      {
        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
      $totalamount30 = $totalamount30 + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount30 = $totalamount30 - $res2transactionamount;
        }
     //$totalamount30 = $totalamount30 + $res2transactionamount;
     
      }
      }
      else if(($days_between >30) && ($days_between <=60))
      {
      if($snocount == 1)
      {
        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount60 = $openingbalance + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount60 = $openingbalance - $res2transactionamount;
        }
      //$totalamount60 = $openingbalance + $res2transactionamount;
      }
      else
      {
        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount60 = $totalamount60 + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount60 = $totalamount60 - $res2transactionamount;
        }
     // $totalamount60 = $totalamount60 + $res2transactionamount;
      }
      }
      else if(($days_between >60) && ($days_between <=90))
      {
      if($snocount == 1)
      {
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount90 = $openingbalance + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount90 = $openingbalance - $res2transactionamount;
        }
      //$totalamount90 = $openingbalance + $res2transactionamount;
      }
      else
      {
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount90 = $totalamount90 + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount90 = $totalamount90 - $res2transactionamount;
        }
     // $totalamount90 = $totalamount90 + $res2transactionamount;
      }
      }
      else if(($days_between >90) && ($days_between <=120))
      {
      if($snocount == 1)
      {
        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount120 = $openingbalance + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount120 = $openingbalance - $res2transactionamount;
        }
      //$totalamount120 = $openingbalance + $res2transactionamount;
      }
      else
      {
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount120 = $totalamount120 + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount120 = $totalamount120 - $res2transactionamount;
        }
     // $totalamount120 = $totalamount120 + $res2transactionamount;
      }
      }
      else if(($days_between >120) && ($days_between <=180))
      {
        if($snocount == 1)
      {
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount180 = $openingbalance + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount180 = $openingbalance - $res2transactionamount;
        }
      //$totalamount180 = $openingbalance + $res2transactionamount;
      }
      else
      {
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamount180 = $totalamount180 + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount180 = $totalamount180 - $res2transactionamount;
        }
      //$totalamount180 = $totalamount180 + $res2transactionamount;
      }
      }
      else
      {
          if($snocount == 1)
      {
        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamountgreater = $openingbalance + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamountgreater = $openingbalance - $res2transactionamount;
        }
      //$totalamountgreater = $openingbalance + $res2transactionamount;
      }
      else
      {
      
       if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
            $totalamountgreater = $totalamountgreater + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamountgreater = $totalamountgreater - $res2transactionamount;
        }
        //$totalamountgreater = $totalamountgreater + $res2transactionamount;
      }
      }
      
           if($snocount == 1)
      {
     // $totalat = $openingbalance + $res45amount;
      
      if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
      $totalat = $openingbalance + $res45transactionamount ;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
          $totalat = $openingbalance - $res45transactionamount;
        }
      
      
      }
      else
      {
     // $totalat = $totalat + $res45amount;
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
      $totalat = $totalat + $res45transactionamount ;
        }
        if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
        $totalat = $totalat - $res45transactionamount;
       }
        
      }
$alloted_status = "No";
			  $bal_amt = $totalat - $total_debitamt;
			   if($billtype == 'PAY LATER')
			   {
			   		 $transc_amt = 0;
					$query27 = "select sum(receivableamount) as transactionamount from master_transactionpaylater where billnumber='$invoiceno' and (recordstatus='allocated' || recordstatus='')";
					$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num2 = mysqli_num_rows($exec27);
					$res27 = mysqli_fetch_array($exec27);
					$transc_amt = $res27['transactionamount'];
					if($totalat == $transc_amt)
					{
					$alloted_status = "Fully";
					}
					else if( ($transc_amt > 0 ) && ($transc_amt < $totalat ) )
					{
					$alloted_status = "Partly";
					}
					else if($transc_amt > $totalat )
					{
					$alloted_status = "Fully";
					}
					else
					{
					if($transc_amt == 0)
					{
					$alloted_status = "No";
					}
					}
					}
					if($billtype == 'PAY NOW' || strpos( $billnumber, "CF-" ) !== false)
					{
					$alloted_status = "Yes";
					}
		 	//$alloted_status = "yes";
					
					 if($totalat !=0){
					 	$colorloopcount = $colorloopcount + 1;
						$showcolor = ($colorloopcount & 1); 
						if ($showcolor == 0)
						{
							$colorcode = 'bgcolor="#CBDBFA"';
						}
						else
						{
							$colorcode = 'bgcolor="#ecf0f5"';
						}
            $totalatorginal=$totalat;
					 	$doct_wise_amt = $doct_wise_amt + $totalat;
					$doct_wise_orgamt = $doct_wise_orgamt + $totalatorginal;
			?>
			 <tr <?php  echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php  echo $snocount_invoice = $snocount_invoice+1; ?></td>
               <td class="bodytext31" valign="center"  align="left" width="15%"><?php  echo $doctorname; ?></td>
             
                <td class="bodytext31" valign="center"  align="left" width="15%">
                  <?php 
                  if($patientname==''){
                        echo "PAYMENT (".$res234['particulars']." )";
                  }else{
                   echo $patientname; 
                  }
                   ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $invoiceno; ?></div></td>
                 <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $subtypename; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"> <?php echo $res45transactiondate; ?></div></td>
                 <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"> <?php echo $billtype; ?></div></td>
                  <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"> <?php echo $alloted_status ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res45billamount,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"> <?php echo $res45doctorperecentage ?></div></td>
				<td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($totalatorginal,2,'.',','); ?></div></td>
				
                <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($totalat,2,'.',','); ?></div></td>
                 <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($totalamount30,2,'.',','); ?></div></td>
                 <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($totalamount60,2,'.',','); ?></div></td>
                 <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($totalamount90,2,'.',','); ?></div></td>
                 <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($totalamount120,2,'.',','); ?></div></td>
                 <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($totalamount180,2,'.',','); ?></div></td>
             
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($totalamountgreater,2,'.',','); ?></div></td>
			
               
           </tr>
           <?php  
           $grandtotal = $totalamount30 + $totalamount60 + $totalamount90 + $totalamount120 + $totalamount180 + $totalamountgreater ;
			
					$totalamount30_new+=$totalamount30;
					$totalamount60_new+=$totalamount60;
					$totalamount90_new+=$totalamount90;
					$totalamount120_new+=$totalamount120;
					$totalamount180_new+=$totalamount180;
					$totalamountgreater_new+=$totalamountgreater;
			$fulltotal = $fulltotal + $totalat;
			$fulltotalamount30 = $fulltotalamount30 + $totalamount30;
			$fulltotalamount60 = $fulltotalamount60 + $totalamount60;
			$fulltotalamount90 = $fulltotalamount90 + $totalamount90;
			$fulltotalamount120 = $fulltotalamount120 + $totalamount120;
			$fulltotalamount180 = $fulltotalamount180 + $totalamount180;
			$fulltotalamountgreater = $fulltotalamountgreater + $totalamountgreater;
			$fulltotalatorginal = $fulltotalatorginal + $totalatorginal;
       }?>
			
           <?php 
            $doctor_arr[] = $suppliercode;
          
          
          /* $grandtotal = $totalamount30 + $totalamount60 + $totalamount90 + $totalamount120 + $totalamount180 + $totalamountgreater ;
			
			$fulltotal = $fulltotal + $totalat;
			$fulltotalamount30 = $fulltotalamount30 + $totalamount30;
			$fulltotalamount60 = $fulltotalamount60 + $totalamount60;
			$fulltotalamount90 = $fulltotalamount90 + $totalamount90;
			$fulltotalamount120 = $fulltotalamount120 + $totalamount120;
			$fulltotalamount180 = $fulltotalamount180 + $totalamount180;
			$fulltotalamountgreater = $fulltotalamountgreater + $totalamountgreater;
			$fulltotalatorginal = $fulltotalatorginal + $totalatorginal;*/
           ?>
		   
         <?php 
			}
         	} // loop invoices
         	?>
          </tbody>
            	
            <tr bgcolor="#D3D3D3" onClick="showsub(<?=$doc_anum?>)">
            	<td colspan="6" class="bodytext31" valign="center"  align="right">&nbsp;</td>
             	<td colspan="4" class="bodytext31" valign="center"  align="right"><b>Sub Total : </b></td>
                <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><b><?php echo number_format($doct_wise_orgamt,2,'.',','); ?></b></div></td>
				<td class="bodytext31" valign="center"  align="right"> <div class="bodytext31"><b><?php echo number_format($doct_wise_amt,2,'.',','); ?></b></div></td>
                <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><b><?php echo number_format($totalamount30_new,2,'.',','); ?></b></div></td>
                <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><b><?php echo number_format($totalamount60_new,2,'.',','); ?></b></div></td>
                <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><b><?php echo number_format($totalamount90_new,2,'.',','); ?></b></div></td>
                <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><b><?php echo number_format($totalamount120_new,2,'.',','); ?></b></div></td>
                <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><b><?php echo number_format($totalamount180_new,2,'.',','); ?></b></div></td>
                <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><b><?php echo number_format($totalamountgreater_new,2,'.',','); ?></b></div></td>
                <!-- <td colspan="7" class="bodytext31" valign="center"  align="right">&nbsp;</td> -->
           </tr>
            <?php 
            $doct_wise_amt =0;$doct_wise_orgamt =0;
            		$totalamount30_new=0;
					$totalamount60_new=0;
					$totalamount90_new=0;
					$totalamount120_new=0;
					$totalamount180_new=0;
					$totalamountgreater_new=0;
        	//}
            
			
			
          } // loop doctors
         
          ?>
        <tr bgcolor="#ffffff">
              
         	<td class="bodytext31" valign="center"  align="left" colspan="6"></td>
               <td class="bodytext31" valign="center"  colspan="4"  align="left"><strong>Total</strong></td>
             
            <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($fulltotalatorginal,2,'.',','); ?></strong></div></td>
				
            <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($fulltotal,2,'.',','); ?></strong></div></td>
            <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"> <strong><?php echo number_format($fulltotalamount30,2,'.',','); ?></strong></div></td>
            <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($fulltotalamount60,2,'.',','); ?></strong></div></td>
            
            <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($fulltotalamount90,2,'.',','); ?></strong></div></td>
            
            <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($fulltotalamount120,2,'.',','); ?></strong></div></td>
            <td class="bodytext31" valign="center"  align="right"><strong><?php echo number_format($fulltotalamount180,2,'.',','); ?></strong></td>
            <td class="bodytext31" valign="center"  align="right"><div align="right"><strong><?php echo number_format($fulltotalamountgreater,2,'.',','); ?></strong></div></td>
        </tr>
        <tr>
			<?php
				$urlpath = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&searchsuppliercode=$suppliercode&&searchsuppliername=$suppliername&&location=$location";
			
			?>
			<td colspan="15"></td>
		   	 	<!-- <td colspan="2" class="bodytext31" valign="center"  align="right"><a href="fulldrstatementdetail_excel.php?<?php //echo $urlpath; ?>"><img  width="40" height="40" src="images/excel-xls-icon.png" style="cursor:pointer;"></a> -->
          		<!-- </td> -->
			</tr> 
		<?php if ($cbfrmflag1 == 'cbfrmflag1'){ ?> 
			<tr>
				 <td colspan="8" class="bodytext31" valign="center"  align="center" 
                bgcolor="#ecf0f5"><a target="_blank" href="fulldrstatementdetail_summary_xl.php?<?php echo $urlpath; ?>">DETAILED EXCEL</a></td>
                <td colspan="8" class="bodytext31" valign="center"  align="center" 
                bgcolor="#ecf0f5"><a target="_blank" href="fulldrstatement_summary_xl.php?<?php echo $urlpath; ?>">SUMMARY EXCEL</a></td>
                <!-- bgcolor="#ecf0f5"><a target="_blank" href="fulldrstatementsummary_excel.php?<?php echo $urlpath; ?>">SUMMARY EXCEL</a></td> -->
			 <td colspan="6" bgcolor="#ecf0f5"></td>
			</tr>
		<?php } ?> 
			  </table>
<?php }
function getsubtype($visitcode,$visittype='')
{
	
	$subtypeid = 0;
	$subtypename = "";
	if(trim($visittype) =="")
	{
		
		$haystack = $visitcode;
		$needle   = "IPV";
		if( strpos( $haystack, $needle ) !== false) {
		    $visittype = "IP";
		}
		else
		{
			$visittype = "OP";
		}
	}
	if($visittype == 'OP')
	{
		$queryacc = "select subtype from master_visitentry where visitcode='$visitcode'";
		$execacc = mysqli_query($GLOBALS["___mysqli_ston"], $queryacc) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$resacc = mysqli_fetch_array($execacc);
		$subtypeid = $resacc['subtype'];
		
	}
	else
	{
		$queryacc = "select subtype from master_ipvisitentry where visitcode='$visitcode'";
		$execacc = mysqli_query($GLOBALS["___mysqli_ston"], $queryacc) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$resacc = mysqli_fetch_array($execacc);
		$subtypeid = $resacc['subtype'];
	}
	if($subtypeid > 0)
		{
			$queryaccsub = "select subtype from master_subtype where auto_number='$subtypeid'";
			$execaccsub = mysqli_query($GLOBALS["___mysqli_ston"], $queryaccsub) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$resaccsub = mysqli_fetch_array($execaccsub);
			$subtypename = $resaccsub['subtype'];
		}
	return $subtypename;
}
?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>