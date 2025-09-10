<?php
session_start();
error_reporting(0);
set_time_limit(0);
//date_default_timezone_set('Asia/Calcutta');
include("db/db_connect.php");
include("includes/loginverify.php");
include ("includes/check_user_access.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$docno = $_SESSION['docno'];

$titlestr = 'SALES BILL';

if (isset($_REQUEST["selectpending"])) {
    $selectpending = $_REQUEST["selectpending"];
} else {
    $selectpending = "";
}
if (isset($_REQUEST["frm1submit1"])) {
    $frm1submit1 = $_REQUEST["frm1submit1"];
} else {
    $frm1submit1 = "";
}
if ($frm1submit1 == 'frm1submit1') {
    $visitcode = $_REQUEST["visitcode"];
    $patientcode = $_REQUEST["customercode"];
    $patientname = $_REQUEST["customername"];
    $consultationdate = date("Y-m-d");
    $accountname = $_REQUEST["account"];
    $billtype = $_REQUEST['billtype'];

    $query341 = "select billtype,planpercentage,planname from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
    $exec341 = mysqli_query($GLOBALS["___mysqli_ston"], $query341);
    $res341 = mysqli_fetch_array($exec341);
    $billingtype = $res341['billtype'];
    $planpercentage = $res341['planpercentage'];
    $planname = $res341['planname'];

    $query222 = "select forall from master_planname where auto_number = '$planname'";
    $exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    $res222 = mysqli_fetch_array($exec222);
    $forall = $res222['forall'];

    if ($billingtype == 'PAY NOW') {
        $status = 'pending';
    } else {
        if (($planpercentage > 0.00 && $forall != '')) {
            $status = 'pending';
        } else {
            $status = 'completed';
        }
    }
    $planforall = $forall;

    $query2 = "select * from master_consultationpharm where patientcode='$patientcode' and patientvisitcode='$visitcode' order by auto_number desc limit 0, 1";
    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $res2 = mysqli_fetch_array($exec2);
    $medrefnonumber = $res2["refno"];
    $oldno = 0;
		foreach ($_POST['aitemcode'] as $key => $value) {
        $oldno = $oldno + 1;
        //echo $key;
        $aitemcode = $_POST['aitemcode'][$key];
        $consid1 = $_POST['consid'][$key];
        $adays = $_POST['adays'][$key];
        $adose = $_POST['adose'][$key];
        $adosemeasure = $_POST['adosemeasure'][$key];
        $aquantity = $_POST['aquantity'][$key];
        $aroute = $_POST['aroute'][$key];
        $aamount = $_POST['amount'][$key];
        $afrequency = $_POST['afrequency'][$key];
        $ainstructions = $_POST['ainstructions'][$key];
        $copay_amount = $_POST['copay_amount'][$key];
       
        $autonum = $_POST['autonums'][$key];


        $sele = mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_frequency where frequencynumber='$afrequency'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        $ress = mysqli_fetch_array($sele);
        $frequencyautonumber = $ress['auto_number'];
        $frequencycode = $ress['frequencycode'];
        $pharamcheck = $_POST['pharamcheck'][$key];

        $query23p = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode' and medicineissue='pending' and auto_number='$autonum' and amendstatus!=2";
        $exec23p = mysqli_query($GLOBALS["___mysqli_ston"], $query23p) or die ("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
        $pharmtotalno = mysqli_num_rows($exec23p);
        if ($pharmtotalno != 0) {

            $amendstatus = 3;//exit();
            if ($pharamcheck != '') {
                $amendstatus = 2;
            }

            $pharamapprovalstatus = isset($_POST['pharamcheck'][$key]) ? '1' : '';
            $pharamapprovalstatus = isset($_POST['pharamlatertonow'][$key]) ? '2' : $pharamapprovalstatus;
			//echo $pharamapprovalstatus;
			//exit;
            if ($billingtype != 'PAY NOW') {

                if ($pharamapprovalstatus == '') {

                    $query34 = "update master_consultationpharm set days='$adays',dose='$adose',dosemeasure='$adosemeasure',quantity='$aquantity',route='$aroute',amount='$aamount',frequencyauto_number='$frequencyautonumber',frequencycode='$frequencycode',cash_copay='$copay_amount',frequencynumber='$afrequency',instructions='$ainstructions',amendstatus='" . $amendstatus . "',approver_username='$username',approvalstatus='$pharamapprovalstatus', paymentstatus='pending',pharmacybill='pending' where patientcode='$patientcode' and patientvisitcode='$visitcode' and medicinecode='$aitemcode' and consultation_id='$consid1' and auto_number='$autonum'"; //and amendstatus <> '2'
                    $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                    //echo "<br>";
                    $query35 = "update master_consultationpharmissue set days='$adays',dose='$adose',dosemeasure='$adosemeasure',prescribed_quantity='$aquantity',quantity='$aquantity',route='$aroute',amount='$aamount',frequencyauto_number='$frequencyautonumber',frequencycode='$frequencycode',frequencynumber='$afrequency',instructions='$ainstructions',amendstatus='" . $amendstatus . "',paymentstatus='$status' where patientcode='$patientcode' and patientvisitcode='$visitcode' and medicinecode='$aitemcode' and consultation_id='$consid1' and auto_number='$autonum'"; //and amendstatus <> '2'
                    $exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"]));


                } else if ($pharamapprovalstatus == '2') {

                     $query34 = "update master_consultationpharm set days='$adays',dose='$adose',dosemeasure='$adosemeasure',quantity='$aquantity',route='$aroute',amount='$aamount',cash_copay='$copay_amount',frequencyauto_number='$frequencyautonumber',frequencycode='$frequencycode',frequencynumber='$afrequency',instructions='$ainstructions',amendstatus='" . $amendstatus . "',approver_username='$username',approvalstatus='$pharamapprovalstatus',pharmacybill='pending' where patientcode='$patientcode' and patientvisitcode='$visitcode' and medicinecode='$aitemcode' and consultation_id='$consid1' and auto_number='$autonum'"; //and amendstatus <> '2'
                    $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                    //echo "<br>";
                    $query35 = "update master_consultationpharmissue set days='$adays',dose='$adose',dosemeasure='$adosemeasure',prescribed_quantity='$aquantity',quantity='$aquantity',route='$aroute',amount='$aamount',frequencyauto_number='$frequencyautonumber',frequencycode='$frequencycode',frequencynumber='$afrequency',instructions='$ainstructions',amendstatus='" . $amendstatus . "',approvalstatus='$pharamapprovalstatus',paymentstatus='pending' where patientcode='$patientcode' and patientvisitcode='$visitcode' and medicinecode='$aitemcode' and consultation_id='$consid1' and auto_number='$autonum'"; //and amendstatus <> '2'
                    $exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

//exit;
                } else if ($pharamapprovalstatus == '1' && $planforall != 'yes') {
                    $query34 = "update master_consultationpharm set days='$adays',dose='$adose',dosemeasure='$adosemeasure',quantity='$aquantity',route='$aroute',amount='$aamount',frequencyauto_number='$frequencyautonumber',cash_copay='$copay_amount',frequencycode='$frequencycode',frequencynumber='$afrequency',instructions='$ainstructions',amendstatus='" . $amendstatus . "',approver_username='$username',approvalstatus='$pharamapprovalstatus',pharmacybill='$status',paymentstatus='completed' where patientcode='$patientcode' and patientvisitcode='$visitcode' and medicinecode='$aitemcode' and consultation_id='$consid1' and auto_number='$autonum'"; //and amendstatus <> '2'
                    $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                    //echo "<br>";
                    $query35 = "update master_consultationpharmissue set days='$adays',dose='$adose',dosemeasure='$adosemeasure',prescribed_quantity='$aquantity',quantity='$aquantity',route='$aroute',amount='$aamount',frequencyauto_number='$frequencyautonumber',frequencycode='$frequencycode',frequencynumber='$afrequency',instructions='$ainstructions',amendstatus='" . $amendstatus . "',approvalstatus='$pharamapprovalstatus',paymentstatus='completed' where patientcode='$patientcode' and patientvisitcode='$visitcode' and medicinecode='$aitemcode' and consultation_id='$consid1'"; //and amendstatus <> '2'
                    $exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

                } else if ($pharamapprovalstatus == '1' && $planforall == 'yes') {

                    $query34 = "update master_consultationpharm set days='$adays',dose='$adose',dosemeasure='$adosemeasure',quantity='$aquantity',route='$aroute',amount='$aamount',frequencyauto_number='$frequencyautonumber',cash_copay='$copay_amount',frequencycode='$frequencycode',frequencynumber='$afrequency',instructions='$ainstructions',amendstatus='" . $amendstatus . "',paymentstatus='$status',pharmacybill='$status',approver_username='$username' where patientcode='$patientcode' and patientvisitcode='$visitcode' and medicinecode='$aitemcode' and consultation_id='$consid1' and auto_number='$autonum'"; //and amendstatus <> '2'
                    $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
//echo "<br>";
                    $query35 = "update master_consultationpharmissue set days='$adays',dose='$adose',dosemeasure='$adosemeasure',prescribed_quantity='$aquantity',quantity='$aquantity',route='$aroute',amount='$aamount',frequencyauto_number='$frequencyautonumber',frequencycode='$frequencycode',frequencynumber='$afrequency',instructions='$ainstructions',amendstatus='" . $amendstatus . "',paymentstatus='$status' where patientcode='$patientcode' and patientvisitcode='$visitcode' and medicinecode='$aitemcode' and consultation_id='$consid1' and auto_number='$autonum'"; //and amendstatus <> '2'
                    $exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"]));


                }

//echo $query34."<br>";
//echo $query35."<br>";
            } else {

                $query34 = "update master_consultationpharm set days='$adays',dose='$adose',dosemeasure='$adosemeasure',quantity='$aquantity',route='$aroute',amount='$aamount',frequencyauto_number='$frequencyautonumber',cash_copay='$copay_amount',frequencycode='$frequencycode',frequencynumber='$afrequency',instructions='$ainstructions',amendstatus='" . $amendstatus . "',paymentstatus='$status',pharmacybill='$status',approver_username='$username' where patientcode='$patientcode' and patientvisitcode='$visitcode' and medicinecode='$aitemcode' and consultation_id='$consid1' and auto_number='$autonum'"; //and amendstatus <> '2'
                $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
//echo "<br>";
                $query35 = "update master_consultationpharmissue set days='$adays',dose='$adose',dosemeasure='$adosemeasure',prescribed_quantity='$aquantity',quantity='$aquantity',route='$aroute',amount='$aamount',frequencyauto_number='$frequencyautonumber',frequencycode='$frequencycode',frequencynumber='$afrequency',instructions='$ainstructions',amendstatus='" . $amendstatus . "',paymentstatus='$status' where patientcode='$patientcode' and patientvisitcode='$visitcode' and medicinecode='$aitemcode' and consultation_id='$consid1' and auto_number='$autonum'"; //and amendstatus <> '2'
                $exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"]));


            }
        } else {
			//cash copay update
			$pharamapprovalstatus = isset($_POST['pharamcheck'][$key]) ? '1' : '';
				$pharamapprovalstatus = isset($_POST['pharamlatertonow'][$key]) ? '2' : $pharamapprovalstatus;
			
			$aproval_status=$pharamapprovalstatus;
				if ($pharamcheck != '' && $pharamapprovalstatus!='') {
                //$amendstatus = 2;
			    if ($billingtype != 'PAY NOW') {
    				if($copay_amount>0)
    				{
    				 $status='pending';
    				 $pharamapprovalstatus='2';
    				}else
    				{
    				 //$status='completed';
    				 if (($planpercentage > 0.00 && $forall != '')) 
							{
								$status = 'pending';
								$aproval_status='';
							} else {
								$status = 'completed';
							}
    				}
				}
				else
				{
					$status='pending';
				}
				$query34 = "update master_consultationpharm set cash_copay='$copay_amount',approver_username='$username',pharmacybill='$status',paymentstatus='$status',approvalstatus='$aproval_status' where patientcode='$patientcode' and patientvisitcode='$visitcode' and medicinecode='$aitemcode' and consultation_id='$consid1' and auto_number='$autonum'"; //and amendstatus <> '2'
				$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$query35 = "update master_consultationpharmissue set paymentstatus='$status' where patientcode='$patientcode' and patientvisitcode='$visitcode' and medicinecode='$aitemcode' and consultation_id='$consid1' "; //and amendstatus <> '2'
            $exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				}
		}
//exit;

//exit();
        $query221 = "select * from master_consultationpharm where patientcode='$patientcode' and patientvisitcode='$visitcode' ";
        $exec221 = mysqli_query($GLOBALS["___mysqli_ston"], $query221) or die ("Error in Query221" . mysqli_error($GLOBALS["___mysqli_ston"]));
        $rowcount221 = mysqli_num_rows($exec221);
        $res221 = mysqli_fetch_array($exec221);
        $patientauto_number = $res221['patientauto_number'];
        $patientvisitauto_number = $res221['patientvisitauto_number'];
        $consultationid = $res221['consultation_id'];


        $query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by auto_number desc";
        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
        $res1 = mysqli_fetch_array($exec1);

        $locationname = $res1["locationname"];
        $locationcode = $res1["locationcode"];


        
    }


			foreach ($_POST['aitemcode'] as $key => $value) {
            $p = $key;
            $medicinename = $_REQUEST['medicinename'][$p];
            $query77 = "select * from master_medicine where itemname='$medicinename'";
            $exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77);
            $res77 = mysqli_fetch_array($exec77);
            $medicinecode = $_REQUEST['aitemcode'][$p];
            $dose = $_REQUEST['adose'][$p];
            $dosemeasure = $_REQUEST['adosemeasure'][$p];
            $adosemeasure = $_REQUEST['adosemeasure'][$p];
            $afrequency = $_REQUEST['afrequency'][$p];
            /* $sele=mysql_query("select * from master_frequency where frequencycode='$afrequency'") or die(mysql_error());
             $ress=mysql_fetch_array($sele);
             $frequencyautonumber=$ress['auto_number'];
             $frequencycode=$ress['frequencycode'];*/
            //echo "select * from master_frequency where frequencynumber='$afrequency'";
            $sele = mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_frequency where frequencynumber='$afrequency'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
            $ress = mysqli_fetch_array($sele);
            $frequencyautonumber = $ress['auto_number'];
            $frequencycode = $_REQUEST['frequency'][$p];
            $frequencynumber = $_REQUEST['afrequency'][$p];
            $days = $_REQUEST['adays'][$p];
            $quantity = $_REQUEST['aquantity'][$p];
            $route = $_REQUEST['aroute'][$p];
            $instructions = $_REQUEST['ainstructions'][$p];
            $rate = preg_replace('[,]', '', $_REQUEST['rates'][$p]);
            $amount = $_REQUEST['amount'][$p];
            //exit();
            $pharamcheck = $_POST['pharamcheck'][$key];
            $amendstatus = 3;
            if ($pharamcheck != '') {
                $amendstatus = 2;
            }
            if ($amendstatus == 2) {
                mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set overallpayment='' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
            }
            //if ($medicinename != "" && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
            if ($medicinename != "" && !isset($_POST['old_item'][$p]))// && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
            {
                
                $querytype = "select type from master_medicine where itemcode='$medicinecode' and status =''";
		$exectype = mysqli_query($GLOBALS["___mysqli_ston"], $querytype);
		$restype = mysqli_fetch_array($exectype);
		$drugtype = $restype['type'];
		
		if($drugtype=='DRUGS'){
		$querytype = "select drugs_store from master_location where locationcode='$locationcode' ";
		$exectype = mysqli_query($GLOBALS["___mysqli_ston"], $querytype);
		$restype = mysqli_fetch_array($exectype);
		$store = $restype['drugs_store'];
		} elseif($drugtype=='NON DRUGS'){
		$querytype = "select nondrug_store from master_location where locationcode='$locationcode'";
		$exectype = mysqli_query($GLOBALS["___mysqli_ston"], $querytype);
		$restype = mysqli_fetch_array($exectype);
		$store = $restype['nondrug_store'];	
		}
                //echo '<br>'.
                $query2 = "insert into master_consultationpharm(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,medicinename,dose,frequencyauto_number,frequencycode,frequencynumber,days,quantity,instructions,rate,amount,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,medicinecode,refno,pharmacybill,medicineissue,source,route,amendstatus,locationname,locationcode,dosemeasure,approver_username,store) 
				values('$consultationid','$patientcode','$patientauto_number','$patientname','$patientvisitauto_number','$visitcode','$medicinename','$dose','$frequencyautonumber','$frequencycode','$frequencynumber','$days','$quantity','$instructions','$rate','$amount','completed','$consultationdate','$ipaddress','$consultingdoctor','$billtype','$accountname','$status','$medicinecode','$medrefnonumber','$status','pending','doctorconsultation','$route','" . $amendstatus . "','" . $locationname . "','" . $locationcode . "','" . $dosemeasure . "','$username','$store')";
                $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2" . mysqli_error($GLOBALS["___mysqli_ston"]));
                //echo "<br>";
                $query29 = "insert into master_consultationpharmissue(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,medicinename,dose,frequencyauto_number,frequencycode,frequencynumber,days,quantity,instructions,rate,amount,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,medicinecode,refno,prescribed_quantity,source,route,amendstatus,locationname,locationcode,dosemeasure,store) 
				values('$consultationid','$patientcode','$patientauto_number','$patientname','$patientvisit','$visitcode','$medicinename','$dose','$frequencyautonumber','$frequencycode','$frequencynumber','$days','$quantity','$instructions','$rate','$amount','completed','$consultationdate','$ipaddress','$consultingdoctor','$billtype','$accountname','$status','$medicinecode','$medrefnonumber','$quantity','doctorconsultation','$route','" . $amendstatus . "','" . $locationname . "','" . $locationcode . "','" . $dosemeasure . "','$store')";
                $exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29) or die ("Error in Query29" . mysqli_error($GLOBALS["___mysqli_ston"]));

            }
        }//exit();

    header("location:amend_pending_pharmacy_page.php");
    exit;

}


