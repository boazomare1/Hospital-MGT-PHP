
function StateSuggestions() {
this.states = 
[
" "," ABEL APIMA"," ADMIN"," CECILIA WAITHERERO"," DAMARIS MUGAMBI"," DANIEL WAFULA"," DOREEN KINYUA"," DR LOCUM"," ESTHER MWANZA"," EUNICE OTIENO"," FAITH MBITHE"," FAITH NDEGWA"," FESTUS GITONGA"," GIBSON M"," GITAU SAMUEL"," HASSAN KIPLANGAT"," HAZEL WANJIKU"," IDRIS DABOW"," IP LOCUM"," IP LOCUM ICU"," JACQUELINE OTIENO"," JOAN MAISIRA"," JOSEPHINE NJIRAINI"," KEISHA OUKO"," KENIQUE"," LIZA GATUGI"," LUCY WAIRIMU"," LYDIAH AMULAKU"," LYDIAH ONGWAE"," MARTHA MUTHONI"," MARTHA WANJALA"," MAURINE OCHIENG"," MICHAEL KARANJA"," MINNEH WAIRIMU"," MOUREEN MAINA"," MOUREEN NZOMO"," NANCY KINGORI"," NAOMY KANGOGO"," NATHAN ATUNDA"," NICHOLAS MUNENE"," NICODEMUS OMBATI"," PAMELA INAMBILI"," PHARMACY"," QUINTER AWINO"," RAHAB THUO"," RAY ODETTE"," RUTH MUTITIKA"," RUTH NJOKI"," SHANIECE SHISIA"," SHARON MUTHONI"," SUPER"," TERESA AMENYA"," TINA AKINYI"," VALLARY ANYANGO"];
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
};