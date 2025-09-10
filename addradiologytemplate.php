<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");

$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$timeonly = date("H:i:s");
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$dateonly1 = date("Y-m-d");

$errmsg = "";

if (isset($_REQUEST["errmsg"])) { $errmsg = $_REQUEST["errmsg"]; } else { $errmsg = ""; }
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'success')
{
		$errmsg = "Success. File Uploaded Successfully.";
		if (isset($_REQUEST["cpynum"])) { $cpynum = $_REQUEST["cpynum"]; } else { $cpynum = ""; }
	
}
if ($st == 'failed')
{
		$errmsg = "Upload Failed";
}

if ($frm1submit1 == 'frm1submit1')
{   
	$templatedata = $_REQUEST['editor1'];
	$templatename = $_REQUEST['templatename'];

   if($templatedata != '') 
     {  
     $query26="insert into master_radiologytemplate(templatename,templatedata,recorddate,recordtime,username)values('$templatename','$templatedata','$dateonly1','$timeonly','$username')";
     $exec26=mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	  header("location:addradiologytemplate.php?st=success");
      exit();
	 }
	 else
	{
		header ("location:addradiologytemplate.php?st=failed");
	}
   
 
}

?>

<!--<script>
function textareacontentcheck()
{
if(document.getElementById("radiology").value == '')
	{
	alert("Enter content");
	document.getElementById("radiology").focus();
	return false;
	}
}

</script>
-->
<script type="text/javascript" src="ckeditor_4.4.3/ckeditor/ckeditor.js"></script>

<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.style1 {
	font-size: 36px;
	font-weight: bold;
}
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
</style>



</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="frmsales" id="frmsales" method="post" action="addradiologytemplate.php" onKeyDown="return disableEnterKey(event)" enctype="multipart/form-data">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
<!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="980" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td height="24" colspan="8" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
    </tr>
      <tr>
        <td><table width="100%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
			  <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Add Radiology Template</strong></td>
                </tr>
			    <tr bgcolor="#011E6A">
			  		<td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Template Name </strong></td>
					 <td width="86%" align="left" valign="middle"  bgcolor="#ecf0f5">
						<input name="templatename" id="templatename" value="" style="border: 1px solid #001E6A; text-transform:uppercase;" size="60">
		            </td>
                </tr>	
            </tbody>
        </table></td>
      </tr>
      
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
         
<tr></tr>     <!--   <script>

                 function check() {
    document.getElementById("myCheck").checked = true;
	CKEDITOR.instances.radiology.setData("Hello");
} </script>-->
                 <tr>
                    <textarea id="radiology" cols='50' rows='15' class="ckeditor" name="editor1">
					<?php
						$sql = "SELECT templatedata FROM master_radiologytemplate WHERE auto_number =67";
						$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die('Bad query!'.mysqli_error($GLOBALS["___mysqli_ston"]));  
						
						while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){        
						$db_pdf = $row['templatedata']; // No stripslashes() here.
						}
                        
						echo $db_pdf;
					
					?>
					
					</textarea>
				</tr>
			<?php 
		?>
<!--			  <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				  
               </tr>
-->          </tbody>
        </table>		</td>
      </tr>
      
      
      
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr>
              <td width="54%" align="right" valign="top" >
                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
             	  <input name="Submit2223" type="submit" value="Save " onClick="return textareacontentcheck()" accesskey="b" class="button" style="border: 1px solid #001E6A"/>
               </td>
              
            </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
  </table>

</form>



<table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td width="13%"bgcolor="#ecf0f5" class="bodytext3"></td>
                        <td width="13%" bgcolor="#ecf0f5" class="bodytext3"><strong>Template Name</strong></td>
                        
                        <td width="13%" bgcolor="#ecf0f5" class="bodytext3"><strong> </strong></td>
                        <td width="13%" bgcolor="#ecf0f5" class="bodytext3"><strong>Edit</strong></td>
                      </tr>
                      <?php
                      $x=1;
      $query1 = "SELECT * from master_radiologytemplate  order by auto_number ";
    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
    while ($res1 = mysqli_fetch_array($exec1))
    {
    $templatename = $res1["templatename"];
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
                        <!-- <td width="4%" align="left" valign="top"  class="bodytext3"><div align="center">
            <a href="adddepartment1.php?st=del&&anum=<?php echo $auto_number; ?>" onClick="return funcDeleteDepartment1('<?php echo $department;?>')">
            <img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td> -->
            <td ><?=$x;?></td>
                        <td width="21%" align="left" valign="top"  class="bodytext3"><?php echo $templatename; ?> </td>
                        
              <td width="10%" align="left" valign="top"  class="bodytext3"></td>
                        <td width="10%" align="left" valign="top"  class="bodytext3">
            <a href="edit_radiologytemplate.php?anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a>           </td>
                      </tr>
                      <?php
    $x++; }
    ?>
                      <tr>
                        <td align="middle" colspan="5" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Radio Template </strong></td>
                      </tr>
                     
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


<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>