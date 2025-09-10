<?php
session_start();
$pagename = '';
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION['username'])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$sessionusername = $_SESSION['username'];
$errmsg = '';
$bgcolorcode = '';
$tdno = 0;
$colorloopcount = '';

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

if (isset($_REQUEST["searchsuppliername"])) {  $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchdescription"])) {   $searchdescription = $_REQUEST["searchdescription"]; } else { $searchdescription = ""; }
if (isset($_REQUEST["searchemployeecode"])) { $searchemployeecode = $_REQUEST["searchemployeecode"]; } else { $searchemployeecode = ""; }
if (isset($_REQUEST["radio_emp"])) { $allemployees = $_REQUEST["radio_emp"];} else{$allemployees = "";}

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
-->
</style>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />  
<script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>
<script type="text/javascript" src="js/autosuggestjobdescription1.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());
  
}
</script>
<!--CODE TO ENABLE AND DISABLE SEARH ON  RADIO BUTTONS-->
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script language="javascript">
$(function(){
//$("#searchsuppliername").prop("disabled",true);

	$("#search_emp").click(function () {
			$("#searchsuppliername").prop("disabled",false);
			$("#searchsuppliername").focus();
			
			/*if($("#searchemployeename").val() == "")
			{
				alert("Please Select any Employee");
			}*/
	});
	
	$("#all").click(function () {
			$("#searchsuppliername").prop("disabled",true);
			var allempval = $("#all").val();
			$("#searchemployeecode").val(allempval);
	});
	
	
	//HIDE DIV FOR HIDE/SHOW -- BY DEFAULT
	$(function() {
		$("[id^='dropid']").hide(0);
 	 }
	);
	//ENDS
});
</script>
<!--ENDS-->
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



function funcEmployeeSelect1()
{
	
	if (document.getElementById("selectemployeecode").value == "")
	{
		alert ("Please Select Employee Code To Edit.");
		document.getElementById("selectemployeecode").focus();
		return false;
	}
}


</script>

<!--CODE FOR SLIDEUP AND SLIDEDOWN-->
 <script>
  
  function dropdown(id,action)
  {
	  if(action=='down')
	  {
		  $("#dropid"+id).slideDown(300); 
		  $("#down"+id).hide(0); 
		  $("#up"+id).show(0);
	  }
	 if(action=='up')
	  {
		  $("#dropid"+id).slideUp(300);  
		  $("#up"+id).hide(0);
		  $("#down"+id).show(0);
	  }
  }
  </script>
<!--ENDS-->

