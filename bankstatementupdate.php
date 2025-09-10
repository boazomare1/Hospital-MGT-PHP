<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

$username = $_SESSION["username"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];



$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$dateonly = date("Y-m-d");

$colorloopcount = "";

$runningbalance = 0;

$totalunpre = 0;

$totalunclr = 0;

  

if (isset($_REQUEST["frmflg1"])) { $frmflg1 = $_REQUEST["frmflg1"]; } else { $frmflg1 = ""; }



if (isset($_REQUEST["ADate1"])) { $transactiondatefrom = $_REQUEST["ADate1"]; } else { $transactiondatefrom = date("Y-m-d"); }

if (isset($_REQUEST["ADate2"])) { $transactiondateto = $_REQUEST["ADate2"]; } else { $transactiondateto = date("Y-m-d"); }

if (isset($_REQUEST["referenceno"])) { $referenceno = $_REQUEST["referenceno"]; } else { $referenceno = ""; }

if (isset($_REQUEST["bankname"])) 

{ 

	$bankfullname = $_REQUEST["bankname"];

	/*$bankfullname = explode("-",$bankfullname,2);

	$banknamereq = $bankfullname[0];

	$accountnumberreq = $bankfullname[1];*/

} 

else 

{ 

	$bankfullname = "";

	/*$banknamereq = "";

	$accountnumberreq = "";*/

}

$colorcode = 'bgcolor="#CBDBFA"';



?>



<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none

}

-->

</style>

<!--<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

--><style type="text/css">



.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}



</style>

<script>

function functiontest()

{

if(document.getElementById("referenceno").value == "")

{

 alert("Please Enter Transaction Ref No");

 document.getElementById("referenceno").focus();

 return false;

}

/*if(document.getElementById("transactiontype").value == '')

{

	alert("Please Select Transaction Type To Proceed");

	 document.getElementById("transactiontype").focus();

 	return false;

}*/

}

	</script>

</head>



<script src="js/datetimepicker_css.js"></script>

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js" type="text/javascript"></script>

<link href="js/jquery-ui.css" rel="stylesheet">



<script type="text/javascript" src="js/jquery-1.11.1.js"></script>

<body>
<script type="text/javascript">
	

	$(document).ready(function(){



	$( ".edititem" ).click(function() {


		console.log('in edit item')
		

		var clickedid = $(this).attr('id');

		var current_expdate = $('tr#'+clickedid).find("div.expdate").text();

		//var current_expdate = $('#uiexpirydate_'+clickedid).text();
		

		//alert(current_expdate)
		//var current_batch = $('tr#'+clickedid).find("div.updatebatch").text();

		$('tr#'+clickedid).find("td.expirydatetd").show();

		$('tr#'+clickedid).find("td.expirydatetdstatic").hide();

		//$('tr#'+clickedid).find("td.batchupdatetd").show();
		//$('tr#'+clickedid).find("td.batchupdatestatic").hide();
        //$('#batchupdate_'+clickedid).val(current_batch);

		$('#expdate_'+clickedid).val(current_expdate);

		$('#s_'+clickedid).show();

		return false;

	})	





	$( ".saveitem" ).click(function() {



		

		var clickedid = $(this).attr('id');

		var idstr = clickedid.split('s_');

		var id = idstr[1];

		var expiry_date = $('#expdate_'+id).val();

		var autonumber = $('#autonumber_'+id).val(); 


		var chequedate = $('#chequedate_'+id).val();

		var bankdate = expiry_date;
	
	

	  var chequedate = new Date(chequedate);
	  var date1 = chequedate.getTime();  
	  
	  var expiry_date = new Date(expiry_date);
	  var date2 = expiry_date.getTime();
  
  	if(date1 > date2){
		alert('Statement Date should not be less than Transaction Date');
		
		return false;
	}

		

		$.ajax({

		  url: 'ajax/bankstmtdateupdate.php',

		  type: 'POST',

		  //async: false,

		  dataType: 'json',

		  //processData: false,    

		  data: { 

		      autonumber: autonumber, 
		      bankdate:bankdate

		  },

		  success: function (data) { 

		  	//alert(data)

		  	

		  	var msg = data.msg;

		  	if(data.status == 1)

		  	{

		  		$('#expirydate_'+id).val(bankdate);
		  		

		  		$('tr#'+id).find("td.expirydatetd").hide();

				$('tr#'+id).find("td.expirydatetdstatic").show();

				

				$('#uiexpirydate_'+id).text(bankdate);

				

				$('#s_'+id).hide();



		  	}

		  	else

		  	{

		  		alert(msg);

		  	}

		  	

		  }

		});

		return false;

	})	

	

})

