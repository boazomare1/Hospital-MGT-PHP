<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$sno = '';
$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

$locationname  = $res["locationname"];

$locationcode = $res["locationcode"];

//to redirect if there is no entry in masters category or item.
$query90 = "select count(auto_number) as masterscount from master_lab";
$exec90 = mysqli_query($GLOBALS["___mysqli_ston"], $query90) or die ("Error in Query90".mysqli_error($GLOBALS["___mysqli_ston"]));
$res90 = mysqli_fetch_array($exec90);
$res90count = $res90["masterscount"];
if ($res90count == 0)
{
	header ("location:addcategory1lab.php?svccount=firstentry");
}


if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
$code = $_REQUEST['itemcode'];


$query78 = "delete from master_lab where itemcode='$code'";
$exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$query79 = "update master_labreference set status = 'deleted' where itemcode='$code'";
$exec79 = mysqli_query($GLOBALS["___mysqli_ston"], $query79) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	for($i=1;$i<20;$i++)
	{	
		if(isset($_REQUEST['chk'.$i]))
		{	
			$serialno = $_REQUEST['chk'.$i];
			if($serialno != '')
			{	
				$locationcode = $_REQUEST['chk'.$i];
				$rateperunit = $_REQUEST['rateperunit'.$i];
			

		foreach($_POST['reference'] as $key => $value)
	{
    $subheader = $_POST['subheader'][$key];
	$reference = $_POST['reference'][$key];
	$units = $_POST['units'][$key];
	//$range = $_POST['range'][$key];
	$criticallow = $_POST['rangelow'][$key];
	$criticalhigh = $_POST['rangehigh'][$key];
	$gender = $_POST['gender'][$key];
	$agelimitfrom = $_POST['agelimitfrom'][$key];
	$agelimitto = $_POST['agelimitto'][$key];

	$refrange_label = $_POST['refrange_label'][$key];

	$reforder = $_POST['reforder'][$key];
	$refcode = $_POST['refcode'][$key];
	$genericsearch = $_POST['genericsearch'][$key];
	if(isset($_REQUEST['refanum'][$key])) { $refanum = $_REQUEST['refanum'][$key]; } else { $refanum = ''; }
	
	//$range = $criticallow.' - '.$criticalhigh;
	$range = $subheader;
	
	$itemcode = $_REQUEST['itemcode'];		
	
	$saccountname = $_REQUEST["saccountname"];
	$saccountid = $_REQUEST["saccountid"]; 

	$itemname = $_REQUEST["itemname"];
	$displayname = $_REQUEST["displayname"];
	//$itemname = strtoupper($itemname);
	$itemname = trim($itemname);
	$displayname = trim($displayname);
	//echo "simple";
	$length1=strlen($itemcode);
	$length2=strlen($itemname);
	//! ^ + = [ ] ; , { } | \ < > ? ~
	//if (preg_match ('/[+,|,=,{,},(,)]/', $itemname))
	if (preg_match ('/[!,^,+,=,[,],;,,,{,},|,\,<,>,?,~]/', $itemname))
	{  
		//echo "inside if";
		$bgcolorcode = 'fail';
		$errmsg="Sorry. lab Item Not Added";
		
		header("location:labitem1.php?st=1");
		exit();
	}
	$itemname = addslashes($itemname);
	$displayname = addslashes($displayname);
	
	$categoryname = $_REQUEST["categoryname"];
	$purchaseprice  = $_REQUEST["purchaseprice"];
	//$rateperunit  = $_REQUEST["rateperunit"];
	$expiryperiod = '';
	$description=$_REQUEST["description"];
	$sampletype=$_REQUEST["sampletype"];
	$referencevalue = $_REQUEST["referencevalue"];
	$itemname_abbreviation = $_REQUEST["unitname_abbreviation"];
	$taxanum = $_REQUEST["taxanum"];
	$ledgercode = $_REQUEST["ledgercode"];
	
	$query4 = "select * from master_tax where auto_number = '$taxanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	
	$res4taxname = $res4["taxname"];
	
	$ipmarkup = $_REQUEST["ipmarkup"];
	//$locationcode = ;
	$querynw21 = "select * from master_location where locationcode = '$locationcode'";//
	$execnw21 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
	$numnw21 = mysqli_num_rows($execnw21);
	$resnw21 = mysqli_fetch_array($execnw21);
	$locationname = $resnw21['locationname'];
	$rate2 = $_REQUEST['rate2'];
	$rate3 = $_REQUEST['rate3'];
	if(isset($_REQUEST['externallab'])) { $externallab = $_REQUEST['externallab']; } else { $externallab = 'no'; }
	if(isset($_REQUEST['exclude'])) { $exclude = $_REQUEST['exclude']; } else { $exclude = 'no'; }
	if(isset($_REQUEST['pkg'])) { $pkg = $_REQUEST['pkg']; } else { $pkg = 'no'; }
	if(isset($_REQUEST['radiology'])) { $radiology = $_REQUEST['radiology']; } else { $radiology = 'no'; }
	
	if ($length1<25 && $length2<255)
	{
		if($reference != '')
		{	
			$query25 = "select * from master_labreference where itemcode = '$itemcode' and auto_number = '$refanum' and location = '$locationcode'";// or itemname = '$itemname'";
			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res25 = mysqli_num_rows($exec25);
			$res = mysqli_fetch_array($exec25);
			$resanum = $res['auto_number'];
			if($resanum == '')
			{	
				$query251 = "select * from master_labreference where itemcode = '$itemcode' and referencename = '$reference' and gender = '$gender' and criticallow = '$criticallow' and criticalhigh = '$criticalhigh' and agefrom='$agelimitfrom' and ageto = '$agelimitto' and refcode = '$refcode' and location = '$locationcode'";// or itemname = '$itemname'";
				$exec251 = mysqli_query($GLOBALS["___mysqli_ston"], $query251) or die ("Error in Query251".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res251 = mysqli_num_rows($exec251);
				if($res251 == 0)
				{
					$query1 = "insert into master_labreference (itemcode, itemname, categoryname, itemname_abbreviation, rateperunit, expiryperiod, taxanum, taxname, ipaddress, updatetime, description, purchaseprice, referencevalue,ipmarkup,sampletype,location,locationname,referencename,referenceunit,referencerange,rate2,rate3,criticallow,criticalhigh,displayname,gender,agefrom,ageto,refrange_label,subheader,reforder,refcode,generic_search) 
					values ('$itemcode', '$itemname', '$categoryname', '$itemname_abbreviation', '', '', '', '', '$ipaddress', '$updatedatetime','', '', '$referencevalue','$ipmarkup','$sampletype','$locationcode','$locationname','$reference','$units','$range','$rate2','$rate3','$criticallow','$criticalhigh','$displayname','$gender','$agelimitfrom','$agelimitto','$refrange_label','$subheader','$reforder','$refcode','$genericsearch')";
					$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));	
				}	
			}
			else
			{
				$query251 = "UPDATE master_labreference set itemcode = '$itemcode', itemname = '$itemname', status = '' ,categoryname = '$categoryname', itemname_abbreviation = '$itemname_abbreviation', referencename = '$reference' , updatetime = '$updatedatetime', referencevalue = '$referencevalue', gender = '$gender' ,criticallow = '$criticallow', referenceunit = '$units', referencerange = '$range' ,criticalhigh = '$criticalhigh' , agefrom='$agelimitfrom' , ageto = '$agelimitto', refrange_label = '$refrange_label',reforder = '$reforder', subheader = '$subheader',refcode='$refcode',generic_search='$genericsearch' where itemcode = '$itemcode' and auto_number = '$resanum'";// or itemname = '$itemname'";
				$exec251 = mysqli_query($GLOBALS["___mysqli_ston"], $query251) or die ("Error in Query251".mysqli_error($GLOBALS["___mysqli_ston"]));
			}	
		}

		$query24 = "select * from master_lab where itemcode = '$itemcode' and location = '$locationcode'";// or itemname = '$itemname'";
		$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res24 = mysqli_num_rows($exec24);
		if($res24 == 0)
		{
		 	$query111 = "insert into master_lab (itemcode, itemname, categoryname, itemname_abbreviation, rateperunit, expiryperiod, taxanum, taxname, ipaddress, updatetime, description, purchaseprice, referencevalue,ipmarkup,sampletype,location,locationname,rate2,rate3,displayname,externallab,exclude,pkg,radiology,username,ledgercode) 
			values ('$itemcode', '$itemname', '$categoryname', '$itemname_abbreviation', '$rateperunit', '$expiryperiod', '$taxanum', '$res4taxname', '$ipaddress', '$updatedatetime','$description', '$purchaseprice', '$referencevalue','$ipmarkup','$sampletype','$locationcode','$locationname','$rate2','$rate3','$displayname','$externallab','$exclude','$pkg', '$radiology','$username','$saccountid')";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		
		
			 $query25 = 'SELECT templatename FROM `master_testtemplate` where testname="lab"';
			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res25 = mysqli_fetch_array($exec25))
			{
				$templatename = $res25["templatename"];
				
				$query241 = "select * from $templatename where itemcode = '$itemcode' ";// or itemname = '$itemname'";
			$exec241 = mysqli_query($GLOBALS["___mysqli_ston"], $query241) or die ("Error in Query241".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res241 = mysqli_num_rows($exec241);
			if($res241 > 0)
			{
				
				 $querytemp1 = "UPDATE `$templatename` set itemcode = '$itemcode', itemname = '$itemname', status = '' ,categoryname = '$categoryname', itemname_abbreviation = '$itemname_abbreviation', updatetime = '$updatedatetime', referencevalue = '$referencevalue' where itemcode = '$itemcode'";// or itemname = '$itemname'";
				 $exectemp1 = mysqli_query($GLOBALS["___mysqli_ston"], $querytemp1) or die ("Error in querytemp1".mysqli_error($GLOBALS["___mysqli_ston"]));	
			}
		}
	
		 
			$errmsg = "Success. New Lab Item Updated.";
			$bgcolorcode = 'success';
			$itemcode = '';
			$itemname = '';
			$rateperunit  = '0.00';
			$purchaseprice  = '0.00';
			$description = '';
			$referencevalue = '';

			//$itemcode = '';	
		header("location:labitem1master.php"); //commented
		
	
	}
	else
	{
		$errmsg = "Failed. lab Item Code Should Be 25 Characters And Name Should Be 255 Characters.";
		$bgcolorcode = 'failed';
	}
}	

			}	
		}
	}	
