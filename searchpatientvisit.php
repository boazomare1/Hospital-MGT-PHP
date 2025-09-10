<?php

session_start();



include ("includes/loginverify.php");

include ("db/db_connect.php");

//echo $menu_id;
include ("includes/check_user_access.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d');

$transactiondateto = date('Y-m-d');

$docno = $_SESSION['docno'];



$location =isset( $_REQUEST['location'])?$_REQUEST['location']:'';

$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$searchsuppliername = "";

$cbsuppliername = "";



$patient = isset($_REQUEST['patient']) ? $_REQUEST['patient'] : '';

$patientcode = isset($_REQUEST['patientcode']) ? $_REQUEST['patientcode'] : '';

$visitcode = isset($_REQUEST['visitcode']) ? $_REQUEST['visitcode'] : '';



//This include updatation takes too long to load for hunge items database.





if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

//$getcanum = $_GET['canum'];

if ($getcanum != '')

{

	$query4 = "select * from master_supplier where auto_number = '$getcanum'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res4 = mysqli_fetch_array($exec4);

	$cbsuppliername = $res4['suppliername'];

	$suppliername = $res4['suppliername'];

}











if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

//$st = $_REQUEST['st'];

if ($st == '1')

{

	$errmsg = "Success. Payment Entry Update Completed.";

}

if ($st == '2')

{

	$errmsg = "Failed. Payment Entry Not Completed.";

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



function cbsuppliername1()

{

	document.cbform1.submit();

}







</script>

<script type="text/javascript">





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





function process1backkeypress1()

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

}



function disableEnterKey()

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

		return false;

	}

	else

	{

		return true;

	}



}



function paymententry1process2()

{

	if (document.getElementById("cbfrmflag1").value == "")

	{

		alert ("Search Bill Number Cannot Be Empty.");

		document.getElementById("cbfrmflag1").focus();

		document.getElementById("cbfrmflag1").value = "";

		return false;

	}

}



function Process23()

{

	/*if (document.getElementById("patient").value == "" && document.getElementById("patientcode").value == "" && document.getElementById("visitcode").value == "")

	{

		alert("Please search any one parameter");

		document.getElementById("patient").focus();

		return false;

	}*/

}



function funcPrintReceipt1()

{

	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

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

.pagination{ float:right; }

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

		

		

              <form name="cbform1" method="post" action="searchpatientvisit.php" onSubmit="return Process23()">

		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Edit Visit Details </strong></td>

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

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>

              <td><select name="location" id="location" onChange="ajaxlocationfunction(this.value);" style="border: 1px solid #001E6A;">

                  <?php

						

						$query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

						$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res = mysqli_fetch_array($exec))

						{

						$locationname = $res["locationname"];

						$locationcode = $res["locationcode"];

						?>

						<option value="<?php echo $locationcode; ?>" <?php if($location!=''){if($location == $locationcode){echo "selected";}}?>><?php echo $locationname; ?></option>

						<?php

						}

						?>

                  </select></td>

                  

             

              </tr>

          

          

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <input name="patient" type="text" id="patient" value="<?php echo $patient; ?>" size="50" autocomplete="off">

              </span></td>

              </tr>

			    <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Registration No</td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <input name="patientcode" type="text" id="patientcode" value="<?php echo $patientcode; ?>" size="50" autocomplete="off">

              </span></td>

              </tr>

			   <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visitcode</td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <input name="visitcode" type="text" id="visitcode" value="<?php echo $visitcode; ?>" size="50" autocomplete="off">

              </span></td>

              </tr>

			  <tr>

          <td width="76" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>

          <td width="123" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>

          <td width="51" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>

          <td width="129" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">

            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>

		  </span></td>

          </tr>

			   <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                  <input  type="submit" value="Search" name="Submit" />

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

        <td>&nbsp;</td>

      </tr>

      

      <tr>

        <td>&nbsp;</td>

      </tr>

      

      <tr>

        <td>&nbsp;</td>

      </tr>

	  <tr>

        <td>

	

		

