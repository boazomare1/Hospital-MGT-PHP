<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $ADate2;

$docno = $_SESSION['docno'];

 //get location for sort by location purpose
   $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		  $locationcode=$location;
		}
		//location get end here
//$locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';
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
.number
{
padding-left:650px;
text-align:right;
font-weight:bold;
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


function cbcustomername1()
{
	document.cbform1.submit();
}

</script>

<script type="text/javascript">

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

</script>
<script src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<body>

<table width="103%" border="0" cellspacing="0" cellpadding="2"><!--maintable  -->
<tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
</tr>
<tr>
   <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
</tr>
<tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
</tr>
<tr>
    <td colspan="9">&nbsp;</td>
</tr>
<tr><!--maintable5throwstart  -->
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><!--maintable2tdstarthere  -->
	   <table width="105%" border="0" cellspacing="0" cellpadding="0"><!--2ndtablestarthere  -->
	
	      
		  <tr><!--2ndtable-1strow start here  -->
				<td width="860"><!--2ndtable-1sttd start here  -->
					<form name="cbform1" method="post" action="patientweiverslist1.php">
<!--3rd table start here --><table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
						<tbody><!--3rd table tbody start here -->
							<tr><!--3rd table 1st row start here -->
								<td align="left" bgcolor="#ecf0f5" class="bodytext3" colspan="2"><strong>Patient Weiver List </strong></td>
								<td colspan="2" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
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
							</tr><!--3rd table 1st row end here -->
							<tr><!--3rd table 2nd row start here -->
							<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
							<td  bgcolor="#FFFFFF" class="bodytext3"  colspan="3" ><select name="location" id="location" onChange=" ajaxlocationfunction(this.value);" style="border: 1px solid #001E6A;">
							<?php
							
							$query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
							$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
							while ($res = mysqli_fetch_array($exec))
							{
							$reslocation = $res["locationname"];
							$reslocationanum = $res["locationcode"];
							?>
							<option value="<?php echo $reslocationanum; ?>" <?php if($location!='')if($location==$reslocationanum){echo "selected";}?>><?php echo $reslocation; ?></option>
							<?php
							}
							?>
							</select></td>
                   
							<input type="hidden" name="locationnamenew" value="<?php echo $locationname; ?>">
							<input type="hidden" name="locationcodenew" value="<?php echo $res1locationanum; ?>">
             
							</tr><!--3rd table 2nd row end here -->
							<tr>
								<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
								<td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
								<input name="patient" type="text" id="patient" value="" size="50" autocomplete="off">
								</span></td>
							</tr>
							<tr>
								<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Registration No</td>
								<td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
								<input name="patientcode" type="text" id="patient" value="" size="50" autocomplete="off">
								</span></td>
							</tr>
							<tr>
								<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visitcode</td>
								<td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
								<input name="visitcode" type="text" id="visitcode" value="" size="50" autocomplete="off">
								</span></td>
							</tr>
							<tr>
								<td width="100" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong>
								</td>
								<td width="137" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
								<input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
								<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			
								</td>
								<td width="68" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
								<td width="263" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
								<input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
								<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
								</span></td>
							</tr>
					
				
							<tr>
								<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
								<td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
									<input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
									<input  type="submit" value="Search" name="Submit" />
									<input name="resetbutton" type="reset" id="resetbutton"  value="Reset" />
								</td>
							</tr>
						</tbody><!--3rd table tbody end here -->
					</table><!--3rd table end here -->
					</form>	<!--3rd table form end here -->	
				</td><!--2ndtable-1sttd end here  -->
			</tr><!--2ndtable-1st tr end here  -->
			<tr><!--2ndtable-2nd tr start here  -->
				<td colspan="9">&nbsp;</td>
			</tr>
					<?php
							$colorloopcount=0;
							$sno=0;
						if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
						//$cbfrmflag1 = $_POST['cbfrmflag1'];
						if ($cbfrmflag1 == 'cbfrmflag1')
						{
						$searchpatient = $_POST['patient'];
						$searchpatientcode=$_POST['patientcode'];
						$searchvisitcode = $_POST['visitcode']; 
					
						$fromdate=$_POST['ADate1'];
						$todate=$_POST['ADate2'];
	
					?>
			<tr><!--2ndtable-3rd tr start here  -->   
						<td width="99%" valign="top"><!--2ndtable-3rd tr 1st td start here  --> 
						   <table width="116%" border="0" cellspacing="0" cellpadding="0"><!--3rdtable start here  --> 
								<tr><!--3rdtable 1st tr start here  --> 
									<td><!--3rdtable 1st td start here  --> 
	<!--4rth table   start here  -->	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
												bordercolor="#666666" cellspacing="0" cellpadding="4" width="921" align="left" border="0">
											<tbody><!--4rth table tbody  start here  -->
													<tr><!--4rth table 1st tr  start here  -->
															<td colspan="9" bgcolor="#ecf0f5" class="bodytext31">
																<strong> Patient List</strong>
															</td>
											  </tr>
											<tr>
											  <td width="4%"  align="left" valign="center" 
												bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>No.</strong></div></td>
												 <td width="11%"  align="left" valign="center" 
												bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>OP Date </strong></div></td>
											  <td width="9%"  align="left" valign="center" 
												bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Reg.No</strong></div></td>
											  <td width="10%"  align="left" valign="center" 
												bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Visit No </strong></div></td>
											  <td width="20%"  align="left" valign="center" 
												bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient </strong></div></td>
											  <td width="17%"  align="left" valign="center" 
												bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Subtype </strong></div></td>
											  <td width="17%"  align="left" valign="center" 
												bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Account</strong></div></td>
											  <td width="12%"  align="left" valign="center" 
												bgcolor="#ffffff" class="bodytext31"><strong>Action</strong></td>
											  </tr>
				
												<?php
												$sno = '';
											$query31=mysqli_query($GLOBALS["___mysqli_ston"], "select patientcode,subtype,visitcode,patientfullname,consultingdoctor,consultationdate from master_visitentry where  locationcode = '".$locationcode."' and billtype='PAY LATER' and overallpayment='' and patientfullname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and consultationdate between '$fromdate' and '$todate' order by auto_number desc") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
											while($exec31=mysqli_fetch_array($query31))
											{
											$patientcode = $exec31['patientcode'];
											$subtypeanum = $exec31['subtype'];
											
											$query321 = "select subtype from master_subtype where auto_number = '$subtypeanum'";
											$exec321 = mysqli_query($GLOBALS["___mysqli_ston"], $query321) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
											$res321 = mysqli_fetch_array($exec321);
											$subtype = $res321['subtype'];
											
											$query39=mysqli_query($GLOBALS["___mysqli_ston"], "select accountname from master_customer where customercode='$patientcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
											$res39=mysqli_fetch_array($query39);
											$accname=$res39['accountname'];
											
											$query40=mysqli_query($GLOBALS["___mysqli_ston"], "select accountname from master_accountname where auto_number='$accname'");
											$res40=mysqli_fetch_array($query40);
											$accountname=$res40['accountname'];
											$patientvisitcode=$exec31['visitcode'];
											$patientname=$exec31['patientfullname'];
											$consultingdoctor = $exec31['consultingdoctor'];
											
											$query33=mysqli_query($GLOBALS["___mysqli_ston"], "select doctorname from master_doctor where auto_number='$consultingdoctor'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
											$exec33=mysqli_fetch_array($query33);
											$consultingdoctorname=$exec33['doctorname'];
											
											$query34=mysqli_query($GLOBALS["___mysqli_ston"], "select accountname from master_consultation where patientvisitcode='$patientvisitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
											$exec34=mysqli_fetch_array($query34);
											$accname=$exec34['accountname'];
											$consultationdate=$exec31['consultationdate'];
											$consultationfees=number_format(0,2,'.','');
											$query32=mysqli_query($GLOBALS["___mysqli_ston"], "select amount from master_consultation where patientvisitcode='$patientvisitcode'");
											while($exec32=mysqli_fetch_array($query32))
											{
											 $consultationfees=$consultationfees+$exec32['amount'];
											$consultationfees=number_format($consultationfees,2,'.','');
											}
											
											$query65 = "select * from billing_paylater where visitcode='$patientvisitcode'";
											$exec65 = mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
											$num65 = mysqli_num_rows($exec65);
											if($num65 == 0)
											{
											
											$query66 = "SELECT visitcode FROM patientweivers where visitcode = '$patientvisitcode'";
											$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
											$row66 = mysqli_num_rows($exec66);
											if($row66 == 0)
											{
	
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
												<div align="center"><?php echo $consultationdate; ?></div></td>
												<td class="bodytext31" valign="center"  align="left">
												<div align="center"><?php echo $patientcode; ?></div></td>
												<td class="bodytext31" valign="center"  align="left">
												<div align="center"><?php echo $patientvisitcode; ?></div></td>
											  <td class="bodytext31" valign="center"  align="left">
											  <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>
											   <td class="bodytext31" valign="center"  align="left">
											  <div class="bodytext31" align="center"><?php echo $subtype; ?></div></td>
											  <td class="bodytext31" valign="center"  align="left">
												<div align="center">
												  <?php echo $accountname; ?>			      </div></td>
											 
											 <td class="bodytext31" valign="center"  align="left"><a href="patientweivers_paylater.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $patientvisitcode; ?>"><strong>Waivers</strong></a>			  </td>
											  </tr>
											  <?php
											}
											}
											}
											
										//location code get
										$locationcode= isset($_REQUEST['location'])?$_REQUEST['location']:'';	  
										$query1 = "select * from master_visitentry where patientfullname like '%$searchpatient%' and locationcode='$locationcode' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and  paymentstatus = '' and billtype = 'PAY NOW' and consultationdate between '$fromdate' and '$todate'  order by auto_number desc";
										$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
										while ($res1 = mysqli_fetch_array($exec1))
										{
										$patientcode = $res1['patientcode'];
										$visitcode = $res1['visitcode'];
										$patientfullname = $res1['patientfullname'];
										$accountname=$res1['accountname'];
										$plannumber = $res1['planname'];
					
										$query66 = "SELECT visitcode FROM patientweivers where visitcode = '$visitcode'";
										$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
										$row66 = mysqli_num_rows($exec66);
										if($row66 == 0)
										{
	
										$query23=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number = '$accountname'");
										$exec23=mysqli_fetch_array($query23);
										$patientaccountname=$exec23['accountname'];
										$consultationdate = $res1['consultationdate'];
										//$res2contactperson1 = $res2['contactperson1'];
										$paymenttypeanum = $res1['subtype'];
										
										$query3 = "select * from master_subtype where auto_number = '$paymenttypeanum'";
										$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
										$res3 = mysqli_fetch_array($exec3);
										$res3paymenttype = $res3['subtype'];
										
										$colorloopcount = $colorloopcount + 1;
										$showcolor = ($colorloopcount & 1); 
										$colorcode = '';
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
										<td class="bodytext31" valign="center"  align="center"><?php echo $colorloopcount; ?></td>
										<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
										<div align="center"><span class="bodytext32"><?php echo $consultationdate; ?></span></div>
										</div></td>
										
										<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
										<div align="center"><span class="bodytext32"><?php echo $patientcode; ?></span></div>
										</div></td>
										<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
										<div align="center"><span class="bodytext32"><?php echo $visitcode; ?></span></div>
										</div></td>
										
										<td class="bodytext31" valign="center"  align="left">
										<div align="center"><?php echo $patientfullname; ?></div></td>
										
										<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
										<div align="center"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
										</div></td>
										<td  align="left" valign="center" class="bodytext31"><div align="center"> <?php echo $patientaccountname; ?></div></td>
										<td  align="left" valign="center" class="bodytext31">
										<div align="left"><a href="patientweivers_consult.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><strong>Waivers</strong></a></div></td>
										</tr>
										<?php
										}
										}
										?>
										<?php
										//location code get
										$locationcode= isset($_REQUEST['location'])?$_REQUEST['location']:'';	  
										echo $query34 = "select * from master_visitentry where patientfullname like '%$searchpatient%' and locationcode='$locationcode' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and  paymentstatus = 'completed' and billtype = 'PAY NOW' and consultationdate between '$fromdate' and '$todate'  order by auto_number desc";
										$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die ("Error in Query34".mysqli_error($GLOBALS["___mysqli_ston"]));
										while ($res34 = mysqli_fetch_array($exec34))
										{
										$patientcode = $res34['patientcode'];
										$visitcode = $res34['visitcode'];
										$patientfullname = $res34['patientfullname'];
										$accountname=$res34['accountname'];
										$plannumber = $res34['planname'];
					
										$query66 = "SELECT visitcode FROM patientweivers where visitcode = '$visitcode'";
										$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
										$row66 = mysqli_num_rows($exec66);
										if($row66 == 0 || $row66 == 1)
										{
	
										$query23=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number = '$accountname'");
										$exec23=mysqli_fetch_array($query23);
										$patientaccountname=$exec23['accountname'];
										$consultationdate = $res34['consultationdate'];
										$paymenttypeanum = $res34['subtype'];
										
										$query3 = "select * from master_subtype where auto_number = '$paymenttypeanum'";
										$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
										$res3 = mysqli_fetch_array($exec3);
										$res3paymenttype = $res3['subtype'];
										
										$colorloopcount = $colorloopcount + 1;
										$showcolor = ($colorloopcount & 1); 
										$colorcode = '';
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
										<td class="bodytext31" valign="center"  align="center"><?php echo $colorloopcount; ?></td>
										<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
										<div align="center"><span class="bodytext32"><?php echo $consultationdate; ?></span></div>
										</div></td>
										
										<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
										<div align="center"><span class="bodytext32"><?php echo $patientcode; ?></span></div>
										</div></td>
										<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
										<div align="center"><span class="bodytext32"><?php echo $visitcode; ?></span></div>
										</div></td>
										
										<td class="bodytext31" valign="center"  align="left">
										<div align="center"><?php echo $patientfullname; ?></div></td>
										
										<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
										<div align="center"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
										</div></td>
										<td  align="left" valign="center" class="bodytext31"><div align="center"> <?php echo $patientaccountname; ?></div></td>
										<td  align="left" valign="center" class="bodytext31">
										<div align="left"><a href="patientweivers_paynow.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><strong>Waivers</strong></a></div></td>
										</tr>
										<?php
										}
										}
										?>
										
											<tr><!--4rth table 4rth tr  start here  -->
											<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
											<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
											<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
											<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
											<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
											<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
											<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
											<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>																	
											</tr>
											</tbody><!--4rth table tbody end here  -->
						<?php
							}//ifendhere
						?>
										</table><!--4rth table   end here  -->
								   </td><!--3rdtable 1st td end here  --> 
							    </tr><!--3rdtable 1st tr end here  --> 

							</table><!--3rdtable end here  --> 
						</td><!--2ndtable-3rd tr 1st td end here  --> 
						</tr><!--2ndtable-3rd tr end here  --> 
     </table><!--2ndtable  end here  -->
	 </td><!--maintable2td end here  -->
	 </tr><!--maintable5throwstarthere  -->
</table><!--maintableendhere  -->
<?php include ("includes/footer1.php"); ?>
</body>
</html>

