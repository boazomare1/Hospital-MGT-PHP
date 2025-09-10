<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$updatedate = date('Y-m-d');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

error_reporting(E_ERROR | E_PARSE);

///////////////////// EXCEL //////// UPLOAD ////////
$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

	
	 $locationname  = $res["locationname"];
	  $locationcode123 = $res["locationcode"];
	  $locationcode = $res["locationcode"];
	 $res12locationanum = $res["auto_number"];


if (isset($_REQUEST["frmflag_upload"]))
{	

							function readCSV($csvFile){

						    $file_handle = fopen($csvFile, 'r');

						    while (!feof($file_handle) ) {

						        $line_of_text[] = fgetcsv($file_handle, 1024);

						    }

						    fclose($file_handle);
						    // return false;
						    return $line_of_text;
						    // window.location
						 //    $searchaccount = $_POST['searchsuppliername'];
							// $searchdocno=$_POST['docno'];
							// $fromdate=$_POST['ADate1'];
							// $todate=$_POST['ADate2'];

						}
	// foreach($_POST['docno_post'] as $key => $value){
 
	 // $upload_file=$_POST['upload_file'][$key];
	 if(!empty($_FILES['upload_file']))
{
$accountsmain=2;
$accountssub=2;

		if(!empty($_FILES['upload_file']))

		{

			$medicinequery231="TRUNCATE TABLE `debtorsupload_temp`";
     		$execquery231=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery231) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$inputFileName = $_FILES['upload_file']['tmp_name'];

		//print_r($_FILES['upload_file']);

		include 'phpexcel/Classes/PHPExcel/IOFactory.php';

		try {

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

				$paynowbillprefix1 = 'DREXUP-';
					$paynowbillprefix12=strlen($paynowbillprefix1);
					$query23 = "SELECT * from debtorsupload_temp order by auto_number desc limit 0, 1";
					$exec23= mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res23 = mysqli_fetch_array($exec23);
					$billnumber1 = $res23["excel_id"];
					$billdigit1=strlen($billnumber1);
					if ($billnumber1 == '')
					{
						$upload_exid ='DREXUP-'.'1';
					}
					else
					{
						$billnumber1 = $res23["excel_id"];
						$upload_exid = substr($billnumber1,$paynowbillprefix12, $billdigit1);
						//echo $billnumbercode;
						$upload_exid = intval($upload_exid);
						$upload_exid = $upload_exid + 1;
						$maxanum1 = $upload_exid;
						$upload_exid = 'DREXUP-'.$maxanum1;
					}

			 if($rowData[$key] == 'Main Type')
			 $epaymenttype1 = $key;

			 if($rowData[$key] == 'Sub Type')
			 $esubtype1 = $key;

			// if($rowData[$key] == 'Accounts ID')
			//  $eaccountsid1 = $key;
 
			if($rowData[$key] == 'Company name')
			 $eaccountname1 = $key;

			if($rowData[$key] == 'Validity(DD/MM/YYYY)')
			 $eexpirydate1 = $key;

			// if($rowData[$key] == 'Is capitation')
			//  $eiscapitation1 = $key;

			//  if($rowData[$key] == 'Is receivable')
			//  $eis_receivable1 = $key;

			 if($rowData[$key] == 'Currency')
			 $ecurrency1 = $key;

			}		

			

			// for ($row = 2; $row <= $highestRow; $row++){ 
   //  		//  Read a row of data into an array
   //  		$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,

   //                                  NULL,

   //                                  TRUE,

   //                                  FALSE)[0];

			//  $epaymenttype = $rowData[$epaymenttype1];
			//  $esubtype = $rowData[$esubtype1];
			//   // $eaccountsid = $rowData[$eaccountsid1];
			//  $eaccountname = $rowData[$eaccountname1];
			// echo  $eexpirydate = $rowData[$eexpirydate1];
			//  // $eiscapitation = $rowData[$eiscapitation1];
			//  // $eis_receivable = $rowData[$eis_receivable1];
			//  $ecurrency = $rowData[$ecurrency1];
				 
			// }

			for ($row = 2; $row <= $highestRow; $row++){ 
    		//  Read a row of data into an array
    		$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,

                                    NULL,

                                    TRUE,

                                    FALSE)[0];

 					$epaymenttype = $rowData[$epaymenttype1];
			 $esubtype = $rowData[$esubtype1];
			  // $eaccountsid = $rowData[$eaccountsid1];
			 $eaccountname = $rowData[$eaccountname1];
			 $eexpirydate_new = $rowData[$eexpirydate1];
			 // $eiscapitation = $rowData[$eiscapitation1];
			 // $eis_receivable = $rowData[$eis_receivable1];
			 $ecurrency = $rowData[$ecurrency1];
		 
				 
			if($eaccountname!="")
				{
					$eiscapitation='';
					$eis_receivable='';

									if($eiscapitation=='Yes'){
									$iscapitation=1;
									}else{
									$iscapitation=0;
									}
									if($eis_receivable=='Yes'){
									$is_receivable=1;
									}else{
									$is_receivable=0;
									}

									// $date_format_c = new DateTime($eexpirydate);
									// $expirydate= $date_format_c->format('Y-m-d');

									// $newdate = date("Y-m-d", strtotime($eexpirydate));

									$expirydate=date('Y-m-d',  PHPExcel_Shared_Date::ExcelToPHP($eexpirydate_new));

									$eaccountname_new = trim($eaccountname);
									$eaccountname_new = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $eaccountname_new);

									$eaccountname_new=ucwords(strtolower($eaccountname_new));


					  $medicinequery2="INSERT INTO `debtorsupload_temp`( `accountname`, `id`, `legacy_code`, `paymenttype`, `subtype`, `accountsmain`, `accountssub`, `openingbalancecredit`, `openingbalancedebit`, `currency`, `fxrate`, `recordstatus`, `expirydate`, `locationname`, `locationcode`, `ipaddress`, `recorddate`, `contact`, `username`, `misreport`, `iscapitation`,`is_receivable`,`excel_id`,`phone`) 
					VALUES ('$eaccountname_new','','','$epaymenttype','$esubtype','$accountsmain','$accountssub','','','$ecurrency','1','ACTIVE','$expirydate','$locationname','$locationcode','$ipaddress','$updatedatetime','','$username','','$iscapitation','$is_receivable','$upload_exid','')";

					// $execquery2=mysql_query($medicinequery2) ;
					$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					// echo "success";
						// exit();
				}
   				 //  Insert row data array into your database of choice here
			}
					echo "<script>window.location.href = 'debtorsupload.php'</script>";
					// debtorsupload
			// echo "<script>window.location.href = 'debtorsupload_view.php?uploadid=$upload_exid;</script>";

			// working one
			 // echo "<script>window.location.href = 'view_uploaded_excel_directlink.php?docno=$docno_get&&searchaccount=$searchaccount&&searchdocno=$searchdocno&&uploadid=$upload_exid&&fromdate=$fromdate&&todate=$todate&&search_type=$search_type';</script>";
			/// above is working one


			// echo "<script>window.open('view_uploaded_excel_directlink.php?docno=$docno_get&&searchaccount=$searchaccount&&searchdocno=$searchdocno;&&uploadid=$upload_exid&&fromdate=$fromdate&&todate=$todate&&search_type=$search_type','_blank')</script>";
			// } // for second row condotion in the excel ends.


			} catch(Exception $e) {

				echo '<script>alert("File is Empty!.. Please retry Again");</script>';
				echo "<script>window.location.href = 'debtorsupload.php'</script>";

			 // die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
				}
	} // excel upload file empty if loop


}

