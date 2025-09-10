<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];

					
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$query1 = "select employeecode from master_employee where  status = 'Active' AND username like '%$username%'";$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));$res1 = mysqli_fetch_array($exec1);$res1employeename  = $res1["employeecode"];
//This include updatation takes too long to load for hunge items database.
$location =isset( $_REQUEST['location'])?$_REQUEST['location']:'';

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum' and locationcode='$locationcode'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}



if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag2 == 'frmflag2')
{
    $itemname=$_REQUEST['itemname'];
	$itemcode=$_REQUEST['itemcode'];
    $adjustmentdate=date('Y-m-d');
	foreach($_POST['batch'] as $key => $value)
		{
		$batchnumber=$_POST['batch'][$key];
		$addstock=$_POST['addstock'][$key];
		$minusstock=$_POST['minusstock'][$key];
	$query40 = "select * from master_itempharmacy where itemcode = '$itemcode' and locationcode='$locationcode'";
	$exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die ("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res40 = mysqli_fetch_array($exec40);
	$itemmrp = $res40['rateperunit'];
	
	$itemsubtotal = $itemmrp * $addstock;
	
		if($addstock != '')
		{
		$query65="insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, 
	transactionparticular, billautonumber, billnumber, quantity, remarks, 
	 username, ipaddress, rateperunit, totalrate, companyanum, companyname,batchnumber,locationname,locationcode)
	values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 
	'BY ADJUSTMENT ADD', '$billautonumber', '$billnumber', '$addstock', '$remarks', 
	'$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname','$batchnumber','$locationname','$locationcode')";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		else
		{
		$query65="insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, 
	transactionparticular, billautonumber, billnumber, quantity, remarks, 
	 username, ipaddress, rateperunit, totalrate, companyanum, companyname,batchnumber,locationname,locationcode)
	values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 
	'BY ADJUSTMENT MINUS', '$billautonumber', '$billnumber', '$minusstock', '$remarks', 
	'$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname','$batchnumber','$locationname','$locationcode')";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
		}
		}
	header("location:stockadjustment.php");
	exit;
	
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
<script language="javascript">

function ajaxlocationfunction(val)
{ 
if (window.XMLHttpRequest)
					  {// code for IE7+, Firefox, Chrome, Opera, Safari
					  xmlhttp=new XMLHttpRequest();
					  }
					else
					  {// code for IE6, IE5
					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					  }
					xmlhttp.onreadystatechange=function()
					  {
					  if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;
						}
					  }
					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);
					xmlhttp.send();
}
					
//ajax to get location which is selected ends here

function cbsuppliername1()
{
	document.cbform1.submit();
}



</script>
<script type="text/javascript">

function funcSubTypeChange1()
{
	<?php 
	$query12 = "select * from master_location";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res12 = mysqli_fetch_array($exec12))
	{
	 $res12subtypeanum = $res12["auto_number"];
	$res12locationname = $res12["locationname"];
	$res12locationcode = $res12["locationcode"];
	?>

	if(document.getElementById("location").value=="<?php echo $res12locationcode; ?>")
	{

		document.getElementById("ward").options.length=null; 
		var combo = document.getElementById('ward'); 	
		<?php 
		$loopcount=0; 
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Ward", ""); 
		<?php
		$query10 = "select * from master_ward where locationname = '$res12locationname' and recordstatus = '' order by ward";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res10 = mysqli_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10accountnameanum = $res10["auto_number"];
		$ward = $res10["ward"];
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $ward;?>", "<?php echo $res10accountnameanum;?>"); 
		<?php 
		}
		?>
	}
	<?php
	}
	?>	
}

function disableEnterKey(varPassed)
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}

	if(key == 13) // if enter key press
	{
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}
}


function process1backkeypress1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}

function disableEnterKey()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}
	
	if(key == 13) // if enter key press
	{
		return false;
	}
	else
	{
		return true;
	}

}


