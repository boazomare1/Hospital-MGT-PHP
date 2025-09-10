<?php
session_start();
include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$pagename ='';
$colorloopcount = "";
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
$locationname = $res["locationname"];
$locationcode = $res["locationcode"];
	
if (isset($_REQUEST["pkgtemplate"])) {  $pkgtemplate = $_REQUEST["pkgtemplate"]; $_SESSION['pkgtemplate']=$pkgtemplate; } else { $pkgtemplate = ''; }
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	
	$packagename = $_REQUEST["packagename"];	//$packagename = strtoupper($packagename);
	$packagename = trim($packagename);
	$packagename = addslashes($packagename);
	$selectedlocationcode=$_REQUEST["location"];
	$days=$_REQUEST["days"];
	$bedcharges=$_REQUEST["bedcharges"];
	$threshold = $_REQUEST["threshold"];
	$lab  = $_REQUEST["lab"];
	$rate  = $_REQUEST["rate"];
	$rate3 = $_REQUEST['rate3'];
	
	$radiology = $_REQUEST["radiology"];
	
	$doctor = $_REQUEST["doctor"];
	
	$admin = $_REQUEST["admin"];
	
	$service  = $_REQUEST["service"];
	
	$total = $_REQUEST['total'];
	$servicesitem = $_REQUEST['servicesitem'];
	$servicescode = $_REQUEST['servicescode'];
	
	 $query31 = "select * from master_location where locationcode = '$selectedlocationcode' and status = '' " ;
	$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res31 =(mysqli_fetch_array($exec31));
	 $selectedlocation = $res31["locationname"];
	
		
	$query2 = "select * from master_ippackage where packagename = '$packagename'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
		$query1 = "insert into master_ippackage (locationname,locationcode,packagename,days,bedcharges,threshold,surgeon,rate,radiology,doctor,service, admin,total,ipaddress,username,rate3,servicesitem,servicescode) 
		values('$selectedlocation','$selectedlocationcode','$packagename','$days','$bedcharges','$threshold','$lab','$rate','$radiology','$doctor','$service','$admin','$total','$ipaddress','$username','$rate3','$servicesitem','$servicescode')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$query10 = "select * from master_testtemplate where testname = 'ippackage' order by templatename";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res10 = mysqli_fetch_array($exec10))
		{							
		$templatename = $res10["templatename"];
		$query2 = "insert into $templatename (locationname,locationcode,packagename,days,bedcharges,threshold,surgeon,rate,radiology,doctor,service, admin,total,ipaddress,username,rate3) 
		values('$selectedlocation','$selectedlocationcode','$packagename','$days','$bedcharges','$threshold','$lab','$rate','$radiology','$doctor','$service','$admin','$total','$ipaddress','$username','$rate3')";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		}	
		$companyname = '';
		$title1  = '';
		$title2  = '';
		$contactperson1  = '';
		$contactperson2 = '';
		$designation1 = '';
		$designation2  = '';
		$phonenumber1 = '';
		$doctor = '';
		$emailid1  = '';
		$admin = '';
		$faxnumber1 = '';
		$faxnumber2  = '';
		$address = '';
		$location = '';
		$lab  = '';
		$state = '';
		$pincode = '';
		$radiology = '';
		$tinnumber = '';
		$cstnumber = '';
		$companystatus  = '';
		$openingbalance = '0.00';
		$remarks = "";
		$dateposted = $updatedatetime;
		header("location:addippackage.php?st=success");
		//header ("location:addcompany1.php?st=success&&cpynum=1");
	}
	else
	{
		//header ("location:addippackage.php?st=failed");
	}

}
else
{
	$companyname = "";
	//$companyname = strtoupper($companyname);
	$title1  = "";
	$title2  = "";
	$contactperson1  = "";
	$contactperson2 = "";
	$designation1 = "";
	$designation2  = "";
	$phonenumber1 = "";
	$doctor = "";
	$emailid1  = "";
	$admin = "";
	$faxnumber1 = "";
	$faxnumber2  = "";
	$days = "";
	$bedcharges = "";
	$location = "";
	$lab  = "";
	$pincode = "";
	$radiology = "";
	$state = "";
	$tinnumber = "";
	$cstnumber = "";
	$companystatus  = "";
	$openingbalance = "";
	$remarks = "";
	$dateposted = $updatedatetime;
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$pkgtemp = $_REQUEST["pkgtemp"];
	$query3 = "update $pkgtemp set status = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}

if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$pkgtemp = $_REQUEST["pkgtemp"];
	$query13 = "update $pkgtemp set status = '' where auto_number = '$delanum'";
	$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
}

