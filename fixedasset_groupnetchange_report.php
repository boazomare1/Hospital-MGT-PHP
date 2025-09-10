<?php
 
error_reporting(0);
session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$location =isset( $_REQUEST['location'])?$_REQUEST['location']:'';



$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$searchsuppliername = "";

$cbsuppliername = "";



//This include updatation takes too long to load for hunge items database.





if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

//$getcanum = $_GET['canum'];

if ($getcanum != '')

{

	$query4 = "select * from master_supplier where auto_number = '$getcanum'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res4 = mysqli_fetch_array($exec4);

	$cbsuppliername = $res4['suppliername'];

	$suppliername = $res4['suppliername'];

}



if(isset($_REQUEST['searchitem'])) { $searchitem = $_REQUEST['searchitem']; } else { $searchitem = ""; }



if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

//$frmflag2 = $_POST['frmflag2'];

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-2 year'));

$paymentreceiveddateto = date('Y-m-d');

if ($frmflag2 == 'frmflag2')

{



}
if ($cbfrmflag1 == 'cbfrmflag1')

{

$paymentreceiveddatefrom = $_REQUEST['ADate1'];

	$paymentreceiveddateto = $_REQUEST['ADate2'];

	
	if (isset($_REQUEST["categoryid"])) { $categoryid_selected = $_REQUEST["categoryid"]; } else { $categoryid_selected = ""; }
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

//$st = $_REQUEST['st'];

if ($st == '1')

{

	$errmsg = "Success. Payment Entry Update Completed.";

}

if ($st == '2')

{

	$errmsg = "Failed. Payment Entry Not Completed.";

}



?>

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

-->

</style>

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<?php include ("js/dropdownlistipbilling.php"); ?>

<script type="text/javascript" src="js/autosuggestipbilling.js"></script> <!-- For searching customer -->

<script type="text/javascript" src="js/autocomplete_customeripbilling.js"></script>

<script type="text/javascript" src="jquery/jquery-1.11.3.min.js"></script>

<script>	

<?php 

if (isset($_REQUEST["ipbillnumber"])) { $ipbillnumbers = $_REQUEST["ipbillnumber"]; } else { $ipbillnumbers = ""; }

if (isset($_REQUEST["ippatientcode"])) { $ippatientcodes = $_REQUEST["ippatientcode"]; } else { $ipbillnumbers = ""; }

?>

	var ipbillnumberr;

	var ipbillnumberr = "<?php echo $ipbillnumbers; ?>";

	var ippatientcoder;

	var ippatientcoder = "<?php echo $ippatientcodes; ?>";

	//alert(refundbillnumber);

	if(ipbillnumberr != "") 

	{

		window.open("print_depositcollection_dmp4inch1.php?billnumbercode="+ipbillnumberr+"&&patientcode="+ippatientcoder+"","OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 

	}				

</script>

<script language="javascript">



function ajaxlocationfunction(val)

{ 

if (window.XMLHttpRequest)

					  {// code for IE7+, Firefox, Chrome, Opera, Safari

					  xmlhttp=new XMLHttpRequest();

					  }

					else

					  {// code for IE6, IE5

					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

					  }

					xmlhttp.onreadystatechange=function()

					  {

					  if (xmlhttp.readyState==4 && xmlhttp.status==200)

						{

						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;

						}

					  }

					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);

					xmlhttp.send();

}

					

//ajax to get location which is selected ends here









function cbsuppliername1()

{

	document.cbform1.submit();

}



function funcOnLoadBodyFunctionCall()

{ 

	//alert ("Inside Body On Load Fucntion.");

	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php

	

	funcCustomerDropDownSearch1(); //To handle ajax dropdown list.

	funcPopupOnLoad1();

}







</script>

<script type="text/javascript">





function disableEnterKey(varPassed)

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

	

	var key;

	if(window.event)

	{

		key = window.event.keyCode;     //IE

	}

	else

	{

		key = e.which;     //firefox

	}



	if(key == 13) // if enter key press

	{

		//alert ("Enter Key Press2");

		return false;

	}

	else

	{

		return true;

	}

}





function process1backkeypress1()

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

}



function disableEnterKey()

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

	

	var key;

	if(window.event)

	{

		key = window.event.keyCode;     //IE

	}

	else

	{

		key = e.which;     //firefox

	}

	

	if(key == 13) // if enter key press

	{

		return false;

	}

	else

	{

		return true;

	}



}





function funcPrintReceipt1()

{

	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

}



</script>



<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<style type="text/css">

<!--

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

-->

.bal

{

border-style:none;

background:none;

text-align:right;

}

.bali

{

text-align:right;

}

</style>

</head>



<script>

	$(document).ready(function() {

		$('.executelink').click(function(){
	    	return confirm("Are you sure you want to Assetize?");
		})
	});


function funcPopupOnLoad1()

