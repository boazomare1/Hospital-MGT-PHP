<?php 

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

 

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

include ("db/db_connect.php"); 

$transactiondatefrom = date('Y-m-d', strtotime('-1 day'));

$transactiondateto = date('Y-m-d');


if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $transactiondatefrom; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $transactiondateto; }
if (isset($_REQUEST["storecode"])) { $storecode = $_REQUEST["storecode"]; } else { $storecode = $storecode; }
if (isset($_REQUEST["locationcode"])) { $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = $locationcode; }



?>

<style>

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

</style>

<style type="text/css">



#marqueecontainer{

position: relative;

width: 5000px; /*marquee width */

height: 200px; /*marquee height */

overflow: hidden;

padding: 1px;

padding-left: 4px;

}

//a { color:black; } 

</style>



<script type="text/javascript">



var delayb4scroll=1000 //Specify initial delay before marquee starts to scroll on page (2000=2 seconds)

var marqueespeed=1 //Specify marquee scroll speed (larger is faster 1-10)

var pauseit=1 //Pause marquee onMousever (0=no. 1=yes)?



////NO NEED TO EDIT BELOW THIS LINE////////////



var copyspeed=marqueespeed

var pausespeed=(pauseit==0)? copyspeed: 0

var actualheight=''



function scrollmarquee(){

if (parseInt(cross_marquee.style.top)>(actualheight*(-1)+8)) //if scroller hasn't reached the end of its height

cross_marquee.style.top=parseInt(cross_marquee.style.top)-copyspeed+"px" //move scroller upwards

else //else, reset to original position

cross_marquee.style.top=parseInt(marqueeheight)+8+"px"

}



function initializemarquee(){

cross_marquee=document.getElementById("vmarquee")

cross_marquee.style.top=0

marqueeheight=document.getElementById("marqueecontainer").offsetHeight

actualheight=cross_marquee.offsetHeight //height of marquee content (much of which is hidden from view)

if (window.opera || navigator.userAgent.indexOf("Netscape/7")!=-1){ //if Opera or Netscape 7x, add scrollbars to scroll and exit

cross_marquee.style.height=marqueeheight+"px"

cross_marquee.style.overflow="scroll"

return

}

setTimeout('lefttime=setInterval("scrollmarquee()",30)', delayb4scroll)

}



if (window.addEventListener)

window.addEventListener("load", initializemarquee, false)

else if (window.attachEvent)

window.attachEvent("onload", initializemarquee)

else if (document.getElementById)

window.onload=initializemarquee

</script>

