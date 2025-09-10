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

$docno = $_SESSION['docno'];

if(isset($_REQUEST['searchstatus'])){$searchstatus = $_REQUEST['searchstatus'];}else{$searchstatus='';}
if(isset($_POST['ADate1'])){$fromdate = $_POST['ADate1'];}else{$fromdate=$transactiondatefrom;}
if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate=$transactiondateto;}
$patienttype=isset($_REQUEST['patienttype'])?$_REQUEST['patienttype']:'';
?>
<?php
//get location for sort by location purpose
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		 $locationcode=$location;
		}
		//location get end here
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
function pharmacy(patientcode,visitcode)
{
	var patientcode = patientcode;
	var visitcode = visitcode;
	var url="pharmacy1.php?RandomKey="+Math.random()+"&&patientcode="+patientcode+"&&visitcode="+visitcode;
	
window.open(url,"Pharmacy",'width=600,height=400');
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

<table width="103%" border="0" cellspacing="0" cellpadding="2">
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
   <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="105%" border="0" cellspacing="0" cellpadding="0">
	      
		  <tr>
        <td width="860">
              <form name="cbform1" method="post" action="samplecollectionlist_original1.php">
                <table width="599" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                   <tr bgcolor="#011E6A">
              <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong> Search Patient for Samplecollection </strong></td>
              <td colspan="1" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
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
               <select name="location" id="location" onChange=" ajaxlocationfunction(this.value);" style="border: 1px solid #001E6A;">
                  <?php
						
						$query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
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
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Status</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <select name="searchstatus" id="searchstatus">
			  <?php if($searchstatus != '') { ?>
			  <option value="<?php echo $searchstatus; ?>"><?php echo $searchstatus; ?></option>
			  <?php } ?>
			  <option value="Pending">Pending</option>
			  <option value="Completed">Completed</option>
			  <option value="Discard">Discard</option>
			  <option value="Transfer">Transfer</option>
			  </select>
              </span></td>
              </tr>
              <tr>
          <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff">Patient Type</td>
          <td colspan="3" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
		  <strong><select name="patienttype" id="patienttype" style="border: solid 1px #001E6A;">
		 <option value="All">ALL</option>
		  <option value="OP+EXTERNAL">OP + EXTERNAL</option>
		  <option value="IP">IP</option>
		  </select>
		  </strong></td>
         
        </tr>
                   <tr>
          <td width="98" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="135" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="66" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="261" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          </tr>
					
				
			<tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
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
  <tr>
   
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1224" 
            align="left" border="0">
          <tbody>
            <tr>
              <td colspan="10" bgcolor="#ecf0f5" class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left"><strong> Sample List</strong><label class="number">&nbsp;</label>
                </div></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              </tr>
            <tr>
              <td width="3%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>No.</strong></div></td>
              <td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>  Date</strong></div></td>
              <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg No </strong></div></td>
              <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit No</strong></div></td>
              <td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient</strong></div></td>
				 <td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Age</strong></div></td>
				 <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Gender</strong></div></td>
              <td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Account</strong></td>
                <td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Requested by</strong></div></td>
				 <td width="12%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Ward/Department</strong></div></td>
              <td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Action</strong></div></td>
              </tr>
		
			<?php
			
			
			if($patienttype != 'IP')
			{
			
			$colorloopcount = '';
			$sno = '';
			
			$triagedatefrom = date('Y-m-d', strtotime('-2 day'));
			$triagedateto = date('Y-m-d');
		
				//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			
			$query1 = "select patientcode,patientvisitcode,patientname,accountname,urgentstatus,consultationdate,paymentstatus,freestatus,username from consultation_lab where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and paymentstatus='completed' and labsamplecoll='$searchstatus' and billtype='PAY NOW' and freestatus='' and patientcode <> 'walkin' and consultationdate between '$fromdate' and '$todate' and locationcode='".$locationcode."' group by patientvisitcode order by consultationdate  ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];
			$urgentstatus = $res1['urgentstatus'];
			$consultationdate = $res1['consultationdate'];
			$paymentstatus = $res1['paymentstatus'];
			$freestatus = $res1['freestatus'];
			$username = $res1['username'];
			
			$userfulldetail=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$username' and locationcode='$locationcode' and username <> '' and status='Active'");
			$resuser=mysqli_fetch_array($userfulldetail);
			$userfullname=$resuser['employeename'];
			
			
			
			$query111 = "select age,gender,departmentname from master_visitentry where visitcode='$visitcode'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
			$age = $res111['age'];
			$gender = $res111['gender'];
			$department = $res111['departmentname'];
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
			 if($urgentstatus == 1)
			{
			$colorcode = 'bgcolor="#FFFF00"';
			}
			
			?>
			
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $patientcode;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><?php echo $age; ?></td>
				  <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $account; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $userfullname;?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $department; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><?php if($searchstatus != 'Completed' && $searchstatus != 'Transfer') { ?><a href="labsamplecollection.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&status=<?php echo $searchstatus; ?>"><strong>Collect</strong></a><?php } ?></div></td>
              </tr>
			<?php
			}    
			?>
			<?php
			
			$triagedatefrom = date('Y-m-d', strtotime('-2 day'));
			$triagedateto = date('Y-m-d');
		
				//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			$query1 = "select patientcode,patientvisitcode,patientname,accountname,username,urgentstatus,consultationdate,paymentstatus,freestatus from consultation_lab where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and labsamplecoll='$searchstatus' and billtype='PAY NOW' and (freestatus='NO' or freestatus='Yes') and consultationdate between '$fromdate' and '$todate'  and locationcode='".$locationcode."' group by patientvisitcode order by consultationdate  ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];
			$username = $res1['username'];
				$urgentstatus = $res1['urgentstatus'];
			$consultationdate = $res1['consultationdate'];
			$paymentstatus = $res1['paymentstatus'];
			$freestatus = $res1['freestatus'];
			
			$userfulldetail=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$username' and locationcode='$locationcode'");
			$resuser=mysqli_fetch_array($userfulldetail);
			$userfullname=$resuser['employeename'];
			if($patientcode=='walkin')
			{
				$username="self";
			}
			
			$query111 = "select age,gender,departmentname from master_visitentry where visitcode='$visitcode'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
			$age = $res111['age'];
			$gender = $res111['gender'];
			$department = $res111['departmentname'];
			
				$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$querymch1 = "select * from consultation_lab where paymentstatus='completed' and  labsamplecoll='$searchstatus' and billtype='PAY NOW' and freestatus='NO' and consultationdate between '$fromdate' and '$todate' and locationcode='".$locationcode."' group by patientvisitcode order by consultationdate  ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execmch1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numsmch1 = mysqli_num_rows($execmch1);
			if($numsmch1 != 0)
			{
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
			 if($urgentstatus == 1)
			{
			$colorcode = 'bgcolor="#FFFF00"';
			}
			?>
			
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $patientcode;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><?php echo $age; ?></td>
				  <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $account; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $userfullname;?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $department; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><?php if($searchstatus != 'Completed' && $searchstatus != 'Transfer') { ?><a href="labsamplecollection.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&status=<?php echo $searchstatus; ?>"><strong>Collect</strong></a><?php } ?></div></td>
              </tr>
			<?php
			}
			else
			{
			if($freestatus == 'Yes')
			{
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
			 if($urgentstatus == 1)
			{
			$colorcode = 'bgcolor="#FFFF00"';
			}
			?>
			
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $patientcode;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><?php echo $age; ?></td>
				  <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $account; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $userfullname;?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $department; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><?php if($searchstatus != 'Completed' && $searchstatus != 'Transfer') { ?><a href="labsamplecollection.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&status=<?php echo $searchstatus; ?>"><strong>Collect</strong></a><?php } ?></div></td>
              </tr>
			<?php 
			}
			} 
			}   
			?>
			<?php
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			
				
			
			$query1 = "select patientcode,patientvisitcode,username,patientcode,patientvisitcode,patientname,accountname,consultationdate,paymentstatus,urgentstatus from consultation_lab where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and paymentstatus = 'completed' and labsamplecoll='$searchstatus' and billtype='PAY LATER' and approvalstatus='1' and consultationdate between '$fromdate' and '$todate' and locationcode='".$locationcode."'  group by patientvisitcode order by consultationdate  ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			
			
			while ($res1 = mysqli_fetch_array($exec1))
			{
				$patientcode1 = $res1['patientcode'];
		    	$visitcode1 = $res1['patientvisitcode'];
				$username = $res1['username'];
				
				if($patientcode1=='walkin')
			{
				$username="self";
			}
				$userfulldetail=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$username' and locationcode='$locationcode' and username <> '' and status='Active'");
			$resuser=mysqli_fetch_array($userfulldetail);
			$userfullname=$resuser['employeename'];
			
				$querycheck = "select planpercentage from master_visitentry where patientcode ='".$patientcode1."' and visitcode ='".$visitcode1."' and locationcode='".$locationcode."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execcheck = mysqli_query($GLOBALS["___mysqli_ston"], $querycheck) or die ("Error in Querycheck".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rescheck = mysqli_fetch_array($execcheck);
			$planpercentage = $rescheck['planpercentage'];
			
			
				$queryche = "select * from master_transactionpaylater where  patientcode ='".$patientcode1."' and visitcode ='".$visitcode1."' and locationcode='".$locationcode."' and transactiontype <> 'pharmacycredit'  ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execche = mysqli_query($GLOBALS["___mysqli_ston"], $queryche) or die ("Error in Queryche".mysqli_error($GLOBALS["___mysqli_ston"]));
			$billpaylatercount=mysqli_num_rows($execche);
				
			if($billpaylatercount==0 && $planpercentage=='0.00')
			{	
			
			
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];
			$consultationdate = $res1['consultationdate'];
			$paymentstatus = $res1['paymentstatus'];
			$query111 = "select age,gender,departmentname from master_visitentry where visitcode='$visitcode'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
			$age = $res111['age'];
			$gender = $res111['gender'];
			$department = $res111['departmentname'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$urgentstatus = $res1['urgentstatus'];
			
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
			 if($urgentstatus == 1)
			{
				$colorcode = 'bgcolor="#FFFF00"';
			}
			?>
			
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $patientcode;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $age; ?></td>
				  <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $account; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $userfullname;?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $department; ?></td>

              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><?php if($searchstatus != 'Completed' && $searchstatus != 'Transfer') { ?><a href="labsamplecollection.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&status=<?php echo $searchstatus; ?>"><strong>Collect</strong></a><?php } ?></div></td>
              </tr>
			<?php
			}   } 
			$query1 = "select username,patientname,billnumber,consultationdate from consultation_lab where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and  paymentstatus='paid' and labsamplecoll='$searchstatus' and patientcode='walkin' and consultationdate between '$fromdate' and '$todate' and locationcode='".$locationcode."' group by billnumber order by consultationdate  ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$patientfullname = $res1['patientname'];
			$username = $res1['username'];
			
			
			if($patientcode=="walkin")
			{
				$username="self";
			}
			
			
			$query111 = "select age,gender from billing_external where patientname='$patientfullname'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
			$age = $res111['age'];
			$gender = $res111['gender'];
			
			$query11="select * from billing_external where patientname='$patientfullname'";
			$exec11=mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11=mysqli_fetch_array($exec11);
			$billnumber=$res1['billnumber'];
			
			$consultationdate = $res1['consultationdate'];
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
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo "DIRECT";?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo "DIRECT"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><?php echo $age; ?></td>
				  <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo "EXTERNAL"; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo "SELF";?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo "EXTERNAL"; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><?php if($searchstatus != 'Completed' && $searchstatus != 'Transfer') { ?><a href="externallabsamplecollection.php?billnumber=<?php echo $billnumber; ?>&&status=<?php echo $searchstatus; ?>"><strong>Collect</strong></a><?php } ?></div></td>
              </tr>
			<?php
			}  
			$query1 = "select patientname,username,billnumber,consultationdate from consultation_lab where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and  paymentstatus='completed' and labsamplecoll='$searchstatus' and patientcode='walkin' and consultationdate between '$fromdate' and '$todate' and locationcode='".$locationcode."' group by billnumber order by consultationdate  ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
		 	 $patientfullname = $res1['patientname'];
			$username = $res1['username'];
			
			
			
			$query111 = "select age,gender from billing_external where patientname='$patientfullname'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
			$age = $res111['age'];
			$gender = $res111['gender'];
			//$billnumber=$res111['billno'];
			
			$query11="select * from billing_external where patientname='$patientfullname'";
			$exec11=mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11=mysqli_fetch_array($exec11);
			$billnumber=$res1['billnumber'];
			
			$consultationdate = $res1['consultationdate'];
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
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo "DIRECT";?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo "DIRECT"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><?php echo $age; ?></td>
				  <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo "EXTERNAL"; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo "SELF";?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo "EXTERNAL"; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><?php if($searchstatus != 'Completed' && $searchstatus != 'Transfer') { ?><a href="externallabsamplecollection.php?billnumber=<?php echo $billnumber; ?>&&status=<?php echo $searchstatus; ?>"><strong>Collect</strong></a><?php } ?></div></td>
              </tr>
			<?php
			}      
			?>
            
            <?php
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			
				
			
			$query1 = "select patientcode,patientvisitcode,username,patientcode,patientvisitcode,patientname,accountname,consultationdate,paymentstatus,urgentstatus from consultation_lab where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and paymentstatus = 'pending' and labsamplecoll='$searchstatus' and billtype='PAY LATER' and approvalstatus!='0' and consultationdate between '$fromdate' and '$todate' and locationcode='".$locationcode."' and copay <> 'completed'  group by patientvisitcode order by consultationdate  ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			
			
			while ($res1 = mysqli_fetch_array($exec1))
			{
				$patientcode1 = $res1['patientcode'];
		    	$visitcode1 = $res1['patientvisitcode'];
				$username = $res1['username'];
			$userfulldetail=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$username' and locationcode='$locationcode' and username <> '' and status='Active'");
			$resuser=mysqli_fetch_array($userfulldetail);
			$userfullname=$resuser['employeename'];	
				
				if($patientcode1=='walkin')
			{
				$username="self";
			}
				
				
				$querycheck = "select planpercentage,planname,planfixedamount from master_visitentry where patientcode ='".$patientcode1."' and visitcode ='".$visitcode1."' and locationcode='".$locationcode."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execcheck = mysqli_query($GLOBALS["___mysqli_ston"], $querycheck) or die ("Error in Querycheck".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rescheck = mysqli_fetch_array($execcheck);
			$planpercentage = $rescheck['planpercentage'];
			$plannumber = $rescheck['planname'];
			$planfixedamount = $rescheck['planfixedamount'];
			
			$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resplanname = mysqli_fetch_array($execplanname);
		 	$planforall = $resplanname['forall'];
			
			
				$queryche = "select * from master_transactionpaylater where  patientcode ='".$patientcode1."' and visitcode ='".$visitcode1."' and locationcode='".$locationcode."' and transactiontype <> 'pharmacycredit'   ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execche = mysqli_query($GLOBALS["___mysqli_ston"], $queryche) or die ("Error in Queryche".mysqli_error($GLOBALS["___mysqli_ston"]));
			$billpaylatercount=mysqli_num_rows($execche);
				
			if($billpaylatercount==0 && $planpercentage!='0.00' && $planfixedamount==0.00)
			{	
			
			
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];
			$consultationdate = $res1['consultationdate'];
			$paymentstatus = $res1['paymentstatus'];
			$query111 = "select age,gender,departmentname from master_visitentry where visitcode='$visitcode'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
			$age = $res111['age'];
			$gender = $res111['gender'];
			$department = $res111['departmentname'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$urgentstatus = $res1['urgentstatus'];
			
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
			 if($urgentstatus == 1)
			{
				$colorcode = 'bgcolor="#FFFF00"';
			}
			?>
			
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $patientcode;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $age; ?></td>
				  <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $account; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $userfullname;?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $department; ?></td>

              <td class="bodytext31" valign="center" align="left">
			    <div align="left">Collect Copay</div></td>
              </tr>
			<?php
			}   } ?>
            
            <?php
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			
				
			
			$query1 = "select patientcode,patientvisitcode,username,consultationid,patientcode,patientvisitcode,patientname,accountname,consultationdate,paymentstatus,urgentstatus from consultation_lab where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and paymentstatus = 'completed' and labsamplecoll='$searchstatus' and billtype='PAY LATER' and approvalstatus='1' and consultationdate between '$fromdate' and '$todate' and locationcode='".$locationcode."'  and copay = 'completed'  group by patientvisitcode order by consultationdate  ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			
			
			while ($res1 = mysqli_fetch_array($exec1))
			{
				$patientcode1 = $res1['patientcode'];
		    	$visitcode1 = $res1['patientvisitcode'];
				$username = $res1['username'];
				
				$consultationid = $res1['consultationid'];
				
			$userfulldetail=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$username' and locationcode='$locationcode' and username <> '' and status='Active'");
			$resuser=mysqli_fetch_array($userfulldetail);
			$userfullname=$resuser['employeename'];	
				
				if($patientcode1=='walkin')
			{
				$username="self";
			}
				
				
				$querycheck = "select planpercentage,planname from master_visitentry where patientcode ='".$patientcode1."' and visitcode ='".$visitcode1."' and locationcode='".$locationcode."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execcheck = mysqli_query($GLOBALS["___mysqli_ston"], $querycheck) or die ("Error in Querycheck".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rescheck = mysqli_fetch_array($execcheck);
			$planpercentage = $rescheck['planpercentage'];
			$plannumber = $rescheck['planname'];
			
			$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resplanname = mysqli_fetch_array($execplanname);
		 	$planforall = $resplanname['forall'];
			
			
				$queryche = "select * from master_transactionpaylater where  patientcode ='".$patientcode1."' and visitcode ='".$visitcode1."' and locationcode='".$locationcode."'  and transactiontype <> 'pharmacycredit'";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execche = mysqli_query($GLOBALS["___mysqli_ston"], $queryche) or die ("Error in Queryche".mysqli_error($GLOBALS["___mysqli_ston"]));
			$billpaylatercount=mysqli_num_rows($execche);
				
			if( $planpercentage!='0.00' && $planforall =='yes')
			{	
			
			
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];
			$consultationdate = $res1['consultationdate'];
			$paymentstatus = $res1['paymentstatus'];
			$query111 = "select * from master_visitentry where visitcode='$visitcode'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
			$age = $res111['age'];
			$gender = $res111['gender'];
			$department = $res111['departmentname'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$urgentstatus = $res1['urgentstatus'];
			
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
			 if($urgentstatus == 1)
			{
				$colorcode = 'bgcolor="#FFFF00"';
			}
			?>
			
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $patientcode;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $age; ?></td>
				  <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $account; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $userfullname;?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $department; ?></td>

              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><?php if($searchstatus != 'Completed' && $searchstatus != 'Transfer') { ?><a href="labsamplecollection.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&consultationid=<?php echo $consultationid;?>&&status=<?php echo $searchstatus; ?>"><strong>Collect</strong></a><?php } ?></div></td>
              </tr>
			<?php
			}   } ?>
             <?php
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			
				
			
			$query1 = "select patientcode,patientvisitcode,patientname,username,patientcode,patientvisitcode,patientname,accountname,consultationdate,paymentstatus,urgentstatus,consultationid from consultation_lab where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and paymentstatus = 'completed' and labsamplecoll='$searchstatus' and billtype='PAY LATER' and approvalstatus='1' and consultationdate between '$fromdate' and '$todate' and locationcode='".$locationcode."'  and copay = 'completed'  group by patientvisitcode order by consultationdate  ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			
			
			while ($res1 = mysqli_fetch_array($exec1))
			{
				$patientcode1 = $res1['patientcode'];
		    	$visitcode1 = $res1['patientvisitcode'];
				 $visitcode1patientname = $res1['patientname'];
				 $username = $res1['username'];
				
				$consultationid = $res1['consultationid'];
				$userfulldetail=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$username' and locationcode='$locationcode' and username <> '' and status='Active'");
			$resuser=mysqli_fetch_array($userfulldetail);
			$userfullname=$resuser['employeename'];
			
				if($patientcode1=='walkin')
			{
				$username="self";
			}
				
				$querycheck = "select planpercentage,planname from master_visitentry where patientcode ='".$patientcode1."' and visitcode ='".$visitcode1."' and locationcode='".$locationcode."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execcheck = mysqli_query($GLOBALS["___mysqli_ston"], $querycheck) or die ("Error in Querycheck".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rescheck = mysqli_fetch_array($execcheck);
			$planpercentage = $rescheck['planpercentage'];
			$plannumber = $rescheck['planname'];
			
			$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resplanname = mysqli_fetch_array($execplanname);
		 	$planforall = $resplanname['forall'];
			
			
				$queryche = "select * from master_transactionpaylater where  patientcode ='".$patientcode1."' and visitcode ='".$visitcode1."' and locationcode='".$locationcode."' and transactiontype <> 'pharmacycredit' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execche = mysqli_query($GLOBALS["___mysqli_ston"], $queryche) or die ("Error in Queryche".mysqli_error($GLOBALS["___mysqli_ston"]));
			$billpaylatercount=mysqli_num_rows($execche);
				
			if( $planpercentage!='0.00' && $planforall =='')
			{	
			
			
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];
			$consultationdate = $res1['consultationdate'];
			$paymentstatus = $res1['paymentstatus'];
			$query111 = "select age,gender,departmentname from master_visitentry where visitcode='$visitcode'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
			$age = $res111['age'];
			$gender = $res111['gender'];
			$department = $res111['departmentname'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$urgentstatus = $res1['urgentstatus'];
			
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
			 if($urgentstatus == 1)
			{
				$colorcode = 'bgcolor="#FFFF00"';
			}
			?>
			
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $patientcode;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $age; ?></td>
				  <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $account; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $userfullname;?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $department; ?></td>

              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><?php if($searchstatus != 'Completed' && $searchstatus != 'Transfer') { ?><a href="labsamplecollection.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&consultationid=<?php echo $consultationid;?>&&status=<?php echo $searchstatus; ?>"><strong>Collect</strong></a><?php } ?></div></td>
              </tr>
			<?php
			}   }
			}?>
            
            <?php
            if($patienttype !='OP+EXTERNAL')
			{
            $triagedatefrom = date('Y-m-d', strtotime('-2 day'));
			$triagedateto = date('Y-m-d');
		
				//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			$query1 = "select patientcode,patientvisitcode,patientname,accountname,username,urgentstatus,consultationdate from ipconsultation_lab where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and labsamplecoll='pending' and billtype='PAY NOW' and locationcode = '$location' and consultationdate between '$fromdate' and '$todate' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];
			$username = $res1['username'];
				$urgentstatus = $res1['urgentstatus'];
			$consultationdate = $res1['consultationdate'];
				$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			
			$userfulldetail=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$username' and locationcode='$locationcode' and username <> '' and status='Active'");
			$resuser=mysqli_fetch_array($userfulldetail);
			$userfullname=$resuser['employeename'];
			
				if($patientcode=='walkin')
			{
				$username="self";
			}
			
			
				
			$query111 = "select age,gender from master_customer where customercode='$patientcode'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
			$age = $res111['age'];
			$gender = $res111['gender'];
			
		 	$warddate="select ward from master_ward where auto_number in(select ward from ip_bedallocation where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus NOT IN ('discharged','transfered'))";
		
			$exeward=mysqli_query($GLOBALS["___mysqli_ston"], $warddate);
			$resward=mysqli_fetch_array($exeward);
			$ward=$resward['ward'];
			$numrow=mysqli_num_rows($exeward);
					if($numrow =='0')

{			$warddate1="select ward from master_ward where auto_number in(select ward from ip_bedtransfer where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus NOT IN ('discharged','transfered') )";
		
			$exeward1=mysqli_query($GLOBALS["___mysqli_ston"], $warddate1);
			$resward1=mysqli_fetch_array($exeward1);
			$ward=$resward1['ward'];
			
}
			
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
			 if($urgentstatus == 1)
			{
			$colorcode = 'bgcolor="#FFFF00"';
			}
			?>
			
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $patientcode;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><?php echo $age; ?></td>
				  <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $account; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $userfullname;?></td>
                 <td class="bodytext31" valign="center"  align="left"><?php echo $ward; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><a href="iplabsamplecollection.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><strong>Collect</strong></a></div></td>
              </tr>
			<?php
			}    
			?>
			<?php
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			$query1 = "select patientcode,patientvisitcode,patientname,accountname,username,consultationdate,urgentstatus from ipconsultation_lab where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and labsamplecoll='pending' and billtype='PAY LATER' and locationcode = '$location' and consultationdate between '$fromdate' and '$todate' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];
			$username = $res1['username'];
			$consultationdate = $res1['consultationdate'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
				$urgentstatus = $res1['urgentstatus'];
				$userfulldetail=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$username' and locationcode='$locationcode' and username <> '' and status='Active'");
			$resuser=mysqli_fetch_array($userfulldetail);
			$userfullname=$resuser['employeename'];
				
					if($patientcode=='walkin')
			{
				$username="self";
			}
				
			
			$query111 = "select age,gender from master_customer where customercode='$patientcode'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
			$age = $res111['age'];
			$gender = $res111['gender'];
			
				$warddate="select ward from master_ward where auto_number in(select ward from ip_bedallocation where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus NOT IN ('discharged','transfered') )";
			
			$exeward=mysqli_query($GLOBALS["___mysqli_ston"], $warddate);
			
			$resward=mysqli_fetch_array($exeward);
			$ward=$resward['ward'];
			$numrow=mysqli_num_rows($exeward);
			if($numrow =='0')

{			$warddate1="select ward from master_ward where auto_number in(select ward from ip_bedtransfer where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus NOT IN ('discharged','transfered') )";
		
			$exeward1=mysqli_query($GLOBALS["___mysqli_ston"], $warddate1);
			$resward1=mysqli_fetch_array($exeward1);
			$ward=$resward1['ward'];
			
}
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
			 if($urgentstatus == 1)
			{
				$colorcode = 'bgcolor="#FFFF00"';
			}
			?>
			
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $patientcode;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><?php echo $age; ?></td>
				  <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $account; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $userfullname;?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $ward; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><a href="iplabsamplecollection.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><strong>Collect</strong></a></div></td>
              </tr>
			<?php
			} 
			}
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              </tr>
          </tbody>
        </table></td>
      </tr>
	  <?php } ?>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

