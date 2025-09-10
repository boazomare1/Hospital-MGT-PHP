<?php


session_start();

$pagename = '';

//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.

if (!isset($_SESSION['username'])) header ("location:index.php");

include ("db/db_connect.php");

$username = $_SESSION["username"];

$docno = $_SESSION['docno'];

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$sessionusername = $_SESSION['username'];

$errmsg = '';

$bgcolorcode = '';

$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

$locationname  = $res["locationname"];

$locationcode = $res["locationcode"];



if (isset($_REQUEST["searchsuppliername"])) {  $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

if (isset($_REQUEST["searchdescription"])) {   $searchdescription = $_REQUEST["searchdescription"]; } else { $searchdescription = ""; }

if (isset($_REQUEST["searchemployeecode"])) { $searchemployeecode = $_REQUEST["searchemployeecode"]; } else { $searchemployeecode = ""; }



if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }



//$frmflag1 = $_REQUEST['frmflag1'];

if ($frmflag1 == 'frmflag1')

{
	
	$roleid = $_REQUEST['roleid'];

	

	$query2 = "select * from master_role where role_id = '$roleid'";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res2 = mysqli_num_rows($exec2);

	if ($res2 != 0)

	{
		
		$employeename = $res2['username'];

		/*

		if ($username != 'admin')

		{

		*/

			$query33 = "delete from role_mapping where role_id = '$roleid' and mainmenuid NOT IN ('MM001','MM026') and submenuid=''";

			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$emp_array=array();
			
			
			
			$q_submenu=array();

			$query_menu="select submenuid from master_menusub where mainmenuid NOT IN ('MM001','MM026')";

			$exec_menu = mysqli_query($GLOBALS["___mysqli_ston"], $query_menu) or die ("Error in query_menu".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res_menu = mysqli_fetch_array($exec_menu)){

				array_push($q_submenu, $res_menu['submenuid']);

			}

			

			$str_submenu = implode ("','", $q_submenu);

			$query33 = "delete from role_mapping where role_id = '$roleid' and mainmenuid='' and submenuid IN ('$str_submenu')";

			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));

			
			///new code
			
			$query06 = "select * from master_employee where role_id = '$roleid'";
			$exec06 = mysqli_query($GLOBALS["___mysqli_ston"], $query06) or die ("Error in Query06".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res06 = mysqli_fetch_array($exec06))
			{
			$roleemp=$res06['employeecode'];
			$roleusername=$res06['username'];
			
			$query33 = "delete from master_employeerights where employeecode = '$roleemp' ";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			for ($i=0;$i<=1000;$i++)

			{

				if (isset($_REQUEST["cbmainmenu".$i])) { $cbmainmenu = $_REQUEST["cbmainmenu".$i]; } else { $cbmainmenu = ""; }

				//$cbmainmenu = $_REQUEST['cbmainmenu'.$i];

				if ($cbmainmenu != '')

				{

					//echo '<br>'.$cbmainmenu;

					$query5 = "select * from master_menumain where auto_number = '$cbmainmenu'";

					$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

					$res5 = mysqli_fetch_array($exec5);

					$res5mainmenuid = $res5['mainmenuid'];

					

					/*$query3 = "insert into role_mapping ( mainmenuid, submenuid, 

					lastupdate, lastupdateipaddress, lastupdateusername,role_id,locationname,locationcode) 

					values ( '$res5mainmenuid', '', 

					'$updatedatetime', '$ipaddress', '$sessionusername','$roleid','$locationname','$locationcode')";

					$exec3 = mysql_query($query3) or die ("Error in query3".mysql_error());*/
					
					
					$query4 = "insert into master_employeerights (employeecode, username, mainmenuid, submenuid,locationname,locationcode,lastupdate, lastupdateipaddress, lastupdateusername) 

				values ('$roleemp', '$roleusername', '$res5mainmenuid', '','$locationname','$locationcode', '$updatedatetime', '$ipaddress', '$sessionusername')";;
				
				$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4);

				}

			}


			//echo '<br><br>';

			for ($i=0;$i<=1000;$i++)

			{

				if (isset($_REQUEST["cbsubmenu".$i])) { $cbsubmenu = $_REQUEST["cbsubmenu".$i]; } else { $cbsubmenu = ""; }

				//$cbsubmenu = $_REQUEST['cbsubmenu'.$i];

				if ($cbsubmenu != '')

				{

					//echo '<br>'.$cbsubmenu;

					$query6 = "select * from master_menusub where auto_number = '$cbsubmenu'";

					$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

					$res6 = mysqli_fetch_array($exec6);

					$res6submenuid = $res6['submenuid'];

	

					/*$query4 = "insert into role_mapping ( mainmenuid, submenuid, 

					lastupdate, lastupdateipaddress, lastupdateusername,role_id,locationname,locationcode) 

					values ( '', '$res6submenuid', 

					'$updatedatetime', '$ipaddress', '$sessionusername','$roleid','$locationname','$locationcode')";

					$exec4 = mysql_query($query4) or die ("Error in query4".mysql_error());*/


					$query4 = "insert into master_employeerights (employeecode, username, mainmenuid, submenuid,locationname,locationcode,lastupdate, lastupdateipaddress, lastupdateusername) 

				values ('$roleemp', '$roleusername', '', '$res6submenuid','$locationname','$locationcode', '$updatedatetime', '$ipaddress', '$sessionusername')";;
				
				$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4);
				}

			}

			}
			
			
			$query06 = "select * from master_employee where role_id = '$roleid'";
			$exec06 = mysqli_query($GLOBALS["___mysqli_ston"], $query06) or die ("Error in Query06".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num06 = mysqli_num_rows($exec06);
			if($num06 == '0')
			{
			$roleemp=$res06['employeecode'];
			$roleusername=$res06['username'];
			
			for ($i=0;$i<=1000;$i++)

			{

				if (isset($_REQUEST["cbmainmenu".$i])) { $cbmainmenu = $_REQUEST["cbmainmenu".$i]; } else { $cbmainmenu = ""; }

				//$cbmainmenu = $_REQUEST['cbmainmenu'.$i];

				if ($cbmainmenu != '')

				{

					//echo '<br>'.$cbmainmenu;

					$query5 = "select * from master_menumain where auto_number = '$cbmainmenu'";

					$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

					$res5 = mysqli_fetch_array($exec5);

					$res5mainmenuid = $res5['mainmenuid'];

					

					$query3 = "insert into role_mapping ( mainmenuid, submenuid, 

					lastupdate, lastupdateipaddress, lastupdateusername,role_id,locationname,locationcode) 

					values ( '$res5mainmenuid', '', 

					'$updatedatetime', '$ipaddress', '$sessionusername','$roleid','$locationname','$locationcode')";

					$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in query3".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					

				}

			}


			//echo '<br><br>';

			for ($i=0;$i<=1000;$i++)

			{

				if (isset($_REQUEST["cbsubmenu".$i])) { $cbsubmenu = $_REQUEST["cbsubmenu".$i]; } else { $cbsubmenu = ""; }

				//$cbsubmenu = $_REQUEST['cbsubmenu'.$i];

				if ($cbsubmenu != '')

				{

					//echo '<br>'.$cbsubmenu;

					$query6 = "select * from master_menusub where auto_number = '$cbsubmenu'";

					$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

					$res6 = mysqli_fetch_array($exec6);

					$res6submenuid = $res6['submenuid'];

	

					$query4 = "insert into role_mapping ( mainmenuid, submenuid, 

					lastupdate, lastupdateipaddress, lastupdateusername,role_id,locationname,locationcode) 

					values ( '', '$res6submenuid', 

					'$updatedatetime', '$ipaddress', '$sessionusername','$roleid','$locationname','$locationcode')";

					$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));


				}

			}

			} else {
				
				for ($i=0;$i<=1000;$i++)

			{

				if (isset($_REQUEST["cbmainmenu".$i])) { $cbmainmenu = $_REQUEST["cbmainmenu".$i]; } else { $cbmainmenu = ""; }

				//$cbmainmenu = $_REQUEST['cbmainmenu'.$i];

				if ($cbmainmenu != '')

				{

					//echo '<br>'.$cbmainmenu;

					$query5 = "select * from master_menumain where auto_number = '$cbmainmenu'";

					$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

					$res5 = mysqli_fetch_array($exec5);

					$res5mainmenuid = $res5['mainmenuid'];

					

					 $query3 = "insert into role_mapping ( mainmenuid, submenuid, 

					lastupdate, lastupdateipaddress, lastupdateusername,role_id,locationname,locationcode) 

					values ( '$res5mainmenuid', '', 

					'$updatedatetime', '$ipaddress', '$sessionusername','$roleid','$locationname','$locationcode')";

					$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in query3".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					

				}

			}


			//echo '<br><br>';

			for ($i=0;$i<=1000;$i++)

			{

				if (isset($_REQUEST["cbsubmenu".$i])) { $cbsubmenu = $_REQUEST["cbsubmenu".$i]; } else { $cbsubmenu = ""; }

				//$cbsubmenu = $_REQUEST['cbsubmenu'.$i];

				if ($cbsubmenu != '')

				{

					//echo '<br>'.$cbsubmenu;

					$query6 = "select * from master_menusub where auto_number = '$cbsubmenu'";

					$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

					$res6 = mysqli_fetch_array($exec6);

					$res6submenuid = $res6['submenuid'];

	

					$query4 = "insert into role_mapping ( mainmenuid, submenuid, 

					lastupdate, lastupdateipaddress, lastupdateusername,role_id,locationname,locationcode) 

					values ( '', '$res6submenuid', 

					'$updatedatetime', '$ipaddress', '$sessionusername','$roleid','$locationname','$locationcode')";

					$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));


				}

			}

				
				
			}

		
		

			header ("location:roles.php");

	}

	else

	{

		header ("location:roles.php");

	}



}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

