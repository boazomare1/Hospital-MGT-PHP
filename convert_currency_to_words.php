<?php

//conversion function written on Sunday, 26 April 2009. Prem Kumar.
//Lakh Separator 
//written for Service Tracking System - Dass & Thomas. Aminjikarai.

function singlenumber_convert($number)
{
$stramount = "";

	$strlen = strlen($number);
	$ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
			"Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
			"Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
			"Nineteen"); //empty begining is to avoid zero of array.
	$tens = array("", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety"); 

	if ($strlen <= 2 && $number <= 19)
	{
		for ($i=1;$i<=19;$i++)
		{
			if ($number == $i)
			{
				$stramount = $ones[$i];
			}
		}
		//echo $stramount;
	}
return $stramount;
}

function doublenumber_convert($number)
{
$stramount1 = "";
$stramount2 = "";

	$strlen = strlen($number);
	$ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
			"Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
			"Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
			"Nineteen"); //empty begining is to avoid zero of array.
	$tens = array("", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety"); 

	if ($strlen == 2 && $number >19)
	{
		for ($i=1;$i<=9;$i++)
		{
			$floornumber = floor($number / 10);  
			if ($floornumber == $i)
			{
				$stramount2 = $tens[$i];
				$onesnumber = substr($number, 1, 1);
				if ($onesnumber <= 9)
				{
					for ($i=1;$i<=9;$i++)
					{
						if ($onesnumber == $i)
						{
							$stramount1 = $ones[$i];
						}
					}
				}
			}
		}
		//echo $stramount2.' '.$stramount1;
	}
$stramount1 = $stramount2.' '.$stramount1;
return $stramount1;
}

function hundredsnumber_convert($number)
{
	$strlen = strlen($number);
	$ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
			"Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
			"Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
			"Nineteen"); //empty begining is to avoid zero of array.
	$tens = array("", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety"); 

	$hundredsnumber = substr($number, 0, 1);
	$hundredsword = singlenumber_convert($hundredsnumber);
	if ($hundredsword != '')	$hundredsword = $hundredsword.' Hundred';
	$balancenumber = substr($number, 1, 2);
	if ($balancenumber <= 19)
	{
		$balancewords = singlenumber_convert($balancenumber);
	}
	else
	{
		$balancewords = doublenumber_convert($balancenumber);
	}
	if ($balancewords != '')
	{
		$hundredsword = $hundredsword.' And '.$balancewords;
	}
	else
	{
		$hundredsword = $hundredsword;
	}
	//echo $hundredsword;
	
return $hundredsword;
}

function thousandsnumber_convert($number)
{
	$hundredsword = '';
	$strlen = strlen($number);
	$ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
			"Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
			"Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
			"Nineteen"); //empty begining is to avoid zero of array.
	$tens = array("", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety"); 

	$thousandsnumber = substr($number, 0, 1);
	$thousandsword = singlenumber_convert($thousandsnumber);
	$thousandsword = $thousandsword.' Thousand';
	$hundredsnumber = substr($number, 1, 3);
	if ($hundredsnumber > 0)
	{
		$hundredsword = hundredsnumber_convert($hundredsnumber);
	}
	if ($hundredsword != '')
	{
		$thousandsword = $thousandsword.' '.$hundredsword;
	}
	
return $thousandsword;
}

function tenthousandsnumber_convert($number)
{
	$hundredsword = '';
	$tenthousandsword = '';
	
	$strlen = strlen($number);
	$ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
			"Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
			"Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
			"Nineteen"); //empty begining is to avoid zero of array.
	$tens = array("", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety"); 

	$tenthousandsnumber = substr($number, 0, 2);
	if ($tenthousandsnumber <= 19)
	{
		$tenthousandsword = singlenumber_convert($tenthousandsnumber);
	}
	else
	{
		$tenthousandsword = doublenumber_convert($tenthousandsnumber);
	}
	$tenthousandsword = $tenthousandsword.' Thousand';
	$hundredsnumber = substr($number, 2, 3);
	if ($hundredsnumber > 0)
	{
		$hundredsword = hundredsnumber_convert($hundredsnumber);
	}
	if ($hundredsword != '')
	{
		$tenthousandsword = $tenthousandsword.' '.$hundredsword;
	}
	//echo $tenthousandsword;

return 	$tenthousandsword;
}

