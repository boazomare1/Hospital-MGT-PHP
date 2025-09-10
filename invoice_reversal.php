<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
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
<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
<link href="js/jquery-ui.css" rel="stylesheet">
<script type="text/javascript">
function funcdupupdate(billnumber,visitcode,fromtype){
	
	$('#'+billnumber).attr("disabled", true);
	var check = confirm("Are you sure you want to Reverse the Invoice");
	if (check != true) {
	$('#'+billnumber).attr("disabled", false);
	return false;
	}
	if(billnumber !="" && visitcode != "" && fromtype != ""){
	 var data = "billnumber="+billnumber+"&&visitcode="+visitcode+"&&fromtype="+fromtype;
		$.ajax({
			type : "get",
			url : "ajaxearseinvoice.php",
			data : data,
			cache : false,
				success : function (data){
					if(data !=""){
						alert("Data Reversed Successfully ");
						 $('#itr'+billnumber).hide();
					} 
					else{
						alert("Data Not Reversed ");
					}    
				}
		});
	}  
 
}

function funcdupupdatedep(billnumber,visitcode,fromtype,sno){
	
	$('#'+billnumber).attr("disabled", true);
	var check = confirm("Are you sure you want to Reverse the Invoice");
	if (check != true) {
	$('#'+billnumber).attr("disabled", false);
	return false;
	}
	if(billnumber !="" && visitcode != "" && fromtype != ""){
	 var data = "billnumber="+billnumber+"&&visitcode="+visitcode+"&&fromtype="+fromtype;
		$.ajax({
			type : "get",
			url : "ajaxearseinvoice.php",
			data : data,
			cache : false,
				success : function (data){
					if(data !=""){
						alert("Data Reversed Successfully ");
						 $('#itr'+sno).hide();
					} 
					else{
						alert("Data Not Reversed ");
					}    
				}
		});
	}  
 
}

