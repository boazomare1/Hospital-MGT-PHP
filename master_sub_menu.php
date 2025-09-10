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
	$paynowbillprefix = 'SM';
$paynowbillprefix1=strlen($paynowbillprefix);
 $query2 = "select * from master_menusub order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["submenuid"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
 $billnumbercode ='SM'.'1';
}
else
{
 $billnumber = $res2["submenuid"];
 $billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);

 $billnumbercode = intval($billnumbercode);
 $billnumbercode = $billnumbercode + 1;
 $maxanum = $billnumbercode;
 $billnumbercode = 'SM' .$maxanum;
 
  
} 
	if ($frmflag1 == 'frmflag1')
	{
		$menu_id = $_REQUEST["menu_id"];
		$submenuid = $_REQUEST["submenuid"];
		$submenuorder = $_REQUEST["submenuorder"];
		$menu_name = $_REQUEST['submenu_name'];
		$menu_url = $_REQUEST['submenu_url'];
		
		 $Query = "insert into master_menusub(mainmenuid,submenuid,submenuorder,submenutext,submenulink) 
		values ('".$menu_id."','".$submenuid."','".$submenuorder."','".$menu_name."', '".$menu_url."')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $Query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
		$errmsg = "Success. New Sub Menu Created";
		//exit;
		$bgcolorcode = 'success';
	
	}

	if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
	if ($st == 'del')
	{
		$delanum = $_REQUEST["anum"];
		$Query = "update master_menusub set status = 'deleted' where auto_number = '".$delanum."'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $Query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	if ($st == 'activate')
	{
		$delanum = $_REQUEST["anum"];
		$Query = "update master_menusub set status = '' where auto_number = '".$delanum."'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $Query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	$paynowbillprefix = 'SM';
$paynowbillprefix1=strlen($paynowbillprefix);
 $query2 = "select * from master_menusub order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["submenuid"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
 $billnumbercode ='SM'.'1';
}
else
{
 $billnumber = $res2["submenuid"];
 $billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);

 $billnumbercode = intval($billnumbercode);
 $billnumbercode = $billnumbercode + 1;
 $maxanum = $billnumbercode;
 $billnumbercode = 'SM' .$maxanum;
 
  
} 
?>
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
<link rel="stylesheet" href="css/main.css" type="text/css" />
<link rel="stylesheet" href="css/field.css" type="text/css" />

<script language="javascript">
	function process1()
	{
		//alert ("Inside Funtion");
		if (document.form1.menu_id.value == "")
		{
			alert ("Please Select the Menu ID");
			document.form1.menu_id.focus();
			return false;
		}
		if (document.form1.submenu_name.value == "")
		{
			alert ("Please Enter Sub Menu Name");
			document.form1.submenu_name.focus();
			return false;
		}
	}
</script>
<body  bgcolor='ECECEC'>
<?php include("includes/title1.php"); ?>