function lakhsnumber_convert($number)
{
	$strlen = strlen($number);
	$ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
			"Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
			"Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
			"Nineteen"); //empty begining is to avoid zero of array.
	$tens = array("", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety"); 

	$lakhsnumber = substr($number, 0, 1);
	$lakhsword = singlenumber_convert($lakhsnumber);
	$lakhsword = $lakhsword.' Lakh';
	$tenthousandsnumber = substr($number, 1, 5);
	if ($tenthousandsnumber > 0)
	{
		$tenthousandsword = tenthousandsnumber_convert($tenthousandsnumber);
	}
	if ($tenthousandsword != '')
	{
		$lakhsword = $lakhsword.' '.$tenthousandsword;
	}
	
//echo $lakhsword;
return 	$lakhsword;
}

function tenlakhsnumber_convert($number)
{
	$strlen = strlen($number);
	$ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
			"Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
			"Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
			"Nineteen"); //empty begining is to avoid zero of array.
	$tens = array("", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety"); 

	$tenlakhsnumber = substr($number, 0, 2);
	if ($tenlakhsnumber <= 19)
	{
		$tenlakhsword = singlenumber_convert($tenlakhsnumber);
	}
	else
	{
		$tenlakhsword = doublenumber_convert($tenlakhsnumber);
	}
	$tenlakhsword = $tenlakhsword.' Lakhs';
	$tenthousandsnumber = substr($number, 2, 5);
	if ($tenthousandsnumber > 0)
	{
		$tenthousandsword = tenthousandsnumber_convert($tenthousandsnumber);
	}
	if ($tenthousandsword != '')
	{
		$tenlakhsword = $tenlakhsword.' '.$tenthousandsword;
	}
	//echo $tenlakhsword;
return $tenlakhsword;
}

