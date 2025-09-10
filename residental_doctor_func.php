<?php
include_once ("db/db_connect.php");


function resident_doctor_sharing($resdoccoa,$resupdatedate,$resprivatedoctoramount){

	//residental doctor

    $chk_doc ="SELECT is_resdoc,resdoc_limit,res_start_per,res_limit_ext,res_per_ext FROM `master_doctor` WHERE `doctorcode` = '$resdoccoa'";
	$resexec21 = mysqli_query($GLOBALS["___mysqli_ston"], $chk_doc);
	$res21res = mysqli_fetch_array($resexec21);
	$totalresdoc=0;
	$totalresdoc1=0;
	$totalresdoc12=0;
	$totalresdoc3=0;
	$is_resdoc=$res21res['is_resdoc'];
	$pvtdrsharingamount = 0;
	   $pvtdrperc = 0;
    if($is_resdoc==1){
       
	   	$res_limit =$res21res['resdoc_limit'];
		$res_start_per =$res21res['res_start_per'];
		$res_limit_ext =$res21res['res_limit_ext'];
		$res_per_ext =$res21res['res_per_ext'];

	   $startdate =date('Y-m-01',strtotime($resupdatedate));
	   $enddate =date('Y-m-31',strtotime($resupdatedate));

	   $amt_chk_doc ="SELECT sum(original_amt) as amt FROM billing_ipprivatedoctor WHERE doccoa = '$resdoccoa' and recorddate between '$startdate' and '$enddate' ";
	   $resexec22 = mysqli_query($GLOBALS["___mysqli_ston"], $amt_chk_doc);
	   $res22res = mysqli_fetch_array($resexec22);
       if($res22res['amt']>0)
		 $totalresdoc1=$res22res['amt'];

	   $amt_chk_doc2 ="SELECT sum(original_amt) as amt FROM billing_ipprivatedoctor_refund WHERE doccoa = '$resdoccoa' and recorddate between '$startdate' and '$enddate' ";
	   $resexec222 = mysqli_query($GLOBALS["___mysqli_ston"], $amt_chk_doc2);
	   $res22res2 = mysqli_fetch_array($resexec222);
       if($res22res2['amt']>0)
		   $totalresdoc12=$res22res2['amt'];
       
	  $totalresdoc = $totalresdoc1 - $totalresdoc12;
      $totalresdoc3 =$totalresdoc+$resprivatedoctoramount;

	   if($totalresdoc3>0){
         

		 if($totalresdoc3<=$res_limit){
            $pvtdrsharingamount = 0;
	        $pvtdrperc = 0;
		 }elseif( $totalresdoc3<=($res_limit+$res_limit_ext) ){
            $pvtdrsharingamount = ($res_start_per/100) * ($totalresdoc3-$res_limit);
	        $pvtdrperc = $res_start_per;
		 }else{

         $totalresdocs=$totalresdoc-$res_limit;

		  if($totalresdocs<0)
			  $totalresdocs=0;

		  $cal_amt=ceil($totalresdocs/$res_limit_ext);

		   if($cal_amt==0)
			   $cal_amt=1;
         
		 $cal_amtnew=ceil(($totalresdoc3-$res_limit)/$res_limit_ext);

		  $marginamt=0;
		  $k=0;
		  $excessamt=$resprivatedoctoramount;

		  for($i=$cal_amt;$i<=$cal_amtnew;$i++)
		  {
			 $balanceamt =0;

             if($i==1)
                $incper= $res_start_per;
			  else
			    $incper= $res_start_per + (($i-1)*$res_per_ext);

			   if($incper>100)
				  $incper=100;

			 if($k==0 ){
               if($totalresdoc<($res_limit+($i*$res_limit_ext)) && $cal_amt==$cal_amtnew)
				{
					$marginamt =0;

				}else{
                  $marginamt = $totalresdoc-($res_limit+($i*$res_limit_ext));
				}

			   if($marginamt<0){
                  $balanceamt = -1* $marginamt;
			   }elseif($marginamt>0){
                  $balanceamt = $res_limit_ext-$marginamt;
			   }
			 }
			 
             
			 if($balanceamt>0){
                 $pvtdrsharingamount = $pvtdrsharingamount+(($incper/100)*$balanceamt);
				 $excessamt = $excessamt-$balanceamt;
			 }else{
			   if($excessamt>=$res_limit_ext)
			     $pvtdrsharingamount = $pvtdrsharingamount+(($incper/100)*$res_limit_ext);
			   else
				  $pvtdrsharingamount = $pvtdrsharingamount+(($incper/100)*$excessamt);

			   $excessamt = $excessamt-$res_limit_ext;


			 }

            $k=$k+1;
		  }
	     $pvtdrperc = $incper;

		 }

	   }		
	}
	else
      $is_resdoc=0;

$rslt['is_resident'] =$is_resdoc;
$rslt['sharing_amt'] =$pvtdrsharingamount;
$rslt['sharing_per'] =$pvtdrperc;


return $rslt;

}


?>