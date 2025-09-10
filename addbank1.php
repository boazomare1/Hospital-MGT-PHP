<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION["username"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];

$errmsg = '';



if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1')

{



	$query1 = "select * from master_bank order by auto_number desc limit 0, 1";

	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

	$rowcount1 = mysqli_num_rows($exec1);

	if ($rowcount1 == 0)

	{

		$bankcode = 'BNK00000001';

	}

	else

	{

		$res1 = mysqli_fetch_array($exec1);

		$res1bankcode = $res1["bankcode"];

		$bankcode = substr($res1bankcode, 3, 8);

		$bankcode = intval($bankcode);

		$bankcode = $bankcode + 1;

	

		$maxanum = $bankcode;

		if (strlen($maxanum) == 1)

		{

			$maxanum1 = '0000000'.$maxanum;

		}

		else if (strlen($maxanum) == 2)

		{

			$maxanum1 = '000000'.$maxanum;

		}

		else if (strlen($maxanum) == 3)

		{

			$maxanum1 = '00000'.$maxanum;

		}

		else if (strlen($maxanum) == 4)

		{

			$maxanum1 = '0000'.$maxanum;

		}

		else if (strlen($maxanum) == 5)

		{

			$maxanum1 = '000'.$maxanum;

		}

		else if (strlen($maxanum) == 6)

		{

			$maxanum1 = '00'.$maxanum;

		}

		else if (strlen($maxanum) == 7)

		{

			$maxanum1 = '0'.$maxanum;

		}

		else if (strlen($maxanum) == 8)

		{

			$maxanum1 = $maxanum;

		}

		

		$bankcode = 'BNK'.$maxanum1;

	

		//echo $bankcode;

	}

	//echo $bankcode;





	//$bankcode=$_REQUEST["bankcode"];

	$bankcode = $_REQUEST["bankcode"];

	$companyname = $_REQUEST["companyname"];

	$bankname = $_REQUEST["bankname"];

	$bankname = strtoupper($bankname);

	$bankname = trim($bankname);

	$contactpersonname = $_REQUEST["contactpersonname"];

	$contactpersonname = strtoupper($contactpersonname);

	$contactpersonphone = $_REQUEST["contactpersonphone"];

	$branchname  = $_REQUEST["branchname"];

	$branchname = strtoupper($branchname);

	$branchname = trim($branchname);

	$netbankinglogin = $_REQUEST["netbankinglogin"];

	$netbankinglogin = strtoupper($netbankinglogin);

	$accountnumber = $_REQUEST["accountnumber"];

	$accounttype  = $_REQUEST["accounttype"];

	$currentbalance = $_REQUEST["currentbalance"];

	$commissionpercentage = $_REQUEST["commissionpercentage"];

	$phonenumber = $_REQUEST["phonenumber"];

	$mobilenumber  = $_REQUEST["mobilenumber"];

	$address  = $_REQUEST["address"];

	$remarks = $_REQUEST["remarks"];

	$remarks = strtoupper($remarks);

	$branchcode = $_REQUEST["branchcode"];

	$branchcode = strtoupper($branchcode);

	$swiftcode = $_REQUEST["swiftcode"];

	$swiftcode = strtoupper($swiftcode);

	$dateposted = $_REQUEST["dateposted"];

	$bankstatus = $_REQUEST["bankstatus"];

	$lastupdate = $updatedatetime;

	$lastupdateusername = $username;

	$lastupdateipaddress = $ipaddress;

	if($accountnumber=='')
		$accountnumber =$bankcode;
	

	$query2 = "select * from master_bank where accountnumber = '$accountnumber'";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

	$rowcount2 = mysqli_num_rows($exec2);

	if ($rowcount2 == 0)

	{

		$query1 = "insert into master_bank (bankcode, companyname, bankname, contactpersonname, contactpersonphone, 

		branchname, netbankinglogin, accountnumber, accounttype, currentbalance, commissionpercentage, 

		phonenumber, mobilenumber, address, remarks, bankstatus, branchcode, swiftcode, 

		lastupdate, lastupdateusername, lastupdateipaddress) 

		values ('$bankcode','$companyname', '$bankname', '$contactpersonname', '$contactpersonphone', 

		'$branchname', '$netbankinglogin', '$accountnumber', '$accounttype', '$currentbalance', '$commissionpercentage', 

		'$phonenumber','$mobilenumber', '$address', '$remarks', '$bankstatus', '$branchcode', '$swiftcode', 

		'$lastupdate', '$lastupdateusername', '$lastupdateipaddress')";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		

		header ("location:addbank1.php?st=success");

	}

	else

	{

		header ("location:addbank1.php?st=failed");

	}	



}

