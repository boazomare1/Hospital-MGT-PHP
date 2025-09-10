<?php
$openingbalance = "0.00";
$totalamount21 = "0.00";
$totalamount2 = "0.00";

$query89 = "select * from master_accountname where auto_number = '$ledgeranum'";
$exec89 = mysqli_query($GLOBALS["___mysqli_ston"], $query89) or die ("Error in Query89".mysqli_error($GLOBALS["___mysqli_ston"]));
$res89 = mysqli_fetch_array($exec89);
$group = $res89['accountssub'];
$ledgerid = $res89['id'];

$query678 = "select accountsmain from master_accountssub where auto_number = '$group'";
$exec678 = mysqli_query($GLOBALS["___mysqli_ston"], $query678) or die ("Error in Query678".mysqli_error($GLOBALS["___mysqli_ston"]));
$res678 = mysqli_fetch_array($exec678);
$accountsmain = $res678['accountsmain'];

$query6781 = "select section from master_accountsmain where auto_number = '$accountsmain'";
$exec6781 = mysqli_query($GLOBALS["___mysqli_ston"], $query6781) or die ("Error in Query6781".mysqli_error($GLOBALS["___mysqli_ston"]));
$res6781 = mysqli_fetch_array($exec6781);
$type1 = $res6781['section'];

