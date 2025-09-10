<?php

session_start();

$pagename = '';

//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.

if (!isset($_SESSION['username'])) header ("location:index.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$sessionusername = $_SESSION['username'];

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companycode = $_SESSION['companycode'];

$companyname = $_SESSION['companyname'];

$errmsg = '';

$bgcolorcode = '';



if (isset($_REQUEST["searchsuppliername"])) {  $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

if (isset($_REQUEST["searchdescription"])) {   $searchdescription = $_REQUEST["searchdescription"]; } else { $searchdescription = ""; }

if (isset($_REQUEST["searchemployeecode"])) { $searchemployeecode = $_REQUEST["searchemployeecode"]; } else { $searchemployeecode = ""; }



if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }



//$frmflag1 = $_REQUEST['frmflag1'];

if ($frmflag1 == 'frmflag1')

{

	$employeecode=$_REQUEST['employeecode'];

	$employeename = $_REQUEST['employeename'];

	$employeename = strtoupper($employeename);

	$employeename = trim($employeename);

	

	$query67 = "delete from payroll_assign where employeecode = '$employeecode'";

	$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die ("Error in Query67".mysqli_error($GLOBALS["___mysqli_ston"]));

	

	$query2 = "insert into payroll_assign(employeecode, employeename, username, ipaddress, updatetime, companyanum, companycode, companyname)

			   values('$employeecode', '$employeename', '$username', '$ipaddress', '$updatedatetime','$companyanum','$companycode','$companyname')";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

	

	for($i=1;$i<=50;$i++)

	{	

		if(isset($_REQUEST['earninganum'.$i]))

		{

			$earninganum = $_REQUEST['earninganum'.$i];

			$earningamount = $_REQUEST['earningvalue'.$earninganum];

			

			$query21 = "update payroll_assign set `$earninganum` = '$earningamount' where employeecode = '$employeecode'";

			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));

			

		}

	}	

	for($j=1;$j<=50;$j++)

	{

		if(isset($_REQUEST['deductionanum'.$j]))

		{

			$deductionanum = $_REQUEST['deductionanum'.$j];

			$deductionamount = $_REQUEST['deductionvalue'.$deductionanum];

			

			$query31 = "update payroll_assign set `$deductionanum` = '$deductionamount' where employeecode = '$employeecode'";

			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));

		}

	}

	

	header("location:payrollassign1.php?st=success");

}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

//$st = $_REQUEST['st'];

if ($st == 'success')

{

		$errmsg = "";

}

else if ($st == 'failed')

{

		$errmsg = "";

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

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />  

<script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>

<script type="text/javascript" src="js/autosuggestemployeesearch12.js"></script>

<script type="text/javascript" src="js/autoemployeecodesearch4.js"></script>

<script type="text/javascript" src="js/autoemployeepayrolledit1.js"></script>

<!--<script type="text/javascript" src="js/deductioncalculation1.js"></script>-->

<script type="text/javascript">

window.onload = function () 

{

	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());

  	

}

</script>

<script type="text/javascript" src="js/disablebackenterkey.js"></script>

<script language="javascript">



function process1backkeypress1() 

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

}



</script>

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

-->

</style>

</head>

<script language="javascript">



function from1submit1()

{



	if (document.form1.employeename.value == "")

	{

		alert ("Employee Name Cannot Be Empty.");

		document.form1.employeename.focus();

		return false;

	}

}



function EarningAllow(i)

