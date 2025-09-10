<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d');
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$res1suppliername = '';
$total1 = '0.00';
$total2 = '0.00';
$total3 = '0.00';
$total4 = '0.00';
$total5 = '0.00';
$total6 = '0.00';
//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_customer2.php");
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Doctoractivity Report.xls"');
header('Cache-Control: max-age=80');


if (isset($_REQUEST["slocation"])) { $slocation = $_REQUEST["slocation"]; } else { $slocation = ""; }

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"];$paymentreceiveddatefrom = $ADate1; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"];$paymentreceiveddateto = $ADate2; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = "cbfrmflag1"; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if (isset($_REQUEST["usernamenew"])) { $usernamenew = $_REQUEST["usernamenew"]; } else { $usernamenew = ""; }

?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #FFF;
}
..bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
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
</style>
</head>

	   <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="631" 
            align="left" border="1">
          <tbody>
            <tr>
              <td colspan="4" class="bodytext31"><strong>Doctor Activity Report</strong>
             </td> 
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
				
              <td width="34%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doctor Name</strong></div></td>
				 
   				  <td width="24%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Count</strong></div></td>
                  <td width="64%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Location</strong></div></td>
				
            </tr>
			
			<?php
			
		
		  $query4 = "select username,locationname,count(username) as totalpatients from master_consultationlist where locationcode like '%$slocation' and date between '$ADate1' and '$ADate2' and username LIKE '%$usernamenew%'  group by username order by auto_number ASC"; 

		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num4 = mysqli_num_rows($exec4);
		  while($res4 = mysqli_fetch_array($exec4))
			{
				$numt1=0;
			
			//echo $res4['totalpatients'];
			 $username = $res4['username'];
			 $totalpatients=$res4['totalpatients'];
		
		$query1002 = "select count(username) as totalpatients1 from master_consultationlist where locationcode like '%$slocation' and username='$username' and date between '$ADate1' and '$ADate2' group by visitcode order by auto_number ASC"; 
		
		  $exec1002 = mysqli_query($GLOBALS["___mysqli_ston"], $query1002) or die ("Error in Query002".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $numt1=mysqli_num_rows($exec1002);
				
				
				$doctorname = $res4['username'];
				$doctorusername = $res4['username'];
				$location=$res4['locationname'];
				

				$query02="select employeename from master_employee where username='$doctorname'";
				$exec02=mysqli_query($GLOBALS["___mysqli_ston"], $query02);
				$res02=mysqli_fetch_array($exec02);
				if($res02['employeename']!='')
				{
					 $doctorname=$res02['employeename'];
				}
				
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
				<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
				<td class="bodytext31" valign="center"  align="left">
				<?php echo $doctorname; ?> 
                </td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $numt1; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $location; ?></div></td>
				
				
				
				</tr>
			<?php
						$total1 +=$numt1;
						$numt1=0;
					
			}
			?>
			
              <td colspan="2" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong>Total Patients Consulted:</strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong><?= $total1;?></strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                </tr>
				</tbody>
                </table>
				