function covert_currency_to_words2($varnumber)
{
	$query1curr_companyanum = $_SESSION["companyanum"];
	$query1curr = "select * from master_company where auto_number = '$query1curr_companyanum'";
	$exec1curr = mysqli_query($GLOBALS["___mysqli_ston"], $query1curr) or die ("Error in Query1curr".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1curr = mysqli_fetch_array($exec1curr);
	$res1country = $res1curr['country'];
	$res1currencyname = $res1curr["currencyname"];
	$res1currencydecimalname = $res1curr["currencydecimalname"];
	$res1currencycode = $res1curr["currencycode"];
	
	$strwords1 = "";
	$strwords2 = "";
	$strwords3 = "";
	$strwords4 = "";
	$strwords5 = "";
	$strwords6 = "";
	$strwords7 = "";
	
	$strdecimal1 = "";

	$varnumber = $varnumber;
	$numberarray = explode('.',$varnumber);
	//print_r($numberarray);
	$number = $numberarray[0];
	$decimal = $numberarray[1];
	
	if ($number > 9999999)
	{
		//echo "Number Not Supported.";
	}
	$convertowords = $number;
	$strlen = strlen($number);
	
	if ($strlen <= 2 && $number <= 19)
	{
		$strwords1 = singlenumber_convert($convertowords);
	}
	if ($strlen == 2 && $number > 19)
	{
		$strwords2 = doublenumber_convert($convertowords);
	}
	if ($strlen == 3)
	{
		$strwords3 = hundredsnumber_convert($convertowords);
	}
	if ($strlen == 4)
	{
		$strwords4 = thousandsnumber_convert($convertowords);
	}
	if ($strlen == 5)
	{
		$strwords5 = tenthousandsnumber_convert($convertowords);
	}
	if ($strlen == 6)
	{
		$strwords6 = lakhsnumber_convert($convertowords);
	}
	if ($strlen == 7)
	{
		$strwords7 = tenlakhsnumber_convert($convertowords);
	}
	if($decimal == 00)
	{
	 $strdecimal1 = 'Zero';
	}
	if ($decimal <= 19 && $decimal ==1)
	{
		$strdecimal1 = singlenumber_convert($decimal);
	}
	
	if ($decimal > 19)
	{
		$strdecimal1 = doublenumber_convert($decimal);
	}
	
	if ($strdecimal1 != '')
	{
		//$strdecimal1 = ' - Paise '.$strdecimal1;
		$strdecimal1 = ' - '.$strdecimal1;
	}
	
	
	$convertedstring = $strwords1.$strwords2.$strwords3.$strwords4.$strwords5.$strwords6.$strwords7.$strdecimal1.' '.'Cents Only';
	//if ($convertedstring != '') $convertedstring = 'Rupees '.$convertedstring;
	if ($convertedstring != '') $convertedstring = $res1country.' '.$res1currencyname.' '.$convertedstring;
	
	//echo $convertedstring;
return $convertedstring;
}

function covert_currency_to_words1($varnumber)
{
	$query1curr_companyanum = $_SESSION["companyanum"];
	$query1curr = "select * from master_company where auto_number = '$query1curr_companyanum'";
	$exec1curr = mysqli_query($GLOBALS["___mysqli_ston"], $query1curr) or die ("Error in Query1curr".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1curr = mysqli_fetch_array($exec1curr);
	$res1country = $res1curr['country'];
	$res1currencyname = $res1curr["currencyname"];
	$res1currencydecimalname = $res1curr["currencydecimalname"];
	$res1currencycode = $res1curr["currencycode"];
	
	$strwords1 = "";
	$strwords2 = "";
	$strwords3 = "";
	$strwords4 = "";
	$strwords5 = "";
	$strwords6 = "";
	$strwords7 = "";
	
	$strdecimal1 = "";

	$varnumber = $varnumber;
	$numberarray = explode('.',$varnumber);
	//print_r($numberarray);
	$number = $numberarray[0];
	$decimal = $numberarray[1];
	
	if ($number > 9999999)
	{
		//echo "Number Not Supported.";
	}
	$convertowords = $number;
	$strlen = strlen($number);
	
	if ($strlen <= 2 && $number <= 19)
	{
		$strwords1 = singlenumber_convert($convertowords);
	}
	if ($strlen == 2 && $number > 19)
	{
		$strwords2 = doublenumber_convert($convertowords);
	}
	if ($strlen == 3)
	{
		$strwords3 = hundredsnumber_convert($convertowords);
	}
	if ($strlen == 4)
	{
		$strwords4 = thousandsnumber_convert($convertowords);
	}
	if ($strlen == 5)
	{
		$strwords5 = tenthousandsnumber_convert($convertowords);
	}
	if ($strlen == 6)
	{
		$strwords6 = lakhsnumber_convert($convertowords);
	}
	if ($strlen == 7)
	{
		$strwords7 = tenlakhsnumber_convert($convertowords);
	}
	if($decimal == 00)
	{
	 $strdecimal1 = 'Zero';
	}
	if ($decimal <= 19 && $decimal ==1)
	{
		$strdecimal1 = singlenumber_convert($decimal);
	}
	
	if ($decimal > 19)
	{
		$strdecimal1 = doublenumber_convert($decimal);
	}
	
	if ($strdecimal1 != '')
	{
		//$strdecimal1 = ' - Paise '.$strdecimal1;
		$strdecimal1 = ' - '.$strdecimal1;
	}
	
	
	$convertedstring = $strwords1.$strwords2.$strwords3.$strwords4.$strwords5.$strwords6.$strwords7.$strdecimal1.' '.'Cents Only';
	//if ($convertedstring != '') $convertedstring = 'Rupees '.$convertedstring;
	if ($convertedstring != '') $convertedstring = $convertedstring;
	
	//echo $convertedstring;
return $convertedstring;
}

//$varnumber = $_REQUEST[number];
//echo covert_currency_to_words($varnumber); //function call


//Million Separator 

    function covert_currency_to_words($amt) {
	$amt = str_replace(',', '', $amt);
       
           /* echo '' . number_format($amt, 0, '.', ',') . '';*/
			$decimal = explode('.',$amt);
			$amt = $decimal[0];
			$sign = $amt > 0 ? '' : '';
			if(isset($decimal[1])){ $decimal1 = $decimal[1]; } else { $decimal1 = '00';}
			$decimallen = strlen($decimal1);
			if($decimallen==1)
			{
			$decimal1=$decimal1.'0';
			}
			$decimal11 = substr($decimal1,0,1);
			
			if($decimal11=='0')
			{
				$sign1 = $decimal11 > 1 ? '' : ' ';
				$decimals11 = $sign1 .toQuadrillions($decimal11);
				$decimal111= substr($decimal1,1,2);	
				$sign11 = $decimal111 > 1 ? '' : ' ';		
				$decimals111 = $sign11 .toQuadrillions($decimal111);
				$decimals = $decimals11.' '.$decimals111;
				if($decimal1=='00')
				{
				$decimals = 'Zero ';
				}
			}
			else
			{
				$sign1 = $decimal1 > 1 ? '' : 'Zero ';			
				$decimals = $sign1 .toQuadrillions($decimal1);			
			}
					
				$amount = $sign . toQuadrillions($amt);
				return $amount.'-'.$decimals.' Cents Only';
       
    }
 
    function toOnes($amt) {
        $words = array(
            0 => 'Zero',
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six',
            7 => 'Seven',
            8 => 'Eight',
            9 => 'Nine'
        );
 
        if ($amt >= 0 && $amt < 10)
            return $words[$amt];
        
    }
 
    function toTens($amt) { // handles 10 - 99
        $firstDigit = intval($amt / 10);
        $remainder = $amt % 10;
 
        if ($firstDigit == 1) {
            $words = array(
                0 => 'Ten',
                1 => 'Eleven',
                2 => 'Twelve',
                3 => 'Thirteen',
                4 => 'Fourteen',
                5 => 'Fifteen',
                6 => 'Sixteen',
                7 => 'Seventeen',
                8 => 'Eighteen',
                9 => 'Nineteen'
            );
 
            return $words[$remainder];
        } else if ($firstDigit >= 2 && $firstDigit <= 9) {
            $words = array(
                2 => 'Twenty',
                3 => 'Thirty',
                4 => 'Fourty',
                5 => 'Fifty',
                6 => 'Sixty',
                7 => 'Seventy',
                8 => 'Eighty',
                9 => 'Ninety'
            );
 
            $rest = $remainder == 0 ? '' : toOnes($remainder);
            return $words[$firstDigit] . ' ' . $rest;
        }
        else
            return toOnes($amt);
    }
 
    function toHundreds($amt) {
        $ones = intval($amt / 100);
        $remainder = $amt % 100;
 
        if ($ones >= 1 && $ones < 10) {
            $rest = $remainder == 0 ? '' : toTens($remainder);
            return toOnes($ones) . ' Hundred ' . $rest;
        }
        else
            return toTens($amt);
    }
 
    function toThousands($amt) {
        $hundreds = intval($amt / 1000);
        $remainder = $amt % 1000;
 
        if ($hundreds >= 1 && $hundreds < 1000) {
            $rest = $remainder == 0 ? '' : toHundreds($remainder);
            return toHundreds($hundreds) . ' Thousand ' . $rest;
        }
        else
            return toHundreds($amt);
    }
 
    function toMillions($amt) {
        $hundreds = intval($amt / pow(1000, 2));
        $remainder = $amt % pow(1000, 2);
 
        if ($hundreds >= 1 && $hundreds < 1000) {
            $rest = $remainder == 0 ? '' : toThousands($remainder);
            return toHundreds($hundreds) . ' Million ' . $rest;
        }
        else
            return toThousands($amt);
    }
 
    function toBillions($amt) {
        $hundreds = intval($amt / pow(1000, 3));
        /* Note:taking the modulos results in a negative value, but
          this seems to work pretty fine */
 
        $remainder = $amt - $hundreds * pow(1000, 3);
 
        if ($hundreds >= 1 && $hundreds < 1000) {
            $rest = $remainder == 0 ? '' : $this->toMillions($remainder);
            return toHundreds($hundreds) . ' Billion ' . $rest;
        }
        else
            return toMillions($amt);
    }
 
    function toTrillions($amt) {
        $hundreds = intval($amt / pow(1000, 4));
        $remainder = $amt - $hundreds * pow(1000, 4);
 
        if ($hundreds >= 1 && $hundreds < 1000) {
            $rest = $remainder == 0 ? '' : $this->toBillions($remainder);
            return toHundreds($hundreds) . ' Trillion ' . $rest;
        }
        else
            return toBillions($amt);
    }
 
    function toQuadrillions($amt) {
        $hundreds = intval($amt / pow(1000, 5));
        $remainder = $amt - $hundreds * pow(1000, 5);
 
        if ($hundreds >= 1 && $hundreds < 1000) {
            $rest = $remainder == 0 ? '' : $this->toTrillions($remainder);
            return toHundreds($hundreds) . ' Quadrillion ' . $rest;
        }
        else
            return toTrillions($amt);
    }
	
	
 

?>