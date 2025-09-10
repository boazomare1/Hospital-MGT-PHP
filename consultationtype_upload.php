<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');
$updatedate= date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$errmsg = '';

$bgcolorcode = '';

$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

	
	 $locationname1  = $res["locationname"];
	  $locationcode123 = $res["locationcode"];
	  $locationcode = $res["locationcode"];
	 $res12locationanum = $res["auto_number"];



if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

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

<!-- Modern CSS -->
<link href="css/consultationtype_upload-modern.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />

<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />

<!-- Modern JavaScript -->
<script type="text/javascript" src="js/consultationtype_upload-modern.js?v=<?php echo time(); ?>"></script>

<!-- Additional styles moved to external CSS -->

</head>

<!-- File validation function moved to external JS -->

<body>

<header>
  <?php include ("includes/alertmessages1.php"); ?>
  <?php include ("includes/title1.php"); ?>
  <?php include ("includes/menu1.php"); ?>
</header>

<main class="main-container">
<table width="101%" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="10" class="alert-container"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" class="title-container"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" class="menu-container"><?php include ("includes/menu1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>

      &nbsp;</td>

    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">

            <tr>

              <td>
              	<form  method="post" enctype="multipart/form-data" name="form1" id="form1" onSubmit="return dataimport1verify()" class="upload-form">

                  <table width="800" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Consultation Type Upload :  </strong></td>

                      </tr>

                      <tr>

                        <td colspan="2" align="left" valign="middle"   bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>

                      </tr>

                      <!-- <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3"><strong>Please Note: </strong></span></td>

                      </tr>

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3"><strong>Only TAB Delimited Files Are Accepted. </strong></span></td>

                      </tr>

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3"><strong>Please Do Not Try To Import Any Other File Format. </strong></span></td>

                      </tr> -->

                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<span class="bodytext3"><strong>Download The Sample File Here.</strong></span></td>
                      </tr>

                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                          <a href="sample_excels/consultation_type_sub_update.xls" class="bodytext3"><span class="bodytext3" style="color: red; text-decoration: underline;"><strong>Click Here for Sample Excel File...</strong></span></a></td>
                      </tr>
                      <tr>
                      	<td colspan="2" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      </tr>

                     
                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Select File To Import Data: </td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="upload_file" id="upload_file" type="file" size="50" style="border: 1px solid #001E6A"></td>

                      </tr>

                      <tr>

                        <td width="36%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                        <td width="64%" align="left" valign="top"  bgcolor="#FFFFFF">

						<input type="hidden" name="frmflag" value="addnew" />

                            <input type="hidden" name="frmflag1" value="frmflag1" />

                          <input type="submit" name="Submit" value="Proceed To Data Import" style="border: 1px solid #001E6A" />                        </td>

                      </tr>

                      <tr>

                        <td align="middle" colspan="2" >&nbsp;</td>

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

  </table>

<footer>
  <?php include ("includes/footer1.php"); ?>
</footer>
</main>

</body>

</html>