<body>

			

			<table width="1000" height="30" border="0" >

				  

					<td width="10%" align="left" valign="center" colspan="20">

					<div id="marqueecontainer" onMouseover="copyspeed=pausespeed" onMouseout="copyspeed=marqueespeed">

						<div id="vmarquee" style="position: absolute; width: 1000%">

						

						<?php 
						
						 //$query1 = "select ts.itemcode as itemcode,pd.expirydate as expirydate,pd.suppliername as suppliername,ts.batchnumber as batchnumber,ts.itemname as itemname,ts.batch_quantity as batch_quantity,pd.categoryname as categoryname from transaction_stock as ts LEFT JOIN purchase_details as pd ON ts.fifo_code = pd.fifo_code where ts.batch_stockstatus = 1 and ts.locationcode = '$locationcode' and pd.expirydate BETWEEN '".$ADate1."' and '".$ADate2."' and ts.storecode='$storecode' group by ts.batchnumber";
						 
						 
						 $query01="select * from (select a.auto_number as auto_number,trim(a.itemname) as itemname,a.itemcode as itemcode,sum(a.batch_quantity) as batch_quantity,a.batchnumber as batchnumber,a.rate as rate,c.categoryname as category,c.genericname,  a.locationcode,a.storecode,a.fifo_code,b.expirydate as expirydate from transaction_stock a left JOIN (select * from (
		select billnumber,itemcode,expirydate,fifo_code from purchase_details where ((not((billnumber like 'GRN-%'))) and (itemcode <> '')) and expirydate BETWEEN '".$ADate1."' and '".$ADate2."' group by itemcode,fifo_code,expirydate
		union all 
		select billnumber,itemcode,expirydate,fifo_code from materialreceiptnote_details where (itemcode <> '') and expirydate BETWEEN '".$ADate1."' and '".$ADate2."'  group by itemcode,fifo_code,expirydate
		) as a group by itemcode,fifo_code,expirydate) as b ON a.fifo_code=b.fifo_code left JOIN  master_medicine as c ON (a.itemcode=c.itemcode)  where a.storecode='$storecode' AND a.locationcode='$locationcode'   and a.itemcode <> ''  and b.expirydate BETWEEN '".$ADate1."' and '".$ADate2."' group by a.batchnumber,b.expirydate,a.itemcode) as final  order by IF(final.itemname RLIKE '^[a-z]', 1, 2), final.itemname";
		
	 //echo $query01;

		$run01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);

		while($exec01=mysqli_fetch_array($run01))

		{

			$medanum=$exec01['auto_number'];

			$itemname=$exec01['itemname'];

			$itemcode=$exec01['itemcode']; 

			$batchnumber=$exec01['batchnumber'];

			$category = $exec01['category'];

			$fifo_code = $exec01['fifo_code'];
			
			$store=$storecode;

			
			
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

		//	$query99 = "select * from purchase_details where recordstatus <> 'DELETED' and companyanum = '$companyanum' and locationcode = '".$locationcode."' and store ='".$store."'  group by batchnumber";

		$query1 = "select sum(transaction_quantity) as currentstock  from transaction_stock as a join (
		
			select itemcode, expirydate,batchnumber,fifo_code from purchase_details where itemcode='$itemcode' and batchnumber='$batchnumber' and expirydate='$expirydate' group by fifo_code,expirydate, batchnumber 
			union all
			select itemcode,expirydate,batchnumber,fifo_code FROM materialreceiptnote_details WHERE itemcode='$itemcode' and batchnumber='$batchnumber' and expirydate='$expirydate' group by fifo_code,expirydate, batchnumber
			
			) as b on a.batchnumber=b.batchnumber and a.itemcode=b.itemcode and a.fifo_code=b.fifo_code	where a.transactionfunction='1' and a.batchnumber='$batchnumber' and a.itemcode='$itemcode' and a.locationcode='$locationcode' and a.storecode='$store'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$currentstock1 = $res1['currentstock'];

			$query1 = "select sum(transaction_quantity) as currentstock  from transaction_stock as a join (
		
			select itemcode, expirydate,batchnumber,fifo_code from purchase_details where itemcode='$itemcode' and batchnumber='$batchnumber' and expirydate='$expirydate' group by fifo_code,expirydate, batchnumber 
			union all
			select itemcode,expirydate,batchnumber,fifo_code FROM materialreceiptnote_details WHERE itemcode='$itemcode' and batchnumber='$batchnumber' and expirydate='$expirydate' group by fifo_code,expirydate, batchnumber
			
			) as b on a.batchnumber=b.batchnumber and a.itemcode=b.itemcode and a.fifo_code=b.fifo_code	where a.transactionfunction='0' and a.batchnumber='$batchnumber' and a.itemcode='$itemcode' and a.locationcode='$locationcode' and a.storecode='$store'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$currentstock2 = $res1['currentstock'];

			$batch_quantity= $currentstock1-$currentstock2;

			if(!$batch_quantity)
			{
				$batch_quantity = 0;
			}



			$rate=$exec01['rate'];
			
if($batch_quantity>0){
						         			 

		                    ?>

							<h4 valign="center" align="left" class="bodytext3" <?php  ?>>  

							<a target="_blank" href="stockreportbyexpirydate1.php?frmflag1=frmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&store=<?php echo $storecode; ?>&&location=<?php echo $locationcode; ?>" style="text-decoration: none"> <span style="font-size:20px; color: #000000;"><strong><?php echo $itemname; ?></strong></span> - <span style="font-size:20px; color: #0000FF;"><strong><?php echo $batchnumber; ?></strong></span>  - <span style="font-size:20px; color: #ff0000;"><strong><?php echo $expirydate; ?></strong></span> </a></h4>

							<?php }  }?>

						</div>

					</div>					</td>

				</tr>

			</table>

</body>

</html>