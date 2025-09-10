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

$currentdate = date("Y-m-d");

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CAFT Sales Credit Report</title>
<!-- Modern CSS -->
<link href="css/caftsalescreditreport-modern.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
<link href="css/three.css" rel="stylesheet" type="text/css">
<!-- Modern JavaScript -->
<script type="text/javascript" src="js/caftsalescreditreport-modern.js?v=<?php echo time(); ?>"></script>
</head>

<body>

<header>
  <?php include ("includes/alertmessages1.php"); ?>
  <?php include ("includes/title1.php"); ?>
  <?php include ("includes/menu1.php"); ?>
</header>

<main class="main-container">
<?php

$res2username ='';

$custname = '';

$colorloopcount = '';

$sno = '';

$customercode = '';

$totalsalesamount = '0.00';

$totalsalesreturnamount = '0.00';

$netcollectionamount = '0.00';

$netpaymentamount = '0.00';

$res2total = '0.00';

$cashamount = '0.00';

$cardamount = '0.00';

$chequeamount = '0.00';

$onlineamount = '0.00';

$total = '0.00';

$cashtotal = '0.00';

$cardtotal = '0.00';

$chequetotal = '0.00';

$onlinetotal = '0.00';

$res2cashamount1 ='';

$res2cardamount1 = '';

$res2chequeamount1 = '';

$res2onlineamount1 ='';

$cashamount2 = '0.00';

$cardamount2 = '0.00';

$chequeamount2 = '0.00';

$onlineamount2 = '0.00';

$creditamount2 = '0.00';

$total1 = '0.00';



include ("autocompletebuild_users.php");

 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');



if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

 $locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';

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
<!-- Modern CSS -->
<link href="caftsalescreditreport.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<!-- Modern JavaScript -->
<script type="text/javascript" src="caftsalescreditreport.js"></script>

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



<script type="text/javascript" src="js/autocomplete_users.js"></script>

<script type="text/javascript" src="js/autosuggestusers.js"></script>

<script type="text/javascript">

window.onload = function () 

{

//alert ('hai');

	var oTextbox = new AutoSuggestControl(document.getElementById("cbcustomername"), new StateSuggestions());        

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

    <td colspan="9" ><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" ><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" ><?php include ("includes/menu1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="1134">

		

		

              <form name="cbform1" method="post" action="caftsalescreditreport.php">

		<table width="660" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="2"  class="bodytext3"><strong>Caft credit Sales By User </strong></td>

              <!--<td colspan="2"  class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->

              <td colspan="2" align="right"  class="bodytext3" id="ajaxlocation"><strong> Location </strong>

             

            

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

              <td width="150" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search User </td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

                <input name="cbcustomername" type="text" id="cbcustomername" value="" size="50" autocomplete="off">

               </td>

              </tr>

           

           <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF"> Date From </td>

              <td width="173" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">

			  <input name="ADate1" id="ADate1"  value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>				</td>

              <td width="132" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>

              <td width="173" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">

                <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>

			  </span></td>

            </tr>

<!--			<tr>

           

			  <td width="150" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>

              <td width="173" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

			 

				 <select name="location" id="location" onChange="ajaxlocationfunction(this.value);">

                    <?php

						

						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

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

			   <td align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>

			  </tr>

-->			

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

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

        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="776" 

            align="left" border="0">

          <tbody>

            <tr>

              <td width="4%"  class="bodytext31">&nbsp;</td>

              <td colspan="6"  class="bodytext31">

                <?php

							  if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if ($cbfrmflag1 == 'cbfrmflag1')

				{



					

?></td>

				

              </tr>

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

><strong>No.</strong></td>

              <td width="23%" align="left" valign="center"  

 class="bodytext31"><strong>Name </strong></td>

              <td width="17%" align="right" valign="center"  

 class="bodytext31"><strong> Date </strong></td>

              <td width="15%"  align="right" valign="center" 

 class="bodytext31"><strong> Bill No </strong></td>

				<td   align="right" valign="center" 

 class="bodytext31"><strong> Remarks </strong></td>

                <td width="12%"  align="right" valign="center" 

 class="bodytext31"><div align="right"><strong>Total </strong></div></td>

                <td width="12%"  align="right" valign="center" 

 class="bodytext31"><div align="right"><strong>Action </strong></div></td>

            </tr>

			  <?php

			 

										$cbcustomername = $_REQUEST['cbcustomername'];

										$ADate1 = $_REQUEST['ADate1'];

										$ADate2 = $_REQUEST['ADate2'];

			$cbcustomername=trim($cbcustomername);

		

			 //$res21employeename = $res21['employeename'];

			 $res21username = $cbcustomername;

			 

/*			$query2 = "select username from master_employee where username like '%$res21username%' group by employeecode"; 

		  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());

		  $sno='';

		  while ($res2 = mysql_fetch_array($exec2))

		  {

     	 echo $res2username = $res2['username'];



			 

			

			 if( $res2username != '')

			{

			?>

			

            <tr bgcolor="#9999FF">

              <td colspan="7"  align="left" valign="center"  class="bodytext31"><strong><?php echo strtoupper ($res2username);?></strong></td>

              </tr>

			  

			<?php

*/			

			$query21 = "select *,sum(totalamount) as totalamount from caftcreditorder where staffname like '%$res21username%' and orderdate between '$ADate1' and '$ADate2' and status='' group by staffcode"; 

		  $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while ($res21 = mysqli_fetch_array($exec21))

		  {

     	  $staffname = $res21['staffname'];

		  $staffcode = $res21['staffcode'];

		  $totalamount = $res21['totalamount'];

		  $remarks = $res21['credittext'];

		  $updatedatetime = $res21['orderdate'];

		  $billnumber = $res21['ordernumber'];

		  

			 

			

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

				$colorcode = '';

			}



			?>

            <tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>

              <td class="bodytext31" valign="center"  align="left">

               <?php echo $staffname; ?></td>

              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $updatedatetime; ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

               <?php echo $billnumber; ?></td>

				<td width="18%"  align="right" valign="center" class="bodytext31">

              <?php echo $remarks; ?></td>

                <td width="12%"  align="right" valign="center" class="bodytext31"><?php echo number_format($totalamount, 2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right"> 

                 <a href="creditapprovalaction.php?user=<?php echo $staffcode;?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>"> Action</a>                </td>	

             </tr>

			<?php

		  }

			}

	//	  }

			

			//}

			 	

			?>

			 

<!--            <tr>

              <td class="bodytext31" valign="center"  align="left" 

><strong>Total:</strong></td>

              <td class="bodytext31" valign="center"  align="right" 

><?php echo number_format($cashamount2,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right" 

><?php echo number_format($cardamount2,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right" 

><?php echo number_format($chequeamount2,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right" 

><?php echo number_format($onlineamount2,2,'.',',');?></td>

				<td class="bodytext31" valign="center"  align="right" 

><?php echo number_format($creditamount2,2,'.',',');?></td>

				<td class="bodytext31" valign="center"  align="right" 

><?php echo number_format($total1,2,'.',',');?></td>

              </tr>

-->          </tbody>

        </table></td>

      </tr>

    </table>

  </table>

<footer>
  <?php include ("includes/footer1.php"); ?>
</footer>
</main>

</body>

</html>



