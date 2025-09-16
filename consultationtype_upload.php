<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

$errmsg = '';
$bgcolorcode = '';

$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

$locationname1 = $res["locationname"];
$locationcode123 = $res["locationcode"];
$locationcode = $res["locationcode"];
$res12locationanum = $res["auto_number"];

$frmflag1 = isset($_REQUEST["frmflag1"]) ? $_REQUEST["frmflag1"] : "";



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

				 
		 
	if($rowData[$key] == 'Name')
    $name = $key;

    if($rowData[$key] == 'Dept')
     $dept = $key;

    if($rowData[$key] == 'Docno')
     $dc = $key;

    if($rowData[$key] == 'Docname')
     $dn = $key;

    if($rowData[$key] == 'Amt')
     $amt = $key;

    if($rowData[$key] == 'Payment Type')
     $ptype1 = $key;
 
			}		
      


			for ($row = 2; $row <= $highestRow; $row++){ 
    		//  Read a row of data into an array
    		$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,

                                    NULL,

                                    TRUE,

                                    FALSE)[0];

            $consultationtype = trim($rowData[$name]);
            $department = trim($rowData[$dept]);
            $doctorcode = trim($rowData[$dc]);
            $doctorname = trim($rowData[$dn]);
            $consultationfees = trim($rowData[$amt]);
            $ptype = trim($rowData[$ptype1]);
					 
		 
			// if($consultationtype!="")
      if(1)
				{
									   $ptype = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $ptype);
                     $doctorname = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $doctorname);

                     $doctorname=strtoupper($doctorname);

                      $query_1 = "SELECT * from master_department where department='$department' ";
                                      $exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                      $no_of_rows=mysqli_num_rows($exec_1);
                                      if($no_of_rows==0){
                                          $query_2 = "INSERT INTO `master_department`(`department`,  `locationname`, `locationcode`, `ipaddress`, `recorddate`,`username`) 
                                            VALUES ('$department','$locationname','$locationcode','$ipaddress','$updatedatetime','admin') ";
                                          $exec_2 = mysqli_query($GLOBALS["___mysqli_ston"], $query_2) or die ("Error in Query_2".mysqli_error($GLOBALS["___mysqli_ston"]));
                                      }

                            $query31 = "SELECT * from master_department where department = '$department' " ;
                            $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res31 =(mysqli_fetch_array($exec31));
                            $department_id = $res31["auto_number"];


                      if($ptype=='INSURANCE' || $ptype=='CREDIT'){

                              $query10 = "select * from master_subtype where maintype = '3' and recordstatus = ''";
                            $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res10 = mysqli_fetch_array($exec10))
                            {
                            $subtype = $res10["auto_number"];
                            $query1 = "INSERT into master_consultationtype (consultationtype, department,doctorcode,doctorname,consultationfees,ipaddress,recorddate,username,locationname,locationcode,condefault,paymenttype,subtype) values ('$consultationtype', '$department_id','$doctorcode','$doctorname','$consultationfees','$ipaddress','$updatedatetime', 'admin','$locationname','$locationcode','','3','$subtype')"; 
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                              $errmsg = "Success. Updated.";

                            }


                            $query_directcomp = "select * from master_subtype where maintype = '2' and recordstatus = ''";
                            $exec_directcomp = mysqli_query($GLOBALS["___mysqli_ston"], $query_directcomp) or die ("error in query_directcomp".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res_directcomp = mysqli_fetch_array($exec_directcomp))
                            {
                                
                            $subtype1 = $res_directcomp["auto_number"];
                            
                            $query2 = "INSERT into master_consultationtype (consultationtype, department,doctorcode,doctorname,consultationfees,ipaddress,recorddate,username,locationname,locationcode,condefault,paymenttype,subtype) values ('$consultationtype', '$department_id','$doctorcode','$doctorname','$consultationfees','$ipaddress','$updatedatetime', 'admin','$locationname','$locationcode','','2','$subtype1')"; 
                                $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query_directcomp".mysqli_error($GLOBALS["___mysqli_ston"]));
                              $errmsg = "Success. Updated.";

                            }
                      }
                      if($ptype=='CASH'){
                          $query3 = "INSERT into master_consultationtype (consultationtype, department,doctorcode,doctorname,consultationfees,ipaddress,recorddate,username,locationname,locationcode,condefault,paymenttype,subtype) values ('$consultationtype', '$department_id','$doctorcode','$doctorname','$consultationfees','$ipaddress','$updatedatetime', 'admin','$locationname','$locationcode','','1','1')"; 
                                $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in cash query".mysqli_error($GLOBALS["___mysqli_ston"]));

                      }
								 
												// echo "success";
													// exit();
				}
   				 //  Insert row data array into your database of choice here
			}
					echo "<script>window.location.href = 'consultationtype_upload.php'</script>";
					// consultationtype_upload
			 

			} catch(Exception $e) {
				echo '<script>alert("File is Empty!.. Please retry Again");</script>';
				echo "<script>window.location.href = 'consultationtype_upload.php'</script>";
			 
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



if (isset($_REQUEST["upload"])) { $upload = $_REQUEST["upload"]; } else { $upload = ""; }

//$upload = $_REQUEST['upload'];

//echo $upload;

if ($upload == 'success')

{

	$errmsg = "File Upload Completed.";

	$bgcolorcode = 'success';

}

if ($upload == 'failed')

{

	$errmsg = "File Upload Failed. Make Sure You Are Uploading TAB Delimited File.";

	$bgcolorcode = 'failed';

}





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation Type Upload - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/consultationtype_upload-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Date Picker CSS -->
    <link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Consultation Type Upload System</p>
    </header>

    <!-- User Information Bar -->
    <div class="user-info-bar">
        <div class="user-welcome">
            <span class="welcome-text">Welcome, <strong><?php echo htmlspecialchars($username); ?></strong></span>
            <span class="location-info">📍 Location: <?php echo htmlspecialchars($locationname1); ?> | Company: <?php echo htmlspecialchars($companyname); ?></span>
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
        <span>Consultation Type Upload</span>
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
                        <a href="consultationtype_upload.php" class="nav-link active">
                            <i class="fas fa-upload"></i>
                            <span>Upload Consultation Types</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addconsultationtemplate.php" class="nav-link">
                            <i class="fas fa-plus-circle"></i>
                            <span>Add Template</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="consultationrefundrequestlist.php" class="nav-link">
                            <i class="fas fa-undo"></i>
                            <span>Refund Request List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="consultationrefundlist.php" class="nav-link">
                            <i class="fas fa-list"></i>
                            <span>Consultation Refund List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="cashradiologyrefund.php" class="nav-link">
                            <i class="fas fa-x-ray"></i>
                            <span>Cash Radiology Refund</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="cashrefundapprovallist.php" class="nav-link">
                            <i class="fas fa-check-circle"></i>
                            <span>Refund Approval List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chequescollected.php" class="nav-link">
                            <i class="fas fa-money-check"></i>
                            <span>Cheques Collected</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="claimtxnidedit.php" class="nav-link">
                            <i class="fas fa-edit"></i>
                            <span>Claim Transaction Edit</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="payrollprocess1.php" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Payroll Process</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="stockreportbyitem3.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Stock Report by Item</span>
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
                    <h2>Consultation Type Upload</h2>
                    <p>Upload Excel files to import consultation types and doctor information into the system.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="downloadSampleFile()">
                        <i class="fas fa-download"></i> Sample File
                    </button>
                </div>
            </div>

            <!-- Upload Form Section -->
            <div class="upload-form-section">
                <div class="upload-form-header">
                    <i class="fas fa-file-upload upload-form-icon"></i>
                    <h3 class="upload-form-title">File Upload</h3>
                </div>
                
                <form method="post" enctype="multipart/form-data" name="form1" id="form1" onSubmit="return dataimport1verify()" class="upload-form-container">

                    <!-- Sample File Section -->
                    <div class="sample-file-section">
                        <div class="sample-file-header">
                            <i class="fas fa-download sample-file-icon"></i>
                            <h4 class="sample-file-title">Sample File</h4>
                        </div>
                        <p class="sample-file-description">
                            Download the sample Excel file to understand the required format for uploading consultation types.
                        </p>
                        <a href="sample_excels/consultation_type_sub_update.xls" class="sample-file-link" target="_blank">
                            <i class="fas fa-file-excel"></i>
                            Download Sample Excel File
                        </a>
                    </div>

                    <!-- File Upload Area -->
                    <div class="file-upload-area">
                        <i class="fas fa-cloud-upload-alt file-upload-icon"></i>
                        <div class="file-upload-text">Drag & Drop your Excel file here</div>
                        <div class="file-upload-subtext">or click to browse</div>
                        <label for="upload_file" class="file-input-label">
                            <i class="fas fa-upload"></i>
                            Choose File
                        </label>
                        <input name="upload_file" id="upload_file" type="file" accept=".xls,.xlsx,.csv" class="file-input">
                    </div>

                    <!-- Progress Bar -->
                    <div id="progressContainer" class="progress-container">
                        <div class="progress-bar">
                            <div id="progressFill" class="progress-fill"></div>
                        </div>
                        <div id="progressText" class="progress-text">Ready to upload...</div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <input type="hidden" name="frmflag" value="addnew" />
                        <input type="hidden" name="frmflag1" value="frmflag1" />
                        <button type="submit" name="Submit" class="btn btn-primary">
                            <i class="fas fa-upload"></i> Proceed To Data Import
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="clearForm()">
                            <i class="fas fa-undo"></i> Clear Form
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/consultationtype_upload-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>



