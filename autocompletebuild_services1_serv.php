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
$res111subtype='';
$query13s = "select sertemplate from master_subtype where auto_number = '$res111subtype' order by subtype";

$exec13s = mysqli_query($GLOBALS["___mysqli_ston"], $query13s) or die ("Error in Query13s".mysqli_error($GLOBALS["___mysqli_ston"]));

$res13s = mysqli_fetch_array($exec13s);

$tablenames = $res13s['sertemplate'];

if($tablenames == '')

{

  $tablenames = 'master_services';

}

////////////////// DISPLAY THE DATA BY THE CATEGORY /////////////////
$query9 = "select * from master_employeelocation where username = '$username' and locationcode = '$locationcode' and defaultstore='default'";

				$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

				$res9 = mysqli_fetch_array($exec9);
				// while($res9 = mysql_fetch_array($exec9));

				// {

				$res9anum = $res9['storecode'];

				$res9default = $res9['defaultstore'];


				$query10 = "select * from master_store where auto_number = '$res9anum'";

				$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));

				$res10 = mysqli_fetch_array($exec10);

				$res10storecode = $res10['storecode'];

				$res10store = $res10['store'];
				$res10category= $res10['category'];

				$res10anum = $res10['auto_number'];

////////////////// DISPLAY THE DATA BY THE CATEGORY /////////////////
				
$stringbuild1 = "";

$query1 = "SELECT * from $tablenames where  status <> 'Deleted' AND categoryname='".$res10category."' AND  rateperunit <> 0 order by itemname";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$num=mysqli_num_rows($exec1);

$query122 = "SELECT * from $tablenames where  status <> 'Deleted'   AND  rateperunit <> 0 order by itemname";
$exec122 = mysqli_query($GLOBALS["___mysqli_ston"], $query122) or die ("Error in Query122".mysqli_error($GLOBALS["___mysqli_ston"]));

if($num>0){
	while ($res1 = mysqli_fetch_array($exec1))
		{
	$res1itemcode=$res1['itemcode'];
	$res1itemname = $res1['itemname'];
	$res1rateperunit = $res1['rateperunit'];
	$res1itemname = addslashes($res1itemname);
	$res1itemname = strtoupper($res1itemname);

	$res1itemname = trim($res1itemname);

	if ($stringbuild1 == '')
	{
		$stringbuild1 = '"'.$res1itemcode.'||'.$res1itemname.'||'.$res1rateperunit.'"';
	}

	else

	{

		$stringbuild1 = $stringbuild1.',"'.$res1itemcode.'||'.$res1itemname.'||'.$res1rateperunit.'"';

	}

}
}else{
	
while ($res1 = mysqli_fetch_array($exec122))
	{
	$res1itemcode=$res1['itemcode'];
	$res1itemname = $res1['itemname'];
	$res1rateperunit = $res1['rateperunit'];
	$res1itemname = addslashes($res1itemname);
	$res1itemname = strtoupper($res1itemname);

	$res1itemname = trim($res1itemname);

	if ($stringbuild1 == '')
	{
		$stringbuild1 = '"'.$res1itemcode.'||'.$res1itemname.'||'.$res1rateperunit.'"';
	}

	else

	{

		$stringbuild1 = $stringbuild1.',"'.$res1itemcode.'||'.$res1itemname.'||'.$res1rateperunit.'"';

	}

}
}







//building file.

$filecontent = $stringpart1.$stringbuild1.$stringpart2;

//$filename = $scriptname.'js';

$filefolder = 'js';

$filename = 'autocomplete_services1.'.'js';

$filepath = $filefolder.'/'.$filename;

$fp = fopen($filepath, 'w');

fwrite($fp, $filecontent);

fclose($fp);

?>