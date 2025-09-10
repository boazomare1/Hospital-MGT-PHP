<?php
//session_start();
//include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$username = '';
$companyanum = '';
$companyname = '';
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
 $total = "0.00";
 
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="outpatientstaticsreport.xls"');
header('Cache-Control: max-age=80');

$locationdata=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
 if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
 
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
		
if (isset($_REQUEST["user"])) { $username = $_REQUEST["user"]; } else { $username = ""; }
		

?>

<table width="56%">  
        <tr>
       <td colspan="8" align="center"> <b> OUT PATIENTS STATICS REPORT</b> </td>
          </tr>
          
         <tr>
       <td colspan="8" align="center"> <b> Date Range </b> <?= $ADate1 ?>  to  <?= $ADate2 ?> </td>
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
                    <tr >
            <!--  <td colspan="3" class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong><?php //echo $locationname; ?></strong></td>-->
               <td  colspan="9" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong><?php echo $locationname; ?></strong></td>
		   </tr>
                    <tr>
              <td width="23%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Consultation Type</strong></div></td>
              <td width="14%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong> Department </strong></td>
              <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong> Cash </strong></td>
              <td width="13%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Direct Credit</strong></div></td>
              <td width="14%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Insurance</strong></div></td>
              <td width="9%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Prepaid</strong></div></td>
              <td width="8%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Staff </strong></div></td>
              <td width="9%" align="right" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Total</strong></div></td> 
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
           <tr >
             <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res1consultationtype; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res4department; ?></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($num1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($num2,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($num4,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($num7,2,'.',','); ?></div></td>
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
		    
             <tr>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><strong>Total</strong></div></td>
               <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><strong></strong></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_cash,2,'.',','); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_insurance,2,'.',','); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_credit,2,'.',','); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_prepaid,2,'.',','); ?></strong></div></td>
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
                    <tr>
               <td  colspan="9" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong><?php echo $locationname; ?></strong></td>
		   </tr>
					<tr>
              <td width="23%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Consultation Type</strong></div></td>
              <td width="14%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong> Department </strong></td>
              <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong> Cash </strong></td>
              <td width="13%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Direct Credit</strong></div></td>
              <td width="14%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Insurance</strong></div></td>
              <td width="9%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><span align="right"><strong>Prepaid</strong></span></td>
              <td width="8%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Staff </strong></div></td>
              <td width="9%" align="right" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Total</strong></div></td> 
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
           <tr>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res1consultationtype; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res4department; ?></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($num1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($num2,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($num4,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($num7,2,'.',','); ?></div></td>
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
			
			<tr >
              <td class="bodytext31" valign="center"  align="left"><strong>Total</strong></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_cash,2,'.',','); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_insurance,2,'.',','); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_credit,2,'.',','); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_prepaid,2,'.',','); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_staff,2,'.',','); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($wholetotal,2,'.',','); ?></strong></div></td>
           </tr>
              <?php
				}
								
					
					
				}
			?>
          </tbody>
        </table></td>
      </tr>
    </table>
	<?php include ("includes/footer1.php"); ?>
</body>
</html>
