<?php
//session_start();
include ("db/db_connect.php");

$stringpart1 = '
function StateSuggestions4() {
this.states = 
[
';

$stringpart2 = '];
}

/**
 * Request suggestions for the given autosuggest control. 
 * @scope protected
 * @param oAutoSuggestControl4 The autosuggest control to provide suggestions for.
 */
StateSuggestions4.prototype.requestSuggestions = function (AutoSuggestControl4 /*:AutoSuggestControl4*/,
                                                          bTypeAhead /*:boolean*/) {
    var aSuggestions = [];
    var sTextboxValue = AutoSuggestControl4.textbox.value;
    //alert (sTextboxValue);
 	var loopLength = 0;

    if (sTextboxValue.length > 0){
    
	var sTextboxValue = sTextboxValue.toUpperCase();

        //search for matching states
        for (var i=0; i < this.states.length; i++) 
		{ 
            if (this.states[i].indexOf(sTextboxValue) >= 0) 
			{
                loopLength = loopLength + 1;
				if (loopLength <= 300) //TO REDUCE THE SUGGESTIONS DROP DOWN LIST
				{
					aSuggestions.push(this.states[i]);
				}
            } 
        }
    }

    //provide suggestions to the control
    AutoSuggestControl4.autosuggest(aSuggestions, bTypeAhead);
};';

$stringbuild1 = "";
$querymed = "select * from master_medicine where status <> 'Deleted' order by itemcode";
$execmed = mysqli_query($GLOBALS["___mysqli_ston"], $querymed) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($resmed = mysqli_fetch_array($execmed))
{
	//$res1autonumber = $res1['auto_number'];
	$res1itemcode = $resmed['itemcode'];
	
	$res1itemname = $resmed['itemname'];
		/*$res1customermiddlename = $res1['customermiddlename'];
	$res1customerlastname = $res1['customerlastname'];
	$res1nationalidnumber = $res1['nationalidnumber'];
	$res1mobilenumber = $res1['mobilenumber'];
	*/
	
	//$res1autonumber = addslashes($res1autonumber);
	$res1itemname = addslashes($res1itemname);
	/*$res1customermiddlename = addslashes($res1customermiddlename);
	$res1customerlastname = addslashes($res1customerlastname);
	$res1nationalidnumber = addslashes($res1nationalidnumber);
	$res1mobilenumber = addslashes($res1mobilenumber);
*/
	//$res1autonumber = strtoupper($res1autonumber);
	$res1itemname = strtoupper($res1itemname);
	/*$res1customermiddlename = strtoupper($res1customermiddlename);
	$res1customerlastname = strtoupper($res1customerlastname);
	$res1nationalidnumber = strtoupper($res1nationalidnumber);
	$res1mobilenumber = strtoupper($res1mobilenumber);
	*/
	//$res1autonumber = trim($res1autonumber);
	$res1itemname = trim($res1itemname);
	
	//$res1itemcode = preg_replace('/,/', ' ', $res1itemcode);
	$res1itemname = preg_replace('/,/', ' ', $res1itemname);
	
	if ($stringbuild1 == '')
	{
		$stringbuild1 = '"'.$res1itemcode.' ||'.$res1itemname.'"';
	}
	else
	{
		$stringbuild1 = $stringbuild1.',"'.$res1itemcode.'|| '.$res1itemname.'"';
	}
}
//echo $stringbuild1;

//building file.
$filecontent = $stringpart1.$stringbuild1.$stringpart2;
//$filename = $scriptname.'js';
$filefolder = 'js';
$filename = 'autocomplete_medicine2.'.'js';
$filepath = $filefolder.'/'.$filename;
$fp = fopen($filepath, 'w');
fwrite($fp, $filecontent);
fclose($fp);

?>