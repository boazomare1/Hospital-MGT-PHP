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



if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1')

{  

    $storeanum = $_REQUEST['storeanum'];

	$location = $_REQUEST["location"];

	$store = $_REQUEST["store"];

	$store = strtoupper($store);

	$store = trim($store);

	$storenumber = $_REQUEST["storeno"];
	$categoryname = $_REQUEST["categoryname"];
	$ph_categoryname = $_REQUEST["ph_categoryname"];
	$cc_name = $_REQUEST["cc_name"];
	$storeLable = $_REQUEST['storeLable'];
	$exp_accountname = $_REQUEST['exp_accountname'];
	$exp_accountid = $_REQUEST['exp_accountid'];



	$length=strlen($store);

	

	$query6 = "select * from master_location where auto_number = '$location'";

	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res6 = mysqli_fetch_array($exec6);

	$locationcode = $res6['locationcode'];

	$locationname = $res6['locationname'];

	//echo $length;

	if ($length<=100)

	{

	$query2 = "select * from master_store where auto_number = '$storeanum'";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res2 = mysqli_num_rows($exec2);

	if ($res2 != 0)

	{

	     $query1 = "update master_store set location = '$location',store = '$store',storecode = '$storenumber',locationcode = '$locationcode',category = '$categoryname', ph_categoryname='$ph_categoryname' , locationname = '$locationname', cost_center = '$cc_name',storelable='$storeLable',expense_ledger='$exp_accountid' where auto_number = '$storeanum'";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$errmsg = "Success. New Store Updated.";

		//$bgcolorcode = 'success';

		header ("location:addstore.php?bgcolorcode=success&&st=edit&&anum=$storeanum");

		

	}

	//exit();

	else

	{

		$errmsg = "Failed. Store Already Exists.";

		//$bgcolorcode = 'failed';

	header ("location:editstore1.php?bgcolorcode=failed&&st=edit&&anum=$storeanum");

	}

	}

	else

	{

		$errmsg = "Failed. Only 100 Characters Are Allowed.";

		//$bgcolorcode = 'failed';

		header ("location:editstore1.php?bgcolorcode=failed&&st=edit&&anum=$storeanum");

	}



}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == 'del')

{

	$delanum = $_REQUEST["anum"];

	$query3 = "update master_store set recordstatus = 'deleted' where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'activate')

{

	$delanum = $_REQUEST["anum"];

	$query3 = "update master_store set recordstatus = '' where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'default')

{

	$delanum = $_REQUEST["anum"];

	$query4 = "update master_store set defaultstatus = '' where cstid='$custid' and cstname='$custname'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));



	$query5 = "update master_store set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";

	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'removedefault')

{

	$delanum = $_REQUEST["anum"];

	$query6 = "update master_store set defaultstatus = '' where auto_number = '$delanum'";

	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

}



if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }

if ($svccount == 'firstentry')

{

	$errmsg = "Please Add Store To Proceed For Billing.";

	$bgcolorcode = 'failed';

}



if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }

if ($st == 'edit' && $anum != '')

{

	$query1 = "select * from master_store where auto_number = '$anum'";

	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res1 = mysqli_fetch_array($exec1);

	$res1autonumber = $res1['auto_number'];

    $res1location = $res1['location'];

    $res1store = $res1['store'];
	$storelable = $res1['storelable'];

	$res1storeno = $res1['storecode'];
	$categoryname = $res1['category'];
	$ph_categoryname = $res1['ph_categoryname'];
	
	$res1cc_name = $res1['cost_center'];
	$res1expenseledgercode = $res1['expense_ledger'];
			
		$query6122 = "select accountname from master_accountname where id = '$res1expenseledgercode'";

		$exec6122 = mysqli_query($GLOBALS["___mysqli_ston"], $query6122) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$res6122 = mysqli_fetch_array($exec6122);

		$res1expenseledgername = $res6122['accountname'];

	$query612 = "select * from master_costcenter where auto_number = '$res1cc_name' and recordstatus <> 'deleted'";

		$exec612 = mysqli_query($GLOBALS["___mysqli_ston"], $query612) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$res612 = mysqli_fetch_array($exec612);

		$cc_name = $res612['name'];
	
	

}



if (isset($_REQUEST["bgcolorcode"])) { $bgcolorcode = $_REQUEST["bgcolorcode"]; } else { $bgcolorcode = ""; }

if ($bgcolorcode == 'success')

{

		$errmsg = "Success. New Store Updated.";

}

if ($bgcolorcode == 'failed')

