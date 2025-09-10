<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");

$username = $_SESSION["username"];
$docno = $_SESSION["docno"];

$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$errmsg = "";

$bgcolorcode = "";

$colorloopcount = "";



//to redirect if there is no entry in masters category or item.

 $loccountloop=isset($_REQUEST['locationcount'])?$_REQUEST['locationcount']:'';





if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1')

{

	//if starts

	for($i=1; $i<=$loccountloop; $i++)

{

	 //$loccodeget=isset($_REQUEST['lcheck'.$i])?$_REQUEST['lcheck'.$i]:'';

	 $locrateget=isset($_REQUEST['locrate'])?$_REQUEST['locrate']:'0';


$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
$loccodename  = $res["locationname"];
$loccodeget = $res["locationcode"];
	 

	 if($locrateget!='')

	 {

		 // top end here 



	$itemcode = $_REQUEST["itemcode"];

	$itemcode = strtoupper($itemcode);

	$itemcode = trim($itemcode);

	$itemname = $_REQUEST["itemname"];

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

		$errmsg="Sorry. services Item Not Added";

		

		header("location:servicename1.php?st=1");

		exit();

	}

	$itemname = addslashes($itemname);

	

	$categoryname = $_REQUEST["categoryname"];

	//$purchaseprice  = $_REQUEST["purchaseprice"];

	//$rateperunit  = $_REQUEST["rateperunit"];

	//$rate2 = $_REQUEST['rate2'];

	//$rate3 = $_REQUEST['rate3'];

	//$location = $_REQUEST["location"];

	$ipmarkup = $_REQUEST["ipmarkup"];

	//$incrementalrate = $_REQUEST["incrementalrate"];

	$expiryperiod = '';

	$description='';

	$referencevalue ='';

	$res4taxname = '';

	//$itemname_abbreviation = $_REQUEST["itemname_abbreviation"];

	

	//get base values

	

	$pkg=isset($_REQUEST['pkg'])?$_REQUEST['pkg']:'no';

	

	$wellnesspkg=isset($_REQUEST['wellnesspkg'])?$_REQUEST['wellnesspkg']:'0';



	 $baseunit = isset($_REQUEST["baseunit"])?$_REQUEST["baseunit"]:'';

	 $slab = isset($_REQUEST["slab"])?$_REQUEST["slab"]:'';

	$saccountname = $_REQUEST["saccountname"];

	$saccountid = $_REQUEST["saccountid"];

	$incrementalqty = $_REQUEST["incrementalqty"];

	 $incrementalrate = $_REQUEST["incrementalrate"];

	 $groupid = isset($_REQUEST["groupid"])?$_REQUEST["groupid"]:'';

	 if($slab=='')

	{$baseunit=1;

	$incrementalqty='';

	$incrementalrate='';}

	//get base ends here

	$taxanum = '';

	if ($length1<25 && $length2<255)

	{

		

		

		$query2 = "select * from master_services where itemcode = '$itemcode' and location='".$loccodeget."'";// or itemname = '$itemname'";

		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res2 = mysqli_num_rows($exec2);

		if ($res2 == 0)

		{

			$query1 = "insert into master_services (itemcode, itemname, categoryname,rateperunit, expiryperiod, ipaddress, updatetime,locationcode,ipmarkup, pkg,wellnesspkg, incrementalrate,description,baseunit,incrementalquantity,slab,ledgername,ledgerid, groupid,username,locationname) 

			values ('$itemcode', '$itemname', '$categoryname', '".$locrateget."', '$expiryperiod', '$ipaddress', '$updatedatetime','".$loccodeget."','$ipmarkup','".$pkg."','$wellnesspkg','$incrementalrate','manual','".$baseunit."','".$incrementalqty."','".$slab."','$saccountname','$saccountid', '$groupid','$username','$loccodename')";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$query25 = 'SELECT templatename FROM `master_testtemplate` where testname="services"';

			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));

			while ($res25 = mysqli_fetch_array($exec25))

			{

				$templatename = $res25["templatename"];

				$querytemp1 = "insert into `$templatename` (itemcode, itemname, categoryname,  rateperunit, expiryperiod, ipaddress, pkg, updatetime, description,  referencevalue,ipmarkup,locationcode,locationname,username) 

			values ('$itemcode', '$itemname', '$categoryname',  '".$locrateget."', '$expiryperiod',  '$ipaddress', '".$pkg."', '$updatedatetime','manual',  '$referencevalue','$ipmarkup','".$loccodeget."','$loccodename','$username')";

				$exectemp1 = mysqli_query($GLOBALS["___mysqli_ston"], $querytemp1) or die ("Error in querytemp1".mysqli_error($GLOBALS["___mysqli_ston"]));	

			}

		 /*<?php?>$query1 = "insert into master_renewal (itemcode, itemname, renewalmonths, ipaddress, updatetime) 

			values ('$itemcode', '$itemname', '0', '$ipaddress', '$updatedatetime')";

			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());<?php ?>*/

	

			$errmsg = "Success. New services Item Updated.";

			$bgcolorcode = 'success';

			$itemcode = '';

			$itemname = '';

			$rateperunit  = '0.00';

			$purchaseprice  = '0.00';

			$description = '';

			$referencevalue = '';



			//$itemcode = '';

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

				$res1itemcode = substr($res1itemcode, 2, 8);

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

			

			

			

			}



		}

		else

		{

			$errmsg = "Failed. services Item Code Already Exists.";

			$bgcolorcode = 'failed';

		}

	}

	else

	{

		$errmsg = "Failed. services Item Code Should Be 25 Characters And Name Should Be 255 Characters.";

		$bgcolorcode = 'failed';

	}

	

	 }}

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

			if (strlen($res1itemcode) == 1)

			{

				$res1itemcode = '00'.$res1itemcode;

			}

			 $itemcode = 'SER'.$res1itemcode;

			

		}

		else

		{

			$rowcount1=0;

			}

			

		}

		//get itemcode end here

		//echo $employeecode;

	}

		

	





