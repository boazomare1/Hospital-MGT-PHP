<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$pkg=isset($_REQUEST['pkg'])?$_REQUEST['pkg']:'no';

//to redirect if there is no entry in masters category or item.
$query90 = "select count(auto_number) as masterscount from master_medicine";
$exec90 = mysqli_query($GLOBALS["___mysqli_ston"], $query90) or die ("Error in Query90".mysqli_error($GLOBALS["___mysqli_ston"]));
$res90 = mysqli_fetch_array($exec90);
$res90count = $res90["masterscount"];
if ($res90count == 0)
{
	header ("location:addcategory1radiology.php?svccount=firstentry");
}


if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{

	$itemcode = $_REQUEST["itemcode"];
	$itemcode = strtoupper($itemcode);
	$itemcode = trim($itemcode);
	$itemname = $_REQUEST["itemname"];
	$genericname = $_REQUEST['genericname'];
	$disease = $_REQUEST['disease'];
	$type = $_REQUEST['type'];
	
	$ledgername = $_REQUEST['saccountname'];
	$ledgerautonumber = $_REQUEST['saccountauto'];
	$ledgercode = $_REQUEST['saccountid'];
	
	$incomeledgername = $_REQUEST['iaccountname'];
	$incomeledgerautonumber = $_REQUEST['iaccountauto'];
	$incomeledgercode = $_REQUEST['iaccountid'];
	
	$inventoryledgername = $_REQUEST['inv_accountname'];
	$inventoryledgerautonumber = $_REQUEST['inv_accountauto'];
	$inventoryledgercode = $_REQUEST['inv_accountid'];			
	
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
	$length1=strlen($itemcode);
	$length2=strlen($itemname);
	//! ^ + = [ ] ; , { } | \ < > ? ~
	//if (preg_match ('/[+,|,=,{,},(,)]/', $itemname))
	if (preg_match ('/[!,^,+,=,[,],;,,,{,},|,\,<,>,?,~]/', $itemname))
	{  
		//echo "inside if";
		$bgcolorcode = 'fail';
		$errmsg="Sorry. pharmacy Item Not Added";
		
		header("location:pharmacyitem1.php?st=1");
		exit();
	}
	$itemname = addslashes($itemname);
	
	$categoryname = $_REQUEST["categoryname"];
	$purchaseprice  = $_REQUEST["costprice"];
	$rateperunit  = $_REQUEST["rateperunit2"];
	$expiryperiod = '';
	$description=$_REQUEST["description"];
	$itemname_abbreviation = $_REQUEST['packageanum'];
	$taxanum = $_REQUEST["taxanum"];
	$formula = $_REQUEST['formula'];
	$transfertype = $_REQUEST["transfertype"];
	if ($length1<25 && $length2<255)
	{
	$query4 = "select * from master_tax where auto_number = '$taxanum'";// and cstid='$custid' and cstname='$custname'";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res4 = mysqli_fetch_array($exec4);
		$res4taxname = $res4["taxname"];

		
		$res4packagename = $itemname_abbreviation;
		
		/*$query54 = "select * from master_manufacturerpharmacy where auto_number = '$manufacturername'";// and cstid='$custid' and cstname='$custname'";
		$exec54 = mysql_query($query54) or die ("Error in Query4".mysql_error());
		$res54 = mysql_fetch_array($exec54);
		$res4manufacturername = $res54["manufacturername"];*/

		//$ratecolumn = '_rateperunit';
			$query1 = "update master_medicine set itemcode='$itemcode', itemname='$itemname', categoryname='$categoryname', unitname_abbreviation='$res4packagename', packagename='$res4packagename',rateperunit='$rateperunit', expiryperiod='$expiryperiod',
			 taxanum='$taxanum', taxname='$res4taxname', ipaddress='$ipaddress', updatetime='$updatedatetime', description='$description', purchaseprice='$purchaseprice',genericname='$genericname',exclude='$exclude',minimumstock='$minimumstock',maximumstock='$maximumstock',rol='$rol',roq='$roq',ipmarkup='$ipmarkup',spmarkup='$spmarkup',formula='$formula',type='$type',disease='$disease',pkg='".$pkg."',ledgername='$ledgername',ledgercode='$ledgercode',ledgerautonumber='$ledgerautonumber',`LTC-1_rateperunit`='$rateperunit',transfertype='$transfertype',incomeledgercode = '$incomeledgercode', incomeledger = '$incomeledgername', inventoryledgercode = '$inventoryledgercode', inventoryledgername = '$inventoryledgername' where itemcode='$itemcode'";
			
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	       $query2 = "update master_itempharmacy set itemcode='$itemcode', itemname='$itemname', categoryname='$categoryname', unitname_abbreviation='$res4packagename', packagename='$res4packagename', rateperunit='$rateperunit', expiryperiod='$expiryperiod',
			 taxanum='$taxanum', taxname='$res4taxname', ipaddress='$ipaddress', updatetime='$updatedatetime', description='$description', purchaseprice='$purchaseprice',genericname='$genericname',exclude='$exclude',type='$type',
			 minimumstock='$minimumstock',maximumstock='$maximumstock',rol='$rol',roq='$roq',ipmarkup='$ipmarkup',spmarkup='$spmarkup',formula='$formula',disease='$disease',pkg='".$pkg."',ledgername='$ledgername',ledgercode='$ledgercode',ledgerautonumber='$ledgerautonumber',transfertype='$transfertype',incomeledgercode = '$incomeledgercode', incomeledger = '$incomeledgername',inventoryledgercode = '$inventoryledgercode', inventoryledgername = '$inventoryledgername' where itemcode='$itemcode'";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			
		 /*<?php?>$query1 = "insert into master_renewal (itemcode, itemname, renewalmonths, ipaddress, updatetime) 
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
		

	
	}
	else
	{
		$errmsg = "Failed. pharmacy Item Code Should Be 25 Characters And Name Should Be 255 Characters.";
		$bgcolorcode = 'failed';
	}
	header("location:pharmacyitem21.php");

}
else
{
	$itemname = '';
	$rateperunit  = '0.00';
	$purchaseprice  = '0.00';
	$description='';
	$referencevalue = '';
	}
	
	//$itemcode = '';

	


if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_medicine set status = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_medicine set status = '' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}


if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add pharmacy Item To Proceed For Billing.";
	$bgcolorcode = 'failed';
}

if (isset($_REQUEST["searchflag1"])) { $searchflag1 = $_REQUEST["searchflag1"]; } else { $searchflag1 = ""; }
if (isset($_REQUEST["searchflag2"])) { $searchflag2 = $_REQUEST["searchflag2"]; } else { $searchflag2 = ""; }
if (isset($_REQUEST["search1"])) { $search1 = $_REQUEST["search1"]; } else { $search1 = ""; }
if (isset($_REQUEST["search2"])) { $search2 = $_REQUEST["search2"]; } else { $search2 = ""; }


if (isset($_REQUEST["itemcode"])) { $itemcode = $_REQUEST["itemcode"]; } else { $itemcode = ""; }
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
		$transfertype = $res65['transfertype'];
		$ledgername = $res65['ledgername'];
		$ledgerautonumber = $res65['ledgerautonumber'];
		$ledgercode = $res65['ledgercode'];
		$incomeledger = $res65['incomeledger'];
		$incomeledgercode = $res65['incomeledgercode'];
		$inventoryledgername = $res65['inventoryledgername'];
		$inventoryledgercode = $res65['inventoryledgercode'];
	
		
		$query11 = "select * from master_tax where taxname='$taxname' and status <> 'deleted' order by taxname";
						$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
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
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
<link href="../hospitalmillennium/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.ui-menu .ui-menu-item{ zoom:1.3 !important; }

</style>
</head>
<script language="javascript">


function changesale()
{
	var costprice1=document.getElementById("costprice").value;
	parseFloat(costprice1); 
	var spmarkup = document.getElementById("spmarkup").value;
	parseFloat(spmarkup);
	
	var salesprice=(parseFloat(spmarkup)/100);
	var salesprice1=parseFloat(salesprice)*parseFloat(costprice1);
	var salesprice2=parseFloat (salesprice1)+parseFloat(costprice1);
	//alert(salesprice);
	document.getElementById("rateperunit2").value=salesprice2.toFixed(2);
}

function totalamount()
{
var costprice1=document.getElementById("costprice").value;
parseFloat(costprice1);
//alert(costprice1);
var spmarkup = document.getElementById("spmarkup").value;
parseFloat(spmarkup);
//var costprice1 = parseFloat(totalamount)/parseFloat(tot);
if(spmarkup==0)
{
var salepricemarkup = parseFloat(spmarkup);	

var saleprice = parseFloat(salepricemarkup);
}
else
{
var salepricemarkup = (parseFloat(costprice1) * parseFloat(spmarkup))/100;

var saleprice = parseFloat(costprice1) + parseFloat(salepricemarkup);
//alert(costprice1)

//var spmarkupfinal=(parseFloat(spmarkup) / parseFloat(costprice1))*100;
//alert(spmarkuptotal);
//parseFloat(saleprice);
}
//alert(saleprice);
document.getElementById("rateperunit2").value=saleprice.toFixed(2);
//document.getElementById("spmarkup").value=spnew.toFixed(2);
//alert(spnew);

}

function changesp()
{
	//alert();
var costprice1=document.getElementById("costprice").value;
var saleprice = document.getElementById("rateperunit2").value;
var spmarkup = document.getElementById("spmarkup").value;

var spmarkuptotal=  (parseFloat(saleprice)-parseFloat(costprice1));///parseFloat(costprice1);
var markuptotal=  (parseFloat(spmarkuptotal)/parseFloat(costprice1));
var spnew=(parseFloat(markuptotal))*100;
//alert(spnew);
document.getElementById("spmarkup").value=spnew.toFixed(2);

}

function additem1process1()
{
	//alert ("Inside Funtion");
	if (document.form1.itemcode.value == "")
	{	
		alert ("Please Enter pharmacy Item Code or ID.");
		document.form1.itemcode.focus();
		return false;
	}
	if(document.form1.inv_accountid.value == "")
	{
		alert ("Please select Inventory ledger");
		document.form1.inv_accountname.focus();
		return false;
	}
	if (document.form1.itemcode.value != "")
	{	
		var data = document.form1.itemcode.value;
		//alert(data);
		// var iChars = "!%^&*()+=[];,.{}|\:<>?~"; //All special characters.*
		var iChars = "!^+=[];,{}|\<>?~$'\"@#%&*()-_`. "; 
		for (var i = 0; i < data.length; i++) 
		{
			if (iChars.indexOf(data.charAt(i)) != -1) 
			{
				//alert ("Your radiology Item Name Has Blank White Spaces Or Special Characters. Like ! ^ + = [ ] ; , { } | \ < > ? ~ $ ' \" These are not allowed.");
				alert ("Your pharmacy Item Code Has Blank White Spaces Or Special Characters. These Are Not Allowed.");
				//return false;
			}
		}
	}
	if (document.form1.itemname.value == "")
	{
		alert ("Pleae Enter pharmacy Item Name.");
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
	if (document.form1.purchaseprice.value == "")
	{	
		alert ("Please Enter Purchase Price Per Unit.");
		document.form1.purchaseprice.focus();
		return false;
	}
	if (document.form1.rateperunit.value == "")
	{	
		alert ("Please Enter Selling Price Per Unit.");
		document.form1.rateperunit.focus();
		return false;
	}
	if (document.form1.type.value == "")
	{	
		alert ("Please Select Type.");
		document.form1.type.focus();
		return false;
	}
	
	if (isNaN(document.form1.rateperunit.value) == true)
	{	
		alert ("Please Enter Rate Per Unit In Numbers.");
		document.form1.rateperunit.focus();
		return false;
	}
	if (document.form1.rateperunit.value == "0.00")
	{
		var fRet; 
		fRet = confirm(' Are You Sure You Want To Continue To Save?'); 
		//alert(fRet);  // true = ok , false = cancel
		if (fRet == false)
		{
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
*/	}
/*	else if (document.form1.itemname_abbreviation.value == "SR")
	{
		if (document.form1.expiryperiod.value == "")
		{	
			alert ("Please Select Expiry Period.");
			document.form1.expiryperiod.focus();
			return false;
		}
	}
*/}

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
function spl()
{
	var data=document.form1.itemname.value ;
	//alert(data);
	// var iChars = "!%^&*()+=[];,.{}|\:<>?~"; //All special characters.
	var iChars = "!^+=[];,{}|\<>?~"; 
	for (var i = 0; i < data.length; i++) 
	{
		if (iChars.indexOf(data.charAt(i)) != -1) 
		{
			alert ("Your pharmacy Item Name Has Special Characters. Like ! ^ + = [ ] ; , { } | \ < > ? ~ These are not allowed.");
			return false;
		}
	}
}
 
 
function process2()
{
	
	//document.getElementById('expiryperiod').style.visibility = 'hidden';
}

