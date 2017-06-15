<?php 
		function mainer($moneyValue)
		{
			//makes string a round divisor of three at the end by adding zeroto the initial numbers
			$moneyValue = (make_string_Divisor_Of_three($moneyValue));

			echo "<b><a style=\"color:red\">" . (generate_money_number($moneyValue)) . "</a></b>";
		}

		function generate_money_number($moneyValueInString)
		{
			$subArrayHolder = (split_to_three($moneyValueInString));
			$notYetDoneHowManyTimes = count($subArrayHolder);
			$mainText ="";

				$temp = $notYetDoneHowManyTimes;
			for ($i=0; $i < $temp; $i++) { 
				//picks the first group of the money from the front
				$idleHolder = $subArrayHolder[$i];

				for ($j=0; $j < 2; $j++) { 
					if ($j == 0) {
						if (!($idleHolder[$j] == 0)) {
							$mainText .= ", " . (first_and_last_digit($idleHolder[$j]));
							$mainText .= " Hundred and ";
						}
					}elseif ($j == 1) {
						if (!($idleHolder[$j] == 0)) {
							if (($idleHolder[$j] == 1)) {
								$mainText .= (middle_one_digit(($idleHolder[$j] . $idleHolder[($j + 1)])));

								//add hundred_mill_thousand
								$mainText .= " " . (hundreds_mill_thousands($notYetDoneHowManyTimes)) . ", ";
							}else { //not number 1 digit
								$mainText .= (tens_for_none_one_second_digit($idleHolder[$j]));

								$mainText .=  "-" . (first_and_last_digit($idleHolder[$j + 1]));

								//add hundred_mill_thousand
								$mainText .= " " . (hundreds_mill_thousands($notYetDoneHowManyTimes));
							}
						}
					}
				}
				$notYetDoneHowManyTimes -= 1;
			}
			$mainText .= " naira only";

			return $mainText;
		}

		function make_string_Divisor_Of_three($stringOfNumbers)
		{
				$size = strlen($stringOfNumbers);
				
				//this if statement ensure that the figure is a round divisor of three
				if (!(($size % 3) == 0)) {
					$holdRemainingSize = (3 -($size % 3));//return remaining
					$temporaryString = $stringOfNumbers;
					$stringOfNumbers = "";

					for ($i=0; $i < $holdRemainingSize; $i++) { 
						$stringOfNumbers .= '0';
					}
					$stringOfNumbers .= $temporaryString;
				}
				return $stringOfNumbers;
		}

		function split_to_three($stringOfNumbers)
		{
			$size = strlen($stringOfNumbers);
			$subArrayHolder = array();
			// $howManyGroups = (($size - ($size % 3)) / 3); //didnt know how to do integer division in php, so did this instead
			// 	echo "$howManyGroups";

			for ($i=0; $i < $size; $i += 3) {
				$a = "";
				$b = "";
				$c = "";
				if ((!empty($stringOfNumbers[$i])) || ($stringOfNumbers[$i] == 0)) {
					$a = $stringOfNumbers[$i];
				}

				if ((!empty($stringOfNumbers[$i + 1])) || ($stringOfNumbers[$i + 1] == 0)) {
					$b = $stringOfNumbers[$i + 1];
				}

				if ((!empty($stringOfNumbers[$i + 2])) || ($stringOfNumbers[$i + 2] == 0)) {
					$c = $stringOfNumbers[$i + 2];
				}
				array_push($subArrayHolder, array(intval("{$a}"), intval("{$b}"), intval("{$c}")));
			}
			return $subArrayHolder;
		}

		function first_and_last_digit($digit)
		{

			$words = "";

			switch ($digit) {
				case '0':
					$words = "";
					break;
				case '1':
					$words = "one";
					break;

				case '2':
					$words = "two";
					break;

				case '3':
					$words = "three";
					break;

				case '4':
					$words = "four";
					break;

				case '5':
					$words = "five";
					break;

				case '6':
					$words = "six";
					break;

				case '7':
					$words = "seven";
					break;

				case '8':
					$words = "eight";
					break;

				case '9':
					$words = "nine";
					break;
				default:
					$words = "";
					break;
			}

			return $words;
		}

		function middle_one_digit($oneDigits)
		{
			$words = "";

			switch ($oneDigits) {
				case '10':
					$words = "ten";
					break;
				
				case '11':
					$words = "eleven";
					break;

				case '12':
					$words = "twelve";
					break;

				case '13':
					$words = "thirteen";
					break;

				case '14':
					$words = "fourteen";
					break;

				case '15':
					$words = "fifteen";
					break;

				case '16':
					$words = "sixteen";
					break;

				case '17':
					$words = "seventeen";
					break;

				case '18':
					$words = "eighteen";
					break;

				case '19':
					$words = "nineteen";
					break;

				default:
					$words = "";
					break;
			}

			return $words;
		}

		function tens_for_none_one_second_digit($digit)
		{
			$words = "";

			switch ($digit) {
				case '0':
					$words = "";
					break;
				case '2':
					$words = "Twenty";
					break;
				
				case '3':
					$words = "Thirty";
					break;

				case '4':
					$words = "Forty";
					break;

				case '5':
					$words = "Fifty";
					break;

				case '6':
					$words = "Sixty";
					break;

				case '7':
					$words = "Seventy";
					break;

				case '8':
					$words = "Eighty";
					break;

				case '9':
					$words = "Ninety";
					break;

				default:
					$words = "";
					break;
			}

			return $words;
		}

		//try this only at first  digit
		function hundreds_mill_thousands($whichBlock)
		{
			$words = "";

			switch ($whichBlock) {
				case '1':
					$words = "";
					break;
				case '2':
					$words = "thousand";
					break;

				case '3':
					$words = "million";
					break;

				case '4':
					$words = "billion";
					break;

				case '5':
					$words = "zillion";
					break;
				default:
					$words = "Not yet defined this length";
					break;
			}

			return $words;
		} //contains necessary methods/functions
?>