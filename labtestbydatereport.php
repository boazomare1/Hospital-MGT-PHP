<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";

// Get search parameters
$fromdate = isset($_REQUEST['fromdate']) ? $_REQUEST['fromdate'] : date('Y-m-d');
$todate = isset($_REQUEST['todate']) ? $_REQUEST['todate'] : date('Y-m-d');
$patientname = isset($_REQUEST['patientname']) ? $_REQUEST['patientname'] : '';
$patientcode = isset($_REQUEST['patientcode']) ? $_REQUEST['patientcode'] : '';
$visitcode = isset($_REQUEST['visitcode']) ? $_REQUEST['visitcode'] : '';

// Build query based on search parameters
$where_conditions = array();
$where_conditions[] = "consultationdate BETWEEN '$fromdate' AND '$todate'";

if (!empty($patientname)) {
    $where_conditions[] = "patientname LIKE '%$patientname%'";
}
if (!empty($patientcode)) {
    $where_conditions[] = "patientcode LIKE '%$patientcode%'";
}
if (!empty($visitcode)) {
    $where_conditions[] = "patientvisitcode LIKE '%$visitcode%'";
}

$where_clause = implode(' AND ', $where_conditions);

// Get lab tests by date
$query = "SELECT * FROM consultation_lab WHERE $where_clause ORDER BY consultationdate DESC, patientname ASC";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));

// Get summary statistics
$summary_query = "SELECT 
    COUNT(*) as total_tests,
    COUNT(CASE WHEN paymentstatus = 'completed' THEN 1 END) as completed_tests,
    COUNT(CASE WHEN paymentstatus = 'pending' THEN 1 END) as pending_tests,
    COUNT(CASE WHEN labsamplecoll = 'collected' THEN 1 END) as collected_samples,
    COUNT(CASE WHEN labsamplecoll = 'pending' THEN 1 END) as pending_samples
    FROM consultation_lab WHERE $where_clause";
$summary_exec = mysqli_query($GLOBALS["___mysqli_ston"], $summary_query) or die ("Error in Summary Query".mysqli_error($GLOBALS["___mysqli_ston"]));
$summary_res = mysqli_fetch_array($summary_exec);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Test by Date Report - MedStar Healthcare</title>
    <link rel="stylesheet" href="css/labtestbydatereport-modern.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/datetimepicker_css.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/datetimepicker_css.js"></script>
</head>
<body>
    <!-- Hospital Header -->
    <div class="hospital-header">
        <div class="hospital-title">MedStar Healthcare</div>
        <div class="hospital-subtitle">Lab Test by Date Report</div>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Navigation -->
        <nav class="breadcrumb-nav">
            <a href="index.php" class="breadcrumb-link">
                <i class="fas fa-home"></i> Home
            </a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">Lab Test by Date Report</span>
        </nav>

        <!-- Search Section -->
        <div class="search-section">
            <div class="section-header">
                <h2><i class="fas fa-search"></i> Search Criteria</h2>
            </div>
            
            <form method="get" action="" class="search-form">
                <div class="form-row">
                    <div class="form-field">
                        <label for="fromdate">From Date *</label>
                        <input type="date" id="fromdate" name="fromdate" value="<?php echo $fromdate; ?>" required>
                    </div>
                    <div class="form-field">
                        <label for="todate">To Date *</label>
                        <input type="date" id="todate" name="todate" value="<?php echo $todate; ?>" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-field">
                        <label for="patientname">Patient Name</label>
                        <input type="text" id="patientname" name="patientname" value="<?php echo htmlspecialchars($patientname); ?>" placeholder="Enter patient name">
                    </div>
                    <div class="form-field">
                        <label for="patientcode">Patient Code</label>
                        <input type="text" id="patientcode" name="patientcode" value="<?php echo htmlspecialchars($patientcode); ?>" placeholder="Enter patient code">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-field">
                        <label for="visitcode">Visit Code</label>
                        <input type="text" id="visitcode" name="visitcode" value="<?php echo htmlspecialchars($visitcode); ?>" placeholder="Enter visit code">
                    </div>
                    <div class="form-field">
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="button" class="btn-secondary" onclick="clearForm()">
                            <i class="fas fa-undo"></i> Clear
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="summary-cards">
            <div class="summary-card">
                <div class="card-icon">
                    <i class="fas fa-flask"></i>
                </div>
                <div class="card-content">
                    <h3><?php echo $summary_res['total_tests']; ?></h3>
                    <p>Total Tests</p>
                </div>
            </div>
            <div class="summary-card">
                <div class="card-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="card-content">
                    <h3><?php echo $summary_res['completed_tests']; ?></h3>
                    <p>Completed Tests</p>
                </div>
            </div>
            <div class="summary-card">
                <div class="card-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="card-content">
                    <h3><?php echo $summary_res['pending_tests']; ?></h3>
                    <p>Pending Tests</p>
                </div>
            </div>
            <div class="summary-card">
                <div class="card-icon">
                    <i class="fas fa-vial"></i>
                </div>
                <div class="card-content">
                    <h3><?php echo $summary_res['collected_samples']; ?></h3>
                    <p>Collected Samples</p>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        <div class="results-section">
            <div class="section-header">
                <h2><i class="fas fa-list"></i> Lab Test Results</h2>
                <div class="section-actions">
                    <button class="btn-export" onclick="exportToExcel()">
                        <i class="fas fa-file-excel"></i> Export to Excel
                    </button>
                    <button class="btn-print" onclick="printReport()">
                        <i class="fas fa-print"></i> Print Report
                    </button>
                </div>
            </div>
            
            <div class="table-container">
                <table class="data-table" id="labTestTable">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Test Date</th>
                            <th>Patient Code</th>
                            <th>Visit Code</th>
                            <th>Patient Name</th>
                            <th>Account Name</th>
                            <th>Test Name</th>
                            <th>Sample Collection</th>
                            <th>Payment Status</th>
                            <th>Bill Type</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sno = 1;
                        $total_amount = 0;
                        while ($res = mysqli_fetch_array($exec)) {
                            $bgcolor = ($sno % 2 == 0) ? '#f8f9fa' : '#ffffff';
                            $total_amount += $res['totalamount'];
                        ?>
                        <tr style="background-color: <?php echo $bgcolor; ?>">
                            <td><?php echo $sno; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($res['consultationdate'])); ?></td>
                            <td><?php echo htmlspecialchars($res['patientcode']); ?></td>
                            <td><?php echo htmlspecialchars($res['patientvisitcode']); ?></td>
                            <td><?php echo htmlspecialchars($res['patientname']); ?></td>
                            <td><?php echo htmlspecialchars($res['accountname']); ?></td>
                            <td><?php echo htmlspecialchars($res['itemname']); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo $res['labsamplecoll'] == 'collected' ? 'success' : 'warning'; ?>">
                                    <?php echo ucfirst($res['labsamplecoll']); ?>
                                </span>
                            </td>
                            <td>
                                <span class="status-badge status-<?php echo $res['paymentstatus'] == 'completed' ? 'success' : 'warning'; ?>">
                                    <?php echo ucfirst($res['paymentstatus']); ?>
                                </span>
                            </td>
                            <td>
                                <span class="status-badge status-info">
                                    <?php echo $res['billtype']; ?>
                                </span>
                            </td>
                            <td>₹<?php echo number_format($res['totalamount'], 2); ?></td>
                        </tr>
                        <?php
                        $sno++;
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <td colspan="10"><strong>Total Amount:</strong></td>
                            <td><strong>₹<?php echo number_format($total_amount, 2); ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <script src="js/labtestbydatereport-modern.js"></script>
</body>
</html>