{

<?php  

if (isset($_REQUEST["savedpatientcode"])) { $savedpatientcode = $_REQUEST["savedpatientcode"]; } else { $savedpatientcode = ""; }

if (isset($_REQUEST["savedvisitcode"])) { $savedvisitcode = $_REQUEST["savedvisitcode"]; } else { $savedvisitcode = ""; }

if (isset($_REQUEST["billnumber"])) { $billnumbers = $_REQUEST["billnumber"]; } else { $billnumbera = ""; }

?>

var patientcodes = "<?php echo $_REQUEST['savedpatientcode']; ?>";

var visitcodes = "<?php echo $_REQUEST['savedvisitcode']; ?>";

var billnumbers = "<?php echo $_REQUEST['billnumber']; ?>";

//alert(billnumbers);

	if(patientcodes != "") 

	{

		window.open("print_ipfinalinvoice1.php?patientcode="+patientcodes+"&&visitcode="+visitcodes+"&&billnumber="+billnumbers,"OriginalWindowA4",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 

	}

}

</script>



<script src="js/datetimepicker_css.js"></script>



<body onLoad="return funcOnLoadBodyFunctionCall()">

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

    <td width="1%">&nbsp;</td>

    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>

      &nbsp;</td>

    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="860">

		

		

              <form name="cbform1" method="post" action="fixedasset_groupnetchange_report.php">

		<table width="500" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td  colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>Fixed Asset - Group Net Change</strong></td>

             



              </tr>

          <tr>

          				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Location</td>

				  <td  align="left" valign="middle"  bgcolor="#ecf0f5">

                  <select name="location" id="location"  onChange="ajaxlocationfunction(this.value);" style="border: 1px solid #001E6A;">

                  <?php

						

						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res1 = mysqli_fetch_array($exec1))

						{

						$locationname = $res1["locationname"];

						$locationcode = $res1["locationcode"];

						?>

						<option value="<?php echo $locationcode; ?>" <?php if($location!=''){if($location == $locationcode){echo "selected";}}?>><?php echo $locationname; ?></option>

						<?php

						}

						?>

                  </select>

                  </td>

				  </tr>


 
         
<!-- 
			      <tr>

                      <td class="bodytext31" valign="center"  align="left" 

                > Date From </td>

                      <td width="30%" align="left" valign="center"  class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>

                      <td width="16%" align="left" valign="center"   class="bodytext31"> Date To </td>

                      <td width="33%" align="left" valign="center"  ><span class="bodytext31">

                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>

                    </tr> --> 
                       <tr>

          				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Category</td>

				  <td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5">

                  <select name="categoryid" id="categoryid"  style="border: 1px solid #001E6A;">

                  	<option value="">Select Category</option>
                  <?php

						

						$query1 = "select * from master_assetcategory where recordstatus='' order by category";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res1 = mysqli_fetch_array($exec1))

						{

						$categoryid = $res1["auto_number"];

						$categoryname = $res1["category"];

						?>

						<option value="<?php echo $categoryid; ?>" <?php if($categoryid_selected!=''){if($categoryid_selected == $categoryid){echo "selected";}}?>><?php echo $categoryname; ?></option>

						<?php

						}

						?>

                  </select>

                  </td>

				  </tr> 
                       <tr>

				 

				  <td colspan="1" align="left" valign="middle"  bgcolor="#ecf0f5">

				  </td>

				

             

              <td width="20%" align="left" valign="top"  bgcolor="#ecf0f5"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                  <input   type="submit" value="Submit" name="Submit" />

            </td>

            </tr>

             </tbody>

        </table>

		</form>		</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      

	  <form name="form11" id="form11" method="post" action="">	

	  <tr>

        <td>

	

		

