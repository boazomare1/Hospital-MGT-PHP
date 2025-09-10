<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");

$username = $_SESSION["username"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];



$docno = $_SESSION['docno'];

$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$errmsg = "";

$bgcolorcode = "";

$colorloopcount = "";



if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1')

{

	$locationcode = $_REQUEST["location"];

	$store = $_REQUEST["store"];

	$storeno = $_REQUEST['storeno'];
	$categoryname = $_REQUEST['categoryname'];
	$ph_categoryname = $_REQUEST['ph_categoryname'];
	$exp_accountname = $_REQUEST['exp_accountname'];
	$exp_accountid = $_REQUEST['exp_accountid'];
	$store = strtoupper($store);
	$store = trim($store);
	$length=strlen($store);
    $cc_categoryname = $_REQUEST['cc_categoryname'];
	$storeLable = $_REQUEST['storeLable'];
	

	$query6 = "select * from master_location where locationcode = '$locationcode'";

	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res6 = mysqli_fetch_array($exec6);

	$location = $res6['auto_number'];

	$locationname = $res6['locationname'];

	//echo $length;

	if ($length<=100)

	{

	$query2 = "select * from master_store where store = '$store' and location = '$location'";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res2 = mysqli_num_rows($exec2);

	if ($res2 == 0)

	{

		 $query1 = "INSERT into master_store (location, store,storecode, ipaddress, recorddate, username,locationcode,category, ph_categoryname, locationname,cost_center,storelable,expense_ledger) 
		values ('$location', '$store', '$storeno','$ipaddress', '$updatedatetime', '$username','$locationcode', '$categoryname', '$ph_categoryname' ,'$locationname','$cc_categoryname','$storeLable','$exp_accountid')";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$errmsg = "Success. New Store Updated.";

		$bgcolorcode = 'success';

	

	}

	//exit();

	else

	{

		$errmsg = "Failed. Store Already Exists.";

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





$query5 = "select storecode from master_store where 1 order by auto_number desc";

	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res=mysqli_fetch_array($exec5);

	 $storecode=$res['storecode'];

	 $storecode=$res['storecode'];

	 $stotemp=substr($storecode,3,9);

	 $storecode=$stotemp+1;

	



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
<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="js/jquery-ui.js" type="text/javascript"></script>
<link href="js/jquery-ui.css" rel="stylesheet">

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

	if (document.form1.store.value == "")

	{

		alert ("Please Enter Store Name.");

		document.form1.store.focus();

		return false;

	}
	if (document.form1.exp_accountauto.value == "")
	{
		alert ("Please Select the Expense Ledger Properly.");
		document.form1.exp_accountname.focus();
		return false;
	}

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

              <td><form name="form1" id="form1" method="post" action="addstore.php" onSubmit="return addward1process1()">

                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <td colspan="" bgcolor="#ecf0f5" class="bodytext3"><strong>Store Master - Add New </strong></td>

                         <td width="10%" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>

             

            

                  <?php

						

						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res1 = mysqli_fetch_array($exec1);

						

						echo $res1location = $res1["locationname"];

						

						?>

						

						

                  

                  </td>

                      </tr>

					  <tr>

                        <td colspan="2" align="left" valign="middle"   

						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>

                      </tr>

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Location </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<select name="location" id="location" onChange="ajaxlocationfunction(this.value);"   style="border: 1px solid #001E6A;">

						

                          <?php

				$query5 = "select * from master_location where status = '' order by locationname";

				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

				while ($res5 = mysqli_fetch_array($exec5))

				{

				$locationcode = $res5["locationcode"];

				$res5location = $res5["locationname"];

				?>

                          <option value="<?php echo $locationcode; ?>"><?php echo $res5location; ?></option>

                          <?php

				}

				?>

                        </select>

						</td>

                      </tr>

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New Store </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="store" id="store" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" /></td>

                      </tr>

					   <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Store No </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="storeno" id="storeno" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" readonly value="STO<?php echo $storecode;?>"/></td>

                      </tr>

					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Label</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<select name="storeLable" id="storeLable" >
						<option value='pharmacy'>Pharmacy</option>
						<option value='ward'>Ward Items</option>
						<option value='theater'>Theater</option>
						<option value='icu'>ICU</option>
						</select>
						</td>
                      </tr>

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Service Category  </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF"><select id="categoryname" name="categoryname" >

                           

                          <option value="" selected="selected">Select Service Category</option>

                          <?php

						

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
                        <td align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Pharmacy Category </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
                        	<select id="ph_categoryname" name="ph_categoryname" >
                           
                          <option value="" selected="selected">Select Pharmacy Category</option>
                          <?php
						 
						$query1 = "select * from master_categorypharmacy where status <> 'deleted' order by categoryname";
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
                        <td align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Cost Center </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
                        	<select id="cc_categoryname" name="cc_categoryname" >
                           
                          <option value="" selected="selected">Select Cost Center</option>
                         
                          <?php

						

						$query1 = "select * from master_costcenter where recordstatus <> 'deleted' order by name";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res1 = mysqli_fetch_array($exec1))

						{

						$res1categoryname = $res1["name"];
						$res1auto_number = $res1["auto_number"];

						?>

                          <option value="<?php echo $res1auto_number; ?>"><?php echo $res1categoryname; ?></option>

                          <?php

						}

						?>

                        </select>
                           
						 </td>
					    </tr>
                        
                        <tr>
                        <td align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Expense Ledger</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
                      	<input type="text" name="exp_accountname" id="exp_accountname" size="50" value="" />
						<input type="hidden" name="exp_accountauto" id="exp_accountauto" value="" />
						<input type="hidden" name="exp_accountid" id="exp_accountid" value="" />
                           
						 </td>
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

                <table width="800" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <td colspan="9" bgcolor="#FFFFF" class="bodytext3"><strong>Store Master - Existing List </strong></td>

                      </tr>

                      <tr>

                        <td align="left" valign="top" bgcolor="#FFFFFF"  class="bodytext3">&nbsp;</td>

                        <th width="" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Location </strong></th>

                        <th width="" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Store Code</strong></th>
                        <th width="" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Store </strong></th>
                        <th width="" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Expense Ledger </strong></th>

                        <th width="" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Edit</strong></th>

                      </tr>

                      <?php

	    $query1 = "select * from master_store where recordstatus <> 'deleted' order by location";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res1 = mysqli_fetch_array($exec1))

		{

		$locationanum = $res1['location'];

		$store = $res1["store"];
		$storecode = $res1["storecode"];

		$auto_number = $res1["auto_number"];
		$category = $res1["category"];
		$ph_categoryname = $res1["ph_categoryname"];
		$res1cost_center = $res1["cost_center"];
		$res1expenseledgerid= $res1["expense_ledger"];
		
		
		

		//$defaultstatus = $res1["defaultstatus"];

		$res1cc_name = $res1['cost_center'];
		
		
		$query6122 = "select accountname from master_accountname where id = '$res1expenseledgerid'";

		$exec6122 = mysqli_query($GLOBALS["___mysqli_ston"], $query6122) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$res6122 = mysqli_fetch_array($exec6122);

		$res1expenseledgername = $res6122['accountname'];
		

	$query612 = "select * from master_costcenter where auto_number = '$res1cost_center' and recordstatus <> 'deleted'";

		$exec612 = mysqli_query($GLOBALS["___mysqli_ston"], $query612) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$res612 = mysqli_fetch_array($exec612);

		$cost_center = $res612['name'];
		
		
		

		$query2 = "select * from master_location where auto_number = '$locationanum'";

		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res2 = mysqli_fetch_array($exec2);

		$location = $res2['locationname'];

	

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

		if($res1['storelable']=='ward')
			$catestoreName ='Ward Items';
		else
		   $catestoreName = ucfirst($res1['storelable']);

		?>

                      <tr <?php echo $colorcode; ?>>

                        <td align="left" valign="top"  class="bodytext3"><div align="center">

					    <a href="addstore.php?st=del&&anum=<?php echo $auto_number; ?>" onClick="return funcDeletestore('<?php echo $store;?>')">

						<img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>

                        <td align="left" valign="top"  class="bodytext3"><?php echo $location; ?> </td>

                        <td align="left" valign="top"  class="bodytext3"><?php echo $storecode; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $store; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $res1expenseledgername; ?> </td>
                        <td align="left" valign="top"  class="bodytext3">

						<a href="editstore.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a>

						</td>

                      </tr>

                      <?php

		}

		?>

                      <tr>
                        <td align="middle" colspan="4" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>

                <table width="60%" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Store Master - Deleted </strong></td>

                        <td bgcolor="#ecf0f5" class="bodytext3"><strong>Store </strong></td>

                      </tr>

                      <?php

		

	    $query1 = "select * from master_store where recordstatus = 'deleted' order by location";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res1 = mysqli_fetch_array($exec1))

		{

		$locationanum = $res1['location'];

		$store = $res1["store"];

		$auto_number = $res1["auto_number"];

		//$defaultstatus = $res1["defaultstatus"];

		

		$query2 = "select * from master_location where auto_number = '$locationanum'";

		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res2 = mysqli_fetch_array($exec2);

		$location = $res2['locationname'];

	

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

						<a href="addstore.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext3">

                          <div align="center" class="bodytext3">Activate</div>

                        </a></td>

                        <td width="37%" align="left" valign="top"  class="bodytext3"><?php echo $location; ?></td>

                        <td width="52%" align="left" valign="top"  class="bodytext3"><?php echo $store; ?></td>

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



