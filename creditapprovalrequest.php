<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedate = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$updatetime = date('H:i:s');



$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$searchsuppliername = "";

$cbsuppliername = "";













if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

//$frmflag2 = $_POST['frmflag2'];



if ($frmflag1 == 'frmflag1')

{

       //get locationcode and locationname for inserting

 $locationcodeget=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';

 $locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';

//get ends here

		$paynowbillprefix7 = 'IPCA-';

$paynowbillprefix17=strlen($paynowbillprefix7);

$query27 = "select * from ip_creditapproval order by auto_number desc limit 0, 1";

$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));

$res27 = mysqli_fetch_array($exec27);

$billnumber7 = $res27["docno"];

$billdigit7=strlen($billnumber7);



if ($billnumber7 == '')

{

	$billnumbercode7 =$paynowbillprefix7.'1';

		$openingbalance = '0.00';



}

else

{

	$billnumber7 = $res27["docno"];

	$billnumbercode7 = substr($billnumber7,$paynowbillprefix17, $billdigit7);

	//echo $billnumbercode;

	$billnumbercode7 = intval($billnumbercode7);

	$billnumbercode7 = $billnumbercode7 + 1;



	$maxanum7 = $billnumbercode7;

	

	

	$billnumbercode7 = $paynowbillprefix7 .$maxanum7;

		}

		$patientname = $_REQUEST['patientname'];

		$patientcode = $_REQUEST['patientcode'];

		$visitcode = $_REQUEST['visitcode'];

		$accname = $_REQUEST['accname'];

		$ward1 = $_REQUEST['wardanum'];

		$bed1 = $_REQUEST['bedanum'];

		$requestforapproval = $_REQUEST['requestforapproval'];

		

			

		$query33 = "select * from ip_creditapproval where docno='$billnumbercode7'";

		$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$num33 = mysqli_num_rows($exec33);

		if($num33 == 0)

		{

		if($requestforapproval == 1)

		{

		

		

		

		$query67 = "insert into ip_creditapproval(docno,patientname,patientcode,visitcode,accountname,ward,bed,recordtime,recorddate,ipaddress,username,locationname,locationcode)values('$billnumbercode7','$patientname','$patientcode','$visitcode','$accname','$ward1','$bed1','$updatetime','$updatedate','$ipaddress','$username','".$locationnameget."','".$locationcodeget."')";

		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		

		$query88 = "update ip_bedallocation set creditapprovalstatus='approved' where patientcode='$patientcode' and visitcode='$visitcode'";

		$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		

		$query881 = "update ip_discharge set creditapprovalstatus='approved' where patientcode='$patientcode' and visitcode='$visitcode'";

		$exec881 = mysqli_query($GLOBALS["___mysqli_ston"], $query881) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	}

	

			}

		header("location:ipbilling.php");

		exit;



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

<?php

$query3 = "select * from master_company where companystatus = 'Active'";

$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

$res3 = mysqli_fetch_array($exec3);

$paynowbillprefix = 'IPCA-';

$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select * from ip_creditapproval order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["docno"];

$billdigit=strlen($billnumber);



if ($billnumber == '')

{

	$billnumbercode =$paynowbillprefix.'1';

		$openingbalance = '0.00';



}

else

{

	$billnumber = $res2["docno"];

	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);

	//echo $billnumbercode;

	$billnumbercode = intval($billnumbercode);

	$billnumbercode = $billnumbercode + 1;



	$maxanum = $billnumbercode;

	

	

	$billnumbercode = $paynowbillprefix .$maxanum;

	$openingbalance = '0.00';

	//echo $companycode;

}



?>

<?php



if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }

if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }



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



<script>





function validcheck()

{

if(document.getElementById("bed").value == '')

{

alert("Please Select Bed");

document.getElementById("bed").focus();

return false;

}

if(document.getElementById("ward").value == '')

{

alert("Please Select Ward");

document.getElementById("ward").focus();

return false;

}



}







function funcwardChange1()

