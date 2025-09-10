<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatetime = date('H:i:s');


if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag1 == 'frmflag1')
{
       
		$paynowbillprefix7 = 'DN-';
$paynowbillprefix17=strlen($paynowbillprefix7);
$query27 = "select * from ip_drugadmin order by auto_number desc limit 0, 1";
$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));
$res27 = mysqli_fetch_array($exec27);
$billnumber7 = $res27["docno"];
$billdigit7=strlen($billnumber7);

if ($billnumber7 == '')
{
	$billnumbercode7 =$paynowbillprefix7.'1';
		$openingbalance = '0.00';

}
else
{
	$billnumber7 = $res27["docno"];
	$billnumbercode7 = substr($billnumber7,$paynowbillprefix17, $billdigit7);
	//echo $billnumbercode;
	$billnumbercode7 = intval($billnumbercode7);
	$billnumbercode7 = $billnumbercode7 + 1;

	$maxanum7 = $billnumbercode7;
	
	
	$billnumbercode7 = $paynowbillprefix7 .$maxanum7;
		}
		$patientname = $_REQUEST['patientname'];
		$patientcode = $_REQUEST['patientcode'];
		$visitcode = $_REQUEST['visitcode'];
		$accname = $_REQUEST['accname'];
		$drugstatus =  $_REQUEST['drugstatus'];
		$itemname =  $_REQUEST['itemname'];
		$itemcode =  $_REQUEST['itemcode'];
		$remarks = $_REQUEST['remarks'];
		$varserial = $_REQUEST['varserial'];
		$medicineissuedocno = $_REQUEST['medicineissuedocno'];
				
		
		$query67 = "insert into ip_drugadmin(docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,itemname,itemcode,drugstatus,serialnumber,remarks,medicineissuedocno)values('$billnumbercode7','$patientname','$patientcode','$visitcode','$accname','$updatetime','$updatedate','$ipaddress','$username','$itemname','$itemcode','$drugstatus','$varserial','$remarks','$medicineissuedocno')";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
		header("location:ipdrugadmin.php?close=1");

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Payment Entry Not Completed.";
}


?>
<?php
if (isset($_REQUEST["close"])) { $close = $_REQUEST["close"]; } else { $close = ""; }
echo $close;
?>
<?php if($close == 1) {

echo "<script language=javascript>\n".

" window.close();\n".
"</script>\n";
exit();
}
?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'DA-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ip_drugadmin order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);

if ($billnumber == '')
{
	$billnumbercode =$paynowbillprefix.'1';
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
	
	
	$billnumbercode = $paynowbillprefix .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

?>
<?php

if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if(isset($_REQUEST['itemcode'])) { $itemcode = $_REQUEST["itemcode"]; } else { $itemcode = ""; }
if(isset($_REQUEST['varserial'])) { $varserial = $_REQUEST["varserial"]; } else { $varserial = ""; }
if(isset($_REQUEST['vardocno'])) { $vardocno = $_REQUEST["vardocno"]; } else { $vardocno = ""; }
?>
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

<script>


function validcheck()
{
if(document.getElementById("drugstatus").value == '')
{
alert("Please Select Drug Status");
document.getElementById("drugstatus").focus();
return false;
}
if(document.getElementById("drugstatus").value == 'incomplete')
{
if(document.getElementById("remarks").value == '')
{
alert("Please Enter Remarks");
document.getElementById("remarks").focus();
return false;
}
}
}


function funcOnLoadBodyFunctionCall()
{
funcremarkshide();
}

function funcremarksshow()
{

  if (document.getElementById("remarks1") != null) 
     {
	 document.getElementById("remarks1").style.display = 'none';
	}
	if (document.getElementById("remarks1") != null) 
	  {
	  document.getElementById("remarks1").style.display = '';
	 }
	 
  if (document.getElementById("remarks2") != null) 
     {
	 document.getElementById("remarks2").style.display = 'none';
	}
	if (document.getElementById("remarks2") != null) 
	  {
	  document.getElementById("remarks2").style.display = '';
	 }
	
}

function funcremarkshide()
{		
 if (document.getElementById("remarks1") != null) 
	{
	document.getElementById("remarks1").style.display = 'none';
	}	
	if (document.getElementById("remarks2") != null) 
	{
	document.getElementById("remarks2").style.display = 'none';
	}	
}

function funcstatus()
{
if(document.getElementById("drugstatus").value == 'incomplete')
{
funcremarksshow();
}
if(document.getElementById("drugstatus").value == 'complete')
{
funcremarkshide();
}
}

function funcwardChange1()
{
	/*if(document.getElementById("ward").value == "1")
	{
		alert("You Cannot Add Account For CASH Type");
		document.getElementById("ward").focus();
		return false;
	}*/
	<?php 
	$query12 = "select * from master_ward where recordstatus=''";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res12 = mysqli_fetch_array($exec12))
	{
	$res12wardanum = $res12["auto_number"];
	$res12ward = $res12["ward"];
	?>
	if(document.getElementById("ward").value=="<?php echo $res12wardanum; ?>")
	{
		document.getElementById("bed").options.length=null; 
		var combo = document.getElementById('bed'); 	
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Sub Type", ""); 
		<?php
		$query10 = "select * from master_bed where ward = '$res12wardanum' and recordstatus = ''";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res10 = mysqli_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10bedanum = $res10['auto_number'];
		$res10bed = $res10["bed"];
		
		
		
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10bed;?>", "<?php echo $res10bedanum;?>"); 
		<?php 
		
		}
		?>
	}
	<?php
	}
	?>	
}