function process1backkeypress1()
{
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}
	
	if(key == 13) // if enter key press
	{
		return false;
	}
	else
	{
		return true;
	}

}

function calculatepersent(val)
{
	//alert(val);
	var original=document.getElementById("costprice").value;
	var newnumber=document.getElementById("rateperunit2").value;// alert(newnumber);
	var decrease=parseFloat(original)-parseFloat(newnumber);
	var persent=(parseFloat(decrease)/parseFloat(original))*100;
	//alert(persent);
	document.getElementById("spmarkup").value=Math.abs(persent).toFixed(2);
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
		
	source:'accountnameajax.php', 
	
	minLength:2,
	delay: 0,
	html: true, 
		select: function(event,ui){
				var saccountauto=ui.item.saccountauto;
				var saccountid=ui.item.saccountid;
				$('#saccountauto').val(saccountauto);	
				$('#saccountid').val(saccountid);	
			}
    });
	
	$('#iaccountname').autocomplete({
		
	source:'accountnameajax1.php', 
	
	minLength:2,
	delay: 0,
	html: true, 
		select: function(event,ui){
				var saccountauto=ui.item.saccountauto;
				var saccountid=ui.item.saccountid;
				$('#iaccountauto').val(saccountauto);	
				$('#iaccountid').val(saccountid);	
			}
    });
	
	$('#inv_accountname').autocomplete({
		
	source:'accountnameajax2.php', 
	
	minLength:2,
	delay: 0,
	html: true, 
		select: function(event,ui){
				var saccountauto=ui.item.saccountauto;
				var saccountid=ui.item.saccountid;
				$('#inv_accountauto').val(saccountauto);	
				$('#inv_accountid').val(saccountid);	
			}
    });
});
</script>


