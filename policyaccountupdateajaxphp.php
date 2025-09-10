<?php
session_start();
include ("db/db_connect.php");
$recorddate = date('Y-m-d');
$recordtime = date('H:i:s');
$updatetime = date('Y-m-d H:i:s');
$user = $_SESSION['username'];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$action = $_REQUEST['action'];
$serialno = $_REQUEST['serialno'];
$textid = $_REQUEST['textid'];
$sortfunc = $_REQUEST['sortfunc'];



$colorloopcount='0';
if($action == 'scrollcoafunction')
{
	 $query1 = "select * from master_accountname where recordstatus <> 'deleted' order by accountssub limit $serialno , 50";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$auto_number = $res1['auto_number'];
		$accountname = $res1["accountname"];
		$auto_number = $res1["auto_number"];
		$paymenttypeanum = $res1['paymenttype'];
		$subtypeanum = $res1['subtype'];
		$expirydate = $res1['expirydate'];
		$accountsmain = $res1['accountsmain'];
		$accountssub = $res1['accountssub'];
		
		$cost_center = $res1['cost_center'];
		$id = $res1['id'];
		
		$query612 = "select * from master_costcenter where auto_number = '$cost_center' and recordstatus <> 'deleted'";
		$exec612 = mysqli_query($GLOBALS["___mysqli_ston"], $query612) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res612 = mysqli_fetch_array($exec612);
		$res612name = $res612['name'];
		$query6 = "select * from master_accountsmain where auto_number = '$accountsmain' and recordstatus <> 'deleted'";
		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res6 = mysqli_fetch_array($exec6);
		$maincode = $res6['id'];
		$accountsmainname = $res6['accountsmain'];
		
		$query8 = "select * from master_accountssub where auto_number = '$accountssub' and recordstatus <> 'deleted'";
		$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res8 = mysqli_fetch_array($exec8);
		$subcode = $res8['id'];
		$accountssubname = $res8['accountssub'];
		
		//$defaultstatus = $res1["defaultstatus"];
		
		$query2 = "select * from master_paymenttype where auto_number = '$paymenttypeanum'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$paymenttype = $res2['paymenttype'];
		
		$query3 = "select * from master_subtype where auto_number = '$subtypeanum'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res3 = mysqli_fetch_array($exec3);
		$subtype = $res3['subtype'];
	
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
                        <td width="4%" align="left" valign="top"  class="bodytext3">
						<div align="center">
						<a href="addaccountname1.php?st=del&&anum=<?php echo $auto_number; ?>" onClick="return funcDeleteAccountName1('<?php echo $accountname;?>')">
						<img src="images/b_drop.png" width="16" height="16" border="0" />						</a>						</div>						</td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $maincode; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $accountsmainname; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $subcode; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $accountssubname; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $id; ?></td>
						 <td width="17%" align="left" valign="top"  class="bodytext3"><span class="bodytext32"><?php echo $accountname; ?></span></td>
                        <td align="left" valign="top"  class="bodytext3"><span class="bodytext32"><?php echo $paymenttype; ?></span></td>
                        <td width="12%" align="left" valign="top"  class="bodytext3"><span class="bodytext32"><?php echo $subtype; ?></span></td>
						
						<td width="16%" align="left" valign="top"  class="bodytext3"><span class="bodytext32"><?php echo $res612name; ?></span></td>
                       
                        
                        <td width="5%" align="left" valign="top"  class="bodytext3">
						<a href="editaccountname1.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a>						</td>
                      </tr>
                      <?php
		}
		
}
if($action == 'searchcoafunction')
{
	$accountsearch=$_REQUEST['accountsearch'];
	$accountsmaintype1 = $_REQUEST['accountsmaintype1'];
	$accountssub1 = $_REQUEST['accountssub1'];
	$accountid = $_REQUEST['accountid'];
		if($accountid!='' && $accountsmaintype1=='' && $accountssub1==''){
		$query1 = "select * from master_accountname where recordstatus <> 'deleted' and accountname like '%$accountsearch%' and id='$accountid' order by accountssub";
		} elseif($accountid=='' && $accountsmaintype1!='' && $accountssub1==''){
		$query1 = "select * from master_accountname where recordstatus <> 'deleted' and  accountsmain='$accountsmaintype1' order by accountssub";	
		} elseif($accountid=='' && $accountsmaintype1!='' && $accountssub1!=''){
		$query1 = "select * from master_accountname where recordstatus <> 'deleted' and  accountsmain='$accountsmaintype1' and accountssub='$accountssub1' order by accountssub";	
		}
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$auto_number = $res1['auto_number'];
		$accountname = $res1["accountname"];
		$auto_number = $res1["auto_number"];
		$paymenttypeanum = $res1['paymenttype'];
		$subtypeanum = $res1['subtype'];
		$expirydate = $res1['expirydate'];
		$accountsmain = $res1['accountsmain'];
		$accountssub = $res1['accountssub'];
		
		$cost_center = $res1['cost_center'];
		$id = $res1['id'];
		$query612 = "select * from master_costcenter where auto_number = '$cost_center' and recordstatus <> 'deleted'";
		$exec612 = mysqli_query($GLOBALS["___mysqli_ston"], $query612) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res612 = mysqli_fetch_array($exec612);
		$res612name = $res612['name'];
		$query6 = "select * from master_accountsmain where auto_number = '$accountsmain' and recordstatus <> 'deleted'";
		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res6 = mysqli_fetch_array($exec6);
		$maincode = $res6['id'];
		$accountsmainname = $res6['accountsmain'];
		
		$query8 = "select * from master_accountssub where auto_number = '$accountssub' and recordstatus <> 'deleted'";
		$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res8 = mysqli_fetch_array($exec8);
		$subcode = $res8['id'];
		$accountssubname = $res8['accountssub'];
		
		//$defaultstatus = $res1["defaultstatus"];
		
		$query2 = "select * from master_paymenttype where auto_number = '$paymenttypeanum'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$paymenttype = $res2['paymenttype'];
		
		$query3 = "select * from master_subtype where auto_number = '$subtypeanum'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res3 = mysqli_fetch_array($exec3);
		$subtype = $res3['subtype'];
	
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
                        <td width="4%" align="left" valign="top"  class="bodytext3">
						<div align="center">
						<a href="addaccountname1.php?st=del&&anum=<?php echo $auto_number; ?>" onClick="return funcDeleteAccountName1('<?php echo $accountname;?>')">
						<img src="images/b_drop.png" width="16" height="16" border="0" />						</a>						</div>						</td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $maincode; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $accountsmainname; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $subcode; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $accountssubname; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $id; ?></td>
						 <td width="17%" align="left" valign="top"  class="bodytext3"><span class="bodytext32"><?php echo $accountname; ?></span></td>
                        <td align="left" valign="top"  class="bodytext3"><span class="bodytext32"><?php echo $paymenttype; ?></span></td>
                        <td width="12%" align="left" valign="top"  class="bodytext3"><span class="bodytext32"><?php echo $subtype; ?></span></td>
						
						<td width="16%" align="left" valign="top"  class="bodytext3"><span class="bodytext32"><?php echo $res612name; ?></span></td>
                       
                        
                        <td width="5%" align="left" valign="top"  class="bodytext3">
						<a href="editaccountname1.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a>						</td>
                      </tr>
                      <?php
		}
		
}
// Plan Master
if($action == 'scrollplanfunction')
{
	    $query1 = "select * from master_planname where recordstatus <> 'deleted' order by planname limit $serialno,50";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$planname = $res1["planname"];
		$accountnameanum = $res1["accountname"];
		$plancondition = $res1["plancondition"];
		$subtypeanum = $res1["subtype"];
		$planfixedamount = $res1["planfixedamount"];
		$planpercentage = $res1["planpercentage"];
		$auto_number = $res1["auto_number"];
		//$defaultstatus = $res1["defaultstatus"];
		$planexpirydate = $res1['planexpirydate'];
		$scheme_id = $res1['scheme_id'];
		$scheme_name = $res1['scheme_name'];
		$scheme_expiry = $res1['scheme_expiry'];
		$query2 = "select * from master_accountname where auto_number = '$accountnameanum'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$accountname = $res2['accountname'];
		$query22 = "select subtype from master_subtype where auto_number = '$subtypeanum'";
		$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res22 = mysqli_fetch_array($exec22);
		$subtype = $res22['subtype'];
		
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
                        <td width="6%" align="left" valign="top"  class="bodytext3"><div align="center"><a href="addplanname1.php?st=del&&anum=<?php echo $auto_number; ?>"><img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
                        <td width="34%" align="left" valign="top"  class="bodytext3"><?php echo $planname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $subtype; ?></td>
						<td align="left" valign="top"  class="bodytext3"><?php echo $accountname; ?></td>
						<td align="left" valign="top"  class="bodytext3"><?php echo $scheme_name; ?></td>
						<td align="left" valign="top"  class="bodytext3"><?php echo $scheme_expiry; ?></td>
                        <td width="13%" align="left" valign="top"  class="bodytext3"><?php echo $planfixedamount; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $planpercentage; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $planexpirydate; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"> <a href="editplanname1.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a></td>
        </tr>
                      <?php
		}
		
		
}
if($action == 'searchplanfunction')
{
	$plansearch=$_REQUEST['plansearch'];
	$query1 = "select mp.planname,mp.scheme_name,mp.scheme_id,mp.scheme_expiry,mp.plancondition,mp.planfixedamount,mp.planpercentage,mp.auto_number,mp.planexpirydate,mc.accountname from master_planname mp , master_accountname mc where mp.recordstatus <> 'deleted' and mc.accountname like '%$plansearch%' and  mp.accountname=mc.auto_number order by planname";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$planname = $res1["planname"];
		$accountnameanum = $res1["accountname"];
		$plancondition = $res1["plancondition"];
		$planfixedamount = $res1["planfixedamount"];
		$planpercentage = $res1["planpercentage"];
		$auto_number = $res1["auto_number"];
		//$defaultstatus = $res1["defaultstatus"];
		$planexpirydate = $res1['planexpirydate'];
		
		$scheme_id = $res1['scheme_id'];
		$scheme_name = $res1['scheme_name'];
		$scheme_expiry = $res1['scheme_expiry'];
		//$query2 = "select * from master_accountname where auto_number = '$accountnameanum'";
		//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		//$res2 = mysql_fetch_array($exec2);
		$accountname = $res1['accountname'];
		
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
                        <td width="6%" align="left" valign="top"  class="bodytext3"><div align="center"><a href="addplanname1.php?st=del&&anum=<?php echo $auto_number; ?>"><img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
                        <td width="34%" align="left" valign="top"  class="bodytext3"><?php echo $planname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $accountname; ?></td>
                        <td align="left" valign="top"  class="bodytext3"> <a href="editscheme.php?st=edit&&scheme_id=<?php echo $scheme_id; ?>" style="text-decoration:none"><?php echo $scheme_name; ?></a></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $scheme_expiry; ?></td>
                        <td width="13%" align="left" valign="top"  class="bodytext3"><?php echo $planfixedamount; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $planpercentage; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $planexpirydate; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"> <a href="editplanname1.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a></td>
        </tr>
                      <?php
		}
}
?>