$query83 = "select condfield,extracond from master_financialintegration where groupcode = '$group' and recordstatus <> 'deleted'";
$exec83 = mysqli_query($GLOBALS["___mysqli_ston"], $query83) or die ("Error in Query83".mysqli_error($GLOBALS["___mysqli_ston"]));
$res83 = mysqli_fetch_array($exec83);
$condfield3 = $res83['condfield'];
$extracond3 = $res83['extracond'];
if($condfield3 == '' && $extracond3 == '')
{
$query31 = "select * from master_financialintegration where code = '$ledgerid' and recordstatus <> 'deleted'";
}
else if($condfield3 != '' && $extracond3 == '')
{
$query31 = "select * from master_financialintegration where groupcode = '$group' and recordstatus <> 'deleted'";
}
else if($extracond3 != '')
{
$query31 = "select * from master_financialintegration where code = '$ledgerid' and recordstatus <> 'deleted'";
}
$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res31 = mysqli_fetch_array($exec31))
{
$tblname1 = $res31['tblname'];
$tblcolumn1 = $res31['field'];
$tbldate1 = $res31['datefield'];
$acccoa = $res31['coa'];
$status = $res31['selectstatus'];
//$type1 = $res31['type'];
//$condfield = $res31['condfield'];
$code1 = $res31['code'];

$query9 = "select * from master_accountname where auto_number = '$ledgeranum'";
$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
$res9 = mysqli_fetch_array($exec9);
$accountsmain2 = $res9['accountname'];	
$id2 = $res9['id'];


$query81 = "select condfield,extracond from master_financialintegration where groupcode = '$group' and tblname = '$tblname1' and recordstatus <> 'deleted'";
$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
$res81 = mysqli_fetch_array($exec81);
$condfield1 = $res81['condfield'];
$extracond1 = $res81['extracond'];
if($condfield1 == '' && $extracond1 == '')
{
$query132 = "select SUM($tblcolumn1) as totalsumamount32 from $tblname1 where $tbldate1 < '$ADate1' and locationcode = '$location'";
}
else if($condfield1 != '' && $extracond1 == '')
{
$query132 = "select SUM($tblcolumn1) as totalsumamount32 from $tblname1 where $condfield1 = '$id2' and $tbldate1 < '$ADate1' and locationcode = '$location'";
}
else if($extracond1 != '')
{
$query132 = "select SUM($tblcolumn1) as totalsumamount32 from $tblname1 where $extracond1 and DATE($tbldate1) < '$ADate1'";
}
$exec132 = mysqli_query($GLOBALS["___mysqli_ston"], $query132) or die ("Error in Query132".mysqli_error($GLOBALS["___mysqli_ston"]));
$res132 = mysqli_fetch_array($exec132);
//echo '<br>'.$query132;
$totalsumamount32 = $res132['totalsumamount32'];

if($status == 'dr' && $type1 == 'A')
{
$openingbalance = $openingbalance + $totalsumamount32;
}
if($status == 'cr' && $type1 == 'A')
{
$openingbalance = $openingbalance - $totalsumamount32;
}
if($status == 'cr' && $type1 == 'I')
{
$openingbalance = $openingbalance + $totalsumamount32;
}
if($status == 'dr' && $type1 == 'I')
{
$openingbalance = $openingbalance - $totalsumamount32;
}
if($status == 'cr' && $type1 == 'L')
{
$openingbalance = $openingbalance + $totalsumamount32;
}
if($status == 'dr' && $type1 == 'L')
{
$openingbalance = $openingbalance - $totalsumamount32;
}
if($status == 'dr' && $type1 == 'E')
{
$openingbalance = $openingbalance + $totalsumamount32;
}
if($status == 'cr' && $type1 == 'E')
{
$openingbalance = $openingbalance - $totalsumamount32;
}
}
//$openingbalance;
/*if($type1 == 'A' || $type1 == 'E')
{
$openingbalancedebit = $openingbalance;
}
else
{
$openingbalancecredit = $openingbalance;
}*/
$openingbalance;
?>	
<?php
$query8 = "select condfield,extracond from master_financialintegration where groupcode = '$group' and recordstatus <> 'deleted'";
$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
$res8 = mysqli_fetch_array($exec8);
$condfield = $res8['condfield'];
$extracond = $res8['extracond'];
if($condfield == '' && $extracond == '')
{
$query1 = "select * from master_financialintegration where code = '$ledgerid' and selectstatus = 'dr' and recordstatus <> 'deleted'";
}
else if($condfield != '' && $extracond == '')
{
$query1 = "select * from master_financialintegration where groupcode = '$group' and selectstatus = 'dr' and recordstatus <> 'deleted'";
}
else if($extracond != '')
{
$query1 = "select * from master_financialintegration where code = '$ledgerid' and selectstatus = 'dr' and recordstatus <> 'deleted'";
}
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res1 = mysqli_fetch_array($exec1))
{
$tblname1 = $res1['tblname'];
$tblcolumn1 = $res1['field'];
$tbldate1 = $res1['datefield'];
//$acccoa = $res1['coa'];
$status = $res1['selectstatus'];
//$type1 = $res1['type'];
$displayname = $res1['displayname'];
$condfield = $res1['condfield'];
$code1 = $res1['code'];
$fanum1 = $res1['auto_number'];
$extracond1 = $res1['extracond'];

$query9 = "select * from master_accountname where auto_number = '$ledgeranum'";
$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
$res9 = mysqli_fetch_array($exec9);
$acccoa = $res9['accountname'];
$id = $res9['id'];

if($condfield == '' && $extracond1 == '')
{
$query2 = "select SUM($tblcolumn1) as totalsumamount2 from $tblname1 where $tbldate1 between '$ADate1' and '$ADate2' and locationcode = '$location'";
}
else if($condfield != '' && $extracond1 == '')
{
$query2 = "select SUM($tblcolumn1) as totalsumamount2 from $tblname1 where $condfield = '$id' and $tbldate1 between '$ADate1' and '$ADate2' and locationcode = '$location'";
}
else if($extracond1 != '')
{
$query2 = "select SUM($tblcolumn1) as totalsumamount2 from $tblname1 where $extracond1 and DATE($tbldate1) between '$ADate1' and '$ADate2'";
}
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res2 = mysqli_fetch_array($exec2))
{
$totalsumamount2 = $res2['totalsumamount2'];

$totalamount21 = $totalamount21 + $totalsumamount2;

}
}
?>
<?php
$totalamount2 = '0.00';
$snocount = '';
$condfield1 = '';
$query81 = "select condfield, extracond from master_financialintegration where groupcode = '$group' and recordstatus <> 'deleted'";
$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
$res81 = mysqli_fetch_array($exec81);
$condfield1 = $res81['condfield'];
$extracond = $res81['extracond'];
if($condfield1 == '' && $extracond == '')
{
$query1 = "select * from master_financialintegration where code = '$ledgerid' and selectstatus = 'cr' and recordstatus <> 'deleted'";
}
else if($condfield1 != '' && $extracond == '')
{
$query1 = "select * from master_financialintegration where groupcode = '$group' and selectstatus = 'cr' and recordstatus <> 'deleted'";
}
else if($extracond != '')
{
$query1 = "select * from master_financialintegration where code = '$ledgerid' and selectstatus = 'cr' and recordstatus <> 'deleted'";
}
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res1 = mysqli_fetch_array($exec1))
{
$tblname1 = $res1['tblname'];
$tblcolumn1 = $res1['field'];
$tbldate1 = $res1['datefield'];
//$acccoa = $res1['coa'];
$status = $res1['selectstatus'];
//$type1 = $res1['type'];
$displayname = $res1['displayname'];
$condfield = $res1['condfield'];
$code1 = $res1['code'];
$fanum2 = $res1['auto_number'];
$extracond1 = $res1['extracond'];

$query9 = "select * from master_accountname where auto_number = '$ledgeranum'";
$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
$res9 = mysqli_fetch_array($exec9);
$acccoa = $res9['accountname'];
$id = $res9['id'];
		
if($condfield == '' && $extracond1 == '')
{
$query2 = "select SUM($tblcolumn1) as totalsumamount2 from $tblname1 where $tbldate1 between '$ADate1' and '$ADate2' and locationcode = '$location'";
}
else if($condfield != '' && $extracond1 == '')
{
$query2 = "select SUM($tblcolumn1) as totalsumamount2 from $tblname1 where $condfield = '$id' and $tbldate1 between '$ADate1' and '$ADate2' and locationcode = '$location'";
}
else if($extracond1 != '')
{
$query2 = "select SUM($tblcolumn1) as totalsumamount2 from $tblname1 where $extracond1 and DATE($tbldate1) between '$ADate1' and '$ADate2'";
}
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res2 = mysqli_fetch_array($exec2))
{
$totalsumamount2 = $res2['totalsumamount2'];

$totalamount2 = $totalamount2 + $totalsumamount2;

}
}
if($type1 == 'A' || $type1 == 'E')
{
$balance = $totalamount21 - $totalamount2 + $openingbalance;
}
else
{
$balance = $totalamount2 - $totalamount21 + $openingbalance;
} 
?>