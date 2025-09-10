<?php

session_start();

include("includes/loginverify.php");

include("db/db_connect.php");

$username =  isset($_REQUEST['username']) ? $_REQUEST['username'] : '';

// $companyanum = $_SESSION["companyanum"];

// $companyname = $_SESSION["companyname"];



$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$errmsg = "";

$bgcolorcode = "";

$colorloopcount = "";


if (isset($_REQUEST["searchsuppliername"])) {
	$searchsuppliername = $_REQUEST["searchsuppliername"];
} else {
	$searchsuppliername = "";
}

if (isset($_REQUEST["searchdescription"])) {
	$searchdescription = $_REQUEST["searchdescription"];
} else {
	$searchdescription = "";
}

if (isset($_REQUEST["searchemployeecode"])) {
	$searchemployeecode = $_REQUEST["searchemployeecode"];
} else {
	$searchemployeecode = "";
}



if (isset($_POST["frmflag1"])) {
	$frmflag1 = $_POST["frmflag1"];
} else {
	$frmflag1 = "";
}

if ($frmflag1 == 'frmflag1') {

	$username1 = $_REQUEST['username1'];

	$username = $_REQUEST['username1'];

	$newpassword = $_REQUEST['newpassword'];

	$samePassword = false;

	$newpassword = base64_encode($newpassword);

	$query2 = "select * from master_employee where username = '$username1'";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in Query2" . mysqli_error($GLOBALS["___mysqli_ston"]));

	$res2 = mysqli_num_rows($exec2);

	if ($res2 != 0) {

		if ($samePassword) {
			header("location:passwordreset.php?bgcolorcode=failed2&username=$username");
			exit();
		}

		$query1 = "update master_employee set password = '$newpassword', password_date='$updatedatetime' where username = '$username1'";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));

		$errmsg = "Success. New Password Updated.";

		//$bgcolorcode = 'success';

		header("location:mainmenu1.php?mainmenuid=MM000");
	} else {

		$errmsg = "Failed. Please Check Username and Password";

		//$bgcolorcode = 'failed';

		header("location:passwordreset.php?bgcolorcode=failed&username=$username");
		exit();
	}
}



if (isset($_REQUEST["st"])) {
	$st = $_REQUEST["st"];
} else {
	$st = "";
}

if ($st == 'del') {

	$delanum = $_REQUEST["anum"];

	$query3 = "update master_salutation set recordstatus = 'deleted' where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query3" . mysqli_error($GLOBALS["___mysqli_ston"]));
}

if ($st == 'activate') {

	$delanum = $_REQUEST["anum"];

	$query3 = "update master_salutation set recordstatus = '' where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query3" . mysqli_error($GLOBALS["___mysqli_ston"]));
}

if ($st == 'default') {

	$delanum = $_REQUEST["anum"];

	$query4 = "update master_salutation set defaultstatus = '' where cstid='$custid' and cstname='$custname'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die("Error in Query4" . mysqli_error($GLOBALS["___mysqli_ston"]));



	$query5 = "update master_salutation set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";

	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die("Error in Query5" . mysqli_error($GLOBALS["___mysqli_ston"]));
}

if ($st == 'removedefault') {

	$delanum = $_REQUEST["anum"];

	$query6 = "update master_salutation set defaultstatus = '' where auto_number = '$delanum'";

	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die("Error in Query6" . mysqli_error($GLOBALS["___mysqli_ston"]));
}





if (isset($_REQUEST["svccount"])) {
	$svccount = $_REQUEST["svccount"];
} else {
	$svccount = "";
}

if ($svccount == 'firstentry') {

	$errmsg = "Please Add Salutation To Proceed For Billing.";

	$bgcolorcode = 'failed';
}









if (isset($_REQUEST["bgcolorcode"])) {
	$bgcolorcode = $_REQUEST["bgcolorcode"];
} else {
	$bgcolorcode = "";
}

if ($bgcolorcode == 'success') {

	$errmsg = "Success. New Password Updated.";
}

