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

$curryear = date('Y');
$selectedyear =isset( $_REQUEST['year'])?$_REQUEST['year']:$curryear;

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if ($cbfrmflag1 == 'cbfrmflag1')
{
	$selectedmonth = $_REQUEST["month"];
	$selectedyear = $_REQUEST["year"];
}
?>
<script src="js/datetimepicker1_css.js"></script>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />

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
     <form name="cbform1" method="post" id="form1" action="moh705b.php">
    <table width="604" border="1" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>MOH 705b (above > 5) </strong></td>
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
                  <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Month</td>
                  <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                  	<select id="month" name="month">
                    <?php
						$montharray = array("01" => "January", "02" => "February", "03" => "March", "04" => "April","05" => "May", "06" => "June", "07" => "July", "08" => "August","09" => "September", "10" => "October", "11" => "November", "12" => "December");
						//print_r($montharray);
						foreach ($montharray as $key=>$month) 
						{
							?>
							<option  value="<?php echo $key; ?>" <?php if (($cbfrmflag1 == 'cbfrmflag1') && ($selectedmonth == $key)){ ?> selected <?php }?>> <?php echo $month;?></option>
                       <?php     
						}
					?>
                    </select>
                  </span></td>        
                  <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Year</td>
                  <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3"> 
                  <select id="year" name="year">
                 <?php
                    $startyear = date('Y',strtotime('-30 year'));
                    $curryear = date('Y');
                    for($startyear; $startyear <= $curryear; $startyear++) 
                    {
					?>
                    <!-- <option value="<?php echo $startyear; ?>" <?php if( $startyear ==  $curryear ) { ?> selected="selected" <?php } ?> ><?php echo $startyear; ?></option>-->
                     <option value="<?php echo $startyear; ?>" <?php if($startyear!=''){if($startyear == $selectedyear){echo "selected";}}?>><?php echo $startyear; ?></option>
                  <?php       
                    }               
                 ?>
                 </select>
                 </span></td>
			  </tr>
              <tr>
				<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td align="left" valign="top"  bgcolor="#FFFFFF" colspan="3"><span class="bodytext3">
                 <select name="location" id="location">
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
					$selectedmonth = $_REQUEST["month"];
					$selectedyear = $_REQUEST["year"];
					$daycount = cal_days_in_month(CAL_GREGORIAN,$selectedmonth,$selectedyear);
					
				if($location=='All'){
				$locationcodewise="locationcode like '%%'";
				}else{
				$locationcodewise="locationcode = '$location'";	
				}
			?>
      <tr>
      
        <td width="800">
        
        <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200" align="left" border="1">
          <tbody>		 
                <tr>
                	<td colspan="35" valign="center"  align="center" bgcolor="#ffffff"><strong>OVER 5 YEARS DAILY OUTPATIENT MORBIDITY SUMMARY SHEET</strong></td>
				</tr>
                 <tr>
                	<td colspan="35" valign="center"  align="center" bgcolor="#ffffff">&nbsp;</td>
				</tr>
                <tr bgcolor="#ffffff">
                    <td colspan="7" valign="center"  align="left"  class="bodytext31"><strong>DISTRICT : <?php echo strtoupper($res1location); ?></strong></td>
                    <td colspan="13" valign="center"  align="left"  class="bodytext31"><strong>FACILITY: <?= strtoupper($res1location) ?> </strong></td>
                    <td colspan="5" valign="center"  align="left"  class="bodytext31"><strong>MONTH: <?php echo strtoupper($selectedmonth); ?></strong></td>
                    <td colspan="5" valign="center"  align="left"  class="bodytext31"><strong>YEAR: <?php echo $selectedyear; ?></strong></td>	
                    <td colspan="5" valign="center"  align="left"  class="bodytext31"><strong>M.O.H.705B</strong></td>
                </tr>
                 <tr bgcolor="#ecf0f5">
                    <td colspan="" valign="center"  align="left"  class="bodytext31"></td>
                    <td colspan="34" valign="center"  align="left"  class="bodytext31"><strong>Days of The Month</strong></td>
                </tr>
                <tr bgcolor="#ffffff">
                    <td colspan="2" align="center" valign="center" class="bodytext31" width="5%"><strong>Diseases (New cases only)</strong></td>
                    <?php
						$no = 1;
						for($i=0; $i<$daycount; $i++)
						{
					?>	
                    	 <td align="center" valign="center" class="bodytext31" width="5%"><strong><?php echo $no; ?></strong></td>	
                         
					<?php
						$no++;		
						}
					?>
                    <td align="center" valign="center" class="bodytext31" width="5%"><strong>TOTAL</strong></td>
				</tr>
                   <?php
					
					//GET DISEASE NAMES FROM master_icd
					$sno=0;
					$colorloopcount = 0;
					$showcolor = 0;
					$totalvisits = 0;
					
					$old_array=array();
					
					$qrydiseases = "SELECT description FROM `master_icd` group by icdcode";					 
					$execdiseases = mysqli_query($GLOBALS["___mysqli_ston"], $qrydiseases) or die ("Error in qrydiseases".mysqli_error($GLOBALS["___mysqli_ston"]));
				   while($resdiseases = mysqli_fetch_array($execdiseases))
					{
						$rptname = trim($resdiseases["description"]);
                       	$rptname = addslashes($rptname);		
					 	if($rptname==''){
							continue;	
						}		
						 	
						if(in_array($rptname,$old_array)){
							continue;
						}
						else
						array_push($old_array,$rptname);


							$qryvisitcount01 = "SELECT ci.auto_number as anumber FROM consultation_icd as ci JOIN master_icd as mi on ci.primaryicdcode=mi.icdcode join master_customer mc on ci.patientcode = mc.customercode WHERE ci.primaryicdcode <> '' AND ci.consultationdate like '$selectedyear-$selectedmonth-__' AND mi.description ='$rptname' AND (mc.dateofbirth < ci.consultationdate - INTERVAL 5 YEAR) and ci.$locationcodewise";					 
							$execvisitcount01 = mysqli_query($GLOBALS["___mysqli_ston"], $qryvisitcount01) or die ("Error in qryvisitcount01".mysqli_error($GLOBALS["___mysqli_ston"]));
							if(mysqli_num_rows($execvisitcount01)==0)
								continue;

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
                    <td colspan="" valign="center"  align="left"  class="bodytext31"><?php echo $sno=$sno+1; ?></td>
                    <td width="80%" colspan="" valign="center"  align="left"  class="bodytext31"><?php echo strtoupper($rptname); ?></td>            
                  
                   <?php 

						$totalvisits = 0;
						for($dateval=1; $dateval<=$daycount; $dateval++)
						{
							if($dateval<10)
							{
								$dateval ="0".$dateval;
							}
							$visitdate = $selectedyear."-".$selectedmonth."-".$dateval;
							//GET VISIT COUNT ON EACH DATE FROM consultation_icd
							$dayvisitcount = 0;
				
							$qryvisitcount1 = "SELECT ci.auto_number as anumber FROM consultation_icd as ci JOIN master_icd as mi on ci.primaryicdcode=mi.icdcode join master_customer mc on ci.patientcode = mc.customercode WHERE ci.primaryicdcode <> '' AND ci.consultationdate = '$visitdate' AND mi.description ='$rptname'  AND (mc.dateofbirth < ci.consultationdate - INTERVAL 5 YEAR) and ci.$locationcodewise";					 
							$execvisitcount1 = mysqli_query($GLOBALS["___mysqli_ston"], $qryvisitcount1) or die ("Error in qryvisitcount1".mysqli_error($GLOBALS["___mysqli_ston"]));
							$dayvisitcount=mysqli_num_rows($execvisitcount1);
													
								if($dayvisitcount == "")
								{
									$dayvisitcount = 0;
								}
								
					?>	
                    	<td align="center" valign="center" class="bodytext31" width="5%"><?php echo $dayvisitcount; ?></td>
                 	<?php
							$totalvisits = $totalvisits + $dayvisitcount;
						} //CLOSE -- for($dateval=1; $dateval<=$daycount; $dateval++)
					?>	
                    <td colspan="" valign="center"  align="right"  class="bodytext31"><?php echo $totalvisits; ?></td>
                    </tr>

                 <?php 
					}
					//close -- while
				 ?>  
          </tbody>
        </table>
       
        </td>
         <td align="left" valign="top"><a target="_blank" href="print_moh705b.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&month=<?php echo $selectedmonth; ?>&&year=<?php echo $selectedyear; ?>"><img src="images/pdfdownload.jpg" width="30" height="30"></a>
            <a href="moh705b_xl.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&month=<?php echo $selectedmonth; ?>&&year=<?php echo $selectedyear; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>
      </tr>
     <?php 
				}//CLOSE -- if ($cbfrmflag1 == 'cbfrmflag1')
				?>  
    </table>
    </td>
    </tr>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