// }

	// 	header("location:accountreceivableentrylist.php");
	// exit;
}

////////////// END OF EXCEL UPLOAD  START OF PLAN UPLOAD /////////////////////
if (isset($_POST["plan_frmflag_upload"]))
{	

		function readCSV($csvFile){

						    $file_handle = fopen($csvFile, 'r');

						    while (!feof($file_handle) ) {

						        $line_of_text[] = fgetcsv($file_handle, 1024);

						    }

						    fclose($file_handle);
						    // return false;
						    return $line_of_text;
						    // window.location
						 //    $searchaccount = $_POST['searchsuppliername'];
							// $searchdocno=$_POST['docno'];
							// $fromdate=$_POST['ADate1'];
							// $todate=$_POST['ADate2'];

						}

if(!empty($_FILES['upload_file']))
{	

			$medicinequery231="TRUNCATE TABLE `planupload_temp`";
     		$execquery231=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery231) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

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

				// $paynowbillprefix1 = 'PLEXUP-';
				// 	$paynowbillprefix12=strlen($paynowbillprefix1);
				// 	$query23 = "SELECT * from planupload_temp order by auto_number desc limit 0, 1";
				// 	$exec23= mysql_query($query23) or die ("Error in Query2".mysql_error());
				// 	$res23 = mysql_fetch_array($exec23);
				// 	$billnumber1 = $res23["excel_id"];
				// 	$billdigit1=strlen($billnumber1);
				// 	if ($billnumber1 == '')
				// 	{
				// 		$upload_exid ='PLEXUP-'.'1';
				// 	}
				// 	else
				// 	{
				// 		$billnumber1 = $res23["excel_id"];
				// 		$upload_exid = substr($billnumber1,$paynowbillprefix12, $billdigit1);
				// 		//echo $billnumbercode;
				// 		$upload_exid = intval($upload_exid);
				// 		$upload_exid = $upload_exid + 1;
				// 		$maxanum1 = $upload_exid;
				// 		$upload_exid = 'PLEXUP-'.$maxanum1;
				// 	}

			 if($rowData[$key] == 'Main Type')
			 $epaymenttype1 = $key;

			 if($rowData[$key] == 'Sub Type')
			 $esubtype1 = $key;

			if($rowData[$key] == 'Accounts ID')
			 $eaccountsid1 = $key;
 
			if($rowData[$key] == 'Account name')
			 $eaccountname1 = $key;


			if($rowData[$key] == 'Plan Name')
			 $eplanname1 = $key;

			if($rowData[$key] == 'Plan Status(OP+IP/OP/IP)')
			 $epstatus1 = $key;

			if($rowData[$key] == 'Copay Amount')
			 $ecopayamount1 = $key;

			if($rowData[$key] == 'Copay Percentage')
			 $ecopaypercentage1 = $key;

			if($rowData[$key] == 'All(Yes/No)')
			 $eall1 = $key;

			// if($rowData[$key] == 'Overall Limit')
			//  $eoveralllimit1 = $key;

			if($rowData[$key] == 'Limit Status(Overall/Visit)')
			 $elimitstatus1 = $key;

			if($rowData[$key] == 'Smart Applicable(Yes/No)')
			 $esmartapplicable1 = $key;

			if($rowData[$key] == 'Overall OP Limit')
			 $eoveralloplimit1 = $key;

			if($rowData[$key] == 'Visit OP Limit')
			 $evisitoplimit1 = $key;

			if($rowData[$key] == 'Overall Ip Limit')
			 $eoveralliplimit1 = $key;

			if($rowData[$key] == 'Visit IP Limit')
			 $evisitiplimit1 = $key;

			if($rowData[$key] == 'Department Limit(Yes/No)')
			 $edepartmentlimit1 = $key;

			if($rowData[$key] == 'Pharmacy Limit')
			 $epharmacylimit1 = $key;

			if($rowData[$key] == 'Lab Limit')
			 $elablimit1 = $key;

			if($rowData[$key] == 'Radiology Limit')
			 $eradiologylimit1 = $key;

			if($rowData[$key] == 'Services Limit')
			 $eserviceslimit1 = $key;

			// if($rowData[$key] == 'Family Plan Limits(Yes/No)')
			//  $planapplicable1 = $key;

			if($rowData[$key] == 'Validity End(DD/MM/YYYY)')
			 $eexpirydate1 = $key;


			}		

			

			// for ($row = 2; $row <= $highestRow; $row++){ 
   //  		//  Read a row of data into an array
   //  		$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,

   //                                  NULL,

   //                                  TRUE,

   //                                  FALSE)[0];

			//  $epaymenttype = $rowData[$epaymenttype1];
			//  $esubtype = $rowData[$esubtype1];
			//   $eaccountsid = $rowData[$eaccountsid1];
			//  $eaccountname = $rowData[$eaccountname1];
				 
			// 	$eplanname=$rowData[$eplanname1];
			// 	$epstatus=$rowData[$epstatus1];
			// 	$ecopayamount=$rowData[$ecopayamount1];
			// 	$ecopaypercentage=$rowData[$ecopaypercentage1];
			// 	$eall=$rowData[$eall1];
			// 	// $eoveralllimit=$rowData[$eoveralllimit1];
			// 	$elimitstatus=$rowData[$elimitstatus1];
			// 	$esmartapplicable=$rowData[$esmartapplicable1];
			// 	$eoveralloplimit=$rowData[$eoveralloplimit1];
			// 	$evisitoplimit=$rowData[$evisitoplimit1];
			// 	$eoveralliplimit=$rowData[$eoveralliplimit1];
			// 	$evisitiplimit=$rowData[$evisitiplimit1];
			// 	$edepartmentlimit=$rowData[$edepartmentlimit1];
			// 	$epharmacylimit=$rowData[$epharmacylimit1];
			// 	$elablimit=$rowData[$elablimit1];
			// 	$eradiologylimit=$rowData[$eradiologylimit1];
			// 	$eserviceslimit=$rowData[$eserviceslimit1];
			// 	// $planapplicable=$rowData[$planapplicable1];
			// 	$eexpirydate=$rowData[$eexpirydate1];

			// }

			for ($row = 2; $row <= $highestRow; $row++){ 
    		//  Read a row of data into an array
    		$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,

                                    NULL,

                                    TRUE,

                                    FALSE)[0];

 					$epaymenttype = $rowData[$epaymenttype1];
			 $esubtype = $rowData[$esubtype1];
			  $eaccountsid = $rowData[$eaccountsid1];
			 $eaccountname = $rowData[$eaccountname1];
				 
				$eplanname=$rowData[$eplanname1];
				$epstatus=$rowData[$epstatus1];
				$ecopayamount=$rowData[$ecopayamount1];
				$ecopaypercentage=$rowData[$ecopaypercentage1];

				$eoveralloplimit=$rowData[$eoveralloplimit1];
				$evisitoplimit=$rowData[$evisitoplimit1];
				$eoveralliplimit=$rowData[$eoveralliplimit1];
				$evisitiplimit=$rowData[$evisitiplimit1];
				$esmartapplicable=$rowData[$esmartapplicable1];

				$eall=$rowData[$eall1];

				// $eoveralllimit=$rowData[$eoveralllimit1];
				$elimitstatus=$rowData[$elimitstatus1];
				
				
				$edepartmentlimit=$rowData[$edepartmentlimit1];
				$epharmacylimit=$rowData[$epharmacylimit1];
				$elablimit=$rowData[$elablimit1];
				$eradiologylimit=$rowData[$eradiologylimit1];
				$eserviceslimit=$rowData[$eserviceslimit1];
				// $planapplicable=$rowData[$planapplicable1];

				 $eexpirydate=$rowData[$eexpirydate1];
		 
				 
			if($eplanname!="")
				{
					$eiscapitation='';
					$eis_receivable='';

									if($esmartapplicable=='Yes'){
									$esmartapplicable12='1';
									}else{
									$esmartapplicable12='';
									}

									$eall=strtolower($eall);
									if($eall=='yes'){
									$forall='yes';
									}else{
									$forall='';
									}

									$elimitstatus=strtolower($elimitstatus);
									if($elimitstatus=='overall'){
									$elimitstatus12='Overall';
									}else{
									$elimitstatus12='Visit';
									}


									// $planapplicable=strtolower($planapplicable);
									// if($planapplicable=='yes'){
									// $planapplicable12='1';
									// }else{
									// $planapplicable12='0';
									// }

									$edepartmentlimit=strtolower($edepartmentlimit);
									if($edepartmentlimit=='yes'){
									$edepartmentlimit='yes';
									}else{
									$edepartmentlimit='';
									}

									// $date_format_c = new D	ateTime($eexpirydate);
									// $newdate1	= $date_format_c->format('Y-m-d');

									// $newdate1 = date("Y-m-d", strtotime($eexpirydate));

									// echo $newdate1=date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($eexpirydate));
									// echo $newdate1=date('Y-m-d', $eexpirydate);

									$date = str_replace('/', '-', $eexpirydate);
									 $newdate1=date('Y-m-d', strtotime($date));

									 if($newdate1=='1970-01-01'){
									 	$newdate1=date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($eexpirydate));
									 }
									// $newdate1 = STR_TO_DATE('$eexpirydate','%Y,%m,%d');
									// CAST('".$eexpirydate."' AS DATE),

									// $eaccountname_new = trim($eaccountname);
									// $eaccountname_new = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $eaccountname_new);

									$eplanname_new = trim($eplanname);
									$eplanname_new1 = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $eplanname_new);

									$epstatus = trim($epstatus);
									$epstatus = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $epstatus);

									$epstatus=strtoupper($epstatus);

									if($epstatus=='OP'){
										$epstatus1='OP';
									}elseif($epstatus=='IP'){
										$epstatus1='IP';
									}else{
										$epstatus1='OP+IP';
									}


									$eplanname_new2=strtoupper($eplanname_new1);

									$planapplicable12='';
									$plancondition='';
									$recordstatus='ACTIVE';
									$exclusions='';

 		  $query1 = "INSERT into planupload_temp (maintype, subtype, accountname, planname, planstatus, plancondition, planfixedamount,planpercentage,

		overalllimitop, overalllimitip, opvisitlimit,ipvisitlimit ,smartap,recordstatus,ipaddress, recorddate, username, planstartdate, planexpirydate,exclusions,forall,planapplicable,departmentlimit,pharmacylimit,lablimit,radiologylimit,serviceslimit,limit_status) 

		values ('$epaymenttype', '$esubtype', '$eaccountsid', '$eplanname_new2', '$epstatus1', '$plancondition', '$ecopayamount',  '$ecopaypercentage', 

		'$eoveralloplimit','$eoveralliplimit', '$evisitoplimit','$evisitiplimit', '$esmartapplicable12', '$recordstatus','$ipaddress', '$updatedatetime', '$username', '".$updatedate."','$newdate1','$exclusions','".$forall."','$planapplicable12','$edepartmentlimit','$epharmacylimit','$elablimit','$eradiologylimit','$eserviceslimit','$elimitstatus12')";

					// $execquery2=mysql_query($medicinequery2) ;
					$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					// echo "success";
						// exit();
				}
   				 //  Insert row data array into your database of choice here
			}
					echo "<script>window.location.href = 'debtorsupload.php'</script>";
					// debtorsupload
			// echo "<script>window.location.href = 'debtorsupload_view.php?uploadid=$upload_exid;</script>";

			// working one
			 // echo "<script>window.location.href = 'view_uploaded_excel_directlink.php?docno=$docno_get&&searchaccount=$searchaccount&&searchdocno=$searchdocno&&uploadid=$upload_exid&&fromdate=$fromdate&&todate=$todate&&search_type=$search_type';</script>";
			/// above is working one


			// echo "<script>window.open('view_uploaded_excel_directlink.php?docno=$docno_get&&searchaccount=$searchaccount&&searchdocno=$searchdocno;&&uploadid=$upload_exid&&fromdate=$fromdate&&todate=$todate&&search_type=$search_type','_blank')</script>";
			// } // for second row condotion in the excel ends.


			} catch(Exception $e) {

				echo '<script>alert("File is Empty!.. Please retry Again");</script>';
				echo "<script>window.location.href = 'debtorsupload.php'</script>";
					// print_r($objPHPExcel);

				 // die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			 // die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
				}
	} // excel upload file empty if loop


}
	
