<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");





$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

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

$tot1 = "00";

$tot2 = "00";

$tot3='00';

$awt_2='00';

$final_total='00';

//This include updatation takes too long to load for hunge items database.

include ("autocompletebuild_account2.php");

 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

//echo $searchsuppliername;

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

 $locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';

 $searchpatientcode=isset($_REQUEST['searchpatientcode'])?$_REQUEST['searchpatientcode']:'';

  $searchvisitcode=isset($_REQUEST['searchvisitcode'])?$_REQUEST['searchvisitcode']:'';

?>

<style type="text/css">
th {
            background-color: #ffffff;
            position: sticky;
            top: 0;
            z-index: 1;
        }


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



<script type="text/javascript" src="js/autocomplete_accounts2.js"></script>

<script type="text/javascript" src="js/autosuggest4accounts.js"></script>

<script type="text/javascript">



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







window.onload = function () 

{

	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        

}

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

.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

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

		

		

              <form name="cbform1" method="post" action="timereport.php">

		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="1" bgcolor="#ecf0f5" class="bodytext3"><strong>Time Report</strong></td>

              <td colspan="3" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>

             

            

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

            <!--<tr>

              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">

			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 

                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 

				</td>

              </tr>-->

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Account </td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

              <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">

              </span></td>

           </tr>

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Reg No</td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

              <input name="searchpatientcode" type="text" id="searchpatientcode" value="" size="25" autocomplete="off">

              </span></td>

           </tr>

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visit No</td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

              <input name="searchvisitcode" type="text" id="searchvisitcode" value="" size="25" autocomplete="off">

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

                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>

                    </tr>

					<tr>

  			 <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>

              			<td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

				 <select name="location" id="location">

                 <option value="All">All</option>

                    <?php

						

						$query1 = "select * from master_location where status='' order by locationname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						$loccode=array();

						while ($res1 = mysqli_fetch_array($exec1))

						{

						$locationname = $res1["locationname"];

						$locationcode = $res1["locationcode"];

						

						?>

						 <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>

						<?php

						} 

						?>

						

                      </select>

		      </span></td>

			   <td width="10%" align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>

			  </tr>

						

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>

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

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1300" 

            align="left" border="0">

          <tbody>

            <tr>

              <td width="3%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              <td colspan="16" bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311">

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

				//For excel file creation.

				

			


				?>

              <script language="javascript">

				function printbillreport1()

				{

					window.open("print_paymentgivenreport1.php?locationcode=<?php echo $locationcode1; ?>&&<?php echo $urlpath; ?>","Window1",'width=900,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

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

            <tr>

              <th class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></th>

              <th width="10%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient</strong></div></th>

				<th width="9%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account</strong></div></th>

              <th width="9%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Visit Date </strong></th>

              <th width="6%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Visit No </strong></th>

              <th width="5%" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>OP Visit </strong></div></th>

				<th width="5%" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Cons. Bill </strong></div></th>

				<th width="5%" align="right" valign="center"  

                bgcolor="#ffffff" class="style1">Triage</th>

                <th width="5%" align="right" valign="center"  

                bgcolor="#ffffff" class="style1">Consultation</th>

				<th width="10%" align="right" valign="center"  

                bgcolor="#ffffff" class="style1">Med Issue </th>

				<th width="5%" align="right" valign="center"  

                bgcolor="#ffffff" class="style1">Service</th>

				<th width="5%" align="right" valign="center"  

                bgcolor="#ffffff" class="style1">Radiology</th>

				<th width="8%" align="right" valign="center"  

                bgcolor="#ffffff" class="style1">Lab</th>

				<th width="8%" align="right" valign="right"  

                bgcolor="#ffffff" class="style1">Total Time </th>

                <th width="15%" align="right" valign="right"  

                bgcolor="#ffffff" class="style1"><div align="right"><strong>Bill Date</strong></th>

				<th width="15%" align="right" valign="right"  

                bgcolor="#ffffff" class="style1"><div align="right"><strong>Bill Time</strong></th>

				<th width="15%" align="right" valign="right"  

                bgcolor="#ffffff" class="style1"><div align="right"><strong>Bill TAT</strong></th>
                
              
				

            </tr>

			<?php

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

            //$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

            if ($cbfrmflag1 == 'cbfrmflag1')

            {

				if($locationcode1=='All'){

					

					$locationcodenew= "locationcode like '%%'";

				}else{

					$locationcodenew= "locationcode = '$locationcode1'";

				}

				$searchsuppliername=trim($searchsuppliername);

				$searchsuppliername=rtrim($searchsuppliername);

			 $query21 = "select * from master_visitentry where  $locationcodenew and accountfullname like '%$searchsuppliername%' and consultationdate between '$ADate1' and '$ADate2'   group by accountfullname order by accountfullname desc  ";

			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));

			 $num2 = mysqli_num_rows($exec21);

			while ($res21 = mysqli_fetch_array($exec21))

			{

			$res21accountfullname = $res21['accountfullname'];

			

			$query22 = "select * from master_accountname where $locationcodenew and accountname = '$res21accountfullname' and recordstatus <>'DELETED' ";

			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res22 = mysqli_fetch_array($exec22);

			$res22accountname = $res22['accountname'];



			if( $res21accountfullname != '')

			{

				if($res22accountname <> ''){

								?>

            

			<tr bgcolor="#ecf0f5">

            <td colspan="17"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo $res22accountname;?></strong></td>

            </tr>

			<?php }?>

			<?php

			

			$dotarray = explode("-", $paymentreceiveddateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			

		      

		  $query2 = "select * from master_visitentry where $locationcodenew and accountfullname like '%$res21accountfullname%' and consultationdate between '$ADate1' and '$ADate2' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' order by accountfullname desc";

		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $numrow=mysqli_num_rows($exec2);

		  

		  

		  while ($res2 = mysqli_fetch_array($exec2))

		  {

     	  $res2patientfullname = $res2['patientfullname'];

		  $res2consultationdate = $res2['consultationdate'];

		  $datearray = explode("-",$res2consultationdate);

		  $res2visitcode = $res2['visitcode'];

		  $res2consultationtime = $res2['consultationtime'];

		  $res2accountfullname = $res2['accountfullname'];

		  $res2patientcode = $res2['patientcode'];
		  
		  $picklocation = $res2['locationcode'];

		  if($res2consultationtime == '')

		  {

		  $res2consultationtime = "00:00:00";

		  }

		  else

		  {

		  $res2consultationtime = $res2['consultationtime'];

		  }

		  $res2consultationtime1 = strtotime($res2consultationtime);





		  $query221 = "select transactiondate,transactiontime from master_transactionpaylater where visitcode='$res2visitcode' and patientcode = '$res2patientcode'";

		  $exec221 = mysqli_query($GLOBALS["___mysqli_ston"], $query221) or die ("Error in Query221".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res221 = mysqli_fetch_array($exec221);

		  $billdate = $res221['transactiondate'];

		  $billtime = $res221['transactiontime'];



		  $query3 = "select * from master_billing where $locationcodenew and patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and billingdatetime between '$ADate1' and '$ADate2' ";

		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res3 = mysqli_fetch_array($exec3);

		  $res3billnumber = $res3['billnumber'];

		  $res3consultationtime = $res3['consultationtime'];

		  if($res3consultationtime == '')

		  {

		  $res3consultationtime = "00:00:00";

		  }

		  else

		  {

		  $res3consultationtime = $res3['consultationtime'];

		  }

		  $res3consultationtime1 = strtotime($res3consultationtime);

		  

		  $query4 = "select * from master_triage where $locationcodenew and patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and registrationdate between '$ADate1' and '$ADate2'";

		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in quey4".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res4 = mysqli_fetch_array($exec4);

		  $res4consultationtime = $res4['consultationtime'];

		  if($res4consultationtime == '')

		  {

		  $res4consultationtime = "00:00:00";

		  }

		  else

		  {

		  $res4consultationtime = $res4['consultationtime'];

		  }

		  $res4consultationtime1 = strtotime($res4consultationtime);

		  

		  $query5 = "select * from pharmacysales_details where $locationcodenew and patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and entrydate between '$ADate1' and '$ADate2'";

		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5". mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res5 = mysqli_fetch_array($exec5);

		  $res5entrytime = $res5['entrytime'];

		  if($res5entrytime == '')

		  {

		  $res5entrytime = "00:00:00";

		  }

		  else

		  {

		  $res5entrytime = $res5['entrytime'];

		  }

		  $res5entrytime1 = strtotime($res5entrytime);

		  

		  $query6 = "select * from process_service where $locationcodenew and patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and recorddate between '$ADate1' and '$ADate2'";

		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res6 = mysqli_fetch_array($exec6);

		  $res6recordtime = $res6['recordtime'];

		  if($res6recordtime == '')

		  {

		  $res6recordtime = "00:00:00";

		  }

		  else

		  {

		  $res6recordtime = $res6['recordtime'];

		  }

		  $res6recordtime1 = strtotime($res6recordtime);

		  

		  $query7 = "select * from resultentry_radiology where  patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and recorddate between '$ADate1' and '$ADate2'"; 

		  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res7 = mysqli_fetch_array($exec7);

		  $res7recordtime = $res7['recordtime'];

		  if($res7recordtime=='')

		  {

		  $res7recordtime = "00:00:00";

		  }

		  else

		  {

		  $res7recordtime = $res7['recordtime'];

		  }

		  $res7recordtime1 = strtotime($res7recordtime);

		  

		  $query8 = "select * from samplecollection_lab where $locationcodenew and patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and recorddate between '$ADate1' and '$ADate2'";

		  $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res8 = mysqli_fetch_array($exec8);

		  $res8recordtime = $res8['recordtime'];

		  //echo $splittedstring=explode(":",$res8recordtime,2);

          if ($res8recordtime == '')

		  {

		  $res8recordtime = "00:00:00";

		  }

		  else

		  {

		  $res8recordtime = $res8['recordtime'];

		  }

		  $res8recordtime1 = strtotime($res8recordtime);

		  

		  $query9 = "select * from master_consultation where $locationcodenew and patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and recorddate between '$ADate1' and '$ADate2'";

		  $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in query9".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res9 = mysqli_fetch_array($exec9);

		  $res9consultationtime = $res9['consultationtime'];

		  //echo $splittedstring=explode(":",$res8recordtime,2);

          if ($res9consultationtime == '')

		  {

		  $res9consultationtime = "00:00:00";

		  }

		  else

		  {

		  $res9consultationtime = $res9['consultationtime'];

		  }

		  $res9consultationtime1 = strtotime($res9consultationtime);
		  
		  

$visitTime = $res2consultationtime;
$triageTime = $res4consultationtime;
$consultationTime =$res9consultationtime;
$pharmacyTime=$res5entrytime;
$labTime=$res8recordtime;
$radiologyTime=$res7recordtime;
$serviceTime=$res6recordtime;


// Convert times to Unix timestamps for comparison
$times = array($triageTime, $consultationTime, $pharmacyTime, $labTime, $radiologyTime, $serviceTime);
$maxTime = strtotime('00:00'); // Initialize with a minimum time value

foreach ($times as $time) {
    if (!empty($time)) { // Exclude empty times
        $timestamp = strtotime($time);
        if ($timestamp > $maxTime) {
            $maxTime = $timestamp;
            $maxTimeString = $time;
        }
    }
}

		
		
$thehig=strtotime($maxTimeString);

// Calculate time differences in seconds
$totalTimeInSeconds = $thehig - $res2consultationtime1;

$final_total=$final_total+$totalTimeInSeconds;

// Convert total time difference back to H:i:s format
$totalTime = gmdate('H:i', $totalTimeInSeconds);
/*
if($res2visitcode=='OPV-1692-2')
{
echo "The highest time among the given list is: $maxTimeString";
echo "totaltime--->".$totalTime;
}*/

		   $highest_time = max($res9consultationtime, $res4consultationtime1, $res5entrytime1, $res6recordtime1, $res7recordtime1 , $res8recordtime1);

		   //$lowest_time = min($res2consultationtime1,$res3consultationtime1, $res4consultationtime1, $res5entrytime1, $res6recordtime1, $res7recordtime1 , $res8recordtime1);

		  

		  $highest_time1 = date("H:i:s", $highest_time); 

		  $lowest_time1 = date("H:i:s", $res2consultationtime1);

		 //echo $t = date("H:i",120);

		$tot =  strtotime($highest_time1) - strtotime($lowest_time1);

//		$totalt=date("H:i",$tot);

		 $exe = explode(":",$highest_time1);

		 $exe1 = explode(":",$lowest_time1);
		
		 $exe2 = abs($exe[0] - $exe1[0]);

		 $exe3 = abs($exe[1] - $exe1[1]);

		 $exe4 = $exe[2] - $exe1[2];

		 $length = strlen($exe2);

		 $length1 = strlen($exe3);
 

		 if($length == '1')

		 {

		  $exe2 = '0'. $exe2;

		 }

		 

		 if($length1 == '1')

		 {

		 $exe3 = '0'.$exe3;

		 }

		 

		 if($exe2 < 0)

		 {

		 $exe2 = '00';

		 }

		 

		 if($exe3 < 0)

		 {

		 $exe3 = '00';

		 }

		 

		  $tot1 = $tot1 + $exe2; 

	 	 $tot2 = $tot2 + $exe3;

		

		 

		 $length2 = strlen($tot1);

		 $length3 = strlen($tot2);

		 

		 if($length2 == '1')

		 {

		 $tot1 = '0'. $tot1;

		 }

		 

		 if($length3 == '1')

		 {

		 $tot2 = '0'. $tot2;

		 }

		 

		 $exe5 = $exe2 * 3600;

		 $exe6 = $exe3 * 60;

		 $exe7 = $exe5 + $exe6;

		 

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

			

	       $exe8 = $exe7 / $snocount;

		 

			?>

           <tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res2patientfullname; ?></div></td>

				 <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res2accountfullname; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $datearray[2]; ?>-<?php echo $datearray[1]; ?>-<?php echo $datearray[0]; ?></div></td>

                 <td class="bodytext31" valign="center"  align="left"><a href="timereport_track.php?patientcode=<?php echo $res2patientcode; ?>&&visitcode=<?php echo $res2visitcode; ?>&location=<?php echo $picklocation;?>" target='_blank'> <?php echo $res2visitcode; ?></a> </td>

              <td class="bodytext31" valign="center"  align="left">

			    <div align="right"><?php echo date("H:i",(strtotime($res2consultationtime))); ?></div></td>

               <td class="bodytext31" valign="center"  align="left">

			    <div align="right"><?php echo date("H:i",(strtotime($res3consultationtime))); ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo date("H:i",(strtotime($res4consultationtime))); ?></div></td>

                <td class="bodytext31" valign="center"  align="left">

			    <div align="right"><?php echo date("H:i",(strtotime($res9consultationtime))); ?></div></td>

              

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo date("H:i",(strtotime($res5entrytime))); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo date("H:i",(strtotime($res6recordtime))); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo date("H:i",(strtotime($res7recordtime))); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo date("H:i",(strtotime($res8recordtime))); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="center"><?php echo $totalTime; ?></div></td>

              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php if($billdate!='') echo date('d-m-Y',strtotime($billdate)); else echo ''; ?></div>

			  </td>

			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $billtime; ?></div>

			  </td>

			  <?php

			  if($billdate!='') {

				  $diff = intval((strtotime($billdate.' '.$billtime) - strtotime($res2consultationdate.' '.$res2consultationtime))/60);
				  $diff=abs($diff);

                  //$hoursstay = $diff / ( 60 * 60 );

				  $hoursstay = intval($diff/60);

                  $minutesstay = $diff%60;
				   $hoursstay=abs($hoursstay);
				   $minutesstay=abs($minutesstay);

				  $los=$hoursstay.':'.$minutesstay;

			  }

			  else

				  $los= '';

		          ?>

			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $los; ?></div>

			  </td>
              
            
       

           </tr>

			<?php

		   

			}

			}

			}

			

			 if($tot2 >60)

			 {

		 	 $hours=($tot2 / 60);

			   $hours1=($tot2 % 60);

			 $hr=explode('.',$hours);

			 $hr1=substr($hr[1], 0, 1);

			 $tot1=$tot1+$hr[0];

			 

			  $tot2=$hours1;

			  

			 }

			 $tot3=$tot1.':'.$tot2;

     $grand_tot = gmdate('H:i', $final_total);

			?>
            
           


            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="right"></div></td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="right"></div></td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="right"></div></td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="right"></div></td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="right"></div></td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="right"><strong>Total Time:</strong></div></td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong><?php echo $tot3; ?></strong></div></td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"></td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"></td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"></td>
            

            </tr>

			<?php

			 $snocount;

			if($snocount!=0){

				$awt1=$tot1/$snocount;

			 $awt = $tot2/$snocount;

			 }

			 else

			 {

				 $awt1=$tot1;

			 $awt=$tot2;

			 }

			 $awt_1=explode('.',$awt1);

			 $awt1=$awt_1[0];

			 $count=count($awt_1);

			 if($count>1)

			 {

				 $awt_2=$awt_1[1];

				 $awt_2=substr($awt_2, 0, 1);

			 }



			 $awt=round($awt)+$awt_2;;

			 

			?>

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

                bgcolor="#ecf0f5"><div align="right"></div></td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><div align="right"></div></td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><div align="right"></div></td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><div align="right"></div></td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><div align="right"></div></td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong>A W T:</strong></div></td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><div align="center"><strong><?php echo $awt1.':'.$awt; /*echo number_format($awt,1,'.',''); */ ?></strong></div></td>

                <td class="bodytext31" valign="center"  align="left" width="100" 

                bgcolor="#ecf0f5"><a target="_blank" href="timereportex.php?cbfrmflag1=cbfrmflag1&&searchsuppliername=<?= $searchsuppliername; ?>&&location=<?= $location; ?>&&ADate1=<?= $ADate1 ?>&&ADate2=<?= $ADate2 ?>&&range=<?= $range ?>&&amount=<?= $amount?>&&cbfrmflag2=<?= $cbfrmflag2?>&&frmflag2=<?= $frmflag2?>&&searchpatientcode=<?= $searchpatientcode ?>&&searchvisitcode=<?= $searchvisitcode ?>"> <img src="images/excel-xls-icon.png" width="30" height="30"></a></td>

            </tr>

			 

		<?php

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

