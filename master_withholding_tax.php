<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$username = $_SESSION["username"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];



$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$errmsg = "";

$bgcolorcode = "";

$colorloopcount = "";



$docno = $_SESSION['docno'];

$query = "select * from master_location where  status <> 'deleted' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

	

	 $locationname  = $res["locationname"];

	 $locationcode = $res["locationcode"];

	 $res12locationanum = $res["auto_number"];

	 

	 

//get location for sort by location purpose

  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

	if($location!='')

	{

		 $locationcode=$location;

		}

		//location get end here

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1')

{



	$name = $_REQUEST["name"];

	// $department = strtoupper($department);

	// $department = trim($department);

	$length=strlen($name);

	$taxid = $_REQUEST["taxid"];
	// $name = $_REQUEST["name"];
	$percentage = $_REQUEST["percentage"];
	$saccountname = $_REQUEST["saccountname"];
	$saccountid = $_REQUEST["saccountid"];
	$type = $_REQUEST["type"];	

	

	$query1 = "select * from master_location where status <> 'deleted' and locationcode = '".$locationcode."'";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res1 = mysqli_fetch_array($exec1);

						

						$locationname = $res1["locationname"];

						

	//echo $length;

	if ($length<=100)

	{

	$query2 = "SELECT * from master_withholding_tax where tax_id = '$taxid'";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res2 = mysqli_num_rows($exec2);

	if ($res2 == 0)

	{

		// $query1 = "insert into master_department (department, ipaddress, recorddate, username,rate1,rate2,rate3,locationcode,locationname,skiptriage) 

		// values ('$department', '$ipaddress', '$updatedatetime', '$username','$rate1','$rate2','$rate3','".$locationcode."','".$locationname."','$skiptriage')";

		$query1 ="INSERT INTO `master_withholding_tax`(`tax_id`, `name`, `tax_percent`, `ledger_name`, `ledger_code`, `type`, `location_code`, `created_at`, `record_status`, `user_id`, `ip_address`) VALUES ('$taxid','$name','$percentage','$saccountname','$saccountid','$type','$locationcode','$updatedatetime','1','$username','$ipaddress')";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		// $res1 = mysql_num_rows($exec1);
		// if ($exec1)
		// {
		$errmsg = "Success. New Tax Updated.";
		$bgcolorcode = 'success';
	}

	//exit();

	else
	{
		$errmsg = "Failed. Reload was Not Allowed. <a href='master_withholding_tax.php'>Refresh Here</a> ";
		$bgcolorcode = 'failed';

	}

	}

	else

	{

		$errmsg = "Failed. Only 100 Characters Are Allowed.";

		$bgcolorcode = 'failed';

	}



}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == 'del')

