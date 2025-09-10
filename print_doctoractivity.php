<?php
session_start();
//include ("includes/loginverify.php");
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

ob_start();

$query1 = "select * from master_company where auto_number = '$companyanum'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1companyname = $res1['companyname'];
$res1address1 = $res1['address1'];
$resfaxnumber1 = $res1['faxnumber1'];
$res1area = $res1['area'];
$res1city = $res1['city'];
$res1state = $res1['state'];
$res1emailid1= $res1['emailid1'];
$res1country = $res1['country'];
$res1pincode = $res1['pincode'];
$phonenumber1 = $res1['phonenumber1'];
$locationname = $res1['locationname'];
$locationcode = $res1['locationcode'];

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
	font-family:"Times New Roman", Times, serif;
}
..bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3B3B3C; 
}
-->
</style>
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c;  text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c;  text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c;  text-decoration:none
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
<?php  include("print_header1.php"); ?>
	   <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200" 
            align="center" border="0">
           <tr>
              <td align="center" colspan="4" class="bodytext31"><strong>&nbsp;</strong>
             </td> 
            </tr>
            <tr>
              <td align="center" colspan="4" class="bodytext31"><strong><u>Doctor Activity Report</u></strong>
             </td> 
            </tr>
            <tr>
              <td align="center" colspan="4" class="bodytext31"><strong>&nbsp;</strong>
             </td> 
            </tr>
            <tr>
              <td width="30" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
				
              <td width="280" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Doctor Name</strong></td>
				 
   				  <td width="60" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Count</strong></td>
                  <td width="180" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Location</strong></td>
				
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
				<?php echo $numt1; ?></td>
                <td class="bodytext31" valign="center"  align="left">
				<?php echo $location; ?></td>
							
				</tr>
			<?php
						$total1 +=$numt1;
						$numt1=0;
					
			}
			?>
			<tr>
              <td colspan="2" class="bodytext31" valign="center"  align="left" 
                bgcolor="#fff"><strong>Total Patients Consulted:</strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#fff"><strong><?= $total1;?></strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#fff">&nbsp;</td>
                </tr>
				
                </table>
	<?php	
$content = ob_get_clean();

    // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));
//      $html2pdf->setModeDebug();
        //$html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('DoctorActivity.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>			