<?php

	$colorloopcount=0;

	$sno=0;

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1' || isset($_REQUEST['page']))

{



	if(isset($_POST['patient'])){$_SESSION['servispatient'] = $_POST['patient']; } else { $_SESSION['servispatient'] = ''; }

	$searchpatient = $_SESSION['servispatient'];

	if(isset($_POST['patientcode'])){$_SESSION['servispatientcode'] = $_POST['patientcode'];} else { $_SESSION['servispatientcode'] = ''; }

	$searchpatientcode=$_SESSION['servispatientcode'];

	if(isset($_POST['visitcode'])){$_SESSION['servisvisitcode'] = $_POST['visitcode'];} else { $_SESSION['servisvisitcode'] = ''; }

	$searchvisitcode = $_SESSION['servisvisitcode'];

	if(isset($_POST['ADate1'])){$_SESSION['servisADate1'] = $_POST['ADate1'];} else { $_SESSION['servisADate1'] = ''; }

	$fromdate=$_SESSION['servisADate1'];

	if(isset($_POST['ADate2'])){$_SESSION['servisADate2'] = $_POST['ADate2'];} else { $_SESSION['servisADate2'] = ''; }

	$todate=$_SESSION['servisADate2'];

	if(isset($_POST['location'])){$_SESSION['servislocation'] = $_POST['location'];} else { $_SESSION['servislocation'] = ''; }

	$location=$_SESSION['servislocation'];



	//echo $searchpatient;

		//$transactiondatefrom = $_REQUEST['ADate1'];

	//$transactiondateto = $_REQUEST['ADate2'];





	

?>

<form name="form1" id="form1" method="post" action="stockadjustment.php">	

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1208" 

            align="left" border="0">

          <tbody>

           <tr>

				 <td colspan="15"  bgcolor="#ecf0f5" class="bodytext31">

				      <?php //error_reporting(0);

						

							

							// How many adjacent pages should be shown on each side?

							$adjacents = 3;

							

							/* 

							   First get total number of rows in data table. 

							   If you have a WHERE clause in your query, make sure you mirror it here.

							*/

							

						

							

							$reslocationanumm= $_REQUEST['location'];

							$total_pages = 0;

							$query111 = "select patientcode, visitcode, billtype from master_visitentry where patientfullname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and locationcode like '%$reslocationanumm%' and consultationdate between '$fromdate' and '$todate'order by auto_number desc";

							$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));

							$total_pages = mysqli_num_rows($exec111);

							$res111 = mysqli_fetch_array($exec111);

											

							/*$query = "SELECT * FROM $tbl_name";

							$total_pages = mysql_fetch_array(mysql_query($query));

							echo $numrow = mysql_num_rows($total_pages);*/

							

							/* Setup vars for query. */

							$targetpage = $_SERVER['PHP_SELF']; 	//your file name  (the name of this file)

							$limit = 50; 								//how many items to show per page

							if(isset($_REQUEST['page'])){ $page=$_REQUEST['page'];} else { $page="";}

							if($page) 

								$start = ($page - 1) * $limit; 			//first item to display on this page

							else

								$start = 0;								//if no page var is given, set start to 0

							

							/* Setup page vars for display. */

							if ($page == 0) $page = 1;					//if no page var is given, default to 1.

							$prev = $page - 1;							//previous page is page - 1

							$next = $page + 1;							//next page is page + 1

							$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.

							$lpm1 = $lastpage - 1;						//last page minus 1

							

							/* 

								Now we apply our rules and draw the pagination object. 

								We're actually saving the code to a variable in case we want to draw it more than once.

							*/

							$pagination = "";

							if($lastpage >= 1)

							{	

								$pagination .= "<div class=\"pagination\">";

								//previous button

								if ($page > 1) 

									$pagination.= "<a href=\"$targetpage?page=$prev&location=$reslocationanumm\" style='color:#3b3b3c;'>previous</a>";

								else

									$pagination.= "<span class=\"disabled\" style='color:#3b3b3c;'>previous</span>";	

								

								//pages	

								if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up

								{	

									for ($counter = 1; $counter <= $lastpage; $counter++)

									{

										if ($counter == $page)

											$pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";

										else

											$pagination.= "<a href=\"$targetpage?page=$counter&location=$reslocationanumm\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					

									}

								}

								elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some

								{

									//close to beginning; only hide later pages

									if($page < 1 + ($adjacents * 2))		

									{

										for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)

										{

											if ($counter == $page)

												$pagination.= "<span class=\"current\" style='margin:0 0 0 2px;' color:#3b3b3c;>$counter</span>";

											else

												$pagination.= "<a href=\"$targetpage?page=$counter&location=$reslocationanumm\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					

										}

										$pagination.= "...";

										$pagination.= "<a href=\"$targetpage?page=$lpm1&location=$reslocationanumm\"style='margin:0 0 0 2px; color:#3b3b3c;'>$lpm1</a>";

										$pagination.= "<a href=\"$targetpage?page=$lastpage&location=$reslocationanumm\"style='margin:0 0 0 2px; color:#3b3b3c;'>$lastpage</a>";		

									}

									//in middle; hide some front and some back

									elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))

									{

										$pagination.= "<a href=\"$targetpage?page=1&location=$reslocationanumm\" style='margin:0 0 0 2px; color:#3b3b3c;'>1</a>";

										$pagination.= "<a href=\"$targetpage?page=2&location=$reslocationanumm\" style='margin:0 0 0 2px; color:#3b3b3c;'>2</a>";

										$pagination.= "...";

										for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)

										{

											if ($counter == $page)

												$pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";

											else

												$pagination.= "<a href=\"$targetpage?page=$counter&location=$reslocationanumm\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					

										}

										$pagination.= "...";

										$pagination.= "<a href=\"$targetpage?page=$lpm1&location=$reslocationanumm\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lpm1</a>";

										$pagination.= "<a href=\"$targetpage?page=$lastpage&location=$reslocationanumm\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lastpage</a>";		

									}

									//close to end; only hide early pages

									else

									{

										$pagination.= "<a href=\"$targetpage?page=1&location=$reslocationanumm\" style='margin:0 0 0 2px; color:#3b3b3c;'>1</a>";

										$pagination.= "<a href=\"$targetpage?page=2&location=$reslocationanumm\" style='margin:0 0 0 2px; color:#3b3b3c;'>2</a>";

										$pagination.= "...";

										for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)

										{

											if ($counter == $page)

												$pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";

											else

												$pagination.= "<a href=\"$targetpage?page=$counter&location=$reslocationanumm\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					

										}

									}

								}

								

								//next button

								if ($page < $counter - 1) 

									$pagination.= "<a href=\"$targetpage?page=$next&location=$reslocationanumm\" style='margin:0 0 0 2px; color:#3b3b3c;'>next</a>";

								else

									$pagination.= "<span class=\"disabled\" style='margin:0 0 0 2px; color:#3b3b3c;'>next</span>";

								//echo $pagination.= "</div>\n";		

							}

						 $reslocationanumm= $_REQUEST['location'];

						?>

				 </td>

			 </tr>

           <tr>

                <td width="29"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>

                <td width="45" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Print</strong></div></td>

                <td width="36" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Edit</strong></div></td>

                <td width="66" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Reg Code</strong></td>

				  <td width="69" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Visit Code</strong></td>

					  <td width="64" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>OP Date</strong></td>

			

			        <td width="145"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name </strong></div></td>

               <td width="51" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Type</strong></div></td>

                <td width="123" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sub Type </strong></div></td>

                <td width="62"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>Bill Type </strong></td>

                <td width="157"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account Name</strong></div></td>

                 <td width="65" align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>Age</strong></td>

                <td width="55"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Gender</strong></div></td>

                      <td width="52"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>

                  <!--OpeningBalance-->

                  ID </strong> </div></td>

				   <td width="69"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>User</strong></div></td>



                 </tr>

			  <?php 

			 

			  $reslocationanumm= $_REQUEST['location'];

              $query2 = "select * from master_visitentry where patientfullname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and locationcode like '%$reslocationanumm%' and consultationdate between '$fromdate' and '$todate' order by auto_number desc"; //LIMIT $start , $limit";

			  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			  $num2 = mysqli_num_rows($exec2);

			  //echo $num2;

			  while ($res2 = mysqli_fetch_array($exec2))

			  {

			  $res2customercode = $res2['patientcode'];
			  $scheme_id = $res2['scheme_id'];

			  $res2visitcode = $res2['visitcode'];

			  $res2customeranum = $res2['auto_number'];

			  $res2customername = $res2['patientfullname'];

			  $res2customercode = $res2['patientcode'];

			  $consultationdate = $res2['consultationdate'];

			  $user = $res2['username'];

			  $billtype = $res2['billtype'];

			  

			  if($billtype == "PAY LATER")

			  {
/*
			  $query891 = "select billno from billing_paynow where visitcode='$res2visitcode' and patientcode = '$res2customercode'";	

			  $exec891 = mysqli_query($GLOBALS["___mysqli_ston"], $query891) or die ("Error in Query891".mysqli_error($GLOBALS["___mysqli_ston"]));

			  $row8910 = mysqli_num_rows($exec891); */
                $row8910=0;
			  

			  $query892 = "select billno from billing_paylater where visitcode='$res2visitcode' and patientcode = '$res2customercode'";	

			  $exec892 = mysqli_query($GLOBALS["___mysqli_ston"], $query892) or die ("Error in Query892".mysqli_error($GLOBALS["___mysqli_ston"]));

			  $row892 = mysqli_num_rows($exec892);

			  

			  $row891 = $row8910 + $row892;

			  }

			  else

			  {

			  $row891 = 0;

			  }

			  if($row891 == '0')

			  {

			  

			 // $query985 = "select visitcode from master_triage where visitcode='$res2visitcode' and patientcode = '$res2customercode'";	

			 // $exec985 = mysql_query($query985) or die ("Error in Query985".mysql_error());

			 // $row985 = mysql_num_rows($exec985);

			  //if($row985 == '0')

			  if(1)
			  {

			  

			  $query34 = "select * from master_customer where customercode='$res2customercode'";

			  $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			  $res34 = mysqli_fetch_array($exec34);

			  $res2gender = $res34['gender'];

			  $dob = $res34['dateofbirth'];

			  $res2nationalidnumber = $res34['nationalidnumber'];

			  $paymenttypeanum = $res2['paymenttype'];

			

				$today = new DateTime();

				$diff = $today->diff(new DateTime($dob));

				

				if ($diff->y)

				{

				$res2age= $diff->y . ' Years';

				}

				elseif ($diff->m)

				{

				$res2age =$diff->m . ' Months';

				}

				else

				{

				$res2age =$diff->d . ' Days';

				}

				

			  $query3 = "select * from master_paymenttype where auto_number = '$paymenttypeanum'";

			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

			  $res3 = mysqli_fetch_array($exec3);

			  $res3paymenttype = $res3['paymenttype'];

			  

			  $subtypeanum = $res2['subtype'];

			  

			  $query4 = "select * from master_subtype where auto_number = '$subtypeanum'";

			  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

			  $res4 = mysqli_fetch_array($exec4);

			  $res4subtype = $res4['subtype'];

			  $res2billtype = $res2['billtype'];

			  $accountnameanum = $res2['accountname'];

	          $query5 = "select * from master_accountname where auto_number = '$accountnameanum'";

			  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

			  $res5 = mysqli_fetch_array($exec5);

			  //$res5accountname = $res5['accountname'];
			  
			  $query_sc = "select * from master_planname where scheme_id = '$scheme_id'";

	$exec_sc = mysqli_query($GLOBALS["___mysqli_ston"], $query_sc) or die ("Error in query_sc".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res_sc = mysqli_fetch_array($exec_sc);

	//$plannameanum = $res4['auto_number'];

	$res5accountname = $res_sc['scheme_name'];

			  $res2accountexpirydate = $res2['accountexpirydate'];

			  $plannameanum = $res2['planname'];

			  $query6 = "select * from master_planname where auto_number = '$plannameanum'";

			  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

			  $res6 = mysqli_fetch_array($exec6);

			  $res6planname = $res6['planname'];

			  

			    $res2consultingdoctor = $res2['consultingdoctor'];

			  $query201 = "select * from master_doctor where doctorcode = '$res2consultingdoctor'";

			  $exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201) or die ("Error in Query201".mysqli_error($GLOBALS["___mysqli_ston"]));

			  $res201 = mysqli_fetch_array($exec201);

			  $res2consultingdoctor = $res201['doctorname'];

			  

			  //$query3 = "select * from master_patientadmission where patientcode = '$res2customercode' order by auto_number desc limit 0, 1";

			  //$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());

			  //$res3 = mysql_fetch_array($exec3);

			  //$res3ipnumber = $res3['ipnumber'];

			  $res3ipnumber = '';

			  

			  $colorloopcount = $colorloopcount + 1;

			  $showcolor = ($colorloopcount & 1); 

			  $colorcode = '';

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

                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>

                <td  align="left" valign="center" class="bodytext31">

				<div align="center"><strong><a target="_blank" href="print_opvisit_label.php?patientcode=<?php echo $res2customercode; ?>"><img src="images/print.png" width="16" height="16" border="0" /></a></strong></div></td>

                <td class="bodytext31" valign="center"  align="left">

				<div align="center">

				<!--<a href="editpatient1.php?customercode=<?php echo $res2customercode; ?>" class="bodytext3">-->

				<a href="editpatientvisit.php?patientcode=<?php echo $res2customercode; ?>&&visitcode=<?php echo $res2visitcode; ?>&&menuid=<?php echo $menu_id; ?>" class="bodytext3">

				<span class="bodytext3"><img src="images/edit.png" width="16" height="16" border="0" /></span>				</a>				</div>				</td>

                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="left"><span class="bodytext32"><?php echo $res2customercode; ?></span></div>

                </div></td>

				  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="left"><span class="bodytext32"><?php echo $res2visitcode; ?></span></div>

                </div></td>

					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="left"><span class="bodytext32"><?php echo $consultationdate; ?></span></div>

                </div></td>

           

                   <td class="bodytext31" valign="center"  align="left">

				  <div align="left"><?php echo $res2customername; ?></div></td>

           

                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>

                </div></td>

                <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31">

                  <div align="left">

				  <span class="bodytext3">

				  <?php echo $res4subtype; //.' ('.$res2customercode.')'; ?>				  </span>				  </div>

                </div>				</td>

                <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $res2billtype; ?></div></td>

                <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $res5accountname; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left">

				  <div align="left"><?php echo $res2age; ?></div></td>

                <td  align="left" valign="center" class="bodytext31">

				 <div align="center">

				<?php if(($res2gender == 'MALE')||($res2gender == 'Male')) 

				 {

				?>

				<img src="images/male.png" width="16" height="16" border="0" />

				<?php

				 }

				 else

				 {

				?>

				<img src="images/female.png" width="16" height="16" border="0" />

				 <?php

				 }

				 ?>



				</div>

				</td>

                    <td class="bodytext31" valign="center"  align="left"><?php echo $res2nationalidnumber; ?></td>

					 <td class="bodytext31" valign="center"  align="left"><?php echo $user; ?></td>

                  </tr>

			  <?php

			  }

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

           	</tr>

			

          </tbody>

        </table>

<?php

}





?>	

		



		

		

		 </form>

		

		</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

	  

	 

    </table>

  </table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>



