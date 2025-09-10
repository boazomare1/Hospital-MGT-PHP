
function StateSuggestions3() {
this.states = 
[
" MLPO-1-24-1"," MLPO-10-24-1"," MLPO-11-24-1"," MLPO-12-24-1"," MLPO-13-24-1"," MLPO-14-24-1"," MLPO-15-24-1"," MLPO-16-24-1"," MLPO-17-24-1"," MLPO-18-24-1"," MLPO-19-24-1"," MLPO-2-24-1"," MLPO-20-24-1"," MLPO-21-24-1"," MLPO-22-24-1"," MLPO-23-24-1"," MLPO-24-24-1"," MLPO-25-24-1"," MLPO-26-24-1"," MLPO-27-24-1"," MLPO-28-24-1"," MLPO-29-24-1"," MLPO-3-24-1"," MLPO-30-24-1"," MLPO-31-24-1"," MLPO-32-24-1"," MLPO-33-24-1"," MLPO-34-24-1"," MLPO-35-24-1"," MLPO-36-24-1"," MLPO-37-24-1"," MLPO-38-24-1"," MLPO-39-24-1"," MLPO-4-24-1"," MLPO-40-24-1"," MLPO-41-24-1"," MLPO-42-24-1"," MLPO-43-24-1"," MLPO-44-24-1"," MLPO-45-24-1"," MLPO-46-24-1"," MLPO-47-24-1"," MLPO-48-24-1"," MLPO-49-24-1"," MLPO-5-24-1"," MLPO-50-24-1"," MLPO-51-24-1"," MLPO-52-24-1"," MLPO-53-24-1"," MLPO-54-24-1"," MLPO-55-24-1"," MLPO-6-24-1"," MLPO-7-24-1"," MLPO-8-24-1"," MLPO-9-24-1"];
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
};