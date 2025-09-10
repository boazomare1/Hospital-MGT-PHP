<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date("Y-m-d",strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
if(isset($_POST['ADate1'])){$fromdate = $_POST['ADate1'];}else{$fromdate=$transactiondatefrom;}
if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate=$transactiondateto;}
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
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>
<script type="text/javascript">

function funcdupupdate(billnumber,visitcode,patienttype,billtype){
//alert(autono);
//alert("hi");
 $('#'+billnumber).attr("disabled", true);
//alert(billnumber+""+patienttype+""+billtype);
  if(billnumber !="" && visitcode != "" && patienttype != "" && billtype != ""){
 
 var data = "billnumber="+billnumber+"&&visitcode="+visitcode+"&&patienttype="+patienttype+"&&billtype="+billtype;
   // alert(data);
 $.ajax({
  type : "get",
  url : "ajaxdupdate.php",
  data : data,
  cache : false,
  success : function (data){
   
   if(data !=""){
   alert(data);
  //  $("#availablelimit").val(data);
    //location.reload();
   } 
    else{
   alert("Updated Successfully ");
   }    
  }
    
 });
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
    <td width="99%" valign="top">
	<table width="105%" border="0" cellspacing="0" cellpadding="0">
	      
		  <tr>
        <td width="860">
              <form name="cbform1" method="post" action="">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
				
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visitcode</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="visitcode" type="text" id="visitcode" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			     <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Bill No</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="billno" type="text" id="bill" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
                   <tr>
          <td width="100" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="137" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $fromdate; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="68" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="263" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" value="<?php echo $todate; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
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
	$searchvisit=$_POST['visitcode'];
	$searchbill=$_POST['billno'];
	$fromdate=$_POST['ADate1'];
	$todate=$_POST['ADate2'];
	?>
  <tr>
   
    <td width="99%" valign="top">
	<table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1075" 
            align="left" border="0">
          <tbody>
            <tr>
              <td colspan="8" bgcolor="#ecf0f5" class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left"><strong>Detailed List</strong><label class="number">&nbsp;</label>
                </div></td>
              </tr>
          
		
			<?php
			$sno = '';
			$showcolor='';
			$colorloopcount = '';
	
	$fromdate = $_REQUEST['ADate1'];
						$todate = $_REQUEST['ADate2'];
	
		?>
	
	 
	
	
	<?php
	
			
				//Pay Now Bills Update Same BillNumber on Different Patients
				
	
		$pno=1;
		$query1 = "select auto_number,billnumber,count(billnumber) from master_transactionpaynow where transactiondate between '$fromdate' and '$todate' and transactionamount <> '0.00' and billnumber like '%$searchbill%' and visitcode like '%$searchvisit%' group by billnumber having count(billnumber) > 1 order by auto_number ASC";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($exec1))
			{
			?>
			<tr>
			<td colspan="8" bgcolor="#FFF">Total OP PayNow BillNumber Duplicate Bills: <?=mysqli_num_rows($exec1);?></td>
			</tr>
			<?php
			while($res1=mysqli_fetch_array($exec1))
			{
			?>
			<tr bgcolor="#CCC">
			<td><?=$pno++?></td>
			<td>Table ano</td>
			<td>Patient Code</td>
			<td>Patient Name</td>
			<td>Visit Code</td>
			<td>Bill Number</td>
			<td>Bill Amount</td>
			</tr>
			<?php
			$billnumber1 = $res1['billnumber'];
			$auto_number1 = $res1['auto_number'];
			$pno1=1;
			$query2 = "select auto_number,patientcode,patientname,visitcode,billnumber,transactionamount from master_transactionpaynow where billnumber like '$billnumber1' and transactiondate between '$fromdate' and '$todate' and auto_number > $auto_number1 order by auto_number ASC";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res2=mysqli_fetch_array($exec2))
			{
			$patientcode = $res2['patientcode'];
			$visitcode = $res2['visitcode'];
			$billno2 = $res2['billnumber'];
			?>
			<tr bgcolor="">
			<td><?=$pno1?></td>
			<td><?=$res2['auto_number'];?></td>
			<td><?=$res2['patientcode'];?></td>
			<td><?=$res2['patientname'];?></td>
			<td><?=$res2['visitcode'];?></td>
			<td><?=$res2['billnumber'];?></td>
			<td><?=$res2['transactionamount'];?></td>
			</tr>
			<?php
		
			$pno1++;
			}
			
			?>
			<tr>
			<td colspan="8" bgcolor="#FFF">&nbsp;</td>
			<td align="center" valign="middle" style="color:<?= $color; ?>"><strong><button type="button" id="<?php echo $billnumber1; ?>"  onClick="funcdupupdate('<?php echo $billnumber1; ?>','<?php echo $visitcode; ?>','op','<?php echo 'cash'; ?>')
" >Update</button></strong></td>
			</tr>
			<?php
			} 
				}
				
				?>
					
		<?php
		
			
		$pno=1;
		$query1 = "select auto_number,visitcode,subtype,count(visitcode) as visnos from master_transactionip where subtype='CASH' and  transactiondate between '$fromdate' and '$todate'  group by visitcode having count(visitcode) > 1 order by auto_number ASC";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($exec1))
			{
			?>
			<tr>
			<td colspan="8" bgcolor="#FFF">Total  IP PayNow  Duplicate Bills on same Visit: <?=mysqli_num_rows($exec1);?></td>
			</tr>
			<?php
			while($res1=mysqli_fetch_array($exec1))
			{
			$visitcode1 = $res1['visitcode'];
			$auto_number1 = $res1['auto_number'];
			$visnos = $res1['visnos'];
			$pno1=1;
			$sno1=1;
			if(strtolower($res1['subtype']) == 'cash')
			{
			
			?>
			<tr bgcolor="#CCC">
			<td><?=$pno++?></td>
			<td>Table ano</td>
			<td>Patient Code</td>
			<td>Patient Name</td>
			<td>Visit Code</td>
			<td>Bill Number</td>
			<td>Account Name</td>
			<td>Bill Amount</td>
			</tr>
			<?php
			
			$query2 = "select auto_number,patientcode,patientname,visitcode,billnumber,accountname,transactionamount,subtype from master_transactionip where visitcode like '$visitcode1' and transactiondate between '$fromdate' and '$todate'  order by auto_number ASC";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res2=mysqli_fetch_array($exec2))
			{
			$patientcode = $res2['patientcode'];
			$visitcode = $res2['visitcode'];
			$billno2 = $res2['billnumber'];
			?>
			<tr bgcolor="">
			<td><?=$pno1?></td>
			<td><?=$res2['auto_number'];?></td>
			<td><?=$res2['patientcode'];?></td>
			<td><?=$res2['patientname'];?></td>
			<td><?=$res2['visitcode'];?></td>
			<td><?=$res2['billnumber'];?></td>
			<td><?=$res2['accountname'];?></td>
			<td><?=$res2['transactionamount'];?></td>
			</tr>
			<?php

			$pno1++;
			}
			
			?>
				<tr>
			<td colspan="8" bgcolor="#FFF">&nbsp;</td>
			<td align="center" valign="middle" style="color:<?= $color; ?>"><strong><button type="button" id="<?php echo $billno2; ?>"  onClick="funcdupupdate('<?php echo $billno2; ?>','<?php echo $visitcode1; ?>','ip','<?php echo 'cash'; ?>')" >Update</button></strong></td>
			</tr>
			<?php
			
			}
				}	
			}	
			
			
			//Pay Later Bills Update Same Billnumber on Different Patients </strong></td>
			
		$pno=1;
		$query1 = "select auto_number,billnumber,count(billnumber) from master_transactionpaylater where billnumber like 'CB-%' and transactiontype like 'finalize' and transactiondate between '$fromdate' and '$todate' and billnumber like '%$searchbill%' and visitcode like '%$searchvisit%' group by billnumber having count(billnumber) > 1 order by auto_number ASC";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($exec1))
			{
			?>
			<tr>
			<td colspan="8" bgcolor="#FFF">Total OP PayLater BillNumber Duplicates: <?=mysqli_num_rows($exec1);?></td>
			</tr>
			<?php
			while($res1=mysqli_fetch_array($exec1))
			{
			?>
			<tr bgcolor="#CCC">
			<td><?=$pno++?></td>
			<td>Table ano</td>
			<td>Patient Code</td>
			<td>Patient Name</td>
			<td>Visit Code</td>
			<td>Bill Number</td>
			<td>Account Name</td>
			<td>Bill Amount</td>
			</tr>
			<?php
			$auto_number1 = $res1['auto_number'];
			$billno1 = $res1['billnumber'];
			$pno1=1;
			$query2 = "select auto_number,patientcode,patientname,visitcode,billnumber,accountname,transactionamount from master_transactionpaylater where billnumber like '$billno1' and transactiontype like 'finalize' and transactiondate between '$fromdate' and '$todate' order by auto_number ASC";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res2=mysqli_fetch_array($exec2))
			{
			$patientcode = $res2['patientcode'];
			$visitcode = $res2['visitcode'];
			$billno2 = $res2['billnumber'];
			?>
			<tr bgcolor="">
			<td><?=$pno1?></td>
			<td><?=$res2['auto_number'];?></td>
			<td><?=$res2['patientcode'];?></td>
			<td><?=$res2['patientname'];?></td>
			<td><?=$res2['visitcode'];?></td>
			<td><?=$res2['billnumber'];?></td>
			<td><?=$res2['accountname'];?></td>
			<td><?=$res2['transactionamount'];?></td>
			</tr>
			<?php
		
			$pno1++;
			}
			
			?>
			<tr>
		<td colspan="8" bgcolor="#FFF">&nbsp;</td>
			<td align="center" valign="middle" style="color:<?= $color; ?>"><strong><button type="button" id="<?php echo $billno2; ?>"  onClick="funcdupupdate('<?php echo $billno2; ?>','<?php echo $visitcode; ?>','op','<?php echo 'credit'; ?>')
" >Update</button></strong></td>
			</tr>
			<?php
			} 
			}
				//Pay Later Bills Update Same Patients on Different Bills 				
		$pno=1;
		$query1 = "select auto_number,visitcode,count(visitcode) as visnos from master_transactionpaylater where billnumber like 'CB-%' and transactiontype like 'finalize' and transactiondate between '$fromdate' and '$todate' and transactionamount <> '0.00' and billnumber like '%$searchbill%' and visitcode like '%$searchvisit%' group by visitcode having count(visitcode) > 1 order by auto_number ASC";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($exec1))
			{
			?>
			<tr>
			<td colspan="8" bgcolor="#FFF">Total  OP PayLater Duplicate Bills on Same Visit: <?=mysqli_num_rows($exec1);?></td>
			</tr>
			<?php
			while($res1=mysqli_fetch_array($exec1))
			{
						$auto_number1 = $res1['auto_number'];
			$visitcode1 = $res1['visitcode'];
			$visnos = $res1['visnos'];
			$pno1=1;
			$query2 = "select auto_number,patientcode,patientname,visitcode,billnumber,accountname,transactionamount from master_transactionpaylater where visitcode like '$visitcode1' and transactiontype like 'finalize' and transactiondate between '$fromdate' and '$todate'  order by auto_number ASC";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$visno =mysqli_num_rows($exec2);
			if($visno>0 && $visnos == $visno)
			{
			?>
			<tr bgcolor="#CCC">
			<td><?=$pno++?></td>
			<td>Table ano</td>
			<td>Patient Code</td>
			<td>Patient Name</td>
			<td>Visit Code</td>
			<td>Bill Number</td>
			<td>Account Name</td>
			<td>Bill Amount</td>
			</tr>
			<?php
			while($res2=mysqli_fetch_array($exec2))
			{
			$patientcode = $res2['patientcode'];
			$visitcode = $res2['visitcode'];
			$billno2 = $res2['billnumber'];
			?>
			<tr bgcolor="">
			<td><?=$pno1++?></td>
			<td><?=$res2['auto_number'];?></td>
			<td><?=$res2['patientcode'];?></td>
			<td><?=$res2['patientname'];?></td>
			<td><?=$res2['visitcode'];?></td>
			<td><?=$res2['billnumber'];?></td>
			<td><?=$res2['accountname'];?></td>
			<td><?=$res2['transactionamount'];?></td>
			</tr>
			<?php
			if($res2['auto_number'] != $auto_number1)
			{
		
			$pno1++;
			
			}
			}
			?>
			<tr>
			<td colspan="8" bgcolor="#FFF">&nbsp;</td>
			<td align="center" valign="middle" style="color:<?= $color; ?>"><strong><button type="button" id="<?php echo $billno2; ?>"  onClick="funcdupupdate('<?php echo $billno2; ?>','<?php echo $visitcode; ?>','op','<?php echo 'credit'; ?>')
" >Update</button></strong></td>
			</tr>
			<?php
			} 
			else
			{
			?>
			<tr bgcolor="#CCC">
			<td><?=$pno++?></td>
			<td>Table ano</td>
			<td>Patient Code</td>
			<td>Patient Name</td>
			<td>Visit Code</td>
			<td>Bill Number</td>
			<td>Account Name</td>
			<td>Bill Amount</td>
			</tr>
			<?php
			while($res2=mysqli_fetch_array($exec2))
			{
			$patientcode = $res2['patientcode'];
			$visitcode = $res2['visitcode'];
			$billno2 = $res2['billnumber'];
			?>
			<tr bgcolor="">
			<td><?=$pno1?></td>
			<td><?=$res2['auto_number'];?></td>
			<td><?=$res2['patientcode'];?></td>
			<td><?=$res2['patientname'];?></td>
			<td><?=$res2['visitcode'];?></td>
			<td><?=$res2['billnumber'];?></td>
			<td><?=$res2['accountname'];?></td>
			<td><?=$res2['transactionamount'];?></td>
			</tr>
			<?php
	
			$pno1++;
			}
			?>
				<tr>
		<td colspan="8" bgcolor="#FFF">&nbsp;</td>
			<td align="center" valign="middle" style="color:<?= $color; ?>"><strong><button type="button" id="<?php echo $billno2; ?>"  onClick="funcdupupdate('<?php echo $billno2; ?>','<?php echo $visitcode; ?>','op','<?php echo 'credit'; ?>')
" >Update</button></strong></td>
			</tr>
			<?php
			} 
		}
			}	
				//IP Bills Update Same BillNumber on Different Patients 
			
		$pno=1;
		$query1 = "select auto_number,billnumber,subtype,count(billnumber) as visnos from master_transactionip where subtype <> 'CASH' and transactiondate between '$fromdate' and '$todate' and billnumber like '%$searchbill%' and visitcode like '%$searchvisit%' group by billnumber having count(billnumber) > 1 order by auto_number ASC";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($exec1))
			{
			?>
			<tr>
			<td colspan="8" bgcolor="#FFF">Total IP PayLater Duplicate Bills: <?=mysqli_num_rows($exec1);?></td>
			</tr>
			<?php
			while($res1=mysqli_fetch_array($exec1))
			{
			$billnumber1 = $res1['billnumber'];
			$auto_number1 = $res1['auto_number'];
			$visnos = $res1['visnos'];
			$pno1=1;
			$sno1=1;
			if(strtolower($res1['subtype']) != 'cash')
			{	
			$query2 = "select auto_number,patientcode,patientname,visitcode,billnumber,accountname,transactionamount from master_transactionpaylater where billnumber like '$billnumber1' and transactiontype like 'finalize' and transactiondate between '$fromdate' and '$todate'  order by auto_number ASC";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			$visno =mysqli_num_rows($exec2);
			if($visno>0 && $visnos == $visno)
			{
			?>
			<tr bgcolor="#CCC">
			<td><?=$pno?></td>
			<td>Table ano</td>
			<td>Patient Code</td>
			<td>Patient Name</td>
			<td>Visit Code</td>
			<td>Bill Number</td>
			<td>Account Name</td>
			<td>Bill Amount</td>
			</tr>
			<?php
			while($res2=mysqli_fetch_array($exec2))
			{
			$patientcode = $res2['patientcode'];
			$visitcode = $res2['visitcode'];
			$billno2 = $res2['billnumber'];
			?>
			<tr bgcolor="">
			<td><?=$pno1?></td>
			<td><?=$res2['auto_number'];?></td>
			<td><?=$res2['patientcode'];?></td>
			<td><?=$res2['patientname'];?></td>
			<td><?=$res2['visitcode'];?></td>
			<td><?=$res2['billnumber'];?></td>
			<td><?=$res2['accountname'];?></td>
			<td><?=$res2['transactionamount'];?></td>
			</tr>
			<?php
			if($pno1!= '1')
			{
		
			$sno1++;
			
			}
			$pno1++;
			}
			?>
			<tr>
			<td colspan="8" bgcolor="#FFF">&nbsp;</td>
			<td align="center" valign="middle" style="color:<?= $color; ?>"><strong><button type="button" id="<?php echo $billno2; ?>"  onClick="funcdupupdate('<?php echo $billno2; ?>','<?php echo $visitcode; ?>','ip','<?php echo 'credit' ?>')
" >Update</button></strong></td>
			</tr>
			<?php
			} 
			else
			{
			?>
			<tr bgcolor="#CCC">
			<td><?=$pno++?></td>
			<td>Table ano</td>
			<td>Patient Code</td>
			<td>Patient Name</td>
			<td>Visit Code</td>
			<td>Bill Number</td>
			<td>Account Name</td>
			<td>Bill Amount</td>
			</tr>
			<?php
			while($res2=mysqli_fetch_array($exec2))
			{
			$patientcode = $res2['patientcode'];
			$visitcode = $res2['visitcode'];
			$billno2 = $res2['billnumber'];
			?>
			<tr bgcolor="">
			<td><?=$pno1?></td>
			<td><?=$res2['auto_number'];?></td>
			<td><?=$res2['patientcode'];?></td>
			<td><?=$res2['patientname'];?></td>
			<td><?=$res2['visitcode'];?></td>
			<td><?=$res2['billnumber'];?></td>
			<td><?=$res2['accountname'];?></td>
			<td><?=$res2['transactionamount'];?></td>
			</tr>
			<?php
		
			$pno1++;
			}
			?>
			<tr>

			<td colspan="9" bgcolor="#FFF">&nbsp;</td>
			</tr>
			<?php
			}
			
				}
				}
			}	
					//IP Bills Update Different BillNumber on Save Visit 
			
		$pno=1;
		$query1 = "select auto_number,visitcode,subtype,count(visitcode) as visnos from master_transactionip where subtype<>'CASH' and transactiondate between '$fromdate' and '$todate' and transactionamount <> '0.00' and billnumber like '%$searchbill%' and visitcode like '%$searchvisit%' group by visitcode having count(visitcode) > 1 order by auto_number ASC";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($exec1))
			{
			?>
			<tr>
			<td colspan="8" bgcolor="#FFF">Total IP PayLater Duplicate Bills on same Visit: <?=mysqli_num_rows($exec1);?></td>
			</tr>
			<?php
			while($res1=mysqli_fetch_array($exec1))
			{
			$visitcode1 = $res1['visitcode'];
			$auto_number1 = $res1['auto_number'];
			$visnos = $res1['visnos'];
			$pno1=1;
			$sno1=1;
			if(strtolower($res1['subtype']) != 'cash')
			{	
			$query2 = "select auto_number,patientcode,patientname,visitcode,billnumber,accountname,transactionamount from master_transactionpaylater where visitcode like '$visitcode1' and transactiontype like 'finalize' and transactiondate between '$fromdate' and '$todate'  order by auto_number ASC";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			$visno =mysqli_num_rows($exec2);
			if($visno>0 && $visnos == $visno)
			{
			?>
			<tr bgcolor="#CCC">
			<td><?=$pno?></td>
			<td>Table ano</td>
			<td>Patient Code</td>
			<td>Patient Name</td>
			<td>Visit Code</td>
			<td>Bill Number</td>
			<td>Account Name</td>
			<td>Bill Amount</td>
			</tr>
			<?php
			while($res2=mysqli_fetch_array($exec2))
			{
			$patientcode = $res2['patientcode'];
			$visitcode = $res2['visitcode'];
			$billno2 = $res2['billnumber'];
			?>
			<tr bgcolor="">
			<td><?=$pno1?></td>
			<td><?=$res2['auto_number'];?></td>
			<td><?=$res2['patientcode'];?></td>
			<td><?=$res2['patientname'];?></td>
			<td><?=$res2['visitcode'];?></td>
			<td><?=$res2['billnumber'];?></td>
			<td><?=$res2['accountname'];?></td>
			<td><?=$res2['transactionamount'];?></td>
			</tr>
			<?php
			if($pno1!= '1')
			{
		
			$sno1++;
			
			}
			$pno1++;
			}
			?>
			<tr>
			<td colspan="8" bgcolor="#FFF">&nbsp;</td>
			<td align="center" valign="middle" style="color:<?= $color; ?>"><strong><button type="button" id="<?php echo $billno2; ?>"  onClick="funcdupupdate('<?php echo $billno2; ?>','<?php echo $visitcode; ?>','ip','<?php echo 'credit'; ?>')
" >Update</button></strong></td>
			</tr>
			<?php
			} 
			else
			{
			?>
			<tr bgcolor="#CCC">
			<td><?=$pno++?></td>
			<td>Table ano</td>
			<td>Patient Code</td>
			<td>Patient Name</td>
			<td>Visit Code</td>
			<td>Bill Number</td>
			<td>Account Name</td>
			<td>Bill Amount</td>
			</tr>
			<?php
			while($res2=mysqli_fetch_array($exec2))
			{
			$patientcode = $res2['patientcode'];
			$visitcode = $res2['visitcode'];
			$billno2 = $res2['billnumber'];
			?>
			<tr bgcolor="">
			<td><?=$pno1?></td>
			<td><?=$res2['auto_number'];?></td>
			<td><?=$res2['patientcode'];?></td>
			<td><?=$res2['patientname'];?></td>
			<td><?=$res2['visitcode'];?></td>
			<td><?=$res2['billnumber'];?></td>
			<td><?=$res2['accountname'];?></td>
			<td><?=$res2['transactionamount'];?></td>
			</tr>
			<?php
		
			$pno1++;
			}
			?>
			<tr>

			<td colspan="9" bgcolor="#FFF">&nbsp;</td>
			</tr>
			<?php
			}
			
				}
				}	
			}	
				$pno=1;
		$query1 = "select auto_number,visitcode,subtype,count(visitcode) as visnos from master_transactionipcreditapproved where subtype='CASH' and  transactiondate between '$fromdate' and '$todate' and transactionamount <> '0.00' and billnumber like '%$searchbill%' and visitcode like '%$searchvisit%' group by visitcode having count(visitcode) > 1 order by auto_number ASC";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($exec1))
			{
			?>
			<tr>
			<td colspan="8" bgcolor="#FFF">Total  IP Credit Approved Duplicate Bills: <?=mysqli_num_rows($exec1);?></td>
			</tr>
			<?php
			while($res1=mysqli_fetch_array($exec1))
			{
			$visitcode1 = $res1['visitcode'];
			$auto_number1 = $res1['auto_number'];
			$visnos = $res1['visnos'];
			$pno1=1;
			$sno1=1;
			$query2 = "select auto_number,patientcode,patientname,visitcode,billnumber,accountname,transactionamount from master_transactionpaylater where visitcode like '$visitcode1' and transactiontype like 'finalize' and transactiondate between '$fromdate' and '$todate'  order by auto_number ASC";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			$visno =mysqli_num_rows($exec2);
			if($visno>0 && $visnos == $visno)
			{
			?>
			<tr bgcolor="#CCC">
			<td><?=$pno?></td>
			<td>Table ano</td>
			<td>Patient Code</td>
			<td>Patient Name</td>
			<td>Visit Code</td>
			<td>Bill Number</td>
			<td>Account Name</td>
			<td>Bill Amount</td>
			</tr>
			<?php
			while($res2=mysqli_fetch_array($exec2))
			{
			$patientcode = $res2['patientcode'];
			$visitcode = $res2['visitcode'];
			$billno2 = $res2['billnumber'];
			?>
			<tr bgcolor="">
			<td><?=$pno1?></td>
			<td><?=$res2['auto_number'];?></td>
			<td><?=$res2['patientcode'];?></td>
			<td><?=$res2['patientname'];?></td>
			<td><?=$res2['visitcode'];?></td>
			<td><?=$res2['billnumber'];?></td>
			<td><?=$res2['accountname'];?></td>
			<td><?=$res2['transactionamount'];?></td>
			</tr>
			<?php
			if($pno1!= '1')
			{
		
			$sno1++;
			
			}
			$pno1++;
			}
			?>
			<tr>
			<td colspan="8" bgcolor="#FFF">&nbsp;</td>
			<td align="center" valign="middle" style="color:<?= $color; ?>"><strong><button type="button" id="<?php echo $billno2; ?>"  onClick="funcdupupdate('<?php echo $billno2; ?>','<?php echo $visitcode; ?>','ip','<?php echo 'credit'; ?>')
" >Update</button></strong></td>
			</tr>
			<?php
			} 
			else
			{
			?>
			<tr bgcolor="#CCC">
			<td><?=$pno++?></td>
			<td>Table ano</td>
			<td>Patient Code</td>
			<td>Patient Name</td>
			<td>Visit Code</td>
			<td>Bill Number</td>
			<td>Account Name</td>
			<td>Bill Amount</td>
			</tr>
			<?php
			while($res2=mysqli_fetch_array($exec2))
			{
			$patientcode = $res2['patientcode'];
			$visitcode = $res2['visitcode'];
			$billno2 = $res2['billnumber'];
			?>
			<tr bgcolor="">
			<td><?=$pno1?></td>
			<td><?=$res2['auto_number'];?></td>
			<td><?=$res2['patientcode'];?></td>
			<td><?=$res2['patientname'];?></td>
			<td><?=$res2['visitcode'];?></td>
			<td><?=$res2['billnumber'];?></td>
			<td><?=$res2['accountname'];?></td>
			<td><?=$res2['transactionamount'];?></td>
			</tr>
			<?php
		
			$pno1++;
			}
			?>
			<tr>

			<td colspan="9" bgcolor="#FFF">&nbsp;</td>
			</tr>
			<?php
			}
			
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
                
              </tr>
            
          </tbody>
        </table></td>
      </tr>
	  <?php 
		  }
	
	  ?>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