//header("location:labitem1.php");
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
if (isset($_REQUEST["itemcode"])) { $itemcode = $_REQUEST["itemcode"]; } else { $itemcode = ""; }
		
	$query67 = "select * from master_lab where itemcode='$itemcode'";
	$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res67 = mysqli_fetch_array($exec67);
	$itemname = $res67['itemname'];
	$rate1 = $res67['rateperunit'];
	$rate2 = $res67['rate2'];
	$rate3 = $res67['rate3'];
	$ipmarkup = $res67['ipmarkup'];
	$location = $res67['location'];
	$sampletype = $res67['sampletype'];
    $unit = $res67['itemname_abbreviation'];
	$category= $res67['categoryname'];
	$taxanum = $res67['taxanum'];
	$referencevalue = $res67['referencevalue'];
	$taxname= $res67['taxname'];
	$displayname = $res67['displayname'];
	$externallab = $res67['externallab'];
	$exclude = $res67['exclude'];
	$pkg1 = $res67['pkg'];
	$radiology = $res67['radiology'];
	$description = $res67['description'];
	$ledgercode= $res67['ledgercode'];

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_lab set status = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_lab set status = '' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}


if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add lab Item To Proceed For Billing.";
	$bgcolorcode = 'failed';
}

if (isset($_REQUEST["searchflag1"])) { $searchflag1 = $_REQUEST["searchflag1"]; } else { $searchflag1 = ""; }
if (isset($_REQUEST["searchflag2"])) { $searchflag2 = $_REQUEST["searchflag2"]; } else { $searchflag2 = ""; }
if (isset($_REQUEST["search1"])) { $search1 = $_REQUEST["search1"]; } else { $search1 = ""; }
if (isset($_REQUEST["search2"])) { $search2 = $_REQUEST["search2"]; } else { $search2 = ""; }
?>

