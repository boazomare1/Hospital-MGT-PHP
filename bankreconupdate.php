<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$timeonly = date('H:i:s');
$errmsg = "";
$bgcolorcode = "";

$transactiondatefrom = '';
$transactiondateto = date('Y-m-d');

// Handle form submission
if (isset($_REQUEST["frmflg1"])) { 
    $frmflg1 = $_REQUEST["frmflg1"]; 
} else { 
    $frmflg1 = ""; 
}


if($frmflg1 == 'frmflg1') {
    // Process bank reconciliation update
    $apdate = $_REQUEST['apdate'];
    $auto_number = $_REQUEST['apno'];
    
    if($apdate != '' && $auto_number != '') {
        // Update bank record with new reconciliation date
        $query1 = "UPDATE bank_record SET bankdate = '$apdate', updateddate = '$transactiondateto', 
                   updatedtime = '$timeonly', recon_date_update_flag = '1' 
                   WHERE auto_number = '$auto_number'";
        
        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
        
        if($exec1) {
            $errmsg = "Success. Bank Reconciliation Updated.";
            $bgcolorcode = 'success';
        } else {
            $errmsg = "Failed. Unable to update bank reconciliation.";
            $bgcolorcode = 'failed';
        }
    } else {
        $errmsg = "Failed. Please provide both date and record number.";
        $bgcolorcode = 'failed';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Reconciliation - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/bankreconupdate-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Alert Container -->
    <div id="alertContainer"></div>

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
        <span>Bank Reconciliation</span>
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
                        <a href="addaccountsmain.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Accounts Main</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountssub.php" class="nav-link">
                            <i class="fas fa-chart-pie"></i>
                            <span>Accounts Sub Type</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addbank1.php" class="nav-link">
                            <i class="fas fa-university"></i>
                            <span>Bank Master</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="bankreconupdate.php" class="nav-link">
                            <i class="fas fa-balance-scale"></i>
                            <span>Bank Reconciliation</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="vat.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>VAT Master</span>
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
                    <h2>Bank Reconciliation</h2>
                    <p>Update bank reconciliation details and transaction dates for accurate financial records.</p>
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

            <!-- Data Table Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-balance-scale data-table-icon"></i>
                    <h3 class="data-table-title">Bank Reconciliation Records</h3>
                </div>
                
                <form id="reconForm" name="form1" method="post" action="bankreconupdate.php" class="add-form">
                    <input type="hidden" name="frmflg1" id="frmflg1" value="frmflg1" />
                    
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Account Name</th>
                                <th>Doc No</th>
                                <th>Inst. No</th>
                                <th>Amount</th>
                                <th>Posting Date</th>
                                <th>Cheque Date</th>
                                <th>Posted By</th>
                                <th>Remarks</th>
                                <th>Bank Amount</th>
                                <th>Bank Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="reconTableBody">
                                <?php
                                $colorloopcount = '';
                                $apno = '';
                                $totalamount = '0.00';
                                $aptotalamount = '0.00';
                                $apposttotalamount = '0.00';
                                $artotalamount = '0.00';
                                $arposttotalamount = '0.00';
                                $extotalamount = '0.00';
                                $exposttotalamount = '0.00';
                                $retotalamount = '0.00';
                                $reposttotalamount = '0.00';
                                $bktotalamount = '0.00';
                                $bkposttotalamount = '0.00';
                                $apjtotalamount = '0.00';
                                $apjposttotalamount = '0.00';
                                $total_credit_amount = 0;
                                $total_debit_amount = 0;

                                if(true) {
                                    $post21 = '';
                                    $query21 = "select * from bank_record where docno = '$transaction_number' and bankcode='$bankname' limit 0,1";
                                    $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res21 = mysqli_fetch_array($exec21);
                                    
                                    $apposttotalamount = $apposttotalamount + $res21['amount'];
                                    $apposttotalamount = 0;
                                    $post21 = mysqli_num_rows($exec21);

                                    if($post21 > 0) {
                                        $auto_number = $res21['auto_number'];
                                        $apaccountname = strtoupper($res21['description']);
                                        $apdocno = $res21['docno'];
                                        $apchequeno = $res21['instno'];
                                        $aptransactionamount = $res21['amount'];
                                        $aptransactiondate = $res21['bankdate'];
                                        $apchequedate = $res21['chequedate'];
                                        $appostedby = $res21['postby'];
                                        $apremarks = $res21['remarks'];
                                        $debit_amount = '0.00';
                                        $credit_amount = '0.00';

                                        if($auto_number != '') {
                                            $colorloopcount++;
                                ?>
                                <tr>
                                    <input name="apno" id="apno" value="<?php echo $auto_number; ?>" type="hidden"/>
                                    
                                    <td><?php echo $colorloopcount; ?></td>
                                    
                                    <td>
                                        <span class="account-name-badge"><?php echo htmlspecialchars($apaccountname); ?></span>
                                        <input name="apaccountname" id="apaccountname" value="<?php echo htmlspecialchars($apaccountname); ?>" type="hidden"/>
                                    </td>
                                    
                                    <td><?php echo htmlspecialchars($apdocno); ?>
                                        <input name="apdocno" id="apdocno" value="<?php echo htmlspecialchars($apdocno); ?>" type="hidden"/>
                                    </td>
                                    
                                    <td><?php echo htmlspecialchars($apchequeno); ?>
                                        <input name="apchequeno" id="apchequeno" value="<?php echo htmlspecialchars($apchequeno); ?>" type="hidden"/>
                                    </td>
                                    
                                    <td>
                                        <span class="amount-badge"><?php echo number_format($aptransactionamount,2,'.',','); ?></span>
                                        <input name="aptransactionamount" id="aptransactionamount" value="<?php echo $aptransactionamount; ?>" type="hidden"/>
                                    </td>
                                    
                                    <td><?php echo htmlspecialchars($aptransactiondate); ?>
                                        <input name="aptransactiondate" id="aptransactiondate" value="<?php echo htmlspecialchars($aptransactiondate); ?>" type="hidden"/>
                                    </td>
                                    
                                    <td><?php echo htmlspecialchars($apchequedate); ?>
                                        <input name="apchequedate" id="apchequedate" value="<?php echo htmlspecialchars($apchequedate); ?>" type="hidden"/>
                                    </td>
                                    
                                    <td><?php echo htmlspecialchars($appostedby); ?>
                                        <input name="appostedby" id="appostedby" value="<?php echo htmlspecialchars($appostedby); ?>" type="hidden"/>
                                    </td>
                                    
                                    <td><?php echo htmlspecialchars($apremarks); ?>
                                        <input name="apremarks" id="apremarks" value="<?php echo htmlspecialchars($apremarks); ?>" type="hidden"/>
                                    </td>
                                    
                                    <td>
                                        <input name="apbankamount" id="apbankamount" 
                                               value="<?php echo number_format($aptransactionamount,2,'.',','); ?>" 
                                               class="form-input" readonly />
                                    </td>
                                    
                                    <td>
                                        <input name="apdate" id="apdate" value="" 
                                               class="form-input datepicker" 
                                               placeholder="Select Date" required />
                                    </td>
                                    
                                    <td>
                                        <div class="action-buttons">
                                            <button type="submit" class="action-btn save">
                                                <i class="fas fa-save"></i> Update
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                        }
                                    }
                                }
                                ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/bankreconupdate-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>

<?php 
function getcreditdebitor($refno,$aptransactionamount)
{
	
	$debit_amount = '0.00';
	$credit_amount = '0.00';
	$haystack = $refno;
	$needle   = "AR";
	if( strpos( $haystack, $needle ) !== false) {
		
		$debit_amount = $aptransactionamount;
		$credit_amount = '0.00';
	}
	else
	{
		$debit_amount = '0.00';
		$needle   = "SPE";
		if( strpos( $haystack, $needle ) !== false) {
		
			$credit_amount = $aptransactionamount;
		}
		else
		{
			$credit_amount = '0.00';
			$needle   = "RE";
			if( strpos( $haystack, $needle ) !== false) {
		
				$debit_amount = $aptransactionamount;
				$credit_amount = '0.00';
			}
			else
			{
				$debit_amount = '0.00';

				$needle   = "BE";
				if( strpos( $haystack, $needle ) !== false) {
		
					$credit_amount = $aptransactionamount;
				}
				else
				{
					$credit_amount = '0.00';
					//FOR DOCTORS PAYMENT ENTRY
					$debit_amount = '0.00';
					$needle   = "DP";
					if( strpos( $haystack, $needle ) !== false) {
					
						$credit_amount = $aptransactionamount;
					}
					else{
						$credit_amount = '0.00';
						
					}
				}
			}

		}
	}

	$needle   = "EN";
	if( strpos( $haystack, $needle ) !== false) {
	
		if($aptransactionamount<0)
			$credit_amount = abs($aptransactionamount);
		else
			$debit_amount = abs($aptransactionamount);
	}



	$amount['debit_amount'] = $debit_amount;
	$amount['credit_amount'] = $credit_amount;
	return $amount;
		    
}
?>