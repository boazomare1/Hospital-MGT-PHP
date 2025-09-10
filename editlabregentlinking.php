<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if ($cbfrmflag1 == 'cbfrmflag1')
{
$medicinename = $_REQUEST['medicinename'];
$locationcode = $_REQUEST['locationcode'];
$medicinecode = $_REQUEST['medicinecode'];
$serial = $_REQUEST['serialnumber'];
$number = $serial - 1;

$query78 = "update master_labregentlinking set recordstatus='deleted' where itemcode='$medicinecode'";
$exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));


for ($p=1;$p<=$number;$p++)
		{
				   
		 $labname=$_REQUEST['labname'.$p];
		$labname=trim($labname);
		$labcode=$_REQUEST['labcode'.$p];
			
		$quantity=$_REQUEST['quantity'.$p];
		
	  	
		if($labname!="")
		{
		
	$medicinequery2="insert into master_labregentlinking (labcode,labname, itemcode, itemname, quantity,username, ipaddress,date)
	values ('$labcode','$labname','$medicinecode', '$medicinename','$quantity','$username', '$ipaddress','$updatedatetime')";
	
	$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}
		}
foreach($_POST['itemname'] as $key => $value)
		{
				   
		 $itemname=$_POST['itemname'][$key];
		$itemname=trim($itemname);
		$itemcode=$_POST['itemcode'][$key];
			
		$quantity=$_POST['itemquantity'][$key];
		
	  	
		if($itemname!="")
		{
		
	$medicinequery2="insert into master_labregentlinking (labcode,labname, itemcode, itemname, quantity,username, ipaddress,date)
	values ('$itemcode','$itemname','$medicinecode', '$medicinename','$quantity','$username', '$ipaddress','$updatedatetime')";
	
	$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
		}
		
		
		header("location:labregentlinking.php");
		exit;
}

if (isset($_REQUEST["code"])) { $code = $_REQUEST["code"]; } else { $code = ""; }
$locationcode = isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
?>
<?php

include ("autocompletebuild_lab1.php");
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
$locationcode = $res55['locationcode'];

$res7storeanum = $res23['store'];

$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res75 = mysqli_fetch_array($exec75);
$store = $res75['store'];

