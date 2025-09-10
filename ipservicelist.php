<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

//echo $menu_id;
include ("includes/check_user_access.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d');

$transactiondateto = date('Y-m-d');

$consultationdate = '';	

if(isset($_POST['ADate1'])){$fromdate = $_POST['ADate1'];}else{$fromdate=$transactiondatefrom;}

if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate=$transactiondateto;}

$var112=0;

$docno = $_SESSION['docno'];

$sno = 0;



 //get location for sort by location purpose

   $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

	if($location!='')

	{

		  $locationcode=$location;

		}

		//location get end here







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

.number

{

padding-left:900px;

text-align:right;

font-weight:bold;

}

-->

</style>

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<script type="text/javascript" src="jquery/jquery-1.11.3.min.js"></script>

<script language="javascript">



function cbcustomername1()

{

	document.cbform1.submit();

}



</script>



<script type="text/javascript">

function pharmacy(patientcode,visitcode)

{

	var patientcode = patientcode;

	var visitcode = visitcode;

	var url="pharmacy1.php?RandomKey="+Math.random()+"&&patientcode="+patientcode+"&&visitcode="+visitcode;

	

window.open(url,"Pharmacy",'width=600,height=400');

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

<script src="jquery/jquery-1.11.3.min.js"></script>



<script>

$(document).ready(function(){



$('.showdocument').click(function(){

	var sno = $(this).attr('id');

	$('#show'+sno).toggle();	

});

});

</script>



<script src="js/datetimepicker_css.js"></script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; }

-->

</style>

</head>

<body>



<table width="103%" border="0" cellspacing="0" cellpadding="2">

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

    <td width="99%" valign="top"><table width="105%" border="0" cellspacing="0" cellpadding="0">

	      

		  <tr>

        <td width="860">

              <form name="cbform1" method="post" action="ipservicelist.php">

                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                  <tbody>



<?php

                  	$matchfailed=isset($_REQUEST['st'])?$_REQUEST['st']:'';

if($matchfailed=="matchfailed")

{

?>

                 <tr>

                  <td colspan="7"  bgcolor="#FF9933" class="bodytext31"> <span> Failed to update. </span> </td>

                 </tr>



<?php	

}

