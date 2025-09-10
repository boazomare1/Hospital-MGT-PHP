/*
function StateSuggestions() {
this.states = 
[
"AFRI HEALTH SOLUTIONS","ASHOK LEYLAND ICICI INSURANCE","CASH","CDC (KEMRI)","COLLINS & CO","DR. CAROL","FAULU KENYA (BRITAM)","LINDA JAMII (BRITAM)","MILLENNIUM CORP ( ICICI INS)","SHARMA MALLADI","SPIC PETRO UNITED INSURANCE","STAFF ACCOUNT","TESTING","TIS DIRECT LTD"];
}
*/
function StateSuggestions3() {
this.states = 
[];
}

/**
 * Request suggestions for the given autosuggest control. 
 * @scope protected
 * @param oAutoSuggestControl The autosuggest control to provide suggestions for.
 */
StateSuggestions3.prototype.requestSuggestions = function (oAutoSuggestControl3 /*:AutoSuggestControl*/,
                                                          bTypeAhead /*:boolean*/) {
    var aSuggestions = [];
    var sTextboxValue = oAutoSuggestControl3.textbox.value;
    
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
    oAutoSuggestControl3.autosuggest(aSuggestions, bTypeAhead);
};