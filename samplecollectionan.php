<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
//date_default_timezone_set('Asia/Calcutta'); 
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$errmsg = "";
$timeonly = date('H:i:s');
$colorloopcount = '';

$docno = $_SESSION['docno'];

if(isset($_REQUEST['searchstatus'])){$searchstatus = $_REQUEST['searchstatus'];}else{$searchstatus='';}

//get location for sort by location purpose
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		  $locationcode=$location;
		}
		//location get end here
		
//To populate the autocompetelist_services1.js


$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');


if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
if ($frmflag2 == 'frmflag2')
{

}

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{

//$medicinecode = $_REQUEST['medicinecode'];

if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
if (isset($_REQUEST["patienttype"])) { $patienttype = $_REQUEST["patienttype"]; } else { $patienttype = ""; }

if (isset($_REQUEST["patient"])) { $patient = $_REQUEST["patient"]; } else { $patient = ""; }
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
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
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; }
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


function funcOnLoadBodyFunctionCall()
{


	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	 //To handle ajax dropdown list.
	funcCustomerDropDownSearch4();
	
	
}


</script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script src="js/datetimepicker_css.js"></script>

<body>
<table width="110%" border="0" cellspacing="0" cellpadding="2">
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
    <td width="1%" rowspan="3">&nbsp;</td>
    <td width="2%" rowspan="3" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		
		
			<form name="drugs" action="samplecollectionan.php" method="post" onKeyDown="return disableEnterKey()" onSubmit="return validcheck()">
	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
      <tbody id="foo">
        <tr>
          <td colspan="3" bgcolor="#ecf0f5" class="bodytext31"><strong>View Analyzer Sample Collection</strong></td>
            <td colspan="3" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
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
        
        <script language="javascript">

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
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}
	

}

