<?php
session_start();
//include ("includes/loginverify.php");
include ("db/db_connect.php");

$updatedatetime = date("Y-m-d H:i:s");
$username = $_SESSION["username"];
if (isset($_REQUEST["id"])) { $id = $_REQUEST["id"]; } else { $id = ""; }
if (isset($_REQUEST["frm"])) { $frm = $_REQUEST["frm"]; } else { $frm = ""; }


if(isset($_REQUEST["cnfform"]) && $_REQUEST["cnfform"]=='cnfform' && $_REQUEST["id"]!=''){
$frm = $_REQUEST["frm"];
$id = $_REQUEST["id"];
$doctnotes=addslashes($_REQUEST["doctnotes"]);
$st = 0;

if($frm=='pre')
	$doc_note='doctor_note';
elseif($frm=='intra')
	$doc_note='intra_doctor_notes';
elseif($frm=='post')
   $doc_note='post_doctor_notes';

	
			 $chkSql = "select * from master_theatre_booking where auto_number ='".$id."' and approvalstatus != 'Closed'";
			 $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $chkSql) or die ("Error in chkSql".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $numSup = mysqli_num_rows($exec1);
			 if($numSup>0){ 

				$query_theatre = "UPDATE master_theatre_booking SET $doc_note='$doctnotes' WHERE auto_number = '$id'";
			    $exec_theatre = mysqli_query($GLOBALS["___mysqli_ston"], $query_theatre) or die ("Error in query_theatre".mysqli_error($GLOBALS["___mysqli_ston"]));

				 $st = 1;
			 }else
	         {
				 $st=2;
			 }
		
        header("location:popup_doctornotes.php?frm=$frm&id=$id&st=$st");
		exit;

}


if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
$errmsg ='';
if ($st == '1')
{
	$errmsg = "Success.  Insert Completed.";
}
elseif ($st == '2')
{
	$errmsg = "Faild.  Please check later.";
}

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />  
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<link href="js/jquery-ui.css" rel="stylesheet">

<script language="javascript">


function validatenumerics(key) {
   var keycode = (key.which) ? key.which : key.keyCode;
   if (keycode != 46 && keycode > 31 && (keycode < 48 || keycode > 57)) {
	   return false;
   }
   else return true;
}


function valid(){


	if (document.form1.doctnotes.value == "")
	{
		alert ("Pleae Enter the notes.");
		document.form1.doctnotes.focus();
		return false;
	}

	var r = confirm("Do you want Save?");
	if (r == true) {
	  return true;
	}else
      return false;
}

</script>

<body >
<form name='form1' id='form1' action='popup_doctornotes.php?frm=<?php echo $frm;?>&id=<?php echo $id;?>' method='post' onsubmit="return valid();">

<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
    <tbody>
	<?php
	if($id!='' && ($frm=='pre' || $frm=='intra' || $frm=='post')){
	$query1 = "select * from master_theatre_booking where auto_number ='".$id."' and approvalstatus != 'Closed' ";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$numLab = mysqli_num_rows($exec1);
	if($numLab>0){ 
	$res1 = mysqli_fetch_array($exec1);

	if($frm=='pre')
		$doc_note=$res1['doctor_note'];
	elseif($frm=='intra')
		$doc_note=$res1['intra_doctor_notes'];
	elseif($frm=='post')
		$doc_note=$res1['post_doctor_notes'];
       
	?>
	  <?php if ($errmsg != '') { ?>
		 <tr>
			<td  align="center" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#ecf0f5'; } ?>" class="bodytext3"><?php echo $errmsg;?></td>
			
		  </tr>
		<?php } ?>
      <tr bgcolor="#011E6A">
        <td  bgcolor="#ecf0f5" class="bodytext3"><strong><?php echo ucfirst($frm);?> Doctor Notes "<?php echo $res1['patientname'];?>(<?php echo $res1['patientvisitcode'];?>)"</strong></td>
      </tr>
      <tr>
        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">
		
		<textarea rows="5" cols="30" name="doctnotes" id="doctnotes"><?php echo stripslashes($doc_note); ?></textarea>

      </tr>
	  <tr >
		<td>
		  <table cellpadding="4" cellspacing="0" id="insertrow1" bordercolor="#666666" border='0'  >
		  </table>
		</td>
	  </tr>
	  <tr >
		<td  align='center'>
		  <input type='hidden' name="id" id="id"  value='<?php echo $id;?>' />
		  <input type='hidden' name="frm" id="frm"  value='<?php echo $frm;?>' />

		  <input type='hidden' name="cnfform" id="cnfform" value='cnfform' />
		  <input type='submit' name='save' id='save' value='Save' >
		  
		</td>
	  </tr>
	  <tr >
		<td>
		 &nbsp;
		</td>
	  </tr>

	  <?php } else { ?>

	  <tr >
        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3" style='red' align='center'><strong>Invalid code.</strong></td>
      </tr>

	  <?php }
      }else {  ?>
       <tr >
        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3" style='red' align='center'><strong>Invalid access.</strong></td>
      </tr>
      <?php
	  }
	  ?>
    </tbody>
</table>
</form>

</body>
