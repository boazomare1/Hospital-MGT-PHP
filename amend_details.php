<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d',strtotime("-7 days"));
$transactiondateto = date('Y-m-d');
$docno = $_SESSION['docno'];
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $transactiondatefrom; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $transactiondateto; }
if (isset($_REQUEST["itemname"])) { $itemname = $_REQUEST["itemname"]; } else { $itemname = ''; }
if (isset($_REQUEST["itemcode"])) { $itemcode = $_REQUEST["itemcode"]; } else { $itemcode = ''; }
if (isset($_REQUEST["auditype"])) { $auditype = $_REQUEST["auditype"]; } else { $auditype = ''; }
if (isset($_REQUEST["visittype"])) { $visittype = $_REQUEST["visittype"]; } else { $visittype = ''; }
if (isset($_REQUEST["locationcode"])) { $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ''; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amendment Details Report - MedStar</title>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/amenddetails-modern.css?v=<?php echo time(); ?>">
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
        <span>Amendment Details Report</span>
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
                        <a href="ipamendrad_pending.php" class="nav-link">
                            <i class="fas fa-x-ray"></i>
                            <span>Radiology Pending</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipamendlab_pending.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Pending</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipamendser_pending.php" class="nav-link">
                            <i class="fas fa-stethoscope"></i>
                            <span>Service Pending</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amend_pending_referral.php" class="nav-link">
                            <i class="fas fa-user-md"></i>
                            <span>Referral Pending</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amend_pending_service.php" class="nav-link">
                            <i class="fas fa-cogs"></i>
                            <span>Service Pending</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="amend_details.php" class="nav-link">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Amendment Details</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountreceivableentrylist_amend.php" class="nav-link">
                            <i class="fas fa-money-bill"></i>
                            <span>AR Entries</span>
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
                    <h2>Amendment Details Report</h2>
                    <p>View and manage amendment records for different services and locations.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToCSV()">
                        <i class="fas fa-download"></i> Export
                    </button>
                    <button type="button" class="btn btn-outline" onclick="printReport()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>
        
            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="search-form-header">
                    <i class="fas fa-search search-form-icon"></i>
                    <h3 class="search-form-title">Search Amendment Records</h3>
                </div>
                
                <form name="cbform1" method="post" action="" id="searchForm" class="search-form">
                    <div class="form-group">
                        <label for="locationcode" class="form-label">Location</label>
                        <select name="locationcode" id="locationcode" class="form-input">
                            <option value="">All Locations</option>
						<?php
						$query = "select * from master_employeelocation where username='$username' group by locationcode order by locationanum asc";
						$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res = mysqli_fetch_array($exec)) {
						$reslocation = $res["locationname"];
						$reslocationanum = $res["auto_number"];
						$locationanum = $res["locationanum"];
						?>
                                <option value="<?php echo $locationanum; ?>" <?php if($locationcode!='')if($locationcode==$locationanum){echo "selected";}?>><?php echo htmlspecialchars($reslocation); ?></option>
						<?php 
						}
						?>
						</select>
                    </div>
                    
                    <div class="form-group">
                        <label for="auditype" class="form-label">Service Type</label>
                        <select name="auditype" id="auditype" class="form-input">
                            <option value="all">All Services</option>
                          <option value="Pharmacy" <?php if($auditype=="Pharmacy") echo 'selected'; ?>>Pharmacy</option>
						  <option value="lab" <?php if($auditype=="lab") echo 'selected'; ?>>Laboratory</option>
						  <option value="radiology" <?php if($auditype=="radiology") echo 'selected'; ?>>Radiology</option>
						  <option value="services" <?php if($auditype=="services") echo 'selected'; ?>>Services</option>
						  <option value="Misc" <?php if($auditype=="Misc") echo 'selected'; ?>>Misc</option>
						  <option value="IP Doctor" <?php if($auditype=="IP Doctor") echo 'selected'; ?>>IP Doctor</option>
				</select>
                    </div>
                    
                    <div class="form-group">
                        <label for="visittype" class="form-label">Visit Type</label>
                        <select name="visittype" id="visittype" class="form-input">
                            <option value="all">All Types</option>
                          <option value="OP" <?php if($visittype=="OP") echo 'selected'; ?>>OP</option>
						  <option value="IP" <?php if($visittype=="IP") echo 'selected'; ?>>IP</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="ADate1" class="form-label">Date From</label>
                        <input name="ADate1" id="ADate1" type="date" value="<?php echo $ADate1; ?>" class="form-input" />
                    </div>
                    
                    <div class="form-group">
                        <label for="ADate2" class="form-label">Date To</label>
                        <input name="ADate2" id="ADate2" type="date" value="<?php echo $ADate2; ?>" class="form-input" />
                    </div>
                    
                    <div class="form-group">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-search"></i>
                            Search Records
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>
        
            <!-- Data Table Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-list data-table-icon"></i>
                    <h3 class="data-table-title">Amendment Records</h3>
                </div>

                <!-- Search Bar -->
                <div style="margin-bottom: 1rem;">
                    <div style="display: flex; gap: 1rem; align-items: center;">
                        <input type="text" id="tableSearch" class="form-input" 
                               placeholder="Search records..." 
                               style="flex: 1; max-width: 300px;"
                               oninput="searchRecords(this.value)">
                        <button type="button" class="btn btn-secondary" onclick="clearSearch()">
                            <i class="fas fa-times"></i> Clear
                        </button>
                    </div>
                </div>

                <div id="totalRecords" class="total-records">
                    <i class="fas fa-info-circle"></i> Total Records: <span id="recordCount">0</span>
                </div>
                
                <div id="loading" class="loading">
                    <div class="spinner"></div>
                    <p>Loading amendment records...</p>
                </div>
                
                <div id="alertContainer"></div>
                
                <div id="dataTableContainer">
			<?php
                if (isset($_REQUEST["cbfrmflag1"])) { 
                    $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; 
                } else { 
                    $cbfrmflag1 = ""; 
                }
                
                if ($cbfrmflag1 == 'cbfrmflag1') {
					if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
					if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
					if (isset($_REQUEST["auditype"])) { $auditype = $_REQUEST["auditype"]; } else { $auditype = "all"; }

					$colorloopcount = '';
			        $sno = '';
					
                    if($locationcode=='') {
					$locationwise="and visitcode like '%%'";
                    } else {
					$locationwise="and visitcode like '%-$locationcode'";
					}

					if($visittype=='all')
						$subqry ='';
					else
						$subqry =" and type='$visittype'";

                    if($auditype=='all')
                        $query1 = "select * from amendment_details where amenddate between '$ADate1' and '$ADate2' $subqry $locationwise order by auto_number";
					else
                        $query1 = "select * from amendment_details where amenddate between '$ADate1' and '$ADate2' and amendfrom='$auditype' $subqry $locationwise order by auto_number";
			
					$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $totalRecords = mysqli_num_rows($exec1);
                    
                    if ($totalRecords > 0) {
                        echo '<table class="data-table" id="amendmentTable">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>#</th>';
                        echo '<th>Patient Code</th>';
                        echo '<th>Visit Code</th>';
                        echo '<th>Patient Name</th>';
                        echo '<th>Item Name</th>';
                        echo '<th>Rate</th>';
                        echo '<th>Service</th>';
                        echo '<th>Date</th>';
                        echo '<th>User</th>';
                        echo '<th>Remarks</th>';
                        echo '<th>IP Address</th>';
                        echo '<th>Visit Type</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody id="amendmentTableBody">';
                        
                        while ($res1 = mysqli_fetch_array($exec1)) {
						$patientcode = $res1['patientcode'];
			            $visitcode = $res1['visitcode'];
						$patientname = $res1['patientname'];
						$itemname = $res1['itemname'];
						$amenddate = $res1['amenddate']." ".$res1['amendtime'];
						$amendfrom = $res1['amendfrom'];
						$amendby = $res1['amendby'];
						$ipaddress = $res1['ipaddress'];
						$type = $res1['type'];
						$remarks = $res1['remarks'];
						$rate = $res1['rate'];

                            $sno = $sno + 1;
                            
                            echo '<tr>';
                            echo '<td>'.$sno.'</td>';
                            echo '<td><span class="patient-code-badge">'.htmlspecialchars($patientcode).'</span></td>';
                            echo '<td><span class="visit-code-badge">'.htmlspecialchars($visitcode).'</span></td>';
                            echo '<td>'.htmlspecialchars($patientname).'</td>';
                            echo '<td>'.htmlspecialchars($itemname).'</td>';
                            echo '<td>₹'.number_format($rate, 2).'</td>';
                            echo '<td><span class="service-badge service-'.strtolower(str_replace(' ', '-', $amendfrom)).'">'.ucfirst(strtolower($amendfrom)).'</span></td>';
                            echo '<td>'.date('d/m/Y H:i', strtotime($amenddate)).'</td>';
                            echo '<td>'.htmlspecialchars($amendby).'</td>';
                            echo '<td>'.htmlspecialchars($remarks).'</td>';
                            echo '<td>'.htmlspecialchars($ipaddress).'</td>';
                            echo '<td><span class="status-badge status-'.strtolower($type).'">'.$type.'</span></td>';
                            echo '</tr>';
                        }
                        
                        echo '</tbody>';
                        echo '</table>';
                        
                        echo '<script>document.getElementById("recordCount").textContent = "'.$totalRecords.'";</script>';
                    } else {
                        echo '<div class="no-data">';
                        echo '<i class="fas fa-inbox fa-3x" style="color: #dee2e6; margin-bottom: 1rem;"></i>';
                        echo '<h3>No Records Found</h3>';
                        echo '<p>No amendment records found for the selected criteria.</p>';
                        echo '</div>';
                        echo '<script>document.getElementById("recordCount").textContent = "0";</script>';
                    }
                }
                ?>
            </div>
            
            <div id="paginationContainer" class="pagination"></div>
            </div>
        </main>
    </div>
    
    <script src="js/amenddetails-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Legacy Functions -->
    <script>
        function cbcustomername1() {
            document.cbform1.submit();
        }
        
        function disableEnterKey(varPassed) {
            if (event.keyCode==8) {
                event.keyCode=0; 
                return event.keyCode;
                return false;
            }
            
            var key;
            if(window.event) {
                key = window.event.keyCode;
            } else {
                key = e.which;
            }

            if(key == 13) {
                return false;
            } else {
                return true;
            }
        }
    </script>
</body>
</html>
