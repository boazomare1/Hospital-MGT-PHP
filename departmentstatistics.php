<?php
session_start();
//echo session_id();
include ("db/db_connect.php");
include ("includes/loginverify.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username=$_SESSION["username"];
$registrationdate = date('Y-m-d');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$docno = $_SESSION['docno'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$todaydate=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date("Y-m-d");
$fromdate=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date("Y-m-d");
$todate=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:date("Y-m-d");


if (isset($_REQUEST["ADate1"])) { $paymentreceiveddatefrom = $_REQUEST["ADate1"]; } else { $paymentreceiveddatefrom = date('Y-m-d'); }
if (isset($_REQUEST["ADate2"])) { $paymentreceiveddateto = $_REQUEST["ADate2"]; } else { $paymentreceiveddateto = date('Y-m-d'); }

$time=strtotime($todaydate);
$month=date("m",$time);
$year=date("Y",$time);
 
  $thismonth=$year."-".$month."___";

//get location for sort by location purpose
$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if($location!='')
{
	  $locationcode=$location;
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
#position
{
position: absolute;
    left: 830px;
    top: 420;
}
-->
</style>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script src="js/datetimepicker_css.js"></script>
<script src="datetimepicker1_css.js"></script>
<style>
.hideClass
{display:none;}
</style>

<script language="javascript">

function process1login1()
{
	if (document.form1.username.value == "")
	{
		alert ("Pleae Enter Your Login.");
		document.form1.username.focus();
		return false;
	}
	else if (document.form1.password.value == "")
	{	
		alert ("Pleae Enter Your Password.");
		document.form1.password.focus();
		return false;
	}
}

function fundatesearch()
{
	alert();
	var fromdate = $("#ADate1").val();
	var todate = $("#ADate2").val();
	var sortfiled='';
	var sortfunc='';
	
	var dataString = 'fromdate='+fromdate+'&&todate='+todate;
	
	$.ajax({
		type: "POST",
		url: "opipcashbillsajax.php",
		data: dataString,
		cache: true,
		//delay:100,
		success: function(html){
		alert(html);
			//$("#insertplan").empty();
			//$("#insertplan").append(html);
			//$("#hiddenplansearch").val('Searched');
			
		}
	});
}

</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}

-->
</style>
</head>

<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="99" colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
</table>
  <?php
  $query341 = "select * from master_employee where username = '$username' and statistics='on'";
			 $exec341 = mysqli_query($GLOBALS["___mysqli_ston"], $query341) or die ("Error in Query34".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $res341 = mysqli_fetch_array($exec341);
			 $rowcount341 = mysqli_num_rows($exec341);
			/* if($rowcount341 > 0)
			 {*/
  ?>

 <!-- filter table -->
 <form name="cbform1" method="post" action="departmentstatistics.php">
          <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse; margin-left:30px;margin-top:10px;">
          <tbody>
		  <!--<tr bgcolor="red">
              <td colspan="4" bgcolor="red" class="bodytext3"><strong> PLEASE REFRESH PAGE BEFORE MAKING BILL </strong></td>
              </tr>-->
            <tr bgcolor="#011E6A">
              <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong> Search Dept Report </strong></td>
              <td colspan="1" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
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
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
               <select name="location" id="location" onChange="ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">
                 <option value="All">All</option>
                  <?php
						
						$query1 = "select locationname,locationcode from master_location where status <> 'deleted' order by locationname";
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
            <!--<tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patient" type="text" id="patient" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			    <!--<tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Registration No</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patientcode" type="text" id="patient" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visitcode</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="visitcode" type="text" id="visitcode" value="" size="50" autocomplete="off">
              </span></td>
              </tr>-->
			  <tr>
          <td width="136" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="131" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="76" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="425" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          </tr>
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit" />
                  <!--<input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>-->
            </tr>
          </tbody>
        </table>
		</form>	
<?php //} ?>
<table width="1051" border="0" style="margin-left:30;">
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr><td>&nbsp;</td>
       </tr>
       
       <?php
	   
	       if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

		    if ($cbfrmflag1 == 'cbfrmflag1')

			{
				?>
  <tr>
    <td colspan="3"><table width="750" cellspacing="0" cellpadding="4px" border="0" style="font-size:medium;">
      <tr bgcolor="#CCC">
	  <td colspan="2" style="color: blue;"><strong>OP Departmental Statisctics</strong></td>
      </tr>
	  <tr bgcolor="#FFF">
	  <td >Department</td>
	  <td align="right" style="padding-right:8px">Count</td>
      </tr>
      <?php
	  
        

          $snocount = 0;
          $colorloopcount = 0;
          $totalvisit =0;

          
          $locationcode = $location;
		  
			if($location=='All')
			{
			$pass_location = "locationcode !=''";
			}
			else
			{
			$pass_location = "locationcode ='$location'";
			}	
		
		  $qrydpt = "select auto_number,department from master_department where recordstatus <> 'deleted'";
		  $execdpt = mysqli_query($GLOBALS["___mysqli_ston"], $qrydpt) or die("Error in qrydpt ".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($resdpt=mysqli_fetch_array($execdpt)){
		  	$dpt = $resdpt['auto_number'];
		    $dptname =  $resdpt['department'];
		    // patient in dept
		     $newwalkin="select patientcode from master_visitentry where department ='$dpt' and consultationdate between '$fromdate' and '$todate' and $pass_location";
		    $walkex=mysqli_query($GLOBALS["___mysqli_ston"], $newwalkin);
		    $walkpatient=0;
		    $walkpatient1=0;
		    while($totwalk=mysqli_fetch_array($walkex))
		    {
		    	$newwalkcode=$totwalk['patientcode'];
			$querywalk="select count(patientcode) as totalwalk from master_visitentry where patientcode='$newwalkcode' and $pass_location";  
				$querywalkex=mysqli_query($GLOBALS["___mysqli_ston"], $querywalk);
				$reswalkt=mysqli_fetch_array($querywalkex);
				$walkcount=$reswalkt['totalwalk'];
				if($walkcount>1)
				{
					$walkpatient+=1;
				}
				/*else if($walkcount==1)
				{
					$walkpatient1+=1;
				}*/
		    } ?>
            <?php
		          // color row
				  $snocount = $snocount + 1;
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
			 <tr <?=$colorcode?>>
			     <td ><?=$resdpt['department'];?></td>
                 <?php if($walkpatient>0)
				 {?>
			     <td align="right" style="padding-right:8px"> <a href="view_deptstats.php?department_search=<?php echo $dpt; ?>&&location=<?php echo $location; ?>&&cbfrmflag1=<?php echo $cbfrmflag1; ?>&&ADate1=<?php echo $fromdate  ; ?>&&ADate2=<?php echo $todate; ?>" target="_blank"><strong><?= number_format($walkpatient);?></strong></a></td>
                 <?php } else {?>
                  <td align="right" style="padding-right:8px"><?= number_format($walkpatient);?></td>
                  <?php } ?>
		     </tr>
		     <?php
			    $totalvisit +=$walkpatient; 
			    //$totalvisit1 +=$walkpatient1; 
			  ?>
		 <?php } ?>
	  <tr bgcolor='#ccc'>
	  <td ><strong>Total :</strong></td>
	  <td align="right" style="padding-right:8px"><?= number_format($totalvisit);?></td>
      </tr>
	  <tr >
	  <td colspan="2">&nbsp;</td>
      </tr>
    </table></td>
  
     
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>

<?php
			}
?>
<?php include ("includes/footer1.php"); ?>
    <!-- Modern JavaScript -->
    <script src="js/departmentstatistics-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>