//function validcheck()
//{
//
//if(confirm("Do You Want To Save The Record?")==false){return false;}	
//}
</script>
        
       
        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td colspan="5" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
               <select name="location" id="location" onChange=" ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">
                  <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationanum; ?>" <?php if($location!='')if($location==$res1locationanum){echo "selected";}?>><?php echo $res1location; ?></option>
						<?php
						}
						?>
                  </select>
              </span></td>
              </tr>
                    <tr>
					  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
					  <td colspan="5" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
						<input name="patient" type="text" id="patient" value="" size="50" autocomplete="off">
					  </span></td>
				    </tr>
						<tr>
					  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Registration No</td>
					  <td colspan="5" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
						<input name="patientcode" type="text" id="patient" value="" size="50" autocomplete="off">
					  </span></td>
					  </tr>
					   <tr>
					  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visit No </td>
					  <td colspan="5" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
						<input name="visitcode" type="text" id="visitcode" value="" size="50" autocomplete="off">
					  </span></td>
             		 </tr>
        <tr>
        
          <td width="76" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"> Date From </td>
          <td width="123" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="51" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"> Date To </span></td>
          <td width="129" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          <td width="186" align="center" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong></strong> </td>
          <td width="186" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">		  </td>
        </tr>
        <tr>
          <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><input type="hidden" name="medicinecode" id="medicinecode" style="border: 1px solid #001E6A; text-align:left" onKeyDown="return disableEnterKey()" value="<?php echo $medicinecode; ?>" size="10" readonly /></td>
          <td colspan="3" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
		  <strong><!--Item Code :--> <?php //echo $medicinecode; ?>
		  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
		  <input  type="submit" value="Search" name="Submit" />
		  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" />
		  <input type="hidden" name="frmflag1" value="frmflag1" id="frmflag1">
		  </strong></td>
          <td colspan="2" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right"></div></td>
        </tr>
      </tbody>
    </table>
    </form>		
	</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  <form name="form1" id="form1" method="post" action="samplecollectionan.php">	
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1155"
            align="left" border="0">
          <tbody>
		  
		 
		  
				<?php
				
	if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{			
				
				if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{

$ADate1 = $_REQUEST["ADate1"];
$ADate2 = $_REQUEST["ADate2"];
}
else
{
$ADate1 = $transactiondateto;
$ADate2 = $transactiondateto;
}
$sno=0;
$total=0;

?>
			<tr>
              <td width="26" height="22" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sno</strong></div></td>
			  <td width="26" height="22" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Print</strong></div></td>
              <td width="122" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Patient Name</strong></td>
                <td width="62" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Lab Request</strong></td>
              <td width="61" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Reg No</strong></td>
              <td width="53" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit No</strong></div></td>
              <td width="61" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
				<td width="87" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sample Doc No</strong></div></td>
			   <td width="63" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sample ID</strong></div></td>
			   <!--<td width="116" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Test</strong></div></td>-->
			  <td width="92" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sample Type</strong></div></td>
			  <td width="93" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Handled By</strong></div></td>
				<td width="70" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Status</strong></div></td>
			   
             </tr>
<?php
$query7 = "select * from opipsampleid_lab where patientname like '%$patient%' and patientcode like '%$patientcode%' and patientvisitcode like '%$visitcode%' and recorddate between '$ADate1' and '$ADate2' group by patientvisitcode,docnumber";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));						
while($res7 = mysqli_fetch_array($exec7))
{
$waitingtime='';
$patientname6 = $res7['patientname'];
$patientname6 = addslashes($patientname6);
$regno = $res7['patientcode'];
$visitno = $res7['patientvisitcode'];
$billdate6 = $res7['recorddate'];
$test = $res7['itemname'];
$itemcode = $res7['itemcode'];
$sample = $res7['sample'];
$sampleid = $res7['sampleid'];
$docnumber = $res7['docnumber'];
$recordtime = $res7['recordtime'];
$lanum = $res7['auto_number'];


$query6 = "select entrywork,entryworkby,username from samplecollection_laban where patientcode = '$regno'  and patientname = '$patientname6' and docnumber = '$docnumber' order by auto_number DESC";
$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res6 = mysqli_fetch_array($exec6);
//$lanum = $res6['auto_number'];
$entrywork = $res6['entrywork'];
$entryworkby = $res6['entryworkby'];
$collected = $res6['username'];



if($entrywork == '')
{
$entrywork = 'Pending';
}
				$waitingtime = (strtotime($timeonly) - strtotime($recordtime))/60;
				$waitingtime = round($waitingtime);
				
				if($entrywork == 'Pending')
				{				
					$waitingtime1 = $waitingtime;
				}
				else
				{
					$waitingtime1 = '';
				}
				
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
             
              <td align="left" valign="center"  
                class="bodytext31"><?php echo $sno=$sno+1; ?></td>
				<td align="center" valign="center"  
                class="bodytext31"><a href="print_labsample_label.php?patientcode=<?= $docnumber; ?>&&visitno=<?php echo $visitno; ?>" target="_blank">Print</a></td>
				<input type="hidden" name="itemcode[]" id="itemcode" value="<?php echo $itemcode; ?>">
				<input type="hidden" name="visitcode[]" id="visitcode" value="<?php echo $visitno; ?>">
				<input type="hidden" name="sampleid[]" id="sampleid" value="<?php echo $sampleid; ?>">
              <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $patientname6; ?></div></td>
               <td align="left" valign="center" class="bodytext31"><div align="left">
                <a href="print_labsamples.php?patientcode=<?php echo $regno?>&&docno=<?php echo $docnumber?>&&visitcode=<?php echo $visitno?>&locationcode=<?php echo $location;?>">Lab Samples</a></div></td>
               <td align="left" valign="center" class="bodytext31"><div align="left">
                <a href="emr2.php?patientcode=<?php echo $regno?>&&visitcode=<?php echo $visitno?>"><?php echo $regno; ?></a></div></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $visitno; ?></div></td>
              <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $billdate6; ?></div></td>
				<td align="left" valign="center"  
                class="bodytext31"><div align="center"><?php echo $docnumber; ?></div></td>
				<td align="left" valign="center"  
                class="bodytext31"><div align="left"><strong><?php echo $sampleid; ?></strong></div></td>

				  <!--<td align="left" valign="center"  
                class="bodytext31"><div align="left"><strong><?php echo $test; ?></strong></div></td>-->
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $sample; ?></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $entryworkby; ?></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $entrywork; ?></div></td>
				</tr>
				<?php
				} 
				?>
		  </tbody>
		  </table></td>
      </tr>
	  <tr>
	   <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
	  </tr>
	  <tr>
	  <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
	  <td width="241"  align="left" valign="center" class="bodytext31">
	   <input type="hidden" name="frmflag2" value="frmflag2" />
	  
	    <input type="hidden" name="submit" value="Submit"></td>
	  </tr>
	  </form>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <?php } ?>
    </table>    
 
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>