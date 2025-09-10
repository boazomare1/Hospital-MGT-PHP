<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

$username = $_SESSION["username"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];



$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$entrydate = date('Y-m-d');

$errmsg = "";

$bgcolorcode = "";

$colorloopcount = "";

$dummy = '';

$cr_amount="";

$sessiondocno = $_SESSION['docno'];



$query31 = "select fromyear,toyear from master_financialyear where status = 'Active' order by auto_number desc";

$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));

$res31 = mysqli_fetch_array($exec31);

$finfromyear = $res31['fromyear'];

$fintoyear = $res31['toyear'];



if(isset($_REQUEST['frmflag1'])) { $frmflag1 = $_REQUEST['frmflag1']; } else { $frmflag1 = ''; }

if(isset($_REQUEST['frmflag2'])) { $frmflag2 = $_REQUEST['frmflag2']; } else { $frmflag2 = ''; }

if($frmflag2 == 'frmflag2')
{


visitcreate:
$paynowbillprefix = 'EN-';

$paynowbillprefix1=strlen($paynowbillprefix);

 $query2 = "select * from master_journalentries where docno like 'EN-%' order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["docno"];

$billdigit=strlen($billnumber);

if ($billnumber == '')

{

 $billnumbercode ='EN-'.'1';

}

else

{

 $billnumber = $res2["docno"];

 $billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);



 $billnumbercode = intval($billnumbercode);

 $billnumbercode = $billnumbercode + 1;

 $maxanum = $billnumbercode;

 $billnumbercode = 'EN-' .$maxanum;

  

} 

$docno = $billnumbercode;

$query2 = "select * from master_journalentries where docno ='$docno'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_num_rows($exec2);
if($res2>0){
	goto visitcreate;
}



$entryid = $_REQUEST['entryid'];

$entrydate = $_REQUEST['entrydate'];

$entrydate = date('Y-m-d',strtotime($entrydate));

$narration = $_REQUEST['narration'];

$locationcode = $_REQUEST['location'];



$query66 = "select locationname from master_location where locationcode = '$locationcode'";

$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));

$res66 = mysqli_fetch_array($exec66);

$locationname = $res66['locationname'];



for($i=1;$i<$_REQUEST['totalrec'];$i++)
{
        $ledgerno = $_REQUEST['ledgerno'.$i];
	

		if($ledgerno != '')
		{

			$entrytype = $_REQUEST['entrytype'.$i];

			$ledger = $_REQUEST['ledger'.$i];

			$remark = $_REQUEST['remark'.$i];

			$creditamount = $_REQUEST['creditamount'.$i];
			$debitamount = $_REQUEST['debitamount'.$i];
			$amount = $_REQUEST['amount'.$i];

			$amount = str_replace(',','',$amount);

			$costcenter = "";
			if(isset($_REQUEST['costcenter'.$i]))
			{
				$costcenter = $_REQUEST['costcenter'.$i];
			}

			$query7 = "insert into master_journalentries (`docno`, `entrydate`, `voucheranum`, `vouchertype`, `selecttype`, `ledgerid`, `ledgername`, `cost_center`,  `transactionamount`, `creditamount`, `debitamount`, `status`, `ipaddress`, `username`, `updatedatetime`, `locationcode`, `locationname`, `narration`,`remarks`)

			values('$docno','$entrydate','','JOURNAL','$entrytype','$ledgerno','$ledger', '$costcenter' , '$amount', '$creditamount', '$debitamount','','$ipaddress','$username','$updatedatetime','$locationcode','$locationname','$narration','$remark')";

			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));

		}

	

}

//exit;
?>

<script>
		window.open("journalprint.php?billnumber=<?php echo $docno; ?>", "OriginalWindow", 'width=522,height=650,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
		window.open("entries_upload.php?st=success","_self")
	</script>

<?php


}



?>



<?php



$paynowbillprefix = 'EN-';

$paynowbillprefix1=strlen($paynowbillprefix);

 $query2 = "select * from master_journalentries where docno like 'EN-%' order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["docno"];

$billdigit=strlen($billnumber);

if ($billnumber == '')

{

 $billnumbercode ='EN-'.'1';

}

else

{

 $billnumber = $res2["docno"];

 $billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);



 $billnumbercode = intval($billnumbercode);

 $billnumbercode = $billnumbercode + 1;

 $maxanum = $billnumbercode;

 $billnumbercode = 'EN-' .$maxanum;

  

} 

$docno = $billnumbercode;

?>



<style type="text/css">



body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5 !important;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext11 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

</style>



</script>



</head>



<script type="text/javascript" language="javascript">



	
	

function entries()

