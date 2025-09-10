<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');

$searchsuppliername = '';
$suppliername = '';
$cbsuppliername = '';
$cbcustomername = '';
$cbbillnumber = '';
$cbbillstatus = '';
$colorloopcount = '';
$sno = '';
$snocount = '';
$visitcode1 = '';
$total = '0';
$pendingamount = '0.00';
$accountname = '';
$amount=0;

if (isset($_REQUEST["slocation"])) { $slocation = $_REQUEST["slocation"]; } else { $slocation = ""; }
if (isset($_REQUEST["overview"])) { $overview = $_REQUEST["overview"];  } else { $overview = ""; }
if (isset($_REQUEST["typemode"])) { $typemode = $_REQUEST["typemode"];  } else { $typemode = ""; }

if (isset($_REQUEST["Category"])) { $Category = $_REQUEST["Category"];  } else { $Category = ""; }
if (isset($_REQUEST["proceduretype"])) { $proceduretype = $_REQUEST["proceduretype"];  } else { $proceduretype = ""; }
if (isset($_REQUEST["speaciality"])) { $speaciality = $_REQUEST["speaciality"];  } else { $speaciality = ""; }
//$getcanum = $_GET['canum'];
if (isset($_REQUEST["anesthesiatype"])) { $anesthesiatype = $_REQUEST["anesthesiatype"];  } else { $anesthesiatype = ""; }
if (isset($_REQUEST["theatre"])) { $theatre = $_REQUEST["theatre"];  } else { $theatre = ""; }

if (isset($_REQUEST["surgeon1"])) { $surgeon1 = $_REQUEST["surgeon1"];  } else { $surgeon1 = ""; }
if (isset($_REQUEST["surgeon_name"])) { $surgeon_name = $_REQUEST["surgeon_name"];  } else { $surgeon_name = ""; }


if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	//$cbsuppliername = $_REQUEST['cbsuppliername'];
	//$suppliername = $_REQUEST['cbsuppliername'];
	$paymentreceiveddatefrom = $_REQUEST['ADate1'];
	$paymentreceiveddateto = $_REQUEST['ADate2'];
	//$visitcode1 = 10;

}


