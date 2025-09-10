<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta'); 
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$errmsg = "";
$timeonly = date('H:i:s');
$colorloopcount = '';

if(isset($_POST['category_id'])){$category_id = $_POST['category_id'];}else{$category_id='';}

$timeonly = date('H:i:s');
$dateonly=date("Y-m-d");

$docno = $_SESSION['docno'];

$patientcode=isset($_REQUEST['patientcode'])?$_REQUEST['patientcode']:'';
$patientvisitcode=isset($_REQUEST['visitcode'])?$_REQUEST['visitcode']:'';
$patientname=isset($_REQUEST['patient'])?$_REQUEST['patient']:'';
$docnum1=isset($_REQUEST['docnumber'])?$_REQUEST['docnumber']:'';

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
	//print_r($_POST['visitcode']);
foreach($_POST['ref'] as $key => $value)
		{
		 $itemcode=$_POST['itemcode'][$value];
		  $sampleid=$_POST['sampleid'][$value];
		$visitcode=$_POST['visitcode'][$value];
		$remark=$_POST['remarks'][$value];
		
			////foreach($_POST['ref'] as $check1)
//	{
//	//echo $refund=$check1;
//		
//	if($refund == $sampleid)
//	{
//		
//	$status1='refund';
//	$newremark=$remark;
//	
//	}
//	else
//	{
//	$status1='norefund';
//	$newremark="";
//	}
//	
	
	//}
	//echo "update consultation_lab set labrefund='refund',remarks='$remark' where labitemcode='$itemcode' and patientvisitcode='$visitcode' and sampleid='$sampleid'"."<br>";
	$query29=mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_lab set labrefund='refund',remarks='$remark' where labitemcode='$itemcode' and patientvisitcode='$visitcode' and sampleid='$sampleid'") or die("error in query".mysqli_error($GLOBALS["___mysqli_ston"]));
	$query29=mysqli_query($GLOBALS["___mysqli_ston"], "update ipconsultation_lab set labrefund='refund',remarks='$remark' where labitemcode='$itemcode' and patientvisitcode='$visitcode' and sampleid='$sampleid'") or die("error in query".mysqli_error($GLOBALS["___mysqli_ston"]));

	
	}
	//exit;
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
function comment(id)
{
	//alert();
	
	if(document.getElementById("ref"+id).checked==true)
	{
		
	document.getElementById("remarks"+id).style.display="";
}
else
{
	
	document.getElementById("remarks"+id).style.display='none';
}
}