{

		$errmsg = "Failed. Visit Sub Already Exists.";

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

<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="js/jquery-ui.js" type="text/javascript"></script>
<link href="js/jquery-ui.css" rel="stylesheet">


<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

-->

</style>

</head>

<script language="javascript">

$(function() {

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




function addward1process1()

{

	//alert ("Inside Funtion");

	if (document.form1.store.value == "")

	{

		alert ("Pleae Enter Store Name.");

		document.form1.store.focus();

		return false;

	}
	
	if (document.form1.exp_accountid.value == "" || document.form1.exp_accountname.value == "")
	{
		alert ("Please Select the Expense Ledger Properly.");
		document.form1.exp_accountname.focus();
		return false;
	}

	// if (document.form1.categoryname.value == "")

	// {

	// 	alert ("Please Select Category.");

	// 	document.form1.store.focus();

	// 	return false;

	// }

}

function funcDeletestore(varstoreAutoNumber)

{

 var varstoreAutoNumber = varstoreAutoNumber;

	var fRet;

	fRet = confirm('Are you sure want to delete this account name '+varstoreAutoNumber+'?');

	//alert(fRet);

	if (fRet == true)

	{

		alert ("Store Entry Delete Completed.");

		//return false;

	}

	if (fRet == false)

	{

		alert ("Store Entry Delete Not Completed.");

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

              <td><form name="form1" id="form1" method="post" action="editstore.php" onSubmit="return addward1process1()">

                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Store Master - Edit </strong></td>

                      </tr>

					  <tr>

                        <td colspan="2" align="left" valign="middle"   

						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>

                      </tr>

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New  Location </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<select name="location" id="location"  style="border: 1px solid #001E6A;">

                          <?php

						

						if ($res1location == '')

						{

						echo '<option value="" selected="selected">Select Location</option>';

						}

						else

						{

						$query4 = "select * from master_location where auto_number = '$res1location'";

						$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res4 = mysqli_fetch_array($exec4);

						$res4dlocationanum = $res4['auto_number'];

						$res4locationname = $res4['locationname'];

					

						echo '<option value="'.$res4dlocationanum.'" selected="selected">'.$res4locationname.'</option>';

						}

					

						$query5 = "select * from master_location where status = '' order by locationname";

						$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res5 = mysqli_fetch_array($exec5))

						{

						$res5anum = $res5["auto_number"];

						$res5location = $res5["locationname"];

						?>

						<option value="<?php echo $res5anum; ?>"><?php echo $res5location; ?></option>

						<?php

						}

						?>

                        </select></td>

                      </tr>

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New Store </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="store" id="store"  value="<?php echo $res1store;?>"style="border: 1px solid #001E6A; text-transform:uppercase" size="40" /></td>

                      </tr>

					   <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right"> Store No </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="storeno" id="storeno"  value="<?php echo $res1storeno;?>"style="border: 1px solid #001E6A; text-transform:uppercase" size="40" readonly/></td>

                      </tr>

					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right"> Label </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="storeLable" id="storeLable" >
						<option value='pharmacy' <?php if($storelable=='pharmacy') echo 'selected'; else echo '';?>>Pharmacy</option>
						<option value='ward' <?php if($storelable=='ward') echo 'selected'; else echo '';?> >Ward Items</option>
						<option value='theater' <?php if($storelable=='theater') echo 'selected'; else echo '';?> >Theater</option>
						<option value='icu' <?php if($storelable=='icu') echo 'selected'; else echo '';?> >ICU</option>
						</select>
						</td>
                      </tr>	

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Service Category</div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF"><select id="categoryname" name="categoryname" >

                          <?php

						if ($categoryname != '')

						{

						?>

                          <option value="<?php echo $categoryname; ?>" selected="selected"><?php echo $categoryname; ?></option>
                          <option value="" >Select Service Category</option>

                          <?php

						}

						else

						{

						?>

                          <option value="" selected="selected">Select Service Category</option>

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

                         </td>
                          </tr>

                           <tr>
                        <td align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Pharmacy Category   </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
                        	<select id="ph_categoryname" name="ph_categoryname" >
                          <?php
						if ($ph_categoryname != '')
						{
						?>
                          <option value="<?php echo $ph_categoryname; ?>" selected="selected"><?php echo $ph_categoryname; ?></option>
                          <option value="" >Select Pharmacy Category</option>
                          <?php
						}
						else
						{
						?>
                          <option value="" selected="selected">Select Pharmacy Category</option>
                          <?php
						}
						$query12 = "select * from master_categorypharmacy where status <> 'deleted' order by categoryname";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res12 = mysqli_fetch_array($exec12))
						{
						$res1categoryname2 = $res12["categoryname"];
						?>
                          <option value="<?php echo $res1categoryname2; ?>"><?php echo $res1categoryname2; ?></option>
                          <?php
						}
						?>
                        </select>
                           
						 </td>
					    </tr>
						
						
						
						<tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Cost Center</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><select id="cc_name" name="cc_name" >
                          <?php
						if ($cc_name != '')
						{
						?>
                          <option value="<?php echo $res1cc_name; ?>" selected="selected"><?php echo $cc_name; ?></option>
                          <option value="" >Select Cost Center</option>
                          <?php
						}
						else
						{
						?>
                          <option value="" selected="selected">Select Cost Center</option>
                          <?php
						}
						$query1 = "select * from master_costcenter where recordstatus <> 'deleted' order by name";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1name = $res1["name"];
						$res1auto_number = $res1["auto_number"];
						?>
                          <option value="<?php echo $res1auto_number; ?>"><?php echo $res1name; ?></option>
                        <?php
						}
						?>
                        </select>
                         </td>
                        </tr>
						  
						  <tr>
                        <td align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Expense Ledger</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
                      	<input type="text" name="exp_accountname" id="exp_accountname" size="50" value="<?php echo $res1expenseledgername;?>" />
						<input type="hidden" name="exp_accountauto" id="exp_accountauto" value="" />
						<input type="hidden" name="exp_accountid" id="exp_accountid" value="<?php echo $res1expenseledgercode;?>" />
                           
						 </td>
					    </tr>
  

                      <tr>

                        <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                        <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF">

						<input type="hidden" name="frmflag" value="addnew" />

                        <input type="hidden" name="frmflag1" value="frmflag1" />

						<input type="hidden" name="storeanum" id="storeanum" value="<?php echo $res1autonumber; ?>">

                          <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" /></td>

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