<?php include("includes/menu1.php"); ?>
<div>
  <table width="101%" border="0" cellspacing="0" cellpadding="2">
    <tr>
      <td width="1%">&nbsp;</td>
      <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
        &nbsp;</td>
      <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
                <tr>
                  <td><form name="form1" id="form1" method="post" action="master_sub_menu.php" onSubmit="return process1()">
                      <table width="914" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                        <?php 
                    $prev_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
                    if( !empty( $prev_url ) || strpos( $prev_url,  "?p=")+1):
                    //Then display it only if it's one of my blog page ?>
                        <a href="<?php echo $prev_url; ?>" class="previous-history-link">
                        <input type="button" name="Back" value="Back" >
                        </a>
                        <?php endif; ?>
                        <tbody>
                          <tr bgcolor="#011E6A">
                            <td colspan="2" bgcolor="#ecf0f5" class="bodytext11"><strong>Master Sub-Menu - Add New </strong></td>
                          </tr>
                          <tr>
                            <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext31"><div align="left"><?php echo $errmsg; ?></div></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle"  bgcolor="#FFFFFF" class="validfield"><div align="right">Main Menu ID </div></td>
                            <!--<td align="left" valign="top"  bgcolor="#FFFFFF"><input name="menu_id" id="menu_id" value=""  />
                              <input name="menuno" id="menuno" size="20"  type="hidden" value=""  />
                              <input name="menunosearch" id="menunosearch" size="20"   type="hidden"  /></td>-->
                              <td align="left" valign="top"  bgcolor="#FFFFFF">
                              
                              
                              	<select name="menu_id" id="menu_id">
                                <option value="">Select</option>
                                 <?php
                            $query5 = "select * from master_menumain where status <> 'deleted' order by mainmenuid";
                            $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res5 = mysqli_fetch_array($exec5))
                            {
                            $res5anum = $res5["auto_number"];
                            $res5accountsmain = $res5["mainmenuid"];
                            $res5mainmenutext = $res5["mainmenutext"];
                            ?>
                               <option value="<?php echo  $res5accountsmain;  ?>"><?php echo $res5mainmenutext; ?></option>
                              <?php	 
                            }
                            ?>
                            </select>
                              
                              </td>
                              
                          </tr>
                          <tr>
                            <td align="left" valign="middle"  bgcolor="#FFFFFF" class="validfield"><div align="right">Sub Menu ID </div></td>
                            <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="submenuid" id="submenuid" value="<?php echo $billnumbercode;?>"  readonly></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle"  bgcolor="#FFFFFF" class="validfield"><div align="right">Sub Menu Order </div></td>
                            <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="submenuorder" id="submenuorder"  ></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle"  bgcolor="#FFFFFF" class="validfield"><div align="right">Sub Menu Name </div></td>
                            <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="submenu_name" id="submenu_name"  ></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle"  bgcolor="#FFFFFF"><div align="right"Sub> Sub Menu Url </div></td>
                            <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="submenu_url" id="submenu_url"  ></td>
                          </tr>
                          <tr>
                            <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
                            <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="frmflag" value="addnew" />
                              <input type="hidden" name="frmflag1" value="frmflag1" />
                              <input type="submit" name="Submit" value="Submit"  /></td>
                          </tr>
                          <tr>
                            <td align="middle" colspan="2" >&nbsp;</td>
                          </tr>
                        </tbody>
                      </table>
                      <table width="1000" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                        <tbody>
                          <tr bgcolor="#011E6A">
                            <td colspan="7" bgcolor="#ecf0f5" class="bodytext11"><strong>Master Sub-Menu - Existing List </strong></td>
                            
                          </tr>
                           <tr bgcolor="#011E6A"> <th  width="21%"  height="48" >Main Menu Id</th> <th width="24%">Sub Menu ID</th> <th width="22%">Sub Order No</th>
                            <th width="16%">Menu Name</th> <th width="11%">Menu Url</th>
                      <th width="9%">Action</th> </tr>
                          <?php
	    $Query = "select * from master_menusub where status <> 'deleted' order by auto_number DESC";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $Query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1 = mysqli_num_rows($exec1);
		while ($res1 = mysqli_fetch_array($exec1))
		{
			$mainmenuid=$res1['mainmenuid'];
			$submenu_id=$res1['submenuid'];
			$submenutext=$res1['submenutext'];
			$submenuorder=$res1['submenuorder'];
			
			$submenulink=$res1['submenulink'];
			$auto_number = $res1['auto_number'];
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
                           
                            <td  align="left" valign="top"  class="bodytext31"><?php echo $mainmenuid; ?></td>
                            <td align="left" valign="top"  class="bodytext31"><?php echo $submenu_id; ?></td>
                            <td  align="left" valign="top"  class="bodytext31"><?php echo $submenuorder; ?></td>
                            <td  align="left" valign="top"  class="bodytext31"><?php echo $submenutext; ?></td>
                            <td width="11%"  align="left" valign="top"  class="bodytext31"><?php echo $submenulink; ?></td>
                            <td width="9%" align="left" valign="top"  class="bodytext31"><a href="edit_master_submenu.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a>&nbsp;&nbsp; <a href="master_sub_menu.php?st=del&&anum=<?php echo $auto_number; ?>" onClick="return funcDeletesurgery1('<?php echo $name;?>')"> <img src="images/b_drop.png" width="16" height="16" border="0" /></a></td>
                          </tr>
                          <?php } ?>
                          <tr>
                            <td align="middle" colspan="4" >Total no of activate sub menus : <?= $num1 ?></td>
                          </tr>
                        </tbody>
                      </table>
                      <table width="1000" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                        <tbody>
                          <tr bgcolor="#011E6A">
                            <td colspan="6" bgcolor="#ecf0f5" class="bodytext11"><strong>Master Sub-Menu- Deleted </strong></td>
                          </tr>
                             <tr bgcolor="#011E6A"> <th  width="21%"  height="48" >Main Menu Id</th> <th width="22%">Sub Menu ID</th> <th width="22%">Sub Order No</th>
                            <th width="20%">Menu Name</th> <th width="20%">Menu Url</th>
                      <th width="9%">Action</th> </tr>
                          <?php
		
	    $Query = "select * from master_menusub where status = 'deleted' order by auto_number DESC";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $Query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1 = mysqli_num_rows($exec1);
		while ($res1 = mysqli_fetch_array($exec1))
		{
			$mainmenuid=$res1['mainmenuid'];
			$submenu_id=$res1['submenuid'];
			$submenutext=$res1['submenutext'];
			$submenuorder=$res1['submenuorder'];
			$submenulink=$res1['submenulink'];
			$auto_number = $res1['auto_number'];
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
                         
                            <td align="left" valign="top"  class="bodytext31"><?php echo $mainmenuid; ?></td>
                            <td  align="left" valign="top"  class="bodytext31"><?php echo $submenu_id; ?></td>
                            <td  align="left" valign="top"  class="bodytext31"><?php echo $submenuorder; ?></td>
                            <td align="left" valign="top"  class="bodytext31"><?php echo $submenutext; ?></td>
                            <td align="left" valign="top"  class="bodytext31"><?php echo $submenulink; ?></td>
                               <td width="22%" height="28" align="left" valign="top"  class="bodytext31"><a href="master_sub_menu.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext31">
                              <div align="center" class="bodytext31">Activate</div>
                              </a></td>
                          </tr>
                          
                          <?php
		}
		?>
                          <tr>
                            <td align="middle" colspan="4" >Total no of In-activate sub menus : <?= $num1 ?></td>
                          </tr>
                        </tbody>
                      </table>
                    </form></td>
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
</div>
</body>
</html>