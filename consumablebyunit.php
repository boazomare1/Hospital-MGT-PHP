<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$docno = $_SESSION['docno'];
$username = $_SESSION['username'];
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
$ADate1 = isset($_REQUEST['ADate1']) ? $_REQUEST['ADate1'] : $transactiondatefrom;
$ADate2 = isset($_REQUEST['ADate2']) ? $_REQUEST['ADate2'] : $transactiondateto;
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
$locationcode = $location;
$data = '';
$status = '';
$searchsupplier = '';
$fromstore = isset($_REQUEST['fromstore']) ? $_REQUEST['fromstore'] : "";
$tostore = isset($_REQUEST['tostore']) ? $_REQUEST['tostore'] : "";
$frmflag1 = isset($_REQUEST["frmflag1"]) ? $_REQUEST["frmflag1"] : "";

$indiatimecheck = date('d-M-Y-H-i-s');
$foldername = "dbexcelfiles";
$tab = "\t";
$cr = "\n";

$data .= "Supplier".$tab."Location" . $tab . "City" . $tab . "Phone1" . $tab . "Phone2" . $tab."Email1". $tab . "Email2" . $tab . "Fax1" . $tab . "Fax2" . $tab . "Address1". $tab . "Address2". $tab . $cr;

$i=0;

$query2 = "select * from master_supplier where status like '%$status%'  order by suppliername";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
$res2supplieranum = $res2['auto_number'];
$res2suppliername = $res2['suppliername'];
$res2location = $res2['area'];
$res2phonenumber1 = $res2['phonenumber1'];
$res2phonenumber2 = $res2['phonenumber2'];
$res2emailid1 = $res2['emailid1'];
$res2emailid2 = $res2['emailid2'];
$res2faxnumber1 = $res2['faxnumber'];
$res2faxnumber2 = '';
$res2anum = $res2['auto_number'];
$res2address1 = $res2['address1'];
$res2address2 = $res2['address2'];
$res2city1 = $res2['city'];
$res2suppliercode = $res2['suppliercode'];

$data .= $res2suppliername. $tab . $res2location . $tab . $res2city1 . $tab . $res2phonenumber1 . $tab . $res2phonenumber2 . $tab . $res2emailid1 . $tab . $res2emailid2 . $tab . $res2faxnumber1 . $tab . $res2faxnumber2 . $tab . $res2address1 . $tab . $res2address2 . $tab. $cr;		

}			
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consumable Report by Unit - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Modern CSS -->
    <link rel="stylesheet" href="css/consumablebyunit-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Additional CSS -->
    <link href="css/three.css" rel="stylesheet" type="text/css">
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css">
    
    <!-- Date Picker Scripts -->
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
</head>

