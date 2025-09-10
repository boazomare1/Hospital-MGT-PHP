<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if ($cbfrmflag1 == 'cbfrmflag1')
{

$serial = $_REQUEST['serialnumber'];
$remarks = $_REQUEST['remarks'];
$fromstore = $_REQUEST['fromstore'];
$tostore = $_REQUEST['tostore'];
$typetransfer = $_REQUEST['typetransfer'];
$number = $serial - 1;
$paynowbillprefix1 = 'ISR-';
$paynowbillprefix12=strlen($paynowbillprefix1);
$query23 = "select * from master_internalstockrequest where orgstatus ='original' order by auto_number desc limit 0, 1";
$exec23= mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$billnumber1 = $res23["docno"];
$billdigit1=strlen($billnumber1);
if ($billnumber1 == '')
{
	$billnumbercode1 ='ISR-'.'1';
	$openingbalance1 = '0.00';
}
else
{
	$billnumber1 = $res23["docno"];
	$billnumbercode1 = substr($billnumber1,$paynowbillprefix12, $billdigit1);
	//echo $billnumbercode;
	$billnumbercode1 = intval($billnumbercode1);
	$billnumbercode1 = $billnumbercode1 + 1;

	$maxanum1 = $billnumbercode1;
	
	
	$billnumbercode1 = 'ISR-'.$maxanum1;
	$openingbalance1 = '0.00';
	//echo $companycode;
}

for ($p=1;$p<=$number;$p++)
		{
				   
		$medicinename=$_REQUEST['medicinename'.$p];
		$medicinename=trim($medicinename);
		/*
		$query77="select itemcode from master_medicine where itemname='$medicinename'";
			$exec77=mysql_query($query77);
			$num77=mysql_num_rows($exec77);
			//echo $num77;
			$res77=mysql_fetch_array($exec77);
			$medicinecode=$res77['itemcode'];
			
		*/	
		$medicinecode=$_REQUEST['medicinecode'.$p];
		
		//echo $medicinecode;
		
$query23 = "select quantity from master_internalstockrequest where itemcode='$medicinecode' and docno='$billnumbercode1'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$numcount = mysqli_num_rows($exec23);
$res23 = mysqli_fetch_array($exec23);
			$alreadyreqquantity=$res23['quantity'];
		
		
		$avlquantity=$_REQUEST['avlquantity'.$p];
		
	    $reqquantity=$_REQUEST['reqquantity'.$p];
		
		 
		if($medicinename!="")
		{
			if($numcount!=0)
			{
				$totalquantity=$reqquantity+$alreadyreqquantity;
				  $updatequery="update master_internalstockrequest set quantity='$totalquantity' where itemcode='$medicinecode' and docno='$billnumbercode1' ";
				  $excupdatequery=mysqli_query($GLOBALS["___mysqli_ston"], $updatequery) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				
			}
			else
			{
		
	$medicinequery2="insert into master_internalstockrequest (itemcode, itemname, docno,fromstore,tostore,quantity,username, ipaddress, companyanum,remarks,recordstatus,orgstatus,typetransfer)
	values ('$medicinecode', '$medicinename', '$billnumbercode1','$fromstore','$tostore','$reqquantity','$username', '$ipaddress','$companyanum', '$remarks','pending','original','$typetransfer')";
	
	$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			}
	}
		}
		header("location:mainmenu1.php");
}

?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'ISR-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from master_internalstockrequest order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='ISR-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'ISR-'.$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>
<?php

$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1location = $res1["locationname"];
$res7locationanum = $res1["locationcode"];
$query2 = "select ms.store,ms.storecode from master_store AS ms LEFT JOIN master_location AS ml ON ms.location=ml.auto_number WHERE ml.locationcode = '".$res7locationanum."'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$store = $res2["store"];
$res7storeanum = $res2["storecode"];
 

?>
<script>
function funcOnLoadBodyFunctionCall()
{

	//funcCustomerDropDownSearch4();
	
	
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
function validate()
{
if(!($('#insertrow').find('tr').length > 0))
{
alert("Add atleast one item");
return false;
}
$('#savebutton').prop('disabled','disabled');
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

<link href="autocomplete.css" rel="stylesheet">

<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/insertnewitemrequestmedicine.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
<script>
function funcSelectFromStore()
{ 
	if(document.getElementById("typetransfer").value=='')
	{
		alert('please Select Type');
		document.getElementById("location").value='';
	}
	else 
	{
		<?php 
		$query12 = "select * from master_location where status <> 'deleted'";
		$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res12 = mysqli_fetch_array($exec12))
		{
		$res12anum = $res12["auto_number"];
		$res12locationcode = $res12["locationcode"];
		?>
		if(document.getElementById("location").value=="<?php echo $res12locationcode; ?>")
		{
			
			document.getElementById("fromstore").options.length=null; 
			var comboto = document.getElementById('fromstore'); 	
			<?php
			$loopcount=0;
			?>
			
			//comboto.options[<?php echo $loopcount;?>] = new Option ("Select Store", ""); 
			<?php
			$query10 = "select storecode,defaultstore from master_employeelocation WHERE username='$username' and defaultstore='default'";
			$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res10 = mysqli_fetch_array($exec10))
			{
			//$loopcount = $loopcount+1;
			$res10anum = $res10["storecode"];	
			$query751 = "select store,storecode from master_store where auto_number='$res10anum'";
			$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res751 = mysqli_fetch_array($exec751);
			$res10store = $res751['store'];
			$res10storecode = $res751['storecode'];
					
			?>
				
				comboto.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10store;?>", "<?php echo $res10storecode;?>"); 
			<?php 
			}
			?>
		}
		<?php
		}
		?>
	}	
}
function medicinesearch(tval)
{	
	if(tval=='NULL')
	{	
		if($('#typetransfer').val()=='')
		{
			alert('Please Select Type');
			return false;
		}
	}
	else
	{
		funcSelectFromStore();
	}
	
	$('#medicinename').autocomplete({
		
		source:'ajaxrequestmedicinebuildnew.php?typetransfer='+tval+'&&storecode='+$('#fromstore').val()+'&&action=medicinesearch', 
		//alert(source);
		minLength:3,
		delay: 0,
		html: true, 
			select: function(event,ui){
				var itemcode = ui.item.itemcode;
				$('#medicinecode').val(itemcode);
						dataString = 'itemcode='+itemcode+'&&storecode='+$('#fromstore').val()+'&&location='+$('#location').val()+'&&action=medicineqty';
						$.ajax({
						type:"POST",
						url:"ajaxrequestmedicinebuildnew.php",
						data:dataString,
						cache: true,
						success: function(html)
						{
							$('#avlquantity').val(html);
						}
						});
				},
	});
}
	</script>    
