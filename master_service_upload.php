<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

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

				if($rowData[$key] == 'ITEM CODE')
			 $itemcode1 = $key;

			if($rowData[$key] == 'SERVICE NAME')
			 $servicename1 = $key;

			if($rowData[$key] == 'CATEGORY NAME')
			 $catname1 = $key;

			 if($rowData[$key] == 'RATE PER UNIT')
			 $rateperunit1 = $key;

			if($rowData[$key] == 'IP MARK UP')
			 $ipmarkup1 = $key;
 
			if($rowData[$key] == 'INCREMENTAL RATE')
			 $incrementalrate1 = $key;

			if($rowData[$key] == 'BASE UNIT')
			 $baseunit1 = $key;

			if($rowData[$key] == 'INCREMENTAL QUANTITY')
			 $incrementalquantity1 = $key;

			if($rowData[$key] == 'SLAB(Yes/No)')
			 $slab1 = $key;

			if($rowData[$key] == 'PKG(Yes/No)')
			 $pkg1 = $key;

			if($rowData[$key] == 'LEDGER NAME')
			 $ledgername1 = $key;

			if($rowData[$key] == 'LEDGER ID')
			 $ledgerid1 = $key;

			if($rowData[$key] == 'WELLNESS PKG(Yes/No)')
			 $wellnesspkg1 = $key;

			if($rowData[$key] == 'MIS Group')
			 $misgroup1 = $key;

			}		

 
			for ($row = 2; $row <= $highestRow; $row++){ 
    		//  Read a row of data into an array
    		$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,

                                    NULL,

                                    TRUE,

                                    FALSE)[0];

					$itemcode = $rowData[$itemcode1];
					$servicename = $rowData[$servicename1];
					$catname = $rowData[$catname1];
					$rateperunit = $rowData[$rateperunit1];
					$ipmarkup = $rowData[$ipmarkup1];
					$incrementalrate = $rowData[$incrementalrate1];
					$baseunit = $rowData[$baseunit1];
					$incrementalquantity = $rowData[$incrementalquantity1];
					$slab = $rowData[$slab1];
					$pkg = $rowData[$pkg1];
					$ledgername = $rowData[$ledgername1];
					$ledgerid = $rowData[$ledgerid1];
					$wellnesspkg = $rowData[$wellnesspkg1];
					$misgroup = $rowData[$misgroup1];

