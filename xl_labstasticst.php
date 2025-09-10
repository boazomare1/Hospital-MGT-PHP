<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");





$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));

$paymentreceiveddateto = date('Y-m-d');

$snocount='';

$colorloopcount='';

$execution='';

$countitem  = '';

$totalcount = '';

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



header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="labstatisticsreport.xls"');

header('Cache-Control: max-age=80');





if (isset($_REQUEST["slocation"])) { $slocation = $_REQUEST["slocation"]; } else { $slocation = ""; }

if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }			

			

if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }



if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

//$getcanum = $_GET['canum'];

if ($getcanum != '')

{

	$query4 = "select suppliername from master_supplier where auto_number = '$getcanum'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res4 = mysqli_fetch_array($exec4);

	$cbsuppliername = $res4['suppliername'];

	$suppliername = $res4['suppliername'];

}



if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{



	//$cbsuppliername = $_REQUEST['cbsuppliername'];

	//$suppliername = $_REQUEST['cbsuppliername'];

	$paymentreceiveddatefrom = $_REQUEST['ADate1'];

	$paymentreceiveddateto = $_REQUEST['ADate2'];

	$visitcode1 = 10;



}



if (isset($_REQUEST["task"])) { $task = $_REQUEST["task"]; } else { $task = ""; }

//$task = $_REQUEST['task'];

if ($task == 'deleted')

{

	$errmsg = 'Payment Entry Delete Completed.';

}


if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
if (isset($_REQUEST["ageinp"])) { $ageinp = $_REQUEST["ageinp"]; } else { $ageinp = ""; }
if (isset($_REQUEST["dmy"])) { $dmy = $_REQUEST["dmy"]; } else { $dmy = ""; }
if (isset($_REQUEST["eptype"])) { $eptype = $_REQUEST["eptype"]; } else { $eptype = ""; }
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

//$paymenttype = $_REQUEST['paymenttype'];

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

if (isset($_REQUEST["itemname"])) { $itemname = $_REQUEST["itemname"]; } else { $itemname = ""; }

if (isset($_REQUEST["itemcode"])) { $itemcode = $_REQUEST["itemcode"]; } else { $itemcode = ""; }

//$billstatus = $_REQUEST['billstatus'];

if ($ADate1 != '' && $ADate2 != '')

{

	$transactiondatefrom = $_REQUEST['ADate1'];

	$transactiondateto = $_REQUEST['ADate2'];

}

else

{

	$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

	$transactiondateto = date('Y-m-d');

}

$countitem  = '';

$totalcount = '';
$grandtotal=0;

if($eptype=='OPIP')
{
	$eptype='OP+IP';
}

if($location==''){

		$locationcodenew= "locationcode like '%%'";
		}else{
		$locationcodenew= "locationcode = '$location'";
		}

?>

<style type="text/css">

<!--



.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

-->

</style>

<script language="javascript">



function cbsuppliername1()

{

	document.cbform1.submit();

}



</script>

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

-->

</style>

<script language="javascript">



function funcPrintReceipt1(varRecAnum)

