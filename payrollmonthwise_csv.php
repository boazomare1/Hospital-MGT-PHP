<?php
session_start();
$pagename = '';
if (!isset($_SESSION['username'])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$sessionusername = $_SESSION['username'];
$username = $_SESSION['username'];

if (isset($_REQUEST["frmflag34"])) { $frmflag34 = $_REQUEST["frmflag34"]; } else { $frmflag34 = ""; }
if (isset($_REQUEST["assignmonth"])) { $assignmonth = $_REQUEST["assignmonth"]; } else { $assignmonth = ""; }
if($frmflag34 == 'frmflag34')
{
	if (isset($_REQUEST["searchcomponent"])) { $searchcomponent = $_REQUEST["searchcomponent"]; } else { $searchcomponent = ""; }
	if($searchcomponent != '')
	{
		$comsplit = explode('|',$searchcomponent);
		$component = $comsplit[0];
		$componentname = $comsplit[1];
		$componentname1 = $comsplit[1];
	
		$componentname = str_replace(' ','_',$componentname);
		
		header("Content-Type: application/csv");
		header("Content-Disposition: attachment;Filename=".$componentname."_".$assignmonth.".csv");
		
		echo "Employeecode".',';
		echo "Employeename".',';
		echo "ComponentId".',';
		echo "Componentname".',';
		echo "Amount".','."\n";
			
		$query245 = "select employeecode, employeename from master_employee where (payrollstatus = 'Active' or payrollstatus = 'Prorata') group by employeecode order by employeecode";
		$exec245 = mysqli_query($GLOBALS["___mysqli_ston"], $query245) or die ("Error in Query245".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res245 = mysqli_fetch_array($exec245))
		{
			$res2employeecode = $res245['employeecode'];
			$res2employeename = $res245['employeename'];
			$employeesearch = $res2employeecode;
			
			$query9 = "select `$component` as component from payroll_assign where status <> 'deleted' and employeecode = '$res2employeecode'";
			$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res9 = mysqli_fetch_array($exec9))
			{
				echo $res2employeecode.',';
				echo $res2employeename.',';
				echo $component.',';
				echo $componentname1.',';
				echo "0.00".','."\n";
			}
		}	
	}	
}	
?>