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

$scheme_id = $_REQUEST['scheme_id'];

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1')

{

  $length=10;

	$maintype = $_REQUEST["paymenttype"];
	$scheme_name = $_REQUEST["scheme_name"];
	$scheme_expiry = $_REQUEST["scheme_expiry"];
	$scheme_active_status = $_REQUEST["scheme_active_status"];

	
	$subtype = $_REQUEST["subtype"];
	$query22 = "select subtype_ledger from master_subtype where auto_number = '$subtype'";
	$exec221 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res221 = mysqli_fetch_array($exec221);
	$subtype_ledger = $res221['subtype_ledger'];
	
	$query_an = "select auto_number from master_accountname where id = '$subtype_ledger'";
	$exec_an = mysqli_query($GLOBALS["___mysqli_ston"], $query_an) or die ("Error in query_an".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res_an = mysqli_fetch_array($exec_an);
	$accountname = $res_an['auto_number'];

	
	
	if ($length<=255)

	{
		/* $query201 = "INSERT INTO audit_master_planname (plan_id,maintype, subtype, accountname, planname, planstatus, plancondition, planfixedamount,planpercentage,

		overalllimitop, overalllimitip, opvisitlimit,ipvisitlimit ,smartap,recordstatus,ipaddress, recorddate, username, planstartdate, planexpirydate,exclusions,forall,planapplicable,departmentlimit,pharmacylimit,lablimit,radiologylimit,serviceslimit) SELECT auto_number,maintype, subtype, accountname, planname, planstatus, plancondition, planfixedamount,planpercentage,

		overalllimitop, overalllimitip, opvisitlimit,ipvisitlimit ,smartap,recordstatus,ipaddress, recorddate, username, planstartdate, planexpirydate,exclusions,forall,planapplicable,departmentlimit,pharmacylimit,lablimit,radiologylimit,serviceslimit FROM master_planname where auto_number = '$plannameanum'";
		$exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201); */

		$query1 = "update master_planname set maintype = '$maintype', subtype = '$subtype',accountname = '$accountname',scheme_name = '$scheme_name',scheme_expiry = '$scheme_expiry',scheme_active_status = '$scheme_active_status' where scheme_id = '$scheme_id'";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		
		

		//$bgcolorcode = 'success';

		header ("location:addplanname1.php");

	

	}

	else

	{

		$errmsg = "Failed. Only 100 Characters Are Allowed.";

		//$bgcolorcode = 'failed';

		header ("location:addplanname1.php");

	}



}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }


if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }




if (isset($_REQUEST["scheme_id"])) { $scheme_id = $_REQUEST["scheme_id"]; } else { $scheme_id = ""; }

if ($scheme_id != '')

{

	$query1 = "select * from master_planname where scheme_id = '$scheme_id' and scheme_status='new'";

	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res1 = mysqli_fetch_array($exec1);

	

	$res1autonumber = $res1['auto_number'];

    $res1maintype = $res1["maintype"];

	$res1subtype =  $res1["subtype"];

	$res1accountname =  $res1["accountname"];

	$scheme_name = $res1['scheme_name'];
	$scheme_expiry = $res1['scheme_expiry'];
	$scheme_active_status = $res1['scheme_active_status'];
	$scheme_id = $res1['scheme_id'];
}



   

if (isset($_REQUEST["bgcolorcode"])) { $bgcolorcode = $_REQUEST["bgcolorcode"]; } else { $bgcolorcode = ""; }

if ($bgcolorcode == 'success')

{

	$errmsg = "Success. Scheme Details  Updated.";

}

if ($bgcolorcode == 'failed')