{

	var varRecAnum = varRecAnum

	//alert (varRecAnum);

	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php //echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

	window.open("print_payment_receipt1.php?receiptanum="+varRecAnum+"","OriginalWindow<?php //echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

}



function funcDeletePayment1(varPaymentSerialNumber)

{

	var varPaymentSerialNumber = varPaymentSerialNumber;

	var fRet;

	fRet = confirm('Are you sure want to delete this payment entry serial number '+varPaymentSerialNumber+'?');

	//alert(fRet);

	if (fRet == true)

	{

		alert ("Payment Entry Delete Completed.");

		//return false;

	}

	if (fRet == false)

	{

		alert ("Payment Entry Delete Not Completed.");

		return false;

	}

	//return false;

}



</script>

</head>



<script src="js/datetimepicker_css.js"></script>



<body>

<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="600" 

            align="left" border="0">

          <tbody>



		 <tr> <td colspan="6" align="center"><strong><u><h3>LAB TEST SUMMARY</h3></u></strong></td></tr>

         

         <tr>  <td colspan="6" align="center">

         <strong> Type : <?php echo "All"; ?> </strong></td> </tr>

		

		  <tr ><td colspan="6" align="center"><strong>Date From:    <?php echo $ADate1 ?>   To:  <?php echo $ADate2 ?></strong></td></tr>

		  <?php 

		  if($itemname != '')

		  {

		  ?>

   <tr ><td colspan="6" align="center"><strong>For The Test:    <?php echo $itemname; ?></strong></td></tr>

   <?php

   }

   ?>

            <tr>

              <td width="10%" bgcolor="" class="bodytext31">&nbsp;</td>

              <td colspan="5" bgcolor="" class="bodytext31"><span class="bodytext311">

              <?php

			 	

				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if ($cbfrmflag1 == 'cbfrmflag1')

				{

					//$cbbillstatus = $_REQUEST['cbbillstatus'];

					

					$transactiondatefrom = $_REQUEST['ADate1'];

					$transactiondateto = $_REQUEST['ADate2'];

					if (isset($_REQUEST["itemname"])) { $itemname = $_REQUEST["itemname"]; } else { $itemname = ""; }

					if (isset($_REQUEST["itemcode"])) { $itemcode = $_REQUEST["itemcode"]; } else { $itemcode = ""; }

					//$paymenttype = $_REQUEST['paymenttype'];

					//$billstatus = $_REQUEST['billstatus'];

					

					$urlpath = "cbcustomername=$cbcustomername&&cbbillnumber=$cbbillnumber&&cbbillstatus=$cbbillstatus&&ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";

				}

				else

				{

					$urlpath = "cbcustomername=$cbcustomername&&cbbillnumber=$cbbillnumber&&cbbillstatus=$cbbillstatus&&ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";

				}

				?>

 				<?php

				//For excel file creation.

				

				$applocation1 = $applocation1; //Value from db_connect.php file giving application path.

				$filename1 = "print_paymentgivenreport1.php?$urlpath";

				$fileurl = $applocation1."/".$filename1;

				$filecontent1 = @file_get_contents($fileurl);

				

				$indiatimecheck = date('d-M-Y-H-i-s');

				$foldername = "dbexcelfiles";

				//$fp = fopen($foldername.'/PaymentGivenToSupplier.xls', 'w+');
				
				//$fp = '';

				//fwrite($fp, $filecontent1);

				//fclose($fp);



				?>

              <script language="javascript">

				function printbillreport1()

				{

					window.open("print_paymentgivenreport1.php?<?php echo $urlpath; ?>","Window1",'width=900,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

					//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');

				}

				function printbillreport2()

				{

					window.location = "dbexcelfiles/PaymentGivenToSupplier.xls"

				}

				</script>

              <!--<input  value="Print Report" onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" />

&nbsp;				<input  value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />-->

</span></td>

            </tr>      
            
            
            
                	<?php
					 if($eptype=='OP+IP' || $eptype=='OP'){ ?>
			<tr>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><strong>OP Tests</strong></td>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff">&nbsp;</td>
			</tr>
			<tr>
				<td class="bodytext31" valign="center"  align="left" >&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" >&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" >&nbsp;</td>
			</tr>
			<tr>
				<td width="17%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
				<td width="39%" align="left" valign="left"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Test Name </strong></div></td>
				<td width="44%" align="center" valign="center"  bgcolor="#ffffff" class="style1">Quantity</td>
			</tr>
			<tr bgcolor="#9999FF">
				<td colspan="7"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo  'Between '.$transactiondatefrom.' and '.$transactiondateto;?></strong></td>
			</tr>
			 <?php
			$totalcount1=0;
			 $query1 = "select labitemname,labitemcode,labsamplecoll,consultationdate,patientcode,patientvisitcode  from consultation_lab where  labsamplecoll = 'completed' and labitemcode like '%$itemcode%' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and $locationcodenew group by labitemcode";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num1 = mysqli_num_rows($exec1);
			//echo $num1;
			while($res1 = mysqli_fetch_array($exec1))
		    {
        	 $res1itemname = $res1['labitemname'];
        	 $res1itemcode = $res1['labitemcode'];
			 
        	  
			$countitem=0;
			$query2 = "select  labitemname,labitemcode,labsamplecoll,consultationdate,patientcode,patientvisitcode,sampleid from consultation_lab where labsamplecoll = 'completed' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and labitemcode = '$res1itemcode' and labitemrate<>'0.00' and $locationcodenew ";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num2 = mysqli_num_rows($exec2);
			while($res2 = mysqli_fetch_array($exec2))
			{
			$res2labitemname = $res2['labitemname'];
			$res2itemcode = $res2['labitemcode'];
			$res2labsamplecoll = $res2['labsamplecoll'];
			$res2patientcode = $res2['patientcode'];
			$res2patientvisitcode = $res2['patientvisitcode'];
			$res2sampleid = $res2['sampleid'];
			
				$query44 = "select auto_number from resultentry_lab where itemcode = '$res2itemcode' and patientvisitcode = '$res2patientvisitcode' and patientcode = '$res2patientcode' and sampleid='$res2sampleid' ";
				$exec44 =mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num44 = mysqli_num_rows($exec44);
				if($num44 !=0)
				{
					
				$query751 = "select * from master_customer where customercode = '$res2patientcode'";
				$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res751 = mysqli_fetch_array($exec751);
				$dob = $res751['dateofbirth'];

				$today = new DateTime();
				$comdob = new DateTime($dob);
				$diff = $today->diff($comdob);
				$totaldiffyears = $diff->y;
				$totaldiffmonths = $diff->m;
				$totaldiffdays = $diff->d;

				if ($diff->y)
				{
				$age= $diff->y . ' Years';
				$monthsdayscondition = '';
				}
				elseif ($diff->m)
				{
				$age =$diff->m . ' Months';
				$monthsdayscondition = 'monthsordays';
				}
				else
				{
				$age =$diff->d . ' Days';
				$monthsdayscondition = 'monthsordays';
				}
				
				if($ageinp!=""){
				if($dmy == 'years'){
					if($range == '='){
						if($totaldiffyears == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}
							
					}	
					if($range == '>'){
						if($totaldiffyears > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}
					}		
					if($range == '<'){
						if($totaldiffyears < $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffyears >= $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffyears <= $ageinp){
							$execution = true;
						}				
						else{
							$execution = false;
						}						
					}	
				
						if($execution == 'true'){
						
							
						$countitem=$countitem+1 ;
						
					 } }
				
				if($dmy == 'months'){
					
					if($range == '='){
						if($totaldiffmonths == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}	
					if($range == '>'){
						if($totaldiffmonths > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}		
					if($range == '<'){
						if($totaldiffmonths < $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffmonths >= $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffmonths <= $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}						
					
					
					if($execution == true){
						
						$countitem=$countitem+1 ;
						
					 } }
				
				if($dmy == 'days'){
					
					
					if($range == '='){
						if($totaldiffmonths == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}	
					if($range == '>'){
						if($totaldiffmonths > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}		
					if($range == '<'){
						if($totaldiffmonths < $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffmonths >= $ageinp){
							$execution = true;
						}				
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffmonths <= $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}						
					if($execution == true){
				
					$countitem=$countitem+1 ;
					}
					}
				}
				else{
						$countitem=$countitem+1 ;
				}
				}
            }
			if($countitem>0){
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
           <tr >
				<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
				<td class="bodytext31" valign="center"  align="left"> <?php echo $res1itemname; ?>           </td>
				<td class="bodytext31" valign="center"  align="center"> <?php echo $countitem; ?>           </td>
			</tr>
				<?php
				$totalcount1 = $totalcount1 + $countitem;
				} 
			}
			
				$grandtotal= $grandtotal+$totalcount1;
				?>
			<tr>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5"><strong>Total Count</strong></td>
				<td class="bodytext31" valign="center"  align="center" bgcolor="#ecf0f5"><strong><?php echo $totalcount1; ?></strong></td>
			</tr>
			<tr>
				<td class="bodytext31" valign="center"  align="left" >&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" >&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left"	>&nbsp;</td>
			</tr>
			<?php 
			}
			if($eptype=='OP+IP' || $eptype=='IP')
			{
			?>
			
			<tr>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><strong>IP Tests</strong></td>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff">&nbsp;</td>
			</tr>
			<tr>
				<td class="bodytext31" valign="center"  align="left" >&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" >&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" >&nbsp;</td>
			</tr>
			<tr>
				<td width="17%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
				<td width="39%" align="left" valign="left"  	bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Test Name </strong></div></td>
				<td width="44%" align="center" valign="center"  bgcolor="#ffffff" class="style1">Quantity</td>
			</tr>

			<tr bgcolor="#9999FF">
				<td colspan="7"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo  'Between '.$transactiondatefrom.' and '.$transactiondateto;?></strong></td>
			</tr>
			<?php
			
			$snocount =0;
			
			$totalcount=0;
			$colorloopcount=0;
			$query1 = "select labitemname,labitemcode,labsamplecoll,consultationdate from ipconsultation_lab where  labsamplecoll = 'completed' and labitemcode like '%$itemcode%' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and $locationcodenew group by labitemcode ";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num1 = mysqli_num_rows($exec1);
			while($res1 = mysqli_fetch_array($exec1))
			{
			$res1itemname = $res1['labitemname'];
			$res1labitemcode = $res1['labitemcode'];
			
			$countitem=0;
			$query2 = "select labitemname,labitemcode,labsamplecoll,patientcode,patientvisitcode,sampleid from ipconsultation_lab where labsamplecoll = 'completed' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and labitemcode = '$res1labitemcode' and $locationcodenew";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num2 = mysqli_num_rows($exec2);
			while($res2 = mysqli_fetch_array($exec2))
			{
			$res2labitemname = $res2['labitemname'];
			$res2itemcode = $res2['labitemcode'];
			$res2labsamplecoll = $res2['labsamplecoll'];
			$res2patientcode = $res2['patientcode'];
			$res2patientvisitcode = $res2['patientvisitcode'];
			$res2sampleid = $res2['sampleid'];
				
				
				$query44 = "select auto_number from ipresultentry_lab where itemcode = '$res2itemcode' and patientvisitcode = '$res2patientvisitcode' and patientcode = '$res2patientcode' and sampleid='$res2sampleid' ";
				$exec44 =mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num44 = mysqli_num_rows($exec44);
				if($num44 !=0)
				{
					
				$query751 = "select * from master_customer where customercode = '$res2patientcode'";
				$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res751 = mysqli_fetch_array($exec751);
				$dob = $res751['dateofbirth'];

				$today = new DateTime();
				$comdob = new DateTime($dob);
				$diff = $today->diff($comdob);
				$totaldiffyears = $diff->y;
				$totaldiffmonths = $diff->m;
				$totaldiffdays = $diff->d;

				if ($diff->y)
				{
				$age= $diff->y . ' Years';
				$monthsdayscondition = '';
				}
				elseif ($diff->m)
				{
				$age =$diff->m . ' Months';
				$monthsdayscondition = 'monthsordays';
				}
				else
				{
				$age =$diff->d . ' Days';
				$monthsdayscondition = 'monthsordays';
				}
				
				if($ageinp!=""){
				if($dmy == 'years'){
					if($range == '='){
						if($totaldiffyears == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}
							
					}	
					if($range == '>'){
						if($totaldiffyears > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}
					}		
					if($range == '<'){
						if($totaldiffyears < $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffyears >= $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffyears <= $ageinp){
							$execution = true;
						}				
						else{
							$execution = false;
						}						
					}	
				
						if($execution == 'true'){
						
							
						$countitem=$countitem+1 ;
						
					 } }
				
				if($dmy == 'months'){
					
					if($range == '='){
						if($totaldiffmonths == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}	
					if($range == '>'){
						if($totaldiffmonths > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}		
					if($range == '<'){
						if($totaldiffmonths < $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffmonths >= $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffmonths <= $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}						
					
					
					if($execution == true){
						
						$countitem=$countitem+1 ;
						
					 } }
				
				if($dmy == 'days'){
					
					
					if($range == '='){
						if($totaldiffmonths == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}	
					if($range == '>'){
						if($totaldiffmonths > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}		
					if($range == '<'){
						if($totaldiffmonths < $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffmonths >= $ageinp){
							$execution = true;
						}				
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffmonths <= $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}						
					if($execution == true){
				
					$countitem=$countitem+1 ;
					}
					}
				}
				else{
						$countitem=$countitem+1 ;
				}
				}
			}
			if($countitem>0){
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
			<tr>
				<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $res1itemname; ?>           </td>
				<td class="bodytext31" valign="center"  align="center"><?php echo $countitem; ?>           </td>
			</tr>
				<?php
				$totalcount = $totalcount + $countitem;
				} 
			}
				$grandtotal= $grandtotal+$totalcount;
				?>
			<tr>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5"><strong>Total Count</strong></td>
				<td class="bodytext31" valign="center"  align="center" bgcolor="#ecf0f5"><strong><?php echo $totalcount;?></strong></td>
			</tr>
			<?php } 
			if($eptype=='Combain')
			{
			?>
			<tr>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><strong>Combain Tests</strong></td>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff">&nbsp;</td>
			</tr>
			<tr>
				<td class="bodytext31" valign="center"  align="left" >&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" >&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" >&nbsp;</td>
			</tr>
			<tr>
				<td width="17%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
				<td width="39%" align="left" valign="left"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Test Name </strong></div></td>
				<td width="44%" align="center" valign="center"  bgcolor="#ffffff" class="style1">Quantity</td>
			</tr>
			<tr bgcolor="#9999FF">
				<td colspan="7"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo  'Between '.$transactiondatefrom.' and '.$transactiondateto;?></strong></td>
			</tr>
			<?php
			//op start
			$totalcount1=0;
			$query1 = "select labitemname,labitemcode  from (
			select labitemname,labitemcode  from consultation_lab where  labsamplecoll = 'completed' and labitemcode like '%$itemcode%' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and $locationcodenew 
			UNION ALL 
			select labitemname,labitemcode from ipconsultation_lab where  labsamplecoll = 'completed' and labitemcode like '%$itemcode%' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and $locationcodenew) as e group by labitemcode";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num1 = mysqli_num_rows($exec1);
			//echo $num1;
			while($res1 = mysqli_fetch_array($exec1))
		    {
			$res1itemname = $res1['labitemname'];
			$res1itemcode = $res1['labitemcode'];
			 
        	$itemtot=0; 
			$countitem=0;
			$query2 = "select  labitemname,labitemcode,labsamplecoll,consultationdate,patientcode,patientvisitcode,sampleid from consultation_lab where labsamplecoll = 'completed' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and labitemcode = '$res1itemcode' and labitemrate<>'0.00' and $locationcodenew ";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num2 = mysqli_num_rows($exec2);
			while($res2 = mysqli_fetch_array($exec2))
			{
			$res2labitemname = $res2['labitemname'];
			$res2itemcode = $res2['labitemcode'];
			$res2labsamplecoll = $res2['labsamplecoll'];
			$res2patientcode = $res2['patientcode'];
			$res2patientvisitcode = $res2['patientvisitcode'];
			$res2sampleid = $res2['sampleid'];
			
				$query44 = "select auto_number from resultentry_lab where itemcode = '$res2itemcode' and patientvisitcode = '$res2patientvisitcode' and patientcode = '$res2patientcode' and sampleid='$res2sampleid' ";
				$exec44 =mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num44 = mysqli_num_rows($exec44);
				if($num44 !=0)
				{
					
				$query751 = "select * from master_customer where customercode = '$res2patientcode'";
				$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res751 = mysqli_fetch_array($exec751);
				$dob = $res751['dateofbirth'];

				$today = new DateTime();
				$comdob = new DateTime($dob);
				$diff = $today->diff($comdob);
				$totaldiffyears = $diff->y;
				$totaldiffmonths = $diff->m;
				$totaldiffdays = $diff->d;

				if ($diff->y)
				{
				$age= $diff->y . ' Years';
				$monthsdayscondition = '';
				}
				elseif ($diff->m)
				{
				$age =$diff->m . ' Months';
				$monthsdayscondition = 'monthsordays';
				}
				else
				{
				$age =$diff->d . ' Days';
				$monthsdayscondition = 'monthsordays';
				}
				
				if($ageinp!=""){
				if($dmy == 'years'){
					if($range == '='){
						if($totaldiffyears == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}
							
					}	
					if($range == '>'){
						if($totaldiffyears > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}
					}		
					if($range == '<'){
						if($totaldiffyears < $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffyears >= $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffyears <= $ageinp){
							$execution = true;
						}				
						else{
							$execution = false;
						}						
					}	
				
						if($execution == 'true'){
						
							
						$countitem=$countitem+1 ;
						
					 } }
				
				if($dmy == 'months'){
					
					if($range == '='){
						if($totaldiffmonths == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}	
					if($range == '>'){
						if($totaldiffmonths > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}		
					if($range == '<'){
						if($totaldiffmonths < $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffmonths >= $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffmonths <= $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}						
					
					
					if($execution == true){
						
						$countitem=$countitem+1 ;
						
					 } }
				
				if($dmy == 'days'){
					
					
					if($range == '='){
						if($totaldiffmonths == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}	
					if($range == '>'){
						if($totaldiffmonths > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}		
					if($range == '<'){
						if($totaldiffmonths < $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffmonths >= $ageinp){
							$execution = true;
						}				
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffmonths <= $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}						
					if($execution == true){
				
					$countitem=$countitem+1 ;
					}
					}
				}
				else{
						$countitem=$countitem+1 ;
				}
				}
            }
				if($countitem>0){
						$totalcount1 = $totalcount1 + $countitem;
						$itemtot = $itemtot + $countitem;
				} 
			
			$countitem1=0;
			$query2 = "select labitemname,labitemcode,labsamplecoll,patientcode,patientvisitcode,sampleid from ipconsultation_lab where labsamplecoll = 'completed' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and labitemcode = '$res1itemcode' and $locationcodenew";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num2 = mysqli_num_rows($exec2);
			while($res2 = mysqli_fetch_array($exec2))
			{
			$res2labitemname = $res2['labitemname'];
			$res2itemcode = $res2['labitemcode'];
			$res2labsamplecoll = $res2['labsamplecoll'];
			$res2patientcode = $res2['patientcode'];
			$res2patientvisitcode = $res2['patientvisitcode'];
			$res2sampleid = $res2['sampleid'];
				
				
				$query44 = "select auto_number from ipresultentry_lab where itemcode = '$res2itemcode' and patientvisitcode = '$res2patientvisitcode' and patientcode = '$res2patientcode' and sampleid='$res2sampleid' ";
				$exec44 =mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num44 = mysqli_num_rows($exec44);
				if($num44 !=0)
				{
					
				$query751 = "select * from master_customer where customercode = '$res2patientcode'";
				$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res751 = mysqli_fetch_array($exec751);
				$dob = $res751['dateofbirth'];

				$today = new DateTime();
				$comdob = new DateTime($dob);
				$diff = $today->diff($comdob);
				$totaldiffyears = $diff->y;
				$totaldiffmonths = $diff->m;
				$totaldiffdays = $diff->d;

				if ($diff->y)
				{
				$age= $diff->y . ' Years';
				$monthsdayscondition = '';
				}
				elseif ($diff->m)
				{
				$age =$diff->m . ' Months';
				$monthsdayscondition = 'monthsordays';
				}
				else
				{
				$age =$diff->d . ' Days';
				$monthsdayscondition = 'monthsordays';
				}
				
				if($ageinp!=""){
				if($dmy == 'years'){
					if($range == '='){
						if($totaldiffyears == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}
							
					}	
					if($range == '>'){
						if($totaldiffyears > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}
					}		
					if($range == '<'){
						if($totaldiffyears < $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffyears >= $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffyears <= $ageinp){
							$execution = true;
						}				
						else{
							$execution = false;
						}						
					}	
				
						if($execution == 'true'){
						
							
						$countitem1=$countitem1+1 ;
						
					 } }
				
				if($dmy == 'months'){
					
					if($range == '='){
						if($totaldiffmonths == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}	
					if($range == '>'){
						if($totaldiffmonths > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}		
					if($range == '<'){
						if($totaldiffmonths < $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffmonths >= $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffmonths <= $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}						
					
					
					if($execution == true){
						
						$countitem1=$countitem1+1 ;
						
					 } }
				
				if($dmy == 'days'){
					
					
					if($range == '='){
						if($totaldiffmonths == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}	
					if($range == '>'){
						if($totaldiffmonths > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}		
					if($range == '<'){
						if($totaldiffmonths < $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffmonths >= $ageinp){
							$execution = true;
						}				
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffmonths <= $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}						
					if($execution == true){
				
					$countitem1=$countitem1+1 ;
					}
					}
				}
				else{
						$countitem1=$countitem1+1 ;
				}
				}
			}
				if($countitem1>0){
				  $totalcount1 = $totalcount1 + $countitem1;
				  $itemtot = $itemtot + $countitem1;
				} 
			if($itemtot>0){	
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
			<tr >
				<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $res1itemname; ?>           </td>
				<td class="bodytext31" valign="center"  align="center"><?php echo $countitem+$countitem1; ?>           </td>
			</tr>	
			<?php	
			}
			}
			//ip end 
			
			$grandtotal= $grandtotal+$totalcount1;
			?>
			<?php
			}
			?>

              <tr>

              <td class="bodytext31" valign="center"  align="left" 

                >&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                ><strong>Grand Total Count</strong></td>

              <td class="bodytext31" valign="center"  align="center" 

                ><strong><?php echo  $grandtotal;?></strong></td>

              </tr>

          </tbody>

        </table>

</body>

</html>



