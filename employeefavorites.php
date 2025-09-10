<?php

session_start();

$pagename = '';

//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.

if (!isset($_SESSION['username'])) header ("location:index.php");

include ("db/db_connect.php");

$username = $_SESSION['username'];

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$sessionusername = $_SESSION['username'];

$qryempcode1 = "SELECT employeename,employeecode FROM master_employee WHERE username= '$username'";

$execempcode1 = mysqli_query($GLOBALS["___mysqli_ston"], $qryempcode1) or die ("Error in qryempcode1".mysqli_error($GLOBALS["___mysqli_ston"]));

$resempcode1 = mysqli_fetch_array($execempcode1);

$searchsuppliername = $resempcode1["employeename"];

$searchemployeecode = $resempcode1["employeecode"];

$errmsg = '';

$bgcolorcode = '';

$tdno = 0;

$colorloopcount = '';



if (isset($_REQUEST["frmflag112"])) { $frmflag112 = $_REQUEST["frmflag112"]; } else { $frmflag112 = ""; }

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

if (isset($_REQUEST["searchdescription"])) {   $searchdescription = $_REQUEST["searchdescription"]; } else { $searchdescription = ""; }


if (isset($_REQUEST["radio_emp"])) { $allemployees = $_REQUEST["radio_emp"];} else{$allemployees = "";}


if ($frmflag112 == 'frmflag112')

{
	
 $searchemployeecode =$_REQUEST['searchemployeecode'];	
	
	$query = "update master_employeerights set is_fav='0' where employeecode='$searchemployeecode' ";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));

foreach($_POST['menuid'] as $key=>$value)
{
 $menuid = $_POST['menuid'][$key];
foreach($_POST['is_fav'] as $check => $value)

{

$is_fav = $_POST['is_fav'][$check];

if($menuid == $is_fav)
{



$queryupdatecumstock2 = "update master_employeerights set is_fav='1' where submenuid='$menuid' and employeecode='$searchemployeecode'";
$execupdatecumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatecumstock2) or die ("Error in updateCumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));


}
}
}


	header("Location:employeefavorites.php");
exit;

}



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

<form name="form1" method="post" action="employeefavorites.php">

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

					 <input type="text" name="searchsuppliername" id="searchsuppliername" autocomplete="off" value="<?= $searchsuppliername; ?>" size="50" readonly></td>

					</tr>

					<tr>

                     <td colspan="2" bgcolor="#FFF" class="bodytext3" align="right" valign="middle"><strong>&nbsp;</strong></td>

					 <td colspan="3" bgcolor="#FFF" class="bodytext3" align="left" valign="middle">

					 <input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">

					 <input type="submit" name="submit45" value="<?= 'Submit'; ?>"></td>

					</tr>

					<?php

					//if($frmflag1 == 'frmflag1') { 
					?>

              		<tr>

                     <td width="30" bgcolor="#ecf0f5" class="bodytext3" align="center" valign="middle"><strong>S No. </strong></td>

               		 <td width="300" bgcolor="#ecf0f5" class="bodytext3" align="center" valign="middle"><strong>Employee Name </strong></td>

                	 <td width="250" bgcolor="#ecf0f5" class="bodytext3" align="center" valign="middle"><strong>Designation</strong></td>

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

                         <td  class="bodytext3" align="center" valign="middle"><span style="text-transform:uppercase"><?php echo $designation; ?></span></td>

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

                         <div id="" style="BORDER-COLLAPSE: collapse;">

                          <table border="1" style="border-collapse:collapse">

                           <tr>

                           	<!--FOR MENU PERMISSIONS-->

                            <td  valign="top">

                                <table border="0" style="border-collapse:collapse">

                                  <tr>

                                      <td width="300" bgcolor="#ffffff" class="bodytext3" align="center" valign="middle"><strong>Menu Permissions</strong></td>
									  
									   <td width="50" bgcolor="#ffffff" class="bodytext3" align="center" valign="middle"><strong>Is_fav</strong></td>

                                  </tr>

								  <?php

                                  //CODE FOR MENU PERMISSIONS

                                      $displaycount = 12;

									  $colorloopcount1 = '';

                                  //GET SUB MENUS WHICH ARE IN ACCESS

                                  $qrysubmenucode = "SELECT submenuid,is_fav FROM master_employeerights WHERE employeecode='$empcode' AND submenuid<>'' ORDER BY submenuid"; 

                                  $execsubmenucode = mysqli_query($GLOBALS["___mysqli_ston"], $qrysubmenucode) or die ("Error in qrysubmenucode".mysqli_error($GLOBALS["___mysqli_ston"]));

                                  while($ressubmenuname = mysqli_fetch_array($execsubmenucode))

                                  {

                                      $submenucode = $ressubmenuname["submenuid"];
									  
									  $is_fav = $ressubmenuname["is_fav"];

                                      

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

                                       <td  class="bodytext3" align="left" valign="middle"><?php echo $submenuname; ?>
									   
									   <input type="hidden" name="menuid[]" id="menuid" value="<?php echo $submenucode; ?>"> 
									   
									   </td>
									   
									    <td  class="bodytext3" align="middle" valign="middle"><input type="checkbox"   name="is_fav[]" id="is_fav" value="<?php echo $submenucode; ?>" onClick="" <?php if($is_fav == '1') { echo "Checked"; } ?> ></td>

                                     </tr>   

                                   <?php	

                                  }//close -- inner while

                                  ?>

                           		</table>

                            </td>

                            <!--ENDS-->

                           

                           </tr>
						
						 <tr>

                        <td width="" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                        <td colspan="2" align="left" valign="top"  bgcolor="#FFFFFF">

                            <input type="hidden" name="frmflag112" value="frmflag112" />

                        <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" /></td>

                      </tr>
						
						
                          </table> 

                          </div> 

                        </td>

                    </tr>

                    

                     <!--ENDS-->

					<?php

						} //close -- outer while

						//} //frmflag1

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



