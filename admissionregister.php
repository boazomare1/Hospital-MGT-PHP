<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");//echo $menu_id;include ("includes/check_user_access.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
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
$admissiondate = "";
$ipnumber = "";
$patientname = "";
$gender = "";
$admissiondoc = "";
$consultingdoc = "";
$companyname = "";
$bedno = "";
$dischargedate = "";
$wardcode = "";
$locationcode = "";

//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_customer2.php");


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
<style type="text/css">.bodytext31:hover { font-size:14px; }
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
		
		
              <form name="cbform1" method="post" action="admissionregister.php">
		<table width="634" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Admission Register</strong></td>
             </tr>
             <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
              <select name="locationcode">
                <?php
                  $query20 = "select * FROM master_location";
                  $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20". mysqli_error($GLOBALS["___mysqli_ston"]));
                  while ($res20 = mysqli_fetch_array($exec20)){
                    echo "<option value=".$res20['locationcode'].">" .$res20['locationname']. "</option>";
                  }
                ?>
                </select></td>
           </tr>
           	<tr>
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1286" 
            align="left" border="0">
          <tbody>
  
			<?php
        if($wardcode == '0'){
        ?>
        <tr>
          <td class="bodytext31" valign="center"  align="left" colspan="2"> 
           <!-- <a target="_blank" href="print_admissionregister.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&wardcode=<?php echo $wardcode; ?>"><img src="images/pdfdownload.jpg" width="30" height="30"></a> -->
           <a href="print_admissionregisterxls.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&wardcode=<?php echo $wardcode; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a>
          </td>
        </tr>
        <?php
          $query24 = "select * from master_ward";
          $exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
          while ($res24 = mysqli_fetch_array($exec24)){
            $wardautonumber = $res24['auto_number'];
            ?>
            <tr>
            <td colspan="2" bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311"><strong><?php echo $res24['ward']; ?></strong></span></td>
            <td colspan="6" bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311">
            </td>
            <td colspan="4" bgcolor="#ecf0f5" class="bodytext31" valign="center" align="right"><span class="bodytext311"><strong>
              <?php
                $query451 = "select * from `master_location`";
                $exec451 = mysqli_query($GLOBALS["___mysqli_ston"], $query451) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                $row2 = array();
                while ($row2[] = mysqli_fetch_assoc($exec451)){
                  $locationcode = $row2[0]['auto_number'];
                  echo "Location: " . $row2[0]['locationname'];
                }
              ?> </strong></span>
            </td> 
          </tr>
          <tr>
          <td width="2%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sno.</strong></div></td>
            <td width="8%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Admission Date</strong></div></td>
          <td width="6%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Ip Visit</strong></div></td>						<td width="6%" align="left" valign="center"                  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Type</strong></div></td>
          <td width="15%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name</strong></div></td>
          <td width="6%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Gender</strong></div></td>
          <td width="6%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><strong>Age</strong></td>
          <td width="15%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><strong>Admitting Doctor</strong></td>
          <td width="15%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Consulting Doctor</strong></div></td>
          <td width="15%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Company Name</strong></div></td>
          <td width="6%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bed No</strong></div></td>
          <td width="6%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Discharge Date</strong></div></td> 
        </tr>
          
        <?php
          
          $query1 = "select * from ip_bedallocation where ward = '$wardautonumber' and (recorddate between '$ADate1' and '$ADate2')";
          $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
          $nums1 = mysqli_num_rows($exec1);

          while ($res1 = mysqli_fetch_array($exec1)){
              $admissiondate = $res1['recorddate'];
              $ipnumber = $res1['visitcode'];
              $patientname = $res1['patientname'];
              $patientcode = $res1['patientcode'];
              $visitcode = $res1['visitcode'];
              $companyname = $res1['accountname'];
              $res2bed = $res1['bed'];

              $query11 = "select * from master_ipvisitentry where patientcode = '$patientcode' and visitcode = '$visitcode'";
              $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11". mysqli_error($GLOBALS["___mysqli_ston"]));
              $res11 = mysqli_fetch_array($exec11);

              $gender = $res11['gender'];
              $age = $res11['age'];
              $admissiondoc = $res11['opadmissiondoctor'];
              $consultingdoc = $res11['consultingdoctorName'];
              $type = $res11['type'];
              $query111 = "select * from master_bed where auto_number = '$res2bed'";
              $exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111". mysqli_error($GLOBALS["___mysqli_ston"]));
              $res111 = mysqli_fetch_array($exec111);

              $bedno = $res111['bed'];

              $query112 = "select * from ip_discharge where patientcode = '$patientcode' and visitcode = '$visitcode' and req_status = 'discharge'";
              $exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112". mysqli_error($GLOBALS["___mysqli_ston"]));
              $res112 = mysqli_fetch_array($exec112);

              $dischargedate = $res112['recorddate'];

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
          ?>
               <tr <?php echo $colorcode; ?>>
                  <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
                  <td class="bodytext31" valign="center"  align="left"><?php echo $admissiondate; ?></td>
             <td  align="left" valign="center" class="bodytext31"><div align="left"><a target="_blank" href="ipemrview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $ipnumber; ?>"><?php echo $ipnumber; ?></a></div></td>			 			 <td class="bodytext31" valign="center"  align="left">                    <div class="bodytext31"><?php echo strtoupper($type); ?></div></td>
                   <td class="bodytext31" valign="center"  align="left">
                    <div class="bodytext31"><?php echo strtoupper($patientname); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left">
                    <div class="bodytext31"><?php echo strtoupper($gender); ?></div></td>
            <td class="bodytext31" valign="center"  align="left">
                    <div class="bodytext31"><?php echo $age ." YEARS";?></div></td>
                  <td class="bodytext31" valign="center"  align="left">
              <div align="left"><?php $rate = explode(".", $admissiondoc); foreach($rate as $item){ echo ( strtoupper($item)." "); } ?></div></td>
                   <td class="bodytext31" valign="center"  align="left">
              <div align="left"><?php echo strtoupper($consultingdoc); ?></div></td>
            <td class="bodytext31" valign="center"  align="left">
              <div align="left"><?php echo strtoupper($companyname); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left">
            <div align="left"><?php echo $bedno; ?></div></td>
                  <td class="bodytext31" valign="center"  align="left">
            <div align="left"><?php echo $dischargedate; ?></div></td>
          </tr>

          <?php
          }
          }
          } else {

            $query23 = "select * from master_ward where auto_number = '$wardcode'";
                  $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                  while ($res23 = mysqli_fetch_array($exec23)){
                    ?>
              <tr>
                <td class="bodytext31" valign="center"  align="left" colspan="2"> 
                 <!-- <a target="_blank" href="print_admissionregister.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&wardcode=<?php echo $wardcode; ?>"><img src="images/pdfdownload.jpg" width="30" height="30"></a> -->
                <a href="print_admissionregisterxls.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&wardcode=<?php echo $wardcode; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a>
                </td>
              </tr>
              <tr>
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311"><strong><?php echo $res23['ward']; ?></strong></span></td>
              <td colspan="6" bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311">&nbsp;</td>
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext31" valign="center" align="right"><span class="bodytext311"><strong>
                <?php
                  $query451 = "select * from `master_location`";
                  $exec451 = mysqli_query($GLOBALS["___mysqli_ston"], $query451) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                  $row2 = array();
                  while ($row2[] = mysqli_fetch_assoc($exec451)){
                    $locationcode = $row2[0]['auto_number'];
                    echo "Location: " . $row2[0]['locationname'];
                  }
                ?> </strong></span>
              </td>
            </tr>
            <tr>
              <td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sno.</strong></div></td>
              <td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Admission Date</strong></div></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Ip Visit</strong></div></td>				 <td width="6%" align="left" valign="center"                  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Type</strong></div></td>
              <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name</strong></div></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Gender</strong></div></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Age</strong></td>
              <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Admitting Doctor</strong></td>
              <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Consulting Doctor</strong></div></td>
              <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Company Name</strong></div></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bed No</strong></div></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Discharge Date</strong></div></td> 
            </tr>
            

        <?php
          $query2 = "select * from ip_bedallocation where ward = '$wardcode' AND (recorddate between '$ADate1' and '$ADate2')";
          $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
          $nums = mysqli_num_rows($exec2);
          while ($res2 = mysqli_fetch_array($exec2))
          {
              $admissiondate = $res2['recorddate'];
              $ipnumber= $res2['visitcode'];
              $patientname = $res2['patientname'];
              $patientcode = $res2['patientcode'];
              $visitcode = $res2['visitcode'];
              $companyname = $res2['accountname'];
              $res2bed = $res2['bed'];
          
              $query3 = "select * from master_ipvisitentry where patientcode = '$patientcode' and visitcode = '$visitcode'";
              $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3". mysqli_error($GLOBALS["___mysqli_ston"]));
              $res3= mysqli_fetch_array($exec3);
              
              $gender = $res3['gender'];
              $age = $res3['age'];
              $admissiondoc = $res3['opadmissiondoctor'];
              $consultingdoc = $res3['consultingdoctorName'];			  			                $type = $res3['type'];

              $query4 = "select * from master_bed where auto_number = '$res2bed'";
              $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4". mysqli_error($GLOBALS["___mysqli_ston"]));
              $res4 = mysqli_fetch_array($exec4);

              $bedno = $res4['bed'];

              $query5 = "select * from ip_discharge where patientcode = '$patientcode' and visitcode = '$visitcode' and req_status = 'discharge'";
              $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5". mysqli_error($GLOBALS["___mysqli_ston"]));
              $res5 = mysqli_fetch_array($exec5);

              $dischargedate = $res5['recorddate'];

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
			?>
           <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $admissiondate; ?></td>
			   <td  align="left" valign="center" class="bodytext31"><div align="left"><a target="_blank" href="ipemrview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $ipnumber; ?>"><?php echo $ipnumber; ?></a></div></td>			   			   <td class="bodytext31" valign="center"  align="left">                    <div class="bodytext31"><?php echo strtoupper($type); ?></div></td>
               <td class="bodytext31" valign="center"  align="left">			   
                <div class="bodytext31"><?php echo strtoupper($patientname); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo strtoupper($gender); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $age ." YEARS";?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php $rate = explode(".", $admissiondoc); foreach($rate as $item){ echo strtoupper($item)." "; } ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo strtoupper($consultingdoc); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo strtoupper($companyname); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="left"><?php echo $bedno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
        <div align="left"><?php echo $dischargedate; ?></div></td>
      </tr>
      <?php 
      }
			}
    }
		?>
          <tr>
            <td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
            <td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
            <td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
            <td class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5"><strong></strong></td>
            <td class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5"><strong></strong></td>
            <td class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5"><strong></strong></td>
            <td class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5"><strong></strong></td>
            <td class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5"><strong></strong></td>
            <td  align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong></strong></td>
            <td  align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong></strong></td>
            <td  align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong></strong></td>             <td  align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong></strong></td>
          </tr>
          </tbody>
        </table></td>
      </tr>
	  
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
