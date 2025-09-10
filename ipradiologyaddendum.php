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

$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$dateonly1 = date("Y-m-d");
$timeonly= date("H:i:s");
$titlestr = 'SALES BILL';
$colorloopcount = '';
$sno = '';
?>

<?php
if (isset($_REQUEST["viewstatus"])) { $viewstatus = $_REQUEST["viewstatus"]; } else { $errcode = ""; }
if($viewstatus == 'viewed')
{
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
$docnumber = $_REQUEST["docnumber"];
	   $query26="update ipresultentry_radiology set viewstatus ='$viewstatus' where patientcode='$patientcode' and patientvisitcode='$visitcode' and docnumber='$docnumber' ";
	    $exec26=mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
}

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if($frm1submit1 == 'frm1submit1')
{
	//print_r($_REQUEST);
	$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
$docnumber = $_REQUEST["docnumber"];
$getdata = addslashes($_REQUEST["getdata"]);
	    $query26="update ipresultentry_radiology set addendum = '".$getdata."',addendum_by = '$username', addendum_at = '$updatedatetime' where patientcode='$patientcode' and patientvisitcode='$visitcode' and docnumber='$docnumber' ";
	    $exec26=mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	header("location:radiologyresultsviewlist.php");
    exit();
}
if (isset($_REQUEST["errcode"])) { $errcode = $_REQUEST["errcode"]; } else { $errcode = ""; }
if($errcode == 'failed')
{
	$errmsg="No Stock";
}
?>

<script>
function funcShowDetailView(varSerialNumber)
			{
				//alert ("Inside Function.");
				var varSerialNumber = varSerialNumber
				//alert (varSerialNumber);

				for (i=1;i<=100;i++)
				{
					if (document.getElementById("idTRSub"+i+"") != null) 
					{
						document.getElementById("idTRSub"+i+"").style.display = 'none';
					}
				}

				if (document.getElementById("idTRSub"+varSerialNumber+"") != null) 
				{
					document.getElementById("idTRSub"+varSerialNumber+"").style.display = '';
				}
			}
			
			
function funcLabHideView(para)
{	
var idname=para;
alert(idname);
 if (document.getElementById(idname) != null) 
	{
	document.getElementById(idname).style.display = 'none';
	}			
}
function funcLabShowView(param)
{
var idname1=param;

  if (document.getElementById(idname) != null) 
     {
	 document.getElementById(idname).style.display = 'none';
	}
	if (document.getElementById(idname) != null) 
	  {
	  document.getElementById(idname).style.display = '';
	 }
}
</script>

	<script language="javascript">
			//alert ("Inside JS");
			//To Hide idTRSub rows this code is not given inside function. This needs to run after rows are completed.
			for (i=1;i<=100;i++)
			{
				if (document.getElementById("idTRMain"+i+"") != null) 
				{
					document.getElementById("idTRMain"+i+"").style.display = 'none';
				}
			}
			function funcShowDetailHide(varSerialNumber)
			{
				//alert ("Inside Function.");
				var varSerialNumber = varSerialNumber
				//alert (varSerialNumber);

				for (i=1;i<=100;i++)
				{
					if (document.getElementById("idTRMain"+i+"") != null) 
					{
						document.getElementById("idTRMain"+i+"").style.display = 'none';
					}
				}
			}
			
			function funcShowDetailView(varSerialNumber)
			{
				//alert ("Inside Function.");
				var varSerialNumber = varSerialNumber
				//alert (varSerialNumber);

				for (i=1;i<=100;i++)
				{
					if (document.getElementById("idTRMain"+i+"") != null) 
					{
						document.getElementById("idTRMain"+i+"").style.display = 'none';
					}
				}

				if (document.getElementById("idTRMain"+varSerialNumber+"") != null) 
				{
					document.getElementById("idTRMain"+varSerialNumber+"").style.display = '';
				}
			}
			</script>	
			
<script>
function funcOnLoadBodyFunctionCall()
{
funcLabHideView();
	}
	
function acknowledgevalid1()
{
var content = CKEDITOR.instances.editor1.getData();

document.getElementById("getdata").value = content;
	}