if ($st == 'success')
{
		$errmsg = "Success. New Package Updated.";
		if (isset($_REQUEST["cpynum"])) { $cpynum = $_REQUEST["cpynum"]; } else { $cpynum = ""; }
		if ($cpynum == 1) //for first company.
		{
			$errmsg = "Success. New Package Updated.";
		}
}
if ($st == 'failed')
{
		$errmsg = "Failed. Package Already Exists.";
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
.ui-menu .ui-menu-item a {
	zoom: 0.5 !important;	
}
-->
</style>
<link href="autocomplete.css" rel="stylesheet">

<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script language="javascript">
$(function() {
	$('#servicesitem').autocomplete({
	source:"ajaxautocomplete_services_pkg.php?subtype=<?php echo '1';?>&&loc=<?php echo $locationcode; ?>",
	minLength:3,
	delay: 0,
	html: true, 
		select:function(event,ui){
		$('#servicesitem').val(ui.item.value);
		$('#servicescode').val(ui.item.code);
		}
	});
});

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

function onloadfunction1()
{
	document.form1.packagename.focus();	
}

					 
function funcDeletepackage(varpackageAutoNumber)
{
     var varpackageAutoNumber = varpackageAutoNumber;
	 var fRet;
	fRet = confirm('Are you sure want to delete this Package Type '+varpackageAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Package Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Package Entry Delete Not Completed.");
		return false;
	}
}

function funclocationChange2()
{
 	if(document.getElementById("packagename").value =="")
	{
	alert("Package Name Cannot Be Empty");
	packagename.focus();
	return false;
	}
}

</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
</head>
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

function from1submit1()
{
	if (document.form1.location.value == "")
	{
		alert ("Location Cannot Be Empty.");
		document.form1.location.focus();
		return false;
	}

	 if (document.form1.packagename.value == "")
	{
		alert ("Package Name Cannot Be Empty.");
		document.form1.packagename.focus();
		return false;
	}

	if (document.form1.servicescode.value == "")
	{
		alert ("Service Item Cannot Be Empty.");
		document.form1.servicesitem.focus();
		return false;
	}

	
}

function totalcalc()
{

if(document.getElementById("bedcharges").value != '')
{
var bedcharges = document.getElementById("bedcharges").value;
}
else
{
var bedcharges = 0;
}
if(document.getElementById("lab").value != '')
{
var lab = document.getElementById("lab").value;
}
else
{
var lab = 0;
}
if(document.getElementById("radiology").value != '')
{
var radiology = document.getElementById("radiology").value;
}
else
{
var radiology = 0;
}
if(document.getElementById("service").value != '')
{
var service = document.getElementById("service").value;
}
else
{
var service = 0;
}
if(document.getElementById("doctor").value != '')
{
var doctor = document.getElementById("doctor").value;
}
else
{
var doctor = 0;
}
if(document.getElementById("admin").value != '')
{
var admin = document.getElementById("admin").value;
}
else
{
var admin = 0;
}
var total = parseInt(bedcharges) + parseInt(lab) + parseInt(radiology) + parseInt(service) + parseInt(doctor) + parseInt(admin);

document.getElementById("total").value = total.toFixed(2);
}
</script> 
<body onLoad="return onloadfunction1();">
<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5">
	<?php 
	
		include ("includes/menu1.php"); 
	
	//	include ("includes/menu2.php"); 
	
	?>	</td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">


      	  <form name="form1" id="form1" method="post" onKeyDown="return disableEnterKey()" action="addippackage.php" onSubmit="return from1submit1()">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860"><table width="714" height="" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td bgcolor="#ecf0f5" class="bodytext3" colspan="1"><strong>Package - New </strong></td>
                <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                <td bgcolor="#ecf0f5" class="bodytext3" align="right" colspan="2">* Indicated Mandatory Fields. </td>
                 <td width="10%" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                  <?php
						
						$query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						$res1locationcode = $res1["locationcode"];
						
						?>
						
						
                  
                  </td>
              </tr>
			  <?php
			  if ($errmsg != '')
			  {
			  ?>
             <tr>
                <td colspan="8" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
              </tr>
			  <?php
			  }
			  ?>
				<tr>
                <td width="14%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><span class="bodytext32">Location   *</span></td>
                <td width="38%" align="left" valign="middle"  bgcolor="#FFFFFF">
                <select name="location" id="location" onChange="return  ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">
                						<option value="">Select</option>
                  <?php
						$query1 = "select * from master_location where status <> 'deleted' order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationanum; ?>" <?php if($res1locationanum==$res1locationcode){echo "selected";} ?>><?php echo $res1location; ?></option>
						<?php
						}
						?>
                </select>
                </td>
                <td width="11%" align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
                <td width="33%" align="left" valign="middle"  bgcolor="#FFFFFF"></td>
				</tr>
				<tr>
                <td width="14%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><span class="bodytext32">Package Name   *</span></td>
                <td width="38%" align="left" valign="middle"  bgcolor="#FFFFFF"><input name="packagename" id="packagename" onChange  style="border: 1px solid #001E6A; text-transform:uppercase" size="40"></td>
                <td width="11%" align="right"  valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>&nbsp;</strong></td>
                <td width="33%" align="left" valign="middle"  bgcolor="#FFFFFF"></td>
				</tr>
			  <tr>
			    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Days </td>
			    <td align="left" valign="middle"  bgcolor="#FFFFFF"><input name="days" id="days" value="<?php echo $days; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
				 <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Rate</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF"><font size="2">
				   <input name="rate" id="rate" style="border: 1px solid #001E6A"  size="20" />
			 
				   </font></td>
                
			  </tr>
				 <tr>
				  
				    <td width="14%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><span class="bodytext32">Service Item</span></td>
                <td width="38%" align="left" valign="middle"  bgcolor="#FFFFFF"><input name="servicesitem" id="servicesitem" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" autocomplete="off">
                <input type="hidden" name="servicescode" id="servicescode"></td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp; </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF">
				<input name="lab" id="lab" value="<?php echo $lab; ?>" type="hidden" style="border: 1px solid #001E6A"  size="20" onKeyUp="return totalcalc();"/>		   </td>
				
				 </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input  type="hidden" name="threshold" id="threshold" style="border: 1px solid #001E6A;"  size="20" /></td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp; </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF">
				<input name="radiology" id="radiology" style="border: 1px solid #001E6A" type="hidden" size="20" onKeyUp="return totalcalc();"/>		   </td>
			      </tr>
				 <tr style='display:none'>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF"><input type="hidden" type="text" name="rate3" id="rate3" style="border: 1px solid #001E6A;" size="20"></td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF"><input name="service" type="hidden" id="service" style="border: 1px solid #001E6A;"  size="20" onKeyUp="return totalcalc();"/></td>
				 </tr>
				
				
				 
                 <tr>
                <td colspan="2" align="middle"  bgcolor="#FFFFFF"><div align="right"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input type="hidden" name="frmflag1" value="frmflag1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                  <input name="Submit222" type="submit"  value="Submit" class="button" style="border: 1px solid #001E6A"/>
				  </form>	
                </font></font></font></font></font></div></td>
				<td colspan="2" align="middle"  bgcolor="#FFFFFF">&nbsp;</td>
				</tr>
				
				<tr>
					<td align="middle" colspan="2" >&nbsp;</td><td align="middle" colspan="2" >&nbsp;</td>
				</tr>
                </tbody>
                  </table>
				  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#ffffff" id="AutoNumber3" style="border-collapse: collapse">
				   <form action="addippackage.php" method="post" name="packagesearch" id="packagesearch">
                      <tr bgcolor="#011E6A">
                        
						  <td colspan="13" bgcolor="#FFFFFF" class="bodytext3">
						<select name="pkgtemplate" id="pkgtemplate"  style="border: 1px solid #001E6A;">
						<?php
						if($pkgtemplate!='')
						{?>
						<option value="<?php echo $pkgtemplate; ?>"><?php echo $pkgtemplate; ?></option>
						<?php } else
						{?>
						<option value="" selected="selected">Select Packge</option>
						<?php }
						if($pkgtemplate != 'master_ippackage'){
						?>
						<option value="master_ippackage" selected="">Master Package</option>						
						<?php
						}
							$query10 = "select * from master_testtemplate where testname = 'ippackage' order by templatename";
							$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
							while ($res10 = mysqli_fetch_array($exec10))
							{							
								$templatename = $res10["templatename"];
								if($templatename != $pkgtemplate)
								{
								?>
								<option value="<?php echo $templatename; ?>"><?php echo $templatename; ?></option>
								<?php
								}
							}
						?>
                        </select>
                          <input type="submit" id="Submit2" name="Submit2" value="Search" style="border: 1px solid #001E6A"  /></td>
                        </tr>
                      </form>    
				  </table>
				  <?php
					  if(isset($_POST['Submit2']) == 'Search')
					  {
						 $pkgtemp=  $_REQUEST['pkgtemplate'];
						 
					  ?>  
                <table width="60%" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                      
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Template</strong></td>
                        <td width="" bgcolor="#ecf0f5" class="bodytext3"><strong>Name</strong></td>
                        <td width="" bgcolor="#ecf0f5" class="bodytext3"><strong>Rate</strong></td>
                        <td width="" bgcolor="#ecf0f5" class="style1">Days</td>
                        <td width="" bgcolor="#ecf0f5" class="style1">Package Id</td>
                        <td width="" bgcolor="#ecf0f5" class="bodytext3"><strong>Edit</strong></td>
                      </tr>
                      <?php
					  $uppercasepkg=strtoupper($pkgtemp);
						$query21 = "select * from $pkgtemp where status <> 'DELETED' ";
						$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res21 = mysqli_fetch_array($exec21))
						{
						$res21location = $res21['locationname'];
						$res21packagename = $res21['packagename'];
						$res21packagenum = $res21['auto_number'];
						$res21days = $res21['days'];
					    $res21threshold = $res21['threshold'];
						$res21rate = $res21['rate'];
						$rate3 = $res21['rate3'];
						$auto_number = $res21['auto_number'];
						$res21updatedatetime = $res21['updatedatetime'];
						$res21arraysupplierdate = explode(" ", $updatedatetime);
			
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
							<td width=" align="left" valign="top" class="bodytext3">
							<div align="center">
							<a href="addippackage.php?st=del&&anum=<?php echo $res21packagenum; ?>&&pkgtemp=<?= $pkgtemp?>" onClick="return funcDeletepackage('<?php echo $res21packagenum ?>')">
							<img src="images/b_drop.png" width="16" height="16" border="0" /></a>						</div>						</td>
							<td width="" align="left" valign="top" name = "packagecode" class="bodytext3"><?php echo $uppercasepkg;?></td>
							<td width="" align="left" valign="top"  class="bodytext3"><?php echo $res21packagename; ?> </td>
							<td align="right" valign="top"  class="bodytext3"><?php echo number_format($res21rate,2,'.',','); ?></td>
							<td align="center" valign="top"  class="bodytext3"><?php echo $res21days; ?></td>
                           <td width="" align="left" valign="top"  class="bodytext3"><?php echo $auto_number; ?> </td>
							<td align="left" valign="top"  class="bodytext3"><a href="editippackage.php?st=edit&&packcode=<?php echo $res21packagenum; ?>&&pkgtemp=<?= $pkgtemp?>" style="text-decoration:none">Edit</a></td>
						</tr>
                      <?php
							}
						?>
                        <tr>
                        <td align="middle" colspan="7" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
				   <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>Package Master - Deleted </strong></td>
                      </tr>
                      <?php
		
	    $query1 = "select * from $pkgtemp where status = 'deleted' order by packagename ";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$packagename = $res1['packagename'];
		$packagenumber = $res1["auto_number"];
		$res1location = $res1['locationname'];
		
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
                        <td width="11%" align="left" valign="top"  class="bodytext3">
						<a href="addippackage.php?st=activate&&anum=<?php echo $packagenumber; ?>&&pkgtemp=<?= $pkgtemp?>" class="bodytext3">
                          <div align="center" class="bodytext3">Activate</div>
                        </a></td>
                        <td width="35%" align="left" valign="top"  class="bodytext3"><?php echo $packagename; ?>
                        <td width="35%" align="left" valign="top"  class="bodytext3"><?php echo $res1location; ?>
                        </td>
                      </tr>
                      <?php
		}
		?>
            </tbody>
          </table>
        	
       <?php
	   }
	   ?>
    </table>

	</table>

<?php include ("includes/footer1.php"); ?>
</body>
</html>

