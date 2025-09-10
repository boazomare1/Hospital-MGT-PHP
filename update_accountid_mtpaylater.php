<?php
// include ("includes/loginverify.php");

include ("db/db_connect.php");

$a=0;
$query = "SELECT * FROM `master_transactionpaylater` WHERE `upload_id` LIKE '%EXUP%' and billnumber!='' and billnumber not like 'CB-%' and recordstatus='allocated' ORDER BY `auto_number` DESC";

// -- $query = "SELECT *,count(billnumber) as bno FROM `master_transactionpaylater` WHERE transactiontype='finalize' AND billnumber in (SELECT billnumber FROM `master_transactionpaylater` WHERE `upload_id` LIKE '%EXUP%' and billnumber!='' and billnumber not like 'CB-%' and recordstatus='allocated' group by billnumber) group by billnumber having bno=1";
      $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
      while($res = mysqli_fetch_array($exec)){

        $bill_no=$res['billnumber'];
        $auto_number=$res['auto_number'];
        $subtypeano=$res['subtypeano'];
        $upload_id=$res['upload_id'];
        $docno=$res['docno'];
        $fxamount_ar=$res['fxamount'];

         // $query1 = "SELECT patientcode, patientname, visitcode, transactionamount, accountname, subtype, accountcode, accountnameid, accountnameano  FROM `master_transactionpaylater` where billnumber='$bill_no' and subtypeano='$subtypeano' and transactionamount<>'0.00'  and transactiontype='finalize'";


        // SELECT * FROM `master_transactionpaylater` WHERE `upload_id` LIKE '%EXUP%' and billnumber!='' and billnumber in (SELECT *,count(billnumber) as bno FROM `master_transactionpaylater` WHERE transactiontype='finalize' AND billnumber='$bill_no'   group by billnumber having bno>1)  and recordstatus='allocated' ORDER BY `auto_number` DESC

         // $query1 = "SELECT *,count(billnumber) as bno FROM `master_transactionpaylater` WHERE transactiontype='finalize' AND billnumber='$bill_no'   group by billnumber having bno>1";

         //            $exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
         //            $y=mysql_num_rows($exec1);
         //            $res1 = mysql_fetch_array($exec1);

                    if(1){
                        $query2 = "SELECT * FROM `master_transactionpaylater` WHERE transactiontype='finalize' AND billnumber='$bill_no'  and fxamount='$fxamount_ar' ";
                        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $x=mysqli_num_rows($exec2);
                        $res2 = mysqli_fetch_array($exec2);
                        $accountnameid_bill=$res2['accountnameid'];
                        $accountnameano_bill=$res2['accountnameano'];


                        if($x>0){
                        	 $a+=1;
                           // echo $bill_no.'<br>';

                              //       	$query8="UPDATE master_transactionpaylater set accountnameid = '$accountnameid_bill',accountcode='$accountnameid_bill', accountnameano = '$accountnameano_bill' where auto_number='$auto_number' and docno='$docno' and upload_id='$upload_id' and billnumber='$bill_no' and  recordstatus = 'allocated'  and subtypeano='$subtypeano'";  
                    					     // $exec8=mysql_query($query8) or die(mysql_error());

                      } //
                    }

                      

      }
      echo $a.'--';

      ?>