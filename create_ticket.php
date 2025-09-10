<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
?>

<div id="section_700">
	<div id="server_message">
		<div class="info">
		<p>Please fill out the form below and click the "Submit" button.</p>
		</div>
	</div>
	<form name="createticket" id="createticket" method="post" action="create_ticket.php">
		<table border="0">
			<tr><th colspan="4"><p>Issue Description:</p></th></tr>
			<tr><td colspan="4"><textarea name="issue" class="k-textbox" id="textarea_full_100"></textarea></td></tr>
			<tr><th><p>Quick Ticket:</p></th><th><p>User:</p></th><th><p>Office/Room:</p></th><th colspan="2"><p>Attachment:</p></th></tr>
			
			<!--<tr>
				<td>
					<select name="quick_ticket" id="quick_ticket">
					<option value="null"></option>
					<?php
					$sql = "SELECT * FROM department ORDER BY d_name";
					$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
					$num = mysqli_num_rows($result);
					$i = 0;
					while ($i < $num) {
						
						$quick_ticket_id = mysqli_result($result,  $i,  "quick_ticket_id");
						$quick_ticket_name = mysqli_result($result,  $i,  "quick_ticket_name");
						echo '<option value="'.$quick_ticket_id.'">'.$quick_ticket_name.'</option>';
						
						$i++;
					}
					?>
					
					</select>
				</td>
				<td>
					<select name="end_user" id="end_user">
					
					<?php
					echo '<option value="null"></option>';
					$sql = "SELECT * FROM users WHERE user_id != '1' ORDER BY user_last_name";
					$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
					$num = mysqli_num_rows($result);
					$i = 0;
					while ($i < $num) {
						
						$user_id = mysqli_result($result,  $i,  "user_id");
						$user_first_name = mysqli_result($result,  $i,  "user_first_name");
						$user_last_name = mysqli_result($result,  $i,  "user_last_name");
						echo '<option value="'.$user_id.'">'.$user_first_name.' '.$user_last_name.'</option>';
						
						$i++;
					}
					?>
					
					</select>
				</td>
				<td><input type="text" name="ticket_office_room" id="ticket_office_room" class="k-textbox" /></td>
				<td colspan="2"><input type="file" name="ticket_attachement" id="ticket_attachement" /></td>
			</tr>-->
			
			<tr><th><p>Issue Category:</p></th><th><p>Issue Priority:</p></th><th><p>Assigned To:</p></th><th><p>Location:</p></th></tr>

			<tr>
				<td>
					<select name="category" id="category">
					
					<?php
					$sql = "SELECT * FROM ticket_categories ORDER BY ticket_category_name";
					$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
					$num = mysqli_num_rows($result);
					$i = 0;
					while ($i < $num) {
						
						$ticket_category_id = mysqli_result($result,  $i,  "ticket_category_id");
						$ticket_category_name = mysqli_result($result,  $i,  "ticket_category_name");
						echo '<option value="'.$ticket_category_id.'">'.$ticket_category_name.'</option>';
						
						$i++;
					}
					?>
					
					</select>
				</td>
				<td>
					<select name="priority" id="priority">
					
					<?php
					$sql = "SELECT * FROM ticket_priorities ORDER BY ticket_priority_id";
					$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
					$num = mysqli_num_rows($result);
					$i = 0;
					while ($i < $num) {
						
						$ticket_priority_id = mysqli_result($result,  $i,  "ticket_priority_id");
						$ticket_priority_name = mysqli_result($result,  $i,  "ticket_priority_name");
						echo '<option value="'.$ticket_priority_id.'">'.$ticket_priority_name.'</option>';
						
						$i++;
					}
					?>
					
					</select>
				</td>
				<td>
					<select name="assigned" id="assigned">
					
					<?php
					
					
					
					$sql = "SELECT * FROM users WHERE user_id = '$_SESSION[user_id]'";
					$result = mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], $sql));
					
					$user_id = $result['user_id'];
					$user_first_name = $result['user_first_name'];
					$user_last_name = $result['user_last_name'];
					
					echo '<option value="'.$user_id.'">'.$user_first_name.' '.$user_last_name.'</option>';
					echo '<option value="0">Un-Assigned</option>';
					$sql = "SELECT * FROM users WHERE user_id != '1' AND user_id != '$_SESSION[user_id]' AND user_acl_id >= '5' ORDER BY user_last_name";
					$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
					$num = mysqli_num_rows($result);
					$i = 0;
					while ($i < $num) {
						
						$user_id = mysqli_result($result,  $i,  "user_id");
						$user_first_name = mysqli_result($result,  $i,  "user_first_name");
						$user_last_name = mysqli_result($result,  $i,  "user_last_name");
						echo '<option value="'.$user_id.'">'.$user_first_name.' '.$user_last_name.'</option>';
						
						$i++;
					}
					?>
					
					</select>
				</td>
				<td>
					<select name="location" id="location">
					
					<?php
					$sql = "SELECT * FROM locations WHERE location_type != '3' ORDER BY location_name";
					$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
					echo mysqli_error($GLOBALS["___mysqli_ston"]);
					$num = mysqli_num_rows($result);
					$i = 0;
					while ($i < $num) {
						
						$location_id = mysqli_result($result,  $i,  "location_id");
						$location_name = mysqli_result($result,  $i,  "location_name");
						//$user_last_name = mysql_result($result, $i, "user_last_name");
						echo '<option value="'.$location_id.'">'.$location_name.'</option>';
						
						$i++;
					}
					?>
					
					</select>
				</td>
			</tr>
			<?php
			//CHECK FOR CUSTOM DETAILS
			$sql = "SELECT * FROM custom_details WHERE custom_detail_mod_name = 'tickets'";
			$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
			$num = mysqli_num_rows($result);
			echo mysqli_error($GLOBALS["___mysqli_ston"]);
			$i = 0;
			$t = 0;
			if($num > 0) {
			echo '<tr><th colspan="4"><br />Custom Details: <br /><hr /></th></tr>';
			echo '<tr>';
			while($i < $num) {
			
				$custom_detail_common_name = mysqli_result($result,  $i,  "custom_detail_common_name");
				$custom_detail_display_name = mysqli_result($result,  $i,  "custom_detail_display_name");
				
					echo '<th align="right">'.$custom_detail_display_name.':</th><td><input type="text" name="'.$custom_detail_common_name.'" class="k-textbox" /></td>';
					if ($i % 2 != 0) {
					echo '</tr>';
					}
				$i++;
			}
			
			?>
			<tr><th colspan="4"><br /><br /><hr /></th></tr>
			<?php } ?>
			<tr><td align="center" colspan="4"><input type="submit" name="submit" value="Submit" class="k-button" /></td></tr>
		</table>
	</form>
</div>

<script type="text/javascript"> 
$(document).ready(function() {
	//jQuery.noConflict();
	$("#category").kendoComboBox();
	$("#priority").kendoDropDownList();
	$("#quick_ticket").kendoComboBox();
	$("#assigned").kendoComboBox();
	$("#end_user").kendoComboBox();
	$("#location").kendoComboBox();
	$("#state").kendoDropDownList();
 
    $('#createticket').ajaxForm({ 
        // target identifies the element(s) to update with the server response 
        target: '#server_message', 
 
        // success identifies the function to invoke when the server response 
        // has been received; here we apply a fade-in effect to the new content 
        success: function() { 
            $('#server_message').fadeIn("slow"); 
            
            reloadPane();
            
        } 
    });
    

});


</script>

<?php

?>