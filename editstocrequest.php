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

$docno=$_REQUEST['docnumber'];
$serial = $_REQUEST['serialnumber'];
$remarks = $_REQUEST['remarks'];
$fromstore = $_REQUEST['fromstore'];
$tostore = $_REQUEST['tostore'];
$number = $serial - 1;

for ($p=1;$p<=$number;$p++)
		{
				   
		$medicinename=$_REQUEST['medicinename'.$p];
		$medicinename=trim($medicinename);
		$medicinecode=$_REQUEST['medicinecode'.$p];
		
		/*$query77="select * from master_medicine where itemname='$medicinename'";
			$exec77=mysql_query($query77);
			$num77=mysql_num_rows($exec77);
			//echo $num77;
			$res77=mysql_fetch_array($exec77);
			$medicinecode=$res77['itemcode'];*/
		
		//echo $medicinecode;
		
		
		$avlquantity=$_REQUEST['avlquantity'.$p];
		
	    $reqquantity=$_REQUEST['reqquantity'.$p];
		
		
		if($medicinename!="")
		{
		
	 echo $medicinequery2="insert into master_internalstockrequest (itemcode, itemname, docno,fromstore,tostore,quantity,username, ipaddress, companyanum,remarks,recordstatus)
	values ('$medicinecode', '$medicinename', '$docno','$fromstore','$tostore','$reqquantity','$username', '$ipaddress','$companyanum', '$remarks','pending')";
	
	$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}
		}
		header("location:stocktransfer.php?docno=$docno");
}

?>

					 <?php
									$docno=$_REQUEST['docno'];
									$query2 = "select * from master_internalstockrequest where docno='$docno' order by docno";
									$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
									while($res2 = mysqli_fetch_array($exec2))
									{
									$billnumber = $res2["docno"];
									$fromstore=$res2["fromstore"];
									$tostore=$res2["tostore"];
									$itemcode = $res2["itemcode"];
									$itemname=$res2["itemname"];
									$quantity=$res2["quantity"];
									$username=$res2["username"];
									$remarks=$res2["remarks"];
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

	funcCustomerDropDownSearch4();
	
	
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

<?php include ("js/dropdownlist1scriptingrequestmedicine.php"); ?>
<script type="text/javascript" src="js/autosuggestrequestmedicine.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_requestmedicine.js"></script>

<script type="text/javascript" src="js/insertnewitemrequestmedicine.js"></script>
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
		
		
              <form name="cbform1" method="post" action="editstocrequest.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="8" bgcolor="#ecf0f5" class="bodytext3"><strong> Internal Stock Request </strong></td>
              </tr>
          
            <tr>
              <td width="71" align="left" valign="middle"  class="bodytext3">Doc NO</td>
              <td width="97" align="left" valign="top"><span class="bodytext32">
                <input name="docnumber" type="text" id="docnumber" style="border: 1px solid #001E6A;" value="<?php echo  $docno=$_REQUEST['docno'] ?>" size="8" autocomplete="off" readonly="readonly">
				<input type="hidden" name="location" id="location" value="<?php echo $res7locationanum; ?>">
              </span></td>
              <td width="63" align="left" valign="top" class="bodytext3"></td>
              <td width="98" align="left" valign="top" class="bodytext3"><input type="hidden" name="fromstore" value="<?php echo $store; ?>"></td>
              <td width="59" align="left" valign="top" class="bodytext3"></td>
              <td width="165" align="left" valign="top" class="bodytext3">
				<input type="hidden" name="tostore" value="<?php echo $tostore; ?>">

			 </td> 
			   <input name="searchtostore1hiddentextbox" id="searchtostore1hiddentextbox" type="hidden" value="">
			  <input name="searchtostoreanum1" id="searchtostoreanum1" value="" type="hidden">
			  <input name="locationcode" id="locationcode" value="<?php echo $res7locationanum; ?>" type="hidden">
			
			    <td width="58" align="left" valign="middle"  class="bodytext3">Date</td>
              <td width="125" align="left" valign="top"><span class="bodytext3">
               <input name="date" type="text" id="date" style="border: 1px solid #001E6A;" value="<?php echo $updatedatetime; ?>" size="8" autocomplete="off" readonly="readonly">
              </span></td>
              </tr>
	  <tr id="pressid">
				   <td colspan="15" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				   <table id="presid" width="500" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="150" class="bodytext3">Medicine Name</td>
                      
                       <td width="84" class="bodytext3">Avl.Qty</td>
                      <td width="84" class="bodytext3">Req.Qty</td>
                     </tr>
					 <tr>
					 <div id="insertrow">					 </div></tr>
					 
                     <tr>
					  <input type="hidden" name="serialnumber" id="serialnumber" value="1">
					  <input type="hidden" name="medicinecode" id="medicinecode" value="<?php echo $itemcode;?>">
                        <td><input name="medicinename" type="text" id="medicinename" size="35" value="" autocomplete="off"  onKeyDown="return StateSuggestionspharm4()" onKeyUp="return funcCustomerDropDownSearch4()"></td>
								   <input name="searchmedicinename1hiddentextbox" id="searchmedicinename1hiddentextbox" type="hidden" value="">
			  <input name="searchmedicineanum1" id="searchmedicineanum1" value="" type="hidden">
			
						<td><input name="avlquantity" type="text" id="avlquantity" size="8" readonly></td>
						<td><input name="reqquantity" type="text" id="reqquantity" size="8" value=""></td>
						
						<td width="118"><label>
                       <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem10()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
                     
					 <input type="hidden" name="h" id="h" value="0">
                   </table>				  </td>
			       </tr>
				    <tr>
              <td align="left" valign="middle" class="bodytext3"><strong>User Name</strong></td>
              <td align="left" valign="middle" class="bodytext3"><?php echo $username; ?> </td>
              <td align="left" valign="middle" class="bodytext3"><strong>Remarks</strong></td>
              <td colspan="2" align="left" valign="middle" class="bodytext3"><textarea name="remarks"></textarea></td>
              <td align="left" valign="top">		              </td>
            </tr>	
			   <tr>
              <td align="left" valign="middle" class="bodytext3"></td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  style="border: 1px solid #001E6A" type="submit" value="Save" name="Submit" />                 </td>
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

