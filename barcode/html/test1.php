<form id="form1" name="form1" method="post" action="code128.php">
<table width="68%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2"><strong>SL Lumax  Ltd - Vendor Barcode Printing Demo </strong></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td width="22%">Vendor Code </td>
    <td width="78%"><input name="vendorcode" type="text" id="vendorcode" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td>Vendor Name </td>
    <td><input name="vendorname" type="text" id="vendorname" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td>Part Name </td>
    <td><input name="partname" type="text" id="partname" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Part Code </td>
    <td><input name="partcode" type="text" id="partcode" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Barcode Text </td>
    <td>
      <input name="text2display" type="text" maxlength="18" />    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
	<input name="barcode_type" type="hidden" id="barcode_type" value="code128" />
	<input name="output" type="hidden" id="output" value="2" />
	<input type="hidden" name="thickness" value="30" size="5" />
	<input type="hidden" name="res" value="1" size="5" />
	<input type="hidden" name="font" value="2" size="5" />
	<input type="submit" name="Submit" value="Submit" />	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>* Please complete the fields and press submit button to see the barcode image. </td>
  </tr>
</table>
</form>