{

	//alert ("Inside Funtion");

	if (document.form2.upload_file.value == "")

	{

		alert ("Please Select file.");

		return false;

	}

	

}

function validentries()

{

	//alert ("Inside Funtion");

	if (document.form1.location.value == "")

	{

		alert ("Please Select location.");

		return false;

	}

	

}



function btnDeleteClickindustry(id)

{

	var id = id;

	var newtotal3;

	//alert(vrate1);

	var varDeleteID1 = id;

	//alert(varDeleteID1);

	var fRet4; 

	fRet4 = confirm('Are You Sure Want To Delete This Entry?'); 

	//alert(fRet4); 

	if (fRet4 == false)

	{

		//alert ("Item Entry Not Deleted.");

		return false;

	}

	

	var limt = parseFloat(varDeleteID1) + 10;

	for(var i=varDeleteID1;i<=limt;i++)

	{	

		var child1 = document.getElementById('insertrow'+i); //tr name

		var child2 = document.getElementById('tblref'+i); //tr name

		var parent1 = document.getElementById('maintableledger'); // tbody name.

		if (child1 != null) 

		{

			//alert (child1);

			document.getElementById ('maintableledger').removeChild(child1);

			document.getElementById ('maintableledger').removeChild(child2);

			

		}

	}	

	

	document.getElementById("serialnumber").value = parseFloat(varDeleteID1);

	

	totend();

}

</script>







<script language="javascript">

function Funcvoucher()

{



}



function numbervaild(key)

{

	var keycode = (key.which) ? key.which : key.keyCode;



	 if(keycode > 40 && (keycode < 48 || keycode > 57 )&&( keycode < 96 || keycode > 111))

	{

		return false;

	}

}



</script>







<link href="css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 

<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>

<link href="css/autocomplete.css" rel="stylesheet">

<script src="js/datetimepicker_css_fin.js"></script>

</head>

