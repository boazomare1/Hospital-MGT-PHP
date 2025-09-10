<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");

$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];

$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$dateonly1 = date("Y-m-d");
$timeonly= date("H:i:s");
$titlestr = 'SALES BILL';
$colorloopcount = '';
$sno = '';
?>
		

<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
</style>
<?php
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
$docnumber = $_REQUEST["docnumber"];
?>
<script src="js/datetimepicker_css.js"></script>
<?php
if($patientcode != 'walkin')
{
$query65= "select * from master_visitentry where patientcode='$patientcode'";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die("error in query65".mysqli_error($GLOBALS["___mysqli_ston"]));
$res65=mysqli_fetch_array($exec65);
$patientname=$res65['patientfullname'];

$query69="select * from master_customer where customercode='$patientcode'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
$patientaccount=$res69['accountname'];

$query78="select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec78=mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res78=mysqli_fetch_array($exec78);
$patientage=$res78['age'];
$patientgender=$res78['gender'];


$query70="select * from master_accountname where auto_number='$patientaccount'";
$exec70=mysqli_query($GLOBALS["___mysqli_ston"], $query70);
$res70=mysqli_fetch_array($exec70);
$accountname=$res70['accountname'];
}
else
{
$query55="select * from consultation_radiology where docnumber='$docnumber'";
$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res55=mysqli_fetch_array($exec55);
$patientname = $res55['patientname'];
$billnumber = $res55['billnumber'];
$query66="select * from billing_external where billno='$billnumber'";
$exec66=mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res66=mysqli_fetch_array($exec66);
$patientage=$res66['age'];
$patientgender=$res66['gender'];
}
?>

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body>
<form name="frm" id="frmsales" method="post" action="radiologyresultsview.php" onKeyDown="return disableEnterKey(event)">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
<!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="980" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td colspan="4" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#ecf0f5'; } else { echo 'red'; } ?>" class="bodytext3"><strong><?php echo $errmsg;?>&nbsp;</strong></td></tr>
      <tr>
        <td colspan="8"><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#ecf0f5" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#ecf0f5">
              
                    <input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" /> 
                    <input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
               <td class="bodytext3" bgcolor="#ecf0f5"><strong>Patient  * </strong></td>
	  <td width="22%" class="bodytext3" align="left" valign="middle" bgcolor="#ecf0f5">
				<input name="customername" type="hidden" id="customer" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/>
				<?php echo $patientname; ?></td>
                          <td bgcolor="#ecf0f5" class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Date </strong></td>
				
                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
                
                <td width="26%" bgcolor="#ecf0f5" class="bodytext3">
               
                  <input name="ADate" id="ADate" style="border: 1px solid #001E6A" value="<?php echo $dateonly1; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                  <img src="images2/cal.gif" style="cursor:pointer"/>				</td>
				<td width="11%" align="left" valign="middle" class="bodytext3"><strong>Age &amp; Gender</strong></td>
                <td width="21%" align="left" valign="middle" class="bodytext3">
			<input name="docnumber" id="docnumber" type="hidden" value="<?php echo $docnumber; ?>" style="border: 1px solid #001E6A" size="8" rsize="20" readonly/><?php echo $patientage; ?>  & <?php echo $patientgender; ?>                </td>
              </tr>
			  <tr>
			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code</strong></td>
                <td width="22%" class="bodytext3" align="left" valign="middle" >
			<input name="visitcode" type="hidden" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $visitcode; ?>                  </td>
                 <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient code </strong></td>
                <td colspan="1" align="left" valign="top" class="bodytext3">
				<input name="customercode" type="hidden" id="customercode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientcode; ?>
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
				<td width="11%" align="left" valign="middle" class="bodytext3"><strong>Account</strong></td>
                <td width="21%" align="left" valign="middle" class="bodytext3"><?php echo $accountname; ?></td>
			    </tr>
				  
				<input type="hidden" name="patientage" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly>
				
				<input type="hidden" name="patientgender" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly>		        
               
				<input name="account" type="hidden" id="account" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="samplecollectiondocno" value="<?php echo $docnumber; ?>">				
				 
				  <tr>
				  <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
				  </tr>
            </tbody>
        </table></td>
      </tr>
	
		<tr>
			<td colspan="3" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext365">
			<strong>ANC NOTES</strong>			</td> 
		</tr>	
		<tr>
		<td colspan="3">
		<table id="presid" width="980" border="0" cellspacing="1" cellpadding="1">
	  		<tr><td colspan="13" class="bodytext3"><strong>Previous Pregnancy</strong></td></tr>
			<tr bgcolor="#ecf0f5">
					 <td width="32" class="bodytext3">No</td>
                       <td width="102" class="bodytext3">Pregnancy Order</td>
                       <td width="30" class="bodytext3">Year</td>
                       <td width="151" class="bodytext3">Number of times ANC attended</td>
                       <td width="103" class="bodytext3">Place of Delivery</td>
                       <td width="55" class="bodytext3">Maturity</td>
					    <td width="117" class="bodytext3">Duration of Labour</td>
                       <td width="102" class="bodytext3">Type of Delivery</td>
                       <td width="102" class="bodytext3">Birth Weight Kg</td>
                       <td width="23" class="bodytext3">Sex</td>
                       <td width="57" class="bodytext3">Outcome</td>
					    <td width="69" class="bodytext3">Puerperium</td>
          </tr>
					 <?php
					 $colorloopcount='';
					 $showcolor='';
					 $queryanc5 = "select * from ancprevpreg where patientcode = '$patientcode' and patientvisitcode = '$visitcode'";
					 $execanc5 = mysqli_query($GLOBALS["___mysqli_ston"], $queryanc5) or die ("Error in Queryanc5".mysqli_error($GLOBALS["___mysqli_ston"]));
					 while($resanc5 = mysqli_fetch_array($execanc5))
					 {
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
					 
					 <tr <?php echo $colorcode ; ?>>
					 <td width="32" class="bodytext3"><?php echo $resanc5['number']; ?></td>
                       <td width="102" class="bodytext3"><?php echo $resanc5['pregnancyorder'];?></td>
                       <td width="30" class="bodytext3"><?php echo $resanc5['year'];?></td>
                       <td width="151" class="bodytext3"><?php echo $resanc5['notimesanc'];?></td>
                       <td width="103" class="bodytext3"><?php echo $resanc5['delivery'];?></td>
                       <td width="55" class="bodytext3"><?php echo $resanc5['maturity'];?></td>
					    <td width="117" class="bodytext3"><?php echo $resanc5['durationlabour'];?></td>
                       <td width="102" class="bodytext3"><?php echo $resanc5['typeofdelivery'];?></td>
                       <td width="102" class="bodytext3"><?php echo $resanc5['birthweight'];?></td>
                       <td width="23" class="bodytext3"><?php echo $resanc5['sex'];?></td>
                       <td width="57" class="bodytext3"><?php echo $resanc5['outcome'];?></td>
					    <td width="69" class="bodytext3"><?php echo $resanc5['puerperium'];?></td>
                     </tr>
					 <?php }
					 ?>
					  <tr><td colspan="14" class="bodytext3"><strong>&nbsp;</strong></td></tr>
			  </table>
		    </td>
					 </tr>
				<tr>
				<td colspan="3">
				 <table id="presid" width="831" border="0" cellspacing="1" cellpadding="1">
				   <tr><td colspan="10" class="bodytext3"><strong>Physical Examination ( First Visit)</strong></td></tr>
				   <tr bgcolor="#ecf0f5">
					 <td width="54" class="bodytext3">CVS</td>
					 <td width="48" class="bodytext3">Vaginal Examination</td>
					 <td width="90" class="bodytext3">Breasts</td>
					 <td width="65" class="bodytext3">Discharge/Genital Ulcer</td>
					 <td width="78" class="bodytext3">Abdomen</td></tr>
				    <?php
					 $queryanc6 = "select * from ancphysixam where patientcode = '$patientcode' and patientvisitcode = '$visitcode'";
					 $execanc6 = mysqli_query($GLOBALS["___mysqli_ston"], $queryanc6) or die ("Error in Queryanc6".mysqli_error($GLOBALS["___mysqli_ston"]));
					 while($resanc6 = mysqli_fetch_array($execanc6))
					 {
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
				   <tr <?php echo $colorcode ; ?>>
					 <td class="bodytext3"><?php echo $resanc6['cvs']; ?></td>                       
                       <td class="bodytext3"><?php echo $resanc6['vaiginalxam']; ?></td>
                       
                       <td class="bodytext3"><?php echo $resanc6['breasts']; ?></td>
                       
					   <td class="bodytext3"><?php echo $resanc6['dischargeulcer']; ?></td>
                       
                       <td class="bodytext3"><?php echo $resanc6['abdomen']; ?></td>
                                       
				      </tr>
					   <?php }
					 ?>
					  <tr><td colspan="10" class="bodytext3"><strong>&nbsp;</strong></td></tr>
                     </table>
				</td>
				</tr>
				<tr>
				<td colspan="3">
				 <table id="presid" width="900" border="0" cellspacing="1" cellpadding="1">
				    <tr><td colspan="14" class="bodytext3"><strong>Present Pregnancy</strong></td></tr>
					<tr bgcolor="#ecf0f5">
					 <td width="37" class="bodytext3">No</td>
                       <td width="56" class="bodytext3">Visit</td>
                       <td width="89" class="bodytext3">Date</td>
                       <td width="70" class="bodytext3">Urine</td>
                       <td width="44" class="bodytext3">Weight</td>
                       <td width="25" class="bodytext3">BP</td>
					    <td width="28" class="bodytext3">HP</td>
                       <td width="43" class="bodytext3">Pallor</td>
                       <td width="62" class="bodytext3">Maturity</td>
                       <td width="96" class="bodytext3">Fundal Height</td>
                       <td width="82" class="bodytext3">Presentation</td>
					    <td width="58" class="bodytext3">Lie</td>
						 <td width="105" class="bodytext3">Foetal Heart</td>
						  <td width="62" class="bodytext3">Next Visit</td>
                   </tr>
				 <?php
					 $sno='';
					 $queryanc7 = "select * from ancprespreg where patientcode = '$patientcode' and patientvisitcode = '$visitcode'";
					 $execanc7 = mysqli_query($GLOBALS["___mysqli_ston"], $queryanc7) or die ("Error in Queryanc7".mysqli_error($GLOBALS["___mysqli_ston"]));
					 while($resanc7 = mysqli_fetch_array($execanc7))
					 {
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
                     <tr <?php echo $colorcode ; ?>>
					 <td width="37" class="bodytext3"><?php echo $resanc7['number']; ?></td>
                       <td width="56" class="bodytext3"><?php echo $resanc7['visit']; ?></td>
                       <td width="89" class="bodytext3"><?php echo $resanc7['date']; ?></td>
                       <td width="70" class="bodytext3"><?php echo $resanc7['urine']; ?></td>
                       <td width="44" class="bodytext3"><?php echo $resanc7['weight']; ?></td>
                       <td width="25" class="bodytext3"><?php echo $resanc7['bp']; ?></td>
					    <td width="28" class="bodytext3"><?php echo $resanc7['hp']; ?></td>
                       <td width="43" class="bodytext3"><?php echo $resanc7['pallor']; ?></td>
                       <td width="62" class="bodytext3"><?php echo $resanc7['maturity']; ?></td>
                       <td width="96" class="bodytext3"><?php echo $resanc7['fundalheight']; ?></td>
                       <td width="82" class="bodytext3"><?php echo $resanc7['presentation']; ?></td>
					    <td width="58" class="bodytext3"><?php echo $resanc7['lie']; ?></td>
						 <td width="105" class="bodytext3"><?php echo $resanc7['foetalheart']; ?></td>
						  <td width="62" class="bodytext3"><?php echo $resanc7['nextvist']; ?></td>
                     </tr>
					 <?php } ?>
					  <tr><td colspan="14" class="bodytext3"><strong>&nbsp;</strong></td></tr>
					 </table>
				</td>
				</tr>
	            <tr>
				<td colspan="3"   >
				 <table id="presid" width="831" border="0" cellspacing="1" cellpadding="1">
				    <tr><td colspan="5" class="bodytext3"><strong>Preventive Services</strong></td></tr>
					<tr bgcolor="#ecf0f5">
					 <td width="132" class="bodytext3">Services</td>
                       <td width="121" class="bodytext3">Date</td>
                       <td width="63" class="bodytext3">Visit</td>
                       <td width="502" class="bodytext3" bgcolor="#ecf0f5"></td>
                      
                     </tr>
					 <?php
					 $sno='';
					 $queryanc8 = "select * from ancprevser where patientcode = '$patientcode' and patientvisitcode = '$visitcode'";
					 $execanc8 = mysqli_query($GLOBALS["___mysqli_ston"], $queryanc8) or die ("Error in Queryanc8".mysqli_error($GLOBALS["___mysqli_ston"]));
					 while($resanc8 = mysqli_fetch_array($execanc8))
					 {
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
					 <tr <?php echo $colorcode ; ?>>
					 <td width="132" class="bodytext3"><?php echo $resanc8['services']; ?></td>
                       <td width="121" class="bodytext3"><?php echo $resanc8['date']; ?></td>
                       <td width="63" class="bodytext3"><?php echo $resanc8['visit']; ?></td>
                       <td bgcolor="#ecf0f5" width="502" class="bodytext3"></td>
                      
                     </tr>
					 <?php }?>
                     
					 </table>
				</td>
				</tr>
               <tr>
                 <td>&nbsp;</td>
               </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">User Name:
               <input type="hidden" name="user" id="user" size="5" style="border: 1px solid #001E6A" value="<?php echo $_SESSION['username']; ?>" readonly="readonly"><?php echo strtoupper($_SESSION['username']); ?></td>
               </tr>
			  
		  </table>
</td>
	</tr>
  </table>   

</form>
<?php include ("includes/footer1.php"); ?>

</body>
</html>