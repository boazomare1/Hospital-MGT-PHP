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
          

				 
        if($rowData[$key] == 'Sub Type')
        $subtype1 = $key; 

        if($rowData[$key] == 'Account')
        $accountname1 = $key;

        if($rowData[$key] == 'PlanName')
        $planname1 = $key;

        if($rowData[$key] == 'Plan Status')
        $pstatus1 = $key;

        if($rowData[$key] == 'Copay Amount')
        $cpamount1 = $key;

        if($rowData[$key] == 'Copay Percentage')
        $cpper1 = $key;


        if($rowData[$key] == 'Limit Status')
        $limitstatus1 = $key;

        if($rowData[$key] == 'Smart Applicable')
        $smartap1 = $key;

        if($rowData[$key] == 'Overal OP Limit')
        $overalop1 = $key;

        if($rowData[$key] == 'Visit OP Limit')
        $visitop1 = $key;

        if($rowData[$key] == 'Overal Ip Limit')
        $overalip1 = $key;

        if($rowData[$key] == 'Visit IP Limit')
        $visitip1 = $key;

        if($rowData[$key] == 'Plan Validity End')
        $Validity1 = $key;
      
      
			}		


			for ($row = 2; $row <= $highestRow; $row++){ 
    		//  Read a row of data into an array
    		$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,

                                    NULL,

                                    TRUE,

                                    FALSE)[0];

            $subtype  = $rowData[$subtype1];
            $accountname  = $rowData[$accountname1];
            $planname  = $rowData[$planname1];
            $pstatus  = trim($rowData[$pstatus1]);
            $cpamount  = $rowData[$cpamount1];
            $cpper  = $rowData[$cpper1];
            $limitstatus  = $rowData[$limitstatus1];
            $smartap  = strtolower(trim($rowData[$smartap1]));
            $overalllimitop  = $rowData[$overalop1];
            $opvisitlimit  = $rowData[$visitop1];
            $overalllimitip  = $rowData[$overalip1];
            $ipvisitlimit  = $rowData[$visitip1];
            $expirydate  = $rowData[$Validity1];
					 
			if($subtype!="")
				{

                 if($smartap=='yes'){
                     $smartap_new='1';
                  }else{
                     $smartap_new='';
                  }

             

        
									$subtype = trim($subtype);
									$subtype = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $subtype);

                  $accountname = trim($accountname);
                  $accountname = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $accountname);
                  $accountname=strtoupper($accountname);

                  $planname = trim($planname);
                  // $planname = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $planname);
                  // $planname=strtoupper($planname);

                    $query31 = "SELECT * from master_subtype where subtype = '$subtype' " ;
                    $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res31 =(mysqli_fetch_array($exec31));
                    $subtype_id = $res31["auto_number"];
                    $maintype_id = $res31["maintype"];

                    $accountmain_id='2';
                    $accountsub_id='16';

                    $accountsmain='2';
                    $accountssub='16';

                    $expirydate=date('Y-m-d',  PHPExcel_Shared_Date::ExcelToPHP($expirydate));

                    if(strtotime($expirydate) < strtotime($updatedate)){
                      $expirydate=date('Y-m-d');
                    }

								 

					 $query_1 = "SELECT * from master_accountname where accountname='$accountname' ";
                    $exec_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $no_of_rows=mysqli_num_rows($exec_1);
                    if($no_of_rows==0){

                                                          //////////// FOR ID GENERATE ///////////////////

                                                          // $query8 = "select * from master_accountssub where auto_number = '$accountssub' and recordstatus <> 'deleted'";
                                                          //         $exec8 = mysql_query($query8) or die(mysql_error());
                                                          //         $res8 = mysql_fetch_array($exec8);
                                                          //         $accanum = $res8['id'];
                                                          //         $accountssubname = $res8['accountssub'];


                                                                      $query82 = "select * from master_accountssub where auto_number = '$accountssub'";
                                                          $exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die ("Error in Query82".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                          $res82 = mysqli_fetch_array($exec82);
                                                          $accanum = $res82['id'];
                                                          $shortname = $res82['shortname'];

                                                          $accanumexplode = explode('-',$accanum);
                                                          $accanum1 = $accanumexplode[0];
                                                          $accanum2 = $accanumexplode[1];


                                                          if(isset($accanumexplode[2]))
                                                            $accanum3 = $accanumexplode[2];
                                                          else
                                                            $accanum3 ='01';

                                                          $accinc = intval($accanum3);
                                                          $accinc = $accinc + 1;



                                                          //$query2 = "select * from master_accountname where locationcode = '$location' and accountsmain = '$accountsmain' and accountssub = '$accountssub'  order by auto_number desc";

                                                          $query2 = "select * from master_accountname where accountsmain = '$accountsmain' and accountssub = '$accountssub'  order by auto_number desc";

                                                          $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

                                                          $res2 = mysqli_fetch_array($exec2);



                                                          $res2id = $res2['id'];



                                                          if($res2id == '')

                                                          {

                                                              $searchresult = $accanum1.'-'.$accanum2.'-'.$accinc;

                                                          }

                                                          else

                                                          {

                                                              $res2id = $res2['id'];

                                                              $res2idexplode = explode('-',$res2id);

                                                              $res2id1 = $res2idexplode[0];

                                                              $res2id2 = $res2idexplode[1];

                                                              $res2id3 = $res2idexplode[2];

                                                              

                                                              $incanum = intval($res2id3);

                                                              $incanum = $incanum + 1;

                                                              

                                                              $searchresult = $res2id1.'-'.$res2id2.'-'.$incanum;

                                                              

                                                              // l1:

                                                              //   $select_query="select * from master_accountname where id = '$searchresult' limit 0,1";

                                                              //   $result = mysql_query($select_query);

                                                              //   while($row = mysql_fetch_array($result))

                                                              //   {

                                                              //     $res2id = $row['id'];

                                                              //     $res2idexplode = explode('-',$res2id);

                                                              //     $res2id1 = $res2idexplode[0];

                                                              //     $res2id2 = $res2idexplode[1];

                                                              //     $res2id3 = $res2idexplode[3];

                                                                  

                                                              //     $incanum = intval($res2id3);

                                                              //     $incanum = $incanum + 1;

                                                                  

                                                              //     $searchresult = $res2id1.'-'.$res2id2.'-'.$incanum;

                                                                  

                                                              //     goto l1;

                                                              //  }

                                                          }
                                                                //////////// FOR ID GENERATE ///////////////////

                     $accountname_query="INSERT INTO `master_accountname`( `accountname`, `id`, `legacy_code`, `paymenttype`, `subtype`, `accountsmain`, `accountssub`, `openingbalancecredit`, `openingbalancedebit`, `currency`, `fxrate`, `recordstatus`, `expirydate`, `locationname`, `locationcode`, `ipaddress`, `recorddate`, `contact`, `username`, `misreport`, `iscapitation`,`is_receivable`,`phone`) 
                    VALUES ('$accountname','$searchresult','','$maintype_id','$subtype_id','$accountmain_id','$accountsub_id','','','KSH','1','ACTIVE','$expirydate','$locationname','$locationcode','$ipaddress','$updatedatetime','','$username','','','','')";

                    $execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $accountname_query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                } // end of adding the account in the accountsname coa table.

                    $query_accid = "SELECT auto_number from master_accountname where accountname='$accountname'" ;
          					$exec_accid = mysqli_query($GLOBALS["___mysqli_ston"], $query_accid) or die ("Error in Query_accid".mysqli_error($GLOBALS["___mysqli_ston"]));
          					$res_accid =(mysqli_fetch_array($exec_accid));
          					$accountname_id = $res_accid["auto_number"];
                     

         
              $query1 = "INSERT into master_planname (maintype, subtype, accountname, planname, planstatus, plancondition, planfixedamount,planpercentage,

                overalllimitop, overalllimitip, opvisitlimit,ipvisitlimit ,smartap,recordstatus,ipaddress, recorddate, username, planstartdate, planexpirydate,exclusions,forall,planapplicable,departmentlimit,pharmacylimit,lablimit,radiologylimit,serviceslimit, locationname, locationcode) 

                values ('$maintype_id', '$subtype_id', '$accountname_id', '$planname', '$pstatus', '', '$cpamount',  '$cpper', 

                '$overalllimitop','$overalllimitip', '$opvisitlimit','$ipvisitlimit', '$smartap_new', 'ACTIVE','$ipaddress', '$updatedatetime', '$username', '$updatedate', '$expirydate','','','','','','','','', '$locationname', '$locationcode')";


									$exec1=mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
							 
												// echo "success";
													// exit();
				}
   				 //  Insert row data array into your database of choice here
			}
					echo "<script>window.location.href = 'master_plan_upload.php'</script>";
					// master_plan_upload
			 

			} catch(Exception $e) {

				echo '<script>alert("File is Empty!.. Please retry Again");</script>';
				echo "<script>window.location.href = 'master_plan_upload.php'</script>";
			 
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

                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Master Plan Upload :  </strong></td>

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
                          <a href="sample_excels/plan_upload_sample.xls" class="bodytext3"><span class="bodytext3" style="color: red; text-decoration: underline;"><strong>Click Here for Sample Excel File...</strong></span></a></td>
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



