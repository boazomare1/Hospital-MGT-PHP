<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$st = isset($_REQUEST["st"]) ? $_REQUEST["st"] : "";
$billautonumber = isset($_REQUEST["billautonumber"]) ? $_REQUEST["billautonumber"] : "";



if(!empty($_REQUEST['billnumber']) && !empty($_REQUEST['visitcode']) && !empty($_REQUEST['remarks'])){



//echo $name_rm="remark".$_REQUEST['remark_id'];

$billnumber=$_REQUEST['billnumber'];

$v_code=$_REQUEST['visitcode'];

$remark_text=$_REQUEST['remarks'];



			$query76 = "select auto_number from master_billing where refund_status='' and  billnumber = '$billnumber' and visitcode = '$v_code' limit 0,1";

			$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res76 = mysqli_fetch_array($exec76))

			{

			//$query8 = "select auto_number from billing_paylater where patientcode = '$p_code' and visitcode = '$v_code'";	

			//$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());

			//$rows8 = mysql_num_rows($exec8);

			//	if($rows8 == 0)

			//	{

					$query81 = "update master_billing set refund_status='requested',refundremarks='$remark_text',refundrequestedby='$username',updatetime=updatetime  where billnumber = '$billnumber' and visitcode = '$v_code'";	

					$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));

					

			//	}

			}

			

header('location:consultationrefundrequestlist.php');

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation Refund Request List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Modern CSS -->
    <link rel="stylesheet" href="css/consultationrefundrequestlist-modern.css?v=<?php echo time(); ?>">


    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Date Picker CSS -->
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

    
    <!-- Auto-suggest CSS -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />

    <!-- External JavaScript -->
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript" src="js/autocomplete_customer1.js"></script>
<script type="text/javascript" src="js/autosuggest3.js"></script>

<script type="text/javascript">

// Auto-suggest initialization moved to external JS





// Key handling function moved to external JS





// Print function moved to external JS





</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<!-- Additional styles moved to external CSS -->

</head>



<body>
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Consultation Refund Request Management</p>
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
        <span>Consultation Refund Request List</span>
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
                        <a href="consultationrefundrequestlist.php" class="nav-link active">
                            <i class="fas fa-undo"></i>
                            <span>Refund Request List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="consultationrefundlist.php" class="nav-link">
                            <i class="fas fa-list"></i>
                            <span>Consultation Refund List</span>
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
                    <h2>Consultation Refund Request List</h2>
                    <p>Manage and process consultation refund requests for patients.</p>
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
                    <h3 class="search-form-title">Search Consultation Refund Requests</h3>
                </div>
                
                <form name="cbform1" method="post" action="consultationrefundrequestlist.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="patient" class="form-label">Patient Name</label>
                            <input name="patient" type="text" id="patient" class="form-input" value="" autocomplete="off" placeholder="Enter patient name">
                        </div>
                        
                        <div class="form-group">
                            <label for="patientcode" class="form-label">Patient Code</label>
                            <input name="patientcode" type="text" id="patientcode" class="form-input" value="" autocomplete="off" placeholder="Enter patient code">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="visitcode" class="form-label">Visit Code</label>
                            <input name="visitcode" type="text" id="visitcode" class="form-input" value="" autocomplete="off" placeholder="Enter visit code">
                        </div>
                        
                        <div class="form-group">
                            <label for="billno" class="form-label">Bill Number</label>
                            <input name="billno" type="text" id="billno" class="form-input" value="" autocomplete="off" placeholder="Enter bill number">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <div class="date-input-group">
                                <input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>" class="form-input" readonly onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" class="date-picker-icon" style="cursor:pointer"/>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <div class="date-input-group">
                                <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>" class="form-input" readonly onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" class="date-picker-icon" style="cursor:pointer"/>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="btn btn-primary" name="Submit">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button name="resetbutton" type="reset" id="resetbutton" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Data Table Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-list data-table-icon"></i>
                    <h3 class="data-table-title">Consultation Refund Request List</h3>
                </div>

                <div class="data-table-content">
			<?php
                    $colorloopcount = 0;
                    $sno = 0;

                    if (isset($_REQUEST["cbfrmflag1"])) { 
                        $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; 
                    } else { 
                        $cbfrmflag1 = ""; 
                    }

                    if ($cbfrmflag1 == 'cbfrmflag1') {
                        $searchpatient = $_POST['patient'];
                        $searchpatientcode = $_POST['patientcode'];
                        $searchvisitcode = $_POST['visitcode'];
                        $fromdate = $_POST['ADate1'];
                        $todate = $_POST['ADate2'];
                        $searchbillno = $_POST['billno'];
                    ?>

                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Bill Date</th>
                                <th>Bill No.</th>
                                <th>Patient Code</th>
                                <th>Visit Code</th>
                                <th>Patient</th>
                                <th>Bill Amount</th>
                                <th>Remarks</th>
                                <th>Action</th>
			 </tr>
                        </thead>
                        <tbody>

			<?php
			$colorloopcount = '';
			$sno = '';

                        $query76 = "select * from master_billing where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientfullname like '%$searchpatient%' and billnumber like '%$searchbillno%' and billingdatetime between '$fromdate' and '$todate' and refund_status='' group by visitcode,billnumber order by billingdatetime desc";

			$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

                        while($res76 = mysqli_fetch_array($exec76)) {
			$patientcode = $res76['patientcode'];
                            $patientvisitcode = $res76['visitcode'];
                            $consultationdate = $res76['billingdatetime'];
                            $patientname = $res76['patientfullname'];
				$consultationfees = $res76['patientbillamount'];
				$billnumber = $res76['billnumber'];

                            if(true) {
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 

                                if ($showcolor == 0) {
				$colorcode = 'bgcolor="#CBDBFA"';
                                } else {
				$colorcode = 'bgcolor="#ecf0f5"';
			} 
			?>
			<tr <?php echo $colorcode; ?>>
                                <td><?php echo $sno = $sno + 1; ?></td>
                                <td><?php echo $consultationdate; ?></td>
                                <td>
                                    <span class="bill-number-badge"><?php echo $billnumber; ?></span>
                                </td>
                                <td>
                                    <span class="patient-code-badge"><?php echo $patientcode; ?></span>
                                </td>
                                <td>
                                    <span class="visit-code-badge"><?php echo $patientvisitcode; ?></span>
                                </td>
                                <td><?php echo htmlspecialchars($patientname); ?></td>
                                <td><?php echo number_format($consultationfees, 2); ?></td>
                                <td>
                                    <textarea id="remark<?= $sno?>" name="remark<?= $sno?>" class="remarks-textarea" placeholder="Enter refund remarks..."></textarea>
                                </td>
                                <td class="action-cell">
                                    <a href="#" onClick="return putRequest('<?= $billnumber ?>','<?= $patientvisitcode ?>','<?= $sno ?>');" class="action-btn refund" title="Process Refund Request">
                                        <i class="fas fa-undo"></i> Process
                                    </a>
                                </td>
              </tr>
			<?php
                            }
                        }
                        ?>

            

			


			    </tbody>
        </table>

		<?php
                    }





?>	

                </div>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/consultationrefundrequestlist-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>



