
function StateSuggestions77() {
this.states = 
[
"DTC00000011|| DR VENKAT","DTC00000010|| DR. AZAM GAZAL","DTC00000003|| DR. HONEY","DTC00000002|| DR. PREM KUMAR","DTC00000001|| DR. SHARMA MALLADI","DTC00000009|| DR. THURANIRA MAJOR","DTC00000007|| DR.CHRIS","DTC00000008|| DR.GITHURA","DTC00000006|| DR.OBWANGA","DTC00000005|| DR.SAKSHI MALLADI","DTC00000012|| NATRAJ","DTC00000004|| OP DOCTOR","DTC00000013|| RAJARAM"];
}

/**
 * Request suggestions for the given autosuggest control. 
 * @scope protected
 * @param oAutoSuggestControl The autosuggest control to provide suggestions for.
 */
StateSuggestions77.prototype.requestSuggestions = function (AutoSuggestControl7 /*:AutoSuggestControl*/,
                                                          bTypeAhead /*:boolean*/) {
    var aSuggestions = [];
    var sTextboxValue = AutoSuggestControl7.textbox.value;
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
    AutoSuggestControl7.autosuggest(aSuggestions, bTypeAhead);
};