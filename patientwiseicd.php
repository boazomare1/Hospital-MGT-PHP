<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$icddatefrom = date('Y-m-d', strtotime('-1 month'));
$icddateto = date('Y-m-d');
$colorloopcount = '';
$sno = '';
$snocount = '';
$secondarydiagnosis='';
$secondarycode='';
$tertiarycode='';
$tertiarydiagnosis='';
$res1disease='';
$res1diseasecode='';
$primarychapter='';
$primarydisease='';
$secchapter='';
$secdisease='';
$trichapter='';
$tridisease='';
if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
if (isset($_REQUEST["age"])) {  $icdage = $_REQUEST["age"]; } else { $icdage = ""; }
if (isset($_REQUEST["range"])) {  $icdrange = $_REQUEST["range"]; } else { $range = ""; }
if (isset($_REQUEST["icdcode"])) { $icdcode1 = $_REQUEST["icdcode"]; } else { $icdcode1 = ""; }
//$slocation=array();
$slocation=isset($_REQUEST['slocation'])?$_REQUEST['slocation']:'';
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
$icddatefrom = $_REQUEST['ADate1'];
$icddateto = $_REQUEST['ADate2'];
}
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];
if ($ADate1 != '' && $ADate2 != '')
{
	$icdddatefrom = $_REQUEST['ADate1'];
	$icdddateto = $_REQUEST['ADate2'];
}
else
{
	$icdddatefrom = date('Y-m-d', strtotime('-1 month'));
	$icdddateto = date('Y-m-d');
}
if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }
$searchsuppliername = trim($searchsuppliername);
?>
<script type="text/javascript">
function funcOnLoadBodyFunctionCall1()
{
//alert('h');
//funcCustomerDropDownSearch1();
var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
}
</script>
<style type="text/css">
th {
            background-color: #ffffff;
            position: sticky;
            top: 0;
            z-index: 1;
        }
.bodytext31:hover { font-size:14px; }
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
<?php include ("autocompletebuild_account2.php"); ?>
<?php include ("js/dropdownlist1scriptingicdcode.php"); ?>
<script type="text/javascript" src="js/autocomplete_accounts2.js"></script>
<script type="text/javascript" src="js/autosuggest4accounts.js"></script>
 <link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style3 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
