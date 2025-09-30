<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

ini_set('memory_limit','-1');
$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$docno = $_SESSION['docno'];

$errmsg = '';

$bgcolorcode = '';

$query = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

$locationname  = $res["locationname"];

$locationcode = $res["locationcode"];


function readCSV($csvFile){

$file_handle = fopen($csvFile, 'r');

while (!feof($file_handle) ) {

$line_of_text[] = fgetcsv($file_handle, 1024);

}

fclose($file_handle);

return $line_of_text;

}

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1')
{
if(!empty($_FILES['upload_file']))

{

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


foreach($rowData as $key=>$value)
{


if($rowData[$key] == 'itemcode')

$itemcode = $key;

if($rowData[$key] == 'itemname')

$itemname = $key;

if($rowData[$key] == 'shortcode')

$shortcode = $key;

if($rowData[$key] == 'displayname')

$displayname = $key;

if($rowData[$key] == 'categoryname')

$categoryname = $key;

if($rowData[$key] == 'sampletype')

$sampletype = $key;

if($rowData[$key] == 'Sales Price')

$sales_price = $key;

if($rowData[$key] == 'externallab')

$externallab = $key;

if($rowData[$key] == 'Status')

$statuss = $key;

if($rowData[$key] == 'radiology')

$radiology = $key;

if($rowData[$key] == 'Income Ledger Code')

$income_ledger_code = $key;


}

for ($row = 2; $row <= $highestRow; $row++){

$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,

NULL,

TRUE,

FALSE)[0];

$item_code=$rowData[$itemcode ];

$item_name=$rowData[$itemname];

$item_name = addslashes($item_name);

$short_code=$rowData[$shortcode];

$display_name=$rowData[$displayname];

$category_name=$rowData[$categoryname];

$sample_type=$rowData[$sampletype];

$salesprice=$rowData[$sales_price];

$external_lab=$rowData[$externallab];

$stat_tuss=$rowData[$statuss];

$radd=$rowData[$radiology];

$ledger_code=$rowData[$income_ledger_code];


$query2 = "select itemname from master_lab where itemname = '" . $item_name . "'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in Query2" . mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_num_rows($exec2);
if ($res2 == 0 && $item_name!='')
{

$query1 = "insert into master_lab (itemcode, itemname,shortcode,displayname, categoryname,sampletype,rateperunit,externallab,status,radiology,ledgercode,username,locationname,location)
values ('$item_code', '$item_name','$short_code','$display_name','$category_name','$sample_type','$salesprice', '$external_lab','$stat_tuss','$radd','$ledger_code','$username','$locationname','$locationcode')";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));


$query2 = "insert into audit_master_lab (itemcode, itemname,shortcode,displayname, categoryname,sampletype,rateperunit,externallab,status,radiology,ledgercode,username,locationname,location)
values ('$item_code', '$item_name','$short_code','$display_name','$category_name','$sample_type','$salesprice', '$external_lab','$stat_tuss','$radd','$ledger_code','$username','$locationname','$locationcode')";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in Query2" . mysqli_error($GLOBALS["___mysqli_ston"]));


$query25 = 'SELECT templatename FROM `master_testtemplate` where testname="lab"';
$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

while ($res25 = mysqli_fetch_array($exec25))

{

$templatename = $res25["templatename"];

$querytemp1 = "insert into `$templatename` (itemcode, itemname, categoryname,  rateperunit, ipaddress,updatetime, description,ledgercode)
values ('$item_code', '$item_name', '$category_name',  '$salesprice','$ipaddress','$updatedatetime','manual','$ledger_code')";
$exectemp1 = mysqli_query($GLOBALS["___mysqli_ston"], $querytemp1) or die ("Error in querytemp1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

}


}

//  Insert row data array into your database of choice here

}

} catch(Exception $e) {

die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());

}

$errmsg = "Success. Lab Uploaded.";