if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];
if ($ADate1 != '' && $ADate2 != '')
{
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
}
else
{
	$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
	$transactiondateto = date('Y-m-d');
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
<script src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />      
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">      

<script language="javascript">
window.onload = function(){
enabletype();
}

</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
<script language="javascript">
$(function() {
    	var surgeonname = document.getElementById('surgeon_name');
	    $('#surgeon_name').autocomplete({		
			source:'ajaxtheatredoctor.php?term='+surgeonname, 
			
			minLength:2,
			delay: 0,
			html: true, 
				select: function(event,ui){
					var surgeonid=ui.item.docid;
					//alert(surgeonid);
					$('#surgeon1').val(surgeonid);	
				}
		    });
	 });


function enabletype()
{
	var typemode = document.getElementById('typemode').value;
	//alert(typemode);
	if(typemode=='Procedure type'){
	$('#procedure').show();
	$('#Category').hide();	
	$('#speaciality').hide();	
	$('#anaesthesia').hide();
	$('#surgeon').hide();
	$('#theatre').hide();
	} else if(typemode=='Category'){
	$('#Category').show();
	$('#procedure').hide();
	$('#speaciality').hide();	
	$('#anaesthesia').hide();
	$('#surgeon').hide();
	$('#theatre').hide();
	}
	else if(typemode=='Procedure'){
	$('#Category').hide();
	$('#procedure').hide();
	$('#speaciality').show();	
	$('#anaesthesia').hide();
	$('#surgeon').hide();
	$('#theatre').hide();
	}
	else if(typemode=='Anesthesia type'){
	$('#Category').hide();
	$('#procedure').hide();
	$('#speaciality').hide();	
	$('#anaesthesia').show();
	$('#surgeon').hide();
	$('#theatre').hide();
	}
	else if(typemode=='Theatre'){
	$('#Category').hide();
	$('#procedure').hide();
	$('#speaciality').hide();	
	$('#anaesthesia').hide();
	$('#surgeon').hide();
	$('#theatre').show();
	}
	else if(typemode=='Surgeon'){
	$('#Category').hide();
	$('#procedure').hide();
	$('#speaciality').hide();	
	$('#anaesthesia').hide();
	$('#theatre').hide();
	$('#surgeon').show();
	}
	
	//return false;
}

function DShowE()
{
	$('#SHE').toggle();
}

</script>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="1800" border="0" cellspacing="0" cellpadding="2">
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
		
		
              <form name="cbform1" method="post" action="theatreprocedure_report.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Theatre Report </strong></td>
                      <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                      <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">&nbsp;</td>
                    </tr>
					
                    <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
					
					
				<tr> 
		   			<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> Type </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF" colspan="3"  >
					<select name="typemode" id="typemode" style="width: 130px;" onChange="enabletype()" >
                        <option value="">Select</option>
                        <option value="Procedure type"<?php if($typemode=='Procedure type') echo 'selected'; ?>>Procedure type</option>
                        <option value="Category"<?php if($typemode=='Category') echo 'selected'; ?>>Category</option>
						<option value="Procedure"<?php if($typemode=='Procedure') echo 'selected'; ?>>Specialty</option>
						<option value="Anesthesia type"<?php if($typemode=='Anesthesia type') echo 'selected'; ?>>Anesthesia type</option>
						<option value="Theatre"<?php if($typemode=='Theatre') echo 'selected'; ?>>Theatre</option>
						<option value="Surgeon"<?php if($typemode=='Surgeon') echo 'selected'; ?>>Surgeon</option>
                    </select></td>
                  </tr>
					
					<tr id="procedure" style="display:none">
		            <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" > Procedure Type </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF" colspan="3">
					<select name="proceduretype" id="proceduretype" style="width: 130px;">
                        <option value="">All</option>
                        <option value="emergency"<?php if($proceduretype=='emergency') echo 'selected'; ?>>Emergency</option>
                        <option value="elective"<?php if($proceduretype=='elective') echo 'selected'; ?>>Elective</option>
                    </select></td>
                    </tr>
					
					<tr id="Category" style="display:none">
		            <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" > Category </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF" colspan="3">
					<select name="Category" id="Category" style="width: 130px;">
                        <option value="">All</option>
                        <option value="major"<?php if($Category=='major') echo 'selected'; ?>>Major</option>
                        <option value="minor"<?php if($Category=='minor') echo 'selected'; ?>>Minor</option>
                    </select></td>
                    </tr>
					
					<tr id="speaciality" style="display:none">
					<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" > Specialties </td>
					<td align="left" valign="top"  bgcolor="#FFFFFF" colspan="3">
						<select style="border: 1px solid #001E6A; text-transform:uppercase;" name="speaciality" id="speaciality">
							<option value="">All</option>
							<?php
							  // get speacialities
							     $query_speac= "SELECT * FROM master_theatrespeaciality WHERE record_status <> 'deleted'";
								 $exec_speac= mysqli_query($GLOBALS["___mysqli_ston"], $query_speac) or die ("Error in Query_speac".mysqli_error($GLOBALS["___mysqli_ston"]));
								 while($res_speac = mysqli_fetch_array($exec_speac)){
									//
									$speaciality_id = $res_speac['auto_number'];
									$speaciality_name = $res_speac['speaciality_name'];
							?>
							<option value="<?php echo $speaciality_id;?>"<?php if($speaciality==$speaciality_id) echo 'selected'; ?>><?php echo $speaciality_name;?></option>
							<?php	
							 }
							?>
						</select>
					    </td>
					</tr>
					
					<tr id="anaesthesia" style="display:none">
					<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" > Anaesthesia Type </td>
							<td align="left" valign="middle"  bgcolor="#FFFFFF" colspan="3">
								<select name="anesthesiatype" id="anesthesiatype" width="100" style="border: 1px solid #001E6A;">
							  		<option value="">All</option>
		                            <option value="General Anesthesia"<?php if($anesthesiatype=='General Anesthesia') echo 'selected'; ?>>General Anesthesia</option>
		                            <option value="Spinal Anesthesia"<?php if($anesthesiatype=='Spinal Anesthesia') echo 'selected'; ?>>Spinal Anesthesia </option>
		                            <option value="Sedation Anesthesia"<?php if($anesthesiatype=='Sedation Anesthesia') echo 'selected'; ?>>Sedation Anesthesia</option>
		                            <option value="Regional Block Anesthesia"<?php if($anesthesiatype=='Regional Block Anesthesia') echo 'selected'; ?>>Regional Block Anesthesia</option>
		                            <option value="Local Anesthesia"<?php if($anesthesiatype=='Local Anesthesia') echo 'selected'; ?>>Local Anesthesia</option>
							  	</select>
							</td>
					</tr>
					
					<tr id="theatre" style="display:none">
					 <td align="left" valign="middle"  bgcolor="#FFFFFF"><span class="bodytext3">Theatre</span></td>
					 <td align="left" valign="middle"  bgcolor="#FFFFFF" colspan="3">
						<select name="theatre" id="theatre" style="border: 1px solid #001E6A;">
							  <option value="">All</option>
							  	<?php
							  	$query_th_1 = "SELECT * FROM master_theatre ORDER BY auto_number ASC";
							  	$exec_th_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_th_1) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
								while ($res_th_1 = mysqli_fetch_array($exec_th_1))
								{
								$auto_number = $res_th_1['auto_number'];
								$theatre_name = $res_th_1['theatrename'];
								?>
							  	<option value="<?php echo $auto_number;?>"<?php if($auto_number==$theatre) echo 'selected'; ?>><?php echo $theatre_name;?></option>
							  	 <?php } ?>
						</select>
					 </td>
					</tr>
					
					<tr id="surgeon" style="display:none">
						<td align="left" valign="middle"  bgcolor="#FFFFFF"><span class="bodytext3">Surgeon</span></td>
						<td align="left" valign="middle"  bgcolor="#FFFFFF" colspan="3">
							<input type="hidden" name="auto_id" id="auto_id" value="0"/>
							<input type="text" name="surgeon_name" size="35" id="surgeon_name" value="<?php echo $surgeon_name; ?>" autocomplete="off">
							<input type="hidden" name="surgeon1" id="surgeon1" value="" autocomplete="off">
						
						</td>
					</tr>
					
                    <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location </td>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
                      <select name="slocation" id="slocation">
                      	<?php
						$query01="select locationcode,locationname from master_location where status ='' order by locationname";
						$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
						while($res01=mysqli_fetch_array($exc01))
						{?>
							<option value="<?= $res01['locationcode'] ?>" <?php if($slocation==$res01['locationcode']){ echo "selected";} ?>> <?= $res01['locationname'] ?></option>		
						<?php 
						}
						?>
                      </select>
                      </td>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
                      
                      </td>
                      
                    </tr>
                    
                    <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
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
            
         <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="500" align="left" border="0">
          <tbody>
			
			<tr>
              <td  colspan="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">Description</strong></td>
			  <td  colspan="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">Count</strong></td>
			  <td  colspan="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">Action</strong></td>
            </tr>
            
			<?php
			
			
			$ADate1 = $transactiondatefrom;
			$ADate2 = $transactiondateto;
			$pro_totalcount='';
			$colorloopcount = '';
            $sno = '';
			
			if($cbfrmflag1 == 'cbfrmflag1')
			{ 
			
			
			if($typemode=='Procedure type'){?>
			
			
			<?php
			//$rows_cnt='0';
			   $querycr1in = "SELECT count(proceduretype) as rows_cnt,proceduretype   FROM `master_theatre_booking` WHERE  proceduretype like '%$proceduretype%' and  starttime <>'0000-00-00 00:00:00' and  date(starttime)  BETWEEN '$ADate1' AND '$ADate2' group by proceduretype ";
			 $execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $rows = mysqli_num_rows($execcr1);
			  while ($resccr1 = mysqli_fetch_array($execcr1))
			 {
			 $rows_cnt=$resccr1['rows_cnt'];
			 $proceduretype = $resccr1['proceduretype'];
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
              <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($proceduretype);?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $rows_cnt; ?></td>
			  <td width="" align="left" valign="center"   class="bodytext31"><span class="bodytext3"><a target="_blank" href="theatrelistwise_report.php?proceduretype=<?php echo $proceduretype; ?>&&cbfrmflag1=cbfrmflag1&&procedrype_wise=proced_wise&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>">VIEW</a> </span> </td>
			  </tr>
			 
			 
			<?php
			}
			}
			
			else if($typemode=='Category'){
			
			?>
			
			
			
			<?php
			//$row_count=0;
			 $querycr1in = "SELECT count(category) as row_count,category FROM `master_theatre_booking` WHERE  category like '%$Category%' and  starttime <>'0000-00-00 00:00:00' and  date(starttime)  BETWEEN '$ADate1' AND '$ADate2' group by category  ";	
			 $execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $rows = mysqli_num_rows($execcr1);
			 while($rescr1 = mysqli_fetch_array($execcr1))
			 {
			 $row_count1=$rescr1['row_count'];
			 $category=$rescr1['category'];
			 ///$row_count=$row_count+1;
			 
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
              <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($category);?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $row_count1; ?></td>
			  <td width="" align="left" valign="center"   class="bodytext31"><span class="bodytext3"><a target="_blank" href="theatrelistwise_report.php?category=<?php echo $category; ?>&&cbfrmflag1=cbfrmflag1&&procedrype_wise=category_wise&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>">VIEW</a> </span> </td>
			  </tr>
			
			 <?php
			 }
			 }
			 
			else if($typemode=='Procedure'){?>
			
			<?php
			 
			
			 
			 $query1 = "SELECT a.booking_id,a.proceduretype_anum,b.speaciality_id,count(b.speaciality_id) as countsum FROM `theatre_booking_proceduretypes` as a Left Join master_theatrespeaciality_subtype As b on(b.auto_number=a.proceduretype_anum) Left Join master_theatre_booking As c on(c.auto_number=a.booking_id) WHERE b.speaciality_id like '%$speaciality%' and c.starttime <>'0000-00-00 00:00:00' and date(c.starttime) BETWEEN '$ADate1' AND '$ADate2' group by b.speaciality_id";
			 $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			 while ($res1 = mysqli_fetch_array($exec1))
			 {
			 $count='';
			 $booking_id = $res1['booking_id'];
			 $proceduretype_anum = $res1['proceduretype_anum'];
			 $speaciality_id = $res1['speaciality_id'];
			 $countsum = $res1['countsum'];
			 
			  $query11 = "SELECT * FROM `master_theatrespeaciality` WHERE auto_number= '$speaciality_id' order by auto_number";
			 $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $res11 = mysqli_fetch_array($exec11);
             $res11speaciality_name = $res11['speaciality_name'];
			 
			 
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
			 
			 <tr <?php echo $colorcode;?>>
              <td width=""  align="left" valign="center"  bgcolor="" class="bodytext31"><?php echo strtoupper($res11speaciality_name);?></td>
			  <td width="" align="left" valign="center"  bgcolor="" class="bodytext31"><div align="left"><?php echo $countsum; ?></div></td>
			  <td width="" align="left" valign="center"   class="bodytext31"><span class="bodytext3"><a target="_blank" href="theatrelistwise_report.php?speaciality=<?php echo $speaciality_id; ?>&&cbfrmflag1=cbfrmflag1&&procedrype_wise=speca_wise&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>">VIEW</a> </span> </td>
			  </tr>
			 <?php
			 
			
			 }
			 
			
			 }
			 
			else if($typemode=='Anesthesia type'){  ?>
			
			
			
			<?php
			//$rows_cnt='0';
			   $querycr1in = "SELECT count(anesthesiatype) as rows_cnt,anesthesiatype   FROM `master_theatre_booking` WHERE  anesthesiatype like '%$anesthesiatype%' and  starttime <>'0000-00-00 00:00:00' and  date(starttime)  BETWEEN '$ADate1' AND '$ADate2' and anesthesiatype!=''  group by anesthesiatype ";
			 $execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $rows = mysqli_num_rows($execcr1);
			  while ($resccr1 = mysqli_fetch_array($execcr1))
			 {
			 $rows_cnt=$resccr1['rows_cnt'];
			 $anesthesiatype = $resccr1['anesthesiatype'];
			 
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
              <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($anesthesiatype);?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $rows_cnt; ?></td>
			  <td width="" align="left" valign="center"   class="bodytext31"><span class="bodytext3"><a target="_blank" href="theatrelistwise_report.php?anesthesiatype=<?php echo $anesthesiatype; ?>&&cbfrmflag1=cbfrmflag1&&procedrype_wise=anesthesia_wise&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>">VIEW</a> </span> </td>
			  </tr>
			 
			 
			<?php
			}
			
			 
			 }
			 
		    else if($typemode=='Theatre'){ ?>
			
			
			<?php
			//$rows_cnt='0';
			   $querycr1in = "SELECT count(theatrecode) as rows_cnt,theatrecode   FROM `master_theatre_booking` WHERE  theatrecode like '%$theatre%' and  starttime <>'0000-00-00 00:00:00' and  date(starttime)  BETWEEN '$ADate1' AND '$ADate2' group by theatrecode ";
			 $execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $rows = mysqli_num_rows($execcr1);
			  while ($resccr1 = mysqli_fetch_array($execcr1))
			 {
			 $rows_cnt=$resccr1['rows_cnt'];
			 $theatrecode = $resccr1['theatrecode'];
			 
			 $query7811 = "select * from master_theatre where auto_number='$theatrecode'";
			  $exec7811 = mysqli_query($GLOBALS["___mysqli_ston"], $query7811) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res7811 = mysqli_fetch_array($exec7811);
			  $theatrename = $res7811['theatrename'];
			 
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
              <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($theatrename);?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $rows_cnt; ?></td>
			  <td width="" align="left" valign="center"   class="bodytext31"><span class="bodytext3"><a target="_blank" href="theatrelistwise_report.php?theatrecode=<?php echo $theatrecode; ?>&&cbfrmflag1=cbfrmflag1&&procedrype_wise=theatre_wise&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>">VIEW</a> </span> </td>
			  </tr>
			 
			 
			<?php
			}
			  }
			  
			else if($typemode=='Surgeon'){ 
		
			   ?>
			
			<?php
			//$rows_cnt='0';
			if($surgeon1!=''){
			   $querycr1in = "SELECT  count(a.surgeon_id) as rows_cnt,a.surgeon_id   FROM `theatre_booking_surgeons` as a join `master_theatre_booking` as b on (b.auto_number=a.booking_id)  WHERE  a.surgeon_id = '$surgeon1' and  b.starttime <>'0000-00-00 00:00:00' and  date(b.starttime)  BETWEEN '$ADate1' AND '$ADate2' group by a.surgeon_id ";
			   } else{
			     $querycr1in = "SELECT  count(a.surgeon_id) as rows_cnt,a.surgeon_id   FROM `theatre_booking_surgeons` as a join `master_theatre_booking` as b on (b.auto_number=a.booking_id)  WHERE  a.surgeon_id like '%$surgeon1%' and  b.starttime <>'0000-00-00 00:00:00' and  date(b.starttime)  BETWEEN '$ADate1' AND '$ADate2' group by a.surgeon_id ";
			   }
			 $execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $rows = mysqli_num_rows($execcr1);
			  while ($resccr1 = mysqli_fetch_array($execcr1))
			 {
			 $rows_cnt=$resccr1['rows_cnt'];
			 $surgeon_id = $resccr1['surgeon_id'];
			 
				$query_t = "SELECT * FROM master_doctor WHERE doctorcode= '$surgeon_id'";
				$exec_t = mysqli_query($GLOBALS["___mysqli_ston"], $query_t) or die ("Error in Query_s".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res_t = mysqli_fetch_assoc($exec_t);
			    $newdoctorname=$res_t['doctorname'];
			 
			 
			 
			 
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
              <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($newdoctorname);?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $rows_cnt; ?></td>
			  <td width="" align="left" valign="center"   class="bodytext31"><span class="bodytext3"><a target="_blank" href="theatrelistwise_report.php?surgeontype=<?php echo $surgeon_id; ?>&&cbfrmflag1=cbfrmflag1&&procedrype_wise=surgeon_wise&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>">VIEW</a> </span> </td>
			  </tr>
			 
			 
			<?php
			}
			
			   
			    }
			  
			  
			
			?>
			
			 
			<?php
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

