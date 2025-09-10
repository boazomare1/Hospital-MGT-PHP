<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
$locationname  = $res["locationname"];
$locationcode = $res["locationcode"];
$res12locationanum = $res["auto_number"];

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if ($cbfrmflag1 == 'cbfrmflag1')
{
$interfacemachine = $_REQUEST['interfacemachine'];

$query342 = "select * from master_interfacemachine where auto_number='$interfacemachine'";
$exec342 = mysqli_query($GLOBALS["___mysqli_ston"], $query342) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res342 = mysqli_fetch_array($exec342);
$machineip = $res342['machineip']; 
$machinecode = $res342['machinecode']; 
$machineport = $res342['machineport']; 
$machine = $res342['machine'];

$serial = $_REQUEST['serialnumber'];
$labname=$_REQUEST['lab'];
$labname=trim($labname);
$labcode=$_REQUEST['labcode'];	
$analyserlabname = $_REQUEST['analyserlabname'];
$analyserlabcode = $_REQUEST['analyserlabcode'];
$number = $serial - 1;
//print_r($_POST);
//exit;
//master_machinelablinkingreference
$countref = count($_POST['reference']);		
	  	
if($labname!="")
{

	$query1 = "select auto_number from master_machinelablinking order by auto_number desc";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	$linkano=$res1['auto_number']+1;
	$medicinequery2="insert into master_machinelablinking (labcode,labname, machine, machineip, username, ipaddress,date,analyserlabname,analyserlabcode,machineport,machinecode,linkano)
	values ('$labcode','$labname','$machine', '$machineip','$username', '$ipaddress','$updatedatetime','$analyserlabname','$analyserlabcode','$machineport','$machinecode','$linkano')";
	
	$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	for($i=0;$i<$countref; $i++)
	{
		$refcode =$_POST['referencecode'][$i];
		$referencename =$_POST['reference'][$i];
		if($refcode!='')
		{
			$medicinequery3="insert into master_machinelablinkingreference (labcode,labname, machine, machineip, username, ipaddress,date,analyserlabname,analyserlabcode,machineport,machinecode,referencename,refcode,linkano)
		values ('$labcode','$labname','$machine', '$machineip','$username', '$ipaddress','$updatedatetime','$analyserlabname','$analyserlabcode','$machineport','$machinecode','$referencename','$refcode','$linkano')";
		
			$execquery3=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	}
}
		header("location:machineitemlinking.php");
}

?>
<?php

//include ("autocompletebuild_labanalyser.php");

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }
if($st == 'del' && $anum != '')
{
	$query22 = "delete from master_machinelablinking where linkano = '$anum'";
	$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query23 = "delete from master_machinelablinkingreference where linkano = '$anum'";
	$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
}
?>
<?php
$query23 = "select * from master_employee where username='$username'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$res7locationanum = $res23['location'];

$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res55 = mysqli_fetch_array($exec55);
$location = $res55['locationname'];

$res7storeanum = $res23['store'];

$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res75 = mysqli_fetch_array($exec75);
$store = $res75['store'];
?>
<script>
function funcOnLoadBodyFunctionCall()
{

	funcCustomerDropDownSearch1();
	
}
function btnDeleteClick10(delID)
{
	//alert ("Inside btnDeleteClick.");
	
	//alert(pharmamount);
	var varDeleteID = delID;
	//alert (varDeleteID);
	var fRet3; 
	fRet3 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet3 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child = document.getElementById('idTR'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	document.getElementById ('insertrow').removeChild(child);
	
	var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	//alert (child);
	if (child != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow').removeChild(child);
		
		
	}
	

}
</script>
<script>
function medicinecheck()
{
if(document.cbform1.interfacemachine.value=="")
	{
		alert("Please Select Interface Machine");
		document.cbform1.interfacemachine.focus();
		return false;
	}

	
	
	return true;
	
}
</script>
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
.ui-menu .ui-menu-item{ zoom:1 !important; }
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>

<?php include ("js/dropdownlist1scriptinglab1.php"); ?>
<script type="text/javascript" src="js/autocomplete_labanalyser.js"></script>
<script type="text/javascript" src="js/autosuggestlab1.js"></script> 
<script type="text/javascript" src="js/insertnewitemmachineitemlinking.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />   
<link href="autocomplete.css" rel="stylesheet">

<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script>
$(function() {
$('#lab').autocomplete({
		
	source:'ajaxlabnewserach.php', 
	//alert(source);
	minLength:3,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var code = ui.item.code;
			
			$('#labcode').val(code);
			labreference(code);
			
			},
    });
	});
	
	function labreference(code)
	{
		var dataString = 'labcode='+code;
		//alert(dataString);
		$.ajax({
			type: "POST",
			url: "lablinkreference.php",
			data: dataString,
			success: function(html){
				//alert(html);
				$("#insertreference").empty();
				$("#insertreference").append(html);
										
			}
		});
	}
	
