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
		$menu_id = $_REQUEST["menu_id"];
		$submenuid = $_REQUEST["submenuid"];
		$submenuorder = $_REQUEST["submenuorder"];
		$menu_name = $_REQUEST['submenu_name'];
		$menu_url = $_REQUEST['submenu_url'];
		$edit_anum = $_REQUEST['edit_anum'];
		  $Query = "update master_menusub set mainmenuid='".$menu_id."',submenuid='".$submenuid."',submenuorder='".$submenuorder."',submenutext='".$menu_name."',submenulink='".$menu_url."' where auto_number = '$edit_anum'";
		//exit;
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $Query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
		$errmsg = "Success. Sub Menu Updated";
		//exit;
		$bgcolorcode = 'success';
		header('location:submenu.php');
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

<?php include("includes/menu1.php"); 

$edit_anum = isset($_REQUEST['anum'])?$_REQUEST['anum']:'';
if($_REQUEST['st'] == 'edit')
{
 $query2 = "select * from master_menusub where auto_number = '$edit_anum'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$menu_id = $res2["mainmenuid"];
$submenuid = $res2["submenuid"];
$submenuorder = $res2["submenuorder"];
$menu_name = $res2['submenutext'];
$menu_url = $res2['submenulink'];
}
else
{
$menu_id = '';
$submenuid = '';
$submenuorder ='';
$menu_name = '';
$menu_url = '';
 
  
} 

?>
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
                  <td><form name="form1" id="form1" method="post" action="edit_master_submenu.php" onSubmit="return process1()">
                      <table width="914" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                        <?php 
                    $prev_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
                    if( !empty( $prev_url ) || strpos( $prev_url,  "?p=")+1):
                    //Then display it only if it's one of my blog page ?>
                        <a href="<?php echo 'master_sub_menu.php'; ?>" class="previous-history-link">
                        <input type="button" name="Back" value="Back" >
                        </a>
                        <?php endif; ?>
                        <tbody>
                          <tr bgcolor="#011E6A">
                            <td colspan="2" bgcolor="#ecf0f5" class="bodytext11"><strong>Master Sub-Menu - Edit </strong></td>
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
                               <option value="<?php echo  $res5accountsmain;  ?>" <?php if($menu_id == $res5accountsmain){echo 'selected';} ?>><?php echo $res5mainmenutext; ?></option>
                              <?php	 
                            }
                            ?>
                            </select>
                              
                              </td>
                              
                          </tr>
                          <tr>
                            <td align="left" valign="middle"  bgcolor="#FFFFFF" class="validfield"><div align="right">Sub Menu ID </div></td>
                            <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="submenuid" id="submenuid" value="<?php echo $submenuid;?>"  readonly></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle"  bgcolor="#FFFFFF" class="validfield"><div align="right">Sub Menu Order </div></td>
                            <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="submenuorder" id="submenuorder" value="<?php echo $submenuorder;?>" ></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle"  bgcolor="#FFFFFF" class="validfield"><div align="right">Sub Menu Name </div></td>
                            <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="submenu_name" id="submenu_name"  value="<?php echo $menu_name;?>"></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle"  bgcolor="#FFFFFF"><div align="right"Sub> Sub Menu Url </div></td>
                            <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="submenu_url" id="submenu_url"  value="<?php echo $menu_url;?>"></td>
                          </tr>
                          <tr>
                            <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
                            <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="frmflag" value="addnew" />
                              <input type="hidden" name="frmflag1" value="frmflag1" />
							  <input type="hidden" name="edit_anum" value="<?= $edit_anum?>" />
                              <input type="submit" name="Submit" value="Submit"  /></td>
                          </tr>
                          <tr>
                            <td align="middle" colspan="2" >&nbsp;</td>
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