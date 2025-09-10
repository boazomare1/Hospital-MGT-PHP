<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

$colorloopcount = '';
$sno = '';
$snocount = '';

 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}

if (isset($_REQUEST["billtype"])) { $billtype = $_REQUEST["billtype"]; } else { $billtype = ""; }
if (isset($_REQUEST["searchpatient"])) { $searchpatient = $_REQUEST["searchpatient"]; } else { $searchpatient = ""; }
if (isset($_REQUEST["searchpatientcode"])) { $searchpatientcode = $_REQUEST["searchpatientcode"]; } else { $searchpatientcode = ""; }
if (isset($_REQUEST["searchvisitcode"])) { $searchvisitcode = $_REQUEST["searchvisitcode"]; } else { $searchvisitcode = ""; }

if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }

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
	$transactiondatefrom = date('Y-m-d');
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



function funcBill()
{
if((document.getElementById("billtype").value == "")||(document.getElementById("billtype").value == " "))
{
alert('Please Select Bill');
return false;
}
}
</script>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>

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
<script>
function myFunction()
{
	if(document.getElementById("billtype").value == '')
	{
	alert("Please Select Deposit Type");
	document.getElementById("billtype").focus();
	return false;
	}
}
</script>

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="1320" border="0" cellspacing="0" cellpadding="2">
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
    <td width="99%" valign="top"><table width="1350" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
              <form name="cbform1" method="post" action="reprintsglobal.php">
                <table width="815" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Bill Reprints </strong></td>
                      <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                     <!--<td colspan="2" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                 <?php /*?> <?php
						
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
						?><?php */?>
						
						
                  
                  </td>--> 
                    </tr>
                    <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">Select</td>
                      <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><strong>
                        <select name="billtype" id="billtype" >
                          <option value="">Select Bill</option>
                          <option value="1" <?php if($billtype==1) echo 'selected'; ?>>Consultation</option>
						  <option value="2" <?php if($billtype==2) echo 'selected'; ?>>Bill Paynow</option>
						  <option value="3" <?php if($billtype==3) echo 'selected'; ?>>Paynow Refund</option>
						  <option value="4" <?php if($billtype==4) echo 'selected'; ?>>Consultation Refund</option>
						  <option value="5" <?php if($billtype==5) echo 'selected'; ?>>External Bill</option>
						  <option value="6" <?php if($billtype==6) echo 'selected'; ?>>Advance Deposit</option>
						  <option value="7" <?php if($billtype==7) echo 'selected'; ?>>IP Deposit</option>
						  <option value="8" <?php if($billtype==8) echo 'selected'; ?>>IP Final & Credit Approved</option> 
						  <!--<option value="8a" >Old IP Final</option> -->
						  <option value="9" <?php if($billtype==9) echo 'selected'; ?>>Bill Paylater</option> 
                          <!-- <option value="16" <?php if($billtype==16) echo 'selected'; ?>>OP Credit</option> -->
                          <option value="161" <?php if($billtype==161) echo 'selected'; ?>>Cr/Dr Notes</option>
						 <!-- <option value="10" <?php if($billtype==10) echo 'selected'; ?>>IP Credit Approved</option> -->
						  <!--<option value="10a" >Old IP Credit Approved</option> -->
						  <option value="11" <?php if($billtype==11) echo 'selected'; ?>>IP Receipts</option>
						  <!--<option value="12" >Sick Leave</option>
						  <option value="13" >Discharge Summary</option>-->
						  <option value="14" <?php if($billtype==14) echo 'selected'; ?>>Manual LPO</option>
						  <option value="15" <?php if($billtype==15) echo 'selected'; ?>>Misc Receipt</option>
						  <!-- <option value="17" <?php if($billtype==17) echo 'selected'; ?>>IP Credit Note</option> -->
						  <!-- <option value="18" <?php if($billtype==18) echo 'selected'; ?>>IP Debit Note</option> -->
                          <option value="19" <?php if($billtype==19) echo 'selected'; ?>>Expenses</option>
                          <option value="20" <?php if($billtype==20) echo 'selected'; ?>>Account Receivable</option>
                          <option value="21" <?php if($billtype==21) echo 'selected'; ?>>Receipts Entry</option>
                          <option value="22" <?php if($billtype==22) echo 'selected'; ?>>Payment Voucher</option>
						  <option value="23" <?php if($billtype==22) echo 'selected'; ?>>Deposit Refund</option>
                        </select>
                      </strong></td>
                      <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
                      <td align="left" valign="center"  bgcolor="#FFFFFF">&nbsp;</td>
                    </tr>
					 <tr>
                      <td class="bodytext31" valign="center"  align="left" 
               		 bgcolor="#FFFFFF"> Patient Name </td>
                      <td colspan="3" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input type="text" name="searchpatient" id="searchpatient" value="<?php echo $searchpatient; ?>" size="50" /></td>
                    </tr>
					<tr>
                      <td class="bodytext31" valign="center"  align="left" 
               		 bgcolor="#FFFFFF"> Patient Code </td>
                      <td colspan="3" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input type="text" name="searchpatientcode" id="searchpatientcode" value="<?php echo $searchpatientcode; ?>" size="50" /></td>
                    </tr>
					<tr>
                      <td class="bodytext31" valign="center"  align="left" 
               		 bgcolor="#FFFFFF"> Visit Code </td>
					 
                      <td colspan="3" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input type="text" name="searchvisitcode" id="searchvisitcode" value="<?php echo $searchvisitcode; ?>" size="50" /></td>
                    </tr>
					
					<tr>
                      <td class="bodytext31" valign="center"  align="left" 
               		 bgcolor="#FFFFFF"> Bill Number </td>
					 
                      <td colspan="3" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input type="text" name="billnumber" id="billnumber" value="<?php echo $billnumber; ?>" size="50" /></td>
                    </tr>
					
					
                    <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
					<tr>
  			  <!--<td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
			 
				 <select name="location" id="location" onChange="ajaxlocationfunction(this.value);">
                    <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
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
					 
              </span></td>-->
			   <!--<td width="10%" align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>-->
			  </tr>
					
                    <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" onClick= "return funcBill();" value="Search" name="Submit" />
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1052" 
            align="left" border="0">
          <tbody>
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				?>
			<?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 1)
				{
			$query1 = "select * from billing_consultation where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billnumber like '%$billnumber%'  and billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));	
			$num1 = mysqli_num_rows($exec1);
			 ?> 	
			<tr>
				<td colspan="9" bgcolor="#ecf0f5" class="style3">Consultation Bills <?php echo '('.$num1.')'; ?> </td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Location Name</td>
               <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">&nbsp;</td>
            </tr>
             
            <?php
			 $query1 = "select * from billing_consultation where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billnumber like '%$billnumber%' and billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res1 = mysqli_fetch_array($exec1))
			 {
			$res1patientcode= $res1['patientcode'];
			$res1patientvisitcode= $res1['patientvisitcode'];
			$res1billdate= $res1['billdate'];
			$res1patientname= $res1['patientname'];
			$res1billnumber= $res1['billnumber'];
			$res1username= $res1['username'];
			$mainlocation= $res1['locationname'];
         	$locationcode = $res1["locationcode"];
			$locationcode1=$locationcode;
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d/m/Y',strtotime($res1billdate)); ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res1billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res1username); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $mainlocation; ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_consultationbill_dmp4inch1.php?locationcode=<?php echo $locationcode1; ?>&&billautonumber=<?php echo $res1billnumber; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } } ?>
		    
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				?>
			<?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 2)
				{
			$query2 = "select * from billing_paynow where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billno like '%$billnumber%'  and billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"])); 	
		    $num2 = mysqli_num_rows($exec2);
			 ?> 	
			<tr>
				<td colspan="9" bgcolor="#ecf0f5" class="style3">Bill Paynow <?php echo '('.$num2.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
                <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Location Name</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
			$query2 = "select * from billing_paynow where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billno like '%$billnumber%'  and billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res2 = mysqli_fetch_array($exec2))
			 {
			$res2patientcode= $res2['patientcode'];
			$res2patientvisitcode= $res2['visitcode'];
			$res2billdate= $res2['billdate'];
			$res2patientname= $res2['patientname'];
			$res2billnumber= $res2['billno'];
			$res2username= $res2['username'];
			$mainlocation= $res2['locationname'];
			$locationcode = $res2["locationcode"];
			$locationcode1=$locationcode;
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
			//checking for copay
			$query17 = "select * from master_visitentry where visitcode='$res2patientvisitcode' and patientcode='$res2patientcode'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res17 = mysqli_fetch_array($exec17);
			//$consultationfee=$res17['consultationfees'];
			//$consultationfee = number_format($consultationfee,2,'.','');
			//$viscode=$res17['visitcode'];
			//$consultationdate=$res17['consultationdate'];
			//$plannumber = $res17['planname'];
			 $planpercentage = $res17['planpercentage'];
			
			/*$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execplanname = mysql_query($queryplanname) or die ("Error in Queryplanname".mysql_error());
			$resplanname = mysql_fetch_array($execplanname);
		 	$planforall = $resplanname['forall'];*/
			?>
            
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d/m/Y',strtotime($res2billdate)); ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res2billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res2patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res2patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res2patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res2username); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $mainlocation; ?></td>
               <td class="bodytext31" valign="center"  align="left">
               <?php if($planpercentage==0){?>
               <a target="_blank" href="print_billpaynowbill_dmp4inch1.php?locationcode=<?php echo $locationcode1; ?>&&billautonumber=<?php echo $res2billnumber; ?>&&patientcode=<?php echo $res2patientcode; ?>"><strong>Bill Paynow</strong></a></td>
               
               <?php } else {?>
			    <a target="_blank" href="print_billpaynowbill_dmp4inch_copay.php?locationcode=<?php echo $locationcode1; ?>&&billautonumber=<?php echo $res2billnumber; ?>&&patientcode=<?php echo $res2patientcode; ?>"><strong>Bill Paynow</strong></a></td>
			   <?php }?>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_paynowsummary.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res2patientcode; ?>&&visitcode=<?php echo $res2patientvisitcode; ?>&&billautonumber=<?php echo $res2billnumber; ?>"><strong>Summary</strong></a></td>
               </tr>
		   <?php } } ?>
		   
		   <?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				?>
			<?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 3)
				{
			$query3 = "select * from refund_paynow where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billnumber like '%$billnumber%'   and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $num3 = mysqli_num_rows($exec3);
			 ?> 	
			<tr>
				<td colspan="9" bgcolor="#ecf0f5" class="style3">Paynow  Refund <?php echo '('.$num3.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
                <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Location Name</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">&nbsp;</td>

            </tr>
		   
		   <?php
			$query3 = "select * from refund_paynow where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billnumber like '%$billnumber%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res3 = mysqli_fetch_array($exec3))
			 {
			$res3patientcode= $res3['patientcode'];
			$res3patientvisitcode= $res3['visitcode'];
			$res3billdate= $res3['transactiondate'];
			$res3patientname= $res3['patientname'];
			$res3billnumber= $res3['billnumber'];
			$res3username= $res3['username'];
			$mainlocation= $res3['locationname'];
			$locationcode = $res3["locationcode"];
			$locationcode1=$locationcode;
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d/m/Y',strtotime($res3billdate)); ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res3billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res3patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res3patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res3patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res3username); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $mainlocation; ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_paynow_refund.php?locationcode=<?php echo $locationcode1; ?>&&billnumber=<?php echo $res3billnumber; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } } ?>
		   
		   <?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				?>
			<?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 4)
				{
			$query4 = "select * from refund_consultation where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billnumber like '%$billnumber%'  and billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $num4 = mysqli_num_rows($exec4);
			 ?> 	
			<tr>
				<td colspan="9" bgcolor="#ecf0f5" class="style3">Consultation Refund <?php echo '('.$num4.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
                <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Location Name</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
			$query4 = "select * from refund_consultation where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billnumber like '%$billnumber%' and billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res4 = mysqli_fetch_array($exec4))
			 {
			$res4patientcode= $res4['patientcode'];
			$res4patientvisitcode= $res4['patientvisitcode'];
			$res4billdate= $res4['billdate'];
			$res4patientname= $res4['patientname'];
			$res4billnumber= $res4['billnumber'];
			$res4username= $res4['username'];
			$mainlocation= $res4['locationname'];
			$locationcode = $res4["locationcode"];
			$locationcode1=$locationcode;
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d/m/Y',strtotime($res4billdate)); ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res4billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res4patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res4patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res4patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res4username); ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $mainlocation; ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_consultationrefund_dmp4inch1.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res4patientcode; ?>&&billautonumber=<?php echo $res4billnumber; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } }  ?>
		   
		   <?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				?>
			<?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 5)
				{
			$query5 = "select * from billing_external where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billno like '%$billnumber%'  and billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num5 = mysqli_num_rows($exec5);
	        ?> 	
			<tr>
				<td colspan="9" bgcolor="#ecf0f5" class="style3">External Bill <?php echo '('.$num5.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
                <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Location Name</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
			$query5 = "select * from billing_external where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billno like '%$billnumber%'  and billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res5 = mysqli_fetch_array($exec5))
			 {
			$res5patientcode= $res5['patientcode'];
			$res5patientvisitcode= $res5['visitcode'];
			$res5billdate= $res5['billdate'];
			$res5patientname= $res5['patientname'];
			$res5billnumber= $res5['billno'];
			$res5username= $res5['username'];
			$mainlocation= $res5['locationname'];
			$locationcode = $res5["locationcode"];
			$locationcode1=$locationcode;
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d/m/Y',strtotime($res5billdate)); ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res5billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res5patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res5patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res5patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res5username); ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $mainlocation; ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_external_bill.php?locationcode=<?php echo $locationcode1; ?>&&billnumber=<?php echo $res5billnumber; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } }  ?>
		   
		   <?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				?>
			<?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 6)
				{
				$query6 = "select * from master_transactionadvancedeposit where patientcode like '%$searchpatientcode%' and patientname like '%$searchpatient%' and docno like '%$billnumber%'  and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
				$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num6 = mysqli_num_rows($exec6);
			 ?> 	
			<tr>
				<td colspan="8" bgcolor="#ecf0f5" class="style3">Advance Deposit <?php echo '('.$num6.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
                <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Location Name</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFF6F" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
			$query6 = "select * from master_transactionadvancedeposit where patientcode like '%$searchpatientcode%' and patientname like '%$searchpatient%' and docno like '%$billnumber%'  and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res6 = mysqli_fetch_array($exec6))
			 {
			$res6patientcode= $res6['patientcode'];
			//$res6patientvisitcode= $res6['visitcode'];
			$res6billdate= $res6['transactiondate'];
			$res6patientname= $res6['patientname'];
			$res6billnumber= $res6['docno'];
			$res6username= $res6['username'];
			$mainlocation= $res6['locationname'];
			$locationcode = $res6["locationcode"];
			$locationcode1=$locationcode;
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
				$colorcode = 'bgcolor="#D3EEB6"';
			}
			?>
             
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d/m/Y',strtotime($res6billdate)); ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res6billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res6patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res6patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res6username); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $mainlocation; ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_advancedeposit_dmp4inch1.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res6patientcode; ?>&&billnumbercode=<?php echo $res6billnumber; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } }  ?>
		   
		   <?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				?>
			<?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 7)
				{
				$query7 = "select * from master_transactionipdeposit where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and docno like '%$billnumber%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num7 = mysqli_num_rows($exec7);
			 ?> 	
			<tr>
				<td colspan="9" bgcolor="#ecf0f5" class="style3">IP Deposit <?php echo '('.$num7.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
                <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Location Name</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFF6F" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
			$query7 = "select * from master_transactionipdeposit where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and docno like '%$billnumber%'  and transactiondate between '$transactiondatefrom' and '$transactiondateto' and transactionmodule = 'PAYMENT' order by auto_number desc ";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res7 = mysqli_fetch_array($exec7))
			 {
			$res7patientcode= $res7['patientcode'];
			$res7patientvisitcode= $res7['visitcode'];
			$res7billdate= $res7['transactiondate'];
			$res7patientname= $res7['patientname'];
			$res7billnumber= $res7['docno'];
			$res7username= $res7['username'];
			$mainlocation= $res7['locationname'];
			$locationcode = $res7["locationcode"];
			$locationcode1=$locationcode;
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d/m/Y',strtotime($res7billdate)); ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res7billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res7username); ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $mainlocation; ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_depositcollection_dmp4inch1.php?locationcode=<?php echo $locationcode1; ?>&&billnumbercode=<?php echo $res7billnumber; ?>&&patientcode=<?php echo $res7patientcode; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } }  ?>
		   
		    <?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				?>
			<?php if ($cbfrmflag1 == 'cbfrmflag1' && ($billtype== 8 || $billtype== '8a')) 
				{
				$query7 = "select * from master_transactionip where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billnumber like '%$billnumber%'  and transactiontype = 'finalize' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num7 = mysqli_num_rows($exec7);

				$query77 = "select * from master_transactionipcreditapproved where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billnumber like '%$billnumber%'  and transactiontype='finalize' and transactiondate between '$transactiondatefrom' and '$transactiondateto' group by billnumber order by auto_number desc ";
				$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num77 = mysqli_num_rows($exec77);
				$num7 =$num7+$num77;
			 ?> 	
			<tr>
				<td colspan="10" bgcolor="#ecf0f5" class="style3">IP Final <?php echo '('.$num7.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
			   <td width="7%" align="left" valign="center" bgcolor="#FFFFF6F" class="style3">Account</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
                <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Location Name</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">&nbsp;</td>
			  <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">&nbsp;</td>
             
            </tr>
		   
		   <?php
		    $query7 = "select patientcode,visitcode,transactiondate,patientname,billnumber,username,accountname,'ipfinal' as types,locationname,locationcode from master_transactionip where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billnumber like '%$billnumber%'  and transactiontype = 'finalize' and transactiondate between '$transactiondatefrom' and '$transactiondateto'  
		    union all
            select patientcode,visitcode,transactiondate,patientname,billnumber,username,accountname,'creadit' as types,locationname,locationcode from master_transactionipcreditapproved where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billnumber like '%$billnumber%'  and transactiontype='finalize' and transactiondate between '$transactiondatefrom' and '$transactiondateto' group by billnumber 
		   ";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res7 = mysqli_fetch_array($exec7))
			 {
			$res7patientcode= $res7['patientcode'];
			$res7patientvisitcode= $res7['visitcode'];
			$res7billdate= $res7['transactiondate'];
			$res7patientname= $res7['patientname'];
			$res7billnumber= $res7['billnumber'];
			$res7username= $res7['username'];
			$accname= $res7['accountname'];
			$mainlocation= $res7['locationname'];
			$locationcode = $res7["locationcode"];
			$locationcode1=$locationcode;
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d/m/Y',strtotime($res7billdate)); ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res7billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientvisitcode; ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $accname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res7username); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $mainlocation; ?></td>
				<?php
					if($billtype=="8a"){
				 ?>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_old_ipfinalinvoice1.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7patientvisitcode; ?>&&billnumber=<?php echo $res7billnumber; ?>"><strong>Print A4 </strong></a></td>
				<?php } else{ 
				if($res7['types']=='ipfinal') {
				?>				
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_ipfinalinvoice1.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7patientvisitcode; ?>&&billnumber=<?php echo $res7billnumber; ?>"><strong>Print A4 </strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_ipfinalinvoice_summary.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7patientvisitcode; ?>&&billnumber=<?php echo $res7billnumber; ?>"><strong>Summary</strong></a> </td>
			   <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="clearance_pdf.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7patientvisitcode; ?>&&billnumber=<?php echo $res7billnumber; ?>"><strong>Clearance</strong></a></td>
			   <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_dischargesummary.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7patientvisitcode; ?>"><strong>Discharge Summary</strong></a></td>
               <?php } else { ?>

			   <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_creditapproval.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7patientvisitcode; ?>&&billnumber=<?php echo $res7billnumber; ?>"><strong>Print</strong></a></td>

			   <?php
			   
			   $query_bill = "select accountnameano from master_transactionipcreditapproved where  billnumber = '$res7billnumber'  order by auto_number";
               $exec_bill = mysqli_query($GLOBALS["___mysqli_ston"], $query_bill) or die ("Error in query_bill".mysqli_error($GLOBALS["___mysqli_ston"]));
               $pno=1;
				while($res7_bill = mysqli_fetch_array($exec_bill))
				{
				?>
			   <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_creditapproval.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7patientvisitcode; ?>&&billnumber=<?php echo $res7billnumber; ?>&account=<?php echo $res7_bill["accountnameano"];?>"><strong>Account<?php echo $pno;?></strong></a></td>

			   <?php
				$pno++;
				}
				?>
			   <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="clearance_pdf.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7patientvisitcode; ?>&&billnumber=<?php echo $res7billnumber; ?>"><strong>Clearance</strong></a> </td>
                <td class="bodytext31" valign="center"  align="left">
			    <a target="_blank" href="print_dischargesummary.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7patientvisitcode; ?>"><strong>Discharge Summary</strong></a> </td>
				<?php
				}
				
				} ?>	
                  </tr>
		   <?php } }  ?>
		   
		   <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 9)
				{
				$query7 = "select a.* from billing_paylater as a,master_visitentry as b where a.patientcode like '%$searchpatientcode%' and a.visitcode like '%$searchvisitcode%' and a.patientname like '%$searchpatient%' and a.billno like '%$billnumber%' and a.patientcode <> '' and a.billdate between '$transactiondatefrom' and '$transactiondateto' and a.visitcode=b.visitcode order by a.auto_number desc ";
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num7 = mysqli_num_rows($exec7);
			 ?> 	
			<tr>
				<td colspan="9" bgcolor="#ecf0f5" class="style3">Bill Paylater <?php echo '('.$num7.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
                <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Location Name</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFF6F" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
		   // $query7 = "select * from billing_paylater where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billno like '%$billnumber%' and locationcode='$locationcode1' and patientcode <> '' and billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc "; 
			//$exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
			//$num7 = mysql_num_rows($exec7);
			while($res7 = mysqli_fetch_array($exec7))
			 {
			$res7patientcode= $res7['patientcode'];
			$res7patientvisitcode= $res7['visitcode'];
			$res7billdate= $res7['billdate'];
			$res7patientname= $res7['patientname'];
			$res7billnumber= $res7['billno'];
			$mainlocation= $res7['locationname'];
			$locationcode = $res7["locationcode"];
			$locationcode1=$locationcode;
			$query27 = "select * from master_transactionpaylater where  transactiontype='finalize' and billnumber='$res7billnumber'";
			$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res27 = mysqli_fetch_array($exec27);
			
			$res7username= $res27['username'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d/m/Y',strtotime($res7billdate)); ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res7billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res7username); ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $mainlocation; ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_paylater_detailed.php?locationcode=<?php echo $locationcode1; ?>&&billautonumber=<?php echo $res7billnumber; ?>"><strong>Print</strong></a></td>
			   <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_paylaterSummary.php?locationcode=<?php echo $locationcode1; ?>&&billautonumber=<?php echo $res7billnumber; ?>"><strong>Summary</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } }  ?>
		   
		   <?php if ($cbfrmflag1 == 'cbfrmflag1' && ($billtype== 10 || $billtype== '10a') )
				{
				$query7 = "select * from master_transactionipcreditapproved where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billnumber like '%$billnumber%'  and transactiontype='finalize' and transactiondate between '$transactiondatefrom' and '$transactiondateto' group by billnumber order by auto_number desc ";
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num7 = mysqli_num_rows($exec7);
			 ?> 	
			<tr>
				<td colspan="9" bgcolor="#ecf0f5" class="style3">IP Credit Approved <?php echo '('.$num7.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
                <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Location Name</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFF6F" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
		    $query7 = "select * from master_transactionipcreditapproved where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billnumber like '%$billnumber%' and transactiontype='finalize' and transactiondate between '$transactiondatefrom' and '$transactiondateto' group by billnumber order by auto_number desc ";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res7 = mysqli_fetch_array($exec7))
			 {
			$res7patientcode= $res7['patientcode'];
			$res7patientvisitcode= $res7['visitcode'];
			$res7billdate= $res7['transactiondate'];
			$res7patientname= $res7['patientname'];
			$res7billnumber= $res7['billnumber'];
			$res7username= $res7['username'];
			$mainlocation= $res7['locationname'];
			$locationcode = $res7["locationcode"];
			$locationcode1=$locationcode;
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d/m/Y',strtotime($res7billdate)); ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res7billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res7username); ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $mainlocation; ?></td>
				<?php
					if($billtype=="10a"){
				 ?>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_old_creditapproval.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7patientvisitcode; ?>&&billnumber=<?php echo $res7billnumber; ?>"><strong>Print</strong></a></td>
				<?php } else{ ?>				
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_creditapproval.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7patientvisitcode; ?>&&billnumber=<?php echo $res7billnumber; ?>"><strong>Print</strong></a></td>
				<?php } ?>	

               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } }  ?>
		   <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 11)
				{
				$query7 = "select * from master_transactionip where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billnumber like '%$billnumber%' and transactiontype = 'finalize' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num7 = mysqli_num_rows($exec7);
			 ?> 	
			<tr>
				<td colspan="9" bgcolor="#ecf0f5" class="style3">IP Final <?php echo '('.$num7.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
                <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Location Name</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFF6F" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
		    $query7 = "select * from master_transactionip where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billnumber like '%$billnumber%'  and transactiontype = 'finalize' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res7 = mysqli_fetch_array($exec7))
			 {
			$res7patientcode= $res7['patientcode'];
			$res7patientvisitcode= $res7['visitcode'];
			$res7billdate= $res7['transactiondate'];
			$res7patientname= $res7['patientname'];
			$res7billnumber= $res7['billnumber'];
			$res7username= $res7['username'];
			$mainlocation= $res7['locationname'];
			$locationcode = $res7["locationcode"];
			$locationcode1=$locationcode;
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d/m/Y',strtotime($res7billdate)); ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res7billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res7username); ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $mainlocation; ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_ipfinal_dmp4inch1.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&billnumbercode=<?php echo $res7billnumber; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } }  ?>
		   
		   <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 12)
				{
				$query7 = "select * from sickleave_entry where  recorddate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num7 = mysqli_num_rows($exec7);
			 ?> 	
			<tr>
				<td colspan="6" bgcolor="#ecf0f5" class="style3">Sick Leave <?php echo '('.$num7.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFF6F" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
		    $query7 = "select * from sickleave_entry where  recorddate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res7 = mysqli_fetch_array($exec7))
			 {
			$res7patientcode= $res7['patientcode'];
			$res7visitcode= $res7['visitcode'];
			$res7billdate= $res7['recorddate'];
			$res7patientname= $res7['patientname'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d/m/Y',strtotime($res7billdate)); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_sickleave.php?patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7visitcode;?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } }  ?>
		      <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 13)
				{
				$query7 = "select * from dischargesummary where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%'  and summarydate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num7 = mysqli_num_rows($exec7);
			 ?> 	
			<tr>
				<td colspan="6" bgcolor="#ecf0f5" class="style3">Discharge Summary<?php echo '('.$num7.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Date</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
			  <td width="7%" align="left" valign="center" bgcolor="#FFFFF6F" class="style3">Visit No</td>
                <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Location Name</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              
            </tr>
		   
		   <?php
		    $query7 = "select * from dischargesummary where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%'  and summarydate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res7 = mysqli_fetch_array($exec7))
			 {
			$res7patientcode= $res7['patientcode'];
			$res7visitcode= $res7['patientvisitcode'];
			$res7billdate= $res7['summarydate'];
			$res7patientname= $res7['patientname'];
			$mainlocation= $res7['locationname'];
			$locationcode = $res7["locationcode"];
			$locationcode1=$locationcode;
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d/m/Y',strtotime($res7billdate)); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7visitcode; ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $mainlocation; ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_dischargesummary.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7visitcode; ?>"><strong>Print</strong></a></td>
               </tr>
		   <?php } }  ?>
		    <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 14)
				{
				$query7 = "select * from manual_lpo where  billnumber like '%$billnumber%'  and entrydate between '$transactiondatefrom' and '$transactiondateto' group by billnumber order by auto_number desc ";
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num7 = mysqli_num_rows($exec7);
			 ?> 	
			<tr>
				<td colspan="5" bgcolor="#ecf0f5" class="style3">Manual LPO<?php echo '('.$num7.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3"> PO No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Supplier</td>
                <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Location Name</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              
            </tr>
		   
		   <?php
		    $query7 = "select * from manual_lpo where  billnumber like '%$billnumber%' and entrydate between '$transactiondatefrom' and '$transactiondateto' group by billnumber order by auto_number desc ";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res7 = mysqli_fetch_array($exec7))
			 {
			
			
			$res7billdate= $res7['entrydate'];
			$res7billno= $res7['billnumber'];
			$res7supplier= $res7['suppliername'];
			$res7suppliercode = $res7['suppliercode'];
			$mainlocation= $res7['locationname'];
			$locationcode = $res7["locationcode"];
			$locationcode1=$locationcode;
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d/m/Y',strtotime($res7billdate)); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billno; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7supplier; ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $mainlocation; ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_localpurchaseorderm.php?locationcode=<?php echo $locationcode1; ?>&&billnumber=<?php echo $res7billno; ?>&&suppliercode=<?php echo $res7suppliercode; ?>"><strong>Print</strong></a></td>
               </tr>
		   <?php } }  ?>
		    <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 15)
				{
				$query7 = "select * from receiptsub_details where  docnumber like '%$billnumber%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' group by docnumber order by auto_number desc ";
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num7 = mysqli_num_rows($exec7);
			 ?> 	
			<tr>
				<td colspan="6" bgcolor="#ecf0f5" class="style3">Misc Receipt <?php echo '('.$num7.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3"> Doc No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Description</td>
			  <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Received From</td>
                <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Location Name</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              
            </tr>
		   
		   <?php
		    $query7 = "select * from receiptsub_details where  docnumber like '%$billnumber%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' group by docnumber order by auto_number desc ";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res7 = mysqli_fetch_array($exec7))
			 {
			
			$anum7 = $res7['auto_number'];
			$res7billdate= $res7['transactiondate'];
			$res7billno= $res7['docnumber'];
			$res7supplier= $res7['receiptsubname'];
			$receivedfrom = $res7['receivedfrom'];
			$mainlocation= $res7['locationname'];
			$locationcode = $res7["locationcode"];
			$locationcode1=$locationcode;
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d/m/Y',strtotime($res7billdate)); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billno; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7supplier; ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $receivedfrom; ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $mainlocation; ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="receipt_mis_print.php?locationcode=<?php echo $locationcode1; ?>&&receiptanum=<?php echo $anum7; ?>"><strong>Print</strong></a></td>
               </tr>
		   <?php } }  ?>
           <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 161)
				{
				$query7 = "SELECT auto_number as auto_number, patientcode as patientcode, billno as billno, visitcode as visitcode, billdate as billdate, patientname as patientname from refund_paylater where  billno like '%$billnumber%' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' group by billno  
				UNION ALL select auto_number as auto_number, patientcode as patientcode, billno as billno, visitcode as visitcode, billdate as billdate, patientname as patientname from ip_creditnote where  billno like '%$billnumber%' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' group by billno 
				UNION ALL select auto_number as auto_number, patientcode as patientcode, billno as billno, visitcode as visitcode, billdate as billdate, patientname as patientname from ip_debitnote where  billno like '%$billnumber%' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' group by billno
				UNION ALL SELECT auto_number as auto_number, patientcode as patientcode, docno as billno, patientvisitcode as visitcode, consultationdate as billdate, patientname as patientname from adhoc_creditnote where docno like '%$billnumber%' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' group by docno 
				UNION ALL SELECT auto_number as auto_number, patientcode as patientcode, docno as billno, patientvisitcode as visitcode, consultationdate as billdate, patientname as patientname from adhoc_debitnote where  docno like '%$billnumber%' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' group by docno 
				order by auto_number desc";
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num7 = mysqli_num_rows($exec7);
			 ?> 	
			<tr>
				<td colspan="7" bgcolor="#ecf0f5" class="style3">Cr/Dr Notes<?php echo '('.$num7.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
                <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Location Name</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              
            </tr>
		   
		   <?php
		    $query7 = "SELECT auto_number as auto_number, patientcode as patientcode, billno as billno, visitcode as visitcode, billdate as billdate, patientname as patientname from refund_paylater where  billno like '%$billnumber%' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' group by billno  
				UNION ALL select auto_number as auto_number, patientcode as patientcode, billno as billno, visitcode as visitcode, billdate as billdate, patientname as patientname from ip_creditnote where  billno like '%$billnumber%' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' group by billno 
				UNION ALL select auto_number as auto_number, patientcode as patientcode, billno as billno, visitcode as visitcode, billdate as billdate, patientname as patientname from ip_debitnote where  billno like '%$billnumber%' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' group by billno
				UNION ALL SELECT auto_number as auto_number, patientcode as patientcode, docno as billno, patientvisitcode as visitcode, consultationdate as billdate, patientname as patientname from adhoc_creditnote where  docno like '%$billnumber%' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' group by docno 
				UNION ALL SELECT auto_number as auto_number, patientcode as patientcode, docno as billno, patientvisitcode as visitcode, consultationdate as billdate, patientname as patientname from adhoc_debitnote where  docno like '%$billnumber%' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' group by docno 
				order by auto_number desc";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res7 = mysqli_fetch_array($exec7))
			 {
			
			$res7patientcode= $res7['patientcode'];
			$res7billno= $res7['billno'];
			$res7visitcode= $res7['visitcode'];
			$res7billdate= $res7['billdate'];
			$res7patientname= $res7['patientname'];
			$mainlocation= $res7['locationname'];
			$locationcode = $res7["locationcode"];
			$locationcode1=$locationcode;
		//	$res7username= $res7['username'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d/m/Y',strtotime($res7billdate)); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billno; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7visitcode; ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $mainlocation; ?></td>
               <?php //Cr.N-37-19	 
               $aa=explode("-",$res7billno);
               $a=$aa[0];
               if($a=='Cr.N'){ ?>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_paylaterrefund.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7visitcode; ?>&&billno=<?php echo $res7billno; ?>"><strong>Print</strong></a></td>
           		<?php }
           		if($a=='IPCr'){ ?>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_creditnote.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7visitcode; ?>&&billno=<?php echo $res7billno; ?>"><strong>Print</strong></a></td>
           		<?php }
           		if($a=='IPDr'){ ?>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_debitnote.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7visitcode; ?>&&billno=<?php echo $res7billno; ?>"><strong>Print</strong></a></td>
               	<?php }
           		if($a=='CRN'){ ?>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_adhoc_creditnote.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7visitcode; ?>&&billno=<?php echo $res7billno; ?>"><strong>Print</strong></a></td>
               	<?php }
           		if($a=='DBN'){ ?>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_adhoc_debitnote.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7visitcode; ?>&&billno=<?php echo $res7billno; ?>"><strong>Print</strong></a></td>
           
           <?php } ?>
               </tr>
		   <?php } }  ?>
		

           <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 17)
				{
				$query76 = "select * from ip_creditnote where billno like '%$billnumber%' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' group by billno order by auto_number desc ";
				$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die ("Error in query76".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num76 = mysqli_num_rows($exec76);
			 ?> 	
			<tr>
				<td colspan="7" bgcolor="#ecf0f5" class="style3">IP Credit Note<?php echo '('.$num76.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>

              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
                <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Location Name</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              
            </tr>
		   
		   <?php
		    $query7 = "select * from ip_creditnote where  billno like '%$billnumber%' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' group by billno order by auto_number desc ";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res7 = mysqli_fetch_array($exec7))
			 {
			
			$res7patientcode= $res7['patientcode'];
			$res7billno= $res7['billno'];
			$res7visitcode= $res7['visitcode'];
			$res7billdate= $res7['billdate'];
			$res7patientname= $res7['patientname'];
			$mainlocation= $res7['locationname'];
			$locationcode = $res7["locationcode"];
			$locationcode1=$locationcode;
		//	$res7username= $res7['username'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d/m/Y',strtotime($res7billdate)); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billno; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7visitcode; ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $mainlocation; ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_creditnote.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7visitcode; ?>&&billno=<?php echo $res7billno; ?>"><strong>Print</strong></a></td>
               </tr>
		   <?php } }  ?>

		<?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 18)
				{
				$query76 = "select * from ip_debitnote where  billno like '%$billnumber%' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' group by billno order by auto_number desc ";
				$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die ("Error in query76".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num76 = mysqli_num_rows($exec76);
			 ?> 	
			<tr>
				<td colspan="7" bgcolor="#ecf0f5" class="style3">IP Debit Note<?php echo '('.$num76.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>

              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
                <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Location Name</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              
            </tr>
		   
		   <?php
		    $query7 = "select * from ip_debitnote where  billno like '%$billnumber%' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' group by billno order by auto_number desc ";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res7 = mysqli_fetch_array($exec7))
			 {
			
			$res7patientcode= $res7['patientcode'];
			$res7billno= $res7['billno'];
			$res7visitcode= $res7['visitcode'];
			$res7billdate= $res7['billdate'];
			$res7patientname= $res7['patientname'];
			$mainlocation= $res7['locationname'];
			$locationcode = $res7["locationcode"];
			$locationcode1=$locationcode;
		//	$res7username= $res7['username'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d/m/Y',strtotime($res7billdate)); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billno; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7visitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $mainlocation; ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_debitnote.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7visitcode; ?>&&billno=<?php echo $res7billno; ?>"><strong>Print</strong></a></td>
               </tr>
		   <?php } }  ?>
           
           <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 19)
				{
				$queryn = "select * from  expensesub_details where chequenumber like '%$billnumber%' and chequedate between '$transactiondatefrom' and '$transactiondateto'  group by chequenumber order by auto_number desc ";
				$execn = mysqli_query($GLOBALS["___mysqli_ston"], $queryn) or die ("Error in queryn".mysqli_error($GLOBALS["___mysqli_ston"]));
				$numn = mysqli_num_rows($execn);
			 ?> 	
			<tr>
				<td colspan="7" bgcolor="#ecf0f5" class="style3">Expenses<?php echo '('.$numn.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>

              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Account</td>
                <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Location Name</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              
            </tr>
		   
		   <?php
		    $querynn = "select * from expensesub_details where  docnumber like '%$billnumber%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' group by chequenumber order by auto_number desc ";
			$execnn = mysqli_query($GLOBALS["___mysqli_ston"], $querynn) or die ("Error in querynn".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($resnn = mysqli_fetch_array($execnn))
			 {
				 $account=$resnn['expenseaccount'];
				 $cdate=$resnn['transactiondate'];
				 $cnumber=$resnn['docnumber'];
			   $mainlocation= $resnn['locationname'];
			   $locationcode = $resnn["locationcode"];
			  $locationcode1=$locationcode;
	
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d/m/Y',strtotime($cdate)); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $cnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $account; ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $mainlocation; ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_expense_receipt1.php?billnumber=<?php echo $cnumber; ?>"><strong>Print</strong></a></td>
               </tr>
		   <?php } }  ?>
           

           <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 20)
				{
				$queryn = "select * from  master_transactionpaylater where docno like '%$billnumber%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and docno like 'AR-%' and transactionstatus='onaccount' group by docno order by auto_number desc ";
				$execn = mysqli_query($GLOBALS["___mysqli_ston"], $queryn) or die ("Error in queryn".mysqli_error($GLOBALS["___mysqli_ston"]));
				$numn = mysqli_num_rows($execn);
			 ?> 	
			<tr>
				<td colspan="5" bgcolor="#ecf0f5" class="style3">Account Receivables<?php echo '('.$numn.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>

              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Account</td>
              
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              
            </tr>
		   
		   <?php
		    $querynn = "select * from master_transactionpaylater where docno like '%$billnumber%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and docno like 'AR-%' and transactionstatus='onaccount' group by docno order by auto_number desc ";
			$execnn = mysqli_query($GLOBALS["___mysqli_ston"], $querynn) or die ("Error in querynn".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($resnn = mysqli_fetch_array($execnn))
			 {
				 $account=$resnn['accountname'];
				 $cdate=$resnn['transactiondate'];
				 $cnumber=$resnn['docno'];
			
			
	
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d/m/Y',strtotime($cdate)); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $cnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $account; ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="printaccountrecievable.php?billnumber=<?php echo $cnumber; ?>"><strong>Print</strong></a></td>
               </tr>
		   <?php } }  ?>
           

           <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 21)
				{
				$queryn = "select * from  receiptsub_details where docnumber like '%$billnumber%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' group by docnumber order by auto_number desc ";
				$execn = mysqli_query($GLOBALS["___mysqli_ston"], $queryn) or die ("Error in queryn".mysqli_error($GLOBALS["___mysqli_ston"]));
				$numn = mysqli_num_rows($execn);
			 ?> 	
			<tr>
				<td colspan="5" bgcolor="#ecf0f5" class="style3">Receipts Entry<?php echo '('.$numn.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>

              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Account</td>
              
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              
            </tr>
		   
		   <?php
		    $querynn = "select * from receiptsub_details where docnumber like '%$billnumber%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' group by docnumber order by auto_number desc ";
			$execnn = mysqli_query($GLOBALS["___mysqli_ston"], $querynn) or die ("Error in querynn".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($resnn = mysqli_fetch_array($execnn))
			 {
				 $account=$resnn['receivedfrom'];
				 $cdate=$resnn['transactiondate'];
				 $cnumber=$resnn['docnumber'];
				 $canumber=$resnn['auto_number'];
		
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d/m/Y',strtotime($cdate)); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $cnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $account; ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="receipt_mis_print.php?receiptanum=<?php echo $canumber; ?>&locationcode=LTC-1"><strong>Print</strong></a></td>
               </tr>
		   <?php } }  ?>
           
            <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 22)
				{
				$queryn = "select * from  master_transactionpharmacy where billnumber like '%$billnumber%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and transactiontype = 'PURCHASE' and paymentvoucherno <> '' group by billnumber order by auto_number desc ";
				$execn = mysqli_query($GLOBALS["___mysqli_ston"], $queryn) or die ("Error in queryn".mysqli_error($GLOBALS["___mysqli_ston"]));
				$numn = mysqli_num_rows($execn);
			 ?> 	
			<tr>
				<td colspan="5" bgcolor="#ecf0f5" class="style3">Payment Voucher <?php echo '('.$numn.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>

              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Account</td>
              
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              
            </tr>
		   
		   <?php
		    $querynn = "select * from  master_transactionpharmacy where billnumber like '%$billnumber%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and transactiontype = 'PURCHASE' and paymentvoucherno <> '' group by billnumber order by auto_number desc ";
			$execnn = mysqli_query($GLOBALS["___mysqli_ston"], $querynn) or die ("Error in querynn".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($resnn = mysqli_fetch_array($execnn))
			 {
				 $account=$resnn['suppliername'];
				 $cdate=$resnn['transactiondate'];
				 $cnumber=$resnn['billnumber'];
				 $canumber=$resnn['auto_number'];
				 $suppliercode = $resnn['suppliercode'];
		
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d/m/Y',strtotime($cdate)); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $cnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $account; ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_payment1.php?billnumber=<?php echo $cnumber; ?>&&suppliercode=<?php echo $suppliercode; ?>&locationcode=LTC-1"><strong>Print</strong></a></td>
               </tr>
		   <?php } }  ?>

		   <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 23)
				{
				$queryn = "select * from  deposit_refund where docno like '%$billnumber%' and patientcode like '%$searchpatientcode%'  and patientname like '%$searchpatient%' and recorddate between '$transactiondatefrom' and '$transactiondateto' group by docno order by auto_number desc ";
				$execn = mysqli_query($GLOBALS["___mysqli_ston"], $queryn) or die ("Error in queryn".mysqli_error($GLOBALS["___mysqli_ston"]));
				$numn = mysqli_num_rows($execn);
			 ?> 	
			<tr>
				<td colspan="5" bgcolor="#ecf0f5" class="style3">Deposit Refund<?php echo '('.$numn.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>

              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              
            </tr>
		   
		   <?php
		    $querynn = "select * from deposit_refund where docno like '%$billnumber%' and patientcode like '%$searchpatientcode%'  and patientname like '%$searchpatient%' and recorddate between '$transactiondatefrom' and '$transactiondateto' group by docno order by auto_number desc ";
			$execnn = mysqli_query($GLOBALS["___mysqli_ston"], $querynn) or die ("Error in querynn".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($resnn = mysqli_fetch_array($execnn))
			 {
				 $cdate=$resnn['recorddate'];
				 $cnumber=$resnn['docno'];
				 $cname=$resnn['patientname'];
				 $ccode=$resnn['patientcode'];
				 $canumber=$resnn['auto_number'];
		
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d/m/Y',strtotime($cdate)); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $cnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $cname; ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $ccode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_depositerefunddetails_dmp4inch1.php?patientcode=<?php echo $ccode; ?>&billautonumber=<?php echo $cnumber; ?>"><strong>Print</strong></a></td>
               </tr>
		   <?php } }  ?>
		   
            <tr>
              <td colspan="2"  class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td width="1%" rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
			   </tr>          </tbody>
        </table></td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

