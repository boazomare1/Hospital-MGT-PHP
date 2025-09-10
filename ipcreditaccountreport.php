<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$tottransactionamount1 = '';
$registrationdate = '';
$packageanum1 = '';
$billtype = '';
$tottransactionamount = '';
$invoice_amt_total = 0;
$deposits_total = 0;
$outstanding_total = 0;
 $colorloopcount1 =0;
 $sno1 = 0;
 $transactionamount = '';
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 	$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 	$searchsuppliername =isset($_REQUEST['searchsuppliername '])?$_REQUEST['searchsuppliername ']:'';
?>
<style type="text/css">
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
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<link href="js/jquery-ui.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery-1.11.1.js"></script>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/datetimepicker_css.js"></script>
<script>
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
$(document).ready(function(){
	$( ".edititem" ).click(function() {
		var clickedid = $(this).attr('id');		
		//alert(clickedid);
		var current_expdate = $('tr#'+clickedid).find("div.txnno").text();		
		var current_txnno = $('tr#'+clickedid).find("div.mptxnno").text();
		$('tr#'+clickedid).find("td.txnno1").show();		
		$('tr#'+clickedid).find("td.mptxnno1").show();
		$('tr#'+clickedid).find("td.itemrateupdate").hide();	
		$('#txnno_'+clickedid).val(current_expdate);
		$('#mptxnno_'+clickedid).val(current_txnno);
		$('#s_'+clickedid).show();
		$('#ss_'+clickedid).show();
		return false;
	})	
	$( ".saveitem" ).click(function() {
		var clickedid = $(this).attr('id');
		var idstr = clickedid.split('s_');
		var id = idstr[1];
		var cdtxn_no= $('#txnno_'+id).val();
		//alert(cdtxn_no);
		var mptxn_no= $('#mptxnno_'+id).val().replace(/,/g, '');
		var mptxn_no_1= $('#mptxnno_'+id).val();
		//alert(mptxn_no);
		var autono=  $('#autono_'+id).val();
		var tablename=  $('#tablename_'+id).val();
		
		$.ajax({
		  url: 'ajax/ajaxeditipvisitlimit.php',
		  type: 'POST',
		  //async: false,
		  dataType: 'json',
		  //processData: false,    
		  data: { 
		      cdtxn_no: cdtxn_no, 
		      mptxn_no: mptxn_no,
			  autono: autono, 
			  tablename: tablename,
		      
		  },
		  success: function (data) { 
		  	//alert(data)
		  	var msg = data.msg;
		  	if(data.status == 1)
		  	{
			//alert(id);	
		  		$('tr#'+id).find("td.mptxnno1").hide();
				$('tr#'+id).find("td.txnno1").hide();
				$('tr#'+id).find("td.itemrateupdate").show();
				$('#caredittxno_'+id).text(mptxn_no_1);
				$('#s_'+id).hide();
				$('#ss_'+id).hide();
		  	}
		  	else
		  	{
		  		alert(msg);
		  	}
		  }
		});
		return false;
	})	
	
})
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
.style3 {
	COLOR: #3b3b3c;
	FONT-FAMILY: Tahoma;
	text-decoration: none;
	font-size: 11px;
	font-weight: bold;
}
</style>
</head>
<body>
 
