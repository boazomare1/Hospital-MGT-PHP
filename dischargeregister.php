<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");


$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedate = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));

$paymentreceiveddateto = date('Y-m-d');

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');





$snocount = "";

$colorloopcount="";

$range = "";

$opnumber = "";

$ipnumber = "";

$patientname = "";

$dateofadmission = "";

$dateofdischarge = "";

$class = "";

$admissiondoc = "";

$consultingdoc = "";

$revenue = "";

$returns = "";

$discount = "";

$nhif = "";

$netbill = "";

$invoiceno = "";

$dischargedby = "";

$wardcode = "";

$locationcode = "";

$patientcode = "";

$consultationfee = 0;

$labrate = 0;

$pharmamount = 0;

$radrate=0;

$serrate=0;

$bedallocationamount = 0;

$bedtransferamount = 0;

$packageamount = 0;

$sumoveralltotal = 0;

$sumrevenue = 0;

$sumnet = 0;





//This include updatation takes too long to load for hunge items database.

//include ("autocompletebuild_customer2.php");


if (isset($_REQUEST["ward"])) { $ward12 = $_REQUEST["ward"]; } else { $ward12 = ""; }


if (isset($_REQUEST["wardcode1"])) { $wardcode = $_REQUEST["wardcode1"]; } else { $wardcode = ""; }



if (isset($_REQUEST["locationcode"])) { $locationcode1 = $_REQUEST["locationcode"]; } else { $locationcode1 = ""; }

//echo $searchsuppliername;

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; $paymentreceiveddatefrom = $ADate1; } else { $ADate1 = ""; }

//echo $ADate1;

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; $paymentreceiveddateto = $ADate2; } else { $ADate2 = ""; }

//echo $ADate2;

if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }

//echo $range;

if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }

//echo $amount;

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

//$frmflag2 = $_POST['frmflag2'];





?>

<style type="text/css">
.bodytext31:hover { font-size:14px; }

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



<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<script src="js/datetimepicker_css.js"></script>



<!--<script type="text/javascript" src="js/autocomplete_customer2.js"></script>

<script type="text/javascript" src="js/autosuggestcustomer.js"></script>-->

<script type="text/javascript">

window.onload = function () 

{

	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        

}


function funcSubTypeChange1(locationcode)

{
	<?php 

	$query12 = "select * from master_location";

	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

	while ($res12 = mysqli_fetch_array($exec12))

	{

	 $res12subtypeanum = $res12["auto_number"];

	$res12locationname = $res12["locationname"];

	$res12locationcode = $res12["locationcode"];

	?>

	if(locationcode=="<?php echo $res12locationcode; ?>")

	{

		

		document.getElementById("ward").options.length=null; 

		var combo = document.getElementById('ward'); 	

		<?php 

		$loopcount=0;

		?>

		combo.options[<?php echo $loopcount;?>] = new Option ("Select Ward", ""); 

		<?php

		$query10 = "select * from master_ward where locationname = '$res12locationname' and recordstatus = '' order by ward";

		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res10 = mysqli_fetch_array($exec10))

		{

		$loopcount = $loopcount+1;

		$res10accountnameanum = $res10["auto_number"];

		$ward = $res10["ward"];

		?>

			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $ward;?>", "<?php echo $res10accountnameanum;?>"); 

		<?php 

		}

		?>

	}
		
	

	<?php

	}

	?>	

}

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
						funcSubTypeChange1();
						}
					  }
					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);
					xmlhttp.send();
}
					
