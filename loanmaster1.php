<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

$username = $_SESSION["username"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];



$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$errmsg = "";

$bgcolorcode = "";

$colorloopcount = "";

$amount1 = '';



if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1')

{

	$loanname = $_REQUEST['loanname'];

	$loanname = strtoupper($loanname);

	$installments = $_REQUEST['installments'];

	if(isset($_REQUEST['interestapplicable'])) { $interestapplicable = $_REQUEST['interestapplicable']; }

	else { $interestapplicable = 'No'; }

	if(isset($_REQUEST['interest'])) { $interest = $_REQUEST['interest']; }

	else { $interest = ''; }

	$fringerate = $_REQUEST['fringerate'];

	

	$query1 = "insert into master_loan (loanname, installments, interestapplicable, interest, fringerate, username, ipaddress, updatedatetime)

	values('$loanname', '$installments', '$interestapplicable', '$interest', '$fringerate', '$username', '$ipaddress', '$updatedatetime')";

	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

	

	header("location:loanmaster1.php?st=success");

}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == 'del')

{

	$delanum = $_REQUEST['anum'];

	$query3 = "update master_loan set status = 'deleted' where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'activate')

{

	$anum = $_REQUEST['anum'];

	$query3 = "update master_loan set status = '' where auto_number = '$anum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

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



function addward1process1()

{

	if(document.getElementById("loanname").value == "")

	{

		alert("Please Enter Name");

		document.getElementById("loanname").focus();

		return false;

	}

	if(document.getElementById("installments").value == "")

	{

		alert("Please Enter Max Installments");

		document.getElementById("installments").focus();

		return false;

	}

	if(isNaN(document.getElementById("installments").value))

	{

		alert("Please Enter Numbers");

		document.getElementById("installments").focus();

		return false;

	}

	if(document.getElementById("interestapplicable").checked == true)

	{

		if(document.getElementById("interest").value == "")

		{

			alert("Please Enter interest");

			document.getElementById("interest").focus();

			return false;

		}

		if(isNaN(document.getElementById("interest").value))

		{

			alert("Please Enter Numbers");

			document.getElementById("interest").focus();

			return false;

		}

	}

	

}



function AppInterest()

{

	if(document.getElementById("interestapplicable").checked == true)

	{

		document.getElementById("interest").disabled = false;

	}

	else

	{

		document.getElementById("interest").disabled = true;

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

              <td><form name="form1" id="form1" method="post" action="loanmaster1.php" onSubmit="return addward1process1()">

                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>LOAN Master</strong></td>

                      </tr>

					  <tr>

                        <td colspan="2" align="left" valign="middle"   

						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>

                      </tr>

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Loan Name </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="loanname" id="loanname" value="" style="border: 1px solid #001E6A;" size="25" /></td>

                      </tr>

					  <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Max Installments </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="installments" id="installments" value="" style="border: 1px solid #001E6A;" size="10" /></td>

                      </tr>

					  <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Is Interest Applicable ? </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input type="checkbox" name="interestapplicable" id="interestapplicable" value="Yes" style="border: 1px solid #001E6A;" onClick="return AppInterest()" /></td>

                      </tr>

					  <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Interest </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input type="text" disabled="disabled" name="interest" id="interest" value="" style="border: 1px solid #001E6A;" size="10" /><span class="bodytext3">&nbsp; %</span></td>

                      </tr>

					  <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Fringe Benefit Corporation Tax Rate</div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="fringerate" id="fringerate" value="" style="border: 1px solid #001E6A;" size="10" /></td>

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

                        <td colspan="7" bgcolor="#ecf0f5" class="bodytext3"><strong>LOAN Master - Existing List </strong></td>

                      </tr>

					  <tr bgcolor="#ecf0f5">

					  <td align="center" class="bodytext3"><strong>Delete</strong></td>

					  <td align="left" class="bodytext3"><strong>Loan Name</strong></td>

					  <td align="left" class="bodytext3"><strong>Installments</strong></td>

					  <td align="left" class="bodytext3"><strong>Interest Applicable</strong></td>

					  <td align="right" class="bodytext3"><strong>Interest</strong></td>

					  <td align="right" class="bodytext3"><strong>Fringe Rate</strong></td>


					  </tr>

                      <?php

						$query1 = "select * from master_loan where status <> 'deleted'";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res1 = mysqli_fetch_array($exec1))

						{

						$auto_number = $res1['auto_number'];

						$loanname = $res1['loanname'];

						$installments = $res1['installments'];

						$interestapplicable = $res1['interestapplicable']; 

						$interest = $res1['interest'];

						$fringerate = $res1['fringerate'];

	

				

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

						<td width="8%" align="left" valign="top"  class="bodytext3">

						<div align="center">	

						<a href="loanmaster1.php?st=del&&anum=<?php echo $auto_number; ?>"> 

						<img src="images/b_drop.png" width="16" height="16" border="0" /></a></div>

						</td>

                        <td width="20%" align="left" valign="top"  class="bodytext3"><?php echo $loanname;?> </td>

						<td width="15%" align="left" valign="top"  class="bodytext3"><?php echo $installments;?> </td>

						<td width="17%" align="left" valign="top"  class="bodytext3"><?php echo $interestapplicable;?> </td>

						<td width="15%" align="right" valign="top"  class="bodytext3"><?php echo $interest;?> </td>

						<td width="18%" align="right" valign="top"  class="bodytext3"><?php echo $fringerate;?> </td>


                      </tr>

                      <?php

						}

						?>

                      <tr>

                        <td align="middle" colspan="7" >&nbsp;</td>

                      </tr>

                    </tbody>

                  </table>

				  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <td colspan="7" bgcolor="#ecf0f5" class="bodytext3"><strong>LOAN Master - Deleted </strong></td>

                      </tr>

					  <tr bgcolor="#ecf0f5">

					  <td align="center" class="bodytext3"><strong>Activate</strong></td>

					  <td align="left" class="bodytext3"><strong>Loan Name</strong></td>

					  <td align="left" class="bodytext3"><strong>Installments</strong></td>

					  <td align="left" class="bodytext3"><strong>Interest Applicable</strong></td>

					  <td align="right" class="bodytext3"><strong>Interest</strong></td>

					  <td align="right" class="bodytext3"><strong>Fringe Rate</strong></td>


					  </tr>

                      <?php

						$query1 = "select * from master_loan where status = 'deleted'";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res1 = mysqli_fetch_array($exec1))

						{

						$auto_number1 = $res1['auto_number'];

						$loanname = $res1['loanname'];

						$installments = $res1['installments'];

						$interestapplicable = $res1['interestapplicable']; 

						$interest = $res1['interest'];

						$fringerate = $res1['fringerate'];

	

				

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

						<td width="8%" align="left" valign="top"  class="bodytext3">

						<div align="center">	

						<a href="loanmaster1.php?st=activate&&anum=<?php echo $auto_number1; ?>"> 

						<span class="bodytext3">Activate</span></a></div>

						</td>

                        <td width="20%" align="left" valign="top"  class="bodytext3"><?php echo $loanname;?> </td>

						<td width="15%" align="left" valign="top"  class="bodytext3"><?php echo $installments;?> </td>

						<td width="17%" align="left" valign="top"  class="bodytext3"><?php echo $interestapplicable;?> </td>

						<td width="15%" align="right" valign="top"  class="bodytext3"><?php echo $interest;?> </td>

						<td width="18%" align="right" valign="top"  class="bodytext3"><?php echo $fringerate;?> </td>

                      </tr>

                      <?php

						}

						?>

                      <tr>

                        <td align="middle" colspan="7" >&nbsp;</td>

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

	</td>

	</tr>

  </table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>



