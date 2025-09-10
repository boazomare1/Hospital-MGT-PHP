<?php 
session_start();
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");

$errmsg = "";
$bgcolorcode = "";
$pagename = "";
$consultationfees1 = '';
$availablelimit = '';
$mrdno = '';
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$sno = '';


if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
$ipaddress = $_SERVER["REMOTE_ADDR"];
$username = $_SESSION['username'];
	
$querynw1 = "select * from resultentry_lab where patientcode = '$searchpatientcode' and patientvisitcode ='$searchvisitcode' and patientname ='$searchpatient' and recorddate between '$fromdate' and '$todate' and docnumber = '$docnumber' group by docnumber order by auto_number desc";

			$execnw1 = mysql_query($querynw1) or die ("Error in Query1".mysql_error());
			$resnw1=mysql_num_rows($execnw1);
}


if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["patientcode"]))
{
$querylab1=mysql_query("select * from master_customer where customercode='$patientcode'");
$execlab1=mysql_fetch_array($querylab1);
$patientname=$execlab1['customerfullname'];
}
else
{
$patientname = '';
}
?>
<style type="text/css">

body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.ui-menu .ui-menu-item{ zoom:1 !important; }
</style>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>

<link href="autocomplete.css" rel="stylesheet">

<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/autocustomercodesearch2.js"></script>

<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script type="text/javascript" src="js/visitentrypatientcodevalidation1.js"></script>

<script src="js/datetimepicker_css.js"></script>
<script>

$(function() {
	
$('#customer').autocomplete({
		
	source:'ajaxcustomernewserach.php', 
	//alert(source);
	minLength:3,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var code = ui.item.id;
			var customercode = ui.item.customercode;
			var accountname = ui.item.accountname;
			$('#customercode').val(customercode);
			$('#accountnamename').val(accountname);
			$('#patientcode').val(customercode);
			
			//funcCustomerSearch2();
			
			},
    });
});



</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.style1 {font-weight: bold}
.style2 {font-weight: bold}
.style3 {font-weight: bold}
.style4 {font-weight: bold}
-->
</style>
<body >
</script>

