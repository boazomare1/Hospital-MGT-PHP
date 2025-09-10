<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
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

//This include updatation takes too long to load for hunge items database.
$docno = $_SESSION['docno'];
 //get location for sort by location purpose
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		  $locationcode=$location;
		}
	


if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

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
<style type="text/css">
.imgloader { background-color:#FFFFFF; }
#imgloader1 {
    position: absolute;
    top: 158px;
    left: 487px;
    width: 28%;
    height: 24%;
}
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script src="js/jquery.min.js"></script>

<script language="javascript">
function FuncPopup()
{
	window.scrollTo(0,0);
	document.getElementById("imgloader").style.display = "";
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
function cbsuppliername1()
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

<style type="text/css">
.imgloader { background-color:#FFFFFF; }
#imgloader1 {
    position: absolute;
    top: 158px;
    left: 487px;
    width: 28%;
    height: 24%;
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<div align="center" class="imgloader" id="imgloader" style="display:none;">
	<div align="center" class="imgloader" id="imgloader1" style="display:;">
	    <p style="text-align:center;" id='claim_msg'></p>
		<p style="text-align:center;"><strong>Processing <br><br> Please be patient...</strong></p>
		<img src="images/ajaxloader.gif">
	</div>
</div>
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
		
		
              <form name="cbform1" method="post" action="slade_reposting.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>Pending Slade Bills </strong></td>
               <td colspan="1" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                  <?php
					
						$query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						
						?>
						
                  
                  </td>
              </tr>
           
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patient" type="text" id="patient" style="border: 1px solid #001E6A;" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			    <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patientcode</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patientcode" type="text" id="patient" style="border: 1px solid #001E6A;" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			    <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visitcode</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="visitcode" type="text" id="patient" style="border: 1px solid #001E6A;" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			      <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Bill Number</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="billnumber" type="text" id="billnumber" style="border: 1px solid #001E6A;" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
            <tr>
          <td width="76" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="123" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="51" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="129" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          </tr>
           
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" /></td>
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
	<form name="form1" id="form1" method="post" action="pending_claims.php">	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$searchpatient = $_POST['patient'];
	$searchpatientcode=$_POST['patientcode'];
	
	$searchvisitcode=$_POST['visitcode'];
	$fromdate=$_POST['ADate1'];
	$todate=$_POST['ADate2'];
	$billnumber2=$_POST['billnumber'];
	
    $querynw1 = "select * from billing_paylater where  (eclaim_id='2' or eclaim_id='3') and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billdate between '$fromdate' and '$todate' and billno like '%$billnumber2%' and slade_status!='completed' ";

			$execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resnw1=mysqli_num_rows($execnw1);
	
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200" 
            align="left" border="0">
          <tbody>
             <tr>
			 <td colspan="9" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Pending Slade Postings</strong><label class="number"></label></div></td>
			 </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				 <td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bill Date </strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Visit Code  </strong></div></td>
              <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient Name</strong></div></td>
				  <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Bill Number</strong></div></td>

				 <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Claim type</strong></div></td>
                
                
                 <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Location</strong></div></td>
             
                <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
             <td width="50%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Action</strong></td>
              </tr>
           <?php
            
		$eclaim_val='';
		 $query12 = "select a.patientname,a.patientcode,a.visitcode,a.billdate,a.accountname,a.billno,a.slade_claim_id,a.fxamount ,a.locationname,b.eclaim_id,b.offpatient  from billing_paylater as a JOIN
		 master_visitentry as b on (a.visitcode=b.visitcode)
		  where (b.eclaim_id='2' or b.eclaim_id='3' or b.offpatient='1') and a.locationcode='$res1locationanum' and a.patientcode like '%$searchpatientcode%' and a.visitcode like '%$searchvisitcode%' and a.patientname like '%$searchpatient%' and a.billdate between '$fromdate' and '$todate' and a.billno like '%$billnumber2%'";
		 /*$query12 = "select * from billing_paylater where (eclaim_id='2' or eclaim_id='3') and locationcode='$res1locationanum' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billdate between '$fromdate' and '$todate' and billno like '%$billnumber2%' and slade_status!='completed' ";*/
		$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num12=mysqli_num_rows($exec12);
		if($num12>0){
		?>
		<tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5" colspan='9'><div align="left"><strong>OP</strong></div></td>
				 
              </tr>
		
		<?php
		}
		while($res12 = mysqli_fetch_array($exec12))
		{
		$patientname=$res12['patientname'];
		$patientcode=$res12['patientcode'];
		 $visitcode=$res12['visitcode'];
		$consultationdate=$res12['billdate'];
		$accountname=$res12['accountname'];	
	    $billnumber=$res12['billno'];
		$slade_claim_id=$res12['slade_claim_id'];
		$amount=$res12['fxamount'];
		$totalamount=$amount;
		$locationname_bp=$res12['locationname'];
		$eclaim_id=$res12['eclaim_id'];
		if($eclaim_id=='2')
		{
			$eclaim_val='Slade';
		}
		else if($eclaim_id=='3')
		{
			$eclaim_val='Smart+Slade';
		}
		
		 
		 
		 
		$query17 = "select * from slade_claim where visitcode='$visitcode' group by visitcode";
		$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num232 = mysqli_num_rows($exec17);
		$res17 = mysqli_fetch_array($exec17);
		$claim_payload=$res17['claim_payload'];
		$invoice_payload=$res17['invoice_payload'];
		$claim_id=$res17['claim_id'];
		$invoice_upload_payload=$res17['invoice_upload_payload'];
		
		
		 $query170 = "select eclaim_id,savannah_authid,patientfirstname,patientlastname from master_visitentry where visitcode='$visitcode' and offpatient=0";
		$exec170 = mysqli_query($GLOBALS["___mysqli_ston"], $query170) or die ("Error in Query170".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num128=mysqli_num_rows($exec170);
		if($num128>0){
		$res170 = mysqli_fetch_array($exec170);
		//$eclaim_id=$res170['eclaim_id'];
		$savannah_authid=$res170['savannah_authid'];
		$patientfirstname=$res170['patientfirstname'];
		$patientlastname=$res170['patientlastname'];
		
		$query1701 = "select invoice_url from master_slade";
		$exec1701 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1701 = mysqli_fetch_array($exec170);
		$invoice_attach_url=$res1701['invoice_url'];
	
	  if($num232<=0 || $claim_payload=='' || $invoice_payload=='' || $invoice_upload_payload=='')
	  {
			
		
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				
				$colorcode = 'bgcolor="#ecf0f5"';
			}
			$sno=$sno + 1;
			?>
          <tr <?php echo $colorcode; ?> id="row-<?php echo $sno ; ?>">
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno ; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $billnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $eclaim_val; ?></div></td>
                 <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $locationname_bp; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="center">
			      <?php echo $accountname; ?>			      </div></td>
                  
              <?php
			  if($num232<=0 && $eclaim_id=='2')
			  {?>
                           
               <td class="bodytext31" valign="center"  align="left">
<a href="slade_auth_repost.php?visitcode=<?php echo $visitcode; ?>&&patientcode=<?php echo $patientcode; ?>&&type='op'&&billautonumber=<?php echo $billnumber; ?>&&auth_token=<?php echo $savannah_authid; ?>&&amount=<?php echo $totalamount; ?>&&first_name=<?php echo $patientfirstname; ?>&&last_name=<?php echo $patientlastname; ?>"  onClick="return FuncPopup()">Re-post to Slade</a></td>  


              <?php } else if ($num232<=0 && $eclaim_id=='3') { ?>
            <td class="bodytext31" valign="center"  align="left">
<a href="slade-claim.php?visitcode=<?php echo $visitcode; ?>&&patientcode=<?php echo $patientcode; ?>&&type='op'&&frmtype='op'&&billno=<?php echo $billnumber; ?>"   onClick="return FuncPopup()">Re-post to Slade</a></td>  
              
              <?php } else if ($claim_payload=='') { ?>
            <td class="bodytext31" valign="center"  align="left">
<a href="slade-claim.php?visitcode=<?php echo $visitcode; ?>&&patientcode=<?php echo $patientcode; ?>&&type='op'&&frmtype='op'&&billno=<?php echo $billnumber; ?>"   onClick="return FuncPopup()">Re-post to Slade</a></td>  
              
              <?php } else if ($invoice_payload=='') {?>
              
                <td class="bodytext31" valign="center"  align="left">
<a href="slade-invoicepost.php?visitcode=<?php echo $visitcode; ?>&&patientcode=<?php echo $patientcode; ?>&&claim=<?php echo $claim_id; ?>&&billno=<?php echo $billnumber; ?>"  onClick="return FuncPopup()">Re-post to Slade</a></td> 

              
              <?php } else if ($invoice_upload_payload=='') {?>
               <td class="bodytext31" valign="center"  align="left">
<a href="slade-invoicepostpdf.php?visitcode=<?php echo $visitcode; ?>&&patientcode=<?php echo $patientcode; ?>&&claim=<?php echo $claim_id; ?>&&billautonumber=<?php echo $billnumber; ?>&&auth=<?php echo $savannah_authid; ?>&&invoice_url=<?php echo $invoice_attach_url; ?>"  onClick="return FuncPopup()">Re-post to Slade</a></td> 

<?php } ?>

              </tr>
		   <?php 
	  } }
	  
	   $query170 = "select eclaim_id,savannah_authid,patientfirstname,patientlastname,offpatient from master_visitentry where visitcode='$visitcode' and offpatient=1";
		$exec170 = mysqli_query($GLOBALS["___mysqli_ston"], $query170) or die ("Error in Query170".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num128=mysqli_num_rows($exec170);
		if($num128>0){
		$res170 = mysqli_fetch_array($exec170);
		$offpatient=$res170['offpatient'];
		if($offpatient=='1')
		{
			$offpatient='offslade';
		}
		else
		{
			$offpatient='';
		}
		$savannah_authid=$res170['savannah_authid'];
		$patientfirstname=$res170['patientfirstname'];
		$patientlastname=$res170['patientlastname'];
		
		$query1701 = "select invoice_url from master_slade";
		$exec1701 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1701 = mysqli_fetch_array($exec170);
		$invoice_attach_url=$res1701['invoice_url'];
	
	  if($num232<=0 || $claim_payload=='' || $invoice_payload=='' || $invoice_upload_payload=='')
	  {
			
		
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				
				$colorcode = 'bgcolor="#ecf0f5"';
			}
			$sno=$sno + 1;
			?>
          <tr <?php echo $colorcode; ?> id="row-<?php echo $sno ; ?>">
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno ; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $billnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $eclaim_val; ?></div></td>
                 <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $locationname_bp; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="center">
			      <?php echo $accountname; ?>			      </div></td>
                  
              <?php
			  if($num232<=0 && $eclaim_id=='')
			  {?>
                           
               <td class="bodytext31" valign="center"  align="left">
<a href="slade-claim.php?visitcode=<?php echo $visitcode; ?>&&patientcode=<?php echo $patientcode; ?>&&type='op'&&frmtype='op'&&source_from=<?php echo $offpatient; ?>&&billno=<?php echo $billnumber; ?>" onClick="return FuncPopup()">Re-post to Slade</a></td> 
              <?php } else if ($num232<=0 && $eclaim_id=='3') { ?>
            <td class="bodytext31" valign="center"  align="left">
<a href="slade-claim.php?visitcode=<?php echo $visitcode; ?>&&patientcode=<?php echo $patientcode; ?>&&type='op'&&frmtype='op'&&source_from=<?php echo $offpatient; ?>&&billno=<?php echo $billnumber; ?>" onClick="return FuncPopup()">Re-post to Slade</a></td>  
              
              <?php } else if ($claim_payload=='') { ?>
            <td class="bodytext31" valign="center"  align="left">
<a href="slade-claim.php?visitcode=<?php echo $visitcode; ?>&&patientcode=<?php echo $patientcode; ?>&&type='op'&&frmtype='op'&&source_from=<?php echo $offpatient; ?>&&billno=<?php echo $billnumber; ?>" onClick="return FuncPopup()">Re-post to Slade</a></td>
    <?php } else if ($invoice_payload=='') {?>
              
                <td class="bodytext31" valign="center"  align="left">
<a href="slade-invoicepost.php?visitcode=<?php echo $visitcode; ?>&&patientcode=<?php echo $patientcode; ?>&&claim=<?php echo $claim_id; ?>&&billno=<?php echo $billnumber; ?>" onClick="return FuncPopup()">Re-post to Slade</a></td> 

              
              <?php } else if ($invoice_upload_payload=='') {?>
               <td class="bodytext31" valign="center"  align="left">
<a href="slade-invoicepostpdf.php?visitcode=<?php echo $visitcode; ?>&&patientcode=<?php echo $patientcode; ?>&&claim=<?php echo $claim_id; ?>&&billautonumber=<?php echo $billnumber; ?>&&auth=<?php echo $savannah_authid; ?>&&invoice_url=<?php echo $invoice_attach_url; ?>" onClick="return FuncPopup()">Re-post to Slade</a></td> 

<?php } ?>

              </tr>
		   <?php 
	  }
		}
		  
		  }
		
		   ?>
           
           
             <?php
            
		$eclaim_val='';
		$slade_it='';
		  $query12 = "select a.patientname,a.patientcode,a.visitcode,a.billdate,a.accountname,a.billno,a.slade_claim_id,a.totalamountuhx as fxamount,a.locationname,b.eclaim_id,b.offpatient  from billing_ip as a JOIN
		 master_ipvisitentry as b on (a.visitcode=b.visitcode)
		  where (b.eclaim_id='2' or b.eclaim_id='3' or b.offpatient='1') and a.locationcode='$res1locationanum' and a.patientcode like '%$searchpatientcode%' and a.visitcode like '%$searchvisitcode%' and a.patientname like '%$searchpatient%' and a.billdate between '$fromdate' and '$todate' and a.billno like '%$billnumber2%'";
		$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num122=mysqli_num_rows($exec12);
		if($num12>0){
		?>
		<tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5" colspan='9'><div align="left"><strong>IP</strong></div></td>
				 
              </tr>
		
		<?php
		}
		while($res12 = mysqli_fetch_array($exec12))
		{
		$patientname=$res12['patientname'];
		$patientcode=$res12['patientcode'];
		 $visitcode=$res12['visitcode'];
		$consultationdate=$res12['billdate'];
		$accountname=$res12['accountname'];	
	    $billnumber=$res12['billno'];
		$slade_claim_id=$res12['slade_claim_id'];
		$amount=$res12['fxamount'];
		$totalamount=$amount;
		$locationname_bp=$res12['locationname'];
		$eclaim_id=$res12['eclaim_id'];
		$offpatient=$res12['offpatient'];
		if($eclaim_id=='2')
		{
			$eclaim_val='Slade';
		}
		else if($eclaim_id=='3')
		{
			$eclaim_val='Smart+Slade';
			$slade_it='yes';
		}
		
		 
		 
		 
		$query17 = "select * from slade_claim where visitcode='$visitcode' group by visitcode";
		$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num232 = mysqli_num_rows($exec17);
		$res17 = mysqli_fetch_array($exec17);
		$claim_payload=$res17['claim_payload'];
		$invoice_payload=$res17['invoice_payload'];
		$claim_id=$res17['claim_id'];
		$invoice_upload_payload=$res17['invoice_upload_payload'];
		
		
		 $query170 = "select eclaim_id,savannah_authid,patientfirstname,patientlastname from master_ipvisitentry where visitcode='$visitcode'";
		$exec170 = mysqli_query($GLOBALS["___mysqli_ston"], $query170) or die ("Error in Query170".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res170 = mysqli_fetch_array($exec170);
		//$eclaim_id=$res170['eclaim_id'];
		$savannah_authid=$res170['savannah_authid'];
		$patientfirstname=$res170['patientfirstname'];
		$patientlastname=$res170['patientlastname'];
		
		$query1701 = "select invoice_url from master_slade";
		$exec1701 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1701 = mysqli_fetch_array($exec170);
		$invoice_attach_url=$res1701['invoice_url'];
	
	  if($num232<=0 || $claim_payload=='' || $invoice_payload=='' || $invoice_upload_payload=='')
	  {
			
		
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				
				$colorcode = 'bgcolor="#ecf0f5"';
			}
			$sno=$sno + 1;
			?>
          <tr <?php echo $colorcode; ?> id="row-<?php echo $sno ; ?>">
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno ; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $billnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $eclaim_val; ?></div></td>
                 <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $locationname_bp; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="center">
			      <?php echo $accountname; ?>			      </div></td>
                  
              <?php
			  if($num232<=0 && $eclaim_id=='2' && $offpatient=='0')
			  {?>
                           
                                    
               <td class="bodytext31" valign="center"  align="left">
<a href="slade_auth_repost.php?visitcode=<?php echo $visitcode; ?>&&patientcode=<?php echo $patientcode; ?>&&type=ip&&billautonumber=<?php echo $billnumber; ?>&&auth_token=<?php echo $savannah_authid; ?>&&amount=<?php echo $totalamount; ?>&&first_name=<?php echo $patientfirstname; ?>&&last_name=<?php echo $patientlastname; ?>" onClick="return FuncPopup()">Re-post to Slade</a></td>  


              <?php } else if ($num232<=0 && $eclaim_id=='2' && $offpatient=='1') { ?>
            <td class="bodytext31" valign="center"  align="left">
<a href="slade-claim.php?visitcode=<?php echo $visitcode; ?>&&patientcode=<?php echo $patientcode; ?>&&type=ip&&frmtype=ip&&billno=<?php echo $billnumber; ?>&&slade=yes" onClick="return FuncPopup()">Re-post to Slade</a></td>  
              
              <?php } else if ($num232<=0 && $eclaim_id=='0' && $offpatient=='1') { ?>
            <td class="bodytext31" valign="center"  align="left">
<a href="slade-claim.php?visitcode=<?php echo $visitcode; ?>&&patientcode=<?php echo $patientcode; ?>&&type=ip&&frmtype=ip&&billno=<?php echo $billnumber; ?>&&slade=yes" onClick="return FuncPopup()">Re-post to Slade</a></td>  
              
              <?php } else if ($num232<=0 && $eclaim_id=='3') { ?>
            <td class="bodytext31" valign="center"  align="left">
<a href="slade-claim.php?visitcode=<?php echo $visitcode; ?>&&patientcode=<?php echo $patientcode; ?>&&type=ip&&frmtype=ip&&billno=<?php echo $billnumber; ?>&&slade=yes" onClick="return FuncPopup()">Re-post to Slade</a></td>  
              
              <?php } else if ($claim_payload=='') { ?>
            <td class="bodytext31" valign="center"  align="left">
<a href="slade-claim.php?visitcode=<?php echo $visitcode; ?>&&patientcode=<?php echo $patientcode; ?>&&type=ip&&frmtype=ip&&billno=<?php echo $billnumber; ?>&&slade=$slade_it" onClick="return FuncPopup()">Re-post to Slade</a></td>  
              
              <?php } else if ($invoice_payload=='') {?>
              
                <td class="bodytext31" valign="center"  align="left">
<a href="slade-invoiceippost.php?visitcode=<?php echo $visitcode; ?>&&patientcode=<?php echo $patientcode; ?>&&claim=<?php echo $claim_id; ?>&&billno=<?php echo $billnumber; ?>" onClick="return FuncPopup()">Re-post to Slade</a></td> 

              
              <?php } else if ($invoice_upload_payload=='') {?>
               <td class="bodytext31" valign="center"  align="left">
<a href="slade-invoicepostippdf.php?visitcode=<?php echo $visitcode; ?>&&patientcode=<?php echo $patientcode; ?>&&claim=<?php echo $claim_id; ?>&&billautonumber=<?php echo $billnumber; ?>&&auth=<?php echo $savannah_authid; ?>&&invoice_url=<?php echo $invoice_attach_url; ?>" onClick="return FuncPopup()">Re-post to Slade</a></td> 

<?php } ?>

              </tr>
		   <?php 
	  }
		  
		  }
		
		   ?>
           
           
           <?php
            
		$eclaim_val='';
		   $query12 = "select a.patientname,a.patientcode,a.visitcode,a.billdate,a.accountname,a.billno,a.slade_claim_id,a.fxamount,a.locationname,b.eclaim_id,b.offpatient  from billing_ipcreditapproved as a JOIN
		 master_ipvisitentry as b on (a.visitcode=b.visitcode)
		  where (b.eclaim_id='2' or b.eclaim_id='3' or b.offpatient='1')  and a.locationcode='$res1locationanum' and a.patientcode like '%$searchpatientcode%' and a.visitcode like '%$searchvisitcode%' and a.patientname like '%$searchpatient%' and a.billdate between '$fromdate' and '$todate' and a.billno like '%$billnumber2%' ";
		$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num12=mysqli_num_rows($exec12);
		if($num12<=0 && $num12>0){
		?>
		<tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5" colspan='9'><div align="left"><strong>IP</strong></div></td>
				 
              </tr>
		
		<?php
		}
		while($res12 = mysqli_fetch_array($exec12))
		{
		$patientname=$res12['patientname'];
		$patientcode=$res12['patientcode'];
		 $visitcode=$res12['visitcode'];
		$consultationdate=$res12['billdate'];
		$accountname=$res12['accountname'];	
	    $billnumber=$res12['billno'];
		$slade_claim_id=$res12['slade_claim_id'];
		$amount=$res12['fxamount'];
		$totalamount=$amount;
		$locationname_bp=$res12['locationname'];
		$eclaim_id=$res12['eclaim_id'];
		$offpatient=$res12['offpatient'];
		if($eclaim_id=='2')
		{
			$eclaim_val='Slade';
		}
		else if($eclaim_id=='3')
		{
			$eclaim_val='Smart+Slade';
		}
		
		 
		 
		 
		$query17 = "select * from slade_claim where visitcode='$visitcode' group by visitcode";
		$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num232 = mysqli_num_rows($exec17);
		$res17 = mysqli_fetch_array($exec17);
		$claim_payload=$res17['claim_payload'];
		$invoice_payload=$res17['invoice_payload'];
		$claim_id=$res17['claim_id'];
		$invoice_upload_payload=$res17['invoice_upload_payload'];
		
		
		 $query170 = "select eclaim_id,savannah_authid,patientfirstname,patientlastname from master_ipvisitentry where visitcode='$visitcode'";
		$exec170 = mysqli_query($GLOBALS["___mysqli_ston"], $query170) or die ("Error in Query170".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res170 = mysqli_fetch_array($exec170);
		//$eclaim_id=$res170['eclaim_id'];
		$savannah_authid=$res170['savannah_authid'];
		$patientfirstname=$res170['patientfirstname'];
		$patientlastname=$res170['patientlastname'];
		
		$query1701 = "select invoice_url from master_slade";
		$exec1701 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1701 = mysqli_fetch_array($exec170);
		$invoice_attach_url=$res1701['invoice_url'];
	
	  if($num232<=0 || $claim_payload=='' || $invoice_payload=='' || $invoice_upload_payload=='')
	  {
			
		
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				
				$colorcode = 'bgcolor="#ecf0f5"';
			}
			$sno=$sno + 1;
			?>
          <tr <?php echo $colorcode; ?> id="row-<?php echo $sno ; ?>">
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno ; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $billnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $eclaim_val; ?></div></td>
                 <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $locationname_bp; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="center">
			      <?php echo $accountname; ?>			      </div></td>
                  
              <?php
			  if($num232<=0 && $eclaim_id=='2' && $offpatient=='0')
			  {?>
                           
               <td class="bodytext31" valign="center"  align="left">
<a href="slade_auth_repost.php?visitcode=<?php echo $visitcode; ?>&&patientcode=<?php echo $patientcode; ?>&&type=ip&&billautonumber=<?php echo $billnumber; ?>&&auth_token=<?php echo $savannah_authid; ?>&&amount=<?php echo $totalamount; ?>&&first_name=<?php echo $patientfirstname; ?>&&last_name=<?php echo $patientlastname; ?>&&split_status=yes" onClick="return FuncPopup()">Re-post to Slade</a></td>  


              <?php } else if ($num232<=0 && $eclaim_id=='2' && $offpatient=='1') { ?>
          <td class="bodytext31" valign="center"  align="left">
<a href="slade-claim.php?visitcode=<?php echo $visitcode; ?>&&patientcode=<?php echo $patientcode; ?>&&type=ip&&frmtype=ip&&billno=<?php echo $billnumber; ?>&&split_status=yes" onClick="return FuncPopup()">Re-post to Slade</a></td>  
              
              <?php } else if ($num232<=0 && $eclaim_id=='0'  && $offpatient=='1') { ?>
          <td class="bodytext31" valign="center"  align="left">
<a href="slade-claim.php?visitcode=<?php echo $visitcode; ?>&&patientcode=<?php echo $patientcode; ?>&&type=ip&&frmtype=ip&&billno=<?php echo $billnumber; ?>&&split_status=yes" onClick="return FuncPopup()">Re-post to Slade</a></td>  
              
              <?php } else if ($num232<=0 && $eclaim_id=='3') { ?>
            <td class="bodytext31" valign="center"  align="left">
<a href="slade-claim.php?visitcode=<?php echo $visitcode; ?>&&patientcode=<?php echo $patientcode; ?>&&type=ip&&frmtype=ip&&billno=<?php echo $billnumber; ?>&&split_status=yes" onClick="return FuncPopup()">Re-post to Slade</a></td>  
              
              <?php } else if ($claim_payload=='') { ?>
            <td class="bodytext31" valign="center"  align="left">
<a href="slade-claim.php?visitcode=<?php echo $visitcode; ?>&&patientcode=<?php echo $patientcode; ?>&&type=ip&&frmtype=ip&&billno=<?php echo $billnumber; ?>&&split_status=yes" onClick="return FuncPopup()">Re-post to Slade</a></td>  
              
              <?php } else if ($invoice_payload=='') {?>
              
                <td class="bodytext31" valign="center"  align="left">
<a href="slade-invoiceippost_split.php?visitcode=<?php echo $visitcode; ?>&&patientcode=<?php echo $patientcode; ?>&&claim=<?php echo $claim_id; ?>&&billno=<?php echo $billnumber; ?>&&split_status=yes" onClick="return FuncPopup()">Re-post to Slade</a></td> 

              
              <?php } else if ($invoice_upload_payload=='') {?>
               <td class="bodytext31" valign="center"  align="left">
<a href="slade-invoicepostippdf_split.php?visitcode=<?php echo $visitcode; ?>&&patientcode=<?php echo $patientcode; ?>&&claim=<?php echo $claim_id; ?>&&billautonumber=<?php echo $billnumber; ?>&&auth=<?php echo $savannah_authid; ?>&&invoice_url=<?php echo $invoice_attach_url; ?>&&split_status=yes" onClick="return FuncPopup()">Re-post to Slade</a></td> 

<?php } ?>

              </tr>
		   <?php 
	  }
		  
		  }
		
		   ?>

		  
		
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
	  
	  </form>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

