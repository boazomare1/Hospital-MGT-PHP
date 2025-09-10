  <?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$docno = $_SESSION['docno'];




$res45transactionamount = 0;
$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));

$paymentreceiveddateto = date('Y-m-d');

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$ADate2 = date('Y-m-d');



$billnumbers=array();

$billnumbers1=array();



$query01="select locationcode from login_locationdetails where username='$username' and docno='$docno'";

$exe01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);

$res01=mysqli_fetch_array($exe01);

 $locationcode=$res01['locationcode'];



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

$snocount1 = 0;

if (isset($_REQUEST["billno"])) {  $billno = $_REQUEST["billno"]; } else { $billno = ""; }

//echo $searchsuppliername;

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $ADate1 = date('Y-m-d'); }

$paymentreceiveddatefrom=$ADate1;

//echo $ADate1;

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $ADate1 = date('Y-m-d'); }

$paymentreceiveddateto=$ADate2;


if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

if (isset($_REQUEST["allcationtype"])) { $allcationtype = $_REQUEST["allcationtype"]; } else { $allcationtype = ""; }


//$frmflag2 = $_POST['frmflag2'];


?>

<style type="text/css">

.ui-menu .ui-menu-item{ zoom: 1 !important;}

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}



</style>

<link href="autocomplete.css" rel="stylesheet">

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>



<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>

<script>

function funcAccount()

{

if((document.getElementById("searchsuppliername").value == "")||(document.getElementById("searchsuppliername").value == " "))

{

alert('Please Select Doctor');

return false;

}

}

function loadprintpagepdf2(billnumber,doctorcode)

