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


$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d'); 

$location =isset( $_REQUEST['location'])?$_REQUEST['location']:'';
$ADate1=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:$transactiondatefrom;
$ADate2=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:$transactiondateto;
$colorloopcount=''; 
$sno='';
?>

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/datetimepicker_css.js"></script>
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
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>


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
  <td width="1%">&nbsp;</td>
    <td colspan="8">
    <form name="cbform1" method="post" id="form1" action="morbidityip.php">
    <table width="604" border="1" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>MORBIDITY -IP </strong></td>
			   <td colspan="4" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
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
			  <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">From Date</td>
              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input name="ADate1" id="ADate1" value="<?php echo $ADate1; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			  <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/></span></td>        
              <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">To Date</td>
              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3"> 
              <input name="ADate2" id="ADate2" value="<?php echo $ADate2; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			  <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/></span></td>
			  </tr>
              <tr>
				<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td align="left" valign="top"  bgcolor="#FFFFFF" colspan="3"><span class="bodytext3">
                 <select name="location" id="location" onChange=" funcSubTypeChange1(); ajaxlocationfunction(this.value);">
				  <option value="All">All</option>
		   <?php 
	   	  $query = "select * from master_location order by locationname"; 
           $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
           while($res = mysqli_fetch_array($exec))
			{
	 		$locationname  = $res["locationname"]; 
	 		$locationcode = $res["locationcode"];
     		$reslocationanum = $res["auto_number"];
			?>
			<option value="<?php echo $locationcode; ?>" <?php if($location!=''){if($location == $locationcode){echo "selected";}}?>><?php echo $locationname; ?></option>
			<?php
			}
			?>
		   </select></span></td>        
			  </tr>
			  <tr>
              <td width="20%"  colspan="6" valign="top" align="center"  bgcolor="#ecf0f5"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" onClick="return funcvalidcheck();"/>
            </td>
            </tr>
			    
             </tbody>
        </table>
        </form></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
       <?php 
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					?>
      <tr>
      
        <td width="800">
        
        <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="1">
          <tbody>		 
                 <tr>
                <td colspan="4" valign="center"  align="center" bgcolor="#ffffff"><strong><?= strtoupper($res1location); ?></strong></td>
				</tr>
                 <tr>
                <td colspan="2" valign="center"  align="left" bgcolor="#ecf0f5" class="bodytext31">Diagnosis [Morbidity]:IP</td>
                <td colspan="2" valign="center"  align="left" bgcolor="#ecf0f5" class="bodytext31">Printed On : <?php echo date('d-m-Y'); ?></td>
				</tr>
                 <tr>
                <td colspan="4" valign="center"  align="left" bgcolor="#ffffff" class="bodytext31"><strong>Period : &nbsp;&nbsp;From &nbsp; <?php echo $ADate1; ?>&nbsp;&nbsp;&nbsp; To &nbsp;<?php echo $ADate2; ?></strong></td>
				</tr>
                <tr>
                <td align="center" valign="center" bgcolor="#ffffff" class="bodytext31" width="5%"><strong>RANK</strong></td>
				<td align="center" valign="center" bgcolor="#ffffff" class="bodytext31" width="76%"><strong>DISEASE</strong></td>
				<td align="center" valign="center" bgcolor="#ffffff" class="bodytext31" width="11%"><strong>NO OF CASES</strong></td>
                <td align="center" valign="center" bgcolor="#ffffff" class="bodytext31" width="8%"><strong>% TOTAL</strong></td>
				</tr>
                <?php 
				//echo $query1 = "select description,icdcode from master_icd where recorddate between '$ADate1' and '$ADate2' and locationcode='$location' limit 0,50";
                //$query1 = "select description,icdcode from master_icd where description <>''";
				//$exec1 = mysql_query($query1) or die(mysql_error());
				//while($res1 = mysql_fetch_array($exec1)){
				//$description = $res1['description'];
				//$icdcode = $res1['icdcode'];
				
				if($location=='All'){
					$locationcodewise="and locationcode like '%%'";
					}else{
					$locationcodewise="and locationcode = '$location'";	
					}
				
				$totalcases=1;
				
				 
				$query02 = "SELECT count(primaryicdcode) as countprimaryicdcode FROM discharge_icd WHERE  dischargedate between '$ADate1' and '$ADate2' $locationcodewise ";

				$exec02 = mysqli_query($GLOBALS["___mysqli_ston"], $query02) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				if($res02 = mysqli_fetch_array($exec02)){
					 $totalcases = $res02['countprimaryicdcode'];
				}
				$data=array();
				$noofcases=array();
				$query2 = "select primaryicdcode,count(primaryicdcode) as countprimaryicdcode from discharge_icd where dischargedate between '$ADate1' and '$ADate2' $locationcodewise  group by primaryicdcode";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res2 = mysqli_fetch_array($exec2)){
				$nocases='';
				$nocases=$res2['countprimaryicdcode'];
				$primaryicdcode=$res2['primaryicdcode'];
                $query1 = "select description,icdcode from master_icd where icdcode='$primaryicdcode'";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res1 = mysqli_fetch_array($exec1);
				$description = $res1['description'];
				$icdcode = $res1['icdcode'];
									
					if($nocases>0){
					
									$data[] = array('name' => $description, 'noofcases' => $nocases,'total' => number_format (round(($nocases/$totalcases)*100,2),2,'.','')) ;
					}
					
					}
					

				foreach ($data as $key => $row) {
					$name[$key]  = $row['name'];
					$noofcases[$key] = $row['noofcases'];
					$total[$key] = $row['total'];
				}
				
				array_multisort($noofcases, SORT_DESC, $data);
				
				foreach ($data as $key => $row) {
						$sno=$sno+1;
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
                <td align="center" valign="center" class="bodytext31"><?php echo $sno; ?></td>
				<td align="left" valign="center" class="bodytext31"><?php echo $row['name']; ?></td>
				<td align="center" valign="center" class="bodytext31"><?php echo $row['noofcases']; ?></td>
                <td align="right" valign="center" class="bodytext31"><?= $row['total']; ?></td>
				</tr>
                <?php 
				}
//				}
				?>
          </tbody>
        </table>
       
        </td>
         <td align="left" valign="top"><a target="_blank" href="print_morbidityip.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>"><img src="images/pdfdownload.jpg" width="30" height="30"></a>
            <a href="morbidityip_xl.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>
      </tr>
       <?php 
				}
		?>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