//to redirect if there is no entry in masters category or item or customer or settings


//To get default tax from autoitemsearch1.php and autoitemsearch2.php - for CST tax override.
if (isset($_REQUEST["defaulttax"])) {
    $defaulttax = $_REQUEST["defaulttax"];
} else {
    $defaulttax = "";
}
if (isset($_REQUEST['delete'])) {
    $medicinename = $_REQUEST['delete'];
    $viscode = $_REQUEST['visitcode'];


    $data = mysqli_query($GLOBALS["___mysqli_ston"], "select auto_number,patientcode,patientvisitcode,patientname,refno,medicinecode,medicinename,quantity,rate,amount,medicineissue from master_consultationpharm where auto_number='$medicinename' and patientvisitcode='$viscode'");
    $data1 = mysqli_fetch_array($data);
    $patientname = $data1['patientname'];
    $patientcode = $data1['patientcode'];
    $visitcode = $data1['patientvisitcode'];
    $refno = $data1['refno'];
    $medicinecode = $data1['medicinecode'];
    $medicinename1 = $data1['medicinename'];
    $medicineissue = $data1['medicineissue'];
    $rate = $data1['rate'];

    $pharmquantity = $data1['quantity'];

    $pharmamount = $data1['amount'];
$query2_1 = "select * from billing_paynowpharmacy where patientcode='$patientcode' and patientvisitcode='$visitcode' and medicinecode='$medicinecode'";
        $exec2_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query2_1) or die ("Error in query2_1" . mysqli_error($GLOBALS["___mysqli_ston"]));
        $cash_received_count = mysqli_num_rows($exec2_1);
        //echo $cash_received_count.$medicineissue;exit;
		if(($cash_received_count==0)||($medicineissue=='pending')){

    $autonum = $data1['auto_number'];
    $date = date('Y-m-d');
    $time = date('H:i:s');

    $remarks = stripslashes(urldecode($_REQUEST['remarks-' . $medicinename]));

    if ($medicinecode <> '') {
        $query = "insert into amendment_details (patientcode,visitcode,patientname,refno,itemcode,itemname,rate,qty,amount,amenddate,amendtime,amendfrom,amendby,ipaddress,remarks) values ('$patientcode','$visitcode','$patientname','$refno','$medicinecode','$medicinename1','$rate','$pharmquantity','$pharmamount','$date','$time','Pharmacy','$username','$ipaddress','$remarks')";
        mysqli_query($GLOBALS["___mysqli_ston"], $query) or die("Error in query" . mysqli_error($GLOBALS["___mysqli_ston"]));
    }


    $query788 = "delete from master_consultationpharm where auto_number='$medicinename' and patientvisitcode='$viscode' and (( billtype ='PAY NOW' and pharmacybill <> 'completed' and medicineissue <> 'completed') or ( billtype ='PAY LATER' and medicineissue <> 'completed'))";
    mysqli_query($GLOBALS["___mysqli_ston"], $query788);

    $query789 = "delete from master_consultationpharmissue where auto_number='$medicinename' and patientvisitcode='$viscode' and ( billtype ='PAY NOW' or  billtype ='PAY LATER')";
    mysqli_query($GLOBALS["___mysqli_ston"], $query789);
//echo $cash_received_count.$medicineissue;exit;
    header('location:amendpharmacy_page.php?patientcode=' . $patientcode . '&visitcode=' . $visitcode . '&selectpending=' . $selectpending);
}else
{
   header('location:amendpharmacy_page.php?patientcode=' . $patientcode . '&visitcode=' . $visitcode . '&selectpending=' . $selectpending);  
}

}
//$defaulttax = $_REQUEST["defaulttax"];
if ($defaulttax == '') {
    $_SESSION["defaulttax"] = '';
} else {
    $_SESSION["defaulttax"] = $defaulttax;
}
if (isset($_REQUEST["patientcode"])) {
    $patientcode = $_REQUEST["patientcode"];
    $visitcode = $_REQUEST["visitcode"];
}


//This include updatation takes too long to load for hunge items database.


//To populate the autocompetelist_services1.js


//To verify the edition and manage the count of bills.
$thismonth = date('Y-m-');
$query77 = "select * from master_edition where status = 'ACTIVE'";
$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77" . mysqli_error($GLOBALS["___mysqli_ston"]));
$res77 = mysqli_fetch_array($exec77);
$res77allowed = $res77["allowed"];


/*
$query99 = "select count(auto_number) as cntanum from master_quotation where quotationdate like '$thismonth%'";
$exec99 = mysql_query($query99) or die ("Error in Query99".mysql_error());
$res99 = mysql_fetch_array($exec99);
$res99cntanum = $res99["cntanum"];
$totalbillandquote = $res88cntanum + $res99cntanum; //total of bill and quote in current month.
if ($totalbillandquote > $res77allowed)
{
	//header ("location:usagelimit1.php"); // redirecting.
	//exit;
}
*/

//To Edit Bill
if (isset($_REQUEST["delbillst"])) {
    $delbillst = $_REQUEST["delbillst"];
} else {
    $delbillst = "";
}
//$delbillst = $_REQUEST["delbillst"];
if (isset($_REQUEST["delbillautonumber"])) {
    $delbillautonumber = $_REQUEST["delbillautonumber"];
} else {
    $delbillautonumber = "";
}
//$delbillautonumber = $_REQUEST["delbillautonumber"];
if (isset($_REQUEST["delbillnumber"])) {
    $delbillnumber = $_REQUEST["delbillnumber"];
} else {
    $delbillnumber = "";
}
//$delbillnumber = $_REQUEST["delbillnumber"];