if ($bgcolorcode == 'failed') {

	$errmsg = "Failed. Please Check Username and Password.";
}

if ($bgcolorcode == 'failed2') {

	$errmsg = "New Password should not be same as old.";
}


if (isset($_REQUEST["searchemployeecode"])) {
	$selectemployeecode = $_REQUEST["searchemployeecode"];
} else {
	$selectemployeecode = "";
}

//$selectemployeecode = $_REQUEST['selectemployeecode'];

$query7 = "select * from master_employee where employeecode = '$selectemployeecode'";

$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die("Error in Query7" . mysqli_error($GLOBALS["___mysqli_ston"]));

$res7 = mysqli_fetch_array($exec7);



$res7employeecode = $res7['employeecode'];

$res7employeename = $res7['employeename'];

$res7employeename = strtoupper($res7employeename);

$res7employeename = trim($res7employeename);

$res7username = $res7['username'];




?>

<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />


<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="js/jquery-ui.js" type="text/javascript"></script>
<link href="js/jquery-ui.css" rel="stylesheet">

<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<style type="text/css">
	<!--
	.bodytext31 {
		FONT-WEIGHT: normal;
		FONT-SIZE: 11px;
		COLOR: #3b3b3c;
		FONT-FAMILY: Tahoma
	}
	-->

</style>
<script>
	$(function() {



		$('#searchsuppliername').autocomplete({



			source: 'ajaxemployeenewsearch.php',

			//alert(source);

			minLength: 3,

			delay: 0,

			html: true,

			select: function(event, ui) {

				var code = ui.item.id;

				var employeecode = ui.item.employeecode;

				var employeename = ui.item.employeename;

				console.log("code", employeecode);
				console.log("name", employeename);

				$('#searchemployeecode').val(employeecode);

				$('#searchsuppliername').val(employeename);



			},

		});

	});
</script>
<script language="javascript">
	function funcEmployeeSelect1()

	{

		if (document.getElementById("selectemployeecode").value == "")

		{

			alert("Please Select Employee Code To Edit.");

			document.getElementById("selectemployeecode").focus();

			return false;

		}

	}

	function addsalutation1process1()

	{

		//alert ("Inside Funtion");

		if (document.form1.username.value == "")

		{

			alert("Please Enter User Name.");

			document.form1.username.focus();

			return false;

		}



		if (document.form1.newpassword.value == "") {
			alert("Please Enter New Password.");

			document.form1.newpassword.focus();

			return false;
		}


	}



	function funcDeleteSalutation(varSalutationAutoNumber)

	{

		var varSalutationAutoNumber = varSalutationAutoNumber;

		var fRet;

		fRet = confirm('Are you sure want to delete this Salutation Type ' + varSalutationAutoNumber + '?');

		//alert(fRet);

		if (fRet == true)

		{

			alert("Salutation Entry Delete Completed.");

			//return false;

		}

		if (fRet == false)

		{

			alert("Salutation Entry Delete Not Completed.");

			return false;

		}



	}
</script>

</head>


<?php include("includes/header.php");
?>

