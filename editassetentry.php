<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

$username = $_SESSION["username"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];



$docno = $_SESSION['docno'];

$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$errmsg = "";

$bgcolorcode = "";

$colorloopcount = "";

$docno = $_SESSION['docno'];

$locationdetails="select locationcode, locationname from login_locationdetails where username='$username' and docno='$docno'";

$exeloc=mysqli_query($GLOBALS["___mysqli_ston"], $locationdetails);

$resloc=mysqli_fetch_array($exeloc);

$locationcode=$resloc['locationcode'];

$locationname = $resloc['locationname'];



if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1')

{

	$itemname = $_REQUEST['itemname'];

	$itemname = strtoupper($itemname);

	$assetid = $_REQUEST['assetid'];

	$costprice = $_REQUEST['costprice'];

	$costprice = str_replace(',','',$costprice);

	$salvage = $_REQUEST['salvage']; 

	$salvage = str_replace(',','',$salvage);

	$entrydate = $_REQUEST['entrydate'];

	$category1 = $_REQUEST['category'];

	$asset_category_id = $_REQUEST['category_id'];

	$dep_percent = $_REQUEST['dep_percent'];

	$category = $category1;

	$department = $_REQUEST['department'];

	$department = ucfirst($department);

	$assetclass = $_REQUEST['assetclass'];

	$assetclass = ucfirst($assetclass);

	$assetclassid = $_REQUEST['assetclassid'];

	$unit = $_REQUEST['unit'];

	$period = $_REQUEST['period'];

	$startyear = $_REQUEST['startyear'];

	$startyear = strtoupper($startyear);

	$assetanum = $_REQUEST['assetanum'];

	$assetledger = $_REQUEST['assetledger'];

	$assetledgercode = $_REQUEST['assetledgercode'];

	$depreciation = $_REQUEST['depreciation'];

	$depreciationcode = $_REQUEST['depreciationcode'];

	$accdepreciation = $_REQUEST['accdepreciation'];

	$accdepreciationcode = $_REQUEST['accdepreciationcode'];

	$accdepreciationvalue = $_REQUEST['accdepreciationvalue'];

	$accdepreciationvalue = str_replace(',','',$accdepreciationvalue);

	$gainlossledger = $_REQUEST['gainlossledger'];

	$gainlossledgercode = $_REQUEST['gainlossledgercode'];

	$assetize_form = $_REQUEST['assetize'];



		$depriciation_startyear = explode('-', $startyear);

		$start_month = $depriciation_startyear[0];

		switch ($start_month) {
			case 'JAN':
				$month = 1;
				break;
			case 'FEB':
			$month = 2;
				break;
				case 'MAR':
			$month = 3;
				break;
				case 'APR':
			$month = 4;
				break;
				case 'MAY':
			$month = 5;
				break;
				case 'JUN':
			$month = 6;
				break;
				case 'JUL':
			$month = 7;
				break;
				case 'AUG':
			$month = 8;
				break;
				case 'SEP':
			$month = 9;
				break;
				case 'OCT':
			$month = 10;
				break;
				case 'NOV':
			$month = 11;
				break;
				case 'DEC':
			$month = 12;
				break;
			default:
				# code...
				break;
		}

		$start_year = $depriciation_startyear[1];

		if($month <10)
		{
			$month = "0".$month;
		}
		$start_day = '01';

		$depreciation_start_date = $start_year.'-'.$month.'-'.$start_day;

	$asset_id = $_REQUEST['assetid'];

	$assetid = $asset_id;


	$assetize_status = 0;

	if($assetize_form)
	{
		
		$idlen = strlen($assetclassid);

		//$query7 = "select asset_id from assets_register where asset_id LIKE '$assetclassid%' order by asset_id desc limit 1";
		$query7 = "select asset_id from assets_register where asset_id LIKE 'PH-FA%' order by asset_id desc limit 1";

		$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res7 = mysqli_fetch_array($exec7);

		$asset_id = $res7['asset_id'];

		$asset_idlen = strlen($asset_id);

		

		$assetid = substr($asset_id,5,$asset_idlen);

		

		$assetid = ltrim($assetid, "0");
		
		$assetid = intval($assetid) + 1;


		$anumlen = strlen($assetid);
		
		$noofzeros = 1;
		if($anumlen <7)
		{
			$noofzeros =  7- $anumlen;
		}
		for($i=1;$i<=$noofzeros;$i++){
			$zeros_str .= "0";
		}
		
		//exit;
		/*if($anumlen == 1) { $assetid = '000'.$assetid; }

		else if($anumlen == 2) { $assetid = '00'.$assetid; }

		else if($anumlen == 3) { $assetid = '0'.$assetid; }

		else { $assetid = $assetid; }*/

		$asset_name_str = "PH-FA";

		$assetid = $asset_name_str.$zeros_str.$assetid;

		

		$assetize_status = 1;
	}

	$query33 = "select asset_id from assets_register where asset_id = '$assetid'";

	$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));

	$row33 = mysqli_num_rows($exec33);

	if( ($row33 > 0)  || ($assetize_form >0))

	{ 

		$billnumber = 'FAP-'.$assetanum;

		$query88 = "UPDATE assets_register SET `itemname` = '$itemname', `asset_id` = '$assetid', `asset_category` = '$category', `asset_department` = '$department', `asset_unit` = '$unit', `asset_period` = '$period', companyanum = '$companyanum',

		`startyear` = '$startyear', asset_class = '$assetclass', dep_percent = '$dep_percent', `depreciationledger` = '$depreciation', `depreciationledgercode` = '$depreciationcode', `accdepreciationledger` = '$accdepreciation',

		`accdepreciationledgercode` = '$accdepreciationcode', `accdepreciation` = '$accdepreciationvalue', `rate` = '$costprice', `quantity` = '1', `subtotal` = '$costprice', `totalamount` = '$costprice', `coa` = '$assetledgercode', 

		`username` = '$username', `ipaddress` = '$ipaddress', `entrydate` = '$entrydate', `itemtotalquantity` = '1', `typeofpurchase` = 'Manual', `locationcode` = '$locationcode', `location` = '$locationname', `assetledger` = '$assetledger', `assetledgercode` = '$assetledgercode',`salvage` = '$salvage' , `depreciation_start_month` = '$month', `depreciation_start_year` = '$start_year',`depreciation_start_date` = '$depreciation_start_date',`assetize` = '$assetize_status',`asset_category_id`='$asset_category_id' , `gainloss_ledger` = '$gainlossledger' , `gainloss_ledger_code` = '$gainlossledgercode'  where auto_number = '$assetanum'";

		$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$assetanum = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);

		

		$query881 = "UPDATE purchase_details SET `itemname` = '$itemname', companyanum = '$companyanum',

		`rate` = '$costprice', `quantity` = '1', `subtotal` = '$costprice', `totalamount` = '$costprice', `costprice` = '$costprice', `coa` = '$assetledgercode', 

		`username` = '$username', `ipaddress` = '$ipaddress', `entrydate` = '$entrydate', `itemtotalquantity` = '1', `typeofpurchase` = 'Manual', `purchasetype` = 'Asset', `totalfxamount` = '$costprice', `fxtotamount` = '$costprice',

		`locationcode` = '$locationcode', `location` = '$locationname', `expense` = '$assetledger', `expensecode` = '$assetledgercode', `accdepreciation_ledger` = 'Opening Balance Equity', `accdepreciation_code` = '04-5010-EQ' where `billnumber` = '$billnumber'";

		$exec881 = mysqli_query($GLOBALS["___mysqli_ston"], $query881) or die ("Error in Query881".mysqli_error($GLOBALS["___mysqli_ston"]));

		
		if($assetize_form)
		{
			header("location:assetschedule.php");
		}
		else
		{
			header("location:assetentrylist.php?st=success");
		}

		exit;

	}	

}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if (isset($_REQUEST["assetanum"])) { $assetanum = $_REQUEST["assetanum"]; } else { $assetanum = ""; }