{

	var k;

	var i = i;

	//alert(i);

	if(i == 1)

	{

		//alert("It's Mandatory !");
		//document.getElementById("earninganum"+i).checked = "checked";

	}	

	else

	{	

		for(k=1;k<50;k++)

		{	

			if(document.getElementById("earninganum"+k) != null)

			{

				if(document.getElementById("earninganum"+k).checked == true)

				{	

					var Eanum = document.getElementById("earninganum"+k).value;

					//alert(Eanum);

					if(document.getElementById("earningamounttype"+Eanum).value != '')

					{

						document.getElementById("earningvalue"+Eanum).readOnly = false;

						document.getElementById("earningvalue"+Eanum).style.backgroundColor= "#FFFFFF";

						//document.getElementById("earningvalue"+Eanum).focus();

					}

					else

					{

						//document.getElementById("earningvalue"+Eanum).readOnly = true;

						//document.getElementById("earningvalue"+Eanum).style.backgroundColor= "#ecf0f5";	

					}	

				}

				if(document.getElementById("earninganum"+k).checked == false)

				{	

					var Eanum = document.getElementById("earninganum"+k).value;

					//alert(Eanum);

					if(document.getElementById("earningamounttype"+Eanum).value != '')

					{

						document.getElementById("earningvalue"+Eanum).readOnly = true;

						document.getElementById("earningvalue"+Eanum).style.backgroundColor= "#ecf0f5";

						//document.getElementById("earningvalue"+Eanum).focus();

					}

					else

					{

						//document.getElementById("earningvalue"+Eanum).readOnly = true;

						//document.getElementById("earningvalue"+Eanum).style.backgroundColor= "#ecf0f5";	

					}	

				}

			}	

		}

	}

	

	//DeductionAllow();

}



function DeductionAllow(j)

{

	var m;

	var j = j;

	//alert(j);

	

		for(m=0;m<50;m++)

		{	

			if(document.getElementById("deductionanum"+m) != null)

			{

				if(document.getElementById("deductionanum"+m).checked == true)

				{

					Danum = document.getElementById("deductionanum"+m).value;

					

					if(document.getElementById("deductionamounttype"+Danum).value != '')

					{

						document.getElementById("deductionvalue"+Danum).readOnly = false;

						document.getElementById("deductionvalue"+Danum).style.backgroundColor= "#FFFFFF";

						//document.getElementById("deductionvalue"+Danum).focus();

					}

					else

					{

						//document.getElementById("deductionvalue"+Danum).disabled = true;	

					}	

				}

				if(document.getElementById("deductionanum"+m).checked == false)

				{

					Danum = document.getElementById("deductionanum"+m).value;

					

					if(document.getElementById("deductionamounttype"+Danum).value != '')

					{

						document.getElementById("deductionvalue"+Danum).readOnly = true;

						document.getElementById("deductionvalue"+Danum).style.backgroundColor= "#ecf0f5";

						//document.getElementById("deductionvalue"+Danum).focus();

					}

					else

					{

						//document.getElementById("deductionvalue"+Danum).disabled = true;	

					}	

				}

			}

		}

}



</script>

<script src="js/datetimepicker_css.js"></script>

<body>

<form name="form1" id="form1" method="post" action="payrollassign1.php" onSubmit="return from1submit1()">

