<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$errmsg = "";
$transferquantity2 = '';
$transferamount2 = '0';

$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
	 $res12locationanum = $res["auto_number"];
	 
  $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
//To populate the autocompetelist_services1.js
//include ("autocompletebuild_item1pharmacy.php");

$transactiondatefrom = '2017-01-01';
$transactiondateto = date('Y-m-d');
	
if (isset($_REQUEST["ADate2"])) { $transactiondateto = $_REQUEST["ADate2"]; }

if (isset($_REQUEST["searchitemcode"])) { $searchitemcode = $_REQUEST["searchitemcode"]; } else { $searchitemcode = ""; }
//$itemcode = $_REQUEST['itemcode'];
if (isset($_REQUEST["servicename"])) { $servicename = $_REQUEST["servicename"]; } else { $servicename = ""; }
//$servicename = $_REQUEST['servicename'];
if($searchitemcode == ''){ $searchcode_12 = $servicename; } else { $searchcode_12 = $searchitemcode; }
//if ($servicename == '') $servicename = 'ALL';
if (isset($_REQUEST["categoryname"])) { $categoryname_1 = $_REQUEST["categoryname"]; } else { $categoryname_1 = ""; }
if (isset($_REQUEST["itemname"])) { $searchitemname = $_REQUEST["itemname"]; } else { $searchitemname = ""; }
if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
//$searchitemname = $_REQUEST['itemname'];
if ($searchitemname != '')
{
	$arraysearchitemname = explode('||', $searchitemname);
	$itemcode = $arraysearchitemname[0];
	$itemcode = trim($itemcode);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Report by Item - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/stockreportbyitem3-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- External JavaScript -->
    <script src="js/datetimepicker_css.js"></script>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<?php include ("js/dropdownlist1scripting1stock1.php"); ?>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script type="text/javascript" src="js/autosuggest1itemstock2.js"></script>
    <script type="text/javascript" src="js/autocomplete_item1pharmacy4.js"></script>
</head>


</script>
<body onLoad="return funcCustomerDropDownSearch1();">
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Stock Report by Item</p>
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
        <span>Reports</span>
        <span>→</span>
        <span>Stock Report by Item</span>
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
                    <li class="nav-item active">
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
                    <h2>Stock Report by Item</h2>
                    <p>Generate detailed stock reports by item with current inventory levels.</p>
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
            <!-- Stock Report Section -->
            <div class="stock-report-section">
                <div class="stock-report-header">
                    <div class="stock-report-icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <div class="stock-report-title">Closing Stock - Report By Item</div>
                </div>

                <?php if ($errmsg != ''): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($errmsg); ?>
                </div>
                <?php endif; ?>

                <form name="stockinward" action="" method="post" onKeyDown="return disableEnterKey()" onSubmit="return Locationcheck()" class="search-form">
       
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-select" onChange="storefunction(this.value)">
                                <option value="">-Select Location-</option>
                                <?php
                                $query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res = mysqli_fetch_array($exec))
                                {
                                    $reslocation = $res["locationname"];
                                    $reslocationanum = $res["locationcode"];
                                ?>
                                <option value="<?php echo $reslocationanum; ?>" <?php if($location!='')if($location==$reslocationanum){echo "selected";}?>><?php echo $reslocation; ?></option>
                                <?php 
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="store" class="form-label">Store</label>
                            <select name="store" id="store" class="form-select">
                                <option value="">-Select Store-</option>
                                <?php 
                                $loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';
                                $username=isset($_REQUEST['username'])?$_REQUEST['username']:'';
                                $frmflag1=isset($_REQUEST['frmflag1'])?$_REQUEST['frmflag1']:'';
                                $store=isset($_REQUEST['store'])?$_REQUEST['store']:'';?>  
                                <?php if ($frmflag1 == 'frmflag1')
                                {
                                    $loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';
                                    $username=isset($_REQUEST['username'])?$_REQUEST['username']:'';
                                    $query5 = "select ms.auto_number,ms.storecode,ms.store from master_employeelocation as me LEFT JOIN master_store as ms ON me.storecode=ms.auto_number where me.locationcode = '".$loc."' AND me.username= '".$username."'";
                                    $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while ($res5 = mysqli_fetch_array($exec5))
                                    {
                                        $res5anum = $res5["storecode"];
                                        $res5name = $res5["store"];
                                ?>
                                <option value="<?php echo $res5anum;?>" <?php if($store==$res5anum){echo 'selected';}?>><?php echo $res5name;?></option>
                                <?php 
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <input type="hidden" name="locationnamenew" value="<?php echo htmlspecialchars($locationname); ?>">
                    <input type="hidden" name="locationcodenew" value="<?php echo htmlspecialchars($res1locationanum); ?>">
                    <input type="hidden" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="categoryname" class="form-label">Category</label>
                            <select name="categoryname" id="categoryname" class="form-select">
                                <?php
                                $categoryname = $_REQUEST['categoryname'];
                                if ($categoryname != '')
                                {
                                ?>
                                <option value="<?php echo htmlspecialchars($categoryname); ?>" selected="selected"><?php echo htmlspecialchars($categoryname); ?></option>
                                <option value="">Show All Category</option>
                                <?php
                                }
                                else
                                {
                                ?>
                                <option selected="selected" value="">Show All Category</option>
                                <?php
                                }
                                ?>
                                <?php
                                $query42 = "select categoryname from master_medicine where status = '' group by categoryname order by categoryname";
                                $exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res42 = mysqli_fetch_array($exec42))
                                {
                                    $categoryname = $res42['categoryname'];
                                ?>
                                <option value="<?php echo htmlspecialchars($categoryname); ?>"><?php echo htmlspecialchars($categoryname); ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="servicename" class="form-label">Item Name</label>
                            <select name="servicename" id="servicename" class="form-select">
                                <option value="">All Items</option>
                                <?php
                                $query42 = "select itemcode, itemname from master_medicine where status <> 'DELETED' and itemcode <> '' order by itemname";
                                $exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res42 = mysqli_fetch_array($exec42))
                                {
                                    $itemcode42 = $res42['itemcode'];
                                    $itemname42 = $res42['itemname'];
                                ?>
                                <option value="<?php echo htmlspecialchars($itemcode42); ?>" <?php if($servicename == $itemcode42) { echo 'selected="selected"'; } ?>><?php echo htmlspecialchars($itemcode42.' - '.$itemname42); ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="itemname" class="form-label">Search Item</label>
                            <input name="itemname" type="text" id="itemname" value="<?php echo htmlspecialchars($searchitemname); ?>" class="form-input" placeholder="Search by item name or code..." autocomplete="off">
                            <input type="hidden" name="searchitem1hiddentextbox" id="searchitem1hiddentextbox">
                            <input type="hidden" name="searchitemcode" id="searchitemcode">
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">As On Date</label>
                            <div class="date-input-group">
                                <input name="ADate2" id="ADate2" value="<?php echo htmlspecialchars($transactiondateto); ?>" class="form-input" readonly onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" class="date-picker-icon" style="cursor:pointer"/>
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                    <input type="hidden" name="frmflag1" value="frmflag1" id="frmflag1">
                    <input type="hidden" name="itemcode2" id="itemcode2" value="<?php echo htmlspecialchars($itemcode); ?>" readonly />
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="reset" class="btn btn-outline">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Results Section -->
            <div class="results-section">
                <div class="results-header">
                    <div class="results-title">Stock Report Results</div>
                    <div class="results-actions">
                        <button type="button" class="btn btn-outline" onclick="printReport()">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Item Code</th>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Formula</th>
                            <th>Batch Number</th>
                            <th>CP</th>
                            <th>Current Stock</th>
                            <th>Inv.Val</th>
                        </tr>
                    </thead>
                    <tbody>
            <?php
			if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
			if (isset($_REQUEST["store"]) && $_REQUEST["store"]!='') { $store = $_REQUEST["store"]; } else { $store = ""; }
			//$categoryname = $_REQUEST['categoryname'];
			if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
			//$frmflag1 = $_REQUEST['frmflag1'];
			if ($frmflag1 == 'frmflag1')
			{
			$colorloopcount = '';
			$sno = '';
			$totalquantity = '';
			$stockdate = '';
			$transactionparticular = '';
			$stockremarks = '';

			$salesquantity = '';
			$salesreturnquantity = '';
			$purchasequantity = '';
			$purchasereturnquantity = '';
			$adjustmentaddquantity = '';
			$adjustmentminusquantity = '';
			$totalsalesquantity = '';
			$totalsalesreturnquantity = '';
			$totalpurchasequantity = '';
			$totalpurchasereturnquantity = '';
			$totaladjustmentaddquantity = '';
			$totaladjustmentminusquantity = '';
			$transferquantity1 = '';
			$transferquantity = '';
			
			$totalpurchaseprice1 = '';
			$totalitemrate1 = '';
			$totalcurrentstock1  = '';
			$grandtotalcogs = '';
			$grandtotalcogs = '0.00';

			$freeqtytot =0;
			
			if($searchitemcode == ''){ $searchcode = $servicename; } else { $searchcode = $searchitemcode; }
			//$query2 = "select * from master_stock where itemcode like '%$itemcode%' and transactiondate <= '$transactiondateto' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";// and cstid='$custid' and cstname='$custname'";
			$rateperunitvar = $location.'_rateperunit';

			if($store=='')
               $store_search = "like '%$store%'";
			else
               $store_search = "='$store'";

			if($categoryname=='')
				$cate_search = "like '%$categoryname%'";
			else
               $cate_search = "='$categoryname'";

			if($searchcode=='')
			{

				$query2 = "select a.auto_number,a.itemcode,a.itemname,a.categoryname,a.`$rateperunitvar`,a.packageanum,a.packagename,a.purchaseprice from master_medicine as a JOIN transaction_stock as b ON a.itemcode = b.itemcode where b.storecode $store_search and a.categoryname $cate_search and  b.recorddate <= '$transactiondateto' group by a.itemcode";
				
				// and companyanum = '$companyanum'";// and cstid='$custid' and cstname='$custname'";
/*				$query2 = "select auto_number,itemcode,itemname,categoryname,`$rateperunitvar`,packageanum,packagename,purchaseprice from master_medicine where categoryname like '%$categoryname%' and status <> 'DELETED'";// and companyanum = '$companyanum'";// and cstid='$custid' and cstname='$custname'";
	*/
			}
			else
			{
				
$query2 = "select a.auto_number,a.itemcode,a.itemname,a.categoryname,a.`$rateperunitvar`,a.packageanum,a.packagename,a.purchaseprice from master_medicine as a JOIN transaction_stock as b ON a.itemcode = b.itemcode where b.storecode $store_search and a.itemcode = '$searchcode' and a.categoryname $cate_search  and b.recorddate <= '$transactiondateto' group by a.itemcode";
				/*
				$query2 = "select auto_number,itemcode,itemname,categoryname,`$rateperunitvar`,packageanum,packagename,purchaseprice from master_medicine where itemcode = '$searchcode' and categoryname like '%$categoryname%' and status <> 'DELETED'";
		*/
			}

			if($searchcode=='' && $store=='' && $transactiondateto>='2020-01-01')
			{
				$chkfree="SELECT sum(free*costprice) as totfree FROM `materialreceiptnote_details` where itemcode!='' and entrydate <= '$transactiondateto' and free>0 and locationcode='$location' ";
				$exec2f = mysqli_query($GLOBALS["___mysqli_ston"], $chkfree) or die ("Error in chkfree".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res2f = mysqli_fetch_array($exec2f);
				$freeqtytot =$res2f['totfree'];
			}

			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num2 = mysqli_num_rows($exec2);
			while ($res2 = mysqli_fetch_array($exec2))
			{
			$res2anum = $res2['auto_number'];
			$itemcode = $res2['itemcode'];
			
			$costprice = $res2['purchaseprice'];
			$res2categoryname = $res2['categoryname'];
			
			
			$query123 = "SELECT itemname,formula FROM master_medicine WHERE itemcode = '$itemcode'";
			$exec123 = mysqli_query($GLOBALS["___mysqli_ston"], $query123) or die ("Error in Query123".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res123 = mysqli_fetch_array($exec123);
			$itemname = "<pre class='bodytext31'>".$res123['itemname']."</pre>";
			
			$itemrate = $res2[$location.'_rateperunit']; //Unit price is calculated below.
			//$stockdate = $res2['transactiondate'];
			//$stockremarks = $res2['remarks'];
			//$transactionparticular = $res2['transactionparticular'];
			$itempackageanum = $res2['packageanum'];
			$res2packagename = $res2['packagename'];
			if($res2packagename == '')
			{
			$res2packagename='1S';
			}
			$res2packagename = stripslashes($res2packagename);
			
			
			$itempackageanum = '14';
			//To calculate price for packaged items to divide by number of items count.
			$query31 = "select quantityperpackage from master_packagepharmacy where auto_number = '$itempackageanum'";
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res31 = mysqli_fetch_array($exec31);
			$quantityperpackage = $res31['quantityperpackage']; //Value called for purchase calc.
			
			@$itemrate = $itemrate / $quantityperpackage;
			$itemrate = number_format($itemrate, 2, '.', '');
			@$itempurchaserate = $purchaseprice / $quantityperpackage;
			$itempurchaserate = number_format($itempurchaserate, 2, '.', '');
			
			$query77 = "select batchnumber from transaction_stock where itemcode='$itemcode' and locationcode='$location' and storecode $store_search and recorddate <= '$transactiondateto' group by batchnumber";
			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res77 = mysqli_fetch_array($exec77))
			{
			$batchnumber = $res77['batchnumber'];
			
			/*$query1 = "select sum(batch_quantity) as currentstock from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$location' and storecode $store_search and batchnumber = '$batchnumber' and recorddate <= '$transactiondateto'";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			$res1 = mysql_fetch_array($exec1);
			$currentstock = $res1['currentstock'];*/

			

			$query33 = "select rate,fifo_code from transaction_stock where itemcode='$itemcode' and locationcode='$location' and batchnumber='$batchnumber' and recorddate <= '$transactiondateto' and storecode $store_search group by rate";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in query33".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numLab1 = mysqli_num_rows($exec33);
			
			$totalcprate=0;
			$currentstock=0;
			$currentstock1 =0;

            if($numLab1>1){
                
                $query33_fifo = "select fifo_code,rate from transaction_stock where itemcode='$itemcode' and locationcode='$location' and batchnumber='$batchnumber' and recorddate <= '$transactiondateto' and storecode $store_search group by fifo_code";
			    $exec33_fifo = mysqli_query($GLOBALS["___mysqli_ston"], $query33_fifo) or die ("Error in query33_fifo".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res33_fifo = mysqli_fetch_array($exec33_fifo))
			    {
                     $fifostocks=0;
					 $fifocode=$res33_fifo["fifo_code"];
					 $rate=$res33_fifo["rate"];

					    $query1 = "select sum(transaction_quantity) as currentstock from transaction_stock where  itemcode='$itemcode' and locationcode='$location' and storecode $store_search and batchnumber = '$batchnumber' and recorddate <= '$transactiondateto' and transactionfunction='1' and fifo_code='".$fifocode."'";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						$currentstock1 = $res1['currentstock'];

						$query1 = "select sum(transaction_quantity) as currentstock from transaction_stock where  itemcode='$itemcode' and locationcode='$location' and storecode $store_search and batchnumber = '$batchnumber' and recorddate <= '$transactiondateto' and transactionfunction='0' and fifo_code='".$fifocode."'";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						$currentstock2 = $res1['currentstock'];

				        $fifostocks = $currentstock1-$currentstock2;
						$currentstock=$currentstock+$fifostocks;

						if($fifostocks>0){
							$cptotal=$fifostocks * $rate;
							$totalcprate=$totalcprate+$cptotal;
						}


				}

				if($currentstock>0)
                   $costprice = $totalcprate/$currentstock;
				else{
					//echo "<br>".$itemcode."-".$batchnumber."-".$totalcprate."-".$currentstock;
					$costprice = 0;

				}

			}else{
				
				$query1 = "select sum(transaction_quantity) as currentstock from transaction_stock where  itemcode='$itemcode' and locationcode='$location' and storecode $store_search and batchnumber = '$batchnumber' and recorddate <= '$transactiondateto' and transactionfunction='1'";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res1 = mysqli_fetch_array($exec1);
				$currentstock1 = $res1['currentstock'];

				$query1 = "select sum(transaction_quantity) as currentstock from transaction_stock where  itemcode='$itemcode' and locationcode='$location' and storecode $store_search and batchnumber = '$batchnumber' and recorddate <= '$transactiondateto' and transactionfunction='0'";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res1 = mysqli_fetch_array($exec1);
				$currentstock2 = $res1['currentstock'];

				$currentstock= $currentstock1-$currentstock2;

				$res33 = mysqli_fetch_array($exec33);
			   
			    $costprice = $res33['rate'];
			}
            
						
			$transferamount =$transferquantity =$totalpurchase =$totalpurchaseamount =$totalsalesquantity =$totalsalesreturn =0;

		/*	$query1 = "select sum(transaction_quantity) as sumpurchase,sum(totalprice) as totalpurchaseamount from transaction_stock where locationcode = '".$location."' AND itemcode = '$itemcode' and storecode $store_search and docstatus='New Batch' and batchnumber = '$batchnumber' and recorddate <= '$transactiondateto'";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			$res1 = mysql_fetch_array($exec1);
			$totalpurchase = $res1['sumpurchase'];
			$totalpurchaseamount = $res1['totalpurchaseamount'];
			
			$query1 = "select sum(transaction_quantity) as sumsales from transaction_stock where locationcode = '".$location."' AND itemcode = '$itemcode' and storecode $store_search and description in('Sales','IP Direct Sales','IP Sales') and batchnumber = '$batchnumber' and recorddate <= '$transactiondateto'";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			$res1 = mysql_fetch_array($exec1);
			$totalsalesquantity = $res1['sumsales'];
			//$totalpurchaseamount = $res1['totalpurchaseamount'];
			
			$query1 = "select sum(transaction_quantity) as sumreturn from transaction_stock where locationcode = '".$location."' AND itemcode = '$itemcode' and storecode $store_search and description in('Sales Return','IP Sales Return') and batchnumber = '$batchnumber' and recorddate <= '$transactiondateto'";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			$res1 = mysql_fetch_array($exec1);
			$totalsalesreturn = $res1['sumreturn'];
			//$totalpurchaseamountreturn = $res1['totalpurchaseamount'];			
			
			$query34 = "select sum(transaction_quantity) as transferquantity,sum(totalprice) as transferamount from transaction_stock where locationcode = '".$location."' AND itemcode = '$itemcode' and storecode $store_search and description = 'Stock Transfer To' and batchnumber = '$batchnumber' and recorddate <= '$transactiondateto'";
			$exec34 = mysql_query($query34) or die(mysql_error());
			$res34 = mysql_fetch_array($exec34);
		    $transferquantity = $res34['transferquantity'];	
			$transferamount = $res34['transferamount'];*/
			
//echo $totalpurchase.'<br>'.$totalsalesquantity.'<br>'.$totalsalesreturn.'<br>'.$transferquantityfrom;
			
			
			
			//$currentstock = $totalpurchase;
			//$currentstock = $currentstock - $totalpurchasereturn;
			//$currentstock = $totalsales;
			/*$currentstock = $currentstock + $totalsalesreturn;
			$currentstock = $currentstock - $totaldccustomer;
			$currentstock = $currentstock + $totaldcsupplier;
			$currentstock = $currentstock + $totalsumadjustmentadd;
			$currentstock = $currentstock - $totalsumadjustmentminus;
			$currentstock = $currentstock - $transferquantity;
			$currentstock = $currentstock + $transferquantity1;
			$currentstock = $currentstock + $transferquantity2;*/
			
			
			if(($totalpurchase == '') && ($transferquantity != ''))
			{
			$totalpurchase = $transferquantity + $transferquantity;
			$totalpurchaseamount = $transferamount + $transferamount;
			}
			
			if ($currentstock > 0)
			{			
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
			
			$sno = $sno + 1;
			//echo $itemrate;
			$totalitemrate = $itemrate * $currentstock;
			$totalitemrate = number_format($totalitemrate, 2, '.', '');
			
			//$totalpurchaseprice = $purchaseprice * $currentstock;
			$totalpurchaseprice = $totalpurchaseamount;
			$totalpurchaseprice = number_format($totalpurchaseprice, 2, '.', '');
			
			$totalcurrentstock1 = $totalcurrentstock1 + $currentstock;
			
			
			if($totalpurchase==0)
			{$purchaseprice= number_format($totalpurchaseprice, 2, '.', '');}
			else
			{
				$purchaseprice = $totalpurchaseprice/intval($totalpurchase);
				$purchaseprice = number_format($purchaseprice, 2, '.', '');
			}
			
			$totalitemrate1 = $totalitemrate1 + $totalitemrate;
			$totalitemrate1 = number_format($totalitemrate1, 2, '.', '');
			
			$totalinventoryvalue = $currentstock * $costprice;
			$totalinventoryvalue = number_format($totalinventoryvalue, 2, '.', '');
		
			
			$totalpurchaseprice1 = $totalpurchaseprice1 + $totalinventoryvalue;
			$totalpurchaseprice1 = number_format($totalpurchaseprice1, 2, '.', '');
			
				
			$cogs = ($totalsalesquantity - $totalsalesreturn)*$costprice;
			
				  
			if($cogs < 0)
			{
			$cogs = 0;
			}
			$grandtotalcogs = $grandtotalcogs + $cogs;
			$cogs = number_format($cogs, 2, '.', '');
			

			?>
                        <tr class="<?php echo ($sno % 2 == 0) ? 'even-row' : 'odd-row'; ?>">
                            <td><?php echo $sno; ?></td>
                            <td><span class="item-code"><?php echo htmlspecialchars($itemcode); ?></span></td>
                            <td><span class="item-name"><?php echo $itemname; ?></span></td>
                            <td><span class="category-badge"><?php echo htmlspecialchars($res2categoryname); ?></span></td>
                            <td><?php echo htmlspecialchars($res123['formula']); ?></td>
                            <td><span class="batch-number"><?php echo htmlspecialchars($batchnumber); ?></span></td>
                            <td class="amount-cell"><?php echo number_format($costprice,2,'.',','); ?></td>
                            <td class="stock-quantity <?php echo ($currentstock <= 0) ? 'stock-out' : (($currentstock <= 10) ? 'stock-low' : 'stock-normal'); ?>">
                                <?php echo $currentstock; ?>
                            </td>
                            <td class="amount-cell amount-positive"><?php echo number_format($totalinventoryvalue,2,'.',','); ?></td>
                        </tr>
            <?php
			$currentstock = '';
			$itemrate = '';
			$totalitemrate = '';
			
			}
			}
			}
			$grandtotalcogs = number_format($grandtotalcogs, 2, '.', '');
			if($totalpurchaseprice1 == '')
			{
			$totalpurchaseprice1 = 0;
			}
			?>
                        <tr class="summary-row">
                            <td colspan="7" class="summary-label">Total Inventory Value</td>
                            <td class="summary-value"><?php echo number_format($totalpurchaseprice1,2,'.',','); ?></td>
                        </tr>
                        <?php if($freeqtytot>0): ?>
                        <tr class="summary-row">
                            <td colspan="7" class="summary-label">Free/Bonus Qty Value</td>
                            <td class="summary-value amount-negative">-<?php echo number_format($freeqtytot,2,'.',',');?></td>
                        </tr>
                        <tr class="summary-row">
                            <td colspan="7" class="summary-label">Final Total</td>
                            <td class="summary-value"><?php echo number_format(($totalpurchaseprice1-$freeqtytot),2,'.',',');?></td>
                        </tr>
                        <?php endif; ?>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Export Actions -->
                <div class="export-actions">
                    <a target="_blank" href="stockreportbyitemxl3.php?categoryname=<?= $categoryname; ?>&&store=<?= $store;?>&&location=<?= $reslocationanum;?>&&searchitemcode=<?= $searchcode;?>&&servicename=<?= $servicename;?>&ADate2=<?php echo $transactiondateto;?>" class="export-btn">
                        <img src="images/excel-xls-icon.png" alt="Excel">
                        Export to Excel
                    </a>
                    <a href="print_itemlabel.php?categoryname=<?= $categoryname_1; ?>&&store=<?= $store;?>&&location=<?= $reslocationanum;?>&&searchitemcode=<?= $searchcode_12;?>&&servicename=<?= $servicename;?>&ADate2=<?php echo $transactiondateto;?>" target="_blank" class="export-btn">
                        <i class="fas fa-tags"></i>
                        Download Item Labels
                    </a>
                </div>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/stockreportbyitem3-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>

