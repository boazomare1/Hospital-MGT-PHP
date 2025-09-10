<?php 
ob_start();
session_start();

include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
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


if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];
$locationcode=isset($_REQUEST['locationdetail'])?$_REQUEST['locationdetail']:'';
?>
 <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["customername"])) { $customername = $_REQUEST["customername"]; } else { $customername = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					//$transactiondatefrom = $_REQUEST['ADate1'];
					//$transactiondateto = $_REQUEST['ADate2'];
					
					//$paymenttype = $_REQUEST['paymenttype'];
					//$billstatus = $_REQUEST['billstatus'];
					
					$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				else
				{
					$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				?>
<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="highcostvisitreport.xls"');
header('Cache-Control: max-age=80');
?>
<style>
.bodyhead{font-weight:bold; font-size:16px; text-align:center;}
.bodytextbold{font-weight:bold; font-size:12px; text-align:center;}
.bodytext31{font-weight:normal; font-size:13px; text-align:center; vertical-align:middle;}
td{{height: 50px;padding: 5px;}
table{table-layout:fixed;
display:table;}
</style>



<table width="748"  align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="BORDER-COLLAPSE: collapse">
          <tbody>
       
      
    </tr><tr>
              <td class="bodytext31" valign="center"  align="left" 
                ><strong>No.</strong></td>
              <td width="6%" align="left" valign="center"  
                 class="bodytext31"><div align="left"><strong>Bill No</strong></div></td>
              <td width="8%" align="left" valign="center"  
                 class="bodytext31"><strong> Date </strong></td>
              <td width="8%" align="left" valign="center"  
                 class="bodytext31"><strong> Reg. No </strong></td>
              <td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>OP No </strong></div></td>
				<td width="14%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account </strong></div></td>
              <td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doctor</strong></div></td>
				<td width="13%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient</strong></div></td>
              <td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Bill Amount </strong></div></td>
                
            </tr>
			<?php
			$locationcode=$_REQUEST['locationcode'];
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
            //$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
            if ($cbfrmflag1 == 'cbfrmflag1')
            {
				
				if($locationcode !='all')
				{
			 $query21 = "select * from billing_paylater where accountnameid like '%$searchsuppliercode%' and locationcode ='$locationcode' and billdate between '$ADate1' and '$ADate2' group by accountname order by accountname desc  ";
				}
				else
				{
					 $query21 = "select * from billing_paylater where accountnameid like '%$searchsuppliercode%'  and billdate between '$ADate1' and '$ADate2' group by accountname order by accountname desc ";
				}
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res21 = mysqli_fetch_array($exec21))
			{
			$res21accountnameano = $res21['accountnameano'];
			
			$query22 = "select * from master_accountname where auto_number = '$res21accountnameano' and recordstatus <>'DELETED' ";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22);
			$res22accountname = $res22['accountname'];
			$res21accountname = $res22['accountname'];

			if( $res22accountname != '')
			{
			?>
			<tr >
            <td colspan="9"  align="left" valign="center"  class="bodytext31"><strong><?php echo $res22accountname;?></strong></td>
            </tr>
			<?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
		  
				if($locationcode !='all')
				{ 
		  if ($range == '')
		  {         
		  $query2 = "select * from billing_paylater where accountnameano = '$res21accountnameano' and locationcode ='$locationcode' and totalamount like '%$amount%' and billdate between '$ADate1' and '$ADate2' order by accountname, billdate desc";
		  }
		  else if ($range == 'equal')
		  { 
		  $query2 = "select * from billing_paylater where accountnameano = '$res21accountnameano' and locationcode ='$locationcode' and totalamount = '$amount' and billdate between '$ADate1' and '$ADate2' order by accountname, billdate desc";
		  }
		  else if ($range == 'greater')
		  {
		  $query2 = "select * from billing_paylater where accountnameano = '$res21accountnameano' and locationcode ='$locationcode' and totalamount > '$amount' and billdate between '$ADate1' and '$ADate2' order by accountname, billdate desc";
		  }
		  else if ($range == 'lesser')
		  {
		  $query2 = "select * from billing_paylater where accountnameano = '$res21accountnameano' and locationcode ='$locationcode' and totalamount < '$amount' and billdate between '$ADate1' and '$ADate2' order by accountname, billdate desc";
		  }
		  else if ($range == 'greaterequal')
		  {
		  $query2 = "select * from billing_paylater where accountnameano = '$res21accountnameano'  and locationcode ='$locationcode' and totalamount >= '$amount' and billdate between '$ADate1' and '$ADate2' order by accountname, billdate desc";
		  }
		  else if ($range == 'lesserequal')
		  {
		  $query2 = "select * from billing_paylater where accountnameano = '$res21accountnameano' and locationcode ='$locationcode' and totalamount <= '$amount' and billdate between '$ADate1' and '$ADate2' order by accountname, billdate desc";
		  }
				}
				else
				{
					 
		  if ($range == '')
		  {         
		  $query2 = "select * from billing_paylater where accountnameano = '$res21accountnameano' and totalamount like '%$amount%' and billdate between '$ADate1' and '$ADate2' order by accountname, billdate desc";
		  }
		  else if ($range == 'equal')
		  { 
		  $query2 = "select * from billing_paylater where accountnameano = '$res21accountnameano'  and totalamount = '$amount' and billdate between '$ADate1' and '$ADate2' order by accountname, billdate desc";
		  }
		  else if ($range == 'greater')
		  {
		  $query2 = "select * from billing_paylater where accountnameano = '$res21accountnameano'  and totalamount > '$amount' and billdate between '$ADate1' and '$ADate2' order by accountname, billdate desc";
		  }
		  else if ($range == 'lesser')
		  {
		  $query2 = "select * from billing_paylater where accountnameano = '$res21accountnameano'  and totalamount < '$amount' and billdate between '$ADate1' and '$ADate2' order by accountname, billdate desc";
		  }
		  else if ($range == 'greaterequal')
		  {
		  $query2 = "select * from billing_paylater where accountnameano = '$res21accountnameano'   and totalamount >= '$amount' and billdate between '$ADate1' and '$ADate2' order by accountname, billdate desc";
		  }
		  else if ($range == 'lesserequal')
		  {
		  $query2 = "select * from billing_paylater where accountnameano = '$res21accountnameano'  and totalamount <= '$amount' and billdate between '$ADate1' and '$ADate2' order by accountname, billdate desc";
		  }
				
				}
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
     	  $res2billnumber = $res2['billno'];
		  $res2billdate = $res2['billdate'];
		  $res2patientcode = $res2['patientcode'];
		  $res2visitcode = $res2['visitcode'];
		  $res2patientname = $res2['patientname'];
		  $res2totalamount = $res2['totalamount'];
		  $res2locationcode=$res2['locationcode'];
		  $total = $total + $res2totalamount;
		  
		   $query3 = "select * from master_consultationlist where patientcode = '$res2patientcode'";
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res3 = mysqli_fetch_array($exec3);
		  $res3consultingdoctor = $res3['consultingdoctor'];
		  
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2patientcode; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2visitcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res21accountname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res3consultingdoctor; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res2totalamount,2,'.',','); ?></div></td>
              <?php $urlpath = "locationcode=$res2locationcode&&billautonumber=$res2billnumber";?>
              

           </tr>
			<?php
			}
			}
			}
			}
		 
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
               >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                ><div align="right"><strong> </strong></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                ><div align="right"><strong> </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                ><div align="left"><strong>Total:</strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                ><div align="right"><strong><?php echo number_format($total,2,'.',','); ?></strong></div></td>
                
            </tr>
            
          </tbody>
        </table>
