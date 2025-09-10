<?php

	 if($module == 'consultationbilling')
			{
			$totalconsultationrefund = 0;
		   $query82 = "select * from refund_consultation where billdate < '$ADate1' order by auto_number desc";
		   $exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while ($res82= mysqli_fetch_array($exec82))
		  {
     	   $resconsultationrefunddate = $res82['billdate'];
		   $resconsultationrefundamount = $res82['consultation'];
		   $resconsultationrefundcoa = $res82['consultationcoa'];
		   $resbillnumberrefund = $res82['billnumber'];
		   
		   $query821 = "select * from master_accountname where id='$resconsultationrefundcoa'";
		   $exec821 = mysqli_query($GLOBALS["___mysqli_ston"], $query821) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res821 = mysqli_fetch_array($exec821);
		   $resconsultationrefundcoaname = $res821['accountname'];
		  	  
		   $totalconsultationrefund = $totalconsultationrefund + $resconsultationrefundamount;
		   }
		   $openingbalancedebit = $totalconsultationrefund;
		   }
		   
		    if($module == 'lab')
			{
			$totallabrefund = 0;
		   $query25= "select * from refund_paylaterlab where billdate < '$ADate1' order by auto_number desc";
		   $exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while ($res25= mysqli_fetch_array($exec25))
		  {
     	   $reslabrefunddate = $res25['billdate'];
		   $reslabrefundamount = $res25['labitemrate'];
		   $reslabrefundcoa = $res25['labcoa'];
		   $resbillnumberlabrefund = $res25['billnumber'];
		   
		   $query251 = "select * from master_accountname where id='$reslabrefundcoa'";
		   $exec251 = mysqli_query($GLOBALS["___mysqli_ston"], $query251) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res251 = mysqli_fetch_array($exec251);
		   $reslabrefundcoaname = $res251['accountname'];
		  	  
		   $totallabrefund = $totallabrefund + $reslabrefundamount;
		   
		   }
		   
		   	
		   $query26= "select * from refund_paynowlab where billdate < '$ADate1' order by auto_number desc";
		   $exec26 = mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while ($res26= mysqli_fetch_array($exec26))
		  {
     	   $reslabrefunddate = $res26['billdate'];
		   $reslabrefundamount = $res26['labitemrate'];
		   $reslabrefundcoa = $res26['labcoa'];
		   $resbillnumberlabrefund = $res26['billnumber'];
		   
		   $query261 = "select * from master_accountname where id='$reslabrefundcoa'";
		   $exec261 = mysqli_query($GLOBALS["___mysqli_ston"], $query261) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res261 = mysqli_fetch_array($exec261);
		   $reslabrefundcoaname = $res261['accountname'];
		  	  
		   $totallabrefund = $totallabrefund + $reslabrefundamount;
		   
		   }
		    $openingbalancedebit = $totallabrefund;
		   }
?>