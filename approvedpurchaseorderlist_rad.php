<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d');

$transactiondateto = date('Y-m-d');

$currentdate = date("Y-m-d");

$docno1 = $_SESSION['docno'];

if(isset($_POST['ADate1'])){$fromdate = $_POST['ADate1'];}else{$fromdate=$transactiondatefrom;}

if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate=$transactiondateto;}

if(isset($_POST['docno'])){$docno = $_POST['docno'];}else{$docno='';}

$ponumber=isset($_REQUEST['pono'])?$_REQUEST['pono']:'';



if(isset($_REQUEST['searchstatus'])){$searchstatus = $_REQUEST['searchstatus'];}else{$searchstatus='Medical';}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

//$st = $_REQUEST['st'];

if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }

//$st = $_REQUEST['st'];

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }



if (isset($_REQUEST["purchaseindentdocno"])) 

{ 

	$purchaseindentdocno = $_REQUEST["purchaseindentdocno"]; 

	$query55="update purchase_indent set pogeneration='' where docno='$purchaseindentdocno'";

	$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	

	$query55="update purchaseorder_details set recordstatus='deleted', discard_username = '$username', discard_ipaddress = '$ipaddress', discard_timestamp = '$updatedatetime' where purchaseindentdocno='$purchaseindentdocno'";

	$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

}

 else { $purchaseindentdocno = ""; }



 $type=isset($_REQUEST["type"])?$_REQUEST["type"]:''; 

 if($type =="Non-Medical")

 {

	  $purchasedoc=isset($_REQUEST["purchaseindentdocno"])?$_REQUEST["purchaseindentdocno"]:''; 

	if($purchasedoc <> '')

	{

	 $mlpoquery="update manual_lpo set recordstatus='deleted', discard_username = '$username', discard_ipaddress = '$ipaddress', discard_timestamp = '$updatedatetime' where  purchaseindentdocno='$purchaseindentdocno'";

	 $exemlpo=mysqli_query($GLOBALS["___mysqli_ston"], $mlpoquery) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	}

 }
 
 $query = "select locationcode,locationname from login_locationdetails where username='$username' and docno='$docno1' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
$locationname  = $res["locationname"];
$locationcode = $res["locationcode"];

?>

<?php

$query3 = "select * from master_company where companystatus = 'Active'";

$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

$res3 = mysqli_fetch_array($exec3);

$paynowbillprefix = 'PO-';

$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select * from purchase_ordergeneration order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["docno"];

$billdigit=strlen($billnumber);

if ($billnumber == '')

{

	$billnumbercode ='PO-'.'1';

	$openingbalance = '0.00';

}

else

{

	$billnumber = $res2["docno"];

	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);

	//echo $billnumbercode;

	$billnumbercode = intval($billnumbercode);

	$billnumbercode = $billnumbercode + 1;



	$maxanum = $billnumbercode;

	

	

	$billnumbercode = 'PO-' .$maxanum;

	$openingbalance = '0.00';

	//echo $companycode;

}



?>

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #E0E0E0;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

.number

{

padding-left:690px;

text-align:right;

font-weight:bold;

}

-->

</style>

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<script language="javascript">



function cbcustomername1()

{

	document.cbform1.submit();

}



</script>

<script type="text/javascript" src="js/autocomplete_customer1.js"></script>

<script type="text/javascript" src="js/autosuggest3.js"></script>

<script type="text/javascript">

window.onload = function () 

{

	var oTextbox = new AutoSuggestControl(document.getElementById("searchcustomername"), new StateSuggestions());        

}





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

function togglefunction(pino)

{

	

	var inputs = document.getElementsByClassName(pino);

	

	for (var i = 0; i < inputs.length; i++) {

		var displayattr = inputs[i].style.display;

		if(displayattr=='')

		{

	  		inputs[i].style.display='none';

			document.getElementById('id'+pino).innerHTML='+';

		}

		else

		{

			inputs[i].style.display='';

			document.getElementById('id'+pino).innerHTML='-';

		}

	}

}

function loadprintpagepdf1(pono,suppliercode)

