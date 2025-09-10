<?php


session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

$username = $_SESSION["username"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];

$docno = $_SESSION['docno'];

$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$errmsg = "";

$bgcolorcode = "";

$colorloopcount = "";


$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

$locationname  = $res["locationname"];

$locationcode = $res["locationcode"];



if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1')

{



	$roleid = $_REQUEST["roleid"];

	$rolename = $_REQUEST["rolename"];
	
	
	
	$alert = $_REQUEST["alert"];
	
	//echo $length;


	$query2 = "select * from purchase_template where template_id = '$roleid' ";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res2 = mysqli_num_rows($exec2);

	if ($res2 == 0)

	{

		$query1 = "insert into purchase_template (template_id, template_name,locationname,locationcode, ipaddress, recorddate,username) 

		values ('$roleid', '$rolename','$locationname','$locationcode', '$ipaddress', '$updatedatetime','$username')";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$errmsg = "Success. New Template Updated.";

		$bgcolorcode = 'success';

		

	}

	else

	{

		$errmsg = "Failed. Template Id Already Exists.";

		$bgcolorcode = 'failed';

	}


}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if (isset($_REQUEST["roleid"])) { $roleid = $_REQUEST["roleid"]; } else { $roleid = ""; }

if ($st == 'del')

{

	$delanum = $_REQUEST["anum"];

	$query3 = "update purchase_template set recordstatus = 'deleted' where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	
	$query33 = "delete from purchase_templatelinking where template_id = '$roleid' ";

	$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'activate')

{

	$delanum = $_REQUEST["anum"];

	$query3 = "update purchase_template set recordstatus = '' where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

}







