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

	
	 $locationname  = $res["locationname"];
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


			if($rowData[$key] == 'WARD NAME')
			 $ward_name1 = $key;

			if($rowData[$key] == 'BED NAME')
			 $bed_name1 = $key;

			if($rowData[$key] == 'BED CHARGES')
			 $bed_charges1 = $key;

			if($rowData[$key] == 'NURSING CHARGES')
			 $nur_charges1 = $key;

			 // if($rowData[$key] == 'QUANTITY')
			 // $qty1 = $key;


			}		


			for ($row = 2; $row <= $highestRow; $row++){ 
    		//  Read a row of data into an array
    		$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,

                                    NULL,

                                    TRUE,

                                    FALSE)[0];

    				$ward_name = $rowData[$ward_name1];
					$bed_name = $rowData[$bed_name1];
					$bed_charges = $rowData[$bed_charges1];
					$nur_charges = $rowData[$nur_charges1];
		 
			if($bed_charges!="")
				{
 

									$ward_name = trim($ward_name);
									$bed_name = trim($bed_name);
									$bed_charges = trim($bed_charges);
									$nur_charges = trim($nur_charges);



									$bed_name = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $bed_name);
 
									$ward_name = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $ward_name);

									// $catname=strtoupper($catname);
									$query_1 = "SELECT * from master_ward where ward='$ward_name' ";
				                    $exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				                    $no_of_rows=mysqli_num_rows($exec_1);
				                    if($no_of_rows==0){
				                    		$query_2 = "INSERT INTO `master_ward`(`ward`, `recordstatus`, `locationname`, `locationcode`, `ipaddress`, `recorddate`, `username`, `description`, `deposit_amount`) 
				                    			VALUES ('$ward_name','','$locationname','$locationcode','$ipaddress','$updatedatetime','$username','','0') ";
				                    		$exec_2 = mysqli_query($GLOBALS["___mysqli_ston"], $query_2) or die ("Error in Query_2".mysqli_error($GLOBALS["___mysqli_ston"]));
				                    }
				                    $query_dup = "SELECT auto_number from master_ward where ward='$ward_name'";
                    				$exec_dup = mysqli_query($GLOBALS["___mysqli_ston"], $query_dup) or die ("Error in Querydup".mysqli_error($GLOBALS["___mysqli_ston"]));
                    				$res_dup = mysqli_fetch_array($exec_dup);
                    				$ward_id = $res_dup['auto_number'];

 	// , `wardnamw`, `accommodationcharges`, `cafetariacharges`, `inh_review`, `int_review`, `adms_review`, `accommodationOnly`
									$query1 = "INSERT INTO `master_bed`(`bed`, `ward`, `bedcharges`, `nursingcharges`, `rmocharges`, `threshold`, `grace`, `locationname`, `locationcode`, `recordstatus`, `ipaddress`, `recorddate`, `username`) 
									VALUES ('$bed_name','$ward_id','$bed_charges','$nur_charges','','','','$locationname','$locationcode','','$ipaddress','$updatedatetime','$username')";
									$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

									  $bed_id=((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
					// echo "success";
						// exit();

									 ///////////// loop for master bed charges ////////////////

									  for($i=1;$i<10;$i++)	
									  // for($i=1;$i<3;$i++)	
													{
													if($i == 1)

													{

													$charge="Bed Charges";

													$rate = $bed_charges;


														}

													if($i == 2)

													{

													$charge="Nursing Charges";

													$rate = $nur_charges;

													}

													if($i == 3)

													{

													//$charge="RMO Charges";

													$charge="Daily Review charge";

													$rate = '';
													// $rate = $rmocharges;

												

													}

													if($i == 4)

													{

													 $charge="Accommodation Charges";

													 $rate = '';
													 // $rate = $accommodationcharges;

												

													}

													if($i == 5)

													{

													$charge="Cafetaria Charges";

													$rate = '';
													// $rate = $cafetariacharges;

												

													}

													if($i == 6)

													{

													//$charge="Inhouse Specialist Review";

													$charge="Consultant Fee";

													$rate = '';
													// $rate = $inh_review;

												

													}

													if($i == 7)

													{

													$charge="Intensivist Review";

													$rate = '';
													// $rate = $int_review;

												

													}

													if($i == 8)

													{

													$charge="Admitting Specialist Review";

													$rate = '';
													// $rate = $adms_review;

												

													}

													if($i == 9)

													{

													$charge="Accommodation Only";

													$rate = '';
													// $rate = $accommodationOnly;

													}

													

													if($rate == '')

													{

													$rate = 0.00;

													}

											

												$chargequery1="INSERT into master_bedcharge(bed,bedanum,charge,rate,ipaddress,recorddate,locationname,locationcode,username,ward)
												values('$bed_name','$bed_id','$charge','$rate','$ipaddress','$updatedatetime','$locationname','$locationcode','$username','$ward_id')";

												$chargeexecquery1=mysqli_query($GLOBALS["___mysqli_ston"], $chargequery1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

												}
									 ///////////// loop for master bed charges ////////////////
						 
				}
   				 //  Insert row data array into your database of choice here
			}
					echo "<script>window.location.href = 'master_bed_ward_upload.php'</script>";
					// master_bed_ward_upload
			 

			} catch(Exception $e) {

				echo '<script>alert("File is Empty!.. Please retry Again");</script>';
				echo "<script>window.location.href = 'master_bed_ward_upload.php'</script>";
			 
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

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

-->

</style>

<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none;

}

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none;

}

-->

</style>

</head>

<script language="javascript">



function dataimport1verify()

{

	if (document.getElementById("upload_file").value == "")

	{

		alert ("Please Select The File To Proceed.");

		return false;

	}

}



</script>

<body>

<table width="101%" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>

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
              	<form  method="post" enctype="multipart/form-data" name="form1" id="form1" onSubmit="return dataimport1verify()">

                  <table width="800" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Master Ward and Bed Upload :  </strong></td>

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
                          <a href="sample_excels/Master_ward_bed_sample.xls" class="bodytext3"><span class="bodytext3" style="color: red; text-decoration: underline;"><strong>Click Here for Sample Excel File...</strong></span></a></td>
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

<?php include ("includes/footer1.php"); ?>

</body>

</html>