<?php

	$colorloopcount=0;

	$sno=0;

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{

$paymentreceiveddatefrom = $_REQUEST['ADate1'];

	$paymentreceiveddateto = $_REQUEST['ADate2'];
$searchpatient = '';		

?>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1000" 

            align="left" border="0">

          <tbody>

             

            <tr>
            	<!-- <td width="1%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>S.No.</strong></div></td> -->
            	<td width="6%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="left"><strong>FA Posting Group</strong></div></td>
           	  <td width="3%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="left"><strong>Field Name</strong></div></td>

			
                 <td width="3%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account No.</strong></div></td>
                <!--  <td width="7%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Disposal </strong></div></td> -->

              <td width="3%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="left"><strong>Account Name</strong></div></td>

				      <td width="3%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="right"><strong>FA Net Change</strong></div></td>

                	                

              </tr>

           <?php
           $grand_netbookvalue = 0;
           $grand_purchasecost = 0;
           $grand_accdepreciation = 0;
           $sno = 0;
           $dep_till_date = date("Y-m-d");
		 	$categoryid_cond = "";

		 	if($categoryid_selected!="")
		 	{
		 		$categoryid_cond = " and auto_number='$categoryid_selected' ";
		 	}

		 	$categoryqry = "select auto_number,category from master_assetcategory where recordstatus= '' $categoryid_cond  order by auto_number ";

		   $categoryexec = mysqli_query($GLOBALS["___mysqli_ston"], $categoryqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		   while($rescategory = mysqli_fetch_array($categoryexec))

		   {

		   	$asset_category_id = $rescategory['auto_number'];
		   //	echo $asset_category_id;

		   	$category_name = $rescategory['category'];

		   	 $query66 = "select * from assets_register where asset_category_id = '$asset_category_id' and assetledger !='' and accdepreciationledger != '' and assetledgercode != '' and depreciationledgercode != '' limit 0,1";

			 //echo 
			 
			$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res66 = mysqli_fetch_array($exec66);

			$ledgerid  =  $res66['assetledgercode'];

			$accountname = $res66['assetledger'];
			
			$depreciationledgercode = $res66['depreciationledgercode']; 
			$field_name = "Acquisition Cost Account";

			$query77 = "select sum(totalamount) amt from assets_register where assetledgercode = '$ledgerid' and asset_category_id = '$asset_category_id' ";
			 
			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res77 = mysqli_fetch_array($exec77);

			$ledgeramount =  $res77['amt'];

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


			 <tr <?php echo $colorcode; ?>>

          	 
               <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $category_name; ?></div></td> 

             
                <td class="bodytext31" valign="center"  align="right"><div align="left"><?php echo $field_name; ?>
              	
              </div></td>
              
              <td class="bodytext31" valign="center"  align="right"><div align="left"><?php echo $ledgerid; ?>
              	
              </div></td>

              <td class="bodytext31" valign="center"  align="right"><div align="left"><?php echo $accountname; ?>
              	
              </div></td>
              
			  <td class="bodytext31" valign="center"  align="left">

			    <div align="right">
			    	
  			<?php	echo number_format($ledgeramount,2);
		
			    	  ?></div></td>
			   

			     


				</tr>



				<?php 

				$accountname = $res66['accdepreciationledger'];
				$accdepreciationledgercode = $res66['accdepreciationledgercode']; 

			$query666 = "select sum(transaction_amount) as amount1 from tb where ledger_id = '$accdepreciationledgercode' and remarks='Depreciation' ";
						//echo $query66;
			$exec666 = mysqli_query($GLOBALS["___mysqli_ston"], $query666) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res666 = mysqli_fetch_array($exec666);

			$ledgeramount =  $res666['amount1'];
			$ledgeramount = $ledgeramount *-1;
				
				

				$field_name = "Accum. Depreciation Account";
				?>

				<tr <?php echo $colorcode; ?>>

          	 
               <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $category_name; ?></div></td> 

             
                <td class="bodytext31" valign="center"  align="right"><div align="left"><?php echo $field_name; ?>
              	
              </div></td>
              
              <td class="bodytext31" valign="center"  align="right"><div align="left"><?php echo $accdepreciationledgercode; ?>
              	
              </div></td>

              <td class="bodytext31" valign="center"  align="right"><div align="left"><?php echo $accountname; ?>
              	
              </div></td>
              
			  <td class="bodytext31" valign="center"  align="left">

			    <div align="right">
			    	
  			<?php	echo number_format($ledgeramount,2);
		
			    	  ?></div></td>
			   

			     


				</tr>

				<?php 

				$depreciationledgercode = $res66['depreciationledgercode']; 

			$query666 = "select sum(transaction_amount) as amount1 from tb where ledger_id = '$depreciationledgercode' and remarks='Depreciation' ";
						//echo $query66;
			$exec666 = mysqli_query($GLOBALS["___mysqli_ston"], $query666) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res666 = mysqli_fetch_array($exec666);

			$ledgeramount =  $res666['amount1'];
				
				//$accountname = "Provision for Depreciation"; 
				$accountname = $res66['depreciationledger'];

				$field_name = "Depreciation Expense Acc.";
				?>

				 <tr <?php echo $colorcode; ?>>

          	 
               <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $category_name; ?></div></td> 

             
                <td class="bodytext31" valign="center"  align="right"><div align="left"><?php echo $field_name; ?>
              	
              </div></td>
              
              <td class="bodytext31" valign="center"  align="right"><div align="left"><?php echo $depreciationledgercode; ?>
              	
              </div></td>

              <td class="bodytext31" valign="center"  align="right"><div align="left"><?php echo $accountname; ?>
              	
              </div></td>
              
			  <td class="bodytext31" valign="center"  align="left">

			    <div align="right">
			    	
  			<?php	echo number_format($ledgeramount,2);
		
			    	  ?></div></td>
			   

			     


				</tr>




		  <?php  }

           ?>
             
           
			<tr>

            <td colspan="4" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><a href="fixedasset_groupnetchange_report_xl.php?categoryid=<?php echo $categoryid_selected ?>"><img  width="40" height="40" src="images/excel-xls-icon.png" style="cursor:pointer;"></a></td>

			</tr>			

          </tbody>

        </table>

<?php

}

?>	

		</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

	  

	  </form>

    </table>

  </table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>

<?php 


function getCategoryAssetIds($asset_category_id)
{
	
	$assetids_arr = array();
	$qry = " select asset_id from assets_register where asset_category_id='$asset_category_id' ";
	
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

	while ($res5 = mysqli_fetch_array($exec5))

				{
					$assetids_arr[] = $res5['asset_id'];
					//echo $res5['asset_id'].'<br>';
				}
	return $assetids_arr;
}
?>

