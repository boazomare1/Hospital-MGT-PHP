<?php
session_start();
ob_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$docno = $_SESSION['docno'];
$docno1 = $_SESSION['docno'];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

// Date ranges
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$currentdate = date("Y-m-d");

// Handle form parameters
$ADate1 = isset($_REQUEST['ADate1']) ? $_REQUEST['ADate1'] : date('Y-m-d', strtotime('-1 month'));
$ADate2 = isset($_REQUEST['ADate2']) ? $_REQUEST['ADate2'] : date('Y-m-d');
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
$frm1submit1 = isset($_REQUEST["frm1submit1"]) ? $_REQUEST["frm1submit1"] : "";
$cbfrmflag1 = isset($_REQUEST["cbfrmflag1"]) ? $_REQUEST["cbfrmflag1"] : "";

$query = "select * from login_locationdetails where username='$username' and docno='$docno1' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
$locationname  = $res["locationname"];
$locationcode = $res["locationcode"];
 


if ($frm1submit1 == 'frm1submit1')
{
		
	
	foreach($_POST['select'] as $key => $value)
	{
		$docno = $_POST['select'][$key];	
		
		$query331 = "select locationcode from purchase_indent where docno='$docno' and approvalstatus='pending' and pogeneration!='completed'";
		$exec331 = mysqli_query($GLOBALS["___mysqli_ston"], $query331) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res331= mysqli_fetch_array($exec331);
		$locationcode=$res331['locationcode'];
		
		$query018="select auto_number from master_location where locationcode='$locationcode'";
		$exc018=mysqli_query($GLOBALS["___mysqli_ston"], $query018);
		$res018=mysqli_fetch_array($exc018);
		$location_auto = $res018['auto_number'];
		
		///////////////// GRN NUMBER /////////
		$query312 = "select * from bill_formats where description = 'external_mrn'";
		$exec312 = mysqli_query($GLOBALS["___mysqli_ston"], $query312) or die ("Error in Query312".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res312 = mysqli_fetch_array($exec312);
		$paynowbillprefix = $res312['prefix'];
		$paynowbillprefix13=strlen($paynowbillprefix);
		$query2233 = "select * from materialreceiptnote_details where billnumber like '%$paynowbillprefix-%' order by auto_number desc limit 0, 1";
		$exec2233 = mysqli_query($GLOBALS["___mysqli_ston"], $query2233) or die ("Error in Query2233".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2233 = mysqli_fetch_array($exec2233);
		$billnumber3 = $res2233["billnumber"];
		$billdigit3=strlen($billnumber3);
		if ($billnumber3 == '')
		{
			$billnumbercode3 =$paynowbillprefix."-".'1'."-".date('y')."-".$location_auto;
		}
		else
		{
			$billnumber3 = $res2233["billnumber"];
			$maxcount3=split("-",$billnumber3);
			$maxcount_3=$maxcount3[1];
			$maxanum = $maxcount_3+1;
			$billnumbercode3 = $paynowbillprefix ."-".$maxanum."-".date('y')."-".$location_auto;
		}
		///////////////// GRN NUMBER /////////
		///////////////// MLPO NUMBER GENERATE /////////
		$query31 = "select * from bill_formats where description = 'direct_purchase'";
		$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res31 = mysqli_fetch_array($exec31);
		$paynowbillprefix = $res31['prefix'];
        $paynowbillprefix1=strlen($paynowbillprefix);
        $query3 = "select * from manual_lpo order by auto_number desc limit 0, 1";
        $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        $num3 = mysqli_num_rows($exec3);
        $res3 = mysqli_fetch_array($exec3);
        $billnumber1 = $res3['billnumber'];
        $billdigit=strlen($billnumber1);
        if($num3 >0)
        {
				$query22 = "select * from manual_lpo order by auto_number desc limit 0, 1";
				$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num22 = mysqli_num_rows($exec22);
				$res22 = mysqli_fetch_array($exec22);
				$billnumber1 = $res222["billnumber"];        
				$billdigit=strlen($billnumber1);
				if($billnumber1 != '')
				{
				$billnumbercode1 = $billnumber1;
				$docstatus = '';          
				}
				else
				{
				$query224 = "select * from manual_lpo order by auto_number desc limit 0, 1";
				$exec224 = mysqli_query($GLOBALS["___mysqli_ston"], $query224) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res224 = mysqli_fetch_array($exec224);
				$billnumber1 = $res224['billnumber'];
				$maxcount_1=split("-",$billnumber1);
				$maxcount_2=$maxcount_1[1];
				$maxanum = $maxcount_2+1;
				$billnumbercode1 = $paynowbillprefix ."-".$maxanum."-".date('y')."-".$location_auto;
				$openingbalance = '0.00';           
				$docstatus = 'new';
				}
        }
        else
        {
          $query22 = "select * from manual_lpo order by auto_number desc limit 0, 1";
          $exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
          $res22 = mysqli_fetch_array($exec22);
          $billnumber1 = $res22["billnumber"];
          $billdigit=strlen($billnumber1);
          if ($billnumber1 == '')
          {
			$billnumbercode1 =$paynowbillprefix."-".'1'."-".date('y')."-".$location_auto;
            $openingbalance = '0.00';
            $docstatus = 'new';
          }
        } 
		
		
			$query33 = "select * from purchase_indent where docno='$docno' and approvalstatus='pending' and pogeneration!='completed'";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res33 = mysqli_fetch_array($exec33))
			{
				$medicinename=$res33['medicinename'];
				$rate=$res33['rate'];
				$quantity=$res33['quantity'];
				$subtotal=$res33['amount'];
				$suppliername=$res33['suppliername'];
				$suppliercode=$res33['suppliercode'];
				$supplieranum=$res33['supplieranum'];
				$locationname=$res33['locationname'];
				$locationcode=$res33['locationcode'];
				$currency=$res33['currency'];
				$fxamount=$res33['fxamount'];
				$job_title=$res33['job_title'];
				$tax_percentage=$res33['tax_percentage'];
				$is_blanket=$res33['is_blanket'];
				
		
				if($is_blanket=='yes')
				$received_status = '';
				else
				$received_status = 'received';
				$query56="INSERT into manual_lpo(companyanum,billnumber,itemcode,itemname,rate,quantity,totalamount,username, ipaddress, entrydate,purchaseindentdocno,purchasetype,suppliername,suppliercode,supplieranum,recordstatus,docstatus,locationname,locationcode,storename,storecode,currency,fxamount,fxpkrate,fxtotamount,remarks,job_title,goodsstatus,itemtaxpercentage,itemtaxamount,is_blanket) values('$companyanum','$billnumbercode1','','$medicinename','$rate','$quantity','$subtotal','$username','$ipaddress','$currentdate','$docno','','$suppliername','$suppliercode','$supplieranum','generated','$docstatus','$locationname','$locationcode','','','$currency','$fxamount','$rate','$subtotal','','$job_title','','$tax_percentage','$tax_amount','$is_blanket')";
				$exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));    
				
				/////////////////// MLPO ///////////// goods RECIVED NOTES //////////////
				
				if($is_blanket=='no'){
				$query4 = "insert into materialreceiptnote_details (bill_autonumber, companyanum, billnumber, itemanum, itemcode, itemname, itemdescription, rate, quantity, 
				subtotal, free, discountpercentage, discountrupees, openingstock, closingstock, totalamount, discountamount, username, ipaddress, entrydate, itemtaxpercentage, itemtaxamount, unit_abbreviation, batchnumber, salesprice, expirydate, itemfreequantity, itemtotalquantity, packageanum, packagename, quantityperpackage, allpackagetotalquantity,manufactureranum,manufacturername,typeofpurchase,suppliername,suppliercode,supplieranum,ponumber,supplierbillnumber,costprice,locationcode,store,coa,categoryname,fifo_code,totalfxamount,fxpkrate,priceperpk,deliverybillno,currency,fxamount,ledgeranum,ledgercode,ledgername ,incomeledger,incomeledgercode,purchasetype,job_title,is_blanket) 
				values ('$billautonumber', '$companyanum', '$billnumbercode3', '', '', '$medicinename', '', '$rate', '$quantity', '$subtotal', '', '0', '0', '0', '0', '$subtotal', '0', '$username', '$ipaddress', '$currentdate', '$tax_percentage', '$tax_amount', '', '', '0', '$currentdate', '', '$quantity', '0', '', '0', '$quantity', '0', '', 'Process', '$suppliername', '$suppliercode', '$supplieranum', '$billnumbercode1', '', '$rate', '$locationcode', '', '', '', '', '$subtotal', '$rate', '$rate', '', '$currency', '$fxamount', '', '', '', '', '','','$job_title','$is_blanket')";
				$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				}
				
				
				$query55="update purchase_indent set approvalstatus='approved',pogeneration='completed' where docno='$docno'";
				$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	
				
			}
	}
	header("location:direct_purchaseapproval.php");
	exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direct Purchase Approval - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/vat-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style type="text/css">
