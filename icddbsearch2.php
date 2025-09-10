<?php
include ("db/db_connect.php");

$searchdisease2 = $_REQUEST['searchdisease1'];
$dept = $_REQUEST['dept'];
$searchexplode = explode('/',$searchdisease2);
$stringbuild1 = "";
$tdbuild = "";
$sno = 0;
$id = 0;
$searchstring = '';
?>
<style>
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
</style>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script type="text/javascript">
function IcdSearch(id)
{
	var Icdcode = document.getElementById('icdcode'+id).value;
	var Icd = document.getElementById('icd'+id).value;
	var Chapter = document.getElementById('chapter'+id).value;
	var Anum = document.getElementById('anum'+id).value;
	//alert(Anum);
	window.opener.document.getElementById('dis').value = Icd;
	window.opener.document.getElementById('code').value = Icdcode;
	window.opener.document.getElementById('diseas').value = Icd;
	window.opener.document.getElementById('chapter').value = Chapter;
	
	window.opener.insertitem13();
	
	var Formdata = "icdcode="+Icdcode+"&&anum="+Anum+"&&icdname="+Icd;
	
	$.ajax({
			type  :   "POST",  
			url   :   "favouriteicd1.php", 
			data  :   Formdata,
			success: function(result){ 
				window.close();
			}
	});
	
	window.close();
}

$(document).ready(function(e) {
    // $("#searchdisease1").focus();
    $("#searchdisease1").focus();
var tmpStr = $("#searchdisease1").val();
$("#searchdisease1").val('');
$("#searchdisease1").val(tmpStr);
});

</script>
<form method="get" action="">
<table border="1" width="100%" cellpadding="5" cellspacing="5" style="border-collapse:collapse;">
<tr bgcolor="#CCC">
<td colspan="1" align="left" class="bodytext3"><strong>ICD Search</strong></td>
<td colspan="2" align="left" class="bodytext3"><strong>Search Tips : Use / to search multiple words</strong></td>
</tr>
<tr>
<td width="159" align="right" class="bodytext3"><strong>Search :</strong></td>
<td width="144" align="left" class="bodytext3"><input type="text" size="35" name="searchdisease1" id="searchdisease1" value="<?php echo $searchdisease2; ?>" onfocus="this.value = this.value;"/></td>
<td width="992" align="left" class="bodytext3"><input type="hidden" name="dept" id="dept" value="<?php echo $dept; ?>" />
<input type="submit" name="Search" value="Search" />
</td>
</tr>
</table>
</form>
<table border="1" width="100%" cellpadding="5" cellspacing="5" style="border-collapse:collapse;">
<?php
foreach($searchexplode as $searchdisease1)
{
	 $searchdisease1 = trim($searchdisease1);
	if($searchstring == "")
	{
		 $searchstring = "description like '%$searchdisease1%'";
	}
	else
	{
		 $searchstring = $searchstring.' and '."description like '%$searchdisease1%'";
	}
	$colorcode = '#FF0000';
}
	 $query2 = "SELECT auto_number,disease,icdcode,chapter,description from master_icd where ($searchstring) and recordstatus = 'active' order by auto_number";// order by subtype limit 0, 15";
	// echo $query2 = "SELECT auto_number,disease,icdcode,chapter,description from master_icd where disease like '%$searchdisease1%' and ($searchstring) and recordstatus = 'active' order by auto_number";// order by subtype limit 0, 15";
		

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res2 = mysqli_fetch_array($exec2))
	{
		$id = $id + 1;
		$res2anum = $res2['auto_number'];
		$res2disease = $res2['disease'];
		$res2icdcode = $res2['icdcode'];
		$res2chapter = $res2['chapter'];
		$res2description = $res2['description'];
		$res2disease = addslashes($res2disease);
		$res2disease = strtoupper($res2disease);
		$res2disease = trim($res2disease);
		$res2disease = preg_replace('/,/', ' ', $res2disease); // To avoid comma from passing on to ajax url.
		$res2description = preg_replace('/,/', ' ', $res2description); // To avoid comma from passing on to ajax url.
		
		$searchexp = explode('/',$searchdisease2);
		$str = $res2description;
		foreach($searchexp as $exp)
		{
		$keyword = $exp;
		$keyword = trim($keyword);
		if($keyword != ''){
		$str = preg_replace("/($keyword)/i","<b><span style='color:$colorcode;'>$1</span></b>",$str); }
		}
		?>
		<tr id="<?php echo $id; ?>" onmouseover="javascript:this.bgColor='#00FF33';" onmouseout="javascript:this.bgColor='#FFF';" onclick="return IcdSearch(this.id)">
		<td width="32%" align="left" class="bodytext3"><?php echo strtoupper($res2disease); ?></td>
		<td width="54%" align="left" class="bodytext3">
		<input type="hidden" name="anum<?php echo $id; ?>" id="anum<?php echo $id; ?>" value="<?php echo $res2anum; ?>" />
		<input type="hidden" name="chapter<?php echo $id; ?>" id="chapter<?php echo $id; ?>" value="<?php echo $res2chapter; ?>" />
		<input type="hidden" name="icd<?php echo $id; ?>" id="icd<?php echo $id; ?>" value="<?php echo $res2description; ?>" /><?php echo strtoupper($str); ?></td>
		<td width="14%" align="left" class="bodytext3"><input type="hidden" name="icdcode<?php echo $id; ?>" id="icdcode<?php echo $id; ?>" value="<?php echo $res2icdcode; ?>" /><?php echo $res2icdcode; ?></td>
		</tr>
		<?php
	}
?>
</table>	