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



$searchcustomername = '';

$patientfirstname = '';

$visitcode = '';

$customername = '';

$cbcustomername = '';

$cbbillnumber = '';

$cbbillstatus = '';

$customername = '';

$paymenttype = '';

$billstatus = '';

$res2loopcount = '';

$custid = '';

$visitcode1='';

$custname = '';

$colorloopcount = '';

$sno = '';

$customercode = '';

$totalsalesamount = '0.00';

$totalsalesreturnamount = '0.00';

$netcollectionamount = '0.00';

$netpaymentamount = '0.00';

$res2total = '0.00';

$total1 = '0.00';

$total2 = '0.00';

$total3 = '0.00';

$total4 = '0.00';

$total5 = '0.00';



$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$department_search=isset($_REQUEST['department_search'])?$_REQUEST['department_search']:'';

if (isset($_REQUEST["department"])) { $department = $_REQUEST["department"]; } else { $department = ""; }

 $locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

//$getcanum = $_GET['canum'];



if ($getcanum != '')

{

	$query4 = "select * from master_customer where auto_number = '$getcanum'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res4 = mysqli_fetch_array($exec4);

	$cbcustomername = $res4['customername'];

	$customername = $res4['customername'];

}



if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{



	$cbcustomername = $_REQUEST['cbcustomername'];

	$patientfirstname = $cbcustomername;

	$cbvisitcode = $_REQUEST['cbvisitcode'];

	$visitcode = $cbvisitcode;

	$visitcode1 = 10;

	

	if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }

	//$cbbillnumber = $_REQUEST['cbbillnumber'];

	if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }

	//$cbbillstatus = $_REQUEST['cbbillstatus'];

	

	$transactiondatefrom = $_REQUEST['ADate1'];

	$transactiondateto = $_REQUEST['ADate2'];

	

	if (isset($_REQUEST["paymenttype"])) { $paymenttype = $_REQUEST["paymenttype"]; } else { $paymenttype = ""; }

	//$paymenttype = $_REQUEST['paymenttype'];

	if (isset($_REQUEST["billstatus"])) { $billstatus = $_REQUEST["billstatus"]; } else { $billstatus = ""; }

	//$billstatus = $_REQUEST['billstatus'];



}

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





function cbcustomername1()

{

	document.cbform1.submit();

}



</script>



<script type="text/javascript" src="js/autosuggest3.js"></script>

<script type="text/javascript">

window.onload = function () 

{

	var oTextbox = new AutoSuggestControl(document.getElementById("searchcustomername"), new StateSuggestions());        

}





function disableEnterKey(varPassed)

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

	

	var key;

	if(window.event)

	{

		key = window.event.keyCode;     //IE

	}

	else

	{

		key = e.which;     //firefox

	}



	if(key == 13) // if enter key press

	{

		//alert ("Enter Key Press2");

		return false;

	}

	else

	{

		return true;

	}

}


</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

-->

</style>

</head>



<script src="js/datetimepicker_css.js"></script>



<body>

