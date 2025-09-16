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
$dateonly = date("Y-m-d");
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$runningbalance = 0;
$totalunpre = 0;
$totalunclr = 0;
  
// Handle form submission and search parameters
if (isset($_REQUEST["frmflg1"])) { 
    $frmflg1 = $_REQUEST["frmflg1"]; 
} else { 
    $frmflg1 = ""; 
}

if (isset($_REQUEST["ADate1"])) { 
    $transactiondatefrom = $_REQUEST["ADate1"]; 
} else { 
    $transactiondatefrom = date("Y-m-d"); 
}

if (isset($_REQUEST["ADate2"])) { 
    $transactiondateto = $_REQUEST["ADate2"]; 
} else { 
    $transactiondateto = date("Y-m-d"); 
}

if (isset($_REQUEST["searchmonth"])) { 
    $searchmonth = $_REQUEST["searchmonth"]; 
} else { 
    $searchmonth = date('m'); 
}

if (isset($_REQUEST["searchyear"])) { 
    $searchyear = $_REQUEST["searchyear"]; 
} else { 
    $searchyear = ""; 
}

if (isset($_REQUEST["bankname"])) { 
    $bankfullname = $_REQUEST["bankname"];
} else { 
    $bankfullname = "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Transaction Statement - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/banktransactionstatement-modern.css?v=<?php echo time(); ?>">
    
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
        <span>Bank Transaction Statement</span>
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
                    <li class="nav-item">
                        <a href="bankreconupdate.php" class="nav-link">
                            <i class="fas fa-balance-scale"></i>
                            <span>Bank Reconciliation</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="payrollbankreport1.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Payroll Bank Report</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="banktransactionstatement.php" class="nav-link">
                            <i class="fas fa-file-alt"></i>
                            <span>Bank Transaction Statement</span>
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
                    <h2>Bank Transaction Statement</h2>
                    <p>Generate and view comprehensive bank transaction statements with detailed financial records.</p>
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

            <!-- Add Form Section -->
            <div class="add-form-section">
                <div class="add-form-header">
                    <i class="fas fa-search add-form-icon"></i>
                    <h3 class="add-form-title">Search Bank Transaction Statement</h3>
                </div>
                
                <form id="bankStatementForm" method="post" action="banktransactionstatement.php" class="add-form">
                    <div class="form-group">
                        <label for="bankname" class="form-label">Bank Name</label>
                        <select name="bankname" id="bankname" class="form-input" required>
                            <option value="">SELECT BANK</option>
                    <?php
                            $query11 = "SELECT * FROM master_bank WHERE bankstatus = ''";
					$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res11 = mysqli_fetch_array($exec11))
					{
					$bankname = $res11["bankname"];
					$accountnumber = $res11["accountnumber"];
					$bankcode = $res11["bankcode"];
					 ?>
                    <option value="<?php echo $bankcode;?>"
                                <?php if(isset($_REQUEST['bankname']) && ($_REQUEST['bankname'] == $bankcode)) {?> selected <?php } ?>>
                                <?php echo htmlspecialchars($bankname); ?>-<?php echo htmlspecialchars($accountnumber); ?>
                    </option>
                    <?php
					 }
					 ?>
                        </select>
                    </div>
				
                    <div class="form-group">
                        <label for="searchmonth" class="form-label">Month</label>
                        <select name="searchmonth" id="searchmonth" class="form-input" required>
                          <option <?php if($searchmonth == '1') { ?> selected = 'selected' <?php } ?> value="1">January</option>
                          <option <?php if($searchmonth == '2') { ?> selected = 'selected' <?php } ?> value="2">February</option>
                          <option <?php if($searchmonth == '3') { ?> selected = 'selected' <?php } ?> value="3">March</option>
                          <option <?php if($searchmonth == '4') { ?> selected = 'selected' <?php } ?> value="4">April</option>
                          <option <?php if($searchmonth == '5') { ?> selected = 'selected' <?php } ?> value="5">May</option>
                          <option <?php if($searchmonth == '6') { ?> selected = 'selected' <?php } ?> value="6">June</option>
                          <option <?php if($searchmonth == '7') { ?> selected = 'selected' <?php } ?> value="7">July</option>
                          <option <?php if($searchmonth == '8') { ?> selected = 'selected' <?php } ?> value="8">August</option>
                          <option <?php if($searchmonth == '9') { ?> selected = 'selected' <?php } ?> value="9">September</option>
                          <option <?php if($searchmonth == '10'){ ?> selected = 'selected' <?php } ?> value="10">October</option>
                          <option <?php if($searchmonth == '11'){ ?> selected = 'selected' <?php } ?> value="11">November</option>
                          <option <?php if($searchmonth == '12'){ ?> selected = 'selected' <?php } ?> value="12">December</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="searchyear" class="form-label">Year</label>
                        <select name="searchyear" id="searchyear" class="form-input" required>
                          <?php if($searchyear != ''){ ?>
                              <option value="<?php echo $searchyear; ?>"><?php echo $searchyear; ?></option>
                          <?php } ?>
                          <option value="">Select Year</option>
                            <?php 
                            $years = range(2023, date('Y') + 2); 
                            foreach($years as $year1) : ?>
                              <option value="<?php echo $year1; ?>"><?php echo $year1; ?></option>
                          <?php endforeach; ?>
                        </select>
                    </div>
					
                    <div class="form-group">
                        <button type="submit" id="submitBtn" class="submit-btn">
                            <i class="fas fa-search"></i>
                            Generate Statement
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>

                    <input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
				  </form>
            </div>
            <!-- Data Table Section -->
            <?php if($frmflag1 == 'frmflag1'): ?>
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-file-alt data-table-icon"></i>
                    <h3 class="data-table-title">Bank Transaction Statement Results</h3>
                </div>
                
				<?php
 					$sno = 0;
                if ($frmflag1 == 'frmflag1') {
					/* if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
					if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
					if ($ADate1 != '' && $ADate2 != '')
					{
						 $transactiondatefrom = $_REQUEST['ADate1'];
						 $transactiondateto = $_REQUEST['ADate2'];
					}
					else
					{
						$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
						$transactiondateto = date('Y-m-d');
					} */
					
					
					$transactiondatefrom= date($searchyear.'-'.$searchmonth.'-01');
					$transactiondateto= date($searchyear.'-'.$searchmonth.'-t');
					   $bankname = $bankfullname;
						/*$bankname = $_REQUEST["bankname"];
						$banknameexplode = explode("-",$bankname,4);
						
						echo $bankname1 = $banknameexplode[0];
						$bankname1 = trim($bankname1);
						$bankname2 = $banknameexplode[1];
						$bankname2 = trim($bankname2);*/
				?>
					
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Transaction Date</th>
                            <th>Statement Date</th>
                            <th>Description</th>
                            <th>Transaction Ref No</th>
                            <th>Money In</th>
                            <th>Money Out</th>
                            <th>Running Balance</th>
                </tr>
                    </thead>
                    <tbody>
				  <?php
				  $totatlmoneyin = 0;
				  $totatlmoneyout = 0;
				  $totatlrunningbal = 0;
				  $moneyin = 0;
				  $moneyout = 0;
				  $runningbalancecalc =0;
				  $temp = 0;
				  $runningbalance = 0;
				  $sno=0;
				  $opening = 0;
				  $query_acc = "select * from master_accountname where id = '$bankname'";
				  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_acc) or die ("Error in query_acc".mysqli_error($GLOBALS["___mysqli_ston"]));
				  $res1 = mysqli_fetch_array($exec1);
				  $currency = $res1['currency'];
				  $cur_qry = "select * from master_currency where currency like '$currency'";
				  $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $cur_qry) or die ("Error in cur_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
				  $res21 = mysqli_fetch_array($exec21);
				  $fxrate = $res21['rate'];
				  if($fxrate == 0.00)
				  {
					  $fxrate = 1.00;
				  }
				  $query = "select openbalanceamount,entrydate,docno from openingbalanceaccount where accountname = '$bankname'";
				  $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
				  while($res = mysqli_fetch_array($exec))
				  {
				  	$openingbal = $res['openbalanceamount'];
					$entrydate = $res['entrydate'];
					$docno = $res['docno'];
					$opening = $opening + $openingbal;
				  		$moneyin = 	$opening;
						$moneyout = 0;
				
						$runningbalance = $runningbalance + $moneyin - $moneyout;
						
				  $colorcode = 'bgcolor="#CBDBFA"';
				  ?>
				  <!--<tr  <?php echo $colorcode; ?>>
                  <td class="bodytext3" valign="middle"  align="center"><?php //echo $sno = $sno+1;?> </td>
				  <td class="bodytext3" valign="middle"  align="left"><?php echo $entrydate; ?></td>
                  <td class="bodytext3" valign="middle"  align="left"><?php echo '';?></td>
                  <td class="bodytext3" valign="middle"  align="left"><?php echo 'OPENING BALANCE';?></td>
				  <td class="bodytext3" valign="middle"  align="left"><?php echo $docno;?></td>
                  <td class="bodytext3" valign="middle"  align="right"><?php echo number_format($moneyin,2,'.',',');?> </td>
                  <td class="bodytext3" valign="middle"  align="right"><?php echo number_format($moneyout,2,'.',',');?></td>
                  <td class="bodytext3" valign="center"  align="right"><?php echo number_format($runningbalance,2,'.',',');?></td>
                </tr>-->
				<?php
				}
				?>
				<?php
				$qrybankstatements = "SELECT postdate,chequedate,bankdate,remarks,docno,bankamount,notes,status FROM bank_record WHERE bankdate < '$transactiondatefrom' AND bankcode = '$bankname' AND status IN ('Posted','Unpresented','Uncleared')";
				
					$excebankstatements = mysqli_query($GLOBALS["___mysqli_ston"], $qrybankstatements) or die("Error in qrybankstatements".mysqli_error($GLOBALS["___mysqli_ston"]));
			
					while($resbankstatement = mysqli_fetch_array($excebankstatements))
					{
					  $postingdate = $resbankstatement["chequedate"];
					  $valuedate = $resbankstatement["bankdate"];
					  $description = $resbankstatement["remarks"];
					  $transrefno = $resbankstatement["docno"];
					  $notes = $resbankstatement["notes"];
					  $status = $resbankstatement["status"];
					  	
						$query2 = "select amount, creditamount from bankentryform where docnumber = '$transrefno' and (frombankid = '$bankname' or tobankid = '$bankname')";
						$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res2 = mysqli_fetch_array($exec2);
						$num2 = mysqli_num_rows($exec2);
						$dramount = $res2['amount'];
						$cramount = $res2['creditamount'];
						if($num2 == 0)
						{
							//MONEY IN  -- notes type is accountrecievelbe
							if($notes == 'accounts receivable')
							{
								if($status == 'Unpresented')
								{
									$moneyin = 0;
									$moneyout = $resbankstatement["bankamount"];
								}
								else if($status == 'Uncleared')
								{
									$moneyin = 	$resbankstatement["bankamount"];
									$moneyout = 0;
								}
								else
								{
									$moneyin = 	$resbankstatement["bankamount"];
									$moneyout = 0;
								}
							}
							else if($notes == 'journal entries'){
								if($resbankstatement["bankamount"]<0){
									$moneyout = abs($resbankstatement["bankamount"]);
									$moneyin = 0;
								}else{
									$moneyin = abs($resbankstatement["bankamount"]);	
									$moneyout = 0;
								
								}
							}
							else //MONEY OUT
							{
								$moneyout = abs($resbankstatement["bankamount"]);
								$moneyin = 0;
							}
						}
						else
						{
							$moneyin = 	$dramount;
							$moneyout = $cramount;
						}	
						$moneyin = $moneyin/$fxrate;
						$moneyout = $moneyout/$fxrate;
						
						$runningbalance = $runningbalance + $moneyin - $moneyout;
						
						/*if($moneyout!=0 && $moneyin == 0)
						{
							if($temp == 0)
							{
								$runningbalancecalc = $runningbalancecalc + $moneyout;
								$runningbalance = "-".number_format($runningbalancecalc,2,'.',',');
							}
							else
							{
								$runningbalancecalc = $temp - $moneyout;
								$runningbalance = number_format($runningbalancecalc,2,'.',',');
								$temp = $runningbalancecalc;
							}
						}
						if($moneyin!= 0 && $moneyout==0)
						{
							if($moneyin>$runningbalancecalc)
							{
								$runningbalancecalc =$moneyin - $runningbalancecalc;
								$runningbalance = number_format($runningbalancecalc,2,'.',',');
								$temp = $runningbalancecalc;
							}
							if($moneyin == $runningbalancecalc)
							{
								$runningbalancecalc = $moneyin - $runningbalancecalc;
								$runningbalance = number_format($runningbalancecalc,2,'.',',');
							}
							
						}*/
						
						$colorcode = 'bgcolor="#CBDBFA"';
						
						//TOTALS
						//$totatlmoneyin = $totatlmoneyin + $moneyin;
						//$totatlmoneyout = $totatlmoneyout + $moneyout;
						//$totatlrunningbal = $totatlrunningbal + $runningbalance;
					}
					?>	
                        <tr class="opening-balance-row">
                            <td><?php echo $sno = $sno+1; ?></td>
                            <td></td>
                            <td></td>
                            <td colspan="2"><strong>OPENING BALANCE AND BALANCE CARRIED OVER</strong></td>
                            <td></td>
                            <td></td>
                            <td>
                                <span class="balance-badge"><?php echo number_format($runningbalance,2,'.',','); ?></span>
                            </td>
                </tr>
				  <?php
				   $qrybankstatements = "SELECT postdate,chequedate,bankdate,remarks,docno,bankamount,notes,status FROM bank_record WHERE bankdate BETWEEN '$transactiondatefrom' AND  '$transactiondateto' AND bankcode = '$bankname' AND status IN ('Posted','Unpresented','Uncleared') ";
					$excebankstatements = mysqli_query($GLOBALS["___mysqli_ston"], $qrybankstatements) or die("Error in qrybankstatements".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($resbankstatement = mysqli_fetch_array($excebankstatements))
					{
					  $postingdate = $resbankstatement["chequedate"];
					  $valuedate = $resbankstatement["bankdate"];
					  $description = $resbankstatement["remarks"];
					  $transrefno = $resbankstatement["docno"];
					  $notes = $resbankstatement["notes"];
					  $status = $resbankstatement["status"];
					  	
						$query2 = "select amount, creditamount from bankentryform where docnumber = '$transrefno' and (frombankid = '$bankname' or tobankid = '$bankname')";
						$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res2 = mysqli_fetch_array($exec2);
						$num2 = mysqli_num_rows($exec2);
						$dramount = $res2['amount'];
						$cramount = $res2['creditamount'];
						if($num2 == 0)
						{
							//MONEY IN  -- notes type is accountrecievelbe
							if($notes == 'accounts receivable')
							{
								if($status == 'Unpresented')
								{
									$moneyin = 0;
									$moneyout = $resbankstatement["bankamount"];
									$totalunpre = $resbankstatement["bankamount"];
								}
								else if($status == 'Uncleared')
								{
									$moneyin = 	$resbankstatement["bankamount"];
									$moneyout = 0;
									$totalunclr = $resbankstatement["bankamount"];
								}
								else
								{
									$moneyin = 	$resbankstatement["bankamount"];
									$moneyout = 0;
								}
							}
							else if($notes == 'journal entries'){
								if($resbankstatement["bankamount"]<0){
									$moneyout = abs($resbankstatement["bankamount"]);
									$moneyin = 0;
								}else{
									$moneyin = abs($resbankstatement["bankamount"]);	
									$moneyout = 0;
								
								}
							}
							else //MONEY OUT
							{
								$moneyout = abs($resbankstatement["bankamount"]);
								$moneyin = 0;
							}
						}
						else
						{
							$moneyin = 	$dramount;
							$moneyout = $cramount;
						}	
						
						$moneyin = $moneyin/$fxrate;
						$moneyout = $moneyout/$fxrate;
						$runningbalance = $runningbalance + $moneyin - $moneyout;
						
						/*if($moneyout!=0 && $moneyin == 0)
						{
							if($temp == 0)
							{
								$runningbalancecalc = $runningbalancecalc + $moneyout;
								$runningbalance = "-".number_format($runningbalancecalc,2,'.',',');
							}
							else
							{
								$runningbalancecalc = $temp - $moneyout;
								$runningbalance = number_format($runningbalancecalc,2,'.',',');
								$temp = $runningbalancecalc;
							}
						}
						if($moneyin!= 0 && $moneyout==0)
						{
							if($moneyin>$runningbalancecalc)
							{
								$runningbalancecalc =$moneyin - $runningbalancecalc;
								$runningbalance = number_format($runningbalancecalc,2,'.',',');
								$temp = $runningbalancecalc;
							}
							if($moneyin == $runningbalancecalc)
							{
								$runningbalancecalc = $moneyin - $runningbalancecalc;
								$runningbalance = number_format($runningbalancecalc,2,'.',',');
							}
							
						}*/
						
						//TOTALS
						$totatlmoneyin = $totatlmoneyin + $moneyin;
						$totatlmoneyout = $totatlmoneyout + $moneyout;
						//$totatlrunningbal = $totatlrunningbal + $runningbalance;
						
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
                            <td><?php echo $sno = $sno+1; ?></td>
                            <td><?php echo htmlspecialchars($postingdate); ?></td>
                            <td><?php echo htmlspecialchars($valuedate); ?></td>
                            <td><?php echo htmlspecialchars($description.' ('.$status.')'); ?></td>
                            <td>
                                <span class="ref-number-badge"><?php echo htmlspecialchars($transrefno); ?></span>
                            </td>
                            <td>
                                <?php if($moneyin > 0): ?>
                                    <span class="money-in-badge"><?php echo number_format($moneyin,2,'.',','); ?></span>
                                <?php else: ?>
                                    <span class="amount-zero">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($moneyout > 0): ?>
                                    <span class="money-out-badge"><?php echo number_format($moneyout,2,'.',','); ?></span>
                                <?php else: ?>
                                    <span class="amount-zero">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="balance-badge"><?php echo number_format($runningbalance,2,'.',','); ?></span>
                            </td>
                </tr>
		    <?php
					}//CLOSE -- WHILE LOOP
			     ?>
                    </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <td colspan="5" class="total-label"><strong>Total</strong></td>
                            <td class="total-amount"><strong><?php echo number_format($totatlmoneyin,2,'.',','); ?></strong></td>
                            <td class="total-amount"><strong><?php echo number_format($totatlmoneyout,2,'.',','); ?></strong></td>
                            <td></td>
                 </tr>
                        <tr class="total-row">
                            <td colspan="5" class="total-label"><strong>Total Unpresented</strong></td>
                            <td class="total-amount"><strong><?php echo number_format(0,2,'.',','); ?></strong></td>
                            <td class="total-amount"><strong><?php echo number_format($totalunpre,2,'.',','); ?></strong></td>
                            <td></td>
                 </tr>
                        <tr class="total-row">
                            <td colspan="5" class="total-label"><strong>Total Uncleared</strong></td>
                            <td class="total-amount"><strong><?php echo number_format($totalunclr,2,'.',','); ?></strong></td>
                            <td class="total-amount"><strong><?php echo number_format(0,2,'.',','); ?></strong></td>
                            <td></td>
                 </tr>
                        <tr class="total-row final-balance">
                            <td colspan="6" class="total-label"><strong>Total Bank Balance:</strong></td>
                            <td class="total-amount final-balance-amount"><strong><?php echo number_format($runningbalance,2,'.',','); ?></strong></td>
                            <td></td>
                </tr>
                    </tfoot>
	      </table>
                
                <div class="export-actions">
                    <a href="print_banktransactionstmnt.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&bankname=<?php echo $bankname; ?>" 
                       target="_blank" class="btn btn-primary">
                        <i class="fas fa-file-pdf"></i> Export to PDF
                    </a>
                    <a href="print_banktransactionstmnt_xls.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&bankname=<?php echo $bankname; ?>" 
                       target="_blank" class="btn btn-primary">
                        <i class="fas fa-file-excel"></i> Export to Excel
                    </a>
                </div>
            </div>
            <?php } // Close if ($frmflag1 == 'frmflag1') ?>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/banktransactionstatement-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>