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


$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

$locationname  = $res["locationname"];

$locationcode = $res["locationcode"];



if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1')

{



	$roleid = $_REQUEST["roleid"];

	$rolename = $_REQUEST["rolename"];
	
	
	
	$alert = $_REQUEST["alert"];
	$limit = $_REQUEST["limit"];
	
	//echo $length;


	$query2 = "select * from master_role where role_id = '$roleid' ";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res2 = mysqli_num_rows($exec2);

	if ($res2 == 0)

	{

		$query1 = "insert into master_role (role_id, role_name,alert,locationname,locationcode, ipaddress, recorddate,username,`limit`) 

		values ('$roleid', '$rolename','$alert','$locationname','$locationcode', '$ipaddress', '$updatedatetime','$username','$limit')";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$errmsg = "Success. New Role Updated.";

		$bgcolorcode = 'success';

		

	}

	else

	{

		$errmsg = "Failed. Role Id Already Exists.";

		$bgcolorcode = 'failed';

	}


}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if (isset($_REQUEST["roleid"])) { $roleid = $_REQUEST["roleid"]; } else { $roleid = ""; }

if ($st == 'del')

{

	$delanum = $_REQUEST["anum"];

	$query3 = "update master_role set recordstatus = 'deleted' where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	
	$query33 = "delete from role_mapping where role_id = '$roleid' ";

	$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'activate')

{

	$delanum = $_REQUEST["anum"];

	$query3 = "update master_role set recordstatus = '' where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

}







$paynowbillprefix7 = 'ROL-';
$paynowbillprefix17=strlen($paynowbillprefix7);
$query27 = "select * from master_role order by auto_number desc limit 0, 1";
$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));
$res27 = mysqli_fetch_array($exec27);
$billnumber7 = $res27["role_id"];
$billdigit7=strlen($billnumber7);
if ($billnumber7 == '')
{
	$billnumbercode7 =$paynowbillprefix7.'1';
		$openingbalance = '0.00';
}
else
{
	$billnumber7 = $res27["role_id"];
	$billnumbercode7 = substr($billnumber7,$paynowbillprefix17, $billdigit7);
	//echo $billnumbercode;
	$billnumbercode7 = intval($billnumbercode7);
	$billnumbercode7 = $billnumbercode7 + 1;
	$maxanum7 = $billnumbercode7;
	$billnumbercode7 = $paynowbillprefix7 .$maxanum7;
}

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



function addsalutation1process1()

{

	//alert ("Inside Funtion");

	/*if (document.form1.salutation.value == "")

	{

		alert ("Please Enter Salutation Name.");

		document.form1.salutation.focus();

		return false;

	}

	if (document.form1.gender.value == "")

	{

		alert ("Please Select Gender.");

		document.form1.gender.focus();

		return false;

	}*/

}



function funcDeleteSalutation(varSalutationAutoNumber)

{

     var varSalutationAutoNumber = varSalutationAutoNumber;

	 var fRet;

	fRet = confirm('Are you sure want to delete this Role  '+varSalutationAutoNumber+'?');

	//alert(fRet);

	if (fRet == true)

	{

		alert ("Role Entry Delete Completed.");

		//return false;

	}

	if (fRet == false)

	{

		alert ("Role Entry Delete Not Completed.");

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

              <td><form name="form1" id="form1" method="post" action="roles.php" onSubmit="return addsalutation1process1()">

                  <table width="450" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Role Master - Add New </strong></td>

                      </tr>

					  <tr>

                        <td colspan="2" align="left" valign="middle"   

						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>

                      </tr>

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">ID</div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="roleid" id="roleid" style="border: 1px solid #001E6A;" size="20"  value="<?php echo $billnumbercode7; ?>" readonly/></td>

                      </tr>

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">

						<div align="right">Role Name </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="rolename" id="rolename" style="border: 1px solid #001E6A;" size="40" autocomplete="off"/>
						
						
						
						
						</td>

                      </tr>
					  
					  
					  <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">

						<div align="right">Alert </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF"><textarea rows="2" name="alert" id="alert"></textarea></td>

                      </tr>

					  <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">

						<div align="right">Set Limit </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF"><input type="text" name="limit" id="limit" /></td>

                      </tr>

                      <tr>

                        <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                        <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF">

						<input type="hidden" name="frmflag" value="addnew" />

                            <input type="hidden" name="frmflag1" value="frmflag1" />

                          <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" /></td>

                      </tr>

                      <tr>

                        <td align="middle" colspan="2" >&nbsp;</td>

                      </tr>

                    </tbody>

                  </table>

                <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Role Master - Existing List </strong></td>

                        <td width="26%" bgcolor="#ecf0f5" class="bodytext3"><strong>Role Name </strong></td>
						
						 <td width="46%" bgcolor="#ecf0f5" class="bodytext3"><strong>Menu Mapping </strong></td>
                         
                          <td width="46%" bgcolor="#ecf0f5" class="bodytext3"><strong>Roles+Master Mapping</strong></td>

                        <td width="9%" bgcolor="#ecf0f5" class="bodytext3"><strong>Edit</strong></td>

                      </tr>

                      <?php

	    $query1 = "select * from master_role where recordstatus <> 'deleted' order by role_id ";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res1 = mysqli_fetch_array($exec1))

		{

		$role_id = $res1["role_id"];

		$role_name = $res1['role_name'];

		$auto_number = $res1["auto_number"];
		

		//$defaultstatus = $res1["defaultstatus"];



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

                        <td width="6%" align="left" valign="top"  class="bodytext3">

						<div align="center">

						<a href="roles.php?st=del&&anum=<?php echo $auto_number; ?>&&roleid=<?php echo $role_id; ?>" onClick="return funcDeleteSalutation('<?php echo $role_id ?>')">

						<img src="images/b_drop.png" width="16" height="16" border="0" /></a>						</div>						</td>

                        <td width="39%" align="left" valign="top"  class="bodytext3"><?php echo $role_id; ?> </td>

                        <td align="left" valign="top"  class="bodytext3"><?php echo $role_name; ?> </td>
						
						<td align="left" valign="top"  class="bodytext3">

						<a href="role_mapping.php?roleid=<?php echo $role_id; ?>" style="text-decoration:none">Menu Mapping</a></td>
                        
                        <td align="left" valign="top"  class="bodytext3">

						<a href="role_mapping_master.php?roleid=<?php echo $role_id; ?>" style="text-decoration:none">Mapping</a></td>

                        <td align="left" valign="top"  class="bodytext3">

						<a   href="editrole.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a></td>

        </tr>

                      <?php

		}

		?>

           <tr>

                        <td align="middle" colspan="4" >&nbsp;</td>

                      </tr>

                    </tbody>

                  </table>

                <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>Salutation Master - Deleted </strong></td>

                      </tr>

                      <?php

		

	    $query1 = "select * from master_role where recordstatus = 'deleted' order by role_id ";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res1 = mysqli_fetch_array($exec1))

		{

		$role_id = $res1['role_id'];

		$role_name = $res1['role_name'];

		$auto_number = $res1["auto_number"];



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

                        <td width="11%" align="left" valign="top"  class="bodytext3">

						<a href="roles.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext3">

                          <div align="center" class="bodytext3">Activate</div>

                        </a></td>

                        <td width="35%" align="left" valign="top"  class="bodytext3"><?php echo $role_id; ?></td>

                        <td width="54%" align="left" valign="top"  class="bodytext3"><?php echo $role_name; ?></td>

        </tr>

                      <?php

		}

		?>

                      <tr>

                        <td align="middle" colspan="3" >&nbsp;</td>

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