</head>
<script src="js/datetimepicker_css.js"></script>
<body onLoad="return funcOnLoadBodyFunctionCall1();">
<table width="1900" border="0" cellspacing="0" cellpadding="2">
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
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
		<form name="cbform1" method="post" action="patientwiseicd.php">
			<table width="35%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
				<tbody>
				<tr bgcolor="#011E6A">
					<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Patientwise ICD </strong></td>
					<!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
					<td bgcolor="#ecf0f5" class="bodytext3" colspan="4">&nbsp;</td>
				</tr>
					
				<tr>
					<td width="13%"  align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"> Range </td>
					<td width="21%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
						<select name="range">
							<option value="" selected>Range </option>
							<option value="equal">= </option>
							<option value="greater">> </option>
							<option value="lesser">< </option>
							<option value="greaterequal">>= </option>
							<option value="lesserequal"><= </option>
						</select>
						
					</td>
					<td width="13%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Age </td>
					<td width="21%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31"><input name="age" id="age" size="10" /></span></td>
					<td width="13%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">Code</td>
					<td width="19%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input type="text" name="icdcode" id="icdcode" size="15" autocomplete="off">
					</td>
				</tr>
					
				<tr>
					<td width="13%"  align="left" valign="center" 
                bgcolor="#FFFFFF" class="bodytext31"> Account</td>
                      <td colspan="3" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="searchsuppliername" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" autocomplete="off" size="50"/>
			<input type="hidden" name="searchsuppliercode" id="searchsuppliercode" value="<?php echo $searchsuppliercode; ?>"  size="20" onKeyDown="return disableEnterKey()" />
                      </td>
                      <td width="13%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">Disease</td>
                      <td width="19%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input type="text" name="disease" id="disease" size="15" autocomplete="off"></td>
					  
					  
                    </tr>
					<tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location </td>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
 
                      <select name="slocation" id="slocation">
                      	<option value="all" selected> ALL</option>
                        <?php
						
					
						$query01="select locationcode,locationname from master_location where status <>'deleted' group by locationcode order by locationname ";
						$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
						while($res01=mysqli_fetch_array($exc01))
						
						{
					 	
						?>
							<option value="<?= $res01['locationcode'] ?>" > <?= $res01['locationname']; ?> </option>		
						<?php 
						}
						?>
                      </select>
                      </td>
					   <td colspan="2" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
					   
                      <td width="13%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">Patient Type</td>
                      <td width="19%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
 
                      <select name="visittype" id="visittype">
                      	<option value="ALL" selected> ALL</option>
						<option value="OP" > OP</option>
						<option value="IP" > IP</option>
                      </select>
                      </td>
					   
					  </tr>
		  <tr>
                      <td width="13%"  align="left" valign="center" 
                bgcolor="#FFFFFF" class="bodytext31"> Date From </td>
                      <td width="21%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $icddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                      <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="13%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td colspan="3" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $icddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                      <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="5" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
                          <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
                    </tr>
                  </tbody>
                </table>
              </form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="110%" 
            align="left" border="0">
          <tbody>
            
            
			<?php
			
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			if (isset($_REQUEST["visittype"])) { $visittype = $_REQUEST["visittype"]; } else { $visittype = ""; }
			
			if ($cbfrmflag1 == 'cbfrmflag1')
				{
				$slocation1=$slocation;
				if($slocation=='all')
				{
				
						
					$slocation=array();
						$query01="select locationcode from master_location where status <>'deleted' group by locationcode order by locationname ";
						$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
						while($res01=mysqli_fetch_array($exc01))
						
						{
					 	
						$slocation[]= "'".$res01['locationcode']."'";
					
						}
					$slocation = implode(',', $slocation);	
				}
				else
				{
				$slocation="'".$slocation."'";
				}
				
				//print_r($slocation);
			//	exit;
				 $searchage = $_REQUEST['age'];
				 $searchrange = $_REQUEST['range'];
				 $searchicdcode = $_REQUEST['icdcode'];
				 $searchicdcode = trim($searchicdcode);
				 $searchdisease = $_REQUEST['disease'];
				 $searchdisease = trim($searchdisease);
				 
				?>
			<tr>
				<th width="" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>No.</strong></th>
				<th width="" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg.No</th>
				<th width="" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</th>
				<th width="" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit Date</th>
				<th width="" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient</th>
				<th width="" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Gender</th>
				<th width="" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Age</th>
				<th width="" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Mobile</th>
				<th width="" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Area</th>
				<th width="" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Subtype</th>
				<th width="" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Account</th>
				<th width="" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</th>
				<th width="" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Amt </th>
				<th width="" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Type</th>
                <th width="" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Block</th>
                <th width="" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Block Code</th>
				<th width="" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Primary Diag</th>
				<th width="" align="left" valign="center" bgcolor="#FFFFFF" class="style3">ICD Code</th>
                <th width="" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Block</th>
                <th width="" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Block Code</th>
				<th width="" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Secondary Diag</th>
                <th width="" align="left" valign="center" bgcolor="#FFFFFF" class="style3">ICD Code</th>
<!--                <th width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Block</th>
                <th width="3%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Block Code</th>
                <th width="8%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Tertiary Diag</th>
                <th width="4%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">ICD Code</th>
-->				

				<th width="" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Systolic / Diastolic</th>
				<th width="" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Consulting Doctor</th>
                 <th width="" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Location Name</th>
				
				
			</tr>
			
			<?php
		
			if($visittype =='OP' || $visittype =='ALL' )
			{
			
			if ($searchrange == '')
			{         
			if($searchicdcode == '' && $searchdisease =='')
			{
		  
			$query1 = "select a.locationname,b.age,a.consultationid,a.consultationtime,a.patientcode,a.patientname,a.patientvisitcode,a.consultationdate,a.accountname,a.locationcode,a.locationname from consultation_icd as a,master_visitentry as b where  a.patientvisitcode=b.visitcode and b.age like '%$searchage%' and a.accountname like '%$searchsuppliername%' and a.primaryicdcode like '%$searchicdcode%' and a.secicdcode like '%$searchicdcode%' and a.consultationdate between '$icddatefrom' and '$icddateto' and a.locationcode in ($slocation) group by a.patientvisitcode order by a.auto_number desc  ";
		   }
		   else
		   {
		    $query1 = "select a.locationname,b.age,a.consultationid,a.consultationtime,a.patientcode,a.patientname,a.patientvisitcode,a.consultationdate,a.accountname,a.locationcode,a.locationname from consultation_icd as a,master_visitentry as b where  a.patientvisitcode=b.visitcode and (a.primaryicdcode like'%$searchicdcode%' or a.secicdcode like'%$searchicdcode%') and  (a.primarydiag like '%$searchdisease%' or a.secondarydiag like '%$searchdisease%') and b.age like '%$searchage%' and a.accountname like '%$searchsuppliername%' and  a.consultationdate between '$icddatefrom' and '$icddateto' and a.locationcode in ($slocation)  group by a.patientvisitcode order by a.auto_number desc ";
		   }
		  }
		  else if ($searchrange == 'equal')
		  { 
		  if($searchicdcode == '' && $searchdisease =='')
		  {
	 	   $query1 = "select a.locationname,b.age,a.consultationid,a.consultationtime,a.patientcode,a.patientname,a.patientvisitcode,a.consultationdate,a.accountname,a.locationcode,a.locationname from consultation_icd as a,master_visitentry as b where a.patientvisitcode=b.visitcode and b.age = '$searchage' and a.accountname like '%$searchsuppliername%' and a.primaryicdcode like '%$searchicdcode%' and a.secicdcode like '%$searchicdcode%' and a.consultationdate between '$icddatefrom' and '$icddateto' and a.locationcode in ($slocation)  group by a.patientvisitcode order by a.auto_number desc ";
		 }
		 else
		 {
	  	  $query1 = "select a.locationname,b.age,a.consultationid,a.consultationtime,a.patientcode,a.patientname,a.patientvisitcode,a.consultationdate,a.accountname,a.locationcode,a.locationname from consultation_icd as a,master_visitentry as b where a.patientvisitcode=b.visitcode and (a.primaryicdcode like'%$searchicdcode%' or a.secicdcode like'%$searchicdcode%') and  (a.primarydiag like '%$searchdisease%' or a.secondarydiag like '%$searchdisease%') and  b.age = '$searchage' and a.accountname like '%$searchsuppliername%'  and  a.consultationdate between '$icddatefrom' and '$icddateto' and a.locationcode in ($slocation)  group by a.patientvisitcode order by a.auto_number desc ";
		 }
		  }
		  else if ($searchrange == 'greater')
		  {
		  if($searchicdcode == '' && $searchdisease =='')
		  {
		  $query1 = "select a.locationname,b.age,a.consultationid,a.consultationtime,a.patientcode,a.patientname,a.patientvisitcode,a.consultationdate,a.accountname,a.locationcode,a.locationname from consultation_icd as a,master_visitentry as b where a.patientvisitcode=b.visitcode and b.age > '$searchage' and a.accountname like '%$searchsuppliername%'  and a.primaryicdcode like '%$searchicdcode%' and a.secicdcode like '%$searchicdcode%' and a.consultationdate between '$icddatefrom'  and '$icddateto' and a.locationcode in ($slocation) group by a.patientvisitcode order by a.auto_number desc ";
		  }
		  else
		  {
		    $query1 = "select a.locationname,b.age,a.consultationid,a.consultationtime,a.patientcode,a.patientname,a.patientvisitcode,a.consultationdate,a.accountname,a.locationcode,a.locationname from consultation_icd as a,master_visitentry as b where a.patientvisitcode=b.visitcode and (a.primaryicdcode like'%$searchicdcode%' or a.secicdcode like'%$searchicdcode%') and (a.primarydiag like '%$searchdisease%' or a.secondarydiag like '%$searchdisease%') and   b.age > '$searchage' and a.accountname like '%$searchsuppliername%' and  a.consultationdate between '$icddatefrom' and '$icddateto' and a.locationcode in ($slocation) group by a.patientvisitcode  order by a.auto_number desc ";
		  }
		  }
		  else if ($searchrange == 'lesser')
		  {
		  if($searchicdcode == '' && $searchdisease =='')
		  {
		    $query1 = "select a.locationname,b.age,a.consultationid,a.consultationtime,a.patientcode,a.patientname,a.patientvisitcode,a.consultationdate,a.accountname,a.locationcode,a.locationname from consultation_icd as a,master_visitentry as b where a.patientvisitcode=b.visitcode and b.age < '$searchage' and a.accountname like '%$searchsuppliername%'  and a.primaryicdcode like '%$searchicdcode%' and a.secicdcode like '%$searchicdcode%' and a.consultationdate between '$icddatefrom' and '$icddateto' and a.locationcode in ($slocation)  group by a.patientvisitcode order by a.auto_number desc ";
		  }
		  else
		  {
		  $query1 = "select a.locationname,b.age,a.consultationid,a.consultationtime,a.patientcode,a.patientname,a.patientvisitcode,a.consultationdate,a.accountname,a.locationcode,a.locationname from consultation_icd as a,master_visitentry as b where a.patientvisitcode=b.visitcode and (a.primaryicdcode like'%$searchicdcode%' or a.secicdcode like'%$searchicdcode%') and (a.primarydiag like '%$searchdisease%' or a.secondarydiag like '%$searchdisease%') and  b.age < '$searchage' and a.accountname like '%$searchsuppliername%'  and  a.consultationdate between '$icddatefrom' and '$icddateto' and a.locationcode in ($slocation)  group by a.patientvisitcode order by a.auto_number desc ";
		  }
		  }
		  else if ($searchrange == 'greaterequal')
		  {
		   if($searchicdcode == '' && $searchdisease =='')
		  {
		  $query1 = "select a.locationname,b.age,a.consultationid,a.consultationtime,a.patientcode,a.patientname,a.patientvisitcode,a.consultationdate,a.accountname,a.locationcode,a.locationname from consultation_icd as a,master_visitentry as b where a.patientvisitcode=b.visitcode and b.age >= '$searchage' and a.accountname like '%$searchsuppliername%'  and a.primaryicdcode like '%$searchicdcode%' and a.secicdcode like '%$searchicdcode%' and a.consultationdate between '$icddatefrom' and '$icddateto' and a.locationcode in ($slocation)  group by a.patientvisitcode order by a.auto_number desc ";
		  }
		  else
		  {
	 	   $query1 = "select a.locationname,b.age,a.consultationid,a.consultationtime,a.patientcode,a.patientname,a.patientvisitcode,a.consultationdate,a.accountname,a.locationcode,a.locationname from consultation_icd as a,master_visitentry as b where a.patientvisitcode=b.visitcode and (a.primaryicdcode like'%$searchicdcode%' or a.secicdcode like'%$searchicdcode%') and (a.primarydiag like '%$searchdisease%' or a.secondarydiag like '%$searchdisease%') and  b.age >= '$searchage' and a.accountname like '%$searchsuppliername%'  and  a.consultationdate between '$icddatefrom' and '$icddateto' and a.locationcode in ($slocation)  group by a.patientvisitcode order by a.auto_number desc ";
		  }
		  }
		  else if ($searchrange == 'lesserequal')
		  {
		    if($searchicdcode == '' && $searchdisease =='')
		  {
		  $query1 = "select a.locationname,b.age,a.consultationid,a.consultationtime,a.patientcode,a.patientname,a.patientvisitcode,a.consultationdate,a.accountname,a.locationcode,a.locationname from consultation_icd as a,master_visitentry as b where a.patientvisitcode=b.visitcode and b.age <= '$searchage' and a.accountname like '%$searchsuppliername%'  and a.primaryicdcode like '%$searchicdcode%' and a.secicdcode like '%$searchicdcode%' and a.consultationdate between '$icddatefrom' and '$icddateto' and a.locationcode in ($slocation)  group by a.patientvisitcode order by a.auto_number desc ";
		  }
		  else
		  {
		   $query1 = "select a.locationname,b.age,a.consultationid,a.consultationtime,a.patientcode,a.patientname,a.patientvisitcode,a.consultationdate,a.accountname,a.locationcode,a.locationname from consultation_icd as a,master_visitentry as b where a.patientvisitcode=b.visitcode and (a.primaryicdcode like'%$searchicdcode%' or a.secicdcode like'%$searchicdcode%' ) and (a.primarydiag like '%$searchdisease%' or a.secondarydiag like '%$searchdisease%') and  b.age <= '$searchage' and a.accountname like '%$searchsuppliername%'  and  a.consultationdate between '$icddatefrom' and '$icddateto' and a.locationcode in ($slocation)  group bya. patientvisitcode order by a.auto_number desc ";
		  }
		  }
			
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
 		 	 $num=mysqli_num_rows($exec1);
			 if($num>0)
			 { 
			while($res1 = mysqli_fetch_array($exec1))
			{
			
			$res1patientcode= $res1['patientcode'];
			$res1patientvisitcode= $res1['patientvisitcode'];
			$res1consultationdate= $res1['consultationdate'];
		 	$res1patientname= $res1['patientname'];
			$res1age=$res1['age'];
			$res1locationname=$res1['locationname'];
			
			
			if($searchicdcode == '' && $searchdisease =='')
			{
					$query12 = "select primaryicdcode from consultation_icd where patientvisitcode='$res1patientvisitcode' and patientcode='$res1patientcode' and primaryicdcode like '%$searchicdcode%' and secicdcode like '%$searchicdcode%' and consultationdate between '$icddatefrom' and '$icddateto' and primaryicdcode <>''  order by auto_number desc limit 0,1";
			
			}
			else
			{
			 $query12 = "select primaryicdcode from consultation_icd where (primaryicdcode like '%$searchicdcode%' or secicdcode like '%$searchicdcode%') and (primarydiag like '%$searchdisease%' or secondarydiag like '%$searchdisease%') and  patientvisitcode='$res1patientvisitcode' and patientcode='$res1patientcode'  and consultationdate between '$icddatefrom' and '$icddateto' and primaryicdcode <>''  and primarydiag <>''  order by auto_number desc limit 0,1";
			
			}
		 
			$exe01=mysqli_query($GLOBALS["___mysqli_ston"], $query12);
			$num01=mysqli_num_rows($exe01);
			if($num01>0)
			{
			$res01=mysqli_fetch_array($exe01);
			$primarydiagcode=$res01['primaryicdcode'];
			$detailicd="select description,icdcode,chapter,disease from master_icd where icdcode='$primarydiagcode' order by auto_number desc limit 0,1";
			$exedet=mysqli_query($GLOBALS["___mysqli_ston"], $detailicd);
			$res011=mysqli_fetch_array($exedet);
		 	$res1disease= $res011['description']; 
			$res1diseasecode= $res011['icdcode'];
			$primarychapter=$res011['chapter'];
			$primarydisease=$res011['disease'];
			}else{
              $res1disease=''; 
			$res1diseasecode= '';
			$primarychapter='';
			$primarydisease='';
			}
			       
		  if($searchicdcode == '' && $searchdisease =='')
		  {
		 $query12 = "select secicdcode from consultation_icd where patientvisitcode='$res1patientvisitcode' and patientcode='$res1patientcode'  and primaryicdcode like '%$searchicdcode%' and secicdcode like '%$searchicdcode%' and consultationdate between '$icddatefrom' and '$icddateto' and secicdcode <>''  order by auto_number desc limit 0,1";
		   }
		   else
		   {
		    $query12 = "select secicdcode from consultation_icd where (primaryicdcode like '%$searchicdcode%' or secicdcode like '%$searchicdcode%') and (primarydiag like '%$searchdisease%' or secondarydiag like '%$searchdisease%') and  patientvisitcode='$res1patientvisitcode' and patientcode='$res1patientcode'  and consultationdate between '$icddatefrom' and '$icddateto' and secicdcode <>''  order by auto_number desc limit 0,1";
		   }
		
		 	$exe011=mysqli_query($GLOBALS["___mysqli_ston"], $query12);
			$num01=mysqli_num_rows($exe011);
			if($num01>0)
			{
			$res01=mysqli_fetch_array($exe011);
 			$numrow=mysqli_num_rows($exe01);
			$secicdcode1=$res01['secicdcode'];
			$detailicd="select description,icdcode,chapter,disease from master_icd where icdcode='$secicdcode1' order by auto_number desc limit 0,1";
			$exedet=mysqli_query($GLOBALS["___mysqli_ston"], $detailicd);
			$res011=mysqli_fetch_array($exedet);
		 	$secondarydiagnosis= $res011['description'];
			$secondarycode= $res011['icdcode'];
			$secchapter=$res011['chapter'];
			$secdisease=$res011['disease'];	
			}else{
              $secondarydiagnosis= '';
			$secondarycode= '';
			$secchapter='';
			$secdisease='';
			}
			
			$query2 = "select gender,departmentname,visitcount,subtype,accountname,billtype,locationcode,age from master_visitentry where patientcode = '$res1patientcode' and visitcode = '$res1patientvisitcode' order by auto_number desc";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2 = mysqli_fetch_array($exec2);
			$res2gender= $res2['gender'];
			$res2department= $res2['departmentname'];
			$visitcount= $res2['visitcount'];
			$res2subtype= $res2['subtype'];
			$res2accountname= $res2['accountname'];
			$res2locationcode= $res2['locationcode'];
			$res2billtype= $res2['billtype'];
			$res1age = $res2['age'];
			$dsql="select username from master_consultationlist where patientcode = '$res1patientcode' and visitcode = '$res1patientvisitcode' and locationcode = '$res2locationcode' order by auto_number desc limit 0,1";
			$execdsql = mysqli_query($GLOBALS["___mysqli_ston"], $dsql) or die ("Error in dsql".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res_dsql = mysqli_fetch_array($execdsql);
			$docusername=$res_dsql['username'];
			if($docusername!='')
			{
				
				$empsql="select employeename from doctor_mapping where docusername='$docusername'";
				$execemp = mysqli_query($GLOBALS["___mysqli_ston"], $empsql) or die ("Error in empsql".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res_empname = mysqli_fetch_array($execemp);
				$doctor_name=$res_empname['employeename'];
				$doctor_name = strtoupper($doctor_name);
				if($doctor_name==''){ 
					$empsql="select employeename from master_employee where username='$docusername'";
					$execemp = mysqli_query($GLOBALS["___mysqli_ston"], $empsql) or die ("Error in empsql".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res_empname = mysqli_fetch_array($execemp);
					$doctor_name=$res_empname['employeename'];
					$doctor_name = strtoupper($doctor_name);
				}
			}else
			  $doctor_name ='';
			
			$query222 = "select subtype from master_subtype where auto_number = '$res2subtype' AND recordstatus = '' "; 
			$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in query222".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res222 = mysqli_fetch_array($exec222);
			$subtypename= $res222['subtype'];
			
			$query222 = "select accountname from master_accountname where auto_number = '$res2accountname' AND recordstatus = 'ACTIVE' "; 
			$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in query222".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res222 = mysqli_fetch_array($exec222);
			$res21accountname= $res222['accountname'];
			
			$query213 = "select mobilenumber,area from master_customer where customercode = '$res1patientcode'"; 
			$exec213 = mysqli_query($GLOBALS["___mysqli_ston"], $query213) or die ("Error in query213".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res213 = mysqli_fetch_array($exec213);
			$num013=mysqli_num_rows($exec213);
			if($num013>0){ $mobilenumber = $res213['mobilenumber']; }else{ $mobilenumber = ''; }
			if(isset($res213['area']) && $res213['area']!='')
			  $area = ucfirst(strtolower($res213['area']));
			else
			  $area = '';
			
			if($visitcount <= 1){$visitstatus = 'New';}else{$visitstatus = 'Revisit';}
			
			if($res2billtype =='PAY LATER'){
				
				$query21 = "select accountname,transactionamount,billnumber from master_transactionpaylater where patientcode = '$res1patientcode' and visitcode = '$res1patientvisitcode'"; 
				$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in query21".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res21 = mysqli_fetch_array($exec21);
			
				$res21accountnames= $res21['accountname'];
				$res21amount= $res21['transactionamount'];
				$billnumbers =$res21['billnumber'];
				$billnumber ='<a target="_blank" href="print_paylater_detailed.php?locationcode='.$res2locationcode.'&&billautonumber='.$billnumbers.'"><strong>'.$billnumbers.'</strong></a>';
				
			}else{
				$locationcode = $res2locationcode;
				$patientcode = $res1patientcode;
				$visitcode = $res1patientvisitcode;
				include "include_paynowsummary.php";
				$res21amount= number_format($nettotal,2,'.',',');
				$billnumber ='<a target="_blank" href="print_paynowsummary.php?locationcode='.$res2locationcode.'&&patientcode='.$res1patientcode.'&&visitcode='.$res1patientvisitcode.'"><strong>Bill Summary</strong></a>';
			}
			
			$query211 = "select bpdiastolic,bpsystolic from master_triage where visitcode='$res1patientvisitcode' ";
			$exec211 = mysqli_query($GLOBALS["___mysqli_ston"], $query211) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res211 = mysqli_fetch_array($exec211);
			$bpdiastolic = $res211['bpdiastolic'];
			$bpsystolic = $res211['bpsystolic'];
			
			
			
			if($res1diseasecode<>''||$secondarycode<>''||$tertiarycode<>'')
			{
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
            
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" width="" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $res1patientcode; ?></td>
               <td align="left" width=""  valign="center"  class="bodytext31"><a target="_blank" href="emrcasesheet.php?visitcode=<?php echo $res1patientvisitcode; ?>"><?php echo $res1patientvisitcode; ?> </a></td>
               <td class="bodytext31" width=""  valign="center"  align="left"><?php echo date('d-m-y',strtotime($res1consultationdate)); ?></td>
               <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $res1patientname; ?></td>
               <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $res2gender; ?></td>
               <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $res1age; ?></td>
			   <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $mobilenumber; ?></td>
			   <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $area; ?></td>
			   <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $subtypename; ?></td>
				<td class="bodytext31" width=""  valign="center"  align="left"><?php echo $res21accountname; ?></td>
				<td class="bodytext31" width=""  valign="center"  align="left"><?php echo $billnumber; ?></td>
                 <td class="bodytext31" width=""  valign="center"  align="right"><?php echo $res21amount ?></td>
				<td class="bodytext31" width=""  valign="center"  align="left"><?php echo $visitstatus; ?></td>
                <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $primarydisease; ?></td>
                <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $primarychapter; ?></td>
               <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $res1disease; ?></td>
                <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $res1diseasecode; ?></td>
                <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $secdisease; ?></td>
                <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $secchapter; ?></td>
				 <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $secondarydiagnosis; ?></td>
                 <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $secondarycode; ?></td>
<!--                 <td class="bodytext31" width="5%"  valign="center"  align="left"><?php echo $tridisease; ?></td>
                <td class="bodytext31" width="3%"  valign="center"  align="left"><?php echo $trichapter; ?></td>
                  <td class="bodytext31" width="8%"  valign="center"  align="left"><?php echo $tertiarydiagnosis; ?></td>
                 <td class="bodytext31" width="4%"  valign="center"  align="left"><?php echo $tertiarycode; ?></td>-->
				  <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $bpsystolic.'/'.$bpdiastolic; ?></td>
				  <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $doctor_name; ?></td>
                <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $res1locationname; ?></td>
                 
               </tr>
		   <?php 
		   }  
			}
		  }
				}
			if($visittype =='IP' || $visittype =='ALL' )
			{
			$secondarydiagnosis2='';
			$secondarycode2 ='';
			$secchapter2='';
			$secdisease2 ='';
			
/* 			if($searchicdcode == '' && $searchdisease =='')
			{
		  
			//echo $query11 ="select dis.locationname,dis.patientcode,dis.patientname,dis.patientvisitcode,dis.dischargedate,dis.locationcode,dis.locationname,mip.age,mip.accountfullname from discharge_icd as dis inner join master_ipvisitentry as mip on dis.patientcode = mip.patientcode and dis.patientvisitcode = mip.visitcode where  mip.age like '%$searchage%' and mip.accountfullname like '%$searchsuppliername%' and dis.primaryicdcode like '%$searchicdcode%' and dis.secicdcode like '%$searchicdcode%' and dis.dischargedate between '$icddatefrom' and '$icddateto' and dis.locationcode in ($slocation) group by dis.patientvisitcode order by dis.auto_number desc";
			
			$query11 = "select locationname,patientcode,patientname,patientvisitcode,dischargedate,locationcode,locationname from discharge_icd where primaryicdcode like '%$searchicdcode%' and secicdcode like '%$searchicdcode%' and dischargedate between '$icddatefrom' and '$icddateto' and locationcode in ($slocation) group by patientvisitcode order by auto_number desc  ";
		   }
		   else
		   {
		    $query11 = "select locationname,patientcode,patientname,patientvisitcode,dischargedate,locationcode,locationname from discharge_icd where  (primaryicdcode like'%$searchicdcode%' or secicdcode like'%$searchicdcode%') and  (primarydiag like '%$searchdisease%' or secondarydiag like '%$searchdisease%') and  dischargedate between '$icddatefrom' and '$icddateto' and locationcode in ($slocation)  group by patientvisitcode order by auto_number desc ";
		   } */
			//echo $query11;
			
			
			
			if ($searchrange == '')
			{         
			if($searchicdcode == '' && $searchdisease =='')
			{
			$query11 ="select dis.locationname,dis.patientcode,dis.patientname,dis.patientvisitcode,dis.dischargedate,dis.locationcode,dis.locationname,mip.age,mip.accountfullname from discharge_icd as dis inner join master_ipvisitentry as mip on dis.patientcode = mip.patientcode and dis.patientvisitcode = mip.visitcode where  mip.age like '%$searchage%' and mip.accountfullname like '%$searchsuppliername%' and dis.primaryicdcode like '%$searchicdcode%' and dis.secicdcode like '%$searchicdcode%' and dis.dischargedate between '$icddatefrom' and '$icddateto' and dis.locationcode in ($slocation) group by dis.patientvisitcode order by dis.auto_number desc";
			
		   }
		   else
		   {
			
			$query11 ="select dis.locationname,dis.patientcode,dis.patientname,dis.patientvisitcode,dis.dischargedate,dis.locationcode,mip.age,mip.accountfullname  from discharge_icd as dis inner join master_ipvisitentry as mip on dis.patientcode = mip.patientcode and dis.patientvisitcode = mip.visitcode  where  (primaryicdcode like'%$searchicdcode%' or secicdcode like'%$searchicdcode%') and  (primarydiag like '%$searchdisease%' or secondarydiag like '%$searchdisease%')  and mip.age like '%$searchage%' and mip.accountname like '%$searchsuppliername%' and  dis.dischargedate between '$icddatefrom' and '$icddateto' and dis.locationcode in ($slocation)  group by dis.patientvisitcode order by dis.auto_number desc ";
		   }
		  }
		  else if ($searchrange == 'equal')
		  { 
		  if($searchicdcode == '' && $searchdisease =='')
		  {
			  $query11 ="select dis.locationname,dis.patientcode,dis.patientname,dis.patientvisitcode,dis.dischargedate,dis.locationcode,dis.locationname,mip.age,mip.accountfullname from discharge_icd as dis inner join master_ipvisitentry as mip on dis.patientcode = mip.patientcode and dis.patientvisitcode = mip.visitcode where  mip.age = '$searchage' and mip.accountfullname like '%$searchsuppliername%' and dis.primaryicdcode like '%$searchicdcode%' and dis.secicdcode like '%$searchicdcode%' and dis.dischargedate between '$icddatefrom' and '$icddateto' and dis.locationcode in ($slocation) group by dis.patientvisitcode order by dis.auto_number desc";
		 }
		 else
		 {
			 $query11 ="select dis.locationname,dis.patientcode,dis.patientname,dis.patientvisitcode,dis.dischargedate,dis.locationcode,mip.age,mip.accountfullname  from discharge_icd as dis inner join master_ipvisitentry as mip on dis.patientcode = mip.patientcode and dis.patientvisitcode = mip.visitcode  where  (primaryicdcode like'%$searchicdcode%' or secicdcode like'%$searchicdcode%') and  (primarydiag like '%$searchdisease%' or secondarydiag like '%$searchdisease%')  and mip.age = '$searchage' and mip.accountname like '%$searchsuppliername%' and  dis.dischargedate between '$icddatefrom' and '$icddateto' and dis.locationcode in ($slocation)  group by dis.patientvisitcode order by dis.auto_number desc ";
			 
	  	 }
		  }
		  else if ($searchrange == 'greater')
		  {
		  if($searchicdcode == '' && $searchdisease =='')
		  {
			   $query11 ="select dis.locationname,dis.patientcode,dis.patientname,dis.patientvisitcode,dis.dischargedate,dis.locationcode,dis.locationname,mip.age,mip.accountfullname from discharge_icd as dis inner join master_ipvisitentry as mip on dis.patientcode = mip.patientcode and dis.patientvisitcode = mip.visitcode where  mip.age > '$searchage' and mip.accountfullname like '%$searchsuppliername%' and dis.primaryicdcode like '%$searchicdcode%' and dis.secicdcode like '%$searchicdcode%' and dis.dischargedate between '$icddatefrom' and '$icddateto' and dis.locationcode in ($slocation) group by dis.patientvisitcode order by dis.auto_number desc";
			   
		  }
		  else
		  {
			  $query11 ="select dis.locationname,dis.patientcode,dis.patientname,dis.patientvisitcode,dis.dischargedate,dis.locationcode,mip.age,mip.accountfullname  from discharge_icd as dis inner join master_ipvisitentry as mip on dis.patientcode = mip.patientcode and dis.patientvisitcode = mip.visitcode  where  (primaryicdcode like'%$searchicdcode%' or secicdcode like'%$searchicdcode%') and  (primarydiag like '%$searchdisease%' or secondarydiag like '%$searchdisease%')  and mip.age > '$searchage' and mip.accountname like '%$searchsuppliername%' and  dis.dischargedate between '$icddatefrom' and '$icddateto' and dis.locationcode in ($slocation)  group by dis.patientvisitcode order by dis.auto_number desc ";
			  
		
		  }
		  }
		  else if ($searchrange == 'lesser')
		  {
		  if($searchicdcode == '' && $searchdisease =='')
		  {
			   $query11 ="select dis.locationname,dis.patientcode,dis.patientname,dis.patientvisitcode,dis.dischargedate,dis.locationcode,dis.locationname,mip.age,mip.accountfullname from discharge_icd as dis inner join master_ipvisitentry as mip on dis.patientcode = mip.patientcode and dis.patientvisitcode = mip.visitcode where  mip.age < '$searchage' and mip.accountfullname like '%$searchsuppliername%' and dis.primaryicdcode like '%$searchicdcode%' and dis.secicdcode like '%$searchicdcode%' and dis.dischargedate between '$icddatefrom' and '$icddateto' and dis.locationcode in ($slocation) group by dis.patientvisitcode order by dis.auto_number desc";
			
		  }
		  else
		  {
			  $query11 ="select dis.locationname,dis.patientcode,dis.patientname,dis.patientvisitcode,dis.dischargedate,dis.locationcode,mip.age,mip.accountfullname  from discharge_icd as dis inner join master_ipvisitentry as mip on dis.patientcode = mip.patientcode and dis.patientvisitcode = mip.visitcode  where  (primaryicdcode like'%$searchicdcode%' or secicdcode like'%$searchicdcode%') and  (primarydiag like '%$searchdisease%' or secondarydiag like '%$searchdisease%')  and mip.age < '$searchage' and mip.accountname like '%$searchsuppliername%' and  dis.dischargedate between '$icddatefrom' and '$icddateto' and dis.locationcode in ($slocation)  group by dis.patientvisitcode order by dis.auto_number desc ";
			  
		  }
		  }
		  else if ($searchrange == 'greaterequal')
		  {
		   if($searchicdcode == '' && $searchdisease =='')
		  {
			   $query11 ="select dis.locationname,dis.patientcode,dis.patientname,dis.patientvisitcode,dis.dischargedate,dis.locationcode,dis.locationname,mip.age,mip.accountfullname from discharge_icd as dis inner join master_ipvisitentry as mip on dis.patientcode = mip.patientcode and dis.patientvisitcode = mip.visitcode where  mip.age >= '$searchage' and mip.accountfullname like '%$searchsuppliername%' and dis.primaryicdcode like '%$searchicdcode%' and dis.secicdcode like '%$searchicdcode%' and dis.dischargedate between '$icddatefrom' and '$icddateto' and dis.locationcode in ($slocation) group by dis.patientvisitcode order by dis.auto_number desc";
			
		  }
		  else
		  {
			  
			$query11 ="select dis.locationname,dis.patientcode,dis.patientname,dis.patientvisitcode,dis.dischargedate,dis.locationcode,mip.age,mip.accountfullname  from discharge_icd as dis inner join master_ipvisitentry as mip on dis.patientcode = mip.patientcode and dis.patientvisitcode = mip.visitcode  where  (primaryicdcode like'%$searchicdcode%' or secicdcode like'%$searchicdcode%') and  (primarydiag like '%$searchdisease%' or secondarydiag like '%$searchdisease%')  and mip.age >= '$searchage' and mip.accountname like '%$searchsuppliername%' and  dis.dischargedate between '$icddatefrom' and '$icddateto' and dis.locationcode in ($slocation)  group by dis.patientvisitcode order by dis.auto_number desc ";
			
		  }
		  }
		  else if ($searchrange == 'lesserequal')
		  {
		    if($searchicdcode == '' && $searchdisease =='')
		  {
			   $query11 ="select dis.locationname,dis.patientcode,dis.patientname,dis.patientvisitcode,dis.dischargedate,dis.locationcode,dis.locationname,mip.age,mip.accountfullname from discharge_icd as dis inner join master_ipvisitentry as mip on dis.patientcode = mip.patientcode and dis.patientvisitcode = mip.visitcode where  mip.age <= '$searchage' and mip.accountfullname like '%$searchsuppliername%' and dis.primaryicdcode like '%$searchicdcode%' and dis.secicdcode like '%$searchicdcode%' and dis.dischargedate between '$icddatefrom' and '$icddateto' and dis.locationcode in ($slocation) group by dis.patientvisitcode order by dis.auto_number desc";
			   
		  }
		  else
		  {
		   $query11 ="select dis.locationname,dis.patientcode,dis.patientname,dis.patientvisitcode,dis.dischargedate,dis.locationcode,mip.age,mip.accountfullname  from discharge_icd as dis inner join master_ipvisitentry as mip on dis.patientcode = mip.patientcode and dis.patientvisitcode = mip.visitcode  where  (primaryicdcode like'%$searchicdcode%' or secicdcode like'%$searchicdcode%') and  (primarydiag like '%$searchdisease%' or secondarydiag like '%$searchdisease%')  and mip.age <= '$searchage' and mip.accountname like '%$searchsuppliername%' and  dis.dischargedate between '$icddatefrom' and '$icddateto' and dis.locationcode in ($slocation)  group by dis.patientvisitcode order by dis.auto_number desc ";
		  }
		  }
		  
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in query11".mysqli_error($GLOBALS["___mysqli_ston"]));
 		 	 $num1=mysqli_num_rows($exec11);
			 if($num1>0)
			 { 
			while($res11 = mysqli_fetch_array($exec11))
			{
			
			$res1patientcode1= $res11['patientcode'];
			$res1patientvisitcode1= $res11['patientvisitcode'];
			$res1consultationdate1= $res11['dischargedate'];
		 	$res1patientname1= $res11['patientname'];
			$res1age1='0';//$res1['age'];
			$res1locationname1=$res11['locationname'];
			
			
			if($searchicdcode == '' && $searchdisease =='')
			{
					$query12 = "select primaryicdcode from discharge_icd where patientvisitcode='$res1patientvisitcode1' and patientcode='$res1patientcode1' and primaryicdcode like '%$searchicdcode%' and secicdcode like '%$searchicdcode%' and dischargedate between '$icddatefrom' and '$icddateto' and primaryicdcode <>''  order by auto_number desc limit 0,1";
			
			}
			else
			{
			 $query12 = "select primaryicdcode from discharge_icd where (primaryicdcode like '%$searchicdcode%' or secicdcode like '%$searchicdcode%') and (primarydiag like '%$searchdisease%' or secondarydiag like '%$searchdisease%') and  patientvisitcode='$res1patientvisitcode1' and patientcode='$res1patientcode1'  and dischargedate between '$icddatefrom' and '$icddateto' and primaryicdcode <>''  and primarydiag <>''   order by auto_number desc limit 0,1";
			
			}
		 
			$exe011=mysqli_query($GLOBALS["___mysqli_ston"], $query12);
			$num011=mysqli_num_rows($exe011);
			if($num011>0)
			{
			$res011=mysqli_fetch_array($exe011);
			$primarydiagcode1=$res011['primaryicdcode'];
			$detailicd1="select description,icdcode,chapter,disease from master_icd where icdcode='$primarydiagcode1' order by auto_number desc limit 0,1";
			$exedet1=mysqli_query($GLOBALS["___mysqli_ston"], $detailicd1);
			$res0111=mysqli_fetch_array($exedet1);
		 	$res1disease1= $res0111['description']; 
			$res1diseasecode1= $res0111['icdcode'];
			$primarychapter1=$res0111['chapter'];
			$primarydisease1=$res0111['disease'];
			}
			       
		  if($searchicdcode == '' && $searchdisease =='')
		  {
		 $query12 = "select secicdcode from discharge_icd where patientvisitcode='$res1patientvisitcode1' and patientcode='$res1patientcode1'  and primaryicdcode like '%$searchicdcode%' and secicdcode like '%$searchicdcode%' and dischargedate between '$icddatefrom' and '$icddateto' and secicdcode <>'' and secondarydiag <>''   order by auto_number desc limit 0,1";
		   }
		   else
		   {
		    $query12 = "select secicdcode from discharge_icd where (primaryicdcode like '%$searchicdcode%' or secicdcode like '%$searchicdcode%') and (primarydiag like '%$searchdisease%' or secondarydiag like '%$searchdisease%') and  patientvisitcode='$res1patientvisitcode1' and patientcode='$res1patientcode1'  and dischargedate between '$icddatefrom' and '$icddateto' and secicdcode <>'' and secondarydiag <>''   order by auto_number desc limit 0,1";
		   }
		//echo $query12."<br>";
		
		 	$exe0112=mysqli_query($GLOBALS["___mysqli_ston"], $query12);
			$num012=mysqli_num_rows($exe0112);
			if($num012>0)
			{
			$res012=mysqli_fetch_array($exe0112);
 			//$numrow=mysql_num_rows($exe012);
			$secicdcode12=trim($res012['secicdcode']);
			$detailicd2="select description,icdcode,chapter,disease from master_icd where icdcode='$secicdcode12' order by auto_number desc limit 0,1";
			$exedet2=mysqli_query($GLOBALS["___mysqli_ston"], $detailicd2);
			$res0112=mysqli_fetch_array($exedet2);
		 	$secondarydiagnosis2= $res0112['description'];
			$secondarycode2= $res0112['icdcode'];
			$secchapter2=$res0112['chapter'];
			$secdisease2=$res0112['disease'];	
			}
			
			$query22 = "select gender,accountfullname,age,subtype,accountname,finalbillno,visitcount,locationcode,consultingdoctorName from master_ipvisitentry where patientcode = '$res1patientcode1' and visitcode = '$res1patientvisitcode1' order by auto_number desc";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22);
			$res2gender2= $res22['gender'];
			$res1age1= $res22['age'];
			$res2subtype= $res22['subtype'];
			$res2accountname= $res22['accountname'];
			$billnumbers =$res22['finalbillno'];
			$res2visitcount= $res22['visitcount'];
			$res2locationcode1= $res22['locationcode'];
			$doctor_name =$res22['consultingdoctorName'];
			
			if(substr($billnumbers,0,4) =='IPF-'){
				
				$billnumber ='<a target="_blank" href="print_ipfinalinvoice1.php?locationcode='.$res2locationcode1.'&&patientcode='.$res1patientcode1.'&&visitcode='.$res1patientvisitcode1.'&&billnumber='.$billnumbers.'"><strong>'.$billnumbers.'</strong></a>';
				
			}else{
				
				$billnumber ='<a target="_blank" href="print_creditapproval.php?locationcode='.$res2locationcode1.'&&patientcode='.$res1patientcode1.'&&visitcode='.$res1patientvisitcode1.'&&billnumber='.$billnumbers.'"><strong>'.$billnumbers.'</strong></a>';
				
			}
			
			
			$query222 = "select subtype from master_subtype where auto_number = '$res2subtype' AND recordstatus = '' "; 
			$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in query222".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res222 = mysqli_fetch_array($exec222);
			$subtypename= $res222['subtype'];
			
			$query222 = "select accountname from master_accountname where auto_number = '$res2accountname' AND recordstatus = 'ACTIVE' "; 
			$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in query222".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res222 = mysqli_fetch_array($exec222);
			$res21accountname2= $res222['accountname'];
			
		 	$query213 = "select mobilenumber,area from master_customer where customercode = '$res1patientcode1'"; 
			$exec213 = mysqli_query($GLOBALS["___mysqli_ston"], $query213) or die ("Error in query213".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res213 = mysqli_fetch_array($exec213);
			$num013=mysqli_num_rows($exec213);
			if($num013>0){
				$mobilenumber = $res213['mobilenumber'];
			}else{$mobilenumber = '';}
            if(isset($res213['area']) && $res213['area']!='')
			  $area = ucfirst(strtolower($res213['area']));
			else
			  $area = '';
			
			if($res2visitcount <= 1){$visitstatus = 'New';}else{$visitstatus = 'Revisit';}
			
			$query212 = "select totalrevenue as transactionamount from billing_ip where patientcode = '$res1patientcode1' and  visitcode = '$res1patientvisitcode1' and billno != '' "; 
			$exec212 = mysqli_query($GLOBALS["___mysqli_ston"], $query212) or die ("Error in query212".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num0212=mysqli_num_rows($exec212);
			if($num0212 > 0 ){ 
				$res212 = mysqli_fetch_array($exec212);
				$res21amount2= $res212['transactionamount'];
				
			}else{ 
				
				$query214 = "select sum(transactionamount) as transactionamount from master_transactionipcreditapproved where patientcode = '$res1patientcode1' and  visitcode = '$res1patientvisitcode1' and transactiontype='finalize' "; 
				$exec214 = mysqli_query($GLOBALS["___mysqli_ston"], $query214) or die ("Error in query214".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res214 = mysqli_fetch_array($exec214);
				$res21amount2= $res214['transactionamount'];
			}
			
			
			
			
			
			
			if($res1diseasecode1<>''||$secondarycode2<>''||$tertiarycode<>'')
			{
				
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
            
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" width="" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $res1patientcode1; ?></td>
               <td align="left" width=""  valign="center"  class="bodytext31"><?php echo $res1patientvisitcode1; ?><a target="_blank" href="ipemrview.php?patientcode=<?php echo $res1patientcode1; ?>&&visitcode=<?php echo $res1patientvisitcode1; ?>"><?php echo $res1patientvisitcode1; ?></a></td>
               <td class="bodytext31" width=""  valign="center"  align="left"><?php echo date('d-m-y',strtotime($res1consultationdate1)); ?></td>
               <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $res1patientname1; ?></td>
               <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $res2gender2; ?></td>
               <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $res1age1; ?></td>
			    <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $mobilenumber; ?></td>
				<td class="bodytext31" width=""  valign="center"  align="left"><?php echo $area; ?></td>
			   <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $subtypename; ?></td>
				<td class="bodytext31" width=""  valign="center"  align="left"><?php echo $res21accountname2; ?></td>
				<td class="bodytext31" width=""  valign="center"  align="left"><?php echo $billnumber; ?></td>
                 <td class="bodytext31" width=""  valign="center"  align="right"><?php echo $res21amount2 ?></td>
				<td class="bodytext31" width=""  valign="center"  align="left"><?php echo $visitstatus; ?></td>
				<td class="bodytext31" width=""  valign="center"  align="left"><?php echo $primarydisease1; ?></td>
                <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $primarychapter1; ?></td>
               <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $res1disease1; ?></td>
                <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $res1diseasecode1; ?></td>
                <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $secdisease2; ?></td>
                <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $secchapter2; ?></td>
				 <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $secondarydiagnosis2; ?></td>
                 <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $secondarycode2; ?></td>
<!--                 <td class="bodytext31" width="5%"  valign="center"  align="left"><?php echo $tridisease; ?></td>
                <td class="bodytext31" width="3%"  valign="center"  align="left"><?php echo $trichapter; ?></td>
                  <td class="bodytext31" width="8%"  valign="center"  align="left"><?php echo $tertiarydiagnosis; ?></td>
                 <td class="bodytext31" width="4%"  valign="center"  align="left"><?php echo $tertiarycode; ?></td>-->
				 <td class="bodytext31" width=""  valign="center"  align="left"><?php echo ''; ?></td>
				 <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $doctor_name; ?></td>
                <td class="bodytext31" width=""  valign="center"  align="left"><?php echo $res1locationname1; ?></td>
                 
               </tr>
			
			<?php
		   }  
			}
		  }
			}
				
				}
		   ?>
		   
		   
		   
		   
		   
		   
            <tr>
              <td width="1%" rowspan="2" align="left" valign="center" bgcolor="#ecf0f5" class="style3"><span class="bodytext31"><a href="print_patientwiseicd.php?ADate1=<?php echo $icddatefrom; ?>&&ADate2=<?php echo $icddateto; ?>&&age=<?php echo $icdage; ?>&&range=<?php echo $icdrange; ?>&&icdcode=<?php echo $icdcode1; ?>&&searchsuppliername=<?php echo $searchsuppliername; ?>&&locationcode=<?=$slocation1;?>&&disease=<?=$searchdisease; ?>&&visittype=<?=$visittype; ?>" target="_blank" ><img src="images/excel-xls-icon.png" width="30" height="30"></a></span></td>
              <td align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
			   </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>