<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

if (isset($_REQUEST["slocation"])) { $slocation = $_REQUEST["slocation"]; } else { $slocation = ""; }
if (isset($_REQUEST["ADate1"])) {  $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = date('Y-m-d'); }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petty Cash Disburse - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/vat-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Additional CSS -->
    <link rel="stylesheet" type="text/css" href="css/autocomplete.css">
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css">
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css">
</head>

<script language="javascript">

$(document).ready(function(){
	
	$('#empname').autocomplete({
		
	source:"ajaxuser_search.php",
	//alert(source);
	matchContains: true,
	minLength:1,
	html: true, 
		select: function(event,ui){
			var userid=ui.item.usercode;
			var username=ui.item.username;

			$("#empcode").val(userid);
			$("#selectedempname").val(username);
	
			},
    
	});
		
});



function additem1process1()
{
	//alert ("Inside Funtion");
	if (document.form1.categoryname.value == "")
	{	
		alert ("Please Select Category Name.");
		document.form1.categoryname.focus();
		return false;
	}
	if (document.form1.itemcode.value == "")
	{	
		alert ("Please Enter lab Item Code or ID.");
		document.form1.itemcode.focus();
		return false;
	}
	if (document.form1.itemcode.value != "")
	{}
	if (document.form1.itemname.value == "")
	{
		alert ("Pleae Enter Lab Item Name.");
		document.form1.itemname.focus();
		return false;
	}
	
	
	
	
	
	/*
	if (document.form1.itemname_abbreviation.value == "")
	{
		alert ("Pleae Select Unit Name.");
		document.form1.itemname_abbreviation.focus();
		return false;
	}
	*/
	if (document.form1.purchaseprice.value == "")
	{	
		alert ("Please Enter Purchase Price Per Unit.");
		document.form1.purchaseprice.focus();
		return false;
	}
	if (document.form1.rateperunit.value == "")
	{	
		alert ("Please Enter Selling Price Per Unit.");
		document.form1.rateperunit.focus();
		return false;
	}
	if (isNaN(document.form1.rateperunit.value) == true)
	{	
		alert ("Please Enter Rate Per Unit In Numbers.");
		document.form1.rateperunit.focus();
		return false;
	}


}

/*
function process1()
{
	//alert (document.form1.itemname.value);
	if (document.form1.itemname_abbreviation.value == "SR")
	{
		document.getElementById('expiryperiod').style.visibility = '';
	}
	else
	{
		document.getElementById('expiryperiod').style.visibility = 'hidden';
	}
}
*/
function spl()
{
	var data=document.form1.itemname.value ;
	//alert(data);
	// var iChars = "!%^&*()+=[];,.{}|\:<>?~"; //All special characters.
	var iChars = "!^+=[];,{}|\<>?~"; 
	for (var i = 0; i < data.length; i++) 
	{
		if (iChars.indexOf(data.charAt(i)) != -1) 
		{
			alert ("Your lab Item Name Has Special Characters. Like ! ^ + = [ ] ; , { } | \ < > ? ~ These are not allowed.");
			return false;
		}
	}
}
 
 
function process2()
{
	//document.getElementById('expiryperiod').style.visibility = 'hidden';
}

function process1backkeypress1()
{
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}
	
	if(key == 13) // if enter key press
	{
		return false;
	}
	else
	{
		return true;
	}

}
function adddata(a){
	
	
	var amount=$('#amount').val();
	
	var doc=$('#doc').val();
	 var selValue = $('input[name=action]:checked').val(); 
	alert(amount);
	alert(doc);
	alert(selValue);
	var data = 'amount='+amount+'&&doc='+doc+'&&selValue='+selValue;
	$.ajax({
		type : "POST",
		url : "pettyupdate.php",
		data : data,
		cache:false,
		success: function(data){
			//alert(data); 
			location.reload();
		}
		
	});	
	}


