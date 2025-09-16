<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$updatedate = date('Y-m-d');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

error_reporting(E_ERROR | E_PARSE);

///////////////////// EXCEL //////// UPLOAD ////////
$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

$locationname  = $res["locationname"];
$locationcode123 = $res["locationcode"];
$locationcode = $res["locationcode"];
$res12locationanum = $res["auto_number"];

if (isset($_REQUEST["frmflag_upload"])) {	
    function readCSV($csvFile){
        $file_handle = fopen($csvFile, 'r');
        while (!feof($file_handle) ) {
            $line_of_text[] = fgetcsv($file_handle, 1024);
        }
        fclose($file_handle);
        return $line_of_text;
    }

    if(!empty($_FILES['upload_file'])) {
        $accountsmain=2;
        $accountssub=2;

        $medicinequery231="TRUNCATE TABLE `debtorsupload_temp`";
        $execquery231=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery231) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

        $inputFileName = $_FILES['upload_file']['tmp_name'];
        include 'phpexcel/Classes/PHPExcel/IOFactory.php';

        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
            $sheet = $objPHPExcel->getSheet(0); 
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $row = 1;

            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                    NULL,
                                    TRUE,
                                    FALSE)[0];

            foreach($rowData as $key=>$value) {
                $paynowbillprefix1 = 'DREXUP-';
                $paynowbillprefix12=strlen($paynowbillprefix1);
                $query23 = "SELECT * from debtorsupload_temp order by auto_number desc limit 0, 1";
                $exec23= mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res23 = mysqli_fetch_array($exec23);
                $billnumber1 = $res23["excel_id"];
                $billdigit1=strlen($billnumber1);
                if ($billnumber1 == '') {
                    $upload_exid ='DREXUP-'.'1';
                } else {
                    $billnumber1 = $res23["excel_id"];
                    $upload_exid = substr($billnumber1,$paynowbillprefix12, $billdigit1);
                    $upload_exid = intval($upload_exid);
                    $upload_exid = $upload_exid + 1;
                    $maxanum1 = $upload_exid;
                    $upload_exid = 'DREXUP-'.$maxanum1;
                }

                if($rowData[$key] == 'Main Type')
                    $epaymenttype1 = $key;

                if($rowData[$key] == 'Sub Type')
                    $esubtype1 = $key;

                if($rowData[$key] == 'Company name')
                    $eaccountname1 = $key;

                if($rowData[$key] == 'Validity(DD/MM/YYYY)')
                    $eexpirydate1 = $key;

                if($rowData[$key] == 'Currency')
                    $ecurrency1 = $key;
            }		

            for ($row = 2; $row <= $highestRow; $row++){ 
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                        NULL,
                                        TRUE,
                                        FALSE)[0];

                $epaymenttype = $rowData[$epaymenttype1];
                $esubtype = $rowData[$esubtype1];
                $eaccountname = $rowData[$eaccountname1];
                $eexpirydate_new = $rowData[$eexpirydate1];
                $ecurrency = $rowData[$ecurrency1];
         
                if($eaccountname!="") {
                    $eiscapitation='';
                    $eis_receivable='';

                    if($eiscapitation=='Yes'){
                        $iscapitation=1;
                    }else{
                        $iscapitation=0;
                    }
                    if($eis_receivable=='Yes'){
                        $is_receivable=1;
                    }else{
                        $is_receivable=0;
                    }

                    $expirydate=date('Y-m-d',  PHPExcel_Shared_Date::ExcelToPHP($eexpirydate_new));
                    $eaccountname_new = trim($eaccountname);
                    $eaccountname_new = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $eaccountname_new);
                    $eaccountname_new=ucwords(strtolower($eaccountname_new));

                    $medicinequery2="INSERT INTO `debtorsupload_temp`( `accountname`, `id`, `legacy_code`, `paymenttype`, `subtype`, `accountsmain`, `accountssub`, `openingbalancecredit`, `openingbalancedebit`, `currency`, `fxrate`, `recordstatus`, `expirydate`, `locationname`, `locationcode`, `ipaddress`, `recorddate`, `contact`, `username`, `misreport`, `iscapitation`,`is_receivable`,`excel_id`,`phone`) 
                    VALUES ('$eaccountname_new','','','$epaymenttype','$esubtype','$accountsmain','$accountssub','','','$ecurrency','1','ACTIVE','$expirydate','$locationname','$locationcode','$ipaddress','$updatedatetime','','$username','','$iscapitation','$is_receivable','$upload_exid','')";

                    $execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                }
            }
            echo "<script>window.location.href = 'debtorsupload.php'</script>";

        } catch(Exception $e) {
            echo '<script>alert("File is Empty!.. Please retry Again");</script>';
            echo "<script>window.location.href = 'debtorsupload.php'</script>";
        }
    }
}

