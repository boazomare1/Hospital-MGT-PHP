<?php
$tbody = '';
$ino = 1;
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
$reforder = $res23['reforder'];
$refcode = $res23['refcode'];
$referenceanum = $res23['auto_number'];
?>
<TR id="idTR<?php echo $itemcount; ?>" bgcolor="#ecf0f5">
<td id="idTD1<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">
<input type="hidden" name="refanum<?php echo $itemcount; ?>" value="<?php echo $referenceanum; ?>" id="referenceanum<?php echo $itemcount; ?>" style="text-align:left" size="20" />
<input name="subheader<?php echo $itemcount; ?>" value="<?php echo $subheader; ?>" id="subheader<?php echo $itemcount; ?>" style="text-align:left" size="20" />
</td>
<td id="idTD1<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">
<input name="reference<?php echo $itemcount; ?>" value="<?php echo $referencename; ?>" id="serialnumber<?php echo $itemcount; ?>" style="text-align:left" size="20" />
</td>
<td id="idTD2<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">
<input name="units<?php echo $itemcount; ?>" value="<?php echo $referenceunit; ?>" id="itemcode<?php echo $itemcount; ?>" style="text-align:left" size="8" />
</td>
<td id="idTD2<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">
<input name="rangelow<?php echo $itemcount; ?>" value="<?php echo $criticallow; ?>" id="criticallow<?php echo $itemcount; ?>" style="text-align:left" size="8" />
</td>
<td id="idTD2<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">
<input name="rangehigh<?php echo $itemcount; ?>" value="<?php echo $criticalhigh; ?>" id="criticalhigh<?php echo $itemcount; ?>" style="text-align:left" size="8" />
</td>
<!--<td id="idTD3<?php echo $itemcount; ?>" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
<input type="text" size="10" name="range<?php echo $itemcount; ?>" id="itemname<?php echo $itemcount; ?>" style="text-align:left" value="<?php echo $referencerange; ?>">
</td>-->
<td id="idTD3<?php echo $itemcount; ?>" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
<select name="gender<?php echo $itemcount; ?>" id="itemname<?php echo $itemcount; ?>">
<?php if($gender != '') { ?>
<option value="<?php echo $gender; ?>"><?php echo $gender; ?></option>
<?php } ?>
<option value="">All</option>
<option value="Male">Male</option>
<option value="Female">Female</option>
</select>
</td>
<td id="idTD3<?php echo $itemcount; ?>" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
<input type="text" size="1" name="agelimitfrom<?php echo $itemcount; ?>" id="itemname<?php echo $itemcount; ?>" style="text-align:left" value="<?php echo $agefrom; ?>">
<input type="text" size="1" name="agelimitto<?php echo $itemcount; ?>" id="itemname<?php echo $itemcount; ?>" style="text-align:left" value="<?php echo $ageto; ?>">
</td>
<td id="idTD2<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">
<input name="reforder<?php echo $itemcount; ?>" value="<?php echo $reforder; ?>" id="reforder<?php echo $itemcount; ?>" style="text-align:left" size="1" />
</td>
<td id="idTD2<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">
<input name="refcode<?php echo $itemcount; ?>" value="<?php echo $refcode; ?>" id="refcode<?php echo $itemcount; ?>" style="text-align:left" size="1" />
</td>
<td width="96">
<input type="button" data-toggle="modal" data-target="#myModal" id="interpret<?php echo $itemcount; ?>" value="Interpretation" onClick="return CallFrom('<?php echo $itemcount; ?>')" style="border: 1px solid #001E6A"></td>
<td id="idTD3<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">
<!--<input onClick="return btnFreeClick(<?php echo $itemcount; ?>)" name="btnfree<?php echo $itemcount; ?>" id="btnfree<?php echo $itemcount; ?>" type="hidden" value="Free" class="button" style="border: 1px solid #001E6A"/>-->
<input onClick="return btnDeleteClick10(<?php echo $itemcount; ?>)" name="btndelete<?php echo $itemcount; ?>" id="btndelete<?php echo $itemcount; ?>" type="button" value="Del" class="button" />
</td>
</TR>

<?php 
$inter_build = '';
//$query8i = "select * from master_labinterpretation where itemcode='$itemcode' and referencename = '$referencename' and status <> 'deleted'";
$query8i = "select * from master_labinterpretation where itemcode='$itemcode' and referencename = '$referencename' and status != 'deleted'";

$exec8i = mysqli_query($GLOBALS["___mysqli_ston"], $query8i) or die ("Error in Query8i".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res8i = mysqli_fetch_array($exec8i))
{
	$idesc = $res8i['interpret_desc'];
	$irange = $res8i['interpret_range'];
	
	$inter_build .= '<tr id="'.$itemcount.'ITR'.$ino.'"><td><input type="hidden" name="'.$itemcount.'idesc'.$ino.'" id="'.$itemcount.'idesc'.$ino.'" value="'.$idesc.'"></td>';
	$inter_build .= '<td><input type="hidden" name="'.$itemcount.'irange'.$ino.'" id="'.$itemcount.'irange'.$ino.'" value="'.$irange.'"></td></tr>';
	
	$ino = $ino+1;
}
$tbody .= '<tbody id="add_interpret'.$itemcount.'">'.$inter_build.'</tbody>';
}
?>
</tbody>
<?php
echo $tbody; 
?>