{

	$errmsg = "Failed. Scheme Details Not Updated.";

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

.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

-->

</style>

</head>

<script language="javascript">

function checking(){

		//alert('ok');

	var vlimit = document.getElementById("vlimit");

	var alllimit = document.getElementById("alllimit");

	var overalllimit = document.getElementById("overalllimit");

	var visitlimit = document.getElementById("visitlimit");

	var limit = document.getElementsByClassName("limit");

	if(vlimit.checked){

		vlimit.checked = true;

		alllimit.checked = false;

		overalllimit.disabled = true;

		overalllimit.value ='';

		visitlimit.disabled = false;	

	}else if(alllimit.checked){

		alllimit.checked = true;

		vlimit.checked = false;

		visitlimit.disabled = true;

		visitlimit.value = '';

		overalllimit.disabled = false;	

	}

	}

function addplanname1process1()

{
	if (document.form1.subtype.value == "")

	{

		alert ("Please Select Sub Type.");

		document.form1.subtype.focus();

		return false;

	}

	if (document.form1.scheme_name.value == "")

	{

		alert ("Please Enter Scheme Name.");

		document.form1.scheme_name.focus();

		return false;

	}
$('#paymenttype').attr("disabled", false);
$('#subtype').attr("disabled", false);
$('#scheme_active_status').attr("disabled", false);
    if(confirm("Do You Want To Save The Record? ")==false) 
	{
		return false;
	}
	

}



function funcPaymentTypeChange1()

{
$('#subtype').attr("disabled", false);
	//alert("hi");

	/*if(document.getElementById("paymenttype").value == "1")

	{

		alert("You Cannot Add Account For CASH Type");

		document.getElementById("paymenttype").focus();

		return false;

	}*/



	<?php 

	$query12 = "select * from master_paymenttype where recordstatus = ''";

	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

	while ($res12 = mysqli_fetch_array($exec12))

	{

	$res12paymenttypeanum = $res12['auto_number'];

	$res12paymenttype = $res12["paymenttype"];

	?>

	if(document.getElementById("paymenttype").value=="<?php echo $res12paymenttypeanum; ?>")

	{

		document.getElementById("subtype").options.length=null; 

		var combo = document.getElementById('subtype'); 	

		<?php 

		$loopcount=0;

		?>

		combo.options[<?php echo $loopcount;?>] = new Option ("Select Sub Type", ""); 

		<?php

		$query10 = "select * from master_subtype where maintype = '$res12paymenttypeanum' and recordstatus = '' and subtype_ledger<>'' ";

		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res10 = mysqli_fetch_array($exec10))

		{

		$loopcount = $loopcount+1;

		$res10subtypeanum = $res10['auto_number'];

		$res10subtype = $res10["subtype"];

		?>

			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10subtype;?>", "<?php echo $res10subtypeanum;?>"); 

		<?php 

		}

		?>

	}

	<?php

	}

	?>	

}



</script>



<script src="js/datetimepicker_css.js"></script>


