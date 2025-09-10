<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

// Initialize variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
$docno = $_SESSION['docno'];

// Form parameters
$location = isset($_REQUEST["location"]) ? $_REQUEST["location"] : '';
$ADate1 = isset($_REQUEST["ADate1"]) ? $_REQUEST["ADate1"] : $transactiondatefrom;
$ADate2 = isset($_REQUEST["ADate2"]) ? $_REQUEST["ADate2"] : $transactiondateto;
$patientname1 = isset($_REQUEST["patientname1"]) ? $_REQUEST["patientname1"] : '';
$patientcode1 = isset($_REQUEST["patientcode1"]) ? $_REQUEST["patientcode1"] : '';
$visitcode1 = isset($_REQUEST["visitcode1"]) ? $_REQUEST["visitcode1"] : '';

// Update date variables if form submitted
if ($ADate1) $transactiondatefrom = $ADate1;
if ($ADate2) $transactiondateto = $ADate2;

$errmsg = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amend Pending Misc - MedStar</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/amendpendingmisc-modern.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="hospital-header">
        <h1 class="hospital-title">MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
    </header>

    <div class="user-info-bar">
        <div class="user-welcome">
            <span class="welcome-text">Welcome, <?php echo htmlspecialchars($username); ?></span>
            <span class="location-info">Company: <?php echo htmlspecialchars($companyname); ?></span>
        </div>
        <div class="user-actions">
            <a href="mainmenu.php" class="btn btn-outline">Main Menu</a>
            <a href="logout.php" class="btn btn-outline">Logout</a>
        </div>
    </div>

    <nav class="nav-breadcrumb">
        <a href="mainmenu.php">Home</a>
        <span>→</span>
        <span>Amend Pending Misc</span>
    </nav>

    <div id="menuToggle" class="floating-menu-toggle">
        <i class="fas fa-bars"></i>
    </div>

    <div class="main-container-with-sidebar">
        <aside id="leftSidebar" class="left-sidebar">
            <div class="sidebar-header">
                <h3>Quick Navigation</h3>
                <button id="sidebarToggle" class="sidebar-toggle">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="vat.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            VAT Master
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="advancedeposit.php" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            Advance Deposit
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addalertmessage1.php" class="nav-link">
                            <i class="fas fa-bell"></i>
                            Alert Messages
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ar_allocatedreport.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            AR Allocated Report
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="amend_pending_misc.php" class="nav-link active">
                            <i class="fas fa-edit"></i>
                            Amend Pending Misc
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="newpatient.php" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            New Patient
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="patientlist.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            Patient List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="visitentry.php" class="nav-link">
                            <i class="fas fa-calendar-check"></i>
                            Visit Entry
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <div id="alertContainer">
                <?php if ($errmsg): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="page-header">
                <div class="page-header-content">
                    <h2>Amend Pending Misc</h2>
                    <p>Search and amend pending miscellaneous billing records</p>
                </div>
                <div class="page-header-actions">
                    <button class="btn btn-primary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i>
                        Refresh
                    </button>
                    <button class="btn btn-secondary" onclick="exportToExcel()">
                        <i class="fas fa-file-excel"></i>
                        Export
                    </button>
                </div>
            </div>

            <div class="search-form-section">
                <div class="search-form-header">
                    <i class="fas fa-search search-form-icon"></i>
                    <h3 class="search-form-title">Search Criteria</h3>
                </div>
                
                <form name="searchForm" method="post" action="" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="patientname1" class="form-label">Patient Name</label>
                            <input name="patientname1" type="text" id="patientname1" 
                                   value="<?php echo htmlspecialchars($patientname1); ?>" 
                                   class="form-input" placeholder="Enter patient name..." autocomplete="off">
                        </div>
                        
                        <div class="form-group">
                            <label for="patientcode1" class="form-label">Registration No</label>
                            <input name="patientcode1" type="text" id="patientcode1" 
                                   value="<?php echo htmlspecialchars($patientcode1); ?>" 
                                   class="form-input" placeholder="Enter registration number..." autocomplete="off">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="visitcode1" class="form-label">Visit Code</label>
                            <input name="visitcode1" type="text" id="visitcode1" 
                                   value="<?php echo htmlspecialchars($visitcode1); ?>" 
                                   class="form-input" placeholder="Enter visit code..." autocomplete="off">
                        </div>
                        
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-input">
                                <option value="">Select Location</option>
                                <?php
                                $query1 = mysqli_prepare($GLOBALS["___mysqli_ston"], "SELECT * FROM login_locationdetails WHERE username = ? AND docno = ? GROUP BY locationname ORDER BY locationname");
                                mysqli_stmt_bind_param($query1, 'ss', $username, $docno);
                                mysqli_stmt_execute($query1);
                                $exec1 = mysqli_stmt_get_result($query1);
                                
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $locationname = $res1["locationname"];
                                    $locationcode = $res1["locationcode"];
                                    $selected = ($location == $locationcode) ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($locationcode) . "' $selected>" . htmlspecialchars($locationname) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <input name="ADate1" id="ADate1" type="date" 
                                   value="<?php echo htmlspecialchars($ADate1); ?>" 
                                   class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <input name="ADate2" id="ADate2" type="date" 
                                   value="<?php echo htmlspecialchars($ADate2); ?>" 
                                   class="form-input">
                        </div>
                    </div>

                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="submit-btn" onclick="return validateSearchForm()">
                            <i class="fas fa-search"></i>
                            Search
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i>
                            Reset
                        </button>
                    </div>
                </form>
            </div>

            <?php if (isset($_REQUEST["cbfrmflag1"]) && $_REQUEST["cbfrmflag1"] == 'cbfrmflag1'): ?>
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-table data-table-icon"></i>
                    <h3 class="data-table-title">Pending Misc Records</h3>
                    <?php
                    // Get count of pending records
                    $countQuery = mysqli_prepare($GLOBALS["___mysqli_ston"], "SELECT COUNT(DISTINCT patientvisitcode) as count FROM ipmisc_billing WHERE patientname LIKE ? AND patientcode LIKE ? AND patientvisitcode LIKE ? AND consultationdate BETWEEN ? AND ? AND paymentstatus = 'pending'");
                    $patientNameSearch = '%' . $patientname1 . '%';
                    $patientCodeSearch = '%' . $patientcode1 . '%';
                    $visitCodeSearch = '%' . $visitcode1 . '%';
                    mysqli_stmt_bind_param($countQuery, 'sssss', $patientNameSearch, $patientCodeSearch, $visitCodeSearch, $ADate1, $ADate2);
                    mysqli_stmt_execute($countQuery);
                    $countResult = mysqli_stmt_get_result($countQuery);
                    $countData = mysqli_fetch_array($countResult);
                    $pendingCount = $countData['count'];
                    ?>
                    <span class="pending-count"><?php echo $pendingCount; ?> Pending</span>
                </div>

                <div class="table-container">
                    <table class="data-table" id="pendingMiscTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>OP Date</th>
                                <th>Patient Code</th>
                                <th>Visit Code</th>
                                <th>Patient</th>
                                <th>Account</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="pendingMiscTableBody">
                            <?php
                            $colorloopcount = 0;
                            $sno = 0;
                            
                            $query1 = mysqli_prepare($GLOBALS["___mysqli_ston"], "SELECT * FROM ipmisc_billing WHERE patientname LIKE ? AND patientcode LIKE ? AND patientvisitcode LIKE ? AND consultationdate BETWEEN ? AND ? AND paymentstatus = 'pending' GROUP BY patientvisitcode ORDER BY consultationdate DESC");
                            mysqli_stmt_bind_param($query1, 'sssss', $patientNameSearch, $patientCodeSearch, $visitCodeSearch, $ADate1, $ADate2);
                            mysqli_stmt_execute($query1);
                            $exec1 = mysqli_stmt_get_result($query1);
                            
                            if (mysqli_num_rows($exec1) > 0) {
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $patientcode = $res1['patientcode'];
                                    $visitcode = $res1['patientvisitcode'];
                                    $patientname = $res1['patientname'];
                                    $patientaccountname = $res1['accountname'];
                                    $consultationdate = $res1['consultationdate'];
                                    
                                    $colorloopcount++;
                                    $showcolor = ($colorloopcount & 1);
                                    $rowClass = $showcolor == 0 ? 'even-row' : 'odd-row';
                                    $sno++;
                            ?>
                            <tr class="<?php echo $rowClass; ?>">
                                <td class="sno-cell"><?php echo $sno; ?></td>
                                <td class="date-cell"><?php echo htmlspecialchars($consultationdate); ?></td>
                                <td class="code-cell"><?php echo htmlspecialchars($patientcode); ?></td>
                                <td class="code-cell"><?php echo htmlspecialchars($visitcode); ?></td>
                                <td class="name-cell"><?php echo htmlspecialchars($patientname); ?></td>
                                <td class="account-cell"><?php echo htmlspecialchars($patientaccountname); ?></td>
                                <td class="action-cell">
                                    <a href="amendmisc.php?patientcode=<?php echo urlencode($patientcode); ?>&visitcode=<?php echo urlencode($visitcode); ?>&menuid=<?php echo $menu_id; ?>" 
                                       class="action-btn edit" title="Amend Record">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                                }
                            } else {
                            ?>
                            <tr>
                                <td colspan="7" class="no-results">
                                    <i class="fas fa-search"></i>
                                    <p>No pending misc records found for the selected criteria.</p>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <script src="js/amendpendingmisc-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>

