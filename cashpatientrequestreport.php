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

$errmsg = "";
$snocount = "";
$colorloopcount="";
$searchsuppliername = "";
//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_patientstatus.php");
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = date('Y-m-d'); }
if (isset($_REQUEST["searchsuppliername"])) {$searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchsuppliercode"])) {$searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }
if (isset($_REQUEST["searchvisitcode"])) {$searchvisitcode = $_REQUEST["searchvisitcode"]; } else { $searchvisitcode = ""; }
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

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

.ui-menu .ui-menu-item{ zoom:1 !important; }
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/datetimepicker_css.js"></script>
<!--<script type="text/javascript" src="js/autocomplete_patientstatus.js"></script>
<script type="text/javascript" src="js/autosuggestpatientstatus1.js"></script>-->

<link href="autocomplete.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>


<script type="text/javascript">
$(function() {
	//AUTO COMPLETE SEARCH FOR SUPPLIER NAME
$('#searchsuppliername').autocomplete({
		
	source:'ajaxpatientnewserach.php', 
	//alert(source);
	minLength:1,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var supplier = this.id;
			var code = ui.item.id;
			var visitcode = ui.item.visit_id;
			var suppliername = supplier.split('suppliername');
			var suppliercode = suppliername[1];
			
			$('#searchsuppliercode').val(code);
			$('#searchvisitcode').val(visitcode);
			
			},
    });
});
</script>   

<script type="text/javascript">
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


/*window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
}*/
</script>