<table width="1901" border="0" cellspacing="0" cellpadding="2">

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

    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="1134">

		

		

              <form name="cbform1" method="post" action="patientwisevisitwise.php">

		<table width="790" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Patient Visit Wise Report </strong></td>

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

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Patient </td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

                <input name="cbcustomername" type="text" id="cbcustomername" value="" size="50" autocomplete="off">

             

               </td>

              </tr>

            <tr>

              <td width="23%"  align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visit Code </td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

			  <input value="" name="cbvisitcode" type="text" id="cbvisitcode"  onKeyDown="return disableEnterKey()" size="50" ></td>

              </tr>

           <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF"> Date From </td>

              <td align="left"  valign="center"  bgcolor="#FFFFFF" class="bodytext31">

			  <input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>				</td>

              <td width="11%" align="left"  valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>

              <td width="46%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">

                <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>

			  </span></td>

            </tr>

			

			<tr>

  			  <td width="23%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext31">Location</td>

              <td width="20%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext31">

			 

				 <select name="location" id="location" onChange="ajaxlocationfunction(this.value);">
                    <option value="All">All</option>

                    <?php
						$query1 = "select locationname,locationcode from master_location  order by auto_number desc";

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

			 

					  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Department</strong></td>

					  <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                       <select name="department_search" id="department_search">
                    <option value="">Select Department</option>

                    <?php
					
						$query1 = "select auto_number,department from master_department";
					
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						$loccode=array();

						while ($res1 = mysqli_fetch_array($exec1))

						{

						$auto_number = $res1["auto_number"];

						$department = $res1["department"];

						

						?>

					 <option value="<?php echo $auto_number; ?>" <?php if($department_search!='')if($department_search==$auto_number){echo "selected";}?>><?php echo $department; ?></option>

						<?php

						} 

						?>

                      </select>

	
					  </span></td>

             		 </tr>

			 

						

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

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

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1400" 

            align="left" border="0">

          <tbody>

            <tr>

              <td width="2%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              <td colspan="12" bgcolor="#ecf0f5" class="bodytext31">

                <?php

				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if ($cbfrmflag1 == 'cbfrmflag1')

				{

					$cbcustomername = $_REQUEST['cbcustomername'];

					$patientfirstname =  $cbcustomername;

					

					$customername = $_REQUEST['cbcustomername'];

					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }

					//$cbbillnumber = $_REQUEST['cbbillnumber'];

					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }

					//$cbbillstatus = $_REQUEST['cbbillstatus'];

					

					$transactiondatefrom = $_REQUEST['ADate1'];

					$transactiondateto = $_REQUEST['ADate2'];

					

					$urlpath = "cbcustomername=$cbcustomername&&cbbillnumber=$cbbillnumber&&locationcode1=$locationcode1&&ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum&&department=$department_search";//&&companyname=$companyname";

				}

				else

				{

					$urlpath = "cbcustomername=$cbcustomername&&cbbillnumber=$cbbillnumber&&locationcode1=$locationcode1&&ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum&&department=$department_search";//&&companyname=$companyname";

				}

				?>

 				<?php

				//For excel file creation.

				



				?>

                <script language="javascript">

				function printbillreport1()

				{

					window.open("print_viewconsultation.php?locationcode=<?php echo $locationcode1; ?>&&<?php echo $urlpath; ?>","Window1",'width=1000,height=600,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

					//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');

				}

				function printbillreport2()

				{

					window.location = "dbexcelfiles/ViewConsultationBills.xls"

				}

				</script>

                <input type="hidden" onClick="javascript:printbillreport1()" name="resetbutton2" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />

&nbsp;				<input type="hidden" value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" id="resetbutton22"  style="border: 1px solid #001E6A" />

</td>

              

              </tr>

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>S.No</strong></td>
                
                <td width="15%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Location </strong></td>

				<td width="15%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Patient </strong></td>

              <td width="6%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Reg No. </strong></td>

              <td width="7%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Visit Code  </strong></td>

				<td width="7%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Visit Date  </strong></td>

              <td width="15%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong> Account </strong></td>
                
                <td width="15%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong> Department </strong></td>

				<td width="7%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong> Pharmacy </strong></div></td>

              <td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Radiology </strong></div></td>

              <td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Lab</strong></div></td>

				<td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Service</strong></div></td>

				<td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Total</strong></div></td>

				

              </tr>

			<?php

			$dotarray = explode("-", $transactiondateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				

				if ($cbfrmflag1 == 'cbfrmflag1')

				{
					
					
			if($locationcode1=='All')
			{
			$pass_location = "locationcode !=''";
			}
			else
			{
			$pass_location = "locationcode ='$locationcode1'";
			}
			
			if($department_search!='')
			{
				 $query2 = "select * from master_visitentry where $pass_location and patientfullname like '%$patientfirstname%' and visitcode like '%$visitcode%' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and department='$department_search' order by patientcode";
			}
			else
			{

			 $query2 = "select * from master_visitentry where $pass_location and patientfullname like '%$patientfirstname%' and visitcode like '%$visitcode%' and consultationdate between '$transactiondatefrom' and '$transactiondateto' order by patientcode";
			}
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			while ($res2 = mysqli_fetch_array($exec2))

			{

			$res2patientcode = $res2['patientcode'];

			$res2visitcode = $res2['visitcode'];

			$res2patientfirstname = $res2['patientfirstname'];

			$res2patientmiddlename = $res2['patientmiddlename'];

			$res2patientlastname = $res2['patientlastname'];

			$res2accountname = $res2['accountname'];

			$res2billtype = $res2['billtype'];

			$res2consultationdate = $res2['consultationdate'];
			
			$res2locationcode = $res2['locationcode'];
			
			$res2departmentname = $res2['departmentname'];
			
			
			
			

		    $res2patientname = $res2patientfirstname.' '.$res2patientmiddlename.' '.$res2patientlastname;

			

			 $query4 = "select * from master_accountname where auto_number = '$res2accountname'";

		    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res4 = mysqli_fetch_array($exec4);

		    $res4accountname = $res4['accountname'];
			
		$query48 = "select locationname from master_location where locationcode = '$res2locationcode'";

		$exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die ("Error in Query48".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res48 = mysqli_fetch_array($exec48);

		$res4locationname= $res48['locationname'];

			

			if($res2billtype == 'PAY LATER')

			{

			$query5 = "select sum(amount) as pharmacyitemrate1 from billing_paylaterpharmacy where $pass_location and patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode'";

			}

			else 

			{

			$query5 = "select sum(amount) as pharmacyitemrate1 from billing_paynowpharmacy where $pass_location and patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode'";

			}

		    $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res5 = mysqli_fetch_array($exec5);

		    //$res5pharmacyitemrate = $res5['amount'];

			$res5pharmacyitemrate1 = $res5['pharmacyitemrate1'];

			

			if($res2billtype == 'PAY LATER')

			{

			$query6 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paylaterradiology where $pass_location and patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode'";

			}

			else 

			{

			$query6 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paynowradiology where $pass_location and patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode'";

			}

		    $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res6 = mysqli_fetch_array($exec6);

		    //$res6radiologyitemrate = $res6['radiologyitemrate'];

			$res6radiologyitemrate1 = $res6['radiologyitemrate1'];

			

			if($res2billtype == 'PAY LATER')

			{

			$query7 = "select sum(labitemrate) as labitemrate1 from billing_paylaterlab where $pass_location and patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode'";

			}

			else 

			{

			$query7 = "select sum(labitemrate) as labitemrate1 from billing_paynowlab where $pass_location and patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode'";

			}

		    $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res7 = mysqli_fetch_array($exec7);

		    //$res7labitemrate = $res7['labitemrate'];

			$res7labitemrate1 = $res7['labitemrate1'];

			

			if($res2billtype == 'PAY LATER')

			{

			$query8 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paylaterservices where $pass_location and patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode'";

			}

			else 

			{

			$query8 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paynowservices where $pass_location and patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode'";

			}

		    $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res8 = mysqli_fetch_array($exec8);

		    //$res8servicesitemrate = $res8['servicesitemrate'];

			$res8servicesitemrate1 = $res8['servicesitemrate1'];

			

			$total = $res5pharmacyitemrate1 + $res6radiologyitemrate1 + $res7labitemrate1 + $res8servicesitemrate1;

			$total1 = $total1 + $res5pharmacyitemrate1;

			$total2 = $total2 + $res6radiologyitemrate1;

			$total3 = $total3 + $res7labitemrate1;

			$total4 = $total4 + $res8servicesitemrate1;

			$total5 = $total5 + $total;

			

			$colorloopcount = $colorloopcount + 1;

			$showcolor = ($colorloopcount & 1); 

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

              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
              
              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res4locationname; ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res2patientname; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res2patientcode; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31"><?php echo $res2consultationdate; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res4accountname; ?></div></td>
                
                 <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res2departmentname; ?></div></td>
        

				<td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($res5pharmacyitemrate1,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($res6radiologyitemrate1,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($res7labitemrate1,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($res8servicesitemrate1,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($total,2,'.',','); ?></div></td>

				

              </tr>

			<?php

			}

			}

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

                bgcolor="#ecf0f5"><strong>Total:</strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($total1,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($total2,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($total3,2,'.',','); ?></strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($total4,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($total5,2,'.',','); ?></strong></td>

              </tr>

             <tr>

			 <td class="bodytext31" valign="center"  align="left" 

                bgcolor=""><a href="print_patientwisevisitwise.php?<?php echo $urlpath; ?>"><img  width="40" height="40" src="images/excel-xls-icon.png" style="cursor:pointer;"></a></td>

              </tr>

          </tbody>

        </table></td>

      </tr>

    </table>

  </table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>