<body>

	<div class="table-responsive">
		<table border="0" cellspacing="0" cellpadding="2">

			<tr>

				<td colspan="10" bgcolor="#ECF0F5"><?php // include ("includes/alertmessages1.php"); 
													?></td>

			</tr>

			<tr>

				<td colspan="10" bgcolor="#ECF0F5"><?php // include ("includes/title1.php"); 
													?></td>

			</tr>

			<tr>

				<td colspan="10" bgcolor="#ECF0F5"><?php // include ("includes/menu1.php"); 
													?></td>

			</tr>

			<tr>


				<td valign="top">

					<form name="selectemployee" id="selectempoyee" method="post" action="passwordresetadmin.php?st=edit" onSubmit="return funcEmployeeSelect1()">

						<table width="900" height="29" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

							<tbody>

								<?php if ($errmsg != '') { ?>

									<tr>

										<td align="left" valign="middle" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

										<td colspan="2" align="left" valign="middle" bgcolor="<?php if ($errmsg == '') {
																									echo '#FFFFFF';
																								} else {
																									echo '#AAFF00';
																								} ?>" class="bodytext3"><?php echo $errmsg; ?>&nbsp;</td>

									</tr>

								<?php } ?>

								<tr>

									<td width="19%" align="left" valign="middle" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

									<td width="21%" align="left" valign="middle" bgcolor="#FFFFFF" class="bodytext3"><strong>Select Employee To Edit </strong></td>

									<td width="60%" align="left" valign="middle" bgcolor="#FFFFFF" class="bodytext3">

										<input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">

										<input name="searchdescription" id="searchdescription" type="hidden" value="">

										<input name="searchemployeecode" id="searchemployeecode" type="hidden" value="">

										<input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">

										<input type="submit" name="Submit" value="Submit">
									</td>

								</tr>

							</tbody>

						</table>

					</form>
				</td>
			</tr>

			<tr>

				<td colspan="10">&nbsp;</td>

			</tr>

			<tr>

				<td valign="top">
					<div class="table-responsive">
						<table border="0" cellspacing="0" cellpadding="0">

							<tr>

								<td>
									<div class="table-responsive">
										<table border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">

											<tr>

												<td>

													<?php

													if ($selectemployeecode != '') {

													?>
														<form name="form1" id="form1" method="post" action="passwordresetadmin.php" onSubmit="return addsalutation1process1()">

															<div class="table-responsive">
																<table border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

																	<tbody>

																		<tr bgcolor="#011E6A">

																			<td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Admin Change Password</strong></td>

																		</tr>

																		<tr>

																			<td colspan="2" align="left" valign="middle" bgcolor="<?php if ($bgcolorcode == '') {
																																		echo '#FFFFFF';
																																	} else if ($bgcolorcode == 'success') {
																																		echo '#AAFF00';
																																	} else if ($bgcolorcode == 'failed' || $bgcolorcode == 'failed2') {
																																		echo '#FFBF00';
																																	} ?>" class="bodytext3">
																				<div align="left"><?php echo $errmsg; ?></div>
																			</td>

																		</tr>

																		<tr>

																			<td align="left" valign="middle" bgcolor="#FFFFFF" class="bodytext3">
																				<div align="right">Current Username</div>
																			</td>

																			<td align="left" valign="top" bgcolor="#FFFFFF">

																				<input name="username1" id="username1" value="<?php echo $res7username; ?>" style="border: 1px solid #001E6A;" size="40" required />
																			</td>

																		</tr>

																		<tr>

																			<td align="left" valign="middle" bgcolor="#FFFFFF" class="bodytext3">
																				<div align="right"> New Password </div>
																			</td>

																			<td align="left" valign="top" bgcolor="#FFFFFF">

																				<input name="newpassword" id="newpassword" value="" style="border: 1px solid #001E6A;" size="40" autocomplete="off" required />
																			</td>

																		</tr>



																		<tr>

																			<td align="left" valign="top" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

																			<td align="left" valign="top" bgcolor="#FFFFFF">

																				<input type="hidden" name="frmflag" value="addnew" />

																				<input type="hidden" name="frmflag1" value="frmflag1" />

																				<input type="hidden" name="salutationanum" id="salutationanum" value="<?php echo $res1autonumber; ?>">

																				<input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" />
																			</td>

																		</tr>

																		<tr>

																			<td align="middle" colspan="2">&nbsp;</td>

																		</tr>

																	</tbody>

																</table>
															</div>

														</form>

													<?php } ?>

												</td>

											</tr>

											<tr>

												<td>&nbsp;</td>

											</tr>

										</table>
									</div>
								</td>

							</tr>

							<tr>

								<td>&nbsp;</td>

							</tr>

						</table>
					</div>

		</table>
	</div>

	<?php include("includes/footer1.php"); ?>

</body>

</html>