</script>
<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
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
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.ckeditor {display:none;}
</style>
<?php
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
$docnumber = $_REQUEST["docnumber"];
?>
<script src="js/datetimepicker_css.js"></script>
<?php
$query65= "select * from master_ipvisitentry where patientcode='$patientcode'";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die("error in query65".mysqli_error($GLOBALS["___mysqli_ston"]));
$res65=mysqli_fetch_array($exec65);
$patientname=$res65['patientfullname'];

$query69="select * from master_customer where customercode='$patientcode'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
$patientaccount=$res69['accountname'];

$query78="select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec78=mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res78=mysqli_fetch_array($exec78);
$patientage=$res78['age'];
$patientgender=$res78['gender'];


$query70="select * from master_accountname where auto_number='$patientaccount'";
$exec70=mysqli_query($GLOBALS["___mysqli_ston"], $query70);
$res70=mysqli_fetch_array($exec70);
$accountname=$res70['accountname'];
?>

</head>
<script type="text/javascript" src="ckeditor_new/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body>
<form name="frm" id="frmsales" method="post" action="ipradiologyaddendum.php" onKeyDown="return disableEnterKey(event)">
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
    <td colspan="4" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#ecf0f5'; } else { echo 'red'; } ?>" class="bodytext3"><strong><?php echo $errmsg;?>&nbsp;</strong></td></tr>
      <tr>
        <td colspan="8"><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#ecf0f5" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#ecf0f5">
              
                    <input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" /> 
                    <input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
               <td class="bodytext3" bgcolor="#ecf0f5"><strong>Patient  * </strong></td>
	  <td width="22%" class="bodytext3" align="left" valign="middle" bgcolor="#ecf0f5">
				<input name="customername" type="hidden" id="customer" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/>
				<?php echo $patientname; ?></td>
                          <td bgcolor="#ecf0f5" class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Date </strong></td>
				
                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
                
                <td width="26%" bgcolor="#ecf0f5" class="bodytext3"><?php echo $dateonly1; ?>
               
                  <input type="hidden" name="ADate" id="ADate" style="border: 1px solid #001E6A" value="<?php echo $dateonly1; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
				<td width="11%" align="left" valign="middle" class="bodytext3"><strong>Doc No</strong></td>
                <td width="21%" align="left" valign="middle" class="bodytext3">
			<input name="docnumber" id="docnumber" type="hidden" value="<?php echo $docnumber; ?>" style="border: 1px solid #001E6A" size="8" rsize="20" readonly/><?php echo $docnumber; ?>                  </td>
              </tr>
			  <tr>
			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code</strong></td>
                <td width="22%" class="bodytext3" align="left" valign="middle" >
			<input name="visitcode" type="hidden" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $visitcode; ?>                  </td>
                 <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient code </strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3">
				<input name="customercode" type="hidden" id="customercode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientcode; ?>
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
			    </tr>
				  <tr>

			  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
			    <td align="left" valign="middle" class="bodytext3">
				<input type="hidden" name="patientage" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientage; ?>
				&
				<input type="hidden" name="patientgender" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientgender; ?>			        </td>
                <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3">
				<input name="account" type="hidden" id="account" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $accountname; ?>
				<input type="hidden" name="samplecollectiondocno" value="<?php echo $docnumber; ?>">				</td>
				  </tr>
				  <tr>
				  <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
				  </tr>
            </tbody>
        </table></td>
      </tr>
	
		<tr>
			<td colspan="3" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext365">
			<strong>RADIOLOGY RESULTS</strong>
			</td> 
		</tr>	
	  
				
		<?php
   $query35="select imagefilename,imagefilename2,imagefilename3,radiologyitemcode as itemcode,radiologyinstructions from ipconsultation_radiology where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and docnumber = '$docnumber'  group by radiologyitemname";
		$exec35=mysqli_query($GLOBALS["___mysqli_ston"], $query35);
		while ($res35=mysqli_fetch_array($exec35))
		{
		$imagefilename = $res35['imagefilename'];
		$imagefilename2 = $res35['imagefilename2'];
		$imagefilename3 = $res35['imagefilename3'];
		$testcode = $res35['itemcode'];
		$radiologyinstructions = $res35['radiologyinstructions'];

if($visitcode=='walkinvis' && $patientcode=='walkin')
{
      $query31="select * from ipresultentry_radiology where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and billnumber = '$billnumber' and acknowledge = 'completed' and itemcode = '$testcode' group by itemname";
}
else
{
	 $query31="select * from ipresultentry_radiology where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and docnumber = '$docnumber' and acknowledge = 'completed' and itemcode = '$testcode' group by itemname";
}
	  $exec31=mysqli_query($GLOBALS["___mysqli_ston"], $query31);
	  $num=mysqli_num_rows($exec31);
	  while($res31=mysqli_fetch_array($exec31))
	  { 
		$labname1=$res31['itemname'];
        $templatedata=$res31['templatedata'];
		$docnumber=$res31['docnumber'];
		$filename = $res31['filename'];
		$fileurl = $res31['fileurl'];
		$addendum = $res31['addendum'];
	   
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
			$sno = $sno + 1;
		?>	
		<tr>
			<td width="97" height="28"  align="left" valign="center" class="bodytext31" ><strong>Test Name:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $labname1; ?></strong></td>		
		</tr>	
		<tr>
		    <td>&nbsp;</td>
		</tr>
		<tr>
		<td>
		<?php if($imagefilename!=''){?>
    	<a href="radiologyimage.php?dst=<?= $imagefilename ?>" target="_blank"><?= $imagefilename ?></a> 
		<br><br>
        <?php }?>
		<?php if($imagefilename2!=''){?>

    	<a href="radiologyimage.php?dst=<?= $imagefilename2 ?>" target="_blank"><?= $imagefilename2 ?></a>
		<br><br>
        <?php } ?>
		<?php if($imagefilename3!=''){?>
    	<a href="radiologyimage.php?dst=<?= $imagefilename3 ?>" target="_blank"><?= $imagefilename3 ?></a><br><br>
        <?php } ?>
		</td>
		</tr>
			  
		<tr id="idTRMain<?php echo $sno; ?>" <?php echo $colorcode; ?>>
 		 <td width="883"  align="left" valign="center" class="bodytext31" ><?php echo $templatedata; ?></td>
		</tr>
		
		<?php 
		$imageurl=explode(',',$filename);
		
		foreach($imageurl as $image)
		 {
		?>
		<tr>
		  <td><a href="radiologyreport.php?dst=<?php echo $image; ?>" target="_blank"><strong><?php echo $image; ?></strong></a></td>
		</tr>
	    <?php
		 }
		 ?>
		 <?php
		 }
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
			$sno = $sno + 1;
		 ?>
		 <tr>
			      <td>&nbsp;</td></tr>
				  <tr>
			      <td>&nbsp;</td></tr>
				  <tr>
			      <td><h3>Addendum:</h3></td></tr>
               
				 <?php
				 if($addendum == ''){
					 ?>
					<tr>
			      <td>
					 <textarea id="editor1"></textarea>	
						 <input type="hidden" name="getdata" id="getdata" value="">
					  </td>
			   </tr>
					<script>
						CKEDITOR.replace( 'editor1');
					</script>
					 <?php
				 }
				 else{
					 ?>
					  <tr id="idTRMain<?php echo $sno; ?>" <?php echo $colorcode; ?>>
 		 <td width="883"  align="left" valign="center" class="bodytext31" ><?php echo $addendum; ?></td>
		</tr>

					 <?php
				 }
				 ?>
				 
				
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">User Name:
               <input type="hidden" name="user" id="user" size="5" style="border: 1px solid #001E6A" value="<?php echo $_SESSION['username']; ?>" readonly><?php echo strtoupper($_SESSION['username']); ?></td>
               </tr>
			   <tr> 
              <td colspan="7" align="right" valign="top" >
                    
             	 <?php if($addendum == ''){ ?> <input name="Submit2223" type="submit" value="Save" onClick="return acknowledgevalid1();"  accesskey="b" class="button" style="border: 1px solid #001E6A"/>
				<input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
				 <?php }else { ?> <a href="radiologyresultsviewlist.php"><input name="Submit2223" type="button" value="Back" onClick="return acknowledgevalid()"  accesskey="b" class="button" style="border: 1px solid #001E6A"/></a>
				 <?php }?>
               </td>
          </tr>
		  </table>
</td>
	</tr>
  </table>   

</form>
<?php include ("includes/footer1.php"); ?>

</body>
</html>