<body>
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Consumable Report by Unit</p>
    </header>

    <!-- User Information Bar -->
    <div class="user-info-bar">
        <div class="user-welcome">
            <span class="welcome-text">Welcome, <strong><?php echo htmlspecialchars($username); ?></strong></span>
            <span class="location-info">📍 Document No: <?php echo htmlspecialchars($docno); ?></span>
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
        <span>Consumable Report by Unit</span>
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
                        <a href="consumablebyunit.php" class="nav-link active">
                            <i class="fas fa-chart-line"></i>
                            <span>Consumable Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="consultationtype_upload.php" class="nav-link">
                            <i class="fas fa-upload"></i>
                            <span>Upload Consultation Types</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addconsultationtemplate.php" class="nav-link">
                            <i class="fas fa-plus-circle"></i>
                            <span>Add Template</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="consultationrefundrequestlist.php" class="nav-link">
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
                    <h2>Consumable Report by Unit</h2>
                    <p>Generate and analyze consumable stock consumption reports by location and store.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                </div>
            </div>
            <!-- Form Section -->
            <div class="form-section">
                <div class="form-header">
                    <i class="fas fa-search form-header-icon"></i>
                    <h3 class="form-header-title">Search Criteria</h3>
                </div>
                
                <form name="frmsales" id="frmsales" method="post" action="consumablebyunit.php" class="form-container">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" onChange="storefunction(this.value);" class="form-input">
                                <option value="">All Locations</option>
                  <?php
						$query1 = "select * from master_location";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationanum; ?>" <?php if($location!='')if($location==$res1locationanum){echo "selected";}?>><?php echo $res1location; ?></option>
						<?php
						}
						?>
                  </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="fromstore" class="form-label">Store</label>
                            <select name="fromstore" id="fromstore" class="form-input">
                                <option value="">Select Store</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <div class="date-input-group">
                                <input name="ADate1" id="ADate1" value="<?php echo $ADate1; ?>" class="date-input" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" class="calendar-icon" style="cursor:pointer"/>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <div class="date-input-group">
                                <input name="ADate2" id="ADate2" value="<?php echo $ADate2; ?>" class="date-input" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" class="calendar-icon" style="cursor:pointer"/>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                    <input type="hidden" name="username" id="username" value="<?php echo $username;?>">
                    <input type="hidden" name="frmflag1" value="frmflag1">
                        <button type="submit" name="Submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="clearForm()">
                            <i class="fas fa-undo"></i> Clear
                        </button>
                    </div>
        </form>
            </div>
            <!-- Data Table Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-table data-table-icon"></i>
                    <h3 class="data-table-title">Consumable Report Data</h3>
                </div>
                
                <div class="table-container">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Doc No</th>
                                <th>Store</th>
                                <th>Date</th>
                                <th>Item Code</th>
                                <th>Item Name</th>
                                <th>Category</th>
                                <th>Batch</th>
                                <th>Qty.</th>
                                <th>Rate</th>
                                <th>Amount</th>
                                <th>Username</th>
                                <th>Remarks</th>
              </tr>
                        </thead>
                        <tbody>
			  <?php
			  $colorloopcount = '';
			  $loopcount = '';
			  $totamount = 0;
			 $location=isset($_REQUEST['location'])?$_REQUEST['location']:$res1locationanum;
			 if($location=='')
			 {
			$query66 = "select * from master_stock_transfer where typetransfer = 'Consumable' and entrydate BETWEEN '".$ADate1."' and '".$ADate2."'";
			 
			 }
			 else
			 {
			if($fromstore!=''){
			 $query66 = "select * from master_stock_transfer where locationcode = '".$location."' and fromstore = '".$fromstore."' and typetransfer = 'Consumable' and entrydate BETWEEN '".$ADate1."' and '".$ADate2."'";
			}else
			{
			$query66 = "select * from master_stock_transfer where locationcode = '".$location."' and typetransfer = 'Consumable' and entrydate BETWEEN '".$ADate1."' and '".$ADate2."'";
		
			}
			 }
			 $exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
			 while($res66 = mysqli_fetch_array($exec66))
			 {
			  $itemcode = $res66['itemcode'];
			  $docno = $res66['docno'];
			  $typetransfer = $res66['typetransfer'];
			  $fromstore = $res66['fromstore'];
			  $categoryname = $res66['categoryname'];
			  $transferuser = $res66['username'];
			  $loopcount=$loopcount+1;
			  
			  $query22 = mysqli_query($GLOBALS["___mysqli_ston"], "select store from master_store where storecode = '$fromstore'");
			  $res22 = mysqli_fetch_array($query22);
			  $fromstore1 = $res22['store'];
			 
			 			  
			  $batch = $res66['batch'];
			  $fifo_code = $res66['fifo_code'];
			  $transaction_quantity = $res66['transferquantity'];
			  $entrydate = $res66['entrydate'];
			  $itemname = $res66['itemname'];
			  $locationname = $res66['locationname'];
              $remarks = $res66['remarks'];
			  $expirydate = '';
			  
			 			  
			  $query3 = "select purchaseprice from master_medicine where itemcode = '$itemcode'";
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res3 = mysqli_fetch_array($exec3);
			  $rate = $res3['purchaseprice'];
			  
			  $amount = $transaction_quantity * $rate;
			  $totamount = $totamount + $amount;
			  
			  $colorloopcount = $colorloopcount + 1;
			  $showcolor = ($colorloopcount & 1); 
			  $colorcode = '';
			  if ($showcolor == 0)
			  {
			  	//$colorcode = 'bgcolor="#66CCFF"';
			  }
			  else
			  {
			  	$colorcode = 'bgcolor="#cbdbfa"';
			  }
			  ?>
                            <tr>
                                <td><?php echo $loopcount; ?></td>
                                <td><?php echo $docno; ?></td>
                                <td><?php echo $fromstore1; ?></td>
                                <td><?php echo $entrydate; ?></td>
                                <td><?php echo $itemcode; ?></td>
                                <td><?php echo $itemname; ?></td>
                                <td><?php echo $categoryname; ?></td>
                                <td><?php echo $batch; ?></td>
                                <td class="text-right"><?php echo $transaction_quantity; ?></td>
                                <td class="text-right"><?php echo $rate; ?></td>
                                <td class="text-right amount-cell"><?php echo number_format($amount,2); ?></td>
                                <td><?php echo $transferuser; ?></td>
                                <td><?php echo $remarks; ?></td>
              </tr>
			  <?php
			  //}
			  }
			  ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Summary Section -->
                <div class="summary-section">
                    <div class="summary-header">
                        <i class="fas fa-calculator summary-icon"></i>
                        <h4 class="summary-title">Report Summary</h4>
                    </div>
                    <div class="summary-grid">
                        <div class="summary-item">
                            <div class="summary-label">Total Records</div>
                            <div class="summary-value"><?php echo $loopcount; ?></div>
                        </div>
                        <div class="summary-item">
                            <div class="summary-label">Total Amount</div>
                            <div class="summary-value" id="totalAmount">₹<?php echo number_format($totamount,2); ?></div>
                        </div>
                    </div>
                </div>
                
                <!-- Table Actions -->
                <?php if($frmflag1 == 'frmflag1') { ?>
                <div class="table-actions">
                    <a target="_blank" href="print_consumablebyunit.php?fromstore=<?=$fromstore;?>&&location=<?= $location;?>&&tostore=<?= $tostore;?>&&ADate1=<?= $ADate1;?>&&ADate2=<?=$ADate2;?>&frmflag1=frmflag1" class="export-btn">
                        <i class="fas fa-file-excel"></i>
                        Export to Excel
                    </a>
                </div>
                <?php } ?>
            </div>
</main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/consumablebyunit-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Additional Scripts -->
    <script src="js/datetimepicker_css.js"></script>
    <?php include("js/dropdownlist1scriptingtostore.php"); ?>
    <script type="text/javascript" src="js/autocomplete_store.js"></script>
    <script type="text/javascript" src="js/autosuggeststore.js"></script>
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js"></script>
</body>
</html>

