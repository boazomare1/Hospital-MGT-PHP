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

$colorloopcount = '';

$sno = '';

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

//$getcanum = $_GET['canum'];

$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';


if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }

if (isset($_REQUEST["cbvisitcode"])) { $cbvisitcode = $_REQUEST["cbvisitcode"]; } else { $cbvisitcode = ""; }

if (isset($_REQUEST["cbpatientcode"])) { $cbpatientcode = $_REQUEST["cbpatientcode"]; } else { $cbpatientcode = ""; }

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

if($ADate2=='' & $ADate1==''){
	
$ADate1 = date('Y-m-d', strtotime('-1 month'));

$ADate2 = date('Y-m-d');	
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

	//var oTextbox = new AutoSuggestControl(document.getElementById("searchcustomername"), new StateSuggestions());        

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

<script src="js/jquery-1.11.1.min.js"></script>

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/autocomplete.css">      

<script>

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

		

		

              <form name="cbform1" method="post" action="consultationfee_report.php">

		<table width="791" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Consultation Fee Report </strong></td>

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

              <td colspan="3" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input name="cbcustomername" type="text" id="cbcustomername" value="" size="50" autocomplete="off"></td>

              <td colspan="4" align="left" valign="top"  bgcolor="#ecf0f5">                               </td>

              </tr>
			  
			  <tr>

              <td width="15%"  align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">PatienCode </td>

              <td colspan="3"  align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input value="" name="cbpatientcode" type="text" id="cbpatientcode"  onKeyDown="return disableEnterKey()" size="50" ></td>

              <td colspan="4" align="left" valign="top"  bgcolor="#ecf0f5">			  </td>

              </tr> 

            <tr>

              <td width="15%"  align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visit Code </td>

              <td colspan="3"  align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input value="" name="cbvisitcode" type="text" id="cbvisitcode"  onKeyDown="return disableEnterKey()" size="50" ></td>

              <td colspan="4" align="left" valign="top"  bgcolor="#ecf0f5">			  </td>

              </tr>

           <tr>

             <td  align="left" valign="center" 

                bgcolor="#FFFFFF" class="bodytext31"> Date From </td>

             <td width="21%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">

			  <input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>				</td>

              <td width="10%"  align="left" valign="center" 

                bgcolor="#FFFFFF" class="bodytext31"> Date To </td>

              <td width="37%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">

                <input name="ADate2" id="ADate2"  value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>

			  </span></td>

              <td colspan="3" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              </tr>

			  <tr>

             <td  align="left" valign="center" 

			  <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>

              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

				 <select name="location" id="location" onChange="ajaxlocationfunction(this.value);">

                    <?php

						$query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' order by locationname";

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
 

			 </td>

			 </tr>

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                  <input  type="submit" value="Search" name="Submit" />

                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>

              <td width="3%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              <td width="14%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><a target="_blank" href="excel_consultationfeereport.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&user=<?php echo $cbcustomername; ?>&&visitcode=<?php echo $cbvisitcode; ?>&&locationcode=<?php echo $locationcode1; ?>&&cbpatientcode=<?php echo $cbpatientcode; ?>"><img src="images/excel-xls-icon.png" width="30" height="30" border="0"></a></td>

			</tr>

          </tbody>

        </table>

		</form>		</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>
			<?php if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

			if($cbfrmflag1 == 'cbfrmflag1'){ ?>
      <tr>

        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="80%" align="left" border="0">

          <tbody>

            <tr>

			 <td class="bodytext31" valign="center"  align="left"  bgcolor="#ffffff"><strong>No.</strong></td>

			 <td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Patient Name</strong></td>

			 <td width="" align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><strong> Reg No. </strong></td>

			<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong> Visit Code </strong></td>
			
			<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong> Consultating Doctor </strong></td>

			<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong> Department </strong></td>

			<td width="" align="left" valign="center"    bgcolor="#ffffff" class="bodytext31"><strong> Doctor Consultation </strong></td>
			
			<td width="" align="left" valign="center"    bgcolor="#ffffff" class="bodytext31"><strong> Consultation Type</strong></td>

			<td width=""  align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Diagnosis </strong></div></td>

			<td width=""  align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit Created By </strong></div></td>
			
			<td width=""  align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visitcount </strong></div></td>

			<td width=""  align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Time Visit</strong></div></td>
			
			<td width=""  align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Last Visit</strong></div></td>
			
			<td width=""  align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit Diff(Hrs)</strong></div></td>

			</tr>

			<?php  
			
			 $query1 = "select * from master_visitentry where consultationdate between '$ADate1' and '$ADate2' and patientfullname like '%$cbcustomername%' and visitcode like '%$cbvisitcode%' and consultationfees = '0' and patientcode like '%$cbpatientcode%' ";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
				$visitcode = $res1['visitcode'];
				$patientcode = $res1['patientcode'];
				$patientfullname = $res1['patientfullname'];
				$departmentname = $res1['departmentname'];
				$doctorconsultation = $res1['doctorconsultation'];
				$visitcount = $res1['visitcount'];
				$consultationtype = $res1['consultationtype'];
				$consultingdoctor = $res1['consultingdoctor'];
				$consultationdate = $res1['consultationdate'];
				$consultationtime = $res1['consultationtime'];
				$res1vistdatetime = $consultationdate.' '.$consultationtime;
				$autonumber=$res1['auto_number'];
				$username=$res1['username'];
			
					$query5 = "select * from consultation_icd where patientvisitcode = '$visitcode'";
					$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res5 = mysqli_fetch_array($exec5);
					$primarydiag = $res5['primarydiag'];
					
					$query58 = "select * from master_consultationtype where auto_number = '$consultationtype'";
					$exec58 = mysqli_query($GLOBALS["___mysqli_ston"], $query58) or die ("Error in Query58".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res58 = mysqli_fetch_array($exec58);
					$res58consultationtype = $res58['consultationtype'];
					
					
					//$query51 = "select * from master_visitentry where patientcode = '$patientcode' order by auto_number desc limit 0,1";
					 $query51 = "select * from master_visitentry where patientcode = '$patientcode' and visitcode !='$visitcode' and auto_number <'$autonumber' order by auto_number desc limit 0,1";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num51 = mysqli_num_rows($exec51);
					$res51 = mysqli_fetch_array($exec51);
					$res51consultationdate= $res51['consultationdate'];
					$res51consultationtime= $res51['consultationtime'];
					if($num51>0){
					$res51lastvistdatetime = $res51consultationdate.' '.$res51consultationtime;
					
					$diff = strtotime($res1vistdatetime) - strtotime($res51lastvistdatetime);
					$days_diff = round($diff/3600);

					} else {
						$res51consultationdate='0000-00-00';
						$res51lastvistdatetime='0000-00-00';
						$days_diff='0';
					}
					
					
					//$diff = abs(strtotime($consultationdate) - strtotime($res51consultationdate));
			
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
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $sno = $sno + 1; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientfullname; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $visitcode; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $consultingdoctor; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $departmentname; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $doctorconsultation; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res58consultationtype; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $primarydiag; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $username; ?></div></td>
			
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $visitcount; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res1vistdatetime; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res51lastvistdatetime; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $days_diff; ?></div></td>
			</tr>
			
			<?php
			}
			?>

            <tr>

              <td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			  <td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left"   bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left"   bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5">&nbsp;</td>
				
				<td class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5">&nbsp;</td>

            

             

              </tr>

          </tbody>

        </table></td>

      </tr>

	  
	    <?php    
		}
		?>
	  
    </table>

  </table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>



