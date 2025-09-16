<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

// Initialize variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

// Date variables
$paymentreceiveddatefrom = date('Y-m-d');
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');

// Report variables
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount = "";
$range = "";
$res1suppliername = '';
$total1 = '0.00';
$total2 = '0.00';
$total3 = '0.00';
$total4 = '0.00';
$total5 = '0.00';
$total6 = '0.00';

//This include updatation takes too long to load for hunge items database.

//include ("autocompletebuild_customer2.php");



// Handle form parameters with modern isset() checks
$slocation = isset($_REQUEST["slocation"]) ? $_REQUEST["slocation"] : "";
$searchsuppliername = isset($_REQUEST["searchsuppliername"]) ? $_REQUEST["searchsuppliername"] : "";
$ADate1 = isset($_REQUEST["ADate1"]) ? $_REQUEST["ADate1"] : "";
$ADate2 = isset($_REQUEST["ADate2"]) ? $_REQUEST["ADate2"] : "";
$range = isset($_REQUEST["range"]) ? $_REQUEST["range"] : "";
$amount = isset($_REQUEST["amount"]) ? $_REQUEST["amount"] : "";
$cbfrmflag2 = isset($_REQUEST["cbfrmflag2"]) ? $_REQUEST["cbfrmflag2"] : "";
$frmflag2 = isset($_REQUEST["frmflag2"]) ? $_REQUEST["frmflag2"] : "";

// Update date variables if form submitted
if ($ADate1 != "") {
    $paymentreceiveddatefrom = $ADate1;
}
if ($ADate2 != "") {
    $paymentreceiveddateto = $ADate2;
}