//ajax to get location which is selected ends here

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

            <form name="cbform1" method="post" action="dischargeregister.php">

		        <table width="634" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3" ><strong>Discharge Register</strong></td>

             </tr>

           	<tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" id="ajaxlocation">Location</td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

              <select name="locationcode" id="locationcode"  onChange=" funcSubTypeChange1(this.value); ajaxlocationfunction(this.value);">
               <option value="All">All</option> 

                <?php

                  $query20 = "select * FROM master_location";

                  $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20". mysqli_error($GLOBALS["___mysqli_ston"]));

                  while ($res20 = mysqli_fetch_array($exec20)){
					  
					  	$locationname = $res20["locationname"];

					   $locationcode = $res20["locationcode"];

						?>

						 <option value="<?php echo $locationcode; ?>" <?php if($locationcode1!='')if($locationcode1==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>

						<?php

						} 


                ?>

                </select></td>
                
                
                
                

           </tr>
           
           <tr>
           
           
                 <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Ward</td>
                <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <select name="ward" id="ward" >
                 <option value="">Select Ward</option>        
							 	  
					 <?php
					 if($locationcode1!='All')
					 {
						 $query78 = "select auto_number,ward from master_ward where locationcode='$locationcode1'";
					 }
					 else
					 {
						 $query78 = "select auto_number,ward from master_ward";
					 }
		
						   
						  $exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						  while($res78 = mysqli_fetch_array($exec78))
						  {
						  $wardanum = $res78['auto_number'];
						  $wardname = $res78['ward'];
						    ?>
                          <option value="<?php echo $wardanum; ?>"<?php if($wardanum == $ward12) { echo "selected"; }?>><?php echo $wardname; ?></option>
						  <?php
						  }
			
                          ?>
                      </select>
              </span></td>
              </tr>

            <!-- <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Ward </td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

              <select name="wardcode1">

                <option value = "0">ALL</option>

                <?php 

                  $query201="select auto_number,ward from master_ward";

                  $exc201=mysqli_query($GLOBALS["___mysqli_ston"], $query201) or die("Error in Query201".mysqli_error($GLOBALS["___mysqli_ston"]));

                  while($res201=mysqli_fetch_array($exc201))

                  { ?>

                    <option value="<?php echo $res201['auto_number'] ?>"><?php echo $res201['ward']; ?> </option>    

                  <?php 

                  }

                  ?>    

                </select></td>

           </tr> -->

		   

			  <tr>

                      <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF"> Date From </td>

                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>

                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>

                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">

                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>

                  </tr>	

                  <tr>

	              <td align="left" valign="top"  bgcolor="#FFFFFF"></td>

	              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

				            <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

	                  <input type="submit" value="Search" name="Submit" />

	                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>

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

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="2000" 

            align="left" border="0">

          <tbody>

  	     <tr>

          <td class="bodytext31" valign="center" align="left" colspan="2"> 

           <!-- <a target="_blank" href="print_dischargeregister.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&wardcode=<?php echo $wardcode; ?>"><img src="images/pdfdownload.jpg" width="30" height="30"></a> -->

           <a href="print_dischargeregisterxls.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&wardcode=<?php echo $ward12; ?>&&locationcode=<?php echo $locationcode1; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a>

          </td>

        </tr>



      <tr>

        <td bgcolor="#ecf0f5" colspan="21">&nbsp;</td>

      </tr>

      <tr>

        <td width="2%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>No.</strong></div></td>

        <td width="8%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Ward</strong></div></td>

        <td width="5%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patientcode</strong></div></td>

        <td width="5%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visitcode</strong></div></td>

        <td width="10%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name</strong></div></td>

        <td width="5%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>D.O.A.</strong></div></td>

        <td width="5%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>D.O.A. Time</strong></div></td>

        <td width="5%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>D.O.D</strong></td>

        <td width="5%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>D.O.D Time</strong></div></td>

        <td width="3%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>LOS</strong></td>

        <td width="10%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Scheme</strong></td>
        
        <td width="10%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Ward</strong></td>

        <td width="10%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Admitting Doctor</strong></div></td>

        <td width="10%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Consulting Doctor</strong></div></td>

        <td width="5%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Revenue</strong></div></td>

        <td width="5%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Deposit</strong></div></td>

        <td width="5%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Discount</strong></div></td> 

        <td width="5%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>NHIF</strong></div></td> 

        <td width="5%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Net Bill</strong></div></td>

        <td width="8%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Invoice NO.</strong></div></td>

        <td width="5%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Discharged By</strong></div></td> 

		 <td width="5%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Finalized By</strong></div></td>
      </tr>



        <?php



          $totalrevenue = $totaldiscount = $totaldeposit = $totalnhif = $totalnetbill = 0;
		  
		  				
		if($locationcode1=='All')
		{
		$pass_location = "locationcode !=''";
		}
		else
		{
		$pass_location = "locationcode ='$locationcode1'";
		}
		
		if($ward12!='')
		{
			   $query110 = "select a.patientname, a.patientcode, a.visitcode, b.ward from billing_ipcreditapproved as a JOIN ip_bedallocation as b ON a.visitcode = b.visitcode where (a.billdate between '$ADate1' and '$ADate2') and a.$pass_location and b.ward='$ward12'
		 UNION ALL 
		 select a.patientname, a.patientcode, a.visitcode, b.ward from billing_ip as a JOIN ip_bedallocation as b ON a.visitcode = b.visitcode where (a.billdate between '$ADate1' and '$ADate2') and a.$pass_location and b.ward='$ward12' order by ward";
		}
		else
		{
			   $query110 = "select a.patientname, a.patientcode, a.visitcode, b.ward from billing_ipcreditapproved as a JOIN ip_bedallocation as b ON a.visitcode = b.visitcode where (a.billdate between '$ADate1' and '$ADate2') and a.$pass_location 
		 UNION ALL 
		 select a.patientname, a.patientcode, a.visitcode, b.ward from billing_ip as a JOIN ip_bedallocation as b ON a.visitcode = b.visitcode where (a.billdate between '$ADate1' and '$ADate2') and a.$pass_location order by ward";
		}
	
          $exec110 = mysqli_query($GLOBALS["___mysqli_ston"], $query110) or die ("Error in Query110".mysqli_error($GLOBALS["___mysqli_ston"]));

          // $res110 = mysql_fetch_array($exec110);



          while ($res110 = mysqli_fetch_array($exec110)){

              $patientcode = $res110['patientcode'];

              $patientname = $res110['patientname'];

              $visitcode = $res110['visitcode'];



              $query10 = "select * from ip_bedallocation where patientcode = '$patientcode' and visitcode = '$visitcode'";

              $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die("Error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));

              $res10 = mysqli_fetch_array($exec10);

              $admissiondate = $res10['recorddate'];

              $admissiontime = $res10['recordtime'];



              $wardno = $res10['ward'];

              $queryward = "select * from master_ward where auto_number = '$wardno'";

              $execward = mysqli_query($GLOBALS["___mysqli_ston"], $queryward) or die("Error in QueryWard".mysqli_error($GLOBALS["___mysqli_ston"]));

              $resward = mysqli_fetch_array($execward);

              $wardname = $resward['ward'];





              $querydischarge = "select * from ip_discharge where patientcode = '$patientcode' and visitcode = '$visitcode'";

              $execdischarge = mysqli_query($GLOBALS["___mysqli_ston"], $querydischarge) or die("Error in querydischarge".mysqli_error($GLOBALS["___mysqli_ston"]));

              $resdischarge = mysqli_fetch_array($execdischarge);

              $dischargedate = $resdischarge['recorddate'];

              $dischargetime = $resdischarge['recordtime'];

              $accountname = $resdischarge['accountname'];

              $dischargedby = $resdischarge['username'];



              $start = strtotime($admissiondate);

              $end = strtotime($dischargedate);

              $los = floor(abs($end - $start) / 86400);



              $query12 = "select * from master_ipvisitentry where patientcode = '$patientcode' and visitcode = '$visitcode'";

              $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die("Error in query12".mysqli_error($GLOBALS["___mysqli_ston"]));

              $res12 = mysqli_fetch_array($exec12);

              $admissiondoc = $res12['opadmissiondoctor'];

              $consultingdoc = $res12['consultingdoctorName'];



              $query13 = "select * from billing_ip where patientcode = '$patientcode' and visitcode = '$visitcode'";

              $exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die("Error in query13".mysqli_error($GLOBALS["___mysqli_ston"]));

              $res13 = mysqli_fetch_array($exec13);

              $num13 = mysqli_num_rows($exec13);



              if($num13 == 1){

                $revenue = $res13['totalrevenue'];

                $deposit = $res13['deposit'];

                $discount = $res13['discount'];

                $nhif = $res13['nhif'];

                //$netbill = $res13['totalamount'];
                $netbill=$revenue-$discount-$nhif;
                $invoiceno = $res13['billno'];

				$finalizedby = $res13['username'];

              } else {

                $query14 = "select * from billing_ipcreditapproved where patientcode = '$patientcode' and visitcode = '$visitcode'";

                $exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die("Error in query14".mysqli_error($GLOBALS["___mysqli_ston"]));

                $res14 = mysqli_fetch_array($exec14);



                $revenue = $res14['totalrevenue'];

                $deposit = $res14['deposit'];

                $discount = $res14['discount'];

                $nhif = $res14['nhif'];

                //$netbill = $res14['totalamount'];
                $netbill=$revenue-$discount-$nhif;
                $invoiceno = $res14['billno'];

				$finalizedby = $res14['username'];
              }

              
			    $query15 = "select username from master_transactionpaylater where billnumber = '$invoiceno' and visitcode = '$visitcode' and transactiontype='finalize'";
                $exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die("Error in query15".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res15 = mysqli_fetch_array($exec15);
                if($finalizedby==''){
				$finalizedby = $res15['username'];
                }


			  
              

              $totalrevenue += $revenue;

              $totaldeposit += $deposit;

              $totaldiscount += $discount;

              $totalnhif += $nhif;

             



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
           $deposit1=$deposit;
		   $deposit1=abs($deposit);
		   if($revenue<=0)
		   {
			 $revenue=$deposit1;
		   }
		   $netbill=$revenue-$discount-$nhif;
		    $totalnetbill += $netbill;
          ?>

               <tr <?php echo $colorcode; ?>>

                  <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>

                  <td class="bodytext31" valign="center" align="left"><?php echo $wardname; ?></td>

                  <td class="bodytext31" valign="center" align="left"><?php echo $patientcode; ?></td>

                  <td class="bodytext31" valign="center" align="left"><?php echo $visitcode; ?></td>

                  <td class="bodytext31" valign="center" align="left"><?php echo $patientname; ?></td>

                  <td class="bodytext31" valign="center" align="left"><?php echo $admissiondate; ?></td>

                  <td class="bodytext31" valign="center" align="left"><?php echo $admissiontime; ?></td>

                  <td class="bodytext31" valign="center" align="left"><?php echo $dischargedate; ?></td>

                  <td class="bodytext31" valign="center" align="left"><?php echo $dischargetime; ?></td>

                  <td class="bodytext31" valign="center" align="left"><?php echo $los; ?></td>

                  <td class="bodytext31" valign="center" align="left"><?php echo $accountname; ?></td>
                  
                  <td class="bodytext31" valign="center" align="left"><?php echo $wardname; ?></td>

                  <td class="bodytext31" valign="center" align="left"><?php echo $admissiondoc; ?></td>

                  <td class="bodytext31" valign="center" align="left"><?php echo $consultingdoc; ?></td>

                  <td class="bodytext31" valign="center" align="right"><?php echo number_format($revenue,2); ?></td>

                  <td class="bodytext31" valign="center" align="right"><?php echo number_format($deposit,2); ?></td>

                  <td class="bodytext31" valign="center" align="right"><?php if($discount != 0){echo "-".number_format($discount,2);} else {echo number_format($discount,2);} ?></td>

                  <td class="bodytext31" valign="center" align="right"><?php echo number_format($nhif,2); ?></td>

                  <td class="bodytext31" valign="center" align="right"><?php echo number_format($netbill,2); ?></td>

                  <td class="bodytext31" valign="center" align="left"><?php echo $invoiceno; ?></td>

                  <td class="bodytext31" valign="center" align="left"><?php echo $dischargedby; ?></td>

				   <td class="bodytext31" valign="center" align="left"><?php echo $finalizedby; ?></td>

          </tr>



          <?php

          }

          ?>



            <tr bgcolor="#ecf0f5">

              <td class="bodytext31" valign="center" align="right" colspan="14"><strong>Total:</strong></td>

              <td class="bodytext31" valign="center" align="right"><strong><?php echo number_format($totalrevenue,2); ?></strong></td>

              <td class="bodytext31" valign="center" align="right"><strong><?php echo number_format($totaldeposit,2); ?></strong></td>

              <td class="bodytext31" valign="center" align="right"><strong><?php if($totaldiscount != 0){echo "-".number_format($totaldiscount,2);} else {echo number_format($totaldiscount,2);} ?></strong></td>

              <td class="bodytext31" valign="center" align="right"><strong><?php echo number_format($totalnhif,2); ?></strong></td>

              <td class="bodytext31" valign="center" align="right"><strong><?php echo number_format($totalnetbill,2); ?></strong></td>

              <td class="bodytext31" valign="center" align="right" colspan="3">&nbsp;</td>

            </tr>

          </tbody>

        </table></td>

      </tr>

	  

    </table>

</table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>

