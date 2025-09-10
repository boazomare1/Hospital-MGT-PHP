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
 

			if($rowData[$key] == 'Item Code')
			 $itemcode1 = $key;

			if($rowData[$key] == 'Item Name')
			 $itemname1 = $key;

			if($rowData[$key] == 'categoryname')
			 $catname1 = $key;

			if($rowData[$key] == 'rateperunit')
			 $rateperunit1 = $key;

			if($rowData[$key] == 'purchaseprice')
			 $purchaseprice1 = $key;

			if($rowData[$key] == 'formula')
			 $formula1 = $key;
			if($rowData[$key] == 'genericname')
			 $genericname1 = $key;
			if($rowData[$key] == 'minimumstock')
			 $minimumstock1 = $key;
			if($rowData[$key] == 'maximumstock')
			 $maximumstock1 = $key;

			if($rowData[$key] == 'rol')
			 $rol1 = $key;
			if($rowData[$key] == 'roq/volume')
			 $roq1 = $key;
			if($rowData[$key] == 'type purchase')
			 $purchasetype1 = $key;
			if($rowData[$key] == 'producttypeid')
			 $prodtype1 = $key;
			if($rowData[$key] == 'transfertype')
			 $transfertype1 = $key;
			if($rowData[$key] == 'cogs ledger code')
			 $cogscode1 = $key;
						
			if($rowData[$key] == 'cogs ledger name')
			 $cogsname1 = $key;

			if($rowData[$key] == 'incomeledger code')
			 $incomecode1 = $key;

			if($rowData[$key] == 'incomeledger name')
			 $incomename1 = $key;

			if($rowData[$key] == 'inventoryledgername')
			 $inventname1 = $key;

			if($rowData[$key] == 'inventoryledgercode')
			 $inventcode1 = $key;

			if($rowData[$key] == 'ex ledger code')
			 $expcode1 = $key;

			if($rowData[$key] == 'ex ledger name')
			 $expname1 = $key; 


			}		


			for ($row = 2; $row <= $highestRow; $row++){ 
    		//  Read a row of data into an array
    		$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,

                                    NULL,

                                    TRUE,

                                    FALSE)[0];

    				// $ward_name = $rowData[$ward_name1];

					$itemcode  = $rowData[$itemcode1];
					$itemname  = $rowData[$itemname1];
					$catname  = $rowData[$catname1];
					$rateperunit  = $rowData[$rateperunit1];
					$purchaseprice  = $rowData[$purchaseprice1];
					$formula  = $rowData[$formula1];
					$genericname  = $rowData[$genericname1];
					$minimumstock  = $rowData[$minimumstock1];
					$maximumstock  = $rowData[$maximumstock1];
					$rol  = $rowData[$rol1];
					$roq  = $rowData[$roq1];
					$purchasetype  = $rowData[$purchasetype1];
					$prodtype  = $rowData[$prodtype1];
					$transfertype  = $rowData[$transfertype1];
					$cogscode  = $rowData[$cogscode1];
					$cogsname  = $rowData[$cogsname1];
					$incomecode  = $rowData[$incomecode1];
					$incomename  = $rowData[$incomename1];
					$inventname  = $rowData[$inventname1];
					$inventcode  = $rowData[$inventcode1];
					$expcode  = $rowData[$expcode1];
					$expname  = $rowData[$expname1];
		 
			if($itemcode!="")
				{
 

									$itemcode= trim($itemcode);
									$itemname= trim($itemname);
									$catname= trim($catname);
									$rateperunit= trim($rateperunit);
									$purchaseprice= trim($purchaseprice);
									$formula= trim($formula);
									$genericname= trim($genericname);
									$minimumstock= trim($minimumstock);
									$maximumstock= trim($maximumstock);
									$rol= trim($rol);
									$roq= trim($roq);
									$purchasetype= trim($purchasetype);
									$prodtype= trim($prodtype);
									$transfertype= trim($transfertype);
									$cogscode= trim($cogscode);
									$cogsname= trim($cogsname);
									$incomecode= trim($incomecode);
									$incomename= trim($incomename);
									$inventname= trim($inventname);
									$inventcode= trim($inventcode);
									$expcode= trim($expcode);
									$expname= trim($expname);



									$itemname = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $itemname);
									$catname = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $catname);
									$genericname = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $genericname);
									$purchasetype = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $purchasetype);

									$incomename = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $incomename);
									$cogsname = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $cogsname);
									$inventname = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $inventname);
									$expname = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $expname);

									$catname=strtoupper($catname);
									$genericname=strtoupper($genericname);

 									$query_1 = "SELECT * from master_categorypharmacy where categoryname='$catname' ";
				                    $exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				                    $no_of_rows=mysqli_num_rows($exec_1);
				                    if($no_of_rows==0){
				                    		$query_2 = "INSERT INTO `master_categorypharmacy`(`categoryname`,  `locationname`, `locationcode`, `ipaddress`, `updatetime`) 
				                    			VALUES ('$catname','$locationname','$locationcode','$ipaddress','$updatedatetime') ";
				                    		$exec_2 = mysqli_query($GLOBALS["___mysqli_ston"], $query_2) or die ("Error in Query_2".mysqli_error($GLOBALS["___mysqli_ston"]));
				                    }


									$query_1 = "SELECT * from product_type where name='$prodtype' ";
				                    $exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				                    $no_of_rows=mysqli_num_rows($exec_1);
				                    if($no_of_rows==0){
				                    		$query_2 = "INSERT INTO product_type(name, status, `ipaddress`, `username`) 
				                    			VALUES ('$prodtype','1','$ipaddress','$username') ";
				                    		$exec_2 = mysqli_query($GLOBALS["___mysqli_ston"], $query_2) or die ("Error in Query_2".mysqli_error($GLOBALS["___mysqli_ston"]));
											$prodtype = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
				                    }else{
                                       while($res21 = mysqli_fetch_array($exec_1))
			                           {
                                           $prodtype=$res21['name'];
									   }
									}

				                    
				                    $query_gen = "SELECT * from master_genericname where genericname='$genericname' ";
				                    $exec_gen = mysqli_query($GLOBALS["___mysqli_ston"], $query_gen) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				                    $no_of_rows_gen=mysqli_num_rows($exec_gen);
				                    if($no_of_rows_gen==0){
				                    		$query_gen = "INSERT INTO `master_genericname`(`genericname`,  `locationname`, `locationcode`, `ipaddress`, `recorddate`,`username`) 	
				                    			VALUES ('$genericname','$locationname','$locationcode','$ipaddress','$updatedatetime','$username') ";
				                    		$exec_gen = mysqli_query($GLOBALS["___mysqli_ston"], $query_gen) or die ("Error in query_gen".mysqli_error($GLOBALS["___mysqli_ston"]));
				                    }



									$query1 = "INSERT INTO `master_itempharmacy`( `itemcode`, `itemname`, `categoryname`, `unitname_abbreviation`, `rateperunit`, `taxanum`, `taxname`,  `ipaddress`, `updatetime`, `purchaseprice`, `packagename`, `formula`, `genericname`, `minimumstock`, `maximumstock`, `rol`, `roq`, `ipmarkup`, `spmarkup`, `locationname`, `locationcode`, `type`, `ledgername`, `ledgercode`, `transfertype`, `nature`, `incomeledger`, `incomeledgercode`, `inventoryledgercode`, `inventoryledgername`, `producttypeid`, `expenseledgercode`, `expenseledgername`) 
									VALUES ('$itemcode','$itemname','$catname','1S','$rateperunit','2','TAX @ 0.00 %','$ipaddress','$updatedatetime','$purchaseprice','1S','$formula','$genericname','$minimumstock','$maximumstock','$rol','$roq','','','$locationname','$locationcode','$purchasetype','$cogsname','$cogscode','$transfertype','','$incomename','$incomecode','$inventcode','$inventname','$prodtype','$expcode','$expname')";
									$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

									$query2 = "INSERT INTO `master_medicine`( `itemcode`, `itemname`, `categoryname`, `unitname_abbreviation`, `rateperunit`, `taxanum`, `taxname`, `ipaddress`, `updatetime`, `purchaseprice`,  `packagename`, `formula`, `genericname`, `minimumstock`, `maximumstock`, `rol`, `roq`, `ipmarkup`, `spmarkup`, `locationname`, `locationcode`, `LTC-1_rateperunit`, `type`, `ledgername`, `ledgercode`, `transfertype`, `nature`, `incomeledger`, `incomeledgercode`, `inventoryledgercode`, `inventoryledgername`, `expenseledgercode`, `expenseledgername`, `producttypeid`) 
									VALUES ('$itemcode','$itemname','$catname','1S','$rateperunit','2','TAX @ 0.00 %','$ipaddress','$updatedatetime','$purchaseprice','1S','$formula','$genericname','$minimumstock','$maximumstock','$rol','$roq','','','$locationname','$locationcode','$rateperunit','$purchasetype','$cogsname','$cogscode','$transfertype','','$incomename','$incomecode','$inventcode','$inventname','$expcode','$expname','$prodtype')";
									$execquery22=mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
									

									  // $bed_id=mysql_insert_id();
					// echo "success";
						// exit();

									 
						 
				}
   				 //  Insert row data array into your database of choice here
			}
					echo "<script>window.location.href = 'master_pharmacy_upload.php'</script>";
					// master_pharmacy_upload
			 

			} catch(Exception $e) {

				echo '<script>alert("File is Empty!.. Please retry Again");</script>';
				echo "<script>window.location.href = 'master_pharmacy_upload.php'</script>";
			 
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

                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Master Pharmacy Upload :  </strong></td>

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
                          <a href="sample_excels/master_pharmacy_sample.xls" class="bodytext3"><span class="bodytext3" style="color: red; text-decoration: underline;"><strong>Click Here for Sample Excel File...</strong></span></a></td>
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