.ui-menu .ui-menu-item{ zoom:1 !important; }
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.number
{
padding-left:690px;
text-align:right;
font-weight:bold;
}

/* Modern table styles */
.dropdown-toggle {
    color: #007bff;
    text-decoration: none;
    margin-right: 8px;
    font-size: 12px;
}

.dropdown-toggle:hover {
    color: #0056b3;
}

.dropdown-content {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    margin: 10px 0;
    padding: 15px;
}

.detail-table {
    width: 100%;
    border-collapse: collapse;
    background-color: white;
    border-radius: 4px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.detail-table th {
    background-color: #e9ecef;
    padding: 12px 8px;
    text-align: center;
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
}

.detail-table td {
    padding: 10px 8px;
    border-bottom: 1px solid #dee2e6;
}

.detail-row:hover {
    background-color: #f8f9fa;
}

.status-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-pending {
    background-color: #fff3cd;
    color: #856404;
    border: 1px solid #ffeaa7;
}

.form-checkbox {
    width: 18px;
    height: 18px;
    cursor: pointer;
}

.text-center { text-align: center; }
.text-right { text-align: right; }
</style>
<link href="autocomplete.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
</style>
</head>
<script src="js/datetimepicker_css.js"></script>
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
        <span>Purchase Management</span>
        <span>→</span>
        <span>Direct Purchase Approval</span>
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
                        <a href="purchase_indent.php" class="nav-link">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Purchase Indent</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="manual_lpo.php" class="nav-link">
                            <i class="fas fa-file-invoice"></i>
                            <span>Manual LPO</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="direct_purchaseapproval.php" class="nav-link">
                            <i class="fas fa-check-circle"></i>
                            <span>Direct Purchase Approval</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="materialreceiptnote.php" class="nav-link">
                            <i class="fas fa-truck"></i>
                            <span>Material Receipt</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="supplier_master.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Supplier Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="purchase_report.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Purchase Reports</span>
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
                <h2>Direct Purchase Approval</h2>
                <p>Review and approve direct purchase requests from various departments.</p>
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
            <div class="form-section">
                <div class="form-section-header">
                    <i class="fas fa-search form-section-icon"></i>
                    <h3 class="form-section-title">Search Purchase Requests</h3>
                </div>
                
                <form name="cbform1" method="post" action="direct_purchaseapproval.php" class="form-section-form">
                <!-- Current Location Display -->
                <div class="current-location">
                    <strong>Current Location: </strong>
                    <span id="ajaxlocation">
                        <?php		
                        if ($location!='')
                        {
                            $query12 = "select locationname from master_location where locationcode='$location' order by locationname";
                            $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res12 = mysqli_fetch_array($exec12);
                            echo $res1location = $res12["locationname"];
                        }
                        else
                        {
                            $query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res1 = mysqli_fetch_array($exec1);		
                            echo $res1location = $res1["locationname"];
                        }
                        ?>      
                    </span>
                </div>
                
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-input" onChange="ajaxlocationfunction(this.value);">
                                <option value="All">All</option>
                                <?php
                                $query1 = "select * from master_location where status=''  order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $loccode=array();
                                while ($res1 = mysqli_fetch_array($exec1))
                                {
                                    $locationname = $res1["locationname"];
                                    $locationcode1 = $res1["locationcode"];
                                    ?>
                                    <option value="<?php echo $locationcode1; ?>" <?php if($location!='')if($location==$locationcode1){echo "selected";}?>><?php echo $locationname; ?></option>
                                    <?php
                                } 
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <div class="date-input-group">
                                <input name="ADate1" id="ADate1" value="<?php echo $ADate1; ?>" readonly="readonly" onKeyDown="return disableEnterKey()" class="form-input date-picker">
                                <i class="fas fa-calendar-alt date-icon" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"></i>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <div class="date-input-group">
                                <input name="ADate2" id="ADate2" value="<?php echo $ADate2; ?>" readonly="readonly" onKeyDown="return disableEnterKey()" class="form-input date-picker">
                                <i class="fas fa-calendar-alt date-icon" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="btn btn-primary" name="Submit">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="reset" class="btn btn-secondary" id="resetbutton">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
            </form>
			</td>
			</tr>
                <script>
                $(function() {
                    $("[id^='droupid']").hide(0);
                });
                
                function dropdown(id, action) {
                    if (action == 'down') {
                        $("#droupid" + id).slideDown(300);
                        $("#down" + id).hide(0);
                        $("#up" + id).show();
                    } else if (action == 'up') {
                        $("#droupid" + id).slideUp(300);
                        $("#up" + id).hide(0);
                        $("#down" + id).show();
                    }
                }
                
                function checkboxselect(docno, checkboxId) {
                    // Add any checkbox selection logic here
                    console.log('Selected document:', docno, 'Checkbox ID:', checkboxId);
                }
                
                function validcheck() {
                    var checkedBoxes = $('input[name^="select"]:checked');
                    if (checkedBoxes.length === 0) {
                        alert('Please select at least one purchase request to approve.');
                        return false;
                    }
                    return confirm('Are you sure you want to approve the selected purchase requests?');
                }
                </script>			
                <form method="post" name="form1" action="direct_purchaseapproval.php" onSubmit="return validcheck()">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Location</th>
                                <th>Date</th>
                                <th>Doc No</th>
                                <th>User</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Approve</th>
                            </tr>
                        </thead>
                        <tbody>
			<?php
			if($cbfrmflag1=='cbfrmflag1'){
			if($location=='All')
			{
			$pass_location = "locationcode !=''";
			}
			else
			{
			$pass_location = "locationcode ='$location'";
			}
			$colorloopcount = '';
			$sno = '';
			$sno1 = '';
			$query34="select *,sum(amount) as transactionamount from purchase_indent where approvalstatus='pending' and pogeneration='pending' and date BETWEEN '".$ADate1."' and '".$ADate2."' and $pass_location group by docno";
			$exec34=mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res34=mysqli_fetch_array($exec34))
			{
			$locationname=$res34['locationname'];
			$docno=$res34['docno'];
			$date=$res34['date'];
			$user=$res34['username'];
			$budgetamount=$res34['transactionamount'];
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
                            <tr class="table-row <?php echo ($showcolor == 0) ? 'table-row-even' : 'table-row-odd'; ?>">
                                <td class="text-center">
                                    <?php $sno = $sno + 1; ?>
                                    <a id="down<?php echo $sno; ?>" onClick="dropdown(<?php echo $sno; ?>,'down')" href="#" class="dropdown-toggle">
                                        <i class="fas fa-chevron-down"></i>
                                    </a>
                                    <a id="up<?php echo $sno; ?>" onClick="dropdown(<?php echo $sno; ?>,'up')" href="#" class="dropdown-toggle" style="display:none;">
                                        <i class="fas fa-chevron-up"></i>
                                    </a>
                                    <?php echo $sno; ?>
                                </td>
                                <td class="text-center"><?php echo htmlspecialchars($locationname); ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($date); ?></td>
                                <td class="text-center">
                                    <strong><?php echo htmlspecialchars($docno); ?></strong>
                                </td>
                                <td class="text-center"><?php echo htmlspecialchars($user); ?></td>
                                <td class="text-center">
                                    <span class="status-badge status-pending">Pending</span>
                                </td>
                                <td class="text-right"><?php echo number_format($budgetamount, 2, '.', ','); ?></td>
                                <td class="text-center">
                                    <input type="checkbox" name="select[<?php echo $sno;?>]" id="select<?php echo $sno;?>" value="<?php echo $docno; ?>" onClick="checkboxselect('<?php echo $docno; ?>',this.id)" class="form-checkbox">
                                </td>
                            </tr>
			
                            <tr>
                                <td colspan="8">
                                    <div id="droupid<?php echo $sno; ?>" class="dropdown-content" style="display: none;">
                                        <table class="detail-table">
                                            <thead>
                                                <tr>
                                                    <th>Supplier Name</th>
                                                    <th>Item Name</th>
                                                    <th>Rate</th>
                                                    <th>Qty</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
			<?php
			$sno2 = 0;
			$totalamount=0;	
			$budgetamount=0;		
			$query12 = "select * from purchase_indent where docno='$docno' and approvalstatus='pending' and pogeneration!='completed'";
			$exec12= mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numb12=mysqli_num_rows($exec12);
			while($res12 = mysqli_fetch_array($exec12))
			{
			$medicinename = $res12['medicinename'];	
			$reqqty = $res12['quantity'];
			$rate = $res12['rate'];
			$suppliername = $res12['suppliername'];
			$amount = $res12['amount'];
		
			?>
                                                <tr class="detail-row">
                                                    <td class="text-center"><?php echo htmlspecialchars($suppliername); ?></td>
                                                    <td class="text-center"><?php echo htmlspecialchars($medicinename); ?></td>
                                                    <td class="text-right"><?php echo number_format($rate, 2); ?></td>
                                                    <td class="text-center"><?php echo htmlspecialchars($reqqty); ?></td>
                                                    <td class="text-right"><?php echo number_format($amount, 2); ?></td>
                                                </tr>
			<?php
			}
			?>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            }
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8" class="text-right">
                                    <div class="form-actions">
                                        <input type="hidden" name="frm1submit1" value="frm1submit1" />
                                        <button type="submit" name="submit" id="savepo" class="btn btn-primary">
                                            <i class="fas fa-check"></i> Approve Selected
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </form>
        </div>
        
            <!-- Results Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-list data-table-icon"></i>
                    <h3 class="data-table-title">Purchase Requests for Approval</h3>
                </div>
                
                <!-- Search Bar -->
                <div style="margin-bottom: 1rem;">
                    <div style="display: flex; gap: 1rem; align-items: center;">
                        <input type="text" id="requestSearch" class="form-input" 
                               placeholder="Search requests..." 
                               style="flex: 1; max-width: 300px;"
                               oninput="searchRequests(this.value)">
                        <button type="button" class="btn btn-secondary" onclick="clearRequestSearch()">
                            <i class="fas fa-times"></i> Clear
                        </button>
                    </div>
                </div>
            
            <!-- Purchase approval form and table will continue here -->
            </div>
        </main>
    </div>
    
    <!-- Modern JavaScript -->
    <script>
        // Modern JavaScript functions
        function refreshPage() {
            window.location.reload();
        }

        function exportToExcel() {
            // Add export functionality here
            alert('Export functionality will be implemented');
        }

        function printReport() {
            window.print();
        }

        function resetForm() {
            document.getElementById("cbform1").reset();
        }

        function searchRequests(searchTerm) {
            const table = document.querySelector('.data-table tbody');
            if (table) {
                const rows = table.querySelectorAll('tr');
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm.toLowerCase())) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
        }

        function clearRequestSearch() {
            document.getElementById('requestSearch').value = '';
            searchRequests('');
        }

        // Sidebar functionality
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.getElementById('leftSidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');

            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });

            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });

            // Close sidebar when clicking outside
            document.addEventListener('click', function(event) {
                if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                    sidebar.classList.remove('active');
                }
            });
        });
    </script>
    <script src="js/direct_purchaseapproval-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>