$query31 = "select * from master_labregentlinking where itemcode = '$code' group by itemcode";
$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res31 = mysqli_fetch_array($exec31);
$itemnames = $res31['itemname'];
?>
<script>
function funcOnLoadBodyFunctionCall()
{

	funcCustomerDropDownSearch4();
	funcCustomerDropDownSearch1();
	
	
}
function btnDeleteClick10(delID)
{
	//alert ("Inside btnDeleteClick.");
	
	//alert(pharmamount);
	var varDeleteID = delID;
	
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
function validcheck()
{
	
if(confirm("Do You Want To Save The Record?")==false){return false;}		
}

function medicinecheck()
{
if(document.cbform1.tostore.value=="")
	{
		alert("Please Select the store");
		document.cbform1.tostore.focus();
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
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>


<?php include ("js/dropdownlist1scriptinglab1.php"); ?>
<script type="text/javascript" src="js/autocomplete_lab1.js"></script>
<script type="text/javascript" src="js/autosuggestlab1.js"></script> 

<?php include ("js/dropdownlist1scriptingrequestmedicine.php"); ?>
<script type="text/javascript" src="js/autosuggestrequestmedicine.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_requestmedicine.js"></script>

<script type="text/javascript" src="js/insertnewitemlabregentlinking.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
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

<body onLoad="return funcOnLoadBodyFunctionCall();">
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
		
		
              <form name="cbform1" method="post" action="editlabregentlinking.php" onSubmit="return validcheck()">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
		   <tr>
              <td colspan="8" bgcolor="#ecf0f5" class="bodytext3"><strong>Edit Lab Regent Linking </strong></td>
              </tr>
            <tr>
              <td colspan="2" class="bodytext3"><strong> Select Item </strong></td>
			   <td colspan="6" class="bodytext3"> <input type="hidden" name="serialnumber" id="serialnumber" value="1">
					  <input type="hidden" name="medicinecode" id="medicinecode" value="<?php echo $code ?>">
                        <input name="medicinename" type="text" id="medicinename" size="69" autocomplete="off" onKeyDown="return StateSuggestionspharm4()" onKeyUp="return funcCustomerDropDownSearch4()" value="<?php echo $itemnames; ?>">
						  <input name="searchmedicinename1hiddentextbox" id="searchmedicinename1hiddentextbox" type="hidden" value="">
			  <input name="searchmedicineanum1" id="searchmedicineanum1" value="" type="hidden">
              </tr>
          
           
	  <tr id="pressid">
				   <td colspan="15" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				   <table id="presid" width="500" border="0" cellspacing="1" cellpadding="1">
				   <tbody id="insertrow">
                     <tr>
                       <td class="bodytext3">Lab</td>
                       <td class="bodytext3">Qty</td>
                     
                     </tr>
					 <?php
				$itemcount = "";
				//To populate items already in the bill if in edit mode.
				$query23 = "select * from master_labregentlinking where itemcode = '$code' and recordstatus <> 'deleted'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($res23 = mysqli_fetch_array($exec23))
{
$itemcount = $itemcount + 1;
$itemcode = $res23['labcode'];
$itemname = $res23['labname'];
$itemname = htmlentities($itemname);
$quantity = $res23['quantity'];

?>
<TR id="idTR<?php echo $itemcount; ?>">
<td id="idTD1<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">
<input name="itemname[]" value="<?php echo $itemname; ?>" id="serialnumber<?php echo $itemcount; ?>" readonly style="border: 0px solid #001E6A; text-align:left" size="60" />
 <input type="hidden" name="itemcode[]" id="itemcode<?php echo $itemcount; ?>" value="<?php echo $itemcode; ?>">
</td>
<td id="idTD2<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">
<input name="itemquantity[]" value="<?php echo $quantity; ?>" id="itemcode<?php echo $itemcount; ?>" style="border: 0px solid #001E6A; text-align:left" size="5" readonly />
</td>

<td id="idTD3<?php echo $itemcount; ?>" align="right" valign="top"  bgcolor="#FFFFFF" class="bodytext3">
<!--<input onClick="return btnFreeClick(<?php echo $itemcount; ?>)" name="btnfree<?php echo $itemcount; ?>" id="btnfree<?php echo $itemcount; ?>" type="hidden" value="Free" class="button" style="border: 1px solid #001E6A"/>-->
<input onClick="return btnDeleteClick10(<?php echo $itemcount; ?>)" name="btndelete<?php echo $itemcount; ?>" id="btndelete<?php echo $itemcount; ?>" type="button" value="Del" class="button" style="border: 1px solid #001E6A"/>
</td>
</TR>
<?php }

				//value to initiate serial number if in edit mode.
				$itemcount = $itemcount;
				?>
				</tbody>
				</table>
					<tr>
				<td colspan="11" bgcolor="#ecf0f5" class="bodytext3">
				 <table border="0" cellspacing="1" cellpadding="1">
				 <tbody>
                     <tr>
					  
                        <td><input name="lab" type="text" id="lab" size="35" autocomplete="off">
			    <input type="hidden" name="labcode" id="labcode" value="">
			    <input name="rate5[]" type="hidden" id="rate5" readonly size="8"></td>
								   
			
						<td><input type="text" name="quantity" id="quantity" size="8" /></td>
						<input name="avlquantity" type="hidden" id="avlquantity" size="8">
                        <input name="locationcode" type="hidden" id="locationcode" size="8">
						
						
						<td width="224"><label>
                       <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem10()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
                     
					 <input type="hidden" name="h" id="h" value="0">
					 </tbody>
                   </table>				  </td>
			       </tr>
				    <tr>
              <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
              <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
              <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
              <td colspan="2" align="left" valign="middle" class="bodytext3">&nbsp;</td>
              <td align="left" valign="top">			              </td>
            </tr>
			   <tr>
              <td align="left" valign="middle" class="bodytext3"></td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  style="border: 1px solid #001E6A" type="submit" value="Save" name="Submit" onClick="return medicinecheck();"/>                 </td>
            </tr>
			 
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
      
	  
	 
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

