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
		
		
              <form name="cbform1" method="post" action="patientstatusreport.php">
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
					
					
		
		$qry_visitentry = "select patientfullname,patientcode,visitcode,billtype,departmentname,paymentstatus,department,accountfullname from master_visitentry where locationcode='$locationcode1' and patientfullname = '$searchsuppliername' and consultationdate = '$ADate1' order by auto_number desc ";
		  $exec_visitentry = mysqli_query($GLOBALS["___mysqli_ston"], $qry_visitentry) or die ("Error in qry_visitentry".mysqli_error($GLOBALS["___mysqli_ston"]));
		  if ($res_visitentry = mysqli_fetch_array($exec_visitentry))
		  {
     	  $patientfullname = $res_visitentry['patientfullname'];
		  $patientcode = $res_visitentry['patientcode'];
		  $visitcode = $res_visitentry['visitcode'];
		  $billtype = $res_visitentry['billtype'];
		  $departmentname = $res_visitentry['departmentname'];
		  $patient_paymentstatus = $res_visitentry['paymentstatus'];
		  $departmentcode = $res_visitentry['department'];
		  $accountname = $res_visitentry['accountfullname'];
		 
		  		  
		    $snocount = $snocount + 1;
			
			//echo $cashamount;
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
	        <tr bgcolor="#FFFFFF">
               <td colspan="1"  align="left" valign="center" class="bodytext31"><strong><?php echo $patientfullname; ?>,<?php echo $patientcode; ?>,<?php echo $visitcode; ?></strong></td>
			   <td> <strong> <a href="patientstatus_billingview.php?visitcode=<?php echo $visitcode; ?>" target="_blank" align="right" valign="right">Billing Details</a> </strong></td>
               </tr>
	        <tr bgcolor="#999999">
	          <td colspan="2"  align="left" valign="center" class="bodytext31"><strong>Description </strong></td>
			  
	        </tr>
           <!-- <tr <?php echo $colorcode; ?>>
            	<td>-->
                	<!--Patient Visit Created in--> <?php //echo $departmentname; ?> 
                    <?php
					$visit_entry_status = "pending";
			
					 if($patient_paymentstatus == "completed")
					 {
						 $visit_entry_status ="completed";
						 //echo "and Consultation Billing Completed. <b>Pending for Triage Process</b>";
					 }
					?>
                <!--</td>
            </tr>-->
   		   <?php
		   if($departmentcode == "50")
		   {
			?> 
               <tr bgcolor="#CBDBFA"><!--Visit Entry Status -- for Walkin Patient-->
            	<td colspan="2" >
                	<?php
					
					echo "Visit is Created in <b>".$departmentname.",".$accountname."</b>. ";
					?>
                </td>
            </tr>
            <tr bgcolor="#ecf0f5">
            	<td colspan="2" >
                	Patient Available on <strong>Self Request</strong>
                </td>
            </tr>
		<?php	   
		   }
		   else
		   {
		    //For Triage Status
			$triage_status ="";
			$qry_traigestatus = "SELECT patientfullname FROM master_triage WHERE patientcode='$patientcode' AND visitcode = '$visitcode' AND locationcode='$locationcode1' AND triagestatus ='completed'";
			$exec_traigestatus = mysqli_query($GLOBALS["___mysqli_ston"], $qry_traigestatus) or die ("Error in qry_traigestatus".mysqli_error($GLOBALS["___mysqli_ston"]));
			$triage_status_count = mysqli_num_rows($exec_traigestatus);
			if($triage_status_count>0)
			{
				$triage_status = "completed";
			?>
            <!--<tr <?php echo $colorcode; ?>>
            	<td>
                	Patient Triage Status is Completed. Waiting for <strong>Consultation</strong>
                </td>
            </tr>-->
		<?php
			}
			else
			{
				$triage_status = "pending";
			}
		   ?>
        <?php
		  //For Consultation Process
		  $consultation_status = "";
		  $consult_ipadmit_status = "";
		  
		  $qry_consultation = "SELECT patientcode FROM master_consultation WHERE locationcode='$locationcode1' AND  patientcode='$patientcode' AND  patientvisitcode = '$visitcode' AND recordstatus='completed'";
		  $exec_consultation = mysqli_query($GLOBALS["___mysqli_ston"], $qry_consultation) or die ("Error in qry_consultation".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $consultation_count = mysqli_num_rows($exec_consultation);
		  
		  if($consultation_count>0)
		  {
			  $consultation_status = "completed";
			  
			  $qry_ipadmit_triage = "SELECT ipconvert FROM master_triage WHERE patientcode='$patientcode' AND visitcode = '$visitcode' AND locationcode='$locationcode1' AND triagestatus ='completed'";
			  $exec_ipadmit_triage = mysqli_query($GLOBALS["___mysqli_ston"], $qry_ipadmit_triage) or die ("Error in qry_ipadmit_triage".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res_ipadmit_triage = mysqli_fetch_array($exec_ipadmit_triage);
			  $ipadmit_triage = $res_ipadmit_triage["ipconvert"];
			?>
            <!--<tr <?php echo $colorcode; ?>>
            	<td>-->
                	<?php
					  if($ipadmit_triage == "yes")
					  {
						  $consult_ipadmit_status = "ipadmit";
						 // echo "Patient Consulted as IP Admission and Lab, Radiology, Services, Pharmacy Process and Billing is Pending.";
					  }
					  else
					  {
						   $consult_ipadmit_status = "";
						 // echo "Patient Consultation Completed. Lab, Radiology, Services, Pharmacy Process and Billing is Pending.";
					  }
					?>
               <!-- </td>
            </tr>-->
         <?php     
		  }
		?> 
        <?php
		//For Lab,Radiology and Services Satus
		$lab_count_complete = 0;
		$lab_count_pending = 0;
		$rad_count_complete = 0;
		$rad_count_pending = 0;
		$serv_count_complete = 0;
		$serv_count_pending = 0;
		$pharma_count_complete = 0;
		$pharma_count_pending = 0;
		
		
		$lab_status = "";
		$radilogy_status = "";
		$service_status = "";
		$pharma_status = "";
		
		$lab_consult_count = "";
		$rad_consult_count = "";
		$serv_consult_count = "";
		$pharma_issue_count = "";


		//For Lab Consultation
		$lab_consultation = "SELECT consultationid,patientvisitcode FROM consultation_lab WHERE patientname='$patientfullname' AND patientcode='$patientcode' AND patientvisitcode='$visitcode' AND locationcode='$locationcode1' group by patientvisitcode";
		$exec_lab_consultation = mysqli_query($GLOBALS["___mysqli_ston"], $lab_consultation) or die ("Error in consultation_lab".mysqli_error($GLOBALS["___mysqli_ston"]));
		$lab_consult_count = mysqli_num_rows($exec_lab_consultation);
		if($lab_consult_count>0)
		{
			$res_lab_consult_id = mysqli_fetch_array($exec_lab_consultation);
			$lab_consult_id = $res_lab_consult_id["patientvisitcode"];
			
			$bank_ref_details = "SELECT patientvisitcode,paymentstatus FROM consultation_lab WHERE patientvisitcode='$lab_consult_id' AND patientcode='$patientcode' AND patientname='$patientfullname' AND patientvisitcode='$visitcode' AND locationcode='$locationcode1'";
			$exec_bankref_details = mysqli_query($GLOBALS["___mysqli_ston"], $bank_ref_details) or die ("Error in consultation_lab".mysqli_error($GLOBALS["___mysqli_ston"]));
			if($res_bankref_details = mysqli_fetch_array($exec_bankref_details)){
				$lab_paymentstatus = $res_bankref_details["paymentstatus"];
				
				if($lab_paymentstatus =='completed')
				{
					$lab_status = "completed";
				}
				else
				{
					$lab_status = "pending";
				}
			}else{
					$lab_status = "completed";
				
			}
			
		}

		
		//For Radiology Consultation
		$consultation_radiology = "SELECT patientvisitcode,paymentstatus FROM consultation_radiology WHERE patientname='$patientfullname' AND patientcode='$patientcode' AND patientvisitcode='$visitcode' AND locationcode='$locationcode1' group by patientvisitcode";
		$exec_rad_consultation = mysqli_query($GLOBALS["___mysqli_ston"], $consultation_radiology) or die ("Error in consultation_radiology".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rad_consult_count = mysqli_num_rows($exec_rad_consultation);
		if($rad_consult_count>0)
		{
			$res_rad_consult_id = mysqli_fetch_array($exec_rad_consultation);
			$rad_consult_id = $res_rad_consult_id["patientvisitcode"];
			
			$bank_ref_details = "SELECT patientvisitcode,paymentstatus FROM consultation_radiology WHERE patientvisitcode='$rad_consult_id' AND patientcode='$patientcode' AND patientname='$patientfullname' AND patientvisitcode='$visitcode' AND locationcode='$locationcode1'";
			$exec_bankref_details = mysqli_query($GLOBALS["___mysqli_ston"], $bank_ref_details) or die ("Error in consultation_radiology".mysqli_error($GLOBALS["___mysqli_ston"]));
			if($res_bankref_details = mysqli_fetch_array($exec_bankref_details)){
			$rad_paymentstatus = $res_bankref_details["paymentstatus"];
		  	
			if($rad_paymentstatus == 'completed')
			{
				$radilogy_status = "completed";
			}
			else
			{
				$radilogy_status = "pending";
			}
			}else{
			 	$radilogy_status = "completed";
			}
			
		}

		$lab_reult_status="pending";
		
		//For Lab Consultation
			$qry_med360_lab_req = "SELECT patientvisitcode,paymentstatus,labsamplecoll FROM consultation_lab WHERE patientcode='$patientcode' AND patientvisitcode='$visitcode' AND locationcode='$locationcode1' group by patientvisitcode";
			$exec_med360_lab_req = mysqli_query($GLOBALS["___mysqli_ston"], $qry_med360_lab_req) or die ("Error in consultation_lab".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res_med360_lab_req = mysqli_fetch_assoc($exec_med360_lab_req);
			$lab_consult_count = $res_med360_lab_req["patientvisitcode"];
			if($lab_consult_count > 0)
			{
				$lab_reult_status = "completed";
			}

		$rad_reult_status="pending";
	
		//For Radiology Consultation
		$consultation_radiology = "SELECT consultationid FROM consultation_radiology WHERE patientcode='$patientcode' AND patientvisitcode='$visitcode' AND locationcode='$locationcode1' AND resultentry <> 'pending' ";
		$exec_rad_consultation = mysqli_query($GLOBALS["___mysqli_ston"], $consultation_radiology) or die ("Error in consultation_radiology".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rad_consult_count = mysqli_num_rows($exec_rad_consultation);
		if($rad_consult_count>0)
		{
			$rad_reult_status = "completed";
		}
			
			//For Services Consultation
		$consultation_service = "SELECT patientvisitcode,paymentstatus FROM consultation_services WHERE patientcode='$patientcode' AND patientvisitcode='$visitcode' AND locationcode='$locationcode1' group by patientvisitcode";
		$exec_serv_consultation = mysqli_query($GLOBALS["___mysqli_ston"], $consultation_service) or die ("Error in consultation_service".mysqli_error($GLOBALS["___mysqli_ston"]));
		$serv_consult_count = mysqli_num_rows($exec_serv_consultation);
		if($serv_consult_count>0)
		{
			$res_serv_consult_id = mysqli_fetch_array($exec_serv_consultation);
			$serv_consult_id = $res_serv_consult_id["patientvisitcode"];
			
			$bank_ref_details = "SELECT patientvisitcode,paymentstatus FROM consultation_services WHERE patientvisitcode='$serv_consult_id' AND patientcode='$patientcode' AND patientvisitcode='$visitcode' AND locationcode='$locationcode1'";
			$exec_bankref_details = mysqli_query($GLOBALS["___mysqli_ston"], $bank_ref_details) or die ("Error in consultation_services".mysqli_error($GLOBALS["___mysqli_ston"]));
			if($res_bankref_details = mysqli_fetch_array($exec_bankref_details)){
			$serv_paymentstatus = $res_bankref_details["paymentstatus"];
			
			if($serv_paymentstatus == 'completed')
			{
				$service_status = "completed";
			}
			else
			{
				$service_status = "pending";
			}}
			else{

				$service_status = "completed";
				
				}
			
		}


		$pharmacy_details = "SELECT patientvisitcode,pharmacybill,medicineissue FROM master_consultationpharm WHERE patientcode='$patientcode' AND patientvisitcode='$visitcode' AND locationcode='$locationcode1' group by patientvisitcode";
		$exec_pharma_details = mysqli_query($GLOBALS["___mysqli_ston"], $pharmacy_details) or die ("Error in master_consultationpharm".mysqli_error($GLOBALS["___mysqli_ston"]));
		$pharma_gencount = mysqli_num_rows($exec_pharma_details);
		
			//For Pharmacy Issue
		$pharmacy_details = "SELECT patientvisitcode,pharmacybill FROM master_consultationpharm WHERE patientcode='$patientcode' AND patientvisitcode='$visitcode' AND locationcode='$locationcode1' group by patientvisitcode";
		$exec_pharma_details = mysqli_query($GLOBALS["___mysqli_ston"], $pharmacy_details) or die ("Error in master_consultationpharm".mysqli_error($GLOBALS["___mysqli_ston"]));
		$pharma_detailse_count = mysqli_num_rows($exec_pharma_details);
		if($pharma_detailse_count>0)
		{
			$res_pharma_details = mysqli_fetch_array($exec_pharma_details);
			$pharma_consult_id = $res_pharma_details["patientvisitcode"];
			
			$phm_bank_ref_details = "SELECT patientvisitcode,pharmacybill,medicineissue FROM master_consultationpharm WHERE patientvisitcode='$pharma_consult_id' AND patientcode='$patientcode' AND patientvisitcode='$visitcode' AND locationcode='$locationcode1'";
			$exec_phm_bankref_details = mysqli_query($GLOBALS["___mysqli_ston"], $phm_bank_ref_details) or die ("Error in master_consultationpharm".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res_phm_bankref_details = mysqli_fetch_array($exec_phm_bankref_details);
			$pharma_paymentstatus = $res_phm_bankref_details["pharmacybill"];
			if($pharma_paymentstatus == 'completed')
			{
				$pharma_status = "completed";
			}
			else
			{
				$pharma_status = "pending";
			}
			
		}
		?>
        	<!--DISPLAY STATUS REPORTS-->
            <tr bgcolor="#CBDBFA"><!--Visit Entry Status-->
            	<td colspan="2" >
                	<?php
					$triage_pending_desc = "<b>Available on Triage Queue.</b></br>";
					echo "Visit is Created in <b>".$departmentname.",".$accountname."</b>. </br>";
					  if($visit_entry_status == "pending")
					  {
						  echo "Available on Cashier queue for Consultation Payment.</br>";
					  }
					  else
					  {
						  echo "";
						 if($triage_status == "pending")
						 {
							 echo $triage_pending_desc;
						 }
					  }
					?>
                </td>
            </tr>
            <tr bgcolor="#ecf0f5"><!--Triage Status-->
            	<td colspan="2" >
                	<?php
					  if($visit_entry_status != "pending")
					  {

						$consultation_pending_desc = "<b>Waiting for Doctors Consultation.</b></br>";
						if($triage_status == "completed")
						{
							echo "";
						
							if($consultation_status == "")
							{
								echo $consultation_pending_desc;
							}
						}
					  }
					?>
                </td>
            </tr>
            <tr bgcolor="#CBDBFA"><!--Cosultation Status-->
            	<td colspan="2" >
                	<?php
					$review_chk = "";
						$qry_bill_close = "SELECT billno FROM billing_paylater WHERE patientcode='$patientcode' AND visitcode='$visitcode'";
						$exec_bill_close = mysqli_query($GLOBALS["___mysqli_ston"], $qry_bill_close) or die ("Error in billing_paylater".mysqli_error($GLOBALS["___mysqli_ston"]));
						$bill_gencount = mysqli_num_rows($exec_bill_close);
						if($consultation_status == "completed")
						{
							  if($ipadmit_triage == "yes")
							  {
								  $consult_ipadmit_status = "ipadmit";
								  echo "<strong>Patient Admited as IP</strong>.<br> ";
							  }
							  else
							  {
								  $review_chk='yes';
							  }
							  
								if($review_chk == "yes")
								{
									echo "Available on <strong>Review List</strong> Now.</br>";
								}
						}
						
						
					?>
                </td>
            </tr>
            <tr bgcolor="#ecf0f5"><!--Lab,Radiology and Services Status-->
            	<td colspan="2" >
                	<?php
						if($consultation_status == "completed")
						{
							
							//echo "Available on <b>Cashier queue </b>";
						/*if($lab_consult_count>0 || $rad_consult_count>0 || $serv_consult_count>0)
						{
							
							if($lab_status != "completed" || $radilogy_status != "completed" || $service_status!= "completed")
							{
								 echo "Available on <b>Cashier queue </b>for Lab, Radiology, Services Payment<br>";
								
							}
							else
							{
								echo "<strong>Lab Billing is Pending</strong>,";
							}
						}*/
						
						
						if($lab_consult_count>0 || $rad_consult_count>0 || $serv_consult_count>0)
						{
							if(($lab_status != "completed" && $lab_status!='' ) || ( $radilogy_status != "completed" && $radilogy_status!='') || ($service_status!= "completed" && $service_status!=''))
							{

								echo "Available on <b>Cashier queue or Approval Desk for</b>";
							if($lab_status != "completed" && $lab_status!='' )
							{
								echo " LAB Payment or Approval.,";
							}
							
							if( $radilogy_status != "completed" && $radilogy_status!='')
							{
								echo " RADIOLOGY Payment or Approval.,";
							}
							if($service_status!= "completed" && $service_status!='')
							{
							
									echo " SERVICES Payment or Approval.,";
							}
						  }
						}
						
							 if($pharma_detailse_count == 0)
							 {
								 echo "<br> <strong>No Prescription Available</strong>.<br>";
							 }
					}
					?>
                </td>
            </tr>
             <tr bgcolor="#CBDBFA"><!--Pharmacy Issue Status-->
            	<td colspan="2" >
                	<?php
						if($consultation_status == "completed")
						{
							if($pharma_detailse_count>0)
								{
									if($pharma_status == "completed")
									{
										 echo "<strong>Pharmacy Billing is Completed.</strong><br>";
									}
									else
									{
										echo "<strong>Available on Cashier or Approval Desk queue for Pharmacy Billing or Approval.</strong>.<br>";
									}
								}
								
								if($lab_status == "completed") 
								{
								if($lab_reult_status == "pending"){
										echo "<strong>Waiting for Lab results</strong>.<br>";
								}
								else{
										echo "Lab results completed and  available on Publishlist for Doctors.<br>";
									}
								}

								if($radilogy_status == "completed") 
								{
								if($rad_reult_status == "pending"){
										echo "<strong>Waiting for Radiology results</strong>.<br>";
								}
								else{
										echo "Radiology results completed and available on Publishlist for Doctors.<br>";
									}
								}						
						}

					?>
                </td>
            </tr>
			<tr bgcolor="#ecf0f5"><!--Final Invoice-->
            	<td colspan="2" >
                	<?php
						$qry_bill_close = "SELECT billno FROM billing_paylater WHERE patientcode='$patientcode' AND visitcode='$visitcode'";
						$exec_bill_close = mysqli_query($GLOBALS["___mysqli_ston"], $qry_bill_close) or die ("Error in billing_paylater".mysqli_error($GLOBALS["___mysqli_ston"]));
						$bill_gencount = mysqli_num_rows($exec_bill_close);
						if($bill_gencount > 0)
						{
							$bill_details = mysqli_fetch_array($exec_bill_close);
							echo "Visit Closed. Invoice No. <strong>".$bill_details['billno']."</strong></br>";
						}
					?>
                </td>
            </tr>
            
		    <!-- ENDS DISPLAY-->
		   <?php 
		   }//else (not if departmentcode is 54)
		   }else{ //close while
		   ?>

   	        <tr bgcolor="#FFFFFF">
               <td colspan="2"  align="left" valign="center" class="bodytext31"><strong><?php echo $searchsuppliername; ?>,<?php echo $searchsuppliercode; ?></strong>. Visit Not Created for the Patient</td>
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
