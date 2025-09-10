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



	$department = $_REQUEST["department"];

	$department = strtoupper($department);

	$department = trim($department);

	$length=strlen($department);

	$rate1 = $_REQUEST['rate1'];

	$rate2 = $_REQUEST['rate2'];

	$rate3 = $_REQUEST['rate3'];

	$skiptriage = isset($_REQUEST['skiptriage'])?'1':'0';	

	

	$query1 = "select * from master_location where status <> 'deleted' and locationcode = '".$locationcode."'";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res1 = mysqli_fetch_array($exec1);

						

						$locationname = $res1["locationname"];

						

	//echo $length;

	if ($length<=100)

	{

	$query2 = "select * from master_department where department = '$department'";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res2 = mysqli_num_rows($exec2);

	if ($res2 == 0)

	{

		$query1 = "insert into master_department (department, ipaddress, recorddate, username,rate1,rate2,rate3,locationcode,locationname,skiptriage) 

		values ('$department', '$ipaddress', '$updatedatetime', '$username','$rate1','$rate2','$rate3','".$locationcode."','".$locationname."','$skiptriage')";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$errmsg = "Success. New Department Updated.";

		$bgcolorcode = 'success';

		

	}

	//exit();

	else

	{

		$errmsg = "Failed. Department Already Exists.";

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

	$query3 = "update master_department set recordstatus = 'deleted' where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'activate')

{

	$delanum = $_REQUEST["anum"];

	$query3 = "update master_department set recordstatus = '' where auto_number = '$delanum'";

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

	if (document.form1.department.value == "")

	{

		alert ("Pleae Enter Department Name.");

		document.form1.department.focus();

		return false;

	}

}



function funcDeleteDepartment1(varDepartmentAutoNumber)

{



     var varDepartmentAutoNumber = varDepartmentAutoNumber;

	 var fRet;

	fRet = confirm('Are you sure want to delete this Department '+varDepartmentAutoNumber+'?');

	//alert(fRet);

	if (fRet == true)

	{

		alert ("Department  Entry Delete Completed.");

		//return false;

	}

	if (fRet == false)

	{

		alert ("Department Entry Delete Not Completed.");

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

              <td><form name="form1" id="form1" method="post" action="adddepartment1.php" onSubmit="return addward1process1()">

                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <td colspan="" bgcolor="#ecf0f5" class="bodytext3"><strong>Department Master - Add New </strong></td>

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

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New Department </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="department" id="department" style="border: 1px solid #001E6A; text-transform:uppercase;" size="40" /></td>

                      </tr>

					  <tr>

					  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Rate1 </div></td>

					  <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="rate1" id="rate1" style="border: 1px solid #001E6A; text-transform:uppercase;" size="10" onKeyPress="return noDecimal(event)" /></td>

                      </tr>

					  <tr>

					   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Rate2</div></td>

					  <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="rate2" id="rate2" style="border: 1px solid #001E6A; text-transform:uppercase;" size="10" onKeyPress="return noDecimal(event)" /></td>

                      </tr>

					  <tr>

					   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Rate3</div></td>

					  <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="rate3" id="rate3" style="border: 1px solid #001E6A; text-transform:uppercase;" size="10" onKeyPress="return noDecimal(event)" /></td>

                      </tr>

					  

					<tr>

                        <td align="left" valign="middle" bgcolor="#FFFFFF" class="bodytext3"><div align="right"><label for="skiptriage">Skip Triage</label></div></td>

                        <td align="left" valign="middle" bgcolor="#FFFFFF" class="bodytext3">

						<input type="checkbox" name="skiptriage" id="skiptriage"></td>

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

                        <th colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Department</strong></th>

                        <th bgcolor="#ecf0f5" class="bodytext3"><strong>Location Name </strong></th>

                        <th bgcolor="#ecf0f5" class="bodytext3"><strong>Rate 1 </strong></th>

                        <th bgcolor="#ecf0f5" class="bodytext3"><strong>Rate2</strong></th>

                        <th width="13%" bgcolor="#ecf0f5" class="bodytext3"><strong>Rate 3 </strong></th>

                        <th width="13%" bgcolor="#ecf0f5" class="bodytext3"><strong> </strong></th>

                        <th width="13%" bgcolor="#ecf0f5" class="bodytext3"><strong>Edit</strong></td>

                      </tr>

                      <?php

	    $query1 = "select * from master_department where recordstatus <> 'deleted'  order by auto_number ";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res1 = mysqli_fetch_array($exec1))

		{

		$department = $res1["department"];

		$auto_number = $res1["auto_number"];

		$rate1 = $res1['rate1'];

		$rate2 = $res1['rate2'];

		$rate3 = $res1['rate3'];

		$locationname = $res1['locationname'];

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

						<a href="adddepartment1.php?st=del&&anum=<?php echo $auto_number; ?>" onClick="return funcDeleteDepartment1('<?php echo $department;?>')">

						<img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>

                        <td width="21%" align="left" valign="top"  class="bodytext3"><?php echo $department; ?> </td>

                        <td width="21%" align="left" valign="top"  class="bodytext3"><?php echo $locationname; ?> </td>

                        <td width="13%" align="left" valign="top"  class="bodytext3"><?php echo $rate1; ?></td>

                        <td width="13%" align="left" valign="top"  class="bodytext3"><?php echo $rate2; ?></td>

						 <td colspan="2" align="left" valign="top"  class="bodytext3"><?php echo $rate3; ?></td>

                        <td width="10%" align="left" valign="top"  class="bodytext3">

						<a href="editdepartment1.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a>						</td>

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

                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Department Master - Deleted </strong></td>

                      </tr>

                      <?php

		

	    $query1 = "select * from master_department where recordstatus = 'deleted'  order by department ";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res1 = mysqli_fetch_array($exec1))

		{

		$department = $res1["department"];

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

						<a href="adddepartment1.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext3">

                          <div align="center" class="bodytext3">Activate</div>

                        </a></td>

                        <td align="left" valign="top"  class="bodytext3"><?php echo $department; ?></td>

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
    <!-- Modern JavaScript -->
    <script src="js/adddepartment1-modern.js?v=<?php echo time(); ?>"></script>
</body>

</html>



