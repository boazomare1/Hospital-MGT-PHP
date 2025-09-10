<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="StockCostOfSales.xls"');
header('Cache-Control: max-age=80');


$main_serial=0;
$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$currentdate = date("Y-m-d");

$docno = $_SESSION['docno'];

$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

	include('convert_currency_to_words.php');

	 $locationname  = $res["locationname"];

	 $locationcode = $res["locationcode"];

	 $res12locationanum = $res["auto_number"];

	 

  $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';

  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

	



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

//$st = $_REQUEST['st'];

if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }

//$st = $_REQUEST['st'];

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

		

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

$store = isset($_REQUEST['store'])?$_REQUEST['store']:'';

$grandtotalamount = 0;

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




<script type="text/javascript">

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





//ajax function to get store for corrosponding location

function storefunction(loc)

{ 

	<?php 

	$query12 = "select * from master_location where status <> 'deleted'";

	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

	while ($res12 = mysqli_fetch_array($exec12))

	{

	$res12anum = $res12["auto_number"];

	$res12locationcode = $res12["locationcode"];

	?>

	if(document.getElementById("location").value=="<?php echo $res12locationcode; ?>")

	{

		document.getElementById("store").options.length=null; 

		var combo = document.getElementById('store'); 

		<?php

		$loopcount=0;

		?>

		combo.options[<?php echo $loopcount;?>] = new Option ("Select Store", ""); 

		<?php

		$query10 = "select * from master_store where location = '$res12anum' and recordstatus = ''";

		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res10 = mysqli_fetch_array($exec10))

		{

		$loopcount = $loopcount+1;

		$res10anum = $res10["storecode"];

		$res10store = $res10["store"];

		?>

			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10store;?>", "<?php echo $res10anum;?>"); 

		<?php 

		}

		?>

	}

	<?php

	}

	?>

	

	

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





function loadprintpage1(banum)

{

	var banum = banum;

	window.open("print_bill1_op1.php?billautonumber="+banum+"","Window"+banum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');

	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');

}





</script>


</head>



<body>



<?php 

$query1 = "select * from purchase_details where entrydate between '$ADate1' and '$ADate2' and typeofpurchase='Process' group by billnumber";

        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));	

					$resnw1=mysqli_num_rows($exec1);

