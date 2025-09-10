
function StateSuggestions8() {
this.states = 
[
"3 ||BIOCHEMISTRY","10|| BLOOD BANK","5|| HEMATOLOGY","8|| HISTOPATHOLOGY","1|| LABORATORY","7|| MICROBIOLOGY","12|| MOLECULAR","11|| OUTSIDE SERVICES","9|| PATHOLOGY","6|| PROFILE","2|| PROFILES","4|| SEROLOGY"];
}

/**
 * Request suggestions for the given autosuggest control. 
 * @scope protected
 * @param oAutoSuggestControl The autosuggest control to provide suggestions for.
 */
StateSuggestions8.prototype.requestSuggestions = function (AutoSuggestControl8 /*:AutoSuggestControl*/,
                                                          bTypeAhead /*:boolean*/) {
    var aSuggestions = [];
    var sTextboxValue = AutoSuggestControl8.textbox.value;
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
    AutoSuggestControl8.autosuggest(aSuggestions, bTypeAhead);
};