{


		window.open("print_doctorstmtbill.php?billnumber="+billnumber+'&&doctorcode='+doctorcode,"Window",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');

}
$(document).ready(function($){

    $('#searchsuppliername').autocomplete({

		

	

	source:"ajaxdoctornewserach.php",

	//alert(source);

	matchContains: true,

	minLength:1,

	html: true, 

		select: function(event,ui){

			var code = ui.item.customercode;

			$("#searchsuppliercode").val(code);

			

			},

    });

});

</script>



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



<script src="js/datetimepicker_css.js"></script>



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

    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="860">

		

		

              <form name="cbform1" method="post" action="">

		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Doctor Outstanding Invoice Wise</strong></td>

              </tr>
           <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Bill Number</td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

              <input name="billno" type="text" id="billno" value="" size="50" autocomplete="off">

              </span></td>

           </tr>

		    <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

             <strong> -OR- <strong>

              </span></td>

            </tr>

			<tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Allocation</td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

              <select name='allcationtype' id='allcationtype'>
			   <option value='Fully' <?php if($allcationtype=="Fully") echo "selected"; else echo "";?>>Fully</option>
			   <option value='Partly' <?php if($allcationtype=="Partly") echo "selected"; else echo "";?>>Partly</option>

			  </select>

              </span></td>

           </tr>

		   

			  <tr>

                      <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF"> Date From </td>

                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>

                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>

                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">

                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                        <!--<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span>-->
                         <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2','yyyyMMdd','','','','','past','07-01-2019','<?php echo date('m-d-Y');?>')" style="cursor:pointer"/>
                      </td>

                    </tr>	

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

              <input type="hidden" name="subcode" value="<?php echo $searchsuppliercode; ?>">

			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                  <input type="submit" onClick="return funcAccount();" value="Search" name="Submit" />

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

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1250" 

            align="left" border="0">

          <tbody>

            <tr>

              <td width="4%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              <td colspan="14" bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311">

              <?php

				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				

				?>


</span></td>  

            </tr>

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></td>

              <td width="7%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>

              <td width="20%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></td>
                 <td width="8%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Bill Number</strong></td>
                 <td width="" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Company </strong></td>

				
			    <td width="3%" align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><strong>Allotted</strong></td>

             
              <td width="8%" align="right" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Invoice Amt</strong></td>

              <td width="10%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Total Doctors Amt</strong></div></td>

                 <td width="5%" align="right" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>CrN</strong></td>

				<td width="85" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Payable Amt</strong></div></td>


				<td width="6%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Paid Amt</strong></div></td>

				<td width="8%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Invoice Balance</strong></div></td>

				<td width="10%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align=""><strong>Doctor Name</strong></div></td>

				<td width="8%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Doctors Paid</strong></div></td>

				<td width="8%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Doctors Bal.</strong></div></td>

            </tr>

			<?php
			

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }


			if ($cbfrmflag1 == 'cbfrmflag1')
			{


			?>

				<!--<tr bgcolor="#ffffff">

					<td colspan="16"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>(Date From: <?php echo $ADate1; ?> Date To: <?php echo $ADate2; ?>)</strong></td>

				</tr>-->

				

			<?php
				
			
            $snocount = 0;

			if($billno!=''){
				$subquery="docno = '$billno'";
				$type="invoice";
			}
			else{
				$subquery="recorddate between '$ADate1' and '$ADate2'";
				$type="allocation";
			}

			$query2 = "SELECT patientname,patientcode,visitcode,docno,recorddate,doccoa,visittype,sum(transactionamount) as transactionamount,sum(sharingamount) as sharingamount from billing_ipprivatedoctor where $subquery and doccoa!='' group by docno,doccoa";
            
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowcount2 = mysqli_num_rows($exec2);
			while ($res2 = mysqli_fetch_array($exec2))
			{	
				
				$suppliername1 = $res2['patientname'];
				$patientcode = $res2['patientcode'];
				$visitcode = $res2['visitcode'];
				$billnumber = $res2['docno'];
				$billdate = $res2['recorddate'];
				$doccoa=$res2['doccoa'];

				$query21 = "select doctorname from master_doctor where doctorcode = '$doccoa'";
				$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res21 = mysqli_fetch_array($exec21);
				$doctorname = $res21['doctorname'];

				$query2b = "SELECT sum(transactionamount) as transactionamount,sum(sharingamount) as transactionamount1 from billing_ipprivatedoctor where docno = '$billnumber' and doccoa!='' group by docno";
				$exec2b = mysqli_query($GLOBALS["___mysqli_ston"], $query2b) or die ("Error in query2b".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res2b = mysqli_fetch_array($exec2b);
				
			
			    $query11 = "SELECT billtype,subtype from master_visitentry where patientcode = '$patientcode' and visitcode = '$visitcode'  ";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
				$num11 =mysqli_num_rows($exec11);
				$billtype = $res11['billtype'];
				$subtype = $res11['subtype'];
				
				if($num11 ==0)
				{
				$query11 = "SELECT billtype,subtype from master_ipvisitentry where patientcode = '$patientcode' and visitcode = '$visitcode' ";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
				$billtype = $res11['billtype'];
				$subtype = $res11['subtype'];
				}

				
                if(isset($billtype2) && $billtype2!='')
					$billtype2=$billtype2;
				else
					$billtype2=$billtype;
                
				$invoiceallocatedamt=0;
				$invoiceamt = 0;


				
                $alloted_status='No';
				if($billtype2 == 'PAY NOW' || strpos( $billnumber, "CF-" ) !== false)
				{
				   $alloted_status = "Yes";
				   

				}
				elseif($billtype2 == 'PAY LATER')
			    {

			   		 $transc_amt = 0;

					 $query27 = "select sum(billbalanceamount) as billbalanceamount from master_transactionpaylater where billnumber='$billnumber' and (recordstatus='allocated' || recordstatus='') and transactionstatus <> 'onaccount' and acc_flag = '0'  and transactiontype='PAYMENT'";


					$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));

					$num2 = mysqli_num_rows($exec27);

					if($num2==0){
						$alloted_status = "No";
					}else{
                        

						$res27 = mysqli_fetch_array($exec27);
						$transc_amt_bal = $res27['billbalanceamount'];						

						if($transc_amt_bal==null || $transc_amt_bal=="")
						{
						 $alloted_status = "No";
						}
						elseif($transc_amt_bal>0 )
						{
						 $alloted_status = "Partly";
						}
						else
						{
						 $alloted_status = "Fully";
						}
					
					}

					$query27 = "select sum(transactionamount) as transactionamount from master_transactionpaylater where billnumber='$billnumber' and (recordstatus='allocated' || recordstatus='') and transactionstatus <> 'onaccount' and transactiontype='PAYMENT'";
					$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res27 = mysqli_fetch_array($exec27);
					$invoiceallocatedamt = $res27['transactionamount'];

					
			   }

			   if($type=='allocation'){
                  if($allcationtype=='Fully' && ($alloted_status=="No" || $alloted_status=="Partly"))
					  continue;
				  elseif($allcationtype=='Partly' && ($alloted_status=="No" || $alloted_status=="Fully" || $alloted_status=="Yes"))
					  continue;
			   }


			   $subtypesql="select subtype from master_subtype where auto_number='$subtype'";
				$sexec11 = mysqli_query($GLOBALS["___mysqli_ston"], $subtypesql) or die ("Error in subtypesql".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sres11 = mysqli_fetch_array($sexec11);
				$subtype = $sres11['subtype'];

				if($res2['visittype']=='OP'){
				  $amount_topay_doc = $res2['transactionamount'];				
				  $totaldocamt = $res2b['transactionamount'];

				}
				else{
				  $amount_topay_doc = $res2['sharingamount'];
				  $totaldocamt = $res2b['transactionamount1'];
				}

				if(strpos( $billnumber, "CF-" ) !== false){
                    $query27b = "select sum(subtotalamount) as transactionamount from master_billing where billnumber='$billnumber'";
					  $exec27b = mysqli_query($GLOBALS["___mysqli_ston"], $query27b) or die ("Error in query27b".mysqli_error($GLOBALS["___mysqli_ston"]));
					  $res27b = mysqli_fetch_array($exec27b);
					  $invoiceamt = $res27b['transactionamount'];
				  
				}else{   
					  $query27b = "select sum(fxamount) as transactionamount from master_transactionpaylater where billnumber='$billnumber' and transactiontype='finalize'";
				  $exec27b = mysqli_query($GLOBALS["___mysqli_ston"], $query27b) or die ("Error in query27b".mysqli_error($GLOBALS["___mysqli_ston"]));
				  $res27b = mysqli_fetch_array($exec27b);
				  $invoiceamt = $res27b['transactionamount'];					 

				  }



			    $query27 = "select sum(amount) as amount from adhoc_creditnote where ref_no='$billnumber'";
				$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res27 = mysqli_fetch_array($exec27);
				$crnamt = $res27['amount'];

                $res45transactionamount=0;
				$query234 = "SELECT sum(sharingamount) as sharingamount, sum(transactionamount) as transactionamount, docno, percentage, pvtdr_percentage, visittype FROM `billing_ipprivatedoctor_refund` WHERE doccoa='$doccoa'  AND `visitcode` =  '$visitcode' and against_refbill='$billnumber' group by docno, visitcode 
					union all SELECT 0 as sharingamount, sum(amount) as transactionamount, docno, '' as percentage, '' as pvtdr_percentage,'adhoc_creditnote_min' as visittype FROM `adhoc_creditnote` WHERE billingaccountcode='$doccoa'  AND `patientvisitcode` =  '$visitcode' and consultationdate <= '$ADate2' group by docno, patientvisitcode 
					union ALL select 0 as sharingamount, sum(transactionamount) as transactionamount,docno,'' as percentage,'' as pvtdr_percentage, 'master_transactiondoctor' as visittype  from master_transactiondoctor where  debit_reference_no IS NULL and doctorcode='$doccoa' and `visitcode` =  '$visitcode' and transactiondate <='$ADate2' and billnumber='$billnumber'
					
					";

				//union ALL select 0 as sharingamount, sum(transactionamount) as transactionamount,docno,'' as percentage,'' as pvtdr_percentage, 'master_transactiondoctor' as visittype  from master_transactiondoctor where  debit_reference_no IS NULL and doctorcode='$doccoa' and `visitcode` =  '$visitcode' and transactiondate <='$ADate2' and billnumber='$billnumber'

				$exec234 = mysqli_query($GLOBALS["___mysqli_ston"], $query234) or die ("Error in Query234".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num234=mysqli_num_rows($exec234);
				while($res234 = mysqli_fetch_array($exec234)){
                   $res45transactionamount_old=0;
				              $ref_doc = $res234['docno'];
				              $res45vistype = $res234['visittype'];
				              $res45transactionamount_old = $res234['sharingamount'];
				              if($res45vistype == "OP")
				              {
				              	$res45doctorperecentage = $res234['percentage'];
				              	 $res45transactionamount_old = $res234['transactionamount'];
				              }
				              if($res45vistype == "IP")
				              {
				              	$res45doctorperecentage = $res234['pvtdr_percentage'];
				              }

				              /// for CRN Bills
				              if($res45vistype == 'adhoc_creditnote_min'){
				              	 $res45transactionamount_old = $res234['transactionamount'];
				              }
				              /// for CRN Bills

				     if($res45vistype == 'master_transactiondoctor')
				        {
				           $res45transactionamount_old = $res234['transactionamount'];
				          // $taxamount = $res234['taxamount'];
				          // $amtwithouttax = $res45transactionamount_old - $taxamount;

				            $query124 = "select sum(original_amt) as original_amt,transactionamount, visittype,percentage,pvtdr_percentage,billtype as billtype2 from billing_ipprivatedoctor where doccoa='$doccoa' and docno='$ref_doc' and transactionamount >0";
				            $exec124 = mysqli_query($GLOBALS["___mysqli_ston"], $query124) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				            $res124 = mysqli_fetch_array($exec124);
				            $res45billamount = $res124['original_amt'];
				            $res45vistype = $res124['visittype'];
							//$billtype2 = $res124['billtype2'];
				             if($res45vistype == "OP")
				              {

				              $res45doctorperecentage = $res234['percentage'];

				              $res45transactionamount_old = $res234['transactionamount'];
				              }
				              else
				              {

				              $res45doctorperecentage = $res234['pvtdr_percentage'];

				              }
				              
				            
				        }

				        $res45transactionamount=$res45transactionamount+$res45transactionamount_old;

				}


               $amount_topay_doc=$amount_topay_doc-$res45transactionamount;

			   $colorloopcount = $colorloopcount + 1;

				$showcolor = ($colorloopcount & 1); 

				if ($showcolor == 0)
				{ $colorcode = 'bgcolor="#CBDBFA"';
				}
				else
				{
					$colorcode = 'bgcolor="#ecf0f5"';
				}
                if($amount_topay_doc>0){

				if($billtype2 == 'PAY NOW' || strpos( $billnumber, "CF-" ) !== false)
				{
				   $invoicebalance=0;
				   

				}
				elseif($billtype2 == 'PAY LATER')
			    {
				  $invoicebalance=$invoiceamt-$crnamt-$invoiceallocatedamt;
				}

				?>
                <tr <?php echo $colorcode; ?>>

				  <td class="bodytext31" valign="center"  align="left"><?php echo $snocount=$snocount+1; ?></td>

				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $suppliername1; ?> (<?php echo $patientcode; ?>, <?php echo $visitcode; ?>)</div></td>
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billnumber; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $subtype; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $alloted_status; ?></div></td>
                  
				  <td class="bodytext31" valign="center"  align="right"><div align="right"><?php echo number_format($invoiceamt,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="right"><div align="right"><?php echo number_format($totaldocamt,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="right"><div align="right"><?php echo number_format($crnamt,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="right"><div align="right"><?php echo number_format($invoiceamt-$crnamt,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="right"><div align="right"><?php echo number_format($invoiceallocatedamt,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="right"><div align="right"><?php echo @number_format($invoicebalance,2,'.',','); ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $doctorname; ?></div></td>
				  <td class="bodytext31" valign="center"  align="right"><div align="right"><?php echo number_format($res45transactionamount,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="right"><div align="right"><?php echo number_format($amount_topay_doc,2,'.',','); ?></div></td>

				</tr>
				<?php
				}

			}

			?>

			

            <tr>

              <td colspan="15" class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5">&nbsp;</td>

            </tr>

				

	  
			

		   <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				

           <?php

				if($billno!='')
					$urlpath = "cbfrmflag1=cbfrmflag1&&billno=$billno";
				else
					$urlpath = "cbfrmflag1=cbfrmflag1&ADate1=$ADate1&ADate2=$ADate2&allcationtype=$allcationtype";

			

			?>

            <td class="bodytext31" valign="center"  align="right"></td> 

		   	 <td class="bodytext31" valign="center" ><a href="print_doctoroutstandinginvoicexl.php?<?php echo $urlpath; ?>" target="_blank"><img  width="40" height="40" src="images/excel-xls-icon.png" style="cursor:pointer;" ></a></td> 

			        

            </tr>

		</table>

			  

			<?php

			

			//}

			//}

			}

			?>

         

</table>

</table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>

