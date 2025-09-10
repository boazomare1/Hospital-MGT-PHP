

function StateSuggestions() {

this.states = 

[

"BONUSES#06-1000-10","DIRECTORS FEES#06-1000-18","DIT- TRAINING LEVY#06-1000-19","EMPLOYERS LIABILITY#06-1000-25","FRINGE BENEFITS TAX#06-1000-14","NHIF CLERICAL DUTIES#06-1000-26","PROMOTIONAL EXPENSE#06-1000-22","RECRUITMENT COSTS#06-1000-9","SALARIES- ADMIN#06-1000-1","SALARIES- CLINICAL#06-1000-2","SALARIES- LOCUM#06-1000-3","SALARIES-LOCUM DOCTORS#06-1000-4","SICKNESS AND ACCIDENT INSURANCE#06-1000-20","STAFF COSTS(EMPLOYEMENT)#06-1000-23","STAFF FOODREFRESHMENTS#06-1000-11","STAFF GRATUITY#06-1000-12","STAFF MEDICAL COSTSTAFF MEDICAL INSURANCE#06-1000-8","STAFF NSSF#06-1000-6","STAFF PAYMENT IN LEAU OF LEAVE#06-1000-13","STAFF PENSION#06-1000-5","STAFF TRAINING#06-1000-16","STAFF TRANSPORT#06-1000-24","STAFF UNIFORMS#06-1000-7","STAFF WELFARE AND OTHER COSTS#06-1000-15","TAILORING EXPENSES#06-1000-21","TRAVEL & ACCOMMODATION EXPENSES#06-1000-17"];

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