<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
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
</style>
</head>
<script type="text/javascript" src="js/insertnewitemlab.js"></script>
<script src="js/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
  <script>
 

$(function() {

    $('#saccountname').autocomplete({
		
	//source:'accountnameradajax.php', 
	source: 'accountnamefinanceajax.php',
	
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
	
	
});
</script>
<script language="javascript">

function additem1process1()
{
	//alert ("Inside Funtion");
	if (document.form1.categoryname.value == "")
	{	
		alert ("Please Select Category Name.");
		document.form1.categoryname.focus();
		return false;
	}
	if (document.form1.itemcode.value == "")
	{	
		alert ("Please Enter lab Item Code or ID.");
		document.form1.itemcode.focus();
		return false;
	}
	// if (document.form1.saccountid.value == "")
	// {	
	// 	alert ("Please select income ledger.");
	// 	document.form1.saccountname.focus();
	// 	return false;
	// }
	///////////////
	if (document.form1.saccountid.value == "")
	{	
		alert ("Please select Income ledger.");
		document.form1.saccountname.focus();
		return false;
	}
	if (document.form1.saccountname.value == "")
	{
		alert ("Please Select Income ledger Name.");
		document.form1.saccountname.focus();
		return false;
	}
	/////////////////////////////////
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
				//alert ("Your lab Item Name Has Blank White Spaces Or Special Characters. Like ! ^ + = [ ] ; , { } | \ < > ? ~ $ ' \" These are not allowed.");
				alert ("Your lab Item Code Has Blank White Spaces Or Special Characters. These Are Not Allowed.");
				return false;
			}
		}
	}
	if (document.form1.itemname.value == "")
	{
		alert ("Pleae Enter lab Item Name.");
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
	
	if (isNaN(document.form1.rateperunit.value) == true)
	{	
		alert ("Please Enter Rate Per Unit In Numbers.");
		document.form1.rateperunit.focus();
		return false;
	}
	if (document.form1.rateperunit.value == "0.00")
	{
		var fRet; 
		fRet = confirm('Rate Per Unit Is 0.00, Are You Sure You Want To Continue To Save?'); 
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
			alert ("Your lab Item Name Has Special Characters. Like ! ^ + = [ ] ; , { } | \ < > ? ~ These are not allowed.");
			return false;
		}
	}
}

