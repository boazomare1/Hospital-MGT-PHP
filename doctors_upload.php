<?php
session_start();

include ("includes/loginverify.php");
include ("db/db_connect.php");

// Initialize variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$errmsg = '';
$bgcolorcode = '';

// Get location details
$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

$locationname1 = $res["locationname"];
$locationcode123 = $res["locationcode"];
$locationcode = $res["locationcode"];
$res12locationanum = $res["auto_number"];

// Handle form submission
$frmflag1 = isset($_REQUEST["frmflag1"]) ? $_REQUEST["frmflag1"] : "";

//$frmflag1 = $_REQUEST['frmflag1'];



	////////////// END OF EXCEL UPLOAD  START OF PLAN UPLOAD /////////////////////
	function readCSV($csvFile){

						    $file_handle = fopen($csvFile, 'r');

						    while (!feof($file_handle) ) {

						        $line_of_text[] = fgetcsv($file_handle, 1024);

						    }

						    fclose($file_handle);
						    // return false;
						    return $line_of_text;

						}


if ($frmflag1 == 'frmflag1')
{

	$query31 = "SELECT * from master_location where locationcode = '$locationcode' and status = '' " ;
	$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res31 =(mysqli_fetch_array($exec31));
	$locationname = $res31["locationname"];


if(!empty($_FILES['upload_file']))
{	


		$inputFileName = $_FILES['upload_file']['tmp_name'];

		// print_r($_FILES['upload_file']);

		include 'phpexcel/Classes/PHPExcel/IOFactory.php';

		try {
			// exit();

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

				 
			if($rowData[$key] == 'Doctor Code')
			 $doccode1 = $key;

			if($rowData[$key] == 'Doctor Name')
			 $docname1 = $key;

			if($rowData[$key] == 'Department')
			 $department1 = $key;

			if($rowData[$key] == 'OP DR SHARE')
			 $opshare1 = $key;

			if($rowData[$key] == 'IP DR SHARE')
			 $ipshare1 = $key;
 
			}		


			for ($row = 2; $row <= $highestRow; $row++){ 
    		//  Read a row of data into an array
    		$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,

                                    NULL,

                                    TRUE,

                                    FALSE)[0];

    				$doccode = $rowData[$doccode1];
    				$docname = $rowData[$docname1];
					$department = $rowData[$department1];
					$opshare = $rowData[$opshare1];
					$ipshare = $rowData[$ipshare1];
					 
		 
			if($doccode!="")
				{
									$department = trim($department);
									$docname = trim($docname);
									$docname = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $docname);

									// $docname=ucwords(strtolower($docname));
									$docname=strtoupper($docname);
									$department=strtoupper($department);
								 

					 $query_1 = "SELECT * from master_department where department='$department' ";
                    $exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $no_of_rows=mysqli_num_rows($exec_1);
                    if($no_of_rows==0){
                    		$query_2 = "INSERT INTO `master_department`(`department`,  `locationname`, `locationcode`, `ipaddress`, `recorddate`,`username`) 
                    			VALUES ('$department','$locationname','$locationcode','$ipaddress','$updatedatetime','$username') ";
                    		$exec_2 = mysqli_query($GLOBALS["___mysqli_ston"], $query_2) or die ("Error in Query_2".mysqli_error($GLOBALS["___mysqli_ston"]));
                    }

                    $query31 = "SELECT * from master_department where department = '$department' " ;
					$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res31 =(mysqli_fetch_array($exec31));
					$department_id = $res31["auto_number"];

                    $query_dup = "SELECT * from master_doctor where doctorcode='$doccode'";
                    $exec_dup = mysqli_query($GLOBALS["___mysqli_ston"], $query_dup) or die ("Error in Querydup".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $no_of_rows_dup=mysqli_num_rows($exec_dup);

			 	  if($no_of_rows_dup==0){
									$query1="INSERT INTO `master_doctor`(`doctorcode`, `doctorname`, `dateposted`, `department`, `locationname`, `locationcode`, `consultation_percentage`, `ipservice_percentage`, `pvtdr_percentage`) 
                    				VALUES ('$doccode','$docname','$updatedatetime','$department_id','$locationname','$locationcode','$opshare','100.00','$ipshare')";

									$exec1=mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
								}
								 
												// echo "success";
													// exit();
				}
   				 //  Insert row data array into your database of choice here
			}
					echo "<script>window.location.href = 'doctors_upload.php'</script>";
					// doctors_upload
			 

			} catch(Exception $e) {

				echo '<script>alert("File is Empty!.. Please retry Again");</script>';
				echo "<script>window.location.href = 'doctors_upload.php'</script>";
			 
				}
	} // excel upload file empty if loop

}
	
////////////// END OF EXCEL UPLOAD /////////////////////

// 	$user=$profileid;

// 	$date=date('ymd');

// 	$uploaddir="tab_file_dump";

// 	$final_filename=$username."_tabdump.txt";

// 	$photodate = date('y-m-d');

// 	$photoid = $user.$date;

	

// 	$fileformat = basename( $_FILES['uploadedfile']['name']);