if($st == 'error')

{

	$errmsg = "Asset ID already exists";

}

if($st == 'success')

{

?>

<script>

window.open("print_assetlable.php?assetanum="+<?= $assetanum;?>+"","Window",'width=500,height=300,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');

</script>

<?php

}

if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }

if ($svccount == 'firstentry')

{

	$errmsg = "Please Add Store To Proceed For Billing.";

	$bgcolorcode = 'failed';

}



$query32 = "select auto_number from assets_register order by auto_number desc limit 0,1";

	$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query32".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res32 = mysqli_fetch_array($exec32);

	$anum = $res32['auto_number'];

	$assetanum = $anum + 1;

	

if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }

$query77 = "select * from assets_register where auto_number = '$anum'";

$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));

$res77 = mysqli_fetch_array($exec77);

$itemname = $res77['itemname'];

$totalamount = $res77['totalamount'];

$salvage = $res77['salvage'];
//echo $salvage;exit;

$entrydate = $res77['entrydate'];

$asset_id = $res77['asset_id'];

$asset_category = $res77['asset_category'];

$asset_category_id = $res77['asset_category_id'];

$asset_class = $res77['asset_class'];

$asset_department = $res77['asset_department'];

$asset_unit = $res77['asset_unit'];

$asset_period = $res77['asset_period'];

