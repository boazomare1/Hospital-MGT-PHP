<?php
$queryd2 = "select * from master_transactionpaynow where username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
$execd2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryd2) or die ("Error in Queryd2".mysqli_error($GLOBALS["___mysqli_ston"]));
$resd2 = mysqli_fetch_array($execd2);
$numsd2 = mysqli_num_rows($execd2);
$queryd23 = "select * from master_billing where username = '$res21username' and billingdatetime between '$transactiondatefrom' and '$transactiondateto' order by username desc";
$execd23 = mysqli_query($GLOBALS["___mysqli_ston"], $queryd23) or die ("Error in Queryd23".mysqli_error($GLOBALS["___mysqli_ston"]));
$resd23 = mysqli_fetch_array($execd23);
$numsd23 = mysqli_num_rows($execd23);
$queryd24 = "select * from master_transactionexternal where username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
$execd24 = mysqli_query($GLOBALS["___mysqli_ston"], $queryd24) or die ("Error in Queryd24".mysqli_error($GLOBALS["___mysqli_ston"]));
$resd24 = mysqli_fetch_array($execd24);
$numsd24 = mysqli_num_rows($execd24);
$queryd25 = "select * from refund_paynow where username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
$execd25 = mysqli_query($GLOBALS["___mysqli_ston"], $queryd25) or die ("Error in Queryd25".mysqli_error($GLOBALS["___mysqli_ston"]));
$resd25 = mysqli_fetch_array($execd25);
$numsd25 = mysqli_num_rows($execd25);
$queryd26 = "select * from master_transactionadvancedeposit where username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
$execd26 = mysqli_query($GLOBALS["___mysqli_ston"], $queryd26) or die ("Error in Queryd26".mysqli_error($GLOBALS["___mysqli_ston"]));
$resd26 = mysqli_fetch_array($execd26);
$numsd26 = mysqli_num_rows($execd26);
$queryd27 = "select * from master_transactionipdeposit where username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
$execd27 = mysqli_query($GLOBALS["___mysqli_ston"], $queryd27) or die ("Error in Queryd27".mysqli_error($GLOBALS["___mysqli_ston"]));
$resd27 = mysqli_fetch_array($execd27);
$numsd27 = mysqli_num_rows($execd27);
$queryd28 = "select * from master_transactionip where username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
$execd28 = mysqli_query($GLOBALS["___mysqli_ston"], $queryd28) or die ("Error in Queryd28".mysqli_error($GLOBALS["___mysqli_ston"]));
$resd28 = mysqli_fetch_array($execd28);
$numsd28 = mysqli_num_rows($execd28);
$queryd29 = "select * from master_transactionipcreditapproved where username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
$execd29 = mysqli_query($GLOBALS["___mysqli_ston"], $queryd29) or die ("Error in Queryd29".mysqli_error($GLOBALS["___mysqli_ston"]));
$resd29 = mysqli_fetch_array($execd29);
$numsd29 = mysqli_num_rows($execd29);
$queryd40 = "select * from receiptsub_details where username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
$execd40 = mysqli_query($GLOBALS["___mysqli_ston"], $queryd40) or die ("Error in Queryd40".mysqli_error($GLOBALS["___mysqli_ston"]));
$resd40 = mysqli_fetch_array($execd40);
$numsd40 = mysqli_num_rows($execd40);

$queryd291 = "select * from deposit_refund where username = '$res21username' and recorddate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
$execd291 = mysqli_query($GLOBALS["___mysqli_ston"], $queryd291) or die ("Error in Queryd291".mysqli_error($GLOBALS["___mysqli_ston"]));
$resd291 = mysqli_fetch_array($execd291);
$numsd291 = mysqli_num_rows($execd291);
$queryd140 = "select * from master_transactionpaylater where locationcode='$locationcode1' and username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and docno like 'AR-%' and transactionstatus='onaccount' ";
$execd140 = mysqli_query($GLOBALS["___mysqli_ston"], $queryd140) or die ("Error in Queryd140".mysqli_error($GLOBALS["___mysqli_ston"]));
$resd140 = mysqli_fetch_array($execd140);
$numsd140 = mysqli_num_rows($execd140);
?>