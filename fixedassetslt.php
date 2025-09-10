<?php
session_start();
$pagename = '';
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION['username'])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$recorddate = date('Y-m-d');
$sessionusername = $_SESSION['username'];
$username = $_SESSION['username'];
$errmsg = '';
$bgcolorcode = '';
$colorloopcount = '';
$month = date('M-Y');
$sno = '';
$docno = $_SESSION['docno'];

$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$locationname = $res1["locationname"];
$locationcode = $res1["locationcode"];  


if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

if (isset($_REQUEST["assignmonth1"])) { $assignmonth1 = $_REQUEST["assignmonth1"]; } else { $assignmonth1 = 'Jan-2016'; }
if (isset($_REQUEST["assignmonth2"])) { $assignmonth2 = $_REQUEST["assignmonth2"]; } else { $assignmonth2 = date('M-Y'); }





$recorddate = date('Y-m-t',strtotime($recorddate));
	



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
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />

<script language="javascript">

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
</script>

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script src="js/datetimepicker1_css.js"></script>
<body> <!--onkeydown="escapekeypressed(event)"-->
<table width="117%" align="left" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy9hbGVydG1lc3NhZ2VzMS5waHAiKTsg')); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy90aXRsZTEucGhwIik7IA==')); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5">
	<?php eval(base64_decode('IA0KCQ0KCQlpbmNsdWRlICgiaW5jbHVkZXMvbWVudTEucGhwIik7IA0KCQ0KCS8vCWluY2x1ZGUgKCJpbmNsdWRlcy9tZW51Mi5waHAiKTsgDQoJDQoJ')); ?>	</td>
  </tr>
  <tr>
    <td height="25" colspan="10">&nbsp;</td>
  </tr>
<form name="form1" id="form1" method="post" action="fixedassetslt.php">
  <tr>
    <td valign="top">
	    <table width="500" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse; margin-left:20">
		 <tbody>
			<tr bgcolor="#FF9900">
				<td colspan="2" align="left" class="bodytext3"><strong>Assets Register</strong></td>
			</tr>
			<tr>
				<td width="" align="left" valign="top" class="bodytext3">
					<table width="100%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
						<thead>
							<tr>
								<td colspan="2" class="bodytext3" align="left" bgcolor="#ecf0f5"><strong>&nbsp;</strong></td>
							</tr>
							<tr>
								<td  align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><strong>Month From &nbsp;&nbsp;</strong>
                                    <input type="text" name="assignmonth1" id="assignmonth1" readonly value="<?php echo $assignmonth1; ?>" size="10">
                                    <img src="images2/cal.gif" onClick="javascript:NewCssCal('assignmonth1','MMMYYYY')" style="cursor:pointer"/>
                                </td>
                                <td  align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><strong>Month To &nbsp;&nbsp;</strong>
                                    <input type="text" name="assignmonth2" id="assignmonth2" readonly value="<?php echo $assignmonth2; ?>" size="10">
                                    <img src="images2/cal.gif" onClick="javascript:NewCssCal('assignmonth2','MMMYYYY')" style="cursor:pointer"/>
                                </td>
  							</tr>
                      <input type="hidden" name="hidassignmonth1" id="hidassignmonth1" value="<?php echo $assignmonth1; ?>"> 
                        	<input type="hidden" name="hidassignmonth1" id="hidassignmonth1" value="<?php echo $assignmonth1; ?>">
                            <tr>
                              	<td colspan="2" align="center" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
                                 	 <input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
                                    <input type="submit" name="frmsubmit" value="Submit">
                                </td>
                            </tr>
 						</thead>
					</table>
				</td>
			</tr>
          </tbody>
        </table>
     </td>
   </tr>
   <tr><td>&nbsp;</td></tr>     