////////////// END OF EXCEL UPLOAD  START OF PLAN UPLOAD /////////////////////
if (isset($_POST["plan_frmflag_upload"])) {	
    function readCSV($csvFile){
        $file_handle = fopen($csvFile, 'r');
        while (!feof($file_handle) ) {
            $line_of_text[] = fgetcsv($file_handle, 1024);
        }
        fclose($file_handle);
        return $line_of_text;
    }

    if(!empty($_FILES['upload_file'])) {	
        $medicinequery231="TRUNCATE TABLE `planupload_temp`";
        $execquery231=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery231) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

        $inputFileName = $_FILES['upload_file']['tmp_name'];
        include 'phpexcel/Classes/PHPExcel/IOFactory.php';

        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
            $sheet = $objPHPExcel->getSheet(0); 
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $row = 1;

            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                    NULL,
                                    TRUE,
                                    FALSE)[0];

            foreach($rowData as $key=>$value) {
                if($rowData[$key] == 'Main Type')
                    $epaymenttype1 = $key;

                if($rowData[$key] == 'Sub Type')
                    $esubtype1 = $key;

                if($rowData[$key] == 'Accounts ID')
                    $eaccountsid1 = $key;
 
                if($rowData[$key] == 'Account name')
                    $eaccountname1 = $key;

                if($rowData[$key] == 'Plan Name')
                    $eplanname1 = $key;

                if($rowData[$key] == 'Plan Status(OP+IP/OP/IP)')
                    $epstatus1 = $key;

                if($rowData[$key] == 'Copay Amount')
                    $ecopayamount1 = $key;

                if($rowData[$key] == 'Copay Percentage')
                    $ecopaypercentage1 = $key;

                if($rowData[$key] == 'All(Yes/No)')
                    $eall1 = $key;

                if($rowData[$key] == 'Limit Status(Overall/Visit)')
                    $elimitstatus1 = $key;

                if($rowData[$key] == 'Smart Applicable(Yes/No)')
                    $esmartapplicable1 = $key;

                if($rowData[$key] == 'Overall OP Limit')
                    $eoveralloplimit1 = $key;

                if($rowData[$key] == 'Visit OP Limit')
                    $evisitoplimit1 = $key;

                if($rowData[$key] == 'Overall Ip Limit')
                    $eoveralliplimit1 = $key;

                if($rowData[$key] == 'Visit IP Limit')
                    $evisitiplimit1 = $key;

                if($rowData[$key] == 'Department Limit(Yes/No)')
                    $edepartmentlimit1 = $key;

                if($rowData[$key] == 'Pharmacy Limit')
                    $epharmacylimit1 = $key;

                if($rowData[$key] == 'Lab Limit')
                    $elablimit1 = $key;

                if($rowData[$key] == 'Radiology Limit')
                    $eradiologylimit1 = $key;

                if($rowData[$key] == 'Services Limit')
                    $eserviceslimit1 = $key;

                if($rowData[$key] == 'Validity End(DD/MM/YYYY)')
                    $eexpirydate1 = $key;
            }		

            for ($row = 2; $row <= $highestRow; $row++){ 
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                        NULL,
                                        TRUE,
                                        FALSE)[0];

                $epaymenttype = $rowData[$epaymenttype1];
                $esubtype = $rowData[$esubtype1];
                $eaccountsid = $rowData[$eaccountsid1];
                $eaccountname = $rowData[$eaccountname1];
                $eplanname=$rowData[$eplanname1];
                $epstatus=$rowData[$epstatus1];
                $ecopayamount=$rowData[$ecopayamount1];
                $ecopaypercentage=$rowData[$ecopaypercentage1];
                $eoveralloplimit=$rowData[$eoveralloplimit1];
                $evisitoplimit=$rowData[$evisitoplimit1];
                $eoveralliplimit=$rowData[$eoveralliplimit1];
                $evisitiplimit=$rowData[$evisitiplimit1];
                $esmartapplicable=$rowData[$esmartapplicable1];
                $eall=$rowData[$eall1];
                $elimitstatus=$rowData[$elimitstatus1];
                $edepartmentlimit=$rowData[$edepartmentlimit1];
                $epharmacylimit=$rowData[$epharmacylimit1];
                $elablimit=$rowData[$elablimit1];
                $eradiologylimit=$rowData[$eradiologylimit1];
                $eserviceslimit=$rowData[$eserviceslimit1];
                $eexpirydate=$rowData[$eexpirydate1];
         
                if($eplanname!="") {
                    $eiscapitation='';
                    $eis_receivable='';

                    if($esmartapplicable=='Yes'){
                        $esmartapplicable12='1';
                    }else{
                        $esmartapplicable12='';
                    }

                    $eall=strtolower($eall);
                    if($eall=='yes'){
                        $forall='yes';
                    }else{
                        $forall='';
                    }

                    $elimitstatus=strtolower($elimitstatus);
                    if($elimitstatus=='overall'){
                        $elimitstatus12='Overall';
                    }else{
                        $elimitstatus12='Visit';
                    }

                    $edepartmentlimit=strtolower($edepartmentlimit);
                    if($edepartmentlimit=='yes'){
                        $edepartmentlimit='yes';
                    }else{
                        $edepartmentlimit='';
                    }

                    $date = str_replace('/', '-', $eexpirydate);
                    $newdate1=date('Y-m-d', strtotime($date));

                    if($newdate1=='1970-01-01'){
                        $newdate1=date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($eexpirydate));
                    }

                    $eplanname_new = trim($eplanname);
                    $eplanname_new1 = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $eplanname_new);

                    $epstatus = trim($epstatus);
                    $epstatus = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $epstatus);
                    $epstatus=strtoupper($epstatus);

                    if($epstatus=='OP'){
                        $epstatus1='OP';
                    }elseif($epstatus=='IP'){
                        $epstatus1='IP';
                    }else{
                        $epstatus1='OP+IP';
                    }

                    $eplanname_new2=strtoupper($eplanname_new1);

                    $planapplicable12='';
                    $plancondition='';
                    $recordstatus='ACTIVE';
                    $exclusions='';

                    $query1 = "INSERT into planupload_temp (maintype, subtype, accountname, planname, planstatus, plancondition, planfixedamount,planpercentage,
                    overalllimitop, overalllimitip, opvisitlimit,ipvisitlimit ,smartap,recordstatus,ipaddress, recorddate, username, planstartdate, planexpirydate,exclusions,forall,planapplicable,departmentlimit,pharmacylimit,lablimit,radiologylimit,serviceslimit,limit_status) 
                    values ('$epaymenttype', '$esubtype', '$eaccountsid', '$eplanname_new2', '$epstatus1', '$plancondition', '$ecopayamount',  '$ecopaypercentage', 
                    '$eoveralloplimit','$eoveralliplimit', '$evisitoplimit','$evisitiplimit', '$esmartapplicable12', '$recordstatus','$ipaddress', '$updatedatetime', '$username', '".$updatedate."','$newdate1','$exclusions','".$forall."','$planapplicable12','$edepartmentlimit','$epharmacylimit','$elablimit','$eradiologylimit','$eserviceslimit','$elimitstatus12')";

                    $execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                }
            }
            echo "<script>window.location.href = 'debtorsupload.php'</script>";

        } catch(Exception $e) {
            echo '<script>alert("File is Empty!.. Please retry Again");</script>';
            echo "<script>window.location.href = 'debtorsupload.php'</script>";
        }
    }
}