////////////// END OF EXCEL UPLOAD /////////////////////

?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">

function validcheck()
{
	
	// alert(idsubm);
	var a = $('#upload_file').val();
	
	if ((a=="") ) 
	{
		 alert('Select Excel file to Upload');
		 return false;
	} 
	// if(confirm("Do you Want to Upload the File?")==false){return false;}	
}

function addward1process1()
{
	//alert ("Inside Funtion");
	if (document.form1.subtype.value == "")
	{
		alert ("Pleae Enter Sub Type Name.");
		document.form1.subtype.focus();
		return false;
	}
	
	if (document.form1.currency.value == "")
	{
		alert ("Pleae Enter Currency.");
		document.form1.currency.focus();
		return false;
	}
	if (document.form1.fxrate.value == "")
	{
		alert ("Pleae Enter FXRate.");
		document.form1.fxrate.focus();
		return false;
	}
	
	if (document.form1.labtemplate.value == "")
	{
		alert ("Pleae Enter Lab Template Name.");
		document.form1.labtemplate.focus();
		return false;
	}
	if (document.form1.pharmtemplate.value == "")
	{
		alert ("Pleae Enter Pharmacy Rate Template Name.");
		document.form1.pharmtemplate.focus();
		return false;
	}
	if (document.form1.radtemplate.value == "")
	{
		alert ("Pleae Enter Radiology Template Type Name.");
		document.form1.radtemplate.focus();
		return false;
	}
	if (document.form1.sertemplate.value == "")
	{
		alert ("Pleae Enter Service Template Type Name.");
		document.form1.sertemplate.focus();
		return false;
	}
	if (document.form1.ippactemplate.value == "")
	{
		alert ("Pleae Enter Ip Package Template Type Name.");
		document.form1.ippactemplate.focus();
		return false;
	}

	// show loader
	FuncPopup();
	document.form1.submit();
	return true;
}