</form>
	<?php 
	if($frmflag1 == 'frmflag1') 
	{ 
		$assignmonth1 = $_REQUEST["assignmonth1"];
		$assignmonth2 = $_REQUEST["assignmonth2"];
		
	?>
		<tr>
			<td align="left" valign="top" class="bodytext3">
				<table width="1522" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse; margin-left:20">
					<thead>
					<tr>
						<td colspan="40" class="bodytext3" align="left" bgcolor="#33CCCC"><strong>Asset List</strong></td>
					</tr>
					<tr bgcolor="#ecf0f5">
                        <td width="49" align="center" valign="middle" class="bodytext3"><strong>S.No</strong></td>
                        <td width="127" align="center" valign="middle" class="bodytext3"><strong>Posting Date</strong></td>
                        <td width="112" align="center" valign="middle" class="bodytext3"><strong>Document No</strong></td>
                        <td width="351" align="left" valign="middle" class="bodytext3"><strong>Description</strong></td>
                        <td width="267" align="right" valign="middle" class="bodytext3"><strong>Debit</strong></td>
                        <?php
						 //TO DISPLAY TOTAL AMOUNT FOR PREVIOUS YEAR OF SELECTED FROM YEAR
						 $prevyear = substr($assignmonth1,4)-1;
						?>
                        <td width="180" align="right" valign="middle" class="bodytext3"><strong>NBV <?php echo $prevyear;?></strong></td>
                    	  <?php 
						 //DISPLAY BETWEEN YEARS IN FROM YEAR TO TO YEAR
						$frommonth = substr($assignmonth1,0,3);
						$fromyear = substr($assignmonth1,4);
						$tomonth  = substr($assignmonth2,0,3);
						$toyear = substr($assignmonth2,4);
						
						//GET PREVIOUS MONTH AND YEAR -- for NBV CALCULATION
						/*if($frommonth == 'Jan')
						{*/
							$prevyear = $fromyear - 1;
						/*}
						else
						{
							$prevyear = $fromyear;
						}
						*/
						
						$months = array(1=>"Jan",2=>"Feb",3=>"Mar",4=>"Apr",5=>"May",6=>"Jun",7=>"Jul",8=>"Aug",9=>"Sep",10=>"Oct",11=>"Nov",12=>"Dec");
						/*foreach($months as $keys=>$monthname)
						{
							
						}*/
						$flg1=0;
						for($year=$fromyear;$year<=$toyear;$year++)
						{
							if($year==$fromyear && $flg1==0)
								{
									$monthname = $frommonth;
									$keys = array_search($frommonth, $months);
									
									
									//DISPLAY FOR START YEAR MONTHS
									for($monthno=$keys;$monthno<=12;$monthno++)
									{
										$monthname = $months[$monthno];
										?>
                                          <td width="129" align="right" valign="middle" class="bodytext3"><strong><?php echo $monthname."-".$year;?></strong></td>
                                        <?php
									}
									$flg1++;
								} //if close
								else
								{
									foreach($months as $keys=>$monthname)
									{
										
								?>
								 <td width="112" align="right" valign="middle" class="bodytext3"><strong><?php echo $monthname."-".$year;?></strong></td>
								<?php
										if($year==$toyear && $monthname == $tomonth)
										{
											break;
										}	
									}
								}//else close
									?>
                             <td width="123" align="right" valign="middle" class="bodytext3"><strong>NBV <?php echo $year;?></strong></td>
                            <?php
						}
						?>
					</tr>
							<?php
                            $yearflag = 0;
							$nbvprevassettotamount = 0;
							$nbvcurrassettotamount = 0;
			
			 					//DISPLAY THOSE (Ist 4 Columns) FROM assetpurchase_details AND master_fixedassets TABLES
								
							  //GET THE VALUES FROM assetpurchase_details
							// $qryprchassetsdeprec = "SELECT ap.auto_number,ap.entrydate,ap.assetcode,ap.itemname,ap.totalamount FROM assetpurchase_details ap,depreciation_information di WHERE ap.itemname=di.itemname AND ap.auto_number=di.id AND di.asset_type='purchase' AND ap.recordstatus<>'deleted'";
							 
							  $qryprchassetsdeprec = "SELECT auto_number,entrydate,assetledgercode,itemname,totalamount,asset_id FROM assets_register WHERE recordstatus<>'deleted'";
							 $execprchassetsdeprec = mysqli_query($GLOBALS["___mysqli_ston"], $qryprchassetsdeprec) or die ("Error in qryprchassetsdeprec".mysqli_error($GLOBALS["___mysqli_ston"]));
							
							 while($resprchassetsdeprec = mysqli_fetch_array($execprchassetsdeprec))
							 {
								 $prchassetanum = $resprchassetsdeprec["auto_number"];
								 $prchassetpostdate = $resprchassetsdeprec["entrydate"];
								 $prchassetdocno = $resprchassetsdeprec["asset_id"];
								 $prchassetdesc = $resprchassetsdeprec["itemname"];
								 $prchassetdebit = $resprchassetsdeprec["totalamount"];
								 $nbvcurrassettotamount = 0;
								 
								 //GET PUCHASE ASSETS - NBV  - PREVIOUS YEAR OF SELECTED FROM YEAR
								  $qrynbvprevyear = "SELECT SUM(depreciation) AS nbvprevyearassets FROM assets_depreciation WHERE itemname='$prchassetdesc' AND YEAR(processmonth)='$prevyear' AND recordstatus<>'deleted'";
								  $execnbvprevyear = mysqli_query($GLOBALS["___mysqli_ston"], $qrynbvprevyear) or die ("Error in qrynbvprevyear".mysqli_error($GLOBALS["___mysqli_ston"]));
							      $resnbvprevyear = mysqli_fetch_assoc($execnbvprevyear);
								  $nbvprevyrprchassets = $resnbvprevyear["nbvprevyearassets"];

								 //ENDS NBV
								 
								  $sno = $sno + 1;
								  $colorloopcount = $colorloopcount + 1;
								  $showcolor = ($colorloopcount & 1); 
								  if ($showcolor == 0)
								  {
									  $colorcode = 'bgcolor="#CBDBFA"';
								  }
								  else
								  {
									  $colorcode = 'bgcolor="#ecf0f5"';
								  }
								  
						?>
                              <tr <?php echo $colorcode; ?>>
                                  <td align="center" valign="middle" class="bodytext3"><?php echo $sno; ?></td>
                                  <td align="center" valign="middle" class="bodytext3"><?php echo $prchassetpostdate;?></td>
                                  <td align="center" valign="middle" class="bodytext3"><?php echo $prchassetdocno;?></td>
                                  <td align="left" valign="middle" class="bodytext3"><?php echo $prchassetdesc;?></td>
                                  <td align="right" valign="middle" class="bodytext3"><?php echo number_format($prchassetdebit,2);?></td>
                                  <td align="right" valign="middle" class="bodytext3"><strong><?php echo number_format($nbvprevyrprchassets,2,'.',',');?></strong></td>
                                  <?php
								    $flg1=0;
									$nbvprchtot_monthwise = 0;
									for($year=$fromyear;$year<=$toyear;$year++)
									{
										if($year==$fromyear && $flg1==0)
											{
												$monthname = $frommonth;
												$keys = array_search($frommonth, $months);
												
												//DISPLAY FOR START YEAR MONTHS
												for($monthno=$keys;$monthno<=12;$monthno++)
												{
													$monthname = $months[$monthno];
													$startmonthyear = $monthname."-".$year;
													
													//GET PURCHASE ASSETS ON MONTHWISE FOR STARTING SELECTED MONTH & YEAR
													 //DISPLAY DATA FROM depreciation_information FOR MONTHWISE
													 //GET PURCHASE ASSETS DATA
												$qryprchamount = "SELECT count(depreciation) as count,depreciation FROM assets_depreciation WHERE itemname='$prchassetdesc' AND processmonth='$startmonthyear' AND recordstatus<>'deleted'";
													 $execprchamount = mysqli_query($GLOBALS["___mysqli_ston"], $qryprchamount) or die ("Error in qryprchamount".mysqli_error($GLOBALS["___mysqli_ston"]));
													// echo "<br>exist cnt: ".$prchrowexist = mysql_num_rows($execprchamount);
													 while($resprchamount = mysqli_fetch_array($execprchamount))
													 {
														$rowcount = $resprchamount["count"];
														$prchamount = $resprchamount["depreciation"];
														
														$nbvcurrassettotamount = $nbvcurrassettotamount + $prchamount;
														
														//NBV TOTAL ON MONTH BASE --for prchase assets
														$nbvprchtot_monthwise = $nbvprchtot_monthwise + $prchamount; 
														
														if($prchamount == "" && $rowcount == 0)
														{
															$prchamount = 0;
														}
													?>
                                                    
													  <td align="right" valign="middle" class="bodytext3"><?php echo  number_format($prchamount,2,'.',',')?></td>
													<?php
													 }//CLOSE--WHILE
												}
												$flg1++;
											} //if close
											else
											{
												foreach($months as $keys=>$monthname)
												{
													$monthyear = $monthname."-".$year;
													//GET PURCHASE ASSETS ON MONTHWISE FOR STARTING SELECTED MONTH & YEAR
													 //DISPLAY DATA FROM depreciation_information FOR MONTHWISE
													 //GET PURCHASE ASSETS DATA
												$qryprchamount = "SELECT count(depreciation) as count,depreciation FROM assets_depreciation WHERE itemname='$prchassetdesc' AND processmonth='$monthyear' AND recordstatus<>'deleted'";
													 $execprchamount = mysqli_query($GLOBALS["___mysqli_ston"], $qryprchamount) or die ("Error in qryprchamount".mysqli_error($GLOBALS["___mysqli_ston"]));
													// echo "<br>exist cnt: ".$prchrowexist = mysql_num_rows($execprchamount);
													 while($resprchamount = mysqli_fetch_array($execprchamount))
													 {
														$rowcount = $resprchamount["count"];
														$prchamount = $resprchamount["depreciation"];
														
														$nbvcurrassettotamount = $nbvcurrassettotamount + $prchamount;
														
														if($prchamount == "" && $rowcount == 0)
														{
															$prchamount = 0;
														}
													?>
                                                    
													  <td align="right" valign="middle" class="bodytext3"><?php echo  number_format($prchamount,2,'.',',')?></td>
													<?php
													 }//CLOSE--WHILE
										    		if($year==$toyear && $monthname == $tomonth)
													{
														break;
													}	
												} //foreach close
											}//else close
											
											$finalnbv = $prchassetdebit - $nbvcurrassettotamount;
												?>
										 <td align="right" valign="middle" class="bodytext3"><strong><?php echo number_format($finalnbv,2); ?></strong></td>
										<?php
									}
									?>
							  </tr>  
                       <?php       
							 }//WHILE--CLOSE
					   ?>
                       
				  <input type="hidden" name="maxno" id="maxno" value="<?php echo $sno; ?>">
				</thead>
			  </table>
			</td>
		</tr>
        <?php
	}//	if($frmflag1 == 'frmflag1') 
	?>
</table>

<?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy9mb290ZXIxLnBocCIpOyA=')); ?>
</body>
</html>

