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
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 
  $transactiondatefrom=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:'';
   $transactiondateto=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:'';
   if($transactiondatefrom=='')
   {
   $transactiondatefrom = date('Y-m-d', strtotime('-1 month')); }
    if($transactiondateto==''){
   $transactiondateto =  date('Y-m-d');}
 
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
.number
{
padding-left:900px;
text-align:right;
font-weight:bold;
}
.bali
{
text-align:right;
}
.style1 {font-weight: bold}
.style2 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
</style>
</head>

<script>

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

</script>
<script src="js/datetimepicker_css.js"></script>

<body>
<table width="129%" border="0" cellspacing="0" cellpadding="2">
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
    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1447"><form name="cbform1" method="post" action="oprevenuereportdetailed.php">
          <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>OP Detail Revenue </strong></td>
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
              </tr>
             <tr>
          <td width="76" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="123" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="51" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="129" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          </tr>
           <tr>
  			  <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
			 
				 <select name="location" id="location"  onChange=" ajaxlocationfunction(this.value);" >
                   <?php
						$query1="select locationcode,locationname from master_employeelocation where username ='$username' group by locationcode order by locationname ";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$loccode=array();
						while ($res1 = mysqli_fetch_array($exec1))
						{
							$locationname = $res1["locationname"];
							$locationcode5 = $res1["locationcode"];
						?>
						 <option value="<?php echo $locationcode5; ?>" <?php if($location!='')if($location==$locationcode5){echo "selected";}?>><?php echo $locationname; ?></option>
						<?php
						} 
						?>
                      </select>
					 
              </span></td>
			   <td width="10%" align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
			  </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      
      
      <tr>
        <td>&nbsp;</td>
      </tr>
	  <tr>
        <td>
	<form name="form1" id="form1" method="post" action="oprevenuereportdetailed.php">	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if ($cbfrmflag1 == 'cbfrmflag1')
{

	$fromdate=$_POST['ADate1'];
	$todate=$_POST['ADate2'];

	
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1060" 
            align="left" border="0">
          <tbody>
             <tr>
			 <td colspan="22" bgcolor="#ecf0f5" class="bodytext31" align="left" valign="middle"><strong>OP Detail Revenue</strong></td>
			 </tr>
			  <tr>
				    <td width="64" class="bodytext31" valign="center"  align="left" 
					bgcolor="#ffffff"><div align="center"><strong>S.No. </strong></div></td>
  				    <td width="193" class="bodytext31" valign="center"  align="left" 
					bgcolor="#ffffff"><div align="center"><strong>Patient</strong></div></td>
  				    <td width="112" class="bodytext31" valign="center"  align="left" 
					bgcolor="#ffffff"><div align="center"><strong>Reg No. </strong></div></td>
  				    <td width="99"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="center">OP&nbsp;No</div></td>
					<td width="88"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="center">Consultation</div></td>
  				    <td width="52"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Laboratory</div></td>
  				    <td width="55"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Radiology</div></td>
  				    <td width="68"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Pharmacy</div></td>
  				    <td width="66"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Services</div></td>
                    <td width="46"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Referral</div></td>
  				    <td width="63"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Ambulance</strong></div></td>
                     <td width="58"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Homecare</strong></div></td>
				    
              </tr>					
        <?php
	    $query1 = "select  patientfullname,patientcode,visitcode,consultationdate from master_visitentry where locationcode='$locationcode1' and consultationdate between '$fromdate' and '$todate' order by auto_number DESC ";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		while($res1 = mysqli_fetch_array($exec1))
		{
		$patientname=$res1['patientfullname'];
		$patientcode=$res1['patientcode'];
		$visitcode=$res1['visitcode'];
		$consultationdate=$res1['consultationdate'];
	   	
		$query18 = "select sum(billamount) as billamount1 from master_billing where patientcode = '$patientcode' and visitcode='$visitcode'";
		$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in query18".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res18 = mysqli_fetch_array($exec18);
		$consultationamount = $res18['billamount1'];
			
		 $query8 = "select sum(amount) as amount1 from billing_paylaterpharmacy where patientcode = '$patientcode' and patientvisitcode='$visitcode'";
		$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res8 = mysqli_fetch_array($exec8);
		$res8pharmacyitemrate = $res8['amount1'];
		
		$query9 = "select sum(amount) as amount1 from billing_paynowpharmacy where patientcode = '$patientcode' and patientvisitcode='$visitcode'";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res9 = mysqli_fetch_array($exec9);
		$res9pharmacyitemrate = $res9['amount1'];	
		
		$pharmacyamount = $res8pharmacyitemrate + $res9pharmacyitemrate;
		
		$query2 = "select sum(labitemrate) as labitemrate1 from billing_paylaterlab where patientcode = '$patientcode' and patientvisitcode='$visitcode'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$res2labitemrate = $res2['labitemrate1'];
		
		$query3 = "select sum(labitemrate) as labitemrate1 from billing_paynowlab where patientcode = '$patientcode' and patientvisitcode='$visitcode'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res3 = mysqli_fetch_array($exec3);
		$res3labitemrate = $res3['labitemrate1'];
		
		$labamount = $res2labitemrate + $res3labitemrate;
		
		$query4 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paylaterradiology where patientcode = '$patientcode' and patientvisitcode='$visitcode'";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res4 = mysqli_fetch_array($exec4);
		$res4radiologyitemrate = $res4['radiologyitemrate1'];
		
		$query5 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paynowradiology where patientcode = '$patientcode' and patientvisitcode='$visitcode'";
		$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res5 = mysqli_fetch_array($exec5);
		$res5radiologyitemrate = $res5['radiologyitemrate1'];
		
		$radiologyamount = $res4radiologyitemrate + $res5radiologyitemrate;
		
		$query6 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paylaterservices where patientcode = '$patientcode' and patientvisitcode='$visitcode'";
		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res6 = mysqli_fetch_array($exec6);
		$res6servicesitemrate = $res6['servicesitemrate1'];
		
		$query7 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paynowservices where patientcode = '$patientcode' and patientvisitcode='$visitcode'";
		$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res7 = mysqli_fetch_array($exec7);
		$res7servicesitemrate = $res7['servicesitemrate1'];
		
		$servicesamount = $res6servicesitemrate + $res7servicesitemrate;
		
		$query10 = "select sum(referalrate) as referalrate1 from billing_paylaterreferal where patientcode = '$patientcode' and patientvisitcode='$visitcode'";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res10 = mysqli_fetch_array($exec10);
		$res10referalitemrate = $res10['referalrate1'];
		
		$query11 = "select sum(referalrate) as referalrate1 from billing_paynowreferal where patientcode = '$patientcode' and patientvisitcode='$visitcode'";
		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res11 = mysqli_fetch_array($exec11);
		$res11referalitemrate = $res11['referalrate1'];
		
		$refamount = $res10referalitemrate + $res11referalitemrate;
		
		$query28 = "select sum(amount) as amount1 from billing_homecare where patientcode = '$patientcode' and visitcode='$visitcode'";
		$exec28= mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query28".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res28 = mysqli_fetch_array($exec28) ;
		$res28homecare = $res28['amount1'];
		
		$query29 = "select sum(amount) as amount1 from billing_homecarepaylater where patientcode = '$patientcode' and visitcode='$visitcode'";
		$exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29) or die ("Error in Query29".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res29 = mysqli_fetch_array($exec29) ;
		$res29homecare = $res29['amount1'];
		$totalhomecare = $res28homecare + $res29homecare;
		
		//this query for rescue
		$query30 = "select sum(amount) as amount1 from billing_opambulance where patientcode = '$patientcode' and visitcode='$visitcode'";
		$exec30= mysqli_query($GLOBALS["___mysqli_ston"], $query30) or die ("Error in Query30".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res30 = mysqli_fetch_array($exec30) ;
		$res30rescue = $res30['amount1'];
		
		$query31 = "select sum(amount) as amount1 from billing_opambulancepaylater where patientcode = '$patientcode' and visitcode='$visitcode'";
		$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res31 = mysqli_fetch_array($exec31) ;
		$res31rescue = $res31['amount1'];
		$totalrescue = $res30rescue + $res31rescue;
			
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
			  <div class="bodytext31" align="center">
			    <div align="center"><?php echo $patientname; ?></div>
			  </div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left">
			      <div align="center"><?php echo $visitcode; ?></div></td>	
            	<td class="bodytext31" valign="center"  align="left">
			      <div align="right"><?php echo number_format($consultationamount,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			      <div align="right"><?php echo number_format($labamount,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			      <div align="right"><?php echo number_format($radiologyamount,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			      <div align="right"><?php echo number_format($pharmacyamount,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			        <div align="right"><?php echo number_format($servicesamount,2,'.',','); ?></div></td>
					<td class="bodytext31" valign="center"  align="left">
			        <div align="right"><?php echo number_format($refamount,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			        <div align="right"><?php echo number_format($totalrescue,2,'.',','); ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
			        <div align="right"><?php echo number_format($totalhomecare,2,'.',','); ?></div></td>
				  
                  </tr>
		   <?php 
		     }
		   ?>
		   <tr bgcolor="#ecf0f5">
              <td colspan="12" class="bodytext31" valign="center"  align="left"><div align="center">&nbsp;</div></td>
			  <td><a href="print_oprevenuedetail.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $locationcode1; ?>&&ADate1=<?php echo $fromdate; ?>&&ADate2=<?php echo $todate; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>
			  </tr>
              </tbody>
        </table>
<?php
}
?>	
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