////////////// END OF EXCEL UPLOAD /////////////////////

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debtors Upload - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/debtorsupload-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker Scripts -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
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
        <span>Debtors Upload</span>
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
                        <a href="debtorsales.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Debtor Sales</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="debtorsreport.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Debtors Report</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="debtorsupload.php" class="nav-link">
                            <i class="fas fa-upload"></i>
                            <span>Debtors Upload</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="debitnotelist.php" class="nav-link">
                            <i class="fas fa-file-invoice"></i>
                            <span>Debit Note List</span>
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
                    <h2>Debtors Upload</h2>
                    <p>Upload debtor and plan data from Excel files to manage your healthcare accounts efficiently.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                </div>
            </div>

            <!-- Upload Form -->
            <div class="upload-form">
                <h3>Upload Excel Files</h3>
                <form name="cbform1" onSubmit="return validcheck();" method="POST" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Select File</label>
                            <div class="file-upload">
                                <input type="file" name="upload_file" id="upload_file" accept=".xls,.xlsx,.csv" required>
                                <label for="upload_file" class="file-upload-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <div class="file-upload-text">
                                        <h4>Choose file or drag and drop</h4>
                                        <p>Excel files (.xls, .xlsx, .csv) up to 10MB</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="upload-actions">
                        <button type="submit" name="frmflag_upload" value="Dr Upload" class="btn btn-primary">
                            <i class="fas fa-upload"></i> Upload Debtors
                        </button>
                        <button type="submit" name="plan_frmflag_upload" value="Plan Upload" class="btn btn-warning">
                            <i class="fas fa-upload"></i> Upload Plans
                        </button>
                        <button type="button" class="btn btn-outline" onclick="clearForm()">
                            <i class="fas fa-undo"></i> Clear
                        </button>
                    </div>
                </form>
            </div>

            <!-- Data Table -->
            <div class="data-table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Main Type</th>
                            <th>Sub Type</th>
                            <th>Dr Download</th>
                            <th>Dr View</th>
                            <th>Plan Download</th>
                            <th>Plan View</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php    
                        $query1 = "select * from master_subtype where recordstatus <> 'deleted' order by maintype ";
                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while ($res1 = mysqli_fetch_array($exec1)) {
                            $maintypeanum = $res1['maintype'];
                            $subtype = $res1["subtype"];
                            $auto_number = $res1["auto_number"];
                            $labtemplate = $res1["labtemplate"];
                            $pharmtemplate = $res1["pharmtemplate"];
                            $radtemplate = $res1["radtemplate"];
                            $sertemplate = $res1["sertemplate"];
                            $ippactemplate = $res1["ippactemplate"];
                            $bedtemp=$res1["bedtemplate"];
                            if($bedtemp==''){$bedtemp='master_bed';}
                            if($labtemplate==''){$labtemplate='master_lab';}
                            if($radtemplate==''){$radtemplate='master_radiology';}
                            if($sertemplate==''){$sertemplate='master_services';}
                            if($ippactemplate==''){$ippactemplate='master_ippackage';}
                            $query2 = "select * from master_paymenttype where auto_number = '$maintypeanum'";
                            $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res2 = mysqli_fetch_array($exec2);
                            $maintype = $res2['paymenttype'];
                        
                            $colorloopcount = $colorloopcount + 1;
                            $showcolor = ($colorloopcount & 1); 
                            if ($showcolor == 0) {
                                $colorcode = 'bgcolor="#CBDBFA"';
                            } else {
                                $colorcode = 'bgcolor="#ecf0f5"';
                            }

                            $query23 = "SELECT * from debtorsupload_temp order by auto_number desc limit 0, 1";
                            $exec23= mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res23 = mysqli_fetch_array($exec23);
                            $subtype12 = $res23["subtype"];
                            $paymenttype12 = $res23["paymenttype"];

                            $query_a = "SELECT * from planupload_temp order by auto_number desc limit 0, 1";
                            $exec_a= mysqli_query($GLOBALS["___mysqli_ston"], $query_a) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res_a = mysqli_fetch_array($exec_a);
                            $subtype2 = $res_a["subtype"];
                            $paymenttype2 = $res_a["maintype"];
                        ?>
                        
                        <tr <?php echo $colorcode; ?>>
                            <td><?=$colorloopcount;?></td>
                            <td><?php echo $maintype; ?></td>
                            <td><?php echo $subtype; ?></td>
                            <td>
                                <a target="_blank" href="debtorsupload_sample_xl.php?maintype=<?php echo $maintypeanum; ?>&&subtype=<?php echo $auto_number; ?>" class="action-link">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </td>
                            <td>
                                <?php if(($paymenttype12==$maintypeanum) and ($subtype12==$auto_number)){ ?>
                                    <a href="javascript: void(0)" onclick="viewUploadedData('debtor')" class="action-link">
                                        <i class="fas fa-eye"></i> View
                                    </a> 
                                <?php } ?>
                            </td>
                            <td>
                                <a target="_blank" href="planupload_sample_xl.php?maintype=<?php echo $maintypeanum; ?>&&subtype=<?php echo $auto_number; ?>" class="action-link">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </td>
                            <td>
                                <?php if(($paymenttype2==$maintypeanum) and ($subtype2==$auto_number)){ ?>
                                    <a href="javascript: void(0)" onclick="viewUploadedData('plan')" class="action-link">
                                        <i class="fas fa-eye"></i> View
                                    </a> 
                                <?php } ?>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/debtorsupload-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>