{

	/*if(document.getElementById("ward").value == "1")

	{

		alert("You Cannot Add Account For CASH Type");

		document.getElementById("ward").focus();

		return false;

	}*/

	<?php 

	$query12 = "select * from master_ward where recordstatus=''";

	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

	while ($res12 = mysqli_fetch_array($exec12))

	{

	$res12wardanum = $res12["auto_number"];

	$res12ward = $res12["ward"];

	?>

	if(document.getElementById("ward").value=="<?php echo $res12wardanum; ?>")

	{

		document.getElementById("bed").options.length=null; 

		var combo = document.getElementById('bed'); 	

		<?php 

		$loopcount=0;

		?>

		combo.options[<?php echo $loopcount;?>] = new Option ("Select Sub Type", ""); 

		<?php

		$query10 = "select * from master_bed where ward = '$res12wardanum' and recordstatus = ''";

		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res10 = mysqli_fetch_array($exec10))

		{

		$loopcount = $loopcount+1;

		$res10bedanum = $res10['auto_number'];

		$res10bed = $res10["bed"];

		

		

		

		?>

			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10bed;?>", "<?php echo $res10bedanum;?>"); 

		<?php 

		

		}

		?>

	}

	<?php

	}

	?>	

}



function funcvalidation()

{

//alert('h');



var discharge = document.getElementById("discharge").value;

if(discharge == 0)

{

alert("Please discharge the patient before approval");

return false;

}





if(document.getElementById("requestforapproval").checked == false)

{

alert("Please Click on Request for Approval");

return false;

}





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

</style>

</head>



<script src="js/datetimepicker_css.js"></script>



<body>

<form name="form1" id="form1" method="post" action="creditapprovalrequest.php" onSubmit="return validcheck()">	

<table width="101%" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="14">&nbsp;</td>

  </tr>

  <tr>

    <td width="2%">&nbsp;</td>

   

    <td colspan="5" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

      

	 

	

		<tr>

		<td>



		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 

            align="left" border="0">

          <tbody>

          <?php

		  

		  $locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';

		   $query1 = "select locationcode from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num1=mysqli_num_rows($exec1);

		

		while($res1 = mysqli_fetch_array($exec1))

		{

		

		

		$locationcodeget = $res1['locationcode'];

		$query551 = "select * from master_location where locationcode='".$locationcodeget."'";

		$exec551 = mysqli_query($GLOBALS["___mysqli_ston"], $query551) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$res551 = mysqli_fetch_array($exec551);

		$locationnameget = $res551['locationname'];

		}?>

             <tr>

			  <td width="13%" align="center" valign="center" class="bodytext31"><strong>Doc No</strong></td>

			   <td width="19%" align="center" valign="center" class="bodytext31"><input type="text" name="docno" id="docno" value="<?php echo $billnumbercode; ?>" size="10" readonly></td>

			   <td width="10%"  align="left" valign="center" class="bodytext31"><strong>Date</strong></td>

			   <td width="12%"  align="left" valign="center" class="bodytext31"> 

			   <input type="text" name="date" id="date" value="<?php echo $updatedate; ?>" size="10" readonly>

                      <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('dateofbirth')" style="cursor:pointer"/> </span></strong>

               </td>

               <td width="12%"  align="left" valign="center" class="bodytext31"> &nbsp;</td>

               <td colspan="2" class="bodytext31" ><strong>Location &nbsp;</strong><?php echo $locationnameget;?></td>

                <input type="hidden" name="locationcodeget" value="<?php echo $locationcodeget?>">

				<input type="hidden" name="locationnameget" value="<?php echo $locationnameget?>">

             </tr>

            <tr>

              

				 <td colspan="2"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient Name</strong></div></td>

           

				 <td colspan="2"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>

				 <td width="20%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP Visit  </strong></div></td>

				 <td width="13%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ward</strong></div></td>

				<td width="13%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bed</strong></div></td>

              </tr>

           <?php

            $colorloopcount ='';

		

		$query1 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode' and paymentstatus =''";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num1=mysqli_num_rows($exec1);

		

		while($res1 = mysqli_fetch_array($exec1))

		{

		$patientname=$res1['patientfullname'];

		$patientcode=$res1['patientcode'];

		$accountname = $res1['accountname'];

		$gender = $res1['gender'];

		$age = $res1['age'];

		

		$query32 = "select * from ip_discharge where patientcode='$patientcode' and visitcode='$visitcode'";

		$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$num32 = mysqli_num_rows($exec32);

		

		$query67 = "select * from master_accountname where auto_number='$accountname'";

		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 

		$res67 = mysqli_fetch_array($exec67);

		$accname = $res67['accountname'];

		

		

		   $query63 = "select * from ip_bedallocation where patientcode='$patientcode' and visitcode='$visitcode'";

		   $exec63 = mysqli_query($GLOBALS["___mysqli_ston"], $query63) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		   $res63 = mysqli_fetch_array($exec63);

		   $ward = $res63['ward'];

		   $bed = $res63['bed'];

		   

		   $query71 = "select * from ip_creditapproval where patientcode='$patientcode' and visitcode='$visitcode' order by auto_number desc";

		   $exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		   $res71 = mysqli_fetch_array($exec71);

		   $num71 = mysqli_num_rows($exec71);

		   if($num71 > 0)

		   {

		    $ward = $res71['ward'];

		    $bed = $res71['bed'];

		   }

		

		$query7811 = "select * from master_ward where auto_number='$ward' and recordstatus=''";

						  $exec7811 = mysqli_query($GLOBALS["___mysqli_ston"], $query7811) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

						  $res7811 = mysqli_fetch_array($exec7811);

						  $wardname1 = $res7811['ward'];

						  

						  $query50 = "select * from master_bed where auto_number='$bed'";

		                  $exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

						  $res50 = mysqli_fetch_array($exec50);

						  $bedname = $res50['bed'];

	



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

             

			  <td colspan="2"  align="left" valign="center" class="bodytext31">

			    <div align="center"><?php echo $patientname; ?></div></td>

				<td colspan="2"  align="center" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>

				<td  align="center" valign="center" class="bodytext31"><?php echo $visitcode; ?></td>

				<td  align="center" valign="center" class="bodytext31"><?php echo $wardname1; ?></td>

				<td  align="center" valign="center" class="bodytext31"><?php echo $bedname; ?></td>

				<input type="hidden" name="wardanum" id="wardanum" value="<?php echo $ward; ?>">

				<input type="hidden" name="bedanum" id="bedanum" value="<?php echo $bed; ?>">

				<input type="hidden" name="patientname" id="patientname" value="<?php echo $patientname; ?>">

				 

				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>">

				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>">

			

				<input type="hidden" name="accname" id="accname" value="<?php echo $accname; ?>">

				<input type="hidden" name="discharge" id="discharge" value="<?php echo $num32; ?>">		

			   </tr>

		   <?php 

		   } 

		  

		   ?>

           

            <tr>

             	<td colspan="5" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td><td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

            

             	<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

             	</tr>

          </tbody>

        </table>		</td>

		</tr>

		

		</table>		</td>

		</tr>

	

      <tr>

        <td>&nbsp;</td>

      </tr>

	  <?php
	  $query641 = "select * from ip_nhifprocessing where patientcode='$patientcode' and patientvisitcode='$visitcode'";
	  $exec641 = mysqli_query($GLOBALS["___mysqli_ston"], $query641) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	  $num1=mysqli_num_rows($exec641);
	  if($num1>0){
		  ?>
          <tr>
        <td colspan='6' align='center'><strong><font color='red'>This patient has NHIF Rebate and hence approval is barred. Pl do delete the NHIF rebate and do the Credit Approval</fond></strong></td>
      </tr>
		  <?php

	  }else{
	  ?>
       <tr>

        <td>&nbsp;</td>

		 <td width="3%">&nbsp;</td>

		  <td width="3%">&nbsp;</td>

		<td width="26%" align="right" valign="center" class="bodytext311">Request for Approval</td>

		<td width="29%" align="left" valign="center" class="bodytext311"><input type="checkbox" name="requestforapproval" id="requestforapproval" value="1"></td>

      </tr>

	  <tr>

        <td>&nbsp;</td>

		 <td>&nbsp;</td>

		  <td>&nbsp;</td>

		<td>&nbsp;</td>

		<td>&nbsp;</td>

		<td width="37%" align="center" valign="center" class="bodytext311">         <input type="hidden" name="frmflag1" value="frmflag1" />

        <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" onClick="return funcvalidation()"/></td>

                 

      </tr>

      <?php } ?>

	  
    </table>

  </table>

</form>

<?php include ("includes/footer1.php"); ?>

</body>

</html>



