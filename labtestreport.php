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
}
else
{
    $searchpatient = '';
    $searchpatientcode='';
    $searchvisitcode='';
    $fromdate=date('Y-m-d');
    $todate=date('Y-m-d');
    $docnumber='';
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
    <title>Lab Test Report - MedStar</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/labtestreport-modern.css?v=<?php echo time(); ?>">
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
        <span>Lab Test Report</span>
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
                <h1 class="page-title">Lab Test Report</h1>
                <p class="page-subtitle">Track laboratory test progress and sample collection status</p>
            </div>
            
            <div class="form-section">
                <h2 class="form-title">Search Criteria</h2>
                <form name="cbform1" method="post" action="labtestreport.php">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" class="form-select" onChange="ajaxlocationfunction(this.value);">
                                <?php
                                $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
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
                
                $queryn21 = "select locationcode from consultation_lab where  locationcode='".$locationcode."' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and consultationdate between '$fromdate' and '$todate' and labsamplecoll='completed'";
                $execn21 = mysqli_query($GLOBALS["___mysqli_ston"], $queryn21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
                $numn21=mysqli_num_rows($execn21);
                
                $query27 = "select locationcode from ipconsultation_lab where locationcode='".$locationcode."' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and labsamplecoll='completed' and consultationdate between '$fromdate' and '$todate' ";
                $exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                $numexec26=mysqli_num_rows($exec27);
                $resnw1 = $numn21+$numexec26;
            ?>
            
            <div class="data-section">
                <div class="data-header">
                    <h2 class="data-title">Test Report</h2>
                    <div class="test-count"><<<?php echo $resnw1;?>>></div>
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
                                <th>Lab Item Name</th>
                                <th>Request Date</th>
                                <th>Sample Type</th>
                                <th>Sample Date</th>
                                <th>Sample Time</th>
                                <th>Publish Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query23 = "select * from consultation_lab where locationcode='".$locationcode."' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and consultationdate between '$fromdate' and '$todate' and labsamplecoll='completed'";
                            $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                            $numexec23=mysqli_num_rows($exec23);
                            
                            if($numexec23>0)
                            while($res23 = mysqli_fetch_array($exec23))
                            {
                                $patientcode = $res23['patientcode'];
                                $visitcode = $res23['patientvisitcode'];
                                $patientname = $res23['patientname'];
                                $itemname = $res23['labitemname'];
                                $itemcode = $res23['labitemcode'];
                                $itemrate = $res23['labitemrate'];
                                $consultationdate = $res23['consultationdate'];
                                
                                $query24="select recorddate from master_consultation where patientcode='".$patientcode."' and patientvisitcode='".$visitcode."'";
                                $exec24=mysqli_query($GLOBALS["___mysqli_ston"], $query24)or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res24=mysqli_fetch_array($exec24);
                                $visitdate=$res24['recorddate'];
                                
                                /* to find sample */
                                $query224="select sampletype from master_lab where itemcode='".$itemcode."'";
                                $exec224=mysqli_query($GLOBALS["___mysqli_ston"], $query224) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res224=mysqli_fetch_array($exec224);
                                $sample=$res224['sampletype'];
                                
                                /*To get date time*/
                                $queryd1="select recorddate,recordtime from samplecollection_lab where patientcode='".$patientcode."' and patientvisitcode='".$visitcode."' and itemcode='".$itemcode."'";
                                $execd1=mysqli_query($GLOBALS["___mysqli_ston"], $queryd1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $resd1=mysqli_fetch_array($execd1);
                                $sampledate=$resd1['recorddate'];
                                $sampletime=$resd1['recordtime'];
                                
                                if($sampledate=='')
                                {
                                    $queryd1="select recorddate,recordtime from samplecollection_laban where patientcode='".$patientcode."' and patientvisitcode='".$visitcode."' and itemcode='".$itemcode."'";
                                    $execd1=mysqli_query($GLOBALS["___mysqli_ston"], $queryd1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $resd1=mysqli_fetch_array($execd1);
                                    $sampledate=$resd1['recorddate'];
                                    $sampletime=$resd1['recordtime'];
                                }	
                                
                                /*to get publish date time*/
                                $queryp="select publishstatus,publishdatetime,datetime from resultentry_lab where patientcode='".$patientcode."' and patientvisitcode='".$visitcode."'and itemcode='".$itemcode."'";
                                $execp=mysqli_query($GLOBALS["___mysqli_ston"], $queryp) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $resp=mysqli_fetch_array($execp);
                                $publishstatus=$resp['publishstatus'];
                                $publishsdatetime=$resp['publishdatetime'];
                                $publishdtime=$resp['datetime'];
                                $publishshow="";
                                $publishshowtime="";
                                
                                if($publishstatus=="completed")
                                {
                                    $publishshow=$publishsdatetime;	
                                }
                                else
                                {
                                    $publishshow=$publishdtime;	
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
                                <td><?php echo htmlspecialchars($itemname); ?></td>
                                <td><?php echo $consultationdate; ?></td>
                                <td><?php echo htmlspecialchars($sample);?></td>
                                <td><?php echo $sampledate; ?></td>
                                <td><?php echo $sampletime; ?></td>
                                <td class="status-published"><?php echo $publishshow; ?></td>
                            </tr>
                            <?php
                            } 
                            ?>   
                            
                            <?php 
                            $query27 = "select * from ipconsultation_lab where locationcode='".$locationcode."' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and labsamplecoll='completed' and labrefund <> 'refund' and consultationdate between '$fromdate' and '$todate' ";
                            $exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                            $numexec26=mysqli_num_rows($exec27);
                            
                            while($res27 = mysqli_fetch_array($exec27))
                            {
                                $patientcode2 = $res27['patientcode'];
                                $visitcode2 = $res27['patientvisitcode'];
                                $patientname2 = $res27['patientname'];
                                $itemname2 = $res27['labitemname'];
                                $itemcode2 = $res27['labitemcode'];
                                $itemrate2 = $res27['labitemrate'];
                                $consultationdate2 = $res27['consultationdate'];
                                
                                $query28="select registrationdate from master_ipvisitentry where patientcode='".$patientcode2."' and visitcode='".$visitcode2."' order by auto_number desc";
                                $exec28=mysqli_query($GLOBALS["___mysqli_ston"], $query28)or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res28=mysqli_fetch_array($exec28);
                                $visitdate2=$res28['registrationdate'];
                                
                                $query225="select sampletype from master_lab where itemcode='".$itemcode2."'";
                                $exec225=mysqli_query($GLOBALS["___mysqli_ston"], $query225) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res225=mysqli_fetch_array($exec225);
                                $sample1=$res225['sampletype'];
                                
                                /*To get date time*/
                                $queryd="select recorddate,recordtime from ipsamplecollection_lab where patientcode='".$patientcode2."' and patientvisitcode='".$visitcode2."' and itemcode='".$itemcode2."'";
                                $execd=mysqli_query($GLOBALS["___mysqli_ston"], $queryd) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $resd=mysqli_fetch_array($execd);
                                $sampledate1=$resd['recorddate'];
                                $sampletime1=$resd['recordtime'];
                                
                                /*to get publish date time*/
                                $queryt="select recorddate,recordtime from ipresultentry_lab where patientcode='".$patientcode2."' and patientvisitcode='".$visitcode2."'and itemcode='".$itemcode2."'";
                                $exect=mysqli_query($GLOBALS["___mysqli_ston"], $queryt) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                                $rest=mysqli_fetch_array($exect);
                                $publishsdate=$rest['recorddate'];
                                $publishdtime1=$rest['recordtime'];
                                
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
                                <td><?php echo htmlspecialchars($itemname2); ?></td>
                                <td><?php echo $consultationdate2; ?></td>
                                <td><?php echo htmlspecialchars($sample1);?></td>
                                <td><?php echo $sampledate1;?></td>
                                <td><?php echo $sampletime1;?></td>
                                <td class="status-published"><?php echo $publishsdate;?></td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <?php } ?>
        </main>
    </div>
    
    <script src="js/labtestreport-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