?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Activity Detail Report - MedStar Hospital Management</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/vat-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .ui-menu .ui-menu-item { zoom: 1.6 !important; }
        .bal { border-style: none; background: none; text-align: right; }
        .bali { text-align: right; }
        .style1 { font-weight: bold; font-size: 11px; color: #3b3b3c; font-family: Tahoma; text-decoration: none; }
    </style>

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<script src="js/datetimepicker_css.js"></script>





 

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 





<script src="js/jquery-1.11.1.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/autocomplete.css">

<link rel="stylesheet" type="text/css" href="css/style.css">

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>
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
        <span>Doctor Activity Detail Report</span>
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
                        <a href="reports.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Reports</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="doctorsactivityreportdetaiview.php" class="nav-link">
                            <i class="fas fa-user-md"></i>
                            <span>Doctor Activity Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billing.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>Billing</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="masterdata.php" class="nav-link">
                            <i class="fas fa-database"></i>
                            <span>Master Data</span>
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
                    <h2>Doctor Activity Detail Report</h2>
                    <p>Generate comprehensive reports on doctor activities, consultations, and patient interactions.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-file-excel"></i> Export
                    </button>
                </div>
            </div>

  <script>



$(function() {



$('#cbcustomername').autocomplete({

		 

	source:'ajaxdoctorsearch.php', 



	minLength:3,

	delay: 0,	

	html: true, 

		select: function(event,ui){

			var customercode=ui.item.auto_number;

			var username=ui.item.username;

				$('#cbcustomercode').val(customercode);

				$('#usernamenew').val(username);

			}

    });

});

</script>    

<style type="text/css">



.ui-menu .ui-menu-item{ zoom:1.6 !important; }

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

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

.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

</style>

</head>







<body>

            <!-- Search Form -->
            <form name="cbform1" method="post" action="doctorsactivityreportdetaiview.php" class="form-section">
                <div class="form-section-header">
                    <i class="fas fa-search form-section-icon"></i>
                    <h3 class="form-section-title">Search Criteria</h3>
                    <span class="form-section-subtitle">Enter search parameters to generate the report</span>
                </div>
                
                <div class="form-section-form">

                    <div class="form-row">
                        <div class="form-group">
                            <label for="cbcustomername" class="form-label">Doctor/User</label>
                            <input name="cbcustomername" type="text" id="cbcustomername" class="form-input" value="" placeholder="Search for doctor or user" autocomplete="off" />
                            <input name="cbcustomercode" type="hidden" id="cbcustomercode" value="" />
                            <input name="usernamenew" type="hidden" id="usernamenew" value="" />
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <div class="form-input-group">
                                <input name="ADate1" id="ADate1" class="form-input" value="<?php echo $paymentreceiveddatefrom; ?>" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <i class="fas fa-calendar-alt" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"></i>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <div class="form-input-group">
                                <input name="ADate2" id="ADate2" class="form-input" value="<?php echo $paymentreceiveddateto; ?>" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <i class="fas fa-calendar-alt" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="searchsuppliercode" id="searchsuppliercode" value="<?php echo $searchsuppliercode; ?>" />
                        <input type="hidden" name="cbfrmflag2" value="cbfrmflag1" />
                        <button type="submit" name="Submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </div>
            </form>

            <!-- Results Section -->
            <?php if($cbfrmflag2 == 'cbfrmflag1'){ ?>
            <div class="data-table-section">
                <div class="data-table-header">
                    <h3 class="data-table-title">Doctor Activity Report Results</h3>
                </div>
                
                <div class="table-container">
                    <table class="data-table">
                        <thead class="table-header">
                            <tr>
                                <th class="table-header-cell">No.</th>
                                <th class="table-header-cell">Patient Name</th>
                                <th class="table-header-cell">Reg.Code</th>
                                <th class="table-header-cell">Visit Code</th>
                                <th class="table-header-cell">Visit Date</th>
                                <th class="table-header-cell">Visit By</th>
                                <th class="table-header-cell">Assgn Doc</th>
                                <th class="table-header-cell">Doc. Code</th>
                                <th class="table-header-cell text-right">Cons. Fee</th>
                                <th class="table-header-cell">Department</th>
                                <th class="table-header-cell">Triaged By</th>
                                <th class="table-header-cell">Consulted By</th>
                                <th class="table-header-cell">Pharmacy By</th>
                                <th class="table-header-cell">Sampled By</th>
                                <th class="table-header-cell">Service By</th>
                                <th class="table-header-cell">Radiology By</th>
                            </tr>
                        </thead>
                        <tbody>

			

			<?php

			

		 	$cbcustomercode=isset($_REQUEST['cbcustomercode'])?$_REQUEST['cbcustomercode']:'';

			$cbcustomername=$_REQUEST['usernamenew'];

		 	$cbcustomername=trim($cbcustomername); 

			

	if($slocation!=''){

		    $query44 = "select username from master_consultationlist where username like '%$cbcustomername%' and locationcode='$slocation' and date between '$ADate1' and '$ADate2' group by username"; 

	}

	else

	{

			    $query44 = "select username from master_consultationlist where username like '%$cbcustomername%' and date between '$ADate1' and '$ADate2' group by username"; 

	}

		  $exec44= mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die ("Error in Query44".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $numcount=mysqli_num_rows($exec44); 

		  while($res44 = mysqli_fetch_array($exec44))

			{

		  $doctorcheck= $res44['username'];   

		  

		  ?>

          <tr <?php //echo $colorcode; ?>>

				<td class="bodytext31" valign="center"  colspan="5" align="left"><strong>

				

				<?php

							$query02="select employeename from master_employee where username='$doctorcheck'";

				$exec02=mysqli_query($GLOBALS["___mysqli_ston"], $query02);

				$res02=mysqli_fetch_array($exec02);

				if($res02['employeename']!='')

				{

					 $doctorname=$res02['employeename'];

				}

	

				?>

				<?php echo strtoupper($doctorname); ?></strong>

                

                </td>

                </tr>

          <?php

		  

			if($slocation!=''){

		   $query4 = "select * from master_consultationlist where username ='$doctorcheck' and locationcode='$slocation' and date between '$ADate1' and '$ADate2' group by visitcode"; 

			}

			else

			{

		  $query4 = "select * from master_consultationlist where username ='$doctorcheck' and date between '$ADate1' and '$ADate2' group by visitcode"; 

				

			}

		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $numcount=mysqli_num_rows($exec4);

		  while($res4 = mysqli_fetch_array($exec4))

			{

				$patientname= $res4['patientfirstname'];

				$patientmiddlename= $res4['patientmiddlename'];

				$patientlastname= $res4['patientlastname'];

				$patientcode= $res4['patientcode'];

				$visitcode= $res4['visitcode'];

				$consultingdoctor= $res4['username'];

				

/*		  $query5 = "select a.visitcode,a.consultationdate as consultationdate,a.username as visitby,b.visitcode,b.user as triageby,a.visitcode, c.username as pharmacyby from master_visitentry a, master_triage b,pharmacysales_details c where (a.visitcode = '$visitcode') and  (b.visitcode = '$visitcode') and  (c.visitcode = '$visitcode')"; 

*/		  

  $query5 = "select a.visitcode,a.consultationdate as consultationdate,a.consultingdoctor,a.consultingdoctorcode,a.departmentname,a.consultationfees,a.username as visitby,b.visitcode,b.user as triageby,c.visitcode, c.username as pharmacyby,

  d.patientvisitcode, d.username as sampleby,e.patientvisitcode, e.username as serviceby,f.patientvisitcode, f.username as radiologyby from master_visitentry as a  LEFT JOIN master_triage as b ON a.visitcode=b.visitcode LEFT JOIN pharmacysales_details as c  ON a.visitcode=c.visitcode LEFT JOIN samplecollection_lab as d ON a.visitcode=d.patientvisitcode LEFT JOIN consultation_services as e ON a.visitcode=e.patientvisitcode LEFT JOIN resultentry_radiology as f ON a.visitcode=f.patientvisitcode where a.visitcode = '$visitcode' "; 

  

  		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res5 = mysqli_fetch_array($exec5);	

				$visitdate= $res5['consultationdate'];

				$visitby= $res5['visitby'];

				$triagedby= $res5['triageby'];

				$pharmacyby= $res5['pharmacyby'];

				$sampleby= $res5['sampleby'];

				$serviceby= $res5['serviceby'];

				$radiologyby= $res5['radiologyby'];

				$doctorname = $res5['consultingdoctor'];

				$doctorcode = $res5['consultingdoctorcode'];

				$department = $res5['departmentname'];

				$consultationfees = $res5['consultationfees'];

			//echo	$count= $res5['count'];

			

						

				

			

				$snocount=$snocount+1;

				//echo $cashamount;

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
                                <td class="table-cell"><?php echo $snocount; ?></td>
                                <td class="table-cell"><?php echo $patientname.' '.$patientmiddlename.' '.$patientlastname; ?></td>
                                <td class="table-cell"><?php echo $patientcode; ?></td>
                                <td class="table-cell">
                                    <a target="_blank" href="emrcasesheet.php?visitcode=<?php echo $visitcode; ?>" class="btn btn-sm btn-outline">
                                        <i class="fas fa-external-link-alt"></i> <?php echo $visitcode; ?>
                                    </a>
                                </td>
                                <td class="table-cell"><?php echo $visitdate; ?></td>
                                <td class="table-cell"><?php echo $visitby; ?></td>
                                <td class="table-cell"><?php echo $doctorname; ?></td>
                                <td class="table-cell"><?php echo $doctorcode; ?></td>
                                <td class="table-cell text-right"><?php echo number_format($consultationfees, 2, '.', ','); ?></td>
                                <td class="table-cell"><?php echo $department; ?></td>
                                <td class="table-cell"><?php echo $triagedby; ?></td>
                                <td class="table-cell"><?php echo $consultingdoctor; ?></td>
                                <td class="table-cell"><?php echo $pharmacyby; ?></td>
                                <td class="table-cell"><?php echo $sampleby; ?></td>
                                <td class="table-cell"><?php echo $serviceby; ?></td>
                                <td class="table-cell"><?php echo $radiologyby; ?></td>
                            </tr>

			<?php

			}}

			?>

                        </tbody>
                    </table>
                </div>
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

        // Reset form function
        function resetForm() {
            document.getElementById('cbform1').reset();
        }

        // Export to Excel function
        function exportToExcel() {
            // Add export functionality here
            alert('Export functionality will be implemented');
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

</body>
</html>

