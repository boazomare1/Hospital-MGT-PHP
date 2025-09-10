<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

$username = $_SESSION["username"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$errmsg = "";

$bgcolorcode = "";

$colorloopcount = "";

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1')

{

	include ("backupsoftwarecode1.php");

	

	header ("location:backupsoftware1.php?st=success");

	exit;

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == 'del')

{

	$delanum = $_REQUEST["anum"];

	

	$query3 = "select * from master_backupsoftware where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res3 = mysqli_fetch_array($exec3);

	$deletefilename = $res3['backupfilename'];

	

	unlink('zbackupsoftwarefiles/'.$deletefilename.'');



	$query3 = "delete from master_backupsoftware where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));



	header ("location:backupsoftware1.php?st=deleted");

	exit;

}

if ($st == 'success')

{

	$errmsg = "Success. Software Backup Completed. Please Download & Save File From List Given Below For Future Reference.";

	$bgcolorcode = 'success';

}

if ($st == 'deleted')

{

	$errmsg = "Success. Software Backup Delete Completed.";

	$bgcolorcode = 'success';

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedStar Hospital Management - Software Backup</title>
    <link rel="stylesheet" href="css/backup-modern.css">
</head>
<body>
    <!-- Modern MedStar Hospital Management Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Software Backup Management System</p>
    </header>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Dashboard</a>
        <span>›</span>
        <a href="#">System Administration</a>
        <span>›</span>
        <span>Software Backup</span>
    </nav>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Page Header -->
        <div class="page-header">
            <h2 class="page-title">
                <span class="section-icon">💾</span>
                Software Backup Management
            </h2>
            <p class="page-subtitle">Create and manage software backups for system recovery and maintenance.</p>
        </div>

        <!-- Backup Action Section -->
        <div class="form-section">
            <div class="section-header">
                <span class="section-icon">🔄</span>
                <h3 class="section-title">Create New Backup</h3>
            </div>

            <!-- Status Messages -->
            <?php if ($st == 'success'): ?>
            <div class="alert alert-success">
                <span class="alert-icon">✅</span>
                <span class="alert-text"><?php echo htmlspecialchars($errmsg); ?></span>
            </div>
            <?php endif; ?>

            <?php if ($st == 'deleted'): ?>
            <div class="alert alert-info">
                <span class="alert-icon">ℹ️</span>
                <span class="alert-text"><?php echo htmlspecialchars($errmsg); ?></span>
            </div>
            <?php endif; ?>

            <form name="form1" id="form1" method="post" action="backupsoftware1.php">
                <div class="backup-action">
                    <div class="backup-info">
                        <p>Click the button below to create a new software backup. This process will create a compressed archive of your system files.</p>
                        <div class="backup-warning">
                            <span class="warning-icon">⚠️</span>
                            <span>Please ensure you have sufficient disk space before proceeding.</span>
                        </div>
                    </div>
                    <div class="backup-button">
                        <input type="hidden" name="frmflag1" value="frmflag1" />
                        <button type="submit" name="Submit" onClick="return funcTakeBackup1()" class="btn btn-primary">
                            <span class="btn-icon">💾</span>
                            <span class="btn-text">Create Software Backup Now</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Existing Backups Section -->
        <div class="data-section">
            <div class="section-header">
                <span class="section-icon">📋</span>
                <h3 class="section-title">Existing Backups</h3>
            </div>

            <!-- Data Table -->
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th width="10%">Actions</th>
                            <th width="45%">File Name</th>
                            <th width="30%">File Date & Time</th>
                            <th width="15%">Download</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query1 = "select * from master_backupsoftware order by auto_number desc";
                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                        
                        if (mysqli_num_rows($exec1) == 0): ?>
                        <tr>
                            <td colspan="4" class="no-data">
                                <div class="no-data-content">
                                    <span class="no-data-icon">📁</span>
                                    <span class="no-data-text">No backup files found. Create your first backup using the form above.</span>
                                </div>
                            </td>
                        </tr>
                        <?php else:
                        while($res1 = mysqli_fetch_array($exec1)):
                            $auto_number = $res1["auto_number"];
                            $backupfilename = $res1["backupfilename"];
                            $backupfiledate = $res1["backupfiledate"];
                        ?>
                        <tr>
                            <td class="action-cell">
                                <a href="backupsoftware1.php?st=del&&anum=<?php echo $auto_number; ?>" 
                                   onClick="return funcDeleteBackup1('<?php echo htmlspecialchars($backupfilename); ?>')"
                                   class="btn btn-danger btn-small" title="Delete Backup">
                                    <span class="btn-icon">🗑️</span>
                                </a>
                            </td>
                            <td class="filename-cell">
                                <span class="file-icon">📦</span>
                                <span class="filename"><?php echo htmlspecialchars($backupfilename); ?></span>
                            </td>
                            <td class="date-cell">
                                <span class="date-icon">📅</span>
                                <span class="date-text"><?php echo htmlspecialchars($backupfiledate); ?></span>
                            </td>
                            <td class="download-cell">
                                <a href="backupsoftwaredownload1.php?filename=<?php echo urlencode($backupfilename); ?>" 
                                   class="btn btn-secondary btn-small" title="Download Backup">
                                    <span class="btn-icon">⬇️</span>
                                    <span class="btn-text">Download</span>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
    function funcTakeBackup1() {
        var fRet = confirm('Are you sure you want to create a software backup now?');
        if (fRet) {
            alert("Proceeding to create software backup. Please wait a moment.");
            return true;
        } else {
            alert("Software backup cancelled.");
            return false;
        }
    }

    function funcDeleteBackup1(varDeleteFileName) {
        var fRet = confirm('Are you sure you want to delete the backup file "' + varDeleteFileName + '"?');
        if (fRet) {
            alert("Success. Software backup deletion completed.");
            return true;
        } else {
            alert("Failed. Software backup deletion cancelled.");
            return false;
        }
    }
    </script>
</body>
</html>