<table width="98%" border="0" cellspacing="0" cellpadding="2">
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
    <td width="1%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1389">
        <form name="cbform1" method="post" action="ipcreditaccountreport.php">
        
          <table width="1000" border="0"  align="left" cellpadding="3" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
           <tr>
          <td colspan="2" bgcolor="#ecf0f5" class="bodytext31"><strong>Search IP Credit</strong></td>
            <td colspan="2" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
						
						
                  
                  </td> 
          </tr>
        
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Account </td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
              <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off"/>
              </td>
           </tr>
           <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="searchpatient" type="text" id="searchpatient" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			    <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Code</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="searchpatientcode" type="text" id="searchpatientcode" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visitcode</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="searchvisitcode" type="text" id="searchvisitcode" value="" size="50" autocomplete="off">
              </span></td>
              </tr>	
		   
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="24%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php if(isset($_REQUEST['ADate1'])){ echo $_REQUEST['ADate1']; }else { echo $paymentreceiveddatefrom; } ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="4%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="65%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php if(isset($_REQUEST['ADate2'])){ echo $_REQUEST['ADate2']; }else { echo $paymentreceiveddateto; } ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
					<tr>
  			  <td width="7%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="24%" align="left" valign="top"  bgcolor="#FFFFFF">
			 
				 <select name="location" id="location"  onChange=" ajaxlocationfunction(this.value);" >
                   <option value="All">All</option>
                      	<?php
						 $query01="select locationcode,locationname from master_location where status=''  group by locationcode";
						$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
						while($res01=mysqli_fetch_array($exc01))
						{?>
							<option value="<?= $res01['locationcode'] ?>" <?php if($location==$res01['locationcode']){ echo "selected";} ?>> <?= $res01['locationname'] ?></option>		
						<?php 
						}
						?>
                      </select>
					 
              </td>
			   <td align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
			  </tr>
						
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
            </tr>
			</table>
		
			</form>
		  </td>
      </tr>
