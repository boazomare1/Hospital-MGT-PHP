<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$date = date('Y-m-d');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$licensedbed='302';
if (isset($_REQUEST["bedtemplate"])) {  $bedtemplate = $_REQUEST["bedtemplate"]; $_SESSION['bedtablename']=$bedtemplate; } else { $bedtemplate = ''; }
if (isset($_REQUEST["searchward"])) {  $searchward = $_REQUEST["searchward"]; $_SESSION['searchward']=$searchward; } else { $searchward = ''; }
if (isset($_REQUEST["searchlocation"])) {  $searchlocation = $_REQUEST["searchlocation"]; $_SESSION['searchlocation']=$searchlocation; } else { $searchlocation = ''; }
if (!isset($_SESSION['bedtablename'])){$_SESSION['bedtablename']='master_bedcharge';}
if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	$bed = $_REQUEST["bed"];
	$bedcharge=$_REQUEST['bedtemp'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Bed</title>
<!-- Modern CSS -->
<link href="css/addbed-modern.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
<link href="css/three.css" rel="stylesheet" type="text/css">
<!-- Modern JavaScript -->
<script type="text/javascript" src="js/addbed-modern.js?v=<?php echo time(); ?>"></script>
</head>

<body>

<header>
  <?php include ("includes/alertmessages1.php"); ?>
  <?php include ("includes/title1.php"); ?>
  <?php include ("includes/menu1.php"); ?>
</header>

<main class="main-container">
<?php
	
	$query23 = "select auto_number from master_bed order by auto_number desc";
	$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res23 = mysqli_fetch_array($exec23);
	$bedanum = $res23['auto_number'];
	 $bedanum1 = $bedanum + 1;
	
	//$bed = strtoupper($bed);
	$bed = trim($bed);
	$length=strlen($bed);
	$ward = $_REQUEST["ward"];
	$threshold = $_REQUEST['threshold'];
	
	$selectedlocationcode=$_REQUEST["location"];
	
	$query31 = "select * from master_location where locationcode = '$selectedlocationcode' and status = '' " ;
	$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res31 =(mysqli_fetch_array($exec31));
	$selectedlocation = $res31["locationname"];
	
/*	$query32 = "select * from master_ward where auto_number = '$ward1' and recordstatus = '' " ;
	$exec32 = mysql_query($query32) or die ("Error in Query31".mysql_error());
	$res32 =(mysql_fetch_array($exec32));
	$ward = $res32["ward"];
*/	
	$accommodationcharges = $_REQUEST['accommodationcharges'];
	$cafetariacharges = $_REQUEST['cafetariacharges'];
	
	
	$bedcharges = $_REQUEST['bedcharges'];
	$nursingcharges = $_REQUEST['nursingcharges'];
	$rmocharges = $_REQUEST['rmocharges'];
	$inh_review = $_REQUEST['inh_review'];
	$int_review = $_REQUEST['int_review'];
	$adms_review = $_REQUEST['adms_review'];
	$accommodationOnly = $_REQUEST['accommodationonly'];
	//echo $length;
	if ($length<=100)
	{
		$query2 = "select * from master_bed where bed = '$bed' and ward = '$ward'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_num_rows($exec2);
		if ($res2 == 0)
		{
			$query1 = "insert into master_bed (bed, ward, ipaddress, recorddate,locationname,locationcode,username,threshold,bedcharges,nursingcharges,rmocharges,accommodationcharges,cafetariacharges,inh_review,int_review,adms_review,accommodationOnly ) 
			values ('$bed','$ward', '$ipaddress', '$updatedatetime','$selectedlocation','$selectedlocationcode', '$username','$threshold','$bedcharges','$nursingcharges','$rmocharges','$accommodationcharges','$cafetariacharges','$inh_review','$int_review','$adms_review','$accommodationOnly')";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$errmsg = "Success. New bed Updated.";
			$bgcolorcode = 'success';
			
			for($i=1;$i<10;$i++)	
				{
				if($i == 1)
				{
				$charge="Bed Charges";
				$rate = $bedcharges;
				
					}
				if($i == 2)
				{
				$charge="Nursing Charges";
				$rate = $nursingcharges;
				}
				if($i == 3)
				{
				//$charge="RMO Charges";
				$charge="Daily Review charge";
				$rate = $rmocharges;
			
				}
				if($i == 4)
				{
				 $charge="Accommodation Charges";
				 $rate = $accommodationcharges;
			
				}
				if($i == 5)
				{
				$charge="Cafetaria Charges";
				$rate = $cafetariacharges;
			
				}
				if($i == 6)
				{
				//$charge="Inhouse Specialist Review";
				$charge="Consultant Fee";
				$rate = $inh_review;
			
				}
				if($i == 7)
				{
				$charge="Intensivist Review";
				$rate = $int_review;
			
				}
				if($i == 8)
				{
				$charge="Admitting Specialist Review";
				$rate = $adms_review;
			
				}
				if($i == 9)
				{
				$charge="Accommodation Only";
				$rate = $accommodationOnly;
			
				}
				
				if($rate == '')
				{
				$rate = 0.00;
				}
		
			$chargequery1="insert into master_bedcharge(bed,bedanum,charge,rate,ipaddress,recorddate,locationname,locationcode,username,ward)values('$bed','$bedanum1','$charge','$rate','$ipaddress','$date','$selectedlocation','$selectedlocationcode','$username','$ward')";
			$chargeexecquery1=mysqli_query($GLOBALS["___mysqli_ston"], $chargequery1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			
		}
		//exit();
		else
		{
			$errmsg = "Failed. bed Already Exists.";
			$bgcolorcode = 'failed';
		}
		$query10 = "select * from master_testtemplate where testname = 'bedcharge' and referencetable!='' order by templatename";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res10 = mysqli_fetch_array($exec10))
		{
			$bedchargetemplate = $res10["templatename"];
			$bedtemplate = $res10["referencetable"];
			
			$query2 = "select * from $bedtemplate where bed = '$bed' and ward = '$ward'";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2 = mysqli_num_rows($exec2);
			if ($res2 == 0)
			{
				$query1 = "insert into $bedtemplate (bed, ward, ipaddress, recorddate,locationname,locationcode,username,threshold,bedcharges,nursingcharges,rmocharges,accommodationcharges,cafetariacharges) 
				values ('$bed','$ward', '$ipaddress', '$updatedatetime','$selectedlocation','$selectedlocationcode', '$username','$threshold','$bedcharges','$nursingcharges','$rmocharges','$accommodationcharges','$cafetariacharges')";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$errmsg = "Success. New bed Updated.";
				$bgcolorcode = 'success';
				
				for($i=1;$i<6;$i++)	
					{
					if($i == 1)
					{
					$charge="Bed Charges";
					$rate = $bedcharges;
					
						}
					if($i == 2)
					{
					$charge="Nursing Charges";
					$rate = $nursingcharges;
					}
					if($i == 3)
					{
					//$charge="RMO Charges";
					$charge="Daily Review charge";
					$rate = $rmocharges;
				
					}
					if($i == 4)
					{
					$charge="Accommodation Charges";
					$rate = $accommodationcharges;
				
					}
					if($i == 5)
					{
					$charge="Cafetaria Charges";
					$rate = $cafetariacharges;
				
					}
					
					if($rate == '')
					{
					$rate = 0.00;
					}
			
				$chargequery1="insert into $bedchargetemplate(bed,bedanum,charge,rate,ipaddress,recorddate,locationname,locationcode,username,ward)values('$bed','$bedanum1','$charge','$rate','$ipaddress','$date','$selectedlocation','$selectedlocationcode','$username','$ward')";
				$chargeexecquery1=mysqli_query($GLOBALS["___mysqli_ston"], $chargequery1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				
			}
			//exit();
			else
			{
				$errmsg = "Failed. bed Already Exists.";
				$bgcolorcode = 'failed';
			}
		}
	}
	else
	{
		$errmsg = "Failed. Only 100 Characters Are Allowed.";
		$bgcolorcode = 'failed';
	}
}
if (isset($_REQUEST["bedtemp"])) { $bedtemp = $_REQUEST["bedtemp"]; } else { $bedtemp = "master_bed"; }
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update $bedtemp set recordstatus = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update $bedtemp set recordstatus = '' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'default')
{
	$delanum = $_REQUEST["anum"];
	$query4 = "update $bedtemp set defaultstatus = '' where cstid='$custid' and cstname='$custname'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$query5 = "update $bedtemp set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'removedefault')
{
	$delanum = $_REQUEST["anum"];
	$query6 = "update $bedtemp set defaultstatus = '' where auto_number = '$delanum'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add bed To Proceed For Billing.";
	$bgcolorcode = 'failed';
}
$query1bed = "select * from master_bed where recordstatus <> 'deleted' order by bed ";
$exec1bed = mysqli_query($GLOBALS["___mysqli_ston"], $query1bed) or die ("Error in Query1bed".mysqli_error($GLOBALS["___mysqli_ston"]));
$nums1bed = mysqli_num_rows($exec1bed);
$remainbed = $licensedbed - $nums1bed;
?>
<!-- Inline styles moved to external CSS file -->
<!-- External CSS and JavaScript files moved to head section -->
<!-- Inline JavaScript moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->
					
<!-- JavaScript functions moved to external JS file --> 
<!-- JavaScript functions moved to external JS file -->
		
<!-- JavaScript functions moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->
	
<!-- JavaScript functions moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->
	
	
<!-- JavaScript functions moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->
	
	
<!-- JavaScript functions moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->
<!-- JavaScript functions moved to external JS file --> 
<!-- JavaScript functions moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->
		
<!-- JavaScript functions moved to external JS file -->
<!-- JavaScript functions moved to external JS file -->
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" ><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" ><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" ><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td><form name="form1" id="form1" method="post" action="addbed.php" onSubmit="return addbedprocess1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan=""   class="bodytext3"><strong>Bed Master - Add New  &nbsp;
						Licensed Beds:<?php echo $licensedbed; ?>&nbsp;<span style="margin-left:10px">Remaining Beds:<?php echo $remainbed; ?></span></strong>
						<input type="hidden" name="licensedbed" id="licensedbed" value="<?php echo $licensedbed; ?>">
						<input type="hidden" name="remainbed" id="remainbed" value="<?php echo $remainbed; ?>">
						</td>
                        
                        <td  align="right"  class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                  <?php
						
						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						
						?>
						
						
                  
                  </td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      				<tr>
                <td width="58%" align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><span class="bodytext32">Location   *</span></td>
                <td width="42%" align="left" valign="middle"  bgcolor="#FFFFFF">
                <select name="location" id="location" onChange=" funcSubTypeChange1(); ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">
                						<option value="">Select</option>
                  <?php
						$query1 = "select * from master_location where status <> 'deleted' order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationanum; ?>"><?php echo $res1location; ?></option>
						<?php
						}
						?>
                </select>
                </td>
				</tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
						<div align="right">Select Ward </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="ward" id="ward">
                          <option value=""> Select Ward</option>
						  <?php
						if ($wardanum != '')
						{
						?>
                    <option value="<?php echo $wardanum; ?>" selected="selected"><?php echo $wardfullname; ?></option>
                    <?php
						}
						else
						{
						?>
                    <option value="" selected="selected">Select Ward</option>
                    <?php
						}
						$query1 = "select * from master_ward where recordstatus <> 'deleted'";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						/* while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1ward = $res1["ward"];
						$res1anum = $res1['auto_number'];
						
						?>
                    <option value="<?php echo $res1anum; ?>"><?php echo $res1ward; ?></option>
                    <?php
						} */
						?>
           
                        </select></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New Bed </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="bed" id="bed" style="border: 1px solid #001E6A; text-transform:uppercase;" size="40" />
						<input type="hidden" name="bedanum" id="bedanum" value="<?php echo $anum; ?>"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Non Pharms *</div></td>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
						<input name="accommodationcharges" id="accommodationcharges" style="border: 1px solid #001E6A;" size="10" onKeyPress="return keypressdigit(event)" onKeyUp="" /></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Meals *</div></td>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
						<input name="cafetariacharges" id="cafetariacharges" style="border: 1px solid #001E6A;" onKeyPress="return keypressdigit(event)" onKeyUp="" size="10" /></td>
                      </tr>                      
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Bed Charges</div></td>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
						<input name="bedcharges" id="bedcharges"  style="border: 1px solid #001E6A;" size="10" value="0" /></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Nursing Care</div></td>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
						<input name="nursingcharges" id="nursingcharges" style="border: 1px solid #001E6A;" size="10" /></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Daily Review</div></td>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
						<input name="rmocharges" id="rmocharges" style="border: 1px solid #001E6A;" size="10" /></td>
                      </tr>
						<tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Consultant Fee</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="inh_review" id="inh_review" style="border: 1px solid #001E6A;" size="10" value="" /></td>
                      </tr>
					 <!-- <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Intensivist Review</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="int_review" id="int_review" style="border: 1px solid #001E6A;" size="10" value=""/></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Admitting Specialist Review</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="adms_review" id="adms_review" style="border: 1px solid #001E6A;" size="10" value=""/></td>
                      </tr>-->
					  <input type="hidden" name="int_review" id="int_review"  size="10" value=""/>
					  <input type="hidden" id="adms_review"  size="10" value=""/>
					  
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Accommodation Only</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="accommodationonly" id="accommodationonly" style=" background-color:#ecf0f5;" size="10" value="0.00" readonly/></td>
                      </tr>
					  
			    <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Threshold</div></td>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
						<input name="threshold" id="threshold" style="border: 1px solid #001E6A;" size="10" />in %</td>
                      </tr>
                    <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Bed Template</div></td>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
                        <select name="bedtemp" id="bedtemp"  style="border: 1px solid #001E6A;">
					
						<option value="" selected="selected">Select Bedcharge</option>
						
						<option value="master_bedcharge" >Master BedCharges</option>						
						<?php
							$query10 = "select * from master_testtemplate where testname = 'bedcharge' order by templatename";
							$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
							while ($res10 = mysqli_fetch_array($exec10))
							{							
								echo $templatename = $res10["templatename"];
								if($templatename != $bedtemplate)
								{
								?>
								<option value="<?php echo $templatename; ?>"><?php echo $templatename; ?></option>
								<?php
								}
							}
						?>
                        </select>
						
						
						</td>
               </tr>
				<!-- <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Grace </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="grace" id="grace" style="border: 1px solid #001E6A;" size="10" /></td>
                      </tr>-->      
				<tr>
                        <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
                          <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" /></td>
                      </tr>
                      <tr>
                        <td align="middle" colspan="2" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                   </form>
                <table width="700" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                       <form action="addbed.php" method="post" name="bedsearch" id="bedsearch">
                      <tr bgcolor="#011E6A">
                        
						  <td colspan="13" bgcolor="#FFFFFF" class="bodytext3">
						<select name="bedtemplate" id="bedtemplate"  style="border: 1px solid #001E6A;">
						<?php
						if($bedtemplate!='')
						{?>
						<option value="<?php echo $bedtemplate; ?>"><?php echo $bedtemplate; ?></option>
						<?php }
						if($bedtemplate != 'master_bed'){
						?>
						<option value="master_bed" >Master Bed</option>						
						<?php
						}
							$query10 = "select * from master_testtemplate where testname = 'bedcharge' and referencetable!='' order by templatename";
							$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
							while ($res10 = mysqli_fetch_array($exec10))
							{							
								$templatename = $res10["referencetable"];
								if($templatename != $bedtemplate)
								{
								?>
								<option value="<?php echo $templatename; ?>"><?php echo $templatename; ?></option>
								<?php
								}
							}
						?>
                        </select>
						
						<select name="searchward" id="searchward">
						<option value="" >All Ward</option>
						<?php
						$query1 = "select * from master_ward where recordstatus <> 'deleted' order by ward asc";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1ward = $res1["ward"];
						$res1anum = $res1['auto_number'];
						?>
						<option value="<?php echo $res1anum; ?>" <?php if($searchward==$res1anum){ echo 'selected'; } ?>><?php echo $res1ward; ?></option>
						<?php
						}
						?>
						</select>
						<select name="searchlocation" id="searchlocation"   style="border: 1px solid #001E6A;">
						<option value="">All</option>
						<?php
						$query1 = "select * from master_location where status <> 'deleted' order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationanum; ?>" <?php if($searchlocation==$res1locationanum){ echo 'selected'; } ?>><?php echo $res1location; ?></option>
						<?php
						}
						?>
						</select>
                          <input type="submit" id="Submit2" name="Submit2" value="Search" style="border: 1px solid #001E6A" /></td>
                        </tr>
                      </form>    
				<?php
				if(isset($_POST['Submit2']) == 'Search')
				{
				$bedtemp=  $_REQUEST['bedtemplate'];
				$searchward=  $_REQUEST['searchward'];

				?>  
				<tr bgcolor="#011E6A">
				<td colspan="3"  class="bodytext3"><strong>bed Bed - Existing List </strong></td>
				<td width=""  class="bodytext3"><strong>ward</strong></td>
				<td width=""  class="bodytext3"><strong>Template</strong></td>
				<td width=""  class="bodytext3"><strong>Location</strong></td>
				<td width=""  class="bodytext3"><strong>Edit</strong></td>
				</tr>
				<?php
				if($searchward==''){
				$ward="and ward like '%%'";	
				} else {
				$ward="and ward = '$searchward'";	
				}
				
				if($searchlocation==''){
				$lct="and locationcode like '%%'";	
				} else {
				$lct="and locationcode = '$searchlocation'";	
				}
				
				$query1 = "select * from $bedtemp where recordstatus <> 'deleted' $ward $lct order by ward ";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res1 = mysqli_fetch_array($exec1))
				{
				$bed = $res1["bed"];
				$ward = $res1['ward'];
				$res1locationname = $res1['locationname'];
				$auto_number = $res1["auto_number"];

				$query55 = "select * from master_ward where auto_number='$ward'";
				$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res55 = mysqli_fetch_array($exec55);
				$wardfullname = $res55['ward'];

				//$defaultstatus = $res1["defaultstatus"];
				$colorloopcount = $colorloopcount + 1;
				$showcolor = ($colorloopcount & 1); 
				if ($showcolor == 0)
				{
				$colorcode = 'bgcolor="#CBDBFA"';
				}
				else
				{
				$colorcode = '';
				}

				?>
				<tr <?php echo $colorcode; ?>>
				<td width="" align="left" valign="top"  class="bodytext3"><?php echo $colorloopcount; ?></td>
				<td width="" align="left" valign="top"  class="bodytext3"><div align="center"><a href="addbed.php?st=del&&anum=<?php echo $auto_number; ?>&&bedtemp=<?= $bedtemp ?>" onClick="return funcDeletebed('<?php echo $bed ?>')"><img src="images/b_drop.png" width="16" height="16" border="0" /></a>	</div>	</td>
				<td width="" align="left" valign="top"  class="bodytext3"><?php echo $bed; ?> </td>
				<td align="left" valign="top"  class="bodytext3"><?php echo $wardfullname; ?> </td>
				<td align="left" valign="top"  class="bodytext3"><?php echo strtoupper($bedtemp); ?> </td>
				<td align="left" valign="top"  class="bodytext3"><?php echo $res1locationname; ?> </td>
				<td align="left" valign="top"  class="bodytext3">
				<a href="editbed.php?st=edit&&anum=<?php echo $auto_number; ?>&&bedtemp=<?= $bedtemp ?>" style="text-decoration:none">Edit</a></td>
				</tr>
				<?php
				}
				?>
			<tr>
			<td align="middle" colspan="4" >&nbsp;</td>
			</tr>
            </tbody>
	</table>
  
			<table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
			<tbody>
			<tr bgcolor="#011E6A">
			<td colspan="5"  class="bodytext3"><strong>Bed Master - Deleted </strong></td>
			</tr>
			<?php
			$colorloopcount = '';
			$query1 = "select * from $bedtemp where recordstatus = 'deleted' order by bed ";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$bed = $res1['bed'];
			$ward = $res1['ward'];
			$res1locationname = $res1['locationname'];
			$auto_number = $res1["auto_number"];

			$query55 = "select * from master_ward where auto_number='$ward'";
			$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res55 = mysqli_fetch_array($exec55);
			$wardfullname = $res55['ward'];

			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
			$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
			$colorcode = '';
			}
			?>
			<tr <?php echo $colorcode; ?>>
			<td width="5%" align="left" valign="top"  class="bodytext3"><?php echo $colorloopcount; ?></td>
			<td width="10%" align="left" valign="top"  class="bodytext3">
			<a href="addbed.php?st=activate&&anum=<?php echo $auto_number; ?>&&bedtemp=<?= $bedtemp ?>" class="bodytext3" onClick="return funcactivatebed()">
			<div align="center" class="bodytext3">Activate</div>
			</a></td>
			<td width="35%" align="left" valign="top"  class="bodytext3"><?php echo $bed; ?></td>
			<td width="25%" align="left" valign="top"  class="bodytext3"><?php echo $wardfullname; ?></td>
			<td width="25%" align="left" valign="top"  class="bodytext3"><?php echo $res1locationname; ?></td>
			</tr>
			<?php
			}
			}
			?>
			<tr>
			<td align="middle" colspan="3" >&nbsp;</td>
			</tr>
			</tbody>
			</table>
            
                </td>
        </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
  </table>
<footer>
  <?php include ("includes/footer1.php"); ?>
</footer>
</main>
</body>
</html>