{

	var ponumnber = pono;

	//alert(varpatientcodes);

		window.open("print_localpurchaseorder.php?billnumber="+ponumnber+'&&suppliercode='+suppliercode,"Window",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');

}

function loadprintpagepdf2(pono,suppliercode)

{

	var ponumnber = pono;

	//alert(varpatientcodes);

		window.open("print_localpurchaseorderm.php?billnumber="+ponumnber+'&&suppliercode='+suppliercode,"Window",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');

}

function loadprintpagepdf21(pono,suppliercode)

{

	var ponumnber = pono;

	//alert(varpatientcodes);

		window.open("print_externalpos.php?billnumber="+ponumnber+'&&suppliercode='+suppliercode,"Window",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');

}



function Validate1(){

	var con = confirm("Are you sure to delete?");

	if(con == false)

	{

	   return false;	

	}

}

</script>

<script src="js/datetimepicker_css.js"></script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

-->

</style>

</head>



<body>



<?php 



	$query34="select * from purchaseorder_details where recordstatus='generated' and goodsstatus ='' and itemstatus != 'deleted' and locationcode='$locationcode' group by purchaseindentdocno";

	$exec34=mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	$resnw1=mysqli_num_rows($exec34);

	

	$query35="select * from manual_lpo where recordstatus='generated' group by purchaseindentdocno";

	$exec35=mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	$resnw2=mysqli_num_rows($exec35);



?>

<table width="100%" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="9" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="99%" valign="top"><table width="105%" border="0" cellspacing="0" cellpadding="0">

	      

		  <tr>

        <td width="860">

              <form name="cbform1" method="post" action="approvedpurchaseorderlist_rad.php">

                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                  <tbody>

                   <tr bgcolor="#011E6A">

              <td colspan="3" bgcolor="#CCCCCC" class="bodytext3"><strong>Finance Purchase Indents Approval</strong></td>

              <td colspan="1" align="right" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation"><strong>  </strong>

             

            

                 

                  </td>



              </tr>

			   <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Doc No</td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <input name="docno" type="text" id="docno" value="" autocomplete="off">

              </span></td>

              </tr>

               <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Po No</td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <input name="pono" type="text" id="pono" value="" autocomplete="off">

              </span></td>

              </tr>

			  <tr style="display:none">

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Status</td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

              <select name="searchstatus" id="searchstatus">
                          
              <option value="External-Rad">External-Rad</option>

			  </select>

              </span></td>

              </tr>

                   <tr>

          <td width="100" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>

          <td width="137" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>

          <td width="68" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>

          <td width="263" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">

            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>

		  </span></td>

          </tr>

					

				

			<tr>

                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                          <input  type="submit" value="Search" name="Submit" />

                          <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>

                    </tr>

                  </tbody>

                </table>

              </form>		</td>

      </tr>

  

    <tr>

    <td colspan="9">&nbsp;</td>

  </tr>

  <tr>

    

    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" 

            align="left" border="0">

          <tbody>

            <tr>

             <?php 
		
			if($searchstatus=='External-Rad'||$searchstatus=='All'){

			?>

            <tr>

              <td colspan="9" class="bodytext31">&nbsp;</td>

            </tr>

            <tr>

             

              <td colspan="9" bgcolor="#cccccc" class="bodytext31">

                <div align="left"><strong>External_Rad Purchase Orders</strong><label class="number"><<<?php echo $resnw2;?>>></label></div></td>

              </tr>

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>

				 <td width="13%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date </strong></div></td>

				<td width="13%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>PO No</strong></div></td>

				<td width="13%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Supplier</strong></div></td>

              <td width="15%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Value</strong></div></td>

				<td width="15%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Budget Holders Remarks</strong></div></td>

				<td width="20%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action</strong></div></td>

              	<td width="20%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Print</strong></div></td>

             

              </tr>

			<?php

			$colorloopcount = '';

			$sno = '';

			

		 $query34="select a.entrydate,a.itemcode,a.username,a.billnumber,a.suppliername,a.suppliercode,a.remarks,a.purchaseindentdocno,b.docno,b.baremarks as baremarks from manual_lpo a JOIN purchase_indent b ON (a.purchaseindentdocno=b.docno) JOIN master_radiology c ON (a.itemcode=c.itemcode) where a.recordstatus='generated'  and a.purchaseindentdocno like '%$docno%' and a.entrydate between '$fromdate' and '$todate' and a.billnumber like '%$ponumber%' and a.itemcode != '' group by a.purchaseindentdocno order by a.auto_number desc";

		$exec34=mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		while($res34=mysqli_fetch_array($exec34))

		{

			$date=$res34['entrydate'];

			$user=$res34['username'];

			$pono=$res34['billnumber'];

			$suppliername=$res34['suppliername'];

			$suppliercode=$res34['suppliercode'];

			$baremarks=$res34['baremarks'];

			$purchaseindentdocno = $res34['purchaseindentdocno'];

			$totalamount = 0;

			$sno1='0';

			

			$query36="select date from purchase_indent where docno='$purchaseindentdocno'";

			$exec36=mysqli_query($GLOBALS["___mysqli_ston"], $query36) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$num36=mysqli_num_rows($exec36);

			$res36=mysqli_fetch_array($exec36);

			$date=$res36['date'];

			

			$query36="select * from manual_lpo where recordstatus='generated' and purchaseindentdocno='$purchaseindentdocno' group by purchaseindentdocno";

			$exec36=mysqli_query($GLOBALS["___mysqli_ston"], $query36) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$num36=mysqli_num_rows($exec36);

			

			

			

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

				$colorcode = 'bgcolor="#D3EEB7"';

			} 

			?>

			  <tr <?php echo $colorcode; ?> id="<?php echo $purchaseindentdocno; ?>" onClick="togglefunction('<?php echo $purchaseindentdocno; ?>');">

              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>

			   <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $date; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $purchaseindentdocno; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="center"></div></td>

		        <td class="bodytext31" valign="center"  align="right">

			  <div class="bodytext31" align="right"></div></td>

			   <td class="bodytext31" valign="center"  align="right">

			  <div class="bodytext31" align="right"></div></td>

			      <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31" align="center"><strong>

              <?php /*if($num36=='0'){*/?>

              <a onClick="return Validate1();" href="approvedpurchaseorderlist.php?purchaseindentdocno=<?php echo $purchaseindentdocno; ?>&&type=<?= $searchstatus ?>">Discard</a>

              <?php //}?>

              </strong></div></td>

			    <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31" align="center"><strong id="id<?php echo $purchaseindentdocno; ?>" style=" font-size:20px; background-color:#FFF;">+</strong></div></td>

              </tr>

		<?php

		$query35="select * from manual_lpo where recordstatus='generated' and purchaseindentdocno='$purchaseindentdocno' group by suppliercode order by auto_number desc";

			$exec35=mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res35=mysqli_fetch_array($exec35))

			{

				$date=$res35['entrydate'];

				$user=$res35['username'];

				$pono=$res35['billnumber'];

				$suppliername=$res35['suppliername'];

				$suppliercode=$res35['suppliercode'];

				$baremark=$res35['remarks'];

				$purchaseindentdocno = $res35['purchaseindentdocno'];

				$query36="select * from manual_lpo where recordstatus='generated' and billnumber='$pono' and suppliercode='$suppliercode'";

				$exec36=mysqli_query($GLOBALS["___mysqli_ston"], $query36) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				while($res36=mysqli_fetch_array($exec36))

				{

					$amount=$res36['totalamount'];

					$totalamount=$totalamount+$amount;

				}

				$totalamount=number_format($totalamount,2);

				

		?>

			

                       

               <tr <?php echo $colorcode; ?> style="" class="<?php echo $purchaseindentdocno; ?>">

                  <td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>

                   <td class="bodytext31" valign="center"  align="left">

                    <div align="center"><?php echo $date; ?></div></td>

                    <td class="bodytext31" valign="center"  align="left">

                    <div align="center"><?php echo $pono; ?></div></td>

                    <td class="bodytext31" valign="center"  align="left">

                    <div align="center"><?php echo $suppliername; ?></div></td>

                    <td class="bodytext31" valign="center"  align="right">

                  <div class="bodytext31" align="right"><?php echo $totalamount; ?></div></td>

				  <td class="bodytext31" valign="center"  align="right">

                  <div class="bodytext31" align="center"><?php echo $baremarks; ?></div></td>

                      <td class="bodytext31" valign="center"  align="left">

                  <div class="bodytext31" align="center"><a href="viewmlpo.php?billnumber=<?php echo $pono; ?>&&suppliercode=<?=$suppliercode?>">View</a></div></td>

                    <td class="bodytext31" valign="center"  align="left">

                  <div class="bodytext31" align="center"><a href="javascript:loadprintpagepdf21('<?php echo $pono; ?>','<?=$suppliercode;?>')"><strong>Print</strong></a></div></td>

                </tr>

			  <?php

			}

			}

			}
			
			?>

            
            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#cccccc">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#cccccc">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#cccccc">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#cccccc">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#cccccc">&nbsp;</td>

				 <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#cccccc">&nbsp;</td>

             			 <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#cccccc">&nbsp;</td>

            	 <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#cccccc">&nbsp;</td>

            

              </tr>

          </tbody>

        </table></td>

      </tr>

	  <tr>

	   <td class="bodytext31" valign="center"  align="left">&nbsp;</td>

	  </tr>

	  <tr>

	  <td class="bodytext31" valign="center"  align="center">

	  

	   <input type="hidden" name="doccno" value="<?php echo $billnumbercode; ?>">

	   </td>

	  </tr>

    </table>

</table>



<?php include ("includes/footer1.php"); ?>



</body>

</html>



