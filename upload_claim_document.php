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
/*$path_info=__DIR__;
echo "pathinfo-->".$path_info=str_replace("\\",'/',$path_info);*/

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
$docno=$_SESSION["docno"];
$username = $_SESSION["username"];
$query01="select locationcode from login_locationdetails where docno ='$docno' and username='$username' order by auto_number desc";
$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
$res01=mysqli_fetch_array($exc01);
$slocation = $res01['locationcode'];


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
if (isset($_REQUEST["visitcode"])) {$visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
?>
<script type="text/javascript" src="js/jquery.min-autocomplete.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript">

function update_claimdetails(visitcode,sno,source)
{
		var get_file=$("#file_upload"+sno).val();	
		var autono_final = sno;
		var mainsource='claimform';
		var property = document.getElementById('file_upload'+autono_final).files[0];
		var image_name = property.name;
		var image_extension = image_name.split('.').pop().toLowerCase();
		if(jQuery.inArray(image_extension,['pdf']) == -1){
		alert("Please Upload only the PDF files!");
		return false;
		}
		
		var check = confirm("Are you sure you want to Upload the "+image_name+"?");
		if (check != true) {
		$('#file_upload'+autono_final).val('');
		return false;
		}
		
		var form_data = new FormData();
		form_data.append("file",property);
		 // alert(form_data);
		$.ajax({
 url:'slade-claim-attachment.php?visitcode='+visitcode+'&&sno='+sno+'&&get_file='+image_name+'&&source='+source+'&&mainsource='+mainsource,
		method:'POST',
		data:form_data,
		contentType:false,
		cache:false,
		processData:false,
		success:function(data){
		$('#idTR'+sno).hide();
		}
		});	
	
	
	
	
	

/*var get_dis_summ='';
if(source=='ip')
{
var get_dis_summ=$("#dis_summ_upload"+sno).val();
}
var get_file=$("#file_upload"+sno).val();

alert(get_file);
alert(get_dis_summ);
return false;

	var dataString_val="visitcode="+visitcode+"&&sno="+sno+"&&get_file="+get_file+"&&get_dis_summ="+get_dis_summ+"&&source="+source;
		$.ajax({
			type: "get",
			url: "slade-claim-attachment.php",
			data: dataString_val,
			success: function(html){
			
			$('#idTR'+sno).hide();

			}
		});*/
}

function update_claimdetails_ds(visitcode,sno,source)
{
		var get_file=$("#dis_summ_upload"+sno).val();	
		var autono_final = sno;
		var mainsource='discharge';
		var property = document.getElementById('dis_summ_upload'+autono_final).files[0];
		var image_name = property.name;
		var image_extension = image_name.split('.').pop().toLowerCase();
		if(jQuery.inArray(image_extension,['pdf']) == -1){
		alert("Please Upload only the PDF files!");
		return false;
		}
		
		var check = confirm("Are you sure you want to Upload the "+image_name+"?");
		if (check != true) {
		$('#file_upload'+autono_final).val('');
		return false;
		}
		
		var form_data = new FormData();
		form_data.append("file",property);
		 // alert(form_data);
		$.ajax({
 url:'slade-claim-attachment.php?visitcode='+visitcode+'&&sno='+sno+'&&get_file='+image_name+'&&source='+source+'&&mainsource='+mainsource,
		method:'POST',
		data:form_data,
		contentType:false,
		cache:false,
		processData:false,
		success:function(data){
		$('#idTR'+sno).hide();
		}
		});	

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
<?php /*?><?php include ("autocompletebuild_account2.php"); ?>
<?php include ("js/dropdownlist1scriptingicdcode.php"); ?><?php */?>
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

<body>
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
		
		
		<form name="cbform1" method="post" action="upload_claim_document.php">
			<table width="35%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
				<tbody>
				<tr bgcolor="#011E6A">
					<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Upload Claim Document </strong></td>
					<td bgcolor="#ecf0f5" class="bodytext3" colspan="4">&nbsp;</td>
				</tr>
					
				
					
				<tr>
					<td width="13%"  align="left" valign="center" 
                bgcolor="#FFFFFF" class="bodytext31">Visitcode</td>
                      <td colspan="3" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" autocomplete="off" size="50"/>
			
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
        <td>
      <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="1300" align="left" border="0">
          <tbody>
            
            
			<?php
			
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			
			if ($cbfrmflag1 == 'cbfrmflag1')
				{
				
							 
				?>
			<tr>
				<th width="1%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>No.</strong></th>
                <th width="4%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Code</th>
				<th width="4%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit Code</th>
				<th width="4%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit Date</th>
                <th width="4%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</th>
				<th width="3%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Gender</th>
				<th width="2%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Age</th>
				<th width="8%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Subtype</th>
				<th width="6%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Account</th>
				<th width="6%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</th>
                <th width="6%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Claim Form</th>
                <th width="6%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Discharge Form</th>
                <th width="6%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</th>
			
				
			</tr>
			
			<?php
					
			 $query1 = "select a.subtype,'op' as source,a.gender,a.age,a.registrationdate as consultationdate,a.patientcode,a.patientfullname as patientname,a.visitcode as visitcode,a.accountname from master_visitentry as a 
			 inner join slade_claim as b
			 where a.visitcode=b.visitcode and b.claim_invoice_status='pending' and a.locationcode ='$slocation' 
			 UNION ALL
			select  a.subtype,'ip' as source,a.gender,a.age,a.registrationdate as consultationdate,a.patientcode,a.patientfullname as patientname,a.visitcode as visitcode,a.accountname from master_ipvisitentry as a 
			inner join slade_claim as b
			where a.visitcode=b.visitcode and b.claim_invoice_status='pending' and a.locationcode ='$slocation' ";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
 		 	 $num=mysqli_num_rows($exec1);
			
			while($res1 = mysqli_fetch_array($exec1))
			{
			$billnumber='';
			$res1patientcode= $res1['patientcode'];
			$visitcode= $res1['visitcode'];
			$accountname= $res1['accountname'];
			$source= $res1['source'];
			$gender= $res1['gender'];
			$res1patientvisitcode= $res1['visitcode'];
			$res1consultationdate= $res1['consultationdate'];
		 	$res1patientname= $res1['patientname'];
			$res1age=$res1['age'];
		    $subtype=$res1['subtype'];
			
		$query222 = "select subtype from master_subtype where auto_number = '$subtype' AND recordstatus = '' "; 
		$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in query222".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res222 = mysqli_fetch_array($exec222);
		$subtypename= $res222['subtype'];
		
	    $query2221 = "select claim_upload_payload,claim_ds_upload from slade_claim where visitcode = '$visitcode'"; 
		$exec2221 = mysqli_query($GLOBALS["___mysqli_ston"], $query2221) or die ("Error in query2221".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2221 = mysqli_fetch_array($exec2221);
		$claim_upload_payload= $res2221['claim_upload_payload'];
		$claim_ds_upload= $res2221['claim_ds_upload'];
		
		$query222 = "select accountname from master_accountname where auto_number = '$accountname' AND recordstatus = 'ACTIVE' "; 
		$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in query222".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res222 = mysqli_fetch_array($exec222);
		$res21accountname= $res222['accountname'];
		
		if($source=='op')
		{
		$query2221 = "select billno from billing_paylater where visitcode = '$visitcode'"; 
		$exec2221 = mysqli_query($GLOBALS["___mysqli_ston"], $query2221) or die ("Error in query2221".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2221 = mysqli_fetch_array($exec2221);
		$billnumber= $res2221['billno'];
		}
		else
		{
		$query2221 = "select billno from billing_ip where visitcode = '$visitcode'"; 
		$exec2221 = mysqli_query($GLOBALS["___mysqli_ston"], $query2221) or die ("Error in query2221".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2221 = mysqli_fetch_array($exec2221);
		$billnumber= $res2221['billno'];	
		}
			
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
            
            <tr <?php echo $colorcode; ?> id='idTR<?php echo $snocount;?>'>
              <td class="bodytext31" width="1%" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" width="4%"  valign="center"  align="left"><?php echo $res1patientcode; ?></td>
                <td class="bodytext31" width="4%"  valign="center"  align="left"><?php echo $visitcode; ?></td>
               <td class="bodytext31" width="4%"  valign="center"  align="left"><?php echo date('d-m-y',strtotime($res1consultationdate)); ?></td>
               <td class="bodytext31" width="6%"  valign="center"  align="left"><?php echo $res1patientname; ?></td>
               <td class="bodytext31" width="3%"  valign="center"  align="left"><?php echo $gender; ?></td>
               <td class="bodytext31" width="2%"  valign="center"  align="left"><?php echo $res1age; ?></td>
			   <td class="bodytext31" width="6%"  valign="center"  align="left"><?php echo $subtypename; ?></td>
				<td class="bodytext31" width="6%"  valign="center"  align="left"><?php echo $res21accountname; ?></td>
				<td class="bodytext31" width="6%"  valign="center"  align="left"><?php echo $billnumber; ?></td>
                  <?php
			   if($claim_upload_payload=='')
		       {?>            
               <td class="bodytext31" width="6%"  valign="center"  align="left">
        <input type="file" id="file_upload<?php echo $snocount; ?>" name="file_upload<?php echo $snocount; ?>"  title="Upload" onChange="update_claimdetails('<?php echo $visitcode; ?>','<?php echo $snocount; ?>','<?php echo $source; ?>')"/></td>
        <?php } else { ?>
         <td class="bodytext31" width="6%"  valign="center"  align="left"></td>
               <?php
		      }
			   if($source=='op' || $claim_ds_upload!='')
		       {?>
                <td class="bodytext31" width="6%"  valign="center"  align="left"></td>
                <?php } else { ?>
           <td class="bodytext31" width="6%"  valign="center"  align="left">
          <input type="file" id="dis_summ_upload<?php echo $snocount; ?>" name="dis_summ_upload<?php echo $snocount; ?>"  title="Upload" onChange="update_claimdetails_ds('<?php echo $visitcode; ?>','<?php echo $snocount; ?>','<?php echo $source; ?>')" /></td>
               <?php } ?>
                
                 
               </tr>
		   <?php 
		   
			}
		 		
				
				}
		   ?>
		   
		   
		   
		   
		
          </tbody>
        </table></td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

