<?php
session_start();

set_time_limit(0);

include ("includes/loginverify.php");

include ("db/db_connect.php");

date_default_timezone_set('Asia/Calcutta'); 

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$errmsg = "";

$colorloopcount = '';

$openingbalance = 0;

$user = '';   

//To populate the autocompetelist_services1.js

header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="Expirystock.xls"');

header('Cache-Control: max-age=80');



$transactiondatefrom = date('Y-m-d', strtotime('-1 week'));

$transactiondateto = date('Y-m-d');



 $ADate1 = $transactiondatefrom;

  $ADate2 = $transactiondateto;

if (isset($_REQUEST["medicinecode"])) { $medicinecode = $_REQUEST["medicinecode"]; } else { $medicinecode = ""; }





if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

//$frmflag1 = $_REQUEST['frmflag1'];

if (isset($_REQUEST["searchitemcode"])) { $medicinecode = $_REQUEST["searchitemcode"]; } else { $medicinecode = ""; }

//$medicinecode = $_REQUEST['medicinecode'];

if (isset($_REQUEST["searchmedicinename"])) {  $searchmedicinename = $_REQUEST["searchmedicinename"]; } else { $searchmedicinename = ""; }

if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }

if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $transactiondatefrom; }

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $transactiondateto; }



$docno = $_SESSION['docno'];

$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

	

	 $locationname  = $res["locationname"];

	 $locationcode = $res["locationcode"];

	 $res12locationanum = $res["auto_number"];

	 

  $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';

  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

?>

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #FFFFFF;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

-->

</style>

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; }

-->

</style>

</head>

<body>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1000"

            align="left" border="1">

          <tbody>

		   <tr>

              <td colspan="9" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>Expiry Stock</strong></td>

		   </tr>

		   <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></td>		

              <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Code </strong></td>

              <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Category </strong></td>

              <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Item Name </strong></td>

              <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Batch No </strong></td>

              <td align="left" valign="center"  

                bgcolor="#ffffff" class="style1">Expiry Date </td>

              <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Supplier Name </strong></div></td>

              <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Quantity</strong></div></td>

				<td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Cost</strong></div></td>

              </tr>

        		<?php

				if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = "frmflag1"; }

//$frmflag1 = $_REQUEST['frmflag1'];

if ($frmflag1 == 'frmflag1')

{



if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }

if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }



?>

