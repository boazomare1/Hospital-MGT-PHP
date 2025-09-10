<?php
session_start();

include ("db/db_connect.php");
$recorddate = date('Y-m-d');
$recordtime = date('H:i:s');
$updatetime = date('Y-m-d H:i:s');
$user = $_SESSION['username'];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$rec_limit=20;
 $icdsearch=isset($_REQUEST['icdsearch'])?$_REQUEST['icdsearch']:'';
?>

 <tr bgcolor="#011E6A">
                        <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>ICD Name Master - Existing List </strong></td>
                        <td colspan="3" bgcolor="#ecf0f5" class="bodytext3" align="right">
                        <?php 
						  $sno='';
	     
						if( isset($_GET{'page'} ) ) {
           $page = $_GET['page'] + 1;
            $offset = $rec_limit * $page ;
         }else {
            $page = 0;
            $offset = 0;
         }
		   $query2 = "select * from master_icd where recordstatus ='active' and disease like '%$icdsearch%' or description like '%$icdsearch%' order by auto_number desc LIMIT $offset, $rec_limit";
		
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rec_count=mysqli_num_rows($exec2);
          if( $page > 0 ) {
            $last = $page - 2;
            echo "<a href = \"addicd.php?page=$last\">Prev</a> |&nbsp;";
            echo "<a href = \"addicd.php?page=$page\">Next</a>";
         }else if( $page == 0 ) {
            echo "<a href = \"addicd.php?page=$page\">Next</a>";
         }else if( $left_rec < $rec_limit ) {
            $last = $page - 2;
            echo "<a href = \"addicd.php?page=$last\">Previous</a>";
         }
		 
         $left_rec = $rec_count - ($page * $rec_limit);
						?>
                        </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" bgcolor="#ffffff"  class="bodytext3"><strong></strong></td>
                        <td width="37%" align="left" valign="top" bgcolor="#ffffff"  class="bodytext3"><strong>Disease </strong></td>
                        <td width="32%" align="left" valign="top" bgcolor="#ffffff"  class="bodytext3"><strong>Description</strong></td>
						<td width="13%" align="left" valign="top" bgcolor="#ffffff"  class="bodytext3"><strong>ICD Code</strong></td>
						<td width="12%" align="left" valign="top" bgcolor="#ffffff"  class="bodytext3"><strong>Chapter</strong></td>
                        
                      </tr>
<?php
	while ($res2 = mysqli_fetch_array($exec2))
		{
		$res2disease = $res2['disease'];
		$res2description = $res2['description'];
		$res2icdcode = $res2['icdcode'];
		$res2chapter = $res2['chapter'];
	    $res2auto_number = $res2["auto_number"];
		$sno = $sno + 1;
		
		$colorloopcount = $colorloopcount + 1;
		$showcolor = ($colorloopcount & 1); 
		if ($showcolor == 0)
		{
			$colorcode = 'bgcolor="#CBDBFA"';
		}
		else
		{
			$colorcode = 'bgcolor="#ecf0f5"';
		}
		  
		?>
                      <tr <?php echo $colorcode; ?>>
                        <td width="6%" align="left" valign="top"  class="bodytext3"><div align="center"><a href="addicd.php?st=del&&anum=<?php echo $res2auto_number; ?>"><img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $res2disease; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $res2description; ?> </td>
						<td align="left" valign="top"  class="bodytext3"><?php echo $res2icdcode; ?> </td>
						<td align="left" valign="top"  class="bodytext3"><?php echo $res2chapter; ?> </td>
                        
                      </tr>
                     <?php 
		}
		
		
?>