<body onLoad="return process2()">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td><form name="form1" id="form1" method="post" action="editpharmacyitem21.php" onSubmit="return additem1process1()">
                  <table width="1072" border="0" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Pharmacy Item Master - Add New </strong></td>
                      </tr>
					  <?php if ($st==1)
					  {?>
					  <tr>
                        <td colspan="4" align="left" valign="middle"   bgcolor="#AAFF00"><font size="2">Sorry Special Characters Are Not Allowed</font></div></td>
                      </tr>
					  <?php }?>
                      <tr>
                        <td colspan="4" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; }else if ($bgcolorcode == 'fail') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?>&nbsp;</div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Select Category Name  </div></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><select id="categoryname" name="categoryname" >
                          <?php
						if ($categoryname != '')
						{
						?>
                          <option value="<?php echo $categoryname; ?>" selected="selected"><?php echo $categoryname; ?></option>
                          <?php
						}
						else
						{
						?>
                          <option value="" selected="selected">Select Category</option>
                          <?php
						}
						$query1 = "select * from master_categorypharmacy where status <> 'deleted' order by categoryname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1categoryname = $res1["categoryname"];
						?>
                          <option value="<?php echo $res1categoryname; ?>"><?php echo $res1categoryname; ?></option>
                          <?php
						}
						?>
                        </select>
                          <a href="pharmacycategory1.php"><font  class="bodytext32" color="#000000">(Click Here To Add New Category)</font></a></td>
                         <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">Generic Name</td>
                         <td align="left" valign="top"  bgcolor="#ecf0f5"><a href="pharmacycategory1.php"></a>
                           <select id="genericname" name="genericname">
						     <?php
						if ($genericname != '')
						{
						?>
                          <option value="<?php echo $genericname; ?>" selected="selected"><?php echo $genericname; ?></option>
                          <?php
						}
						else
						{
						?>
                             <option value="" selected="selected">Select Generic Name</option>
                             <?php
							 }
						$query111 = "select * from master_genericname where recordstatus = '' ";
						$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res111 = mysqli_fetch_array($exec111))
						{
						$res111genericname = $res111['genericname'];
						?>
                             <option value="<?php echo $res111genericname; ?>"><?php echo $res111genericname; ?></option>
                             <?php
						  }
						  ?>
                           </select></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> <div align="left">New Pharmacy Item Code </div></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input name="itemcode" value="<?php echo $itemcode; ?>" id="itemcode" readonly onKeyDown="return process1backkeypress1()" style="border: 1px solid #001E6A; background-color:#ecf0f5" size="20" maxlength="100" />
                          <span class="bodytext32">( Example : PRD1234567890 ) </span></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">Exclude</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="checkbox" name="exclude"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Add New Pharmacy Item Name </div></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input name="itemname" type="text" id="itemname" style="border: 1px solid #001E6A" onChange="return spl()" value="<?php echo $itemname; ?>" size="60"></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">Min Stock</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="text" name="minimumstock" id="minimumstock" style="border: 1px solid #001E6A" value="<?php echo $minimumstock; ?>"></td>
                      </tr>
                   
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Sales Price</div></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input name="rateperunit2" id="rateperunit2"  onKeyUp="return changesp()" style="border: 1px solid #001E6A" value="<?php echo $rateperunit; ?>" size="20"/>                        </td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">Max Stock</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="text" name="maximumstock" id="maximumstock" style="border: 1px solid #001E6A" value="<?php echo $maximumstock; ?>"></td>
                      </tr>
				  
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Formula</div></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><select id="formula" name="formula">
                          <?php
						if ($formula1 != '')
						{
						?>
                          <option value="<?php echo $formula1; ?>" selected="selected"><?php echo $formula1; ?></option>
                          <?php
						}
						else
						{
						?>
                          <option value="" selected="selected">Select Formula</option>
                          <?php
						}
						
                         ?>
						 <option value="CONSTANT">CONSTANT</option>
						  <option value="INCREMENT">INCREMENT</option>
                        </select></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">ROL</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="text" name="rol" style="border: 1px solid #001E6A" value="<?php echo $rol; ?>"></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Select Pharmacy Package </div></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><select id="packageanum" name="packageanum">
                          <option value="">Select Pack</option>
						  	  <?php
						if ($itemname_abbreviation != '')
						{
						?>
                          <option value="<?php echo $itemname_abbreviation; ?>" selected="selected"><?php echo $itemname_abbreviation; ?></option>
                          <?php
						}
						else
						{
						?>
						<option value="">Select Pack</option>
                          <?php
						  }
						$query1 = "select * from master_packagepharmacy where status <> 'deleted' order by packagename";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1anum = $res1['auto_number'];
						$res1packagename = $res1["packagename"];
						$res1packagename = stripslashes($res1packagename);
						$quantityperpackage = $res1["quantityperpackage"];
						$quantityperpackage = round($quantityperpackage);
						?>
                          <option value="<?php echo $res1packagename; ?>"><?php echo $res1packagename.' ( '.$quantityperpackage.' ) '; ?></option>
                          <?php
						}
						?>
                        </select></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">Strength</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="text" name="roq" style="border: 1px solid #001E6A" value="<?php echo $roq; ?>"></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Select Applicable Tax </div></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><select id="taxanum" name="taxanum">
                          <option value="">Select Tax</option>
						  <?php
						  if ($taxname != '')
						{
						?>
						 <option value="<?php echo $res11anum; ?>" selected="selected"><?php echo $taxname.' ( '.$res11taxpercent.'% ) '; ?></option>
						     <?php
						}
						else
						{
						?>
						<option value="">Select Tax</option>
                          <?php
						  }
						$query1 = "select * from master_tax where status <> 'deleted' order by taxname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1taxname = $res1["taxname"];
						$res1taxpercent = $res1["taxpercent"];
						$res1anum = $res1["auto_number"];
						?>
                          <option value="<?php echo $res1anum; ?>"><?php echo $res1taxname.' ( '.$res1taxpercent.'% ) '; ?></option>
                          <?php
						}
						?>
                        </select>
                          <input name="rateperunit" type="hidden" id="rateperunit" style="border: 1px solid #001E6A" value="<?php echo $rateperunit; ?>" size="20" />
                          <input type="hidden" name="purchaseprice" id="purchaseprice" style="border: 1px solid #001E6A" value="<?php echo $purchaseprice; ?>" size="20" />
                          <input name="description" type="hidden" id="description" style="border: 1px solid #001E6A" value="<?php echo $description; ?>" size="50">
                          <input type="hidden" name="unitname_abbreviation" id="unitname_abbreviation" value="NOS"></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">IP Mark up</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="text" name="ipmarkup" style="border: 1px solid #001E6A" value="<?php echo $ipmarkup; ?>"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">Cost Price</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="text" name="costprice" id="costprice" onKeyUp="return totalamount();" style="border: 1px solid #001E6A" value="<?php echo $purchaseprice; ?>"></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">SP Mark up</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="text" name="spmarkup" onKeyUp="return changesale(); "  id="spmarkup" style="border: 1px solid #001E6A" value="<?php echo $spmarkup; ?>"></td>
                      </tr>
					   <tr>
                        <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">Disease</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="text" name="disease" id="disease" style="border: 1px solid #001E6A" value="<?php echo $disease; ?>"></td>
                        <td align="left" valign="top" class="bodytext3"  bgcolor="#ecf0f5" >Type</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5" >
                        <select name="type" id="type" >
                        <?php if($type!='')
						{
							?>
                       	<option value="<?php echo $type; ?>"><?php echo $type; ?></option>
							<option value="">Select</option>
							<option value="Assets">Assets</option>
						    <option value="General Purchases">General Purchases</option>
						    <option value="IT Assets">IT Assets</option>
						    <option value="Linen">Linen</option>
						    <option value="Maintenance">Maintenance</option>
                            <option value="Stationery & Printing">Stationery & Printing</option>
						    </select> 
                          <?php
                         }
						 else
						 {
						 ?>
                         	<option value="">Select</option>
							<option value="assets">Assets</option>
						    <option value="CAFETERIA">CAFETERIA</option>
						    <option value="I.T Consumable">I.T Consumable</option>
						      <option value="LAUNDRY">LAUNDRY</option>
						       <option value="STATIONERY">STATIONERY</option>
                          <?php
						 }
                          ?>  
                          </select>  </td>
                      </tr>
                     
                      <tr >
                       <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">Package</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="checkbox" name="pkg" <?php if($pkg=='yes'){echo "checked";}?> value="yes"></td>
                       
                   	   <td width="13%" align="left" valign="top"  bgcolor="#ecf0f5"  class="bodytext3">Income Ledger</td>
                        <td width="33%" align="left" valign="top"  bgcolor="#ecf0f5"> 
                        <input type="text" name="saccountname" id="saccountname" size="30" value="<?= $ledgername ?>" />
                        <input type="hidden" name="saccountauto" id="saccountauto" value="<?= $ledgerautonumber ?>" />
                        <input type="hidden" name="saccountid" id="saccountid" value="<?= $ledgercode ?>" />
                         </td>
                    
                     </tr>
                      <tr >
                        <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">Transfer Type</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><select name="transfertype" id="transfertype" >
                          <option value="">Select</option>
                          <option value="0" <?php if($transfertype=='0') echo 'selected'; ?>>Transfer</option>
                          <option value="1" <?php if($transfertype=='1') echo 'selected'; ?>>Consumable</option>
							</select>  </td>
                        <td width="13%" align="left" valign="top"  bgcolor="#ecf0f5"  class="bodytext3">COGS Ledger</td>
                        <td width="33%" align="left" valign="top"  bgcolor="#ecf0f5"> 
                        <input type="text" name="iaccountname" id="iaccountname" size="30" value="<?= $incomeledger ?>" />
                        <input type="hidden" name="iaccountauto" id="iaccountauto" value="" />
                        <input type="hidden" name="iaccountid" id="iaccountid" value="<?= $incomeledgercode ?>" />
                         </td>
                      </tr>
                     
					 <tr>
                        <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>
                        <td width="13%" align="left" valign="top"  bgcolor="#ecf0f5"  class="bodytext3">Inventory Ledger</td>
                        <td width="33%" align="left" valign="top"  bgcolor="#ecf0f5"> 
                        <input type="text" name="inv_accountname" id="inv_accountname" size="30" value="<?= $inventoryledgername; ?>"  />
                        <input type="hidden" name="inv_accountauto" id="inv_accountauto" value=""  />
                        <input type="hidden" name="inv_accountid" id="inv_accountid" value="<?= $inventoryledgercode ?>" />
                         </td>
                      </tr>
                      <tr>
                       <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3"></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"></td>
                       
                        <td width="13%" align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>
                        <td width="33%" align="left" valign="top"  bgcolor="#ecf0f5"><input type="hidden" name="frmflag1" value="frmflag1" />
                          <input type="hidden" name="frmflag" value="addnew" />
                          <input type="submit" name="Submit" value="Save Pharmacy Item" style="border: 1px solid #001E6A" /></td>
                      </tr>
                    </tbody>
                  </table>
				  </form>
					                  </td>
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

