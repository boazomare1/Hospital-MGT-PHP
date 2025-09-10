<?php
$query23 = "select * from master_bedcharge where bed='$bed' and recordstatus <> 'deleted'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($res23 = mysqli_fetch_array($exec23))
{
$itemcount = $itemcount + 1;
$charge = $res23['charge'];
$rate = $res23['rate'];

?>
<TR id="idTR<?php echo $itemcount; ?>">
<td id="idTD1<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">
<input name="charge[]" value="<?php echo $charge; ?>" id="serialnumber<?php echo $itemcount; ?>" readonly="readonly" style="border: 0px solid #001E6A; text-align:left" size="20" />
</td>
<td id="idTD2<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">
<input name="rate8[]" value="<?php echo $rate; ?>" id="rate8<?php echo $itemcount; ?>" style="border: 0px solid #001E6A; text-align:left" size="10" readonly="readonly" />
</td>

<td id="idTD3<?php echo $itemcount; ?>" align="right" valign="top"  bgcolor="#FFFFFF" class="bodytext3">
<!--<input onClick="return btnFreeClick(<?php echo $itemcount; ?>)" name="btnfree<?php echo $itemcount; ?>" id="btnfree<?php echo $itemcount; ?>" type="hidden" value="Free" class="button" style="border: 1px solid #001E6A"/>-->
<input onClick="return btnDeleteClick9(<?php echo $itemcount; ?>)" name="btndelete<?php echo $itemcount; ?>" id="btndelete<?php echo $itemcount; ?>" type="button" value="Del" class="button" style="border: 1px solid #001E6A"/>
</td>
</TR>
<?php }
?>