</script>     
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.bali
{
text-align:right;
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
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
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="machineitemlinking.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
		   <tr>
              <td colspan="8" bgcolor="#ecf0f5" class="bodytext3"><strong> Machine Item Linking </strong></td>
              </tr>
            <tr>
			
              <td colspan="8" class="bodytext3"><strong> Select Interface Machine </strong>
		<select name="interfacemachine" id="interfacemachine">
		<option value="">Select</option>
		<?php
		$query24 = "select * from master_interfacemachine where recordstatus = ''";
		$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res24 = mysqli_fetch_array($exec24))
		{
		$machine = $res24['machine'];
		$machineanum = $res24['auto_number'];
		?>
		<option value="<?php echo $machineanum; ?>"><?php echo $machine; ?></option>
		<?php
		}
		?>
		</select>
                </td>
			   </tr>
          
           
	  <tr id="pressid">
				   <td colspan="15" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				   <table id="presid" width="500" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="211" class="bodytext3"><strong>Lab Item</strong></td>
                       <td width="211" class="bodytext3"><strong>Analyser Labname</strong></td>
                       <td width="211" class="bodytext3"><strong>Analyser Labcode</strong></td>
					   <td align="left">&nbsp;</td>
                     </tr>
					 
					 <tbody id="insertrow">					 </tbody>
                     <tr>
					 <td>
					  <input name="lab" type="text" id="lab" size="35">
						 <input type="hidden" name="labcode" id="labcode" value="">
			 			 <input type="hidden" name="serialnumber" id="serialnumber" value="1">
						</td>
						<td> <input name="analyserlabname" type="text" id="analyserlabname" size="35"></td>
						<td> <input name="analyserlabcode" type="text" id="analyserlabcode" size="15"></td>
						<td width="224"><label>
                       <input type="hidden" name="Add" id="Add" value="Add" onClick="return insertitem10()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
                     <tbody id="insertreference">					 </tbody>
                     
					 <input type="hidden" name="h" id="h" value="0">
                   </table>				  </td>
			       </tr>
				    <tr>
              <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
              <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
              <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
              <td colspan="2" align="left" valign="middle" class="bodytext3">&nbsp;</td>
              <td width="1%" align="left" valign="top">			              </td>
            </tr>
			   <tr>
              <td align="left" valign="middle" class="bodytext3"></td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  style="border: 1px solid #001E6A" type="submit" value="Save" name="Submit" onClick="return medicinecheck();"/>                 </td>
            </tr>
			 <tr bgcolor="#011E6A">
                        <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Machine Item Linking - Existing List </strong></td>
                      </tr>
                      <tr>
                        <td width="9%" align="left" valign="top" bgcolor="#FFFFFF"  class="bodytext3"><strong>Delete</strong></td>
                        <td width="27%" align="left" valign="top" bgcolor="#FFFFFF"  class="bodytext3"><strong>Lab Name </strong></td>
						<td width="32%" align="left" valign="top" bgcolor="#FFFFFF"  class="bodytext3"><strong>Analyser Labname</strong></td>
                        <td width="30%" align="left" valign="top" bgcolor="#FFFFFF"  class="bodytext3"><strong>Analyser Labcode</strong></td>
                      </tr>
                      <?php
					  $colorloopcount = '';
					  $query6 = "select machinecode,machine from master_machinelablinking where recordstatus <> 'deleted' group by machinecode";
					  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
					while ($res6 = mysqli_fetch_array($exec6))
					{
					$machinecode = $res6['machinecode'];
					$machine1 = $res6['machine'];
					?>
					<tr>
					<td colspan="4" align="left" valign="top"  class="bodytext3" bgcolor="#00CCCC"><strong><?php echo $machine1; ?></strong> </td>
					</tr>
					<?php
					$query1 = "select * from master_machinelablinking where machinecode = '$machinecode' and recordstatus <> 'deleted' order by machine";
					$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
					while ($res1 = mysqli_fetch_array($exec1))
					{
					$machine = $res1['machine'];
					$labname = $res1['labname'];
					$alabname = $res1['analyserlabname'];
					$alabcode = $res1['analyserlabcode'];
					$auto_number = $res1['auto_number'];
					$linkano = $res1['linkano'];
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
					<td align="left" valign="top"  class="bodytext3">
					<a href="machineitemlinking.php?st=del&&anum=<?php echo $linkano; ?>">
					<img src="images/b_drop.png" width="16" height="16" border="0" /></a></td>
					<td align="left" valign="top"  class="bodytext3"><?php echo $labname; ?> </td>
					<td align="left" valign="top"  class="bodytext3"><?php echo $alabname; ?> </td>
					<td align="left" valign="top"  class="bodytext3"><?php echo $alabcode; ?> </td>
					</tr>
                     <?php
					}
					}
					?>
                      <tr>
                        <td align="middle" colspan="2" >&nbsp;</td>
                      </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      
	  
	  </form>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