if (isset($_REQUEST["frm1submit1"])) {
    $frm1submit1 = $_REQUEST["frm1submit1"];
} else {
    $frm1submit1 = "";
}
//$frm1submit1 = $_REQUEST["frm1submit1"];


if (isset($_REQUEST["st"])) {
    $st = $_REQUEST["st"];
} else {
    $st = "";
}
//$st = $_REQUEST["st"];
if (isset($_REQUEST["banum"])) {
    $banum = $_REQUEST["banum"];
} else {
    $banum = "";
}
//$banum = $_REQUEST["banum"];
if ($st == '1') {
    $errmsg = "Success. New Bill Updated. You May Continue To Add Another Bill.";
    $bgcolorcode = 'success';
}
if ($st == '2') {
    $errmsg = "Failed. New Bill Cannot Be Completed.";
    $bgcolorcode = 'failed';
}
if ($st == '1' && $banum != '') {
    $loadprintpage = 'onLoad="javascript:loadprintpage1()"';
}

if ($delbillst == "" && $delbillnumber == "") {
    $res41customername = "";
    $res41customercode = "";
    $res41tinnumber = "";
    $res41cstnumber = "";
    $res41address1 = "";
    $res41deliveryaddress = "";
    $res41area = "";
    $res41city = "";
    $res41pincode = "";
    $res41billdate = "";
    $billnumberprefix = "";
    $billnumberpostfix = "";
}


?>

<?php
$query78 = "select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res78 = mysqli_fetch_array($exec78);
//$patientage=$res78['age'];
$patientgender = $res78['gender'];
$subtypeanum = $res78['subtype'];
$patientname = $res78['patientfullname'];
$patientaccount = $res78['accountfullname'];
$consultationdate = $res78['consultationdate'];
$accname = $res78['accountname'];
$visit_planpercentage = $res78['planpercentage'];

$query112 = "select iscapitation from master_accountname where auto_number = '$accname'";
$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112" . mysqli_error($GLOBALS["___mysqli_ston"]));
$res112 = mysqli_fetch_array($exec112);
$iscapitation = $res112['iscapitation'];
$iscapitation_f = $res112['iscapitation'];

$query111 = "select * from master_customer where customercode = '$patientcode'";
$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111" . mysqli_error($GLOBALS["___mysqli_ston"]));
$res111 = mysqli_fetch_array($exec111);
$dob = $res111['dateofbirth'];

if ($dob > '0000-00-00') {
    $today = new DateTime($consultationdate);
    $diff = $today->diff(new DateTime($dob));
    $patientage = format_interval($diff);
} else {
    $patientage = '<font color="red">DOB Not Found.</font>';
}


function format_interval(DateInterval $interval)
{
    $result = "";
    if ($interval->y) {
        $result .= $interval->format("%y Years ");
    }
    if ($interval->m) {
        $result .= $interval->format("%m Months ");
    }
    if ($interval->d) {
        $result .= $interval->format("%d Days ");
    }

    return $result;
}

$query131 = "select * from master_subtype where auto_number = '$subtypeanum'";
$exec131 = mysqli_query($GLOBALS["___mysqli_ston"], $query131) or die ("Error in Query131" . mysqli_error($GLOBALS["___mysqli_ston"]));
$res131 = mysqli_fetch_array($exec131);
$res131subtype = $res131['subtype'];
?>

<?php


$querylab7 = mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'");
$execlab7 = mysqli_fetch_array($querylab7);
$billtype = $execlab7['billtype'];
$plannamenew = $execlab7['planname'];
$consultationfees = $execlab7['consultationfees'];
$totaliplimit = $execlab7['availablelimit'];

$totalserivces = 0;
$avaliable_limit_op = 0;
$visit_planforall='';
if ($billtype == 'PAY LATER') {
    $query222 = "select overalllimitop,opvisitlimit,planfixedamount,forall from master_planname where auto_number = '$plannamenew'";
    $exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    $res222 = mysqli_fetch_array($exec222);
    $overalllmt = $res222['overalllimitop'];
    $opvisitlimit = $res222['opvisitlimit'];
    $planfixedamount = $res222['planfixedamount'];
    $visit_planforall = $res222['forall'];
    //$totaliplimit = $overalllmt + $opvisitlimit + $planfixedamount;

   $pharmrefund=0;
		$pharmcalcrate=0;
		$querybilpharm="select (amount-cash_copay) as pharmrate,medicinecode from master_consultationpharm  where patientcode = '$res1customercode' and  patientvisitcode='$visitcode' and  (paymentstatus = 'completed' and  approvalstatus <> '2') ";
		$execbilpharm=mysqli_query($GLOBALS["___mysqli_ston"], $querybilpharm) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		while ($resbilpharm=mysqli_fetch_array($execbilpharm))
		{
		$pharmrate=$resbilpharm['pharmrate'];
		$medicinecode=$resbilpharm['medicinecode'];
		$querybilpharm1="select totalamount as refundpharm from pharmacysalesreturn_details  where patientcode = '$res1customercode' and  visitcode='$visitcode' and itemcode ='".$medicinecode."' ";
		$execbilpharm1=mysqli_query($GLOBALS["___mysqli_ston"], $querybilpharm1) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		while ($resbilpharm1=mysqli_fetch_array($execbilpharm1))
		{
		$pharmrate1=$resbilpharm1['refundpharm'];
		$pharmrefund=$pharmrefund+$pharmrate1;
		}
		$pharmcalcrate=$pharmcalcrate+($pharmrate-$pharmrefund);
		}

    $query67 = "select sum(amount-cash_copay) as serviceamt from consultation_services where patientcode='$patientcode' and patientvisitcode='$visitcode' and paymentstatus='completed'";
    $exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]) . __LINE__);
    $num67 = mysqli_fetch_array($exec67);
    $serviceamt = $num67['serviceamt'];

    $query67 = "select sum(labitemrate-cash_copay) as labamt from consultation_lab where patientcode='$patientcode' and patientvisitcode='$visitcode'  and labrefund<>'refund' and paymentstatus='completed'";
    $exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]) . __LINE__);
    $num67 = mysqli_fetch_array($exec67);
    $labamt = $num67['labamt'];

    $query67 = "select sum(radiologyitemrate-cash_copay) as radamt from consultation_radiology where patientcode='$patientcode' and patientvisitcode='$visitcode' and paymentstatus='completed' ";
    $exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]) . __LINE__);
    $num67 = mysqli_fetch_array($exec67);
    $radamt = $num67['radamt'];
    $totalserivces = $consultationfees + $serviceamt + $labamt + $radamt+$pharmcalcrate;
    $avaliable_limit_op = $totaliplimit - $totalserivces;
}

?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3" . mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$labprefix = $res3['labprefix'];

$query2 = "select * from billing_lab order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2" . mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billnumber"];
if ($billnumber == '') {
    $billnumbercode = $labprefix . '00000001';
    $openingbalance = '0.00';
} else {
    $billnumber = $res2["billnumber"];
    $billnumbercode = substr($billnumber, 3, 8);
    $billnumbercode = intval($billnumbercode);
    $billnumbercode = $billnumbercode + 1;

    $maxanum = $billnumbercode;
    if (strlen($maxanum) == 1) {
        $maxanum1 = '0000000' . $maxanum;
    } else if (strlen($maxanum) == 2) {
        $maxanum1 = '000000' . $maxanum;
    } else if (strlen($maxanum) == 3) {
        $maxanum1 = '00000' . $maxanum;
    } else if (strlen($maxanum) == 4) {
        $maxanum1 = '0000' . $maxanum;
    } else if (strlen($maxanum) == 5) {
        $maxanum1 = '000' . $maxanum;
    } else if (strlen($maxanum) == 6) {
        $maxanum1 = '00' . $maxanum;
    } else if (strlen($maxanum) == 7) {
        $maxanum1 = '0' . $maxanum;
    } else if (strlen($maxanum) == 8) {
        $maxanum1 = $maxanum;
    }

    $billnumbercode = $labprefix . $maxanum1;
    $openingbalance = '0.00';
    //echo $companycode;
}
?>

