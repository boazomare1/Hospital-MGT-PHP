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
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$searchsuppliername = '';
$suppliername = '';
$cbsuppliername = '';
$cbcustomername = '';
$cbbillnumber = '';
$cbbillstatus = '';
$colorloopcount = '';
$sno = '';
$snocount = '';
$visitcode1 = '';
$total = '0.00';
$looptotalpaidamount = '0.00';
$looptotalpendingamount = '0.00';
$looptotalwriteoffamount = '0.00';
$looptotalcashamount = '0.00';
$looptotalcreditamount = '0.00';
$looptotalcardamount = '0.00';
$looptotalonlineamount = '0.00';
$looptotalchequeamount = '0.00';
$looptotaltdsamount = '0.00';
$looptotalwriteoffamount = '0.00';
$pendingamount = '0.00';
$accountname = '';
$amount = '';

 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

if (isset($_REQUEST["patientname"])) { $searchpatientname = $_REQUEST["patientname"]; } else { $searchpatientname = ""; }
if (isset($_REQUEST["patientcode"])) { $searchpatientcode = $_REQUEST["patientcode"]; } else { $searchpatientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $searchvisitcode = $_REQUEST["visitcode"]; } else { $searchvisitcode = ""; }
if (isset($_REQUEST["docno"])) { $searchdocno = $_REQUEST["docno"]; } else { $searchdocno = ""; }
if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }



if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype']; 
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];


if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];


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
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">


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




</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>