//$st = $_REQUEST['st'];

if ($st == 'success')

{

		$errmsg = "Success. Employee Role Updated.";

}

else if ($st == 'failed')

{

		$errmsg = "Failed. Employee Role Already Exists.";

}



if (isset($_REQUEST["code"])) { $code = $_REQUEST["code"]; } else { $code = ""; }

if (isset($_REQUEST["roleid"])) { $roleid = $_REQUEST["roleid"]; } else { $roleid = ""; }

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

.ui-menu .ui-menu-item{ zoom:1.3 !important; }

-->

</style>

<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />  

<!--<script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>

<script type="text/javascript" src="js/autosuggestjobdescription1.js"></script>-->

<link rel="stylesheet" type="text/css" href="css/autocomplete.css">

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>

  <script> 


	

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





</script>

<script src="js/datetimepicker_css.js"></script>

<body>

<table width="103%" border="0" cellspacing="0" cellpadding="2">

 
  <tr>

    <td colspan="10">&nbsp;</td>

  </tr>

  <tr>

    <td>&nbsp;</td>

    <td valign="top">&nbsp;</td>

    <td valign="top">

	


	

	

  <tr>

    <td>&nbsp;</td>

    <td valign="top">&nbsp;</td>

    <td valign="top">  

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="2%" valign="top">&nbsp;</td>

    <td width="97%" valign="top">



			<?php

			if ($roleid != '')

			{

			?>

      	  <form name="form1" id="form1" method="post" action="role_mapping_master.php" onKeyDown="return disableEnterKey()" onSubmit="return from1submit1()">

      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td width="860"><table width="900" height="250" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

            <tbody>

             

              <tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Menu Permissions </strong></td>

                <td valign="middle" align="left" bgcolor="#FFFFFF" >&nbsp;
				<input type="hidden" name="roleid" id="roleid" value="<?php echo $roleid; ?>" />
				<input type="hidden" name="employeecode" id="employeecode" value="<?php echo $code; ?>" />
				
				
				
				</td>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>

                <td valign="middle" align="left"  ></td>

              </tr>

             
              <tr>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong</strong></td>
                <td valign="middle" align="left" bgcolor="#FFFFFF" >&nbsp;</td>

			  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
                <td valign="middle" align="left"  ></td>
			 </tr>

			 

              <script>

				 function allmenucheck()

				 {

					 var inputs = document.getElementsByClassName('mainmenucheck');	

					 for (var i = 0; i < inputs.length; i++) 

					 {

						 var displayattr = document.getElementById('mainmenucheck1').checked;

						 if(displayattr==true)

						 {

							inputs[i].checked='checked';

							//document.getElementById('id'+pino).innerHTML='+';

						 }

						 else

						 {

							inputs[i].checked='';

							//document.getElementById('id'+pino).innerHTML='-';

						 }

					 }

					 var inputs = document.getElementsByClassName('submenucheck');	

					 for (var i = 0; i < inputs.length; i++) 

					 {

						 var displayattr = document.getElementById('mainmenucheck1').checked;

						 if(displayattr==true)

						 {

							inputs[i].checked='checked';

							//document.getElementById('id'+pino).innerHTML='+';

						 }

						 else

						 {

							inputs[i].checked='';

							//document.getElementById('id'+pino).innerHTML='-';

						 }

					 }

				 }

				 

				 function submenucheck(mainmenucheck)

				 {

					 var inputs = document.getElementsByClassName(mainmenucheck);	

					 for (var i = 0; i < inputs.length; i++) 

					 {

						 

						 var displayattr = document.getElementById(mainmenucheck).checked;

						 if(displayattr==true)

						 {

							inputs[i].checked='checked';

							//document.getElementById('id'+pino).innerHTML='+';

						 }

						 else

						 {

							inputs[i].checked='';

							

							//document.getElementById('id'+pino).innerHTML='-';

						 }

					 }

					

				 }

			  </script>

              <tr>

                <td align="left" valign="middle"   bgcolor="#FFFFFF" class="bodytext3"><strong>Main Menu <input id="mainmenucheck1" class="mainmenucheck1" type="checkbox" name="cbmainmen" onClick="allmenucheck()"></strong></td>

                <td valign="middle" align="left" bgcolor="#FFFFFF" ><span class="bodytext3"><strong>Sub Menu </strong></span></td>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td valign="middle" align="left" >&nbsp;</td>

              </tr>

              <?php

			  $checkedvalue1 = '';

			  $checkedvalue2 = '';

				 $query2 = "select * from master_menumain where  status = '' order by mainmenuorder";

				 $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

				 while ($res2 = mysqli_fetch_array($exec2))

				 {

				 $res2anum = $res2['auto_number'];

				 $res2menuid = $res2['mainmenuid'];

				 $res2mainmenutext = $res2['mainmenutext'];

				 

				 $query31 = "select * from role_mapping where role_id = '$roleid' and mainmenuid = '$res2menuid'";

				 $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));

				 $res31 = mysqli_fetch_array($exec31);

				 $rowcount31 = mysqli_num_rows($exec31);

				 if ($rowcount31 > 0)

				 {

				 	$checkedvalue1 = 'checked="checked"';

				 }

				 

				 ?>

              <tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">

				<input class="mainmenucheck" id="<?php echo $res2anum; ?>" type="checkbox" name="cbmainmenu<?php echo $res2anum; ?>" <?php echo $checkedvalue1; ?> value="<?php echo $res2anum; ?>" onClick="submenucheck('<?php echo $res2anum; ?>')">

                    <strong><?php echo $res2mainmenutext; ?></strong></td>

                <td valign="middle" align="left"  bgcolor="#FFFFFF" >&nbsp;</td>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td valign="middle" align="left" >&nbsp;</td>

              </tr>

              <?php

				 $query3 = "select * from master_menusub where mainmenuid = '$res2menuid' and status = '' order by submenuorder";

				 $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

				 while ($res3 = mysqli_fetch_array($exec3))

				 {

				 $res3anum = $res3['auto_number'];

				 $res3submenuid = $res3['submenuid'];

				 $res3submenutext = $res3['submenutext'];

				 

			 	 $query32 = "select * from role_mapping where role_id = '$roleid' and submenuid = '$res3submenuid'";

				 $exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query32".mysqli_error($GLOBALS["___mysqli_ston"]));

				 $res32 = mysqli_fetch_array($exec32);

				 $rowcount32 = mysqli_num_rows($exec32);

				 if ($rowcount32 > 0)

				 {

				 	$checkedvalue2 = 'checked="checked"';

				 }

				 ?>

              <tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td valign="middle" align="left" bgcolor="#FFFFFF" ><span class="bodytext3">

                  <input class="submenucheck <?php echo $res2anum; ?>" type="checkbox" name="cbsubmenu<?php echo $res3anum; ?>" <?php echo $checkedvalue2; ?> value="<?php echo $res3anum; ?>">

                  <strong><?php echo $res3submenutext; ?></strong></span></td>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td valign="middle" align="left" >&nbsp;</td>

              </tr>

              <?php

				 $checkedvalue2 = '';

				 }

				 ?>

              <tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td valign="middle" align="left"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td valign="middle" align="left" >&nbsp;</td>

              </tr>

              <?php

				 $checkedvalue1 = '';

				 //}

				 }

				 ?>

            
              <tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td valign="middle" align="left" bgcolor="#FFFFFF" >&nbsp;</td>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td valign="middle" align="left" >&nbsp;</td>

              </tr>

              <tr>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td valign="middle" align="left" bgcolor="#FFFFFF" >&nbsp;</td>

                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                <td valign="middle" align="left" >&nbsp;</td>

              </tr>

              <tr>

                <td align="middle" colspan="4" >&nbsp;</td>

              </tr>

            </tbody>

          </table></td>

        </tr>

        <tr>

          <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="95%" 

            align="left" border="1">

            <tbody>

              <tr>

                <td width="3%" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

                <td width="30%" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

                <td width="30%" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

                <td width="41%" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><div align="right">

				<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">

				<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">

				<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">

				<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">

				<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">

                    <input type="hidden" name="frmflag1" value="frmflag1" />

                    <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />

                    <input name="Submit222" accesskey="s" type="submit"  value="Save Employee(Alt+S)" class="button"/>

                </font></font></font></font></font></div></td>

                </tr>

            </tbody>

          </table></td>

        </tr>

    </table>

	</form>

	<?php

	}

	?>

<script language="javascript">





</script>

</table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>



