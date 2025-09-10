<?php
//session_start();
include ("db/db_connect.php");

$stringpart1 = '
function StateSuggestions3() {
this.states = 
[
';

$stringpart2 = '];
}

/**
 * Request suggestions for the given autosuggest control. 
 * @scope protected
 * @param oAutoSuggestControl The autosuggest control to provide suggestions for.
 */
StateSuggestions3.prototype.requestSuggestions = function (AutoSuggestControl3 /*:AutoSuggestControl*/,
                                                          bTypeAhead /*:boolean*/) {
    var aSuggestions = [];
    var sTextboxValue = AutoSuggestControl3.textbox.value;
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
				if (loopLength <= 15) //TO REDUCE THE SUGGESTIONS DROP DOWN LIST
				{
					aSuggestions.push(this.states[i]);
				}
            } 
        }
    }

    //provide suggestions to the control
    AutoSuggestControl3.autosuggest(aSuggestions, bTypeAhead);
};';

$stringbuild1 = "";
 $todate=date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') -500, date('Y')));
 /*$query1 = "select * from purchaseorder_details where goodsstatus='' and billdate <= '".date('Y-m-d')."' AND billdate >= '".$todate."' group by billnumber";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());

while ($res1 = mysql_fetch_array($exec1))
{
	$resbillnumber = $res1['billnumber'];
	
	
	if ($stringbuild1 == '')
	{
		$stringbuild1 = '"'.' '.$resbillnumber.'"';
	}
	else
	{
		$stringbuild1 = $stringbuild1.',"'.' '.$resbillnumber.'"';
	}
}*/

 $query2 = "select * from manual_lpo where entrydate <= '".date('Y-m-d')."' AND entrydate >= '".$todate."' and recordstatus <> 'deleted' AND goodsstatus='' group by billnumber";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res2 = mysqli_fetch_array($exec2))
{
	$resbillnumber = $res2['billnumber'];
	
	
	if ($stringbuild1 == '')
	{
		$stringbuild1 = '"'.' '.$resbillnumber.'"';
	}
	else
	{
		$stringbuild1 = $stringbuild1.',"'.' '.$resbillnumber.'"';
	}
}

//echo $stringbuild1;

//building file.
$filecontent = $stringpart1.$stringbuild1.$stringpart2;
//$filename = $scriptname.'js';
$filefolder = 'js';
$filename = 'autocomplete_purchaseorder_1.'.'js';
$filepath = $filefolder.'/'.$filename;
$fp = fopen($filepath, 'w');
fwrite($fp, $filecontent);
fclose($fp);
?>