$paynowbillprefix7 = 'PT-';
$paynowbillprefix17=strlen($paynowbillprefix7);
$query27 = "select * from purchase_template order by auto_number desc limit 0, 1";
$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));
$res27 = mysqli_fetch_array($exec27);
$billnumber7 = $res27["template_id"];
$billdigit7=strlen($billnumber7);
if ($billnumber7 == '')
{
	$billnumbercode7 =$paynowbillprefix7.'1';
		$openingbalance = '0.00';
}
else
{
	$billnumber7 = $res27["template_id"];
	$billnumbercode7 = substr($billnumber7,$paynowbillprefix17, $billdigit7);
	//echo $billnumbercode;
	$billnumbercode7 = intval($billnumbercode7);
	$billnumbercode7 = $billnumbercode7 + 1;
	$maxanum7 = $billnumbercode7;
	$billnumbercode7 = $paynowbillprefix7 .$maxanum7;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Template - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/vat-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker CSS -->
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />

    <!-- Date Picker Scripts -->
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
</head>

<script language="javascript">



function addsalutation1process1()

{

	//alert ("Inside Funtion");

	/*if (document.form1.salutation.value == "")

	{

		alert ("Please Enter Salutation Name.");

		document.form1.salutation.focus();

		return false;

	}

	if (document.form1.gender.value == "")

	{

		alert ("Please Select Gender.");

		document.form1.gender.focus();

		return false;

	}*/

}



function funcDeleteSalutation(varSalutationAutoNumber)

{

     var varSalutationAutoNumber = varSalutationAutoNumber;

	 var fRet;

	fRet = confirm('Are you sure want to delete this Template  '+varSalutationAutoNumber+'?');

	//alert(fRet);

	if (fRet == true)

	{

		alert ("Template Entry Delete Completed.");

		//return false;

	}

	if (fRet == false)

	{

		alert ("Template Entry Delete Not Completed.");

		return false;

	}



}







</script>

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
        <span>Purchase Template</span>
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
                        <a href="direct_purchase.php" class="nav-link">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Direct Purchase</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="direct_purchaseapproval.php" class="nav-link">
                            <i class="fas fa-check-circle"></i>
                            <span>Purchase Approval</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="template_purchase.php" class="nav-link">
                            <i class="fas fa-file-alt"></i>
                            <span>Purchase Template</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="purchase_order_edit_dp.php" class="nav-link">
                            <i class="fas fa-edit"></i>
                            <span>Purchase Order Edit</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php if (!empty($errmsg)): ?>
                    <div class="alert alert-<?php echo $bgcolorcode === 'success' ? 'success' : ($bgcolorcode === 'failed' ? 'error' : 'info'); ?>">
                        <i class="fas fa-<?php echo $bgcolorcode === 'success' ? 'check-circle' : ($bgcolorcode === 'failed' ? 'exclamation-triangle' : 'info-circle'); ?> alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Purchase Template</h2>
                    <p>Create and manage purchase templates for streamlined procurement processes.</p>
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

            <!-- Add Form Section -->
            <div class="add-form-section">
                <div class="add-form-header">
                    <i class="fas fa-plus-circle add-form-icon"></i>
                    <h3 class="add-form-title">Add New Purchase Template</h3>
                </div>
                
                <form id="templateForm" name="form1" method="post" action="template_purchase.php" class="add-form" onSubmit="return addsalutation1process1()">

                    <div class="form-group">
                        <label for="roleid" class="form-label">Template ID</label>
                        <input name="roleid" id="roleid" class="form-input" 
                               value="<?php echo $billnumbercode7; ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="rolename" class="form-label">Template Name</label>
                        <input name="rolename" id="rolename" class="form-input" 
                               placeholder="Enter template name..." autocomplete="off" required>
                    </div>

                    <div class="form-group" style="display:none">
                        <label for="alert" class="form-label">Alert</label>
                        <textarea name="alert" id="alert" class="form-input" rows="2"></textarea>
                    </div>

                    <div class="form-group">
						<input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />

                        <button type="submit" name="Submit" class="submit-btn">
                            <i class="fas fa-save"></i>
                            Create Template
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Data Table Section -->
            <div class="data-table-section">
                <div class="data-table-header">
                    <i class="fas fa-list data-table-icon"></i>
                    <h3 class="data-table-title">Existing Purchase Templates</h3>
                </div>

                <!-- Search Bar -->
                <div style="margin-bottom: 1rem;">
                    <div style="display: flex; gap: 1rem; align-items: center;">
                        <input type="text" id="searchInput" class="form-input" 
                               placeholder="Search template ID or name..." 
                               style="flex: 1; max-width: 300px;"
                               oninput="searchTemplates(this.value)">
                        <button type="button" class="btn btn-secondary" onclick="clearSearch()">
                            <i class="fas fa-times"></i> Clear
                        </button>
                    </div>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Template ID</th>
                            <th>Template Name</th>
                            <th>Template Mapping</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="templateTableBody">

                      <?php

	    $query1 = "select * from purchase_template where recordstatus <> 'deleted' order by template_id ";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res1 = mysqli_fetch_array($exec1))

		{

		$template_id = $res1["template_id"];

		$template_name = $res1['template_name'];

		$auto_number = $res1["auto_number"];
		

		//$defaultstatus = $res1["defaultstatus"];



		$colorloopcount = $colorloopcount + 1;

		$showcolor = ($colorloopcount & 1); 

		if ($showcolor == 0)

		{

			$colorcode = 'bgcolor="#CBDBFA"';

		}

		else

		{

			$colorcode = 'bgcolor="#ecf0f5"';

		}

		  

		?>

                        <tr>
                            <td><?php echo $colorloopcount; ?></td>
                            <td>
                                <span class="template-id-badge"><?php echo htmlspecialchars($template_id); ?></span>
                            </td>
                            <td><?php echo htmlspecialchars($template_name); ?></td>
                            <td>
                                <a href="template_mapping.php?template_id=<?php echo $template_id; ?>" class="btn btn-outline btn-sm">
                                    <i class="fas fa-link"></i> Template Mapping
                                </a>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn delete" 
                                            onclick="confirmDelete('<?php echo htmlspecialchars($template_id); ?>', '<?php echo $auto_number; ?>')"
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <a href="edit_purchase_template.php?st=edit&&anum=<?php echo $auto_number; ?>" 
                                       class="action-btn edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                      <?php

		}

		?>

           <tr>

                        <td align="middle" colspan="4" >&nbsp;</td>

                      </tr>

                    </tbody>

                  </table>


              </form>

                </td>

            </tr>

            <tr>

              <td>&nbsp;</td>

            </tr>

        </table></td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

    </table>

                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/template-purchase-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>



