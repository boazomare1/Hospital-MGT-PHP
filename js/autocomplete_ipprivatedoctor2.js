
function StateSuggestions77() {
this.states = 
[
"03-2000-22|| DENNIS MUASYA|| 0.00","03-2000-83|| DENTIST|| 0.00","03-2000-92|| DR  ABEL ODOUR|| 0.00","03-2000-12|| DR  DANIEL MUTONGA|| 0.00","03-2000-67|| DR AISHA|| 0.00","03-2000-25|| DR AJUA NKENG|| 0.00","03-2000-43|| DR ALLAN|| 0.00","03-2000-19|| DR ALLAN GRAY|| 0.00","03-2000-36|| DR ALUORA|| 0.00","03-2000-54|| DR AMBROSE|| 0.00","03-2000-75|| DR ANN IRUNGU|| 0.00","03-2000-50|| DR ARAKA|| 0.00","03-2000-9|| DR AUSTIN OYWER|| 0.00","03-2000-13|| DR BRUCE SEMO|| 0.00","03-2000-41|| DR CHEBOI|| 0.00","03-2000-94|| DR CLIFF MUTURI|| 0.00","03-2000-55|| DR COLLINS MASINDE|| 0.00","03-2000-74|| DR DAISY ODUNDA|| 0.00","03-2000-91|| DR DUNCAN KIHONGO|| 0.00","03-2000-65|| DR ENOCK|| 0.00","03-2000-57|| DR GAKUO|| 0.00","03-2000-21|| DR GATWIRI MERCY|| 0.00","03-2000-31|| DR GLADYS MAINA|| 0.00","03-2000-72|| DR HASSAN|| 0.00","03-2000-6|| DR JACKLINE OTIENO|| 0.00","03-2000-5|| DR JONATHAN|| 0.00","03-2000-73|| DR KAARA|| 0.00","03-2000-27|| DR KAKAI|| 0.00","03-2000-7|| DR KANYATTA DANIEL|| 0.00","03-2000-48|| DR KARANGA|| 0.00","03-2000-47|| DR KAZOIYA|| 0.00","03-2000-95|| DR KEEGAN|| 0.00","03-2000-39|| DR KIMATHI DENNIS|| 0.00","03-2000-40|| DR KOSGEI|| 0.00","03-2000-62|| DR KURIA KAMAU|| 0.00","03-2000-3|| DR LEAH OPERE|| 0.00","03-2000-44|| DR LODENYO HUDSON|| 0.00","03-2000-10|| DR LOLLA MOLLA|| 0.00","03-2000-8|| DR LUCAS|| 0.00","03-2000-76|| DR MAGARE|| 0.00","03-2000-93|| DR MAKORI|| 0.00","03-2000-49|| DR MANG'OLI PAUL|| 0.00","03-2000-60|| DR MARJORIE|| 0.00","03-2000-38|| DR MARTHA MONARI|| 0.00","03-2000-90|| DR MASOUD|| 0.00","03-2000-70|| DR MATHEKA|| 0.00","03-2000-77|| DR MATHEKA|| 0.00","03-2000-58|| DR MAUREEN SHABUYA|| 0.00","03-2000-16|| DR MBURU|| 0.00","03-2000-68|| DR MICHAEL|| 0.00","03-2000-56|| DR MITEMA|| 0.00","03-2000-28|| DR MOMANYI BRIAN|| 0.00","03-2000-66|| DR MUGENDI|| 0.00","03-2000-26|| DR MUIGAI|| 0.00","03-2000-52|| DR MUIGAI ? UROLOGIST|| 0.00","03-2000-64|| DR MUTIE|| 0.00","03-2000-34|| DR MWAI|| 0.00","03-2000-45|| DR MWEA MACHARIA|| 0.00","03-2000-51|| DR NELLY KAMALE|| 0.00","03-2000-46|| DR NGETICH|| 0.00","03-2000-4|| DR OGOYE|| 0.00","03-2000-59|| DR OKANGA|| 0.00","03-2000-11|| DR OKIRIAMU|| 0.00","03-2000-30|| DR OLOO BENARD|| 0.00","03-2000-61|| DR OPONDO|| 0.00","03-2000-96|| DR OYIENGO|| 0.00","03-2000-17|| DR ROOPRAI|| 0.00","03-2000-23|| DR ROSE MUNGE|| 0.00","03-2000-32|| DR SIMIYU|| 0.00","03-2000-79|| DR STEVEN ONYANGO|| 0.00","03-2000-42|| DR VIVIAN|| 0.00","03-2000-63|| DR WINNIE KIMANI|| 0.00","03-2000-15|| DR. FAITH WANZA|| 0.00","03-2000-80|| DR. GILBERT NGETICH|| 0.00","03-2000-2|| DR. NICOLE|| 0.00","03-2000-88|| DR. RAINA JONES|| 0.00","03-2000-89|| DR. YASHAR MAJIAAHDAM|| 0.00","03-2000-14|| E. MURIITHI|| 0.00","03-2000-18|| ERNEST MUGUNA|| 0.00","03-2000-82|| GENERAL PHYSICIAN|| 0.00","03-2000-81|| IP NURSE|| 0.00","03-2000-78|| KEISHA OUKO|| 0.00","03-2000-35|| KEN MAINA|| 0.00","03-2000-87|| MIDWIFE|| 0.00","03-2000-71|| MUTUA|| 0.00","03-2000-86|| OPTICIAN|| 0.00","03-2000-20|| PHILIP MWACHAKA|| 0.00","03-2000-84|| PHYSIOTHERAPIST|| 0.00","03-2000-69|| RAY ODETTE|| 0.00","03-2000-24|| SAMUEL MA ITHYA|| 0.00","03-2000-37|| SHEILA MUGENDI|| 0.00","03-2000-33|| STEPHEN MUTISYA|| 0.00","03-2000-29|| STEVE|| 0.00","03-2000-53|| WILLIAM MOROGA|| 0.00"];
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