<?php
//error_reporting(0);
error_reporting(~E_ALL);
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$lastid = "";
$columnname = "";
$altersql = "";
$searchflag1="";
$search1="";

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="pharmacyrates.xls"');
header('Cache-Control: max-age=80');
								
?>

</head>

<body>
<!--
<table width="101%" border="0" cellspacing="0" cellpadding="2">
	<tr>
		<td colspan="10">&nbsp;</td>
	</tr>
	<tr>
		<td width="1%">&nbsp;</td>
		<td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>&nbsp;</td>
		<td width="97%" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="860">-->
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
						<tr>
							<td>
								
								<form name="form2" id="form2" method="post" action="pharmacyrateupdate.php">
								
						
								<table width="1200" border="1" align="center" cellpadding="4" cellspacing="0" bordercolor="#333" id="AutoNumber3" style="border-collapse: collapse">
								<tbody>
								<?php 
									  //get colspan from rows
									  $query_rt0 = "SELECT templatename FROM pharma_rate_template WHERE recordstatus <> 'deleted' ORDER BY auto_number DESC";
									  $exec_rt0 = mysqli_query($GLOBALS["___mysqli_ston"], $query_rt0) or die ("Error in Query_rt".mysqli_error($GLOBALS["___mysqli_ston"]));
									  $num_rows = mysqli_num_rows($exec_rt0);
									  $colspan = 6 + ($num_rows * 2);
									?>
								
									<?php 
										$colorloopcount=0;
										$sno=0;
								    
								    // checkbox flag
                                    $templateautocode = 1;
                                    
                                    
									if ($templateautocode == '1'){
										
										//$sqlresult=mysql_query('SELECT DATABASE()');
										//$row=mysql_fetch_row($sqlresult);
										//$active_db=$row[0];
											//echo "Active Database :<b> $active_db</b> ";
											
										//$columnnames = 'subtype_'.$subtypeautocode;
										//$columnnames = '';
										//$sqlq= "SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '$active_db' AND TABLE_NAME = 'master_medicine' AND COLUMN_NAME = '$columnnames'";
										$sqlq= "SELECT * FROM master_medicine where status <> 'deleted' ORDER BY auto_number DESC";
										$querys = mysqli_query($GLOBALS["___mysqli_ston"], $sqlq);											
										$checkcolmncnt = mysqli_num_rows($querys);
										
											
											
										if($checkcolmncnt > '0'){
												
										

									 //error_reporting(0);
										$tbl_name="master_medicine";		//your table name
										// How many adjacent pages should be shown on each side?
										$adjacents = 0;
								
										
										  // First get total number of rows in data table. 
										  // If you have a WHERE clause in your query, make sure you mirror it here.
										
										$query111 = "select * from $tbl_name where type in ('drugs','medical items','sundries','lab reagents','Radiology Consumables','medical','other medical') and status <> 'deleted'";
										
										$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
										$res111 = mysqli_fetch_array($exec111);
										$total_pages = mysqli_num_rows($exec111);
													
										//$query = "SELECT * FROM $tbl_name";
										//	$total_pages = mysql_fetch_array(mysql_query($query));
										//	echo $numrow = mysql_num_rows($total_pages)
							
										
									
									?>
			
								<tr bgcolor="#fff">
							
									<td width="4%" bgcolor="#fff" class="bodytext3">
										<div align="center"><strong>S.No</strong></div>
									</td>
									<td width="10%" bgcolor="#fff" class="bodytext3">
										<strong>ID / Code </strong>
									</td>
									<td width="15%" bgcolor="#fff" class="bodytext3">
										<strong>Category</strong>
									</td>
									<td width="45%" bgcolor="#fff" class="bodytext3">
										<strong>Pharmacy Item</strong>
									</td>
									<td width="9%" align="right" bgcolor="#fff" class="bodytext3">
										<strong>Cost Price</strong>
									</td>
									<!-- rate templates headers -->
									<?php 
									  $query_rt = "SELECT templatename,markup FROM pharma_rate_template ORDER BY auto_number ASC";
									  $exec_rt = mysqli_query($GLOBALS["___mysqli_ston"], $query_rt) or die ("Error in Query_rt".mysqli_error($GLOBALS["___mysqli_ston"]));
										while ($res_rt = mysqli_fetch_array($exec_rt))
										{
											$col_rt = $res_rt['templatename'];
											$col_markup = $res_rt['markup'];
									?>
									<td width="9%" align="center" bgcolor="#fff" class="bodytext3">
										<strong>Markup</strong>
									</td>
									<td  align="center" width="20%" bgcolor="#fff" class="bodytext3">
										<strong> <?php echo ucfirst($col_rt);?> <?php //if($col_markup != '0'){echo '('.$col_markup.'%)'; }?></strong>  
									</td>
								    <?php } ?>
																		
								</tr>
								<?php

								$cnt ="0";
								//$query1 = "select * from master_medicine where status <> 'deleted' order by auto_number asc LIMIT $start, $limit";
								$query1 = "select * from master_medicine where status <> 'deleted' order by auto_number asc";
								$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
								while ($res1 = mysqli_fetch_array($exec1))
								{
									$cnt = $cnt+1;
									$itemcode = $res1["itemcode"];
									$itemname = $res1["itemname"];
									$categoryname = $res1["categoryname"];
									$auto_number = $res1["auto_number"];
									$rateperunit = $res1["subtype_".$subtypeautocode];
									$cost = $res1['purchaseprice'];
                                    
                                    /*$result = mysql_query("SELECT * FROM pharma_template_map WHERE templateid='$templateautocode' and productcode='$itemcode' ORDER BY auto_number DESC");

									$row = mysql_fetch_assoc($result);
									$rt = $row['rate'];
									if($rt ==''){
							    		$rate = '0.00';
							    	}else{
							    		//$rate = number_format($rt);
							    		$rate = number_format((float)$rt, 2, '.', '');
							    	}*/

									$colorloopcount = $colorloopcount + 1;
									$showcolor = ($colorloopcount & 1); 
									if ($showcolor == 0)
									{
										$colorcode = 'bgcolor="#fff"';
									}
									else
									{
										$colorcode = 'bgcolor="#fff"';
									}
		  
							?>
							<tr <?php echo $colorcode; ?>>
									
								<td align="left" valign="middle" class="bodytext3">
									<div align="center"><?php echo $cnt; ?></div>
								</td>
								<td align="left" valign="middle"  class="bodytext3"><?php echo $itemcode; ?> </td>
								<td align="left" valign="middle"  class="bodytext3"><?php echo $categoryname; ?> </td>
								<td align="left" valign="middle"  class="bodytext3"><?php echo $itemname; ?> </td>
								<td align="right" valign="middle"  class="bodytext3">
									<div style="text-align:right;">
									     <?php echo number_format($cost, 2, '.', ','); ?>
								    </div>
							    </td>
								<!-- pharmacy template rate-->
									<?php
									    // Get all templates
									    $query_rt1 = "SELECT auto_number,markup FROM pharma_rate_template ORDER BY auto_number ASC";
									    $exec_rt1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_rt1) or die ("Error in Query_rt".mysqli_error($GLOBALS["___mysqli_ston"]));
										while ($res_rt1 = mysqli_fetch_array($exec_rt1))
										{
											$tempid = $res_rt1['auto_number'];
											$rate = '0.00';
											$margin = $res_rt1['markup'];
						                ?>
						            <?php
									    // Get all pharmacy template mapping rates
									    $query_rm = "SELECT * FROM pharma_template_map WHERE templateid='$tempid' and productcode='$itemcode' ORDER BY auto_number DESC LIMIT 1";
										$exec_rm = mysqli_query($GLOBALS["___mysqli_ston"], $query_rm) or die("Error in Query_rm".mysqli_error($GLOBALS["___mysqli_ston"]));
										while($res_rm = mysqli_fetch_array($exec_rm)){
											$rm_rate = $res_rm['rate'];
											$rm_productcode = $res_rm['productcode'];
											$rm_templateid = $res_rm['templateid'];
											$item_margin = $res_rm['margin'];
											// rate
											if($rm_rate ==''){
												$rt = $rate;
											}else{
												//$rate = number_format((float)$rm_rate, 2, '.', '');
												$rate = number_format((float)$rm_rate, 2, '.', ',');
											}
									?>
								    <?php }  ?>
								    <td align="left" valign="middle" class="bodytext3">
									    <div align="center">
											<?php echo $item_margin.' %'; ?>
										</div>
									</td>
									<td align="left" valign="middle" class="bodytext3">
									    <div align="right">
											<?php echo $rate; ?>
										</div>
									</td>
								 <?php } ?>
								 <?php 
								       // get all pharma rate temp codes
								        $arr1 = array();
								        //query
								        $query_rt2 = "SELECT auto_number FROM pharma_rate_template ORDER BY auto_number ASC";
									    $exec_rt2 = mysqli_query($GLOBALS["___mysqli_ston"], $query_rt2) or die ("Error in Query_rt".mysqli_error($GLOBALS["___mysqli_ston"]));
										while ($res_rt2 = mysqli_fetch_assoc($exec_rt2))
										{   
											$tempid= $res_rt2['auto_number'];
											array_push($arr1, $tempid);
										}
										$tempids = json_encode($arr1);
										//echo $tempids;
								    ?>
																
							</tr>
							<?php
								} } }
								
										
							?>															
					
															
							</tbody>
						</table>
						</form>
							</td>
						</tr>
					</table>
					<!--</td>
				</tr>
			</table>

		</td>
	</tr>		
</table>-->

</body>
</html>

