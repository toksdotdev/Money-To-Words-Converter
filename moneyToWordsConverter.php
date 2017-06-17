<?php
  /**
  * Coverts a money value to senetence
  * Author: TOCHUKWU NKEMDILIM
  * Date: 11:22am June-17-2017
  *
  * USAGE:
  * MoneyToWordsConverter converter = new MoneyToWordsConverter(87472482348, "naira");
  * echo (converter.Convert());
  *
  * TO THE GLORY OF CHRIST JESUS
  */
 
  class MoneyToWordsConverter
  {
    protected $moneyInDigit;
    protected $currency;


    function __construct($moneyDigit, $currency)
    {
      $this->moneyInDigit = $moneyDigit;
      $this->currency = $currency;
    }


    /**
     * Performs the conversion of the given movey value from digit to words
     * @return [string]                  [converted sentence]
     */
    public function Convert()
    {
      try
      {
        //makes string a round divisor of three at the end by adding zero to the initial numbers
        $this->moneyInDigit = $this->MakeStringDivisibleBy3(strval($this->moneyInDigit));

        return ucfirst(strtolower($this->GenerateSentence($this->moneyInDigit)));
      }
      catch(Exception $ex)
      {
        throw new Exception("Invalid inputs");
      } 
    }


    /**
     * If the length of the money is not divisible by 3, 
     * make it divisible by 3 by adding zero's to make it divisible by 3
     * @param  [type] $stringOfNumbers [money value to check]
     * @return [string]                  [money value divisible by 3]
     */
    private function MakeStringDivisibleBy3($stringOfNumbers)
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
     * Change the currency for money value
     * @param [string] $currency [currency in word e.g. naira, dollar, pounds, yens etc.]
     */
    public function ChangeCurrency($currency)
    {
      $this->currency = $currency;
    }

    /**
     * This does the whole work of converting the money value whose
     * length that has been made divisible by 3 into words
     * [e.g. 003,472,747  ; 045,532,453]
     * @param  [string] $moneyValueInString [money value to convert to words]
     * @return [string]                     [the english sentence of the corresponding money value ]
     */
    private function GenerateSentence($moneyValueInString)
    {
      $subArrayHolder = ($this->SplitToThree($moneyValueInString));
      $notYetDoneHowManyTimes = count($subArrayHolder);
      $mainText = "";

      $temp = $notYetDoneHowManyTimes;
      // echo var_dump($subArrayHolder);
      

      for ($i=0; $i < $temp; $i++) { 

        //picks the first group of the money from the front
        $idleHolder = $subArrayHolder[$i];

        for ($j = 0; $j < 2; $j++) { 
          if ($j == 0) {
            if (!($idleHolder[$j] == 0)) {
              $mainText .= str_replace(" and ", ", ", ($this->ConvertFirstOrLastDigit($idleHolder[$j])) );

              if (($idleHolder[$j + 1] == 0) && !($i == (count($subArrayHolder) - 2))) {
                $mainText .= " hundred";
              }
              else
              {
                $mainText .= " hundred";
              }
            }            
          } 
          elseif ($j == 1) {
            if (!($idleHolder[$j] == 0)) {
              
              if (($idleHolder[$j] == 1)) {
                $mainText .= ($this->ConvertMiddleDigitWith_1(($idleHolder[$j] . $idleHolder[($j + 1)])));

                //add billion | million | thousand etc
                $mainText .= " " . ($this->ConvertTo_Trill_Mill_Hund_Thou($notYetDoneHowManyTimes));
              }
              else { //not number 1 digit
                $mainText .= ($this->ConvertTensForNon_1_MiddleDigit($idleHolder[$j]));
                
                if (($i == ($temp - 2)) && ($subArrayHolder[$i][2] == 0)) {
                  $mainText .= ($this->ConvertFirstOrLastDigit($idleHolder[$j + 1]));
                }
                else
                {
                  if ($idleHolder[$j + 1] == 0) {
                    $mainText .= ($this->ConvertFirstOrLastDigit($idleHolder[$j + 1]));  
                  }
                  else
                  {
                    $mainText .=  "-" . ($this->ConvertFirstOrLastDigit($idleHolder[$j + 1]));
                  }
                }

                //add billion | million | thousand etc
                if (($i == ($temp - 2))) {
                  $mainText .= " " . ($this->ConvertTo_Trill_Mill_Hund_Thou($notYetDoneHowManyTimes)) . ",  ";
                }
                else
                {
                  if ((($idleHolder[$j + 1] == 0) && ($notYetDoneHowManyTimes == 1)) ||
                      ($notYetDoneHowManyTimes == 1)) {
                    $mainText .= " " . ($this->ConvertTo_Trill_Mill_Hund_Thou($notYetDoneHowManyTimes)) . " ";
                  }
                  else
                  {
                    $mainText .= " " . ($this->ConvertTo_Trill_Mill_Hund_Thou($notYetDoneHowManyTimes)) . ", ";
                  }
                }
              }
            }
            else
            {
              $mainText .= ($this->ConvertFirstOrLastDigit(($idleHolder[$j + 1])));
              $mainText .= " " . ($this->ConvertTo_Trill_Mill_Hund_Thou($notYetDoneHowManyTimes)) . ", ";
            }
          }
        }
        $notYetDoneHowManyTimes -= 1;
      }

      $mainText = $this->CorrectSentence($mainText);

      return $mainText;
    }


    /**
     * Removes unecessary characters and literals that make sentence incorrect
     * @param [string] $mainText [Corrected sentence of the money value converted]
     */
    private function CorrectSentence($mainText)
    {
      $mainText .= "{$this->currency} only";
      
      $mainText = str_replace("and  , ", "", $mainText);
      $mainText = str_replace("- and ", "-", $mainText);
      $mainText = str_replace(",  and", ",", $mainText);
      $mainText = str_replace(", ,", ",", $mainText);
      $mainText = str_replace(",  ,", ",", $mainText);
      $mainText = str_replace(", {$this->currency} only", "{$this->currency} only", $mainText);

      if(substr($mainText, 0, 5) == " and ")
      {
        $mainText = substr($mainText, 4);
      }

      if (substr($mainText, 0, 2) == ", ") {
        $mainText = substr($mainText, 1);
      }

      //REMOVES LAST TRAILING SPACE AT THE BEGINNING OF THE SENTENCE
      if ($mainText[0] = " ") {
        $mainText = substr($mainText, 1);
      }
      
      return $mainText;
    }

    /**
     * Split an already divisible by 3 string to arrays of size 3 each
     * @param  [string] $stringOfNumbers [string to split]
     * @return [array]                  [array of sets of 3 digits each]
     */
    function SplitToThree($stringOfNumbers)
    {
      $size = strlen($stringOfNumbers);
      $subArrayHolder = array();

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
    private function ConvertFirstOrLastDigit($digit)
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

      return ($words == "") ? $words : (" and " . $words);
    }


    /**
     * Converts the middle(2nd) digit [less than 20] in the size 3 array to its corresponding tens as word
     * @param  [integer] $oneDigits [digit to convert to word]
     * @return [string]        [digit in its tens word]
     */
    private function ConvertMiddleDigitWith_1($oneDigits)
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

      return ($words == "") ? $words : (" and " . $words);
    }


    /**
     * Converts the middle(2nd) digit [greate than or equal to 20] in the 3-size array to its corresponding tens as word
     * @param  [integer] $digit [digit to convert to word]
     * @return [string]        [digit in word]
     */
    private function ConvertTensForNon_1_MiddleDigit($digit)
    {
      $words = "";

      switch ($digit) {
        case '0':
          $words = "";
          break;
        case '2':
          $words = "twenty";
          break;
        
        case '3':
          $words = "thirty";
          break;

        case '4':
          $words = "forty";
          break;

        case '5':
          $words = "fifty";
          break;

        case '6':
          $words = "sixty";
          break;

        case '7':
          $words = "seventy";
          break;

        case '8':
          $words = "eighty";
          break;

        case '9':
          $words = "ninety";
          break;

        default:
          $words = "";
          break;
      }

      return ($words == "") ? $words : (" and " . $words);
    }

    
    /**
     * Converts only the first digit in the 3-size array to its corresponding word
     * 
     * [try this only at first  digit]
     * @param  [integer] $whichBlock [digit to convert to word]
     * @return [string]        [digit in word]
     */
    private function ConvertTo_Trill_Mill_Hund_Thou($whichBlock)
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
          throw new Exception("Invalid Input");
          break;
      }
    
      return $words;
    }
    
  }
?>