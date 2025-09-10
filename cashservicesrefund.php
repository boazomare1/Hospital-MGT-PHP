<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
$consultationdate = '';	
if(isset($_POST['ADate1'])){$fromdate = $_POST['ADate1'];}else{$fromdate=$transactiondatefrom;}
if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate=$transactiondateto;}
$var112=0;
$docno = $_SESSION['docno'];
$sno = 0;

 //get location for sort by location purpose
   $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		  $locationcode=$location;
		}
		//location get end here
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash Services Refund - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/cashservicesrefund-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
        <span>Cash Services Refund</span>
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
                        <a href="cashrefundsreport.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Cash Refunds Report</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="cashservicesrefund.php" class="nav-link">
                            <i class="fas fa-cogs"></i>
                            <span>Cash Services Refund</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

         <!-- Main Content -->
         <main class="main-content">
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Cash Services Refund</h2>
                    <p>Process and manage cash refunds for various services provided to patients.</p>
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
                    <h3 class="search-form-title">Search Services Refund</h3>
                </div>
                
                <form id="searchForm" name="cbform1" method="post" action="cashservicesrefund.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-input" onchange="ajaxlocationfunction(this.value)">
                                <?php
                                $query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res = mysqli_fetch_array($exec)) {
                                    $reslocation = $res["locationname"];
                                    $reslocationanum = $res["locationcode"];
                                    $selected = ($location != '' && $location == $reslocationanum) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $reslocationanum; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($reslocation); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>" 
                                   class="form-input date-input" readonly="readonly">
                        </div>

                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>" 
                                   class="form-input date-input" readonly="readonly">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="patientname" class="form-label">Patient Name</label>
                            <input name="patientname" type="text" id="patientname" class="form-input" 
                                   placeholder="Enter patient name" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="patientcode" class="form-label">Patient Code</label>
                            <input name="patientcode" type="text" id="patientcode" class="form-input" 
                                   placeholder="Enter patient code" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="visitcode" class="form-label">Visit Code</label>
                            <input name="visitcode" type="text" id="visitcode" class="form-input" 
                                   placeholder="Enter visit code" autocomplete="off">
                        </div>
                    </div>

                     <div class="form-actions">
                         <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                         <button type="submit" class="btn btn-primary">
                             <i class="fas fa-search"></i> Search
                         </button>
                         <button type="button" class="btn btn-secondary" onclick="resetForm()">
                             <i class="fas fa-undo"></i> Reset
                         </button>
                     </div>
                 </form>
            </div>

            <!-- Results Table Section -->
            <div class="results-table-section">
                <div class="results-table-header">
                    <i class="fas fa-list results-table-icon"></i>
                    <h3 class="results-table-title">Services Refund List</h3>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Patient</th>
                            <th>Service</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                         <?php
                         $matchfailed = isset($_REQUEST['st']) ? $_REQUEST['st'] : '';
                         if ($matchfailed == "matchfailed") {
                         ?>
                         <tr>
                             <td colspan="7" class="alert alert-error">
                                 <i class="fas fa-exclamation-triangle"></i> Failed to update.
                             </td>
                         </tr>
                         <?php
                         }
                         
                         // Display search results if form was submitted
                         if (isset($_REQUEST["cbfrmflag1"])) { 
                             $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; 
                         } else { 
                             $cbfrmflag1 = ""; 
                         }
                         
                         if ($cbfrmflag1 == 'cbfrmflag1') {
                             $searchpatient = $_POST['patientname'];
                             $searchpatientcode = $_POST['patientcode'];
                             $searchvisitcode = $_POST['visitcode'];
                             $fromdate = $_POST['ADate1'];
                             $todate = $_POST['ADate2'];
                             
                             $colorloopcount = '';
                             $sno = '0';
                             
                             // Services with items linked
                             $servicescode_linked_arr = array();
                             $services_linked_condition = "";
                             $services_linked_condition1 = "";
                             
                             $query1 = "select servicecode from master_serviceslinking where recordstatus <> 'deleted' group by servicecode";
                             $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                             while ($res1 = mysqli_fetch_array($exec1)) {
                                 $servcode = trim($res1['servicecode']);
                                 if($servcode != "") {
                                     $servicescode_linked_arr[] = $servcode;
                                 }
                             }
                             
                             if(count($servicescode_linked_arr) > 0) {
                                 $servceid_linked_str = implode(",",$servicescode_linked_arr);
                                 $servceid_linked_str = "'" . implode ( "', '", $servicescode_linked_arr ) . "'";
                                 
                                 if($servceid_linked_str != "") {
                                     $services_linked_condition = " and servicesitemcode IN(".$servceid_linked_str.") ";
                                     $services_linked_condition1 = " and servicesitemcode not IN(".$servceid_linked_str.") ";
                                 }	
                             }
                             
                             // Query for services with items linked
                             $query1 = "SELECT * from consultation_services where locationcode = '".$locationcode."' and patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and (paymentstatus='completed' OR paymentstatus='paid') and billtype='PAY NOW' and process <> 'pending' and (servicerefund <> 'completed' or servicerefund <> 'refund') and (serviceqty-refundquantity) > 0 and wellnessitem <> '1' and consultationdate between '$fromdate' and '$todate' $services_linked_condition order by consultationdate desc";
                             
                             $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                             while ($res1 = mysqli_fetch_array($exec1)) {
                                 $res1patientcode = $res1['patientcode'];
                                 $res1visitcode = $res1['patientvisitcode'];
                                 $res1patientfullname = $res1['patientname'];
                                 $res1account = $res1['accountname'];
                                 $res1consultationdate = $res1['consultationdate'];
                                 $billnumber = $res1['billnumber'];
                                 $service_item_code = $res1['servicesitemcode'];
                                 $servicename = $res1["servicesitemname"];
                                 $refnumber = $res1['refno'];
                                 $refno = $res1['auto_number'];
                                 $sno = $sno + 1;
                                 
                                 $query11 = "select * from master_customer where customercode = '$res1patientcode' and status = '' ";
                                 $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
                                 $res11 = mysqli_fetch_array($exec11);
                                 $res11age = $res11['age'];
                                 $res11gender = $res11['gender'];
                                 
                                 $query111 = "select * from master_visitentry where patientcode = '$res1patientcode' ";
                                 $exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
                                 $res111 = mysqli_fetch_array($exec111);
                                 $res111consultingdoctor = $res111['consultingdoctor'];
                                 $res1111department = $res111['departmentname'];
                                 
                                 // Check if patient is external
                                 if($res1patientcode == 'walkin') {
                                     $query11 = "select * from billing_external where billno='$billnumber'";
                                     $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                     $res11 = mysqli_fetch_array($exec11);
                                     $res11age = $res11['age'];
                                     $res11gender = $res11['gender'];
                                     $res1111department = 'External';
                                     $res1visitcode = $res1['billnumber'];
                                 }
                                 
                                 $colorloopcount = $colorloopcount + 1;
                                 $showcolor = ($colorloopcount & 1); 
                                 $rowclass = ($showcolor == 0) ? 'even-row' : 'odd-row';
                         ?>
                         <tr class="<?php echo $rowclass; ?>">
                             <td class="modern-cell"><?php echo $sno; ?></td>
                             <td class="modern-cell"><?php echo $res1consultationdate; ?></td>
                             <td class="modern-cell">
                                 <div class="patient-info">
                                     <strong><?php echo htmlspecialchars($res1patientfullname); ?></strong><br>
                                     <small>Code: <?php echo htmlspecialchars($res1patientcode); ?></small>
                                 </div>
                             </td>
                             <td class="modern-cell"><?php echo htmlspecialchars($servicename); ?></td>
                             <td class="modern-cell"><?php echo htmlspecialchars($res1111department); ?></td>
                             <td class="modern-cell"><?php echo htmlspecialchars($res1account); ?></td>
                             <td class="modern-cell">
                                 <?php if($res1patientcode != 'walkin') { ?>
                                     <a href="cashservicesrefund_view.php?patientcode=<?php echo $res1patientcode; ?>&visitcode=<?php echo $res1visitcode; ?>&refnumber=<?php echo $refno; ?>&servicesitemcode=<?php echo $service_item_code; ?>" class="btn btn-primary btn-sm">
                                         <i class="fas fa-undo"></i> Refund
                                     </a>
                                 <?php } else { ?>
                                     <span class="btn btn-secondary btn-sm">
                                         <i class="fas fa-cog"></i> PROCESS
                                     </span>
                                 <?php } ?>
                             </td>
                         </tr>
                         <?php
                             }
                             
                             // Query for services without items linked
                             $query1 = "SELECT * from consultation_services where locationcode = '".$locationcode."' and patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and (paymentstatus='completed' OR paymentstatus='paid') and billtype='PAY NOW' and process = 'pending' and (servicerefund <> 'completed' or servicerefund <> 'refund') and (serviceqty-refundquantity) > 0 and wellnessitem <> '1' and consultationdate between '$fromdate' and '$todate' $services_linked_condition1 order by consultationdate desc";
                             
                             $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                             while ($res1 = mysqli_fetch_array($exec1)) {
                                 $res1patientcode = $res1['patientcode'];
                                 $res1visitcode = $res1['patientvisitcode'];
                                 $res1patientfullname = $res1['patientname'];
                                 $res1account = $res1['accountname'];
                                 $res1consultationdate = $res1['consultationdate'];
                                 $billnumber = $res1['billnumber'];
                                 $service_item_code = $res1['servicesitemcode'];
                                 $servicename = $res1["servicesitemname"];
                                 $refnumber = $res1['refno'];
                                 $refno = $res1['auto_number'];
                                 $sno = $sno + 1;
                                 
                                 $query11 = "select * from master_customer where customercode = '$res1patientcode' and status = '' ";
                                 $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
                                 $res11 = mysqli_fetch_array($exec11);
                                 $res11age = $res11['age'];
                                 $res11gender = $res11['gender'];
                                 
                                 $query111 = "select * from master_visitentry where patientcode = '$res1patientcode' ";
                                 $exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
                                 $res111 = mysqli_fetch_array($exec111);
                                 $res111consultingdoctor = $res111['consultingdoctor'];
                                 $res1111department = $res111['departmentname'];
                                 
                                 // Check if patient is external
                                 if($res1patientcode == 'walkin') {
                                     $query11 = "select * from billing_external where billno='$billnumber'";
                                     $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                     $res11 = mysqli_fetch_array($exec11);
                                     $res11age = $res11['age'];
                                     $res11gender = $res11['gender'];
                                     $res1111department = 'External';
                                     $res1visitcode = $res1['billnumber'];
                                 }
                                 
                                 $colorloopcount = $colorloopcount + 1;
                                 $showcolor = ($colorloopcount & 1); 
                                 $rowclass = ($showcolor == 0) ? 'even-row' : 'odd-row';
                         ?>
                         <tr class="<?php echo $rowclass; ?>">
                             <td class="modern-cell"><?php echo $sno; ?></td>
                             <td class="modern-cell"><?php echo $res1consultationdate; ?></td>
                             <td class="modern-cell">
                                 <div class="patient-info">
                                     <strong><?php echo htmlspecialchars($res1patientfullname); ?></strong><br>
                                     <small>Code: <?php echo htmlspecialchars($res1patientcode); ?></small>
                                 </div>
                             </td>
                             <td class="modern-cell"><?php echo htmlspecialchars($servicename); ?></td>
                             <td class="modern-cell"><?php echo htmlspecialchars($res1111department); ?></td>
                             <td class="modern-cell"><?php echo htmlspecialchars($res1account); ?></td>
                             <td class="modern-cell">
                                 <?php if($res1patientcode != 'walkin') { ?>
                                     <a href="cashservicesrefund_view.php?patientcode=<?php echo $res1patientcode; ?>&visitcode=<?php echo $res1visitcode; ?>&refnumber=<?php echo $refno; ?>&servicesitemcode=<?php echo $service_item_code; ?>" class="btn btn-primary btn-sm">
                                         <i class="fas fa-undo"></i> Refund
                                     </a>
                                 <?php } else { ?>
                                     <span class="btn btn-secondary btn-sm">
                                         <i class="fas fa-cog"></i> PROCESS
                                     </span>
                                 <?php } ?>
                             </td>
                         </tr>
                         <?php
                             }
                         }
                         ?>
                     </tbody>
                 </table>
             </div>
         </main>
     </div>

    <!-- Modern JavaScript -->
    <script src="js/cashservicesrefund-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Date Picker Scripts -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    
</body>
</html>
