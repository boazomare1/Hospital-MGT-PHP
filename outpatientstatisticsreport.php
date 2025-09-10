<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-2 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-2 month'));
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
$snocount = "";
$colorloopcount="";

 $locationdata=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 
 if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
 
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
 if ($cbfrmflag1 == 'cbfrmflag1')
{
	$paymentreceiveddatefrom =  $ADate1 ;
    $paymentreceiveddateto =  $ADate2;
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
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

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
.bali
{
text-align:right;
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
</style>

<script src="js/datetimepicker_css.js"></script>

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
    
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
              <form name="cbform1" id="cbform1" method="post" action="outpatientstatisticsreport.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>OP Statistics By Fee Type</strong></td>
              
              </tr>
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->
           
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
			  <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
			 
				 <select name="location" id="location" onChange="ajaxlocationfunction(this.value)">
                 
                  <option value="all" >All</option>
                   <?php
						
						$query1="select locationcode,locationname from master_employeelocation where username ='$username' group by locationcode order by locationname ";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$loccode=array();
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$locationname = $res1["locationname"];
						$locationcode = $res1["locationcode"];
						
						?>
						 <option value="<?php echo $locationcode; ?>" <?php if($locationdata!='')if($locationdata==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>
						<?php
						} 
						?>
                      </select>
					 
              </span></td>
              
			   <td width="10%" align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              </tr>
					
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
			  <input  type="submit" id="toggleButton" value="Search" name="Submit" onClick="hideTable(true);"/>
			  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" />
			 </td>
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="992" 
            align="left" border="0">
          <tbody>
<tr bgcolor="#011E6A">
                <td bgcolor="#ecf0f5" class="bodytext3" colspan="5"></td>
                <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                <td bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
              </tr>
            
			<?php


			 if ($cbfrmflag1 == 'cbfrmflag1')
				{
					
					if($locationdata=="all"){
						
				$query0001="select locationcode,locationname from master_employeelocation where username ='$username' group by locationcode order by locationname ";		
				$exec0001 = mysqli_query($GLOBALS["___mysqli_ston"], $query0001) or die ("Error in Query01".mysqli_error($GLOBALS["___mysqli_ston"]));
			//	$loccode=array();
				while ($res0001 = mysqli_fetch_array($exec0001))
				{
						$locationname = $res0001["locationname"];
						$locationcode = $res0001["locationcode"];
						
						
						
					?>
                    <tr <?php //echo $colorcode; ?>>
            <!--  <td colspan="3" class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong><?php //echo $locationname; ?></strong></td>-->
               <td  colspan="9" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong><?php echo $locationname; ?></strong></td>
		   </tr>
                    <tr>
              <td width="3%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
              <td width="21%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Consultation Type</strong></div></td>
              <td width="13%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong> Department </strong></td>
              <td width="8%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong> Cash </strong></td>
              <td width="8%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Direct Credit</strong></div></td>
              <td width="9%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Insurance</strong></div></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="style1">Prepaid</td>
              <td width="6%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Staff </strong></div></td>
              <td width="8%" align="right" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Total</strong></div></td> 
            </tr>
                    <?php	
			
			
			
					
					$tot_cash = 0.00;
					$tot_insurance = 0.00;
					$tot_credit = 0.00;
					$tot_staff = 0.00;
					$tot_prepaid = 0.00;
					$wholetotal = 0.00;
					
					$location=$locationcode;
					
                    $query01="select locationname from master_employeelocation where locationcode ='$location' ";		
					$exec01 = mysqli_query($GLOBALS["___mysqli_ston"], $query01) or die ("Error in Query01".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res01 = mysqli_fetch_array($exec01);
					$locationname = $res01["locationname"];	
					?>
              
					<?php
							
		  $query1 = "select consultationtype,department,auto_number from master_consultationtype where locationcode = '$location'";
		  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res1 = mysqli_fetch_array($exec1))
		  {
		  $res1consultationtype = $res1['consultationtype'];
		  $res1department = $res1['department'];
		  $res1auto_number = $res1['auto_number'];
          
		  $query3 = "select locationcode from master_visitentry where locationcode = '$location' and consultationtype = '$res1auto_number' and department = '$res1department' and paymenttype ='1' and consultationdate between '$ADate1' and '$ADate2'";
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num1 = mysqli_num_rows($exec3);
		  
		  $query6 = "select locationcode from master_visitentry where locationcode = '$location' and consultationtype = '$res1auto_number' and department = '$res1department' and paymenttype ='2' and consultationdate between '$ADate1' and '$ADate2' ";
		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num2 = mysqli_num_rows($exec6);
		  
		  /* $query7 = "select * from master_visitentry where consultationtype = '$res1auto_number' and department = '$res1department' and paymenttype ='3' and consultationdate between '$ADate1' and '$ADate2' ";
		  $exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
		  $num3 = mysql_num_rows($exec7);
		  $res7 = mysql_fetch_array($exec7);*/
		  
		  $query8 = "select locationcode from master_visitentry where locationcode = '$location' and consultationtype = '$res1auto_number' and department = '$res1department' and paymenttype ='3' and consultationdate between '$ADate1' and '$ADate2' ";
		  $exec8= mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num4 = mysqli_num_rows($exec8);
		  
		  $query9 = "select locationcode from master_visitentry where locationcode = '$location' and consultationtype = '$res1auto_number' and department = '$res1department' and paymenttype ='5' and consultationdate between '$ADate1' and '$ADate2' ";
		  $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num5 = mysqli_num_rows($exec9);
			  
		  $query10 = "select locationcode from master_visitentry where locationcode = '$location' and consultationtype = '$res1auto_number' and department = '$res1department' and paymenttype ='7' and consultationdate between '$ADate1' and '$ADate2' ";
		  $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num7 = mysqli_num_rows($exec10);

		 		  
		  $query4 = "select department from master_department where auto_number = '$res1department'";
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res4 = mysqli_fetch_array($exec4);
		  $res4department = $res4['department'];
		  
		  $query5 = "select department from master_department where auto_number = '$res1department'";
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res5 = mysqli_fetch_array($exec5);
		  $res5department = $res5['department'];
		  
		  $total = $num1 + $num2 + $num4 +$num5 + $num7;
		  if($total != '0')
		  {
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
           <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res1consultationtype; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res4department; ?></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($num1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($num2,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($num4,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right"><?php echo number_format($num7,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($num5,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($total,2,'.',','); ?></strong></div></td>
           </tr>
		   <?php 
		   
		   $tot_cash=$tot_cash+$num1;
			$tot_insurance=$tot_insurance+$num2;
			$tot_credit=$tot_credit+$num4;
			$tot_staff=$tot_staff+$num5;
			$tot_prepaid=$tot_prepaid+$num7;
			$wholetotal=$wholetotal+$total;
			} 
			
        
			}?>
		    
             <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><strong>Total</strong></div></td>
               <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><strong></strong></div></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><strong></strong></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_cash,2,'.',','); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_insurance,2,'.',','); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_credit,2,'.',','); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="right"><?php echo number_format($tot_prepaid,2,'.',','); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_staff,2,'.',','); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($wholetotal,2,'.',','); ?></strong></div></td>
           </tr>
            <?php
				}
					}
					
				if($locationdata!='all')	
				{
					
					$tot_cash = 0.00;
					$tot_insurance = 0.00;
					$tot_credit = 0.00;
					$tot_staff = 0.00;
					$tot_prepaid = 0.00;
					$wholetotal = 0.00;
					
                    $query01="select locationname from master_employeelocation where locationcode ='$locationdata' ";		
					$exec01 = mysqli_query($GLOBALS["___mysqli_ston"], $query01) or die ("Error in Query01".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res01 = mysqli_fetch_array($exec01);
					$locationname = $res01["locationname"];	
					?>
                    <tr <?php //echo $colorcode; ?>>
               <td  colspan="9" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong><?php echo $locationname; ?></strong></td>
		   </tr>
					<tr>
              <td width="3%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
              <td width="21%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Consultation Type</strong></div></td>
              <td width="13%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong> Department </strong></td>
              <td width="8%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong> Cash </strong></td>
              <td width="8%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Direct Credit</strong></div></td>
              <td width="9%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Insurance</strong></div></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><span class="style1">Prepaid</span></td>
              <td width="6%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Staff </strong></div></td>
              <td width="8%" align="right" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Total</strong></div></td> 
            </tr>
					
					<?php
							
		  $query1 = "select consultationtype,department,auto_number from master_consultationtype where locationcode = '$locationdata'";
		  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res1 = mysqli_fetch_array($exec1))
		  {
		  $res1consultationtype = $res1['consultationtype'];
		  $res1department = $res1['department'];
		  $res1auto_number = $res1['auto_number'];
          
		  $query3 = "select locationcode from master_visitentry where locationcode = '$locationdata' and consultationtype = '$res1auto_number' and department = '$res1department' and paymenttype ='1' and consultationdate between '$ADate1' and '$ADate2'";
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num1 = mysqli_num_rows($exec3);
		  
		  $query6 = "select locationcode from master_visitentry where locationcode = '$locationdata' and consultationtype = '$res1auto_number' and department = '$res1department' and paymenttype ='2' and consultationdate between '$ADate1' and '$ADate2' ";
		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num2 = mysqli_num_rows($exec6);
		  
		  /* $query7 = "select * from master_visitentry where consultationtype = '$res1auto_number' and department = '$res1department' and paymenttype ='3' and consultationdate between '$ADate1' and '$ADate2' ";
		  $exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
		  $num3 = mysql_num_rows($exec7);
		  $res7 = mysql_fetch_array($exec7);*/
		  
		  $query8 = "select locationcode from master_visitentry where locationcode = '$locationdata' and consultationtype = '$res1auto_number' and department = '$res1department' and paymenttype ='3' and consultationdate between '$ADate1' and '$ADate2' ";
		  $exec8= mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num4 = mysqli_num_rows($exec8);
		  
		  $query9 = "select locationcode from master_visitentry where locationcode = '$locationdata' and consultationtype = '$res1auto_number' and department = '$res1department' and paymenttype ='5' and consultationdate between '$ADate1' and '$ADate2' ";
		  $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num5 = mysqli_num_rows($exec9);
		  
		  $query10 = "select locationcode from master_visitentry where locationcode = '$locationdata' and consultationtype = '$res1auto_number' and department = '$res1department' and paymenttype ='7' and consultationdate between '$ADate1' and '$ADate2' ";
		  $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num7 = mysqli_num_rows($exec10);
		  
		 		  
		  $query4 = "select department from master_department where auto_number = '$res1department'";
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res4 = mysqli_fetch_array($exec4);
		  $res4department = $res4['department'];
		  
		  $query5 = "select department from master_department where auto_number = '$res1department'";
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res5 = mysqli_fetch_array($exec5);
		  $res5department = $res5['department'];
		  
		  $total = $num1 + $num2 + $num4 +$num5 + $num7;
		  if($total != '0')
		  {
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
           <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res1consultationtype; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res4department; ?></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($num1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($num2,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($num4,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right"><?php echo number_format($num7,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($num5,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($total,2,'.',','); ?></strong></div></td>
           </tr>
		   <?php 
		   
		   $tot_cash=$tot_cash+$num1;
			$tot_insurance=$tot_insurance+$num2;
			$tot_credit=$tot_credit+$num4;
			$tot_staff=$tot_staff+$num5;
			$tot_prepaid=$tot_prepaid+$num7;
			$wholetotal=$wholetotal+$total;
		  
			} 
			
        
			}?>
			
			<tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><strong>Total</strong></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_cash,2,'.',','); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_insurance,2,'.',','); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_credit,2,'.',','); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="right"><?php echo number_format($tot_prepaid,2,'.',','); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_staff,2,'.',','); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($wholetotal,2,'.',','); ?></strong></div></td>
           </tr>
              <?php
				}
			}
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5"><div align="right"><strong> </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5"><div align="right"><strong><!--Total--></strong></div></td> 
              <td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5"><div align="right"><strong><?php //echo $totallab; ?></strong></div></td>
              <td width="17%" rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><a target="_blank" href="print_outpatientstatisticsreport.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $locationdata; ?>&&ADate1=<?php echo $paymentreceiveddatefrom; ?>&&ADate2=<?php echo $paymentreceiveddateto; ?>&&user=<?php echo $username; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></div></td>
            </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
