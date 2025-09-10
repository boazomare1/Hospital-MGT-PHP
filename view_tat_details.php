<?php 

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

 

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$curr_time = date('H:i:s');
$curr_time1=strtotime($curr_time);
$deadline_time='01:30';
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

				  <tr><span style="font-size:30px"><strong>Patients TAT</strong></span></tr>

					<td width="10%" align="left" valign="center" colspan="20">

					<div id="marqueecontainer" onMouseover="copyspeed=pausespeed" onMouseout="copyspeed=marqueespeed">

						<div id="vmarquee" style="position: absolute; width: 1000%">

						

						<?php 
						

		 $query1 = "select patientcode,visitcode,patientfullname,consultationdate,accountfullname,username,consultationtime,locationcode from master_visitentry where billtype='PAY LATER' and overallpayment='' and visitcode not in (select visitcode from billing_paylater) and consultationdate='$ADate1' and locationcode IN ($locationcode) order by accountfullname desc";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res1 = mysqli_fetch_array($exec1))
			{
			$totalTime='';
			$consultationtime = $res1['consultationtime'];
			$locationcode1 = $res1['locationcode'];
			$patientfullname = $res1['patientfullname'];
			 $visitcode = $res1['visitcode'];
			$consultationtime1=strtotime($consultationtime);
			$totalTimeInSeconds = $consultationtime1-$curr_time1;
            $totalTimeInSeconds=abs($totalTimeInSeconds);
           // Convert total time difference back to H:i:s format
           $totalTime = gmdate('H:i', $totalTimeInSeconds);
		   
		   
		$query551 = "select locationname from master_location where locationcode='$locationcode1'";
		
		$exec551 = mysqli_query($GLOBALS["___mysqli_ston"], $query551) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$res551 = mysqli_fetch_array($exec551);
		
		$locationnameget = $res551['locationname'];
     
 if($totalTime>=$deadline_time)
 {
		                    ?>

							<h4 valign="center" align="left" class="bodytext3" <?php  ?>>  

							<a target="_blank" href="" style="text-decoration: none"> <span style="font-size:20px; color: #0000FF;"><strong><?php echo $patientfullname; ?></strong></span> - <span style="font-size:20px; color:  #ff0000;"><strong><?php echo $locationnameget; ?></strong></span>  - <span style="font-size:20px; color: #000000;"><strong><?php echo $totalTime; ?></strong></span> </a></h4>

							<?php }  } ?>

						</div>

					</div>					</td>

				</tr>

			</table>

</body>

</html>