</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="1900" border="0" cellspacing="0" cellpadding="2">
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
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="debit_credit_note_report.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Report</strong></td>
                      <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                     <td colspan="2" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                  <?php
						
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
						?>
						
                  </td> 
                    </tr>
					
                    
                    <tr>
  			  <td width="18%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
              <td align="left" valign="top"  bgcolor="#FFFFFF" colspan="3"><span class="bodytext3">
			 <input type="text" name="patientname" id="patientname" value="<?php echo $searchpatientname;?>" size="43">
              </span></td>
			  </tr>
					<tr>
  			  <td width="18%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Code</td>
              <td align="left" valign="top"  bgcolor="#FFFFFF" colspan="3"><span class="bodytext3">
			 <input type="text" name="patientcode" id="patientcode" value="<?php echo $searchpatientcode;?>" size="43">
              </span></td>
			  </tr>
              <tr>
  			  <td width="18%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> Visit Code</td>
              <td align="left" valign="top"  bgcolor="#FFFFFF" colspan="3"><span class="bodytext3">
			 <input type="text" name="visitcode" id="visitcode" value="<?php echo $searchvisitcode;?>" size="43">
              </span></td>
			  </tr>
               <tr>
  			  <td width="18%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Doc.No</td>
              <td align="left" valign="top"  bgcolor="#FFFFFF" colspan="3"><span class="bodytext3">
			 <input type="text" name="docno" id="docno" value="<?php echo $searchdocno;?>" size="43">
              </span></td>
			  </tr>
               <tr>
  			  <td width="18%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Type</td>
              <td align="left" valign="top"  bgcolor="#FFFFFF" colspan="3"><span class="bodytext3">
			<select name="type" id="type">
            <option value="credit" <?php if($type=='credit'){echo "selected";} ?>>Credit</option>
			<option value="debit" <?php if($type=='debit'){echo "selected";} ?>>Debit</option>

            </select>
              </span></td>
			  </tr>
              <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="27%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="8%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="47%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
             
                    <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1512" 
            align="left" border="0">
          <tbody>
		  <?php
            if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
		    if ($cbfrmflag1 == 'cbfrmflag1')
			{
				$sno=1;
				$grandtotal=0;
			if($type=='credit')
			{ ?>
				 <tr>
              <td width="37"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>S.No</strong></div></td>
              <td width="70" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td width="84" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doc.No</strong></div></td>
              <td width="109" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Code</strong></div></td>
              <td width="75" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit Code</strong></div></td>
              <td width="267" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name</strong></div></td>
              <td width="278" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sub Type</strong></div></td>
              <td width="379" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account Name</strong></div></td>
              <td width="141" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount</strong></div></td>
                  
            </tr>
            <?php
			    $querytranspay="select * from master_transactionpaylater where patientname like '%$searchpatientname%' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and docno like '%$searchdocno%' and transactiondate between '$ADate1' and '$ADate2' and transactiontype in('pharmacycredit','paylatercredit') and accountname<>'consultation' group by docno order by transactiondate asc";
			$exctranspay=mysqli_query($GLOBALS["___mysqli_ston"], $querytranspay) or die("error in querytranspay".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($restrans=mysqli_fetch_array($exctranspay))
			{
				$visitcode=$restrans['visitcode'];
				$transactiondate=$restrans['transactiondate'];
				$patientcode=$restrans['patientcode'];
				$patientname=$restrans['patientname'];
				$docno=$restrans['docno'];
				$transactionamount=$restrans['transactionamount'];
				$accountname=$restrans['accountname'];
				$subtype=$restrans['subtype'];
				
				if($transactionamount > 0)
				{
					$grandtotal+=$transactionamount;
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
              <td width="37"  align="left" valign="center" 
               class="bodytext31"><div align="left"><?php echo $sno++;?></div></td>
              <td width="70" align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $transactiondate;?></div></td>
              <td width="84" align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $docno;?></div></td>
              <td width="109" align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $patientcode;?></div></td>
              <td width="75" align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $visitcode;?></div></td>
              <td width="267" align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $patientname;?></div></td>
              <td width="278" align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $subtype;?></div></td>
              <td width="379" align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $accountname;?></div></td>
              <td width="141" align="left" valign="center"  
                 class="bodytext31"><div align="center"><?php echo number_format($transactionamount,2);?></div></td>
                  
            </tr>
			<?php
			}
			}
			/*
			 $opdiscount="select patientvisitcode,patientcode from op_discount  where patientname like '%$searchpatientname%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and docno like '%$searchdocno%' and consultationdate between '$ADate1' and '$ADate2' and paymentstatus='pending' group by docno order by consultationdate asc";
			$exeopdiscount=mysql_query($opdiscount) or die("error in opdiscount".mysql_error());
			while($resopdisc=mysql_fetch_array($exeopdiscount))	
			{
				$fvisitcode=$resopdisc['patientvisitcode'];
				$fpatientcode=$resopdisc['patientcode'];
				
				 $discount="select patientvisitcode,consultationdate,patientcode,patientname,docno,sum(rate) as rate from op_discount where patientcode='$fpatientcode' and patientvisitcode='$fvisitcode'";
				$exediscount=mysql_query($discount) or die("error in discount".mysql_error());
			while($resdisc=mysql_fetch_array($exediscount))
			{
			 $disvisitcode=$resdisc['patientvisitcode'];
				$dispatientcode=$resdisc['patientcode'];
				$distransactiondate=$resdisc['consultationdate'];
				
				$dispatientname=$resdisc['patientname'];
				$disdocno=$resdisc['docno'];
				$distransactionamount=$resdisc['rate'];
				
				if($distransactionamount > 0)
				{
					$grandtotal+=$distransactionamount;
					
					  $query2 = "select subtype,accountname from master_visitentry where patientcode='$dispatientcode' and visitcode='$disvisitcode'";
			  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			 $res2 = mysql_fetch_array($exec2);
			   $subtypeanum = $res2['subtype'];
			  $accountnameanum = $res2['accountname'];
			  
					
					 $query4 = "select subtype from master_subtype where auto_number = '$subtypeanum'";
			  $exec4 = mysql_query($query4) or die ("Error in Query5".mysql_error());
			  $res4 = mysql_fetch_array($exec4);
			  $res4subtype = $res4['subtype'];
			
	          $query5 = "select accountname from master_accountname where auto_number = '$accountnameanum'";
			  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
			  $res5 = mysql_fetch_array($exec5);
			  $res5accountname = $res5['accountname'];
					
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
              <td width="37"  align="left" valign="center" 
               class="bodytext31"><div align="left"><?php echo $sno++;?></div></td>
              <td width="70" align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $distransactiondate;?></div></td>
              <td width="84" align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $disdocno;?></div></td>
              <td width="109" align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $dispatientcode;?></div></td>
              <td width="75" align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $disvisitcode;?></div></td>
              <td width="267" align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $dispatientname;?></div></td>
              <td width="278" align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $res4subtype;?></div></td>
              <td width="379" align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $res5accountname;?></div></td>
              <td width="141" align="left" valign="center"  
                 class="bodytext31"><div align="center"><?php echo number_format($distransactionamount,2);?></div></td>
                  
            </tr>
			<?php
			}
			}
			}
			*/
			?>
			<tr class="bodytext31" bgcolor="#ecf0f5">
              <td  align="left" colspan="8"><div align="right"><strong>Grand Total</strong></div></td>
              <td width="141"  align="left"><div align="center"><?php echo number_format($grandtotal,2);?></div></td>
			<?php
			}
			if($type=='debit')
			{
				?>
                <tr>
              <td width="37"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>S.No</strong></div></td>
              <td width="70" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
                <td width="84" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doc No.</strong></div></td>
              <td width="109" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Code</strong></div></td>
              <td width="75" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit Code</strong></div></td>
              <td width="267" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name</strong></div></td>
               <td width="278" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sub Type</strong></div></td>
              <td width="379" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account Name</strong></div></td>
              <td width="141" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount</strong></div></td>
                  
            </tr>
                
                <?php
			//debit
			  $querytranspay="select * from ip_debitnote where patientname like '%$searchpatientname%' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and billno like '%$searchdocno%' and billdate between '$ADate1' and '$ADate2' and billno !='' group by billno  order by billdate asc";
			$exctranspay=mysqli_query($GLOBALS["___mysqli_ston"], $querytranspay) or die("error in querytranspay".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($restrans=mysqli_fetch_array($exctranspay))
			{
				$visitcode=$restrans['visitcode'];
				$transactiondate=$restrans['billdate'];
				$patientcode=$restrans['patientcode'];
				$patientname=$restrans['patientname'];
				$transactionamount=$restrans['totalamount'];
				$billnumber=$restrans['billno'];
				$accountname=$restrans['accountname'];
				$subtype=$restrans['subtype'];
				
				if($transactionamount > 0)
				{
					$grandtotal+=$transactionamount;
					
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
              <td width="37"  align="left" valign="center" 
               class="bodytext31"><div align="left"><?php echo $sno++;?></div></td>
              <td width="70" align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $transactiondate;?></div></td>
              <td width="84" align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $billnumber;?></div></td>
              <td width="109" align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $patientcode;?></div></td>
              <td width="75" align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $visitcode;?></div></td>
              <td width="267" align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $patientname;?></div></td>
              <td width="278" align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $subtype;?></div></td>
              <td width="379" align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $accountname;?></div></td>
              <td width="141" align="left" valign="center"  
                 class="bodytext31"><div align="center"><?php echo number_format($transactionamount,2);?></div></td>
            </tr>
			<?php
			} 
			}

			/*
			$opmisc="select * from opmisc_billing where patientname like '%$searchpatientname%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and docno like '%$searchdocno%' and consultationdate between '$ADate1' and '$ADate2' and paymentstatus='pending' order by consultationdate asc";
			$exeopmisc=mysql_query($opmisc) or die("Error in opmisc".mysql_error());
			while($resmisc=mysql_fetch_array($exeopmisc))
			{
				$miscvisitcode=$resmisc['patientvisitcode'];
				$misctransactiondate=$resmisc['consultationdate'];
				$miscpatientcode=$resmisc['patientcode'];
				$miscpatientname=$resmisc['patientname'];
				$misctransactionamount=$resmisc['amount'];
				$miscbillnumber=$resmisc['docno'];
				
				if($misctransactionamount > 0)
				{
					$grandtotal+=$misctransactionamount;
					
					 $query2 = "select subtype,accountname from master_visitentry where patientcode='$miscpatientcode' and visitcode='$miscvisitcode'";
			  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			 $res2 = mysql_fetch_array($exec2);
			   $subtypeanum = $res2['subtype'];
			  $accountnameanum = $res2['accountname'];
			  
					
					 $query4 = "select subtype from master_subtype where auto_number = '$subtypeanum'";
			  $exec4 = mysql_query($query4) or die ("Error in Query5".mysql_error());
			  $res4 = mysql_fetch_array($exec4);
			  $res4subtype = $res4['subtype'];
			
	          $query5 = "select accountname from master_accountname where auto_number = '$accountnameanum'";
			  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
			  $res5 = mysql_fetch_array($exec5);
			  $res5accountname = $res5['accountname'];
			 
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
              <td width="37"  align="left" valign="center" 
               class="bodytext31"><div align="left"><?php echo $sno++;?></div></td>
              <td width="70" align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $misctransactiondate;?></div></td>
              <td width="84" align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $miscbillnumber;?></div></td>
              <td width="109" align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $miscpatientcode;?></div></td>
              <td width="75" align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $miscvisitcode;?></div></td>
              <td width="267" align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $miscpatientname;?></div></td>
              <td width="278" align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $res4subtype;?></div></td>
              <td width="379" align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $res5accountname;?></div></td>
              <td width="141" align="left" valign="center"  
                 class="bodytext31"><div align="center"><?php echo number_format($misctransactionamount,2);?></div></td>
            </tr>
			<?php
			} 
			}
			*/
			?>
			<tr class="bodytext31" bgcolor="#ecf0f5">
              <td  align="left" colspan="8"><div align="right"><strong>Grand Total</strong></div></td>
              <td width="141"  align="left"><div align="center"><?php echo number_format($grandtotal,2);?></div></td>
			<?php
			}
			}
			?>
            
          </tbody>
        </table></td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

