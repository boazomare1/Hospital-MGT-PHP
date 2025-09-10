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
?>
<style>
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
</style>
<style type="text/css">

#marqueecontainer{
position: relative;
width: 200px; /*marquee width */
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
			
			<table width="400" height="30" border="0" >
				  
					<td width="10%" align="left" valign="center" >
					<div id="marqueecontainer" onMouseover="copyspeed=pausespeed" onMouseout="copyspeed=marqueespeed">
						<div id="vmarquee" style="position: absolute; width: 98%;">
						
						<?php 
						$query11 = "select * from ipresultentry_lab where recorddate between '$transactiondatefrom' and '$transactiondateto' group by docnumber order by auto_number desc";
						$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
						$num11=mysqli_num_rows($exec11);
						
							while($res11 = mysqli_fetch_array($exec11))
							{
							$res11name= $res11['patientname'];
							$res11visitcode= $res11['patientvisitcode'];
							$res11patientcode= $res11['patientcode'];
							$res11docnumber= $res11['docnumber'];
							//$res11viewstatus= $res11['viewstatus'];
							
					   	
						$query1 = "select * from ipresultentry_lab where patientcode='$res11patientcode' and patientvisitcode='$res11visitcode' and docnumber ='$res11docnumber' and recorddate between '$transactiondatefrom' and '$transactiondateto' group by docnumber order by auto_number desc";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$num1=mysqli_num_rows($exec1);
						
							while($res1 = mysqli_fetch_array($exec1))
							{
							$res1name= $res1['patientname'];
							$res1visitcode= $res1['patientvisitcode'];
							$res1patientcode= $res1['patientcode'];
							$res1docnumber= $res1['docnumber'];
							//$res1viewstatus= $res1['viewstatus'];
         			 
		                    ?>
							<h4 valign="center" align="left" class="bodytext3" <?php  ?>>  
							<a target="_blank" href="#" style="text-decoration: none"><?php echo $res11name; ?> </a></h4>
							<?php } } ?>
						</div>
					</div>					</td>
				</tr>
			</table>
</body>
</html>