function AddDisplayname()
{
	var Name = document.getElementById("itemname").value;
	
	document.getElementById("displayname").value = Name;
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

function btnDeleteClick10(delID)
{
	//alert ("Inside btnDeleteClick.");
	var varDeleteID = delID;
	//alert (varDeleteID);
	var fRet3; 
	fRet3 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet3 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child = document.getElementById('idTR'+varDeleteID);  //tr name
	
    var parent = document.getElementById('insertrow'); // tbody name.
	document.getElementById('insertrow').removeChild(child);
		
	var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	//alert (child);
	if (child != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow').removeChild(child);
		
		
	}
	

}
</script>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 ,.bodytext12,.bodytext11{	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
<style type="text/css">
<!--
.bodytext13,.bodytext21 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.pagination{float:right;}
-->
</style>
<?php /*?><?php include ("includes/header.php"); ?><?php */?>
<link rel="stylesheet" href="main.css" type="text/css" />
<body onLoad="return process2()">
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
    <td width="97%" valign="top">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:22px 41px">
        <tr>
          <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td><form name="form1" id="form1" method="post" action="edititem1labmaster.php" onSubmit="return additem1process1()">
                <table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr >
                      <td colspan="4"  bgcolor="#ecf0f5" class="bodytext3"><strong>Lab Item Master - Edit </strong></td>
                    </tr>
                    <?php if ($st==1)
					  {?>
                    <tr>
                      <td colspan="4" align="left" valign="middle" class="bodytext13" bgcolor="#AAFF00"><font size="2">Sorry Special Characters Are Not Allowed</font></td>
                    </tr>
                    <?php }?>
                    <tr>
                      <td colspan="4" align="left" valign="middle" class="bodytext13"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; }else if ($bgcolorcode == 'fail') { echo '#AAFF00'; } ?>"><div align="left"><?php echo $errmsg; ?>&nbsp;</div></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"   class="bodytext13"><div align="left">Select Category Name </div></td>
                      <td align="left" valign="top" class="bodytext13"><select id="categoryname" name="categoryname" >
                        <option value="" selected="selected">Select Category</option>
                        <?php
						if ($category != '')
						{
						?>
                        <option value="<?php echo $category; ?>" selected="selected"><?php echo $category; ?></option>
                        <?php
						}
						else
						{
						?>
                        <option value="" selected="selected">Select Category</option>
                        <?php
						}
						$query1 = "select * from master_categorylab where status <> 'deleted'  order by categoryname";
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
                        <a href="labcategory1.php"><font  class="bodytext13" color="#000000">(Click Here To Add New Category)</font></a></td>
                      <td align="left" valign="top"   class="bodytext13">External Lab</td>
                      <td align="left" valign="top" class="bodytext13"><input type="checkbox" name="externallab" <?php if($externallab == 'yes'){ ?> checked="checked" <?php } ?> value="yes"></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"   class="bodytext13"><div align="left">New Lab Item Code </div></td>
                      <td align="left" valign="top"  ><input name="itemcode" value="<?php echo $itemcode; ?>" id="itemcode" readonly onKeyDown="return process1backkeypress1()" style="border: none;" size="20" maxlength="100" />
					  <input type="hidden" name="ledgercode" id="ledgercode" value="<?php echo $ledgercode; ?>" size="20" />
                        <span class="bodytext13">( Example : PRD1234567890 ) </span></td>
                      <td align="left" valign="top"   class="bodytext13">Exclude</td>
                      <td align="left" valign="top"  ><input type="checkbox" name="exclude" value="yes" <?php if($exclude == 'yes'){ ?> checked="checked" <?php } ?>></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"   class="bodytext13"><div align="left">Add New Lab Item Name </div></td>
                      <td align="left" valign="top"  ><input name="itemname" type="text" id="itemname" onChange="return spl()" onKeyUp="return AddDisplayname()" value="<?php echo $itemname; ?>" size="45"></td>
                      <td align="left" valign="top"   class="bodytext13">IP Mark up</td>
                      <td align="left" valign="top"  ><input type="text" name="ipmarkup"  value="<?php echo $ipmarkup; ?>"></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"   class="bodytext21"><div align="left">Lab Item Display Name </div></td>
                      <td align="left" valign="top" class="bodytext21"><input name="displayname" type="text" id="displayname" value="<?php echo $displayname; ?>" size="45"></td>
                      <td colspan="2" align="left" valign="top"   class="bodytext21">&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"   class="bodytext13"><div align="left">Select Lab Item Unit (Optional) </div></td>
                      <td align="left" valign="top"  ><input name="unitname_abbreviation" type="text" id="unitname_abbreviation" size="20" value="<?php echo $unit; ?>"></td>
                      <td align="left" valign="top"   class="bodytext13">Sample Type</td>
                      <td align="left" valign="top"  ><input name="sampletype" id="sampletype" value="<?php echo $sampletype ; ?>" size="20" /></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"   class="bodytext13"><div align="left">Lab Item Reference Value (Optional) </div></td>
                      <td align="left" valign="top"  ><textarea name="referencevalue" cols="35" id="referencevalue" ><?php echo $referencevalue; ?></textarea>
                        <input name="description" type="hidden" id="description" style="border: 1px solid #001E6A" value="<?php echo $description; ?>" size="60"></td>
                      <td align="left" valign="top"   class="bodytext13">&nbsp;</td>
                      <td align="left" valign="top"  ><!--<select name="location" id="location"><?php echo $location; ?>
						<?php
						$querynw2 = "select * from master_location where status <> 'deleted'";//
						$execnw2 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
						$numnw2=mysqli_num_rows($execnw2);
						while($resnw2 = mysqli_fetch_array($execnw2))
						{
						?>
						<option value="<?php echo $resnw2['locationcode'];?>" <?php if($location==$resnw2['locationcode']){echo "Selected";} ?>><?php echo $resnw2['locationname'];?></option>		
						<?php 
						}?>		
						</select>--></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"   class="bodytext13"><div align="left">Select Applicable Tax </div></td>
                      <td align="left" valign="top"  ><select id="taxanum" name="taxanum">
                        <option value="" selected="selected">Select Tax</option>
                        <?php
						if ($taxname != '')
						{
						?>
                        <option value="<?php echo $taxanum; ?>" selected="selected"><?php echo $taxname; ?></option>
                        <?php
						}
						else
						{
						?>
                        <option value="" selected="selected">Select Tax</option>
                        <?php
						}
						$query2 = "select * from master_tax where status <> 'deleted' group by taxname order by taxname";
						$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res2 = mysqli_fetch_array($exec2))
						{
						$res1taxname = $res2["taxname"];
						$res1taxanum = $res2['auto_number'];
						?>
                        <option value="<?php echo $res1taxanum; ?>"><?php echo $res1taxname; ?></option>
                        <?php
						}
						?>
                      </select></td>
                      <td align="left" valign="top"  >&nbsp;</td>
                      <td align="left" valign="top"  >&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="left" class="bodytext12">Package</td>
                      <td align="left" class="bodytext12"><input type="checkbox" name="pkg" id="pkg" <?php if($pkg1 == 'yes'){ echo "checked='checked'"; } ?> value="yes"></td>
                      <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">Radiology</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="checkbox"  name="radiology" <?php if($radiology == 'yes'){ echo "checked='checked'"; } ?> value="yes"></td>
                    </tr>
                    <tr>
				  	    <td width="13%" align="left" valign="top"  bgcolor="#ecf0f5"  class="bodytext3">Income Ledger</td>
                        <td width="33%" align="left" valign="top"  bgcolor="#ecf0f5"> 
                           <?php
                             // get account name
                             $query_2 = "select auto_number,id,accountname,accountssub from master_accountname where id='$ledgercode' and recordstatus <> 'deleted'";
							 $exec_2 = mysqli_query($GLOBALS["___mysqli_ston"], $query_2) or die ("Error in Query_2".mysqli_error($GLOBALS["___mysqli_ston"]));
                             //$ledgername='';
							// $ledgerauto ='';
							 while ($res_2 = mysqli_fetch_array($exec_2))
							 {
								$ledgername = $res_2['accountname'];	  
								$ledgerauto = $res_2['auto_number'];
						     }
                           ?>
                           <input type="text" name="saccountname" id="saccountname" size="30" value="<?php echo $ledgername;?>" />
                           <input type="hidden" name="saccountauto" id="saccountauto" value="<?php echo $ledgerauto;?>"/>
                           <input type="hidden" name="saccountid" id="saccountid" value="<?php echo $ledgercode;?>" />
                        </td>
                        
                                       
                     <?php
										
					$query13 = "select * from master_lab where itemcode='$itemcode' and location = '$locationcode'";
					$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$res13 = mysqli_fetch_array($exec13);
					$itemname = $res13['itemname'];
					$rate13 = $res13['rateperunit'];
			
					?>
    <td align="left" class="bodytext12"><input type="checkbox" name="chk1" id="chk1" value="<?php echo $locationcode; ?>"  checked style="display:none" style="display:none">Rate</td>
                          <td align="left" class="bodytext12"  ><input type="text" name="rateperunit1" id="rateperunit1" value="<?php echo $rate13; ?>" size="10" readOnly /></td>
				     </tr>
                    <!-- <tr>
                      <td align="left" class="bodytext12">&nbsp;</td>
                      <td align="left" class="bodytext12"><strong>Location Rate</strong></td>
                    </tr>
                    <tr>
                      <td align="left" class="bodytext12">&nbsp;</td>
                      <td colspan="3" align="left" class="bodytext12"><table border="0" width="300" cellpadding="1" cellspacing="1">-->
                       <?php /*?> <?php
					$query12 = "select * from master_location where status <> 'deleted' order by locationname";
					$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res12 = mysqli_fetch_array($exec12))
					{
					$sno = $sno + 1;
					$locationcode = $res12['locationcode'];
					$locationname = $res12['locationname'];
					
					$query13 = "select * from master_lab where itemcode='$itemcode' and location = '$locationcode'";
					$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$res13 = mysqli_fetch_array($exec13);
					$itemname = $res13['itemname'];
					$rate13 = $res13['rateperunit'];
			
					?><?php */?>
                      <!--  <tr>
                          <td align="left" class="bodytext12"><input type="checkbox" name="chk<?php echo $sno; ?>" id="chk<?php echo $sno; ?>" value="<?php echo $locationcode; ?>" <?php if($rate13 != '') { ?> checked="checked" <?php } ?>>
                            &nbsp;&nbsp;<?php echo $locationname; ?></td>
                          <td align="left" class="bodytext12"><input type="text" name="rateperunit<?php echo $sno; ?>" id="rateperunit<?php echo $sno; ?>" value="<?php echo $rate13; ?>" size="10" /></td>
                        </tr>-->
                        <?php //} ?>
                      <!--</table></td>
                    </tr>-->
                  <input type="hidden" name="rate2" id="rate2" value="<?php echo $rate2; ?>" size="20" />
                  <input type="hidden" name="rate3" id="rate3" value="<?php echo $rate3; ?>" size="20" />
                  <input type="hidden" name="purchaseprice" id="purchaseprice" value="<?php echo $purchaseprice; ?>" size="20" />
                  <tr>
                    <td width="20%" align="left" valign="middle"   class="bodytext12"><strong>Add Reference</strong></td>
                  </tr>
                  <tr id="pressid">
                    <td colspan="11" align="left" valign="middle"   class="bodytext13">
					<table id="presid" border="0" cellspacing="1" cellpadding="1">
                      <tbody id="insertrow">
                        <tr>
                       
					   <td width="210" class="bodytext3"><strong>Reference</strong></td>
                       <td width="150" class="bodytext3"><strong>Unit</strong></td>
					   <td width="250" class="bodytext3"><strong>Normal Range</strong></td>
                       <td width="98" class="bodytext3"><strong>Critical Low</strong></td>
					   <td width="98" class="bodytext3"><strong>Critical High</strong></td>
					   <td width="50" class="bodytext3"><strong>Gender</strong></td>
					   <td width="30" class="bodytext3"><input type="text" size="10" value="Age Range" class="bodytext3" readonly style="border:none;background-color:transparent;font-weight:bold;" /></td>

					   <td width="40" class="bodytext3"><strong>Ref. Range Label</strong></td>

					   <td width="40" class="bodytext3"><input type="text" size="10" value="Ref Order" class="bodytext3" readonly style="border:none;background-color:transparent;font-weight:bold;" /></td>
					   <td width="40" class="bodytext3"><input type="text" size="10" value="Ref Code" class="bodytext3" readonly style="border:none;background-color:transparent;" /></td>
					   <td width="30" class="bodytext3"><strong>Generic Search</strong></td>
                        </tr>
                        <?php
				$itemcount = "";
				//To populate items already in the bill if in edit mode.
				include ('lab_edit1listingmaster.php');
				//value to initiate serial number if in edit mode.
				$itemcount = $itemcount;
				?>
                      </tbody>
                    </table>
                    <tr>
                      <td colspan="11"  class="bodytext13"><table border="0" cellspacing="1" cellpadding="1">
                        <tbody>
                          <tr >
                            <input type="hidden" name="serialnumber" id="serialnumber" value="<?php echo $itemcount+1; ?>">
                            <input type="hidden" name="medicinecode" id="medicinecode" value="">
                           
						   <td><input name="reference[]" type="text" id="reference" size="20" autocomplete="off"></td>
						   <td><input name="units[]" type="text" id="units" size="8" autocomplete="off"></td>
							 <td><input name="subheader[]" type="text" id="subheader" size="20" autocomplete="off"></td>
						   <td><input name="rangelow[]" type="text" id="rangelow" size="8" autocomplete="off"></td>
						   <td><input name="rangehigh[]" type="text" id="rangehigh" size="8" autocomplete="off"></td>
						   <td><select name="gender[]" id="gender">
						   <option value="">All</option>
						   <option value="Male">Male</option>
						   <option value="Female">Female</option></select></td>
						   <td><input name="agelimitfrom[]" type="text" id="agelimitfrom" size="1" autocomplete="off" placeholder="From">
						   <input name="agelimitto[]" type="text" id="agelimitto" size="1" autocomplete="off" placeholder="To"></td>

						   <td><input name="refrange_label[]" type="text" id="refrange_label" size="8" autocomplete="off"></td>

						   

						   <td><input name="reforder[]" type="text" id="reforder" size="1" autocomplete="off"></td>
                           <td><input name="refcode[]" type="text" id="refcode" size="1" autocomplete="off"></td>
						   <td><select name="genericsearch[]" id="genericsearch">
						   <option value="0">No</option>
						   <option value="1">Yes</option></select></td>
						   <td width="54"><label>
						   <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem10()" class="button" style="border: 1px solid #001E6A">
						   </label></td>
                          </tr>
                        <input type="hidden" name="h" id="h" value="0">
                      </table></td>
                    </tr>
                  <tr>
                    <td width="20%" align="left" valign="top"   class="bodytext13">&nbsp;</td>
                    <td width="47%" align="left" valign="top" class="bodytext13">&nbsp;</td>
                    <td width="11%" align="left" valign="top" class="bodytext13">&nbsp;</td>
                    <td width="22%" align="left" valign="top" class="bodytext13" ><input type="hidden" name="frmflag" value="addnew" />
                      <input type="hidden" name="frmflag1" value="frmflag1" />
                      <input type="submit" name="Submit" value="Save Lab Item" /></td>
                  </tr>
                </table>
              </form></td>
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