$startyear = $res77['startyear'];

$dep_percent = $res77['dep_percent'];

$assetledger = $res77['assetledger'];

$assetledgercode = $res77['assetledgercode'];

if($assetledger =="")
$assetledger = getLedgerName($assetledgercode);

$depreciationledger = $res77['depreciationledger'];

$depreciationledgercode = $res77['depreciationledgercode'];
if($depreciationledger =="")
$depreciationledger = getLedgerName($depreciationledgercode);

$accdepreciationledger = $res77['accdepreciationledger'];

$accdepreciationledgercode = $res77['accdepreciationledgercode'];
if($accdepreciationledger =="")
$accdepreciationledger = getLedgerName($accdepreciationledgercode);

$accdepreciationvalue = $res77['accdepreciation'];

$gainlossledger = $res77['gainloss_ledger'];

$gainlossledgercode = $res77['gainloss_ledger_code'];


$depreciation = $totalamount * ($dep_percent / 100);

$accdepreciation = $depreciation * $asset_period;

$totalamount = number_format($totalamount,2);

$salvage = number_format($salvage,2);

$depreciation = number_format($depreciation,2);

$accdepreciation = number_format($accdepreciation,2);

$asset_classid = '';

if($asset_class != '')

{

$query61 = "select * from master_assetcategory where category like '$asset_class' and recordstatus <> 'deleted'";

$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query61".mysqli_error($GLOBALS["___mysqli_ston"]));

$res61 = mysqli_fetch_array($exec61);

$asset_classid = $res61['id'];

}	

function getLedgerName($ledgercode)
{

	$accountname = "";
	$query61 = "select accountname from master_accountname where id= '$ledgercode'";

$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query61".mysqli_error($GLOBALS["___mysqli_ston"]));

$res61 = mysqli_fetch_array($exec61);

$accountname = $res61['accountname'];
return $accountname;

}
if (isset($_REQUEST["assetize"])) { $assetize = $_REQUEST["assetize"]; } else { $assetize = 0; }


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
.requiredfld{color:red;}
-->

</style>

</head>

<script language="javascript">



function ajaxlocationfunction(val)

{ 

if (window.XMLHttpRequest)

					  {// code for IE7+, Firefox, Chrome, Opera, Safari

					  xmlhttp=new XMLHttpRequest();

					  }

					else

					  {// code for IE6, IE5

					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

					  }

					xmlhttp.onreadystatechange=function()

					  {

					  if (xmlhttp.readyState==4 && xmlhttp.status==200)

						{

						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;

						}

					  }

					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);

					xmlhttp.send();

}

					