function FuncPopup()
{
	window.scrollTo(0,0);
	document.getElementById("imgloader").style.display = "";
}

function funcDeleteSubType(varSubTypeAutoNumber)
{
 var varSubTypeAutoNumber = varSubTypeAutoNumber;
	var fRet;
	fRet = confirm('Are you sure want to delete this account name '+varSubTypeAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Sub Type Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Sub Type Entry Delete Not Completed.");
		return false;
	}

}


</script>

<style type="text/css">
.imgloader { background-color:#FFFFFF; }
#imgloader1 {
    position: absolute;
    top: 158px;
    left: 487px;
    width: 28%;
    height: 24%;
}
</style>
<body>
<!-- ajax loader -->
<div align="center" class="imgloader" id="imgloader" style="display:none;">
	<div align="center" class="imgloader" id="imgloader1" style="display:;">
		<p style="text-align:center;"><strong>Processing <br><br> Please be patient...</strong></p>
		<img src="images/ajaxloader.gif">
	</div>
</div>

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
              <td><!-- <form name="form1" id="form1" method="post" action="addsubtype1.php" onSubmit="return addward1process1()"> -->

              	<form name="cbform1" onSubmit="return validcheck();" method="POST" enctype="multipart/form-data" >
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>Debtors Upload </strong></td>
                      </tr>
							  <tr>
							  	<td><input type="file" name="upload_file" id="upload_file"    ></td>
							  	<td> <input type="submit" name="frmflag_upload" value="Dr Upload"  > </td>
							  	<td> <input type="submit" name="plan_frmflag_upload" value="Plan Upload"  > </td>
				                </tr>
		                  </tbody>
		              </table>
		          </form>
                 
                <table width="900" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="10" bgcolor="#ecf0f5" class="bodytext3"><strong>Debtors Upload </strong></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3">&nbsp;</td>
                        <td width="20%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Main Type </strong></td>
                        <td width="30%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Sub Type </strong></td>
						<td width="10%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong> Dr</strong></td>
						<td width="10%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Dr View</strong></td>

						<td width="10%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Plan</strong></td>
						<td width="10%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Plan View</strong></td>
						<!-- <td width="20%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong></strong></td> -->
                      </tr>
                      <?php    
	    $query1 = "select * from master_subtype where recordstatus <> 'deleted' order by maintype ";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$maintypeanum = $res1['maintype'];
		$subtype = $res1["subtype"];
		$auto_number = $res1["auto_number"];
		$labtemplate = $res1["labtemplate"];
		$pharmtemplate = $res1["pharmtemplate"];
		$radtemplate = $res1["radtemplate"];
		$sertemplate = $res1["sertemplate"];
		$ippactemplate = $res1["ippactemplate"];
		$bedtemp=$res1["bedtemplate"];
		if($bedtemp==''){$bedtemp='master_bed';}
		if($labtemplate==''){$labtemplate='master_lab';}
		if($radtemplate==''){$radtemplate='master_radiology';}
		if($sertemplate==''){$sertemplate='master_services';}
		if($ippactemplate==''){$ippactemplate='master_ippackage';}
		$query2 = "select * from master_paymenttype where auto_number = '$maintypeanum'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$maintype = $res2['paymenttype'];
	
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

		$query23 = "SELECT * from debtorsupload_temp order by auto_number desc limit 0, 1";
					$exec23= mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res23 = mysqli_fetch_array($exec23);
					$subtype12 = $res23["subtype"];
					$paymenttype12 = $res23["paymenttype"];

					$query_a = "SELECT * from planupload_temp order by auto_number desc limit 0, 1";
					$exec_a= mysqli_query($GLOBALS["___mysqli_ston"], $query_a) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res_a = mysqli_fetch_array($exec_a);
					$subtype2 = $res_a["subtype"];
					$paymenttype2 = $res_a["maintype"];

					// if(($paymenttype12==$maintype) or ($subtype12==$subtype)){
					// 							$view_true=1;
					// 							}
		  
		?>
		
                      <tr <?php echo $colorcode; ?>>
                        <td width="6%" align="left" valign="top"  class="bodytext3"><div align="center">
					    <?=$colorloopcount;?>
					    </div></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $maintype; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $subtype; ?> </td>
						<td align="left" valign="top"  class="bodytext3">
							<a target="_blank" href="debtorsupload_sample_xl.php?maintype=<?php echo $maintypeanum; ?>&&subtype=<?php echo $auto_number; ?>">Dr Download </a>
								<!-- <img src="images/excel-xls-icon.png" width="30" height="30"></a> -->
							 </td>
						<td align="left" valign="top"  class="bodytext3"> <?php if(($paymenttype12==$maintypeanum) and ($subtype12==$auto_number)){ ?>
						 <!-- <a href="debtorsupload_view.php">View</a>  -->
								<a href="javascript: void(0)" onclick="window.open('debtorsupload_view.php', 'mapping', 'location=yes,height=800,width=1400,scrollbars=yes,status=yes');">Dr View</a> 
							<?php } ?></td>

						<td align="left" valign="top"  class="bodytext3">
							<a target="_blank" href="planupload_sample_xl.php?maintype=<?php echo $maintypeanum; ?>&&subtype=<?php echo $auto_number; ?>"> Plan Download </a>
						</td>
						<td align="left" valign="top"  class="bodytext3"> <?php if(($paymenttype2==$maintypeanum) and ($subtype2==$auto_number)){ ?>
						 <!-- <a href="debtorsupload_view.php">View</a>  -->
								<a href="javascript: void(0)" onclick="window.open('planupload_view.php', 'mapping', 'location=yes,height=800,width=1400,scrollbars=yes,status=yes');">Plan View</a> 
							<?php } ?></td>
						
                      </tr>
                      <?php
		}
		?>
		 <tr bgcolor="#011E6A">
                        <td colspan="10" bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
                      </tr>
                      <tr>
                        <td align="middle" colspan="4" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                <!-- </form> -->
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
    <!-- Modern JavaScript -->
    <script src="js/debtorsupload-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>

