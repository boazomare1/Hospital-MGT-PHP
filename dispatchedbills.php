<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

// Initialize variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$updatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 day'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 day'));
$transactiondateto = date('Y-m-d');

// Initialize form variables
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount = "";
$total = "0.00";

// Handle form parameters with modern isset() checks
$searchaccoutname = isset($_REQUEST["searchaccoutname"]) ? $_REQUEST["searchaccoutname"] : "";
$searchaccoutnameanum = isset($_REQUEST["searchaccoutnameanum"]) ? $_REQUEST["searchaccoutnameanum"] : "";

// Handle location parameters
$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
$locationcode1 = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
 	$query12 = "select locationname from master_location where locationcode='$location' order by locationname";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res12 = mysqli_fetch_array($exec12);
						
						 $locationname1 = $res12["locationname"];

// Handle additional form parameters
$getcanum = isset($_REQUEST["canum"]) ? $_REQUEST["canum"] : "";

if ($getcanum != '') {
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}

$searchsuppliername = isset($_REQUEST["searchsuppliername1"]) ? $_REQUEST["searchsuppliername1"] : "";
$searchsubtypeanum1 = isset($_REQUEST["searchsubtypeanum1"]) ? $_REQUEST["searchsubtypeanum1"] : "";
$cbfrmflag1 = isset($_REQUEST["cbfrmflag1"]) ? $_REQUEST["cbfrmflag1"] : "";
$frmflag2 = isset($_REQUEST["frmflag2"]) ? $_REQUEST["frmflag2"] : "";

// Handle date parameters
$ADate1 = isset($_REQUEST["ADate1"]) ? $_REQUEST["ADate1"] : $transactiondatefrom;
$ADate2 = isset($_REQUEST["ADate2"]) ? $_REQUEST["ADate2"] : $transactiondateto;



$query7 = "select * from completed_billingpaylater order by auto_number desc limit 0, 1";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
$res7 = mysqli_fetch_array($exec7);
$printno = $res7['printno'];
if($printno == '')
{
	$printnumber = '1';
}
else
{
	$printnumber = $printno + 1;
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if (isset($_REQUEST["printno"])) { $printno = $_REQUEST["printno"]; } else { $printno = ""; }
if($st == 'printsuccess')
{
?>
<script>
window.open("print_deliveryreportsubtype1.php?printno=<?php echo $printno; ?>");
window.open("print_deliveryreportsubtype_xl.php?printno=<?php echo $printno; ?>");
</script>
<?php
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dispatched Bills - MedStar Hospital Management</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/vat-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Additional CSS -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <style>
        th {
            background-color: #ffffff;
            position: sticky;
            top: 0;
            z-index: 1;
        }
        .bodytext31:hover { font-size:14px; }
        .bal {
            border-style:none;
            background:none;
            text-align:right;
        }
        .bali {
            text-align:right;
        }
        .ui-menu .ui-menu-item{ zoom:1 !important; }
    </style>
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
        <span>Reports</span>
        <span>→</span>
        <span>Dispatched Bills</span>
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
                        <a href="billing.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>Billing</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="dispatch.php" class="nav-link">
                            <i class="fas fa-truck"></i>
                            <span>Dispatch</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="dispatchedbills.php" class="nav-link">
                            <i class="fas fa-file-invoice"></i>
                            <span>Dispatched Bills</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="reports.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Reports</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="finance.php" class="nav-link">
                            <i class="fas fa-calculator"></i>
                            <span>Finance</span>
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
                    <h2>Dispatched Bills</h2>
                    <p>View and manage all dispatched bills with comprehensive tracking and reporting capabilities.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-download"></i> Export
                    </button>
                    <button type="button" class="btn btn-outline" onclick="printReport()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>

    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>

<script type="text/javascript">
function clickcheck(cat,val)
{
	//alert(cat);
	//alert(val);
	if(cat=='com')
	{
		document.getElementById("misscheck"+val).checked=false;
		document.getElementById("incomcheck"+val).checked=false;
		}
	else if(cat=='incom')
	{
		document.getElementById("comcheck"+val).checked=false;
		document.getElementById("misscheck"+val).checked=false;
		}
	else 
	{
		document.getElementById("comcheck"+val).checked=false;
		document.getElementById("incomcheck"+val).checked=false;
		}
	}

function ajaxlocationfunction(val)
{ 
if (window.XMLHttpRequest)
					  {// code for IE7+, Firefox, Chrome, Opera, Safari
					  xmlhttp=new XMLHttpRequest();
					  }
					else
					  {// code for IE6, IE5
					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					  }
					xmlhttp.onreadystatechange=function()
					  {
					  if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;
						}
					  }
					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);
					xmlhttp.send();
}
					
//ajax to get location which is selected ends here