//ajax to get location which is selected ends here



function addward1process1()

{
	

	
	var assetize = '<?php echo $assetize ?>';


	//alert ("Inside Funtion");

	if (document.form1.category_id.value == "")

	{

		alert ("Please Select Asset Category.");

		document.form1.category.focus();

		return false;

	}

	if (document.form1.assetclassid.value == "")

	{

		alert ("Please Select Asset Class From Search List.");

		document.form1.assetclass.focus();

		return false;

	}

	if (document.form1.department.value == "")

	{

		alert ("Please Select Department");

		document.form1.department.focus();

		return false;

	}

	if (document.form1.unit.value == "")

	{

		alert ("Please Select Unit");

		document.form1.unit.focus();

		return false;

	}

	if (document.form1.itemname.value == "")

	{

		alert ("Please Enter Asset Name.");

		document.form1.itemname.focus();

		return false;

	}

	if(assetize == 0)
	{
		if (document.form1.assetid.value == "")
		{

		alert ("Please Enter Asset ID.");

		document.form1.assetid.focus();

		return false;

		}
	}
	
	if (document.form1.costprice.value == "")

	{

		alert ("Please Enter Purchase Price.");

		document.form1.costprice.focus();

		return false;

	}
	if (document.form1.salvage.value == "")

	{

		alert ("Please Enter Salvage.");

		document.form1.salvage.focus();

		return false;

	}

	if (document.form1.startyear.value == "")

	{

		alert ("Please Enter Depreciation Start From.");

		document.form1.startyear.focus();

		return false;

	}
	

	if (document.form1.period.value == "")

	{

		alert ("Please Enter Life.");

		document.form1.period.focus();

		return false;

	}

	if (document.form1.category.value == "")

	{

		alert ("Please Select Category.");

		document.form1.category.focus();

		return false;

	}

	if (document.form1.assetledgercode.value == "")

	{

		alert ("Please Enter Asset Ledger");

		document.form1.assetledgercode.focus();

		return false;

	}

	if (document.form1.depreciationcode.value == "")

	{

		alert ("Please Enter Depreciation Ledger");

		document.form1.depreciation.focus();

		return false;

	}

	if (document.form1.accdepreciationcode.value == "")

	{

		alert ("Please Enter Accu Depreciation Ledger");

		document.form1.accdepreciation.focus();

		return false;

	}

	if (document.form1.gainlossledgercode.value == "")

	{

		alert ("Please Select Gain/Loss Ledger");

		document.form1.gainlossledger.focus();

		return false;

	}

	return confirm("Are you sure you want to Save?");

	

}



function UnitSelect(val)

{

	<?php 

	$query_c = "select * from master_assetdepartment where recordstatus <> 'deleted' group by department";

	$exec_c = mysqli_query($GLOBALS["___mysqli_ston"], $query_c) or die ("Error in Query_c".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($res_c = mysqli_fetch_array($exec_c))

	{

		$assetdepartment = $res_c['department'];

	?>

	if(val == "<?php echo $assetdepartment; ?>")

	{

		document.getElementById("unit").options.length=null; 

		var combo = document.getElementById('unit'); 	

		<?php 

		$loopcount=0;

		?>

		combo.options[<?php echo $loopcount;?>] = new Option ("Select", ""); 

		<?php

		$query10 = "select * from master_assetdepartment where department = '$assetdepartment' and recordstatus <> 'deleted'";

		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res10 = mysqli_fetch_array($exec10))

		{

		$loopcount = $loopcount+1;

		$unit = $res10["unit"];

		?>

			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $unit;?>", "<?php echo $unit;?>"); 

		<?php 

		}

		?>

	}

	<?php

	}

	?>

}



</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />

<link rel="stylesheet" type="text/css" href="css/autocomplete.css" />        



<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>

<script type="text/javascript" src="js/jquery.min-autocomplete.js"></script>

<script type="text/javascript" src="js/jquery-ui.min.js"></script>

<script type="text/javascript">

