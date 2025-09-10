<?php
include ("db/db_connect.php");
						
							$query1 = "select * from master_testtemplate where testname = 'services' order by templatename";
							$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
							while ($res1 = mysqli_fetch_array($exec1))
						{						
								$templatename = $res1["templatename"];
								$query2 = "ALTER TABLE `$templatename` DROP `ledgername` ,DROP `ledgerid` ";
							$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
							
echo $templatename."<br>";
                        }
?>




