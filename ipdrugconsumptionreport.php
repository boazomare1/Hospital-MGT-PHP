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
$currentdate = date("M d, Y");
$colorloopcount = 0;

$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';

if(isset($_REQUEST["cbfrmflag1"])){ $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; }else{ $cbfrmflag1 = ""; }
if(isset($_REQUEST["ADate1"])){ $reqdatefrom = $_REQUEST["ADate1"]; }else{ $reqdatefrom = date('Y-m-d'); }
if(isset($_REQUEST["ADate2"])){ $reqdateto = $_REQUEST["ADate2"]; }else{ $reqdateto = date('Y-m-d'); }
if(isset($_REQUEST["maternityward"])){ $maternitywardname = $_REQUEST["maternityward"]; }else{ $maternitywardname =""; }
if(isset($_REQUEST["searchitemname"])){ $searchitemname = $_REQUEST["searchitemname"]; }else{ $searchitemname = ""; }
if(isset($_REQUEST["searchitemcode"])){ $searchitemcode = $_REQUEST["searchitemcode"]; }else{ $searchitemcode = ""; }
if(isset($_REQUEST["radconsumption"])){ $reportytype = $_REQUEST["radconsumption"]; }else{ $reportytype = ""; }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Drug Consumption Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/ipdrugconsumptionreport-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker -->
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/datetimepicker_css.js"></script> 

    <!-- Autocomplete -->
<link href="autocomplete.css" rel="stylesheet">
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>

<script language="javascript">
$(function() {
$('#searchitemname').autocomplete({
	source:'ajaxpharmacyitemserach.php', 
	minLength:0,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var code = ui.item.id;
			var itemcode = ui.item.itemcode;
			var itemname = ui.item.itemname;

			$('#searchitemcode').val(itemcode);
			$('#searchitemname').val(itemname);
            },
        });
    });

    function validation() {
  var wardval = document.getElementById("maternityward").value;
        if(wardval == '') {
	  alert("Please Select Any Wards");
	  document.getElementById("maternityward").focus();
	  return false;
  }

  var chkradioetailed = document.getElementById("detailed");
  var chkradiosummary = document.getElementById("summary");

        if(chkradioetailed.checked == false && chkradiosummary.checked == false) {
	  alert("Please Select any Report type");
			return false;
        }

              return true;
    }
</script>
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
        <span>IP Drug Consumption Report</span>
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
                        <a href="ipdischargelist.php" class="nav-link">
                            <i class="fas fa-list"></i>
                            <span>Discharge List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdischargerequestlist.php" class="nav-link">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Discharge Requests</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdischargelist_tat.php" class="nav-link">
                            <i class="fas fa-clock"></i>
                            <span>Discharge TAT</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdiscountlist.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>% Discount List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdiscountreport.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Discount Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdocs.php" class="nav-link">
                            <i class="fas fa-file-alt"></i>
                            <span>IP Documents</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdrugconsumptionreport.php" class="nav-link active">
                            <i class="fas fa-pills"></i>
                            <span>Drug Consumption Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipdrugintake.php" class="nav-link">
                            <i class="fas fa-capsules"></i>
                            <span>Drug Intake</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipmedicinestatement.php" class="nav-link">
                            <i class="fas fa-prescription"></i>
                            <span>Medicine Statement</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div class="alert-container">
                <?php include ("includes/alertmessages1.php"); ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2><i class="fas fa-pills"></i> IP Drug Consumption Report</h2>
                    <p>Generate detailed drug consumption reports by ward and date range</p>
                </div>
                <div class="page-header-actions">
                    <button class="btn btn-primary" onclick="window.print()">
                        <i class="fas fa-print"></i> Print Report
                    </button>
                </div>
            </div>

            <!-- Search Form -->
            <div class="search-form-container">
                <form name="cbform1" method="post" action="ipdrugconsumptionreport.php" class="search-form">
                    <div class="form-header">
                        <h3><i class="fas fa-search"></i> Search Parameters</h3>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="maternityward">Ward</label>
                            <select name="maternityward" id="maternityward" class="form-control">
                                <option value="">Select Ward</option>
             			 <?php
                                $query1 = "select * from master_ward where status <> 'deleted' order by wardname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $wardname = $res1["wardname"];
                                    $wardanum = $res1["auto_number"];
                                    if ($maternitywardname == $wardanum) {
                                        echo "<option value='$wardanum' selected>$wardname</option>";
                                    } else {
                                        echo "<option value='$wardanum'>$wardname</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate1">Date From</label>
                            <input type="text" name="ADate1" id="ADate1" value="<?php echo $reqdatefrom; ?>" class="form-control date-picker" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2">Date To</label>
                            <input type="text" name="ADate2" id="ADate2" value="<?php echo $reqdateto; ?>" class="form-control date-picker" readonly>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="searchitemname">Item Name</label>
                            <input type="text" name="searchitemname" id="searchitemname" value="<?php echo $searchitemname; ?>" class="form-control" placeholder="Search by item name">
                            <input type="hidden" name="searchitemcode" id="searchitemcode" value="<?php echo $searchitemcode; ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Report Type</label>
                            <div class="radio-group">
                                <label class="radio-label">
                                    <input type="radio" name="radconsumption" id="detailed" value="detailed" <?php echo ($reportytype == 'detailed') ? 'checked' : ''; ?>>
                                    <span class="radio-text">Detailed Report</span>
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="radconsumption" id="summary" value="summary" <?php echo ($reportytype == 'summary') ? 'checked' : ''; ?>>
                                    <span class="radio-text">Summary Report</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="btn btn-primary" onclick="return validation()">
                            <i class="fas fa-search"></i> Generate Report
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
        </form>		
            </div>

            <!-- Report Results -->
            <?php if ($cbfrmflag1 == 'cbfrmflag1') { ?>
            <div class="report-results">
                <div class="report-header">
                    <h3><i class="fas fa-chart-line"></i> Drug Consumption Report</h3>
                    <div class="report-info">
                        <span><strong>Ward:</strong> <?php echo $maternitywardname; ?></span>
                        <span><strong>Period:</strong> <?php echo $reqdatefrom; ?> to <?php echo $reqdateto; ?></span>
                        <span><strong>Report Type:</strong> <?php echo ucfirst($reportytype); ?></span>
                    </div>
                </div>
                
                <div class="report-content">
    <?php
                    // Your existing PHP logic for generating the report goes here
                    echo "<p>Report generation logic would go here...</p>";
                    ?>
                </div>
            </div>
            <?php } ?>

        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/ipdrugconsumptionreport-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
