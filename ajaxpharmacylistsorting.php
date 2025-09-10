<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$docno = $_SESSION['docno'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');


if(isset($_REQUEST['search1'])){$search1 = $_REQUEST['search1'];}else{$search1='';}
if (isset($_REQUEST["sortfunc"])) { $sortfunc = $_REQUEST["sortfunc"]; } else { $sortfunc = ""; }
if (isset($_REQUEST["orderby"])) { $orderby = $_REQUEST["orderby"]; } else { $orderby = ""; }
if (isset($_REQUEST["start"])) {  $start = $_REQUEST["start"]; } else { $start = ""; }
if (isset($_REQUEST["limit"])) {  $limit = $_REQUEST["limit"]; } else { $limit = ""; }

$colorloopcount = 0;
if($start == '' || $limit  == ''){
	
	$limitcondition = '';
}
else{
	
	 $limitcondition = "LIMIT $start, $limit";
}
$query1 = "select * from master_medicine where   (itemname like '%$search1%' or categoryname = '$search1') and  status <> 'deleted' order by $orderby $sortfunc ";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$itemcode = $res1["itemcode"];
		$itemname = $res1["itemname"];
		$categoryname = $res1["categoryname"];
		$purchaseprice = $res1["purchaseprice"];
		$rateperunit = $res1["rateperunit"];
		$expiryperiod = $res1["expiryperiod"];
		$auto_number = $res1["auto_number"];
		$itemname_abbreviation = $res1["packagename"];
		$taxname = $res1["taxname"];
		$manufacturername = $res1["manufacturername"];
		$formula = $res1['formula'];
		$genericname = $res1["genericname"];
		$minimumstock = $res1["minimumstock"];
		$maximumstock = $res1["maximumstock"];
		$rol = $res1["rol"];
		$roq = $res1["roq"];
		$type = $res1["type"];
		$ipmarkup = $res1["ipmarkup"];
		$spmarkup = $res1["spmarkup"];
		$disease = $res1["disease"];
		
		$taxanum = $res1["taxanum"];
		if ($expiryperiod != '0') 
		{ 
			$expiryperiod = $expiryperiod.' Months'; 
		}
		else
		{
			$expiryperiod = ''; 
		}
	 /*?>	
		$query6 = "select * from master_tax where auto_number = '$taxanum'";
		$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		$res6 = mysql_fetch_array($exec6);
		$res6taxpercent = $res6["taxpercent"];<?php */
		
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
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="center"><a href="pharmacyitem1.php?st=del&&anum=<?php echo $auto_number; ?>"><img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
                        <td align="left" valign="top"  class="bodytext3"><a href="editpharmacyitem.php?itemcode=<?php echo $itemcode; ?>">Edit</a></td>
					    <td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname_abbreviation; ?> <div align="right"></div></td>
                        <td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rateperunit; ?></div></td>
                        <td align="left" valign="top"  class="bodytext3">    <?php echo $formula; ?>                  </td>
						<td align="left" valign="top"  class="bodytext3">    <?php echo $taxname; ?>                  </td>
						<td align="left" valign="top"  class="bodytext3">  <div align="right">  <?php echo $purchaseprice; ?>    </div>              </td>
						<td align="left" valign="top"  class="bodytext3">    <?php echo $disease; ?>                  </td>  
						<td align="left" valign="top"  class="bodytext3">    <?php echo $genericname; ?>                  </td> 
                        <td align="left" valign="top"  class="bodytext3">    <?php echo $type; ?>                  </td>   
						<td align="left" valign="top"  class="bodytext3">   <div align="center"> <?php echo $minimumstock; ?>   </div>               </td>
						<td align="left" valign="top"  class="bodytext3">  <div align="center">  <?php echo $maximumstock; ?>     </div>             </td>
						<td align="left" valign="top"  class="bodytext3">   <div align="center"> <?php echo $rol; ?>  </div>                </td>
						<td align="left" valign="top"  class="bodytext3">  <div align="center">  <?php echo $roq; ?> </div>                </td>
						<td align="left" valign="top"  class="bodytext3">    <div align="right"><?php echo $ipmarkup; ?>    </div></td>
						<td align="left" valign="top"  class="bodytext3">    <div align="right"><?php echo $spmarkup; ?>   </div></td>  </tr>
		<?php } ?>