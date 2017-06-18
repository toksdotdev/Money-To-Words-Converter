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
  * LET ALL THE GLORY OF CHRIST JESUS
  * 
  */
 
  namespace MoneyToWords;
  
  use Stichoza\GoogleTranslate\TranslateClient;

  class MoneyToWordsConverter
  {
    /**
     * Money to convert in digit
     * 
     * [ A list of numeric systems can be found at: https://en.wikipedia.org/wiki/List_of_numeral_systems ]
     * 
     * @var [any numeric system value e.g. greek, babylonians, etc]
     */
    protected $moneyInDigit;


    /**
     * The currency to state such money value
     * @var [string]
     */
    protected $currency;


    /**
     * The language of the money value (numeral) inserted
     * @var [string]
     */
    protected $languageFrom;


    /**
     * Language to convert money value into
     * @var [string]
     */
    protected $languageTo;


    /**
     * The google translator object
     * @var [Object]
     */
    protected $translator;



    /**
     * [Initialises the MoneyToWordsConverter object]
     * @param [numeric] $moneyDigit [Money value of any language, in which should be converted to words ]
     * @param [string] $currency   [currency to convert money to]
     * @param string $languageTo [language to convert money in words to]
     */
    function __construct($moneyDigit, $currency, $languageTo = 'en')
    {
      $this->moneyInDigit = $moneyDigit;
      $this->currency = $currency;
      $this->languageTo = $languageTo;
      $this->translator = new TranslateClient(null, $languageTo);
    }




    /**
     * Detects the language of the just converted value
     */
    public function DetectInputLanguage()
    {
      //detect digit language
      return $this->translator->getLastDetectedSource();
    }



    /**
     * Checks if the input specified is in greek numeric system [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
     */
    private function IsLanguageEnglish()
    {
      $numbers = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];

      try
      {
        //detect digit language and translate
        if ( in_array(strval($this->moneyInDigit[0]), $numbers) ) {
          
          if (!($this->moneyInDigit == 'm/[^a-zA-Z0-9]/')) {

            //is english
            $this->laguageFrom = 'en';

            return true;
          }
        }

        return false;
      }
      catch(Exception $ex)
      {
        return false;
      }
    }



    /**
     * Translates the money value to the current language target
     */
    private function TranslateMoneyValueToEnglish()
    {
      //set english as the language to convert into
      $this->TranslateMoneyValue('en');
    }




    /**
     * Translates the money input to any language
     * @param [sting] $language [language tot convert to]
     */
    private function TranslateMoneyValue($language)
    {
      try
      {
        //set translation language to users choice
        $this->translator->setTarget($language);

        //sets the moneyDigit to the english version of the [foreign-language money-value] entered
        $this->moneyInDigit = $this->translator->translate($this->moneyInDigit);

        //reset translator back to original language set by user
        $this->translator->setTarget($this->languageTo);
      }
      catch (Exception $ex)
      {
        throw new Exception("Error translating. Please insert a valid input");
      }
    }




    /**
     * sets the language to translate into, to users choice
     * @param [string] $languageTo [language to translate to]
     */
    public function SetLanguage($languageTo)
    {
      $this->$languageTo = $languageTo;
    }




    /**
     * Performs the conversion of the given movey value from digit to words
     * @return [string]                  [converted sentence]
     */
    public function Convert()
    {
      //check if input is in english numeric system
      if(!$this->IsLanguageEnglish())
      {
        //Translate to greek numeric system [0, 1, 2, 3, 4, 5, 6, 7, 8, 9s]
        $this->TranslateMoneyValue('el');
      }

      //convert digit entered[already in english numeric system]
      try
      {

        //makes string a round divisor of three at the end by adding zero to the initial numbers
        $this->moneyInDigit = $this->MakeStringDivisibleBy3(strval($this->moneyInDigit));
        

        //convert to words
        $moneyValueInWords = ucfirst(strtolower($this->GenerateSentence($this->moneyInDigit)));
        
        
        //Final Translation is not english, return translation version
        if (!($this->languageTo == 'en')) {
          
          //sets the language to translate to users input, to ensure no un -selected translation is performed
          $this->SetLanguage($this->languageTo);

          //translate into the language user specifies
          return $this->translator->translate($moneyValueInWords);
        }
        
        //return english instead
        return $moneyValueInWords;
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
     * Set a new currency for money value
     * @param [string] $currency [currency in word e.g. naira, dollar, pounds, yens etc.]
     */
    public function SetCurrency($currency)
    {
      $this->currency = $currency;
    }



    /**
     * Set a new money value to convert
     * @param [numeric] $moneyValue [money value to convert]
     */
    public function SetMoneyValue($moneyValue)
    {
        $this->moneyInDigit = $moneyValue;
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