<?php
/* $endTime = microtime(true);
$pageLoadTime = $endTime - $startTime;
$pageLoadTime = round($pageLoadTime, 2);
$pagename=basename($_SERVER['REQUEST_URI']); 
//$string=explode('?',$pagename);
//$pagename=$string[0];
$query_sub2 = "select * from master_menusub where submenulink='$pagename'";

$exec_sub2 = mysqli_query($GLOBALS["___mysqli_ston"], $query_sub2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$sub_rows = mysqli_num_rows($exec_sub2);
if($sub_rows!=0){
echo " Loading Time $pageLoadTime seconds";
}

*/
@((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res);
?>
<!--<footer class="sticky-footer bg-white">
			<div class="container my-auto">
				<div class="copyright text-right my-auto">
					<span>&copy;<?=date('Y');?><b> Powered by Kenique</span>
				</div>
			</div>
		</footer> -->