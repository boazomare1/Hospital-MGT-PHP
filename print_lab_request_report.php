<?php
//include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$total = '0.00';
$snocount = "";
$colorloopcount="";
$range = "";
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Lab_Request_report.xls"');
header('Cache-Control: max-age=80');  
$reportformat = "";
if (isset($_REQUEST["ADate1"])) { $fromdate  = $_REQUEST["ADate1"];} else { $fromdate  = ""; }
if (isset($_REQUEST["ADate2"])) { $todate = $_REQUEST["ADate2"]; } else { $todate = ""; }
if (isset($_REQUEST["patienttype"])) { $patienttype = $_REQUEST["patienttype"]; } else { $patienttype = ""; }
if (isset($_REQUEST["searchpatient"])) { $searchpatient = $_REQUEST["searchpatient"]; } else { $searchpatient = ""; }
if (isset($_REQUEST["searchpatientcode"])) { $searchpatientcode = $_REQUEST["searchpatientcode"]; } else { $searchpatientcode = ""; }
if (isset($_REQUEST["searchvisitcode"])) { $searchvisitcode = $_REQUEST["searchvisitcode"]; } else { $searchvisitcode = ""; }
if (isset($_REQUEST["locationcode"])) { $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }
$labresult_count=0;
$labreq_count=0;
?>