else

{

	$bankcode = '';

	$bankname = '';

	$contactpersonname = '';

	$contactpersonphone = '';

	$branchname  = '';

	$netbankinglogin = '';

	$accountnumber = '';

	$accounttype  = '';

	$currentbalance = '';

	$commissionpercentage = '';

	$phonenumber = '';

	$mobilenumber  = '';

	$address  = '';

	$remarks = '';

	$branchcode = '';

	$swiftcode = '';

	$dateposted = '';

	$bankstatus = '';

	$lastupdate = $updatedatetime;

	$lastupdateusername = $username;

	$lastupdateipaddress = $ipaddress;



}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == 'success')

{

	$errmsg = "Success. New Bank Updated.";

}

if ($st == 'failed')

{

	$errmsg = "Failed. Bank Account Number Already Exists.";

}



if ($st == 'del')

{

	$delanum = $_REQUEST["anum"];

	$query3 = "update master_bank set bankstatus = 'Deleted' where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

}



$query1 = "select * from master_bank order by auto_number desc limit 0, 1";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$rowcount1 = mysqli_num_rows($exec1);

if ($rowcount1 == 0)

{

	$bankcode = 'BNK00000001';

}

else

{

	$res1 = mysqli_fetch_array($exec1);

	$res1bankcode = $res1["bankcode"];

	$bankcode = substr($res1bankcode, 3, 8);

	$bankcode = intval($bankcode);

	$bankcode = $bankcode + 1;



	$maxanum = $bankcode;

	if (strlen($maxanum) == 1)

	{

		$maxanum1 = '0000000'.$maxanum;

	}

	else if (strlen($maxanum) == 2)

	{

		$maxanum1 = '000000'.$maxanum;

	}

	else if (strlen($maxanum) == 3)

	{

		$maxanum1 = '00000'.$maxanum;

	}

	else if (strlen($maxanum) == 4)

	{

		$maxanum1 = '0000'.$maxanum;

	}

	else if (strlen($maxanum) == 5)

	{

		$maxanum1 = '000'.$maxanum;

	}

	else if (strlen($maxanum) == 6)

	{

		$maxanum1 = '00'.$maxanum;

	}

	else if (strlen($maxanum) == 7)

	{

		$maxanum1 = '0'.$maxanum;

	}

	else if (strlen($maxanum) == 8)

	{

		$maxanum1 = $maxanum;

	}

	

	$bankcode = 'BNK'.$maxanum1;



	//echo $bankcode;

}

