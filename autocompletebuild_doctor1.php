<?php

//session_start();

include ("db/db_connect.php");



$stringpart1 = '

function StateSuggestions() {

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

StateSuggestions.prototype.requestSuggestions = function (oAutoSuggestControl /*:AutoSuggestControl*/,

                                                          bTypeAhead /*:boolean*/) {

    var aSuggestions = [];

    var sTextboxValue = oAutoSuggestControl.textbox.value;

    

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

    oAutoSuggestControl.autosuggest(aSuggestions, bTypeAhead);

};';





$stringbuild1 = "";

$query1 = "select * from master_doctor where status <> 'Deleted' and is_staff <>'1' order by doctorname";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res1 = mysqli_fetch_array($exec1))

{

	$res1doctorcode = $res1['doctorcode'];

	$res1doctorname = $res1['doctorname'];

	$res1doctorname = strtoupper($res1doctorname);

	$res1doctorname = trim($res1doctorname);

	$res1doctorname = preg_replace('/,/', ' ', $res1doctorname);

	if ($stringbuild1 == '')

	{

		$stringbuild1 = '"'.$res1doctorname.' #'.$res1doctorcode.'"';

	}

	else

	{

		$stringbuild1 = $stringbuild1.',"'.$res1doctorname.' #'.$res1doctorcode.'"';

	}

}

//echo $stringbuild1;



//building file.

$filecontent = $stringpart1.$stringbuild1.$stringpart2;

//$filename = $scriptname.'js';

$filefolder = 'js';

$filename = 'autocomplete_doctor.'.'js';

$filepath = $filefolder.'/'.$filename;

$fp = fopen($filepath, 'w');

fwrite($fp, $filecontent);

fclose($fp);











?>