</script>
<body onLoad="return process2()">
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
        <span>Petty Cash Disburse</span>
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
                        <a href="pettycash_request.php" class="nav-link">
                            <i class="fas fa-plus"></i>
                            <span>New Request</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pettycash_approval.php" class="nav-link">
                            <i class="fas fa-check"></i>
                            <span>Approvals</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="pettycash_disburse.php" class="nav-link">
                            <i class="fas fa-list-alt"></i>
                            <span>Disburse List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="financial_reports.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Financial Reports</span>
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
                    <h2>Petty Cash Disburse List</h2>
                    <p>View and manage petty cash disbursement records by date range and location.</p>
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
            <div class="add-form-section">
                <div class="add-form-header">
                    <i class="fas fa-search add-form-icon"></i>
                    <h3 class="add-form-title">Search Disbursement Records</h3>
                </div>
                
                <form method="post" class="add-form">
                    <div class="form-group">
                        <label for="ADate1" class="form-label">Start Date</label>
                        <div class="date-input-group">
                            <input name="ADate1" id="ADate1" class="form-input" value="<?php echo $ADate1; ?>" readonly onKeyDown="return disableEnterKey()" />
                            <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer" class="date-picker-icon"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="ADate2" class="form-label">End Date</label>
                        <div class="date-input-group">
                            <input name="ADate2" id="ADate2" class="form-input" value="<?php echo $ADate2; ?>" readonly onKeyDown="return disableEnterKey()" />
                            <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer" class="date-picker-icon"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="slocation" class="form-label">Location</label>
                        <select name="slocation" id="slocation" class="form-input">
                            <option value="All">All Locations</option>
                            <?php
                            $query01="select locationcode,locationname from master_employeelocation where username='$username' group by locationcode";
                            $exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
                            while($res01=mysqli_fetch_array($exc01))
                            {?>
                                <option value="<?= $res01['locationcode'] ?>" <?php if($slocation==$res01['locationcode']){ echo "selected";} ?>><?= $res01['locationname'] ?></option>		
                            <?php 
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" id="submitBtn" class="submit-btn">
                            <i class="fas fa-search"></i>
                            Search Records
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>

                    <input type="hidden" name="frmflag" value="addnew">
                    <input type="hidden" name="frmflag1" value="frmflag1">
                </form>
            </div>
        
            <?php 
            if (isset($_REQUEST["frmflag1"])) {  
                $frmflag1 = $_REQUEST["frmflag1"]; 
            } else { 
                $frmflag1 = ""; 
            } 
            
            if ($frmflag1 == 'frmflag1') {
                if (isset($_REQUEST["empname"])) { $user = $_REQUEST["empname"]; } else { $user = ""; }
                if (isset($_REQUEST["request"])) { $request= $_REQUEST["request"]; } else { $request = ""; }

                $startdate=$_REQUEST['ADate1'];
                $enddate=$_REQUEST['ADate2'];
                $sno=0;
                
                // Data Table Section
                ?>
                <div class="data-table-section">
                    <div class="data-table-header">
                        <i class="fas fa-list data-table-icon"></i>
                        <h3 class="data-table-title">Disbursement Records</h3>
                        <div class="data-table-actions">
                            <a href="petty_disburse_excel.php?slocation=<?php echo $slocation; ?>&&startdate=<?php echo $ADate1; ?>&&enddate=<?php echo $ADate2; ?>" class="btn btn-outline">
                                <i class="fas fa-download"></i> Export Excel
                            </a>
                        </div>
                    </div>
                    
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Location</th>
                                    <th>Doc No</th>
                                    <th>Date</th>
                                    <th>Approved Amount</th>
                                    <th>Disburse Amount</th>
                                    <th>Remarks</th>
                                    <th>Disburse By</th>
                                </tr>
                            </thead>
                            <tbody>
			
							<?php
							if($slocation=='All')
							{
								$query01="select locationcode,locationname from master_employeelocation where username='$username' group by locationcode";
								$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
								while($res01=mysqli_fetch_array($exc01))
								{
									$locationcode1=$res01['locationcode'];
									$querry=" select * from pcrequest where currentdate between '$startdate' and '$enddate' and delete_status <>'deleted' and approved_status ='3' and final_status='completed' and locationcode='$locationcode1' ORDER BY `pcrequest`.`doc_no` ASC ";
									
									$exe=mysqli_query($GLOBALS["___mysqli_ston"], $querry);  
									$colorloopcount=0;
									while($result=mysqli_fetch_array($exe)){
										$sno=$sno+1;
										$date=$result['currentdate'];
										$amount=$result['amount'];
										$approved_amt=$result['approved_amt'];
										$remarks=$result['remarks'];
										$requestedby_user=$result['username'];
										$second_approvel_user=$result['second_approvel_user'];
										$doc_no=$result['doc_no'];
										$locationname=$result['locationname'];
										
										$query018="select username from master_journalentries where pcdocno='$doc_no'";
										$exc018=mysqli_query($GLOBALS["___mysqli_ston"], $query018);
										$res018=mysqli_fetch_array($exc018);
										$disby=$res018['username'];
										
										$colorloopcount = $colorloopcount + 1;
										$showcolor = ($colorloopcount & 1);   
										
										$rowClass = ($showcolor == 0) ? 'even-row' : 'odd-row';
									?>
                                <tr class="<?php echo $rowClass; ?>">
                                    <td><?php echo $sno; ?></td>
                                    <td><?php echo $locationname; ?></td>
                                    <td>
                                        <input type="hidden" name="doc" id="doc" value="<?php echo $doc_no; ?>">
                                        <?php echo $doc_no; ?>
                                    </td>
                                    <td><?php echo date('d/m/Y',strtotime($date)); ?></td>
                                    <td class="amount-cell">
                                        <input type="hidden" name="amount" id="amount" value="<?php echo number_format($amount); ?>">
                                        <?php echo number_format($amount,2,'.',','); ?>
                                    </td>
                                    <td class="amount-cell">
                                        <input type="hidden" name="aamount" id="aamount" value="<?php echo number_format($approved_amt); ?>">
                                        <?php echo number_format($approved_amt,2,'.',','); ?>
                                    </td>
                                    <td class="remarks-cell"><?php echo $remarks; ?></td>
                                    <td><?php echo ucwords($disby); ?></td>
                                </tr>
									<?php } 
								}
							} else {
								$querry=" select * from pcrequest where currentdate between '$startdate' and '$enddate' and delete_status <>'deleted' and approved_status ='3' and final_status='completed' and locationcode='$slocation' ORDER BY `pcrequest`.`doc_no` ASC ";
								
								$exe=mysqli_query($GLOBALS["___mysqli_ston"], $querry);
								
								$colorloopcount=0;
								while($result=mysqli_fetch_array($exe)){
									$sno=$sno+1;
									$date=$result['currentdate'];
									$amount=$result['amount'];
									$approved_amt=$result['approved_amt'];
									$remarks=$result['remarks'];
									$requestedby_user=$result['username'];
									$second_approvel_user=$result['second_approvel_user'];
									$doc_no=$result['doc_no'];
									$locationname=$result['locationname'];
									
									$query018="select username from master_journalentries where pcdocno='$doc_no'";
									$exc018=mysqli_query($GLOBALS["___mysqli_ston"], $query018);
									$res018=mysqli_fetch_array($exc018);
									$disby=$res018['username'];
									
									$colorloopcount = $colorloopcount + 1;
									$showcolor = ($colorloopcount & 1);   
									
									$rowClass = ($showcolor == 0) ? 'even-row' : 'odd-row';
								?>
                                <tr class="<?php echo $rowClass; ?>">
                                    <td><?php echo $sno; ?></td>
                                    <td><?php echo $locationname; ?></td>
                                    <td>
                                        <input type="hidden" name="doc" id="doc" value="<?php echo $doc_no; ?>">
                                        <?php echo $doc_no; ?>
                                    </td>
                                    <td><?php echo date('d/m/Y',strtotime($date)); ?></td>
                                    <td class="amount-cell">
                                        <input type="hidden" name="amount" id="amount" value="<?php echo number_format($amount); ?>">
                                        <?php echo number_format($amount,2,'.',','); ?>
                                    </td>
                                    <td class="amount-cell">
                                        <input type="hidden" name="aamount" id="aamount" value="<?php echo number_format($approved_amt); ?>">
                                        <?php echo number_format($approved_amt,2,'.',','); ?>
                                    </td>
                                    <td class="remarks-cell"><?php echo $remarks; ?></td>
                                    <td><?php echo ucwords($disby); ?></td>
                                </tr>
                                <?php }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } ?>
        </main>
    </div>

    <!-- JavaScript -->
    <script src="js/jquery.min-autocomplete.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    
    <!-- Modern JavaScript -->
    <script>
        // Sidebar toggle functionality
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('leftSidebar');
            const mainContent = document.querySelector('.main-content');
            
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
            
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-chevron-left');
            icon.classList.toggle('fa-chevron-right');
        });

        // Mobile menu toggle
        document.getElementById('menuToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('leftSidebar');
            sidebar.classList.toggle('mobile-open');
        });

        // Form reset function
        function resetForm() {
            document.querySelector('.add-form').reset();
        }

        // Refresh page function
        function refreshPage() {
            window.location.reload();
        }

        // Export to Excel function
        function exportToExcel() {
            const form = document.createElement('form');
            form.method = 'GET';
            form.action = 'petty_disburse_excel.php';
            
            const locationInput = document.createElement('input');
            locationInput.type = 'hidden';
            locationInput.name = 'slocation';
            locationInput.value = document.getElementById('slocation').value;
            
            const startDateInput = document.createElement('input');
            startDateInput.type = 'hidden';
            startDateInput.name = 'startdate';
            startDateInput.value = document.getElementById('ADate1').value;
            
            const endDateInput = document.createElement('input');
            endDateInput.type = 'hidden';
            endDateInput.name = 'enddate';
            endDateInput.value = document.getElementById('ADate2').value;
            
            form.appendChild(locationInput);
            form.appendChild(startDateInput);
            form.appendChild(endDateInput);
            
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 300);
            });
        }, 5000);
    </script>
</body>
</html>