<?php



				$noofdays=strtotime($ADate2) - strtotime($ADate1);

				$noofdays = $noofdays/(3600*24);

				//get store for location

				$loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';

				$username=isset($_REQUEST['username'])?$_REQUEST['username']:'';

				

				$sno=0;



				//$query99 = "select ts.itemcode as itemcode,pd.expirydate as expirydate,pd.suppliername as suppliername,ts.batchnumber as batchnumber,ts.itemname as itemname,ts.batch_quantity as batch_quantity,pd.categoryname as categoryname,ts.rate as cost from transaction_stock as ts LEFT JOIN purchase_details as pd ON ts.batchnumber = pd.batchnumber where ts.batch_stockstatus = 1 and ts.locationcode = '".$loc."' and ts.storecode ='".$store."' and pd.categoryname like '%".$categoryname."%'  and pd.expirydate BETWEEN '".$ADate1."' and '".$ADate2."' and pd.companyanum = '$companyanum' ";
	
				//$query99 .= " and ts.itemname like '%".$searchmedicinename."%'";
	
	
	
	//$query99 .= " group by ts.batchnumber";

				//echo $query99;

        $query01="select * from (select a.auto_number as auto_number,trim(a.itemname) as itemname,a.itemcode as itemcode,sum(a.batch_quantity) as batch_quantity,a.batchnumber as batchnumber,a.rate as rate,c.categoryname as category,c.genericname,  a.locationcode,a.storecode,a.fifo_code,b.expirydate as expirydate from transaction_stock a left JOIN (select * from (
    select billnumber,itemcode,expirydate,fifo_code from purchase_details where ((not((billnumber like 'GRN-%'))) and (itemcode <> '')) and expirydate BETWEEN '".$ADate1."' and '".$ADate2."' and itemname like '%".$searchmedicinename."%' group by itemcode,fifo_code,expirydate
    union all 
    select billnumber,itemcode,expirydate,fifo_code from materialreceiptnote_details where (itemcode <> '') and expirydate BETWEEN '".$ADate1."' and '".$ADate2."' and itemname like '%".$searchmedicinename."%' group by itemcode,fifo_code,expirydate
    ) as a group by itemcode,fifo_code,expirydate) as b ON a.fifo_code=b.fifo_code left JOIN  master_medicine as c ON (a.itemcode=c.itemcode)  where a.storecode='$store' AND a.locationcode='$loc' and  c.categoryname like '%".$categoryname."%'  and a.itemcode <> ''  and b.expirydate BETWEEN '".$ADate1."' and '".$ADate2."' group by a.batchnumber,b.expirydate,a.itemcode) as final  order by IF(final.itemname RLIKE '^[a-z]', 1, 2), final.itemname";
  

				//$exec99 = mysql_query($query99) or die ("Error in Query99".mysql_error());

				//echo mysql_num_rows($exec99);

			$run01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);

    while($exec01=mysqli_fetch_array($run01))

    {

      $medanum=$exec01['auto_number'];

      $itemname=$exec01['itemname'];

      $itemcode=$exec01['itemcode']; 

      $batchnumber=$exec01['batchnumber'];

      $category = $exec01['category'];

      $fifo_code = $exec01['fifo_code'];

      
      
      // $query03="select SUM(batch_quantity) as batch_quantity FROM transaction_stock WHERE itemcode='$itemcode' AND storecode='".$storecode."' AND locationcode='".$locationcode."' AND batch_quantity > '0' AND batch_stockstatus ='1' and batchnumber='$batchnumber' and fifo_code = '$fifo_code'";

      // $run03=mysql_query($query03);

      // $exec03=mysql_fetch_array($run03);       

      $batch_quantity=$exec01['batch_quantity'];

      

      $query04="select expirydate,suppliername FROM purchase_details WHERE itemcode='$itemcode' and fifo_code='$fifo_code' group by expirydate, batchnumber asc";

      $run04=mysqli_query($GLOBALS["___mysqli_ston"], $query04);

      $exec04=mysqli_fetch_array($run04);  

      $expirydate=$exec04['expirydate'];
      $suppliername = $exec04['suppliername'];

      if($expirydate=='')

      {

        $query05="select expirydate,suppliername FROM materialreceiptnote_details WHERE itemcode='$itemcode' and fifo_code='$fifo_code' order by expirydate, batchnumber asc";

        $run05=mysqli_query($GLOBALS["___mysqli_ston"], $query05);

        $exec05=mysqli_fetch_array($run05);  

        $expirydate=$exec05['expirydate'];
        if($suppliername =="")
        $suppliername = $exec05['suppliername'];

      }


  //itemname = '".$searchitemname."'

    //  $query99 = "select * from purchase_details where recordstatus <> 'DELETED' and companyanum = '$companyanum' and locationcode = '".$locationcode."' and store ='".$store."'  group by batchnumber";

    $query1 = "select sum(transaction_quantity) as currentstock  from transaction_stock as a join (
    
      select itemcode, expirydate,batchnumber,fifo_code from purchase_details where itemcode='$itemcode' and batchnumber='$batchnumber' and expirydate='$expirydate' group by fifo_code,expirydate, batchnumber 
      union all
      select itemcode,expirydate,batchnumber,fifo_code FROM materialreceiptnote_details WHERE itemcode='$itemcode' and batchnumber='$batchnumber' and expirydate='$expirydate' group by fifo_code,expirydate, batchnumber
      
      ) as b on a.batchnumber=b.batchnumber and a.itemcode=b.itemcode and a.fifo_code=b.fifo_code where a.transactionfunction='1' and a.batchnumber='$batchnumber' and a.itemcode='$itemcode' and a.locationcode='$locationcode' and a.storecode='$store'";
      $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
      $res1 = mysqli_fetch_array($exec1);
      $currentstock1 = $res1['currentstock'];

      $query1 = "select sum(transaction_quantity) as currentstock  from transaction_stock as a join (
    
      select itemcode, expirydate,batchnumber,fifo_code from purchase_details where itemcode='$itemcode' and batchnumber='$batchnumber' and expirydate='$expirydate' group by fifo_code,expirydate, batchnumber 
      union all
      select itemcode,expirydate,batchnumber,fifo_code FROM materialreceiptnote_details WHERE itemcode='$itemcode' and batchnumber='$batchnumber' and expirydate='$expirydate' group by fifo_code,expirydate, batchnumber
      
      ) as b on a.batchnumber=b.batchnumber and a.itemcode=b.itemcode and a.fifo_code=b.fifo_code where a.transactionfunction='0' and a.batchnumber='$batchnumber' and a.itemcode='$itemcode' and a.locationcode='$locationcode' and a.storecode='$store'";
      $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
      $res1 = mysqli_fetch_array($exec1);
      $currentstock2 = $res1['currentstock'];

      $batch_quantity= $currentstock1-$currentstock2;

      if(!$batch_quantity)
      {
        $batch_quantity = 0;
      }



      $rate=$exec01['rate'];

      

      

      

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
			if($batch_quantity>0){
			$sno = $sno + 1;

			?>

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                ><?php echo $sno; ?></td>

              <td align="left" valign="center"  

                 class="bodytext31"><div class="bodytext31"><?php echo $itemcode; ?></div></td>

              <td align="left" valign="center"  

                 class="bodytext31"><div class="bodytext31"><?php echo $category;?></div></td>

              <td align="left" valign="center"  

                 class="bodytext31"><div class="bodytext31"><?php echo $itemname; ?></div></td>

              <td align="left" valign="center"  

                 class="bodytext31"><div class="bodytext31">

                <div align="left"><?php echo $batchnumber; ?>&nbsp;</div>

              </div></td>

              <td align="left" valign="center"  

                 class="bodytext31"><div class="bodytext31">

                <div align="left"><?php echo $expirydate; ?>&nbsp;</div>

              </div></td>

              <td align="left" valign="center"  

                 class="bodytext31"><div align="right">

                <div class="bodytext31">

                  <div align="left"><?php echo $suppliername; ?>&nbsp;</div>

                </div>

              </div></td>

              <td align="left" valign="center"  

                 class="bodytext31"><div class="bodytext31">

                <div align="left"><?php echo $batch_quantity; ?>&nbsp;</div>

              </div></td>

			  <td align="left" valign="center"  
                 class="bodytext31"><div class="bodytext31">
                <div align="right"><?php echo $rate; ?>&nbsp;</div>
              </div></td>

              </tr>

          

			<?php
	}
			}

			}

			?>



            <tr>

              <td colspan="2" class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF"><div align="right"><strong>

                <?php //echo $totalcurrentstock1; ?>&nbsp;</strong></div></td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF">&nbsp;</td>

				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF"><div align="right"><strong>

                <?php //echo $totalitemrate1; ?>&nbsp;</strong></div></td>

				 </tr>

			</tbody>

		</table>

</body>

</html>