?>


	  <?php if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

			if ($cbfrmflag1 == 'cbfrmflag1')

			{ ?>

       <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1050" 

            align="left" border="0">

          <tbody>

            <tr>
              	<td colspan="11" class="bodytext31" valign="center"  align="center" bgcolor="#ffffff"><div align="center"><strong>Stock Cost Of Sales</strong></div></td>
          	</tr>

              

             <tr>

              <td class="bodytext31" valign="center"  align="left" width="1%"  bgcolor="#ffffff"><div align="left"><strong>Sno.</strong></div></td>
              <td class="bodytext31" valign="center"  align="left" width="6%"  bgcolor="#ffffff"><div align="center"><strong>Item code</strong></div></td>

                <td align="left" valign="center" width="25%"

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Item Name</strong></div></td>

                <td align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Category Name</strong></div></td>


                 <td width="10%" align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Issued Qty</strong></div></td>

                 <td width="10%" align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Returned Qty</strong></div></td>

				 <td width="8%" align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Tot.Qty</strong></div></td>

				<td width="10%" align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Cost Price</strong></div></td>

				<td width="10%" align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Cost Amt</strong></div></td>

				<td width="10%" align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Sales Price</strong></div></td>

				<td width="10%" align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Sales Amt</strong></div></td>

              	             

              </tr>

             

			<?php

			$colorloopcount = '';

			$sno = '';

			$locationcode = isset($_REQUEST['location'])?$_REQUEST['location']:'';

			$store = isset($_REQUEST['store'])?$_REQUEST['store']:'';

			$grandtotalamount_s=0;

			$grandtotalamount_c=0;

			if($store!=""){
					$query_storename = "SELECT store, storecode FROM master_store where storecode='$store' ";
				}else{
						$query_storename = "SELECT store, storecode FROM master_store  ";
				}
				$exec_storename = mysqli_query($GLOBALS["___mysqli_ston"], $query_storename) or die("Error in Query_storename".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res_storename = mysqli_fetch_array($exec_storename)){
				$store_name = $res_storename['store'];
				$store_code = $res_storename['storecode'];

				$query1 = "SELECT *, SUM(quantity) AS quantity1, SUM(totalamount) AS totalamount1 FROM pharmacysales_details WHERE entrydate BETWEEN '".$ADate1."' AND '".$ADate2."' AND locationcode = '".$locationcode."' AND store = '".$store_code."'  GROUP BY itemcode";

					$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));	
					$num2 = mysqli_num_rows($exec1);
					if($num2>0){

				?>
				  	<tr> 
				  		<!-- <td class="bodytext31" valign="center"  align="left"   bgcolor="#ff9933"><div align="left"><strong><?//=$main_serial+=1;?></strong></div></td> -->
				  		<td colspan="11" class="bodytext31" valign="center"  align="left"  bgcolor="#ff9933"><div align="left"><strong><?=$store_name;?></strong></div></td>
            		</tr>

				<?php
					}
					 
					while($res1=mysqli_fetch_array($exec1))
					{	

				// $query_storename = "SELECT store FROM master_store WHERE storecode='$store' ";
				// $exec_storename = mysql_query($query_storename) or die("Error in Query_storename".mysql_error());
				// $res_storename = mysql_fetch_array($exec_storename);
				// $store_name = $res_storename['rate'];


			$store=$res1['store'];
			$itemcode=$res1['itemcode'];

			$itemname=$res1['itemname'];

			$quantity1=$res1['quantity1'];

			$rate=$res1['rate'];

			$totalamount1=$res1['totalamount1'];

			$sales_rate=0;

			$sales_amount=0;





			$querya1 = "select purchaseprice from master_medicine where itemcode='$itemcode' and status=''";

			$execa1 = mysqli_query($GLOBALS["___mysqli_ston"], $querya1) or die ("Error in Querya1".mysqli_error($GLOBALS["___mysqli_ston"]));	

			while($resa1=mysqli_fetch_array($execa1))

			{

				$rate=$resa1['purchaseprice'];

				//$sales_rate=$resa1['rateperunit'];

			}

			$query_rm = "SELECT rate FROM pharma_template_map WHERE productcode='$itemcode' ORDER BY auto_number DESC LIMIT 1";
			$exec_rm = mysqli_query($GLOBALS["___mysqli_ston"], $query_rm) or die("Error in Query_rm".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res_rm = mysqli_fetch_array($exec_rm)){
				$sales_rate = $res_rm['rate'];
			}
			

			$quantity2= 0;

			$totalamount2= 0;

			if($quantity1 > 0)

			{

			$query2 = "SELECT *,SUM(quantity) AS quantity2,SUM(totalamount)AS totalamount2 FROM pharmacysalesreturn_details WHERE itemcode = '".$itemcode."' AND entrydate BETWEEN '".$ADate1."' AND '".$ADate2."' AND locationcode = '".$locationcode."' AND store = '".$store."' GROUP BY itemcode";

			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res2=mysqli_fetch_array($exec2);

			$quantity2=$res2['quantity2'];

			$totalamount2=$res2['totalamount2'];

			}

			$quantity = $quantity1 - $quantity2;

		//	$totalamount = $totalamount1 - $totalamount2;

			$totalamount = $quantity*$rate;

			$sales_amount= $quantity*$sales_rate;



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

	if($quantity2 =='')

	{

		$quantity2=0.00;

	}			

					$query_catname = "SELECT categoryname FROM `master_medicine` WHERE itemcode = '$itemcode'";
					$exec_catname = mysqli_query($GLOBALS["___mysqli_ston"], $query_catname) or die ("Error in Query_catname".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res_catname=mysqli_fetch_array($exec_catname);
					$categoryname=$res_catname['categoryname'];


				

		 ?>

    <tr <?php // echo $colorcode;?>>

        <td class="bodytext3 border" align="left"><?php echo $colorloopcount; ?></td>
        <td class="bodytext3 border" align="left"><?php echo $itemcode; ?></td>

        <td class="bodytext3 border" width="20%" align="left"><?php echo $itemname; ?></td>
         <td class="bodytext3 border"  align="left"><?php echo $categoryname; ?></td>

         <td class="bodytext3 border" align="right"><?php echo number_format($quantity1); ?></td>

          <td class="bodytext3 border" align="right"><?php echo number_format($quantity2); ?></td>

        <td class="bodytext3 border" align="right"><?php echo number_format($quantity); ?></td>

        <td class="bodytext3 border" align="right"><?php echo number_format($rate,2,'.',','); ?></td>

        <td class="bodytext3 border" align="right"><?php echo number_format($totalamount,2,'.',','); ?></td>

        <td class="bodytext3 border" align="right"><?php echo number_format($sales_rate,2,'.',','); ?></td>

        <td class="bodytext3 border" align="right"><?php echo number_format($sales_amount,2,'.',','); ?></td>

        

    </tr>

    <?php 

		$grandtotalamount_c+= $totalamount;

		$grandtotalamount_s+= $sales_amount;



	}
}

//		$totalamountinwords = $transactionamountinwords = covert_currency_to_words($grandtotalamount); 

		

			

		?>

	

    <tr>

    	<td class="bodytext3 border" bgcolor="#ffffff" align="right" colspan="8"><strong>Grand Amount:</strong></td>

	<td class="bodytext3 border" bgcolor="#ffffff" align="right"><strong><?php echo number_format($grandtotalamount_c,2,'.',','); ?></strong>

	<td bgcolor="#ffffff" ></td>

    <td class="bodytext3 border" bgcolor="#ffffff" align="right"><strong><?php echo number_format($grandtotalamount_s,2,'.',','); ?></strong>

        </td>

    <tr>

    	<td class="bodytext3 border" bgcolor="#ffffff" align="right" colspan="10"><strong>Net Amount:</strong></td>

	<td class="bodytext3 border" bgcolor="#ffffff" align="right"><strong><?php echo number_format($grandtotalamount_s-$grandtotalamount_c,2,'.',','); ?></strong></td>

    </tr>

     <tr>

              <td class="bodytext31" valign="center"  align="left"  >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left"  >&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                >&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                >&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" >&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" >&nbsp;</td>

			  <td class="bodytext31" valign="center"  align="left">&nbsp;</td>

			  <td class="bodytext31" valign="center"  align="left" >&nbsp;</td>

			  <td class="bodytext31" valign="center"  align="left">&nbsp;</td>

			 

              </tr>

			 

           <?php }?>

          </tbody>

        </table>





</body>

</html>



