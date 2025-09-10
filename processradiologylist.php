<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");//echo $menu_id;include ("includes/check_user_access.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
if(isset($_REQUEST['searchstatus'])){$searchstatus = $_REQUEST['searchstatus'];}else{$searchstatus='';}
$patienttype=isset($_REQUEST['patienttype'])?$_REQUEST['patienttype']:'';
if(isset($_POST['ADate1'])){$fromdate = $_POST['ADate1'];}else{$fromdate=$transactiondatefrom;}
if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate=$transactiondateto;}

if(isset($_POST['category_id'])){$category_id = $_POST['category_id'];}else{$category_id='';}

$timeonly = date('H:i:s');
$dateonly=date("Y-m-d");

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
padding-left:900px;
text-align:right;
font-weight:bold;
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

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
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; }
-->
</style>
</head>
<?php
function calculate_age($birthday)
{
 
 if($birthday=="0000-00-00")
 {
  return "0 Days";
 }
 
    $today = new DateTime();
    $diff = $today->diff(new DateTime($birthday));

    if ($diff->y)
    {
        return $diff->y . ' Years';
    }
    elseif ($diff->m)
    {
        return $diff->m . ' Months';
    }
    else
    {
        return $diff->d . ' Days';
    }
}
?>
<?php

function get_time($g_datetime){
$from=date_create(date('Y-m-d H:i:s',strtotime($g_datetime)));
$to=date_create(date('Y-m-d H:i:s'));
$diff=date_diff($to,$from);
//print_r($diff);
$y = $diff->y > 0 ? $diff->y.' Years <br>' : '';
$m = $diff->m > 0 ? $diff->m.' Months <br>' : '';
$d = $diff->d > 0 ? $diff->d.' Days <br>' : '';
$h = $diff->h > 0 ? $diff->h.' Hrs <br>' : '';
$mm = $diff->i > 0 ? $diff->i.' Mins <br>' : '';
$ss = $diff->s > 0 ? $diff->s.' Secs <br>' : '';

echo $y.' '.$m.' '.$d.' '.$h.' '.$mm.' '.$ss.' ';
}

