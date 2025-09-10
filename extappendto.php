<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$username = $_SESSION['username'];
//$patientcode = $_REQUEST["patientcode"];
//$visitcode = $_REQUEST["visitcode"];
$templatecode = $_REQUEST["tid"];
$itemcode = $_REQUEST["itemcode"];
$docnumber = $_REQUEST["docnum"];
$billno = $_REQUEST["billnum"];   

$query7="select * from consultation_radiology where patientcode='walkin' and patientvisitcode='walkinvis' and billnumber = '$billno'";
$exec7=mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res7=mysqli_fetch_array($exec7);
$res7patientname=$res7['patientname'];
//$res7patientage=$res7['age'];
//$res7patientgender=$res7['gender'];
$res7billtype = $res7['billtype'];

$query66="select * from billing_external where billno='$billno'";
$exec66=mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res66=mysqli_fetch_array($exec66);
$res7patientage=$res66['age'];
$res7patientgender=$res66['gender'];

$query98="select * from master_radiology where itemcode='$itemcode'";
$exec98=mysqli_query($GLOBALS["___mysqli_ston"], $query98);
$res98=mysqli_fetch_array($exec98);
$res98itemname = $res98['itemname'];

?>

<script>
function acknowledgevalid() 
 {
 window.close();
 }
 
function toredirect()
{ 
var content = CKEDITOR.instances.editor1.getData();

document.getElementById("getdata").value = content;

//alert(content);
}
</script>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/script.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css">

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

.ckeditor {display:none;}
</style>
<script type="text/javascript" src="ckeditor1/ckeditor.js"></script>

  
			  
<?php
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }

if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{   
$patientcode = 'walkin';
$visitcode = 'walkinvis';
$templatecode = $_REQUEST["templatecode"];
$itemcode = $_REQUEST["itemcode"];
$docnumber = $_REQUEST["docnumber"];
$getdata = $_REQUEST["getdata"];
$getitemname = $_REQUEST["itemname"];
$billnumber = $_REQUEST['billnumber'];


$query61 = "select * from consultation_radiology where patientcode = '$patientcode' and billnumber='$billnumber' and patientvisitcode = '$visitcode' and resultentry='pending' group by radiologyitemname";
$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query61".mysqli_error($GLOBALS["___mysqli_ston"]));
$numb=mysqli_num_rows($exec61);
$res61 = mysqli_fetch_array($exec61);
$radiologyname =$res61["radiologyitemname"];
$billtype = $res61['billtype'];
$accountname = $res61['accountname'];
$patientname = $res61['patientname'];
$acknowledge = 'completed';

$query68="select * from master_radiology where itemname='$radiologyname'";
$exec68=mysqli_query($GLOBALS["___mysqli_ston"], $query68);
$res68=mysqli_fetch_array($exec68);

if($radiologyname != "")
   {
  
   $query26="insert into resultentry_radiology(patientname,patientcode,patientvisitcode,recorddate,itemcode,itemname,acknowledge,refund,billnumber,username,templatedata,docnumber)values('$patientname','walkin',
   'walkinvis','$dateonly','$itemcode','$radiologyname','$acknowledge','$status1','$billnumber','$username','$getdata','$docnumber')";
   $exec26=mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  
		   $filename='';
			$fileurl='';
			
			for ($i = 0; $i < count($_FILES['file']['name']); $i++) 
			{   //loop to get individual element from the array
				$file_name=$_FILES['file']['name'][$i];
				 
				 if($filename=='')
				 {
				 $filename = $file_name;
				 }
				 else
				 {
				 $filename = $filename.','.$file_name;
				 }
			}
			
			$fileurl = 'radiologyimages/'.$filename;
			
			$query76 = "update resultentry_radiology set filename= '$filename', fileurl='$fileurl' WHERE patientcode = '$patientcode' and patientvisitcode = '$visitcode' and docnumber = '$docnumber'";
			$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

      }
echo '<script type="text/javascript"> acknowledgevalid();  </script>';
}
?>
</head>

<body>
<form name="frmsales" id="frmsales" method="post" FORM ENCTYPE="multipart/form-data" action="extappendto.php" onKeyDown="return disableEnterKey(event)" onSubmit="return toredirect();">
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
		
		<tr>
			<td align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo 'red'; } ?>" class="bodytext3"><strong><?php echo $errmsg;?>&nbsp;</strong></td>
		</tr>
		<tr>
			<td colspan="3" align="left" valign="middle"  class="bodytext3"><strong>Add</strong></td>
		</tr>	
		<table width="1150" border="0" cellspacing="0" cellpadding="0">
				<?php
				$query78="select * from master_radiologytemplate where auto_number='$templatecode' ";
				$exec78=mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res78=mysqli_fetch_array($exec78);
				$templatedata=$res78['templatedata'];
				?>
			<tr>
			
				<td colspan="2">
				    <input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
					 <input type="hidden" name="visitcode" value="<?php echo $visitcode; ?>">
					  <input type="hidden" name="templatecode" value="<?php echo $templatecode; ?>">
					   <input type="hidden" name="itemcode" value="<?php echo $itemcode; ?>">
					    <input type="hidden" name="docnumber" value="<?php echo $docnumber; ?>">
						 <input type="hidden" name="getdata" id="getdata" value="">
						  <input type="hidden" name="itemname" id="itemname" value="<?php echo $res98itemname; ?>">
						  <input type="hidden" name="billnumber" id="billnumber" value="<?php echo $billno; ?>">
						 
						
						  
					<textarea id="editor1">
					<strong><?php echo $sno; echo "Patient: ".$res7patientname; ?> <?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Age: ".$res7patientage; ?>  <?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Gender: ".$res7patientgender; ?></strong><br/>
					<?php echo $templatedata; ?><br/>
					<?php echo "<pre>Sonographer: ".strtoupper($username); ?>
					<?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sign:............</pre>"; ?>
		            </textarea>		
				
					<script>
						CKEDITOR.replace( 'editor1',
						null,
						''
						);
					</script>
						
				</td>
			</tr>	
		    <tr>
			   <td>&nbsp;</td>
			 </tr>  
			<tr>
			
				<td colspan="2" width="54%" align="right" valign="top" >
				<div id="formdiv">
						<div id="filediv">
						Save image link: <input name="file[]" type="file" id="file" accept=".jpeg,.jpg" />
						</div><br/>
						<input type="button" id="add_more" class="upload" value="Add More Files"/>
						<br /><br />
						<input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1" ons>
				        <input name="Submit2223" type="submit" value="Save "  accesskey="b" class="button" style="border: 1px solid #001E6A"/>
						</div>
				       </div>
				</td>
			</tr>
		</table>
	</table>
</form>



			  
		
