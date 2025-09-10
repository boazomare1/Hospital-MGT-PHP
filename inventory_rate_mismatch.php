<html>
<?php
include ("db/db_connect.php");
?>
<body>
	<table border="1">


			<?php	
				$sno=0;
				$querycr1in_2 = "SELECT * FROM `master_subtype` ";						   
				$execcr1_2 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in_2) or die ("Error in querycr1in_2".mysqli_error($GLOBALS["___mysqli_ston"]));				
				while($rescr1_2 = mysqli_fetch_array($execcr1_2))
				{

					$dynamic_column = "subtype_". $rescr1_2['auto_number'];

		?>

						<tr>
						<th colspan="8">  <?= $rescr1_2['subtype'] ?> </th>
						</tr>

						<tr>
						<th>Sno</th>
						<th>Itemcode</th>
						<th>Itemname</th>
						<th>Cateogry</th>
						<th>Type</th>
						<th><?= $dynamic_column ?></th>
						<th>Template Rate</th>
						<th>Difference</th>
						</tr>

			<?php	
					$sno=0;
					$querycr1in = "SELECT * FROM `master_medicine`";						   
					$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));				
					while($rescr1 = mysqli_fetch_array($execcr1))
					{

						$querycr1in_1 = "SELECT * FROM `pharma_template_map` where productcode='".$rescr1['itemcode']."' order by auto_number desc limit 0,1";
						$execcr1_1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in_1) or die ("Error in querycr1in_1".mysqli_error($GLOBALS["___mysqli_ston"]));		
						$rescr1_1 = mysqli_fetch_array($execcr1_1);

						if(isset($rescr1_1['rate']) && (float)$rescr1_1['rate']!=(float)$rescr1[$dynamic_column]  ){
							echo "<tr>";
							echo "<td>".++$sno."</td>";
							echo "<td>".$rescr1['itemcode']."</td>";
							echo "<td>".$rescr1['itemname']."</td>";
							echo "<td>".$rescr1['categoryname']."</td>";
							echo "<td>".$rescr1['type']."</td>";
							echo "<td>".$rescr1[$dynamic_column]."</td>";
							echo "<td>".$rescr1_1['rate']."</td>";
							echo "<td>".round($rescr1_1['rate']-$rescr1[$dynamic_column],2)."</td>";
							echo "</tr>";

							$query_st = "SELECT * FROM master_subtype WHERE pharmtemplate = '1'";
							$exec_st = mysqli_query($GLOBALS["___mysqli_ston"], $query_st) or die ("Error in Query_st".mysqli_error($GLOBALS["___mysqli_ston"]));
							$count=0;
							$col = "";
							while($res_st = mysqli_fetch_array($exec_st)){
								$count++;
								$subtype = $res_st['auto_number'];
			                    
			                    if($count > 1){
									$col .=',';
								}

								$col .= 'subtype_'.$subtype." = ".$rescr1_1['rate'];
							}
							$sqlquery_st_med= "UPDATE master_medicine SET $col WHERE itemcode = '".$rescr1['itemcode']."'";
						    $exequery_st_med = mysqli_query($GLOBALS["___mysqli_ston"], $sqlquery_st_med);

						}
					 }
					?>
						<tr>
						<th colspan="8">DATA <?= $rescr1_2['auto_number'] ?> <?= $rescr1_2['subtype'] ?> <?= $sno ?> </th>
						</tr>

			<?php
				}
			?>

              
</table>
</body>
</html>

