
function StateSuggestions3() {
this.states = 
[
" MGR-1-24-1"," MGR-10-24-1"," MGR-11-24-1"," MGR-12-24-1"," MGR-13-24-1"," MGR-14-24-1"," MGR-15-24-1"," MGR-16-24-1"," MGR-17-24-1"," MGR-18-24-1"," MGR-19-24-1"," MGR-2-24-1"," MGR-20-24-1"," MGR-21-24-1"," MGR-22-24-1"," MGR-23-24-1"," MGR-24-24-1"," MGR-25-24-1"," MGR-26-24-1"," MGR-27-24-1"," MGR-28-24-1"," MGR-29-24-1"," MGR-3-24-1"," MGR-30-24-1"," MGR-31-24-1"," MGR-32-24-1"," MGR-33-24-1"," MGR-34-24-1"," MGR-35-24-1"," MGR-36-24-1"," MGR-37-24-1"," MGR-38-24-1"," MGR-39-24-1"," MGR-4-24-1"," MGR-40-24-1"," MGR-41-24-1"," MGR-42-24-1"," MGR-5-24-1"," MGR-6-24-1"," MGR-7-24-1"," MGR-8-24-1"," MGR-9-24-1"," MRN-1-24-1"," MRN-10-24-1"," MRN-100-24-1"," MRN-101-24-1"," MRN-102-24-1"," MRN-103-24-1"," MRN-104-24-1"," MRN-105-24-1"," MRN-106-24-1"," MRN-107-24-1"," MRN-108-24-1"," MRN-109-24-1"," MRN-11-24-1"," MRN-110-24-1"," MRN-111-24-1"," MRN-112-24-1"," MRN-113-24-1"," MRN-114-24-1"," MRN-115-24-1"," MRN-116-24-1"," MRN-12-24-1"," MRN-13-24-1"," MRN-14-24-1"," MRN-15-24-1"," MRN-16-24-1"," MRN-17-24-1"," MRN-18-24-1"," MRN-19-24-1"," MRN-2-24-1"," MRN-20-24-1"," MRN-21-24-1"," MRN-22-24-1"," MRN-23-24-1"," MRN-24-24-1"," MRN-25-24-1"," MRN-26-24-1"," MRN-27-24-1"," MRN-28-24-1"," MRN-29-24-1"," MRN-3-24-1"," MRN-30-24-1"," MRN-31-24-1"," MRN-32-24-1"," MRN-33-24-1"," MRN-34-24-1"," MRN-35-24-1"," MRN-36-24-1"," MRN-37-24-1"," MRN-38-24-1"," MRN-39-24-1"," MRN-4-24-1"," MRN-40-24-1"," MRN-41-24-1"," MRN-42-24-1"," MRN-43-24-1"," MRN-44-24-1"," MRN-45-24-1"," MRN-46-24-1"," MRN-47-24-1"," MRN-48-24-1"," MRN-49-24-1"," MRN-5-24-1"," MRN-50-24-1"," MRN-51-24-1"," MRN-52-24-1"," MRN-53-24-1"," MRN-54-24-1"," MRN-55-24-1"," MRN-56-24-1"," MRN-57-24-1"," MRN-58-24-1"," MRN-59-24-1"," MRN-6-24-1"," MRN-60-24-1"," MRN-61-24-1"," MRN-62-24-1"," MRN-63-24-1"," MRN-64-24-1"," MRN-65-24-1"," MRN-66-24-1"," MRN-67-24-1"," MRN-68-24-1"," MRN-69-24-1"," MRN-7-24-1"," MRN-70-24-1"," MRN-71-24-1"," MRN-72-24-1"," MRN-73-24-1"," MRN-74-24-1"," MRN-75-24-1"," MRN-76-24-1"," MRN-77-24-1"," MRN-78-24-1"," MRN-79-24-1"," MRN-8-24-1"," MRN-80-24-1"," MRN-81-24-1"," MRN-82-24-1"," MRN-83-24-1"," MRN-84-24-1"," MRN-85-24-1"," MRN-86-24-1"," MRN-87-24-1"," MRN-88-24-1"," MRN-89-24-1"," MRN-9-24-1"," MRN-90-24-1"," MRN-91-24-1"," MRN-92-24-1"," MRN-93-24-1"," MRN-94-24-1"," MRN-95-24-1"," MRN-96-24-1"," MRN-97-24-1"," MRN-98-24-1"," MRN-99-24-1"];
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