<table width="101%" align="left" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy9hbGVydG1lc3NhZ2VzMS5waHAiKTsg')); ?></td>

  </tr>

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy90aXRsZTEucGhwIik7IA==')); ?></td>

  </tr>

  <tr>

    <td colspan="10" bgcolor="#ecf0f5">

	<?php eval(base64_decode('IA0KCQ0KCQlpbmNsdWRlICgiaW5jbHVkZXMvbWVudTEucGhwIik7IA0KCQ0KCS8vCWluY2x1ZGUgKCJpbmNsdWRlcy9tZW51Mi5waHAiKTsgDQoJDQoJ')); ?>	</td>

  </tr>

  <tr>

    <td height="25" colspan="10">&nbsp;</td>

  </tr>

  <tr>

   <td width="1%" align="left" valign="top">&nbsp;</td>

    <td width="99%" valign="top">

	<table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

	<tbody>

	<tr>

	<td width="13%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Search Employee </strong></td>

	<td width="87%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

	<input name="searchsuppliername" type="text" id="searchsuppliername" value="" size="40" autocomplete="off">

	<input type="hidden" name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox">

	<input type="hidden" name="searchdescription" id="searchdescription">

	<input type="hidden" name="searchemployeecode" id="searchemployeecode">

	</td>

	</tr>

	</tbody>

	</table> 

	</td>

  </tr> 

  <tr>

  <td width="1%" align="left" valign="top">&nbsp;</td>

    <td width="99%" valign="top">

	<table width="900" height="29" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

	<tbody id="employeetr">

	<tr>

	<td width="118" align="left" class="bodytext3"><strong>Employee Name</strong></td>

	<td width="266" align="left" class="bodytext3"><input type="text" name="employeename" id="employeename" value="" size="30" readonly class="bodytext3" style="border:none;background-color:#ecf0f5;">

	<td width="120" align="left" class="bodytext3"><strong>Employee Code</strong></td>

	<td width="364" align="left" class="bodytext3"><input type="text" name="employeecode" id="employeecode" value="" size="20" readonly class="bodytext3" style="border:none;background-color:#ecf0f5;">

	</tr>

	</tbody>

	</table>

	</td>

  </tr>

  <tr>

  <td width="1%" align="left" valign="top">&nbsp;</td>

    <td width="99%" valign="top">

	<table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

	<tbody id="assigntr">

	<tr bgcolor="#ecf0f5">

	<td align="left" class="bodytext3"><strong>Earnings</strong></td>

	<td align="left" class="bodytext3"><strong>Deduction</strong></td>

	</tr>

	<tr>

	<td valign="top">

	<table width="400" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

	<tr>

	<td align="left" class="bodytext3"><strong>Select</strong></td>

	<td align="left" class="bodytext3"><strong>Component</strong></td>

	<td align="left" class="bodytext3"><strong>Type</strong></td>

	<td align="left" class="bodytext3"><strong>Monthly</strong></td>

	<td align="left" class="bodytext3"><strong>Value</strong></td>

	</tr>

	<?php 

	$eno = '';

	$query5 = "select * from master_payrollcomponent where recordstatus <> 'deleted' and type = 'Earning' order by auto_number, componentname";

	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($res5 = mysqli_fetch_array($exec5))

	{

	$eno = $eno + 1;

	$res5anum = $res5['auto_number'];

	$res5componentname = $res5['componentname'];

	$res5amounttype = $res5['amounttype'];

	$res5monthly = $res5['monthly'];

	$res5formula = $res5['formula'];

	if($res5formula == '1')

	{

		$formulafrom = 'BASIC';

	}

	else if($res5formula == '1+2')

	{

		$formulafrom = 'BASIC+HRA';

	}

	else

	{

		$formulafrom = '';

	}

	 ?>

	<tr>

	<td width="35" align="left" class="bodytext3"><input type="checkbox" name="earninganum<?php eval(base64_decode('IGVjaG8gJGVubzsg')); ?>" id="earninganum<?php eval(base64_decode('IGVjaG8gJGVubzsg')); ?>" value="<?php eval(base64_decode('IGVjaG8gJHJlczVhbnVtOyA=')); ?>" onClick="return EarningAllow('<?php eval(base64_decode('IGVjaG8gJGVubzsg')); ?>')" <?php  if($res5anum == '1') { echo "checked=\"checked\""; }  ?>></td>

	<td width="65" align="left" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJHJlczVjb21wb25lbnRuYW1lOyA=')); ?></td>

	<td width="28" align="left" class="bodytext3"><input type="text" name="earningamounttype<?php eval(base64_decode('IGVjaG8gJHJlczVhbnVtOyA=')); ?>" id="earningamounttype<?php eval(base64_decode('IGVjaG8gJHJlczVhbnVtOyA=')); ?>" value="<?php eval(base64_decode('IGVjaG8gJHJlczVhbW91bnR0eXBlOyA=')); ?>" readonly style="border:none;background-color:#ecf0f5;" size="5" class="bodytext3"></td>

	<td width="46" align="left" class="bodytext3"><input type="text" name="earningmonthly<?php eval(base64_decode('IGVjaG8gJHJlczVhbnVtOyA=')); ?>" id="earningmonthly<?php eval(base64_decode('IGVjaG8gJHJlczVhbnVtOyA=')); ?>" value="<?php eval(base64_decode('IGVjaG8gJHJlczVtb250aGx5OyA=')); ?>" readonly style="border:none;background-color:#ecf0f5;" size="5" class="bodytext3"></td>

	<td width="50" align="left" class="bodytext3"><input type="text" readonly name="earningvalue<?php eval(base64_decode('IGVjaG8gJHJlczVhbnVtOw==')); ?>" id="earningvalue<?php eval(base64_decode('IGVjaG8gJHJlczVhbnVtOw==')); ?>" value="" size="10" style="background-color:#ecf0f5;"></td>

	<input type="hidden" disabled="disabled" name="earningamount<?php eval(base64_decode('IGVjaG8gJHJlczVhbnVtOw==')); ?>" id="earningamount<?php eval(base64_decode('IGVjaG8gJHJlczVhbnVtOw==')); ?>" value="" size="10">

	</tr>

	<?php 

	}

	 ?>

	</table>

	</td>

	<td valign="top">

	<table width="400" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

	<tr>

	<td align="left" class="bodytext3"><strong>Select</strong></td>

	<td align="left" class="bodytext3"><strong>Component</strong></td>

	<td align="left" class="bodytext3"><strong>Type</strong></td>

	<td align="left" class="bodytext3"><strong>Monthly</strong></td>

	<td align="left" class="bodytext3"><strong>Value</strong></td>

	</tr>

	<?php 

	$dno = '';

	$query6 = "select * from master_payrollcomponent where recordstatus <> 'deleted' and type = 'Deduction' and auto_number NOT IN ('2','3','4') order by auto_number, componentname";

	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($res6 = mysqli_fetch_array($exec6))

	{

	$dno = $dno + 1;

	$res6anum = $res6['auto_number'];

	$res6componentname = $res6['componentname'];

	$res6amounttype = $res6['amounttype'];

	$res6monthly = $res6['monthly'];

	 ?>

	<tr>

	<td width="20" align="left" class="bodytext3"><input type="checkbox" name="deductionanum<?php eval(base64_decode('IGVjaG8gJGRubzsg')); ?>" id="deductionanum<?php eval(base64_decode('IGVjaG8gJGRubzsg')); ?>" value="<?php eval(base64_decode('IGVjaG8gJHJlczZhbnVtOyA=')); ?>" onClick="return DeductionAllow('<?php eval(base64_decode('IGVjaG8gJGRubzsg')); ?>')" ></td>

	<td width="142" align="left" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJHJlczZjb21wb25lbnRuYW1lOyA=')); ?></td>

	<td width="81" align="left" class="bodytext3"><input type="text" name="deductionamounttype<?php eval(base64_decode('IGVjaG8gJHJlczZhbnVtOyA=')); ?>" id="deductionamounttype<?php eval(base64_decode('IGVjaG8gJHJlczZhbnVtOyA=')); ?>" value="<?php eval(base64_decode('IGVjaG8gJHJlczZhbW91bnR0eXBlOyA=')); ?>" readonly style="border:none;background-color:#ecf0f5;" size="5" class="bodytext3"></td>

	<td width="81" align="left" class="bodytext3"><input type="text" name="deductionmonthly<?php eval(base64_decode('IGVjaG8gJHJlczZhbnVtOyA=')); ?>" id="deductionmonthly<?php eval(base64_decode('IGVjaG8gJHJlczZhbnVtOyA=')); ?>" value="<?php eval(base64_decode('IGVjaG8gJHJlczZtb250aGx5OyA=')); ?>" readonly style="border:none;background-color:#ecf0f5;" size="5" class="bodytext3"></td>

	<td width="50" align="left" class="bodytext3"><input readonly name="deductionvalue<?php eval(base64_decode('IGVjaG8gJHJlczZhbnVtOw==')); ?>" id="deductionvalue<?php eval(base64_decode('IGVjaG8gJHJlczZhbnVtOw==')); ?>" value="" size="10" style="background-color:#ecf0f5;"></td>

	<input type="hidden" disabled="disabled" name="deductionamount<?php eval(base64_decode('IGVjaG8gJHJlczZhbnVtOw==')); ?>" id="deductionamount<?php eval(base64_decode('IGVjaG8gJHJlczZhbnVtOw==')); ?>" size="10">	

	</tr>

	<?php 

	}

	 ?>

	</table>

	</td>

	</tr>

	<tr>

	<td colspan="2" align="center" class="bodytext3">

	<input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">

	<input type="submit" name="Submit" value="Submit">

	</tbody>

	</table>

	</td>

	</tr>

    </table>

	</form>

<?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy9mb290ZXIxLnBocCIpOyA=')); ?>

</body>

</html>