?>
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
              <form name="cbform1" method="post" action="processradiologylist.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                  <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong> Radiology Process List </strong></td>
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
                  <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td  bgcolor="#FFFFFF" class="bodytext3"  colspan="3" ><select name="location" id="location"  onChange=" ajaxlocationfunction(this.value);" style="border: 1px solid #001E6A;">
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
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Category</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <select name="category_id">
			  <option value="" >All</option>
				<?php
						$queryaa1 = "select categoryname,auto_number from master_categoryradiology order by categoryname ";
						$execaa1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryaa1) or die ("Error in Queryaa1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($resaa1 = mysqli_fetch_array($execaa1))
						{
				
						$data_count=0;
						$categoryname = $resaa1["categoryname"];
						$auto_number = $resaa1["auto_number"];
					?>
						<option value="<?= $auto_number; ?>" <?php if($auto_number==$category_id) echo "selected"; ?> > <?= $categoryname ?> </option>
					<?php
					}
				 ?>
				 </select>
				</td>
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
          <td width="100" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="137" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
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
                          <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
                    </tr>
                  </tbody>
                </table>
              </form>		</td>
      </tr>
  
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
	  <?php if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$searchpatient = $_POST['patient'];
	$searchpatientcode=$_POST['patientcode'];
	$searchvisitcode = $_POST['visitcode'];
	$fromdate=$_POST['ADate1'];
	$todate=$_POST['ADate2'];
	
	?>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1275" 
            align="left" border="0">
          <tbody>
		  
            <tr>
              <td colspan="13" bgcolor="#ecf0f5" class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left"><strong>Search Radiology result reporting</strong><label class="number"></label></div></td>
				<td width="3%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>No.</strong></div></td>
              <td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> OP Date</strong></div></td>
              <td width="3%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> OP Time</strong></div></td>
              <td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patientcode </strong></div></td>
              <td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visitcode</strong></div></td>
              <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient</strong></div></td>
              <td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Age</strong></td>
              <td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="style1">Gender</td>
              <td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Test</strong></td>
              <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Account</strong></td>
				 <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Requested by</strong></div></td>
				 <td width="12%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Ward/Department</strong></div></td>
              <td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Action</strong></div></td>
              <td width="3%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Time</strong></div></td>
              </tr>

<?php
			$colorloopcount = '';
			$sno = '';

	if($category_id!='')
	{
	    $queryaa1 = "select * from master_categoryradiology where auto_number='$category_id' order by categoryname ";
	}else{
	    $queryaa1 = "select * from master_categoryradiology order by categoryname ";
		}
		$execaa1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryaa1) or die ("Error in Queryaa1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($resaa1 = mysqli_fetch_array($execaa1))
		{

		$data_count=0;
		$categoryname = $resaa1["categoryname"];
		$auto_number = $resaa1["auto_number"];
?>
	<tr>
              <td  align="left" valign="center" 
                bgcolor="#ccc" class="bodytext31" colspan="14"><div align="left"><strong><?= $categoryname?></strong></div></td>
	</tr>

			<?php
			
			$triagedatefrom = date('Y-m-d', strtotime('-2 day'));
			$triagedateto = date('Y-m-d');
			
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			$query1 = "select a.* from consultation_radiology as a JOIN master_radiology as b ON a.radiologyitemcode=b.itemcode and b.categoryname='$categoryname' where a.patientname like '%$searchpatient%' and a.patientcode like '%$searchpatientcode%' and a.patientvisitcode like '%$searchvisitcode%' and a.prepstatus='completed' and a.imgaquistatus='completed' and a.billtype='PAY NOW' and a.resultentry='$searchstatus' and (a.paymentstatus='completed' OR a.paymentstatus='paid') and  a.consultationdate between '$fromdate' and '$todate' and a.pkg_process='pending' and a.locationcode='".$locationcode."' group by a.patientvisitcode,a.radiologyitemcode,a.refno order by a.consultationdate ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			if($patienttype!='IP')
			{			
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$res1patientcode = $res1['patientcode'];
			$res1visitcode = $res1['patientvisitcode'];
			$res1patientfullname = $res1['patientname'];
			$res1account = $res1['accountname'];
			$res1consultationdate = $res1['consultationdate'];
			$billnumber=$res1['billnumber'];
			$urgent=$res1['urgentstatus'];
			$username = $res1['username'];
			
			$consultationtime = $res1['consultationtime'];
			$radiologyitemcode = $res1['radiologyitemcode'];
			$radiologyitemname = $res1['radiologyitemname'];
//			$refno = $res1['refno'];
			$refno = $res2['auto_number'];


				$consultationdate = $res1['consultationdate'];
				$diff = abs(strtotime($consultationdate) - strtotime($dateonly));
				$years = floor($diff / (365*60*60*24));
				$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
				$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

				$waitingtime = (strtotime($timeonly) - strtotime($consultationtime))/60;
				$waitingtime = round($waitingtime);
				$waitingtime = abs($waitingtime);
					$waitingtime1 = $waitingtime;
					$days=$days;

			$userfulldetail=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$username' and locationcode='$locationcode'");
			$resuser=mysqli_fetch_array($userfulldetail);
			$userfullname=$resuser['employeename'];

	        $query11 = "select * from master_customer where customercode = '$res1patientcode' and status = '' ";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11 = mysqli_fetch_array($exec11);
			
			//$patientcodedob = $res111['patientcode'];
$query69="select * from master_customer where customercode='$res1patientcode'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
 $patientdob=$res69['dateofbirth'];
			$res11age = $res11['age'];
			$res11gender= $res11['gender'];
			
			$query111 = "select * from master_visitentry where patientcode = '$res1patientcode' ";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
			$res111consultingdoctor = $res111['consultingdoctor'];
			$res1111department = $res111['departmentname'];
			
			
			//check that patient is a external patient
			if($res1patientcode=='walkin')
			{
			$query11="select * from billing_external where billno='$billnumber'";
			$exec11=mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11=mysqli_fetch_array($exec11);
			
			
			$res11age=$res11['age'];
			$res11gender= $res11['gender'];
			$res1111department = 'External';
			$res1visitcode =$res1['billnumber'];
			//$res1account = 'External';
			}
			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			if($urgent==1)
{
	$colorcode = 'bgcolor="#F96363"';
	
}
else
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
}
$data_count++;

			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res1consultationdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationtime; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><a href="emr2.php?patientcode=<?php echo $res1patientcode?>&&visitcode=<?php echo $res1visitcode?>">
			      <?php echo $res1patientcode;?></a></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res1visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res1patientfullname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo calculate_age($patientdob); ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res11gender; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $radiologyitemname; ?></div></td>
       
              <td class="bodytext31" valign="center"  align="left"><?php echo $res1account; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $userfullname;?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $res1111department; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><a href="processradiology.php?patientcode=<?php echo $res1patientcode; ?>&&visitcode=<?php echo $res1visitcode; ?>&&q_itemcode=<?= $radiologyitemcode ?>&&refnumber=<?= $refno ?>"><strong>Process</strong></a></div></td>
				<td align="left" valign="center"  
                class="bodytext31" <?php if($waitingtime1 > 15 || $days > 1){ ?> bgcolor=" #FF0040" <?php } ?>><div align="center"><strong>
				<?php $datetime1=$res1['aquisition_datetime']; get_time($datetime1); ?></strong></div></td>

              </tr>
			<?php
			} 
			   
			?>
			<?php
			
			$query2 = "select a.* from consultation_radiology as a JOIN master_radiology as b ON a.radiologyitemcode=b.itemcode and b.categoryname='$categoryname' where a.patientname like '%$searchpatient%' and a.patientcode like '%$searchpatientcode%' and a.patientvisitcode like '%$searchvisitcode%' and a.prepstatus='completed' and a.imgaquistatus='completed' and billtype='PAY LATER' and a.paymentstatus='completed' and a.resultentry='$searchstatus' and   a.consultationdate between '$fromdate' and '$todate'  and a.locationcode='".$locationcode."' and a.pkg_process='pending' and a.approvalstatus='1' group by a.patientvisitcode,a.radiologyitemcode,a.refno order by a.consultationdate ";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res2 = mysqli_fetch_array($exec2))
			{
			$res2patientcode = $res2['patientcode'];
			$res2visitcode = $res2['patientvisitcode'];
			$res2patientfullname = $res2['patientname'];
			$res2account = $res2['accountname'];
			$res2consultationdate = $res2['consultationdate'];

			$res1consultationdate = $res2consultationdate;
			$consultationtime = $res2['consultationtime'];
			$radiologyitemcode = $res2['radiologyitemcode'];
			$radiologyitemname = $res2['radiologyitemname'];
//			$refno = $res2['refno'];
			$refno = $res2['auto_number'];


				$consultationdate = $res2['consultationdate'];
				$diff = abs(strtotime($consultationdate) - strtotime($dateonly));
				$years = floor($diff / (365*60*60*24));
				$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
				$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

				$waitingtime = (strtotime($timeonly) - strtotime($consultationtime))/60;
				$waitingtime = round($waitingtime);
				$waitingtime = abs($waitingtime);
					$waitingtime1 = $waitingtime;
					$days=$days;

			$username = $res2['username'];
			$userfulldetail=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$username' and locationcode='$locationcode'");
			$resuser=mysqli_fetch_array($userfulldetail);
			$userfullname=$resuser['employeename'];
			
			$query12 = "select * from master_customer where customercode = '$res2patientcode' and status = '' ";
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res12 = mysqli_fetch_array($exec12);
			$res12age = $res12['age'];
		//	$patientcodedob = $res111['patientcode'];
$query69="select * from master_customer where customercode='$res2patientcode'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
 $patientdob=$res69['dateofbirth'];
			$res12gender= $res12['gender'];
			
			$query112 = "select * from master_visitentry where patientcode = '$res2patientcode' ";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res112 = mysqli_fetch_array($exec112);
			$res112consultingdoctor = $res112['consultingdoctor'];
			$res1112department = $res112['departmentname'];
			
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
			$data_count++;

			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2consultationdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationtime; ?></div></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><a href="emr2.php?patientcode=<?php echo $res2patientcode?>&&visitcode=<?php echo $res2visitcode?>">
			      <?php echo $res2patientcode;?></a></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientfullname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo calculate_age($patientdob); ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res12gender; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $radiologyitemname; ?></div></td>          
              <td class="bodytext31" valign="center"  align="left"><?php echo $res2account; ?></td>
			    <td class="bodytext31" valign="center"  align="left"><?php echo $userfullname;?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $res1112department; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><a href="processradiology.php?patientcode=<?php echo $res2patientcode; ?>&&visitcode=<?php echo $res2visitcode; ?>&&q_itemcode=<?= $radiologyitemcode ?>&&refnumber=<?= $refno ?>"><strong>Process</strong></a></div></td>
				<td align="left" valign="center"  
                class="bodytext31" <?php if($waitingtime1 > 15 || $days > 1){ ?> bgcolor=" #FF0040" <?php } ?>><div align="center"><strong>
				<?php $datetime1=$res2['aquisition_datetime']; get_time($datetime1); ?></strong></div></td>
              </tr>
			<?php
			}    
			?>
            
            <?php
			  
			$query2 = "select a.* from consultation_radiology as a JOIN master_radiology as b ON a.radiologyitemcode=b.itemcode and b.categoryname='$categoryname' where a.locationcode = '".$locationcode."' and a.patientname like '%$searchpatient%' and a.patientcode like '%$searchpatientcode%' and a.patientvisitcode like '%$searchvisitcode%' and a.paymentstatus='pending' and a.prepstatus='completed' and a.imgaquistatus='completed' and a.billtype='PAY LATER' and a.approvalstatus='1' and a.resultentry='$searchstatus' and a.consultationdate between '$fromdate' and '$todate' and a.pkg_process='pending' group by a.patientvisitcode,a.radiologyitemcode,a.refno order by a.consultationdate";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res2 = mysqli_fetch_array($exec2))
			{
			$res2patientcode = $res2['patientcode'];
			$res2visitcode = $res2['patientvisitcode'];
			$res2patientfullname = $res2['patientname'];
			$res2account = $res2['accountname'];
			$res2consultationdate = $res2['consultationdate'];

			$res1consultationdate = $res2consultationdate;

			$consultationtime = $res2['consultationtime'];
			$radiologyitemcode = $res2['radiologyitemcode'];
			$radiologyitemname = $res2['radiologyitemname'];
//			$refno = $res2['refno'];
			$refno = $res2['auto_number'];


				$consultationdate = $res2['consultationdate'];
				$diff = abs(strtotime($consultationdate) - strtotime($dateonly));
				$years = floor($diff / (365*60*60*24));
				$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
				$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

				$waitingtime = (strtotime($timeonly) - strtotime($consultationtime))/60;
				$waitingtime = round($waitingtime);
				$waitingtime = abs($waitingtime);
					$waitingtime1 = $waitingtime;
					$days=$days;

			$username = $res1['username'];
			$userfulldetail=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$username' and locationcode='$locationcode'");
			$resuser=mysqli_fetch_array($userfulldetail);
			$userfullname=$resuser['employeename'];
			
			$query12 = "select * from master_customer where customercode = '$res2patientcode' and status = '' ";
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res12 = mysqli_fetch_array($exec12);
			
			$query69="select * from master_customer where customercode='$res2patientcode'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
 $patientdob=$res69['dateofbirth'];
	
			$res12age = $res12['age'];
			$res12gender= $res12['gender'];
			
			$query112 = "select * from master_visitentry where patientcode = '$res2patientcode' ";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res112 = mysqli_fetch_array($exec112);
			$res112consultingdoctor = $res112['consultingdoctor'];
			$res1112department = $res112['departmentname'];
			$planfixedamount = $res112['planfixedamount'];
			
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
			if($planfixedamount==0.00)
			{
			$data_count++;

			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2consultationdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationtime; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><a href="emr2.php?patientcode=<?php echo $res2patientcode?>&&visitcode=<?php echo $res2visitcode?>">
			      <?php echo $res2patientcode;?></a></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientfullname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo calculate_age($patientdob); ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res12gender; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $radiologyitemname; ?></div></td>             
              <td class="bodytext31" valign="center"  align="left"><?php echo $res2account; ?></td>
			    <td class="bodytext31" valign="center"  align="left"><?php echo $userfullname;?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $res1112department; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left">Collect Copay</div></td>
				<td align="left" valign="center"  
                class="bodytext31" <?php if($waitingtime1 > 15 || $days > 1){ ?> bgcolor=" #FF0040" <?php } ?>><div align="center"><strong>
				<?php $datetime1=$res2['aquisition_datetime']; get_time($datetime1); ?></strong></div></td>
              </tr>
			<?php
			}
			}    
			
			}  //op if condition
			//ip consult
			if($patienttype!='OP+EXTERNAL'){
			
			$query1 = "select a.* from ipconsultation_radiology as a JOIN master_radiology as b ON a.radiologyitemcode=b.itemcode and b.categoryname='$categoryname' where a.patientname like '%$searchpatient%' and a.patientcode like '%$searchpatientcode%' and a.patientvisitcode like '%$searchvisitcode%' and a.prepstatus='completed' and a.imgaquistatus='completed' and a.billtype='PAY NOW' and a.resultentry='$searchstatus' and a.consultationdate between '$fromdate' and '$todate'  and a.locationcode='".$locationcode."' and a.pkg_process='pending' group by a.patientvisitcode,a.radiologyitemcode,a.refno order by a.consultationdate";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$res1patientcode = $res1['patientcode'];
			$res1visitcode = $res1['patientvisitcode'];
			$res1patientfullname = $res1['patientname'];
			$res1account = $res1['accountname'];
			$res1consultationdate = $res1['consultationdate'];
			$username = $res1['username'];
			$userfulldetail=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$username' and locationcode='$locationcode'");
			$resuser=mysqli_fetch_array($userfulldetail);
			$userfullname=$resuser['employeename'];

			$consultationtime = $res1['consultationtime'];
			$radiologyitemcode = $res1['radiologyitemcode'];
			$radiologyitemname = $res1['radiologyitemname'];
			$refno = $res1['auto_number'];

				$consultationdate = $res1['consultationdate'];
				$diff = abs(strtotime($consultationdate) - strtotime($dateonly));
				$years = floor($diff / (365*60*60*24));
				$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
				$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

				$waitingtime = (strtotime($timeonly) - strtotime($consultationtime))/60;
				$waitingtime = round($waitingtime);
				$waitingtime = abs($waitingtime);
					$waitingtime1 = $waitingtime;
					$days=$days;

			$query11 = "select * from master_customer where customercode = '$res1patientcode' and status = '' ";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11 = mysqli_fetch_array($exec11);
			
			$query69="select * from master_customer where customercode='$res1patientcode'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
 $patientdob=$res69['dateofbirth'];
	
			$res11age = $res11['age'];
			$res11gender= $res11['gender'];
			$query112 = "select * from master_visitentry where patientcode = '$res1patientcode' ";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res112 = mysqli_fetch_array($exec112);
			$res112consultingdoctor = $res112['consultingdoctor'];
			$res1112department = $res112['departmentname'];
			
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
			$data_count++;

			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res1consultationdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationtime; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $res1patientcode;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res1visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res1patientfullname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo calculate_age($patientdob); ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res11gender; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $radiologyitemname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res1account; ?></td>
			    <td class="bodytext31" valign="center"  align="left"><?php echo $userfullname;?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $res1112department; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><a href="processipradiology.php?patientcode=<?php echo $res1patientcode; ?>&&visitcode=<?php echo $res1visitcode; ?>&&q_itemcode=<?= $radiologyitemcode ?>&&refnumber=<?= $refno ?>"><strong>Process</strong></a></div></td>
				<td align="left" valign="center"  
                class="bodytext31" <?php if($waitingtime1 > 15 || $days > 1){ ?> bgcolor=" #FF0040" <?php } ?>><div align="center"><strong>
				<?php $datetime1=$res1['aquisition_datetime']; get_time($datetime1); ?></strong></div></td>
              </tr>
			<?php
			}    
			?>
			<?php 
			
			$query2 = "select a.* from ipconsultation_radiology as a JOIN master_radiology as b ON a.radiologyitemcode=b.itemcode and b.categoryname='$categoryname' where a.patientname like '%$searchpatient%' and a.patientcode like '%$searchpatientcode%' and a.patientvisitcode like '%$searchvisitcode%' and a.prepstatus='completed' and a.imgaquistatus='completed' and a.billtype='PAY LATER' and a.resultentry='$searchstatus' and  a.consultationdate between '$fromdate' and '$todate' and a.locationcode='".$locationcode."' and a.pkg_process='pending' group by a.patientvisitcode,a.radiologyitemcode,a.refno order by a.consultationdate ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res2 = mysqli_fetch_array($exec2))

			{
			$res2patientcode = $res2['patientcode'];
			$res2visitcode = $res2['patientvisitcode'];
			$res2patientfullname = $res2['patientname'];
			$res2account = $res2['accountname'];
			$res2consultationdate = $res2['consultationdate'];
			$username = $res1['username'];
			$userfulldetail=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$username' and locationcode='$locationcode'");
			$resuser=mysqli_fetch_array($userfulldetail);
			$userfullname=$resuser['employeename'];
			$res1consultationdate = $res2consultationdate;
 
			$consultationtime = $res2['consultationtime'];
			$radiologyitemcode = $res2['radiologyitemcode'];
			$radiologyitemname = $res2['radiologyitemname'];
			$refno = $res2['auto_number'];


				$consultationdate = $res2['consultationdate'];
				$diff = abs(strtotime($consultationdate) - strtotime($dateonly));
				$years = floor($diff / (365*60*60*24));
				$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
				$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

				$waitingtime = (strtotime($timeonly) - strtotime($consultationtime))/60;
				$waitingtime = round($waitingtime);
				$waitingtime = abs($waitingtime);
					$waitingtime1 = $waitingtime;
					$days=$days;

            $query12 = "select * from master_customer where customercode = '$res2patientcode' and status = '' ";
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res12 = mysqli_fetch_array($exec12);
			
			$query69="select * from master_customer where customercode='$res2patientcode'";
			$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res69=mysqli_fetch_array($exec69);
			 $patientdob=$res69['dateofbirth'];
	
			$res12age = $res12['age'];
			$res12gender= $res12['gender'];
			$query112 = "select * from master_visitentry where patientcode = '$res2patientcode' ";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res112 = mysqli_fetch_array($exec112);
			$res112consultingdoctor = $res112['consultingdoctor'];
			$res1112department = $res112['departmentname'];
			 
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
			$data_count++;

			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2consultationdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationtime; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $res2patientcode;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientfullname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo calculate_age($patientdob); ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res12gender; ?></td>
			              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $radiologyitemname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res2account; ?></td>
			    <td class="bodytext31" valign="center"  align="left"><?php echo $userfullname;?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $res1112department; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><a href="processipradiology.php?patientcode=<?php echo $res2patientcode; ?>&&visitcode=<?php echo $res2visitcode; ?>&&q_itemcode=<?= $radiologyitemcode ?>&&refnumber=<?= $refno ?>"><strong>Process</strong></a></div></td>
				<td align="left" valign="center"  
                class="bodytext31" <?php if($waitingtime1 > 15 || $days > 1){ ?> bgcolor=" #FF0040" <?php } ?>><div align="center"><strong>
				<?php $datetime1=$res2['aquisition_datetime']; get_time($datetime1); ?></strong></div></td>
              </tr>
			<?php
			}    
			
			
			}  //if for ip
			?>
			
	<?php

		if($data_count==0){
			echo "<tr bgcolor='blanchedalmond'><td align='left' valign='center' colspan='16'  class='bodytext31'  > No Data Found.</td></tr>";
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
                bgcolor="#ecf0f5" colspan="4">&nbsp;</td>              </tr>
          </tbody>
        </table></td>
      </tr>
	  <?php }?>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

