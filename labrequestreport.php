<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
$docno = $_SESSION['docno'];

//get location for sort by location purpose
$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if($location!='')
{
    $locationcode=$location;
}
//location get end here

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$res21itemname='';
$res21itemcode='';
$docnumber1 = '';

//This include updatation takes too long to load for hunge items database.
if (isset($_REQUEST["rowcount"])) { echo $rowcount = $_REQUEST["rowcount"]; } else { $rowcount = ""; }
if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

if ($getcanum != '')
{
    $query4 = "select * from master_supplier where auto_number = '$getcanum'";
    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res4 = mysqli_fetch_array($exec4);
    $cbsuppliername = $res4['suppliername'];
    $suppliername = $res4['suppliername'];
}

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if ($cbfrmflag1 == 'cbfrmflag1')
{
    $searchpatient = $_POST['patient'];
    $searchpatientcode=$_POST['patientcode'];
    $searchvisitcode=$_POST['visitcode'];
    $fromdate=$_POST['ADate1'];
    $todate=$_POST['ADate2'];
    $patienttype=$_POST['patienttype'];
}
else
{
    $searchpatient = '';
    $searchpatientcode='';
    $searchvisitcode='';
    $fromdate=date('Y-m-d');
    $todate=date('Y-m-d');
    $docnumber='';
    $patienttype='ALL';
}	

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == '1')
{
    $errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
    $errmsg = "Failed. Payment Entry Not Completed.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Request Report - MedStar</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/labrequestreport-modern.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
</head>
<body>
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
    </header>
    
    <div class="user-info-bar">
        <div class="user-welcome">
            <span class="welcome-text">Welcome, <strong><?php echo htmlspecialchars($_SESSION["username"]); ?></strong></span>
            <span class="location-info">📍 Company: <?php echo htmlspecialchars($_SESSION["companyname"]); ?></span>
        </div>
        <div class="user-actions">
            <a href="mainmenu1.php" class="btn btn-outline">🏠 Main Menu</a>
            <a href="logout.php" class="btn btn-outline">🚪 Logout</a>
        </div>
    </div>
    
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Home</a>
        <span>→</span>
        <span>Lab Request Report</span>
    </nav>
    
    <div id="menuToggle" class="floating-menu-toggle">
        <i class="fas fa-bars"></i>
    </div>
    
    <div class="main-container-with-sidebar">
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
                        <a href="labrequestreport.php" class="nav-link">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Lab Request Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="labtestreport.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Test Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="labrevenuereport.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Lab Revenue Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="labcategory1.php" class="nav-link">
                            <i class="fas fa-tags"></i>
                            <span>Lab Categories</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        
        <main class="main-content">
            <div class="alert-container">
                <?php if ($errmsg != "") { ?>
                    <div class="alert <?php echo ($st == '1') ? 'success' : 'failed'; ?>">
                        <?php echo htmlspecialchars($errmsg); ?>
                    </div>
                <?php } ?>
            </div>
            
            <div class="page-header">
                <h1 class="page-title">Lab Request Report</h1>
                <p class="page-subtitle">Track and analyze laboratory test requests and results</p>
            </div>
            
            <div class="form-section">
                <h2 class="form-title">Search Criteria</h2>
                <form name="cbform1" method="post" action="labrequestreport.php">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-select" onChange="ajaxlocationfunction(this.value);">
                                <?php
                                $query1 = "select * from master_employeelocation where username='$username' group by locationname order by locationname asc";
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
                            <label for="patient" class="form-label">Patient Name</label>
                            <input name="patient" type="text" id="patient" class="form-input" value="<?php echo htmlspecialchars($searchpatient); ?>" placeholder="Enter patient name">
                        </div>
                        
                        <div class="form-group">
                            <label for="patientcode" class="form-label">Patient Code</label>
                            <input name="patientcode" type="text" id="patientcode" class="form-input" value="<?php echo htmlspecialchars($searchpatientcode); ?>" placeholder="Enter patient code">
                        </div>
                        
                        <div class="form-group">
                            <label for="visitcode" class="form-label">Visit Code</label>
                            <input name="visitcode" type="text" id="visitcode" class="form-input" value="<?php echo htmlspecialchars($searchvisitcode); ?>" placeholder="Enter visit code">
                        </div>
                        
                        <div class="form-group">
                            <label for="patienttype" class="form-label">Patient Type</label>
                            <select name="patienttype" id="patienttype" class="form-select">
                                <option value="ALL" <?php if($patienttype=='ALL') echo "selected"; ?>>ALL</option>
                                <option value="IP" <?php if($patienttype=='IP') echo "selected"; ?>>IP</option>
                                <option value="OP" <?php if($patienttype=='OP') echo "selected"; ?>>OP</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <div class="date-input-group">
                                <input name="ADate1" id="ADate1" class="form-input date-input" value="<?php echo $fromdate; ?>" size="10" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" class="calendar-icon" title="Select Date">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <div class="date-input-group">
                                <input name="ADate2" id="ADate2" class="form-input date-input" value="<?php echo $todate; ?>" size="10" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" class="calendar-icon" title="Select Date">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                            Search
                        </button>
                        <button type="reset" class="btn btn-outline">
                            <i class="fas fa-undo"></i>
                            Reset
                        </button>
                        <a href="print_lab_request_report.php?ADate1=<?php echo $fromdate; ?>&&ADate2=<?php echo $todate; ?>&&patienttype=<?php echo $patienttype; ?>&&searchpatient=<?php echo $searchpatient; ?>&&searchpatientcode=<?php echo $searchpatientcode; ?>&&searchvisitcode=<?php echo $searchvisitcode; ?>&&locationcode=<?php echo $locationcode; ?>" 
                           class="btn btn-success" target="_blank">
                            <i class="fas fa-file-excel"></i>
                            Export Excel
                        </a>
                    </div>
                </form>
            </div>
            
            <?php
            $colorloopcount=0;
            $sno=0;
            if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
            
            if ($cbfrmflag1 == 'cbfrmflag1')
            {
                $searchpatient = $_POST['patient'];
                $searchpatientcode=$_POST['patientcode'];
                $searchvisitcode=$_POST['visitcode'];
                $fromdate=$_POST['ADate1'];
                $todate=$_POST['ADate2'];
                $labreq_count=0;
                $labresult_count=0;
            ?>
            
            <div class="data-section">
                <div class="data-header">
                    <h2 class="data-title">Request Report</h2>
                    <div class="search-container">
                        <span class="location-display" id="ajaxlocation">
                            <strong>Location: </strong>
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
                </div>
                
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Patient</th>
                                <th>Reg No</th>
                                <th>Visit No</th>
                                <th>Visit Date</th>
                                <th>Lab Item Code</th>
                                <th>Lab Item Rate</th>
                                <th>Lab Item Name</th>
                                <th>External Lab</th>
                                <th>External Rate</th>
                                <th>Supplier</th>
                                <th>Request Date</th>
                                <th>Sample Type</th>
                                <th>Request Entry</th>
                                <th>Result Entry</th>
                                <th>Amendment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $grandtotal="0";
                            $total="0";
                            $amendtotal="0";
                            $exttotal="0";
                            $extcount="0";
                            
                            $query12 = "select auto_number from master_location where locationcode='$locationcode' order by locationname";
                            $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res12 = mysqli_fetch_array($exec12);
                            $loctid = $res12["auto_number"];
                            
                            if($patienttype=='ALL' || $patienttype=='OP') {
                                $queryh="select labitemname,labitemcode,visitcode from (
                                select labitemname,labitemcode,patientvisitcode as visitcode from consultation_lab where locationcode='".$locationcode."' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and consultationdate between '$fromdate' and '$todate' and labsamplecoll='completed' 
                                UNION ALL
                                select itemname as labitemname,itemcode as labitemcode,visitcode as visitcode from amendment_details where visitcode like '%-$loctid' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and amenddate between '$fromdate' and '$todate' and amendfrom='lab' 
                                and visitcode like 'OPV-%') as a group by labitemcode";
                                $exech=mysqli_query($GLOBALS["___mysqli_ston"], $queryh) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($exeche=mysqli_fetch_array($exech))
                                {
                                    $itemname=$exeche['labitemname'];
                                    $itemcode21=$exeche['labitemcode'];
                            ?>
                            
                            <tr class="item-header-row">
                                <td colspan="16" class="item-header">
                                    <strong>Lab Item Name: <?php echo htmlspecialchars($itemname); ?></strong>
                                </td>
                            </tr>
                            
                            <?php
                                $query23 = "select username,patientcode,patientvisitcode,patientname,labitemcode,labitemrate,consultationdate,resultentry,'' as amend from consultation_lab where locationcode='".$locationcode."' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and consultationdate between '$fromdate' and '$todate' and labsamplecoll='completed' and labitemcode='".$itemcode21."'
                                UNION ALL
                                select amendby as username,patientcode,visitcode as patientvisitcode,patientname,itemcode as labitemcode,amount as labitemrate,amenddate as consultationdate,'' as resultentry,'Yes' as amend from amendment_details where visitcode like '%-$loctid' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and amenddate between '$fromdate' and '$todate' and amendfrom='lab' and visitcode like 'OPV-%'  and itemcode='".$itemcode21."'";
                                $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $numexec23=mysqli_num_rows($exec23);
                                if($numexec23>0)
                                while($res23 = mysqli_fetch_array($exec23))
                                {
                                    $resultdone='';
                                    $username=$res23['username'];
                                    $patientcode = $res23['patientcode'];
                                    $visitcode = $res23['patientvisitcode'];
                                    $patientname = $res23['patientname'];
                                    $itemcode = $res23['labitemcode'];
                                    $itemrate = $res23['labitemrate'];
                                    $consultationdate = $res23['consultationdate'];
                                    $resultentry = $res23['resultentry'];
                                    $amend = $res23['amend'];
                                    
                                    if($resultentry=='completed'){
                                        $resultdone='Yes';
                                        $labresult_count+=1;
                                    } else if($amend=='Yes'){
                                        $amendtotal+=1;
                                    }else{
                                        $labreq_count+=1;
                                    }
                                    
                                    $total+=$itemrate;
                                    
                                    $query24="select recorddate from master_consultation where patientcode='".$patientcode."' and patientvisitcode='".$visitcode."'";
                                    $exec24=mysqli_query($GLOBALS["___mysqli_ston"], $query24)or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res24=mysqli_fetch_array($exec24);
                                    $visitdate=$res24['recorddate'];
                                    
                                    $query224="select sampletype from master_lab where itemcode='".$itemcode."'";
                                    $exec224=mysqli_query($GLOBALS["___mysqli_ston"], $query224) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res224=mysqli_fetch_array($exec224);
                                    $sample=$res224['sampletype'];
                                    
                                    $query241="select externallab,externalack from samplecollection_lab where patientvisitcode='".$visitcode."' and itemcode='$itemcode'";
                                    $exec241=mysqli_query($GLOBALS["___mysqli_ston"], $query241)or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res241=mysqli_fetch_array($exec241);
                                    $externallab=$res241['externallab'];
                                    $externalack=$res241['externalack'];
                                    
                                    $itemrate_ext=0.00;
                                    $suppliername='';
                                    $extlab=0;
                                    if($externallab=='1' && $externalack=='0' && $amend==''){
                                        $extcount+=1;
                                        $extlab=1;
                                        
                                        $supplierq = "select suppliercode,rate from lab_supplierlink where itemcode = '$itemcode' and fav_supplier='1'";
                                        $execq = mysqli_query($GLOBALS["___mysqli_ston"], $supplierq) or die("Error in SupplierQ".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $resq = mysqli_fetch_array($execq);
                                        $suppliercode = $resq['suppliercode'];
                                        $itemrate_ext = $resq['rate'];
                                        $exttotal+=$itemrate_ext;
                                        $query20 = "select accountname from master_accountname where id = '$suppliercode' ";
                                        $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die('Error in Query20'.mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $res20 = mysqli_fetch_array($exec20);
                                        $suppliername = $res20['accountname'];
                                    }
                                    
                                    if($visitcode=='walkinvis')
                                    {
                                        $visitdate=$consultationdate;	
                                    }
                                    
                                    $colorloopcount = $colorloopcount + 1;
                                    $showcolor = ($colorloopcount & 1);
                                    
                                    if ($showcolor == 0) {
                                        $colorcode = 'bgcolor="#CBDBFA"';
                                    } else {
                                        $colorcode = 'bgcolor="#ecf0f5"';
                                    }
                            ?>
                            <tr <?php echo $colorcode; ?>>
                                <td><?php echo $sno = $sno + 1; ?></td>
                                <td><?php echo htmlspecialchars($patientname); ?></td>
                                <td><?php echo htmlspecialchars($patientcode); ?></td>
                                <td><?php echo htmlspecialchars($visitcode); ?></td>
                                <td><?php echo $visitdate; ?></td>
                                <td><?php echo htmlspecialchars($itemcode); ?></td>
                                <td class="text-right"><?php echo number_format($itemrate,2); ?></td>
                                <td><?php echo htmlspecialchars($itemname); ?></td>
                                <td class="text-center"><?php echo $extlab; ?></td>
                                <td class="text-right"><?php echo number_format($itemrate_ext,2); ?></td>
                                <td><?php echo htmlspecialchars($suppliername); ?></td>
                                <td><?php echo $consultationdate; ?></td>
                                <td><?php echo htmlspecialchars($sample);?></td>
                                <td><?php echo htmlspecialchars($username);?></td>
                                <td class="text-center"><?php echo $resultdone;?></td>
                                <td class="text-center"><?php echo $amend;?></td>
                            </tr>
                            <?php
                                } 
                            ?>
                            <tr class="subtotal-row">
                                <td colspan="6" class="text-right"><strong>Sub Total</strong></td>
                                <td class="text-right"><strong><?php echo number_format($total,2); ?></strong></td>
                                <td colspan="9"></td>
                            </tr>
                            <?php
                                $grandtotal=$grandtotal+$total;
                                $total=0;
                            }
                            }
                            ?>   
                            
                            <?php 
                            if($patienttype=='ALL' || $patienttype=='IP') {
                                $total1="0";
                                $queryq="select labitemname,labitemcode,visitcode from (
                                select labitemname,labitemcode,patientvisitcode as visitcode from ipconsultation_lab where locationcode='".$locationcode."' and labsamplecoll='completed' and consultationdate between '$fromdate' and '$todate' 
                                UNION ALL
                                select itemname as labitemname,itemcode as labitemcode,visitcode as visitcode from amendment_details where visitcode like '%-$loctid' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and amenddate between '$fromdate' and '$todate' and amendfrom='lab' 
                                and visitcode like 'IPV-%') as a group by labitemcode";
                                $execg=mysqli_query($GLOBALS["___mysqli_ston"], $queryq) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $numrow=mysqli_num_rows($execg);
                                while( $exeg=mysqli_fetch_array($execg))
                                {
                                    $itemname2=$exeg['labitemname'];
                                    $itemcode22=$exeg['labitemcode'];
                            ?>
                            
                            <tr class="item-header-row">
                                <td colspan="16" class="item-header">
                                    <strong>Lab Item Name: <?php echo htmlspecialchars($itemname2); ?></strong>
                                </td>
                            </tr>
                            
                            <?php
                                $total1=0;
                                $query27 = "select username,patientcode,patientvisitcode,patientname,labitemcode,labitemrate,consultationdate,resultentry,'' as amend from ipconsultation_lab where locationcode='".$locationcode."' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and labsamplecoll='completed' and consultationdate between '$fromdate' and '$todate' and labitemcode='$itemcode22'
                                UNION ALL
                                select amendby as username,patientcode,visitcode as patientvisitcode,patientname,itemcode as labitemcode,amount as labitemrate,amenddate as consultationdate,'' as resultentry,'Yes' as amend from amendment_details where visitcode like '%-$loctid' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and amenddate between '$fromdate' and '$todate' and amendfrom='lab' and visitcode like 'IPV-%'  and itemcode='".$itemcode22."'";
                                
                                $exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $numexec26=mysqli_num_rows($exec27);
                                
                                while($res27 = mysqli_fetch_array($exec27))
                                {
                                    $resultdone='';
                                    $username1= $res27['username'];
                                    $patientcode2 = $res27['patientcode'];
                                    $visitcode2 = $res27['patientvisitcode'];
                                    $patientname2 = $res27['patientname'];
                                    $itemcode2 = $res27['labitemcode'];
                                    $itemrate2 = $res27['labitemrate'];
                                    $consultationdate2 = $res27['consultationdate'];
                                    $resultentry = $res27['resultentry'];
                                    $amend = $res27['amend'];
                                    
                                    if($resultentry=='completed'){
                                        $resultdone='Yes';
                                        $labresult_count+=1;
                                    }else if($amend=='Yes'){
                                        $amendtotal+=1;
                                    }else{
                                        $labreq_count+=1;
                                    }
                                    
                                    $total1+=$itemrate2;
                                    
                                    $query28="select registrationdate from master_ipvisitentry where patientcode='".$patientcode2."' and visitcode='".$visitcode2."' order by auto_number desc";
                                    $exec28=mysqli_query($GLOBALS["___mysqli_ston"], $query28)or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res28=mysqli_fetch_array($exec28);
                                    $visitdate2=$res28['registrationdate'];
                                    
                                    $itemrate_ext=0.00;
                                    $query225="select sampletype from master_lab where itemcode='".$itemcode2."'";
                                    $exec225=mysqli_query($GLOBALS["___mysqli_ston"], $query225) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res225=mysqli_fetch_array($exec225);
                                    $sample1=$res225['sampletype'];
                                
                                    $query241="select externallab,externalack from ipsamplecollection_lab where patientvisitcode='".$visitcode2."' and itemcode='$itemcode2'";
                                    $exec241=mysqli_query($GLOBALS["___mysqli_ston"], $query241)or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res241=mysqli_fetch_array($exec241);
                                    $externallab=$res241['externallab'];
                                    $externalack=$res241['externalack'];
                                    
                                    $itemrate_ext=0.00;
                                    $suppliername='';
                                    $extlab=0;
                                    if($externallab=='1' &&  $externalack='1' && $amend==''){
                                        $extcount+=1;
                                        $extlab=1;
                                            
                                        $supplierq = "select suppliercode,rate from lab_supplierlink where itemcode = '$itemcode2' and fav_supplier='1'";
                                        $execq = mysqli_query($GLOBALS["___mysqli_ston"], $supplierq) or die("Error in SupplierQ".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $resq = mysqli_fetch_array($execq);
                                        $suppliercode = $resq['suppliercode'];
                                        $itemrate_ext = $resq['rate'];
                                        $exttotal+=$itemrate_ext;
                                        $query20 = "select accountname from master_accountname where id = '$suppliercode' ";
                                        $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die('Error in Query20'.mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $res20 = mysqli_fetch_array($exec20);
                                        $suppliername = $res20['accountname'];
                                    }
                                
                                    $colorloopcount = $colorloopcount + 1;
                                    $showcolor = ($colorloopcount & 1); 
                                    if ($showcolor == 0) {
                                        $colorcode = 'bgcolor="#CBDBFA"';
                                    } else {
                                        $colorcode = 'bgcolor="#ecf0f5"';
                                    }
                            ?>
                            <tr <?php echo $colorcode; ?>>
                                <td><?php echo $sno = $sno + 1; ?></td>
                                <td><?php echo htmlspecialchars($patientname2); ?></td>
                                <td><?php echo htmlspecialchars($patientcode2); ?></td>
                                <td><?php echo htmlspecialchars($visitcode2); ?></td>
                                <td><?php echo $visitdate2; ?></td>
                                <td><?php echo htmlspecialchars($itemcode2); ?></td>
                                <td class="text-right"><?php echo number_format($itemrate2,2); ?></td>
                                <td><?php echo htmlspecialchars($itemname2); ?></td>
                                <td class="text-center"><?php echo $extlab; ?></td>
                                <td class="text-right"><?php echo number_format($itemrate_ext,2); ?></td>
                                <td><?php echo htmlspecialchars($suppliername); ?></td>               
                                <td><?php echo $consultationdate2; ?></td>
                                <td><?php echo htmlspecialchars($sample1);?></td>
                                <td><?php echo htmlspecialchars($username1);?></td>
                                <td class="text-center"><?php echo $resultdone;?></td>
                                <td class="text-center"><?php echo $amend;?></td>
                            </tr>
                            <?php
                                }
                            ?>
                            <tr class="subtotal-row">
                                <td colspan="6" class="text-right"><strong>Sub Total</strong></td>
                                <td class="text-right"><strong><?php echo number_format($total1,2); ?></strong></td>
                                <td colspan="9"></td>
                            </tr>
                            <?php
                                $grandtotal=$grandtotal+$total1;
                            }
                            }
                            ?>
                            
                            <tr class="grandtotal-row">
                                <td colspan="6" class="text-right"><strong>Grand Total</strong></td>
                                <td class="text-right"><strong><?php echo number_format($grandtotal,2); ?></strong></td>
                                <td colspan="9"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="summary-section">
                    <div class="summary-grid">
                        <div class="summary-item">
                            <div class="summary-label">Lab Count</div>
                            <div class="summary-value"><?php echo number_format($labreq_count+$labresult_count+$amendtotal,0); ?></div>
                        </div>
                        <div class="summary-item">
                            <div class="summary-label">Lab Pending Count</div>
                            <div class="summary-value"><?php echo number_format($labreq_count,0); ?></div>
                        </div>
                        <div class="summary-item">
                            <div class="summary-label">Result Entry Count</div>
                            <div class="summary-value"><?php echo number_format($labresult_count,0); ?></div>
                        </div>
                        <div class="summary-item">
                            <div class="summary-label">Amendment Count</div>
                            <div class="summary-value"><?php echo number_format($amendtotal,0); ?></div>
                        </div>
                        <div class="summary-item">
                            <div class="summary-label">External Lab Count</div>
                            <div class="summary-value"><?php echo $extcount; ?></div>
                        </div>
                        <div class="summary-item">
                            <div class="summary-label">External Lab Amount</div>
                            <div class="summary-value"><?php echo number_format($exttotal,2); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php } ?>
        </main>
    </div>
    
    <script src="js/labrequestreport-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