</table></td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td>
      <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="100%" 
            align="left" border="0">
            <tbody>
            
             <tr>
              <td width="" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
					 <td width="" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Patient</strong></div></td>
				 <td width="" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Reg No</strong></div></td>
				
				 <td width="" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>IP Visit</strong></div></td>
				  <td width="" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">
                <div align="center"><strong>IP Date</strong></div></td>
                <td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Type</strong> </div></td>
                <td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Sub Type</strong> </div></td>
					 <td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bed No</strong> </div></td>
                
					 <td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
			<!--  <td width="9%"  align="right" valign="right"  bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Total Deposits </strong></div></td> -->
			<td width=""  align="right" valign="right" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Invoice Amount</strong></div></td>
            <td width=""  align="right" valign="right" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Deposits</strong></div></td>
				    <td width=""  align="right" valign="right"  bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Outstanding</strong></div></td>
					
					<td width=""  align="right" valign="right"  bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Pre Auth</strong></div></td>
					
					<td width=""  align="right" valign="right"  bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Visit Limit</strong></div></td>
					
				<td width="" bgcolor="#ffffff" class="bodytext3"><div align="center"><strong>Update Limit</strong></div></td>
				 <td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Interim</strong></div></td>
               
              </tr>
               </tbody>
			  <?php 
			   if (isset($_POST["cbfrmflag1"])) { $cbfrmflag1 = $_POST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
                 if($cbfrmflag1== 'cbfrmflag1')
				 {
			if($locationcode1=='All')
			{
			$pass_location = "locationcode !=''";
			}
			else
			{
			$pass_location = "locationcode ='$locationcode1'";
			}		 
					 
					 
					 
					$transactiondatefrom = $_REQUEST['ADate1'];
					$transactiondateto = $_REQUEST['ADate2'];
					$searchpatient = $_REQUEST['searchpatient'];
					$searchpatientcode = $_REQUEST['searchpatientcode'];
					$searchvisitcode = $_REQUEST['searchvisitcode'];

$query34 = "SELECT * from ip_bedallocation where  recorddate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and $pass_location and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and visitcode NOT IN (select visitcode from billing_ip) and visitcode NOT IN (select visitcode from billing_ipcreditapproved)";
		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $num1 = mysqli_num_rows($exec34);
		   while($res34 = mysqli_fetch_array($exec34))
		   {
		   $patientname = $res34['patientname'];
		   $patientcode = $res34['patientcode'];
		  $visitcode = $res34['visitcode'];
		   $docnumberr = $res34['docno'];
		   
		   $query36 = "select * from ip_bedtransfer where patientcode= '$patientcode' and visitcode='$visitcode'  and $pass_location  order by auto_number desc ";
		   $exec36 = mysqli_query($GLOBALS["___mysqli_ston"], $query36) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $num36 = mysqli_num_rows($exec36);
		   $res36 = mysqli_fetch_array($exec36);
		   $nbed = $res36['bed'];
		   
           $query35 = "select * from ip_bedallocation where patientcode= '$patientcode' and visitcode='$visitcode' and docno = '$docnumberr' and paymentstatus = '' and creditapprovalstatus = ''  ";
		   $exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res35 = mysqli_fetch_array($exec35);
		   $bednumber = $res35['bed'];
		   $paymentstatus = $res35['paymentstatus'];
		   $creditapprovalstatus = $res35['creditapprovalstatus'];
		   
		     
		   if($num36 > 0)
		     {
			   $bednumber = $nbed; 
			  }
		   
		   $query50 = "select * from master_bed where auto_number='$bednumber'";
		                  $exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						  $res50 = mysqli_fetch_array($exec50);
						  $bednames = $res50['bed'];
		 
		  
			include ('ipcreditaccountreport3_ipcredit.php');
			// $total = $overalltotal;
			$total = 0;
		//echo  $overalltotal;
			  // $overalltotal12=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totaldiscountamount+$totalmiscbillingamount-$totaldepositamount-$totalnhifamount+$totaldepositrefundamount);
		   $query82 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'  and $pass_location ";
		   $exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res82 = mysqli_fetch_array($exec82);
		   $accountname = $res82['accountfullname'];
		   $registrationdate = $res82['registrationdate'];
		   $billtype = $res82['billtype'];
		   $overalllimit = $res82['overalllimit'];
		   $patienttype=$res82['type'];
		   $subtype=$res82['subtype'];
		   
		   $visitlimit=$res82['visitlimit'];
		   
		   $auto_number=$res82['auto_number'];
		   
		   $preauth_ref=$res82['preauth_ref'];
		   $query_subtypename = "SELECT subtype from master_subtype where auto_number = '".$subtype."'";
		   	$exec_subtypename = mysqli_query($GLOBALS["___mysqli_ston"], $query_subtypename) or die ("Error in query_subtypename".mysqli_error($GLOBALS["___mysqli_ston"]));
			$ressubtypename = mysqli_fetch_array($exec_subtypename);
			$subtypename=$ressubtypename['subtype'];
		   //$consultationfee = $res82['admissionfees'];
		   
		     $query83 = "select sum(transactionamount) from master_transactionipdeposit where patientcode='$patientcode' and visitcode='$visitcode'  and recordstatus ='' and $pass_location";
		     $exec83 = mysqli_query($GLOBALS["___mysqli_ston"], $query83) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		     $res83 = mysqli_fetch_array($exec83);
			$transactionamount = $res83['sum(transactionamount)'];
			
			$tottransactionamount = $tottransactionamount + $transactionamount;
			$tottransactionamount1 = $tottransactionamount1 + $total;
			  
		    $colorloopcount1 = $colorloopcount1 + 1;
			$showcolor1 = ($colorloopcount1 & 1); 
			if ($showcolor1 == 0)
			{
				//echo "if";
				$colorcode1 = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode1 = 'bgcolor="#ecf0f5"';
			}
			$invoice_amt_total += $overalltotal+($totaldepositamount-$totaldepositrefundamount);
			$deposits_total +=($totaldepositamount-$totaldepositrefundamount);
			$outstanding_total +=$overalltotal;
$sno1 = $sno1 + 1
			?>
			  <tr <?php echo $colorcode1; ?> id="<?php echo $sno1;?>"> 
             <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno1; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $patientname; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $patientcode; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $visitcode; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $registrationdate; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $patienttype; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $subtypename; ?></div></td>
               
               
			   <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $bednames; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $accountname; ?></div></td>
			 <!--  <td class="bodytext31" valign="right"  align="right"><div align="right"><?php //echo number_format($transactionamount,2,'.',','); ?></div></td> -->
						<td class="bodytext31" valign="right"  align="right"><div align="right"><?php echo number_format($overalltotal+($totaldepositamount-$totaldepositrefundamount),2,'.',','); ?></div></td>
			<td class="bodytext31" valign="right"  align="right"><div align="right"><?php echo number_format(($totaldepositamount-$totaldepositrefundamount),2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="right"  align="right"><div align="right"><?php echo number_format($overalltotal,2,'.',',');  ?></div></td>
			 
			 <td class="bodytext31" valign="right"  align="right"><div align="right"><?php echo $preauth_ref;  ?></div></td>
			 
		
			 
			 <td class="bodytext31 itemrateupdate" valign="center"  align="right"><div class="mptxnno" id="caredittxno_<?php echo $sno1;?>"><?php echo number_format($visitlimit);  ?></div></td>
			 <td  style="display:none;" class="txnno1" width="123" align="left" valign="center"   class="bodytext31">
			<div bgcolor="#ffffff"><input class="mptxnno1"  id="mptxnno_<?php  echo $sno1;?>" name="mptxnno[]" style="border: 1px solid #001E6A" value=""  size="10"    /> 
			<input type="hidden" id="tablename_<?php echo $sno1;?>" name="tablename_<?php echo $sno1;?>" value="<?php echo 'master_ipvisitentry';?>"/>
			<input type="hidden" name="autono[]" id="autono_<?php echo $sno1;?>" value="<?php echo $auto_number ?>" /></div>
			</td>
			<td align="left" valign="center"  class="bodytext31 itemrateupdate"><div class="bodytext31">
			<div align="center" ><a class="edititem" id="<?php echo $sno1; ?>" href="" style="padding-right: 10px;">Edit</a> </div>   </div></td>
			<td align="left" valign="center" style="display:none;" id="ss_<?php echo $sno1; ?>"  class="bodytext31"><div class="bodytext31"> <div align="center">
			<a style="display:none;" class="saveitem" id="s_<?php echo $sno1; ?>" href="" >Update</a>
			</div>  </div></td>
			 <td width="4%"  align="center" valign="center" class="bodytext31"><div align="center"><a target="_blank" href="ipinteriminvoiceserver.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><strong>View</strong></a> </div></td>
			  </tr>
			 
		   <!-- <tr>
		   
           <td class="bodytext31" valign="center"  align="center" colspan="9"></td>
           <td class="bodytext31" valign="center" >
           <div align="center"><strong>
		   <?php //echo number_format($tottransactionamount,2,'.',','); ?></strong></div>
           </td>
          
		   <td class="bodytext31" valign="center"  align="right"><div align="center"><strong><?php echo number_format($tottransactionamount1,2,'.',','); ?></strong></div></td>
         </tr> -->
 <?php
			  } ?>
			  <tr> 
              <td colspan="8" class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5">&nbsp;</td>
              <td colspan="1" class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5"><b>Total : </b></td>
              <td colspan="1" class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5"><b><?php echo number_format($invoice_amt_total,2,'.',',');  ?></b></td>
              <td colspan="1" class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5"><b><?php echo number_format($deposits_total,2,'.',',');  ?></b></td>
              <td colspan="1" class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5"><b><?php echo number_format($outstanding_total,2,'.',',');  ?></b></td>
               <td colspan="1" class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5">&nbsp;</td>
           	 
              
             <td width="7%"  align="left" valign="center" bgcolor="" class="bodytext31">
             <a href="ipcreditaccountreport_xl.php?locationcode=<?= $location; ?>&&transactiondatefrom=<?=$_REQUEST['ADate1']; ?>&&transactiondateto=<?=$_REQUEST['ADate2']; ?>&&searchpatient=<?php echo $searchpatient; ?>&&searchpatientcode=<?php echo $searchpatientcode; ?>&&searchvisitcode=<?php echo $searchvisitcode; ?>" target="_blank"> <img src="images/excel-xls-icon.png" width="30" height="30" /> </a>
               </td> 
           </tr>
			 
				<?php }
			  ?>
		 
          </tbody>
		  
        </table>
		</td>
        </tr>
	 
	  
    </table>
<?php include ("includes/footer1.php"); ?>
<script>
$('input.mptxnno1').keyup(function(event) {
  // skip for arrow keys
  if(event.which >= 37 && event.which <= 40) return;
  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "")
    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    ;
  });
});	
</script>
</body>
</html>