$(document).ready(function(){
	$( ".edititem" ).click(function() {
		var clickedid = $(this).attr('id');		
		//alert(clickedid);
		var current_expdate = $('tr'+'#itr'+clickedid).find("div.txnno").text();
		var current_txnno = $('tr'+'#itr'+clickedid).find("div.mptxnno").text();
		$('tr'+'#itr'+clickedid).find("td.txnno1").show();		
		$('tr'+'#itr'+clickedid).find("td.mptxnno1").show();
		$('tr'+'#itr'+clickedid).find("td.itemrateupdate").hide();	
		$('#txnno_'+clickedid).val(current_expdate);
		$('#mptxnno_'+clickedid).val(current_txnno);
		$('#s_'+clickedid).show();
		return false;
	})	
	$( ".saveitem" ).click(function() {
		var clickedid = $(this).attr('id');
		var idstr = clickedid.split('s_');
		var id = idstr[1];
		var cdtxn_no= $('#txnno_'+id).val();
		//alert(cdtxn_no);
		var mptxn_no= $('#mptxnno_'+id).val();
		//alert(mptxn_no);
		mptxn_no=mptxn_no.replace(/,/g,'');
		var autono=  $('#autono_'+id).val();
		var tablename=  $('#tablename_'+id).val();
		
		$.ajax({
		  url: 'ajax/ajaxeditdepamt.php',
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
		  		$('tr'+'#itr'+id).find("td.mptxnno1").hide();
				$('tr'+'#itr'+id).find("td.txnno1").hide();
				$('tr'+'#itr'+id).find("td.itemrateupdate").show();
				rateamt=parseFloat(mptxn_no).toFixed(2);
				rateamt = rateamt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				//alert(rateamt);
				$('#caredittxno_'+id).text(rateamt);
				$('#s_'+id).hide();
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
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
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
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	      
		<tr>
			<td width="400">
				<form name="cbform1" method="post" action="invoice_reversal.php">
					<table width="400" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
					<tbody>
					
					<tr>
					<td align="left" valign="middle" colspan="3"  bgcolor="" class="bodytext32"><strong>Invoice Reversal</strong></td>
					</tr>
					
					<tr>
					<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
					<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">Visitcode</td>
					<td colspan="" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
					<input name="visitcode" type="text" id="visitcode" value="" size="20" autocomplete="off">
					</span></td>
					</tr>
					
					<tr>
					<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
					<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">Bill No</td>
					<td colspan="" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
					<input name="billno" type="text" id="bill" value="" size="20" autocomplete="off">
					</span></td>
					</tr>
					
					<tr>
					<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
					<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
					<td colspan="" align="left" valign="top"  bgcolor="#FFFFFF">
					<input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
					<input  type="submit" value="Search" name="Submit" />
					<input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
					</tr>
					
					</tbody>
					</table>
				</form>		
			</td>
			<td width="400">
				<form name="cbform2" method="post" action="invoice_reversal.php">
					<table width="400" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
					<tbody>
					
					<tr>
					<td align="left" valign="middle" colspan="3"  bgcolor="" class="bodytext32"><strong>Deposit Reversal</strong></td>
					</tr>
					
					<tr>
					<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
					<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">Visitcode</td>
					<td colspan="" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
					<input name="dep_visitcode" type="text" id="dep_visitcode" value="" size="20" autocomplete="off">
					</span></td>
					</tr>
					
					<tr>
					<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
					<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">Bill No</td>
					<td colspan="" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
					<input name="dep_bill" type="text" id="dep_bill" value="" size="20" autocomplete="off">
					</span></td>
					</tr>
					
					<tr>
					<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
					<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
					<td colspan="" align="left" valign="top"  bgcolor="#FFFFFF">
					<input type="hidden" name="cbfrmflag2" value="cbfrmflag2">
					<input  type="submit" value="Search" name="Submit" />
					<input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
					</tr>
					
					</tbody>
					</table>
				</form>		
			</td>
		</tr>
		
		<tr>
		<td colspan="9">&nbsp;</td>
		</tr>

		<?php
		$colorloopcount=0;
		$sno=0;
		if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
		if ($cbfrmflag1 == 'cbfrmflag1')
		{
		$searchvisit=$_POST['visitcode'];
		$searchbill=$_POST['billno'];
		$sno = '';
		$showcolor='';
		$colorloopcount = '';
		?>
		<tr>
			<td width="99%" valign="top" colspan="2">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="70%" align="center" border="0">
							<tbody>
								<tr>
								<td colspan="8" bgcolor="#ecf0f5" class="bodytext32"><div align="left"><strong>Patient Detailed</strong></div></td>
								</tr>

								<tr bgcolor="#CCC">
									<td  class="bodytext32">Patient Code</td>
									<td  class="bodytext32">Patient Name</td>
									<td  class="bodytext32">Visit Code</td>
									<td  class="bodytext32">Bill Number</td>
									<td  class="bodytext32">Bill Amount</td>
									<td  class="bodytext32">Action</td>
								</tr>
								
								<?php
								if($searchbill!=''){
								$query1 = "
								select billno,auto_number,visitcode,patientcode,totalamount,patientname,'billing_ip' as fromtb from billing_ip where  totalamount <> '0.00' and billno = '$searchbill'
								UNION ALL 
								select billno,auto_number,visitcode,patientcode,totalamount,patientname,'billing_ipcreditapproved' as fromtb from billing_ipcreditapproved where  totalamount <> '0.00' and billno = '$searchbill'  ";
								}else{
								$query1 = "
								select billno,auto_number,visitcode,patientcode,totalamount,patientname,'billing_ip' as fromtb from billing_ip where  totalamount <> '0.00' and visitcode = '$searchvisit'
								UNION ALL 
								select billno,auto_number,visitcode,patientcode,totalamount,patientname,'billing_ipcreditapproved' as fromtb from billing_ipcreditapproved where  totalamount <> '0.00'  and visitcode = '$searchvisit' ";	
								}
								$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($res1=mysqli_fetch_array($exec1))
								{
								
								$billnumber1 = $res1['billno'];
								$auto_number1 = $res1['auto_number'];
								$visitcode = $res1['visitcode'];
								$patientcode = $res1['patientcode'];
								$totalamount = $res1['totalamount'];
								$patientname = $res1['patientname'];
								$fromtb = $res1['fromtb'];
							
								?>
								<tr id="itr<?php echo $billnumber1;?>">
									<td  class="bodytext32"><?=$res1['patientcode'];?></td>
									<td class="bodytext32" ><?=$res1['patientname'];?></td>
									<td  class="bodytext32"><?=$res1['visitcode'];?></td>
									<td  class="bodytext32"><?=$res1['billno'];?></td>
									<td  class="bodytext32"><?=number_format($res1['totalamount'],2);?></td>
									<td align="left" valign="middle" style="color:<?= $color; ?>"><strong><button type="button" id="<?php echo $billnumber1; ?>"  onClick="funcdupupdate('<?php echo $billnumber1; ?>','<?php echo $visitcode; ?>','<?php echo $fromtb; ?>')
									" >Reverse Invoice</button></strong></td>
								</tr>
								<?php
								}
								?>
								
								
		


							</tbody>
						</table>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<?php } ?>
		
		<?php
		$colorloopcount=0;
		$sno=0;
		if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
		if ($cbfrmflag2 == 'cbfrmflag2')
		{
		$dep_searchvisit=$_POST['dep_visitcode'];
		$dep_searchbill=$_POST['dep_bill'];
		$sno = '';
		$showcolor='';
		$colorloopcount = '';	
		?>
		<tr>
			<td width="99%" valign="top" colspan="2">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td >
						<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="70%" align="center" border="0">
							<tbody>
								<tr>
								<td colspan="8" bgcolor="#ecf0f5" class="bodytext32"><div align="left"><strong>Patient Detailed</strong></div></td>
								</tr>

								<tr bgcolor="#CCC">
									<td  class="bodytext32">Patient Code</td>
									<td  class="bodytext32">Patient Name</td>
									<td  class="bodytext32">Visit Code</td>
									<td  class="bodytext32" >Bill Number</td>
									<td  class="bodytext32"  align="right">Bill Amount</td>
									<td colspan="2" class="bodytext32"  align="center">Edit Amount</td>
									<td  class="bodytext32">Action</td>
								</tr>
								
								<?php
								if($dep_searchbill!=''){
								$query1 = "
								select docno,auto_number,visitcode,patientcode,transactionamount,patientname,'master_transactionipdeposit' as fromtb from master_transactionipdeposit where  transactionamount <> '0.00' and docno = '$dep_searchbill'";
								}else{
								$query1 = "
								select docno,auto_number,visitcode,patientcode,transactionamount,patientname,'master_transactionipdeposit' as fromtb from master_transactionipdeposit where  transactionamount <> '0.00' and visitcode = '$dep_searchvisit' ";	
								}
								$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($res1=mysqli_fetch_array($exec1))
								{
								
								$billnumber1 = $res1['docno'];
								$auto_number1 = $res1['auto_number'];
								$visitcode = $res1['visitcode'];
								$patientcode = $res1['patientcode'];
								$totalamount = $res1['transactionamount'];
								$patientname = $res1['patientname'];
								$fromtb = $res1['fromtb'];
								
								$query11 = "
								select auto_number from billing_ip where visitcode = '$visitcode'
								UNION ALL 
								select auto_number from billing_ipcreditapproved where  visitcode = '$visitcode'  ";
								$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
								$checknumfinal=mysqli_num_rows($exec11);
								if($checknumfinal==0){
								$sno+=1;
								?>
								<tr id="itr<?php echo $sno;?>">
									<td  class="bodytext32"><?=$res1['patientcode'];?></td>
									<td class="bodytext32" ><?=$res1['patientname'];?></td>
									<td  class="bodytext32"><?=$res1['visitcode'];?></td>
									<td  class="bodytext32"><?=$res1['docno'];?></td>
									<td class="bodytext32 itemrateupdate" valign="center"  align="right"><div class="mptxnno" id="caredittxno_<?php echo $sno;?>"><?=number_format($res1['transactionamount'],2);?></div></td>
									<td  style="display:none;" class="txnno1" width="123" align="left" valign="center"   class="bodytext32">
									<div bgcolor="#ffffff"><input class="mptxnno1" id="mptxnno_<?php  echo $sno;?>" name="mptxnno[]" style="border: 1px solid #001E6A" value=""  size="10"   onKeyDown="return number()" /> 
									<input type="hidden" id="tablename_<?php echo $sno;?>" name="tablename_<?php echo $sno;?>" value="<?php echo $fromtb;?>"/>
									<input type="hidden" name="autono[]" id="autono_<?php echo $sno;?>" value="<?php echo $billnumber1 ?>" /></div>
									</td>
									<td align="center" valign="center"  class="bodytext32 itemrateupdate"><div class="bodytext32">
									<div align="right" ><a class="edititem" id="<?php echo $sno; ?>" href="" style="padding-right: 10px;">Edit Amount</a> </div>   </div></td>
									<td align="left" valign="center"   class="bodytext32"><div class="bodytext32"> <div align="center">
									<a style="display:none;" class="saveitem" id="s_<?php echo $sno; ?>" href="" >Update</a>
									</div>  </div></td>
									<td align="left" valign="middle" style="color:<?= $color; ?>"><strong><button type="button" id="<?php echo $billnumber1; ?>"  onClick="funcdupupdatedep('<?php echo $billnumber1; ?>','<?php echo $visitcode; ?>','<?php echo $fromtb; ?>','<?php echo $sno; ?>')
									" >Reverse Deposit</button></strong></td>
								</tr>
								<?php
								}
								}
								?>
							</tbody>
						</table>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		
		<?php } ?>
	</table>
	</td>
	</tr>
	
</table>
</body>
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