<style type="text/css">
.ui-menu .ui-menu-item{ zoom:1 !important; }
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
		
		
              <form name="cbform1" method="post" action="internalstockrequest.php" onSubmit="return validate();">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="8" bgcolor="#ecf0f5" class="bodytext3"><strong> Internal Stock Request </strong></td>
              </tr>zz
          <tr bgcolor="#011E6A">
                      <td colspan="1" bgcolor="#ecf0f5" class="bodytext32"><strong>Type</strong></td>
                      <td colspan="12" bgcolor="#ecf0f5" class="bodytext32"><select name="typetransfer" id="typetransfer" onChange="return medicinesearch(this.value);">
                      <option value="">Select Type</option>
                      
					  <option value="0">Transfer</option>
                      <option value="1">Consumable</option>
                      </select></td>
                    </tr>
            <tr>
              <td width="71" align="left" valign="middle"  class="bodytext3">Doc NO</td>
              <td width="97" align="left" valign="top"><span class="bodytext32">
                <input name="docnumber" type="text" id="docnumber" style="border: 1px solid #001E6A;" value="<?php echo $billnumbercode; ?>" size="8" autocomplete="off" readonly>
				<input type="hidden" name="location" id="location" value="<?php echo $res7locationanum; ?>">
              </span></td>
              <td width="63" align="left" valign="top" class="bodytext3">From Store</td>
              <td width="98" align="left" valign="top" class="bodytext3">
              <select name="fromstore" id="fromstore">
			  <option value="">Select Store</option>
			 <?php
			  $query2 = "select storecode,defaultstore from master_employeelocation WHERE username='$username' and defaultstore='default'"; 
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res2 = mysqli_fetch_array($exec2))
				{
					$storecodeanum = $res2['storecode'];
					$defaultstore = $res2['defaultstore'];
					$query751 = "select store,storecode from master_store where auto_number='$storecodeanum'";
					$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$res751 = mysqli_fetch_array($exec751);
					$res2store = $res751['store'];
					$storecode = $res751['storecode'];
					?>
					<option value="<?php echo $storecode; ?>" <?php if($defaultstore=='default'){ echo 'selected';}?>><?php echo $res2store; ?></option>
				<?php
				}
?>
			  </select>
              </td>
              <td width="59" align="left" valign="top" class="bodytext3">To Store</td>
              <td width="165" align="left" valign="top" class="bodytext3">
			  <select name="tostore" id="tostore"  onChange="return medicinesearch('NULL');">
			  <option value="">Select Store</option>
			 <?php
			  $query2 = "select * from master_store where locationcode = '$res7locationanum' and recordstatus <> 'Deleted' order by store limit 0, 200";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
	$storecode = $res2['storecode'];
	$res2store = $res2['store'];
	?>
	<option value="<?php echo $storecode; ?>"><?php echo $res2store; ?></option>
<?php
}
?>
			  </select></td> 
			   <input name="searchtostore1hiddentextbox" id="searchtostore1hiddentextbox" type="hidden" value="">
			  <input name="searchtostoreanum1" id="searchtostoreanum1" value="" type="hidden">
			
			    <td width="58" align="left" valign="middle"  class="bodytext3">Date</td>
              <td width="125" align="left" valign="top"><span class="bodytext3">
               <input name="date" type="text" id="date" style="border: 1px solid #001E6A;" value="<?php echo $updatedatetime; ?>" size="8" autocomplete="off" readonly>
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
					  <input type="hidden" name="medicinecode" id="medicinecode" value="">
                        <td><input name="medicinename" type="text" id="medicinename" size="35" autocomplete="off" ></td>
								   <input name="searchmedicinename1hiddentextbox" id="searchmedicinename1hiddentextbox" type="hidden" value="">
			  <input name="searchmedicineanum1" id="searchmedicineanum1" value="" type="hidden">
			
						<td><input name="avlquantity" type="text" id="avlquantity" size="8"></td>
						<td><input name="reqquantity" type="text" id="reqquantity" size="8"></td>
						
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
                  <input  style="border: 1px solid #001E6A" type="submit" value="Save" id="savebutton" name="Submit" onClick="return medicinecheck();"/>                 </td>
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