<body id="voucherbgcolor">

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

    <td width="2%">&nbsp;</td>

    <td width="90%" valign="top">
	<table width="918" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                      <tr bgcolor="#011E6A">

                        <td colspan="7" bgcolor="#999999" class="bodytext11"><strong> Journal Entries - Upload </strong></td>

						<td align="right" colspan="2" bgcolor="#999999" class="bodytext11">&nbsp;</td>

                      </tr>
					  <tr >

                        <td colspan="7"  class="bodytext11"></td>

						<td align="right" colspan="2"  class="bodytext11">&nbsp;</td>

                      </tr>
			<?php
             if ($frmflag1 != 'frmflag1')
                  {
			?>

	        <form name="form2" id="form2" method="post" action="entries_upload.php" enctype="multipart/form-data" >
              <tr >
				  <td  align="left" class="bodytext3"> <strong>Upload File </strong>			</td>
				   <td colspan="2"><input type="file" name="upload_file" id="upload_file"></td>
				 </td>

	         </tr>
			 <tr >
				  <td  align="left" class="bodytext3">			</td>
				   <td colspan="2"><input type="hidden" name="frmflag1" value="frmflag1" />
                   <input type="submit" name="Submit" value="Submit" onClick="return entries()"/></td>
				 </td>

	         </tr>
			 
                        
			 </form>
			 
				  <?php
				  }
				  $status=0;
				  $total_cr=0;
				  $total_dr=0;
				  $k=1;
				  if ($frmflag1 == 'frmflag1' && isset($_FILES['upload_file']))
                  {
					  ?>

					   <form name="form1" id="form1" method="post" action="entries_upload.php" enctype="multipart/form-data" >

					   <tr>

                        <td colspan="4" align="left" valign="middle" class="bodytext3">&nbsp;</td>

                      </tr>

					   <tr>

                        <td width="142" align="left" valign="middle"  class="bodytext3"><div align="right">ID </div></td>

                        <td align="left" colspan="3" valign="top"><input type="text" name="entryid" id="entryid" value="<?php echo $docno; ?>" size="20" readonly="readonly">

						</td>

					  </tr>

					   <tr>

                        <td align="left" valign="middle" class="bodytext3"><div align="right">Entry Date</div></td>

                        <td align="left" colspan="3" valign="top"><input type="text" name="entrydate" id="entrydate" size="10" value="<?php echo date('Y-m-d'); ?>" readonly="readonly">

						<img src="images2/cal.gif" onClick="javascript:NewCssCal('entrydate')" style="cursor:pointer"/> 

						</td>

					  </tr>

					 

					   <tr>

                        <td align="left" valign="middle" class="bodytext3"><div align="right">Location</div></td>

                        <td align="left" colspan="3" valign="top">

					  <select name="location" id="location" onChange="locationform(form1,this.value); ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">

                      <?php

						

						$query1 = "select * from login_locationdetails where username='$username' and docno='$sessiondocno' group by locationname order by locationname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res1 = mysqli_fetch_array($exec1))

						{

						$res1location = $res1["locationname"];

						$res1locationanum = $res1["locationcode"];

						?>

						<option value="<?php echo $res1locationanum; ?>"><?php echo $res1location; ?></option>

						<?php

						}

						?>

                  </select>

				  </td>

                  </tr>

			<?php
					  if(!empty($_FILES['upload_file']))
                      {
						$inputFileName = $_FILES['upload_file']['tmp_name'];
						include 'phpexcel/Classes/PHPExcel/IOFactory.php';
						try {
							    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);

								$objReader = PHPExcel_IOFactory::createReader($inputFileType);

								$objPHPExcel = $objReader->load($inputFileName);

								$sheet = $objPHPExcel->getSheet(0); 

								$highestRow = $sheet->getHighestRow();

								$highestColumn = $sheet->getHighestColumn();

								$row = 1;

								$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,

														NULL,

														TRUE,

														FALSE)[0];

								foreach($rowData as $key=>$value)
								{
									if($rowData[$key] == 'voucher_type')
			                          $voucher_type = $key;
									if($rowData[$key] == 'ledger_name')
			                          $ledger_name = $key;
									if($rowData[$key] == 'ledger_code')
			                          $ledger_code = $key;
									if($rowData[$key] == 'cost_centre')
			                          $cost_centre = $key;
									if($rowData[$key] == 'amount')
			                          $amount = $key;
									if($rowData[$key] == 'remarks')
			                          $remarks = $key;
								}
								?>
								<tr id="heading" style="display:;" >
								
								<td align="right" class="bodytext11" colspan='9'><strong>&nbsp;</strong></td>

								</tr>
								<tr id="heading" style="display:;" bgcolor="#ecf0f5">
								<td align="left" class="bodytext11"><strong>Type</strong></td>
								<td  align="left" class="bodytext11"><strong>Ledger Name</strong></td>
								<td  align="left" class="bodytext11"><strong>Ledger Code</strong></td>
								<td id="costcentertd"  align="left" class="bodytext11"><strong><span id='showhide'>Cost Center</span></strong></td>
								<td align="left" class="bodytext11"><strong>Remarks</strong></td>
								<td align="right" class="bodytext11">&nbsp;</td>
								<td align="right" class="bodytext11"><strong>Cr.Amt</strong></td>
								<td align="right" class="bodytext11"><strong>Dr.Amt</strong></td>
								<td align="right" class="bodytext11"><strong>&nbsp;</strong></td>

								</tr>
								<?php
								$row_status=0;
								
								for ($row = 2; $row <= $highestRow; $row++){ 

									$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,

                                    NULL,

                                    TRUE,

                                    FALSE)[0];			
		
		                            $voucher_type_val=ucfirst(strtolower($rowData[$voucher_type]));
									$ledger_code_val=trim($rowData[$ledger_code]);
									$cost_centre_val=trim($rowData[$cost_centre]);
									$amount_val=$rowData[$amount];
									$amount_val=str_replace(",","",$amount_val);
									$remarks_val=addslashes($rowData[$remarks]);

									if($ledger_code_val!=''){
										$query11 = "select id,accountname from master_accountname where id = '$ledger_code_val'";
										$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
										$res11 = mysqli_fetch_array($exec11);
										$account_id = $res11['id'];
										if($account_id!=''){
										$accountname = $res11['accountname'];
										$row_status=0;
										}else{
                                          $row_status=1;
										}
									}
									else
										$row_status=1;

                                    $costcenter_name='';
									if($cost_centre_val!=''){
										$query10 = "select auto_number,name from `master_costcenter` where auto_number = '$cost_centre_val'";		
										$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
										$num_rows = mysqli_num_rows($exec10);
										if($num_rows > 0)
										{
                                           $costcenter_name=$num_rows['name'];
										}else{
                                           $row_status=1;
										}

									}

									if(strtolower($voucher_type_val)=='cr'){
										$cramt=$amount_val;
									}
									else
										$cramt=0;

									if(strtolower($voucher_type_val)=='dr'){
										$dramt=$amount_val;
									}
									else
										$dramt=0;
									
									$total_cr=$total_cr+$cramt;
				                    $total_dr=$total_dr+$dramt;	
									?>

									<tr id="heading"  bgcolor="<?php if($row_status==1) echo 'red'; else echo ''; ?>">
										<td align="left" class="bodytext11"><?php echo $voucher_type_val;?></td>
										<td  align="left" class="bodytext11"><?php echo $accountname;?></td>
										<td  align="left" class="bodytext11"><?php echo $account_id;?></td>
										<td id="costcentertd" align="left" class="bodytext11"><?php echo $costcenter_name;?></td>
										<td align="left" class="bodytext11"><?php echo $remarks_val;?></td>
										<td align="right" class="bodytext11">&nbsp;</td>
										<td align="right" class="bodytext11"><?php echo number_format($cramt, 2, '.', ',');?></td>
										<td align="right" class="bodytext11"><?php echo number_format($dramt, 2, '.', ',');?></td>
										<td align="right" class="bodytext11">
										
										<input id="entrytype<?php echo $k;?>" name="entrytype<?php echo $k;?>" type="hidden" value='<?php echo $voucher_type_val;?>'>
										<input id="ledger<?php echo $k;?>" name="ledger<?php echo $k;?>" type="hidden" value='<?php echo $accountname;?>'>
										<input id="ledgerno<?php echo $k;?>" name="ledgerno<?php echo $k;?>" type="hidden" value='<?php echo $account_id;?>'>
										<input id="costcenter<?php echo $k;?>" name="costcenter<?php echo $k;?>" type="hidden" value='<?php echo $costcenter_name;?>'>
										<input id="remark<?php echo $k;?>" name="remark<?php echo $k;?>" type="hidden" value='<?php echo $remarks_val;?>'>
										<input id="creditamount<?php echo $k;?>" name="creditamount<?php echo $k;?>" type="hidden" value='<?php echo $cramt;?>'>
										<input id="debitamount<?php echo $k;?>" name="debitamount<?php echo $k;?>" type="hidden" value='<?php echo $dramt;?>'>
										<input id="amount<?php echo $k;?>" name="amount<?php echo $k;?>" type="hidden" value='<?php echo $amount_val;?>'>

										</td>
                                         
									</tr>

									<?php
									$k++;
                                    if($row_status==1)
										$status=1;
								}

						} catch(Exception $e) {
						 die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
						}
					  }
				 

				  ?>
				  <tr id="heading" style="display:;" >
								
								<td align="right" class="bodytext11" colspan='9'><strong>&nbsp;</strong></td>

								</tr>
								
								<td align="center" class="bodytext11" colspan='6'><strong>Total</strong></td>
								<td align="right" class="bodytext11"><strong><?php echo number_format($total_cr, 2, '.', ',');?></strong></td>
								<td align="right" class="bodytext11"><strong><?php echo number_format($total_dr, 2, '.', ',');?></strong></td>
								<td align="right" class="bodytext11"><strong>&nbsp;</strong></td>

								</tr>
                 <input id="totalrec" name="totalrec" type="hidden" value='<?php echo $k;?>'>
                 <tr id="heading" style="display:;" >
								
								<td align="right" class="bodytext11" colspan='9'><strong>&nbsp;</strong></td>

				</tr>
				 <tr>

                        <td align="left" valign="middle" class="bodytext3"><div align="right">Narration</div></td>

                        <td align="left" colspan="3" valign="top"><textarea name="narration" id="narration" rows="3" cols="30"></textarea>

						</td>

					    </tr>

                        <tr id="sbtn" style="display:;">

                        <td align="left" valign="top">&nbsp;</td>

                        <td width="293" colspan="5" align="left" valign="middle" >


                        <input type="hidden" name="frmflag2" value="frmflag2" />

                     <?php if($status==0){ 
					 
					 if($total_cr==$total_dr){
					 ?>

						  <input type="submit" name="Submit" value="Submit" onClick="return validentries()"/>&nbsp;&nbsp;&nbsp;&nbsp;

                          <input type="reset" name="reset" value="Reset" onClick="javascript: var aa = confirm('Are you Sure to Reset ?'); if(aa == false) { return false; } window.location = 'entries_upload.php'" />
					<?php
					
					 }else{
						?>
						<input type="reset" name="reset" value="Reset" onClick="javascript: var aa = confirm('Are you Sure to Reset ?'); if(aa == false) { return false; } window.location = 'entries_upload.php'" />
						<?php
                        echo '<strong><font color="red">Sum of Credit and Debit Mismatch.</font></strong>';
					 }
					}else{ ?>

					<input type="reset" name="reset" value="Reset" onClick="javascript: var aa = confirm('Are you Sure to Reset ?'); if(aa == false) { return false; } window.location = 'entries_upload.php'" />

					<?php } ?>

                          </td>

                      </tr>	

					   </form>

					 <?php } ?>

        </table> 

		

             

   </td>

  </tr>

</table>



</body>

</html>