window.onload = function () 
{
	//var oTextbox = new AutoSuggestControl1(document.getElementById("searchsuppliername1"), new StateSuggestions1());
	
}
</script>
<script>
function funcAccount1()
{
if((document.getElementById("searchsuppliername").value == "")||(document.getElementById("searchsuppliername").value == " "))
{
alert ('Please Select Account Name');
return false;
}
}
function calprint(){

if((document.getElementById("searchsubtypeanum1").value == ""))
{
alert ('Please Select Sub Type.');
document.getElementById("searchsuppliername1").focus();
return false;
}

if(document.querySelector('input[name="types"]:checked').value==1){
window.open("print_deliverysubpdf2.php?subtype="+document.getElementById("searchsubtypeanum1").value+"&ADate1="+document.getElementById("ADate1").value+'&ADate2='+document.getElementById("ADate2").value+'',"_blank");
}
else{
window.open("print_deliverysubpdf2xl.php?subtype="+document.getElementById("searchsubtypeanum1").value+"&ADate1="+document.getElementById("ADate1").value+'&ADate2='+document.getElementById("ADate2").value+'',"_blank");
}
return false;
}
</script>
<script language="javascript">

function cbsuppliername1()
{
	document.cbform1.submit();
}

</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.bali
{
text-align:right;
}
.ui-menu .ui-menu-item{ zoom:1 !important; }

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma;}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.imgloader { background-color:#FFFFFF; }
#imgloader1 {
    position: absolute;
    top: 158px;
    left: 487px;
    width: 28%;
    height: 24%;
}
</style>



            <!-- Loading Overlay -->
            <div class="loading-overlay" id="imgloader" style="display:none;">
                <div class="loading-content">
                    <div class="loading-spinner"></div>
                    <p id='claim_msg'></p>
                    <p><strong>Processing</strong></p>
                    <p>Please be patient...</p>
                </div>
            </div>

            <!-- Search Form -->
            <form name="cbform1" method="post" action="" class="search-form">
                <div class="form-section">
                    <div class="form-section-header">
                        <i class="fas fa-search form-section-icon"></i>
                        <h3 class="form-section-title">Search Dispatched Bills</h3>
                    </div>
                    
                    <div class="form-section-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="ADate1" class="form-label">Date From</label>
                                <input name="ADate1" id="ADate1" value="<?php echo $ADate1; ?>" class="form-input" size="10" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <i class="fas fa-calendar-alt" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer; margin-left: 5px;"></i>
                            </div>
                            
                            <div class="form-group">
                                <label for="ADate2" class="form-label">Date To</label>
                                <input name="ADate2" id="ADate2" value="<?php echo $ADate2; ?>" class="form-input" size="10" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <i class="fas fa-calendar-alt" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer; margin-left: 5px;"></i>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="location" class="form-label">Location</label>
                                <select name="location" id="location" class="form-input" onChange="ajaxlocationfunction(this.value);">
                                    <option value="">ALL</option>
                                    <?php
                                    $query1 = "select * from master_employeelocation where username='$username' group by locationname order by locationname asc";
                                    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while ($res1 = mysqli_fetch_array($exec1)) {
                                        $res1location = $res1["locationname"];
                                        $res1locationanum = $res1["locationcode"];
                                    ?>
                                        <option value="<?php echo $res1locationanum; ?>" <?php if($location!='')if($location==$res1locationanum){echo "selected";}?>><?php echo $res1location; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                                <button type="submit" class="btn btn-primary" name="Submit">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                <button name="resetbutton" type="reset" id="resetbutton" class="btn btn-secondary">
                                    <i class="fas fa-undo"></i> Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Results Section -->
			<?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
				if($locationcode1==''){
					$locationcodenew= "and locationcode like '%%'";
				}else{
					$locationcodenew= "and locationcode = '$locationcode1'";
				}
				$query24 = "select * from completed_billingpaylater where date(updatedate) between '$ADate1' and '$ADate2' $locationcodenew order by updatedate desc";
			?>

            <!-- Data Table Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <h3 class="data-table-title">Dispatched Bills Results</h3>
                    <div class="data-table-actions">
                        <a target="_blank" href="print_dispatchedbills.php?cbfrmflag1=cbfrmflag1&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&locationcode=<?php echo $locationcode1; ?>" class="btn btn-outline">
                            <i class="fas fa-file-excel"></i> Export to Excel
                        </a>
                    </div>
                </div>
                
                <table class="data-table">
                    <thead class="table-header">
                        <tr>
                            <th class="table-header-cell">Sno</th>
                            <th class="table-header-cell">Batch</th>
                            <th class="table-header-cell">Bill No</th>
                            <th class="table-header-cell">Bill Date</th>
                            <th class="table-header-cell">Patient Name</th>
                            <th class="table-header-cell">Patient Code</th>
                            <th class="table-header-cell">Subtype</th>
                            <th class="table-header-cell">Account</th>
                            <th class="table-header-cell text-right">Bill Amount</th>
                            <th class="table-header-cell">Dispatched By</th>
                            <th class="table-header-cell">Dispatched Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        
						<?php
						
						
						$colorloopcount = 0;
						$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
		                while($res24 = mysqli_fetch_array($exec24)) {
							
						$patientcode=$res24['patientcode'];
						$visitcode=$res24['visitcode'];
						
						$querylab1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_visitentry where visitcode='$visitcode' and patientcode='$patientcode'");
						$execlab1=mysqli_fetch_array($querylab1);
						$scheme_id=$execlab1['scheme_id'];
						
						$queryplan=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_planname where scheme_id='$scheme_id'");
						$execplan=mysqli_fetch_array($queryplan);
						$scheme_name=$execplan['scheme_name'];
							

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
                        <tr class="<?php echo ($colorloopcount % 2 == 0) ? 'table-row-even' : 'table-row-odd'; ?>">
                            <td class="table-cell"><?php echo $colorloopcount; ?></td>
                            <td class="table-cell"><?php echo $res24['printno']; ?></td>
                            <td class="table-cell"><?php echo $res24['billno']; ?></td>
                            <td class="table-cell"><?php echo $res24['billdate']; ?></td>
                            <td class="table-cell"><?php echo $res24['patientname']; ?></td>
                            <td class="table-cell"><?php echo $res24['patientcode']; ?></td>
                            <td class="table-cell"><?php echo $res24['subtype']; ?></td>
                            <td class="table-cell"><?php echo $scheme_name; ?></td>
                            <td class="table-cell text-right"><?php echo number_format($res24['totalamount'],2,'.',','); ?></td>
                            <td class="table-cell"><?php echo $res24['username']; ?></td>
                            <td class="table-cell"><?php echo $res24['updatedate']; ?></td>
                        </tr>
					   <?php } ?>


                    </tbody>
                </table>
            </div>
            <?php } ?>
        </main>
    </div>

    <!-- Modern JavaScript Functions -->
    <script>
        // Sidebar toggle functionality
        function toggleSidebar() {
            const sidebar = document.getElementById('leftSidebar');
            const toggle = document.querySelector('.sidebar-toggle i');
            
            sidebar.classList.toggle('collapsed');
            toggle.classList.toggle('fa-chevron-left');
            toggle.classList.toggle('fa-chevron-right');
        }

        // Page refresh function
        function refreshPage() {
            window.location.reload();
        }

        // Export to Excel function
        function exportToExcel() {
            // Add export functionality here
            alert('Export functionality will be implemented');
        }

        // Print report function
        function printReport() {
            window.print();
        }

        // Initialize sidebar toggle on menu button click
        document.getElementById('menuToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('leftSidebar');
            sidebar.classList.toggle('show');
        });

        // Close sidebar when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('leftSidebar');
            const menuToggle = document.getElementById('menuToggle');
            
            if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                sidebar.classList.remove('show');
            }
        });
    </script>

    <!-- JavaScript for functionality -->
    <script type="text/javascript">
        function clickcheck(cat,val) {
            if(cat=='com') {
                document.getElementById("misscheck"+val).checked=false;
                document.getElementById("incomcheck"+val).checked=false;
            } else if(cat=='incom') {
                document.getElementById("comcheck"+val).checked=false;
                document.getElementById("misscheck"+val).checked=false;
            } else {
                document.getElementById("comcheck"+val).checked=false;
                document.getElementById("incomcheck"+val).checked=false;
            }
        }

        function ajaxlocationfunction(val) { 
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("ajaxlocation").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "ajax/ajaxgetlocationname.php?loccode=" + val, true);
            xmlhttp.send();
        }

        window.onload = function () {
            // Initialize any required functionality
        }

        function funcAccount1() {
            if((document.getElementById("searchsuppliername").value == "")||(document.getElementById("searchsuppliername").value == " ")) {
                alert('Please Select Account Name');
                return false;
            }
        }

        function calprint() {
            if((document.getElementById("searchsubtypeanum1").value == "")) {
                alert('Please Select Sub Type.');
                document.getElementById("searchsuppliername1").focus();
                return false;
            }

            if(document.querySelector('input[name="types"]:checked').value==1) {
                window.open("print_deliverysubpdf2.php?subtype="+document.getElementById("searchsubtypeanum1").value+"&ADate1="+document.getElementById("ADate1").value+'&ADate2='+document.getElementById("ADate2").value+'',"_blank");
            } else {
                window.open("print_deliverysubpdf2xl.php?subtype="+document.getElementById("searchsubtypeanum1").value+"&ADate1="+document.getElementById("ADate1").value+'&ADate2='+document.getElementById("ADate2").value+'',"_blank");
            }
            return false;
        }

        function cbsuppliername1() {
            document.cbform1.submit();
        }
    </script>

</body>
</html>
