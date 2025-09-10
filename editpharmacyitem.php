<?php
session_start();
include("includes/loginverify.php");
include("db/db_connect.php");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$docno = $_SESSION["docno"];
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$pkg = isset($_REQUEST['pkg']) ? $_REQUEST['pkg'] : 'no';

$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname limit 0,1";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1)) {
	$locationname = $res1["locationname"];
	$locationcode = $res1["locationcode"];
}

//to redirect if there is no entry in masters category or item.
$query90 = "select count(auto_number) as masterscount from master_medicine";
$exec90 = mysqli_query($GLOBALS["___mysqli_ston"], $query90) or die("Error in Query90" . mysqli_error($GLOBALS["___mysqli_ston"]));
$res90 = mysqli_fetch_array($exec90);
$res90count = $res90["masterscount"];
if ($res90count == 0) {
	header("location:addcategory1radiology.php?svccount=firstentry");
}


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
	$type = $_REQUEST['type'];
	$producttype = $_REQUEST['producttype'];

	$incomeledgername = $_REQUEST['saccountname'];
	$incomeledgerautonumber = $_REQUEST['saccountauto'];
	$incomeledgercode = $_REQUEST['saccountid'];

	$ledgername = $_REQUEST['iaccountname'];
	$ledgerautonumber = $_REQUEST['iaccountauto'];
	$ledgercode = $_REQUEST['iaccountid'];

	$inventoryledgername = $_REQUEST['inv_accountname'];
	$inventoryledgerautonumber = $_REQUEST['inv_accountauto'];
	$inventoryledgercode = $_REQUEST['inv_accountid'];

	$expenseledgername = $_REQUEST['exp_accountname'];
	$expenseledgerautonumber = $_REQUEST['exp_accountauto'];
	$expenseledgercode = $_REQUEST['exp_accountid'];

	$drug_instructions = $_REQUEST['drug_instructions'];
	$dose_measure = $_REQUEST['dose_measure'];


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
	$formula = $_REQUEST['formula'];
	$transfertype = $_REQUEST["transfertype"];
	$nature = $_REQUEST["nature"];
	if ($length1 < 25 && $length2 < 255) {

		$numberOfItemsQuery =
			"select itemname, itemcode from master_medicine where itemname = '" . $itemname . "'";
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


		$res4packagename = $itemname_abbreviation;

		$query10 = "select purchaseprice,markup from master_medicine where itemcode='" . $itemcode . "'";
		$exec10  = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die("error in query10" . mysqli_error($GLOBALS["___mysqli_ston"]));
		$res10   = mysqli_fetch_array($exec10);
		$prev_markup = $res10["markup"];

		/*$query54 = "select * from master_manufacturerpharmacy where auto_number = '$manufacturername'";// and cstid='$custid' and cstname='$custname'";
		$exec54 = mysql_query($query54) or die ("Error in Query4".mysql_error());
		$res54 = mysql_fetch_array($exec54);
		$res4manufacturername = $res54["manufacturername"];*/

		//$ratecolumn = '_rateperunit';
		$query1 = "update master_medicine set itemcode='$itemcode', itemname='$itemname', categoryname='$categoryname', unitname_abbreviation='$res4packagename', packagename='$res4packagename',rateperunit='$rateperunit', expiryperiod='$expiryperiod',
			 taxanum='$taxanum', taxname='$res4taxname', ipaddress='$ipaddress', updatetime='$updatedatetime', description='$description', purchaseprice='$purchaseprice',genericname='$genericname',exclude='$exclude',minimumstock='$minimumstock',maximumstock='$maximumstock',rol='$rol',roq='$roq',ipmarkup='$ipmarkup',spmarkup='$spmarkup',formula='$formula',type='$type',producttypeid='$producttype',disease='$disease',pkg='" . $pkg . "',ledgername='$ledgername',ledgercode='$ledgercode',ledgerautonumber='$ledgerautonumber',`LTC-1_rateperunit`='$rateperunit',transfertype='$transfertype',nature='$nature',incomeledgercode = '$incomeledgercode', incomeledger = '$incomeledgername', inventoryledgercode = '$inventoryledgercode', inventoryledgername = '$inventoryledgername',expenseledgercode = '$expenseledgercode', expenseledgername = '$expenseledgername', drug_instructions='$drug_instructions',dose_measure='$dose_measure', username = '$username' , locationname = '$locationname' , locationcode = '$locationcode' where itemcode='$itemcode'";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));

		$fields = array();
		$queryChk = "SHOW COLUMNS FROM master_medicine";
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
		$query1 = "update master_medicine set $subtypedata where itemcode='$itemcode'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));


		//audit start

		$query1 = "insert into audit_master_medicine (itemcode, itemname, categoryname, unitname_abbreviation,packagename,rateperunit, expiryperiod, taxanum, taxname, ipaddress, updatetime, description, purchaseprice,pkg,genericname,exclude,minimumstock,maximumstock,rol,roq,ipmarkup,spmarkup,formula,disease,type,producttypeid,ledgername,ledgercode,ledgerautonumber,transfertype,nature,incomeledgercode,incomeledger,inventoryledgercode,inventoryledgername,expenseledgercode,expenseledgername,username,locationname,locationcode,auditstatus,from_table) 
			values ('$itemcode', '$itemname', '$categoryname', '$res4packagename','$res4packagename', '$rateperunit', '$expiryperiod', '$taxanum', '$res4taxname', '$ipaddress', '$updatedatetime','$description', '$purchaseprice','','$genericname','$exclude','$minimumstock','$maximumstock','$rol','$roq','$ipmarkup','$spmarkup','$formula','$disease','$type','$producttype','$ledgername','$ledgercode','$ledgerautonumber','$transfertype','$nature','$incomeledgercode','$incomeledgername','$inventoryledgercode','$inventoryledgername','$expenseledgercode','$expenseledgername','$username','$locationname','$locationcode','e','master_medicine')";
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
		$sql_pharma_rate1 = "SELECT * FROM audit_master_medicine WHERE  itemcode='$itemcode' order by  auto_number desc limit 0,1";
		$exec_pharma_rate1 = mysqli_query($GLOBALS["___mysqli_ston"], $sql_pharma_rate1) or die("Error in sql_pharma_rate1" . mysqli_error($GLOBALS["___mysqli_ston"]));
		$res_pharma_rate1 = mysqli_fetch_array($exec_pharma_rate1);
		$temp_id1 = $res_pharma_rate1['auto_number'];

		$query1 = "update audit_master_medicine set $subtypedata where itemcode='$itemcode' and auto_number='$temp_id1'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));


		//audit end 		





		$query2 = "update master_itempharmacy set itemcode='$itemcode', itemname='$itemname', categoryname='$categoryname', unitname_abbreviation='$res4packagename', packagename='$res4packagename', rateperunit='$rateperunit', expiryperiod='$expiryperiod',
			 taxanum='$taxanum', taxname='$res4taxname', ipaddress='$ipaddress', updatetime='$updatedatetime', description='$description', purchaseprice='$purchaseprice',genericname='$genericname',exclude='$exclude',type='$type',producttypeid='$producttype',
			 minimumstock='$minimumstock',maximumstock='$maximumstock',rol='$rol',roq='$roq',ipmarkup='$ipmarkup',spmarkup='$spmarkup',formula='$formula',disease='$disease',pkg='" . $pkg . "',ledgername='$ledgername',ledgercode='$ledgercode',ledgerautonumber='$ledgerautonumber',transfertype='$transfertype',nature='$nature',incomeledgercode = '$incomeledgercode', incomeledger = '$incomeledgername',inventoryledgercode = '$inventoryledgercode', inventoryledgername = '$inventoryledgername',expenseledgercode = '$expenseledgercode', expenseledgername = '$expenseledgername' where itemcode='$itemcode'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in Query2" . mysqli_error($GLOBALS["___mysqli_ston"]));

		// update pharmacy rate and subtypes

		// select pharmacy rate templates
		$sql_pharma_rate = "SELECT * FROM pharma_rate_template WHERE recordstatus <> 'deleted'";
		$exec_pharma_rate = mysqli_query($GLOBALS["___mysqli_ston"], $sql_pharma_rate) or die("Error in Query_pharma_rate" . mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res_pharma_rate = mysqli_fetch_array($exec_pharma_rate)) {
			$temp_id = $res_pharma_rate['auto_number'];

			if ($prev_markup > 0)
				$markup = $prev_markup;
			else
				$markup = $res_pharma_rate['markup'];

			$margin = $markup;
			$item_id = $itemcode;
			$item_price = (float)$purchaseprice;

			$var_price = (($margin / 100) * $item_price);
			$new_price = ($item_price + $var_price);

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

				$col .= 'subtype_' . $subtype . " = " . $new_price;
			}
			// update master med
			$sqlquery_st_med = "UPDATE master_medicine SET $col WHERE itemcode = '$item_id'";
			//echo $sqlquery_st_med.'<br>';
			$exequery_st_med = mysqli_query($GLOBALS["___mysqli_ston"], $sqlquery_st_med);

			$sqlquery_st_med1 = "UPDATE audit_master_medicine SET $col WHERE itemcode = '$item_id' and auto_number='$temp_id1'";
			//echo $sqlquery_st_med.'<br>';
			$exequery_st_med1 = mysqli_query($GLOBALS["___mysqli_ston"], $sqlquery_st_med1);
		}
