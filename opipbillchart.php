<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('2014-01-01');
$transactiondateto = date('Y-m-d');

if (isset($_REQUEST["charttype"])) {  $charttype = $_REQUEST["charttype"]; } else { $charttype = ""; }
if (isset($_REQUEST["ADate1"])) {  $datefrom = $_REQUEST["ADate1"]; } else { $datefrom = ""; }
if (isset($_REQUEST["ADate2"])) {  $dateto = $_REQUEST["ADate2"]; } else { $dateto = ""; }
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

function selectmonth()
{
	if (document.getElementById("month").value == "")
	{
		alert ("Search Month.");
		document.getElementById("month").focus();
		return false;
	}
}
function selectcharttype()
{
	if (document.getElementById("charttype").value == "")
	{
		alert ("Search Chart.");
		document.getElementById("charttype").focus();
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
        <td width="860"><form name="cbform1" method="post" action="opipbillchart.php">
          <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="10" bgcolor="#ecf0f5" class="bodytext3"><strong>OP/IP Revenue </strong></td>
              </tr>
        
             <tr>
          <td width="79" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="150" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1"  value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="57" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="139" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2"  value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          <td width="90" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Chart Type </strong></td>
          <td width="237" align="left" valign="center"  bgcolor="#ffffff"><strong>
            <select name="charttype" id="charttype" required>
			  <?php
				/*if ($charttype != '')
				{
				?>
                 <option value="<?php echo $charttype; ?>" selected="selected"><?php echo $charttype; ?></option>
				 <?php
				}*/
				?>
              <option value="Pie">Pie</option>
			  <option value="Bar">Bar</option>
              <!--<option value="Line">Line</option>-->
            </select>
          </strong></td>
             </tr>
           
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="9" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" onClick="return selectmonth(); return selectcharttype();" value="Search" name="Submit" />
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
	<form name="form1" id="form1" method="post" action="labresultsviewlist.php">	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if ($cbfrmflag1 == 'cbfrmflag1')
{
if (isset($_REQUEST["charttype"])) { $charttype = $_REQUEST["charttype"]; } else { $charttype = ""; }
if (isset($_REQUEST["ADate1"])) {  $datefrom = $_REQUEST["ADate1"]; } else { $datefrom = ""; }
if (isset($_REQUEST["ADate2"])) {  $dateto = $_REQUEST["ADate2"]; } else { $dateto = ""; }
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="802" 
            align="left" border="0">
          <tbody>
	<?php
	  $query1 = "select sum(billamount) as billamount1 from master_billing where billingdatetime between '$transactiondatefrom' and '$transactiondateto'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$res1consultationamount = $res1['billamount1'];
			  
			  if($res1consultationamount != 0)
			  {
			  $data1[] = $res1consultationamount;
              $alldepartment1[] = 'Consulation:' ;
			  }
			
			$query5 = "select sum(labitemrate) as labitemrate1 from billing_paylaterlab where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res5 = mysqli_fetch_array($exec5);
			$res5labitemrate = $res5['labitemrate1'];
			
			$query6 = "select sum(labitemrate) as labitemrate1 from billing_paynowlab where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6 = mysqli_fetch_array($exec6);
			$res6labitemrate = $res6['labitemrate1'];
			
			$query7 = "select sum(labitemrate) as labitemrate1 from billing_externallab where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res7 = mysqli_fetch_array($exec7);
			$res7labitemrate = $res7['labitemrate1'];
			
			$totallabitemrate = $res5labitemrate + $res6labitemrate + $res7labitemrate;
			
			if($totallabitemrate != 0)
			  {
			  $data1[] = $totallabitemrate;
              $alldepartment1[] = 'Lab:' ;
			  }
			
			$query9 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paylaterradiology where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in query9".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res9 = mysqli_fetch_array($exec9);
			$res9radiologyitemrate = $res9['radiologyitemrate1'];
			
			$query10 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paynowradiology where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res10 = mysqli_fetch_array($exec10);
			$res10radiologyitemrate = $res10['radiologyitemrate1'];
			
			$query11 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_externalradiology where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11 = mysqli_fetch_array($exec11);
			$res11radiologyitemrate = $res11['radiologyitemrate1'];
			
			$totalradiologyitemrate = $res9radiologyitemrate + $res10radiologyitemrate + $res11radiologyitemrate;
			
			if($totalradiologyitemrate != 0)
			  {
			  $data1[] = $totalradiologyitemrate;
              $alldepartment1[] = 'Radiology:' ;
			  }
			
			$query13 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paylaterservices where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in query13".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res13 = mysqli_fetch_array($exec13);
			$res13servicesitemrate = $res13['servicesitemrate1'];
			
			$query14 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paynowservices where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res14 = mysqli_fetch_array($exec14);
			$res14servicesitemrate = $res14['servicesitemrate1'];
			
			$query15 = "select sum(servicesitemrate) as servicesitemrate1 from billing_externalservices where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res15 = mysqli_fetch_array($exec15);
			$res15servicesitemrate = $res15['servicesitemrate1'];
			
			$totalservicesitemrate = $res13servicesitemrate + $res14servicesitemrate + $res15servicesitemrate ;
			
			if($totalservicesitemrate != 0)
			  {
			  $data1[] = $totalservicesitemrate;
              $alldepartment1[] = 'Services:' ;
			  }
			
			$query17 = "select sum(referalrate) as referalrate1 from billing_paylaterreferal where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in query17".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res17 = mysqli_fetch_array($exec17);
			$res17referalitemrate = $res17['referalrate1'];
			
			$query18 = "select sum(referalrate) as referalrate1 from billing_paynowreferal where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res18 = mysqli_fetch_array($exec18);
			$res18referalitemrate = $res18['referalrate1'];
			
			$totalreferalitemrate = $res17referalitemrate + $res18referalitemrate;
			
			if($totalreferalitemrate != 0)
			  {
			  $data1[] = $totalreferalitemrate;
              $alldepartment1[] = 'Referral:' ;
			  }
$totalop = array_sum($data1);	

 $query2 = "select sum(amount) from billing_ipadmissioncharge where recorddate between '$transactiondatefrom' and '$transactiondateto' ";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num2=mysqli_num_rows($exec2);
			$res2 = mysqli_fetch_array($exec2);
			$totalipadmissionamount =$res2['sum(amount)'];
			
			$query3 = "select sum(packagecharge) as packagecharge from master_ipvisitentry where consultationdate between '$transactiondatefrom' and '$transactiondateto' ";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num3=mysqli_num_rows($exec3);
			$res3 = mysqli_fetch_array($exec3);
			$totalippackageamount =$res3['packagecharge'];
			
			$query4 = "select sum(amount) from billing_ipbedcharges where description='bed charges' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num4 = mysqli_num_rows($exec4);
			$res4 = mysqli_fetch_array($exec4);
			$totalbedcharges =$res4['sum(amount)'];
			
			$totalhospitalrevenue = $totalbedcharges + $totalippackageamount + $totalipadmissionamount;
			  
			  if($totalhospitalrevenue != 0)
			  {
			  $data[] = $totalhospitalrevenue;
              $alldepartment[] = 'Hospital:' ;
			  }
			
			$query8 = "select sum(labitemrate) as labitemrate1 from billing_iplab where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res8 = mysqli_fetch_array($exec8);
			$res8labitemrate = $res8['labitemrate1'];
			
			
			if($res8labitemrate != 0)
			  {
			  $data[] = $res8labitemrate;
              $alldepartment[] = 'Lab:' ;
			  }
		    
			$query12 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_ipradiology where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res12 = mysqli_fetch_array($exec12);
			$res12radiologyitemrate = $res12['radiologyitemrate1'];
			
			if($res12radiologyitemrate != 0)
			  {
			  $data[] = $res12radiologyitemrate;
              $alldepartment[] = 'Radiology:' ;
			  }
			
		
			$query16 = "select sum(servicesitemrate) as servicesitemrate1 from billing_ipservices where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res16 = mysqli_fetch_array($exec16);
			$res16servicesitemrate = $res16['servicesitemrate1'];
			
			if($res16servicesitemrate != 0)
			  {
			  $data[] = $res16servicesitemrate;
              $alldepartment[] = 'Services:' ;
			  }		
$totalip = array_sum($data);	
			  ?>
		  
		  <?php
		    if($charttype== 'Pie') { ?>
		 	<tr>
				<td width="94" align="left" valign="center">
					<?php
                    include_once 'open-flash-chart-1.9.5/php-ofc-library/open_flash_chart_object.php';
					open_flash_chart_object( 500, 250, 'http://'. $_SERVER['SERVER_NAME'] .'/neema/oponlyrevenue_pie.php', false );
					$_SESSION['datefrom'] = $datefrom;
					$_SESSION['dateto'] = $dateto;
					?>
				</td>
				<td width="94" align="left" valign="center">
					<?php
                    include_once 'open-flash-chart-1.9.5/php-ofc-library/open_flash_chart_object.php';
					open_flash_chart_object( 500, 250, 'http://'. $_SERVER['SERVER_NAME'] .'/neema/iponlyrevenue_pie.php', false );
					$_SESSION['datefrom'] = $datefrom;
					$_SESSION['dateto'] = $dateto;
					?>
					

				</td>
                </tr>
           <?php } ?>
		   
		  <?php
		    if($charttype== 'Bar') { ?>
		 	<tr>
				<td width="94" align="left" valign="center">
					<?php
                    include_once 'open-flash-chart-1.9.5/php-ofc-library/open_flash_chart_object.php';
					open_flash_chart_object( 500, 250, 'http://'. $_SERVER['SERVER_NAME'] .'/neema/oponlyrevenue_bar.php', false );
					$_SESSION['datefrom'] = $datefrom;
					$_SESSION['dateto'] = $dateto;
					?>
				</td>
           <?php } ?>
		    <?php
		    if($charttype== 'Bar') { ?>
		
				<td width="94" align="left" valign="center">
					<?php
                    include_once 'open-flash-chart-1.9.5/php-ofc-library/open_flash_chart_object.php';
					open_flash_chart_object( 500, 250, 'http://'. $_SERVER['SERVER_NAME'] .'/neema/iponlyrevenue_bar.php', false );
					$_SESSION['datefrom'] = $datefrom;
					$_SESSION['dateto'] = $dateto;
					?>
				</td>
                </tr>
           <?php } ?>
		    <tr>
			   
		        <td><strong>Total: <?php echo number_format($totalop,2,'.',','); ?></strong>			  
             </td>
			 <td><strong>Total: <?php echo number_format($totalip,2,'.',','); ?></strong>			  
             </td>
			</tr>
		   <?php
		    /*if($charttype== 'Line') { ?>
				<!--<tr>
				<td>
					<?php
					include_once 'open-flash-chart-1.9.5/php-ofc-library/open_flash_chart_object.php';
					open_flash_chart_object( 500, 250, 'http://'. $_SERVER['SERVER_NAME'] .'/neema/oprevenue_line.php', false );
				    $_SESSION['datefrom'] = $datefrom;
					$_SESSION['dateto'] = $dateto;
					*/?>
				 </td>
			</tr>
			  <?php //} ?>	
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