?>



                   <tr>

                   

          <td colspan="3" bgcolor="#ecf0f5" class="bodytext31"><strong>Service List</strong></td>

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

                  

                  	  <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>

              <td  bgcolor="#FFFFFF" class="bodytext3"  colspan="3" ><select name="location" id="location" onChange=" ajaxlocationfunction(this.value);" style="border: 1px solid #001E6A;">

                  <?php

						

						$query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

						$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res = mysqli_fetch_array($exec))

						{

						$reslocation = $res["locationname"];

						$reslocationanum = $res["locationcode"];

						?>

						<option value="<?php echo $reslocationanum; ?>" <?php if($location!='')if($location==$reslocationanum){echo "selected";}?>><?php echo $reslocation; ?></option>

						<?php

						}

						?>

                  </select></td>

                   

                  <input type="hidden" name="locationnamenew" value="<?php echo $locationname; ?>">

                <input type="hidden" name="locationcodenew" value="<?php echo $res1locationanum; ?>">

             

              </tr>

				  	   <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <input name="patient" type="text" id="patient" value="" size="50" autocomplete="off">

              </span></td>

              </tr>

			    <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Registration No</td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <input name="patientcode" type="text" id="patient" value="" size="50" autocomplete="off">

              </span></td>

              </tr>

			   <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visitcode</td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <input name="visitcode" type="text" id="visitcode" value="" size="50" autocomplete="off">

              </span></td>

              </tr>

                   <tr>

          <td width="100" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>

          <td width="137" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>

          <td width="68" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>

          <td width="263" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">

            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>

		  </span></td>

          </tr>

					

				

			<tr>

                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

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

    <td colspan="9">&nbsp;</td>

  </tr>

  <tr>

   

    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

	<?php if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{

//	$res1patientcode='';

	$searchpatient = $_POST['patient'];

	$searchpatientcode=$_POST['patientcode'];

	$searchvisitcode = $_POST['visitcode'];

	$fromdate=$_POST['ADate1'];

	$todate=$_POST['ADate2'];?>

      <tr>

        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1127" 

            align="left" border="0">

          <tbody>

            <tr>

              <td width="5%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              <td colspan="11" bgcolor="#ecf0f5" class="bodytext31">

                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->

                <div align="left"><strong>Process Service</strong>

                <label class="number"> </label>

                </div></td>

              </tr>

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="left"><strong>No.</strong></div></td>

              <td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> OP Date</strong></div></td>

              <td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patientcode </strong></div></td>

              <td width="6%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visitcode</strong></div></td>

              <td width="13%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient</strong></div></td>

              <td width="7%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>Age</strong></td>

              <td width="6%"  align="left" valign="center" 

                bgcolor="#ffffff" class="style1">Gender</td>

              <td width="18%"  align="left" valign="center" 

                bgcolor="#ffffff" class="style1">Department</td>

              <td width="20%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>Account</strong></td>

              <td width="9%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Action</strong></div></td>

              </tr>

			<?php

			$services_condition = "";
			
			$colorloopcount = '';

			$sno = '0';


			$triagedatefrom = date('Y-m-d', strtotime('-2 day'));

			$triagedateto = date('Y-m-d');
			

			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";

			  $query1 = "select * from ipconsultation_services where locationcode = '".$locationcode."' and patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%'  and billtype='PAY NOW' and process='pending' and consultationdate between '$fromdate' and '$todate' group by patientvisitcode order by consultationdate,auto_number";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while ($res1 = mysqli_fetch_array($exec1))

			{

			$res1patientcode = $res1['patientcode'];

			  $res1visitcode = $res1['patientvisitcode'];

			$res1patientfullname = $res1['patientname'];

			$res1account = $res1['accountname'];

			$res1consultationdate = $res1['consultationdate'];

			 $billnumber=$res1['billnumber'];

			$sno = $sno + 1;

			

			$query11 = "select * from master_customer where customercode = '$res1patientcode' and status = '' ";

			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res11 = mysqli_fetch_array($exec11);

			$res11age = $res11['age'];

			$res11gender= $res11['gender'];

			

			$query111 = "select * from master_ipvisitentry where patientcode = '$res1patientcode' ";

			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res111 = mysqli_fetch_array($exec111);

			$res111consultingdoctor = $res111['consultingdoctor'];

			$res1111department = '';

			//check that patient is a external patient

			if($res1patientcode=='walkin')

			{

			$query11="select * from billing_external where billno='$billnumber'";

			$exec11=mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res11=mysqli_fetch_array($exec11);

			$res11age=$res11['age'];

			$res11gender= $res11['gender'];

			$res1111department = '';

			 $res1visitcode =$res1['billnumber'];

			//$res1account = 'External';

			}



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

			 $query822 = "select * from transaction_stock where patientcode='$res1patientcode'  and locationcode='$locationcode' and patientvisitcode='$res1visitcode' and description='Process' ";

		   $exec822 = mysqli_query($GLOBALS["___mysqli_ston"], $query822) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		   $num822= mysqli_num_rows($exec822);

		  // if($num822 == 0)

		   {

			?>

            <tr <?php echo $colorcode; ?>  class="showdocument"  id="<?php echo $sno; ?>">

              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31"><?php echo $res1consultationdate; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			    <div align="left">

			      <?php echo $res1patientcode;?>			      </div></td>

              <td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo $res1visitcode; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo $res1patientfullname; ?></div></td>

              <td class="bodytext31" valign="center"  align="left"><?php echo $res11age; ?></td>

              <td class="bodytext31" valign="center"  align="left"><?php echo $res11gender; ?></td>

              <td class="bodytext31" valign="center"  align="left"><?php echo $res1111department; ?></td>

              <td class="bodytext31" valign="center"  align="left"><?php echo $res1account; ?></td>

          	 <td><img id="toggleimg" src="images/plus1.gif" width="13" height="13">	</td>

              </tr>

			

			  <tr  id='show<?php echo $sno; ?>'  style="">

             

             <td colspan="9" align='left'>

             

             

           <table width='80%' align='left'>

             

             

             <?php

		 

			$sno11 = '';

			$totalamount=0;

		

			 $query61 = "select * from ipconsultation_services where  patientcode = '$res1patientcode' and patientvisitcode = '$res1visitcode' and billtype='PAY NOW' and process='pending' and consultationdate between '$fromdate' and '$todate' and locationcode = '".$locationcode."' order by consultationdate,auto_number";

$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$numb=mysqli_num_rows($exec61);

while($res61 = mysqli_fetch_array($exec61))

{

	

	$serviceqty =$res61["serviceqty"];
	$req_username =$res61["username"];

	



$refnumber=$res61['refno'];

$service_item_code=$res61['servicesitemcode'];

			

			

$servicename =$res61["servicesitemname"];

$billtype = $res61["billtype"];

$refno = $res61['auto_number'];

$query68="select * from master_services where itemname='$servicename'";

$exec68=mysqli_query($GLOBALS["___mysqli_ston"], $query68);

$res68=mysqli_fetch_array($exec68);

$itemcode=$res68['itemcode'];

$sno11 = $sno11 + 1;

?>

  

  <tr>

  		

		<td class="bodytext31" valign="center"  align="left" colspan="6"><div align="center"><?php echo $service_item_code.' - '.$servicename;?></div></td>

		<input type="hidden" name="service[]" value="<?php echo $servicename;?>">

		<input type="hidden" name="code[]" value="<?php echo $itemcode; ?>">

		<input type="hidden" name="refno[]" value="<?php echo $refno; ?>">

		<input type="hidden" name="sno[]" value="<?php echo $sno11; ?>">

		<input type="hidden" name="billtype" id="billtype" value="<?php //echo $billtype; ?>">

        <input type="hidden" name="serquantity<?php echo $sno11; ?>" id="serquantity<?php echo $sno11; ?>" value="<?php echo $serviceqty; ?>">

		  <td class="bodytext31" valign="center"  align="center"><?php //echo $serviceqty;?>

			 		  </td>



		   <td class="bodytext31" valign="center"  align="center" width='25%'> Requested By: <?php echo $req_username;?>

           <input type="hidden" name="avqtyy<?php echo $sno11;?>" id="avqtyy<?php echo $sno11;?>" readonly value="<?php echo $serviceqty;?>" size="5" style="border:none;background: none;">

       </td>

		<td class="bodytext31" valign="center"  align="center">

        <input type="hidden" name="rfqty<?php echo $sno11;?>" id="rfqty<?php echo $sno11;?>"  value="" size="5" onKeyDown="return numbervaild(event)" onKeyUp="sumtheservice(this.value,<?php echo $sno11;?>)">

       </td>

        <td class="bodytext31" valign="center"  align="left" 

                >&nbsp;</td>

                

                  <td class="bodytext31" valign="center"  align="left" 

               >&nbsp;</td>

                

                     <td class="bodytext31" valign="center"  align="left" 

               >&nbsp;</td>

                

                     <td class="bodytext31" valign="center"  align="left" 

               >&nbsp;</td>

                

                     <td class="bodytext31" valign="center"  align="left" 

               >&nbsp;</td>

                

               <td class="bodytext31" valign="center" align="left" > 

			    

                <div align="left"><?php if($res1patientcode!='walkin'){?><a href="ipprocessservice.php?patientcode=<?php echo $res1patientcode; ?>&&visitcode=<?php echo $res1visitcode; ?>&&refnumber=<?php  echo $refno; ?>&&servicesitemcode=<?php  echo $service_item_code; ?>"><strong>PROCESS</strong></a><?php }?></div></td>

         

         </tr>

              <?php

			}

			  ?>

            </table>  

               

             

            </td>

            </tr>

           

             <?php

			}

		   }

			?>

			<?php

			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
		
			  $query2 = "select * from ipconsultation_services where locationcode = '".$locationcode."' and patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and billtype='PAY LATER' and process='pending' and consultationdate between '$fromdate' and '$todate'  group by patientvisitcode order by consultationdate ,auto_number";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//

			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while ($res2 = mysqli_fetch_array($exec2))

			{

			 $res2patientcode = $res2['patientcode'];

			$res2visitcode = $res2['patientvisitcode'];

			$res2patientfullname = $res2['patientname'];

			$res2account = $res2['accountname'];

			$res2consultationdate = $res2['consultationdate'];

			

				$refnumber=$res1['refno'];

			$service_item_code=$res1['servicesitemcode'];

			$sno = $sno + 1;

			

			$query12 = "select * from master_customer where customercode = '$res2patientcode' and status = '' ";

			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res12 = mysqli_fetch_array($exec12);

			$res12age = $res12['age'];

			$res12gender= $res12['gender'];

			

			$query112 = "select * from master_ipvisitentry where patientcode = '$res2patientcode' ";

			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res112 = mysqli_fetch_array($exec112);

			$res112consultingdoctor = $res112['consultingdoctor'];

			$res1112department = '';

			$res1112plannumber = $res112['planname'];

			$res1112planpercentage = $res112['planpercentage'];



			$querypl = "select forall from master_planname where auto_number = '$res1112plannumber' ";

			$execpl = mysqli_query($GLOBALS["___mysqli_ston"], $querypl) or die ("Error in Querypl".mysqli_error($GLOBALS["___mysqli_ston"]));

			$respl = mysqli_fetch_array($execpl);

			$resplforall = $respl['forall'];

			

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

			if(true){

				

			$query822 = "select * from transaction_stock where patientcode='$res2patientcode'  and locationcode='$locationcode' and patientvisitcode='$res2visitcode' and description='Process' ";

		   $exec822 = mysqli_query($GLOBALS["___mysqli_ston"], $query822) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		   $num822= mysqli_num_rows($exec822);

		  // if($num822 == 0)

		   {

			?>

            <tr <?php echo $colorcode; ?>  class="showdocument"  id="<?php echo $sno; ?>" >

              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31"><?php echo $res2consultationdate; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			    <div align="left">

			      <?php echo $res2patientcode;?>			      </div></td>

              <td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo $res2visitcode; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo $res2patientfullname; ?></div></td>

               <td class="bodytext31" valign="center"  align="left"><?php echo $res12age; ?></td>

              <td class="bodytext31" valign="center"  align="left"><?php echo $res12gender; ?></td>

              <td class="bodytext31" valign="center"  align="left"><?php echo $res1112department; ?></td>

              <td class="bodytext31" valign="center"  align="left"><?php echo $res2account; ?></td>

              <td class="bodytext31" valign="center" align="left">

			  <img id="toggleimg" src="images/plus1.gif" width="13" height="13">

              </td>

              </tr>

             

             

             <tr  id='show<?php echo $sno; ?>'  style="">

             

             <td colspan="8" align='left' >

            

           <table width='80%' align='left'>

             

             

             <?php

			 

			$sno11 = '';

			$totalamount=0;


			  $query61 = "select * from ipconsultation_services where  patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and billtype='PAY LATER' and process='pending' and consultationdate between '$fromdate' and '$todate' and locationcode = '".$locationcode."' order by consultationdate ,auto_number";

$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$numb=mysqli_num_rows($exec61);

while($res61 = mysqli_fetch_array($exec61))

{

	

	$serviceqty =$res61["serviceqty"];
	$req_username =$res61["username"];

	/*for($i=0; $i<$serviceqty; $i++)

	{ */



$refnumber=$res61['refno'];

$service_item_code=$res61['servicesitemcode'];

			

			

$servicename =$res61["servicesitemname"];

$billtype = $res61["billtype"];

$refno = $res61['auto_number'];

$query68="select * from master_services where itemname='$servicename'";

$exec68=mysqli_query($GLOBALS["___mysqli_ston"], $query68);

$res68=mysqli_fetch_array($exec68);

$itemcode=$res68['itemcode'];

$sno11 = $sno11 + 1;

?>

  

  <tr>

  		

		<td class="bodytext31" valign="center"  align="left" colspan="6"><div align="center"><?php echo $service_item_code.' - '.$servicename;?></div></td>

		<input type="hidden" name="service[]" value="<?php echo $servicename;?>">

		<input type="hidden" name="code[]" value="<?php echo $itemcode; ?>">

		<input type="hidden" name="refno[]" value="<?php echo $refno; ?>">

		<input type="hidden" name="sno[]" value="<?php echo $sno11; ?>">

		<input type="hidden" name="billtype" id="billtype" value="<?php //echo $billtype; ?>">

        <input type="hidden" name="serquantity<?php echo $sno11; ?>" id="serquantity<?php echo $sno11; ?>" value="<?php echo $serviceqty; ?>">

		  <td class="bodytext31" valign="center"  align="center"><?php //echo $serviceqty;?>

			 		  </td>



		   <td class="bodytext31" valign="center"  align="center" width='25%'> Requested By: <?php echo $req_username;?>

           <input type="hidden" name="avqtyy<?php echo $sno11;?>" id="avqtyy<?php echo $sno11;?>" readonly value="<?php echo $serviceqty;?>" size="5" style="border:none;background: none;">

       </td>

		<td class="bodytext31" valign="center"  align="center">

        <input type="hidden" name="rfqty<?php echo $sno11;?>" id="rfqty<?php echo $sno11;?>"  value="" size="5" onKeyDown="return numbervaild(event)" onKeyUp="sumtheservice(this.value,<?php echo $sno11;?>)">

       </td>

        <td class="bodytext31" valign="center"  align="left" 

                >&nbsp;</td>

                

                  <td class="bodytext31" valign="center"  align="left" 

               >&nbsp;</td>

                

                     <td class="bodytext31" valign="center"  align="left" 

               >&nbsp;</td>

                

                     <td class="bodytext31" valign="center"  align="left" 

               >&nbsp;</td>

                

                     <td class="bodytext31" valign="center"  align="left" 

               >&nbsp;</td>

                

               <td class="bodytext31" valign="center" align="left" > 

			    

                <div align="left"><?php if($res2patientcode!='walkin'){?><a href="ipprocessservice.php?patientcode=<?php echo $res2patientcode; ?>&&visitcode=<?php echo $res2visitcode; ?>&&refnumber=<?php  echo $refno; ?>&&servicesitemcode=<?php  echo $service_item_code; ?>"><strong>PROCESS</strong></a><?php }?></div></td>

         

         </tr>

              <?php

			}

			  ?>

            </table>  

               

             

            </td>

            </tr>

           



              

              

			<?php

			}  } }  

			?>

          <?php } ?>

    </table>

  </table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>



