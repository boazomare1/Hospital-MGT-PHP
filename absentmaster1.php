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

$totaldays1 = '';

$proratatotaldays1 = '';

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1')

{

	$totaldays = $_REQUEST['totaldays'];

	$formula = $_REQUEST['formula'];

	$proratatotaldays = $_REQUEST['proratatotaldays'];

	

	$query2 = "select * from master_absent where componentname = 'ABSENT'";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res2 = mysqli_num_rows($exec2);

	if ($res2 == 0)

	{

		$query1 = "insert into master_absent (componentanum, componentname, totaldays, formula, ipaddress, updatedatetime, username, proratatotaldays) 

		values ('5', 'ABSENT', '$totaldays', '$formula', '$ipaddress', '$updatedatetime', '$username', '$proratatotaldays')";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$errmsg = "Success. Added Successfully.";

		$bgcolorcode = 'success';

		

	}

	else

	{

		$query2 = "update master_absent set totaldays = '$totaldays', proratatotaldays = '$proratatotaldays', formula = '$formula', updatedatetime = '$updatedatetime' where componentanum = '5'";

		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		

		$errmsg = "Success. Updated Successfully.";

		$bgcolorcode = 'success';

	}

	

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == 'edit')

{

	$editanum = $_REQUEST["anum"];

	$query3 = "select * from master_absent where auto_number = '$editanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res3 = mysqli_fetch_array($exec3);

	$totaldays1 = $res3['totaldays'];

	$proratatotaldays1 = $res3['proratatotaldays'];

	$formula1 = $res3['formula'];

	if($formula1 == '1')

	{

		$calc1 = 'BASIC';

	}

	else if($formula1 == '1+2')

	{

		$calc1 = 'BASIC+HRA';

	}

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedStar Hospital Management - Absent Master</title>
    <link rel="stylesheet" href="css/absent-modern.css">
</head>
<body>
    <!-- Modern MedStar Hospital Management Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Employee Absence Policy Management System</p>
    </header>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Dashboard</a>
        <span>›</span>
        <a href="#">Human Resources</a>
        <span>›</span>
        <span>Absent Master</span>
    </nav>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Page Header -->
        <div class="page-header">
            <h2 class="page-title">
                <span class="section-icon">📋</span>
                Absent Master Management
            </h2>
            <p class="page-subtitle">Configure employee absence policies and working day calculations for payroll processing.</p>
        </div>

        <!-- Absent Policy Form Section -->
        <div class="form-section">
            <div class="section-header">
                <span class="section-icon">⚙️</span>
                <h3 class="section-title">Configure Absent Policy</h3>
            </div>

            <!-- Status Messages -->
            <?php if ($errmsg != ''): ?>
            <div class="alert alert-success">
                <span class="alert-icon">✅</span>
                <span class="alert-text"><?php echo htmlspecialchars($errmsg); ?></span>
            </div>
            <?php endif; ?>

            <form name="form1" id="form1" method="post" action="absentmaster1.php" onSubmit="return addward1process1()">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="totaldays" class="form-label">Total Working Days *</label>
                        <input name="totaldays" id="totaldays" value="<?php echo htmlspecialchars($totaldays1); ?>" 
                               class="form-input" placeholder="Enter total working days" required />
                        <small class="form-help">Number of working days in the month for absence calculation</small>
                    </div>

                    <div class="form-group">
                        <label for="formula" class="form-label">Calculation Based On *</label>
                        <select name="formula" id="formula" class="form-select" required>
                            <?php if($formula1 != ''): ?>
                                <option value="<?php echo htmlspecialchars($formula1); ?>" selected="selected"><?php echo htmlspecialchars($calc1); ?></option>
                            <?php endif; ?>
                            <option value="">Select calculation basis</option>
                            <option value="1">BASIC</option>
                            <option value="1+2">BASIC + HRA</option>
                        </select>
                        <small class="form-help">Select the salary component basis for absence deductions</small>
                    </div>
                </div>

                <!-- Hidden Fields -->
                <input type="hidden" name="proratatotaldays" id="proratatotaldays" value="<?php echo htmlspecialchars($proratatotaldays1); ?>" />
                <input type="hidden" name="frmflag" value="addnew" />
                <input type="hidden" name="frmflag1" value="frmflag1" />

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button type="submit" name="Submit" class="btn btn-primary">
                        <span class="btn-icon">💾</span>
                        <span class="btn-text">Save Policy</span>
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <span class="btn-icon">🔄</span>
                        <span class="btn-text">Reset Form</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Existing Policies Section -->
        <div class="data-section">
            <div class="section-header">
                <span class="section-icon">📊</span>
                <h3 class="section-title">Existing Absent Policies</h3>
            </div>

            <!-- Data Table -->
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Component Name</th>
                            <th>Total Days</th>
                            <th>Calculation Basis</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query1 = "select * from master_absent where status <> 'deleted'";
                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                        
                        if (mysqli_num_rows($exec1) == 0): ?>
                        <tr>
                            <td colspan="4" class="no-data">
                                <div class="no-data-content">
                                    <span class="no-data-icon">📋</span>
                                    <span class="no-data-text">No absent policies found. Create your first policy using the form above.</span>
                                </div>
                            </td>
                        </tr>
                        <?php else:
                        while ($res1 = mysqli_fetch_array($exec1)):
                            $componentname = $res1["componentname"];
                            $auto_number = $res1["auto_number"];
                            $totaldays = $res1['totaldays'];
                            $proratatotaldays = $res1['proratatotaldays'];
                            $formula = $res1["formula"];
                            
                            if($formula == '1') {
                                $calcfrom = 'BASIC';
                            } else {
                                $calcfrom = 'BASIC + HRA';
                            }
                        ?>
                        <tr>
                            <td class="component-cell">
                                <span class="component-icon">📋</span>
                                <span class="component-name"><?php echo htmlspecialchars($componentname); ?></span>
                            </td>
                            <td class="days-cell">
                                <span class="days-number"><?php echo htmlspecialchars($totaldays); ?></span>
                                <span class="days-label">days</span>
                            </td>
                            <td class="basis-cell">
                                <span class="basis-text"><?php echo htmlspecialchars($calcfrom); ?></span>
                            </td>
                            <td class="action-cell">
                                <a href="absentmaster1.php?st=edit&&anum=<?php echo $auto_number; ?>" 
                                   class="btn btn-secondary btn-small" title="Edit Policy">
                                    <span class="btn-icon">✏️</span>
                                    <span class="btn-text">Edit</span>
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
    function addward1process1() {
        if(document.getElementById("totaldays").value == "") {
            alert("Please Enter Total Working Days");
            document.getElementById("totaldays").focus();
            return false;
        }
        
        if(isNaN(document.getElementById("totaldays").value)) {
            alert("Please Enter Numbers Only");
            document.getElementById("totaldays").focus();
            return false;
        }
        
        if(document.getElementById("formula").value == "") {
            alert("Please Select Calculation Basis");
            document.getElementById("formula").focus();
            return false;
        }
        
        return true;
    }
    </script>
</body>
</html>



