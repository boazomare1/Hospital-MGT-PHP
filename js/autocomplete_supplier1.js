
function StateSuggestions() {
this.states = 
[
"ABC SUPPLIERS LTD #08-8002","ADVANCE IP DEPOSITS #08-8102","AMBULANCE #01-1011","BRITAM #07-7501","CASH #07-7601","CHARITY FUND #07-7505","CONSULTATION FEE #01-1001","COOPERATIVE BANK(KSH) #07-7603","CUBE PHARMA LTD #08-8003","DR.VENKAT #08-8100","EB BILL #04-4003","HOSPITAL REVENUE #01-1009","INTEREST ON BANK DEPOSIT #03-3001","IP DEPOSITS #08-8101","KIOSK INCOME #03-3002","LABORATORY #01-1003","MOSES PAUL #07-7504","MPESA-TILL NO.769965 #07-7605","NHIF #07-7502","OT REVENUE #01-1010","PHARMACY DRUGS #02-2001","PHARMACY SALES #01-1002","PRIVATE DOCTOR #08-8004","RADIOLOGY #01-1005","RAJESH #07-7503","REFERRAL #01-1004","RENT #04-4002","SERVICE #01-1008","TELEPHONE BILL #04-4001"];
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