</script>


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
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body onLoad="return funcOnLoadBodyFunctionCall()">
<form name="form1" id="form1" method="post" action="ipdrugadmin.php" onSubmit="return validcheck()">	
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  
  <tr>
    <td colspan="14">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%">&nbsp;</td>
   
    <td colspan="5" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
     	<tr>
		<td>
	        
           <?php
            $colorloopcount ='';
		
		$query1 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode' and paymentstatus =''";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		while($res1 = mysqli_fetch_array($exec1))
		{
		$patientname=$res1['patientfullname'];
		$patientcode=$res1['patientcode'];
		$accountname = $res1['accountname'];
			
		
		$query67 = "select * from master_accountname where auto_number='$accountname'";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 
		$res67 = mysqli_fetch_array($exec67);
		$accname = $res67['accountname'];
		
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
			?>
       			<input type="hidden" name="patientname" id="patientname" value="<?php echo $patientname; ?>">
				 
				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>">
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>">
				<input type="hidden" name="varserial" id="varserial" value="<?php echo $varserial; ?>">
			
				<input type="hidden" name="accname" id="accname" value="<?php echo $accname; ?>">
			  
		   <?php 
		   } 
		  
		   ?>   		</td>
		<td>&nbsp;</td>
		</tr>
		
		</table>		</td>
		</tr>
	
      <tr>
        <td>&nbsp;</td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="450" 
            align="left" border="0">
          <tbody>
		  <tr>
		  <td width="60%" align="center" valign="center" class="bodytext311">Medicine</td>
		   <td align="center" valign="center" class="bodytext311">Drug Status </td>
		    <td align="center" valign="center" class="bodytext311" id="remarks2">Remarks</td>
		  </tr>
		  <?php
		   $query19 = "select * from ipmedicine_issue where patientcode='$patientcode' and visitcode='$visitcode' and itemcode='$itemcode' and docno='$vardocno' and recordstatus = '' order by auto_number desc";
		   $exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query19".mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res19 = mysqli_fetch_array($exec19);
		   $itemname = $res19['itemname'];
	 
		  ?>
		  <tr>
		  <td align="center" valign="center" class="bodytext311"><?php echo $itemname; ?></td>
		  <input type="hidden" name="itemname" id="itemname" value="<?php echo $itemname; ?>">
		  <input type="hidden" name="itemcode" id="itemcode" value="<?php echo $itemcode; ?>">
		   <input type="hidden" name="medicineissuedocno" id="medicineissuedocno" value="<?php echo $vardocno; ?>">
		  <td align="center" valign="center" class="bodytext311">
		  <select name="drugstatus" id="drugstatus" onChange="return funcstatus();">
		  <option value="">Select</option>
		  <option value="complete">Complete</option>
		  <option value="incomplete">Incomplete</option>
		  </select>		  </td>
		  <td align="center" valign="center" class="bodytext311" id="remarks1"><textarea name="remarks" id="remarks"></textarea></td>
		  </tr>
		  </tbody>
		  </table>
      </tr>
       
	     <tr>
        <td>&nbsp;</td>
	</tr>
	 <tr>
        <td>&nbsp;</td>
	</tr>
	 <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td width="48%" align="center" valign="center" class="bodytext311">&nbsp;</td>
	    <td width="43%" align="center" valign="center" class="bodytext311"><input type="submit" name="Submit" value="Save" style="border: 1px solid #001E6A"/>
        <input type="hidden" name="frmflag1" value="frmflag1" /></td>
	    <td width="7%" align="center" valign="center" class="bodytext311">&nbsp;</td>
	 </tr>
  </table>
  
</form>

</body>
</html>

