<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');

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
$total = '0';
$pendingamount = '0.00';
$accountname = '';
$amount=0;

if (isset($_REQUEST["slocation"])) { $slocation = $_REQUEST["slocation"]; } else { $slocation = ""; }
if (isset($_REQUEST["typemode"])) { $typemode = $_REQUEST["typemode"];  } else { $typemode = ""; }
//$getcanum = $_GET['canum'];


if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	//$cbsuppliername = $_REQUEST['cbsuppliername'];
	//$suppliername = $_REQUEST['cbsuppliername'];
	$paymentreceiveddatefrom = $_REQUEST['ADate1'];
	$paymentreceiveddateto = $_REQUEST['ADate2'];
	//$visitcode1 = 10;

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
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<script src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />      
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">      

<script language="javascript">


</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
<script language="javascript">



</script>
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/theatredelayschedulereport-modern.css?v=<?php echo time(); ?>">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Existing Scripts -->
    <script src="js/datetimepicker_css.js"></script>
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
        <a href="theatre.php">Theatre Management</a>
        <span>→</span>
        <span>Theatre Delay Schedule Report</span>
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
                        <a href="theatre.php" class="nav-link">
                            <i class="fas fa-procedures"></i>
                            <span>Theatre Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="theatreschedule.php" class="nav-link">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Theatre Schedule</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="theatredelayschedulereport.php" class="nav-link">
                            <i class="fas fa-clock"></i>
                            <span>Delay Schedule Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="theatrecancellationreport.php" class="nav-link">
                            <i class="fas fa-times-circle"></i>
                            <span>Cancellation Report</span>
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
                    <h2>Theatre Delay Schedule Report</h2>
                    <p>Comprehensive report on theatre delays and schedule changes with detailed analysis and tracking.</p>
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

            <!-- Search Form -->
            <div class="search-form-container">
                <form name="cbform1" method="post" action="theatredelayschedulereport.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>" class="form-control" readonly="readonly" onKeyDown="return disableEnterKey()" />
                        </div>
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>" class="form-control" readonly="readonly" onKeyDown="return disableEnterKey()" />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="typemode" class="form-label">Delay Reason</label>
                            <select name="typemode" id="typemode" class="form-control">
                                <option value="">ALL</option>
                                <option value="ward"<?php if($typemode=='ward') echo 'selected'; ?>>Ward</option>
                                <option value="surgeon"<?php if($typemode=='surgeon') echo 'selected'; ?>>Surgeon</option>
                                <option value="Anaesthetist"<?php if($typemode=='Anaesthetist') echo 'selected'; ?>>Anaesthetist</option>
                                <option value="Equipment"<?php if($typemode=='Equipment') echo 'selected'; ?>>Equipment</option>
                                <option value="Instruments"<?php if($typemode=='Instruments') echo 'selected'; ?>>Instruments</option>
                                <option value="Patient checked in late"<?php if($typemode=='Patient checked in late') echo 'selected'; ?>>Patient Checked in late</option>
                                <option value="Lab Investigation"<?php if($typemode=='Lab Investigation') echo 'selected'; ?>>Lab Investigation</option>
                                <option value="Blood"<?php if($typemode=='Blood') echo 'selected'; ?>>Blood</option>
                                <option value="Consent by patient"<?php if($typemode=='Consent by patient') echo 'selected'; ?>>Consent by patient</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="slocation" class="form-label">Location</label>
                            <select name="slocation" id="slocation" class="form-control">
                                <option value="">All Locations</option>
                                <?php
                                $query01="select locationcode,locationname from master_location where status ='' order by locationname";
                                $exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
                                while($res01=mysqli_fetch_array($exc01))
                                {?>
                                    <option value="<?= $res01['locationcode'] ?>" <?php if($slocation==$res01['locationcode']){ echo "selected";} ?>> <?= $res01['locationname'] ?></option>		
                                <?php 
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" name="Submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="reset" name="resetbutton" class="btn btn-outline">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Data Table Container -->
            <div class="data-table-container">
                <?php
                $ADate1 = $transactiondatefrom;
                $ADate2 = $transactiondateto;
                
                $colorloopcount = '';
                $sno = '';
                
                if($cbfrmflag1 == 'cbfrmflag1')
                { 
                ?>
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Count</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
			
			
			 <?php
			 $querycr1in = " SELECT b.late_reason as selectreason,a.auto_number,b.booking_id FROM `master_theatre_booking` as a join `theatre_panel_late reason` as b on b.booking_id=a.auto_number  WHERE date(a.surgerydatetime) BETWEEN '$ADate1' AND '$ADate2'  and b.late_reason like '%$typemode%' group by b.late_reason";	
			 $execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $rows = mysqli_num_rows($execcr1);
			 while($res = mysqli_fetch_array($execcr1))
			 {
			 $bookingid = $res['auto_number'];
			 $selectreason=$res['late_reason'];
			 $booking_id=$res['booking_id'];
			 $count=0;
			 
			  $querycr1in1 = " SELECT * FROM `master_theatre_booking`   WHERE  auto_number='$booking_id' ";	
			 $execcr11 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in1) or die ("Error in querycr1in1".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $rows1 = mysqli_num_rows($execcr11);
			 while($res1 = mysqli_fetch_array($execcr11))
			 {
			 $surgerydatetime = $res1['surgerydatetime'];
			   $now_surgerytime=strtotime($surgerydatetime);
		
			 $starttime = $res1['starttime'];
			  $now_starttime=strtotime($starttime);
		
			 
			$timedifference=abs($now_surgerytime-$now_starttime);
			 
			 
			 if($timedifference>1800){
			 $count=$count+1;
			}
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
			 
			?>
			
                        <tr>
                            <td><?php echo $selectreason; ?></td>
                            <td><?php echo $count ?></td>
                            <td>
                                <a target="_blank" href="theatredelayview_report.php?delay_reason=<?php echo $selectreason; ?>&&cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>" class="btn btn-outline btn-sm">
                                    <i class="fas fa-eye"></i> VIEW
                                </a>
                            </td>
                        </tr>
			
			 
			<?php
			  
			} 
			 ?>
                    </tbody>
                </table>
                <?php } ?>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/theatredelayschedulereport-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>

