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

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="employeeaccessinfo.xls"');
header('Cache-Control: max-age=80');

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }


if (isset($_REQUEST["searchemployeecode"])) { $searchemployeecode = $_REQUEST["searchemployeecode"]; } else { $searchemployeecode = ""; }

?>


<body>
 <table width="" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="">
          	<table border="1" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            	<tbody>
              		<tr>
                     <td width="30"  class="bodytext3" align="left" valign="middle"><strong>S No. </strong></td>
               		 <td width="300" class="bodytext3" align="center" valign="middle"><strong>Employee Name </strong></td>
                	 <td width="250" class="bodytext3" align="center" valign="middle"><strong>Designation</strong></td>
                     <td colspan="2" width="250" class="bodytext3" align="center" valign="middle"><strong>User Name</strong></td>
                    </tr>
                    <?php 
						$sno = 0;
						$qryempcode = "SELECT employeecode FROM master_employeerights WHERE employeecode<>'' and employeecode = '$searchemployeecode' GROUP BY employeecode";
						$execempcode = mysqli_query($GLOBALS["___mysqli_ston"], $qryempcode) or die ("Error in qryempcode".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($resempcode = mysqli_fetch_array($execempcode))
						{
							$empcode = $resempcode["employeecode"];
							
							//GET EMPLOYEE NAME AND DESIGNATION 
							$qryemdetails = "SELECT employeename,jobdescription,username FROM master_employee WHERE employeecode='$empcode'";
							$execempdetails = mysqli_query($GLOBALS["___mysqli_ston"], $qryemdetails) or die ("Error in qryemdetails".mysqli_error($GLOBALS["___mysqli_ston"]));
							$resempdetails =  mysqli_fetch_assoc($execempdetails);
							$empname = $resempdetails["employeename"];
							$designation = $resempdetails["jobdescription"];
							$username = $resempdetails["username"];
							if($empname == "")
							{
								$empname = "Unkonown";
							}
					?>
                    <tr>
                    	 <td  class="bodytext3" align="left" valign="middle"><?php echo $sno = $sno + 1; ?></td>
                         <td  class="bodytext3" align="center" valign="middle"><?php echo $empname; ?></td>
                         <td  class="bodytext3" align="center" valign="middle"><span style="text-transform:uppercase"><?php echo $designation; ?></span></td>
                         <td  class="bodytext3" align="center" valign="middle"><?php echo $username;?></td>
                    </tr>
                    <tr>
                    	<td></td>
                    	<td colspan="4"  valign="top">
                         <!--DIV TO SHOW AND HIDE-->
                         <!--<div id="dropid<?php echo $tdno; ?>" style="BORDER-COLLAPSE: collapse;">-->
                          <table border="1" style="border-collapse:collapse">
                           <tr>
                           	<!--FOR MENU PERMISSIONS-->
                            <td valign="top">
                                <table border="1" style="border-collapse:collapse;">
                                  <tr>
                                      <td width="250" bgcolor="#ffffff" class="bodytext3" align="left" valign="top"><strong>Menu Permissions</strong></td>
                                  </tr>
								  <?php
                                  //CODE FOR MENU PERMISSIONS
                                      $displaycount = 12;
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
						          ?>
                                      <tr>
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
                            	<table border="1" style="border-collapse:collapse">
                                  <tr>
                                      <td bgcolor="#ffffff" width="200" class="bodytext3" align="left" valign="top"><strong>Department</strong></td>
                                  </tr>
								  <?php
                                  //CODE FOR departments
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
									
								?>
                                      <tr>
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
                            	<table border="1" style="border-collapse:collapse">
                                  <tr>
                                      <td bgcolor="#ffffff" width="200" class="bodytext3" align="left" valign="middle"><strong>Location</strong></td>
                                  </tr>
								  <?php
                                   //LOCATION CODE
							      //CODE FOR LOCATION
								 $qrylocation = "SELECT locationname,locationcode FROM master_employeelocation WHERE employeecode='$empcode' GROUP BY locationcode";
								 $execlocation   = mysqli_query($GLOBALS["___mysqli_ston"], $qrylocation) or die ("Error in qrylocation".mysqli_error($GLOBALS["___mysqli_ston"]));
								 while($reslocation = mysqli_fetch_assoc($execlocation))
								 {
								 $locationcode = $reslocation["locationcode"];
								 $locationname = $reslocation["locationname"];
								  ?>
                                     <tr>
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
                            	<table border="1" style="border-collapse:collapse">
                                  <tr>
                                      <td bgcolor="#ffffff" width="250" class="bodytext3" align="left" valign="top"><strong>Store</strong></td>
                                  </tr>
								  <?php
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
								
								?>
                                     <tr>
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
					?>
              </tbody>
          </table>
          </td>
        </tr>
    </table>
</body>
</html>