<script language="javascript">
    function grandtotl(vrate) {
        var varserRate = vrate;

        if (document.getElementById('grandtotal').value == '') {
            grandtotal = 0;
        } else {
            grandtotal = document.getElementById('grandtotal').value;
        }
        grandtotal = grandtotal.replace(/,/g, '');
        grandtotal = parseInt(grandtotal, 10);
        grandtotal = parseInt(grandtotal) + parseInt(varserRate);
        document.getElementById("grandtotal").value = grandtotal.toFixed(2);

    }
	
	function cashcopay_coll(ser){
		var serial=ser;		
		var cash_copay_amt=0;
		var amd_status = document.getElementById('item_amendstatus'+serial).value;
		var item_plan = document.getElementById('item_plan'+serial).value;
		var item_cashcopaycollected = document.getElementById('item_copaycollected'+serial).value;
		
		if(item_cashcopaycollected>0){
		alert('For This Item Cash Copay Already Collected.');
		return false;
		}else if(item_plan=='yes'){
		alert('The patient has already copay percentage plan. It wont Allow you to parcital pay.');
		return false;	
		} else {
		var itemamt = document.getElementById('amount'+serial).value;
		var copayamt = document.getElementById('org_copay_amount'+serial).value;
		if (document.getElementById("pharamlatertonow" + serial).checked == true) {		
		if(copayamt>=0 ){
		cash_copay_amt= itemamt;
		}else{
		cash_copay_amt=copayamt;
		}
		document.getElementById('copay_amount'+serial).readOnly = false;
		document.getElementById('copay_amount'+serial).value = cash_copay_amt;
        }else{
		if(copayamt>0){
		cash_copay_amt=0.00;
		}else{
		cash_copay_amt=0.00;
		}
		document.getElementById('copay_amount'+serial).value = cash_copay_amt;
		document.getElementById('copay_amount'+serial).readOnly = true;	
		}
		}
		
	}
	function check_cashcopay(val,id){
		
		var expt_amount=val;
		var actual_amt = document.getElementById('amount'+id).value;
		console.log(expt_amount);
		console.log(actual_amt);
		if(parseInt(expt_amount)>parseInt(actual_amt)){
			alert('Cash Copay Amount Should Not be More Than Item Amount');
			document.getElementById('copay_amount'+id).value = '0.00';
			return false;
			
		}
	}


    function validcheck() {
        var phcheck = false;
        for (var i = 0; i <= 10; i++) {
            if (document.getElementById("pharamcheck" + i) != null) {
                if (document.getElementById("pharamcheck" + i).checked == true) {
                    phcheck = true;
                }
            }
        }

        var amt = 0;
        var inputs = document.getElementsByTagName("input");


        for (var i = 1; i < 100; i++) {

            /*if(inputs[i].name.indexOf('amount') == 0) {


                 val = parseFloat(inputs[i].value);
                 alert(val+"first");
                 if(val > 0) {
                 amt = parseFloat (amt );
                 amt = amt + val;
                 }
            }*/

            if (document.getElementById("pharamcheck" + i) != null) {
                if (document.getElementById("pharamcheck" + i).checked == true) {

                    if (document.getElementById("pharamlatertonow" + i).checked == true) {

                    } else {
                        var val = document.getElementById("amount" + i).value;

                        if (val > 0) {
                            amt = parseInt(amt);
                            amt = parseInt(amt) + parseInt(val);


                        }
                    }

                }
            }


        }
        if (document.getElementById("billtype").value == "PAY LATER") {
            if (amt > document.getElementById("avaliable_limits").value && document.getElementById("iscapitation").value == 0) {
                alert("Selected items price exceed from available limit.");
                return false;
            }
        }

        if (phcheck == false) {
            alert("Please check checkbox to proceed");
            return false;
        }
		
		for (var j = 1; j <= 100; j++) {
			if(document.getElementById("adays" + j + "").value==''){	
				alert("Days Cannot Be Empty");
				return false;
			}
		}
		
		

        if (confirm("Do You Want To Save The Record? ") == false) {
            document.getElementById("saverequest").disabled = false;
            return false;
        } else {

            document.getElementById("saverequest").disabled = true;
        }
    }

    function frequencyitem() {
        if (document.form1.frequency.value == "select") {
            alert("please select a frequency");
            document.form1.frequency.focus();
            return false;
        }
        return true;
    }

    function Functionfrequency(i) {
        var i = i;
		
		

        var formula = document.getElementById("aformula" + i + "").value;
        
        formula = formula.replace(/\s/g, '');
//alert(formula);
		var org_days = document.getElementById("adays_org" + i + "").value;
		if(document.getElementById("adays" + i + "").value=='0'){	
			alert("Days Cannot Be Zero");
			document.getElementById("adays" + i + "").value=org_days;
			Functionfrequency(i);
			return false;
		}

        console.log(formula);
        if (formula == 'INCREMENT') {
            var ResultFrequency;
            var frequencyanum = document.getElementById("afrequency" + i + "").value;
            var medicinedose = document.getElementById("adose" + i + "").value;
            var VarDays = document.getElementById("adays" + i + "").value;

            if ((frequencyanum != '') && (VarDays != '')) {
                ResultFrequency = medicinedose * frequencyanum * VarDays;
            } else {
                ResultFrequency = 0;
            }
            document.getElementById("aquantity" + i + "").value = ResultFrequency;
            var VarRate = document.getElementById("rate" + i + "").value;
            VarRate = parseFloat(VarRate.replace(/[^0-9\.]+/g, ""));
            var ResultAmount = parseFloat(VarRate * ResultFrequency);
            document.getElementById("amount" + i + "").value = ResultAmount.toFixed(2);
        } else if (formula == 'CONSTANT') {

            var ResultFrequency;
            var strength = document.getElementById("astrength" + i + "").value;
            var frequencyanum = document.getElementById("afrequency" + i + "").value;
            var medicinedose = document.getElementById("adose" + i + "").value;
            var VarDays = document.getElementById("adays" + i + "").value;
            if ((frequencyanum != '') && (VarDays != '')) {
                ResultFrequency = medicinedose * frequencyanum * VarDays / strength;
            } else {
                ResultFrequency = 0;
            }
            //ResultFrequency = parseInt(ResultFrequency);

            ResultFrequency = Math.ceil(ResultFrequency);
            //alert(ResultFrequency);
            document.getElementById("aquantity" + i + "").value = ResultFrequency;


            var VarRate = document.getElementById("rate" + i + "").value;
            VarRate = parseFloat(VarRate.replace(/[^0-9\.]+/g, ""));

            var ResultAmount = parseFloat(VarRate * ResultFrequency);
            document.getElementById("amount" + i + "").value = ResultAmount.toFixed(2);


        }
        totalcal();
    }

    function Functionfrequency1() {
        var formula = document.getElementById("formula").value;
        formula = formula.replace(/\s/g, '');
//alert(formula);
        if (formula == 'INCREMENT') {
            var ResultFrequency;
            var frequencyanum = document.getElementById("frequency").value;
            var medicinedose = document.getElementById("dose").value;
            var VarDays = document.getElementById("days").value;
            if ((frequencyanum != '') && (VarDays != '')) {
                ResultFrequency = medicinedose * frequencyanum * VarDays;
            } else {
                ResultFrequency = 0;
            }
            document.getElementById("quantity").value = ResultFrequency;
            var VarRate = document.getElementById("rates").value;
			VarRate = parseFloat(VarRate.replace(/[^0-9\.]+/g, ""));
            var ResultAmount = parseFloat(VarRate * ResultFrequency);
            document.getElementById("amount").value = ResultAmount.toFixed(2);
        } else if (formula == 'CONSTANT') {
            var ResultFrequency;
            var strength = document.getElementById("strength").value;
            var frequencyanum = document.getElementById("frequency").value;
            var medicinedose = document.getElementById("dose").value;
            var VarDays = document.getElementById("days").value;
            if ((frequencyanum != '') && (VarDays != '')) {
                ResultFrequency = medicinedose * frequencyanum * VarDays / strength;
            } else {
                ResultFrequency = 0;
            }
            //ResultFrequency = parseInt(ResultFrequency);

            ResultFrequency = Math.ceil(ResultFrequency);
            //alert(ResultFrequency);
            document.getElementById("quantity").value = ResultFrequency;


            var VarRate = document.getElementById("rates").value;
			VarRate = parseFloat(VarRate.replace(/[^0-9\.]+/g, ""));
            var ResultAmount = parseFloat(VarRate * ResultFrequency);
            document.getElementById("amount").value = ResultAmount.toFixed(2);

        }
    }

    function totalcal() {
        var amt = 0;
        var inputs = document.getElementsByTagName("input");
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].name.indexOf('amount') == 0) {
                val = parseFloat(inputs[i].value);
                if (val > 0) {
                    amt = parseFloat(amt);
                    amt = amt + val;
                }
            }
        }
        document.getElementById("totaldb").value = amt;
    }

    function deletevalid(id, patient, visit, type) {
        var msg = document.getElementById('remarks-' + id).value;
        if (msg.trim() == '') {
            alert("Must have remarks.");
            document.getElementById('remarks-' + id).focus();

            return false;
        }
        var del;
        del = confirm("Do You want to delete this medicine ?");
        if (del == false) {
            return false;
        } else {
            window.location = 'amendpharmacy_page.php?delete=' + id + '&patientcode=' + patient + '&&visitcode=' + visit + '&remarks-' + id + '=' + msg + '&selectpending=' + type;

        }
    }

    function btnDeleteClick10(delID, pharmamount) {
        //alert ("Inside btnDeleteClick.");
        var newtotal4;
        //alert(pharmamount);
        var varDeleteID = delID;
        //alert (varDeleteID);
        var fRet3;
        fRet3 = confirm('Are You Sure Want To Delete This Entry?');
        //alert(fRet);
        if (fRet3 == false) {
            //alert ("Item Entry Not Deleted.");
            return false;
        }

        var child = document.getElementById('idTR' + varDeleteID);  //tr name
        var parent = document.getElementById('insertrow'); // tbody name.
        document.getElementById('insertrow').removeChild(child);

        var child = document.getElementById('idTRaddtxt' + varDeleteID);  //tr name
        var parent = document.getElementById('insertrow'); // tbody name.
        //alert (child);
        if (child != null) {
            //alert ("Row Exsits.");
            document.getElementById('insertrow').removeChild(child);


        }
        var currenttotal4 = document.getElementById('total').value;
        //alert(currenttotal);
        newtotal4 = currenttotal4 - pharmamount;

        //alert(newtotal);

        document.getElementById('total').value = newtotal4;


    }

    function btnDeleteClick6(delID1, vrate1, nam) {
        alert("Inside btnDeleteClick.");
        var newtotal3;
        //alert(vrate1);
        var varDeleteID1 = delID1;
        var amount = vrate1;
        //alert(varDeleteID1);
        var fRet4;
        fRet4 = confirm('Are You Sure Want To Delete This Entry?');
        //alert(fRet4);
        if (fRet4 == false) {
            //alert ("Item Entry Not Deleted.");
            return false;
        }

        if (document.getElementById(nam).checked == true) {
            //alert(amount);
            document.getElementById("approvallimit").value = parseFloat(document.getElementById("approvallimit").value) - parseFloat(amount);

        }

//alert(varDeleteID1);
        var child1 = document.getElementById('labidTR' + varDeleteID1);  //tr name
        var parent1 = document.getElementById('insertrow1'); // tbody name.
        document.getElementById('insertrow1').removeChild(child1);

        var child1 = document.getElementById('idTRaddtxt' + varDeleteID1);  //tr name
        var parent1 = document.getElementById('insertrow1'); // tbody name.
        //alert (child);
        if (child1 != null) {
            //alert ("Row Exsits.");
            document.getElementById('insertrow1').removeChild(child1);
        }

        var currenttotal3 = document.getElementById('total1').value;
        //alert(currenttotal);
        newtotal3 = currenttotal3 - vrate1;

        //alert(newtotal3);

        document.getElementById('total1').value = newtotal3.toFixed(2);

        grandtotalminus(vrate1);

    }
    <?php
    if ($delbillst != 'billedit') // Not in edit mode or other mode.
    {
    ?>
    //Function call from billnumber onBlur and Save button click.
    function billvalidation() {
        billnovalidation1();
    }
    <?php
    }
    ?>

    function formatMoney(number, places, thousand, decimal) {

        number = number || 0;

        places = !isNaN(places = Math.abs(places)) ? places : 2;


        thousand = thousand || ",";

        decimal = decimal || ".";

        var negative = number < 0 ? "-" : "",

            i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",

            j = (j = i.length) > 3 ? j % 3 : 0;

        return negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");


    }
	
	
    function funcOnLoadBodyFunctionCall() {


        //funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php

        //To handle ajax dropdown list.
        funcCustomerDropDownSearch4();
        funcPopupPrintFunctionCall();

    }

    function funcPopupPrintFunctionCall() {

        ///*
        //alert ("Auto Print Function Runs Here.");
        <?php
        if (isset($_REQUEST["src"])) {
            $src = $_REQUEST["src"];
        } else {
            $src = "";
        }
        //$src = $_REQUEST["src"];
        if (isset($_REQUEST["st"])) {
            $st = $_REQUEST["st"];
        } else {
            $st = "";
        }
        //$st = $_REQUEST["st"];
        if (isset($_REQUEST["billnumber"])) {
            $previousbillnumber = $_REQUEST["billnumber"];
        } else {
            $previousbillnumber = "";
        }
        //$previousbillnumber = $_REQUEST["billnumber"];
        if (isset($_REQUEST["billautonumber"])) {
            $previousbillautonumber = $_REQUEST["billautonumber"];
        } else {
            $previousbillautonumber = "";
        }
        //$previousbillautonumber = $_REQUEST["billautonumber"];
        if (isset($_REQUEST["companyanum"])) {
            $previouscompanyanum = $_REQUEST["companyanum"];
        } else {
            $previouscompanyanum = "";
        }
        //$previouscompanyanum = $_REQUEST["companyanum"];
        if ($src == 'frm1submit1' && $st == 'success')
        {
        $query1print = "select * from master_printer where defaultstatus = 'default' and status <> 'deleted'";
        $exec1print = mysqli_query($GLOBALS["___mysqli_ston"], $query1print) or die ("Error in Query1print." . mysqli_error($GLOBALS["___mysqli_ston"]));
        $res1print = mysqli_fetch_array($exec1print);
        $papersize = $res1print["papersize"];
        $paperanum = $res1print["auto_number"];
        $printdefaultstatus = $res1print["defaultstatus"];
        if ($paperanum == '1') //For 40 Column paper
        {
        ?>
        //quickprintbill1();
        quickprintbill1sales();
        <?php
        }
        else if ($paperanum == '2') //For A4 Size paper
        {
        ?>
        loadprintpage1('A4');
        <?php
        }
        else if ($paperanum == '3') //For A4 Size paper
        {
        ?>
        loadprintpage1('A5');
        <?php
        }
        }
        ?>
        //*/


    }

    //Print() is at bottom of this page.

