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

$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

$locationname = $res["locationname"];

$locationcode = $res["locationcode"];



if (isset($_REQUEST["ADate1"])) { $paymentreceiveddatefrom = $_REQUEST["ADate1"]; } else { $paymentreceiveddatefrom = date('Y-m-d'); }

 

if (isset($_REQUEST["ADate2"])) { $paymentreceiveddateto = $_REQUEST["ADate2"]; } else { $paymentreceiveddateto = date('Y-m-d'); }





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

$processcount = 0;

$ipprocessstatus='';

$processstatus='';



 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';



if (isset($_REQUEST["patientname"])) { $searchpatientname = $_REQUEST["patientname"]; } else { $searchpatientname = ""; }

if (isset($_REQUEST["serdoct"])) {  $doctorname = $_REQUEST["serdoct"]; } else { $doctorname = ""; }

if (isset($_REQUEST["serdoctcode"])) { $doctorcode = $_REQUEST["serdoctcode"]; } else { $doctorcode = ""; }



if (isset($_REQUEST["visitcode"])) { $searchvisitcode = $_REQUEST["visitcode"]; } else { $searchvisitcode = ""; }

if (isset($_REQUEST["patienttype"])) { $patienttype = $_REQUEST["patienttype"]; } else { $patienttype = ""; }

if (isset($_REQUEST["servicescode"])) { $servicescode = $_REQUEST["servicescode"]; } else { $servicescode = ""; }

if (isset($_REQUEST["department"])) { $department = $_REQUEST["department"]; } else { $department = ""; }

//echo $department;

if (isset($_REQUEST["servicesitem"])) { $servicesitem = $_REQUEST["servicesitem"]; } else { $servicesitem = ""; }



if (isset($_REQUEST["searchemployeecode"])) { $searchemployeecode = $_REQUEST["searchemployeecode"]; } else { $searchemployeecode = ""; }

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }





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

<script src="js/jquery-1.11.1.min.js"></script>

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js" type="text/javascript"></script>

<link href="js/jquery-ui.css" rel="stylesheet">



<script>



$(function() {



$('#serdoct').autocomplete({

	

source:"ajaxdoc.php",

select:function(event,ui){

$('#serdoct').val(ui.item.value);

$('#serdoctcode').val(ui.item.id);

	document.getElementById("searchsuppliername").disabled = true;



}

 });



$('#servicesitem').autocomplete({

	source:"ajaxautocomplete_services_pkg.php?subtype=<?php echo '1';?>&&loc=<?php echo $locationcode; ?>",

	minLength:3,

	delay: 0,

	html: true, 

		select:function(event,ui){

		$('#servicesitem').val(ui.item.value);

		$('#servicescode').val(ui.item.code);

		}

	});

	

		

$('#searchsuppliername').autocomplete({

		

	source:'ajaxemployeenewsearch.php', 

	//alert(source);

	minLength:3,

	delay: 0,

	html: true, 

		select: function(event,ui){

			var code = ui.item.id;

			var employeecode = ui.item.employeecode;

			var employeename = ui.item.employeename;

			$('#searchemployeecode').val(employeecode);

			$('#searchsuppliername').val(employeename);

				document.getElementById("serdoct").disabled = true;



			

			},

    });

	

	

});

</script>

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

		

		

              <form name="cbform1" method="post" action="servicesreportlist.php">

                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                  <tbody>

                    <tr bgcolor="#011E6A">

                      <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Services Report</strong></td>

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

  			  <td width="18%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Doctor</td>

             <td align="left" width="38%" valign="top"  bgcolor="#FFFFFF" colspan="3"><input name="serdoct" type="text" id="serdoct" value="<?php echo $doctorname; ?>" size="40" >

				   <input name="serdoctcode" type="hidden" id="serdoctcode" value="<?php echo $doctorcode; ?>" size="30">

				   </td>

				   </tr>

				    <tr>

				   <td width="14%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><span class="bodytext32">Service Item</span></td>

                <td width="38%" align="left" valign="middle"  bgcolor="#FFFFFF" colspan="3"><input name="servicesitem" id="servicesitem" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" value="<?php echo $servicesitem; ?>" autocomplete="off">

                <input type="hidden" name="servicescode" id="servicescode" value="<?php echo $servicescode; ?>"></td>

				 

			      </tr>

             	<tr>

					   <td width="14%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><span class="bodytext32">Select Employee</span></td>



	<td width="38%" colspan="3" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">



	<input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="40" autocomplete="off">

	<input name="searchdescription" id="searchdescription" type="hidden" value="">

	<input name="searchemployeecode" id="searchemployeecode" type="hidden" value="<?php echo $searchemployeecode; ?>">

	<input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">

	</td>

	</tr>

              <tr>

  			  <td width="18%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>

              <td align="left" valign="top"  bgcolor="#FFFFFF" colspan="3"><span class="bodytext3">

			  <select name="location" id="location" onChange="ajaxlocationfunction(this.value);">
               <option value="All">All</option>

                    <?php

						

						$query1 = "select locationname,locationcode from master_location where status <> 'deleted' order by locationname";

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

                      </select></td>

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

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="600" 

            align="left" border="0">

          <tbody>

		  <?php

            if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

		    if ($cbfrmflag1 == 'cbfrmflag1')

			{

			

				$sno=1;

				

			?>

            <tr>

              <td width="24"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>S.No</strong></td>

           

              <td width="156" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Service Code</strong></td>

                <td width="187" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Service Name</strong></td>

				                <td width="187" align="left" valign="center"  

bgcolor="#ffffff" class="bodytext31"><strong>Service Count</strong></td>



                  

            </tr>

			

			<?php

if($location=='All')
{
$pass_location = "locationcode !=''";
}
else
{
$pass_location = "locationcode ='$location'";
}

$query7 = "select * from master_employee where employeecode = '$searchemployeecode'";

$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));

