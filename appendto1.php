<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");

$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$timeonly = date("H:i:s");
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$dateonly1 = date("Y-m-d");
$titlestr = 'SALES BILL';

?>

<script type="text/javascript" src="ckeditor1/ckeditor.js"></script>

	
		<script>
			function toggleTextArea1() {
			
		
			CKEDITOR.appendTo( 'section1',
				null,
				'<p><?php echo $_SESSION["username"]; ?></p>'
			);
			}
		</script>
		
		<select name="Class" id="Class" onChange="toggleTextArea1();">
				<option value = '0'>-Select Template-</option>  
				  <?php
				$query5 = "select * from master_radiologytemplate";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5templatename = $res5["templatename"];
				?>
                   <option value="<?php echo $res5anum; ?>"><?php echo $res5templatename; ?></option>
                    <?php
				}
				?>
       		</select>
			
		
				
		<div id="section1"></div>	
