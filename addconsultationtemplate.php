<?php

session_start();

error_reporting(0);

//date_default_timezone_set('Asia/Calcutta');

include ("db/db_connect.php");

include ("includes/loginverify.php");
//echo $menu_id;
include ("includes/check_user_access.php");
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

     $query26="insert into master_consultationtemplate(templatename,templatedata,recorddate,recordtime,username)values('$templatename','$templatedata','$dateonly1','$timeonly','$username')";

     $exec26=mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	  header("location:addconsultationtemplate.php?st=success");

      exit();

	 }

	 else

	{

		header ("location:addconsultationtemplate.php?st=failed");

	}

   

 

}



?>



<!--<script>

function textareacontentcheck()

{

if(document.getElementById("consultation").value == '')

	{

	alert("Enter content");

	document.getElementById("consultation").focus();

	return false;

	}

}



</script>

-->

<script type="text/javascript" src="ckeditor1/ckeditor.js"></script>

<!-- Modern CSS -->
<link href="css/addconsultationtemplate-modern.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />

<!-- Modern JavaScript -->
<script type="text/javascript" src="js/addconsultationtemplate-modern.js?v=<?php echo time(); ?>"></script>



<!-- Additional styles moved to external CSS -->







</head>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<body onLoad="return funcOnLoadBodyFunctionCall();">

<header>
  <?php include ("includes/alertmessages1.php"); ?>
  <?php include ("includes/title1.php"); ?>
  <?php include ("includes/menu1.php"); ?>
</header>

<main class="main-container">
<form name="frmsales" id="frmsales" method="post" action="addconsultationtemplate.php" onKeyDown="return disableEnterKey(event)" enctype="multipart/form-data">

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

        <div class="form-container">
          <div class="form-header">Add Consultation Template</div>
          
          <div class="form-row">
            <div class="form-group">
              <label for="templatename">Template Name:</label>
              <input name="templatename" id="templatename" value="" class="form-control" style="text-transform:uppercase;" placeholder="Enter template name...">
            </div>
          </div>
        </div>

      </tr>

      

      <tr>

        <td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 

            align="left" border="0">

          <tbody id="foo">

         

<tr></tr>

                 <div class="editor-container">
                    <textarea id="consultation" cols='50' rows='15' class="ckeditor" name="editor1" placeholder="Enter your consultation template content here..."></textarea>
                 </div>

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

              <div class="btn-group">
                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
             	  <input name="Submit2223" type="submit" value="Save Template" onClick="return textareacontentcheck()" accesskey="b" class="btn btn-primary"/>
               </div>

              

            </tr>

          </tbody>

        </table></td>

      </tr>

    </table>

  </table>



</form>
</main>

<footer>
  <?php include ("includes/footer1.php"); ?>
</footer>

</body>
</html>