/*
		<?php?>$query1 = "insert into master_renewal (itemcode, itemname, renewalmonths, ipaddress, updatetime) 
			values ('$itemcode', '$itemname', '0', '$ipaddress', '$updatedatetime')";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());<?php ?>*/

		$errmsg = "Success. pharmacy Item Updated.";
		$bgcolorcode = 'success';
		$itemcode = '';
		$itemname = '';
		$rateperunit  = '0.00';
		$purchaseprice  = '0.00';
		$description = '';
		$referencevalue = '';

		//$itemcode = '';



	} else {
		$errmsg = "Failed. pharmacy Item Code Should Be 25 Characters And Name Should Be 255 Characters.";
		$bgcolorcode = 'failed';
	}
	header("location:pharmacyitem1.php");
} else {
	$itemname = '';
	$rateperunit  = '0.00';
	$purchaseprice  = '0.00';
	$description = '';
	$referencevalue = '';
}

//$itemcode = '';




if (isset($_REQUEST["st"])) {
	$st = $_REQUEST["st"];
} else {
	$st = "";
}
if ($st == 'del') {
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_medicine set status = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query3" . mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'activate') {
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_medicine set status = '' where auto_number = '$delanum'";
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
if (isset($_REQUEST["search2"])) {
	$search2 = $_REQUEST["search2"];
} else {
	$search2 = "";
}


if (isset($_REQUEST["itemcode"])) {
	$itemcode = $_REQUEST["itemcode"];
} else {
	$itemcode = "";
}
$query65 = "select * from master_medicine where itemcode='$itemcode'";
$exec65 = mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res65 = mysqli_fetch_array($exec65);
$itemname = $res65["itemname"];
$categoryname = $res65["categoryname"];
$purchaseprice = $res65["purchaseprice"];
$rateperunit = $res65["rateperunit"];
$expiryperiod = $res65["expiryperiod"];
$auto_number = $res65["auto_number"];
$itemname_abbreviation = $res65["unitname_abbreviation"];
$taxname = $res65["taxname"];
//$manufacturername = $res65["manufacturername"];
$genericname = $res65["genericname"];
$minimumstock = $res65["minimumstock"];
$maximumstock = $res65["maximumstock"];
$rol = $res65["rol"];
$roq = $res65["roq"];
$pkg = $res65["pkg"];
$ipmarkup = $res65["ipmarkup"];
$spmarkup = $res65["spmarkup"];
$disease = $res65["disease"];
$formula1 = $res65['formula'];
$type = $res65['type'];
$producttype = $res65['producttypeid'];
$transfertype = $res65['transfertype'];
$nature = $res65['nature'];
$ledgername = $res65['ledgername'];
$ledgerautonumber = $res65['ledgerautonumber'];
$ledgercode = $res65['ledgercode'];
$incomeledger = $res65['incomeledger'];
$incomeledgercode = $res65['incomeledgercode'];
$inventoryledgername = $res65['inventoryledgername'];
$inventoryledgercode = $res65['inventoryledgercode'];
$expenseledgercode = $res65['expenseledgercode'];
$expenseledgername = $res65['expenseledgername'];
$drug_instructions = $res65['drug_instructions'];
$dose_measure = $res65['dose_measure'];

$query11 = "select * from master_tax where taxname='$taxname' and status <> 'deleted' order by taxname";
$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
$res11 = mysqli_fetch_array($exec11);

$res11taxpercent = $res11["taxpercent"];
$res11anum = $res11["auto_number"];




?>
<style type="text/css">
	<!--
	body {
		margin-left: 0px;
		margin-top: 0px;
		background-color: #ecf0f5;
	}

	.bodytext3 {
		FONT-WEIGHT: normal;
		FONT-SIZE: 11px;
		COLOR: #3B3B3C;
		FONT-FAMILY: Tahoma;
		text-decoration: none
	}
	-->
</style>
<link href="../hospitalmillennium/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
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
	function changesale() {
		var costprice1 = document.getElementById("costprice").value;
		parseFloat(costprice1);
		var spmarkup = document.getElementById("spmarkup").value;
		parseFloat(spmarkup);

		var salesprice = (parseFloat(spmarkup) / 100);
		var salesprice1 = parseFloat(salesprice) * parseFloat(costprice1);
		var salesprice2 = parseFloat(salesprice1) + parseFloat(costprice1);
		//alert(salesprice);
		document.getElementById("rateperunit2").value = salesprice2.toFixed(2);
	}

	function totalamount() {
		var costprice1 = document.getElementById("costprice").value;
		parseFloat(costprice1);
		//alert(costprice1);
		var spmarkup = document.getElementById("spmarkup").value;
		parseFloat(spmarkup);
		//var costprice1 = parseFloat(totalamount)/parseFloat(tot);
		if (spmarkup == 0) {
			var salepricemarkup = parseFloat(spmarkup);

			var saleprice = parseFloat(salepricemarkup);
		} else {
			var salepricemarkup = (parseFloat(costprice1) * parseFloat(spmarkup)) / 100;

			var saleprice = parseFloat(costprice1) + parseFloat(salepricemarkup);
			//alert(costprice1)

			//var spmarkupfinal=(parseFloat(spmarkup) / parseFloat(costprice1))*100;
			//alert(spmarkuptotal);
			//parseFloat(saleprice);
		}
		//alert(saleprice);
		document.getElementById("rateperunit2").value = saleprice.toFixed(2);
		//document.getElementById("spmarkup").value=spnew.toFixed(2);
		//alert(spnew);

	}

	function changesp() {
		//alert();
		var costprice1 = document.getElementById("costprice").value;
		var saleprice = document.getElementById("rateperunit2").value;
		var spmarkup = document.getElementById("spmarkup").value;

		var spmarkuptotal = (parseFloat(saleprice) - parseFloat(costprice1)); ///parseFloat(costprice1);
		var markuptotal = (parseFloat(spmarkuptotal) / parseFloat(costprice1));
		var spnew = (parseFloat(markuptotal)) * 100;
		//alert(spnew);
		document.getElementById("spmarkup").value = spnew.toFixed(2);

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
					//return false;
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
		if (document.form1.packageanum.value == "") {
			alert("Please Select Package.");
			document.form1.packageanum.focus();
			return false;
		}
		if (document.form1.packageanum.value == "NOS") {
			alert("Please Select Package.");
			document.form1.packageanum.focus();
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

		// if (document.form1.saccountname.value != "")
		// {	
		// 	if (document.form1.saccountid.value == ""){
		// 	alert ("Please Select Income Account Name.");
		// 	document.form1.saccountname.focus();
		// 			return false;

		// 	}
		// }
		// if (document.form1.iaccountname.value != "")
		// {
		// 	if (document.form1.saccountid.value == ""){
		// 	alert ("Please Select COGS Account Name.");
		// 	document.form1.iaccountname.focus();
		// 	return false;
		// 	}
		// }

		// if (document.form1.inv_accountname.value == "")
		// {
		// 	if (document.form1.inv_accountid.value != ""){
		// 	alert ("Please Select Inventory Account Name.");
		// 	document.form1.inv_accountname.focus();
		// 	return false;
		// 	}
		// }

		// if (document.form1.exp_accountname.value != "")
		// {
		// 	if (document.form1.exp_accountid.value == ""){
		// 	alert ("Please Select Expense Account Name.");
		// 	document.form1.exp_accountname.focus();
		// 	return false;
		// 	}
		// }

		if (document.form1.rol.value == 0) {
			alert("Please Enter ROL value.");
			document.form1.rol.focus();
			return false;
		}
		if (isNaN(document.form1.rol.value)) {
			alert("Please Enter ROL value in Numbers");
			document.form1.rol.focus();
			return false;
		}
		if (document.form1.maximumstock.value == 0) {
			alert("Please Enter Maximum Stock value.");
			document.form1.maximumstock.focus();
			return false;
		}
		if (isNaN(document.form1.maximumstock.value)) {
			alert("Please Enter Maximum Stock value in Numbers");
			document.form1.maximumstock.focus();
			return false;
		}
		if (isNaN(document.form1.rateperunit.value) == true) {
			alert("Please Enter Rate Per Unit In Numbers.");
			document.form1.rateperunit.focus();
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
		if (document.form1.formula.value == "CONSTANT") {
			if (document.form1.roq.value == "" || document.form1.roq.value == 0) {
				alert("Constant formula should have volume");
				document.form1.roq.focus();
				return false;
				//}
			}
		}
		if (document.form1.costprice.value == "" || document.form1.costprice.value == 0) {
			alert("Please Enter Cost price.");
			document.form1.costprice.focus();
			return false;
		}
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

	function calculatepersent(val) {
		//alert(val);
		var original = document.getElementById("costprice").value;
		var newnumber = document.getElementById("rateperunit2").value; // alert(newnumber);
		var decrease = parseFloat(original) - parseFloat(newnumber);
		var persent = (parseFloat(decrease) / parseFloat(original)) * 100;
		//alert(persent);
		document.getElementById("spmarkup").value = Math.abs(persent).toFixed(2);
		//alert(val);
		//alert(val);
	}

	jQuery('#some_text_box').on('input propertychange paste', function() {
		// do your stuff
	});
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


<body onLoad="return process2()">
	<table width="101%" border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td colspan="9" bgcolor="#ecf0f5"><?php include("includes/alertmessages1.php"); ?></td>
		</tr>
		<tr>
			<td colspan="9" bgcolor="#ecf0f5"><?php include("includes/title1.php"); ?></td>
		</tr>
		<tr>
			<td colspan="9" bgcolor="#ecf0f5"><?php include("includes/menu1.php"); ?></td>
		</tr>
		<tr>
			<td colspan="9">&nbsp;</td>
		</tr>
		<tr>
			<td width="1%">&nbsp;</td>
			<td width="97%" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="860">
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
								<tr>
									<td>
										<form name="form1" id="form1" method="post" action="editpharmacyitem.php" onSubmit="return additem1process1()">
											<table width="1072" border="0" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
												<tbody>
													<tr bgcolor="#011E6A">
														<td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Pharmacy Item Master - Add New </strong></td>
													</tr>
													<?php if ($st == 1) { ?>
														<tr>
															<td colspan="4" align="left" valign="middle" bgcolor="#AAFF00">
																<font size="2">Sorry Special Characters Are Not Allowed</font>
																</div>
															</td>
														</tr>
													<?php } ?>
													<?php if (isset($_REQUEST['errmsg'])) { ?>
														<tr>
															<td colspan="4" align="left" valign="middle" bgcolor="red">
																<font size="2"><?php echo $_REQUEST['errmsg']; ?></font>
																</div>
															</td>
														</tr>
													<?php } ?>
													<tr>
														<td colspan="4" align="left" valign="middle" bgcolor="<?php if ($bgcolorcode == '') {
																													echo '#FFFFFF';
																												} else if ($bgcolorcode == 'success') {
																													echo '#FFBF00';
																												} else if ($bgcolorcode == 'failed') {
																													echo '#AAFF00';
																												} else if ($bgcolorcode == 'fail') {
																													echo '#AAFF00';
																												} ?>" class="bodytext3">
															<div align="left"><?php echo $errmsg; ?>&nbsp;</div>
														</td>
													</tr>
													<tr>
														<td align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
															<div align="left">Select Category Name </div>
														</td>
														<td align="left" valign="top" bgcolor="#ecf0f5"><select id="categoryname" name="categoryname">
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
															<a href="pharmacycategory1.php">
																<font class="bodytext32" color="#000000">(Click Here To Add New Category)</font>
															</a>
														</td>
														<td align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">Generic Name</td>
														<td align="left" valign="top" bgcolor="#ecf0f5"><a href="pharmacycategory1.php"></a>
															<select id="genericname" name="genericname">
																<?php
																if ($genericname != '') {
																?>
																	<option value="<?php echo $genericname; ?>" selected="selected"><?php echo $genericname; ?></option>
																<?php
																} else {
																?>
																	<option value="" selected="selected">Select Generic Name</option>
																<?php
																}
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
														</td>
													</tr>
													<tr>
														<td align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
															<div align="left">New Pharmacy Item Code </div>
														</td>
														<td align="left" valign="top" bgcolor="#ecf0f5"><input name="itemcode" value="<?php echo $itemcode; ?>" id="itemcode" readonly onKeyDown="return process1backkeypress1()" style="border: 1px solid #001E6A; background-color:#ecf0f5" size="20" maxlength="100" />
															<span class="bodytext32">( Example : PRD1234567890 ) </span>
														</td>
														<td align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">Exclude</td>
														<td align="left" valign="top" bgcolor="#ecf0f5"><input type="checkbox" name="exclude"></td>
													</tr>
													<tr>
														<td align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
															<div align="left">Add New Pharmacy Item Name </div>
														</td>
														<td align="left" valign="top" bgcolor="#ecf0f5"><input name="itemname" type="text" id="itemname" style="border: 1px solid #001E6A" onkeydown="return spl()" value="<?php echo $itemname; ?>" size="60"></td>
														<td align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">Min Stock</td>
														<td align="left" valign="top" bgcolor="#ecf0f5"><input type="text" name="minimumstock" id="minimumstock" style="border: 1px solid #001E6A" value="<?php echo $minimumstock; ?>"></td>
													</tr>

													<tr>
														<td align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
															<div align="left">Sales Price</div>
														</td>
														<td align="left" valign="top" bgcolor="#ecf0f5"><input name="rateperunit2" id="rateperunit2" onKeyUp="return changesp()" style="border: 1px solid #001E6A" value="<?php echo $rateperunit; ?>" size="20" /> </td>
														<td align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">Max Stock</td>
														<td align="left" valign="top" bgcolor="#ecf0f5"><input type="text" name="maximumstock" id="maximumstock" style="border: 1px solid #001E6A" value="<?php echo $maximumstock; ?>"></td>
													</tr>

													<tr>
														<td align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
															<div align="left">Formula</div>
														</td>
														<td align="left" valign="top" bgcolor="#ecf0f5"><select id="formula" name="formula">
																<?php
																if ($formula1 != '') {
																?>
																	<option value="<?php echo $formula1; ?>" selected="selected"><?php echo $formula1; ?></option>
																<?php
																} else {
																?>
																	<option value="" selected="selected">Select Formula</option>
																<?php
																}

																?>
																<option value="CONSTANT">CONSTANT</option>
																<option value="INCREMENT">INCREMENT</option>
															</select></td>
														<td align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">ROL</td>
														<td align="left" valign="top" bgcolor="#ecf0f5"><input type="text" name="rol" style="border: 1px solid #001E6A" value="<?php echo $rol; ?>"></td>
													</tr>
													<tr>
														<td align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
															<div align="left">Select Pharmacy Package </div>
														</td>
														<td align="left" valign="top" bgcolor="#ecf0f5"><select id="packageanum" name="packageanum">
																<option value="">Select Pack</option>
																<?php
																if ($itemname_abbreviation != '') {
																?>
																	<option value="<?php echo $itemname_abbreviation; ?>" selected="selected"><?php echo $itemname_abbreviation; ?></option>
																<?php
																} else {
																?>
																	<option value="">Select Pack</option>
																<?php
																}
																$query1 = "select * from master_packagepharmacy where status <> 'deleted' order by packagename";
																$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
																while ($res1 = mysqli_fetch_array($exec1)) {
																	$res1anum = $res1['auto_number'];
																	$res1packagename = $res1["packagename"];
																	$res1packagename = stripslashes($res1packagename);
																	$quantityperpackage = $res1["quantityperpackage"];
																	$quantityperpackage = round($quantityperpackage);
																?>
																	<option value="<?php echo $res1packagename; ?>"><?php echo $res1packagename . ' ( ' . $quantityperpackage . ' ) '; ?></option>
																<?php
																}
																?>
															</select></td>
														<td align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">Strength</td>
														<td align="left" valign="top" bgcolor="#ecf0f5"><input type="text" name="roq" style="border: 1px solid #001E6A" value="<?php echo $roq; ?>"></td>
													</tr>
													<tr>
														<td align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
															<div align="left">Select Applicable Tax </div>
														</td>
														<td align="left" valign="top" bgcolor="#ecf0f5"><select id="taxanum" name="taxanum">
																<option value="">Select Tax</option>
																<?php
																if ($taxname != '') {
																?>
																	<option value="<?php echo $res11anum; ?>" selected="selected"><?php echo $taxname . ' ( ' . $res11taxpercent . '% ) '; ?></option>
																<?php
																} else {
																?>
																	<option value="">Select Tax</option>
																<?php
																}
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
															<input name="rateperunit" type="hidden" id="rateperunit" style="border: 1px solid #001E6A" value="<?php echo $rateperunit; ?>" size="20" />
															<input type="hidden" name="purchaseprice" id="purchaseprice" style="border: 1px solid #001E6A" value="<?php echo $purchaseprice; ?>" size="20" />
															<input name="description" type="hidden" id="description" style="border: 1px solid #001E6A" value="<?php echo $description; ?>" size="50">
															<input type="hidden" name="unitname_abbreviation" id="unitname_abbreviation" value="NOS">
														</td>
														<td align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">IP Mark up</td>
														<td align="left" valign="top" bgcolor="#ecf0f5"><input type="text" name="ipmarkup" style="border: 1px solid #001E6A" value="<?php echo $ipmarkup; ?>"></td>
													</tr>
													<tr>
														<td align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">Cost Price</td>
														<td align="left" valign="top" bgcolor="#ecf0f5"><input type="text" name="costprice" id="costprice" onKeyUp="return totalamount();" style="border: 1px solid #001E6A" value="<?php echo $purchaseprice; ?>"></td>
														<td align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">SP Mark up</td>
														<td align="left" valign="top" bgcolor="#ecf0f5"><input type="text" name="spmarkup" onKeyUp="return changesale(); " id="spmarkup" style="border: 1px solid #001E6A" value="<?php echo $spmarkup; ?>"></td>
													</tr>
													<tr>
														<td align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">Disease</td>
														<td align="left" valign="top" bgcolor="#ecf0f5"><input type="text" name="disease" id="disease" style="border: 1px solid #001E6A" value="<?php echo $disease; ?>"></td>
														<td align="left" valign="top" class="bodytext3" bgcolor="#ecf0f5">Purchase Type</td>
														<td align="left" valign="top" bgcolor="#ecf0f5">
															<select name="type" id="type">
																<?php if ($type != '') {
																?>
																	<option value="<?php echo $type; ?>" selected="selected"><?php echo $type; ?></option>

																<?php
																}
																?>
																<option value="">Select Purchase Type</option>
																<?php

																$query = "select id,name from master_purchase_type where status !='deleted' order by id desc";
																$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
																while ($res = mysqli_fetch_array($exec)) {
																	$producttypes = $res["name"];
																	$product_type_id = $res["id"];
																?>
																	<option value="<?php echo $producttypes; ?>"><?php echo $producttypes; ?></option>
																<?php
																}
																?>
															</select>

														</td>
													</tr>

													<!-- Product Type -->
													<tr>
														<!--empty col-->
														<td align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3"></td>
														<td align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3"></td>
														<!-- empty col-->
														<td align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">Product Type</td>
														<td align="left" valign="top" bgcolor="#ecf0f5">
															<select name="producttype" id="producttype">
																<option value="">Select Product Type</option>
																<?php
																$query_prod_type = "select * from product_type where status = '1' ";
																$exec_prod_type = mysqli_query($GLOBALS["___mysqli_ston"], $query_prod_type) or die("Error in query_prod_type" . mysqli_error($GLOBALS["___mysqli_ston"]));
																while ($res_prod_type = mysqli_fetch_array($exec_prod_type)) {
																	$res_prod_id = $res_prod_type['id'];
																	$res_prod_name = $res_prod_type['name'];

																?>
																	<option value="<?php echo $res_prod_id; ?>" <?php if ($producttype == $res_prod_id) {
																													echo 'selected="selected"';
																												} ?>><?php echo $res_prod_name; ?></option>
																<?php
																}
																?>
															</select>
														</td>
													</tr>
													<tr>
														<!-- <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
							<td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td> -->
														<td align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">Drug Instructions</td>
														<td align="left" valign="top" bgcolor="#ecf0f5">
															<select name="drug_instructions" id="drug_instructions">
																<option value="">Select Drug Instructions</option>
																<?php
																$query_prod_type = "select * from drug_instructions where status = '1' ";
																$exec_prod_type = mysqli_query($GLOBALS["___mysqli_ston"], $query_prod_type) or die("Error in query_prod_type" . mysqli_error($GLOBALS["___mysqli_ston"]));
																while ($res_prod_type = mysqli_fetch_array($exec_prod_type)) {
																	$res_prod_id2 = $res_prod_type['id'];
																	$res_prod_name2 = $res_prod_type['name'];

																?>
																	<option value="<?php echo $res_prod_id2; ?>" <?php if ($drug_instructions == $res_prod_id2) {
																														echo 'selected="selected"';
																													} ?>><?php echo $res_prod_name2; ?></option>
																<?php
																}
																?>
															</select>
														</td>
														<td align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">Dose Measure</td>
														<td align="left" valign="top" bgcolor="#ecf0f5">
															<select name="dose_measure" id="dose_measure">
																<option value="">Select Dose Measure</option>
																<?php
																$query_prod_type = "select * from dose_measure where status = '1' ";
																$exec_prod_type = mysqli_query($GLOBALS["___mysqli_ston"], $query_prod_type) or die("Error in query_prod_type" . mysqli_error($GLOBALS["___mysqli_ston"]));
																while ($res_prod_type = mysqli_fetch_array($exec_prod_type)) {
																	$res_prod_id3 = $res_prod_type['id'];
																	$res_prod_name3 = $res_prod_type['name'];

																?>
																	<option value="<?php echo $res_prod_id3; ?>" <?php if ($dose_measure == $res_prod_id3) {
																														echo 'selected="selected"';
																													} ?>><?php echo $res_prod_name3; ?></option>
																<?php
																}
																?>
															</select>
														</td>
													</tr>
													<tr>
														<td align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">Package</td>
														<td align="left" valign="top" bgcolor="#ecf0f5"><input type="checkbox" name="pkg" <?php if ($pkg == 'yes') {
																																				echo "checked";
																																			} ?> value="yes"></td>

														<td width="13%" align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">Income Ledger</td>
														<td width="33%" align="left" valign="top" bgcolor="#ecf0f5">
															<input type="text" name="saccountname" id="saccountname" size="30" value="<?= $incomeledger ?>" />
															<input type="hidden" name="saccountauto" id="saccountauto" value="" />
															<input type="hidden" name="saccountid" id="saccountid" value="<?= $incomeledgercode ?>" />
														</td>

													</tr>
													<tr>
														<td align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">Transfer Type</td>
														<td align="left" valign="top" bgcolor="#ecf0f5"><select name="transfertype" id="transfertype">
																<option value="">Select</option>
																<option value="0" <?php if ($transfertype == '0') echo 'selected'; ?>>Transfer</option>
																<option value="1" <?php if ($transfertype == '1') echo 'selected'; ?>>Consumable</option>
															</select> </td>
														<td width="13%" align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">COGS Ledger</td>
														<td width="33%" align="left" valign="top" bgcolor="#ecf0f5">
															<input type="text" name="iaccountname" id="iaccountname" size="30" value="<?= $ledgername ?>" />
															<input type="hidden" name="iaccountauto" id="iaccountauto" value="" />
															<input type="hidden" name="iaccountid" id="iaccountid" value="<?= $ledgercode ?>" />
														</td>
													</tr>

													<tr>
														<!-- <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td> -->
														<!-- <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td> -->

														<td align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">Nature Type</td>
														<td align="left" valign="top" bgcolor="#ecf0f5"><select name="nature" id="nature">
																<option value="">Select</option>
																<option value="0" <?php if ($nature == '0') echo 'selected'; ?>>Nature 1</option>
																<option value="1" <?php if ($nature == '1') echo 'selected'; ?>>Nature 2</option>
															</select> </td>

														<td width="13%" align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">Inventory Ledger</td>
														<td width="33%" align="left" valign="top" bgcolor="#ecf0f5">
															<input type="text" name="inv_accountname" id="inv_accountname" size="30" value="<?= $inventoryledgername; ?>" />
															<input type="hidden" name="inv_accountauto" id="inv_accountauto" value="" />
															<input type="hidden" name="inv_accountid" id="inv_accountid" value="<?= $inventoryledgercode ?>" />
														</td>
													</tr>
													<tr>
														<td width="13%" align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3">Expense Ledger</td>
														<td width="33%" align="left" valign="top" bgcolor="#ecf0f5">
															<input type="text" name="exp_accountname" id="exp_accountname" size="30" value="<?= $expenseledgername; ?>" />
															<input type="hidden" name="exp_accountauto" id="exp_accountauto" value="" />
															<input type="hidden" name="exp_accountid" id="exp_accountid" value="<?= $expenseledgercode ?>" />
														</td>


													</tr>


													<tr>
														<td align="left" valign="top" bgcolor="#ecf0f5" class="bodytext3"></td>
														<td align="left" valign="top" bgcolor="#ecf0f5"></td>

														<td width="13%" align="left" valign="top" bgcolor="#ecf0f5">&nbsp;</td>
														<td width="33%" align="left" valign="top" bgcolor="#ecf0f5"><input type="hidden" name="frmflag1" value="frmflag1" />
															<input type="hidden" name="frmflag" value="addnew" />
															<input type="submit" name="Submit" value="Save Pharmacy Item" style="border: 1px solid #001E6A" />
														</td>
													</tr>
												</tbody>
											</table>
										</form>
									</td>
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