if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == 'del')

{

	$delanum = $_REQUEST["anum"];

	$query3 = "update master_services set status = 'deleted',username = '$username',ipaddress = '$ipaddress',updatetime = '$updatedatetime' where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query25 = 'SELECT templatename FROM `master_testtemplate` where testname="services"';
			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res25 = mysqli_fetch_array($exec25))
			{
				$templatename = $res25["templatename"];
				$querytemp1 = "update $templatename set status = 'deleted',username = '$username',ipaddress = '$ipaddress',updatetime = '$updatedatetime' where auto_number = '$delanum'";
				$exectemp1 = mysqli_query($GLOBALS["___mysqli_ston"], $querytemp1) or die ("Error in querytemp1".mysqli_error($GLOBALS["___mysqli_ston"]));	
			}

}

if ($st == 'activate')

{

	$delanum = $_REQUEST["anum"];

	$query3 = "update master_services set status = '',username = '$username',ipaddress = '$ipaddress',updatetime = '$updatedatetime' where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	
	$query25 = 'SELECT templatename FROM `master_testtemplate` where testname="services"';
			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res25 = mysqli_fetch_array($exec25))
			{
				$templatename = $res25["templatename"];
				$querytemp1 = "update $templatename set status = '',username = '$username',ipaddress = '$ipaddress',updatetime = '$updatedatetime' where auto_number = '$delanum'";
				$exectemp1 = mysqli_query($GLOBALS["___mysqli_ston"], $querytemp1) or die ("Error in querytemp1".mysqli_error($GLOBALS["___mysqli_ston"]));	
			}

}





if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }

if ($svccount == 'firstentry')

{

	$errmsg = "Please Add services Item To Proceed For Billing.";

	$bgcolorcode = 'failed';

}



if (isset($_REQUEST["searchflag1"])) { $searchflag1 = $_REQUEST["searchflag1"]; } else { $searchflag1 = ""; }

if (isset($_REQUEST["searchflag2"])) { $searchflag2 = $_REQUEST["searchflag2"]; } else { $searchflag2 = ""; }

if (isset($_REQUEST["search1"])) { $search1 = $_REQUEST["search1"]; } else { $search1 = ""; }

if (isset($_REQUEST["search2"])) { $search2 = $_REQUEST["search2"]; } else { $search2 = ""; }













?>

<style type="text/css">
th {
            background-color: #ffffff;
            position: sticky;
            top: 0;
            z-index: 1;
        }


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

.pagination{float:right;}

-->

</style>

