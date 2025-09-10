<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$ADate1 = date('Y-m-d', strtotime('01-01-2015'));
$ADate2 = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$sno = "";
$stl = '';
$std = '';
$colorloopcount = '';
$totalamount = '0.00';

if (isset($_REQUEST["tbl"])) { $tbl = $_REQUEST["tbl"]; } else { $tbl = ""; }
if (isset($_REQUEST["ledgeranum"])) { $ledgeranum = $_REQUEST["ledgeranum"]; } else { $ledgeranum = ""; }
if (isset($_REQUEST["group"])) { $group = $_REQUEST["group"]; } else { $group = ""; }
if (isset($_REQUEST["field"])) { $field1 = $_REQUEST["field"]; } else { $field1 = ""; }
if (isset($_REQUEST["selectfield"])) { $selectfield = $_REQUEST["selectfield"]; } else { $selectfield = ""; }
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }

if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }

$loc = '';
$query8 = "select locationname from master_location where locationcode = '$location'";
$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res8 = mysqli_fetch_array($exec8))
{
	$locationname = $res8['locationname'];
	if($loc == '')
	{
		$loc = $locationname;
	}
	else
	{
		$loc = $loc.','.$locationname;
	}
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
<script type="text/javascript" src="js/autocomplete_ledger.js"></script>
<script type="text/javascript" src="js/autosuggestledger.js"></script>
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>

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
<script type="text/javascript">
window.onload = function(){

var oTextbox = new AutoSuggestControlledger(document.getElementById("ledger"), new StateSuggestions()); 
	//alert(oTextbox1); 
}
</script>
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
		
		
              <form name="cbform1" method="post" action="ledgerreport_detail.php?tbl=<?php echo $tbl;?>&&field=<?php echo $field1; ?>&&ledgeranum=<?php echo $ledgeranum; ?>&&group=<?php echo $group; ?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&anum=<?php echo $anum; ?>&&location=<?php echo $location; ?>" onSubmit="return modulecheck()">
		<table width="60%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
             <?php
		 	$query9 = "select * from master_accountname where auto_number = '$ledgeranum'";
			$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res9 = mysqli_fetch_array($exec9);
			$acccoa23 = $res9['accountname'];
			?>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#FFFFFF" class="bodytext3"><strong> Ledger Report - Detail  <span style="color:#FF0000;"> &nbsp;&nbsp;From <?php echo date('d-M-Y',strtotime($ADate1)); ?> to <?php echo date('d-M-Y',strtotime($ADate2)); ?></span>&nbsp;&nbsp;&nbsp;&nbsp;For Location &nbsp;&nbsp;<span style="color:#FF0000;"><?php echo $loc; ?></span></strong></td>
              </tr>
              <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#0099FF" class="bodytext3" style="color:#FFF;"><strong><?php echo strtoupper($acccoa23); ?></strong></td>
              </tr>
			  <?php
			  if ($cbfrmflag1 != 'cbfrmflag1')
				{
				$query7 = "select field from master_financialintegration where tblname = '$tbl' and field = '$field1' and auto_number = '$anum'";
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res7 = mysqli_fetch_array($exec7);
				$field7 = $res7['field'];
				?>
			  <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong> Select Fields</strong></td>
              </tr>
			  <tr>
                 <td colspan="4" align="left" valign="center" 
                bgcolor="#FFFFFF" class="bodytext3">
				 <table border="0">
				 <tr>
				<?php
				 $typebuild = '';
				 $query8 = "SHOW COLUMNS from $tbl";
				 $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
				 while($res8 = mysqli_fetch_array($exec8))
				 {
				 $sno = $sno + 1;
				 $tblfield = $res8['Field'];
				 $tbltype = $res8['Type'];
				 $tbltype = substr($tbltype,0,7);
				 if($tbltype == 'decimal')
				 {
				 	if($typebuild == '')
					{
						$typebuild = $tblfield;
					}
					else
					{
						$typebuild = $typebuild.','.$tblfield;
					}
				 }
				 ?>
				 <td class="bodytext3" align="left"><input type="checkbox" name="field[]" id="field" <?php if($field7 == $tblfield) { echo 'checked="checked"';} ?> value="<?php echo $tblfield; ?>"></td>
				 <td class="bodytext3" align="left"><?php echo $tblfield; ?></td>
				 <?php
				 if($sno%8==0)
				 {
				 echo '</tr>';
				 }
				 }
				 ?>	
				 <input type="hidden" name="typebuild[]" id="typebuild" value="<?php echo $typebuild;?>">
				 </table>
				 </td> </tr>	
							
            <tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input type="hidden" name="tbl" id="tbl" value="<?php echo $tbl; ?>">
			  <input type="hidden" name="group" id="group" value="<?php echo $group; ?>">
			  <input type="hidden" name="selectfield" id="selectfield" value="<?php echo $field1; ?>">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" value="Submit" name="Submit" />
               </td>
            </tr>
			<?php
			}
			?>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>
		<table width="60%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
		<tbody>
		<?php
		if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
		//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
		$fieldbuild = '';
		if ($cbfrmflag1 == 'cbfrmflag1')
		{
		$selectfield = $_REQUEST['selectfield'];
		?>
		<tr bgcolor="#011E6A">
		<td bgcolor="#FFFFFF" align="left" class="bodytext3"><strong><?php echo 'S.No';?></strong></td>
		<?php
			$fieldarray = $_REQUEST['field'];
			$fieldarraylen = count($fieldarray);
			foreach($fieldarray as $field)
			{
			$field;
			if($fieldbuild == '') {
			$fieldbuild = $field;
			} else { $fieldbuild = $fieldbuild.','.$field; }
		?>
		<td bgcolor="#FFFFFF" class="bodytext3"><strong><?php echo $field; ?></strong></td>
		<?php
		}
		?>
		</tr>
		<?php
		$query7 = "select * from master_financialintegration where auto_number = '$anum'";
		$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res7 = mysqli_fetch_array($exec7);
		$field7 = $res7['field'];
		$datefield7 = $res7['datefield'];
		$condfield = $res7['condfield'];
		$extracond = $res7['extracond'];
		//$acccoa = $res7['coa'];
		
		$query9 = "select * from master_accountname where auto_number = '$ledgeranum'";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res9 = mysqli_fetch_array($exec9);
		$acccoa = $res9['accountname'];
		$id2 = $res9['id'];	
		
		if($condfield == '' && $extracond == '')
		{
		$query5 = "select $fieldbuild from $tbl where $datefield7 between '$ADate1' and '$ADate2' and locationcode = '$location' order by $datefield7";
		}
		else if($condfield != '' && $extracond == '')
		{
		$query5 = "select $fieldbuild from $tbl where ($condfield = '$id2') and $datefield7 between '$ADate1' and '$ADate2' and locationcode = '$location' order by $datefield7";
		}
		else if($extracond != '')
		{
		$query5 = "select $fieldbuild from $tbl where $extracond and DATE($datefield7) between '$ADate1' and '$ADate2' order by $datefield7";
		}
		$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res5 = mysqli_fetch_array($exec5))
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
		<tr <?php echo $colorcode; ?>>
		<td align="left" class="bodytext3"><?php echo $colorloopcount;?></td>
		<?php
			foreach($fieldarray as $field1)
			{
			$stl = $stl + 1;
			$query7 = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
  			WHERE table_name = '$tbl' AND COLUMN_NAME = '$field1'";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res7 = mysqli_fetch_array($exec7);
			$res7type = $res7['DATA_TYPE'];
			
			if($field1 == $field7)
			//if($res7type == 'decimal')
			{
				$field1 = $res5[$field1];
				$totalamount = $totalamount + $field1;
			}
			else
			{
				$field1 = $res5[$field1];
			}
		
		?>
		<td align="left" class="bodytext3"><?php echo $field1; ?></td>
		<?php	
		}
		?>
		</tr>
		<?php
		}
		?>
		<tr bgcolor="#ecf0f5">
		<td align="left" class="bodytext3"><strong><?php echo 'Total';?></strong></td>
		<?php
		 foreach($fieldarray as $field1)
			{
			$std = $std + 1;
			$query7 = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
  			WHERE table_name = '$tbl' AND COLUMN_NAME = '$field1'";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res7 = mysqli_fetch_array($exec7);
			$res7type = $res7['DATA_TYPE'];
			
			if($field1 == $field7)
			//if($res7type == 'decimal')
			{
			?>
		<td align="left" class="bodytext3"><strong><?php echo number_format($totalamount,2,'.',',');?></strong></td>
		<?php }
		else{?>
		<td align="left" class="bodytext3"></td>
		<?php
		}
		 }?>
		</tr>
		<?php
		}
		?>
		</tbody>
		</table>		
		</td>
      </tr>
         
</table>
</td>
</tr>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
