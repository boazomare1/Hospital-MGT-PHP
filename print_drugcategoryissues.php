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

if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }
//echo $type;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"];$paymentreceiveddatefrom = $ADate1; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"];$paymentreceiveddateto = $ADate2; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = "frmflag1"; }
//$frmflag1 = $_REQUEST['frmflag1'];
if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
//$categoryname = $_POST['categoryname'];
if (isset($_REQUEST["searchitemcode"])) { $searchitemcode = $_REQUEST["searchitemcode"]; } else { $searchitemcode = ""; }
//$searchitemcode = $_REQUEST["searchitemcode"];
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
	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200" align="left" border="0">
		<tr>
			<td align="center" colspan="4" class="bodytext31"><strong>&nbsp;</strong></td> 
			
		</tr>
		
		<tr>
			<td align="center" colspan="4" class="bodytext31"><strong>&nbsp;</strong></td> 
			
		</tr>
		<tr>
			<td align="center" class="bodytext31"> &nbsp; </td> 
			<td align="center" colspan="3" class="bodytext31">
			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" align="left" border="0">
			<tbody>
			
			<tr>
				<td align="center" colspan="6" class="bodytext31"><strong> Drug Category Issues  </strong></td> 
			</tr>
			<?php
			
			if ($frmflag1 == 'frmflag1')
			{

				$query9 = "select categoryname, itemcode from master_medicine where status <> 'deleted' and categoryname LIKE '%$categoryname%' and itemcode LIKE '%$searchitemcode%' order by itemname";
				$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res9 = mysqli_fetch_array($exec9))
				{
					$sno=0;
					$total=0;
					$categoryname = $res9['categoryname']; 
					$catitemcode = $res9['itemcode']; 

					$query7 = "select * from pharmacysales_details where itemcode = '$catitemcode'  and entrydate between '$ADate1' and '$ADate2' order by entrydate desc";

					$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num7 = mysqli_num_rows($exec7);
				
					if($num7!=0){
			?>
				<tr bgcolor="#ecf0f5"> 
					<td align="left" valign="center" class="bodytext31" colspan="6" ><strong><?php echo $categoryname; ?></strong></td>
				</tr>
				
				<tr>
					<td align="left" valign="center" bgcolor="#ffffff" class="bodytext31" width="35" ><strong>Sno</strong></td>
					<td align="left" valign="center" bgcolor="#ffffff" class="bodytext31" width="auto" ><strong>Patient Name</strong></td>
					<td align="left" valign="center" bgcolor="#ffffff" class="bodytext31" width="auto" ><strong>Dept/Ward</strong></td>
					<td align="left" valign="center" bgcolor="#ffffff" class="bodytext31" width="100" ><strong>Drug Name</strong></td>
					<td align="left" valign="center" bgcolor="#ffffff" class="bodytext31" width="60" ><strong>Quantity</strong></td>
					<td align="left" valign="center" bgcolor="#ffffff" class="bodytext31" width="90" ><strong>Date of Issue</strong></td>
				</tr>
				<?php							
				while($res7 = mysqli_fetch_array($exec7))
				{

				$billdate6 = $res7['entrydate'];
				$quantity6 = $res7['quantity'];
				$patientname6 = $res7['patientname'];
				$itemname = $res7['itemname'];
				$itemcode = $res7['itemcode']; 
				$issuedfrom = $res7['issuedfrom']; 
				$visitcode = $res7['visitcode'];

				if($issuedfrom ==''){
					$sqlq = "SELECT departmentname FROM `master_visitentry` WHERE `visitcode` = '$visitcode'";
					$sqlexc = mysqli_query($GLOBALS["___mysqli_ston"], $sqlq);
					$sqlnum = mysqli_num_rows($sqlexc);
					$sqlres = mysqli_fetch_array($sqlexc);
					if($sqlnum > 0){
						$dept_ward = $sqlres['departmentname'];
					}else{
						$dept_ward = '';
					}

				}else{
					$sqlq1 = "SELECT ward FROM `ip_bedallocation` WHERE `visitcode` = '$visitcode'";
					$sqlexc1 = mysqli_query($GLOBALS["___mysqli_ston"], $sqlq1);
					$sqlnum1 = mysqli_num_rows($sqlexc1);
					$sqlres1 = mysqli_fetch_array($sqlexc1);

					if($sqlnum1 > 0){
						$dept_wardautono = $sqlres1['ward'];
						$sqlq2 = "SELECT ward FROM `master_ward` WHERE `auto_number` = '$dept_wardautono' ";
						$sqlexc2 = mysqli_query($GLOBALS["___mysqli_ston"], $sqlq2);
						$sqlnum2 = mysqli_num_rows($sqlexc2);
						$sqlres2 = mysqli_fetch_array($sqlexc2);
						if($sqlnum2 > 0){
							$dept_ward = $sqlres2['ward'];
						}else{
							$dept_ward = '';
						}
					}else{
						$dept_ward = '';
					}

				}



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
				if($type=='')
				{
					$num='1';
				}
				else
				{
					$query9 = "select * from master_medicine where  incomeledger like '%$type%' and itemcode='$itemcode'  and status = '' group by itemcode	 order by categoryname";
					$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num=mysqli_num_rows($exec9);	
				}
				
				if($num!=0)
				{
				$total=$total+$quantity6;
				?>
				<tr >
					
					<td align="left" valign="center" class="bodytext31"><?php echo $sno=$sno+1; ?></td>
					<td align="left" valign="center" class="bodytext31"><?php echo $patientname6; ?></td>
					<td align="left" valign="center" class="bodytext31"><?php echo $dept_ward; ?></td>
					<td align="left" valign="center" class="bodytext31" width="170"><?php echo $itemname; ?></td>
					<td align="left" valign="center" class="bodytext31" width="60"><?php echo intval($quantity6); ?></td>
					<td align="left" valign="center" class="bodytext31" width="90"><?php echo $billdate6; ?></td>
					
				</tr>
				<?php
				}
				}
				?>
				<tr >
					
					<td align="left" valign="center" class="bodytext31">&nbsp;</td>
					<td align="left" valign="center" class="bodytext31">&nbsp;</td>
					<td align="left" valign="center" class="bodytext31">&nbsp;</td>
					<td align="left" valign="center" class="bodytext31">Total</td>
					<td align="left" valign="center" class="bodytext31"><?php echo intval($total); ?></td>
					<td align="left" valign="center" class="bodytext31">&nbsp;</td>
					
				</tr>
			<?php
					}
				}
			}
				
			?>
			</tbody>
			
			</table>
			
			</td>
			
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