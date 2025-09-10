<?php
include ("db/db_connect.php");
$getsub='select * from master_subtype where auto_number=46';
$opexec2 = mysqli_query($GLOBALS["___mysqli_ston"], $getsub) or die ("Error in getsub".mysqli_error($GLOBALS["___mysqli_ston"]));
echo '<table border=1>';
$tot2=0;
while($opres2= mysqli_fetch_array($opexec2)){

$subtype=$opres2['subtype'];
$subtypeid=$opres2['auto_number'];

$getsub2="select sum(if(transaction_type='C',-1*transaction_amount,transaction_amount)) as tot,ledger_id from tb where ledger_id in (select id from master_accountname where accountssub=2 and accountsmain=2 and subtype='$subtypeid') and transaction_date between '2000-01-01' and '2021-03-20' group by ledger_id";
$opexec22 = mysqli_query($GLOBALS["___mysqli_ston"], $getsub2) or die ("Error in getsub2".mysqli_error($GLOBALS["___mysqli_ston"]));
while($opres22= mysqli_fetch_array($opexec22)){
$tot=$opres22['tot'];
$ledger_id=$opres22['ledger_id'];
if($tot!=0){
  $tot2=$tot2+$tot;
  $getname="select accountname from master_accountname where id='$ledger_id'";
  $opexec223 = mysqli_query($GLOBALS["___mysqli_ston"], $getname) or die ("Error in getname".mysqli_error($GLOBALS["___mysqli_ston"]));
  $opres222= mysqli_fetch_array($opexec223);
  echo "<tr><td>".$opres222['accountname']."</td><td>".$tot."</td></tr>";
}
}
}
 echo "<tr><td>Total</td><td>".$tot2."</td></tr>";
echo '</table>';
?>