// 	$fileformat = substr($fileformat, -3, 3);

// 	if ($fileformat == 'txt') // || $fileformat == 'peg') // || $fileformat == 'gif')

// 	{

// 		//echo "inside if";

// 		$uploadfile123 = $uploaddir . "/" . $final_filename;

// 		$target_path = $uploadfile123;

// 		if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) 

// 		{

// 			header ("location:servicedataimport1.php?upload=success");

// 		}

// 		else

// 		{

// 			header ("location:servicedataimport.php?upload=failed");

// 		}

	

// 	} 

// 	else

// 	{

// 			header ("location:servicedataimport.php?upload=failed");

// 	}

	

// }



// Handle upload status messages
$upload = isset($_REQUEST["upload"]) ? $_REQUEST["upload"] : "";

if ($upload == 'success') {
    $errmsg = "File Upload Completed Successfully!";
    $bgcolorcode = 'success';
} elseif ($upload == 'failed') {
    $errmsg = "File Upload Failed. Please ensure you are uploading a valid Excel file.";
    $bgcolorcode = 'failed';
}





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors Upload - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/doctors-upload-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker CSS -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <script type="text/javascript">
    function dataimport1verify() {
        if (document.getElementById("upload_file").value == "") {
            alert("Please Select The File To Proceed.");
            return false;
        }
        
        // Show loading overlay
        showLoadingOverlay();
        return true;
    }
    
    function showLoadingOverlay() {
        const overlay = document.createElement('div');
        overlay.id = 'loadingOverlay';
        overlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        `;
        
        const content = document.createElement('div');
        content.style.cssText = `
            background: white;
            padding: 2rem;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        `;
        
        content.innerHTML = `
            <div style="margin-bottom: 1rem;">
                <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: #1e40af;"></i>
            </div>
            <p style="margin: 0; font-weight: 600;">Processing File Upload...</p>
            <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; color: #666;">Please wait while we import the doctor data.</p>
        `;
        
        overlay.appendChild(content);
        document.body.appendChild(overlay);
    }
    </script>
    
    <!-- Modern JavaScript -->
    <script src="js/doctors-upload-modern.js?v=<?php echo time(); ?>"></script>
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
        <span>Doctors Upload</span>
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
                        <a href="doctors_upload.php" class="nav-link active">
                            <i class="fas fa-upload"></i>
                            <span>Doctors Upload</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="doctorsactivityreport.php" class="nav-link">
                            <i class="fas fa-user-md"></i>
                            <span>Doctor Activity Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="doctorpaymententry.php" class="nav-link">
                            <i class="fas fa-credit-card"></i>
                            <span>Doctor Payment Entry</span>
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
                    <h2>Doctors Upload</h2>
                    <p>Import doctor information from Excel files with comprehensive data validation and processing.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="viewSampleFile()">
                        <i class="fas fa-download"></i> Sample File
                    </button>
                </div>
            </div>

            <!-- Upload Form Section -->
            <div class="upload-form-section">
                <div class="upload-form-header">
                    <i class="fas fa-upload upload-form-icon"></i>
                    <h3 class="upload-form-title">Doctor Data Upload</h3>
                </div>
                
                <form method="post" enctype="multipart/form-data" name="form1" id="form1" onSubmit="return dataimport1verify()" class="upload-form">

                    <!-- Sample File Download -->
                    <div class="sample-file-section">
                        <div class="sample-file-header">
                            <i class="fas fa-download sample-file-icon"></i>
                            <h4>Sample File Download</h4>
                        </div>
                        <div class="sample-file-content">
                            <p>Download the sample Excel file to understand the required format for doctor data upload.</p>
                            <a href="sample_excels/doctors_upload_sample.xls" class="btn btn-outline" target="_blank">
                                <i class="fas fa-file-excel"></i>
                                Download Sample File
                            </a>
                        </div>
                    </div>

                    <!-- File Upload Section -->
                    <div class="file-upload-section">
                        <div class="form-group">
                            <label for="upload_file" class="form-label">Select Excel File to Upload</label>
                            <div class="file-input-wrapper">
                                <input name="upload_file" id="upload_file" type="file" accept=".xls,.xlsx" class="file-input" required>
                                <div class="file-input-display">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span class="file-input-text">Choose Excel file or drag and drop here</span>
                                    <span class="file-input-hint">Supports .xls and .xlsx files</span>
                                </div>
                            </div>
                        </div>

                        <!-- File Requirements -->
                        <div class="file-requirements">
                            <h5>File Requirements:</h5>
                            <ul>
                                <li><i class="fas fa-check"></i> Excel format (.xls or .xlsx)</li>
                                <li><i class="fas fa-check"></i> Must include columns: Doctor Code, Doctor Name, Department, OP DR SHARE, IP DR SHARE</li>
                                <li><i class="fas fa-check"></i> First row should contain column headers</li>
                                <li><i class="fas fa-check"></i> Maximum file size: 10MB</li>
                            </ul>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
                            
                            <button type="submit" class="submit-btn">
                                <i class="fas fa-upload"></i>
                                Upload and Process Data
                            </button>
                            
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

</body>
</html>