{

	$delanum = $_REQUEST["anum"];

	$query3 = "UPDATE master_withholding_tax set record_status = '0' where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'activate')

{

	$delanum = $_REQUEST["anum"];

	$query3 = "UPDATE master_withholding_tax set record_status = '1' where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'default')

{

	$delanum = $_REQUEST["anum"];

	$query4 = "update master_department set defaultstatus = '' where cstid='$custid' and cstname='$custname'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));



	$query5 = "update master_department set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";

	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'removedefault')

{

	$delanum = $_REQUEST["anum"];

	$query6 = "update master_department set defaultstatus = '' where auto_number = '$delanum'";

	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

}





if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }

if ($svccount == 'firstentry')

{

	$errmsg = "Please Add Department To Proceed For Billing.";

	$bgcolorcode = 'failed';

}

$query_taxid = "SELECT tax_id from master_withholding_tax where 1 order by auto_number desc";
	$exec_taxid = mysqli_query($GLOBALS["___mysqli_ston"], $query_taxid) or die ("Error in Query_taxid".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res_taxid=mysqli_fetch_array($exec_taxid);
	 $taxid=$res_taxid['tax_id'];
	 $taxidtemp=substr($taxid,4,9);
	 $taxid_f=$taxidtemp+1;


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

<script src="js/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script language="javascript">

$(function() {

    $('#accountname').autocomplete({
		
	source:'accountnameajax_tax.php', 
	
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

	//alert ("Inside Funtion");

	if (document.form1.taxid.value == "")

	{

		alert ("Pleae Enter Tax Name.");

		document.form1.taxid.focus();

		return false;

	}

	if (document.form1.name.value == "")

	{

		alert ("Pleae Enter TAX Name.");

		document.form1.name.focus();

		return false;

	}

	if (document.form1.percentage.value == "")

	{

		alert ("Pleae Enter percentage.");

		document.form1.percentage.focus();

		return false;

	}

	if (document.form1.saccountname.value == "")

	{

		alert ("Pleae Select Ledger.");

		document.form1.percentage.focus();

		return false;

	}
	if (document.form1.type.value == "")

	{

		alert ("Pleae Select Type.");

		document.form1.type.focus();

		return false;

	}

}



function funcDeletetaxid(varTaxIdAutoNumber)

{



     var varTaxIdAutoNumber = varTaxIdAutoNumber;

	 var fRet;

	fRet = confirm('Are you sure want to delete this Tax ID  '+varTaxIdAutoNumber+'?');

	//alert(fRet);

	if (fRet == true)

	{

		alert (varTaxIdAutoNumber+" TAX ID Delete Completed.");

		//return false;

	}

	if (fRet == false)

	{

		alert (varTaxIdAutoNumber+" TAX ID Delete Not Completed.");

		return false;

	}



}

/*this is for numbers only */

	function noDecimal(evt) {



  

        var charCode = (evt.which) ? evt.which : event.keyCode

        if (charCode > 31 && (charCode < 48 || charCode > 57)  )

  return false;

        else 

        return true;





}





//onkeypress="return noDecimal(event);"

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

              <td><form name="form1" id="form1" method="post" action="master_withholding_tax.php" onSubmit="return addward1process1()">

                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <td colspan="" bgcolor="#ecf0f5" class="bodytext3"><strong>Master Withholding Tax - Add New </strong></td>

                        <td align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>

             

            

                  <?php

						

					if ($location!='')

						{ 

						$query12 = "select locationname from master_location where locationcode='$location' order by locationname";

						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res12 = mysqli_fetch_array($exec12);

						

						echo $res1location = $res12["locationname"];

						//echo $location;

						}

						else

						{

						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res1 = mysqli_fetch_array($exec1);

						

						echo $res1location = $res1["locationname"];

						//$res1locationanum = $res1["locationcode"];

						}

						?>

						

                  

                  </td>

                      </tr>

					  <tr>

                        <td colspan="2" align="left" valign="middle"   

						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>

                      </tr>

                      <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Location</div></td>

              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

               <select name="location" id="location"   style="border: 1px solid #001E6A;">

                  <?php

						

						$query1 = "select * from master_location where status <> 'deleted' order by locationname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res1 = mysqli_fetch_array($exec1))

						{

						$res1location = $res1["locationname"];

						$res1locationanum = $res1["locationcode"];

						?>

						<option value="<?php echo $res1locationanum; ?>" <?php if($location!='')if($location==$res1locationanum){echo "selected";}?>><?php echo $res1location; ?></option>

						<?php

						}

						?>

                  </select>

              </span></td>

              </tr>

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">TAX ID </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="taxid" id="taxid" style="border: 1px solid #001E6A; text-transform:uppercase;"   readonly value="WHT-<?=$taxid_f;?>" required=""/></td>

                      </tr>

					  <tr>

					  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Name </div></td>

					  <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="name" id="name" style="border: 1px solid #001E6A; text-transform:uppercase;"  /></td>

                      </tr>

					  <tr>

					   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Percentage</div></td>

					  <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="percentage" id="percentage" style="border: 1px solid #001E6A; text-transform:uppercase;" size="10" onKeyPress="return noDecimal(event)"  />%
						</td>

                      </tr>

					  <tr>

					   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Ledger</div></td>

					  <td align="left" valign="top"  bgcolor="#FFFFFF">

						<!-- <input name="rate3" id="rate3" style="border: 1px solid #001E6A; text-transform:uppercase;" size="10" onKeyPress="return noDecimal(event)" /></td> -->
						<input type="text" name="saccountname" id="accountname" size="30"  />
                        <input type="hidden" name="saccountauto" id="saccountauto" />
                        <input type="hidden" name="saccountid" id="saccountid" />

                      </tr>

					  

					<tr>

                        <td align="left" valign="middle" bgcolor="#FFFFFF" class="bodytext3"><div align="right"><label for="Type">Type</label></div></td>

                        <td align="left" valign="middle" bgcolor="#FFFFFF" class="bodytext3">

						<select name="type"  >
							<option value="">--Select Type--</option>
							<option value="0">TAX</option>
							<option value="1">VAT</option>
						</select>

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

                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>TAX ID</strong></td>

                        <td bgcolor="#ecf0f5" class="bodytext3"><strong> Name </strong></td>

                        <td bgcolor="#ecf0f5" class="bodytext3"><strong>Percentage</strong></td>

                        <td width="18%" bgcolor="#ecf0f5" class="bodytext3"><strong>Ledger</strong></td>

                        <td width="13%" bgcolor="#ecf0f5" class="bodytext3"><strong>Type</strong></td>

                        <td width="13%" bgcolor="#ecf0f5" class="bodytext3"><strong> </strong></td>

                        <td width="13%" bgcolor="#ecf0f5" class="bodytext3"><strong>Edit</strong></td>

                      </tr>

                      <?php

	    $query1 = "SELECT * from master_withholding_tax where record_status <> '0'  order by auto_number ";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res1 = mysqli_fetch_array($exec1))

		{

		$tax_id = $res1["tax_id"];

		$auto_number = $res1["auto_number"];

		$name = ucwords($res1['name']);
		$tax_percent = $res1['tax_percent'];

		$ledger_name = $res1['ledger_name'];

		$type = $res1['type'];

		// $locationname = $res1['locationname'];

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

                        <td width="4%" align="left" valign="top"  class="bodytext3"><div align="center">

						<a href="master_withholding_tax.php?st=del&&anum=<?php echo $auto_number; ?>" onClick="return funcDeletetaxid('<?php echo $tax_id;?>')">

						<img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>

                        <td width="21%" align="left" valign="top"  class="bodytext3"><?php echo $tax_id; ?> </td>

                        <td width="21%" align="left" valign="top"  class="bodytext3"><?php echo $name; ?> </td>


                        <td width="13%" align="left" valign="top"  class="bodytext3"><?php echo $tax_percent; ?></td>

                        <td width="13%" align="left" valign="top"  class="bodytext3"><?php echo $ledger_name; ?></td>

						 <td colspan="2" align="left" valign="top"  class="bodytext3"><?php 
							if($type==0){
								echo 'Tax';
							}else{
								echo 'VAT';
							}

						 ?></td>

                        <td width="10%" align="left" valign="top"  class="bodytext3">

						<a href="master_withholding_tax_edit.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a>						</td>

                      </tr>

                      <?php

		}

		?>

                      <tr>

                        <td align="middle" colspan="5" >&nbsp;</td>

                      </tr>

                    </tbody>

                  </table>

                <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Master Withholding Tax - Deleted </strong></td>

                      </tr>

                      <?php


	    $query1 = "SELECT * from master_withholding_tax where record_status='0'  order by name ";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res1 = mysqli_fetch_array($exec1))

		{

		$tax_id = $res1["tax_id"];
		$name = ucwords($res1['name']);

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

						<a href="master_withholding_tax.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext3">

                          <div align="center" class="bodytext3">Activate</div>

                        </a></td>

                        <td align="left" valign="top"  class="bodytext3"><?php echo $tax_id; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $name; ?></td>

                        </tr>

                      <?php

		}

		?>

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