//echo $bankcode;





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Bank - <?php echo $companyname; ?></title>
    <link rel="stylesheet" href="css/addbank1-modern.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Alert Container -->
    <div id="alertContainer"></div>

    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title"><?php echo $companyname; ?></h1>
        <p class="hospital-subtitle">Bank Management System</p>
    </header>

    <!-- User Info Bar -->
    <div class="user-info-bar">
        <div class="user-info">
            <i class="fas fa-user"></i>
            <span>Welcome, <?php echo $username; ?></span>
        </div>
        <div class="datetime">
            <i class="fas fa-calendar"></i>
            <span><?php echo date('d M Y, h:i A'); ?></span>
        </div>
    </div>

    <!-- Navigation Breadcrumb -->
    <nav class="breadcrumb-nav">
        <div class="breadcrumb">
            <a href="index.php">Home</a>
            <span class="separator">/</span>
            <span>Bank Management</span>
            <span class="separator">/</span>
            <span>Add Bank</span>
        </div>
    </nav>

    <!-- Floating Menu Toggle -->
    <button id="menuToggle" class="floating-menu-toggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Left Sidebar -->
        <aside id="leftSidebar" class="left-sidebar">
            <div class="sidebar-header">
                <h3>Navigation</h3>
                <button id="sidebarToggle" class="sidebar-toggle">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            <nav class="sidebar-nav">
                <?php include ("includes/menu1.php"); ?>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-title">
                    <h2><i class="fas fa-university"></i> Bank Management</h2>
                    <p>Add new bank accounts and manage existing ones</p>
                </div>
                <div class="page-header-actions">
                    <button onclick="refreshPage()" class="btn btn-secondary">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button onclick="exportToExcel()" class="btn btn-secondary">
                        <i class="fas fa-file-excel"></i> Export
                    </button>
                </div>
            </div>

            <!-- Alert Messages -->
            <?php if ($errmsg != ''): ?>
                <div class="alert alert-<?php echo ($st == 'success') ? 'success' : 'error'; ?>">
                    <i class="fas fa-<?php echo ($st == 'success') ? 'check-circle' : 'exclamation-triangle'; ?> alert-icon"></i>
                    <span><?php echo $errmsg; ?></span>
                </div>
            <?php endif; ?>

            <!-- Existing Banks List -->
            <section class="existing-banks-section">
                <div class="section-header">
                    <h3><i class="fas fa-list"></i> Existing Banks</h3>
                </div>
                <div class="table-container">
                    <table class="banks-table">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Bank Name</th>
                                <th>Account No</th>
                                <th>Account Type</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $searchcontact = isset($_REQUEST["searchcontact"]);
                            $colorloopcount = '';
                            $query100 = "select * from master_bank where bankstatus = '' order by bankname";
                            $exec100 = mysqli_query($GLOBALS["___mysqli_ston"], $query100) or die ("Error in Query100".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res100 = mysqli_fetch_array($exec100))
                            {
                                $res100bankcode = $res100["bankcode"];
                                $res100bankname = $res100["bankname"];
                                $res100address = $res100["address"];
                                $res100phonenumber1 = $res100["phonenumber"];
                                $res100bankstatus = $res100["bankstatus"];
                                $res100bankstatus = strtoupper($res100bankstatus);
                                $res100auto_number = $res100["auto_number"];
                                $res100accountnumber = $res100["accountnumber"];
                                $res100accounttype = $res100["accounttype"];
                            
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
                                <td class="action-cell">
                                    <a href="addbank1.php?st=del&&anum=<?php echo $res100auto_number; ?>" 
                                       onclick="return confirmDelete('<?php echo $res100bankname; ?>')" 
                                       class="btn-delete" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                                <td><?php echo $res100bankname; ?></td>
                                <td><?php echo $res100accountnumber; ?></td>
                                <td><?php echo $res100accounttype; ?></td>
                                <td class="action-cell">
                                    <a href="editbank1.php?bankcode=<?php echo $res100bankcode; ?>" 
                                       class="btn-edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- New Bank Form -->
            <section class="new-bank-section">
                <div class="section-header">
                    <h3><i class="fas fa-plus-circle"></i> Add New Bank</h3>
                    <p class="mandatory-note">* Indicates mandatory fields</p>
                </div>
                
                <form name="form1" id="form1" method="post" action="addbank1.php" class="bank-form">
                    <input type="hidden" name="frmflag1" value="frmflag1" />
                    <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="bankcode" class="form-label required">Bank Code</label>
                            <input type="text" name="bankcode" id="bankcode" value="<?php echo $bankcode; ?>" 
                                   readonly class="form-input" />
                        </div>
                        
                        <div class="form-group">
                            <label for="companyname" class="form-label required">Company Name</label>
                            <input type="text" name="companyname" id="companyname" value="<?php echo $companyname; ?>" 
                                   readonly class="form-input" />
                        </div>
                        
                        <div class="form-group full-width">
                            <label for="bankname" class="form-label required">Bank Name</label>
                            <div class="input-with-button">
                                <input type="text" name="bankname" id="bankname" value="<?php echo $bankname; ?>" 
                                       class="form-input" required />
                                <button type="button" onclick="banksearch('4')" class="btn btn-secondary">
                                    <i class="fas fa-search"></i> Select Bank
                                </button>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="contactpersonname" class="form-label">Contact Person Name</label>
                            <input type="text" name="contactpersonname" id="contactpersonname" 
                                   value="<?php echo $contactpersonname; ?>" class="form-input" />
                        </div>
                        
                        <div class="form-group">
                            <label for="contactpersonphone" class="form-label">Contact Phone Number</label>
                            <input type="text" name="contactpersonphone" id="contactpersonphone" 
                                   value="<?php echo $contactpersonphone; ?>" class="form-input" />
                        </div>
                        
                        <div class="form-group">
                            <label for="branchname" class="form-label required">Branch</label>
                            <input type="text" name="branchname" id="branchname" 
                                   value="<?php echo $branchname; ?>" class="form-input" required />
                        </div>
                        
                        <div class="form-group">
                            <label for="netbankinglogin" class="form-label">Net Banking Login ID</label>
                            <input type="text" name="netbankinglogin" id="netbankinglogin" 
                                   value="<?php echo $netbankinglogin; ?>" class="form-input" />
                        </div>
                        
                        <div class="form-group">
                            <label for="accountnumber" class="form-label required">Account Number</label>
                            <input type="text" name="accountnumber" id="accountnumber" 
                                   value="<?php echo $accountnumber; ?>" class="form-input" required />
                        </div>
                        
                        <div class="form-group">
                            <label for="accounttype" class="form-label required">Account Type</label>
                            <input type="text" name="accounttype" id="accounttype" 
                                   value="<?php echo $accounttype; ?>" class="form-input" required />
                        </div>
                        
                        <div class="form-group">
                            <label for="phonenumber" class="form-label">Phone Number</label>
                            <input type="text" name="phonenumber" id="phonenumber" 
                                   value="<?php echo $phonenumber; ?>" class="form-input" />
                        </div>
                        
                        <div class="form-group">
                            <label for="mobilenumber" class="form-label">Mobile Number</label>
                            <input type="text" name="mobilenumber" id="mobilenumber" 
                                   value="<?php echo $mobilenumber; ?>" class="form-input" />
                        </div>
                        
                        <div class="form-group">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" name="address" id="address" 
                                   value="<?php echo $address; ?>" class="form-input" />
                        </div>
                        
                        <div class="form-group">
                            <label for="remarks" class="form-label">Remarks</label>
                            <input type="text" name="remarks" id="remarks" 
                                   value="<?php echo $remarks; ?>" class="form-input" />
                        </div>
                        
                        <div class="form-group">
                            <label for="branchcode" class="form-label">Branch Code</label>
                            <input type="text" name="branchcode" id="branchcode" 
                                   value="<?php echo $branchcode; ?>" class="form-input" />
                        </div>
                        
                        <div class="form-group">
                            <label for="swiftcode" class="form-label">Swift Code</label>
                            <input type="text" name="swiftcode" id="swiftcode" 
                                   value="<?php echo $swiftcode; ?>" class="form-input" />
                        </div>
                        
                        <div class="form-group">
                            <label for="dateposted" class="form-label">Date Posted</label>
                            <input type="text" name="dateposted" id="dateposted" 
                                   value="<?php echo $updatedatetime; ?>" readonly class="form-input" />
                        </div>
                        
                        <div class="form-group">
                            <label for="bankstatus" class="form-label">Bank Status</label>
                            <select name="bankstatus" id="bankstatus" class="form-select">
                                <?php
                                if ($bankstatus != '') 
                                {
                                    echo '<option value="'.$bankstatus.'" selected="selected">'.$bankstatus.'</option>';
                                }
                                else
                                {
                                    echo '<option value="" selected="selected">Active</option>';
                                }
                                ?>
                                <option value="">Active</option>
                                <option value="Deleted">Deleted</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Bank
                        </button>
                        <button type="button" onclick="clearForm()" class="btn btn-secondary">
                            <i class="fas fa-eraser"></i> Clear Form
                        </button>
                    </div>
                </form>
            </section>
        </main>
    </div>

    <!-- Footer -->
    <?php include ("includes/footer1.php"); ?>

    <!-- Scripts -->
    <script src="js/addbank1-modern.js"></script>
</body>
</html>