</script>
<table width="101%" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php  include ("includes/menu1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>

      &nbsp;</td>

    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">

            <tr>

              <td>

              <form method="post" action="bankstatementupdate.php">

                <table width="759" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>			  

                <tr>

                  <td  colspan="5" bgcolor="#ecf0f5" class="bodytext3"><strong>Bank Statement Update</strong></td>

                  </tr>

                <tr>

                  <td colspan="1" width="100" bgcolor="#ffffff" class="bodytext3"><div align="left">Transaction Ref No</div></td>
                  <td bgcolor="#ffffff" class="bodytext3"><input type="text" name="referenceno" id="referenceno" class="bodytext3" value="<?php echo $referenceno; ?>"></td>
                  <td colspan="2" bgcolor="#ffffff" class="bodytext3">&nbsp;</td>

                </tr>


                  <tr>

				  	<td bgcolor="#ffffff">&nbsp;</td>

                    <td align="left" valign="middle" bgcolor="#ffffff" class="bodytext3">

 					<input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1" >				  

				  <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" onClick="return functiontest()" /></td>

				  <td bgcolor="#ffffff">&nbsp;</td>

				  <td bgcolor="#ffffff">&nbsp;</td>

                  </tr>

				  </tbody>

				  </table>

				  </form>

			    </td>

				  </tr>

				  <tr><td>&nbsp;</td></tr>

                <tr >

				<td><table width="" align="left" cellpadding="4" cellspacing="0"  style="border-collapse: collapse">

				<?php

 					$sno = 0;

				if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

				//$cbfrmflag1 = $_POST['cbfrmflag1'];

				if ($frmflag1 == 'frmflag1')

				{	

					if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

					if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

					//if (isset($_REQUEST["referenceno"])) { $referenceno = $_REQUEST["referenceno"]; } else { $referenceno = ""; }

					if ($ADate1 != '' && $ADate2 != '')

					{

						 $transactiondatefrom = $_REQUEST['ADate1'];

						 $transactiondateto = $_REQUEST['ADate2'];

					}

					else

					{

						$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

						$transactiondateto = date('Y-m-d');

					}

					   $bankname = $bankfullname;

						

				?>

					

				<tr>

                  <td width="30" bgcolor="#ecf0f5" class="bodytext3" align="center" valign="middle"><strong>No</strong></td>

				  <td width="100" bgcolor="#ecf0f5" class="bodytext3" align="left" valign="middle"><strong>Transaction Date</strong></td>

                  <td width="90" bgcolor="#ecf0f5" class="bodytext3" align="left" valign="middle"><strong>Statement Date</strong></td>

                  <td width="100" bgcolor="#ecf0f5" class="bodytext3" align="left" valign="middle"><strong>Description</strong></td>

				  <td width="50" bgcolor="#ecf0f5" class="bodytext3" align="left" valign="middle"><strong>Transaction <br/> Ref No</strong></td>

				  <td width="150" bgcolor="#ecf0f5" class="bodytext3" align="right" valign="middle"><strong>Money In</strong></td>

                  <td width="150" bgcolor="#ecf0f5" class="bodytext3" align="right" valign="middle"><strong>Money Out</strong></td>
                  <td width="50" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Action</strong></div></td>
                    <td align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong></strong></div></td>
                 

                </tr>

				  <?php

				  $totatlmoneyin = 0;

				  $totatlmoneyout = 0;

				  $totatlrunningbal = 0;

				  $moneyin = 0;

				  $moneyout = 0;

				  $runningbalancecalc =0;

				  $temp = 0;

				  $runningbalance = 0;

				  $sno=0;

				  $opening = 0;

				  $query_acc = "select * from master_accountname where id = '$bankname'";

				  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_acc) or die ("Error in query_acc".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $res1 = mysqli_fetch_array($exec1);

				  $currency = $res1['currency'];

				  $cur_qry = "select * from master_currency where currency like '$currency'";

				  $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $cur_qry) or die ("Error in cur_qry".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $res21 = mysqli_fetch_array($exec21);

				  $fxrate = $res21['rate'];

				  if($fxrate == 0.00)

				  {

					  $fxrate = 1.00;

				  }

				  $incr = 0;
				  $qrybankstatements = "SELECT auto_number,postdate,chequedate,bankdate,remarks,docno,bankamount,notes,status,bankcode FROM bank_record WHERE docno like '%$referenceno%'";

					$excebankstatements = mysqli_query($GLOBALS["___mysqli_ston"], $qrybankstatements) or die("Error in qrybankstatements".mysqli_error($GLOBALS["___mysqli_ston"]));

			

					while($resbankstatement = mysqli_fetch_array($excebankstatements))

					{

						
					  $postingdate = $resbankstatement["chequedate"];

					  $valuedate = $resbankstatement["bankdate"];

					  $description = $resbankstatement["remarks"];

					  $transrefno = $resbankstatement["docno"];

					  $notes = $resbankstatement["notes"];

					  $status = $resbankstatement["status"];

					  $auto_number = $resbankstatement["auto_number"];

					  $bankcode = $resbankstatement["bankcode"];

					  	if($incr == 0){

							 $query_acc = "select * from master_accountname where id = '$bankcode'";

							  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_acc) or die ("Error in query_acc".mysqli_error($GLOBALS["___mysqli_ston"]));

							  $res1 = mysqli_fetch_array($exec1);

							  $currency = $res1['currency'];

							  $cur_qry = "select * from master_currency where currency like '$currency'";

							  $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $cur_qry) or die ("Error in cur_qry".mysqli_error($GLOBALS["___mysqli_ston"]));

							  $res21 = mysqli_fetch_array($exec21);

							  $fxrate = $res21['rate'];

							  if($fxrate == 0)

							  {

								  $fxrate = 1;

							  }
						}

						$query2 = "select amount, creditamount from bankentryform where docnumber = '$transrefno' and (frombankid = '$bankcode' or tobankid = '$bankcode')";

						$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res2 = mysqli_fetch_array($exec2);

						$num2 = mysqli_num_rows($exec2);

						$dramount = $res2['amount'];

						$cramount = $res2['creditamount'];

						if($num2 == 0)

						{

							//MONEY IN  -- notes type is accountrecievelbe

							if($notes == 'accounts receivable')

							{

								if($status == 'Unpresented')

								{

									$moneyin = 0;

									$moneyout = $resbankstatement["bankamount"];

									$totalunpre = $resbankstatement["bankamount"];

								}

								else if($status == 'Uncleared')

								{

									$moneyin = 	$resbankstatement["bankamount"];

									$moneyout = 0;

									$totalunclr = $resbankstatement["bankamount"];

								}

								else

								{

									$moneyin = 	$resbankstatement["bankamount"];

									$moneyout = 0;

								}

							}

							else //MONEY OUT

							{

								$moneyout = abs($resbankstatement["bankamount"]);

								$moneyin = 0;

							}

						}

						else

						{

							$moneyin = 	$dramount;

							$moneyout = $cramount;

						}	

						

						$moneyin = $moneyin/$fxrate;

						$moneyout = $moneyout/$fxrate;

						$runningbalance = $runningbalance + $moneyin - $moneyout;

						

						

						

						//TOTALS

						$totatlmoneyin = $totatlmoneyin + $moneyin;

						$totatlmoneyout = $totatlmoneyout + $moneyout;

						//$totatlrunningbal = $totatlrunningbal + $runningbalance;

						

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
							$sno = $sno+1;
				  ?>

				<tr  <?php echo $colorcode; ?> id="<?php echo $sno;  ?>">

                  <td class="bodytext3" valign="middle"  align="center"><?php echo $sno;?> </td>

				  <td class="bodytext3" valign="middle"  align="left"><?php echo $postingdate;?><input type="hidden" id="chequedate_<?php echo $sno?>" value="<?php echo $postingdate;?>"></td>

				   <td  style="display:none;" class="expirydatetd" width="123" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input class="expdatepicker" id="expdate_<?php  echo $sno;?>" name="expdate[]" style="border: 1px solid #001E6A" value=""  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('expdate_<?php  echo $sno;?>','yyyyMMdd','','','','','')" style="cursor:pointer"/>			</td>

                  <td class="bodytext3 expirydatetdstatic" valign="middle"  align="left"><div class="bodytext31">

                <div align="left" class="expdate" id="uiexpirydate_<?php echo $sno;?>"><?php echo $valuedate;?></div></div></td>

                  <td class="bodytext3" valign="middle"  align="left"><?php echo $description.' ('.$status.')';?></td>

				  <td class="bodytext3" valign="middle"  align="left"><?php echo $transrefno;?></td>

                  <td class="bodytext3" valign="middle"  align="right"><?php echo number_format($moneyin,2,'.',',');?> </td>

                  <td class="bodytext3" valign="middle"  align="right"><?php echo number_format($moneyout,2,'.',',');?></td>

                  <td align="left" valign="center"  

                 class="bodytext31"><div class="bodytext31">

                <div align="right"><a class="edititem" id="<?php echo $sno; ?>" href="" style="padding-right: 10px;">Edit</a>

                	<!-- <a style="display:none;" class="saveitem" id="s_<?php echo $sno; ?>" href="" >Save</a> -->

                </div>

               <input type="hidden" id="autonumber_<?php echo $sno?>" value="<?php echo $auto_number;?>">

              </div></td>

                  <td align="left" valign="center"  

                 class="bodytext31"><div class="bodytext31">

                <div align="right">

                	<a style="display:none;" class="saveitem" id="s_<?php echo $sno; ?>" href="" >Update</a>

                </div>

               

              </div></td>

                </tr>

		    <?php
		    $incr += 1;

					}//CLOSE -- WHILE LOOP

			     ?>

               

               
				 <?php   		

				} //CLOSE -- IF(frmflag1)

				?>	

	      </table>

          </td>

            </tr>  

        </table></td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

    </table>

</table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>



