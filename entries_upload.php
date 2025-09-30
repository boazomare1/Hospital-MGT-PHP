<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

$username = $_SESSION["username"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];



$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$entrydate = date('Y-m-d');

$errmsg = "";

$bgcolorcode = "";

$colorloopcount = "";

$dummy = '';

$cr_amount="";

$sessiondocno = $_SESSION['docno'];



$query31 = "select fromyear,toyear from master_financialyear where status = 'Active' order by auto_number desc";

$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));

$res31 = mysqli_fetch_array($exec31);

$finfromyear = $res31['fromyear'];

$fintoyear = $res31['toyear'];



if(isset($_REQUEST['frmflag1'])) { $frmflag1 = $_REQUEST['frmflag1']; } else { $frmflag1 = ''; }

if(isset($_REQUEST['frmflag2'])) { $frmflag2 = $_REQUEST['frmflag2']; } else { $frmflag2 = ''; }

if($frmflag2 == 'frmflag2')
{


visitcreate:
$paynowbillprefix = 'EN-';

$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select * from master_journalentries where docno like 'EN-%' order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["docno"];

$billdigit=strlen($billnumber);

if ($billnumber == '')

{

$billnumbercode ='EN-'.'1';

}

else

{

$billnumber = $res2["docno"];

$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);



$billnumbercode = intval($billnumbercode);

$billnumbercode = $billnumbercode + 1;

$maxanum = $billnumbercode;

$billnumbercode = 'EN-' .$maxanum;

}

$docno = $billnumbercode;

$query2 = "select * from master_journalentries where docno ='$docno'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_num_rows($exec2);
if($res2>0){
goto visitcreate;
}



$entryid = $_REQUEST['entryid'];

$entrydate = $_REQUEST['entrydate'];

$entrydate = date('Y-m-d',strtotime($entrydate));

$narration = $_REQUEST['narration'];

$locationcode = $_REQUEST['location'];



$query66 = "select locationname from master_location where locationcode = '$locationcode'";

$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));

$res66 = mysqli_fetch_array($exec66);

$locationname = $res66['locationname'];



for($i=1;$i<$_REQUEST['totalrec'];$i++)
{
$ledgerno = $_REQUEST['ledgerno'.$i];


if($ledgerno != '')
{

$entrytype = $_REQUEST['entrytype'.$i];

$ledger = $_REQUEST['ledger'.$i];

$remark = $_REQUEST['remark'.$i];

$creditamount = $_REQUEST['creditamount'.$i];
$debitamount = $_REQUEST['debitamount'.$i];
$amount = $_REQUEST['amount'.$i];

$amount = str_replace(',','',$amount);

$costcenter = "";
if(isset($_REQUEST['costcenter'.$i]))
{
$costcenter = $_REQUEST['costcenter'.$i];
}

$query7 = "insert into master_journalentries (`docno`, `entrydate`, `voucheranum`, `vouchertype`, `selecttype`, `ledgerid`, `ledgername`, `cost_center`,  `transactionamount`, `creditamount`, `debitamount`, `status`, `ipaddress`, `username`, `updatedatetime`, `locationcode`, `locationname`, `narration`,`remarks`)

values('$docno','$entrydate','','JOURNAL','$entrytype','$ledgerno','$ledger', '$costcenter' , '$amount', '$creditamount', '$debitamount','','$ipaddress','$username','$updatedatetime','$locationcode','$locationname','$narration','$remark')";

$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));

}


}

//exit;
?>

<script>
window.open("journalprint.php?billnumber=<?php echo $docno; ?>", "OriginalWindow", 'width=522,height=650,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
window.open("entries_upload.php?st=success","_self")
</script>

<?php


}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journal Entries Upload - MedStar</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/entries_upload-modern.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/datetimepicker_css.css">
    <script src="js/datetimepicker_css.js"></script>
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
        <span>Journal Entries Upload</span>
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
                        <a href="entries_upload.php" class="nav-link active">
                            <i class="fas fa-upload"></i>
                            <span>Upload Entries</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <div id="alertContainer"></div>

            <div class="page-header">
                <h2 class="page-title">📤 Journal Entries Upload</h2>
                <p class="page-subtitle">Upload journal entries from Excel or CSV file</p>
            </div>

            <div class="form-container">
                <form id="form1" name="form1" method="post" action="entries_upload.php" enctype="multipart/form-data">
                    <input type="hidden" name="frmflag2" value="frmflag2">
                    <input type="hidden" name="entryid" value="<?php echo $docno; ?>">
                    <input type="hidden" name="totalrec" id="totalrec" value="1">

                    <div class="form-row">
                        <div class="form-group">
                            <label for="entrydate" class="form-label">Entry Date *</label>
                            <input type="text" class="form-control from_date" id="entrydate" name="entrydate" value="<?php echo $entrydate; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="location" class="form-label">Location *</label>
                            <select class="form-control" id="location" name="location" required>
                                <option value="">Select Location</option>
                                <?php
                                $query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' order by locationname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1))
                                {
                                    $locationname = $res1["locationname"];
                                    $locationcode = $res1["locationcode"];
                                    echo "<option value='$locationcode'>$locationname</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="narration" class="form-label">Narration</label>
                        <textarea class="form-control" id="narration" name="narration" rows="3" placeholder="Enter narration for this journal entry"></textarea>
                    </div>

                    <div class="file-upload-container">
                        <div class="file-upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <div class="file-upload-text">Upload Journal Entries File</div>
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
                            <i class="fas fa-upload"></i> Upload Entries
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
                    <h3 class="data-title">Upload Instructions</h3>
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
                                <td>Entry Type</td>
                                <td>Type of entry (Dr or Cr)</td>
                                <td><span class="status-badge status-valid">Yes</span></td>
                                <td>Dr</td>
                            </tr>
                            <tr>
                                <td>Ledger Code</td>
                                <td>Ledger account code</td>
                                <td><span class="status-badge status-valid">Yes</span></td>
                                <td>1001</td>
                            </tr>
                            <tr>
                                <td>Ledger Name</td>
                                <td>Ledger account name</td>
                                <td><span class="status-badge status-valid">Yes</span></td>
                                <td>Cash Account</td>
                            </tr>
                            <tr>
                                <td>Amount</td>
                                <td>Transaction amount</td>
                                <td><span class="status-badge status-valid">Yes</span></td>
                                <td>1000.00</td>
                            </tr>
                            <tr>
                                <td>Remarks</td>
                                <td>Additional remarks</td>
                                <td><span class="status-badge status-warning">No</span></td>
                                <td>Initial entry</td>
                            </tr>
                            <tr>
                                <td>Cost Center</td>
                                <td>Cost center code</td>
                                <td><span class="status-badge status-warning">No</span></td>
                                <td>Main</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script src="js/entries_upload-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