</head>

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

		alert ("Please Enter services Item Code or ID.");

		document.form1.itemcode.focus();

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

				//alert ("Your services Item Name Has Blank White Spaces Or Special Characters. Like ! ^ + = [ ] ; , { } | \ < > ? ~ $ ' \" These are not allowed.");

				alert ("Your services Item Code Has Blank White Spaces Or Special Characters. These Are Not Allowed.");

				return false;

			}

		}

	}

	if (document.form1.itemname.value == "")

	{

		alert ("Pleae Enter services Item Name.");

		document.form1.itemname.focus();

		return false;

	}

	if (document.form1.saccountname.value == "")

	{

		alert ("Please Select ledger Name.");

		document.form1.saccountname.focus();

		return false;

	}

	if (document.form1.saccountid.value == "")

	{

		alert ("Please Select ledger Name.");

		document.form1.saccountname.focus();

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

	if(document.form1.slab.checked==true)

	{

		if (document.form1.baseunit.value == "")

		{	

			alert ("Please Enter Base Unit.");

			document.form1.baseunit.focus();

			return false;

		}

		if (isNaN(document.form1.baseunit.value) == true)

		{	

			alert ("Please Enter Numbers Only.");

			document.form1.baseunit.focus();

			return false;

		}

		if (document.form1.incrementalqty.value == "")

		{	

			alert ("Please Enter Incremental Quantity.");

			document.form1.incrementalqty.focus();

			return false;

		}

		if (isNaN(document.form1.incrementalqty.value) == true)

		{	

			alert ("Please Enter Numbers Only.");

			document.form1.incrementalqty.focus();

			return false;

		}

		if (document.form1.incrementalrate.value == "")

		{	

			alert ("Please Enter Incremental Rate.");

			document.form1.incrementalrate.focus();

			return false;

		}

		

		if (isNaN(document.form1.incrementalrate.value) == true)

		{	

			alert ("Please Enter Numbers Only.");

			document.form1.incrementalrate.focus();

			return false;

		}

	}

	/*if (document.form1.rateperunit.value == "0.00")

	{

		var fRet; 

		fRet = confirm('Rate Per Unit Is 0.00, Are You Sure You Want To Continue To Save?'); 

		//alert(fRet);  // true = ok , false = cancel

		if (fRet == false)

		{

			return false;

		}*/

/*		else if (document.form1.itemname_abbreviation.value == "SR")

		{

			if (document.form1.expiryperiod.value == "")

			{	

				alert ("Please Select Expiry Period.");

				document.form1.expiryperiod.focus();

				return false;

			}

		}

*/	/*}*/

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



var ifcount=0;

	var lcheck='lcheck';

	//var lcheckk='lcheck3';

	//alert(document.form1.lcheck.value);

	var lcount=document.form1.locationcount.value;

	

	if(lcount!=0)

	{

		for(var i=1; i<=lcount; i++)

		{

			if(document.form1.elements["lcheck"+i].checked == true)

			{ ifcount=ifcount+1;}

			/*var lname=lcheck+i;

			alert(lname);

			alert(document.form1.elements[lname].value);*/

			//alert(document.getElementById("icheck"+i).value);

		}

		if(ifcount==0)

		{

			alert('Please select atleast one Location');

			return false;

		}

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

			alert ("Your services Item Name Has Special Characters. Like ! ^ + = [ ] ; , { } | \ < > ? ~ These are not allowed.");

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



</script>





<script src="js/jquery-1.11.1.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/autocomplete.css">

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>

  <script>



$(function() {



    $('#saccountname').autocomplete({

		

	source:'accountnameserajax.php', 

	

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

              <td><form name="form1" id="form1" method="post" action="servicename1.php" onSubmit="return additem1process1()">

                  <table width="900" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Services Item Master - Add New </strong></td>

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

						$query1 = "select * from master_categoryservices where status <> 'deleted' order by categoryname";

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

                          <a href="addcategory1services.php"><font  class="bodytext32" color="#000000">(Click Here To Add New Category)</font></a></td>

                      <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Exclude</span></td>

                        <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3"><input type="checkbox" name="exclude"></td>

                          </tr>

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> <div align="left">New Services Item Code </div></td>

                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input name="itemcode" value="<?php echo $itemcode; ?>" id="itemcode" readonly onKeyDown="return process1backkeypress1()" style="border: 1px solid #001E6A; background-color:#ecf0f5" size="20" maxlength="100" />

                          <span class="bodytext32">( Example : PRD1234567890 ) </span></td>

                     <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">IP Mark up</td>

                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="text" name="ipmarkup" style="border: 1px solid #001E6A; "></td>

                     </tr>

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Add New Services Item Name </div></td>

                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input name="itemname" type="text" id="itemname" style="border: 1px solid #001E6A" onChange="return spl()" value="" size="60"></td>

                        <!-- <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">Location</td>

                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="text" name="location" style="border: 1px solid #001E6A"></td>-->

                 </tr>

				 <tr>

				 <td width="13%" align="left" valign="top"  bgcolor="#ecf0f5"  class="bodytext3">Income Ledger</td>

                        <td width="33%" align="left" valign="top"  bgcolor="#ecf0f5"> 

                        <input type="text" name="saccountname" id="saccountname" size="30" />

                        <input type="hidden" name="saccountauto" id="saccountauto" />

                        <input type="hidden" name="saccountid" id="saccountid" />

                         </td>

				 </tr>

                 <tr>

					  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Slab</div></td>

					   <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="checkbox" name="slab" value="1"></td>

					   <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>

					   <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>

					  </tr>

                 <tr>

					  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Base Unit</div></td>

					   <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="text" name="baseunit" style="border: 1px solid #001E6A"></td>

					   <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>

					   <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>

					  </tr>

                      <tr>

					  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Incremental Quantity</div></td>

					   <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="text" name="incrementalqty" style="border: 1px solid #001E6A"></td>

					   <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>

					   <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>

					  </tr>

                      <tr>

					  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Incremental Rate</div></td>

					   <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="text" name="incrementalrate" style="border: 1px solid #001E6A"></td>

					   <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>

					   <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>

					  </tr>

                      

                       

                       <tr>  <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">Package</td>

                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="checkbox" name="pkg" value="yes"></td></tr>

					  <tr>

					   <tr>  <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">Wellness Pkg</td>

                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="checkbox" name="wellnesspkg" value="1"></td></tr>

					  <tr>

					  <tr>

					   <tr>  <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">MIS Group</td>

                        <td align="left" valign="top"  bgcolor="#ecf0f5"><select name="groupid">

                        	<?php

                        		$qmis = "select * from mis_accountname";

                        		$execmis = mysqli_query($GLOBALS["___mysqli_ston"], $qmis) or die("Error in qmis".mysqli_error($GLOBALS["___mysqli_ston"]));

                        		while($resmis = mysqli_fetch_array($execmis)){

                        			$accountname = $resmis['accountname'];

                        			$id = $resmis['auto_number'];



                        			?>



                        			<option value="<?php echo $id; ?>"><?php echo $accountname; ?></option>

                    			<?php

                        		} 

                        	?>

                        </select></td></tr>

					  <tr>

                      <?php /*?><!--<tr>

                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Charge  Price  Per Unit </div></td>

                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input name="rateperunit" id="rateperunit" style="border: 1px solid #001E6A" value="<?php echo $rateperunit; ?>" size="20" />

                          <input type="hidden" name="purchaseprice" id="purchaseprice" style="border: 1px solid #001E6A" value="<?php echo $purchaseprice; ?>" size="20" /></td>

                        <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>

                        <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>

                      </tr>--><?php */?>

                   <?php /*?> <!--  <tr>

                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">services Item Reference Value (Optional) </div></td>

                        <td align="left" valign="top"  bgcolor="#ecf0f5"><textarea  name="referencevalue" cols="60" id="referencevalue" style="border: 1px solid #001E6A"><?php echo $referencevalue; ?></textarea>

                          <input name="description" type="hidden" id="description" style="border: 1px solid #001E6A" value="<?php echo $description; ?>" size="60"></td>

                      </tr>--><?php */?>

                    <?php /*?><!-- <tr>

                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Select Applicable Tax </div></td>

                        <td align="left" valign="top"  bgcolor="#ecf0f5"><select id="taxanum" name="taxanum">

                          <option value="">Select Tax</option>

                          <?php

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

						?>

                        </select></td>

                        <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>

                        <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>

				  </tr>

					   <tr>

                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Rate2 </div></td>

                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input name="rate2" id="rate2" style="border: 1px solid #001E6A" value="<?php echo $rateperunit; ?>" size="20" />

                          </td>

                        <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>

                        <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>

                      </tr>

					   <tr>

                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Rate3 </div></td>

                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input name="rate3" id="rate3" style="border: 1px solid #001E6A" value="<?php echo $rateperunit; ?>" size="20" />

                          </td>

                        <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>

                        <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>

                      </tr>--><?php */?>

				  		<tr>

	   <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>

        <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>

	  </tr> 

       <?php
$incr=1;
	  //$query1 = "select locationcode,locationname,prefix,suffix from master_location where status <> 'deleted' order by locationname";

						// $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						// $incr=0;

						// while ($res1 = mysqli_fetch_array($exec1))

						// {

						// $locationcode = $res1["locationcode"];

						// $locationname = $res1["locationname"];

						$res1anum = $res1["auto_number"];

						 // $incr=$incr+1;

						?>

      <tr>

	   <td width="9%" align="left" valign="middle"  bgcolor="#ECF0F5" class="bodytext3">&nbsp;</td>

        <td width="10px" align="left" valign="middle"  bgcolor="#ECF0F5" class="bodytext3" >
		<!--<input type="checkbox" name="lcheck<?php //echo $incr;?>" id="lcheck<?php //echo $incr;?>" style="float:left" value="<?php //echo $locationcode;?>"><input type="hidden" name="checklocval" value=<?php// echo $locationcode;?>"">-->

        &nbsp;<span style="width:100px;float:left;line-height:20px">Item Rate</span><input type="text" name="locrate" style="width:90px;"></td>
	  </tr> 

      <?php //}?><input type="hidden" name="locationcount" value="<?php echo  $incr;?>">

					  

                      <tr>

                        <td width="20%" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>

                        <td width="45%" align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>

                        <td width="16%" align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>

                        <td width="19%" align="left" valign="top"  bgcolor="#ecf0f5"><input type="hidden" name="frmflag" value="addnew" />

                            <input type="hidden" name="frmflag1" value="frmflag1" />

                          <input type="submit" name="Submit" value="Save Services Item" style="border: 1px solid #001E6A" />                        </td>

                      </tr>

                    </tbody>

                  </table>

				  </form>

				  <form>

                <table width="900" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><strong>services Item Master - Existing List - Latest 100 services Items </strong></span></td>

						<td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">

						<?php //error_reporting(0);

						if($searchflag1 != 'searchflag1'){

							$tbl_name="master_lab";		//your table name

							// How many adjacent pages should be shown on each side?

							$adjacents = 3;

							

							/* 

							   First get total number of rows in data table. 

							   If you have a WHERE clause in your query, make sure you mirror it here.

							*/

							$query111 = "select * from master_services where status <> 'deleted' group by itemcode order by auto_number desc";

							$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));

							$res111 = mysqli_fetch_array($exec111);

							$total_pages = mysqli_num_rows($exec111);

												

							/*$query = "SELECT * FROM $tbl_name";

							$total_pages = mysql_fetch_array(mysql_query($query));

							echo $numrow = mysql_num_rows($total_pages);*/

							

							/* Setup vars for query. */

							$targetpage = $_SERVER['PHP_SELF']; 	//your file name  (the name of this file)

							$limit = 50; 								//how many items to show per page

							if(isset($_REQUEST['page'])){ $page=$_REQUEST['page'];} else { $page="";}

							if($page) 

								$start = ($page - 1) * $limit; 			//first item to display on this page

							else

								$start = 0;								//if no page var is given, set start to 0

							

							/* Setup page vars for display. */

							if ($page == 0) $page = 1;					//if no page var is given, default to 1.

							$prev = $page - 1;							//previous page is page - 1

							$next = $page + 1;							//next page is page + 1

							$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.

							$lpm1 = $lastpage - 1;						//last page minus 1

							

							/* 

								Now we apply our rules and draw the pagination object. 

								We're actually saving the code to a variable in case we want to draw it more than once.

							*/

							$pagination = "";

							if($lastpage >= 1)

							{	

								$pagination .= "<div class=\"pagination\">";

								//previous button

								if ($page > 1) 

									$pagination.= "<a href=\"$targetpage?page=$prev\" style='color:#3b3b3c;'>previous</a>";

								else

									$pagination.= "<span class=\"disabled\">previous</span>";	

								

								//pages	

								if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up

								{	

									for ($counter = 1; $counter <= $lastpage; $counter++)

									{

										if ($counter == $page)

											$pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";

										else

											$pagination.= "<a href=\"$targetpage?page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					

									}

								}

								elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some

								{

									//close to beginning; only hide later pages

									if($page < 1 + ($adjacents * 2))		

									{

										for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)

										{

											if ($counter == $page)

												$pagination.= "<span class=\"current\" style='margin:0 0 0 2px;' color:#3b3b3c;>$counter</span>";

											else

												$pagination.= "<a href=\"$targetpage?page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					

										}

										$pagination.= "...";

										$pagination.= "<a href=\"$targetpage?page=$lpm1\"style='margin:0 0 0 2px; color:#3b3b3c;'>$lpm1</a>";

										$pagination.= "<a href=\"$targetpage?page=$lastpage\"style='margin:0 0 0 2px; color:#3b3b3c;'>$lastpage</a>";		

									}

									//in middle; hide some front and some back

									elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))

									{

										$pagination.= "<a href=\"$targetpage?page=1\" style='margin:0 0 0 2px; color:#3b3b3c;'>1</a>";

										$pagination.= "<a href=\"$targetpage?page=2\" style='margin:0 0 0 2px; color:#3b3b3c;'>2</a>";

										$pagination.= "...";

										for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)

										{

											if ($counter == $page)

												$pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";

											else

												$pagination.= "<a href=\"$targetpage?page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					

										}

										$pagination.= "...";

										$pagination.= "<a href=\"$targetpage?page=$lpm1\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lpm1</a>";

										$pagination.= "<a href=\"$targetpage?page=$lastpage\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lastpage</a>";		

									}

									//close to end; only hide early pages

									else

									{

										$pagination.= "<a href=\"$targetpage?page=1\" style='margin:0 0 0 2px; color:#3b3b3c;'>1</a>";

										$pagination.= "<a href=\"$targetpage?page=2\" style='margin:0 0 0 2px; color:#3b3b3c;'>2</a>";

										$pagination.= "...";

										for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)

										{

											if ($counter == $page)

												$pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";

											else

												$pagination.= "<a href=\"$targetpage?page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					

										}

									}

								}

								

								//next button

								if ($page < $counter - 1) 

									$pagination.= "<a href=\"$targetpage?page=$next\" style='margin:0 0 0 2px; color:#3b3b3c;'>next</a>";

								else

									$pagination.= "<span class=\"disabled\" style='margin:0 0 0 2px; color:#3b3b3c;'>next</span>";

								echo $pagination.= "</div>\n";		

							}

						}

						?>

						</span></td>

                      </tr>

                      <tr bgcolor="#011E6A">

                        <td colspan="12" bgcolor="#FFFFFF" class="bodytext3">

						<input name="search1" type="text" id="search1" size="40" value="<?php echo $search1; ?>">

						<input type="hidden" name="searchflag1" id="searchflag1" value="searchflag1">

                          <input type="submit" name="Submit2" value="Search" style="border: 1px solid #001E6A" /></td>

                        </tr>

                      <tr bgcolor="#011E6A">

                        <th width="6%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Delete</strong></div></th>

                        <th width="10%" bgcolor="#ecf0f5" class="bodytext3"><strong>ID / Code </strong></th>

                        <th width="10%" bgcolor="#ecf0f5" class="bodytext3"><strong>Category</strong></th>

                        <th width="28%" bgcolor="#ecf0f5" class="bodytext3"><strong>services Item</strong></th>

                       <!-- <td width="6%" bgcolor="#ecf0f5" class="bodytext3"><strong>Unit</strong></td>

                       

                        <td width="9%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Charges</strong></div></td>

						 <td width="10%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Rate2</strong></div></td>

						  <td width="10%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Rate3</strong></div></td>-->

						  <th width="9%" bgcolor="#ecf0f5" class="bodytext3"><div><strong>IP Markup</strong></div></th>

						<!--<td width="10%" bgcolor="#ecf0f5" class="bodytext3"><div><strong>Location</strong></div></td>-->

                  <th width="10%" bgcolor="#ecf0f5" class="bodytext3"><div><strong>Incremental Rate</strong></div></th>

                        <th width="12%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Edit</strong></div></th>

                      </tr>

                      <?php

	  if ($searchflag1 == 'searchflag1')

	  {

					  

		$search1 = $_REQUEST["search1"];			  

	    $query1 = "select * from master_services where (itemname like '%$search1%' or categoryname like '%$search1%') and status <> 'deleted' group by itemcode order by auto_number desc LIMIT 100";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res1 = mysqli_fetch_array($exec1))

		{

		$itemcode = $res1["itemcode"];

		$itemname = $res1["itemname"];

		$categoryname = $res1["categoryname"];

		$purchaseprice = $res1["purchaseprice"];

		$rateperunit = $res1["rateperunit"];

		$expiryperiod = $res1["expiryperiod"];

		$auto_number = $res1["auto_number"];

		$itemname_abbreviation = $res1["itemname_abbreviation"];

		$taxname = $res1["taxname"];

		$taxanum = $res1["taxanum"];

		$ipmarkup = $res1["ipmarkup"];

		$location = $res1["location"];

		$incrementalrate = $res1["incrementalrate"];

		$rate2 = $res1['rate2'];

		$rate3 = $res1['rate3'];

		if ($expiryperiod != '0') 

		{ 

			$expiryperiod = $expiryperiod.' Months'; 

		}

		else

		{

			$expiryperiod = ''; 

		}

	 /*?>	

		$query6 = "select * from master_tax where auto_number = '$taxanum'";

		$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());

		$res6 = mysql_fetch_array($exec6);

		$res6taxpercent = $res6["taxpercent"];<?php */

		

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

		  

		?>

        <tr <?php echo $colorcode; ?>>

                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="center"><a href="servicename1.php?st=del&&anum=<?php echo $auto_number; ?>"><img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>

                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>

                        <td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>

                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?> </td>

                        <?php /*?><!--<td align="left" valign="top"  class="bodytext3"><?php echo $itemname_abbreviation; ?> </td>

                        

                        <td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rateperunit; ?></div></td>

						<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate2; ?></div></td>

						<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate3; ?></div></td>--><?php */?>

						 <td align="center" valign="top"  class="bodytext3"><?php echo $ipmarkup; ?></td>

						 <?php /*?><!--<td align="left" valign="top"  class="bodytext3"><?php echo $location; ?></td>--><?php */?>

                  <td align="left" valign="top"  class="bodytext3"><?php echo $incrementalrate; ?></td>

                        <td align="left" valign="top"  class="bodytext3">

						  <div align="center">

						  <a href="edititem1services.php?sanum=<?php echo $auto_number; ?>&&itemcode=<?php echo $itemcode; ?>&&sertemplate=master_services" class="bodytext3">Edit</a></div></td>

                      </tr>

                      <?php

		}

	}

	else

	{

	$query1 = "select * from master_services where status <> 'deleted' group by itemcode order by auto_number desc LIMIT $start , $limit";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res1 = mysqli_fetch_array($exec1))

		{

		$itemcode = $res1["itemcode"];

		$itemname = $res1["itemname"];

		$categoryname = $res1["categoryname"];

		$purchaseprice = $res1["purchaseprice"];

		$rateperunit = $res1["rateperunit"];

		$expiryperiod = $res1["expiryperiod"];

		$auto_number = $res1["auto_number"];

		$itemname_abbreviation = $res1["itemname_abbreviation"];

		$taxname = $res1["taxname"];

		$taxanum = $res1["taxanum"];

		$ipmarkup = $res1["ipmarkup"];

		$location = $res1["location"];

		$incrementalrate = $res1["incrementalrate"];

		$rate2 = $res1['rate2'];

		$rate3 = $res1['rate3'];

		if ($expiryperiod != '0') 

		{ 

			$expiryperiod = $expiryperiod.' Months'; 

		}

		else

		{

			$expiryperiod = ''; 

		}

		

		 /*?>$query6 = "select * from master_tax where auto_number = '$taxanum'";

		$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());

		$res6 = mysql_fetch_array($exec6);

		$res6taxpercent = $res6["taxpercent"];<?php */

		

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

		  

		?>

        <tr <?php echo $colorcode; ?>>

                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="center"><a href="servicename1.php?st=del&&anum=<?php echo $auto_number; ?>"><img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>

                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>

                        <td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>

                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?> </td>

                        <?php /*?><!--<td align="left" valign="top"  class="bodytext3"><?php echo $itemname_abbreviation; ?> </td>

                       

                       

                        <td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rateperunit; ?></div></td>

							<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate2; ?></div></td>

							<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate3; ?></div></td>--><?php */?>

						 <td align="center" valign="top"  class="bodytext3"><?php echo $ipmarkup; ?></td>

						 <?php /*?><!--<td align="left" valign="top"  class="bodytext3"><?php echo $location; ?></td>--><?php */?>

                  <td align="left" valign="top"  class="bodytext3"><?php echo $incrementalrate; ?></td>

                        <td align="left" valign="top"  class="bodytext3">

						  <div align="center">

						  <a href="edititem1services.php?sanum=<?php echo $auto_number; ?>&&itemcode=<?php echo $itemcode; ?>&&sertemplate=master_services" class="bodytext3">Edit</a></div></td>

                      </tr>

                      <?php

		}

	}

		?>

                    </tbody>

                  </table>

				  </form>

				  <br>

				  

 				  <form>

                <table width="900" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <td colspan="11" bgcolor="#ecf0f5" class="bodytext3"><strong>Services Item Master - Deleted </strong></td>

                      </tr>

                      <tr bgcolor="#011E6A">

                        <td colspan="11" bgcolor="#FFFFFF" class="bodytext3"><span class="bodytext32">

                          <input name="search2" type="text" id="search2" size="40" value="<?php echo $search2; ?>">

                          <input type="hidden" name="searchflag2" id="searchflag2" value="searchflag2">

                          <input type="submit" name="Submit22" value="Search" style="border: 1px solid #001E6A" />

                        </span></td>

                        </tr>

                      <tr bgcolor="#011E6A">

                        <td width="8%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Activate</strong></div></td>

                        <td width="13%" bgcolor="#ecf0f5" class="bodytext3"><strong>ID / Code </strong></td>

                        <td width="16%" bgcolor="#ecf0f5" class="bodytext3"><strong>Category</strong></td>

                        <td width="23%" bgcolor="#ecf0f5" class="bodytext3"><strong>services Item</strong></td>

                       <!-- <td width="10%" bgcolor="#ecf0f5" class="bodytext3"><strong>Unit</strong></td>

                       <td width="10%" bgcolor="#ecf0f5" class="bodytext3"><strong>Charges</strong></td>

					     <td width="10%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Rate2</strong></div></td>

						  <td width="10%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Rate3</strong></div></td>-->

						<td width="10%" bgcolor="#ecf0f5" class="bodytext3"><div><strong>IP Markup</strong></div></td>

					    <!--<td width="15%" bgcolor="#ecf0f5" class="bodytext3"><div><strong>Location</strong></div></td>-->

						 <td width="10%" bgcolor="#ecf0f5" class="bodytext3"><div><strong>Incremental Rate</strong></div></td>

                      </tr>

                      <?php

		if (isset($_REQUEST["searchflag2"])) { $searchflag2 = $_REQUEST["searchflag2"]; } else { $searchflag2 = ""; }

	  if ($searchflag2 == 'searchflag2')

	  {

					  

		$search2 = $_REQUEST["search2"];			  

	    $query1 = "select * from master_services where (itemname like '%$search2%' or categoryname like '%$search2%') and status = 'deleted' group by itemcode order by auto_number desc LIMIT 100";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res1 = mysqli_fetch_array($exec1))

		{

		$itemcode = $res1["itemcode"];

		$itemname = $res1["itemname"];

		$categoryname = $res1["categoryname"];

		$purchaseprice = $res1["purchaseprice"];

		$rateperunit = $res1["rateperunit"];

		$expiryperiod = $res1["expiryperiod"];

		$auto_number = $res1["auto_number"];

		$ipmarkup = $res1["ipmarkup"];

		$location = $res1["location"];

		$incrementalrate = $res1["incrementalrate"];

		$itemname_abbreviation = $res1["itemname_abbreviation"];

		$rate2 = $res1['rate2'];

		$rate3 = $res1['rate3'];

	

		if ($expiryperiod != '0') 

		{ 

			$expiryperiod = $expiryperiod.' Months'; 

		}

		else

		{

			$expiryperiod = ''; 

		}

	

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

		  

		?>

        <tr <?php echo $colorcode; ?>>

                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">

						<a href="servicename1.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext3">

                          <div align="center" class="bodytext3">Activate</div>

                        </a></td>

                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>

                        <td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>

                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?></td>

                       <?php /*?><!-- <td align="left" valign="top"  class="bodytext3"><?php echo $itemname_abbreviation; ?></td>

                        <td align="left" valign="top"  class="bodytext3"><?php echo $res6taxpercent; ?></td>

                        

                        <td align="left" valign="top"  class="bodytext3"><div align="right"><span class="bodytext32"><?php echo $rateperunit; ?></span></div></td>

							<td align="center" valign="top"  class="bodytext3"><div align="right"><?php echo $rate2; ?></div></td>

							<td align="center" valign="top"  class="bodytext3"><div align="right"><?php echo $rate3; ?></div></td>--><?php */?>

									  <td align="left" valign="top"  class="bodytext3"><?php echo $ipmarkup; ?></td>

						 <?php /*?><!--<td align="left" valign="top"  class="bodytext3"><?php echo $location; ?></td>--><?php */?>

              <td align="left" valign="top"  class="bodytext3"><?php echo $incrementalrate; ?></td>

                      </tr>

                      <?php

		}

	}

	else

	{

		

	    $query1 = "select * from master_services where status = 'deleted' group by itemcode order by auto_number desc LIMIT 100";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res1 = mysqli_fetch_array($exec1))

		{

		$itemcode = $res1["itemcode"];

		$itemname = $res1["itemname"];

		$categoryname = $res1["categoryname"];

		$purchaseprice = $res1["purchaseprice"];

		$rateperunit = $res1["rateperunit"];

		$expiryperiod = $res1["expiryperiod"];

		$auto_number = $res1["auto_number"];

		$ipmarkup = $res1["ipmarkup"];

		$location = $res1["location"];

		$incrementalrate = $res1["incrementalrate"];

		$rate2 = $res1['rate2'];

		$rate3 = $res1['rate3'];

		if ($expiryperiod != '0') 

		{ 

			$expiryperiod = $expiryperiod.' Months'; 

		}

		else

		{

			$expiryperiod = ''; 

		}

		

		/*<?php ?>$query6 = "select * from master_tax where auto_number = '$taxanum'";

		$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());

		$res6 = mysql_fetch_array($exec6);

		$res6taxpercent = $res6["taxpercent"];

		<?php ?>*/

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

		  

		?>

        <tr <?php echo $colorcode; ?>>

                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">

						<a href="servicename1.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext3">

                          <div align="center" class="bodytext3">Activate</div>

                        </a></td>

                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>

                        <td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>

                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?></td>

                       <?php /*?><!-- <td align="left" valign="top"  class="bodytext3"><?php echo $itemname_abbreviation; ?></td>

                        

                        <td align="left" valign="top"  class="bodytext3"><div align="right"><span class="bodytext32"><?php echo $rateperunit; ?></span></div></td>

							<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate2; ?></div></td>

							<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate3; ?></div></td>--><?php */?>

									  <td align="center" valign="top"  class="bodytext3"><?php echo $ipmarkup; ?></td>

						 <?php /*?><!--<td align="left" valign="top"  class="bodytext3"><?php echo $location; ?></td>--><?php */?>

                <td align="left" valign="top"  class="bodytext3"><?php echo $incrementalrate; ?></td>

                      </tr>

                      <?php

		}

	}

		?>

                      <tr>

                        <td colspan="8" align="middle" >&nbsp;</td>

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



