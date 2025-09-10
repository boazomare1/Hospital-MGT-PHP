<?php
$query23 = "select * from master_labreference where itemcode='$itemcode' and status <> 'deleted'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($res23 = mysqli_fetch_array($exec23))
{
$itemcount = $itemcount + 1;
$subheader = $res23['subheader'];
$referencename = $res23['referencename'];
$referenceunit = $res23['referenceunit'];
$referencerange = $res23['referencerange'];
$criticallow = $res23['criticallow'];
$criticalhigh = $res23['criticalhigh'];
$gender = $res23['gender'];
$agefrom = $res23['agefrom'];
$ageto = $res23['ageto'];
$refrange_label = $res23['refrange_label'];
$reforder = $res23['reforder'];
$refcode = $res23['refcode'];
$referenceanum = $res23['auto_number'];
$generic_search = $res23['generic_search'];
?>
<TR id="idTR<?php echo $itemcount; ?>" bgcolor="#ecf0f5">

<td id="idTD1<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">
<input name="reference[]" value="<?php echo $referencename; ?>" id="serialnumber<?php echo $itemcount; ?>" style="text-align:left" size="20" />
</td>
<td id="idTD2<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">
<input name="units[]" value="<?php echo $referenceunit; ?>" id="itemcode<?php echo $itemcount; ?>" style="text-align:left" size="8" />
</td>
<td id="idTD1<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">
<input type="hidden" name="refanum[]" value="<?php echo $referenceanum; ?>" id="referenceanum<?php echo $itemcount; ?>" style="text-align:left" size="20" />
<input name="subheader[]" value="<?php echo $subheader; ?>" id="subheader<?php echo $itemcount; ?>" style="text-align:left" size="20" />
</td>
<td id="idTD2<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">
<input name="rangelow[]" value="<?php echo $criticallow; ?>" id="criticallow<?php echo $itemcount; ?>" style="text-align:left" size="8" />
</td>
<td id="idTD2<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">
<input name="rangehigh[]" value="<?php echo $criticalhigh; ?>" id="criticalhigh<?php echo $itemcount; ?>" style="text-align:left" size="8" />
</td>
<!--<td id="idTD3<?php echo $itemcount; ?>" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
<input type="text" size="10" name="range[]" id="itemname<?php echo $itemcount; ?>" style="text-align:left" value="<?php echo $referencerange; ?>">
</td>-->
<td id="idTD3<?php echo $itemcount; ?>" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
<select name="gender[]" id="itemname<?php echo $itemcount; ?>">
<?php if($gender != '') { ?>
<option value="<?php echo $gender; ?>"><?php echo $gender; ?></option>
<?php } ?>
<option value="">All</option>
<option value="Male">Male</option>
<option value="Female">Female</option>
</select>
</td>
<td id="idTD3<?php echo $itemcount; ?>" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
<input type="text" size="1" name="agelimitfrom[]" id="itemname<?php echo $itemcount; ?>" style="text-align:left" value="<?php echo $agefrom; ?>">
<input type="text" size="1" name="agelimitto[]" id="itemname<?php echo $itemcount; ?>" style="text-align:left" value="<?php echo $ageto; ?>">
</td>

<td id="idTD2<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">
<input name="refrange_label[]" value="<?php echo $refrange_label; ?>" id="refrange_label<?php echo $itemcount; ?>" style="text-align:left" size="10" />
</td>

<td id="idTD2<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">
<input name="reforder[]" value="<?php echo $reforder; ?>" id="reforder<?php echo $itemcount; ?>" style="text-align:left" size="1" />
</td>
<td id="idTD2<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">
<input name="refcode[]" value="<?php echo $refcode; ?>" id="refcode<?php echo $itemcount; ?>" style="text-align:left" size="1" />
</td>

<td id="idTD3<?php echo $itemcount; ?>" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
<select name="genericsearch[]" id="itemname<?php echo $itemcount; ?>">

<option value="0" <?php if($generic_search == '0') echo "selected"; else echo ""; ?>>No</option>
<option value="1" <?php if($generic_search == '1') echo "selected"; else echo ""; ?>>Yes</option>
</select>
</td>

<td id="idTD3<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">
<!--<input onClick="return btnFreeClick(<?php echo $itemcount; ?>)" name="btnfree<?php echo $itemcount; ?>" id="btnfree<?php echo $itemcount; ?>" type="hidden" value="Free" class="button" style="border: 1px solid #001E6A"/>-->
<input onClick="return btnDeleteClick10(<?php echo $itemcount; ?>)" name="btndelete<?php echo $itemcount; ?>" id="btndelete<?php echo $itemcount; ?>" type="button" value="Del" class="button" />
</td>
</TR>
<?php }
?>