</script>
<?php include("js/sales1scripting1.php"); ?>
<script type="text/javascript">

    function loadprintpage1(varPaperSizeCatch) {
        //var varBillNumber = document.getElementById("billnumber").value;
        var varPaperSize = varPaperSizeCatch;
        //alert (varPaperSize);
        //return false;
        <?php
        //To previous js error if empty.
        if ($previousbillnumber == '') {
            $previousbillnumber = 1;
            $previousbillautonumber = 1;
            $previouscompanyanum = 1;
        }
        ?>
        var varBillNumber = document.getElementById("quickprintbill").value;
        var varBillAutoNumber = "<?php //echo $previousbillautonumber; ?>";
        var varBillCompanyAnum = "<?php echo $_SESSION["companyanum"]; ?>";
        if (varBillNumber == "") {
            alert("Bill Number Cannot Be Empty.");//quickprintbill
            document.getElementById("quickprintbill").focus();
            return false;
        }

        var varPrintHeader = "INVOICE";
        var varTitleHeader = "ORIGINAL";
        if (varTitleHeader == "") {
            alert("Please Select Print Title.");
            document.getElementById("titleheader").focus();
            return false;
        }

        //alert (varBillNumber);
        //alert (varPrintHeader);
        //window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');

        if (varPaperSize == "A4") {
            window.open("print_bill1.php?printsource=billpage&&billautonumber=" + varBillAutoNumber + "&&companyanum=" + varBillCompanyAnum + "&&title1=" + varTitleHeader + "&&billnumber=" + varBillNumber + "", "OriginalWindowA4<?php echo $banum; ?>", 'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
        }
        if (varPaperSize == "A5") {
            window.open("print_bill1_a5.php?printsource=billpage&&billautonumber=" + varBillAutoNumber + "&&companyanum=" + varBillCompanyAnum + "&&title1=" + varTitleHeader + "&&billnumber=" + varBillNumber + "", "OriginalWindowA5<?php echo $banum; ?>", 'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
        }
    }

    function cashentryonfocus1() {
        if (document.getElementById("cashgivenbycustomer").value == "0.00") {
            document.getElementById("cashgivenbycustomer").value = "";
            document.getElementById("cashgivenbycustomer").focus();
        }
    }

    function funcDefaultTax1() //Function to CST Taxes if required.
    {
        //alert ("Default Tax");
        <?php
        //delbillst=billedit&&delbillautonumber=13&&delbillnumber=1
        //To avoid change of bill number on edit option after selecting default tax.
        if (isset($_REQUEST["delbillst"])) {
            $delBillSt = $_REQUEST["delbillst"];
        } else {
            $delBillSt = "";
        }
        //$delBillSt = $_REQUEST["delbillst"];
        if (isset($_REQUEST["delbillautonumber"])) {
            $delBillAutonumber = $_REQUEST["delbillautonumber"];
        } else {
            $delBillAutonumber = "";
        }
        //$delBillAutonumber = $_REQUEST["delbillautonumber"];
        if (isset($_REQUEST["delbillnumber"])) {
            $delBillNumber = $_REQUEST["delbillnumber"];
        } else {
            $delBillNumber = "";
        }
        //$delBillNumber = $_REQUEST["delbillnumber"];

        ?>
        var varDefaultTax = document.getElementById("defaulttax").value;
        if (varDefaultTax != "") {
            <?php
            if ($delBillSt == 'billedit')
            {
            ?>
            window.location = "sales1.php?defaulttax=" + varDefaultTax + "&&delbillst=<?php echo $delBillSt; ?>&&delbillautonumber="+<?php echo $delBillAutonumber; ?>+
            "&&delbillnumber="+<?php echo $delBillNumber; ?>+
            "";
            <?php
            }
            else
            {
            ?>
            window.location = "sales1.php?defaulttax=" + varDefaultTax + "";
            <?php
            }
            ?>
        } else {
            window.location = "sales1.php";
        }
        //return false;
    }


    function selectcash(checkname, sno) {

        var sno = sno;
        if (checkname == 'pharam' && document.getElementById("billtype").value == "PAY LATER") {

            if (document.getElementById('pharamcheck' + sno).checked == true) {
                document.getElementById('pharamlatertonow' + sno).disabled = false;

            } else {
                document.getElementById('pharamlatertonow' + sno).checked = false;
                document.getElementById('pharamlatertonow' + sno).disabled = true;
            }
        }
    }
</script>

<?php /*?><?php include ("js/dropdownlist1newscriptingmedicine1.php"); ?>
<script type="text/javascript" src="js/autosuggestnewmedicine1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newmedicineq.js"></script>
<script type="text/javascript" src="js/automedicinecodesearch12_new.js"></script>
<script type="text/javascript" src="js/insertnewitem10.js"></script>
<?php */ ?>

<?php include("js/dropdownlist1newscriptingmedicine1.php"); ?>
<script type="text/javascript" src="js/autosuggestnewmedicine1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newmedicineq.js"></script>
<script type="text/javascript" src="js/automedicinecodesearch12_new.js"></script>
<!--<script type="text/javascript" src="js/insertnewitemforallamendpharam1_amend.js"></script>
-->
<script type="text/javascript" src="js/insertnewitemforallamendpharam1_amend1.js"></script>


<style type="text/css">
    .bodytext3 {
        FONT-WEIGHT: normal;
        FONT-SIZE: 11px;
        COLOR: #3B3B3C;
        FONT-FAMILY: Tahoma
    }

    .bodytext31 {
        FONT-WEIGHT: normal;
        FONT-SIZE: 11px;
        COLOR: #3b3b3c;
        FONT-FAMILY: Tahoma
    }

    .bodytext311 {
        FONT-WEIGHT: normal;
        FONT-SIZE: 11px;
        COLOR: #3b3b3c;
        FONT-FAMILY: Tahoma;
        text-decoration: none
    }

    .bodytext311 {
        FONT-WEIGHT: normal;
        FONT-SIZE: 11px;
        COLOR: #3b3b3c;
        FONT-FAMILY: Tahoma
    }

    .bodytext32 {
        FONT-WEIGHT: normal;
        FONT-SIZE: 11px;
        COLOR: #3B3B3C;
        FONT-FAMILY: Tahoma
    }

    .bodytext312 {
        FONT-WEIGHT: normal;
        FONT-SIZE: 11px;
        COLOR: #3b3b3c;
        FONT-FAMILY: Tahoma
    }

    .bodytextbold3 {
        FONT-WEIGHT: bold;
        FONT-SIZE: 13px;
        COLOR: red;
        FONT-FAMILY: Tahoma
    }

    body {
        margin-left: 0px;
        margin-top: 0px;
        background-color: #ecf0f5;
    }

    .style1 {
        font-size: 36px;
        font-weight: bold;
    }

    .style2 {
        font-size: 18px;
        font-weight: bold;
    }

    .style4 {
        FONT-WEIGHT: bold;
        FONT-SIZE: 11px;
        COLOR: #3B3B3C;
        FONT-FAMILY: Tahoma;
    }

    .style6 {
        FONT-WEIGHT: bold;
        FONT-SIZE: 11px;
        COLOR: #3b3b3c;
        FONT-FAMILY: Tahoma;
        text-decoration: none;
    }

    .bal {
        border-style: none;
        background: none;
        text-align: right;
        FONT-FAMILY: Tahoma;
        FONT-SIZE: 11px;
    }
</style>

<script src="js/datetimepicker_css.js"></script>

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css"/>
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="form1" id="frmsales" method="post" action="amendpharmacy_page.php" onKeyDown=""
      onSubmit="return validcheck()">
    <table width="101%" border="0" cellspacing="0" cellpadding="2">
        <tr>
            <td colspan="9" bgcolor="#ecf0f5"><?php include("includes/alertmessages1.php"); ?></td>
        </tr>
        <tr>
            <td colspan="9" bgcolor="#ecf0f5"><?php include("includes/title1.php"); ?></td>
        </tr>
        <tr>
            <td colspan="9" bgcolor="#ecf0f5"><?php include("includes/menu1.php"); ?></td>
        </tr>
        <!--  <tr>
            <td colspan="10">&nbsp;</td>
          </tr>
        -->
        <tr>
            <td width="1%">&nbsp;</td>
            <td width="99%" valign="top">
                <table width="1031" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                            <table width="99%" border="0" align="left" cellpadding="2" cellspacing="0"
                                   bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                                <tbody>


                                <tr>
                                    <td width="15%" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
                                        <strong>Patient * </strong></td>
                                    <td width="36%" align="left" valign="middle" class="bodytext3">
                                        <input name="customername" id="customer" type="hidden"
                                               value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;"
                                               size="40" autocomplete="off" readonly/><?php echo $patientname; ?>
                                    </td>
                                    <td width="9%" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
                                        <strong>Patient code </strong></td>
                                    <td colspan="3" align="left" valign="middle" class="bodytext3">
                                        <input name="customercode" id="customercode" type="hidden"
                                               value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A"
                                               size="18" rsize="20" readonly/><?php echo $patientcode; ?>

                                        <!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>-->
                                    </td>

                                </tr>
                                <tr>
                                    <td align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3"><span
                                                class="style4"></span><strong>Age &amp; Gender </strong></td>
                                    <td align="left" valign="middle" class="bodytext3">
                                        <input name="patientage" type="hidden" id="patientage"
                                               value="<?php echo $patientage; ?>"
                                               style="border: 1px solid #001E6A;text-transform: uppercase;" size="5"
                                               readonly><?php echo $patientage; ?>
                                        &
                                        <input type="hidden" name="patientgender" id="patientgender"
                                               value="<?php echo $patientgender; ?>"
                                               style="border: 1px solid #001E6A;text-transform: uppercase;" size="5"
                                               readonly><?php echo $patientgender; ?>
                                        <input type="hidden" name="address1" id="address1"
                                               value="<?php echo $res41address1; ?>"
                                               style="border: 1px solid #001E6A;text-transform: uppercase;" size="30"/>
                                        <span class="style4"><!--Area--> </span>
                                        <input type="hidden" name="area" id="area" value="<?php echo $res41area; ?>"
                                               style="border: 1px solid #001E6A;text-transform: uppercase;" size="10"/>
                                        <input type="hidden" name="subtype" id="subtype"
                                               value="<?php echo $res131subtype; ?>">
                                        <input type="hidden" name="subtypeano" id="subtypeano"
                                               value="<?php echo $subtypeanum; ?>">
                                    </td>

                                    <td width="9%" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
                                        <strong>Subtype</strong></td>
                                    <td colspan="3" align="left" valign="middle"
                                        class="bodytext3"><?php echo $res131subtype; ?></td>

                                </tr>

                                <tr>
                                    <td width="9%" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
                                        <strong>Visit Code</strong></td>
                                    <td align="left" valign="top" class="bodytext3">
                                        <input name="visitcode" id="visitcode" type="hidden"
                                               value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A"
                                               size="18" rsize="20" readonly/><?php echo $visitcode; ?></td>


                                    <td width="9%" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
                                        <strong>Account</strong></td>
                                    <td colspan="3" align="left" valign="middle" class="bodytext3">
                                        <input name="account" id="account" type="hidden"
                                               value="<?php echo $patientaccount; ?>" style="border: 1px solid #001E6A"
                                               size="18" rsize="20" readonly/><?php echo $patientaccount; ?>
                                        <input type="hidden" name="billtype" id="billtype"
                                               value="<?php echo $billtype; ?>"></td>


                                </tr>

                                <!-- drug allergy and weight-->
                                <?php
                                $query_allergy = "SELECT drugallergy,weight,bmi,celsius,height,pulse FROM master_triage WHERE patientcode='$patientcode' AND visitcode='$visitcode' ORDER BY auto_number ASC LIMIT 1";
                                $exec_allergy = mysqli_query($GLOBALS["___mysqli_ston"], $query_allergy) or die ("Error in QueryAllegry" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                $nums = mysqli_num_rows($exec_allergy);
                                while ($res_allergy = mysqli_fetch_array($exec_allergy)) {
                                    $drugallergy = $res_allergy['drugallergy'];
                                    $weight = $res_allergy['weight'];
                                    $bmi = $res_allergy['bmi'];
                                    $celsius = $res_allergy['celsius'];
                                    $height = $res_allergy['height'];
                                    $pulse = $res_allergy['pulse'];
                                }
                                $query232 = "SELECT primarydiag,secondarydiag FROM `consultation_icd` WHERE patientcode='$patientcode' and patientvisitcode='$visitcode' order by auto_number desc";
                                $exec232 = mysqli_query($GLOBALS["___mysqli_ston"], $query232) or die ("Error in Query2" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res132 = mysqli_fetch_array($exec232);
                                $res132primarydiag = $res132["primarydiag"];
                                $res132secondarydiag = $res132["secondarydiag"];
                                ?>
                                <tr>
                                    <td width="9%" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
                                        <strong>Drug Allergy</strong></td>
                                    <td align="left" valign="middle" class="bodytext3"><?php if ($drugallergy == '') {
                                            echo "None";
                                        } else {
                                            echo $drugallergy;
                                        } ?></td>

                                    <?php if ($billtype == 'PAY LATER') { ?>
                                        <td width="9%" align="left" valign="middle" bgcolor="#ecf0f5"
                                            class="bodytextbold3"><strong>Available limit</strong></td>
                                        <td align="left" valign="middle"
                                            class="bodytextbold3"><?php echo number_format($avaliable_limit_op, 2, '.', ','); ?> </td>
                                        <input name="avaliable_limits" id="avaliable_limits" type="hidden"
                                               value="<?php echo $avaliable_limit_op; ?>" type='hidden'/>
                                    <?php } else { ?>

                                        <td width="9%" align="left" valign="middle" bgcolor="#ecf0f5"
                                            class="bodytext3"></td>
                                        <td align="left" valign="middle" class="bodytext3"></td>

                                    <?php } ?>
                                    <input name="iscapitation" id="iscapitation" type="hidden"
                                           value="<?php echo $iscapitation; ?>"/>


                                </tr>

                                <tr>


                                    <td width="9%" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
                                        <strong>Weight</strong></td>
                                    <td align="left" valign="middle" class="bodytext3"><?php if ($weight == '') {
                                            echo "--";
                                        } else {
                                            echo $weight;
                                        } ?></td>

                                    <td width="9%" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
                                        <strong>BMI</strong></td>
                                    <td align="left" valign="middle" class="bodytext3"><?php if ($bmi == '') {
                                            echo "--";
                                        } else {
                                            echo $bmi;
                                        } ?></td>

                                </tr>

                                <tr>

                                    <td width="9%" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
                                        <strong>Temperature</strong></td>
                                    <td align="left" valign="middle" class="bodytext3"><?php if ($celsius == '') {
                                            echo "--";
                                        } else {
                                            echo $celsius;
                                        } ?>&deg;
                                    </td>

                                    <td width="9%" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
                                        <strong>Height</strong></td>
                                    <td align="left" valign="middle" class="bodytext3"><?php if ($height == '') {
                                            echo "--";
                                        } else {
                                            echo $height;
                                        } ?></td>

                                </tr>

                                <tr>

                                    <td width="9%" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
                                        <strong>Pulse</strong></td>
                                    <td align="left" valign="middle" class="bodytext3"><?php if ($pulse == '') {
                                            echo "--";
                                        } else {
                                            echo $pulse;
                                        } ?></td>

                                    <td width="9%" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
                                        <strong>Primary Diagnosis</strong></td>
                                    <td colspan="3" align="left" valign="top" class="bodytext3">
                                        <input name="primarydiag" id="primarydiag" type="hidden"
                                               value="<?php echo $res132primarydiag; ?>"
                                               style="border: 1px solid #001E6A" size="18" rsize="20"
                                               readonly/><?php if ($res132primarydiag == '') {
                                            echo "--";
                                        } else {
                                            echo $res132primarydiag;
                                        } ?>

                                </tr>

                                <tr>
                                    <td width="9%" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
                                        <strong>Secondary Diagnosis</strong></td>
                                    <td colspan="1" align="left" valign="top" class="bodytext3">
                                        <input name="secondarydiag" id="secondarydiag" type="hidden"
                                               value="<?php echo $res132secondarydiag; ?>"
                                               style="border: 1px solid #001E6A" size="18" rsize="20"
                                               readonly/><?php if ($res132secondarydiag == '') {
                                            echo "--";
                                        } else {
                                            echo $res132secondarydiag;
                                        } ?>
                                    <td align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
                                        <strong>Store</strong></td>
                                    <?php

                                    $query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by auto_number desc";
                                    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res1 = mysqli_fetch_array($exec1);

                                    $locationname = $res1["locationname"];
                                    $locationcode = $res1["locationcode"];

                                    $query231 = "select * from master_employeelocation where username='$username' and locationcode='" . $locationcode . "' and defaultstore='default' order by locationname";

                                    $exec231 = mysqli_query($GLOBALS["___mysqli_ston"], $query231) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

                                    $res231 = mysqli_fetch_array($exec231);

                                    $res7locationanum1 = $res231['locationcode'];

                                    $location3 = $res231['locationname'];

                                    $storecode_autono = $res231['storecode'];

                                    $query751 = "select * from master_store where auto_number='$storecode_autono'";

                                    $exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

                                    $res751 = mysqli_fetch_array($exec751);

                                    $store = $res751['store'];
                                    $storecode = $res751['storecode'];
                                    ?>
                                    <td align="left" valign="middle" class="bodytext3"><?php echo $store ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <?php
                                        if ($iscapitation_f == '1') { ?>
                                            <p style="color: red; text-align: justify;"><b>Capitation Account, Please
                                                    Inform client about no Refunds on the Medicine after Issue.</b></p>
                                        <?php }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"></td>
                                </tr>
                                </tbody>
                            </table>

                        </td>

                    </tr>

                    <tr>
                        <td>
                            <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse"
                                   bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%"
                                   align="left" border="0">
                                <tbody id="foo">
                                <tr>
                                    <td width="6%" class="bodytext31" valign="center" align="left"
                                        bgcolor="#ffffff">
                                        <div align="center"><strong>No.</strong></div>
                                    </td>
                                    <td width="8%" align="left" valign="center"
                                        bgcolor="#ffffff" class="bodytext31">
                                        <div align="center"><strong>Code </strong></div>
                                    </td>
                                    <td width="8%" align="left" valign="center"
                                        bgcolor="#ffffff" class="bodytext31">
                                        <div align="center"><strong>Medicine Name</strong></div>
                                    </td>
                                    <td width="8%" align="left" valign="center"
                                        bgcolor="#ffffff" class="bodytext31">
                                        <div align="center"><strong>Dose</strong></div>
                                    </td>
                                    <td width="12%" align="left" valign="center"
                                        bgcolor="#ffffff" class="bodytext31">
                                        <div align="center"><strong>Dose Measure</strong></div>
                                    </td>
                                    <td width="8%" align="left" valign="center"
                                        bgcolor="#ffffff" class="bodytext31">
                                        <div align="center"><strong>Freq</strong></div>
                                    </td>

                                    <td width="8%" align="left" valign="center"
                                        bgcolor="#ffffff" class="bodytext31">
                                        <div align="center"><strong>Days </strong></div>
                                    </td>
                                    <td width="3%" align="left" valign="center"
                                        bgcolor="#ffffff" class="bodytext31">
                                        <div align="right"><strong>Qty </strong></div>
                                    </td>

                                    <td width="3%" align="left" valign="center"
                                        bgcolor="#ffffff" class="bodytext31">
                                        <div align="right"><strong>Avl.Qty </strong></div>
                                    </td>
                                    <td width="13%" align="left" valign="center"
                                        bgcolor="#ffffff" class="bodytext31">
                                        <div align="center"><strong>Route </strong></div>
                                    </td>
                                    <td width="8%" align="left" valign="center"
                                        bgcolor="#ffffff" class="bodytext31">
                                        <div align="center"><strong>Instructions </strong></div>
                                    </td>
                                    <td width="8%" align="left" valign="center"
                                        bgcolor="#ffffff" class="bodytext31">
                                        <div align="center"><strong>Consulting</strong></div>
                                    </td>
                                    <td width="8%" align="left" valign="center"
                                        bgcolor="#ffffff" class="bodytext31">
                                        <div align="center"><strong>Rate </strong></div>
                                    </td>
                                    <td width="8%" align="left" valign="center"
                                        bgcolor="#ffffff" class="bodytext31">
                                        <div align="center"><strong>Amount </strong></div>
                                    </td>
                                    <td width="13%" align="left" valign="center"

                                        bgcolor="#ffffff" class="bodytext31">
                                        <div align="center"><strong>Delete Remarks </strong></div>
                                    </td>
                                    <td width="15%" align="left" valign="center"
                                        bgcolor="#ffffff" class="bodytext31">
                                        <div align="center"><strong>Action </strong></div>
                                    </td>
                                    <td width="15%" align="left" valign="center"
                                        bgcolor="#ffffff" class="bodytext31">
                                        <div align="center"><strong>Cash </strong></div>
                                    </td>
									<td width="8%" align="left" valign="center"
                                        bgcolor="#ffffff" class="bodytext31">
                                        <div align="center"><strong>Cash Copay </strong></div>
                                    </td>
                                </tr>
                                <?php
                                $colorloopcount = '';
                                $sno = '';
                                $totalamount = 0;
                                $totalpharmrate = 0;
                                $totalpharmamount = 0;
                                if ($billtype == 'PAY NOW') {
                                    $status = 'pending';
                                    $query17 = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode' and pharmacybill='$status' and medicineissue='pending' and amendstatus='$selectpending' and store='$storecode'";
                                } else {
                                    $status = 'completed';
                                    $query17 = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode' and medicineissue='pending' and amendstatus='$selectpending' and store='$storecode' ";
                                }


                                $exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                $nums = mysqli_num_rows($exec17);
                                while ($res17 = mysqli_fetch_array($exec17)) {

                                    $paharmitemname = $res17['medicinename'];
                                    $pharmitemcode = $res17['medicinecode'];
                                    $pharmdose = $res17['dose'];
                                    $pharmfrequency = $res17['frequencynumber'];
                                    $pharmdays = $res17['days'];
                                    $pharmquantity = $res17['quantity'];
                                    $pharmitemrate = $res17['rate'];
                                    $pharmamount = $res17['amount'];
                                    $appr_stat = $res17['approvalstatus'];
                                    $totalpharmamount = $totalpharmamount + $pharmamount;

                                    $totalpharmrate = $totalpharmrate + $pharmitemrate;

                                    $route = $res17['route'];
                                    $instructions = $res17['instructions'];
                                    $medanum = $res17['auto_number'];
                                    $dosemeasure = $res17['dosemeasure'];
                                    $consid = $res17['consultation_id'];
                                    $username = $res17['consultingdoctor'];
                                    $cash_copay = $res17['cash_copay'];
                                    $amendstatus = $res17['amendstatus'];
                                    $itemcash_copay = $res17['cash_copay'];
                                    $billtype = $res17['billtype'];
                                    $billing = $res17['billing'];

                                    $query77 = "select * from master_medicine where itemcode='$pharmitemcode'";
                                    $exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77);
                                    $res77 = mysqli_fetch_array($exec77);
                                    $formula = $res77['formula'];
                                    $strength = $res77['roq'];
									
									
									//cash copay if already collected
									$query171 = "select count(auto_number) as copayamount from billing_paynowpharmacy where patientvisitcode='$visitcode' and patientcode='$patientcode' and medicinecode='$pharmitemcode'  and amount='$itemcash_copay'";
									$exec171  = mysqli_query($GLOBALS["___mysqli_ston"], $query171) or die ("Error in Query171" . mysqli_error($GLOBALS["___mysqli_ston"]));
									$nums171 = mysqli_num_rows($exec171);
									$res171 = mysqli_fetch_array($exec171);
									$alreadycoll = $res171['copayamount'];
									
									//checking the loop for direct patient and for paylater
									$checkpaymentdonerow=1;
									
									if($billtype=='PAY LATER' && $visit_planpercentage>0 && $visit_planforall=='yes' && $billing!=''){
										$checkpaymentdonerow=0;	
									}else if($itemcash_copay!='0' && $billing!='' && $billtype=='PAY LATER' ){
										$checkpaymentdonerow=0;
									}
									//end
									
									if($checkpaymentdonerow==1){
                                    $colorloopcount = $colorloopcount + 1;
                                    $showcolor = ($colorloopcount & 1);
                                    if ($showcolor == 0) {
                                        //echo "if";
                                        $colorcode = 'bgcolor="#CBDBFA"';
                                    } else {
                                        //echo "else";
                                        $colorcode = 'bgcolor="#ecf0f5"';
                                    }
                                    $totalamount = $totalamount + $pharmitemrate;
                                    $totalamount = number_format($totalamount, 2);
                                    ?>
                                    <tr <?php echo $colorcode; ?>>

                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="center"><?php $sno = $sno + 1; ?>
                                                <input id="pharamcheck<?php echo $sno; ?>"name="pharamcheck[<?php echo $sno; ?>]" type="checkbox" align="left" size="10" value="<?php echo $sno; ?>" 
                                                <?php if(($appr_stat=='1')||($amendstatus=='2')){ ?>checked  onclick="return false;" <?php } ?>
                                                       style="border: 0px solid rgb(0, 30, 106); text-align: left; background-color: rgb(255, 255, 255);"
                                                       onClick="selectcash('pharam','<?php echo $sno; ?>')">
                                                <?php echo $sno; ?></div>
                                        </td>
                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="center"><?php echo $pharmitemcode; ?>
                                                <input type="hidden" name="aitemcode[<?php echo $sno; ?>]"
                                                       id="aitemcode<?php echo $sno; ?>"
                                                       value="<?php echo $pharmitemcode; ?>">
                                                <input type="hidden" name="old_item[<?php echo $sno; ?>]"
                                                       id="old_item<?php echo $sno; ?>"
                                                       value="true">
                                                <input type="hidden" name="consid[<?php echo $sno; ?>]"
                                                       id="consid<?php echo $sno; ?>" value="<?= $consid; ?>">
                                            </div>
                                        </td>
                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="center"><?php echo $paharmitemname; ?></div>
                                        </td>
                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="center">
                                                <input type="number" name="adose[<?php echo $sno; ?>]" id="adose<?php echo $sno; ?>" onKeyUp="return Functionfrequency('<?php echo $sno; ?>')" value="<?php echo $pharmdose; ?>" size="8" style="text-align:center;">
												<input type="hidden" name="adays_org[<?php echo $sno; ?>]" id="adays_org<?php echo $sno; ?>" onKeyUp="return Functionfrequency('<?php echo $sno; ?>')" value="<?php echo $pharmdose; ?>" size="8" style="text-align:center;" ></div>
                                        </td>
                                        <td valign="center" align="left">
                                            <div align="center">
                                                <!--
                      	 <select name="adosemeasure[<?php echo $sno; ?>]" id="dosemeasure<?php echo $sno; ?>" >

                       <?php
                                                // 	   				if ($dosemeasure == '')
                                                // {
                                                // 	echo '<option value="" selected="selected">Select Measure</option>';
                                                // }
                                                // else
                                                // {
                                                ?>   <option value="<?php echo $dosemeasure ?>"><?php echo $dosemeasure ?></option>
                    <?php
                                                // }

                                                ?>
					  <option value="suppositories">suppositories</option>
					   <option value="tabs">tabs</option>
					   <option value="caps">caps</option>
					   <option value="ml">ml</option>
					   <option value="vial">vial</option>
					   <option value="inj">inj</option>
					   <option value="amp">amp</option>
					    <option value="gel">Gel</option>
					   <option value="tube">tube</option>
					   <option value="mg">mg</option>
					   <option value="drops">drops</option>
					   <option value="pcs">pcs</option>
					   </select> -->
                                                <select name="adosemeasure[<?php echo $sno; ?>]"
                                                        id="dosemeasure<?php echo $sno; ?>">
                                                    <option value="">Select Measure</option>
                                                    <?php
                                                    // $dose_measure='3';
                                                    $query_prod_type = "select * from dose_measure where status = '1' ";
                                                    $exec_prod_type = mysqli_query($GLOBALS["___mysqli_ston"], $query_prod_type) or die ("Error in query_prod_type" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                                    while ($res_prod_type = mysqli_fetch_array($exec_prod_type)) {
                                                        $res_prod_id3 = $res_prod_type['id'];
                                                        $res_prod_name3 = $res_prod_type['name'];

                                                        ?>
                                                        <option value="<?php echo $res_prod_name3; ?>" <?php if ($dosemeasure == $res_prod_name3) {
                                                            echo 'selected="selected"';
                                                        } ?> ><?php echo $res_prod_name3; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>


                                            </div>
                                        </td>
                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="center">
                                                <input type="hidden" name="aformula" id="aformula<?php echo $sno; ?>"
                                                       value="<?php echo $formula; ?>">
                                                <input type="hidden" name="astrength" id="astrength<?php echo $sno; ?>"
                                                       value="<?php echo $strength; ?>">
                                                <select name="afrequency[<?php echo $sno; ?>]"
                                                        id="afrequency<?php echo $sno; ?>"
                                                        onChange="return Functionfrequency('<?php echo $sno; ?>')">
                                                    <?php
                                                    if ($pharmfrequency == '') {
                                                        echo '<option value="select" selected="selected">Select frequency</option>';
                                                    } else {
                                                        $query51 = "select * from master_frequency where frequencynumber='$pharmfrequency' and recordstatus = ''";
                                                        $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                                        $res51 = mysqli_fetch_array($exec51);
                                                        $res51code = $res51["frequencycode"];
                                                        $res51num = $res51['frequencynumber'];
                                                        echo '<option value="' . $res51num . '" selected="selected">' . $res51code . '</option>';
                                                    }
                                                    $query5 = "select * from master_frequency where recordstatus = '' order by auto_number";
                                                    $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                                    while ($res5 = mysqli_fetch_array($exec5)) {
                                                        $res5num = $res5["frequencynumber"];
                                                        $res5code = $res5["frequencycode"];
                                                        ?>
                                                        <option value="<?php echo $res5num; ?>"><?php echo $res5code; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </td>
                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="center"><input type="number" name="adays[<?php echo $sno; ?>]" id="adays<?php echo $sno; ?>"  onKeyUp="return Functionfrequency('<?php echo $sno; ?>')" value="<?php echo $pharmdays; ?>" size="8"  style="text-align:center;" >
											<input type="hidden" name="adays_org[<?php echo $sno; ?>]" id="adays_org<?php echo $sno; ?>"   value="<?php echo $pharmdays; ?>" size="8"  style="text-align:center;" ></div>
                                        </td>
                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="center"><input type="text" name="aquantity[<?php echo $sno; ?>]"
                                                                       id="aquantity<?php echo $sno; ?>"
                                                                       value="<?php echo $pharmquantity; ?>" size="8"
                                                                       class="bal" readonly></div>
                                        </td>
                                        <?php
                                        $stockquantity = 0;
                                        $querybatstock2 = "SELECT batch_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$pharmitemcode' and locationcode='$locationcode' and  storecode ='$storecode' ";
                                        $execbatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querybatstock2) or die ("Error in batQuery2" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $stocknumrows = mysqli_num_rows($execbatstock2);

                                        if ($stocknumrows) {
                                            // $resbatstock2 = mysql_fetch_array($execbatstock2);
                                            while ($resbatstock2 = mysqli_fetch_array($execbatstock2)) {
                                                $stockquantity += $resbatstock2["batch_quantity"];
                                            }
                                        } else {
                                            $stockquantity = 0;
                                        }
                                        ?>
                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="left"><input type="text" name="avlquantity[<?php echo $sno; ?>]"
                                                                     id="avlquantity<?php echo $sno; ?>"
                                                                     value="<?php echo $stockquantity; ?>" size="8"
                                                                     class="bal" readonly></div>
                                        </td>
                                        <td class="bodytext31" valign="center" align="left">
                                            <select name="aroute[<?php echo $sno; ?>]" id="aroute">
                                                <?php
                                                if ($route == '') {
                                                    echo '<option value="select" selected="selected">Select Route</option>';
                                                } else {

                                                    echo '<option value="' . $route . '" selected="selected">' . $route . '</option>';
                                                }
                                                ?>

                                                <option value="Oral">Oral</option>
                                                <option value="Sublingual">Sublingual</option>
                                                <option value="Rectal">Rectal</option>
                                                <option value="Vaginal">Vaginal</option>
                                                <option value="Topical">Topical</option>
                                                <option value="Intravenous">Intravenous</option>
                                                <option value="Intramuscular">Intramuscular</option>
                                                <option value="Subcutaneous">Subcutaneous</option>
                                            </select>
                                        </td>
                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="center"><input type="text"
                                                                       name="ainstructions[<?php echo $sno; ?>]"
                                                                       id="ainstructions<?php echo $sno; ?>"
                                                                       value="<?php echo $instructions; ?>" size="15">
                                            </div>
                                        </td>
                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="center"><?php echo $username; ?></div>
                                        </td>
                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="center"><input type="text" name="rate[<?php echo $sno; ?>]"
                                                                       id="rate<?php echo $sno; ?>"
                                                                       value="<?php echo $pharmitemrate; ?>" size="8"
                                                                       class="bal" readonly></div>
                                        </td>

                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="center"><input type="text" name="amount[<?php echo $sno; ?>]"
                                                                       id="amount<?php echo $sno; ?>"
                                                                       value="<?php echo $pharmamount; ?>" size="8"
                                                                       class="bal" readonly>

                                                <input type="hidden" name="autonums[<?php echo $sno; ?>]"
                                                       id="autonums<?php echo $sno; ?>" value="<?php echo $medanum; ?>"
                                                       size="8" class="bal" readonly>

                                            </div>
                                        </td>
										
                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="center"><input type="text"
                                                                       name="remarks-<?php echo $medanum; ?>"
                                                                       id="remarks-<?php echo $medanum; ?>"></div>
                                        </td>

                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="center"><a
                                                        onClick="return deletevalid('<?php echo $medanum; ?>','<?php echo $patientcode; ?>','<?php echo $visitcode; ?>','<?php echo $selectpending; ?>')"
                                                        href='javascript:return false;'>Delete</a></div>
                                        </td>


                                        <td class="bodytext31" valign="center" align="left">
                                            <div align="center">

                                                <input type="checkbox" name="pharamlatertonow[<?php echo $sno; ?>]"
                                                       id="pharamlatertonow<?php echo $sno; ?>" <?php if($cash_copay>0){ ?>checked <?php } ?>
                                                        <?php if(($appr_stat!='1')&&($appr_stat!='2')){ ?>disabled <?php } ?>
                                                       value="<?php echo $sno; ?>"  onClick="return cashcopay_coll(<?php echo $sno; ?>)">

                                            </div>
                                        </td>
										
										 <td class="bodytext31" valign="center" align="left">
                                            <div align="center">
											<input type="hidden" name="org_copay_amount[<?php echo $sno; ?>]" id="org_copay_amount<?php echo $sno; ?>" value="<?php echo $cash_copay;?>" size="8" readonly>
											<input type="hidden" name="item_amendstatus[<?php echo $sno; ?>]" id="item_amendstatus<?php echo $sno; ?>" value="<?php echo $amendstatus;?>" size="8" readonly>
											<input type="hidden" name="item_plan[<?php echo $sno; ?>]" id="item_plan<?php echo $sno; ?>" value="<?php echo $planforall;?>" size="8" readonly>
											<input type="hidden" name="item_copaycollected[<?php echo $sno; ?>]" id="item_copaycollected<?php echo $sno; ?>" value="<?php echo $alreadycoll;?>" size="8" readonly>
											<input type="text" name="copay_amount[<?php echo $sno; ?>]" id="copay_amount<?php echo $sno; ?>" value="<?php echo $cash_copay;?>" size="8" readonly onkeyup="return check_cashcopay(this.value,<?php echo $sno; ?>)">
                                            </div>
                                        </td>

                                    </tr>
                                <?php } } ?>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                
                                <td colspan="3"><a
                                            href="opdrughistory.php?searchsuppliercode=<?php echo $patientcode; ?>&&cbfrmflag1=cbfrmflag1"
                                            target="_blank"><strong>Past Medicine History</strong> </a></td>
                                <td class="bodytext31" align="right"><a
                                            href="print_amendpharmacy_page.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode ?>"
                                            target="new"><strong>Print</strong> </a></td>
                                <input type="hidden" name="pharmacysno" id="pharmacysno" value="<?php echo $sno; ?>">
                                <tr>
                                    <td class="bodytext31" valign="center" align="left"
                                        bgcolor="#ecf0f5">&nbsp;
                                    </td>
                                    <td class="bodytext31" valign="center" align="left"
                                        bgcolor="#ecf0f5">&nbsp;
                                    </td>
                                    <td class="bodytext31" valign="center" align="left"
                                        bgcolor="#ecf0f5">&nbsp;
                                    </td>
                                    <td class="bodytext31" valign="center" align="left"
                                        bgcolor="#ecf0f5">&nbsp;
                                    </td>
                                    <td class="bodytext31" valign="center" align="left"
                                        bgcolor="#ecf0f5">&nbsp;
                                    </td>
                                    <td class="bodytext31" valign="center" align="left"
                                        bgcolor="#ecf0f5">&nbsp;
                                    </td>
                                    <td class="bodytext31" valign="center" align="left"
                                        bgcolor="#ecf0f5">&nbsp;
                                    </td>
                                    <td class="bodytext31" colspan="3" valign="center" align="left"
                                        bgcolor="#ecf0f5">&nbsp;
                                    </td>
                                    <td class="bodytext31" valign="center" align="left"
                                        bgcolor="#ecf0f5">&nbsp;
                                    </td>
                                    <td class="bodytext31" valign="center" align="left"
                                        bgcolor="#ecf0f5">
                                        <div align="center">
                                    </td>
                                    <td class="bodytext31" valign="center" align="left"
                                        bgcolor="#ecf0f5">Total
                                    </td>

                                    <td class="bodytext31" valign="center" align="left"
                                        bgcolor="#ecf0f5">
                                        <div align="center">
                                            <input type="text" name="totaldb" id="totaldb"
                                                   value="<?php echo number_format($totalpharmamount, 2); ?>" size="8"
                                                   class="bal" readonly>
                                        </div>
                                    </td>
                                    <td class="bodytext31" valign="center" align="left"
                                        bgcolor="#ecf0f5">&nbsp;
                                    </td>


                                    <td class="bodytext31" valign="center" align="left"
                                        bgcolor="#ecf0f5">&nbsp;
                                    </td>
                                    <td class="bodytext31" valign="center" align="left"
                                        bgcolor="#ecf0f5">&nbsp;
                                    </td>


                                </tr>

                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td width="9%" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3"><strong>Prescribe
                                Medicine</strong></td>

                    </tr>
                    <tr id="pressid">
                        <td colspan="11" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
                            <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                                <tr>
                                    <td width="150" class="bodytext3">Medicine Name</td>
                                    <td width="48" class="bodytext3">Dose</td>
                                    <td width="48" class="bodytext3">Dose.Measure</td>
                                    <td width="41" class="bodytext3">Freq</td>
                                    <td width="48" class="bodytext3">Days</td>
                                    <td width="48" class="bodytext3">Quantity</td>
                                    <td width="48" class="bodytext3">Route</td>
                                    <td width="120" class="bodytext3">Instructions</td>
                                    <td class="bodytext3">Rate</td>
                                    <td width="48" class="bodytext3">Amount</td>
                                    <td width="42" class="bodytext3">&nbsp;</td>
                                </tr>
                                <tr>
                                    <div id="insertrow"></div>
                                </tr>
                                <?php /*?><tr>
					  <input type="hidden" name="serialnumber" id="serialnumber" value="1">
					  <input type="hidden" name="medicinecode" id="medicinecode" value="">
					     <input name="searchmedicinename1hiddentextbox" id="searchmedicinename1hiddentextbox" type="hidden" value="">
			           <input name="searchmedicineanum1" id="searchmedicineanum1" value="" type="hidden">

                       <td><input name="medicinename" type="text" id="medicinename" size="40" autocomplete="off" onKeyDown="return StateSuggestionspharm4()" onKeyUp="return funcCustomerDropDownSearch4()"></td>
                       <td><input name="dose" type="text" id="dose" size="8" onKeyUp="return Functionfrequency1()"></td>
                       <td>
					    <input name="formula" type="hidden" id="formula" readonly size="8">
						<input name="strength" type="hidden" id="strength" readonly size="8">
					   <select name="frequency" id="frequency" onChange="return Functionfrequency1()">
					     <?php
				if ($frequncy == '')
				{
					echo '<option value="select" selected="selected">Select frequency</option>';
				}
				else
				{
					$query51 = "select * from master_frequency where recordstatus = ''";
					$exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
					$res51 = mysql_fetch_array($exec51);
					$res51code = $res51["frequencycode"];
					$res51num = $res51['frequencynumber'];
					echo '<option value="'.$res51num.'" selected="selected">'.$res51code.'</option>';
				}
				$query5 = "select * from master_frequency where recordstatus = '' order by auto_number";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				$res5num = $res5["frequencynumber"];
				$res5code = $res5["frequencycode"];
				?>
                <option value="<?php echo $res5num; ?>"><?php echo $res5code; ?></option>
                 <?php
				}
				?>
               </select>				</td>	
                       <td><input name="days" type="text" id="days" size="8" onKeyUp="return Functionfrequency1()" onFocus="return frequencyitem()"></td>
                       <td><input name="quantity" type="text" id="quantity" size="8" readonly></td>
					    <td><select name="route" id="route">
					   <option value="">Select Route</option>
					   <option value="Oral">Oral</option>
					   <option value="Sublingual">Sublingual</option>
					   <option value="Rectal">Rectal</option>
					   <option value="Vaginal">Vaginal</option>
					   <option value="Topical">Topical</option>
					   <option value="Intravenous">Intravenous</option>
					   <option value="Intramuscular">Intramuscular</option>
					   <option value="Subcutaneous">Subcutaneous</option>
					   </select></td>
                       <td><input name="instructions" type="text" id="instructions" size="20"></td>
                       <td width="48"><input name="rates" type="text" id="rates" readonly size="8"></td>
                       <td>
                         <input name="amount" type="text" id="amount" readonly size="8"></td>
                       <td><label>
                       <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem10()" class="button" >
                       </label></td>
				     </tr><?php */ ?>
                                <tr>
                                    <input type="hidden" name="serialnumber" id="serialnumber" value="1">
                                    <input type="hidden" name="medicinecode" id="medicinecode" value="">
                                    <input name="searchmedicinename1hiddentextbox" id="searchmedicinename1hiddentextbox"
                                           type="hidden" value="">
                                    <input name="searchmedicineanum1" id="searchmedicineanum1" value="" type="hidden">
                                    <input type="hidden" name="genericname" id="genericname">
                                    <input type="hidden" name="drugallergy" id="drugallergy">
                                    <input type="hidden" name="exclude[]" id="exclude">
                                    <input type="hidden" name="hiddenmedicinename" id="hiddenmedicinename">
                                    <td><input name="medicinename[]" type="text" id="medicinename" size="40"
                                               autocomplete="off" onKeyDown="return StateSuggestionspharm4()"
                                               onKeyUp="return funcCustomerDropDownSearch4()"></td>
                                    <td><input name="dose" type="text" id="dose" size="8"
                                               onKeyUp="return Functionfrequency1()"
                                               oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                    </td>
                                    <td>


                                        <select class="dose_measure" name="dosemeasure[]" id="dosemeasure">
                                            <option value="">Select Measure</option>
                                            <?php
                                            // $dose_measure='3';
                                            $query_prod_type = "select * from dose_measure where status = '1' ";
                                            $exec_prod_type = mysqli_query($GLOBALS["___mysqli_ston"], $query_prod_type) or die ("Error in query_prod_type" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                            while ($res_prod_type = mysqli_fetch_array($exec_prod_type)) {
                                                $res_prod_id3 = $res_prod_type['id'];
                                                $res_prod_name3 = $res_prod_type['name'];

                                                ?>
                                                <option value="<?php echo $res_prod_name3; ?>"><?php echo $res_prod_name3; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input name="formula" type="hidden" id="formula" readonly size="8">
                                        <input name="strength" type="hidden" id="strength" readonly size="8">
                                        <input name="afrequency[]" type="hidden" id="afrequency" readonly size="8">
                                        <select name="frequency[]" id="frequency"
                                                onChange="return Functionfrequency1()">
                                            <?php
                                            if ($frequncy == '') {
                                                echo '<option value="select" selected="selected">Select frequency</option>';
                                            } else {
                                                $query51 = "select * from master_frequency where recordstatus = ''";
                                                $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                                $res51 = mysqli_fetch_array($exec51);
                                                $res51code = $res51["frequencycode"];
                                                $res51num = $res51['frequencynumber'];
                                                echo '<option value="' . $res51num . '" selected="selected">' . $res51code . '</option>';
                                            }
                                            $query5 = "select * from master_frequency where recordstatus = '' order by auto_number";
                                            $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                            while ($res5 = mysqli_fetch_array($exec5)) {
                                                $res5num = $res5["frequencynumber"];
                                                $res5code = $res5["frequencycode"];
                                                ?>
                                                <option value="<?php echo $res5num; ?>"><?php echo $res5code; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select></td>
                                    <td><input name="days[]" type="text" id="days" size="8"
                                               onKeyUp="return Functionfrequency1()" onFocus="return frequencyitem()"
                                               oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                    </td>
                                    <td><input name="quantity[]" type="text" id="quantity" size="8" readonly></td>
                                    <td><select name="route" id="route">
                                            <option value="">Select Route</option>
                                            <option value="Oral">Oral</option>
                                            <option value="Sublingual">Sublingual</option>
                                            <option value="Rectal">Rectal</option>
                                            <option value="Vaginal">Vaginal</option>
                                            <option value="Topical">Topical</option>
                                            <option value="Intravenous">Intravenous</option>
                                            <option value="Intramuscular">Intramuscular</option>
                                            <option value="Subcutaneous">Subcutaneous</option>
                                        </select></td>
                                    <td><input name="instructions[]" type="text" id="instructions" size="20"></td>
                                    <td width="48"><input name="rates[]" type="text" id="rates" readonly size="8"></td>
                                    <td>
                                        <input name="amount[]" type="text" id="amount" readonly size="8"></td>
                                    <td><label>
                                            <input  type="button" name="Add" id="Add" value="Add"
                                                   onClick="return insertitem10()" class="button">
                                        </label></td>
                                </tr>

                                <input type="hidden" name="h" id="h" value="0">
                                <input type="hidden" id="grandtotal"
                                       value="<?php echo number_format($grandtotal, 2, '.', ','); ?>" readonly size="7">


                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8" align="right" valign="middle" bgcolor="#ecf0f5" class="bodytext3"><span
                                    class="style2">Total</span><input type="text" id="total" readonly size="7"></td>
                    </tr>
					<tr>
					<td>&nbsp;</td>
					</tr>
                    <tr>
                        <td colspan="1" align="right" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
                            <input type="hidden" name="frm1submit1" value="frm1submit1"/>
                            <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>"/>
                            <input name="Submit222" type="submit" id="saverequest" value="Save Request" class="button"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>
</form>
<?php include("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>