<script src="js/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script>
	/* $(function() {

		$('#scheme_name').autocomplete({

			source: 'getSchemename.php',

			minLength: 2,
			delay: 0,
			html: true,
			select: function(event, ui) {
				var scheme_id = ui.item.scheme_id;
				var scheme_expiry = ui.item.scheme_expiry;
				var scheme_active_status = ui.item.scheme_active_status;
				$('#scheme_id').val(scheme_id);
				$('#scheme_expiry').val(scheme_expiry);
				$('#scheme_active_status').val(scheme_active_status);
				$('#scheme_active_status').attr("disabled", true); 
				$('#schm_date').css('display', 'none');
			}
		});
	});
	
	function removeScheme()
	{
		if($('#scheme_id').val()!=''){
		$('#scheme_id').val('');
		$('#scheme_active_status').attr("disabled", false); 
		$('#schm_date').css('display', 'block');
		}
	} */
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

              <td><form name="form1" id="form1" method="post" action="editscheme.php" onSubmit="return addplanname1process1()">

              <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber" style="border-collapse: collapse">

                      <tbody>

                        <tr bgcolor="#011E6A">

                          <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Plan Name Master - Edit</strong></td>

                        </tr>

                        <tr>

                          <td colspan="4" align="left" valign="middle"   

						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>

                        </tr>

                        <tr>

                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Main Type </div></td>

                          <td align="left" colspan="3" valign="top"  bgcolor="#FFFFFF">

                          

                          <input name="plannameanum" id="plannameanum"  type="hidden" value="<?php echo $plannameanum;?>"/>

                          <select name="paymenttype" id="paymenttype" onChange="return funcPaymentTypeChange1();" >

                            <?php

				if ($res1maintype == '')

				{

					echo '<option value="" selected="selected">Select Type</option>';

				}

				else

				{

					$query4 = "select * from master_paymenttype where auto_number = '$res1maintype'";

					$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

					$res4 = mysqli_fetch_array($exec4);

					$res4dmaintypeanum = $res4['auto_number'];

					$res4maintypename = $res4['paymenttype'];

					

					echo '<option value="'.$res4dmaintypeanum.'" selected="selected">'.$res4maintypename.'</option>';

				}

				

				$query5 = "select * from master_paymenttype where recordstatus = '' order by paymenttype";

				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

				while ($res5 = mysqli_fetch_array($exec5))

				{

				$res5anum = $res5["auto_number"];

				$res5paymenttype = $res5["paymenttype"];

				?>

                          <option value="<?php echo $res5anum; ?>"><?php echo $res5paymenttype; ?></option>

                          <?php

				}

				?>

                          </select></td>

                        </tr>

                        <tr>

                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Sub Type </div></td>

                          <td align="left" colspan="3" valign="top"  bgcolor="#FFFFFF"><select disabled name="subtype" id="subtype" onChange="return funcSubTypeChange1()" >

                           <?php   	if ($res1subtype == '')

								 {

						   echo '<option value="" selected="selected">Select Sub Type</option>';

					       }

					     else

					     {

						$query4 = "select * from master_subtype where auto_number = '$res1subtype'";

						$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res4 = mysqli_fetch_array($exec4);

						$res4subtypeanum = $res4['auto_number'];

						$res4subtypename = $res4['subtype'];

					

						echo '<option value="'.$res4subtypeanum.'" selected="selected">'.$res4subtypename.'</option>';

					      }

					

					$query5 = "select * from master_subtype where recordstatus = '' order by subtype";

					$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

					while ($res5 = mysqli_fetch_array($exec5))

					{

					$res5anum = $res5["auto_number"];

					$res5subtype = $res5["subtype"];

					?>

							  <option value="<?php echo $res5anum; ?>"><?php echo $res5subtype; ?></option>

                          <?php

				}

				?>

                          </select></td>

                        </tr>

                        <tr>

                          <!--<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Account Name </div></td>

                          <td align="left" valign="top" colspan="3"  bgcolor="#FFFFFF"><strong>

                            <select name="accountname" id="accountname">

                               <?php

				if ($res1accountname == '')

				{

					echo '<option value="" selected="selected">Select Type</option>';

				}

				else

				{

					$query4 = "select * from master_accountname where auto_number = '$res1accountname'";

					$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

					$res4 = mysqli_fetch_array($exec4);

					$res4res1accountnameanum = $res4['auto_number'];

					$res4res1accountname = $res4['accountname'];

				

					echo '<option value="'.$res4res1accountnameanum.'" selected="selected">'.$res4res1accountname.'</option>';

				}

				

				$query5 = "select * from master_accountname where recordstatus = '' order by accountname";

				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

				while ($res5 = mysqli_fetch_array($exec5))

				{

				$res5anum = $res5["auto_number"];

				$res5accountname = $res5["accountname"];

				?>

                          <option value="<?php echo $res5anum; ?>"><?php echo $res5accountname; ?></option>

                          <?php

				}

				?>

                            </select>

                          </strong></td>-->
							<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Scheme Name </div></td>

                          <td align="left" valign="top" colspan="3" bgcolor="#FFFFFF">
						  <input name="scheme_name" id="scheme_name"   size="40" value="<?php echo $scheme_name;?>" onkeypress="return removeScheme();"/>
						  </td>

                          <input type="hidden" name="scheme_id" id="scheme_id" value="<?php echo $scheme_id;?>">
                        </tr>
						 <tr>

                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Scheme Expiry </div></td>

                          <td align="left" valign="top"  bgcolor="#FFFFFF"><strong>
						  
							<input name="scheme_expiry" id="scheme_expiry"  size="10" value="<?php echo $scheme_expiry ?>" readonly />
                           <img src="images2/cal.gif" onClick="javascript:NewCssCal('scheme_expiry')" style="cursor:pointer"/>

                          </strong></td>

                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Scheme Status </div></td>

                          <td align="left" valign="top"  bgcolor="#FFFFFF"><strong>

                           <select name="scheme_active_status" id="scheme_active_status" >

                             
                              <option <?php if($scheme_active_status=='ACTIVE'){ ?> selected <?php } ?>value="ACTIVE">ACTIVE</option>

                              <option <?php if($scheme_active_status=='DELETED'){ ?> selected <?php } ?> value="DELETED">INACTIVE</option>

                            </select>

                          </strong></td>

                        </tr>

                        <tr>

                          <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                          <td width="58%" align="left" valign="top" colspan="3"  bgcolor="#FFFFFF"><input type="hidden" name="frmflag" value="addnew" />

                            <input type="hidden" name="frmflag1" value="frmflag1" />

                            <input type="submit" name="Submit" value="Submit" /></td>

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