<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />     
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 12px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
</head>

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
        <td width="860">
		
		
              <form name="cbform1" method="post" action="cashpatientrequestreport.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Patient Status Report</strong></td>
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
				
                <tr bgcolor="#011E6A">
                
               
                 <td colspan="8" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Search Sequence : First Name | Middle Name | Last Name | Date of Birth | Location | Mobile Number | ID/Digitika Card | Registration No   (*Use "|" symbol to skip sequence)</strong>
             
            
              </td></tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Patient</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
			  <input name="searchsuppliercode" id="searchsuppliercode" value="" type="hidden">
			  <input name="searchvisitcode" id="searchvisitcode" value="" type="hidden">
			  <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
			  
              </span></td>
           </tr>
		   
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $ADate1; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp; </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF">&nbsp;</td>
                    </tr>	
						<tr>
  			  <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
			 
				 <select name="location" id="location" onChange="ajaxlocationfunction(this.value);">
                    <?php
						
						$query1 = "select * from login_locationdetails where   username='$username' and docno='$docno' order by locationname";
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
			  <input type="submit" value="Search" name="Submit" />
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="682" 
            align="left" border="0">
          <tbody>
            
    		<?php
			 
			 if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					
					$sno =0;
					$colorloopcount = '';
					$totalamount=0;
					$total_consult=0;
					$total_presc=0;
					$total_lab=0;
					$total_rad=0;
					$total_serv=0;
					$total_dpref=0;
					$total_ref=0;
		$qry_visitentry = "select * from master_visitentry where locationcode='$locationcode1' and patientfullname = '$searchsuppliername' and consultationdate = '$ADate1' and paymenttype = 1 order by auto_number desc ";
		  $exec_visitentry = mysqli_query($GLOBALS["___mysqli_ston"], $qry_visitentry) or die ("Error in qry_visitentry".mysqli_error($GLOBALS["___mysqli_ston"]));
		  if ($res_visitentry = mysqli_fetch_array($exec_visitentry))
		  {
		  $visitcode=$res_visitentry['visitcode'];
		  $patientcode = $res_visitentry['patientcode'];
			$consultationdate=$res_visitentry['consultationdate'];
			$consultingdoctor = $res_visitentry['consultingdoctor'];
			$consultationfee=$res_visitentry['consultationfees'];
			$conpaymentstatus=$res_visitentry['paymentstatus'];
			$consultationfee = number_format($consultationfee,2,'.','');
			$totalamount = $consultationfee;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$total_consult=$consultationfee;
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
		  <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="55%" 
            align="left" border="0">
          <tbody id="foo">
           <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32"><strong>Transaction Details</strong></td>
                
			 </tr>
          
            <tr>
              <td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ref.No</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Description</strong></div></td>
                <td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Qty</strong></div></td>
				<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rate  </strong></div></td>
					<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount </strong></div></td>
				<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Payment Status</strong></div></td>
			   </tr>
			
				  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $visitcode; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $consultingdoctor; ?></div></td>
			     <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($consultationfee,2); ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($consultationfee,2); ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php if($conpaymentstatus!=''){echo ucwords($conpaymentstatus);} else {echo "Pending";}?></div></td>
				</tr>
			
			<?php
			$query28 = "select * from master_consultationpharm where   patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec28 = mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res28 = mysqli_fetch_array($exec28))
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
			?>
			<tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res28['recorddate']; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res28['refno']; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $res28['medicinename']; ?></div></td>
			     <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res28['quantity']; ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($res28['rate'],2); ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($res28['amount'],2); $totalamount += $res28['amount'];$total_presc += $res28['amount'];?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo ucwords($res28['paymentstatus']);?></div></td>
				</tr>
			<?php
			}
			
			?>
			<?php
			$query29 = "select * from consultation_lab where   patientvisitcode='$visitcode' and patientcode='$patientcode' and refundapproval <> 'approved'";
			$exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res29 = mysqli_fetch_array($exec29))
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
			?>
			<tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res29['consultationdate']; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res29['refno']; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $res29['labitemname']; ?></div></td>
			     <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($res29['labitemrate'],2); ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($res29['labitemrate'],2); $totalamount += $res29['labitemrate'];$total_lab += $res29['labitemrate'];?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php if($res29['labrefund']!='refund'){echo ucwords($res29['paymentstatus']);}else{echo "Refund Initiated";}?></div></td>
				</tr>
			<?php
			}
			
			?>
			<?php
			$query30 = "select * from consultation_radiology where   patientvisitcode='$visitcode' and patientcode='$patientcode' and refundapprove <> 'approved'";
			$exec30 = mysqli_query($GLOBALS["___mysqli_ston"], $query30) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res30 = mysqli_fetch_array($exec30))
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
			?>
			<tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res30['consultationdate']; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res30['refno']; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $res30['radiologyitemname']; ?></div></td>
			     <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($res30['radiologyitemrate'],2); ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($res30['radiologyitemrate'],2); $totalamount += $res30['radiologyitemrate'];$total_rad += $res30['radiologyitemrate'];?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo ucwords($res30['paymentstatus']);?></div></td>
				</tr>
			<?php
			}
			
			?>
			<?php
			$query31 = "select * from consultation_services where   patientvisitcode='$visitcode' and patientcode='$patientcode' and refundapprove <> 'approved'";
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res31 = mysqli_fetch_array($exec31))
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
			?>
			<tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res31['consultationdate']; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res31['refno']; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $res31['servicesitemname']; ?></div></td>
			     <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res31['serviceqty']; ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($res31['servicesitemrate'],2); ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($res31['amount'],2); $totalamount += $res31['amount'];$total_serv += $res31['amount'];?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo ucwords($res31['paymentstatus']);?></div></td>
				</tr>
			<?php
			}
			
			?>
			<?php
			$query32 = "select * from consultation_referal where   patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res32 = mysqli_fetch_array($exec32))
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
			?>
			<tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res32['consultationdate']; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res32['refno']; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $res32['referalname']; ?></div></td>
			     <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($res32['referalrate'],2); ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($res32['referalrate'],2); $totalamount += $res32['referalrate'];$total_ref += $res32['referalrate'];?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo ucwords($res32['paymentstatus']);?></div></td>
				</tr>
			<?php
			}
			
			?>
			<?php
			$query33 = "select * from consultation_departmentreferal where   patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res33 = mysqli_fetch_array($exec33))
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
			?>
			<tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res33['consultationdate']; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res33['refno']; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left">Referral Fee - <?php echo $res33['referalname']; ?></div></td>
			     <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($res33['referalrate'],2); ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($res33['referalrate'],2); $totalamount += $res33['referalrate'];$total_dpref += $res33['referalrate'];?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo ucwords($res33['paymentstatus']);?></div></td>
				</tr>
			<?php
			}
			
			?>
			
			
			
				<tr>
              <td class="bodytext31" valign="center" align="left" bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center" align="left" bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center" align="left" bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center" align="left" bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center" align="left" bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong>Total</strong></td>
             <td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount,2,'.',','); ?>	            
				</strong></td>
                <td class="bodytext31" valign="center" align="left" bgcolor="#ecf0f5">&nbsp;</td>      
			 </tr>
			 
      <tr>
        <td></td>
      <tr>
			 </tbody>
			 </table>
			 <?php
			 $query_pw = "select `docno`, `entrydate`, `consult_discamount`, `pharmacy_discamount`, `lab_discamount`, `radiology_discamount`, `services_discamount` from patientweivers where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec_pw = mysqli_query($GLOBALS["___mysqli_ston"], $query_pw) or die ("Error in Query_pw".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res_pw = mysqli_fetch_array($exec_pw);
			$consult_discamount = $res_pw['consult_discamount'];
			$pharmacy_discamount = $res_pw['pharmacy_discamount'];
			$lab_discamount = $res_pw['lab_discamount'];
			$radiology_discamount = $res_pw['radiology_discamount'];
			$services_discamount = $res_pw['services_discamount'];
			$pw_docno = $res_pw['docno'];
			$pw_entrydate = $res_pw['entrydate'];
			 
			 ?>
			 <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="55%" 
            align="left" border="0">
            <tbody id="foo">
              <tr bgcolor="#011E6A">
                <td colspan="7" bgcolor="#ecf0f5" class="bodytext32"><strong>Summarized Details</strong></td>
              </tr>
              <tr>
                <td width="33%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
                <td width="21%" class="bodytext31" valign="center" align="left" 
                bgcolor="#CBDBFA"><div align="left">Total for Consultation</div></td>
                <td width="25%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="right"><?php echo number_format($total_consult,2,'.',','); ?></div>
                  </td>
                <td width="21%" class="bodytext31" valign="center"  align="right" 
                bgcolor="#CBDBFA"><div align="right"><?php echo number_format($total_consult,2,'.',','); ?></div></td>
              </tr>
              <tr>
                <td width="33%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
                <td width="21%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left">Total for Pharmacy </div></td>
                <td width="25%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><?php echo number_format($total_presc,2,'.',','); ?></div></td>
                <td width="21%" class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><div align="right"><?php echo number_format($total_presc,2,'.',','); ?></div></td>
              </tr>
              <tr>
                <td width="33%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
                <td width="21%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="left">Total for Laboratory</div></td>
                <td width="25%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="right"><?php echo number_format($total_lab,2,'.',','); ?></div></td>
                <td width="21%" class="bodytext31" valign="center"  align="right" 
                bgcolor="#CBDBFA"><div align="right"><?php echo number_format($total_lab,2,'.',',');?></div></td>
              </tr>
              <tr>
                <td width="33%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
                <td width="21%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left">Total for Radiology </div></td>
                <td width="25%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><?php echo number_format($total_rad,2,'.',','); ?></div></td>
                <td width="21%" class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><div align="right"><?php echo number_format($total_rad,2,'.',',');?></div></td>
              </tr>
              <tr>
                <td width="33%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
                <td width="21%"  align="left" valign="center" 

                bgcolor="#CBDBFA" class="bodytext31"><div align="left">Total for Service </div></td>
                <td width="25%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="right"><?php echo number_format($total_serv,2,'.',','); ?></div></td>
                <td width="21%" class="bodytext31" valign="center"  align="right" 
                bgcolor="#CBDBFA"><div align="right"><?php echo number_format($total_serv,2,'.',',');?></div></td>
              </tr>
              <tr>
                <td width="33%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
                <td width="21%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left">Total for Referral </div></td>
                <td width="25%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><?php echo number_format($total_ref,2,'.',','); ?></div></td>
                <td width="21%" class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><div align="right"><?php echo number_format($total_ref,2,'.',',');?></div></td>
              </tr>
              <tr>
                <td width="33%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="center"><strong>&nbsp;</strong></div></td>
                <td width="21%"  align="left" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Net Amount </strong></div></td>
                <td width="25%"  align="left" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong><?php echo  number_format($totalamount,2,'.',','); ?></strong></div></td>
                <td width="21%" class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totalamount,2,'.',',');?></strong></div></td>
              </tr>
            </tbody>
        </table>
				  <?php
		  }
		  else{
		   ?>

   	        <tr bgcolor="#FFFFFF">
               <td colspan="3"  align="left" valign="center" class="bodytext31"><strong><?php echo $searchsuppliername; ?>,<?php echo $searchsuppliercode; ?></strong>. Cash Visit Not Created for the Patient</td>
               </tr>

		<?php
		   }
          } //close if ($cbfrmflag1 == 'cbfrmflag1')
          ?>
          </tbody>
        </table></td>
      </tr>
	  
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