$(function() {

$('#assetledger').autocomplete({

	source:'autoassetledgersearch.php?requestfrm=asset&', 

	select: function(event,ui){

			var code = ui.item.id;

			var anum = ui.item.anum;

			$('#assetledgercode').val(code);

			},

	html: true

    });

	

$('#depreciation').autocomplete({

	source:'autoassetledgersearch.php?requestfrm=depreciation&', 

	select: function(event,ui){

			var code = ui.item.id;

			var anum = ui.item.anum;

			$('#depreciationcode').val(code);

			},

	html: true

    });	

	

$('#accdepreciation').autocomplete({

	source:'autoassetledgersearch.php?requestfrm=accdepreciation&', 

	select: function(event,ui){

			var code = ui.item.id;

			var anum = ui.item.anum;

			$('#accdepreciationcode').val(code);

			},

	html: true

    });	

$('#gainlossledger').autocomplete({

	source:'autoassetledgersearch.php?requestfrm=gainloss&', 

	select: function(event,ui){

			var code = ui.item.id;

			var anum = ui.item.anum;

			$('#gainlossledgercode').val(code);

			},

	html: true

    });	

	$('#assetclass').autocomplete({

	source:'autoassetclasssearch.php', 

	select: function(event,ui){

			var code = ui.item.id;

			var anum = ui.item.anum;

			var assetid = ui.item.asset_id;

			$('#assetclassid').val(code);

			},

	html: true

    });

	

	$('#category').autocomplete({

	source:'autoassetclasssearch.php', 

	select: function(event,ui){

			var salvage = ui.item.salvage;

			var anum = ui.item.anum;

			$('#category_id').val(anum);
			$('#dep_percent').val(salvage);

			var assetano = $('#assetanum').val();
			var noofyears = ui.item.noofyears;
			$('#period').val(noofyears)
			},

	html: true

    });		

	$( "#costprice" ).blur(function() {
	
		//var costprice = parseFloat($(this).val());
		var costprice = document.getElementById("costprice").value.replace(/[^0-9\.]+/g,"");
		
		console.log(costprice)
		//var salvage = parseFloat($('#salvage').val());
		var salvage = document.getElementById("salvage").value.replace(/[^0-9\.]+/g,"");
		
		if(parseFloat(costprice) < parseFloat(salvage))
		{
			alert('Purchase Price cannot be less than Salvage');
			$(this).val('');
			$('#costprice').focus();
		}
		else
		{
			document.getElementById("costprice").value = formatMoney(costprice);
		}
		

	});

$( "#salvage" ).blur(function() {
	
		//var salvage = parseFloat($.trim($(this).val()));
		//var salvage=salvage.replace(/[^0-9\.]+/g,"");
		var salvage = document.getElementById("salvage").value.replace(/[^0-9\.]+/g,"");
		
		//var costprice = parseFloat($.trim($('#costprice').val()));
		var costprice = document.getElementById("costprice").value.replace(/[^0-9\.]+/g,"");

		//var costprice = parseFloat($.trim($('#costprice').val()));
		if(parseFloat(salvage) > parseFloat(costprice))
		{
			alert('Salvage cannot be more than Purchase Price');
			$(this).val('');
			$('#salvage').focus();

		}
		else
		{
			document.getElementById("salvage").value = formatMoney(salvage);
		}
		

	});

});
function formatMoney(number, places, thousand, decimal) {
	number = number || 0;
	places = !isNaN(places = Math.abs(places)) ? places : 2;
	
	thousand = thousand || ",";
	decimal = decimal || ".";
	var negative = number < 0 ? "-" : "",
	    i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
	    j = (j = i.length) > 3 ? j % 3 : 0;
	return  negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");

}

/*$(document).ready(function() {

		$('#submitbtn').click(function(){
	    	return confirm("Are you sure you want to Save?");
		})
	});*/
</script>