function remark()
{
	var sno=document.getElementById("serialno").value;
	
	//alert(sno);
	for(i=1;i<=sno;i++)
	{
	if(document.getElementById("ref"+i).checked==true)
	{
		if(document.getElementById("remarks"+i).value=="")
		{	
		alert("Please enter Remarks");
		return false;
		}
	}
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
		
		
			<form name="drugs" action="processlablist.php" method="post" onKeyDown="return disableEnterKey()" onSubmit="return validcheck()">
	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
      <tbody id="foo">
        <tr>
          <td colspan="3" bgcolor="#ecf0f5" class="bodytext31"><strong>Lab Process List</strong></td>
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

function AnaProcess(sno,pcode,vcode,dno,sid)
{
	if($('#interfacemachine'+sno).val() == "")
	{
		alert("Select Analyser Machine");
		$('#interfacemachine'+sno).focus();
		return false;
	}
	else
	{
		var amac = $('#interfacemachine'+sno).val();
		
		window.location = "labresultentryan.php?patientcode="+pcode+"&&visitcode="+vcode+"&&docnumber="+dno+"&&sampleid="+sid+"&&amacid="+amac;
	}
}

function AnaProcessIP(sno,pcode,vcode,dno,sid)
{
	if($('#interfacemachine'+sno).val() == "")
	{
		alert("Select Analyser Machine");
		$('#interfacemachine'+sno).focus();
		return false;
	}
	else
	{
		var amac = $('#interfacemachine'+sno).val();
		window.location = "iplabresultentryan.php?patientcode="+pcode+"&&visitcode="+vcode+"&&docnumber="+dno+"&&sampleid="+sid+"&&amacid="+amac;
	}
}


</script>
        
       
        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td colspan="5" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
               <select name="location" id="location" onChange=" ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">
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
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Doc Number</td>
              <td colspan="5" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="docnumber" type="text" id="docnumber" style="border: 1px solid #001E6A;" value="" size="50" autocomplete="off">
              </span></td>
              </tr>

			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Category</td>
              <td colspan="5" align="left" valign="top"  bgcolor="#FFFFFF">
			  <select name="category_id">
			  <option value="" >All</option>
				<?php
						$queryaa1 = "select categoryname,auto_number from master_categorylab order by categoryname ";
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
        
          <td width="60" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"> Date From </td>
          <td width="200" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="93" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"> Date To </span></td>
          <td width="246" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          <td width="76" align="center" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong></strong> </td>
          <td width="77" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">		  </td>
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
          <td colspan="2" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right"></div></td>
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
	  <form name="form1" id="form1" method="post" action="processlablist.php">	
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200"
            align="left" border="0">
          <tbody>
		  
		 

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
				<td class="" align="right" colspan="20"> 
			</td>
		</tr>
			<tr>
              <td width="25" height="22" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sno</strong></div></td>
<!--				 <td width="48" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Refund</strong></td>
   -->           
              <td width="48" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
                <td width="48" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Time</strong></div></td>
             <td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patientcode </strong></div></td>
              <td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visitcode</strong></div></td>
              <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient</strong></div></td>
               <td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Age</strong></td>
              <td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Gender</strong></td>
              <td width="85" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Test</strong></div></td>
             <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Account</strong></td>
<!--			  <td width="75" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sample Type</strong></div></td>
			  <td width="78" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Handled By</strong></div></td>
                <td width="132" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Requested By</strong></div></td>
                <td width="124" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sample collected</strong></div></td>
				<td width="62" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Status</strong></div></td>
-->                <td width="122"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Ward/Department</strong></div></td>
                <td width="60" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Remarks</strong></div></td>
			    <td width="48" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Action</strong></div></td>
			   
			    <td width="60" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Time(Min)</strong></div></td>

             </tr>

<?php
			$colorloopcount = '';
			$sno = '';

	if($category_id!='')
	{
	    $queryaa1 = "select * from master_categorylab where auto_number='$category_id' order by categoryname ";
	}else{
	    $queryaa1 = "select * from master_categorylab order by categoryname ";
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

$snovisit=0;
if($patienttype != 'IP') {
$queryvisit7 = "select a.itemcode,a.patientname,a.patientcode,a.patientvisitcode,a.docnumber from samplecollection_lab as a JOIN master_lab as b ON a.itemcode=b.itemcode and b.categoryname='$categoryname' where a.locationcode = '".$locationcode."' and a.patientname like '%$patientname%' and a.patientcode like '%$patientcode%' and a.patientvisitcode like '%$patientvisitcode%'  and a.acknowledge = 'completed' and a.status = 'completed' and a.resultentry = '' and a.refund <> 'refund' and a.docnumber like '%$docnum1%' and a.recorddate between '$ADate1' and '$ADate2' group by a.patientvisitcode,a.patientname,a.itemcode,a.docnumber order by a.recorddate ";
$execvisit7 = mysqli_query($GLOBALS["___mysqli_ston"], $queryvisit7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));						
while($resvisit7 = mysqli_fetch_array($execvisit7))
{
	$patientnamevisit6 = $resvisit7['patientname'];
//$patientnamevisit6 = addslashes($patientnamevisit6);
 $regnovisit = $resvisit7['patientcode'];
$visitnovisit = $resvisit7['patientvisitcode'];
$snovisit=$snovisit+1;
  $docnum = $resvisit7['docnumber'];
  $itemcode = $resvisit7['itemcode'];


?>

<?php
$query7 = "select auto_number,patientname,patientcode,patientvisitcode,recorddate,itemname,itemcode,sample,sampleid,docnumber,username,entrywork,entryworkby,recordtime from samplecollection_lab where locationcode = '".$locationcode."' and patientname like '$patientnamevisit6' and patientcode like '$regnovisit' and patientvisitcode like '$visitnovisit'  and acknowledge = 'completed' and status = 'completed' and resultentry = '' and refund <> 'refund' and docnumber like '$docnum' and itemcode='$itemcode' and recorddate between '$ADate1' and '$ADate2' and externallab ='' order by recorddate ";
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
$collected=$res7['username'];
$entrywork = $res7['entrywork'];
$entryworkby = $res7['entryworkby'];
$recordtime = $res7['recordtime'];

$querycon="select auto_number,username,accountname,pkg_process from consultation_lab where patientcode='$regno' and patientvisitcode='$visitno' and labitemcode='$itemcode' and docnumber='$docnumber'";
$queryconex=mysqli_query($GLOBALS["___mysqli_ston"], $querycon) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$queryconx=mysqli_fetch_array($queryconex);
$requested=$queryconx['username'];
$account = $queryconx['accountname'];
$pkg_process = $queryconx['pkg_process'];
    $anumber = $queryconx['auto_number'];

if($pkg_process=='completed'){
	continue;
}

			$requestedusr=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$requested' and locationcode='$locationcode' and username <> '' and status='Active'");
			$resrequser=mysqli_fetch_array($requestedusr);
			$requesteduser=$resrequser['employeename'];
			
			$collectedusr=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$collected' and locationcode='$locationcode' and username <> '' and status='Active'");
			$rescoluser=mysqli_fetch_array($collectedusr);
			$samplecolluser=$rescoluser['employeename'];

			if($regno=='walkin')
			{
				$requesteduser="SELF";
			}
		
			$query111 = "select gender,departmentname from master_visitentry where visitcode='$visitno'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
			$department = $res111['departmentname'];
			$gender = $res111['gender'];
			
			$query69="select * from master_customer where customercode='$regno'";
			$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res69=mysqli_fetch_array($exec69);
			 $patientdob=$res69['dateofbirth'];			
			
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
				
				if($regno == 'walkin')
				{
				$query43 = "select urgentstatus from consultation_lab where patientvisitcode='$visitno' and patientname='$patientname6' and labsamplecoll = 'completed' and labitemcode = '$itemcode' and (labrefund <> 'norefund' or labrefund = '') and (sampleid ='$sampleid' or sampleid = '')";
				$exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				 $num43 = mysqli_num_rows($exec43);
				 $num43='1';
				}
				else
				{
			 	$query43 = "select urgentstatus from consultation_lab where patientvisitcode='$visitno' and labsamplecoll = 'completed' and labitemcode = '$itemcode' and (labrefund = 'norefund' or labrefund = '') and (sampleid ='$sampleid' or sampleid = '')";
				$exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				 $num43 = mysqli_num_rows($exec43);
				}
				$res43 = mysqli_fetch_array($exec43);
				$urgentstatus=$res43['urgentstatus'];
				if($num43 > 0)
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
				if($urgentstatus==1)
				{
					$colorcode= 'bgcolor="#FFFF00"';
				}
				$data_count++;
				?>
				 <tr <?php echo $colorcode; ?> class="<?= $snovisit; ?>">
             
              <td align="left" valign="center"  
                class="bodytext31"><?php echo $sno=$sno+1; ?></td>
<!--				<td align="center" valign="center"  
                class="bodytext31"><input type="checkbox" name="ref[]" id="ref<?php echo $sno;?>" value="<?php echo $sno; ?>" onClick="return comment('<?php echo $sno?>');"></td> -->
				<input type="hidden" name="itemcode[<?=$sno;?>]" id="itemcode" value="<?php echo $itemcode; ?>">
				<input type="hidden" name="visitcode[<?=$sno;?>]" id="visitcode" value="<?php echo $visitno; ?>">
				<input type="hidden" name="sampleid[<?=$sno;?>]" id="sampleid" value="<?php echo $sampleid; ?>">
              
              <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $billdate6; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $recordtime; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $regno; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $visitno; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $patientname6; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo calculate_age($patientdob); ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $gender; ?></div></td>
			<!--	<td align="left" valign="center"  
                class="bodytext31"><div align="center"><?php echo $docnumber; ?></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><strong><?php echo $sampleid; ?></strong></div></td>-->

				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><strong><?php echo $test; ?></strong></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><strong><?php echo $account; ?></strong></div></td>
<!--				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $sample; ?></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $entryworkby; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $requesteduser; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $samplecolluser;?></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $entrywork; ?></div></td>-->
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $department; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><textarea name="remarks[<?=$sno;?>]" id="remarks<?php echo $sno; ?>" style="display:none"></textarea></td>
				<?php
				$q = "select labcode from master_machinelablinking where labcode = '$itemcode' and recordstatus <> 'deleted'";
				$e = mysqli_query($GLOBALS["___mysqli_ston"], $q) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$r = mysqli_num_rows($e);
				$r =0;
				
				if($r == 0) { ?>
              	 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><a href="processlab.php?patientcode=<?php echo $regno; ?>&&visitcode=<?php echo $visitno; ?>&&docnumber=<?php echo $docnumber; ?>&&sampleid=<?php echo $sampleid; ?>&&q_itemcode=<?php echo $itemcode; ?>&&refnumber=<?= $anumber ?>"><strong>Process</strong></a></div></td>
				<?php } else { ?>
				<td align="left" valign="center"  
                class="bodytext31"><div align="left"><img src="images/plus.jpg" width="20" height="20" onClick="javascript: $('#SUB<?php echo $sno; ?>').toggle();"></div></td>
				
				<?php } ?>
				<td width="50" align="left" valign="center" bgcolor=" #FF0040"  
                class="bodytext31" <?php if($waitingtime1 > 15){ ?> <?php } ?>><div align="center"><strong><?php $datetime1=$billdate6.' '.$recordtime; get_time($datetime1); ?></strong></div></td>

				</tr>
				<tr id="SUB<?php echo $sno; ?>" style="display:none; background-color:#ecf0f5;">
				<td align="left">&nbsp;</td>
				<td colspan="2" align="left" class="bodytext3"><strong>Select Analyser </strong></td>
				<td colspan="3" align="left" class="bodytext3"><select name="interfacemachine<?php echo $sno; ?>" id="interfacemachine<?php echo $sno; ?>">
				<option value="">Select Analyser</option>
				<?php
				$query24 = "select machinecode,machine from master_machinelablinking where labcode = '$itemcode' and recordstatus <> 'deleted'";
				$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res24 = mysqli_fetch_array($exec24))
				{
				$machine = $res24['machine'];
				$machinecode = $res24['machinecode'];
				?>
				<option value="<?php echo $machinecode; ?>"><?php echo $machine; ?></option>
				<?php
				}
				?>
				</select></td>
				<td colspan="14" align="left" class="bodytext3"><strong><a href="#" onClick="return AnaProcess('<?php echo $sno; ?>','<?php echo $regno; ?>','<?php echo $visitno; ?>','<?php echo $docnumber; ?>','<?php echo $sampleid; ?>')">Process</a></strong></td>
				</tr>
				<?php
				} 
				}
				
 $query7 = "select auto_number,patientname,patientcode,patientvisitcode,recorddate,itemname,itemcode,sample,username,sampleid,docnumber,entrywork,entryworkby,recordtime from samplecollection_lab where locationcode = '".$locationcode."' and patientname like '$patientnamevisit6' and patientcode like '$regnovisit' and patientvisitcode like '$visitnovisit'  and acknowledge = 'completed' and status = 'completed' and resultentry = '' and refund = 'norefund' and docnumber like '$docnum' and itemcode = '$itemcode' and recorddate between '$ADate1' and '$ADate2' and externallab !='' and externalack ='acknowledge'  group by auto_number order by recorddate ";
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
$collected=$res7['username'];
$sampleid = $res7['sampleid'];
$docnumber = $res7['docnumber'];
$entrywork = $res7['entrywork'];
$entryworkby = $res7['entryworkby'];
$recordtime = $res7['recordtime'];


$querycon="select auto_number,username,accountname,pkg_process from consultation_lab where patientcode='$regno' and patientvisitcode='$visitno' and labitemcode='$itemcode' and docnumber='$docnumber'";
$queryconex=mysqli_query($GLOBALS["___mysqli_ston"], $querycon) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$queryconx=mysqli_fetch_array($queryconex);
$requested=$queryconx['username'];
$account = $queryconx['accountname'];
$pkg_process  = $queryconx['pkg_process'];
$anumber = $queryconx['auto_number'];


if($pkg_process=='completed'){
	continue;
}


			$requestedusr=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$requested' and locationcode='$locationcode' and username <> '' and status='Active'");
			$resrequser=mysqli_fetch_array($requestedusr);
			$requesteduser=$resrequser['employeename'];
			
			$collectedusr=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$collected' and locationcode='$locationcode' and username <> '' and status='Active'");
			$rescoluser=mysqli_fetch_array($collectedusr);
			$samplecolluser=$rescoluser['employeename'];
			
			if($regno=='walkin')
			{
				$requesteduser="SELF";
			}
	
			$query111 = "select departmentname,gender from master_visitentry where visitcode='$visitno'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
			$department = $res111['departmentname'];
			$gender = $res111['gender'];

			$query69="select * from master_customer where customercode='$regno'";
			$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res69=mysqli_fetch_array($exec69);
			 $patientdob=$res69['dateofbirth'];	
			 			
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
				
				if($regno == 'walkin')
				{
				$query43 = "select urgentstatus from consultation_lab where patientvisitcode='$visitno' and patientname='$patientname6' and labsamplecoll = 'completed' and labitemcode = '$itemcode' and (labrefund = 'norefund' or labrefund = '') and (sampleid ='$sampleid' or sampleid = '')";
				}
				else
				{
				$query43 = "select urgentstatus from consultation_lab where patientvisitcode='$visitno' and labsamplecoll = 'completed' and labitemcode = '$itemcode' and (labrefund = 'norefund' or labrefund = '') and (sampleid ='$sampleid' or sampleid = '')";
				}
				$exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				 $num43 = mysqli_num_rows($exec43);
				$res43 = mysqli_fetch_array($exec43);
				$urgentstatus=$res43['urgentstatus'];
				if($num43 > 0)
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
				if($urgentstatus==1)
				{
					$colorcode= 'bgcolor="#FFFF00"';
				}
				$data_count++;
				?>
				 <tr <?php echo $colorcode; ?> class="<?= $snovisit; ?>">
             
              <td align="left" valign="center"  
                class="bodytext31"><?php echo $sno=$sno+1; ?></td>
<!--				<td align="center" valign="center"  
                class="bodytext31"><input type="checkbox" name="ref[]" id="ref<?php echo $sno;?>" value="<?php echo $sno; ?>" onClick="return comment('<?php echo $sno?>')"></td>
-->				<input type="hidden" name="itemcode[<?=$sno;?>]" id="itemcode" value="<?php echo $itemcode; ?>">
				<input type="hidden" name="visitcode[<?=$sno;?>]" id="visitcode" value="<?php echo $visitno; ?>">
				<input type="hidden" name="sampleid[<?=$sno;?>]" id="sampleid" value="<?php echo $sampleid; ?>">
              
              <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $billdate6; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $recordtime; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $regno; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $visitno; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $patientname6; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo calculate_age($patientdob); ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $gender; ?></div></td>
<!--		<td align="left" valign="center"  
                class="bodytext31"><div align="center"><?php echo $docnumber; ?></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><strong><?php echo $sampleid; ?></strong></div></td>
-->
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><strong><?php echo $test; ?></strong></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><strong><?php echo $account; ?></strong></div></td>
<!--				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $sample; ?></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $entryworkby; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $requesteduser; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"></div><?php echo $samplecolluser;?></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $entrywork; ?></div></td> -->
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $department; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><textarea name="remarks[<?=$sno;?>]" id="remarks<?php echo $sno;?>" style="display:none"></textarea></td>
				<?php
				$q = "select labcode from master_machinelablinking where labcode = '$itemcode' and recordstatus <> 'deleted'";
				$e = mysqli_query($GLOBALS["___mysqli_ston"], $q) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$r = mysqli_num_rows($e);
				$r =0;

				if($r == 0) { ?>
              	 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><a href="processlab.php?patientcode=<?php echo $regno; ?>&&visitcode=<?php echo $visitno; ?>&&docnumber=<?php echo $docnumber; ?>&&sampleid=<?php echo $sampleid; ?>&&q_itemcode=<?php echo $itemcode; ?>&&refnumber=<?= $anumber ?>"><strong>Process</strong></a></div></td>
				<?php } else { ?>
				<td align="left" valign="center"  
                class="bodytext31"><div align="left"><img src="images/plus.jpg" width="20" height="20" onClick="javascript: $('#SUB<?php echo $sno; ?>').toggle();"></div></td>
				
				<?php } ?>
				<td align="left" valign="center"  
                class="bodytext31" <?php if($waitingtime1 > 15){ ?> bgcolor=" #FF0040" <?php } ?>><div align="center"><strong><?php $datetime1=$billdate6.' '.$recordtime; get_time($datetime1); ?></strong></div></td>

				</tr>
				<tr id="SUB<?php echo $sno; ?>" style="display:none; background-color:#ecf0f5;">
				<td align="left">&nbsp;</td>
				<td colspan="2" align="left" class="bodytext3"><strong>Select Analyser </strong></td>
				<td colspan="3" align="left" class="bodytext3"><select name="interfacemachine<?php echo $sno; ?>" id="interfacemachine<?php echo $sno; ?>">
				<option value="">Select Analyser</option>
				<?php
				$query24 = "select machinecode,machine from master_machinelablinking where labcode = '$itemcode' and recordstatus <> 'deleted'";
				$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res24 = mysqli_fetch_array($exec24))
				{
				$machine = $res24['machine'];
				$machinecode = $res24['machinecode'];
				?>
				<option value="<?php echo $machinecode; ?>"><?php echo $machine; ?></option>
				<?php
				}
				?>
				</select></td>
				<td colspan="14" align="left" class="bodytext3"><strong><a href="#" onClick="return AnaProcess('<?php echo $sno; ?>','<?php echo $regno; ?>','<?php echo $visitno; ?>','<?php echo $docnumber; ?>','<?php echo $sampleid; ?>')">Process</a></strong></td>
				</tr>
				<?php
				} 
				
}
				
				}
				}
				?>
				<?php
				if($patienttype != 'OP+EXTERNAL') {
				 $queryipvisit98a = "select a.sampleid,a.itemcode,a.docnumber,a.patientname,a.patientcode,a.patientvisitcode from ipsamplecollection_lab as a JOIN master_lab as b ON a.itemcode=b.itemcode and b.categoryname='$categoryname' where a.locationcode = '".$locationcode."' and a.patientname like '%$patientname%' and a.patientcode like '%$patientcode%' and a.patientvisitcode like '%$patientvisitcode%' and a.acknowledge = 'completed' and a.resultentry = '' and a.refund = 'norefund' and a.docnumber like '%$docnum1%'  and a.recorddate between '$ADate1' and '$ADate2'  group by a.patientvisitcode,a.patientname,a.itemcode,a.sampleid order by a.recorddate ";
				$execipvisit98a = mysqli_query($GLOBALS["___mysqli_ston"], $queryipvisit98a) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				while($resipvisit98a = mysqli_fetch_array($execipvisit98a))
				{
					$patientnameipvisit6 = $resipvisit98a['patientname'];				
					$regnoipvisit = $resipvisit98a['patientcode'];
					$visitnoipvisit = $resipvisit98a['patientvisitcode'];
					$snovisit=$snovisit+1;
					$docnum = $resipvisit98a['docnumber'];
					$itemcode = $resipvisit98a['itemcode'];
					$sampleid_q = $resipvisit98a['sampleid'];
					
					
					
					?>
				
              <?php
				 $query98 = "select auto_number,patientname,patientcode,patientvisitcode,recorddate,itemname,itemcode,sample,username,sampleid,docnumber,recordtime from ipsamplecollection_lab where locationcode = '".$locationcode."' and patientcode like '$regnoipvisit' and patientvisitcode like '$visitnoipvisit'   and acknowledge = 'completed' and resultentry = '' and refund = 'norefund' and docnumber like '$docnum' and itemcode ='$itemcode' and sampleid='$sampleid_q' and recorddate between '$ADate1' and '$ADate2' and transferloccode =''   group by auto_number order by recorddate ";
				$exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die(mysqli_error($GLOBALS["___mysqli_ston"]));						
				while($res98 = mysqli_fetch_array($exec98))
				{
				$waitingtime='';
				$patientname6 = $res98['patientname'];
				$patientname6 = addslashes($patientname6);
				$regno = $res98['patientcode'];
				$visitno = $res98['patientvisitcode'];
				$billdate6 = $res98['recorddate'];
				$test = $res98['itemname'];
				$itemcode = $res98['itemcode'];
				$sample = $res98['sample'];
				$usernameip = $res98['username'];
				$collected = '';
				$sampleid = $res98['sampleid'];
				$docnumber = $res98['docnumber'];
				$entrywork = '';
				$entryworkby = '';
				$recordtime = $res98['recordtime'];
				
				$querysample="select auto_number,pkg_process,username,accountname from ipconsultation_lab where patientcode='$regno' and patientvisitcode='$visitno' and labitemcode='$itemcode' and docnumber='$docnumber'";
$querysamplexc=mysqli_query($GLOBALS["___mysqli_ston"], $querysample) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$samplexc=mysqli_fetch_array($querysamplexc);
$requested=$samplexc['username'];
$account = $samplexc['accountname'];
$pkg_process  = $samplexc['pkg_process'];
			    $anumber = $samplexc['auto_number'];

if($pkg_process=='completed'){
	continue;
}

			$requestedusr=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$requested' and locationcode='$locationcode' and username <> '' and status='Active'");
			$resrequser=mysqli_fetch_array($requestedusr);
			$requesteduser=$resrequser['employeename'];
			
			$collectedusr=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$usernameip' and locationcode='$locationcode' and username <> '' and status='Active'");
			$rescoluser=mysqli_fetch_array($collectedusr);
			$samplecolluser=$rescoluser['employeename'];
				
				
		$query111 = "select gender from master_ipvisitentry where visitcode='$visitno'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
			$gender = $res111['gender'];
			
			$query69="select * from master_customer where customercode='$regno'";
			$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res69=mysqli_fetch_array($exec69);
			 $patientdob=$res69['dateofbirth'];		

				
				$warddate="select ward from master_ward where auto_number in(select ward from ip_bedallocation where patientcode='$regno' and visitcode='$visitno' and recordstatus NOT IN ('discharged','transfered'))";
		
			$exeward=mysqli_query($GLOBALS["___mysqli_ston"], $warddate);
			$resward=mysqli_fetch_array($exeward);
			$ward=$resward['ward'];
			$numrow=mysqli_num_rows($exeward);
					if($numrow =='0')

{			$warddate1="select ward from master_ward where auto_number in(select ward from ip_bedtransfer where patientcode='$regno' and visitcode='$visitno' and recordstatus NOT IN ('discharged','transfered') )";
		
			$exeward1=mysqli_query($GLOBALS["___mysqli_ston"], $warddate1);
			$resward1=mysqli_fetch_array($exeward1);
			$ward=$resward1['ward'];
			
}
			
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
				
				
				 $query431 = "select * from ipconsultation_lab where patientvisitcode='$visitno' and labsamplecoll = 'completed' and labitemcode = '$itemcode' and (labrefund = 'norefund' or labrefund = '') and (sampleid ='$sampleid' or sampleid = '')";
				$exec431 = mysqli_query($GLOBALS["___mysqli_ston"], $query431) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			 	$num431 = mysqli_num_rows($exec431);
				//echo "<br>";
				if($num431 > 0)
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
				$data_count++;
				
				?>
				 <tr <?php echo $colorcode; ?> class="<?= $snovisit; ?>" >
             
              <td align="left" valign="center"  
                class="bodytext31"><?php echo $sno=$sno+1; ?></td>
<!--				<td align="center" valign="center"  
                class="bodytext31"><input type="checkbox" name="ref[]" id="ref<?php echo $sno?>" value="<?php echo $sno; ?>" onClick="return comment('<?php echo $sno;?>')"></td> -->
				<input type="hidden" name="itemcode[<?=$sno;?>]" id="itemcode" value="<?php echo $itemcode; ?>">
				<input type="hidden" name="visitcode[<?=$sno;?>]" id="visitcode" value="<?php echo $visitno; ?>">
				<input type="hidden" name="sampleid[<?=$sno;?>]" id="sampleid" value="<?php echo $sampleid; ?>">
              
              <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $billdate6; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $recordtime; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $regno; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $visitno; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $patientname6; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo calculate_age($patientdob); ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $gender; ?></div></td>
				<!--				<td align="left" valign="center"  
                class="bodytext31"><div align="center"><?php echo $docnumber; ?></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><strong><?php echo $sampleid; ?></strong></div></td>
			-->
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><strong><?php echo $test; ?></strong></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><strong><?php echo $account; ?></strong></div></td>
<!--				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $sample; ?></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $entryworkby; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $requesteduser; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $samplecolluser;?></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $entrywork; ?></div></td> -->
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $ward; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><textarea name="remarks[<?=$sno;?>]" id="remarks<?php echo $sno;?>" style="display:none"></textarea></td>
				<?php
				$q = "select labcode from master_machinelablinking where labcode = '$itemcode' and recordstatus <> 'deleted'";
				$e = mysqli_query($GLOBALS["___mysqli_ston"], $q) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$r = mysqli_num_rows($e);
				$r =0;				
				if($r == 0) { ?>
              	 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><a href="processiplab.php?patientcode=<?php echo $regno; ?>&&visitcode=<?php echo $visitno; ?>&&docnumber=<?php echo $docnumber; ?>&&sampleid=<?php echo $sampleid; ?>&&q_itemcode=<?php echo $itemcode; ?>&&refnumber=<?= $anumber ?>"><strong>Process</strong></a></div></td>
				<?php } else { ?>
				<td align="left" valign="center"  
                class="bodytext31"><div align="left"><img src="images/plus.jpg" width="20" height="20" onClick="javascript: $('#SUB<?php echo $sno; ?>').toggle();"></div></td>
				
				<?php } ?>
				<td align="left" valign="center"  
                class="bodytext31" <?php if($waitingtime1 > 15){ ?> bgcolor=" #FF0040" <?php } ?>><div align="center"><strong><?php $datetime1=$billdate6.' '.$recordtime; get_time($datetime1); ?></strong></div></td>

				</tr>
				<tr id="SUB<?php echo $sno; ?>" style="display:none; background-color:#ecf0f5;">
				<td align="left">&nbsp;</td>
				<td colspan="2" align="left" class="bodytext3"><strong>Select Analyser </strong></td>
				<td colspan="3" align="left" class="bodytext3"><select name="interfacemachine<?php echo $sno; ?>" id="interfacemachine<?php echo $sno; ?>">
				<option value="">Select Analyser</option>
				<?php
				$query24 = "select machinecode,machine from master_machinelablinking where labcode = '$itemcode' and recordstatus <> 'deleted'";
				$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res24 = mysqli_fetch_array($exec24))
				{
				$machine = $res24['machine'];
				$machinecode = $res24['machinecode'];
				?>
				<option value="<?php echo $machinecode; ?>"><?php echo $machine; ?></option>
				<?php
				}
				?>
				</select></td>
				<td colspan="14" align="left" class="bodytext3"><strong><a href="#" onClick="return AnaProcessIP('<?php echo $sno; ?>','<?php echo $regno; ?>','<?php echo $visitno; ?>','<?php echo $docnumber; ?>','<?php echo $sampleid; ?>')">Process</a></strong></td>
				</tr>
				<?php
				} 
				}
				
				
					$query98 = "select auto_number,patientname,patientcode,patientvisitcode,recorddate,itemname,itemcode,sample,username,sampleid,docnumber,recordtime from ipsamplecollection_lab where locationcode = '".$locationcode."' and patientcode like '$regnoipvisit' and patientvisitcode like '$visitnoipvisit'   and acknowledge = 'completed' and resultentry = '' and refund = 'norefund' and docnumber like '$docnum' and sampleid='$sampleid'  and recorddate between '$ADate1' and '$ADate2' and transferloccode !='' and externalack = 'acknowledge' group by auto_number  order by recorddate ";
				$exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die(mysqli_error($GLOBALS["___mysqli_ston"]));						
				while($res98 = mysqli_fetch_array($exec98))
				{
				$waitingtime='';
				 $patientname6 = $res98['patientname'];
				$patientname6 = addslashes($patientname6);
				$regno = $res98['patientcode'];
				$visitno = $res98['patientvisitcode'];
				$billdate6 = $res98['recorddate'];
				$test = $res98['itemname'];
				$itemcode = $res98['itemcode'];
				$sample = $res98['sample'];
				$collected = '';
				$usernameip1=$res98['username'];
				$sampleid = $res98['sampleid'];
				$docnumber = $res98['docnumber'];
				$entrywork = '';
				$entryworkby = '';
				$recordtime = $res98['recordtime'];
				
				
				$querysample="select auto_number,username,accountname,pkg_process from ipconsultation_lab where patientcode='$regno' and patientvisitcode='$visitno' and labitemcode='$itemcode' and docnumber='$docnumber'";
$querysamplexc=mysqli_query($GLOBALS["___mysqli_ston"], $querysample) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$samplexc=mysqli_fetch_array($querysamplexc);
$requested=$samplexc['username'];
$account = $samplexc['accountname'];				
$pkg_process  = $samplexc['pkg_process'];
			    $anumber = $samplexc['auto_number'];

if($pkg_process=='completed'){
	continue;
}
				
		$query111 = "select gender from master_ipvisitentry where visitcode='$visitno'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
			$gender = $res111['gender'];
			
			$query69="select * from master_customer where customercode='$regno'";
			$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res69=mysqli_fetch_array($exec69);
			 $patientdob=$res69['dateofbirth'];		

				$requestedusr=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$requested' and locationcode='$locationcode' and username <> '' and status='Active'");
			$resrequser=mysqli_fetch_array($requestedusr);
			$requesteduser=$resrequser['employeename'];
			
			$collectedusr=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$usernameip1' and locationcode='$locationcode' and username <> '' and status='Active'");
			$rescoluser=mysqli_fetch_array($collectedusr);
			$samplecolluser=$rescoluser['employeename'];
				
				$warddate="select ward from master_ward where auto_number in(select ward from ip_bedallocation where patientcode='$regno' and visitcode='$visitno' and recordstatus NOT IN ('discharged','transfered'))";
		
			$exeward=mysqli_query($GLOBALS["___mysqli_ston"], $warddate);
			$resward=mysqli_fetch_array($exeward);
			$ward=$resward['ward'];
			$numrow=mysqli_num_rows($exeward);
					if($numrow =='0')

{			$warddate1="select ward from master_ward where auto_number in(select ward from ip_bedtransfer where patientcode='$regno' and visitcode='$visitno' and recordstatus NOT IN ('discharged','transfered') )";
		
			$exeward1=mysqli_query($GLOBALS["___mysqli_ston"], $warddate1);
			$resward1=mysqli_fetch_array($exeward1);
			$ward=$resward1['ward'];
			
}
			
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
				
				
				 $query431 = "select * from ipconsultation_lab where patientvisitcode='$visitno' and labsamplecoll = 'completed' and labitemcode = '$itemcode' and (labrefund = 'norefund' or labrefund = '') and (sampleid ='$sampleid' or sampleid = '')";
				$exec431 = mysqli_query($GLOBALS["___mysqli_ston"], $query431) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			 	$num431 = mysqli_num_rows($exec431);
				//echo "<br>";
				if($num431 > 0)
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
				$data_count++;
				?>
				 <tr <?php echo $colorcode; ?> class="<?= $snovisit; ?>" style="display:none">
             
              <td align="left" valign="center"  
                class="bodytext31"><?php echo $sno=$sno+1; ?></td>
<!--				<td align="center" valign="center"  
                class="bodytext31"><input type="checkbox" name="ref[]" id="ref<?php echo $sno?>" value="<?php echo $sno; ?>" onClick="return comment('<?php echo $sno?>')"></td> -->
				<input type="hidden" name="itemcode[<?=$sno;?>]" id="itemcode" value="<?php echo $itemcode; ?>">
				<input type="hidden" name="visitcode[<?=$sno;?>]" id="visitcode" value="<?php echo $visitno; ?>">
				<input type="hidden" name="sampleid[<?=$sno;?>]" id="sampleid" value="<?php echo $sampleid; ?>">
              
              <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $billdate6; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $recordtime; ?></div></td>
          	   <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $regno; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $visitno; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $patientname6; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo calculate_age($patientdob); ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $gender; ?></div></td>
				<!--<td align="left" valign="center"  
                class="bodytext31"><div align="center"><?php echo $docnumber; ?></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><strong><?php echo $sampleid; ?></strong></div></td>
-->
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><strong><?php echo $test; ?></strong></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><strong><?php echo $account; ?></strong></div></td>
<!--				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $sample; ?></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $entryworkby; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $requesteduser; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $samplecolluser;?></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $entrywork; ?></div></td> -->
                <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $ward; ?></div></td>
                <td align="left" valign="center"  
                class="bodytext31"><textarea name="remarks[<?=$sno;?>]" id="remarks<?php echo $sno;?>" style="display:none"></textarea></td>
				<?php
				$q = "select labcode from master_machinelablinking where labcode = '$itemcode' and recordstatus <> 'deleted'";
				$e = mysqli_query($GLOBALS["___mysqli_ston"], $q) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$r = mysqli_num_rows($e);
				$r =0;
				if($r == 0) { ?>
              	 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><a href="processiplab.php?patientcode=<?php echo $regno; ?>&&visitcode=<?php echo $visitno; ?>&&docnumber=<?php echo $docnumber; ?>&&sampleid=<?php echo $sampleid; ?>&&q_itemcode=<?php echo $itemcode; ?>&&refnumber=<?= $anumber ?>"><strong>Process</strong></a></div></td>
				<?php } else { ?>
				<td align="left" valign="center"  
                class="bodytext31"><div align="left"><img src="images/plus.jpg" width="20" height="20" onClick="javascript: $('#SUB<?php echo $sno; ?>').toggle();"></div></td>
				
				<?php } ?>
				<td align="left" valign="center"  
                class="bodytext31" <?php if($waitingtime1 > 15){ ?> bgcolor=" #FF0040" <?php } ?>><div align="center"><strong><?php $datetime1=$billdate6.' '.$recordtime; get_time($datetime1); ?></strong></div></td>

				</tr>
				<tr id="SUB<?php echo $sno; ?>" style="display:none; background-color:#ecf0f5;">
				<td align="left">&nbsp;</td>
				<td colspan="2" align="left" class="bodytext3"><strong>Select Analyser </strong></td>
				<td colspan="3" align="left" class="bodytext3"><select name="interfacemachine<?php echo $sno; ?>" id="interfacemachine<?php echo $sno; ?>">
				<option value="">Select Analyser</option>
				<?php
				$query24 = "select machinecode,machine from master_machinelablinking where labcode = '$itemcode' and recordstatus <> 'deleted'";
				$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res24 = mysqli_fetch_array($exec24))
				{
				$machine = $res24['machine'];
				$machinecode = $res24['machinecode'];
				?>
				<option value="<?php echo $machinecode; ?>"><?php echo $machine; ?></option>
				<?php
				}
				?>
				</select></td>
				<td colspan="14" align="left" class="bodytext3"><strong><a href="#" onClick="return AnaProcessIP('<?php echo $sno; ?>','<?php echo $regno; ?>','<?php echo $visitno; ?>','<?php echo $docnumber; ?>','<?php echo $sampleid; ?>')">Process</a></strong></td>
				</tr>
				<?php
				} 
				}
				
				}
				}
				$lastsno=$sno;
				?>

	<?php

		if($data_count==0){
			echo "<tr bgcolor='blanchedalmond'><td align='left' valign='center' colspan='20'  class='bodytext31'  > No Data Found.</td></tr>";
		}
		
	}
?>   
                <input type="hidden" value="<?php echo $lastsno;?>" name="serialno" id="serialno"/>
		  </tbody>
		  </table></td>
      </tr>
	  <tr>
	   <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
	  </tr>
	  <tr>
	  <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
	  <td width="241"  align="left" valign="center" class="bodytext31">
	   </td>
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