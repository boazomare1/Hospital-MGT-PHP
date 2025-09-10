<?php
include ("db/db_connect.php");
$getsub='select * from master_subtype where auto_number>1';
$opexec2 = mysqli_query($GLOBALS["___mysqli_ston"], $getsub) or die ("Error in getsub".mysqli_error($GLOBALS["___mysqli_ston"]));
echo '<table border=1>';
$tot2=0;
while($opres2= mysqli_fetch_array($opexec2)){

$subtype=$opres2['subtype'];
$subtypeid=$opres2['auto_number'];

$getsub2="select sum(if(transaction_type='C',-1*transaction_amount,transaction_amount)) as tot from tb where ledger_id in (select id from master_accountname where accountssub=2 and accountsmain=2 and subtype='$subtypeid') and transaction_date between '2000-01-01' and '2021-03-20'";
$opexec22 = mysqli_query($GLOBALS["___mysqli_ston"], $getsub2) or die ("Error in getsub2".mysqli_error($GLOBALS["___mysqli_ston"]));
$opres22= mysqli_fetch_array($opexec22);
$tot=$opres22['tot'];
if($tot!=0){
  $tot2=$tot2+$tot;
  echo "<tr><td>".$subtype."</td><td>".$subtypeid."</td><td>".$tot."</td></tr>";
}
}
 echo "<tr><td colspan=2>Total</td><td>".$tot2."</td></tr>";
echo '</table>';
?>