function funcPrintReceipt1()
{
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

	
function wardwisesearch1()
{
    if (document.getElementById("location").value== "")
	{
		alert ("Location Cannot Be Empty.");
		document.getElementById("location").focus();
		return false;
	}

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
		
		
              <form name="cbform1" method="post" id="form1" action="wardwisebedsearch.php" onSubmit="return wardwisesearch1()">
		<table width="604" border="1" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Ward Wise Bed Search</strong></td>
			   <td colspan="4" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                  <?php
						
							
						if ($location!='')
						{
						$query12 = "select locationname from master_location where locationcode='$location' order by locationname";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res12 = mysqli_fetch_array($exec12);
						
						echo $res1location = $res12["locationname"];
						//echo $location;
						}
						else
						{
						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						//$res1locationanum = $res1["locationcode"];
						}
						?>
						
						
                  
                  </td>
			  <!--<td colspan="5" bgcolor="#ecf0f5" class="bodytext3"><strong>Location</strong></td>-->
						  </span></td></tr>
            <tr>
				<td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                 <select name="location" id="location" onChange=" funcSubTypeChange1(); ajaxlocationfunction(this.value);">
		   <?php 
	   	  $query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname"; 
           $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
           while($res = mysqli_fetch_array($exec))
			{
	 		$locationname  = $res["locationname"]; 
	 		$locationcode = $res["locationcode"];
     		$reslocationanum = $res["auto_number"];
			?>
			<option value="<?php echo $locationcode; ?>" <?php if($location!=''){if($location == $locationcode){echo "selected";}}?>><?php echo $locationname; ?></option>
			<?php
			}
			?>
		   </select></span></td>        
              <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Ward</td>
              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <select name="ward" id="ward">
						 <option value="all">All</option>
						  <?php 
		  $query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname"; 
           $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
          $res = mysqli_fetch_array($exec);
			
	 		$locationname  = $res["locationname"]; 
	 		$locationcode2 = $res["locationcode"];
			
		$query78 = "select B.auto_number,B.ward,A.wardcode from nurse_ward as A join master_ward as B on (B.auto_number=A.wardcode) where  A.locationcode='$locationcode2' and B.recordstatus=''  and A.employeecode='$res1employeename'  order by A.defaultward desc";
						  $exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						  while($res78 = mysqli_fetch_array($exec78))
						  {
						  $wardanum = $res78['auto_number'];
						  $wardname = $res78['ward'];
						    ?>
                          <option value="<?php echo $wardanum; ?>"><?php echo $wardname; ?></option>
						  <?php
						  }
			
                          ?>
                      </select>
              </span></td>
              <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Type</td>
              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF">
			  <select name="type" id="type">
			 
			  <option value="all">All</option>
			  <option value="occupied">Occupied</option>
			  <option value="available">Available</option>
			  </select></td>
			  </tr>
			  <tr>
              <td width="20%"  colspan="6" valign="top" align="center"  bgcolor="#ecf0f5"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" onClick="return funcvalidcheck();"/>
            </td>
            </tr>
			    
             </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      
	  <form name="form1" id="form1" method="post" action="wardwisebedsearch.php">	
	  <tr>
        <td>
	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$searchward = $_POST['ward'];
	$searchtype=$_POST['type'];
    $searchlocationcode=$_POST['location'];	   if($searchward=='all'){	$query781 = "select * from master_ward where auto_number in (select B.auto_number  from nurse_ward as A join master_ward as B on (B.auto_number=A.wardcode) where  A.locationcode='$locationcode2' and B.recordstatus=''  and A.employeecode='$res1employeename' order by A.defaultward desc) and locationcode='$searchlocationcode' and recordstatus=''";        }   else{
	$query781 = "select * from master_ward where auto_number='$searchward' and locationcode='$searchlocationcode' and recordstatus=''";   }
						  $exec781 = mysqli_query($GLOBALS["___mysqli_ston"], $query781) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res781 = mysqli_fetch_array($exec781))	   {
						  $wardname = $res781['ward'];                           $wardno = $res781['auto_number'];
						
	
		//echo $searchpatient;
		//$transactiondatefrom = $_REQUEST['ADate1'];
	//$transactiondateto = $_REQUEST['ADate2'];


	
?>
           <?php
            $query34 = "select * from master_ward where auto_number = '$wardno' and locationcode='$searchlocationcode' and recordstatus=''";
			$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res34 = mysqli_fetch_array($exec34))
			{
			$wardnum = $res34['auto_number'];
			$wardname5 = $res34['ward'];
			?>
			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="600" 
            align="left" border="0">
            
			<tbody>
			<tr>
              <td width="13%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				 <td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bed No </strong></div></td>
				 <td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Availability</strong></div></td>
			
				<td width="51%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient </strong></div></td>
				
                <td width="4%"  align="left" valign="center"  bgcolor="#ffffff"
                class="bodytext31"><div align="center"><strong>Discharge Status </strong></div></td>
				<td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="center"><strong>&nbsp; </strong></div></td>
			</tr>
			  
			<tr>
			  <td colspan="5" align="left" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong><?php echo $wardname5; ?></strong></div></td>
			 </tr>
			 
			<?php
		if($searchtype == 'all')
		{
		$query50 = "select * from master_bed where ward='$wardnum' and locationcode='$searchlocationcode' and recordstatus <> 'deleted'";
		$exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		if($searchtype == 'occupied')
		{
		$query50 = "select * from master_bed where ward='$wardnum' and locationcode='$searchlocationcode' and recordstatus='occupied'";
		$exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		if($searchtype == 'available')
		{
		$query50 = "select * from master_bed where ward='$wardnum' and locationcode='$searchlocationcode' and recordstatus=''";
		$exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		while($res50 = mysqli_fetch_array($exec50))
		{
		$bedname = $res50['bed'];
		$bedanum = $res50['auto_number'];
		$status = $res50['recordstatus'];
		if($status == '')
		{
		$bedstatus = 'Available';
		}
		else
		{
		$bedstatus = 'Occupied';
		}
		
		if($bedstatus == 'Occupied')
		{
		$query41 = "select * from ip_bedallocation where ward='$wardnum' and bed='$bedanum' and locationcode='$searchlocationcode' and (recordstatus='' or recordstatus='request')";
		$exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res41 = mysqli_fetch_array($exec41);
		$num41 = mysqli_num_rows($exec41);
		if($num41 > 0)
		{
		$patientname = $res41['patientname'];
		$patientname = $patientname.'/';
		$patientcode = $res41['patientcode'];
		$patientcode1 = $patientcode;
		$patientcode = $patientcode.'/';
		$visitcode = $res41['visitcode'];
		$recstatus = $res41['recordstatus'];
		}
		else
		{
		$query411 = "select * from ip_bedtransfer where ward='$wardnum' and locationcode='$searchlocationcode' and bed='$bedanum' and (recordstatus='' or recordstatus='request') order by auto_number desc limit 0,1";
		$exec411 = mysqli_query($GLOBALS["___mysqli_ston"], $query411) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res411 = mysqli_fetch_array($exec411);
		$patientname = $res411['patientname'];
		if($patientname != '') {
		$patientname = $patientname.'/';
		} else { $patientname = ''; }
		$patientcode = $res411['patientcode'];
		$patientcode1 = $patientcode;
		if($patientcode != '') {
		$patientcode = $patientcode.'/';
		} else { $patientcode = ''; }
		$visitcode = $res411['visitcode'];
		$recstatus = $res411['recordstatus'];
		}
		$wardno = $res41['ward'];
		
		  $query7811 = "select * from master_ward where auto_number='$wardno' and locationcode='$searchlocationcode' and recordstatus=''";
		  $exec7811 = mysqli_query($GLOBALS["___mysqli_ston"], $query7811) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res7811 = mysqli_fetch_array($exec7811);
		  $wardname1 = $res7811['ward'];
		}
		else
		{
		$patientname = '';
		$patientcode = '';
		$patientcode1 = '';
		$visitcode = '';
		}
		
		   $query82 = "select * from master_ipvisitentry where patientcode='$patientcode1'  and locationcode='$searchlocationcode' and visitcode='$visitcode'";
		   $exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $num82 = mysqli_num_rows($exec82);
		   $res82 = mysqli_fetch_array($exec82);
		   $discharge = $res82['discharge'];
		   
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
			
			<tr <?php echo $colorcode; ?>>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div align="center"><?php echo $bedname; ?></div></td>
				<td class="bodytext31" valign="center"  align="center"> 
				<?php if($patientname != '') { ?> 
				<img src="images/hospital-bed-icon.png" width="20" height="20" border="0" />
				<?php }else{ ?>
				<img src="images/medical-bed-icon.png" width="20" height="20" border="0" />				
				<?php } ?>
				<td class="bodytext31" valign="center"  align="left">
				<div align="center"><?php echo $patientname; ?><?php echo $patientcode; ?><?php echo $visitcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div align="center"><?php echo ucfirst($discharge); ?></div></td>
			</tr>
			 </tbody> 
		   <?php 
		   } 
		}	   }
		   ?>
        </table>
<?php
}


?>	
		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
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