<script src="js/datetimepicker_css.js"></script>
<body>
<form name="form1" method="post" action="employeeaccessinfo.php">
<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5">
	<?php 
	
		include ("includes/menu1.php"); 
	
	//	include ("includes/menu2.php"); 
	
	?>	</td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  		
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    
<!--IF ALL SELECTED-->

     <td width="97%" valign="top">
      <br>	 
      <table width="" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="">
          	<table border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            	<tbody>
					<tr>
                     <td colspan="5" width="30" bgcolor="#ecf0f5" class="bodytext3" align="left" valign="middle"><strong>Employee Access Report</strong></td>
					</tr> 
					<tr>
					<td bgcolor="#FFF">&nbsp;</td>
                     <td width="300" bgcolor="#FFF" class="bodytext3" align="right" valign="middle"><strong>Search Employee :</strong></td>
					 <td width="700" colspan="3" bgcolor="#FFF" class="bodytext3" align="left" valign="middle">
					 <input type="hidden" name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox">
					 <input type="hidden" name="searchdescription" id="searchdescription">
					 <input type="hidden" name="searchemployeecode" id="searchemployeecode" value="<?= $searchemployeecode; ?>">
					 <input type="text" name="searchsuppliername" id="searchsuppliername" autocomplete="off" value="<?= $searchsuppliername; ?>" size="50"></td>
					</tr>
					<tr>
                     <td colspan="2" bgcolor="#FFF" class="bodytext3" align="right" valign="middle"><strong>&nbsp;</strong></td>
					 <td colspan="3" bgcolor="#FFF" class="bodytext3" align="left" valign="middle">
					 <input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
					 <input type="submit" name="submit45" value="<?= 'Submit'; ?>"></td>
					</tr>
					<?php
					if($frmflag1 == 'frmflag1') { ?>
              		<tr>
                     <td width="30" bgcolor="#ecf0f5" class="bodytext3" align="center" valign="middle"><strong>S No. </strong></td>
               		 <td width="300" bgcolor="#ecf0f5" class="bodytext3" align="center" valign="middle"><strong>Employee Name </strong></td>
                	 <td width="250" bgcolor="#ecf0f5" class="bodytext3" align="center" valign="middle"><strong>Role</strong></td>
                     <td width="250" bgcolor="#ecf0f5" class="bodytext3" align="center" valign="middle"><strong>User Name</strong></td>
                     <td width="100" bgcolor="#ecf0f5" class="bodytext3" align="center" valign="middle"><strong>Show/Hide</strong></td>
					 <td class="bodytext3" align="left"><a href="employeeaccessinfo_xl.php?cbfrmflag1=cbfrmflag1&&searchemployeecode=<?php echo $searchemployeecode; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a>    
					 </td>
                    </tr>
                    <?php 
						$sno = 0;
						$qryempcode = "SELECT employeecode FROM master_employeerights WHERE employeecode<>'' and employeecode = '$searchemployeecode' GROUP BY employeecode";
						$execempcode = mysqli_query($GLOBALS["___mysqli_ston"], $qryempcode) or die ("Error in qryempcode".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($resempcode = mysqli_fetch_array($execempcode))
						{
							$empcode = $resempcode["employeecode"];
							
							//GET EMPLOYEE NAME AND DESIGNATION 
							$qryemdetails = "SELECT employeename,jobdescription,username,role_id FROM master_employee WHERE employeecode='$empcode'";
							$execempdetails = mysqli_query($GLOBALS["___mysqli_ston"], $qryemdetails) or die ("Error in qryemdetails".mysqli_error($GLOBALS["___mysqli_ston"]));
							$resempdetails =  mysqli_fetch_assoc($execempdetails);
							$empname = $resempdetails["employeename"];
							$designation = $resempdetails["jobdescription"];
							$username = $resempdetails["username"];														$role_id = $resempdetails["role_id"];																					$qryemdetails1 = "SELECT role_name FROM master_role WHERE role_id='$role_id'";							$execempdetails1 = mysqli_query($GLOBALS["___mysqli_ston"], $qryemdetails1) or die ("Error in qryemdetails1".mysqli_error($GLOBALS["___mysqli_ston"]));							$resempdetails1 =  mysqli_fetch_assoc($execempdetails1);							$role_name = $resempdetails1["role_name"];																					
							if($empname == "")
							{
								$empname = "Unkonown";
							}
							
							$colorloopcount = $colorloopcount + 1;
							$showcolor = ($colorloopcount & 1); 
							if ($showcolor == 0)
							{
								//echo "if";
								$colorcode = 'bgcolor="#CBDBFA"';
							}
							else
							{
								//echo "else";
								$colorcode = 'bgcolor="#ecf0f5"';
							} 
							
					?>
                    <tr  <?php echo $colorcode; ?>>
                    	 <td  class="bodytext3" align="center" valign="middle"><?php echo $sno = $sno + 1; ?></td>
                         <td  class="bodytext3" align="center" valign="middle"><?php echo $empname; ?></td>
                         <td  class="bodytext3" align="center" valign="middle"><span style="text-transform:uppercase"><?php echo $role_name; ?></span></td>
                         <td  class="bodytext3" align="center" valign="middle"><?php echo $username;?></td>
                         <!--VENU -- SHOW/HIDE DETATILS-->
                          <td class="bodytext3" align="center" valign="middle">
                          <?php  $tdno = $tdno + 1; ?>
              <a id="down<?php echo $tdno; ?>" onClick="dropdown(<?php echo $tdno; ?>,'down')" style="background:url(img/arrow1.png) 0px 10px;width:20px;height:10px;float:center;display:block;text-decoration:none;"></a>
                <a id="up<?php echo $tdno; ?>"  onClick="dropdown(<?php echo $tdno; ?>,'up')" style="background:url(img/arrow1.png) 0px 0px;width:20px;height:10px;float:center;display:block;text-decoration:none;display:none;"></a>
                          </td>
                         <!--ends-->
					</tr>
                    <tr>
                    	<td colspan="5" valign="top">
                         <!--DIV TO SHOW AND HIDE-->
                         <div id="dropid<?php echo $tdno; ?>" style="BORDER-COLLAPSE: collapse;">
                          <table border="1" style="border-collapse:collapse">
                           <tr>
                           	<!--FOR MENU PERMISSIONS-->
                            <td  valign="top">
                                <table border="0" style="border-collapse:collapse">
                                  <tr>
                                      <td width="250" bgcolor="#ffffff" class="bodytext3" align="center" valign="middle"><strong>Menu Permissions</strong></td>
                                  </tr>
								  <?php
                                  //CODE FOR MENU PERMISSIONS
                                      $displaycount = 12;
									  $colorloopcount1 = '';
                                  //GET SUB MENUS WHICH ARE IN ACCESS
                                  $qrysubmenucode = "SELECT submenuid FROM master_employeerights WHERE employeecode='$empcode' AND submenuid<>'' ORDER BY submenuid"; 
                                  $execsubmenucode = mysqli_query($GLOBALS["___mysqli_ston"], $qrysubmenucode) or die ("Error in qrysubmenucode".mysqli_error($GLOBALS["___mysqli_ston"]));
                                  while($ressubmenuname = mysqli_fetch_array($execsubmenucode))
                                  {
                                      $submenucode = $ressubmenuname["submenuid"];
                                      
                                      //GET SUBMENU NAME ON SUBMENUCODE
                                      $qrysubmenuname = "SELECT submenutext FROM master_menusub WHERE submenuid='$submenucode' AND status<>'deleted'";
                                      $execsubmenuname = mysqli_query($GLOBALS["___mysqli_ston"], $qrysubmenuname) or die ("Error in qrysubmenuname".mysqli_error($GLOBALS["___mysqli_ston"]));
                                      $ressubmenuname = mysqli_fetch_assoc($execsubmenuname);
                                      $submenuname = $ressubmenuname["submenutext"];
									  
									    $colorloopcount1 = $colorloopcount1 + 1;
										$showcolor1 = ($colorloopcount1 & 1); 
										if ($showcolor1 == 0)
										{
											//echo "if";
											$colorcode1 = 'bgcolor="#CBDBFA"';
										}
										else
										{
											//echo "else";
											$colorcode1 = 'bgcolor="#ecf0f5"';
										} 
                                  ?>
                                      <tr <?php echo $colorcode1;?>>
                                       <td  class="bodytext3" align="left" valign="middle"><?php echo $submenuname; ?></td>
                                     </tr>   
                                   <?php	
                                  }//close -- inner while
                                  ?>
                           		</table>
                            </td>
                            <!--ENDS-->
                            <!--FOR DEPARTMENT-->
                            <td valign="top">
                            	<table border="0" style="border-collapse:collapse">
                                  <tr>
                                      <td bgcolor="#ffffff" width="200" class="bodytext3" align="center" valign="middle"><strong>Department</strong></td>
                                  </tr>
								  <?php
                                  //CODE FOR departments
								   $colorloopcount2 = '';
                                   $querydept = "select auto_number,department from master_employeedepartment where employeecode ='$empcode' order by auto_number";
                                   $execdept = mysqli_query($GLOBALS["___mysqli_ston"], $querydept) or die ("Error in querydept".mysqli_error($GLOBALS["___mysqli_ston"]));
                                   while ($resdept = mysqli_fetch_array($execdept))
                                   {
                                    $deptautonum = $resdept['auto_number'];
                                    $departmentname = $resdept['department'];
                                    if($departmentname == "")
                                    {
                                        $departmentname ="  ";
                                    }
									
									$colorloopcount2 = $colorloopcount2 + 1;
									$showcolor2 = ($colorloopcount2 & 1); 
									if ($showcolor2 == 0)
									{
										//echo "if";
										$colorcode2 = 'bgcolor="#CBDBFA"';
									}
									else
									{
										//echo "else";
										$colorcode2 = 'bgcolor="#ecf0f5"';
									} 
							
                                  ?>
                                      <tr <?php echo $colorcode2;?>>
                                       <td  class="bodytext3" align="left" valign="top"><?php echo $departmentname; ?></td>
                                     </tr>   
                                   <?php	
                                  }//close -- inner while
                                  ?>
                           		</table>
                            </td>
                            <!--ENDS-->
                            <!--FOR LOCATION-->
                            <td valign="top">
                            	<table border="0" style="border-collapse:collapse">
                                  <tr>
                                      <td bgcolor="#ffffff" width="200" class="bodytext3" align="center" valign="middle"><strong>Location</strong></td>
                                  </tr>
								  <?php
                                  //CODE FOR departments
								   $colorloopcount3 = '';
                                   //LOCATION CODE
							      //CODE FOR LOCATION
								 $qrylocation = "SELECT locationname,locationcode FROM master_employeelocation WHERE employeecode='$empcode' GROUP BY locationcode";
								 $execlocation   = mysqli_query($GLOBALS["___mysqli_ston"], $qrylocation) or die ("Error in qrylocation".mysqli_error($GLOBALS["___mysqli_ston"]));
								 while($reslocation = mysqli_fetch_assoc($execlocation))
								 {
								 $locationcode = $reslocation["locationcode"];
								 $locationname = $reslocation["locationname"];
									
									$colorloopcount3 = $colorloopcount3 + 1;
									$showcolor3 = ($colorloopcount3 & 1); 
									if ($showcolor3 == 0)
									{
										//echo "if";
										$colorcode3 = 'bgcolor="#CBDBFA"';
									}
									else
									{
										//echo "else";
										$colorcode3 = 'bgcolor="#ecf0f5"';
									} 
							
                                  ?>
                                      <tr <?php echo $colorcode3;?>>
                                       <td  class="bodytext3" align="left" valign="top"><?php echo $locationname;?></td>
                                     </tr>   
                                   <?php	
                                  }//close -- inner while
                                  ?>
                           		</table>
                            </td>
                            <!--ENDS-->
                            <!--FOR STORES-->
                            <td valign="top">
                            	<table border="0" style="border-collapse:collapse">
                                  <tr>
                                      <td bgcolor="#ffffff" width="250" class="bodytext3" align="center" valign="middle"><strong>Store</strong></td>
                                  </tr>
								  <?php
                                  //CODE FOR -STORES
								  $colorloopcount4 = '';
                                     //GET STORE VALUES BASED ON LOCATIONCODE
								$qrylocation = "SELECT storecode FROM master_employeelocation WHERE employeecode='$empcode' group by storecode";
								 $execlocation   = mysqli_query($GLOBALS["___mysqli_ston"], $qrylocation) or die ("Error in qrylocation".mysqli_error($GLOBALS["___mysqli_ston"]));
								 while($reslocation = mysqli_fetch_assoc($execlocation))
								 {	
								 $storeanum = $reslocation['storecode'];
								 
                                $qrystores = "SELECT store FROM master_store WHERE auto_number = '$storeanum'";
                                $execstores   = mysqli_query($GLOBALS["___mysqli_ston"], $qrystores) or die ("Error in qrystores".mysqli_error($GLOBALS["___mysqli_ston"]));
                                
                                while($resstores = mysqli_fetch_assoc($execstores))
                                {
                                    $storename = $resstores["store"];
								
									$colorloopcount4 = $colorloopcount4 + 1;
									$showcolor4 = ($colorloopcount4 & 1); 
									if ($showcolor4 == 0)
									{
										//echo "if";
										$colorcode4 = 'bgcolor="#CBDBFA"';
									}
									else
									{
										//echo "else";
										$colorcode4 = 'bgcolor="#ecf0f5"';
									} 
                                  ?>
                                     <tr <?php echo $colorcode4;?>>
                                       <td  class="bodytext3" align="left" valign="middle"><?php echo $storename; ?></td>
                                     </tr>   
                                   <?php
								   }	
                                  }//close -- inner while
                                  ?>
                           		</table>
                            </td>
                            <!--ENDS-->
                           </tr>
                          </table> 
                          </div> 
                        </td>
                    </tr>
                    
                     <!--ENDS-->
					<?php
						} //close -- outer while
						} //frmflag1
					?>
              </tbody>
          </table>
          </td>
        </tr>
    </table>
	 </td>
<!--ENDS-->
</table>
</form>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

