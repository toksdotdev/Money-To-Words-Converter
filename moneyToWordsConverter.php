<?php
  /**
  * Coverts a money value to senetence
  * Author: TOCHUKWU NKEMDILIM
  * Date: 11:22am June-17-2017
  *
  * 6,428,478,474,817,427,842
  */
  class MoneyToWordsConverter
  {
    protected $moneyInDigit;

    function __construct($moneyDigit)
    {
      $this->moneyInDigit = $moneyDigit;
    }

    public function Convert()
    {
      //makes string a round divisor of three at the end by adding zero to the initial numbers
      $this->moneyInDigit = ($this->make_string_Divisor_Of_three($this->moneyInDigit));

      return ucwords(strtolower($this->generate_money_number($this->moneyInDigit)));
    }

    /**
     * If the length of the money is not divisible by 3, 
     * make it divisible by 3 by adding zero's to make it divisible by 3
     * @param  [type] $stringOfNumbers [money value to check]
     * @return [string]                  [money value divisible by 3]
     */
    private function make_string_Divisor_Of_three($stringOfNumbers)
    {
        $size = strlen($stringOfNumbers);
        
        //this if statement ensure that the figure is a round divisor of three
        if (!(($size % 3) == 0)) {
          $holdRemainingSize = (3 - ($size % 3));//return remaining
          $temporaryString = $stringOfNumbers;
          $stringOfNumbers = "";

          for ($i = 0; $i < $holdRemainingSize; $i++) { 
            $stringOfNumbers .= '0';
          }

          $stringOfNumbers .= $temporaryString;
        }
        return $stringOfNumbers;
    }



    /**
     * This does the whole work of converting the money value whose
     * length that has been made divisible by 3 into words
     * [e.g. 003,472,747  ; 045,532,453]
     * @param  [string] $moneyValueInString [money value to convert to words]
     * @return [string]                     [the english sentence of the corresponding money value ]
     */
    private function generate_money_number($moneyValueInString)
    {
      $subArrayHolder = ($this->split_to_three($moneyValueInString));
      $notYetDoneHowManyTimes = count($subArrayHolder);
      $mainText = "";

      $temp = $notYetDoneHowManyTimes;

      for ($i=0; $i < $temp; $i++) { 

        //picks the first group of the money from the front
        $idleHolder = $subArrayHolder[$i];

        for ($j = 0; $j < 2; $j++) { 
          if ($j == 0) {
            if (!($idleHolder[$j] == 0)) {
              $mainText .= ", " . ($this->first_and_last_digit($idleHolder[$j]));
              $mainText .= " Hundred and ";
            }

          } elseif ($j == 1) {
            if (!($idleHolder[$j] == 0)) {
              
              if (($idleHolder[$j] == 1)) {
                $mainText .= ($this->middle_one_digit(($idleHolder[$j] . $idleHolder[($j + 1)])));

                //add billion | million | thousand etc
                $mainText .= " " . ($this->hundreds_mill_thousands($notYetDoneHowManyTimes)) . ", ";
              }
              else { //not number 1 digit
                $mainText .= ($this->tens_for_none_one_second_digit($idleHolder[$j]));

                $mainText .=  "-" . ($this->first_and_last_digit($idleHolder[$j + 1]));

                //add billion | million | thousand etc
                $mainText .= " " . ($this->hundreds_mill_thousands($notYetDoneHowManyTimes));
              }
            }
          }
        }

        $notYetDoneHowManyTimes -= 1;
      }

      $mainText .= " naira only";

      return $mainText;
    }


    /**
     * Split an already divisible by 3 string to arrays of size 3 each
     * @param  [string] $stringOfNumbers [string to split]
     * @return [array]                  [array of sets of 3 digits each]
     */
    function split_to_three($stringOfNumbers)
    {
      $size = strlen($stringOfNumbers);
      $subArrayHolder = array();
      // $howManyGroups = (($size - ($size % 3)) / 3); //didnt know how to do integer division in php, so did this instead
      //  echo "$howManyGroups";

      for ($i = 0; $i < $size; $i += 3) {
        $firstDigit = "";
        $secondDigit = "";
        $thirdDigit = "";

        if ((!empty($stringOfNumbers[$i])) || ($stringOfNumbers[$i] == 0)) {
          $firstDigit = $stringOfNumbers[$i];
        }

        if ((!empty($stringOfNumbers[$i + 1])) || ($stringOfNumbers[$i + 1] == 0)) {
          $secondDigit = $stringOfNumbers[$i + 1];
        }

        if ((!empty($stringOfNumbers[$i + 2])) || ($stringOfNumbers[$i + 2] == 0)) {
          $thirdDigit = $stringOfNumbers[$i + 2];
        }
        array_push($subArrayHolder, array(intval("{$firstDigit}"), intval("{$secondDigit}"), intval("{$thirdDigit}")));
      }
      return $subArrayHolder;
    }

    /**
     * Converts every first and last digit in the size 3 array to their corresponding word
     * @param  [integer] $digit [digit to convert to word]
     * @return [string]        [digit in word]
     */
    private function first_and_last_digit($digit)
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


    /**
     * Converts the middle(2nd) digit [less than 20] in the size 3 array to its corresponding tens as word
     * @param  [integer] $oneDigits [digit to convert to word]
     * @return [string]        [digit in its tens word]
     */
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


    /**
     * Converts the middle(2nd) digit [greate than or equal to 20] in the 3-size array to its corresponding tens as word
     * @param  [integer] $digit [digit to convert to word]
     * @return [string]        [digit in word]
     */
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

    
    /**
     * Converts only the first digit in the 3-size array to its corresponding word\
     * 
     * [try this only at first  digit]
     * @param  [integer] $whichBlock [digit to convert to word]
     * @return [string]        [digit in word]
     */
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
          $words = "trillion";
          break;
        default:
          $words = "Not yet defined this length";
          break;
      }

      return $words;
    }
  }
