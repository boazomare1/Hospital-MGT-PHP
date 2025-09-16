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
$currentdate = date("Y-m-d");
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');  
include ("autocompletebuild_users.php");
 
$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if (isset($_REQUEST["searchbillnumber"])) { $searchbillnumber = $_REQUEST["searchbillnumber"]; } else { $searchbillnumber = ""; }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claim Transaction Edit - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/claimtxnidedit-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <!-- External JavaScript -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/datetimepicker_css.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<link href="js/jquery-ui.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery-1.11.1.js"></script>
<script type="text/javascript" src="js/autocomplete_users.js"></script>
    <script type="text/javascript" src="js/autosuggestusers.js"></script>
</head>
    <!-- Autocomplete CSS -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
</head>
<script src="js/datetimepicker_css.js"></script>
<body>
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Claim Transaction Edit</p>
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
        <span>Claim Transaction Edit</span>
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
                    <li class="nav-item active">
                        <a href="claimtxnidedit.php" class="nav-link">
                            <i class="fas fa-edit"></i>
                            <span>Claim Transaction Edit</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountreceivableentrylist.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>Account Receivable</span>
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
                <h2>Claim Transaction Edit</h2>
                <p>Edit Pre-Auth codes for claim transactions and billing records.</p>
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
                <h3 class="search-form-title">Search Claim Transactions</h3>
            </div>
            
            <form name="cbform1" method="post" action="claimtxnidedit.php" onSubmit="return valid();" class="search-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="searchbillnumber" class="form-label">Search Bill Number</label>
                        <input type="hidden" name="cbcustomername" id="cbcustomername" value="">
                        <input name="searchbillnumber" type="text" value="<?php echo htmlspecialchars($searchbillnumber); ?>" 
                               id="searchbillnumber" class="form-input" placeholder="Enter bill number" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="location" class="form-label">Location</label>
                        <select name="location" id="location" class="form-input" onChange="ajaxlocationfunction(this.value);">
                            <?php
                            $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
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
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Search
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="resetForm()">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>
            </form>
        </div>
        <!-- Results Section -->
        <?php
        if (isset($_REQUEST["cbfrmflag1"])) { 
            $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; 
        } else { 
            $cbfrmflag1 = ""; 
        }
        
        if ($cbfrmflag1 == 'cbfrmflag1') {
        ?>
        
        <div class="results-table-section">
            <div class="results-table-header">
                <i class="fas fa-list results-table-icon"></i>
                <h3 class="results-table-title">Claim Transactions</h3>
            </div>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Bill Date</th>
                            <th>Bill No</th>
                            <th>Patient Name</th>
                            <th>Patient Code</th>
                            <th>Visit Code</th>
                            <th>Pre-Auth Code</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $colorloopcount = '';
                        $sno = '';
                        $query40 = "select * from billing_paylater where billno like '%$searchbillnumber%' AND locationcode='$location'";
                        $exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die ("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));
                        
                        while($res40 = mysqli_fetch_array($exec40)) {
                            $res40billnumber = $res40['billno'];
                            $res40auto_number = $res40['auto_number'];
                            $res40transactiondate = $res40['billdate'];
                            $res40patientname = $res40['patientname'];
                            $res40patientcode = $res40['patientcode'];
                            $res40visitcode = $res40['visitcode'];
                            $res40preauthcode = $res40['preauthcode'];
                            
                            $colorloopcount = $colorloopcount + 1;
                            $showcolor = ($colorloopcount & 1); 
                            $sno = $sno + 1;
                        ?>

                        <tr class="<?php echo $showcolor == 0 ? 'even-row' : 'odd-row'; ?>" id="<?php echo $sno; ?>">
                            <td><?php echo $sno; ?></td>
                            <td>
                                <span class="date-badge"><?php echo date('d/m/Y', strtotime($res40transactiondate)); ?></span>
                            </td>
                            <td>
                                <span class="bill-number"><?php echo htmlspecialchars($res40billnumber); ?></span>
                            </td>
                            <td>
                                <span class="patient-name"><?php echo htmlspecialchars($res40patientname); ?></span>
                            </td>
                            <td>
                                <span class="patient-code"><?php echo htmlspecialchars($res40patientcode); ?></span>
                            </td>
                            <td>
                                <span class="visit-code"><?php echo htmlspecialchars($res40visitcode); ?></span>
                            </td>
                            <td>
                                <div class="mptxnno" id="caredittxno_<?php echo $sno;?>">
                                    <span class="pre-auth-code"><?php echo htmlspecialchars($res40preauthcode); ?></span>
                                </div>
                                <div style="display:none;" class="txnno1">
                                    <input class="mptxnno1 editable-field" id="mptxnno_<?php echo $sno;?>" 
                                           name="mptxnno[]" value="" size="10" onKeyDown="return disableEnterKey()" />
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a class="action-btn edit edititem" id="<?php echo $sno; ?>" href="" title="Edit Pre-Auth Code">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a style="display:none;" class="action-btn save saveitem" id="s_<?php echo $sno; ?>" href="" title="Save Changes">
                                        <i class="fas fa-save"></i> Update
                                    </a>
                                </div>
                            </td>
                            <input type="hidden" name="autono[]" id="autono_<?php echo $sno;?>" value="<?php echo $res40auto_number ?>" />
                            <input type="hidden" name="billno[]" id="billno_<?php echo $sno;?>" value="<?php echo $res40billnumber ?>" />
                            <input type="hidden" name="tablename[]" id="tablename_<?php echo $sno;?>" value="billing_paylater" />
                        </tr>

                        <?php
                        }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/claimtxnidedit-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>