<?php

session_start();

include ("db/db_connect.php");

header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="Petty Disbursed.xls"');

header('Cache-Control: max-age=80');
$username=$_SESSION['username'];
 $slocation=isset($_REQUEST['slocation'])?$_REQUEST['slocation']:'';
 $startdate=isset($_REQUEST['startdate'])?$_REQUEST['startdate']:'';
 $enddate=isset($_REQUEST['enddate'])?$_REQUEST['enddate']:'';
$checkboxnumber=0;
$sno=0;
?>

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none

}

-->

</style>

<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<style type="text/css">

<!--

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

-->

</style>

</head>

<script>

</script>



<script src="js/jquery-1.11.1.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/autocomplete.css">

<link rel="stylesheet" type="text/css" href="css/style.css">

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>





<body >

<table width="101%" border="0" cellspacing="0" cellpadding="2">


  <tr>

  

    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="860"><table width="" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">

            <tr>

              <td>

                <table width="850" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

<tr>

<td colspan="15"  class="bodytext3"><span class="bodytext32"><strong>Petty Cash Disbursed </strong></span></td>

</tr>
                      

<tr >

<td width="50" height="25"  class="bodytext31"><strong>S.No.</strong></td>
<td width="94" height="25"  class="bodytext31"><strong>Location</strong></td>
<td width="70"  class="bodytext31"><strong>Doc No</strong></td>
<td width="80"  class="bodytext31"><strong>Date</strong></td>
<td width="100"  class="bodytext31"><strong>Aprv Amount</strong></td>
<td width="100"  class="bodytext31"><strong>Disburse Amount</strong></td>
<td width="300"  class="bodytext31"><strong>Remarks</strong></td>
<td width="144"  class="bodytext31"><strong>Disburse By</strong></td>

</tr>

                     <?php
		if($slocation=='All')
		{			 
   $query01="select locationcode,locationname from master_employeelocation where username='$username'  group by locationcode";
$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
while($res01=mysqli_fetch_array($exc01))
{
$locationcode1=$res01['locationcode'];
			  $querry=" select  * from pcrequest where  currentdate between '$startdate' and '$enddate' and delete_status <>'deleted'  and approved_status ='3' and final_status='completed' and locationcode='$locationcode1' ORDER BY `pcrequest`.`doc_no` ASC ";
			
	$exe=mysqli_query($GLOBALS["___mysqli_ston"], $querry);  
			$colorloopcount=0;
		while($result=mysqli_fetch_array($exe)){
			$sno=$sno+1;
			$date=$result['currentdate'];
			$amount=$result['amount'];
			$approved_amt=$result['approved_amt'];
			$remarks=$result['remarks'];
			$requestedby_user=$result['username'];
			$second_approvel_user=$result['second_approvel_user'];
			$doc_no=$result['doc_no'];
			$locationname=$result['locationname'];
			
			$query018="select username from master_journalentries where pcdocno='$doc_no'";
$exc018=mysqli_query($GLOBALS["___mysqli_ston"], $query018);
$res018=mysqli_fetch_array($exc018);

$disby=$res018['username'];
$checkboxnumber = $checkboxnumber + 1;

		?>

<tr >

<td align="left" valign="top" class="bodytext31"><?php echo $sno; ?> </td>
<td align="left" valign="top" class="bodytext31"><?php echo $locationname; ?> </td>
<td align="left" valign="top" class="bodytext31"><?php echo $doc_no; ?> </td>

<td align="left" valign="top" class="bodytext31"><?php echo date('d/m/Y',strtotime($date)); ?> </td>
<td align="right" valign="top" class="bodytext31"><?php echo number_format($amount,2,'.',','); ?> </td>
<td align="right" valign="top" class="bodytext31"><?php echo number_format($approved_amt,2,'.',','); ?> </td>
<td align="left" valign="top" class="bodytext31"><?php echo $remarks; ?> </td>
<td align="left" valign="top" class="bodytext31"><?php echo ucwords($disby); ?> </td>
</tr>

                      <?php

		}
}
		}
		else
		{
			
			
            
               $querry=" select  * from pcrequest where  currentdate between '$startdate' and '$enddate' and delete_status <>'deleted'  and approved_status ='3' and final_status='completed' and locationcode='$slocation' ORDER BY `pcrequest`.`doc_no` ASC ";
			
	$exe=mysqli_query($GLOBALS["___mysqli_ston"], $querry);
			
			?>
		<table border="0" >
			
			
            <?php  
			$colorloopcount=0;
		while($result=mysqli_fetch_array($exe)){
			$sno=$sno+1;
			$date=$result['currentdate'];
			$amount=$result['amount'];
			$approved_amt=$result['approved_amt'];
			$remarks=$result['remarks'];
			$requestedby_user=$result['username'];
			$second_approvel_user=$result['second_approvel_user'];
			$doc_no=$result['doc_no'];
			$locationname=$result['locationname'];
			
			$query018="select username from master_journalentries where pcdocno='$doc_no'";
$exc018=mysqli_query($GLOBALS["___mysqli_ston"], $query018);
$res018=mysqli_fetch_array($exc018);

$disby=$res018['username'];
			
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
           
           <td align="left" valign="top" class="bodytext31"><?php echo $sno; ?> </td>
            <td align="left" valign="top" class="bodytext31"><?php echo $locationname; ?> </td>
             <td align="left" valign="top" class="bodytext31"><input type="hidden" name="doc" id="doc"value="<?php echo $doc_no; ?>"><?php echo $doc_no; ?> </td>
            
              <td align="left" valign="top" class="bodytext31"><?php echo date('d/m/Y',strtotime($date)); ?> </td>
               <td align="right" valign="top" class="bodytext31"><input type="hidden" name="amount" id="amount" value="<?php echo number_format($amount); ?>" ><?php echo number_format($amount,2,'.',','); ?> </td>
                <td align="right" valign="top" class="bodytext31"><input type="hidden" name="aamount" id="aamount" value="<?php echo number_format($approved_amt); ?>"><?php echo number_format($approved_amt,2,'.',','); ?> </td>
                <td align="left" valign="top" class="bodytext31"><?php echo $remarks; ?> </td>
                 <td align="left" valign="top" class="bodytext31"><?php echo ucwords($disby); ?> </td>

                
                 
            <?php }?>
            
            </tr>
            </table>
            </table>
            
            
            
            <?php  
		}
?>
          
		   

                    </tbody>

                  </table>

				  

			    </td>

            </tr>

            <tr>

              <td>&nbsp;</td>

            </tr>

        </table></td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

    </table>

</table>



</body>

</html>



