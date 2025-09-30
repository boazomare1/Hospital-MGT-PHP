<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
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
if($frmflag1 == 'frmflag1')
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
///////////////////
$total_debitamount=0;
$total_creditamount=0;
for($i=1;$i<=50;$i++)
{
if(isset($_REQUEST['serialnumberentries'.$i]))
{
$serialnumberentries = $_REQUEST['serialnumberentries'.$i];

if($serialnumberentries != '')
{
$entrytype = $_REQUEST['entrytype'.$i];
$ledger = $_REQUEST['ledger'.$i];
$ledgerno = $_REQUEST['ledgerno'.$i];
$amount = $_REQUEST['amount'.$i];
$amount = str_replace(',','',$amount);

if($entrytype == 'Cr')
{
$creditamount = $amount;
$debitamount = '0.00';
}
else
{
$debitamount = $amount;
$creditamount = '0.00';
}

if($ledgerno!=''){
$total_debitamount +=$debitamount;
$total_creditamount +=$creditamount;
}
}
}
}
if($total_debitamount == $total_creditamount)
{
//save the data into db
for($i=1;$i<=50;$i++)
{
if(isset($_REQUEST['serialnumberentries'.$i]))
{
$serialnumberentries = $_REQUEST['serialnumberentries'.$i];

if($serialnumberentries != '')
{
$entrytype = $_REQUEST['entrytype'.$i];
$ledger = $_REQUEST['ledger'.$i];
$ledgerno = $_REQUEST['ledgerno'.$i];
$amount = $_REQUEST['amount'.$i];
$amount = str_replace(',','',$amount);
$billwise = $_REQUEST['billwise'.$i];
$remark = $_REQUEST['remark'.$i];
if($entrytype == 'Cr')
{
$creditamount = $amount;
$debitamount = '0.00';
}
else
{
$debitamount = $amount;
$creditamount = '0.00';
}
$costcenter = "";
if(isset($_REQUEST['costcenter'.$i]))
{
$costcenter = $_REQUEST['costcenter'.$i];
}
if($ledgerno!=''){
$pattern = '/[^a-zA-Z0-9\s]/';
$narration = preg_replace($pattern, '', $narration);
$remark = preg_replace($pattern, '', $remark);
$query7 = "insert into master_journalentries (`docno`, `entrydate`, `voucheranum`, `vouchertype`, `selecttype`, `ledgerid`, `ledgername`, `cost_center`,  `transactionamount`, `creditamount`, `debitamount`, `status`, `ipaddress`, `username`, `updatedatetime`, `locationcode`, `locationname`, `narration`,`remarks`)
values('$docno','$entrydate','','JOURNAL','$entrytype','$ledgerno','$ledger', '$costcenter' , '$amount', '$creditamount', '$debitamount','','$ipaddress','$username','$updatedatetime','$locationcode','$locationname','$narration','$remark')";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
}
}
}
}
if (isset($_SESSION['items'])) {
unset($_SESSION['items']);
}

}
else
{

if (isset($_SESSION['items'])) {
unset($_SESSION['items']);
}
// do not save the data into db
for($i=1;$i<=50;$i++)
{
if(isset($_REQUEST['serialnumberentries'.$i]))
{
$serialnumberentries = $_REQUEST['serialnumberentries'.$i];

if($serialnumberentries != '')
{
$entrytype = $_REQUEST['entrytype'.$i];
$ledger = $_REQUEST['ledger'.$i];
$ledgerno = $_REQUEST['ledgerno'.$i];
$amount = $_REQUEST['amount'.$i];
$amount = str_replace(',','',$amount);
$billwise = $_REQUEST['billwise'.$i];
$remark = $_REQUEST['remark'.$i];
if($entrytype == 'Cr')
{
$creditamount = $amount;
$debitamount = '0.00';
}
else
{
$debitamount = $amount;
$creditamount = '0.00';
}
$costcenter = "";
if(isset($_REQUEST['costcenter'.$i]))
{
$costcenter = $_REQUEST['costcenter'.$i];
}
if($ledgerno!=''){
$_SESSION['items'][$i] = array('entrytype' => $entrytype, 'ledger' => $ledger, 'ledgerno' => $ledgerno, 'amount' => $amount, 'billwise' => $billwise, 'remark' => $remark,'costcenter' => $costcenter);
}
}
}
}
header("location:entries.php");
}
////////////////
//exit;
?>
<script>
window.open("journalprint.php?billnumber=<?php echo $docno; ?>", "OriginalWindow", 'width=522,height=650,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
window.open("entries.php?st=success","_self")
</script>
<?php
}
?>
<?php
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journal Entries - MedStar</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/entries-modern.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/datetimepicker_css.css">
    <script src="js/datetimepicker_css.js"></script>
    <script src="js/autocompletebuild_ledger.js"></script>
    <script src="js/autocompletebuild_costcenter.js"></script>
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
        <span>Journal Entries</span>
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
                        <a href="entries.php" class="nav-link active">
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
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <div id="alertContainer"></div>

            <div class="page-header">
                <h2 class="page-title">📝 Journal Entries</h2>
                <p class="page-subtitle">Create new journal entries for accounting</p>
            </div>

            <div class="form-container">
                <form id="form1" name="form1" method="post" action="entries.php" onSubmit="return entries()">
                    <input type="hidden" name="frmflag1" value="frmflag1">
                    <input type="hidden" name="entryid" value="<?php echo $docno; ?>">
                    <input type="hidden" name="serialnumber" id="serialnumber" value="1">
                    <input type="hidden" name="vamount" id="vamount" value="0.00">

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

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Entry
                        </button>
                        <button type="button" class="btn btn-outline" onclick="refreshData()">
                            <i class="fas fa-refresh"></i> Refresh
                        </button>
                    </div>
                </form>
            </div>

            <div class="data-container">
                <div class="data-header">
                    <h3 class="data-title">Journal Entry Details</h3>
                    <button type="button" class="btn btn-outline btn-sm" id="addmainledger">
                        <i class="fas fa-plus"></i> Add Ledger
                    </button>
                </div>

                <div class="table-container">
                    <table class="data-table" id="maintableledger">
                        <thead>
                            <tr>
                                <th>Entry Type</th>
                                <th>Ledger</th>
                                <th>Cost Center</th>
                                <th>Amount</th>
                                <th>Bill Wise</th>
                                <th>Remarks</th>
                                <th>Action</th>
                                <th>Credit</th>
                                <th>Debit</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="insertrow1">
                                <td>
                                    <input id="serialnumberentries1" name="serialnumberentries1" type="hidden" value="1" readonly="">
                                    <select name="entrytype1" id="entrytype1" onChange="return FillAmt(1)" class="form-control">
                                        <option value="Dr" selected="selected">Dr</option>
                                        <option value="Cr">Cr</option>
                                    </select>
                                </td>
                                <td>
                                    <input id="ledger1" class="form-control clientglaccountsc" name="ledger1" type="text">
                                    <input id="ledgerno1" class="form-control" name="ledgerno1" type="hidden">
                                    <input id="billwise1" class="form-control" name="billwise1" type="hidden">
                                </td>
                                <td id="costcenter_tdcontent1"></td>
                                <td>
                                    <input class="form-control" id="amount1" name="amount1" type="text" value="0.00" onBlur="addcommas(this.id)" onKeyDown="return numbervaild(event)" onFocus="return Dis(1)" onKeyUp="return FillAmt(1)" style="text-align:right;">
                                </td>
                                <td>&nbsp;</td>
                                <td>
                                    <textarea class="form-control" id="remark1" name="remark1" rows="2" cols="15"></textarea>
                                </td>
                                <td>
                                    <select id="selectact1" name="selectact1" class="form-control" style="display:none">
                                        <option value="1">New Ref</option>
                                        <option value="2">Agst Ref</option>
                                        <option value="3">On Account</option>
                                    </select>
                                </td>
                                <td>
                                    <input id="cramount1" name="cramount1" type="text" readonly="readonly" value="" class="form-control" style="text-align:right; border:none; background-color:transparent;">
                                </td>
                                <td>
                                    <input id="dramount1" name="dramount1" type="text" readonly="readonly" value="0.00" class="form-control" style="text-align:right; border:none; background-color:transparent;">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline btn-sm" onClick="return btnDeleteClickindustry(1)">
                                        <i class="fas fa-trash"></i> Del
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7" style="text-align: right; font-weight: bold;">Total:</td>
                                <td>
                                    <input id="totalcr" name="totalcr" type="text" readonly="readonly" value="0.00" class="form-control" style="text-align:right; border:none; background-color:transparent; font-weight: bold;">
                                </td>
                                <td>
                                    <input id="totaldr" name="totaldr" type="text" readonly="readonly" value="0.00" class="form-control" style="text-align:right; border:none; background-color:transparent; font-weight: bold;">
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <?php if(isset($_SESSION['items']) && count($_SESSION['items']) > 0) { ?>
            <div class="data-container">
                <div class="data-header">
                    <h3 class="data-title">Previous Unsuccessful Entries</h3>
                </div>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Entry Type</th>
                                <th>Ledger</th>
                                <th>Amount</th>
                                <th>Remarks</th>
                                <th>Cost Center</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sno = 1;
                            foreach($_SESSION['items'] as $item) {
                                echo "<tr>";
                                echo "<td>".$item['entrytype']."</td>";
                                echo "<td>".$item['ledger']."</td>";
                                echo "<td>".$item['amount']."</td>";
                                echo "<td>".$item['remark']."</td>";
                                echo "<td>".$item['costcenter']."</td>";
                                echo "</tr>";
                                $sno++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php } ?>
        </main>
    </div>

    <script src="js/entries-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