$bgcolorcode = 'success';

}
else
{
$errmsg = "Upload Failed.";

$bgcolorcode = 'failed';
}


}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Data Import - MedStar</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/lab_dataimport-modern.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
    </header>

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

    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Home</a>
        <span>→</span>
        <span>Lab Data Import</span>
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
                        <a href="entries.php" class="nav-link">
                            <i class="fas fa-plus-circle"></i>
                            <span>New Entry</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="editentries.php" class="nav-link">
                            <i class="fas fa-edit"></i>
                            <span>Edit Entry</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="entriesreport.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Entries Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="entries_upload.php" class="nav-link">
                            <i class="fas fa-upload"></i>
                            <span>Upload Entries</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="lab_dataimport.php" class="nav-link active">
                            <i class="fas fa-flask"></i>
                            <span>Lab Data Import</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <div id="alertContainer"></div>

            <div class="page-header">
                <h2 class="page-title">🧪 Lab Data Import</h2>
                <p class="page-subtitle">Import laboratory test data from Excel or CSV file</p>
            </div>

            <div class="form-container">
                <form id="form1" name="form1" method="post" action="lab_dataimport.php" enctype="multipart/form-data">
                    <input type="hidden" name="frmflag1" value="frmflag1">

                    <div class="file-upload-container">
                        <div class="file-upload-icon">
                            <i class="fas fa-flask"></i>
                        </div>
                        <div class="file-upload-text">Upload Lab Data File</div>
                        <div class="file-upload-subtext">Drag and drop your Excel or CSV file here, or click to browse</div>
                        <input type="file" id="upload_file" name="upload_file" class="file-input" accept=".xlsx,.xls,.csv" required>
                        <button type="button" class="file-upload-btn">
                            <i class="fas fa-folder-open"></i> Choose File
                        </button>
                        <div class="file-info" style="display: none;"></div>
                    </div>

                    <div class="progress-container" style="display: none;">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 0%;"></div>
                        </div>
                        <div class="progress-text">Uploading...</div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload"></i> Import Lab Data
                        </button>
                        <button type="button" class="btn btn-outline" onclick="downloadTemplate()">
                            <i class="fas fa-download"></i> Download Template
                        </button>
                        <button type="button" class="btn btn-outline" onclick="refreshData()">
                            <i class="fas fa-refresh"></i> Refresh
                        </button>
                    </div>
                </form>
            </div>

            <div class="data-container">
                <div class="data-header">
                    <h3 class="data-title">Import Instructions</h3>
                </div>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Column</th>
                                <th>Description</th>
                                <th>Required</th>
                                <th>Example</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Item Code</td>
                                <td>Unique identifier for the lab test</td>
                                <td><span class="status-badge status-valid">Yes</span></td>
                                <td>LAB001</td>
                            </tr>
                            <tr>
                                <td>Item Name</td>
                                <td>Name of the lab test</td>
                                <td><span class="status-badge status-valid">Yes</span></td>
                                <td>Blood Sugar Test</td>
                            </tr>
                            <tr>
                                <td>Short Code</td>
                                <td>Abbreviated code for the test</td>
                                <td><span class="status-badge status-warning">No</span></td>
                                <td>BS</td>
                            </tr>
                            <tr>
                                <td>Display Name</td>
                                <td>Display name for the test</td>
                                <td><span class="status-badge status-warning">No</span></td>
                                <td>Blood Sugar</td>
                            </tr>
                            <tr>
                                <td>Category Name</td>
                                <td>Test category</td>
                                <td><span class="status-badge status-valid">Yes</span></td>
                                <td>Biochemistry</td>
                            </tr>
                            <tr>
                                <td>Sample Type</td>
                                <td>Type of sample required</td>
                                <td><span class="status-badge status-valid">Yes</span></td>
                                <td>Blood</td>
                            </tr>
                            <tr>
                                <td>Sales Price</td>
                                <td>Price of the test</td>
                                <td><span class="status-badge status-valid">Yes</span></td>
                                <td>150.00</td>
                            </tr>
                            <tr>
                                <td>External Lab</td>
                                <td>Whether test is done externally</td>
                                <td><span class="status-badge status-warning">No</span></td>
                                <td>No</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>Test status (Active/Inactive)</td>
                                <td><span class="status-badge status-valid">Yes</span></td>
                                <td>Active</td>
                            </tr>
                            <tr>
                                <td>Radiology</td>
                                <td>Whether test is radiology related</td>
                                <td><span class="status-badge status-warning">No</span></td>
                                <td>No</td>
                            </tr>
                            <tr>
                                <td>Income Ledger Code</td>
                                <td>Ledger code for accounting</td>
                                <td><span class="status-badge status-valid">Yes</span></td>
                                <td>4001</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php if ($frmflag1 == 'frmflag1') { ?>
            <div class="import-results">
                <div class="import-summary">
                    <div class="summary-card">
                        <div class="summary-card-icon">✅</div>
                        <div class="summary-card-value">Success</div>
                        <div class="summary-card-label">Import Status</div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-card-icon">📊</div>
                        <div class="summary-card-value"><?php echo isset($highestRow) ? $highestRow - 1 : 0; ?></div>
                        <div class="summary-card-label">Records Processed</div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-card-icon">🏥</div>
                        <div class="summary-card-value"><?php echo htmlspecialchars($locationname); ?></div>
                        <div class="summary-card-label">Location</div>
                    </div>
                </div>
                
                <div class="data-container">
                    <div class="data-header">
                        <h3 class="data-title">Import Results</h3>
                    </div>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Item Code</th>
                                    <th>Item Name</th>
                                    <th>Category</th>
                                    <th>Sample Type</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($highestRow)) {
                                    for ($row = 2; $row <= $highestRow; $row++) {
                                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE)[0];
                                        $item_code = $rowData[$itemcode];
                                        $item_name = $rowData[$itemname];
                                        $category_name = $rowData[$categoryname];
                                        $sample_type = $rowData[$sampletype];
                                        $salesprice = $rowData[$sales_price];
                                        $stat_tuss = $rowData[$statuss];
                                        
                                        if ($item_name != '') {
                                            echo "<tr>";
                                            echo "<td>$item_code</td>";
                                            echo "<td>$item_name</td>";
                                            echo "<td>$category_name</td>";
                                            echo "<td>$sample_type</td>";
                                            echo "<td>$salesprice</td>";
                                            echo "<td><span class='status-badge status-valid'>$stat_tuss</span></td>";
                                            echo "</tr>";
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php } ?>
        </main>
    </div>

    <script src="js/lab_dataimport-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
