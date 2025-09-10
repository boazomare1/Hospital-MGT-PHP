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
$transactiondatefrom = "2014-01-01";
$transactiondateto = date('Y-m-d');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
//This include updatation takes too long to load for hunge items database.


//$getcanum = $_GET['canum'];
if (isset($_REQUEST["package"])) { $packagecode = $_REQUEST["package"]; } else { $packagecode = ""; }


if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';


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
<?php /*include ("autocompletebuild_package2.php");*/  ?>
<!--<script type="text/javascript" src="js/autosuggestippackage.js"></script>  For searching customer 
<script type="text/javascript" src="js/autocomplete_ippackage1.js"></script>-->
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
<script type="text/javascript">
/*window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("packagename"), new StateSuggestions());        
}*/


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

function paymententry1process2()
{
	if (document.getElementById("cbfrmflag1").value == "")
	{
		alert ("Search Bill Number Cannot Be Empty.");
		document.getElementById("cbfrmflag1").focus();
		document.getElementById("cbfrmflag1").value = "<?php echo $cbfrmflag1; ?>";
		return false;
	}
}

function funcvalid()
{
	if(document.cbform1.package.value == "")
	{
		alert("Please Select Package");
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

<body onLoad=" funcOnLoadBodyFunctionCall">
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
		
		
        <form name="cbform1" method="post" action="ippackageanalysis.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>IP Package Analysis </strong></td>
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
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Package Name</strong></td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <select name="package" id="package">
				    <option value="">Select Package</option>
				   <?php
				   $query66 = "select * from master_ippackage where status=''";
				   $exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				   while($res66 = mysqli_fetch_array($exec66))
				   {
				   $packageanum = $res66['auto_number'];
				   $packagename = $res66['packagename'];
				   ?>
				   <option value="<?php echo $packageanum; ?>"><?php echo $packagename; ?></option>
				   <?php
				   }
				   
				   ?>
				   </select>
              </span></td>
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
			 
				 <select name="location" id="location" onChange=" ajaxlocationfunction(this.value);" >
                    <?php
						
						$query1 = "select * from login_locationdetails where  username='$username' and docno='$docno' order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$loccode=array();
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$locationname = $res1["locationname"];
						$locationcode = $res1["locationcode"];
						
						?>
						 <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>
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
                  <input  type="submit" onClick="return funcvalid();" value="Search" name="submit"/>
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
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
      </tr>
	  
	  <tr>
        <td>
	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$fromdate=$_POST['ADate1'];
	$todate=$_POST['ADate2'];
	


	
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
             
           
           <?php
          
		$query40 = "select packagename from master_ippackage where locationcode='$locationcode1' and auto_number = '$packagecode'";
		$exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res40 = mysqli_fetch_array($exec40);
		$packagename = $res40['packagename'];
		//$num1=0;
		$query1 = "select visitcode, packagecharge from master_ipvisitentry where locationcode='$locationcode1' and consultationdate between '$fromdate' and '$todate' and  package='$packagecode' and finalbillno <> ''";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		$amount=0;
		$pharamount=0;
		$freepharamount=0;
		$labamount=0;
		$freelabamount=0;
		$serviceamount=0;
		$freeserviceamount=0;
		$radamount=0;
		$freeradamount=0;
		while($res1 = mysqli_fetch_array($exec1))
		{
		
		$visitcode=$res1['visitcode'];		
		$amount=$amount+$res1['packagecharge'];
		
		$query2 = "select sum(totalamount) as pharamount from pharmacysales_details where locationcode='$locationcode1' and entrydate between '$fromdate' and '$todate' and  visitcode='$visitcode' and freestatus='no'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num2=mysqli_num_rows($exec2);
		$res2 = mysqli_fetch_array($exec2);
		$pharamount=$res2['pharamount']+$pharamount;
		
		$query3 = "select sum(totalamount) as pharamount from pharmacysales_details where locationcode='$locationcode1' and entrydate between '$fromdate' and '$todate' and  visitcode='$visitcode' and freestatus='yes'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num3=mysqli_num_rows($exec3);
		$res3 = mysqli_fetch_array($exec3);
		$freepharamount=$res3['pharamount']+$freepharamount;
		
		$query4 = "select sum(labitemrate) as labamount from ipconsultation_lab where locationcode='$locationcode1' and consultationdate between '$fromdate' and '$todate' and  patientvisitcode='$visitcode' and freestatus='no'";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num4=mysqli_num_rows($exec4);
		$res4 = mysqli_fetch_array($exec4);
		$labamount=$res4['labamount']+$labamount;
		
		$query5 = "select sum(labitemrate) as labamount from ipconsultation_lab where locationcode='$locationcode1' and consultationdate between '$fromdate' and '$todate' and  patientvisitcode='$visitcode' and freestatus='yes'";
		$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num5 = mysqli_num_rows($exec5);
		$res5 = mysqli_fetch_array($exec5);
		$freelabamount=$res5['labamount']+$freelabamount;
		
		$query6 = "select sum(amount) as serviceamount from ipconsultation_services where locationcode='$locationcode1' and consultationdate between '$fromdate' and '$todate' and  patientvisitcode='$visitcode' and freestatus='no'";
		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num6 = mysqli_num_rows($exec6);
		$res6 = mysqli_fetch_array($exec6);
		$serviceamount=$res6['serviceamount']+$serviceamount;
		
		$query7 = "select sum(amount) as serviceamount from ipconsultation_services where locationcode='$locationcode1' and consultationdate between '$fromdate' and '$todate' and  patientvisitcode='$visitcode' and freestatus='yes'";
		$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num7 = mysqli_num_rows($exec7);
		$res7 = mysqli_fetch_array($exec7);
		$freeserviceamount=$res7['serviceamount']+$freeserviceamount;
		
		$query8 = "select sum(radiologyitemrate) as radamount from ipconsultation_radiology where locationcode='$locationcode1' and consultationdate between '$fromdate' and '$todate' and  patientvisitcode='$visitcode' and freestatus='no'";
		$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num8 = mysqli_num_rows($exec8);
		$res8 = mysqli_fetch_array($exec8);
		$radamount=$res8['radamount']+$radamount;
		
		$query9 = "select sum(radiologyitemrate) as radamount from ipconsultation_radiology where locationcode='$locationcode1' and consultationdate between '$fromdate' and '$todate' and  patientvisitcode='$visitcode' and freestatus='yes'";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num9 = mysqli_num_rows($exec9);
		$res9 = mysqli_fetch_array($exec9);
		$freeradamount=$res9['radamount']+$freeradamount;
		
		
			?>
         
		   <?php 
		   } 
		  
		   ?>
		   <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
           <tr>
		   <td class="bodytext31" valign="center"  align="left"><strong><?php echo $packagename;?></strong></td>
		   <td class="bodytext31" valign="center"  align="left"><strong>Count</strong></td>
		   <td class="bodytext31" valign="center"  align="left"><?php echo $num1;?></td> 
		   <td class="bodytext31" valign="center"  align="left"><strong>Total</strong></td>
		   <td class="bodytext31" valign="center"  align="left"><?php echo number_format($amount,2,'.',',');?></td> 
		   </tr>
		   </table>
		   <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
           <tr bgcolor="#fff">
		   <td class="bodytext31" valign="center"  align="left"><strong></strong></td>
		   <td class="bodytext31" valign="center"  align="right"><strong>Pharmacy</strong></td>
		   <td class="bodytext31" valign="center"  align="right"><strong>Lab</strong></td> 
		   <td class="bodytext31" valign="center"  align="right"><strong>Radiology</strong></td>
		   <td class="bodytext31" valign="center"  align="right"><strong>Service</strong></td> 
		   <td class="bodytext31" valign="center"  align="right"><strong>Total Amount</strong></td> 
		   </tr>
		   <tr bgcolor="#ecf0f5">
		   <td class="bodytext31" valign="center"  align="left"><strong>Free</strong></td>
		   <td class="bodytext31" valign="center"  align="right"><a href="package_pharamacy.php?pkgid=<?=$packagecode?>&&from=<?=$fromdate?>&&to=<?=$todate?>&&status=1&&loc=<?=$locationcode1?>" target="_blank"><?php echo number_format($freepharamount,2,'.',','); ?></a></td>
		   <td class="bodytext31" valign="center"  align="right"><a href="package_lab.php?pkgid=<?=$packagecode?>&&from=<?=$fromdate?>&&to=<?=$todate?>&&status=1&&loc=<?=$locationcode1?>" target="_blank"><?php echo number_format($freelabamount,2,'.',','); ?></a></td> 
		   <td class="bodytext31" valign="center"  align="right"><a href="package_radiology.php?pkgid=<?=$packagecode?>&&from=<?=$fromdate?>&&to=<?=$todate?>&&status=1&&loc=<?=$locationcode1?>" target="_blank"><?php echo number_format($freeradamount,2,'.',','); ?></a></td>
		   <td class="bodytext31" valign="center"  align="right"><a href="package_services.php?pkgid=<?=$packagecode?>&&from=<?=$fromdate?>&&to=<?=$todate?>&&status=1&&loc=<?=$locationcode1?>" target="_blank"><?php echo number_format($freeserviceamount,2,'.',','); ?></a></td> 
		   <?php $freetotalamount=$freepharamount+$freelabamount+$freeradamount+$freeserviceamount;?>
		   <td class="bodytext31" valign="center"  align="right"><?php echo number_format($freetotalamount,2,'.',','); ?></td> 
		   </tr>
		   <tr bgcolor="#CBDBFA">
		   <td class="bodytext31" valign="center"  align="left"><strong>Billed</strong></td>
		   <td class="bodytext31" valign="center"  align="right"><a href="package_pharamacy.php?pkgid=<?=$packagecode?>&&from=<?=$fromdate?>&&to=<?=$todate?>&&status=0&&loc=<?=$locationcode1?>" target="_blank"><?php echo number_format($pharamount,2,'.',','); ?></td>
		   <td class="bodytext31" valign="center"  align="right"><a href="package_lab.php?pkgid=<?=$packagecode?>&&from=<?=$fromdate?>&&to=<?=$todate?>&&status=0&&loc=<?=$locationcode1?>" target="_blank"><?php echo number_format($labamount,2,'.',','); ?></td> 
		   <td class="bodytext31" valign="center"  align="right"><a href="package_radiology.php?pkgid=<?=$packagecode?>&&from=<?=$fromdate?>&&to=<?=$todate?>&&status=0&&loc=<?=$locationcode1?>" target="_blank"><?php echo number_format($radamount,2,'.',','); ?></td>
		   <td class="bodytext31" valign="center"  align="right"><a href="package_services.php?pkgid=<?=$packagecode?>&&from=<?=$fromdate?>&&to=<?=$todate?>&&status=0&&loc=<?=$locationcode1?>" target="_blank"><?php echo number_format($serviceamount,2,'.',','); ?></td> 
		    <?php $totalamount=$pharamount+$labamount+$radamount+$serviceamount;?>
		   <td class="bodytext31" valign="center"  align="right"><?php echo number_format($totalamount,2,'.',','); ?></td> 
		   </tr>
		    <tr>
		   <td class="bodytext31" valign="center"  align="left"><strong></strong></td>
		   
		   <td class="bodytext31" valign="center"  align="left"><strong></strong></td>
		  
		   </tr>
		    <tr>
		   <td class="bodytext31" valign="center"  align="left"><strong></strong></td>
		   
		   <td class="bodytext31" valign="center"  align="left"><strong></strong></td>
		  
		   </tr>
		   <tr>
		   <td class="bodytext31" valign="center"  align="left"><strong>Total Revenue</strong></td>
		   <td class="bodytext31" valign="center"  align="right"><?php echo number_format($amount,2,'.',',');?></td>
		  
		   </tr>
		   <tr>
		   <td class="bodytext31" valign="center"  align="left"><strong>Less Free</strong></td>
		   <td class="bodytext31" valign="center"  align="right"><?php echo number_format($freetotalamount,2,'.',',');?></td>
		  
		   </tr>
		   <tr>
		   <td class="bodytext31" valign="center"  align="left" width="15%"><strong>Notional Profit/Loss</strong></td>
		   <?php $profit=$amount-$freetotalamount; ?>
		   <td class="bodytext31" valign="center"  align="right"><?php echo number_format($profit,2,'.',',');?></td>
		  
		   </tr>
		   </table>
            
			
          </tbody>
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
	  
	
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>