<!-- <script src="js/datetimepicker_css.js"></script> -->
<script src="js/datetimepicker1_css.js"></script>

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

              <td><form name="form1" id="form1" method="post" action="editassetentry.php" onsubmit="return addward1process1()">

                  <table width="620" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <td colspan="" bgcolor="#ecf0f5" class="bodytext3"><strong>Asset Entry - Edit</strong></td>

                         <td width="77%" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>

             

            

                  <?php

						

						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res1 = mysqli_fetch_array($exec1);

						

						echo $res1location = $res1["locationname"];

						

						?>                  </td>

                      </tr>

                        <tr>

                        <td colspan="2" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="left">All fields marked with an asterisk (*) are required.</div></td>

                        

                      </tr>

					  <tr>

                        <td colspan="2" align="left" valign="middle"   

						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>

                      </tr>

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Location </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<select name="location" id="location" onChange="ajaxlocationfunction(this.value);"   style="border: 1px solid #001E6A;">

						

                          <?php

				$query5 = "select * from master_location where status = '' order by locationname";

				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

				while ($res5 = mysqli_fetch_array($exec5))

				{

				$locationcode = $res5["locationcode"];

				$res5location = $res5["locationname"];

				?>

                          <option value="<?php echo $locationcode; ?>"><?php echo $res5location; ?></option>

                          <?php

				}

				?>

                        </select>

						</td>

                      </tr>

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Asset Category<span class="requiredfld">*</span></div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input type="text" name="category" id="category" value="<?php echo $asset_category; ?>" size="40" style="border: 1px solid #001E6A;">

						<input type="hidden" name="category_id" id="category_id" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" value="<?php echo $asset_category_id; ?>"/>

		

                        <input type="hidden" name="dep_percent" id="dep_percent" value="<?php echo $dep_percent; ?>"></td>

                      </tr>

                       <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Class <span class="requiredfld">*</span></div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="assetclass" id="assetclass" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" value="<?php echo $asset_class; ?>"/>

						<input type="hidden" name="assetclassid" id="assetclassid" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" value="<?php echo $asset_class; ?>"/></td>

                      </tr>

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Department <span class="requiredfld">*</span></div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<select name="department" id="department" style="border: 1px solid #001E6A;" onChange="return UnitSelect(this.value);">

						<option value="">Select</option>

                        <?php 

						$query_c = "select * from master_assetdepartment where recordstatus <> 'deleted' group by department";

						$exec_c = mysqli_query($GLOBALS["___mysqli_ston"], $query_c) or die ("Error in Query_c".mysqli_error($GLOBALS["___mysqli_ston"]));

						while($res_c = mysqli_fetch_array($exec_c))

						{

							$assetdepartment = $res_c['department'];

						?>

						<option value="<?php echo $assetdepartment; ?>" <?php if($assetdepartment == $asset_department) { echo "selected"; } ?>><?php echo $assetdepartment; ?></option>

						<?php

						}

						?>

						</select></td>

                      </tr>

					  <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Unit <span class="requiredfld">*</span></div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<select name="unit" id="unit" style="border: 1px solid #001E6A;">

                        <option value="">Select</option>

                        <?php 

						$query_u = "select * from master_assetdepartment where department = '$asset_department' and recordstatus <> 'deleted'";

						$exec_u = mysqli_query($GLOBALS["___mysqli_ston"], $query_u) or die ("Error in Query_u".mysqli_error($GLOBALS["___mysqli_ston"]));

						while($res_u = mysqli_fetch_array($exec_u))

						{

							$assetunit = $res_u['unit'];

						?>

						<option value="<?php echo $assetunit; ?>" <?php if($assetunit == $asset_unit) { echo "selected"; } ?>><?php echo $assetunit; ?></option>

						<?php

						}

						?>

                        </select>

                        </td>

                      </tr>

					   

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Asset Name <span class="requiredfld">*</span></div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="itemname" id="itemname" value="<?php echo $itemname; ?>" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" <?php if($assetize) echo "readonly";?> autocomplete="off" /></td>

                      </tr>
                      
                      <?php if($assetize ==0){ ?>
                      	 <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Asset ID <span class="requiredfld">*</span></div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input readonly name="assetid" id="assetid" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" value="<?php echo $asset_id; ?>"/></td>
						
						</td>
                      </tr>
                  <?php } ?>
					  <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Purchase Price <span class="requiredfld">*</span></div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="costprice" id="costprice" value="<?php echo $totalamount; ?>" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" readonly /></td>

                      </tr>

                       <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Salvage <span class="requiredfld">*</span></div></td>
                        <?php 
                        if($assetize){$salvage='';}

                        ?>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input type="text" name="salvage" id="salvage" value="<?= $salvage ?>" size="40" <?php if($assetize == 0)  echo "readonly";?> autocomplete="off"/></td>

                      </tr>

					  <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Acquisition Date </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="entrydate" id="entrydate" value="<?php echo $entrydate; ?>" readonly style="border: 1px solid #001E6A;"/>

                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('entrydate')" style="cursor:pointer">

                        </td>

                      </tr>

					 

					   <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Life </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="period" id="period" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" value="<?php echo $asset_period; ?>" readonly/></td>

                      </tr>

					   <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Depreciation Start From </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="startyear" id="startyear" style="border: 1px solid #001E6A; text-transform:uppercase" size="20" value="<?php echo $startyear; ?>" readonly />
						<?php if($assetize == 0)  {?>
						<img src="images2/cal.gif"  style="cursor:pointer">
					<?php } else {?>
						<img src="images2/cal.gif" onclick="javascript:NewCssCal('startyear','MMMYYYY')" style="cursor:pointer">
					<?php } ?>
						</td>

                      </tr>

					   

					  <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Asset Ledger <span class="requiredfld">*</span></div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="assetledger" id="assetledger" value="<?php echo $assetledger; ?>" style="border: 1px solid #001E6A; text-transform:uppercase" size="40"/>

						<input type="hidden" name="assetledgercode" id="assetledgercode" value="<?php echo $assetledgercode; ?>"></td>

                      </tr>

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Depreciation Ledger <span class="requiredfld">*</span></div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="depreciation" id="depreciation" value="<?php echo $depreciationledger; ?>" style="border: 1px solid #001E6A; text-transform:uppercase" size="40"/>

						<input type="hidden" name="depreciationcode" id="depreciationcode" value="<?php echo $depreciationledgercode; ?>"></td>

                      </tr>

					  <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Accu Depreciation Ledger <span class="requiredfld">*</span></div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="accdepreciation" id="accdepreciation" value="<?php echo $accdepreciationledger; ?>" style="border: 1px solid #001E6A; text-transform:uppercase" size="40"/>

						<input type="hidden" name="accdepreciationcode" id="accdepreciationcode" value="<?php echo $accdepreciationledgercode; ?>">

						<input type="hidden" name="accdepreciationvalue" id="accdepreciationvalue" value="<?php echo $accdepreciation; ?>" style="border: 1px solid #001E6A; text-transform:uppercase" size="40"/></td>

                      </tr>

					   <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Gain/Loss Ledger <span class="requiredfld">*</span></div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="gainlossledger" id="gainlossledger" value="<?php echo $gainlossledger;?>" style="border: 1px solid #001E6A; text-transform:uppercase" size="40"/>

						<input type="hidden" name="gainlossledgercode" id="gainlossledgercode" value="<?php echo $gainlossledgercode;?>">

						</td>

                      </tr>

                      <tr>

                        <td width="23%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                        <td width="77%" align="left" valign="top"  bgcolor="#FFFFFF">

						<input type="hidden" name="frmflag" value="addnew" />

						<input type="hidden" name="assetanum" id="assetanum" value="<?php echo $anum; ?>">

						<input type="hidden" name="assetize" id="assetize" value="<?php echo $assetize; ?>">
						
                            <input type="hidden" name="frmflag1" value="frmflag1" />

                          <input type="submit" id="submitbtn" name="Submit" value="Submit" style="border: 1px solid #001E6A" /></td>

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



