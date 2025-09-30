<?php
session_start();
include("includes/loginverify.php");
include("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$exclude = '';
$docno = $_SESSION['docno'];

//to redirect if there is no entry in masters category or item.
$pkg = isset($_REQUEST['pkg']) ? $_REQUEST['pkg'] : 'no';


$location = "select locationcode,locationname from login_locationdetails where username='$username' and docno='$docno'";
$exeloc = mysqli_query($GLOBALS["___mysqli_ston"], $location);
$resloc = mysqli_fetch_array($exeloc);
$locationcode = $resloc['locationcode'];
$locationname = $resloc['locationname'];

if (isset($_POST["frmflag1"])) {
	$frmflag1 = $_POST["frmflag1"];
} else {
	$frmflag1 = "";
}
if ($frmflag1 == 'frmflag1') {

	$itemcode = $_REQUEST["itemcode"];
	$itemcode = strtoupper($itemcode);
	$itemcode = trim($itemcode);
	$itemname = $_REQUEST["itemname"];
	$genericname = $_REQUEST['genericname'];
	$disease = $_REQUEST['disease'];
	$formula = $_REQUEST['formula'];
	$type = $_REQUEST['type'];
	$producttype = $_REQUEST['producttype'];

	$ledgername = $_REQUEST['iaccountname'];
	$ledgerautonumber = $_REQUEST['iaccountauto'];
	$ledgercode = $_REQUEST['iaccountid'];

	$incomeledgername = $_REQUEST['saccountname'];
	$incomeledgerautonumber = $_REQUEST['saccountauto'];
	$incomeledgercode = $_REQUEST['saccountid'];

	$inventoryledgername = $_REQUEST['inv_accountname'];
	$inventoryledgerautonumber = $_REQUEST['inv_accountauto'];
	$inventoryledgercode = $_REQUEST['inv_accountid'];

	$expenseledgername = $_REQUEST['exp_accountname'];
	$expenseledgerautonumber = $_REQUEST['exp_accountauto'];
	$expenseledgercode = $_REQUEST['exp_accountid'];

	$drug_instructions = $_REQUEST['drug_instructions'];
	$dose_measure = $_REQUEST['dose_measure'];

	//echo $formula;
	$minimumstock = $_REQUEST['minimumstock'];
	$maximumstock = $_REQUEST['maximumstock'];
	//$manufacturername = $_REQUEST['manufactureranum'];
	$rol = $_REQUEST['rol'];
	$roq = $_REQUEST['roq'];
	$ipmarkup = $_REQUEST['ipmarkup'];
	$spmarkup = $_REQUEST['spmarkup'];
	//$itemname = strtoupper($itemname);
	$itemname = trim($itemname);
	//echo "simple";
	$length1 = strlen($itemcode);
	$length2 = strlen($itemname);
	//! ^ + = [ ] ; , { } | \ < > ? ~
	//if (preg_match ('/[+,|,=,{,},(,)]/', $itemname))
	if (preg_match('/[!,^,+,=,[,],;,,,{,},|,\,<,>,?,~]/', $itemname)) {
		//echo "inside if";
		$bgcolorcode = 'fail';
		$errmsg = "Sorry. pharmacy Item Not Added";

		header("location:pharmacyitem1.php?st=1");
		exit();
	}
	$itemname = addslashes($itemname);

	$categoryname = $_REQUEST["categoryname"];
	$purchaseprice  = $_REQUEST["costprice"];
	$rateperunit  = $_REQUEST["rateperunit2"];
	$expiryperiod = '';
	$description = $_REQUEST["description"];
	$itemname_abbreviation = $_REQUEST['packageanum'];
	$taxanum = $_REQUEST["taxanum"];
	$transfertype = $_REQUEST["transfertype"];
	$nature = $_REQUEST["nature"];
	if ($length1 < 25 && $length2 < 255) {
		$numberOfItemsQuery = "select itemname, itemcode from master_medicine where itemname = '" . $itemname . "'";
		$numberOfItems = mysqli_query($GLOBALS["___mysqli_ston"], $numberOfItemsQuery) or die("Error in numberOfItemsQuery" . mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($n = mysqli_fetch_assoc($numberOfItems)) {

			if ($n['itemcode'] != $itemcode) {
				$bgcolorcode = 'fail';
				$errmsg = "Duplicate name";

				header("location:pharmacyitem1.php?errmsg=" . $errmsg);
				exit();
			}
		}

		$query4 = "select * from master_tax where auto_number = '$taxanum'"; // and cstid='$custid' and cstname='$custname'";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die("Error in Query4" . mysqli_error($GLOBALS["___mysqli_ston"]));
		$res4 = mysqli_fetch_array($exec4);
		$res4taxname = $res4["taxname"];

		$query44 = "select * from master_packagepharmacy where auto_number = '$itemname_abbreviation'"; // and cstid='$custid' and cstname='$custname'";
		$exec44 = mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die("Error in Query4" . mysqli_error($GLOBALS["___mysqli_ston"]));
		$res44 = mysqli_fetch_array($exec44);
		$res4packagename = $res44["packagename"];

		/*$query54 = "select * from master_manufacturerpharmacy where auto_number = '$manufacturername'";// and cstid='$custid' and cstname='$custname'";
		$exec54 = mysql_query($query54) or die ("Error in Query4".mysql_error());
		$res54 = mysql_fetch_array($exec54);
		$res4manufacturername = $res54["manufacturername"];*/


		$query2 = "select * from master_medicine where itemcode = '$itemcode'"; // or itemname = '$itemname'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in Query2" . mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_num_rows($exec2);
		if ($res2 == 0) {
			$query1 = "insert into master_medicine (itemcode, itemname, categoryname, unitname_abbreviation,packagename,rateperunit, expiryperiod, taxanum, taxname, ipaddress, updatetime, description, purchaseprice,pkg,genericname,exclude,minimumstock,maximumstock,rol,roq,ipmarkup,spmarkup,formula,disease,type,producttypeid,ledgername,ledgercode,ledgerautonumber,transfertype,nature,incomeledgercode,incomeledger,inventoryledgercode,inventoryledgername,expenseledgercode,expenseledgername,drug_instructions,dose_measure) 
			values ('$itemcode', '$itemname', '$categoryname', '$res4packagename','$res4packagename', '$rateperunit', '$expiryperiod', '$taxanum', '$res4taxname', '$ipaddress', '$updatedatetime','$description', '$purchaseprice','$pkg','$genericname','$exclude','$minimumstock','$maximumstock','$rol','$roq','$ipmarkup','$spmarkup','$formula','$disease','$type','$producttype','$ledgername','$ledgercode','$ledgerautonumber','$transfertype','$nature','$incomeledgercode','$incomeledgername','$inventoryledgercode','$inventoryledgername','$expenseledgercode','$expenseledgername','$drug_instructions','$dose_measure')";



			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));

			$fields = array();
			$queryChk = "SHOW COLUMNS FROM master_medicine";
			$execchk = mysqli_query($GLOBALS["___mysqli_ston"], $queryChk) or die("Error in queryChk" . mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($x = mysqli_fetch_assoc($execchk)) {

				if (stripos($x['Field'], "subtype_") !== false) {
					$fieldname = $x['Field'];
					$query1 = "update master_medicine set $fieldname='$rateperunit' where itemcode='$itemcode'";
					$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}


			//audit 1 loop start

			$query2 = "select * from audit_master_medicine where itemcode = '$itemcode'"; // or itemname = '$itemname'";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in Query2" . mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2 = mysqli_num_rows($exec2);
			if ($res2 == 0) {
				$query1 = "insert into audit_master_medicine (itemcode, itemname, categoryname, unitname_abbreviation,packagename,rateperunit, expiryperiod, taxanum, taxname, ipaddress, updatetime, description, purchaseprice,pkg,genericname,exclude,minimumstock,maximumstock,rol,roq,ipmarkup,spmarkup,formula,disease,type,producttypeid,ledgername,ledgercode,ledgerautonumber,transfertype,nature,incomeledgercode,incomeledger,inventoryledgercode,inventoryledgername,expenseledgercode,expenseledgername,username,locationname,locationcode,auditstatus,from_table) 
			values ('$itemcode', '$itemname', '$categoryname', '$res4packagename','$res4packagename', '$rateperunit', '$expiryperiod', '$taxanum', '$res4taxname', '$ipaddress', '$updatedatetime','$description', '$purchaseprice','$pkg','$genericname','$exclude','$minimumstock','$maximumstock','$rol','$roq','$ipmarkup','$spmarkup','$formula','$disease','$type','$producttype','$ledgername','$ledgercode','$ledgerautonumber','$transfertype','$nature','$incomeledgercode','$incomeledgername','$inventoryledgercode','$inventoryledgername','$expenseledgercode','$expenseledgername','$username','$locationname','$locationcode','i','master_medicine')";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));

				$subtypedata = '';
				$fields = array();
				$queryChk = "SHOW COLUMNS FROM audit_master_medicine";
				$execchk = mysqli_query($GLOBALS["___mysqli_ston"], $queryChk) or die("Error in queryChk" . mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($x = mysqli_fetch_assoc($execchk)) {

					if (stripos($x['Field'], "subtype_") !== false) {

						$fieldname = $x['Field'];
						if ($subtypedata != '') {
							$subtypedata = $subtypedata . ',';
						}
						$subtypedata = $subtypedata . "$fieldname='$rateperunit'";
					}
				}

				$query1 = "update audit_master_medicine set $subtypedata where itemcode='$itemcode'";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
			}

			//audit 1 loop end 			






			$query2 = "insert into master_itempharmacy (itemcode, itemname, categoryname, unitname_abbreviation, packagename,rateperunit, expiryperiod, taxanum, taxname, ipaddress, updatetime, description, purchaseprice, pkg, genericname,exclude,minimumstock,maximumstock,rol,roq,ipmarkup,spmarkup,formula,disease,type,producttypeid,ledgername,ledgercode,ledgerautonumber,transfertype,nature,incomeledgercode,incomeledger,inventoryledgercode,inventoryledgername,expenseledgercode,expenseledgername) 
			values ('$itemcode', '$itemname', '$categoryname', '$res4packagename','$res4packagename', '$rateperunit', '$expiryperiod', '$taxanum', '$res4taxname', '$ipaddress', '$updatedatetime','$description', '$purchaseprice','$pkg','$genericname','$exclude','$minimumstock','$maximumstock','$rol','$roq','$ipmarkup','$spmarkup','$formula','$disease','$type','$producttype','$ledgername','$ledgercode','$ledgerautonumber','$transfertype','$nature','$incomeledgercode','$incomeledgername','$inventoryledgercode','$inventoryledgername','$expenseledgercode','$expenseledgername')";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in Query2" . mysqli_error($GLOBALS["___mysqli_ston"]));

			// update pharmacy rate and subtypes

			// select pharmacy rate templates
			$sql_pharma_rate = "SELECT * FROM pharma_rate_template WHERE recordstatus <> 'deleted'";
			$exec_pharma_rate = mysqli_query($GLOBALS["___mysqli_ston"], $sql_pharma_rate) or die("Error in Query_pharma_rate" . mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res_pharma_rate = mysqli_fetch_array($exec_pharma_rate)) {
				$temp_id = $res_pharma_rate['auto_number'];
				$markup = $res_pharma_rate['markup'];

				$margin = $markup;
				$item_id = $itemcode;
				$item_price = (float)$purchaseprice;

				$var_price = (($margin / 100) * $item_price);
			$new_price = round(($item_price + $var_price),0);

				$date = date("Y-m-d");

				//insert new row in template rate mapping
				$sqlquerymap = "INSERT INTO pharma_template_map(templateid, productcode, rate, username,dateadded, recordstatus,margin) VALUES ('$temp_id','$item_id','$new_price','$username','$date','','$margin')";
				$exequerymap = mysqli_query($GLOBALS["___mysqli_ston"], $sqlquerymap);

				//check subtypes linked // if any update values
				$array_subtype = array();
				$query_st = "SELECT * FROM master_subtype WHERE pharmtemplate = '$temp_id' ";
				$exec_st = mysqli_query($GLOBALS["___mysqli_ston"], $query_st) or die("Error in Query_st" . mysqli_error($GLOBALS["___mysqli_ston"]));
				$count = 0;
				$col = "";
				while ($res_st = mysqli_fetch_array($exec_st)) {
					$count++;
					$subtype = $res_st['auto_number'];

					if ($count > 1) {
						$col .= ',';
					}

					$col= 'subtype_'.$subtype;
					$sqlquery_st_med = "UPDATE master_medicine SET $col='$new_price' WHERE itemcode = '$item_id'";
				//echo $sqlquery_st_med.'<br>';
				$exequery_st_med = mysqli_query($GLOBALS["___mysqli_ston"], $sqlquery_st_med);
				
				$sqlquery_st_med1 = "UPDATE audit_master_medicine SET $col='$new_price' itemcode = '$item_id'";
				//echo $sqlquery_st_med.'<br>';
				$exequery_st_med1 = mysqli_query($GLOBALS["___mysqli_ston"], $sqlquery_st_med1);
				}
				

				
			}



			$errmsg = "Success. New pharmacy Item Updated.";
			$bgcolorcode = 'success';
			$itemcode = '';
			$itemname = '';

			$rateperunit  = '0.00';
			$purchaseprice  = '0.00';
			$description = '';
			$referencevalue = '';

			// Check for URL messages
			if (isset($_GET['msg'])) {
			    if ($_GET['msg'] == 'success') {
			        $errmsg = "Pharmacy item added successfully.";
			        $bgcolorcode = 'success';
			    } elseif ($_GET['msg'] == 'failed') {
			        $errmsg = "Failed to add pharmacy item.";
			        $bgcolorcode = 'failed';
			    }
			}

			//$itemcode = '';
			$query1 = "select * from master_medicine order by auto_number desc limit 0, 1";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowcount1 = mysqli_num_rows($exec1);
			if ($rowcount1 == 0) {
				$itemcode = 'PRDIN001';
			} else {
				$res1 = mysqli_fetch_array($exec1);
				$res1itemcode = $res1['auto_number'];
				//$res1itemcode = substr($res1itemcode, 2, 8);
				$res1itemcode = intval($res1itemcode);
				$res1itemcode = $res1itemcode + 1;

				$res1itemcode = $res1itemcode;
				if (strlen($res1itemcode) == 2) {
					$res1itemcode = '0' . $res1itemcode;
				}
				if (strlen($res1itemcode) == 1) {
					$res1itemcode = '00' . $res1itemcode;
				}
				$itemcode = 'PRDIN' . $res1itemcode;
			}
		} else {
			$errmsg = "Failed. pharmacy Item Code Already Exists.";
			$bgcolorcode = 'failed';
		}
	} else {
		$errmsg = "Failed. pharmacy Item Code Should Be 25 Characters And Name Should Be 255 Characters.";
		$bgcolorcode = 'failed';
	}
} else {
	$itemname = '';
	$rateperunit  = '0.00';
	$purchaseprice  = '0.00';
	$description = '';
	$referencevalue = '';
}

//$itemcode = '';
$query1 = "select * from master_medicine order by auto_number desc limit 0,1";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
$rowcount1 = mysqli_num_rows($exec1);
if ($rowcount1 == 0) {
	$itemcode = 'PRDIN001';
} else {
	$res1 = mysqli_fetch_array($exec1);
	$res1itemcode = $res1['auto_number'];
	//$res1itemcode = substr($res1itemcode, 3, 7);
	$res1itemcode = intval($res1itemcode);
	 $res1itemcode = $res1itemcode + 1;

	/*
		$maxanum = $res1itemcode;
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
		*/


	if (strlen($res1itemcode) == 4) {
		$res1itemcode = '0' . $res1itemcode;
	}
	if (strlen($res1itemcode) == 3) {
		$res1itemcode = '00' . $res1itemcode;
	}
	$itemcode = 'PRDIN' . $res1itemcode;

	//echo $employeecode;
}




if (isset($_REQUEST["st"])) {
	$st = $_REQUEST["st"];
} else {
	$st = "";
}
if ($st == 'del') {
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_medicine set status = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query3" . mysqli_error($GLOBALS["___mysqli_ston"]));


	$fieldbuildpayment = "";
	$query35 = "show columns from master_medicine";
	$exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die("Error in Query35" . mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res35 = mysqli_fetch_array($exec35)) {
		$res35fields = "`" . $res35['Field'] . "`";

		if ($res35fields != "`auto_number`") {
			if ($fieldbuildpayment == '') {
				$fieldbuildpayment = $res35fields;
			} else {
				$fieldbuildpayment = $fieldbuildpayment . ',' . $res35fields;
			}
		}
	}

	$query433 = "select $fieldbuildpayment from master_medicine where auto_number = '$delanum'";
	$exec433 = mysqli_query($GLOBALS["___mysqli_ston"], $query433) or die("Error in Query433" . mysqli_error($GLOBALS["___mysqli_ston"]));
	$res433 = mysqli_fetch_array($exec433);

	$fieldbuildpayment1 = explode(',', $fieldbuildpayment);
	$valuebuildpayment = '';
	foreach ($fieldbuildpayment1 as $key1) {
		$fieldname = str_replace("`", "", $key1);
		$res43nbn = $res433[$fieldname];
		if ($valuebuildpayment == '') {
			$valuebuildpayment = "'" . $res43nbn . "'";
		} else {
			$valuebuildpayment = $valuebuildpayment . ',' . "'" . $res43nbn . "'";
		}
	}

	$query433valid = "select $fieldbuildpayment from master_medicine where auto_number = '$delanum'";
	$exec433valid = mysqli_query($GLOBALS["___mysqli_ston"], $query433valid) or die("Error in Query43valid" . mysqli_error($GLOBALS["___mysqli_ston"]));
	$res433valid = mysqli_fetch_array($exec433valid);
	$rows433valid = mysqli_num_rows($exec433valid);
	if ($rows433valid == 1) {
		$query644 = "insert into audit_master_medicine($fieldbuildpayment,auditstatus,from_table) values($valuebuildpayment,'d','master_medicine')";
		$exec644 = mysqli_query($GLOBALS["___mysqli_ston"], $query644) or die("Error in Query6444" . mysqli_error($GLOBALS["___mysqli_ston"]));
	}






	$query3 = "update master_itempharmacy set status = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query3" . mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'activate') {
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_medicine set status = '' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query3" . mysqli_error($GLOBALS["___mysqli_ston"]));

	$fieldbuildpayment = "";
	$query35 = "show columns from master_medicine";
	$exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die("Error in Query35" . mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res35 = mysqli_fetch_array($exec35)) {
		$res35fields = "`" . $res35['Field'] . "`";
		if ($res35fields != "`auto_number`") {
			if ($fieldbuildpayment == '') {
				$fieldbuildpayment = $res35fields;
			} else {
				$fieldbuildpayment = $fieldbuildpayment . ',' . $res35fields;
			}
		}
	}


	$query433 = "select $fieldbuildpayment from master_medicine where auto_number = '$delanum'";
	$exec433 = mysqli_query($GLOBALS["___mysqli_ston"], $query433) or die("Error in Query433" . mysqli_error($GLOBALS["___mysqli_ston"]));
	$res433 = mysqli_fetch_array($exec433);

	$fieldbuildpayment1 = explode(',', $fieldbuildpayment);
	$valuebuildpayment = '';
	foreach ($fieldbuildpayment1 as $key1) {
		$fieldname = str_replace("`", "", $key1);
		$res43nbn = $res433[$fieldname];

		if ($valuebuildpayment == '') {
			$valuebuildpayment = "'" . $res43nbn . "'";
		} else {

			$valuebuildpayment = $valuebuildpayment . ',' . "'" . $res43nbn . "'";
		}
	}




	$query433valid = "select $fieldbuildpayment from master_medicine where auto_number = '$delanum'";
	$exec433valid = mysqli_query($GLOBALS["___mysqli_ston"], $query433valid) or die("Error in Query43valid" . mysqli_error($GLOBALS["___mysqli_ston"]));
	$res433valid = mysqli_fetch_array($exec433valid);
	$rows433valid = mysqli_num_rows($exec433valid);
	if ($rows433valid == 1) {
		$query644 = "insert into audit_master_medicine($fieldbuildpayment,auditstatus,from_table) values($valuebuildpayment,'a','master_medicine')";
		$exec644 = mysqli_query($GLOBALS["___mysqli_ston"], $query644) or die("Error in Query6444" . mysqli_error($GLOBALS["___mysqli_ston"]));
	}






	$query3 = "update master_itempharmacy set status = '' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query3" . mysqli_error($GLOBALS["___mysqli_ston"]));
}


if (isset($_REQUEST["svccount"])) {
	$svccount = $_REQUEST["svccount"];
} else {
	$svccount = "";
}
if ($svccount == 'firstentry') {
	$errmsg = "Please Add pharmacy Item To Proceed For Billing.";
	$bgcolorcode = 'failed';
}

if (isset($_REQUEST["searchflag1"])) {
	$searchflag1 = $_REQUEST["searchflag1"];
} else {
	$searchflag1 = "";
}
if (isset($_REQUEST["searchflag2"])) {
	$searchflag2 = $_REQUEST["searchflag2"];
} else {
	$searchflag2 = "";
}
if (isset($_REQUEST["search1"])) {
	$search1 = $_REQUEST["search1"];
} else {
	$search1 = "";
}
if (isset($_REQUEST["searchcat"])) {
	$searchcat = $_REQUEST["searchcat"];
} else {
	$searchcat = "";
}
if (isset($_REQUEST["searchgen"])) {
	$searchgen = $_REQUEST["searchgen"];
} else {
	$searchgen = "";
}
if (isset($_REQUEST["pharmacytype"])) {
	$pharmacytype = $_REQUEST["pharmacytype"];
} else {
	$pharmacytype = "";
}
if (isset($_REQUEST["search2"])) {
	$search2 = $_REQUEST["search2"];
} else {
	$search2 = "";
}






?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Item Master - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/pharmacy-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Legacy CSS for compatibility -->
    <link href="../hospitalmillennium/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/autocomplete.css">
    <link href="js/jquery-ui.css" rel="stylesheet">
    
    <!-- Legacy JavaScript -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/jquery-ui.js" type="text/javascript"></script>
<style type="text/css">
	<!--
	.bodytext3 {
		FONT-WEIGHT: normal;
		FONT-SIZE: 11px;
		COLOR: #3b3b3c;
		FONT-FAMILY: Tahoma;
		text-decoration: none
	}

	.bodytext31 {
		FONT-WEIGHT: normal;
		FONT-SIZE: 11px;
		COLOR: #3b3b3c;
		FONT-FAMILY: Tahoma;
		text-decoration: none
	}

	.bodytext32 {
		FONT-WEIGHT: normal;
		FONT-SIZE: 11px;
		COLOR: #3B3B3C;
		FONT-FAMILY: Tahoma;
		text-decoration: none
	}

	.bodytext32 {
		FONT-WEIGHT: normal;
		FONT-SIZE: 11px;
		COLOR: #3b3b3c;
		FONT-FAMILY: Tahoma;
		text-decoration: none
	}

	.pagination {
		float: right;
	}
	-->
	.ui-menu
	.ui-menu-item
	{
	zoom:1.3
	 !important;
	}
</style>
</head>
<script language="javascript">
	$(function() {

		$('.sorting').click(function() {

			$('#activepharmacylist').empty();

			var sortfunc = $("#sortfunc").val();
			var search1 = $("#search1").val();
			var start = $("#start").val();
			var limit = $("#limit").val();

			var textid = $(this).attr('id');
			if (textid == 'category') {
				var orderby = 'categoryname';
			} else if (textid == 'pharmacyitem') {

				var orderby = 'itemname';
			} else if (textid == 'generic') {

				var orderby = 'genericname';
			} else if (textid == 'phtype') {

				var orderby = 'type';
			}

			$(document).ajaxStart(function() {
				$("#wait").css("display", "block");
			});
			$(document).ajaxComplete(function() {
				$("#wait").css("display", "none");
			});

			if (sortfunc == '') {
				sortfunc = 'desc';
			}

			var dataString = 'sortfunc=' + sortfunc + '&&search1=' + search1 + '&&orderby=' + orderby + '&&start=' + start + '&&limit=' + limit;
			//alert(dataString);		
			$.ajax({
				type: "GET",
				url: "ajaxpharmacylistsorting.php",
				data: dataString,
				cache: true,
				//delay:100,
				success: function(html) {
					html = html.trim()
					//alert(html);

					$("#activepharmacylist").append(html);

					$("#sortcolumn").val(textid);
					if (sortfunc == 'asc') {
						$('#' + textid + 'up').hide();
						$('#' + textid + 'down').show();
						sortfunc = 'desc';
						$("#sortfunc").val(sortfunc);
					} else {
						$('#' + textid + 'down').hide();
						$('#' + textid + 'up').show();
						sortfunc = 'asc';
						$("#sortfunc").val(sortfunc);
					}

				}
			});
		});

		$('#search1').autocomplete({
			source: 'ajaxpharmacyitems.php?action=item',
			minLength: 1,
			html: true,
			select: function(event, ui) {
				var medicine = ui.item.value;
				$('#search1').val(medicine);

			},
		});

		$('#searchcat').autocomplete({
			source: 'ajaxpharmacyitems.php?action=category',
			minLength: 1,
			html: true,
			select: function(event, ui) {
				var category = ui.item.value;
				$('#searchcat').val(category);

			},
		});

		$('#searchgen').autocomplete({
			source: 'ajaxpharmacyitems.php?action=generic',
			minLength: 1,
			html: true,
			select: function(event, ui) {
				var generic = ui.item.value;
				$('#searchgen').val(generic);

			},
		});
	});
	//fixed option

	function fixed2() {
		var formula = document.getElementById("formula");
		var packageanum = document.getElementById("packageanum");
		if (formula.value == 'FIXED') {
			packageanum.value = '14';
			packageanum.onchange = function() {
				if (packageanum.value != '14' && formula.value == 'FIXED') {
					alert("For Fixed formula, package value is 1.");
					packageanum.value = '14';
				}
			};
		} else {
			packageanum.selectedIndex = '0';
		}
	}

	function additem1process1() {
		//alert ("Inside Funtion");
		if (document.form1.categoryname.value == "") {
			alert("Please Select Category Name.");
			document.form1.categoryname.focus();
			return false;
		}
		if (document.form1.itemcode.value == "") {
			alert("Please Enter pharmacy Item Code or ID.");
			document.form1.itemcode.focus();
			return false;
		}
		if (document.form1.itemcode.value != "") {
			var data = document.form1.itemcode.value;
			//alert(data);
			// var iChars = "!%^&*()+=[];,.{}|\:<>?~"; //All special characters.*
			var iChars = "!^+=[];,{}|\<>?~$'\"@#%&*()-_`. ";
			for (var i = 0; i < data.length; i++) {
				if (iChars.indexOf(data.charAt(i)) != -1) {
					//alert ("Your radiology Item Name Has Blank White Spaces Or Special Characters. Like ! ^ + = [ ] ; , { } | \ < > ? ~ $ ' \" These are not allowed.");
					alert("Your pharmacy Item Code Has Blank White Spaces Or Special Characters. These Are Not Allowed.");
					return false;
				}
			}
		}
		if (document.form1.itemname.value == "") {
			alert("Pleae Enter pharmacy Item Name.");
			document.form1.itemname.focus();
			return false;
		}
		/*
		if (document.form1.itemname_abbreviation.value == "")
		{
			alert ("Pleae Select Unit Name.");
			document.form1.itemname_abbreviation.focus();
			return false;
		}
		*/
		if (document.form1.purchaseprice.value == "") {
			alert("Please Enter Purchase Price Per Unit.");
			document.form1.purchaseprice.focus();
			return false;
		}
		if (document.form1.rateperunit.value == "") {
			alert("Please Enter Selling Price Per Unit.");
			document.form1.rateperunit.focus();
			return false;
		}
		if (document.form1.taxanum.value == "") {
			alert("Please Select Applicable Tax.");
			document.form1.taxanum.focus();
			return false;
		}
		if (isNaN(document.form1.rateperunit.value) == true) {
			alert("Please Enter Rate Per Unit In Numbers.");
			document.form1.rateperunit.focus();
			return false;
		}
		if (document.form1.type.value == "") {
			alert("Please Select Purchase Type.");
			document.form1.type.focus();
			return false;
		}
		if (document.form1.producttype.value == "") {
			alert("Please Select Product Type.");
			document.form1.producttype.focus();
			return false;
		}

		////////////////for ledgers /////////////////
		if (document.form1.saccountid.value == "") {
			//if (document.form1.type.value == "DRUGS") {
			alert("Please Select Income Account Name.");
			document.form1.saccountname.focus();
			return false;
			//}
		}
		if (document.form1.iaccountid.value == "") {
			//if (document.form1.type.value == "DRUGS") {
			alert("Please Select COGS Account Name.");
			document.form1.iaccountname.focus();
			return false;
			//}
		}

		if (document.form1.inv_accountid.value == "") {
			alert("Please Select Inventory Account Name.");
			document.form1.inv_accountname.focus();
			return false;
		}

		if (document.form1.exp_accountid.value == "") {
			//if (document.form1.type.value == "NON DRUGS") {
			alert("Please Select Expense Account Name.");
			document.form1.exp_accountname.focus();
			return false;
			//}
		}
		////////////////for ledgers /////////////////

		// if (document.form1.drug_instructions.value == "")
		// {	
		// 	alert ("Please Select Drug Instructions.");
		// 	document.form1.drug_instructions.focus();
		// 	return false;
		// }

		// if (document.form1.dose_measure.value == "")
		// {	
		// 	alert ("Please Select Dose Measure.");
		// 	document.form1.dose_measure.focus();
		// 	return false;
		// }



		/*if (document.form1.saccountid.value == "")
		{	
			alert ("Please Select COGS Account Name.");
			document.form1.saccountname.focus();
			return false;
		}
		if (document.form1.iaccountid.value == "")
		{	
			alert ("Please Select Income Account Name.");
			document.form1.iaccountname.focus();
			return false;
		}*/



		if (document.form1.formula.value !== "") {
			if (document.form1.formula.value === "CONSTANT" && (document.form1.roq.value === "" || document.form1.roq.value == 0)) {
				alert("Constant formula should have volume");
				document.form1.roq.focus();
				return false;
				//}
			}
		} else {
			alert("Formula should not be null ");
			document.form1.formula.focus();
			return false
		}

		if (document.form1.costprice.value == "" || document.form1.costprice.value == 0) {
			alert("Please Enter Cost price.");
			document.form1.costprice.focus();
			return false;
		}

		if (document.form1.rateperunit.value == "0.00") {
			var fRet;
			fRet = confirm(' Are You Sure You Want To Continue To Save?');
			//alert(fRet);  // true = ok , false = cancel
			if (fRet == false) {
				return false;
			}
			/*		else if (document.form1.itemname_abbreviation.value == "SR")
					{
						if (document.form1.expiryperiod.value == "")
						{	
							alert ("Please Select Expiry Period.");
							document.form1.expiryperiod.focus();
							return false;
						}
					}
			*/
		}



		/*	else if (document.form1.itemname_abbreviation.value == "SR")
			{
				if (document.form1.expiryperiod.value == "")
				{	
					alert ("Please Select Expiry Period.");
					document.form1.expiryperiod.focus();
					return false;
				}
			}
		*/
	}

	/*
	function process1()
	{
		//alert (document.form1.itemname.value);
		if (document.form1.itemname_abbreviation.value == "SR")
		{
			document.getElementById('expiryperiod').style.visibility = '';
		}
		else
		{
			document.getElementById('expiryperiod').style.visibility = 'hidden';
		}
	}
	*/
	function spl() {
	  var key = event.keyCode || event.charCode;
   if(key=='222')
   {
        return false;
	   //alert('yes');
	   return false;
   }
	}


	function process2() {
		//document.getElementById('expiryperiod').style.visibility = 'hidden';
	}

	function process1backkeypress1() {
		if (event.keyCode == 8) {
			event.keyCode = 0;
			return event.keyCode
			return false;
		}

		var key;
		if (window.event) {
			key = window.event.keyCode; //IE
		} else {
			key = e.which; //firefox
		}

		if (key == 13) // if enter key press
		{
			return false;
		} else {
			return true;
		}

	}
</script>


<script src="js/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script>
	$(function() {

		$('#saccountname').autocomplete({

			source: 'accountnameajax.php',

			minLength: 2,
			delay: 0,
			html: true,
			select: function(event, ui) {
				var saccountauto = ui.item.saccountauto;
				var saccountid = ui.item.saccountid;
				$('#saccountauto').val(saccountauto);
				$('#saccountid').val(saccountid);
			}
		});

		$('#iaccountname').autocomplete({

			source: 'accountnameajax1.php',

			minLength: 2,
			delay: 0,
			html: true,
			select: function(event, ui) {
				var saccountauto = ui.item.saccountauto;
				var saccountid = ui.item.saccountid;
				$('#iaccountauto').val(saccountauto);
				$('#iaccountid').val(saccountid);
			}
		});

		$('#inv_accountname').autocomplete({

			source: 'accountnameajax2.php',

			minLength: 2,
			delay: 0,
			html: true,
			select: function(event, ui) {
				var saccountauto = ui.item.saccountauto;
				var saccountid = ui.item.saccountid;
				$('#inv_accountauto').val(saccountauto);
				$('#inv_accountid').val(saccountid);
			}
		});

		// expense account
		$('#exp_accountname').autocomplete({

			source: 'accountnameajax3.php',

			minLength: 2,
			delay: 0,
			html: true,
			select: function(event, ui) {
				var saccountauto = ui.item.saccountauto;
				var saccountid = ui.item.saccountid;
				$('#exp_accountauto').val(saccountauto);
				$('#exp_accountid').val(saccountid);
			}
		});
	});
</script>

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
        <span>Pharmacy Item Master</span>
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
                        <a href="labitem1master.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Items</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="openingstockentry_master.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Opening Stock</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addward.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Wards</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountreceivableentrylist.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>Account Receivable</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="corporateoutstanding.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Corporate Outstanding</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountstatement.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Account Statement</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountsmain.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Accounts Main</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountssub.php" class="nav-link">
                            <i class="fas fa-chart-pie"></i>
                            <span>Accounts Sub Type</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="fixedasset_acquisition_report.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Fixed Asset Acquisition</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeinpatientlist.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Active Inpatient List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeusersreport.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Active Users Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartofaccounts_upload.php" class="nav-link">
                            <i class="fas fa-upload"></i>
                            <span>Chart of Accounts Upload</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartaccountsmaindataimport.php" class="nav-link">
                            <i class="fas fa-database"></i>
                            <span>Chart of Accounts Main Import</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartaccountssubdataimport.php" class="nav-link">
                            <i class="fas fa-database"></i>
                            <span>Chart of Accounts Sub Import</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addbloodgroup.php" class="nav-link">
                            <i class="fas fa-tint"></i>
                            <span>Blood Group Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addfoodallergy1.php" class="nav-link">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Food Allergy Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addgenericname.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Generic Name Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addpromotion.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>Promotion Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addsalutation1.php" class="nav-link">
                            <i class="fas fa-user-tie"></i>
                            <span>Salutation Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="vat.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>VAT Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="payrollmonthwiseinterim.php" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Payroll Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="internalreferallist.php" class="nav-link">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Internal Referral List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="crdradjustment.php" class="nav-link">
                            <i class="fas fa-balance-scale"></i>
                            <span>Credit/Debit Adjustment</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="pharmacyitem1.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Pharmacy Item Master</span>
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
                
                <?php if ($st == 1): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-triangle alert-icon"></i>
                        <span>Sorry Special Characters Are Not Allowed</span>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_REQUEST['errmsg'])): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-triangle alert-icon"></i>
                        <span><?php echo htmlspecialchars($_REQUEST['errmsg']); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Pharmacy Item Master</h2>
                    <p>Manage pharmacy items, medications, and inventory for the hospital pharmacy.</p>
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

            <!-- Add New Pharmacy Item Section -->
            <div class="add-item-section">
                <div class="section-header">
                    <i class="fas fa-plus-circle"></i>
                    <h3>Add New Pharmacy Item</h3>
                </div>
                
                <form name="form1" id="form1" method="post" action="pharmacyitem1.php" onSubmit="return additem1process1();" class="pharmacy-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="categoryname" class="form-label">Category Name</label>
                            <select id="categoryname" name="categoryname" class="form-select">
                                <?php
                                if ($categoryname != '') {
                                ?>
                                    <option value="<?php echo $categoryname; ?>" selected="selected"><?php echo $categoryname; ?></option>
                                <?php
                                } else {
                                ?>
                                    <option value="" selected="selected">Select Category</option>
                                <?php
                                }
                                $query1 = "select * from master_categorypharmacy where status <> 'deleted' order by categoryname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $res1categoryname = $res1["categoryname"];
                                ?>
                                    <option value="<?php echo $res1categoryname; ?>"><?php echo $res1categoryname; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <a href="pharmacycategory1.php" class="form-link">
                                <i class="fas fa-plus"></i> Add New Category
                            </a>
                        </div>
                        
                        <div class="form-group">
                            <label for="genericname" class="form-label">Generic Name</label>
                            <select id="genericname" name="genericname" class="form-select">
                                <option value="" selected="selected">Select Generic Name</option>
                                <?php
                                $query111 = "select * from master_genericname where recordstatus = '' ";
                                $exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die("Error in Query111" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res111 = mysqli_fetch_array($exec111)) {
                                    $res111genericname = $res111['genericname'];
                                ?>
                                    <option value="<?php echo $res111genericname; ?>"><?php echo $res111genericname; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="itemcode" class="form-label">Item Code</label>
                            <input name="itemcode" readonly value="<?php echo $itemcode; ?>" id="itemcode" 
                                   onKeyDown="return process1backkeypress1()" class="form-input readonly" 
                                   size="20" maxlength="100" />
                            <span class="form-hint">( Example : PRD1234567890 )</span>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Exclude</label>
                            <div class="checkbox-group">
                                <input type="checkbox" name="exclude" id="exclude" class="form-checkbox">
                                <label for="exclude" class="checkbox-label">Exclude from reports</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="itemname" class="form-label">Item Name</label>
                            <input name="itemname" type="text" id="itemname" class="form-input" 
                                   onkeydown="return spl()" value="<?php echo $itemname; ?>" size="60">
                        </div>
                        
                        <div class="form-group">
                            <label for="minimumstock" class="form-label">Min Stock</label>
                            <input type="text" name="minimumstock" id="minimumstock" class="form-input">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="rateperunit2" class="form-label">Charge Price Per Unit</label>
                            <input name="rateperunit2" id="rateperunit2" class="form-input" 
                                   value="<?php echo $rateperunit; ?>" size="20">
                        </div>
                        
                        <div class="form-group">
                            <label for="maximumstock" class="form-label">Max Stock</label>
                            <input type="text" name="maximumstock" id="maximumstock" class="form-input">
                        </div>
                    </div>
													<!--  <tr>
                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">radiology Item Reference Value (Optional) </div></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><textarea name="referencevalue" cols="60" id="referencevalue" style="border: 1px solid #001E6A"><?php echo $referencevalue; ?></textarea>
                          <input name="description" type="hidden" id="description" style="border: 1px solid #001E6A" value="<?php echo $description; ?>" size="60"></td>
                      </tr>-->
													<!--<tr>
                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Select Applicable Tax </div></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5">
						<select id="taxanum" name="taxanum">
                            <option value="">Select Tax</option>-->
													<?php /*?>  <?php
						$query1 = "select * from master_tax where status <> 'deleted' order by taxname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
						$res1taxname = $res1["taxname"];
						$res1taxpercent = $res1["taxpercent"];
						$res1anum = $res1["auto_number"];
						?>
                            <option value="<?php echo $res1anum; ?>"><?php echo $res1taxname.' ( '.$res1taxpercent.'% ) '; ?></option>
                            <?php
						}
						?><?php */ ?>
													</select>
													<!--                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
						<div align="right">radiology Item Period </div></td>
                        <td valign="top" align="left" >
						<select class="box" id="expiryperiod" 
                  style="BORDER-RIGHT: #001e6a 1px solid; BORDER-TOP: #001e6a 1px solid; BORDER-LEFT: #001e6a 1px solid; BORDER-BOTTOM: #001e6a 1px solid" 
                  name="expiryperiod">
                            <option value="0" selected="selected">No Renewal</option>
							<?php
							for ($i = 1; $i <= 60; $i++) {
							?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?> Months</option>
							<?php
							}
							?>
                        </select></td>
                      </tr>
-->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="formula" class="form-label">Formula</label>
                            <select id="formula" name="formula" onChange="fixed2()" class="form-select">
                                <option value="">Select Formula</option>
                                <option value="CONSTANT">Constant</option>
                                <option value="FIXED">Fixed</option>
                                <option value="INCREMENT">Increment</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="rol" class="form-label">ROL</label>
                            <input type="text" name="rol" id="rol" class="form-input">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="packageanum" class="form-label">Pharmacy Package</label>
                            <select id="packageanum" name="packageanum" class="form-select">
                                <?php
                                $query1 = "select * from master_packagepharmacy where status <> 'deleted' order by packagename";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $res1anum = $res1['auto_number'];
                                    $res1packagename = $res1["packagename"];
                                    $res1packagename = stripslashes($res1packagename);
                                    $quantityperpackage = $res1["quantityperpackage"];
                                    $quantityperpackage = round($quantityperpackage);
                                ?>
                                    <option value="<?php echo $res1anum; ?>"><?php echo $res1packagename . ' ( ' . $quantityperpackage . ' ) '; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="roq" class="form-label">Volume (for CONSTANT item)</label>
                            <input type="text" name="roq" id="roq" class="form-input">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="taxanum" class="form-label">Applicable Tax</label>
                            <select id="taxanum" name="taxanum" class="form-select">
                                <option value="">Select Tax</option>
                                <?php
                                $query1 = "select * from master_tax where status <> 'deleted' order by taxname";
                                $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res1 = mysqli_fetch_array($exec1)) {
                                    $res1taxname = $res1["taxname"];
                                    $res1taxpercent = $res1["taxpercent"];
                                    $res1anum = $res1["auto_number"];
                                ?>
                                    <option value="<?php echo $res1anum; ?>"><?php echo $res1taxname . ' ( ' . $res1taxpercent . '% ) '; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            
                            <!-- Hidden fields -->
                            <input name="rateperunit" type="hidden" id="rateperunit" value="<?php echo $rateperunit; ?>" />
                            <input type="hidden" name="purchaseprice" id="purchaseprice" value="<?php echo $purchaseprice; ?>" />
                            <input name="description" type="hidden" id="description" value="<?php echo $description; ?>">
                            <input type="hidden" name="unitname_abbreviation" id="unitname_abbreviation" value="NOS">
                        </div>
                        
                        <div class="form-group">
                            <label for="ipmarkup" class="form-label">IP Mark up</label>
                            <input type="text" name="ipmarkup" id="ipmarkup" class="form-input">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="costprice" class="form-label">Cost Price</label>
                            <input type="text" name="costprice" id="costprice" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="spmarkup" class="form-label">SP Mark up</label>
                            <input type="text" name="spmarkup" id="spmarkup" class="form-input">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="disease" class="form-label">Disease</label>
                            <input type="text" name="disease" id="disease" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="type" class="form-label">Purchase Type</label>
                            <select name="type" id="type" class="form-select">
                                <option value="">Select Purchase Type</option>
                                <?php
                                $query = "select id,name from master_purchase_type where status !='deleted' order by id desc";
                                $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res = mysqli_fetch_array($exec)) {
                                    $producttype = $res["name"];
                                    $product_type_id = $res["id"];
                                ?>
                                    <option value="<?php echo $producttype; ?>"><?php echo $producttype; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

													<!--Product Type-->
													<tr>
														<!--empty col-->
														<td align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3"></td>
														<td align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3"></td>
														<!-- empty col-->
														<td align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">Product Type</td>
														<td align="left" valign="top" bgcolor="#ecf0f5">
															<select name="producttype" id="producttype">
																<option value="" selected="selected">Select Product Type</option>
																<?php
																// Select * from product_type table
																$query_prod_type = "select * from product_type where status = '1' ";
																$exec_prod_type = mysqli_query($GLOBALS["___mysqli_ston"], $query_prod_type) or die("Error in query_prod_type" . mysqli_error($GLOBALS["___mysqli_ston"]));
																while ($res_prod_type = mysqli_fetch_array($exec_prod_type)) {
																	$res_prod_name = $res_prod_type['name'];
																	$res_prod_id = $res_prod_type['id'];
																?>
																	<option value="<?php echo $res_prod_id; ?>"><?php echo $res_prod_name; ?></option>
																<?php
																}
																?>
															</select>
														</td>
													</tr>
													<tr>
														<td align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">Drug Instructions</td>
														<td align="left" valign="top" bgcolor="#ecf0f5">
															<select name="drug_instructions" id="drug_instructions">
																<option value="" selected="selected">Select Drug Instruction</option>
																<?php
																$query_prod_type = "select * from drug_instructions where status = '1' ";
																$exec_prod_type = mysqli_query($GLOBALS["___mysqli_ston"], $query_prod_type) or die("Error in query_prod_type" . mysqli_error($GLOBALS["___mysqli_ston"]));
																while ($res_prod_type = mysqli_fetch_array($exec_prod_type)) {
																	$res_prod_name = $res_prod_type['name'];
																	$res_prod_id = $res_prod_type['id'];
																?>
																	<option value="<?php echo $res_prod_id; ?>"><?php echo $res_prod_name; ?></option>
																<?php
																}
																?>
															</select>
														</td>

														<td align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">Dose Measure</td>
														<td align="left" valign="top" bgcolor="#ecf0f5">
															<select name="dose_measure" id="dose_measure">
																<option value="" selected="selected">Select Dose Measure</option>
																<?php
																$query_prod_type = "select * from dose_measure where status = '1' ";
																$exec_prod_type = mysqli_query($GLOBALS["___mysqli_ston"], $query_prod_type) or die("Error in query_prod_type" . mysqli_error($GLOBALS["___mysqli_ston"]));
																while ($res_prod_type = mysqli_fetch_array($exec_prod_type)) {
																	$res_prod_name = $res_prod_type['name'];
																	$res_prod_id = $res_prod_type['id'];
																?>
																	<option value="<?php echo $res_prod_id; ?>"><?php echo $res_prod_name; ?></option>
																<?php
																}
																?>
															</select>
														</td>
													</tr>
													<tr>
														<td align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">Package</td>
														<td align="left" valign="top" bgcolor="#ecf0f5"><input type="checkbox" name="pkg" value="yes"></td>
														<td width="13%" align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">Income Ledger</td>
														<td width="33%" align="left" valign="top" bgcolor="#ecf0f5">
															<input type="text" name="saccountname" id="saccountname" size="30" />
															<input type="hidden" name="saccountauto" id="saccountauto" />
															<input type="hidden" name="saccountid" id="saccountid" />
														</td>
													</tr>

													<tr>
														<td align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">Transfer Type</td>
														<td align="left" valign="top" bgcolor="#ecf0f5"><select name="transfertype" id="transfertype">
																<option value="">Select</option>
																<option value="0">Transfer</option>
																<option value="1">Consumable</option>
															</select> </td>
														<td width="13%" align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">COGS Ledger</td>
														<td width="33%" align="left" valign="top" bgcolor="#ecf0f5">
															<input type="text" name="iaccountname" id="iaccountname" size="30" />
															<input type="hidden" name="iaccountauto" id="iaccountauto" />
															<input type="hidden" name="iaccountid" id="iaccountid" />
														</td>
													</tr>
													<tr>
														<!-- <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td> -->
														<td align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">Nature Type</td>
														<td align="left" width="13%" valign="top" bgcolor="#ecf0f5"><select name="nature" id="nature">
																<option value="">Select</option>
																<option value="0">Nature 1</option>
																<option value="1">Nature 2</option>
															</select> </td>

														<!-- <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td> -->
														<td width="13%" align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">Inventory Ledger</td>
														<td width="33%" align="left" valign="top" bgcolor="#ecf0f5">
															<input type="text" name="inv_accountname" id="inv_accountname" size="30" value="" />
															<input type="hidden" name="inv_accountauto" id="inv_accountauto" value="" />
															<input type="hidden" name="inv_accountid" id="inv_accountid" value="" />
														</td>
													</tr>
													<tr>
														<td width="13%" align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">Expense Ledger</td>
														<td width="33%" align="left" valign="top" bgcolor="#ecf0f5">
															<input type="text" name="exp_accountname" id="exp_accountname" size="30" value="" />
															<input type="hidden" name="exp_accountauto" id="exp_accountauto" value="" />
															<input type="hidden" name="exp_accountid" id="exp_accountid" value="" />
														</td>


													</tr>


                    <div class="form-actions">
                        <input type="hidden" name="frmflag1" value="frmflag1" />
                        <input type="hidden" name="frmflag" value="addnew" />
                        <button type="submit" name="Submit" class="submit-btn">
                            <i class="fas fa-save"></i>
                            Save Pharmacy Item
                        </button>
                    </div>
                </form>
            </div>
												</tbody>
											</table>
										</form>
										<form>
											<table width="1200" border="0" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

												<tr bgcolor="#011E6A">
													<td colspan="15" bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><strong>Pharmacy Item Master - Existing List - Latest 100 pharmacy Items </strong></span></td>
													<td bgcolor="#ecf0f5" colspan="3" class="bodytext3"><span class="bodytext32">
															<?php //error_reporting(0);
															//if($searchflag1 != 'searchflag1')
															{

																$tbl_name = "master_medicine";		//your table name
																// How many adjacent pages should be shown on each side?
																$adjacents = 3;

																/* 
							   First get total number of rows in data table. 
							   If you have a WHERE clause in your query, make sure you mirror it here.
							*/
																if ($pharmacytype == '') {
																	$typecondtion = "AND type LIKE '%$pharmacytype%'";
																} else {
																	$typecondtion = "AND type = '$pharmacytype'";
																}
																$query111 = "select * from $tbl_name where  status <> 'deleted'  AND (itemname like '%$search1%' AND categoryname like '%$searchcat%' AND genericname like '%$searchgen%'  $typecondtion)";
																$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die("Error in Query111" . mysqli_error($GLOBALS["___mysqli_ston"]));
																$res111 = mysqli_fetch_array($exec111);
																$total_pages = mysqli_num_rows($exec111);

																/*$query = "SELECT * FROM $tbl_name";
							$total_pages = mysql_fetch_array(mysql_query($query));
							echo $numrow = mysql_num_rows($total_pages);*/

																/* Setup vars for query. */
																$targetpage = $_SERVER['PHP_SELF']; 	//your file name  (the name of this file)
																$limit = 10; 								//how many items to show per page
																if (isset($_REQUEST['page'])) {
																	$page = $_REQUEST['page'];
																} else {
																	$page = "";
																}
																if ($page)
																	$start = ($page - 1) * $limit; 			//first item to display on this page
																else
																	$start = 0;								//if no page var is given, set start to 0

																/* Setup page vars for display. */
																if ($page == 0) $page = 1;					//if no page var is given, default to 1.
																$prev = $page - 1;							//previous page is page - 1
																$next = $page + 1;							//next page is page + 1
																$lastpage = ceil($total_pages / $limit);		//lastpage is = total pages / items per page, rounded up.
																$lpm1 = $lastpage - 1;						//last page minus 1

																/* 
								Now we apply our rules and draw the pagination object. 
								We're actually saving the code to a variable in case we want to draw it more than once.
							*/
																$pagination = "";
																if ($lastpage > 1) {
																	$pagination .= "<div class=\"pagination\">";
																	//previous button
																	if ($page > 1)
																		$pagination .= "<a href=\"$targetpage?page=$prev&&search1=$search1&&searchflag1=$searchflag1&&searchcat=$searchcat&&searchgen=$searchgen&&pharmacytype=$pharmacytype\" style='color:#3b3b3c;'>previous</a>";
																	else
																		$pagination .= "<span class=\"disabled\">previous</span>";

																	//pages	
																	if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
																	{
																		for ($counter = 1; $counter <= $lastpage; $counter++) {
																			if ($counter == $page)
																				$pagination .= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
																			else
																				$pagination .= "<a href=\"$targetpage?page=$counter&&search1=$search1&&searchflag1=$searchflag1&&searchcat=$searchcat&&searchgen=$searchgen&&pharmacytype=$pharmacytype\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";
																		}
																	} elseif ($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
																	{
																		//close to beginning; only hide later pages
																		if ($page < 1 + ($adjacents * 2)) {
																			for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
																				if ($counter == $page)
																					$pagination .= "<span class=\"current\" style='margin:0 0 0 2px;' color:#3b3b3c;>$counter</span>";
																				else
																					$pagination .= "<a href=\"$targetpage?page=$counter&&search1=$search1&&searchflag1=$searchflag1&&searchcat=$searchcat&&searchgen=$searchgen&&pharmacytype=$pharmacytype\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";
																			}
																			$pagination .= "...";
																			$pagination .= "<a href=\"$targetpage?page=$lpm1&&search1=$search1&&searchflag1=$searchflag1&&searchcat=$searchcat&&searchgen=$searchgen&&pharmacytype=$pharmacytype\"style='margin:0 0 0 2px; color:#3b3b3c;'>$lpm1</a>";
																			$pagination .= "<a href=\"$targetpage?page=$lastpage&&search1=$search1&&searchflag1=$searchflag1&&searchcat=$searchcat&&searchgen=$searchgen&&pharmacytype=$pharmacytype\"style='margin:0 0 0 2px; color:#3b3b3c;'>$lastpage</a>";
																		}
																		//in middle; hide some front and some back
																		elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
																			$pagination .= "<a href=\"$targetpage?page=1&&search1=$search1&&searchflag1=$searchflag1&&searchcat=$searchcat&&searchgen=$searchgen&&pharmacytype=$pharmacytype\" style='margin:0 0 0 2px; color:#3b3b3c;'>1</a>";
																			$pagination .= "<a href=\"$targetpage?page=2&&search1=$search1&&searchflag1=$searchflag1&&searchcat=$searchcat&&searchgen=$searchgen&&pharmacytype=$pharmacytype\" style='margin:0 0 0 2px; color:#3b3b3c;'>2</a>";
																			$pagination .= "...";
																			for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
																				if ($counter == $page)
																					$pagination .= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
																				else
																					$pagination .= "<a href=\"$targetpage?page=$counter&&search1=$search1&&searchflag1=$searchflag1&&searchcat=$searchcat&&searchgen=$searchgen&&pharmacytype=$pharmacytype\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";
																			}
																			$pagination .= "...";
																			$pagination .= "<a href=\"$targetpage?page=$lpm1&&search1=$search1&&searchflag1=$searchflag1&&searchcat=$searchcat&&searchgen=$searchgen&&pharmacytype=$pharmacytype\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lpm1</a>";
																			$pagination .= "<a href=\"$targetpage?page=$lastpage&&search1=$search1&&searchflag1=$searchflag1&&searchcat=$searchcat&&searchgen=$searchgen&&pharmacytype=$pharmacytype\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lastpage</a>";
																		}
																		//close to end; only hide early pages
																		else {
																			$pagination .= "<a href=\"$targetpage?page=1&&search1=$search1&&searchflag1=$searchflag1&&searchcat=$searchcat&&searchgen=$searchgen&&pharmacytype=$pharmacytype\" style='margin:0 0 0 2px; color:#3b3b3c;'>1</a>";
																			$pagination .= "<a href=\"$targetpage?page=2&&search1=$search1&&searchflag1=$searchflag1&&searchcat=$searchcat&&searchgen=$searchgen&&pharmacytype=$pharmacytype\" style='margin:0 0 0 2px; color:#3b3b3c;'>2</a>";
																			$pagination .= "...";
																			for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
																				if ($counter == $page)
																					$pagination .= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
																				else
																					$pagination .= "<a href=\"$targetpage?page=$counter&&search1=$search1&&searchflag1=$searchflag1&&searchcat=$searchcat&&searchgen=$searchgen&&pharmacytype=$pharmacytype\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";
																			}
																		}
																	}

																	//next button
																	if ($page < $counter - 1)
																		$pagination .= "<a href=\"$targetpage?page=$next&&search1=$search1&&searchflag1=$searchflag1&&searchcat=$searchcat&&searchgen=$searchgen&&pharmacytype=$pharmacytype\" style='margin:0 0 0 2px; color:#3b3b3c;'>next</a>";
																	else
																		$pagination .= "<span class=\"disabled\" style='margin:0 0 0 2px; color:#3b3b3c;'>next</span>";
																	echo $pagination .= "</div>\n";
																}
															}
															?>
													</td>
												</tr>
            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="section-header">
                    <i class="fas fa-search"></i>
                    <h3>Search Pharmacy Items</h3>
                </div>
                
                <form method="get" action="pharmacyitem1.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="search1" class="form-label">Search by Item</label>
                            <input name="search1" type="text" id="search1" class="form-input" 
                                   value="<?php echo $search1; ?>" placeholder="Search by item name" autocomplete="off">
                        </div>
                        
                        <div class="form-group">
                            <label for="searchcat" class="form-label">Search by Category</label>
                            <input name="searchcat" type="text" id="searchcat" class="form-input" 
                                   value="<?php echo $searchcat; ?>" placeholder="Search by category" autocomplete="off">
                        </div>
                        
                        <div class="form-group">
                            <label for="searchgen" class="form-label">Search by Generic</label>
                            <input name="searchgen" type="text" id="searchgen" class="form-input" 
                                   value="<?php echo $searchgen; ?>" placeholder="Search by generic name" autocomplete="off">
                        </div>
                        
                        <div class="form-group">
                            <label for="pharmacytype" class="form-label">Type</label>
                            <select name="pharmacytype" id="pharmacytype" class="form-select">
                                <option value="">Select by Type</option>
                                <option value="DRUGS" <?php if ($pharmacytype == 'DRUGS') { echo 'selected'; } ?>>DRUGS</option>
                                <option value="NON DRUGS" <?php if ($pharmacytype == 'NON DRUGS') { echo 'selected'; } ?>>NON DRUGS</option>
                                <option value="ASSETS" <?php if ($pharmacytype == 'ASSETS') { echo 'selected'; } ?>>ASSETS</option>
                            </select>
                        </div>
                        
                        <div class="form-group form-group-submit">
                            <input type="hidden" name="searchflag1" id="searchflag1" value="searchflag1">
                            <input type="hidden" id="sortfunc" name="sortfunc" value="">
                            <input type="hidden" id="start" value="<?php echo $start ?>">
                            <input type="hidden" id="limit" value="<?php echo $limit ?>">
                            <button type="submit" name="Submit2" class="submit-btn">
                                <i class="fas fa-search"></i>
                                Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Pagination Info Section -->
            <?php if (isset($pagination) && !empty($pagination)): ?>
            <div class="pagination-info-section">
                <div class="pagination-stats">
                    <div class="stats-info">
                        <i class="fas fa-info-circle"></i>
                        <span>Showing page <?php echo $page; ?> of <?php echo $lastpage; ?> (Total: <?php echo $total_pages; ?> items)</span>
                    </div>
                    <div class="records-per-page">
                        <label for="recordsPerPage">Records per page:</label>
                        <select id="recordsPerPage" onchange="changeRecordsPerPage(this.value)">
                            <option value="10" <?php echo $limit == 10 ? 'selected' : ''; ?>>10</option>
                            <option value="25" <?php echo $limit == 25 ? 'selected' : ''; ?>>25</option>
                            <option value="50" <?php echo $limit == 50 ? 'selected' : ''; ?>>50</option>
                            <option value="100" <?php echo $limit == 100 ? 'selected' : ''; ?>>100</option>
                            <option value="200" <?php echo $limit == 200 ? 'selected' : ''; ?>>200</option>
                        </select>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Data Table Section -->
            <div class="data-table-section">
                <div class="section-header">
                    <i class="fas fa-list"></i>
                    <h3>Pharmacy Items List</h3>
                </div>
                
                <!-- Table Container -->
                <div class="table-container">
                    <table class="pharmacy-table">
                        <thead>
                            <tr>
                                <th class="action-header">Delete</th>
                                <th class="action-header">Edit</th>
                                <th class="id-header">ID / Code</th>
                                <th class="sortable-header" id="category" style="cursor:pointer">
                                    Category
                                    <span class="sort-arrows">
                                        <i class="fas fa-sort-down" id='categoryup'></i>
                                        <i class="fas fa-sort-up" id='categorydown'></i>
                                    </span>
                                </th>
                                <th class="sortable-header" id="pharmacyitem" style="cursor:pointer">
                                    Pharmacy Item
                                    <span class="sort-arrows">
                                        <i class="fas fa-sort-down" id='pharmacyitemup'></i>
                                        <i class="fas fa-sort-up" id='pharmacyitemdown'></i>
                                    </span>
                                </th>
                                <th class="unit-header">Unit</th>
                                <th class="charges-header">Charges</th>
                                <th class="formula-header">Formula</th>
                                <th class="tax-header">Tax</th>
                                <th class="cost-header">Cost Price</th>
                                <th class="disease-header">Disease</th>
                                <th class="sortable-header" id="generic" style="cursor:pointer">
                                    Generic
                                    <span class="sort-arrows">
                                        <i class="fas fa-sort-down" id='genericup'></i>
                                        <i class="fas fa-sort-up" id='genericdown'></i>
                                    </span>
                                </th>
                                <th class="sortable-header" id="phtype" style="cursor:pointer">
                                    Type
                                    <span class="sort-arrows">
                                        <i class="fas fa-sort-down" id='phtypeup'></i>
                                        <i class="fas fa-sort-up" id='phtypedown'></i>
                                    </span>
                                </th>
                                <th class="stock-header">Min Stock</th>
                                <th class="stock-header">Max Stock</th>
                                <th class="rol-header">ROL</th>
                                <th class="strength-header">Strength</th>
                                <th class="markup-header">IP Markup</th>
                                <th class="markup-header">SP Markup</th>
                            </tr>
                        </thead>
                        
                        <!-- Loading Overlay -->
                        <div id="wait" class="loading-overlay" style="display:none;">
                            <div class="loading-content">
                                <div class="loading-spinner">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </div>
                                <p><strong>Loading...</strong></p>
                            </div>
                        </div>
                        
                        <tbody id="activepharmacylist">
													<?php
													if ($searchflag1 == 'searchflag1') {

														$search1 = $_REQUEST["search1"];
														if ($pharmacytype == '') {
															$typecondtion = "AND type LIKE '%$pharmacytype%'";
														} else {
															$typecondtion = "AND type = '$pharmacytype'";
														}
														$query1 = "select * from master_medicine where   (itemname like '%$search1%' AND categoryname like '%$searchcat%' AND genericname like '%$searchgen%'  $typecondtion) and  status <> 'deleted' order by itemcode asc LIMIT $start, $limit";
														$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
														while ($res1 = mysqli_fetch_array($exec1)) {
															$itemcode = $res1["itemcode"];
															$itemname = $res1["itemname"];
															$categoryname = $res1["categoryname"];
															$purchaseprice = $res1["purchaseprice"];
															$rateperunit = $res1["rateperunit"];
															$expiryperiod = $res1["expiryperiod"];
															$auto_number = $res1["auto_number"];
															$itemname_abbreviation = $res1["packagename"];
															$taxname = $res1["taxname"];
															$manufacturername = $res1["manufacturername"];
															$formula = $res1['formula'];
															$genericname = $res1["genericname"];
															$minimumstock = $res1["minimumstock"];
															$maximumstock = $res1["maximumstock"];
															$rol = $res1["rol"];
															$roq = $res1["roq"];
															$type = $res1["type"];
															$ipmarkup = $res1["ipmarkup"];
															$spmarkup = $res1["spmarkup"];
															$disease = $res1["disease"];

															$taxanum = $res1["taxanum"];
															if ($expiryperiod != '0') {
																$expiryperiod = $expiryperiod . ' Months';
															} else {
																$expiryperiod = '';
															}
															/*?>	
		$query6 = "select * from master_tax where auto_number = '$taxanum'";
		$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		$res6 = mysql_fetch_array($exec6);
		$res6taxpercent = $res6["taxpercent"];<?php */

															$colorloopcount = $colorloopcount + 1;
															$showcolor = ($colorloopcount & 1);
															if ($showcolor == 0) {
																$colorcode = 'bgcolor="#CBDBFA"';
															} else {
																$colorcode = 'bgcolor="#ecf0f5"';
															}

													?>
                            <tr class="table-row">
                                <td class="action-cell">
                                    <button class="btn-action btn-delete" onclick="deleteItem('<?php echo $auto_number; ?>')" title="Delete Item">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                                <td class="action-cell">
                                    <a href="editpharmacyitem.php?itemcode=<?php echo $itemcode; ?>" class="btn-action btn-edit" title="Edit Item">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                                <td class="id-cell"><?php echo htmlspecialchars($itemcode); ?></td>
                                <td class="category-cell"><?php echo htmlspecialchars($categoryname); ?></td>
                                <td class="item-cell"><?php echo htmlspecialchars($itemname); ?></td>
                                <td class="unit-cell"><?php echo htmlspecialchars($itemname_abbreviation); ?></td>
                                <td class="charges-cell"><?php echo number_format($rateperunit, 2); ?></td>
                                <td class="formula-cell"><?php echo htmlspecialchars($formula); ?></td>
                                <td class="tax-cell"><?php echo htmlspecialchars($taxname); ?></td>
                                <td class="cost-cell"><?php echo number_format($purchaseprice, 2); ?></td>
                                <td class="disease-cell"><?php echo htmlspecialchars($disease); ?></td>
                                <td class="generic-cell"><?php echo htmlspecialchars($genericname); ?></td>
                                <td class="type-cell"><?php echo htmlspecialchars($type); ?></td>
                                <td class="stock-cell"><?php echo $minimumstock; ?></td>
                                <td class="stock-cell"><?php echo $maximumstock; ?></td>
                                <td class="rol-cell"><?php echo $rol; ?></td>
                                <td class="strength-cell"><?php echo $roq; ?></td>
                                <td class="markup-cell"><?php echo number_format($ipmarkup, 2); ?></td>
                                <td class="markup-cell"><?php echo number_format($spmarkup, 2); ?></td>
                            </tr>
														<?php
														}
													} else {
														?>

														<?php
														$query1 = "select * from master_medicine where  status <> 'deleted' order by auto_number asc LIMIT $start, $limit";
														$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
														while ($res1 = mysqli_fetch_array($exec1)) {
															$itemcode = $res1["itemcode"];
															$itemname = $res1["itemname"];
															$categoryname = $res1["categoryname"];
															$purchaseprice = $res1["purchaseprice"];
															$rateperunit = $res1["rateperunit"];
															$expiryperiod = $res1["expiryperiod"];
															$auto_number = $res1["auto_number"];
															$itemname_abbreviation = $res1["packagename"];
															$taxname = $res1["taxname"];
															$manufacturername = $res1["manufacturername"];
															$formula = $res1['formula'];
															$genericname = $res1["genericname"];
															$minimumstock = $res1["minimumstock"];
															$maximumstock = $res1["maximumstock"];
															$rol = $res1["rol"];
															$roq = $res1["roq"];
															$type = $res1["type"];
															$ipmarkup = $res1["ipmarkup"];
															$spmarkup = $res1["spmarkup"];
															$disease = $res1["disease"];
															$taxanum = $res1["taxanum"];
															if ($expiryperiod != '0') {
																$expiryperiod = $expiryperiod . ' Months';
															} else {
																$expiryperiod = '';
															}

															/*?>$query6 = "select * from master_tax where auto_number = '$taxanum'";
		$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		$res6 = mysql_fetch_array($exec6);
		$res6taxpercent = $res6["taxpercent"];<?php */

															$colorloopcount = $colorloopcount + 1;
															$showcolor = ($colorloopcount & 1);
															if ($showcolor == 0) {
																$colorcode = 'bgcolor="#CBDBFA"';
															} else {
																$colorcode = 'bgcolor="#ecf0f5"';
															}

														?>
                            <tr class="table-row">
                                <td class="action-cell">
                                    <button class="btn-action btn-delete" onclick="deleteItem('<?php echo $auto_number; ?>')" title="Delete Item">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                                <td class="action-cell">
                                    <a href="editpharmacyitem.php?itemcode=<?php echo $itemcode; ?>" class="btn-action btn-edit" title="Edit Item">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                                <td class="id-cell"><?php echo htmlspecialchars($itemcode); ?></td>
                                <td class="category-cell"><?php echo htmlspecialchars($categoryname); ?></td>
                                <td class="item-cell"><?php echo htmlspecialchars($itemname); ?></td>
                                <td class="unit-cell"><?php echo htmlspecialchars($itemname_abbreviation); ?></td>
                                <td class="charges-cell"><?php echo number_format($rateperunit, 2); ?></td>
                                <td class="formula-cell"><?php echo htmlspecialchars($formula); ?></td>
                                <td class="tax-cell"><?php echo htmlspecialchars($taxname); ?></td>
                                <td class="cost-cell"><?php echo number_format($purchaseprice, 2); ?></td>
                                <td class="disease-cell"><?php echo htmlspecialchars($disease); ?></td>
                                <td class="generic-cell"><?php echo htmlspecialchars($genericname); ?></td>
                                <td class="type-cell"><?php echo htmlspecialchars($type); ?></td>
                                <td class="stock-cell"><?php echo $minimumstock; ?></td>
                                <td class="stock-cell"><?php echo $maximumstock; ?></td>
                                <td class="rol-cell"><?php echo $rol; ?></td>
                                <td class="strength-cell"><?php echo $roq; ?></td>
                                <td class="markup-cell"><?php echo number_format($ipmarkup, 2); ?></td>
                                <td class="markup-cell"><?php echo number_format($spmarkup, 2); ?></td>
                            </tr>


                            <?php
                            }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Modern Pagination Controls -->
                <?php if (isset($pagination) && !empty($pagination)): ?>
                <div class="pagination-controls">
                    <div class="pagination-info">
                        <span class="pagination-text">
                            Showing <?php echo ($start + 1); ?> to <?php echo min($start + $limit, $total_pages); ?> of <?php echo $total_pages; ?> entries
                        </span>
                    </div>
                    
                    <div class="pagination-nav">
                        <?php if ($page > 1): ?>
                            <a href="<?php echo $targetpage; ?>?page=1<?php echo isset($search1) ? '&search1=' . urlencode($search1) : ''; ?><?php echo isset($searchflag1) ? '&searchflag1=' . urlencode($searchflag1) : ''; ?><?php echo isset($searchcat) ? '&searchcat=' . urlencode($searchcat) : ''; ?><?php echo isset($searchgen) ? '&searchgen=' . urlencode($searchgen) : ''; ?><?php echo isset($pharmacytype) ? '&pharmacytype=' . urlencode($pharmacytype) : ''; ?>&limit=<?php echo $limit; ?>" class="pagination-btn pagination-btn-first">
                                <i class="fas fa-angle-double-left"></i>
                                First
                            </a>
                            <a href="<?php echo $targetpage; ?>?page=<?php echo $prev; ?><?php echo isset($search1) ? '&search1=' . urlencode($search1) : ''; ?><?php echo isset($searchflag1) ? '&searchflag1=' . urlencode($searchflag1) : ''; ?><?php echo isset($searchcat) ? '&searchcat=' . urlencode($searchcat) : ''; ?><?php echo isset($searchgen) ? '&searchgen=' . urlencode($searchgen) : ''; ?><?php echo isset($pharmacytype) ? '&pharmacytype=' . urlencode($pharmacytype) : ''; ?>&limit=<?php echo $limit; ?>" class="pagination-btn pagination-btn-prev">
                                <i class="fas fa-angle-left"></i>
                                Previous
                            </a>
                        <?php else: ?>
                            <span class="pagination-btn pagination-btn-disabled">
                                <i class="fas fa-angle-double-left"></i>
                                First
                            </span>
                            <span class="pagination-btn pagination-btn-disabled">
                                <i class="fas fa-angle-left"></i>
                                Previous
                            </span>
                        <?php endif; ?>

                        <div class="pagination-pages">
                            <?php
                            // Show page numbers
                            $start_page = max(1, $page - 2);
                            $end_page = min($lastpage, $page + 2);
                            
                            if ($start_page > 1): ?>
                                <a href="<?php echo $targetpage; ?>?page=1<?php echo isset($search1) ? '&search1=' . urlencode($search1) : ''; ?><?php echo isset($searchflag1) ? '&searchflag1=' . urlencode($searchflag1) : ''; ?><?php echo isset($searchcat) ? '&searchcat=' . urlencode($searchcat) : ''; ?><?php echo isset($searchgen) ? '&searchgen=' . urlencode($searchgen) : ''; ?><?php echo isset($pharmacytype) ? '&pharmacytype=' . urlencode($pharmacytype) : ''; ?>&limit=<?php echo $limit; ?>" class="pagination-number">1</a>
                                <?php if ($start_page > 2): ?>
                                    <span class="pagination-ellipsis">...</span>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                                <?php if ($i == $page): ?>
                                    <span class="pagination-number pagination-number-active"><?php echo $i; ?></span>
                                <?php else: ?>
                                    <a href="<?php echo $targetpage; ?>?page=<?php echo $i; ?><?php echo isset($search1) ? '&search1=' . urlencode($search1) : ''; ?><?php echo isset($searchflag1) ? '&searchflag1=' . urlencode($searchflag1) : ''; ?><?php echo isset($searchcat) ? '&searchcat=' . urlencode($searchcat) : ''; ?><?php echo isset($searchgen) ? '&searchgen=' . urlencode($searchgen) : ''; ?><?php echo isset($pharmacytype) ? '&pharmacytype=' . urlencode($pharmacytype) : ''; ?>&limit=<?php echo $limit; ?>" class="pagination-number"><?php echo $i; ?></a>
                                <?php endif; ?>
                            <?php endfor; ?>

                            <?php if ($end_page < $lastpage): ?>
                                <?php if ($end_page < $lastpage - 1): ?>
                                    <span class="pagination-ellipsis">...</span>
                                <?php endif; ?>
                                <a href="<?php echo $targetpage; ?>?page=<?php echo $lastpage; ?><?php echo isset($search1) ? '&search1=' . urlencode($search1) : ''; ?><?php echo isset($searchflag1) ? '&searchflag1=' . urlencode($searchflag1) : ''; ?><?php echo isset($searchcat) ? '&searchcat=' . urlencode($searchcat) : ''; ?><?php echo isset($searchgen) ? '&searchgen=' . urlencode($searchgen) : ''; ?><?php echo isset($pharmacytype) ? '&pharmacytype=' . urlencode($pharmacytype) : ''; ?>&limit=<?php echo $limit; ?>" class="pagination-number"><?php echo $lastpage; ?></a>
                            <?php endif; ?>
                        </div>

                        <?php if ($page < $lastpage): ?>
                            <a href="<?php echo $targetpage; ?>?page=<?php echo $next; ?><?php echo isset($search1) ? '&search1=' . urlencode($search1) : ''; ?><?php echo isset($searchflag1) ? '&searchflag1=' . urlencode($searchflag1) : ''; ?><?php echo isset($searchcat) ? '&searchcat=' . urlencode($searchcat) : ''; ?><?php echo isset($searchgen) ? '&searchgen=' . urlencode($searchgen) : ''; ?><?php echo isset($pharmacytype) ? '&pharmacytype=' . urlencode($pharmacytype) : ''; ?>&limit=<?php echo $limit; ?>" class="pagination-btn pagination-btn-next">
                                Next
                                <i class="fas fa-angle-right"></i>
                            </a>
                            <a href="<?php echo $targetpage; ?>?page=<?php echo $lastpage; ?><?php echo isset($search1) ? '&search1=' . urlencode($search1) : ''; ?><?php echo isset($searchflag1) ? '&searchflag1=' . urlencode($searchflag1) : ''; ?><?php echo isset($searchcat) ? '&searchcat=' . urlencode($searchcat) : ''; ?><?php echo isset($searchgen) ? '&searchgen=' . urlencode($searchgen) : ''; ?><?php echo isset($pharmacytype) ? '&pharmacytype=' . urlencode($pharmacytype) : ''; ?>&limit=<?php echo $limit; ?>" class="pagination-btn pagination-btn-last">
                                Last
                                <i class="fas fa-angle-double-right"></i>
                            </a>
                        <?php else: ?>
                            <span class="pagination-btn pagination-btn-disabled">
                                Next
                                <i class="fas fa-angle-right"></i>
                            </span>
                            <span class="pagination-btn pagination-btn-disabled">
                                Last
                                <i class="fas fa-angle-double-right"></i>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <!-- Deleted Items Section -->
            <div class="deleted-items-section">
                <div class="section-header">
                    <i class="fas fa-trash-alt"></i>
                    <h3>Deleted Pharmacy Items</h3>
                </div>
                
                <form method="get" action="pharmacyitem1.php" class="deleted-search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="search2" class="form-label">Search Deleted Items</label>
                            <input name="search2" type="text" id="search2" class="form-input" 
                                   value="<?php echo $search2; ?>" placeholder="Search deleted items..." autocomplete="off">
                            <input type="hidden" name="searchflag2" id="searchflag2" value="searchflag2">
                        </div>
                        
                        <div class="form-group form-group-submit">
                            <button type="submit" name="Submit22" class="submit-btn">
                                <i class="fas fa-search"></i>
                                Search Deleted
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Deleted Items Pagination Info -->
                <?php if (isset($deleted_total_pages) && $deleted_total_pages > 0): ?>
                <div class="pagination-info-section">
                    <div class="pagination-stats">
                        <div class="stats-info">
                            <i class="fas fa-info-circle"></i>
                            <span>Showing page <?php echo $deleted_page; ?> of <?php echo ceil($deleted_total_pages / $deleted_limit); ?> (Total: <?php echo $deleted_total_pages; ?> deleted items)</span>
                        </div>
                        <div class="records-per-page">
                            <label for="deletedRecordsPerPage">Records per page:</label>
                            <select id="deletedRecordsPerPage" onchange="changeDeletedRecordsPerPage(this.value)">
                                <option value="10" <?php echo $deleted_limit == 10 ? 'selected' : ''; ?>>10</option>
                                <option value="25" <?php echo $deleted_limit == 25 ? 'selected' : ''; ?>>25</option>
                                <option value="50" <?php echo $deleted_limit == 50 ? 'selected' : ''; ?>>50</option>
                                <option value="100" <?php echo $deleted_limit == 100 ? 'selected' : ''; ?>>100</option>
                            </select>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Deleted Items Table -->
                <div class="table-container">
                    <table class="deleted-table">
                        <thead>
                            <tr>
                                <th class="action-header">Activate</th>
                                <th class="id-header">ID / Code</th>
                                <th class="category-header">Category</th>
                                <th class="item-header">Pharmacy Item</th>
                                <th class="unit-header">Unit</th>
                                <th class="charges-header">Charges</th>
                                <th class="formula-header">Formula</th>
                                <th class="tax-header">Tax</th>
                                <th class="cost-header">Cost Price</th>
                                <th class="disease-header">Disease</th>
                                <th class="generic-header">Generic</th>
                                <th class="type-header">Type</th>
                                <th class="stock-header">Min Stock</th>
                                <th class="stock-header">Max Stock</th>
                                <th class="rol-header">ROL</th>
                                <th class="roq-header">ROQ</th>
                                <th class="markup-header">IP Markup</th>
                                <th class="markup-header">SP Markup</th>
                            </tr>
                        </thead>
                        <tbody>
													<tr bgcolor="#011E6A">
														<td width="4%" bgcolor="#ecf0f5" class="bodytext3">
															<div align="center"><strong>Activate</strong></div>
														</td>
														<td width="5%" bgcolor="#ecf0f5" class="bodytext3"><strong>ID / Code </strong></td>
														<td width="5%" bgcolor="#ecf0f5" class="bodytext3">
															<div align="left" style="pointer: cursor"><strong>Category</strong></div>
														</td>
														<td width="8%" bgcolor="#ecf0f5" class="bodytext3"><strong>Pharmacy Item</strong></td>
														<td width="5%" bgcolor="#ecf0f5" class="bodytext3"><strong>Unit</strong>
															<div align="center"><strong>
																	<!--Purchase-->
																</strong></div>
														</td>
														<td width="7%" bgcolor="#ecf0f5" class="bodytext3">
															<div align="center"><strong>Charges</strong></div>
														</td>
														<td width="11%" bgcolor="#ecf0f5" class="bodytext3">
															<div align="center"><strong>Formula</strong></div>
														</td>
														<td width="5%" bgcolor="#ecf0f5" class="bodytext3">
															<div align="center"><strong>Tax</strong></div>
														</td>
														<td width="6%" bgcolor="#ecf0f5" class="bodytext3">
															<div align="center"><strong>Cost price</strong></div>
														</td>
														<td width="7%" bgcolor="#ecf0f5" class="bodytext3">
															<div align="center"><strong>Disease</strong></div>
														</td>
														<td width="7%" bgcolor="#ecf0f5" class="bodytext3">
															<div align="center"><strong>Generic</strong></div>
														</td>
														<td width="7%" bgcolor="#ecf0f5" class="bodytext3">
															<div align="center"><strong>Type</strong></div>
														</td>
														<td width="6%" bgcolor="#ecf0f5" class="bodytext3">
															<div align="center"><strong>Min Stock</strong></div>
														</td>
														<td width="6%" bgcolor="#ecf0f5" class="bodytext3">
															<div align="center"><strong>Max Stock</strong></div>
														</td>
														<td width="6%" bgcolor="#ecf0f5" class="bodytext3">
															<div align="center"><strong>ROL</strong></div>
														</td>
														<td width="6%" bgcolor="#ecf0f5" class="bodytext3">
															<div align="center"><strong>ROQ</strong></div>
														</td>
														<td width="6%" bgcolor="#ecf0f5" class="bodytext3">
															<div align="center"><strong>IP Markup</strong></div>
														</td>
														<td width="7%" bgcolor="#ecf0f5" class="bodytext3">
															<div align="center"><strong>SP Markup</strong></div>
														</td>
													</tr>
													<?php
													if (isset($_REQUEST["searchflag2"])) {
														$searchflag2 = $_REQUEST["searchflag2"];
													} else {
														$searchflag2 = "";
													}
													// Deleted items pagination setup
													$deleted_limit = 10; // Records per page for deleted items
													if (isset($_REQUEST['deleted_page'])) {
														$deleted_page = $_REQUEST['deleted_page'];
													} else {
														$deleted_page = 1;
													}
													$deleted_start = ($deleted_page - 1) * $deleted_limit;
													
													if ($searchflag2 == 'searchflag2') {

														$search2 = $_REQUEST["search2"];
														// Get total count for deleted items with search
														$count_query = "select count(*) as total from master_medicine where ( itemname like '%$search2%' or categoryname = '$search2') and status = 'deleted'";
														$count_exec = mysqli_query($GLOBALS["___mysqli_ston"], $count_query) or die("Error in count query" . mysqli_error($GLOBALS["___mysqli_ston"]));
														$count_res = mysqli_fetch_array($count_exec);
														$deleted_total_pages = $count_res['total'];
														
														$query1 = "select * from master_medicine where   ( itemname like '%$search2%' or categoryname = '$search2') and status = 'deleted' order by auto_number asc LIMIT $deleted_start, $deleted_limit";
														$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
														while ($res1 = mysqli_fetch_array($exec1)) {
															$itemcode = $res1["itemcode"];
															$itemname = $res1["itemname"];
															$categoryname = $res1["categoryname"];
															$purchaseprice = $res1["purchaseprice"];
															$rateperunit = $res1["rateperunit"];
															$expiryperiod = $res1["expiryperiod"];
															$auto_number = $res1["auto_number"];
															$itemname_abbreviation = $res1["packagename"];
															$taxname = $res1["taxname"];
															$manufacturername = $res1["manufacturername"];
															$formula = $res1['formula'];
															$genericname = $res1["genericname"];
															$minimumstock = $res1["minimumstock"];
															$maximumstock = $res1["maximumstock"];
															$rol = $res1["rol"];
															$roq = $res1["roq"];
															$type = $res1["type"];
															$ipmarkup = $res1["ipmarkup"];
															$spmarkup = $res1["spmarkup"];
															$disease = $res1["disease"];


															$taxanum = $res1["taxanum"];
															if ($expiryperiod != '0') {
																$expiryperiod = $expiryperiod . ' Months';
															} else {
																$expiryperiod = '';
															}

															$query6 = "select * from master_tax where auto_number = '$taxanum'";
															$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die("Error in Query6" . mysqli_error($GLOBALS["___mysqli_ston"]));
															$res6 = mysqli_fetch_array($exec6);
															$res6taxpercent = $res6["taxpercent"];

															$colorloopcount = $colorloopcount + 1;
															$showcolor = ($colorloopcount & 1);
															if ($showcolor == 0) {
																$colorcode = 'bgcolor="#CBDBFA"';
															} else {
																$colorcode = 'bgcolor="#ecf0f5"';
															}

													?>
                            <tr class="table-row deleted-row">
                                <td class="action-cell">
                                    <button class="btn-action btn-activate" onclick="activateItem('<?php echo $auto_number; ?>')" title="Activate Item">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                </td>
                                <td class="id-cell"><?php echo htmlspecialchars($itemcode); ?></td>
                                <td class="category-cell"><?php echo htmlspecialchars($categoryname); ?></td>
                                <td class="item-cell"><?php echo htmlspecialchars($itemname); ?></td>
                                <td class="unit-cell"><?php echo htmlspecialchars($itemname_abbreviation); ?></td>
                                <td class="charges-cell"><?php echo number_format($rateperunit, 2); ?></td>
                                <td class="formula-cell"><?php echo htmlspecialchars($formula); ?></td>
                                <td class="tax-cell"><?php echo htmlspecialchars($taxname); ?></td>
                                <td class="cost-cell"><?php echo number_format($purchaseprice, 2); ?></td>
                                <td class="disease-cell"><?php echo htmlspecialchars($disease); ?></td>
                                <td class="generic-cell"><?php echo htmlspecialchars($genericname); ?></td>
                                <td class="type-cell"><?php echo htmlspecialchars($type); ?></td>
                                <td class="stock-cell"><?php echo $minimumstock; ?></td>
                                <td class="stock-cell"><?php echo $maximumstock; ?></td>
                                <td class="rol-cell"><?php echo $rol; ?></td>
                                <td class="roq-cell"><?php echo $roq; ?></td>
                                <td class="markup-cell"><?php echo number_format($ipmarkup, 2); ?></td>
                                <td class="markup-cell"><?php echo number_format($spmarkup, 2); ?></td>
                            </tr>


														<?php
														}
													} else {
														// Get total count for all deleted items
														$count_query = "select count(*) as total from master_medicine where status = 'deleted'";
														$count_exec = mysqli_query($GLOBALS["___mysqli_ston"], $count_query) or die("Error in count query" . mysqli_error($GLOBALS["___mysqli_ston"]));
														$count_res = mysqli_fetch_array($count_exec);
														$deleted_total_pages = $count_res['total'];

														$query1 = "select * from master_medicine where   status = 'deleted' order by auto_number asc LIMIT $deleted_start, $deleted_limit";
														$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
														while ($res1 = mysqli_fetch_array($exec1)) {
															$itemcode = $res1["itemcode"];
															$itemname = $res1["itemname"];
															$categoryname = $res1["categoryname"];
															$purchaseprice = $res1["purchaseprice"];
															$rateperunit = $res1["rateperunit"];

															$expiryperiod = $res1["expiryperiod"];
															$auto_number = $res1["auto_number"];
															$itemname_abbreviation = $res1["packagename"];
															$taxname = $res1["taxname"];
															$manufacturername = $res1["manufacturername"];
															$formula = $res1['formula'];
															$genericname = $res1["genericname"];
															$minimumstock = $res1["minimumstock"];
															$maximumstock = $res1["maximumstock"];
															$rol = $res1["rol"];
															$roq = $res1["roq"];
															$type = $res1["type"];
															$ipmarkup = $res1["ipmarkup"];
															$spmarkup = $res1["spmarkup"];
															$disease = $res1["disease"];

															$taxanum = $res1["taxanum"];
															if ($expiryperiod != '0') {
																$expiryperiod = $expiryperiod . ' Months';
															} else {
																$expiryperiod = '';
															}

															/*<?php ?>$query6 = "select * from master_tax where auto_number = '$taxanum'";
		$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		$res6 = mysql_fetch_array($exec6);
		$res6taxpercent = $res6["taxpercent"];
		<?php ?>*/
															$colorloopcount = $colorloopcount + 1;
															$showcolor = ($colorloopcount & 1);
															if ($showcolor == 0) {
																$colorcode = 'bgcolor="#CBDBFA"';
															} else {
																$colorcode = 'bgcolor="#ecf0f5"';
															}

														?>
                            <tr class="table-row deleted-row">
                                <td class="action-cell">
                                    <button class="btn-action btn-activate" onclick="activateItem('<?php echo $auto_number; ?>')" title="Activate Item">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                </td>
                                <td class="id-cell"><?php echo htmlspecialchars($itemcode); ?></td>
                                <td class="category-cell"><?php echo htmlspecialchars($categoryname); ?></td>
                                <td class="item-cell"><?php echo htmlspecialchars($itemname); ?></td>
                                <td class="unit-cell"><?php echo htmlspecialchars($itemname_abbreviation); ?></td>
                                <td class="charges-cell"><?php echo number_format($rateperunit, 2); ?></td>
                                <td class="formula-cell"><?php echo htmlspecialchars($formula); ?></td>
                                <td class="tax-cell"><?php echo htmlspecialchars($taxname); ?></td>
                                <td class="cost-cell"><?php echo number_format($purchaseprice, 2); ?></td>
                                <td class="disease-cell"><?php echo htmlspecialchars($disease); ?></td>
                                <td class="generic-cell"><?php echo htmlspecialchars($genericname); ?></td>
                                <td class="type-cell"><?php echo htmlspecialchars($type); ?></td>
                                <td class="stock-cell"><?php echo $minimumstock; ?></td>
                                <td class="stock-cell"><?php echo $maximumstock; ?></td>
                                <td class="rol-cell"><?php echo $rol; ?></td>
                                <td class="roq-cell"><?php echo $roq; ?></td>
                                <td class="markup-cell"><?php echo number_format($ipmarkup, 2); ?></td>
                                <td class="markup-cell"><?php echo number_format($spmarkup, 2); ?></td>
                            </tr>


													<?php
														}
													}
													?>
                        </tbody>
                    </table>
                </div>

                <!-- Deleted Items Pagination Controls -->
                <?php if (isset($deleted_total_pages) && $deleted_total_pages > 0): ?>
                <?php
                $deleted_lastpage = ceil($deleted_total_pages / $deleted_limit);
                $deleted_prev = $deleted_page - 1;
                $deleted_next = $deleted_page + 1;
                ?>
                <div class="pagination-controls">
                    <div class="pagination-info">
                        <span class="pagination-text">
                            Showing <?php echo ($deleted_start + 1); ?> to <?php echo min($deleted_start + $deleted_limit, $deleted_total_pages); ?> of <?php echo $deleted_total_pages; ?> deleted entries
                        </span>
                    </div>
                    
                    <div class="pagination-nav">
                        <?php if ($deleted_page > 1): ?>
                            <a href="<?php echo $targetpage; ?>?deleted_page=1<?php echo isset($search2) ? '&search2=' . urlencode($search2) : ''; ?><?php echo isset($searchflag2) ? '&searchflag2=' . urlencode($searchflag2) : ''; ?>&deleted_limit=<?php echo $deleted_limit; ?>" class="pagination-btn pagination-btn-first">
                                <i class="fas fa-angle-double-left"></i>
                                First
                            </a>
                            <a href="<?php echo $targetpage; ?>?deleted_page=<?php echo $deleted_prev; ?><?php echo isset($search2) ? '&search2=' . urlencode($search2) : ''; ?><?php echo isset($searchflag2) ? '&searchflag2=' . urlencode($searchflag2) : ''; ?>&deleted_limit=<?php echo $deleted_limit; ?>" class="pagination-btn pagination-btn-prev">
                                <i class="fas fa-angle-left"></i>
                                Previous
                            </a>
                        <?php else: ?>
                            <span class="pagination-btn pagination-btn-disabled">
                                <i class="fas fa-angle-double-left"></i>
                                First
                            </span>
                            <span class="pagination-btn pagination-btn-disabled">
                                <i class="fas fa-angle-left"></i>
                                Previous
                            </span>
                        <?php endif; ?>

                        <div class="pagination-pages">
                            <?php
                            // Show page numbers for deleted items
                            $deleted_start_page = max(1, $deleted_page - 2);
                            $deleted_end_page = min($deleted_lastpage, $deleted_page + 2);
                            
                            if ($deleted_start_page > 1): ?>
                                <a href="<?php echo $targetpage; ?>?deleted_page=1<?php echo isset($search2) ? '&search2=' . urlencode($search2) : ''; ?><?php echo isset($searchflag2) ? '&searchflag2=' . urlencode($searchflag2) : ''; ?>&deleted_limit=<?php echo $deleted_limit; ?>" class="pagination-number">1</a>
                                <?php if ($deleted_start_page > 2): ?>
                                    <span class="pagination-ellipsis">...</span>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php for ($i = $deleted_start_page; $i <= $deleted_end_page; $i++): ?>
                                <?php if ($i == $deleted_page): ?>
                                    <span class="pagination-number pagination-number-active"><?php echo $i; ?></span>
                                <?php else: ?>
                                    <a href="<?php echo $targetpage; ?>?deleted_page=<?php echo $i; ?><?php echo isset($search2) ? '&search2=' . urlencode($search2) : ''; ?><?php echo isset($searchflag2) ? '&searchflag2=' . urlencode($searchflag2) : ''; ?>&deleted_limit=<?php echo $deleted_limit; ?>" class="pagination-number"><?php echo $i; ?></a>
                                <?php endif; ?>
                            <?php endfor; ?>

                            <?php if ($deleted_end_page < $deleted_lastpage): ?>
                                <?php if ($deleted_end_page < $deleted_lastpage - 1): ?>
                                    <span class="pagination-ellipsis">...</span>
                                <?php endif; ?>
                                <a href="<?php echo $targetpage; ?>?deleted_page=<?php echo $deleted_lastpage; ?><?php echo isset($search2) ? '&search2=' . urlencode($search2) : ''; ?><?php echo isset($searchflag2) ? '&searchflag2=' . urlencode($searchflag2) : ''; ?>&deleted_limit=<?php echo $deleted_limit; ?>" class="pagination-number"><?php echo $deleted_lastpage; ?></a>
                            <?php endif; ?>
                        </div>

                        <?php if ($deleted_page < $deleted_lastpage): ?>
                            <a href="<?php echo $targetpage; ?>?deleted_page=<?php echo $deleted_next; ?><?php echo isset($search2) ? '&search2=' . urlencode($search2) : ''; ?><?php echo isset($searchflag2) ? '&searchflag2=' . urlencode($searchflag2) : ''; ?>&deleted_limit=<?php echo $deleted_limit; ?>" class="pagination-btn pagination-btn-next">
                                Next
                                <i class="fas fa-angle-right"></i>
                            </a>
                            <a href="<?php echo $targetpage; ?>?deleted_page=<?php echo $deleted_lastpage; ?><?php echo isset($search2) ? '&search2=' . urlencode($search2) : ''; ?><?php echo isset($searchflag2) ? '&searchflag2=' . urlencode($searchflag2) : ''; ?>&deleted_limit=<?php echo $deleted_limit; ?>" class="pagination-btn pagination-btn-last">
                                Last
                                <i class="fas fa-angle-double-right"></i>
                            </a>
                        <?php else: ?>
                            <span class="pagination-btn pagination-btn-disabled">
                                Next
                                <i class="fas fa-angle-right"></i>
                            </span>
                            <span class="pagination-btn pagination-btn-disabled">
                                Last
                                <i class="fas fa-angle-double-right"></i>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table>
	</table>
	<?php include("includes/footer1.php"); ?>
</body>

</html>