$res7 = mysqli_fetch_array($exec7);

$res7username = $res7['username'];



			 $queryservices1="select itemcode,itemname from master_services  where itemcode like '%$servicescode%' group by itemname";

				$exservice1=mysqli_query($GLOBALS["___mysqli_ston"], $queryservices1) or die("error in queryservices".mysqli_error($GLOBALS["___mysqli_ston"]));

				while($resservice1=mysqli_fetch_array($exservice1))

				{

			  					$servicesitemcode=$resservice1['itemcode'];

			  					$servicesitemname=$resservice1['itemname'];

if($doctorcode==''){

			$queryservices="select cs.auto_number from consultation_services cs join billing_paynow bpn on cs.patientvisitcode=bpn.visitcode where  cs.consultationdate between '$ADate1' and '$ADate2' and cs.locationcode='$location' and cs.servicesitemcode ='$servicesitemcode' and cs.username like '%$res7username%' and cs.$pass_location GROUP BY cs.auto_number";
			
			$exservice=mysqli_query($GLOBALS["___mysqli_ston"], $queryservices) or die("error in queryservices".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$numcountoppn=mysqli_num_rows($exservice);



			$queryservices="select cs.auto_number from consultation_services cs join billing_paylater bpn on cs.patientvisitcode=bpn.visitcode where  cs.consultationdate between '$ADate1' and '$ADate2' and cs.locationcode='$location' and cs.servicesitemcode ='$servicesitemcode' and cs.username like '%$res7username%' and cs.$pass_location GROUP BY cs.auto_number";
			
			$exservice=mysqli_query($GLOBALS["___mysqli_ston"], $queryservices) or die("error in queryservices".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$numcountoppl=mysqli_num_rows($exservice);

			$numcountop=$numcountoppn+$numcountoppl;

				

}

else{

	$numcountop=0;

}

				

			

					   $queryipservices="select cs.auto_number from ipconsultation_services cs join billing_ip bpn on cs.patientvisitcode=bpn.visitcode where   cs.servicesitemcode ='$servicesitemcode' and  cs.consultationdate between '$ADate1' and '$ADate2' and cs.doctorcode like '%$doctorcode%'  and cs.locationcode='$location' and cs.username like '%$res7username%' and cs.$pass_location GROUP BY cs.auto_number  ";

				$exipservice=mysqli_query($GLOBALS["___mysqli_ston"], $queryipservices) or die("error in queryipservices".mysqli_error($GLOBALS["___mysqli_ston"]));

				$numcountip=mysqli_num_rows($exipservice);



					

					

				

				if($numcountip+$numcountop>0){

				

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



$processcount=$processcount+$numcountip+$numcountop;

					?>

                    <tr <?php echo $colorcode; ?>>

                    <td width="24"  align="left" 

               class="bodytext31"><?php echo $sno++;?></td>

          

                <td width="156"  align="left" 

                 class="bodytext31"><?php echo $servicesitemcode;?></td>

                 <td width="187"  align="left" 

                 class="bodytext31"><a href="servicesreport_new.php?servicesitemcode=<?= $servicesitemcode; ?>&location=<?= $location; ?>&doctorcode=<?php echo $doctorcode; ?>&doctorname=<?php echo $doctorname; ?>&username=<?= $res7username; ?>&ADate1=<?= $ADate1; ?>&ADate2=<?= $ADate2; ?>&cbfrmflag1=cbfrmflag1" target="_blank" ><?php echo $servicesitemname;?></a></td>

      <td width="187"  align="left" 

                 class="bodytext31"><?php echo $numcountip+$numcountop;?></td>

                    </tr>

                    

					<?php	

				}

			}

			

				

			?>

			<tr>

              <td colspan='13'  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Total  : <?= $processcount;?></strong> </td>

              

                  

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