<table width="101%" border="0" cellspacing="0" cellpadding="2">
	<tr>
		<td colspan="3" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
	</tr>
	<tr>
		<td colspan="3" bgcolor="#ECF0F5"><?php include ("includes/title1.php"); ?></td>
	</tr>
	<tr>
		<td colspan="3" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); //	include ("includes/menu2.php");?></td>
	</tr>
	<tr>
		<td width="1%">&nbsp;</td>
		<td colspan="2" width="99%" valign="top">
	
			<table width="80%" border="1" cellspacing="0" cellpadding="0">
			<form name="form1" id="form1" method="post" action="vitalsummary.php" onKeyDown="return disableEnterKey(event)" onSubmit="return process1()">
			<tr>
				<td width="1000">
					<table width="960" height="128" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
					<tbody>
						<tr bgcolor="#011E6A">
							<td height="21" colspan="4" bgcolor="#ecf0f5" class="bodytext3">
								<strong> Vitals Summary </strong>
							</td>
						</tr>
						<tr bgcolor="#011E6A">     
               
							<td colspan="4" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation">
								<strong> 
									Search Sequence : First Name | Middle Name | Last Name | Date of Birth | Location | Mobile Number | National ID | Registration No   (*Use "|" symbol to skip sequence)
								</strong>
							</td>
						</tr>
						<tr>
							<td width="13%" height="32" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
								<strong> Patient Search </strong>
							</td>
							<td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
							<span class="bodytext32">
								<input name="customer" id="customer" size="60" autocomplete="off" value="<?php echo $patientname; ?>"/>
							    <input name="customerhiddentextbox" id="customerhiddentextbox" value="" type="hidden" />
								<input name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>" type="hidden" />
								<input name="nationalid" id="nationalid" value = "" type = "hidden" />
								<input name="accountnames" id="accountnames" value="" type="hidden" />
								<input name = "mobilenumber111" id="mobilenumber111" value="" type="hidden" />
								<input type="hidden" name="recordstatus" id="recordstatus" />
								<input type="hidden" name="billnumbercode" id="billnumbercode" value="<?php echo $billnumbercode; ?>" readonly style="border: 1px solid #001E6A;" />
							</span>
							</td>
						</tr>
						<tr>
							<td height="32" align="left" valign="center" bgcolor="#ffffff" class="bodytext3">
								<strong> Date From </strong>
							</td>
							<td width="15%" align="left" valign="center"  bgcolor="#ffffff" class="bodytext3">
								<input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
								<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>
							</td>
							<td width="10%" align="left" valign="center"  bgcolor="#FFFFFF" class="style1">
								<span class="bodytext3"><strong> Date To </strong></span>
							</td>
							<td width="62%" align="left" valign="center"  bgcolor="#ffffff">
								<span class="bodytext3">
									<input name="ADate2" id="ADate2"  value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
									<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> 
								</span>
							</td>
						</tr>
						<tr>
							<td height="32" align="left" valign="center" bgcolor="#ffffff" class="bodytext3">&nbsp;</td>
							<td colspan="3" align="left" valign="center"  bgcolor="#ffffff" class="bodytext3">
								<input type="hidden" name="cbfrmflag1" value="cbfrmflag1" />
								<input  type="submit" value="Search" name="Submit" />
								<input name="resetbutton" type="reset" id="resetbutton" value="Reset" />
							</td>
						</tr>
					</tbody>
					</table>
				</td>
			</tr>	
			</form>		
			</table>
			
			<?php
				$colorloopcount=0;
				$sno=0;
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
					//$cbfrmflag1 = $_POST['cbfrmflag1'];
					if ($cbfrmflag1 == 'cbfrmflag1')
					{
						$searchpatient = $_POST['customer'];
						$searchpatientcode=$_REQUEST['patientcode'];
						$fromdate=$_POST['ADate1'];
						$todate=$_POST['ADate2'];
			?>
			<table  bordercolor="#666666" cellspacing="0" cellpadding="4" width="80%" align="left" border="0">
                <tr>
					<td colspan="3" class="bodytext3" nowrap="nowrap">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="3" class="bodytext3" bgcolor="#ecf0f5" nowrap="nowrap">
						<div align="left">
							<strong>Vitals Summary Details </strong>
						</div>
					</td>
				</tr>
				<tr>
				    <td class="bodytext3" colspan="2">
						<div align="center">
							<span class="style4">
								<?php	echo $searchpatient.' - '.$searchpatientcode; ?>
							</span>					
						</div>					
					</td>
					<td width="77">&nbsp;</td>
                </tr>
				<tr>
                    <td width="280" bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code </strong></td>
                    <td width="160" bgcolor="#ecf0f5" class="bodytext3"><strong>Date</strong></td>
					<td  width="160" bgcolor="#ecf0f5">&nbsp;</td>
                </tr>
				<?php
					$query1 = "select * from master_ipvisitentry where patientcode = '$searchpatientcode' order by auto_number desc";
					$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
					while ($res1 = mysql_fetch_array($exec1))
					{
						$ipvisitcode = $res1['visitcode'];
						$ipvisitdate = $res1['consultationdate'];
				  
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
							$colorcode = 'bgcolor="#CBDBFA"';
						}
				  ?>
				<tr <?php echo $colorcode; ?>>
					<td bgcolor="#ffffff" class="bodytext3">
						<a target="_blank" href="ipemrview.php?patientcode=<?php echo $searchpatientcode; ?>&&visitcode=<?php echo $ipvisitcode; ?>"><strong><?php echo $ipvisitcode; ?></strong>
						</a>
					</td>
                    <td bgcolor="#ffffff" class="bodytext3"><?php echo $ipvisitdate; ?>&nbsp;</td>
					<td bgcolor="#ffffff">&nbsp;</td>
					
				<?php 
					} 
				?>
				</tr>	
				<tr>
				<?php
					$query1 = "select * from master_visitentry where patientcode = '$searchpatientcode' and consultationdate between '$fromdate' and '$todate' order by auto_number desc";
					$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
					while ($res1 = mysql_fetch_array($exec1))
					{
						$visitcode = $res1['visitcode'];
						$visitdate = $res1['consultationdate'];
				?>
                 
                <tr>
				<?php 
					if($searchpatient!= '') { 
				?> 
                    <td bgcolor="#ffffff" class="bodytext3"><?php echo $visitcode; ?>&nbsp;</td>
                    <td bgcolor="#ffffff" class="bodytext3"><?php  $visitdate; ?>&nbsp;</td>
					<td bgcolor="#ffffff" class="bodytext3"> &nbsp;</td>
                <?php } ?>
				</tr>

				<tr>
					<td colspan="3" class="bodytext3" nowrap="nowrap">
						<table width="1000" height="40" border="1" bgcolor="#ecf0f5">
						<tr >
							<td align="center" valign="middle" bgcolor="#ecf0f5" colspan="3" class="bodytext3" >
								<strong > Blood Pressure </strong> 
							</td>
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								&nbsp;
							</td>							
							<td align="center" valign="middle" bgcolor="#ecf0f5" colspan="2" class="bodytext3" >
								<strong > Temp </strong>
							</td>
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								&nbsp;
							</td>
							<td align="center" valign="middle" bgcolor="#ecf0f5" colspan="2" class="bodytext3" >
								<strong > Pulse </strong>
							</td>
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								&nbsp;
							</td>							
							<td align="center" valign="middle" bgcolor="#ecf0f5" colspan="2" class="bodytext3" >
								<strong > Weight </strong>
							</td>
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								&nbsp;
							</td>
						</tr>
						<tr >
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								<strong > Date </strong>
							</td>
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								<strong > Systolic </strong> 
							</td>
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								<strong > Diastolic </strong>
							</td>
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								&nbsp;
							</td>							
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								<strong > Temp </strong>
							</td>
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								&nbsp;
							</td>							
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								<strong > Date </strong>
							</td>
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								<strong > Pulse </strong>
							</td>
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								&nbsp;
							</td>							
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								<strong > Date </strong>
							</td>
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								<strong > Weight </strong>
							</td>
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								&nbsp;
							</td>							

						</tr>						
					<?php

								$query19="select * from master_triage where visitcode = '$visitcode'";
								$exec19=mysql_query($query19);
								$res19=mysql_fetch_array($exec19);
								$user = $res19['user'];
								$height = $res19['height'];
								$weight = $res19['weight'];
								$bmi = $res19['bmi'];
								$bpsystolic = $res19['bpsystolic'];
								$bpdiastolic = $res19['bpdiastolic'];
								$respiration = $res19['respiration'];
								$pulse = $res19['pulse'];
								$celsius = $res19['celsius'];
								$spo2 = $res19['spo2'];
								$intdrugs = $res19['intdrugs'];
								$dose = $res19['dose'];
								$route = $res19['route'];
								
								$colorloopcount = $colorloopcount + 1;
								$showcolor = ($colorloopcount & 1); 
								if ($showcolor == 0)
								{
									//echo "if";
									$colorcode = 'bgcolor="#FFFFFF"';
								}
								else
								{
									//echo "else";
									$colorcode = 'bgcolor="#FFFFFF"';
								}
					?>
					
						<tr >
							<td class="bodytext3" valign="center"  align="left">
								<div align="center">
									<?php echo $visitdate ; ?>
								</div>
							</td>
							<td class="bodytext3" valign="center"  align="left">
								<div align="center">
									<?php echo $visitdate ; ?>
								</div>
							</td>
							<td class="bodytext3" valign="center"  align="left">
								<div align="center">
									<?php echo $visitdate ; ?>
								</div>
							</td>
							<td class="bodytext3" valign="center"  align="left">
								<div align="center">
									<?php echo $visitdate ; ?>
								</div>
							</td>
							<td class="bodytext3" valign="center"  align="left">
								<div align="center">
									<?php echo $visitdate ; ?>
								</div>
							</td>
							<td class="bodytext3" valign="center"  align="left">
								<div align="center">
									<?php echo $visitdate ; ?>
								</div>
							</td>
							<td class="bodytext3" valign="center"  align="left">
								<div align="center">
									<?php echo $visitdate ; ?>
								</div>
							</td>
							<td class="bodytext3" valign="center"  align="left">
								<div align="center">
									<?php echo $visitdate ; ?>
								</div>
							</td>
							<td class="bodytext3" valign="center"  align="left">
								<div align="center">
									<?php echo $visitdate ; ?>
								</div>
							</td>							
							<td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $bpdiastolic ; ?></div></td>
							<td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $pulse ; ?></div></td>
							<td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $height ; ?></div></td>
							<td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $weight ; ?></div></td>
							<td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $respiration ; ?></div></td>
							<td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $celsius ; ?></div></td>
							<td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $dose ; ?></div></td>

							<td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $user ; ?></div></td>							<td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $route ; ?></div></td>
						
							<!-- <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $date ; ?></div> </td>
							<td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $vcode ; ?></div></td>
							 	<td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $spo2 ; ?></div></td>  <td class="bodytext3" valign="center"  align="left"><div align="center"><a target="_blank" href="emrcasesheet.php?visitcode=<?php echo $vcode;?>">View</a></div></td> -->
						</tr> 
						</table>
					</td>
				</tr>	
			<?php 
				} 
			?>				
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</table>
			<?php
					}
			?> 
		</td>
	</tr>
</table>	
<?php include ("includes/footer1.php"); ?>
</body>
</html>