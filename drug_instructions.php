<?php

session_start();   

include ("includes/loginverify.php");

include ("db/db_connect.php");

$username = $_SESSION["username"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];



$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');
// $updatedate = date('Y-m-d H:i:s');

$errmsg = "";

$bgcolorcode = "";

$colorloopcount = "";



if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1')

{



	$drug_inst = $_REQUEST["drug_inst"];

	//$salutation = strtoupper($salutation);

	$drug_inst = trim($drug_inst);

	$length=strlen($drug_inst);

	//echo $length;

	if ($length<=100)

	{
		$drug_inst=strtolower($drug_inst);
		$drug_inst=ucwords($drug_inst);
	$query2 = "select id from drug_instructions where name = '$drug_inst'";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res2 = mysqli_num_rows($exec2);

	if ($res2 == 0)

	{

		$query1 = "insert into drug_instructions ( `name`, `ipaddress`, `username`, `created_on`) 

		values ('$drug_inst', '$ipaddress', '$username','$updatedatetime')";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$errmsg = "Success. New Drug Instruction was Created.";

		$bgcolorcode = 'success';

		

	}

	//exit();

	else

	{

		$errmsg = "Failed. Drug Instruction Already Exists.";

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

	$query3 = "update drug_instructions set status = '0' where id = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'activate')

{

	$delanum = $_REQUEST["anum"];

	$query3 = "update drug_instructions set status = '1' where id = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

}

/*if ($st == 'default')

{

	$delanum = $_REQUEST["anum"];

	$query4 = "update product_type set defaultstatus = '' where cstid='$custid' and cstname='$custname'";

	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());



	$query5 = "update master_salutation set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";

	$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());

}*/

/*if ($st == 'removedefault')

{

	$delanum = $_REQUEST["anum"];

	$query6 = "update master_salutation set defaultstatus = '' where auto_number = '$delanum'";

	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());

}

*/









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

	var drug_inst = document.form1.drug_inst.value;

	drug_inst = drug_inst.replace(/^\s+|\s+$/g, '' );

	if(drug_inst == "")

	{

		alert ("Please Enter Drug Instructions.");

		document.form1.drug_inst.focus();

		return false;

	}

	

}



function funcDeleteProductType(varNameAutoNumber)

{

     var varNameAutoNumber = varNameAutoNumber;

	 var fRet;

	fRet = confirm('Are you sure want to delete this Drug Instruction '+varNameAutoNumber+'?');

	//alert(fRet);

	if (fRet == true)

	{

		alert ("Drug Instruction Entry Delete Completed.");

		//return false;

	}

	if (fRet == false)

	{

		alert ("Drug Instruction Entry Delete Not Completed.");

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

              <td><form name="form1" id="form1" method="post" action="drug_instructions.php" onSubmit="return addsalutation1process1()">

                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Drug Instructions Master - Add New </strong></td>
                      </tr>

					  <tr>

                        <td colspan="2" align="left" valign="middle"   

						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>

                      </tr>

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New Drug Instruction </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="drug_inst" id="drug_inst" style="border: 1px solid #001E6A;" size="40" autocomplete="off"/></td>

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

                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Drug Instructions  Master - Existing List </strong></td>

                       

                        <td width="9%" bgcolor="#ecf0f5" class="bodytext3"><strong>Edit</strong></td>

                      </tr>

                      <?php

	    $query1 = "select id,name from drug_instructions where status='1' order by id desc ";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res1 = mysqli_fetch_array($exec1))

		{

		$drug_inst = $res1["name"];

		$auto_number = $res1["id"];

		

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

						<a href="drug_instructions.php?st=del&&anum=<?php echo $auto_number; ?>" onClick="return funcDeleteProductType('<?php  ?>')">

						<img src="images/b_drop.png" width="16" height="16" border="0" /></a>						</div>						</td>

                        <td width="39%" align="left" valign="top"  class="bodytext3"><?php echo $drug_inst; ?> </td>

                      

                        <td align="left" valign="top"  class="bodytext3">

						<a href="edit_drug_instructions.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a></td>

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

                        <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>Drug Instruction Master - Deleted </strong></td>

                      </tr>

                      <?php

		

	    $query1 = "select id,name from drug_instructions where status = 0 order by id desc ";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res1 = mysqli_fetch_array($exec1))

		{

		$drug_inst = $res1['name'];

		

		$auto_number = $res1["id"];



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

						<a href="drug_instructions.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext3">

                          <div align="center" class="bodytext3">Activate</div>

                        </a></td>

                        <td width="35%" align="left" valign="top"  class="bodytext3"><?php echo $drug_inst; ?></td>

                        

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