// if(($itemcode=='')){
// 	$itemcode = '';
// }
// if(($servicename=='')){
// 	$servicename = '';
// }
// if(($catname=='')){
// 	$catname = '';
// }
// if(($rateperunit=='')){
// 	$rateperunit = '';
// }
// if(($ipmarkup=='')){
// 	$ipmarkup = '';
// }
// if(($incrementalrate=='')){
// 	$incrementalrate = '';
// }
// if(($baseunit=='')){
// 	$baseunit = '';
// }
// if(($incrementalquantity=='')){
// 	$incrementalquantity = '';
// }
// if(($slab=='')){
// 	$slab = '';
// }
// if(($pkg=='')){
// 	$pkg = '';
// }
// if(($ledgername=='')){
// 	$ledgername = '';
// }
// if(($ledgerid=='')){
// 	$ledgerid = '';
// }
// if(($wellnesspkg=='')){
// 	$wellnesspkg = '';
// }
// if(($misgroup=='')){
// 	$misgroup = '';
// }
		 
			if($servicename!="")
				{
					////////////////////////// service item code generation //////////////////////////////
					if(trim($itemcode)==''){
					$query1 = "select * from master_services order by auto_number desc limit 0, 1";

													$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

													$rowcount1 = mysqli_num_rows($exec1);

													if ($rowcount1 == 0)

													{

														$itemcode = 'SER001';

													}

													else

													{

														$res1 = mysqli_fetch_array($exec1);

														$res1itemcode = $res1['itemcode'];

														$res1itemcode = substr($res1itemcode, 3, 7);

														$res1itemcode = intval($res1itemcode);

														$res1itemcode = $res1itemcode + 1;


														$res1itemcode = $res1itemcode;

														if (strlen($res1itemcode) == 2)

														{

															$res1itemcode = '0'.$res1itemcode;

														}

														if (strlen($res1itemcode) == 1)

														{

															$res1itemcode = '00'.$res1itemcode;

														}

														$itemcode = 'SER'.$res1itemcode;

													

														 //get next itemcode form table by doing this conditions

														   $checklabitem=$itemcode;

														 $query12 = "select itemcode from master_services where itemcode='".$checklabitem."'";

													$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

													 $rowcount1 = mysqli_num_rows($exec12);

													if($rowcount1>0)

													{

														 $res1itemcode = $res1itemcode+1;

														if (strlen($res1itemcode) == 2)

														{

															$res1itemcode = '0'.$res1itemcode;

														}

														if (strlen($res1itemcode) == 1)

														{

															$res1itemcode = '00'.$res1itemcode;

														}

														 $itemcode = 'SER'.$res1itemcode;

														}

													while($rowcount1>0)

													{

														 $checklabitem=$itemcode;

														 $query12 = "select itemcode from master_services where itemcode='".$checklabitem."'";

													$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

													  $rowcount1 = mysqli_num_rows($exec12);

														 if($rowcount1>0)

														 {

														 $res1itemcode = $res1itemcode+1;

															if (strlen($res1itemcode) == 2)

															{

																$res1itemcode = '0'.$res1itemcode;
															}
															if (strlen($res1itemcode) == 1){ $res1itemcode = '00'.$res1itemcode; }
															 	$itemcode = 'SER'.$res1itemcode;
															} else { $rowcount1=0; }
												   }

												}
											}// end of null itemcode form excel.
					////////////////////////// service item code generation //////////////////////////////
 
										if($slab==''){
											$slab='';
										}else{
											$slab=strtolower(trim($slab));
											if($slab=='yes'){
											$slab='1';
											}else{
											$slab='';
											}
										}

									if($pkg==''){
											$pkg='';
										}else{
											$pkg=strtolower(trim($pkg));
												if($pkg=='yes'){
												$pkg='yes';
												}else{
												$pkg='no';
												}
											}

									if($wellnesspkg==''){
											$wellnesspkg='';
										}else{
											$wellnesspkg=strtolower(trim($wellnesspkg));
											if($wellnesspkg=='yes'){
											$wellnesspkg='1';
											}else{
											$wellnesspkg='0';
											}
										}

									// $date = str_replace('/', '-', $eexpirydate);
									//  $newdate1=date('Y-m-d', strtotime($date));

									//  if($newdate1=='1970-01-01'){
									//  	$newdate1=date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($eexpirydate));
									//  }

									$itemcode = trim($itemcode);
									$servicename = trim($servicename);
									$servicename = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $servicename);

									$catname = trim($catname);
									$catname = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $catname);

									$catname=strtoupper($catname);

									$ledgername = trim($ledgername);
									$ledgername = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $ledgername);

					$query_1 = "SELECT * from master_categoryservices where categoryname='$catname' ";
                    $exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $no_of_rows=mysqli_num_rows($exec_1);
                    if($no_of_rows==0){
                    		$query_2 = "INSERT INTO `master_categoryservices`(`categoryname`,  `locationname`, `locationcode`, `ipaddress`, `updatetime`) 
                    			VALUES ('$catname','$locationname','$locationcode','$ipaddress','$updatedatetime') ";
                    		$exec_2 = mysqli_query($GLOBALS["___mysqli_ston"], $query_2) or die ("Error in Query_2".mysqli_error($GLOBALS["___mysqli_ston"]));
                    }

                    $query_dup = "SELECT * from master_services where itemcode='$itemcode' and  itemname='$servicename'";
                    $exec_dup = mysqli_query($GLOBALS["___mysqli_ston"], $query_dup) or die ("Error in Querydup".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $no_of_rows_dup=mysqli_num_rows($exec_dup);

			 	  if($no_of_rows_dup==0){
			  $query1 = "INSERT INTO `master_services`(`itemcode`, `itemname`, `categoryname`, `rateperunit`, `ipaddress`, `updatetime`, `description`, `purchaseprice`, `ipmarkup`,  `incrementalrate`, `baseunit`, `incrementalquantity`, `locationname`, `locationcode`, `slab`, `pkg`, `ledgername`, `ledgerid`, `wellnesspkg`, `groupid`, username) 

			 VALUES ('$itemcode','$servicename','$catname','$rateperunit','$ipaddress','$updatedatetime','manual','0.00','$ipmarkup','$incrementalrate','$baseunit','$incrementalquantity','$locationname','$locationcode','$slab','$pkg','$ledgername','$ledgerid','$wellnesspkg','$misgroup','$username')";

				 
					$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					// echo "success";
						// exit();
							} // duplicate check

				}

   				 //  Insert row data array into your database of choice here
			}
					echo "<script>window.location.href = 'master_service_upload.php'</script>";
					// master_service_upload
			 

			} catch(Exception $e) {

				echo '<script>alert("File is Empty!.. Please retry Again");</script>';
				echo "<script>window.location.href = 'master_service_upload.php'</script>";
			 
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

                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Master Services Upload :  </strong></td>

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

						<span class="bodytext3"><strong >Download The Sample File Here.</strong></span></td>

                      </tr>

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                          <a href="sample_excels/master_service_sample_xl.xls" class="bodytext3"><span class="bodytext3" style="color: red; text-decoration: underline;"><strong>Click Here for Sample Excel File...</strong></span></a></td>

                      </tr>
                      <tr>
                      	<td colspan="2" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      </tr>

                     <!--  <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
                          <a href="sample_excels/master_service_sample_xl.xls" class="bodytext3"><span class="bodytext3"><strong>Sample Download File Click Here...</strong></span></a></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>

                      </tr>
 -->
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