<table  border="1" cellspacing="0" cellpadding="2">
<tr>
<td>
	<table width="100%" border="1" cellspacing="0" cellpadding="0">
		<tbody>
			
			
			<tr>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><strong>No.</strong></td>
			<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient </strong></div></td>
			<td width="" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg. No</strong></div></td>
			<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit. No</strong></div></td>
			<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit Date</strong></div></td>
			<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Lab Item code</strong></div></td>
			<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Lab Item Rate</strong></div></td>
			<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Lab Item Name</strong></div></td>
			<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>External Lab</strong></div></td>
			<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>External Rate</strong></div></td>
			<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Supplier</strong></div></td>
			<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Request Date</strong></div></td>
			<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Sample type</strong></div></td>
			<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Request Entry</strong></div></td>
			<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>ResultEntry</strong></div></td>
			<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amendment</strong></div></td>
			</tr>
			
			 <?php
		   
		   $grandtotal="0";
		    $total="0";
		    $amendtotal="0";
		    $exttotal="0";
		    $extcount="0";
			$sno=0;
			$query12 = "select auto_number from master_location where locationcode='$locationcode' order by locationname";
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res12 = mysqli_fetch_array($exec12);
			$loctid = $res12["auto_number"];
			
			
			
		   if($patienttype=='ALL' || $patienttype=='OP') {
			   
		   $queryh="select labitemname,labitemcode,visitcode from (
		   select labitemname,labitemcode,patientvisitcode as visitcode from consultation_lab where locationcode='".$locationcode."' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and consultationdate between '$fromdate' and '$todate' and labsamplecoll='completed' 
		   UNION ALL
		   select itemname as labitemname,itemcode as labitemcode,visitcode as visitcode from amendment_details where visitcode like '%-$loctid' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and amenddate between '$fromdate' and '$todate' and amendfrom='lab' 
		   and visitcode like 'OPV-%') as a group by labitemcode";
		   
		   $exech=mysqli_query($GLOBALS["___mysqli_ston"], $queryh) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($exeche=mysqli_fetch_array($exech))
		   {
			   $itemname=$exeche['labitemname'];
			   $itemcode21=$exeche['labitemcode'];
			  
		   ?>
           
           <tr>
              <td class="bodytext31" valign="center" colspan="10"  align="left" bgcolor="#ffffff">
			  <div class="bodytext31" align="left"><strong>Lab Item Name:<?= $itemname; ?></strong></div></td>
               <td class="bodytext31" valign="center" colspan="6"  align="left" bgcolor="#ffffff">
			  <div class="bodytext31" align="left"></div></td>
              </tr>
               
              <?php
			 
			$query23 = "select username,patientcode,patientvisitcode,patientname,labitemcode,labitemrate,consultationdate,resultentry,'' as amend from consultation_lab where locationcode='".$locationcode."' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and consultationdate between '$fromdate' and '$todate' and labsamplecoll='completed' and labitemcode='".$itemcode21."'
			UNION ALL
			select amendby as username,patientcode,visitcode as patientvisitcode,patientname,itemcode as labitemcode,amount as labitemrate,amenddate as consultationdate,'' as resultentry,'Yes' as amend from amendment_details where visitcode like '%-$loctid' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and amenddate between '$fromdate' and '$todate' and amendfrom='lab' and visitcode like 'OPV-%'  and itemcode='".$itemcode21."'
			";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$numexec23=mysqli_num_rows($exec23);
			if($numexec23>0)
			while($res23 = mysqli_fetch_array($exec23))
			{
			$resultdone='';
			$username=$res23['username'];
			$patientcode = $res23['patientcode'];
			$visitcode = $res23['patientvisitcode'];
			$patientname = $res23['patientname'];
			$itemcode = $res23['labitemcode'];
			$itemrate = $res23['labitemrate'];
			$consultationdate = $res23['consultationdate'];
			$resultentry = $res23['resultentry'];
			$amend = $res23['amend'];
			if($resultentry=='completed'){
				$resultdone='Yes';
				$labresult_count+=1;
			} else if($amend=='Yes'){
				$amendtotal+=1;
			}else{
				$labreq_count+=1;
			}
			
			$total+=$itemrate;
			
			$query24="select recorddate from master_consultation where patientcode='".$patientcode."' and patientvisitcode='".$visitcode."'";
			$exec24=mysqli_query($GLOBALS["___mysqli_ston"], $query24)or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res24=mysqli_fetch_array($exec24);
			$visitdate=$res24['recorddate'];
			
			
			$query224="select sampletype from master_lab where itemcode='".$itemcode."'";
			$exec224=mysqli_query($GLOBALS["___mysqli_ston"], $query224) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res224=mysqli_fetch_array($exec224);
			$sample=$res224['sampletype'];
			
			
			$query241="select externallab,externalack from samplecollection_lab where patientvisitcode='".$visitcode."' and itemcode='$itemcode'";
			$exec241=mysqli_query($GLOBALS["___mysqli_ston"], $query241)or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res241=mysqli_fetch_array($exec241);
			$externallab=$res241['externallab'];
			$externalack=$res241['externalack'];
			
			$itemrate_ext=0.00;
			$suppliername='';
			$extlab=0;
			if($externallab=='1' && $externalack=='0' && $amend==''){
			$extcount+=1;
			$extlab=1;
			
			$supplierq = "select suppliercode,rate from lab_supplierlink where itemcode = '$itemcode' and fav_supplier='1'";
			$execq = mysqli_query($GLOBALS["___mysqli_ston"], $supplierq) or die("Error in SupplierQ".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resq = mysqli_fetch_array($execq);
			$suppliercode = $resq['suppliercode'];
			$itemrate_ext = $resq['rate'];
			$exttotal+=$itemrate_ext;
			$query20 = "select accountname from master_accountname where id = '$suppliercode' ";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die('Error in Query20'.mysqli_error($GLOBALS["___mysqli_ston"]));
			$res20 = mysqli_fetch_array($exec20);
			$suppliername = $res20['accountname'];
			
			}

			
			if($visitcode=='walkinvis')
			{
			$visitdate=$consultationdate;	
			}
              
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
          <tr >
          
              <td  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitcode; ?></div></td>
			
             <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitdate; ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $itemcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="right"><?php echo number_format($itemrate,2); ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $itemname; ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $extlab; ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="right"><?php echo number_format($itemrate_ext,2); ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $suppliername; ?></div></td>
                  
              <td width=""  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $consultationdate; ?> </div></td>
              <td width=""  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $sample;?></div></td>
              <td width=""  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $username;?></div></td>
              <td width=""  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $resultdone;?></div></td>
              <td width=""  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $amend;?></div></td>
              </tr>
			   
           
		   <?php 
		   } 
		   ?>
		   <tr>
           <td   align="left" valign="center" class="bodytext31" colspan="6"><div align="right"><strong>Sub Total</strong></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="right"><strong><?= number_format($total,2) ?></strong></div></td>
             </tr>
             <?php
			 $grandtotal=$grandtotal+$total;
			 $total=0;
			 //$sno =0;
           }
		   }
		   ?>   
           
              
           
           <?php 
		    if($patienttype=='ALL' || $patienttype=='IP') {
		     $total1="0";
			$queryq="select labitemname,labitemcode,visitcode from (
			select labitemname,labitemcode,patientvisitcode as visitcode from ipconsultation_lab where locationcode='".$locationcode."' and labsamplecoll='completed' and consultationdate between '$fromdate' and '$todate' 
			UNION ALL
			select itemname as labitemname,itemcode as labitemcode,visitcode as visitcode from amendment_details where visitcode like '%-$loctid' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and amenddate between '$fromdate' and '$todate' and amendfrom='lab' 
			and visitcode like 'IPV-%') as a group by labitemcode";
			$execg=mysqli_query($GLOBALS["___mysqli_ston"], $queryq) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$numrow=mysqli_num_rows($execg);
			while( $exeg=mysqli_fetch_array($execg))
			{
			$itemname2=$exeg['labitemname'];
			$itemcode22=$exeg['labitemcode'];
			 
		   ?>
           
			   <tr>
              <td class="bodytext31" valign="center" colspan="10"  align="left" bgcolor="#ffffff">
			  <div class="bodytext31" align="left"><strong>Lab Item Name:<?= $itemname2 ?></strong></div></td>
              <td class="bodytext31" valign="center" colspan="6"  align="left" bgcolor="#ffffff">
			  <div class="bodytext31" align="left"></div></td>
              </tr>
           
           <?php
			$total1=0;
		     $query27 = "select username,patientcode,patientvisitcode,patientname,labitemcode,labitemrate,consultationdate,resultentry,'' as amend from ipconsultation_lab where locationcode='".$locationcode."' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and labsamplecoll='completed' and consultationdate between '$fromdate' and '$todate' and labitemcode='$itemcode22'
			 UNION ALL
			select amendby as username,patientcode,visitcode as patientvisitcode,patientname,itemcode as labitemcode,amount as labitemrate,amenddate as consultationdate,'' as resultentry,'Yes' as amend from amendment_details where visitcode like '%-$loctid' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and amenddate between '$fromdate' and '$todate' and amendfrom='lab' and visitcode like 'IPV-%'  and itemcode='".$itemcode22."' ";
	
			$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			 $numexec26=mysqli_num_rows($exec27);
			
			while($res27 = mysqli_fetch_array($exec27))
			{
			$resultdone='';
			$username1= $res27['username'];
		    $patientcode2 = $res27['patientcode'];
			$visitcode2 = $res27['patientvisitcode'];
			$patientname2 = $res27['patientname'];
			//$itemname2 = $res27['labitemname'];
			$itemcode2 = $res27['labitemcode'];
			$itemrate2 = $res27['labitemrate'];
			$consultationdate2 = $res27['consultationdate'];
			$resultentry = $res27['resultentry'];
			$amend = $res27['amend'];
			if($resultentry=='completed'){
				$resultdone='Yes';
				$labresult_count+=1;
			}else if($amend=='Yes'){
				$amendtotal+=1;
			}else{
				$labreq_count+=1;
			}
			
	 		$total1+=$itemrate2;
			
			$query28="select registrationdate from master_ipvisitentry where patientcode='".$patientcode2."' and visitcode='".$visitcode2."' order by auto_number desc";
			$exec28=mysqli_query($GLOBALS["___mysqli_ston"], $query28)or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res28=mysqli_fetch_array($exec28);
			$visitdate2=$res28['registrationdate'];
			
			$itemrate_ext=0.00;
			$query225="select sampletype from master_lab where itemcode='".$itemcode2."'";
			$exec225=mysqli_query($GLOBALS["___mysqli_ston"], $query225) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res225=mysqli_fetch_array($exec225);
			$sample1=$res225['sampletype'];
		
			$query241="select externallab,externalack from ipsamplecollection_lab where patientvisitcode='".$visitcode2."' and itemcode='$itemcode2'";
			$exec241=mysqli_query($GLOBALS["___mysqli_ston"], $query241)or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res241=mysqli_fetch_array($exec241);
			$externallab=$res241['externallab'];
			$externalack=$res241['externalack'];
			
			$itemrate_ext=0.00;
			$suppliername='';
			$extlab=0;
			if($externallab=='1' &&  $externalack='1' && $amend==''){
			$extcount+=1;
			$extlab=1;
				
			$supplierq = "select suppliercode,rate from lab_supplierlink where itemcode = '$itemcode2' and fav_supplier='1'";
			$execq = mysqli_query($GLOBALS["___mysqli_ston"], $supplierq) or die("Error in SupplierQ".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resq = mysqli_fetch_array($execq);
			$suppliercode = $resq['suppliercode'];
			$itemrate_ext = $resq['rate'];
			$exttotal+=$itemrate_ext;
			$query20 = "select accountname from master_accountname where id = '$suppliercode' ";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die('Error in Query20'.mysqli_error($GLOBALS["___mysqli_ston"]));
			$res20 = mysqli_fetch_array($exec20);
			$suppliername = $res20['accountname'];
			
			}
		
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
			<tr>

				<td   align="left" valign="center" class="bodytext31"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31" align="center"><?php echo $patientname2; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div align="center"><?php echo $patientcode2; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div align="center"><?php echo $visitcode2; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div align="center"><?php echo $visitdate2; ?></div></td>
				<td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $itemcode2; ?></div></td>
				<td class="bodytext31" valign="center"  align="center"><div align="right"><?php echo number_format($itemrate2,2); ?></div></td>
				<td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $itemname2; ?></div></td>
				<td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $extlab; ?></div></td>
				<td class="bodytext31" valign="center"  align="center"><div align="right"><?php echo number_format($itemrate_ext,2); ?></div></td>
				<td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $suppliername; ?></div></td>               
				<td width=""  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $consultationdate2; ?> </div></td>
				<td width=""  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $sample1;?></div></td>
				<td width=""  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $username1;?></div></td>
				<td width=""  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $resultdone;?></div></td>
				<td width=""  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $amend;?></div></td>

			</tr>

           
           
           <?php
		   }
		   ?>
		   <tr>
				<td   align="left" valign="center" class="bodytext31" colspan="6"><div align="right"><strong>Sub Total</strong></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31" align="right"><strong><?= number_format($total1,2) ?></strong></div></td>
			</tr>
             <?php
			 $grandtotal=$grandtotal+$total1;
		   }
		   }
		   ?>
           
			<tr>
				<td   align="left" valign="center" class="bodytext31" colspan="6"><div align="right"><strong>Grand Total</strong></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31" align="right"><strong><?= number_format($grandtotal,2) ?></strong></div></td>
			</tr>

			<tr>
				<td  align="left" valign="center" class="bodytext31" colspan="2"><div align="right"><strong>Lab Count</strong></div></td>
				<td class="bodytext31" valign="center"  align="left" colspan="2"><div class="bodytext31" align="center"><strong><?= number_format($labreq_count+$labresult_count+$amendtotal,2) ?></strong></div></td>
				<td   align="left" valign="center" class="bodytext31" colspan="2"><div align="right"><strong>Lab Pending Count</strong></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31" align="center"><strong><?= number_format($labreq_count,2) ?></strong></div></td>
				<td   align="left" valign="center" class="bodytext31" colspan="2"><div align="right"><strong>Result Entry Count</strong></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31" align="center"><strong><?= number_format($labresult_count,2) ?></strong></div></td> 
				<td   align="left" valign="center" class="bodytext31" colspan="2"><div align="right"><strong>Amendment Count</strong></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31" align="center"><strong><?= number_format($amendtotal,2) ?></strong></div></td>  
			</tr>

			<tr>
				<td  align="left" valign="center" class="bodytext31" colspan="2"><div align="right"><strong>External Lab Count</strong></div></td>
				<td class="bodytext31" valign="center"  align="left" colspan="2"><div class="bodytext31" align="center"><strong><?= $extcount; ?></strong></div></td>
				<td align="left" valign="center" class="bodytext31" colspan="2"><div align="right"><strong>External Lab Amount</strong></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31" align="center"><strong><?= number_format($exttotal,2) ?></strong></div></td>
			</tr>
           
           
                   
            
			
		</tbody>
        </table>
</td>
</tr>
</table>