<?php


session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

$financialyear = $_SESSION["financialyear"];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

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
.ui-menu .ui-menu-item{ zoom:1 !important; }
</style>
<link href="autocomplete.css" rel="stylesheet">

<script src="js/jquery-ui.min.js"></script>


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
</style>
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
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="80%" valign="top"><table width="80%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
            
           <?php

           $patientcode=isset($_REQUEST['patientcode'])?$_REQUEST['patientcode']:'';
	if($patientcode!='')
	{
		 $detailquery="select patientname,patientcode,visitcode,docno,transactionamount,transactiondate from master_transactionadvancedeposit where  patientcode = '$patientcode' limit 1";
     


	 $docnum = "";
	$sno1='';
	$colorloopcount='';
	$showcolor='';
$exedetail=mysqli_query($GLOBALS["___mysqli_ston"], $detailquery)or die("Error in query".mysqli_error($GLOBALS["___mysqli_ston"]));
while($resquery=mysqli_fetch_array($exedetail))
{

	$patientname=$resquery['patientname'];
	}

	} ?>       
						
			
      <tr>
        <td class="bodytext31">Statement for <strong><?php echo  $patientname; ?></strong></td>
      </tr>
		
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
   
	

	   	<table id="AutoNumber5" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="50%" 
            align="left" border="0">
            
          <tbody>
            
            <tr>
              <td width="5%" class="bodytext31" 
                bgcolor="#ecf0f5"><div ><strong>S.No.</strong></div></td>
                <td width="10%" class="bodytext31" bgcolor="#ecf0f5" align="center"><strong>Transaction Amt</strong></td>
                <td width="10%" class="bodytext31" bgcolor="#ecf0f5" align="center"><strong>Doc no</strong></td>
                <td width="10%" class="bodytext31" bgcolor="#ecf0f5" align="left"><strong>Date</strong></td>
                 <td width="8%" class="bodytext31" bgcolor="#ecf0f5" align="center"><strong>Debit</strong></td>
                  <td width="8%" class="bodytext31" bgcolor="#ecf0f5" align="center"><strong>Credit</strong></td>
                
     
     
			            
              </tr>
	  <?php 

	$patientcode=isset($_REQUEST['patientcode'])?$_REQUEST['patientcode']:'';
	if($patientcode!='')
	{
		   
	 //$detailquery="select patientcode,billno,adjustamount,balamt,billdate from adjust_advdeposits where  patientcode = '$patientcode' order by id";


   $stmtquery="select res.* from ((select transactionamount,docno,concat(transactiondate,' ',transactiontime) as stmtdate,'' as debit,transactionamount as credit from master_transactionadvancedeposit where patientcode = '$patientcode' order by transactiondate ) UNION (select adjustamount,billno,createdon,adjustamount as debit,'' as credit from adjust_advdeposits where patientcode = '$patientcode' order by createdon ) UNION (select amount,docno,concat(recorddate,' ',recordtime) as stmtdate,amount as debit,'' as credit from deposit_refund where patientcode = '$patientcode' and visitcode='' order by recorddate) ) res order by res.stmtdate ";


	 $docnum = "";
	$sno1='';
	$colorloopcount='';
	$showcolor='';
  $total_debit = 0;
  $total_credit = 0;
$exedetail=mysqli_query($GLOBALS["___mysqli_ston"], $stmtquery)or die("Error in query".mysqli_error($GLOBALS["___mysqli_ston"]));
$numrow=mysqli_num_rows($exedetail);
if($numrow >0)
{
while($resquery=mysqli_fetch_array($exedetail))
{

	//$patientname=$resquery['patientname'];

	/*if($sno1 == '')
	{
		echo '<tr><td colspan="4">'.$patientname.'</td</tr>';
	}*/
	
	//$patientcode=$resquery['patientcode'];
	$docnum=$resquery['docno'];
	//$docnum=$resquery['billno'];
	//$transactiondate=$resquery['transactiondate'];
	//$transactiondate=$resquery['billdate'];
  $transactiondate=$resquery['stmtdate'];
$transactionamount=$resquery['transactionamount'];

//$transactionamount=$resquery['adjustamount'];
//$bal = $resquery['balamt'];

$debit = $resquery['debit'];
$credit = $resquery['credit'];

$total_debit  = $total_debit + $debit;
$total_credit = $total_credit + $credit;
  //$deposit_totalamt=$resquery['amt'];
	
        /*$deposit_bal_amt = $deposit_totalamt;
        $all_adjust_amt = 0;*/

  
  /*$deposit_amt_bal_query = "SELECT sum(adjustamount) usedamt FROM `adjust_advdeposits` WHERE `patientcode` = '$patientcode'";
  $bal_exec = mysql_query($deposit_amt_bal_query) or die(mysql_error());
   if(mysql_num_rows($bal_exec) > 0)
   {
       $bal_res = mysql_fetch_array($bal_exec);
       $all_adjust_amt = $bal_res['usedamt']; 
       $deposit_bal_amt = $deposit_totalamt - $all_adjust_amt;
      
   }*/
	$sno1=$sno1+1;
	 $colorloopcount = $colorloopcount + 1;
			  $showcolor = ($colorloopcount & 1); 
			  $colorcode = '';
				if ($showcolor == 0)
				{
					
					$colorcode = 'bgcolor="#CBDBFA"';
				}
				else
				{
					
					$colorcode = 'bgcolor="#ecf0f5"';
				}
        
?>
<tr <?php echo $colorcode; ?>>
<td class="bodytext31"><?=$sno1;?></td>
<td class="bodytext31" align="right"><?= number_format($transactionamount,'2','.',',');?></td>
<td class="bodytext31" align="center"><?= $docnum;?></td>
<td class="bodytext31" align="left"><?= $transactiondate;?></td>
<td class="bodytext31" align="right"><?php if(isset($debit) && $debit !="") echo number_format($debit,'2','.',',');?></td>
<td class="bodytext31" align="right"><?php if(isset($credit) && $credit !="") echo number_format($credit,'2','.',',');?></td>

</tr>

		 <?php
} 

$total_available = $total_credit - $total_debit;
?>

<tr><td colspan="5" class="bodytext31" align="right"><?php echo number_format($total_debit,'2','.',','); ?></td><td class="bodytext31" align="right"><?php echo number_format($total_credit,'2','.',','); ?></td></tr>
<tr><td colspan="5" class="bodytext31" align="right">Total Available</td><td class="bodytext31" align="right"><strong><?php echo number_format($total_available,'2','.',','); ?></strong></td></tr>
<?php }

}
		   ?>
           
            <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
             	<td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            
           
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>
                <?php //echo number_format($totalpurchaseamount, 2); ?>
              </strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
             
      
			</tr>
			<tr>
        <td>&nbsp;</td>
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

