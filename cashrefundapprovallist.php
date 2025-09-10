<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
if(isset($_POST['ADate1'])){$fromdate = $_POST['ADate1'];}else{$fromdate=$transactiondatefrom;}
if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate=$transactiondateto;}

$docno = $_SESSION['docno'];

 //get location for sort by location purpose
   $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		  $locationcode=$location;
		}
		//location get end here
//$locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';

// Handle action requests
if(!empty($_REQUEST['patientcode']) && !empty($_REQUEST['visitcode']) && !empty($_REQUEST['action'])){
if($_REQUEST['action']=='consultation'){
$p_code=$_REQUEST['patientcode'];
$v_code=$_REQUEST['visitcode'];

			$query76 = "select auto_number from master_visitentry where paymentstatus='completed' and consultationrefund='torefundrequest' and doctorfeesstatus = '' and patientcode like '$p_code' and visitcode like '$v_code' limit 0,1";
			$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res76 = mysqli_fetch_array($exec76))
			{
	 		$query8 = "select auto_number from billing_paylater where patientcode = '$p_code' and visitcode = '$v_code'";	
			$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rows8 = mysqli_num_rows($exec8);
				if($rows8 == 0)
				{
					$query81 = "update master_visitentry set consultationrefund='torefundapproved' where patientcode = '$p_code' and visitcode = '$v_code'";	
					$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
					
				}
			}
			
header('location:cashrefundapprovallist.php');
}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash Refund Approval List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/cashrefundapprovallist-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
        <span>Cash Refund Approval List</span>
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
                    <li class="nav-item active">
                        <a href="cashrefundapprovallist.php" class="nav-link">
                            <i class="fas fa-check-circle"></i>
                            <span>Refund Approval List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountreceivableentrylist.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>Account Receivable</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeinpatientlist.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Active Inpatient List</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Cash Refund Approval List</h2>
                    <p>Review and approve pending refund requests from various departments.</p>
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
                    <h3 class="search-form-title">Search Refund Approvals</h3>
                </div>
                
                <form id="searchForm" name="cbform1" method="post" action="cashrefundapprovallist.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-input" onchange="ajaxlocationfunction(this.value)">
                                <?php
                                $query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res = mysqli_fetch_array($exec)) {
                                    $reslocation = $res["locationname"];
                                    $reslocationanum = $res["locationcode"];
                                    $selected = ($location != '' && $location == $reslocationanum) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $reslocationanum; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($reslocation); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>" 
                                   class="form-input date-input" readonly="readonly">
                        </div>

                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>" 
                                   class="form-input date-input" readonly="readonly">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="patient" class="form-label">Patient Name</label>
                            <input name="patient" type="text" id="patient" class="form-input" 
                                   placeholder="Enter patient name" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="patientcode" class="form-label">Registration No</label>
                            <input name="patientcode" type="text" id="patientcode" class="form-input" 
                                   placeholder="Enter registration number" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="visitcode" class="form-label">Visit Code</label>
                            <input name="visitcode" type="text" id="visitcode" class="form-input" 
                                   placeholder="Enter visit code" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>

                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                    <input type="hidden" name="locationnamenew" value="<?php echo $locationname; ?>">
                    <input type="hidden" name="locationcodenew" value="<?php echo $res1locationanum; ?>">
                </form>
            </div>
            <!-- Results Table Section -->
            <div class="results-table-section">
                <div class="results-table-header">
                    <i class="fas fa-list results-table-icon"></i>
                    <h3 class="results-table-title">Refund Approval List</h3>
                </div>

                <?php
                $colorloopcount=0;
                $sno=0;
                if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
                if ($cbfrmflag1 == 'cbfrmflag1') {
                    $searchpatient = $_POST['patient'];
                    $searchpatientcode=$_POST['patientcode'];
                    $searchvisitcode = $_POST['visitcode'];
                    $fromdate=$_POST['ADate1'];
                    $todate=$_POST['ADate2'];
                ?>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Reg No</th>
                            <th>Visit No</th>
                            <th>Patient</th>
                            <th>Account</th>
                            <th>Remarks</th>
                            <th>Requested By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>		

			<?php
			$colorloopcount = '';
			$sno = 0;
			
			$query76 = "select * from master_billing where  patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientfullname like '%$searchpatient%'  and billingdatetime between '$fromdate' and '$todate' and refund_status='requested'  group by visitcode,billnumber order by billingdatetime desc";

			$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res76 = mysqli_fetch_array($exec76))
			{
			$patientcode = $res76['patientcode'];
			$patientvisitcode=$res76['visitcode'];
			$consultationdate=$res76['billingdatetime'];
			$patientname=$res76['patientfullname'];
			$accountname=$res76['accountname'];
			//$billtype = $res76['billtype'];
			$remarks = $res76['refundremarks'];
			$res76refundrequestedby = $res76['refundrequestedby'];
			$billnumber = $res76['billnumber'];
				
			//$query8 = "select * from billing_paylater where patientcode = '$patientcode' and visitcode = '$patientvisitcode'";	
			//$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
			//$rows8 = mysql_num_rows($exec8);
			//if($rows8 == 0)
			//{
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
				$colorcode = '';
			} 
			?>
                        <tr class="<?php echo $showcolor == 0 ? 'even-row' : 'odd-row'; ?>">
                            <td><?php echo $sno = $sno + 1; ?></td>
                            <td>
                                <span class="date-badge"><?php echo date('d/m/Y',strtotime($consultationdate)); ?></span>
                            </td>
                            <td>
                                <span class="patient-code"><?php echo htmlspecialchars($patientcode); ?></span>
                            </td>
                            <td>
                                <span class="visit-code"><?php echo htmlspecialchars($patientvisitcode); ?></span>
                            </td>
                            <td>
                                <span class="patient-name"><?php echo htmlspecialchars($patientname); ?></span>
                            </td>
                            <td>
                                <span class="account-badge"><?php echo htmlspecialchars($accountname); ?></span>
                            </td>
                            <td>
                                <span class="remarks"><?php echo htmlspecialchars($remarks); ?></span>
                            </td>
                            <td>
                                <span class="requested-by"><?php echo htmlspecialchars($res76refundrequestedby); ?></span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="cashrefundapproval.php?billnumber=<?php echo $billnumber; ?>&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $patientvisitcode; ?>&&menuid=<?php echo $menu_id; ?>" 
                                       class="action-btn approve" title="Approve Refund">
                                        <i class="fas fa-check"></i> Approve
                                    </a>
                                </div>
                            </td>
                        </tr>
			<?php
			//}
			}
		
			?>


	  <?php
			$colorloopcount = '';
		
			$opvisitcode="'".''."'";
			$ipvisitcode="'".''."'";
			$triagedatefrom = date('Y-m-d', strtotime('-2 day'));
			$triagedateto = date('Y-m-d');
		
			$query1 = "select * from consultation_lab where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and paymentstatus='completed' and (freestatus='' or freestatus='NO') and refundapproval='' and labrefund='refund' and consultationdate between '$fromdate' and '$todate' and adv_refundapprove='' and patientvisitcode not in($opvisitcode) group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];
			$urgentstatus = $res1['urgentstatus'];
			$consultationdate = $res1['consultationdate'];
			$paymentstatus = $res1['paymentstatus'];
			$freestatus = $res1['freestatus'];
			$billtype = $res1['billtype'];
						$remarks=$res1['remarks'];
						$requestedby=$res1['requestedby'];

			if($opvisitcode=='')
			{
			$opvisitcode = "'".$visitcode."'";
			}
			else
			{
			$opvisitcode = $opvisitcode.",'".$visitcode."'";
			}
			$query111 = "select * from master_visitentry where visitcode='$visitcode'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
			$age = $res111['age'];
			$gender = $res111['gender'];
			$department = $res111['departmentname'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 	
			
			if($billtype == 'PAY LATER')
			{
				$query891 = "select billno from billing_paynow where visitcode='$visitcode' and patientcode = '$patientcode'";	
				$exec891 = mysqli_query($GLOBALS["___mysqli_ston"], $query891) or die ("Error in Query891".mysqli_error($GLOBALS["___mysqli_ston"]));
				$row891 = mysqli_num_rows($exec891);
			}	
			else
			{
				$row891 = '1';
			}	
			
			if($row891 > 0)
			{
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = '';
			}
			 if($urgentstatus == 1)
			{
			$colorcode = 'bgcolor="#FFFF00"';
			}
			?>
			
                        <tr class="<?php echo $urgentstatus == 1 ? 'urgent-row' : ($showcolor == 0 ? 'even-row' : 'odd-row'); ?>">
                            <td><?php echo $sno = $sno + 1; ?></td>
                            <td>
                                <span class="date-badge"><?php echo date('d/m/Y',strtotime($consultationdate)); ?></span>
                            </td>
                            <td>
                                <span class="patient-code"><?php echo htmlspecialchars($patientcode); ?></span>
                            </td>
                            <td>
                                <span class="visit-code"><?php echo htmlspecialchars($visitcode); ?></span>
                            </td>
                            <td>
                                <span class="patient-name"><?php echo htmlspecialchars($patientfullname); ?></span>
                            </td>
                            <td>
                                <span class="account-badge"><?php echo htmlspecialchars($account); ?></span>
                            </td>
                            <td>
                                <span class="remarks"><?php echo htmlspecialchars($remarks); ?></span>
                            </td>
                            <td>
                                <span class="requested-by"><?php echo htmlspecialchars($requestedby); ?></span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="cashrefundapproval.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=<?php echo $menu_id; ?>" 
                                       class="btn btn-primary btn-sm">
                                        <i class="fas fa-check"></i> Approve
                                    </a>
                                </div>
                            </td>
                        </tr>
			<?php
			}  
			}  
			?>
		
			<?php
			// paynow pharma bill refund before the medicine issue
			$query1 = "select * from master_item_refund where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and billstatus='requested' and approved_user='' and date(request_date) between '$fromdate' and '$todate' and adv_refundapprove='' and visitcode not in($opvisitcode) and visitcode not like 'IPV%'  group by visitcode,from_table,billnumber order by request_date desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['visitcode'];
			$refundrequestedby = $res1['request_username'];
			$billnumber = $res1['billnumber'];			
			
			if($opvisitcode=='')
			{
			$opvisitcode = "'".$visitcode."'";
			}
			else
			{
			$opvisitcode = $opvisitcode.",'".$visitcode."'";
			}
		

		if (strpos($visitcode, 'IPV') !== false) {
		    // str exists
		    $query23="select * from master_ipvisitentry where patientfullname like '%$searchpatient%' and visitcode='$visitcode'";
		}
		else
		{
			$query23="select * from master_visitentry where patientfullname like '%$searchpatient%' and visitcode='$visitcode'";
		}
		 
		 $exec23=mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res23=mysqli_fetch_array($exec23);

		 $patientfullname=$res23['patientfullname'];
		 $account=$res23['accountfullname'];
		 $billtype=$res23['billtype'];
		 $overallpayment=$res23['overallpayment'];
		 
			if($billtype=='PAY LATER' && $overallpayment=='completed'){
			  continue;
			}
			
			$consultationdate = $res1['request_date'];

			$remarks = stripslashes($res1['remarks']);

			if($patientfullname != '')
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
				$colorcode = '';
			}
			?>
                        <tr class="<?php echo $showcolor == 0 ? 'even-row' : 'odd-row'; ?>">
                            <td><?php echo $sno = $sno + 1; ?></td>
                            <td>
                                <span class="date-badge"><?php echo date('d/m/Y',strtotime($consultationdate)); ?></span>
                            </td>
                            <td>
                                <span class="patient-code"><?php echo htmlspecialchars($patientcode); ?></span>
                            </td>
                            <td>
                                <span class="visit-code"><?php echo htmlspecialchars($visitcode); ?></span>
                            </td>
                            <td>
                                <span class="patient-name"><?php echo htmlspecialchars($patientfullname); ?></span>
                            </td>
                            <td>
                                <span class="account-badge"><?php echo htmlspecialchars($account); ?></span>
                            </td>
                            <td>
                                <span class="remarks"><?php echo htmlspecialchars($remarks); ?></span>
                            </td>
                            <td>
                                <span class="requested-by"><?php echo htmlspecialchars($refundrequestedby); ?></span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="cashrefundapproval.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&billno=<?php echo $billnumber; ?>&&menuid=<?php echo $menu_id; ?>" 
                                       class="btn btn-primary btn-sm">
                                        <i class="fas fa-check"></i> Approve
                                    </a>
                                </div>
                            </td>
                        </tr>
			<?php
			}
			}    
			?>

				<?php
			$query1 = "select * from pharmacysalesreturn_details where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and billstatus='pending' and refundapprove='' and entrydate between '$fromdate' and '$todate' and adv_refundapprove='' and visitcode not in($opvisitcode) and visitcode not like 'IPV%'  group by visitcode order by entrydate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['visitcode'];
			$refundrequestedby = $res1['username'];
			
			if($opvisitcode=='')
			{
			$opvisitcode = "'".$visitcode."'";
			}
			else
			{
			$opvisitcode = $opvisitcode.",'".$visitcode."'";
			}
		

		if (strpos($visitcode, 'IPV') !== false) {
		    // str exists
		    $query23="select * from master_ipvisitentry where patientfullname like '%$searchpatient%' and visitcode='$visitcode'";
		}
		else
		{
			$query23="select * from master_visitentry where patientfullname like '%$searchpatient%' and visitcode='$visitcode'";
		}
		 
		 $exec23=mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res23=mysqli_fetch_array($exec23);
		 $patientfullname=$res23['patientfullname'];
		 $account=$res23['accountfullname'];
		
			
			$consultationdate = $res1['entrydate'];
			if($patientfullname != '')
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
				$colorcode = '';
			}
			?>
                        <tr class="<?php echo $showcolor == 0 ? 'even-row' : 'odd-row'; ?>">
                            <td><?php echo $sno = $sno + 1; ?></td>
                            <td>
                                <span class="date-badge"><?php echo date('d/m/Y',strtotime($consultationdate)); ?></span>
                            </td>
                            <td>
                                <span class="patient-code"><?php echo htmlspecialchars($patientcode); ?></span>
                            </td>
                            <td>
                                <span class="visit-code"><?php echo htmlspecialchars($visitcode); ?></span>
                            </td>
                            <td>
                                <span class="patient-name"><?php echo htmlspecialchars($patientfullname); ?></span>
                            </td>
                            <td>
                                <span class="account-badge"><?php echo htmlspecialchars($account); ?></span>
                            </td>
                            <td>
                                <span class="remarks">-</span>
                            </td>
                            <td>
                                <span class="requested-by"><?php echo htmlspecialchars($refundrequestedby); ?></span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="cashrefundapproval.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=<?php echo $menu_id; ?>" 
                                       class="btn btn-primary btn-sm">
                                        <i class="fas fa-check"></i> Approve
                                    </a>
                                </div>
                            </td>
                        </tr>
			<?php
			}
			}    
			?>
		
			<?php
			$query1 = "select * from consultation_radiology where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and paymentstatus='completed' and radiologyrefund='refund' and refundapprove='' and consultationdate between '$fromdate' and '$todate' and adv_refundapprove='' and patientvisitcode not in($opvisitcode) group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$res1patientcode = $res1['patientcode'];
			$res1visitcode = $res1['patientvisitcode'];
			$res1patientfullname = $res1['patientname'];
			$res1account = $res1['accountname'];
			$res1consultationdate = $res1['consultationdate'];
			$billtype = $res1['billtype'];
			$remarks=$res1['comments'];
			$refundrequestedby=$res1['refundrequestedby'];
			if($opvisitcode=='')
			{
			$opvisitcode = "'".$res1visitcode."'";
			}
			else
			{
			$opvisitcode = $opvisitcode.",'".$res1visitcode."'";
			}
	        $query11 = "select * from master_customer where customercode = '$res1patientcode' and status = '' ";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11 = mysqli_fetch_array($exec11);
			$res11age = $res11['age'];
			$res11gender= $res11['gender'];
			
			$query111 = "select * from master_visitentry where patientcode = '$res1patientcode' ";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
			$res111consultingdoctor = $res111['consultingdoctor'];
			$res1111department = $res111['departmentname'];
			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			if($billtype == 'PAY LATER')
			{
				$query891 = "select billno from billing_paynow where visitcode='$res1visitcode' and patientcode = '$res1patientcode'";	
				$exec891 = mysqli_query($GLOBALS["___mysqli_ston"], $query891) or die ("Error in Query891".mysqli_error($GLOBALS["___mysqli_ston"]));
				$row891 = mysqli_num_rows($exec891);
			}	
			else
			{
				$row891 = '1';
			}	
			
			if($row891 > 0)
			{
			
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = '';
			}
			?>
                        <tr class="<?php echo $showcolor == 0 ? 'even-row' : 'odd-row'; ?>">
                            <td><?php echo $sno = $sno + 1; ?></td>
                            <td>
                                <span class="date-badge"><?php echo $res1consultationdate; ?></span>
                            </td>
                            <td>
                                <span class="patient-code"><?php echo htmlspecialchars($res1patientcode); ?></span>
                            </td>
                            <td>
                                <span class="visit-code"><?php echo htmlspecialchars($res1visitcode); ?></span>
                            </td>
                            <td>
                                <span class="patient-name"><?php echo htmlspecialchars($res1patientfullname); ?></span>
                            </td>
                            <td>
                                <span class="account-badge"><?php echo htmlspecialchars($res1account); ?></span>
                            </td>
                            <td>
                                <span class="remarks"><?php echo htmlspecialchars($remarks); ?></span>
                            </td>
                            <td>
                                <span class="requested-by"><?php echo htmlspecialchars($refundrequestedby); ?></span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="cashrefundapproval.php?patientcode=<?php echo $res1patientcode; ?>&&visitcode=<?php echo $res1visitcode; ?>&&menuid=<?php echo $menu_id; ?>" 
                                       class="btn btn-primary btn-sm">
                                        <i class="fas fa-check"></i> Approve
                                    </a>
                                </div>
                            </td>
                        </tr>
			<?php
			}   
			} 
			?>

			<?php
			$query1 = "select * from consultation_referal where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and paymentstatus='completed' and referalrefund='refund' and refundapprove='' and adv_refundapprove='' and consultationdate between '$fromdate' and '$todate' and patientvisitcode not in($opvisitcode) group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$res1patientcode = $res1['patientcode'];
			$res1visitcode = $res1['patientvisitcode'];
			$res1patientfullname = $res1['patientname'];
			$res1account = $res1['accountname'];
			$res1consultationdate = $res1['consultationdate'];
			$billtype = $res1['billtype'];
			$remarks=$res1['remarks'];
			$refundrequestedby=$res1['refundrequestedby'];
			if($opvisitcode=='')
			{
			$opvisitcode = "'".$res1visitcode."'";
			}
			else
			{
			$opvisitcode = $opvisitcode.",'".$res1visitcode."'";
			}
	        $query11 = "select * from master_customer where customercode = '$res1patientcode' and status = '' ";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11 = mysqli_fetch_array($exec11);
			$res11age = $res11['age'];
			$res11gender= $res11['gender'];
			
			$query111 = "select * from master_visitentry where patientcode = '$res1patientcode' ";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
			$res111consultingdoctor = $res111['consultingdoctor'];
			$res1111department = $res111['departmentname'];
			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			if($billtype == 'PAY LATER')
			{
				$query891 = "select billno from billing_paynow where visitcode='$res1visitcode' and patientcode = '$res1patientcode'";	
				$exec891 = mysqli_query($GLOBALS["___mysqli_ston"], $query891) or die ("Error in Query891".mysqli_error($GLOBALS["___mysqli_ston"]));
				$row891 = mysqli_num_rows($exec891);
			}	
			else
			{
				$row891 = '1';
			}	
			
			if($row891 > 0)
			{
			
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = '';
			}
			?>
                        <tr class="<?php echo $showcolor == 0 ? 'even-row' : 'odd-row'; ?>">
                            <td><?php echo $sno = $sno + 1; ?></td>
                            <td>
                                <span class="date-badge"><?php echo $res1consultationdate; ?></span>
                            </td>
                            <td>
                                <span class="patient-code"><?php echo htmlspecialchars($res1patientcode); ?></span>
                            </td>
                            <td>
                                <span class="visit-code"><?php echo htmlspecialchars($res1visitcode); ?></span>
                            </td>
                            <td>
                                <span class="patient-name"><?php echo htmlspecialchars($res1patientfullname); ?></span>
                            </td>
                            <td>
                                <span class="account-badge"><?php echo htmlspecialchars($res1account); ?></span>
                            </td>
                            <td>
                                <span class="remarks"><?php echo htmlspecialchars($remarks); ?></span>
                            </td>
                            <td>
                                <span class="requested-by"><?php echo htmlspecialchars($refundrequestedby); ?></span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="cashrefundapproval.php?patientcode=<?php echo $res1patientcode; ?>&&visitcode=<?php echo $res1visitcode; ?>&&menuid=<?php echo $menu_id; ?>" 
                                       class="btn btn-primary btn-sm">
                                        <i class="fas fa-check"></i> Approve
                                    </a>
                                </div>
                            </td>
                        </tr>
			<?php
			}   
			} 
			?>
		
	
			<?php
			$query1 = "select * from consultation_services where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and paymentstatus='completed' and servicerefund='refund' and refundapprove='' and consultationdate between '$fromdate' and '$todate' and adv_refundapprove='' and patientvisitcode not in($opvisitcode) group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$res1patientcode = $res1['patientcode'];
			$res1visitcode = $res1['patientvisitcode'];
			$res1patientfullname = $res1['patientname'];
			$res1account = $res1['accountname'];
			$billtype = $res1['billtype'];
			$res1consultationdate = $res1['consultationdate'];
			$remarks=$res1['remarks'];
			$processedby=$res1['processedby'];
			if($opvisitcode=='')
			{
			$opvisitcode = "'".$res1visitcode."'";
			}
			else
			{
			$opvisitcode = $opvisitcode.",'".$res1visitcode."'";
			}
			$query11 = "select * from master_customer where customercode = '$res1patientcode' and status = '' ";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11 = mysqli_fetch_array($exec11);
			$res11age = $res11['age'];
			$res11gender= $res11['gender'];
			
			$query111 = "select * from master_visitentry where patientcode = '$res1patientcode' ";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
			$res111consultingdoctor = $res111['consultingdoctor'];
			$res1111department = $res111['departmentname'];
			
			if($billtype == 'PAY LATER')
			{
				$query891 = "select billno from billing_paynow where visitcode='$res1visitcode' and patientcode = '$res1patientcode'";	
				$exec891 = mysqli_query($GLOBALS["___mysqli_ston"], $query891) or die ("Error in Query891".mysqli_error($GLOBALS["___mysqli_ston"]));
				$row891 = mysqli_num_rows($exec891);
			}	
			else
			{
				$row891 = '1';
			}	
			
			if($row891 > 0)
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
				$colorcode = '';
			}
			?>
                        <tr class="<?php echo $showcolor == 0 ? 'even-row' : 'odd-row'; ?>">
                            <td><?php echo $sno = $sno + 1; ?></td>
                            <td>
                                <span class="date-badge"><?php echo $res1consultationdate; ?></span>
                            </td>
                            <td>
                                <span class="patient-code"><?php echo htmlspecialchars($res1patientcode); ?></span>
                            </td>
                            <td>
                                <span class="visit-code"><?php echo htmlspecialchars($res1visitcode); ?></span>
                            </td>
                            <td>
                                <span class="patient-name"><?php echo htmlspecialchars($res1patientfullname); ?></span>
                            </td>
                            <td>
                                <span class="account-badge"><?php echo htmlspecialchars($res1account); ?></span>
                            </td>
                            <td>
                                <span class="remarks"><?php echo htmlspecialchars($remarks); ?></span>
                            </td>
                            <td>
                                <span class="requested-by"><?php echo htmlspecialchars($processedby); ?></span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="cashrefundapproval.php?patientcode=<?php echo $res1patientcode; ?>&&visitcode=<?php echo $res1visitcode; ?>&&menuid=<?php echo $menu_id; ?>" 
                                       class="btn btn-primary btn-sm">
                                        <i class="fas fa-check"></i> Approve
                                    </a>
                                </div>
                            </td>
                        </tr>
			<?php
			} 
			}   
			?>
					
                    </tbody>
                </table>
                <?php } ?>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/cashrefundapprovallist-modern.js?v=<?php echo time(); ?>"></script>
    
    <!-- Date Picker Scripts -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    
</body>
</html>

