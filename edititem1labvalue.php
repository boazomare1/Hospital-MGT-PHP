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


if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
	$itemcode = $_REQUEST['itemcode'];
	$itemname = $_REQUEST['itemname'];
	
	$query76 = "delete from labanalyzervalues where itemcode = '$itemcode' and itemname = '$itemname'";
	$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die ("Error in Query76".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	for($i=1;$i<=50;$i++)
	{
		$refanum = $_REQUEST['refanum'.$i];
		$refname = $_REQUEST['refname'.$i];
		$refvalue = $_REQUEST['refvalue'.$refanum];
		
		foreach($refvalue as $ref)
		{
			$query78 = "insert into labanalyzervalues (itemcode, itemname, refanum, referencename, resultvalue, username, ipaddress, updatedatetime)
			values('$itemcode', '$itemname', '$refanum', '$refname', '$ref', '$username', '$ipaddress', '$updatedatetime')";
			$exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die ("Error in Query78".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	}
	
	header("location:labanalyzervalue.php");
}

?>

<?php
if (isset($_REQUEST["itemcode"])) { $itemcode = $_REQUEST["itemcode"]; } else { $itemcode = ""; }
		
	$query67 = "select * from master_lab where itemcode='$itemcode'";
	$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res67 = mysqli_fetch_array($exec67);
	$itemname = $res67['itemname'];
	$rate1 = $res67['rateperunit'];
	$rate2 = $res67['rate2'];
	$rate3 = $res67['rate3'];
	$ipmarkup = $res67['ipmarkup'];
	$location = $res67['location'];
	$sampletype = $res67['sampletype'];
    $unit = $res67['itemname_abbreviation'];
	$category= $res67['categoryname'];
	$taxanum = $res67['taxanum'];
	$referencevalue = $res67['referencevalue'];
	$taxname= $res67['taxname'];
	$displayname = $res67['displayname'];
	$externallab = $res67['externallab'];
	$exclude = $res67['exclude'];
	$pkg1 = $res67['pkg'];
	$description = $res67['description'];
?>
<script>

function coasearch(varCallFrom,itemcode,reference)
{
	var varCallFrom = varCallFrom;
	var itemcode = itemcode;
	var reference = reference;
	window.open("labreference.php?callfrom="+varCallFrom+"&&itemcode="+itemcode+"&&reference="+reference,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
</script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
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
</style>
<script type="text/javascript">
function Addvalue(id)
{
	var Refvalue = document.getElementById('analyzevalue'+id).value;
	var Refanum = document.getElementById('refanum'+id).value;
	var Ser = document.getElementById('ser'+id).value;
	//alert(id);
	if(Refvalue == "")
	{
		alert("Enter Values");
		return false;
	}
	var tr = document.createElement ('TR');
	tr.id = "idTR"+id+Ser+"";
	
	//var td1 = document.createElement ('<td id="idTD1'+i+'" align="left" valign="top" bordercolor="#F3F3F3" bgcolor="#FFFFFF" class="bodytext3"></td>');
	var td1 = document.createElement ('td');
	td1.id = "refvalue"+Refanum+"";
	//td1.align = "left";
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	//var text1 = document.createElement ('<input name="serialnumber'+i+'" value="'+i+'" id="serialnumber'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="1" />');
	var text1 = document.createElement ('input');
	text1.id = "refvalue"+Refanum+"[]";
	text1.name = "refvalue"+Refanum+"[]";
	text1.type = "text";
	text1.size = "20";
	text1.value = Refvalue;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);
	
	var text11 = document.createElement ('input');
	text11.id = "btndelete"+i+"";
	text11.name = "btndelete"+i+"";
	text11.type = "button";
	text11.value = "Del";
	text11.style.border = "1px solid #001E6A";
	text11.onclick = function() { return btnDeleteClick10(id+"|"+Ser); }
	//td10.appendChild (text10);
	td1.appendChild (text11);
	tr.appendChild (td1);

    document.getElementById ('foo'+id).appendChild (tr);
	
	document.getElementById('ser'+id).value = parseFloat(Ser) + 1;
	var Refvalue = document.getElementById('analyzevalue'+id).value = "";
}

function btnDeleteClick10(delID)
{
	//alert ("Inside btnDeleteClick.");
	var varDeleteID = delID;
	//alert (varDeleteID);
	var spp = varDeleteID.split('|');
	var id = spp[0];
	var anum = spp[1];
	var fRet3; 
	fRet3 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet3 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child = document.getElementById('idTR'+id+anum);  //tr name
	
    var parent = document.getElementById('foo'+id); // tbody name.
	
	//alert (child);
	if (child != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('foo'+id).removeChild(child);		
	}
}
</script>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body>
<form name="frm" id="frmsales" method="post" action="edititem1labvalue.php">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
 <tr>
    <td colspan="10">&nbsp;</td>
  </tr>

  <tr>
    <td width="0%">&nbsp;</td>
    <td width="88%" valign="top">
	<table width="619" border="0" cellspacing="4" cellpadding="4">
	<tr bgcolor="#999999">
	<td colspan="10" width="10%" class="bodytext3" valign="center"  align="left"><strong>Lab Test Anlyzer Values</strong></td>
	</tr>
   	<tr>
	<td width="10%" class="bodytext3" valign="center"  align="left"><div align="left"><strong>Test Name</strong></div></td>
	<td width="90%"  align="left" valign="center" 
	class="bodytext366"><strong><input type="text" name="itemname" size="40" value="<?php echo $itemname; ?>" readonly />
	<input type="hidden" name="itemcode" size="40" value="<?php echo $itemcode; ?>" readonly />  </strong></td>
	</tr>
	<tr bgcolor="#ecf0f5">
	<td colspan="10" width="10%" class="bodytext3" valign="center"  align="left"><strong>References</strong></td>
	</tr>
				  <?php
				$colorloopcount = 0;
			  $query52="select * from master_labreference where itemname='$itemname' and itemcode='$itemcode' and status <> 'deleted' order by reforder"; 
			   $exec52=mysqli_query($GLOBALS["___mysqli_ston"], $query52);
			   $num1=mysqli_num_rows($exec52);
			   while($res52=mysqli_fetch_array($exec52))
			   {
			   $refanum = $res52['auto_number'];
			   $labname2=$res52['itemname'];
			   $itemcode2=$res52['itemcode'];
				$labunit1=$res52['itemname_abbreviation'];
				$labreferenceunit = $res52['referenceunit'];
				$labreferencename = $res52['referencename'];
				
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
				<td colspan="10" width="10%" class="bodytext3" valign="center"  align="left"><strong><?php echo $labreferencename; ?>
				<input type="hidden" name="refanum<?php echo $colorloopcount; ?>" id="refanum<?php echo $colorloopcount; ?>" value="<?php echo $refanum; ?>" />
				<input type="hidden" name="refname<?php echo $colorloopcount; ?>" id="refname<?php echo $colorloopcount; ?>" value="<?php echo $labreferencename; ?>" /></strong></td>
				</tr>
				<tr>
				<td colspan="10" width="88%" valign="top">
				<table width="508" border="0" cellspacing="4" cellpadding="4">
				<tr bgcolor="#ecf0f5">
				<td colspan="10" width="10%" class="bodytext3" valign="center"  align="left"><strong> Anlyzer Values</strong></td>
				</tr>
				<tbody id="foo<?php echo $colorloopcount; ?>">
				<?php include("lab_reflisting.php"); ?>
				</tbody>
				<tr bgcolor="#ecf0f5">
				<td colspan="10" width="10%" class="bodytext3" valign="center"  align="left"><strong>
				<input type="hidden" name="ser<?php echo $colorloopcount; ?>" id="ser<?php echo $colorloopcount; ?>" value="<?php echo $sno; ?>" size="1">
				<input type="text" name="analyzevalue<?php echo $colorloopcount; ?>" id="analyzevalue<?php echo $colorloopcount; ?>" size="20">
				<input type="button" name="Add" value="Add" onClick="return Addvalue('<?php echo $colorloopcount; ?>')"></strong></td>
				</tr>
				</table>
				</td>
				</tr>
				  <?php	
				  }
				  ?>
		 
				  
				  
			<script language="javascript">
			//alert ("Inside JS");
			//To Hide idTRSub rows this code is not given inside function. This needs to run after rows are completed.
			for (i=1;i<=100;i++)
			{
				if (document.getElementById("idTRSub"+i+"") != null) 
				{
					document.getElementById("idTRSub"+i+"").style.display = 'none';
				}
			}
			
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
			
			function funcShowDetailHide(varSerialNumber)
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
			}
			</script>	
			   <tr> 
              <td colspan="7" align="right" valign="top" >
                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
                     <input name="Submit2223" type="submit" value="Save " onClick="return acknowledgevalid()"  accesskey="b" class="button"/>
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
